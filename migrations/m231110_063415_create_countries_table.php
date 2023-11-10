<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%countries}}`.
 */
class m231110_063415_create_countries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%countries}}', [
            'id' => $this->primaryKey(),
            'api_id' => $this->integer(),
            'name' => $this->string()->notNull(),
            'name_to' => $this->string()->notNull(),
            'to' => $this->string()->notNull(),
            'sort' => $this->integer()->defaultValue(0),
        ]);

        $this->createIndex(
            'idx-countries-api_id',
            'countries',
            'api_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-countries-api_id',
            'countries'
        );

        $this->dropTable('{{%countries}}');
    }
}
