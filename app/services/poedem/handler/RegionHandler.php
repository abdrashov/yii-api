<?php

namespace app\services\poedem\handler;

use app\models\Country;
use app\services\RegionService;
use yii\db\Query;

class RegionHandler
{
    private array $content;

    public function __construct(array $content)
    {
        $this->content = $content;
    }

    public function apply(): void
    {
        foreach ($this->handler() as $content) {
            if ($region = RegionService::findByApiId($content['api_id'])) {
                RegionService::update($region, [
                    'api_id' => $content['api_id'],
                    'country_id' => $content['country_id'],
                    'name' => $content['name'],
                    'price' => $content['price'],
                    'cur' => $content['cur'],
                    'popularity' => $content['popularity'],
                ]);
            } else {
                RegionService::insert([
                    'api_id' => $content['api_id'],
                    'country_id' => $content['country_id'],
                    'name' => $content['name'],
                    'price' => $content['price'],
                    'cur' => $content['cur'],
                    'popularity' => $content['popularity'],
                ]);
            }
        }
    }

    public function handler()
    {
        $countries = (new Query)->from(Country::tableName())
            ->where(['in', 'api_id', array_keys($this->content)])
            ->all();

        foreach ($this->content as $api_country_id => $contents) {
            foreach ($contents as $content) {
                $country = array_values(array_filter($countries, fn($country) => $country['api_id'] == $api_country_id))[0];

                yield [
                    'api_id' => $content['id'],
                    'country_id' => $country['id'],
                    'name' => $content['name'],
                    'price' => $content['price'],
                    'cur' => $content['cur'],
                    'popularity' => $content['popularity'],
                ];
            }
        }
    }
}