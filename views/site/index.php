<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var float $totalPemasukan */
/** @var float $totalPengeluaran */
/** @var float $saldoTotal */
/** @var float $saldoCash */
/** @var float $saldoNonCash */
/** @var array $nonCashBreakdown */
/** @var array $investasiSummary */

$this->title = 'Dashboard';
?>
<div class="site-index">

<?php $this->beginBlock('page-header'); ?>
<div>
    <h1 class="fw-bold mb-1">Ringkasan Keuangan</h1>
    <p class="text-muted mb-0">Pantau arus kas dan aset Anda secara real-time.</p>
</div>
<?php $this->endBlock(); ?>

    <div class="body-content">

        <!-- Baris Utama: Pemasukan, Pengeluaran & Saldo -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="text-uppercase fw-semibold opacity-75 mb-0">Total Pemasukan</h6>
                            <i class="bi bi-arrow-down-circle fs-3"></i>
                        </div>
                        <h2 class="fw-bold mb-0">Rp <?= number_format((float)($totalPemasukan ?? 0), 0, ',', '.') ?></h2>
                        <a href="<?= \yii\helpers\Url::to(['/transaksi/index', 'tipe' => 'pemasukan']) ?>" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="text-uppercase fw-semibold opacity-75 mb-0">Total Pengeluaran</h6>
                            <i class="bi bi-arrow-up-circle fs-3"></i>
                        </div>
                        <h2 class="fw-bold mb-0">Rp <?= number_format((float)($totalPengeluaran ?? 0), 0, ',', '.') ?></h2>
                        <a href="<?= \yii\helpers\Url::to(['/transaksi/index', 'tipe' => 'pengeluaran']) ?>" class="stretched-link"></a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: white;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="text-uppercase fw-semibold opacity-75 mb-0">Total Saldo</h6>
                            <i class="bi bi-wallet2 fs-3"></i>
                        </div>
                        <h2 class="fw-bold mb-0">Rp <?= number_format((float)($saldoTotal ?? 0), 0, ',', '.') ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Saldo Cash -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="text-uppercase fw-semibold text-muted mb-0">Saldo Cash (Tunai)</h6>
                            <i class="bi bi-cash-stack fs-3 text-success"></i>
                        </div>
                        <h3 class="fw-bold mb-0 text-success">Rp <?= number_format((float)($saldoCash ?? 0), 0, ',', '.') ?></h3>
                    </div>
                </div>
            </div>

            <!-- Saldo Non-Cash -->
            <div class="col-md-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="text-uppercase fw-semibold text-muted mb-0">Saldo Non-Cash (Bank & E-Wallet)</h6>
                            <i class="bi bi-bank fs-3 text-primary"></i>
                        </div>
                        <div class="d-flex justify-content-between align-items-end mt-2">
                            <h3 class="fw-bold mb-0 text-primary">Rp <?= number_format((float)($saldoNonCash ?? 0), 0, ',', '.') ?></h3>
                            <?php if (!empty($nonCashBreakdown)): ?>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light rounded-pill px-3 fw-semibold text-primary dropdown-toggle" type="button" id="dropdownNonCash" data-bs-toggle="dropdown" aria-expanded="false">
                                        Lihat Detail
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 p-3" aria-labelledby="dropdownNonCash" style="min-width: 280px; max-height: 300px; overflow-y: auto;">
                                        <h6 class="dropdown-header px-0 mb-2 text-dark fw-bold">Rincian Saldo Akun</h6>
                                        <?php foreach ($nonCashBreakdown as $item): ?>
                                            <div class="d-flex align-items-center justify-content-between py-2 border-bottom border-light">
                                                <div class="d-flex align-items-center me-3">
                                                    <i class="bi <?= Html::encode($item['icon'] ?? 'bi-wallet2') ?> me-2 text-primary"></i>
                                                    <span class="small text-muted text-truncate" style="max-width: 120px;"><?= Html::encode($item['nama']) ?></span>
                                                </div>
                                                <span class="fw-bold small">Rp <?= number_format((float)($item['saldo'] ?? 0), 0, ',', '.') ?></span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Portofolio Investasi Section (Hanya tampil jika ada data) -->
            <?php if (!empty($investasiSummary)): ?>
                <div class="col-lg-12 mt-2">
                    <div class="card border-0 shadow-sm overflow-hidden">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h5 class="fw-bold mb-1">Portofolio Investasi</h5>
                                    <p class="text-muted small mb-0">Ringkasan aset berdasarkan jenis investasi.</p>
                                </div>
                                <a href="<?= \yii\helpers\Url::to(['/investasi/index']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    Lihat Detail <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>

                            <div class="row g-4">
                                <?php foreach ($investasiSummary as $inv): ?>
                                    <div class="col-md-3">
                                        <div class="p-4 border-start border-4 border-primary bg-primary-subtle rounded-3">
                                            <h6 class="text-primary fw-bold mb-1"><?= Html::encode($inv['nama']) ?></h6>
                                            <h4 class="fw-bold mb-0">Rp <?= number_format((float)($inv['total_nilai'] ?? 0), 0, ',', '.') ?></h4>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<!-- Load Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
