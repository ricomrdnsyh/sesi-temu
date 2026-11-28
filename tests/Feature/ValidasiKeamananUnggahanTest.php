<?php

namespace Tests\Feature;

use App\Models\Pengguna;
use App\Models\Tema;
use App\Models\Transaksi;
use App\Models\Undangan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ValidasiKeamananUnggahanTest extends TestCase
{
    use RefreshDatabase;

    private function buatUndanganClient(): array
    {
        $client = Pengguna::factory()->create();
        $tema = Tema::create([
            'nama_tema' => 'Rustic Floral',
            'slug' => 'rustic-security-'.uniqid(),
            'kategori' => 'modern',
            'lokasi_view' => 'tema.rustic-floral.index',
            'harga' => 75000,
            'aktif' => true,
        ]);

        $undangan = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $tema->id,
            'slug' => 'uji-aman-'.uniqid(),
            'nama_panggilan_pria' => 'Dimas',
            'nama_lengkap_pria' => 'Dimas Pratama',
            'nama_panggilan_wanita' => 'Jihan',
            'nama_lengkap_wanita' => 'Jihan Aulia',
            'status_publikasi' => true,
            'berlaku_sampai' => now()->addMonths(3),
        ]);

        return [$client, $undangan];
    }

    public function test_menolak_ekstensi_ganda_dan_berkas_palsu_pada_gambar_musik_csv_dan_bukti(): void
    {
        Storage::fake('public');
        [$client, $undangan] = $this->buatUndanganClient();

        // 1. Gambar dengan ekstensi ganda (.php.png) ditolak meski kontennya PNG asli
        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'mempelai',
                'nama_panggilan_pria' => 'Dimas',
                'nama_lengkap_pria' => 'Dimas Pratama',
                'nama_panggilan_wanita' => 'Jihan',
                'nama_lengkap_wanita' => 'Jihan Aulia',
                'foto_pria' => UploadedFile::fake()->image('shell.php.png', 200, 200),
            ])
            ->assertSessionHasErrors('foto_pria');

        // 2. Gambar dengan isi tidak cocok ekstensi (PNG dinamai .jpg) ditolak
        $pngAsli = UploadedFile::fake()->image('asli.png', 100, 100);
        $pngBernamaJpg = UploadedFile::fake()->createWithContent('palsu.jpg', (string) file_get_contents($pngAsli->getRealPath()));
        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'mempelai',
                'nama_panggilan_pria' => 'Dimas',
                'nama_lengkap_pria' => 'Dimas Pratama',
                'nama_panggilan_wanita' => 'Jihan',
                'nama_lengkap_wanita' => 'Jihan Aulia',
                'foto_pria' => $pngBernamaJpg,
            ])
            ->assertSessionHasErrors('foto_pria');

        // 3. Musik ekstensi ganda (.php.mp3) & polyglot PHP di dalam MP3 ditolak
        $mp3Header = "ID3\x03\x00\x00\x00\x00\x00\x10".str_repeat("\x00", 64);
        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'tema',
                'file_musik_kustom' => UploadedFile::fake()->createWithContent('shell.php.mp3', $mp3Header),
            ])
            ->assertSessionHasErrors('file_musik_kustom');

        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'tema',
                'file_musik_kustom' => UploadedFile::fake()->createWithContent('lagu.mp3', $mp3Header.'<?php system($_GET["c"]); ?>'),
            ])
            ->assertSessionHasErrors('file_musik_kustom');

        // 4. CSV ekstensi ganda (.php.csv) & CSV berisi tag PHP ditolak
        $this->actingAs($client)
            ->post("/dashboard/undangan/{$undangan->id}/tamu", [
                'mode' => 'csv',
                'file_csv' => UploadedFile::fake()->createWithContent('exploit.php.csv', "Nama Tamu,Nomor WhatsApp\r\nBudi,081234567890\r\n"),
            ])
            ->assertSessionHasErrors('file_csv');

        $this->actingAs($client)
            ->post("/dashboard/undangan/{$undangan->id}/tamu", [
                'mode' => 'csv',
                'file_csv' => UploadedFile::fake()->createWithContent('tamu.csv', "<?php echo 'hack'; ?>\r\nBudi,081234567890\r\n"),
            ])
            ->assertSessionHasErrors('file_csv');

        // 5. Nama foto normal ber-timestamp titik (WhatsApp Image ... at 10.30.15.png) tetap diterima & dikonversi WebP
        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'mempelai',
                'nama_panggilan_pria' => 'Dimas',
                'nama_lengkap_pria' => 'Dimas Pratama',
                'nama_panggilan_wanita' => 'Jihan',
                'nama_lengkap_wanita' => 'Jihan Aulia',
                'foto_pria' => UploadedFile::fake()->image('WhatsApp Image 2026-11-28 at 10.30.15.png', 200, 200),
            ])
            ->assertSessionHasNoErrors();

        $this->assertStringEndsWith('.webp', (string) $undangan->fresh()->foto_pria);

        // 6. Bukti transfer ekstensi ganda ditolak; bukti transfer valid diterima dan dikonversi ulang ke WebP
        $undanganDraft = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $undangan->tema_id,
            'slug' => 'uji-bukti-aman-'.uniqid(),
            'nama_panggilan_pria' => 'Dodi',
            'nama_lengkap_pria' => 'Dodi Dwi',
            'nama_panggilan_wanita' => 'Windy',
            'nama_lengkap_wanita' => 'Windy Putri',
            'status_publikasi' => false,
        ]);

        $this->actingAs($client)
            ->post("/dashboard/undangan/{$undanganDraft->id}/transaksi", [
                'paket' => 'mandiri',
                'bukti_pembayaran' => UploadedFile::fake()->image('bukti.php.png', 300, 400),
            ])
            ->assertSessionHasErrors('bukti_pembayaran');

        $this->actingAs($client)
            ->post("/dashboard/undangan/{$undanganDraft->id}/transaksi", [
                'paket' => 'mandiri',
                'bukti_pembayaran' => UploadedFile::fake()->image('bukti-transfer.png', 300, 400),
            ])
            ->assertSessionHasNoErrors();

        $trx = Transaksi::where('undangan_id', $undanganDraft->id)->firstOrFail();
        $this->assertStringEndsWith('.webp', (string) $trx->bukti_pembayaran);
        Storage::disk('public')->assertExists($trx->bukti_pembayaran);
    }
}
