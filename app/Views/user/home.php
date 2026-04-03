<?php
declare(strict_types=1);

use App\Models\Tb_Jenis;
use App\Models\TbReviewModel;

$brandName = 'AKA Laundry';
$logoUrl = base_url('img/356bf6d1-70af-4c10-97c7-8b3a8d3890d0.png'); // login\public\img\...

try {
    $paketList = (new Tb_Jenis())->getAllForPublic();
} catch (Throwable $e) {
    $paketList = [];
}

// Ambil data review
try {
    $reviewModel = new TbReviewModel();
    $reviewList = $reviewModel->getLatestReviews(10);
    $avgRating = $reviewModel->getAverageRating();
    $totalReviews = $reviewModel->getTotalReviews();
} catch (Throwable $e) {
    $reviewList = [];
    $avgRating = 0;
    $totalReviews = 0;
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

        /* Review Styles */
        .review-card{
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 16px;
            margin-bottom: 16px;
            box-shadow: 0 6px 16px rgba(0,0,0,.06);
        }
        .review-header{
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }
        .review-name{
            font-weight: 700;
            margin: 0;
        }
        .review-date{
            font-size: .8rem;
            color: var(--muted);
        }
        .review-stars{
            color: #f59e0b;
            margin-bottom: 8px;
        }
        .review-comment{
            color: var(--muted);
            margin: 0;
            line-height: 1.5;
        }
        .rating-input{
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            gap: 4px;
        }
        .rating-input input{
            display: none;
        }
        .rating-input label{
            cursor: pointer;
            font-size: 1.5rem;
            color: #d1d5db;
            transition: color .15s;
        }
        .rating-input label:hover,
        .rating-input label:hover ~ label,
        .rating-input input:checked ~ label{
            color: #f59e0b;
        }
        .avg-rating-display{
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .avg-rating-number{
            font-size: 2rem;
            font-weight: 900;
        }
        .avg-rating-stars{
            color: #f59e0b;
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
                    <a class="btn btn-warning fw-bold" href="<?= base_url('/user/lokasi') ?>">
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

                <form action="<?= base_url('/pesanancontroller/trackingresult') ?>" method="get" class="row g-2">
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

    <!-- Review Section -->
    <section id="review-section" class="section pt-0">
        <div class="container">
            <div class="info-card p-4">
                <div class="d-flex justify-content-between align-items-end flex-wrap gap-2 mb-4">
                    <div>
                        <h2 class="section-title h4 mb-1">Ulasan Pelanggan</h2>
                        <p class="section-sub mb-0">Lihat apa kata pelanggan kami atau berikan ulasan Anda.</p>
                    </div>
                    <?php if ($totalReviews > 0): ?>
                    <div class="avg-rating-display">
                        <span class="avg-rating-number"><?= number_format($avgRating, 1) ?></span>
                        <div>
                            <div class="avg-rating-stars">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fa-<?= $i <= round($avgRating) ? 'solid' : 'regular' ?> fa-star"></i>
                                <?php endfor; ?>
                            </div>
                            <div class="small text-muted"><?= $totalReviews ?> ulasan</div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Flash Messages -->
                <?php if (session()->getFlashdata('review_success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-check-circle me-2"></i><?= esc(session()->getFlashdata('review_success')) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('review_error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-exclamation-circle me-2"></i><?= esc(session()->getFlashdata('review_error')) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Form Review -->
                <div class="mb-4 p-3" style="background: rgba(248,181,0,.1); border-radius: 12px;">
                    <h5 class="fw-bold mb-3"><i class="fa-solid fa-pen me-2"></i>Tulis Ulasan</h5>
                    <form action="<?= base_url('review/submit') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="nama_cust" class="form-label fw-semibold">Nama Anda</label>
                                <input type="text" class="form-control" id="nama_cust" name="nama_cust" 
                                       placeholder="Masukkan nama Anda" required minlength="2" maxlength="100"
                                       value="<?= esc(old('nama_cust') ?? '') ?>">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold">Rating</label>
                                <div class="rating-input">
                                    <?php for ($i = 5; $i >= 1; $i--): ?>
                                        <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>" <?= old('rating') == $i ? 'checked' : '' ?> required>
                                        <label for="star<?= $i ?>" title="<?= $i ?> bintang"><i class="fa-solid fa-star"></i></label>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="komen" class="form-label fw-semibold">Komentar (opsional)</label>
                                <textarea class="form-control" id="komen" name="komen" rows="3" 
                                          placeholder="Ceritakan pengalaman Anda..." maxlength="1000"><?= esc(old('komen') ?? '') ?></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-warning fw-bold">
                                    <i class="fa-solid fa-paper-plane me-2"></i>Kirim Ulasan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Daftar Review -->
                <h5 class="fw-bold mb-3"><i class="fa-solid fa-comments me-2"></i>Ulasan Terbaru</h5>
                <?php if (empty($reviewList)): ?>
                    <div class="text-muted text-center py-4">
                        <i class="fa-regular fa-comment-dots fa-3x mb-3 d-block" style="opacity:.4"></i>
                        Belum ada ulasan. Jadilah yang pertama memberikan ulasan!
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($reviewList as $review): ?>
                            <div class="col-12 col-md-6">
                                <div class="review-card">
                                    <div class="review-header">
                                        <h6 class="review-name"><?= esc($review['nama_cust'] ?? 'Anonim') ?></h6>
                                        <span class="review-date">
                                            <?= date('d M Y', strtotime($review['tgl_review'] ?? 'now')) ?>
                                        </span>
                                    </div>
                                    <div class="review-stars">
                                        <?php 
                                        $rating = (int)($review['rating'] ?? 0);
                                        for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fa-<?= $i <= $rating ? 'solid' : 'regular' ?> fa-star"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <?php if (!empty($review['komen'])): ?>
                                        <p class="review-comment"><?= esc($review['komen']) ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<footer class="footer">
    <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div><b><?= esc($brandName) ?></b> &middot; Laundry cepat dan rapi.</div>
        <div class="small">© <?= date('Y') ?> <?= esc($brandName) ?></div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php endif; ?>