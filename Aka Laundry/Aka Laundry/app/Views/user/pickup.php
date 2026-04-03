<?= $this->extend('user/templates') ?>
<?= $this->section('content') ?>

<section class="py-5" style="position: relative; z-index: 10;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="font-size: 2.8rem; color: #333; text-shadow: 1px 1px 0 #fdd835;">
                Metode Layanan
            </h2>
            <p class="text-muted fs-5">Pilih metode layanan laundry sesuai kenyamanan Anda</p>
        </div>

        <div class="row justify-content-center gy-5 gx-5">
            <!-- Kartu: Datang ke Cabang -->
            <div class="col-md-5 col-lg-4 d-flex">
                <div class="card layanan-card border-0 rounded-4 shadow-lg w-100 p-4 d-flex flex-column justify-content-between text-center bg-white">
                    <div class="card-body d-flex flex-column align-items-center">
                        <div class="img-wrapper mb-4">
                            <img src="/toko.png" alt="Datang ke Cabang" class="img-fluid">
                        </div>
                        <div class="mt-auto w-100">
                            <a href="<?= base_url(); ?>/user/lokasi" class="btn btn-gradient rounded-pill px-4 py-3 fs-5 w-100">
                                Datang ke Cabang
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu: Pick Up Pakaian -->
            <div class="col-md-5 col-lg-4 d-flex">
                <div class="card layanan-card border-0 rounded-4 shadow-lg w-100 p-4 d-flex flex-column justify-content-between text-center bg-white">
                    <div class="card-body d-flex flex-column align-items-center">
                        <div class="img-wrapper mb-4">
                            <img src="/truck.png" alt="Pick Up Pakaian" class="img-fluid">
                        </div>
                        <div class="mt-auto w-100">
                            <small class="text-dark fw-medium d-block mb-2">* Maksimal jarak 15 km ( Member Only )</small>
                            <a href="<?= base_url(); ?>/pickup/request" class="btn btn-gradient rounded-pill px-4 py-3 fs-5 w-100">
                                Pick Up Pakaian
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Card dasar */
    .layanan-card {
        background: linear-gradient(145deg, #fffde7, #fff8e1);
        border: 1px solid #f5f5f5;
        min-height: 520px;
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    /* Hover card */
    .layanan-card:hover {
        transform: translateY(-12px) scale(1.03);
        box-shadow: 0 20px 48px rgba(0, 0, 0, 0.15);
        z-index: 10;
    }

    /* Wrapper gambar agar ukuran dan animasi konsisten */
    .img-wrapper {
        width: 100%;
        max-width: 320px;
        height: 230px;
        margin: 0 auto;
        overflow: hidden;
        border-radius: 20px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.4s ease;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Zoom dan shadow gambar saat hover */
    .layanan-card:hover .img-wrapper {
        box-shadow: 0 12px 36px rgba(0, 0, 0, 0.2);
    }

    .layanan-card:hover img {
        transform: scale(1.1);
        filter: brightness(1.05);
    }

    .img-wrapper img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.4s ease, filter 0.4s ease;
        display: block;
    }

    /* Tombol dengan gradient & shadow */
    .btn-gradient {
        background: linear-gradient(90deg, #64b5f6, #1976d2);
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
        border: none;
        box-shadow: 0 6px 12px rgba(25, 118, 210, 0.3);
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-gradient:hover {
        background: linear-gradient(90deg, #42a5f5, #1565c0);
        box-shadow: 0 10px 24px rgba(21, 101, 192, 0.5);
        color: #fff;
    }

    /* Teks kecil di bawah tombol */
    small.text-dark {
        font-weight: 600;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .layanan-card {
            min-height: auto;
        }

        .img-wrapper {
            max-width: 100%;
            height: 180px;
            border-radius: 15px;
        }

        .btn-gradient {
            font-size: 1rem;
            padding: 12px 24px;
        }
    }
</style>

<?= $this->endSection() ?>