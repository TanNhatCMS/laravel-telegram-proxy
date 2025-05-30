<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TelegramProxyController;

Route::get('/', [TelegramProxyController::class, 'index'])->name('home');

Route::any('/bot{token}/{method?}', [TelegramProxyController::class, 'proxy'])
    ->where('method', '.*');
