<?php

namespace PayPayCheckoutSdk\Config;

class SandboxPayPayConfig extends PayPayConfig
{
    public function getEndPoint()
    {
        return "http://xxxxx/gateway/recv.do";
    }

}