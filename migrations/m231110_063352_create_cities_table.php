<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cities}}`.
 */
class m231110_063352_create_cities_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cities}}', [
            'id' => $this->primaryKey(),
            'api_id' => $this->integer(),
            'name' => $this->string()->notNull(),
            'name_from' => $this->string()->notNull(),
            'sort' => $this->integer()->defaultValue(0),
        ]);

        $this->createIndex(
            'idx-cities-api_id',
            'cities',
            'api_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-cities-api_id',
            'cities'
        );

        $this->dropTable('{{%cities}}');
    }
}
