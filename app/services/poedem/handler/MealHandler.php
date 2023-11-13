<?php

namespace app\services\poedem\handler;

use app\services\MealService;

class MealHandler
{
    private array $content;

    public function __construct(array $content)
    {
        $this->content = $content;
    }

    public function apply(): void
    {
        foreach ($this->handler() as $content) {
            if ($meal = MealService::findByApiId($content['api_id'])) {
                MealService::update($meal, [
                    'api_id' => $content['api_id'],
                    'name' => $content['name'],
                ]);
            } else {
                MealService::insert([
                    'api_id' => $content['api_id'],
                    'name' => $content['name'],
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
            ];
        }
    }
}