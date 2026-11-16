<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promo', function (Blueprint $table): void {
            $table->id();
            $table->string('kode', 40)->unique();
            $table->string('nama_promo', 120);
            $table->enum('tipe_diskon', ['nominal', 'persen'])->default('nominal');
            $table->unsignedInteger('nilai_diskon');
            $table->unsignedInteger('maksimal_diskon')->nullable();
            $table->unsignedInteger('kuota')->nullable();
            $table->unsignedInteger('jumlah_terpakai')->default(0);
            $table->date('berlaku_mulai')->nullable();
            $table->date('berlaku_sampai')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promo');
    }
};
