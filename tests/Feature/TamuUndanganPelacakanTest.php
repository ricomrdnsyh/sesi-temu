<?php

namespace Tests\Feature;

use App\Models\Pengguna;
use App\Models\TamuUndangan;
use App\Models\Tema;
use App\Models\Undangan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TamuUndanganPelacakanTest extends TestCase
{
    use RefreshDatabase;

    private function buatUndangan(Pengguna $pemilik, bool $aktif = true): Undangan
    {
        $tema = Tema::create([
            'nama_tema' => 'Rustic Floral',
            'slug' => 'rustic-floral-'.uniqid(),
            'kategori' => 'modern',
            'lokasi_view' => 'tema.rustic-floral.index',
            'aktif' => true,
        ]);

        return Undangan::create([
            'pengguna_id' => $pemilik->id,
            'tema_id' => $tema->id,
            'slug' => 'uji-tamu-'.uniqid(),
            'nama_panggilan_pria' => 'Dimas',
            'nama_lengkap_pria' => 'Dimas Pratama',
            'nama_panggilan_wanita' => 'Jihan',
            'nama_lengkap_wanita' => 'Jihan Aulia',
            'status_publikasi' => $aktif,
            'berlaku_sampai' => $aktif ? now()->addMonths(3) : null,
        ]);
    }

    public function test_client_dapat_menambah_mengedit_menandai_kirim_dan_menghapus_tamu_undangan(): void
    {
        $pemilik = Pengguna::factory()->create();
        $clientLain = Pengguna::factory()->create();
        $undangan = $this->buatUndangan($pemilik, true);

        $urlHalamanTamu = route('dashboard.undangan.tamu', $undangan);

        // 1. Tambah satuan dengan nomor WA format lokal (08...) -> dinormalisasi ke 628...
        $this->actingAs($pemilik)
            ->post("/dashboard/undangan/{$undangan->id}/tamu", [
                'mode' => 'satuan',
                'nama_tamu' => 'Budi Santoso',
                'nomor_wa' => '0812-3456-7890',
            ])
            ->assertRedirect($urlHalamanTamu)
            ->assertSessionHas('sukses');

        $tamuBudi = TamuUndangan::where('undangan_id', $undangan->id)
            ->where('nama_tamu', 'Budi Santoso')
            ->firstOrFail();

        $this->assertSame('6281234567890', $tamuBudi->nomor_wa);
        $this->assertNotEmpty($tamuBudi->kode_tamu);
        $this->assertFalse($tamuBudi->sudahDikirim());
        $this->assertFalse($tamuBudi->sudahDibuka());

        // 2. Tambah satuan tanpa nomor WA tetap diperbolehkan
        $this->actingAs($pemilik)
            ->post("/dashboard/undangan/{$undangan->id}/tamu", [
                'mode' => 'satuan',
                'nama_tamu' => 'Keluarga Bpk. Hendra',
                'nomor_wa' => '',
            ])
            ->assertRedirect($urlHalamanTamu);

        $tamuHendra = TamuUndangan::where('undangan_id', $undangan->id)
            ->where('nama_tamu', 'Keluarga Bpk. Hendra')
            ->firstOrFail();
        $this->assertNull($tamuHendra->nomor_wa);

        // 3. Format nomor WA tidak valid ditolak dengan error
        $this->actingAs($pemilik)
            ->post("/dashboard/undangan/{$undangan->id}/tamu", [
                'mode' => 'satuan',
                'nama_tamu' => 'Nomor Salah',
                'nomor_wa' => '123',
            ])
            ->assertRedirect($urlHalamanTamu)
            ->assertSessionHasErrors('nomor_wa');

        // 4. Tambah massal (dengan dan tanpa nomor WA)
        $this->actingAs($pemilik)
            ->post("/dashboard/undangan/{$undangan->id}/tamu", [
                'mode' => 'massal',
                'daftar_bulk' => "Siti Aminah, 085612345678\nRina Putri | +62 813-9988-7766\nAndi Tanpa Nomor",
            ])
            ->assertRedirect($urlHalamanTamu);

        $this->assertDatabaseHas('tamu_undangan', [
            'undangan_id' => $undangan->id,
            'nama_tamu' => 'Siti Aminah',
            'nomor_wa' => '6285612345678',
        ]);
        $this->assertDatabaseHas('tamu_undangan', [
            'undangan_id' => $undangan->id,
            'nama_tamu' => 'Rina Putri',
            'nomor_wa' => '6281399887766',
        ]);
        $this->assertDatabaseHas('tamu_undangan', [
            'undangan_id' => $undangan->id,
            'nama_tamu' => 'Andi Tanpa Nomor',
            'nomor_wa' => null,
        ]);

        // 5. Edit inline via JSON (tambahkan nomor WA ke tamu yang sebelumnya kosong)
        $this->actingAs($pemilik)
            ->putJson("/dashboard/undangan/{$undangan->id}/tamu/{$tamuHendra->id}", [
                'nama_tamu' => 'Keluarga Besar Bpk. Hendra',
                'nomor_wa' => '082111223344',
            ])
            ->assertOk()
            ->assertJson([
                'ok' => true,
                'tamu' => [
                    'id' => $tamuHendra->id,
                    'nama_tamu' => 'Keluarga Besar Bpk. Hendra',
                    'nomor_wa' => '6282111223344',
                ],
            ]);

        // Edit inline dengan nomor WA tidak valid -> 422
        $this->actingAs($pemilik)
            ->putJson("/dashboard/undangan/{$undangan->id}/tamu/{$tamuHendra->id}", [
                'nama_tamu' => 'Keluarga Besar Bpk. Hendra',
                'nomor_wa' => 'abc',
            ])
            ->assertStatus(422)
            ->assertJson(['ok' => false]);

        // 6. Tandai sudah dikirim & reset ke belum dikirim via PATCH JSON
        $this->actingAs($pemilik)
            ->patchJson("/dashboard/undangan/{$undangan->id}/tamu/{$tamuBudi->id}/status-kirim", [
                'terkirim' => true,
            ])
            ->assertOk()
            ->assertJson([
                'ok' => true,
                'id' => $tamuBudi->id,
                'sudah_dikirim' => true,
            ]);

        $this->assertTrue($tamuBudi->fresh()->sudahDikirim());

        $this->actingAs($pemilik)
            ->patchJson("/dashboard/undangan/{$undangan->id}/tamu/{$tamuBudi->id}/status-kirim", [
                'terkirim' => false,
            ])
            ->assertOk()
            ->assertJson([
                'ok' => true,
                'sudah_dikirim' => false,
                'dikirim_pada_label' => null,
            ]);

        $this->assertFalse($tamuBudi->fresh()->sudahDikirim());

        // 7. Client lain dilarang mengubah/menghapus tamu milik orang lain
        $this->actingAs($clientLain)
            ->patchJson("/dashboard/undangan/{$undangan->id}/tamu/{$tamuBudi->id}/status-kirim", ['terkirim' => true])
            ->assertForbidden();

        $this->actingAs($clientLain)
            ->delete("/dashboard/undangan/{$undangan->id}/tamu/{$tamuBudi->id}")
            ->assertForbidden();

        // 8. Akses lama kelola?tab=tamu dan /dashboard/tamu diarahkan ke ruang kerja Tamu & RSVP undangan ini
        $this->actingAs($pemilik)
            ->get("/dashboard/undangan/{$undangan->id}/kelola?tab=tamu")
            ->assertRedirect($urlHalamanTamu);

        $this->actingAs($pemilik)
            ->get("/dashboard/tamu?undangan={$undangan->id}")
            ->assertRedirect($urlHalamanTamu);

        // Halaman ruang kerja Tamu & RSVP menampilkan menu Undangan + Tamu & RSVP serta data tamu tersimpan
        $this->actingAs($pemilik)
            ->get($urlHalamanTamu)
            ->assertOk()
            ->assertSee('data-workspace-menu="undangan"', false)
            ->assertSee('data-workspace-menu="tamu"', false)
            ->assertSee('Tamu &amp; RSVP', false)
            ->assertSee('Budi Santoso')
            ->assertSee('6281234567890')
            ->assertSee('Sudah Dibuka')
            ->assertSee('Belum Dikirim')
            ->assertSee('Import Banyak')
            ->assertSee('Tambah Tamu');

        // 9. Pemilik dapat menghapus tamu
        $this->actingAs($pemilik)
            ->delete("/dashboard/undangan/{$undangan->id}/tamu/{$tamuBudi->id}")
            ->assertRedirect($urlHalamanTamu);

        $this->assertDatabaseMissing('tamu_undangan', ['id' => $tamuBudi->id]);
    }

    public function test_pelacakan_status_buka_undangan_mencatat_kunjungan_nyata_dan_mengabaikan_bot_pratinjau(): void
    {
        $pemilik = Pengguna::factory()->create();
        $undangan = $this->buatUndangan($pemilik, false);

        $tamu = TamuUndangan::create([
            'undangan_id' => $undangan->id,
            'kode_tamu' => TamuUndangan::buatKodeUnik(),
            'nama_tamu' => 'Dewi Kartika',
            'nomor_wa' => '6281298765432',
        ]);

        // Saat undangan masih draft, pratinjau pemilik TIDAK boleh menandai tamu sudah membuka
        $this->actingAs($pemilik)
            ->get("/{$undangan->slug}?to=Dewi+Kartika&g={$tamu->kode_tamu}")
            ->assertOk();

        $tamu->refresh();
        $this->assertFalse($tamu->sudahDibuka());
        $this->assertSame(0, $tamu->jumlah_dibuka);

        // Aktifkan undangan
        $undangan->update([
            'status_publikasi' => true,
            'berlaku_sampai' => now()->addMonths(3),
        ]);

        // Kunjungan bot pratinjau WhatsApp / Facebook TIDAK boleh menandai sudah dibuka
        $this->withHeader('User-Agent', 'WhatsApp/2.23.20 A')
            ->get("/{$undangan->slug}?to=Dewi+Kartika&g={$tamu->kode_tamu}")
            ->assertOk();

        $this->withHeader('User-Agent', 'facebookexternalhit/1.1')
            ->get("/{$undangan->slug}?g={$tamu->kode_tamu}")
            ->assertOk();

        $tamu->refresh();
        $this->assertFalse($tamu->sudahDibuka());
        $this->assertSame(0, $tamu->jumlah_dibuka);

        // Kunjungan browser tamu nyata via kode unik (?g=...) tanpa ?to= -> nama tamu tampil & tercatat dibuka
        $this->withHeader('User-Agent', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15')
            ->get("/{$undangan->slug}?g={$tamu->kode_tamu}")
            ->assertOk()
            ->assertSee('Dewi Kartika');

        $tamu->refresh();
        $this->assertTrue($tamu->sudahDibuka());
        $this->assertNotNull($tamu->dibuka_pada);
        $this->assertNotNull($tamu->terakhir_dibuka_pada);
        $this->assertSame(1, $tamu->jumlah_dibuka);

        // Kunjungan kedua lewat fallback ?to= (tanpa ?g=) menaikkan jumlah_dibuka menjadi 2
        $this->withHeader('User-Agent', 'Mozilla/5.0 (Linux; Android 14) Chrome/120.0')
            ->get("/{$undangan->slug}?to=dewi+kartika")
            ->assertOk();

        $this->assertSame(2, $tamu->fresh()->jumlah_dibuka);
    }
}
