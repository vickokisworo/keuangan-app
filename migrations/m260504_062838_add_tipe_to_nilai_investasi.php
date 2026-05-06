<?php

use yii\db\Migration;

class m260504_062838_add_tipe_to_nilai_investasi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%nilai_investasi}}', 'tipe', $this->string(20)->notNull()->defaultValue('update')); // 'update' atau 'topup'
        $this->addColumn('{{%nilai_investasi}}', 'keterangan', $this->text());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%nilai_investasi}}', 'keterangan');
        $this->dropColumn('{{%nilai_investasi}}', 'tipe');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260504_062838_add_tipe_to_nilai_investasi cannot be reverted.\n";

        return false;
    }
    */
}
