<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Catatan $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="catatan-form">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-4 p-md-5">
            <?php $form = ActiveForm::begin([
                'id' => 'catatan-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'form-label fw-bold mb-2'],
                    'inputOptions' => ['class' => 'form-control rounded-3 py-2 px-3'],
                    'errorOptions' => ['class' => 'invalid-feedback'],
                ],
            ]); ?>

            <?= $form->field($model, 'judul')->textInput(['maxlength' => true, 'placeholder' => 'Masukkan judul catatan...']) ?>

            <?= $form->field($model, 'isi')->textarea(['rows' => 10, 'placeholder' => 'Tulis isi catatan Anda di sini...', 'style' => 'resize: none;']) ?>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                <?= Html::a('Batal', ['index'], ['class' => 'btn btn-light rounded-pill px-4 fw-semibold']) ?>
                <?= Html::submitButton($model->isNewRecord ? 'Simpan Catatan' : 'Simpan Perubahan', ['class' => 'btn btn-primary rounded-pill px-5 fw-semibold shadow-sm']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
