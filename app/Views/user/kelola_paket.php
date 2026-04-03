<?= $this->extend('templates/home') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <h1 class="h3 mb-4 text-gray-800">Kelola Paket Layanan</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-gradient-primary text-white">
            <h6 class="m-0 font-weight-bold">Daftar Paket</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Paket</th>
                            <th>Harga</th>
                            <th>Keterangan 1</th>
                            <th>Keterangan 2</th>
                            <th>Keterangan 3</th>
                            <th>Warna</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($paket as $p): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($p['name']) ?></td>
                                <td><?= esc($p['price']) ?></td>
                                <td><?= esc($p['feature1']) ?></td>
                                <td><?= esc($p['feature2']) ?></td>
                                <td><?= esc($p['feature3']) ?></td>
                                <td>
                                    <span class="badge"
                                        style="background-color: <?= esc($p['color']) ?>;
                                                 color: <?= hexdec(str_replace('#', '', $p['color'])) < 0x888888 ? '#fff' : '#000' ?>;
                                                 padding: 6px 12px;
                                                 border-radius: 12px;">
                                        <?= esc($p['color']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= base_url('/pelayanan/edit/' . $p['id']) ?>"
                                        class="btn btn-sm btn-primary shadow-sm">
                                        <i class="fas fa-edit fa-sm"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>