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
            ->assertSee('Website Undangan Digital')
            ->assertSee('Buat Undangan Digital,')
            ->assertSee('Jadi Dulu, Baru Bayar')
            ->assertSee('Siap dalam 5 Menit')
            ->assertSee('data-hero-typewriter', false)
            ->assertSee('data-hero-mockup-iphone="2"', false)
            ->assertSee('aset-tema/adat-jawa/hero-poster.webp', false)
            ->assertSee('sunda-heritage', false)
            ->assertSee('Bagja', false)
            ->assertSee('aset-tema/islami-syari/hero-poster.webp', false)
            ->assertSee('data-hero-preview-menu', false)
            ->assertSee('Buka Contoh Undangan')
            ->assertSee('data-landing-bottom-nav', false)
            ->assertSee('md:hidden fixed bottom-0', false)
            ->assertSee('Lihat Katalog Tema')
            ->assertSeeText('Mengapa Memilih SesiTemu?')
            ->assertSee('text-[#223F2E]', false)
            ->assertSee('text-[#C29940]', false)
            ->assertSee('Rustic Floral')
            ->assertSee('Adat Jawa Keraton')
            ->assertSee('Islami Syari')
            ->assertSee('Lihat Sampul')
            ->assertSee('Pratinjau sampul tema')
            ->assertSee('aset-tema/rustic-floral/latar-utama.webp', false)
            ->assertSee('Save The Date')
            ->assertSee('The Wedding Of')
            ->assertDontSee('Tema Nonaktif')
            ->assertSee('font-logo text-3xl sm:text-4xl font-bold text-charcoal tracking-tight">Pilih Paket Sesuai Kebutuhan', false)
            ->assertSee('font-logo text-2xl sm:text-3xl font-bold text-charcoal tracking-tight">Paket Mandiri</h3>', false)
            ->assertSee('font-logo text-2xl sm:text-3xl font-bold text-white tracking-tight">Paket Terima Beres</h3>', false)
            ->assertSee('font-logo text-2xl sm:text-4xl font-bold text-charcoal tracking-tight">Pertanyaan Seputar Undangan Digital</h2>', false)
            ->assertSee('font-logo text-2xl font-bold text-charcoal tracking-tight">Pratinjau Tema</h3>', false)
            ->assertSee('font-sans tabular-nums text-3xl sm:text-4xl font-bold tracking-tight text-charcoal', false)
            ->assertSee('Semua Fitur Unggulan Sudah Termasuk')
            ->assertSee('Lihat 12 Fitur Lainnya')
            ->assertDontSee('Inspirasi Tema')
            ->assertSee('Siapkan Undangan Anda');

        $this->get('/?tab=paket&sub=faq')
            ->assertOk()
            ->assertSee("tabMobile: 'paket'", false)
            ->assertSee("subTabPaket: 'faq'", false);
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
            ->followingRedirects()
            ->post('/cek-link', ['slug' => 'Dimas Rani']);

        $response->assertOk()
            ->assertSee('data-swal-warning', false)
            ->assertSee('dimas-rani');
    }

    public function test_demo_tema_berjalan_in_memory_tanpa_menyimpan_ke_database(): void
    {
        $this->buatTemaBawaan();

        // Halaman utama live demo menampilkan pratinjau perangkat (Handphone / Tablet / Desktop)
        $this->get('/demo/rustic-floral?to=Andi+Wijaya')
            ->assertOk()
            ->assertSee('Pratinjau Tema')
            ->assertSee('Rustic Floral')
            ->assertSee('Handphone')
            ->assertSee('Tablet')
            ->assertSee('Desktop')
            ->assertSee('data-kanvas-demo', false)
            ->assertSee('kanvas=1', false)
            ->assertDontSee('Pilih Desain Font Demo');

        // Kanvas undangan di dalam pratinjau tetap merender konten demo lengkap tanpa bar lama
        $this->get('/demo/rustic-floral?kanvas=1&to=Andi+Wijaya')
            ->assertOk()
            ->assertSee('Dimas')
            ->assertSee('Rani')
            ->assertSee('Andi Wijaya')
            ->assertDontSee('<div data-bar-pratinjau', false)
            ->assertDontSee('Pilih Desain Font Demo');

        $this->get('/demo/adat-jawa?kanvas=1')
            ->assertOk()
            ->assertSee('Budi Santoso & Partner')
            ->assertDontSee('Lewati Intro')
            ->assertDontSee('<div data-bar-pratinjau', false);
        $this->get('/demo/islami-syari?kanvas=1')->assertOk()->assertSee('Budi Santoso & Partner');
        $this->get('/demo/tema-tidak-ada')->assertNotFound();

        $this->assertDatabaseCount('undangan', 0);
    }

    public function test_demo_tema_mendukung_katalog_lengkap_variasi_font_dan_mode_tanpa_foto(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/demo/editorial-monokrom?kanvas=1&to=Ibu+Maya&font=editorial_gilda')
            ->assertOk()
            ->assertSee('Ibu Maya')
            ->assertSee('Gilda+Display', false)
            ->assertSee('Editorial Monokrom');

        $this->get('/demo/luxury-noir?kanvas=1&tf=1')
            ->assertOk()
            ->assertDontSee('<div data-bar-pratinjau', false)
            ->assertDontSee('mempelai-pria.webp')
            ->assertDontSee('galeri-1.webp');

        $this->get('/demo/velvet-garden?kanvas=1')->assertOk()->assertSee('animasi-melayang');
        $this->get('/demo/sunda-heritage?kanvas=1')->assertOk()->assertSee('Sampurasun');
        $this->get('/demo/islamic-heavenly?kanvas=1')->assertOk()->assertSee('animasi-bintang');
    }

    public function test_footer_beranda_menampilkan_tautan_kebijakan_privasi_dan_syarat_ketentuan(): void
    {
        $this->buatTemaBawaan();

        $respon = $this->get('/')
            ->assertOk()
            ->assertDontSee('Abadikan Setiap Sesi Bahagia Menuju Hari Pertemuan')
            ->assertDontSee('Akses Cepat')
            ->assertSee('Kebijakan Privasi')
            ->assertSee('Syarat &amp; Ketentuan', false)
            ->assertSee(route('halaman.kebijakan-privasi'), false)
            ->assertSee(route('halaman.syarat-ketentuan'), false);

        $this->assertSame(1, preg_match('/<footer\b.*?<\/footer>/s', $respon->getContent(), $cocokFooter));
        $this->assertStringNotContainsString('Jelajahi', $cocokFooter[0]);
        $this->assertStringNotContainsString('Konsultasi Admin', $cocokFooter[0]);
        $this->assertStringNotContainsString('Pratinjau Gratis', $cocokFooter[0]);
        $this->assertStringNotContainsString('Masa Aktif', $cocokFooter[0]);

        $this->get('/kebijakan-privasi')
            ->assertOk()
            ->assertSee('Kebijakan Privasi')
            ->assertSee('Data yang Kami Kumpulkan');

        $this->get('/syarat-ketentuan')
            ->assertOk()
            ->assertSee('Syarat &amp; Ketentuan', false)
            ->assertSee('Masa Aktif');
    }
}
