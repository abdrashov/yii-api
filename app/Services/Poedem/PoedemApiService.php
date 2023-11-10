<?php

namespace App\Services\Poedem;

use Yii;

class PoedemApiService
{
    public function getContent(string $url): array
    {
//        $response = (new Client())->createRequest()
//            ->setMethod('GET')
//            ->setUrl()
//            ->send();
//
//        if (!$response->isOk) {
//            return [];
//        }
//
//        return json_decode($response->content, true);

        $content = file_get_contents(Yii::$app->basePath . '/web/get-data-for-wide.json');
        return json_decode($content, true);
    }
}