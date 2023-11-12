<?php

namespace app\controllers\api;

use app\services\DirectionDayService;
use yii\web\Controller;

class DirectionDayController extends Controller
{
    public function actionIndex()
    {
        return response(DirectionDayService::get());
    }
}
