<?php

namespace App\Services;

use GdImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class PengolahGambarService
{
    private const LEBAR_MAKSIMAL = 1200;

    private const KUALITAS_WEBP = 80;

    public function simpanGambarUndangan(UploadedFile $berkas, int $undanganId, string $awalan = 'foto'): string
    {
        $namaBerkas = Str::slug($awalan).'-'.Str::lower(Str::random(10)).'.webp';
        $jalurTujuan = "undangan/{$undanganId}/{$namaBerkas}";

        return $this->prosesDanSimpanWebp($berkas, $jalurTujuan);
    }

    public function simpanGambarTema(UploadedFile $berkas, string $slugTema): string
    {
        $namaBerkas = Str::slug($slugTema).'-'.Str::lower(Str::random(8)).'.webp';
        $jalurTujuan = "tema/{$namaBerkas}";

        return $this->prosesDanSimpanWebp($berkas, $jalurTujuan);
    }

    public function hapusBerkasJikaAda(?string $jalur): void
    {
        if (! $jalur) {
            return;
        }

        if (Str::startsWith($jalur, ['http://', 'https://', 'aset-demo/', 'aset-tema/'])) {
            return;
        }

        if (Storage::disk('public')->exists($jalur)) {
            Storage::disk('public')->delete($jalur);
        }
    }

    private function prosesDanSimpanWebp(UploadedFile $berkas, string $jalurTujuan): string
    {
        $sumber = $this->muatGambarDariFile($berkas);
        $lebarAsli = imagesx($sumber);
        $tinggiAsli = imagesy($sumber);

        $kanvas = $sumber;

        if ($lebarAsli > self::LEBAR_MAKSIMAL) {
            $lebarBaru = self::LEBAR_MAKSIMAL;
            $tinggiBaru = max(1, (int) round(($lebarBaru * $tinggiAsli) / $lebarAsli));

            $kanvasBaru = imagecreatetruecolor($lebarBaru, $tinggiBaru);
            imagealphablending($kanvasBaru, false);
            imagesavealpha($kanvasBaru, true);
            $transparan = imagecolorallocatealpha($kanvasBaru, 0, 0, 0, 127);
            imagefill($kanvasBaru, 0, 0, $transparan);

            imagecopyresampled($kanvasBaru, $sumber, 0, 0, 0, 0, $lebarBaru, $tinggiBaru, $lebarAsli, $tinggiAsli);
            imagedestroy($sumber);
            $kanvas = $kanvasBaru;
        }

        $tempPath = tempnam(sys_get_temp_dir(), 'webp_');
        if ($tempPath === false) {
            imagedestroy($kanvas);
            throw new RuntimeException('Gagal membuat berkas sementara untuk konversi WebP.');
        }

        try {
            $berhasil = imagewebp($kanvas, $tempPath, self::KUALITAS_WEBP);
            if (! $berhasil) {
                throw new RuntimeException('Gagal mengonversi gambar ke format WebP.');
            }

            $konten = file_get_contents($tempPath);
            if ($konten === false) {
                throw new RuntimeException('Gagal membaca hasil gambar WebP.');
            }

            Storage::disk('public')->put($jalurTujuan, $konten);
        } finally {
            imagedestroy($kanvas);
            if (file_exists($tempPath)) {
                unlink($tempPath);
            }
        }

        return $jalurTujuan;
    }

    private function muatGambarDariFile(UploadedFile $berkas): GdImage
    {
        $path = $berkas->getRealPath();
        if ($path === false || ! file_exists($path)) {
            throw new RuntimeException('Berkas gambar yang diunggah tidak ditemukan.');
        }

        $info = getimagesize($path);
        $mime = $info['mime'] ?? $berkas->getMimeType();

        $gambar = match ($mime) {
            'image/jpeg', 'image/jpg' => $this->muatJpegDenganOrientasi($path),
            'image/png' => imagecreatefrompng($path),
            'image/webp' => imagecreatefromwebp($path),
            default => imagecreatefromstring((string) file_get_contents($path)),
        };

        if (! $gambar instanceof GdImage) {
            throw new RuntimeException('Format gambar tidak didukung. Gunakan JPG, PNG, atau WebP.');
        }

        if (! imageistruecolor($gambar)) {
            imagepalettetotruecolor($gambar);
        }

        imagealphablending($gambar, true);
        imagesavealpha($gambar, true);

        return $gambar;
    }

    private function muatJpegDenganOrientasi(string $path): GdImage|false
    {
        $gambar = imagecreatefromjpeg($path);
        if (! $gambar instanceof GdImage) {
            return false;
        }

        if (! function_exists('exif_read_data')) {
            return $gambar;
        }

        $exif = @exif_read_data($path);
        $orientasi = $exif['Orientation'] ?? null;

        return match ($orientasi) {
            3 => imagerotate($gambar, 180, 0) ?: $gambar,
            6 => imagerotate($gambar, -90, 0) ?: $gambar,
            8 => imagerotate($gambar, 90, 0) ?: $gambar,
            default => $gambar,
        };
    }
}
