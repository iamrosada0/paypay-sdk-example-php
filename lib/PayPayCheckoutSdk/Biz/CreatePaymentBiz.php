<?php

namespace PayPayCheckoutSdk\Biz;

class CreatePaymentBiz extends BizContentBase
{
    public static function apiService()
    {
        return "instant_trade";
    }

    public function getCashierType() {
        return $this->map['cashier_type'];
    }

    public function setCashierType($value) {
        $this->map['cashier_type'] = $value;
    }

    public function getPayerIp() {
        return $this->map['payer_ip'];
    }

    public function setPayerIp($value) {
        $this->map['payer_ip'] = $value;
    }

    public function getSaleProductCode() {
        return $this->map['sale_product_code'];
    }

    public function setSaleProductCode($value) {
        $this->map['sale_product_code'] = $value;
    }

    public function getTimeoutExpress() {
        return $this->map['timeout_express'];
    }

    public function setTimeoutExpress($value) {
        $this->map['timeout_express'] = $value;
    }

    private function getTrade($key) {
        return $this->map['trade_info'] != null ? $this->map['trade_info'][$key] : null;
    }

    private function setTrade($key, $value) {
        if (!isset($this->map['trade_info'])) {
            $this->map['trade_info'] = [];
        }
        $this->map['trade_info'][$key] = $value;
    }

    public function getOutTradeNo() {
        return $this->getTrade("out_trade_no");
    }

    public function setOutTradeNo($value) {
        $this->setTrade("out_trade_no", $value);
    }

    public function getSubject() {
        return $this->getTrade("subject");
    }

    public function setSubject($value) {
        $this->setTrade("subject", $value);
    }

    public function getCurrency() {
        return $this->getTrade("currency");
    }

    public function setCurrency($value) {
        $this->setTrade("currency", $value);
    }

    public function setPrice($value) {
        $this->setTrade("price", $value);
    }

    public function getPrice() {
        return $this->getTrade("price");
    }

    public function setQuantity($value) {
        $this->setTrade("quantity", $value);
    }

    public function getQuantity() {
        return $this->getTrade("quantity");
    }

    public function setTotalAmount($value) {
        $this->setTrade("total_amount", $value);
    }

    public function getTotalAmount() {
        return $this->getTrade("total_amount");
    }

    public function setPayeeIdentity($value) {
        $this->setTrade("payee_identity", $value);
    }

    public function getPayeeIdentity() {
        return $this->getTrade("payee_identity");
    }
}