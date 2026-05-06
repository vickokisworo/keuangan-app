<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Catatan $model */

$this->title = 'Tambah Catatan Baru';
$this->params['breadcrumbs'][] = ['label' => 'Catatan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catatan-create">

    <?php $this->beginBlock('page-header'); ?>
    <div class="d-flex justify-content-between align-items-center w-100">
        <div>
            <h1 class="fw-bold mb-0 text-white"><?= Html::encode($this->title) ?></h1>
            <p class="text-white-50 mb-0">Tulis ide atau rencana baru Anda.</p>
        </div>
    </div>
    <?php $this->endBlock(); ?>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>
