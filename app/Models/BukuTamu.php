<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BukuTamu extends Model
{
    protected $table = 'buku_tamu';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'undangan_id',
        'nama_tamu',
        'status_kehadiran',
        'jumlah_tamu',
        'ucapan_doa',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'jumlah_tamu' => 'integer',
        ];
    }

    public function undangan(): BelongsTo
    {
        return $this->belongsTo(Undangan::class, 'undangan_id');
    }
}
