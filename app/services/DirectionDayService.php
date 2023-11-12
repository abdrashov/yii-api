<?php

namespace app\services;

use app\models\DirectionDay;
use yii\db\Query;

class DirectionDayService
{
    public static function get(): array
    {
        return array_map(
            fn($directionDay) => $directionDay['day'],
            (new Query)->from(DirectionDay::tableName())->orderBy('day')->groupBy('day')->all()
        );
    }

    public static function getByDirectionIds(array $ids): array
    {
        return (new Query)->from(DirectionDay::tableName())
            ->where(['in', 'direction_id', $ids])
            ->all();
    }

    public static function insert(int $direction_id, array $days): void
    {
        array_map(fn($day) => (new Query())->createCommand()->insert(DirectionDay::tableName(), [
            'direction_id' => $direction_id,
            'day' => $day
        ])->execute(), $days);
    }

    public static function updateOrInsert(int $direction_id, array $days): void
    {
        array_map(fn($day) => (new Query())->createCommand()->upsert(DirectionDay::tableName(), [
            'direction_id' => $direction_id,
            'day' => $day
        ])->execute(), $days);
    }
}