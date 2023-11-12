<?php

namespace app\controllers\api;

use app\services\CityService;
use yii\web\Controller;

class CityController extends Controller
{
    public function actionIndex()
    {
        return response(CityService::get());
    }

    public function actionView($id)
    {
        return response($city = CityService::find($id), $city ? 200 : 404);
    }
}
