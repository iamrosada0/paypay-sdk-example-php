<?php

namespace PayPayCheckoutSdk\Config;

class PayPayConfig
{
    protected static $endPoint = "https://gateway.paypayafrica.com/recv.do";

    protected static $paypayPublicKey = "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAydmftMVrdJU7MQa/75RXsQgNDeEytJA7tSk8nGrboZNt6sx7dLhW+f1NgzY0VlymZeMjL7+IX44fLXo2TGLxE+ziRFCVsgl/DLC5qndyiBwh7Bfreph5OR3guj5k733mjYLiQ2UJDKqswlEYeB6LJwdl1QTmTq1STlX7HDQkhVfYCuUlgQocCAOFpew8rOi5ssw3qiAE35OQQMepP+c2etZC1apmyWvE+u8XW5zuo4b/j43c3/h9LhRZJHt7UWSgDWvWZL6n6W5sB6VftBsNE8Opot080SVJCbnPBS6AtgR2G5OQQyn4GF81sxxAwlAP7d6bX2aZptv+unemhfKJKwIDAQAB";

    protected $partnerId;

    protected $myPrivateKey;

    protected $lang;

    public function getEndPoint() {
        return self::$endPoint;
    }

    public function getPayPayPublicKey() {
        return "-----BEGIN PUBLIC KEY-----\n" . wordwrap(self::$paypayPublicKey, 64, "\n", true) . "\n-----END PUBLIC KEY-----";
    }

    public function __construct($partnerId = "", $myPrivateKey = "") {
        $this->partnerId = $partnerId;
        $this->myPrivateKey = $myPrivateKey;
    }

    public function getPartnerId() {
        return $this->partnerId;
    }

    public function setPartnerId($partnerId) {
        $this->partnerId = $partnerId;
    }

    public function setMyPrivateKey($myPrivateKey) {
        $this->myPrivateKey = $myPrivateKey;
    }

    public function getMyPrivateKey() {
        return $this->myPrivateKey;
    }

    /**
     * @return mixed
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param mixed $lang
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
    }

}