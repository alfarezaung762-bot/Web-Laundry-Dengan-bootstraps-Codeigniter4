<?= $this->extend('user/templates'); ?>
<?= $this->section('content'); ?>

<?php
// 3 status resmi
$statuses = ['Menunggu', 'Proses', 'Selesai'];

$pesananStatus = $pesanan['status'] ?? null;
$index = ($pesananStatus !== null) ? array_search($pesananStatus, $statuses, true) : false;
if ($index === false) { $index = 0; } // fallback aman
$progress = ($index / (count($statuses) - 1)) * 100;

$statusColors = [
    'Menunggu' => '#6b7280', // gray
    'Proses'   => '#f59e0b', // amber
    'Selesai'  => '#22c55e', // green
];

$activeColor = $statusColors[$statuses[$index]] ?? '#111827';

$tanggalMasuk  = $pesanan['tanggal_masuk']  ?? ($pesanan['created_at'] ?? '-');
$tanggalSelesai = $pesanan['tanggal_selesai'] ?? '-';

$idWasher = $pesanan['id_washer'] ?? null;
$namaWasher = $pesanan['nama_washer'] ?? null;

function badgeKeteranganCuci(?string $ket): string {
    $ket = trim((string)$ket);
    if ($ket === '') return '';
    $map = [
        'Sedang Dicuci'     => ['bg' => 'primary', 'icon' => 'fa-soap'],
        'Sedang Dijemur'    => ['bg' => 'warning text-dark', 'icon' => 'fa-sun'],
        'Sedang Disetrika'  => ['bg' => 'info text-white', 'icon' => 'fa-shirt'],
        'Menunggu Untuk Dicuci' => ['bg' => 'secondary', 'icon' => 'fa-hourglass-half'],
    ];
    $meta = $map[$ket] ?? ['bg' => 'secondary', 'icon' => 'fa-circle-info'];
    return '<span class="badge bg-'.$meta['bg'].'"><i class="fa-solid '.$meta['icon'].' me-1"></i>'.esc($ket).'</span>';
}
?>

<div class="container py-4">
    <div class="text-center mb-4">
        <h2 class="fw-bold mb-1">Pelacakan Pesanan</h2>
        <p class="text-muted mb-0">Masukkan resi di Home untuk melihat progres.</p>
    </div>

    <div class="mx-auto tracking-card card border-0 shadow-sm rounded-4 overflow-hidden" style="max-width: 860px;">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2"
             style="background: linear-gradient(135deg, rgba(252,234,187,.85) 0%, rgba(248,181,0,.85) 100%); border: 0;">
            <div class="fw-bold">
                <i class="fa-solid fa-receipt me-2"></i>Hasil Pelacakan
            </div>
            <?php if (!empty($pesananStatus)): ?>
                <span class="badge text-bg-dark">
                    Status: <?= esc($pesananStatus) ?>
                </span>
            <?php endif; ?>
        </div>

        <div class="card-body p-4">
            <?php if ($pesanan): ?>
                <div class="row g-3">
                    <div class="col-12 col-lg-7">
                        <div class="p-3 rounded-4 border bg-light">
                            <div class="row g-2 small">
                                <div class="col-12 col-md-6"><b>No Resi:</b> <?= esc($pesanan['no_resi'] ?? '-') ?></div>
                                <div class="col-12 col-md-6"><b>Pelanggan:</b> <?= esc($pesanan['nama_pelanggan'] ?? '-') ?></div>
                                <div class="col-12 col-md-6"><b>Jenis:</b> <?= esc($pesanan['jenis_laundry'] ?? '-') ?></div>
                                <div class="col-12 col-md-6"><b>Berat:</b> <?= esc((string)($pesanan['berat_kg'] ?? '-')) ?> Kg</div>

                                <div class="col-12 col-md-6"><b>Tanggal Masuk:</b> <?= esc((string)$tanggalMasuk) ?></div>
                                <div class="col-12 col-md-6"><b>Tanggal Selesai:</b> <?= esc((string)$tanggalSelesai) ?></div>

                                <div class="col-12 col-md-6">
                                    <b>ID Pencuci (Washer):</b> <?= esc($idWasher !== null ? (string)$idWasher : '-') ?>
                                </div>
                                <div class="col-12 col-md-6">
                                    <b>Nama Pencuci:</b> <?= esc($namaWasher !== null && $namaWasher !== '' ? (string)$namaWasher : '-') ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-5">
                        <div class="p-3 rounded-4 border h-100">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="fw-bold small text-muted">Progress</div>
                                <div class="fw-bold small" style="color: <?= esc($activeColor) ?>;">
                                    <?= (int)$progress ?>%
                                </div>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar" role="progressbar"
                                     style="width: <?= $progress ?>%; background: <?= esc($activeColor) ?>;"
                                     aria-valuenow="<?= (int)$progress ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <div class="mt-3 stepper">
                                <?php foreach ($statuses as $i => $step): ?>
                                    <?php
                                        $done = $i < $index;
                                        $active = $i === $index;
                                        $color = $done || $active ? ($statusColors[$step] ?? '#111827') : '#d1d5db';
                                    ?>
                                    <div class="step <?= $active ? 'is-active' : ($done ? 'is-done' : '') ?>">
                                        <div class="dot" style="background: <?= esc($color) ?>;"></div>
                                        <div class="label"><?= esc($step) ?></div>
                                    </div>
                                    <?php if ($i < count($statuses) - 1): ?>
                                        <div class="bar"></div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>

                            <div class="mt-3 small text-muted">
                                <?php if (($pesanan['status'] ?? '') === 'Menunggu'): ?>
                                    Pesanan Anda sedang menunggu diproses.
                                <?php elseif (($pesanan['status'] ?? '') === 'Proses'): ?>
                                    Sedang diproses: <?= badgeKeteranganCuci($pesanan['keterangan_cuci'] ?? '') ?: '<span class="badge bg-warning text-dark"><i class="fa-solid fa-gear me-1"></i>Dalam Proses</span>' ?>
                                <?php elseif (($pesanan['status'] ?? '') === 'Selesai'): ?>
                                    <span class="badge bg-success"><i class="fa-solid fa-circle-check me-1"></i>Selesai</span>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (($pesanan['status'] ?? '') === 'Selesai'): ?>
                    <div class="mt-4 p-3 rounded-4 border bg-light">
                        <div class="fw-bold mb-2"><i class="fa-solid fa-box-archive me-2"></i>Status Pengambilan</div>
                        <?php
                            $ss = $pesanan['status_selesai'] ?? null;
                            if ($ss === 'Sudah Diambil') {
                                echo '<span class="badge bg-success"><i class="fa-solid fa-check me-1"></i> Sudah diambil pelanggan</span>';
                            } elseif ($ss === 'Sedang Diantar') {
                                echo '<span class="badge bg-info text-white"><i class="fa-solid fa-truck me-1"></i> Sedang diantar</span>';
                            } else {
                                echo '<span class="badge bg-warning text-dark"><i class="fa-solid fa-triangle-exclamation me-1"></i> Belum diambil/antar</span>';
                            }
                        ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="alert alert-danger mb-0">
                    Data pesanan tidak ditemukan. Pastikan nomor resi benar.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.tracking-card { animation: fadeInUp .5s ease; }
@keyframes fadeInUp { from {opacity:0; transform: translateY(10px);} to {opacity:1; transform: translateY(0);} }

.stepper{ display:flex; align-items:center; gap:10px; }
.stepper .step{ display:flex; align-items:center; gap:8px; }
.stepper .dot{
    width:14px; height:14px; border-radius:999px;
    box-shadow: 0 6px 14px rgba(0,0,0,.10);
}
.stepper .label{ font-size: .85rem; font-weight: 700; color:#374151; }
.stepper .bar{
    flex:1;
    height:3px;
    background:#e5e7eb;
    border-radius:999px;
}
.stepper .step.is-active .label{ color:#111827; }
.stepper .step.is-done .label{ color:#111827; }
</style>

<?= $this->endSection(); ?>