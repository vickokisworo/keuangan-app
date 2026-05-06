<?php

use yii\db\Migration;

class m260504_043802_drop_nama_from_kategori extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%kategori}}', 'nama');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%kategori}}', 'nama', $this->string()->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260504_043802_drop_nama_from_kategori cannot be reverted.\n";

        return false;
    }
    */
}
