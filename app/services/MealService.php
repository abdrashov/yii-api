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

        return static::normalize($meal);
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