<?= $this->extend('templates/home'); ?>
<?= $this->section('content'); ?>

<style>
    /* selaras dengan gaya pesanan/create.php */
    .create-card { border: none; border-radius: 15px; overflow: hidden; }
    .create-header {
        background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%);
        color: #fff;
        padding: 20px;
    }
    .create-header .status-badge {
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
        color: #1cc88a;
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

            <div class="card create-card shadow mb-4">

                <div class="create-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h4 class="mb-1 font-weight-bold">
                                <i class="fas fa-user-plus mr-2"></i>Tambah User Baru
                            </h4>
                            <div class="helper-text text-white-50">
                                Isi data user dan tentukan level akses (tanpa role).
                            </div>
                        </div>
                        <div class="mt-2 mt-md-0 text-right">
                            <a href="<?= base_url('/useradmin') ?>" class="btn btn-light btn-sm shadow-sm">
                                <i class="fas fa-arrow-left mr-1"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="<?= base_url('/useradmin/store') ?>" method="post">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="info-section">
                                    <h6><i class="fas fa-id-card mr-2"></i>Data User</h6>

                                    <div class="form-group">
                                        <label class="font-weight-bold"><i class="fas fa-user mr-1"></i>Nama</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold"><i class="fas fa-user-tag mr-1"></i>Username</label>
                                        <input type="text" name="username" class="form-control" required autocomplete="off">
                                    </div>

                                    <div class="form-group mb-0">
                                        <label class="font-weight-bold"><i class="fas fa-lock mr-1"></i>Password</label>
                                        <input
                                            type="password"
                                            id="password"
                                            name="password"
                                            class="form-control"
                                            required
                                            minlength="8"
                                            pattern=".{8,}"
                                            title="Password minimal 8 karakter"
                                            autocomplete="new-password"
                                            aria-describedby="passwordHelp"
                                        >
                                        <small id="passwordHelp" class="helper-text">
                                            Minimal 8 karakter.
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="info-section">
                                    <h6><i class="fas fa-user-shield mr-2"></i>Akses</h6>

                                    <div class="form-group mb-0">
                                        <label class="font-weight-bold">Level Akses</label>
                                        <select name="level" class="form-control" required>
                                            <option value="superadmin">Superadmin</option>
                                            <option value="admin">Admin</option>
                                            <option value="washer">Washer</option>
                                            <!-- kurir dihapus -->
                                        </select>
                                        <small class="helper-text">Level dipakai untuk otorisasi.</small>
                                    </div>

                                    <!-- role dihapus -->
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success shadow-sm">
                                        <i class="fas fa-save mr-1"></i>Simpan
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
    // Validasi pesan yang lebih jelas (tetap mengandalkan minlength/pattern browser)
    (function () {
        const pwd = document.getElementById('password');
        if (!pwd) return;

        const msg = 'Password minimal 8 karakter.';
        pwd.addEventListener('input', function () {
            // reset pesan saat user mengetik
            pwd.setCustomValidity('');
        });
        pwd.addEventListener('invalid', function () {
            pwd.setCustomValidity(msg);
        });
    })();
</script>

<?= $this->endSection(); ?>