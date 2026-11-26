<?php

namespace Tests\Feature;

use App\Models\AcaraUndangan;
use App\Models\AmplopDigital;
use App\Models\BukuTamu;
use App\Models\GaleriUndangan;
use App\Models\Pengguna;
use App\Models\Tema;
use App\Models\Transaksi;
use App\Models\Undangan;
use App\Services\PengolahGambarService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class Tahap4DashboardAdminWebpTest extends TestCase
{
    use RefreshDatabase;

    private function buatTema(): Tema
    {
        return Tema::create([
            'nama_tema' => 'Rustic Floral',
            'slug' => 'rustic-floral',
            'kategori' => 'modern',
            'lokasi_view' => 'tema.rustic-floral.index',
            'aktif' => true,
        ]);
    }

    private function buatGambarPngDummy(string $nama = 'foto.png', int $lebar = 1600, int $tinggi = 1200): UploadedFile
    {
        $img = imagecreatetruecolor($lebar, $tinggi);
        $warna = imagecolorallocate($img, 75, 99, 88);
        imagefill($img, 0, 0, $warna);

        $tmpPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid('uji_', true) . '.png';
        imagepng($img, $tmpPath);
        imagedestroy($img);

        return new UploadedFile($tmpPath, $nama, 'image/png', null, true);
    }

    public function test_pengolah_gambar_mengonversi_dan_meresize_foto_ke_webp(): void
    {
        Storage::fake('public');

        $service = app(PengolahGambarService::class);
        $file = $this->buatGambarPngDummy('prewed.png', 1600, 1200);

        $path = $service->simpanGambarUndangan($file, 42, 'galeri');

        $this->assertStringStartsWith('undangan/42/', $path);
        $this->assertStringEndsWith('.webp', $path);
        Storage::disk('public')->assertExists($path);

        $konten = Storage::disk('public')->get($path);
        $info = getimagesizefromstring($konten);
        $this->assertNotFalse($info);
        $this->assertSame('image/webp', $info['mime']);
        $this->assertSame(1200, $info[0]);
        $this->assertSame(900, $info[1]);
    }

    public function test_client_dapat_mengelola_undangan_miliknya_dan_dibatasi_dari_undangan_orang_lain(): void
    {
        Storage::fake('public');

        $tema = $this->buatTema();
        $clientA = Pengguna::factory()->create();
        $clientB = Pengguna::factory()->create();

        // Client A buat draft baru
        $this->actingAs($clientA)
            ->post('/dashboard/undangan', [
                'tema_id' => $tema->id,
                'slug' => 'Raka & Maya',
                'nama_panggilan_pria' => 'Raka',
                'nama_lengkap_pria' => 'Raka Wijaya',
                'nama_panggilan_wanita' => 'Maya',
                'nama_lengkap_wanita' => 'Maya Sari',
            ])
            ->assertRedirect();

        $undangan = Undangan::where('slug', 'raka-maya')->firstOrFail();
        $this->assertSame($clientA->id, $undangan->pengguna_id);

        // Client A buka dashboard, ruang kerja undangan, dan lihat menu Tamu & RSVP terkunci saat draft
        $this->actingAs($clientA)->get('/dashboard')->assertOk()->assertSee('raka-maya');
        $this->actingAs($clientA)
            ->get("/dashboard/undangan/{$undangan->id}/kelola")
            ->assertOk()
            ->assertSee('data-workspace-menu="undangan"', false)
            ->assertSee('data-workspace-menu="tamu"', false)
            ->assertSee('data-workspace-menu="rsvp"', false)
            ->assertSee('data-workspace-locked="true"', false)
            ->assertSee('Edit Undangan');
        $this->actingAs($clientA)
            ->get("/dashboard/undangan/{$undangan->id}/tamu")
            ->assertRedirect("/dashboard/undangan/{$undangan->id}/kelola?tab=aktivasi");
        $this->actingAs($clientA)
            ->get("/dashboard/undangan/{$undangan->id}/rsvp")
            ->assertRedirect("/dashboard/undangan/{$undangan->id}/kelola?tab=aktivasi");

        // Client B tidak boleh kelola undangan Client A
        $this->actingAs($clientB)
            ->get("/dashboard/undangan/{$undangan->id}/kelola")
            ->assertForbidden();

        // Client A perbarui data mempelai + upload foto pria -> WebP
        $fotoPria = $this->buatGambarPngDummy('pria.png', 1400, 1400);
        $this->actingAs($clientA)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'mempelai',
                'nama_panggilan_pria' => 'Raka',
                'nama_lengkap_pria' => 'Raka Wijaya, S.T.',
                'nama_panggilan_wanita' => 'Maya',
                'nama_lengkap_wanita' => 'Maya Sari, S.Pd.',
                'kutipan_ayat' => 'Doa pernikahan terbaik.',
                'foto_pria' => $fotoPria,
            ])
            ->assertRedirect();

        $undangan->refresh();
        $this->assertNotNull($undangan->foto_pria);
        $this->assertStringEndsWith('.webp', $undangan->foto_pria);
        Storage::disk('public')->assertExists($undangan->foto_pria);

        // Tambah & hapus acara
        $this->actingAs($clientA)
            ->post("/dashboard/undangan/{$undangan->id}/acara", [
                'nama_acara' => 'Akad Nikah',
                'tanggal_acara' => '2026-12-12',
                'waktu_mulai' => '08:00',
                'waktu_selesai' => '10:00',
                'zona_waktu' => 'WIB',
                'nama_tempat' => 'Pendopo Agung',
                'alamat_lengkap' => 'Jl. Sudirman No. 1, Jakarta',
            ])
            ->assertRedirect();

        $acara = AcaraUndangan::where('undangan_id', $undangan->id)->firstOrFail();

        // Tambah & hapus amplop digital
        $this->actingAs($clientA)
            ->post("/dashboard/undangan/{$undangan->id}/amplop", [
                'nama_bank' => 'BCA',
                'nomor_rekening' => '5566778899',
                'atas_nama' => 'Raka Wijaya',
            ])
            ->assertRedirect();

        $amplop = AmplopDigital::where('undangan_id', $undangan->id)->firstOrFail();

        // Hapus ucapan buku tamu hanya setelah undangan aktif (terkunci saat draft)
        $ucapan = BukuTamu::create([
            'undangan_id' => $undangan->id,
            'nama_tamu' => 'Spammer',
            'status_kehadiran' => 'hadir',
            'jumlah_tamu' => 1,
            'ucapan_doa' => 'Ucapan spam',
        ]);

        $this->actingAs($clientA)
            ->delete("/dashboard/undangan/{$undangan->id}/buku-tamu/{$ucapan->id}")
            ->assertRedirect("/dashboard/undangan/{$undangan->id}/kelola?tab=aktivasi");
        $this->assertDatabaseHas('buku_tamu', ['id' => $ucapan->id]);

        $undangan->update([
            'status_publikasi' => true,
            'berlaku_sampai' => now()->addMonths(3),
        ]);

        $this->actingAs($clientA)->get("/dashboard/undangan/{$undangan->id}/tamu")->assertOk()->assertSee('Daftar Tamu');
        $this->actingAs($clientA)->get("/dashboard/undangan/{$undangan->id}/rsvp")->assertOk()->assertSee('RSVP &amp; Ucapan', false);

        $this->actingAs($clientA)
            ->delete("/dashboard/undangan/{$undangan->id}/buku-tamu/{$ucapan->id}")
            ->assertRedirect("/dashboard/undangan/{$undangan->id}/rsvp");
        $this->assertDatabaseMissing('buku_tamu', ['id' => $ucapan->id]);

        $this->actingAs($clientA)
            ->delete("/dashboard/undangan/{$undangan->id}/acara/{$acara->id}")
            ->assertRedirect();
        $this->assertDatabaseMissing('acara_undangan', ['id' => $acara->id]);

        $this->actingAs($clientA)
            ->delete("/dashboard/undangan/{$undangan->id}/amplop/{$amplop->id}")
            ->assertRedirect();
        $this->assertDatabaseMissing('amplop_digital', ['id' => $amplop->id]);
    }

    public function test_galeri_dibatasi_maksimal_10_foto_dan_slug_terkunci_saat_aktif(): void
    {
        Storage::fake('public');

        $tema = $this->buatTema();
        $client = Pengguna::factory()->create();
        $undangan = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $tema->id,
            'slug' => 'galeri-penuh',
            'nama_panggilan_pria' => 'A',
            'nama_lengkap_pria' => 'A Lengkap',
            'nama_panggilan_wanita' => 'B',
            'nama_lengkap_wanita' => 'B Lengkap',
            'status_publikasi' => true,
            'berlaku_sampai' => now()->addMonths(3),
        ]);

        for ($i = 1; $i <= 10; $i++) {
            GaleriUndangan::create([
                'undangan_id' => $undangan->id,
                'lokasi_foto' => "undangan/{$undangan->id}/foto-{$i}.webp",
                'urutan' => $i,
            ]);
        }

        // Unggahan ke-11 harus ditolak
        $this->actingAs($client)
            ->from("/dashboard/undangan/{$undangan->id}/kelola")
            ->post("/dashboard/undangan/{$undangan->id}/galeri", [
                'foto' => $this->buatGambarPngDummy('ke11.png', 400, 400),
            ])
            ->assertRedirect("/dashboard/undangan/{$undangan->id}/kelola")
            ->assertSessionHasErrors('foto');

        $this->assertSame(10, $undangan->daftarGaleri()->count());

        // Client tidak bisa mengubah slug undangan yang sudah aktif
        $this->actingAs($client)
            ->from("/dashboard/undangan/{$undangan->id}/kelola")
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'tema',
                'tema_id' => $tema->id,
                'slug' => 'slug-baru-terlarang',
            ])
            ->assertSessionHasErrors('slug');

        $this->assertSame('galeri-penuh', $undangan->fresh()->slug);
    }

    public function test_panel_admin_aktivasi_tema_pengguna_dan_pembersihan_kedaluwarsa(): void
    {
        Storage::fake('public');

        $tema = $this->buatTema();
        $admin = Pengguna::factory()->admin()->create();
        $client = Pengguna::factory()->create(['peran' => 'client']);

        $draft = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $tema->id,
            'slug' => 'draft-client',
            'nama_panggilan_pria' => 'Ali',
            'nama_lengkap_pria' => 'Ali Akbar',
            'nama_panggilan_wanita' => 'Zahra',
            'nama_lengkap_wanita' => 'Zahra Putri',
            'status_publikasi' => false,
        ]);

        $kedaluwarsa = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $tema->id,
            'slug' => 'undangan-expired',
            'nama_panggilan_pria' => 'Eko',
            'nama_lengkap_pria' => 'Eko Saputra',
            'nama_panggilan_wanita' => 'Nina',
            'nama_lengkap_wanita' => 'Nina Marlina',
            'foto_pria' => 'undangan/expired-placeholder/pria.webp',
            'status_publikasi' => true,
            'berlaku_sampai' => now()->subDay(),
        ]);

        $pathFotoExpired = "undangan/{$kedaluwarsa->id}/foto-1.webp";
        $kedaluwarsa->update(['foto_pria' => $pathFotoExpired]);
        Storage::disk('public')->put($pathFotoExpired, 'dummy-webp');
        GaleriUndangan::create([
            'undangan_id' => $kedaluwarsa->id,
            'lokasi_foto' => $pathFotoExpired,
            'urutan' => 1,
        ]);

        // Client ditolak masuk admin
        $this->actingAs($client)->get('/admin')->assertForbidden();

        // Admin akses dashboard, daftar undangan, tema, dan pengguna
        $this->actingAs($admin)->get('/admin')->assertOk()->assertSee('Dashboard');
        $this->actingAs($admin)->get('/admin/undangan')->assertOk()->assertSee('draft-client');
        $this->actingAs($admin)->get('/admin/tema')->assertOk()->assertSee('Rustic Floral');
        $this->actingAs($admin)->get('/admin/tema/create')->assertOk()->assertSee('Tambah Tema Baru');
        $this->actingAs($admin)->get('/admin/pengguna')->assertOk()->assertSee($client->email);

        // Admin mengaktifkan undangan
        $this->actingAs($admin)
            ->patch("/admin/undangan/{$draft->id}/aktifkan")
            ->assertRedirect();

        $draft->refresh();
        $this->assertTrue($draft->status_publikasi);
        $this->assertNotNull($draft->berlaku_sampai);
        $this->assertTrue($draft->berlaku_sampai->isFuture());

        // Admin dapat mengubah slug undangan milik client (Paket Terima Beres)
        $this->actingAs($admin)
            ->put("/dashboard/undangan/{$draft->id}", [
                'bagian' => 'tema',
                'tema_id' => $tema->id,
                'slug' => 'ali-zahra-resmi',
            ])
            ->assertRedirect();
        $this->assertSame('ali-zahra-resmi', $draft->fresh()->slug);

        // Admin CRUD tema
        $this->actingAs($admin)
            ->post('/admin/tema', [
                'nama_tema' => 'Minimalist Sage',
                'slug' => 'minimalist-sage',
                'kategori' => 'modern',
                'lokasi_view' => 'tema.rustic-floral.index',
                'aktif' => '1',
            ])
            ->assertRedirect('/admin/tema');
        $this->assertDatabaseHas('tema', ['slug' => 'minimalist-sage']);

        // Admin reset sandi pengguna
        $this->actingAs($admin)
            ->patch("/admin/pengguna/{$client->id}/reset-sandi", [
                'kata_sandi_baru' => 'SandiBaru123',
            ])
            ->assertRedirect();
        $this->assertTrue(Hash::check('SandiBaru123', $client->fresh()->kata_sandi));

        // Admin jalankan pembersihan storage kedaluwarsa
        $this->actingAs($admin)
            ->post('/admin/bersihkan-kedaluwarsa')
            ->assertRedirect();

        Storage::disk('public')->assertMissing($pathFotoExpired);
        $this->assertFalse($kedaluwarsa->fresh()->status_publikasi);
        $this->assertNull($kedaluwarsa->fresh()->foto_pria);
        $this->assertDatabaseCount('galeri_undangan', 0);
    }

    public function test_client_dapat_mengubah_gaya_font_dan_mode_tanpa_foto_dan_admin_tambah_kategori_luxury(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $client = Pengguna::factory()->create();
        $tema = $this->buatTema();

        $undangan = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $tema->id,
            'slug' => 'bagas-tiara',
            'nama_panggilan_pria' => 'Bagas',
            'nama_lengkap_pria' => 'Bagas Prakoso',
            'nama_panggilan_wanita' => 'Tiara',
            'nama_lengkap_wanita' => 'Tiara Dewi',
            'pengaturan' => Undangan::pengaturanBawaan(),
        ]);

        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'tema',
                'tema_id' => $tema->id,
                'slug' => 'bagas-tiara',
                'gaya_font' => 'editorial_gilda',
                'tanpa_foto' => '1',
                'fitur_hitung_mundur' => '1',
                'fitur_cerita_cinta' => '1',
                'fitur_galeri' => '1',
                'fitur_amplop_digital' => '1',
                'fitur_buku_tamu' => '1',
            ])
            ->assertRedirect();

        $undangan->refresh();
        $this->assertSame('editorial_gilda', $undangan->kodeGayaFontTerpilih());
        $this->assertTrue($undangan->modeTanpaFoto());
        $this->assertStringContainsString('Gilda+Display', $undangan->resolusiGayaFont()['google_fonts_url']);

        $this->actingAs($admin)
            ->post('/admin/tema', [
                'nama_tema' => 'Starry Ballroom',
                'slug' => 'starry-ballroom',
                'kategori' => 'elegan',
                'lokasi_view' => 'tema.luxury-noir.index',
                'aktif' => '1',
            ])
            ->assertRedirect('/admin/tema');

        $this->assertDatabaseHas('tema', [
            'slug' => 'starry-ballroom',
            'kategori' => 'elegan',
        ]);
    }

    public function test_client_hanya_dapat_menghapus_draft_belum_aktif_dan_tidak_bisa_hapus_undangan_aktif(): void
    {
        Storage::fake('public');

        $client = Pengguna::factory()->create(['peran' => 'client']);
        $clientLain = Pengguna::factory()->create(['peran' => 'client']);
        $tema = $this->buatTema();

        $draft = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $tema->id,
            'slug' => 'uji-coba-draft',
            'nama_panggilan_pria' => 'Raka',
            'nama_lengkap_pria' => 'Raka Wijaya',
            'nama_panggilan_wanita' => 'Sinta',
            'nama_lengkap_wanita' => 'Sinta Dewi',
            'pengaturan' => Undangan::pengaturanBawaan(),
            'status_publikasi' => false,
        ]);

        $pathFotoPria = "undangan/{$draft->id}/pria.webp";
        $pathGaleri = "undangan/{$draft->id}/galeri-1.webp";
        Storage::disk('public')->put($pathFotoPria, 'dummy-pria');
        Storage::disk('public')->put($pathGaleri, 'dummy-galeri');

        $draft->update(['foto_pria' => $pathFotoPria]);
        GaleriUndangan::create([
            'undangan_id' => $draft->id,
            'lokasi_foto' => $pathGaleri,
            'urutan' => 1,
        ]);

        $aktif = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $tema->id,
            'slug' => 'undangan-sudah-aktif',
            'nama_panggilan_pria' => 'Budi',
            'nama_lengkap_pria' => 'Budi Santoso',
            'nama_panggilan_wanita' => 'Laras',
            'nama_lengkap_wanita' => 'Laras Putri',
            'pengaturan' => Undangan::pengaturanBawaan(),
            'status_publikasi' => true,
            'berlaku_sampai' => now()->addMonths(12),
        ]);

        $menungguVerifikasi = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $tema->id,
            'slug' => 'draft-tunggu-verifikasi',
            'nama_panggilan_pria' => 'Dika',
            'nama_lengkap_pria' => 'Dika Saputra',
            'nama_panggilan_wanita' => 'Nadia',
            'nama_lengkap_wanita' => 'Nadia Sari',
            'pengaturan' => Undangan::pengaturanBawaan(),
            'status_publikasi' => false,
        ]);

        Transaksi::create([
            'kode_invoice' => 'INV-TEST-001',
            'undangan_id' => $menungguVerifikasi->id,
            'pengguna_id' => $client->id,
            'tema_id' => $tema->id,
            'paket' => 'mandiri',
            'harga_tema' => 59000,
            'biaya_jasa' => 0,
            'potongan_promo' => 0,
            'total_bayar' => 59000,
            'status' => 'menunggu_verifikasi',
        ]);

        // Tombol Hapus Draft tampil pada draft, tidak tampil pada undangan aktif maupun yang sedang diverifikasi
        $this->actingAs($client)
            ->get("/dashboard/undangan/{$draft->id}/kelola")
            ->assertOk()
            ->assertSee('Hapus Draft');

        $this->actingAs($client)
            ->get("/dashboard/undangan/{$aktif->id}/kelola")
            ->assertOk()
            ->assertDontSee('Hapus Draft');

        $this->actingAs($client)
            ->get("/dashboard/undangan/{$menungguVerifikasi->id}/kelola")
            ->assertOk()
            ->assertDontSee('Hapus Draft');

        // Client lain tidak boleh menghapus draft orang lain
        $this->actingAs($clientLain)
            ->delete("/dashboard/undangan/{$draft->id}")
            ->assertForbidden();

        // Client tidak boleh menghapus undangan yang sudah aktif
        $this->actingAs($client)
            ->delete("/dashboard/undangan/{$aktif->id}")
            ->assertForbidden();

        // Client tidak boleh menghapus draft yang sedang menunggu verifikasi pembayaran
        $this->actingAs($client)
            ->delete("/dashboard/undangan/{$menungguVerifikasi->id}")
            ->assertForbidden();

        $this->assertDatabaseHas('undangan', ['id' => $aktif->id]);
        $this->assertDatabaseHas('undangan', ['id' => $menungguVerifikasi->id]);

        // Client berhasil menghapus draft miliknya yang belum aktif, beserta file storage terkait
        $this->actingAs($client)
            ->delete("/dashboard/undangan/{$draft->id}", ['kembali_ke' => 'beranda'])
            ->assertRedirect('/dashboard')
            ->assertSessionHas('sukses');

        $this->assertDatabaseMissing('undangan', ['id' => $draft->id]);
        $this->assertDatabaseMissing('galeri_undangan', ['undangan_id' => $draft->id]);
        Storage::disk('public')->assertMissing($pathFotoPria);
        Storage::disk('public')->assertMissing($pathGaleri);

        // Galat validasi (misal link sudah dipakai) dirender lewat hook SweetAlert2, bukan alert kotak merah inline
        $this->actingAs($client)
            ->from('/dashboard')
            ->followingRedirects()
            ->post('/dashboard/undangan', [
                'tema_id' => $tema->id,
                'slug' => 'undangan-sudah-aktif',
                'nama_panggilan_pria' => 'Baru',
                'nama_lengkap_pria' => 'Baru Lengkap',
                'nama_panggilan_wanita' => 'Coba',
                'nama_lengkap_wanita' => 'Coba Lengkap',
            ])
            ->assertOk()
            ->assertSee('data-swal-errors', false)
            ->assertSee('sudah dipakai')
            ->assertDontSee('rounded-2xl bg-red-50 border border-red-200', false);
    }
}
