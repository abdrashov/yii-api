<?php

namespace app\services;

use app\models\DirectionDate;
use yii\db\Query;

class DirectionDateService
{
    public static function getByDirectionIds(array $ids): array
    {
        return (new Query)->from(DirectionDate::tableName())
            ->where(['in', 'direction_id', $ids])
            ->all();
    }
}