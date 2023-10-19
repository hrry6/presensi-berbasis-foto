<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtentikasiController;

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

// Route::group(function () {
//     Route::get('/', [AuthController::class, 'index'])->name('login');
//     Route::post('/', [AuthController::class, 'login']);
// });