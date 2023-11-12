<?php

namespace app\services;

use app\models\DirectionDate;
use yii\db\Query;

class DirectionDateService
{
    public static function get(): array
    {
        return array_map(
            fn($directionDate) => $directionDate['date'],
            (new Query)->from(DirectionDate::tableName())->orderBy('date')->groupBy('date')->all()
        );
    }

    public static function getByDirectionIds(array $ids): array
    {
        return (new Query)->from(DirectionDate::tableName())
            ->where(['in', 'direction_id', $ids])
            ->all();
    }

    public static function insert(int $direction_id, array $dates): void
    {
        array_map(fn($date) => (new Query())->createCommand()->insert(DirectionDate::tableName(), [
            'direction_id' => $direction_id,
            'date' => $date
        ])->execute(), $dates);
    }

    public static function updateOrInsert(int $direction_id, array $dates): void
    {
        array_map(fn($date) => (new Query())->createCommand()->upsert(DirectionDate::tableName(), [
            'direction_id' => $direction_id,
            'date' => $date
        ])->execute(), $dates);
    }
}