<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrderController;

Route::resource('order', OrderController::class);
Route::post('/order/notification', [OrderController::class, 'notification'])->name('order.notification');