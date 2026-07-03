<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// route halaman login/register
Route::get('/login', function(){
    return view('auth.login');
})->name('login');

Route::get('/register', function(){
    return view('auth.register');
})->name('register');


// halaman bagian
Route::get('/laporan-harian', function(){
    return view('laporan-harian.index');
})->name('laporan-harian');

Route::get('/laporan-bulanan', function(){
    return view('laporan-bulanan.index');
})->name('laporan-bulanan');

Route::get('/observasi', function(){
    return view('observasi.index');
})->name('observasi');

Route::get('/laporan-nilai', function(){
    return view('laporan-nilai.index');
})->name('laporan-nilai');

Route::get('/jurnal-kompetensi', function(){
    return view('jurnal-kompetensi.index');
})->name('jurnal-kompetensi');
