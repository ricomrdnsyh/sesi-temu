<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanPlatform extends Model
{
    protected $table = 'pengaturan_platform';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'kunci',
        'nilai',
        'keterangan',
    ];
}
