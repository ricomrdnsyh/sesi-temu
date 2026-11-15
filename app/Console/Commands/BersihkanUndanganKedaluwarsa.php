<?php

namespace App\Console\Commands;

use App\Models\Undangan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BersihkanUndanganKedaluwarsa extends Command
{
    protected $signature = 'undangan:bersihkan-kedaluwarsa';

    protected $description = 'Menghapus direktori foto undangan yang telah melewati masa berlaku (berlaku_sampai).';

    public function handle(): int
    {
        $daftarKedaluwarsa = Undangan::whereNotNull('berlaku_sampai')
            ->where('berlaku_sampai', '<', now())
            ->get();

        $jumlahDibersihkan = 0;

        foreach ($daftarKedaluwarsa as $undangan) {
            $direktori = "undangan/{$undangan->id}";

            if (Storage::disk('public')->exists($direktori)) {
                Storage::disk('public')->deleteDirectory($direktori);
            }

            $perluSimpan = false;

            if ($undangan->foto_pria && Str::startsWith($undangan->foto_pria, $direktori.'/')) {
                $undangan->foto_pria = null;
                $perluSimpan = true;
            }

            if ($undangan->foto_wanita && Str::startsWith($undangan->foto_wanita, $direktori.'/')) {
                $undangan->foto_wanita = null;
                $perluSimpan = true;
            }

            if ($undangan->status_publikasi) {
                $undangan->status_publikasi = false;
                $perluSimpan = true;
            }

            if ($perluSimpan) {
                $undangan->save();
            }

            $undangan->daftarGaleri()
                ->where('lokasi_foto', 'like', $direktori.'/%')
                ->delete();

            $jumlahDibersihkan++;
        }

        $this->info("Pembersihan selesai. {$jumlahDibersihkan} undangan kedaluwarsa telah diproses.");

        return self::SUCCESS;
    }
}
