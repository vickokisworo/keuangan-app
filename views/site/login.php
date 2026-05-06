<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Sign In';
?>
<div class="site-login d-flex align-items-center justify-content-center mt-md-5 mt-3">
    <div class="card border-0 shadow-sm rounded-4 w-100" style="max-width: 400px;">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <i class="bi bi-intersect text-primary" style="font-size: 3rem;"></i>
                <h3 class="fw-bold mt-2 mb-0"><?= Html::encode($this->title) ?></h3>
                <p class="text-muted small mt-1">Masuk ke akun keuangan Anda</p>
            </div>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'form-label fw-semibold small text-secondary'],
                    'inputOptions' => ['class' => 'form-control form-control-lg rounded-3 fs-6'],
                    'errorOptions' => ['class' => 'invalid-feedback small'],
                ],
            ]); ?>

            <div class="mb-3">
                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Username']) ?>
            </div>

            <div class="mb-3">
                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password']) ?>
            </div>

            <div class="mb-4 d-flex justify-content-between align-items-center">
                <?= $form->field($model, 'rememberMe', [
                    'options' => ['class' => 'mb-0']
                ])->checkbox([
                    'template' => "<div class=\"form-check\">\n{input}\n<label class=\"form-check-label small text-secondary\" for=\"loginform-rememberme\">Ingat Saya</label>\n</div>",
                    'class' => 'form-check-input'
                ])->label(false) ?>
            </div>

            <div class="d-grid gap-2 mb-4">
                <?= Html::submitButton('Masuk Sekarang', ['class' => 'btn btn-primary btn-lg rounded-pill fw-semibold', 'name' => 'login-button']) ?>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted small mb-0">
                    Belum punya akun? 
                    <?= Html::a('Daftar di sini', ['site/signup'], ['class' => 'text-primary fw-semibold text-decoration-none']) ?>
                </p>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
