{{-- PANGGUNG VISUAL DESKTOP KANAN: EDITORIAL MONOKROM (MONOGRAM BERSIH & SEJAJAR TENGAH — ZERO ROUNDED CORNERS) --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 min-w-0 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d items-center justify-center bg-[#111113] {{ $tampilBarDemo ? 'pt-14' : '' }}"
>
    <div class="lapis-3d absolute -inset-4 pointer-events-none" style="--depth: -12px; --pz: -36px;">
        <img
            src="{{ $urlFotoLatar }}"
            alt=""
            class="w-full h-full object-cover object-center grayscale scale-105 opacity-36 animasi-nafas {{ empty($urlFotoLatarCustom) ? '-scale-x-100' : '' }}"
        >
    </div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-b from-black/78 via-[#111113]/64 to-black/90"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 left-0 w-10 bg-gradient-to-r from-black/55 to-transparent z-30"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-5 xl:inset-7 {{ $tampilBarDemo ? 'top-18 xl:top-20' : '' }} rounded-none border border-white/22 z-10"></div>

    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'halus', 'konteks' => 'panggung'])

    <div class="lapis-3d relative z-20 w-full max-w-[270px] xl:max-w-[330px] mx-auto px-6 flex flex-col items-center justify-center text-center text-white" style="--depth: 8px; --pz: 20px;">
        <div class="relative w-36 h-36 xl:w-44 xl:h-44 rounded-none flex items-center justify-center">
            <span aria-hidden="true" class="absolute inset-0 rounded-none border border-white/45 bg-black/30"></span>
            <span aria-hidden="true" class="absolute inset-2 rounded-none border border-white/20"></span>
            <div class="relative z-10 flex items-baseline justify-center gap-2 text-white">
                <span class="ed-serif text-4xl xl:text-5xl tracking-[0.08em]">{{ $undangan->inisialPria() }}</span>
                <span class="ed-serif text-2xl xl:text-3xl text-white/55">&amp;</span>
                <span class="ed-serif text-4xl xl:text-5xl tracking-[0.08em]">{{ $undangan->inisialWanita() }}</span>
            </div>
        </div>

        <div class="my-5 flex items-center justify-center gap-3 w-full max-w-[140px]" aria-hidden="true">
            <span class="h-px flex-1 bg-white/35"></span>
            <span class="w-1.5 h-1.5 bg-white/80"></span>
            <span class="h-px flex-1 bg-white/35"></span>
        </div>

        <p class="text-[10px] xl:text-[11px] font-medium uppercase tracking-[0.24em] text-white/80">
            {{ $hashtagPasangan }}
        </p>
    </div>
</aside>
