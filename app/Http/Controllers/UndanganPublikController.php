<?php

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use App\Models\Undangan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UndanganPublikController extends Controller
{
    public function tampil(string $slug, Request $request): View
    {
        $undangan = Undangan::with(['tema', 'daftarAcara', 'daftarGaleri', 'daftarAmplop', 'bukuTamu'])
            ->where('slug', $slug)
            ->firstOrFail();

        if ($undangan->sudahKedaluwarsa()) {
            return view('undangan-kedaluwarsa', [
                'undangan' => $undangan,
            ]);
        }

        $namaTamu = trim((string) $request->query('to', ''));
        if ($namaTamu === '') {
            $namaTamu = 'Tamu Undangan';
        }

        $lokasiView = $undangan->tema?->lokasi_view ?: 'tema.rustic-floral.index';

        return view($lokasiView, [
            'undangan' => $undangan,
            'namaTamu' => $namaTamu,
            'modeDemo' => false,
            'modePratinjau' => ! $undangan->status_publikasi,
        ]);
    }

    public function simpanUcapan(string $slug, Request $request): RedirectResponse
    {
        $undangan = Undangan::where('slug', $slug)->firstOrFail();

        if ($undangan->sudahKedaluwarsa()) {
            abort(403, 'Masa aktif undangan telah berakhir.');
        }

        $tervalidasi = $request->validate([
            'nama_tamu' => ['required', 'string', 'max:100'],
            'status_kehadiran' => ['required', Rule::in(['hadir', 'tidak_hadir', 'ragu'])],
            'jumlah_tamu' => ['required', 'integer', 'min:1', 'max:20'],
            'ucapan_doa' => ['required', 'string', 'max:1000'],
        ], [
            'nama_tamu.required' => 'Nama tamu wajib diisi.',
            'status_kehadiran.required' => 'Konfirmasi kehadiran wajib dipilih.',
            'ucapan_doa.required' => 'Ucapan & doa restu wajib diisi.',
        ]);

        BukuTamu::create([
            'undangan_id' => $undangan->id,
            'nama_tamu' => $tervalidasi['nama_tamu'],
            'status_kehadiran' => $tervalidasi['status_kehadiran'],
            'jumlah_tamu' => (int) $tervalidasi['jumlah_tamu'],
            'ucapan_doa' => $tervalidasi['ucapan_doa'],
        ]);

        return back()->with('sukses_ucapan', 'Terima kasih! Konfirmasi kehadiran dan ucapan doa Anda telah tersimpan.');
    }
}
