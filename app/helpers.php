<?php

if (!function_exists('response')) {
    function response(array $body, int $status = 200): void
    {
        $response = \Yii::$app->response;
        $response->statusCode = $status;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $body;
        $response->send();
        \Yii::$app->end();
    }
}