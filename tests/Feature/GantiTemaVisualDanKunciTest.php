<?php

namespace Tests\Feature;

use App\Models\Pengguna;
use App\Models\Tema;
use App\Models\Transaksi;
use App\Models\Undangan;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GantiTemaVisualDanKunciTest extends TestCase
{
    use RefreshDatabase;

    private function buatUndanganContoh(Pengguna $pemilik, Tema $tema, array $atributTambahan = []): Undangan
    {
        return Undangan::create(array_merge([
            'pengguna_id' => $pemilik->id,
            'tema_id' => $tema->id,
            'slug' => 'pasangan-'.uniqid(),
            'nama_panggilan_pria' => 'Dimas',
            'nama_lengkap_pria' => 'Dimas Pratama',
            'nama_panggilan_wanita' => 'Jihan',
            'nama_lengkap_wanita' => 'Jihan Aulia',
            'musik_latar' => 'musik/romantis.mp3',
            'pengaturan' => [
                'gaya_font' => 'editorial_gilda',
                'tanpa_foto' => true,
                'fitur_aktif' => [
                    'hitung_mundur' => true,
                    'cerita_cinta' => false,
                    'galeri' => true,
                    'amplop_digital' => true,
                    'buku_tamu' => false,
                ],
            ],
            'status_publikasi' => false,
        ], $atributTambahan));
    }

    public function test_client_dapat_ganti_tema_saat_draft_dan_kedaluwarsa_tanpa_mereset_pengaturan(): void
    {
        $this->seed(DatabaseSeeder::class);

        $client = Pengguna::factory()->create(['peran' => 'client']);
        $clientLain = Pengguna::factory()->create(['peran' => 'client']);
        $temaMurah = Tema::where('slug', 'rustic-floral')->firstOrFail();
        $temaMahal = Tema::where('slug', 'luxury-noir')->firstOrFail();
        $temaAdat = Tema::where('slug', 'adat-jawa')->firstOrFail();

        $draft = $this->buatUndanganContoh($client, $temaMurah, [
            'slug' => 'draft-ganti-tema',
            'status_publikasi' => false,
        ]);

        // Halaman kelola menampilkan Studio Modal Tengah dengan filter Tier saja (tanpa filter kategori) & live try-on preview
        $this->actingAs($client)
            ->get("/dashboard/undangan/{$draft->id}/kelola")
            ->assertOk()
            ->assertSee('data-modal-ganti-tema', false)
            ->assertSee('data-filter-tier-studio', false)
            ->assertSee('data-filter-tier="semua"', false)
            ->assertSee('data-filter-tier="basic"', false)
            ->assertSee('data-filter-tier="premium"', false)
            ->assertSee('data-filter-tier="eksklusif"', false)
            ->assertDontSee('kategoriDrawerTema', false)
            ->assertSee('Studio Pilih Tema')
            ->assertSee('Data Anda')
            ->assertSee('Contoh Penuh')
            ->assertSee('data-modal-konfirmasi-ganti-tema', false)
            ->assertSee('data-buka-drawer-tema', false)
            ->assertSee('Ganti Tema?')
            ->assertSee('Ya, Ganti Tema')
            ->assertSee('url_pratinjau', false)
            ->assertSee('pratinjau-tema', false)
            ->assertDontSee('<select id="tema_id"', false);

        // Endpoint Live Try-On merender data mempelai milik client pada tema kandidat tanpa mengubah DB & tanpa bar melayang saat embed=1
        $this->actingAs($client)
            ->get(route('dashboard.undangan.pratinjau-tema', ['undangan' => $draft, 'tema' => $temaMahal, 'embed' => 1]))
            ->assertOk()
            ->assertSee('Dimas')
            ->assertSee('Jihan')
            ->assertSee('animasi-debu-emas')
            ->assertDontSee('MODE PRATINJAU SESITEMU.ID');

        $this->assertSame($temaMurah->id, $draft->fresh()->tema_id);

        // Client lain tidak boleh mengakses live try-on maupun mengganti tema undangan milik client ini
        $this->actingAs($clientLain)
            ->get(route('dashboard.undangan.pratinjau-tema', ['undangan' => $draft, 'tema' => $temaMahal, 'embed' => 1]))
            ->assertForbidden();

        $this->actingAs($clientLain)
            ->patch("/dashboard/undangan/{$draft->id}/tema", [
                'tema_id' => $temaMahal->id,
            ])
            ->assertForbidden();

        // Client ganti tema saat draft -> berhasil & pengaturan font/musik/tanpa_foto/fitur tetap aman
        $this->actingAs($client)
            ->patch("/dashboard/undangan/{$draft->id}/tema", [
                'tema_id' => $temaMahal->id,
                'tab_kembali' => 'tema',
            ])
            ->assertRedirect("/dashboard/undangan/{$draft->id}/kelola")
            ->assertSessionHas('sukses')
            ->assertSessionHas('tab_aktif', 'tema');

        $draft->refresh();
        $this->assertSame($temaMahal->id, $draft->tema_id);
        $this->assertSame('musik/romantis.mp3', $draft->musik_latar);
        $this->assertSame('editorial_gilda', $draft->kodeGayaFontTerpilih());
        $this->assertTrue($draft->modeTanpaFoto());
        $this->assertFalse($draft->fiturAktif('cerita_cinta'));
        $this->assertFalse($draft->fiturAktif('buku_tamu'));

        // Undangan kedaluwarsa (perlu perpanjangan) juga diperbolehkan ganti tema sebelum bayar ulang
        $kedaluwarsa = $this->buatUndanganContoh($client, $temaMurah, [
            'slug' => 'expired-ganti-tema',
            'status_publikasi' => true,
            'berlaku_sampai' => now()->subDay(),
        ]);

        $this->actingAs($client)
            ->patch("/dashboard/undangan/{$kedaluwarsa->id}/tema", [
                'tema_id' => $temaAdat->id,
            ])
            ->assertRedirect("/dashboard/undangan/{$kedaluwarsa->id}/kelola")
            ->assertSessionHas('sukses');

        $this->assertSame($temaAdat->id, $kedaluwarsa->fresh()->tema_id);
    }

    public function test_client_tidak_bisa_ganti_tema_saat_undangan_aktif_namun_tetap_bisa_simpan_pengaturan_lain(): void
    {
        $this->seed(DatabaseSeeder::class);

        $client = Pengguna::factory()->create(['peran' => 'client']);
        $temaBasic = Tema::where('slug', 'rustic-floral')->firstOrFail();
        $temaMahal = Tema::where('slug', 'islamic-heavenly')->firstOrFail();

        $aktif = $this->buatUndanganContoh($client, $temaBasic, [
            'slug' => 'undangan-aktif-terkunci',
            'status_publikasi' => true,
            'berlaku_sampai' => now()->addMonths(6),
        ]);

        // Halaman kelola menyembunyikan drawer & tombol Ganti Tema, menampilkan status Terkunci + Hubungi Admin
        $this->actingAs($client)
            ->get("/dashboard/undangan/{$aktif->id}/kelola")
            ->assertOk()
            ->assertSee('data-tema-terkunci-badge', false)
            ->assertSee('Terkunci (Aktif)')
            ->assertSee('Hubungi Admin')
            ->assertDontSee('data-drawer-ganti-tema', false)
            ->assertDontSee('data-buka-drawer-tema', false);

        // Jalur 1: PATCH /dashboard/undangan/{id}/tema -> ditolak
        $this->actingAs($client)
            ->patch("/dashboard/undangan/{$aktif->id}/tema", [
                'tema_id' => $temaMahal->id,
            ])
            ->assertRedirect("/dashboard/undangan/{$aktif->id}/kelola")
            ->assertSessionHasErrors('tema_id');

        $this->assertSame($temaBasic->id, $aktif->fresh()->tema_id);

        // Jalur 2: PUT /dashboard/undangan/{id} dengan tema_id berbeda -> ditolak
        $this->actingAs($client)
            ->from("/dashboard/undangan/{$aktif->id}/kelola")
            ->put("/dashboard/undangan/{$aktif->id}", [
                'bagian' => 'tema',
                'tema_id' => $temaMahal->id,
                'gaya_font' => 'royal_playfair',
            ])
            ->assertSessionHasErrors('tema_id');

        $this->assertSame($temaBasic->id, $aktif->fresh()->tema_id);

        // Jalur 3: POST /dashboard/katalog/terapkan-tema -> ditolak
        $this->actingAs($client)
            ->from('/dashboard/katalog')
            ->post('/dashboard/katalog/terapkan-tema', [
                'undangan_id' => $aktif->id,
                'tema_id' => $temaMahal->id,
            ])
            ->assertSessionHasErrors('undangan_id');

        $this->assertSame($temaBasic->id, $aktif->fresh()->tema_id);

        // Halaman katalog menandai undangan aktif sebagai Terkunci — Aktif
        $this->actingAs($client)
            ->get('/dashboard/katalog')
            ->assertOk()
            ->assertSee('Terkunci — Aktif');

        // Client TETAP bisa memperbarui font, musik, mode tanpa foto, dan fitur aktif tanpa mengubah tema
        $this->actingAs($client)
            ->put("/dashboard/undangan/{$aktif->id}", [
                'bagian' => 'tema',
                'tema_id' => $temaBasic->id,
                'gaya_font' => 'royal_playfair',
                'musik_latar' => 'musik/baru.mp3',
                'fitur_hitung_mundur' => '1',
                'fitur_cerita_cinta' => '1',
                'fitur_galeri' => '1',
                'fitur_amplop_digital' => '1',
                'fitur_buku_tamu' => '1',
            ])
            ->assertRedirect("/dashboard/undangan/{$aktif->id}/kelola")
            ->assertSessionHasNoErrors()
            ->assertSessionHas('sukses');

        $aktif->refresh();
        $this->assertSame($temaBasic->id, $aktif->tema_id);
        $this->assertSame('royal_playfair', $aktif->kodeGayaFontTerpilih());
        $this->assertSame('musik/baru.mp3', $aktif->musik_latar);
        $this->assertFalse($aktif->modeTanpaFoto());
    }

    public function test_tema_juga_terkunci_sementara_saat_menunggu_verifikasi_pembayaran(): void
    {
        $this->seed(DatabaseSeeder::class);

        $client = Pengguna::factory()->create(['peran' => 'client']);
        $temaBasic = Tema::where('slug', 'rustic-floral')->firstOrFail();
        $temaMahal = Tema::where('slug', 'velvet-garden')->firstOrFail();

        $draftVerifikasi = $this->buatUndanganContoh($client, $temaBasic, [
            'slug' => 'sedang-verifikasi-tema',
            'status_publikasi' => false,
        ]);

        Transaksi::create([
            'kode_invoice' => 'INV-LOCK-001',
            'undangan_id' => $draftVerifikasi->id,
            'pengguna_id' => $client->id,
            'tema_id' => $temaBasic->id,
            'paket' => 'mandiri',
            'harga_tema' => $temaBasic->hargaNominal(),
            'biaya_jasa' => 0,
            'potongan_promo' => 0,
            'total_bayar' => $temaBasic->hargaNominal(),
            'status' => 'menunggu_verifikasi',
            'bukti_pembayaran' => 'bukti-pembayaran/dummy.jpg',
        ]);

        $this->actingAs($client)
            ->get("/dashboard/undangan/{$draftVerifikasi->id}/kelola")
            ->assertOk()
            ->assertSee('Terkunci (Verifikasi)')
            ->assertDontSee('data-drawer-ganti-tema', false);

        $this->actingAs($client)
            ->patch("/dashboard/undangan/{$draftVerifikasi->id}/tema", [
                'tema_id' => $temaMahal->id,
            ])
            ->assertSessionHasErrors('tema_id');

        $this->assertSame($temaBasic->id, $draftVerifikasi->fresh()->tema_id);
    }

    public function test_admin_tetap_dapat_mengganti_tema_undangan_aktif_milik_client(): void
    {
        $this->seed(DatabaseSeeder::class);

        $admin = Pengguna::factory()->admin()->create();
        $client = Pengguna::factory()->create(['peran' => 'client']);
        $temaBasic = Tema::where('slug', 'rustic-floral')->firstOrFail();
        $temaEksklusif = Tema::where('slug', 'luxury-noir')->firstOrFail();
        $temaAdat = Tema::where('slug', 'adat-jawa')->firstOrFail();

        $aktif = $this->buatUndanganContoh($client, $temaBasic, [
            'slug' => 'admin-ubah-tema-aktif',
            'status_publikasi' => true,
            'berlaku_sampai' => now()->addMonths(6),
        ]);

        // Admin tetap melihat drawer Ganti Tema dengan label Mode Admin
        $this->actingAs($admin)
            ->get("/dashboard/undangan/{$aktif->id}/kelola")
            ->assertOk()
            ->assertSee('data-drawer-ganti-tema', false)
            ->assertSee('Mode Admin')
            ->assertSee('data-buka-drawer-tema', false);

        // Admin mengganti tema lewat drawer endpoint
        $this->actingAs($admin)
            ->patch("/dashboard/undangan/{$aktif->id}/tema", [
                'tema_id' => $temaEksklusif->id,
            ])
            ->assertRedirect("/dashboard/undangan/{$aktif->id}/kelola")
            ->assertSessionHasNoErrors()
            ->assertSessionHas('sukses');

        $this->assertSame($temaEksklusif->id, $aktif->fresh()->tema_id);

        // Admin juga bisa menerapkan tema lewat katalog
        $this->actingAs($admin)
            ->post('/dashboard/katalog/terapkan-tema', [
                'undangan_id' => $aktif->id,
                'tema_id' => $temaAdat->id,
            ])
            ->assertRedirect("/dashboard/undangan/{$aktif->id}/kelola?tab=tema")
            ->assertSessionHasNoErrors();

        $this->assertSame($temaAdat->id, $aktif->fresh()->tema_id);
    }
}
