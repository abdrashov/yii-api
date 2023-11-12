<?php

namespace app\models;

use yii\db\ActiveRecord;

class Meal extends ActiveRecord
{
    public static function tableName()
    {
        return 'meals';
    }
}