<?php

use Codeception\Util\HttpCode;

class RegionCest
{
    public function getAllRegions(ApiTester $I)
    {
        $I->sendGET('/api/regions');
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function getRegion(ApiTester $I)
    {
        $I->sendGET('/api/regions/1');
        $I->seeResponseCodeIs(HttpCode::OK);
    }
}
