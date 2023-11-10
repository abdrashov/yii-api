<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%regions}}`.
 */
class m231110_071719_create_regions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%regions}}', [
            'id' => $this->primaryKey(),
            'api_id' => $this->integer(),
            'country_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'price' => $this->double()->notNull(),
            'cur' => $this->string()->notNull(),
            'popularity' => $this->integer()->defaultValue(0),
        ]);

        $this->createIndex(
            'idx-regions-api_id',
            'regions',
            'api_id'
        );

        $this->createIndex(
            'idx-regions-country_id',
            'regions',
            'country_id'
        );

        $this->addForeignKey(
            'fk-regions-country_id',
            'regions',
            'country_id',
            'countries',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-regions-api_id',
            'regions'
        );

        $this->dropForeignKey(
            'fk-regions-country_id',
            'regions'
        );

        $this->dropIndex(
            'idx-regions-country_id',
            'regions'
        );

        $this->dropTable('{{%regions}}');
    }
}
