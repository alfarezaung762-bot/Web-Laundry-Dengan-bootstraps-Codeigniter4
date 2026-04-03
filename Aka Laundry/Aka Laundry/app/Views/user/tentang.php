<?= $this->extend('user/templates') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row align-items-center g-4">
        <div class="col-12 col-lg-7">
            <h2 class="fw-bold mb-2">Tentang AKA Laundry</h2>
            <p class="text-muted mb-3">
                <b>AKA Laundry</b> adalah layanan laundry yang berfokus pada kualitas hasil cuci, ketepatan waktu,
                dan pengalaman pelanggan yang rapi dari awal sampai selesai.
            </p>

            <div class="d-flex flex-wrap gap-2">
                <a href="<?= site_url('user/lokasi') ?>" class="btn btn-warning fw-bold rounded-pill">
                    <i class="fa-solid fa-location-dot me-2"></i>Lihat Lokasi
                </a>
                <a href="<?= site_url('user/index') ?>#cek-resi" class="btn btn-outline-dark rounded-pill">
                    <i class="fa-solid fa-magnifying-glass me-2"></i>Cek Resi
                </a>
            </div>
        </div>

        <div class="col-12 col-lg-5 text-center">
            <img src="/laundry_logo.png"
                 alt="Logo AKA Laundry"
                 class="img-fluid"
                 style="max-width: 320px;">
        </div>
    </div>

    <hr class="my-4">

    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-2"><i class="fa-solid fa-bullseye me-2 text-warning"></i>Visi</h5>
                    <p class="text-muted mb-0">
                        Menjadi pilihan utama layanan laundry yang bersih, rapi, dan terpercaya di area sekitar.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-2"><i class="fa-solid fa-list-check me-2 text-warning"></i>Misi</h5>
                    <ul class="text-muted mb-0 ps-3">
                        <li>Memberikan hasil cuci yang bersih, wangi, dan terawat.</li>
                        <li>Menjaga ketepatan waktu pengerjaan.</li>
                        <li>Mengutamakan layanan pelanggan yang cepat dan jelas.</li>
                        <li>Menjaga konsistensi kualitas dengan SOP kerja.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3"><i class="fa-solid fa-shirt me-2 text-warning"></i>Layanan</h5>
                    <div class="row g-3">
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="border rounded-4 p-3 h-100">
                                <div class="fw-bold">Cuci Kiloan</div>
                                <div class="text-muted small">Hemat untuk kebutuhan harian.</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="border rounded-4 p-3 h-100">
                                <div class="fw-bold">Cuci Satuan</div>
                                <div class="text-muted small">Untuk item khusus (jaket, dll).</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="border rounded-4 p-3 h-100">
                                <div class="fw-bold">Setrika & Lipat</div>
                                <div class="text-muted small">Rapi, siap pakai.</div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-light border mt-4 mb-0">
                        <div class="fw-bold mb-1">Catatan</div>
                        <div class="text-muted">
                            Tidak tersedia layanan antar-jemput; pengambilan pakaian dilakukan sendiri oleh pemilik.
                            Detail paket & tarif bisa dilihat di Home (bagian “Paket Layanan”) atau tanyakan langsung ke toko.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3"><i class="fa-solid fa-star me-2 text-warning"></i>Kenapa AKA Laundry?</h5>
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div class="d-flex gap-3">
                                <div class="pt-1"><i class="fa-solid fa-circle-check"></i></div>
                                <div>
                                    <div class="fw-bold">Kualitas Konsisten</div>
                                    <div class="text-muted small">Proses kerja mengikuti standar agar hasil stabil.</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="d-flex gap-3">
                                <div class="pt-1"><i class="fa-solid fa-circle-check"></i></div>
                                <div>
                                    <div class="fw-bold">Tepat Waktu</div>
                                    <div class="text-muted small">Estimasi jelas, progres mudah dipantau lewat resi.</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="d-flex gap-3">
                                <div class="pt-1"><i class="fa-solid fa-circle-check"></i></div>
                                <div>
                                    <div class="fw-bold">Layanan Ramah</div>
                                    <div class="text-muted small">Komunikasi cepat dan transparan.</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="d-flex gap-3">
                                <div class="pt-1"><i class="fa-solid fa-circle-check"></i></div>
                                <div>
                                    <div class="fw-bold">Rapi & Siap Pakai</div>
                                    <div class="text-muted small">Fokus pada kerapihan finishing.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <a href="<?= site_url('user/lokasi') ?>" class="btn btn-dark rounded-pill">
                            <i class="fa-solid fa-route me-2"></i>Petunjuk Arah
                        </a>
                        <a href="<?= site_url('user/index') ?>" class="btn btn-outline-dark rounded-pill">
                            <i class="fa-solid fa-tags me-2"></i>Lihat Paket
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
