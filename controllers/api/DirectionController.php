<?php

namespace app\controllers\api;

use app\services\DirectionService;
use app\models\Direction;
use Yii;
use yii\web\Controller;

class DirectionController extends Controller
{
    public function actionIndex()
    {
        return response(DirectionService::get());
    }

    public function actionView($id)
    {
        return response(DirectionService::find($id));
    }

    public function actionStore()
    {
        $direction = new Direction();
        $direction->load(['Direction' => Yii::$app->request->get()]);

        if (!$direction->validate()) {
            return response($direction->errors, 422);
        }

        return response([
            'message' => 'Successful'
        ], 201);
    }
}
