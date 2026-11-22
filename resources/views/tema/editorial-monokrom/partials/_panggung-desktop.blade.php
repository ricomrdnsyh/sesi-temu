{{-- PANGGUNG VISUAL DESKTOP KIRI: EDITORIAL MONOKROM (BERSIH & SEJAJAR TENGAH — ZERO ROUNDED CORNERS) --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 min-w-0 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d items-center justify-center bg-[#111113] {{ $tampilBarDemo ? 'pt-14' : '' }}"
>
    <div class="lapis-3d absolute -inset-4 pointer-events-none" style="--depth: -12px; --pz: -36px;">
        <img src="{{ $urlFotoLatar }}" alt="Editorial Monokrom" class="w-full h-full object-cover object-center grayscale scale-105 opacity-36 animasi-nafas">
    </div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-b from-black/78 via-[#111113]/64 to-black/90"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 w-10 bg-gradient-to-l from-black/55 to-transparent z-30"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-5 xl:inset-7 {{ $tampilBarDemo ? 'top-18 xl:top-20' : '' }} rounded-none border border-white/22 z-10"></div>

    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'halus', 'konteks' => 'panggung'])

    <div class="lapis-3d relative z-20 w-full max-w-[270px] xl:max-w-[330px] mx-auto px-6 flex flex-col items-center justify-center text-center text-white" style="--depth: 8px; --pz: 20px;">
        <div class="h-14 xl:h-16 flex items-center justify-center">
            <img src="{{ $asetEditorial['bingkai'] }}" alt="" class="w-11 xl:w-13 opacity-85 invert animasi-ayun-3d">
        </div>

        <p class="mt-4 text-[10px] xl:text-[11px] font-semibold uppercase tracking-[0.36em] text-white/70">
            The Wedding Edition
        </p>

        <h2 class="mt-3 ed-serif text-3xl xl:text-4xl 2xl:text-5xl font-normal uppercase tracking-[0.08em] leading-[1.08] text-white">
            <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
            <span class="block text-2xl xl:text-3xl text-white/55 my-1">&amp;</span>
            <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
        </h2>

        <div class="my-5 flex items-center justify-center gap-3 w-full max-w-[140px]" aria-hidden="true">
            <span class="h-px flex-1 bg-white/35"></span>
            <span class="w-1.5 h-1.5 bg-white/80"></span>
            <span class="h-px flex-1 bg-white/35"></span>
        </div>

        <p class="text-[10px] xl:text-[11px] font-medium uppercase tracking-[0.24em] text-white/80">
            {{ $tanggalLengkap }}
        </p>
    </div>
</aside>
