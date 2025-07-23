<?php

namespace PayPayCheckoutSdk\PayPayHttp;

class HttpRequest
{
    public $path;

    public $body;

    public $verb;

    public $enableSSL = true;

    public $headers;

    function __construct($path, $verb, $body = null) {
        $this->path = $path;
        $this->verb = $verb;
        $this->body = $body;
        $this->headers = [];
    }

    function parseHeaders() {
        $hs = [];
        foreach ($this->headers as $k => $v) {
            $k = trim($k);
            $v = trim($v);
            $hs[] = "{$k}: {$v}";
        }
        return $hs;
    }
}