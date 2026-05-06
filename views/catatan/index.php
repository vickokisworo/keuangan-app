<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Catatan Pribadi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catatan-index">

    <?php $this->beginBlock('page-header'); ?>
    <div class="d-flex justify-content-between align-items-center w-100">
        <div>
            <h1 class="fw-bold mb-0 text-white"><?= Html::encode($this->title) ?></h1>
            <p class="text-white-50 mb-0">Simpan ide, rencana, atau catatan keuangan Anda di sini.</p>
        </div>
    </div>
    <?php $this->endBlock(); ?>

    <div class="d-flex justify-content-end mb-4">
        <?= Html::a('<i class="bi bi-plus-lg fs-4"></i>', ['create'], [
            'class' => 'btn btn-primary shadow-sm rounded-circle d-inline-flex align-items-center justify-content-center',
            'style' => 'width: 55px; height: 55px;',
            'title' => 'Tambah Catatan Baru'
        ]) ?>
    </div>

    <?php if ($dataProvider->totalCount > 0): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($dataProvider->getModels() as $model): ?>
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm rounded-4 hover-lift" style="transition: transform 0.2s;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title fw-bold mb-0 text-truncate pe-3" title="<?= Html::encode($model->judul) ?>">
                                    <?= Html::encode($model->judul) ?>
                                </h5>
                                <div class="dropdown">
                                    <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3">
                                        <li><?= Html::a('<i class="bi bi-pencil me-2"></i> Edit', ['update', 'id' => $model->id], ['class' => 'dropdown-item']) ?></li>
                                        <li>
                                            <?= Html::a('<i class="bi bi-trash me-2"></i> Hapus', ['delete', 'id' => $model->id], [
                                                'class' => 'dropdown-item text-danger',
                                                'data' => [
                                                    'confirm' => 'Apakah Anda yakin ingin menghapus catatan ini?',
                                                    'method' => 'post',
                                                ],
                                            ]) ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="text-muted small mb-3">
                                <i class="bi bi-clock me-1"></i> <?= Yii::$app->formatter->asRelativeTime($model->updated_at) ?>
                            </div>
                            <p class="card-text text-muted" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                <?= nl2br(Html::encode($model->isi)) ?>
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0 pb-3 px-3">
                            <?= Html::a('Buka Catatan', ['update', 'id' => $model->id], ['class' => 'btn btn-light btn-sm rounded-3 w-100 fw-semibold']) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-5 d-flex justify-content-center">
            <?= LinkPager::widget([
                'pagination' => $dataProvider->pagination,
                'options' => ['class' => 'pagination'],
                'linkContainerOptions' => ['class' => 'page-item'],
                'linkOptions' => ['class' => 'page-link'],
                'disabledPageCssClass' => 'disabled',
                'activePageCssClass' => 'active',
            ]) ?>
        </div>

    <?php else: ?>
        <div class="empty-state-container text-center d-flex flex-column justify-content-center align-items-center" style="min-height: 50vh;">
            <div style="width: 100px; height: 100px;">
                <i class="bi bi-journal-text display-3 text-muted opacity-50"></i>
            </div>
            <h4 class="fw-bold text-muted">Belum ada catatan</h4>
            <p class="text-muted small mb-4">Catatan Anda akan muncul di sini setelah Anda menambahkannya.</p>
        </div>
    <?php endif; ?>

</div>

<style>
.hover-lift:hover {
    transform: translateY(-5px);
}
</style>
