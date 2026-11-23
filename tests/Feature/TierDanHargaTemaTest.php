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
            ->assertSee('Semua Tier')
            ->assertSee('Basic')
            ->assertSee('Premium')
            ->assertSee('Eksklusif')
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
            'kategori' => 'luxury',
            'tier' => 'eksklusif',
            'harga' => 175000,
            'lokasi_view' => 'tema.luxury-noir.index',
            'aktif' => true,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Tema Custom Sultan')
            ->assertSee('Eksklusif')
            ->assertSee('Rp 175.000')
            ->assertSee('Total mulai Rp 225.000');

        $tema->update(['tier' => 'premium', 'harga' => 95000]);

        $this->get('/')
            ->assertOk()
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

        $this->get('/daftar?tema='.$tema->id)
            ->assertOk()
            ->assertSee('Luxury Noir Monogram')
            ->assertSee('Eksklusif')
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
        $tmpPath = sys_get_temp_dir().DIRECTORY_SEPARATOR.uniqid('sampul_', true).'.png';
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

        // Tab 5 (kado_fisik) -> Tab 6 (aktivasi)
        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'kado_fisik',
                'alamat_kado_fisik' => 'Jl. Merdeka No. 10, Jakarta',
            ])
            ->assertRedirect("/dashboard/undangan/{$undangan->id}/kelola")
            ->assertSessionHas('tab_aktif', 'aktivasi');

        // Halaman kelola menampilkan dropzone pratinjau foto mempelai, mockup sampul, & template kutipan cepat
        $this->actingAs($client)
            ->get("/dashboard/undangan/{$undangan->id}/kelola?tab=mempelai")
            ->assertOk()
            ->assertSee('Pratinjau Sampul Undangan')
            ->assertSee('Pilih atau Seret Foto Sampul')
            ->assertSee('+ QS. Ar-Rum: 21')
            ->assertSee('Pilih atau Seret Foto Prewedding')
            ->assertSee('<textarea', false)
            ->assertSee('name="keterangan"', false);
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
            ->get('http://127.0.0.1:8000/dashboard/undangan/'.$undangan->id.'/kelola?tab=galeri')
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
            ->assertSee('Menyimpan Pengaturan Tema...')
            ->assertSee('Menyimpan &amp; Mengompresi Foto...', false)
            ->assertSee('Mengunggah &amp; Mengompresi Foto...', false)
            ->assertSee('Menyimpan Cerita Cinta...')
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
}
