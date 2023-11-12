<?php

use Codeception\Util\HttpCode;

class CityCest
{
    public function getAllCities(ApiTester $I)
    {
        $I->sendGET('/api/cities');
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function getCity(ApiTester $I)
    {
        $I->sendGET('/api/cities/1');
        $I->seeResponseCodeIs(HttpCode::OK);
    }
}
