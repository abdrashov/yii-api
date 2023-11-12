<?php

namespace app\services;

use app\models\CountryDepart;
use yii\db\Query;

class CountryDepartService
{
    public static function getByCountryIds(array $ids): array
    {
        return (new Query)->from(CountryDepart::tableName())
            ->where(['in', 'country_id', $ids])
            ->all();
    }

    public static function delete(int $country_id): void
    {
        (new Query())->createCommand()->delete(CountryDepart::tableName(), [
            'country_id' => $country_id
        ])->execute();
    }

    public static function insert(int $country_id, array $departs): void
    {
        array_map(fn($depart) => (new Query())->createCommand()->insert(CountryDepart::tableName(), [
            'country_id' => $country_id,
            'depart' => $depart
        ])->execute(), $departs);
    }
}