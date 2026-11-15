<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcaraUndangan extends Model
{
    protected $table = 'acara_undangan';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'undangan_id',
        'nama_acara',
        'tanggal_acara',
        'waktu_mulai',
        'waktu_selesai',
        'zona_waktu',
        'nama_tempat',
        'alamat_lengkap',
        'link_maps',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_acara' => 'date',
        ];
    }

    public function undangan(): BelongsTo
    {
        return $this->belongsTo(Undangan::class, 'undangan_id');
    }
}
