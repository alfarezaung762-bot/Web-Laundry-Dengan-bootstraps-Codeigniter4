<!DOCTYPE html>
<html>

<head>
    <title>Struk Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
        }

        .struk-container {
            max-width: 600px;
            margin: auto;
            border: 1px dashed #000;
            padding: 30px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .row {
            margin-bottom: 10px;
        }

        .label {
            font-weight: bold;
            display: inline-block;
            width: 180px;
        }

        .value {
            display: inline-block;
        }

        hr {
            border: none;
            border-top: 1px dashed #999;
            margin: 20px 0;
        }

        .note {
            margin-top: 20px;
            font-style: italic;
            text-align: center;
        }

        @media print {
            button {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="struk-container">
        <h2>🧺 AKA Laundry - Struk Pesanan</h2>

        <?php if ($pesanan): ?>
            <div class="row"><span class="label">No Resi:</span> <span class="value"><?= $pesanan['no_resi'] ?></span></div>
            <div class="row"><span class="label">ID Pelanggan:</span> <span class="value"><?= $pesanan['id_pelanggan'] ?></span></div>
            <div class="row"><span class="label">Nama Pelanggan:</span> <span class="value"><?= $pesanan['nama_pelanggan'] ?></span></div>
            <div class="row"><span class="label">No HP:</span> <span class="value"><?= $pesanan['no_pelanggan'] ?></span></div>
            <div class="row"><span class="label">Alamat:</span> <span class="value"><?= $pesanan['alamat_pelanggan'] ?></span></div>
            <div class="row"><span class="label">Tanggal Masuk:</span> <span class="value"><?= $pesanan['tanggal_masuk'] ?></span></div>
            <div class="row"><span class="label">Tanggal Cetak:</span> <span class="value"><?= date('d-m-Y H:i') ?></span></div>

            <hr>

            <div class="row"><span class="label">Jenis Laundry:</span> <span class="value"><?= $pesanan['jenis_laundry'] ?></span></div>
            <div class="row"><span class="label">Berat:</span> <span class="value"><?= $pesanan['berat_kg'] ?> Kg</span></div>
            <div class="row"><span class="label">Tarif /Kg:</span> <span class="value">Rp <?= number_format($pesanan['tarif']) ?></span></div>
            <div class="row"><span class="label">Total:</span> <span class="value"><strong>Rp <?= number_format($pesanan['berat_kg'] * $pesanan['tarif']) ?></strong></span></div>

            <hr>

            <div class="row"><span class="label">Status:</span> <span class="value"><?= $pesanan['status'] ?></span></div>
            <div class="row"><span class="label">Status Selesai:</span> <span class="value"><?= $pesanan['status_selesai'] ?? '-' ?></span></div>

            <?php if (!empty($pesanan['nama_admin'])): ?>
                <div class="row"><span class="label">Admin:</span> <span class="value"><?= esc($pesanan['nama_admin']) ?></span></div>
            <?php endif; ?>

            <?php if (!empty($pesanan['nama_washer'])): ?>
                <div class="row"><span class="label">Petugas Cuci:</span> <span class="value"><?= esc($pesanan['nama_washer']) ?></span></div>
            <?php endif; ?>

            <?php if (!empty($pesanan['nama_kurir'])): ?>
                <div class="row"><span class="label">Kurir:</span> <span class="value"><?= esc($pesanan['nama_kurir']) ?></span></div>
            <?php endif; ?>

            <p class="note">Terima kasih telah menggunakan layanan NT Laundry!</p>
        <?php else: ?>
            <p>Data pesanan tidak ditemukan.</p>
        <?php endif; ?>
    </div>

    <script>
        window.print();
    </script>

</body>

</html>