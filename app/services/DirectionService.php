<?php

namespace app\services;

use app\models\Direction;
use yii\db\Query;

class DirectionService
{
    public static function get(): array
    {
        return array_map(
            fn($direction) => static::normalize($direction),
            (new Query)->from(Direction::tableName())->all()
        );
    }

    public static function find(int $id): array
    {
        $direction = (new Query)->from(Direction::tableName())
            ->where(['id' => $id])
            ->one();

        return static::normalize($direction);
    }

    private static function normalize(array $direction): array
    {
        return [
            'id' => $direction['id'],
            'city_id' => $direction['city_id'],
            'country_id' => $direction['country_id'],
            'price' => $direction['price'],
            'cur' => $direction['cur'],
        ];
    }
}