<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%direction_dates}}`.
 */
class m231110_075027_create_direction_dates_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%direction_dates}}', [
            'direction_id' => $this->integer()->notNull(),
            'date' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-direction_dates-direction_id',
            'direction_dates',
            'direction_id'
        );

        $this->addForeignKey(
            'fk-direction_dates-direction_id',
            'direction_dates',
            'direction_id',
            'directions',
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
            'fk-direction_dates-direction_id',
            'direction_dates'
        );

        $this->dropIndex(
            'idx-direction_dates-direction_id',
            'direction_dates'
        );
        
        $this->dropTable('{{%direction_dates}}');
    }
}
