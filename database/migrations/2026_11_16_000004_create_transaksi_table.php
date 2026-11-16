<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table): void {
            $table->id();
            $table->string('kode_invoice', 40)->unique();
            $table->foreignId('undangan_id')->constrained('undangan')->cascadeOnDelete();
            $table->foreignId('pengguna_id')->constrained('pengguna')->cascadeOnDelete();
            $table->foreignId('tema_id')->constrained('tema');
            $table->foreignId('promo_id')->nullable()->constrained('promo')->nullOnDelete();
            $table->enum('paket', ['mandiri', 'terima_beres'])->default('mandiri');
            $table->unsignedInteger('harga_tema');
            $table->unsignedInteger('biaya_jasa')->default(0);
            $table->unsignedInteger('potongan_promo')->default(0);
            $table->unsignedInteger('total_bayar');
            $table->enum('status', ['menunggu_pembayaran', 'menunggu_verifikasi', 'lunas', 'ditolak'])
                ->default('menunggu_pembayaran');
            $table->string('bukti_pembayaran')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->foreignId('diverifikasi_oleh')->nullable()->constrained('pengguna')->nullOnDelete();
            $table->timestamp('diverifikasi_pada')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
