<?php

namespace Database\Seeders;

use App\Models\AcaraUndangan;
use App\Models\AmplopDigital;
use App\Models\BukuTamu;
use App\Models\GaleriUndangan;
use App\Models\Pengguna;
use App\Models\Tema;
use App\Models\Undangan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Pengguna::updateOrCreate(
            ['email' => 'admin@sesitemu.id'],
            [
                'nama' => 'Admin SesiTemu',
                'nomor_wa' => '6281234567890',
                'kata_sandi' => Hash::make('password'),
                'peran' => 'admin',
            ]
        );

        $client = Pengguna::updateOrCreate(
            ['email' => 'client@sesitemu.id'],
            [
                'nama' => 'Dimas & Rani',
                'nomor_wa' => '6281298765432',
                'kata_sandi' => Hash::make('password'),
                'peran' => 'client',
            ]
        );

        $daftarTema = [
            [
                'nama_tema' => 'Rustic Floral',
                'slug' => 'rustic-floral',
                'kategori' => 'floral',
                'tier' => 'basic',
                'harga' => 59000,
                'lokasi_view' => 'tema.rustic-floral.index',
                'gambar_pratinjau' => 'aset-demo/tema-rustic-floral.webp',
                'aktif' => true,
            ],
            [
                'nama_tema' => 'Editorial Monokrom',
                'slug' => 'editorial-monokrom',
                'kategori' => 'modern',
                'tier' => 'premium',
                'harga' => 79000,
                'lokasi_view' => 'tema.editorial-monokrom.index',
                'gambar_pratinjau' => 'aset-demo/tema-editorial-monokrom.webp',
                'aktif' => true,
            ],
            [
                'nama_tema' => 'Luxury Noir Monogram',
                'slug' => 'luxury-noir',
                'kategori' => 'elegan',
                'tier' => 'eksklusif',
                'harga' => 119000,
                'lokasi_view' => 'tema.luxury-noir.index',
                'gambar_pratinjau' => 'aset-demo/tema-luxury-noir.webp',
                'aktif' => true,
            ],
            [
                'nama_tema' => 'Luxury Royal Ivory',
                'slug' => 'royal-ivory',
                'kategori' => 'elegan',
                'tier' => 'premium',
                'harga' => 99000,
                'lokasi_view' => 'tema.royal-ivory.index',
                'gambar_pratinjau' => 'aset-demo/tema-royal-ivory.webp',
                'aktif' => true,
            ],
            [
                'nama_tema' => 'Velvet Garden Motion',
                'slug' => 'velvet-garden',
                'kategori' => 'floral',
                'tier' => 'eksklusif',
                'harga' => 129000,
                'lokasi_view' => 'tema.velvet-garden.index',
                'gambar_pratinjau' => 'aset-demo/tema-velvet-garden.webp',
                'aktif' => true,
            ],
            [
                'nama_tema' => 'Adat Jawa Keraton',
                'slug' => 'adat-jawa',
                'kategori' => 'adat',
                'tier' => 'premium',
                'harga' => 89000,
                'lokasi_view' => 'tema.adat-jawa.index',
                'gambar_pratinjau' => 'aset-demo/tema-adat-jawa.webp',
                'aktif' => true,
            ],
            [
                'nama_tema' => 'Sunda Siger Heritage',
                'slug' => 'sunda-heritage',
                'kategori' => 'adat',
                'tier' => 'premium',
                'harga' => 89000,
                'lokasi_view' => 'tema.sunda-heritage.index',
                'gambar_pratinjau' => 'aset-demo/tema-sunda-heritage.webp',
                'aktif' => true,
            ],
            [
                'nama_tema' => 'Islami Syari',
                'slug' => 'islami-syari',
                'kategori' => 'islami',
                'tier' => 'basic',
                'harga' => 59000,
                'lokasi_view' => 'tema.islami-syari.index',
                'gambar_pratinjau' => 'aset-demo/tema-islami-syari.webp',
                'aktif' => true,
            ],
            [
                'nama_tema' => 'Islamic Heavenly Motion',
                'slug' => 'islamic-heavenly',
                'kategori' => 'islami',
                'tier' => 'eksklusif',
                'harga' => 129000,
                'lokasi_view' => 'tema.islamic-heavenly.index',
                'gambar_pratinjau' => 'aset-demo/tema-islamic-heavenly.webp',
                'aktif' => true,
            ],
        ];

        $temaUtama = null;

        foreach ($daftarTema as $dataTema) {
            $tema = Tema::updateOrCreate(
                ['slug' => $dataTema['slug']],
                $dataTema
            );

            if ($tema->slug === 'rustic-floral') {
                $temaUtama = $tema;
            }
        }

        foreach (Tema::katalogMusikBawaan() as $musikItem) {
            \App\Models\MusikLatar::updateOrCreate(
                ['path_file' => $musikItem['path_file']],
                [
                    'judul' => $musikItem['judul'],
                    'artis' => $musikItem['artis'],
                    'kategori' => $musikItem['kategori'],
                    'aktif' => true,
                    'urutan' => $musikItem['urutan'],
                ]
            );
        }

        if ($temaUtama === null) {
            return;
        }

        $undanganContoh = Undangan::updateOrCreate(
            ['slug' => 'dimas-rani'],
            [
                'pengguna_id' => $client->id,
                'tema_id' => $temaUtama->id,
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
                'kutipan_ayat' => 'Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu isteri-isteri dari jenismu sendiri, supaya kamu cenderung dan merasa tenteram kepadanya, dan dijadikan-Nya di antaramu rasa kasih dan sayang. (QS. Ar-Rum: 21)',
                'musik_latar' => 'musik/penjaga-hati.mp3',
                'pengaturan' => [
                    'cerita_cinta' => [
                        [
                            'judul' => 'Pertama Bertemu',
                            'tanggal' => '2023',
                            'cerita' => 'Kami dipertemukan dalam sebuah proyek kolaborasi di Jakarta Selatan dan mulai berbagi cerita tentang masa depan.',
                        ],
                        [
                            'judul' => 'Lamaran',
                            'tanggal' => '2026',
                            'cerita' => 'Dengan restu kedua orang tua, kami mengikat janji untuk melangkah menuju pernikahan yang penuh berkah.',
                        ],
                    ],
                    'live_streaming' => [
                        'aktif' => true,
                        'platform' => 'YouTube Live',
                        'link' => 'https://youtube.com',
                    ],
                    'alamat_kado_fisik' => 'Jl. Kemang Raya No. 45, Jakarta Selatan 12730 (Penerima: Dimas / Rani)',
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
            ]
        );

        if ($undanganContoh->daftarAcara()->count() === 0) {
            AcaraUndangan::create([
                'undangan_id' => $undanganContoh->id,
                'nama_acara' => 'Akad Nikah',
                'tanggal_acara' => now()->addDays(30)->toDateString(),
                'waktu_mulai' => '08:00:00',
                'waktu_selesai' => '10:00:00',
                'zona_waktu' => 'WIB',
                'nama_tempat' => 'Masjid Agung Al-Azhar',
                'alamat_lengkap' => 'Jl. Sisingamangaraja, Kebayoran Baru, Jakarta Selatan',
                'link_maps' => 'https://maps.google.com/?q=Masjid+Agung+Al-Azhar+Jakarta',
            ]);

            AcaraUndangan::create([
                'undangan_id' => $undanganContoh->id,
                'nama_acara' => 'Resepsi Pernikahan',
                'tanggal_acara' => now()->addDays(30)->toDateString(),
                'waktu_mulai' => '11:00:00',
                'waktu_selesai' => '14:00:00',
                'zona_waktu' => 'WIB',
                'nama_tempat' => 'Aula Buya Hamka Al-Azhar',
                'alamat_lengkap' => 'Jl. Sisingamangaraja, Kebayoran Baru, Jakarta Selatan',
                'link_maps' => 'https://maps.google.com/?q=Aula+Buya+Hamka+Al-Azhar+Jakarta',
            ]);
        }

        if ($undanganContoh->daftarGaleri()->count() === 0) {
            $galeriContoh = [
                ['lokasi_foto' => 'aset-demo/galeri-1.webp', 'keterangan' => 'Sesi Prewedding Outdoor', 'urutan' => 1],
                ['lokasi_foto' => 'aset-demo/galeri-2.webp', 'keterangan' => 'Momen Pertunangan', 'urutan' => 2],
                ['lokasi_foto' => 'aset-demo/galeri-3.webp', 'keterangan' => 'Menuju Hari Pertemuan', 'urutan' => 3],
            ];

            foreach ($galeriContoh as $itemGaleri) {
                GaleriUndangan::create([
                    'undangan_id' => $undanganContoh->id,
                    ...$itemGaleri,
                ]);
            }
        }

        if ($undanganContoh->daftarAmplop()->count() === 0) {
            AmplopDigital::create([
                'undangan_id' => $undanganContoh->id,
                'nama_bank' => 'BCA',
                'nomor_rekening' => '1234567890',
                'atas_nama' => 'Dimas Pratama Putra',
            ]);

            AmplopDigital::create([
                'undangan_id' => $undanganContoh->id,
                'nama_bank' => 'Mandiri',
                'nomor_rekening' => '9876543210123',
                'atas_nama' => 'Rani Kusuma Wardhani',
            ]);
        }

        if ($undanganContoh->bukuTamu()->count() === 0) {
            BukuTamu::create([
                'undangan_id' => $undanganContoh->id,
                'nama_tamu' => 'Budi Santoso',
                'status_kehadiran' => 'hadir',
                'jumlah_tamu' => 2,
                'ucapan_doa' => 'Selamat menempuh hidup baru Dimas & Rani! Semoga menjadi keluarga sakinah, mawaddah, warahmah.',
            ]);

            BukuTamu::create([
                'undangan_id' => $undanganContoh->id,
                'nama_tamu' => 'Siti Aminah',
                'status_kehadiran' => 'hadir',
                'jumlah_tamu' => 1,
                'ucapan_doa' => 'Barakallahu lakuma wa baraka alaikuma. InsyaAllah hadir tepat waktu!',
            ]);
        }
    }
}
