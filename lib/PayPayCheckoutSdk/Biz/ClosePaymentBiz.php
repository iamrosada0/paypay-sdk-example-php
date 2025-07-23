<?php

namespace PayPayCheckoutSdk\Biz;

class ClosePaymentBiz extends BizContentBase
{

    static function apiService()
    {
        return "trade_close";
    }

    public function getOutTradeNo() {
        return $this->map['out_trade_no'];
    }

    public function setOutTradeNo($value) {
        $this->map['out_trade_no'] = $value;
    }
}