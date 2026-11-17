<?php

namespace App\Models;

use App\Support\MediaPublik;
use App\Support\PengaturanSesiTemu;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
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
        'diskon_tipe',
        'diskon_nilai',
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
            'diskon_nilai' => 'integer',
            'aktif' => 'boolean',
        ];
    }

    public function undangan(): HasMany
    {
        return $this->hasMany(Undangan::class, 'tema_id');
    }

    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'tema_id');
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

    public function hargaAsliNominal(): int
    {
        return (int) ($this->harga ?? self::hargaBawaanTier($this->tierKode()));
    }

    public function hargaAsliFormatted(): string
    {
        return self::formatRupiah($this->hargaAsliNominal());
    }

    public function diskonTipe(): ?string
    {
        return in_array($this->diskon_tipe, ['nominal', 'persen'], true) ? $this->diskon_tipe : null;
    }

    public function diskonNilai(): int
    {
        return max(0, (int) ($this->diskon_nilai ?? 0));
    }

    public function potonganDiskonNominal(): int
    {
        $hargaAsli = $this->hargaAsliNominal();
        $tipe = $this->diskonTipe();
        $nilai = $this->diskonNilai();

        if ($hargaAsli <= 0 || $tipe === null || $nilai <= 0) {
            return 0;
        }

        if ($tipe === 'persen') {
            return min($hargaAsli, (int) floor($hargaAsli * min(100, $nilai) / 100));
        }

        return min($hargaAsli, $nilai);
    }

    public function adaDiskon(): bool
    {
        return $this->potonganDiskonNominal() > 0;
    }

    public function persenDiskon(): int
    {
        $hargaAsli = $this->hargaAsliNominal();
        if ($hargaAsli <= 0 || ! $this->adaDiskon()) {
            return 0;
        }

        return (int) round(($this->potonganDiskonNominal() / $hargaAsli) * 100);
    }

    public function labelBadgeDiskon(): ?string
    {
        if (! $this->adaDiskon()) {
            return null;
        }

        if ($this->diskonTipe() === 'persen') {
            return 'Diskon '.min(100, $this->diskonNilai()).'%';
        }

        return 'Hemat '.self::formatRupiah($this->potonganDiskonNominal());
    }

    public function hargaNominal(): int
    {
        return max(0, $this->hargaAsliNominal() - $this->potonganDiskonNominal());
    }

    public function hargaFormatted(): string
    {
        return self::formatRupiah($this->hargaNominal());
    }

    public function hargaTerimaBeresFormatted(): string
    {
        return self::formatRupiah($this->hargaNominal() + PengaturanSesiTemu::biayaTerimaBeres());
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
     * Menghitung ringkasan jumlah tema dan harga mulai per tingkatan tier.
     *
     * @param  EloquentCollection<int, Tema>|Collection<int, Tema>  $daftarTema
     * @return Collection<string, array{kode: string, label: string, jumlah: int, harga_mulai: int}>
     */
    public static function ringkasanTier(EloquentCollection|Collection $daftarTema): Collection
    {
        return collect(self::TIER_TERSEDIA)->map(function (string $label, string $kode) use ($daftarTema): array {
            $temaTier = $daftarTema->filter(fn (Tema $tema): bool => $tema->tierKode() === $kode);
            $hargaMinimal = $temaTier->min(fn (Tema $tema): int => $tema->hargaNominal());

            return [
                'kode' => $kode,
                'label' => $label,
                'jumlah' => $temaTier->count(),
                'harga_mulai' => $hargaMinimal ?? self::hargaBawaanTier($kode),
            ];
        });
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
        return MediaPublik::url($this->gambar_pratinjau);
    }

    /**
     * Token visual palet poster sampul bergaya triple-phone yang tersinkronisasi dengan tema undangan.
     *
     * @return array{
     *     latar_css: string,
     *     lantai_hex: string,
     *     layar_kiri_bg: string,
     *     layar_kiri_teks: string,
     *     kotak_countdown_bg: string,
     *     kotak_countdown_teks: string,
     *     tombol_kiri_bg: string,
     *     tombol_kiri_teks: string,
     *     kartu_arch_bg: string,
     *     kartu_arch_teks: string,
     *     tengah_scrim: string,
     *     tengah_teks: string,
     *     tengah_aksen: string,
     *     kanan_bg: string,
     *     kanan_teks: string,
     *     tanggal_pendek: string,
     *     tagline: string,
     *     gelap: bool,
     *     editorial: bool,
     *     islami: bool
     * }
     */
    public function infoPoster(): array
    {
        $palet = [
            'rustic-floral' => [
                'latar_css' => 'radial-gradient(circle at 50% 22%, #6C8477 0%, #4C6357 58%, #34473D 100%)',
                'lantai_hex' => '#EFECE5',
                'layar_kiri_bg' => 'linear-gradient(180deg, #4B6358 0%, #394D44 100%)',
                'layar_kiri_teks' => '#FFFFFF',
                'kotak_countdown_bg' => '#FFFFFF',
                'kotak_countdown_teks' => '#1F2937',
                'tombol_kiri_bg' => '#FFFFFF',
                'tombol_kiri_teks' => '#2F4037',
                'kartu_arch_bg' => '#FDFBF7',
                'kartu_arch_teks' => '#1F2937',
                'tengah_scrim' => 'radial-gradient(ellipse at center, rgba(253,251,247,0.92) 30%, rgba(253,251,247,0.48) 74%, rgba(253,251,247,0.02) 100%)',
                'tengah_teks' => '#1F2937',
                'tengah_aksen' => '#8E7142',
                'kanan_bg' => '#FDFBF7',
                'kanan_teks' => '#1F2937',
                'tanggal_pendek' => '24 · 10 · 26',
                'tagline' => 'The Wedding Of',
                'gelap' => false,
                'editorial' => false,
                'islami' => false,
            ],
            'editorial-monokrom' => [
                'latar_css' => 'radial-gradient(circle at 50% 22%, #50545C 0%, #31343A 58%, #18181B 100%)',
                'lantai_hex' => '#EFECE5',
                'layar_kiri_bg' => 'linear-gradient(180deg, #18181B 0%, #09090B 100%)',
                'layar_kiri_teks' => '#FAF9F6',
                'kotak_countdown_bg' => '#FAF9F6',
                'kotak_countdown_teks' => '#18181B',
                'tombol_kiri_bg' => '#FAF9F6',
                'tombol_kiri_teks' => '#18181B',
                'kartu_arch_bg' => '#FFFFFF',
                'kartu_arch_teks' => '#18181B',
                'tengah_scrim' => 'radial-gradient(ellipse at center, rgba(250,249,246,0.90) 32%, rgba(250,249,246,0.45) 75%, rgba(250,249,246,0.05) 100%)',
                'tengah_teks' => '#18181B',
                'tengah_aksen' => '#52525B',
                'kanan_bg' => '#FAF9F6',
                'kanan_teks' => '#18181B',
                'tanggal_pendek' => '07 · 11 · 26',
                'tagline' => 'The Wedding Edition',
                'gelap' => false,
                'editorial' => true,
                'islami' => false,
            ],
            'luxury-noir' => [
                'latar_css' => 'radial-gradient(circle at 50% 20%, #2C2C34 0%, #16161B 56%, #0B0B0F 100%)',
                'lantai_hex' => '#EFECE5',
                'layar_kiri_bg' => 'linear-gradient(180deg, #16151B 0%, #0B0B0F 100%)',
                'layar_kiri_teks' => '#F5EFE6',
                'kotak_countdown_bg' => '#222029',
                'kotak_countdown_teks' => '#F3E5AB',
                'tombol_kiri_bg' => '#D4AF37',
                'tombol_kiri_teks' => '#0D0D10',
                'kartu_arch_bg' => '#1B1A22',
                'kartu_arch_teks' => '#F5EFE6',
                'tengah_scrim' => 'radial-gradient(ellipse at center, rgba(11,11,15,0.84) 32%, rgba(11,11,15,0.42) 76%, rgba(11,11,15,0.02) 100%)',
                'tengah_teks' => '#FAF2DB',
                'tengah_aksen' => '#D4AF37',
                'kanan_bg' => '#121217',
                'kanan_teks' => '#F5EFE6',
                'tanggal_pendek' => '08 · 11 · 26',
                'tagline' => 'The Grand Celebration',
                'gelap' => true,
                'editorial' => false,
                'islami' => false,
            ],
            'royal-ivory' => [
                'latar_css' => 'radial-gradient(circle at 50% 22%, #8C7151 0%, #6A5339 58%, #4A3824 100%)',
                'lantai_hex' => '#EFECE5',
                'layar_kiri_bg' => 'linear-gradient(180deg, #7B603F 0%, #58432B 100%)',
                'layar_kiri_teks' => '#FAF6EE',
                'kotak_countdown_bg' => '#FFFFFF',
                'kotak_countdown_teks' => '#3B2E25',
                'tombol_kiri_bg' => '#FFFFFF',
                'tombol_kiri_teks' => '#58432B',
                'kartu_arch_bg' => '#FFFFFF',
                'kartu_arch_teks' => '#3B2E25',
                'tengah_scrim' => 'radial-gradient(ellipse at center, rgba(251,248,243,0.90) 30%, rgba(251,248,243,0.45) 75%, rgba(251,248,243,0.02) 100%)',
                'tengah_teks' => '#3B2E25',
                'tengah_aksen' => '#9E7B4F',
                'kanan_bg' => '#FBF8F3',
                'kanan_teks' => '#3B2E25',
                'tanggal_pendek' => '15 · 11 · 26',
                'tagline' => 'The Royal Wedding',
                'gelap' => false,
                'editorial' => false,
                'islami' => false,
            ],
            'velvet-garden' => [
                'latar_css' => 'radial-gradient(circle at 50% 20%, #6C8688 0%, #415D5E 56%, #1D3532 100%)',
                'lantai_hex' => '#EFECE5',
                'layar_kiri_bg' => 'linear-gradient(180deg, #3E5A5C 0%, #203734 100%)',
                'layar_kiri_teks' => '#FFFFFF',
                'kotak_countdown_bg' => '#FFFFFF',
                'kotak_countdown_teks' => '#1F3431',
                'tombol_kiri_bg' => '#FFFFFF',
                'tombol_kiri_teks' => '#253D3A',
                'kartu_arch_bg' => '#FDFBF7',
                'kartu_arch_teks' => '#1F3431',
                'tengah_scrim' => 'radial-gradient(ellipse at center, rgba(253,251,247,0.88) 28%, rgba(253,251,247,0.45) 68%, rgba(253,251,247,0.02) 100%)',
                'tengah_teks' => '#1F3431',
                'tengah_aksen' => '#9E7E41',
                'kanan_bg' => '#FDFBF7',
                'kanan_teks' => '#1F3431',
                'tanggal_pendek' => '11 · 12 · 26',
                'tagline' => 'Velvet Garden Motion',
                'gelap' => false,
                'editorial' => false,
                'islami' => false,
            ],
            'adat-jawa' => [
                'latar_css' => 'radial-gradient(circle at 50% 22%, #6E4730 0%, #4A2D1C 58%, #23150E 100%)',
                'lantai_hex' => '#EFECE5',
                'layar_kiri_bg' => 'linear-gradient(180deg, #4A2E1E 0%, #29180F 100%)',
                'layar_kiri_teks' => '#FAF3E6',
                'kotak_countdown_bg' => '#FCF7EB',
                'kotak_countdown_teks' => '#332012',
                'tombol_kiri_bg' => '#D4AF37',
                'tombol_kiri_teks' => '#1C100A',
                'kartu_arch_bg' => '#FCF7EB',
                'kartu_arch_teks' => '#332012',
                'tengah_scrim' => 'radial-gradient(ellipse at center, rgba(252,247,235,0.90) 28%, rgba(252,247,235,0.45) 70%, rgba(252,247,235,0.02) 100%)',
                'tengah_teks' => '#3B1D12',
                'tengah_aksen' => '#A8823B',
                'kanan_bg' => '#FCF7EB',
                'kanan_teks' => '#332012',
                'tanggal_pendek' => '12 · 12 · 26',
                'tagline' => 'Pawiwahan Ageng',
                'gelap' => false,
                'editorial' => false,
                'islami' => false,
            ],
            'sunda-heritage' => [
                'latar_css' => 'radial-gradient(circle at 50% 22%, #862C3B 0%, #631B28 58%, #410F18 100%)',
                'lantai_hex' => '#EFECE5',
                'layar_kiri_bg' => 'linear-gradient(180deg, #6E2C2C 0%, #4B1818 100%)',
                'layar_kiri_teks' => '#FAF4E8',
                'kotak_countdown_bg' => '#FFFBF4',
                'kotak_countdown_teks' => '#4A2020',
                'tombol_kiri_bg' => '#FFFBF4',
                'tombol_kiri_teks' => '#5A1E1E',
                'kartu_arch_bg' => '#FFFBF4',
                'kartu_arch_teks' => '#4A2020',
                'tengah_scrim' => 'radial-gradient(ellipse at center, rgba(250,244,232,0.90) 30%, rgba(250,244,232,0.48) 72%, rgba(250,244,232,0.02) 100%)',
                'tengah_teks' => '#5A1E1E',
                'tengah_aksen' => '#B58931',
                'kanan_bg' => '#FAF4E8',
                'kanan_teks' => '#4A2020',
                'tanggal_pendek' => '19 · 12 · 26',
                'tagline' => 'Sampurasun • Sunda Heritage',
                'gelap' => false,
                'editorial' => false,
                'islami' => false,
            ],
            'islami-syari' => [
                'latar_css' => 'radial-gradient(circle at 50% 22%, #25685F 0%, #184D47 58%, #0E312C 100%)',
                'lantai_hex' => '#EFECE5',
                'layar_kiri_bg' => 'linear-gradient(180deg, #184D47 0%, #0F342F 100%)',
                'layar_kiri_teks' => '#FFFFFF',
                'kotak_countdown_bg' => '#FFFFFF',
                'kotak_countdown_teks' => '#184D47',
                'tombol_kiri_bg' => '#FFFFFF',
                'tombol_kiri_teks' => '#184D47',
                'kartu_arch_bg' => '#FFFFFF',
                'kartu_arch_teks' => '#184D47',
                'tengah_scrim' => 'radial-gradient(ellipse at center, rgba(244,250,246,0.92) 28%, rgba(244,250,246,0.48) 72%, rgba(244,250,246,0.02) 100%)',
                'tengah_teks' => '#184D47',
                'tengah_aksen' => '#9E7D40',
                'kanan_bg' => '#F4FAF6',
                'kanan_teks' => '#184D47',
                'tanggal_pendek' => '26 · 12 · 26',
                'tagline' => 'Walimatul Ursy',
                'gelap' => false,
                'editorial' => false,
                'islami' => true,
            ],
            'islamic-heavenly' => [
                'latar_css' => 'radial-gradient(circle at 50% 20%, #28436E 0%, #162B47 56%, #0E1B2A 100%)',
                'lantai_hex' => '#EFECE5',
                'layar_kiri_bg' => 'linear-gradient(180deg, #13263E 0%, #0B1624 100%)',
                'layar_kiri_teks' => '#E6EEF8',
                'kotak_countdown_bg' => '#1A304C',
                'kotak_countdown_teks' => '#F3E5AB',
                'tombol_kiri_bg' => '#D9B664',
                'tombol_kiri_teks' => '#09131F',
                'kartu_arch_bg' => '#162940',
                'kartu_arch_teks' => '#E6EEF8',
                'tengah_scrim' => 'radial-gradient(ellipse at center, rgba(14,27,42,0.82) 32%, rgba(14,27,42,0.40) 74%, rgba(14,27,42,0.02) 100%)',
                'tengah_teks' => '#FAF3DE',
                'tengah_aksen' => '#D9B664',
                'kanan_bg' => '#112134',
                'kanan_teks' => '#E6EEF8',
                'tanggal_pendek' => '27 · 12 · 26',
                'tagline' => 'Walimatul Ursy',
                'gelap' => true,
                'editorial' => false,
                'islami' => true,
            ],
        ];

        return $palet[$this->slug] ?? $palet['rustic-floral'];
    }

    /**
     * Memindai seluruh file Blade tema yang tersedia di resources/views/tema/.
     *
     * @return array<string, string>
     */
    public static function daftarLokasiViewTersedia(): array
    {
        $direktori = resource_path('views/tema');
        if (! File::isDirectory($direktori)) {
            return [];
        }

        $daftar = [];
        foreach (File::allFiles($direktori) as $berkas) {
            $relatif = str_replace(['\\', '/'], '/', $berkas->getRelativePathname());
            if (! Str::endsWith($relatif, '.blade.php')) {
                continue;
            }

            $tanpaEkstensi = Str::beforeLast($relatif, '.blade.php');
            $viewDot = 'tema.'.str_replace('/', '.', $tanpaEkstensi);

            $segmenLabel = Str::endsWith($tanpaEkstensi, '/index')
                ? Str::beforeLast($tanpaEkstensi, '/index')
                : $tanpaEkstensi;

            $label = Str::of($segmenLabel)
                ->replace(['/', '-', '_'], ' ')
                ->title()
                ->value();

            $daftar[$viewDot] = "{$label} ({$viewDot})";
        }

        ksort($daftar);

        return $daftar;
    }
}
