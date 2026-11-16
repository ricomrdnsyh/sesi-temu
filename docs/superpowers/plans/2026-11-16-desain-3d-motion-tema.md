# Upgrade 3D Diorama & Motion Engine Semua Tema Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Mengubah ke-9 tema undangan SesiTemu menjadi pengalaman visual 3D Motion Diorama lengkap dengan aset ornamen transparan ilustrasi baru, gerbang pembuka 3D, *parallax* multi-lapisan, kartu tilt 3D interaktif, dan partikel hidup bertema.

**Architecture:** Memanfaatkan pembungkus perspektif CSS 3D (`.panggung-3d`, `perspective: 1600px`, `preserve-3d`) di komponen inti `resources/views/komponen-undangan/`, dikendalikan oleh *engine* JS ringan di `skrip-tema.blade.php` (*pointer tilt*, *scroll parallax*, dan `IntersectionObserver` *3D scroll reveal*), serta mengganti 9 file `ornamen-*.webp` dengan hasil generasi ilustrasi *cut-out* transparan menggunakan PHP GD *alpha-matte & color decontamination*.

**Tech Stack:** Laravel 12 Native Blade, Tailwind CSS v4 (Vite), Alpine.js, PHP GD Image Processing, PHPUnit 12, Laravel Pint.

## Global Constraints

- Semua nama variabel, view, dan pengujian baru tetap berbahasa Indonesia konsisten dengan SesiTemu dan mematuhi `AGENTS.md` (kurung kurawal `{}` wajib, tipe eksplisit).
- Seluruh 28 pengujian PHPUnit yang sudah ada wajib tetap lolos tanpa merusak slug, rute, mode demo, maupun Mode Tanpa Foto (TF).
- Semua aset ornamen baru (`public/aset-tema/<slug>/ornamen-*.webp`) wajib berformat `.webp` dengan dimensi proporsional (<= 600px) dan transparansi bersih tanpa kotak latar.
- Wajib menyediakan fallback `prefers-reduced-motion: reduce` agar aksesibilitas dan performa perangkat mobile tetap optimal.

---

### Task 1: Generasi & Konversi 9 Aset Ornamen Transparan (`.webp`)

**Files:**
- Modify/Replace:
  - `public/aset-tema/adat-jawa/ornamen-gunungan.webp`
  - `public/aset-tema/sunda-heritage/ornamen-siger.webp`
  - `public/aset-tema/islamic-heavenly/ornamen-sabit.webp`
  - `public/aset-tema/islami-syari/ornamen-arabesque.webp`
  - `public/aset-tema/luxury-noir/ornamen-emas.webp`
  - `public/aset-tema/royal-ivory/ornamen-katedral.webp`
  - `public/aset-tema/velvet-garden/ornamen-botani.webp`
  - `public/aset-tema/rustic-floral/ornamen-sudut.webp`
  - `public/aset-tema/editorial-monokrom/ornamen-bingkai.webp`
- Test: `tests/Feature/TemaMotion3DTest.php`

**Interfaces:**
- Produces: 9 file WebP berkanal alfa transparan yang langsung dipanggil lewat `$ornamenUrl` pada ke-9 `resources/views/tema/*/index.blade.php`.

- [ ] **Step 1: Generate ilustrasi sumber via `image-generator` untuk ke-9 tema**
  Gunakan latar solid polos kontras tinggi (`#FFFFFF` putih bersih untuk nuansa gelap/berwarna solid; `#0B1018` / `#0D1914` gelap bersih untuk nuansa emas terang/melati putih) tanpa bayangan jatuh ke latar agar mudah diekstrak menjadi transparan.

- [ ] **Step 2: Konversi ke-9 gambar ke WebP transparan (alpha-matte + color decontamination + auto-trim)**
  Jalankan skrip PHP GD di terminal untuk membaca warna piksel sudut sebagai warna latar, menghapus latar dengan transisi alfa halus (`alpha un-premultiplication`), memotong tepi transparan berlebih (*auto-crop padding*), meresize maks 420px, dan menyimpan `.webp` ke `public/aset-tema/<slug>/ornamen-*.webp`.

- [ ] **Step 3: Verifikasi visual semua 9 ornamen `.webp` menggunakan `read_file`**
  Pastikan tidak ada kotak latar sisa, halo, maupun bagian ilustrasi penting yang terpotong.

---

### Task 2: Engine CSS 3D Perspektif, Keyframes 3D, & Partikel Hidup (`meta-opengraph` & `lapisan-motion`)

**Files:**
- Modify: `resources/views/komponen-undangan/meta-opengraph.blade.php`
- Modify: `resources/views/komponen-undangan/lapisan-motion.blade.php`
- Modify: `resources/views/komponen-undangan/divider-tema.blade.php`

**Interfaces:**
- Produces: Kelas CSS `.panggung-3d`, `.lapis-3d`, `.kartu-3d`, `.kartu-3d-kilau`, `.masuk-3d`, `.terlihat`, `.animasi-ayun-3d`, `.animasi-kelopak-3d`, `.animasi-burung`, `.animasi-sinar`, `.angka-flip-3d`, serta dukungan `efekMotion` baru (`wayang-flora`, `melati-burung`, `bintang`, `kilau`, `debu-emas`, `kelopak-kunang`, `kelopak`, `halus`).

- [ ] **Step 1: Tambahkan CSS 3D keyframes, perspektif, tilt kartu, scroll reveal, & reduced-motion di `meta-opengraph.blade.php`**
  Tambahkan `.panggung-3d` (`perspective: 1600px`), `.lapis-3d` (variabel `--px`, `--py`, `--ps`, `--pz`, `--depth`), `.kartu-3d` (tilt `--rx`, `--ry`, highlight border atas, shadow berlapis), `.masuk-3d` (*progressive enhancement* ketika `.siap-3d` aktif), `@keyframes ayun3d`, `@keyframes kelopak3d`, `@keyframes burungTerbang`, `@keyframes sinarCahaya`, `@keyframes flipAngka3d`, serta `@media (prefers-reduced-motion: reduce)`.

- [ ] **Step 2: Tingkatkan `lapisan-motion.blade.php` dengan animasi burung terbang, kelopak 3D tumbling, sinar cahaya volumetrik, dan partikel bercahaya**
  Tambahkan elemen SVG burung melintas perlahan untuk nuansa *heritage/garden/royal*, awan tipis berlapis, lentera berkilau pada *Islamic*, serta kelopak berputar 3D di sumbu X/Y/Z.

- [ ] **Step 3: Tingkatkan `divider-tema.blade.php` dengan kedalaman 3D & ikon animasi lebih tegas**
  Tambahkan kilau tiga lapis simetris & bayangan lembut pada ikon pemisah tiap gaya tata letak.

---

### Task 3: Engine JS 3D Parallax, Tilt Kartu, Cover Gate 3D, & Countdown Flip (`kerangka-tema`, `hitung-mundur`, `amplop-dan-tamu`, `skrip-tema`)

**Files:**
- Modify: `resources/views/komponen-undangan/kerangka-tema.blade.php`
- Modify: `resources/views/komponen-undangan/hitung-mundur.blade.php`
- Modify: `resources/views/komponen-undangan/amplop-dan-tamu.blade.php`
- Modify: `resources/views/komponen-undangan/skrip-tema.blade.php`

**Interfaces:**
- Consumes: Kelas CSS 3D & aset ornamen `.webp` dari Task 1 & Task 2.
- Produces: Properti `animasiSampul` mendukung `'belah-pintu-3d'`, `'tirai-portal-3d'`, `'lipat-katedral-3d'`, dan `'halaman-editorial-3d'` (dengan *backward compatibility* bila nilai lama dipanggil).

- [ ] **Step 1: Perbarui `skrip-tema.blade.php` dengan pengendali Pointer Parallax 3D, Scroll Parallax, 3D Card Tilt, dan IntersectionObserver `.masuk-3d`**
  Pastikan saat halaman dimuat `document.body.classList.add('siap-3d')`, gerakan mouse di desktop mengupdate `--px`/`--py` pada `.panggung-3d` serta `--rx`/`--ry` pada `.kartu-3d`, dan elemen `.masuk-3d` otomatis mendapat `.terlihat` saat memasuki viewport (atau langsung aktif bila IntersectionObserver tidak tersedia).

- [ ] **Step 2: Perbarui `kerangka-tema.blade.php` dengan Panggung 3D 5-Lapis, 4 jenis Cover Gate 3D bersudut perspektif, dan penempatan ornamen foreground atas–bawah yang hidup**
  - Bungkus `<aside>` panggung kiri dan kolom undangan kanan dengan `.panggung-3d` dan lapis `--depth`/`--pz`.
  - Terapkan 4 gaya 3D Cover Gate (`belah-pintu-3d`, `tirai-portal-3d`, `lipat-katedral-3d`, `halaman-editorial-3d`) dengan panel bertekstur bingkai arsitektur/monogram dan engsel `transform-origin` sejati.
  - Perbesar kehadiran ornamen transparan `ornamenUrl` pada keempat sudut panggung desktop (`w-40 xl:w-52 animasi-ayun-3d drop-shadow-2xl`) serta bingkai sudut kolom mobile.
  - Pasang `.kartu-3d` & `.masuk-3d` pada Hero card, Quote, Kartu Mempelai Pria & Wanita, Acara, Cerita Cinta, dan Galeri.

- [ ] **Step 3: Perbarui `hitung-mundur.blade.php` dan `amplop-dan-tamu.blade.php` dengan kartu `.kartu-3d`, `.masuk-3d`, serta efek flip 3D pada angka hitung mundur**
  Tambahkan watcher ringan di Alpine countdown atau class flip saat nilai `detik` / `menit` berubah, serta terapkan `.kartu-3d` ke kotak countdown, amplop digital, alamat kado, dan buku tamu.

---

### Task 4: Konfigurasi Properti 3D & Motion pada 9 Tema + Pengujian PHPUnit (`TemaMotion3DTest`)

**Files:**
- Modify:
  - `resources/views/tema/adat-jawa/index.blade.php`
  - `resources/views/tema/sunda-heritage/index.blade.php`
  - `resources/views/tema/islamic-heavenly/index.blade.php`
  - `resources/views/tema/islami-syari/index.blade.php`
  - `resources/views/tema/luxury-noir/index.blade.php`
  - `resources/views/tema/royal-ivory/index.blade.php`
  - `resources/views/tema/velvet-garden/index.blade.php`
  - `resources/views/tema/rustic-floral/index.blade.php`
  - `resources/views/tema/editorial-monokrom/index.blade.php`
- Create: `tests/Feature/TemaMotion3DTest.php`

- [ ] **Step 1: Tulis failing test `tests/Feature/TemaMotion3DTest.php`**
  ```php
  public function test_seluruh_tema_memiliki_ornamen_webp_dan_animasi_gerbang_3d(): void
  {
      // Assert file ornamen exist & > 1500 bytes, setiap route /demo/{slugTema} merender kelas panggung-3d, kartu-3d, dan animasi 3D sesuai tema.
  }
  ```

- [ ] **Step 2: Jalankan test untuk memastikan fail sebelum properti 9 tema diperbarui**
  Run: `php artisan test --filter=TemaMotion3DTest`
  Expected: FAIL sebelum pembaruan view 9 tema.

- [ ] **Step 3: Perbarui ke-9 `resources/views/tema/*/index.blade.php` memakai `animasiSampul` 3D dan `efekMotion` spesifik tema**
  - `adat-jawa` & `sunda-heritage`: `animasiSampul => 'belah-pintu-3d'`, `efekMotion` beranimasi burung + melati/kelopak emas
  - `luxury-noir`, `velvet-garden`, `islamic-heavenly`: `animasiSampul => 'tirai-portal-3d'`
  - `royal-ivory`, `islami-syari`: `animasiSampul => 'lipat-katedral-3d'`
  - `editorial-monokrom`, `rustic-floral`: `animasiSampul => 'halaman-editorial-3d'`

- [ ] **Step 4: Jalankan build Vite, clear views, Pint, dan seluruh PHPUnit suite**
  - `npm run build`
  - `php artisan view:clear`
  - `php vendor/bin/pint --format=json`
  - `php artisan test`
  Expected: Vite exit 0, Pint `passed`, semua pengujian PHPUnit lolos 100%.

- [ ] **Step 5: Commit bertahap**
  Simpan commit bersih untuk dokumentasi, aset ornamen 3D, engine 3D diorama, serta 9 tema & pengujiannya.
