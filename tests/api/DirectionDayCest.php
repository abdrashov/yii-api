<?php

use Codeception\Util\HttpCode;

class DirectionDayCest
{
    public function getAllDay(ApiTester $I)
    {
        $I->sendGET('/api/direction-days');
        $I->seeResponseCodeIs(HttpCode::OK);
    }
}
