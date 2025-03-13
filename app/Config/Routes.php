<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

//Route Landing
$routes->get('/', 'LandingController::index');
// Route Role Admin
// $routes->get('/admin', 'Admin\AdminController::index', ['filter' => 'login']);
// $routes->get('/admin', 'Admin\AdminController::index', ['filter' => 'role:admin']);
// $routes->get('/admin/index', 'Admin\AdminController::index', ['filter' => 'role:admin']);
$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'login']);
// $routes->get('/', 'Home:index', ['filter' => 'login']);
$routes->get('sistem_informasi', 'LandingController::sistem_informasi');
$routes->get('lowongan_kerja', 'LandingController::kerja');
$routes->get('lowongan_kerja_detail/(:any)', 'LandingController::kerja_detail/$1');
$routes->get('informasi_magang', 'LandingController::magang');
$routes->get('informasi_magang_detail/(:any)', 'LandingController::magang_detail/$1');
$routes->get('tips_karir', 'LandingController::tips_karir');
$routes->get('tips_karir_detail/(:any)', 'LandingController::tips_karir_detail/$1');
$routes->get('agenda', 'LandingController::agenda');
$routes->get('sipema_info', 'LandingController::sipema_info');
$routes->get('tracer_info', 'LandingController::tracer_info');
$routes->get('register', 'AuthController::register');
$routes->post('/register/buat', 'AuthController::store');

// // Pengelolaan Data Mahasiswa
// // Tampil Data
// $routes->get('mahasiswa', 'MahasiswaController::index');
// $routes->get('/landing', 'LandingController::index');
// // Tambah Data
// $routes->get('mahasiswa/tambah', 'MahasiswaController::tambah');
// $routes->post('mahasiswa/simpan', 'MahasiswaController::simpan');
// // Edit Data
// $routes->get('mahasiswa/edit/(:segment)', 'BidangController::edit/$1');
// $routes->put('mahasiswa/update/(:segment)', 'BidangController::update/$1');
// // Hapus Data
// $routes->delete('bidang/hapus/(:segment)', 'BidangController::hapus/$1');

// });
/*
 * --------------------------------------------------------------------
 *                               CRUD MASTER
 * --------------------------------------------------------------------
 */

$routes->get('admin/dashboard', 'DashboardController::admin', ['filter' => 'role:admin']);
// Ubah Profil
$routes->get('profil', 'DashboardController::profil', ['filter' => 'login']);
$routes->post('profil/update-profil/(:any)', 'DashboardController::update_profil/$1', ['filter' => 'login']);

$routes->get('mitra/dashboard', 'DashboardController::mitra', ['filter' => 'login']);

// Data Mahasiswa
// $routes->group('mahasiswa',['filter' => 'permission:data-mahasiswa'], static function ($routes) {
//     // Tampil Data
//     $routes->get('', 'Master\MahasiswaController::index', ['filter' => 'permission:data-mahasiswa']);
//     $routes->get('getDataMataKuliah/(:any)(:any)(/(:any))?', 'Master\MahasiswaController::getDataMataKuliah/$1/$2/$3');
//     // Tambah Data
//     $routes->get('tambah', 'Master\MahasiswaController::tambah', ['filter' => 'permission:data-mahasiswa']);
//     $routes->post('simpan', 'Master\MahasiswaController::simpan', ['filter' => 'permission:data-mahasiswa']);
//     // Edit Data
//     $routes->get('edit/(:any)', 'Master\MahasiswaController::edit/$1', ['filter' => 'permission:data-mahasiswa']);
//     $routes->post('update/(:any)', 'Master\MahasiswaController::update/$1', ['filter' => 'permission:data-mahasiswa']);
//     // Hapus Data
//     $routes->delete('hapus/(:any)', 'Master\MahasiswaController::hapus/$1', ['filter' => 'permission:admin']);
// });

// Data Mahasiswa
$routes->group('mahasiswa', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Master\MahasiswaController::index', ['filter' => 'role:admin,pimpinan']);
    $routes->get('getDataMataKuliah/(:any)(:any)(/(:any))?', 'Master\MahasiswaController::getDataMataKuliah/$1/$2/$3', ['filter' => 'role:admin,dosen,pimpinan,mahasiswa']);
    // Tambah Data
    $routes->get('tambah', 'Master\MahasiswaController::tambah', ['filter' => 'role:admin']);
    $routes->get('user/tambah', 'Master\MahasiswaController::tambah', ['filter' => 'role:admin']);
    $routes->post('simpan', 'Master\MahasiswaController::simpan', ['filter' => 'role:admin']);
    $routes->post('user/simpan', 'Master\MahasiswaController::simpan', ['filter' => 'role:admin']);
    // Edit Data
    $routes->get('edit/(:any)', 'Master\MahasiswaController::edit/$1', ['filter' => 'role:admin']);
    $routes->get('user/edit/(:any)', 'Master\MahasiswaController::edit/$1', ['filter' => 'role:admin']);
    $routes->post('update/(:any)', 'Master\MahasiswaController::update/$1', ['filter' => 'role:admin']);
    $routes->post('user/update/(:any)', 'Master\MahasiswaController::update/$1', ['filter' => 'role:admin']);
    // Hapus Data
    $routes->delete('hapus/(:any)', 'Master\MahasiswaController::hapus/$1', ['filter' => 'role:admin']);
    // Ubah Password
    $routes->get('ubah-password/(:any)', 'Master\MahasiswaController::ubah_password/$1');
    $routes->post('update-password/(:any)', 'Master\MahasiswaController::update_password/$1');
});

// Data Mitra
$routes->group('mitra', ['filter' => ['login', 'role:admin']], static function ($routes) {
    $routes->get('/', 'Master\MitraController::index');
    $routes->get('user/tambah', 'Master\MitraController::create');
    $routes->get('tambah', 'Master\MitraController::create');
    $routes->post('tambah/store', 'Master\MitraController::store');
    $routes->post('user/tambah/store', 'Master\MitraController::store');
    $routes->get('edit/(:any)', 'Master\MitraController::edit/$1');
    $routes->get('user/edit/(:any)', 'Master\MitraController::edit/$1');
    $routes->post('update/(:any)', 'Master\MitraController::update/$1');
    $routes->post('user/update/(:any)', 'Master\MitraController::update/$1');
    $routes->delete('hapus/(:any)', 'Master\MitraController::delete/$1');
    $routes->get('ubah-password/(:any)', 'Master\MitraController::ubah_password/$1');
    $routes->post('update-password/(:any)', 'Master\MitraController::update_password/$1');
});

// Data Mata Kuliah
$routes->group('mata-kuliah', ['filter' => 'login'], static function ($routes) {
    $routes->get('', 'Master\MataKuliahController::index', ['filter' => 'role:admin,pimpinan']);
    $routes->get('tambah', 'Master\MataKuliahController::tambah', ['filter' => 'role:admin']);
    $routes->post('import', 'Master\MataKuliahController::importExcel', ['filter' => 'role:admin']);
    $routes->post('simpan', 'Master\MataKuliahController::simpan', ['filter' => 'role:admin']);
    $routes->get('edit/(:any)', 'Master\MataKuliahController::edit/$1', ['filter' => 'role:admin']);
    $routes->post('update/(:any)', 'Master\MataKuliahController::update/$1', ['filter' => 'role:admin']);
    $routes->delete('hapus/(:any)', 'Master\MataKuliahController::hapus/$1', ['filter' => 'role:admin']);
});

// Data Staf
$routes->group('staf', ['filter' => 'login'], static function ($routes) {
    $routes->get('/', 'Master\StafController::index', ['filter' => 'role:admin,pimpinan']);
    $routes->get('tambah', 'Master\StafController::tambah', ['filter' => 'role:admin']);
    $routes->get('user/tambah', 'Master\StafController::tambah', ['filter' => 'role:admin']);
    $routes->post('tambah/store', 'Master\StafController::store', ['filter' => 'role:admin']);
    $routes->post('user/tambah/store', 'Master\StafController::store', ['filter' => 'role:admin']);
    $routes->get('edit/(:any)', 'Master\StafController::edit/$1', ['filter' => 'role:admin']);
    $routes->get('user/edit/(:any)', 'Master\StafController::edit/$1', ['filter' => 'role:admin']);
    $routes->post('update/(:any)', 'Master\StafController::update/$1', ['filter' => 'role:admin']);
    $routes->post('user/update/(:any)', 'Master\StafController::update/$1', ['filter' => 'role:admin']);
    $routes->delete('hapus/(:any)', 'Master\StafController::delete/$1', ['filter' => 'role:admin']);
    $routes->get('ubah-password/(:any)', 'Master\StafController::ubah_password/$1', ['filter' => 'role:admin']);
    $routes->post('update-password/(:any)', 'Master\StafController::update_password/$1', ['filter' => 'role:admin']);
});

// Data Group
$routes->group('group', ['filter' => 'login'], static function ($routes) {
    $routes->get('/', 'Master\GroupController::index', ['filter' => 'role:admin,pimpinan']);
    $routes->get('tambah', 'Master\GroupController::tambah', ['filter' => 'role:admin']);
    $routes->post('tambah/create', 'Master\GroupController::create', ['filter' => 'role:admin']);
    $routes->get('edit/(:any)', 'Master\GroupController::edit/$1', ['filter' => 'role:admin']);
    $routes->post('update/(:any)', 'Master\GroupController::update/$1', ['filter' => 'role:admin']);
    $routes->delete('hapus/(:any)', 'Master\GroupController::delete/$1', ['filter' => 'role:admin']);
    $routes->get('generatePDF', 'Master\GroupController::generatePDF', ['filter' => 'role:admin,pimpinan']);
});

// $routes->group('', ['filter' => 'login'], function($routes) {
//     $routes->resource('admin', ['filter' => 'permission:admin-module']);
//     $routes->resource('admin', ['filter' => 'permission:mahasiswa-module']);
//     $routes->resource('admin', ['filter' => 'permission:mitra-module']);
//     $routes->resource('mahasiswa', ['filter' => 'permission:mahasiswa-module']);
//     $routes->resource('mitra', ['filter' => 'permission:mitra-module']);
//     $routes->resource('dosen', ['filter' => 'permission:dosen-module']);
//     $routes->resource('pimpinan', ['filter' => 'permission:pimpinan-module']);
//     $routes->resource('laboran', ['filter' => 'permission:laboran-module']);
// });

// Data User
$routes->group('users', ['filter' => 'login'], static function ($routes) {
    $routes->get('/', 'Master\UserController::index', ['filter' => 'role:admin, pimpinan']);
    $routes->get('role', 'Master\UserController::role', ['filter' => 'role:admin']);
    $routes->get('ubah-password/(:any)', 'Master\UserController::ubah_password/$1', ['filter' => 'role:admin']);
    $routes->post('update-password/(:any)', 'Master\UserController::update_password/$1', ['filter' => 'role:admin']);
    $routes->delete('hapus/(:any)', 'Master\UserController::delete/$1', ['filter' => 'role:admin']);
});

/*
 * --------------------------------------------------------------------
 *                        SISTEM PEMETAAN KETERAMPILAN (SIPEMA)
 * --------------------------------------------------------------------
 */

// Dashboard SIPEMA
$routes->get('sipema', 'DashboardController::sipema', ['filter' => 'login']);

// Pengelolaan Data Bidang
$routes->group('sipema/bidang', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Sipema\BidangController::index', ['filter' => 'role:admin,dosen,pimpinan']);
    // Tambah Data
    $routes->get('tambah', 'Sipema\BidangController::tambah', ['filter' => 'role:admin,dosen']);
    $routes->post('simpan', 'Sipema\BidangController::simpan', ['filter' => 'role:admin,dosen']);
    // Edit Data
    $routes->get('edit/(:any)', 'Sipema\BidangController::edit/$1', ['filter' => 'role:admin,dosen']);
    $routes->post('update/(:any)', 'Sipema\BidangController::update/$1', ['filter' => 'role:admin,dosen']);
    // Hapus Data
    $routes->delete('hapus/(:any)', 'Sipema\BidangController::hapus/$1', ['filter' => 'role:admin,dosen']);
});

// Pengelolaan Data Sub Bidang
$routes->group('sipema/sub-bidang', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Sipema\SubBidangController::index', ['filter' => 'role:admin,dosen,pimpinan']);
    $routes->get('tambah', 'Sipema\SubBidangController::tambah', ['filter' => 'role:admin,dosen']);
    // Tambah Data
    $routes->post('simpan', 'Sipema\SubBidangController::simpan', ['filter' => 'role:admin,dosen']);
    // Detail Data
    $routes->get('detail/(:any)', 'Sipema\SubBidangController::detail/$1', ['filter' => 'role:admin,dosen']);
    // Edit Data
    $routes->get('edit/(:any)', 'Sipema\SubBidangController::edit/$1', ['filter' => 'role:admin,dosen']);
    $routes->post('update/(:any)', 'Sipema\SubBidangController::update/$1', ['filter' => 'role:admin,dosen']);
    // Hapus Data
    $routes->delete('hapus/(:any)', 'Sipema\SubBidangController::hapus/$1', ['filter' => 'role:admin,dosen']);
});

// Pengelolaan Data Nilai
$routes->group('sipema/nilai', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Sipema\NilaiController::index', ['filter' => 'role:admin,dosen,pimpinan']);
    $routes->get('tambah_mahasiswa', 'Sipema\NilaiController::tambah_mahasiswa', ['filter' => 'role:admin,dosen']);
    $routes->get('getDetailNilaiMataKuliahMahasiswa', 'Sipema\NilaiController::getDetailNilaiMataKuliahMahasiswa', ['filter' => 'role:admin,dosen,pimpinan,mahasiswa']);
    $routes->get('getMataKuliahByMahasiswa/(:any)', 'Sipema\NilaiController::getMataKuliahByMahasiswa/$1', ['filter' => 'role:admin,dosen,pimpinan,mahasiswa']);
    $routes->get('getFilterDataNilaiByIdMahasiswa/(:any)', 'Sipema\NilaiController::getFilterDataNilaiByIdMahasiswa/$1', ['filter' => 'role:admin,dosen,pimpinan,mahasiswa']);
    $routes->get('getFilterDataNilaiByIdMataKuliah/(:any)', 'Sipema\NilaiController::getFilterDataNilaiByIdMataKuliah/$1', ['filter' => 'role:admin,dosen,pimpinan,mahasiswa']);
    $routes->get('getFilterDataNilaiByNilaiUtsUasFilter/(:any)', 'Sipema\NilaiController::getFilterDataNilaiByNilaiUtsUasFilter/$1', ['filter' => 'role:admin,dosen,pimpinan,mahasiswa']);
    $routes->get('getFilterDataNilaiByIdMahasiswaAndIdMataKuliah/(:any)', 'Sipema\NilaiController::getFilterDataNilaiByIdMahasiswaAndIdMataKuliah/$1', ['filter' => 'role:admin,dosen,pimpinan,mahasiswa']);
    $routes->get('getFilterDataNilaiByIdMahasiswaAndNilaiUtsUasFilter/(:any)/(:num)', 'Sipema\NilaiController::getFilterDataNilaiByIdMahasiswaAndNilaiUtsUasFilter/$1/$2', ['filter' => 'role:admin,dosen,pimpinan,mahasiswa']);
    $routes->get('getFilterDataNilaiByIdMataKuliahAndNilaiUtsUasFilter/(:any)/(:num)', 'Sipema\NilaiController::getFilterDataNilaiByIdMataKuliahAndNilaiUtsUasFilter/$1/$2', ['filter' => 'role:admin,dosen,pimpinan,mahasiswa']);
    $routes->get('getFilterDataNilaiByIdMataKuliahAndNilaiUtsUasFilterAndNilaiUtsUasFilter/(:any)/(:any)/(:any)', 'Sipema\NilaiController::getFilterDataNilaiByIdMataKuliahAndNilaiUtsUasFilterAndNilaiUtsUasFilter/$1/$2/$3', ['filter' => 'role:admin,dosen,pimpinan,mahasiswa']);
    $routes->get('tambah_nilai_mata_kuliah/(:any)', 'Sipema\NilaiController::tambah_nilai_mata_kuliah/$1', ['filter' => 'role:admin,dosen']);
    $routes->post('import', 'Sipema\NilaiController::importExcel');
    $routes->post('simpan', 'Sipema\NilaiController::simpan', ['filter' => 'role:admin,dosen']);
    // Detail Data
    $routes->get('detail/(:any)', 'Sipema\NilaiController::detail/$1', ['filter' => 'role:admin,dosen,pimpinan']);
    // Edit Data
    $routes->get('edit_mahasiswa/(:any)', 'Sipema\NilaiController::edit_mahasiswa/$1', ['filter' => 'role:admin,dosen']);
    $routes->get('edit_nilai_mata_kuliah/(:any)/(:any)', 'Sipema\NilaiController::edit_nilai_mata_kuliah/$1/$2', ['filter' => 'role:admin,dosen']);
    $routes->post('update_mahasiswa/(:any)', 'Sipema\NilaiController::update_mahasiswa/$1', ['filter' => 'role:admin,dosen']);
    $routes->post('update_nilai_mata_kuliah/(:any)/(:any)', 'Sipema\NilaiController::update_nilai_mata_kuliah/$1/$2', ['filter' => 'role:admin,dosen']);
    // Hapus Data
    $routes->delete('hapus_mahasiswa/(:any)', 'Sipema\NilaiController::hapus_mahasiswa/$1', ['filter' => 'role:admin,dosen']);
    $routes->delete('hapus_nilai_mata_kuliah/(:any)', 'Sipema\NilaiController::hapus_nilai_mata_kuliah/$1', ['filter' => 'role:admin,dosen']);
});

// Pengelolaan Data Bobot
$routes->group('sipema/bobot', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Sipema\BobotController::index', ['filter' => 'role:admin,dosen,pimpinan']);
    $routes->get('tambah', 'Sipema\BobotController::tambah', ['filter' => 'role:admin,dosen']);
    $routes->post('simpan', 'Sipema\BobotController::simpan', ['filter' => 'role:admin,dosen']);
    // Edit Data
    $routes->get('edit/(:any)', 'Sipema\BobotController::edit/$1', ['filter' => 'role:admin,dosen']);
    $routes->post('update/(:any)', 'Sipema\BobotController::update/$1', ['filter' => 'role:admin,dosen']);
    // Hapus Data
    $routes->delete('hapus/(:any)', 'Sipema\BobotController::hapus/$1', ['filter' => 'role:admin,dosen']);
});

// Pengelolaan Data Pemetaan Mata Kuliah
$routes->group('sipema/pemetaan_mata_kuliah', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Sipema\PemetaanMataKuliahController::index', ['filter' => 'role:admin,dosen,pimpinan']);
    $routes->get('getDataFilterPemetaan/(:any)(/(:any))?(/(:any))?', 'Sipema\PemetaanMataKuliahController::getDataFilterPemetaan/$1/$2/$3', ['filter' => 'role:admin,dosen,pimpinan,mahasiswa']);
    $routes->get('getDataFilterPemetaanBidangJenisBobot/(:any)/(:any)', 'Sipema\PemetaanMataKuliahController::getDataFilterPemetaanBidangJenisBobot/$1/$2', ['filter' => 'role:admin,dosen,pimpinan,mahasiswa']);
    $routes->get('getDataFilterPemetaanJenisBobot/(:any)', 'Sipema\PemetaanMataKuliahController::getDataFilterPemetaanJenisBobot/$1', ['filter' => 'role:admin,dosen,pimpinan,mahasiswa']);
    $routes->get('getDetailPemetaanMataKuliah', 'Sipema\PemetaanMataKuliahController::getDetailPemetaanMataKuliah', ['filter' => 'role:admin,dosen,pimpinan,mahasiswa']);
    $routes->get('detail/(:any)', 'Sipema\PemetaanMataKuliahController::detail/$1', ['filter' => 'role:admin,dosen,pimpinan']);
    $routes->get('tambah_sub_bidang_pemetaan', 'Sipema\PemetaanMataKuliahController::tambah_sub_bidang_pemetaan', ['filter' => 'role:admin,dosen']);
    $routes->get('tambah_detail_pemetaan_mata_kuliah/(:any)', 'Sipema\PemetaanMataKuliahController::tambah_detail_pemetaan_mata_kuliah/$1', ['filter' => 'role:admin,dosen']);
    $routes->post('simpan', 'Sipema\PemetaanMataKuliahController::simpan', ['filter' => 'role:admin,dosen']);
    // Edit Data
    $routes->get('edit_sub_bidang_pemetaan/(:any)', 'Sipema\PemetaanMataKuliahController::edit_sub_bidang_pemetaan/$1', ['filter' => 'role:admin,dosen']);
    $routes->get('edit_detail_pemetaan_mata_kuliah/(:any)/(:any)', 'Sipema\PemetaanMataKuliahController::edit_detail_pemetaan_mata_kuliah/$1/$2', ['filter' => 'role:admin,dosen']);
    $routes->post('update_sub_bidang/(:any)', 'Sipema\PemetaanMataKuliahController::update_sub_bidang_pemetaan/$1', ['filter' => 'role:admin,dosen']);
    $routes->post('update_detail_pemetaan_mata_kuliah/(:any)/(:any)', 'Sipema\PemetaanMataKuliahController::update_detail_pemetaan_mata_kuliah/$1/$2', ['filter' => 'role:admin,dosen']);
    // Hapus Data
    $routes->delete('hapus_sub_bidang_pemetaan/(:any)', 'Sipema\PemetaanMataKuliahController::hapus_sub_bidang_pemetaan/$1', ['filter' => 'role:admin,dosen']);
    $routes->delete('hapus_detail_pemetaan_mata_kuliah/(:any)', 'Sipema\PemetaanMataKuliahController::hapus_detail_pemetaan_mata_kuliah/$1', ['filter' => 'role:admin,dosen']);
});

// Rekomendasi Mahasiswa
$routes->group('sipema/rekomendasi', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Sipema\RekomendasiController::index', ['filter' => 'role:admin,dosen,pimpinan']);
    $routes->get('get_dosen_by_sub_bidang_id/(:any)', 'Sipema\RekomendasiController::get_dosen_by_sub_bidang_id/$1', ['filter' => 'role:admin,dosen,pimpinan,mahasiswa']);
    $routes->get('tambah', 'Sipema\RekomendasiController::tambah', ['filter' => 'role:admin,dosen']);
    $routes->post('simpan', 'Sipema\RekomendasiController::simpan', ['filter' => 'role:admin,dosen']);
    // Edit Data
    $routes->get('edit/(:any)', 'Sipema\RekomendasiController::edit/$1', ['filter' => 'role:admin,dosen']);
    $routes->post('update/(:any)', 'Sipema\RekomendasiController::update/$1', ['filter' => 'role:admin,dosen']);
    // Hapus Data
    $routes->delete('hapus/(:any)', 'Sipema\RekomendasiController::hapus/$1', ['filter' => 'role:admin,dosen']);
});

// Hasil Pemetaan Keterampilan Mahasiswa Menggunakan Nilai
$routes->group('sipema/hasil_pemetaan_keterampilan', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Sipema\HasilPemetaanKeterampilanController::index', ['filter' => 'role:admin,dosen,pimpinan']);
    $routes->get('getChartDataByMahasiswa/(:any)', 'Sipema\HasilPemetaanKeterampilanController::getChartDataByMahasiswa/$1', ['filter' => 'role:admin,dosen,pimpinan,mahasiswa']);
    $routes->get('getDataSubBidang/(:any)(/(:any))?(/(:any))?(/(:any))?', 'Sipema\HasilPemetaanKeterampilanController::getDataSubBidang/$1/$2/$3/$4', ['filter' => 'role:admin,dosen,pimpinan,mahasiswa']);
    $routes->get('getDataBidangNilaiAkhirSks/(:any)/(:any)/(:any)', 'Sipema\HasilPemetaanKeterampilanController::getDataBidangNilaiAkhirSks/$1/$2/$3', ['filter' => 'role:admin,dosen,pimpinan,mahasiswa']);
    $routes->get('getDataBidangNilaiAkhir/(:any)/(:any)', 'Sipema\HasilPemetaanKeterampilanController::getDataBidangNilaiAkhir/$1/$2', ['filter' => 'role:admin,dosen,pimpinan,mahasiswa']);
    $routes->get('getDataBidangSks/(:any)/(:any)', 'Sipema\HasilPemetaanKeterampilanController::getDataBidangSks/$1/$2', ['filter' => 'role:admin,dosen,pimpinan,mahasiswa']);
    $routes->get('getDataBidangSubBidangSks/(:any)/(:any)/(:any)', 'Sipema\HasilPemetaanKeterampilanController::getDataBidangSubBidangSks/$1/$2/$3', ['filter' => 'role:admin,dosen,pimpinan,mahasiswa']);
    $routes->get('getSubBidangByBidang/(:any)', 'Sipema\HasilPemetaanKeterampilanController::getSubBidangByBidang/$1', ['filter' => 'role:admin,dosen,pimpinan,mahasiswa']);
    $routes->get('getMataKuliahByMahasiswa/(:any)', 'Sipema\HasilPemetaanKeterampilanController::getMataKuliahByMahasiswa/$1', ['filter' => 'role:admin,dosen,pimpinan,mahasiswa']);
    $routes->get('tambah', 'Sipema\HasilPemetaanKeterampilanController::tambah', ['filter' => 'role:admin,dosen']);
    $routes->post('simpan', 'Sipema\HasilPemetaanKeterampilanController::simpan', ['filter' => 'role:admin,dosen']);
    // Edit Data
    $routes->get('edit/(:any)', 'Sipema\HasilPemetaanKeterampilanController::edit/$1', ['filter' => 'role:admin,dosen']);
    $routes->post('update/(:any)', 'Sipema\HasilPemetaanKeterampilanController::update/$1', ['filter' => 'role:admin,dosen']);
    // Hapus Data
    $routes->delete('hapus/(:any)', 'Sipema\HasilPemetaanKeterampilanController::hapus/$1', ['filter' => 'role:admin,dosen']);
});

/*
 * --------------------------------------------------------------------
 *                        SI MANAJEMEN LABORATORIUM
 * --------------------------------------------------------------------
 */

$routes->get('simlab', 'DashboardController::simlab', ['filter' => 'login']);
// Pengelolaan Data Kategori
$routes->group('simlab/kategori', ['filter' => 'login'], static function ($routes) {
    $routes->get('', 'Simlab\KategoriController::index', ['filter' => 'role:laboran']);
    $routes->get('tambah', 'Simlab\KategoriController::tambah', ['filter' => 'role:laboran']);
    $routes->post('simpan', 'Simlab\KategoriController::simpan', ['filter' => 'role:laboran']);
    $routes->get('edit/(:any)', 'Simlab\KategoriController::edit/$1', ['filter' => 'role:laboran']);
    $routes->post('update/(:any)', 'Simlab\KategoriController::update/$1', ['filter' => 'role:laboran']);
    $routes->delete('hapus/(:any)', 'Simlab\KategoriController::hapus/$1', ['filter' => 'role:laboran']);

});

// Pengelolaan Data Ruang Laboratorium
$routes->group('simlab/ruang-laboratorium', ['filter' => 'login'], static function ($routes) {
    $routes->get('', 'Simlab\RuangLaboratoriumController::index', ['filter' => 'role:laboran']);
    $routes->get('tambah', 'Simlab\RuangLaboratoriumController::tambah', ['filter' => 'role:laboran']);
    $routes->post('simpan', 'Simlab\RuangLaboratoriumController::simpan', ['filter' => 'role:laboran']);
    $routes->get('edit/(:any)', 'Simlab\RuangLaboratoriumController::edit/$1', ['filter' => 'role:laboran']);
    $routes->post('update/(:any)', 'Simlab\RuangLaboratoriumController::update/$1', ['filter' => 'role:laboran']);
    $routes->delete('hapus/(:any)', 'Simlab\RuangLaboratoriumController::hapus/$1', ['filter' => 'role:laboran']);
});

// Pengelolaan Data Alat Laboratorium
$routes->group('simlab/alat-laboratorium', ['filter' => 'login'], static function ($routes) {
    $routes->get('', 'Simlab\AlatLaboratoriumController::index');
    $routes->get('testPdf', 'Simlab\AlatLaboratoriumController::testPdf');
    $routes->get('tambah', 'Simlab\AlatLaboratoriumController::tambah');
    $routes->post('simpan', 'Simlab\AlatLaboratoriumController::simpan');
    $routes->get('edit/(:any)', 'Simlab\AlatLaboratoriumController::edit/$1');
    $routes->post('update/(:any)', 'Simlab\AlatLaboratoriumController::update/$1');
    $routes->delete('hapus/(:any)', 'Simlab\AlatLaboratoriumController::hapus/$1');
    $routes->get('detail/(:any)', 'Simlab\AlatLaboratoriumController::detail/$1');
    $routes->get('alat-rusak', 'Simlab\AlatLaboratoriumController::alat_rusak/$1');
});

// Pengelolaan Data Perawatan Alat Laboratorium
$routes->group('simlab/perawatan-alat', ['filter' => 'login'], static function ($routes) {
    $routes->get('', 'Simlab\PerawatanAlatLabController::index');
    $routes->get('tambah', 'Simlab\PerawatanAlatLabController::tambah');
    $routes->post('simpan', 'Simlab\PerawatanAlatLabController::simpan');
    $routes->get('edit/(:any)', 'Simlab\PerawatanAlatLabController::edit/$1');
    $routes->post('update/(:any)', 'Simlab\PerawatanAlatLabController::update/$1');
    $routes->delete('hapus/(:any)', 'Simlab\PerawatanAlatLabController::hapus/$1');
});

// Pengelolaan Data Penghapusan Aset
$routes->group('simlab/penghapusan-aset', ['filter' => 'login'], static function ($routes) {
    $routes->get('', 'Simlab\PenghapusanAsetController::index');
    $routes->get('tambah', 'Simlab\PenghapusanAsetController::tambah');
    $routes->post('simpan', 'Simlab\PenghapusanAsetController::simpan');
    $routes->get('edit/(:any)', 'Simlab\PenghapusanAsetController::edit/$1');
    $routes->post('update/(:any)', 'Simlab\PenghapusanAsetController::update/$1');
    $routes->delete('hapus/(:any)', 'Simlab\PenghapusanAsetController::hapus/$1');
    $routes->get('cek-stok/(:any)', 'Simlab\AlatLaboratoriumController::getStokByAlat/$1');
});

// Pengelolaan Data Jadwal Penggunaan Ruang Laboratorium
$routes->group('simlab/penggunaan-ruang-laboratorium', ['filter' => 'login'], static function ($routes) {
    $routes->get('pilih-kondisi', 'Simlab\JadwalRuangController::pilih_kondisi');
    $routes->get('pilih-ruang/praktikum', 'Simlab\JadwalRuangController::pilih_ruang_praktikum');
    $routes->get('pilih-ruang/peminjaman', 'Simlab\JadwalRuangController::pilih_ruang_peminjaman');
    $routes->get('lihat/(:any)', 'Simlab\JadwalRuangController::lihat/$1');
    $routes->get('lihat-ruang-dipinjam/(:any)', 'Simlab\JadwalRuangController::lihat_ruang_dipinjam/$1');
    $routes->get('tambah/(:any)', 'Simlab\JadwalRuangController::tambah/$1');
    $routes->post('simpan', 'Simlab\JadwalRuangController::simpan');
    $routes->get('edit/(:any)/(:any)', 'Simlab\JadwalRuangController::edit/$1/$2');
    $routes->post('update/(:any)/(:any)', 'Simlab\JadwalRuangController::update/$1/$2');
    $routes->delete('hapus/(:any)', 'Simlab\JadwalRuangController::hapus/$1');
});

// Pengajuan Peminjaman
$routes->group('simlab/pengajuan-peminjaman', ['filter' => 'login'], static function ($routes) {
    $routes->get('alat-laboratorium', 'Simlab\PeminjamanController::pengajuan_peminjaman_alat');
    $routes->post('alat-laboratorium/simpan', 'Simlab\PeminjamanController::pengajuan_peminjaman_alat_simpan');
    $routes->get('ruang-laboratorium', 'Simlab\PeminjamanController::pengajuan_peminjaman_ruang');
    $routes->post('ruang-laboratorium/simpan', 'Simlab\PeminjamanController::pengajuan_peminjaman_ruang_simpan');
});

// untuk user perminjam melihat status ajuan dan status peminjaman serta riwayat peminjaman
$routes->group('simlab/peminjaman', ['filter' => 'login'], static function ($routes) {
    $routes->get('', 'Simlab\PeminjamanController::index');
    $routes->get('data-peminjaman/alat-laboratorium', 'Simlab\PeminjamanController::data_peminjaman_alat');
    $routes->get('data-peminjaman/ruang-laboratorium', 'Simlab\PeminjamanController::data_peminjaman_ruang');
    $routes->get('riwayat-peminjaman/alat-laboratorium', 'Simlab\PeminjamanController::riwayat_peminjaman_alat');
    $routes->get('riwayat-peminjaman/ruang-laboratorium', 'Simlab\PeminjamanController::riwayat_peminjaman_ruang');
});

$routes->group('simlab/detail-peminjaman', ['filter' => 'login'], static function ($routes) {
    $routes->get('alat-laboratorium/(:any)', 'Simlab\PeminjamanController::detail_peminjaman_alat/$1');
    $routes->get('ruang-laboratorium/(:any)', 'Simlab\PeminjamanController::detail_peminjaman_ruang/$1');
});

// Generate surat peminjaan
$routes->group('simlab/surat-peminjaman', ['filter' => 'login'], static function ($routes) {
    $routes->get('alat-laboratorium/(:any)', 'Simlab\PeminjamanController::generate_surat_pinjam_alat/$1');
    $routes->get('ruang-laboratorium/(:any)', 'Simlab\PeminjamanController::generate_surat_pinjam_ruang/$1');
});

// Laporan
$routes->group('simlab/laporan', ['filter' => 'login', 'role:laboran'], static function ($routes) {
    $routes->get('', 'Simlab\LaporanController::index', ['filter' => 'role:laboran']);
    $routes->get('alat-masuk', 'Simlab\LaporanController::alatMasuk', ['filter' => 'role:laboran']);
    $routes->get('filter-alat-masuk/(:any)/(:any)/(:any)', 'Simlab\LaporanController::getFilterAlatMasuk/$1/$2/$3', ['filter' => 'role:laboran']);
    $routes->get('alat-masuk/download-pdf/(:any)/(:any)/(:any)', 'Simlab\LaporanController::alatMasukPdf/$1/$2/$3', ['filter' => 'role:laboran']);
    $routes->get('alat-rusak', 'Simlab\LaporanController::alatRusak');
    $routes->get('filter-alat-rusak/(:any)/(:any)/(:any)', 'Simlab\LaporanController::getFilterAlatRusak/$1/$2/$3', ['filter' => 'role:laboran']);
    $routes->get('alat-rusak/download-pdf/(:any)/(:any)/(:any)', 'Simlab\LaporanController::alatRusakPdf/$1/$2/$3', ['filter' => 'role:laboran']);
    $routes->get('penghapusan-aset', 'Simlab\LaporanController::penghapusanAset');
    $routes->get('filter-penghapusan-aset/(:any)/(:any)/(:any)', 'Simlab\LaporanController::getFilterPenghapusanAset/$1/$2/$3', ['filter' => 'role:laboran']);
    $routes->get('penghapusan-aset/download-pdf/(:any)/(:any)/(:any)', 'Simlab\LaporanController::penghapusanAsetPdf/$1/$2/$3', ['filter' => 'role:laboran']);
    $routes->get('perawatan-alat', 'Simlab\LaporanController::perawatanAlat');
    $routes->get('filter-perawatan-alat/(:any)/(:any)/(:any)', 'Simlab\LaporanController::getFilterPerawatanAlat/$1/$2/$3', ['filter' => 'role:laboran']);
    $routes->get('perawatan-alat/download-pdf/(:any)/(:any)/(:any)', 'Simlab\LaporanController::perawatanAlatPdf/$1/$2/$3', ['filter' => 'role:laboran']);
    $routes->get('jadwal-praktikum', 'Simlab\LaporanController::ruangPraktikum');
    $routes->get('filter-jadwal-praktikum/(:any)/(:any)/(:any)', 'Simlab\LaporanController::getFilterRuangPraktikum/$1/$2/$3', ['filter' => 'role:laboran']);
    $routes->get('ruang-praktikum/download-pdf/(:any)/(:any)/(:any)', 'Simlab\LaporanController::ruangPraktikumPdf/$1/$2/$3', ['filter' => 'role:laboran']);
    $routes->get('peminjaman-alat', 'Simlab\LaporanController::peminjamanAlat');
    $routes->get('filter-peminjaman-alat/(:any)/(:any)', 'Simlab\LaporanController::getFilterPeminjamanAlat/$1/$2', ['filter' => 'role:laboran']);
    $routes->get('peminjaman-alat/download-pdf/(:any)/(:any)', 'Simlab\LaporanController::peminjamanAlatPdf/$1/$2', ['filter' => 'role:laboran']);
    $routes->get('peminjaman-ruang', 'Simlab\LaporanController::peminjamanRuang');
    $routes->get('filter-peminjaman-ruang/(:any)/(:any)', 'Simlab\LaporanController::getFilterPeminjamanRuang/$1/$2', ['filter' => 'role:laboran']);
    $routes->get('peminjaman-ruang/download-pdf/(:any)/(:any)', 'Simlab\LaporanController::peminjamanRuangPdf/$1/$2', ['filter' => 'role:laboran']);
});

// Transaksi Pengelolaan dan Konfirmasi Peminjaman oleh Laboran
$routes->group('simlab/transaksi', ['filter' => 'login'], static function ($routes) {
    $routes->get('', 'Simlab\TransaksiPeminjamanController::index');
    $routes->get('konfirmasi-pengajuan-peminjaman/alat-laboratorium', 'Simlab\TransaksiPeminjamanController::dataPengajuanAlat');
    $routes->get('konfirmasi-pengajuan-peminjaman/ruang-laboratorium', 'Simlab\TransaksiPeminjamanController::dataPengajuanRuang');
    $routes->get('detail-peminjaman-alat-laboratorium/(:any)', 'Simlab\TransaksiPeminjamanController::detail_peminjaman_alat/$1');
    $routes->get('konfirmasi-pengajuan-peminjaman/alat-laboratorium/disetujui/(:any)', 'Simlab\TransaksiPeminjamanController::verif_disetujui_alat/$1');
    $routes->get('konfirmasi-pengajuan-peminjaman/ruang-laboratorium/disetujui/(:any)', 'Simlab\TransaksiPeminjamanController::verif_disetujui_ruang/$1'); //BUOSOKKK IKI API NE
    $routes->post('konfirmasi-pengajuan-peminjaman/alat-laboratorium/ditolak/(:any)', 'Simlab\TransaksiPeminjamanController::verif_ditolak_alat/$1');
    $routes->post('konfirmasi-pengajuan-peminjaman/ruang-laboratorium/ditolak/(:any)', 'Simlab\TransaksiPeminjamanController::verif_ditolak_ruang/$1');
    $routes->get('konfirmasi-pengembalian/alat-laboratorium', 'Simlab\TransaksiPeminjamanController::dataPeminjamanAlat');
    $routes->get('konfirmasi-pengembalian/ruang-laboratorium', 'Simlab\TransaksiPeminjamanController::dataPeminjamanRuang');
    $routes->post('konfirmasi-pengembalian/alat-laboratorium/dikembalikan/(:any)', 'Simlab\TransaksiPeminjamanController::verif_pengembalian_alat/$1');
    $routes->get('konfirmasi-pengembalian/ruang-laboratorium/dikembalikan/(:any)', 'Simlab\TransaksiPeminjamanController::verif_pengembalian_ruang/$1');
    $routes->get('riwayat-peminjaman/alat-laboratorium', 'Simlab\TransaksiPeminjamanController::riwayat_peminjaman_alat');
    $routes->get('riwayat-peminjaman/ruang-laboratorium', 'Simlab\TransaksiPeminjamanController::riwayat_peminjaman_ruang');
});

// getstok ajuan pinjam
$routes->post('simlab/alatlab/getStokByAlat/(:any)', 'Simlab\AlatLaboratoriumController::getStokByAlat/$1');
//get alat yang dipinjam
$routes->get('simlab/detail-alat-dipinjam/(:any)', 'Simlab\TransaksiPeminjamanController::detail_alat/$1');
/*
 * --------------------------------------------------------------------
 *                        SIM KMM
 * --------------------------------------------------------------------
 */

// Dashboard
$routes->get('kmm', 'DashboardController::simkmm', ['filter' => 'login']);

// Pengelolaan Berkas Pendukung KMM
$routes->group('kmm/berkas', ['filter' => ['login', 'role:admin,koor-kmm']], static function ($routes) {
    $routes->get('/', 'Kmm\BerkasController::index');
    // Tambah Berkas
    $routes->get('tambah', 'Kmm\BerkasController::create');
    $routes->post('tambah/simpan', 'Kmm\BerkasController::store');
    // Edit Berkas
    $routes->get('edit/(:any)', 'Kmm\BerkasController::edit/$1');
    $routes->post('update/(:any)', 'Kmm\BerkasController::update/$1');
    // Hapus Berkas
    $routes->delete('hapus/(:any)', 'Kmm\BerkasController::delete/$1');
    // Download Berkas
    $routes->get('download/(:any)', 'Kmm\BerkasController::download/$1');
});

// Pengelolaan Data Bobot Penilaian KMM
$routes->group('kmm/bobot', ['filter' => ['login', 'role:admin,koor-kmm']], static function ($routes) {
    $routes->get('/', 'Kmm\BobotController::index');
    // Edit Bobot
    $routes->get('edit/(:any)', 'Kmm\BobotController::edit/$1');
    $routes->post('update/(:any)', 'Kmm\BobotController::update/$1');
});

// Pengelolaan Data Pengajuan Proposal Awal
$routes->group('kmm/proposal', ['filter' => 'login'], static function ($routes) {
    $routes->get('/', 'Kmm\ProposalController::index', ['filter' => 'role:mahasiswa,dosen']);
    // Pengajuan Proposal Awal
    $routes->get('pengajuan', 'Kmm\ProposalController::create', ['filter' => 'role:mahasiswa']);
    $routes->post('pengajuan/store', 'Kmm\ProposalController::store', ['filter' => 'role:mahasiswa']);
    // Edit Pengajuan Proposal Awal
    $routes->get('edit/(:any)', 'Kmm\ProposalController::edit/$1', ['filter' => 'role:mahasiswa']);
    $routes->post('update/(:any)', 'Kmm\ProposalController::update/$1', ['filter' => 'role:mahasiswa']);
    // Hapus Pengajuan Proposal Awal
    $routes->delete('hapus/(:any)', 'Kmm\ProposalController::delete/$1', ['filter' => 'role:mahasiswa,dosen']);
    // $routes->post('hapus/(:any)', 'Kmm\ProposalController::delete/$1', ['filter' => 'role:mahasiswa,dosen']);
    // Download Proposal Awal
    $routes->get('download/(:any)', 'Kmm\ProposalController::download_proposal/$1', ['filter' => 'role:mahasiswa,dosen']);
    // Verifikasi Pengajuan Proposal Awal oleh Dosen
    $routes->get('verifikasi-setuju/(:any)', 'Kmm\ProposalController::verif_disetujui/$1', ['filter' => 'role:dosen']);
    $routes->post('verifikasi-revisi/(:any)', 'Kmm\ProposalController::verif_revisi/$1', ['filter' => 'role:dosen']);
    $routes->get('verifikasi-gagal/(:any)', 'Kmm\ProposalController::verif_tidak_disetujui/$1', ['filter' => 'role:dosen']);
    // Filter Pengajuan Proposal KMM
    $routes->get('getFilterProposalByIdDosen/(:any)', 'Kmm\ProposalController::getFilterProposalByIdDosen/$1', ['filter' => 'role:dosen']);
});

// Pengelolaan Data KMM
$routes->group('kmm/kmm', ['filter' => 'login'], static function ($routes) {
    $routes->get('/', 'Kmm\KmmController::index');
    // Detail KMM
    $routes->get('detail/(:any)', 'Kmm\KmmController::detail/$1');
    // Pendaftaran KMM
    $routes->get('tambah', 'Kmm\KmmController::create');
    $routes->post('tambah/store', 'Kmm\KmmController::store');
    // Edit KMM
    $routes->get('edit/(:any)', 'Kmm\KmmController::edit/$1');
    $routes->post('update/(:any)', 'Kmm\KmmController::update/$1');
    // Hapus KMM
    $routes->delete('hapus/(:any)', 'Kmm\KmmController::delete/$1');
    // Download Proposal Akhir KMM
    $routes->get('download-proposal/(:any)', 'Kmm\KmmController::download_proposal/$1');
    // Download Surat Pengantar KMM
    $routes->get('download-surat-pengantar/(:any)', 'Kmm\KmmController::download_surat_pengantar/$1');
    // Update Status Kelolosan
    $routes->post('verifikasi/lolos/(:any)', 'Kmm\KmmController::verif_lolos/$1');
    $routes->post('verifikasi/tidak-lolos/(:any)', 'Kmm\KmmController::verif_tidak_lolos/$1');
    $routes->get('getFilterDataKMM/(:any)', 'Kmm\KmmController::getFilterDataKMM/$1');
    $routes->get('getFilterDataKMMByIdDosen/(:any)', 'Kmm\KmmController::getFilterDataKMMByIdDosen/$1');
    // Download LoA
    $routes->get('download-loa/(:any)', 'Kmm\KmmController::download_loa/$1');
    // Download Bukti Tidak Lolos KMM
    $routes->get('download-bukti-gagal/(:any)', 'Kmm\KmmController::download_bukti_gagal/$1');
});

// Pengalolaan Data Pengajuan Laporan Akhir KMM
$routes->group('kmm/lap-akhir', ['filter' => 'login'], static function ($routes) {
    $routes->get('/', 'Kmm\LapAkhirController::index');
    //Upload Laporan Akhir
    $routes->post('upload/(:any)', 'Kmm\LapAkhirController::upload_lap_akhir/$1');
    // Download Laporan Akhir
    $routes->get('download/(:any)', 'Kmm\LapAkhirController::download_lap_akhir/$1');
    // Verifikasi Laporan Akhir oleh Dosen
    $routes->get('verifikasi-setuju/(:any)', 'Kmm\LapAkhirController::verif_disetujui/$1');
    $routes->post('verifikasi-revisi/(:any)', 'Kmm\LapAkhirController::verif_revisi/$1');
    $routes->get('getFilterDataLapAkhir/(:any)', 'Kmm\LapAkhirController::getFilterDataLapAkhir/$1');
    $routes->get('getFilterDataLapAkhirByIdDosen/(:any)', 'Kmm\LapAkhirController::getFilterDataLapAkhirByIdDosen/$1');
});

// Pengalolaan Data Seminar KMM
$routes->group('kmm/seminar', ['filter' => 'login'], static function ($routes) {
    $routes->get('/', 'Kmm\SeminarController::index');
    //Pendaftaran Seminar
    $routes->get('daftar/(:any)', 'Kmm\SeminarController::edit/$1');
    $routes->post('daftar/simpan/(:any)', 'Kmm\SeminarController::update/$1');
    //Update Jadwal Seminar
    $routes->post('update/(:any)', 'Kmm\SeminarController::update_jadwal_seminar/$1');
    $routes->get('getFilterDataSeminar/(:any)', 'Kmm\SeminarController::getFilterDataSeminar/$1');
    $routes->get('getFilterDataSeminarByIdDosen/(:any)', 'Kmm\SeminarController::getFilterDataSeminarByIdDosen/$1');
});

// Pengelolaan Pertanyaan untuk Penilaian Seminar KMM
$routes->group('kmm/pertanyaan-penilaian', ['filter' => ['login', 'role:admin,dosen,koor-kmm']], static function ($routes) {
    $routes->get('/', 'Kmm\PertanyaanController::index');
    // Tambah Pertanyaan
    $routes->get('tambah', 'Kmm\PertanyaanController::create');
    $routes->post('tambah/store', 'Kmm\PertanyaanController::store');
    // Edit Pertanyaan
    $routes->get('edit/(:any)', 'Kmm\PertanyaanController::edit/$1');
    $routes->post('update/(:any)', 'Kmm\PertanyaanController::update/$1');
    // Hapus Pertanyaan
    $routes->delete('hapus/(:any)', 'Kmm\PertanyaanController::delete/$1');
});

// Pengelolaan Penilaian KMM
$routes->group('kmm/penilaian', ['filter' => 'login'], static function ($routes) {
    $routes->get('/', 'Kmm\PenilaianController::index');
    // Tambah Pertanyaan
    $routes->get('kmm/dosen/(:any)', 'Kmm\PenilaianController::penilaian_dosen/$1');
    $routes->post('dosen/(:any)', 'Kmm\PenilaianController::simpan_penilaian_dosen/$');

    $routes->get('kmm/mitra/(:any)', 'Kmm\PenilaianController::penilaian_mitra/$1');
    $routes->post('mitra/(:any)', 'Kmm\PenilaianController::simpan_penilaian_mitra/$');
    $routes->get('getFilterDataNilaiByIdDosen/(:any)', 'Kmm\PenilaianController::getFilterDataNilaiByIdDosen/$1');
    $routes->get('getFilterDataNilai/(:any)', 'Kmm\PenilaianController::getFilterDataNilai/$1');
    $routes->get('cetak-penilaian-prodi/(:any)', 'Kmm\PenilaianController::cetak_penilaian_prodi_pdf/$1');
    $routes->get('cetak-penilaian-mitra/(:any)', 'Kmm\PenilaianController::cetak_penilaian_mitra_pdf/$1');
    $routes->get('cetak/(:any)', 'Kmm\PenilaianController::cetak_penilaian_excel/$1');

});

/*
 * --------------------------------------------------------------------
 *                        SIM MBKM
 * --------------------------------------------------------------------
 */
// Test Export Excel
$routes->get('mbkm/exportExcel', 'Mbkm\MsibController::exportExcel', ['filter' => 'login']);
// Dashboard MBKM
$routes->get('mbkm', 'DashboardController::mbkm', ['filter' => 'login']);
// download pdf
$routes->get('download-berkas/(:any)', 'DashboardController::download_berkas_mbkm/$1');
// Pengelolaan Data MSIB
$routes->group('mbkm/msib', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Mbkm\MsibController::index');
    // Tambah Data
    $routes->get('tambah', 'Mbkm\MsibController::tambah');
    $routes->post('simpan', 'Mbkm\MsibController::simpan');
    // Edit Data
    $routes->get('edit/(:any)', 'Mbkm\MsibController::edit/$1');
    $routes->post('update/(:any)', 'Mbkm\MsibController::update/$1');
    // Hapus Data
    $routes->delete('hapus/(:any)', 'Mbkm\MsibController::hapus/$1');
    // download pdf
    $routes->get('download-sr/(:any)', 'Mbkm\MsibController::download_sr/$1');
    $routes->get('download-sptjm/(:any)', 'Mbkm\MsibController::download_sptjm/$1');
    //verif dosen
    $routes->get('dosen/verifikasi-setujui/(:any)', 'Mbkm\MsibController::verif_disetujui_dosen/$1');
    $routes->get('dosen/verifikasi-tidak-disetujui/(:any)', 'Mbkm\MsibController::verif_tidak_disetujui_dosen/$1');
    // Edit Data Status Mhs
    $routes->get('edit-status-mhs/(:any)', 'Mbkm\MsibController::edit_status_mhs/$1');
    //  $routes->post('update-status-mhs/(:any)', 'Mbkm\MsibController::update_status_mhs/$1')
    $routes->post('update-status-mhs/(:any)', 'Mbkm\MbkmFixController::update_insert_msib/$1');;
    $routes->get('filter-msib/(:any)', 'Mbkm\MsibController::filterMsibAdm/$1');
    $routes->get('filter-msib-dsn/(:any)', 'Mbkm\MsibController::filterMsibDosen/$1');
    // SPTJM & SR
    $routes->get('upload-berkas/(:any)', 'Mbkm\MsibController::upload_berkas/$1');
    $routes->post('proses-upload-berkas/(:any)', 'Mbkm\MsibController::proses_upload_berkas/$1');
    $routes->get('upload-sptjm/(:any)', 'Mbkm\MsibController::upload_sptjm/$1');
    $routes->post('proses-upload-sptjm/(:any)', 'Mbkm\MsibController::proses_upload_sptjm/$1');
    $routes->get('detail/(:any)', 'Mbkm\MsibController::detail/$1');

});
// Pengelolaan Data MBKM Prodi
$routes->group('mbkm/mbkmProdi', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Mbkm\MbkmProdiController::index');
    $routes->get('detail/(:any)', 'Mbkm\MbkmProdiController::detail/$1');
    // Tambah Data
    $routes->get('tambah', 'Mbkm\MbkmProdiController::tambah');
    $routes->post('simpan', 'Mbkm\MbkmProdiController::simpan');
    // Edit Data
    $routes->get('edit/(:any)', 'Mbkm\MbkmProdiController::edit/$1');
    $routes->post('update/(:any)', 'Mbkm\MbkmProdiController::update/$1');
    // Hapus Data
    $routes->delete('hapus/(:any)', 'Mbkm\MbkmProdiController::hapus/$1');
    $routes->get('download-LoA/(:any)', 'Mbkm\MbkmProdiController::download_loa/$1');
    $routes->get('download-lap-akhir/(:any)', 'Mbkm\MbkmProdiController::download_lap_akhir/$1');
    //verif dosen
    $routes->get('dosen/verifikasi-setujui/(:any)', 'Mbkm\MbkmProdiController::verif_disetujui_dosen/$1');
    $routes->get('dosen/verifikasi-tidak-disetujui/(:any)', 'Mbkm\MbkmProdiController::verif_tidak_disetujui_dosen/$1');
    //verif mhs
    // download pdf
    $routes->get('download-sr/(:any)', 'Mbkm\MbkmProdiController::download_sr/$1');
    // Edit Data
    $routes->get('edit-status-mhs/(:any)', 'Mbkm\MbkmProdiController::edit_status_mhs/$1');
    // $routes->post('update-status-mhs/(:any)', 'Mbkm\MbkmProdiController::update_status_mhs/$1');
    $routes->post('update-status-mhs/(:any)', 'Mbkm\MbkmFixController::update_insert/$1');
    $routes->get('filter-prodi/(:any)', 'Mbkm\MbkmProdiController::filterProdiAdm/$1');
    $routes->get('filter-prodi-dsn/(:any)', 'Mbkm\MbkmProdiController::filterProdiDosen/$1');

    $routes->get('upload-sr/(:any)', 'Mbkm\MbkmProdiController::upload_sr/$1');
    $routes->post('proses-upload-sr/(:any)', 'Mbkm\MbkmProdiController::proses_upload_sr/$1');
});

// Pengelolaan Data MBKM Hibah
$routes->group('mbkm/hibah', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Mbkm\MbkmHibahController::index');
    $routes->get('detail/(:any)', 'Mbkm\MbkmHibahController::detail/$1');
    // Tambah Data
    $routes->get('tambah', 'Mbkm\MbkmHibahController::tambah');
    $routes->post('simpan', 'Mbkm\MbkmHibahController::simpan');
    // Edit Data
    $routes->get('edit/(:any)', 'Mbkm\MbkmHibahController::edit/$1');
    $routes->post('update/(:any)', 'Mbkm\MbkmHibahController::update/$1');
    // Edit Data
    $routes->get('upload-sr/(:any)', 'Mbkm\MbkmHibahController::upload_sr/$1');
    $routes->post('proses-upload-sr/(:any)', 'Mbkm\MbkmHibahController::proses_upload_sr/$1');
    // Hapus Data
    $routes->delete('hapus/(:any)', 'Mbkm\MbkmHibahController::hapus/$1');
    // download pdf
    $routes->get('download-proposal/(:any)', 'Mbkm\MbkmHibahController::download_proposal/$1');
    $routes->get('download-sr/(:any)', 'Mbkm\MbkmHibahController::download_surat_rekom/$1');
    // $routes->get('download-lap-akhir/(:any)', 'Mbkm\MbkmHibahController::download_lap_akhir/$1');
    //verif dosen
    $routes->get('dosen/verifikasi-setujui/(:any)', 'Mbkm\MbkmHibahController::verif_disetujui_dosen/$1');
    $routes->get('dosen/verifikasi-tidak-disetujui/(:any)', 'Mbkm\MbkmHibahController::verif_tidak_disetujui_dosen/$1');
    // Edit Data Status Mhs
    $routes->get('edit-status-mhs/(:any)', 'Mbkm\MbkmHibahController::edit_status_mhs/$1');
    // $routes->post('update-status-mhs/(:any)', 'Mbkm\MbkmHibahController::update_status_mhs/$1');
    $routes->post('update-status-mhs/(:any)', 'Mbkm\MbkmFixController::update_insert_hibah/$1');
    $routes->get('filter-hibah/(:any)', 'Mbkm\MbkmHibahController::filterHibahAdm/$1');
    $routes->get('filter-hibah-dsn/(:any)', 'Mbkm\MbkmHibahController::filterHibahDosen/$1');
});

// Monitoring
$routes->group('mbkm/monitoring', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Mbkm\MonitoringController::index');
    // tampil mon Hibah dsn adm
    $routes->get('msib', 'Mbkm\MonitoringController::index_mon_msib');
    $routes->get('mbkm-prodi', 'Mbkm\MonitoringController::index_mon_prodi');
    $routes->get('mbkm-hibah', 'Mbkm\MonitoringController::index_mon_hibah');
    // Tambah Data
    $routes->get('tambah/(:any)', 'Mbkm\MonitoringController::tambah/$1');
    $routes->post('simpan/(:any)', 'Mbkm\MonitoringController::simpan/$1');
    // Edit Data
    $routes->get('tambah-dosen/(:any)', 'Mbkm\MonitoringController::tambah_dosen/$1');
    $routes->post('simpan-dosen/(:any)', 'Mbkm\MonitoringController::simpan_dosen/$1');
    $routes->get('tambah-dosen-msib/(:any)', 'Mbkm\MonitoringController::tambah_dosen_msib/$1');
    $routes->post('simpan-dosen-msib/(:any)', 'Mbkm\MonitoringController::simpan_dosen_msib/$1');
    $routes->get('tambah-dosen-hibah/(:any)', 'Mbkm\MonitoringController::tambah_dosen_hibah/$1');
    $routes->post('simpan-dosen-hibah/(:any)', 'Mbkm\MonitoringController::simpan_dosen_hibah/$1');
    // Hapus Data
    $routes->delete('hapus/(:any)', 'Mbkm\MonitoringController::hapus/$1');
    // detail mon setiap mbkm
    $routes->get('detail-msib/(:any)', 'Mbkm\MonitoringController::detail_mon_msib/$1');
    $routes->get('detail-mbkm-prodi/(:any)', 'Mbkm\MonitoringController::detail_mon_prodi/$1');
    $routes->get('detail-mbkm-hibah/(:any)', 'Mbkm\MonitoringController::detail_mon_hibah/$1');

    $routes->get('filter-adm-msib/(:any)', 'Mbkm\MonitoringController::filterAdm/$1');
    $routes->get('filter-dsn-msib/(:any)', 'Mbkm\MonitoringController::filterDosen/$1');

    $routes->get('filter-adm-prodi/(:any)', 'Mbkm\MonitoringController::filterAdmProdi/$1');
    $routes->get('filter-dsn-prodi/(:any)', 'Mbkm\MonitoringController::filterDosenProdi/$1');

    $routes->get('filter-adm-hibah/(:any)', 'Mbkm\MonitoringController::filterAdmHibah/$1');
    $routes->get('filter-dsn-hibah/(:any)', 'Mbkm\MonitoringController::filterDosenHibah/$1');
});

// MBKM FIX
$routes->group('mbkm/mbkmFix', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Mbkm\MbkmFixController::index');
    $routes->get('detail/(:any)', 'Mbkm\MbkmFixController::detail/$1');

    //  update data fix
    $routes->get('id_mhs/(:any)/id_staf/(:any)/nama_instansi/(:any)', 'Mbkm\MbkmFixController::update_insert/$1/$2/$3');
    // Edit Data
    $routes->get('edit/(:any)', 'Mbkm\MbkmFixController::edit/$1');
    $routes->post('update/(:any)', 'Mbkm\MbkmFixController::update/$1');
    // Hapus Data
    $routes->delete('hapus/(:any)', 'Mbkm\MbkmFixController::hapus/$1');
    // Edit Data
    // $routes->get('upload-bukti/(:any)', 'Mbkm\MbkmFixController::update_bukti/$1');
    $routes->post('simpan-bukti/(:any)', 'Mbkm\MbkmFixController::simpan_bukti/$1');
    $routes->get('download-bukti/(:any)', 'Mbkm\MbkmFixController::download_bukti/$1');
    $routes->get('download-lap-akhir/(:any)', 'Mbkm\MbkmFixController::download_lap_akhir/$1');
    $routes->post('update-mitra/(:any)', 'Mbkm\MbkmFixController::update_mitra/$1');
    $routes->post('upload-lap-akhir/(:any)', 'Mbkm\MbkmFixController::proses_upload_lap/$1');
    $routes->post('upload-bukti/(:any)', 'Mbkm\MbkmFixController::proses_upload_bukti/$1');
    $routes->get('filter-adm/(:any)', 'Mbkm\MbkmFixController::filterAdm/$1');
    $routes->get('filter-dsn/(:any)', 'Mbkm\MbkmFixController::filterDosen/$1');
    //export 
    $routes->get('cetak-excel/(:any)', 'Mbkm\MbkmFixController::cetak_excel/$1');
    $routes->get('cetak-pdf/(:any)', 'Mbkm\MbkmFixController::cetak_pdf/$1');


});

// Berkas
$routes->group('mbkm/berkas', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Mbkm\BerkasController::index');
    // Tambah Data
    $routes->get('tambah', 'Mbkm\BerkasController::tambah');
    $routes->post('simpan', 'Mbkm\BerkasController::simpan');
    // Edit Data
    $routes->get('edit/(:any)', 'Mbkm\BerkasController::edit/$1');
    $routes->post('update/(:any)', 'Mbkm\BerkasController::update/$1');
    // Hapus Data
    $routes->delete('hapus/(:any)', 'Mbkm\BerkasController::hapus/$1');
    // download pdf
    $routes->get('download-berkas/(:any)', 'Mbkm\BerkasController::download_berkas/$1');
});

// Data Bobot Penilaian
$routes->group('mbkm/bobot', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Mbkm\BobotController::index');
    // Tambah Data
    $routes->get('tambah', 'Mbkm\BobotController::tambah');
    $routes->post('simpan', 'Mbkm\BobotController::simpan');
    // Edit Data
    $routes->get('edit/(:any)', 'Mbkm\BobotController::edit/$1');
    $routes->post('update/(:any)', 'Mbkm\BobotController::update/$1');
    // Hapus Data
    $routes->delete('hapus/(:any)', 'Mbkm\BobotController::hapus/$1');
});

// Data pertanyaan
$routes->group('mbkm/pertanyaan', ['filter' => 'login'], static function ($routes) {
    // Tampil Data UTS dan UAS
    $routes->get('', 'Mbkm\PertanyaanController::index');
    $routes->get('uts', 'Mbkm\PertanyaanController::index_uts');
    $routes->get('uas', 'Mbkm\PertanyaanController::index_uas');
    // Tambah Data UTS
    $routes->get('tambah', 'Mbkm\PertanyaanController::tambah');
    $routes->post('simpan', 'Mbkm\PertanyaanController::simpan');
    // Edit Data UTS
    $routes->get('edit/(:any)', 'Mbkm\PertanyaanController::edit/$1');
    $routes->post('update/(:any)', 'Mbkm\PertanyaanController::update/$1');
    // Hapus Data UTS
    $routes->delete('hapus/(:any)', 'Mbkm\PertanyaanController::hapus/$1');
    // Tambah Data UAS
    $routes->get('tambah_uas', 'Mbkm\PertanyaanController::tambah_uas');
    $routes->post('simpan_uas', 'Mbkm\PertanyaanController::simpan_uas');
    // Edit Data UAS
    $routes->get('edit_uas/(:any)', 'Mbkm\PertanyaanController::edit_uas/$1');
    $routes->post('update_uas/(:any)', 'Mbkm\PertanyaanController::update_uas/$1');
    // Hapus Data UAS
    $routes->delete('hapus_uas/(:any)', 'Mbkm\PertanyaanController::hapus_uas/$1');
});

// Data penilaian UTS
$routes->group('mbkm/penilaian', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Mbkm\PenilaianController::index');
    $routes->get('uts', 'Mbkm\PenilaianController::index_uts');
    // Tambah UTS Data dosen
    $routes->get('mbkm/dosen/(:any)', 'Mbkm\PenilaianController::penilaian_uts_dsn/$1');
    $routes->post('simpan/dosen/(:any)', 'Mbkm\PenilaianController::simpan_penilaian_uts_dsn/$');
    // Tambah UTS Data mitra
    $routes->get('mbkm/mitra/(:any)', 'Mbkm\PenilaianController::penilaian_uts_mtr/$1');
    $routes->post('simpan/mitra/(:any)', 'Mbkm\PenilaianController::simpan_penilaian_uts_mtr/$');
    // FILTER
    $routes->get('filter-adm/(:any)', 'Mbkm\PenilaianController::getFilterDataNilai/$1');
    $routes->get('filter-dsn/(:any)', 'Mbkm\PenilaianController::getFilterDataNilaiByIdDosen/$1');
    // export
    $routes->get('pdf-uts-dsn/(:any)', 'Mbkm\PenilaianController::cetak_nilai_uts_dsn_pdf/$1');
    $routes->get('pdf-uts-mtr/(:any)', 'Mbkm\PenilaianController::cetak_nilai_uts_mtr_pdf/$1');
    //excel
    $routes->get('cetak/(:any)', 'Mbkm\PenilaianController::cetak_penilaian_excel_uts/$1');
    $routes->get('grafik-uts', 'Mbkm\PenilaianController::grafik');

    // Tambah UAS Data dosen
    // $routes->get('mbkm/dosen/uas/(:any)', 'Mbkm\PenilaianController::penilaian_uas_dsn/$1');
    // $routes->post('simpan/dosen/uas/(:any)', 'Mbkm\PenilaianController::simpan_penilaian_uas_dsn/$');
    // // Tambah UAS Data mitra
    // $routes->get('mbkm/mitra/uas/(:any)', 'Mbkm\PenilaianController::penilaian_uas_mtr/$1');
    // $routes->post('simpan/mitra/uas/(:any)', 'Mbkm\PenilaianController::simpan_penilaian_uas_mtr/$');

});
// Data penilaian UAS
$routes->group('mbkm/penilaian/uas', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Mbkm\PenilaianController::index_uas');
    // Tambah UAS Data dosen
    $routes->get('mbkm/dosen/uas/(:any)', 'Mbkm\PenilaianController::penilaian_uas_dsn/$1');
    $routes->post('simpan/dosen/uas/(:any)', 'Mbkm\PenilaianController::simpan_penilaian_uas_dsn/$');
    // Tambah UAS Data mitra
    $routes->get('mbkm/mitra/uas/(:any)', 'Mbkm\PenilaianController::penilaian_uas_mtr/$1');
    $routes->post('simpan/mitra/uas/(:any)', 'Mbkm\PenilaianController::simpan_penilaian_uas_mtr/$');
    $routes->get('filter-adm-uas/(:any)', 'Mbkm\PenilaianController::getFilterDataNilaiUasAdm/$1');
    $routes->get('filter-dsn-uas/(:any)', 'Mbkm\PenilaianController::getFilterDataNilaiUasDsn/$1');
    $routes->get('cetak/(:any)', 'Mbkm\PenilaianController::cetak_penilaian_excel_uas/$1');
     // export
     $routes->get('pdf-uas-dsn/(:any)', 'Mbkm\PenilaianController::cetak_nilai_uas_dsn_pdf/$1');
     $routes->get('pdf-uas-mtr/(:any)', 'Mbkm\PenilaianController::cetak_nilai_uas_mtr_pdf/$1');
});
$routes->group('mbkm/penilaian/akhir', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Mbkm\PenilaianController::index_nilai_akhir');
    $routes->get('filter-adm/(:any)', 'Mbkm\PenilaianController::getFilterDataAllNilaiAdm/$1');
    $routes->get('filter-dsn/(:any)', 'Mbkm\PenilaianController::getAllNilaiFilterDsn/$1');
    $routes->get('cetak/(:any)', 'Mbkm\PenilaianController::cetak_penilaian_akhir_excel/$1');
     // export
     $routes->get('pdf/(:any)', 'Mbkm\PenilaianController::cetak_nilai_akhir_pdf/$1');
});

/*
 * --------------------------------------------------------------------
 *                      TRACER STUDY
 * --------------------------------------------------------------------
 */

// Dashboard TRACER
$routes->get('tracer', 'DashboardController::tracer', ['filter' => 'login']);

// Pengelolaan Data Agenda
$routes->group('tracer/agenda', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Tracer\AgendaController::index');
    // Tambah Data
    $routes->get('tambah', 'Tracer\AgendaController::tambah');
    $routes->post('simpan', 'Tracer\AgendaController::simpan');
    // Edit Data
    $routes->get('edit/(:any)', 'Tracer\AgendaController::edit/$1');
    $routes->post('update/(:any)', 'Tracer\AgendaController::update/$1');
    // Hapus Data
    $routes->delete('hapus/(:any)', 'Tracer\AgendaController::hapus/$1');
});

// Pengelolaan Data Tahun
$routes->group('tracer/tahun', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Tracer\TahunController::index');
    // Tambah Data
    $routes->get('tambah', 'Tracer\TahunController::tambah');
    $routes->post('simpan', 'Tracer\TahunController::simpan');
    // Edit Data
    $routes->get('edit/(:any)', 'Tracer\TahunController::edit/$1');
    $routes->post('update/(:any)', 'Tracer\TahunController::update/$1');
    // Hapus Data
    $routes->delete('hapus/(:any)', 'Tracer\TahunController::hapus/$1');
});

// Pengelolaan Data Tips Karir
$routes->group('tracer/tips_karir', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Tracer\TipsKarirController::index');
    // Tambah Data
    $routes->get('tambah', 'Tracer\TipsKarirController::tambah');
    $routes->post('simpan', 'Tracer\TipsKarirController::simpan');
    // Edit Data
    $routes->get('edit/(:any)', 'Tracer\TipsKarirController::edit/$1');
    $routes->post('update/(:any)', 'Tracer\TipsKarirController::update/$1');
    // Hapus Data
    $routes->delete('hapus/(:any)', 'Tracer\TipsKarirController::hapus/$1');
});

// Pengelolaan Data Alumni Berprestasi
$routes->group('tracer/alumni_berprestasi', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Tracer\AlumniBerprestasiController::index');
    // Tambah Data
    $routes->get('tambah', 'Tracer\AlumniBerprestasiController::tambah');
    $routes->post('simpan', 'Tracer\AlumniBerprestasiController::simpan');
    // Edit Data
    $routes->get('edit/(:any)', 'Tracer\AlumniBerprestasiController::edit/$1');
    $routes->post('update/(:any)', 'Tracer\AlumniBerprestasiController::update/$1');
    // Hapus Data
    $routes->delete('hapus/(:any)', 'Tracer\AlumniBerprestasiController::hapus/$1');
});

// Pengelolaan Data Lowongan Kerja
$routes->group('tracer/lowongan_kerja', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Tracer\LowonganKerjaController::index');
    // Tambah Data
    $routes->get('tambah', 'Tracer\LowonganKerjaController::tambah');
    $routes->post('simpan', 'Tracer\LowonganKerjaController::simpan');
    // Edit Data
    $routes->get('edit/(:any)', 'Tracer\LowonganKerjaController::edit/$1');
    $routes->post('update/(:any)', 'Tracer\LowonganKerjaController::update/$1');
    // Hapus Data
    $routes->delete('hapus/(:any)', 'Tracer\LowonganKerjaController::hapus/$1');
});

// Pengelolaan Data Informasi Magang
$routes->group('tracer/informasi_magang', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Tracer\InformasiMagangController::index');
    // Tambah Data
    $routes->get('tambah', 'Tracer\InformasiMagangController::tambah');
    $routes->post('simpan', 'Tracer\InformasiMagangController::simpan');
    // Edit Data
    $routes->get('edit/(:any)', 'Tracer\InformasiMagangController::edit/$1');
    $routes->post('update/(:any)', 'Tracer\InformasiMagangController::update/$1');
    // Hapus Data
    $routes->delete('hapus/(:any)', 'Tracer\InformasiMagangController::hapus/$1');
});

// Pengelolaan Data Jenis Kuesioner
$routes->group('tracer/jenis_kuesioner', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Tracer\JenisKuesionerController::index');
    // Tambah Data
    $routes->get('tambah', 'Tracer\JenisKuesionerController::tambah');
    $routes->post('simpan', 'Tracer\JenisKuesionerController::simpan');
    // Edit Data
    $routes->get('edit/(:any)', 'Tracer\JenisKuesionerController::edit/$1');
    $routes->post('update/(:any)', 'Tracer\JenisKuesionerController::update/$1');
    // Hapus Data
    $routes->delete('hapus/(:any)', 'Tracer\JenisKuesionerController::hapus/$1');
});

// Pengelolaan Data Pertanyaan Kuesioner
$routes->group('tracer/pertanyaan_kuesioner', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Tracer\PertanyaanKuesionerController::index');
    // Tambah Data
    $routes->get('tambah', 'Tracer\PertanyaanKuesionerController::tambah');
    $routes->post('simpan', 'Tracer\PertanyaanKuesionerController::simpan');
    // Edit Data
    $routes->get('edit/(:any)', 'Tracer\PertanyaanKuesionerController::edit/$1');
    $routes->post('update/(:any)', 'Tracer\PertanyaanKuesionerController::update/$1');
    // Hapus Data
    $routes->delete('hapus/(:any)', 'Tracer\PertanyaanKuesionerController::hapus/$1');
});

// Pengelolaan Data Pertanyaan Kuesioner isian
$routes->group('tracer/pertanyaan_isian', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Tracer\PertanyaanIsianController::index');
    // Tambah Data
    $routes->get('tambah', 'Tracer\PertanyaanIsianController::tambah');
    $routes->post('simpan', 'Tracer\PertanyaanIsianController::simpan');
    // Edit Data
    $routes->get('edit/(:any)', 'Tracer\PertanyaanIsianController::edit/$1');
    $routes->post('update/(:any)', 'Tracer\PertanyaanIsianController::update/$1');
    // Hapus Data
    $routes->delete('hapus/(:any)', 'Tracer\PertanyaanIsianController::hapus/$1');
});

// Pengelolaan Data Jadwal Kuesioner
$routes->group('tracer/jadwal_kuesioner', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Tracer\JadwalKuesionerController::index');
    // Tambah Data
    $routes->get('tambah', 'Tracer\JadwalKuesionerController::tambah');
    $routes->post('simpan', 'Tracer\JadwalKuesionerController::simpan');
    // Edit Data
    $routes->get('edit/(:any)', 'Tracer\JadwalKuesionerController::edit/$1');
    $routes->post('update/(:any)', 'Tracer\JadwalKuesionerController::update/$1');
    // Hasil Data
    $routes->get('hasil/(:any)', 'Tracer\JadwalKuesionerController::hasil/$1');
    // Hapus Data
    $routes->delete('hapus/(:any)', 'Tracer\JadwalKuesionerController::hapus/$1');
});
// Pengelolaan Data FAQ
$routes->group('tracer/faq', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Tracer\FaqController::index');
    // Tambah Data
    $routes->get('tambah', 'Tracer\FaqController::tambah');
    $routes->post('simpan', 'Tracer\FaqController::simpan');
    // Edit Data
    $routes->get('edit/(:any)', 'Tracer\FaqController::edit/$1');
    $routes->post('update/(:any)', 'Tracer\FaqController::update/$1');
    // Hapus Data
    $routes->delete('hapus/(:any)', 'Tracer\FaqController::hapus/$1');
});

// Pengelolaan Data Cms
$routes->group('tracer/cms', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Tracer\CmsController::index');
    // Tambah Data
    $routes->get('tambah', 'Tracer\CmsController::tambah');
    $routes->post('simpan', 'Tracer\CmsController::simpan');
    // Edit Data
    $routes->get('edit/(:any)', 'Tracer\CmsController::edit/$1');
    $routes->post('update/(:any)', 'Tracer\CmsController::update/$1');
    // Hapus Data
    $routes->delete('hapus/(:any)', 'Tracer\CmsController::hapus/$1');
});

// Pengelolaan Isi Kuesioner
$routes->group('tracer/isi_kuesioner', ['filter' => 'login'], static function ($routes) {
    // Tampil Data
    $routes->get('', 'Tracer\IsiKuesionerController::index');
    // Tambah Data
    $routes->get('mengisi/(:any)', 'Tracer\IsiKuesionerController::mengisi/$1');
    $routes->post('simpan', 'Tracer\IsiKuesionerController::simpan');
    $routes->get('bukti', 'Tracer\IsiKuesionerController::BuktiMengisiKuesioner');
    // Edit Data
    $routes->get('edit/(:any)', 'Tracer\CmsController::edit/$1');
    $routes->post('update', 'Tracer\IsiKuesionerController::update');
    // Hapus Data
    $routes->delete('hapus/(:any)', 'Tracer\CmsController::hapus/$1');
});

/*
 * --------------------------------------------------------------------
 *                        SIM TA
 * --------------------------------------------------------------------
 */

// Dashboard
$routes->get('simta', 'DashboardController::simta', ['filter' => 'login']);
// download pdf
$routes->get('download_berkas/(:any)', 'DashboardController::download_berkas_simta/$1');
$routes->group('simta/berkas', ['filter' => 'login'], static function ($routes) {
    $routes->get('/', 'Simta\BerkasController::index');
    $routes->get('tambah', 'Simta\BerkasController::tambah');
    $routes->post('simpan', 'Simta\BerkasController::simpan');
    $routes->get('edit/(:any)', 'Simta\BerkasController::edit/$1');
    $routes->post('update/(:any)', 'Simta\BerkasController::update/$1');
    $routes->delete('hapus/(:any)', 'Simta\BerkasController::hapus/$1');
    $routes->get('download_berkas(:any)', 'Simta\BerkasController::download_berkas$1');
});
$routes->group('simta/taterdahulu', ['filter' => 'login'], static function ($routes) {
    $routes->get('/', 'Simta\TaTerdahuluController::index');
    $routes->get('tambah', 'Simta\TaTerdahuluController::create');
    $routes->post('simpan', 'Simta\TaTerdahuluController::simpan');
    $routes->get('edit/(:any)', 'Simta\TaTerdahuluController::edit/$1');
    $routes->post('update/(:any)', 'Simta\TaTerdahuluController::update/$1');
    $routes->delete('hapus/(:any)', 'Simta\TaTerdahuluController::delete/$1');
    $routes->get('download_dokumen_ta/(:any)', 'Simta\TaTerdahuluController::download_dokumen_ta/$1');
});

$routes->group('simta/pengajuanjudul', ['filter' => 'login'], static function ($routes) {
    $routes->get('/', 'Simta\PengajuanJudulController::index');
    $routes->get('tambah', 'Simta\PengajuanJudulController::tambah');
    $routes->post('store', 'Simta\PengajuanJudulController::store');
    $routes->get('edit/(:any)', 'Simta\PengajuanJudulController::edit/$1');
    $routes->post('update/(:any)', 'Simta\PengajuanJudulController::update/$1');
    $routes->get('editstatus/(:any)', 'Simta\PengajuanJudulController::editstatus/$1');
    $routes->post('updatestatus/(:any)', 'Simta\PengajuanJudulController::updatestatus/$1');
    $routes->get('editpembimbing/(:any)', 'Simta\PengajuanJudulController::editpembimbing/$1');
    $routes->post('updatepembimbing/(:any)', 'Simta\PengajuanJudulController::updatepembimbing/$1');
    $routes->delete('delete/(:any)', 'Simta\PengajuanJudulController::delete/$1');
    $routes->get('detail/(:any)', 'Simta\PengajuanJudulController::detail/$1');
    $routes->get('tambahrekomendasi/(:any)', 'Simta\PengajuanJudulController::tambahrekomendasi/$1');
    $routes->post('storerekomendasi/(:any)', 'Simta\PengajuanJudulController::storerekomendasi/$1');
    $routes->get('editrekomendasi/(:any)', 'Simta\PengajuanJudulController::editrekomendasi/$1');
    $routes->post('updaterekomendasi/(:any)', 'Simta\PengajuanJudulController::updaterekomendasi/$1');
    $routes->delete('deleterekomendasi/(:any)', 'Simta\PengajuanJudulController::deleterekomendasi/$1');
});

$routes->group('simta/ujianproposal', ['filter' => 'login'], static function ($routes) {
    $routes->get('/', 'Simta\UjianProposalController::index');
    $routes->get('tambah/(:any)', 'Simta\UjianProposalController::tambah/$1');
    $routes->post('store/(:any)', 'Simta\UjianProposalController::store/$1');
    $routes->post('simpanmahasiswa', 'Simta\UjianProposalController::simpanmahasiswa');
    $routes->get('edit/(:any)', 'Simta\UjianProposalController::edit/$1');
    $routes->post('update/(:any)', 'Simta\UjianProposalController::update/$1');
    $routes->get('editstatus/(:any)', 'Simta\UjianProposalController::editstatus/$1');
    $routes->post('updatestatus/(:any)', 'Simta\UjianProposalController::updatestatus/$1');
    $routes->get('edithasil/(:any)', 'Simta\UjianProposalController::edithasil/$1');
    $routes->post('updatehasil/(:any)', 'Simta\UjianProposalController::updatehasil/$1');
    $routes->get('revisi/(:any)', 'Simta\UjianProposalController::revisi/$1');
    $routes->post('updaterevisi/(:any)', 'Simta\UjianProposalController::updaterevisi/$1');
    $routes->delete('delete/(:any)', 'Simta\UjianProposalController::delete/$1');
    $routes->get('download_proposalawal/(:any)', 'Simta\UjianProposalController::download_proposalawal/$1');
    $routes->get('download_transkripnilai/(:any)', 'Simta\UjianProposalController::download_transkripnilai/$1');
    $routes->get('download_revisi_proposal/(:any)', 'Simta\UjianProposalController::download_revisi_proposal/$1');
    $routes->get('detail/(:any)', 'Simta\UjianProposalController::detail/$1');
    $routes->get('tambahpengujiujianproposal/(:any)', 'Simta\UjianProposalController::tambahpengujiujianproposal/$1');
    $routes->post('storepengujiujianproposal/(:any)', 'Simta\UjianProposalController::storepengujiujianproposal/$1');
    $routes->get('editpengujiujianproposal/(:any)', 'Simta\UjianProposalController::editpengujiujianproposal/$1');
    $routes->post('updatepengujiujianproposal/(:any)', 'Simta\UjianProposalController::updatepengujiujianproposal/$1');
    $routes->delete('deletepengujiujianproposal/(:any)', 'Simta\UjianProposalController::deletepengujiujianproposal/$1');
});

$routes->group('simta/seminarhasil', ['filter' => 'login'], static function ($routes) {
    $routes->get('/', 'Simta\SeminarHasilController::index');
    $routes->get('tambah/(:any)', 'Simta\SeminarHasilController::tambah/$1');
    $routes->post('store/(:any)', 'Simta\SeminarHasilController::store/$1');
    $routes->post('simpanmahasiswa', 'Simta\SeminarHasilController::simpanmahasiswa');
    $routes->get('edit/(:any)', 'Simta\SeminarHasilController::edit/$1');
    $routes->post('update/(:any)', 'Simta\SeminarHasilController::update/$1');
    $routes->get('editstatus/(:any)', 'Simta\SeminarHasilController::editstatus/$1');
    $routes->post('updatestatus/(:any)', 'Simta\SeminarHasilController::updatestatus/$1');
    $routes->delete('delete/(:any)', 'Simta\SeminarHasilController::delete/$1');
    $routes->get('download_proposal_seminarhasil/(:any)', 'Simta\SeminarHasilController::download_proposal_seminarhasil/$1');
    $routes->get('download_persetujuan_dosen/(:any)', 'Simta\SeminarHasilController::download_persetujuan_dosen/$1');
    $routes->get('download_berita_acara/(:any)', 'Simta\SeminarHasilController::download_berita_acara/$1');
    $routes->get('download_revisi_proposal/(:any)', 'Simta\SeminarHasilController::download_revisi_proposal/$1');
    $routes->get('detail/(:any)', 'Simta\SeminarHasilController::detail/$1');
    $routes->get('revisi/(:any)', 'Simta\SeminarHasilController::revisi/$1');
    $routes->post('updaterevisi/(:any)', 'Simta\SeminarHasilController::updaterevisi/$1');
});

$routes->group('simta/ujianta', ['filter' => 'login'], static function ($routes) {
    $routes->get('/', 'Simta\UjianTAController::index');
    $routes->get('tambah/(:any)', 'Simta\UjianTAController::tambah/$1');
    $routes->post('store/(:any)', 'Simta\UjianTAController::store/$1');
    $routes->get('edit/(:any)', 'Simta\UjianTAController::edit/$1');
    $routes->post('update/(:any)', 'Simta\UjianTAController::update/$1');
    $routes->get('editstatus/(:any)', 'Simta\UjianTAController::editstatus/$1');
    $routes->post('updatestatus/(:any)', 'Simta\UjianTAController::updatestatus/$1');
    $routes->get('edithasil/(:any)', 'Simta\UjianTAController::edithasil/$1');
    $routes->post('updatehasil/(:any)', 'Simta\UjianTAController::updatehasil/$1');
    $routes->get('editpenguji/(:any)', 'Simta\UjianTAController::editpenguji/$1');
    $routes->get('revisi/(:any)', 'Simta\UjianTAController::revisi/$1');
    $routes->post('updaterevisi/(:any)', 'Simta\UjianTAController::updaterevisi/$1');
    $routes->delete('delete/(:any)', 'Simta\UjianTAController::delete/$1');
    $routes->get('download_proposalakhir/(:any)', 'Simta\UjianTAController::download_proposalakhir/$1');
    $routes->get('download_berita_acarakmm/(:any)', 'Simta\UjianTAController::download_berita_acarakmm/$1');
    $routes->get('download_krs/(:any)', 'Simta\UjianTAController::download_krs/$1');
    $routes->get('download_transkrip_nilai/(:any)', 'Simta\UjianTAController::download_transkrip_nilai/$1');
    $routes->get('download_rekomendasi_dospem/(:any)', 'Simta\UjianTAController::download_rekomendasi_dospem/$1');
    $routes->get('download_revisi_proposal/(:any)', 'Simta\UjianTAController::download_revisi_proposal/$1');
    $routes->get('detail/(:any)', 'Simta\UjianTAController::detail/$1');
    $routes->get('penilaian/(:any)', 'Simta\UjianTAController::penilaian/$1');
    $routes->get('tambahpengujiujianta/(:any)', 'Simta\UjianTAController::tambahpengujiujianta/$1');
    $routes->post('storepengujiujianta/(:any)', 'Simta\UjianTAController::storepengujiujianta/$1');
    $routes->get('editpengujiujianta/(:any)', 'Simta\UjianTAController::editpengujiujianta/$1');
    $routes->post('updatepengujiujianta/(:any)', 'Simta\UjianTAController::updatepengujiujianta/$1');
    $routes->delete('deletepengujiujianta/(:any)', 'Simta\UjianTAController::deletepengujiujianta/$1');
});

$routes->group('simta/bobotpenilaian', ['filter' => 'login'], static function ($routes) {
    $routes->get('/', 'Simta\BobotPenilaianController::index');
    $routes->get('tambah', 'Simta\BobotPenilaianController::tambah');
    $routes->post('simpan', 'Simta\BobotPenilaianController::simpan');
    $routes->get('edit/(:any)', 'Simta\BobotPenilaianController::edit/$1');
    $routes->post('update/(:any)', 'Simta\BobotPenilaianController::update/$1');
    $routes->delete('delete/(:any)', 'Simta\BobotPenilaianController::delete/$1');
});

$routes->group('simta/penilaianakhir', ['filter' => 'login'], static function ($routes) {
    $routes->get('/', 'Simta\PenilaianAkhirController::index');
    $routes->get('tambah/(:any)', 'Simta\PenilaianAkhirController::tambah/$1');
    $routes->post('store/(:any)', 'Simta\PenilaianAkhirController::store/$1');
    $routes->get('editsemhas/(:any)', 'Simta\PenilaianAkhirController::editsemhas/$1');
    $routes->post('updatesemhas/(:any)', 'Simta\PenilaianAkhirController::updatesemhas/$1');
    $routes->get('editsidang/(:any)', 'Simta\PenilaianAkhirController::editsidang/$1');
    $routes->post('updatesidang/(:any)', 'Simta\PenilaianAkhirController::updatesidang/$1');
    $routes->get('hasilakhir(:any)', 'Simta\PenilaianAkhirController::hasilakhir/$1');
    $routes->post('total/(:any)', 'Simta\PenilaianAkhirController::total/$1');
    $routes->delete('delete/(:any)', 'Simta\PenilaianAkhirController::delete/$1');
    $routes->get('cetak_penilaian/(:any)', 'Simta\PenilaianAkhirController::cetak_penilaian/$1');
});

$routes->group('simta/pengajuanbimbingan', ['filter' => 'login'], static function ($routes) {
    $routes->get('/', 'Simta\PengajuanBimbinganController::index');
    $routes->get('tambah/(:any)', 'Simta\PengajuanBimbinganController::tambah/$1');
    $routes->post('store/(:any)', 'Simta\PengajuanBimbinganController::store/$1');
    $routes->get('edit/(:any)', 'Simta\PengajuanBimbinganController::edit/$1');
    $routes->post('update/(:any)', 'Simta\PengajuanBimbinganController::update/$1');
    $routes->get('verifikasi/(:any)', 'Simta\PengajuanBimbinganController::verifikasi/$1');
    $routes->post('updateverifikasi/(:any)', 'Simta\PengajuanBimbinganController::updateverifikasi/$1');
    $routes->get('detail/(:any)', 'Simta\PengajuanBimbinganController::detail/$1');
});

$routes->group('simta/timeline', ['filter' => 'login'], static function ($routes) {
    $routes->get('/', 'Simta\TimelineController::index');
    $routes->get('tambah', 'Simta\TimelineController::create');
    $routes->post('simpan', 'Simta\TimelineController::simpan');
    $routes->get('edit/(:any)', 'Simta\TimelineController::edit/$1');
    $routes->post('update/(:any)', 'Simta\TimelineController::update/$1');
    $routes->delete('hapus/(:any)', 'Simta\TimelineController::delete/$1');
    $routes->get('download_dokumen_ta/(:any)', 'Simta\TimelineController::download_dokumen_ta/$1');
});

$routes->post('uploadproposalwal', 'Simta\FileController::uploadproposalwal');
$routes->post('uploadtranskripnilai', 'Simta\FileController::uploadtranskripnilai');
$routes->post('revisiproposalwal', 'Simta\FileController::revisiproposalwal');
$routes->post('uploadproposalsemhas', 'Simta\FileController::uploadproposalsemhas');
$routes->post('uploadberitaacara', 'Simta\FileController::uploadberitaacara');
$routes->post('uploadpersetujuandosen', 'Simta\FileController::uploadpersetujuandosen');
$routes->post('revisiproposalsemhas', 'Simta\FileController::revisiproposalsemhas');
$routes->post('uploadproposalakhir', 'Simta\FileController::uploadproposalakhir');
$routes->post('uploadberitaacarakmm', 'Simta\FileController::uploadberitaacarakmm');
$routes->post('uploadkrs', 'Simta\FileController::uploadkrs');
$routes->post('uploadtranskripnilaita', 'Simta\FileController::uploadtranskripnilaita');
$routes->post('uploadrekomendasidosen', 'Simta\FileController::uploadrekomendasidosen');
$routes->post('revisiproposalakhir', 'Simta\FileController::revisiproposalakhir');
$routes->post('laporanlengkap', 'Simta\FileController::laporanlengkap');
$routes->post('halamanpengesahan', 'Simta\FileController::halamanpengesahan');
$routes->post('halamanpersetujuan', 'Simta\FileController::halamanpersetujuan');
$routes->post('manualbook', 'Simta\FileController::manualbook');
$routes->post('ktp', 'Simta\FileController::ktp');
$routes->get('download/(:any)', 'Simta\FileController::download/$1');

/*
 * --------------------------------------------------------------------
 *                        BOT
 * --------------------------------------------------------------------
 */
// Dashboard Chatbot
$routes->get('bot', 'DashboardController::bot', ['filter' => 'login']);

$routes->group('bot/kelola_bot', ['filter' => 'login'], static function ($routes) {
    $routes->get('', 'Bot\ChatbotResponseController::index', ['filter' => 'role:admin']);
    $routes->get('tambah', 'Bot\ChatbotResponseController::tambah', ['filter' => 'role:admin']);
    $routes->post('simpan', 'Bot\ChatbotResponseController::simpan', ['filter' => 'role:admin']);
    $routes->post('insert_tag', 'Bot\ChatbotResponseController::insert_tag', ['filter' => 'role:admin']);
    $routes->post('edit/tambah_tag/(:any)', 'Bot\ChatbotResponseController::tambah_tag/$1', ['filter' => 'role:admin']);
    $routes->get('', 'Bot\BlastChatController::index', ['filter' => 'role:admin']);
    $routes->delete('hapus/(:any)', 'Bot\ChatbotResponseController::hapus/$1', ['filter' => 'role:admin']);
    $routes->delete('edit/hapus_tag/(:any)', 'Bot\ChatbotResponseController::hapus_tag/$1', ['filter' => 'role:admin']);
    // edit
    $routes->get('edit/(:any)', 'Bot\ChatbotResponseController::edit/$1', ['filter' => 'role:admin']);
    $routes->post('update/(:any)', 'Bot\ChatbotResponseController::update_message/$1', ['filter' => 'role:admin']);
    $routes->post('edit/update_tag/(:any)', 'Bot\ChatbotResponseController::update_tag/$1', ['filter' => 'role:admin']);
    $routes->post('edit/tambah_lampiran/(:any)', 'Bot\ChatbotResponseController::add_dokumen_lampiran/$1', ['filter' => 'role:admin']);
    $routes->post('edit/hapus_lampiran/(:any)', 'Bot\ChatbotResponseController::hapus_dokumen_lampiran/$1', ['filter' => 'role:admin']);
    $routes->get('download-lampiran/(:any)', 'Bot\ChatbotResponseController::download_dokumen_lampiran/$1', ['filter' => 'role:admin']);
    //user
    $routes->get('user/mahasiswa', 'Bot\ChatbotUserController::user_mahasiswa', ['filter' => 'role:admin']);
    $routes->get('user/mahasiswa/edit/(:any)', 'Bot\ChatbotUserController::user_mahasiswa_edit/$1', ['filter' => 'role:admin']);
    $routes->delete('user/mahasiswa/hapus-mahasiswa/(:any)', 'Bot\ChatbotUserController::hapus_user_mahasiswa/$1', ['filter' => 'role:admin']);
    $routes->post('user/mahasiswa/simpan-edit/(:any)', 'Bot\ChatbotUserController::user_mahasiswa_edit_simpan/$1', ['filter' => 'role:admin']);
    $routes->get('user/staf', 'Bot\ChatbotUserController::user_staf', ['filter' => 'role:admin']);
    $routes->get('user/staf/edit/(:any)', 'Bot\ChatbotUserController::user_staf_edit/$1', ['filter' => 'role:admin']);
    $routes->delete('user/staf/hapus-staf/(:any)', 'Bot\ChatbotUserController::hapus_user_staf/$1', ['filter' => 'role:admin']);
    $routes->post('user/staf/simpan-edit/(:any)', 'Bot\ChatbotUserController::user_staf_edit_simpan/$1', ['filter' => 'role:admin']);
});
$routes->group('bot/blast_chat', ['filter' => 'login'], static function ($routes) {
    $routes->get('', 'Bot\BlastChatController::index', ['filter' => 'role:admin']);
    $routes->get('terjadwal', 'Bot\BlastChatController::terjadwal', ['filter' => 'role:admin']);
    $routes->post('terjadwal/kirim', 'Bot\BlastChatController::kirim_terjadwal', ['filter' => 'role:admin']);
    $routes->get('terjadwal/pilih_penerima/(:any)', 'Bot\BlastChatController::terjadwal/$1', ['filter' => 'role:admin']);
    $routes->get('terjadwal/pilih_penerima', 'Bot\BlastChatController::pilih_penerima_terjadwal', ['filter' => 'role:admin']);
    $routes->get('terjadwal/mahasiswa', 'Bot\BlastChatController::terjadwal_mahasiswa', ['filter' => 'role:admin']);
    $routes->get('terjadwal/staff', 'Bot\BlastChatController::terjadwal_staff', ['filter' => 'role:admin']);
    $routes->get('kirim_email', 'Bot\BlastChatController::email', ['filter' => 'role:admin']);
    $routes->post('kirim_email/kirim', 'Bot\BlastChatController::kirim_email', ['filter' => 'role:admin']);
    $routes->post('kirim_email/kirim_excel', 'Bot\BlastChatController::kirimEmailFromExcel', ['filter' => 'role:admin']);
    $routes->get('instan/pilih_penerima/(:any)', 'Bot\BlastChatController::instan/$1', ['filter' => 'role:admin']);
    $routes->post('instan/kirim', 'Bot\BlastChatController::kirim_instan', ['filter' => 'role:admin']);
    $routes->get('instan/pilih_penerima', 'Bot\BlastChatController::pilih_penerima_instan', ['filter' => 'role:admin']);
    $routes->get('instan/mahasiswa', 'Bot\BlastChatController::instan_mahasiswa', ['filter' => 'role:admin']);
    $routes->get('instan/staff', 'Bot\BlastChatController::instan_staff', ['filter' => 'role:admin']);
    $routes->get('broadcast', 'Bot\BlastChatController::broadcast', ['filter' => 'role:admin']);
    $routes->get('broadcast_semua', 'Bot\BlastChatController::broadcast_semua', ['filter' => 'role:admin']);
    $routes->get('broadcast_spesifik', 'Bot\BlastChatController::broadcast_spesifik', ['filter' => 'role:admin']);
    $routes->get('download-format-blast-email', 'Bot\BlastChatController::download_format_blast_email', ['filter' => 'role:admin']);
    $routes->post('broadcast/kirim', 'Bot\BlastChatController::kirim_broadcast', ['filter' => 'role:admin']);
    $routes->post('broadcast_spesifik/kirim', 'Bot\BlastChatController::kirim_broadcast_spesifik', ['filter' => 'role:admin']);
});

$routes->group('bot/register_app', ['filter' => 'login'], static function ($routes) {
    $routes->get('', 'Bot\RegisterAppChatbotController::index', ['filter' => 'role:admin']);
    $routes->get('tambah', 'Bot\RegisterAppChatbotController::tambah', ['filter' => 'role:admin']);
    $routes->delete('hapus/(:any)', 'Bot\RegisterAppChatbotController::hapus/$1', ['filter' => 'role:admin']);
    $routes->post('tambah/submit', 'Bot\RegisterAppChatbotController::submit', ['filter' => 'role:admin']);
});

$routes->group('bot/log', ['filter' => 'login'], static function ($routes) {
    $routes->get('notifikasi', 'Bot\ChatbotLogNotificationController::log', ['filter' => 'role:admin']);
    $routes->get('notifikasi_kegiatan', 'Bot\ChatbotLogNotificationController::log_kegiatan', ['filter' => 'role:admin']);
});

$routes->group('bot', ['filter' => 'login'], static function ($routes) {
    $routes->get('register_chatbot', 'Bot\ChatbotController::register');
    $routes->get('akses_chatbot', 'Bot\ChatbotController::akses_chatbot');
    $routes->post('akses_chatbot/update-nomor-wa/(:any)', 'Bot\ChatbotController::update_nomor_wa/$1');
    $routes->post('akses_chatbot/ubah-status-notifikasi/(:any)', 'Bot\ChatbotController::status_notifikasi/$1');
    $routes->get('register_chatbot/aktivasi', 'Bot\ChatbotController::aktivasi');
    $routes->post('register_chatbot/submit', 'Bot\ChatbotController::submit_register');
});

/*
 * --------------------------------------------------------------------
 *                        TIMELINE REMINDER (AGENDA)
 * --------------------------------------------------------------------
 */
$routes->group('timelinereminder/agenda', ['filter' => 'login'], static function ($routes) {
    $routes->get('', 'TimelineReminder\KegiatanController::index', ['filter' => 'role:admin, dosen']);
    $routes->get('detail/(:any)', 'TimelineReminder\KegiatanController::detail/$1', ['filter' => 'role:admin, dosen']);
    $routes->get('notifikasi/(:any)', 'TimelineReminder\KegiatanController::notifikasi/$1', ['filter' => 'role:admin, dosen']);
    $routes->get('notifikasi_edit/(:any)/(:any)', 'TimelineReminder\KegiatanController::notifikasi_edit/$1/$2', ['filter' => 'role:admin, dosen']);
    $routes->post('simpan_notifikasi_edit/(:any)/(:any)', 'TimelineReminder\KegiatanController::simpan_notifikasi_edit/$1/$2', ['filter' => 'role:admin, dosen']);
    $routes->post('kirim_notifikasi/(:any)', 'TimelineReminder\KegiatanController::kirim_notifikasi/$1', ['filter' => 'role:admin, dosen']);
    $routes->get('tambah', 'TimelineReminder\KegiatanController::tambah', ['filter' => 'role:admin, dosen']);
    $routes->get('edit-kegiatan/(:any)', 'TimelineReminder\KegiatanController::edit_kegiatan/$1', ['filter' => 'role:admin, dosen']);
    $routes->post('simpan-edit-kegiatan/(:any)', 'TimelineReminder\KegiatanController::simpan_edit_kegiatan/$1', ['filter' => 'role:admin, dosen']);
    $routes->post('tambah/simpan', 'TimelineReminder\KegiatanController::simpan', ['filter' => 'role:admin, dosen']);
    $routes->get('tambah-dokumen/(:any)', 'TimelineReminder\KegiatanController::tambah_dokumen/$1', ['filter' => 'role:admin, dosen']);
    $routes->post('simpan-dokumen/(:any)', 'TimelineReminder\KegiatanController::add_dokumen/$1', ['filter' => 'role:admin, dosen']);
    $routes->get('download-dokumen/(:any)', 'TimelineReminder\KegiatanController::download_dokumen/$1', ['filter' => 'role:admin, dosen']);
    $routes->get('auto-reminder/(:any)/(:any)/(:any)/(:any)/(:any)', 'TimelineReminder\KegiatanController::autoReminder/$1/$2/$3/$4/$5', ['filter' => 'role:admin, dosen']);
    $routes->delete('hapus-kegiatan/(:any)', 'TimelineReminder\KegiatanController::hapus_kegiatan/$1', ['filter' => 'role:admin, dosen']);
    $routes->delete('hapus-dokumen/(:any)/(:any)', 'TimelineReminder\KegiatanController::hapus_dokumen/$1/$2', ['filter' => 'role:admin, dosen']);
    //$routes->post('detail/tambah-dokumen/(:any)', 'TimelineReminder\KegiatanController::add_dokumen/$1');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}