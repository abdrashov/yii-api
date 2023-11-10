<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%direction_days}}`.
 */
class m231110_075016_create_direction_days_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%direction_days}}', [
            'direction_id' => $this->integer()->notNull(),
            'day' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-direction_days-direction_id',
            'direction_days',
            'direction_id'
        );

        $this->addForeignKey(
            'fk-direction_days-direction_id',
            'direction_days',
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
            'fk-direction_days-direction_id',
            'direction_days'
        );

        $this->dropIndex(
            'idx-direction_days-direction_id',
            'direction_days'
        );

        $this->dropTable('{{%direction_days}}');
    }
}
