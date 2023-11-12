<?php

namespace app\controllers\api;

use app\services\DirectionDateService;
use app\services\DirectionDayService;
use yii\web\Controller;

class DirectionDateController extends Controller
{
    public function actionIndex()
    {
        return response(DirectionDateService::get());
    }
}
