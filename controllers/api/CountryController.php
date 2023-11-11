<?php

namespace app\controllers\api;

use app\services\CountryService;
use yii\web\Controller;

class CountryController extends Controller
{
    public function actionIndex()
    {
        return response(CountryService::get());
    }

    public function actionView($id)
    {
        return response(CountryService::find($id));
    }
}
