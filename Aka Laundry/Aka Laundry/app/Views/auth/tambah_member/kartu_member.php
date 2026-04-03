<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Member</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root{
            --bg: #f1f4f6;
            --card: #ffffff;
            --text: #1f2937;
            --muted: #6b7280;
            --brand1: #4e73df;
            --brand2: #224abe;
            --ring: rgba(78,115,223,.25);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at 20% 10%, #eaf2ff 0%, var(--bg) 45%, #eef2f7 100%);
            margin: 0;
            color: var(--text);
        }

        .kartu {
            width: 360px;
            height: 220px;
            border-radius: 18px;
            margin: 40px auto;
            background:
                radial-gradient(circle at 25% 25%, rgba(78,115,223,.18) 0%, rgba(255,255,255,0) 55%),
                radial-gradient(circle at 85% 15%, rgba(34,74,190,.16) 0%, rgba(255,255,255,0) 50%),
                linear-gradient(135deg, #ffffff 0%, #f7f9ff 55%, #ffffff 100%);
            box-shadow: 0 14px 28px rgba(16,24,40,.12);
            border: 1px solid rgba(34,74,190,.12);
            position: relative;
            overflow: hidden;
            padding: 16px 18px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        /* accent stripe */
        .kartu::before{
            content:"";
            position:absolute;
            inset: 0;
            background:
                linear-gradient(135deg, rgba(78,115,223,.95) 0%, rgba(34,74,190,.95) 100%);
            clip-path: polygon(0 0, 62% 0, 44% 28%, 0 28%);
            opacity: .95;
            pointer-events: none;
        }

        /* subtle pattern */
        .kartu::after{
            content:"";
            position:absolute;
            right:-28px;
            bottom:-28px;
            width: 140px;
            height: 140px;
            background: radial-gradient(circle, rgba(78,115,223,.18) 0%, rgba(78,115,223,0) 70%);
            border-radius: 999px;
            pointer-events: none;
        }

        .header{
            position: relative;
            display:flex;
            align-items:center;
            justify-content: space-between;
            gap: 12px;
            padding-bottom: 4px;
        }

        .brand{
            display:flex;
            align-items:center;
            gap: 10px;
            color: #fff;
        }

        .logo-dot{
            width: 34px;
            height: 34px;
            border-radius: 999px;
            background: rgba(255,255,255,.18);
            border: 1px solid rgba(255,255,255,.28);
            box-shadow: 0 0 0 6px rgba(255,255,255,.08);
        }

        .brand-text{
            line-height: 1.1;
        }

        .brand-text .title{
            font-weight: 800;
            letter-spacing: .3px;
            font-size: 16px;
        }
        .brand-text .sub{
            font-size: 11px;
            opacity: .9;
        }

        .badge{
            position: relative;
            font-size: 11px;
            font-weight: 700;
            color: #fff;
            padding: 6px 10px;
            border-radius: 999px;
            background: rgba(255,255,255,.16);
            border: 1px solid rgba(255,255,255,.22);
            white-space: nowrap;
        }

        .content{
            position: relative;
            display:flex;
            gap: 12px;
            align-items: stretch;
            flex: 1;
        }

        .avatar{
            width: 86px;
            min-width: 86px;
            height: 86px;
            border-radius: 16px;
            background: #fff;
            border: 1px solid rgba(17,24,39,.08);
            box-shadow: 0 10px 18px rgba(16,24,40,.10);
            display:flex;
            align-items:center;
            justify-content:center;
            overflow:hidden;
        }
        .avatar img{
            width:100%;
            height:100%;
            object-fit: cover;
        }
        .avatar--placeholder{
            background: linear-gradient(135deg, rgba(78,115,223,.16), rgba(34,74,190,.10));
            color: var(--brand2);
            font-weight: 800;
            font-size: 26px;
            letter-spacing: .5px;
        }

        .info{
            flex: 1;
            background: rgba(255,255,255,.72);
            border: 1px solid rgba(17,24,39,.06);
            border-radius: 14px;
            padding: 10px 12px;
            box-shadow: inset 0 0 0 2px rgba(78,115,223,.06);
        }

        .row{
            display:grid;
            grid-template-columns: 104px 1fr;
            gap: 8px;
            font-size: 12.5px;
            line-height: 1.35;
            padding: 4px 0;
            border-bottom: 1px dashed rgba(17,24,39,.10);
        }
        .row:last-child{ border-bottom: none; }
        .k{
            color: var(--muted);
            font-weight: 600;
        }
        .v{
            color: var(--text);
            font-weight: 600;
            word-break: break-word;
        }

        .footer{
            position: relative;
            display:flex;
            align-items:center;
            justify-content: space-between;
            gap: 10px;
            font-size: 10.5px;
            color: rgba(31,41,55,.75);
        }
        .footer .pill{
            padding: 5px 9px;
            border-radius: 999px;
            border: 1px solid rgba(78,115,223,.18);
            background: rgba(78,115,223,.08);
        }

        @media print {
            body { margin: 0; background: none; }
            .kartu { box-shadow: none; border-color: rgba(0,0,0,.15); margin: 0 auto; }
        }
    </style>
</head>

<body>
<?php
// inisial jika foto kosong
$name = (string)($pelanggan['nama_pelanggan'] ?? '');
$words = preg_split('/\s+/', trim($name)) ?: [];
$initials = '';
foreach ($words as $w) {
    if ($w === '') continue;
    $initials .= mb_strtoupper(mb_substr($w, 0, 1, 'UTF-8'), 'UTF-8');
    if (mb_strlen($initials, 'UTF-8') >= 2) break;
}
$initials = $initials ?: 'AK';
?>

    <div class="kartu">
        <div class="header">
            <div class="brand">
                <div class="logo-dot" aria-hidden="true"></div>
                <div class="brand-text">
                    <div class="title">AKA Laundry</div>
                    <div class="sub">Kartu Member</div>
                </div>
            </div>
            <div class="badge">MEMBER</div>
        </div>

        <div class="content">
            <div class="avatar <?= empty($pelanggan['foto_pelanggan']) ? 'avatar--placeholder' : '' ?>">
                <?php if (!empty($pelanggan['foto_pelanggan'])): ?>
                    <img src="<?= base_url('uploads/' . $pelanggan['foto_pelanggan']) ?>" alt="Foto Member">
                <?php else: ?>
                    <?= esc($initials) ?>
                <?php endif; ?>
            </div>

            <div class="info">
                <div class="row"><div class="k">ID Pelanggan</div><div class="v"><?= esc($pelanggan['id_pelanggan']) ?></div></div>
                <div class="row"><div class="k">Nama</div><div class="v"><?= esc($pelanggan['nama_pelanggan']) ?></div></div>
                <div class="row"><div class="k">Alamat</div><div class="v"><?= esc($pelanggan['alamat_pelanggan']) ?></div></div>
                <div class="row"><div class="k">Kelamin</div><div class="v"><?= esc($pelanggan['jeniskelamin']) ?></div></div>
                <div class="row"><div class="k">No. Telp</div><div class="v"><?= esc($pelanggan['no_pelanggan']) ?></div></div>
            </div>
        </div>

        <div class="footer">
            <div class="pill">Valid • Customer</div>
            <div>Printed: <?= esc(date('Y-m-d H:i')) ?></div>
        </div>
    </div>

    <script>
        window.onload = function() { window.print(); };
    </script>
</body>
</html>