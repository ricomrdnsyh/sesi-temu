<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Undangan extends Model
{
    protected $table = 'undangan';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'pengguna_id',
        'tema_id',
        'slug',
        'nama_panggilan_pria',
        'nama_lengkap_pria',
        'nama_ayah_pria',
        'nama_ibu_pria',
        'foto_pria',
        'nama_panggilan_wanita',
        'nama_lengkap_wanita',
        'nama_ayah_wanita',
        'nama_ibu_wanita',
        'foto_wanita',
        'kutipan_ayat',
        'musik_latar',
        'pengaturan',
        'status_publikasi',
        'berlaku_sampai',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'pengaturan' => 'array',
            'status_publikasi' => 'boolean',
            'berlaku_sampai' => 'datetime',
        ];
    }

    /**
     * @return array{
     *     cerita_cinta: list<array{judul: string, tanggal: string, cerita: string}>,
     *     live_streaming: array{aktif: bool, platform: string, link: string},
     *     alamat_kado_fisik: string,
     *     fitur_aktif: array{
     *         hitung_mundur: bool,
     *         cerita_cinta: bool,
     *         galeri: bool,
     *         amplop_digital: bool,
     *         buku_tamu: bool
     *     }
     * }
     */
    public static function pengaturanBawaan(): array
    {
        return [
            'cerita_cinta' => [],
            'live_streaming' => [
                'aktif' => false,
                'platform' => 'Instagram / YouTube',
                'link' => '',
            ],
            'alamat_kado_fisik' => '',
            'fitur_aktif' => [
                'hitung_mundur' => true,
                'cerita_cinta' => true,
                'galeri' => true,
                'amplop_digital' => true,
                'buku_tamu' => true,
            ],
        ];
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function tema(): BelongsTo
    {
        return $this->belongsTo(Tema::class, 'tema_id');
    }

    public function daftarAcara(): HasMany
    {
        return $this->hasMany(AcaraUndangan::class, 'undangan_id')
            ->orderBy('tanggal_acara')
            ->orderBy('waktu_mulai');
    }

    public function daftarGaleri(): HasMany
    {
        return $this->hasMany(GaleriUndangan::class, 'undangan_id')
            ->orderBy('urutan')
            ->orderBy('id');
    }

    public function daftarAmplop(): HasMany
    {
        return $this->hasMany(AmplopDigital::class, 'undangan_id');
    }

    public function bukuTamu(): HasMany
    {
        return $this->hasMany(BukuTamu::class, 'undangan_id')->latest();
    }

    public function sudahKedaluwarsa(): bool
    {
        return $this->berlaku_sampai !== null && $this->berlaku_sampai->isPast();
    }

    public function fiturAktif(string $fitur): bool
    {
        $fiturAktif = $this->pengaturan['fitur_aktif'] ?? [];

        return (bool) ($fiturAktif[$fitur] ?? true);
    }

    public function urlFotoPria(): ?string
    {
        return $this->resolveUrlMedia($this->foto_pria);
    }

    public function urlFotoWanita(): ?string
    {
        return $this->resolveUrlMedia($this->foto_wanita);
    }

    private function resolveUrlMedia(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://', 'aset-demo/', 'aset-tema/'])) {
            return asset($path);
        }

        return Storage::disk('public')->url($path);
    }
}
