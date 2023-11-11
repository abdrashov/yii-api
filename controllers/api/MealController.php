<?php

namespace app\controllers\api;

use app\models\Meal;
use yii\db\Query;
use yii\web\Controller;

class MealController extends Controller
{
    public function actionIndex()
    {
        return response(array_map(fn($meal) => [
            'id' => $meal['id'],
            'api_id' => $meal['api_id'],
            'name' => $meal['name'],
        ], (new Query)->from(Meal::tableName())->all()));
    }

    public function actionView($id)
    {
        $meal = (new Query)->from(Meal::tableName())
            ->where(['id' => $id])
            ->one();

        return response([
            'id' => $meal['id'],
            'api_id' => $meal['api_id'],
            'name' => $meal['name'],
        ]);
    }
}
