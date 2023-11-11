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
        return response(CityService::find($id));
    }
}
