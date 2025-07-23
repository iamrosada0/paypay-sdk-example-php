<?php
require_once dirname(__DIR__) . "/vendor/autoload.php";

use PayPayCheckoutSdk\Biz\ClosePaymentBiz;
use PayPayCheckoutSdk\Biz\CreatePaymentBiz;
use PayPayCheckoutSdk\Biz\PaymentCardBiz;
use PayPayCheckoutSdk\Biz\RefundPaymentBiz;
use PayPayCheckoutSdk\Biz\SingleQueryBiz;
use PayPayCheckoutSdk\Core\PayPayService;
use PayPayCheckoutSdk\PayPayHttp\Log;
use PayPayCheckoutSdk\Config\SandboxPayPayConfig;

class Application {

    /**
     * @var PayPayService
     */
    protected $paypayService;

    protected $dataFile = __DIR__ . DIRECTORY_SEPARATOR . "data.json";

    protected $data = [
        'order' => [],
        'refund' => [],
        'card' => []
    ];

    protected $lang = "en";

    protected $partnerId = "";

    protected $saleProductCode = "";

    protected $salePaymentCardProductCode = "";

    private $myPrivateKey = "MIIEvQIBADANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQ..."; // Replace with your actual private key

    public function __construct() {
        $this->init();
        $this->loadData();
    }

    protected function init() {
        $sandboxPayPayConfig = new SandboxPayPayConfig();
        $privateKey = "-----BEGIN PRIVATE KEY-----\n" . $this->myPrivateKey . "-----END PRIVATE KEY-----\n";
        $sandboxPayPayConfig->setLang($this->lang);
        $sandboxPayPayConfig->setPartnerId($this->partnerId);
        $sandboxPayPayConfig->setMyPrivateKey($privateKey);
        $this->paypayService = new PayPayService($sandboxPayPayConfig, new MyLogger());
    }

    protected function create() {
        $order = [];
        $order['orderId'] = $this->generalTradeNo();
        $order['amount'] = "10.00";
        $order['createTime'] = date("Y-m-d H:i:s");
        $order['status'] = "Init";

        $this->data['order'][$order['orderId']] = $order;

        $createPaymentBiz = new CreatePaymentBiz();
        $createPaymentBiz->setPayerIp("127.0.0.1");
        $createPaymentBiz->setTimeoutExpress("10m");
        $createPaymentBiz->setSaleProductCode($this->saleProductCode);
        $createPaymentBiz->setCashierType("SDK");
        $createPaymentBiz->setOutTradeNo($order['orderId']);
        $createPaymentBiz->setSubject("Demo");
        $createPaymentBiz->setCurrency("AOA");
        $createPaymentBiz->setPrice($order["amount"]);
        $createPaymentBiz->setQuantity("1");
        $createPaymentBiz->setTotalAmount($order['amount']);
        $createPaymentBiz->setPayeeIdentity($this->partnerId);
        try {
            $res = $this->paypayService->makeRequest($createPaymentBiz);
            echo $res["dynamic_link"];
        } catch (Exception $ex) {
            echo var_dump($ex);
        }
    }

    protected function close() {
        $id = $_GET["id"];

        $closePaymentBiz = new ClosePaymentBiz();
        $closePaymentBiz->setOutTradeNo($id);
        try {
            $this->paypayService->makeRequest($closePaymentBiz);
            echo "true";
        } catch (Exception $ex) {
            echo var_dump($ex);
        }
    }

    protected function refund() {
        $id = $_GET["id"];
        $order = $this->data['order'][$id];
        $refund = [
            "refundId" => $this->generalTradeNo(),
            "amount" => $order['amount'],
            'orderId' => $order['orderId'],
            'status' => 'Init'
        ];
        $this->data['refund'][$refund['refundId']] = $refund;

        $refundPaymentBiz = new RefundPaymentBiz();
        $refundPaymentBiz->setOrigOutTradeNo($refund['orderId']);
        $refundPaymentBiz->setOutTradeNo($refund['refundId']);
        $refundPaymentBiz->setRefundAmount($refund['amount']);
        try {
            $this->paypayService->makeRequest($refundPaymentBiz);
            echo "true";
        } catch (Exception $ex) {
            echo var_dump($ex);
        }
    }


    protected function card() {
        $card = [
            'paymentId' => $this->generalTradeNo(),
            'amount' => '10.00',
            'status' => 'Init',
            'iban' => 'AO06005500000000000000001',
            'bankName' => 'BPA',
            'accountName' => 'Test'
        ];
        $this->data['card'][$card['paymentId']] = $card;

        $paymentCardBiz = new PaymentCardBiz();
        $paymentCardBiz->setAmount($card['amount']);
        $paymentCardBiz->setBankCardNo($card['iban']);
        $paymentCardBiz->setMemo("Demo");
        $paymentCardBiz->setCurrency("AOA");
        $paymentCardBiz->setSaleProductCode($this->salePaymentCardProductCode);
        $paymentCardBiz->setBankCode($card['bankName']);
        $paymentCardBiz->setBankAccountName($card['accountName']);
        $paymentCardBiz->setOutTradeNo($card['paymentId']);
        $paymentCardBiz->setPayerIdentity($this->partnerId);
        try {
            $this->paypayService->makeRequest($paymentCardBiz);
            echo "true";
        } catch (Exception $ex) {
            echo var_dump($ex);
        }
    }

    protected function fetch() {
        $id = $_GET["id"];

        $singleQueryBiz = new SingleQueryBiz();
        $singleQueryBiz->setOutTradeNo($id);
        try {
            $res = $this->paypayService->makeRequest($singleQueryBiz);
            echo json_encode($res);
        } catch (Exception $ex) {
            echo var_dump($ex);
        }
    }

    protected function queryList() {
        $arr = [];
        foreach ($this->data as $k => $v) {
            $arr[$k] = array_values($v);
        }
        echo json_encode($arr);
    }

    protected function ipn() {
        $str = file_get_contents("php://input");
        $notify = $this->paypayService->handleNotify($str);
        if (is_null($notify)) {
            echo "success";
            return;
        }
        if ("TRADE_SUCCESS" == $notify["status"]) {
            $id = $notify['out_trade_no'];
            $this->data['order'][$id]['status'] = "Paid";
        } else if ("TRADE_FINISHED" == $notify["status"]) {

        } else if ("TRADE_CLOSED" == $notify['status']) {
            $id = $notify['out_trade_no'];
            $this->data['order'][$id]['status'] = "Closed";
        } else if ("REFUND_SUCCESS" == $notify['status']) {
            $id = $notify['out_trade_no'];
            $this->data['refund'][$id]['status'] = "Refund";
            $this->data['order'][$this->data['refund'][$id]['orderId']]["status"] = "Refund";
        } else if ("REFUND_FAIL" == $notify['status']) {
            $id = $notify['out_trade_no'];
            $this->data['refund'][$id]['status'] = "Fail";
        } else if ("TRANSFER_SUCCESS" == $notify['status']) {
            $id = $notify['out_trade_no'];
            $this->data['card'][$id]['status'] = "Success";
        } else if ("TRANSFER_FAIL" == $notify['status']) {
            $id = $notify['out_trade_no'];
            $this->data['card'][$id]['status'] = "Fail";
        } else if ("RETURN_TICKET" == $notify['status']) {
            $id = $notify['out_trade_no'];
            $this->data['card'][$id]['status'] = "Return";
        }
        echo "success";
    }

    protected function index() {
        echo @file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "index.html");
    }


    private function generalTradeNo() {
        return time().rand(1000, 9999);
    }

    private function loadData() {
        $json = @file_get_contents($this->dataFile);
        if (!($json == null || $json == "")) {
            $this->data = json_decode($json, true);
        }
    }

    private function saveData() {
        @file_put_contents($this->dataFile, json_encode($this->data));
    }

    public function run() {
        $route = trim($_SERVER["REQUEST_URI"], "/");
        list($route) = explode("?", $route);
        if ($route == "ipn") {
            $this->ipn();
        } else if ($route == "create") {
            $this->create();
        } else if ($route == "close") {
            $this->close();
        } else if ($route == "refund") {
            $this->refund();
        } else if ($route == "list") {
            $this->queryList();
        } else if ($route == "fetch") {
            $this->fetch();
        } else if ($route == "card") {
            $this->card();
        } else {
            header("Content-Type: text/html");
            $this->index();
        }
        $this->saveData();
    }
}

class MyLogger extends Log {
    private $file;

    public function __construct() {
        $this->file = __DIR__ . '/paypay.log';
    }

    public function log($log)
    {
        file_put_contents($this->file, $log . "\n", FILE_APPEND);
    }
}

$application = new Application();
$application->run();