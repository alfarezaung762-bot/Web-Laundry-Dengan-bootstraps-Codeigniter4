<?= $this->extend('templates/home'); ?>

<?= $this->section('content'); ?>

<style>
    /* selaras dengan UI tambah_layanan */
    .edit-card { border: none; border-radius: 15px; overflow: hidden; }
    .edit-header{
        background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
        color:#1f2937;
        padding: 18px 20px;
    }
    .edit-header .status-badge{
        background: rgba(255,255,255,0.35);
        padding: 8px 14px;
        border-radius: 20px;
        font-size: .9rem;
        display:inline-block;
        white-space: nowrap;
    }
    .info-section{
        background:#f8f9fc;
        border-radius:10px;
        padding:18px 18px;
        margin-bottom:18px;
        border:1px solid #eaecf4;
    }
    .info-section h6{
        color:#dda20a;
        font-weight:700;
        margin-bottom:12px;
        padding-bottom:10px;
        border-bottom:2px solid #e3e6f0;
    }
    .helper-text{ font-size:.85rem; color:#858796; }
</style>

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">

            <div class="card edit-card shadow mb-4">

                <div class="edit-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h4 class="mb-1 font-weight-bold">
                                <i class="fas fa-edit mr-2"></i>Edit Layanan
                            </h4>
                            <div class="helper-text text-dark-50">
                                Ubah nama layanan, tarif, dan deskripsi.
                            </div>
                        </div>
                        <div class="mt-2 mt-md-0 text-right">
                            <span class="status-badge mr-2">
                                <i class="fas fa-pen mr-1"></i>Update
                            </span>
                            <a href="<?= base_url('jenis/index'); ?>" class="btn btn-light btn-sm shadow-sm">
                                <i class="fas fa-arrow-left mr-1"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <?php if (session()->getFlashdata('errors')) : ?>
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('/jenis/update'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="kd_jenis" value="<?= esc($jenis['kd_jenis']); ?>">

                        <div class="row">
                            <div class="col-md-7">
                                <div class="info-section">
                                    <h6><i class="fas fa-tags mr-2"></i>Detail Layanan</h6>

                                    <div class="form-group">
                                        <label class="font-weight-bold" for="nama_layanan">Nama Layanan</label>
                                        <input type="text"
                                               class="form-control"
                                               id="nama_layanan"
                                               name="jenis_laundry"
                                               value="<?= esc($jenis['jenis_laundry']) ?>"
                                               placeholder="Contoh: Cuci Kering"
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold" for="harga">Harga (Rp / Kg)</label>
                                        <input type="number"
                                               class="form-control"
                                               id="harga"
                                               name="tarif"
                                               value="<?= esc($jenis['tarif']) ?>"
                                               placeholder="Contoh: 15000"
                                               inputmode="numeric"
                                               min="0"
                                               step="1"
                                               required>
                                        <div class="helper-text mt-2">Gunakan angka tanpa titik/koma.</div>
                                    </div>

                                    <div class="form-group mb-0">
                                        <label class="font-weight-bold" for="deskripsi">Deskripsi</label>
                                        <textarea class="form-control"
                                                  id="deskripsi"
                                                  name="deskripsi"
                                                  rows="4"
                                                  placeholder="Deskripsi singkat layanan..."
                                                  required><?= esc($jenis['deskripsi']); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="info-section">
                                    <h6><i class="fas fa-info-circle mr-2"></i>Catatan</h6>
                                    <ul class="mb-0 pl-3 helper-text">
                                        <li>Tarif dipakai untuk hitung total pesanan (tarif × berat).</li>
                                        <li>Pastikan deskripsi jelas agar mudah dipahami.</li>
                                    </ul>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-warning shadow-sm">
                                        <i class="fas fa-save mr-1"></i>Update Layanan
                                    </button>
                                </div>

                                <div class="mt-3">
                                    <a href="<?= base_url('jenis/index'); ?>" class="btn btn-secondary btn-block">
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

<?= $this->endSection(); ?>