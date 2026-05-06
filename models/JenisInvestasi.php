<?php

namespace app\models;

use Yii;

/**
 * @property int $id
 * @property string $nama
 * @property Investasi[] $investasis
 */
class JenisInvestasi extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'jenis_investasi';
    }

    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['nama'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Jenis Investasi',
        ];
    }

    public function getInvestasis()
    {
        return $this->hasMany(Investasi::class, ['jenis_investasi_id' => 'id']);
    }
}
