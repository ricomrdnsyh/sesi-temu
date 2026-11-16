<?php

namespace App\Models;

use App\Support\MediaPublik;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class GaleriUndangan extends Model
{
    protected $table = 'galeri_undangan';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'undangan_id',
        'lokasi_foto',
        'keterangan',
        'urutan',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'urutan' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::deleting(function (GaleriUndangan $galeri): void {
            if ($galeri->lokasi_foto && Storage::disk('public')->exists($galeri->lokasi_foto)) {
                Storage::disk('public')->delete($galeri->lokasi_foto);
            }
        });
    }

    public function undangan(): BelongsTo
    {
        return $this->belongsTo(Undangan::class, 'undangan_id');
    }

    public function urlFoto(): string
    {
        return MediaPublik::url($this->lokasi_foto) ?? '';
    }
}
