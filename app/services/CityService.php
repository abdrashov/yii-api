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

        return $city ? static::normalize($city) : [];
    }

    public static function findByApiId(int $api_id): array
    {
        return (new Query)->from(City::tableName())
            ->where(['api_id' => $api_id])
            ->one() ?: [];
    }

    public static function insert(array $content): void
    {
        (new Query())->createCommand()->insert(City::tableName(), $content)->execute();
    }

    public static function update(array $city, array $content): void
    {
        (new Query())->createCommand()->update(City::tableName(), $content, [
            'id' => $city['id'],
        ])->execute();
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