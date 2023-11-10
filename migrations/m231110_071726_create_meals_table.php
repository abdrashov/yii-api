<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%meals}}`.
 */
class m231110_071726_create_meals_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%meals}}', [
            'id' => $this->primaryKey(),
            'api_id' => $this->integer(),
            'name' => $this->string()->notNull(),
        ]);

        $this->createIndex(
            'idx-meals-api_id',
            'meals',
            'api_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-meals-api_id',
            'meals'
        );

        $this->dropTable('{{%meals}}');
    }
}
