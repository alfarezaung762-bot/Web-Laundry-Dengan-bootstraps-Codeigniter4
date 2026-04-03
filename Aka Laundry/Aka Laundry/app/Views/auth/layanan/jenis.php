<?= $this->extend('templates/home'); ?>

<?= $this->section('content'); ?>

<?php
$totalLayanan = is_array($all_data ?? null) ? count($all_data) : 0;
?>

<style>
    /* selaras dengan UI pesanan/create dan halaman adminakses */
    .layanan-card { border: none; border-radius: 15px; overflow: hidden; }
    .layanan-header{
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color:#fff;
        padding: 18px 20px;
    }
    .layanan-header .status-badge{
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
    .desc-cell{ max-width: 420px; }
</style>

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-11 col-xl-10">

            <div class="card layanan-card shadow mb-4">
                <div class="layanan-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h4 class="mb-1 font-weight-bold">
                                <i class="fas fa-list-alt mr-2"></i>Daftar Layanan
                            </h4>
                            <div class="helper-text text-white-50">Kelola jenis laundry, tarif, dan deskripsi layanan.</div>
                        </div>

                        <div class="mt-2 mt-md-0 d-flex align-items-center">
                            <span class="status-badge mr-2">
                                <i class="fas fa-tags mr-1"></i>Total: <?= esc($totalLayanan) ?>
                            </span>
                            <a href="<?= base_url('/jenis/tambah'); ?>" class="btn btn-light btn-sm shadow-sm">
                                <i class="fas fa-plus mr-1"></i>Tambahkan Layanan
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success mb-3">
                            <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <div class="info-section">
                        <div class="row">
                            <div class="col-md-8 mb-3 mb-md-0">
                                <label class="small text-muted mb-1">Cari</label>
                                <input id="layananSearch" type="text" class="form-control"
                                       placeholder="Cari nama layanan / deskripsi / tarif...">
                                <div class="helper-text mt-2">Pencarian berjalan di browser (tanpa reload).</div>
                            </div>
                            <div class="col-md-4">
                                <label class="small text-muted mb-1">Catatan</label>
                                <div class="form-control bg-white" style="height:auto;">
                                    <span class="helper-text">Gunakan tombol <b>Edit</b> / <b>Hapus</b> pada kolom aksi.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th style="width:70px;">No</th>
                                    <th>Nama Layanan</th>
                                    <th style="width:160px;">Harga</th>
                                    <th>Deskripsi</th>
                                    <th style="width:120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="layananTbody">
                                <?php $no = 1; foreach ($all_data as $item): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td class="font-weight-bold"><?= esc($item['jenis_laundry']); ?></td>
                                        <td class="text-center">Rp <?= number_format($item['tarif'], 0, ',', '.'); ?></td>
                                        <td class="desc-cell"><?= esc($item['deskripsi']); ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url('jenis/edit/' . $item['kd_jenis']); ?>"
                                               class="btn btn-sm btn-outline-warning btn-icon" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url('jenis/delete/' . $item['kd_jenis']); ?>"
                                               class="btn btn-sm btn-outline-danger btn-icon" title="Hapus"
                                               onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <?php if (empty($all_data)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada data layanan.</td>
                                    </tr>
                                <?php endif; ?>

                                <tr id="noResultsRow" style="display:none;">
                                    <td colspan="5" class="text-center text-muted">Tidak ada hasil.</td>
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
    // search client-side
    (function () {
        const searchEl = document.getElementById('layananSearch');
        const tbody = document.getElementById('layananTbody');
        const noRow = document.getElementById('noResultsRow');
        if (!searchEl || !tbody || !noRow) return;

        const getRows = () => Array.from(tbody.querySelectorAll('tr'))
            .filter(tr => tr.id !== 'noResultsRow' && tr.querySelectorAll('td').length);

        function applyFilter() {
            const q = (searchEl.value || '').trim().toLowerCase();
            let visible = 0;

            for (const tr of getRows()) {
                const isEmptyRow = tr.querySelectorAll('td').length === 1 && tr.querySelector('td[colspan]');
                if (isEmptyRow) continue;

                const text = (tr.innerText || '').toLowerCase();
                const ok = (!q || text.includes(q));
                tr.style.display = ok ? '' : 'none';
                if (ok) visible++;
            }

            const hasData = getRows().some(tr => !tr.querySelector('td[colspan]'));
            noRow.style.display = (hasData && visible === 0) ? '' : 'none';
        }

        searchEl.addEventListener('input', applyFilter);
        applyFilter();
    })();
</script>

<?= $this->endSection(); ?>
