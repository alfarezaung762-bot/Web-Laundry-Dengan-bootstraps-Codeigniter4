<?= $this->extend('templates/home'); ?>
<?= $this->section('content'); ?>

<?php
$pesananList = array_reverse($pesanan ?? []);
$statusCounts = [];
foreach ($pesananList as $row) {
    $s = $row['status'] ?? '-';
    $statusCounts[$s] = ($statusCounts[$s] ?? 0) + 1;
}
$totalPesanan = count($pesananList);

function badgeClassByStatus(string $status): string {
    // Bootstrap 4 badge classes (SB Admin 2 friendly)
    return match ($status) {
        'Menunggu' => 'badge-secondary',
        'Pickup' => 'badge-warning',
        'Sedang Dijemput' => 'badge-info',
        'Proses' => 'badge-primary',
        'Cuci' => 'badge-warning',
        'Selesai' => 'badge-success',
        default => 'badge-light',
    };
}
?>

<style>
    /* selaras dengan halaman create */
    .page-card { border: none; border-radius: 15px; overflow: hidden; }
    .page-header{
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color:#fff;
        padding: 18px 20px;
    }
    .page-header .status-badge{
        background: rgba(255,255,255,0.2);
        padding: 8px 14px;
        border-radius: 20px;
        font-size: .9rem;
        display:inline-block;
        white-space: nowrap;
    }
    .info-section{
        background:#f8f9fc;
        border-radius:10px;
        padding:16px 16px;
        margin-bottom:16px;
        border:1px solid #eaecf4;
    }
    .helper-text{ font-size:.85rem; color:#858796; }
    .table thead th{ vertical-align: middle; }
    .table-hover tbody tr:hover{ background:#f8f9fc; }
    .btn-icon{ width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center; padding:0; }
    .mono{ font-variant-numeric: tabular-nums; }
</style>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-11">

            <div class="card page-card shadow mb-4">
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h4 class="mb-1 font-weight-bold">
                                <i class="fas fa-clipboard-list mr-2"></i>Daftar Pesanan Laundry
                            </h4>
                            <div class="helper-text text-white-50">Cari, filter, dan kelola status pesanan.</div>
                        </div>
                        <div class="mt-2 mt-md-0 d-flex align-items-center">
                            <span class="status-badge mr-2">
                                <i class="fas fa-list mr-1"></i>Total: <?= esc($totalPesanan) ?>
                            </span>
                            <a href="<?= base_url('/pesanan/create') ?>" class="btn btn-light btn-sm shadow-sm">
                                <i class="fas fa-plus mr-1"></i>Tambah Pesanan
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success mb-3">
                            <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <div class="info-section">
                        <div class="row">
                            <div class="col-md-7 mb-3 mb-md-0">
                                <label class="small text-muted mb-1">Cari</label>
                                <input id="pesananSearch" type="text" class="form-control"
                                       placeholder="Cari resi / pelanggan / jenis / status...">
                                <div class="helper-text mt-2">Pencarian berjalan di browser (tanpa reload).</div>
                            </div>
                            <div class="col-md-5">
                                <label class="small text-muted mb-1">Filter Status</label>
                                <select id="statusFilter" class="form-control">
                                    <option value="">Semua</option>
                                    <?php foreach ($statusCounts as $s => $cnt): ?>
                                        <option value="<?= esc($s) ?>"><?= esc($s) ?> (<?= esc($cnt) ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mt-3 d-flex flex-wrap">
                            <?php foreach ($statusCounts as $s => $cnt): ?>
                                <span class="badge <?= esc(badgeClassByStatus((string)$s)) ?> mr-2 mb-2">
                                    <?= esc($s) ?>: <?= esc($cnt) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0">
                            <thead class="table-light text-center">
                                <tr>
                                    <th style="width:70px;">No</th>
                                    <th>No Resi</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Jenis Laundry</th>
                                    <th style="width:120px;">Tarif</th>
                                    <th style="width:90px;">Berat</th>
                                    <th style="width:140px;">Total</th>
                                    <th style="width:140px;">Status</th>
                                    <th>Keterangan</th>
                                    <th style="width:160px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="pesananTbody">
                                <?php
                                $no = 1;
                                foreach ($pesananList as $p):
                                    $hideRow = false;
                                    $countdownSeconds = 0;

                                    if (
                                        $p['status'] === 'Selesai' &&
                                        $p['status_selesai'] === 'Sudah Diambil' &&
                                        !empty($p['tanggal_selesai'])
                                    ) {
                                        try {
                                            $selesai = new DateTime($p['tanggal_selesai'], new DateTimeZone('Asia/Jakarta'));
                                            $now = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
                                            $diff = $now->getTimestamp() - $selesai->getTimestamp();

                                            if ($diff > 600) {
                                                $hideRow = true;
                                            } else {
                                                $countdownSeconds = 600 - $diff;
                                            }
                                        } catch (Exception $e) {
                                            $hideRow = false;
                                            $countdownSeconds = 0;
                                        }
                                    }

                                    if ($hideRow) continue;

                                    $status = (string)($p['status'] ?? '-');
                                    $badgeCls = badgeClassByStatus($status);
                                    $classRow = '';
                                    if (
                                        $status === 'Selesai' &&
                                        (
                                            empty($p['status_selesai']) ||
                                            $p['status_selesai'] === 'Selesai - belum diambil/antar'
                                        )
                                    ) {
                                        $classRow = 'table-success';
                                    }
                                ?>
                                    <tr
                                        data-status="<?= esc($status) ?>"
                                        <?= $countdownSeconds > 0 ? 'data-countdown="' . (int)$countdownSeconds . '"' : '' ?>
                                        class="<?= esc($classRow) ?>"
                                    >
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td class="mono font-weight-bold"><?= esc($p['no_resi']) ?></td>
                                        <td><?= esc($p['nama_pelanggan']) ?></td>
                                        <td><?= esc($p['jenis_laundry']) ?></td>
                                        <td class="text-right mono">Rp <?= number_format((float)$p['tarif'], 0, ',', '.') ?></td>
                                        <td class="text-center mono"><?= esc($p['berat_kg']) ?> Kg</td>
                                        <td class="text-right mono font-weight-bold">Rp <?= number_format(((float)$p['tarif'] * (float)$p['berat_kg']), 0, ',', '.') ?></td>
                                        <td class="text-center">
                                            <span class="badge <?= esc($badgeCls) ?>"><?= esc($status) ?></span>
                                            <?php if ($status === 'Selesai' && !empty($p['status_selesai'])): ?>
                                                <div class="small text-muted fst-italic">(<?= esc($p['status_selesai']) ?>)</div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($status === 'Pickup'): ?>
                                                <span class="text-warning"><i class="fas fa-car-side mr-1"></i>Menunggu dijemput</span>
                                            <?php elseif ($status === 'Sedang Dijemput'): ?>
                                                <span class="text-info"><i class="fas fa-sync-alt mr-1"></i>Kurir menjemput</span>
                                            <?php elseif ($status === 'Proses'): ?>
                                                <?php 
                                                    $keterangan = $p['keterangan_cuci'] ?? 'Sedang diproses';
                                                    $namaWasher = $p['nama_washer'] ?? '';
                                                ?>
                                                <span class="text-primary">
                                                    <i class="fas fa-cogs mr-1"></i><?= esc($keterangan) ?>
                                                    <?php if (!empty($namaWasher)): ?>
                                                        oleh <strong><?= esc($namaWasher) ?></strong>
                                                    <?php endif; ?>
                                                </span>
                                            <?php elseif ($status === 'Cuci'): ?>
                                                <?php if (!empty($p['keterangan_cuci'])): ?>
                                                    <span class="text-primary"><i class="fas fa-soap mr-1"></i><?= esc($p['keterangan_cuci']) ?></span>
                                                <?php else: ?>
                                                    <span class="text-primary"><i class="fas fa-soap mr-1"></i>Sedang dicuci</span>
                                                <?php endif; ?>
                                            <?php elseif ($status === 'Selesai'): ?>
                                                <?php if (($p['status_selesai'] ?? '') === 'Sudah Diambil'): ?>
                                                    <span class="text-success"><i class="fas fa-check-circle mr-1"></i>Sudah diambil</span>
                                                    <?php if ($countdownSeconds > 0): ?>
                                                        <div class="small text-muted">Hilang dalam <span class="countdown"></span> detik</div>
                                                    <?php endif; ?>
                                                <?php elseif (($p['status_selesai'] ?? '') === 'Dalam Pengantaran'): ?>
                                                    <span class="text-info"><i class="fas fa-truck mr-1"></i>Dalam pengantaran</span>
                                                <?php else: ?>
                                                    <span class="text-success"><i class="fas fa-flag-checkered mr-1"></i>Selesai - belum diambil/antar</span>
                                                <?php endif; ?>
                                            <?php elseif ($status === 'Menunggu'): ?>
                                                <span class="text-secondary"><i class="fas fa-clock mr-1"></i>Menunggu Untuk Dicuci</span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= base_url('/pesanan/edit-status/' . $p['id_pesanan']) ?>"
                                               class="btn btn-sm btn-outline-warning btn-icon" title="Ubah Status">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url('/pesanan/detail/' . $p['id_pesanan']) ?>"
                                               class="btn btn-sm btn-outline-info btn-icon" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= base_url('/pesanan/struk/' . $p['id_pesanan']) ?>"
                                               class="btn btn-sm btn-outline-success btn-icon"
                                               title="Cetak Struk"
                                               target="_blank" rel="noopener">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <?php if (empty($pesananList)): ?>
                                    <tr>
                                        <td colspan="10" class="text-center text-muted">Belum ada pesanan.</td>
                                    </tr>
                                <?php endif; ?>

                                <tr id="noResultsRow" style="display:none;">
                                    <td colspan="10" class="text-center text-muted">Tidak ada hasil.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div><!-- /card-body -->
            </div><!-- /card -->
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // countdown (hardened)
        document.querySelectorAll('tr[data-countdown]').forEach(row => {
            let countdown = parseInt(row.getAttribute('data-countdown'), 10);
            const countdownSpan = row.querySelector('.countdown');
            if (!Number.isFinite(countdown) || countdown <= 0 || !countdownSpan) return;

            (function tick() {
                if (countdown <= 0) { row.style.display = 'none'; return; }
                countdownSpan.textContent = String(countdown);
                countdown--;
                setTimeout(tick, 1000);
            })();
        });

        // search + status filter
        const searchEl = document.getElementById('pesananSearch');
        const statusEl = document.getElementById('statusFilter');
        const tbody = document.getElementById('pesananTbody');
        const noRow = document.getElementById('noResultsRow');
        if (!searchEl || !statusEl || !tbody || !noRow) return;

        const getRows = () => Array.from(tbody.querySelectorAll('tr')).filter(tr => tr.id !== 'noResultsRow' && tr.querySelectorAll('td').length);

        function applyFilter() {
            const q = (searchEl.value || '').trim().toLowerCase();
            const s = (statusEl.value || '').trim().toLowerCase();

            let visible = 0;
            for (const tr of getRows()) {
                const isEmptyRow = tr.querySelectorAll('td').length === 1 && tr.querySelector('td[colspan]');
                if (isEmptyRow) continue;

                const text = (tr.innerText || '').toLowerCase();
                const rowStatus = (tr.getAttribute('data-status') || '').toLowerCase();

                const ok = (!q || text.includes(q)) && (!s || rowStatus === s);
                tr.style.display = ok ? '' : 'none';
                if (ok) visible++;
            }

            const hasData = getRows().some(tr => !tr.querySelector('td[colspan]'));
            noRow.style.display = (hasData && visible === 0) ? '' : 'none';
        }

        searchEl.addEventListener('input', applyFilter);
        statusEl.addEventListener('change', applyFilter);
        applyFilter();
    });
</script>

<?= $this->endSection(); ?>