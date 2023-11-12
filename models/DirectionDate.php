<?php

namespace app\models;

use Yii;
use yii\base\Model;

class DirectionDate extends Model
{
    public $direction_id;
    public $date;

    public static function tableName()
    {
        return '{{direction_dates}}';
    }

    public function rules()
    {
        return [
            [['date'], 'required', 'on' => 'create'],

            [['direction_id', 'date'], 'required', 'on' => 'update'],

            ['date', 'each', 'rule' => ['integer']],
        ];
    }
}