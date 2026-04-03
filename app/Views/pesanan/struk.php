<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk AKA Laundry</title>
    <style>
        :root {
            --bg: #f3f4f6;
            --card: #ffffff;
            --text: #111827;
            --muted: #6b7280;
            --brand1: #4e73df;
            --brand2: #224abe;
            --border: rgba(17, 24, 39, .12);
        }

        body {
            font-family: Arial, sans-serif;
            background: var(--bg);
            margin: 0;
            padding: 24px;
            color: var(--text);
        }

        .wrap {
            max-width: 560px;
            margin: 0 auto;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: 0 10px 24px rgba(16, 24, 40, .10);
            overflow: hidden;
        }

        .header {
            padding: 18px 18px 14px;
            background: linear-gradient(135deg, var(--brand1) 0%, var(--brand2) 100%);
            color: #fff;
        }

        .header .title {
            font-size: 18px;
            font-weight: 800;
            letter-spacing: .2px;
            margin: 0;
        }

        .header .sub {
            margin: 6px 0 0;
            font-size: 12px;
            opacity: .9;
        }

        .body {
            padding: 16px 18px;
        }

        .kv {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .kv tr td {
            padding: 7px 0;
            vertical-align: top;
            border-bottom: 1px dashed rgba(17, 24, 39, .14);
        }

        .kv tr:last-child td {
            border-bottom: none;
        }

        .k {
            width: 160px;
            color: var(--muted);
            font-weight: 700;
        }

        .v {
            font-weight: 700;
            color: var(--text);
        }

        .sep {
            height: 10px;
        }

        .total {
            margin-top: 14px;
            padding: 12px 12px;
            border-radius: 12px;
            background: rgba(78, 115, 223, .08);
            border: 1px solid rgba(78, 115, 223, .18);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .total .label {
            color: var(--muted);
            font-weight: 700;
        }

        .total .amount {
            font-size: 16px;
            font-weight: 900;
        }

        .footer {
            padding: 14px 18px 18px;
            color: var(--muted);
            font-size: 12px;
            text-align: center;
        }

        @media print {
            body {
                background: none;
                padding: 0;
            }

            .card {
                box-shadow: none;
                border-color: rgba(0, 0, 0, .18);
            }
        }
    </style>
</head>

<body>
    <?php
    // ...existing code...
    $tarif = (float)($pesanan['tarif'] ?? 0);
    $berat = (float)($pesanan['berat_kg'] ?? 0);
    $total = $tarif * $berat;
    ?>
    <div class="wrap">
        <div class="card">
            <div class="header">
                <p class="title">Struk AKA Laundry</p>
                <p class="sub">Simpan struk ini sebagai bukti transaksi.</p>
            </div>

            <div class="body">
                <table class="kv">
                    <tr>
                        <td class="k">No Resi</td>
                        <td class="v"><?= esc($pesanan['no_resi'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="k">Tanggal</td>
                        <td class="v"><?= esc(!empty($pesanan['created_at']) ? date('d-m-Y H:i', strtotime($pesanan['created_at'])) : '-') ?></td>
                    </tr>
                    <tr>
                        <td class="k">ID Pelanggan</td>
                        <td class="v"><?= esc($pesanan['id_pelanggan'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="k">Nama Pelanggan</td>
                        <td class="v"><?= esc($pesanan['nama_pelanggan'] ?? '-') ?></td>
                    </tr>

                    <tr class="sep">
                        <td colspan="2"></td>
                    </tr>

                    <tr>
                        <td class="k">Jenis</td>
                        <td class="v"><?= esc($pesanan['jenis_laundry'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="k">Berat</td>
                        <td class="v"><?= esc($pesanan['berat_kg'] ?? '-') ?> Kg</td>
                    </tr>
                    <tr>
                        <td class="k">Tarif / Kg</td>
                        <td class="v">Rp <?= number_format($tarif, 0, ',', '.') ?></td>
                    </tr>

                    <tr class="sep">
                        <td colspan="2"></td>
                    </tr>

                    <tr>
                        <td class="k">Washer (ID)</td>
                        <td class="v"><?= esc($pesanan['id_washer'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="k">Washer (Nama)</td>
                        <td class="v"><?= esc($pesanan['nama_washer'] ?? '-') ?></td>
                    </tr>
                </table>

                <div class="total">
                    <div class="label">Total</div>
                    <div class="amount">Rp <?= number_format($total, 0, ',', '.') ?></div>
                </div>
            </div>

            <div class="footer">
                Terima kasih telah menggunakan layanan kami!
            </div>
        </div>
    </div>

    <script>
        (function () {
            function redirectBack() {
                // kembalikan ke daftar pesanan (kurir sudah dihapus)
                window.location.href = "<?= base_url('/pesanancontroller/index') ?>";
            }

            window.onafterprint = function () {
                setTimeout(redirectBack, 300);
            };

            window.onload = function () {
                window.print();
                setTimeout(redirectBack, 2500);
            };
        })();
    </script>
</body>

</html>