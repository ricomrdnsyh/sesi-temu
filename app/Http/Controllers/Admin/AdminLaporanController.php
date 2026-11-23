<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BukuTamu;
use App\Models\Pengguna;
use App\Models\Tema;
use App\Models\Transaksi;
use App\Models\Undangan;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminLaporanController extends Controller
{
    public function index(): View
    {
        $awalBulanIni = now()->startOfMonth();

        $totalOmzet = (int) Transaksi::where('status', 'lunas')->sum('total_bayar');
        $omzetBulanIni = (int) Transaksi::where('status', 'lunas')
            ->where('created_at', '>=', $awalBulanIni)
            ->sum('total_bayar');
        $nominalPending = (int) Transaksi::whereIn('status', ['menunggu_pembayaran', 'menunggu_verifikasi'])
            ->sum('total_bayar');

        $transaksiLunasCount = Transaksi::where('status', 'lunas')->count();
        $transaksiMandiri = Transaksi::where('status', 'lunas')->where('paket', 'mandiri')->count();
        $transaksiTerimaBeres = Transaksi::where('status', 'lunas')->where('paket', 'terima_beres')->count();

        $temaTerlaris = Tema::withCount('undangan')
            ->orderByDesc('undangan_count')
            ->orderBy('id')
            ->get();

        $distribusiKategori = collect(Tema::KATEGORI_TERSEDIA)->map(function (string $label, string $kode) use ($temaTerlaris): array {
            $temaDiKategori = $temaTerlaris->filter(fn (Tema $tema): bool => $tema->kategoriKode() === $kode);

            return [
                'kode' => $kode,
                'label' => $label,
                'jumlah_tema' => $temaDiKategori->count(),
                'jumlah_undangan' => (int) $temaDiKategori->sum('undangan_count'),
            ];
        });

        $batasAwal6Bulan = now()->subMonths(5)->startOfMonth();
        $undangan6Bulan = Undangan::where('created_at', '>=', $batasAwal6Bulan)->get(['id', 'created_at']);
        $transaksi6Bulan = Transaksi::where('status', 'lunas')
            ->where('created_at', '>=', $batasAwal6Bulan)
            ->get(['id', 'total_bayar', 'created_at']);

        $rekapBulanan = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = now()->subMonths($i);
            $kunciBulan = $bulan->format('Y-m');

            $jumlahUndangan = $undangan6Bulan->filter(
                fn (Undangan $u): bool => $u->created_at?->format('Y-m') === $kunciBulan
            )->count();

            $omzet = (int) $transaksi6Bulan->filter(
                fn (Transaksi $t): bool => $t->created_at?->format('Y-m') === $kunciBulan
            )->sum('total_bayar');

            $rekapBulanan[] = [
                'label' => $bulan->translatedFormat('M Y'),
                'undangan' => $jumlahUndangan,
                'omzet' => $omzet,
            ];
        }

        $undanganAkanKedaluwarsa = Undangan::with(['pengguna', 'tema'])
            ->where('status_publikasi', true)
            ->whereNotNull('berlaku_sampai')
            ->where('berlaku_sampai', '<=', now()->addDays(14))
            ->orderBy('berlaku_sampai')
            ->get();

        return view('admin.laporan.index', [
            'totalOmzet' => $totalOmzet,
            'omzetBulanIni' => $omzetBulanIni,
            'nominalPending' => $nominalPending,
            'transaksiLunasCount' => $transaksiLunasCount,
            'transaksiMandiri' => $transaksiMandiri,
            'transaksiTerimaBeres' => $transaksiTerimaBeres,
            'totalClient' => Pengguna::where('peran', 'client')->count(),
            'totalUndangan' => Undangan::count(),
            'totalUcapan' => BukuTamu::count(),
            'temaTerlaris' => $temaTerlaris,
            'distribusiKategori' => $distribusiKategori,
            'rekapBulanan' => $rekapBulanan,
            'undanganAkanKedaluwarsa' => $undanganAkanKedaluwarsa,
        ]);
    }

    public function eksporCsv(): StreamedResponse
    {
        $namaFile = 'laporan-transaksi-sesitemu-'.now()->format('Y-m-d').'.csv';

        return response()->streamDownload(function (): void {
            $handle = fopen('php://output', 'w');
            if ($handle === false) {
                return;
            }

            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, [
                'Kode Invoice',
                'Tanggal',
                'Client',
                'Email',
                'Slug Undangan',
                'Tema',
                'Paket',
                'Harga Tema',
                'Biaya Jasa',
                'Promo',
                'Potongan',
                'Total Bayar',
                'Status',
            ]);

            Transaksi::with(['pengguna', 'undangan', 'tema', 'promo'])
                ->latest()
                ->chunk(200, function ($daftarTransaksi) use ($handle): void {
                    foreach ($daftarTransaksi as $transaksi) {
                        fputcsv($handle, [
                            $transaksi->kode_invoice,
                            $transaksi->created_at?->format('Y-m-d H:i:s') ?? '-',
                            $transaksi->pengguna?->nama ?? '-',
                            $transaksi->pengguna?->email ?? '-',
                            $transaksi->undangan?->slug ?? '-',
                            $transaksi->tema?->nama_tema ?? '-',
                            $transaksi->labelPaket(),
                            $transaksi->harga_tema,
                            $transaksi->biaya_jasa,
                            $transaksi->promo?->kode ?? '-',
                            $transaksi->potongan_promo,
                            $transaksi->total_bayar,
                            $transaksi->labelStatus(),
                        ]);
                    }
                });

            fclose($handle);
        }, $namaFile, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
