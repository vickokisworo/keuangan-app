<?php

namespace app\models;

use Yii;

/**
 * @property int $id
 * @property int $investasi_id
 * @property string $tanggal
 * @property float $nilai_saat_ini
 *
 * @property Investasi $investasi
 * @property Metode $metode
 */
class NilaiInvestasi extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'nilai_investasi';
    }

    public function rules()
    {
        return [
            [['investasi_id', 'tanggal', 'nilai_saat_ini', 'tipe'], 'required'],
            [['investasi_id', 'metode_id'], 'integer'],
            [['tanggal'], 'safe'],
            [['nilai_saat_ini', 'jumlah_topup'], 'number'],
            [['keterangan'], 'string'],
            [['tipe'], 'string', 'max' => 20],
            [['investasi_id'], 'exist', 'skipOnError' => true, 'targetClass' => Investasi::class, 'targetAttribute' => ['investasi_id' => 'id']],
            [['metode_id'], 'exist', 'skipOnError' => true, 'targetClass' => Metode::class, 'targetAttribute' => ['metode_id' => 'id']],
            [['jumlah_topup'], 'validateSaldo'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'investasi_id' => 'Investasi ID',
            'tanggal' => 'Tanggal',
            'nilai_saat_ini' => 'Nilai Saat Ini',
            'tipe' => 'Jenis Perubahan',
            'keterangan' => 'Keterangan',
            'jumlah_topup' => 'Jumlah Modal Tambahan',
            'metode_id' => 'Diambil Dari (Saldo)',
        ];
    }

    public function getInvestasi()
    {
        return $this->hasOne(Investasi::class, ['id' => 'investasi_id']);
    }

    public function getMetode()
    {
        return $this->hasOne(Metode::class, ['id' => 'metode_id']);
    }

    public function validateSaldo($attribute, $params)
    {
        if (!$this->hasErrors() && $this->jumlah_topup > 0) {
            $userId = $this->investasi->user_id ?? Yii::$app->user->id;
            
            if ($this->metode_id) {
                $saldo = Transaksi::getSaldoByMetode($userId, $this->metode_id);
            } else {
                $saldo = Transaksi::getSaldo($userId);
            }

            if ($this->jumlah_topup > $saldo) {
                $this->addError($attribute, 'Saldo tidak mencukupi untuk menambah modal ini. Saldo saat ini: Rp ' . number_format($saldo, 0, ',', '.'));
            }
        }
    }
}
