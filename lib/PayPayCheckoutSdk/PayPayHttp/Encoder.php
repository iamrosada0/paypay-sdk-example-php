<?php

namespace PayPayCheckoutSdk\PayPayHttp;

class Encoder
{
    public function serializeRequest(HttpRequest $request) {
        $body = $request->body;
        if (!is_scalar($body)) {
            $body = json_encode($body, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
        return $body;
    }

    public function deserializeResponse($responseBody, $headers) {
        return json_decode($responseBody, true);
    }
}