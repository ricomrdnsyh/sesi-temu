<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan_platform', function (Blueprint $table): void {
            $table->id();
            $table->string('kunci', 100)->unique();
            $table->text('nilai')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });

        $now = now();
        $bawaan = [
            [
                'kunci' => 'nomor_wa_admin',
                'nilai' => '6281234567890',
                'keterangan' => 'Nomor WhatsApp resmi CS SesiTemu (awalan 62)',
            ],
            [
                'kunci' => 'masa_aktif_bulan',
                'nilai' => '3',
                'keterangan' => 'Durasi masa aktif undangan default dalam bulan',
            ],
            [
                'kunci' => 'biaya_terima_beres',
                'nilai' => '50000',
                'keterangan' => 'Biaya tambahan jasa Paket Terima Beres (Rupiah)',
            ],
            [
                'kunci' => 'nama_bank_pembayaran',
                'nilai' => 'BCA',
                'keterangan' => 'Nama bank tujuan pembayaran client',
            ],
            [
                'kunci' => 'nomor_rekening_pembayaran',
                'nilai' => '1234567890',
                'keterangan' => 'Nomor rekening pembayaran platform',
            ],
            [
                'kunci' => 'atas_nama_rekening',
                'nilai' => 'PT SesiTemu Digital',
                'keterangan' => 'Nama pemilik rekening pembayaran platform',
            ],
            [
                'kunci' => 'catatan_pembayaran',
                'nilai' => 'Cantumkan slug undangan pada berita acara transfer lalu unggah bukti transfer atau konfirmasi ke WhatsApp Admin.',
                'keterangan' => 'Petunjuk singkat pembayaran client',
            ],
        ];

        foreach ($bawaan as $item) {
            DB::table('pengaturan_platform')->updateOrInsert(
                ['kunci' => $item['kunci']],
                [
                    'nilai' => $item['nilai'],
                    'keterangan' => $item['keterangan'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_platform');
    }
};
