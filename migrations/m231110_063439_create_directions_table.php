<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%directions}}`.
 */
class m231110_063439_create_directions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%directions}}', [
            'id' => $this->primaryKey(),
            'city_id' => $this->integer()->notNull(),
            'country_id' => $this->integer()->notNull(),
            'price' => $this->double()->notNull(),
            'cur' => $this->string()->notNull(),
        ]);

        $this->createIndex(
            'idx-directions-city_id',
            'directions',
            'city_id'
        );

        $this->addForeignKey(
            'fk-directions-city_id',
            'directions',
            'city_id',
            'cities',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-directions-country_id',
            'directions',
            'country_id'
        );

        $this->addForeignKey(
            'fk-directions-country_id',
            'directions',
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
        $this->dropForeignKey(
            'fk-directions-city_id',
            'directions'
        );

        $this->dropIndex(
            'idx-directions-city_id',
            'directions'
        );

        $this->dropForeignKey(
            'fk-directions-country_id',
            'directions'
        );

        $this->dropIndex(
            'idx-directions-country_id',
            'directions'
        );

        $this->dropTable('{{%directions}}');
    }
}
