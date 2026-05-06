<?php

use app\models\Investasi;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Portofolio Investasi';
?>
<div class="investasi-index">

<?php $this->beginBlock('page-header'); ?>
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h1 class="fw-bold mb-0"><?= Html::encode($this->title) ?></h1>
        <p class="text-muted mb-0">Kelola aset investasi Anda (Saham, Reksadana, Obligasi, Emas).</p>
    </div>
</div>
<?php $this->endBlock(); ?>

<div class="d-flex justify-content-end mb-3">
    <?= Html::a('<i class="bi bi-plus-lg fs-4"></i>', ['create'], [
        'class' => 'btn btn-primary shadow-sm rounded-circle d-inline-flex align-items-center justify-content-center',
        'style' => 'width: 50px; height: 50px;',
        'title' => 'Tambah Investasi'
    ]) ?>
</div>

    <?php if ($dataProvider->totalCount > 0): ?>
        <div class="card border-0">
            <div class="card-body p-0">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-hover mb-0'],
                    'summary' => false,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'nama',
                            'contentOptions' => ['class' => 'fw-semibold'],
                        ],
                        [
                            'attribute' => 'jenis_investasi_id',
                            'value' => 'jenisInvestasi.nama',
                        ],
                        [
                            'attribute' => 'nominal_awal',
                            'value' => function($model) {
                                return 'Rp ' . number_format($model->nominal_awal, 0, ',', '.');
                            },
                        ],
                        [
                            'attribute' => 'tanggal_beli',
                            'format' => ['date', 'php:d M Y'],
                        ],
                        [
                            'class' => ActionColumn::className(),
                            'header' => 'Aksi',
                            'headerOptions' => ['style' => 'width: 120px; text-align: center;'],
                            'contentOptions' => ['style' => 'text-align: center;'],
                        'template' => '{topup} {view}',
                        'buttons' => [
                            'topup' => function ($url, $model) {
                                return Html::a('<i class="bi bi-plus-circle"></i>', ['view', 'id' => $model->id], [
                                    'class' => 'btn btn-sm btn-outline-success border-0',
                                    'title' => 'Top Up',
                                ]);
                            },
                            'view' => function ($url, $model) {
                                return Html::a('<i class="bi bi-eye"></i>', $url, [
                                    'class' => 'btn btn-sm btn-outline-info border-0',
                                    'title' => 'Detail',
                                ]);
                            },
                        ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    <?php else: ?>
        <div class="empty-state-container text-center d-flex flex-column justify-content-center align-items-center" style="min-height: 50vh;">
            <i class="bi bi-graph-up-arrow display-1 text-muted opacity-25 mb-3"></i>
            <h5 class="fw-bold text-muted">Belum ada data investasi</h5>
            <p class="text-muted small">Mulai catat aset investasi Anda dengan menekan tombol di atas.</p>
        </div>
    <?php endif; ?>

</div>
