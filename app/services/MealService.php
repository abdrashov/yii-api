<?php

namespace app\services;

use app\models\Meal;
use yii\db\Query;

class MealService
{
    public static function get(): array
    {
        return array_map(
            fn($meal) => static::normalize($meal),
            (new Query)->from(Meal::tableName())->all()
        );
    }

    public static function find(int $id): array
    {
        $meal = (new Query)->from(Meal::tableName())
            ->where(['id' => $id])
            ->one();

        return $meal ? static::normalize($meal) : [];
    }

    public static function findByApiId(int $api_id): array
    {
        return (new Query)->from(Meal::tableName())
            ->where(['api_id' => $api_id])
            ->one() ?: [];
    }

    public static function insert(array $content): void
    {
        (new Query())->createCommand()->insert(Meal::tableName(), $content)->execute();
    }

    public static function update(array $meal, array $content): void
    {
        (new Query())->createCommand()->update(Meal::tableName(), $content, [
            'id' => $meal['id'],
        ])->execute();
    }

    private static function normalize(array $meal): array
    {
        return [
            'id' => $meal['id'],
            'api_id' => $meal['api_id'],
            'name' => $meal['name'],
        ];
    }
}