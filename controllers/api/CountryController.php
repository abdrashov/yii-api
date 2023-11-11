<?php

namespace app\controllers\api;

use app\models\Country;
use yii\db\Query;
use yii\web\Controller;

class CountryController extends Controller
{
    public function actionIndex()
    {
        return response(array_map(fn($country) => [
            'id' => $country['id'],
            'api_id' => $country['api_id'],
            'name' => $country['name'],
            'nameTo' => $country['name_to'],
        ], (new Query)->from(Country::tableName())->orderBy('sort')->all()));
    }

    public function actionView($id)
    {
        $country = (new Query)->from(Country::tableName())
            ->where(['id' => $id])
            ->one();

        return response([
            'id' => $country['id'],
            'api_id' => $country['api_id'],
            'name' => $country['name'],
            'nameTo' => $country['name_to'],
        ]);
    }
}
