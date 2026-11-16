<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Models\Tema;
use App\Models\Transaksi;
use App\Models\Undangan;
use App\Services\LayananTransaksiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminTransaksiController extends Controller
{
    public function index(Request $request): View
    {
        $status = (string) $request->query('status', 'semua');

        $query = Transaksi::with(['undangan', 'pengguna', 'tema', 'promo', 'verifikator'])->latest();

        if (array_key_exists($status, Transaksi::STATUS_TERSEDIA)) {
            $query->where('status', $status);
        }

        $daftarTransaksi = $query->get();

        $totalOmzetLunas = (int) Transaksi::where('status', 'lunas')->sum('total_bayar');
        $jumlahMenungguVerifikasi = Transaksi::where('status', 'menunggu_verifikasi')->count();
        $jumlahMenungguBayar = Transaksi::where('status', 'menunggu_pembayaran')->count();
        $jumlahLunas = Transaksi::where('status', 'lunas')->count();

        $daftarUndangan = Undangan::with(['pengguna', 'tema'])->latest()->get();
        $daftarTema = Tema::where('aktif', true)->orderBy('id')->get();
        $daftarPromo = Promo::where('aktif', true)->orderBy('kode')->get();

        return view('admin.transaksi.index', [
            'daftarTransaksi' => $daftarTransaksi,
            'status' => $status,
            'totalOmzetLunas' => $totalOmzetLunas,
            'jumlahMenungguVerifikasi' => $jumlahMenungguVerifikasi,
            'jumlahMenungguBayar' => $jumlahMenungguBayar,
            'jumlahLunas' => $jumlahLunas,
            'daftarUndangan' => $daftarUndangan,
            'daftarTema' => $daftarTema,
            'daftarPromo' => $daftarPromo,
        ]);
    }

    public function store(Request $request, LayananTransaksiService $layanan): RedirectResponse
    {
        $tervalidasi = $request->validate([
            'undangan_id' => ['required', 'exists:undangan,id'],
            'tema_id' => ['required', 'exists:tema,id'],
            'paket' => ['required', Rule::in(['mandiri', 'terima_beres'])],
            'kode_promo' => ['nullable', 'string', 'max:40'],
            'catatan_admin' => ['nullable', 'string', 'max:500'],
            'langsung_lunas' => ['nullable', 'boolean'],
        ], [
            'undangan_id.required' => 'Pilih undangan client terlebih dahulu.',
            'tema_id.required' => 'Pilih tema undangan.',
        ]);

        $hasilPromo = $layanan->validasiKodePromo($tervalidasi['kode_promo'] ?? null);
        if ($hasilPromo['error'] !== null) {
            return back()->withErrors(['kode_promo' => $hasilPromo['error']])->withInput();
        }

        $undangan = Undangan::with('pengguna')->findOrFail((int) $tervalidasi['undangan_id']);
        $tema = Tema::findOrFail((int) $tervalidasi['tema_id']);

        $transaksi = $layanan->buatTransaksi(
            $undangan,
            $undangan->pengguna,
            $tema,
            $tervalidasi['paket'],
            $hasilPromo['promo'],
            null,
            $request->boolean('langsung_lunas'),
            $request->user(),
            $tervalidasi['catatan_admin'] ?? null
        );

        return back()->with('sukses', "Transaksi {$transaksi->kode_invoice} berhasil dicatat (".Tema::formatRupiah($transaksi->total_bayar).').');
    }

    public function verifikasi(
        Request $request,
        Transaksi $transaksi,
        LayananTransaksiService $layanan
    ): RedirectResponse {
        $layanan->verifikasiLunas(
            $transaksi,
            $request->user(),
            $request->input('catatan_admin') ? trim((string) $request->input('catatan_admin')) : null
        );

        return back()->with('sukses', "Transaksi {$transaksi->kode_invoice} diverifikasi Lunas & undangan otomatis aktif!");
    }

    public function tolak(
        Request $request,
        Transaksi $transaksi,
        LayananTransaksiService $layanan
    ): RedirectResponse {
        $alasan = trim((string) $request->input('catatan_admin', '')) ?: 'Bukti pembayaran belum valid atau dana belum diterima.';

        $layanan->tolakTransaksi($transaksi, $request->user(), $alasan);

        return back()->with('sukses', "Transaksi {$transaksi->kode_invoice} ditandai Ditolak.");
    }
}
