<?php

use App\Http\Controllers\Admin\AdminBukuTamuController;
use App\Http\Controllers\Admin\AdminLaporanController;
use App\Http\Controllers\Admin\AdminMusikController;
use App\Http\Controllers\Admin\AdminPengaturanController;
use App\Http\Controllers\Admin\AdminPenggunaController;
use App\Http\Controllers\Admin\AdminPromoController;
use App\Http\Controllers\Admin\AdminTransaksiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminTemaController;
use App\Http\Controllers\AutentikasiController;
use App\Http\Controllers\DashboardUndanganController;
use App\Http\Controllers\HalamanUtamaController;
use App\Http\Controllers\UndanganPublikController;
use App\Http\Middleware\PastikanAdmin;
use Illuminate\Support\Facades\Route;

// 1. Landing Page, Cek Link, & Live Demo
Route::get('/', [HalamanUtamaController::class, 'beranda'])->name('beranda');
Route::post('/cek-link', [HalamanUtamaController::class, 'cekLink'])->name('cek.link');
Route::get('/demo/{slugTema}', [HalamanUtamaController::class, 'demoTema'])->name('tema.demo');
Route::get('/kebijakan-privasi', [HalamanUtamaController::class, 'kebijakanPrivasi'])->name('halaman.kebijakan-privasi');
Route::get('/syarat-ketentuan', [HalamanUtamaController::class, 'syaratKetentuan'])->name('halaman.syarat-ketentuan');

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

// 3. Area Dashboard Client (Juga bisa diakses Admin untuk Paket Terima Beres)
Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function (): void {
    Route::get('/', [DashboardUndanganController::class, 'index'])->name('index');
    Route::get('/undangan', [DashboardUndanganController::class, 'daftarUndangan'])->name('undangan.index');
    Route::get('/tamu', [DashboardUndanganController::class, 'tamu'])->name('tamu.index');
    Route::get('/rsvp', [DashboardUndanganController::class, 'rsvp'])->name('rsvp.index');
    Route::get('/katalog', [DashboardUndanganController::class, 'katalog'])->name('katalog');
    Route::post('/katalog/terapkan-tema', [DashboardUndanganController::class, 'terapkanTema'])->name('katalog.terapkan');
    Route::get('/profil', [DashboardUndanganController::class, 'profil'])->name('profil.tampil');
    Route::put('/profil', [DashboardUndanganController::class, 'perbaruiProfil'])->name('profil.perbarui');
    Route::post('/undangan', [DashboardUndanganController::class, 'simpanUndanganBaru'])->name('undangan.simpan');
    Route::get('/undangan/{undangan}/kelola', [DashboardUndanganController::class, 'kelola'])->name('undangan.kelola');
    Route::get('/undangan/{undangan}/tamu', [DashboardUndanganController::class, 'tamuUndangan'])->name('undangan.tamu');
    Route::get('/undangan/{undangan}/rsvp', [DashboardUndanganController::class, 'rsvpUndangan'])->name('undangan.rsvp');
    Route::get('/undangan/{undangan}/pratinjau-tema/{tema}', [DashboardUndanganController::class, 'pratinjauTema'])->name('undangan.pratinjau-tema');
    Route::post('/undangan/{undangan}/pratinjau-langsung', [DashboardUndanganController::class, 'pratinjauLangsung'])->name('undangan.pratinjau-langsung');
    Route::patch('/undangan/{undangan}/tema', [DashboardUndanganController::class, 'gantiTema'])->name('undangan.ganti-tema');
    Route::put('/undangan/{undangan}', [DashboardUndanganController::class, 'perbaruiDataUtama'])->name('undangan.perbarui');
    Route::delete('/undangan/{undangan}', [DashboardUndanganController::class, 'hapusUndangan'])->name('undangan.hapus');

    // Sub-fitur di dalam pengelolaan undangan
    Route::post('/undangan/{undangan}/acara', [DashboardUndanganController::class, 'simpanAcara'])->name('acara.simpan');
    Route::delete('/undangan/{undangan}/acara/{acara}', [DashboardUndanganController::class, 'hapusAcara'])->name('acara.hapus');

    Route::post('/undangan/{undangan}/galeri', [DashboardUndanganController::class, 'unggahGaleri'])->name('galeri.unggah');
    Route::delete('/undangan/{undangan}/galeri/{galeri}', [DashboardUndanganController::class, 'hapusGaleri'])->name('galeri.hapus');

    Route::post('/undangan/{undangan}/amplop', [DashboardUndanganController::class, 'simpanAmplop'])->name('amplop.simpan');
    Route::delete('/undangan/{undangan}/amplop/{amplop}', [DashboardUndanganController::class, 'hapusAmplop'])->name('amplop.hapus');

    Route::post('/undangan/{undangan}/tamu', [DashboardUndanganController::class, 'simpanTamu'])->name('tamu.simpan');
    Route::post('/undangan/{undangan}/tamu/kategori', [DashboardUndanganController::class, 'simpanKategoriTamu'])->name('tamu.kategori.simpan');
    Route::delete('/undangan/{undangan}/tamu/kategori/{kategori}', [DashboardUndanganController::class, 'hapusKategoriTamu'])->name('tamu.kategori.hapus');
    Route::put('/undangan/{undangan}/tamu/template-pesan', [DashboardUndanganController::class, 'simpanTemplatePesanTamu'])->name('tamu.template-pesan');
    Route::get('/undangan/{undangan}/tamu/template-csv', [DashboardUndanganController::class, 'unduhTemplateCsvTamu'])->name('tamu.template-csv');
    Route::get('/undangan/{undangan}/tamu/ekspor', [DashboardUndanganController::class, 'eksporTamu'])->name('tamu.ekspor');
    Route::put('/undangan/{undangan}/tamu/{tamu}', [DashboardUndanganController::class, 'perbaruiTamu'])->name('tamu.perbarui');
    Route::patch('/undangan/{undangan}/tamu/{tamu}/status-kirim', [DashboardUndanganController::class, 'tandaiStatusKirimTamu'])->name('tamu.status-kirim');
    Route::delete('/undangan/{undangan}/tamu/{tamu}', [DashboardUndanganController::class, 'hapusTamu'])->name('tamu.hapus');

    Route::delete('/undangan/{undangan}/buku-tamu/{ucapan}', [DashboardUndanganController::class, 'hapusUcapan'])->name('ucapan.hapus');

    Route::post('/undangan/{undangan}/promo/cek', [DashboardUndanganController::class, 'cekPromo'])->name('transaksi.cek-promo');
    Route::post('/undangan/{undangan}/transaksi', [DashboardUndanganController::class, 'ajukanTransaksi'])->name('transaksi.ajukan');
    Route::post('/transaksi/{transaksi}/unggah-bukti', [DashboardUndanganController::class, 'unggahBuktiTransaksi'])->name('transaksi.unggah');
});

// 4. Area Panel Admin
Route::middleware(['auth', PastikanAdmin::class])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', [AdminController::class, 'ringkasan'])->name('ringkasan');
    Route::get('/undangan', [AdminController::class, 'daftarUndangan'])->name('undangan.index');
    Route::patch('/undangan/{undangan}/aktifkan', [AdminController::class, 'aktifkanUndangan'])->name('undangan.aktifkan');
    Route::patch('/undangan/{undangan}/nonaktifkan', [AdminController::class, 'nonaktifkanUndangan'])->name('undangan.nonaktifkan');
    Route::post('/bersihkan-kedaluwarsa', [AdminController::class, 'bersihkanKedaluwarsa'])->name('undangan.bersihkan');

    Route::get('/transaksi', [AdminTransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('/transaksi', [AdminTransaksiController::class, 'store'])->name('transaksi.store');
    Route::patch('/transaksi/{transaksi}/verifikasi', [AdminTransaksiController::class, 'verifikasi'])->name('transaksi.verifikasi');
    Route::patch('/transaksi/{transaksi}/tolak', [AdminTransaksiController::class, 'tolak'])->name('transaksi.tolak');

    Route::get('/buku-tamu', [AdminBukuTamuController::class, 'index'])->name('buku-tamu.index');
    Route::delete('/buku-tamu/{ucapan}', [AdminBukuTamuController::class, 'destroy'])->name('buku-tamu.destroy');

    Route::post('/tema-diskon-massal', [AdminTemaController::class, 'terapkanDiskonMassal'])->name('tema.diskon-massal');
    Route::post('/tema-reset-diskon', [AdminTemaController::class, 'resetDiskonMassal'])->name('tema.reset-diskon');
    Route::resource('/tema', AdminTemaController::class)->except(['show']);

    Route::get('/musik', [AdminMusikController::class, 'index'])->name('musik.index');
    Route::post('/musik', [AdminMusikController::class, 'store'])->name('musik.store');
    Route::patch('/musik/{musik}/toggle', [AdminMusikController::class, 'toggle'])->name('musik.toggle');
    Route::delete('/musik/{musik}', [AdminMusikController::class, 'destroy'])->name('musik.destroy');

    Route::get('/promo', [AdminPromoController::class, 'index'])->name('promo.index');
    Route::post('/promo', [AdminPromoController::class, 'store'])->name('promo.store');
    Route::patch('/promo/{promo}/toggle', [AdminPromoController::class, 'toggle'])->name('promo.toggle');
    Route::delete('/promo/{promo}', [AdminPromoController::class, 'destroy'])->name('promo.destroy');

    Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/ekspor', [AdminLaporanController::class, 'eksporCsv'])->name('laporan.ekspor');

    Route::resource('/pengguna', AdminPenggunaController::class);
    Route::patch('/pengguna/{pengguna}/reset-sandi', [AdminController::class, 'resetSandiPengguna'])->name('pengguna.reset-sandi');

    Route::get('/pengaturan', [AdminPengaturanController::class, 'index'])->name('pengaturan.index');
    Route::put('/pengaturan', [AdminPengaturanController::class, 'update'])->name('pengaturan.update');
});

// 5. Route Publik Undangan & Buku Tamu (WAJIB DI BARIS PALING BAWAH)
Route::post('/{slug}/buku-tamu', [UndanganPublikController::class, 'simpanUcapan'])
    ->middleware('throttle:5,1')
    ->name('undangan.ucapan');

Route::get('/{slug}', [UndanganPublikController::class, 'tampil'])
    ->where('slug', '[a-z0-9-]+')
    ->name('undangan.tampil');
