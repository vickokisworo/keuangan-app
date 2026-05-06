<?php

use yii\db\Migration;

class m260504_063007_add_jumlah_topup_to_nilai_investasi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%nilai_investasi}}', 'jumlah_topup', $this->decimal(15, 2)->notNull()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%nilai_investasi}}', 'jumlah_topup');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260504_063007_add_jumlah_topup_to_nilai_investasi cannot be reverted.\n";

        return false;
    }
    */
}
