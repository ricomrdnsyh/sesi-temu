<?php

namespace Tests\Feature;

use App\Models\Pengguna;
use App\Models\Tema;
use App\Models\Undangan;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Tahap3LandingDemoTest extends TestCase
{
    use RefreshDatabase;

    private function buatTemaBawaan(): void
    {
        Tema::create([
            'nama_tema' => 'Rustic Floral',
            'slug' => 'rustic-floral',
            'kategori' => 'modern',
            'lokasi_view' => 'tema.rustic-floral.index',
            'gambar_pratinjau' => 'aset-demo/tema-rustic-floral.webp',
            'aktif' => true,
        ]);

        Tema::create([
            'nama_tema' => 'Adat Jawa Keraton',
            'slug' => 'adat-jawa',
            'kategori' => 'adat',
            'lokasi_view' => 'tema.adat-jawa.index',
            'gambar_pratinjau' => 'aset-demo/tema-adat-jawa.webp',
            'aktif' => true,
        ]);

        Tema::create([
            'nama_tema' => 'Islami Syari',
            'slug' => 'islami-syari',
            'kategori' => 'islami',
            'lokasi_view' => 'tema.islami-syari.index',
            'gambar_pratinjau' => 'aset-demo/tema-islami-syari.webp',
            'aktif' => true,
        ]);

        Tema::create([
            'nama_tema' => 'Tema Nonaktif',
            'slug' => 'tema-nonaktif',
            'kategori' => 'modern',
            'lokasi_view' => 'tema.rustic-floral.index',
            'aktif' => false,
        ]);
    }

    public function test_halaman_beranda_menampilkan_katalog_tema_aktif_dan_paket_harga(): void
    {
        $this->buatTemaBawaan();

        $this->get('/')
            ->assertOk()
            ->assertSee('SesiTemu')
            ->assertSee('Website Undangan Pernikahan Digital')
            ->assertSee('Bagikan Kabar Pernikahan')
            ->assertSee('Dengan Lebih Berkesan')
            ->assertSee('Buka Contoh Undangan')
            ->assertSee('data-landing-bottom-nav', false)
            ->assertSee('md:hidden fixed bottom-0', false)
            ->assertSee('Lihat Katalog Tema')
            ->assertSee('Mengapa Memilih')
            ->assertSee('SesiTemu?')
            ->assertSee('Rustic Floral')
            ->assertSee('Adat Jawa Keraton')
            ->assertSee('Islami Syari')
            ->assertSee('Lihat Sampul')
            ->assertSee('Pratinjau sampul tema')
            ->assertSee('aset-tema/rustic-floral/latar-utama.webp', false)
            ->assertSee('Save The Date')
            ->assertSee('The Wedding Of')
            ->assertDontSee('Tema Nonaktif')
            ->assertSee('Paket Mandiri')
            ->assertSee('Paket Terima Beres')
            ->assertSee('Pertanyaan Seputar Undangan Digital');
    }

    public function test_cek_link_tersedia_mengarahkan_ke_daftar_dengan_slug_terformat(): void
    {
        $response = $this->post('/cek-link', [
            'slug' => 'Fajar & Nadia!',
        ]);

        $response->assertRedirect(route('daftar', ['slug' => 'fajar-nadia']));
        $response->assertSessionHas('sukses');
    }

    public function test_cek_link_sudah_dipakai_menampilkan_saran_di_beranda(): void
    {
        $this->buatTemaBawaan();
        $client = Pengguna::factory()->create();
        $tema = Tema::where('slug', 'rustic-floral')->firstOrFail();

        Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $tema->id,
            'slug' => 'dimas-rani',
            'nama_panggilan_pria' => 'Dimas',
            'nama_lengkap_pria' => 'Dimas Pratama',
            'nama_panggilan_wanita' => 'Rani',
            'nama_lengkap_wanita' => 'Rani Kusuma',
        ]);

        $response = $this->from('/')
            ->post('/cek-link', ['slug' => 'Dimas Rani']);

        $response->assertRedirect('/');
        $response->assertSessionHas('saran_link');
    }

    public function test_demo_tema_berjalan_in_memory_tanpa_menyimpan_ke_database(): void
    {
        $this->buatTemaBawaan();

        $this->get('/demo/rustic-floral?to=Andi+Wijaya')
            ->assertOk()
            ->assertSee('Dimas')
            ->assertSee('Rani')
            ->assertSee('Andi Wijaya')
            ->assertSee('Pakai Tema Ini');

        $this->get('/demo/adat-jawa')->assertOk()->assertSee('Budi Santoso & Partner');
        $this->get('/demo/islami-syari')->assertOk()->assertSee('Budi Santoso & Partner');
        $this->get('/demo/tema-tidak-ada')->assertNotFound();

        $this->assertDatabaseCount('undangan', 0);
    }

    public function test_demo_tema_mendukung_katalog_lengkap_variasi_font_dan_mode_tanpa_foto(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/demo/editorial-monokrom?to=Ibu+Maya&font=editorial_gilda')
            ->assertOk()
            ->assertSee('Ibu Maya')
            ->assertSee('Gilda+Display', false)
            ->assertSee('Editorial Monokrom');

        $this->get('/demo/luxury-noir?tf=1')
            ->assertOk()
            ->assertSee('Mode: Tanpa Foto (TF)')
            ->assertDontSee('mempelai-pria.webp')
            ->assertDontSee('galeri-1.webp');

        $this->get('/demo/velvet-garden')->assertOk()->assertSee('animasi-melayang');
        $this->get('/demo/sunda-heritage')->assertOk()->assertSee('Sampurasun');
        $this->get('/demo/islamic-heavenly')->assertOk()->assertSee('animasi-bintang');
    }
}
