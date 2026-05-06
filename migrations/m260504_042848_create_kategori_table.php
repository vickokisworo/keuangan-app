<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%kategori}}`.
 */
class m260504_042848_create_kategori_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%kategori}}', [
            'id' => $this->primaryKey(),
            'nama' => $this->string()->notNull(),
            'tipe' => $this->string()->notNull(), // pemasukan / pengeluaran
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%kategori}}');
    }
}
