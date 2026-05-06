<?php

use yii\db\Migration;

class m260504_062159_create_investasi_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // 1. Tabel Jenis Investasi
        $this->createTable('{{%jenis_investasi}}', [
            'id' => $this->primaryKey(),
            'nama' => $this->string(50)->notNull(),
        ]);

        $this->batchInsert('{{%jenis_investasi}}', ['nama'], [
            ['Reksadana'],
            ['Saham'],
            ['Emas'],
            ['Obligasi'],
        ]);

        // 2. Tabel Investasi
        $this->createTable('{{%investasi}}', [
            'id' => $this->primaryKey(),
            'jenis_investasi_id' => $this->integer()->notNull(),
            'nama' => $this->string(100)->notNull(),
            'nominal_awal' => $this->decimal(15, 2)->notNull(),
            'tanggal_beli' => $this->date()->notNull(),
            'keterangan' => $this->text(),
        ]);

        $this->addForeignKey(
            'fk-investasi-jenis_id',
            '{{%investasi}}',
            'jenis_investasi_id',
            '{{%jenis_investasi}}',
            'id',
            'CASCADE'
        );

        // 3. Tabel Nilai Investasi (Historis)
        $this->createTable('{{%nilai_investasi}}', [
            'id' => $this->primaryKey(),
            'investasi_id' => $this->integer()->notNull(),
            'tanggal' => $this->date()->notNull(),
            'nilai_saat_ini' => $this->decimal(15, 2)->notNull(),
        ]);

        $this->addForeignKey(
            'fk-nilai_investasi-investasi_id',
            '{{%nilai_investasi}}',
            'investasi_id',
            '{{%investasi}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%nilai_investasi}}');
        $this->dropTable('{{%investasi}}');
        $this->dropTable('{{%jenis_investasi}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260504_062159_create_investasi_tables cannot be reverted.\n";

        return false;
    }
    */
}
