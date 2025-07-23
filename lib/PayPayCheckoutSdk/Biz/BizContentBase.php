<?php

namespace PayPayCheckoutSdk\Biz;

abstract class BizContentBase
{
    protected $map = [];
    abstract static function apiService();

    public function parseJson() {
        return json_encode($this->map);
    }
}