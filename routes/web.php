<?php

use App\Http\Controllers\GuruPiketController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtentikasiController;
use App\Http\Controllers\TataUsahaController;
use App\Http\Controllers\WaliKelasController;
use App\Http\Controllers\PengurusKelasController;

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

Route::get('/', [OtentikasiController::class, 'index'])->name('login');
Route::post('/', [OtentikasiController::class, 'authenticated']);


Route::middleware(['auth'])->group(function () {

    // TATA USAHA
    Route::prefix('tata-usaha')->middleware('akses:tata-usaha')->group(function () {
        Route::get('dashboard', [TataUsahaController::class, 'index']);
    });

    // GURU BK
    Route::prefix('guru-bk')->middleware('akses:guru-bk')->group(function () {
        Route::get('dashboard', [WaliKelasController::class, 'index']);
    });

    // GURU PIKET
    Route::prefix('guru-piket')->middleware('akses:guru-piket')->group(function () {
        Route::get('dashboard', [GuruPiketController::class, 'index']);
    });

    // WALI KELAS
    Route::prefix('wali-kelas')->middleware('akses:wali-kelas')->group(function () {
        Route::get('dashboard', [WaliKelasController::class, 'index']);
    });

    // SISWA
    Route::prefix('siswa')->middleware('akses:siswa')->group(function () {
        Route::get('dashboard', [SiswaController::class, 'index']);
    });

    // PENGURUS KELAS
    Route::prefix('pengurus-kelas')->middleware('akses:pengurus-kelas')->group(function () {
        Route::get('dashboard', [PengurusKelasController::class, 'index']);
    });
});
