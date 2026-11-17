@extends('layouts.aplikasi')

@section('judul', 'SesiTemu | Undangan Digital Modern')

@section('konten')
    @php
        $durasiTampil = $durasiAktifBulan ?? \App\Support\PengaturanSesiTemu::masaAktifBulan();
        $daftarFilterJson = $daftarTema
            ->map(
                fn($t) => [
                    'tier' => $t->tierKode(),
                    'nama' => $t->nama_tema.' '.$t->kategoriLabel(),
                ],
            )
            ->values();

        $fallbackHeroSlides = [
            [
                'slug' =>
                    $daftarTema->firstWhere('slug', 'rustic-floral')?->slug ??
                    ($daftarTema->first()?->slug ?? 'rustic-floral'),
                'label' => 'Floral Pastel',
                'nama_tema' => $daftarTema->firstWhere('slug', 'rustic-floral')?->nama_tema ?? 'Rustic Floral',
                'pasangan' => 'Dimas & Rani',
                'domain' => 'sesitemu.id/dimas-rani',
                'tanggal' => 'Sabtu, 24 Oktober 2026',
                'gambar' => asset('aset-demo/sampul-rustic.webp'),
                'gelap' => false,
            ],
            [
                'slug' =>
                    $daftarTema->firstWhere('slug', 'luxury-noir')?->slug ??
                    ($daftarTema->skip(1)->first()?->slug ?? ($daftarTema->first()?->slug ?? 'luxury-noir')),
                'label' => 'Luxury Noir',
                'nama_tema' => $daftarTema->firstWhere('slug', 'luxury-noir')?->nama_tema ?? 'Luxury Noir Monogram',
                'pasangan' => 'Arga & Nadira',
                'domain' => 'sesitemu.id/arga-nadira',
                'tanggal' => 'Minggu, 08 November 2026',
                'gambar' => asset('aset-demo/sampul-luxury.webp'),
                'gelap' => true,
            ],
            [
                'slug' =>
                    $daftarTema->firstWhere('slug', 'adat-jawa')?->slug ??
                    ($daftarTema->skip(2)->first()?->slug ?? ($daftarTema->first()?->slug ?? 'adat-jawa')),
                'label' => 'Adat Keraton',
                'nama_tema' => $daftarTema->firstWhere('slug', 'adat-jawa')?->nama_tema ?? 'Adat Jawa Keraton',
                'pasangan' => 'Bagas & Laras',
                'domain' => 'sesitemu.id/bagas-laras',
                'tanggal' => 'Sabtu, 19 Desember 2026',
                'gambar' => asset('aset-demo/sampul-jawa.webp'),
                'gelap' => false,
            ],
        ];
    @endphp

    <div x-data="{
        seksiAktif: 'beranda',
        tierAktif: 'semua',
        kataCariTema: '',
        previewTerbukaId: null,
        sampulLightboxSlug: null,
        daftarFilter: @js($daftarFilterJson),
        heroTemaIndex: 0,
        heroSlides: @js($fallbackHeroSlides),
        semuaFiturMobile: false,
        faqAktif: 0,
        modalDemoTerbuka: false,
        temaDemoSlug: '',
        temaDemoNama: '',
        temaDemoInfo: '',
        namaTamuDemo: 'Budi Santoso & Partner',
        tanpaFotoDemo: false,
        fontDemo: 'bawaan',
        get heroSlideAktif() {
            return this.heroSlides[this.heroTemaIndex] ?? this.heroSlides[0];
        },
        get heroSlideKiriIdx() {
            return (this.heroTemaIndex + 1) % this.heroSlides.length;
        },
        get heroSlideKiri() {
            return this.heroSlides[this.heroSlideKiriIdx] ?? this.heroSlides[1];
        },
        get heroSlideKananIdx() {
            return (this.heroTemaIndex + 2) % this.heroSlides.length;
        },
        get heroSlideKanan() {
            return this.heroSlides[this.heroSlideKananIdx] ?? this.heroSlides[2];
        },
        temaCocok(tier, nama = '') {
            const cocokTier = this.tierAktif === 'semua' || this.tierAktif === tier;
            const kata = this.kataCariTema.trim().toLowerCase();
            const cocokCari = !kata || nama.toLowerCase().includes(kata);
            return cocokTier && cocokCari;
        },
        get adaHasilFilter() {
            return this.daftarFilter.some(item => this.temaCocok(item.tier, item.nama));
        },
        resetFilter() {
            this.tierAktif = 'semua';
            this.kataCariTema = '';
        },
        bukaModalDemo(slug, nama, info = '') {
            this.temaDemoSlug = slug;
            this.temaDemoNama = nama;
            this.temaDemoInfo = info;
            this.tanpaFotoDemo = false;
            this.fontDemo = 'bawaan';
            this.modalDemoTerbuka = true;
        },
        bukaUrlDemo() {
            const params = new URLSearchParams({
                to: this.namaTamuDemo.trim() || 'Budi Santoso & Partner',
                tf: this.tanpaFotoDemo ? '1' : '0',
                font: this.fontDemo || 'bawaan',
            });
            window.open('/demo/' + this.temaDemoSlug + '?' + params.toString(), '_blank');
            this.modalDemoTerbuka = false;
        },
        bukaLightboxSampul(slug) {
            this.previewTerbukaId = null;
            this.sampulLightboxSlug = slug;
        },
        tutupLightboxSampul() {
            this.sampulLightboxSlug = null;
        }
    }">
        {{-- Header / Navbar Atas (Simpel di Mobile, Lengkap di Desktop) --}}
        <header class="sticky top-0 z-40 bg-ivory/95 backdrop-blur-md border-b border-champagne/20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-14 md:h-16 flex items-center justify-between gap-3">
                <a href="{{ route('beranda') }}" class="flex items-center gap-2 sm:gap-2.5 group shrink-0">
                    <img src="{{ asset('aset-demo/logo-sesi-temu-ikon.webp') }}" alt="Logo SesiTemu"
                        class="h-8 w-8 sm:h-10 sm:w-10 object-contain transition-transform duration-200 group-hover:scale-105">
                    <span class="font-logo text-2xl sm:text-3xl font-bold tracking-tight text-[#1D3B2C] leading-none">
                        Sesi<span class="text-champagne">Temu</span>
                    </span>
                </a>

                <nav class="hidden md:flex items-center gap-6 lg:gap-7 text-sm font-medium text-charcoal/80">
                    <a href="#beranda" @click="seksiAktif = 'beranda'"
                        :class="seksiAktif === 'beranda' ? 'text-sage font-semibold' : ''"
                        class="hover:text-sage transition">Beranda</a>
                    <a href="#keunggulan" @click="seksiAktif = 'fitur'"
                        :class="seksiAktif === 'fitur' ? 'text-sage font-semibold' : ''"
                        class="hover:text-sage transition">Fitur</a>
                    <a href="#katalog-tema" @click="seksiAktif = 'tema'"
                        :class="seksiAktif === 'tema' ? 'text-sage font-semibold' : ''"
                        class="hover:text-sage transition">Katalog Tema</a>
                    <a href="#paket-harga" @click="seksiAktif = 'harga'"
                        :class="seksiAktif === 'harga' ? 'text-sage font-semibold' : ''"
                        class="hover:text-sage transition">Paket Harga</a>
                    <a href="#faq" @click="seksiAktif = 'faq'"
                        :class="seksiAktif === 'faq' ? 'text-sage font-semibold' : ''"
                        class="hover:text-sage transition">FAQ</a>
                </nav>

                <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                    @auth
                        <a href="{{ auth()->user()->adalahAdmin() ? '/admin' : '/dasbor' }}"
                            class="rounded-xl bg-sage px-3.5 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-white hover:bg-sage/90 transition">
                            {{ auth()->user()->adalahAdmin() ? 'Panel Admin' : 'Dasbor Saya' }}
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center gap-1.5 rounded-xl border-[1.5px] border-sage bg-white/85 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-sage hover:bg-sage/10 hover:-translate-y-0.5 transition shadow-2xs">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                                <polyline points="10 17 15 12 10 7" />
                                <line x1="15" x2="3" y1="12" y2="12" />
                            </svg>
                            <span>Masuk</span>
                        </a>
                        <a href="{{ route('daftar') }}"
                            class="hidden md:inline-flex rounded-xl bg-sage px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sage/90 hover:-translate-y-0.5 transition">
                            Buat Undangan
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        {{-- Hero Section: Responsif Hybrid (Mockup HP di Atas pada Mobile, Sejajar Bersih di Desktop) --}}
        <section id="beranda"
            class="relative overflow-hidden bg-gradient-to-b from-ivory via-[#FAF5EC] to-white pt-5 pb-10 sm:pt-9 sm:pb-12 lg:py-12 px-4 sm:px-6 lg:px-8">
            <div aria-hidden="true"
                class="pointer-events-none absolute right-0 lg:right-16 top-8 w-[26rem] sm:w-[34rem] h-[24rem] rounded-full bg-champagne/18 blur-3xl">
            </div>

            <div
                class="relative z-10 max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-7 sm:gap-9 lg:gap-10 items-center">
                {{-- Kolom Copy Hero (Kiri di Desktop agar Terbaca Seketika, Bawah Mockup di Mobile) --}}
                <div class="order-2 lg:order-1 lg:col-span-6 text-center lg:text-left">
                    <div
                        class="inline-flex items-center gap-2 rounded-full bg-white/95 border border-champagne/35 px-3.5 sm:px-4 py-1.5 text-[10px] sm:text-xs font-semibold uppercase tracking-[0.16em] sm:tracking-[0.18em] text-[#8A6D33] shadow-2xs">
                        <span class="h-1.5 w-1.5 rounded-full bg-sage"></span>
                        <span>Website Undangan Pernikahan Digital</span>
                    </div>

                    <h1
                        class="mt-3.5 sm:mt-4 font-logo text-[1.85rem] sm:text-4xl lg:text-[2.85rem] xl:text-[3.2rem] font-bold text-charcoal leading-[1.15] tracking-tight">
                        Bagikan Kabar Pernikahan
                        <span class="text-sage">Dengan Lebih Berkesan</span>
                    </h1>

                    <p
                        class="mt-3 sm:mt-4 text-[13px] sm:text-base text-charcoal/75 max-w-lg mx-auto lg:mx-0 leading-relaxed">
                        Rancang <strong>website undangan pernikahan</strong> berkelas dalam hitungan menit — lengkap dengan
                        galeri ringan, musik romantis, RSVP tamu, amplop digital, dan link personal WhatsApp.
                    </p>

                    <div
                        class="mt-5 sm:mt-6 grid grid-cols-2 sm:flex sm:items-center justify-center lg:justify-start gap-2.5 sm:gap-3.5">
                        <a href="{{ auth()->check() ? route('dasbor.katalog') : route('daftar') }}"
                            class="inline-flex items-center justify-center gap-1.5 sm:gap-2 rounded-2xl bg-sage px-3 sm:px-6 py-3 sm:py-3.5 text-[11px] sm:text-sm font-bold text-white shadow-lg shadow-sage/20 hover:bg-[#3b5047] hover:-translate-y-0.5 transition whitespace-nowrap">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-champagne shrink-0" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" aria-hidden="true">
                                <path
                                    d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z" />
                                <path d="M5 3v4" />
                                <path d="M3 5h4" />
                            </svg>
                            <span>{{ auth()->check() ? 'Buat Undangan Baru' : 'Coba Gratis' }}</span>
                        </a>

                        <a href="#katalog-tema"
                            class="inline-flex items-center justify-center gap-1.5 sm:gap-2 rounded-2xl bg-white px-3 sm:px-6 py-3 sm:py-3.5 text-[11px] sm:text-sm font-semibold text-charcoal ring-1 ring-champagne/45 hover:bg-champagne/10 hover:-translate-y-0.5 transition shadow-xs whitespace-nowrap">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-sage shrink-0" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <rect width="7" height="7" x="3" y="3" rx="1.5" />
                                <rect width="7" height="7" x="14" y="3" rx="1.5" />
                                <rect width="7" height="7" x="14" y="14" rx="1.5" />
                                <rect width="7" height="7" x="3" y="14" rx="1.5" />
                            </svg>
                            <span>Lihat Katalog Tema</span>
                        </a>
                    </div>
                </div>

                {{-- Kolom Stage Mockup HP Undangan Digital (Paling Atas di Mobile, Kanan di Desktop) --}}
                <div class="order-1 lg:order-2 lg:col-span-6 text-center">
                    <div
                        class="inline-flex items-center justify-center gap-1 rounded-full bg-white/95 p-1 ring-1 ring-champagne/30 shadow-xs mb-4 sm:mb-5">
                        <template x-for="(slide, idx) in heroSlides" :key="idx">
                            <button type="button" @click="heroTemaIndex = idx"
                                :class="heroTemaIndex === idx ?
                                    'bg-charcoal text-champagne shadow-xs' :
                                    'text-charcoal/70 hover:text-charcoal'"
                                class="rounded-full px-3 sm:px-3.5 py-1.5 text-[11px] font-semibold transition cursor-pointer"
                                x-text="slide.label"></button>
                        </template>
                    </div>

                    <div class="relative mx-auto max-w-[245px] sm:max-w-[285px] xl:max-w-[305px]">
                        {{-- Pratinjau Samping Kiri --}}
                        <button type="button" @click="heroTemaIndex = heroSlideKiriIdx"
                            :aria-label="'Pilih pratinjau ' + heroSlideKiri.label"
                            :class="heroSlideKiri.gelap ? 'bg-charcoal text-ivory' : 'bg-ivory text-charcoal'"
                            class="flex flex-col justify-between p-3 sm:p-4 text-left absolute -left-14 sm:-left-24 xl:-left-28 top-8 sm:top-11 w-28 sm:w-40 h-48 sm:h-60 -rotate-6 rounded-[1.5rem] sm:rounded-3xl overflow-hidden shadow-lg ring-1 ring-champagne/40 opacity-85 hover:opacity-100 hover:-translate-y-1 transition duration-300 cursor-pointer">
                            <img :src="heroSlideKiri.gambar" :alt="heroSlideKiri.nama_tema"
                                class="absolute inset-0 w-full h-full object-cover"
                                :class="heroSlideKiri.gelap ? 'opacity-65' : 'opacity-90'">
                            <div class="absolute inset-0"
                                :class="heroSlideKiri.gelap ?
                                    'bg-gradient-to-b from-black/20 via-transparent to-black/80' :
                                    'bg-gradient-to-b from-white/30 via-transparent to-ivory/95'">
                            </div>
                            <div class="relative z-10 mt-auto">
                                <p class="text-[8px] sm:text-[9px] font-semibold uppercase tracking-widest"
                                    :class="heroSlideKiri.gelap ? 'text-champagne/90' : 'text-[#8A6D33]'"
                                    x-text="heroSlideKiri.label"></p>
                                <p class="font-logo text-xs sm:text-sm font-bold"
                                    :class="heroSlideKiri.gelap ? 'text-white' : 'text-charcoal'"
                                    x-text="heroSlideKiri.pasangan"></p>
                            </div>
                        </button>

                        {{-- Pratinjau Samping Kanan --}}
                        <button type="button" @click="heroTemaIndex = heroSlideKananIdx"
                            :aria-label="'Pilih pratinjau ' + heroSlideKanan.label"
                            :class="heroSlideKanan.gelap ? 'bg-charcoal text-ivory' : 'bg-ivory text-charcoal'"
                            class="flex flex-col justify-between p-3 sm:p-4 text-right absolute -right-14 sm:-right-24 xl:-right-28 top-8 sm:top-11 w-28 sm:w-40 h-48 sm:h-60 rotate-6 rounded-[1.5rem] sm:rounded-3xl overflow-hidden shadow-lg ring-1 ring-champagne/40 opacity-85 hover:opacity-100 hover:-translate-y-1 transition duration-300 cursor-pointer">
                            <img :src="heroSlideKanan.gambar" :alt="heroSlideKanan.nama_tema"
                                class="absolute inset-0 w-full h-full object-cover"
                                :class="heroSlideKanan.gelap ? 'opacity-65' : 'opacity-90'">
                            <div class="absolute inset-0"
                                :class="heroSlideKanan.gelap ?
                                    'bg-gradient-to-b from-black/20 via-transparent to-black/80' :
                                    'bg-gradient-to-b from-white/30 via-transparent to-ivory/95'">
                            </div>
                            <div class="relative z-10 mt-auto">
                                <p class="text-[8px] sm:text-[9px] font-semibold uppercase tracking-widest"
                                    :class="heroSlideKanan.gelap ? 'text-champagne/90' : 'text-[#8A6D33]'"
                                    x-text="heroSlideKanan.label"></p>
                                <p class="font-logo text-xs sm:text-sm font-bold"
                                    :class="heroSlideKanan.gelap ? 'text-white' : 'text-charcoal'"
                                    x-text="heroSlideKanan.pasangan"></p>
                            </div>
                        </button>

                        {{-- Bingkai Ponsel Utama Interaktif --}}
                        <div
                            class="relative z-10 rounded-[2.2rem] sm:rounded-[2.5rem] bg-charcoal p-2 sm:p-2.5 shadow-[0_24px_60px_-15px_rgba(31,41,55,0.24)] ring-1 ring-champagne/45">
                            <div
                                class="rounded-[1.8rem] sm:rounded-[2.05rem] overflow-hidden bg-ivory relative flex flex-col">
                                <div
                                    class="bg-charcoal px-3.5 sm:px-4 pt-2 sm:pt-2.5 pb-1.5 sm:pb-2 flex items-center justify-between gap-2 text-[9px] sm:text-[10px] text-ivory/90">
                                    <span class="inline-flex items-center gap-1.5 font-mono truncate">
                                        <svg class="w-3 h-3 text-emerald-400 shrink-0" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                            stroke-linejoin="round" aria-hidden="true">
                                            <rect width="18" height="11" x="3" y="11" rx="2"
                                                ry="2" />
                                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                        </svg>
                                        <span x-text="heroSlideAktif.domain"></span>
                                    </span>
                                    <span
                                        class="rounded-full bg-champagne/20 px-2 py-0.5 text-[8px] sm:text-[9px] font-bold uppercase tracking-wider text-champagne shrink-0">
                                        Live Web
                                    </span>
                                </div>

                                <div class="relative h-[300px] sm:h-[365px] xl:h-[385px] flex flex-col justify-between p-4 sm:p-5 text-center transition-colors duration-300"
                                    :class="heroSlideAktif.gelap ? 'bg-[#111827] text-ivory' : 'bg-[#FDFBF7] text-charcoal'">
                                    <img :src="heroSlideAktif.gambar" :alt="heroSlideAktif.nama_tema"
                                        class="absolute inset-0 w-full h-full object-cover object-[center_26%] transition-all duration-500"
                                        :class="heroSlideAktif.gelap ? 'opacity-65' : 'opacity-98'">
                                    <div class="absolute inset-0"
                                        :class="heroSlideAktif.gelap ?
                                            'bg-gradient-to-b from-[#0f172a]/65 via-transparent to-[#0f172a]/90' :
                                            'bg-gradient-to-b from-white/65 via-transparent to-ivory/90'">
                                    </div>

                                    <div class="relative z-10 pt-1 space-y-0.5">
                                        <p
                                            class="text-[8px] sm:text-[10px] font-bold uppercase tracking-[0.24em] opacity-80">
                                            The
                                            Wedding Of</p>
                                        <h2 class="font-logo text-xl sm:text-3xl font-bold tracking-tight"
                                            x-text="heroSlideAktif.pasangan"></h2>
                                        <p class="text-[10px] sm:text-xs font-medium opacity-80"
                                            x-text="heroSlideAktif.tanggal"></p>
                                    </div>

                                    <div class="relative z-10 space-y-2 pb-0.5">
                                        <div class="rounded-xl sm:rounded-2xl px-3 py-2 sm:px-4 sm:py-2.5 backdrop-blur-md border text-center"
                                            :class="heroSlideAktif.gelap ?
                                                'bg-white/10 border-champagne/35 text-ivory' :
                                                'bg-white/92 border-champagne/40 text-charcoal shadow-sm'">
                                            <p class="text-[8px] sm:text-[10px] opacity-75">Kepada Yth. Bapak/Ibu/Saudara/i
                                            </p>
                                            <p class="text-xs sm:text-sm font-bold mt-0.5">Budi Santoso &amp; Partner</p>

                                            <div class="mt-1.5 sm:mt-2 grid grid-cols-3 gap-1.5 text-center border-t pt-1.5"
                                                :class="heroSlideAktif.gelap ? 'border-white/15' : 'border-champagne/20'">
                                                <div>
                                                    <p class="text-[11px] sm:text-xs font-bold">14</p>
                                                    <p class="text-[8px] sm:text-[9px] opacity-65">Hari</p>
                                                </div>
                                                <div>
                                                    <p class="text-[11px] sm:text-xs font-bold">08</p>
                                                    <p class="text-[8px] sm:text-[9px] opacity-65">Jam</p>
                                                </div>
                                                <div>
                                                    <p class="text-[11px] sm:text-xs font-bold">25</p>
                                                    <p class="text-[8px] sm:text-[9px] opacity-65">Menit</p>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="button"
                                            @click="bukaModalDemo(heroSlideAktif.slug, heroSlideAktif.nama_tema, 'Live Preview')"
                                            class="w-full inline-flex items-center justify-center gap-1.5 rounded-xl px-3.5 py-2 sm:py-2.5 text-[11px] sm:text-xs font-bold shadow-md transition cursor-pointer"
                                            :class="heroSlideAktif.gelap ? 'bg-champagne text-charcoal hover:bg-champagne/90' :
                                                'bg-sage text-white hover:bg-sage/90'">
                                            <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2.1" stroke-linecap="round"
                                                stroke-linejoin="round" aria-hidden="true">
                                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>
                                            <span>Buka Contoh Undangan</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Keunggulan SesiTemu: Editorial Ticket Highlight + Grid Fitur Bersih Tanpa Border --}}
        <section id="keunggulan"
            class="pt-10 pb-16 sm:pt-14 sm:pb-20 bg-gradient-to-b from-white via-[#F9F5EB] to-[#F9F5EB] border-b border-champagne/20 px-4 sm:px-6 lg:px-8">
            <div class="max-w-5xl mx-auto">
                {{-- Header Seksi --}}
                <div class="text-center max-w-2xl mx-auto">
                    <h2 class="font-logo text-3xl sm:text-4xl lg:text-[2.6rem] font-bold text-charcoal tracking-tight">
                        Mengapa Memilih <span class="text-sage">SesiTemu?</span>
                    </h2>
                </div>

                {{-- Ticket Highlight Card Minimalis (Mobile & Desktop) --}}
                <div class="mt-7 sm:mt-10 max-w-2xl mx-auto">
                    <div
                        class="relative rounded-2xl bg-[#FDFBF7] border border-champagne/40 shadow-xs flex flex-col sm:grid sm:grid-cols-2 overflow-visible">
                        {{-- Efek Sobekan Tiket Atas & Bawah (Desktop) --}}
                        <span aria-hidden="true"
                            class="hidden sm:block absolute left-1/2 -translate-x-1/2 -top-2.5 h-5 w-5 rounded-full bg-[#FBF8F0] border-b border-champagne/40 z-10"></span>
                        <span aria-hidden="true"
                            class="hidden sm:block absolute left-1/2 -translate-x-1/2 -bottom-2.5 h-5 w-5 rounded-full bg-[#F9F5EB] border-t border-champagne/40 z-10"></span>

                        {{-- Sisi Kiri / Atas Tiket: Ringkasan Harga Mulai & Masa Aktif --}}
                        <div
                            class="p-5 sm:p-7 sm:border-r sm:border-dashed sm:border-champagne/45 flex flex-col justify-center text-center sm:text-left">
                            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-[#8A6D33]">
                                Mulai Dari • Aktif {{ $durasiTampil }} Bulan Penuh
                            </p>
                            <div class="mt-1.5 flex items-baseline justify-center sm:justify-start gap-2">
                                <span
                                    class="font-logo text-3xl sm:text-4xl font-bold text-charcoal">{{ \App\Models\Tema::formatRupiah($hargaTermurah) }}</span>
                                <span class="text-xs text-charcoal/55">/ {{ $durasiTampil }} bln</span>
                            </div>
                            <span
                                class="mt-2 inline-block self-center sm:self-start rounded-md bg-sage/10 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-sage">
                                Edit &amp; Pratinjau Gratis
                            </span>
                            <p class="mt-2.5 text-xs text-charcoal/65 leading-relaxed">
                                Sekali bayar saat undangan siap disebar, aktif
                                {{ $durasiTampil == 12 ? '1 tahun (12 bulan)' : $durasiTampil . ' bulan' }} penuh.
                            </p>
                        </div>

                        {{-- Garis Putus & Sobekan Tiket Kiri-Kanan Khusus Mobile --}}
                        <div class="sm:hidden relative px-4">
                            <div class="border-t border-dashed border-champagne/45"></div>
                            <span aria-hidden="true"
                                class="absolute -left-2.5 -top-2.5 h-5 w-5 rounded-full bg-[#FAF6EC] border-r border-champagne/40"></span>
                            <span aria-hidden="true"
                                class="absolute -right-2.5 -top-2.5 h-5 w-5 rounded-full bg-[#FAF6EC] border-l border-champagne/40"></span>
                        </div>

                        {{-- Sisi Kanan / Bawah Tiket: Aksi Utama --}}
                        <div class="p-5 sm:p-7 flex flex-col items-center justify-center gap-2.5">
                            <div class="w-full grid grid-cols-2 gap-2.5 sm:flex sm:flex-col">
                                <a href="{{ auth()->check() ? route('dasbor.katalog') : route('daftar') }}"
                                    class="w-full inline-flex items-center justify-center gap-1.5 sm:gap-2 rounded-xl bg-sage px-3 sm:px-5 py-2.5 sm:py-3 text-xs sm:text-sm font-bold text-white shadow-xs hover:bg-[#3b5047] transition whitespace-nowrap">
                                    <span>{{ auth()->check() ? 'Buat Baru' : 'Coba Gratis' }}</span>
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" aria-hidden="true">
                                        <path d="M5 12h14" />
                                        <path d="m12 5 7 7-7 7" />
                                    </svg>
                                </a>

                                <a href="{{ $urlWaKonsultasi ?? \App\Support\PengaturanSesiTemu::urlWaAdmin('Halo SesiTemu, saya ingin konsultasi mengenai undangan pernikahan digital.') }}"
                                    target="_blank" rel="noopener"
                                    class="w-full inline-flex items-center justify-center gap-1.5 sm:gap-2 rounded-xl bg-white border border-champagne/40 px-3 sm:px-5 py-2.5 text-xs sm:text-sm font-semibold text-charcoal hover:bg-champagne/10 transition whitespace-nowrap">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-sage shrink-0" viewBox="0 0 24 24"
                                        fill="currentColor" aria-hidden="true">
                                        <path
                                            d="M12.031 2c-5.516 0-9.969 4.453-9.969 9.969 0 1.766.469 3.484 1.344 5l-1.406 5.156 5.281-1.375c1.469.797 3.109 1.219 4.75 1.219 5.516 0 9.969-4.453 9.969-9.969S17.547 2 12.031 2Zm5.813 14.125c-.25.703-1.438 1.344-2 1.422-.516.078-1.172.109-1.891-.125-.438-.141-1-.328-1.719-.641-3.016-1.313-4.984-4.359-5.141-4.563-.156-.203-1.234-1.641-1.234-3.125s.781-2.219 1.063-2.516c.281-.297.609-.375.813-.375.203 0 .406 0 .578.016.188.016.438-.078.688.531.25.609.859 2.094.938 2.25.078.156.125.344.016.547-.109.203-.156.344-.313.516-.156.172-.328.391-.469.516-.156.156-.313.328-.141.641.172.313.781 1.297 1.672 2.094 1.156 1.031 2.125 1.344 2.438 1.5.313.156.484.125.672-.078.188-.203.781-.906.984-1.219.203-.313.406-.266.688-.156.281.109 1.797.844 2.109 1 .313.156.516.234.594.359.078.125.078.734-.172 1.438Z" />
                                    </svg>
                                    <span>Konsultasi</span>
                                </a>
                            </div>

                            <p class="text-[11px] text-charcoal/55">Edit &amp; pratinjau desain gratis dulu.</p>
                        </div>
                    </div>
                </div>

                {{-- Subjudul Grid Fitur --}}
                <div class="mt-10 sm:mt-14 text-center">
                    <h3 class="font-logo text-xl sm:text-2xl font-bold text-charcoal">
                        Semua Fitur Unggulan Sudah Termasuk
                    </h3>
                </div>

                @php
                    $durasiTeks = $durasiTampil == 12 ? '1 tahun (12 bulan)' : $durasiTampil . ' bulan';
                    $daftarKeunggulanGrid = [
                        [
                            'judul' => 'Unlimited tamu',
                            'deskripsi' => 'Buat & kirim link undangan personal sebanyak apa pun tanpa batas kuota.',
                            'ikon' => 'users',
                        ],
                        [
                            'judul' => "Aktif {$durasiTampil} bulan penuh",
                            'deskripsi' => "Sekali bayar, tautan tetap dapat diakses keluarga dan tamu hingga {$durasiTeks}.",
                            'ikon' => 'clock',
                        ],
                        [
                            'judul' => 'Kirim lewat WhatsApp',
                            'deskripsi' =>
                                'Hasilkan pesan pengantar sopan dan link pribadi tiap tamu sekali klik siap kirim WA.',
                            'ikon' => 'send',
                        ],
                        [
                            'judul' => 'RSVP & ucapan doa',
                            'deskripsi' =>
                                'Tamu konfirmasi kehadiran serta menulis doa, dan rekapnya langsung terhitung.',
                            'ikon' => 'heart',
                        ],
                        [
                            'judul' => 'Galeri foto auto WebP',
                            'deskripsi' =>
                                'Hingga 10 foto prewedding otomatis dikompresi ke WebP agar ringan di HP tamu.',
                            'ikon' => 'image',
                        ],
                        [
                            'judul' => 'Amplop digital & kado',
                            'deskripsi' =>
                                'Tampilkan nomor rekening, e-wallet, serta alamat kado dengan tombol salin cepat.',
                            'ikon' => 'gift',
                        ],
                        [
                            'judul' => 'Nama tamu di sampul',
                            'deskripsi' =>
                                'Setiap tamu melihat namanya tercetak sopan langsung di halaman pembuka undangan.',
                            'ikon' => 'user',
                        ],
                        [
                            'judul' => 'Revisi kapan saja',
                            'deskripsi' =>
                                'Perbarui isi, foto, atau jadwal sampai hari H. Tamu langsung lihat versi terbaru.',
                            'ikon' => 'edit',
                        ],
                        [
                            'judul' => 'Hitung mundur & peta',
                            'deskripsi' =>
                                'Penghitung waktu menuju hari H dilengkapi tombol penunjuk arah Google Maps.',
                            'ikon' => 'map',
                        ],
                        [
                            'judul' => 'Musik latar romantis',
                            'deskripsi' =>
                                'Pilih koleksi lagu pengiring bernuansa hangat untuk menyambut tamu yang membuka link.',
                            'ikon' => 'music',
                        ],
                        [
                            'judul' => '8 pilihan tipografi huruf',
                            'deskripsi' =>
                                'Ganti gaya font dari kaligrafi romantis hingga editorial modern sesuai karakter tema.',
                            'ikon' => 'type',
                        ],
                        [
                            'judul' => 'Kisah cinta mempelai',
                            'deskripsi' =>
                                'Susun linimasa cerita perjalanan cinta Anda berdua hingga momen menuju pelaminan.',
                            'ikon' => 'book',
                        ],
                        [
                            'judul' => 'Ganti tema kapan saja',
                            'deskripsi' =>
                                'Pindah ke desain setara atau upgrade tema lain tanpa perlu mengetik ulang isinya.',
                            'ikon' => 'layers',
                        ],
                        [
                            'judul' => 'Mode Tanpa Foto (Syar\'i)',
                            'deskripsi' =>
                                'Ubah potret mempelai menjadi inisial monogram elegan 1 klik untuk menjaga privasi.',
                            'ikon' => 'shield',
                        ],
                        [
                            'judul' => 'Atur bagian sesukamu',
                            'deskripsi' =>
                                'Aktifkan atau sembunyikan seksi galeri, cerita cinta, hitung mundur, dan buku tamu.',
                            'ikon' => 'sliders',
                        ],
                        [
                            'judul' => 'Tautan live streaming',
                            'deskripsi' =>
                                'Sertakan link siaran langsung acara untuk tamu jauh yang belum berkesempatan hadir.',
                            'ikon' => 'video',
                        ],
                        [
                            'judul' => 'Multi jadwal & lokasi',
                            'deskripsi' =>
                                'Tambahkan jadwal akad, pemberkatan, hingga resepsi beserta lokasi masing-masing.',
                            'ikon' => 'calendar',
                        ],
                        [
                            'judul' => 'Tersedia Terima Beres',
                            'deskripsi' =>
                                'Sibuk menjelang hari H? Cukup kirim data & foto, tim Admin yang isikan hingga siap.',
                            'ikon' => 'sparkles',
                        ],
                    ];
                @endphp

                {{-- Grid Kartu Fitur Unggulan (2 Kolom Expandable di Mobile, 3 Kolom di Desktop) --}}
                <div class="mt-6 sm:mt-10 grid grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 lg:gap-5">
                    @foreach ($daftarKeunggulanGrid as $item)
                        <div :class="(semuaFiturMobile || {{ $loop->index }} < 6) ? 'flex' : 'hidden sm:flex'"
                            class="flex-col sm:flex-row items-start gap-2.5 sm:gap-3.5 rounded-2xl bg-[#FDFBF7] p-3.5 sm:p-5 border border-champagne/35 shadow-2xs hover:bg-white hover:border-sage/45 hover:shadow-md hover:-translate-y-0.5 transition duration-200">
                            <span
                                class="sm:mt-0.5 inline-flex h-8 w-8 sm:h-9 sm:w-9 shrink-0 items-center justify-center rounded-full border border-champagne/45 bg-ivory text-sage shadow-2xs">
                                @switch($item['ikon'])
                                    @case('users')
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                            aria-hidden="true">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                            <circle cx="9" cy="7" r="4" />
                                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                        </svg>
                                    @break

                                    @case('clock')
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                            aria-hidden="true">
                                            <circle cx="12" cy="12" r="10" />
                                            <polyline points="12 6 12 12 16 14" />
                                        </svg>
                                    @break

                                    @case('edit')
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                            aria-hidden="true">
                                            <path d="M12 20h9" />
                                            <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z" />
                                        </svg>
                                    @break

                                    @case('heart')
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                            aria-hidden="true">
                                            <path
                                                d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                                        </svg>
                                    @break

                                    @case('user')
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                            aria-hidden="true">
                                            <circle cx="12" cy="8" r="4" />
                                            <path d="M20 21a8 8 0 0 0-16 0" />
                                        </svg>
                                    @break

                                    @case('gift')
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                            aria-hidden="true">
                                            <rect x="3" y="8" width="18" height="4" rx="1" />
                                            <path d="M12 8v13" />
                                            <path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7" />
                                            <path
                                                d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5" />
                                        </svg>
                                    @break

                                    @case('map')
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                            aria-hidden="true">
                                            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z" />
                                            <circle cx="12" cy="10" r="3" />
                                        </svg>
                                    @break

                                    @case('image')
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                            aria-hidden="true">
                                            <rect width="18" height="18" x="3" y="3" rx="2" ry="2" />
                                            <circle cx="9" cy="9" r="2" />
                                            <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                                        </svg>
                                    @break

                                    @case('music')
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                            aria-hidden="true">
                                            <path d="M9 18V5l12-2v13" />
                                            <circle cx="6" cy="18" r="3" />
                                            <circle cx="18" cy="16" r="3" />
                                        </svg>
                                    @break

                                    @case('type')
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                            aria-hidden="true">
                                            <polyline points="4 7 4 4 20 4 20 7" />
                                            <line x1="9" x2="15" y1="20" y2="20" />
                                            <line x1="12" x2="12" y1="4" y2="20" />
                                        </svg>
                                    @break

                                    @case('book')
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                            aria-hidden="true">
                                            <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20" />
                                        </svg>
                                    @break

                                    @case('layers')
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                            aria-hidden="true">
                                            <polygon points="12 2 2 7 12 12 22 7 12 2" />
                                            <polyline points="2 17 12 22 22 17" />
                                            <polyline points="2 12 12 17 22 12" />
                                        </svg>
                                    @break

                                    @case('shield')
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                            aria-hidden="true">
                                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10" />
                                            <path d="m9 12 2 2 4-4" />
                                        </svg>
                                    @break

                                    @case('sliders')
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                            aria-hidden="true">
                                            <line x1="21" x2="14" y1="4" y2="4" />
                                            <line x1="10" x2="3" y1="4" y2="4" />
                                            <line x1="21" x2="12" y1="12" y2="12" />
                                            <line x1="8" x2="3" y1="12" y2="12" />
                                            <line x1="21" x2="16" y1="20" y2="20" />
                                            <line x1="12" x2="3" y1="20" y2="20" />
                                        </svg>
                                    @break

                                    @case('video')
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                            aria-hidden="true">
                                            <path d="m22 8-6 4 6 4V8Z" />
                                            <rect width="14" height="12" x="2" y="6" rx="2" ry="2" />
                                        </svg>
                                    @break

                                    @case('calendar')
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                            aria-hidden="true">
                                            <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                                            <line x1="16" x2="16" y1="2" y2="6" />
                                            <line x1="8" x2="8" y1="2" y2="6" />
                                            <line x1="3" x2="21" y1="10" y2="10" />
                                        </svg>
                                    @break

                                    @case('send')
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                            aria-hidden="true">
                                            <path d="m22 2-7 20-4-9-9-4Z" />
                                            <path d="M22 2 11 13" />
                                        </svg>
                                    @break

                                    @default
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                            aria-hidden="true">
                                            <path
                                                d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z" />
                                        </svg>
                                @endswitch
                            </span>

                            <div class="min-w-0">
                                <h4 class="font-serif text-[13.5px] sm:text-base font-bold text-charcoal leading-snug">
                                    {{ $item['judul'] }}
                                </h4>
                                <p class="mt-0.5 text-[11.5px] sm:text-[13px] text-charcoal/70 leading-relaxed">
                                    {{ $item['deskripsi'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Tombol Tampilkan Semua Fitur Khusus Mobile --}}
                <div class="sm:hidden mt-6 text-center">
                    <button type="button" @click="semuaFiturMobile = !semuaFiturMobile"
                        class="inline-flex items-center justify-center gap-2 rounded-full bg-white border border-champagne/45 px-5 py-2.5 text-xs font-semibold text-charcoal shadow-2xs hover:bg-champagne/10 transition cursor-pointer">
                        <span x-text="semuaFiturMobile ? 'Tampilkan Lebih Ringkas' : 'Lihat 12 Fitur Lainnya'"></span>
                        <svg class="w-3.5 h-3.5 text-sage transition-transform duration-200"
                            :class="semuaFiturMobile ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
                            aria-hidden="true">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                    </button>
                </div>
            </div>
        </section>

        {{-- Katalog Tema dengan Pencarian, Filter Kategori, Tingkatan Tier & Popover Preview 2 Mode --}}
        <section id="katalog-tema" class="py-16 sm:py-20 bg-white px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-5">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-widest text-[#8A6D33]">Pilihan Desain
                            Eksklusif</span>
                        <h2 class="mt-1.5 font-logo text-3xl sm:text-4xl font-bold text-charcoal tracking-tight">
                            Katalog Tema Undangan
                        </h2>
                        <p class="mt-1.5 text-xs sm:text-sm text-charcoal/65">
                            Sentuh tombol <strong>Preview</strong> lalu pilih <strong>Pakai Foto</strong> atau
                            <strong>Tanpa Foto</strong> untuk melihat contoh undangan.
                        </p>
                    </div>

                    {{-- Pencarian Tema --}}
                    <div class="relative w-full sm:w-72 shrink-0">
                        <svg class="w-4 h-4 text-charcoal/45 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                        <input type="search" x-model="kataCariTema"
                            placeholder="Cari tema (Jawa, Rustic, Luxury...)" aria-label="Cari tema undangan"
                            class="w-full rounded-xl border border-champagne/40 bg-ivory/60 pl-9 pr-3.5 py-2.5 text-xs sm:text-sm text-charcoal placeholder:text-charcoal/45 focus:border-sage focus:bg-white focus:outline-none focus:ring-2 focus:ring-sage/15 transition">
                    </div>
                </div>

                {{-- Pilihan Tingkatan Kualitas (Tier) Tema --}}
                <div class="mt-7 grid grid-cols-2 lg:grid-cols-4 gap-3">
                    <button type="button" @click="tierAktif = 'semua'"
                        :class="tierAktif === 'semua' ? 'bg-sage/10 ring-2 ring-sage shadow-sm' :
                            'bg-ivory/60 ring-1 ring-champagne/25 hover:ring-champagne/60'"
                        class="rounded-2xl p-3.5 text-left transition cursor-pointer">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-xs sm:text-sm font-bold text-charcoal">Semua Tier</span>
                            <span
                                class="rounded-full bg-white px-2.5 py-0.5 text-[11px] font-semibold text-charcoal/70 ring-1 ring-charcoal/10">
                                {{ $daftarTema->count() }} Tema
                            </span>
                        </div>
                        <p class="mt-1 text-[11px] sm:text-xs text-charcoal/65">Tampilkan seluruh koleksi</p>
                    </button>

                    @foreach ([
            'basic' => ['ikon_warna' => 'bg-sage', 'deskripsi' => 'Elegan, clean & cepat dimuat', 'active' => 'bg-sage/10 ring-2 ring-sage shadow-sm'],
            'premium' => ['ikon_warna' => 'bg-champagne', 'deskripsi' => 'Detail artistik & ornamen adat', 'active' => 'bg-champagne/15 ring-2 ring-champagne shadow-sm'],
            'eksklusif' => ['ikon_warna' => 'bg-charcoal', 'deskripsi' => 'Efek motion & nuansa luxury', 'active' => 'bg-charcoal text-ivory ring-2 ring-champagne shadow-md'],
        ] as $kodeTier => $metaTier)
                        @php $dataTier = $ringkasanTier[$kodeTier]; @endphp
                        <button type="button" @click="tierAktif = '{{ $kodeTier }}'"
                            :class="tierAktif === '{{ $kodeTier }}' ? '{{ $metaTier['active'] }}' :
                                'bg-ivory/60 ring-1 ring-champagne/25 hover:ring-champagne/60'"
                            class="rounded-2xl p-3.5 text-left transition cursor-pointer">
                            <div class="flex items-center justify-between gap-2">
                                <span class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold"
                                    :class="tierAktif === 'eksklusif' && '{{ $kodeTier }}'
                                    === 'eksklusif' ? 'text-champagne' : 'text-charcoal'">
                                    <span class="w-2 h-2 rounded-full {{ $metaTier['ikon_warna'] }}"
                                        :class="tierAktif === 'eksklusif' && '{{ $kodeTier }}'
                                        === 'eksklusif' ? 'bg-champagne' : ''"></span>
                                    {{ $dataTier['label'] }}
                                </span>
                                <span class="rounded-full px-2.5 py-0.5 text-[11px] font-semibold"
                                    :class="tierAktif === 'eksklusif' && '{{ $kodeTier }}'
                                    === 'eksklusif' ? 'bg-champagne/20 text-champagne' :
                                        'bg-white text-charcoal/75 ring-1 ring-charcoal/10'">
                                    Mulai {{ \App\Models\Tema::formatRupiah($dataTier['harga_mulai']) }}
                                </span>
                            </div>
                            <p class="mt-1 text-[11px] sm:text-xs"
                                :class="tierAktif === 'eksklusif' && '{{ $kodeTier }}'
                                === 'eksklusif' ? 'text-ivory/80' : 'text-charcoal/65'">
                                {{ $metaTier['deskripsi'] }} ({{ $dataTier['jumlah'] }} tema)
                            </p>
                        </button>
                    @endforeach
                </div>

                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-7">
                    @forelse ($daftarTema as $tema)
                        @php
                            $infoDesain = $tema->infoDesain();
                            $infoTier = $tema->infoTier();
                        @endphp
                        <div x-show="temaCocok('{{ $infoTier['kode'] }}', '{{ e($tema->nama_tema.' '.$tema->kategoriLabel()) }}')"
                            x-transition
                            class="group rounded-2xl bg-white border border-champagne/30 {{ $infoTier['card_ring'] }} flex flex-col transition duration-300 hover:shadow-xl hover:-translate-y-0.5 relative">
                            {{-- Poster Sampul Tema 3-Ponsel (Klik untuk Pratinjau Diperbesar) --}}
                            <button type="button" @click="bukaLightboxSampul('{{ $tema->slug }}')"
                                aria-label="Perbesar sampul {{ $tema->nama_tema }}"
                                class="group/poster relative block w-full overflow-hidden rounded-t-2xl bg-ivory text-left cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-sage">
                                <div class="transition-transform duration-500 group-hover/poster:scale-[1.02]">
                                    <x-poster-sampul-tema :tema="$tema" />
                                </div>

                                <span
                                    class="pointer-events-none absolute bottom-2.5 right-2.5 z-20 inline-flex items-center gap-1 rounded-full bg-charcoal/80 px-2.5 py-1 text-[10px] font-semibold text-white backdrop-blur-xs shadow-sm opacity-90 group-hover/poster:opacity-100 group-hover/poster:bg-sage transition">
                                    <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        aria-hidden="true">
                                        <circle cx="11" cy="11" r="8" />
                                        <path d="m21 21-4.3-4.3" />
                                        <path d="M11 8v6" />
                                        <path d="M8 11h6" />
                                    </svg>
                                    <span>Lihat Sampul</span>
                                </span>
                            </button>

                            {{-- Konten Detail Tema + Tombol Preview Popover 2 Mode --}}
                            <div class="p-5 sm:p-6 bg-white rounded-b-2xl flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex flex-wrap items-center justify-between gap-2 text-[11px]">
                                        <div class="flex items-center gap-1.5">
                                            <span class="font-bold uppercase tracking-wider text-[#8A6D33]">
                                                {{ $tema->kategoriLabel() }}
                                            </span>
                                            <span class="text-charcoal/25">&bull;</span>
                                            <span
                                                class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider {{ $infoTier['badge_class'] }}">
                                                <span>{{ $infoTier['label'] }}</span>
                                            </span>
                                        </div>
                                        @if ($infoDesain['dukungan_tf'])
                                            <span
                                                class="rounded-full bg-ivory px-2.5 py-0.5 font-medium text-charcoal/75 ring-1 ring-champagne/30">
                                                Support Tanpa Foto
                                            </span>
                                        @endif
                                    </div>

                                    <h3 class="mt-2 font-logo text-xl sm:text-2xl font-bold text-charcoal leading-snug">
                                        {{ $tema->nama_tema }}
                                    </h3>

                                    <p class="mt-1.5 text-xs sm:text-sm text-charcoal/65 leading-relaxed">
                                        {{ $infoDesain['deskripsi'] }}
                                    </p>

                                    <div
                                        class="mt-3 pt-3 border-t border-champagne/15 flex items-end justify-between gap-2">
                                        <div>
                                            @if ($tema->adaDiskon())
                                                <span
                                                    class="block text-[11px] text-charcoal/45 line-through leading-none mb-0.5">{{ $tema->hargaAsliFormatted() }}</span>
                                            @endif
                                            <div class="flex items-baseline gap-1">
                                                <span
                                                    class="text-lg sm:text-xl font-extrabold {{ $tema->adaDiskon() ? 'text-rose-600' : 'text-charcoal' }}">{{ $tema->hargaFormatted() }}</span>
                                                <span class="text-[11px] text-charcoal/55">/ {{ $durasiTampil }}
                                                    bln</span>
                                            </div>
                                        </div>

                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1 text-[10px] font-semibold {{ $infoTier['chip_class'] }}">
                                            <span class="inline-block w-1.5 h-1.5 rounded-full"
                                                style="background-color: {{ $infoDesain['warna_aksen'] }}"></span>
                                            <span>{{ $infoTier['ringkasan'] }}</span>
                                        </span>
                                    </div>
                                </div>

                                {{-- Tombol Preview (Muncul 2 Tombol di Atasnya: Pakai Foto & Tanpa Foto) + Pakai Tema Ini --}}
                                <div class="mt-5 space-y-2">
                                    <div class="relative"
                                        @click.away="if (previewTerbukaId === {{ $tema->id }}) previewTerbukaId = null"
                                        @keydown.escape.window="if (previewTerbukaId === {{ $tema->id }}) previewTerbukaId = null">
                                        {{-- Menu 2 Pilihan Muncul Tepat Di Atas Tombol Preview --}}
                                        <div x-show="previewTerbukaId === {{ $tema->id }}" x-cloak
                                            x-transition:enter="transition ease-out duration-150"
                                            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                            x-transition:leave="transition ease-in duration-100"
                                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                            x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                                            class="absolute bottom-full inset-x-0 mb-2 z-30 rounded-2xl bg-white p-1.5 shadow-xl ring-1 ring-champagne/45 space-y-1.5">
                                            <a href="{{ route('tema.demo', ['slugTema' => $tema->slug]) }}"
                                                target="_blank" rel="noopener" @click="previewTerbukaId = null"
                                                class="w-full flex items-center justify-between gap-2 rounded-xl bg-ivory/80 hover:bg-sage/10 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-charcoal hover:text-sage transition">
                                                <span class="inline-flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-sage shrink-0" viewBox="0 0 24 24"
                                                        fill="none" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        aria-hidden="true">
                                                        <rect width="18" height="18" x="3" y="3" rx="2"
                                                            ry="2" />
                                                        <circle cx="9" cy="9" r="2" />
                                                        <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                                                    </svg>
                                                    <span>Pakai Foto</span>
                                                </span>
                                                <svg class="w-3.5 h-3.5 text-charcoal/45 shrink-0" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M7 17 17 7" />
                                                    <path d="M7 7h10v10" />
                                                </svg>
                                            </a>

                                            <a href="{{ route('tema.demo', ['slugTema' => $tema->slug, 'tf' => 1]) }}"
                                                target="_blank" rel="noopener" @click="previewTerbukaId = null"
                                                class="w-full flex items-center justify-between gap-2 rounded-xl bg-ivory/80 hover:bg-champagne/15 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-charcoal hover:text-[#8A6D33] transition">
                                                <span class="inline-flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-[#8A6D33] shrink-0" viewBox="0 0 24 24"
                                                        fill="none" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        aria-hidden="true">
                                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10" />
                                                        <path d="m9 12 2 2 4-4" />
                                                    </svg>
                                                    <span>Tanpa Foto</span>
                                                </span>
                                                <svg class="w-3.5 h-3.5 text-charcoal/45 shrink-0" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M7 17 17 7" />
                                                    <path d="M7 7h10v10" />
                                                </svg>
                                            </a>
                                        </div>

                                        <button type="button"
                                            @click.stop="previewTerbukaId = (previewTerbukaId === {{ $tema->id }} ? null : {{ $tema->id }})"
                                            :aria-expanded="(previewTerbukaId === {{ $tema->id }}).toString()"
                                            :class="previewTerbukaId === {{ $tema->id }} ?
                                                'border-sage bg-sage/5 text-sage' :
                                                'border-champagne/55 bg-white text-charcoal hover:bg-champagne/10'"
                                            class="w-full inline-flex items-center justify-between gap-2 rounded-xl border px-3.5 py-2.5 text-xs sm:text-sm font-semibold transition cursor-pointer">
                                            <span class="inline-flex items-center gap-1.5">
                                                <svg class="w-4 h-4 text-sage shrink-0" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                                    <circle cx="12" cy="12" r="3" />
                                                </svg>
                                                <span>Preview</span>
                                            </span>
                                            <span class="inline-flex items-center gap-1.5">
                                                <span
                                                    class="inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-sage text-[10px] font-bold text-white px-1.5">2</span>
                                                <svg class="w-3.5 h-3.5 transition-transform duration-200"
                                                    :class="previewTerbukaId === {{ $tema->id }} ? 'rotate-180 text-sage' :
                                                        'text-charcoal/55'"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
                                                    aria-hidden="true">
                                                    <path d="m18 15-6-6-6 6" />
                                                </svg>
                                            </span>
                                        </button>
                                    </div>

                                    <a href="{{ auth()->check() ? route('dasbor.katalog', ['pakai' => $tema->id]) : route('daftar', ['tema' => $tema->id]) }}"
                                        class="block w-full text-center rounded-xl bg-sage px-4 py-2.5 text-xs sm:text-sm font-bold text-white shadow-xs hover:bg-[#3b5047] transition">
                                        Pakai Tema Ini
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12 bg-ivory/60 rounded-2xl ring-1 ring-champagne/20">
                            <p class="text-charcoal/70">Belum ada tema aktif tersedia saat ini.</p>
                        </div>
                    @endforelse

                    @if ($daftarTema->isNotEmpty())
                        <div x-show="!adaHasilFilter" x-cloak
                            class="col-span-full text-center py-12 bg-ivory/60 rounded-2xl ring-1 ring-champagne/25 px-6">
                            <p class="text-charcoal/75 font-medium">Tidak ada tema yang sesuai dengan pencarian atau filter
                                yang dipilih.</p>
                            <button type="button" @click="resetFilter()"
                                class="mt-4 rounded-xl bg-sage px-5 py-2 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer">
                                Tampilkan Semua Tema
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        {{-- Tabel Perbandingan 2 Paket Harga --}}
        <section id="paket-harga" class="py-16 sm:py-20 bg-ivory border-t border-champagne/15 px-4 sm:px-6 lg:px-8">
            <div class="max-w-5xl mx-auto">
                <div class="text-center max-w-2xl mx-auto">
                    <span class="text-xs font-semibold uppercase tracking-widest text-champagne">Transparan &amp;
                        Fleksibel</span>
                    <h2 class="mt-2 font-serif text-3xl sm:text-4xl font-bold text-charcoal">Pilih Paket Sesuai Kebutuhan
                        Anda</h2>
                    <p class="mt-3 text-sm sm:text-base text-charcoal/70">Harga dasar mengikuti tema pilihan Anda (Basic,
                        Premium, atau Eksklusif). Susun sendiri lewat dasbor atau serahkan ke tim SesiTemu.</p>
                </div>

                <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Paket Mandiri --}}
                    <div class="rounded-2xl bg-white p-8 ring-1 ring-champagne/25 shadow-sm flex flex-col justify-between">
                        <div>
                            <span
                                class="inline-block rounded-full bg-sage/10 px-3 py-1 text-xs font-semibold text-sage">Self-Service</span>
                            <h3 class="mt-4 font-serif text-3xl font-bold text-charcoal">Paket Mandiri</h3>
                            <p class="mt-2 text-sm text-charcoal/70">Client mengisi data mempelai, acara, galeri, dan
                                amplop secara mandiri melalui dasbor SesiTemu.</p>
                            <div class="mt-6">
                                <div class="flex items-baseline gap-2">
                                    <span class="text-sm font-semibold text-charcoal/65">Mulai</span>
                                    <span
                                        class="font-serif text-4xl font-bold text-charcoal">{{ \App\Models\Tema::formatRupiah($hargaTermurah) }}</span>
                                    <span class="text-sm text-charcoal/60">/ {{ $durasiTampil }} bulan aktif</span>
                                </div>
                                <p class="mt-1 text-xs text-charcoal/60">
                                    Mengikuti harga tema pilihan ({{ \App\Models\Tema::formatRupiah($hargaTermurah) }} –
                                    {{ \App\Models\Tema::formatRupiah($hargaTermahal) }})
                                </p>
                            </div>

                            <ul class="mt-6 space-y-3 text-sm text-charcoal/80">
                                <li>✓ Harga sesuai tema pilihan (Basic, Premium, atau Eksklusif)</li>
                                <li>✓ Bebas ganti tema setara atau upgrade kapan saja</li>
                                <li>✓ Editor mandiri 7-tab real-time + pratinjau gratis</li>
                                <li>✓ Maksimal 10 foto galeri otomatis WebP</li>
                                <li>✓ Generator link tamu WhatsApp tanpa batas</li>
                                <li>✓ Rekap RSVP, ucapan doa, &amp; amplop digital</li>
                            </ul>
                        </div>

                        <a href="{{ auth()->check() ? route('dasbor.index', ['buat' => 1]) : route('daftar') }}"
                            class="mt-8 block text-center rounded-xl bg-sage px-6 py-3.5 text-sm font-semibold text-white hover:bg-sage/90 transition">
                            Mulai Buat Draft Gratis
                        </a>
                    </div>

                    {{-- Paket Terima Beres --}}
                    <div
                        class="rounded-2xl bg-charcoal text-ivory p-8 ring-2 ring-champagne relative flex flex-col justify-between shadow-xl">
                        <span
                            class="absolute -top-3.5 right-6 rounded-full bg-champagne px-3 py-1 text-xs font-bold uppercase tracking-wider text-charcoal">
                            Paling Praktis
                        </span>

                        <div>
                            <span
                                class="inline-block rounded-full bg-champagne/20 px-3 py-1 text-xs font-semibold text-champagne">Full
                                Assistance</span>
                            <h3 class="mt-4 font-serif text-3xl font-bold text-white">Paket Terima Beres</h3>
                            <p class="mt-2 text-sm text-ivory/75">Client cukup mengirimkan data &amp; foto via WhatsApp,
                                Admin SesiTemu yang menginputkan semuanya hingga siap sebar.</p>
                            <div class="mt-6">
                                <div class="flex flex-wrap items-baseline gap-2">
                                    <span class="font-serif text-3xl sm:text-4xl font-bold text-champagne">Harga Tema + {{ \App\Models\Tema::formatRupiah($biayaTerimaBeres) }}</span>
                                </div>
                                <p class="mt-1 text-xs text-ivory/65">
                                    Total mulai {{ \App\Models\Tema::formatRupiah($hargaTermurah + $biayaTerimaBeres) }} /
                                    {{ $durasiTampil }} bulan aktif (sudah termasuk jasa input Admin)
                                </p>
                            </div>

                            <ul class="mt-6 space-y-3 text-sm text-ivory/85">
                                <li>✓ Sudah termasuk harga tema pilihan Anda</li>
                                <li>✓ Biaya jasa input &amp; tata letak Admin
                                    (+{{ \App\Models\Tema::formatRupiah($biayaTerimaBeres) }})</li>
                                <li>✓ Konsultasi pemilihan tema &amp; musik latar</li>
                                <li>✓ Bantuan revisi teks &amp; jadwal acara via WhatsApp</li>
                                <li>✓ Prioritas aktivasi instan siap sebar</li>
                            </ul>
                        </div>

                        <a href="{{ $urlWaTerimaBeres ?? \App\Support\PengaturanSesiTemu::urlWaAdmin('Halo Admin SesiTemu, saya tertarik memesan Paket Terima Beres untuk undangan pernikahan digital.') }}"
                            target="_blank" rel="noopener"
                            class="mt-8 block text-center rounded-xl bg-champagne px-6 py-3.5 text-sm font-semibold text-charcoal hover:bg-champagne/90 transition">
                            Pesan via WhatsApp Admin
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- FAQ Accordion + Banner CTA Penutup --}}
        <section id="faq" class="py-16 bg-white border-t border-champagne/15 px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto space-y-12">
                <div>
                    <div class="text-center max-w-xl mx-auto">
                        <span class="text-xs font-semibold uppercase tracking-widest text-champagne">Pertanyaan Umum</span>
                        <h2 class="mt-2 font-serif text-2xl sm:text-4xl font-bold text-charcoal">Pertanyaan Seputar Undangan Digital</h2>
                    </div>

                    <div class="mt-8 space-y-3">
                        @foreach ([
            ['q' => 'Apakah saya bisa coba membuat & melihat pratinjau undangan dulu sebelum bayar?', 'a' => 'Bisa! Anda dapat mendaftar gratis, mengisi data mempelai, acara, galeri foto, serta melihat pratinjau langsung tampilan undangan sebelum melakukan pembayaran aktivasi.'],
            ['q' => 'Berapa lama masa aktif link undangan digital SesiTemu?', 'a' => 'Setiap undangan yang diaktifkan memiliki masa aktif ' . $durasiTampil . ' bulan penuh sejak pembayaran diverifikasi Admin sehingga tamu dapat mengakses galeri & ucapan jauh setelah hari acara.'],
            ['q' => 'Bagaimana jika kami ingin undangan tanpa foto pengantin (konsep Islami / privasi)?', 'a' => 'Seluruh tema SesiTemu sudah mendukung Mode Tanpa Foto (TF / Monogram) yang bisa diaktifkan dengan 1 klik di editor untuk mengganti potret dengan inisial pasangan yang anggun.'],
            ['q' => 'Apakah saya masih bisa ganti tema setelah data sudah terisi?', 'a' => 'Ya, Anda bebas berganti tema kapan saja di Dasbor Client maupun lewat Katalog Tema dan seluruh data acara, mempelai, galeri, serta tamu tetap aman tersimpan.'],
        ] as $idx => $faq)
                            <div class="rounded-2xl border border-champagne/25 bg-ivory/60 overflow-hidden">
                                <button type="button"
                                    @click="faqAktif = faqAktif === {{ $idx }} ? -1 : {{ $idx }}"
                                    class="w-full px-5 py-4 flex items-center justify-between gap-4 text-left font-semibold text-sm sm:text-base text-charcoal cursor-pointer">
                                    <span>{{ $faq['q'] }}</span>
                                    <span class="text-champagne font-bold text-lg shrink-0"
                                        x-text="faqAktif === {{ $idx }} ? '−' : '+'"></span>
                                </button>
                                <div x-show="faqAktif === {{ $idx }}" x-cloak
                                    class="px-5 pb-4 text-xs sm:text-sm text-charcoal/70 leading-relaxed border-t border-champagne/15 pt-3">
                                    {{ $faq['a'] }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- CTA Penutup & Widget Cek Ketersediaan Link Pasangan --}}
                <div id="cek-link"
                    @if (session('saran_link') || $errors->has('slug')) x-init="$el.scrollIntoView({ behavior: 'smooth', block: 'center' })" @endif
                    class="rounded-3xl bg-gradient-to-br from-[#1B2D24] via-charcoal to-[#262B31] text-ivory p-7 sm:p-10 text-center ring-1 ring-champagne/30 shadow-xl space-y-5">
                    <div class="space-y-2">
                        <span
                            class="inline-block rounded-full bg-champagne/15 px-3 py-1 text-[11px] font-bold uppercase tracking-widest text-champagne">
                            Amankan Link Unik Pasangan
                        </span>
                        <h2 class="font-logo text-2xl sm:text-3xl font-bold text-white">Siap Menyiapkan Undangan Hari
                            Bahagiamu?</h2>
                        <p class="text-xs sm:text-sm text-ivory/75 max-w-xl mx-auto">
                            Cek ketersediaan link undangan pasanganmu sekarang lalu lanjutkan membuat draft gratis di
                            SesiTemu.
                        </p>
                    </div>

                    {{-- Form Cek Ketersediaan Link Pasangan --}}
                    <div class="max-w-xl mx-auto bg-white p-2 sm:p-2.5 rounded-2xl shadow-md">
                        <form action="{{ route('cek.link') }}" method="POST"
                            class="flex flex-col sm:flex-row gap-2.5 items-stretch sm:items-center">
                            @csrf
                            <div
                                class="flex-1 flex items-center rounded-xl border border-charcoal/15 bg-ivory/80 px-4 py-3 focus-within:border-champagne focus-within:bg-white focus-within:ring-2 focus-within:ring-champagne/25">
                                <span class="text-sm font-semibold text-charcoal/50 select-none">sesitemu.id/</span>
                                <input type="text" name="slug" value="{{ old('slug') }}" required
                                    placeholder="dimas-rani" aria-label="Nama link pasangan"
                                    class="w-full bg-transparent text-sm font-semibold text-charcoal placeholder:font-normal placeholder:text-charcoal/40 focus:outline-none ml-0.5">
                            </div>
                            <button type="submit"
                                class="rounded-xl bg-sage px-5 py-3 text-sm font-semibold text-white hover:bg-sage/90 transition shrink-0 cursor-pointer">
                                Cek &amp; Amankan Link
                            </button>
                        </form>

                        @if (session('saran_link'))
                            <div
                                class="mt-2.5 rounded-xl bg-amber-50 border border-amber-200 px-4 py-2.5 text-left text-sm text-amber-800">
                                {{ session('saran_link') }}
                            </div>
                        @endif

                        @error('slug')
                            <div
                                class="mt-2.5 rounded-xl bg-red-50 border border-red-200 px-4 py-2.5 text-left text-sm text-red-700">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="pt-1 flex flex-col sm:flex-row items-center justify-center gap-3">
                        <a href="{{ auth()->check() ? route('dasbor.katalog') : route('daftar') }}"
                            class="w-full sm:w-auto rounded-xl bg-champagne px-6 py-3 text-sm font-bold text-charcoal hover:bg-champagne/90 transition">
                            {{ auth()->check() ? 'Buka Katalog Tema Saya' : 'Buat Draft Gratis Sekarang' }}
                        </a>
                        <a href="{{ $urlWaKonsultasi ?? \App\Support\PengaturanSesiTemu::urlWaAdmin('Halo SesiTemu, saya ingin konsultasi mengenai undangan pernikahan digital.') }}"
                            target="_blank" rel="noopener"
                            class="w-full sm:w-auto rounded-xl bg-white/10 border border-white/15 px-6 py-3 text-sm font-semibold text-ivory hover:bg-white/15 transition">
                            Konsultasi via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer
            class="pt-10 pb-24 md:pb-10 px-4 sm:px-6 lg:px-8 border-t border-champagne/20 bg-ivory text-center text-sm text-charcoal/65">
            <a href="{{ route('beranda') }}" class="inline-flex flex-col items-center">
                <img src="{{ asset('aset-demo/logo-sesi-temu-lengkap.webp') }}" alt="Logo SesiTemu"
                    class="h-20 w-auto object-contain mb-2">
                <span class="font-logo text-sm font-bold tracking-tight text-[#1D3B2C]">Sesi<span
                        class="text-champagne">Temu</span>.id</span>
            </a>
            <p class="mt-1">Abadikan Setiap Sesi Bahagia Menuju Hari Pertemuan &copy; {{ now()->format('Y') }}</p>
        </footer>

        {{-- Bottom Navbar Khusus Mobile (Gaya Aplikasi Mobile) --}}
        <nav aria-label="Navigasi Mobile Beranda" data-landing-bottom-nav
            class="md:hidden fixed bottom-0 inset-x-0 z-40 bg-white/95 backdrop-blur-md border-t border-champagne/25 shadow-[0_-8px_28px_-10px_rgba(31,41,55,0.14)] pb-[env(safe-area-inset-bottom)]">
            <div class="max-w-lg mx-auto grid grid-cols-5 h-16 px-1 items-center gap-0.5">
                <button type="button" @click="seksiAktif = 'beranda'; window.scrollTo({ top: 0, behavior: 'smooth' })"
                    :class="seksiAktif === 'beranda' ? 'text-sage font-bold bg-sage/10' :
                        'text-charcoal/70 hover:text-sage font-medium'"
                    class="flex flex-col items-center justify-center gap-0.5 py-1 rounded-xl transition cursor-pointer">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                    <span class="text-[10px] leading-tight">Beranda</span>
                </button>

                <a href="#katalog-tema" @click="seksiAktif = 'tema'"
                    :class="seksiAktif === 'tema' ? 'text-sage font-bold bg-sage/10' :
                        'text-charcoal/70 hover:text-sage font-medium'"
                    class="flex flex-col items-center justify-center gap-0.5 py-1 rounded-xl transition">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="13.5" cy="6.5" r=".5" fill="currentColor" />
                        <circle cx="17.5" cy="10.5" r=".5" fill="currentColor" />
                        <circle cx="8.5" cy="7.5" r=".5" fill="currentColor" />
                        <circle cx="6.5" cy="12.5" r=".5" fill="currentColor" />
                        <path
                            d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z" />
                    </svg>
                    <span class="text-[10px] leading-tight">Tema</span>
                </a>

                <a href="{{ auth()->check() ? route('dasbor.katalog') : route('daftar') }}"
                    class="flex flex-col items-center justify-center gap-0.5 py-1 rounded-xl text-charcoal/85 hover:text-sage font-semibold transition">
                    <span
                        class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-sage text-white shadow-xs">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <line x1="12" x2="12" y1="5" y2="19" />
                            <line x1="5" x2="19" y1="12" y2="12" />
                        </svg>
                    </span>
                    <span class="text-[10px] leading-tight">Buat</span>
                </a>

                <a href="#paket-harga" @click="seksiAktif = 'harga'"
                    :class="seksiAktif === 'harga' ? 'text-sage font-bold bg-sage/10' :
                        'text-charcoal/70 hover:text-sage font-medium'"
                    class="flex flex-col items-center justify-center gap-0.5 py-1 rounded-xl transition">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z" />
                        <path d="M7 7h.01" />
                    </svg>
                    <span class="text-[10px] leading-tight">Harga</span>
                </a>

                <a href="{{ auth()->check() ? (auth()->user()->adalahAdmin() ? '/admin' : '/dasbor') : route('login') }}"
                    class="flex flex-col items-center justify-center gap-0.5 py-1 rounded-xl text-charcoal/70 hover:text-sage font-medium transition">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="8" r="4" />
                        <path d="M20 21a8 8 0 0 0-16 0" />
                    </svg>
                    <span class="text-[10px] leading-tight">
                        @auth
                            {{ auth()->user()->adalahAdmin() ? 'Admin' : 'Dasbor' }}
                        @else
                            Masuk
                        @endauth
                    </span>
                </a>
            </div>
        </nav>

        {{-- Modal Simulasi Nama Tamu Preview --}}
        <div x-show="modalDemoTerbuka" x-cloak
            class="fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-charcoal/60 backdrop-blur-sm p-0 sm:p-4"
            @keydown.escape.window="modalDemoTerbuka = false">
            <div @click.away="modalDemoTerbuka = false"
                class="w-full max-w-md rounded-t-3xl sm:rounded-2xl bg-white p-5 sm:p-6 shadow-xl ring-1 ring-champagne/30 max-h-[90dvh] overflow-y-auto">
                <h3 class="font-serif text-2xl font-bold text-charcoal">Pratinjau Tema</h3>
                <p class="mt-1 text-sm text-charcoal/70">
                    Masukkan nama tamu contoh untuk melihat tampilan sampul tema <span class="font-semibold text-sage"
                        x-text="temaDemoNama"></span><span x-show="temaDemoInfo"
                        class="ml-1 inline-block rounded-full bg-champagne/15 px-2 py-0.5 text-xs font-semibold text-charcoal"
                        x-text="temaDemoInfo"></span>.
                </p>

                <div class="mt-4 space-y-4">
                    <div>
                        <label for="nama_tamu_demo" class="block text-sm font-medium text-charcoal">Nama Tamu
                            Undangan</label>
                        <input id="nama_tamu_demo" type="text" x-model="namaTamuDemo"
                            class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/70 px-4 py-2.5 text-sm text-charcoal focus:border-champagne focus:bg-white focus:outline-none focus:ring-2 focus:ring-champagne/25">
                    </div>

                    <div>
                        <label for="font_demo" class="block text-sm font-medium text-charcoal">Desain Tipografi
                            (Font)</label>
                        <select id="font_demo" x-model="fontDemo"
                            class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/70 px-4 py-2.5 text-sm text-charcoal focus:border-champagne focus:bg-white focus:outline-none focus:ring-2 focus:ring-champagne/25">
                            @foreach (\App\Models\Undangan::GAYA_FONT_TERSEDIA as $kodeFont => $infoFont)
                                <option value="{{ $kodeFont }}">{{ $infoFont['label'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <label
                        class="flex items-center gap-2.5 rounded-xl border border-champagne/30 bg-ivory/60 px-3.5 py-2.5 text-sm text-charcoal cursor-pointer">
                        <input type="checkbox" x-model="tanpaFotoDemo"
                            class="rounded border-charcoal/25 text-sage focus:ring-sage">
                        <span>Pratinjau Mode Tanpa Foto (TF / Monogram)</span>
                    </label>
                </div>

                <div class="mt-6 flex items-center justify-end gap-3">
                    <button type="button" @click="modalDemoTerbuka = false"
                        class="rounded-xl px-4 py-2 text-sm font-semibold text-charcoal/70 hover:bg-charcoal/5 cursor-pointer">
                        Batal
                    </button>
                    <button type="button" @click="bukaUrlDemo()"
                        class="rounded-xl bg-sage px-5 py-2 text-sm font-semibold text-white hover:bg-sage/90 cursor-pointer">
                        Buka Preview
                    </button>
                </div>
            </div>
        </div>

        {{-- Tombol WhatsApp Mengambang (Ikon WA, Muncul Teks saat Hover) --}}
        <a href="{{ $urlWaKonsultasi ?? \App\Support\PengaturanSesiTemu::urlWaAdmin('Halo SesiTemu, saya ingin konsultasi mengenai undangan pernikahan digital.') }}"
            target="_blank" rel="noopener" aria-label="Konsultasi WhatsApp SesiTemu"
            class="group fixed bottom-20 right-3.5 md:bottom-5 md:right-5 z-40 inline-flex items-center rounded-full bg-sage p-3 md:p-3.5 text-white shadow-lg shadow-sage/30 ring-2 ring-white/85 hover:bg-[#3b5047] hover:pr-4 md:hover:pr-5 transition-all duration-300">
            <svg class="w-6 h-6 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path
                    d="M12.031 2c-5.516 0-9.969 4.453-9.969 9.969 0 1.766.469 3.484 1.344 5l-1.406 5.156 5.281-1.375c1.469.797 3.109 1.219 4.75 1.219 5.516 0 9.969-4.453 9.969-9.969S17.547 2 12.031 2Zm5.813 14.125c-.25.703-1.438 1.344-2 1.422-.516.078-1.172.109-1.891-.125-.438-.141-1-.328-1.719-.641-3.016-1.313-4.984-4.359-5.141-4.563-.156-.203-1.234-1.641-1.234-3.125s.781-2.219 1.063-2.516c.281-.297.609-.375.813-.375.203 0 .406 0 .578.016.188.016.438-.078.688.531.25.609.859 2.094.938 2.25.078.156.125.344.016.547-.109.203-.156.344-.313.516-.156.172-.328.391-.469.516-.156.156-.313.328-.141.641.172.313.781 1.297 1.672 2.094 1.156 1.031 2.125 1.344 2.438 1.5.313.156.484.125.672-.078.188-.203.781-.906.984-1.219.203-.313.406-.266.688-.156.281.109 1.797.844 2.109 1 .313.156.516.234.594.359.078.125.078.734-.172 1.438Z" />
            </svg>
            <span
                class="max-w-0 overflow-hidden whitespace-nowrap opacity-0 group-hover:max-w-[140px] group-hover:opacity-100 group-hover:ml-2 text-xs sm:text-sm font-semibold transition-all duration-300">
                Konsultasi WA
            </span>
        </a>

        <x-modal-lightbox-sampul :daftar-tema="$daftarTema" :mode-katalog-client="false" />
    </div>
@endsection
