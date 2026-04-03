<?= $this->extend('templates/home') ?>
<?= $this->section('content') ?>

<style>
    .detail-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }
    .detail-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        padding: 20px;
    }
    .detail-header .resi-badge {
        background: rgba(255,255,255,0.2);
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.9rem;
        display: inline-block;
    }
    .info-section {
        background: #f8f9fc;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .info-section h6 {
        color: #4e73df;
        font-weight: 700;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e3e6f0;
    }
    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px dashed #e3e6f0;
    }
    .info-row:last-child {
        border-bottom: none;
    }
    .info-label {
        color: #858796;
        font-weight: 500;
    }
    .info-value {
        color: #5a5c69;
        font-weight: 600;
        text-align: right;
    }
    .total-price {
        background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%);
        color: white;
        padding: 15px 20px;
        border-radius: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .total-price .label {
        font-size: 1rem;
    }
    .total-price .amount {
        font-size: 1.5rem;
        font-weight: 700;
    }
    
    /* Progress Timeline */
    .progress-timeline {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin: 30px 0;
    }
    .progress-timeline::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 10%;
        right: 10%;
        height: 4px;
        background: #e3e6f0;
        z-index: 1;
    }
    .progress-step {
        text-align: center;
        position: relative;
        z-index: 2;
        flex: 1;
    }
    .progress-step .step-icon {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: #e3e6f0;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        font-size: 1.2rem;
        transition: all 0.3s ease;
    }
    .progress-step.completed .step-icon {
        background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%);
        color: white;
    }
    .progress-step.active .step-icon {
        background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
        color: white;
        transform: scale(1.1);
        box-shadow: 0 4px 15px rgba(246, 194, 62, 0.4);
    }
    .progress-step .step-label {
        font-size: 0.75rem;
        color: #858796;
        font-weight: 600;
    }
    .progress-step.completed .step-label,
    .progress-step.active .step-label {
        color: #5a5c69;
    }
    
    /* Staff Cards */
    .staff-card {
        display: flex;
        align-items: center;
        background: white;
        border: 1px solid #e3e6f0;
        border-radius: 10px;
        padding: 12px 15px;
        margin-bottom: 10px;
    }
    .staff-card .staff-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 1rem;
    }
    .staff-card .staff-icon.admin { background: #e7e3ff; color: #6f42c1; }
    .staff-card .staff-icon.washer { background: #d4edda; color: #28a745; }
    .staff-card .staff-icon.kurir { background: #fff3cd; color: #856404; }
    .staff-card .staff-info .role {
        font-size: 0.7rem;
        color: #858796;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .staff-card .staff-info .name {
        font-weight: 600;
        color: #5a5c69;
    }
    
    /* Photo Section */
    .photo-section {
        background: linear-gradient(135deg, #f8f9fc 0%, #eaecf4 100%);
        border-radius: 10px;
        padding: 20px;
        text-align: center;
    }
    .photo-section img {
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    .photo-section img:hover {
        transform: scale(1.02);
    }
    
    /* Status Alert */
    .status-alert {
        border-radius: 10px;
        padding: 15px 20px;
        display: flex;
        align-items: center;
    }
    .status-alert .status-icon {
        font-size: 1.5rem;
        margin-right: 15px;
    }
</style>

<div class="container-fluid">
    <?php if ($pesanan): ?>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                
                <!-- Main Card -->
                <div class="card detail-card shadow mb-4">
                    
                    <!-- Header -->
                    <div class="detail-header">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h4 class="mb-1 font-weight-bold">Detail Pesanan</h4>
                                <span class="resi-badge">
                                    <i class="fas fa-receipt mr-1"></i> <?= esc($pesanan['no_resi']) ?>
                                </span>
                            </div>
                            <div class="text-right mt-2 mt-md-0">
                                <?php
                                    $statusColors = [
                                        'Menunggu' => 'warning',
                                        'Pickup' => 'info',
                                        'Proses' => 'primary',
                                        'Selesai' => 'success'
                                    ];
                                    $badgeColor = $statusColors[$pesanan['status']] ?? 'secondary';
                                ?>
                                <span class="badge badge-<?= $badgeColor ?> px-3 py-2" style="font-size: 0.9rem;">
                                    <?= esc($pesanan['status']) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body p-4">
                        
                        <!-- Progress Timeline (tanpa status Cuci) -->
                        <div class="progress-timeline">
                            <?php
                            $statuses = ['Menunggu', 'Proses', 'Selesai'];
                            $icons = ['Menunggu' => '⏳', 'Proses' => '🧺', 'Selesai' => '✅'];
                            $current = $pesanan['status'];
                            $currentIndex = array_search($current, $statuses);
                            if ($currentIndex === false) $currentIndex = -1;
                            
                            foreach ($statuses as $index => $step):
                                $stepClass = '';
                                if ($index < $currentIndex) $stepClass = 'completed';
                                elseif ($index == $currentIndex) $stepClass = 'active';
                            ?>
                                <div class="progress-step <?= $stepClass ?>">
                                    <div class="step-icon"><?= $icons[$step] ?></div>
                                    <div class="step-label"><?= $step ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Keterangan Proses (jika status Proses) -->
                        <?php if ($pesanan['status'] === 'Proses' && !empty($pesanan['keterangan_cuci'])): ?>
                            <div class="alert alert-info text-center mb-4">
                                <strong>Tahap saat ini:</strong> <?= esc($pesanan['keterangan_cuci']) ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <!-- Customer Info -->
                                <div class="info-section">
                                    <h6><i class="fas fa-user mr-2"></i>Informasi Pelanggan</h6>
                                    <div class="info-row">
                                        <span class="info-label">Nama</span>
                                        <span class="info-value"><?= esc($pesanan['nama_pelanggan']) ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">No. HP</span>
                                        <span class="info-value"><?= esc($pesanan['no_pelanggan']) ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Alamat</span>
                                        <span class="info-value"><?= esc($pesanan['alamat_pelanggan']) ?></span>
                                    </div>
                                </div>
                                
                                <!-- Date Info -->
                                <div class="info-section">
                                    <h6><i class="fas fa-calendar-alt mr-2"></i>Informasi Waktu</h6>
                                    <div class="info-row">
                                        <span class="info-label">Tanggal Masuk</span>
                                        <span class="info-value"><?= date('d M Y, H:i', strtotime($pesanan['tanggal_masuk'])) ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Tanggal Selesai</span>
                                        <span class="info-value">
                                            <?= $pesanan['tanggal_selesai'] ? date('d M Y, H:i', strtotime($pesanan['tanggal_selesai'])) : '<span class="text-muted">-</span>' ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right Column -->
                            <div class="col-md-6">
                                <!-- Laundry Info -->
                                <div class="info-section">
                                    <h6><i class="fas fa-tshirt mr-2"></i>Detail Laundry</h6>
                                    <div class="info-row">
                                        <span class="info-label">Jenis</span>
                                        <span class="info-value"><?= esc($pesanan['jenis_laundry']) ?></span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Berat</span>
                                        <span class="info-value"><?= esc($pesanan['berat_kg']) ?> Kg</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Tarif</span>
                                        <span class="info-value">Rp <?= number_format($pesanan['tarif']) ?>/Kg</span>
                                    </div>
                                </div>
                                
                                <!-- Total Price -->
                                <div class="total-price">
                                    <span class="label"><i class="fas fa-money-bill-wave mr-2"></i>Total Bayar</span>
                                    <span class="amount">Rp <?= number_format($pesanan['tarif'] * $pesanan['berat_kg']) ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Status Selesai Alert -->
                        <?php if ($pesanan['status'] === 'Selesai'): ?>
                            <div class="status-alert alert alert-<?= $pesanan['status_selesai'] === 'Sudah Diambil' ? 'success' : 'info' ?> mt-3">
                                <span class="status-icon">
                                    <?php
                                    if ($pesanan['status_selesai'] === 'Sudah Diambil') echo '✅';
                                    elseif ($pesanan['status_selesai'] === 'Dalam Pengantaran') echo '🚚';
                                    elseif ($pesanan['status_selesai'] === 'Sedang Diantar') echo '📦';
                                    else echo '⏳';
                                    ?>
                                </span>
                                <div>
                                    <strong>Status Pengambilan</strong><br>
                                    <span>
                                        <?php
                                        if ($pesanan['status_selesai'] === 'Sudah Diambil') {
                                            echo "Sudah diambil pelanggan";
                                        } elseif ($pesanan['status_selesai'] === 'Dalam Pengantaran') {
                                            echo "Dalam pengantaran ke pelanggan";
                                        } elseif ($pesanan['status_selesai'] === 'Sedang Diantar') {
                                            echo "Siap diantar kurir";
                                        } else {
                                            echo "Belum diambil/antar";
                                        }
                                        ?>
                                    </span>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Staff Info -->
                        <?php if (!empty($pesanan['nama_admin']) || !empty($pesanan['nama_washer']) || !empty($pesanan['nama_kurir'])): ?>
                            <div class="info-section mt-3">
                                <h6><i class="fas fa-users mr-2"></i>Petugas</h6>
                                <div class="row">
                                    <?php if (!empty($pesanan['nama_admin'])): ?>
                                        <div class="col-md-4">
                                            <div class="staff-card">
                                                <div class="staff-icon admin"><i class="fas fa-user-tie"></i></div>
                                                <div class="staff-info">
                                                    <div class="role">Admin</div>
                                                    <div class="name"><?= esc($pesanan['nama_admin']) ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($pesanan['nama_washer'])): ?>
                                        <div class="col-md-4">
                                            <div class="staff-card">
                                                <div class="staff-icon washer"><i class="fas fa-soap"></i></div>
                                                <div class="staff-info">
                                                    <div class="role">Washer</div>
                                                    <div class="name"><?= esc($pesanan['nama_washer']) ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($pesanan['nama_kurir'])): ?>
                                        <div class="col-md-4">
                                            <div class="staff-card">
                                                <div class="staff-icon kurir"><i class="fas fa-motorcycle"></i></div>
                                                <div class="staff-info">
                                                    <div class="role">Kurir</div>
                                                    <div class="name"><?= esc($pesanan['nama_kurir']) ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Photo Section -->
                        <?php if (!empty($pesanan['foto_transaksi'])): ?>
                            <div class="photo-section mt-3">
                                <h6 class="text-gray-700 mb-3"><i class="fas fa-camera mr-2"></i>Foto Transaksi</h6>
                                <img id="fotoZoom" 
                                     src="<?= base_url('uploads/foto_transaksi/' . $pesanan['foto_transaksi']) ?>" 
                                     class="img-fluid" 
                                     style="max-height: 250px; cursor: pointer;" 
                                     alt="Foto Transaksi">
                                <p class="text-muted mt-2 small mb-0"><i class="fas fa-search-plus mr-1"></i>Klik untuk memperbesar</p>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Back Button -->
                        <div class="mt-4 pt-3 border-top">
                            <a href="<?= base_url('/pesanancontroller/index') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
                            </a>
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
    <?php else: ?>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="alert alert-danger text-center">
                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                    <h5>Data Tidak Ditemukan</h5>
                    <p class="mb-3">Pesanan yang Anda cari tidak tersedia.</p>
                    <a href="<?= base_url('/pesanancontroller/index') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Modal Zoom Foto -->
<div class="modal fade" id="zoomModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0" style="background: transparent;">
            <div class="modal-body p-0 text-center">
                <img id="modalImg" src="#" class="img-fluid rounded shadow-lg" style="max-height: 80vh;" />
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("fotoZoom")?.addEventListener("click", function() {
        document.getElementById("modalImg").src = this.src;
        $('#zoomModal').modal('show');
    });
</script>

<?= $this->endSection() ?>