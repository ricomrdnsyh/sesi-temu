<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminTemaController;
use App\Http\Controllers\AutentikasiController;
use App\Http\Controllers\DasborUndanganController;
use App\Http\Controllers\HalamanUtamaController;
use App\Http\Controllers\UndanganPublikController;
use App\Http\Middleware\PastikanAdmin;
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

// 3. Area Dasbor Client (Juga bisa diakses Admin untuk Paket Terima Beres)
Route::middleware('auth')->prefix('dasbor')->name('dasbor.')->group(function (): void {
    Route::get('/', [DasborUndanganController::class, 'index'])->name('index');
    Route::post('/undangan', [DasborUndanganController::class, 'simpanUndanganBaru'])->name('undangan.simpan');
    Route::get('/undangan/{undangan}/kelola', [DasborUndanganController::class, 'kelola'])->name('undangan.kelola');
    Route::put('/undangan/{undangan}', [DasborUndanganController::class, 'perbaruiDataUtama'])->name('undangan.perbarui');

    // Sub-fitur di dalam pengelolaan undangan
    Route::post('/undangan/{undangan}/acara', [DasborUndanganController::class, 'simpanAcara'])->name('acara.simpan');
    Route::delete('/undangan/{undangan}/acara/{acara}', [DasborUndanganController::class, 'hapusAcara'])->name('acara.hapus');

    Route::post('/undangan/{undangan}/galeri', [DasborUndanganController::class, 'unggahGaleri'])->name('galeri.unggah');
    Route::delete('/undangan/{undangan}/galeri/{galeri}', [DasborUndanganController::class, 'hapusGaleri'])->name('galeri.hapus');

    Route::post('/undangan/{undangan}/amplop', [DasborUndanganController::class, 'simpanAmplop'])->name('amplop.simpan');
    Route::delete('/undangan/{undangan}/amplop/{amplop}', [DasborUndanganController::class, 'hapusAmplop'])->name('amplop.hapus');

    Route::delete('/undangan/{undangan}/buku-tamu/{ucapan}', [DasborUndanganController::class, 'hapusUcapan'])->name('ucapan.hapus');
});

// 4. Area Panel Admin
Route::middleware(['auth', PastikanAdmin::class])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', [AdminController::class, 'ringkasan'])->name('ringkasan');
    Route::get('/undangan', [AdminController::class, 'daftarUndangan'])->name('undangan.index');
    Route::patch('/undangan/{undangan}/aktifkan', [AdminController::class, 'aktifkanUndangan'])->name('undangan.aktifkan');
    Route::patch('/undangan/{undangan}/nonaktifkan', [AdminController::class, 'nonaktifkanUndangan'])->name('undangan.nonaktifkan');
    Route::post('/bersihkan-kedaluwarsa', [AdminController::class, 'bersihkanKedaluwarsa'])->name('undangan.bersihkan');

    Route::resource('/tema', AdminTemaController::class)->except(['show']);

    Route::get('/pengguna', [AdminController::class, 'daftarPengguna'])->name('pengguna.index');
    Route::patch('/pengguna/{pengguna}/reset-sandi', [AdminController::class, 'resetSandiPengguna'])->name('pengguna.reset-sandi');
});

// 5. Route Publik Undangan & Buku Tamu (WAJIB DI BARIS PALING BAWAH)
Route::post('/{slug}/buku-tamu', [UndanganPublikController::class, 'simpanUcapan'])
    ->middleware('throttle:5,1')
    ->name('undangan.ucapan');

Route::get('/{slug}', [UndanganPublikController::class, 'tampil'])
    ->where('slug', '[a-z0-9-]+')
    ->name('undangan.tampil');
