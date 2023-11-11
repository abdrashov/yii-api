<?php

namespace app\models;

use yii\base\Model;

class Direction extends Model
{
    public $city_id;
    public $country_id;
    public $price;
    public $cur;

    public static function tableName()
    {
        return '{{directions}}';
    }

    public function rules()
    {
        return [
            [['city_id', 'country_id', 'price', 'cur'], 'required'],
            [['price'], 'number'],
            [['cur'], 'string', 'max' => 5],
        ];
    }
}