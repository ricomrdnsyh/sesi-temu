<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\TamuUndangan;
use Illuminate\Support\Str;
use RuntimeException;
use ZipArchive;

class EksporSpreadsheetTamu
{
    /**
     * Mem-parsing file CSV daftar tamu dengan deteksi otomatis pemisah (koma, titik koma, tab),
     * dukungan UTF-8 BOM, dan deteksi otomatis baris header.
     *
     * @return list<array{nama_tamu: string, nomor_wa: ?string}>
     */
    public static function bacaCsvTamu(string $kontenMentah, int $maksBaris = 500): array
    {
        return array_map(
            static fn (array $item): array => [
                'nama_tamu' => $item['nama_tamu'],
                'nomor_wa' => $item['nomor_wa'],
            ],
            self::bacaCsvTamuDenganLaporan($kontenMentah, $maksBaris)['valid']
        );
    }

    /**
     * Mem-parsing file CSV daftar tamu sekaligus memisahkan baris valid dan baris gagal
     * (Nama Tamu wajib terisi; Nomor WhatsApp & Kategori opsional, namun jika Nomor WhatsApp diisi formatnya harus valid).
     *
     * @return array{
     *     valid: list<array{baris: int, nama_tamu: string, nomor_wa: ?string, kategori: ?string}>,
     *     gagal: list<array{baris: int, alasan: string}>
     * }
     */
    public static function bacaCsvTamuDenganLaporan(string $kontenMentah, int $maksBaris = 500): array
    {
        $konten = preg_replace('/^\xEF\xBB\xBF/', '', $kontenMentah) ?? $kontenMentah;
        $konten = str_replace(["\r\n", "\r"], "\n", $konten);

        if (trim($konten) === '') {
            return ['valid' => [], 'gagal' => []];
        }

        $barisContoh = '';
        foreach (explode("\n", $konten) as $calon) {
            if (trim($calon) !== '') {
                $barisContoh = $calon;
                break;
            }
        }

        $pemisah = self::deteksiPemisahCsv($barisContoh);

        $stream = fopen('php://temp', 'r+');
        if ($stream === false) {
            return ['valid' => [], 'gagal' => []];
        }

        fwrite($stream, $konten);
        rewind($stream);

        $barisAktif = [];
        $nomorBaris = 0;
        while (($kolom = fgetcsv($stream, 0, $pemisah, '"', '\\')) !== false) {
            $nomorBaris++;
            $kosongMurni = $kolom === [null]
                || $kolom === []
                || (count($kolom) === 1 && trim((string) $kolom[0]) === '');
            if ($kosongMurni) {
                continue;
            }

            $barisAktif[] = [
                'baris' => $nomorBaris,
                'kolom' => array_map(static fn ($sel): string => trim((string) $sel), $kolom),
            ];
        }

        fclose($stream);

        if ($barisAktif === []) {
            return ['valid' => [], 'gagal' => []];
        }

        $indeksNama = 0;
        $indeksWa = 1;
        $indeksKategori = 2;
        $mulaiBaris = 0;

        $headerInfo = self::analisisHeaderCsv($barisAktif[0]['kolom']);
        if ($headerInfo['adalah_header']) {
            $indeksNama = $headerInfo['indeks_nama'];
            $indeksWa = $headerInfo['indeks_wa'];
            $indeksKategori = $headerInfo['indeks_kategori'];
            $mulaiBaris = 1;
        }

        $valid = [];
        $gagal = [];
        $total = count($barisAktif);
        for ($i = $mulaiBaris; $i < $total; $i++) {
            $noBaris = $barisAktif[$i]['baris'];
            $row = $barisAktif[$i]['kolom'];
            $nama = trim((string) ($row[$indeksNama] ?? ''));
            $nomorMentah = $indeksWa !== null ? trim((string) ($row[$indeksWa] ?? '')) : '';
            if ($nomorMentah === '-' || $nomorMentah === '—') {
                $nomorMentah = '';
            }
            $kategoriMentah = $indeksKategori !== null ? trim((string) ($row[$indeksKategori] ?? '')) : '';
            if ($kategoriMentah === '-' || $kategoriMentah === '—') {
                $kategoriMentah = '';
            }

            if ($nama === '') {
                $gagal[] = [
                    'baris' => $noBaris,
                    'alasan' => "Baris {$noBaris}: Nama tamu kosong.",
                ];
                continue;
            }

            $nomorNormal = null;
            if ($nomorMentah !== '') {
                $nomorCek = ltrim($nomorMentah, "'");
                $nomorNormal = preg_match('/^[\d\s+\-().]+$/', $nomorCek) === 1
                    ? TamuUndangan::normalisasiNomorWa($nomorCek)
                    : null;

                if ($nomorNormal === null) {
                    $gagal[] = [
                        'baris' => $noBaris,
                        'alasan' => "Baris {$noBaris}: Format Nomor WhatsApp \"{$nomorMentah}\" tidak valid (\"{$nama}\").",
                    ];
                    continue;
                }
            }

            if (count($valid) >= $maksBaris) {
                $gagal[] = [
                    'baris' => $noBaris,
                    'alasan' => "Baris {$noBaris}: Melebihi batas maksimal {$maksBaris} tamu per impor CSV (\"{$nama}\").",
                ];
                continue;
            }

            $valid[] = [
                'baris' => $noBaris,
                'nama_tamu' => Str::limit($nama, 120, ''),
                'nomor_wa' => $nomorNormal,
                'kategori' => $kategoriMentah !== '' ? Str::limit($kategoriMentah, 60, '') : null,
            ];
        }

        return [
            'valid' => $valid,
            'gagal' => $gagal,
        ];
    }

    /**
     * Menghasilkan contoh file CSV siap unduh untuk mempermudah import tamu.
     */
    public static function contohCsv(): string
    {
        $stream = fopen('php://temp', 'r+');
        if ($stream === false) {
            return "\xEF\xBB\xBFNama Tamu,Nomor WhatsApp,Kategori\n";
        }

        fwrite($stream, "\xEF\xBB\xBF");
        fputcsv($stream, ['Nama Tamu', 'Nomor WhatsApp', 'Kategori']);
        fputcsv($stream, ['Budi Santoso', '081234567890', 'Keluarga Pria']);
        fputcsv($stream, ['Siti Aminah & Partner', '085612345678', 'Teman']);
        fputcsv($stream, ['Keluarga Bpk. Hendra', '', 'Kantor']);
        rewind($stream);

        $isi = stream_get_contents($stream) ?: '';
        fclose($stream);

        return $isi;
    }

    /**
     * Melindungi sel teks CSV dari Excel formula injection tanpa merusak nomor telepon valid.
     */
    public static function amankanSelCsv(string $nilai): string
    {
        if ($nilai === '') {
            return '';
        }

        // Biarkan nomor telepon format +62... tetap bersih
        if (preg_match('/^\+\d[\d\s-]*$/', $nilai) === 1) {
            return $nilai;
        }

        $awal = $nilai[0];
        if (in_array($awal, ['=', '+', '-', '@', "\t", "\r"], true)) {
            return "'".$nilai;
        }

        return $nilai;
    }

    /**
     * Membuat file Excel (.xlsx) OOXML valid lengkap dengan header bergaya SesiTemu,
     * freeze pane baris header, auto-filter, lebar kolom, dan format teks aman untuk nomor WA.
     *
     * @param  list<string>  $headers
     * @param  list<list<int|string>>  $rows
     * @param  list<int|float>  $lebarKolom
     * @param  list<int>  $kolomTeks  Indeks kolom (0-based) yang dipaksa berformat teks (@)
     */
    public static function buatXlsx(
        array $headers,
        array $rows,
        array $lebarKolom = [],
        array $kolomTeks = [],
        string $namaSheet = 'Daftar Tamu'
    ): string {
        if (! class_exists(ZipArchive::class)) {
            throw new RuntimeException('Ekstensi PHP ZipArchive diperlukan untuk ekspor Excel (.xlsx).');
        }

        $tempPath = tempnam(sys_get_temp_dir(), 'st_xlsx_');
        if ($tempPath === false) {
            throw new RuntimeException('Gagal membuat berkas sementara untuk ekspor Excel.');
        }

        $zip = new ZipArchive();
        if ($zip->open($tempPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            @unlink($tempPath);
            throw new RuntimeException('Gagal membuka arsip XLSX.');
        }

        $sheetAman = self::bersihkanNamaSheet($namaSheet);
        $zip->addFromString('[Content_Types].xml', self::xmlContentTypes());
        $zip->addFromString('_rels/.rels', self::xmlRootRels());
        $zip->addFromString('xl/workbook.xml', self::xmlWorkbook($sheetAman));
        $zip->addFromString('xl/_rels/workbook.xml.rels', self::xmlWorkbookRels());
        $zip->addFromString('xl/styles.xml', self::xmlStyles());
        $zip->addFromString('xl/worksheets/sheet1.xml', self::xmlWorksheet($headers, $rows, $lebarKolom, $kolomTeks));
        $zip->close();

        $konten = file_get_contents($tempPath);
        @unlink($tempPath);

        if ($konten === false) {
            throw new RuntimeException('Gagal membaca hasil ekspor Excel.');
        }

        return $konten;
    }

    private static function deteksiPemisahCsv(string $barisContoh): string
    {
        $kandidat = [
            ',' => substr_count($barisContoh, ','),
            ';' => substr_count($barisContoh, ';'),
            "\t" => substr_count($barisContoh, "\t"),
        ];

        arsort($kandidat);
        $teratas = (string) array_key_first($kandidat);

        return $kandidat[$teratas] > 0 ? $teratas : ',';
    }

    /**
     * @param  list<string>  $barisPertama
     * @return array{adalah_header: bool, indeks_nama: int, indeks_wa: ?int, indeks_kategori: ?int}
     */
    private static function analisisHeaderCsv(array $barisPertama): array
    {
        $indeksNama = null;
        $indeksWa = null;
        $indeksKategori = null;
        $jumlahCocokHeader = 0;

        foreach ($barisPertama as $idx => $judul) {
            $norm = Str::lower(preg_replace('/[^a-z0-9]+/i', ' ', $judul) ?? '');
            $norm = trim($norm);

            if (in_array($norm, ['nama', 'nama tamu', 'tamu', 'name', 'guest', 'guest name', 'full name', 'nama lengkap'], true)) {
                $indeksNama ??= $idx;
                $jumlahCocokHeader++;
            } elseif (in_array($norm, ['wa', 'no wa', 'nomor wa', 'nomor whatsapp', 'whatsapp', 'no hp', 'hp', 'telepon', 'telp', 'phone', 'phone number', 'mobile'], true)) {
                $indeksWa ??= $idx;
                $jumlahCocokHeader++;
            } elseif (in_array($norm, ['kategori', 'kategori tamu', 'category', 'grup', 'group', 'kelompok'], true)) {
                $indeksKategori ??= $idx;
                $jumlahCocokHeader++;
            } elseif (in_array($norm, ['no', 'nomor', 'status', 'status kirim', 'status buka', 'link', 'link undangan', 'link undangan personal'], true)) {
                $jumlahCocokHeader++;
            }
        }

        if ($jumlahCocokHeader > 0 && $indeksNama !== null) {
            if ($indeksWa === null && $indeksKategori !== ($indeksNama + 1) && array_key_exists($indeksNama + 1, $barisPertama)) {
                $indeksWa = $indeksNama + 1;
            }

            return [
                'adalah_header' => true,
                'indeks_nama' => $indeksNama,
                'indeks_wa' => $indeksWa,
                'indeks_kategori' => $indeksKategori,
            ];
        }

        return [
            'adalah_header' => false,
            'indeks_nama' => 0,
            'indeks_wa' => 1,
            'indeks_kategori' => 2,
        ];
    }

    private static function bersihkanNamaSheet(string $nama): string
    {
        $bersih = preg_replace('/[:\\\\\/?*\[\]]/', ' ', trim($nama)) ?? 'Daftar Tamu';
        $bersih = trim($bersih);

        return Str::limit($bersih !== '' ? $bersih : 'Daftar Tamu', 31, '');
    }

    private static function hurufKolom(int $indeksNol): string
    {
        $huruf = '';
        $n = $indeksNol + 1;
        while ($n > 0) {
            $sisa = ($n - 1) % 26;
            $huruf = chr(65 + $sisa).$huruf;
            $n = intdiv($n - 1, 26);
        }

        return $huruf;
    }

    private static function escapeXml(string $teks): string
    {
        $bersih = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', '', $teks) ?? $teks;

        return htmlspecialchars($bersih, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }

    private static function xmlContentTypes(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            .'<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            .'<Default Extension="xml" ContentType="application/xml"/>'
            .'<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            .'<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            .'<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
            .'</Types>';
    }

    private static function xmlRootRels(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            .'<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
            .'</Relationships>';
    }

    private static function xmlWorkbook(string $namaSheet): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            .'<sheets><sheet name="'.self::escapeXml($namaSheet).'" sheetId="1" r:id="rId1"/></sheets>'
            .'</workbook>';
    }

    private static function xmlWorkbookRels(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            .'<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
            .'<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
            .'</Relationships>';
    }

    private static function xmlStyles(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            .'<fonts count="2">'
            .'<font><sz val="11"/><color rgb="FF1F2937"/><name val="Calibri"/></font>'
            .'<font><b/><sz val="11"/><color rgb="FFFFFFFF"/><name val="Calibri"/></font>'
            .'</fonts>'
            .'<fills count="4">'
            .'<fill><patternFill patternType="none"/></fill>'
            .'<fill><patternFill patternType="gray125"/></fill>'
            .'<fill><patternFill patternType="solid"><fgColor rgb="FF4B6358"/><bgColor indexed="64"/></patternFill></fill>'
            .'<fill><patternFill patternType="solid"><fgColor rgb="FFFAF8F4"/><bgColor indexed="64"/></patternFill></fill>'
            .'</fills>'
            .'<borders count="2">'
            .'<border><left/><right/><top/><bottom/><diagonal/></border>'
            .'<border>'
            .'<left style="thin"><color rgb="FFE5E0D5"/></left>'
            .'<right style="thin"><color rgb="FFE5E0D5"/></right>'
            .'<top style="thin"><color rgb="FFE5E0D5"/></top>'
            .'<bottom style="thin"><color rgb="FFE5E0D5"/></bottom>'
            .'<diagonal/>'
            .'</border>'
            .'</borders>'
            .'<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
            .'<cellXfs count="5">'
            .'<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyBorder="1" applyAlignment="1"><alignment vertical="center"/></xf>'
            .'<xf numFmtId="0" fontId="1" fillId="2" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment vertical="center" horizontal="left"/></xf>'
            .'<xf numFmtId="49" fontId="0" fillId="0" borderId="1" xfId="0" applyNumberFormat="1" applyBorder="1" applyAlignment="1"><alignment vertical="center"/></xf>'
            .'<xf numFmtId="0" fontId="0" fillId="3" borderId="1" xfId="0" applyFill="1" applyBorder="1" applyAlignment="1"><alignment vertical="center"/></xf>'
            .'<xf numFmtId="49" fontId="0" fillId="3" borderId="1" xfId="0" applyNumberFormat="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment vertical="center"/></xf>'
            .'</cellXfs>'
            .'</styleSheet>';
    }

    /**
     * @param  list<string>  $headers
     * @param  list<list<int|string>>  $rows
     * @param  list<int|float>  $lebarKolom
     * @param  list<int>  $kolomTeks
     */
    private static function xmlWorksheet(
        array $headers,
        array $rows,
        array $lebarKolom,
        array $kolomTeks
    ): string {
        $jumlahKolom = max(1, count($headers));
        $kolomAkhir = self::hurufKolom($jumlahKolom - 1);
        $barisAkhir = count($rows) + 1;
        $dimensi = "A1:{$kolomAkhir}{$barisAkhir}";

        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            .'<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            .'<dimension ref="'.$dimensi.'"/>'
            .'<sheetViews><sheetView tabSelected="1" workbookViewId="0">'
            .'<pane ySplit="1" topLeftCell="A2" activePane="bottomLeft" state="frozen"/>'
            .'</sheetView></sheetViews>'
            .'<sheetFormatPr defaultRowHeight="20"/>';

        if (! empty($lebarKolom)) {
            $xml .= '<cols>';
            foreach ($lebarKolom as $idx => $lebar) {
                $colNo = $idx + 1;
                $xml .= '<col min="'.$colNo.'" max="'.$colNo.'" width="'.number_format((float) $lebar, 2, '.', '').'" customWidth="1"/>';
            }
            $xml .= '</cols>';
        }

        $xml .= '<sheetData>';

        // Baris 1: Header
        $xml .= '<row r="1" ht="26" customHeight="1">';
        foreach ($headers as $cIdx => $judul) {
            $ref = self::hurufKolom($cIdx).'1';
            $xml .= '<c r="'.$ref.'" s="1" t="inlineStr"><is><t xml:space="preserve">'.self::escapeXml((string) $judul).'</t></is></c>';
        }
        $xml .= '</row>';

        // Baris data
        foreach ($rows as $rIdx => $row) {
            $nomorBaris = $rIdx + 2;
            $zebra = ($rIdx % 2) === 1;
            $xml .= '<row r="'.$nomorBaris.'" ht="21" customHeight="1">';
            foreach ($headers as $cIdx => $_) {
                $ref = self::hurufKolom($cIdx).$nomorBaris;
                $nilai = $row[$cIdx] ?? '';
                $paksaTeks = in_array($cIdx, $kolomTeks, true);

                if (! $paksaTeks && is_int($nilai)) {
                    $gaya = $zebra ? 3 : 0;
                    $xml .= '<c r="'.$ref.'" s="'.$gaya.'" t="n"><v>'.$nilai.'</v></c>';
                } else {
                    $gaya = $paksaTeks ? ($zebra ? 4 : 2) : ($zebra ? 3 : 0);
                    $xml .= '<c r="'.$ref.'" s="'.$gaya.'" t="inlineStr"><is><t xml:space="preserve">'.self::escapeXml((string) $nilai).'</t></is></c>';
                }
            }
            $xml .= '</row>';
        }

        $xml .= '</sheetData>'
            .'<autoFilter ref="'.$dimensi.'"/>'
            .'</worksheet>';

        return $xml;
    }
}
