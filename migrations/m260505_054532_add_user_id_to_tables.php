<?php

use yii\db\Migration;

class m260505_054532_add_user_id_to_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Add user_id to transaksi
        $this->addColumn('{{%transaksi}}', 'user_id', $this->integer());
        $this->addForeignKey(
            'fk-transaksi-user_id',
            '{{%transaksi}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // Add user_id to investasi
        $this->addColumn('{{%investasi}}', 'user_id', $this->integer());
        $this->addForeignKey(
            'fk-investasi-user_id',
            '{{%investasi}}',
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
        $this->dropForeignKey('fk-transaksi-user_id', '{{%transaksi}}');
        $this->dropColumn('{{%transaksi}}', 'user_id');

        $this->dropForeignKey('fk-investasi-user_id', '{{%investasi}}');
        $this->dropColumn('{{%investasi}}', 'user_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260505_054532_add_user_id_to_tables cannot be reverted.\n";

        return false;
    }
    */
}
