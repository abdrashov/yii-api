<?php

use Codeception\Util\HttpCode;

class DirectionDateCest
{
    public function getAllDate(ApiTester $I)
    {
        $I->sendGET('/api/direction-dates');
        $I->seeResponseCodeIs(HttpCode::OK);
    }
}
