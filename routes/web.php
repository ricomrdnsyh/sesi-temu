<?php

use App\Http\Controllers\AutentikasiController;
use App\Http\Controllers\HalamanUtamaController;
use Illuminate\Support\Facades\Route;

// 1. Landing Page, Cek Link, & Live Demo
Route::get('/', [HalamanUtamaController::class, 'beranda'])->name('beranda');
Route::post('/cek-link', [HalamanUtamaController::class, 'cekLink'])->name('cek.link');
Route::get('/demo/{slugTema}', [HalamanUtamaController::class, 'demoTema'])->name('tema.demo');

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
