<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%metode}}`.
 */
class m260504_042851_create_metode_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%metode}}', [
            'id' => $this->primaryKey(),
            'nama' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%metode}}');
    }
}
