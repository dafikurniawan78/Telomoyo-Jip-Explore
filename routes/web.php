<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\PaketWisataController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\LokasiJemputController;
use App\Http\Controllers\JipController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/paket', [BerandaController::class, 'paket'])->name('paket');

Route::get('/pemesanan/{id}', [PemesananController::class, 'create'])->name('pemesanan.create');
Route::post('/pemesanan', [PemesananController::class, 'store'])->name('pemesanan.store');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/admin/paket-wisata', [PaketWisataController::class, 'index'])->name('paket-wisata.index');
Route::get('/admin/paket-wisata/create', [PaketWisataController::class, 'create'])->name('paket-wisata.create');
Route::post('/admin/paket-wisata', [PaketWisataController::class, 'store'])->name('paket-wisata.store');
Route::get('/admin/paket-wisata/{id}/edit', [PaketWisataController::class, 'edit'])->name('paket-wisata.edit');
Route::put('/admin/paket-wisata/{id}', [PaketWisataController::class, 'update'])->name('paket-wisata.update');
Route::delete('/admin/paket-wisata/{id}', [PaketWisataController::class, 'destroy'])->name('paket-wisata.destroy');

Route::get('/admin/lokasi-jemput', [LokasiJemputController::class, 'index'])->name('lokasi-jemput.index');
Route::get('/admin/lokasi-jemput/create', [LokasiJemputController::class, 'create'])->name('lokasi-jemput.create');
Route::post('/admin/lokasi-jemput', [LokasiJemputController::class, 'store'])->name('lokasi-jemput.store');
Route::get('/admin/lokasi-jemput/{id}/edit', [LokasiJemputController::class, 'edit'])->name('lokasi-jemput.edit');
Route::put('/admin/lokasi-jemput/{id}', [LokasiJemputController::class, 'update'])->name('lokasi-jemput.update');
Route::delete('/admin/lokasi-jemput/{id}', [LokasiJemputController::class, 'destroy'])->name('lokasi-jemput.destroy');

Route::get('/admin/jip', [JipController::class, 'index'])->name('jip.index');
Route::get('/admin/jip/create', [JipController::class, 'create'])->name('jip.create');
Route::post('/admin/jip', [JipController::class, 'store'])->name('jip.store');
Route::get('/admin/jip/{id}/edit', [JipController::class, 'edit'])->name('jip.edit');
Route::put('/admin/jip/{id}', [JipController::class, 'update'])->name('jip.update');
Route::delete('/admin/jip/{id}', [JipController::class, 'destroy'])->name('jip.destroy');
