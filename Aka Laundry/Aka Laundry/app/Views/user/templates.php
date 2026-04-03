<?php
declare(strict_types=1);

use App\Models\Tb_Jenis;

$brandName = 'AKA Laundry';
$logoUrl = base_url('img/356bf6d1-70af-4c10-97c7-8b3a8d3890d0.png'); // login\public\img\...

try {
    $paketList = (new Tb_Jenis())->getAllForPublic();
} catch (Throwable $e) {
    $paketList = [];
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($brandName) ?> - Informasi</title>

    <!-- Bootstrap 5 (halaman pelanggan) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" referrerpolicy="no-referrer" />

    <style>
        :root{
            --bg:#fffde7;
            --ink:#111827;
            --muted:#6b7280;
            --card: rgba(255,255,255,.86);
            --border: rgba(17,24,39,.10);
            --shadow: 0 14px 34px rgba(0,0,0,.12);
            --grad: linear-gradient(135deg, rgba(252,234,187,.85) 0%, rgba(248,181,0,.85) 100%);
        }

        body{
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
            background:
                radial-gradient(1200px 520px at 15% -10%, rgba(248,181,0,.28), transparent 60%),
                radial-gradient(900px 520px at 100% 20%, rgba(252,234,187,.45), transparent 65%),
                var(--bg);
            color: var(--ink);
            overflow-x: hidden;
        }

        .topbar{
            backdrop-filter: blur(10px);
            background: rgba(255,255,255,.75);
            border-bottom: 1px solid var(--border);
        }

        .brand-lockup{ display:flex; align-items:center; gap:12px; }
        .brand-logo{
            width:46px; height:46px; object-fit:contain;
            filter: drop-shadow(0 10px 14px rgba(0,0,0,.10));
        }
        .brand-title{ font-weight: 900; letter-spacing: .2px; line-height: 1.1; margin:0; }
        .brand-sub{ color: var(--muted); font-size: .9rem; }

        .hero{ padding: 3.25rem 0 1.25rem; }
        .hero-card{
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }
        .hero-head{
            padding: 18px;
            background: var(--grad);
            border-bottom: 1px solid rgba(17,24,39,.08);
        }
        .hero-body{ padding: 18px; color: var(--muted); }

        .section{ padding: 1.25rem 0 3.25rem; }
        .section-title{
            font-weight: 900;
            letter-spacing: .2px;
            margin: 0 0 .25rem 0;
        }
        .section-sub{ color: var(--muted); margin: 0; }

        .info-card{
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: 0 10px 24px rgba(0,0,0,.10);
        }

        .paket-card{
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: 0 10px 24px rgba(0,0,0,.10);
            overflow: hidden;
            height: 100%;
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .paket-card:hover{
            transform: translateY(-4px);
            box-shadow: 0 16px 36px rgba(0,0,0,.14);
        }
        .paket-top{
            padding: 14px 16px;
            background: var(--grad);
            border-bottom: 1px solid rgba(17,24,39,.08);
        }
        .paket-name{ font-weight: 900; margin:0; }
        .paket-badge{
            display:inline-flex; align-items:center; gap:8px;
            margin-top: 8px;
            padding: 6px 10px;
            border-radius: 999px;
            background: rgba(17,24,39,.08);
            border: 1px solid rgba(17,24,39,.10);
            font-weight: 700;
            font-size: .85rem;
        }
        .paket-body{ padding: 14px 16px 16px; }
        .paket-desc{ color: var(--muted); min-height: 44px; }
        .paket-price{ font-weight: 900; font-variant-numeric: tabular-nums; }

        .footer{
            padding: 22px 0 30px;
            color: var(--muted);
            border-top: 1px solid var(--border);
            background: rgba(255,255,255,.55);
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg topbar sticky-top">
    <div class="container">
        <a class="navbar-brand brand-lockup text-decoration-none" href="<?= site_url('user/index') ?>">
            <img class="brand-logo" src="<?= esc($logoUrl) ?>" alt="Logo <?= esc($brandName) ?>">
            <div>
                <p class="brand-title"><?= esc($brandName) ?></p>
                <div class="brand-sub">Informasi layanan, lokasi, dan cek resi</div>
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navPelanggan" aria-controls="navPelanggan" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div id="navPelanggan" class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav align-items-lg-center gap-lg-2">
                <li class="nav-item"><a class="nav-link" href="<?= site_url('user/index') ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= site_url('user/lokasi') ?>">Lokasi</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= site_url('user/tentang') ?>">Tentang</a></li>
                <li class="nav-item">
                    <a class="btn btn-dark ms-lg-2" href="#cek-resi">
                        <i class="fa-solid fa-magnifying-glass me-2"></i>Cek Resi
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<?php $pageContent = trim($this->renderSection('content')); ?>

<?php if ($pageContent !== ''): ?>
    <main class="py-4">
        <?= $pageContent ?>
    </main>
<?php else: ?>

    <header class="hero">
        <div class="container">
            <div class="hero-card">
                <div class="hero-head d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <h1 class="h4 m-0 fw-bold">Selamat datang di <?= esc($brandName) ?></h1>
                    <span class="badge text-bg-dark">
                        <i class="fa-solid fa-store me-2"></i>Transaksi Offline
                    </span>
                </div>
                <div class="hero-body">
                    Kami melayani laundry dengan sistem <b>offline</b>. Halaman ini untuk informasi paket layanan, lokasi, dan pengecekan resi.
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- Paket Layanan -->
        <section class="section">
            <div class="container">
                <div class="d-flex justify-content-between align-items-end flex-wrap gap-2 mb-3">
                    <div>
                        <h2 class="section-title h4">Paket Layanan</h2>
                    </div>
                    <span class="badge text-bg-warning text-dark">
                        <i class="fa-solid fa-tags me-2"></i><?= esc((string)count($paketList)) ?> Paket
                    </span>
                </div>

                <?php if (empty($paketList)): ?>
                    <div class="alert alert-warning mb-0">
                        Paket belum tersedia atau gagal memuat data dari <code>tb_jenis</code>.
                    </div>
                <?php else: ?>
                    <div class="row g-4">
                        <?php foreach ($paketList as $p): ?>
                            <?php
                                $nama = (string)($p['jenis_laundry'] ?? '-');
                                $desc = (string)($p['deskripsi'] ?? '');
                                $tarif = (float)($p['tarif'] ?? 0);
                            ?>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="paket-card">
                                    <div class="paket-top">
                                        <p class="paket-name"><?= esc($nama) ?></p>
                                        <span class="paket-badge">
                                            <i class="fa-solid fa-scale-balanced"></i>
                                            Tarif per Kg
                                        </span>
                                    </div>
                                    <div class="paket-body">
                                        <div class="paket-desc mb-3">
                                            <?= esc($desc !== '' ? $desc : 'Silakan datang ke toko untuk info detail layanan paket ini.') ?>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="small text-muted">Mulai dari</div>
                                                <div class="paket-price">Rp <?= number_format($tarif, 0, ',', '.') ?></div>
                                            </div>
                                            <a class="btn btn-outline-dark" href="<?= site_url('user/tentang') ?>">
                                                <i class="fa-solid fa-circle-info me-2"></i>Info
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Lokasi -->
        <section class="section pt-0">
            <div class="container">
                <div class="info-card p-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h2 class="section-title h4 mb-1">Lokasi</h2>
                            <p class="section-sub mb-0">Lihat alamat dan petunjuk lokasi toko.</p>
                        </div>
                        <a class="btn btn-warning fw-bold" href="<?= site_url('user/lokasi') ?>">
                            <i class="fa-solid fa-location-dot me-2"></i>Lihat Lokasi
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Cek Resi -->
        <section id="cek-resi" class="section pt-0">
            <div class="container">
                <div class="info-card p-4">
                    <div class="mb-3">
                        <h2 class="section-title h4 mb-1">Cek Resi</h2>
                        <p class="section-sub mb-0">Masukkan nomor resi untuk melihat status pesanan.</p>
                    </div>

                    <form action="<?= site_url('pesanancontroller/trackingresult') ?>" method="get" class="row g-2">
                        <div class="col-12 col-md-8">
                            <input type="text" name="no_resi" class="form-control" placeholder="Contoh: LN-250101-001" required>
                        </div>
                        <div class="col-12 col-md-4 d-grid">
                            <button class="btn btn-dark" type="submit">
                                <i class="fa-solid fa-magnifying-glass me-2"></i>Cek
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

<?php endif; ?>

<footer class="footer">
    <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div><b><?= esc($brandName) ?></b> &middot; Laundry cepat dan rapi.</div>
        <div class="small">© <?= date('Y') ?> <?= esc($brandName) ?></div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>