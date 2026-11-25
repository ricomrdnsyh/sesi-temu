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
     * Daftar kategori gaya tema undangan yang tersedia pada katalog.
     *
     * @var array<string, string>
     */
    public const KATEGORI_TERSEDIA = [
        'adat' => 'Adat',
        'islami' => 'Islami',
        'floral' => 'Floral',
        'elegan' => 'Elegan',
        'modern' => 'Modern',
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

    public function kategoriKode(): string
    {
        $nilai = strtolower(trim((string) ($this->kategori ?: 'modern')));

        $normalisasi = match ($nilai) {
            'luxury' => 'elegan',
            'motion' => 'floral',
            default => $nilai,
        };

        return array_key_exists($normalisasi, self::KATEGORI_TERSEDIA) ? $normalisasi : 'modern';
    }

    public function kategoriLabel(): string
    {
        return self::KATEGORI_TERSEDIA[$this->kategoriKode()];
    }

    /**
     * Menghitung ringkasan jumlah tema dan harga mulai per kategori gaya.
     *
     * @param  EloquentCollection<int, Tema>|Collection<int, Tema>  $daftarTema
     * @return Collection<string, array{kode: string, label: string, jumlah: int, harga_mulai: int}>
     */
    public static function ringkasanKategori(EloquentCollection|Collection $daftarTema): Collection
    {
        return collect(self::KATEGORI_TERSEDIA)->map(function (string $label, string $kode) use ($daftarTema): array {
            $temaKategori = $daftarTema->filter(fn (Tema $tema): bool => $tema->kategoriKode() === $kode);
            $hargaMinimal = $temaKategori->min(fn (Tema $tema): int => $tema->hargaNominal());

            return [
                'kode' => $kode,
                'label' => $label,
                'jumlah' => $temaKategori->count(),
                'harga_mulai' => $hargaMinimal ?? self::HARGA_BAWAAN_TIER['basic'],
            ];
        });
    }

    /**
     * Metadata tampilan badge dan ringkasan gaya per kategori tema.
     *
     * @return array{
     *     kode: string,
     *     label: string,
     *     ringkasan: string,
     *     badge_class: string,
     *     chip_class: string,
     *     card_ring: string
     * }
     */
    public function infoKategori(): array
    {
        $kode = $this->kategoriKode();

        $daftar = [
            'adat' => [
                'kode' => 'adat',
                'label' => 'Adat',
                'ringkasan' => 'Budaya & Adat Nusantara',
                'badge_class' => 'bg-champagne text-charcoal ring-1 ring-white/40 shadow-xs',
                'chip_class' => 'bg-champagne/15 text-[#7A5B22] ring-1 ring-champagne/40',
                'card_ring' => 'ring-1 ring-champagne/45',
            ],
            'islami' => [
                'kode' => 'islami',
                'label' => 'Islami',
                'ringkasan' => 'Syar\'i & Penuh Makna',
                'badge_class' => 'bg-[#184D47] text-white ring-1 ring-white/30 shadow-xs',
                'chip_class' => 'bg-[#184D47]/10 text-[#184D47] ring-1 ring-[#184D47]/25',
                'card_ring' => 'ring-1 ring-champagne/35',
            ],
            'floral' => [
                'kode' => 'floral',
                'label' => 'Floral',
                'ringkasan' => 'Taman & Nuansa Bunga',
                'badge_class' => 'bg-sage text-white ring-1 ring-white/30 shadow-xs',
                'chip_class' => 'bg-sage/10 text-sage ring-1 ring-sage/25',
                'card_ring' => 'ring-1 ring-champagne/35',
            ],
            'elegan' => [
                'kode' => 'elegan',
                'label' => 'Elegan',
                'ringkasan' => 'Klasik & Berkelas',
                'badge_class' => 'bg-charcoal text-champagne ring-1 ring-champagne/55 shadow-xs',
                'chip_class' => 'bg-charcoal text-champagne ring-1 ring-champagne/45',
                'card_ring' => 'ring-1 ring-champagne/55',
            ],
            'modern' => [
                'kode' => 'modern',
                'label' => 'Modern',
                'ringkasan' => 'Minimalis & Estetik',
                'badge_class' => 'bg-zinc-800 text-white ring-1 ring-white/25 shadow-xs',
                'chip_class' => 'bg-zinc-100 text-zinc-700 ring-1 ring-zinc-300/70',
                'card_ring' => 'ring-1 ring-champagne/30',
            ],
        ];

        return $daftar[$kode];
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
     * Daftar kurasi lagu latar populer bawaan platform yang disesuaikan per karakter tema.
     *
     * @return list<array{judul: string, artis: string, path_file: string, kategori: string, urutan: int}>
     */
    public static function katalogMusikBawaan(): array
    {
        return [
            [
                'judul' => 'Penjaga Hati',
                'artis' => 'Nadhif Basalamah',
                'path_file' => 'musik/penjaga-hati.mp3',
                'kategori' => 'Pop Romantis & Floral',
                'urutan' => 1,
            ],
            [
                'judul' => 'A Thousand Years',
                'artis' => 'Christina Perri',
                'path_file' => 'musik/a-thousand-years.mp3',
                'kategori' => 'Botanical & Garden',
                'urutan' => 2,
            ],
            [
                'judul' => 'Until I Found You',
                'artis' => 'Stephen Sanchez',
                'path_file' => 'musik/until-i-found-you.mp3',
                'kategori' => 'Modern & Editorial',
                'urutan' => 3,
            ],
            [
                'judul' => "Can't Help Falling in Love (Grand Piano)",
                'artis' => 'Romantic Ballroom Cover',
                'path_file' => 'musik/cant-help-falling-in-love.mp3',
                'kategori' => 'Elegan & Gala',
                'urutan' => 4,
            ],
            [
                'judul' => 'Beautiful in White',
                'artis' => 'Shane Filan',
                'path_file' => 'musik/beautiful-in-white.mp3',
                'kategori' => 'Klasik & Royal',
                'urutan' => 5,
            ],
            [
                'judul' => 'Lagu Pernikahan Kita',
                'artis' => 'Arsy Widianto & Tiara Andini',
                'path_file' => 'musik/lagu-pernikahan-kita.mp3',
                'kategori' => 'Pop Romantis Indonesia',
                'urutan' => 6,
            ],
            [
                'judul' => 'Gending Temanten Kebo Giro',
                'artis' => 'Karawitan Adat Jawa',
                'path_file' => 'musik/gamelan-lembut.mp3',
                'kategori' => 'Adat Jawa',
                'urutan' => 7,
            ],
            [
                'judul' => 'Degung Sabilulungan',
                'artis' => 'Kacapi Suling Priangan',
                'path_file' => 'musik/degung-sabilulungan.mp3',
                'kategori' => 'Adat Sunda',
                'urutan' => 8,
            ],
            [
                'judul' => 'Barakallahu Lakuma',
                'artis' => 'Maher Zain',
                'path_file' => 'musik/barakallahu-lakuma.mp3',
                'kategori' => 'Islami & Walimah',
                'urutan' => 9,
            ],
            [
                'judul' => "Rahmatun Lil'Alameen",
                'artis' => 'Maher Zain',
                'path_file' => 'musik/rahmatun-lil-alameen.mp3',
                'kategori' => 'Islami & Syahdu',
                'urutan' => 10,
            ],
        ];
    }

    /**
     * Lagu latar bawaan yang paling selaras untuk masing-masing slug tema.
     */
    public static function musikBawaanUntukSlug(?string $slug): string
    {
        return match ($slug) {
            'rustic-floral' => 'musik/penjaga-hati.mp3',
            'velvet-garden' => 'musik/a-thousand-years.mp3',
            'editorial-monokrom' => 'musik/until-i-found-you.mp3',
            'luxury-noir' => 'musik/cant-help-falling-in-love.mp3',
            'royal-ivory' => 'musik/beautiful-in-white.mp3',
            'adat-jawa' => 'musik/gamelan-lembut.mp3',
            'sunda-heritage' => 'musik/degung-sabilulungan.mp3',
            'islami-syari' => 'musik/barakallahu-lakuma.mp3',
            'islamic-heavenly' => 'musik/rahmatun-lil-alameen.mp3',
            default => 'musik/penjaga-hati.mp3',
        };
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
                'latar_css' => 'radial-gradient(circle at 50% 42%, #637D70 0%, #3E5349 54%, #1F2E27 100%)',
                'lantai_hex' => '#F3EEE6',
                'layar_kiri_bg' => 'linear-gradient(180deg, #4B6358 0%, #2C3C34 100%)',
                'layar_kiri_teks' => '#FDFBF7',
                'kotak_countdown_bg' => '#FDFBF7',
                'kotak_countdown_teks' => '#2F4037',
                'tombol_kiri_bg' => '#FDFBF7',
                'tombol_kiri_teks' => '#2F4037',
                'kartu_arch_bg' => '#FDFBF7',
                'kartu_arch_teks' => '#1F2937',
                'tengah_scrim' => 'radial-gradient(ellipse at center, rgba(253,251,247,0.92) 30%, rgba(253,251,247,0.48) 74%, rgba(253,251,247,0.02) 100%)',
                'tengah_teks' => '#223029',
                'tengah_aksen' => '#B86B4B',
                'kanan_bg' => '#FDFBF7',
                'kanan_teks' => '#1F2937',
                'tanggal_pendek' => '24 · 10 · 26',
                'tagline' => 'The Wedding Of',
                'gelap' => false,
                'editorial' => false,
                'islami' => false,
            ],
            'editorial-monokrom' => [
                'latar_css' => 'radial-gradient(circle at 50% 42%, #3A3D45 0%, #22242A 54%, #111114 100%)',
                'lantai_hex' => '#F2EFE9',
                'layar_kiri_bg' => 'linear-gradient(180deg, #18181B 0%, #09090B 100%)',
                'layar_kiri_teks' => '#FAF9F6',
                'kotak_countdown_bg' => '#0D0D10',
                'kotak_countdown_teks' => '#FAF9F6',
                'tombol_kiri_bg' => '#FAF9F6',
                'tombol_kiri_teks' => '#18181B',
                'kartu_arch_bg' => '#FFFFFF',
                'kartu_arch_teks' => '#18181B',
                'tengah_scrim' => 'linear-gradient(180deg, rgba(12,12,15,0.82) 0%, rgba(12,12,15,0.32) 38%, rgba(10,10,13,0.92) 100%)',
                'tengah_teks' => '#FAF9F6',
                'tengah_aksen' => '#E4E4E7',
                'kanan_bg' => '#FAF9F6',
                'kanan_teks' => '#18181B',
                'tanggal_pendek' => '07 · 11 · 26',
                'tagline' => 'The Wedding Edition',
                'gelap' => true,
                'editorial' => true,
                'islami' => false,
            ],
            'luxury-noir' => [
                'latar_css' => 'radial-gradient(circle at 50% 42%, #322E3D 0%, #16151E 54%, #09090D 100%)',
                'lantai_hex' => '#F3EEE6',
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
                'latar_css' => 'radial-gradient(circle at 50% 42%, #8C7151 0%, #634D34 54%, #3B2E25 100%)',
                'lantai_hex' => '#F3EEE6',
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
                'latar_css' => 'radial-gradient(circle at 50% 38%, #2E524B 0%, #17302B 54%, #0B1916 100%)',
                'lantai_hex' => '#F3EEE6',
                'layar_kiri_bg' => 'linear-gradient(180deg, #294443 0%, #132623 100%)',
                'layar_kiri_teks' => '#FDFBF7',
                'kotak_countdown_bg' => '#FDFBF7',
                'kotak_countdown_teks' => '#132623',
                'tombol_kiri_bg' => '#DFC285',
                'tombol_kiri_teks' => '#132623',
                'kartu_arch_bg' => '#FDFBF7',
                'kartu_arch_teks' => '#1F3431',
                'tengah_scrim' => 'radial-gradient(ellipse at center, rgba(14,30,24,0.68) 28%, rgba(14,30,24,0.34) 68%, rgba(14,30,24,0.02) 100%)',
                'tengah_teks' => '#FFFFFF',
                'tengah_aksen' => '#F3DFA2',
                'kanan_bg' => '#132623',
                'kanan_teks' => '#F4F8F6',
                'tanggal_pendek' => '11 · 12 · 26',
                'tagline' => 'Velvet Garden Motion',
                'gelap' => true,
                'editorial' => false,
                'islami' => false,
            ],
            'adat-jawa' => [
                'latar_css' => 'radial-gradient(circle at 50% 42%, #7D5337 0%, #472A1C 52%, #1E110A 100%)',
                'lantai_hex' => '#F3EEE6',
                'layar_kiri_bg' => 'linear-gradient(180deg, #472A1C 0%, #2B180F 100%)',
                'layar_kiri_teks' => '#FFFAF5',
                'kotak_countdown_bg' => '#D7BB83',
                'kotak_countdown_teks' => '#2B180F',
                'tombol_kiri_bg' => 'linear-gradient(135deg, #ECD298 0%, #C79F4B 100%)',
                'tombol_kiri_teks' => '#24130A',
                'kartu_arch_bg' => '#FFFAF5',
                'kartu_arch_teks' => '#2B180F',
                'tengah_scrim' => 'linear-gradient(180deg, rgba(20,10,5,0.58) 0%, rgba(20,10,5,0.08) 20%, rgba(20,10,5,0.0) 44%, rgba(24,12,6,0.16) 56%, rgba(22,11,6,0.88) 76%, rgba(16,8,4,0.98) 100%)',
                'tengah_teks' => '#FFFBF4',
                'tengah_aksen' => '#E5C98B',
                'kanan_bg' => '#FFFAF5',
                'kanan_teks' => '#2B180F',
                'tanggal_pendek' => '28 · 12 · 26',
                'tagline' => 'Pawiwahan',
                'gelap' => true,
                'editorial' => false,
                'islami' => false,
            ],
            'sunda-heritage' => [
                'latar_css' => 'radial-gradient(circle at 50% 42%, #922D3C 0%, #581822 52%, #290A10 100%)',
                'lantai_hex' => '#F3EEE6',
                'layar_kiri_bg' => 'linear-gradient(180deg, #5A1E1E 0%, #3E1212 100%)',
                'layar_kiri_teks' => '#FAF4E8',
                'kotak_countdown_bg' => '#E7C87D',
                'kotak_countdown_teks' => '#3B1414',
                'tombol_kiri_bg' => 'linear-gradient(135deg, #E4C578 0%, #B88B32 100%)',
                'tombol_kiri_teks' => '#351010',
                'kartu_arch_bg' => '#FFFBF4',
                'kartu_arch_teks' => '#4A2020',
                'tengah_scrim' => 'linear-gradient(180deg, rgba(40,12,14,0.72) 0%, rgba(40,12,14,0.12) 22%, rgba(40,12,14,0.0) 46%, rgba(40,12,14,0.18) 58%, rgba(40,12,14,0.90) 78%, rgba(28,8,10,0.98) 100%)',
                'tengah_teks' => '#FFFDF8',
                'tengah_aksen' => '#E7C87D',
                'kanan_bg' => '#FAF4E8',
                'kanan_teks' => '#4A2020',
                'tanggal_pendek' => '19 · 12 · 26',
                'tagline' => 'Sampurasun',
                'gelap' => true,
                'editorial' => false,
                'islami' => false,
            ],
            'islami-syari' => [
                'latar_css' => 'radial-gradient(circle at 50% 42%, #1C5D55 0%, #0E3A36 54%, #071E1C 100%)',
                'lantai_hex' => '#F3EEE6',
                'layar_kiri_bg' => 'linear-gradient(180deg, #0E3A36 0%, #08221F 100%)',
                'layar_kiri_teks' => '#F7FBF8',
                'kotak_countdown_bg' => '#E5C982',
                'kotak_countdown_teks' => '#092623',
                'tombol_kiri_bg' => 'linear-gradient(135deg, #EFE0B4 0%, #C5A059 100%)',
                'tombol_kiri_teks' => '#092623',
                'kartu_arch_bg' => '#FCFEFD',
                'kartu_arch_teks' => '#0E3A36',
                'tengah_scrim' => 'radial-gradient(ellipse at center, rgba(244,250,246,0.92) 28%, rgba(244,250,246,0.48) 72%, rgba(244,250,246,0.02) 100%)',
                'tengah_teks' => '#FFFDF8',
                'tengah_aksen' => '#E6D19C',
                'kanan_bg' => '#F7FBF8',
                'kanan_teks' => '#0E3A36',
                'tanggal_pendek' => '26 · 12 · 26',
                'tagline' => 'Walimatul Ursy',
                'gelap' => true,
                'editorial' => false,
                'islami' => true,
            ],
            'islamic-heavenly' => [
                'latar_css' => 'radial-gradient(circle at 50% 42%, #24406B 0%, #102038 52%, #060D18 100%)',
                'lantai_hex' => '#F3EEE6',
                'layar_kiri_bg' => 'linear-gradient(180deg, #13263E 0%, #091322 100%)',
                'layar_kiri_teks' => '#E6EEF8',
                'kotak_countdown_bg' => '#18304F',
                'kotak_countdown_teks' => '#F3E5AB',
                'tombol_kiri_bg' => 'linear-gradient(135deg, #F3E5AB 0%, #D9B664 100%)',
                'tombol_kiri_teks' => '#091322',
                'kartu_arch_bg' => '#12243B',
                'kartu_arch_teks' => '#E6EEF8',
                'tengah_scrim' => 'radial-gradient(ellipse at center, rgba(14,27,42,0.82) 32%, rgba(14,27,42,0.40) 74%, rgba(14,27,42,0.02) 100%)',
                'tengah_teks' => '#FAF3DE',
                'tengah_aksen' => '#D9B664',
                'kanan_bg' => '#0D1B2E',
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
