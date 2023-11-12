<?php

namespace app\models;

use yii\db\ActiveRecord;

class Region extends ActiveRecord
{
    public static function tableName()
    {
        return 'regions';
    }
}