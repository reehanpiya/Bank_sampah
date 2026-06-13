<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BsuController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\JenisSampahController;
use App\Http\Controllers\HargaSampahController;
use App\Http\Controllers\TransaksiSetorController;
use App\Http\Controllers\PenarikanController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Master Data
|--------------------------------------------------------------------------
*/

Route::resource('bsu', BsuController::class);

Route::resource('nasabah', NasabahController::class);

Route::resource('jenis-sampah', JenisSampahController::class);

Route::resource('harga-sampah', HargaSampahController::class);

/*
|--------------------------------------------------------------------------
| Transaksi
|--------------------------------------------------------------------------
*/

Route::resource(
    'transaksi-setor',
    TransaksiSetorController::class
);

Route::resource(
    'penarikan',
    PenarikanController::class
);

/*
|--------------------------------------------------------------------------
| Laporan
|--------------------------------------------------------------------------
*/

Route::get(
    '/laporan',
    [ReportController::class, 'index']
)->name('laporan.index');