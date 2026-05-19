<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DestinasiController;
use App\Http\Controllers\KulinerController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BobotController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('kategori', KategoriController::class)->except(['show']);
Route::resource('destinasi', DestinasiController::class)->except(['show']);
Route::resource('kuliner', KulinerController::class)->except(['show']);
Route::get('riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');

Route::get('bobot', [BobotController::class, 'index'])->name('bobot.index');
Route::put('bobot', [BobotController::class, 'update'])->name('bobot.update');
