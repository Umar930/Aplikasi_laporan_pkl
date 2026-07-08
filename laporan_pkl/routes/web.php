<?php

use App\Http\Controllers\AuthController;
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

// Route::middleware(['auth:murid,guru,dudi,web', 'redirect.role'])->get('/', function() {
//     return view('welcome');
// });

Route::middleware(['auth:murid'])->prefix('murid')->name('murid.')->group(function (){
    Route::get('/laporan-harian', function(){
    return view('laporan-harian.index');
    })->name('harian');

    Route::get('/laporan-bulanan', function(){
    return view('laporan-bulanan.index');
    })->name('bulanan');

    Route::get('/jurnal-kompetensi', function(){
    return view('jurnal-kompetensi.index');
    })->name('kompetensi');

    Route::get('/profil', function(){
    return view('profil.index');
    })->name('profil');
});

Route::middleware(['auth:dudi'])->prefix('dudi')->name('dudi.')->group(function (){
    Route::get('/laporan-nilai', function(){
    return view('laporan-nilai.index');
    })->name('nilai');
});

Route::middleware(['auth:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/jurnal-kompetensi', function(){
    return view('jurnal-kompetensi.index');
    })->name('kompetensi');
});

Route::middleware(['auth:web'])->prefix('web')->name('web.')->group(function (){
    Route::get('/observasi', function(){
        return view('observasi.index');
    })->name('observasi');
});
