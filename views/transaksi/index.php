<?php

use app\models\Transaksi;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var string|null $tipe */

$this->title = $tipe ? 'Daftar ' . ucfirst($tipe) : 'Semua Transaksi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaksi-index">

<?php $this->beginBlock('page-header'); ?>
<div class="d-flex justify-content-between align-items-center w-100">
    <div>
        <h1 class="fw-bold mb-0"><?= Html::encode($this->title) ?></h1>
        <p class="text-muted mb-0">Riwayat transaksi keuangan Anda.</p>
    </div>
</div>
<?php $this->endBlock(); ?>

<div class="d-flex justify-content-end mb-3">
    <?= Html::a('<i class="bi bi-plus-lg fs-4"></i>', ['create', 'tipe' => Yii::$app->request->get('tipe')], [
        'class' => 'btn btn-primary shadow-sm rounded-circle d-inline-flex align-items-center justify-content-center',
        'style' => 'width: 50px; height: 50px;',
        'title' => 'Tambah Data'
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
                            'attribute' => 'tanggal',
                            'format' => ['date', 'php:d M Y'],
                        ],
                        [
                            'attribute' => 'nominal',
                            'value' => function($model) {
                                return 'Rp ' . number_format($model->nominal, 0, ',', '.');
                            },
                        ],
                        'keterangan:ntext',
                        [
                            'attribute' => 'metode_id',
                            'value' => 'metode.nama',
                        ],
                        [
                            'class' => ActionColumn::className(),
                            'header' => 'Aksi',
                            'headerOptions' => ['style' => 'width: 120px; text-align: center;'],
                            'contentOptions' => ['style' => 'text-align: center;'],
                            'template' => '{view}',
                            'buttons' => [
                                'view' => function ($url, $model) {
                                    return Html::a('<i class="bi bi-eye"></i>', $url, [
                                        'class' => 'btn btn-sm btn-outline-info border-0',
                                        'title' => 'Lihat Detail',
                                    ]);
                                },
                            ],
                            'urlCreator' => function ($action, Transaksi $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                             }
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    <?php else: ?>
        <div class="empty-state-container text-center d-flex flex-column justify-content-center align-items-center" style="min-height: 50vh;">
            <i class="bi bi-folder2-open display-1 text-muted opacity-25 mb-3"></i>
            <h5 class="fw-bold text-muted">Belum ada data <?= strtolower($this->title) ?></h5>
            <p class="text-muted small">Mulai tambahkan transaksi Anda dengan menekan tombol di atas.</p>
        </div>
    <?php endif; ?>
</div>
