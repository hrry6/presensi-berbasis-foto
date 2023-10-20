<?php

use App\Http\Controllers\GuruBkController;
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
Route::get('/logout', [OtentikasiController::class, 'logout']);


Route::middleware(['auth'])->group(function () {

    Route::prefix('tata-usaha')->middleware('akses:6')->group(function () {
        // DASHBOARD
        Route::get('dashboard', [TataUsahaController::class, 'index']);

        // AKUN SISWA
        Route::get('akun-siswa', [TataUsahaController::class, 'showSiswa']);
        Route::get('tambah-siswa', [TataUsahaController::class, 'createSiswa']);
        Route::post('simpan-siswa', [TataUsahaController::class, 'storeSiswa']);
        Route::get('edit-siswa/{id}', [TataUsahaController::class, 'editSiswa']);
        Route::post('edit-siswa/update', [TataUsahaController::class, 'updateSiswa']);
        Route::delete('hapus-siswa', [TataUsahaController::class, 'destroySiswa']);

        // PENGURUS KELAS
        Route::get('akun-pengurus-kelas', [TataUsahaController::class, 'showPengurus']);
        Route::get('tambah-pengurus-kelas', [TataUsahaController::class, 'createPengurus']);
        Route::post('simpan-pengurus-kelas', [TataUsahaController::class, 'storePengurus']);
        Route::get('edit-pengurus-kelas/{id}', [TataUsahaController::class, 'editPengurus']);
        Route::post('edit-pengurus-kelas/update', [TataUsahaController::class, 'updatePengurus']);
        Route::delete('hapus-pengurus-kelas', [TataUsahaController::class, 'destroyPengurus']);
        // LOGS
        Route::get('logs', [TataUsahaController::class, 'logs']);
    });

    // GURU BK
    Route::prefix('guru-bk')->middleware('akses:5')->group(function () {
        Route::get('dashboard', [GuruBkController::class, 'index']);
    });

    // GURU PIKET
    Route::prefix('guru-piket')->middleware('akses:4')->group(function () {
        Route::get('dashboard', [GuruPiketController::class, 'index']);
    });

    // PENGURUS KELAS
    Route::prefix('pengurus-kelas')->middleware('akses:3')->group(function () {
        Route::get('dashboard', [PengurusKelasController::class, 'index']);
    });

    // WALI KELAS
    Route::prefix('wali-kelas')->middleware('akses:2')->group(function () {
        // DASHBOARD
        Route::get('dashboard', [WaliKelasController::class, 'index']);

        // AKUN SISWA
        Route::get('akun-siswa', [WaliKelasController::class, 'showSiswa']);
        Route::get('tambah-siswa', [WaliKelasController::class, 'create']);
        Route::post('tambah-simpan', [WaliKelasController::class, 'store']);
        Route::get('edit-siswa/{id}', [WaliKelasController::class, 'edit']);
        Route::post('edit-siswa/simpan', [WaliKelasController::class, 'update']);
        Route::delete('hapus-siswa', [WaliKelasController::class, 'destroySiswa']);
    });

    // SISWA
    Route::prefix('siswa')->middleware('akses:1')->group(function () {
        Route::get('dashboard', [SiswaController::class, 'index']);
    });

});