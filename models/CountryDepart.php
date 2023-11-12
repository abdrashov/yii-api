<?php

namespace app\models;

use yii\db\ActiveRecord;

class CountryDepart extends ActiveRecord
{
    public static function tableName()
    {
        return 'country_departs';
    }
}