<?php

namespace App\Services\Poedem;

use App\Services\Poedem\Handler\HandlerAbstract;
use App\Services\Poedem\Handler\HandlerInterface;

class PoedemHandlerService
{
    public function __construct(HandlerAbstract $handler, array $contents)
    {
        foreach ($contents as $id => $content) {
            $handler = (new $handler);

            $handler->setId($id);
            $handler->setContent($content);
            $handler->apply();
        }
    }
}