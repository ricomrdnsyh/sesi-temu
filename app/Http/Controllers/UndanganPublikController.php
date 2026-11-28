<?php

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use App\Models\TamuUndangan;
use App\Models\Undangan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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

        if (! $undangan->status_publikasi && ! $undangan->bolehDipratinjauOleh($request->user())) {
            return view('undangan-belum-aktif', [
                'undangan' => $undangan,
            ]);
        }

        $kodeTamu = trim((string) $request->query('g', ''));
        $namaTamu = trim((string) $request->query('to', ''));

        $tamuTerdeteksi = null;
        if ($kodeTamu !== '') {
            $tamuTerdeteksi = TamuUndangan::where('undangan_id', $undangan->id)
                ->where('kode_tamu', $kodeTamu)
                ->first();
        } elseif ($namaTamu !== '') {
            $tamuTerdeteksi = TamuUndangan::where('undangan_id', $undangan->id)
                ->whereRaw('LOWER(nama_tamu) = ?', [Str::lower($namaTamu)])
                ->first();
        }

        if ($namaTamu === '' && $tamuTerdeteksi !== null) {
            $namaTamu = $tamuTerdeteksi->nama_tamu;
        }

        if ($namaTamu === '') {
            $namaTamu = 'Tamu Undangan';
        }

        $adalahPratinjauEmbed = $request->boolean('embed') || $request->has('_preview');

        if (! $adalahPratinjauEmbed && $tamuTerdeteksi !== null && $undangan->sudahAktifPublik() && ! $this->adalahBotPratinjau($request->userAgent())) {
            $tamuTerdeteksi->catatkanDibuka();
        }

        $lokasiView = $undangan->tema?->lokasi_view ?: 'tema.rustic-floral.index';

        return view($lokasiView, [
            'undangan' => $undangan,
            'namaTamu' => $namaTamu,
            'modeDemo' => false,
            'modePratinjau' => ! $undangan->status_publikasi,
            'modePratinjauIframe' => $adalahPratinjauEmbed,
        ]);
    }

    private function adalahBotPratinjau(?string $userAgent): bool
    {
        if (! is_string($userAgent) || trim($userAgent) === '') {
            return false;
        }

        $ua = Str::lower($userAgent);
        foreach ([
            'whatsapp',
            'facebookexternalhit',
            'facebot',
            'twitterbot',
            'telegrambot',
            'discordbot',
            'slackbot',
            'linkedinbot',
            'googlebot',
            'bingbot',
            'crawler',
            'spider',
        ] as $tandaBot) {
            if (str_contains($ua, $tandaBot)) {
                return true;
            }
        }

        return false;
    }

    public function simpanUcapan(string $slug, Request $request): RedirectResponse
    {
        $undangan = Undangan::where('slug', $slug)->firstOrFail();

        if ($undangan->sudahKedaluwarsa()) {
            abort(403, 'Masa aktif undangan telah berakhir.');
        }

        if (! $undangan->status_publikasi) {
            abort(403, 'Undangan belum aktif. Fitur RSVP dan ucapan hanya tersedia setelah undangan diaktifkan.');
        }

        $tervalidasi = $request->validate([
            'nama_tamu' => ['required', 'string', 'max:100'],
            'status_kehadiran' => ['required', Rule::in(['hadir', 'tidak_hadir', 'ragu'])],
            'jumlah_tamu' => ['nullable', 'required_if:status_kehadiran,hadir', 'integer', 'min:1', 'max:20'],
            'ucapan_doa' => ['required', 'string', 'max:1000'],
        ], [
            'nama_tamu.required' => 'Nama tamu wajib diisi.',
            'status_kehadiran.required' => 'Konfirmasi kehadiran wajib dipilih.',
            'jumlah_tamu.required_if' => 'Jumlah tamu wajib diisi jika memilih hadir.',
            'ucapan_doa.required' => 'Ucapan & doa restu wajib diisi.',
        ]);

        BukuTamu::create([
            'undangan_id' => $undangan->id,
            'nama_tamu' => $tervalidasi['nama_tamu'],
            'status_kehadiran' => $tervalidasi['status_kehadiran'],
            'jumlah_tamu' => $tervalidasi['status_kehadiran'] === 'hadir'
                ? (int) ($tervalidasi['jumlah_tamu'] ?? 1)
                : 0,
            'ucapan_doa' => $tervalidasi['ucapan_doa'],
        ]);

        return back()->with('sukses_ucapan', 'Terima kasih! Konfirmasi kehadiran dan ucapan doa Anda telah tersimpan.');
    }
}
