<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SubProdukController;
use App\Http\Controllers\DetailBrgMasukController;
use App\Http\Controllers\DetailPenjualanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\RecBrgMasukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\PemindahanStokController;

Route::get('/', function () {
    return view('welcome');
})->name('beranda');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::name('master.')->prefix('master')->group(function () {
    Route::resource('kategori', KategoriController::class);
    Route::resource('produk', ProdukController::class);
    Route::resource('subproduk', SubProdukController::class);
    Route::get('/subproduk/copy/{id}', [SubProdukController::class, 'copy'])->name('subproduk.copy');
    Route::resource('lokasi', LokasiController::class);
    Route::resource('pembeli', PembeliController::class);
});
Route::resource('rec_brg_masuk', RecBrgMasukController::class);

Route::resource('penjualan', PenjualanController::class);

Route::get('/stok', [StokController::class, 'index'])->name('stok.index');

Route::resource('pemindahan_stok', PemindahanStokController::class);

Route::resource('detailbrgmasuk', DetailBrgMasukController::class);

Route::resource('detailpenjualan', DetailPenjualanController::class);

Route::resource('user', UserController::class);

require __DIR__.'/auth.php';
