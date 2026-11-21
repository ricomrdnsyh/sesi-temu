{{-- SEKSI 1: HERO BOTANICAL SCRAPBOOK LINEN (BASIC SMOOTH DIORAMA) --}}
<section
    data-diorama-3d="basic"
    class="relative px-4 pt-5 pb-8 overflow-hidden bg-[#FDFBF7]"
>
    <div class="relative h-[32rem] sm:h-[35rem] rounded-t-[10.5rem] rounded-b-3xl border-2 border-[#BFA15F]/45 overflow-hidden shadow-xl bg-[#3E5349]">
        <div class="absolute inset-0 pointer-events-none">
            <img
                src="{{ $urlFotoLatar }}"
                alt="Rustic Floral"
                class="w-full h-full object-cover object-center"
                :class="undanganTerbuka ? 'diorama-latar-basic' : ''"
            >
            <div class="absolute inset-0 bg-gradient-to-b from-[#FDFBF7]/86 via-[#FDFBF7]/38 to-[#394D44]/82"></div>
        </div>

        {{-- Karangan Daun Botani & Terakota SVG --}}
        <svg aria-hidden="true" viewBox="0 0 360 480" class="pointer-events-none absolute inset-2 w-[calc(100%-1rem)] h-[calc(100%-1rem)] z-10 opacity-70">
            <path d="M24 464 V178 C24 88 94 26 180 18 C266 26 336 88 336 178 V464 Z" fill="none" stroke="#BFA15F" stroke-width="1.6"/>
            <circle cx="180" cy="18" r="5" fill="#B86B4B"/>
            <circle cx="164" cy="21" r="3" fill="#4B6358"/>
            <circle cx="196" cy="21" r="3" fill="#4B6358"/>
        </svg>

        <img src="{{ $asetRustic['sudut'] }}" alt="" class="pointer-events-none absolute -top-2 -left-2 w-20 opacity-85 z-20 animasi-ayun-3d">
        <img src="{{ $asetRustic['sudut'] }}" alt="" class="pointer-events-none absolute -top-2 -right-2 w-20 opacity-85 z-20 animasi-ayun-3d-balik">

        @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'kelopak', 'konteks' => 'utama'])

        <div class="relative z-20 h-full flex flex-col justify-between px-7 pt-16 pb-8 text-center">
            <div class="space-y-2 text-[#1F2937]">
                <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#4B6358]">Undangan Pernikahan</p>
                <p class="text-[10px] uppercase tracking-[0.28em] text-[#B86B4B]">We Are Getting Married!</p>
                <h2 class="pt-1 font-serif text-4xl sm:text-[2.75rem] font-bold leading-[1.08] text-[#1F2937]">
                    {{ $undangan->nama_panggilan_pria }}
                    <span class="block font-kaligrafi text-3xl font-normal text-[#B86B4B] my-0.5">&amp;</span>
                    {{ $undangan->nama_panggilan_wanita }}
                </h2>
            </div>

            <div class="space-y-1.5 text-[#FDFBF7]">
                <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#F3E5AB]">{{ $tanggalTitik }}</p>
                <p class="text-[11px] tracking-[0.2em] text-white/90">{{ $hashtagPasangan }}</p>
            </div>
        </div>
    </div>
</section>

{{-- SEKSI 2: SCRAPBOOK SNAPSHOT WASHI-TAPE + MONOGRAM + AYAT --}}
<section
    data-aos="fade-up"
    data-section-pembuka="klasik"
    class="relative bg-[#3E5349] text-[#FDFBF7] px-5 py-12 overflow-hidden"
>
    <div class="max-w-md mx-auto text-center space-y-6">
        <div class="grid grid-cols-3 items-center max-w-[200px] mx-auto">
            <span class="fx-slide-left font-serif text-4xl sm:text-5xl font-bold text-[#E5D5C0]">{{ $undangan->inisialPria() }}</span>
            <span class="fx-scale-in font-kaligrafi text-3xl text-[#BFA15F]">&amp;</span>
            <span class="fx-slide-right font-serif text-4xl sm:text-5xl font-bold text-[#E5D5C0]">{{ $undangan->inisialWanita() }}</span>
        </div>

        @if ($urlFotoPembuka)
            <div class="fx-scale-in relative mx-auto w-56 sm:w-64 bg-white p-2 pb-5 shadow-2xl -rotate-1">
                <span aria-hidden="true" class="pointer-events-none absolute -top-2.5 left-1/2 -translate-x-1/2 w-20 h-5 bg-[#E5D5C0]/90 rotate-1 shadow-xs"></span>
                <img src="{{ $urlFotoPembuka }}" alt="Foto Pembuka {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}" class="w-full aspect-[4/5] object-cover object-top">
                <p class="mt-2 font-kaligrafi text-lg text-[#4B6358]">{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</p>
            </div>
        @endif

        @if ($undangan->kutipan_ayat)
            <blockquote class="fx-rise rounded-2xl bg-[#FDFBF7] text-[#1F2937] border border-[#BFA15F]/45 px-6 py-6 shadow-md kartu-3d">
                <p class="italic text-xs sm:text-sm text-[#1F2937]/85 leading-relaxed">
                    &ldquo;{{ $undangan->kutipan_ayat }}&rdquo;
                </p>
            </blockquote>
        @endif
    </div>
</section>
