<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KompetensiDasarController;
use App\Http\Controllers\TujuanPembelajaranController;
use App\Http\Controllers\JurnalKompetensiController;
use App\Http\Controllers\DaftarNilaiController;
use App\Http\Controllers\ObservasiController;
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

Route::get('/laporan-nilai', function(){
    return view('laporan-nilai.index');
});

Route::middleware(['auth:murid'])->prefix('murid')->name('murid.')->group(function (){
    Route::get('/laporan-harian', function(){
    return view('laporan-harian.index');
    })->name('harian');

    Route::get('/laporan-bulanan', function(){
    return view('laporan-bulanan.index');
    })->name('bulanan');

    Route::get('/jurnal-kompetensi', [KompetensiDasarController::class, 'index'])->name('kompetensi');

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

    Route::get('/jurnal-kompetensi', [KompetensiDasarController::class, 'index'])->name('kompetensi');
    
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

Route::middleware(['auth:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/jurnal-kompetensi', [KompetensiDasarController::class, 'index'])->name('kompetensi');

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

