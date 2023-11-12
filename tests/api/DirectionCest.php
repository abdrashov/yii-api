<?php

use Codeception\Util\HttpCode;

class DirectionCest
{
    public function getAllDirections(ApiTester $I)
    {
        $I->sendGET('/api/directions');
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function getDirection(ApiTester $I)
    {
        $I->sendGET('/api/directions/1');
        $I->seeResponseCodeIs(HttpCode::OK);
    }
}
