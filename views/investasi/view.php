<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use app\models\NilaiInvestasi;

/** @var yii\web\View $this */
/** @var app\models\Investasi $model */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Investasi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$modalTotal = $model->getModalTotal();
?>
<div class="investasi-view">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-0"><?= Html::encode($this->title) ?></h1>
            <span class="badge bg-primary rounded-pill"><?= $model->jenisInvestasi->nama ?></span>
        </div>
        <div>
            <?= Html::a('<i class="bi bi-trash"></i> Hapus', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-outline-danger',
                'data' => [
                    'confirm' => 'Apakah Anda yakin ingin menghapus investasi ini?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <div class="row g-4">
        <!-- Summary Card -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: white;">
                <div class="card-body p-4">
                    <h6 class="text-uppercase fw-bold opacity-75 small mb-3">Total Saldo Investasi</h6>
                    <h2 class="fw-bold mb-0">Rp <?= number_format((float)($modalTotal ?? 0), 0, ',', '.') ?></h2>
                    <p class="opacity-75 small mt-2 mb-0">Modal awal + Semua modal tambahan</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Informasi Tambahan</h5>
                    <?= DetailView::widget([
                        'model' => $model,
                        'options' => ['class' => 'table table-borderless mb-0'],
                        'attributes' => [
                            [
                                'attribute' => 'tanggal_beli',
                                'format' => ['date', 'php:d F Y'],
                            ],
                            'keterangan:ntext',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Riwayat Modal Tambahan (Top-up)</h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jumlah Top Up</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $history = $model->getNilaiInvestasis()->where(['tipe' => 'topup'])->orderBy(['tanggal' => SORT_DESC, 'id' => SORT_DESC])->all();
                                ?>
                                <tr>
                                    <td><?= date('d M Y', strtotime($model->tanggal_beli)) ?></td>
                                    <td class="fw-bold">Rp <?= number_format((float)$model->nominal_awal, 0, ',', '.') ?></td>
                                    <td class="text-muted small">Modal Awal</td>
                                </tr>
                                <?php foreach ($history as $h): ?>
                                    <tr>
                                        <td><?= date('d M Y', strtotime($h->tanggal)) ?></td>
                                        <td class="fw-bold text-success">+ Rp <?= number_format((float)$h->jumlah_topup, 0, ',', '.') ?></td>
                                        <td class="text-muted small"><?= Html::encode($h->keterangan) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Tambah Modal (Top-up)</h5>
                    
                    <?php 
                    $newNilai = new NilaiInvestasi();
                    $form = ActiveForm::begin(['action' => ['update-nilai', 'id' => $model->id]]); ?>

                    <?= Html::activeHiddenInput($newNilai, 'tipe', ['value' => 'topup']) ?>
                    
                    <!-- Nilai saat ini disamakan dengan jumlah topup agar query saldo tetap jalan jika diperlukan -->
                    <?= Html::activeHiddenInput($newNilai, 'nilai_saat_ini', ['value' => 0]) ?>

                    <?= $form->field($newNilai, 'tanggal')->input('date', ['value' => date('Y-m-d')]) ?>

                    <?= $form->field($newNilai, 'jumlah_topup')->textInput(['type' => 'number', 'placeholder' => 'Jumlah modal yang ditambah'])->label('Nominal Top Up') ?>

                    <?= $form->field($newNilai, 'metode_id')->dropDownList(
                        \yii\helpers\ArrayHelper::map(\app\models\Metode::find()->all(), 'id', 'nama'),
                        ['prompt' => 'Pilih Sumber Saldo', 'class' => 'form-control bg-white']
                    ) ?>

                    <?= $form->field($newNilai, 'keterangan')->textarea(['rows' => 3, 'placeholder' => 'Catatan singkat...']) ?>

                    <div class="d-grid mt-3">
                        <?= Html::submitButton('<i class="bi bi-plus-circle me-2"></i> Tambah Modal', ['class' => 'btn btn-primary btn-lg']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

</div>
