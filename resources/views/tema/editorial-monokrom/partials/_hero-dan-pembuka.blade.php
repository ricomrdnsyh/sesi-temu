{{-- SEKSI 1: HERO EDITORIAL SPREAD (ZERO ROUNDED CORNERS) --}}
<section
    data-diorama-3d="{{ $tierAktif }}"
    class="relative min-h-[94dvh] p-3.5 flex items-stretch overflow-hidden bg-[#FAF9F6]"
>
    <div class="relative w-full min-h-[calc(94dvh-1.75rem)] rounded-none border border-[#18181B] overflow-hidden bg-[#111113]">
        <div class="relative w-full h-full flex flex-col justify-between diorama-kamera-3d">
            <div class="absolute inset-0 pointer-events-none">
                <img src="{{ $urlFotoLatar }}" alt="Editorial Monokrom" class="w-full h-full object-cover object-center grayscale">
                <div class="absolute inset-0 bg-gradient-to-b from-black/78 via-black/38 to-black/88"></div>
            </div>

            @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'halus', 'konteks' => 'utama'])

            <div
                class="relative z-20 flex-1 flex flex-col justify-between p-6 text-white"
                :class="undanganTerbuka ? 'ed-spread-masuk' : 'opacity-0'"
            >
                <div class="border-b border-white/25 pb-4 text-left space-y-2">
                    <div class="flex items-center justify-between text-[10px] uppercase tracking-[0.32em] text-white/75">
                        <span>Editorial Invitation</span>
                        <span>{{ $tanggalTitik }}</span>
                    </div>
                    <p class="text-[10px] uppercase tracking-[0.3em] text-white/70">We Are Getting Married!</p>
                    <h2 class="ed-serif text-4xl sm:text-5xl uppercase tracking-[0.06em] leading-[1.04] text-white">
                        {{ $undangan->nama_panggilan_pria }}
                        <span class="block text-2xl text-white/60 my-1">&amp;</span>
                        {{ $undangan->nama_panggilan_wanita }}
                    </h2>
                </div>

                <div class="flex items-center justify-between border-t border-white/25 pt-4 text-[10px] uppercase tracking-[0.28em] text-white/80">
                    <span>Issue 01</span>
                    <span class="ed-serif text-sm px-2.5 py-1 border border-white/40">{{ $undangan->inisialPria() }}&amp;{{ $undangan->inisialWanita() }}</span>
                    <span>{{ $hashtagPasangan }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- RUNWAY MARQUEE TICKER --}}
<div class="py-3 bg-[#18181B] border-y border-white/15 overflow-hidden">
    <div class="animasi-marquee flex items-center gap-6 text-[10px] font-semibold uppercase tracking-[0.34em] text-white/90">
        @for ($i = 0; $i < 4; $i++)
            <span>The Wedding Edition</span>
            <span>/</span>
            <span>{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</span>
            <span>/</span>
            <span>{{ $tanggalTitik }}</span>
            <span>/</span>
            <span>{{ $hashtagPasangan }}</span>
            <span>/</span>
        @endfor
    </div>
</div>

{{-- SEKSI 2: 00 / PRELUDE SPREAD (HITAM PEKAT + MONOGRAM + FOTO PEMBUKA GRAYSCALE) --}}
<section
    data-section-pembuka="editorial"
    class="relative bg-[#111113] text-[#FAF9F6] px-5 py-12 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-6">
        <div class="flex items-center justify-between text-[10px] uppercase tracking-[0.34em] text-white/60 border-b border-white/20 pb-3">
            <span>00 / Prelude</span>
            <span>{{ $tanggalTitik }}</span>
        </div>

        {{-- Monogram Bertemu --}}
        <div class="grid grid-cols-3 items-center max-w-[200px] mx-auto text-center">
            <span class="fx-slide-left ed-serif text-4xl sm:text-5xl text-white">{{ $undangan->inisialPria() }}</span>
            <span class="fx-scale-in text-2xl text-white/50">&amp;</span>
            <span class="fx-slide-right ed-serif text-4xl sm:text-5xl text-white">{{ $undangan->inisialWanita() }}</span>
        </div>

        @if ($urlFotoPembuka)
            <div class="fx-scale-in border border-white/30 p-1.5 bg-black">
                <img src="{{ $urlFotoPembuka }}" alt="Editorial Portrait {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}" class="w-full aspect-[4/3] object-cover object-center grayscale">
            </div>
        @endif

        @if ($undangan->kutipan_ayat)
            <blockquote class="fx-rise border-y border-white/20 py-6 text-left space-y-2">
                <span aria-hidden="true" class="block ed-serif text-4xl leading-none text-white/35">&ldquo;</span>
                <p class="italic text-xs sm:text-sm text-white/85 leading-relaxed">
                    {{ $undangan->kutipan_ayat }}
                </p>
            </blockquote>
        @endif
    </div>
</section>
