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

        return static::normalize($country);
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