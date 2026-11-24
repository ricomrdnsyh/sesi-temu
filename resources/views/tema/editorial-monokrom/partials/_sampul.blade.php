{{-- SAMPUL PEMBUKA EDITORIAL MONOKROM: LEICA 35MM VIEWFINDER & VOGUE COLLECTOR ISSUE --}}
<section
    data-transisi-sampul="fade-halus"
    class="tirai-fade-halus tirai-shutter-editorial fixed inset-0 mx-auto h-dvh w-full lg:w-[460px] xl:w-[490px] z-40 {{ $tampilBarDemo ? 'pt-28 sm:pt-20 lg:pt-14' : '' }}"
    style="height: 100dvh;"
    :class="undanganTerbuka ? 'tirai-terbuka pointer-events-none' : ''"
>
    <div class="relative w-full h-full flex flex-col justify-between overflow-hidden bg-[#0E0E11] text-white">
        {{-- Latar Penuh Monokrom Kontras Tinggi --}}
        <img
            src="{{ $pakaiFotoSampul ? $urlFotoSampul : $urlFotoLatar }}"
            alt="Sampul {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
            fetchpriority="high"
            decoding="sync"
            class="absolute inset-0 w-full h-full object-cover grayscale contrast-[1.12] {{ $pakaiFotoSampul ? 'object-top scale-[1.03] animasi-nafas' : 'object-center scale-105 opacity-45 animasi-nafas' }}"
        >

        {{-- Gradasi Editorial & Tekstur Film Grain 35mm --}}
        <div
            aria-hidden="true"
            class="pointer-events-none absolute inset-0"
            style="background: {{ $pakaiFotoSampul
                ? 'linear-gradient(180deg, rgba(12,12,15,0.86) 0%, rgba(12,12,15,0.28) 26%, rgba(12,12,15,0.06) 48%, rgba(12,12,15,0.42) 68%, rgba(10,10,13,0.94) 88%, #09090B 100%)'
                : 'linear-gradient(180deg, rgba(10,10,13,0.92) 0%, rgba(17,17,20,0.76) 48%, rgba(9,9,11,0.96) 100%)' }};"
        ></div>
        <div aria-hidden="true" class="pointer-events-none absolute inset-0 ed-film-grain opacity-45"></div>

        {{-- Garis Scan Viewfinder Halus & Siku Pembidik Kamera (Crop Marks) --}}
        <div aria-hidden="true" class="pointer-events-none absolute inset-4 z-10 border border-white/20">
            <span class="absolute -top-px -left-px h-4 w-4 border-t-2 border-l-2 border-white"></span>
            <span class="absolute -top-px -right-px h-4 w-4 border-t-2 border-r-2 border-white"></span>
            <span class="absolute -bottom-px -left-px h-4 w-4 border-b-2 border-l-2 border-white"></span>
            <span class="absolute -bottom-px -right-px h-4 w-4 border-b-2 border-r-2 border-white"></span>
            <div class="ed-scanline absolute inset-x-0 top-12 h-px bg-gradient-to-r from-transparent via-white/45 to-transparent"></div>
        </div>

        {{-- Label Punggung Majalah Vertikal di Tepi Kiri --}}
        <div aria-hidden="true" class="pointer-events-none absolute left-6 top-1/2 -translate-y-1/2 hidden sm:flex flex-col items-center gap-3 z-20">
            <span class="h-10 w-px bg-white/30"></span>
            <span class="ed-mono text-[8px] uppercase tracking-[0.34em] text-white/55 [writing-mode:vertical-rl] rotate-180">
                EDITION {{ $tahunAcara }} &middot; MONOCHROME ARCHIVE
            </span>
            <span class="h-10 w-px bg-white/30"></span>
        </div>

        @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'halus', 'konteks' => 'sampul'])

        {{-- 1. MASTHEAD ATAS: TELEMETRI KAMERA + JUDUL MAJALAH VOGUE --}}
        <header class="relative z-20 px-7 pt-7 sm:pt-8 space-y-3">
            <div class="ed-mono flex items-center justify-between text-[9px] uppercase tracking-[0.22em] text-white/75 border-b border-white/25 pb-2.5">
                <span class="inline-flex items-center gap-1.5">
                    <span class="inline-block h-1.5 w-1.5 bg-white animate-pulse"></span>
                    <span>ISSUE NO. 01</span>
                </span>
                <span>35MM &middot; ISO 100</span>
                <span>{{ $tahunAcara }}</span>
            </div>

            @if ($pakaiFotoSampul)
                <div class="text-left space-y-1 pt-0.5">
                    <p class="ed-mono text-[9px] uppercase tracking-[0.34em] text-white/70">The Editorial Invitation</p>
                    <h1 class="ed-serif text-[2.35rem] sm:text-[2.85rem] uppercase tracking-[0.05em] leading-[0.98] text-white drop-shadow">
                        {{ $undangan->nama_panggilan_pria }}
                        <span class="ed-mono text-base sm:text-lg align-middle text-white/60 mx-1">/</span>
                        {{ $undangan->nama_panggilan_wanita }}
                    </h1>
                    <p class="ed-mono text-[9.5px] uppercase tracking-[0.26em] text-white/75 pt-1">
                        {{ $tanggalLengkap }}
                    </p>
                </div>
            @endif
        </header>

        {{-- 2. TENGAH: PLAKAT ARSITEKTURAL (KHUSUS MODE TANPA FOTO) ATAU RUANG POTRET BERSIH --}}
        @if (! $pakaiFotoSampul)
            <div class="relative z-20 px-7 my-auto">
                <div class="kartu-3d bg-[#FAF9F6] text-[#18181B] border border-[#18181B] p-2 shadow-[8px_8px_0_0_rgba(255,255,255,0.22)]">
                    <div class="border border-[#18181B]/25 px-6 py-7 text-center space-y-4">
                        <div class="ed-mono flex items-center justify-between text-[8.5px] uppercase tracking-[0.24em] text-[#52525B] border-b border-[#18181B]/20 pb-2">
                            <span>COLLECTOR ISSUE</span>
                            <span>MONOGRAM</span>
                        </div>
                        <p class="ed-mono text-[9.5px] uppercase tracking-[0.32em] text-[#52525B]">The Editorial Invitation</p>
                        <h1 class="ed-serif text-4xl sm:text-[2.7rem] uppercase tracking-[0.06em] leading-[1.03] text-[#18181B]">
                            <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
                            <span class="my-1 flex items-center justify-center gap-3">
                                <span class="h-px w-8 bg-[#18181B]/35"></span>
                                <span class="ed-mono text-sm text-[#52525B]">&amp;</span>
                                <span class="h-px w-8 bg-[#18181B]/35"></span>
                            </span>
                            <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
                        </h1>
                        <p class="ed-mono text-[10px] uppercase tracking-[0.22em] text-[#52525B]">
                            {{ $tanggalLengkap }}
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="flex-1 min-h-0 flex items-center justify-center pointer-events-none" aria-hidden="true">
                {{-- Crosshair Fokus Tengah Halus --}}
                <div class="relative w-12 h-12 opacity-30">
                    <span class="absolute left-1/2 top-0 bottom-0 w-px bg-white/70"></span>
                    <span class="absolute top-1/2 left-0 right-0 h-px bg-white/70"></span>
                </div>
            </div>
        @endif

        {{-- 3. BAWAH: KARTU AKSES TAMU FRONT-ROW & TOMBOL SHUTTER --}}
        <div class="relative z-20 px-7 pb-8 sm:pb-9 space-y-3">
            <div class="bg-[#FAF9F6]/96 backdrop-blur-md text-[#18181B] border border-white p-4 shadow-2xl">
                <div class="ed-mono flex items-center justify-between text-[8.5px] uppercase tracking-[0.24em] text-[#52525B] border-b border-[#18181B]/15 pb-2">
                    <span>FRONT ROW PASS</span>
                    <span>VIP GUEST</span>
                </div>

                <div class="pt-2.5 pb-3 text-left flex items-end justify-between gap-3">
                    <div class="min-w-0">
                        <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
                        <p class="ed-mono text-[8.5px] uppercase tracking-[0.22em] text-[#52525B]">
                            Kepada Yth. Bapak/Ibu/Saudara/i
                        </p>
                        <p class="ed-serif text-xl sm:text-2xl text-[#18181B] leading-snug truncate mt-0.5">
                            {{ $namaTamu }}
                        </p>
                    </div>
                    {{-- Barcode Vertikal Mini --}}
                    <div aria-hidden="true" class="shrink-0 flex items-end gap-[2px] h-7 opacity-75">
                        <span class="w-[2px] h-full bg-[#18181B]"></span>
                        <span class="w-px h-5 bg-[#18181B]"></span>
                        <span class="w-[3px] h-full bg-[#18181B]"></span>
                        <span class="w-px h-6 bg-[#18181B]"></span>
                        <span class="w-[2px] h-4 bg-[#18181B]"></span>
                        <span class="w-px h-full bg-[#18181B]"></span>
                        <span class="w-[2px] h-6 bg-[#18181B]"></span>
                    </div>
                </div>

                <button
                    type="button"
                    @click="bukaUndangan()"
                    class="ed-btn-invert w-full inline-flex items-center justify-between bg-[#18181B] text-[#FAF9F6] px-4 py-3 text-[11px] font-bold uppercase tracking-[0.26em] hover:bg-black active:scale-[0.99] transition cursor-pointer"
                >
                    <span class="inline-flex items-center gap-2">
                        <span class="inline-block h-2 w-2 border border-white/80 rounded-full"></span>
                        <span>Buka Undangan</span>
                    </span>
                    <span class="ed-mono text-xs">&rarr;</span>
                </button>
            </div>

            <p class="text-[9.5px] text-center italic text-white/65 leading-relaxed">
                Mohon maaf apabila ada kesalahan penulisan nama/gelar
            </p>
        </div>
    </div>
</section>
