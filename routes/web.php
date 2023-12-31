<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PesananbController;
use App\Http\Controllers\PesanandController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DasboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SayuranController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// DasboardC
Route::get('/',[DasboardController::class, 'index'])->name('home');
Route::get('/test',[DasboardController::class, 'test']);
// Route::get('/invoice/invoice',[DasboardController::class, 'test']);


// customer
Route::get('/cust',[CustomerController::class, 'cust'])->name('pelanggan');
Route::get('/cust/add/{id}',[CustomerController::class, 'tambah']);
Route::post('/cust/save',[CustomerController::class, 'save']);
Route::get('/cust/cari',[CustomerController::class, 'cari']);
Route::get('/cust/invoice/{id}', [CustomerController::class, 'invoice']);

// pesanan
Route::prefix('pesanan')->group(function () {
    Route::get('/up_status/{id}', [PesananController::class, 'up_status']);
    Route::get('/cari-sayur/{kataKunci}', [PesananController::class, 'cari_sayur']);
    Route::post('/with-model', [PesananController::class, 'simpan_pesanan'])->name('pesanan.store');
    Route::get('/invoice/{id}', [PesananController::class, 'ubah_pesanan_pdf']);
});



// sayuran
// Route::get('/sayuran/up_status/{id}',[SayuranController::class, 'up_status']);
// Route::get('/sayuran/cari',[SayuranController::class, 'cari']);
// Route::get('/sayuran/hapus/{id}',[SayuranController::class, 'delete']);
// Route::get('/sayuran/edit/{id}',[SayuranController::class, 'edit']);
// Route::post('/sayuran/update',[SayuranController::class, 'update']);
// Route::get('/sayuran', [SayuranController::class, 'index'])->name('sayuran');
// // Route::get('/sayuran', 'SayuranController@index')->name('index');

// Route::post('/sayuran/with-model', [SayuranController::class, 'insertwmodel']);
// Route::get('/sayuran/input', [SayuranController::class, 'insert']);
// Route::get('/sayuran/detail/{id}', [SayuranController::class, 'getbyid']);

// AdminController
Route::prefix('admin')->group(function () {
    Route::get('/index', [AdminController::class, 'index']);

    Route::post('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::get('/hapus/{id}', [AdminController::class, 'hapus_pesanan'])->name('admin.hapus_pesanan');
    Route::get('/detail_pesanan/{id}', [AdminController::class, 'detail_pesanan'])->name('admin.detail_pesanan');
    Route::get('/cari_pesanan', [AdminController::class, 'cari_pesanan'])->name('admin.cari_pesanan');
    Route::get('/data_pesanan', [AdminController::class, 'lihat_data_pesanan'])->name('admin.data_pesanan');
    Route::get('/input', [AdminController::class, 'insert_data_pesanan'])->name('admin.insert_pesanan');
    Route::get('/up_status/{id}', [AdminController::class, 'aktivasi_pembayaran'])->name('admin.ubah_status_pesanan');

});

