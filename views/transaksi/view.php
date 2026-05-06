<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Transaksi $model */

$this->title = 'Detail Transaksi #' . $model->id;
// Dapatkan relasi metode
$metode = $model->metode_id ? \app\models\Metode::findOne($model->metode_id) : null;
$metodeName = $metode ? '<i class="bi ' . $metode->icon . ' me-2 text-primary"></i>' . $metode->nama : '<span class="text-muted">Tidak ada metode</span>';

// Tentukan warna berdasarkan tipe
$isPemasukan = $model->tipe === 'pemasukan';
$colorClass = $isPemasukan ? 'success' : 'danger';
$iconClass = $isPemasukan ? 'bi-arrow-down-circle-fill' : 'bi-arrow-up-circle-fill';
$tipeLabel = $isPemasukan ? 'Pemasukan' : 'Pengeluaran';
?>

<div class="transaksi-view">

    <div class="d-flex justify-content-between align-items-center py-3 mb-1">
        <div>
            <h1 class="fw-bold mb-0">Detail Transaksi</h1>
            <p class="text-muted mb-0">Rincian data transaksi Anda.</p>
        </div>
        <div>
            <?= Html::a('<i class="bi bi-arrow-left"></i> Kembali', ['index', 'tipe' => $model->tipe], ['class' => 'btn btn-light border shadow-sm']) ?>
        </div>
    </div>

    <div class="row justify-content-center mt-3">
        <div class="col-md-8 col-lg-6">
            <div class="card p-4 text-center mb-4 border-0" style="background: linear-gradient(135deg, rgba(255,255,255,1) 0%, rgba(248,250,252,1) 100%);">
                <div class="mb-3">
                    <i class="bi <?= $iconClass ?> text-<?= $colorClass ?>" style="font-size: 3rem;"></i>
                </div>
                <h5 class="text-muted fw-semibold mb-1"><?= $tipeLabel ?></h5>
                <h2 class="fw-bold text-<?= $colorClass ?> mb-0">
                    <?= $isPemasukan ? '+' : '-' ?> Rp <?= number_format($model->nominal ?? 0, 0, ',', '.') ?>
                </h2>
            </div>

            <div class="card border-0 p-4">
                <h5 class="fw-bold mb-4">Informasi Lengkap</h5>
                
                <div class="d-flex justify-content-between border-bottom pb-3 mb-3">
                    <span class="text-muted">Tanggal</span>
                    <span class="fw-semibold"><?= Yii::$app->formatter->asDate($model->tanggal, 'php:d F Y') ?></span>
                </div>

                <div class="d-flex justify-content-between border-bottom pb-3 mb-3">
                    <span class="text-muted">Metode Pembayaran</span>
                    <span class="fw-semibold"><?= $metodeName ?></span>
                </div>

                <div class="d-flex flex-column border-bottom pb-3 mb-4">
                    <span class="text-muted mb-1">Catatan / Keterangan</span>
                    <span class="fw-semibold"><?= $model->keterangan ? Html::encode($model->keterangan) : '<em class="text-muted fw-normal">Tidak ada catatan</em>' ?></span>
                </div>

                <div class="d-flex gap-2">
                    <?= Html::a('<i class="bi bi-trash"></i> Hapus', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger flex-grow-1 shadow-sm',
                        'data' => [
                            'confirm' => 'Apakah Anda yakin ingin menghapus data transaksi ini?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>
