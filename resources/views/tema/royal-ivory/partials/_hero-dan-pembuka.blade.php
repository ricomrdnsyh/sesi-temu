{{-- SEKSI 1: HERO DIORAMA KATEDRAL GADING & SEGEL LILIN --}}
<section
    data-diorama-3d="{{ $tierAktif }}"
    class="relative min-h-[96dvh] px-3.5 py-4 flex items-stretch overflow-hidden bg-[#EFE7DA]"
>
    <div class="relative w-full min-h-[calc(96dvh-2rem)] rounded-t-[10.5rem] rounded-b-3xl border-2 border-[#9E7B4F]/60 ring-4 ring-[#9E7B4F]/15 overflow-hidden shadow-2xl bg-[#3B2E25]">
        <div class="relative w-full h-full flex flex-col justify-between diorama-kamera-3d">
            <div class="absolute inset-0 pointer-events-none">
                <img src="{{ $urlFotoLatar }}" alt="Royal Ivory" class="w-full h-full object-cover object-center">
                <div class="absolute inset-0 bg-gradient-to-b from-[#FAF6EE]/86 via-[#FAF6EE]/30 to-[#3B2E25]/82"></div>
            </div>

            {{-- Lengkungan Rose-Window Katedral SVG --}}
            <svg
                aria-hidden="true"
                viewBox="0 0 360 520"
                class="pointer-events-none absolute inset-2 w-[calc(100%-1rem)] h-[calc(100%-1rem)] z-10 opacity-70"
                :class="undanganTerbuka ? 'royal-arch-masuk' : 'opacity-0'"
            >
                <path d="M24 504 V190 C24 85 95 22 180 14 C265 22 336 85 336 190 V504 Z" fill="none" stroke="#9E7B4F" stroke-width="2"/>
                <path d="M36 492 V194 C36 98 102 38 180 30 C258 38 324 98 324 194 V492 Z" fill="none" stroke="#9E7B4F" stroke-width="1" stroke-dasharray="5 4"/>
                <circle cx="180" cy="84" r="24" fill="none" stroke="#9E7B4F" stroke-width="1.2"/>
                <circle cx="180" cy="84" r="14" fill="none" stroke="#9E7B4F" stroke-width="0.9" stroke-dasharray="3 3"/>
            </svg>

            @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'katedral-cahaya', 'konteks' => 'utama'])

            <div class="relative z-20 flex-1 flex flex-col justify-between px-9 pt-24 pb-10 text-center">
                <div class="space-y-2 text-[#3B2E25]">
                    <img src="{{ $asetRoyal['katedral'] }}" alt="" class="w-12 mx-auto opacity-95 animasi-ayun-3d">
                    <p class="text-[10px] font-bold uppercase tracking-[0.36em] text-[#7B603F]">
                        The Royal Wedding
                    </p>
                    <p class="text-[10px] uppercase tracking-[0.28em] text-[#3B2E25]/75">
                        We Are Getting Married!
                    </p>
                    <h2 class="pt-1 font-serif text-4xl sm:text-[2.8rem] font-bold leading-[1.08] text-[#3B2E25]">
                        {{ $undangan->nama_panggilan_pria }}
                        <span class="block font-kaligrafi text-3xl sm:text-4xl font-normal text-[#9E7B4F] my-0.5">&amp;</span>
                        {{ $undangan->nama_panggilan_wanita }}
                    </h2>
                    <p class="pt-1 text-xs font-bold uppercase tracking-[0.3em] text-[#58432B]">
                        {{ $tanggalTitik }}
                    </p>
                </div>

                {{-- Segel Lilin Emas-Perunggu di Bawah --}}
                <div class="pt-6 space-y-3 text-[#FAF6EE]">
                    <div class="mx-auto w-14 h-14 rounded-full bg-[#9E7B4F] border-2 border-[#E5C99B] shadow-xl flex items-center justify-center animasi-segel">
                        <span class="font-serif text-xs font-bold tracking-widest">{{ $undangan->inisialPria() }}&amp;{{ $undangan->inisialWanita() }}</span>
                    </div>
                    <p class="text-[11px] font-medium tracking-[0.22em] text-[#FAF6EE]/95">{{ $hashtagPasangan }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- MARQUEE LETTERPRESS --}}
<div class="py-2.5 bg-[#58432B] border-y border-[#E5C99B]/40 overflow-hidden">
    <div class="animasi-marquee flex items-center gap-6 text-[10px] font-semibold uppercase tracking-[0.34em] text-[#E5C99B]">
        @for ($i = 0; $i < 4; $i++)
            <span>The Royal Wedding</span>
            <span>&#10022;</span>
            <span>{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</span>
            <span>&#10022;</span>
            <span>{{ $tanggalTitik }}</span>
            <span>&#10022;</span>
            <span>{{ $hashtagPasangan }}</span>
            <span>&#10022;</span>
        @endfor
    </div>
</div>

{{-- SEKSI 2: PRELUDE KARTU SURAT GANDA + FOTO PEMBUKA KATEDRAL --}}
<section
    data-section-pembuka="katedral"
    class="relative bg-[#EFE7DA] px-4 py-12 overflow-hidden"
>
    <div class="max-w-md mx-auto rounded-3xl bg-[#FBF8F3] border border-[#9E7B4F]/50 p-2 shadow-xl">
        <div class="rounded-[1.2rem] border border-dashed border-[#9E7B4F]/45 px-5 py-8 text-center space-y-6">
            <div class="grid grid-cols-3 items-center max-w-[200px] mx-auto">
                <span class="fx-slide-left font-serif text-4xl sm:text-5xl font-bold text-[#7B603F]">
                    {{ $undangan->inisialPria() }}
                </span>
                <span class="fx-scale-in font-kaligrafi text-3xl text-[#9E7B4F]">&amp;</span>
                <span class="fx-slide-right font-serif text-4xl sm:text-5xl font-bold text-[#7B603F]">
                    {{ $undangan->inisialWanita() }}
                </span>
            </div>

            @if ($urlFotoPembuka)
                <div class="fx-scale-in mx-auto w-56 sm:w-64 p-1.5 rounded-t-[9rem] rounded-b-2xl border-2 border-[#9E7B4F]/55 bg-white shadow-lg">
                    <div class="overflow-hidden rounded-t-[8.5rem] rounded-b-xl aspect-[4/5]">
                        <img src="{{ $urlFotoPembuka }}" alt="Foto Pembuka {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}" class="w-full h-full object-cover object-top">
                    </div>
                </div>
            @endif

            @if ($undangan->kutipan_ayat)
                <blockquote class="fx-rise border-t border-double border-[#9E7B4F]/45 pt-5">
                    <p class="italic text-xs sm:text-sm text-[#3B2E25]/85 leading-relaxed">
                        &ldquo;{{ $undangan->kutipan_ayat }}&rdquo;
                    </p>
                </blockquote>
            @endif
        </div>
    </div>
</section>
