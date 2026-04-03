<?= $this->extend('templates/home'); ?>
<?= $this->section('content'); ?>

<?php
// defaults agar tidak memecahkan pemakaian lama (/useradmin/edit/{id})
$formAction = $formAction ?? base_url('/useradmin/update/' . $user['id']);
$backUrl = $backUrl ?? base_url('/useradmin');
$showLevelSelect = $showLevelSelect ?? true;
?>

<style>
    /* selaras dengan halaman create user / pesanan/create.php */
    .edit-card { border: none; border-radius: 15px; overflow: hidden; }
    .edit-header {
        background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
        color: #1f2937;
        padding: 20px;
    }
    .info-section {
        background: #f8f9fc;
        border-radius: 10px;
        padding: 18px 18px;
        margin-bottom: 18px;
        border: 1px solid #eaecf4;
    }
    .info-section h6 {
        color: #dda20a;
        font-weight: 700;
        margin-bottom: 12px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e3e6f0;
    }
    .helper-text { font-size: .85rem; color: #858796; }
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">

            <div class="card edit-card shadow mb-4">

                <div class="edit-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h4 class="mb-1 font-weight-bold">
                                <i class="fas fa-user-edit mr-2"></i>Edit User
                            </h4>
                            <div class="helper-text text-dark-50">
                                Ubah data user dan level akses. Password boleh dikosongkan jika tidak diubah.
                            </div>
                        </div>
                        <div class="mt-2 mt-md-0 text-right">
                            <a href="<?= esc($backUrl) ?>" class="btn btn-light btn-sm shadow-sm">
                                <i class="fas fa-arrow-left mr-1"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="<?= esc($formAction) ?>" method="post">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="info-section">
                                    <h6><i class="fas fa-id-card mr-2"></i>Data User</h6>

                                    <div class="form-group">
                                        <label class="font-weight-bold"><i class="fas fa-user mr-1"></i>Nama</label>
                                        <input type="text" name="name" class="form-control" value="<?= esc($user['name']) ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold"><i class="fas fa-user-tag mr-1"></i>Username</label>
                                        <input type="text" name="username" class="form-control" value="<?= esc($user['username']) ?>" required>
                                    </div>

                                    <div class="form-group mb-0">
                                        <label class="font-weight-bold"><i class="fas fa-key mr-1"></i>Password (opsional)</label>
                                        <input
                                            type="password"
                                            id="password"
                                            name="password"
                                            class="form-control"
                                            minlength="8"
                                            pattern=".{8,}"
                                            title="Password minimal 8 karakter"
                                            autocomplete="new-password"
                                            aria-describedby="passwordHelp"
                                        >
                                        <small id="passwordHelp" class="helper-text">
                                            Kosongkan jika tidak diubah. Jika diisi, minimal 8 karakter.
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="info-section">
                                    <h6><i class="fas fa-user-shield mr-2"></i>Akses</h6>

                                    <?php if ($showLevelSelect): ?>
                                        <div class="form-group mb-0">
                                            <label class="font-weight-bold">Level Akses</label>
                                            <select name="level" class="form-control" required>
                                                <option value="superadmin" <?= $user['level'] == 'superadmin' ? 'selected' : '' ?>>Superadmin</option>
                                                <option value="admin" <?= $user['level'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                                <option value="washer" <?= $user['level'] == 'washer' ? 'selected' : '' ?>>Washer</option>
                                                <!-- kurir dihapus -->
                                            </select>
                                            <small class="helper-text">Otorisasi aplikasi menggunakan level.</small>
                                        </div>
                                    <?php else: ?>
                                        <div class="form-group mb-0">
                                            <label class="font-weight-bold">Level</label>
                                            <input type="text" class="form-control" value="<?= esc($user['level']) ?>" disabled>
                                            <small class="helper-text">Admin hanya boleh mengelola user level <b>washer</b> dan tidak dapat mengubah level.</small>
                                        </div>
                                    <?php endif; ?>

                                    <!-- role dihapus -->
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-warning shadow-sm">
                                        <i class="fas fa-save mr-1"></i>Update
                                    </button>
                                </div>

                                <div class="mt-3">
                                    <a href="<?= base_url('/useradmin') ?>" class="btn btn-secondary btn-block">
                                        <i class="fas fa-times mr-2"></i>Batal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div><!-- /card -->

        </div>
    </div>
</div>

<script>
    // pesan validasi yang konsisten untuk password (hanya berlaku jika user mengisi)
    (function () {
        const pwd = document.getElementById('password');
        if (!pwd) return;

        const msg = 'Password minimal 8 karakter.';
        pwd.addEventListener('input', function () {
            // jika kosong, biarkan valid (karena optional)
            if (!pwd.value) return pwd.setCustomValidity('');
            pwd.setCustomValidity('');
        });
        pwd.addEventListener('invalid', function () {
            if (!pwd.value) return pwd.setCustomValidity(''); // optional
            pwd.setCustomValidity(msg);
        });
    })();
</script>

<?= $this->endSection(); ?>