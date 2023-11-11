<?php

namespace app\services\poedem\handler;

use yii\db\Query;

class CountyHandler extends HandlerAbstract
{
    public const TABLE = 'countries';

    public const JSON_KEY = 'countries';

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

        if ($exists) {
            $this->update($this->content + ['api_id' => $this->id]);
        } else {
            $this->insert($this->content + ['api_id' => $this->id]);
        }
    }

    public function insert(array $content): void
    {
        (new Query())->createCommand()->insert(static::TABLE, [
            'api_id' => $content['api_id'],
            'name' => $content['name'],
            'name_to' => $content['nameTo'],
            'to' => $content['to'],
            'sort' => $content['sort'],
        ])->execute();
    }

    public function update(array $content): void
    {
        (new Query())->createCommand()->update(static::TABLE, [
            'name' => $content['name'],
            'name_to' => $content['nameTo'],
            'to' => $content['to'],
            'sort' => $content['sort'],
        ], [
            'api_id' => $content['api_id'],
        ])->execute();
    }
}