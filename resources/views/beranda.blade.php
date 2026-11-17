@extends('layouts.aplikasi')

@section('judul', 'SesiTemu — Platform Undangan Pernikahan Digital Modern')

@section('konten')
@php
    $durasiTampil = $durasiAktifBulan ?? \App\Support\PengaturanSesiTemu::masaAktifBulan();
    $daftarFilterJson = $daftarTema->map(fn ($t) => [
        'kategori' => $t->kategori,
        'tier' => $t->tierKode(),
    ])->values();

    $fallbackHeroSlides = [
        [
            'slug' => $daftarTema->firstWhere('slug', 'rustic-floral')?->slug ?? ($daftarTema->first()?->slug ?? 'rustic-floral'),
            'label' => 'Floral Pastel',
            'nama_tema' => $daftarTema->firstWhere('slug', 'rustic-floral')?->nama_tema ?? 'Rustic Floral',
            'pasangan' => 'Dimas & Rani',
            'tanggal' => 'Sabtu, 24 Oktober 2026',
            'gambar' => asset('aset-demo/sampul-rustic.webp'),
            'gelap' => false,
            'aksen' => '#4B6358',
        ],
        [
            'slug' => $daftarTema->firstWhere('slug', 'luxury-noir')?->slug ?? ($daftarTema->skip(1)->first()?->slug ?? ($daftarTema->first()?->slug ?? 'luxury-noir')),
            'label' => 'Luxury Noir',
            'nama_tema' => $daftarTema->firstWhere('slug', 'luxury-noir')?->nama_tema ?? 'Luxury Noir Monogram',
            'pasangan' => 'Arga & Nadira',
            'tanggal' => 'Minggu, 08 November 2026',
            'gambar' => asset('aset-demo/sampul-luxury.webp'),
            'gelap' => true,
            'aksen' => '#D4AF37',
        ],
        [
            'slug' => $daftarTema->firstWhere('slug', 'adat-jawa')?->slug ?? ($daftarTema->skip(2)->first()?->slug ?? ($daftarTema->first()?->slug ?? 'adat-jawa')),
            'label' => 'Adat Keraton',
            'nama_tema' => $daftarTema->firstWhere('slug', 'adat-jawa')?->nama_tema ?? 'Adat Jawa Keraton',
            'pasangan' => 'Bagas & Laras',
            'tanggal' => 'Sabtu, 19 Desember 2026',
            'gambar' => asset('aset-demo/sampul-jawa.webp'),
            'gelap' => false,
            'aksen' => '#BFA15F',
        ],
    ];

    $temaPertamaDemo = $daftarTema->first();
@endphp

<div x-data="{
    menuMobileTerbuka: false,
    kategoriAktif: 'semua',
    tierAktif: 'semua',
    daftarFilter: @js($daftarFilterJson),
    heroTemaIndex: 0,
    heroSlides: @js($fallbackHeroSlides),
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
    temaCocok(kategori, tier) {
        return (this.kategoriAktif === 'semua' || this.kategoriAktif === kategori)
            && (this.tierAktif === 'semua' || this.tierAktif === tier);
    },
    get adaHasilFilter() {
        return this.daftarFilter.some(item => this.temaCocok(item.kategori, item.tier));
    },
    resetFilter() {
        this.kategoriAktif = 'semua';
        this.tierAktif = 'semua';
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
    }
}">
    {{-- Header / Navbar --}}
    <header class="sticky top-0 z-40 bg-ivory/95 backdrop-blur-md border-b border-champagne/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-3">
            <a href="{{ route('beranda') }}" class="flex items-center gap-2.5 group shrink-0">
                <img
                    src="{{ asset('aset-demo/logo-sesi-temu-ikon.webp') }}"
                    alt="Logo SesiTemu"
                    class="h-9 w-9 sm:h-10 sm:w-10 object-contain transition-transform duration-200 group-hover:scale-105"
                >
                <span class="font-logo text-2xl sm:text-3xl font-bold tracking-tight text-[#1D3B2C] leading-none">
                    Sesi<span class="text-champagne">Temu</span>
                </span>
            </a>

            <nav class="hidden md:flex items-center gap-7 text-sm font-medium text-charcoal/80">
                <a href="#cara-kerja" class="hover:text-sage transition">Cara Kerja</a>
                <a href="#keunggulan" class="hover:text-sage transition">Fitur</a>
                <a href="#katalog-tema" class="hover:text-sage transition">Katalog Tema</a>
                <a href="#paket-harga" class="hover:text-sage transition">Paket Harga</a>
                <a href="#faq" class="hover:text-sage transition">FAQ</a>
            </nav>

            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                @auth
                    <a href="{{ auth()->user()->adalahAdmin() ? '/admin' : '/dasbor' }}" class="rounded-xl bg-sage px-4 py-2 text-xs sm:text-sm font-semibold text-white hover:bg-sage/90 transition">
                        {{ auth()->user()->adalahAdmin() ? 'Panel Admin' : 'Dasbor Saya' }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-semibold text-charcoal hover:text-sage transition">
                        Masuk
                    </a>
                    <a href="{{ route('daftar') }}" class="rounded-xl bg-sage px-3.5 sm:px-4 py-2 text-xs sm:text-sm font-semibold text-white shadow-sm hover:bg-sage/90 transition">
                        Buat Undangan
                    </a>
                @endauth

                <button
                    type="button"
                    @click="menuMobileTerbuka = !menuMobileTerbuka"
                    aria-label="Buka menu navigasi"
                    class="md:hidden rounded-xl border border-charcoal/15 p-2 text-charcoal hover:bg-white cursor-pointer"
                >
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="4" x2="20" y1="6" y2="6"/>
                        <line x1="4" x2="20" y1="12" y2="12"/>
                        <line x1="4" x2="20" y1="18" y2="18"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Dropdown Navigasi Mobile --}}
        <div x-show="menuMobileTerbuka" x-cloak @click.away="menuMobileTerbuka = false" class="md:hidden border-t border-champagne/20 bg-white px-4 py-3 space-y-1 shadow-lg">
            <a href="#cara-kerja" @click="menuMobileTerbuka = false" class="block rounded-xl px-3 py-2 text-sm font-medium text-charcoal hover:bg-ivory">Cara Kerja</a>
            <a href="#keunggulan" @click="menuMobileTerbuka = false" class="block rounded-xl px-3 py-2 text-sm font-medium text-charcoal hover:bg-ivory">Fitur Lengkap</a>
            <a href="#katalog-tema" @click="menuMobileTerbuka = false" class="block rounded-xl px-3 py-2 text-sm font-medium text-charcoal hover:bg-ivory">Katalog Tema</a>
            <a href="#paket-harga" @click="menuMobileTerbuka = false" class="block rounded-xl px-3 py-2 text-sm font-medium text-charcoal hover:bg-ivory">Paket Harga</a>
            <a href="#faq" @click="menuMobileTerbuka = false" class="block rounded-xl px-3 py-2 text-sm font-medium text-charcoal hover:bg-ivory">FAQ</a>
        </div>
    </header>

    {{-- Hero Section: Split Value Proposition + Pratinjau Ponsel Undangan Digital Interaktif --}}
    <section class="relative overflow-hidden pt-10 pb-16 sm:pt-16 sm:pb-24 px-4 sm:px-6 lg:px-8">
        <div class="absolute -top-28 right-0 w-[30rem] h-[30rem] rounded-full bg-champagne/15 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-32 -left-12 w-[26rem] h-[26rem] rounded-full bg-sage/12 blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
            {{-- Kolom Kiri: Headline Jelas Undangan Digital + Cek Link --}}
            <div class="lg:col-span-6 text-center lg:text-left space-y-5">
                <div class="inline-flex items-center gap-2 rounded-full bg-champagne/15 border border-champagne/30 px-4 py-1.5 text-[11px] sm:text-xs font-bold uppercase tracking-widest text-[#8A6D33]">
                    <span class="h-2 w-2 rounded-full bg-sage"></span>
                    <span>Website Undangan Pernikahan Digital</span>
                </div>

                <h1 class="font-logo text-3xl sm:text-5xl lg:text-[3.35rem] font-bold text-charcoal leading-[1.15] tracking-tight">
                    Abadikan Setiap Sesi Bahagia Menuju <span class="text-sage">Hari Pertemuan</span>
                </h1>

                <p class="text-sm sm:text-base lg:text-lg text-charcoal/75 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                    Buat &amp; sebar <strong>undangan pernikahan website</strong> elegan dalam hitungan menit. Lengkap dengan galeri foto hemat kuota (.WebP), musik latar, amplop digital, RSVP real-time, hingga kirim link tamu WhatsApp personal.
                </p>

                {{-- Form Cek Link Pasangan --}}
                <div class="pt-1 max-w-xl mx-auto lg:mx-0">
                    <div class="bg-white p-2.5 sm:p-3 rounded-2xl shadow-lg shadow-charcoal/5 ring-1 ring-champagne/30">
                        <form action="{{ route('cek.link') }}" method="POST" class="flex flex-col sm:flex-row gap-2.5 items-stretch sm:items-center">
                            @csrf
                            <div class="flex-1 flex items-center rounded-xl border border-charcoal/15 bg-ivory/80 px-4 py-3 focus-within:border-champagne focus-within:bg-white focus-within:ring-2 focus-within:ring-champagne/25">
                                <span class="text-sm font-semibold text-charcoal/50 select-none">sesitemu.id/</span>
                                <input
                                    type="text"
                                    name="slug"
                                    value="{{ old('slug') }}"
                                    required
                                    placeholder="dimas-rani"
                                    aria-label="Nama link pasangan"
                                    class="w-full bg-transparent text-sm font-semibold text-charcoal placeholder:font-normal placeholder:text-charcoal/40 focus:outline-none ml-0.5"
                                >
                            </div>
                            <button type="submit" class="rounded-xl bg-sage px-5 py-3.5 text-sm font-semibold text-white hover:bg-sage/90 transition shrink-0 cursor-pointer shadow-sm">
                                Cek Ketersediaan Link
                            </button>
                        </form>

                        @if (session('saran_link'))
                            <div class="mt-2.5 rounded-xl bg-amber-50 border border-amber-200 px-4 py-2.5 text-left text-sm text-amber-800">
                                {{ session('saran_link') }}
                            </div>
                        @endif

                        @error('slug')
                            <div class="mt-2.5 rounded-xl bg-red-50 border border-red-200 px-4 py-2.5 text-left text-sm text-red-700">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <p class="mt-2 text-xs text-charcoal/55">Coba tulis nama panggilanmu &amp; pasangan — gratis pratinjau dulu sebelum bayar.</p>
                </div>

                {{-- Tombol Sekunder & Trust Highlights --}}
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-3 pt-1">
                    <a
                        href="#katalog-tema"
                        class="inline-flex items-center gap-2 rounded-xl bg-charcoal px-5 py-2.5 text-xs sm:text-sm font-semibold text-champagne hover:bg-charcoal/90 transition shadow-sm"
                    >
                        <span>Lihat {{ $daftarTema->count() > 0 ? $daftarTema->count().' ' : '' }}Koleksi Tema</span>
                        <span aria-hidden="true">↓</span>
                    </a>
                    @if ($temaPertamaDemo)
                        <button
                            type="button"
                            @click="bukaModalDemo('{{ $temaPertamaDemo->slug }}', '{{ e($temaPertamaDemo->nama_tema) }}', '{{ $temaPertamaDemo->tierLabel() }} • {{ $temaPertamaDemo->hargaFormatted() }}')"
                            class="inline-flex items-center gap-2 rounded-xl border border-champagne bg-white px-5 py-2.5 text-xs sm:text-sm font-semibold text-charcoal hover:bg-champagne/10 transition cursor-pointer"
                        >
                            <span>Coba Live Demo</span>
                            <span aria-hidden="true">→</span>
                        </button>
                    @endif
                </div>

                <div class="pt-2 flex flex-wrap items-center justify-center lg:justify-start gap-x-5 gap-y-2 text-xs text-charcoal/65">
                    <span class="inline-flex items-center gap-1.5">
                        <span class="text-sage font-bold">✓</span>
                        <span>Aktif {{ $durasiTampil }} Bulan Penuh</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <span class="text-sage font-bold">✓</span>
                        <span>Kompresi Foto Otomatis .WebP</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <span class="text-sage font-bold">✓</span>
                        <span>Siap Mobile &amp; OpenGraph WhatsApp</span>
                    </span>
                </div>
            </div>

            {{-- Kolom Kanan: Mockup Interaktif Layar HP Undangan Digital --}}
            <div class="lg:col-span-6 relative">
                <div class="relative mx-auto max-w-[330px] sm:max-w-[360px]">
                    {{-- Kartu Melayang Atas Kiri: Link Tamu WhatsApp --}}
                    <div class="hidden sm:flex items-center gap-2.5 absolute -left-10 top-10 z-20 rounded-2xl bg-white/95 backdrop-blur-md px-3.5 py-2.5 shadow-xl ring-1 ring-champagne/30 max-w-[215px]">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700 shrink-0">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="m22 2-7 20-4-9-9-4Z"/>
                                <path d="M22 2 11 13"/>
                            </svg>
                        </span>
                        <div class="min-w-0">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-700">Link Personal Tamu</p>
                            <p class="text-[11px] font-medium text-charcoal truncate">?to=Budi+Santoso</p>
                        </div>
                    </div>

                    {{-- Kartu Melayang Bawah Kanan: RSVP & Amplop --}}
                    <div class="hidden sm:flex items-center gap-2.5 absolute -right-10 bottom-20 z-20 rounded-2xl bg-charcoal/95 text-ivory px-3.5 py-2.5 shadow-xl ring-1 ring-champagne/40 max-w-[215px]">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-champagne/20 text-champagne shrink-0">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                            </svg>
                        </span>
                        <div class="min-w-0">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-champagne">RSVP Real-Time</p>
                            <p class="text-[11px] text-ivory/85 truncate">Fajar &amp; Kel. • Hadir ✓</p>
                        </div>
                    </div>

                    {{-- Bingkai Smartphone --}}
                    <div class="rounded-[2.6rem] bg-charcoal p-2.5 shadow-2xl ring-2 ring-champagne/45">
                        <div class="rounded-[2.1rem] overflow-hidden bg-ivory relative flex flex-col">
                            {{-- Address Bar Mockup Website Undangan --}}
                            <div class="bg-charcoal/95 px-4 pt-2.5 pb-2 flex items-center justify-between gap-2 text-[10px] text-ivory/80">
                                <span class="inline-flex items-center gap-1 font-mono truncate">
                                    <span class="text-emerald-400">🔒</span>
                                    <span>sesitemu.id/dimas-rani</span>
                                </span>
                                <span class="rounded-full bg-champagne/20 px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider text-champagne shrink-0">
                                    Live Web
                                </span>
                            </div>

                            {{-- Layar Sampul Undangan Digital --}}
                            <div
                                class="relative h-[370px] sm:h-[395px] flex flex-col justify-between p-5 text-center transition-colors duration-300"
                                :class="heroSlideAktif.gelap ? 'bg-[#111827] text-ivory' : 'bg-[#FDFBF7] text-charcoal'"
                            >
                                <img
                                    :src="heroSlideAktif.gambar"
                                    :alt="heroSlideAktif.nama_tema"
                                    class="absolute inset-0 w-full h-full object-cover transition-all duration-500"
                                    :class="heroSlideAktif.gelap ? 'opacity-45' : 'opacity-85'"
                                >
                                <div
                                    class="absolute inset-0"
                                    :class="heroSlideAktif.gelap
                                        ? 'bg-gradient-to-b from-[#0f172a]/70 via-[#0f172a]/45 to-[#0f172a]/90'
                                        : 'bg-gradient-to-b from-white/80 via-white/35 to-ivory/95'"
                                ></div>

                                {{-- Konten Atas Sampul --}}
                                <div class="relative z-10 pt-2 space-y-1">
                                    <p class="text-[10px] font-bold uppercase tracking-[0.25em] opacity-80">The Wedding Of</p>
                                    <h2 class="font-logo text-3xl font-bold tracking-tight" x-text="heroSlideAktif.pasangan"></h2>
                                    <p class="text-xs font-medium opacity-80" x-text="heroSlideAktif.tanggal"></p>
                                </div>

                                {{-- Konten Bawah Sampul + Personalisasi Tamu --}}
                                <div class="relative z-10 space-y-3 pb-1">
                                    <div
                                        class="rounded-2xl px-4 py-3 backdrop-blur-md border text-center"
                                        :class="heroSlideAktif.gelap
                                            ? 'bg-white/10 border-champagne/35 text-ivory'
                                            : 'bg-white/88 border-champagne/40 text-charcoal shadow-sm'"
                                    >
                                        <p class="text-[10px] opacity-75">Kepada Yth. Bapak/Ibu/Saudara/i</p>
                                        <p class="text-sm font-bold mt-0.5">Budi Santoso &amp; Partner</p>

                                        <div class="mt-2.5 grid grid-cols-3 gap-1.5 text-center border-t pt-2" :class="heroSlideAktif.gelap ? 'border-white/15' : 'border-champagne/20'">
                                            <div>
                                                <p class="text-xs font-bold">14</p>
                                                <p class="text-[9px] opacity-65">Hari</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold">08</p>
                                                <p class="text-[9px] opacity-65">Jam</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold">25</p>
                                                <p class="text-[9px] opacity-65">Menit</p>
                                            </div>
                                        </div>
                                    </div>

                                    <button
                                        type="button"
                                        @click="bukaModalDemo(heroSlideAktif.slug, heroSlideAktif.nama_tema, 'Live Preview')"
                                        class="w-full rounded-xl px-4 py-2.5 text-xs font-bold shadow-md transition cursor-pointer"
                                        :class="heroSlideAktif.gelap ? 'bg-champagne text-charcoal hover:bg-champagne/90' : 'bg-sage text-white hover:bg-sage/90'"
                                    >
                                        Buka Contoh Undangan ✨
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Switcher Tema di Bawah Mockup HP --}}
                    <div class="mt-4 flex items-center justify-center gap-2 flex-wrap">
                        <template x-for="(slide, idx) in heroSlides" :key="idx">
                            <button
                                type="button"
                                @click="heroTemaIndex = idx"
                                :class="heroTemaIndex === idx ? 'bg-charcoal text-champagne ring-1 ring-champagne shadow-sm' : 'bg-white text-charcoal/75 ring-1 ring-charcoal/15 hover:bg-champagne/10'"
                                class="rounded-full px-3 py-1.5 text-[11px] font-semibold transition cursor-pointer"
                                x-text="slide.label"
                            ></button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Cara Kerja: 3 Langkah Mudah --}}
    <section id="cara-kerja" class="py-14 sm:py-16 bg-white border-t border-champagne/15 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="text-center max-w-2xl mx-auto">
                <span class="text-xs font-semibold uppercase tracking-widest text-champagne">Alur Praktis</span>
                <h2 class="mt-2 font-serif text-2xl sm:text-4xl font-bold text-charcoal">3 Langkah Undangan Digital Siap Sebar</h2>
                <p class="mt-2.5 text-sm sm:text-base text-charcoal/70">Tanpa perlu install aplikasi atau keahlian desain — semua bisa diatur langsung lewat HP maupun laptop.</p>
            </div>

            <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="rounded-2xl bg-ivory/80 p-6 ring-1 ring-champagne/25 relative">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-sage text-white font-bold text-sm shadow-xs">01</span>
                    <h3 class="mt-4 font-serif text-xl font-bold text-charcoal">Pilih Tema &amp; Cek Link</h3>
                    <p class="mt-2 text-sm text-charcoal/70 leading-relaxed">Eksplor tema Modern, Adat, Luxury, hingga Islami lalu pesan link unik pasangan Anda seperti <span class="font-mono text-sage font-semibold">sesitemu.id/dimas-rani</span>.</p>
                </div>

                <div class="rounded-2xl bg-ivory/80 p-6 ring-1 ring-champagne/25 relative">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-champagne text-charcoal font-bold text-sm shadow-xs">02</span>
                    <h3 class="mt-4 font-serif text-xl font-bold text-charcoal">Isi Data atau Terima Beres</h3>
                    <p class="mt-2 text-sm text-charcoal/70 leading-relaxed">Lengkapi data mempelai, lokasi Maps, musik latar, foto galeri, serta amplop digital mandiri atau titip tim Admin mengisikannya.</p>
                </div>

                <div class="rounded-2xl bg-ivory/80 p-6 ring-1 ring-champagne/25 relative">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-charcoal text-champagne font-bold text-sm shadow-xs">03</span>
                    <h3 class="mt-4 font-serif text-xl font-bold text-charcoal">Sebar Personal via WhatsApp</h3>
                    <p class="mt-2 text-sm text-charcoal/70 leading-relaxed">Buat daftar nama tamu untuk menghasilkan link &amp; teks sambutan personal sekali klik, lalu pantau ucapan serta RSVP tamu secara live.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Keunggulan SesiTemu --}}
    <section id="keunggulan" class="py-16 bg-ivory border-y border-champagne/15 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center max-w-2xl mx-auto">
                <span class="text-xs font-semibold uppercase tracking-widest text-champagne">Fitur Lengkap Undangan</span>
                <h2 class="mt-2 font-serif text-3xl sm:text-4xl font-bold text-charcoal">Mengapa Memilih SesiTemu?</h2>
                <p class="mt-3 text-sm sm:text-base text-charcoal/70">Dirancang khusus untuk kebutuhan calon pengantin di Indonesia dengan performa ringan dan pengelolaan praktis.</p>
            </div>

            <div class="mt-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="rounded-2xl bg-white p-6 ring-1 ring-champagne/20 shadow-xs hover:-translate-y-1 hover:shadow-md transition duration-200">
                    <div class="w-11 h-11 rounded-xl bg-sage/10 text-sage flex items-center justify-center">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/>
                            <circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/>
                            <circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/>
                            <circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/>
                            <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/>
                        </svg>
                    </div>
                    <h3 class="mt-4 font-serif text-lg sm:text-xl font-semibold text-charcoal">Pratinjau &amp; Ganti Tema Instan</h3>
                    <p class="mt-2 text-sm text-charcoal/70 leading-relaxed">Coba live demo sebelum daftar, dan ganti tema kapan saja tanpa kehilangan data mempelai maupun acara.</p>
                </div>

                <div class="rounded-2xl bg-white p-6 ring-1 ring-champagne/20 shadow-xs hover:-translate-y-1 hover:shadow-md transition duration-200">
                    <div class="w-11 h-11 rounded-xl bg-champagne/15 text-[#8A6D33] flex items-center justify-center">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect width="18" height="18" x="3" y="3" rx="2" ry="2"/>
                            <circle cx="9" cy="9" r="2"/>
                            <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                        </svg>
                    </div>
                    <h3 class="mt-4 font-serif text-lg sm:text-xl font-semibold text-charcoal">Otomatis Kompresi WebP</h3>
                    <p class="mt-2 text-sm text-charcoal/70 leading-relaxed">Setiap foto prewedding otomatis di-resize dan dikonversi ke .webp agar undangan terbuka super cepat di HP tamu.</p>
                </div>

                <div class="rounded-2xl bg-white p-6 ring-1 ring-champagne/20 shadow-xs hover:-translate-y-1 hover:shadow-md transition duration-200">
                    <div class="w-11 h-11 rounded-xl bg-sage/10 text-sage flex items-center justify-center">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m22 2-7 20-4-9-9-4Z"/>
                            <path d="M22 2 11 13"/>
                        </svg>
                    </div>
                    <h3 class="mt-4 font-serif text-lg sm:text-xl font-semibold text-charcoal">Sebar Tamu WhatsApp Massal</h3>
                    <p class="mt-2 text-sm text-charcoal/70 leading-relaxed">Cukup tempel daftar nama tamu, sistem langsung membuat link personal ?to=Nama+Tamu beserta tombol kirim WA.</p>
                </div>

                <div class="rounded-2xl bg-white p-6 ring-1 ring-champagne/20 shadow-xs hover:-translate-y-1 hover:shadow-md transition duration-200">
                    <div class="w-11 h-11 rounded-xl bg-champagne/15 text-[#8A6D33] flex items-center justify-center">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="3" y="8" width="18" height="4" rx="1"/>
                            <path d="M12 8v13"/>
                            <path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"/>
                            <path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"/>
                        </svg>
                    </div>
                    <h3 class="mt-4 font-serif text-lg sm:text-xl font-semibold text-charcoal">RSVP &amp; Amplop Digital</h3>
                    <p class="mt-2 text-sm text-charcoal/70 leading-relaxed">Pantau rekap jumlah tamu hadir, moderasi ucapan doa, serta tampilkan rekening bank/e-wallet dengan fitur salin cepat.</p>
                </div>
            </div>

            {{-- Strip Kelengkapan Fitur Pendukung --}}
            <div class="mt-8 rounded-2xl bg-white px-5 py-4 ring-1 ring-champagne/20 flex flex-wrap items-center justify-center gap-x-6 gap-y-2.5 text-xs sm:text-sm font-medium text-charcoal/80">
                <span>♫ Musik Latar Romantis</span>
                <span class="text-champagne">•</span>
                <span>🛡️ Mode Tanpa Foto (Privasi/Syar'i)</span>
                <span class="text-champagne">•</span>
                <span>📍 Navigasi Google Maps</span>
                <span class="text-champagne">•</span>
                <span>⏳ Hitung Mundur Acara</span>
                <span class="text-champagne">•</span>
                <span>🎥 Tautan Live Streaming</span>
            </div>
        </div>
    </section>

    {{-- Katalog Tema dengan Filter Kategori, Tingkatan Tier & Modal Simulasi Nama Tamu --}}
    <section id="katalog-tema" class="py-16 sm:py-20 bg-white px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-widest text-champagne">Pilihan Desain Eksklusif</span>
                    <h2 class="mt-2 font-serif text-3xl sm:text-4xl font-bold text-charcoal">Katalog Tema Undangan</h2>
                </div>

                {{-- Filter Tab Kategori --}}
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1 md:flex-wrap md:overflow-visible">
                    <button
                        type="button"
                        @click="kategoriAktif = 'semua'"
                        :class="kategoriAktif === 'semua' ? 'bg-sage text-white shadow-sm' : 'bg-ivory text-charcoal/80 hover:bg-champagne/10 ring-1 ring-charcoal/10'"
                        class="rounded-xl px-4 py-2 text-xs sm:text-sm font-semibold transition cursor-pointer shrink-0"
                    >
                        Semua
                    </button>
                    @foreach (\App\Models\Tema::KATEGORI_TERSEDIA as $kode => $label)
                        <button
                            type="button"
                            @click="kategoriAktif = '{{ $kode }}'"
                            :class="kategoriAktif === '{{ $kode }}' ? 'bg-sage text-white shadow-sm' : 'bg-ivory text-charcoal/80 hover:bg-champagne/10 ring-1 ring-charcoal/10'"
                            class="rounded-xl px-4 py-2 text-xs sm:text-sm font-semibold transition cursor-pointer shrink-0"
                        >
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Pilihan Tingkatan Kualitas (Tier) Tema --}}
            <div class="mt-7 grid grid-cols-2 lg:grid-cols-4 gap-3">
                <button
                    type="button"
                    @click="tierAktif = 'semua'"
                    :class="tierAktif === 'semua' ? 'bg-sage/10 ring-2 ring-sage shadow-sm' : 'bg-ivory/60 ring-1 ring-champagne/25 hover:ring-champagne/60'"
                    class="rounded-2xl p-3.5 text-left transition cursor-pointer"
                >
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-xs sm:text-sm font-bold text-charcoal">Semua Tier</span>
                        <span class="rounded-full bg-white px-2.5 py-0.5 text-[11px] font-semibold text-charcoal/70 ring-1 ring-charcoal/10">
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
                    <button
                        type="button"
                        @click="tierAktif = '{{ $kodeTier }}'"
                        :class="tierAktif === '{{ $kodeTier }}' ? '{{ $metaTier['active'] }}' : 'bg-ivory/60 ring-1 ring-champagne/25 hover:ring-champagne/60'"
                        class="rounded-2xl p-3.5 text-left transition cursor-pointer"
                    >
                        <div class="flex items-center justify-between gap-2">
                            <span class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold" :class="tierAktif === 'eksklusif' && '{{ $kodeTier }}' === 'eksklusif' ? 'text-champagne' : 'text-charcoal'">
                                <span class="w-2 h-2 rounded-full {{ $metaTier['ikon_warna'] }}" :class="tierAktif === 'eksklusif' && '{{ $kodeTier }}' === 'eksklusif' ? 'bg-champagne' : ''"></span>
                                {{ $dataTier['label'] }}
                            </span>
                            <span
                                class="rounded-full px-2.5 py-0.5 text-[11px] font-semibold"
                                :class="tierAktif === 'eksklusif' && '{{ $kodeTier }}' === 'eksklusif' ? 'bg-champagne/20 text-champagne' : 'bg-white text-charcoal/75 ring-1 ring-charcoal/10'"
                            >
                                Mulai {{ \App\Models\Tema::formatRupiah($dataTier['harga_mulai']) }}
                            </span>
                        </div>
                        <p
                            class="mt-1 text-[11px] sm:text-xs"
                            :class="tierAktif === 'eksklusif' && '{{ $kodeTier }}' === 'eksklusif' ? 'text-ivory/80' : 'text-charcoal/65'"
                        >
                            {{ $metaTier['deskripsi'] }} ({{ $dataTier['jumlah'] }} tema)
                        </p>
                    </button>
                @endforeach
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @forelse ($daftarTema as $tema)
                    @php
                        $infoDesain = $tema->infoDesain();
                        $infoTier = $tema->infoTier();
                    @endphp
                    <div
                        x-show="temaCocok('{{ $tema->kategori }}', '{{ $infoTier['kode'] }}')"
                        x-transition
                        class="group rounded-2xl bg-ivory/40 overflow-hidden {{ $infoTier['card_ring'] }} flex flex-col transition duration-300 hover:shadow-lg"
                    >
                        <div class="aspect-[4/3] bg-ivory relative overflow-hidden">
                            @if ($tema->urlGambarPratinjau())
                                <img
                                    src="{{ $tema->urlGambarPratinjau() }}"
                                    alt="{{ $tema->nama_tema }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                >
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-sage/10 text-sage font-serif text-2xl">
                                    {{ $tema->nama_tema }}
                                </div>
                            @endif
                            <span class="absolute top-3 left-3 rounded-full bg-white/95 backdrop-blur px-3 py-1 text-xs font-semibold uppercase tracking-wider text-charcoal shadow-sm">
                                {{ $tema->kategoriLabel() }}
                            </span>
                            @if ($infoDesain['dukungan_tf'])
                                <span class="absolute top-3 right-3 rounded-full bg-charcoal/85 backdrop-blur px-2.5 py-1 text-[11px] font-medium text-ivory">
                                    Support Tanpa Foto (TF)
                                </span>
                            @endif
                            <span class="absolute bottom-3 left-3 inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-[11px] font-bold uppercase tracking-wider backdrop-blur {{ $infoTier['badge_class'] }}">
                                @if ($infoTier['kode'] === 'eksklusif')
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M2.5 14.5h15v1.75a.75.75 0 01-.75.75H3.25a.75.75 0 01-.75-.75V14.5zm0-2L1.75 6l4.75 3.25L10 4.5l3.5 4.75L18.25 6l-.75 6.5h-15z"/>
                                    </svg>
                                @elseif ($infoTier['kode'] === 'premium')
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.96a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.447a1 1 0 00-.364 1.118l1.286 3.96c.3.921-.755 1.688-1.54 1.118l-3.367-2.447a1 1 0 00-1.175 0l-3.367 2.447c-.784.57-1.838-.197-1.539-1.118l1.285-3.96a1 1 0 00-.363-1.118L2.063 9.387c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.96z"/>
                                    </svg>
                                @else
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 2a1 1 0 01.894.553l1.72 3.44 3.796.552a1 1 0 01.554 1.706l-2.747 2.677.648 3.781a1 1 0 01-1.45 1.054L10 13.978l-3.415 1.785a1 1 0 01-1.45-1.054l.648-3.781L3.036 8.25a1 1 0 01.554-1.706l3.796-.552 1.72-3.44A1 1 0 0110 2z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                                <span>{{ $infoTier['label'] }}</span>
                            </span>
                            @if ($tema->adaDiskon())
                                <span class="absolute bottom-3 right-3 rounded-full bg-rose-600 px-3 py-1 text-[11px] font-bold text-white shadow-sm">
                                    {{ $tema->labelBadgeDiskon() }}
                                </span>
                            @endif
                        </div>

                        <div class="p-6 bg-white flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between gap-2 pb-3 mb-3 border-b border-champagne/15">
                                    <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-[11px] font-semibold {{ $infoTier['chip_class'] }}">
                                        {{ $infoTier['ringkasan'] }}
                                    </span>
                                    <div class="text-right shrink-0">
                                        @if ($tema->adaDiskon())
                                            <span class="block text-[11px] text-charcoal/45 line-through leading-none mb-0.5">{{ $tema->hargaAsliFormatted() }}</span>
                                        @endif
                                        <span class="text-lg font-extrabold {{ $tema->adaDiskon() ? 'text-rose-600' : 'text-charcoal' }}">{{ $tema->hargaFormatted() }}</span>
                                        <span class="text-[11px] text-charcoal/55">/ {{ $durasiTampil }} bln</span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 text-[11px] font-semibold uppercase tracking-wider text-champagne">
                                    <span class="inline-block w-2 h-2 rounded-full" style="background-color: {{ $infoDesain['warna_aksen'] }}"></span>
                                    <span>{{ $infoDesain['font_label'] }}</span>
                                </div>
                                <h3 class="mt-1.5 font-serif text-2xl font-bold text-charcoal">{{ $tema->nama_tema }}</h3>
                                <p class="mt-1.5 text-sm text-charcoal/65 leading-relaxed">{{ $infoDesain['deskripsi'] }}</p>
                                <p class="mt-2.5 text-[11px] font-medium text-sage">{{ $infoTier['fitur_singkat'] }}</p>
                            </div>

                            <div class="mt-6 flex items-center gap-3">
                                <button
                                    type="button"
                                    @click="bukaModalDemo('{{ $tema->slug }}', '{{ e($tema->nama_tema) }}', '{{ $infoTier['label'] }} • {{ $tema->hargaFormatted() }}')"
                                    class="flex-1 rounded-xl border border-champagne px-4 py-2.5 text-sm font-semibold text-charcoal hover:bg-champagne/10 transition cursor-pointer"
                                >
                                    Lihat Demo
                                </button>
                                <a
                                    href="{{ auth()->check() ? route('dasbor.katalog', ['pakai' => $tema->id]) : route('daftar', ['tema' => $tema->id]) }}"
                                    class="flex-1 text-center rounded-xl bg-sage px-4 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition"
                                >
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
                    <div
                        x-show="!adaHasilFilter"
                        x-cloak
                        class="col-span-full text-center py-12 bg-ivory/60 rounded-2xl ring-1 ring-champagne/25 px-6"
                    >
                        <p class="text-charcoal/75 font-medium">Tidak ada tema pada kombinasi kategori dan tingkatan yang dipilih.</p>
                        <button
                            type="button"
                            @click="resetFilter()"
                            class="mt-4 rounded-xl bg-sage px-5 py-2 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer"
                        >
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
                <span class="text-xs font-semibold uppercase tracking-widest text-champagne">Transparan &amp; Fleksibel</span>
                <h2 class="mt-2 font-serif text-3xl sm:text-4xl font-bold text-charcoal">Pilih Paket Sesuai Kebutuhan Anda</h2>
                <p class="mt-3 text-sm sm:text-base text-charcoal/70">Harga dasar mengikuti tema pilihan Anda (Basic, Premium, atau Eksklusif). Susun sendiri lewat dasbor atau serahkan ke tim SesiTemu.</p>
            </div>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Paket Mandiri --}}
                <div class="rounded-2xl bg-white p-8 ring-1 ring-champagne/25 shadow-sm flex flex-col justify-between">
                    <div>
                        <span class="inline-block rounded-full bg-sage/10 px-3 py-1 text-xs font-semibold text-sage">Self-Service</span>
                        <h3 class="mt-4 font-serif text-3xl font-bold text-charcoal">Paket Mandiri</h3>
                        <p class="mt-2 text-sm text-charcoal/70">Client mengisi data mempelai, acara, galeri, dan amplop secara mandiri melalui dasbor SesiTemu.</p>
                        <div class="mt-6">
                            <div class="flex items-baseline gap-2">
                                <span class="text-sm font-semibold text-charcoal/65">Mulai</span>
                                <span class="font-serif text-4xl font-bold text-charcoal">{{ \App\Models\Tema::formatRupiah($hargaTermurah) }}</span>
                                <span class="text-sm text-charcoal/60">/ {{ $durasiTampil }} bulan aktif</span>
                            </div>
                            <p class="mt-1 text-xs text-charcoal/60">
                                Mengikuti harga tema pilihan ({{ \App\Models\Tema::formatRupiah($hargaTermurah) }} – {{ \App\Models\Tema::formatRupiah($hargaTermahal) }})
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

                    <a href="{{ auth()->check() ? route('dasbor.index', ['buat' => 1]) : route('daftar') }}" class="mt-8 block text-center rounded-xl bg-sage px-6 py-3.5 text-sm font-semibold text-white hover:bg-sage/90 transition">
                        Mulai Buat Draft Gratis
                    </a>
                </div>

                {{-- Paket Terima Beres --}}
                <div class="rounded-2xl bg-charcoal text-ivory p-8 ring-2 ring-champagne relative flex flex-col justify-between shadow-xl">
                    <span class="absolute -top-3.5 right-6 rounded-full bg-champagne px-3 py-1 text-xs font-bold uppercase tracking-wider text-charcoal">
                        Paling Praktis
                    </span>

                    <div>
                        <span class="inline-block rounded-full bg-champagne/20 px-3 py-1 text-xs font-semibold text-champagne">Full Assistance</span>
                        <h3 class="mt-4 font-serif text-3xl font-bold text-white">Paket Terima Beres</h3>
                        <p class="mt-2 text-sm text-ivory/75">Client cukup mengirimkan data &amp; foto via WhatsApp, Admin SesiTemu yang menginputkan semuanya hingga siap sebar.</p>
                        <div class="mt-6">
                            <div class="flex flex-wrap items-baseline gap-2">
                                <span class="font-serif text-3xl sm:text-4xl font-bold text-champagne">Harga Tema + {{ \App\Models\Tema::formatRupiah($biayaTerimaBeres) }}</span>
                            </div>
                            <p class="mt-1 text-xs text-ivory/65">
                                Total mulai {{ \App\Models\Tema::formatRupiah($hargaTermurah + $biayaTerimaBeres) }} / {{ $durasiTampil }} bulan aktif (sudah termasuk jasa input Admin)
                            </p>
                        </div>

                        <ul class="mt-6 space-y-3 text-sm text-ivory/85">
                            <li>✓ Sudah termasuk harga tema pilihan Anda</li>
                            <li>✓ Biaya jasa input &amp; tata letak Admin (+{{ \App\Models\Tema::formatRupiah($biayaTerimaBeres) }})</li>
                            <li>✓ Konsultasi pemilihan tema &amp; musik latar</li>
                            <li>✓ Bantuan revisi teks &amp; jadwal acara via WhatsApp</li>
                            <li>✓ Prioritas aktivasi instan siap sebar</li>
                        </ul>
                    </div>

                    <a
                        href="{{ $urlWaTerimaBeres ?? \App\Support\PengaturanSesiTemu::urlWaAdmin('Halo Admin SesiTemu, saya tertarik memesan Paket Terima Beres untuk undangan pernikahan digital.') }}"
                        target="_blank"
                        rel="noopener"
                        class="mt-8 block text-center rounded-xl bg-champagne px-6 py-3.5 text-sm font-semibold text-charcoal hover:bg-champagne/90 transition"
                    >
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
                        ['q' => 'Berapa lama masa aktif link undangan digital SesiTemu?', 'a' => 'Setiap undangan yang diaktifkan memiliki masa aktif '.$durasiTampil.' bulan penuh sejak pembayaran diverifikasi Admin sehingga tamu dapat mengakses galeri & ucapan jauh setelah hari acara.'],
                        ['q' => 'Bagaimana jika kami ingin undangan tanpa foto pengantin (konsep Islami / privasi)?', 'a' => 'Seluruh tema SesiTemu sudah mendukung Mode Tanpa Foto (TF / Monogram) yang bisa diaktifkan dengan 1 klik di editor untuk mengganti potret dengan inisial pasangan yang anggun.'],
                        ['q' => 'Apakah saya masih bisa ganti tema setelah data sudah terisi?', 'a' => 'Ya, Anda bebas berganti tema kapan saja di Dasbor Client maupun lewat Katalog Tema dan seluruh data acara, mempelai, galeri, serta tamu tetap aman tersimpan.'],
                    ] as $idx => $faq)
                        <div class="rounded-2xl border border-champagne/25 bg-ivory/60 overflow-hidden">
                            <button
                                type="button"
                                @click="faqAktif = faqAktif === {{ $idx }} ? -1 : {{ $idx }}"
                                class="w-full px-5 py-4 flex items-center justify-between gap-4 text-left font-semibold text-sm sm:text-base text-charcoal cursor-pointer"
                            >
                                <span>{{ $faq['q'] }}</span>
                                <span class="text-champagne font-bold text-lg shrink-0" x-text="faqAktif === {{ $idx }} ? '−' : '+'"></span>
                            </button>
                            <div x-show="faqAktif === {{ $idx }}" x-cloak class="px-5 pb-4 text-xs sm:text-sm text-charcoal/70 leading-relaxed border-t border-champagne/15 pt-3">
                                {{ $faq['a'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- CTA Penutup --}}
            <div class="rounded-3xl bg-gradient-to-br from-[#1B2D24] via-charcoal to-[#262B31] text-ivory p-7 sm:p-10 text-center ring-1 ring-champagne/30 shadow-xl space-y-4">
                <h2 class="font-logo text-2xl sm:text-3xl font-bold text-white">Siap Menyiapkan Undangan Hari Bahagiamu?</h2>
                <p class="text-xs sm:text-sm text-ivory/75 max-w-xl mx-auto">
                    Mulai buat draft undangan pernikahan digital Anda hari ini—gratis mencoba semua tema dan fitur sepuasnya.
                </p>
                <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a
                        href="{{ auth()->check() ? route('dasbor.katalog') : route('daftar') }}"
                        class="w-full sm:w-auto rounded-xl bg-champagne px-6 py-3 text-sm font-bold text-charcoal hover:bg-champagne/90 transition"
                    >
                        {{ auth()->check() ? 'Buka Katalog Tema Saya' : 'Buat Draft Gratis Sekarang' }}
                    </a>
                    <a
                        href="{{ $urlWaKonsultasi ?? \App\Support\PengaturanSesiTemu::urlWaAdmin('Halo SesiTemu, saya ingin konsultasi mengenai undangan pernikahan digital.') }}"
                        target="_blank"
                        rel="noopener"
                        class="w-full sm:w-auto rounded-xl bg-white/10 border border-white/15 px-6 py-3 text-sm font-semibold text-ivory hover:bg-white/15 transition"
                    >
                        Konsultasi via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="py-10 px-4 sm:px-6 lg:px-8 border-t border-champagne/20 bg-ivory text-center text-sm text-charcoal/65">
        <a href="{{ route('beranda') }}" class="inline-flex flex-col items-center">
            <img
                src="{{ asset('aset-demo/logo-sesi-temu-lengkap.webp') }}"
                alt="Logo SesiTemu"
                class="h-20 w-auto object-contain mb-2"
            >
            <span class="font-logo text-sm font-bold tracking-tight text-[#1D3B2C]">Sesi<span class="text-champagne">Temu</span>.id</span>
        </a>
        <p class="mt-1">Abadikan Setiap Sesi Bahagia Menuju Hari Pertemuan &copy; {{ now()->format('Y') }}</p>
    </footer>

    {{-- Modal Simulasi Nama Tamu Live Demo --}}
    <div
        x-show="modalDemoTerbuka"
        x-cloak
        class="fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-charcoal/60 backdrop-blur-sm p-0 sm:p-4"
        @keydown.escape.window="modalDemoTerbuka = false"
    >
        <div @click.away="modalDemoTerbuka = false" class="w-full max-w-md rounded-t-3xl sm:rounded-2xl bg-white p-5 sm:p-6 shadow-xl ring-1 ring-champagne/30 max-h-[90dvh] overflow-y-auto">
            <h3 class="font-serif text-2xl font-bold text-charcoal">Pratinjau Live Demo</h3>
            <p class="mt-1 text-sm text-charcoal/70">
                Masukkan nama tamu contoh untuk melihat tampilan sampul tema <span class="font-semibold text-sage" x-text="temaDemoNama"></span><span x-show="temaDemoInfo" class="ml-1 inline-block rounded-full bg-champagne/15 px-2 py-0.5 text-xs font-semibold text-charcoal" x-text="temaDemoInfo"></span>.
            </p>

            <div class="mt-4 space-y-4">
                <div>
                    <label for="nama_tamu_demo" class="block text-sm font-medium text-charcoal">Nama Tamu Undangan</label>
                    <input
                        id="nama_tamu_demo"
                        type="text"
                        x-model="namaTamuDemo"
                        class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/70 px-4 py-2.5 text-sm text-charcoal focus:border-champagne focus:bg-white focus:outline-none focus:ring-2 focus:ring-champagne/25"
                    >
                </div>

                <div>
                    <label for="font_demo" class="block text-sm font-medium text-charcoal">Desain Tipografi (Font)</label>
                    <select
                        id="font_demo"
                        x-model="fontDemo"
                        class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/70 px-4 py-2.5 text-sm text-charcoal focus:border-champagne focus:bg-white focus:outline-none focus:ring-2 focus:ring-champagne/25"
                    >
                        @foreach (\App\Models\Undangan::GAYA_FONT_TERSEDIA as $kodeFont => $infoFont)
                            <option value="{{ $kodeFont }}">{{ $infoFont['label'] }}</option>
                        @endforeach
                    </select>
                </div>

                <label class="flex items-center gap-2.5 rounded-xl border border-champagne/30 bg-ivory/60 px-3.5 py-2.5 text-sm text-charcoal cursor-pointer">
                    <input
                        type="checkbox"
                        x-model="tanpaFotoDemo"
                        class="rounded border-charcoal/25 text-sage focus:ring-sage"
                    >
                    <span>Pratinjau Mode Tanpa Foto (TF / Monogram)</span>
                </label>
            </div>

            <div class="mt-6 flex items-center justify-end gap-3">
                <button type="button" @click="modalDemoTerbuka = false" class="rounded-xl px-4 py-2 text-sm font-semibold text-charcoal/70 hover:bg-charcoal/5 cursor-pointer">
                    Batal
                </button>
                <button type="button" @click="bukaUrlDemo()" class="rounded-xl bg-sage px-5 py-2 text-sm font-semibold text-white hover:bg-sage/90 cursor-pointer">
                    Buka Live Demo
                </button>
            </div>
        </div>
    </div>

    {{-- Tombol WhatsApp Mengambang --}}
    <a
        href="{{ $urlWaKonsultasi ?? \App\Support\PengaturanSesiTemu::urlWaAdmin('Halo SesiTemu, saya ingin konsultasi mengenai undangan pernikahan digital.') }}"
        target="_blank"
        rel="noopener"
        aria-label="Hubungi WhatsApp SesiTemu"
        class="fixed bottom-5 right-5 z-40 inline-flex items-center gap-2 rounded-full bg-sage px-4 py-3 text-sm font-semibold text-white shadow-lg hover:bg-sage/90 transition"
    >
        <span>Konsultasi WA</span>
    </a>
</div>
@endsection
