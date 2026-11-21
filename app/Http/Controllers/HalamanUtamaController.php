<?php

namespace App\Http\Controllers;

use App\Models\AcaraUndangan;
use App\Models\AmplopDigital;
use App\Models\BukuTamu;
use App\Models\GaleriUndangan;
use App\Models\Tema;
use App\Models\Undangan;
use App\Support\KatalogKontenDemo;
use App\Support\PengaturanSesiTemu;
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

        $ringkasanTier = Tema::ringkasanTier($daftarTema);

        $hargaTermurah = $daftarTema->min(fn (Tema $tema): int => $tema->hargaNominal())
            ?? Tema::HARGA_BAWAAN_TIER['basic'];
        $hargaTermahal = $daftarTema->max(fn (Tema $tema): int => $tema->hargaNominal())
            ?? Tema::HARGA_BAWAAN_TIER['eksklusif'];

        return view('beranda', [
            'daftarTema' => $daftarTema,
            'ringkasanTier' => $ringkasanTier,
            'hargaTermurah' => $hargaTermurah,
            'hargaTermahal' => $hargaTermahal,
            'biayaTerimaBeres' => PengaturanSesiTemu::biayaTerimaBeres(),
            'durasiAktifBulan' => PengaturanSesiTemu::masaAktifBulan(),
            'urlWaTerimaBeres' => PengaturanSesiTemu::urlWaAdmin('Halo Admin SesiTemu, saya tertarik memesan Paket Terima Beres untuk undangan pernikahan digital.'),
            'urlWaKonsultasi' => PengaturanSesiTemu::urlWaAdmin('Halo SesiTemu, saya ingin konsultasi mengenai undangan pernikahan digital.'),
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

        if ($request->user()) {
            return redirect()
                ->route('dashboard.index', ['buat' => 1, 'slug' => $slug])
                ->with('sukses', "Kabar baik! Link sesitemu.id/{$slug} masih tersedia. Lengkapi draft undangan Anda di bawah ini.");
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

        $tanpaFoto = $request->boolean('tf');
        $gayaFont = (string) $request->query('font', 'bawaan');
        if (! array_key_exists($gayaFont, Undangan::GAYA_FONT_TERSEDIA)) {
            $gayaFont = 'bawaan';
        }

        $undangan = $this->buatUndanganDemoInMemory($tema, $tanpaFoto, $gayaFont);

        return view($tema->lokasi_view, [
            'undangan' => $undangan,
            'namaTamu' => $namaTamu,
            'modeDemo' => true,
            'modePratinjau' => false,
        ]);
    }

    public function kebijakanPrivasi(): View
    {
        $durasiBulan = PengaturanSesiTemu::masaAktifBulan();

        return view('halaman-legal', [
            'halamanAktif' => 'privasi',
            'judulTab' => 'Kebijakan Privasi — SesiTemu',
            'labelBadge' => 'Perlindungan Data',
            'judul' => 'Kebijakan Privasi',
            'subjudul' => 'Komitmen SesiTemu dalam menjaga kerahasiaan data akun, informasi mempelai, media undangan, dan ucapan tamu Anda.',
            'urlWaAdmin' => PengaturanSesiTemu::urlWaAdmin('Halo Admin SesiTemu, saya ingin menanyakan mengenai Kebijakan Privasi.'),
            'pasal' => [
                [
                    'judul' => '1. Data yang Kami Kumpulkan',
                    'isi' => [
                        'Saat Anda mendaftar dan menyusun undangan di SesiTemu, kami mengumpulkan data akun (nama lengkap, alamat email, nomor WhatsApp, dan kata sandi terenkripsi) serta konten undangan yang Anda masukkan secara sukarela seperti nama mempelai, nama orang tua, jadwal dan lokasi acara, cerita cinta, nomor rekening amplop digital, alamat pengiriman kado, serta foto galeri.',
                        'Ketika tamu mengisi formulir Buku Tamu & RSVP pada undangan aktif, sistem menyimpan nama tamu, status kehadiran, jumlah tamu, serta pesan doa restu untuk ditampilkan pada undangan dan dashboard pemilik undangan.',
                    ],
                ],
                [
                    'judul' => '2. Penggunaan Informasi',
                    'isi' => [
                        'Data Anda digunakan semata-mata untuk menampilkan halaman undangan digital pada link pilihan Anda, menyediakan dashboard pengelolaan undangan, memproses verifikasi pembayaran aktivasi, serta memberikan dukungan layanan melalui WhatsApp Admin.',
                        'Kami tidak pernah menjual, menyewakan, atau membagikan data pribadi Anda kepada pihak ketiga untuk keperluan pemasaran di luar layanan SesiTemu.',
                    ],
                ],
                [
                    'judul' => '3. Privasi Foto & Mode Tanpa Foto (TF)',
                    'isi' => [
                        'Seluruh foto yang diunggah dioptimalkan otomatis ke format WebP agar ringan diakses tamu. Anda memegang kendali penuh atas foto yang ingin ditampilkan atau dihapus kapan saja melalui dashboard.',
                        'Bagi pasangan yang mengutamakan privasi atau konsep syar\'i, SesiTemu menyediakan Mode Tanpa Foto (TF / Monogram) yang menyembunyikan foto sampul, potret mempelai, dan galeri dari tampilan publik undangan.',
                    ],
                ],
                [
                    'judul' => '4. Masa Penyimpanan & Hak Pengguna',
                    'isi' => [
                        "Undangan yang telah diaktifkan dapat diakses publik selama masa aktif {$durasiBulan} bulan penuh sejak tanggal verifikasi. Setelah masa aktif berakhir, tautan publik tidak lagi ditampilkan kepada tamu.",
                        'Anda berhak memperbarui data profil, menghapus ucapan tamu tertentu, mengubah isi undangan, atau menghubungi Admin SesiTemu melalui WhatsApp apabila ingin mengajukan penghapusan akun beserta seluruh berkas undangan secara permanen.',
                    ],
                ],
            ],
        ]);
    }

    public function syaratKetentuan(): View
    {
        $durasiBulan = PengaturanSesiTemu::masaAktifBulan();
        $biayaTerimaBeres = Tema::formatRupiah(PengaturanSesiTemu::biayaTerimaBeres());

        return view('halaman-legal', [
            'halamanAktif' => 'syarat',
            'judulTab' => 'Syarat & Ketentuan — SesiTemu',
            'labelBadge' => 'Ketentuan Layanan',
            'judul' => 'Syarat & Ketentuan',
            'subjudul' => 'Ketentuan penggunaan platform, paket aktivasi, masa aktif undangan, dan tanggung jawab konten di SesiTemu.',
            'urlWaAdmin' => PengaturanSesiTemu::urlWaAdmin('Halo Admin SesiTemu, saya ingin menanyakan mengenai Syarat & Ketentuan layanan.'),
            'pasal' => [
                [
                    'judul' => '1. Pendaftaran Akun & Draft Gratis',
                    'isi' => [
                        'Pengguna dapat membuat akun, mengecek ketersediaan link pasangan, mengisi data undangan, dan melihat pratinjau desain secara gratis sebelum melakukan pembayaran aktivasi.',
                        'Anda bertanggung jawab menjaga kerahasiaan email dan kata sandi akun Anda serta memastikan seluruh informasi yang didaftarkan adalah benar dan sah.',
                    ],
                ],
                [
                    'judul' => '2. Pilihan Paket, Pembayaran & Aktivasi',
                    'isi' => [
                        "SesiTemu menyediakan Paket Mandiri (harga mengikuti tema Basic, Premium, atau Eksklusif yang dipilih) serta Paket Terima Beres (harga tema ditambah jasa input penuh Admin sebesar {$biayaTerimaBeres}).",
                        'Aktivasi undangan diproses setelah bukti transfer pembayaran diverifikasi oleh Admin. Kode promo atau diskon tema yang berlaku akan dihitung otomatis pada halaman aktivasi sebelum pembayaran dilakukan.',
                        'Pembayaran untuk undangan yang sudah diverifikasi dan aktif bersifat final (tidak dapat dikembalikan), kecuali terjadi kendala teknis permanen dari sisi platform yang tidak dapat diselesaikan.',
                    ],
                ],
                [
                    'judul' => '3. Masa Aktif & Perubahan Tema',
                    'isi' => [
                        "Setiap undangan yang telah diverifikasi memiliki masa aktif selama {$durasiBulan} bulan penuh sejak aktivasi, lengkap dengan akses editor untuk revisi teks, jadwal acara, galeri foto, dan pengelolaan daftar tamu tanpa batas.",
                        'Anda bebas berganti ke tema lain yang setara maupun melakukan peningkatan tier kapan saja melalui Dashboard Client tanpa kehilangan data undangan yang sudah diisi.',
                    ],
                ],
                [
                    'judul' => '4. Ketentuan Konten & Penggunaan Wajar',
                    'isi' => [
                        'Pengguna bertanggung jawab penuh atas legalitas, keakuratan, dan kepatutan seluruh teks, foto, tautan peta, nomor rekening, dan media yang diunggah pada halaman undangan.',
                        'SesiTemu berhak menonaktifkan undangan apabila ditemukan penyalahgunaan layanan, konten yang melanggar hukum, atau aktivitas yang mengganggu stabilitas sistem.',
                    ],
                ],
            ],
        ]);
    }

    private function buatUndanganDemoInMemory(
        Tema $tema,
        bool $tanpaFoto = false,
        string $gayaFont = 'bawaan'
    ): Undangan {
        $dataDemo = KatalogKontenDemo::untukTema($tema);

        $undangan = new Undangan([
            'tema_id' => $tema->id,
            'slug' => 'demo-'.$tema->slug,
            'nama_panggilan_pria' => $dataDemo['pria']['panggilan'],
            'nama_lengkap_pria' => $dataDemo['pria']['lengkap'],
            'nama_ayah_pria' => $dataDemo['pria']['ayah'],
            'nama_ibu_pria' => $dataDemo['pria']['ibu'],
            'foto_pria' => $tanpaFoto ? null : 'aset-demo/mempelai-pria.webp',
            'nama_panggilan_wanita' => $dataDemo['wanita']['panggilan'],
            'nama_lengkap_wanita' => $dataDemo['wanita']['lengkap'],
            'nama_ayah_wanita' => $dataDemo['wanita']['ayah'],
            'nama_ibu_wanita' => $dataDemo['wanita']['ibu'],
            'foto_wanita' => $tanpaFoto ? null : 'aset-demo/mempelai-wanita.webp',
            'kutipan_ayat' => $dataDemo['kutipan_ayat'],
            'musik_latar' => $dataDemo['musik_latar'],
            'pengaturan' => [
                'gaya_font' => $gayaFont,
                'tanpa_foto' => $tanpaFoto,
                'foto_sampul' => $tanpaFoto ? null : $dataDemo['foto_sampul'],
                'foto_pembuka' => $tanpaFoto ? null : ($dataDemo['foto_pembuka'] ?? null),
                'foto_penutup' => $tanpaFoto ? null : ($dataDemo['foto_penutup'] ?? null),
                'foto_latar_tema' => null,
                'hashtag' => $dataDemo['hashtag'] ?? '',
                'sosial_media' => $dataDemo['sosial_media'] ?? [
                    'instagram_pria' => '',
                    'instagram_wanita' => '',
                ],
                'dress_code' => $dataDemo['dress_code'] ?? [
                    'catatan' => '',
                    'warna' => [],
                ],
                'turut_mengundang' => $dataDemo['turut_mengundang'] ?? [
                    'pihak_wanita' => '',
                    'pihak_pria' => '',
                ],
                'cerita_cinta' => $dataDemo['cerita_cinta'],
                'live_streaming' => $dataDemo['live_streaming'],
                'alamat_kado_fisik' => $dataDemo['alamat_kado_fisik'],
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

        $tanggalAcara = now()->addDays((int) ($dataDemo['hari_lagi'] ?? 21))->toDateString();

        $undangan->setRelation('daftarAcara', collect($dataDemo['acara'])->map(
            fn (array $acara) => new AcaraUndangan([
                'nama_acara' => $acara['nama_acara'],
                'tanggal_acara' => $tanggalAcara,
                'waktu_mulai' => $acara['waktu_mulai'],
                'waktu_selesai' => $acara['waktu_selesai'],
                'zona_waktu' => $acara['zona_waktu'],
                'nama_tempat' => $acara['nama_tempat'],
                'alamat_lengkap' => $acara['alamat_lengkap'],
                'link_maps' => $acara['link_maps'],
            ])
        ));

        $undangan->setRelation(
            'daftarGaleri',
            $tanpaFoto
                ? collect()
                : collect($dataDemo['galeri'])->values()->map(
                    fn (array $foto, int $idx) => new GaleriUndangan([
                        'lokasi_foto' => $foto['lokasi_foto'],
                        'keterangan' => $foto['keterangan'],
                        'urutan' => $idx + 1,
                    ])
                )
        );

        $undangan->setRelation('daftarAmplop', collect($dataDemo['amplop'])->map(
            fn (array $amplop) => new AmplopDigital([
                'nama_bank' => $amplop['nama_bank'],
                'nomor_rekening' => $amplop['nomor_rekening'],
                'atas_nama' => $amplop['atas_nama'],
            ])
        ));

        $undangan->setRelation('bukuTamu', collect($dataDemo['ucapan'])->values()->map(function (array $ucapan, int $idx) {
            $item = new BukuTamu([
                'nama_tamu' => $ucapan['nama_tamu'],
                'status_kehadiran' => $ucapan['status_kehadiran'],
                'jumlah_tamu' => $ucapan['jumlah_tamu'],
                'ucapan_doa' => $ucapan['ucapan_doa'],
            ]);
            $item->created_at = now()->subHours(5 - ($idx * 2));

            return $item;
        }));

        return $undangan;
    }
}
