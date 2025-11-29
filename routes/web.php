<?php

use Illuminate\Support\Facades\Route;
// Mengimpor facade Route untuk mendefinisikan rute web
use Illuminate\Support\Facades\DB;
// (Opsional) Untuk query langsung ke database
use Carbon\Carbon;
// (Opsional) Untuk manipulasi tanggal
// Mengimpor controller yang akan digunakan pada rute-rute berikut
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;

// Route::get('/', function(){
//     return view('');
// });


//===========
// LOGIN ROUTES
//===========

Route::middleware('guest')->group (function () {
    // Grup route hanya untuk pengguna yang belum login (guest)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    // Tampilkan halaman login (GET)
    Route::post('/login', [AuthController::class, 'login']);
    // Proses login pengguna (POST)
});

//LOGOUT ROUTE
//===========

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Logout hanya bisa dilakukan oleh pengguna yang sudah login (middleware 'auth')
// DASHBOARD (HOME)
//=========

Route::middleware (['auth', 'role:admin,kasir'])->group (function () {
// Grup rute hanya bisa diakses oleh user dengan role 'admin'

Route::get('/home', function () {
    return view('home.home');
})->middleware('auth')->name('home');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/home', [HomeController::class, 'index'])->name('home.home');


});
//=================
// ADMIN ONLY ROUTES
//=============

Route::middleware (['auth', 'role:admin'])->group (function () {
// Grup rute hanya bisa diakses oleh user dengan role 'admin'

Route::resource('user', UserController::class);
// Route resource CRUD untuk produk

Route::resource('produk', ProdukController::class);
// Route resource CRUD untuk produk

Route::resource('pelanggan', PelangganController::class);
// Route resource CRUD untuk Pelanggan

});
// 
// ===========
// ADMIN & KASIR ROUTES
// ===========

Route::middleware (['auth', 'role:admin,kasir'])->group (function () {
// Grup rute yang dapat diakses oleh user dengan role 'admin' atau 'kasir'

Route::get('/pelanggan/create', [PelangganController::class, 'create'])->name('pelanggan.create');
Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::get('/transaksi/struk/{id}', [TransaksiController::class, 'printStruk'])->name('transaksi.printStruk');
Route::get('/transaksi', fn() => redirect()->route('transaksi.create'));
Route::get('/user', [UserController::class, 'index'])->name('user.index');
});


// Tampilkan halaman cetak struk berdasarkan ID transaksi

Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
// Tampilkan halaman laporan transaksi

Route::delete('/laporan-penjualan/{id}', [LaporanController::class, 'destroy'])->name('laporan-penjualan.destroy');
// Menambahkan fitur delete di laporan

Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/user', [UserController::class, 'index'])->name('user.index');
// Tampilkan daftar pelanggan (akses oleh admin dan kasir)

Route::get('/user', [UserController::class, 'index'])->middleware('auth')->name('user.index');
// menampilkan pengguna kasir

// Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::middleware(['role:admin'])->group(function () {
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    });
Route::get('/laporan/terlaris', [LaporanController::class, 'terlaris'])->name('laporan.terlaris');
Route::get('/laporan/terlaris', [LaporanController::class, 'tampilMenuTerlaris']);
Route::get('/api/menu-terlaris', [LaporanController::class, 'apiMenuTerlaris']);
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
Route::get('/laporan/terlaris', [LaporanController::class, 'redirectToHomeTerlaris'])->name('laporan.terlaris');



Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
// Route::get('/laporan/print/{id}', [LaporanController::class, 'printStruk'])->name('laporan.print');
// Route::delete('/laporan/delete/{id}', [LaporanController::class, 'destroy'])->name('laporan.delete');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

// Route::get('/transaksi/{id}/struk', [TransaksiController::class, 'printStruk'])->name('transaksi.struk');
// Route::get('/transaksi/{id}/cetak-pdf', [TransaksiController::class, 'cetakPdf'])->name('transaksi.cetakPdf');
// Route::get('/transaksi/{id}/print-struk', [TransaksiController::class, 'printStruk'])->name('transaksi.printStruk');
Route::get('transaksi/{id}/print-struk', [TransaksiController::class, 'printStruk'])->name('transaksi.printStruk');
Route::get('transaksi/{id}/cetak-pdf', [TransaksiController::class, 'cetakPdf'])->name('transaksi.cetakPdf');



