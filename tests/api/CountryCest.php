<?php

use Codeception\Util\HttpCode;

class CountryCest
{
    public function getAllCountries(ApiTester $I)
    {
        $I->sendGET('/api/countries');
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function getCountry(ApiTester $I)
    {
        $I->sendGET('/api/countries/1');
        $I->seeResponseCodeIs(HttpCode::OK);
    }
}
