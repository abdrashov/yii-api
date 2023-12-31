<?php

namespace app\controllers\api;

use app\models\Direction;
use app\models\DirectionDate;
use app\models\DirectionDay;
use app\services\DirectionDateService;
use app\services\DirectionDayService;
use app\services\DirectionService;
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
        return response($direction = DirectionService::find($id), $direction ? 200 : 404);
    }

    public function actionStore()
    {
        $request = Yii::$app->request->get();

        $direction = new Direction();
        $direction->load(['Direction' => $request]);

        $directionDay = new DirectionDay();
        $directionDay->setScenario('create');
        $directionDay->load(['DirectionDay' => $request]);

        $directionDate = new DirectionDate();
        $directionDate->setScenario('create');
        $directionDate->load(['DirectionDate' => $request]);

        if (!($direction->validate() & $directionDay->validate() & $directionDate->validate())) {
            return response($direction->errors + $directionDay->errors + $directionDate->errors, 422);
        }

        $direction = DirectionService::store([
            'city_id' => $request['city_id'],
            'country_id' => $request['country_id'],
            'price' => $request['price'],
            'cur' => $request['cur'],
        ]);

        DirectionDayService::insert($direction['id'], array_unique($request['day']));

        DirectionDateService::insert($direction['id'], array_unique($request['date']));

        return response([
            'message' => 'Successful'
        ], 201);
    }
}
