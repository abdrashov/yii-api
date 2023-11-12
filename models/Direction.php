<?php

namespace app\models;

use app\services\DirectionService;
use yii\base\Model;

class Direction extends Model
{
    public $city_id;
    public $country_id;
    public $price;
    public $cur;

    public static function tableName()
    {
        return 'directions';
    }

    public function rules()
    {
        return [
            [['city_id', 'country_id', 'price', 'cur'], 'required'],
            [['city_id', 'country_id'], 'validateUniqueness'],
            [['price'], 'number'],
            [['cur'], 'string', 'max' => 5],
        ];
    }

    public function validateUniqueness($attribute)
    {
        if (DirectionService::existByCityIdCountryId($this->attributes['city_id'], $this->attributes['country_id'])) {
            $this->addError($attribute, 'This already exists.');
        }
    }
}