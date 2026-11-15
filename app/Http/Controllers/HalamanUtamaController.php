<?php

namespace App\Http\Controllers;

use App\Models\AcaraUndangan;
use App\Models\AmplopDigital;
use App\Models\BukuTamu;
use App\Models\GaleriUndangan;
use App\Models\Tema;
use App\Models\Undangan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HalamanUtamaController extends Controller
{
    public function beranda(): View
    {
        $daftarTema = Tema::where('aktif', true)
            ->orderBy('id')
            ->get();

        return view('beranda', [
            'daftarTema' => $daftarTema,
        ]);
    }

    public function cekLink(Request $request): RedirectResponse
    {
        $tervalidasi = $request->validate([
            'slug' => ['required', 'string', 'max:100'],
        ], [
            'slug.required' => 'Silakan ketik nama pasangan untuk mengecek ketersediaan link.',
        ]);

        $slug = Str::slug($tervalidasi['slug']);

        if ($slug === '') {
            return back()
                ->withErrors(['slug' => 'Format link hanya dapat berisi huruf, angka, dan tanda hubung.'])
                ->withInput();
        }

        if (Undangan::where('slug', $slug)->exists()) {
            $saranSlug = $slug.'-'.now()->format('Y');

            return redirect()->route('beranda')
                ->withInput(['slug' => $slug])
                ->with('saran_link', "Maaf, link sesitemu.id/{$slug} sudah digunakan. Coba alternatif seperti {$saranSlug} atau {$slug}-official.");
        }

        return redirect()
            ->route('daftar', ['slug' => $slug])
            ->with('sukses', "Kabar baik! Link sesitemu.id/{$slug} masih tersedia. Lengkapi pendaftaran untuk mengamankannya.");
    }

    public function demoTema(string $slugTema, Request $request): View
    {
        $tema = Tema::where('slug', $slugTema)
            ->where('aktif', true)
            ->firstOrFail();

        $namaTamu = trim((string) $request->query('to', ''));
        if ($namaTamu === '') {
            $namaTamu = 'Budi Santoso & Partner';
        }

        $undangan = $this->buatUndanganDemoInMemory($tema);

        return view($tema->lokasi_view, [
            'undangan' => $undangan,
            'namaTamu' => $namaTamu,
            'modeDemo' => true,
            'modePratinjau' => false,
        ]);
    }

    private function buatUndanganDemoInMemory(Tema $tema): Undangan
    {
        $musikBawaan = match ($tema->slug) {
            'adat-jawa' => 'musik/gamelan-lembut.mp3',
            'islami-syari' => 'musik/instrumen-islami.mp3',
            default => 'musik/romantis-akustik.mp3',
        };

        $undangan = new Undangan([
            'tema_id' => $tema->id,
            'slug' => 'demo-'.$tema->slug,
            'nama_panggilan_pria' => 'Dimas',
            'nama_lengkap_pria' => 'Dimas Pratama Putra, S.Kom.',
            'nama_ayah_pria' => 'Bpk. Hendra Wijaya',
            'nama_ibu_pria' => 'Ibu Ratna Sari',
            'foto_pria' => 'aset-demo/mempelai-pria.webp',
            'nama_panggilan_wanita' => 'Rani',
            'nama_lengkap_wanita' => 'Rani Kusuma Wardhani, S.E.',
            'nama_ayah_wanita' => 'Bpk. Bambang Sutrisno',
            'nama_ibu_wanita' => 'Ibu Sri Wahyuni',
            'foto_wanita' => 'aset-demo/mempelai-wanita.webp',
            'kutipan_ayat' => 'Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu pasangan hidup dari jenismu sendiri, supaya kamu merasa tenteram di sampingnya. (QS. Ar-Rum: 21)',
            'musik_latar' => $musikBawaan,
            'pengaturan' => [
                'cerita_cinta' => [
                    [
                        'judul' => 'Pertama Bertemu',
                        'tanggal' => '2023',
                        'cerita' => 'Kami dipertemukan dalam sebuah pertemuan yang hangat di Jakarta Selatan dan mulai merangkai cerita masa depan.',
                    ],
                    [
                        'judul' => 'Lamaran',
                        'tanggal' => '2026',
                        'cerita' => 'Dengan doa dan restu kedua keluarga besar, kami memantapkan hati untuk melangkah menuju hari pertemuan.',
                    ],
                ],
                'live_streaming' => [
                    'aktif' => true,
                    'platform' => 'YouTube Live',
                    'link' => 'https://youtube.com',
                ],
                'alamat_kado_fisik' => 'Jl. Kemang Raya No. 45, Jakarta Selatan 12730',
                'fitur_aktif' => [
                    'hitung_mundur' => true,
                    'cerita_cinta' => true,
                    'galeri' => true,
                    'amplop_digital' => true,
                    'buku_tamu' => true,
                ],
            ],
            'status_publikasi' => true,
            'berlaku_sampai' => now()->addMonths(3),
        ]);

        $undangan->setRelation('tema', $tema);

        $tanggalAcara = now()->addDays(21)->toDateString();

        $undangan->setRelation('daftarAcara', collect([
            new AcaraUndangan([
                'nama_acara' => 'Akad Nikah',
                'tanggal_acara' => $tanggalAcara,
                'waktu_mulai' => '08:00:00',
                'waktu_selesai' => '10:00:00',
                'zona_waktu' => 'WIB',
                'nama_tempat' => 'Masjid Agung Al-Azhar',
                'alamat_lengkap' => 'Jl. Sisingamangaraja, Kebayoran Baru, Jakarta Selatan',
                'link_maps' => 'https://maps.google.com/?q=Masjid+Agung+Al-Azhar+Jakarta',
            ]),
            new AcaraUndangan([
                'nama_acara' => 'Resepsi Pernikahan',
                'tanggal_acara' => $tanggalAcara,
                'waktu_mulai' => '11:00:00',
                'waktu_selesai' => '14:00:00',
                'zona_waktu' => 'WIB',
                'nama_tempat' => 'Aula Buya Hamka Al-Azhar',
                'alamat_lengkap' => 'Jl. Sisingamangaraja, Kebayoran Baru, Jakarta Selatan',
                'link_maps' => 'https://maps.google.com/?q=Aula+Buya+Hamka+Al-Azhar+Jakarta',
            ]),
        ]));

        $undangan->setRelation('daftarGaleri', collect([
            new GaleriUndangan(['lokasi_foto' => 'aset-demo/galeri-1.webp', 'keterangan' => 'Sesi Prewedding Outdoor', 'urutan' => 1]),
            new GaleriUndangan(['lokasi_foto' => 'aset-demo/galeri-2.webp', 'keterangan' => 'Momen Pertunangan', 'urutan' => 2]),
            new GaleriUndangan(['lokasi_foto' => 'aset-demo/galeri-3.webp', 'keterangan' => 'Menuju Hari Pertemuan', 'urutan' => 3]),
        ]));

        $undangan->setRelation('daftarAmplop', collect([
            new AmplopDigital(['nama_bank' => 'BCA', 'nomor_rekening' => '1234567890', 'atas_nama' => 'Dimas Pratama Putra']),
            new AmplopDigital(['nama_bank' => 'Mandiri', 'nomor_rekening' => '9876543210123', 'atas_nama' => 'Rani Kusuma Wardhani']),
        ]));

        $ucapan1 = new BukuTamu([
            'nama_tamu' => 'Budi Santoso',
            'status_kehadiran' => 'hadir',
            'jumlah_tamu' => 2,
            'ucapan_doa' => 'Selamat menempuh hidup baru Dimas & Rani! Semoga menjadi keluarga sakinah, mawaddah, warahmah.',
        ]);
        $ucapan1->created_at = now()->subHours(5);

        $ucapan2 = new BukuTamu([
            'nama_tamu' => 'Nadia Larasati',
            'status_kehadiran' => 'hadir',
            'jumlah_tamu' => 1,
            'ucapan_doa' => 'Bahagia selalu untuk kalian berdua. Sampai bertemu di hari bahagia!',
        ]);
        $ucapan2->created_at = now()->subHours(2);

        $undangan->setRelation('bukuTamu', collect([$ucapan1, $ucapan2]));

        return $undangan;
    }
}
