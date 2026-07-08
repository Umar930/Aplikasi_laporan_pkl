<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route untuk login/register
Route::get('/login', function(){
    return view('auth.login');
})->name('login');

Route::get('/register-user', function(){
    return view('auth.register-user');
})->name('user');

Route::get('/register-guru-pembimbing', function(){
    return view('auth.register-guru-pembimbing');
})->name('guru-pembimbing');

Route::get('/register-dudi', function(){
    return view('auth.register-dudi');
})->name('dudi');

Route::get('/register-murid', function(){
    return view('auth.register-murid');
})->name('murid');


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

