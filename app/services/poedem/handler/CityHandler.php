<?php

namespace app\services\poedem\handler;

use app\services\CityService;

class CityHandler
{
    private array $content;

    public function __construct(array $content)
    {
        $this->content = $content;
    }

    public function apply(): void
    {
        foreach ($this->handler() as $content) {
            if ($city = CityService::findByApiId($content['api_id'])) {
                CityService::update($city, [
                    'api_id' => $content['api_id'],
                    'name' => $content['name'],
                    'name_from' => $content['name_from'],
                    'sort' => $content['sort'],
                ]);
            } else {
                CityService::insert([
                    'api_id' => $content['api_id'],
                    'name' => $content['name'],
                    'name_from' => $content['name_from'],
                    'sort' => $content['sort'],
                ]);
            }
        }
    }

    public function handler()
    {
        foreach ($this->content as $key => $content) {
            yield [
                'api_id' => $key,
                'name' => $content['name'],
                'name_from' => $content['nameFrom'],
                'sort' => $content['sort'],
            ];
        }
    }
}