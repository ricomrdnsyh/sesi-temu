<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

class BerkasUnggahanAman implements ValidationRule
{
    public const MAKS_DIMENSI_GAMBAR = 8000;

    public const MAKS_TOTAL_PIKSEL_GAMBAR = 25_000_000;

    /**
     * Ekstensi yang dilarang muncul sebagai ekstensi ganda di tengah nama berkas
     * (misalnya: shell.php.jpg, hack.phtml.mp3, evil.svg.png, fake.jpg.png).
     *
     * @var list<string>
     */
    private const EKSTENSI_TERLARANG_GANDA = [
        'php', 'phtml', 'pht', 'phps', 'phar', 'inc',
        'asp', 'aspx', 'asa', 'cer', 'jsp', 'jspx', 'cfm', 'cgi', 'pl', 'py', 'rb',
        'sh', 'bash', 'zsh', 'bat', 'cmd', 'ps1', 'psm1', 'vbs', 'vbe', 'wsf', 'wsh',
        'exe', 'dll', 'msi', 'com', 'scr', 'pif', 'jar', 'war', 'class', 'elf', 'bin',
        'js', 'mjs', 'cjs', 'ts', 'jsx', 'tsx',
        'html', 'htm', 'xhtml', 'shtml', 'mhtml', 'svg', 'svgz', 'xml', 'xsl', 'xslt',
        'htaccess', 'htpasswd', 'ini', 'env', 'conf', 'config', 'sql', 'sqlite', 'db',
        'zip', 'rar', '7z', 'tar', 'gz', 'bz2', 'xz', 'iso',
        'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'rtf',
        'jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp', 'ico', 'tif', 'tiff', 'heic', 'avif',
        'mp3', 'wav', 'ogg', 'm4a', 'aac', 'flac', 'mp4', 'webm', 'mov', 'avi', 'mkv',
        'csv', 'txt', 'tsv', 'json', 'yaml', 'yml', 'css',
    ];

    /**
     * @param  'gambar'|'musik'|'csv'  $jenis
     */
    private function __construct(
        private readonly string $jenis,
        private readonly int $maksKb,
    ) {}

    public static function gambar(int $maksKb = 5120): self
    {
        return new self('gambar', $maksKb);
    }

    public static function musik(int $maksKb = 15360): self
    {
        return new self('musik', $maksKb);
    }

    public static function csv(int $maksKb = 2048): self
    {
        return new self('csv', $maksKb);
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $value instanceof UploadedFile || ! $value->isValid()) {
            $fail('Berkas unggahan tidak valid atau rusak.');

            return;
        }

        $ukuran = (int) ($value->getSize() ?: 0);
        if ($ukuran <= 0) {
            $fail('Berkas unggahan kosong dan tidak dapat diproses.');

            return;
        }

        if ($ukuran > ($this->maksKb * 1024)) {
            $maksMb = round($this->maksKb / 1024, 1);
            $fail("Ukuran berkas melebihi batas maksimal {$maksMb} MB.");

            return;
        }

        $namaAsli = (string) $value->getClientOriginalName();
        $ekstensiAkhir = $this->validasiNamaDanEkstensi($namaAsli, $fail);
        if ($ekstensiAkhir === null) {
            return;
        }

        $realPath = $value->getRealPath();
        if ($realPath === false || ! is_file($realPath)) {
            $fail('Berkas sementara tidak dapat dibaca oleh server.');

            return;
        }

        match ($this->jenis) {
            'gambar' => $this->validasiIsiGambar($value, $realPath, $ekstensiAkhir, $fail),
            'musik' => $this->validasiIsiMusik($value, $realPath, $ekstensiAkhir, $fail),
            'csv' => $this->validasiIsiCsv($value, $realPath, $fail),
        };
    }

    /**
     * Memastikan nama berkas aman, bebas ekstensi ganda berbahaya, dan ekstensi akhirnya diizinkan.
     */
    private function validasiNamaDanEkstensi(string $namaAsli, Closure $fail): ?string
    {
        $nama = trim($namaAsli);
        if (
            $nama === ''
            || strlen($nama) > 255
            || preg_match('/[\x00-\x1F\x7F\\\\\/]/', $nama) === 1
            || str_contains($nama, '..')
            || stripos($nama, '%00') !== false
        ) {
            $fail('Nama berkas mengandung karakter tidak aman dan ditolak.');

            return null;
        }

        $bagian = explode('.', $nama);
        if (count($bagian) < 2) {
            $fail('Berkas harus memiliki ekstensi yang valid.');

            return null;
        }

        $ekstensiAkhir = strtolower(trim((string) array_pop($bagian)));
        $ekstensiDiizinkan = match ($this->jenis) {
            'gambar' => ['jpg', 'jpeg', 'png', 'webp'],
            'musik' => ['mp3', 'wav', 'ogg', 'm4a'],
            'csv' => ['csv'],
        };

        if (! in_array($ekstensiAkhir, $ekstensiDiizinkan, true)) {
            $labelFormat = strtoupper(implode(', ', $ekstensiDiizinkan));
            $fail("Ekstensi berkas .{$ekstensiAkhir} tidak diizinkan. Gunakan format {$labelFormat}.");

            return null;
        }

        // Periksa segmen sebelum ekstensi akhir untuk menolak ekstensi ganda (misal: shell.php.jpg, foto.jpg.png)
        $jumlahBagianNama = count($bagian);
        for ($i = 1; $i < $jumlahBagianNama; $i++) {
            $segmen = strtolower(trim($bagian[$i]));
            if (
                $segmen === ''
                || in_array($segmen, self::EKSTENSI_TERLARANG_GANDA, true)
                || preg_match('/^php[0-9a-z]*$/', $segmen) === 1
            ) {
                $fail('Berkas dengan ekstensi ganda atau mencurigakan ditolak demi keamanan.');

                return null;
            }
        }

        return $ekstensiAkhir;
    }

    private function validasiIsiGambar(UploadedFile $berkas, string $realPath, string $ekstensiAkhir, Closure $fail): void
    {
        $mime = $this->deteksiMimeAman($berkas, $realPath);
        $mimeDiizinkan = ['image/jpeg', 'image/png', 'image/webp'];
        if (! in_array($mime, $mimeDiizinkan, true)) {
            $fail('Isi berkas bukan gambar JPG, PNG, atau WebP yang valid.');

            return;
        }

        $header = $this->bacaPotonganAwal($realPath, 16);
        $jenisHeader = $this->deteksiSignatureGambar($header);
        $ekstensiNormal = $ekstensiAkhir === 'jpeg' ? 'jpg' : $ekstensiAkhir;

        if ($jenisHeader === null || $jenisHeader !== $ekstensiNormal) {
            $fail('Isi berkas gambar tidak cocok dengan ekstensinya dan ditolak.');

            return;
        }

        $info = @getimagesize($realPath);
        if (! is_array($info)) {
            $fail('Berkas gambar rusak atau tidak dapat diverifikasi.');

            return;
        }

        $lebar = (int) ($info[0] ?? 0);
        $tinggi = (int) ($info[1] ?? 0);
        $mimeInfo = strtolower((string) ($info['mime'] ?? ''));

        if (! in_array($mimeInfo, $mimeDiizinkan, true)) {
            $fail('Format internal gambar tidak didukung. Gunakan JPG, PNG, atau WebP.');

            return;
        }

        if (
            $lebar < 1
            || $tinggi < 1
            || $lebar > self::MAKS_DIMENSI_GAMBAR
            || $tinggi > self::MAKS_DIMENSI_GAMBAR
            || ($lebar * $tinggi) > self::MAKS_TOTAL_PIKSEL_GAMBAR
        ) {
            $fail('Resolusi gambar terlalu besar (maks. 8000×8000 px / 25 MP) dan ditolak demi stabilitas server.');
        }
    }

    private function validasiIsiMusik(UploadedFile $berkas, string $realPath, string $ekstensiAkhir, Closure $fail): void
    {
        $mime = $this->deteksiMimeAman($berkas, $realPath);
        $mimeDiizinkan = [
            'audio/mpeg',
            'audio/mp3',
            'audio/wav',
            'audio/x-wav',
            'audio/wave',
            'audio/vnd.wave',
            'audio/ogg',
            'application/ogg',
            'audio/mp4',
            'audio/x-m4a',
            'video/mp4',
            'audio/aac',
        ];

        if (! in_array($mime, $mimeDiizinkan, true)) {
            $fail('Isi berkas bukan file audio MP3, WAV, OGG, atau M4A yang valid.');

            return;
        }

        $header = $this->bacaPotonganAwal($realPath, 32);
        $signatureCocok = match ($ekstensiAkhir) {
            'mp3' => str_starts_with($header, 'ID3')
                || (strlen($header) >= 2 && ord($header[0]) === 0xFF && (ord($header[1]) & 0xE0) === 0xE0),
            'wav' => strlen($header) >= 12 && substr($header, 0, 4) === 'RIFF' && substr($header, 8, 4) === 'WAVE',
            'ogg' => str_starts_with($header, 'OggS'),
            'm4a' => strlen($header) >= 8 && substr($header, 4, 4) === 'ftyp',
            default => false,
        };

        if (! $signatureCocok) {
            $fail('Isi berkas musik tidak sesuai dengan format ekstensinya dan ditolak.');

            return;
        }

        $cuplikan = $this->bacaPotonganAwal($realPath, 65536).$this->bacaPotonganAkhir($realPath, 8192);
        if ($this->mengandungSkripBerbahaya($cuplikan)) {
            $fail('Berkas musik mengandung pola skrip berbahaya dan ditolak.');
        }
    }

    private function validasiIsiCsv(UploadedFile $berkas, string $realPath, Closure $fail): void
    {
        $mime = $this->deteksiMimeAman($berkas, $realPath);
        $mimeDiizinkan = [
            'text/plain',
            'text/csv',
            'application/csv',
            'application/vnd.ms-excel',
            'text/x-csv',
            'text/comma-separated-values',
            'application/octet-stream',
        ];

        if ($mime !== '' && ! in_array($mime, $mimeDiizinkan, true)) {
            $fail('Isi berkas bukan file teks CSV yang valid.');

            return;
        }

        $awal = $this->bacaPotonganAwal($realPath, 65536);
        $akhir = $this->bacaPotonganAkhir($realPath, 8192);

        if (str_contains($awal, "\0") || str_contains($akhir, "\0")) {
            $fail('Berkas CSV mengandung data biner tidak valid dan ditolak.');

            return;
        }

        foreach (['MZ', "\x7FELF", '%PDF-', "PK\x03\x04", "\x89PNG", "\xFF\xD8\xFF", 'GIF8', 'Rar!', "\x1F\x8B"] as $sigBiner) {
            if (str_starts_with($awal, $sigBiner)) {
                $fail('Berkas yang diunggah bukan file CSV murni dan ditolak.');

                return;
            }
        }

        if ($this->mengandungSkripBerbahaya($awal.$akhir)) {
            $fail('Berkas CSV mengandung kode skrip tidak diizinkan dan ditolak.');
        }
    }

    private function deteksiMimeAman(UploadedFile $berkas, string $realPath): string
    {
        try {
            $mime = strtolower((string) $berkas->getMimeType());
            if ($mime !== '') {
                return $mime;
            }
        } catch (\Throwable) {
            // Fallback ke finfo buffer bila is_readable() pada direktori temp OS dibatasi
        }

        if (function_exists('finfo_open')) {
            $finfo = @finfo_open(FILEINFO_MIME_TYPE);
            if ($finfo !== false) {
                $buffer = $this->bacaPotonganAwal($realPath, 65536);
                $hasil = $buffer !== '' ? @finfo_buffer($finfo, $buffer) : false;
                finfo_close($finfo);
                if (is_string($hasil) && $hasil !== '') {
                    return strtolower($hasil);
                }
            }
        }

        return '';
    }

    private function deteksiSignatureGambar(string $header): ?string
    {
        if (strlen($header) >= 3 && substr($header, 0, 3) === "\xFF\xD8\xFF") {
            return 'jpg';
        }

        if (strlen($header) >= 8 && substr($header, 0, 8) === "\x89PNG\r\n\x1A\n") {
            return 'png';
        }

        if (strlen($header) >= 12 && substr($header, 0, 4) === 'RIFF' && substr($header, 8, 4) === 'WEBP') {
            return 'webp';
        }

        return null;
    }

    private function mengandungSkripBerbahaya(string $teks): bool
    {
        return preg_match('/<\?(?:php|=)|\<\s*(?:script|iframe|svg|html)\b|<!doctype\s+html/i', $teks) === 1;
    }

    private function bacaPotonganAwal(string $realPath, int $panjang): string
    {
        $handle = @fopen($realPath, 'rb');
        if ($handle === false) {
            return '';
        }

        $data = (string) fread($handle, $panjang);
        fclose($handle);

        return $data;
    }

    private function bacaPotonganAkhir(string $realPath, int $panjang): string
    {
        $ukuran = @filesize($realPath);
        if ($ukuran === false || $ukuran <= $panjang) {
            return '';
        }

        $handle = @fopen($realPath, 'rb');
        if ($handle === false) {
            return '';
        }

        fseek($handle, -$panjang, SEEK_END);
        $data = (string) fread($handle, $panjang);
        fclose($handle);

        return $data;
    }
}
