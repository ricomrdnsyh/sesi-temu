<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriTamu extends Model
{
    protected $table = 'kategori_tamu';

    /**
     * 8 pilihan warna preset bernuansa soft selaras dengan palet SesiTemu.
     *
     * @var list<string>
     */
    public const WARNA_BAWAAN = [
        '#A85F6E',
        '#B37156',
        '#9A7F49',
        '#5F7D6E',
        '#527F80',
        '#5A789B',
        '#7E6C99',
        '#95677F',
    ];

    /**
     * 5 kategori bawaan saat undangan pertama kali membuka halaman Daftar Tamu.
     *
     * @var list<array{nama: string, warna: string}>
     */
    public const KATEGORI_BAWAAN = [
        ['nama' => 'Keluarga Pria', 'warna' => '#5A789B'],
        ['nama' => 'Keluarga Wanita', 'warna' => '#A85F6E'],
        ['nama' => 'Teman', 'warna' => '#5F7D6E'],
        ['nama' => 'Kantor', 'warna' => '#9A7F49'],
        ['nama' => 'Tetangga', 'warna' => '#527F80'],
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'undangan_id',
        'nama',
        'warna',
        'urutan',
    ];

    public function undangan(): BelongsTo
    {
        return $this->belongsTo(Undangan::class, 'undangan_id');
    }

    public function daftarTamu(): HasMany
    {
        return $this->hasMany(TamuUndangan::class, 'kategori_tamu_id');
    }

    public static function warnaAman(?string $warna): string
    {
        $bersih = strtoupper(trim((string) $warna));
        if (preg_match('/^#[0-9A-F]{6}$/', $bersih) === 1) {
            return $bersih;
        }

        return self::WARNA_BAWAAN[0];
    }
}
