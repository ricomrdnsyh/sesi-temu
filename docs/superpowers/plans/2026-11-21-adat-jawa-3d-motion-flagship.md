# Flagship `adat-jawa` 3D Motion Diorama & Transisi Buka Sampul Fade Halus Global — Implementation Plan

> **For agentic workers:** Execute task-by-task cleanly with tests, Pint formatting, and live browser verification.

**Goal:** Mengubah transisi buka sampul seluruh 9 tema menjadi fade halus (tanpa buka buku/belah pintu/lipat), menambahkan field opsional Instagram/Dress Code/Turut Mengundang di `undangan.pengaturan` & dashboard editor, serta merombak total `adat-jawa` menjadi tema flagship modular 13 seksi dengan panggung 3D diorama 9-aset WebP transparan asli.

**Architecture:**
- Core engine bersama tetap di `resources/views/komponen-undangan/` (`meta-opengraph`, `skrip-tema`, `kontrol-sinema`, `pemutar-musik`, `modal-galeri`, `bar-pratinjau-demo`).
- `kerangka-tema.blade.php` & 8 tema lainnya beralih ke transisi sampul `fade-halus`.
- `adat-jawa` berdiri mandiri di `resources/views/tema/adat-jawa/` dengan 5 partial terstruktur + 9 aset ilustrasi WebP asli di `public/aset-tema/adat-jawa/`.
- Field opsional baru disimpan di kolom JSON `undangan.pengaturan` (kompatibel 100% dengan data lama).

**Tech Stack:** Laravel 12, Blade, Alpine.js, Tailwind CSS v4, CSS 3D Keyframes + IntersectionObserver, PHP GD / Python Pillow (konversi WebP alpha cutout), PHPUnit.

---

### Task 1: Model, Tipografi `java_heritage`, Data Demo, & Dashboard Editor (Field Opsional Baru)
**Files:**
- Modify: `app/Models/Undangan.php` (tambah `java_heritage` font preset, update `FONT_BAWAAN_TEMA['adat-jawa']`, tambah `sosial_media`, `dress_code`, `turut_mengundang` di `pengaturanBawaan()` + helper baca aman)
- Modify: `app/Http/Controllers/DashboardUndanganController.php` (validasi, sanitasi, & simpan `instagram_pria`, `instagram_wanita`, `dress_code_catatan`, `dress_code_warna`, `turut_mengundang_wanita`, `turut_mengundang_pria`)
- Modify: `resources/views/dashboard/kelola.blade.php` (input Instagram di tab Mempelai; panel Dress Code & Turut Mengundang di tab Cerita & Tambahan)
- Modify: `app/Support/KatalogKontenDemo.php` & `app/Http/Controllers/HalamanUtamaController.php` (lengkapi data demo `adat-jawa` & salurkan ke model in-memory)
- Test: `tests/Feature/TemaMotion3DTest.php`

### Task 2: Transisi Buka Sampul Fade Halus Global (Hapus Buka Buku / Belah Pintu / Lipat)
**Files:**
- Modify: `resources/views/komponen-undangan/meta-opengraph.blade.php` (tambah `.sampul-fade-halus` + CSS koreografi diorama Jawa: `sapuGununganKiri`, `sapuGununganKanan`, `ayunJanurKiri`, `ayunJanurKanan`, `bingkaiUkiranMekar`, `pendopoNaik`, `slideshowFade`, `prefers-reduced-motion`)
- Modify: `resources/views/komponen-undangan/kerangka-tema.blade.php` (ganti seluruh gerbang 3D lipat/belah/buku menjadi 1 penutup `.sampul-fade-halus`)
- Modify: `resources/views/tema/*/index.blade.php` (seluruh 8 tema lain: `animasiSampul => 'fade-halus'`)

### Task 3: Pemrosesan 9 Aset Ilustrasi WebP Transparan Asli `public/aset-tema/adat-jawa/`
**Files:**
- Create: `public/aset-tema/adat-jawa/latar-hutan-jawa.webp`
- Create: `public/aset-tema/adat-jawa/pendopo-joglo.webp`
- Create: `public/aset-tema/adat-jawa/gunungan-pembuka.webp`
- Create: `public/aset-tema/adat-jawa/bingkai-ukiran.webp`
- Create: `public/aset-tema/adat-jawa/janur-kuning.webp`
- Create: `public/aset-tema/adat-jawa/sayap-wayang.webp`
- Create: `public/aset-tema/adat-jawa/bunga-depan.webp`
- Create: `public/aset-tema/adat-jawa/bunga-lili.webp`
- Create: `public/aset-tema/adat-jawa/motif-kawung-atas.webp`
- Create: `public/aset-tema/adat-jawa/motif-kawung-bawah.webp`
- Tooling: Skrip pemroses chroma-key `#0033FF` + color decontamination + auto-trim + WebP encoding di scratch dir.

### Task 4: Template Mandiri 13 Seksi Flagship `adat-jawa`
**Files:**
- Modify: `resources/views/tema/adat-jawa/index.blade.php`
- Create: `resources/views/tema/adat-jawa/partials/_panggung-desktop.blade.php`
- Create: `resources/views/tema/adat-jawa/partials/_sampul.blade.php`
- Create: `resources/views/tema/adat-jawa/partials/_hero-diorama.blade.php`
- Create: `resources/views/tema/adat-jawa/partials/_konten-utama.blade.php`
- Create: `resources/views/tema/adat-jawa/partials/_penutup-dan-rsvp.blade.php`

### Task 5: Automated Tests, Pint Formatting, & Verifikasi Visual Browser
**Files:**
- Modify: `tests/Feature/TemaMotion3DTest.php`
- Verify: `php artisan test`, `./vendor/bin/pint --test`, dan verifikasi visual langsung via browser subagent pada `http://127.0.0.1:8000/demo/adat-jawa` (mobile `412x900` + desktop).
