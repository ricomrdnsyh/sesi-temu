<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $petaSlug = [
            'adat-jawa' => 'adat',
            'sunda-heritage' => 'adat',
            'islami-syari' => 'islami',
            'islamic-heavenly' => 'islami',
            'rustic-floral' => 'floral',
            'velvet-garden' => 'floral',
            'luxury-noir' => 'elegan',
            'royal-ivory' => 'elegan',
            'editorial-monokrom' => 'modern',
        ];

        foreach ($petaSlug as $slug => $kategori) {
            DB::table('tema')
                ->where('slug', $slug)
                ->update(['kategori' => $kategori]);
        }

        // Normalkan kategori lama lainnya (luxury -> elegan, motion -> floral)
        DB::table('tema')->where('kategori', 'luxury')->update(['kategori' => 'elegan']);
        DB::table('tema')->where('kategori', 'motion')->update(['kategori' => 'floral']);
    }

    public function down(): void
    {
        $petaBalik = [
            'rustic-floral' => 'modern',
            'velvet-garden' => 'motion',
            'luxury-noir' => 'luxury',
            'royal-ivory' => 'luxury',
        ];

        foreach ($petaBalik as $slug => $kategori) {
            DB::table('tema')
                ->where('slug', $slug)
                ->update(['kategori' => $kategori]);
        }
    }
};
