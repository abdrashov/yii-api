<?php

namespace app\controllers\api;

use app\models\Direction;
use Yii;
use yii\db\Query;
use yii\web\Controller;

class DirectionController extends Controller
{
    public function actionIndex()
    {
        return response(array_map(fn($direction) => [
            'id' => $direction['id'],
            'city_id' => $direction['city_id'],
            'country_id' => $direction['country_id'],
            'price' => $direction['price'],
            'cur' => $direction['cur'],
        ], (new Query)->from(Direction::tableName())->all()));
    }

    public function actionView($id)
    {
        $direction = (new Query)->from(Direction::tableName())
            ->where(['id' => $id])
            ->one();

        return response([
            'id' => $direction['id'],
            'city_id' => $direction['city_id'],
            'country_id' => $direction['country_id'],
            'price' => $direction['price'],
            'cur' => $direction['cur'],
        ]);
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
