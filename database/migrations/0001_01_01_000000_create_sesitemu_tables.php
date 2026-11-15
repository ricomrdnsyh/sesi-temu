<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Pengguna (Pengganti users)
        Schema::create('pengguna', function (Blueprint $table): void {
            $table->id();
            $table->string('nama', 100);
            $table->string('email')->unique();
            $table->string('nomor_wa', 20)->nullable();
            $table->string('kata_sandi');
            $table->enum('peran', ['admin', 'client'])->default('client');
            $table->rememberToken();
            $table->timestamps();
        });

        // Tabel Sessions Bawaan Laravel
        Schema::create('sessions', function (Blueprint $table): void {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // 2. Tabel Tema Undangan
        Schema::create('tema', function (Blueprint $table): void {
            $table->id();
            $table->string('nama_tema');
            $table->string('slug')->unique();
            $table->enum('kategori', ['modern', 'adat', 'islami'])->default('modern');
            $table->string('lokasi_view');
            $table->string('gambar_pratinjau')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // 3. Tabel Utama Undangan
        Schema::create('undangan', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('pengguna')->cascadeOnDelete();
            $table->foreignId('tema_id')->constrained('tema');
            $table->string('slug')->unique();

            // Data Mempelai Pria
            $table->string('nama_panggilan_pria');
            $table->string('nama_lengkap_pria');
            $table->string('nama_ayah_pria')->nullable();
            $table->string('nama_ibu_pria')->nullable();
            $table->string('foto_pria')->nullable();

            // Data Mempelai Wanita
            $table->string('nama_panggilan_wanita');
            $table->string('nama_lengkap_wanita');
            $table->string('nama_ayah_wanita')->nullable();
            $table->string('nama_ibu_wanita')->nullable();
            $table->string('foto_wanita')->nullable();

            // Konten & Pengaturan Fleksibel
            $table->text('kutipan_ayat')->nullable();
            $table->string('musik_latar')->nullable();
            $table->json('pengaturan')->nullable();

            // Status Publikasi & Masa Aktif
            $table->boolean('status_publikasi')->default(false);
            $table->timestamp('berlaku_sampai')->nullable();
            $table->timestamps();
        });

        // 4. Tabel Acara Undangan (One-to-Many)
        Schema::create('acara_undangan', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('undangan_id')->constrained('undangan')->cascadeOnDelete();
            $table->string('nama_acara');
            $table->date('tanggal_acara');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai')->nullable();
            $table->string('zona_waktu', 10)->default('WIB');
            $table->string('nama_tempat');
            $table->text('alamat_lengkap');
            $table->text('link_maps')->nullable();
            $table->timestamps();
        });

        // 5. Tabel Galeri Foto (One-to-Many)
        Schema::create('galeri_undangan', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('undangan_id')->constrained('undangan')->cascadeOnDelete();
            $table->string('lokasi_foto');
            $table->string('keterangan')->nullable();
            $table->unsignedSmallInteger('urutan')->default(1);
            $table->timestamps();
        });

        // 6. Tabel Amplop Digital (One-to-Many)
        Schema::create('amplop_digital', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('undangan_id')->constrained('undangan')->cascadeOnDelete();
            $table->string('nama_bank');
            $table->string('nomor_rekening');
            $table->string('atas_nama');
            $table->timestamps();
        });

        // 7. Tabel Buku Tamu & RSVP (One-to-Many)
        Schema::create('buku_tamu', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('undangan_id')->constrained('undangan')->cascadeOnDelete();
            $table->string('nama_tamu');
            $table->enum('status_kehadiran', ['hadir', 'tidak_hadir', 'ragu'])->default('hadir');
            $table->unsignedTinyInteger('jumlah_tamu')->default(1);
            $table->text('ucapan_doa');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_tamu');
        Schema::dropIfExists('amplop_digital');
        Schema::dropIfExists('galeri_undangan');
        Schema::dropIfExists('acara_undangan');
        Schema::dropIfExists('undangan');
        Schema::dropIfExists('tema');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('pengguna');
    }
};
