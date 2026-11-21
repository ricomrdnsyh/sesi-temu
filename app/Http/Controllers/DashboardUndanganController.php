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
use App\Support\PengaturanSesiTemu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
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
        $ringkasanTier = Tema::ringkasanTier($daftarTema);
        $daftarUndanganSaya = $request->user()
            ->undangan()
            ->with(['tema', 'transaksi'])
            ->latest()
            ->get();

        $idPrepilih = (int) ($request->old('tema_id') ?: $request->query('pakai') ?: $request->query('tema', 0));
        $temaPrepilih = $idPrepilih > 0 ? $daftarTema->firstWhere('id', $idPrepilih) : null;

        return view('dashboard.katalog', [
            'daftarTema' => $daftarTema,
            'ringkasanTier' => $ringkasanTier,
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

    public function gantiTema(Request $request, Undangan $undangan): RedirectResponse
    {
        Gate::authorize('kelola', $undangan);

        $tabKembali = (string) $request->input('tab_kembali', 'tema');
        if (! in_array($tabKembali, ['', 'tema', 'mempelai', 'acara', 'galeri', 'amplop', 'aktivasi'], true)) {
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

        $undangan = Undangan::create([
            'pengguna_id' => $request->user()->id,
            'tema_id' => (int) $tervalidasi['tema_id'],
            'slug' => $slug,
            'nama_panggilan_pria' => $tervalidasi['nama_panggilan_pria'],
            'nama_lengkap_pria' => $tervalidasi['nama_lengkap_pria'],
            'nama_panggilan_wanita' => $tervalidasi['nama_panggilan_wanita'],
            'nama_lengkap_wanita' => $tervalidasi['nama_lengkap_wanita'],
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
        $fotoPenutup = data_get($undangan->pengaturan, 'foto_penutup');
        $fotoLatar = data_get($undangan->pengaturan, 'foto_latar_tema');
        $fotoCerita = collect((array) data_get($undangan->pengaturan, 'cerita_cinta', []))
            ->pluck('foto')
            ->filter(static fn ($path): bool => is_string($path) && $path !== '')
            ->all();
        $jalurGaleri = $undangan->daftarGaleri->pluck('lokasi_foto')->filter()->all();
        $jalurBuktiTransaksi = $undangan->transaksi->pluck('bukti_pembayaran')->filter()->all();

        $undangan->delete();

        $pengolahGambar->hapusBerkasJikaAda($fotoPria);
        $pengolahGambar->hapusBerkasJikaAda($fotoWanita);
        foreach ([$fotoSampul, $fotoPembuka, $fotoPenutup, $fotoLatar, ...$fotoCerita] as $jalurTambahan) {
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
                $bagianLama === 'cerita_streaming' => 'galeri',
                $bagianLama === 'kado_fisik' || $request->old('nama_bank') !== null => 'amplop',
                $request->old('nama_acara') !== null => 'acara',
                $request->old('paket') !== null => 'aktivasi',
                default => 'tema',
            };
        }

        if ($tabAktif !== '' && ! in_array($tabAktif, ['tema', 'mempelai', 'acara', 'galeri', 'amplop', 'aktivasi'], true)) {
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
    ): RedirectResponse {
        Gate::authorize('kelola', $undangan);

        $bagian = (string) $request->input('bagian', 'semua');
        $pengaturan = array_replace_recursive(Undangan::pengaturanBawaan(), $undangan->pengaturan ?? []);

        if ($bagian === 'tema' || $bagian === 'semua') {
            $tervalidasi = $request->validate([
                'tema_id' => ['nullable', 'integer', 'exists:tema,id'],
                'slug' => ['nullable', 'string', 'max:100'],
                'musik_latar' => ['nullable', 'string', 'max:255'],
                'gaya_font' => ['nullable', Rule::in(array_keys(Undangan::GAYA_FONT_TERSEDIA))],
            ]);

            if ($request->filled('slug')) {
                $slugBaru = Str::slug((string) $tervalidasi['slug']);

                if ($slugBaru !== $undangan->slug) {
                    if ($undangan->status_publikasi && ! $request->user()->adalahAdmin()) {
                        return back()
                            ->withErrors(['slug' => 'Slug undangan yang sudah aktif tidak dapat diubah oleh client.'])
                            ->with('tab_aktif', 'tema');
                    }

                    if ($slugBaru === '' || in_array($slugBaru, self::SLUG_TERCADANG, true)) {
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
                        return back()
                            ->withErrors([
                                'tema_id' => $undangan->alasanTemaTerkunci() ?? 'Tema undangan yang sudah aktif tidak dapat diubah oleh client.',
                            ])
                            ->with('tab_aktif', 'tema');
                    }

                    if (! Tema::where('id', $temaBaruId)->where('aktif', true)->exists()) {
                        return back()
                            ->withErrors(['tema_id' => 'Tema yang dipilih sedang tidak aktif.'])
                            ->with('tab_aktif', 'tema');
                    }

                    $undangan->tema_id = $temaBaruId;
                }
            }
            if ($request->has('musik_latar')) {
                $undangan->musik_latar = ($tervalidasi['musik_latar'] ?? null) ?: null;
            }

            if ($bagian === 'tema') {
                $pengaturan['gaya_font'] = $tervalidasi['gaya_font'] ?? 'bawaan';
                $pengaturan['tanpa_foto'] = $request->boolean('tanpa_foto');
                $pengaturan['fitur_aktif'] = [
                    'hitung_mundur' => $request->boolean('fitur_hitung_mundur'),
                    'cerita_cinta' => $request->boolean('fitur_cerita_cinta'),
                    'galeri' => $request->boolean('fitur_galeri'),
                    'amplop_digital' => $request->boolean('fitur_amplop_digital'),
                    'buku_tamu' => $request->boolean('fitur_buku_tamu'),
                ];
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
                'foto_sampul' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
                'hapus_foto_sampul' => ['nullable', 'boolean'],
                'foto_pembuka' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
                'hapus_foto_pembuka' => ['nullable', 'boolean'],
                'foto_penutup' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
                'hapus_foto_penutup' => ['nullable', 'boolean'],
                'foto_latar_tema' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
                'hapus_foto_latar_tema' => ['nullable', 'boolean'],
                'hashtag' => ['nullable', 'string', 'max:80'],
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

            foreach ([
                'foto_sampul' => ['hapus' => 'hapus_foto_sampul', 'awalan' => 'foto-sampul'],
                'foto_pembuka' => ['hapus' => 'hapus_foto_pembuka', 'awalan' => 'foto-pembuka'],
                'foto_penutup' => ['hapus' => 'hapus_foto_penutup', 'awalan' => 'foto-penutup'],
                'foto_latar_tema' => ['hapus' => 'hapus_foto_latar_tema', 'awalan' => 'foto-latar'],
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

            if ($request->has('hashtag')) {
                $hashtagBersih = ltrim(trim((string) $request->input('hashtag', '')), '# ');
                $pengaturan['hashtag'] = $hashtagBersih !== '' ? '#'.$hashtagBersih : '';
            }

            if ($request->has('instagram_pria') || $request->has('instagram_wanita')) {
                $pengaturan['sosial_media'] = [
                    'instagram_pria' => Undangan::bersihkanUsernameInstagram((string) $request->input('instagram_pria', data_get($pengaturan, 'sosial_media.instagram_pria', ''))),
                    'instagram_wanita' => Undangan::bersihkanUsernameInstagram((string) $request->input('instagram_wanita', data_get($pengaturan, 'sosial_media.instagram_wanita', ''))),
                ];
            }
        }

        if ($bagian === 'cerita_streaming' || $bagian === 'semua') {
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

            if ($request->has('cerita_cinta') || $bagian === 'cerita_streaming') {
                foreach ($fotoCeritaLama as $jalurLama) {
                    if (! in_array($jalurLama, $fotoCeritaDipertahankan, true)) {
                        $pengolahGambar->hapusBerkasJikaAda($jalurLama);
                    }
                }
                $pengaturan['cerita_cinta'] = $ceritaBersih;
                $pengaturan['live_streaming'] = [
                    'aktif' => $request->boolean('live_aktif'),
                    'platform' => (string) $request->input('live_platform', 'Instagram / YouTube'),
                    'link' => (string) $request->input('live_link', ''),
                ];
            }

            if ($request->has('dress_code_catatan') || $request->has('dress_code_warna') || $request->has('dress_code_disertakan')) {
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

            if ($request->has('turut_mengundang_wanita') || $request->has('turut_mengundang_pria')) {
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

        $undangan->pengaturan = $pengaturan;
        $undangan->save();

        $tabTujuan = match ($bagian) {
            'tema' => 'mempelai',
            'mempelai' => 'acara',
            'cerita_streaming' => 'amplop',
            'kado_fisik' => 'aktivasi',
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
