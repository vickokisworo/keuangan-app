<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => Yii::getAlias('@web/img/favicon_square.png')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <?php $this->head() ?>
    <style>
        @media (max-width: 768px) {
            body {
                padding-bottom: 100px !important;
            }
            .main-bottom-nav {
                bottom: 0 !important;
                position: fixed !important;
            }
        }
    </style>
</head>
<body class="d-flex flex-column">
<?php $this->beginBody() ?>

<?php if (isset($this->blocks['page-header'])): ?>
    <div class="bg-white border-bottom shadow-sm mb-4">
        <div class="container py-3">
            <div class="row align-items-center">
                <!-- Bagian Kiri (Info Page & Mobile Header) -->
                <div class="col-md-5 mb-3 mb-md-0">
                    <!-- Mobile Header (Logo Kiri, Profile Kanan) -->
                    <div class="d-flex d-md-none align-items-center justify-content-between mb-3">
                        <a href="<?= Yii::$app->homeUrl ?>" class="text-decoration-none">
                            <img src="<?= Yii::getAlias('@web/img/logoPutih.png') ?>" alt="Finora" style="height: 40px; width: auto; object-fit: contain;">
                        </a>

                        <?php if (!Yii::$app->user->isGuest): ?>
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none" id="profileDropdownMobile" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px; background: rgba(255,255,255,0.2);">
                                    <i class="bi bi-person-fill fs-5"></i>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-4 mt-2" aria-labelledby="profileDropdownMobile">
                                <li class="px-4 py-3 border-bottom mb-2 text-center bg-light rounded-top-4">
                                    <div class="fw-bold" style="color: #000 !important;"><?= Html::encode(Yii::$app->user->identity->username) ?></div>
                                    <div class="small" style="color: #000 !important;"><?= Html::encode(Yii::$app->user->identity->email) ?></div>
                                </li>
                                <li>
                                    <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'px-2 pb-2 m-0']) ?>
                                    <?= Html::submitButton(
                                        '<i class="bi bi-box-arrow-right me-2"></i> Logout',
                                        ['class' => 'dropdown-item text-danger rounded-3 py-2 fw-semibold d-flex align-items-center']
                                    ) ?>
                                    <?= Html::endForm() ?>
                                </li>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Info Page (Dibawah logo pada mobile) -->
                    <div class="w-100" style="color: white;">
                        <?= $this->blocks['page-header'] ?>
                    </div>
                </div>

                <!-- Kanan: Logo & Nav Menu -->
                <div class="col-md-7 d-none d-md-flex flex-column align-items-end justify-content-center">
                    <!-- Logo & Profile di atas -->
                    <div class="d-flex align-items-center justify-content-end mb-0">
                        <a href="<?= Yii::$app->homeUrl ?>" class="d-flex align-items-center text-decoration-none text-dark">
                            <img src="<?= Yii::getAlias('@web/img/logoPutih.png') ?>" alt="Finora" style="height: 50px; width: auto; object-fit: contain;">
                        </a>

                        <?php if (!Yii::$app->user->isGuest): ?>
                        <div class="dropdown ms-5">
                            <a href="#" class="d-flex align-items-center text-decoration-none" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px; background: rgba(255,255,255,0.2); transition: 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.35)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
                                    <i class="bi bi-person-fill fs-5"></i>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-4 mt-2" aria-labelledby="profileDropdown">
                                <li class="px-4 py-3 border-bottom mb-2 text-center bg-light rounded-top-4">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center text-primary mx-auto mb-2" style="width: 50px; height: 50px;">
                                        <i class="bi bi-person-fill fs-3"></i>
                                    </div>
                                    <div class="fw-bold" style="color: #000 !important;"><?= Html::encode(Yii::$app->user->identity->username) ?></div>
                                    <div class="small" style="color: #000 !important;"><?= Html::encode(Yii::$app->user->identity->email) ?></div>
                                </li>
                                <li>
                                    <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'px-2 pb-2 m-0']) ?>
                                    <?= Html::submitButton(
                                        '<i class="bi bi-box-arrow-right me-2"></i> Logout',
                                        ['class' => 'dropdown-item text-danger rounded-3 py-2 fw-semibold d-flex align-items-center']
                                    ) ?>
                                    <?= Html::endForm() ?>
                                </li>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Nav Menu di bawah logo -->
                    <div style="margin-top: 20px;">
                    <?php
                    $navItems = [
                        ['label' => 'Dashboard', 'url' => ['/site/index'], 'linkOptions' => ['class' => 'nav-link rounded-pill px-3 fw-semibold']],
                        ['label' => 'Pemasukan', 'url' => ['/transaksi/index', 'tipe' => 'pemasukan'], 'linkOptions' => ['class' => 'nav-link rounded-pill px-3 fw-semibold']],
                        ['label' => 'Pengeluaran', 'url' => ['/transaksi/index', 'tipe' => 'pengeluaran'], 'linkOptions' => ['class' => 'nav-link rounded-pill px-3 fw-semibold']],
                        ['label' => 'Investasi', 'url' => ['/investasi/index'], 'linkOptions' => ['class' => 'nav-link rounded-pill px-3 fw-semibold']],
                        ['label' => 'Catatan', 'url' => ['/catatan/index'], 'linkOptions' => ['class' => 'nav-link rounded-pill px-3 fw-semibold']],
                    ];

                    if (Yii::$app->user->isGuest) {
                        $navItems[] = ['label' => 'Signup', 'url' => ['/site/signup'], 'linkOptions' => ['class' => 'nav-link rounded-pill px-3 fw-semibold']];
                        $navItems[] = ['label' => 'Login', 'url' => ['/site/login'], 'linkOptions' => ['class' => 'nav-link rounded-pill px-3 fw-semibold']];
                    }

                    echo Nav::widget([
                        'options' => ['class' => 'nav nav-pills gap-1 justify-content-end align-items-center'],
                        'items' => $navItems,
                    ]);
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container pb-4 <?= isset($this->blocks['page-header']) ? '' : 'pt-4' ?>">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<?php if (!Yii::$app->user->isGuest): ?>
<div class="main-bottom-nav d-md-none">
    <a href="<?= \yii\helpers\Url::to(['/site/index']) ?>" class="<?= Yii::$app->controller->id == 'site' ? 'active' : '' ?>">
        <i class="bi bi-grid-1x2"></i>
        <span>Dashboard</span>
    </a>
    <a href="<?= \yii\helpers\Url::to(['/transaksi/index', 'tipe' => 'pemasukan']) ?>" class="<?= Yii::$app->controller->id == 'transaksi' && Yii::$app->request->get('tipe') == 'pemasukan' ? 'active' : '' ?>">
        <i class="bi bi-plus-circle"></i>
        <span>Pemasukan</span>
    </a>
    <a href="<?= \yii\helpers\Url::to(['/transaksi/index', 'tipe' => 'pengeluaran']) ?>" class="<?= Yii::$app->controller->id == 'transaksi' && Yii::$app->request->get('tipe') == 'pengeluaran' ? 'active' : '' ?>">
        <i class="bi bi-dash-circle"></i>
        <span>Pengeluaran</span>
    </a>
    <a href="<?= \yii\helpers\Url::to(['/investasi/index']) ?>" class="<?= Yii::$app->controller->id == 'investasi' ? 'active' : '' ?>">
        <i class="bi bi-graph-up-arrow"></i>
        <span>Investasi</span>
    </a>
    <a href="<?= \yii\helpers\Url::to(['/catatan/index']) ?>" class="<?= Yii::$app->controller->id == 'catatan' ? 'active' : '' ?>">
        <i class="bi bi-journal-text"></i>
        <span>Catatan</span>
    </a>
</div>
<?php endif; ?>

<script>
// Pindah ke input selanjutnya saat menekan Enter
document.addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        const target = event.target;
        if (target.tagName === 'INPUT' && target.type !== 'submit' && target.type !== 'button' && target.type !== 'checkbox' && target.type !== 'radio') {
            const form = target.form;
            if (form) {
                const focusable = Array.from(form.elements).filter(el => 
                    !el.disabled && !el.readOnly && el.type !== 'hidden' && el.tabIndex !== -1
                );
                const index = focusable.indexOf(target);
                if (index > -1 && index < focusable.length - 1) {
                    event.preventDefault();
                    let nextEl = focusable[index + 1];
                    
                    // Lewati checkbox "Remember Me" saat menekan enter di form login
                    if (nextEl.type === 'checkbox') {
                        if (index + 2 < focusable.length) {
                            nextEl = focusable[index + 2];
                        }
                    }

                    if (nextEl.type === 'submit' || nextEl.tagName === 'BUTTON') {
                        nextEl.click();
                    } else {
                        nextEl.focus();
                    }
                }
            }
        }
    }
});
</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
