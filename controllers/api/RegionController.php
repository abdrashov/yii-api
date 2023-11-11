<?php

namespace app\controllers\api;

use app\models\Region;
use yii\db\Query;
use yii\web\Controller;

class RegionController extends Controller
{
    public function actionIndex()
    {
        return response(array_map(fn($region) => [
            'id' => $region['id'],
            'api_id' => $region['api_id'],
            'country_id' => $region['country_id'],
            'name' => $region['name'],
            'price' => $region['price'],
            'cur' => $region['cur'],
            'popularity' => $region['popularity'],
        ], (new Query)->from(Region::tableName())->all()));
    }

    public function actionView($id)
    {
        $region = (new Query)->from(Region::tableName())
            ->where(['id' => $id])
            ->one();

        return response([
            'id' => $region['id'],
            'api_id' => $region['api_id'],
            'country_id' => $region['country_id'],
            'name' => $region['name'],
            'price' => $region['price'],
            'cur' => $region['cur'],
            'popularity' => $region['popularity'],
        ]);
    }
}
