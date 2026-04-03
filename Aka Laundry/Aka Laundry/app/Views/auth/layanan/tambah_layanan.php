<?= $this->extend('templates/home'); ?>

<?= $this->section('content'); ?>

<style>
    /* selaras dengan UI pesanan/create & daftar layanan */
    .create-card { border: none; border-radius: 15px; overflow: hidden; }
    .create-header{
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color:#fff;
        padding: 18px 20px;
    }
    .create-header .status-badge{
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
        padding:18px 18px;
        margin-bottom:18px;
        border:1px solid #eaecf4;
    }
    .info-section h6{
        color:#4e73df;
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

            <div class="card create-card shadow mb-4">

                <div class="create-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h4 class="mb-1 font-weight-bold">
                                <i class="fas fa-plus-circle mr-2"></i>Tambah Layanan
                            </h4>
                            <div class="helper-text text-white-50">
                                Tambahkan jenis laundry beserta tarif dan deskripsi singkat.
                            </div>
                        </div>
                        <div class="mt-2 mt-md-0 text-right">
                            <span class="status-badge mr-2">
                                <i class="fas fa-clipboard-list mr-1"></i>Form
                            </span>
                            <a href="<?= base_url('jenis/index'); ?>" class="btn btn-light btn-sm shadow-sm">
                                <i class="fas fa-arrow-left mr-1"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="<?= base_url('/jenis/simpan'); ?>" method="post">
                        <?= csrf_field(); ?>

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
                                               placeholder="Contoh: Cuci Kering"
                                               required>
                                        <div class="helper-text mt-2">Nama akan tampil di pilihan paket saat membuat pesanan.</div>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold" for="harga">Harga (Rp / Kg)</label>
                                        <input type="number"
                                               class="form-control"
                                               id="harga"
                                               name="tarif"
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
                                                  required></textarea>
                                        <div class="helper-text mt-2">Contoh: Estimasi selesai 2 hari, termasuk setrika, dsb.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="info-section">
                                    <h6><i class="fas fa-info-circle mr-2"></i>Catatan</h6>
                                    <ul class="mb-0 pl-3 helper-text">
                                        <li>Pastikan nama layanan unik agar mudah dibedakan.</li>
                                        <li>Tarif digunakan untuk menghitung total (tarif × berat).</li>
                                        <li>Deskripsi membantu admin memilih layanan yang tepat.</li>
                                    </ul>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary shadow-sm">
                                        <i class="fas fa-save mr-1"></i>Simpan Layanan
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