# PRODUCT REQUIREMENTS DOCUMENT (PRD)
## Nama Produk: SesiTemu (Platform SaaS Undangan Pernikahan Digital)
## Tagline: "Abadikan Setiap Sesi Bahagia Menuju Hari Pertemuan"
## Target Domain: sesitemu.id

---

## 1. ATURAN ARSITEKTUR KETAT (STRICT AI CODING GUARDRAILS)
AI Agent di Antigravity WAJIB mematuhi seluruh batasan berikut selama menulis kode:

1. **100% Native Laravel (Tanpa Package Pihak Ketiga Berat):**
   - **DILARANG** menginstal atau menggunakan **Filament**, **Spatie** (`laravel-permission`, `laravel-medialibrary`, `laravel-sluggable`), maupun **Laravel Breeze / Jetstream / Fortify**.
   - Gunakan fitur bawaan Laravel: manual Session Auth (`Auth` & `Hash` facade), `Middleware`, `Policy`, `Storage` facade, `Str::slug()`, dan `RateLimiter` (`throttle`).
2. **Sistem 2 Peran (`admin` dan `client`):**
   - Sistem hanya memiliki 2 role pada kolom `peran` di tabel `pengguna`, yaitu `'admin'` (pengelola platform) dan `'client'` (pemesan/calon pengantin).
   - Default nilai `peran` saat registrasi mandiri adalah `'client'`.
3. **Konvensi Penamaan Bahasa Indonesia:**
   - Seluruh nama tabel database, kolom database, Model Eloquent, Controller, Middleware, Policy, dan Route menggunakan **Bahasa Indonesia** (kecuali istilah standar `'admin'` dan `'client'`).
   - Setiap Model Eloquent WAJIB mendeklarasikan `protected $table = 'nama_tabel';` secara eksplisit.
   - Setiap relasi (`belongsTo`, `hasMany`) dan migrasi (`constrained()`) WAJIB menyertakan nama tabel dan *foreign key* Bahasa Indonesia secara eksplisit.
4. **Kustomisasi Model Autentikasi:**
   - Tabel autentikasi utama bernama `pengguna` dengan model `App\Models\Pengguna`.
   - Kolom password bernama `kata_sandi`. Model `Pengguna` wajib meng-override method `getAuthPasswordName()` yang mengembalikan `'kata_sandi'`, dan `config/auth.php` wajib diarahkan ke `App\Models\Pengguna::class`.
   - Route halaman masuk (`/masuk`) wajib tetap diberi nama `->name('login')` agar kompatibel dengan redirect bawaan middleware `auth` Laravel.
5. **Tech Stack Frontend:**
   - Gunakan **Blade Template Engine** + **Tailwind CSS** + **Alpine.js** untuk Landing Page, Dasbor Client, dan Panel Admin.
   - Gunakan **Blade** + **Alpine.js / Vanilla JS** + **AOS.js (Animate On Scroll via CDN)** + **Pure CSS Keyframes** untuk halaman tema undangan publik agar ringan dan mulus di perangkat mobile.

---

## 2. STRUKTUR DIREKTORI PROYEK

```text
app/
├── Console/Commands/
│   └── BersihkanUndanganKedaluwarsa.php   # Scheduler hapus foto undangan expired
├── Http/
│   ├── Controllers/
│   │   ├── HalamanUtamaController.php     # Landing page, cek link, & live demo
│   │   ├── AutentikasiController.php      # Masuk, daftar, keluar (Tanpa Breeze)
│   │   ├── DasborUndanganController.php   # Area client: kelola undangan, acara, galeri, amplop, tamu
│   │   ├── AdminController.php            # Area admin: aktivasi undangan, kelola pengguna
│   │   ├── AdminTemaController.php        # Area admin: CRUD katalog tema
│   │   └── UndanganPublikController.php   # Render undangan publik & simpan RSVP buku tamu
│   └── Middleware/
│       └── PastikanAdmin.php              # Memastikan $pengguna->peran === 'admin'
├── Models/
│   ├── Pengguna.php
│   ├── Tema.php
│   ├── Undangan.php
│   ├── AcaraUndangan.php
│   ├── GaleriUndangan.php
│   ├── AmplopDigital.php
│   └── BukuTamu.php
├── Policies/
│   └── UndanganPolicy.php                 # Otorisasi pemilik undangan (client) & bypass Admin
└── Services/
    └── PengolahGambarService.php          # Kompresi upload foto ke .webp via PHP GD

public/
├── aset-demo/                             # Foto mempelai, galeri & MP3 contoh untuk Live Preview
├── aset-tema/                             # Ornamen bunga/bingkai (.webp) per tema
└── musik/                                 # Katalog lagu latar (.mp3) bawaan

resources/views/
├── beranda.blade.php                      # Landing page promosi SesiTemu
├── autentikasi/
│   ├── masuk.blade.php
│   └── daftar.blade.php
├── dasbor/                                # Halaman kelola undangan untuk Client
│   ├── index.blade.php
│   └── kelola.blade.php
├── admin/                                 # Halaman kelola platform untuk Admin
│   ├── ringkasan.blade.php
│   ├── undangan/index.blade.php
│   ├── tema/index.blade.php
│   └── pengguna/index.blade.php
├── komponen-undangan/                     # Komponen global lintas tema
│   ├── hitung-mundur.blade.php
│   ├── pemutar-musik.blade.php
│   └── modal-galeri.blade.php
└── tema/                                  # Folder desain undangan (multi-theme)
    ├── rustic-floral/index.blade.php
    ├── adat-jawa/index.blade.php
    └── islami-syari/index.blade.php
```

---

## 3. SPESIFIKASI SKEMA DATABASE (7 TABEL BAHASA INDONESIA)

Buat skema database dalam satu atau beberapa file migrasi dengan struktur persis seperti berikut:

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Pengguna (Pengganti users)
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('email')->unique();
            $table->string('nomor_wa', 20)->nullable();
            $table->string('kata_sandi');
            $table->enum('peran', ['admin', 'client'])->default('client');
            $table->rememberToken();
            $table->timestamps();
        });

        // Tabel Sessions Bawaan Laravel
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // 2. Tabel Tema Undangan
        Schema::create('tema', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tema'); // Contoh: Rustic Floral
            $table->string('slug')->unique(); // Contoh: rustic-floral
            $table->enum('kategori', ['modern', 'adat', 'islami'])->default('modern');
            $table->string('lokasi_view'); // Contoh: tema.rustic-floral.index
            $table->string('gambar_pratinjau')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // 3. Tabel Utama Undangan
        Schema::create('undangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('pengguna')->cascadeOnDelete();
            $table->foreignId('tema_id')->constrained('tema');
            $table->string('slug')->unique(); // Contoh: sesitemu.id/dimas-rani

            // Data Mempelai Pria
            $table->string('nama_panggilan_pria');
            $table->string('nama_lengkap_pria');
            $table->string('nama_ayah_pria')->nullable();
            $table->string('nama_ibu_pria')->nullable();
            $table->string('foto_pria')->nullable();

            // Data Mempelai Wanita
            $table->string('nama_panggilan_wanita');
            $table->string('nama_lengkap_wanita');
            $table->string('nama_ayah_wanita')->nullable();
            $table->string('nama_ibu_wanita')->nullable();
            $table->string('foto_wanita')->nullable();

            // Konten & Pengaturan Fleksibel
            $table->text('kutipan_ayat')->nullable();
            $table->string('musik_latar')->nullable();
            $table->json('pengaturan')->nullable();

            // Status Publikasi & Masa Aktif
            $table->boolean('status_publikasi')->default(false);
            $table->timestamp('berlaku_sampai')->nullable();
            $table->timestamps();
        });

        // 4. Tabel Acara Undangan (One-to-Many)
        Schema::create('acara_undangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('undangan_id')->constrained('undangan')->cascadeOnDelete();
            $table->string('nama_acara'); // Akad Nikah, Resepsi, Ngunduh Mantu
            $table->date('tanggal_acara');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai')->nullable();
            $table->string('zona_waktu', 10)->default('WIB'); // WIB, WITA, WIT
            $table->string('nama_tempat');
            $table->text('alamat_lengkap');
            $table->text('link_maps')->nullable();
            $table->timestamps();
        });

        // 5. Tabel Galeri Foto (One-to-Many)
        Schema::create('galeri_undangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('undangan_id')->constrained('undangan')->cascadeOnDelete();
            $table->string('lokasi_foto'); // Disimpan dalam format .webp
            $table->string('keterangan')->nullable();
            $table->unsignedSmallInteger('urutan')->default(1);
            $table->timestamps();
        });

        // 6. Tabel Amplop Digital (One-to-Many)
        Schema::create('amplop_digital', function (Blueprint $table) {
            $table->id();
            $table->foreignId('undangan_id')->constrained('undangan')->cascadeOnDelete();
            $table->string('nama_bank'); // BCA, Mandiri, GoPay, DANA
            $table->string('nomor_rekening');
            $table->string('atas_nama');
            $table->timestamps();
        });

        // 7. Tabel Buku Tamu & RSVP (One-to-Many)
        Schema::create('buku_tamu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('undangan_id')->constrained('undangan')->cascadeOnDelete();
            $table->string('nama_tamu');
            $table->enum('status_kehadiran', ['hadir', 'tidak_hadir', 'ragu'])->default('hadir');
            $table->unsignedTinyInteger('jumlah_tamu')->default(1);
            $table->text('ucapan_doa');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_tamu');
        Schema::dropIfExists('amplop_digital');
        Schema::dropIfExists('galeri_undangan');
        Schema::dropIfExists('acara_undangan');
        Schema::dropIfExists('undangan');
        Schema::dropIfExists('tema');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('pengguna');
    }
};
```

### Struktur JSON pada Kolom `undangan.pengaturan`:
```json
{
  "cerita_cinta": [
    {"judul": "Pertama Bertemu", "tanggal": "2023", "cerita": "Kami bertemu pertama kali di..."},
    {"judul": "Lamaran", "tanggal": "2026", "cerita": "Memutuskan untuk mengikat janji..."}
  ],
  "live_streaming": {
    "aktif": false,
    "platform": "Instagram / YouTube",
    "link": ""
  },
  "alamat_kado_fisik": "",
  "fitur_aktif": {
    "hitung_mundur": true,
    "cerita_cinta": true,
    "galeri": true,
    "amplop_digital": true,
    "buku_tamu": true
  }
}
```

---

## 4. SPESIFIKASI MODEL, MIDDLEWARE & POLICY

### 4.1. Model `Pengguna` (`app/Models/Pengguna.php`)
```php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengguna extends Authenticatable
{
    protected $table = 'pengguna';

    protected $fillable = [
        'nama',
        'email',
        'nomor_wa',
        'kata_sandi',
        'peran',
    ];

    protected $hidden = [
        'kata_sandi',
        'remember_token',
    ];

    public function getAuthPasswordName(): string
    {
        return 'kata_sandi';
    }

    public function undangan(): HasMany
    {
        return $this->hasMany(Undangan::class, 'pengguna_id');
    }

    public function adalahAdmin(): bool
    {
        return $this->peran === 'admin';
    }

    public function adalahClient(): bool
    {
        return $this->peran === 'client';
    }
}
```

### 4.2. Model `GaleriUndangan` dengan Auto-Delete File (`app/Models/GaleriUndangan.php`)
Saat baris galeri dihapus dari database, file fisik `.webp` wajib otomatis dihapus dari storage:
```php
protected static function booted(): void
{
    static::deleting(function (GaleriUndangan $galeri) {
        if ($galeri->lokasi_foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($galeri->lokasi_foto)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($galeri->lokasi_foto);
        }
    });
}
```

### 4.3. Middleware `PastikanAdmin` (`app/Http/Middleware/PastikanAdmin.php`)
```php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PastikanAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user() || ! $request->user()->adalahAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini khusus Administrator.');
        }

        return $next($request);
    }
}
```

### 4.4. Policy `UndanganPolicy` (`app/Policies/UndanganPolicy.php`)
Mengatur agar **Client** hanya bisa mengelola undangan miliknya sendiri, sedangkan **Admin** bisa mengelola undangan milik seluruh client (untuk melayani *Paket Terima Beres*):
```php
namespace App\Policies;

use App\Models\Pengguna;
use App\Models\Undangan;

class UndanganPolicy
{
    public function before(Pengguna $pengguna, string $ability): ?bool
    {
        if ($pengguna->adalahAdmin()) {
            return true;
        }
        return null;
    }

    public function kelola(Pengguna $pengguna, Undangan $undangan): bool
    {
        return $pengguna->id === $undangan->pengguna_id;
    }

    public function hapus(Pengguna $pengguna, Undangan $undangan): bool
    {
        return $pengguna->id === $undangan->pengguna_id && ! $undangan->status_publikasi;
    }
}
```

---

## 5. MATRIKS HAK AKSES (`client` vs `admin`)

| Modul / Fitur | Client (`peran = 'client'`) | Admin (`peran = 'admin'`) | Aturan Sistem |
| :--- | :---: | :---: | :--- |
| **Membuat Draft Undangan** | Ya | Ya | Client buat mandiri; Admin bisa buatkan untuk *Paket Terima Beres*. |
| **Edit Mempelai, Acara, Galeri, Amplop** | Ya *(Milik Sendiri)* | Ya *(Semua Client)* | Dibatasi oleh `UndanganPolicy@kelola`. |
| **Ganti Tema Undangan** | Ya | Ya | Bisa diganti kapan saja tanpa kehilangan data yang sudah diisi. |
| **Ubah Slug URL Undangan** | Hanya saat Draft | Kapan saja | Jika `status_publikasi == true`, client tidak bisa mengubah slug. |
| **Lihat Live Preview Undangan** | Ya *(Ber-watermark)* | Ya | Draft tampil dengan pita watermark *"PRATINJAU SESITEMU.ID"*. |
| **Aktifkan Undangan (`status_publikasi`)** | Tidak | Ya | Tombol aktifkan di client mengarah ke WhatsApp Admin. |
| **Atur Masa Aktif (`berlaku_sampai`)** | Tidak | Ya | Hanya Admin yang bisa mengaktifkan & memperpanjang masa aktif. |
| **Generator Link Nama Tamu & WA** | Ya | Ya | Menghasilkan link `?to=Nama+Tamu` dan tombol kirim WA. |
| **Rekap RSVP & Hapus Komentar** | Ya *(Milik Sendiri)* | Ya *(Semua Client)* | Menghapus komentar spam/salah ketik di buku tamu. |
| **Kelola Master Katalog Tema** | Tidak | Ya | CRUD tema di `/admin/tema`. |
| **Kelola Pengguna & Reset Sandi** | Tidak | Ya | Admin bisa reset sandi client secara manual dari `/admin/pengguna`. |
| **Bersihkan Storage Kedaluwarsa** | Tidak | Ya | Menghapus direktori foto undangan yang sudah lewat `berlaku_sampai`. |

---

## 6. RINCIAN FITUR PER MODUL

### Modul 1: Landing Page Promosi & Live Demo (`HalamanUtamaController`)
1. **Identitas Visual Brand SesiTemu:**
   - Nuansa warna hangat dan elegan: *Warm Ivory* (`#FDFBF7`), *Champagne Gold* (`#BFA15F`), *Deep Charcoal* (`#1F2937`), dan *Sage Green* (`#4B6358`).
2. **Hero Section dengan "Cek Ketersediaan Link Pasangan" (`POST /cek-link`):**
   - Input interaktif `sesitemu.id/[ ketik-nama-pasangan ]`.
   - Sistem memformat input dengan `Str::slug()` dan mengecek ketersediaannya di tabel `undangan`.
   - Jika tersedia, redirect ke `/daftar?slug={slug}` dengan notifikasi sukses. Jika sudah dipakai, tampilkan pesan saran di halaman beranda.
3. **Katalog Tema dengan Filter & Modal Simulasi Nama Tamu:**
   - Filter tab kategori: *Semua*, *Modern*, *Adat*, *Islami*.
   - Tombol **"Lihat Demo"** membuka modal kecil tempat pengunjung bisa mengetik namanya (default: `Budi Santoso & Partner`) lalu membuka `/demo/{slugTema}?to={Nama}`.
   - Tombol **"Pakai Tema Ini"** mengarahkan ke `/daftar?tema={id}`.
4. **In-Memory Live Preview (`GET /demo/{slugTema}`):**
   - Tidak perlu menyimpan data demo di database. Buat instance `new Undangan([...])` di memori dalam `HalamanUtamaController@demoTema` dan isi relasi `tema`, `daftarAcara`, `daftarGaleri`, `daftarAmplop`, serta `bukuTamu` menggunakan `setRelation()` dan `collect([...])` dengan data pasangan contoh (*Dimas & Rani*).
   - Kirim variabel `$modeDemo = true` agar bagian atas tema menampilkan *floating bar* berisi nama tema dan tombol **"Pakai Tema Ini"**.
5. **Tabel Perbandingan 2 Paket Harga:**
   - **Paket Mandiri (Self-Service):** Client mengisi data sendiri melalui dasbor.
   - **Paket Terima Beres:** Client cukup mengirimkan data & foto melalui WhatsApp, Admin yang menginputkan semuanya sampai siap sebar.

### Modul 2: Autentikasi Manual Tanpa Breeze (`AutentikasiController`)
1. **Halaman Daftar (`/daftar`):**
   - Input: `nama`, `email`, `nomor_wa`, `kata_sandi`, dan `kata_sandi_confirmation`.
   - Menyimpan pengguna baru dengan `peran = 'client'`.
   - Jika ada parameter `?slug=` atau `?tema=` di session/query string, simpan otomatis draft undangan pertama milik client tersebut setelah registrasi berhasil.
2. **Halaman Masuk (`/masuk`):**
   - Memverifikasi email dan `Hash::check($request->kata_sandi, $pengguna->kata_sandi)`.
   - Jika `adalahAdmin()`, redirect ke `/admin`. Jika `adalahClient()`, redirect ke `/dasbor`.

### Modul 3: Dasbor Client & Step-by-Step Builder (`DasborUndanganController`)
1. **Halaman Utama Dasbor (`/dasbor`):**
   - Menampilkan daftar undangan milik client, status publikasi (*Draft / Aktif*), sisa masa aktif, statistik ringkas RSVP, tombol **Kelola Undangan**, tombol **Lihat Undangan**, dan tombol **Aktifkan via WhatsApp**.
2. **Halaman Editor Undangan Berbasis Tab Alpine.js (`/dasbor/undangan/{undangan}/kelola`):**
   - **Tab 1 - Tema & Pengaturan Link:** Pilih/ganti tema dari katalog, ubah `slug` (dikunci jika sudah dipublikasikan), pilih lagu latar dari daftar file di `public/musik/*.mp3`, dan sakelar aktif/nonaktif fitur.
   - **Tab 2 - Data Mempelai:** Form data mempelai pria & wanita, nama orang tua, kutipan ayat/doa, dan upload foto profil mempelai.
   - **Tab 3 - Rangkaian Acara:** Tambah/edit/hapus jadwal acara (Akad, Resepsi, dll.), tanggal, jam, zona waktu (`WIB`/`WITA`/`WIT`), nama gedung, alamat, dan link Google Maps.
   - **Tab 4 - Galeri & Cerita Cinta:** Upload foto prewedding (dibatasi maksimal 10 foto per undangan), hapus foto, dan kelola daftar *Cerita Cinta* beserta link *Live Streaming* (disimpan ke kolom JSON `pengaturan`).
   - **Tab 5 - Amplop Digital:** Tambah/hapus daftar rekening bank/e-wallet dan alamat pengiriman kado fisik.
   - **Tab 6 - Sebar Tamu & Buku Tamu (RSVP):**
     - **Generator Link Tamu WhatsApp:** Textarea input banyak nama tamu (per baris) yang otomatis menghasilkan daftar URL `https://sesitemu.id/{slug}?to={Nama+Tamu}` lengkap dengan tombol *Salin Teks Undangan* dan *Kirim langsung ke WhatsApp*.
     - **Rekapitulasi Kehadiran:** Grafik/kartu jumlah tamu *Hadir*, *Tidak Hadir*, *Ragu*, total orang hadir, dan tabel daftar ucapan dengan tombol hapus komentar.

### Modul 4: Kompresi Gambar Otomatis ke WebP (`PengolahGambarService`)
Setiap foto yang diunggah (foto mempelai maupun galeri) WAJIB diproses melalui `App\Services\PengolahGambarService`:
- Menerima `UploadedFile`, membaca gambar menggunakan ekstensi PHP GD bawaan (`imagecreatefromjpeg`, `imagecreatefrompng`, atau `imagecreatefromwebp`).
- Mengubah ukuran (*resize* proporsional) jika lebar gambar melebihi `1200px`.
- Menyimpan hasil kompresi dalam format `.webp` dengan kualitas `80` ke `Storage::disk('public')` di dalam folder `undangan/{undangan_id}/`.

### Modul 5: Panel Admin (`AdminController` & `AdminTemaController`)
1. **Ringkasan Statistik (`/admin`):** Total client terdaftar, total undangan aktif, total draft menunggu aktivasi, dan tombol jalankan pembersihan storage kedaluwarsa.
2. **Manajemen & Aktivasi Undangan (`/admin/undangan`):**
   - Pencarian berdasarkan `slug` atau nama client, filter status (*Semua, Draft, Aktif, Kedaluwarsa*).
   - Tombol **Aktifkan** (`PATCH /admin/undangan/{undangan}/aktifkan`): Mengubah `status_publikasi = true` dan mengeset `berlaku_sampai = now()->addMonths(3)`.
   - Tombol **Nonaktifkan**: Mengembalikan `status_publikasi = false`.
   - Tombol **Edit Isian Client**: Membuka `/dasbor/undangan/{undangan}/kelola` untuk mengisikan data client yang memesan *Paket Terima Beres*.
3. **Manajemen Katalog Tema (`/admin/tema`):**
   - CRUD data tabel `tema`, upload thumbnail tema, atur `lokasi_view`, dan toggle status `aktif`.
4. **Manajemen Pengguna (`/admin/pengguna`):**
   - Daftar client lengkap dengan tombol chat langsung ke `nomor_wa` (untuk *follow-up* draft undangan) dan fitur **Reset Kata Sandi Manual**.

### Modul 6: Halaman Undangan Publik & Animasi (`UndanganPublikController`)
1. **Aturan Tampilan & Watermark Draft:**
   - Jika `berlaku_sampai` sudah terlewat, tampilkan halaman pemberitahuan masa aktif undangan telah berakhir.
   - Jika `status_publikasi == false`, undangan tetap tampil utuh agar client bisa melihat pratinjau, namun terdapat banner melayang di bagian atas: **"MODE PRATINJAU SESITEMU.ID — UNDANGAN BELUM AKTIF"**.
2. **Meta Tag OpenGraph WhatsApp Dinamis:**
   - Wajib ada di `<head>` setiap tema agar saat link dibagikan ke WhatsApp muncul thumbnail foto pasangan dan judul pernikahan:
     - `og:title`: `The Wedding of {nama_panggilan_pria} & {nama_panggilan_wanita}`
     - `og:description`: `Kepada Yth. {namaTamu}. Tanpa mengurangi rasa hormat, kami mengundang Anda untuk hadir di acara pernikahan kami.`
     - `og:image`: Foto mempelai pria/wanita atau gambar pratinjau tema.
3. **Standar Animasi & Interaksi di Seluruh Tema (3 Tema Awal: `rustic-floral`, `adat-jawa`, `islami-syari`):**
   - **Cover Gate (Sampul Terkunci):** Saat halaman dimuat, `body` terkunci (`overflow: hidden`). Menampilkan nama pasangan, nama tamu dari query `?to=`, dan tombol **"Buka Undangan"**.
   - **Transisi Buka & Autoplay Musik:** Saat tombol diklik, layar sampul bergeser halus ke atas (`transform: translateY(-100%)`), scroll halaman terbuka, audio `.mp3` berputar otomatis, dan muncul tombol piringan musik berputar (`@keyframes putarKaset`) di pojok kanan bawah.
   - **Ornamen Bergerak (CSS Keyframes):** Gambar ornamen bunga/daun/wayang di sudut layar bergerak lembut secara terus-menerus menggunakan `@keyframes goyangAngin`.
   - **Animasi Scroll (AOS.js):** Setiap seksi menggunakan atribut `data-aos="fade-up"`, `zoom-in`, atau `fade-right` dengan durasi `1000ms`.
   - **Countdown Timer & Simpan ke Google Calendar:** Hitung mundur *real-time* menuju tanggal acara pertama, dilengkapi tombol **Simpan ke Kalender** yang mengarah ke URL `https://calendar.google.com/calendar/render?action=TEMPLATE&...` secara dinamis.
   - **Amplop Digital Copy-to-Clipboard:** Tombol salin nomor rekening dengan indikator teks *"Berhasil Disalin!"*.
   - **Buku Tamu Anti-Spam:** Form pengiriman ucapan dan konfirmasi kehadiran yang diproteksi dengan middleware `throttle:5,1`.

---

## 7. SPESIFIKASI ROUTING (`routes/web.php`)

```php
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
Route::middleware('guest')->group(function () {
    Route::get('/masuk', [AutentikasiController::class, 'formMasuk'])->name('login');
    Route::post('/masuk', [AutentikasiController::class, 'prosesMasuk'])->name('masuk.proses');
    Route::get('/daftar', [AutentikasiController::class, 'formDaftar'])->name('daftar');
    Route::post('/daftar', [AutentikasiController::class, 'prosesDaftar'])->name('daftar.proses');
});
Route::post('/keluar', [AutentikasiController::class, 'keluar'])->middleware('auth')->name('keluar');

// 3. Area Dasbor Client (Juga bisa diakses Admin untuk Paket Terima Beres)
Route::middleware('auth')->prefix('dasbor')->name('dasbor.')->group(function () {
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
Route::middleware(['auth', PastikanAdmin::class])->prefix('admin')->name('admin.')->group(function () {
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
```

---

## 8. PANDUAN TAHAPAN EKSEKUSI (ROADMAP PROMPT ANTIGRAVITY)

Kerjakan proyek ini secara bertahap menggunakan 5 urutan langkah berikut agar kode bersih dan bebas dari error:

### Tahap 1: Database, Model Eloquent, Auth Config & Seeder
- Buat migrasi untuk ke-7 tabel Bahasa Indonesia (`pengguna`, `tema`, `undangan`, `acara_undangan`, `galeri_undangan`, `amplop_digital`, `buku_tamu`) dengan enum peran `['admin', 'client']`.
- Buat ke-7 Model Eloquent lengkap dengan deklarasi `$table`, `$fillable`/`$guarded`, `$casts`, method `getAuthPasswordName()`, dan relasinya.
- Perbarui `config/auth.php` agar menggunakan `App\Models\Pengguna::class`.
- Buat `DatabaseSeeder` berisi:
  - 1 Akun Admin (`admin@sesitemu.id`, peran: `'admin'`)
  - 1 Akun Client contoh (`client@sesitemu.id`, peran: `'client'`)
  - 3 Tema awal (`Rustic Floral` - modern, `Adat Jawa Keraton` - adat, `Islami Syari` - islami) beserta 1 data undangan contoh.

### Tahap 2: Autentikasi Manual, Middleware `PastikanAdmin` & `UndanganPolicy`
- Buat `AutentikasiController` untuk menangani form masuk, daftar, dan keluar tanpa Breeze.
- Buat halaman Blade `resources/views/autentikasi/masuk.blade.php` dan `daftar.blade.php` dengan desain elegan khas SesiTemu.
- Buat middleware `PastikanAdmin` dan daftarkan alias/penggunaannya.
- Buat `UndanganPolicy` dengan method `before()` untuk bypass Admin dan method `kelola()` untuk validasi kepemilikan Client.

### Tahap 3: Landing Page SesiTemu & Sistem Live Demo In-Memory
- Buat `HalamanUtamaController` dengan method `beranda`, `cekLink`, dan `demoTema`.
- Bangun `resources/views/beranda.blade.php` lengkap dengan Hero Section + input Cek Link Pasangan, Keunggulan SesiTemu, Katalog Tema dengan filter kategori + modal simulasi nama tamu, Tabel Harga (Paket Mandiri vs Paket Terima Beres), dan tombol WhatsApp mengambang.

### Tahap 4: Dasbor Client, Kompresi WebP & Panel Admin
- Buat `App\Services\PengolahGambarService` untuk mengonversi setiap upload foto menjadi `.webp` secara otomatis menggunakan PHP GD.
- Buat `DasborUndanganController` dan view `resources/views/dasbor/index.blade.php` serta `kelola.blade.php` (menggunakan tab Alpine.js untuk mengelola mempelai, acara, galeri, amplop, cerita cinta, generator link WA tamu, dan rekap RSVP).
- Buat `AdminController`, `AdminTemaController`, dan seluruh view di `resources/views/admin/` untuk aktivasi undangan, manajemen tema, manajemen pengguna, serta command `BersihkanUndanganKedaluwarsa`.

### Tahap 5: Halaman Undangan Publik & 3 Desain Tema Beranimasi
- Buat `UndanganPublikController` untuk merender undangan berdasarkan `slug`, menangkap parameter `?to=`, menampilkan watermark jika `status_publikasi == false`, dan menyimpan input RSVP buku tamu.
- Buat komponen global di `resources/views/komponen-undangan/` (hitung mundur, pemutar musik piringan berputar, lightbox galeri, dan bar mengambang mode demo).
- Buat 3 file Blade tema lengkap (`tema/rustic-floral/index.blade.php`, `tema/adat-jawa/index.blade.php`, dan `tema/islami-syari/index.blade.php`) yang mengimplementasikan Cover Gate, animasi goyang ornamen CSS Keyframes, animasi scroll AOS.js, OpenGraph WhatsApp, tombol Simpan ke Google Calendar, dan salin rekening amplop digital.