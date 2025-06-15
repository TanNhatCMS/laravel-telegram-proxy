<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
use App\Http\Controllers\FlyEnvProxyController;

Route::post('/app/start', [FlyEnvProxyController::class, 'start']);
Route::post('/app/feedback', [FlyEnvProxyController::class, 'feedback']);
Route::post('/version/fetch_version', [FlyEnvProxyController::class, 'fetchVersion']);
Route::post('/version/php_extension', [FlyEnvProxyController::class, 'phpExtension']);
