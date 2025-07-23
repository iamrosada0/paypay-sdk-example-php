<?php

namespace PayPayCheckoutSdk\Core;

class PayPayRequestBase
{
    private $params = [];

    public function getRequestNo() {
        return $this->params["request_no"];
    }

    public function setRequestNo($value) {
        $this->params["request_no"] = $value;
    }

    public function getService() {
        return $this->params["service"];
    }

    public function setService($value) {
        $this->params['service'] = $value;
    }

    public function getVersion() {
        return $this->params["version"];
    }

    public function setVersion($value) {
        $this->params["version"] = $value;
    }

    public function getPartnerId() {
        return $this->params["partner_id"];
    }

    public function setPartnerId($value) {
        $this->params["partner_id"] = $value;
    }

    public function getCharset() {
        return $this->params['charset'];
    }

    public function setCharset($value) {
        $this->params['charset'] = $value;
    }

    public function getSign() {
        return $this->params["sign"];
    }

    public function setSign($value) {
        $this->params['sign'] = $value;
    }

    public function getSignType() {
        return $this->params['sign_type'];
    }

    public function setSignType($value) {
        $this->params['sign_type'] = $value;
    }

    public function setTimestamp($value) {
        $this->params['timestamp'] = $value;
    }

    public function getTimestamp() {
        return $this->params['timestamp'];
    }

    public function getFormat() {
        return $this->params['format'];
    }

    public function setFormat($value) {
        $this->params['format'] = $value;
    }

    public function getLanguage() {
        return $this->params['language'];
    }

    public function setLanguage($value) {
        $this->params['language'] = $value;
    }

    public function getBizContent() {
        return $this->params['biz_content'];
    }

    public function setBizContent($value) {
        $this->params['biz_content'] = $value;
    }

    public function getParams() {
        return $this->params;
    }
}