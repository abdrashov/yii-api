<?php

namespace App\Services\Poedem;

class PoedemService
{
    private string $url;
    private array $content;

    private array $handler = [
        \App\Services\Poedem\Handler\CityHandler::class,
        \App\Services\Poedem\Handler\CountyHandler::class,
        \App\Services\Poedem\Handler\DirectionHandler::class,
        \App\Services\Poedem\Handler\MealHandler::class,
        \App\Services\Poedem\Handler\RegionHandler::class,
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
