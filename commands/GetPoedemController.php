<?php

namespace app\commands;


use app\services\poedem\PoedemService;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class GetPoedemController extends Controller
{
    public function actionIndex()
    {
        $poedemService = new PoedemService(
            'https://poedem.kz/find-form/get-data-for-wide'
        );

        $poedemService->apply();

        return ExitCode::OK;
    }
}