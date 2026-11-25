<?php

use App\Models\Tema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('musik_latar')) {
            return;
        }

        $now = now();

        foreach (Tema::katalogMusikBawaan() as $musik) {
            DB::table('musik_latar')->updateOrInsert(
                ['path_file' => $musik['path_file']],
                [
                    'judul' => $musik['judul'],
                    'artis' => $musik['artis'],
                    'kategori' => $musik['kategori'],
                    'aktif' => true,
                    'urutan' => $musik['urutan'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        // Nonaktifkan entri generik lama yang sudah digantikan oleh lagu kurasi spesifik
        DB::table('musik_latar')
            ->whereIn('path_file', ['musik/romantis-akustik.mp3', 'musik/instrumen-islami.mp3'])
            ->update([
                'aktif' => false,
                'updated_at' => $now,
            ]);
    }

    public function down(): void
    {
        if (! Schema::hasTable('musik_latar')) {
            return;
        }

        $jalurBaru = [
            'musik/penjaga-hati.mp3',
            'musik/a-thousand-years.mp3',
            'musik/until-i-found-you.mp3',
            'musik/cant-help-falling-in-love.mp3',
            'musik/beautiful-in-white.mp3',
            'musik/lagu-pernikahan-kita.mp3',
            'musik/degung-sabilulungan.mp3',
            'musik/barakallahu-lakuma.mp3',
            'musik/rahmatun-lil-alameen.mp3',
        ];

        DB::table('musik_latar')->whereIn('path_file', $jalurBaru)->delete();
        DB::table('musik_latar')
            ->whereIn('path_file', ['musik/romantis-akustik.mp3', 'musik/instrumen-islami.mp3'])
            ->update(['aktif' => true]);
    }
};
