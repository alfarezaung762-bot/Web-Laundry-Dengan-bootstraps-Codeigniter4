<?= $this->extend('templates/home'); ?>
<?= $this->section('content'); ?>

<?php
$level = session()->get('level');

$isActive = (bool) session()->get('logged_in');
$statusLabel = $isActive ? 'Aktif' : 'Tidak Aktif';
$statusBadgeClass = $isActive ? 'badge-success' : 'badge-secondary';
$statusDotClass = $isActive ? 'text-success' : 'text-muted';
$lastLogin = session()->get('last_login') ?? 'Baru saja';
?>

<style>
    /* selaras dengan UI pesanan/create.php */
    .profile-card { border: none; border-radius: 15px; overflow: hidden; }
    .profile-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: #fff;
        padding: 20px;
    }
    .profile-header .status-badge {
        background: rgba(255,255,255,0.2);
        padding: 8px 16px;
        border-radius: 20px;
        font-size: .9rem;
        display: inline-block;
        white-space: nowrap;
    }
    .info-section {
        background: #f8f9fc;
        border-radius: 10px;
        padding: 18px 18px;
        margin-bottom: 18px;
        border: 1px solid #eaecf4;
    }
    .info-section h6 {
        color: #4e73df;
        font-weight: 700;
        margin-bottom: 12px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e3e6f0;
    }
    .helper-text { font-size: .85rem; color: #858796; }
    .avatar-wrap {
        width: 112px; height: 112px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border: 3px solid rgba(0,0,0,.15);
        box-shadow: 0 .25rem .75rem rgba(0,0,0,.10);
    }
    .avatar-img { width: 100px; height: 100px; object-fit: cover; border-radius: 999px; }
    .kv-row { display:flex; align-items:center; justify-content:space-between; gap: 12px; }
    .kv-row .k { color:#858796; }
</style>

<?php if ($level === 'admin' || $level === 'superadmin'): ?>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">

                <div class="card profile-card shadow mb-4">

                    <div class="profile-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-1 font-weight-bold">
                                    <i class="fas fa-user-shield mr-2"></i>Dashboard Admin
                                </h4>
                                <div class="helper-text text-white-50">
                                    Ringkasan profil dan status akun.
                                </div>
                            </div>
                            <div class="mt-2 mt-md-0 text-right">
                                <span class="status-badge">
                                    <i class="fas fa-circle mr-1 <?= esc($statusDotClass) ?>"></i>
                                    Status: <?= esc($statusLabel) ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="row">
                            <!-- KIRI -->
                            <div class="col-md-5 text-center mb-4 mb-md-0">
                                <div class="avatar-wrap mb-3">
                                    <img src="/programmer_2085231.png" class="avatar-img" alt="Foto Profil">
                                </div>

                                <h5 class="mb-0 font-weight-bold"><?= esc(session()->get('name')) ?></h5>
                                <div class="text-muted small mb-3"><?= esc($level) ?></div>

                                <span class="badge <?= esc($statusBadgeClass) ?> px-3 py-2">
                                    <i class="fas fa-check-circle mr-1"></i><?= esc($statusLabel) ?>
                                </span>

                                <div class="info-section text-left mt-4 mb-0">
                                    <h6><i class="fas fa-chart-line mr-2"></i>Ringkasan</h6>
                                    <div class="row">
                                        <div class="col-6 border-right">
                                            <div class="small text-muted">Last Login</div>
                                            <div class="font-weight-bold"><?= esc($lastLogin) ?></div>
                                        </div>
                                        <div class="col-6">
                                            <div class="small text-muted">Level</div>
                                            <div class="font-weight-bold"><?= esc($level) ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- KANAN -->
                            <div class="col-md-7">
                                <div class="info-section">
                                    <h6><i class="fas fa-id-badge mr-2"></i>Informasi Akun</h6>

                                    <div class="kv-row">
                                        <div class="k">Username</div>
                                        <div class="font-weight-bold"><?= esc(session()->get('username')) ?></div>
                                    </div>

                                    <hr class="my-3">

                                    <div class="kv-row">
                                        <div class="k">Level</div>
                                        <div class="font-weight-bold"><?= esc($level) ?></div>
                                    </div>

                                    <hr class="my-3">

                                    <div class="d-flex justify-content-end">
                                        <a href="<?= base_url('/login/editProfile') ?>" class="btn btn-primary btn-sm shadow-sm">
                                            <i class="fas fa-user-edit mr-1"></i>Edit Profil
                                        </a>
                                    </div>
                                </div>

                                <div class="info-section mb-0">
                                    <h6><i class="fas fa-shield-alt mr-2"></i>Akses</h6>
                                    <div class="helper-text">
                                        Halaman ini hanya untuk admin/superadmin.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!-- /card -->

            </div>
        </div>
    </div>

<?php else: ?>

    <div class="container mt-5">
        <div class="alert alert-danger text-center">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            Anda tidak memiliki akses ke halaman ini.
        </div>
    </div>

<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="container-fluid mt-3">
        <div class="alert alert-success mb-0">
            <i class="fas fa-check-circle mr-2"></i><?= session()->getFlashdata('success') ?>
        </div>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="container-fluid mt-3">
        <div class="alert alert-danger mb-0">
            <i class="fas fa-exclamation-triangle mr-2"></i><?= session()->getFlashdata('error') ?>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection(); ?>