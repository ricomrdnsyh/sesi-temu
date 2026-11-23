<?php

namespace App\Http\Controllers;

use App\Models\Tema;
use App\Services\PengolahGambarService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AdminTemaController extends Controller
{
    public function index(): View
    {
        $daftarTema = Tema::withCount('undangan')->orderBy('id')->get();
        $jumlahTemaDiskon = $daftarTema->filter(fn (Tema $tema): bool => $tema->adaDiskon())->count();

        return view('admin.tema.index', [
            'daftarTema' => $daftarTema,
            'jumlahTemaDiskon' => $jumlahTemaDiskon,
            'daftarLokasiView' => Tema::daftarLokasiViewTersedia(),
        ]);
    }

    public function create(): View
    {
        $daftarLokasiView = Tema::daftarLokasiViewTersedia();
        $lokasiBawaan = array_key_exists('tema.rustic-floral.index', $daftarLokasiView)
            ? 'tema.rustic-floral.index'
            : (array_key_first($daftarLokasiView) ?? 'tema.rustic-floral.index');

        return view('admin.tema.form', [
            'tema' => new Tema([
                'kategori' => 'adat',
                'tier' => 'basic',
                'harga' => Tema::HARGA_BAWAAN_TIER['basic'],
                'lokasi_view' => $lokasiBawaan,
                'aktif' => true,
            ]),
            'modeEdit' => false,
            'daftarLokasiView' => $daftarLokasiView,
        ]);
    }

    public function store(Request $request, PengolahGambarService $pengolahGambar): RedirectResponse
    {
        $data = $this->validasiDataTema($request);

        $pathGambar = null;
        if ($request->hasFile('gambar_pratinjau')) {
            $pathGambar = $pengolahGambar->simpanGambarTema($request->file('gambar_pratinjau'), $data['slug']);
        }

        Tema::create([
            ...$data,
            'gambar_pratinjau' => $pathGambar,
        ]);

        return redirect()
            ->route('admin.tema.index')
            ->with('sukses', 'Tema baru berhasil ditambahkan ke katalog.');
    }

    public function edit(Tema $tema): View
    {
        return view('admin.tema.form', [
            'tema' => $tema,
            'modeEdit' => true,
            'daftarLokasiView' => Tema::daftarLokasiViewTersedia(),
        ]);
    }

    public function update(Request $request, Tema $tema, PengolahGambarService $pengolahGambar): RedirectResponse
    {
        $data = $this->validasiDataTema($request, $tema);

        $pathGambar = $tema->gambar_pratinjau;
        if ($request->hasFile('gambar_pratinjau')) {
            $pengolahGambar->hapusBerkasJikaAda($tema->gambar_pratinjau);
            $pathGambar = $pengolahGambar->simpanGambarTema($request->file('gambar_pratinjau'), $data['slug']);
        }

        $tema->update([
            ...$data,
            'gambar_pratinjau' => $pathGambar,
        ]);

        return redirect()
            ->route('admin.tema.index')
            ->with('sukses', "Tema {$tema->nama_tema} berhasil diperbarui.");
    }

    /**
     * Memvalidasi input tema sekaligus menormalkan slug, tier, harga, dan diskon katalog.
     *
     * @return array{
     *     nama_tema: string,
     *     slug: string,
     *     kategori: string,
     *     tier: string,
     *     harga: int,
     *     diskon_tipe: ?string,
     *     diskon_nilai: int,
     *     lokasi_view: string,
     *     aktif: bool
     * }
     */
    private function validasiDataTema(Request $request, ?Tema $tema = null): array
    {
        $tervalidasi = $request->validate([
            'nama_tema' => ['required', 'string', 'max:120'],
            'slug' => ['nullable', 'string', 'max:120'],
            'kategori' => ['required', Rule::in(array_keys(Tema::KATEGORI_TERSEDIA))],
            'tier' => ['nullable', Rule::in(array_keys(Tema::TIER_TERSEDIA))],
            'harga' => ['nullable', 'integer', 'min:0', 'max:100000000'],
            'diskon_tipe' => ['nullable', Rule::in(['nominal', 'persen'])],
            'diskon_nilai' => ['nullable', 'integer', 'min:0', 'max:100000000'],
            'lokasi_view' => [
                'required',
                'string',
                'max:150',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    $namaView = trim((string) $value);
                    if (! Str::startsWith($namaView, 'tema.') || ! ViewFacade::exists($namaView)) {
                        $fail("Template Blade \"{$namaView}\" tidak ditemukan di folder resources/views/tema/.");
                    }
                },
            ],
            'gambar_pratinjau' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $slug = Str::slug((string) ($tervalidasi['slug'] ?: $tervalidasi['nama_tema']));
        $request->merge(['slug_normalisasi' => $slug]);
        $request->validate([
            'slug_normalisasi' => ['required', Rule::unique('tema', 'slug')->ignore($tema?->id)],
        ], [
            'slug_normalisasi.unique' => "Slug tema {$slug} sudah terdaftar.",
        ]);

        $tier = $tervalidasi['tier'] ?? ($tema?->tierKode() ?? 'basic');
        $harga = array_key_exists('harga', $tervalidasi) && $tervalidasi['harga'] !== null
            ? (int) $tervalidasi['harga']
            : ($tema ? $tema->hargaAsliNominal() : Tema::hargaBawaanTier($tier));

        $diskonTipe = $tervalidasi['diskon_tipe'] ?? null;
        $diskonNilai = (int) ($tervalidasi['diskon_nilai'] ?? 0);

        if ($diskonTipe === 'persen' && $diskonNilai > 100) {
            throw ValidationException::withMessages([
                'diskon_nilai' => 'Diskon persentase maksimal 100%.',
            ]);
        }

        if ($diskonTipe === null || $diskonNilai <= 0) {
            $diskonTipe = null;
            $diskonNilai = 0;
        }

        return [
            'nama_tema' => $tervalidasi['nama_tema'],
            'slug' => $slug,
            'kategori' => $tervalidasi['kategori'],
            'tier' => $tier,
            'harga' => $harga,
            'diskon_tipe' => $diskonTipe,
            'diskon_nilai' => $diskonNilai,
            'lokasi_view' => $tervalidasi['lokasi_view'],
            'aktif' => $request->boolean('aktif'),
        ];
    }

    public function terapkanDiskonMassal(Request $request): RedirectResponse
    {
        $tervalidasi = $request->validate([
            'target_kategori' => ['required', Rule::in(['semua', ...array_keys(Tema::KATEGORI_TERSEDIA)])],
            'diskon_tipe' => ['required', Rule::in(['nominal', 'persen'])],
            'diskon_nilai' => ['required', 'integer', 'min:1', 'max:100000000'],
        ], [
            'diskon_nilai.required' => 'Nilai diskon massal wajib diisi.',
            'diskon_nilai.min' => 'Nilai diskon minimal 1.',
        ]);

        if ($tervalidasi['diskon_tipe'] === 'persen' && (int) $tervalidasi['diskon_nilai'] > 100) {
            return back()
                ->withErrors(['diskon_nilai' => 'Diskon persentase maksimal 100%.'])
                ->withInput();
        }

        $query = Tema::query();
        if ($tervalidasi['target_kategori'] !== 'semua') {
            $query->where('kategori', $tervalidasi['target_kategori']);
        }

        $jumlahTerpengaruh = $query->update([
            'diskon_tipe' => $tervalidasi['diskon_tipe'],
            'diskon_nilai' => (int) $tervalidasi['diskon_nilai'],
        ]);

        $labelTarget = $tervalidasi['target_kategori'] === 'semua'
            ? 'semua tema katalog'
            : 'tema kategori '.(Tema::KATEGORI_TERSEDIA[$tervalidasi['target_kategori']] ?? $tervalidasi['target_kategori']);

        return redirect()
            ->route('admin.tema.index')
            ->with('sukses', "Diskon berhasil diterapkan ke {$jumlahTerpengaruh} {$labelTarget}.");
    }

    public function resetDiskonMassal(Request $request): RedirectResponse
    {
        $targetKategori = (string) $request->input('target_kategori', 'semua');

        $query = Tema::query();
        if (array_key_exists($targetKategori, Tema::KATEGORI_TERSEDIA)) {
            $query->where('kategori', $targetKategori);
        }

        $jumlah = $query->update([
            'diskon_tipe' => null,
            'diskon_nilai' => 0,
        ]);

        return redirect()
            ->route('admin.tema.index')
            ->with('sukses', "Diskon katalog pada {$jumlah} tema berhasil dikembalikan ke harga normal.");
    }

    public function destroy(Tema $tema, PengolahGambarService $pengolahGambar): RedirectResponse
    {
        if ($tema->undangan()->exists()) {
            return back()->withErrors(['tema' => 'Tema tidak dapat dihapus karena masih digunakan oleh undangan client.']);
        }

        $pengolahGambar->hapusBerkasJikaAda($tema->gambar_pratinjau);
        $tema->delete();

        return redirect()
            ->route('admin.tema.index')
            ->with('sukses', 'Tema berhasil dihapus dari katalog.');
    }
}
