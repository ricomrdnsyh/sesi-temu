<?php

namespace App\Models;

use Database\Factories\PenggunaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    /** @use HasFactory<PenggunaFactory> */
    use HasFactory, Notifiable;

    protected $table = 'pengguna';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'email',
        'nomor_wa',
        'kata_sandi',
        'peran',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'kata_sandi',
        'remember_token',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'kata_sandi' => 'hashed',
        ];
    }

    public function getAuthPasswordName(): string
    {
        return 'kata_sandi';
    }

    public function undangan(): HasMany
    {
        return $this->hasMany(Undangan::class, 'pengguna_id');
    }

    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'pengguna_id')->latest();
    }

    public function adalahAdmin(): bool
    {
        return $this->peran === 'admin';
    }

    public function adalahClient(): bool
    {
        return $this->peran === 'client';
    }

    public function inisialNama(): string
    {
        $bagian = preg_split('/\s+/', trim((string) $this->nama)) ?: [];
        $kata = array_values(array_filter($bagian, static fn (string $item): bool => $item !== ''));

        if (count($kata) >= 2) {
            return mb_strtoupper(mb_substr($kata[0], 0, 1).mb_substr($kata[1], 0, 1));
        }

        if (count($kata) === 1) {
            return mb_strtoupper(mb_substr($kata[0], 0, 2));
        }

        return 'ST';
    }

    public static function normalisasiNomorWa(?string $nomorWa): ?string
    {
        $bersih = preg_replace('/[^0-9]/', '', (string) ($nomorWa ?? ''));
        if ($bersih === '') {
            return null;
        }

        if (str_starts_with($bersih, '0')) {
            return '62'.substr($bersih, 1);
        }

        return $bersih;
    }
}
