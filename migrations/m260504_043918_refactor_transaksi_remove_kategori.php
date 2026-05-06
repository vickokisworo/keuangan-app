<?php

use yii\db\Migration;

class m260504_043918_refactor_transaksi_remove_kategori extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Drop FK and index first
        $this->dropForeignKey('{{%fk-transaksi-kategori_id}}', '{{%transaksi}}');
        $this->dropIndex('{{%idx-transaksi-kategori_id}}', '{{%transaksi}}');
        
        // Remove kategori_id column
        $this->dropColumn('{{%transaksi}}', 'kategori_id');
        
        // Add tipe column
        $this->addColumn('{{%transaksi}}', 'tipe', $this->string(20)->notNull()->defaultValue('pemasukan'));
        
        // Drop kategori table
        $this->dropTable('{{%kategori}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('{{%kategori}}', [
            'id' => $this->primaryKey(),
            'tipe' => $this->string()->notNull(),
        ]);

        $this->addColumn('{{%transaksi}}', 'kategori_id', $this->integer());
        $this->dropColumn('{{%transaksi}}', 'tipe');

        $this->createIndex(
            '{{%idx-transaksi-kategori_id}}',
            '{{%transaksi}}',
            'kategori_id'
        );

        $this->addForeignKey(
            '{{%fk-transaksi-kategori_id}}',
            '{{%transaksi}}',
            'kategori_id',
            '{{%kategori}}',
            'id',
            'CASCADE'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260504_043918_refactor_transaksi_remove_kategori cannot be reverted.\n";

        return false;
    }
    */
}
