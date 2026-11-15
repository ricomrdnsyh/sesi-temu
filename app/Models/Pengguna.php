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

    public function adalahAdmin(): bool
    {
        return $this->peran === 'admin';
    }

    public function adalahClient(): bool
    {
        return $this->peran === 'client';
    }
}
