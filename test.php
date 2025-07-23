<?php
require_once "./vendor/autoload.php";
use PayPayCheckoutSdk\Biz\CreatePaymentBiz;
use PayPayCheckoutSdk\Core\PayPayService;
use PayPayCheckoutSdk\Response\CreatePaymentResponse;

$obj = new CreatePaymentBiz();
$obj->setId(11);

$map = $obj->getMap();
$map['aa'] = 22;

echo json_encode($map);
echo json_encode($obj->getMap());

$service = new PayPayService(null);
$makeRequest = $service->makeRequest($obj);