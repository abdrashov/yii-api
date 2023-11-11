<?php

namespace app\services;

use app\models\Region;
use yii\db\Query;

class RegionService
{
    public static function get(): array
    {
        return array_map(
            fn($region) => static::normalize($region),
            (new Query)->from(Region::tableName())->all()
        );
    }

    public static function find(int $id): array
    {
        $region = (new Query)->from(Region::tableName())
            ->where(['id' => $id])
            ->one();

        return static::normalize($region);
    }

    private static function normalize(array $region): array
    {
        return [
            'id' => $region['id'],
            'api_id' => $region['api_id'],
            'country_id' => $region['country_id'],
            'name' => $region['name'],
            'price' => $region['price'],
            'cur' => $region['cur'],
            'popularity' => $region['popularity'],
        ];
    }
}