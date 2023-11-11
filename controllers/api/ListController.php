<?php

namespace app\controllers\api;

use app\models\City;
use app\models\Country;
use app\models\Direction;
use app\models\Meal;
use app\models\Region;
use app\services\CityService;
use app\services\CountryService;
use app\services\DirectionService;
use app\services\MealService;
use app\services\RegionService;
use yii\web\Controller;

class ListController extends Controller
{
    public function actionIndex()
    {
        return response([
            City::tableName(), CityService::get(),
            Country::tableName(), CountryService::get(),
            Direction::tableName(), DirectionService::get(),
            Meal::tableName(), MealService::get(),
            Region::tableName(), RegionService::get(),
        ]);
    }
}
