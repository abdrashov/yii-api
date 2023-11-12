<?php

namespace app\services\poedem\handler;

use app\services\CountryDepartService;
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
            if ($county = CountryService::findByApiId($content['api_id'])) {
                CountryService::update($county, [
                    'api_id' => $content['api_id'],
                    'name' => $content['name'],
                    'name_to' => $content['name_to'],
                    'to' => $content['to'],
                    'sort' => $content['sort'],
                ]);
            } else {
                $county = CountryService::store([
                    'api_id' => $content['api_id'],
                    'name' => $content['name'],
                    'name_to' => $content['name_to'],
                    'to' => $content['to'],
                    'sort' => $content['sort'],
                ]);
            }

            CountryDepartService::delete($county['id']);
            CountryDepartService::insert($county['id'], $content['departs']);
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
                'departs' => $content['departs'],
            ];
        }
    }
}