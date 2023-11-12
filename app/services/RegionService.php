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

        return $region ? static::normalize($region) : [];
    }

    public static function findByApiId(int $api_id): array
    {
        return (new Query)->from(Region::tableName())
            ->where(['api_id' => $api_id])
            ->one() ?: [];
    }

    public static function insert(array $content): void
    {
        (new Query())->createCommand()->insert(Region::tableName(), $content)->execute();
    }

    public static function update(array $region, array $content): void
    {
        (new Query())->createCommand()->update(Region::tableName(), $content, [
            'id' => $region['id'],
        ])->execute();
    }

    private static function normalize(array $region): array
    {
        return [
            'id' => $region['id'],
            'api_id' => $region['api_id'],
            'name' => $region['name'],
            'price' => $region['price'],
            'cur' => $region['cur'],
            'popularity' => $region['popularity'],
        ];
    }
}