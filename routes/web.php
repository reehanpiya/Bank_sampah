<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BsuController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\JenisSampahController;
use App\Http\Controllers\HargaSampahController;
use App\Http\Controllers\TransaksiSetorController;
use App\Http\Controllers\PenarikanController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransaksiSetorBsuController;

/*
|--------------------------------------------------------------------------
| Public Route
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');

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

    Route::get(
        '/laporan/harian',
        [ReportController::class, 'harian']
    )->name('laporan.harian');

    Route::get(
        '/laporan/bulanan',
        [ReportController::class, 'bulanan']
    )->name('laporan.bulanan');

    Route::get(
        '/laporan/tahunan',
        [ReportController::class, 'tahunan']
    )->name('laporan.tahunan');

    Route::get(
        '/laporan/saldo-nasabah',
        [ReportController::class, 'saldoNasabah']
    )->name('laporan.saldo-nasabah');

    Route::get(
        '/laporan/bsi',
        [ReportController::class, 'laporanBsi']
    )->name('laporan.bsi');
    });

    Route::get(
        '/laporan/export-csv',
        [ReportController::class, 'exportCsv']
    )->name('laporan.export-csv');

    Route::get(
        '/laporan/export-excel',
        [ReportController::class, 'exportExcel']
    )->name('laporan.export-excel');

    Route::resource(
        'transaksi-setor-bsu',
        TransaksiSetorBsuController::class
    );

    Route::get(
        '/laporan/{id}',
        [ReportController::class, 'show']
    )->name('report.show');


    Route::middleware(['auth', 'role:admin_bsi'])
        ->group(function () {

            Route::resource(
                'jenis-sampah',
                JenisSampahController::class
            )->except([
                'index',
                'show'
            ]);

            Route::resource(
                'harga-sampah',
                HargaSampahController::class
            )->except([
                'index',
                'show'
            ]);
        });

/*
|--------------------------------------------------------------------------
| Breeze Auth Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';