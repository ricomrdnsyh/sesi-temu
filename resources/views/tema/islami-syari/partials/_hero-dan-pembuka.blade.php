{{-- SEKSI 1: HERO ALHAMBRA SANCTUARY (1 LAYAR PENUH + KANOPI ZAMRUD & KARTUS MEMPELAI) --}}
<section
    data-diorama-3d="basic"
    class="syari-hero-layar-penuh {{ $tampilBarDemo ? 'dengan-bar-demo' : '' }} relative flex flex-col justify-between overflow-hidden bg-[#0E3A36]"
    :class="undanganTerbuka ? 'syari-hero-terbuka' : ''"
>
    {{-- Latar Lukisan Courtyard Andalusia Penuh dengan Dolly Halus --}}
    <div class="absolute inset-0 pointer-events-none">
        <img
            src="{{ $urlFotoLatar }}"
            alt="Islami Syar'i"
            class="w-full h-full object-cover object-center"
            :class="undanganTerbuka ? 'diorama-latar-basic' : ''"
        >
        <div
            aria-hidden="true"
            class="absolute inset-0"
            style="background: linear-gradient(180deg, rgba(11,45,42,0.92) 0%, rgba(14,58,54,0.68) 28%, rgba(247,251,248,0.52) 55%, rgba(247,251,248,0.78) 78%, rgba(14,58,54,0.94) 100%);"
        ></div>
    </div>

    {{-- Bingkai Kubah Lengkung Mihrab Tipis Menyatu dengan Layar --}}
    <div aria-hidden="true" class="pointer-events-none absolute inset-3 rounded-t-[10.5rem] rounded-b-3xl border border-[#E6D19C]/55 z-10"></div>

    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'zaitun-kilau', 'konteks' => 'utama'])

    {{-- Kanopi Tajuk Zamrud-Emas Atas --}}
    <div class="syari-hero-stagger-1 relative z-20 px-7 pt-10 sm:pt-12 text-center text-[#F7FBF8] space-y-1.5">
        <div class="relative mx-auto flex h-14 w-14 items-center justify-center">
            <span aria-hidden="true" class="absolute inset-1 rotate-45 border border-[#E6D19C]/65 bg-[#0A2B28]/55"></span>
            <img src="{{ $asetSyari['arabesque'] }}" alt="" class="relative z-10 w-10 opacity-95 animasi-ayun-3d">
        </div>
        <p class="pt-1 text-lg sm:text-xl text-[#F3E5AB] drop-shadow" style="font-family: 'Amiri', serif;">
            بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
        </p>
        <p class="text-[9.5px] font-bold uppercase tracking-[0.26em] text-[#E6D19C]">
            Assalamu&rsquo;alaikum Warahmatullahi Wabarakatuh
        </p>
        <p class="text-[10px] font-medium uppercase tracking-[0.34em] text-white/80">
            We Are Getting Married!
        </p>
    </div>

    {{-- Kartus Manuskrip Mempelai Di Tengah --}}
    <div class="syari-hero-stagger-2 relative z-20 px-6 my-auto py-4">
        <div class="relative mx-auto max-w-[340px] rounded-3xl bg-[#F8FCF9]/94 backdrop-blur-md border-2 border-[#C5A059]/75 px-6 py-6 text-center shadow-[0_22px_50px_-14px_rgba(11,45,42,0.45)]">
            <span aria-hidden="true" class="pointer-events-none absolute top-2.5 left-2.5 h-3 w-3 border-t-2 border-l-2 border-[#C5A059]"></span>
            <span aria-hidden="true" class="pointer-events-none absolute top-2.5 right-2.5 h-3 w-3 border-t-2 border-r-2 border-[#C5A059]"></span>
            <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 left-2.5 h-3 w-3 border-b-2 border-l-2 border-[#C5A059]"></span>
            <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 right-2.5 h-3 w-3 border-b-2 border-r-2 border-[#C5A059]"></span>

            <p class="text-[9.5px] font-bold uppercase tracking-[0.36em] text-[#9E7D40]">
                Walimatul Ursy
            </p>
            <h2 class="mt-2 font-serif text-[2.75rem] sm:text-[3.1rem] font-bold leading-[1.04] text-[#0E3A36]">
                <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
                <span class="my-1 flex items-center justify-center gap-3">
                    <span aria-hidden="true" class="h-px w-10 bg-gradient-to-r from-transparent to-[#C5A059]"></span>
                    <span class="font-kaligrafi text-4xl font-normal text-[#B99348] leading-none">&amp;</span>
                    <span aria-hidden="true" class="h-px w-10 bg-gradient-to-l from-transparent to-[#C5A059]"></span>
                </span>
                <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
            </h2>
            <p class="mt-3 text-[10.5px] font-semibold uppercase tracking-[0.24em] text-[#16524C]">
                {{ $tanggalLengkap }}
            </p>
        </div>
    </div>

    {{-- Pita Tanggal 3-Kolom & Hashtag Bawah --}}
    <div class="syari-hero-stagger-3 relative z-20 px-6 pb-7 sm:pb-8 text-center text-[#F7FBF8] space-y-3">
        <div class="mx-auto max-w-[320px] grid grid-cols-3 items-center divide-x divide-[#C5A059]/45 rounded-2xl bg-[#0A2B28]/75 backdrop-blur-md border border-[#C5A059]/45 py-2.5 px-2 shadow-lg">
            <div>
                <p class="text-[9px] uppercase tracking-[0.22em] text-[#E6D19C]/80">Tanggal</p>
                <p class="font-serif text-sm font-bold text-white">{{ $tanggalTitik }}</p>
            </div>
            <div class="col-span-2 px-2">
                <p class="text-[9px] uppercase tracking-[0.22em] text-[#E6D19C]/80">Momen Bahagia</p>
                <p class="text-[11px] font-semibold tracking-[0.14em] text-[#F3E5AB] truncate">{{ $hashtagPasangan }}</p>
            </div>
        </div>

        <div class="flex flex-col items-center gap-1 text-[#E6D19C]/85" aria-hidden="true">
            <svg class="w-4 h-4 animate-bounce" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m6 9 6 6 6-6"/>
            </svg>
            <span class="text-[8.5px] font-semibold uppercase tracking-[0.32em] text-[#F7FBF8]/75">Gulir Undangan</span>
        </div>
    </div>
</section>

{{-- SEKSI 2: PRELUDE MANUSKRIP AYAT & SEGEL RUB EL HIZB (KONTRAST TERANG ALABASTER) --}}
<section
    data-section-pembuka="mihrab"
    class="relative bg-[#F7FBF8] syari-pola-zellige text-[#0E3A36] px-5 py-11 border-b border-[#C5A059]/30 overflow-hidden"
>
    <div class="max-w-md mx-auto text-center space-y-6">
        {{-- Segel Bintang 8 Sudut Monogram --}}
        <div class="fx-scale-in relative mx-auto h-24 w-24 flex items-center justify-center">
            <span aria-hidden="true" class="absolute inset-2 bg-[#0E3A36] border border-[#C5A059] shadow-md"></span>
            <span aria-hidden="true" class="absolute inset-2 rotate-45 bg-[#0E3A36] border border-[#C5A059] shadow-md"></span>
            <div class="relative z-10 flex items-baseline gap-1 text-[#F3E5AB]">
                <span class="fx-slide-left font-serif text-2xl font-bold">{{ $undangan->inisialPria() }}</span>
                <span class="font-kaligrafi text-xl text-[#E6D19C]">&amp;</span>
                <span class="fx-slide-right font-serif text-2xl font-bold">{{ $undangan->inisialWanita() }}</span>
            </div>
        </div>

        @if ($urlFotoPembuka)
            <div class="fx-scale-in relative mx-auto w-60 sm:w-64 p-2 rounded-t-[8.5rem] rounded-b-2xl bg-white border border-[#C5A059]/70 shadow-[0_18px_40px_-16px_rgba(14,58,54,0.28)]">
                <div class="overflow-hidden rounded-t-[7.8rem] rounded-b-xl aspect-[4/5] border border-[#0E3A36]/12">
                    <img src="{{ $urlFotoPembuka }}" alt="Foto Pembuka {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}" class="w-full h-full object-cover object-top">
                </div>
            </div>
        @endif

        @if ($undangan->kutipan_ayat)
            {{-- Kartu Manuskrip Ayat Zamrud-Emas --}}
            <blockquote class="fx-rise relative rounded-3xl bg-gradient-to-br from-[#0E3A36] via-[#134842] to-[#0B2D2A] text-[#F7FBF8] border border-[#C5A059]/60 px-6 py-6 shadow-[0_18px_38px_-14px_rgba(14,58,54,0.45)] kartu-3d">
                <span aria-hidden="true" class="pointer-events-none absolute top-2.5 left-2.5 h-3 w-3 border-t border-l border-[#E6D19C]/75"></span>
                <span aria-hidden="true" class="pointer-events-none absolute top-2.5 right-2.5 h-3 w-3 border-t border-r border-[#E6D19C]/75"></span>
                <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 left-2.5 h-3 w-3 border-b border-l border-[#E6D19C]/75"></span>
                <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 right-2.5 h-3 w-3 border-b border-r border-[#E6D19C]/75"></span>

                <p class="text-lg text-[#F3E5AB] mb-2" style="font-family: 'Amiri', serif;">
                    بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                </p>
                <p class="italic text-xs sm:text-sm text-[#F7FBF8]/90 leading-relaxed">
                    &ldquo;{{ $undangan->kutipan_ayat }}&rdquo;
                </p>
                <div class="mt-3.5 flex items-center justify-center gap-2" aria-hidden="true">
                    <span class="h-px w-10 bg-[#C5A059]/55"></span>
                    <span class="h-1.5 w-1.5 rotate-45 bg-[#E6D19C]"></span>
                    <span class="h-px w-10 bg-[#C5A059]/55"></span>
                </div>
            </blockquote>
        @endif
    </div>
</section>
