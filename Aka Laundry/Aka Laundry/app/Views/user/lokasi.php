<?= $this->extend('user/templates') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="text-center mb-4">
        <h2 class="fw-bold mb-1">Lokasi AKA Laundry</h2>
        <p class="text-muted mb-0">Alamat, jam operasional, dan petunjuk arah.</p>
    </div>

    <div class="row g-4 align-items-stretch">
        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">AKA Laundry (Cabang Utama)</h5>

                    <div class="mb-2">
                        <i class="fa-solid fa-location-dot text-danger me-2"></i>
                        <strong>Alamat:</strong>
                        <div class="text-muted">Jl. Babakan Lio No.11, RT.01/RW.08, Balungbangjaya, Kec. Bogor Bar., Kota Bogor, Jawa Barat 16116</div>
                    </div>

                    <div class="mb-2">
                        <i class="fa-solid fa-clock text-warning me-2"></i>
                        <strong>Jam Operasional:</strong>
                        <div class="text-muted">Senin–Minggu, 08.00–21.00</div>
                    </div>

                    <div class="mb-2">
                        <i class="fa-solid fa-phone text-success me-2"></i>
                        <strong>Telepon/WA:</strong>
                        <div class="text-muted">0822-5877-9965</div>
                    </div>

                    <div class="mb-2">
                        <i class="fa-solid fa-envelope text-primary me-2"></i>
                        <strong>Email:</strong>
                        <div class="text-muted">aka.laundry@example.com</div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-3">
                        <a class="btn btn-warning fw-bold rounded-pill"
                           target="_blank"
                                    href="https://www.google.com/maps?q=-6.558566245181559,106.73781993744431">
                            <i class="fa-solid fa-map-location-dot me-2"></i>Buka Google Maps
                        </a>

                        <a class="btn btn-outline-dark rounded-pill"
                           href="<?= site_url('user/index') ?>">
                            <i class="fa-solid fa-house me-2"></i>Kembali ke Home
                        </a>
                    </div>

                    <hr class="my-4">

                    <div class="small text-muted">
                        Tips: untuk akurasi, ganti query link Maps dan alamat sesuai lokasi toko sebenarnya.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-0">
                    <div class="ratio ratio-4x3">
                        <iframe
                            src="https://www.google.com/maps?q=-6.558566245181559,106.73781993744431&output=embed"
                            style="border:0;"
                            allowfullscreen
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
