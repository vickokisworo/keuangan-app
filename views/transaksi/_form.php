<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Metode;

/** @var yii\web\View $this */
/** @var app\models\Transaksi $model */
/** @var yii\widgets\ActiveForm $form */

// Ambil data metode untuk keperluan display di button
$selectedMetode = $model->metode_id ? Metode::findOne($model->metode_id) : null;
$buttonLabel = $selectedMetode ? '<i class="bi ' . $selectedMetode->icon . ' me-2"></i>' . $selectedMetode->nama : '<i class="bi bi-wallet2 me-2"></i> Pilih Metode Pembayaran';
?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm p-4">
            <div class="card-body">
                <h4 class="fw-bold mb-4">Informasi Transaksi</h4>

                <?php $form = ActiveForm::begin([
                    'id' => 'transaksi-form',
                    'fieldConfig' => [
                        'template' => "{label}\n{input}\n{error}",
                        'labelOptions' => ['class' => 'form-label fw-semibold'],
                        'inputOptions' => ['class' => 'form-control bg-white'], // Background putih biasa
                    ],
                ]); ?>

                <div class="row g-3">
                    <div class="col-md-6">
                        <?= $form->field($model, 'tanggal')->input('date') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'tipe')->dropDownList([
                            'pemasukan' => 'Pemasukan',
                            'pengeluaran' => 'Pengeluaran',
                        ], [
                            'prompt' => 'Pilih Tipe',
                            'disabled' => $model->tipe !== null,
                            'class' => 'form-control bg-white', // Gunakan form-control untuk menghilangkan panah
                        ]) ?>
                        <?php if ($model->tipe !== null): ?>
                            <?= Html::activeHiddenInput($model, 'tipe') ?>
                        <?php endif; ?>
                    </div>
                </div>

                <?= $form->field($model, 'nominal', [
                    'template' => "{label}\n<div class='input-group'><span class='input-group-text bg-white'>Rp</span>{input}</div>\n{error}",
                ])->textInput(['type' => 'number', 'placeholder' => '0', 'min' => 0]) ?>

                <!-- Custom Metode Selector -->
                <div class="mb-4">
                    <label class="form-label fw-semibold d-block">Metode Pembayaran</label>
                    <button type="button" id="btn-metode-toggle" class="btn btn-white border w-100 p-3 text-start d-flex justify-content-between align-items-center" style="border-radius: 12px; background-color: #fff;">
                        <span id="selected-metode-label"><?= $buttonLabel ?></span>
                        <i class="bi bi-chevron-down"></i>
                    </button>
                    
                    <div id="metode-list-container" class="mt-3 p-3 border rounded-4 bg-white shadow-sm" style="display: none;">
                        <?= $form->field($model, 'metode_id')->radioList(
                            ArrayHelper::map(Metode::find()->all(), 'id', function($m) {
                                return '<i class="bi ' . $m->icon . ' fs-4 d-block mb-1"></i>' . $m->nama;
                            }),
                            [
                                'item' => function ($index, $label, $name, $checked, $value) {
                                    return '<div class="form-check form-check-inline p-0 m-0 me-2 mb-2">
                                        <input type="radio" name="' . $name . '" value="' . $value . '" id="metode-' . $value . '" class="btn-check metode-radio-input" ' . ($checked ? 'checked' : '') . ' data-label="' . htmlspecialchars($label) . '">
                                        <label class="btn btn-outline-primary p-3 text-center ' . ($checked ? 'active' : '') . '" for="metode-' . $value . '" style="min-width: 90px; border-radius: 12px; font-size: 0.8rem;">
                                            ' . $label . '
                                        </label>
                                    </div>';
                                },
                                'encode' => false,
                            ]
                        )->label(false) ?>
                    </div>
                </div>

                <?= $form->field($model, 'keterangan')->textarea(['rows' => 3, 'placeholder' => 'Catatan opsional...', 'class' => 'form-control bg-white']) ?>

                <div class="d-flex gap-2 mt-4">
                    <?= Html::submitButton('Simpan Transaksi', ['class' => 'btn btn-primary flex-grow-1 shadow-sm']) ?>
                    <?= Html::a('Batal', ['index', 'tipe' => $model->tipe], ['class' => 'btn btn-light border flex-grow-1']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
$('#btn-metode-toggle').on('click', function() {
    $('#metode-list-container').slideToggle(200);
    $(this).find('.bi-chevron-down').toggleClass('bi-chevron-up');
});

$('.metode-radio-input').on('change', function() {
    var label = $(this).data('label');
    $('#selected-metode-label').html(label.replace('fs-4 d-block mb-1', 'me-2'));
    $('#metode-list-container').slideUp(200);
    $('#btn-metode-toggle').find('.bi-chevron-down').removeClass('bi-chevron-up');
    $('#btn-metode-toggle').addClass('border-primary text-primary');
});
JS;
$this->registerJs($script);
?>

<style>
/* Menghilangkan hover effect default yang tidak diinginkan */
.btn-white:hover {
    background-color: #fff !important;
    color: inherit;
}
#btn-metode-toggle {
    border-color: #dee2e6 !important;
    color: #212529;
}
#btn-metode-toggle.border-primary {
    border-color: var(--primary) !important;
}
</style>
