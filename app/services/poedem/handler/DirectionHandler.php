<?php

namespace app\services\poedem\handler;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class DirectionHandler extends HandlerAbstract
{
    public const TABLE = 'directions';

    public const JSON_KEY = 'directions';

    private int $id;
    private array $content;

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setContent(array $content)
    {
        $this->content = array_map(function ($key, $content) {
            return array_merge(['api_country_id' => $key] + $content);
        }, array_keys($content), $content);
    }

    public function apply(): void
    {
        $city = (new Query)->from(CityHandler::TABLE)
            ->where(['api_id' => $this->id])
            ->one();

        $countries = (new Query)->from(CountyHandler::TABLE)
            ->where(['in', 'api_id', ArrayHelper::getColumn($this->content, 'api_country_id')])
            ->all();

        $directions = (new Query)->from(static::TABLE)
            ->where(['city_id' => $city['id']])
            ->all();

        foreach ($this->content as $content) {
            $country_id = null;

            foreach ($countries as $country) {
                if ($country['api_id'] == $content['api_country_id']) {
                    $country_id = $country['id'];
                    break;
                }
            }

            $direction = array_filter($directions, fn($direction) => $direction['country_id'] == $country_id);
            $direction = array_values($direction);
            $direction = array_key_exists(0, $direction) ? $direction[0] : null;


            if ($direction) {
                $this->update([
                    'city_id' => $city['id'],
                    'country_id' => $country_id,
                    'price' => $content['price'],
                    'cur' => $content['cur'],
                ]);
            } else {
                $connection = Yii::$app->db;
                $command = $connection->createCommand()->insert(static::TABLE, [
                    'city_id' => $city['id'],
                    'country_id' => $country_id,
                    'price' => $content['price'],
                    'cur' => $content['cur'],
                ]);
                $command->execute();

                $direction = (new Query)->from(static::TABLE)
                    ->where(['id' => $connection->getLastInsertID()])
                    ->one();
            }

            (new Query())->createCommand()->delete('direction_days', [
                'direction_id' => $direction['id'],
            ])->execute();

            foreach ($content['days'] as $day) {
                (new Query())->createCommand()->insert('direction_days', [
                    'direction_id' => $direction['id'],
                    'day' => $day
                ])->execute();
            }

            (new Query())->createCommand()->delete('direction_dates', [
                'direction_id' => $direction['id'],
            ])->execute();

            foreach ($content['defaultDate'] as $date) {
                (new Query())->createCommand()->insert('direction_dates', [
                    'direction_id' => $direction['id'],
                    'date' => $date
                ])->execute();
            }
        }
    }

    public function insert(array $content)
    {
        return (new Query())->createCommand()->insert(static::TABLE, [
            'city_id' => $content['city_id'],
            'country_id' => $content['country_id'],
            'price' => $content['price'],
            'cur' => $content['cur'],
        ])->execute();
    }

    public function update(array $content): void
    {
        (new Query())->createCommand()->update(static::TABLE, [
            'price' => $content['price'],
            'cur' => $content['cur'],
        ], [
            'city_id' => $content['city_id'],
            'country_id' => $content['country_id'],
        ])->execute();
    }
}