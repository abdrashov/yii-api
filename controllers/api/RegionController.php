<?php

namespace app\controllers\api;

use app\services\RegionService;
use yii\web\Controller;

class RegionController extends Controller
{
    public function actionIndex()
    {
        return response(RegionService::get());
    }

    public function actionView($id)
    {
        return response($region = RegionService::find($id), $region ? 200 : 404);
    }
}
