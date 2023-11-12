<?php

namespace app\services;

use app\models\Country;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class CountryService
{
    public static function get(): array
    {
        $countries = (new Query)->from(Country::tableName())->all();

        $countryDeparts = CountryDepartService::getByCountryIds(ArrayHelper::getColumn($countries, 'id'));

        return array_map(
            fn($country) => static::normalize(
                $country,
                array_filter($countryDeparts, fn($countryDepart) => $countryDepart['country_id'] == $country['id']),
            ),
            $countries
        );
    }

    public static function find(int $id): array
    {
        $country = (new Query)->from(Country::tableName())
            ->where(['id' => $id])
            ->one();

        if (!$country) return [];

        $countryDeparts = CountryDepartService::getByCountryIds([$country['id']]);

        return $country ? static::normalize($country, $countryDeparts) : [];
    }

    public static function findByApiId(int $api_id): array
    {
        return (new Query)->from(Country::tableName())
            ->where(['api_id' => $api_id])
            ->one() ?: [];
    }

    public static function store(array $content): array
    {
        $connection = Yii::$app->db;

        $connection->createCommand()->insert(Country::tableName(), $content)->execute();

        return static::find($connection->getLastInsertID());
    }

    public static function update(array $country, array $content): void
    {
        (new Query())->createCommand()->update(Country::tableName(), $content, [
            'id' => $country['id'],
        ])->execute();
    }

    private static function normalize(array $country, array $departs): array
    {
        return [
            'id' => $country['id'],
            'api_id' => $country['api_id'],
            'name' => $country['name'],
            'nameTo' => $country['name_to'],
            'departs' => array_values(ArrayHelper::getColumn($departs, 'depart'))
        ];
    }
}