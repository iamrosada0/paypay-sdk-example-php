<?php

namespace PayPayCheckoutSdk\PayPayHttp;

class HttpClient
{
    private $log;

    private $encoder;


    function __construct(Log $log = null) {
        if (is_null($log)) {
            $log = new Log();
        }
        $this->log = $log;
        $this->encoder = new Encoder();
    }

    /**
     * @throws HttpException
     */
    public function execute(HttpRequest $request) {
        $requestCpy = clone $request;
        $curl = new Curl();
        $url = $requestCpy->path;
        $this->log->log("[{$requestCpy->verb}]{$url}");
        if (!array_key_exists("user-agent", $requestCpy->headers)) {
            $requestCpy->headers["user-agent"] = $this->userAgent();
        }
        if (!array_key_exists("content-type", $requestCpy->headers)) {
            $requestCpy->headers["content-type"] = "application/json";
        }
        $curl->setOpt(CURLOPT_URL, $url);
        $curl->setOpt(CURLOPT_CUSTOMREQUEST, $requestCpy->verb);
        $curl->setOpt(CURLOPT_HTTPHEADER, $requestCpy->parseHeaders());
        $curl->setOpt(CURLOPT_RETURNTRANSFER, 1);
        $curl->setOpt(CURLOPT_HEADER, 0);
        if (!is_null($requestCpy->body)) {
            $body = $this->encoder->serializeRequest($request);
            $this->log->log("Http body: " . $body);
            $curl->setOpt(CURLOPT_POSTFIELDS, $body);
        }
        if (strpos($url, "https://") === 0) {
            if ($requestCpy->enableSSL) {
                $curl->setOpt(CURLOPT_SSL_VERIFYPEER, true);
                $curl->setOpt(CURLOPT_SSL_VERIFYHOST, 2);
            } else {
                $curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
                $curl->setOpt(CURLOPT_SSL_VERIFYHOST, false);
            }
        }
        $response = $curl->exec();
        $statusCode = $curl->getInfo(CURLINFO_HTTP_CODE);
        $errorCode = $curl->errNo();
        $error = $curl->error();
        $curl->close();
        if ($errorCode > 0) {
            throw new HttpException($error, $errorCode);
        }
        return new HttpResponse($statusCode, $response, []);
    }

    public function userAgent() {
        return "PayPaySDK-PHP HTTP/1.1";
    }

}