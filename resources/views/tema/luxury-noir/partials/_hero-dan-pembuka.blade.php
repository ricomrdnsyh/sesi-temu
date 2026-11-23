{{-- SEKSI 1: HERO DIORAMA ART DECO BALLROOM & CRYSTAL CHANDELIER --}}
<section
    data-diorama-3d="{{ $tierAktif }}"
    class="relative min-h-[96dvh] px-3.5 py-4 flex items-stretch overflow-hidden bg-[#09090D]"
>
    <div class="relative w-full min-h-[calc(96dvh-2rem)] rounded-2xl border border-[#D4AF37]/60 overflow-hidden shadow-2xl bg-[#0B0B0F]">
        <div class="relative w-full h-full flex flex-col justify-between diorama-kamera-3d">
            {{-- Z-0: Latar Ballroom --}}
            <div class="absolute inset-0 pointer-events-none">
                <img src="{{ $urlFotoLatar }}" alt="Luxury Noir Ballroom" class="w-full h-full object-cover object-center">
                <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/45 to-black/92"></div>
            </div>

            {{-- Z-1: Lampu Gantung Kristal Art Deco (Inline SVG) --}}
            <svg
                aria-hidden="true"
                viewBox="0 0 280 96"
                class="pointer-events-none absolute top-0 left-1/2 -translate-x-1/2 w-56 z-20"
                :class="undanganTerbuka ? 'noir-chandelier-turun' : 'opacity-0'"
            >
                <line x1="140" y1="0" x2="140" y2="26" stroke="#D4AF37" stroke-width="2"/>
                <path d="M88 30 Q140 16 192 30" fill="none" stroke="#F3E5AB" stroke-width="1.6"/>
                <path d="M58 46 Q140 28 222 46" fill="none" stroke="#D4AF37" stroke-width="1.6"/>
                <path d="M98 64 Q140 50 182 64" fill="none" stroke="#F3E5AB" stroke-width="1.3"/>
                <g fill="#F3E5AB" opacity="0.9">
                    <polygon points="140,22 145,34 140,46 135,34"/>
                    <polygon points="94,34 97,46 94,54 91,46"/>
                    <polygon points="186,34 189,46 186,54 183,46"/>
                    <polygon points="66,48 69,60 66,68 63,60"/>
                    <polygon points="214,48 217,60 214,68 211,60"/>
                    <polygon points="116,58 119,70 116,78 113,70"/>
                    <polygon points="164,58 167,70 164,78 161,70"/>
                    <polygon points="140,66 144,82 140,94 136,82"/>
                </g>
            </svg>

            {{-- Z-2: Bingkai Art Deco Emas-Obsidian --}}
            <div
                class="pointer-events-none absolute inset-x-1.5 top-2 bottom-2 flex items-center justify-center z-10"
                :class="undanganTerbuka ? 'noir-deco-masuk' : 'opacity-0'"
            >
                <img src="{{ $asetNoir['bingkai'] }}" alt="" class="w-full h-full object-contain opacity-95">
            </div>

            {{-- Debu Emas Naik --}}
            @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'debu-emas', 'konteks' => 'utama'])

            {{-- Z-3: Tipografi Tengah Art Deco (Tepat di Ruang Hitam Tengah di Bawah Kipas Sunburst Atas) --}}
            <div class="relative z-20 flex-1 flex flex-col justify-between px-11 pt-36 pb-10 text-center text-[#F5EFE6]">
                <div class="my-auto space-y-2.5">
                    <img src="{{ $asetNoir['emas'] }}" alt="" class="w-11 mx-auto opacity-95 animasi-ayun-3d">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.36em] text-[#D4AF37]">
                        With Joy &amp; Honor
                    </p>
                    <p class="text-[10px] uppercase tracking-[0.26em] text-white/80">
                        We Are Getting Married!
                    </p>
                    <h2 class="pt-1 noir-font-judul text-3xl sm:text-[2.45rem] font-bold tracking-wider leading-[1.12] text-white">
                        {{ $undangan->nama_panggilan_pria }}
                        <span class="block font-kaligrafi text-3xl font-normal text-[#D4AF37] my-0.5">&amp;</span>
                        {{ $undangan->nama_panggilan_wanita }}
                    </h2>
                    <p class="pt-1 text-xs font-semibold uppercase tracking-[0.32em] text-[#F3E5AB]">
                        {{ $tanggalTitik }}
                    </p>
                    <p class="text-[10px] tracking-[0.18em] text-[#D4AF37]">
                        {{ $hashtagPasangan }}
                    </p>
                </div>

                {{-- Medallion Monogram Orbit + Indikator Gulir --}}
                <div class="pt-6 space-y-3">
                    <div aria-hidden="true" class="mx-auto w-5 h-8 rounded-full border border-[#D4AF37]/70 flex justify-center pt-1.5">
                        <span class="w-1 h-1.5 rounded-full bg-[#F3E5AB] animasi-gulir-roda"></span>
                    </div>
                    <div class="mx-auto w-14 h-14 relative flex items-center justify-center">
                        <span class="absolute inset-0 rounded-full border border-dashed border-[#D4AF37]/70 animasi-orbit"></span>
                        <span class="absolute inset-1.5 rounded-full border border-[#F3E5AB]/60 animasi-orbit-balik"></span>
                        <span class="noir-font-judul text-xs font-bold text-[#F3E5AB]">{{ $undangan->inisialPria() }}&amp;{{ $undangan->inisialWanita() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- GALA MARQUEE TICKER --}}
<div class="py-2.5 bg-[#121118] border-y border-[#D4AF37]/45 overflow-hidden">
    <div class="animasi-marquee flex items-center gap-6 text-[10px] font-semibold uppercase tracking-[0.34em] text-[#F3E5AB]">
        @for ($i = 0; $i < 4; $i++)
            <span>The Grand Celebration</span>
            <span>&#9670;</span>
            <span>{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</span>
            <span>&#9670;</span>
            <span>{{ $tanggalTitik }}</span>
            <span>&#9670;</span>
            <span>{{ $hashtagPasangan }}</span>
            <span>&#9670;</span>
        @endfor
    </div>
</div>

{{-- SEKSI 2: PRELUDE GALA & LANDSCAPE SPOTLIGHT FOTO PEMBUKA --}}
<section
    data-section-pembuka="artdeco"
    class="relative bg-[#0B0B0F] px-4 py-12 overflow-hidden"
>
    <div class="relative max-w-md mx-auto rounded-xl bg-[#16151B] border border-[#D4AF37]/55 p-6 text-center shadow-2xl space-y-6 efek-shimmer-kartu">
        <span aria-hidden="true" class="pointer-events-none absolute top-2 left-2 h-4 w-4 border-t border-l border-[#D4AF37]"></span>
        <span aria-hidden="true" class="pointer-events-none absolute top-2 right-2 h-4 w-4 border-t border-r border-[#D4AF37]"></span>
        <span aria-hidden="true" class="pointer-events-none absolute bottom-2 left-2 h-4 w-4 border-b border-l border-[#D4AF37]"></span>
        <span aria-hidden="true" class="pointer-events-none absolute bottom-2 right-2 h-4 w-4 border-b border-r border-[#D4AF37]"></span>

        {{-- Monogram Bertemu --}}
        <div class="grid grid-cols-3 items-center max-w-[200px] mx-auto">
            <span data-gsap="kiri" class="fx-slide-left noir-font-judul text-4xl font-bold text-[#F3E5AB]">
                {{ $undangan->inisialPria() }}
            </span>
            <span data-gsap="mekar" data-gsap-delay="0.06" class="font-kaligrafi text-3xl text-[#D4AF37]">&amp;</span>
            <span data-gsap="kanan" data-gsap-delay="0.08" class="fx-slide-right noir-font-judul text-4xl font-bold text-[#F3E5AB]">
                {{ $undangan->inisialWanita() }}
            </span>
        </div>

        @if ($urlFotoPembuka)
            <div data-gsap="potret" data-gsap-delay="0.1" class="overflow-hidden rounded-lg border border-[#D4AF37]/60 bg-black p-1 shadow-xl">
                <img
                    src="{{ $urlFotoPembuka }}"
                    alt="Foto Pembuka {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                    class="w-full aspect-[16/10] object-cover object-center rounded-sm"
                >
            </div>
        @endif

        @if ($undangan->kutipan_ayat)
            <blockquote data-gsap="naik" data-gsap-delay="0.06" class="border-t border-[#D4AF37]/30 pt-4">
                <p class="italic text-xs sm:text-sm text-[#F5EFE6]/85 leading-relaxed">
                    &ldquo;{{ $undangan->kutipan_ayat }}&rdquo;
                </p>
            </blockquote>
        @endif
    </div>
</section>
