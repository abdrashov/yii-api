<?php

namespace app\services\poedem;

class PoedemService
{
    private string $url;
    private array $content;

    private array $handler = [
        \app\services\poedem\handler\CityHandler::class,
        \app\services\poedem\handler\CountyHandler::class,
        \app\services\poedem\handler\DirectionHandler::class,
        \app\services\poedem\handler\MealHandler::class,
        \app\services\poedem\handler\RegionHandler::class,
    ];

    public function setContent(): void
    {
        $this->content = (new PoedemApiService)->getContent($this->url);
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function apply(): void
    {
        foreach ($this->handler as $handler) {
            $handler = new $handler;

            if (!array_key_exists($handler::JSON_KEY, $this->content)) {
                continue;
            }

            new PoedemHandlerService($handler, $this->content[$handler::JSON_KEY]);
        }

        dd($this->content);
    }
}
