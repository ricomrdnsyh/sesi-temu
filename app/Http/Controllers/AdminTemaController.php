<?php

namespace App\Http\Controllers;

use App\Models\Tema;
use App\Services\PengolahGambarService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminTemaController extends Controller
{
    public function index(): View
    {
        $daftarTema = Tema::withCount('undangan')->orderBy('id')->get();

        return view('admin.tema.index', [
            'daftarTema' => $daftarTema,
        ]);
    }

    public function create(): View
    {
        return view('admin.tema.form', [
            'tema' => new Tema(['kategori' => 'modern', 'aktif' => true]),
            'modeEdit' => false,
        ]);
    }

    public function store(Request $request, PengolahGambarService $pengolahGambar): RedirectResponse
    {
        $tervalidasi = $request->validate([
            'nama_tema' => ['required', 'string', 'max:120'],
            'slug' => ['nullable', 'string', 'max:120'],
            'kategori' => ['required', Rule::in(['modern', 'adat', 'islami'])],
            'lokasi_view' => ['required', 'string', 'max:150'],
            'gambar_pratinjau' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $slug = Str::slug((string) ($tervalidasi['slug'] ?: $tervalidasi['nama_tema']));
        $request->merge(['slug_normalisasi' => $slug]);
        $request->validate([
            'slug_normalisasi' => ['required', Rule::unique('tema', 'slug')],
        ], [
            'slug_normalisasi.unique' => "Slug tema {$slug} sudah terdaftar.",
        ]);

        $pathGambar = null;
        if ($request->hasFile('gambar_pratinjau')) {
            $pathGambar = $pengolahGambar->simpanGambarTema($request->file('gambar_pratinjau'), $slug);
        }

        Tema::create([
            'nama_tema' => $tervalidasi['nama_tema'],
            'slug' => $slug,
            'kategori' => $tervalidasi['kategori'],
            'lokasi_view' => $tervalidasi['lokasi_view'],
            'gambar_pratinjau' => $pathGambar,
            'aktif' => $request->boolean('aktif'),
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
        ]);
    }

    public function update(Request $request, Tema $tema, PengolahGambarService $pengolahGambar): RedirectResponse
    {
        $tervalidasi = $request->validate([
            'nama_tema' => ['required', 'string', 'max:120'],
            'slug' => ['nullable', 'string', 'max:120'],
            'kategori' => ['required', Rule::in(['modern', 'adat', 'islami'])],
            'lokasi_view' => ['required', 'string', 'max:150'],
            'gambar_pratinjau' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $slug = Str::slug((string) ($tervalidasi['slug'] ?: $tervalidasi['nama_tema']));
        $request->merge(['slug_normalisasi' => $slug]);
        $request->validate([
            'slug_normalisasi' => ['required', Rule::unique('tema', 'slug')->ignore($tema->id)],
        ], [
            'slug_normalisasi.unique' => "Slug tema {$slug} sudah terdaftar.",
        ]);

        $pathGambar = $tema->gambar_pratinjau;
        if ($request->hasFile('gambar_pratinjau')) {
            $pengolahGambar->hapusBerkasJikaAda($tema->gambar_pratinjau);
            $pathGambar = $pengolahGambar->simpanGambarTema($request->file('gambar_pratinjau'), $slug);
        }

        $tema->update([
            'nama_tema' => $tervalidasi['nama_tema'],
            'slug' => $slug,
            'kategori' => $tervalidasi['kategori'],
            'lokasi_view' => $tervalidasi['lokasi_view'],
            'gambar_pratinjau' => $pathGambar,
            'aktif' => $request->boolean('aktif'),
        ]);

        return redirect()
            ->route('admin.tema.index')
            ->with('sukses', "Tema {$tema->nama_tema} berhasil diperbarui.");
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
