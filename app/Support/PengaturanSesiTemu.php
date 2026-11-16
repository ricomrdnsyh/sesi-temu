<?php

namespace App\Support;

use App\Models\PengaturanPlatform;
use App\Models\Tema;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Throwable;

class PengaturanSesiTemu
{
    private const CACHE_KEY = 'sesitemu.pengaturan_platform';

    /**
     * Nilai bawaan platform bila belum ada baris konfigurasi di database.
     *
     * @var array<string, string>
     */
    public const BAWAAN = [
        'nomor_wa_admin' => '6281234567890',
        'masa_aktif_bulan' => '3',
        'biaya_terima_beres' => '50000',
        'nama_bank_pembayaran' => 'BCA',
        'nomor_rekening_pembayaran' => '1234567890',
        'atas_nama_rekening' => 'PT SesiTemu Digital',
        'catatan_pembayaran' => 'Cantumkan slug undangan pada berita acara transfer lalu unggah bukti transfer atau konfirmasi ke WhatsApp Admin.',
    ];

    /**
     * @return array<string, string>
     */
    public static function semua(): array
    {
        try {
            if (! Schema::hasTable('pengaturan_platform')) {
                return self::BAWAAN;
            }

            /** @var array<string, string> $tersimpan */
            $tersimpan = Cache::remember(self::CACHE_KEY, now()->addHours(12), function (): array {
                return PengaturanPlatform::query()
                    ->pluck('nilai', 'kunci')
                    ->map(fn ($nilai): string => (string) ($nilai ?? ''))
                    ->all();
            });

            return array_merge(self::BAWAAN, array_filter(
                $tersimpan,
                static fn (string $nilai): bool => $nilai !== ''
            ));
        } catch (Throwable) {
            return self::BAWAAN;
        }
    }

    public static function ambil(string $kunci, ?string $bawaan = null): string
    {
        $semua = self::semua();

        if (array_key_exists($kunci, $semua) && $semua[$kunci] !== '') {
            return $semua[$kunci];
        }

        return $bawaan ?? (self::BAWAAN[$kunci] ?? '');
    }

    /**
     * @param  array<string, string|int|null>  $pasangan
     */
    public static function simpanBulk(array $pasangan): void
    {
        foreach ($pasangan as $kunci => $nilai) {
            PengaturanPlatform::updateOrCreate(
                ['kunci' => $kunci],
                ['nilai' => (string) ($nilai ?? '')]
            );
        }

        Cache::forget(self::CACHE_KEY);
    }

    public static function bersihkanCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    public static function nomorWaAdmin(): string
    {
        $bersih = preg_replace('/[^0-9]/', '', self::ambil('nomor_wa_admin')) ?: self::BAWAAN['nomor_wa_admin'];

        if (str_starts_with($bersih, '0')) {
            return '62'.substr($bersih, 1);
        }

        return $bersih;
    }

    public static function urlWaAdmin(string $pesan = ''): string
    {
        $url = 'https://wa.me/'.self::nomorWaAdmin();

        if ($pesan !== '') {
            return $url.'?text='.urlencode($pesan);
        }

        return $url;
    }

    public static function masaAktifBulan(): int
    {
        $bulan = (int) self::ambil('masa_aktif_bulan');

        return $bulan > 0 ? $bulan : 3;
    }

    public static function biayaTerimaBeres(): int
    {
        $biaya = (int) self::ambil('biaya_terima_beres', (string) Tema::BIAYA_JASA_TERIMA_BERES);

        return $biaya >= 0 ? $biaya : Tema::BIAYA_JASA_TERIMA_BERES;
    }

    /**
     * @return array{bank: string, rekening: string, atas_nama: string, catatan: string}
     */
    public static function infoRekening(): array
    {
        return [
            'bank' => self::ambil('nama_bank_pembayaran'),
            'rekening' => self::ambil('nomor_rekening_pembayaran'),
            'atas_nama' => self::ambil('atas_nama_rekening'),
            'catatan' => self::ambil('catatan_pembayaran'),
        ];
    }
}
