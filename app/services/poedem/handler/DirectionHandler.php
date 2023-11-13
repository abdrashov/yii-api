<?php

namespace app\services\poedem\handler;

use app\models\City;
use app\models\Country;
use app\services\DirectionDateService;
use app\services\DirectionDayService;
use app\services\DirectionService;
use yii\db\Query;

class DirectionHandler
{
    private array $content;

    public function __construct(array $content)
    {
        $this->content = $content;
    }

    public function apply(): void
    {
        foreach ($this->handler() as $content) {
            if ($direction = DirectionService::findByCityIdCountryId($content['city_id'], $content['country_id'])) {
                DirectionService::update($direction, [
                    'city_id' => $content['city_id'],
                    'country_id' => $content['country_id'],
                    'price' => $content['price'],
                    'cur' => $content['cur'],
                ]);
            } else {
                $direction = DirectionService::store([
                    'city_id' => $content['city_id'],
                    'country_id' => $content['country_id'],
                    'price' => $content['price'],
                    'cur' => $content['cur'],
                ]);
            }

            DirectionDayService::delete($direction['id']);
            DirectionDayService::insert($direction['id'], array_unique($content['days']));

            DirectionDateService::delete($direction['id']);
            DirectionDateService::insert($direction['id'], array_unique($content['dates']));
        }
    }

    public function handler()
    {
        $cities = (new Query)->from(City::tableName())
            ->where(['in', 'api_id', array_keys($this->content)])
            ->all();

        $api_ids = [];
        foreach ($this->content as $contents) {
            $api_ids = array_merge($api_ids, array_keys($contents));
        }

        $countries = (new Query)->from(Country::tableName())
            ->where(['in', 'api_id', array_unique($api_ids)])
            ->all();

        foreach ($this->content as $api_city_id => $contents) {
            foreach ($contents as $api_county_id => $content) {
                $city = array_values(array_filter($cities, fn($city) => $city['api_id'] == $api_city_id))[0];
                $country = array_values(array_filter($countries, fn($country) => $country['api_id'] == $api_county_id))[0];

                yield [
                    'city_id' => $city['id'],
                    'country_id' => $country['id'],
                    'price' => $content['price'],
                    'cur' => $content['cur'],
                    'days' => $content['days'],
                    'dates' => $content['defaultDate'],
                ];
            }
        }
    }
}