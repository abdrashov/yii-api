<?php

namespace app\services;

use app\models\Country;
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

    public static function insert(array $request): void
    {
        array_map(function ($day) use ($request) {
            (new Query())->createCommand()->insert(DirectionDay::tableName(), [
                'direction_id' => $request['direction_id'],
                'day' => $day
            ])->execute();
        }, $request['days']);
    }
}