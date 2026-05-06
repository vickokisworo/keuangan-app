<?php

use yii\db\Migration;

class m260505_054857_clear_transaction_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->delete('{{%transaksi}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m260505_054857_clear_transaction_data cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260505_054857_clear_transaction_data cannot be reverted.\n";

        return false;
    }
    */
}
