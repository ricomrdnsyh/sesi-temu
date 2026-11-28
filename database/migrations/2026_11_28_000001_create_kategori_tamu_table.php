<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_tamu', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('undangan_id')->constrained('undangan')->cascadeOnDelete();
            $table->string('nama', 60);
            $table->string('warna', 16)->default('#2563EB');
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamps();

            $table->index(['undangan_id', 'urutan']);
        });

        Schema::table('tamu_undangan', function (Blueprint $table): void {
            $table->foreignId('kategori_tamu_id')
                ->nullable()
                ->after('nomor_wa')
                ->constrained('kategori_tamu')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tamu_undangan', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('kategori_tamu_id');
        });

        Schema::dropIfExists('kategori_tamu');
    }
};
