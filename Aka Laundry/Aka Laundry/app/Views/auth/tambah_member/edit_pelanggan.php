<?= $this->extend('templates/home'); ?>

<?= $this->section('content'); ?>

<?php
// defaults agar fleksibel seperti edit user/edit status
$formAction = $formAction ?? base_url('pelanggan/update');
$backUrl = $backUrl ?? base_url('/pelanggan/index');
?>

<style>
    /* selaras dengan UI edit status & edit user */
    .edit-card { border: none; border-radius: 15px; overflow: hidden; }
    .edit-header{
        background: linear-gradient(135deg, #1cc88a 0%, #0f9d67 100%);
        color:#fff;
        padding: 18px 20px;
    }
    .info-section{
        background:#f8f9fc;
        border-radius:10px;
        padding:16px 16px;
        margin-bottom:16px;
        border:1px solid #eaecf4;
    }
    .info-section h6{
        color:#0f9d67;
        font-weight:700;
        margin-bottom:12px;
        padding-bottom:10px;
        border-bottom:2px solid #e3e6f0;
    }
    .helper-text{ font-size:.85rem; color:#858796; }
    .preview-img{ width: 96px; height: 96px; object-fit: cover; border-radius: 14px; }
</style>

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">

            <div class="card edit-card shadow mb-4">
                <div class="edit-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h4 class="mb-1 font-weight-bold">
                                <i class="fas fa-user-edit mr-2"></i>Edit Member
                            </h4>
                            <div class="helper-text text-white-50">
                                Perbarui data pelanggan. Foto boleh dikosongkan jika tidak diganti.
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

                    <?php if (session()->getFlashdata('errors')) : ?>
                        <div class="alert alert-danger rounded-3">
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= esc($formAction) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= esc($pelanggan['id_pelanggan']); ?>">

                        <div class="row">
                            <div class="col-md-7">
                                <div class="info-section">
                                    <h6><i class="fas fa-id-card mr-2"></i>Data Member</h6>

                                    <div class="form-group">
                                        <label class="font-weight-bold" for="nama_pelanggan">Nama Pelanggan</label>
                                        <input
                                            type="text"
                                            name="nama_pelanggan"
                                            value="<?= esc($pelanggan['nama_pelanggan']) ?>"
                                            class="form-control"
                                            id="nama_pelanggan"
                                            placeholder="Masukkan nama"
                                            required
                                        >
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold d-block">Jenis Kelamin</label>

                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="jeniskelamin"
                                                id="pria"
                                                value="Pria"
                                                <?= (($pelanggan['jeniskelamin'] ?? '') === 'Pria') ? 'checked' : '' ?>
                                                required
                                            >
                                            <label class="form-check-label" for="pria">Pria</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="jeniskelamin"
                                                id="wanita"
                                                value="Wanita"
                                                <?= (($pelanggan['jeniskelamin'] ?? '') === 'Wanita') ? 'checked' : '' ?>
                                            >
                                            <label class="form-check-label" for="wanita">Wanita</label>
                                        </div>

                                        <div class="helper-text mt-2">Pilih sesuai identitas pelanggan.</div>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold" for="alamat_pelanggan">Alamat</label>
                                        <input
                                            type="text"
                                            name="alamat_pelanggan"
                                            class="form-control"
                                            id="alamat_pelanggan"
                                            value="<?= esc($pelanggan['alamat_pelanggan']) ?>"
                                            placeholder="Masukkan alamat"
                                            required
                                        >
                                    </div>

                                    <div class="form-group mb-0">
                                        <label class="font-weight-bold" for="no_pelanggan">No Telp</label>
                                        <input
                                            type="text"
                                            name="no_pelanggan"
                                            value="<?= esc($pelanggan['no_pelanggan']) ?>"
                                            class="form-control"
                                            id="no_pelanggan"
                                            placeholder="Masukkan no telp"
                                            inputmode="tel"
                                            autocomplete="tel"
                                            required
                                        >
                                        <div class="helper-text mt-2">Gunakan nomor aktif agar mudah dihubungi.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="info-section">
                                    <h6><i class="fas fa-image mr-2"></i>Foto</h6>

                                    <?php if (!empty($pelanggan['foto_pelanggan'])): ?>
                                        <div class="d-flex align-items-center mb-3">
                                            <img
                                                src="<?= base_url('uploads/' . $pelanggan['foto_pelanggan']) ?>"
                                                alt="Foto pelanggan"
                                                class="preview-img shadow-sm"
                                            >
                                            <div class="ml-3">
                                                <div class="font-weight-bold">Foto saat ini</div>
                                                <div class="helper-text">Upload foto baru untuk mengganti.</div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="helper-text mb-3">Belum ada foto. Anda bisa menambahkan foto baru.</div>
                                    <?php endif; ?>

                                    <div class="form-group mb-0">
                                        <label class="font-weight-bold" for="foto_pelanggan">Ganti Foto (opsional)</label>
                                        <input type="file" id="foto_pelanggan" name="foto_pelanggan" class="form-control" accept="image/*">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success shadow-sm">
                                        <i class="fas fa-save mr-1"></i>Simpan
                                    </button>
                                </div>

                                <div class="mt-3">
                                    <a href="<?= esc($backUrl) ?>" class="btn btn-secondary btn-block">
                                        <i class="fas fa-times mr-2"></i>Batal
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                </div><!-- /card-body -->
            </div><!-- /card -->

        </div>
    </div>
</div>

<?= $this->endSection(); ?>
