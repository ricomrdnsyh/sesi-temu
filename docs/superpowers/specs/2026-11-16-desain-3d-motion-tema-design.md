# Spesifikasi Desain: Upgrade 3D Diorama & Motion Engine Semua Tema SesiTemu

**Tanggal:** 2026-11-16
**Status:** Disetujui Pengguna
**Cakupan:** Seluruh 9 tema undangan digital SesiTemu (`adat-jawa`, `sunda-heritage`, `islamic-heavenly`, `islami-syari`, `luxury-noir`, `royal-ivory`, `velvet-garden`, `rustic-floral`, `editorial-monokrom`)

---

## 1. Latar Belakang & Tujuan

Saat ini ke-9 tema undangan digital di SesiTemu menggunakan tata letak *split-screen* desktop + kolom portrait mobile ([kerangka-tema.blade.php](file:///c:/laragon/www/sesi-temu/resources/views/komponen-undangan/kerangka-tema.blade.php)), namun terasa masih 2D karena:
- Aset ornamen sudut (`public/aset-tema/*/ornamen-*.webp`) masih berupa placeholder geometris PHP GD (oval/segitiga/garis kasar).
- Pembukaan sampul (*Cover Gate Reveal*) dan kartu konten hanya memakai translasi/fade 2D datar tanpa kedalaman perspektif 3D maupun *parallax* antar-lapisan.

Tujuan peningkatan ini adalah menghadirkan pengalaman visual **3D Motion Diorama** pada seluruh 9 tema yang terinspirasi oleh gaya undangan gerak *heritage/motion* modern — memadukan kedalaman ruang **CSS 3D Perspektif sejati**, **engine parallax JS ringan** (responsif terhadap pointer desktop, *scroll*, dan gerak ambien di mobile), **animasi gerbang pembuka 3D unik per karakter tema**, serta **9 set ornamen ilustrasi transparan berkualitas tinggi** berformat `.webp`.

---

## 2. Arsitektur 3D Diorama 5-Lapis

Baik **Panggung Visual Desktop Kiri** maupun **Kolom Undangan Portrait Mobile/Kanan** menggunakan pembungkus perspektif `.panggung-3d` (`perspective: 1600px; transform-style: preserve-3d;`) dengan 5 lapisan kedalaman terpisah:

| Lapisan | Nama Lapisan | Perilaku & Efek Visual |
| :--- | :--- | :--- |
| **Z-0** | *Far Backdrop* | Gambar `latar-utama.webp` bergerak lambat (`animasi-nafas`) disertai pergeseran parallax balik terhadap kursor/scroll agar terasa jauh di latar belakang. |
| **Z-1** | *Atmospheric Mist & Light Rays* | Efek sinar cahaya radial lembut (*volumetric light rays*) & kabut tipis bergerak halus menyesuaikan nuansa terang/gelap tema. |
| **Z-2** | *Interactive 3D Cards & Content* | Kartu konten (Hero Arch, Mempelai, Hitung Mundur, Rangkaian Acara, Cerita Cinta, Galeri, Amplop, Buku Tamu) memakai kelas `.kartu-3d` (pointer tilt `--rx`/`--ry`, kilau bezel atas *specular rim*, bayangan bertingkat) serta `.masuk-3d` (*IntersectionObserver* 3D reveal `rotateX` + `translateZ` saat discroll), plus animasi flip 3D pada angka detik/menit di [hitung-mundur.blade.php](file:///c:/laragon/www/sesi-temu/resources/views/komponen-undangan/hitung-mundur.blade.php). |
| **Z-3** | *Foreground Cutout Framing* | Ornamen ilustrasi *cut-out* transparan (`ornamen-*.webp`) berukuran proporsional ditempatkan di sudut atas & bawah (termasuk *corner foreground* pada panggung desktop dan tepi kolom portrait) dengan ayunan angin 3D (`rotateY`/`rotateZ`) serta faktor parallax lebih cepat. |
| **Z-4** | *Living Ambient Life* | Elemen SVG/CSS hidup bertema pada [lapisan-motion.blade.php](file:///c:/laragon/www/sesi-temu/resources/views/komponen-undangan/lapisan-motion.blade.php): burung melintas (*burungTerbang* + kepak sayap) untuk tema taman/adat, awan bergeser, kelopak berputar 3D (`rotate3d`), kunang-kunang glowing, debu emas naik, lentera berayun, dan bintang jatuh. |

---

## 3. Animasi Buka Sampul 3D (*Cover Gate Reveal*)

Menggantikan animasi sampul 2D pada [kerangka-tema.blade.php](file:///c:/laragon/www/sesi-temu/resources/views/komponen-undangan/kerangka-tema.blade.php) menjadi 4 mekanisme 3D berbasis properti `$animasiSampul`:

1. **`belah-pintu-3d`** (`adat-jawa`, `sunda-heritage`): Dua daun pintu gerbang berbingkai ukiran berayun membuka ke luar pada engsel kiri & kanan (`transform-origin: left/right center; rotateY(±112deg)`) dengan efek bayangan lipatan.
2. **`tirai-portal-3d`** (`luxury-noir`, `velvet-garden`, `islamic-heavenly`): Dua panel tirai mewah membelah berperspektif 3D sementara lapisan sampul melakukan efek *portal zoom-depth* ke arah penonton.
3. **`lipat-katedral-3d`** (`royal-ivory`, `islami-syari`): Sampul melengkung/terlipat ke atas pada engsel atas (`transform-origin: top center; rotateX(82deg)`) mengungkap cahaya lengkung mihrab/katedral di belakangnya.
4. **`halaman-editorial-3d`** (`editorial-monokrom`, `rustic-floral`): Sampul membuka menyamping layaknya lembaran sampul majalah/buku hardcover (`transform-origin: left center; rotateY(-108deg)`).

---

## 4. Pembuatan Ulang 9 Aset Ornamen Transparan (`.webp`)

Seluruh file `ornamen-*.webp` di `public/aset-tema/<slug>/` dibuat ulang menggunakan `image-generator` di atas latar polos kontras tinggi, lalu diproses via skrip PHP GD (`alpha-matte` + *color decontamination* + *auto-trim*) menjadi `.webp` transparan berukuran optimal (`<= 512px`, tanpa kotak putih/hitam):

1. `adat-jawa/ornamen-gunungan.webp` — Ornamen wayang gunungan emas, bunga mawar maroon & dedaunan keraton Jawa.
2. `sunda-heritage/ornamen-siger.webp` — Ornamen siger Sunda emas dengan untaian melati putih & anggrek.
3. `islamic-heavenly/ornamen-sabit.webp` — Lentera fanous emas gantung, bulan sabit & bintang surgawi.
4. `islami-syari/ornamen-arabesque.webp` — Lengkung motif arabesque zamrud, bunga champagne-putih & ranting zaitun.
5. `luxury-noir/ornamen-emas.webp` — Chandelier Art-Deco emas & ukiran sudut mewah.
6. `royal-ivory/ornamen-katedral.webp` — Rangkaian bunga mawar dusty rose, dedaunan eucalyptus & aksen perunggu klasik.
7. `velvet-garden/ornamen-botani.webp` — Rangkaian pakis hutan beludru, mawar antik & aksen emas botani.
8. `rustic-floral/ornamen-sudut.webp` — Buket bunga liar terakota, rumput pampas hangat & daun sage rustik.
9. `editorial-monokrom/ornamen-bingkai.webp` — Ilustrasi botani garis tinta artistik monokrom untuk editorial.

---

## 5. Komponen yang Diubah & Batasan

- **CSS 3D Keyframes & Rules:** [meta-opengraph.blade.php](file:///c:/laragon/www/sesi-temu/resources/views/komponen-undangan/meta-opengraph.blade.php) — menambahkan kelas 3D (`.panggung-3d`, `.lapis-3d`, `.kartu-3d`, `.masuk-3d`, `ayun3d`, `kelopak3d`, `burungTerbang`, `flipAngka3d`, `@media (prefers-reduced-motion: reduce)`).
- **Kerangka Utama & Partikel & Divider & Countdown & JS:** [kerangka-tema.blade.php](file:///c:/laragon/www/sesi-temu/resources/views/komponen-undangan/kerangka-tema.blade.php), [lapisan-motion.blade.php](file:///c:/laragon/www/sesi-temu/resources/views/komponen-undangan/lapisan-motion.blade.php), [divider-tema.blade.php](file:///c:/laragon/www/sesi-temu/resources/views/komponen-undangan/divider-tema.blade.php), [hitung-mundur.blade.php](file:///c:/laragon/www/sesi-temu/resources/views/komponen-undangan/hitung-mundur.blade.php), [amplop-dan-tamu.blade.php](file:///c:/laragon/www/sesi-temu/resources/views/komponen-undangan/amplop-dan-tamu.blade.php), dan [skrip-tema.blade.php](file:///c:/laragon/www/sesi-temu/resources/views/komponen-undangan/skrip-tema.blade.php).
- **9 View Tema:** Pembaruan nilai `animasiSampul` & prop motion/ornamen di masing-masing file `resources/views/tema/*/index.blade.php`.
- **Kompatibilitas Penuh:** Tidak mengubah struktur database, route, slug tema, teks wajib pengujian, maupun perilaku mode Tanpa Foto (TF). Mempertahankan standar `AGENTS.md` (kurung kurawal penuh `{}` pada blok kontrol, deklarasi tipe ketat, Laravel Pint lolos, dan 100% PHPUnit hijau).
