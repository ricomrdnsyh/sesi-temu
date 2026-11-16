<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BukuTamu;
use App\Models\Undangan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminBukuTamuController extends Controller
{
    public function index(Request $request): View
    {
        $statusKehadiran = (string) $request->query('status', 'semua');
        $undanganId = (int) $request->query('undangan_id', 0);

        $query = BukuTamu::with(['undangan.tema'])->latest();

        if (in_array($statusKehadiran, ['hadir', 'tidak_hadir', 'ragu'], true)) {
            $query->where('status_kehadiran', $statusKehadiran);
        }

        if ($undanganId > 0) {
            $query->where('undangan_id', $undanganId);
        }

        $daftarUcapan = $query->get();
        $daftarUndangan = Undangan::orderBy('nama_panggilan_pria')->get();

        return view('admin.buku-tamu.index', [
            'daftarUcapan' => $daftarUcapan,
            'daftarUndangan' => $daftarUndangan,
            'statusKehadiran' => $statusKehadiran,
            'undanganId' => $undanganId,
            'totalUcapan' => BukuTamu::count(),
            'totalHadir' => BukuTamu::where('status_kehadiran', 'hadir')->count(),
            'totalRagu' => BukuTamu::where('status_kehadiran', 'ragu')->count(),
            'totalTidakHadir' => BukuTamu::where('status_kehadiran', 'tidak_hadir')->count(),
        ]);
    }

    public function destroy(BukuTamu $ucapan): RedirectResponse
    {
        $namaTamu = $ucapan->nama_tamu;
        $ucapan->delete();

        return back()->with('sukses', "Ucapan dari \"{$namaTamu}\" berhasil dihapus dari buku tamu.");
    }
}
