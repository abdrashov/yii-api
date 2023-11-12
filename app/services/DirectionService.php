<?php

namespace app\services;

use app\models\Direction;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class DirectionService
{
    public static function get(): array
    {
        $directions = (new Query)->from(Direction::tableName())->all();

        $directionDays = DirectionDayService::getByDirectionIds(ArrayHelper::getColumn($directions, 'id'));
        $directionDates = DirectionDateService::getByDirectionIds(ArrayHelper::getColumn($directions, 'id'));

        return array_map(
            fn($direction) => static::normalize(
                $direction,
                array_filter($directionDays, fn($directionDay) => $directionDay['direction_id'] == $direction['id']),
                array_filter($directionDates, fn($directionDate) => $directionDate['direction_id'] == $direction['id']),
            ),
            $directions
        );
    }

    public static function find(int $id): array
    {
        $direction = (new Query)->from(Direction::tableName())
            ->where(['id' => $id])
            ->one();

        $directionDays = DirectionDayService::getByDirectionIds([$direction['id']]);
        $directionDates = DirectionDateService::getByDirectionIds([$direction['id']]);

        return static::normalize($direction, $directionDays, $directionDates);
    }

    public static function store(array $request): array
    {
        $connection = Yii::$app->db;

        $connection->createCommand()->insert(Direction::tableName(), [
            'city_id' => $request['city_id'],
            'country_id' => $request['country_id'],
            'price' => $request['price'],
            'cur' => $request['cur'],
        ])->execute();

        return static::find($connection->getLastInsertID());
    }

    public static function checkExistByCityIdCountyId(int $city_id, int $country_id): bool
    {
        return (new Query)->from(Direction::tableName())
            ->where([
                'and',
                ['city_id' => $city_id],
                ['country_id' => $country_id],
            ])
            ->exists();
    }

    private static function normalize(array $direction, array $directionDays, array $directionDates): array
    {
        return [
            'id' => $direction['id'],
            'city_id' => $direction['city_id'],
            'country_id' => $direction['country_id'],
            'price' => $direction['price'],
            'cur' => $direction['cur'],
            'days' => $directionDays,
            'defaultDate' => $directionDates,
        ];
    }
}