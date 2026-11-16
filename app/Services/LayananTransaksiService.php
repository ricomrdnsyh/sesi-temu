<?php

namespace App\Services;

use App\Models\Pengguna;
use App\Models\Promo;
use App\Models\Tema;
use App\Models\Transaksi;
use App\Models\Undangan;
use App\Support\PengaturanSesiTemu;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LayananTransaksiService
{
    /**
     * @return array{harga_tema: int, biaya_jasa: int, potongan_promo: int, total_bayar: int}
     */
    public function hitungRincian(Tema $tema, string $paket, ?Promo $promo = null): array
    {
        $hargaTema = $tema->hargaNominal();
        $biayaJasa = $paket === 'terima_beres' ? PengaturanSesiTemu::biayaTerimaBeres() : 0;
        $subtotal = $hargaTema + $biayaJasa;
        $potongan = $promo ? $promo->hitungPotongan($subtotal) : 0;
        $total = max(0, $subtotal - $potongan);

        return [
            'harga_tema' => $hargaTema,
            'biaya_jasa' => $biayaJasa,
            'potongan_promo' => $potongan,
            'total_bayar' => $total,
        ];
    }

    /**
     * @return array{promo: ?Promo, error: ?string}
     */
    public function validasiKodePromo(?string $kodePromo): array
    {
        $kode = Str::upper(trim((string) $kodePromo));
        if ($kode === '') {
            return ['promo' => null, 'error' => null];
        }

        $promo = Promo::whereRaw('UPPER(kode) = ?', [$kode])->first();
        if (! $promo) {
            return ['promo' => null, 'error' => "Kode promo \"{$kode}\" tidak ditemukan."];
        }

        if (! $promo->layakDigunakan()) {
            return ['promo' => null, 'error' => "Kode promo \"{$kode}\" sudah kedaluwarsa, nonaktif, atau kuota habis."];
        }

        return ['promo' => $promo, 'error' => null];
    }

    public function buatKodeInvoice(): string
    {
        do {
            $kode = 'INV-'.now()->format('Ymd').'-'.Str::upper(Str::random(4));
        } while (Transaksi::where('kode_invoice', $kode)->exists());

        return $kode;
    }

    public function buatTransaksi(
        Undangan $undangan,
        Pengguna $pengguna,
        Tema $tema,
        string $paket,
        ?Promo $promo = null,
        ?UploadedFile $bukti = null,
        bool $langsungLunas = false,
        ?Pengguna $verifikator = null,
        ?string $catatanAdmin = null
    ): Transaksi {
        $rincian = $this->hitungRincian($tema, $paket, $promo);
        $pathBukti = $bukti ? $bukti->store('bukti-pembayaran', 'public') : null;

        return DB::transaction(function () use (
            $undangan,
            $pengguna,
            $tema,
            $promo,
            $paket,
            $rincian,
            $pathBukti,
            $langsungLunas,
            $verifikator,
            $catatanAdmin
        ): Transaksi {
            $statusAwal = $pathBukti !== null ? 'menunggu_verifikasi' : 'menunggu_pembayaran';

            $transaksi = Transaksi::create([
                'kode_invoice' => $this->buatKodeInvoice(),
                'undangan_id' => $undangan->id,
                'pengguna_id' => $pengguna->id,
                'tema_id' => $tema->id,
                'promo_id' => $promo?->id,
                'paket' => $paket,
                'harga_tema' => $rincian['harga_tema'],
                'biaya_jasa' => $rincian['biaya_jasa'],
                'potongan_promo' => $rincian['potongan_promo'],
                'total_bayar' => $rincian['total_bayar'],
                'status' => $statusAwal,
                'bukti_pembayaran' => $pathBukti,
                'catatan_admin' => $catatanAdmin,
            ]);

            if ($langsungLunas && $verifikator !== null) {
                return $this->verifikasiLunas($transaksi, $verifikator, $catatanAdmin);
            }

            return $transaksi;
        });
    }

    public function unggahBukti(Transaksi $transaksi, UploadedFile $bukti): Transaksi
    {
        if ($transaksi->bukti_pembayaran) {
            Storage::disk('public')->delete($transaksi->bukti_pembayaran);
        }

        $pathBaru = $bukti->store('bukti-pembayaran', 'public');

        $transaksi->update([
            'bukti_pembayaran' => $pathBaru,
            'status' => 'menunggu_verifikasi',
            'catatan_admin' => null,
        ]);

        return $transaksi->fresh();
    }

    public function verifikasiLunas(Transaksi $transaksi, Pengguna $admin, ?string $catatan = null): Transaksi
    {
        return DB::transaction(function () use ($transaksi, $admin, $catatan): Transaksi {
            $terkunci = Transaksi::with(['undangan', 'promo'])
                ->lockForUpdate()
                ->findOrFail($transaksi->id);

            $baruPertamaLunas = $terkunci->status !== 'lunas';

            $terkunci->update([
                'status' => 'lunas',
                'catatan_admin' => $catatan ?: $terkunci->catatan_admin,
                'diverifikasi_oleh' => $admin->id,
                'diverifikasi_pada' => now(),
            ]);

            if ($baruPertamaLunas && $terkunci->promo_id !== null && $terkunci->promo !== null) {
                $terkunci->promo->increment('jumlah_terpakai');
            }

            $bulanAktif = PengaturanSesiTemu::masaAktifBulan();

            if ($terkunci->undangan !== null) {
                $terkunci->undangan->update([
                    'tema_id' => $terkunci->tema_id,
                    'status_publikasi' => true,
                    'berlaku_sampai' => now()->addMonths($bulanAktif),
                ]);
            }

            return $terkunci->fresh(['undangan', 'tema', 'pengguna', 'promo']);
        });
    }

    public function tolakTransaksi(Transaksi $transaksi, Pengguna $admin, string $alasan): Transaksi
    {
        $transaksi->update([
            'status' => 'ditolak',
            'catatan_admin' => $alasan,
            'diverifikasi_oleh' => $admin->id,
            'diverifikasi_pada' => now(),
        ]);

        return $transaksi->fresh();
    }
}
