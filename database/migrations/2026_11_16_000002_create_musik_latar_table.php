<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('musik_latar', function (Blueprint $table): void {
            $table->id();
            $table->string('judul', 120);
            $table->string('artis', 120)->nullable();
            $table->string('path_file')->unique();
            $table->string('kategori', 50)->nullable();
            $table->boolean('aktif')->default(true);
            $table->unsignedSmallInteger('urutan')->default(1);
            $table->timestamps();
        });

        $now = now();
        $musikBawaan = [
            [
                'judul' => 'Romantis Akustik',
                'artis' => 'SesiTemu Audio',
                'path_file' => 'musik/romantis-akustik.mp3',
                'kategori' => 'Modern & Romantis',
                'aktif' => true,
                'urutan' => 1,
            ],
            [
                'judul' => 'Gamelan Lembut',
                'artis' => 'SesiTemu Nusantara',
                'path_file' => 'musik/gamelan-lembut.mp3',
                'kategori' => 'Adat & Tradisional',
                'aktif' => true,
                'urutan' => 2,
            ],
            [
                'judul' => 'Instrumen Islami',
                'artis' => 'SesiTemu Syari',
                'path_file' => 'musik/instrumen-islami.mp3',
                'kategori' => 'Islami & Syari',
                'aktif' => true,
                'urutan' => 3,
            ],
        ];

        foreach ($musikBawaan as $musik) {
            DB::table('musik_latar')->updateOrInsert(
                ['path_file' => $musik['path_file']],
                [
                    'judul' => $musik['judul'],
                    'artis' => $musik['artis'],
                    'kategori' => $musik['kategori'],
                    'aktif' => $musik['aktif'],
                    'urutan' => $musik['urutan'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('musik_latar');
    }
};
