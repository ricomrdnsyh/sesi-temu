<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AmplopDigital extends Model
{
    protected $table = 'amplop_digital';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'undangan_id',
        'nama_bank',
        'nomor_rekening',
        'atas_nama',
    ];

    public function undangan(): BelongsTo
    {
        return $this->belongsTo(Undangan::class, 'undangan_id');
    }
}
