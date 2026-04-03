<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        body,
        #wrapper,
        #content-wrapper {
            padding: 0 !important;
            margin: 0 !important;
        }

        .scroll-to-top {
            bottom: 10px !important;
            right: 10px !important;
        }

        .modal-content {
            padding: 0 !important;
        }

        .modal-dialog {
            margin: 0 auto !important;
        }

        /* ===== Animasi Futuristik ===== */
        .fade-in {
            animation: fadeInUp 1s ease-out both;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .glow-hover:hover {
            box-shadow: 0 0 15px rgba(0, 191, 255, 0.6);
            transition: 0.3s ease;
            transform: scale(1.03);
        }

        .sidebar .nav-item .nav-link:hover {
            background: rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }

        .sidebar .nav-item.active .nav-link,
        .sidebar .nav-item .nav-link:focus {
            background-color: #1cc88a;
            color: #fff;
            border-left: 4px solid #20c997;
        }

        .btn-glow {
            transition: 0.4s ease;
        }

        .btn-glow:hover {
            box-shadow: 0 0 10px #36b9cc, 0 0 20px #36b9cc, 0 0 30px #36b9cc;
        }

        .animated-delay-1 {
            animation-delay: 0.2s;
        }

        .animated-delay-2 {
            animation-delay: 0.4s;
        }

        .animated-delay-3 {
            animation-delay: 0.6s;
        }

        /* FIX: SB Admin 2 biasanya set tinggi sidebar-brand fixed, jadi margin img tidak berpengaruh */
        .sidebar .sidebar-brand {
            height: auto !important;
            padding-top: 14px !important;
            padding-bottom: 14px !important;
        }

        .sidebar .sidebar-brand .sidebar-brand-icon {
            padding-top: 6px;
            padding-bottom: 6px;
        }

        /* Jarak atas-bawah untuk logo sidebar (tetap boleh, tapi sekarang parent-nya sudah auto height) */
        .sidebar-logo {
            width: 200px !important;
            height: 200px !important;
            object-fit: contain;
            transition: width .2s ease, height .2s ease, transform .2s ease;
            margin: 0 auto;
            /* center horizontal saja */
            display: block;
        }

        /* saat sidebar ditutup (SB Admin 2 menambahkan class "toggled" ke .sidebar) */
        .sidebar.toggled .sidebar-logo {
            width: 60px !important;
            height: 60px !important;
            transform: scale(1);
        }

        /* opsional: rapatkan area brand saat sidebar ditutup */
        .sidebar.toggled .sidebar-brand {
            padding-top: 8px !important;
            padding-bottom: 8px !important;
        }
    </style>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Blank</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url(); ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url(); ?>/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion -in animatedfade-delay-1" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center glow-hover py-3" href="#">
                <div class="sidebar-brand-icon">
                    <img class="sidebar-logo"
                     src="<?= base_url('img/356bf6d1-70af-4c10-97c7-8b3a8d3890d0.png') ?>"
                     alt="Logo AKA Laundry" />
                </div>
            </a>

            <hr class="sidebar-divider my-0">

            <?php if (session()->get('level') === 'superadmin'): ?>
                <li class="nav-item">
                    <a class="nav-link glow-hover" href="<?= base_url('/useradmin') ?>">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>ADMIN</span></a>
                </li>
                <!-- Layanan collapse -->
                <li class="nav-item">
                    <a class="nav-link collapsed glow-hover" href="#" data-toggle="collapse" data-target="#collapseLayanan">
                        <i class="fas fa-fw fa-wrench"></i>
                        <span>LAYANAN</span>
                    </a>
                    <div id="collapseLayanan" class="collapse">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">MENU</h6>
                            <a class="collapse-item" href="/pelanggan/index">Data Member</a>
                            <a class="collapse-item" href="/jenis/index">Data Paket</a>
                            <a class="collapse-item" href="/pesanancontroller/index">Daftar Pesanan</a>

                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link glow-hover" href="/pesanancontroller/washer">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>WASHER</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link glow-hover" href="/pesanan/riwayat">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>RIWAYAT TRANSAKSI</span></a>
                </li>


            <?php elseif (session()->get('level') === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link glow-hover" href="<?= base_url('/useradmin') ?>">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>ADMIN</span></a>
                </li>
                <!-- Layanan collapse -->
                <li class="nav-item">
                    <a class="nav-link collapsed glow-hover" href="#" data-toggle="collapse" data-target="#collapseLayanan">
                        <i class="fas fa-fw fa-wrench"></i>
                        <span>LAYANAN</span>
                    </a>
                    <div id="collapseLayanan" class="collapse">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">MENU</h6>
                            <a class="collapse-item" href="/pelanggan/index">Data Member</a>
                            <a class="collapse-item" href="/jenis/index">Data Paket</a>
                            <a class="collapse-item" href="/pesanancontroller/index">Daftar Pesanan</a>

                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link glow-hover" href="/pesanancontroller/washer">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>WASHER</span></a>
                </li>

                <!-- tambah ini: admin juga bisa akses riwayat -->
                <li class="nav-item">
                    <a class="nav-link glow-hover" href="/pesanan/riwayat">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>RIWAYAT TRANSAKSI</span></a>
                </li>
            <?php elseif (session()->get('level') === 'washer'): ?>
                <li class="nav-item">
                    <a class="nav-link glow-hover" href="<?= base_url('/login/washer') ?>">
                        <i class="fas fa-fw fa-user"></i>
                        <span>PROFIL</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link glow-hover" href="/pesanancontroller/washer">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>WASHER</span></a>
                </li>
            <?php endif; ?>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link glow-hover" href="<?= base_url(); ?>/login/logout">
                    <i class="fas fa-fw fa-table"></i>
                    <span>LOGOUT</span></a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0 btn-glow" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column fade-in animated-delay-2">
            <div id="content">
                <!-- Topbar -->
                <?php
                // Tentukan halaman profil berdasarkan level user
                $level = (string) session()->get('level');
                $profileUrl = base_url('/login/templates'); // fallback lama
                $profileLabel = 'Profile';

                if ($level === 'washer') {
                    $profileUrl = base_url('/login/washer');
                    $profileLabel = 'Profile';
                } elseif ($level === 'admin' || $level === 'superadmin') {
                    // diarahkan ke dashboard admin
                    $profileUrl = base_url('/login/dashboard');
                    $profileLabel = 'Dashboard';
                } elseif ($level === 'kurir') {
                    $profileUrl = base_url('/login/kurir');
                    $profileLabel = 'Profile';
                }
                ?>
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <form action="<?= base_url('/pesanancontroller/trackingresult') ?>" method="get"
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" name="no_resi"
                                class="form-control bg-light border-0 small"
                                placeholder="Masukkan No Resi..." required>
                            <div class="input-group-append">
                                <button class="btn btn-primary btn-glow" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= session()->get('name') ?></span>
                                <img class="img-profile rounded-circle"
                                    src="<?= base_url(); ?>/programmer_2085231.png">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= $profileUrl ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    <?= esc($profileLabel) ?>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <?= $this->renderSection('content'); ?>
            </div>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content fade-in">
                <div class="modal-header">
                    <h5 class="modal-title">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-glow" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary btn-glow" href="<?= base_url(); ?>/login/logout">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="<?= base_url(); ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url(); ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url(); ?>/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?= base_url(); ?>/js/sb-admin-2.min.js"></script>

</body>

</html>