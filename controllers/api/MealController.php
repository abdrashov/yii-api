<?php

namespace app\controllers\api;

use app\services\MealService;
use yii\web\Controller;

class MealController extends Controller
{
    public function actionIndex()
    {
        return response(MealService::get());
    }

    public function actionView($id)
    {
        return response($meal = MealService::find($id), $meal ? 200 : 404);
    }
}
