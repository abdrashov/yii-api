<?php

namespace app\services;

use app\models\Country;
use yii\db\Query;

class CountryService
{
    public static function get(): array
    {
        return array_map(
            fn($country) => static::normalize($country),
            (new Query)->from(Country::tableName())->orderBy('sort')->all()
        );
    }

    public static function find(int $id): array
    {
        $country = (new Query)->from(Country::tableName())
            ->where(['id' => $id])
            ->one();

        return $country ? static::normalize($country) : [];
    }

    public static function findByApiId(int $api_id): array
    {
        return (new Query)->from(Country::tableName())
            ->where(['api_id' => $api_id])
            ->one() ?: [];
    }

    public static function insert(array $content): void
    {
        (new Query())->createCommand()->insert(Country::tableName(), $content)->execute();
    }

    public static function update(array $country, array $content): void
    {
        (new Query())->createCommand()->update(Country::tableName(), $content, [
            'id' => $country['id'],
        ])->execute();
    }

    private static function normalize(array $country): array
    {
        return [
            'id' => $country['id'],
            'api_id' => $country['api_id'],
            'name' => $country['name'],
            'nameTo' => $country['name_to'],
        ];
    }
}