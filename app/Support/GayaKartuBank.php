<?php

namespace App\Support;

use Illuminate\Support\Str;

class GayaKartuBank
{
    /**
     * Definisi tampilan kartu bank & e-wallet populer di Indonesia.
     * Urutan disusun dari kata kunci paling spesifik agar pencocokan akurat.
     *
     * @return list<array{
     *     kode: string,
     *     label_cepat: string,
     *     kata_kunci: list<string>,
     *     singkatan: string,
     *     subjudul: string,
     *     jenis: 'bank'|'ewallet',
     *     label_jenis: string,
     *     warna_utama: string,
     *     gradient_css: string,
     *     aksen_hex: string,
     *     chip_gaya: 'emas'|'perak'|'wallet',
     *     logo_url: string
     * }>
     */
    public static function katalog(): array
    {
        $daftar = [
            [
                'kode' => 'bca-syariah',
                'label_cepat' => 'BCA Syariah',
                'kata_kunci' => ['bca syariah', 'bsya'],
                'singkatan' => 'BCA SYARIAH',
                'subjudul' => 'Bank BCA Syariah',
                'jenis' => 'bank',
                'label_jenis' => 'Kartu Syariah',
                'warna_utama' => '#006266',
                'gradient_css' => 'linear-gradient(135deg, #0A3D62 0%, #006266 58%, #079992 100%)',
                'aksen_hex' => '#38BDF8',
                'chip_gaya' => 'emas',
            ],
            [
                'kode' => 'blu',
                'label_cepat' => 'blu by BCA',
                'kata_kunci' => ['blu by bca', 'blu bca', 'blu'],
                'singkatan' => 'blu',
                'subjudul' => 'blu by BCA Digital',
                'jenis' => 'bank',
                'label_jenis' => 'Bank Digital',
                'warna_utama' => '#00A8CC',
                'gradient_css' => 'linear-gradient(135deg, #0077B6 0%, #00B4D8 58%, #005F8A 100%)',
                'aksen_hex' => '#90E0EF',
                'chip_gaya' => 'perak',
            ],
            [
                'kode' => 'bca',
                'label_cepat' => 'BCA',
                'kata_kunci' => ['bca', 'central asia'],
                'singkatan' => 'BCA',
                'subjudul' => 'Bank Central Asia',
                'jenis' => 'bank',
                'label_jenis' => 'Kartu Debit',
                'warna_utama' => '#0057B8',
                'gradient_css' => 'linear-gradient(135deg, #003373 0%, #0057B8 55%, #002352 100%)',
                'aksen_hex' => '#60A5FA',
                'chip_gaya' => 'emas',
            ],
            [
                'kode' => 'mandiri',
                'label_cepat' => 'Mandiri',
                'kata_kunci' => ['mandiri', 'livin'],
                'singkatan' => 'mandiri',
                'subjudul' => 'Bank Mandiri',
                'jenis' => 'bank',
                'label_jenis' => 'Kartu Debit',
                'warna_utama' => '#003D79',
                'gradient_css' => 'linear-gradient(135deg, #002855 0%, #00428D 55%, #091E3A 100%)',
                'aksen_hex' => '#FDB913',
                'chip_gaya' => 'emas',
            ],
            [
                'kode' => 'bni',
                'label_cepat' => 'BNI',
                'kata_kunci' => ['bni', 'negara indonesia', 'wondr'],
                'singkatan' => 'BNI',
                'subjudul' => 'Bank Negara Indonesia',
                'jenis' => 'bank',
                'label_jenis' => 'Kartu Debit',
                'warna_utama' => '#005E6A',
                'gradient_css' => 'linear-gradient(135deg, #004E59 0%, #006F7A 55%, #003840 100%)',
                'aksen_hex' => '#F15A22',
                'chip_gaya' => 'emas',
            ],
            [
                'kode' => 'bri',
                'label_cepat' => 'BRI',
                'kata_kunci' => ['bri', 'brimo', 'rakyat indonesia'],
                'singkatan' => 'BANK BRI',
                'subjudul' => 'Bank Rakyat Indonesia',
                'jenis' => 'bank',
                'label_jenis' => 'Kartu Debit',
                'warna_utama' => '#00529C',
                'gradient_css' => 'linear-gradient(135deg, #003E7E 0%, #005AA7 58%, #002854 100%)',
                'aksen_hex' => '#F37021',
                'chip_gaya' => 'perak',
            ],
            [
                'kode' => 'bsi',
                'label_cepat' => 'BSI',
                'kata_kunci' => ['bsi', 'syariah indonesia'],
                'singkatan' => 'BSI',
                'subjudul' => 'Bank Syariah Indonesia',
                'jenis' => 'bank',
                'label_jenis' => 'Kartu Syariah',
                'warna_utama' => '#00A39D',
                'gradient_css' => 'linear-gradient(135deg, #005C58 0%, #008B84 55%, #00423F 100%)',
                'aksen_hex' => '#FBBF24',
                'chip_gaya' => 'emas',
            ],
            [
                'kode' => 'cimb',
                'label_cepat' => 'CIMB Niaga',
                'kata_kunci' => ['cimb', 'niaga', 'octo'],
                'singkatan' => 'CIMB NIAGA',
                'subjudul' => 'Bank CIMB Niaga',
                'jenis' => 'bank',
                'label_jenis' => 'Kartu Debit',
                'warna_utama' => '#9E111D',
                'gradient_css' => 'linear-gradient(135deg, #6E0A12 0%, #9E111D 55%, #4A050B 100%)',
                'aksen_hex' => '#FCA5A5',
                'chip_gaya' => 'perak',
            ],
            [
                'kode' => 'permata',
                'label_cepat' => 'Permata',
                'kata_kunci' => ['permata'],
                'singkatan' => 'PermataBank',
                'subjudul' => 'Bank Permata',
                'jenis' => 'bank',
                'label_jenis' => 'Kartu Debit',
                'warna_utama' => '#1F7A36',
                'gradient_css' => 'linear-gradient(135deg, #164A21 0%, #277937 55%, #0D3115 100%)',
                'aksen_hex' => '#86EFAC',
                'chip_gaya' => 'emas',
            ],
            [
                'kode' => 'danamon',
                'label_cepat' => 'Danamon',
                'kata_kunci' => ['danamon'],
                'singkatan' => 'Danamon',
                'subjudul' => 'Bank Danamon',
                'jenis' => 'bank',
                'label_jenis' => 'Kartu Debit',
                'warna_utama' => '#E67E00',
                'gradient_css' => 'linear-gradient(135deg, #7C2D12 0%, #B45309 55%, #521E0A 100%)',
                'aksen_hex' => '#FDE047',
                'chip_gaya' => 'emas',
            ],
            [
                'kode' => 'ocbc',
                'label_cepat' => 'OCBC NISP',
                'kata_kunci' => ['ocbc', 'nisp'],
                'singkatan' => 'OCBC',
                'subjudul' => 'Bank OCBC Indonesia',
                'jenis' => 'bank',
                'label_jenis' => 'Kartu Debit',
                'warna_utama' => '#D71920',
                'gradient_css' => 'linear-gradient(135deg, #7F1D1D 0%, #B91C1C 55%, #450A0A 100%)',
                'aksen_hex' => '#FCA5A5',
                'chip_gaya' => 'perak',
            ],
            [
                'kode' => 'maybank',
                'label_cepat' => 'Maybank',
                'kata_kunci' => ['maybank'],
                'singkatan' => 'Maybank',
                'subjudul' => 'Maybank Indonesia',
                'jenis' => 'bank',
                'label_jenis' => 'Kartu Debit',
                'warna_utama' => '#111827',
                'gradient_css' => 'linear-gradient(135deg, #CA8A04 0%, #EAB308 55%, #854D0E 100%)',
                'aksen_hex' => '#FFC800',
                'chip_gaya' => 'emas',
            ],
            [
                'kode' => 'mega',
                'label_cepat' => 'Bank Mega',
                'kata_kunci' => ['mega'],
                'singkatan' => 'BANK MEGA',
                'subjudul' => 'Bank Mega Indonesia',
                'jenis' => 'bank',
                'label_jenis' => 'Kartu Debit',
                'warna_utama' => '#B45309',
                'gradient_css' => 'linear-gradient(135deg, #334155 0%, #92400E 55%, #1E293B 100%)',
                'aksen_hex' => '#FBBF24',
                'chip_gaya' => 'emas',
            ],
            [
                'kode' => 'btpn',
                'label_cepat' => 'BTPN',
                'kata_kunci' => ['btpn', 'smbc'],
                'singkatan' => 'BTPN',
                'subjudul' => 'Bank BTPN',
                'jenis' => 'bank',
                'label_jenis' => 'Kartu Debit',
                'warna_utama' => '#EA580C',
                'gradient_css' => 'linear-gradient(135deg, #9A3412 0%, #EA580C 55%, #7C2D12 100%)',
                'aksen_hex' => '#FDBA74',
                'chip_gaya' => 'emas',
            ],
            [
                'kode' => 'muamalat',
                'label_cepat' => 'Muamalat',
                'kata_kunci' => ['muamalat'],
                'singkatan' => 'Muamalat',
                'subjudul' => 'Bank Muamalat',
                'jenis' => 'bank',
                'label_jenis' => 'Kartu Syariah',
                'warna_utama' => '#5B2D86',
                'gradient_css' => 'linear-gradient(135deg, #4C1D95 0%, #7E22CE 55%, #3B0764 100%)',
                'aksen_hex' => '#E9D5FF',
                'chip_gaya' => 'emas',
            ],
            [
                'kode' => 'seabank',
                'label_cepat' => 'SeaBank',
                'kata_kunci' => ['seabank', 'sea bank'],
                'singkatan' => 'SeaBank',
                'subjudul' => 'SeaBank Indonesia',
                'jenis' => 'bank',
                'label_jenis' => 'Bank Digital',
                'warna_utama' => '#F95700',
                'gradient_css' => 'linear-gradient(135deg, #C84000 0%, #F95700 55%, #9B2E00 100%)',
                'aksen_hex' => '#FED7AA',
                'chip_gaya' => 'perak',
            ],
            [
                'kode' => 'jenius',
                'label_cepat' => 'Jenius',
                'kata_kunci' => ['jenius'],
                'singkatan' => 'Jenius',
                'subjudul' => 'Jenius BTPN',
                'jenis' => 'bank',
                'label_jenis' => 'Bank Digital',
                'warna_utama' => '#00A4E4',
                'gradient_css' => 'linear-gradient(135deg, #0077B6 0%, #00A4E4 55%, #005A8D 100%)',
                'aksen_hex' => '#BAE6FD',
                'chip_gaya' => 'perak',
            ],
            [
                'kode' => 'jago',
                'label_cepat' => 'Bank Jago',
                'kata_kunci' => ['jago'],
                'singkatan' => 'Jago',
                'subjudul' => 'Bank Jago',
                'jenis' => 'bank',
                'label_jenis' => 'Bank Digital',
                'warna_utama' => '#6D28D9',
                'gradient_css' => 'linear-gradient(135deg, #42127A 0%, #6D28D9 55%, #2E0959 100%)',
                'aksen_hex' => '#FBBF24',
                'chip_gaya' => 'emas',
            ],
            [
                'kode' => 'btn',
                'label_cepat' => 'BTN',
                'kata_kunci' => ['btn', 'tabungan negara'],
                'singkatan' => 'BTN',
                'subjudul' => 'Bank Tabungan Negara',
                'jenis' => 'bank',
                'label_jenis' => 'Kartu Debit',
                'warna_utama' => '#00529C',
                'gradient_css' => 'linear-gradient(135deg, #1E3A8A 0%, #1D4ED8 55%, #172554 100%)',
                'aksen_hex' => '#FACC15',
                'chip_gaya' => 'emas',
            ],
            [
                'kode' => 'bjb',
                'label_cepat' => 'Bank BJB',
                'kata_kunci' => ['bjb'],
                'singkatan' => 'bank bjb',
                'subjudul' => 'Bank BJB',
                'jenis' => 'bank',
                'label_jenis' => 'Kartu Daerah',
                'warna_utama' => '#0284C7',
                'gradient_css' => 'linear-gradient(135deg, #075985 0%, #0284C7 55%, #0C4A6E 100%)',
                'aksen_hex' => '#FDE047',
                'chip_gaya' => 'perak',
            ],
            [
                'kode' => 'gopay',
                'label_cepat' => 'GoPay',
                'kata_kunci' => ['gopay', 'gojek'],
                'singkatan' => 'gopay',
                'subjudul' => 'Dompet Digital GoPay',
                'jenis' => 'ewallet',
                'label_jenis' => 'E-Wallet',
                'warna_utama' => '#00AED6',
                'gradient_css' => 'linear-gradient(135deg, #00749B 0%, #00AED6 55%, #005270 100%)',
                'aksen_hex' => '#A5F3FC',
                'chip_gaya' => 'wallet',
            ],
            [
                'kode' => 'ovo',
                'label_cepat' => 'OVO',
                'kata_kunci' => ['ovo'],
                'singkatan' => 'OVO',
                'subjudul' => 'Dompet Digital OVO',
                'jenis' => 'ewallet',
                'label_jenis' => 'E-Wallet',
                'warna_utama' => '#4C3494',
                'gradient_css' => 'linear-gradient(135deg, #3D1F70 0%, #5B2E9C 55%, #27124C 100%)',
                'aksen_hex' => '#C4B5FD',
                'chip_gaya' => 'wallet',
            ],
            [
                'kode' => 'dana',
                'label_cepat' => 'DANA',
                'kata_kunci' => ['dana'],
                'singkatan' => 'DANA',
                'subjudul' => 'Dompet Digital DANA',
                'jenis' => 'ewallet',
                'label_jenis' => 'E-Wallet',
                'warna_utama' => '#118EEA',
                'gradient_css' => 'linear-gradient(135deg, #0066C0 0%, #118EEA 55%, #004A8C 100%)',
                'aksen_hex' => '#BAE6FD',
                'chip_gaya' => 'wallet',
            ],
            [
                'kode' => 'shopeepay',
                'label_cepat' => 'ShopeePay',
                'kata_kunci' => ['shopeepay', 'shopee'],
                'singkatan' => 'ShopeePay',
                'subjudul' => 'Dompet Digital ShopeePay',
                'jenis' => 'ewallet',
                'label_jenis' => 'E-Wallet',
                'warna_utama' => '#EE4D2D',
                'gradient_css' => 'linear-gradient(135deg, #C92F14 0%, #EE4D2D 55%, #9B1E08 100%)',
                'aksen_hex' => '#FED7AA',
                'chip_gaya' => 'wallet',
            ],
            [
                'kode' => 'linkaja',
                'label_cepat' => 'LinkAja',
                'kata_kunci' => ['linkaja', 'link aja'],
                'singkatan' => 'LinkAja',
                'subjudul' => 'Dompet Digital LinkAja',
                'jenis' => 'ewallet',
                'label_jenis' => 'E-Wallet',
                'warna_utama' => '#E11D48',
                'gradient_css' => 'linear-gradient(135deg, #991B1B 0%, #E11D48 55%, #7F1D1D 100%)',
                'aksen_hex' => '#FECDD3',
                'chip_gaya' => 'wallet',
            ],
            [
                'kode' => 'qris',
                'label_cepat' => 'QRIS',
                'kata_kunci' => ['qris'],
                'singkatan' => 'QRIS',
                'subjudul' => 'Pembayaran QRIS',
                'jenis' => 'ewallet',
                'label_jenis' => 'QR Payment',
                'warna_utama' => '#1F2937',
                'gradient_css' => 'linear-gradient(135deg, #111827 0%, #374151 55%, #0F172A 100%)',
                'aksen_hex' => '#E5E7EB',
                'chip_gaya' => 'wallet',
            ],
        ];

        return array_map(static function (array $item): array {
            $item['logo_url'] = asset("aset-bank/{$item['kode']}.svg");

            return $item;
        }, $daftar);
    }

    /**
     * Daftar opsi dropdown Bank / E-Wallet terurut populer.
     *
     * @return list<array<string, mixed>>
     */
    public static function opsiDropdown(): array
    {
        $urutanKode = [
            'bca', 'mandiri', 'bni', 'bri', 'bsi', 'cimb', 'permata', 'danamon',
            'ocbc', 'maybank', 'mega', 'btpn', 'muamalat', 'blu', 'seabank', 'jenius',
            'jago', 'btn', 'bjb', 'bca-syariah', 'gopay', 'ovo', 'dana', 'shopeepay',
            'linkaja', 'qris',
        ];

        $byKode = [];
        foreach (self::katalog() as $item) {
            $byKode[$item['kode']] = $item;
        }

        $hasil = [];
        foreach ($urutanKode as $kode) {
            if (isset($byKode[$kode])) {
                $hasil[] = $byKode[$kode];
            }
        }

        return $hasil;
    }

    /**
     * @return array<string, mixed>
     */
    public static function gayaBawaan(?string $namaBank = null): array
    {
        $namaBersih = trim((string) $namaBank);
        $singkatan = $namaBersih !== '' ? Str::upper(Str::limit($namaBersih, 14, '')) : 'BANK / E-WALLET';

        return [
            'kode' => 'bawaan',
            'label_cepat' => $namaBersih !== '' ? $namaBersih : 'Rekening',
            'kata_kunci' => [],
            'singkatan' => $singkatan,
            'subjudul' => $namaBersih !== '' ? $namaBersih : 'Amplop Digital',
            'jenis' => 'bank',
            'label_jenis' => 'Amplop Digital',
            'warna_utama' => '#334155',
            'gradient_css' => 'linear-gradient(135deg, #1F2937 0%, #36454F 55%, #111827 100%)',
            'aksen_hex' => '#D4AF37',
            'chip_gaya' => 'emas',
            'logo_url' => null,
        ];
    }

    public static function untukNamaBank(?string $namaBank): array
    {
        $teks = Str::lower(trim((string) $namaBank));

        if ($teks !== '') {
            foreach (self::katalog() as $item) {
                foreach ($item['kata_kunci'] as $kataKunci) {
                    if (str_contains($teks, $kataKunci)) {
                        return $item;
                    }
                }
            }
        }

        return self::gayaBawaan($namaBank);
    }

    /**
     * @return list<string>
     */
    public static function pilihanCepat(): array
    {
        return ['BCA', 'Mandiri', 'BRI', 'BNI', 'BSI', 'SeaBank', 'Bank Jago', 'GoPay', 'OVO', 'DANA', 'ShopeePay'];
    }

    /**
     * Format nomor rekening agar mudah dibaca seperti angka timbul kartu ATM.
     */
    public static function formatNomor(?string $nomor): string
    {
        $bersih = trim((string) $nomor);
        if ($bersih === '') {
            return '•••• •••• ••••';
        }

        if (preg_match('/^\d{6,}$/', $bersih) === 1) {
            return trim(chunk_split($bersih, 4, ' '));
        }

        return $bersih;
    }
}
