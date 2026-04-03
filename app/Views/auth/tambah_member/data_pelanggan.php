<?= $this->extend('templates/home'); ?>

<?= $this->section('content'); ?>

<?php
$totalMember = is_array($all_data ?? null) ? count($all_data) : 0;
?>

<style>
    /* selaras dengan gaya create/adminakses */
    .member-card { border: none; border-radius: 15px; overflow: hidden; }
    .member-header{
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color:#fff;
        padding: 18px 20px;
    }
    .member-header .status-badge{
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
    .avatar-sm{
        width:44px; height:44px;
        object-fit:cover;
        border-radius:999px;
        border: 2px solid rgba(0,0,0,.08);
        box-shadow: 0 .25rem .75rem rgba(0,0,0,.08);
    }
    .btn-icon{ width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center; padding:0; }
    .table thead th{ vertical-align: middle; }
    .table-hover tbody tr:hover{ background:#f8f9fc; }
</style>

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-11 col-xl-10">

            <div class="card member-card shadow mb-4">
                <div class="member-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h4 class="mb-1 font-weight-bold">
                                <i class="fas fa-address-book mr-2"></i>Data Member
                            </h4>
                            <div class="helper-text text-white-50">
                                Kelola data pelanggan/member (edit, hapus, cetak kartu).
                            </div>
                        </div>

                        <div class="mt-2 mt-md-0 d-flex align-items-center">
                            <span class="status-badge mr-2">
                                <i class="fas fa-users mr-1"></i>Total: <?= esc($totalMember) ?>
                            </span>
                            <a href="<?= base_url('/pelanggan/tambah') ?>" class="btn btn-light btn-sm shadow-sm">
                                <i class="fas fa-user-plus mr-1"></i>Tambah Member
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
                                <input id="memberSearch" type="text" class="form-control"
                                       placeholder="Cari nama / no telp / alamat...">
                                <div class="helper-text mt-2">Pencarian berjalan di browser (tanpa reload).</div>
                            </div>
                            <div class="col-md-4">
                                <label class="small text-muted mb-1">Filter Kelamin</label>
                                <select id="genderFilter" class="form-control">
                                    <option value="">Semua</option>
                                    <option value="laki-laki">Laki-laki</option>
                                    <option value="perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:70px;">#</th>
                                    <th style="width:90px;">Foto</th>
                                    <th>Pelanggan</th>
                                    <th style="width:140px;">Kelamin</th>
                                    <th>Alamat</th>
                                    <th style="width:160px;">No Telp</th>
                                    <th style="width:180px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="memberTbody">
                                <?php $no = 1; ?>
                                <?php foreach ($all_data as $pelanggan): ?>
                                    <tr data-gender="<?= esc(strtolower($pelanggan['jeniskelamin'] ?? '')) ?>">
                                        <td><?= $no++; ?></td>
                                        <td>
                                            <?php if (!empty($pelanggan['foto_pelanggan'])): ?>
                                                <img src="<?= base_url('uploads/' . $pelanggan['foto_pelanggan']); ?>"
                                                     alt="Foto"
                                                     class="avatar-sm">
                                            <?php else: ?>
                                                <span class="text-muted small">Tidak ada</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-left font-weight-bold"><?= esc($pelanggan['nama_pelanggan']); ?></td>
                                        <td>
                                            <span class="badge badge-info"><?= esc($pelanggan['jeniskelamin']); ?></span>
                                        </td>
                                        <td class="text-left"><?= esc($pelanggan['alamat_pelanggan']); ?></td>
                                        <td><?= esc($pelanggan['no_pelanggan']); ?></td>
                                        <td>
                                            <a href="<?= base_url('/pelanggan/edit/' . $pelanggan['id_pelanggan']); ?>"
                                               class="btn btn-sm btn-outline-warning btn-icon" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url('/pelanggan/delete/' . $pelanggan['id_pelanggan']); ?>"
                                               class="btn btn-sm btn-outline-danger btn-icon"
                                               title="Hapus"
                                               onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                            <a href="<?= base_url('/pelanggan/kartu/' . $pelanggan['id_pelanggan']); ?>"
                                               class="btn btn-sm btn-outline-info btn-icon"
                                               title="Cetak Kartu"
                                               target="_blank" rel="noopener">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <?php if (empty($all_data)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Belum ada data member.</td>
                                    </tr>
                                <?php endif; ?>

                                <tr id="noResultsRow" style="display:none;">
                                    <td colspan="7" class="text-center text-muted">Tidak ada hasil.</td>
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
    // filter client-side: search + gender
    (function () {
        const searchEl = document.getElementById('memberSearch');
        const genderEl = document.getElementById('genderFilter');
        const tbody = document.getElementById('memberTbody');
        const noRow = document.getElementById('noResultsRow');
        if (!searchEl || !genderEl || !tbody || !noRow) return;

        const getRows = () => Array.from(tbody.querySelectorAll('tr'))
            .filter(tr => tr.id !== 'noResultsRow' && tr.querySelectorAll('td').length);

        function applyFilter() {
            const q = (searchEl.value || '').trim().toLowerCase();
            const g = (genderEl.value || '').trim().toLowerCase();

            let visible = 0;
            for (const tr of getRows()) {
                const isEmptyRow = tr.querySelectorAll('td').length === 1 && tr.querySelector('td[colspan]');
                if (isEmptyRow) continue;

                const text = (tr.innerText || '').toLowerCase();
                const rowGender = (tr.getAttribute('data-gender') || '').toLowerCase();

                const ok = (!q || text.includes(q)) && (!g || rowGender === g);
                tr.style.display = ok ? '' : 'none';
                if (ok) visible++;
            }

            const hasData = getRows().some(tr => !tr.querySelector('td[colspan]'));
            noRow.style.display = (hasData && visible === 0) ? '' : 'none';
        }

        searchEl.addEventListener('input', applyFilter);
        genderEl.addEventListener('change', applyFilter);
        applyFilter();
    })();
</script>

<?= $this->endSection(); ?>