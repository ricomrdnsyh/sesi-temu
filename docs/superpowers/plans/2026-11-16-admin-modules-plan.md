# Ekspansi 6 Modul Panel Admin Terintegrasi SesiTemu Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Menambahkan 6 modul admin terintegrasi (`Pengaturan Platform`, `Musik Latar`, `Promo & Voucher`, `Transaksi & Pembayaran`, `Buku Tamu & RSVP`, `Laporan & Analitik`) beserta integrasi penuh ke Client (`Dasbor Client`) dan `Beranda`.

**Architecture:** Menggunakan Controller modular per domain dengan dua komponen inti bersama (`PengaturanSesiTemu` untuk konfigurasi dinamis & `LayananTransaksiService` untuk kalkulasi harga/kupon/verifikasi atomik) serta mempertahankan standar SesiTemu (`Poppins`, DataTables berkolom aksi kiri rata tengah, dan SweetAlert2).

**Tech Stack:** Laravel 12 (PHP 8.2+), Blade, Alpine.js, Tailwind CSS v4, DataTables (`datatables.net-dt`), SweetAlert2, PHPUnit, Laravel Pint.

## Global Constraints

- Semua struktur kontrol PHP memakai kurung kurawal `{}` dan pengetikan parameter/return eksplisit.
- Kolom **Aksi** pada semua tabel DataTables berada di paling kiri (`<th data-no-sort class="py-3 dt-center text-center">`), memiliki ikon + teks jelas, tanpa baris kosong `colspan` manual.
- Semua tombol aksi penting memakai `data-swal-confirm` + `data-swal-loading-title` agar memicu konfirmasi & spinner SweetAlert2, dan redirect membawa flash `sukses`.
- Route publik `/{slug}` di `routes/web.php` wajib tetap di baris paling bawah.

---

### Task 1: Migrasi Database, Model Inti & Helper Bersama (`PengaturanSesiTemu`, `MusikLatar`, `Promo`, `Transaksi`)
- **Files:**
  - Create: `database/migrations/2026_11_16_000001_create_pengaturan_platform_table.php`
  - Create: `database/migrations/2026_11_16_000002_create_musik_latar_table.php`
  - Create: `database/migrations/2026_11_16_000003_create_promo_table.php`
  - Create: `database/migrations/2026_11_16_000004_create_transaksi_table.php`
  - Create: `app/Models/PengaturanPlatform.php`, `app/Models/MusikLatar.php`, `app/Models/Promo.php`, `app/Models/Transaksi.php`
  - Create: `app/Support/PengaturanSesiTemu.php`
  - Modify: `app/Models/Undangan.php`, `app/Models/Tema.php`, `app/Models/Pengguna.php`, `database/seeders/DatabaseSeeder.php`
  - Verify: Jalankan `php artisan migrate` dan unit/feature tests awal.

### Task 2: `LayananTransaksiService` & Integrasi `PengaturanSesiTemu` / `MusikLatar` di Backend
- **Files:**
  - Create: `app/Services/LayananTransaksiService.php`
  - Modify: `app/Http/Controllers/AdminController.php` (`aktifkanUndangan` memakai durasi `PengaturanSesiTemu::masaAktifBulan()`, `ringkasan` memakai metrik omzet/transaksi terbaru bila bermanfaat)
  - Modify: `app/Http/Controllers/HalamanUtamaController.php` (passing biaya Terima Beres dinamis & info WA dinamis)
  - Modify: `app/Http/Controllers/DasborUndanganController.php` (`ambilDaftarMusik()` membaca `MusikLatar` aktif, `index` & `kelola` membawa info pengaturan & transaksi undangan, endpoint client `ajukanTransaksi` & `unggahBuktiTransaksi`)

### Task 3: Controllers & Routes Panel Admin (6 Modul)
- **Files:**
  - Create: `app/Http/Controllers/Admin/AdminTransaksiController.php`
  - Create: `app/Http/Controllers/Admin/AdminBukuTamuController.php`
  - Create: `app/Http/Controllers/Admin/AdminMusikController.php`
  - Create: `app/Http/Controllers/Admin/AdminPromoController.php`
  - Create: `app/Http/Controllers/Admin/AdminLaporanController.php`
  - Create: `app/Http/Controllers/Admin/AdminPengaturanController.php`
  - Modify: `routes/web.php` (tambahkan route admin & client di atas route publik `/{slug}`)

### Task 4: Tampilan Sidebar Admin & Views 6 Modul Admin
- **Files:**
  - Modify: `resources/views/admin/tata-letak.blade.php` (pengelompokan sidebar `MAIN`, `LAYANAN`, `KATALOG & ASET`, `SISTEM & LAPORAN`, `PINTASAN` + pemetaan judul header halaman baru)
  - Create: `resources/views/admin/transaksi/index.blade.php`
  - Create: `resources/views/admin/buku-tamu/index.blade.php`
  - Create: `resources/views/admin/musik/index.blade.php`
  - Create: `resources/views/admin/promo/index.blade.php`
  - Create: `resources/views/admin/laporan/index.blade.php`
  - Create: `resources/views/admin/pengaturan/index.blade.php`

### Task 5: Integrasi UI Beranda & Dasbor Client
- **Files:**
  - Modify: `resources/views/beranda.blade.php` (link WhatsApp admin dinamis dari `PengaturanSesiTemu`)
  - Modify: `resources/views/dasbor/index.blade.php` (tampilkan status transaksi/invoice terakhir & WA dinamis)
  - Modify: `resources/views/dasbor/kelola.blade.php` (tab/kartu Pembayaran & Aktivasi Terpadu: pilih paket Mandiri/Terima Beres, kode promo, upload bukti transfer, info rekening & WA CS dinamis)

### Task 6: Pengujian Komprehensif, Formatting Pint, Build Vite, Clear Cache & Commit
- **Files:**
  - Create: `tests/Feature/PanelAdminEkspansiTest.php`
  - Modify: `tests/Feature/LogoBrandingTest.php` (pastikan cek semua 10 rute admin tetap konsisten dengan sidebar & header)
  - Verify: `npm run build`, `php vendor/bin/pint`, `php artisan test`, `php artisan view:clear`, commit bersih.
