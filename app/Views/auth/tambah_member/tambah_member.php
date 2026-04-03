<?= $this->extend('templates/home'); ?>

<?= $this->section('content'); ?>

<style>
    .member-card { border: none; border-radius: 15px; overflow: hidden; }
    .member-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: #fff;
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
        color: #4e73df;
        font-weight: 700;
        margin-bottom: 12px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e3e6f0;
    }
    .helper-text { font-size: .85rem; color: #858796; }
    .preview {
        width: 84px; height: 84px; border-radius: 999px;
        object-fit: cover; border: 2px solid rgba(0,0,0,.08);
        box-shadow: 0 .25rem .75rem rgba(0,0,0,.08);
        display: none;
    }
</style>

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">

            <div class="card member-card shadow mb-4">
                <div class="member-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h4 class="mb-1 font-weight-bold">
                                <i class="fas fa-user-plus mr-2"></i>Tambah Member
                            </h4>
                            <div class="helper-text text-white-50">Lengkapi data pelanggan untuk registrasi member.</div>
                        </div>
                        <div class="mt-2 mt-md-0 text-right">
                            <a href="<?= base_url('/pelanggan/index') ?>" class="btn btn-light btn-sm shadow-sm">
                                <i class="fas fa-arrow-left mr-1"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="<?= base_url('/pelanggan/simpan'); ?>" method="post" enctype="multipart/form-data">
                        <?php if (session()->getFlashdata('errors')) : ?>
                            <div class="alert alert-danger mb-3">
                                <ul class="mb-0">
                                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-md-7">
                                <div class="info-section">
                                    <h6><i class="fas fa-id-card mr-2"></i>Data Pelanggan</h6>

                                    <div class="form-group">
                                        <label class="font-weight-bold" for="nama_pelanggan">Nama Pelanggan</label>
                                        <input type="text"
                                               name="nama_pelanggan"
                                               class="form-control"
                                               id="nama_pelanggan"
                                               placeholder="Masukkan nama"
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold d-block mb-2">Jenis Kelamin</label>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input class="custom-control-input" type="radio" name="jeniskelamin" id="pria" value="Pria" required>
                                            <label class="custom-control-label" for="pria">Pria</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input class="custom-control-input" type="radio" name="jeniskelamin" id="wanita" value="Wanita" required>
                                            <label class="custom-control-label" for="wanita">Wanita</label>
                                        </div>
                                        <div class="helper-text mt-2">Pilih salah satu.</div>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold" for="alamat_pelanggan">Alamat</label>
                                        <input type="text"
                                               name="alamat_pelanggan"
                                               class="form-control"
                                               id="alamat_pelanggan"
                                               placeholder="Masukkan alamat"
                                               required>
                                    </div>

                                    <div class="form-group mb-0">
                                        <label class="font-weight-bold" for="no_pelanggan">No Telp</label>
                                        <input type="text"
                                               name="no_pelanggan"
                                               class="form-control"
                                               id="no_pelanggan"
                                               placeholder="Masukkan no telp"
                                               inputmode="tel"
                                               required>
                                        <div class="helper-text mt-2">Contoh: 08xxxxxxxxxx</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="info-section">
                                    <h6><i class="fas fa-camera mr-2"></i>Foto (Opsional)</h6>

                                    <div class="form-group">
                                        <label class="font-weight-bold" for="foto_pelanggan">Foto Pelanggan</label>
                                        <input type="file"
                                               id="foto_pelanggan"
                                               name="foto_pelanggan"
                                               class="form-control"
                                               accept="image/*">
                                        <div class="helper-text mt-2">Boleh dikosongkan.</div>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <img id="fotoPreview" class="preview mr-3" alt="Preview Foto">
                                        <div class="helper-text">Preview akan muncul setelah memilih file.</div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary shadow-sm">
                                        <i class="fas fa-save mr-1"></i>Simpan
                                    </button>
                                </div>

                                <div class="mt-3">
                                    <a href="<?= base_url('/pelanggan/index') ?>" class="btn btn-secondary btn-block">
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
    (function () {
        const input = document.getElementById('foto_pelanggan');
        const img = document.getElementById('fotoPreview');
        if (!input || !img) return;

        input.addEventListener('change', function () {
            const f = input.files && input.files[0];
            if (!f) { img.style.display = 'none'; img.removeAttribute('src'); return; }
            const url = URL.createObjectURL(f);
            img.src = url;
            img.style.display = 'inline-block';
        });
    })();
</script>

<?= $this->endSection(); ?>