<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Daftar Akun';
?>
<div class="site-signup d-flex align-items-center justify-content-center mt-md-5 mt-3">
    <div class="card border-0 shadow-sm rounded-4 w-100" style="max-width: 400px;">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <i class="bi bi-person-plus text-primary" style="font-size: 3rem;"></i>
                <h3 class="fw-bold mt-2 mb-0"><?= Html::encode($this->title) ?></h3>
                <p class="text-muted small mt-1">Buat akun baru untuk memulai</p>
            </div>

            <?php $form = ActiveForm::begin([
                'id' => 'form-signup',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'form-label fw-semibold small text-secondary'],
                    'inputOptions' => ['class' => 'form-control form-control-lg rounded-3 fs-6'],
                    'errorOptions' => ['class' => 'invalid-feedback small'],
                ],
            ]); ?>

                <div class="mb-3">
                    <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Pilih username']) ?>
                </div>

                <div class="mb-3">
                    <?= $form->field($model, 'email')->textInput(['placeholder' => 'Alamat email']) ?>
                </div>

                <div class="mb-4">
                    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Buat password']) ?>
                </div>

                <div class="d-grid gap-2 mb-4">
                    <?= Html::submitButton('Daftar Sekarang', ['class' => 'btn btn-primary btn-lg rounded-pill fw-semibold', 'name' => 'signup-button']) ?>
                </div>

                <div class="text-center mt-4">
                    <p class="text-muted small mb-0">
                        Sudah punya akun? 
                        <?= Html::a('Login di sini', ['site/login'], ['class' => 'text-primary fw-semibold text-decoration-none']) ?>
                    </p>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
