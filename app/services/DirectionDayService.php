<?php

namespace app\services;

use app\models\DirectionDay;
use yii\db\Query;

class DirectionDayService
{
    public static function getByDirectionIds(array $ids): array
    {
        return (new Query)->from(DirectionDay::tableName())
            ->where(['in', 'direction_id', $ids])
            ->all();
    }
}