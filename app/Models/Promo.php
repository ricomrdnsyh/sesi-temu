<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Promo extends Model
{
    protected $table = 'promo';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'kode',
        'nama_promo',
        'tipe_diskon',
        'nilai_diskon',
        'maksimal_diskon',
        'kuota',
        'jumlah_terpakai',
        'berlaku_mulai',
        'berlaku_sampai',
        'aktif',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'nilai_diskon' => 'integer',
            'maksimal_diskon' => 'integer',
            'kuota' => 'integer',
            'jumlah_terpakai' => 'integer',
            'berlaku_mulai' => 'date',
            'berlaku_sampai' => 'date',
            'aktif' => 'boolean',
        ];
    }

    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'promo_id');
    }

    public function layakDigunakan(): bool
    {
        if (! $this->aktif) {
            return false;
        }

        $hariIni = now()->startOfDay();

        if ($this->berlaku_mulai !== null && $hariIni->lt($this->berlaku_mulai->startOfDay())) {
            return false;
        }

        if ($this->berlaku_sampai !== null && $hariIni->gt($this->berlaku_sampai->endOfDay())) {
            return false;
        }

        if ($this->kuota !== null && $this->jumlah_terpakai >= $this->kuota) {
            return false;
        }

        return true;
    }

    public function hitungPotongan(int $subtotal): int
    {
        if ($subtotal <= 0 || ! $this->layakDigunakan()) {
            return 0;
        }

        if ($this->tipe_diskon === 'persen') {
            $potongan = (int) floor($subtotal * min(100, max(0, $this->nilai_diskon)) / 100);
            if ($this->maksimal_diskon !== null && $this->maksimal_diskon > 0) {
                $potongan = min($potongan, $this->maksimal_diskon);
            }

            return min($subtotal, $potongan);
        }

        return min($subtotal, max(0, $this->nilai_diskon));
    }

    public function labelDiskon(): string
    {
        if ($this->tipe_diskon === 'persen') {
            $label = $this->nilai_diskon.'%';
            if ($this->maksimal_diskon !== null && $this->maksimal_diskon > 0) {
                $label .= ' (Maks '.Tema::formatRupiah($this->maksimal_diskon).')';
            }

            return $label;
        }

        return Tema::formatRupiah($this->nilai_diskon);
    }
}
