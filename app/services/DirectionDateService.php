<?php

namespace app\services;

use app\models\DirectionDate;
use app\models\DirectionDay;
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

    public static function insert(array $request): void
    {
        array_map(function ($date) use ($request) {
            (new Query())->createCommand()->insert(DirectionDate::tableName(), [
                'direction_id' => $request['direction_id'],
                'date' => $date
            ])->execute();
        }, $request['dates']);
    }
}