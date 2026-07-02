<?php

use App\Http\Controllers\JurnalKegiatanController;
use App\Http\Controllers\CatatanKegiatanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('auth.login', function(){
    return view('auth.login');
});

Route::get('auth.register', function(){
    return view('auth.register');
});

Route::get('/index', function(){
    return view('index');
});

Route::get('catatan-kegiatan.index', function(){
    return view('catatan-kegiatan.index');
});

route::resource('jurnal-kegiatan', JurnalKegiatanController::class);
route::resource('catatan-kegiatan', CatatanKegiatanController::class);
