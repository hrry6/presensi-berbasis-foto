<?php

use App\Http\Controllers\GuruBkController;
use App\Http\Controllers\GuruPiketController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtentikasiController;
use App\Http\Controllers\TataUsahaController;
use App\Http\Controllers\WaliKelasController;
use App\Http\Controllers\PengurusKelasController;
use App\Models\PengurusKelas;

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

        // Akun Guru
        Route::get('jurusan', [TataUsahaController::class, 'showJurusan']);
        Route::get('tambah-jurusan', [TataUsahaController::class, 'createJurusan']);
        Route::post('simpan-jurusan', [TataUsahaController::class, 'storeJurusan']);
        Route::get('edit-jurusan/{id}', [TataUsahaController::class, 'editJurusan']);
        Route::post('edit-jurusan/update', [TataUsahaController::class, 'updateJurusan']);
        Route::delete('hapus-jurusan', [TataUsahaController::class, 'destroyJurusan']);

        Route::get('kelas', [TataUsahaController::class, 'showKelas']);
        Route::get('detail-kelas/{id}', [TataUsahaController::class, 'detailKelas']);
        Route::get('tambah-kelas', [TataUsahaController::class, 'createKelas']);
        Route::post('simpan-kelas', [TataUsahaController::class, 'storeKelas']);
        Route::get('edit-kelas/{id}', [TataUsahaController::class, 'editKelas']);
        Route::post('edit-kelas/update', [TataUsahaController::class, 'updateKelas']);
        Route::delete('hapus-kelas', [TataUsahaController::class, 'destroyKelas']);

        // Akun Guru
        Route::get('akun-guru', [TataUsahaController::class, 'showGuru']);
        Route::get('detail-guru/{id}', [TataUsahaController::class, 'detailGuru']);
        Route::get('tambah-guru', [TataUsahaController::class, 'createGuru']);
        Route::post('simpan-guru', [TataUsahaController::class, 'storeGuru']);
        Route::get('edit-guru/{id}', [TataUsahaController::class, 'editGuru']);
        Route::post('edit-guru/update', [TataUsahaController::class, 'updateGuru']);
        Route::delete('hapus-guru', [TataUsahaController::class, 'destroyGuru']);
       
        // PENGURUS KELAS
        Route::get('akun-pengurus-kelas', [TataUsahaController::class, 'showPengurus']);
        Route::get('detail-pengurus-kelas/{id}', [TataUsahaController::class, 'detailPengurus']);
        Route::get('tambah-pengurus-kelas', [TataUsahaController::class, 'createPengurus']);
        Route::post('simpan-pengurus-kelas', [TataUsahaController::class, 'storePengurus']);
        Route::get('edit-pengurus-kelas/{id}', [TataUsahaController::class, 'editPengurus']);
        Route::post('edit-pengurus-kelas/update', [TataUsahaController::class, 'updatePengurus']);
        Route::delete('hapus-pengurus-kelas', [TataUsahaController::class, 'destroyPengurus']);

        // AKUN SISWA
        Route::get('akun-siswa', [TataUsahaController::class, 'showSiswa']);
        Route::get('detail-siswa/{id}', [TataUsahaController::class, 'detailSiswa']);
        Route::get('tambah-siswa', [TataUsahaController::class, 'createSiswa']);
        Route::post('simpan-siswa', [TataUsahaController::class, 'storeSiswa']);
        Route::get('edit-siswa/{id}', [TataUsahaController::class, 'editSiswa']);
        Route::post('edit-siswa/update', [TataUsahaController::class, 'updateSiswa']);
        Route::delete('hapus-siswa', [TataUsahaController::class, 'destroySiswa']);

        // PRESENSI
        Route::get('presensi', [TataUsahaController::class, 'showPresensi']);
        Route::get('presensi-pdf', [TataUsahaController::class, 'exportPresensi']);
        // LOGS
        Route::get('logs', [TataUsahaController::class, 'logs']);
        Route::post('hapus-logs', [TataUsahaController::class, 'deleteLogs']);
    });

    // GURU BK
    Route::prefix('guru-bk')->middleware('akses:5')->group(function () {
        Route::get('dashboard', [GuruBkController::class, 'index']);
        Route::get('detail-profil/{id}', [GuruBKController::class, 'detailProfil']);
        Route::get('detail-presensi/{id}', [GuruBkController::class, 'detailPresensi']);
        Route::get('presensi', [GuruBkController::class, 'showPresensi']);
        Route::get('presensi-pdf', [GuruBkController::class, 'exportPresensi']);
    });

    // GURU PIKET
    Route::prefix('guru-piket')->middleware('akses:4')->group(function () {
        Route::get('dashboard', [GuruPiketController::class, 'index']);
        Route::get('detail-profil/{id}', [GuruPiketController::class, 'detailProfil']);
        Route::get('akun-pengurus-kelas', [GuruPiketController::class, 'showPengurus']);
        Route::get('detail-pengurus-kelas/{id}', [GuruPiketController::class, 'detailPengurus']);
        Route::get('presensi', [GuruPiketController::class, 'showPresensi']);
        Route::get('detail-presensi/{id}', [GuruPiketController::class, 'detailPresensi']);
        Route::get('edit-presensi/{id}', [GuruPiketController::class, 'editPresensi']);
        Route::post('edit-presensi/update', [GuruPiketController::class, 'updatePresensi']);
        Route::get('presensi-pdf', [GuruPiketController::class, 'exportPresensi']);
    });

    // PENGURUS KELAS
    Route::prefix('pengurus-kelas')->middleware('akses:3')->group(function () {
        // DASHBOARD
        Route::get('dashboard', [PengurusKelasController::class, 'index']);

        Route::get('histori', [PengurusKelasController::class, 'showHistori']);

        // PRESENSI
        Route::get('/presensi', [PengurusKelasController::class, 'openCam']);
        Route::post('webcam', [PengurusKelasController::class, 'store'])->name('webcam.capture');
        Route::post('/webcam/check_snapshot', [PengurusKelasController::class, 'checkSnapshot'])->name('webcam.check_snapshot');

        // VALIDASI
        Route::get('kelas', [PengurusKelasController::class, 'showKelas']);
        Route::post('validasi', [PengurusKelasController::class, 'storeValidasi']);
    });

    // WALI KELAS
    Route::prefix('wali-kelas')->middleware('akses:2')->group(function () {
        // DASHBOARD
        Route::get('dashboard', [WaliKelasController::class, 'index']);

        // AKUN SISWA
        Route::get('akun-siswa', [WaliKelasController::class, 'showSiswa']);
        Route::get('detail-siswa/{id}', [WaliKelasController::class, 'detailSiswa']);
        Route::get('edit-siswa/{id}', [WaliKelasController::class, 'editSiswa']);
        Route::post('edit-siswa/simpan', [WaliKelasController::class, 'updateSiswa']);

        // PENGURUS KELAS
        Route::get('akun-pengurus-kelas', [WaliKelasController::class, 'showPengurus']);
        Route::get('tambah-pengurus-kelas', [WaliKelasController::class, 'createPengurus']);
        Route::post('simpan-pengurus-kelas', [WaliKelasController::class, 'storePengurus']);
        Route::get('detail-kelas/{id}', [WaliKelasController::class, 'detailKelasPengurus']);
        Route::get('detail-siswa-pengurus/{id}', [WaliKelasController::class, 'detailSiswa']);
        Route::get('edit-pengurus-kelas/{id}', [WaliKelasController::class, 'editPengurus']);
        Route::post('edit-pengurus-kelas/update', [WaliKelasController::class, 'updatePengurus']);
        Route::delete('hapus-pengurus-kelas', [WaliKelasController::class, 'destroyPengurus']);

        // PRESENSI SISWA
        Route::get('presensi-siswa', [WaliKelasController::class, 'showPresensi']);
        Route::get('edit-presensi-siswa/{id}', [WaliKelasController::class, 'editPresensi']);
        Route::post('edit-presensi-siswa/update', [WaliKelasController::class, 'updatePresensi']);
        Route::get('presensi-pdf', [WaliKelasController::class, 'exportPresensi']);

        // LOGS
        Route::get('logs', [WaliKelasController::class, 'logs']);
    });

    // SISWA
    Route::prefix('siswa')->middleware('akses:1')->group(function () {
        Route::get('dashboard', [SiswaController::class, 'index']);

        Route::get('histori', [SiswaController::class, 'showHistori']);


        // PRESENSI
        Route::get('/presensi', [SiswaController::class, 'openCam']);
        Route::post('webcam', [SiswaController::class, 'store'])->name('webcam.capture');
        Route::post('/webcam/check_snapshot', [SiswaController::class, 'checkSnapshot'])->name('webcam.check_snapshot');

    });
});
