<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\DashboardController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/laporan', [LaporanController::class, 'stok'])->name('laporan.stok');
});
    Route::resource('/barang', BarangController::class);


Route::get('/laporan', [LaporanController::class, 'laporan'])->name('laporan.stok');
// Route::get('/user/{role}', [UserController::class, 'indexByRole'])->name('user.role');
Route::get('/barang/search', [BarangController::class, 'search'])->name('barang.search');
Route::get('/barang/{id}', [BarangController::class, 'show'])->name('barang.show');
Route::get('/barang/{id}/print', [BarangController::class, 'print'])->name('barang.print');
Route::get('/barang/{id}/printbc', [BarangController::class, 'printbc'])->name('barang.printbc');

// Login & Logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// barang masuk & keluar
Route::resource('/barang_masuk', BarangMasukController::class);
Route::resource('/barang_keluar', BarangKeluarController::class);


Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

Route::get('/about', function () {
    return view('about');
});
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/masuk', [LaporanController::class, 'masuk'])->name('laporan.masuk');
Route::get('/laporan/keluar', [LaporanController::class, 'keluar'])->name('laporan.keluar');

// Default route
Route::get('/', function () {
    return view('welcome');
});

Route::get('/barangkeluar', [BarangKeluarController::class, 'index'])->name('barangkeluar.index');
Route::get('/barangkeluar/create', [BarangKeluarController::class, 'create'])->name('barangkeluar.create');
Route::get('/barangkeluar/{id}/edit', [BarangKeluarController::class, 'edit'])->name('barangkeluar.edit');
Route::put('/barangkeluar/{id}', [BarangKeluarController::class, 'update'])->name('barangkeluar.update');
Route::delete('/barangkeluar/{id}', [BarangKeluarController::class, 'destroy'])->name('barangkeluar.destroy');
Route::post('/barangkeluar', [BarangKeluarController::class, 'store'])->name('barangkeluar.store');
Route::get('/barangkeluar/struk/{id}', [App\Http\Controllers\BarangKeluarController::class, 'cetakStruk'])->name('barangkeluar.struk');
Route::get('/barang-keluar/search', [BarangKeluarController::class, 'search'])->name('barangkeluar.search');


Route::get('/barang/{id}', [BarangController::class, 'show'])->name('barang.show');

Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barang-masuk.index');
Route::get('/barang-masuk/create', [BarangMasukController::class, 'create'])->name('barang-masuk.create');
Route::post('/barang-masuk', [BarangMasukController::class, 'store'])->name('barang-masuk.store');
// web.php
Route::get('/qr-code/{text}', function ($text) {
    $qr = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(150)->generate(urldecode($text));
    return response($qr)->header('Content-Type', 'image/png');
});

Route::delete('/barangmasuk/{id}', [BarangMasukController::class, 'destroy'])->name('barang-masuk.destroy');



Route::get('/employees', [EmployeesController::class, 'index'])->name('employees.index');
Route::get('/employees/create', [EmployeesController::class, 'create'])->name('employees.create');
Route::post('/employees', [EmployeesController::class, 'store'])->name('employees.store');
Route::delete('/employees/{id}', [EmployeesController::class, 'destroy'])->name('employees.destroy');
// Route::get('/departemen/{id}/employees', [DepartemenController::class, 'showEmployees'])->name('departemen.employees');
// Route::get('/employees', [DepartemenController::class, 'index'])->name('departemen.index');
Route::get('/departemen', [DepartemenController::class, 'show'])->name('departemen.show');
Route::get('/departemen', [DepartemenController::class, 'index'])->name('departemen.index');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [BarangKeluarController::class, 'dashboard'])->name('dashboard');
Route::get('/barang-keluar/chart', [BarangKeluarController::class, 'chartBarangKeluar'])->name('barangkeluar.chart');
