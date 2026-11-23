<?php

namespace Tests\Feature;

use App\Models\AcaraUndangan;
use App\Models\AmplopDigital;
use App\Models\GaleriUndangan;
use App\Models\Pengguna;
use App\Models\Tema;
use App\Models\Undangan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class Tahap5UndanganPublikTemaTest extends TestCase
{
    use RefreshDatabase;

    private function buatUndanganLengkap(
        string $slugTema = 'rustic-floral',
        string $slugUndangan = 'dimas-rani',
        bool $publikasi = true,
        ?Carbon $berlakuSampai = null
    ): Undangan {
        $client = Pengguna::factory()->create();

        $lokasiView = match ($slugTema) {
            'adat-jawa' => 'tema.adat-jawa.index',
            'islami-syari' => 'tema.islami-syari.index',
            'editorial-monokrom' => 'tema.editorial-monokrom.index',
            'luxury-noir' => 'tema.luxury-noir.index',
            'royal-ivory' => 'tema.royal-ivory.index',
            'velvet-garden' => 'tema.velvet-garden.index',
            'sunda-heritage' => 'tema.sunda-heritage.index',
            'islamic-heavenly' => 'tema.islamic-heavenly.index',
            default => 'tema.rustic-floral.index',
        };

        $kategori = match ($slugTema) {
            'adat-jawa', 'sunda-heritage' => 'adat',
            'islami-syari', 'islamic-heavenly' => 'islami',
            'rustic-floral', 'velvet-garden' => 'floral',
            'luxury-noir', 'royal-ivory' => 'elegan',
            default => 'modern',
        };

        $tema = Tema::firstOrCreate(
            ['slug' => $slugTema],
            [
                'nama_tema' => ucwords(str_replace('-', ' ', $slugTema)),
                'kategori' => $kategori,
                'lokasi_view' => $lokasiView,
                'gambar_pratinjau' => "aset-demo/tema-{$slugTema}.webp",
                'aktif' => true,
            ]
        );

        $undangan = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $tema->id,
            'slug' => $slugUndangan,
            'nama_panggilan_pria' => 'Dimas',
            'nama_lengkap_pria' => 'Dimas Pratama',
            'nama_ayah_pria' => 'Bpk. Hendra',
            'nama_ibu_pria' => 'Ibu Ratna',
            'foto_pria' => 'aset-demo/mempelai-pria.webp',
            'nama_panggilan_wanita' => 'Rani',
            'nama_lengkap_wanita' => 'Rani Kusuma',
            'nama_ayah_wanita' => 'Bpk. Bambang',
            'nama_ibu_wanita' => 'Ibu Sri',
            'foto_wanita' => 'aset-demo/mempelai-wanita.webp',
            'kutipan_ayat' => 'QS. Ar-Rum: 21',
            'musik_latar' => 'musik/romantis-akustik.mp3',
            'pengaturan' => [
                'cerita_cinta' => [
                    ['judul' => 'Pertama Bertemu', 'tanggal' => '2023', 'cerita' => 'Awal kisah kami.'],
                ],
                'live_streaming' => [
                    'aktif' => true,
                    'platform' => 'YouTube Live',
                    'link' => 'https://youtube.com/live/contoh',
                ],
                'alamat_kado_fisik' => 'Jl. Kemang Raya No. 45, Jakarta',
                'fitur_aktif' => [
                    'hitung_mundur' => true,
                    'cerita_cinta' => true,
                    'galeri' => true,
                    'amplop_digital' => true,
                    'buku_tamu' => true,
                ],
            ],
            'status_publikasi' => $publikasi,
            'berlaku_sampai' => $berlakuSampai ?? ($publikasi ? now()->addMonths(3) : null),
        ]);

        AcaraUndangan::create([
            'undangan_id' => $undangan->id,
            'nama_acara' => 'Akad Nikah',
            'tanggal_acara' => now()->addDays(15)->toDateString(),
            'waktu_mulai' => '08:00:00',
            'waktu_selesai' => '10:00:00',
            'zona_waktu' => 'WIB',
            'nama_tempat' => 'Masjid Agung Al-Azhar',
            'alamat_lengkap' => 'Jakarta Selatan',
            'link_maps' => 'https://maps.google.com/?q=Jakarta',
        ]);

        GaleriUndangan::create([
            'undangan_id' => $undangan->id,
            'lokasi_foto' => 'aset-demo/galeri-1.webp',
            'keterangan' => 'Foto Prewedding',
            'urutan' => 1,
        ]);

        AmplopDigital::create([
            'undangan_id' => $undangan->id,
            'nama_bank' => 'BCA',
            'nomor_rekening' => '1234567890',
            'atas_nama' => 'Dimas Pratama',
        ]);

        return $undangan;
    }

    public function test_halaman_undangan_publik_merender_opengraph_animasi_kalender_dan_amplop(): void
    {
        $this->buatUndanganLengkap('rustic-floral', 'dimas-rani', true);

        $response = $this->get('/dimas-rani?to=Bapak+Surya');

        $response->assertOk()
            ->assertSee('The Wedding of Dimas &amp; Rani', false)
            ->assertSee('Kepada Yth. Bapak Surya', false)
            ->assertSee('property="og:title"', false)
            ->assertSee('property="og:description"', false)
            ->assertSee('property="og:image"', false)
            ->assertSee('Buka Undangan')
            ->assertSee('goyangAngin')
            ->assertSee('putarKaset')
            ->assertSee('data-aos')
            ->assertSee('calendar.google.com/calendar/render?action=TEMPLATE', false)
            ->assertSee('1234567890')
            ->assertSee('Berhasil Disalin!')
            ->assertDontSee('MODE PRATINJAU SESITEMU.ID');
    }

    public function test_ketiga_tema_dapat_dirender_untuk_undangan_publik(): void
    {
        $this->buatUndanganLengkap('rustic-floral', 'pasangan-rustic', true);
        $this->buatUndanganLengkap('adat-jawa', 'pasangan-jawa', true);
        $this->buatUndanganLengkap('islami-syari', 'pasangan-islami', true);

        $this->get('/pasangan-rustic')->assertOk()->assertSee('Dimas')->assertSee('Rani');
        $this->get('/pasangan-jawa')->assertOk()->assertSee('Dimas')->assertSee('Rani');
        $this->get('/pasangan-islami')->assertOk()->assertSee('Dimas')->assertSee('Rani');
    }

    public function test_semua_tema_baru_tipografi_custom_dan_mode_tanpa_foto_merender_sempurna(): void
    {
        $this->buatUndanganLengkap('editorial-monokrom', 'pasangan-editorial', true);
        $this->buatUndanganLengkap('luxury-noir', 'pasangan-luxury', true);
        $this->buatUndanganLengkap('royal-ivory', 'pasangan-royal', true);
        $this->buatUndanganLengkap('velvet-garden', 'pasangan-velvet', true);
        $this->buatUndanganLengkap('sunda-heritage', 'pasangan-sunda', true);
        $this->buatUndanganLengkap('islamic-heavenly', 'pasangan-heavenly', true);

        $this->get('/pasangan-editorial')->assertOk()->assertSee('Gilda+Display', false)->assertSee('The Wedding Edition');
        $this->get('/pasangan-luxury')->assertOk()->assertSee('Cinzel', false)->assertSee('The Grand Celebration');
        $this->get('/pasangan-royal')->assertOk()->assertSee('Playfair+Display', false)->assertSee('The Royal Wedding');
        $this->get('/pasangan-velvet')->assertOk()->assertSee('Velvet Garden Motion')->assertSee('animasi-melayang');
        $this->get('/pasangan-sunda')->assertOk()->assertSee('Sampurasun')->assertSee('Wilujeng Sumping');
        $this->get('/pasangan-heavenly')->assertOk()->assertSee('Amiri', false)->assertSee('Celestial Night');

        $undanganPrivasi = Undangan::where('slug', 'pasangan-royal')->firstOrFail();
        $pengaturan = $undanganPrivasi->pengaturan ?? [];
        $pengaturan['tanpa_foto'] = true;
        $pengaturan['gaya_font'] = 'editorial_gilda';
        $undanganPrivasi->update(['pengaturan' => $pengaturan]);

        $this->get('/pasangan-royal')
            ->assertOk()
            ->assertSee('Gilda+Display', false)
            ->assertDontSee('mempelai-pria.webp')
            ->assertDontSee('galeri-1.webp');
    }

    public function test_undangan_draft_hanya_bisa_dipratinjau_pemilik_atau_admin_dan_rsvp_dikunci(): void
    {
        $draft = $this->buatUndanganLengkap('rustic-floral', 'undangan-draft', false);
        $this->buatUndanganLengkap('rustic-floral', 'undangan-habis', true, now()->subDay());
        $orangLain = Pengguna::factory()->create();
        $admin = Pengguna::factory()->admin()->create();

        // Pengunjung umum & client lain melihat halaman "Undangan Belum Diaktifkan"
        $this->get('/undangan-draft')
            ->assertOk()
            ->assertSee('Undangan Belum Diaktifkan')
            ->assertDontSee('Buka Undangan')
            ->assertDontSee('Kirim Konfirmasi &amp; Doa', false);

        $this->actingAs($orangLain)
            ->get('/undangan-draft')
            ->assertOk()
            ->assertSee('Undangan Belum Diaktifkan')
            ->assertDontSee('MODE PRATINJAU SESITEMU.ID');

        // Pemilik undangan & Admin yang login boleh membuka Pratinjau (dengan RSVP terkunci)
        $this->actingAs($draft->pengguna)
            ->get('/undangan-draft')
            ->assertOk()
            ->assertSee('MODE PRATINJAU SESITEMU.ID — UNDANGAN BELUM AKTIF')
            ->assertSee('Mode Pratinjau — Buku Tamu &amp; RSVP Dikunci', false)
            ->assertDontSee('Kirim Konfirmasi &amp; Doa', false);

        $this->actingAs($admin)
            ->get('/undangan-draft')
            ->assertOk()
            ->assertSee('MODE PRATINJAU SESITEMU.ID — UNDANGAN BELUM AKTIF');

        // Pengiriman RSVP/ucapan ke undangan draft ditolak 403 di backend
        $this->post('/undangan-draft/buku-tamu', [
            'nama_tamu' => 'Tamu Ilegal',
            'status_kehadiran' => 'hadir',
            'jumlah_tamu' => 1,
            'ucapan_doa' => 'Coba kirim saat masih draft',
        ])->assertStatus(403);

        $this->assertDatabaseMissing('buku_tamu', [
            'undangan_id' => $draft->id,
            'nama_tamu' => 'Tamu Ilegal',
        ]);

        // Undangan kedaluwarsa menampilkan halaman kedaluwarsa
        auth()->logout();
        $this->get('/undangan-habis')
            ->assertOk()
            ->assertSee('Masa Aktif Undangan Telah Berakhir');

        $this->get('/slug-yang-tidak-pernah-ada')->assertNotFound();
    }

    public function test_simpan_ucapan_buku_tamu_dan_proteksi_anti_spam_throttle(): void
    {
        $undangan = $this->buatUndanganLengkap('rustic-floral', 'dimas-rani', true);

        for ($i = 1; $i <= 5; $i++) {
            $this->post('/dimas-rani/buku-tamu', [
                'nama_tamu' => "Tamu {$i}",
                'status_kehadiran' => 'hadir',
                'jumlah_tamu' => 2,
                'ucapan_doa' => "Selamat menempuh hidup baru ke-{$i}!",
            ])->assertRedirect();
        }

        $this->assertDatabaseHas('buku_tamu', [
            'undangan_id' => $undangan->id,
            'nama_tamu' => 'Tamu 1',
            'status_kehadiran' => 'hadir',
            'jumlah_tamu' => 2,
        ]);

        // Permintaan ke-6 dalam 1 menit diblokir throttle:5,1
        $this->post('/dimas-rani/buku-tamu', [
            'nama_tamu' => 'Tamu Spam',
            'status_kehadiran' => 'hadir',
            'jumlah_tamu' => 1,
            'ucapan_doa' => 'Spam',
        ])->assertStatus(429);
    }
}
