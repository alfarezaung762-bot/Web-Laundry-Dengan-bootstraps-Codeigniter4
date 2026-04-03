<?= $this->extend('templates/home'); ?>
<?= $this->section('content'); ?>
<div class="container py-4">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body text-center">
            <h4 class="mb-3">Struk Siap Dicetak</h4>
            <p>Resi: <strong><?= esc($pesanan['no_resi']) ?></strong></p>
            <a href="<?= base_url('/pesanancontroller/cetakstruk/' . $pesanan['id_pesanan']) ?>" target="_blank" class="btn btn-primary">
                🧾 Cetak Struk Sekarang
            </a>
            <a href="<?= base_url('/kurir/pickup-admin') ?>" class="btn btn-secondary ms-2">⬅️ Kembali ke Daftar</a>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>