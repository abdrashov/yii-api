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

        if (!$direction) return [];

        $directionDays = DirectionDayService::getByDirectionIds([$direction['id']]);
        $directionDates = DirectionDateService::getByDirectionIds([$direction['id']]);

        return static::normalize($direction, $directionDays, $directionDates);
    }

    public static function store(array $content): array
    {
        $connection = Yii::$app->db;

        $connection->createCommand()->insert(Direction::tableName(), $content)->execute();

        return static::find($connection->getLastInsertID());
    }

    public static function findByCityIdCountryId(int $city_id, int $country_id): array
    {
        return (new Query)->from(Direction::tableName())
            ->where([
                'and',
                ['city_id' => $city_id],
                ['country_id' => $country_id],
            ])
            ->one() ?: [];
    }

    public static function update(array $direction, array $content): void
    {
        (new Query())->createCommand()->update(Direction::tableName(), $content, [
            'id' => $direction['id'],
        ])->execute();
    }

    public static function existByCityIdCountryId(int $city_id, int $country_id): bool
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
            'days' => array_values(ArrayHelper::getColumn($directionDays, 'day')),
            'defaultDate' => array_values(ArrayHelper::getColumn($directionDates, 'date')),
        ];
    }
}