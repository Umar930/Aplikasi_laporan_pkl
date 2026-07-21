<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KompetensiDasarController;
use App\Http\Controllers\TujuanPembelajaranController;
use App\Http\Controllers\JurnalKompetensiController;
use App\Http\Controllers\DaftarNilaiController;
use App\Http\Controllers\ObservasiController;
use App\Http\Controllers\LaporanBulananController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function(){
    return view('welcome');
})->name('home');


// Route untuk login/register

Route::middleware('guest')->group(function (){
    
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showregister'])->name('register');
Route::get('/login', [AuthController::class, 'showlogin'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// Route untuk halaman bagian

Route::middleware(['auth:murid'])->prefix('murid')->name('murid.')->group(function (){
    Route::get('/laporan-harian', function(){
    return view('laporan-harian.index');
    })->name('harian');

    Route::get('/laporan-bulanan', [LaporanBulananController::class, 'index'])->name('bulanan.index');
    Route::get('/laporan-bulanan/tambah', [LaporanBulananController::class, 'create'])->name('bulanan.tambah');
    Route::post('/laporan-bulanan', [LaporanBulananController::class, 'store'])->name('bulanan.store');
    Route::get('/laporan-bulanan/{id}/edit', [LaporanBulananController::class, 'edit'])->name('bulanan.edit');
    Route::put('/laporan-bulanan/{id}', [LaporanBulananController::class, 'update'])->name('bulanan.update');
    Route::delete('/laporan-bulanan/{id}', [LaporanBulananController::class, 'delete'])->name('bulanan.delete');

    Route::get('/profil', function(){
    return view('profil.index');
    })->name('profil');
});

Route::middleware(['auth:dudi'])->prefix('dudi')->name('dudi.')->group(function (){
    Route::get('/laporan-nilai', [DaftarNilaiController::class, 'index'])->name('nilai.index');
    Route::get('/laporan-nilai/tambah', [DaftarNilaiController::class, 'create'])->name('nilai.tambah');
    Route::post('/laporan-nilai', [DaftarNilaiController::class, 'store'])->name('nilai.store');
    Route::get('/laporan-nilai/{id}/edit', [DaftarNilaiController::class, 'edit'])->name('nilai.edit');
    Route::put('/laporan-nilai/{id}', [DaftarNilaiController::class, 'update'])->name('nilai.update');
    Route::delete('/laporan-nilai/{id}', [DaftarNilaiController::class, 'destroy'])->name('nilai.destroy');

    Route::get('/jurnal-kompetensi', [JurnalKompetensiController::class, 'index'])->name('jurnal.index');
    Route::get('/jurnal-kompetensi/tambah', [JurnalKompetensiController::class, 'create'])->name('jurnal.tambah');
    Route::post('/jurnal-kompetensi', [JurnalKompetensiController::class, 'store'])->name('jurnal.store');
    Route::get('/jurnal-kompetensi/{id}/edit', [JurnalKompetensiController::class, 'edit'])->name('jurnal.edit');
    Route::put('/jurnal-kompetensi/{id}', [JurnalKompetensiController::class, 'update'])->name('jurnal.update');
    Route::delete('/jurnal-kompetensi/{id}', [JurnalKompetensiController::class, 'destroy'])->name('jurnal.hapus');
    
    Route::get('/observasi', [ObservasiController::class, 'index'])->name('observasi.index');
    Route::get('/observasi/tambah', [ObservasiController::class, 'create'])->name('observasi.tambah');
    Route::post('/observasi', [ObservasiController::class, 'store'])->name('observasi.store');
    Route::get('/observasi/{id}/edit', [ObservasiController::class, 'edit'])->name('observasi.edit');
    Route::put('/observasi/{id}', [ObservasiController::class, 'update'])->name('observasi.update');
    Route::delete('/observasi/{id}', [ObservasiController::class, 'destroy'])->name('observasi.destroy');

    Route::get('/laporan-bulanan', [LaporanBulananController::class, 'index'])->name('bulanan.index');
    Route::get('/laporan-bulanan/tambah', [LaporanBulananController::class, 'create'])->name('bulanan.tambah');
    Route::post('/laporan-bulanan', [LaporanBulananController::class, 'store'])->name('bulanan.store');
    Route::get('/laporan-bulanan/{id}/edit', [LaporanBulananController::class, 'edit'])->name('bulanan.edit');
    Route::put('/laporan-bulanan/{id}', [LaporanBulananController::class, 'update'])->name('bulanan.update');
    Route::delete('/laporan-bulanan/{id}', [LaporanBulananController::class, 'delete'])->name('bulanan.delete');
    Route::post('/laporan-bulanan/{id}', [LaporanBulananController::class, 'verifikasi'])->name('bulanan.verifikasi');

    Route::get('/profil', function(){
    return view('profil.index');
    })->name('profil');
});

Route::middleware(['auth:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/jurnal-kompetensi', [JurnalKompetensiController::class, 'index'])->name('jurnal.index');
    Route::get('/jurnal-kompetensi/tambah', [JurnalKompetensiController::class, 'create'])->name('jurnal.tambah');
    Route::post('/jurnal-kompetensi', [JurnalKompetensiController::class, 'store'])->name('jurnal.store');
    Route::get('/jurnal-kompetensi/{id}/edit', [JurnalKompetensiController::class, 'edit'])->name('jurnal.edit');
    Route::put('/jurnal-kompetensi/{id}', [JurnalKompetensiController::class, 'update'])->name('jurnal.update');
    Route::delete('/jurnal-kompetensi/{id}', [JurnalKompetensiController::class, 'destroy'])->name('jurnal.hapus');

    Route::get('/laporan-nilai', [DaftarNilaiController::class, 'index'])->name('nilai.index');
    Route::get('/laporan-nilai/tambah', [DaftarNilaiController::class, 'create'])->name('nilai.tambah');
    Route::post('/laporan-nilai', [DaftarNilaiController::class, 'store'])->name('nilai.store');
    Route::get('/laporan-nilai/{id}/edit', [DaftarNilaiController::class, 'edit'])->name('nilai.edit');
    Route::put('/laporan-nilai/{id}', [DaftarNilaiController::class, 'update'])->name('nilai.update');
    Route::delete('/laporan-nilai/{id}', [DaftarNilaiController::class, 'destroy'])->name('nilai.destroy');

    Route::get('/observasi', [ObservasiController::class, 'index'])->name('observasi.index');
    Route::get('/observasi/tambah', [ObservasiController::class, 'create'])->name('observasi.tambah');
    Route::post('/observasi', [ObservasiController::class, 'store'])->name('observasi.store');
    Route::get('/observasi/{id}/edit', [ObservasiController::class, 'edit'])->name('observasi.edit');
    Route::put('/observasi/{id}', [ObservasiController::class, 'update'])->name('observasi.update');
    Route::delete('/observasi/{id}', [ObservasiController::class, 'destroy'])->name('observasi.destroy');

    Route::get('/profil', function(){
    return view('profil.index');
    })->name('profil');
});

Route::middleware(['auth:web'])->prefix('web')->name('web.')->group(function (){
    Route::get('/observasi', [ObservasiController::class, 'index'])->name('observasi');

    Route::get('/laporan-nilai', [DaftarNilaiController::class, 'index'])->name('nilai');
    Route::get('/laporan-nilai/tambah', [DaftarNilaiController::class, 'create'])->name('tambah');
    Route::post('/laporan-nilai', [DaftarNilaiController::class, 'store'])->name('store');
    Route::get('/laporan-nilai/{id}/edit', [DaftarNilaiController::class, 'edit'])->name('edit');
    Route::put('/laporan-nilai/{id}', [DaftarNilaiController::class, 'update'])->name('update');
    Route::delete('/laporan-nilai/{id}', [DaftarNilaiController::class, 'destroy'])->name('destroy');

    Route::get('/jurnal-kompetensi', [KompetensiDasarController::class, 'index'])->name('kompetensi');

    Route::get('/profil', function(){
    return view('profil.index');
    })->name('profil');
});

