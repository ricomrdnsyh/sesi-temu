<?php

use App\Http\Controllers\AutentikasiController;
use Illuminate\Support\Facades\Route;

// 1. Landing Page sementara (akan diganti HalamanUtamaController di Tahap 3)
Route::get('/', function () {
    return view('welcome');
})->name('beranda');

// 2. Autentikasi Pengguna (Tanpa Breeze)
Route::middleware('guest')->group(function (): void {
    Route::get('/masuk', [AutentikasiController::class, 'formMasuk'])->name('login');
    Route::post('/masuk', [AutentikasiController::class, 'prosesMasuk'])->name('masuk.proses');
    Route::get('/daftar', [AutentikasiController::class, 'formDaftar'])->name('daftar');
    Route::post('/daftar', [AutentikasiController::class, 'prosesDaftar'])->name('daftar.proses');
});

Route::post('/keluar', [AutentikasiController::class, 'keluar'])
    ->middleware('auth')
    ->name('keluar');
