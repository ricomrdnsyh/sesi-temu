# Desain Ekspansi 6 Modul Panel Admin Terintegrasi SesiTemu

**Tanggal:** 2026-11-16  
**Pendekatan:** Pendekatan A — Controller Modular per Domain + Layanan/Model Bersama (`PengaturanPlatform`, `LayananTransaksiService`)  
**Status:** Disetujui untuk eksekusi

## 1. Tujuan & Cakupan
Memperluas Panel Admin SesiTemu dari 4 menu dasar menjadi panel operasional lengkap dengan 6 modul baru yang terintegrasi penuh dengan sisi Client (`Dasbor Client`) dan `Beranda`:
1. **Pengaturan Platform** (`/admin/pengaturan`)
2. **Musik Latar** (`/admin/musik`)
3. **Promo & Voucher** (`/admin/promo`)
4. **Transaksi & Pembayaran** (`/admin/transaksi` + pengajuan order/checkout dari `Dasbor Client`)
5. **Buku Tamu & RSVP** (`/admin/buku-tamu`)
6. **Laporan & Analitik** (`/admin/laporan` + ekspor CSV)

## 2. Arsitektur & Skema Basis Data

### 2.1 Tabel Baru (4 Migrasi Idempotent)
1. **`pengaturan_platform`** (`kunci` string unique, `nilai` text nullable, `keterangan` string nullable, timestamps)
   - Nilai bawaan otomatis (seed idempotent dalam migrasi):
     - `nomor_wa_admin`: `6281234567890`
     - `masa_aktif_bulan`: `3`
     - `biaya_terima_beres`: `50000`
     - `nama_bank_pembayaran`: `BCA`
     - `nomor_rekening_pembayaran`: `1234567890`
     - `atas_nama_rekening`: `PT SesiTemu Digital`
     - `catatan_pembayaran`: `Cantumkan slug undangan pada berita acara transfer lalu unggah bukti pembayaran atau konfirmasi via WhatsApp.`
2. **`musik_latar`** (`judul`, `artis` nullable, `path_file` unique, `kategori` nullable, `aktif` boolean default true, `urutan` unsignedSmallInteger default 1, timestamps)
   - Sinkronisasi bawaan idempotent untuk `musik/romantis-akustik.mp3`, `musik/gamelan-lembut.mp3`, `musik/instrumen-islami.mp3`.
3. **`promo`** (`kode` unique uppercase, `nama_promo`, `tipe_diskon` enum `nominal|persen`, `nilai_diskon` unsignedInteger, `maksimal_diskon` unsignedInteger nullable, `kuota` unsignedInteger nullable, `jumlah_terpakai` unsignedInteger default 0, `berlaku_mulai` date nullable, `berlaku_sampai` date nullable, `aktif` boolean default true, timestamps)
4. **`transaksi`** (`kode_invoice` unique, `undangan_id` FK, `pengguna_id` FK, `tema_id` FK, `promo_id` nullable FK `nullOnDelete`, `paket` enum `mandiri|terima_beres`, `harga_tema`, `biaya_jasa`, `potongan_promo`, `total_bayar`, `status` enum `menunggu_pembayaran|menunggu_verifikasi|lunas|ditolak`, `bukti_pembayaran` nullable, `catatan_admin` nullable, `diverifikasi_oleh` nullable FK `pengguna` `nullOnDelete`, `diverifikasi_pada` timestamp nullable, timestamps)

### 2.2 Komponen Bersama (Shared Domain Services & Models)
- `App\Support\PengaturanSesiTemu`:
  - Membaca konfigurasi dari tabel `pengaturan_platform` secara aman (aman meski tabel belum dimigrasi / fallback konstanta).
  - Menyediakan helper terpusat: `semua()`, `ambil()`, `simpanBulk()`, `nomorWaAdmin()`, `urlWaAdmin()`, `masaAktifBulan()`, `biayaTerimaBeres()`, `infoRekening()`.
  - Dipakai oleh `AdminController` (durasi aktif), `HalamanUtamaController`, `beranda.blade.php`, `dasbor/index.blade.php`, `dasbor/kelola.blade.php`, dan `LayananTransaksiService`.
- `App\Services\LayananTransaksiService`:
  - Menghitung komponen biaya (`harga_tema`, `biaya_jasa`, `potongan_promo`, `total_bayar`).
  - Memvalidasi kelayakan `Promo` (aktif, dalam rentang tanggal, masih memiliki kuota).
  - Membuat invoice unik `INV-YYYYMMDD-XXXX` saat Client mengajukan order atau Admin mencatat order manual.
  - Memverifikasi lunas transaksi secara atomik (`DB::transaction`): menandai transaksi `lunas`, menaikkan `jumlah_terpakai` promo jika ada, memperbarui `tema_id` undangan bila berbeda, dan mengaktifkan undangan (`status_publikasi = true`, `berlaku_sampai = now()->addMonths(masaAktifBulan())`).

### 2.3 Controller & Routes Admin (`/admin/...`)
- `AdminTransaksiController`: daftar transaksi DataTables (`GET /admin/transaksi`), simpan order manual (`POST /admin/transaksi`), verifikasi lunas & aktifkan (`PATCH /admin/transaksi/{transaksi}/verifikasi`), tolak transaksi (`PATCH /admin/transaksi/{transaksi}/tolak`).
- `AdminBukuTamuController`: daftar ucapan & RSVP lintas undangan DataTables (`GET /admin/buku-tamu`) dengan filter undangan/status kehadiran + hapus spam (`DELETE /admin/buku-tamu/{ucapan}`).
- `AdminMusikController`: CRUD daftar musik latar (`GET /admin/musik`, `POST`, `PUT`, `DELETE`) termasuk upload MP3 (`storage/musik/...`) dan audio preview.
- `AdminPromoController`: CRUD voucher & promo (`GET /admin/promo`, `POST`, `PUT`, `PATCH toggle`, `DELETE`).
- `AdminLaporanController`: analitik omzet lunas & pending, konversi paket, tren bulanan undangan & transaksi, tema terlaris, komposisi tier, undangan hampir/sudah kedaluwarsa (`GET /admin/laporan`), serta unduh CSV (`GET /admin/laporan/ekspor`).
- `AdminPengaturanController`: tampilan & simpan form pengaturan platform (`GET /admin/pengaturan`, `PUT /admin/pengaturan`).

### 2.4 Integrasi Sisi Client (`DasborUndanganController` & `dasbor/*`)
- `DasborUndanganController@index`: menyertakan riwayat/status transaksi per undangan serta info nomor WA, biaya Terima Beres, & rekening dari `PengaturanSesiTemu`.
- `DasborUndanganController@kelola`: membaca daftar musik aktif dari model `MusikLatar` (fallback ke `public/musik/*.mp3` bila tabel kosong), menampilkan form/kartu **Aktivasi & Pembayaran** (pilih paket Mandiri/Terima Beres, input kode voucher opsional, info total estimasi & rekening bank, unggah bukti pembayaran).
- Endpoint client baru di group `auth`:
  - `POST /dasbor/undangan/{undangan}/transaksi`: buat pengajuan transaksi / simpan order + opsional upload bukti bayar (webp/jpg/png).
  - `POST /dasbor/transaksi/{transaksi}/unggah-bukti`: unggah / perbarui bukti transfer pada transaksi yang masih `menunggu_pembayaran` atau `ditolak`.

### 2.5 UI/UX Admin Panel
- Sidebar [tata-letak.blade.php](file:///c:/laragon/www/sesi-temu/resources/views/admin/tata-letak.blade.php) dikelompokkan rapi:
  - `MAIN`: `Dashboard`
  - `LAYANAN`: `Undangan`, `Transaksi`, `Buku Tamu & RSVP`
  - `KATALOG & ASET`: `Katalog Tema`, `Musik Latar`, `Promo & Voucher`
  - `SISTEM & LAPORAN`: `Laporan & Analitik`, `Pengguna`, `Pengaturan`
  - `PINTASAN`: `Lihat Beranda`, `Dasbor Client`
- Seluruh tabel daftar admin baru memakai DataTables (`data-datatable`), kolom **Aksi** rata tengah di paling kiri lengkap dengan ikon, serta konfirmasi/loading/sukses SweetAlert2.
