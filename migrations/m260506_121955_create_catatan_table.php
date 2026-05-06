<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%catatan}}`.
 */
class m260506_121955_create_catatan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%catatan}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'judul' => $this->string()->notNull(),
            'isi' => $this->text(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-catatan-user_id',
            '{{%catatan}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%catatan}}');
    }
}
