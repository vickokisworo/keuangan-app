<?php

use yii\db\Migration;

class m260506_123343_add_metode_id_to_investasi extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%investasi}}', 'metode_id', $this->integer());
        $this->addColumn('{{%nilai_investasi}}', 'metode_id', $this->integer());

        $this->addForeignKey(
            'fk-investasi-metode_id',
            '{{%investasi}}',
            'metode_id',
            '{{%metode}}',
            'id',
            'SET NULL'
        );

        $this->addForeignKey(
            'fk-nilai_investasi-metode_id',
            '{{%nilai_investasi}}',
            'metode_id',
            '{{%metode}}',
            'id',
            'SET NULL'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-nilai_investasi-metode_id', '{{%nilai_investasi}}');
        $this->dropForeignKey('fk-investasi-metode_id', '{{%investasi}}');
        $this->dropColumn('{{%nilai_investasi}}', 'metode_id');
        $this->dropColumn('{{%investasi}}', 'metode_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260506_123343_add_metode_id_to_investasi cannot be reverted.\n";

        return false;
    }
    */
}
