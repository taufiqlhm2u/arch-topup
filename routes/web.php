<?php

use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PackagesController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\GameController as UserGame;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::view('controll', 'pages.admin.dashboard')
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

Route::middleware('guest')->group(function() {
    Route::get('/game', [UserGame::class, 'index'])->name('game.index');
    Route::get('/game/{id}', [UserGame::class, 'show'])->name('game.show')->where('id', '[0-9]+');
    Route::get('/game/search/{q?}', [UserGame::class, 'search'])->name('game.search');


});