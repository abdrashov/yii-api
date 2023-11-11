<?php

namespace app\services\poedem\handler;

interface HandlerInterface
{
    public function apply(): void;

    public function insert(array $content): void;

    public function update(array $content): void;
}