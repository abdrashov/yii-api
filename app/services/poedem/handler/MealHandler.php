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
        $this->handler();

        foreach ($this->handler() as $content) {
            if ($meal = MealService::findByApiId($content['api_id'])) {
                MealService::update($meal, $content);
            } else {
                MealService::insert($content);
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