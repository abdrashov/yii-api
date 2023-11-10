<?php

namespace App\Services\Poedem\Handler;

use yii\db\Query;

class RegionHandler extends HandlerAbstract
{
    public const TABLE = 'regions';

    public const JSON_KEY = 'regions';

    private int $id;
    private array $content;

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setContent(array $content)
    {
        $this->content = $content;
    }

    public function apply(): void
    {
        $exists = (new Query)->from(static::TABLE)
            ->where(['api_id' => $this->id])
            ->exists();

        $country = (new Query)->from(CountyHandler::TABLE)
            ->where(['api_id' => $this->id])
            ->one();

        foreach ($this->content as $content) {
            if ($exists) {
                $this->update([
                    'api_id' => $this->id,
                    'country_id' => $country['id'],
                    'name' => $content['name'],
                    'price' => $content['price'],
                    'cur' => $content['cur'],
                    'popularity' => $content['popularity'],
                ]);
            } else {
                $this->insert([
                    'api_id' => $this->id,
                    'country_id' => $country['id'],
                    'name' => $content['name'],
                    'price' => $content['price'],
                    'cur' => $content['cur'],
                    'popularity' => $content['popularity'],
                ]);
            }
        }
    }

    public function insert(array $content): void
    {
        (new Query())->createCommand()->insert(static::TABLE, [
            'api_id' => $content['api_id'],
            'country_id' => $content['country_id'],
            'name' => $content['name'],
            'price' => $content['price'],
            'cur' => $content['cur'],
            'popularity' => $content['popularity'],
        ])->execute();
    }

    public function update(array $content): void
    {
        (new Query())->createCommand()->update(static::TABLE, [
            'country_id' => $content['country_id'],
            'name' => $content['name'],
            'price' => $content['price'],
            'cur' => $content['cur'],
            'popularity' => $content['popularity'],
        ], [
            'api_id' => $content['api_id'],
        ])->execute();
    }
}