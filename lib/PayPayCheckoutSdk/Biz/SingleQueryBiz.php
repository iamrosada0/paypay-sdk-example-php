<?php

namespace PayPayCheckoutSdk\Biz;

class SingleQueryBiz extends BizContentBase
{

    static function apiService()
    {
        return "trade_query";
    }

    public function getOutTradeNo() {
        return $this->map['out_trade_no'];
    }

    public function setOutTradeNo($value) {
        $this->map['out_trade_no'] = $value;
    }
}