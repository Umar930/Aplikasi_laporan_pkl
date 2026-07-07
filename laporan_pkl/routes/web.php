<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
})->name('home');


// Route untuk login/register

Route::get('/register', [AuthController::class, 'showregister'])->name('register');

Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showlogin'])->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']);

Route::get('web/dashboard', function() { return "Dashboard Admin";});
Route::get('guru/dashboard', function() { return "Dashboard Guru";});
Route::get('dudi/dashboard', function() { return "Dashboard Dudi";});
Route::get('murid/dashboard', function() { return "Dashboard Murid";});



// Route untuk halaman bagian

Route::get('/laporan-bulanan', function(){
    return view('laporan-bulanan.index');
})->name('bulanan');

Route::get('/observasi', function(){
    return view('observasi.index');
})->name('observasi');

Route::get('/laporan-nilai', function(){
    return view('laporan-nilai.index');
})->name('nilai');

Route::get('/laporan-harian', function(){
    return view('laporan-harian.index');
})->name('harian');

Route::get('/jurnal-kompetensi', function(){
    return view('jurnal-kompetensi.index');
})->name('kompetensi');

Route::get('/profil', function(){
    return view('profil.index');
})->name('profil');

Route::get('/index', function(){
    return view('index');
});

