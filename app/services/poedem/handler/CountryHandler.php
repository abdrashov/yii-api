<?php

namespace app\services\poedem\handler;

use app\services\CountryService;

class CountryHandler
{
    private array $content;

    public function __construct(array $content)
    {
        $this->content = $content;
    }

    public function apply(): void
    {
        $this->handler();

        foreach ($this->handler() as $content) {
            if ($city = CountryService::findByApiId($content['api_id'])) {
                CountryService::update($city, $content);
            } else {
                CountryService::insert($content);
            }
        }
    }

    public function handler()
    {
        foreach ($this->content as $key => $content) {
            yield [
                'api_id' => $key,
                'name' => $content['name'],
                'name_to' => $content['nameTo'],
                'to' => $content['to'],
                'sort' => $content['sort'],
            ];
        }
    }
}