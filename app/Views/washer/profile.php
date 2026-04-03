<?= $this->extend('templates/home'); ?>

<?= $this->section('content'); ?>

<?php
$isActive = (bool) session()->get('logged_in');
$statusLabel = $isActive ? 'Aktif' : 'Tidak Aktif';
$statusBadgeClass = $isActive ? 'badge-success' : 'badge-secondary';
$statusDotClass = $isActive ? 'text-success' : 'text-muted';
$lastLogin = session()->get('last_login') ?? 'Baru saja';
?>

<style>
    /* selaras dengan gaya di pesanan/create.php */
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
    .kv-row { display:flex; align-items:center; justify-content:space-between; }
    .kv-row .k { color:#858796; }
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">

            <div class="card profile-card shadow mb-4">

                <div class="profile-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h4 class="mb-1 font-weight-bold">
                                <i class="fas fa-user-circle mr-2"></i>Profil
                            </h4>
                            <div class="helper-text text-white-50">
                                Informasi akun dan ringkasan aktivitas.
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
                        <!-- KIRI: avatar + ringkasan -->
                        <div class="col-md-5 text-center mb-4 mb-md-0">
                            <div class="avatar-wrap mb-3">
                                <img src="/programmer_2085231.png" class="avatar-img" alt="Foto Profil">
                            </div>

                            <h5 class="mb-0 font-weight-bold"><?= esc(session()->get('name')) ?></h5>
                            <div class="text-muted small mb-3"><?= esc(session()->get('level')) ?></div>

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
                                        <div class="small text-muted">Role</div>
                                        <div class="font-weight-bold"><?= esc(session()->get('level')) ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- KANAN: detail akun -->
                        <div class="col-md-7">
                            <div class="info-section">
                                <h6><i class="fas fa-id-badge mr-2"></i>Informasi Akun</h6>

                                <div class="kv-row">
                                    <div class="k">Username</div>
                                    <div class="font-weight-bold"><?= esc(session()->get('username')) ?></div>
                                </div>

                                <hr class="my-3">

                                <div class="kv-row">
                                    <div class="k">Status</div>
                                    <div class="font-weight-bold"><?= esc($statusLabel) ?></div>
                                </div>

                                <div class="mt-3 helper-text">
                                    Tip: Jika “Last Login” ingin real, simpan timestamp ke session (mis. <code>last_login</code>) saat autentikasi berhasil.
                                </div>
                            </div>

                            <div class="info-section mb-0">
                                <h6><i class="fas fa-shield-alt mr-2"></i>Keamanan</h6>
                                <div class="helper-text">
                                    Pastikan password kuat dan jangan bagikan kredensial. (Tombol/fitur ubah password bisa ditambahkan saat route sudah tersedia.)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Tambahan kecil: tombol kembali -->
            <div class="mt-3">
                <a href="<?= base_url('/pesanancontroller/washer') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Pesanan
                </a>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>