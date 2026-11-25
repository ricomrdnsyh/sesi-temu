<?php

namespace Tests\Feature;

use App\Models\Pengguna;
use App\Models\Tema;
use App\Models\Undangan;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TierDanHargaTemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_mengisi_tier_dan_harga_berbeda_sesuai_kualitas_tema(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseHas('tema', ['slug' => 'rustic-floral', 'tier' => 'basic', 'harga' => 59000]);
        $this->assertDatabaseHas('tema', ['slug' => 'editorial-monokrom', 'tier' => 'premium', 'harga' => 79000]);
        $this->assertDatabaseHas('tema', ['slug' => 'adat-jawa', 'tier' => 'premium', 'harga' => 89000]);
        $this->assertDatabaseHas('tema', ['slug' => 'royal-ivory', 'tier' => 'premium', 'harga' => 99000]);
        $this->assertDatabaseHas('tema', ['slug' => 'luxury-noir', 'tier' => 'eksklusif', 'harga' => 119000]);
        $this->assertDatabaseHas('tema', ['slug' => 'velvet-garden', 'tier' => 'eksklusif', 'harga' => 129000]);

        $temaVelvet = Tema::where('slug', 'velvet-garden')->firstOrFail();
        $this->assertSame('Eksklusif', $temaVelvet->tierLabel());
        $this->assertSame('Rp 129.000', $temaVelvet->hargaFormatted());
        $this->assertSame('Rp 179.000', $temaVelvet->hargaTerimaBeresFormatted());
    }

    public function test_beranda_menampilkan_label_harga_tier_filter_dan_paket_harga_sinkron_dari_database(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSee('data-filter-kategori="semua"', false)
            ->assertSee('Adat')
            ->assertSee('Islami')
            ->assertSee('Floral')
            ->assertSee('Elegan')
            ->assertSee('Modern')
            ->assertDontSee('Semua Tier')
            ->assertSee('Rp 59.000')
            ->assertSee('Rp 79.000')
            ->assertSee('Rp 89.000')
            ->assertSee('Rp 99.000')
            ->assertSee('Rp 119.000')
            ->assertSee('Rp 129.000')
            ->assertSee('Harga Tema + Rp 50.000')
            ->assertSee('Total mulai Rp 109.000');
    }

    public function test_perubahan_harga_dan_tier_tema_di_database_langsung_tercermin_di_beranda(): void
    {
        $tema = Tema::create([
            'nama_tema' => 'Tema Custom Sultan',
            'slug' => 'custom-sultan',
            'kategori' => 'elegan',
            'tier' => 'eksklusif',
            'harga' => 175000,
            'lokasi_view' => 'tema.luxury-noir.index',
            'aktif' => true,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Tema Custom Sultan')
            ->assertSee('Elegan')
            ->assertSee('Rp 175.000')
            ->assertSee('Total mulai Rp 225.000');

        $tema->update(['kategori' => 'adat', 'tier' => 'premium', 'harga' => 95000]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Adat')
            ->assertSee('Rp 95.000')
            ->assertSee('Total mulai Rp 145.000')
            ->assertDontSee('Rp 175.000');
    }

    public function test_admin_dapat_mengatur_dan_memvalidasi_tier_serta_harga_tema_secara_bebas(): void
    {
        $admin = Pengguna::factory()->admin()->create();

        $this->actingAs($admin)
            ->post('/admin/tema', [
                'nama_tema' => 'Floral Elegan Custom',
                'slug' => 'floral-elegan-custom',
                'kategori' => 'modern',
                'tier' => 'premium',
                'harga' => 85000,
                'lokasi_view' => 'tema.rustic-floral.index',
                'aktif' => '1',
            ])
            ->assertRedirect('/admin/tema');

        $tema = Tema::where('slug', 'floral-elegan-custom')->firstOrFail();
        $this->assertSame('premium', $tema->tier);
        $this->assertSame(85000, $tema->harga);

        $this->actingAs($admin)
            ->put("/admin/tema/{$tema->id}", [
                'nama_tema' => 'Floral Elegan Custom',
                'slug' => 'floral-elegan-custom',
                'kategori' => 'modern',
                'tier' => 'eksklusif',
                'harga' => 135000,
                'lokasi_view' => 'tema.rustic-floral.index',
                'aktif' => '1',
            ])
            ->assertRedirect('/admin/tema');

        $tema->refresh();
        $this->assertSame('eksklusif', $tema->tier);
        $this->assertSame(135000, $tema->harga);

        $this->actingAs($admin)
            ->post('/admin/tema', [
                'nama_tema' => 'Tema Invalid',
                'slug' => 'tema-invalid',
                'kategori' => 'modern',
                'tier' => 'vip_tidak_sah',
                'harga' => -5000,
                'lokasi_view' => 'tema.rustic-floral.index',
            ])
            ->assertSessionHasErrors(['tier', 'harga']);
    }

    public function test_halaman_daftar_dan_live_demo_menampilkan_tier_dan_harga_tema(): void
    {
        $this->seed(DatabaseSeeder::class);

        $tema = Tema::where('slug', 'luxury-noir')->firstOrFail();

        $this->get('/daftar?tema=' . $tema->id)
            ->assertOk()
            ->assertSee('Luxury Noir Monogram')
            ->assertSee('Elegan')
            ->assertSee('Rp 119.000');

        $this->get('/demo/luxury-noir?kanvas=1')
            ->assertOk()
            ->assertSee('data-diorama-3d="eksklusif"', false)
            ->assertDontSee('<div data-bar-pratinjau', false);
    }

    public function test_setiap_tier_dan_tema_merender_karakter_tata_letak_dan_animasi_berbeda(): void
    {
        $this->seed(DatabaseSeeder::class);

        // Basic: bersih & ringan tanpa marquee/shimmer pada elemen kartu
        $this->get('/demo/rustic-floral?kanvas=1')
            ->assertOk()
            ->assertSee('animasi-melayang')
            ->assertDontSee('animasi-marquee flex')
            ->assertDontSee('shadow-lg efek-shimmer-kartu');

        $this->get('/demo/islami-syari?kanvas=1')
            ->assertOk()
            ->assertSee('بِسْمِ اللّٰهِ')
            ->assertDontSee('shadow-lg efek-shimmer-kartu');

        // Premium: layout & animasi sampul berkarakter + marquee + timeline + scroll progress
        $this->get('/demo/editorial-monokrom?kanvas=1')
            ->assertOk()
            ->assertSee('01 / The Groom')
            ->assertSee('02 / The Bride')
            ->assertSee('animasi-marquee flex')
            ->assertSee('scrollPersen')
            ->assertDontSee('shadow-lg efek-shimmer-kartu');

        $this->get('/demo/adat-jawa?kanvas=1')
            ->assertOk()
            ->assertSee('tirai-fade-halus')
            ->assertSee('jawa-bingkai-masuk')
            ->assertSee('jawa-sapu-kiri');

        $this->get('/demo/sunda-heritage?kanvas=1')
            ->assertOk()
            ->assertSee('animasi-kelopak-3d')
            ->assertSee('animasi-awan')
            ->assertSee('tirai-fade-halus');

        $this->get('/demo/royal-ivory?kanvas=1')
            ->assertOk()
            ->assertSee('animasi-segel')
            ->assertSee('tirai-fade-halus');

        // Eksklusif: tirai sinematik + partikel kaya + orbit crest + shimmer kartu + galeri unggulan
        $this->get('/demo/luxury-noir?kanvas=1')
            ->assertOk()
            ->assertSee('animasi-debu-emas')
            ->assertSee('animasi-orbit')
            ->assertSee('efek-shimmer-kartu')
            ->assertSee('col-span-2 aspect-[16/10]');

        $this->get('/demo/velvet-garden?kanvas=1')
            ->assertOk()
            ->assertSee('animasi-kelopak-3d')
            ->assertSee('animasi-kunang')
            ->assertSee('animasi-melayang')
            ->assertSee('efek-shimmer-kartu');

        $this->get('/demo/islamic-heavenly?kanvas=1')
            ->assertOk()
            ->assertSee('animasi-bintang')
            ->assertSee('animasi-bintang-jatuh')
            ->assertSee('animasi-orbit')
            ->assertSee('بِسْمِ اللّٰهِ')
            ->assertSee('efek-shimmer-kartu');
    }

    public function test_demo_setiap_tema_memiliki_isian_mempelai_acara_kutipan_dan_foto_sampul_berbeda(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/demo/adat-jawa?kanvas=1')
            ->assertOk()
            ->assertSee('Akmal')
            ->assertSee('Aisyah')
            ->assertSee('Pendopo Agung Royal Ambarrukmo')
            ->assertSee('sampul-jawa.webp')
            ->assertSee('animasi-gulir-roda')
            ->assertDontSee('Dimas Pratama');

        $this->get('/demo/editorial-monokrom?kanvas=1')
            ->assertOk()
            ->assertSee('Arsen')
            ->assertSee('Kaira')
            ->assertSee('Gallery Atrium Senopati')
            ->assertSee('sampul-editorial.webp')
            ->assertDontSee('Akmal')
            ->assertDontSee('Pendopo Agung Royal Ambarrukmo');

        $this->get('/demo/sunda-heritage?kanvas=1')
            ->assertOk()
            ->assertSee('Bagja')
            ->assertSee('Nenden')
            ->assertSee('Gedung Pendopo Kota Bandung')
            ->assertSee('sampul-sunda.webp');

        $this->get('/demo/islami-syari?kanvas=1')
            ->assertOk()
            ->assertSee('Zayd')
            ->assertSee('Fatimah')
            ->assertSee('Masjid Istiqlal')
            ->assertSee('sampul-islami.webp');

        $this->get('/demo/luxury-noir?kanvas=1')
            ->assertOk()
            ->assertSee('Alvaro')
            ->assertSee('Clarissa')
            ->assertSee('The St. Regis Astor Chapel')
            ->assertSee('sampul-luxury.webp');
    }

    public function test_demo_tanpa_foto_menyembunyikan_foto_sampul_dan_galeri_tema(): void
    {
        $this->seed(DatabaseSeeder::class);

        foreach (['adat-jawa', 'luxury-noir', 'islami-syari'] as $slugTema) {
            $latarDiharapkan = $slugTema === 'adat-jawa'
                ? 'aset-tema/adat-jawa/latar-hutan-jawa.webp'
                : "aset-tema/{$slugTema}/latar-utama.webp";

            $this->get("/demo/{$slugTema}?kanvas=1&tf=1")
                ->assertOk()
                ->assertDontSee('<div data-bar-pratinjau', false)
                ->assertSee($latarDiharapkan)
                ->assertDontSee('sampul-')
                ->assertDontSee('mempelai-pria.webp')
                ->assertDontSee('mempelai-wanita.webp')
                ->assertDontSee('galeri-');
        }
    }

    public function test_client_dapat_mengunggah_dan_menghapus_foto_sampul_yang_hormati_mode_tanpa_foto(): void
    {
        Storage::fake('public');
        $this->seed(DatabaseSeeder::class);

        $client = Pengguna::factory()->create();
        $tema = Tema::where('slug', 'adat-jawa')->firstOrFail();

        $undangan = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $tema->id,
            'slug' => 'pratama-putri-sampul',
            'nama_panggilan_pria' => 'Pratama',
            'nama_lengkap_pria' => 'Pratama Wijaya',
            'nama_panggilan_wanita' => 'Putri',
            'nama_lengkap_wanita' => 'Putri Lestari',
            'status_publikasi' => false,
            'pengaturan' => ['tanpa_foto' => false],
        ]);

        $img = imagecreatetruecolor(800, 1200);
        imagefill($img, 0, 0, imagecolorallocate($img, 120, 90, 60));
        $tmpPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid('sampul_', true) . '.png';
        imagepng($img, $tmpPath);
        imagedestroy($img);
        $fileSampul = new UploadedFile($tmpPath, 'sampul.png', 'image/png', null, true);

        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'mempelai',
                'nama_panggilan_pria' => 'Pratama',
                'nama_lengkap_pria' => 'Pratama Wijaya',
                'nama_panggilan_wanita' => 'Putri',
                'nama_lengkap_wanita' => 'Putri Lestari',
                'foto_sampul' => $fileSampul,
            ])
            ->assertRedirect("/dashboard/undangan/{$undangan->id}/kelola");

        $undangan->refresh();
        $pathSampul = $undangan->pengaturan['foto_sampul'] ?? null;
        $this->assertNotNull($pathSampul);
        $this->assertStringEndsWith('.webp', $pathSampul);
        Storage::disk('public')->assertExists($pathSampul);

        $this->get('/pratama-putri-sampul')
            ->assertOk()
            ->assertSee('foto-sampul-');

        $undangan->update([
            'pengaturan' => array_merge($undangan->pengaturan ?? [], ['tanpa_foto' => true]),
        ]);

        $this->get('/pratama-putri-sampul')
            ->assertOk()
            ->assertDontSee('foto-sampul-');

        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'mempelai',
                'nama_panggilan_pria' => 'Pratama',
                'nama_lengkap_pria' => 'Pratama Wijaya',
                'nama_panggilan_wanita' => 'Putri',
                'nama_lengkap_wanita' => 'Putri Lestari',
                'hapus_foto_sampul' => '1',
            ])
            ->assertRedirect("/dashboard/undangan/{$undangan->id}/kelola");

        $undangan->refresh();
        $this->assertNull($undangan->pengaturan['foto_sampul'] ?? null);
        Storage::disk('public')->assertMissing($pathSampul);
    }

    public function test_simpan_bagian_kelola_langsung_arahkan_ke_tab_berikutnya_tanpa_alert_duplikat(): void
    {
        $this->seed(DatabaseSeeder::class);

        $client = Pengguna::factory()->create();
        $tema = Tema::where('slug', 'adat-jawa')->firstOrFail();

        $undangan = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $tema->id,
            'slug' => 'uji-lanjut-tab',
            'nama_panggilan_pria' => 'Dimas',
            'nama_lengkap_pria' => 'Dimas Pratama',
            'nama_panggilan_wanita' => 'Maya',
            'nama_lengkap_wanita' => 'Maya Sari',
            'status_publikasi' => false,
        ]);

        // Tab 1 (tema) -> Tab 2 (mempelai)
        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'tema',
                'tema_id' => $tema->id,
                'slug' => 'uji-lanjut-tab',
                'gaya_font' => 'bawaan',
            ])
            ->assertRedirect("/dashboard/undangan/{$undangan->id}/kelola")
            ->assertSessionHas('tab_aktif', 'mempelai')
            ->assertSessionHas('sukses', 'Perubahan undangan berhasil disimpan.');

        // Halaman kelola menampilkan atribut SweetAlert saja (tanpa banner sukses inline di atas tab)
        $this->actingAs($client)
            ->withSession([
                'tab_aktif' => 'mempelai',
                'sukses' => 'Perubahan undangan berhasil disimpan.',
            ])
            ->get("/dashboard/undangan/{$undangan->id}/kelola")
            ->assertOk()
            ->assertSee('data-swal-success="Perubahan undangan berhasil disimpan."', false)
            ->assertDontSee('rounded-xl bg-sage/10 border border-sage/30 px-4 py-3 text-sm text-sage', false);

        // Tab 2 (mempelai) -> Tab 3 (acara)
        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'mempelai',
                'nama_panggilan_pria' => 'Dimas',
                'nama_lengkap_pria' => 'Dimas Pratama',
                'nama_panggilan_wanita' => 'Maya',
                'nama_lengkap_wanita' => 'Maya Sari',
            ])
            ->assertRedirect("/dashboard/undangan/{$undangan->id}/kelola")
            ->assertSessionHas('tab_aktif', 'acara');

        // Tab 4 (cerita_streaming) -> Tab 5 (amplop)
        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'cerita_streaming',
                'cerita_cinta' => [
                    ['judul' => 'Pertama Bertemu', 'tanggal' => '2024', 'cerita' => 'Berawal di kafe.'],
                ],
            ])
            ->assertRedirect("/dashboard/undangan/{$undangan->id}/kelola")
            ->assertSessionHas('tab_aktif', 'amplop');

        // Tab 6 (kado_fisik) -> Tab 7 (penutup)
        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'kado_fisik',
                'alamat_kado_fisik' => 'Jl. Merdeka No. 10, Jakarta',
            ])
            ->assertRedirect("/dashboard/undangan/{$undangan->id}/kelola")
            ->assertSessionHas('tab_aktif', 'penutup');

        // Halaman kelola menampilkan dropzone pratinjau foto mempelai, mockup sampul, & template kutipan cepat
        $this->actingAs($client)
            ->get("/dashboard/undangan/{$undangan->id}/kelola?tab=mempelai")
            ->assertOk()
            ->assertSee('Pratinjau Sampul Undangan')
            ->assertSee('Pilih atau Seret Foto Sampul')
            ->assertSee('+ QS. Ar-Rum: 21')
            ->assertSee('Pilih atau Seret Foto Prewedding')
            ->assertSee('<textarea', false)
            ->assertSee('name="galeri_foto[]"', false)
            ->assertSee('Keterangan (opsional)...');
    }

    public function test_url_foto_galeri_mengikuti_host_permintaan_bukan_terkunci_app_url(): void
    {
        $this->seed(DatabaseSeeder::class);

        $client = Pengguna::factory()->create();
        $tema = Tema::firstOrFail();

        $undangan = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $tema->id,
            'slug' => 'uji-host-galeri',
            'nama_panggilan_pria' => 'Dimas',
            'nama_lengkap_pria' => 'Dimas Pratama',
            'nama_panggilan_wanita' => 'Maya',
            'nama_lengkap_wanita' => 'Maya Sari',
            'foto_pria' => 'undangan/99/mempelai-pria.webp',
        ]);

        $undangan->daftarGaleri()->create([
            'lokasi_foto' => 'undangan/99/hari-tunangan.webp',
            'keterangan' => 'Hari Tunangan',
            'urutan' => 1,
        ]);

        $this->actingAs($client)
            ->get('http://127.0.0.1:8000/dashboard/undangan/' . $undangan->id . '/kelola?tab=galeri')
            ->assertOk()
            ->assertSee('http://127.0.0.1:8000/storage/undangan/99/hari-tunangan.webp', false);

        $this->get('http://127.0.0.1:8000/uji-host-galeri')
            ->assertOk()
            ->assertSee('http://127.0.0.1:8000/storage/undangan/99/mempelai-pria.webp', false)
            ->assertSee('http://127.0.0.1:8000/storage/undangan/99/hari-tunangan.webp', false);

        $undangan->daftarAcara()->create([
            'nama_acara' => 'Akad Nikah',
            'tanggal_acara' => now()->addDays(10)->toDateString(),
            'waktu_mulai' => '08:00:00',
            'waktu_selesai' => '10:00:00',
            'zona_waktu' => 'WIB',
            'nama_tempat' => 'Masjid Agung',
            'alamat_lengkap' => 'Jl. Merdeka No. 1',
            'link_maps' => 'https://maps.google.com/?q=Masjid+Agung',
        ]);

        $this->actingAs($client)
            ->get("/dashboard/undangan/{$undangan->id}/kelola?tab=acara")
            ->assertOk()
            ->assertSee('Daftar Jadwal Terpasang')
            ->assertSee('1 Acara')
            ->assertSee('Acara #1')
            ->assertSee('H-10 Hari')
            ->assertSee('Buka Google Maps')
            ->assertSee('+ Akad Nikah');

        $this->actingAs($client)
            ->get("/dashboard/undangan/{$undangan->id}/kelola?tab=galeri")
            ->assertOk()
            ->assertSee('Linimasa Romantis')
            ->assertSee('Pratinjau Tampilan Tamu')
            ->assertSee('+ Pertama Bertemu')
            ->assertSee('Fitur Live Streaming Pernikahan');

        $undangan->daftarAmplop()->create([
            'nama_bank' => 'BCA',
            'nomor_rekening' => '1234567890',
            'atas_nama' => 'Dimas Pratama',
        ]);

        $undangan->daftarAmplop()->create([
            'nama_bank' => 'GoPay',
            'nomor_rekening' => '081234567890',
            'atas_nama' => 'Maya Sari',
        ]);

        $this->actingAs($client)
            ->get("/dashboard/undangan/{$undangan->id}/kelola?tab=amplop")
            ->assertOk()
            ->assertSee('Pratinjau Kartu Bank Live')
            ->assertSee('Koleksi Kartu Rekening Tersimpan')
            ->assertSee('Bank Central Asia')
            ->assertSee('Dompet Digital GoPay')
            ->assertSee('1234 5678 90')
            ->assertSee('#0057B8', false)
            ->assertSee('#00AED6', false)
            ->assertSee('data-simpan-semua', false)
            ->assertSee('Menyimpan semua perubahan...')
            ->assertSee('name="galeri_foto[]"', false)
            ->assertSee('Pilih atau Seret Foto Prewedding')
            ->assertSee('Menambahkan Kartu Rekening...')
            ->assertSee('Menghapus Rekening...')
            ->assertDontSee('onsubmit="return confirm', false);

        // Halaman Tamu & RSVP dalam mode draft mengunci tombol Kirim WA
        $this->actingAs($client)
            ->get("/dashboard/undangan/{$undangan->id}/tamu")
            ->assertOk()
            ->assertSee('Mode Simulasi — Aktifkan Undangan untuk Menyebar Link WA')
            ->assertSee('Bayar &amp; Aktifkan Undangan', false)
            ->assertDontSee(':href="tamu.waUrl"', false);

        // Setelah undangan diaktifkan, tombol Salin & Kirim WA pada halaman Tamu & RSVP terbuka
        $undangan->update([
            'status_publikasi' => true,
            'berlaku_sampai' => now()->addMonths(3),
        ]);

        $this->actingAs($client)
            ->get("/dashboard/undangan/{$undangan->id}/tamu")
            ->assertOk()
            ->assertDontSee('Mode Simulasi — Aktifkan Undangan untuk Menyebar Link WA')
            ->assertSee(':href="tamu.waUrl"', false);

        // Jika masa aktif sudah habis, Kirim WA kembali dikunci
        $undangan->update([
            'berlaku_sampai' => now()->subDay(),
        ]);

        $this->actingAs($client)
            ->get("/dashboard/undangan/{$undangan->id}/tamu")
            ->assertOk()
            ->assertSee('Kirim WA Dikunci — Masa Aktif Undangan Berakhir')
            ->assertDontSee(':href="tamu.waUrl"', false);

        $this->actingAs($client)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Membuat Draft Undangan...')
            ->assertSee('Keluar dari Akun...');
    }

    public function test_urutan_editor_sesuai_undangan_dan_sakelar_fitur_langsung_di_tiap_bagian(): void
    {
        $this->seed(DatabaseSeeder::class);

        $client = Pengguna::factory()->create();
        $tema = Tema::firstOrFail();

        $undangan = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $tema->id,
            'slug' => 'uji-urutan-editor',
            'nama_panggilan_pria' => 'Dodi',
            'nama_lengkap_pria' => 'Dodi Pratama',
            'nama_panggilan_wanita' => 'Windy',
            'nama_lengkap_wanita' => 'Windy Sari',
            'pengaturan' => Undangan::pengaturanBawaan(),
        ]);

        $html = $this->actingAs($client)
            ->get("/dashboard/undangan/{$undangan->id}/kelola")
            ->assertOk()
            ->assertDontSee('Sakelar Fitur Undangan')
            ->assertSee('data-toggle-fitur="hitung_mundur"', false)
            ->assertSee('data-toggle-fitur="cerita_cinta"', false)
            ->assertSee('data-toggle-fitur="galeri"', false)
            ->assertSee('data-toggle-fitur="amplop_digital"', false)
            ->assertSee('data-toggle-fitur="buku_tamu"', false)
            ->assertSee('data-toggle-fitur="doa_pengantin"', false)
            ->assertSee('role="switch"', false)
            ->assertSee('name="teks[sampul_judul]"', false)
            ->assertSee('name="teks[sampul_sapaan]"', false)
            ->assertSee('name="teks[sampul_catatan]"', false)
            ->assertSee('name="teks[judul_mempelai]"', false)
            ->assertSee('name="teks[pengantar_mempelai]"', false)
            ->assertSee('name="teks[judul_hitung_mundur]"', false)
            ->assertSee('name="teks[pengantar_hitung_mundur]"', false)
            ->assertSee('name="teks[judul_acara]"', false)
            ->assertSee('name="teks[judul_cerita]"', false)
            ->assertSee('name="teks[judul_galeri]"', false)
            ->assertSee('name="teks[judul_amplop]"', false)
            ->assertSee('name="teks[pengantar_amplop]"', false)
            ->assertSee('name="teks[judul_buku_tamu]"', false)
            ->assertSee('name="teks[doa_judul]"', false)
            ->assertSee('name="teks[judul_turut_mengundang]"', false)
            ->assertSee('name="teks[judul_penutup]"', false)
            ->assertSee('name="teks[ucapan_penutup]"', false)
            ->getContent();

        $urutan = ['tema', 'mempelai', 'acara', 'cerita', 'galeri', 'amplop', 'penutup', 'aktivasi'];
        $posisiSebelumnya = -1;
        foreach ($urutan as $kodeTab) {
            $jumlah = substr_count($html, "data-mobile-tab=\"{$kodeTab}\"");
            $this->assertSame(1, $jumlah, "Tab {$kodeTab} wajib muncul tepat 1 kali di editor.");
            $pos = strpos($html, "data-mobile-tab=\"{$kodeTab}\"");
            $this->assertGreaterThan($posisiSebelumnya, $pos, "Tab {$kodeTab} harus berada sesuai urutan undangan.");
            $posisiSebelumnya = $pos;
        }
        foreach (['hitung_mundur', 'cerita_cinta', 'galeri', 'amplop_digital', 'buku_tamu', 'doa_pengantin'] as $kodeFitur) {
            $this->assertSame(1, substr_count($html, "data-toggle-fitur=\"{$kodeFitur}\""), "Sakelar {$kodeFitur} wajib muncul tepat 1 kali.");
        }

        // Pastikan urutan isi form di editor mengikuti alur undangan dari atas (Sampul) hingga bawah (Penutup)
        $urutanIsiUndangan = [
            'name="foto_sampul"',
            'name="teks[sampul_judul]"',
            'name="kutipan_ayat"',
            'name="foto_pembuka"',
            'name="nama_panggilan_pria"',
            'data-toggle-fitur="hitung_mundur"',
            'name="foto_hitung_mundur[]"',
            'name="teks[judul_hitung_mundur]"',
            'name="nama_acara"',
            'name="dress_code_catatan"',
            'name="live_platform"',
            'name="teks[judul_cerita]"',
            'name="teks[judul_galeri]"',
            'name="galeri_foto[]"',
            'name="teks[judul_amplop]"',
            'name="nama_bank"',
            'name="alamat_kado_fisik"',
            'name="teks[judul_buku_tamu]"',
            'data-toggle-fitur="doa_pengantin"',
            'name="turut_mengundang_wanita"',
            'name="foto_penutup"',
            'name="teks[ucapan_penutup]"',
            'name="hashtag"',
        ];
        $posisiIsi = -1;
        foreach ($urutanIsiUndangan as $penanda) {
            $pos = strpos($html, $penanda);
            $this->assertNotFalse($pos, "Penanda {$penanda} wajib ada di halaman editor.");
            $this->assertGreaterThan($posisiIsi, $pos, "Urutan {$penanda} harus mengikuti urutan isi undangan dari atas ke bawah.");
            $posisiIsi = $pos;
        }

        // Pastikan struktur 2 kolom (Panel Kiri & Panel Kanan sejajar, tidak jatuh ke bawah) dan tidak ada JS bocor dari atribut x-data
        $dom = new \DOMDocument();
        @$dom->loadHTML('<?xml encoding="utf-8" ?>'.$html);
        $xpath = new \DOMXPath($dom);
        $panelKiri = $xpath->query("//*[@x-ref='panelKiri']/parent::div")->item(0);
        $panelKanan = $xpath->query("//*[@x-ref='stagePreview']/parent::div")->item(0);
        $this->assertNotNull($panelKiri, 'Panel kiri wajib ter-render.');
        $this->assertNotNull($panelKanan, 'Panel kanan wajib ter-render.');
        $this->assertSame($panelKiri->parentNode, $panelKanan->parentNode, 'Panel kanan wajib sejajar (sibling) dengan panel kiri.');
        $teksTanpaSkrip = '';
        foreach ($xpath->query('//body//text()[not(ancestor::script) and not(ancestor::style)]') as $nodeTeks) {
            $teksTanpaSkrip .= $nodeTeks->nodeValue;
        }
        $this->assertStringNotContainsString('kirimLivePreview', $teksTanpaSkrip, 'Skrip Alpine tidak boleh bocor sebagai teks halaman.');
        $this->assertStringNotContainsString('kumpulkanPayloadLive', $teksTanpaSkrip, 'Atribut x-data tidak boleh terpotong tanda kutip.');

        // Toggle langsung per fitur via POST + _method PUT (sesuai fetch browser) tersimpan tanpa merusak fitur lain
        $this->actingAs($client)
            ->postJson("/dashboard/undangan/{$undangan->id}", [
                '_method' => 'PUT',
                'bagian' => 'fitur',
                'kunci' => 'galeri',
                'aktif' => false,
            ])
            ->assertOk()
            ->assertJson(['ok' => true, 'kunci' => 'galeri', 'aktif' => false]);

        $this->actingAs($client)
            ->postJson("/dashboard/undangan/{$undangan->id}", [
                '_method' => 'PUT',
                'bagian' => 'fitur',
                'kunci' => 'doa_pengantin',
                'aktif' => false,
            ])
            ->assertOk()
            ->assertJson(['ok' => true, 'kunci' => 'doa_pengantin', 'aktif' => false]);

        $undangan->refresh();
        $this->assertFalse($undangan->fiturAktif('galeri'));
        $this->assertFalse($undangan->fiturAktif('doa_pengantin'));
        $this->assertTrue($undangan->fiturAktif('cerita_cinta'));

        // Simpan tab Tema + teks sampul kustom tanpa input fitur_* wajib mempertahankan sakelar fitur sebelumnya
        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'tema',
                'tema_id' => $tema->id,
                'slug' => 'uji-urutan-editor',
                'gaya_font' => 'bawaan',
                'teks' => [
                    'sampul_judul' => 'Undangan Pernikahan Spesial',
                    'sampul_tombol' => 'Masuk Undangan',
                    'sampul_sapaan' => 'Untuk Sahabat Tercinta',
                    'sampul_catatan' => 'Catatan sampul kustom kami',
                ],
            ])
            ->assertRedirect("/dashboard/undangan/{$undangan->id}/kelola");

        $undangan->refresh();
        $this->assertFalse($undangan->fiturAktif('galeri'));
        $this->assertTrue($undangan->fiturAktif('amplop_digital'));

        // Simpan teks kustom mempelai & penutup (termasuk doa pengantin kustom)
        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'mempelai',
                'nama_panggilan_pria' => 'Dodi',
                'nama_lengkap_pria' => 'Dodi Pratama',
                'nama_panggilan_wanita' => 'Windy',
                'nama_lengkap_wanita' => 'Windy Sari',
                'nama_ayah_pria' => 'Bpk. Pratama',
                'nama_ibu_pria' => 'Ibu Ratna',
                'nama_ayah_wanita' => 'Bpk. Santoso',
                'nama_ibu_wanita' => 'Ibu Sari',
                'teks' => [
                    'judul_mempelai' => 'Dua Hati Bersatu',
                    'pengantar_mempelai' => 'Kami mengundang sahabat terbaik pada hari bahagia kami.',
                    'label_pria' => 'Putra pertama dari',
                    'label_wanita' => 'Putri bungsu dari',
                ],
            ])
            ->assertSessionHas('tab_aktif', 'acara');

        // Simpan bagian terpisah (acara_tambahan, cerita, penutup) tanpa saling menimpa
        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'acara_tambahan',
                'live_aktif' => '1',
                'live_platform' => 'YouTube Live',
                'live_link' => 'https://youtube.com/live/dodi-windy',
                'dress_code_disertakan' => '1',
                'dress_code_catatan' => 'Batik & Pastel',
                'dress_code_warna' => ['#4B6358', '#D7BB83'],
                'teks' => [
                    'judul_hitung_mundur' => 'Menuju Hari Bahagia',
                    'pengantar_hitung_mundur' => 'Hitung hari menuju akad dan resepsi kami.',
                    'judul_acara' => 'Jadwal Bahagia Kami',
                ],
            ])
            ->assertSessionHas('tab_aktif', 'cerita');

        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'cerita',
                'cerita_cinta' => [
                    ['judul' => 'Awal Bertemu', 'tanggal' => '2023', 'cerita' => 'Di kampus.'],
                ],
                'teks' => [
                    'judul_cerita' => 'Perjalanan Cinta Kami',
                ],
            ])
            ->assertSessionHas('tab_aktif', 'galeri');

        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'galeri',
                'teks' => [
                    'judul_galeri' => 'Album Kenangan Kami',
                ],
            ])
            ->assertSessionHas('tab_aktif', 'galeri');

        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'kado_fisik',
                'alamat_kado_fisik' => 'Jl. Melati No. 8, Bandung',
                'teks' => [
                    'judul_amplop' => 'Tanda Kasih Keluarga',
                    'pengantar_amplop' => 'Doa restu sudah sangat berarti bagi kami.',
                ],
            ])
            ->assertSessionHas('tab_aktif', 'penutup');

        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'penutup',
                'doa_disertakan' => '1',
                'turut_mengundang_wanita' => 'Keluarga Besar Ibu Sari',
                'turut_mengundang_pria' => 'Keluarga Besar Bpk. Pratama',
                'teks' => [
                    'judul_buku_tamu' => 'Konfirmasi & Doa Tamu',
                    'doa_judul' => 'Doa Restu Keluarga',
                    'doa_arab' => '',
                    'doa_latin' => '',
                    'doa_isi' => 'Semoga rumah tangga selalu rukun dan penuh berkah.',
                    'judul_turut_mengundang' => 'Keluarga Yang Berbahagia',
                    'judul_penutup' => 'Matur Nuwun Sanget',
                    'ucapan_penutup' => 'Terima kasih banyak atas doa dan kehadirannya.',
                    'label_penutup' => 'Salam Hangat Dari Kami',
                ],
            ])
            ->assertSessionHas('tab_aktif', 'aktivasi');

        $undangan->refresh();
        $this->assertTrue((bool) data_get($undangan->pengaturan, 'live_streaming.aktif'));
        $this->assertSame('Batik & Pastel', $undangan->dressCodeCatatan());
        $this->assertSame('Awal Bertemu', data_get($undangan->pengaturan, 'cerita_cinta.0.judul'));
        $this->assertSame(['Keluarga Besar Ibu Sari'], $undangan->turutMengundangWanita());
        $this->assertSame(['Keluarga Besar Bpk. Pratama'], $undangan->turutMengundangPria());

        // Saat sakelar doa_pengantin mati, seksi doa tidak tampil di pratinjau/publik; teks kustom lain tetap tampil
        $this->actingAs($client)
            ->get("/{$undangan->slug}")
            ->assertOk()
            ->assertSee('Undangan Pernikahan Spesial')
            ->assertSee('Masuk Undangan')
            ->assertSee('Untuk Sahabat Tercinta')
            ->assertSee('Catatan sampul kustom kami')
            ->assertSee('Dua Hati Bersatu')
            ->assertSee('Kami mengundang sahabat terbaik pada hari bahagia kami.')
            ->assertSee('Putra pertama dari')
            ->assertSee('Putri bungsu dari')
            ->assertSee('Perjalanan Cinta Kami')
            ->assertSee('Tanda Kasih Keluarga')
            ->assertSee('Konfirmasi &amp; Doa Tamu', false)
            ->assertSee('Keluarga Yang Berbahagia')
            ->assertSee('Matur Nuwun Sanget')
            ->assertSee('Terima kasih banyak atas doa dan kehadirannya.')
            ->assertSee('Salam Hangat Dari Kami')
            ->assertDontSee('data-section-doa-pengantin=', false);

        // Nyalakan kembali doa_pengantin -> judul & isi doa kustom muncul tanpa teks Arab bawaan
        $this->actingAs($client)
            ->postJson("/dashboard/undangan/{$undangan->id}", [
                '_method' => 'PUT',
                'bagian' => 'fitur',
                'kunci' => 'doa_pengantin',
                'aktif' => true,
            ])
            ->assertOk();

        $this->actingAs($client)
            ->get("/{$undangan->slug}")
            ->assertOk()
            ->assertSee('data-section-doa-pengantin=', false)
            ->assertSee('Doa Restu Keluarga')
            ->assertSee('Semoga rumah tangga selalu rukun dan penuh berkah.')
            ->assertDontSee('HR. Abu Daud');

        // Live preview langsung merender perubahan yang belum disimpan tanpa mengubah database
        $this->actingAs($client)
            ->post("/dashboard/undangan/{$undangan->id}/pratinjau-langsung", [
                'nama_panggilan_pria' => 'RakaLive',
                'nama_lengkap_pria' => 'Raka Live Preview',
                'nama_panggilan_wanita' => 'SintaLive',
                'nama_lengkap_wanita' => 'Sinta Live Preview',
                'kutipan_ayat' => 'Ayat langsung terlihat di pratinjau.',
                'gaya_font' => 'editorial',
                'tanpa_foto' => false,
                'teks' => [
                    'sampul_judul' => 'Judul Sampul Live',
                    'judul_mempelai' => 'Judul Mempelai Live',
                    'ucapan_penutup' => 'Ucapan penutup live sebelum klik simpan.',
                ],
                'foto_live' => [
                    'foto_pria' => 'blob:http://127.0.0.1:8000/uji-blob-pria',
                ],
                'buka_sampul' => true,
                'fokus_bagian' => 'mempelai',
            ])
            ->assertOk()
            ->assertSee('RakaLive')
            ->assertSee('SintaLive')
            ->assertSee('Judul Sampul Live')
            ->assertSee('Judul Mempelai Live')
            ->assertSee('Ayat langsung terlihat di pratinjau.')
            ->assertSee('Ucapan penutup live sebelum klik simpan.')
            ->assertSee('blob:http://127.0.0.1:8000/uji-blob-pria', false)
            ->assertSee('__SESITEMU_LIVE_PREVIEW__', false)
            ->assertDontSee('data-intro-pembuka=', false);

        // Pastikan database tidak berubah selama hanya pratinjau live
        $undangan->refresh();
        $this->assertSame('Dodi', $undangan->nama_panggilan_pria);
        $this->assertSame('Windy', $undangan->nama_panggilan_wanita);

        // Client lain tidak boleh mengakses live preview undangan milik orang lain
        $clientLain = Pengguna::factory()->create(['peran' => 'client']);
        $this->actingAs($clientLain)
            ->post("/dashboard/undangan/{$undangan->id}/pratinjau-langsung", [
                'nama_panggilan_pria' => 'Hacker',
            ])
            ->assertForbidden();
    }

    public function test_input_teks_terisi_value_bawaan_tema_dan_customer_bisa_unggah_musik_sendiri(): void
    {
        Storage::fake('public');
        $this->seed(DatabaseSeeder::class);

        $client = Pengguna::factory()->create(['peran' => 'client']);
        $temaJawa = Tema::where('slug', 'adat-jawa')->firstOrFail();

        $undangan = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $temaJawa->id,
            'slug' => 'uji-bawaan-dan-musik',
            'nama_panggilan_pria' => 'Dodi',
            'nama_lengkap_pria' => 'Dodi Pratama',
            'nama_panggilan_wanita' => 'Windy',
            'nama_lengkap_wanita' => 'Windy Sari',
            'musik_latar' => 'musik/gamelan-lembut.mp3',
            'pengaturan' => Undangan::pengaturanBawaan(),
            'status_publikasi' => true,
            'berlaku_sampai' => now()->addMonths(3),
        ]);

        // 1. Halaman editor mengisi value input sesuai bawaan tema aktif & menyediakan unggah musik sendiri
        $this->actingAs($client)
            ->get("/dashboard/undangan/{$undangan->id}/kelola")
            ->assertOk()
            ->assertSee('value="The Wedding of"', false)
            ->assertSee('value="Buka Undangan"', false)
            ->assertSee('value="Kepada Yth. Bapak/Ibu/Saudara/i"', false)
            ->assertSee('value="Mohon maaf apabila ada kesalahan penulisan nama/gelar"', false)
            ->assertSee('value="We Are Getting Married!"', false)
            ->assertSee('value="Our Love Story"', false)
            ->assertSee('value="Our Gallery"', false)
            ->assertSee('value="#DodiWindyTogether"', false)
            ->assertSee('name="file_musik_kustom"', false)
            ->assertSee('Musik Sendiri')
            ->assertSee('Atur Potongan Foto')
            ->assertSee('Terapkan Potongan')
            ->assertSee('Potret Kapsul (11:18)')
            ->assertSee('9:16 Sampul Penuh')
            ->assertSee('4:3 Cerita');

        // Verifikasi rasio crop menyesuaikan tema aktif saat berganti tema (mis. Editorial Monokrom)
        $temaEditorial = Tema::where('slug', 'editorial-monokrom')->firstOrFail();
        $undangan->update(['tema_id' => $temaEditorial->id]);
        $this->actingAs($client)
            ->get("/dashboard/undangan/{$undangan->id}/kelola")
            ->assertOk()
            ->assertSee('3:4 Editorial')
            ->assertSee('16:10 Cerita');
        $undangan->update(['tema_id' => $temaJawa->id]);

        // 2. Menyimpan nilai bawaan tanpa diubah tetap menyimpan string kosong (tidak mengunci ke tema lama)
        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'tema',
                'tema_id' => $temaJawa->id,
                'slug' => 'uji-bawaan-dan-musik',
                'sumber_musik' => 'katalog',
                'musik_latar' => 'musik/gamelan-lembut.mp3',
                'gaya_font' => 'bawaan',
                'teks' => [
                    'sampul_judul' => 'The Wedding of',
                    'sampul_tombol' => 'Buka Undangan',
                    'sampul_sapaan' => 'Kepada Yth. Bapak/Ibu/Saudara/i',
                    'sampul_catatan' => 'Mohon maaf apabila ada kesalahan penulisan nama/gelar',
                ],
            ])
            ->assertRedirect("/dashboard/undangan/{$undangan->id}/kelola")
            ->assertSessionHasNoErrors();

        $undangan->refresh();
        $this->assertSame('', (string) data_get($undangan->pengaturan, 'teks.sampul_judul', ''));
        $this->assertSame('', (string) data_get($undangan->pengaturan, 'teks.sampul_tombol', ''));

        // 3. Format audio tidak valid ditolak
        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'tema',
                'sumber_musik' => 'kustom',
                'file_musik_kustom' => UploadedFile::fake()->create('bukan-lagu.txt', 10, 'text/plain'),
            ])
            ->assertSessionHasErrors('file_musik_kustom');

        // 4. Customer mengunggah musik sendiri -> tersimpan, aktif di undangan publik, dan bisa diputar
        $audioKustom = UploadedFile::fake()->create('lagu-favorit-kami.mp3', 512, 'audio/mpeg');

        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'tema',
                'tema_id' => $temaJawa->id,
                'slug' => 'uji-bawaan-dan-musik',
                'sumber_musik' => 'kustom',
                'gaya_font' => 'bawaan',
                'file_musik_kustom' => $audioKustom,
            ])
            ->assertRedirect("/dashboard/undangan/{$undangan->id}/kelola")
            ->assertSessionHasNoErrors();

        $undangan->refresh();
        $pathMusikKustom = $undangan->musik_latar;
        $this->assertNotNull($pathMusikKustom);
        $this->assertStringStartsWith("storage/undangan/{$undangan->id}/musik/", $pathMusikKustom);
        $this->assertTrue($undangan->pakaiMusikKustom());
        $this->assertSame('lagu-favorit-kami.mp3', $undangan->musikKustom()['nama'] ?? null);
        Storage::disk('public')->assertExists(substr($pathMusikKustom, 8));

        // Halaman undangan publik menggunakan audio kustom tersebut
        $this->get('/uji-bawaan-dan-musik')
            ->assertOk()
            ->assertSee($pathMusikKustom, false);

        // Simpan ulang tab tema tanpa unggah ulang file saat sumber_musik=kustom tetap mempertahankan musik sendiri
        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'tema',
                'sumber_musik' => 'kustom',
                'musik_latar' => '',
                'gaya_font' => 'bawaan',
            ])
            ->assertSessionHasNoErrors();

        $this->assertSame($pathMusikKustom, $undangan->fresh()->musik_latar);

        // 5. Hapus musik kustom -> file terhapus bersih dari storage dan kembali ke pilihan katalog
        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'tema',
                'sumber_musik' => 'katalog',
                'musik_latar' => 'musik/gamelan-lembut.mp3',
                'hapus_musik_kustom' => '1',
                'gaya_font' => 'bawaan',
            ])
            ->assertSessionHasNoErrors();

        $undangan->refresh();
        $this->assertNull($undangan->musikKustom());
        $this->assertFalse($undangan->pakaiMusikKustom());
        $this->assertSame('musik/gamelan-lembut.mp3', $undangan->musik_latar);
        Storage::disk('public')->assertMissing(substr($pathMusikKustom, 8));
    }

    public function test_toggle_fitur_put_json_dan_tombol_simpan_semua_tanpa_refresh(): void
    {
        Storage::fake('public');
        $this->seed(DatabaseSeeder::class);

        $client = Pengguna::factory()->create(['peran' => 'client']);
        $temaJawa = Tema::where('slug', 'adat-jawa')->firstOrFail();

        $undangan = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $temaJawa->id,
            'slug' => 'uji-simpan-semua',
            'nama_panggilan_pria' => 'Dodi',
            'nama_lengkap_pria' => 'Dodi Pratama',
            'nama_panggilan_wanita' => 'Windy',
            'nama_lengkap_wanita' => 'Windy Sari',
            'pengaturan' => Undangan::pengaturanBawaan(),
            'status_publikasi' => false,
        ]);

        // 1. Editor hanya menampilkan satu tombol Simpan Semua (bukan tombol simpan per bagian)
        $this->actingAs($client)
            ->get("/dashboard/undangan/{$undangan->id}/kelola")
            ->assertOk()
            ->assertSee('data-simpan-semua', false)
            ->assertSee('Simpan Semua')
            ->assertDontSee('Simpan Sampul &amp; Lanjut', false)
            ->assertDontSee('Simpan Ayat &amp; Mempelai', false)
            ->assertDontSee('Simpan Cerita &amp; Lanjut', false)
            ->assertDontSee('Simpan Penutup &amp; Lanjut', false);

        // 2. Toggle ON/OFF seluruh 6 fitur melalui PUT JSON (persis seperti fetch() di browser)
        foreach (['hitung_mundur', 'cerita_cinta', 'galeri', 'amplop_digital', 'buku_tamu', 'doa_pengantin'] as $kunciFitur) {
            $this->actingAs($client)
                ->putJson("/dashboard/undangan/{$undangan->id}", [
                    'bagian' => 'fitur',
                    'kunci' => $kunciFitur,
                    'aktif' => false,
                ])
                ->assertOk()
                ->assertJson([
                    'ok' => true,
                    'kunci' => $kunciFitur,
                    'aktif' => false,
                ]);
        }

        $undangan->refresh();
        foreach (['hitung_mundur', 'cerita_cinta', 'galeri', 'amplop_digital', 'buku_tamu', 'doa_pengantin'] as $kunciFitur) {
            $this->assertFalse($undangan->fiturAktif($kunciFitur), "Fitur {$kunciFitur} harus tersimpan nonaktif.");
        }

        // Aktifkan kembali cerita_cinta & buku_tamu via PUT JSON
        $this->actingAs($client)
            ->putJson("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'fitur',
                'kunci' => 'cerita_cinta',
                'aktif' => true,
            ])
            ->assertOk()
            ->assertJson(['ok' => true, 'kunci' => 'cerita_cinta', 'aktif' => true]);

        $this->assertTrue($undangan->fresh()->fiturAktif('cerita_cinta'));

        // 3. Simpan Semua (bagian=semua) dengan Accept: application/json menyimpan seluruh seksi sekaligus tanpa redirect
        $respon = $this->actingAs($client)
            ->withHeaders(['Accept' => 'application/json'])
            ->post("/dashboard/undangan/{$undangan->id}", [
                '_method' => 'PUT',
                'bagian' => 'semua',
                'tema_id' => $temaJawa->id,
                'slug' => 'uji-simpan-semua-baru',
                'gaya_font' => 'editorial_gilda',
                'tanpa_foto' => '0',
                'sumber_musik' => 'katalog',
                'musik_latar' => 'musik/gamelan-lembut.mp3',
                'fitur_hitung_mundur' => '1',
                'fitur_cerita_cinta' => '1',
                'fitur_galeri' => '0',
                'fitur_amplop_digital' => '1',
                'fitur_buku_tamu' => '1',
                'fitur_doa_pengantin' => '0',
                'nama_panggilan_pria' => 'Dodi',
                'nama_lengkap_pria' => 'Dodi Pratama, S.T.',
                'nama_panggilan_wanita' => 'Windy',
                'nama_lengkap_wanita' => 'Windy Sari, S.E.',
                'kutipan_ayat' => 'Kutipan pembuka baru.',
                'foto_sampul' => UploadedFile::fake()->image('sampul-baru.jpg', 900, 1600),
                'dress_code_disertakan' => '1',
                'dress_code_catatan' => 'Batik Klasik',
                'dress_code_warna' => ['#472A1C', '#D7BB83'],
                'live_aktif' => '1',
                'live_platform' => 'YouTube Live',
                'live_link' => 'https://youtube.com/live/uji',
                'cerita_cinta' => [
                    ['judul' => 'Awal Jumpa', 'tanggal' => '2023', 'cerita' => 'Di Yogyakarta.'],
                ],
                'alamat_kado_fisik' => 'Jl. Malioboro No. 1',
                'turut_mengundang_pria' => 'Keluarga Besar Pratama',
                'hashtag' => 'DodiWindy2026',
                'doa_disertakan' => '1',
                'teks' => [
                    'sampul_judul' => 'Pernikahan Bahagia',
                    'judul_galeri' => 'Album Kami',
                ],
            ]);

        $respon->assertOk()
            ->assertJson([
                'ok' => true,
                'slug' => 'uji-simpan-semua-baru',
                'fitur_aktif' => [
                    'hitung_mundur' => true,
                    'cerita_cinta' => true,
                    'galeri' => false,
                    'amplop_digital' => true,
                    'buku_tamu' => true,
                    'doa_pengantin' => false,
                ],
            ]);

        $undangan->refresh();
        $this->assertSame('uji-simpan-semua-baru', $undangan->slug);
        $this->assertSame('editorial_gilda', $undangan->kodeGayaFontTerpilih());
        $this->assertSame('Dodi Pratama, S.T.', $undangan->nama_lengkap_pria);
        $this->assertSame('Batik Klasik', $undangan->dressCodeCatatan());
        $this->assertSame('Jl. Malioboro No. 1', data_get($undangan->pengaturan, 'alamat_kado_fisik'));
        $this->assertSame('#DodiWindy2026', $undangan->hashtagPasangan());
        $this->assertSame('Pernikahan Bahagia', $undangan->teksKustom('sampul_judul'));
        $this->assertSame('Album Kami', $undangan->teksKustom('judul_galeri'));
        $this->assertFalse($undangan->fiturAktif('galeri'));
        $this->assertFalse($undangan->fiturAktif('doa_pengantin'));
        $this->assertTrue($undangan->fiturAktif('hitung_mundur'));
        $this->assertNotEmpty($undangan->urlFotoSampulKhususDashboard());

        // Uji sinkronisasi multi-foto Galeri lewat Simpan Semua (tanpa refresh) + urutan + potong ulang + hapus + live preview
        $responGaleri1 = $this->actingAs($client)
            ->withHeaders(['Accept' => 'application/json'])
            ->post("/dashboard/undangan/{$undangan->id}", [
                '_method' => 'PUT',
                'bagian' => 'semua',
                'nama_panggilan_pria' => 'Dodi',
                'nama_lengkap_pria' => 'Dodi Pratama, S.T.',
                'nama_panggilan_wanita' => 'Windy',
                'nama_lengkap_wanita' => 'Windy Sari, S.E.',
                'fitur_galeri' => '1',
                'galeri_disertakan' => '1',
                'galeri_items' => [
                    [
                        'keterangan' => 'Momen Lamaran',
                        'file' => UploadedFile::fake()->image('galeri-a.jpg', 900, 1200),
                    ],
                    [
                        'keterangan' => 'Prewedding Senja',
                        'file' => UploadedFile::fake()->image('galeri-b.jpg', 900, 1200),
                    ],
                ],
            ]);

        $responGaleri1->assertOk()->assertJsonCount(2, 'galeri');
        $galeriJson1 = $responGaleri1->json('galeri');
        $idGaleri1 = $galeriJson1[0]['id'];
        $idGaleri2 = $galeriJson1[1]['id'];
        $pathGaleri1 = $galeriJson1[0]['path'];
        $pathGaleri2 = $galeriJson1[1]['path'];

        Storage::disk('public')->assertExists($pathGaleri1);
        Storage::disk('public')->assertExists($pathGaleri2);
        $this->assertSame('Momen Lamaran', $galeriJson1[0]['keterangan']);
        $this->assertSame('Prewedding Senja', $galeriJson1[1]['keterangan']);

        // Live preview menampilkan galeri blob & urutan live secara langsung
        $this->actingAs($client)
            ->postJson("/dashboard/undangan/{$undangan->id}/pratinjau-langsung", [
                'galeri_disertakan' => true,
                'galeri_live' => [
                    ['id' => $idGaleri2, 'path' => $pathGaleri2, 'url' => $galeriJson1[1]['url'], 'keterangan' => 'Senja Indah'],
                    ['id' => null, 'path' => '', 'url' => 'blob:http://127.0.0.1:8000/galeri-live-baru', 'keterangan' => 'Pratinjau Baru'],
                ],
            ])
            ->assertOk()
            ->assertSee('blob:http://127.0.0.1:8000/galeri-live-baru', false);

        // Simpan Semua berikutnya: hapus foto pertama, simpan foto kedua dengan keterangan baru & hasil potong ulang
        $responGaleri2 = $this->actingAs($client)
            ->withHeaders(['Accept' => 'application/json'])
            ->post("/dashboard/undangan/{$undangan->id}", [
                '_method' => 'PUT',
                'bagian' => 'semua',
                'nama_panggilan_pria' => 'Dodi',
                'nama_lengkap_pria' => 'Dodi Pratama, S.T.',
                'nama_panggilan_wanita' => 'Windy',
                'nama_lengkap_wanita' => 'Windy Sari, S.E.',
                'galeri_disertakan' => '1',
                'galeri_items' => [
                    [
                        'id' => $idGaleri2,
                        'keterangan' => 'Prewedding Senja (Potong Ulang)',
                        'file' => UploadedFile::fake()->image('galeri-b-recrop.jpg', 900, 1200),
                    ],
                ],
            ]);

        $responGaleri2->assertOk()->assertJsonCount(1, 'galeri');
        $galeriJson2 = $responGaleri2->json('galeri');
        $pathGaleri2Baru = $galeriJson2[0]['path'];

        $this->assertSame($idGaleri2, $galeriJson2[0]['id']);
        $this->assertSame('Prewedding Senja (Potong Ulang)', $galeriJson2[0]['keterangan']);
        $this->assertNotSame($pathGaleri2, $pathGaleri2Baru);
        Storage::disk('public')->assertMissing($pathGaleri1);
        Storage::disk('public')->assertMissing($pathGaleri2);
        Storage::disk('public')->assertExists($pathGaleri2Baru);
    }
}
