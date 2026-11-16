<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MusikLatar;
use App\Models\Undangan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminMusikController extends Controller
{
    public function index(): View
    {
        $daftarMusik = MusikLatar::orderBy('urutan')->orderBy('judul')->get();

        $pemakaianMusik = Undangan::query()
            ->select('musik_latar', DB::raw('count(*) as total'))
            ->whereNotNull('musik_latar')
            ->groupBy('musik_latar')
            ->pluck('total', 'musik_latar');

        return view('admin.musik.index', [
            'daftarMusik' => $daftarMusik,
            'pemakaianMusik' => $pemakaianMusik,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $tervalidasi = $request->validate([
            'judul' => ['required', 'string', 'max:120'],
            'artis' => ['nullable', 'string', 'max:120'],
            'kategori' => ['nullable', 'string', 'max:50'],
            'urutan' => ['nullable', 'integer', 'min:1', 'max:999'],
            'file_audio' => ['required', 'file', 'mimes:mp3,wav,ogg,m4a', 'max:15360'],
        ], [
            'judul.required' => 'Judul lagu wajib diisi.',
            'file_audio.required' => 'File audio musik wajib diunggah.',
            'file_audio.mimes' => 'Format audio harus MP3, WAV, OGG, atau M4A.',
            'file_audio.max' => 'Ukuran file audio maksimal 15 MB.',
        ]);

        $pathTersimpan = $request->file('file_audio')->store('musik', 'public');

        $musik = MusikLatar::create([
            'judul' => $tervalidasi['judul'],
            'artis' => $tervalidasi['artis'] ?? null,
            'kategori' => $tervalidasi['kategori'] ?? 'Umum',
            'path_file' => 'storage/'.$pathTersimpan,
            'aktif' => true,
            'urutan' => (int) ($tervalidasi['urutan'] ?? (MusikLatar::max('urutan') + 1)),
        ]);

        return back()->with('sukses', "Musik \"{$musik->judul}\" berhasil ditambahkan ke katalog audio.");
    }

    public function toggle(MusikLatar $musik): RedirectResponse
    {
        $musik->update([
            'aktif' => ! $musik->aktif,
        ]);

        $statusLabel = $musik->aktif ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('sukses', "Musik \"{$musik->judul}\" berhasil {$statusLabel}.");
    }

    public function destroy(MusikLatar $musik): RedirectResponse
    {
        $judul = $musik->judul;

        if (str_starts_with($musik->path_file, 'storage/')) {
            Storage::disk('public')->delete(substr($musik->path_file, 8));
        }

        $musik->delete();

        return back()->with('sukses', "Musik \"{$judul}\" berhasil dihapus dari daftar.");
    }
}
