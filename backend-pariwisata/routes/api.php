<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DestinasiController;
use App\Http\Controllers\Api\RekomendasiController;
use App\Http\Controllers\Api\InteractionController;
use App\Http\Controllers\Api\AiProxyController;

Route::get('/destinasi', [DestinasiController::class, 'index']);

// 1. SPK Rekomendasi Adaptif & Radius
Route::get('/rekomendasi', [RekomendasiController::class, 'index']);

// 2. Perekaman Jejak Adaptif
Route::post('/interaksi/log', [InteractionController::class, 'logInteraction']);

// 3. Proxy ke Microservice AI Python
Route::prefix('ai')->group(function () {
    Route::post('/chat', [AiProxyController::class, 'chat']);
    Route::post('/scan', [AiProxyController::class, 'scan']);
});
