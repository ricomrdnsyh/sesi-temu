{{-- PANGGUNG VISUAL DESKTOP KIRI: SUNLIT ALABASTER & EMERALD ANDALUSIA --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 min-w-0 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d items-center justify-center bg-[#EEF6F1] {{ $tampilBarDemo ? 'pt-14' : '' }}"
>
    {{-- Latar Lukisan Courtyard Andalusia Lembut --}}
    <div class="lapis-3d absolute -inset-4 pointer-events-none" style="--depth: -12px; --pz: -36px;">
        <img src="{{ $urlFotoLatar }}" alt="Islami Syar'i Andalusia" class="w-full h-full object-cover object-center scale-105 opacity-45 animasi-nafas">
    </div>
    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-0"
        style="background: radial-gradient(ellipse 84% 72% at 50% 50%, rgba(247,251,248,0.92) 0%, rgba(238,246,241,0.78) 54%, rgba(215,232,223,0.88) 100%);"
    ></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 w-10 bg-gradient-to-l from-[#0E3A36]/14 to-transparent z-30"></div>

    {{-- Bingkai Kubah Moorish Ganda Emas-Zamrud --}}
    <div aria-hidden="true" class="pointer-events-none absolute inset-6 xl:inset-8 {{ $tampilBarDemo ? 'top-20 xl:top-22' : '' }} rounded-t-[11rem] rounded-b-3xl border border-[#C5A059]/55 z-10"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-8 xl:inset-10 {{ $tampilBarDemo ? 'top-22 xl:top-24' : '' }} rounded-t-[10.2rem] rounded-b-2xl border border-dashed border-[#0E3A36]/22 z-10"></div>

    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'zaitun-kilau', 'konteks' => 'panggung'])

    {{-- Plakat Tipografi Sanctuary di Tengah --}}
    <div class="lapis-3d relative z-20 w-full max-w-[280px] xl:max-w-[330px] mx-auto px-6 flex flex-col items-center justify-center text-center text-[#0E3A36]" style="--depth: 8px; --pz: 20px;">
        <div class="relative flex h-16 w-16 xl:h-18 xl:w-18 items-center justify-center">
            <span aria-hidden="true" class="absolute inset-1 rotate-45 border border-[#C5A059]/70 bg-[#0E3A36]/8"></span>
            <span aria-hidden="true" class="absolute inset-1 border border-[#0E3A36]/25"></span>
            <img src="{{ $asetSyari['arabesque'] }}" alt="" class="relative z-10 w-11 xl:w-13 opacity-95 animasi-ayun-3d">
        </div>

        <p class="mt-5 text-lg xl:text-xl text-[#0E3A36]" style="font-family: 'Amiri', serif;">
            بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
        </p>

        <p class="mt-1.5 text-[10px] xl:text-[11px] font-bold uppercase tracking-[0.36em] text-[#9E7D40]">
            Walimatul Ursy
        </p>

        <h2 class="mt-3 font-serif text-3xl xl:text-4xl 2xl:text-[2.8rem] font-bold leading-[1.08] text-[#0E3A36]">
            <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
            <span class="my-1 flex items-center justify-center gap-3">
                <span aria-hidden="true" class="h-px w-8 bg-[#C5A059]/65"></span>
                <span class="font-kaligrafi font-normal text-3xl xl:text-4xl text-[#B99348]">&amp;</span>
                <span aria-hidden="true" class="h-px w-8 bg-[#C5A059]/65"></span>
            </span>
            <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
        </h2>

        <div class="mt-5 inline-flex items-center gap-2 rounded-full bg-[#0E3A36] border border-[#C5A059]/70 px-5 py-1.5 shadow-md">
            <span aria-hidden="true" class="h-1.5 w-1.5 rotate-45 bg-[#E6D19C]"></span>
            <p class="text-[10px] xl:text-[11px] font-semibold uppercase tracking-[0.22em] text-[#F3E5AB]">
                {{ $tanggalLengkap }}
            </p>
            <span aria-hidden="true" class="h-1.5 w-1.5 rotate-45 bg-[#E6D19C]"></span>
        </div>
    </div>
</aside>
