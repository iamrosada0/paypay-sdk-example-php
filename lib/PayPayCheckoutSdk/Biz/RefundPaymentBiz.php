<?php

namespace PayPayCheckoutSdk\Biz;

class RefundPaymentBiz extends BizContentBase
{

    static function apiService()
    {
        return "trade_refund";
    }

    public function getOutTradeNo() {
        return $this->map['out_trade_no'];
    }

    public function setOutTradeNo($value) {
        $this->map['out_trade_no'] = $value;
    }

    public function setOrigOutTradeNo($value) {
        $this->map['orig_out_trade_no'] = $value;
    }

    public function getOrigOutTradeNo() {
        return $this->map['orig_out_trade_no'];
    }

    public function setRefundAmount($value) {
        $this->map['refund_amount'] = $value;
    }

    public function getRefundAmount() {
        return $this->map['refund_amount'];
    }
}