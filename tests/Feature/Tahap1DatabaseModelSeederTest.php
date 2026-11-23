<?php

namespace Tests\Feature;

use App\Models\AcaraUndangan;
use App\Models\AmplopDigital;
use App\Models\BukuTamu;
use App\Models\GaleriUndangan;
use App\Models\Pengguna;
use App\Models\Tema;
use App\Models\Undangan;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class Tahap1DatabaseModelSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_semua_tabel_bahasa_indonesia_tersedia(): void
    {
        $tabelWajib = [
            'pengguna',
            'sessions',
            'tema',
            'undangan',
            'acara_undangan',
            'galeri_undangan',
            'amplop_digital',
            'buku_tamu',
        ];

        foreach ($tabelWajib as $tabel) {
            $this->assertTrue(Schema::hasTable($tabel), "Tabel {$tabel} harus ada di database.");
        }

        $this->assertFalse(Schema::hasTable('users'), 'Tabel default users tidak boleh digunakan.');
    }

    public function test_konfigurasi_auth_menggunakan_model_pengguna_dan_kolom_kata_sandi(): void
    {
        $this->assertSame(Pengguna::class, config('auth.providers.users.model'));

        $admin = Pengguna::create([
            'nama' => 'Admin SesiTemu',
            'email' => 'admin-uji@sesitemu.id',
            'nomor_wa' => '6281234567890',
            'kata_sandi' => Hash::make('rahasia123'),
            'peran' => 'admin',
        ]);

        $client = Pengguna::create([
            'nama' => 'Client SesiTemu',
            'email' => 'client-uji@sesitemu.id',
            'nomor_wa' => '6289876543210',
            'kata_sandi' => 'rahasia123',
            'peran' => 'client',
        ]);

        $this->assertSame('pengguna', $admin->getTable());
        $this->assertSame('kata_sandi', $admin->getAuthPasswordName());
        $this->assertTrue($admin->adalahAdmin());
        $this->assertFalse($admin->adalahClient());
        $this->assertTrue($client->adalahClient());
        $this->assertFalse($client->adalahAdmin());
        $this->assertTrue(Hash::check('rahasia123', $admin->kata_sandi));
        $this->assertTrue(Hash::check('rahasia123', $client->kata_sandi));
    }

    public function test_relasi_model_undangan_dan_auto_delete_galeri_berfungsi(): void
    {
        Storage::fake('public');

        $client = Pengguna::create([
            'nama' => 'Budi',
            'email' => 'budi@sesitemu.id',
            'kata_sandi' => Hash::make('password'),
            'peran' => 'client',
        ]);

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
            'slug' => 'budi-sari',
            'nama_panggilan_pria' => 'Budi',
            'nama_lengkap_pria' => 'Budi Santoso',
            'nama_panggilan_wanita' => 'Sari',
            'nama_lengkap_wanita' => 'Sari Rahayu',
            'pengaturan' => Undangan::pengaturanBawaan(),
            'status_publikasi' => false,
        ]);

        $acara = AcaraUndangan::create([
            'undangan_id' => $undangan->id,
            'nama_acara' => 'Akad Nikah',
            'tanggal_acara' => '2026-12-20',
            'waktu_mulai' => '08:00:00',
            'zona_waktu' => 'WIB',
            'nama_tempat' => 'Masjid Agung',
            'alamat_lengkap' => 'Jakarta Selatan',
        ]);

        $lokasiFoto = 'undangan/'.$undangan->id.'/foto-1.webp';
        Storage::disk('public')->put($lokasiFoto, 'konten-webp-dummy');

        $galeri = GaleriUndangan::create([
            'undangan_id' => $undangan->id,
            'lokasi_foto' => $lokasiFoto,
            'keterangan' => 'Foto Prewedding',
            'urutan' => 1,
        ]);

        $amplop = AmplopDigital::create([
            'undangan_id' => $undangan->id,
            'nama_bank' => 'BCA',
            'nomor_rekening' => '1234567890',
            'atas_nama' => 'Budi Santoso',
        ]);

        $ucapan = BukuTamu::create([
            'undangan_id' => $undangan->id,
            'nama_tamu' => 'Andi',
            'status_kehadiran' => 'hadir',
            'jumlah_tamu' => 2,
            'ucapan_doa' => 'Selamat menempuh hidup baru!',
        ]);

        $this->assertTrue($undangan->pengguna->is($client));
        $this->assertTrue($undangan->tema->is($tema));
        $this->assertTrue($undangan->daftarAcara->contains($acara));
        $this->assertTrue($undangan->daftarGaleri->contains($galeri));
        $this->assertTrue($undangan->daftarAmplop->contains($amplop));
        $this->assertTrue($undangan->bukuTamu->contains($ucapan));
        $this->assertTrue($client->undangan->contains($undangan));
        $this->assertIsArray($undangan->pengaturan);

        Storage::disk('public')->assertExists($lokasiFoto);
        $galeri->delete();
        Storage::disk('public')->assertMissing($lokasiFoto);
    }

    public function test_database_seeder_mengisi_akun_tema_dan_undangan_contoh(): void
    {
        $this->seed(DatabaseSeeder::class);

        $admin = Pengguna::where('email', 'admin@sesitemu.id')->first();
        $client = Pengguna::where('email', 'client@sesitemu.id')->first();

        $this->assertNotNull($admin);
        $this->assertSame('admin', $admin->peran);
        $this->assertNotNull($client);
        $this->assertSame('client', $client->peran);

        $this->assertSame(9, Tema::count());
        $this->assertDatabaseHas('tema', ['slug' => 'rustic-floral', 'kategori' => 'floral']);
        $this->assertDatabaseHas('tema', ['slug' => 'editorial-monokrom', 'kategori' => 'modern']);
        $this->assertDatabaseHas('tema', ['slug' => 'luxury-noir', 'kategori' => 'elegan']);
        $this->assertDatabaseHas('tema', ['slug' => 'royal-ivory', 'kategori' => 'elegan']);
        $this->assertDatabaseHas('tema', ['slug' => 'velvet-garden', 'kategori' => 'floral']);
        $this->assertDatabaseHas('tema', ['slug' => 'adat-jawa', 'kategori' => 'adat']);
        $this->assertDatabaseHas('tema', ['slug' => 'sunda-heritage', 'kategori' => 'adat']);
        $this->assertDatabaseHas('tema', ['slug' => 'islami-syari', 'kategori' => 'islami']);
        $this->assertDatabaseHas('tema', ['slug' => 'islamic-heavenly', 'kategori' => 'islami']);

        $undanganContoh = Undangan::where('pengguna_id', $client->id)->first();
        $this->assertNotNull($undanganContoh);
        $this->assertGreaterThanOrEqual(1, $undanganContoh->daftarAcara()->count());
        $this->assertGreaterThanOrEqual(1, $undanganContoh->daftarAmplop()->count());
        $this->assertGreaterThanOrEqual(1, $undanganContoh->bukuTamu()->count());
    }
}
