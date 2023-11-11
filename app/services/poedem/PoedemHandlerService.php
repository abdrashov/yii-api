<?php

namespace app\services\poedem;

use app\services\poedem\handler\HandlerAbstract;
use app\services\poedem\handler\HandlerInterface;

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