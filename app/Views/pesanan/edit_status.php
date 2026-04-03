<?= $this->extend('templates/home'); ?>
<?= $this->section('content'); ?>

<?php
$currentStatus = (string)($pesanan['status'] ?? '');
$allowedStatus = ['Menunggu', 'Proses', 'Selesai'];
?>

<style>
    /* selaras dengan UI modern lainnya */
    .edit-card { border: none; border-radius: 15px; overflow: hidden; }
    .edit-header{
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color:#fff;
        padding: 18px 20px;
    }
    .edit-header .status-badge{
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
        padding:16px 16px;
        margin-bottom:16px;
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

            <div class="card edit-card shadow mb-4">
                <div class="edit-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h4 class="mb-1 font-weight-bold">
                                <i class="fas fa-sync-alt mr-2"></i>Ubah Status Pesanan
                            </h4>
                            <div class="helper-text text-white-50">Update status pesanan berdasarkan progress terbaru.</div>
                        </div>
                        <div class="mt-2 mt-md-0 text-right">
                            <span class="status-badge">
                                <i class="fas fa-receipt mr-1"></i><?= esc($pesanan['no_resi']) ?>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-section">
                                <h6><i class="fas fa-info-circle mr-2"></i>Informasi Pesanan</h6>
                                <div class="mb-2"><span class="text-muted">No Resi:</span> <b><?= esc($pesanan['no_resi']) ?></b></div>
                                <div class="mb-2"><span class="text-muted">Pelanggan:</span> <b><?= esc($pesanan['nama_pelanggan']) ?></b></div>
                                <div class="mb-2"><span class="text-muted">Jenis:</span> <b><?= esc($pesanan['jenis_laundry']) ?></b></div>
                                <div class="mb-2"><span class="text-muted">Berat:</span> <b><?= esc($pesanan['berat_kg']) ?> Kg</b></div>
                                <div class="mb-0">
                                    <span class="text-muted">Status Saat Ini:</span>
                                    <span class="badge badge-info"><?= esc($currentStatus ?: '-') ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <form action="<?= base_url('/pesanan/update-status/' . $pesanan['id_pesanan']) ?>" method="post">
                                <div class="info-section">
                                    <h6><i class="fas fa-edit mr-2"></i>Ubah Status</h6>

                                    <div class="form-group">
                                        <label class="font-weight-bold" for="status">Pilih Status Baru</label>
                                        <select name="status" id="status" class="form-control" onchange="toggleStatusSelesai()" required>
                                            <?php if ($currentStatus && !in_array($currentStatus, $allowedStatus, true)): ?>
                                                <option value="<?= esc($currentStatus) ?>" selected disabled>
                                                    Status lama: <?= esc($currentStatus) ?> (tidak dipakai lagi)
                                                </option>
                                            <?php endif; ?>

                                            <?php foreach ($allowedStatus as $s): ?>
                                                <option value="<?= esc($s) ?>" <?= ($s === $currentStatus) ? 'selected' : '' ?>>
                                                    <?= esc($s) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="helper-text mt-2">Pilihan status kini dibatasi: Menunggu, Proses, Selesai.</div>
                                    </div>

                                    <div id="status_selesai_box" class="form-group" style="display:none;">
                                        <label class="font-weight-bold" for="status_selesai">Status Setelah Selesai</label>
                                        <select name="status_selesai" id="status_selesai" class="form-control">
                                            <option value="">-- Pilih --</option>
                                            <option value="Sudah Diambil" <?= (($pesanan['status_selesai'] ?? '') === 'Sudah Diambil') ? 'selected' : '' ?>>Sudah Diambil</option>
                                            <option value="Belum Diambil" <?= (($pesanan['status_selesai'] ?? '') === 'Belum Diambil') ? 'selected' : '' ?>>Belum Diambil</option>
                                        </select>
                                        <div class="helper-text mt-2">Wajib dipilih jika status = Selesai.</div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary shadow-sm">
                                        <i class="fas fa-save mr-1"></i>Simpan Perubahan
                                    </button>
                                </div>

                                <div class="mt-3">
                                    <a href="<?= base_url('/pesanancontroller/index') ?>" class="btn btn-secondary btn-block">
                                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div><!-- /row -->
                </div><!-- /card-body -->
            </div><!-- /card -->

        </div>
    </div>
</div>

<script>
    function toggleStatusSelesai() {
        const statusEl = document.getElementById('status');
        const box = document.getElementById('status_selesai_box');
        const selesaiEl = document.getElementById('status_selesai');
        if (!statusEl || !box || !selesaiEl) return;

        const isSelesai = (statusEl.value === 'Selesai');
        box.style.display = isSelesai ? 'block' : 'none';
        selesaiEl.required = isSelesai;

        if (!isSelesai) selesaiEl.value = '';
    }

    window.addEventListener('DOMContentLoaded', toggleStatusSelesai);
</script>

<?= $this->endSection(); ?>