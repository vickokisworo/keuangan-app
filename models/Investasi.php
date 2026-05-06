<?php

namespace app\models;

use Yii;

/**
 * @property int $id
 * @property int $user_id
 * @property int $jenis_investasi_id
 * @property string $nama
 * @property float $nominal_awal
 * @property string $tanggal_beli
 * @property string|null $keterangan
 * @property int|null $metode_id
 *
 * @property User $user
 * @property Metode $metode
 * @property JenisInvestasi $jenisInvestasi
 * @property NilaiInvestasi[] $nilaiInvestasis
 */
class Investasi extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'investasi';
    }

    public function rules()
    {
        return [
            [['jenis_investasi_id', 'nama', 'nominal_awal', 'tanggal_beli', 'user_id'], 'required'],
            [['jenis_investasi_id', 'user_id', 'metode_id'], 'integer'],
            [['nominal_awal'], 'number', 'min' => 0],
            [['tanggal_beli'], 'safe'],
            [['keterangan'], 'string'],
            [['nama'], 'string', 'max' => 100],
            [['jenis_investasi_id'], 'exist', 'skipOnError' => true, 'targetClass' => JenisInvestasi::class, 'targetAttribute' => ['jenis_investasi_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['metode_id'], 'exist', 'skipOnError' => true, 'targetClass' => Metode::class, 'targetAttribute' => ['metode_id' => 'id']],
            [['nominal_awal'], 'validateSaldo'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jenis_investasi_id' => 'Jenis Investasi',
            'nama' => 'Nama Investasi',
            'nominal_awal' => 'Nominal Awal',
            'tanggal_beli' => 'Tanggal Beli',
            'keterangan' => 'Keterangan',
            'metode_id' => 'Diambil Dari (Saldo)',
        ];
    }

    public function getJenisInvestasi()
    {
        return $this->hasOne(JenisInvestasi::class, ['id' => 'jenis_investasi_id']);
    }

    public function getNilaiInvestasis()
    {
        return $this->hasMany(NilaiInvestasi::class, ['investasi_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getMetode()
    {
        return $this->hasOne(Metode::class, ['id' => 'metode_id']);
    }
    
    public function getNilaiTerbaru()
    {
        return NilaiInvestasi::find()
            ->where(['investasi_id' => $this->id])
            ->orderBy(['tanggal' => SORT_DESC, 'id' => SORT_DESC])
            ->one();
    }

    public function getModalTotal()
    {
        $topups = NilaiInvestasi::find()
            ->where(['investasi_id' => $this->id])
            ->sum('jumlah_topup') ?? 0;
        return $this->nominal_awal + $topups;
    }

    public function validateSaldo($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if ($this->metode_id) {
                $saldo = Transaksi::getSaldoByMetode($this->user_id, $this->metode_id);
            } else {
                $saldo = Transaksi::getSaldo($this->user_id);
            }

            if ($this->nominal_awal > $saldo) {
                $this->addError($attribute, 'Saldo tidak mencukupi untuk investasi ini. Saldo saat ini: Rp ' . number_format($saldo, 0, ',', '.'));
            }
        }
    }
}
