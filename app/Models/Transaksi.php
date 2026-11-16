<?php

namespace App\Models;

use App\Support\MediaPublik;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    /**
     * @var array<string, string>
     */
    public const PAKET_TERSEDIA = [
        'mandiri' => 'Paket Mandiri (Input Sendiri)',
        'terima_beres' => 'Paket Terima Beres (Dibantu Admin)',
    ];

    /**
     * @var array<string, string>
     */
    public const STATUS_TERSEDIA = [
        'menunggu_pembayaran' => 'Menunggu Pembayaran',
        'menunggu_verifikasi' => 'Menunggu Verifikasi',
        'lunas' => 'Lunas & Aktif',
        'ditolak' => 'Ditolak',
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'kode_invoice',
        'undangan_id',
        'pengguna_id',
        'tema_id',
        'promo_id',
        'paket',
        'harga_tema',
        'biaya_jasa',
        'potongan_promo',
        'total_bayar',
        'status',
        'bukti_pembayaran',
        'catatan_admin',
        'diverifikasi_oleh',
        'diverifikasi_pada',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'harga_tema' => 'integer',
            'biaya_jasa' => 'integer',
            'potongan_promo' => 'integer',
            'total_bayar' => 'integer',
            'diverifikasi_pada' => 'datetime',
        ];
    }

    public function undangan(): BelongsTo
    {
        return $this->belongsTo(Undangan::class, 'undangan_id');
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function tema(): BelongsTo
    {
        return $this->belongsTo(Tema::class, 'tema_id');
    }

    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class, 'promo_id');
    }

    public function verifikator(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'diverifikasi_oleh');
    }

    public function labelPaket(): string
    {
        return self::PAKET_TERSEDIA[$this->paket] ?? ucfirst($this->paket);
    }

    public function labelStatus(): string
    {
        return self::STATUS_TERSEDIA[$this->status] ?? ucfirst(str_replace('_', ' ', $this->status));
    }

    public function urlBukti(): ?string
    {
        return MediaPublik::url($this->bukti_pembayaran);
    }
}
