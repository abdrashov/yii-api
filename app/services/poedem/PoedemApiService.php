<?php

namespace app\services\poedem;

use yii\httpclient\Client;

class PoedemApiService
{
    public function getContent(string $url): array
    {
        $response = (new Client())->createRequest()
            ->setMethod('GET')
            ->setUrl($url)
            ->send();

        if (!$response->isOk) {
            return [];
        }

        return json_decode($response->content, true);
//        $content = file_get_contents(Yii::$app->basePath . '/web/get-data-for-wide.json');
//        return json_decode($content, true);
    }
}