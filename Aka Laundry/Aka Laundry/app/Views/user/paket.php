<?= $this->extend('user/templates') ?>
<?= $this->section('content') ?>

<div class="container py-5" style="position: relative; z-index: 10;">
    <div class="text-center mb-5">
        <h2 class="section-title">Paket Layanan Kami</h2>
        <p class="text-muted">Layanan terbaik sesuai dengan kebutuhan Anda</p>
    </div>

    <div class="row g-4 justify-content-center">
        <?php foreach ($paket as $index => $service): ?>
            <div class="col-md-4">
                <div class="card h-100 p-4 text-center service-card" style="background-color: <?= esc($service['color']) ?>;">
                    <h3 class="fw-bold mb-3"><?= esc($service['name']) ?></h3>
                    <div class="price mb-3"><?= esc($service['price']) ?></div>
                    <hr class="my-3">
                    <ul class="list-unstyled features-list mb-4">
                        <li class="mb-2"><span class="check-icon">✔</span> <?= esc($service['feature1']) ?></li>
                        <li class="mb-2"><span class="check-icon">✔</span> <?= esc($service['feature2']) ?></li>
                        <li class="mb-2"><span class="check-icon">✔</span> <?= esc($service['feature3']) ?></li>
                    </ul>
                    <a href="<?= base_url('/user/pickup') ?>" class="btn btn-light rounded-pill fw-bold px-4 py-2 choose-btn">
                        Pilih Paket
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="text-center mt-5">
        <p class="fw-bold fs-5 text-warning-emphasis">
            Datang ke outlet kami untuk daftar Member Keanggotaan (Gratis)
        </p>
    </div>
</div>

<style>
    .service-card {
        border-radius: 15px;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    <?php for ($i = 1; $i <= 6; $i++): ?>.service-card:nth-child(<?= $i ?>) {
        animation-delay: <?= 0.1 * $i ?>s;
    }

    <?php endfor; ?>.service-card:hover {
        transform: translateY(-10px) scale(1.03);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.25);
        background-color: #fff !important;
        color: #333 !important;
    }

    .service-card:hover h3,
    .service-card:hover .price,
    .service-card:hover .features-list li,
    .service-card:hover .choose-btn {
        color: #333 !important;
    }

    .check-icon {
        display: inline-block;
        margin-right: 8px;
        color: #4caf50;
        font-weight: bold;
        position: relative;
        top: 1px;
        transition: transform 0.3s ease, color 0.3s ease;
    }

    .service-card:hover .check-icon {
        color: #388e3c;
        transform: scale(1.3) translateX(4px);
    }

    .choose-btn {
        background-color: #fff;
        color: #333;
        border: 2px solid transparent;
        transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
    }

    .service-card:hover .choose-btn {
        background-color: #4caf50;
        color: white;
        border-color: #388e3c;
        box-shadow: 0 4px 12px rgba(72, 180, 97, 0.6);
    }

    @media (max-width: 576px) {
        .service-card {
            padding: 2rem 1.5rem;
        }

        .service-card h3 {
            font-size: 1.5rem;
        }

        .service-card .price {
            font-size: 1.2rem;
        }
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .text-warning-emphasis {
        color: #f57f17;
        /* lebih dalam dari kuning Bootstrap */
    }
</style>

<?= $this->endSection() ?>