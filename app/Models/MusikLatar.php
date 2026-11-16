<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MusikLatar extends Model
{
    protected $table = 'musik_latar';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'judul',
        'artis',
        'path_file',
        'kategori',
        'aktif',
        'urutan',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'aktif' => 'boolean',
            'urutan' => 'integer',
        ];
    }

    public function apakahFileBawaan(): bool
    {
        return str_starts_with($this->path_file, 'musik/');
    }

    public function urlAudio(): string
    {
        return asset($this->path_file);
    }
}
