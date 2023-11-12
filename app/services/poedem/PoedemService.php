<?php

namespace app\services\poedem;

class PoedemService
{
    private array $content;

    private static $attribute = [
        'cities' => \app\services\poedem\handler\CityHandler::class,
        'countries' => \app\services\poedem\handler\CountryHandler::class,
        'directions' => \app\services\poedem\handler\DirectionHandler::class,
        'meals' => \app\services\poedem\handler\MealHandler::class,
        'regions' => \app\services\poedem\handler\RegionHandler::class,
    ];

    public function __construct(string $url)
    {
        $this->content = (new PoedemApiService)->getContent($url);
    }

    public function apply(): void
    {
        foreach (static::$attribute as $json_key => $attribute) {
            if (!array_key_exists($json_key, $this->content)) {
                continue;
            }

            (new $attribute($this->content[$json_key]))
                ->apply();
        }
    }
}
