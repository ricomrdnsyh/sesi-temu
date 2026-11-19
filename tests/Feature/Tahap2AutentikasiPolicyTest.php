<?php

namespace Tests\Feature;

use App\Http\Middleware\PastikanAdmin;
use App\Models\Pengguna;
use App\Models\Tema;
use App\Models\Undangan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class Tahap2AutentikasiPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_masuk_dan_daftar_dapat_diakses_tamu(): void
    {
        $this->get('/masuk')
            ->assertOk()
            ->assertSee('Masuk')
            ->assertSee('Selamat Datang Kembali')
            ->assertSee('Kembali ke Beranda')
            ->assertSee('data-landing-bottom-nav', false);
        $this->get('/daftar')
            ->assertOk()
            ->assertSee('Daftar')
            ->assertSee('Buat Akun Gratis')
            ->assertSee('Kembali ke Beranda')
            ->assertSee('data-landing-bottom-nav', false);
        $this->assertSame(url('/masuk'), route('login'));
    }

    public function test_registrasi_client_baru_berhasil_dan_membuat_draft_otomatis_jika_ada_slug_atau_tema(): void
    {
        $tema = Tema::create([
            'nama_tema' => 'Rustic Floral',
            'slug' => 'rustic-floral',
            'kategori' => 'modern',
            'lokasi_view' => 'tema.rustic-floral.index',
            'aktif' => true,
        ]);

        // Kunjungi halaman daftar dengan parameter slug & tema terlebih dahulu
        $this->get('/daftar?slug=andi-sinta&tema='.$tema->id)
            ->assertOk()
            ->assertSee('Draft Undangan Awal Anda Siap Dibuat')
            ->assertSee('Rustic Floral');

        $response = $this->post('/daftar', [
            'nama' => 'Andi Pratama',
            'email' => 'andi@sesitemu.id',
            'nomor_wa' => '628123450000',
            'kata_sandi' => 'rahasia123',
            'kata_sandi_confirmation' => 'rahasia123',
            'slug' => 'andi-sinta',
            'tema_id' => $tema->id,
        ]);

        $response->assertRedirect('/dashboard');

        $pengguna = Pengguna::where('email', 'andi@sesitemu.id')->first();
        $this->assertNotNull($pengguna);
        $this->assertSame('client', $pengguna->peran);
        $this->assertTrue(Hash::check('rahasia123', $pengguna->kata_sandi));
        $this->assertAuthenticatedAs($pengguna);

        $this->assertDatabaseHas('undangan', [
            'pengguna_id' => $pengguna->id,
            'tema_id' => $tema->id,
            'slug' => 'andi-sinta',
            'status_publikasi' => false,
        ]);
    }

    public function test_masuk_menggunakan_email_dan_kata_sandi_sesuai_peran(): void
    {
        $admin = Pengguna::factory()->admin()->create([
            'email' => 'admin@sesitemu.id',
            'kata_sandi' => Hash::make('sandi-admin'),
        ]);

        $client = Pengguna::factory()->create([
            'email' => 'client@sesitemu.id',
            'kata_sandi' => Hash::make('sandi-client'),
        ]);

        // Kata sandi salah ditolak
        $this->from('/masuk')
            ->post('/masuk', [
                'email' => 'client@sesitemu.id',
                'kata_sandi' => 'salah',
            ])
            ->assertRedirect('/masuk')
            ->assertSessionHasErrors('email');
        $this->assertGuest();

        // Client masuk -> /dashboard
        $this->post('/masuk', [
            'email' => 'client@sesitemu.id',
            'kata_sandi' => 'sandi-client',
        ])->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($client);

        // Keluar -> /
        $this->post('/keluar')->assertRedirect('/');
        $this->assertGuest();

        // Admin masuk -> /admin
        $this->post('/masuk', [
            'email' => 'admin@sesitemu.id',
            'kata_sandi' => 'sandi-admin',
        ])->assertRedirect('/admin');
        $this->assertAuthenticatedAs($admin);
    }

    public function test_middleware_pastikan_admin_membatasi_akses_client_dan_tamu(): void
    {
        Route::middleware(['web', 'auth', PastikanAdmin::class])
            ->get('/_uji-admin', fn () => response('ok'));

        $client = Pengguna::factory()->create(['peran' => 'client']);
        $admin = Pengguna::factory()->admin()->create();

        // Tamu diarahkan ke halaman masuk (/masuk)
        $this->get('/_uji-admin')->assertRedirect('/masuk');

        // Client mendapat 403
        $this->actingAs($client)->get('/_uji-admin')->assertForbidden();

        // Admin diizinkan
        $this->actingAs($admin)->get('/_uji-admin')->assertOk()->assertSee('ok');
    }

    public function test_undangan_policy_mengatur_hak_client_dan_bypass_admin(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $pemilik = Pengguna::factory()->create();
        $orangLain = Pengguna::factory()->create();

        $tema = Tema::create([
            'nama_tema' => 'Rustic Floral',
            'slug' => 'rustic-floral',
            'kategori' => 'modern',
            'lokasi_view' => 'tema.rustic-floral.index',
            'aktif' => true,
        ]);

        $draft = Undangan::create([
            'pengguna_id' => $pemilik->id,
            'tema_id' => $tema->id,
            'slug' => 'draft-pemilik',
            'nama_panggilan_pria' => 'A',
            'nama_lengkap_pria' => 'A Lengkap',
            'nama_panggilan_wanita' => 'B',
            'nama_lengkap_wanita' => 'B Lengkap',
            'status_publikasi' => false,
        ]);

        $aktif = Undangan::create([
            'pengguna_id' => $pemilik->id,
            'tema_id' => $tema->id,
            'slug' => 'aktif-pemilik',
            'nama_panggilan_pria' => 'C',
            'nama_lengkap_pria' => 'C Lengkap',
            'nama_panggilan_wanita' => 'D',
            'nama_lengkap_wanita' => 'D Lengkap',
            'status_publikasi' => true,
        ]);

        // Pemilik bisa kelola miliknya, tidak bisa kelola milik orang lain
        $this->assertTrue(Gate::forUser($pemilik)->allows('kelola', $draft));
        $this->assertTrue(Gate::forUser($pemilik)->allows('kelola', $aktif));
        $this->assertFalse(Gate::forUser($orangLain)->allows('kelola', $draft));

        // Pemilik hanya bisa hapus jika masih draft
        $this->assertTrue(Gate::forUser($pemilik)->allows('hapus', $draft));
        $this->assertFalse(Gate::forUser($pemilik)->allows('hapus', $aktif));

        // Admin bypass seluruh hak akses
        $this->assertTrue(Gate::forUser($admin)->allows('kelola', $draft));
        $this->assertTrue(Gate::forUser($admin)->allows('kelola', $aktif));
        $this->assertTrue(Gate::forUser($admin)->allows('hapus', $aktif));
    }
}
