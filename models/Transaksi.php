<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaksi".
 *
 * @property int $id
 * @property int $user_id
 * @property string $tanggal
 * @property float $nominal
 * @property string $tipe
 * @property int $metode_id
 * @property string|null $keterangan
 *
 * @property User $user
 * @property Metode $metode
 */
class Transaksi extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaksi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['keterangan'], 'default', 'value' => null],
            [['tanggal', 'nominal', 'tipe', 'metode_id', 'user_id'], 'required'],
            [['tanggal', 'tipe'], 'safe'],
            [['nominal'], 'number', 'min' => 0],
            [['metode_id', 'user_id'], 'default', 'value' => null],
            [['metode_id', 'user_id'], 'integer'],
            [['tipe'], 'string', 'max' => 20],
            [['keterangan'], 'string'],
            [['metode_id'], 'exist', 'skipOnError' => true, 'targetClass' => Metode::class, 'targetAttribute' => ['metode_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tanggal' => 'Tanggal',
            'nominal' => 'Nominal',
            'tipe' => 'Tipe',
            'metode_id' => 'Metode ID',
            'keterangan' => 'Keterangan',
        ];
    }

    /**
     * Gets query for [[Metode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMetode()
    {
        return $this->hasOne(Metode::class, ['id' => 'metode_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public static function getSaldo($userId)
    {
        $totalPemasukan = self::find()
            ->where(['tipe' => 'pemasukan', 'user_id' => $userId])
            ->sum('nominal') ?? 0;

        $totalPengeluaran = self::find()
            ->where(['tipe' => 'pengeluaran', 'user_id' => $userId])
            ->sum('nominal') ?? 0;

        $totalInvestasiAwal = Investasi::find()
            ->where(['user_id' => $userId])
            ->sum('nominal_awal') ?? 0;

        $totalInvestasiTopup = NilaiInvestasi::find()
            ->joinWith('investasi')
            ->where(['investasi.user_id' => $userId])
            ->sum('jumlah_topup') ?? 0;

        return $totalPemasukan - $totalPengeluaran - $totalInvestasiAwal - $totalInvestasiTopup;
    }

    public static function getSaldoByMetode($userId, $metodeId)
    {
        $transaksi = self::find()
            ->where(['user_id' => $userId, 'metode_id' => $metodeId])
            ->sum('CASE WHEN tipe = \'pemasukan\' THEN nominal ELSE -nominal END') ?? 0;

        $investasiAwal = Investasi::find()
            ->where(['user_id' => $userId, 'metode_id' => $metodeId])
            ->sum('nominal_awal') ?? 0;

        $investasiTopup = NilaiInvestasi::find()
            ->joinWith('investasi')
            ->where(['investasi.user_id' => $userId, 'nilai_investasi.metode_id' => $metodeId])
            ->sum('jumlah_topup') ?? 0;

        return $transaksi - $investasiAwal - $investasiTopup;
    }
}
