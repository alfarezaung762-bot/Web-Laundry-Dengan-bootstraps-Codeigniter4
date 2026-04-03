<?= $this->extend('templates/home') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <h3>Edit Paket Layanan</h3>
    <form action="<?= base_url('/pelayanan/update/' . $paket['id']) ?>" method="post">
        <div class="mb-3">
            <label>Nama Paket</label>
            <input type="text" name="name" class="form-control" value="<?= esc($paket['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="text" name="price" class="form-control" value="<?= esc($paket['price']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi 1</label>
            <input type="text" name="feature1" class="form-control" value="<?= esc($paket['feature1']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi 2</label>
            <input type="text" name="feature2" class="form-control" value="<?= esc($paket['feature2']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi 3</label>
            <input type="text" name="feature3" class="form-control" value="<?= esc($paket['feature3']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Warna Background (misal: #ffb74d)</label>
            <input type="color" name="color" class="form-control form-control-color" value="<?= esc($paket['color']) ?>" title="Pilih warna background">
        </div>
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="<?= base_url('/user/kelola_paket') ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?= $this->endSection() ?>