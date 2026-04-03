<?= $this->extend('templates/home'); ?>
<?= $this->section('content'); ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>Input Berat Cucian</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="<?= base_url('/kurir/pickup-admin/selesai/' . $pesanan['id_pesanan']) ?>" enctype="multipart/form-data">

                        <!-- No Resi -->
                        <div class="mb-3">
                            <label class="form-label"><strong>No Resi:</strong></label>
                            <div class="form-control-plaintext"><?= esc($pesanan['no_resi']) ?></div>
                        </div>

                        <!-- Nama Pelanggan -->
                        <div class="mb-3">
                            <label class="form-label"><strong>Nama Pelanggan:</strong></label>
                            <div class="form-control-plaintext"><?= esc($pesanan['id_pelanggan']) ?></div>
                        </div>

                        <!-- Jenis Laundry -->
                        <div class="mb-3">
                            <label class="form-label">Pilih Jenis Laundry</label>
                            <select name="kd_jenis" id="kd_jenis" class="form-select" onchange="hitungTotal()" required>
                                <option value="">-- Pilih Jenis --</option>
                                <?php foreach ($jenis as $j): ?>
                                    <option value="<?= $j['kd_jenis'] ?>" data-tarif="<?= $j['tarif'] ?>"
                                        <?= $pesanan['kd_jenis'] == $j['kd_jenis'] ? 'selected' : '' ?>>
                                        <?= $j['jenis_laundry'] ?> - Rp<?= number_format($j['tarif']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Berat -->
                        <div class="mb-3">
                            <label for="berat_kg" class="form-label">Berat Cucian (Kg):</label>
                            <input type="number" name="berat_kg" id="berat_kg" step="0.1" min="0"
                                class="form-control" value="<?= esc($pesanan['berat_kg']) ?>" required oninput="hitungTotal()">
                        </div>

                        <!-- Total -->
                        <div class="mb-3">
                            <label class="form-label">Total Harga</label>
                            <input type="text" id="total" class="form-control fw-bold text-primary" disabled>
                        </div>

                        <!-- Foto Transaksi -->
                        <div class="mb-3">
                            <label class="form-label">Upload Foto Transaksi</label>
                            <input type="file" name="foto_transaksi" class="form-control" accept="image/*">
                        </div>

                        <!-- Tombol -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save me-1"></i>Simpan & Proses
                            </button>
                        </div>
                    </form>
                    <script>
                        let tarif = {};
                        <?php foreach ($jenis as $j): ?>
                            tarif["<?= $j['kd_jenis'] ?>"] = <?= $j['tarif'] ?>;
                        <?php endforeach; ?>

                        function hitungTotal() {
                            let berat = parseFloat(document.getElementById('berat_kg').value) || 0;
                            let jenis = document.getElementById('kd_jenis').value;
                            let total = tarif[jenis] * berat;
                            document.getElementById('total').value = isNaN(total) ? '' : 'Rp ' + total.toLocaleString();
                        }

                        window.onload = hitungTotal;
                    </script>

                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>