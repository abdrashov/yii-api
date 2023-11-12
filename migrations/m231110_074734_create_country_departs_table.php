<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%country_departs}}`.
 */
class m231110_074734_create_country_departs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%country_departs}}', [
            'country_id' => $this->integer()->notNull(),
            'depart' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-unique-country_departs-country_id-depart',
            'country_departs',
            'country_id, depart',
            true
        );

        $this->addForeignKey(
            'fk-country_departs-country_id',
            'country_departs',
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
            'fk-country_departs-country_id',
            'country_departs'
        );

        $this->dropIndex(
            'idx-unique-country_departs-country_id-depart',
            'country_departs'
        );

        $this->dropTable('{{%country_departs}}');
    }
}
