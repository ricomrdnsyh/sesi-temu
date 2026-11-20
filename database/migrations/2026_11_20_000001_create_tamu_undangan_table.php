<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tamu_undangan', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('undangan_id')->constrained('undangan')->cascadeOnDelete();
            $table->string('kode_tamu', 16)->unique();
            $table->string('nama_tamu', 120);
            $table->string('nomor_wa', 25)->nullable();
            $table->timestamp('dikirim_pada')->nullable();
            $table->timestamp('dibuka_pada')->nullable();
            $table->timestamp('terakhir_dibuka_pada')->nullable();
            $table->unsignedInteger('jumlah_dibuka')->default(0);
            $table->timestamps();

            $table->index(['undangan_id', 'dikirim_pada']);
            $table->index(['undangan_id', 'dibuka_pada']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tamu_undangan');
    }
};
