<?php

namespace app\models;

use Yii;
use yii\base\Model;

class DirectionDay extends Model
{
    public $direction_id;
    public $day;

    public static function tableName()
    {
        return 'direction_days';
    }

    public function rules()
    {
        return [
            [['day'], 'required', 'on' => 'create'],

            [['direction_id', 'day'], 'required', 'on' => 'update'],

            ['day', 'each', 'rule' => ['integer']],
        ];
    }
}