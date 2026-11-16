<?php

namespace App\Http\Controllers;

use App\Models\AcaraUndangan;
use App\Models\AmplopDigital;
use App\Models\BukuTamu;
use App\Models\GaleriUndangan;
use App\Models\MusikLatar;
use App\Models\Pengguna;
use App\Models\Tema;
use App\Models\Transaksi;
use App\Models\Undangan;
use App\Services\LayananTransaksiService;
use App\Services\PengolahGambarService;
use App\Support\PengaturanSesiTemu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DasborUndanganController extends Controller
{
    /**
     * @var list<string>
     */
    private const SLUG_TERCADANG = [
        'masuk',
        'daftar',
        'keluar',
        'dasbor',
        'admin',
        'demo',
        'cek-link',
        'up',
    ];

    public function index(Request $request): View
    {
        $daftarUndangan = $request->user()
            ->undangan()
            ->with(['tema', 'bukuTamu', 'daftarAcara', 'transaksi'])
            ->latest()
            ->get();

        $daftarTema = Tema::where('aktif', true)->orderBy('id')->get();

        return view('dasbor.index', [
            'daftarUndangan' => $daftarUndangan,
            'daftarTema' => $daftarTema,
            'durasiAktifBulan' => PengaturanSesiTemu::masaAktifBulan(),
        ]);
    }

    public function katalog(Request $request): View
    {
        $daftarTema = Tema::where('aktif', true)->orderBy('id')->get();
        $ringkasanTier = Tema::ringkasanTier($daftarTema);
        $daftarUndanganSaya = $request->user()
            ->undangan()
            ->with('tema')
            ->latest()
            ->get();

        $idPrepilih = (int) ($request->old('tema_id') ?: $request->query('pakai') ?: $request->query('tema', 0));
        $temaPrepilih = $idPrepilih > 0 ? $daftarTema->firstWhere('id', $idPrepilih) : null;

        return view('dasbor.katalog', [
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

        $tema = Tema::findOrFail((int) $tervalidasi['tema_id']);
        $undangan->update(['tema_id' => $tema->id]);

        return redirect()
            ->route('dasbor.undangan.kelola', [$undangan, 'tab' => 'tema'])
            ->with('sukses', "Tema \"{$tema->nama_tema}\" berhasil diterapkan ke undangan {$undangan->nama_panggilan_pria} & {$undangan->nama_panggilan_wanita}. Lanjutkan melengkapi data undangan!");
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

        return view('dasbor.profil', [
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
                ->route('dasbor.profil.tampil')
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
            ->route('dasbor.profil.tampil')
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
            ->route('dasbor.undangan.kelola', $undangan)
            ->with('sukses', 'Draft undangan berhasil dibuat! Silakan lengkapi detail undangan Anda.');
    }

    public function kelola(Request $request, Undangan $undangan): View
    {
        Gate::authorize('kelola', $undangan);

        $undangan->load(['tema', 'daftarAcara', 'daftarGaleri', 'daftarAmplop', 'bukuTamu', 'transaksi.tema', 'transaksi.promo']);

        $daftarTema = Tema::where('aktif', true)->orderBy('id')->get();
        $daftarMusik = $this->ambilDaftarMusik();

        $rekapRsvp = [
            'hadir' => $undangan->bukuTamu->where('status_kehadiran', 'hadir')->count(),
            'tidak_hadir' => $undangan->bukuTamu->where('status_kehadiran', 'tidak_hadir')->count(),
            'ragu' => $undangan->bukuTamu->where('status_kehadiran', 'ragu')->count(),
            'total_orang_hadir' => (int) $undangan->bukuTamu->where('status_kehadiran', 'hadir')->sum('jumlah_tamu'),
        ];

        $tabAktif = (string) ($request->session()->get('tab_aktif') ?: $request->query('tab', 'tema'));

        return view('dasbor.kelola', [
            'undangan' => $undangan,
            'daftarTema' => $daftarTema,
            'daftarMusik' => $daftarMusik,
            'daftarGayaFont' => Undangan::GAYA_FONT_TERSEDIA,
            'rekapRsvp' => $rekapRsvp,
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
                'tema_id' => ['required', 'exists:tema,id'],
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

            $undangan->tema_id = (int) $tervalidasi['tema_id'];
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

            $fotoSampulLama = data_get($pengaturan, 'foto_sampul');
            if ($request->boolean('hapus_foto_sampul') && is_string($fotoSampulLama) && $fotoSampulLama !== '') {
                $pengolahGambar->hapusBerkasJikaAda($fotoSampulLama);
                $pengaturan['foto_sampul'] = null;
            }

            if ($request->hasFile('foto_sampul')) {
                $pengolahGambar->hapusBerkasJikaAda(is_string($fotoSampulLama) ? $fotoSampulLama : null);
                $pengaturan['foto_sampul'] = $pengolahGambar->simpanGambarUndangan(
                    $request->file('foto_sampul'),
                    $undangan->id,
                    'foto-sampul'
                );
            }
        }

        if ($bagian === 'cerita_streaming' || $bagian === 'semua') {
            $request->validate([
                'cerita_cinta' => ['nullable', 'array'],
                'cerita_cinta.*.judul' => ['nullable', 'string', 'max:100'],
                'cerita_cinta.*.tanggal' => ['nullable', 'string', 'max:50'],
                'cerita_cinta.*.cerita' => ['nullable', 'string', 'max:1000'],
                'live_platform' => ['nullable', 'string', 'max:100'],
                'live_link' => ['nullable', 'string', 'max:500'],
            ]);

            $ceritaBersih = [];
            foreach ((array) $request->input('cerita_cinta', []) as $item) {
                $judul = trim((string) ($item['judul'] ?? ''));
                $tanggal = trim((string) ($item['tanggal'] ?? ''));
                $cerita = trim((string) ($item['cerita'] ?? ''));

                if ($judul !== '' || $cerita !== '') {
                    $ceritaBersih[] = [
                        'judul' => $judul,
                        'tanggal' => $tanggal,
                        'cerita' => $cerita,
                    ];
                }
            }

            if ($request->has('cerita_cinta') || $bagian === 'cerita_streaming') {
                $pengaturan['cerita_cinta'] = $ceritaBersih;
                $pengaturan['live_streaming'] = [
                    'aktif' => $request->boolean('live_aktif'),
                    'platform' => (string) $request->input('live_platform', 'Instagram / YouTube'),
                    'link' => (string) $request->input('live_link', ''),
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
            'mempelai' => 'mempelai',
            'cerita_streaming' => 'galeri',
            'kado_fisik' => 'amplop',
            default => 'tema',
        };

        return redirect()
            ->route('dasbor.undangan.kelola', $undangan)
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
            ->route('dasbor.undangan.kelola', $undangan)
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
            ->route('dasbor.undangan.kelola', $undangan)
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
                ->route('dasbor.undangan.kelola', $undangan)
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
            ->route('dasbor.undangan.kelola', $undangan)
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
            ->route('dasbor.undangan.kelola', $undangan)
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
            ->route('dasbor.undangan.kelola', $undangan)
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
            ->route('dasbor.undangan.kelola', $undangan)
            ->with('tab_aktif', 'amplop')
            ->with('sukses', 'Rekening amplop digital berhasil dihapus.');
    }

    public function hapusUcapan(Undangan $undangan, BukuTamu $ucapan): RedirectResponse
    {
        Gate::authorize('kelola', $undangan);

        if ($ucapan->undangan_id !== $undangan->id) {
            abort(404);
        }

        $ucapan->delete();

        return redirect()
            ->route('dasbor.undangan.kelola', $undangan)
            ->with('tab_aktif', 'tamu')
            ->with('sukses', 'Ucapan buku tamu berhasil dihapus.');
    }

    public function ajukanTransaksi(
        Request $request,
        Undangan $undangan,
        LayananTransaksiService $layanan
    ): RedirectResponse {
        Gate::authorize('kelola', $undangan);

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

        $hasilPromo = $layanan->validasiKodePromo($tervalidasi['kode_promo'] ?? null);
        if ($hasilPromo['error'] !== null) {
            return back()
                ->withErrors(['kode_promo' => $hasilPromo['error']])
                ->withInput()
                ->with('tab_aktif', 'aktivasi');
        }

        $tema = isset($tervalidasi['tema_id'])
            ? Tema::findOrFail((int) $tervalidasi['tema_id'])
            : $undangan->tema;

        $transaksi = $layanan->buatTransaksi(
            $undangan,
            $request->user(),
            $tema,
            $tervalidasi['paket'],
            $hasilPromo['promo'],
            $request->file('bukti_pembayaran')
        );

        return redirect()
            ->route('dasbor.undangan.kelola', $undangan)
            ->with('tab_aktif', 'aktivasi')
            ->with('sukses', "Order {$transaksi->kode_invoice} berhasil dibuat dengan total ".Tema::formatRupiah($transaksi->total_bayar).'.');
    }

    public function unggahBuktiTransaksi(
        Request $request,
        Transaksi $transaksi,
        LayananTransaksiService $layanan
    ): RedirectResponse {
        Gate::authorize('kelola', $transaksi->undangan);

        $request->validate([
            'bukti_pembayaran' => ['required', 'image', 'max:4096'],
        ], [
            'bukti_pembayaran.required' => 'Pilih file gambar bukti pembayaran terlebih dahulu.',
            'bukti_pembayaran.image' => 'Bukti pembayaran harus berupa gambar.',
        ]);

        $layanan->unggahBukti($transaksi, $request->file('bukti_pembayaran'));

        return redirect()
            ->route('dasbor.undangan.kelola', $transaksi->undangan)
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
