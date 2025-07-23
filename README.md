# PayPay-PHP-SDK
PAYPAY AO API integration document
[link>>](https://portal.paypayafrica.com/passport/apidoc/guide)

## 1. Base Config
```php
$payPayConfig = new PayPayConfig();
//your private key 
$privateKey = "-----BEGIN PRIVATE KEY-----\n" . $this->myPrivateKey . "-----END PRIVATE KEY-----\n";
$payPayConfig->setLang($this->lang);
$payPayConfig->setPartnerId($this->partnerId);
$payPayConfig->setMyPrivateKey($privateKey);
```

## 2. Create PaypayService Instance
```php
//set config and logger
$this->paypayService = new PayPayService($payPayConfig, new MyLogger());
```

## 3. Create payment
```php
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
    //handle Exception
}
```

## 4. Refund payment
```php
$refundPaymentBiz = new RefundPaymentBiz();
$refundPaymentBiz->setOrigOutTradeNo($refund['orderId']);
$refundPaymentBiz->setOutTradeNo($refund['refundId']);
$refundPaymentBiz->setRefundAmount($refund['amount']);
try {
    $this->paypayService->makeRequest($refundPaymentBiz);
    echo "true";
} catch (Exception $ex) {
    //handle Exception
}
```

## 5. Close payment
```php
$closePaymentBiz = new ClosePaymentBiz();
$closePaymentBiz->setOutTradeNo($id);
try {
    $this->paypayService->makeRequest($closePaymentBiz);
    echo "true";
} catch (Exception $ex) {
    //handle Exception
}
```

## 6. Single payment query
```php
$singleQueryBiz = new SingleQueryBiz();
$singleQueryBiz->setOutTradeNo($id);
try {
    $res = $this->paypayService->makeRequest($singleQueryBiz);
    echo json_encode($res);
} catch (Exception $ex) {
    //handle Exception
}
```

## 7. Payment to bank card
```php
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
    //handle Exception
}
```

## 8. Handle Asynchronous Notification
```php
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
```
## Run springboot Demo
- run `composer run-script demo`
- Browser access http://127.0.0.1:8080