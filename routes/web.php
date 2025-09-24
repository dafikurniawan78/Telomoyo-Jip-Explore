<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlokasiJipController;
use App\Http\Controllers\AntreanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaketWisataController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\LokasiJemputController;
use App\Http\Controllers\JipController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/paket', [BerandaController::class, 'paket'])->name('paket');

Route::get('/pemesanan/create/{id}', [PemesananController::class, 'create'])->name('pemesanan.create');
Route::post('/pemesanan', [PemesananController::class, 'store'])->name('pemesanan.store');
Route::get('/pemesanan/show/{id}', [PemesananController::class, 'show'])->name('pemesanan.show');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/pemesanan', [PemesananController::class, 'index'])->name('admin.pemesanan.index');
    Route::get('/admin/pemesanan/{id}', [PemesananController::class, 'detail'])->name('admin.pemesanan.detail');
    Route::put('/admin/pemesanan/{id}/status', [PemesananController::class, 'updateStatus'])->name('admin.pemesanan.updateStatus');
    Route::delete('/admin/pemesanan/{id}', [PemesananController::class, 'destroy'])->name('admin.pemesanan.destroy');

    Route::get('/admin/antrean', [AntreanController::class, 'index'])->name('admin.antrean.index');
    Route::post('/admin/antrean/store/{pemesananId}', [AntreanController::class, 'storeFromPemesanan'])->name('admin.antrean.storeFromPemesanan');
    Route::put('/admin/antrean/{id}/status', [AntreanController::class, 'updateStatus'])->name('admin.antrean.updateStatus');
    Route::delete('/admin/antrean/{id}', [AntreanController::class, 'destroy'])->name('admin.antrean.destroy');
    Route::put('/admin/antrean/{id}/layani', [AntreanController::class, 'layani'])->name('admin.antrean.layani');
    Route::put('/admin/antrean/{id}/selesai', [AntreanController::class, 'selesai'])->name('admin.antrean.selesai');

    Route::get('/admin/alokasi', [AlokasiJipController::class, 'index'])->name('admin.alokasi.index');

    Route::get('/admin/paket-wisata', [PaketWisataController::class, 'index'])->name('admin.paket-wisata.index');
    Route::get('/admin/paket-wisata/create', [PaketWisataController::class, 'create'])->name('admin.paket-wisata.create');
    Route::post('/admin/paket-wisata', [PaketWisataController::class, 'store'])->name('admin.paket-wisata.store');
    Route::get('/admin/paket-wisata/{id}/edit', [PaketWisataController::class, 'edit'])->name('admin.paket-wisata.edit');
    Route::put('/admin/paket-wisata/{id}', [PaketWisataController::class, 'update'])->name('admin.paket-wisata.update');
    Route::delete('/admin/paket-wisata/{id}', [PaketWisataController::class, 'destroy'])->name('admin.paket-wisata.destroy');

    Route::get('/admin/lokasi-jemput', [LokasiJemputController::class, 'index'])->name('admin.lokasi-jemput.index');
    Route::get('/admin/lokasi-jemput/create', [LokasiJemputController::class, 'create'])->name('admin.lokasi-jemput.create');
    Route::post('/admin/lokasi-jemput', [LokasiJemputController::class, 'store'])->name('admin.lokasi-jemput.store');
    Route::get('/admin/lokasi-jemput/{id}/edit', [LokasiJemputController::class, 'edit'])->name('admin.lokasi-jemput.edit');
    Route::put('/admin/lokasi-jemput/{id}', [LokasiJemputController::class, 'update'])->name('admin.lokasi-jemput.update');
    Route::delete('/admin/lokasi-jemput/{id}', [LokasiJemputController::class, 'destroy'])->name('admin.lokasi-jemput.destroy');

    Route::get('/admin/jip', [JipController::class, 'index'])->name('admin.jip.index');
    Route::get('/admin/jip/create', [JipController::class, 'create'])->name('admin.jip.create');
    Route::post('/admin/jip', [JipController::class, 'store'])->name('admin.jip.store');
    Route::get('/admin/jip/{id}/edit', [JipController::class, 'edit'])->name('admin.jip.edit');
    Route::put('/admin/jip/{id}', [JipController::class, 'update'])->name('admin.jip.update');
    Route::delete('/admin/jip/{id}', [JipController::class, 'destroy'])->name('admin.jip.destroy');
});
