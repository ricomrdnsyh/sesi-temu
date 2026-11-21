# Spesifikasi Desain: Flagship 3D Motion Diorama `adat-jawa` & Transisi Buka Sampul Fade Halus Global

**Tanggal:** 2026-11-21  
**Status:** Disetujui Pengguna  
**Cakupan Tahap 1:**
1. Mengubah transisi buka sampul pada seluruh 9 tema menjadi **fade halus tanpa efek buka buku / belah pintu / lipat 3D**.
2. Merombak total tema flagship `adat-jawa` (Adat Jawa Keraton) menggunakan **template mandiri modular** + **set 9 aset ilustrasi WebP transparan berlapis asli** + **koreografi panggung diorama 2.5D/3D** + **alur 13 seksi ritme kontras** terinspirasi `waktutemu.id/java-heritage`.
3. Menambahkan field opsional di `undangan.pengaturan` JSON & dashboard editor (`sosial_media.instagram_pria/wanita`, `dress_code`, `turut_mengundang`) + melengkapi data demo `adat-jawa` & preset tipografi `java_heritage`.

*(Tahap 2 berikutnya setelah flagship disetujui visualnya: membedakan total 8 tema lain dengan pola template mandiri + aset berlapis unik masing-masing.)*

---

## 1. Transisi Buka Sampul Global (Semua 9 Tema)

- Pada `resources/views/komponen-undangan/kerangka-tema.blade.php`, `resources/views/komponen-undangan/meta-opengraph.blade.php`, dan seluruh file `resources/views/tema/*/index.blade.php`:
  - Hapus mekanisme belah pintu 2 panel (`panel-gerbang-kiri`, `panel-gerbang-kanan`, `rotateY(±112deg)`), lipat katedral (`lipat-katedral-3d`, `rotateX(78deg)`), dan buka halaman buku (`halaman-editorial-3d`, `rotateY(-108deg)`).
  - Ganti seluruh `animasiSampul` menjadi **`fade-halus`**: kelas `.sampul-fade-halus` mentransisikan `opacity: 1 -> 0` dan `transform: scale(1) -> scale(1.03)` selama `600ms cubic-bezier(0.22, 1, 0.36, 1)` lalu `pointer-events: none` saat `undanganTerbuka === true`.
  - Mempertahankan penuh fungsi audio autoplay, auto-scroll cinema, dan trigger reveal setelah terbuka.

---

## 2. Arsitektur Template Mandiri `adat-jawa`

Melepas `adat-jawa` dari `kerangka-tema.blade.php` menjadi struktur modular:
- `resources/views/tema/adat-jawa/index.blade.php` — entry point layout split-screen desktop (`lg:flex`) + kolom portrait (`lg:w-[460px] xl:w-[490px]`) dengan *pinned illustrated backdrop*.
- `resources/views/tema/adat-jawa/partials/_panggung-desktop.blade.php` — panggung kiri desktop menampilkan diorama lukisan hutan Jawa, pendopo, janur kuning, bunga depan, kawanan burung/kupu-kupu, serta tipografi pasangan.
- `resources/views/tema/adat-jawa/partials/_sampul.blade.php` — sampul `100dvh` *full-bleed* bersih: foto sampul + gradasi bawah ke `#472A1C`, teks judul di atas, ruang lega di tengah untuk wajah mempelai, sapaan `Kepada Yth. {{ $namaTamu }}` + tombol pill emas gradasi (`linear-gradient(180deg, #D7BB83 0%, #A38C5E 100%)`) + catatan miring tanpa kotak kaca yang menghalangi foto.
- `resources/views/tema/adat-jawa/partials/_hero-diorama.blade.php` — panggung pembuka 3D diorama penuh `100dvh` 6-lapis dengan koreografi pembukaan otomatis saat `undanganTerbuka === true`.
- `resources/views/tema/adat-jawa/partials/_konten-utama.blade.php` — Seksi 3 s.d. 9: Ayat/Quote Kawung, Profil Mempelai Kapsul Raksasa, Slideshow Transisi, Save The Date Countdown, Rangkaian Acara Double-Frame, Dress Code & Live Streaming, Our Love Story Kubah Coklat, dan Galeri Sepia.
- `resources/views/tema/adat-jawa/partials/_penutup-dan-rsvp.blade.php` — Seksi 10 s.d. 13: Wedding Gift ATM Glossy (toggle interaktif), RSVP & Wishes Sogan Gelap, Doa Untuk Pengantin, Turut Mengundang, Penutup Kapsul Simetris, dan Footer Sogan.

Core engine yang tetap dipakai bersama: `meta-opengraph.blade.php`, `bar-pratinjau-demo.blade.php`, `kontrol-sinema.blade.php`, `pemutar-musik.blade.php`, `modal-galeri.blade.php`, `skrip-tema.blade.php`.

---

## 3. Set 9 Aset Ilustrasi WebP Berlapis `public/aset-tema/adat-jawa/`

Seluruh aset baru digenerate dengan palet konsisten (Sepia Hangat, Emas Keraton `#D7BB83`, Coklat Sogan `#472A1C`, Mawar Peach/Blush) dan diproses dengan PHP GD menjadi WebP optimal + transparansi alpha bersih (tanpa tepi putih/kotak):

1. `latar-hutan-jawa.webp` — Latar ilustrasi penuh (9:16 portrait) kanopi hutan/pepohonan vintage sepia-krem-emas lembut (tanpa Joglo/wayang menempel, agar menjadi lapisan Z-0 yang bersih).
2. `gunungan-pembuka.webp` — Transparan: siluet Wayang Gunungan ukir emas detail tinggi untuk efek gerbang pembuka *fly-through* (zoom melewati kamera membelah kiri-kanan).
3. `pendopo-joglo.webp` — Transparan: rumah adat Pendopo Joglo kayu ukir emas hangat (Lapisan Z-2 tengah-bawah).
4. `janur-kuning.webp` — Transparan: hiasan Janur Kuning melengkung anggun (dipakai simetris kiri & kanan dengan ayunan organik independen).
5. `bunga-depan.webp` — Transparan: hamparan bunga mawar peach, blush pink, krem, dan dedaunan halus di tepi bawah foreground (Lapisan Z-4).
6. `bingkai-ukiran.webp` — Transparan (tengah berlubang/isi coklat transparan lembut): bingkai ukiran Jawa klasik emas elegan yang mekar masuk di detik ke-2 membungkus nama mempelai.
7. `motif-kawung-atas.webp` & `motif-kawung-bawah.webp` — Transparan: pita ornamen border Batik Kawung emas-sogan untuk tepi atas & bawah seksi Kutipan/Ayat.
8. `sayap-wayang.webp` — Transparan: ornamen sayap ukiran batik/wayang emas untuk lapisan belakang potret mempelai (berayun lembut).
9. `bunga-lili.webp` — Transparan: rangkaian bunga lili peach & dedaunan untuk lapisan depan potret mempelai dan sepasang sudut miring (`-35deg` & `+35deg`) pada kapsul penutup.

*(Aset eksisting `ornamen-gunungan.webp` tetap dipertahankan sebagai crest kecil 50px di tajuk seksi dan untuk kompatibilitas backward.)*

---

## 4. Koreografi 3D Motion Diorama (`adat-jawa`)

Saat tombol *Buka Undangan* diklik:
- **`0.0s – 0.6s`:** Sampul memudar halus (`opacity: 1 -> 0`, `scale: 1 -> 1.03`).
- **`0.0s – 1.9s`:** Sepasang `gunungan-pembuka.webp` raksasa menyapu/membelah keluar ke kiri-kanan melewati kamera (`scale(2.1) translateZ(180px)` -> keluar layar + `opacity: 0`).
- **`0.2s – 2.5s`:** `latar-hutan-jawa.webp` melakukan *camera dolly-out* (`scale(1.22) -> 1.03`); `pendopo-joglo.webp` terangkat lembut dari bawah; `janur-kuning.webp` kiri & kanan masuk melengkung lalu masuk loop ayunan angin (`ayunJanurKiri`/`ayunJanurKanan`); `bunga-depan.webp` mekar di tepi bawah; kawanan burung SVG kecil terbang naik melintas langit + 2 kupu-kupu emas 3D melintas.
- **`1.9s – 3.4s`:** `bingkai-ukiran.webp` + tipografi *"The Wedding of"*, nama mempelai `#D7BB83`, tanggal `dd · mm · yy`, hashtag, dan indikator gulir mouse animasi mekar ke tengah panggung dari kedalaman 3D (`scale(0.76) translateZ(-90px)` -> `scale(1)`).
- Sepanjang scroll: `data-panggung-3d` & `lapis-paralaks-scroll` memberi kedalaman paralaks responsif, seluruh elemen konten memakai reveal 3D (`.fx-rise`, `.fx-rise-down`, `.fx-scale-in`, `.fx-scale-out`, `.fx-slide-left`, `.fx-slide-right`).
- Hormati `@media (prefers-reduced-motion: reduce)`: seluruh elemen langsung tampil pada posisi akhir tanpa gerak berlebih.

---

## 5. Penambahan Data Opsional (`undangan.pengaturan` JSON) & Dashboard Editor

Ditambahkan ke `Undangan::pengaturanBawaan()` di `app/Models/Undangan.php` (tanpa migrasi DB berisiko; 100% kompatibel dengan data lama):
- `sosial_media`: `['instagram_pria' => '', 'instagram_wanita' => '']`
- `dress_code`: `['catatan' => '', 'warna' => []]` (maks 5 warna hex `#RRGGBB`)
- `turut_mengundang`: `['pihak_wanita' => '', 'pihak_pria' => '']` (teks multi-baris, 1 baris = 1 nama keluarga)

Integrasi:
- **Tipografi:** Tambah preset `java_heritage` (`Pinyon Script` + `Cormorant Infant` + `Playfair Display` + `Poppins`) pada `Undangan::GAYA_FONT_TERSEDIA` dan jadikan `FONT_BAWAAN_TEMA['adat-jawa'] = 'java_heritage'`.
- **Dashboard Editor (`resources/views/dashboard/kelola.blade.php` & `DashboardUndanganController.php`):**
  - Tab **Mempelai (`bagian = mempelai`)**: input opsional Username Instagram Mempelai Pria & Wanita (sanitasi otomatis menghapus `@` / prefix URL `instagram.com/`).
  - Tab **Cerita & Tambahan (`bagian = cerita_streaming`)**: blok **Dress Code** (catatan + 3–5 *color picker* interaktif dengan tombol tambah/hapus) dan blok **Turut Mengundang** (textarea Pihak Wanita & Pihak Pria).
- **Demo Data (`app/Support/KatalogKontenDemo.php` & `HalamanUtamaController.php`):** Lengkapi data demo `adat-jawa` dan teruskan `sosial_media`, `dress_code`, `turut_mengundang` ke model demo in-memory.

---

## 6. Verifikasi & Pengujian

- Update `tests/Feature/TemaMotion3DTest.php`:
  - Seluruh 9 tema memakai `sampul-fade-halus` dan bebas dari markup buka-buku/belah-pintu (`halaman-editorial-3d`, `panel-gerbang-kiri`, `rotateY(-108deg)`, `rotateY(-112deg)`, `rotateX(78deg)`).
  - Seluruh 9 aset WebP baru di `public/aset-tema/adat-jawa/` eksis, valid (> 2KB), dan dirender pada `/demo/adat-jawa`.
  - Seluruh 13 seksi `adat-jawa` (termasuk Dress Code, Doa Untuk Pengantin, Turut Mengundang, Instagram, dan Mode Tanpa Foto `?tf=1`) lulus verifikasi.
- Tambah test penyimpanan & validasi field baru di dashboard (`instagram_pria`, `instagram_wanita`, `dress_code`, `turut_mengundang`).
- Jalankan suite PHPUnit penuh, Laravel Pint, dan verifikasi visual langsung di browser (mobile `412x900` + desktop).
