<?php

use Codeception\Util\HttpCode;

class MealCest
{
    public function getAllMeals(ApiTester $I)
    {
        $I->sendGET('/api/meals');
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function getMeal(ApiTester $I)
    {
        $I->sendGET('/api/meals/1');
        $I->seeResponseCodeIs(HttpCode::OK);
    }
}
