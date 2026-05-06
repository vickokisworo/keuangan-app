<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%transaksi}}`.
 */
class m260504_042854_create_transaksi_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transaksi}}', [
            'id' => $this->primaryKey(),
            'tanggal' => $this->date()->notNull(),
            'nominal' => $this->decimal(15, 2)->notNull(),
            'kategori_id' => $this->integer()->notNull(),
            'metode_id' => $this->integer()->notNull(),
            'keterangan' => $this->text(),
        ]);

        // creates index for column `kategori_id`
        $this->createIndex(
            '{{%idx-transaksi-kategori_id}}',
            '{{%transaksi}}',
            'kategori_id'
        );

        // add foreign key for table `{{%kategori}}`
        $this->addForeignKey(
            '{{%fk-transaksi-kategori_id}}',
            '{{%transaksi}}',
            'kategori_id',
            '{{%kategori}}',
            'id',
            'CASCADE'
        );

        // creates index for column `metode_id`
        $this->createIndex(
            '{{%idx-transaksi-metode_id}}',
            '{{%transaksi}}',
            'metode_id'
        );

        // add foreign key for table `{{%metode}}`
        $this->addForeignKey(
            '{{%fk-transaksi-metode_id}}',
            '{{%transaksi}}',
            'metode_id',
            '{{%metode}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%transaksi}}');
    }
}
