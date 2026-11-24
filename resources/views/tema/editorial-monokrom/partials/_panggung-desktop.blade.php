{{-- PANGGUNG VISUAL DESKTOP KIRI: VOGUE EXHIBITION SPREAD & VIEWFINDER --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 min-w-0 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d items-center justify-center bg-[#0E0E11] {{ $tampilBarDemo ? 'pt-14' : '' }}"
>
    <div class="lapis-3d absolute -inset-4 pointer-events-none" style="--depth: -12px; --pz: -36px;">
        <img
            src="{{ $urlFotoLatar }}"
            alt="Editorial Monokrom"
            :class="modeWarnaEditorial ? 'grayscale-0 opacity-40' : 'grayscale opacity-34'"
            class="w-full h-full object-cover object-center scale-105 animasi-nafas transition duration-700"
        >
    </div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-b from-black/82 via-[#0E0E11]/68 to-black/92"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 ed-film-grain opacity-35"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 w-10 bg-gradient-to-l from-black/65 to-transparent z-30"></div>

    {{-- Bingkai Viewfinder Siku Tajam --}}
    <div aria-hidden="true" class="pointer-events-none absolute inset-5 xl:inset-7 {{ $tampilBarDemo ? 'top-18 xl:top-20' : '' }} rounded-none border border-white/20 z-10">
        <span class="absolute -top-px -left-px h-4 w-4 border-t-2 border-l-2 border-white/80"></span>
        <span class="absolute -top-px -right-px h-4 w-4 border-t-2 border-r-2 border-white/80"></span>
        <span class="absolute -bottom-px -left-px h-4 w-4 border-b-2 border-l-2 border-white/80"></span>
        <span class="absolute -bottom-px -right-px h-4 w-4 border-b-2 border-r-2 border-white/80"></span>
    </div>

    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'halus', 'konteks' => 'panggung'])

    <div class="lapis-3d relative z-20 w-full max-w-[280px] xl:max-w-[340px] mx-auto px-6 flex flex-col items-start justify-center text-left text-white" style="--depth: 8px; --pz: 20px;">
        <div class="w-full flex items-center justify-between border-b border-white/25 pb-3 mb-5">
            <span class="ed-mono text-[9.5px] uppercase tracking-[0.28em] text-white/65">ISSUE 01 / {{ $tahunAcara }}</span>
            <img src="{{ $asetEditorial['bingkai'] }}" alt="" class="w-8 opacity-85 invert animasi-ayun-3d">
        </div>

        <p class="ed-mono text-[9.5px] xl:text-[10px] uppercase tracking-[0.34em] text-white/65">
            ATELIER MONOCHROME
        </p>

        <h2 class="mt-2.5 ed-serif text-3xl xl:text-4xl 2xl:text-5xl font-normal uppercase tracking-[0.06em] leading-[1.02] text-white">
            <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
            <span class="my-1.5 flex items-center gap-2.5">
                <span class="h-px w-8 bg-white/45"></span>
                <span class="ed-mono text-xs xl:text-sm tracking-[0.24em] text-white/65">&amp;</span>
            </span>
            <span class="block pl-4">{{ $undangan->nama_panggilan_wanita }}</span>
        </h2>

        <div class="mt-6 pt-3.5 border-t border-white/20 w-full flex items-center justify-between text-[9.5px] xl:text-[10px] ed-mono uppercase tracking-[0.22em] text-white/75">
            <span>{{ $tanggalTitik }}</span>
            <span>35MM ARCHIVE</span>
        </div>
    </div>
</aside>
