<?php

use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PackagesController;
use App\Http\Controllers\Admin\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('controll', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';


Route::middleware('auth')
->prefix('controll')
->as('admin.')
->group(function() {
/**
 * IMPORTANT:
 * Menggunakan prefix "controll" agar route admin tidak terlalu umum
 * dan tidak mudah diakses customer. URL browser = controll,
 * tetapi di dalam code tetap menggunakan admin.
 */

    Route::resource('game', GameController::class);
    Route::resource('paket', PackagesController::class);
    Route::resource('transaksi', OrderController::class);
    Route::resource('laporan', ReportController::class);
});