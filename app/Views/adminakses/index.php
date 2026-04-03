<?= $this->extend('templates/home'); ?>
<?= $this->section('content'); ?>

<?php
$totalUsers = is_array($users ?? null) ? count($users) : 0;
$levelSet = [];
if (is_array($users ?? null)) {
    foreach ($users as $u) {
        if (isset($u['level'])) $levelSet[$u['level']] = true;
    }
}
$levelOptions = array_keys($levelSet);
sort($levelOptions);

$currentLevel = (string) session()->get('level');
$isSuperadmin = ($currentLevel === 'superadmin');
$isAdmin = ($currentLevel === 'admin');
?>

<style>
    /* selaras dengan gaya halaman create */
    .manage-card { border: none; border-radius: 15px; overflow: hidden; }
    .manage-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: #fff;
        padding: 18px 20px;
    }
    .manage-header .status-badge {
        background: rgba(255,255,255,0.2);
        padding: 8px 14px;
        border-radius: 20px;
        font-size: .9rem;
        display: inline-block;
        white-space: nowrap;
    }
    .info-section {
        background: #f8f9fc;
        border-radius: 10px;
        padding: 16px 16px;
        margin-bottom: 16px;
        border: 1px solid #eaecf4;
    }
    .helper-text { font-size: .85rem; color: #858796; }
    .table thead th { vertical-align: middle; }
    .table-hover tbody tr:hover { background: #f8f9fc; }
    .btn-icon { width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; padding: 0; }
</style>

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-11 col-xl-10">

            <div class="card manage-card shadow mb-4">
                <div class="manage-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h5 class="mb-1 font-weight-bold">
                                <i class="fas fa-user-shield mr-2"></i>Manajemen Akses Login
                            </h5>
                            <div class="helper-text text-white-50">Kelola user dan level untuk akses aplikasi.</div>
                        </div>

                        <div class="mt-2 mt-md-0 d-flex align-items-center">
                            <span class="status-badge mr-2">
                                <i class="fas fa-users mr-1"></i>Total: <?= esc($totalUsers) ?>
                            </span>

                            <?php if ($isSuperadmin): ?>
                                <a href="<?= base_url('/useradmin/create') ?>" class="btn btn-light btn-sm shadow-sm">
                                    <i class="fas fa-user-plus mr-1"></i>Tambah User
                                </a>
                            <?php else: ?>
                                <span class="status-badge">
                                    <i class="fas fa-lock mr-1"></i>Admin hanya kelola washer
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success mb-3">
                            <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger mb-3">
                            <i class="fas fa-exclamation-triangle mr-2"></i><?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <div class="info-section">
                        <div class="row">
                            <div class="col-md-8 mb-3 mb-md-0">
                                <label class="small text-muted mb-1">Cari</label>
                                <input id="userSearch" type="text" class="form-control"
                                       placeholder="Cari nama / username / level...">
                                <div class="helper-text mt-2">Pencarian & filter berjalan di browser (tanpa reload).</div>
                            </div>

                            <div class="col-md-4">
                                <label class="small text-muted mb-1">Filter Level</label>
                                <select id="levelFilter" class="form-control">
                                    <option value="">Semua Level</option>
                                    <?php foreach ($levelOptions as $lvl): ?>
                                        <option value="<?= esc($lvl) ?>"><?= esc($lvl) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:70px;">No</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th style="width:140px;">Level</th>
                                    <th style="width:120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="userTableBody">
                                <?php $no = 1; foreach ($users as $user): ?>
                                    <?php
                                        $uLevel = (string)($user['level'] ?? '');
                                        $canManage = $isSuperadmin || ($isAdmin && $uLevel === 'washer');
                                    ?>
                                    <tr data-level="<?= esc($uLevel) ?>">
                                        <td><?= $no++ ?></td>
                                        <td><?= esc($user['name']) ?></td>
                                        <td><?= esc($user['username']) ?></td>
                                        <td><span class="badge badge-primary"><?= esc($uLevel) ?></span></td>
                                        <td>
                                            <?php if ($canManage): ?>
                                                <a href="<?= base_url('/useradmin/edit/' . $user['id']) ?>"
                                                   class="btn btn-sm btn-outline-warning btn-icon" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= base_url('/useradmin/delete/' . $user['id']) ?>"
                                                   onclick="return confirm('Yakin hapus user ini?')"
                                                   class="btn btn-sm btn-outline-danger btn-icon" title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-sm btn-outline-secondary btn-icon" title="Tidak diizinkan" disabled>
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary btn-icon" title="Tidak diizinkan" disabled>
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <?php if (empty($users)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada data user.</td>
                                    </tr>
                                <?php endif; ?>

                                <!-- untuk kasus hasil filter = 0 (saat data sebenarnya ada) -->
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
    // filter client-side (search + level)
    (function () {
        const searchEl = document.getElementById('userSearch');
        const levelEl = document.getElementById('levelFilter');
        const tbody = document.getElementById('userTableBody');
        const noRow = document.getElementById('noResultsRow');
        if (!searchEl || !levelEl || !tbody || !noRow) return;

        const getRows = () => Array.from(tbody.querySelectorAll('tr')).filter(tr => tr.id !== 'noResultsRow' && tr.querySelectorAll('td').length);

        function applyFilter() {
            const q = (searchEl.value || '').trim().toLowerCase();
            const lvl = (levelEl.value || '').trim().toLowerCase();

            let visible = 0;
            for (const tr of getRows()) {
                // skip "empty users" row
                const isEmptyRow = tr.querySelectorAll('td').length === 1 && tr.querySelector('td[colspan]');
                if (isEmptyRow) continue;

                const text = (tr.innerText || '').toLowerCase();
                const rowLvl = (tr.getAttribute('data-level') || '').toLowerCase();

                const ok = (!q || text.includes(q)) && (!lvl || rowLvl === lvl);
                tr.style.display = ok ? '' : 'none';
                if (ok) visible++;
            }

            // tampilkan "Tidak ada hasil" hanya kalau memang ada data awal (bukan empty users)
            const hasData = getRows().some(tr => !tr.querySelector('td[colspan]'));
            noRow.style.display = (hasData && visible === 0) ? '' : 'none';
        }

        searchEl.addEventListener('input', applyFilter);
        levelEl.addEventListener('change', applyFilter);
        applyFilter();
    })();
</script>

<?= $this->endSection(); ?>