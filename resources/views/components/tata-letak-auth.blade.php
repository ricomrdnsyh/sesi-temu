@props([
    'mode' => 'masuk',
    'judulHalaman' => 'Masuk ke Akun Anda',
    'subjudul' => 'Kelola undangan pernikahan digital dan pantau buku tamu Anda.',
    'temaTerpilih' => null,
    'durasiBulan' => null,
])

@php
    $durasi = $durasiBulan ?? \App\Support\PengaturanSesiTemu::masaAktifBulan();
    $slidesShowcase = [
        [
            'label' => 'Rustic',
            'tema' => 'Rustic Floral',
            'pasangan' => 'Dimas & Rani',
            'inisial' => 'D&R',
            'domain' => 'sesitemu.id/dimas-rani',
            'tamu' => '124 Tamu Hadir',
            'gambar' => asset('aset-demo/sampul-rustic.webp'),
        ],
        [
            'label' => 'Garden',
            'tema' => 'Velvet Garden',
            'pasangan' => 'Narendra & Seruni',
            'inisial' => 'N&S',
            'domain' => 'sesitemu.id/narendra-seruni',
            'tamu' => '186 Tamu Hadir',
            'gambar' => asset('aset-demo/sampul-garden.webp'),
        ],
        [
            'label' => 'Jawa',
            'tema' => 'Adat Jawa Keraton',
            'pasangan' => 'Akmal & Aisyah',
            'inisial' => 'A&A',
            'domain' => 'sesitemu.id/akmal-aisyah',
            'tamu' => '210 Tamu Hadir',
            'gambar' => asset('aset-demo/sampul-jawa.webp'),
        ],
        [
            'label' => 'Sunda',
            'tema' => 'Sunda Siger Heritage',
            'pasangan' => 'Bagja & Nenden',
            'inisial' => 'B&N',
            'domain' => 'sesitemu.id/bagja-nenden',
            'tamu' => '158 Tamu Hadir',
            'gambar' => asset('aset-demo/sampul-sunda.webp'),
        ],
    ];

    $latarTemaTerpilih = null;
    if ($temaTerpilih) {
        $relatif = "aset-tema/{$temaTerpilih->slug}/latar-utama.webp";
        $latarTemaTerpilih = is_file(public_path($relatif))
            ? asset($relatif)
            : ($temaTerpilih->urlGambarPratinjau() ?? asset('aset-demo/sampul-rustic.webp'));
    }
@endphp

<div class="min-h-screen w-full lg:grid lg:grid-cols-12 bg-ivory relative overflow-x-hidden">
    {{-- Panel Showcase Kiri Full-Bleed Editorial (Desktop) --}}
    <aside
        x-data="{
            slideAktif: 0,
            slides: @js($slidesShowcase),
            timer: null,
            mulaiAuto() {
                this.timer = setInterval(() => {
                    this.slideAktif = (this.slideAktif + 1) % this.slides.length;
                }, 5500);
            },
            pilihSlide(idx) {
                this.slideAktif = idx;
                if (this.timer) {
                    clearInterval(this.timer);
                    this.mulaiAuto();
                }
            },
            init() {
                @if (! $temaTerpilih)
                    this.mulaiAuto();
                @endif
            }
        }"
        class="hidden lg:flex lg:col-span-6 relative overflow-hidden bg-[#132920] text-ivory flex-col justify-between p-8 xl:p-12 select-none"
    >
        @if ($temaTerpilih)
            {{-- Mode Tema Terpilih: Latar Kabur Halus + Poster 3 Ponsel Diperbesar --}}
            <img
                src="{{ $latarTemaTerpilih }}"
                alt=""
                aria-hidden="true"
                class="absolute inset-0 w-full h-full object-cover scale-105 opacity-35 blur-xs"
            >
            <div aria-hidden="true" class="absolute inset-0 bg-gradient-to-b from-[#0E2119]/85 via-[#132920]/75 to-[#0B1B14]/95"></div>
        @else
            {{-- Mode Showcase Beranda Auth: Foto Pernikahan Full-Bleed Tajam --}}
            @foreach ($slidesShowcase as $idx => $itemSlide)
                <img
                    src="{{ $itemSlide['gambar'] }}"
                    alt="{{ $itemSlide['tema'] }} — {{ $itemSlide['pasangan'] }}"
                    x-show="slideAktif === {{ $idx }}"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 scale-105"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-500"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="absolute inset-0 w-full h-full object-cover object-top"
                    @if ($idx > 0) x-cloak @endif
                >
            @endforeach
            <div
                aria-hidden="true"
                class="pointer-events-none absolute inset-0 bg-gradient-to-b from-[#0B1B14]/65 via-transparent via-40% to-[#0B1B14]/95"
            ></div>
            <div
                aria-hidden="true"
                class="pointer-events-none absolute inset-x-0 bottom-0 h-[55%] bg-gradient-to-t from-[#0B1B14] via-[#0B1B14]/80 to-transparent"
            ></div>
        @endif

        {{-- Bingkai Halus di Tepi --}}
        <div aria-hidden="true" class="pointer-events-none absolute inset-5 rounded-3xl border border-white/15 z-10"></div>

        {{-- Bar Atas --}}
        <div class="relative z-20 flex items-center justify-between gap-4">
            <a href="{{ route('beranda') }}" class="inline-flex items-center gap-2 rounded-full bg-black/35 hover:bg-black/50 px-4 py-2 text-xs font-semibold text-white ring-1 ring-white/25 backdrop-blur-md transition">
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
                <span>Kembali ke Beranda</span>
            </a>

            @if (! $temaTerpilih)
                <div class="inline-flex items-center gap-1 rounded-full bg-black/35 p-1 ring-1 ring-white/20 backdrop-blur-md">
                    @foreach ($slidesShowcase as $idx => $itemSlide)
                        <button
                            type="button"
                            @click="pilihSlide({{ $idx }})"
                            :class="slideAktif === {{ $idx }} ? 'bg-champagne text-charcoal shadow-xs' : 'text-white/80 hover:text-white'"
                            class="rounded-full px-2.5 py-1 text-[11px] font-semibold transition cursor-pointer"
                        >
                            {{ $itemSlide['label'] }}
                        </button>
                    @endforeach
                </div>
            @else
                <span class="rounded-full bg-champagne/20 px-3.5 py-1 text-[11px] font-bold uppercase tracking-[0.2em] text-champagne ring-1 ring-champagne/35 backdrop-blur-md">
                    SesiTemu.id
                </span>
            @endif
        </div>

        @if ($temaTerpilih)
            {{-- Showcase Poster Tema Terpilih --}}
            <div class="relative z-20 my-auto py-6 flex flex-col items-center text-center max-w-md mx-auto">
                <div class="w-full max-w-[360px] rounded-2xl overflow-hidden shadow-[0_24px_60px_rgba(0,0,0,0.55)] ring-2 ring-champagne/50">
                    <x-poster-sampul-tema :tema="$temaTerpilih" />
                </div>
                <div class="mt-4 inline-flex items-center gap-2 rounded-full bg-white/12 px-4 py-1.5 text-xs font-semibold text-champagne ring-1 ring-champagne/35 backdrop-blur-md">
                    <span>Tema Pilihan:</span>
                    <span class="text-white">{{ $temaTerpilih->nama_tema }}</span>
                </div>
            </div>
        @endif

        {{-- Blok Editorial Bawah --}}
        <div class="relative z-20 mt-auto space-y-5">
            @if (! $temaTerpilih)
                {{-- Bar Kartu Pratinjau Mini Mengambang --}}
                <div class="rounded-2xl bg-black/45 backdrop-blur-md px-4 py-3 ring-1 ring-white/20 flex items-center justify-between gap-4 shadow-xl">
                    <div class="flex items-center gap-3 min-w-0">
                        <span
                            class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-champagne/20 text-champagne font-logo text-sm font-bold ring-1 ring-champagne/40"
                            x-text="slides[slideAktif].inisial"
                        >D&amp;R</span>
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <p class="text-sm font-bold text-white truncate" x-text="slides[slideAktif].pasangan">Dimas &amp; Rani</p>
                                <span class="rounded-full bg-white/15 px-2 py-0.5 text-[10px] font-medium text-champagne shrink-0" x-text="slides[slideAktif].tema">Rustic Floral</span>
                            </div>
                            <p class="text-[11px] font-mono text-white/70 truncate" x-text="slides[slideAktif].domain">sesitemu.id/dimas-rani</p>
                        </div>
                    </div>

                    <div class="hidden xl:flex items-center gap-1.5 rounded-full bg-sage/85 px-3 py-1 text-[11px] font-semibold text-white shrink-0 ring-1 ring-white/20">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M20 6 9 17l-5-5" />
                        </svg>
                        <span x-text="slides[slideAktif].tamu">124 Tamu Hadir</span>
                    </div>
                </div>
            @endif

            <div>
                <h2 class="font-logo text-3xl xl:text-[2.2rem] font-bold text-white leading-tight drop-shadow-sm">
                    Bagikan Momen Sakral dengan Tampilan Berkelas
                </h2>
                <p class="mt-2 text-xs xl:text-sm text-ivory/80 leading-relaxed max-w-xl">
                    Susun data mempelai, jadwal acara, galeri otomatis WebP, amplop digital, hingga link tamu personal WhatsApp dalam satu dasbor rapi.
                </p>

                <div class="mt-4 flex flex-wrap items-center gap-2 text-[11px] font-medium text-ivory/95">
                    <span class="rounded-full bg-white/12 px-3 py-1 ring-1 ring-white/15 backdrop-blur-xs">Masa Aktif {{ $durasi }} Bulan</span>
                    <span class="rounded-full bg-white/12 px-3 py-1 ring-1 ring-white/15 backdrop-blur-xs">Bebas Ganti Tema</span>
                    <span class="rounded-full bg-white/12 px-3 py-1 ring-1 ring-white/15 backdrop-blur-xs">Mode Tanpa Foto</span>
                </div>
            </div>

            <div class="flex items-center justify-between gap-4 border-t border-white/15 pt-4 text-xs text-ivory/70">
                <span>Platform Undangan Digital Modern</span>
                <span class="text-champagne font-semibold">&starf; Siap Pakai dalam Hitungan Menit</span>
            </div>
        </div>
    </aside>

    {{-- Kolom Form Kanan --}}
    <main class="lg:col-span-6 flex flex-col justify-center py-8 sm:py-12 px-4 sm:px-8 lg:px-12 relative overflow-hidden">
        <div aria-hidden="true" class="pointer-events-none absolute -top-24 -right-24 w-80 h-80 rounded-full bg-champagne/14 blur-3xl"></div>
        <div aria-hidden="true" class="pointer-events-none absolute -bottom-24 -left-24 w-80 h-80 rounded-full bg-sage/12 blur-3xl"></div>

        {{-- Tautan Kembali Mobile --}}
        <div class="lg:hidden relative z-10 w-full max-w-[460px] mx-auto mb-4">
            <a href="{{ route('beranda') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-charcoal/70 hover:text-sage transition">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
                <span>Kembali ke Beranda</span>
            </a>
        </div>

        <div class="relative z-10 w-full max-w-[460px] mx-auto">
            <div class="bg-white rounded-3xl p-6 sm:p-9 shadow-[0_24px_60px_-20px_rgba(31,41,55,0.12)] ring-1 ring-champagne/25">
                {{-- Logo + Tab Switcher --}}
                <div class="text-center">
                    <a href="{{ route('beranda') }}" class="inline-flex flex-col items-center justify-center group">
                        <img
                            src="{{ asset('aset-demo/logo-sesi-temu-lengkap.webp') }}"
                            alt="Logo SesiTemu"
                            class="h-16 sm:h-20 w-auto object-contain transition-transform duration-200 group-hover:scale-105"
                        >
                        <span class="sr-only">SesiTemu</span>
                    </a>

                    <div class="mt-5 grid grid-cols-2 rounded-xl bg-ivory p-1 ring-1 ring-champagne/25">
                        <a
                            href="{{ route('login') }}"
                            class="rounded-lg py-2 text-xs sm:text-sm font-semibold transition {{ $mode === 'masuk' ? 'bg-sage text-white shadow-xs' : 'text-charcoal/70 hover:text-charcoal' }}"
                        >
                            Masuk
                        </a>
                        <a
                            href="{{ route('daftar') }}"
                            class="rounded-lg py-2 text-xs sm:text-sm font-semibold transition {{ $mode === 'daftar' ? 'bg-sage text-white shadow-xs' : 'text-charcoal/70 hover:text-charcoal' }}"
                        >
                            Daftar Gratis
                        </a>
                    </div>

                    <h1 class="mt-5 font-logo text-2xl sm:text-[1.75rem] font-bold text-charcoal leading-tight">
                        {{ $judulHalaman }}
                    </h1>
                    <p class="mt-1.5 text-xs sm:text-sm text-charcoal/65 leading-relaxed">
                        {{ $subjudul }}
                    </p>
                </div>

                <div class="mt-6">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </main>
</div>
