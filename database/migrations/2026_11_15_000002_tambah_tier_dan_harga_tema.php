<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tema', function (Blueprint $table): void {
            $table->string('tier', 30)->default('basic')->after('kategori');
            $table->unsignedInteger('harga')->default(59000)->after('tier');
        });

        $hargaBawaanSlug = [
            'rustic-floral' => ['tier' => 'basic', 'harga' => 59000],
            'islami-syari' => ['tier' => 'basic', 'harga' => 59000],
            'editorial-monokrom' => ['tier' => 'premium', 'harga' => 79000],
            'adat-jawa' => ['tier' => 'premium', 'harga' => 89000],
            'sunda-heritage' => ['tier' => 'premium', 'harga' => 89000],
            'royal-ivory' => ['tier' => 'premium', 'harga' => 99000],
            'luxury-noir' => ['tier' => 'eksklusif', 'harga' => 119000],
            'velvet-garden' => ['tier' => 'eksklusif', 'harga' => 129000],
            'islamic-heavenly' => ['tier' => 'eksklusif', 'harga' => 129000],
        ];

        foreach ($hargaBawaanSlug as $slug => $data) {
            DB::table('tema')->where('slug', $slug)->update($data);
        }
    }

    public function down(): void
    {
        Schema::table('tema', function (Blueprint $table): void {
            $table->dropColumn(['tier', 'harga']);
        });
    }
};
