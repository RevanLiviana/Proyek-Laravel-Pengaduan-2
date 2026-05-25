<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect(match(auth()->user()->role ?? '') {
        'super_admin', 'admin' => '/pengelolaan/laporan',
        default => '/master/kategori',
    });
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ══════ DATA MASTER ══════
Route::prefix('master')->name('master.')->middleware(['auth'])->group(function () {
    Route::resource('kategori', \App\Http\Controllers\Master\KategoriController::class);
    Route::resource('pengguna', \App\Http\Controllers\Master\PenggunaController::class);
    Route::resource('petugas', \App\Http\Controllers\Master\PetugasController::class);
    Route::resource('unit', \App\Http\Controllers\Master\UnitController::class);
});

// ══════ PENGELOLAAN ══════
Route::prefix('pengelolaan')->name('pengelolaan.')->middleware(['auth'])->group(function () {
    Route::resource('laporan', \App\Http\Controllers\Pengelolaan\LaporanController::class);
    Route::patch('laporan/{laporan}/status', [\App\Http\Controllers\Pengelolaan\LaporanController::class, 'updateStatus'])->name('laporan.updateStatus');
    Route::resource('pengguna', \App\Http\Controllers\Pengelolaan\PenggunaController::class);
});

// ══════ LAPORAN USER ══════
Route::middleware(['auth'])->group(function () {
    Route::get('/laporan-pengaduan', [\App\Http\Controllers\LaporanPengaduanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan-pengaduan', [\App\Http\Controllers\LaporanPengaduanController::class, 'store'])->name('laporan.store');
    Route::get('/riwayat-laporan', [\App\Http\Controllers\LaporanPengaduanController::class, 'riwayat'])->name('riwayat.index');
    Route::get('/rekapitulasi', [\App\Http\Controllers\RekapitulasiController::class, 'index'])->name('rekapitulasi.index');
    Route::get('/export-data', [\App\Http\Controllers\RekapitulasiController::class, 'export'])->name('export.data');
});
