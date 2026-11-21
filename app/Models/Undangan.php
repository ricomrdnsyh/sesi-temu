<?php

namespace App\Models;

use App\Support\MediaPublik;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Undangan extends Model
{
    protected $table = 'undangan';

    /**
     * Daftar pilihan kombinasi desain font untuk halaman undangan.
     *
     * @var array<string, array{
     *     label: string,
     *     judul_css: string,
     *     isi_css: string,
     *     aksen_css: string,
     *     google_families: list<string>
     * }>
     */
    public const GAYA_FONT_TERSEDIA = [
        'bawaan' => [
            'label' => 'Bawaan Tema (Direkomendasikan)',
            'judul_css' => "'Cormorant Garamond', Georgia, serif",
            'isi_css' => "'Poppins', ui-sans-serif, system-ui, sans-serif",
            'aksen_css' => "'Great Vibes', cursive",
            'google_families' => ['Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,400', 'Great+Vibes', 'Poppins:wght@300;400;500;600;700'],
        ],
        'java_heritage' => [
            'label' => 'Cormorant Infant & Pinyon Script (Java Heritage Keraton)',
            'judul_css' => "'Cormorant Infant', 'Playfair Display', Georgia, serif",
            'isi_css' => "'Poppins', ui-sans-serif, system-ui, sans-serif",
            'aksen_css' => "'Pinyon Script', 'Great Vibes', cursive",
            'google_families' => ['Cormorant+Infant:ital,wght@0,500;0,600;0,700;1,400', 'Playfair+Display:ital,wght@0,500;0,600;0,700;1,400', 'Pinyon+Script', 'Great+Vibes', 'Poppins:wght@300;400;500;600;700'],
        ],
        'berkshire_adat' => [
            'label' => 'Berkshire Swash & Marcellus (Etnik Klasik TemuWaktu)',
            'judul_css' => "'Berkshire Swash', 'Marcellus', Georgia, serif",
            'isi_css' => "'Plus Jakarta Sans', 'Poppins', ui-sans-serif, system-ui, sans-serif",
            'aksen_css' => "'Berkshire Swash', cursive",
            'google_families' => ['Berkshire+Swash', 'Marcellus', 'Plus+Jakarta+Sans:wght@400;500;600;700', 'Poppins:wght@400;500;600'],
        ],
        'editorial_gilda' => [
            'label' => 'Gilda Display & Inter (Editorial TemuWaktu)',
            'judul_css' => "'Gilda Display', Georgia, serif",
            'isi_css' => "'Inter', 'Poppins', ui-sans-serif, system-ui, sans-serif",
            'aksen_css' => "'Great Vibes', cursive",
            'google_families' => ['Gilda+Display', 'Inter:wght@300;400;500;600;700', 'Great+Vibes', 'Poppins:wght@400;500;600'],
        ],
        'kaligrafi_vibes' => [
            'label' => 'Cormorant Garamond & Great Vibes (Kaligrafi Romantis)',
            'judul_css' => "'Cormorant Garamond', Georgia, serif",
            'isi_css' => "'Poppins', ui-sans-serif, system-ui, sans-serif",
            'aksen_css' => "'Great Vibes', cursive",
            'google_families' => ['Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,400', 'Great+Vibes', 'Poppins:wght@300;400;500;600;700'],
        ],
        'ningrat_cinzel' => [
            'label' => 'Cinzel Decorative & Cormorant (Mewah & Ballroom)',
            'judul_css' => "'Cinzel Decorative', 'Cinzel', 'Cormorant Garamond', Georgia, serif",
            'isi_css' => "'Plus Jakarta Sans', 'Poppins', ui-sans-serif, system-ui, sans-serif",
            'aksen_css' => "'Cormorant Garamond', Georgia, serif",
            'google_families' => ['Cinzel+Decorative:wght@700', 'Cinzel:wght@500;600;700', 'Cormorant+Garamond:ital,wght@0,500;0,600;1,400', 'Plus+Jakarta+Sans:wght@400;500;600;700', 'Poppins:wght@400;500;600'],
        ],
        'royal_playfair' => [
            'label' => 'Playfair Display & Alex Brush (Klasik Elegan)',
            'judul_css' => "'Playfair Display', Georgia, serif",
            'isi_css' => "'Poppins', ui-sans-serif, system-ui, sans-serif",
            'aksen_css' => "'Alex Brush', 'Great Vibes', cursive",
            'google_families' => ['Playfair+Display:ital,wght@0,500;0,600;0,700;1,400', 'Alex+Brush', 'Great+Vibes', 'Poppins:wght@300;400;500;600;700'],
        ],
        'arabesque_amiri' => [
            'label' => 'Amiri & Aref Ruqaa (Anggun Islami)',
            'judul_css' => "'Amiri', 'Cormorant Garamond', Georgia, serif",
            'isi_css' => "'Plus Jakarta Sans', 'Poppins', ui-sans-serif, system-ui, sans-serif",
            'aksen_css' => "'Aref Ruqaa', 'Amiri', Georgia, serif",
            'google_families' => ['Amiri:ital,wght@0,400;0,700;1,400', 'Aref+Ruqaa:wght@400;700', 'Cormorant+Garamond:wght@500;600;700', 'Plus+Jakarta+Sans:wght@400;500;600;700', 'Poppins:wght@400;500;600'],
        ],
        'modern_poppins' => [
            'label' => 'Poppins Clean (Minimalis Modern)',
            'judul_css' => "'Poppins', ui-sans-serif, system-ui, sans-serif",
            'isi_css' => "'Poppins', ui-sans-serif, system-ui, sans-serif",
            'aksen_css' => "'Poppins', ui-sans-serif, system-ui, sans-serif",
            'google_families' => ['Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400'],
        ],
    ];

    /**
     * Pemetaan font bawaan yang paling serasi untuk setiap tema.
     *
     * @var array<string, string>
     */
    public const FONT_BAWAAN_TEMA = [
        'rustic-floral' => 'kaligrafi_vibes',
        'editorial-monokrom' => 'editorial_gilda',
        'luxury-noir' => 'ningrat_cinzel',
        'royal-ivory' => 'royal_playfair',
        'velvet-garden' => 'editorial_gilda',
        'adat-jawa' => 'java_heritage',
        'sunda-heritage' => 'berkshire_adat',
        'islami-syari' => 'arabesque_amiri',
        'islamic-heavenly' => 'arabesque_amiri',
    ];

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
     *     gaya_font: string,
     *     tanpa_foto: bool,
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
            'gaya_font' => 'bawaan',
            'tanpa_foto' => false,
            'foto_sampul' => null,
            'foto_pembuka' => null,
            'foto_penutup' => null,
            'foto_latar_tema' => null,
            'hashtag' => '',
            'sosial_media' => [
                'instagram_pria' => '',
                'instagram_wanita' => '',
            ],
            'dress_code' => [
                'catatan' => '',
                'warna' => [],
            ],
            'turut_mengundang' => [
                'pihak_wanita' => '',
                'pihak_pria' => '',
            ],
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

    public function daftarTamu(): HasMany
    {
        return $this->hasMany(TamuUndangan::class, 'undangan_id')->latest();
    }

    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'undangan_id')->latest();
    }

    public function sudahKedaluwarsa(): bool
    {
        return $this->berlaku_sampai !== null && $this->berlaku_sampai->isPast();
    }

    public function sudahAktifPublik(): bool
    {
        return $this->status_publikasi && ! $this->sudahKedaluwarsa();
    }

    public function statusKode(): string
    {
        if ($this->sudahKedaluwarsa()) {
            return 'kedaluwarsa';
        }

        if ($this->status_publikasi) {
            return 'aktif';
        }

        return 'draft';
    }

    public function memilikiTransaksiTerkunci(): bool
    {
        $statusTerkunci = ['menunggu_verifikasi', 'lunas'];

        if ($this->relationLoaded('transaksi')) {
            return $this->transaksi->contains(
                static fn (Transaksi $transaksi): bool => in_array($transaksi->status, $statusTerkunci, true)
            );
        }

        return $this->transaksi()
            ->whereIn('status', $statusTerkunci)
            ->exists();
    }

    public function transaksiMenungguVerifikasi(): ?Transaksi
    {
        if ($this->relationLoaded('transaksi')) {
            return $this->transaksi->firstWhere('status', 'menunggu_verifikasi');
        }

        return $this->transaksi()
            ->where('status', 'menunggu_verifikasi')
            ->latest()
            ->first();
    }

    public function bolehAjukanPembayaran(): bool
    {
        return ! $this->sudahAktifPublik()
            && $this->transaksiMenungguVerifikasi() === null;
    }

    public function temaTerkunciUntukClient(): bool
    {
        return $this->sudahAktifPublik()
            || $this->transaksiMenungguVerifikasi() !== null;
    }

    public function bolehGantiTemaOleh(?Pengguna $pengguna): bool
    {
        if ($pengguna !== null && $pengguna->adalahAdmin()) {
            return true;
        }

        return ! $this->temaTerkunciUntukClient();
    }

    public function alasanTemaTerkunci(): ?string
    {
        if ($this->sudahAktifPublik()) {
            return 'Tema undangan yang sudah aktif dikunci otomatis. Hubungi Admin jika ingin mengganti atau upgrade tema.';
        }

        if ($this->transaksiMenungguVerifikasi() !== null) {
            return 'Tema sedang dikunci sementara karena bukti pembayaran Anda sedang menunggu verifikasi Admin.';
        }

        return null;
    }

    public function bolehDihapusClient(): bool
    {
        return ! $this->status_publikasi
            && ! $this->sudahKedaluwarsa()
            && ! $this->memilikiTransaksiTerkunci();
    }

    public function acaraTerdekat(): ?AcaraUndangan
    {
        $daftar = $this->relationLoaded('daftarAcara')
            ? $this->daftarAcara
            : $this->daftarAcara()->get();

        if ($daftar->isEmpty()) {
            return null;
        }

        $hariIni = now()->startOfDay();

        return $daftar->first(
            static fn (AcaraUndangan $acara): bool => $acara->tanggal_acara !== null
                && $acara->tanggal_acara->copy()->startOfDay()->greaterThanOrEqualTo($hariIni)
        ) ?? $daftar->first();
    }

    /**
     * Ringkasan progres kelengkapan isi undangan (4 tahap utama).
     *
     * @return array{
     *     terpenuhi: int,
     *     total: int,
     *     persen: int,
     *     butir: list<array{kode: string, label: string, selesai: bool, tab: string}>
     * }
     */
    public function ringkasanKelengkapan(): array
    {
        $acaraAda = $this->relationLoaded('daftarAcara')
            ? $this->daftarAcara->isNotEmpty()
            : $this->daftarAcara()->exists();

        $galeriAda = $this->modeTanpaFoto()
            || ($this->relationLoaded('daftarGaleri')
                ? $this->daftarGaleri->isNotEmpty()
                : $this->daftarGaleri()->exists());

        $amplopAda = ($this->relationLoaded('daftarAmplop')
            ? $this->daftarAmplop->isNotEmpty()
            : $this->daftarAmplop()->exists())
            || trim((string) data_get($this->pengaturan, 'alamat_kado_fisik', '')) !== '';

        $mempelaiAda = trim((string) $this->nama_lengkap_pria) !== ''
            && trim((string) $this->nama_lengkap_wanita) !== '';

        $butir = [
            ['kode' => 'mempelai', 'label' => 'Mempelai', 'selesai' => $mempelaiAda, 'tab' => 'mempelai'],
            ['kode' => 'acara', 'label' => 'Acara', 'selesai' => $acaraAda, 'tab' => 'acara'],
            ['kode' => 'galeri', 'label' => $this->modeTanpaFoto() ? 'Mode TF' : 'Galeri', 'selesai' => $galeriAda, 'tab' => 'galeri'],
            ['kode' => 'amplop', 'label' => 'Amplop', 'selesai' => $amplopAda, 'tab' => 'amplop'],
        ];

        $terpenuhi = collect($butir)->where('selesai', true)->count();
        $total = count($butir);

        return [
            'terpenuhi' => $terpenuhi,
            'total' => $total,
            'persen' => (int) round(($terpenuhi / $total) * 100),
            'butir' => $butir,
        ];
    }

    public function bolehDipratinjauOleh(?Pengguna $pengguna): bool
    {
        if (! $pengguna) {
            return false;
        }

        return $pengguna->adalahAdmin() || $pengguna->id === $this->pengguna_id;
    }

    public function fiturAktif(string $fitur): bool
    {
        $fiturAktif = $this->pengaturan['fitur_aktif'] ?? [];

        return (bool) ($fiturAktif[$fitur] ?? true);
    }

    public function modeTanpaFoto(): bool
    {
        return (bool) ($this->pengaturan['tanpa_foto'] ?? false);
    }

    public function kodeGayaFontTerpilih(): string
    {
        $kode = (string) ($this->pengaturan['gaya_font'] ?? 'bawaan');

        if (! array_key_exists($kode, self::GAYA_FONT_TERSEDIA)) {
            return 'bawaan';
        }

        return $kode;
    }

    /**
     * Resolusi kombinasi tipografi aktif untuk halaman undangan (preset khusus atau bawaan tema).
     *
     * @return array{
     *     kode: string,
     *     label: string,
     *     judul_css: string,
     *     isi_css: string,
     *     aksen_css: string,
     *     google_fonts_url: string
     * }
     */
    public function resolusiGayaFont(?string $kodeOverride = null): array
    {
        $kodeDipilih = $kodeOverride ?: $this->kodeGayaFontTerpilih();

        if ($kodeDipilih === 'bawaan' || ! array_key_exists($kodeDipilih, self::GAYA_FONT_TERSEDIA)) {
            $slugTema = $this->tema?->slug ?? 'rustic-floral';
            $kodeEfektif = self::FONT_BAWAAN_TEMA[$slugTema] ?? 'kaligrafi_vibes';
        } else {
            $kodeEfektif = $kodeDipilih;
        }

        $preset = self::GAYA_FONT_TERSEDIA[$kodeEfektif] ?? self::GAYA_FONT_TERSEDIA['kaligrafi_vibes'];
        $queryKeluarga = collect($preset['google_families'])
            ->unique()
            ->map(static fn (string $family): string => 'family='.$family)
            ->implode('&');

        return [
            'kode' => $kodeEfektif,
            'label' => $preset['label'],
            'judul_css' => $preset['judul_css'],
            'isi_css' => $preset['isi_css'],
            'aksen_css' => $preset['aksen_css'],
            'google_fonts_url' => 'https://fonts.googleapis.com/css2?'.$queryKeluarga.'&display=swap',
        ];
    }

    public function inisialPria(): string
    {
        $nama = trim((string) $this->nama_panggilan_pria);

        return $nama !== '' ? Str::upper(Str::substr($nama, 0, 1)) : 'P';
    }

    public function inisialWanita(): string
    {
        $nama = trim((string) $this->nama_panggilan_wanita);

        return $nama !== '' ? Str::upper(Str::substr($nama, 0, 1)) : 'W';
    }

    public function inisialMempelai(): string
    {
        return $this->inisialPria().' & '.$this->inisialWanita();
    }

    public function urlFotoPria(): ?string
    {
        return $this->resolveUrlMedia($this->foto_pria);
    }

    public function urlFotoWanita(): ?string
    {
        return $this->resolveUrlMedia($this->foto_wanita);
    }

    public function urlFotoSampul(): ?string
    {
        if ($this->modeTanpaFoto()) {
            return null;
        }

        $fotoSampul = data_get($this->pengaturan, 'foto_sampul');
        if (is_string($fotoSampul) && $fotoSampul !== '') {
            return $this->resolveUrlMedia($fotoSampul);
        }

        $galeriPertama = $this->daftarGaleri->first();
        if ($galeriPertama) {
            return $galeriPertama->urlFoto();
        }

        return $this->urlFotoPria() ?? $this->urlFotoWanita();
    }

    public function urlFotoSampulKhususDashboard(): ?string
    {
        $fotoSampul = data_get($this->pengaturan, 'foto_sampul');

        return (is_string($fotoSampul) && $fotoSampul !== '')
            ? $this->resolveUrlMedia($fotoSampul)
            : null;
    }

    public function urlFotoPembuka(): ?string
    {
        if ($this->modeTanpaFoto()) {
            return null;
        }

        $fotoPembuka = data_get($this->pengaturan, 'foto_pembuka');
        if (is_string($fotoPembuka) && $fotoPembuka !== '') {
            return $this->resolveUrlMedia($fotoPembuka);
        }

        return $this->urlFotoSampul();
    }

    public function urlFotoPembukaKhususDashboard(): ?string
    {
        $fotoPembuka = data_get($this->pengaturan, 'foto_pembuka');

        return (is_string($fotoPembuka) && $fotoPembuka !== '')
            ? $this->resolveUrlMedia($fotoPembuka)
            : null;
    }

    public function urlFotoPenutup(): ?string
    {
        if ($this->modeTanpaFoto()) {
            return null;
        }

        $fotoPenutup = data_get($this->pengaturan, 'foto_penutup');
        if (is_string($fotoPenutup) && $fotoPenutup !== '') {
            return $this->resolveUrlMedia($fotoPenutup);
        }

        return $this->urlFotoSampul();
    }

    public function urlFotoPenutupKhususDashboard(): ?string
    {
        $fotoPenutup = data_get($this->pengaturan, 'foto_penutup');

        return (is_string($fotoPenutup) && $fotoPenutup !== '')
            ? $this->resolveUrlMedia($fotoPenutup)
            : null;
    }

    public function urlFotoLatarCustom(): ?string
    {
        if ($this->modeTanpaFoto()) {
            return null;
        }

        $fotoLatar = data_get($this->pengaturan, 'foto_latar_tema');

        return (is_string($fotoLatar) && $fotoLatar !== '')
            ? $this->resolveUrlMedia($fotoLatar)
            : null;
    }

    public function urlFotoLatarCustomKhususDashboard(): ?string
    {
        $fotoLatar = data_get($this->pengaturan, 'foto_latar_tema');

        return (is_string($fotoLatar) && $fotoLatar !== '')
            ? $this->resolveUrlMedia($fotoLatar)
            : null;
    }

    public function hashtagPasangan(): string
    {
        $custom = trim((string) data_get($this->pengaturan, 'hashtag', ''));
        if ($custom !== '') {
            $tanpaPagar = ltrim($custom, '# ');
            if ($tanpaPagar !== '') {
                return '#'.$tanpaPagar;
            }
        }

        return '#'.Str::studly($this->nama_panggilan_pria.$this->nama_panggilan_wanita).'Together';
    }

    public static function bersihkanUsernameInstagram(?string $nilai): string
    {
        $teks = trim((string) $nilai);
        if ($teks === '') {
            return '';
        }

        $teks = preg_replace('#^https?://(www\.)?instagram\.com/#i', '', $teks) ?? $teks;
        $teks = trim(explode('?', $teks)[0], " \t\n\r\0\x0B/@");

        return preg_replace('/[^A-Za-z0-9._]/', '', $teks) ?? '';
    }

    public function instagramPria(): string
    {
        return self::bersihkanUsernameInstagram((string) data_get($this->pengaturan, 'sosial_media.instagram_pria', ''));
    }

    public function instagramWanita(): string
    {
        return self::bersihkanUsernameInstagram((string) data_get($this->pengaturan, 'sosial_media.instagram_wanita', ''));
    }

    public function dressCodeCatatan(): string
    {
        return trim((string) data_get($this->pengaturan, 'dress_code.catatan', ''));
    }

    /**
     * @return list<string>
     */
    public function dressCodeWarna(): array
    {
        $mentah = (array) data_get($this->pengaturan, 'dress_code.warna', []);
        $bersih = [];

        foreach ($mentah as $hex) {
            $kode = strtoupper(trim((string) $hex));
            if (preg_match('/^#[0-9A-F]{6}$/', $kode) === 1 && ! in_array($kode, $bersih, true)) {
                $bersih[] = $kode;
            }
            if (count($bersih) >= 5) {
                break;
            }
        }

        return $bersih;
    }

    /**
     * @return list<string>
     */
    public function turutMengundangWanita(): array
    {
        return $this->pecahBarisTeks((string) data_get($this->pengaturan, 'turut_mengundang.pihak_wanita', ''));
    }

    /**
     * @return list<string>
     */
    public function turutMengundangPria(): array
    {
        return $this->pecahBarisTeks((string) data_get($this->pengaturan, 'turut_mengundang.pihak_pria', ''));
    }

    /**
     * @return list<string>
     */
    private function pecahBarisTeks(string $teks): array
    {
        $hasil = [];
        foreach (preg_split('/\r\n|\r|\n/', $teks) ?: [] as $baris) {
            $bersih = trim($baris);
            if ($bersih !== '') {
                $hasil[] = $bersih;
            }
        }

        return $hasil;
    }

    private function resolveUrlMedia(?string $path): ?string
    {
        return MediaPublik::url($path);
    }
}
