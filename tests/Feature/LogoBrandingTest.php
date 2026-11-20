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
        $this->assertFileExists(public_path('favicon.png'));
        $this->assertFileExists(public_path('logo/logo-vertikal.webp'));
        $this->assertFileExists(public_path('logo/logo-horizontal.webp'));
        $this->assertFileExists(public_path('logo/logo-editorial.webp'));
        $this->assertFileExists(public_path('logo/logo-gelap.webp'));
        $this->assertFileExists(public_path('logo/logo-ikon.webp'));
        $this->assertFileExists(public_path('logo/logo-ikon-gelap.webp'));
        $this->assertFileExists(public_path('aset-demo/logo-sesi-temu-ikon.webp'));
        $this->assertFileExists(public_path('aset-demo/logo-sesi-temu-lengkap.webp'));
    }

    /**
     * Memastikan logo dan favicon tampil di halaman publik utama, autentikasi, dashboard, admin, dan demo tema.
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
            ->assertSee('logo/logo-horizontal.webp', false)
            ->assertSee('logo/logo-editorial.webp', false)
            ->assertSee('Logo SesiTemu', false);

        $this->get('/masuk')
            ->assertOk()
            ->assertSee('favicon.png', false)
            ->assertSee('logo/logo-vertikal.webp', false)
            ->assertSee('Logo SesiTemu', false);

        $this->get('/daftar')
            ->assertOk()
            ->assertSee('favicon.png', false)
            ->assertSee('logo/logo-vertikal.webp', false)
            ->assertSee('Logo SesiTemu', false);

        $this->actingAs($client)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('favicon.png', false)
            ->assertSee('logo/logo-horizontal.webp', false)
            ->assertSee('font-sans text-[1.35rem] sm:text-[1.85rem] font-bold text-white leading-snug tracking-tight', false)
            ->assertSee('Kelola Undangan Pernikahan Anda')
            ->assertSee('Kelengkapan Undangan')
            ->assertSee('Salin Link')
            ->assertSee('font-sans tabular-nums text-lg sm:text-2xl font-bold text-charcoal', false);

        $this->actingAs($client)
            ->get('/dashboard/undangan')
            ->assertRedirect('/dashboard');

        $this->actingAs($client)
            ->get(route('dashboard.undangan.tamu', $undangan))
            ->assertOk()
            ->assertSee('favicon.png', false)
            ->assertSee('logo/logo-ikon.webp', false)
            ->assertSee('data-workspace-sidebar', false)
            ->assertSee('font-sans text-xl sm:text-2xl font-bold text-charcoal tracking-tight', false)
            ->assertSee('Tamu &amp; RSVP', false)
            ->assertSee('font-sans tabular-nums text-2xl font-bold text-sage', false);

        $this->actingAs($client)
            ->get('/dashboard/katalog')
            ->assertOk()
            ->assertSee('font-sans text-lg sm:text-2xl font-bold text-charcoal tracking-tight', false)
            ->assertSee('Katalog Tema Undangan')
            ->assertSee('font-sans tabular-nums text-base sm:text-lg font-bold tracking-tight', false);

        $this->actingAs($client)
            ->get('/dashboard/profil')
            ->assertOk()
            ->assertSee('font-sans text-base sm:text-lg font-bold text-charcoal tracking-tight', false)
            ->assertSee('Data Profil Saya')
            ->assertSee('font-sans tabular-nums text-lg sm:text-xl font-bold text-charcoal leading-none', false);

        $this->actingAs($client)
            ->get(route('dashboard.undangan.kelola', $undangan))
            ->assertOk()
            ->assertSee('favicon.png', false)
            ->assertSee('logo/logo-ikon.webp', false)
            ->assertSee('data-workspace-sidebar', false)
            ->assertSee('Edit Undangan')
            ->assertSee('iframePreview', false)
            ->assertSee('font-sans text-lg sm:text-2xl font-bold text-charcoal tracking-tight">Tema, Musik &amp; Pengaturan Link</h2>', false);

        $this->actingAs($admin)
            ->get('/admin')
            ->assertOk()
            ->assertSee('favicon.png', false)
            ->assertSee('logo/logo-ikon-gelap.webp', false)
            ->assertSee('Playfair Display', false);

        $this->get('/demo/rustic-floral')
            ->assertOk()
            ->assertSee('favicon.png', false)
            ->assertSee('logo/logo-horizontal.webp', false)
            ->assertSee('logo/logo-ikon.webp', false);
    }

    /**
     * Memastikan tata letak panel admin menggunakan sidebar navigasi serta header informasi panel.
     */
    public function test_tampilan_admin_menggunakan_sidebar_dan_header_panel(): void
    {
        $admin = Pengguna::factory()->admin()->create();

        $semuaRuteAdmin = [
            '/admin',
            '/admin/undangan',
            '/admin/transaksi',
            '/admin/buku-tamu',
            '/admin/tema',
            '/admin/musik',
            '/admin/promo',
            '/admin/laporan',
            '/admin/pengguna',
            '/admin/pengaturan',
        ];

        foreach ($semuaRuteAdmin as $ruteAdmin) {
            $respon = $this->actingAs($admin)->get($ruteAdmin);
            $respon->assertOk()
                ->assertSee('aria-label="Navigasi Panel Admin"', false)
                ->assertSee('aria-label="Header Panel Admin"', false)
                ->assertSee('MAIN')
                ->assertSee('Administrator')
                ->assertDontSee('flex-1 max-w-7xl', false);

            $konten = $respon->getContent();
            if (preg_match('/<header\b[^>]*>.*?<\/header>/s', $konten, $cocokHeader)) {
                $this->assertStringNotContainsString('<nav', $cocokHeader[0]);
                $this->assertStringContainsString('menuProfilTerbuka', $cocokHeader[0]);
                $this->assertStringContainsString($admin->nama, $cocokHeader[0]);
                $this->assertStringContainsString('Administrator', $cocokHeader[0]);
                $this->assertStringContainsString('Keluar', $cocokHeader[0]);
                $this->assertStringNotContainsString('Lihat Beranda', $cocokHeader[0]);
                $this->assertMatchesRegularExpression('/<button[^>]*aria-label="Menu profil admin"[^>]*>.*?' . preg_quote($admin->nama, '/') . '.*?<\/button>/s', $cocokHeader[0]);
                $this->assertMatchesRegularExpression('/<button[^>]*aria-label="Menu profil admin"[^>]*>.*?' . preg_quote($admin->nama, '/') . '.*?<\/button>/s', $cocokHeader[0]);
                $this->assertStringNotContainsString('M19 9l-7 7-7-7', $cocokHeader[0]);
            } else {
                $this->fail('Header panel admin tidak ditemukan pada ' . $ruteAdmin);
            }

            if (preg_match('/<aside\b[^>]*aria-label="Navigasi Panel Admin".*?<\/aside>/s', $konten, $cocokSidebar)) {
                $this->assertStringContainsString('logo/logo-ikon-gelap.webp', $cocokSidebar[0]);
                $this->assertStringContainsString('Sesi<span class="text-champagne">Temu</span>', $cocokSidebar[0]);
                $this->assertStringContainsString('Playfair Display', $cocokSidebar[0]);
                $this->assertStringContainsString($admin->nama, $cocokSidebar[0]);
                $this->assertStringContainsString('Administrator', $cocokSidebar[0]);
                $this->assertStringContainsString('MAIN', $cocokSidebar[0]);
                $this->assertStringContainsString('Dashboard', $cocokSidebar[0]);
                $this->assertStringContainsString('admin-sidebar-scroll', $cocokSidebar[0]);
                $this->assertSame(1, substr_count($cocokSidebar[0], '<span>Dashboard</span>'));
                $this->assertSame(1, substr_count($cocokSidebar[0], '<span>Pengguna</span>'));
                $this->assertSame(1, substr_count($cocokSidebar[0], '<span>Undangan</span>'));
                $this->assertSame(1, substr_count($cocokSidebar[0], 'Katalog Tema'));
                $this->assertStringNotContainsString('>Ringkasan<', $cocokSidebar[0]);
                $this->assertStringNotContainsString('Pintasan', $cocokSidebar[0]);
                $this->assertStringNotContainsString('Lihat Beranda', $cocokSidebar[0]);
                $this->assertStringNotContainsString('Dashboard Client', $cocokSidebar[0]);
                $this->assertStringNotContainsString('menuProfilTerbuka', $cocokSidebar[0]);
                $this->assertStringContainsString('h-16 shrink-0 px-5 border-b border-champagne/25 flex items-center justify-center', $cocokSidebar[0]);
                $this->assertStringContainsString('Keluar', $cocokSidebar[0]);
                $this->assertStringContainsString('border-ivory/25', $cocokSidebar[0]);
                $this->assertStringNotContainsString($admin->email, $cocokSidebar[0]);
                $this->assertStringNotContainsString('rounded-md bg-champagne/15', $cocokSidebar[0]);
            } else {
                $this->fail('Sidebar panel admin tidak ditemukan pada ' . $ruteAdmin);
            }
        }

        $this->actingAs($admin)
            ->get('/admin')
            ->assertOk()
            ->assertSee('Dashboard Admin — SesiTemu')
            ->assertSee('Total Client')
            ->assertSee('Draft Aktivasi')
            ->assertSee('Ucapan &amp; RSVP', false)
            ->assertSee('Pintasan Cepat');
    }

    /**
     * Memastikan seluruh tabel utama pada panel admin siap diinisialisasi oleh DataTables.
     */
    public function test_tabel_panel_admin_menggunakan_datatables(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $client = Pengguna::factory()->create(['peran' => 'client']);
        $tema = Tema::create([
            'nama_tema' => 'Rustic Floral',
            'slug' => 'rustic-floral-uji',
            'kategori' => 'modern',
            'lokasi_view' => 'tema.rustic-floral.index',
            'aktif' => true,
        ]);
        $undangan = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $tema->id,
            'slug' => 'uji-preview-undangan',
            'nama_panggilan_pria' => 'Dimas',
            'nama_lengkap_pria' => 'Dimas Aditya',
            'nama_panggilan_wanita' => 'Rani',
            'nama_lengkap_wanita' => 'Rani Kusuma',
            'status_publikasi' => true,
        ]);

        foreach (
            [
                '/admin' => 'data-page-length="5"',
                '/admin/undangan' => 'data-page-length="10"',
                '/admin/pengguna' => 'data-page-length="10"',
            ] as $rute => $pageLengthAttr
        ) {
            $respon = $this->actingAs($admin)
                ->get($rute)
                ->assertOk()
                ->assertSee('data-datatable', false)
                ->assertSee($pageLengthAttr, false)
                ->assertSee('data-empty-message', false)
                ->assertDontSee('colspan="5"', false);

            $konten = $respon->getContent();
            $this->assertMatchesRegularExpression(
                '/<thead>\s*<tr[^>]*>\s*<th[^>]*data-no-sort[^>]*dt-center text-center[^>]*>Aksi<\/th>/s',
                $konten
            );
        }

        foreach (['/admin', '/admin/undangan'] as $ruteUndangan) {
            $this->actingAs($admin)
                ->get($ruteUndangan)
                ->assertOk()
                ->assertSee('title="Preview Undangan"', false)
                ->assertSee('<span>Preview</span>', false)
                ->assertSee('<span>Edit Isian</span>', false)
                ->assertSee($undangan->slug);
        }

        $this->actingAs($admin)
            ->get('/admin/pengguna')
            ->assertOk()
            ->assertSee($admin->email)
            ->assertSee($client->email)
            ->assertSee('Tambah Pengguna')
            ->assertSee('data-buka-modal-tambah', false)
            ->assertSee('data-buka-modal-edit', false)
            ->assertSee('max-w-2xl lg:max-w-3xl', false)
            ->assertSee('id="judul-modal-pengguna"', false)
            ->assertSee('title="Lihat Detail Pengguna"', false)
            ->assertSee('title="Edit Data &amp; Reset Kata Sandi"', false)
            ->assertDontSee('<span>Detail</span>', false)
            ->assertDontSee('<span>Edit</span>', false)
            ->assertSee('data-swal-confirm', false)
            ->assertSee('data-swal-loading-title', false)
            ->assertSee('<svg', false);

        $this->actingAs($admin)
            ->get('/admin/undangan')
            ->assertOk()
            ->assertSee('data-swal-confirm', false)
            ->assertSee('data-swal-loading-title', false)
            ->assertSee('Nonaktifkan Undangan?');

        $this->actingAs($admin)
            ->from('/admin/undangan')
            ->followingRedirects()
            ->patch("/admin/undangan/{$undangan->id}/nonaktifkan")
            ->assertOk()
            ->assertSee('data-swal-success', false)
            ->assertSee('Aktifkan Undangan?');
    }
}
