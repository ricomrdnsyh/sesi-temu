<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Tema extends Model
{
    protected $table = 'tema';

    /**
     * Daftar kategori tema undangan yang tersedia pada katalog.
     *
     * @var array<string, string>
     */
    public const KATEGORI_TERSEDIA = [
        'modern' => 'Modern',
        'luxury' => 'Luxury',
        'motion' => 'Motion',
        'adat' => 'Adat',
        'islami' => 'Islami',
    ];

    /**
     * Daftar tingkatan kualitas (tier) tema yang tersedia pada katalog.
     *
     * @var array<string, string>
     */
    public const TIER_TERSEDIA = [
        'basic' => 'Basic',
        'premium' => 'Premium',
        'eksklusif' => 'Eksklusif',
    ];

    /**
     * Harga saran bawaan (Rupiah) untuk masing-masing tier tema.
     *
     * @var array<string, int>
     */
    public const HARGA_BAWAAN_TIER = [
        'basic' => 59000,
        'premium' => 89000,
        'eksklusif' => 119000,
    ];

    /**
     * Biaya tambahan jasa bantu input & tata letak Admin untuk Paket Terima Beres.
     */
    public const BIAYA_JASA_TERIMA_BERES = 50000;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'nama_tema',
        'slug',
        'kategori',
        'tier',
        'harga',
        'lokasi_view',
        'gambar_pratinjau',
        'aktif',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'harga' => 'integer',
            'aktif' => 'boolean',
        ];
    }

    public function undangan(): HasMany
    {
        return $this->hasMany(Undangan::class, 'tema_id');
    }

    public function kategoriLabel(): string
    {
        return self::KATEGORI_TERSEDIA[$this->kategori] ?? ucfirst($this->kategori);
    }

    public function tierKode(): string
    {
        $tier = (string) ($this->tier ?: 'basic');

        return array_key_exists($tier, self::TIER_TERSEDIA) ? $tier : 'basic';
    }

    public function tierLabel(): string
    {
        return self::TIER_TERSEDIA[$this->tierKode()];
    }

    public function hargaNominal(): int
    {
        return (int) ($this->harga ?? self::hargaBawaanTier($this->tierKode()));
    }

    public function hargaFormatted(): string
    {
        return self::formatRupiah($this->hargaNominal());
    }

    public function hargaTerimaBeresFormatted(): string
    {
        return self::formatRupiah($this->hargaNominal() + self::BIAYA_JASA_TERIMA_BERES);
    }

    public static function formatRupiah(int $nominal): string
    {
        return 'Rp '.number_format($nominal, 0, ',', '.');
    }

    public static function hargaBawaanTier(?string $tier): int
    {
        return self::HARGA_BAWAAN_TIER[$tier ?? 'basic'] ?? self::HARGA_BAWAAN_TIER['basic'];
    }

    /**
     * Metadata tampilan badge dan ringkasan kualitas per tier tema.
     *
     * @return array{
     *     kode: string,
     *     label: string,
     *     ringkasan: string,
     *     fitur_singkat: string,
     *     badge_class: string,
     *     chip_class: string,
     *     card_ring: string
     * }
     */
    public function infoTier(): array
    {
        $kode = $this->tierKode();

        $daftar = [
            'basic' => [
                'kode' => 'basic',
                'label' => 'Basic',
                'ringkasan' => 'Desain Elegan & Ringan',
                'fitur_singkat' => 'Layout klasik rapi • Animasi lembut',
                'badge_class' => 'bg-sage/95 text-white ring-1 ring-white/30',
                'chip_class' => 'bg-sage/10 text-sage ring-1 ring-sage/25',
                'card_ring' => 'ring-1 ring-champagne/25',
            ],
            'premium' => [
                'kode' => 'premium',
                'label' => 'Premium',
                'ringkasan' => 'Detail Artistik & Adat',
                'fitur_singkat' => 'Cover spesial • Timeline & marquee',
                'badge_class' => 'bg-champagne text-charcoal ring-1 ring-white/40 shadow-sm',
                'chip_class' => 'bg-champagne/15 text-charcoal ring-1 ring-champagne/40',
                'card_ring' => 'ring-1 ring-champagne/50 shadow-sm',
            ],
            'eksklusif' => [
                'kode' => 'eksklusif',
                'label' => 'Eksklusif',
                'ringkasan' => 'Motion & Luxury',
                'fitur_singkat' => 'Tirai sinematik • Efek partikel & kilau',
                'badge_class' => 'bg-charcoal text-champagne ring-1 ring-champagne/60 shadow-md',
                'chip_class' => 'bg-charcoal text-champagne ring-1 ring-champagne/50',
                'card_ring' => 'ring-2 ring-champagne/75 shadow-md',
            ],
        ];

        return $daftar[$kode];
    }

    /**
     * Ringkasan desain tipografi, nuansa, dan dukungan Mode Tanpa Foto (TF) per tema.
     *
     * @return array{
     *     font_label: string,
     *     deskripsi: string,
     *     dukungan_tf: bool,
     *     warna_aksen: string
     * }
     */
    public function infoDesain(): array
    {
        $katalog = [
            'rustic-floral' => [
                'font_label' => 'Cormorant Garamond + Great Vibes',
                'deskripsi' => 'Botanical pastel hangat dengan ornamen floral goyang lembut dan aksen kaligrafi.',
                'dukungan_tf' => true,
                'warna_aksen' => '#4B6358',
            ],
            'editorial-monokrom' => [
                'font_label' => 'Gilda Display + Inter Editorial',
                'deskripsi' => 'Tata letak majalah editorial modern minimalis dengan tipografi high-fashion dan grid bersih.',
                'dukungan_tf' => true,
                'warna_aksen' => '#18181B',
            ],
            'luxury-noir' => [
                'font_label' => 'Cinzel Royal + Cormorant Garamond',
                'deskripsi' => 'Nuansa ballroom malam gelap eksklusif berpadu kilau emas sampanye dan monogram mewah.',
                'dukungan_tf' => true,
                'warna_aksen' => '#D4AF37',
            ],
            'royal-ivory' => [
                'font_label' => 'Playfair Display + Great Vibes',
                'deskripsi' => 'Kemewahan klasik bernuansa ivory mutiara dengan bingkai lengkung katedral dan aksen perunggu.',
                'dukungan_tf' => true,
                'warna_aksen' => '#9E7B4F',
            ],
            'velvet-garden' => [
                'font_label' => 'Gilda Display + Great Vibes Motion',
                'deskripsi' => 'Taman beludru zamrud dengan kelopak melayang, kilau kunang-kunang, dan transisi halus.',
                'dukungan_tf' => true,
                'warna_aksen' => '#C8A464',
            ],
            'adat-jawa' => [
                'font_label' => 'Berkshire Swash + Marcellus',
                'deskripsi' => 'Keagungan keraton Jawa bernuansa Joglo, wayang kulit, batik Kawung, dan bunga keraton klasik.',
                'dukungan_tf' => true,
                'warna_aksen' => '#BFA15F',
            ],
            'sunda-heritage' => [
                'font_label' => 'Berkshire Swash + Marcellus',
                'deskripsi' => 'Pesona adat Sunda priangan berlatar Julang Ngapak, ornamen siger emas, melati, dan Mega Mendung.',
                'dukungan_tf' => true,
                'warna_aksen' => '#8B2635',
            ],
            'islami-syari' => [
                'font_label' => 'Amiri Kaligrafi + Cormorant',
                'deskripsi' => 'Desain santun bernuansa hijau zamrud dan lengkung mihrab, ramah mode privasi tanpa foto.',
                'dukungan_tf' => true,
                'warna_aksen' => '#184D47',
            ],
            'islamic-heavenly' => [
                'font_label' => 'Amiri + Gilda Display Motion',
                'deskripsi' => 'Nuansa malam safir surgawi berhias bintang berkilau, lengkung bulan sabit, dan arabesque.',
                'dukungan_tf' => true,
                'warna_aksen' => '#D9B664',
            ],
        ];

        return $katalog[$this->slug] ?? [
            'font_label' => 'Cormorant Garamond + Poppins',
            'deskripsi' => 'Animasi sampul interaktif, pilihan font custom, musik latar, RSVP, dan mode tanpa foto.',
            'dukungan_tf' => true,
            'warna_aksen' => '#4B6358',
        ];
    }

    public function urlGambarPratinjau(): ?string
    {
        if (! $this->gambar_pratinjau) {
            return null;
        }

        if (Str::startsWith($this->gambar_pratinjau, ['http://', 'https://', 'aset-demo/', 'aset-tema/'])) {
            return asset($this->gambar_pratinjau);
        }

        return Storage::disk('public')->url($this->gambar_pratinjau);
    }
}
