<?php

namespace app\controllers\api;

use app\models\City;
use yii\db\Query;
use yii\web\Controller;

class CityController extends Controller
{
    public function actionIndex()
    {
        return response(array_map(fn($city) => [
            'id' => $city['id'],
            'api_id' => $city['api_id'],
            'name' => $city['name'],
            'nameFrom' => $city['name_from'],
            'sort' => $city['sort'],
        ], (new Query)->from(City::tableName())->orderBy('sort')->all()));
    }

    public function actionView($id)
    {
        $city = (new Query)->from(City::tableName())
            ->where(['id' => $id])
            ->one();

        return response([
            'id' => $city['id'],
            'api_id' => $city['api_id'],
            'name' => $city['name'],
            'nameFrom' => $city['name_from'],
            'sort' => $city['sort'],
        ]);
    }
}
