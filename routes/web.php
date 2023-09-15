<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\WalikelasController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SiswaController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});


Auth::routes();
  
/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:user'])->group(function () {
  
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

  
/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {
  
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
});
  
/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:walikelas'])->group(function () {
  
    Route::get('/walikelas/home', [HomeController::class, 'walikelasHome'])->name('walikelas.home');
});
 // data untuk admin 
Route::resource('/posts',\App\Http\Controllers\PostController::class);
Route::resource('/guru',\App\Http\Controllers\WalikelasController::class);

// data untuk guru
Route::resource('/teacher',\App\Http\Controllers\TeacherController::class);
// data untuk siswa
Route::resource('/siswa',\App\Http\Controllers\SiswaController::class);
// membuat route untuk mencari data siswa dan cetak
Route::get('/cetak', [PostController::class, 'cetak'])->name('posts.cetak');

Route::get('/search', [PostController::class, 'cari'])->name('posts.cari');

//membuat route untuk mencari data guru dan cetak
Route::get('/search/guru', [WalikelasController::class, 'cari'])->name('guru.cari');

//Membuat router cetak data siswa untuk siswa
Route::get('/cari/siswa', [SiswaController::class, 'cari'])->name('siswa.cari');
//Membuat router cetak data siswa untuk guru
Route::get('/cari/guru', [TeacherController::class, 'cari'])->name('teacher.cari');

