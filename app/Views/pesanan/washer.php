<?= $this->extend('templates/home'); ?>
<?= $this->section('content'); ?>

<?php
$rows = $pesanan ?? [];
$total = is_array($rows) ? count($rows) : 0;
$menunggu = 0; $proses = 0;
foreach ($rows as $r) {
    if (($r['status'] ?? '') === 'Menunggu') $menunggu++;
    if (($r['status'] ?? '') === 'Proses') $proses++;
}
?>

<style>
    .page-card { border: none; border-radius: 15px; overflow: hidden; }
    .page-header{
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color:#fff; padding: 18px 20px;
    }
    .page-header .status-badge{
        background: rgba(255,255,255,0.2);
        padding: 8px 14px; border-radius: 20px;
        font-size: .9rem; display:inline-block; white-space: nowrap;
    }
    .info-section{
        background:#f8f9fc;
        border-radius:10px;
        padding:16px 16px;
        margin-bottom:16px;
        border:1px solid #eaecf4;
    }
    .helper-text{ font-size:.85rem; color:#858796; }
    .mono{ font-variant-numeric: tabular-nums; }
    .btn-icon{ width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center; padding:0; }
    .table thead th{ vertical-align: middle; }
    .table-hover tbody tr:hover{ background:#f8f9fc; }
</style>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-11">

            <div class="card page-card shadow mb-4">
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h4 class="mb-1 font-weight-bold">
                                <i class="fas fa-tshirt mr-2"></i>Daftar Pesanan - Washer
                            </h4>
                            <div class="helper-text text-white-50">Ambil pesanan, lanjutkan proses, dan selesaikan.</div>
                        </div>
                        <div class="mt-2 mt-md-0">
                            <span class="status-badge mr-2"><i class="fas fa-list mr-1"></i>Total: <?= esc($total) ?></span>
                            <span class="status-badge mr-2"><i class="fas fa-clock mr-1"></i>Menunggu: <?= esc($menunggu) ?></span>
                            <span class="status-badge"><i class="fas fa-cogs mr-1"></i>Proses: <?= esc($proses) ?></span>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success mb-3">
                            <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success') ?>
                        </div>
                    <?php elseif (session()->getFlashdata('warning')): ?>
                        <div class="alert alert-warning mb-3">
                            <i class="fas fa-exclamation-triangle mr-2"></i><?= session()->getFlashdata('warning') ?>
                        </div>
                    <?php elseif (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger mb-3">
                            <i class="fas fa-times-circle mr-2"></i><?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <div class="info-section">
                        <div class="row">
                            <div class="col-md-7 mb-3 mb-md-0">
                                <label class="small text-muted mb-1">Cari</label>
                                <input id="washerSearch" type="text" class="form-control"
                                       placeholder="Cari resi / pelanggan / jenis / keterangan...">
                                <div class="helper-text mt-2">Pencarian berjalan di browser (tanpa reload).</div>
                            </div>
                            <div class="col-md-5">
                                <label class="small text-muted mb-1">Filter Status</label>
                                <select id="washerStatusFilter" class="form-control">
                                    <option value="">Semua</option>
                                    <option value="Menunggu">Menunggu</option>
                                    <option value="Proses">Proses</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($rows)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle mb-0">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th style="width:70px;">No</th>
                                        <th>No Resi</th>
                                        <th>Pelanggan</th>
                                        <th>Jenis Laundry</th>
                                        <th style="width:90px;">Berat</th>
                                        <th style="width:120px;">Status</th>
                                        <th>Keterangan</th>
                                        <th style="width:240px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="washerTbody">
                                    <?php $no = 1; foreach ($rows as $p): ?>
                                        <?php
                                            $status = (string)($p['status'] ?? '-');
                                            $badge = 'secondary';
                                            if ($status === 'Menunggu') $badge = 'warning';
                                            elseif ($status === 'Proses') $badge = 'primary';
                                        ?>
                                        <tr data-status="<?= esc($status) ?>">
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td class="mono font-weight-bold"><?= esc($p['no_resi']) ?></td>
                                            <td><?= esc($p['nama_pelanggan']) ?></td>
                                            <td><?= esc($p['jenis_laundry']) ?></td>
                                            <td class="text-center mono"><?= esc($p['berat_kg']) ?> Kg</td>
                                            <td class="text-center">
                                                <span class="badge badge-<?= esc($badge) ?>"><?= esc($status) ?></span>
                                            </td>
                                            <td>
                                                <?php if (($p['status'] ?? '') === 'Menunggu'): ?>
                                                    <span class="text-muted"><i class="fas fa-clock mr-1"></i>Menunggu Untuk Dicuci</span>
                                                <?php elseif (($p['status'] ?? '') === 'Proses'): ?>
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
                                                <?php else: ?>
                                                    <span class="text-muted"><?= esc($p['keterangan_cuci'] ?? '-') ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if (($p['status'] ?? '') === 'Menunggu'): ?>
                                                    <?php if (empty($p['id_washer'])): ?>
                                                        <form action="<?= base_url('/pesanancontroller/washer/cuci/' . $p['id_pesanan']) ?>" method="post" class="d-inline">
                                                            <button type="submit" class="btn btn-sm btn-success">
                                                                <i class="fas fa-check mr-1"></i>Terima
                                                            </button>
                                                        </form>
                                                    <?php else: ?>
                                                        <span class="text-muted"><i class="fas fa-lock mr-1"></i>Sudah diambil</span>
                                                    <?php endif; ?>

                                                <?php elseif (($p['status'] ?? '') === 'Proses'): ?>
                                                    <?php if (($p['id_washer'] ?? null) != session()->get('id')): ?>
                                                        <span class="text-muted"><i class="fas fa-lock mr-1"></i>Dikerjakan washer lain</span>
                                                    <?php else: ?>
                                                        <?php if (($p['keterangan_cuci'] ?? '') === 'Sedang Dicuci'): ?>
                                                            <form action="<?= base_url('/pesanancontroller/washer/jemur/' . $p['id_pesanan']) ?>" method="post" class="d-inline">
                                                                <button type="submit" class="btn btn-sm btn-warning">
                                                                    <i class="fas fa-sun mr-1"></i>Jemur
                                                                </button>
                                                            </form>
                                                        <?php elseif (($p['keterangan_cuci'] ?? '') === 'Sedang Dijemur'): ?>
                                                            <form action="<?= base_url('/pesanancontroller/washer/setrika/' . $p['id_pesanan']) ?>" method="post" class="d-inline">
                                                                <button type="submit" class="btn btn-sm btn-info">
                                                                    <i class="fas fa-iron mr-1"></i>Setrika
                                                                </button>
                                                            </form>
                                                        <?php elseif (($p['keterangan_cuci'] ?? '') === 'Sedang Disetrika'): ?>
                                                            <form action="<?= base_url('/pesanancontroller/washer/selesai/' . $p['id_pesanan']) ?>" method="post" class="d-inline">
                                                                <button type="submit" class="btn btn-sm btn-success">
                                                                    <i class="fas fa-flag-checkered mr-1"></i>Selesai
                                                                </button>
                                                            </form>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    <?php endif; ?>

                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                    <tr id="noResultsRow" style="display:none;">
                                        <td colspan="8" class="text-center text-muted">Tidak ada hasil.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info text-center mb-0">
                            Tidak ada pesanan yang perlu dikerjakan.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        const searchEl = document.getElementById('washerSearch');
        const statusEl = document.getElementById('washerStatusFilter');
        const tbody = document.getElementById('washerTbody');
        const noRow = document.getElementById('noResultsRow');
        if (!searchEl || !statusEl || !tbody || !noRow) return;

        const getRows = () => Array.from(tbody.querySelectorAll('tr'))
            .filter(tr => tr.id !== 'noResultsRow' && tr.querySelectorAll('td').length);

        function applyFilter() {
            const q = (searchEl.value || '').trim().toLowerCase();
            const s = (statusEl.value || '').trim().toLowerCase();
            let visible = 0;

            for (const tr of getRows()) {
                const text = (tr.innerText || '').toLowerCase();
                const rowStatus = (tr.getAttribute('data-status') || '').toLowerCase();
                const ok = (!q || text.includes(q)) && (!s || rowStatus === s);
                tr.style.display = ok ? '' : 'none';
                if (ok) visible++;
            }

            noRow.style.display = (getRows().length > 0 && visible === 0) ? '' : 'none';
        }

        searchEl.addEventListener('input', applyFilter);
        statusEl.addEventListener('change', applyFilter);
        applyFilter();
    })();
</script>

<?= $this->endSection(); ?>