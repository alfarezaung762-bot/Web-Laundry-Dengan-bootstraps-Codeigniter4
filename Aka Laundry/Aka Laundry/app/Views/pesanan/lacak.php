<?= $this->extend('templates/home'); ?>
<?= $this->section('content'); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-search me-2"></i>Lacak Pesanan</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/pesanancontroller/trackingresult') ?>" method="get" class="row g-3 align-items-center">
                        <div class="col-sm-9">
                            <input type="text" name="no_resi" class="form-control" placeholder="Masukkan No Resi" required>
                        </div>
                        <div class="col-sm-3 text-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search"></i> Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>