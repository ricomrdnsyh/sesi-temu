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
     * @var list<string>
     */
    protected $fillable = [
        'nama_tema',
        'slug',
        'kategori',
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
