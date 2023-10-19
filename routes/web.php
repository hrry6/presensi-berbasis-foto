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
Route::prefix('tata-usaha')->group(function () {
    Route::get('dashboard', [TataUsahaController::class, 'index']);
});
Route::prefix('guru-bk')->group(function () {
    Route::get('dashboard', [WaliKelasController::class, 'index']);
});
Route::prefix('guru-piket')->group(function () {
    Route::get('dashboard', [GuruPiketController::class, 'index']);
});
Route::prefix('wali-kelas')->group(function () {
    Route::get('dashboard', [WaliKelasController::class, 'index']);
});
Route::prefix('siswa')->group(function () {
    Route::get('dashboard', [SiswaController::class, 'index']);
});
Route::prefix('pengurus-kelas')->group(function () {
    Route::get('dashboard', [PengurusKelasController::class, 'index']);
});
