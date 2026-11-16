<?php

namespace Tests\Feature;

use App\Models\Pengguna;
use App\Models\Tema;
use App\Models\Undangan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoBrandingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Memastikan file logo utama dan turunannya tersedia di folder public.
     */
    public function test_aset_logo_dan_favicon_tersedia_di_public(): void
    {
        $this->assertFileExists(public_path('logo-sesi-temu.jfif'));
        $this->assertFileExists(public_path('favicon.png'));
        $this->assertFileExists(public_path('aset-demo/logo-sesi-temu-ikon.webp'));
        $this->assertFileExists(public_path('aset-demo/logo-sesi-temu-lengkap.webp'));
    }

    /**
     * Memastikan logo dan favicon tampil di halaman publik utama, autentikasi, dasbor, admin, dan demo tema.
     */
    public function test_logo_baru_terpasang_pada_seluruh_halaman_utama(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $client = Pengguna::factory()->create();

        $tema = Tema::create([
            'nama_tema' => 'Rustic Floral',
            'slug' => 'rustic-floral',
            'kategori' => 'modern',
            'lokasi_view' => 'tema.rustic-floral.index',
            'aktif' => true,
        ]);

        $undangan = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $tema->id,
            'slug' => 'uji-logo-sesitemu',
            'nama_panggilan_pria' => 'Dimas',
            'nama_lengkap_pria' => 'Dimas Pratama',
            'nama_panggilan_wanita' => 'Rani',
            'nama_lengkap_wanita' => 'Rani Kusuma',
            'status_publikasi' => false,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('favicon.png', false)
            ->assertSee('logo-sesi-temu-ikon.webp', false)
            ->assertSee('logo-sesi-temu-lengkap.webp', false)
            ->assertSee('Logo SesiTemu', false);

        $this->get('/masuk')
            ->assertOk()
            ->assertSee('favicon.png', false)
            ->assertSee('logo-sesi-temu-lengkap.webp', false)
            ->assertSee('Logo SesiTemu', false);

        $this->get('/daftar')
            ->assertOk()
            ->assertSee('favicon.png', false)
            ->assertSee('logo-sesi-temu-lengkap.webp', false)
            ->assertSee('Logo SesiTemu', false);

        $this->actingAs($client)
            ->get('/dasbor')
            ->assertOk()
            ->assertSee('favicon.png', false)
            ->assertSee('logo-sesi-temu-ikon.webp', false);

        $this->actingAs($client)
            ->get(route('dasbor.undangan.kelola', $undangan))
            ->assertOk()
            ->assertSee('favicon.png', false)
            ->assertSee('logo-sesi-temu-ikon.webp', false);

        $this->actingAs($admin)
            ->get('/admin')
            ->assertOk()
            ->assertSee('favicon.png', false)
            ->assertSee('logo-sesi-temu-ikon.webp', false);

        $this->get('/demo/rustic-floral')
            ->assertOk()
            ->assertSee('favicon.png', false)
            ->assertSee('logo-sesi-temu-ikon.webp', false);
    }

    /**
     * Memastikan tata letak panel admin menggunakan sidebar penuh tanpa navbar atas.
     */
    public function test_tampilan_admin_menggunakan_sidebar_tanpa_navbar_atas(): void
    {
        $admin = Pengguna::factory()->admin()->create();

        foreach (['/admin', '/admin/undangan', '/admin/tema', '/admin/pengguna'] as $ruteAdmin) {
            $this->actingAs($admin)
                ->get($ruteAdmin)
                ->assertOk()
                ->assertSee('aria-label="Navigasi Panel Admin"', false)
                ->assertSee('Menu Utama')
                ->assertSee('Dasbor Client')
                ->assertDontSee('<header', false);
        }
    }
}
