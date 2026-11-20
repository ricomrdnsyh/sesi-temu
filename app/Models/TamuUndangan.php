<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class TamuUndangan extends Model
{
    protected $table = 'tamu_undangan';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'undangan_id',
        'kode_tamu',
        'nama_tamu',
        'nomor_wa',
        'dikirim_pada',
        'dibuka_pada',
        'terakhir_dibuka_pada',
        'jumlah_dibuka',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'dikirim_pada' => 'datetime',
            'dibuka_pada' => 'datetime',
            'terakhir_dibuka_pada' => 'datetime',
            'jumlah_dibuka' => 'integer',
        ];
    }

    public function undangan(): BelongsTo
    {
        return $this->belongsTo(Undangan::class, 'undangan_id');
    }

    public static function buatKodeUnik(): string
    {
        do {
            $kode = Str::lower(Str::random(8));
        } while (self::where('kode_tamu', $kode)->exists());

        return $kode;
    }

    /**
     * Normalisasi nomor WhatsApp ke format digit internasional (628xxxx).
     */
    public static function normalisasiNomorWa(?string $nomor): ?string
    {
        $hanyaAngka = preg_replace('/\D+/', '', (string) $nomor);
        if (! is_string($hanyaAngka) || $hanyaAngka === '') {
            return null;
        }

        if (str_starts_with($hanyaAngka, '0')) {
            $hanyaAngka = '62'.substr($hanyaAngka, 1);
        } elseif (str_starts_with($hanyaAngka, '8')) {
            $hanyaAngka = '62'.$hanyaAngka;
        }

        if (strlen($hanyaAngka) < 8 || strlen($hanyaAngka) > 16) {
            return null;
        }

        return $hanyaAngka;
    }

    public function sudahDikirim(): bool
    {
        return $this->dikirim_pada !== null;
    }

    public function sudahDibuka(): bool
    {
        return $this->dibuka_pada !== null;
    }

    public function catatkanDibuka(): void
    {
        $sekarang = now();

        if ($this->dibuka_pada === null) {
            $this->dibuka_pada = $sekarang;
        }

        $this->terakhir_dibuka_pada = $sekarang;
        $this->jumlah_dibuka = ((int) $this->jumlah_dibuka) + 1;
        $this->save();
    }
}
