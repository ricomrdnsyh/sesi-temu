{{-- SEKSI 1: HERO EDITORIAL EXHIBITION SPREAD (DARKROOM FOCUS + MASKED KINETIC TYPOGRAPHY) --}}
<section
    id="ed-bab-01"
    data-diorama-3d="{{ $tierAktif }}"
    data-autoscroll-delay="4800"
    class="relative min-h-[95dvh] p-3 sm:p-3.5 flex items-stretch overflow-x-clip bg-[#FAF9F6]"
>
    <div class="relative w-full min-h-[calc(95dvh-1.75rem)] rounded-none border border-[#18181B] overflow-hidden bg-[#0E0E11] shadow-[6px_6px_0_0_#18181B]">
        <div class="relative w-full h-full flex flex-col justify-between diorama-kamera-3d">
            {{-- Latar Foto Arsitektural Darkroom Pull-Focus + Toggle Filter B&W / Natural --}}
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                <img
                    src="{{ $urlFotoLatar }}"
                    alt="Editorial Monokrom"
                    :class="[
                        undanganTerbuka ? 'ed-foto-darkroom-aktif' : 'scale-110 grayscale',
                        modeWarnaEditorial ? '!grayscale-0 contrast-[1.03]' : 'grayscale contrast-[1.1]'
                    ]"
                    class="w-full h-full object-cover object-center transition-all duration-700"
                >
                <div
                    aria-hidden="true"
                    class="absolute inset-0"
                    style="background: linear-gradient(180deg, rgba(12,12,15,0.82) 0%, rgba(12,12,15,0.30) 36%, rgba(12,12,15,0.44) 64%, rgba(10,10,13,0.94) 100%);"
                ></div>
                <div aria-hidden="true" class="absolute inset-0 ed-film-grain opacity-40"></div>
            </div>

            {{-- Kilat Garis Horizon Shutter Saat Sampul Membuka --}}
            <div
                aria-hidden="true"
                :class="undanganTerbuka ? 'ed-kilat-shutter-aktif' : 'opacity-0'"
                class="pointer-events-none absolute inset-x-0 top-1/2 -translate-y-1/2 h-[2px] bg-white shadow-[0_0_24px_rgba(255,255,255,0.95)] z-30"
            ></div>

            {{-- Grid Arsitektural Tipis & Siku Pembidik --}}
            <div aria-hidden="true" class="pointer-events-none absolute inset-3.5 border border-white/18 z-10">
                <span class="absolute -top-px -left-px h-3.5 w-3.5 border-t-2 border-l-2 border-white/85"></span>
                <span class="absolute -top-px -right-px h-3.5 w-3.5 border-t-2 border-r-2 border-white/85"></span>
                <span class="absolute -bottom-px -left-px h-3.5 w-3.5 border-b-2 border-l-2 border-white/85"></span>
                <span class="absolute -bottom-px -right-px h-3.5 w-3.5 border-b-2 border-r-2 border-white/85"></span>
            </div>

            @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'halus', 'konteks' => 'utama'])

            {{-- Konten Hero Kinetik --}}
            <div class="relative z-20 flex-1 flex flex-col justify-between p-5 sm:p-6 text-white">
                {{-- Baris Atas: Telemetri + Saklar Interaktif Film 35mm B&W / Natural --}}
                <div class="space-y-3">
                    <div class="flex items-center justify-between gap-2 pb-3 border-b border-white/25"
                        :class="undanganTerbuka ? 'ed-garis-hero-aktif' : 'opacity-0'">
                        <span class="ed-mono text-[9px] uppercase tracking-[0.24em] text-white/80">
                            NO. 01 &middot; {{ $tanggalTitik }}
                        </span>

                        <button
                            type="button"
                            @click="modeWarnaEditorial = !modeWarnaEditorial"
                            class="ed-mono inline-flex items-center gap-1.5 border border-white/45 bg-black/45 backdrop-blur-xs px-2.5 py-1 text-[8.5px] font-bold uppercase tracking-[0.18em] text-white hover:bg-white hover:text-[#111113] transition cursor-pointer"
                            title="Ubah mode warna film"
                        >
                            <span class="inline-block h-1.5 w-1.5 rounded-full" :class="modeWarnaEditorial ? 'bg-amber-300' : 'bg-white'"></span>
                            <span x-text="modeWarnaEditorial ? 'TONE: NATURAL' : 'FILM: 35MM B&W'">FILM: 35MM B&amp;W</span>
                        </button>
                    </div>

                    <div class="pt-1 text-left">
                        <span class="ed-mask-wrap">
                            <span
                                :class="undanganTerbuka ? 'ed-mask-baris-1' : 'opacity-0'"
                                class="block ed-mono text-[9.5px] uppercase tracking-[0.3em] text-white/75"
                            >
                                We Are Getting Married!
                            </span>
                        </span>
                    </div>
                </div>

                {{-- Pusat Bawah: Masthead Nama Mempelai Bertingkat Masked Line-Reveal --}}
                <div class="my-auto py-6 text-left space-y-2">
                    <h2 class="ed-serif uppercase tracking-[0.04em] leading-[0.94] text-white">
                        <span class="ed-mask-wrap">
                            <span
                                :class="undanganTerbuka ? 'ed-mask-baris-2' : 'opacity-0'"
                                class="block text-[2.85rem] sm:text-[3.45rem] drop-shadow-[0_6px_24px_rgba(0,0,0,0.65)]"
                            >
                                {{ $undangan->nama_panggilan_pria }}
                            </span>
                        </span>

                        <span class="ed-mask-wrap my-1.5">
                            <span
                                :class="undanganTerbuka ? 'ed-mask-baris-3' : 'opacity-0'"
                                class="flex items-center gap-3"
                            >
                                <span class="h-px w-10 bg-white/55"></span>
                                <span class="ed-mono text-xs sm:text-sm tracking-[0.28em] text-white/80">&amp; / COLLECTOR EDITION</span>
                            </span>
                        </span>

                        <span class="ed-mask-wrap">
                            <span
                                :class="undanganTerbuka ? 'ed-mask-baris-4' : 'opacity-0'"
                                class="block text-[2.85rem] sm:text-[3.45rem] pl-5 sm:pl-8 drop-shadow-[0_6px_24px_rgba(0,0,0,0.65)]"
                            >
                                {{ $undangan->nama_panggilan_wanita }}
                            </span>
                        </span>
                    </h2>
                </div>

                {{-- Footer Hero: Segel Kompas Berputar + Monogram + Indikator Scroll --}}
                <div
                    :class="undanganTerbuka ? 'ed-garis-hero-aktif' : 'opacity-0'"
                    class="flex items-end justify-between gap-3 border-t border-white/25 pt-3.5"
                >
                    <div class="space-y-0.5 text-left">
                        <p class="ed-mono text-[8.5px] uppercase tracking-[0.26em] text-white/60">EXHIBITION DATE</p>
                        <p class="ed-mono text-[10px] font-bold uppercase tracking-[0.18em] text-white">{{ $tanggalLengkap }}</p>
                        <p class="ed-mono text-[8.5px] uppercase tracking-[0.2em] text-white/65">{{ $hashtagPasangan }}</p>
                    </div>

                    <div class="relative h-14 w-14 shrink-0 flex items-center justify-center">
                        <svg aria-hidden="true" viewBox="0 0 100 100" class="ed-putar-lambat absolute inset-0 w-full h-full text-white/75">
                            <defs>
                                <path id="ed-ring-hero" d="M 50, 50 m -37, 0 a 37,37 0 1,1 74,0 a 37,37 0 1,1 -74,0" />
                            </defs>
                            <text font-size="8.4" fill="currentColor" letter-spacing="2.6" class="ed-mono uppercase">
                                <textPath href="#ed-ring-hero">EDITORIAL &bull; MONOKROM &bull; {{ $tahunAcara }} &bull;</textPath>
                            </text>
                        </svg>
                        <span class="ed-serif text-xs tracking-widest text-white border border-white/40 px-1.5 py-0.5 bg-black/50">
                            {{ $undangan->inisialPria() }}{{ $undangan->inisialWanita() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- DUAL COUNTER-DIRECTIONAL KINETIC MARQUEE TICKER --}}
<div class="bg-[#111114] border-y border-[#18181B] overflow-hidden select-none">
    {{-- Pita 1: Bergerak ke Kiri (Solid Monospace) --}}
    <div class="py-2.5 border-b border-white/12 overflow-hidden">
        <div class="animasi-marquee flex ed-mono items-center gap-6 text-[9.5px] font-bold uppercase tracking-[0.32em] text-[#FAF9F6]">
            @for ($i = 0; $i < 4; $i++)
                <span>The Wedding Edition</span>
                <span class="inline-block h-1.5 w-1.5 bg-white/70"></span>
                <span>{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</span>
                <span class="inline-block h-1.5 w-1.5 bg-white/70"></span>
                <span>{{ $tanggalTitik }}</span>
                <span class="inline-block h-1.5 w-1.5 bg-white/70"></span>
                <span>{{ $hashtagPasangan }}</span>
                <span class="inline-block h-1.5 w-1.5 bg-white/70"></span>
            @endfor
        </div>
    </div>

    {{-- Pita 2: Bergerak Berlawanan ke Kanan (Hollow Stroke Serif) --}}
    <div aria-hidden="true" class="py-2 bg-[#0B0B0D] overflow-hidden">
        <div class="ed-marquee-kanan ed-serif ed-teks-garis flex items-center gap-8 text-xl sm:text-2xl uppercase tracking-[0.16em]">
            @for ($i = 0; $i < 4; $i++)
                <span>Atelier Monochrome</span>
                <span>&mdash;</span>
                <span>{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</span>
                <span>&mdash;</span>
                <span>Issue {{ $tahunAcara }}</span>
                <span>&mdash;</span>
            @endfor
        </div>
    </div>
</div>

{{-- SEKSI 2: 00 / PRELUDE SPREAD (SWISS GRID MONOGRAM + INK CURTAIN PHOTO WIPE) --}}
<section
    data-section-pembuka="editorial"
    class="relative bg-[#111113] text-[#FAF9F6] px-5 pb-14 pt-4 overflow-x-clip"
>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 ed-film-grain opacity-30"></div>

    <div class="relative z-10 max-w-md mx-auto space-y-7">
        <div
            data-masthead-lengket
            class="sticky {{ $tampilBarDemo ? 'top-14' : 'top-0' }} z-30 -mx-5 px-5 py-3 bg-[#111113]/95 backdrop-blur-md ed-mono flex items-center justify-between text-[9.5px] uppercase tracking-[0.3em] text-white/70 border-b border-white/20"
        >
            <span>00 / PRELUDE</span>
            <span>ARCHIVE &middot; {{ $tanggalTitik }}</span>
        </div>

        {{-- Monogram Konvergen Arsitektural --}}
        <div class="grid grid-cols-3 items-center max-w-[230px] mx-auto text-center">
            <div data-gsap="kiri" class="fx-slide-left border border-white/30 bg-white/[0.03] py-3">
                <span class="ed-serif text-4xl sm:text-5xl text-white leading-none">{{ $undangan->inisialPria() }}</span>
            </div>
            <div data-gsap="mekar" data-gsap-delay="0.06" class="flex flex-col items-center justify-center gap-1">
                <span class="h-4 w-px bg-white/25"></span>
                <span class="ed-mono text-xs tracking-widest text-white/65">&amp;</span>
                <span class="h-4 w-px bg-white/25"></span>
            </div>
            <div data-gsap="kanan" data-gsap-delay="0.08" class="fx-slide-right border border-white/30 bg-white/[0.03] py-3">
                <span class="ed-serif text-4xl sm:text-5xl text-white leading-none">{{ $undangan->inisialWanita() }}</span>
            </div>
        </div>

        @if ($urlFotoPembuka)
            <div data-gsap="potret" data-gsap-delay="0.1" class="space-y-2">
                <div class="ed-mono flex items-center justify-between text-[8.5px] uppercase tracking-[0.24em] text-white/55">
                    <span>FRAME 00A &#9656;</span>
                    <span>LEICA M-SYSTEM</span>
                </div>
                <div class="ed-tirai-foto border border-white/35 p-1.5 bg-black">
                    <img
                        src="{{ $urlFotoPembuka }}"
                        alt="Editorial Portrait {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                        :class="modeWarnaEditorial ? 'grayscale-0' : 'grayscale hover:grayscale-0'"
                        class="w-full aspect-[4/3] object-cover object-center contrast-[1.06] transition duration-700"
                    >
                </div>
            </div>
        @endif

        @if ($undangan->kutipan_ayat)
            <blockquote data-gsap="naik" data-gsap-delay="0.08" class="relative border-l-2 border-white/75 pl-5 py-2 text-left space-y-2 bg-white/[0.02]">
                <span aria-hidden="true" class="ed-mono block text-[9px] uppercase tracking-[0.28em] text-white/50">EDITORIAL NOTE</span>
                <p class="ed-serif italic text-sm sm:text-[15px] text-white/90 leading-relaxed">
                    &ldquo;{{ $undangan->kutipan_ayat }}&rdquo;
                </p>
            </blockquote>
        @endif
    </div>
</section>
