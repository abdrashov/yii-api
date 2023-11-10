<?php

namespace app\controllers;

use yii\data\Pagination;
use yii\web\Controller;

class CityController extends Controller
{
    public function actionIndex()
    {
        $query = \Yii::$app->db->createCommand('SELECT * FROM cities')->queryAll();

        dd($query);

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $countries = $query->orderBy('name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        dd($countries);

        return $this->render('index', [
            'countries' => $countries,
            'pagination' => $pagination,
        ]);
    }
}
