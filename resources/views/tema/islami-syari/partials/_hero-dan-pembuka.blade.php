{{-- SEKSI 1: HERO SANCTUARY EMERALD MIHRAB (BASIC SMOOTH DIORAMA) --}}
<section
    data-diorama-3d="basic"
    class="relative px-4 pt-5 pb-8 overflow-hidden bg-[#F4FAF6]"
>
    <div class="relative h-[32rem] sm:h-[35rem] rounded-t-[10.5rem] rounded-b-3xl border-2 border-[#184D47]/25 overflow-hidden shadow-xl bg-[#133D38]">
        <div class="absolute inset-0 pointer-events-none">
            <img
                src="{{ $urlFotoLatar }}"
                alt="Islami Syar'i"
                class="w-full h-full object-cover object-center"
                :class="undanganTerbuka ? 'diorama-latar-basic' : ''"
            >
            <div class="absolute inset-0 bg-gradient-to-b from-[#F4FAF6]/88 via-[#F4FAF6]/40 to-[#133D38]/85"></div>
        </div>

        {{-- Lengkungan Mihrab Minimalis SVG --}}
        <svg aria-hidden="true" viewBox="0 0 360 480" class="pointer-events-none absolute inset-2 w-[calc(100%-1rem)] h-[calc(100%-1rem)] z-10 opacity-65">
            <path d="M22 464 V178 C22 86 92 22 180 14 C268 22 338 86 338 178 V464 Z" fill="none" stroke="#BFA15F" stroke-width="1.8"/>
            <path d="M34 452 V182 C34 98 100 38 180 30 C260 38 326 98 326 182 V452 Z" fill="none" stroke="#184D47" stroke-width="0.9" opacity="0.5"/>
        </svg>

        @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'zaitun-kilau', 'konteks' => 'utama'])

        <div class="relative z-20 h-full flex flex-col justify-between px-7 pt-16 pb-8 text-center">
            <div class="space-y-2 text-[#184D47]">
                <img src="{{ $asetSyari['arabesque'] }}" alt="" class="w-11 mx-auto opacity-90 animasi-ayun-3d">
                <p class="text-base text-[#184D47]" style="font-family: 'Amiri', serif;">
                    بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                </p>
                <p class="text-[10px] font-bold uppercase tracking-[0.26em] text-[#9E7D40]">
                    Assalamu&rsquo;alaikum Warahmatullahi Wabarakatuh
                </p>
                <p class="text-[10px] uppercase tracking-[0.28em] text-[#184D47]/75">
                    We Are Getting Married!
                </p>
                <h2 class="pt-1 font-serif text-4xl sm:text-[2.7rem] font-bold leading-[1.08] text-[#184D47]">
                    {{ $undangan->nama_panggilan_pria }}
                    <span class="block font-kaligrafi text-3xl font-normal text-[#BFA15F] my-0.5">&amp;</span>
                    {{ $undangan->nama_panggilan_wanita }}
                </h2>
            </div>

            <div class="space-y-1.5 text-[#F4FAF6]">
                <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#F3E5AB]">{{ $tanggalTitik }}</p>
                <p class="text-[11px] tracking-[0.2em] text-white/90">{{ $hashtagPasangan }}</p>
            </div>
        </div>
    </div>
</section>

{{-- SEKSI 2: PRELUDE DOA WALIMAH & FOTO PEMBUKA --}}
<section
    data-section-pembuka="mihrab"
    class="relative bg-[#133D38] text-[#F4FAF6] px-5 py-12 overflow-hidden"
>
    <div class="max-w-md mx-auto text-center space-y-6">
        <div class="grid grid-cols-3 items-center max-w-[200px] mx-auto">
            <span class="fx-slide-left font-serif text-4xl sm:text-5xl font-bold text-[#F3E5AB]">{{ $undangan->inisialPria() }}</span>
            <span class="fx-scale-in font-kaligrafi text-3xl text-[#BFA15F]">&amp;</span>
            <span class="fx-slide-right font-serif text-4xl sm:text-5xl font-bold text-[#F3E5AB]">{{ $undangan->inisialWanita() }}</span>
        </div>

        @if ($urlFotoPembuka)
            <div class="fx-scale-in mx-auto w-56 sm:w-64 p-1.5 rounded-t-[9rem] rounded-b-2xl border border-[#BFA15F]/70 bg-white/10 shadow-xl">
                <div class="overflow-hidden rounded-t-[8.5rem] rounded-b-xl aspect-[4/5]">
                    <img src="{{ $urlFotoPembuka }}" alt="Foto Pembuka {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}" class="w-full h-full object-cover object-top">
                </div>
            </div>
        @endif

        @if ($undangan->kutipan_ayat)
            <blockquote class="fx-rise rounded-t-[3.5rem] rounded-b-2xl bg-white text-[#184D47] border border-[#BFA15F]/45 px-6 py-6 shadow-md kartu-3d">
                <p class="text-base text-[#9E7D40] mb-2" style="font-family: 'Amiri', serif;">
                    بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                </p>
                <p class="italic text-xs sm:text-sm text-[#184D47]/85 leading-relaxed">
                    &ldquo;{{ $undangan->kutipan_ayat }}&rdquo;
                </p>
            </blockquote>
        @endif
    </div>
</section>
