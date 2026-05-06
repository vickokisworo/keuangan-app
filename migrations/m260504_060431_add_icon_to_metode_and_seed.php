<?php

use yii\db\Migration;

class m260504_060431_add_icon_to_metode_and_seed extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->getTableSchema('{{%metode}}');
        if (!isset($table->columns['icon'])) {
            $this->addColumn('{{%metode}}', 'icon', $this->string(50));
        }

        // Clear existing using delete to avoid truncate issues in some environments
        $this->delete('{{%metode}}');

        $this->batchInsert('{{%metode}}', ['nama', 'icon'], [
            ['Tunai', 'bi-cash-stack'],
            ['BRI', 'bi-bank'],
            ['BCA', 'bi-bank2'],
            ['Mandiri', 'bi-bank'],
            ['Dana', 'bi-phone'],
            ['OVO', 'bi-phone-fill'],
            ['Gopay', 'bi-wallet2'],
            ['ShopeePay', 'bi-bag-check'],
            ['Lainnya', 'bi-credit-card-2-back'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%metode}}');
        $this->dropColumn('{{%metode}}', 'icon');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260504_060431_add_icon_to_metode_and_seed cannot be reverted.\n";

        return false;
    }
    */
}
