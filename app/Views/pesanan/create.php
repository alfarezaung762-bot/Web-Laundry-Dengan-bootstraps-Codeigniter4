<?= $this->extend('templates/home'); ?>
<?= $this->section('content'); ?>

<style>
    /* mirip gaya di pesanan/detail.php */
    .create-card { border: none; border-radius: 15px; overflow: hidden; }
    .create-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: #fff;
        padding: 20px;
    }
    .create-header .status-badge {
        background: rgba(255,255,255,0.2);
        padding: 8px 16px;
        border-radius: 20px;
        font-size: .9rem;
        display: inline-block;
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
    .total-box {
        background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%);
        color: #fff;
        padding: 14px 18px;
        border-radius: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .total-box .label { font-size: 0.95rem; font-weight: 600; opacity: .95; }
    .total-box .amount { font-size: 1.35rem; font-weight: 800; }
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
                                <i class="fas fa-plus-circle mr-2"></i>Tambah Pesanan
                            </h4>
                            <div class="helper-text text-white-50">
                                Isi data pelanggan, paket, dan berat. Total akan terhitung otomatis.
                            </div>
                        </div>
                        <div class="mt-2 mt-md-0 text-right">
                            <span class="status-badge">
                                <i class="fas fa-hourglass-half mr-1"></i>Status: Menunggu
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="<?= base_url('/pesanancontroller/store') ?>" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <!-- KIRI: input utama -->
                            <div class="col-md-7">
                                <div class="info-section">
                                    <h6><i class="fas fa-clipboard-list mr-2"></i>Informasi Pesanan</h6>

                                    <div class="form-group">
                                        <label class="font-weight-bold">Pilih Pelanggan</label>
                                        <select name="id_pelanggan" class="form-control" required>
                                            <option value="">-- Pilih Pelanggan --</option>
                                            <?php foreach ($pelanggan as $p): ?>
                                                <option value="<?= $p['id_pelanggan'] ?>"><?= $p['nama_pelanggan'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold">Pilih Jenis Laundry</label>
                                        <select name="kd_jenis" id="kd_jenis" class="form-control" onchange="hitungTotal()" required autocomplete="off">
                                            <option value="">-- Pilih Jenis --</option>
                                            <?php foreach ($jenis as $j): ?>
                                                <option value="<?= $j['kd_jenis'] ?>">
                                                    <?= $j['jenis_laundry'] ?> - Rp<?= number_format($j['tarif']) ?>/Kg
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <small class="helper-text">Pilih paket untuk menentukan tarif per Kg.</small>
                                    </div>

                                    <div class="form-group mb-0">
                                        <label class="font-weight-bold">Berat (Kg)</label>
                                        <input type="number"
                                               name="berat_kg"
                                               id="berat_kg"
                                               class="form-control"
                                               aria-label="Berat dalam kilogram"
                                               inputmode="numeric"
                                               enterkeyhint="done"
                                               autocomplete="off"
                                               step="1"
                                               min="1"
                                               required
                                               oninput="hitungTotal()">
                                        <small class="helper-text">Masukkan berat dalam Kg (minimal 1).</small>
                                    </div>
                                </div>

                                <div class="info-section mb-0">
                                    <h6><i class="fas fa-camera mr-2"></i>Foto Transaksi (Opsional)</h6>
                                    <div class="form-group mb-0">
                                        <input type="file" name="foto_transaksi" class="form-control" accept="image/*">
                                        <small class="helper-text">Boleh dikosongkan.</small>
                                    </div>
                                </div>
                            </div>

                            <!-- KANAN: ringkasan -->
                            <div class="col-md-5">
                                <div class="info-section">
                                    <h6><i class="fas fa-receipt mr-2"></i>Ringkasan</h6>

                                    <div class="mb-2">
                                        <div class="helper-text mb-1">Status Pesanan</div>
                                        <input type="text" class="form-control" value="Menunggu" disabled>
                                        <input type="hidden" name="status" value="Menunggu">
                                        <small class="helper-text">Pesanan akan masuk antrian washer.</small>
                                    </div>

                                    <div class="mt-3 total-box">
                                        <span class="label"><i class="fas fa-money-bill-wave mr-2"></i>Total</span>
                                        <span class="amount" id="totalBox" aria-live="polite">Rp 0</span>
                                    </div>

                                    <!-- tetap pertahankan input total lama (disabled) jika masih ingin terlihat -->
                                    <div class="form-group mt-3 mb-0">
                                        <label class="font-weight-bold mb-1">Detail Total (auto)</label>
                                        <input type="text" id="total" class="form-control font-weight-bold text-primary" disabled aria-live="polite">
                                        <small class="helper-text">Total = tarif x berat.</small>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary shadow-sm">
                                        <i class="fas fa-save mr-1"></i> Simpan Pesanan
                                    </button>
                                </div>

                                <div class="mt-3">
                                    <a href="<?= base_url('/pesanancontroller/index') ?>" class="btn btn-secondary btn-block">
                                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>

<script>
    // ...existing code... (tarif map)
    const tarif = {};
    <?php foreach ($jenis as $j): ?>
        tarif["<?= $j['kd_jenis'] ?>"] = <?= $j['tarif'] ?>;
    <?php endforeach; ?>

    const rupiahFmt = new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0, minimumFractionDigits: 0 });

    function hitungTotal() {
        const beratEl = document.getElementById('berat_kg');
        const jenisEl = document.getElementById('kd_jenis');
        const totalEl = document.getElementById('total');
        const box = document.getElementById('totalBox');
        if (!beratEl || !jenisEl || !totalEl) return;

        let berat = parseFloat(beratEl.value) || 0;
        berat = Math.max(0, berat);

        let jenis = jenisEl.value;

        let total = (!jenis ? 0 : (tarif[jenis] || 0) * berat);

        const totalStr = isNaN(total) ? '' : 'Rp ' + rupiahFmt.format(total);
        totalEl.value = totalStr;
        if (box) box.textContent = totalStr || 'Rp 0';
    }

    document.addEventListener('DOMContentLoaded', hitungTotal);
</script>

<?= $this->endSection(); ?>