<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Tema;
use App\Models\Undangan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function ringkasan(): View
    {
        $totalClient = Pengguna::where('peran', 'client')->count();
        $totalTemaAktif = Tema::where('aktif', true)->count();

        $totalUndanganAktif = Undangan::where('status_publikasi', true)
            ->where(function ($query): void {
                $query->whereNull('berlaku_sampai')
                    ->orWhere('berlaku_sampai', '>=', now());
            })
            ->count();

        $totalDraft = Undangan::where('status_publikasi', false)->count();

        $totalKedaluwarsa = Undangan::whereNotNull('berlaku_sampai')
            ->where('berlaku_sampai', '<', now())
            ->count();

        $undanganTerbaru = Undangan::with(['pengguna', 'tema'])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.ringkasan', [
            'totalClient' => $totalClient,
            'totalTemaAktif' => $totalTemaAktif,
            'totalUndanganAktif' => $totalUndanganAktif,
            'totalDraft' => $totalDraft,
            'totalKedaluwarsa' => $totalKedaluwarsa,
            'undanganTerbaru' => $undanganTerbaru,
        ]);
    }

    public function daftarUndangan(Request $request): View
    {
        $pencarian = trim((string) $request->query('q', ''));
        $status = (string) $request->query('status', 'semua');

        $query = Undangan::with(['pengguna', 'tema'])->latest();

        if ($pencarian !== '') {
            $query->where(function ($sub) use ($pencarian): void {
                $sub->where('slug', 'like', "%{$pencarian}%")
                    ->orWhere('nama_panggilan_pria', 'like', "%{$pencarian}%")
                    ->orWhere('nama_panggilan_wanita', 'like', "%{$pencarian}%")
                    ->orWhereHas('pengguna', function ($penggunaQuery) use ($pencarian): void {
                        $penggunaQuery->where('nama', 'like', "%{$pencarian}%")
                            ->orWhere('email', 'like', "%{$pencarian}%");
                    });
            });
        }

        if ($status === 'draft') {
            $query->where('status_publikasi', false);
        } elseif ($status === 'aktif') {
            $query->where('status_publikasi', true)
                ->where(function ($sub): void {
                    $sub->whereNull('berlaku_sampai')
                        ->orWhere('berlaku_sampai', '>=', now());
                });
        } elseif ($status === 'kedaluwarsa') {
            $query->whereNotNull('berlaku_sampai')
                ->where('berlaku_sampai', '<', now());
        }

        $daftarUndangan = $query->paginate(15)->withQueryString();

        return view('admin.undangan.index', [
            'daftarUndangan' => $daftarUndangan,
            'pencarian' => $pencarian,
            'status' => $status,
        ]);
    }

    public function aktifkanUndangan(Undangan $undangan): RedirectResponse
    {
        $undangan->update([
            'status_publikasi' => true,
            'berlaku_sampai' => now()->addMonths(3),
        ]);

        return back()->with('sukses', "Undangan sesitemu.id/{$undangan->slug} berhasil diaktifkan selama 3 bulan.");
    }

    public function nonaktifkanUndangan(Undangan $undangan): RedirectResponse
    {
        $undangan->update([
            'status_publikasi' => false,
        ]);

        return back()->with('sukses', "Undangan sesitemu.id/{$undangan->slug} dikembalikan ke mode Draft.");
    }

    public function bersihkanKedaluwarsa(): RedirectResponse
    {
        Artisan::call('undangan:bersihkan-kedaluwarsa');
        $pesan = trim(Artisan::output()) ?: 'Pembersihan storage kedaluwarsa selesai dijalankan.';

        return back()->with('sukses', $pesan);
    }

    public function daftarPengguna(Request $request): View
    {
        $pencarian = trim((string) $request->query('q', ''));

        $query = Pengguna::where('peran', 'client')
            ->withCount('undangan')
            ->latest();

        if ($pencarian !== '') {
            $query->where(function ($sub) use ($pencarian): void {
                $sub->where('nama', 'like', "%{$pencarian}%")
                    ->orWhere('email', 'like', "%{$pencarian}%")
                    ->orWhere('nomor_wa', 'like', "%{$pencarian}%");
            });
        }

        $daftarPengguna = $query->paginate(15)->withQueryString();

        return view('admin.pengguna.index', [
            'daftarPengguna' => $daftarPengguna,
            'pencarian' => $pencarian,
        ]);
    }

    public function resetSandiPengguna(Request $request, Pengguna $pengguna): RedirectResponse
    {
        $tervalidasi = $request->validate([
            'kata_sandi_baru' => ['required', 'string', 'min:8'],
        ], [
            'kata_sandi_baru.required' => 'Kata sandi baru wajib diisi.',
            'kata_sandi_baru.min' => 'Kata sandi baru minimal 8 karakter.',
        ]);

        $pengguna->update([
            'kata_sandi' => Hash::make($tervalidasi['kata_sandi_baru']),
        ]);

        return back()->with('sukses', "Kata sandi untuk {$pengguna->nama} ({$pengguna->email}) berhasil direset.");
    }
}
