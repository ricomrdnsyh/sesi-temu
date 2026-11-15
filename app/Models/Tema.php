<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Tema extends Model
{
    protected $table = 'tema';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'nama_tema',
        'slug',
        'kategori',
        'lokasi_view',
        'gambar_pratinjau',
        'aktif',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'aktif' => 'boolean',
        ];
    }

    public function undangan(): HasMany
    {
        return $this->hasMany(Undangan::class, 'tema_id');
    }

    public function urlGambarPratinjau(): ?string
    {
        if (! $this->gambar_pratinjau) {
            return null;
        }

        if (Str::startsWith($this->gambar_pratinjau, ['http://', 'https://', 'aset-demo/', 'aset-tema/'])) {
            return asset($this->gambar_pratinjau);
        }

        return Storage::disk('public')->url($this->gambar_pratinjau);
    }
}
