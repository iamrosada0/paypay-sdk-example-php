<?php

namespace PayPayCheckoutSdk\Biz;

class PaymentCardBiz extends BizContentBase
{

    public function __construct()
    {
        $this->setPayerIdentityType('1');
        $this->setPayProductCode('11');
    }

    static function apiService()
    {
        return "transfer_to_card";
    }

    public function getOutTradeNo() {
        return $this->map['out_trade_no'];
    }

    public function setOutTradeNo($value) {
        $this->map['out_trade_no'] = $value;
    }

    public function getPayerIdentityType() {
        return $this->map['payer_identity_type'];
    }

    public function setPayerIdentityType($value) {
        $this->map['payer_identity_type'] = $value;
    }

    public function getPayerIdentity() {
        return $this->map['payer_identity'];
    }

    public function setPayerIdentity($value) {
        $this->map['payer_identity'] = $value;
    }

    public function getAmount() {
        return $this->map['amount'];
    }

    public function setAmount($value) {
        $this->map['amount'] = $value;
    }

    public function getCurrency() {
        return $this->map['currency'];
    }

    public function setCurrency($value) {
        $this->map['currency'] = $value;
    }

    public function getBankCardNo() {
        return $this->map['bank_card_no'];
    }

    public function setBankCardNo($value) {
        $this->map['bank_card_no'] = $value;
    }

    public function getBankAccountName() {
        return $this->map['bank_account_name'];
    }

    public function setBankAccountName($value) {
        $this->map['bank_account_name'] = $value;
    }

    public function getBankCode() {
        return $this->map['bank_code'];
    }

    public function setBankCode($value) {
        $this->map['bank_code'] = $value;
    }

    public function setSaleProductCode($value) {
        $this->map['sale_product_code'] = $value;
    }

    public function getSaleProductCode() {
        return $this->map['sale_product_code'];
    }

    public function setPayProductCode($value) {
        $this->map['pay_product_code'] = $value;
    }

    public function getPayProductCode() {
        return $this->map['pay_product_code'];
    }

    public function setMemo($value) {
        $this->map['memo'] = $value;
    }

    public function getMemo() {
        return $this->map['memo'];
    }
}