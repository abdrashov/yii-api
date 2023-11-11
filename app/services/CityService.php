<?php

namespace app\services;

use app\models\City;
use yii\db\Query;

class CityService
{
    public static function get(): array
    {
        return array_map(
            fn($city) => static::normalize($city),
            (new Query)->from(City::tableName())->orderBy('sort')->all()
        );
    }

    public static function find(int $id): array
    {
        $city = (new Query)->from(City::tableName())
            ->where(['id' => $id])
            ->one();

        return static::normalize($city);
    }

    private static function normalize(array $city): array
    {
        return [
            'id' => $city['id'],
            'api_id' => $city['api_id'],
            'name' => $city['name'],
            'nameFrom' => $city['name_from'],
            'sort' => $city['sort'],
        ];
    }
}