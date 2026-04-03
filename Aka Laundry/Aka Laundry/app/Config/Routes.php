<?php

use App\Controllers\Jenis;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//j
// $routes->setAutoRoute(true);
$routes->get('/login/templates', 'Login::templates');

// Pelanggan
$routes->get('/pelanggan/index', 'Pelanggan::index');
$routes->get('/pelanggan/tambah', 'Pelanggan::tambah');
$routes->post('/pelanggan/simpan', 'Pelanggan::simpan');
$routes->get('/pelanggan/edit/(:num)', 'Pelanggan::edit/$1');
$routes->post('/pelanggan/edit/(:num)', 'Pelanggan::edit/$1');
$routes->post('/pelanggan/update', 'Pelanggan::update');
$routes->get('/pelanggan/delete/(:num)', 'Pelanggan::delete/$1');

// ===== Layanan (Jenis Laundry) =====
// UI: app/Views/auth/layanan/jenis.php, tambah_layanan.php, edit_layanan.php
$routes->get('/jenis/index', 'Jenis::index');
$routes->get('jenis/tambah', 'Jenis::tambah');
$routes->post('jenis/simpan', 'Jenis::simpan');
$routes->get('jenis/edit/(:num)', 'Jenis::edit/$1');
$routes->post('jenis/update', 'Jenis::update');
$routes->get('jenis/delete/(:num)', 'Jenis::delete/$1');

// Login / Auth
$routes->get('/login/index', 'Login::index');
$routes->post('/login/action', 'Login::action');
$routes->get('/login/logout', 'Login::logout');

// ✅ Edit profil user yang sedang login (admin/superadmin)
$routes->get('/login/editProfile', 'Login::editProfile', ['filter' => 'adminfilter']);
$routes->post('/login/updateProfile', 'Login::updateProfile', ['filter' => 'adminfilter']);

// Role-based
$routes->get('/login/dashboard', 'Login::dashboard', ['filter' => 'adminfilter']);
$routes->get('/login/washer', 'Login::washer', ['filter' => 'washerfilter']);
$routes->get('/login/kurir', 'Login::kurir', ['filter' => 'kurirfilter']);
$routes->get('/login/tolak', 'Login::tolak', ['filter' => 'washerfilter']);
$routes->get('/login/tolak2', 'Login::tolak2', ['filter' => 'kurirfilter']);

// ===== Pesanan =====
// UI: app/Views/pesanan/index.php
$routes->get('/pesanancontroller/index', 'PesananController::index');

// coba pesanan
$routes->get('/pesanan/create', 'PesananController::create');
$routes->post('/pesanan/store', 'PesananController::store');
$routes->get('/pesanan/track/(:any)', 'PesananController::track/$1');

$routes->get('/pesanancontroller/tracking', 'PesananController::trackingForm'); // halaman form lacak
$routes->get('/pesanancontroller/trackingresult', 'PesananController::trackingResult'); // hasil lacak


//tracking edit
$routes->get('/pesanan/edit-status/(:num)', 'PesananController::editStatus/$1');
$routes->post('/pesanan/update-status/(:num)', 'PesananController::updateStatus/$1');

//detail
$routes->get('/pesanan/detail/(:num)', 'PesananController::detail/$1');

//washer
$routes->get('/pesanancontroller/washer', 'PesananController::washerView');
$routes->post('/pesanancontroller/washer/mark-done/(:num)', 'PesananController::markWasherDone/$1');

$routes->get('/pesanancontroller/washer', 'PesananController::washerView');
$routes->post('/pesanancontroller/washer/cuci/(:num)', 'PesananController::washerCuci/$1');
$routes->post('/pesanancontroller/washer/selesai/(:num)', 'PesananController::washerSelesai/$1');
$routes->get('/washer', 'PesananController::washerView');

$routes->post('/pesanancontroller/store', 'PesananController::store');

$routes->get('/kurir', 'PesananController::kurirView');
$routes->get('/pesanancontroller/kurirview', 'PesananController::kurirView');
$routes->post('/kurir/ambil/(:num)', 'PesananController::markAsTaken/$1');
$routes->post('/kurir/antar/(:num)', 'PesananController::kurirAntar/$1');


//pickup
$routes->get('/pickup/form', 'PickupController::form');
$routes->post('/pickup/submit', 'PickupController::submit');
$routes->get('/kurir/pickup', 'PickupController::kurirView');
$routes->post('/kurir/pickup/update/(:num)', 'PickupController::updateStatus/$1');
$routes->post('/pickup/check', 'PickupController::check'); // cek status pickup

$routes->get('/kurir/riwayat-pickup', 'PickupController::riwayatPickup');

// Halaman pickup dari pesanan buatan admin


// Tombol aksi kurir untuk pickup buatan admin
$routes->post('/kurir/pickup-admin/aksi/(:num)', 'PesananController::pickupAdminSelesai/$1');

$routes->get('/kurir/pickup-user', 'PickMe::kurirPickupView'); // ✅

$routes->get('/kurir/pickup-admin', 'PickupController::pickupAdmin');


// Kurir - Pickup dari Admin
$routes->get('/kurir/pickup-admin', 'PesananController::pickupAdminView');
$routes->post('/kurir/pickup-admin/mulai/(:num)', 'PesananController::pickupAdminMulai/$1');




$routes->get('/kurir/pickup-admin/edit-kg/(:num)', 'PesananController::editBeratAdmin/$1');



$routes->get('/kurir/pickup-admin', 'PesananController::pickupByAdmin');
$routes->post('/kurir/pickup-admin/selesai/(:num)', 'PesananController::pickupAdminSelesai/$1');

//struk
$routes->get('/pesanan/struk/(:num)', 'PesananController::cetakStruk/$1');

//riwayat transaksi (izinkan admin + superadmin)
$routes->get('/pesanan/riwayat', 'PesananController::riwayatTransaksi', ['filter' => 'adminfilter']);

//riwayat struke (ikut dibuka untuk admin + superadmin)
$routes->get('/pesanan/riwayat_struk/(:num)', 'PesananController::riwayatStruk/$1', ['filter' => 'adminfilter']);
$routes->get('/kurir/pickup-admin/edit-kg/(:num)', 'PesananController::editBeratAdmin/$1');
// Member Card
$routes->get('/pelanggan/kartu/(:num)', 'Pelanggan::cetakKartu/$1');


//user
$routes->get('/user/index', 'User::index');
$routes->get('/user/paket', 'User::paket');
$routes->get('/user/pickup', 'User::pickup');
$routes->get('/user/lokasi', 'User::lokasi');
$routes->get('/user/tentang', 'User::tentang');


//pickup
// Pickup oleh pelanggan
$routes->get('/pickup/request', 'PickMe::requestForm');
$routes->post('/pickup/request', 'PickMe::submitRequest');

// Kurir ambil pickup
$routes->get('/kurir/pickup-user', 'PickMe::kurirPickupView');
$routes->post('/kurir/pickup-user/mulai/(:num)', 'PickMe::kurirAmbil/$1');

// Kurir input berat cucian
$routes->get('/kurir/pickup-user/edit-kg/(:num)', 'PickMe::editBerat/$1');
$routes->post('/kurir/pickup-user/selesai/(:num)', 'PickMe::selesaiPickup/$1');


//paket pelayanan
$routes->get('/pelayanan', 'Pelayanan::index');
$routes->get('/pelayanan/edit/(:num)', 'Pelayanan::edit/$1');
$routes->post('/pelayanan/update/(:num)', 'Pelayanan::update/$1');

$routes->get('/user/kelola_paket', 'Pelayanan::kelola');
$routes->post('/kurir/pickup-user/tolak/(:num)', 'PickupController::tolakPickup/$1');

//admin akses 
$routes->get('/useradmin', 'UserAdmin::index', ['filter' => 'adminfilter']);
$routes->get('/useradmin/create', 'UserAdmin::create', ['filter' => 'adminfilter']);
$routes->post('/useradmin/store', 'UserAdmin::store', ['filter' => 'adminfilter']);
$routes->get('/useradmin/edit/(:num)', 'UserAdmin::edit/$1', ['filter' => 'adminfilter']);
$routes->post('/useradmin/update/(:num)', 'UserAdmin::update/$1', ['filter' => 'adminfilter']);
$routes->get('/useradmin/delete/(:num)', 'UserAdmin::delete/$1', ['filter' => 'adminfilter']);


$routes->post('/pesanancontroller/washer/jemur/(:num)', 'PesananController::washerJemur/$1');
$routes->post('/pesanancontroller/washer/setrika/(:num)', 'PesananController::washerSetrika/$1');

//cetak struk after pickup
$routes->get('/pesanancontroller/cetakstruk/(:num)', 'PesananController::cetakStruk/$1');
$routes->get('/pesanancontroller/struk-berhasil/(:num)', 'PesananController::strukBerhasil/$1');

// Pastikan route washer pakai filter (lebih aman daripada mengandalkan Auto Routing)
$routes->get('pesanancontroller/washer', 'PesananController::washer', ['filter' => 'washerauth']);

// NOTE: Jika kolom-kolom kurir (mis. id_kurir) sudah dihapus dari tb_pesanan,
// maka fitur/rute terkait kurir & pickup sebaiknya ikut dibersihkan/di-nonaktifkan
// agar tidak ada endpoint yang memanggil logic lama.

// Alias route lama (mencegah 404 setelah simpan/redirect)
$routes->get('/auth/tambah_member/data_pelanggan', 'Pelanggan::index');

// Review routes
$routes->post('review/submit', 'Review::submit');
$routes->get('review/get', 'Review::getReviews');
