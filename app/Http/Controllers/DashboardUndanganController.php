<?php

namespace App\Http\Controllers;

use App\Models\AcaraUndangan;
use App\Models\AmplopDigital;
use App\Models\BukuTamu;
use App\Models\GaleriUndangan;
use App\Models\MusikLatar;
use App\Models\Pengguna;
use App\Models\TamuUndangan;
use App\Models\Tema;
use App\Models\Transaksi;
use App\Models\Undangan;
use App\Services\LayananTransaksiService;
use App\Services\PengolahGambarService;
use App\Support\MediaPublik;
use App\Support\PengaturanSesiTemu;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class DashboardUndanganController extends Controller
{
    /**
     * @var list<string>
     */
    private const SLUG_TERCADANG = [
        'masuk',
        'daftar',
        'keluar',
        'dashboard',
        'admin',
        'demo',
        'cek-link',
        'up',
    ];

    public function index(Request $request): View
    {
        $daftarUndangan = $request->user()
            ->undangan()
            ->with(['tema', 'bukuTamu', 'daftarTamu', 'daftarAcara', 'daftarGaleri', 'daftarAmplop', 'transaksi'])
            ->latest()
            ->get();

        $daftarTema = Tema::where('aktif', true)->orderBy('id')->get();

        return view('dashboard.undangan', [
            'daftarUndangan' => $daftarUndangan,
            'daftarTema' => $daftarTema,
            'durasiAktifBulan' => PengaturanSesiTemu::masaAktifBulan(),
        ]);
    }

    public function daftarUndangan(Request $request): RedirectResponse
    {
        return redirect()->route('dashboard.index', $request->query());
    }

    public function tamu(Request $request): RedirectResponse
    {
        $pengguna = $request->user();
        $subtab = in_array($request->query('subtab'), ['tamu', 'rsvp'], true)
            ? ['subtab' => (string) $request->query('subtab')]
            : [];

        $undanganDipilihId = (int) $request->query('undangan', 0);
        if ($undanganDipilihId > 0) {
            $undangan = Undangan::findOrFail($undanganDipilihId);
            Gate::authorize('kelola', $undangan);

            return redirect()->route('dashboard.undangan.tamu', array_merge(['undangan' => $undangan], $subtab));
        }

        $daftarUndangan = $pengguna->undangan()->latest()->get();
        $target = $daftarUndangan->first(fn (Undangan $item): bool => $item->sudahAktifPublik())
            ?? $daftarUndangan->first();

        if (! $target) {
            return redirect()
                ->route('dashboard.index')
                ->with('peringatan', 'Buat draft undangan terlebih dahulu untuk mulai mengelola Tamu & RSVP.');
        }

        return redirect()->route('dashboard.undangan.tamu', array_merge(['undangan' => $target], $subtab));
    }

    public function tamuUndangan(Request $request, Undangan $undangan): View
    {
        Gate::authorize('kelola', $undangan);

        $undangan->load(['tema', 'daftarTamu', 'bukuTamu', 'transaksi']);

        $rekapRsvp = [
            'hadir' => $undangan->bukuTamu->where('status_kehadiran', 'hadir')->count(),
            'tidak_hadir' => $undangan->bukuTamu->where('status_kehadiran', 'tidak_hadir')->count(),
            'ragu' => $undangan->bukuTamu->where('status_kehadiran', 'ragu')->count(),
            'total_orang_hadir' => (int) $undangan->bukuTamu->where('status_kehadiran', 'hadir')->sum('jumlah_tamu'),
        ];

        $subtab = (string) ($request->session()->get('subtab_tamu') ?: $request->query('subtab', 'tamu'));
        if (! in_array($subtab, ['tamu', 'rsvp'], true)) {
            $subtab = 'tamu';
        }

        return view('dashboard.tamu', [
            'undangan' => $undangan,
            'rekapRsvp' => $rekapRsvp,
            'subtabAktif' => $subtab,
        ]);
    }

    public function katalog(Request $request): View
    {
        $daftarTema = Tema::where('aktif', true)->orderBy('id')->get();
        $ringkasanKategori = Tema::ringkasanKategori($daftarTema);
        $daftarUndanganSaya = $request->user()
            ->undangan()
            ->with(['tema', 'transaksi'])
            ->latest()
            ->get();

        $idPrepilih = (int) ($request->old('tema_id') ?: $request->query('pakai') ?: $request->query('tema', 0));
        $temaPrepilih = $idPrepilih > 0 ? $daftarTema->firstWhere('id', $idPrepilih) : null;

        return view('dashboard.katalog', [
            'daftarTema' => $daftarTema,
            'ringkasanKategori' => $ringkasanKategori,
            'daftarUndanganSaya' => $daftarUndanganSaya,
            'temaPrepilih' => $temaPrepilih,
            'durasiAktifBulan' => PengaturanSesiTemu::masaAktifBulan(),
        ]);
    }

    public function terapkanTema(Request $request): RedirectResponse
    {
        $tervalidasi = $request->validate([
            'undangan_id' => ['required', 'integer', 'exists:undangan,id'],
            'tema_id' => ['required', 'integer', Rule::exists('tema', 'id')->where('aktif', true)],
        ], [
            'undangan_id.required' => 'Silakan pilih undangan yang ingin diperbarui.',
            'tema_id.required' => 'Tema tidak valid atau sedang tidak aktif.',
        ]);

        $undangan = Undangan::findOrFail((int) $tervalidasi['undangan_id']);
        Gate::authorize('kelola', $undangan);

        if (! $undangan->bolehGantiTemaOleh($request->user())) {
            return back()
                ->withErrors([
                    'undangan_id' => $undangan->alasanTemaTerkunci() ?? 'Tema undangan yang sudah aktif tidak dapat diubah oleh client.',
                ])
                ->withInput();
        }

        $tema = Tema::findOrFail((int) $tervalidasi['tema_id']);
        $undangan->update(['tema_id' => $tema->id]);

        return redirect()
            ->route('dashboard.undangan.kelola', [$undangan, 'tab' => 'tema'])
            ->with('sukses', "Tema \"{$tema->nama_tema}\" berhasil diterapkan ke undangan {$undangan->nama_panggilan_pria} & {$undangan->nama_panggilan_wanita}. Lanjutkan melengkapi data undangan!");
    }

    public function pratinjauTema(Request $request, Undangan $undangan, Tema $tema): View
    {
        Gate::authorize('kelola', $undangan);

        if (! $tema->aktif && (int) $undangan->tema_id !== (int) $tema->id) {
            abort(404);
        }

        $undangan->load(['daftarAcara', 'daftarGaleri', 'daftarAmplop', 'bukuTamu']);

        $pratinjau = clone $undangan;
        $pratinjau->tema_id = $tema->id;
        $pratinjau->setRelation('tema', $tema);

        $lokasiView = $tema->lokasi_view ?: 'tema.rustic-floral.index';

        return view($lokasiView, [
            'undangan' => $pratinjau,
            'namaTamu' => 'Tamu Undangan',
            'modeDemo' => false,
            'modePratinjau' => false,
        ]);
    }

    public function pratinjauLangsung(Request $request, Undangan $undangan): View
    {
        Gate::authorize('kelola', $undangan);

        $undangan->load(['tema', 'daftarAcara', 'daftarGaleri', 'daftarAmplop', 'bukuTamu']);

        $pratinjau = clone $undangan;
        $pengaturan = array_replace_recursive(Undangan::pengaturanBawaan(), $pratinjau->pengaturan ?? []);

        foreach ([
            'nama_panggilan_pria' => 80,
            'nama_lengkap_pria' => 150,
            'nama_panggilan_wanita' => 80,
            'nama_lengkap_wanita' => 150,
        ] as $kolomWajib => $batas) {
            if ($request->has($kolomWajib)) {
                $nilai = trim((string) $request->input($kolomWajib, ''));
                if ($nilai !== '') {
                    $pratinjau->{$kolomWajib} = Str::limit($nilai, $batas, '');
                }
            }
        }

        foreach ([
            'nama_ayah_pria' => 150,
            'nama_ibu_pria' => 150,
            'nama_ayah_wanita' => 150,
            'nama_ibu_wanita' => 150,
            'kutipan_ayat' => 2000,
        ] as $kolomOpsional => $batas) {
            if ($request->has($kolomOpsional)) {
                $nilai = trim((string) $request->input($kolomOpsional, ''));
                $pratinjau->{$kolomOpsional} = $nilai !== '' ? Str::limit($nilai, $batas, '') : null;
            }
        }

        if ($request->has('gaya_font')) {
            $gayaFont = (string) $request->input('gaya_font', 'bawaan');
            if (array_key_exists($gayaFont, Undangan::GAYA_FONT_TERSEDIA)) {
                $pengaturan['gaya_font'] = $gayaFont;
            }
        }

        if ($request->has('tanpa_foto')) {
            $pengaturan['tanpa_foto'] = $request->boolean('tanpa_foto');
        }

        if (is_array($request->input('fitur_aktif'))) {
            foreach (['hitung_mundur', 'cerita_cinta', 'galeri', 'amplop_digital', 'buku_tamu', 'doa_pengantin'] as $kunciFitur) {
                if (array_key_exists($kunciFitur, $request->input('fitur_aktif', []))) {
                    $pengaturan['fitur_aktif'][$kunciFitur] = (bool) $request->input("fitur_aktif.{$kunciFitur}");
                }
            }
        }

        if (is_array($request->input('teks'))) {
            $kunciTeksDiizinkan = [
                'sampul_judul', 'sampul_tombol', 'sampul_sapaan', 'sampul_catatan',
                'judul_mempelai', 'pengantar_mempelai', 'label_pria', 'label_wanita',
                'judul_hitung_mundur', 'pengantar_hitung_mundur', 'judul_acara',
                'judul_cerita', 'judul_galeri', 'judul_amplop', 'pengantar_amplop',
                'judul_buku_tamu', 'doa_judul', 'doa_arab', 'doa_latin', 'doa_isi',
                'judul_turut_mengundang', 'judul_penutup', 'ucapan_penutup', 'label_penutup',
            ];
            $teksBawaanTema = $pratinjau->teksBawaanTema();
            $teksTersimpan = (array) ($pengaturan['teks'] ?? []);
            foreach ($kunciTeksDiizinkan as $kunciTeks) {
                if (array_key_exists($kunciTeks, $request->input('teks', []))) {
                    $nilaiBaru = Str::limit(trim((string) $request->input("teks.{$kunciTeks}", '')), 1000, '');
                    $bawaanKunci = $teksBawaanTema[$kunciTeks] ?? null;
                    $teksTersimpan[$kunciTeks] = ($bawaanKunci !== null && $nilaiBaru === $bawaanKunci)
                        ? ''
                        : $nilaiBaru;
                }
            }
            if ($request->boolean('doa_disertakan')) {
                $doaBawaan = [
                    'doa_judul' => 'Doa Untuk Pengantin',
                    'doa_arab' => 'بَارَكَ اللّٰهُ لَكَ وَبَارَكَ عَلَيْكَ وَجَمَعَ بَيْنَكُمَا فِي خَيْرٍ',
                    'doa_latin' => 'Baarakallahu laka wa baaraka ‘alaika wa jama‘a bainakuma fii khair.',
                    'doa_isi' => 'Semoga Allah memberkahimu di waktu bahagia dan memberkahimu di waktu susah, serta semoga Allah mempersatukan kalian berdua dalam kebaikan. (HR. Abu Daud)',
                ];
                $doaBerubah = false;
                foreach ($doaBawaan as $kunciDoa => $nilaiBawaanDoa) {
                    if (array_key_exists($kunciDoa, $request->input('teks', []))
                        && trim((string) ($teksTersimpan[$kunciDoa] ?? '')) !== $nilaiBawaanDoa) {
                        $doaBerubah = true;
                        break;
                    }
                }
                if ($doaBerubah || ! empty($teksTersimpan['doa_kustom'])) {
                    $teksTersimpan['doa_kustom'] = true;
                }
            }
            $pengaturan['teks'] = $teksTersimpan;
        }

        if ($request->has('instagram_pria') || $request->has('instagram_wanita')) {
            $pengaturan['sosial_media'] = [
                'instagram_pria' => Undangan::bersihkanUsernameInstagram((string) $request->input('instagram_pria', data_get($pengaturan, 'sosial_media.instagram_pria', ''))),
                'instagram_wanita' => Undangan::bersihkanUsernameInstagram((string) $request->input('instagram_wanita', data_get($pengaturan, 'sosial_media.instagram_wanita', ''))),
            ];
        }

        if ($request->has('hashtag')) {
            $hashtagBersih = ltrim(trim((string) $request->input('hashtag', '')), '# ');
            $pengaturan['hashtag'] = $hashtagBersih !== '' ? '#'.Str::limit($hashtagBersih, 79, '') : '';
        }

        if ($request->has('dress_code_catatan') || $request->has('dress_code_warna')) {
            $warnaBersih = [];
            foreach ((array) $request->input('dress_code_warna', []) as $hex) {
                $kode = strtoupper(trim((string) $hex));
                if (preg_match('/^#[0-9A-F]{6}$/', $kode) === 1 && ! in_array($kode, $warnaBersih, true)) {
                    $warnaBersih[] = $kode;
                }
                if (count($warnaBersih) >= 5) {
                    break;
                }
            }
            $pengaturan['dress_code'] = [
                'catatan' => Str::limit(trim((string) $request->input('dress_code_catatan', '')), 300, ''),
                'warna' => $warnaBersih,
            ];
        }

        if ($request->has('live_aktif') || $request->has('live_platform') || $request->has('live_link')) {
            $pengaturan['live_streaming'] = [
                'aktif' => $request->boolean('live_aktif'),
                'platform' => Str::limit(trim((string) $request->input('live_platform', 'Instagram / YouTube')), 100, ''),
                'link' => Str::limit(trim((string) $request->input('live_link', '')), 500, ''),
            ];
        }

        if ($request->has('alamat_kado_fisik')) {
            $pengaturan['alamat_kado_fisik'] = Str::limit(trim((string) $request->input('alamat_kado_fisik', '')), 500, '');
        }

        if ($request->has('turut_mengundang_wanita') || $request->has('turut_mengundang_pria')) {
            $pengaturan['turut_mengundang'] = [
                'pihak_wanita' => Str::limit(trim((string) $request->input('turut_mengundang_wanita', '')), 1500, ''),
                'pihak_pria' => Str::limit(trim((string) $request->input('turut_mengundang_pria', '')), 1500, ''),
            ];
        }

        if (is_array($request->input('cerita_cinta'))) {
            $fotoCeritaLama = collect((array) data_get($pengaturan, 'cerita_cinta', []))
                ->pluck('foto')
                ->filter(static fn ($path): bool => is_string($path) && $path !== '')
                ->all();
            $ceritaBersih = [];
            foreach ((array) $request->input('cerita_cinta', []) as $item) {
                if (! is_array($item)) {
                    continue;
                }
                $judul = Str::limit(trim((string) ($item['judul'] ?? '')), 100, '');
                $tanggal = Str::limit(trim((string) ($item['tanggal'] ?? '')), 50, '');
                $cerita = Str::limit(trim((string) ($item['cerita'] ?? '')), 1000, '');
                $fotoPath = trim((string) ($item['foto'] ?? ''));
                $fotoUrlBlob = trim((string) ($item['foto_url'] ?? ''));
                $hapusFoto = ! empty($item['hapus_foto']);

                if ($hapusFoto) {
                    $fotoFinal = '';
                } elseif (preg_match('/^blob:https?:\/\/[^\s"\'<>]+$/', $fotoUrlBlob) === 1) {
                    $fotoFinal = $fotoUrlBlob;
                } elseif ($fotoPath !== '' && in_array($fotoPath, $fotoCeritaLama, true)) {
                    $fotoFinal = $fotoPath;
                } else {
                    $fotoFinal = '';
                }

                if ($judul !== '' || $cerita !== '' || $fotoFinal !== '') {
                    $entri = ['judul' => $judul, 'tanggal' => $tanggal, 'cerita' => $cerita];
                    if ($fotoFinal !== '') {
                        $entri['foto'] = $fotoFinal;
                    }
                    $ceritaBersih[] = $entri;
                }
            }
            $pengaturan['cerita_cinta'] = $ceritaBersih;
        }

        $fotoLive = (array) $request->input('foto_live', []);
        foreach (['foto_pria', 'foto_wanita'] as $kolomFotoMempelai) {
            $blob = trim((string) ($fotoLive[$kolomFotoMempelai] ?? ''));
            if (preg_match('/^blob:https?:\/\/[^\s"\'<>]+$/', $blob) === 1) {
                $pratinjau->{$kolomFotoMempelai} = $blob;
            }
        }
        foreach ([
            'foto_sampul' => 'hapus_foto_sampul',
            'foto_pembuka' => 'hapus_foto_pembuka',
            'foto_penutup' => 'hapus_foto_penutup',
        ] as $kunciFoto => $kunciHapus) {
            $blob = trim((string) ($fotoLive[$kunciFoto] ?? ''));
            if (preg_match('/^blob:https?:\/\/[^\s"\'<>]+$/', $blob) === 1) {
                $pengaturan[$kunciFoto] = $blob;
            } elseif ($request->boolean($kunciHapus)) {
                $pengaturan[$kunciFoto] = null;
            }
        }

        if ($request->boolean('foto_hitung_mundur_disertakan') || is_array($request->input('foto_hitung_mundur_live'))) {
            $fotoHitungMundurLama = $undangan->daftarPathFotoHitungMundur();
            $hasilLiveHitungMundur = [];
            foreach (array_slice((array) $request->input('foto_hitung_mundur_live', []), 0, Undangan::MAKS_FOTO_HITUNG_MUNDUR) as $itemLive) {
                if (! is_array($itemLive)) {
                    continue;
                }
                $urlLive = trim((string) ($itemLive['url'] ?? ''));
                $pathLive = trim((string) ($itemLive['path'] ?? ''));
                if (preg_match('/^blob:https?:\/\/[^\s"\'<>]+$/', $urlLive) === 1) {
                    $hasilLiveHitungMundur[] = $urlLive;
                } elseif ($pathLive !== '' && in_array($pathLive, $fotoHitungMundurLama, true)) {
                    $hasilLiveHitungMundur[] = $pathLive;
                }
            }
            $pengaturan['foto_hitung_mundur'] = $hasilLiveHitungMundur;
        } elseif ($request->boolean('hapus_foto_hitung_mundur')) {
            $pengaturan['foto_hitung_mundur'] = [];
        } else {
            $blobHitungMundur = trim((string) ($fotoLive['foto_hitung_mundur'] ?? ''));
            if (preg_match('/^blob:https?:\/\/[^\s"\'<>]+$/', $blobHitungMundur) === 1) {
                $pengaturan['foto_hitung_mundur'] = [$blobHitungMundur];
            }
        }

        $pratinjau->pengaturan = $pengaturan;

        if ($request->boolean('galeri_disertakan') || is_array($request->input('galeri_live'))) {
            $galeriLamaById = $undangan->daftarGaleri->keyBy('id');
            $galeriLamaPaths = $undangan->daftarGaleri->pluck('lokasi_foto')->filter()->all();
            $koleksiGaleriLive = [];
            $urutanLive = 1;

            foreach (array_slice((array) $request->input('galeri_live', []), 0, 10) as $itemGaleri) {
                if (! is_array($itemGaleri)) {
                    continue;
                }
                $idItem = (int) ($itemGaleri['id'] ?? 0);
                $urlItem = trim((string) ($itemGaleri['url'] ?? ''));
                $pathItem = trim((string) ($itemGaleri['path'] ?? ''));
                $keteranganItem = Str::limit(trim((string) ($itemGaleri['keterangan'] ?? '')), 255, '');

                $lokasiFinal = '';
                if (preg_match('/^blob:https?:\/\/[^\s"\'<>]+$/', $urlItem) === 1) {
                    $lokasiFinal = $urlItem;
                } elseif ($idItem > 0 && $galeriLamaById->has($idItem)) {
                    $lokasiFinal = (string) $galeriLamaById->get($idItem)->lokasi_foto;
                } elseif ($pathItem !== '' && in_array($pathItem, $galeriLamaPaths, true)) {
                    $lokasiFinal = $pathItem;
                }

                if ($lokasiFinal === '') {
                    continue;
                }

                $modelGaleri = new GaleriUndangan([
                    'undangan_id' => $undangan->id,
                    'lokasi_foto' => $lokasiFinal,
                    'keterangan' => $keteranganItem !== '' ? $keteranganItem : null,
                    'urutan' => $urutanLive++,
                ]);
                if ($idItem > 0) {
                    $modelGaleri->id = $idItem;
                }
                $koleksiGaleriLive[] = $modelGaleri;
            }

            $pratinjau->setRelation('daftarGaleri', new EloquentCollection($koleksiGaleriLive));
        }

        $fokusBagian = (string) $request->input('fokus_bagian', '');
        if (! in_array($fokusBagian, ['tema', 'mempelai', 'acara', 'cerita', 'galeri', 'amplop', 'penutup'], true)) {
            $fokusBagian = '';
        }

        $lokasiView = $pratinjau->tema?->lokasi_view ?: 'tema.rustic-floral.index';

        return view($lokasiView, [
            'undangan' => $pratinjau,
            'namaTamu' => 'Tamu Undangan',
            'modeDemo' => false,
            'modePratinjau' => ! $pratinjau->status_publikasi,
            'livePreviewState' => [
                'bukaSampul' => $request->boolean('buka_sampul'),
                'scrollY' => max(0, (int) $request->input('scroll_y', 0)),
                'fokusBagian' => $fokusBagian,
            ],
        ]);
    }

    public function gantiTema(Request $request, Undangan $undangan): RedirectResponse
    {
        Gate::authorize('kelola', $undangan);

        $tabKembali = (string) $request->input('tab_kembali', 'tema');
        if (! in_array($tabKembali, ['', 'tema', 'mempelai', 'acara', 'cerita', 'galeri', 'amplop', 'penutup', 'aktivasi'], true)) {
            $tabKembali = 'tema';
        }

        if (! $undangan->bolehGantiTemaOleh($request->user())) {
            return redirect()
                ->route('dashboard.undangan.kelola', $undangan)
                ->with('tab_aktif', $tabKembali)
                ->withErrors([
                    'tema_id' => $undangan->alasanTemaTerkunci() ?? 'Tema undangan yang sudah aktif tidak dapat diubah oleh client.',
                ]);
        }

        $tervalidasi = $request->validate([
            'tema_id' => ['required', 'integer', Rule::exists('tema', 'id')->where('aktif', true)],
        ], [
            'tema_id.required' => 'Silakan pilih tema terlebih dahulu.',
            'tema_id.exists' => 'Tema tidak valid atau sedang tidak aktif.',
        ]);

        $tema = Tema::findOrFail((int) $tervalidasi['tema_id']);
        $undangan->update(['tema_id' => $tema->id]);

        return redirect()
            ->route('dashboard.undangan.kelola', $undangan)
            ->with('tab_aktif', $tabKembali)
            ->with('sukses', "Tema berhasil diganti ke \"{$tema->nama_tema}\". Seluruh data undangan Anda tetap tersimpan aman.");
    }

    public function profil(Request $request): View
    {
        $pengguna = $request->user();
        $totalUndangan = $pengguna->undangan()->count();
        $totalUndanganAktif = $pengguna->undangan()
            ->where('status_publikasi', true)
            ->where(function ($query): void {
                $query->whereNull('berlaku_sampai')
                    ->orWhere('berlaku_sampai', '>', now());
            })
            ->count();

        $totalTransaksi = $pengguna->transaksi()->count();
        $riwayatTransaksi = $pengguna->transaksi()
            ->with(['undangan', 'tema'])
            ->take(5)
            ->get();

        return view('dashboard.profil', [
            'pengguna' => $pengguna,
            'totalUndangan' => $totalUndangan,
            'totalUndanganAktif' => $totalUndanganAktif,
            'totalTransaksi' => $totalTransaksi,
            'riwayatTransaksi' => $riwayatTransaksi,
        ]);
    }

    public function perbaruiProfil(Request $request): RedirectResponse
    {
        $pengguna = $request->user();
        $bagian = (string) $request->input('bagian', 'biodata');

        if ($bagian === 'kata_sandi') {
            $tervalidasi = $request->validate([
                'kata_sandi_lama' => ['required', 'string'],
                'kata_sandi_baru' => ['required', 'string', 'min:8', 'confirmed'],
            ], [
                'kata_sandi_lama.required' => 'Kata sandi saat ini wajib diisi.',
                'kata_sandi_baru.required' => 'Kata sandi baru wajib diisi.',
                'kata_sandi_baru.min' => 'Kata sandi baru minimal 8 karakter.',
                'kata_sandi_baru.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            ]);

            if (! Hash::check($tervalidasi['kata_sandi_lama'], $pengguna->kata_sandi)) {
                return back()
                    ->withErrors(['kata_sandi_lama' => 'Kata sandi saat ini tidak sesuai.']);
            }

            $pengguna->update([
                'kata_sandi' => Hash::make($tervalidasi['kata_sandi_baru']),
            ]);

            return redirect()
                ->route('dashboard.profil.tampil')
                ->with('sukses', 'Kata sandi akun berhasil diperbarui.');
        }

        $tervalidasi = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', Rule::unique('pengguna', 'email')->ignore($pengguna->id)],
            'nomor_wa' => ['nullable', 'string', 'max:20'],
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Email tersebut sudah digunakan oleh akun lain.',
        ]);

        $pengguna->update([
            'nama' => $tervalidasi['nama'],
            'email' => $tervalidasi['email'],
            'nomor_wa' => Pengguna::normalisasiNomorWa($tervalidasi['nomor_wa'] ?? null),
        ]);

        return redirect()
            ->route('dashboard.profil.tampil')
            ->with('sukses', 'Profil akun Anda berhasil diperbarui.');
    }

    public function simpanUndanganBaru(Request $request): RedirectResponse
    {
        $tervalidasi = $request->validate([
            'tema_id' => ['required', 'exists:tema,id'],
            'slug' => ['required', 'string', 'max:100'],
            'nama_panggilan_pria' => ['required', 'string', 'max:80'],
            'nama_lengkap_pria' => ['required', 'string', 'max:150'],
            'nama_panggilan_wanita' => ['required', 'string', 'max:80'],
            'nama_lengkap_wanita' => ['required', 'string', 'max:150'],
        ], [
            'tema_id.required' => 'Tema wajib dipilih.',
            'slug.required' => 'Slug link undangan wajib diisi.',
        ]);

        $slug = Str::slug($tervalidasi['slug']);

        if ($slug === '' || in_array($slug, self::SLUG_TERCADANG, true)) {
            return back()->withErrors(['slug' => 'Nama link tidak valid atau merupakan kata yang dicadangkan sistem.'])->withInput();
        }

        if (Undangan::where('slug', $slug)->exists()) {
            return back()->withErrors(['slug' => "Link sesitemu.id/{$slug} sudah dipakai. Gunakan nama link lain."])->withInput();
        }

        $temaDipilih = Tema::findOrFail((int) $tervalidasi['tema_id']);

        $undangan = Undangan::create([
            'pengguna_id' => $request->user()->id,
            'tema_id' => $temaDipilih->id,
            'slug' => $slug,
            'nama_panggilan_pria' => $tervalidasi['nama_panggilan_pria'],
            'nama_lengkap_pria' => $tervalidasi['nama_lengkap_pria'],
            'nama_panggilan_wanita' => $tervalidasi['nama_panggilan_wanita'],
            'nama_lengkap_wanita' => $tervalidasi['nama_lengkap_wanita'],
            'musik_latar' => Tema::musikBawaanUntukSlug($temaDipilih->slug),
            'pengaturan' => Undangan::pengaturanBawaan(),
            'status_publikasi' => false,
        ]);

        return redirect()
            ->route('dashboard.undangan.kelola', $undangan)
            ->with('sukses', 'Draft undangan berhasil dibuat! Silakan lengkapi detail undangan Anda.');
    }

    public function hapusUndangan(
        Request $request,
        Undangan $undangan,
        PengolahGambarService $pengolahGambar
    ): RedirectResponse {
        Gate::authorize('hapus', $undangan);

        if (! $undangan->bolehDihapusClient()) {
            return back()->withErrors([
                'undangan' => 'Undangan yang sudah aktif atau sedang diverifikasi tidak dapat dihapus.',
            ]);
        }

        $undangan->loadMissing(['daftarGaleri', 'transaksi']);

        $slugDihapus = $undangan->slug;
        $undanganId = $undangan->id;
        $fotoPria = $undangan->foto_pria;
        $fotoWanita = $undangan->foto_wanita;
        $fotoSampul = data_get($undangan->pengaturan, 'foto_sampul');
        $fotoPembuka = data_get($undangan->pengaturan, 'foto_pembuka');
        $fotoHitungMundurList = $undangan->daftarPathFotoHitungMundur();
        $fotoPenutup = data_get($undangan->pengaturan, 'foto_penutup');
        $fotoLatar = data_get($undangan->pengaturan, 'foto_latar_tema');
        $musikKustom = data_get($undangan->pengaturan, 'musik_kustom.path');
        $fotoCerita = collect((array) data_get($undangan->pengaturan, 'cerita_cinta', []))
            ->pluck('foto')
            ->filter(static fn ($path): bool => is_string($path) && $path !== '')
            ->all();
        $jalurGaleri = $undangan->daftarGaleri->pluck('lokasi_foto')->filter()->all();
        $jalurBuktiTransaksi = $undangan->transaksi->pluck('bukti_pembayaran')->filter()->all();

        $undangan->delete();

        $pengolahGambar->hapusBerkasJikaAda($fotoPria);
        $pengolahGambar->hapusBerkasJikaAda($fotoWanita);
        foreach ([$fotoSampul, $fotoPembuka, $fotoPenutup, $fotoLatar, ...$fotoHitungMundurList, ...$fotoCerita] as $jalurTambahan) {
            if (is_string($jalurTambahan)) {
                $pengolahGambar->hapusBerkasJikaAda($jalurTambahan);
            }
        }

        foreach ($jalurGaleri as $jalurFoto) {
            $pengolahGambar->hapusBerkasJikaAda($jalurFoto);
        }

        foreach ($jalurBuktiTransaksi as $jalurBukti) {
            if (Storage::disk('public')->exists($jalurBukti)) {
                Storage::disk('public')->delete($jalurBukti);
            }
        }

        if (is_string($musikKustom) && str_starts_with($musikKustom, 'storage/')) {
            $relatifMusik = substr($musikKustom, 8);
            if ($relatifMusik !== '' && Storage::disk('public')->exists($relatifMusik)) {
                Storage::disk('public')->delete($relatifMusik);
            }
        }

        $direktoriUndangan = "undangan/{$undanganId}";
        if (Storage::disk('public')->exists($direktoriUndangan)) {
            Storage::disk('public')->deleteDirectory($direktoriUndangan);
        }

        return redirect()
            ->route('dashboard.index')
            ->with('sukses', "Draft undangan sesitemu.id/{$slugDihapus} berhasil dihapus.");
    }

    public function kelola(Request $request, Undangan $undangan): View|RedirectResponse
    {
        Gate::authorize('kelola', $undangan);

        $tabAktif = (string) ($request->session()->get('tab_aktif') ?: $request->query('tab', ''));

        if ($tabAktif === 'tamu') {
            return redirect()->route('dashboard.undangan.tamu', $undangan);
        }

        if ($tabAktif === '' && $request->session()->has('errors')) {
            $bagianLama = (string) $request->old('bagian', '');
            $tabAktif = match (true) {
                $bagianLama === 'mempelai' => 'mempelai',
                $bagianLama === 'acara_tambahan' || $request->old('nama_acara') !== null => 'acara',
                $bagianLama === 'cerita' || $bagianLama === 'cerita_streaming' => 'cerita',
                $bagianLama === 'kado_fisik' || $request->old('nama_bank') !== null => 'amplop',
                $bagianLama === 'penutup' => 'penutup',
                $request->old('paket') !== null => 'aktivasi',
                default => 'tema',
            };
        }

        if ($tabAktif !== '' && ! in_array($tabAktif, ['tema', 'mempelai', 'acara', 'cerita', 'galeri', 'amplop', 'penutup', 'aktivasi'], true)) {
            $tabAktif = '';
        }

        $undangan->load(['tema', 'daftarAcara', 'daftarGaleri', 'daftarAmplop', 'bukuTamu', 'daftarTamu', 'transaksi.tema', 'transaksi.promo']);

        $daftarTema = Tema::where('aktif', true)->orderBy('id')->get();
        $daftarMusik = $this->ambilDaftarMusik();

        return view('dashboard.kelola', [
            'undangan' => $undangan,
            'daftarTema' => $daftarTema,
            'daftarMusik' => $daftarMusik,
            'daftarGayaFont' => Undangan::GAYA_FONT_TERSEDIA,
            'tabAktif' => $tabAktif,
            'infoRekening' => PengaturanSesiTemu::infoRekening(),
            'biayaTerimaBeres' => PengaturanSesiTemu::biayaTerimaBeres(),
            'durasiAktifBulan' => PengaturanSesiTemu::masaAktifBulan(),
        ]);
    }

    public function perbaruiDataUtama(
        Request $request,
        Undangan $undangan,
        PengolahGambarService $pengolahGambar
    ): RedirectResponse|JsonResponse {
        Gate::authorize('kelola', $undangan);

        $bagian = (string) $request->input('bagian', 'semua');
        $pengaturan = array_replace_recursive(Undangan::pengaturanBawaan(), $undangan->pengaturan ?? []);

        if ($bagian === 'fitur') {
            $tervalidasiFitur = $request->validate([
                'kunci' => ['required', Rule::in(['hitung_mundur', 'cerita_cinta', 'galeri', 'amplop_digital', 'buku_tamu', 'doa_pengantin'])],
                'aktif' => ['required', 'boolean'],
            ]);

            $kunciFitur = (string) $tervalidasiFitur['kunci'];
            $aktifFitur = (bool) $tervalidasiFitur['aktif'];
            $pengaturan['fitur_aktif'][$kunciFitur] = $aktifFitur;
            $undangan->pengaturan = $pengaturan;
            $undangan->save();

            if ($request->expectsJson()) {
                return response()->json([
                    'ok' => true,
                    'kunci' => $kunciFitur,
                    'aktif' => $aktifFitur,
                ]);
            }

            return back()->with('sukses', 'Status fitur undangan berhasil diperbarui.');
        }

        if ($request->has('teks') && is_array($request->input('teks'))) {
            $request->validate([
                'teks' => ['array'],
                'teks.*' => ['nullable', 'string', 'max:1000'],
            ]);
            $kunciTeksDiizinkan = [
                'sampul_judul',
                'sampul_tombol',
                'sampul_sapaan',
                'sampul_catatan',
                'judul_mempelai',
                'pengantar_mempelai',
                'label_pria',
                'label_wanita',
                'judul_hitung_mundur',
                'pengantar_hitung_mundur',
                'judul_acara',
                'judul_cerita',
                'judul_galeri',
                'judul_amplop',
                'pengantar_amplop',
                'judul_buku_tamu',
                'doa_judul',
                'doa_arab',
                'doa_latin',
                'doa_isi',
                'judul_turut_mengundang',
                'judul_penutup',
                'ucapan_penutup',
                'label_penutup',
            ];
            $undangan->loadMissing('tema');
            $teksBawaanTema = $undangan->teksBawaanTema();
            $teksTersimpan = (array) ($pengaturan['teks'] ?? []);
            foreach ($kunciTeksDiizinkan as $kunciTeks) {
                if (array_key_exists($kunciTeks, $request->input('teks', []))) {
                    $nilaiBaru = trim((string) $request->input("teks.{$kunciTeks}", ''));
                    $bawaanKunci = $teksBawaanTema[$kunciTeks] ?? null;
                    $teksTersimpan[$kunciTeks] = ($bawaanKunci !== null && $nilaiBaru === $bawaanKunci)
                        ? ''
                        : $nilaiBaru;
                }
            }
            if ($request->boolean('doa_disertakan')) {
                $doaBawaan = [
                    'doa_judul' => 'Doa Untuk Pengantin',
                    'doa_arab' => 'بَارَكَ اللّٰهُ لَكَ وَبَارَكَ عَلَيْكَ وَجَمَعَ بَيْنَكُمَا فِي خَيْرٍ',
                    'doa_latin' => 'Baarakallahu laka wa baaraka ‘alaika wa jama‘a bainakuma fii khair.',
                    'doa_isi' => 'Semoga Allah memberkahimu di waktu bahagia dan memberkahimu di waktu susah, serta semoga Allah mempersatukan kalian berdua dalam kebaikan. (HR. Abu Daud)',
                ];
                $doaBerubah = false;
                foreach ($doaBawaan as $kunciDoa => $nilaiBawaanDoa) {
                    if (array_key_exists($kunciDoa, $request->input('teks', []))
                        && trim((string) ($teksTersimpan[$kunciDoa] ?? '')) !== $nilaiBawaanDoa) {
                        $doaBerubah = true;
                        break;
                    }
                }
                if ($doaBerubah || ! empty($teksTersimpan['doa_kustom'])) {
                    $teksTersimpan['doa_kustom'] = true;
                }
            }
            $pengaturan['teks'] = $teksTersimpan;
        }

        if ($bagian === 'tema' || $bagian === 'semua') {
            $tervalidasi = $request->validate([
                'tema_id' => ['nullable', 'integer', 'exists:tema,id'],
                'slug' => ['nullable', 'string', 'max:100'],
                'musik_latar' => ['nullable', 'string', 'max:255'],
                'sumber_musik' => ['nullable', Rule::in(['katalog', 'kustom'])],
                'file_musik_kustom' => ['nullable', 'file', 'mimes:mp3,wav,ogg,m4a', 'max:15360'],
                'hapus_musik_kustom' => ['nullable', 'boolean'],
                'gaya_font' => ['nullable', Rule::in(array_keys(Undangan::GAYA_FONT_TERSEDIA))],
            ], [
                'file_musik_kustom.file' => 'Berkas musik kustom tidak valid.',
                'file_musik_kustom.mimes' => 'Format musik harus MP3, WAV, OGG, atau M4A.',
                'file_musik_kustom.max' => 'Ukuran file musik maksimal 15 MB.',
            ]);

            if ($request->filled('slug')) {
                $slugBaru = Str::slug((string) $tervalidasi['slug']);

                if ($slugBaru !== $undangan->slug) {
                    if ($undangan->status_publikasi && ! $request->user()->adalahAdmin()) {
                        if ($request->expectsJson()) {
                            throw ValidationException::withMessages([
                                'slug' => 'Slug undangan yang sudah aktif tidak dapat diubah oleh client.',
                            ]);
                        }

                        return back()
                            ->withErrors(['slug' => 'Slug undangan yang sudah aktif tidak dapat diubah oleh client.'])
                            ->with('tab_aktif', 'tema');
                    }

                    if ($slugBaru === '' || in_array($slugBaru, self::SLUG_TERCADANG, true)) {
                        if ($request->expectsJson()) {
                            throw ValidationException::withMessages([
                                'slug' => 'Format slug tidak valid atau dicadangkan oleh sistem.',
                            ]);
                        }

                        return back()
                            ->withErrors(['slug' => 'Format slug tidak valid atau dicadangkan oleh sistem.'])
                            ->with('tab_aktif', 'tema')
                            ->withInput();
                    }

                    $request->merge(['slug_normalisasi' => $slugBaru]);
                    $request->validate([
                        'slug_normalisasi' => [Rule::unique('undangan', 'slug')->ignore($undangan->id)],
                    ], [
                        'slug_normalisasi.unique' => "Link sesitemu.id/{$slugBaru} sudah dipakai pasangan lain.",
                    ]);

                    $undangan->slug = $slugBaru;
                }
            }

            if (isset($tervalidasi['tema_id'])) {
                $temaBaruId = (int) $tervalidasi['tema_id'];

                if ($temaBaruId !== (int) $undangan->tema_id) {
                    if (! $undangan->bolehGantiTemaOleh($request->user())) {
                        $pesanKunciTema = $undangan->alasanTemaTerkunci() ?? 'Tema undangan yang sudah aktif tidak dapat diubah oleh client.';
                        if ($request->expectsJson()) {
                            throw ValidationException::withMessages(['tema_id' => $pesanKunciTema]);
                        }

                        return back()
                            ->withErrors(['tema_id' => $pesanKunciTema])
                            ->with('tab_aktif', 'tema');
                    }

                    if (! Tema::where('id', $temaBaruId)->where('aktif', true)->exists()) {
                        if ($request->expectsJson()) {
                            throw ValidationException::withMessages(['tema_id' => 'Tema yang dipilih sedang tidak aktif.']);
                        }

                        return back()
                            ->withErrors(['tema_id' => 'Tema yang dipilih sedang tidak aktif.'])
                            ->with('tab_aktif', 'tema');
                    }

                    $undangan->tema_id = $temaBaruId;
                }
            }
            $musikKustomLama = is_array($pengaturan['musik_kustom'] ?? null)
                ? $pengaturan['musik_kustom']
                : null;
            $pathKustomLama = is_string($musikKustomLama['path'] ?? null)
                ? trim($musikKustomLama['path'])
                : '';

            if ($request->boolean('hapus_musik_kustom')) {
                if ($pathKustomLama !== '' && str_starts_with($pathKustomLama, 'storage/')) {
                    Storage::disk('public')->delete(substr($pathKustomLama, 8));
                }
                $pengaturan['musik_kustom'] = null;
                if ($undangan->musik_latar === $pathKustomLama) {
                    $undangan->musik_latar = null;
                }
                $pathKustomLama = '';
            }

            if ($request->hasFile('file_musik_kustom')) {
                if ($pathKustomLama !== '' && str_starts_with($pathKustomLama, 'storage/')) {
                    Storage::disk('public')->delete(substr($pathKustomLama, 8));
                }

                $fileMusik = $request->file('file_musik_kustom');
                $pathRelatif = $fileMusik->store("undangan/{$undangan->id}/musik", 'public');
                $pathPublik = 'storage/'.$pathRelatif;
                $namaAsli = Str::limit(trim((string) $fileMusik->getClientOriginalName()), 120, '');

                $pengaturan['musik_kustom'] = [
                    'path' => $pathPublik,
                    'nama' => $namaAsli !== '' ? $namaAsli : 'Musik Kustom',
                ];
                $undangan->musik_latar = $pathPublik;
            } elseif ($request->input('sumber_musik') === 'kustom') {
                $pathKustomAktif = is_string(data_get($pengaturan, 'musik_kustom.path'))
                    ? trim((string) data_get($pengaturan, 'musik_kustom.path'))
                    : '';
                $undangan->musik_latar = $pathKustomAktif !== '' ? $pathKustomAktif : null;
            } elseif ($request->has('musik_latar')) {
                $undangan->musik_latar = ($tervalidasi['musik_latar'] ?? null) ?: null;
            }

            if ($bagian === 'tema' || $bagian === 'semua') {
                if ($bagian === 'tema' || $request->has('gaya_font')) {
                    $pengaturan['gaya_font'] = $tervalidasi['gaya_font'] ?? ($pengaturan['gaya_font'] ?? 'bawaan');
                }
                if ($bagian === 'tema' || $request->has('tanpa_foto')) {
                    $pengaturan['tanpa_foto'] = $request->boolean('tanpa_foto');
                }
                // Pertahankan sakelar fitur bila form tidak mengirim input fitur_*
                foreach (['hitung_mundur', 'cerita_cinta', 'galeri', 'amplop_digital', 'buku_tamu', 'doa_pengantin'] as $kunciFitur) {
                    if ($request->has("fitur_{$kunciFitur}")) {
                        $pengaturan['fitur_aktif'][$kunciFitur] = $request->boolean("fitur_{$kunciFitur}");
                    }
                }
            }
        }

        if ($bagian === 'mempelai' || $bagian === 'semua') {
            $tervalidasiMempelai = $request->validate([
                'nama_panggilan_pria' => ['required', 'string', 'max:80'],
                'nama_lengkap_pria' => ['required', 'string', 'max:150'],
                'nama_ayah_pria' => ['nullable', 'string', 'max:150'],
                'nama_ibu_pria' => ['nullable', 'string', 'max:150'],
                'foto_pria' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
                'nama_panggilan_wanita' => ['required', 'string', 'max:80'],
                'nama_lengkap_wanita' => ['required', 'string', 'max:150'],
                'nama_ayah_wanita' => ['nullable', 'string', 'max:150'],
                'nama_ibu_wanita' => ['nullable', 'string', 'max:150'],
                'foto_wanita' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
                'instagram_pria' => ['nullable', 'string', 'max:120'],
                'instagram_wanita' => ['nullable', 'string', 'max:120'],
                'kutipan_ayat' => ['nullable', 'string', 'max:2000'],
            ]);

            $undangan->fill([
                'nama_panggilan_pria' => $tervalidasiMempelai['nama_panggilan_pria'],
                'nama_lengkap_pria' => $tervalidasiMempelai['nama_lengkap_pria'],
                'nama_ayah_pria' => $tervalidasiMempelai['nama_ayah_pria'] ?? null,
                'nama_ibu_pria' => $tervalidasiMempelai['nama_ibu_pria'] ?? null,
                'nama_panggilan_wanita' => $tervalidasiMempelai['nama_panggilan_wanita'],
                'nama_lengkap_wanita' => $tervalidasiMempelai['nama_lengkap_wanita'],
                'nama_ayah_wanita' => $tervalidasiMempelai['nama_ayah_wanita'] ?? null,
                'nama_ibu_wanita' => $tervalidasiMempelai['nama_ibu_wanita'] ?? null,
                'kutipan_ayat' => $tervalidasiMempelai['kutipan_ayat'] ?? null,
            ]);

            if ($request->hasFile('foto_pria')) {
                $pengolahGambar->hapusBerkasJikaAda($undangan->foto_pria);
                $undangan->foto_pria = $pengolahGambar->simpanGambarUndangan(
                    $request->file('foto_pria'),
                    $undangan->id,
                    'mempelai-pria'
                );
            }

            if ($request->hasFile('foto_wanita')) {
                $pengolahGambar->hapusBerkasJikaAda($undangan->foto_wanita);
                $undangan->foto_wanita = $pengolahGambar->simpanGambarUndangan(
                    $request->file('foto_wanita'),
                    $undangan->id,
                    'mempelai-wanita'
                );
            }

            if ($request->has('instagram_pria') || $request->has('instagram_wanita')) {
                $pengaturan['sosial_media'] = [
                    'instagram_pria' => Undangan::bersihkanUsernameInstagram((string) $request->input('instagram_pria', data_get($pengaturan, 'sosial_media.instagram_pria', ''))),
                    'instagram_wanita' => Undangan::bersihkanUsernameInstagram((string) $request->input('instagram_wanita', data_get($pengaturan, 'sosial_media.instagram_wanita', ''))),
                ];
            }
        }

        if (in_array($bagian, ['tema', 'mempelai', 'acara_teks', 'acara_tambahan', 'penutup', 'semua'], true)) {
            $aturanFotoTambahan = [
                'foto_sampul' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
                'hapus_foto_sampul' => ['nullable', 'boolean'],
                'foto_pembuka' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
                'hapus_foto_pembuka' => ['nullable', 'boolean'],
                'foto_hitung_mundur_disertakan' => ['nullable', 'boolean'],
                'foto_hitung_mundur_items' => ['nullable', 'array', 'max:'.Undangan::MAKS_FOTO_HITUNG_MUNDUR],
                'foto_hitung_mundur_items.*.path' => ['nullable', 'string', 'max:255'],
                'foto_hitung_mundur_items.*.file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
                'hapus_foto_hitung_mundur' => ['nullable', 'boolean'],
                'foto_penutup' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
                'hapus_foto_penutup' => ['nullable', 'boolean'],
                'hashtag' => ['nullable', 'string', 'max:80'],
            ];

            if ($request->hasFile('foto_hitung_mundur')) {
                if (is_array($request->file('foto_hitung_mundur'))) {
                    $aturanFotoTambahan['foto_hitung_mundur'] = ['array', 'max:'.Undangan::MAKS_FOTO_HITUNG_MUNDUR];
                    $aturanFotoTambahan['foto_hitung_mundur.*'] = ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'];
                } else {
                    $aturanFotoTambahan['foto_hitung_mundur'] = ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'];
                }
            }

            $request->validate($aturanFotoTambahan);

            foreach ([
                'foto_sampul' => ['hapus' => 'hapus_foto_sampul', 'awalan' => 'foto-sampul'],
                'foto_pembuka' => ['hapus' => 'hapus_foto_pembuka', 'awalan' => 'foto-pembuka'],
                'foto_penutup' => ['hapus' => 'hapus_foto_penutup', 'awalan' => 'foto-penutup'],
            ] as $kunciFoto => $metaFoto) {
                $fotoLama = data_get($pengaturan, $kunciFoto);
                if ($request->boolean($metaFoto['hapus']) && is_string($fotoLama) && $fotoLama !== '') {
                    $pengolahGambar->hapusBerkasJikaAda($fotoLama);
                    $pengaturan[$kunciFoto] = null;
                }

                if ($request->hasFile($kunciFoto)) {
                    $pengolahGambar->hapusBerkasJikaAda(is_string($fotoLama) ? $fotoLama : null);
                    $pengaturan[$kunciFoto] = $pengolahGambar->simpanGambarUndangan(
                        $request->file($kunciFoto),
                        $undangan->id,
                        $metaFoto['awalan']
                    );
                }
            }

            // Slideshow Foto Hitung Mundur (hingga 4 foto)
            $fotoHitungMundurLama = $undangan->daftarPathFotoHitungMundur();
            if ($request->boolean('foto_hitung_mundur_disertakan') || $request->has('foto_hitung_mundur_items') || $request->hasFile('foto_hitung_mundur_items')) {
                $inputItems = (array) $request->input('foto_hitung_mundur_items', []);
                $fileItems = (array) $request->file('foto_hitung_mundur_items', []);
                $daftarIndeks = array_values(array_unique(array_merge(array_keys($inputItems), array_keys($fileItems))));
                usort($daftarIndeks, static fn ($a, $b): int => (int) $a <=> (int) $b);

                $daftarFinal = [];
                foreach ($daftarIndeks as $idx) {
                    if (count($daftarFinal) >= Undangan::MAKS_FOTO_HITUNG_MUNDUR) {
                        break;
                    }

                    if ($request->hasFile("foto_hitung_mundur_items.{$idx}.file")) {
                        $daftarFinal[] = $pengolahGambar->simpanGambarUndangan(
                            $request->file("foto_hitung_mundur_items.{$idx}.file"),
                            $undangan->id,
                            'foto-hitung-mundur-'.(count($daftarFinal) + 1)
                        );
                        continue;
                    }

                    $jalurPertahankan = trim((string) data_get($inputItems, "{$idx}.path", ''));
                    if (
                        $jalurPertahankan !== ''
                        && in_array($jalurPertahankan, $fotoHitungMundurLama, true)
                        && ! in_array($jalurPertahankan, $daftarFinal, true)
                    ) {
                        $daftarFinal[] = $jalurPertahankan;
                    }
                }

                foreach ($fotoHitungMundurLama as $jalurLama) {
                    if (! in_array($jalurLama, $daftarFinal, true)) {
                        $pengolahGambar->hapusBerkasJikaAda($jalurLama);
                    }
                }

                $pengaturan['foto_hitung_mundur'] = $daftarFinal;
            } else {
                if ($request->boolean('hapus_foto_hitung_mundur') && ! empty($fotoHitungMundurLama)) {
                    foreach ($fotoHitungMundurLama as $jalurLama) {
                        $pengolahGambar->hapusBerkasJikaAda($jalurLama);
                    }
                    $fotoHitungMundurLama = [];
                    $pengaturan['foto_hitung_mundur'] = [];
                }

                if ($request->hasFile('foto_hitung_mundur')) {
                    $berkasMasuk = $request->file('foto_hitung_mundur');
                    $daftarBerkas = is_array($berkasMasuk) ? array_values($berkasMasuk) : [$berkasMasuk];
                    $daftarBerkas = array_slice($daftarBerkas, 0, Undangan::MAKS_FOTO_HITUNG_MUNDUR);

                    foreach ($fotoHitungMundurLama as $jalurLama) {
                        $pengolahGambar->hapusBerkasJikaAda($jalurLama);
                    }

                    $daftarFinal = [];
                    foreach ($daftarBerkas as $idx => $berkas) {
                        $daftarFinal[] = $pengolahGambar->simpanGambarUndangan(
                            $berkas,
                            $undangan->id,
                            'foto-hitung-mundur-'.($idx + 1)
                        );
                    }
                    $pengaturan['foto_hitung_mundur'] = $daftarFinal;
                }
            }

            if ($request->has('hashtag')) {
                $hashtagBersih = ltrim(trim((string) $request->input('hashtag', '')), '# ');
                $hashtagFinal = $hashtagBersih !== '' ? '#'.$hashtagBersih : '';
                $pengaturan['hashtag'] = $hashtagFinal === $undangan->hashtagBawaan() ? '' : $hashtagFinal;
            }
        }

        if (in_array($bagian, ['cerita', 'acara_tambahan', 'penutup', 'cerita_streaming', 'semua'], true)) {
            $request->validate([
                'cerita_cinta' => ['nullable', 'array'],
                'cerita_cinta.*.judul' => ['nullable', 'string', 'max:100'],
                'cerita_cinta.*.tanggal' => ['nullable', 'string', 'max:50'],
                'cerita_cinta.*.cerita' => ['nullable', 'string', 'max:1000'],
                'cerita_cinta.*.foto' => ['nullable', 'string', 'max:255'],
                'cerita_cinta.*.hapus_foto' => ['nullable', 'boolean'],
                'cerita_cinta.*.foto_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
                'live_platform' => ['nullable', 'string', 'max:100'],
                'live_link' => ['nullable', 'string', 'max:500'],
                'dress_code_catatan' => ['nullable', 'string', 'max:300'],
                'dress_code_warna' => ['nullable', 'array', 'max:5'],
                'dress_code_warna.*' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
                'turut_mengundang_wanita' => ['nullable', 'string', 'max:1500'],
                'turut_mengundang_pria' => ['nullable', 'string', 'max:1500'],
            ]);

            if ($bagian === 'cerita' || $request->has('cerita_cinta')) {
                $fotoCeritaLama = collect((array) data_get($pengaturan, 'cerita_cinta', []))
                    ->pluck('foto')
                    ->filter(static fn ($path): bool => is_string($path) && $path !== '')
                    ->values()
                    ->all();

                $ceritaBersih = [];
                $fotoCeritaDipertahankan = [];
                foreach ((array) $request->input('cerita_cinta', []) as $idx => $item) {
                    $judul = trim((string) ($item['judul'] ?? ''));
                    $tanggal = trim((string) ($item['tanggal'] ?? ''));
                    $cerita = trim((string) ($item['cerita'] ?? ''));
                    $fotoPath = trim((string) ($item['foto'] ?? ''));
                    $hapusFotoBab = ! empty($item['hapus_foto']);

                    // Keamanan: hanya pertahankan jalur foto yang memang berasal dari undangan ini sebelumnya
                    if ($fotoPath !== '' && ! in_array($fotoPath, $fotoCeritaLama, true)) {
                        $fotoPath = '';
                    }

                    if ($hapusFotoBab) {
                        $fotoPath = '';
                    }

                    if ($request->hasFile("cerita_cinta.{$idx}.foto_file")) {
                        $fotoPath = $pengolahGambar->simpanGambarUndangan(
                            $request->file("cerita_cinta.{$idx}.foto_file"),
                            $undangan->id,
                            'cerita-'.($idx + 1)
                        );
                    }

                    if ($judul !== '' || $cerita !== '' || $fotoPath !== '') {
                        $entriCerita = [
                            'judul' => $judul,
                            'tanggal' => $tanggal,
                            'cerita' => $cerita,
                        ];
                        if ($fotoPath !== '') {
                            $entriCerita['foto'] = $fotoPath;
                            $fotoCeritaDipertahankan[] = $fotoPath;
                        }
                        $ceritaBersih[] = $entriCerita;
                    }
                }

                foreach ($fotoCeritaLama as $jalurLama) {
                    if (! in_array($jalurLama, $fotoCeritaDipertahankan, true)) {
                        $pengolahGambar->hapusBerkasJikaAda($jalurLama);
                    }
                }
                $pengaturan['cerita_cinta'] = $ceritaBersih;
            }

            if ($bagian === 'acara_tambahan' || $request->has('live_aktif') || $request->has('live_platform') || $request->has('live_link')) {
                $pengaturan['live_streaming'] = [
                    'aktif' => $request->boolean('live_aktif'),
                    'platform' => (string) $request->input('live_platform', 'Instagram / YouTube'),
                    'link' => (string) $request->input('live_link', ''),
                ];
            }

            if ($bagian === 'acara_tambahan' || $request->has('dress_code_catatan') || $request->has('dress_code_warna') || $request->has('dress_code_disertakan')) {
                $warnaBersih = [];
                foreach ((array) $request->input('dress_code_warna', []) as $hex) {
                    $kode = strtoupper(trim((string) $hex));
                    if (preg_match('/^#[0-9A-F]{6}$/', $kode) === 1 && ! in_array($kode, $warnaBersih, true)) {
                        $warnaBersih[] = $kode;
                    }
                    if (count($warnaBersih) >= 5) {
                        break;
                    }
                }

                $pengaturan['dress_code'] = [
                    'catatan' => trim((string) $request->input('dress_code_catatan', '')),
                    'warna' => $warnaBersih,
                ];
            }

            if ($bagian === 'penutup' || $request->has('turut_mengundang_wanita') || $request->has('turut_mengundang_pria')) {
                $pengaturan['turut_mengundang'] = [
                    'pihak_wanita' => trim((string) $request->input('turut_mengundang_wanita', '')),
                    'pihak_pria' => trim((string) $request->input('turut_mengundang_pria', '')),
                ];
            }
        }

        if ($bagian === 'kado_fisik' || $bagian === 'semua') {
            $request->validate([
                'alamat_kado_fisik' => ['nullable', 'string', 'max:500'],
            ]);

            if ($request->has('alamat_kado_fisik')) {
                $pengaturan['alamat_kado_fisik'] = (string) $request->input('alamat_kado_fisik', '');
            }
        }

        if (in_array($bagian, ['galeri', 'semua'], true) && (
            $request->boolean('galeri_disertakan')
            || $request->has('galeri_items')
            || $request->hasFile('galeri_items')
        )) {
            $request->validate([
                'galeri_disertakan' => ['nullable', 'boolean'],
                'galeri_items' => ['nullable', 'array', 'max:10'],
                'galeri_items.*.id' => ['nullable', 'integer'],
                'galeri_items.*.keterangan' => ['nullable', 'string', 'max:255'],
                'galeri_items.*.file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            ]);

            $galeriLama = $undangan->daftarGaleri()->get()->keyBy('id');
            $inputGaleri = (array) $request->input('galeri_items', []);
            $fileGaleri = (array) $request->file('galeri_items', []);
            $daftarIndeksGaleri = array_values(array_unique(array_merge(array_keys($inputGaleri), array_keys($fileGaleri))));
            usort($daftarIndeksGaleri, static fn ($a, $b): int => (int) $a <=> (int) $b);

            $idDipertahankan = [];
            $urutanGaleri = 1;

            foreach ($daftarIndeksGaleri as $idx) {
                if ($urutanGaleri > 10) {
                    break;
                }

                $idLama = (int) data_get($inputGaleri, "{$idx}.id", 0);
                $ketBersih = trim((string) data_get($inputGaleri, "{$idx}.keterangan", ''));
                $ketFinal = $ketBersih !== '' ? Str::limit($ketBersih, 255, '') : null;
                $adaBerkasBaru = $request->hasFile("galeri_items.{$idx}.file");

                if ($idLama > 0 && $galeriLama->has($idLama) && ! in_array($idLama, $idDipertahankan, true)) {
                    $baris = $galeriLama->get($idLama);
                    if ($adaBerkasBaru) {
                        $pathBaru = $pengolahGambar->simpanGambarUndangan(
                            $request->file("galeri_items.{$idx}.file"),
                            $undangan->id,
                            'galeri'
                        );
                        $pengolahGambar->hapusBerkasJikaAda($baris->lokasi_foto);
                        $baris->lokasi_foto = $pathBaru;
                    }
                    $baris->keterangan = $ketFinal;
                    $baris->urutan = $urutanGaleri++;
                    $baris->save();
                    $idDipertahankan[] = $baris->id;
                } elseif ($adaBerkasBaru) {
                    $pathBaru = $pengolahGambar->simpanGambarUndangan(
                        $request->file("galeri_items.{$idx}.file"),
                        $undangan->id,
                        'galeri'
                    );
                    $barisBaru = GaleriUndangan::create([
                        'undangan_id' => $undangan->id,
                        'lokasi_foto' => $pathBaru,
                        'keterangan' => $ketFinal,
                        'urutan' => $urutanGaleri++,
                    ]);
                    $idDipertahankan[] = $barisBaru->id;
                }
            }

            foreach ($galeriLama as $barisLama) {
                if (! in_array($barisLama->id, $idDipertahankan, true)) {
                    $barisLama->delete();
                }
            }
        }

        $undangan->pengaturan = $pengaturan;
        $undangan->save();

        if ($request->expectsJson()) {
            $undangan->refresh();
            $undangan->load('daftarGaleri');
            $musikKustom = $undangan->musikKustom();
            $galeriTersimpan = $undangan->daftarGaleri
                ->map(static fn (GaleriUndangan $item): array => [
                    'id' => (int) $item->id,
                    'path' => (string) $item->lokasi_foto,
                    'url' => $item->urlFoto(),
                    'keterangan' => (string) ($item->keterangan ?? ''),
                    'urutan' => (int) $item->urutan,
                ])
                ->values()
                ->all();
            $ceritaTersimpan = collect((array) data_get($undangan->pengaturan, 'cerita_cinta', []))
                ->map(static function (array $item): array {
                    $jalurFoto = is_string($item['foto'] ?? null) ? trim($item['foto']) : '';

                    return [
                        'judul' => (string) ($item['judul'] ?? ''),
                        'tanggal' => (string) ($item['tanggal'] ?? ''),
                        'cerita' => (string) ($item['cerita'] ?? ''),
                        'foto' => $jalurFoto,
                        'foto_url' => $jalurFoto !== '' ? (MediaPublik::url($jalurFoto) ?? '') : '',
                        'hapus_foto' => false,
                    ];
                })
                ->values()
                ->all();

            return response()->json([
                'ok' => true,
                'pesan' => 'Semua perubahan undangan berhasil disimpan.',
                'slug' => $undangan->slug,
                'url_publik' => Route::has('undangan.tampil')
                    ? route('undangan.tampil', $undangan->slug)
                    : url('/'.$undangan->slug),
                'url_publik_relatif' => Route::has('undangan.tampil')
                    ? route('undangan.tampil', $undangan->slug, false)
                    : '/'.$undangan->slug,
                'fitur_aktif' => [
                    'hitung_mundur' => $undangan->fiturAktif('hitung_mundur'),
                    'cerita_cinta' => $undangan->fiturAktif('cerita_cinta'),
                    'galeri' => $undangan->fiturAktif('galeri'),
                    'amplop_digital' => $undangan->fiturAktif('amplop_digital'),
                    'buku_tamu' => $undangan->fiturAktif('buku_tamu'),
                    'doa_pengantin' => $undangan->fiturAktif('doa_pengantin'),
                ],
                'foto' => [
                    'foto_sampul' => $undangan->urlFotoSampulKhususDashboard(),
                    'foto_pembuka' => $undangan->urlFotoPembukaKhususDashboard(),
                    'foto_hitung_mundur' => $undangan->urlFotoHitungMundurKhususDashboard(),
                    'foto_pria' => $undangan->urlFotoPria(),
                    'foto_wanita' => $undangan->urlFotoWanita(),
                    'foto_penutup' => $undangan->urlFotoPenutupKhususDashboard(),
                ],
                'foto_hitung_mundur' => $undangan->daftarFotoHitungMundurKhususDashboard(),
                'galeri' => $galeriTersimpan,
                'musik_kustom' => [
                    'url' => $undangan->urlMusikKustom() ?? '',
                    'nama' => (string) ($musikKustom['nama'] ?? ''),
                    'aktif' => $undangan->pakaiMusikKustom(),
                ],
                'cerita_cinta' => $ceritaTersimpan,
            ]);
        }

        $tabTujuan = match ($bagian) {
            'tema' => 'mempelai',
            'mempelai' => 'acara',
            'acara_teks' => 'acara',
            'acara_tambahan' => 'cerita',
            'cerita' => 'galeri',
            'galeri' => 'galeri',
            'amplop_teks' => 'amplop',
            'cerita_streaming' => 'amplop',
            'kado_fisik' => 'penutup',
            'penutup' => 'aktivasi',
            default => 'tema',
        };

        return redirect()
            ->route('dashboard.undangan.kelola', $undangan)
            ->with('tab_aktif', $tabTujuan)
            ->with('sukses', 'Perubahan undangan berhasil disimpan.');
    }

    public function simpanAcara(Request $request, Undangan $undangan): RedirectResponse
    {
        Gate::authorize('kelola', $undangan);

        $tervalidasi = $request->validate([
            'acara_id' => ['nullable', 'integer'],
            'nama_acara' => ['required', 'string', 'max:120'],
            'tanggal_acara' => ['required', 'date'],
            'waktu_mulai' => ['required', 'string', 'max:20'],
            'waktu_selesai' => ['nullable', 'string', 'max:20'],
            'zona_waktu' => ['required', Rule::in(['WIB', 'WITA', 'WIT'])],
            'nama_tempat' => ['required', 'string', 'max:180'],
            'alamat_lengkap' => ['required', 'string', 'max:1000'],
            'link_maps' => ['nullable', 'url', 'max:500'],
        ]);

        if (! empty($tervalidasi['acara_id'])) {
            $acara = $undangan->daftarAcara()->findOrFail((int) $tervalidasi['acara_id']);
            $acara->update([
                'nama_acara' => $tervalidasi['nama_acara'],
                'tanggal_acara' => $tervalidasi['tanggal_acara'],
                'waktu_mulai' => $tervalidasi['waktu_mulai'],
                'waktu_selesai' => $tervalidasi['waktu_selesai'] ?? null,
                'zona_waktu' => $tervalidasi['zona_waktu'],
                'nama_tempat' => $tervalidasi['nama_tempat'],
                'alamat_lengkap' => $tervalidasi['alamat_lengkap'],
                'link_maps' => $tervalidasi['link_maps'] ?? null,
            ]);
            $pesan = 'Data acara berhasil diperbarui.';
        } else {
            AcaraUndangan::create([
                'undangan_id' => $undangan->id,
                'nama_acara' => $tervalidasi['nama_acara'],
                'tanggal_acara' => $tervalidasi['tanggal_acara'],
                'waktu_mulai' => $tervalidasi['waktu_mulai'],
                'waktu_selesai' => $tervalidasi['waktu_selesai'] ?? null,
                'zona_waktu' => $tervalidasi['zona_waktu'],
                'nama_tempat' => $tervalidasi['nama_tempat'],
                'alamat_lengkap' => $tervalidasi['alamat_lengkap'],
                'link_maps' => $tervalidasi['link_maps'] ?? null,
            ]);
            $pesan = 'Jadwal acara baru berhasil ditambahkan.';
        }

        return redirect()
            ->route('dashboard.undangan.kelola', $undangan)
            ->with('tab_aktif', 'acara')
            ->with('sukses', $pesan);
    }

    public function hapusAcara(Undangan $undangan, AcaraUndangan $acara): RedirectResponse
    {
        Gate::authorize('kelola', $undangan);

        if ($acara->undangan_id !== $undangan->id) {
            abort(404);
        }

        $acara->delete();

        return redirect()
            ->route('dashboard.undangan.kelola', $undangan)
            ->with('tab_aktif', 'acara')
            ->with('sukses', 'Jadwal acara berhasil dihapus.');
    }

    public function unggahGaleri(
        Request $request,
        Undangan $undangan,
        PengolahGambarService $pengolahGambar
    ): RedirectResponse {
        Gate::authorize('kelola', $undangan);

        if ($undangan->daftarGaleri()->count() >= 10) {
            return redirect()
                ->route('dashboard.undangan.kelola', $undangan)
                ->with('tab_aktif', 'galeri')
                ->withErrors(['foto' => 'Maksimal 10 foto galeri per undangan.']);
        }

        $tervalidasi = $request->validate([
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ], [
            'foto.required' => 'Silakan pilih file foto untuk diunggah.',
            'foto.image' => 'Berkas harus berupa gambar (JPG, PNG, atau WebP).',
            'foto.max' => 'Ukuran foto maksimal 5 MB.',
        ]);

        $pathWebp = $pengolahGambar->simpanGambarUndangan($request->file('foto'), $undangan->id, 'galeri');
        $urutanBerikut = ((int) $undangan->daftarGaleri()->max('urutan')) + 1;

        GaleriUndangan::create([
            'undangan_id' => $undangan->id,
            'lokasi_foto' => $pathWebp,
            'keterangan' => $tervalidasi['keterangan'] ?? null,
            'urutan' => $urutanBerikut,
        ]);

        return redirect()
            ->route('dashboard.undangan.kelola', $undangan)
            ->with('tab_aktif', 'galeri')
            ->with('sukses', 'Foto galeri berhasil dikompresi ke WebP dan disimpan.');
    }

    public function hapusGaleri(Undangan $undangan, GaleriUndangan $galeri): RedirectResponse
    {
        Gate::authorize('kelola', $undangan);

        if ($galeri->undangan_id !== $undangan->id) {
            abort(404);
        }

        $galeri->delete();

        return redirect()
            ->route('dashboard.undangan.kelola', $undangan)
            ->with('tab_aktif', 'galeri')
            ->with('sukses', 'Foto galeri berhasil dihapus.');
    }

    public function simpanAmplop(Request $request, Undangan $undangan): RedirectResponse
    {
        Gate::authorize('kelola', $undangan);

        $tervalidasi = $request->validate([
            'nama_bank' => ['required', 'string', 'max:80'],
            'nomor_rekening' => ['required', 'string', 'max:80'],
            'atas_nama' => ['required', 'string', 'max:150'],
        ]);

        AmplopDigital::create([
            'undangan_id' => $undangan->id,
            'nama_bank' => $tervalidasi['nama_bank'],
            'nomor_rekening' => $tervalidasi['nomor_rekening'],
            'atas_nama' => $tervalidasi['atas_nama'],
        ]);

        return redirect()
            ->route('dashboard.undangan.kelola', $undangan)
            ->with('tab_aktif', 'amplop')
            ->with('sukses', 'Rekening amplop digital berhasil ditambahkan.');
    }

    public function hapusAmplop(Undangan $undangan, AmplopDigital $amplop): RedirectResponse
    {
        Gate::authorize('kelola', $undangan);

        if ($amplop->undangan_id !== $undangan->id) {
            abort(404);
        }

        $amplop->delete();

        return redirect()
            ->route('dashboard.undangan.kelola', $undangan)
            ->with('tab_aktif', 'amplop')
            ->with('sukses', 'Rekening amplop digital berhasil dihapus.');
    }

    public function simpanTamu(Request $request, Undangan $undangan): RedirectResponse
    {
        Gate::authorize('kelola', $undangan);

        $mode = (string) $request->input('mode', 'satuan');

        if ($mode === 'massal') {
            $tervalidasi = $request->validate([
                'daftar_bulk' => ['required', 'string', 'max:20000'],
            ], [
                'daftar_bulk.required' => 'Masukkan minimal satu nama tamu pada kolom daftar tamu.',
            ]);

            $barisDaftar = preg_split('/\r\n|\r|\n/', $tervalidasi['daftar_bulk']) ?: [];
            $tamuBaru = [];

            foreach ($barisDaftar as $baris) {
                $barisBersih = trim($baris);
                if ($barisBersih === '') {
                    continue;
                }

                $bagian = preg_split('/\s*[,|;\t]\s*/', $barisBersih, 2);
                $namaTamu = trim((string) ($bagian[0] ?? ''));
                $nomorMentah = isset($bagian[1]) ? trim((string) $bagian[1]) : null;

                if ($namaTamu === '') {
                    continue;
                }

                $tamuBaru[] = [
                    'nama_tamu' => Str::limit($namaTamu, 120, ''),
                    'nomor_wa' => TamuUndangan::normalisasiNomorWa($nomorMentah),
                ];

                if (count($tamuBaru) >= 200) {
                    break;
                }
            }

            if ($tamuBaru === []) {
                return redirect()
                    ->route('dashboard.undangan.tamu', $undangan)
                    ->withErrors(['daftar_bulk' => 'Tidak ada nama tamu yang valid untuk disimpan.'])
                    ->withInput();
            }

            foreach ($tamuBaru as $item) {
                TamuUndangan::create([
                    'undangan_id' => $undangan->id,
                    'kode_tamu' => TamuUndangan::buatKodeUnik(),
                    'nama_tamu' => $item['nama_tamu'],
                    'nomor_wa' => $item['nomor_wa'],
                ]);
            }

            $jumlah = count($tamuBaru);

            return redirect()
                ->route('dashboard.undangan.tamu', $undangan)
                ->with('sukses', "{$jumlah} tamu undangan berhasil ditambahkan ke daftar sebar.");
        }

        $tervalidasi = $request->validate([
            'nama_tamu' => ['required', 'string', 'max:120'],
            'nomor_wa' => ['nullable', 'string', 'max:30'],
        ], [
            'nama_tamu.required' => 'Nama tamu wajib diisi.',
            'nama_tamu.max' => 'Nama tamu maksimal 120 karakter.',
        ]);

        $nomorMentah = trim((string) ($tervalidasi['nomor_wa'] ?? ''));
        $nomorNormal = $nomorMentah !== '' ? TamuUndangan::normalisasiNomorWa($nomorMentah) : null;

        if ($nomorMentah !== '' && $nomorNormal === null) {
            return redirect()
                ->route('dashboard.undangan.tamu', $undangan)
                ->withErrors(['nomor_wa' => 'Format nomor WhatsApp tidak valid. Contoh: 081234567890 atau 6281234567890.'])
                ->withInput();
        }

        TamuUndangan::create([
            'undangan_id' => $undangan->id,
            'kode_tamu' => TamuUndangan::buatKodeUnik(),
            'nama_tamu' => trim($tervalidasi['nama_tamu']),
            'nomor_wa' => $nomorNormal,
        ]);

        return redirect()
            ->route('dashboard.undangan.tamu', $undangan)
            ->with('sukses', "Tamu \"{$tervalidasi['nama_tamu']}\" berhasil ditambahkan.");
    }

    public function perbaruiTamu(Request $request, Undangan $undangan, TamuUndangan $tamu): RedirectResponse|JsonResponse
    {
        Gate::authorize('kelola', $undangan);

        if ($tamu->undangan_id !== $undangan->id) {
            abort(404);
        }

        $tervalidasi = $request->validate([
            'nama_tamu' => ['required', 'string', 'max:120'],
            'nomor_wa' => ['nullable', 'string', 'max:30'],
        ], [
            'nama_tamu.required' => 'Nama tamu wajib diisi.',
        ]);

        $nomorMentah = trim((string) ($tervalidasi['nomor_wa'] ?? ''));
        $nomorNormal = $nomorMentah !== '' ? TamuUndangan::normalisasiNomorWa($nomorMentah) : null;

        if ($nomorMentah !== '' && $nomorNormal === null) {
            if ($request->expectsJson()) {
                return response()->json([
                    'ok' => false,
                    'pesan' => 'Format nomor WhatsApp tidak valid. Contoh: 081234567890.',
                ], 422);
            }

            return redirect()
                ->route('dashboard.undangan.tamu', $undangan)
                ->withErrors(['nomor_wa' => 'Format nomor WhatsApp tidak valid. Contoh: 081234567890.']);
        }

        $tamu->update([
            'nama_tamu' => trim($tervalidasi['nama_tamu']),
            'nomor_wa' => $nomorNormal,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'tamu' => [
                    'id' => $tamu->id,
                    'nama_tamu' => $tamu->nama_tamu,
                    'nomor_wa' => $tamu->nomor_wa,
                ],
            ]);
        }

        return redirect()
            ->route('dashboard.undangan.tamu', $undangan)
            ->with('sukses', "Data tamu \"{$tamu->nama_tamu}\" berhasil diperbarui.");
    }

    public function tandaiStatusKirimTamu(Request $request, Undangan $undangan, TamuUndangan $tamu): RedirectResponse|JsonResponse
    {
        Gate::authorize('kelola', $undangan);

        if ($tamu->undangan_id !== $undangan->id) {
            abort(404);
        }

        $terkirim = $request->boolean('terkirim', true);

        $tamu->update([
            'dikirim_pada' => $terkirim ? ($tamu->dikirim_pada ?? now()) : null,
        ]);

        $tamu->refresh();

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'id' => $tamu->id,
                'sudah_dikirim' => $tamu->sudahDikirim(),
                'dikirim_pada_label' => $tamu->dikirim_pada
                    ? $tamu->dikirim_pada->locale('id')->translatedFormat('d M, H:i')
                    : null,
            ]);
        }

        return redirect()
            ->route('dashboard.undangan.tamu', $undangan)
            ->with('sukses', $terkirim ? "Tamu \"{$tamu->nama_tamu}\" ditandai sudah dikirim." : "Status kirim tamu \"{$tamu->nama_tamu}\" direset ke Belum Dikirim.");
    }

    public function hapusTamu(Undangan $undangan, TamuUndangan $tamu): RedirectResponse
    {
        Gate::authorize('kelola', $undangan);

        if ($tamu->undangan_id !== $undangan->id) {
            abort(404);
        }

        $namaTamu = $tamu->nama_tamu;
        $tamu->delete();

        return redirect()
            ->route('dashboard.undangan.tamu', $undangan)
            ->with('sukses', "Tamu \"{$namaTamu}\" berhasil dihapus dari daftar sebar.");
    }

    public function hapusUcapan(Undangan $undangan, BukuTamu $ucapan): RedirectResponse
    {
        Gate::authorize('kelola', $undangan);

        if ($ucapan->undangan_id !== $undangan->id) {
            abort(404);
        }

        $ucapan->delete();

        return redirect()
            ->route('dashboard.undangan.tamu', ['undangan' => $undangan, 'subtab' => 'rsvp'])
            ->with('sukses', 'Ucapan buku tamu berhasil dihapus.');
    }

    public function cekPromo(
        Request $request,
        Undangan $undangan,
        LayananTransaksiService $layanan
    ): JsonResponse {
        Gate::authorize('kelola', $undangan);

        $tervalidasi = $request->validate([
            'paket' => ['required', Rule::in(['mandiri', 'terima_beres'])],
            'tema_id' => ['nullable', 'exists:tema,id'],
            'kode_promo' => ['nullable', 'string', 'max:40'],
        ]);

        $penawaran = $this->hitungPenawaranTransaksi($undangan, $tervalidasi, $layanan);
        if (isset($penawaran['error_message'])) {
            return response()->json([
                'valid' => false,
                'field' => $penawaran['error_field'],
                'pesan' => $penawaran['error_message'],
            ], 422);
        }

        $promo = $penawaran['promo'];
        $rincian = $penawaran['rincian'];

        return response()->json([
            'valid' => true,
            'kode' => $promo?->kode,
            'nama_promo' => $promo?->nama_promo,
            'label_diskon' => $promo?->labelDiskon(),
            'harga_tema' => $rincian['harga_tema'],
            'biaya_jasa' => $rincian['biaya_jasa'],
            'potongan_promo' => $rincian['potongan_promo'],
            'total_bayar' => $rincian['total_bayar'],
            'perlu_bukti' => $rincian['total_bayar'] > 0,
            'pesan' => $promo
                ? "Voucher {$promo->kode} ({$promo->nama_promo}) berhasil diterapkan!"
                : 'Rincian pembayaran tanpa kode promo.',
        ]);
    }

    public function ajukanTransaksi(
        Request $request,
        Undangan $undangan,
        LayananTransaksiService $layanan
    ): RedirectResponse {
        Gate::authorize('kelola', $undangan);

        if ($undangan->sudahAktifPublik()) {
            return back()
                ->withErrors(['pembayaran' => 'Undangan ini sudah aktif sehingga tidak perlu mengajukan pembayaran lagi.'])
                ->with('tab_aktif', 'aktivasi');
        }

        $transaksiMenunggu = $undangan->transaksiMenungguVerifikasi();
        if ($transaksiMenunggu !== null) {
            return back()
                ->withErrors([
                    'pembayaran' => "Bukti pembayaran untuk invoice {$transaksiMenunggu->kode_invoice} sudah dikirim dan sedang menunggu verifikasi Admin. Mohon tunggu hingga verifikasi selesai.",
                ])
                ->with('tab_aktif', 'aktivasi');
        }

        $tervalidasi = $request->validate([
            'paket' => ['required', Rule::in(['mandiri', 'terima_beres'])],
            'tema_id' => ['nullable', 'exists:tema,id'],
            'kode_promo' => ['nullable', 'string', 'max:40'],
            'bukti_pembayaran' => ['nullable', 'image', 'max:4096'],
        ], [
            'paket.required' => 'Silakan pilih paket aktivasi undangan.',
            'bukti_pembayaran.image' => 'Bukti pembayaran harus berupa file gambar (JPG/PNG/WebP).',
            'bukti_pembayaran.max' => 'Ukuran gambar bukti pembayaran maksimal 4 MB.',
        ]);

        $penawaran = $this->hitungPenawaranTransaksi($undangan, $tervalidasi, $layanan);
        if (isset($penawaran['error_message'])) {
            return back()
                ->withErrors([$penawaran['error_field'] => $penawaran['error_message']])
                ->withInput()
                ->with('tab_aktif', 'aktivasi');
        }

        if ($penawaran['rincian']['total_bayar'] > 0 && ! $request->hasFile('bukti_pembayaran')) {
            return back()
                ->withErrors(['bukti_pembayaran' => 'Bukti transfer wajib diunggah sebelum mengajukan aktivasi.'])
                ->withInput()
                ->with('tab_aktif', 'aktivasi');
        }

        $transaksi = $layanan->buatTransaksi(
            $undangan,
            $request->user(),
            $penawaran['tema'],
            $tervalidasi['paket'],
            $penawaran['promo'],
            $request->file('bukti_pembayaran')
        );

        return redirect()
            ->route('dashboard.undangan.kelola', $undangan)
            ->with('tab_aktif', 'aktivasi')
            ->with('sukses', "Order {$transaksi->kode_invoice} berhasil diajukan dengan total ".Tema::formatRupiah($transaksi->total_bayar).' dan menunggu verifikasi Admin.');
    }

    /**
     * Evaluasi tema, promo, dan rincian biaya aktivasi undangan secara seragam.
     *
     * @param  array<string, mixed>  $tervalidasi
     * @return array<string, mixed>
     */
    private function hitungPenawaranTransaksi(
        Undangan $undangan,
        array $tervalidasi,
        LayananTransaksiService $layanan
    ): array {
        $tema = isset($tervalidasi['tema_id'])
            ? Tema::findOrFail((int) $tervalidasi['tema_id'])
            : $undangan->tema;

        if (! $tema) {
            return [
                'error_field' => 'paket',
                'error_message' => 'Tema undangan belum dipilih.',
            ];
        }

        $hasilPromo = $layanan->validasiKodePromo($tervalidasi['kode_promo'] ?? null);
        if ($hasilPromo['error'] !== null) {
            return [
                'error_field' => 'kode_promo',
                'error_message' => $hasilPromo['error'],
            ];
        }

        return [
            'tema' => $tema,
            'promo' => $hasilPromo['promo'],
            'rincian' => $layanan->hitungRincian($tema, $tervalidasi['paket'], $hasilPromo['promo']),
        ];
    }

    public function unggahBuktiTransaksi(
        Request $request,
        Transaksi $transaksi,
        LayananTransaksiService $layanan
    ): RedirectResponse {
        Gate::authorize('kelola', $transaksi->undangan);

        if ($transaksi->status !== 'menunggu_pembayaran' || $transaksi->bukti_pembayaran !== null) {
            return back()
                ->withErrors([
                    'bukti_pembayaran' => "Bukti pembayaran untuk invoice {$transaksi->kode_invoice} sudah dikirim dan tidak dapat diunggah ulang.",
                ])
                ->with('tab_aktif', 'aktivasi');
        }

        $request->validate([
            'bukti_pembayaran' => ['required', 'image', 'max:4096'],
        ], [
            'bukti_pembayaran.required' => 'Pilih file gambar bukti pembayaran terlebih dahulu.',
            'bukti_pembayaran.image' => 'Bukti pembayaran harus berupa gambar.',
        ]);

        $layanan->unggahBukti($transaksi, $request->file('bukti_pembayaran'));

        return redirect()
            ->route('dashboard.undangan.kelola', $transaksi->undangan)
            ->with('tab_aktif', 'aktivasi')
            ->with('sukses', "Bukti pembayaran untuk invoice {$transaksi->kode_invoice} berhasil diunggah.");
    }

    /**
     * @return list<array{path: string, label: string}>
     */
    private function ambilDaftarMusik(): array
    {
        if (Schema::hasTable('musik_latar')) {
            $musikDb = MusikLatar::where('aktif', true)
                ->orderBy('urutan')
                ->orderBy('judul')
                ->get();

            if ($musikDb->isNotEmpty()) {
                return $musikDb->map(function (MusikLatar $musik): array {
                    $label = $musik->artis ? "{$musik->judul} — {$musik->artis}" : $musik->judul;

                    return [
                        'path' => $musik->path_file,
                        'label' => $label,
                    ];
                })->all();
            }
        }

        $direktori = public_path('musik');
        if (! is_dir($direktori)) {
            return [];
        }

        $daftar = [];
        $files = glob($direktori.DIRECTORY_SEPARATOR.'*.mp3') ?: [];

        foreach ($files as $file) {
            $namaFile = basename($file);
            $daftar[] = [
                'path' => 'musik/'.$namaFile,
                'label' => Str::title(str_replace(['-', '.mp3'], [' ', ''], $namaFile)),
            ];
        }

        return $daftar;
    }
}
