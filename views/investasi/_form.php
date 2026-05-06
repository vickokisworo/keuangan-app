<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\JenisInvestasi;

/** @var yii\web\View $this */
/** @var app\models\Investasi $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm p-4">
            <div class="card-body">
                <h4 class="fw-bold mb-4"><?= $model->isNewRecord ? 'Catat Investasi Baru' : 'Ubah Data Investasi' ?></h4>

                <?php $form = ActiveForm::begin([
                    'fieldConfig' => [
                        'template' => "{label}\n{input}\n{error}",
                        'labelOptions' => ['class' => 'form-label fw-semibold'],
                        'inputOptions' => ['class' => 'form-control bg-white'],
                    ],
                ]); ?>

                <div class="row g-3">
                    <div class="col-md-6">
                        <?= $form->field($model, 'jenis_investasi_id')->dropDownList(
                            ArrayHelper::map(JenisInvestasi::find()->all(), 'id', 'nama'),
                            ['prompt' => 'Pilih Jenis', 'class' => 'form-control bg-white']
                        ) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'tanggal_beli')->input('date') ?>
                    </div>
                </div>

                <?= $form->field($model, 'nama')->textInput(['maxlength' => true, 'placeholder' => 'Misal: SBN ST010, Saham BBCA, dll']) ?>

                <?= $form->field($model, 'nominal_awal', [
                    'template' => "{label}\n<div class='input-group'><span class='input-group-text bg-white'>Rp</span>{input}</div>\n{error}",
                ])->textInput(['type' => 'number', 'placeholder' => '0', 'min' => 0]) ?>

                <?= $form->field($model, 'metode_id')->dropDownList(
                    ArrayHelper::map(\app\models\Metode::find()->all(), 'id', 'nama'),
                    ['prompt' => 'Pilih Sumber Saldo', 'class' => 'form-control bg-white']
                ) ?>

                <?= $form->field($model, 'keterangan')->textarea(['rows' => 3, 'placeholder' => 'Catatan opsional...']) ?>

                <div class="d-flex gap-2 mt-4">
                    <?= Html::submitButton('Simpan Investasi', ['class' => 'btn btn-primary flex-grow-1 shadow-sm']) ?>
                    <?= Html::a('Batal', ['index'], ['class' => 'btn btn-light border flex-grow-1']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
