<?php

namespace Tests\Feature;

use App\Models\BukuTamu;
use App\Models\MusikLatar;
use App\Models\Pengguna;
use App\Models\Promo;
use App\Models\Tema;
use App\Models\Transaksi;
use App\Models\Undangan;
use App\Support\PengaturanSesiTemu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PanelAdminEkspansiTest extends TestCase
{
    use RefreshDatabase;

    private function buatTemaContoh(): Tema
    {
        return Tema::create([
            'nama_tema' => 'Velvet Garden',
            'slug' => 'velvet-garden-uji',
            'kategori' => 'luxury',
            'tier' => 'eksklusif',
            'harga' => 129000,
            'lokasi_view' => 'tema.velvet-garden.index',
            'aktif' => true,
        ]);
    }

    public function test_pengguna_client_dilarang_mengakses_enam_modul_admin_baru(): void
    {
        $client = Pengguna::factory()->create(['peran' => 'client']);

        foreach ([
            '/admin/transaksi',
            '/admin/buku-tamu',
            '/admin/musik',
            '/admin/promo',
            '/admin/laporan',
            '/admin/laporan/ekspor',
            '/admin/pengaturan',
        ] as $rute) {
            $this->actingAs($client)->get($rute)->assertForbidden();
        }
    }

    public function test_pengaturan_platform_memengaruhi_beranda_dasbor_dan_durasi_aktivasi(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $client = Pengguna::factory()->create(['peran' => 'client']);
        $tema = $this->buatTemaContoh();

        $undangan = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $tema->id,
            'slug' => 'pengaturan-uji',
            'nama_panggilan_pria' => 'Raka',
            'nama_lengkap_pria' => 'Raka Pratama',
            'nama_panggilan_wanita' => 'Sinta',
            'nama_lengkap_wanita' => 'Sinta Dewi',
            'status_publikasi' => false,
        ]);

        $this->actingAs($admin)
            ->put('/admin/pengaturan', [
                'nomor_wa_admin' => '081122334455',
                'masa_aktif_bulan' => 6,
                'biaya_terima_beres' => 75000,
                'nama_bank_pembayaran' => 'Mandiri',
                'nomor_rekening_pembayaran' => '1440099887766',
                'atas_nama_rekening' => 'SesiTemu Indonesia',
                'catatan_pembayaran' => 'Transfer sesuai nominal invoice.',
            ])
            ->assertRedirect()
            ->assertSessionHas('sukses');

        $this->assertSame('6281122334455', PengaturanSesiTemu::nomorWaAdmin());
        $this->assertSame(6, PengaturanSesiTemu::masaAktifBulan());
        $this->assertSame(75000, PengaturanSesiTemu::biayaTerimaBeres());

        $this->get('/')
            ->assertOk()
            ->assertSee('6281122334455')
            ->assertSee('Aktif 6 Bulan Penuh')
            ->assertSee('/ 6 bln')
            ->assertSee('/ 6 bulan aktif')
            ->assertSee('Rp 75.000');

        $this->actingAs($admin)
            ->get('/admin/undangan')
            ->assertOk()
            ->assertSee('Aktifkan Undangan (6 Bulan)');

        $this->actingAs($client)
            ->get('/dasbor')
            ->assertOk()
            ->assertSee('6281122334455');

        $this->actingAs($admin)
            ->patch("/admin/undangan/{$undangan->id}/aktifkan")
            ->assertRedirect();

        $undanganSegar = $undangan->fresh();
        $this->assertTrue($undanganSegar->status_publikasi);
        $this->assertNotNull($undanganSegar->berlaku_sampai);
        $this->assertGreaterThan(now()->addMonths(5)->timestamp, $undanganSegar->berlaku_sampai->timestamp);
    }

    public function test_admin_mengelola_musik_latar_dan_tersedia_di_editor_client(): void
    {
        Storage::fake('public');

        $admin = Pengguna::factory()->admin()->create();
        $client = Pengguna::factory()->create(['peran' => 'client']);
        $tema = $this->buatTemaContoh();

        $undangan = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $tema->id,
            'slug' => 'musik-client-uji',
            'nama_panggilan_pria' => 'Bima',
            'nama_lengkap_pria' => 'Bima Putra',
            'nama_panggilan_wanita' => 'Tari',
            'nama_lengkap_wanita' => 'Tari Lestari',
            'status_publikasi' => false,
        ]);

        $audioFake = UploadedFile::fake()->create('melodi-cinta.mp3', 256, 'audio/mpeg');

        $this->actingAs($admin)
            ->post('/admin/musik', [
                'judul' => 'Melodi Cinta Baru',
                'artis' => 'Orchestra SesiTemu',
                'kategori' => 'Romantis',
                'file_audio' => $audioFake,
            ])
            ->assertRedirect()
            ->assertSessionHas('sukses');

        $musikBaru = MusikLatar::where('judul', 'Melodi Cinta Baru')->firstOrFail();
        Storage::disk('public')->assertExists(substr($musikBaru->path_file, 8));

        $this->actingAs($client)
            ->get("/dasbor/undangan/{$undangan->id}/kelola")
            ->assertOk()
            ->assertSee('Melodi Cinta Baru')
            ->assertSee($musikBaru->path_file);

        $this->actingAs($admin)
            ->patch("/admin/musik/{$musikBaru->id}/toggle")
            ->assertRedirect();
        $this->assertFalse($musikBaru->fresh()->aktif);

        session()->forget('sukses');

        $this->actingAs($client)
            ->get("/dasbor/undangan/{$undangan->id}/kelola")
            ->assertOk()
            ->assertDontSee('Melodi Cinta Baru')
            ->assertDontSee($musikBaru->path_file);

        $this->actingAs($admin)
            ->delete("/admin/musik/{$musikBaru->id}")
            ->assertRedirect();
        $this->assertDatabaseMissing('musik_latar', ['id' => $musikBaru->id]);
    }

    public function test_promo_transaksi_client_dan_verifikasi_admin_terintegrasi(): void
    {
        Storage::fake('public');

        $admin = Pengguna::factory()->admin()->create();
        $client = Pengguna::factory()->create(['peran' => 'client']);
        $tema = $this->buatTemaContoh();

        $undangan = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $tema->id,
            'slug' => 'checkout-client-uji',
            'nama_panggilan_pria' => 'Dani',
            'nama_lengkap_pria' => 'Dani Permana',
            'nama_panggilan_wanita' => 'Nadia',
            'nama_lengkap_wanita' => 'Nadia Ayu',
            'status_publikasi' => false,
        ]);

        $this->actingAs($admin)
            ->post('/admin/promo', [
                'kode' => 'HEMAT20',
                'nama_promo' => 'Diskon Uji 20%',
                'tipe_diskon' => 'persen',
                'nilai_diskon' => 20,
                'maksimal_diskon' => 30000,
                'kuota' => 5,
            ])
            ->assertRedirect()
            ->assertSessionHas('sukses');

        $promo = Promo::where('kode', 'HEMAT20')->firstOrFail();
        $bukti = UploadedFile::fake()->create('bukti.png', 120, 'image/png');

        // Total: harga tema 129.000 + Terima Beres 50.000 = 179.000; 20% = 35.800 dibatasi maks 30.000 => 149.000
        $this->actingAs($client)
            ->post("/dasbor/undangan/{$undangan->id}/transaksi", [
                'paket' => 'terima_beres',
                'kode_promo' => 'hemat20',
                'bukti_pembayaran' => $bukti,
            ])
            ->assertRedirect("/dasbor/undangan/{$undangan->id}/kelola")
            ->assertSessionHas('sukses');

        $transaksi = Transaksi::where('undangan_id', $undangan->id)->firstOrFail();
        $this->assertSame('menunggu_verifikasi', $transaksi->status);
        $this->assertSame(129000, $transaksi->harga_tema);
        $this->assertSame(50000, $transaksi->biaya_jasa);
        $this->assertSame(30000, $transaksi->potongan_promo);
        $this->assertSame(149000, $transaksi->total_bayar);
        Storage::disk('public')->assertExists($transaksi->bukti_pembayaran);

        // Admin memverifikasi lunas => promo terpakai +1 dan undangan langsung aktif
        $this->actingAs($admin)
            ->patch("/admin/transaksi/{$transaksi->id}/verifikasi")
            ->assertRedirect()
            ->assertSessionHas('sukses');

        $this->assertSame('lunas', $transaksi->fresh()->status);
        $this->assertSame(1, $promo->fresh()->jumlah_terpakai);
        $this->assertTrue($undangan->fresh()->status_publikasi);
        $this->assertNotNull($undangan->fresh()->berlaku_sampai);

        // Laporan & ekspor CSV menampilkan transaksi lunas tersebut
        $this->actingAs($admin)
            ->get('/admin/laporan')
            ->assertOk()
            ->assertSee('Rp 149.000')
            ->assertSee('Velvet Garden');

        $ekspor = $this->actingAs($admin)->get('/admin/laporan/ekspor');
        $ekspor->assertOk();
        $this->assertStringContainsString($transaksi->kode_invoice, $ekspor->streamedContent());
    }

    public function test_admin_moderasi_buku_tamu_lintas_undangan(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $client = Pengguna::factory()->create(['peran' => 'client']);
        $tema = $this->buatTemaContoh();

        $undangan = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $tema->id,
            'slug' => 'tamu-moderasi-uji',
            'nama_panggilan_pria' => 'Farhan',
            'nama_lengkap_pria' => 'Farhan Ahmad',
            'nama_panggilan_wanita' => 'Mira',
            'nama_lengkap_wanita' => 'Mira Sari',
            'status_publikasi' => true,
        ]);

        $ucapan = BukuTamu::create([
            'undangan_id' => $undangan->id,
            'nama_tamu' => 'Tamu Penguji',
            'status_kehadiran' => 'hadir',
            'jumlah_tamu' => 2,
            'ucapan_doa' => 'Selamat menempuh hidup baru!',
        ]);

        $this->actingAs($admin)
            ->get('/admin/buku-tamu')
            ->assertOk()
            ->assertSee('Tamu Penguji')
            ->assertSee('Selamat menempuh hidup baru!');

        $this->actingAs($admin)
            ->delete("/admin/buku-tamu/{$ucapan->id}")
            ->assertRedirect()
            ->assertSessionHas('sukses');

        $this->assertDatabaseMissing('buku_tamu', ['id' => $ucapan->id]);
    }

    public function test_admin_mengelola_pengguna_admin_dan_client_serta_detail_edit_reset_sandi(): void
    {
        $adminUtama = Pengguna::factory()->admin()->create();
        $clientAwal = Pengguna::factory()->create(['peran' => 'client']);
        $tema = $this->buatTemaContoh();

        $undangan = Undangan::create([
            'pengguna_id' => $clientAwal->id,
            'tema_id' => $tema->id,
            'slug' => 'detail-pengguna-uji',
            'nama_panggilan_pria' => 'Aldi',
            'nama_lengkap_pria' => 'Aldi Pratama',
            'nama_panggilan_wanita' => 'Sari',
            'nama_lengkap_wanita' => 'Sari Indah',
            'status_publikasi' => true,
        ]);

        // Daftar pengguna menampilkan admin, client, dan modal form tambah/edit sekaligus
        $this->actingAs($adminUtama)
            ->get('/admin/pengguna')
            ->assertOk()
            ->assertSee($adminUtama->email)
            ->assertSee($clientAwal->email)
            ->assertSee('Admin')
            ->assertSee('Client')
            ->assertSee('data-buka-modal-tambah', false)
            ->assertSee('data-buka-modal-edit', false)
            ->assertSee('role="dialog"', false);

        // Query ?edit=ID memuat data awal ke modal edit
        $this->actingAs($adminUtama)
            ->get("/admin/pengguna?edit={$clientAwal->id}")
            ->assertOk()
            ->assertSee('"modalTerbuka":true', false);

        // Filter berdasarkan peran admin
        $this->actingAs($adminUtama)
            ->get('/admin/pengguna?peran=admin')
            ->assertOk()
            ->assertSee($adminUtama->email)
            ->assertDontSee($clientAwal->email);

        // Tambah akun admin baru
        $this->actingAs($adminUtama)
            ->post('/admin/pengguna', [
                'nama' => 'Admin Kedua',
                'email' => 'admin2@sesitemu.id',
                'nomor_wa' => '081234560000',
                'peran' => 'admin',
                'kata_sandi' => 'Rahasia123',
            ])
            ->assertRedirect('/admin/pengguna')
            ->assertSessionHas('sukses');

        $adminKedua = Pengguna::where('email', 'admin2@sesitemu.id')->firstOrFail();
        $this->assertSame('admin', $adminKedua->peran);
        $this->assertSame('6281234560000', $adminKedua->nomor_wa);
        $this->assertTrue(Hash::check('Rahasia123', $adminKedua->kata_sandi));

        // Lihat Detail Pengguna client lengkap dengan undangannya
        $this->actingAs($adminUtama)
            ->get("/admin/pengguna/{$clientAwal->id}")
            ->assertOk()
            ->assertSee($clientAwal->nama)
            ->assertSee($undangan->slug);

        // Edit data pengguna tanpa mengubah kata sandi (field kata_sandi dikosongkan)
        $hashLama = $clientAwal->kata_sandi;
        $this->actingAs($adminUtama)
            ->put("/admin/pengguna/{$clientAwal->id}", [
                'nama' => 'Nama Client Diubah',
                'email' => $clientAwal->email,
                'nomor_wa' => '089988776655',
                'peran' => 'client',
                'kata_sandi' => '',
            ])
            ->assertRedirect('/admin/pengguna')
            ->assertSessionHas('sukses');

        $this->assertSame('Nama Client Diubah', $clientAwal->fresh()->nama);
        $this->assertSame('6289988776655', $clientAwal->fresh()->nomor_wa);
        $this->assertSame($hashLama, $clientAwal->fresh()->kata_sandi);

        // Edit pengguna sekaligus reset kata sandi baru
        $this->actingAs($adminUtama)
            ->put("/admin/pengguna/{$clientAwal->id}", [
                'nama' => 'Nama Client Diubah',
                'email' => $clientAwal->email,
                'nomor_wa' => '6289988776655',
                'peran' => 'client',
                'kata_sandi' => 'SandiBaru999',
            ])
            ->assertRedirect('/admin/pengguna')
            ->assertSessionHas('sukses');

        $this->assertTrue(Hash::check('SandiBaru999', $clientAwal->fresh()->kata_sandi));

        // Guard: tidak bisa menghapus akun sendiri, tetapi bisa hapus admin kedua
        $this->actingAs($adminUtama)
            ->delete("/admin/pengguna/{$adminUtama->id}")
            ->assertSessionHasErrors('pengguna');

        $this->actingAs($adminUtama)
            ->delete("/admin/pengguna/{$adminKedua->id}")
            ->assertRedirect()
            ->assertSessionHas('sukses');

        $this->assertDatabaseMissing('pengguna', ['id' => $adminKedua->id]);

        // Katalog tema memakai modal tambah/edit beserta dropzone pratinjau gambar
        $this->actingAs($adminUtama)
            ->get('/admin/tema')
            ->assertOk()
            ->assertSee('data-buka-modal-tambah-tema', false)
            ->assertSee('data-buka-modal-edit-tema', false)
            ->assertSee('id="judul-modal-tema"', false)
            ->assertSee('id="modal_gambar_pratinjau"', false);
    }

    public function test_admin_menerapkan_diskon_per_tema_dan_diskon_massal_ke_katalog(): void
    {
        Storage::fake('public');

        $admin = Pengguna::factory()->admin()->create();
        $client = Pengguna::factory()->create(['peran' => 'client']);

        $temaBasic = Tema::create([
            'nama_tema' => 'Rustic Basic Uji',
            'slug' => 'rustic-basic-uji',
            'kategori' => 'modern',
            'tier' => 'basic',
            'harga' => 60000,
            'lokasi_view' => 'tema.rustic-floral.index',
            'aktif' => true,
        ]);

        $temaEksklusif = $this->buatTemaContoh();

        $undangan = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $temaEksklusif->id,
            'slug' => 'diskon-katalog-uji',
            'nama_panggilan_pria' => 'Aldo',
            'nama_lengkap_pria' => 'Aldo Pratama',
            'nama_panggilan_wanita' => 'Nisa',
            'nama_lengkap_wanita' => 'Nisa Putri',
            'status_publikasi' => false,
        ]);

        // Validasi: persentase > 100 ditolak
        $this->actingAs($admin)
            ->put("/admin/tema/{$temaBasic->id}", [
                'nama_tema' => $temaBasic->nama_tema,
                'slug' => $temaBasic->slug,
                'kategori' => $temaBasic->kategori,
                'tier' => $temaBasic->tier,
                'harga' => 60000,
                'diskon_tipe' => 'persen',
                'diskon_nilai' => 120,
                'lokasi_view' => $temaBasic->lokasi_view,
                'aktif' => 1,
            ])
            ->assertSessionHasErrors('diskon_nilai');

        // Diskon per tema (nominal Rp 15.000 pada harga Rp 60.000 => Rp 45.000)
        $this->actingAs($admin)
            ->put("/admin/tema/{$temaBasic->id}", [
                'nama_tema' => $temaBasic->nama_tema,
                'slug' => $temaBasic->slug,
                'kategori' => $temaBasic->kategori,
                'tier' => $temaBasic->tier,
                'harga' => 60000,
                'diskon_tipe' => 'nominal',
                'diskon_nilai' => 15000,
                'lokasi_view' => $temaBasic->lokasi_view,
                'aktif' => 1,
            ])
            ->assertRedirect('/admin/tema')
            ->assertSessionHas('sukses');

        $temaBasic->refresh();
        $this->assertTrue($temaBasic->adaDiskon());
        $this->assertSame(60000, $temaBasic->hargaAsliNominal());
        $this->assertSame(45000, $temaBasic->hargaNominal());
        $this->assertSame('Rp 60.000', $temaBasic->hargaAsliFormatted());
        $this->assertSame('Rp 45.000', $temaBasic->hargaFormatted());
        $this->assertSame('Hemat Rp 15.000', $temaBasic->labelBadgeDiskon());

        $this->actingAs($admin)
            ->get('/admin/tema')
            ->assertOk()
            ->assertSee('data-buka-modal-diskon-massal', false)
            ->assertSee('Hemat Rp 15.000')
            ->assertSee('Rp 60.000')
            ->assertSee('Rp 45.000');

        $this->get('/')
            ->assertOk()
            ->assertSee('Hemat Rp 15.000')
            ->assertSee('Rp 60.000')
            ->assertSee('Rp 45.000');

        // Diskon massal 20% khusus tier eksklusif => Rp 129.000 - Rp 25.800 = Rp 103.200; tier basic tidak berubah
        $this->actingAs($admin)
            ->post('/admin/tema-diskon-massal', [
                'target_tier' => 'eksklusif',
                'diskon_tipe' => 'persen',
                'diskon_nilai' => 20,
            ])
            ->assertRedirect('/admin/tema')
            ->assertSessionHas('sukses');

        $temaBasic->refresh();
        $temaEksklusif->refresh();

        $this->assertSame(45000, $temaBasic->hargaNominal());
        $this->assertTrue($temaEksklusif->adaDiskon());
        $this->assertSame(129000, $temaEksklusif->hargaAsliNominal());
        $this->assertSame(103200, $temaEksklusif->hargaNominal());
        $this->assertSame('Diskon 20%', $temaEksklusif->labelBadgeDiskon());

        // Editor client Tab 7 & Beranda menampilkan harga coret + harga diskon
        $this->actingAs($client)
            ->get("/dasbor/undangan/{$undangan->id}/kelola")
            ->assertOk()
            ->assertSee('Rp 129.000')
            ->assertSee('Rp 103.200');

        // Checkout client otomatis memakai harga tema terdiskon (103.200 + biaya Terima Beres 50.000 = 153.200)
        $bukti = UploadedFile::fake()->create('bukti-diskon.png', 100, 'image/png');
        $this->actingAs($client)
            ->post("/dasbor/undangan/{$undangan->id}/transaksi", [
                'paket' => 'terima_beres',
                'bukti_pembayaran' => $bukti,
            ])
            ->assertRedirect("/dasbor/undangan/{$undangan->id}/kelola")
            ->assertSessionHas('sukses');

        $transaksi = Transaksi::where('undangan_id', $undangan->id)->firstOrFail();
        $this->assertSame(103200, $transaksi->harga_tema);
        $this->assertSame(50000, $transaksi->biaya_jasa);
        $this->assertSame(153200, $transaksi->total_bayar);

        // Diskon massal ke semua tema 10%, lalu reset semua diskon
        $this->actingAs($admin)
            ->post('/admin/tema-diskon-massal', [
                'target_tier' => 'semua',
                'diskon_tipe' => 'persen',
                'diskon_nilai' => 10,
            ])
            ->assertRedirect('/admin/tema')
            ->assertSessionHas('sukses');

        $this->assertSame(54000, $temaBasic->fresh()->hargaNominal());
        $this->assertSame(116100, $temaEksklusif->fresh()->hargaNominal());

        $this->actingAs($admin)
            ->post('/admin/tema-reset-diskon', [
                'target_tier' => 'semua',
            ])
            ->assertRedirect('/admin/tema')
            ->assertSessionHas('sukses');

        $this->assertFalse($temaBasic->fresh()->adaDiskon());
        $this->assertFalse($temaEksklusif->fresh()->adaDiskon());
        $this->assertSame(60000, $temaBasic->fresh()->hargaNominal());
        $this->assertSame(129000, $temaEksklusif->fresh()->hargaNominal());
    }

    public function test_admin_hanya_bisa_memilih_template_blade_tema_yang_tersedia(): void
    {
        $admin = Pengguna::factory()->admin()->create();

        $daftarView = Tema::daftarLokasiViewTersedia();
        $this->assertArrayHasKey('tema.rustic-floral.index', $daftarView);
        $this->assertArrayHasKey('tema.luxury-noir.index', $daftarView);

        $this->actingAs($admin)
            ->get('/admin/tema')
            ->assertOk()
            ->assertSee('<select', false)
            ->assertSee('id="modal_lokasi_view"', false)
            ->assertSee('tema.rustic-floral.index');

        $this->actingAs($admin)
            ->get('/admin/tema/create')
            ->assertOk()
            ->assertSee('id="lokasi_view"', false)
            ->assertSee('tema.velvet-garden.index');

        // View yang file Blade-nya belum dibuat ditolak
        $this->actingAs($admin)
            ->post('/admin/tema', [
                'nama_tema' => 'Tema Fiktif',
                'slug' => 'tema-fiktif',
                'kategori' => 'modern',
                'tier' => 'basic',
                'harga' => 59000,
                'lokasi_view' => 'tema.belum-dibuat.index',
                'aktif' => 1,
            ])
            ->assertSessionHasErrors('lokasi_view');

        // View di luar folder resources/views/tema/ juga ditolak
        $this->actingAs($admin)
            ->post('/admin/tema', [
                'nama_tema' => 'Tema Salah Folder',
                'slug' => 'tema-salah-folder',
                'kategori' => 'modern',
                'tier' => 'basic',
                'harga' => 59000,
                'lokasi_view' => 'beranda',
                'aktif' => 1,
            ])
            ->assertSessionHasErrors('lokasi_view');

        $this->assertDatabaseMissing('tema', ['slug' => 'tema-fiktif']);
        $this->assertDatabaseMissing('tema', ['slug' => 'tema-salah-folder']);
    }

    public function test_tampilan_dasbor_client_memiliki_bottom_navbar_mobile_first(): void
    {
        $client = Pengguna::factory()->create(['peran' => 'client']);
        $tema = $this->buatTemaContoh();

        $undangan = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $tema->id,
            'slug' => 'mobile-nav-uji',
            'nama_panggilan_pria' => 'Budi',
            'nama_lengkap_pria' => 'Budi Santoso',
            'nama_panggilan_wanita' => 'Sari',
            'nama_lengkap_wanita' => 'Sari Dewi',
            'status_publikasi' => false,
        ]);

        $this->actingAs($client)
            ->get('/dasbor')
            ->assertOk()
            ->assertSee('data-client-bottom-nav', false)
            ->assertSee('md:hidden fixed bottom-0', false)
            ->assertSee('pb-28 md:py-8', false)
            ->assertSee('Buat Draft');

        $this->actingAs($client)
            ->get("/dasbor/undangan/{$undangan->id}/kelola")
            ->assertOk()
            ->assertSee('data-client-bottom-nav', false)
            ->assertSee('data-mobile-tab="tema"', false)
            ->assertSee('data-mobile-tab="mempelai"', false)
            ->assertSee('data-mobile-tab="acara"', false)
            ->assertSee('data-mobile-tab="galeri"', false)
            ->assertSee('data-mobile-tab="amplop"', false)
            ->assertSee('data-mobile-tab="tamu"', false)
            ->assertSee('data-mobile-tab="aktivasi"', false);
    }
}
