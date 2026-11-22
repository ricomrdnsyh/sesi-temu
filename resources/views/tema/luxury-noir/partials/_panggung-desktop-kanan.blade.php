{{-- PANGGUNG VISUAL DESKTOP KANAN: LUXURY NOIR GOLD (MONOGRAM ART DECO BERSIH & SEJAJAR TENGAH) --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 min-w-0 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d items-center justify-center bg-[#09090D] {{ $tampilBarDemo ? 'pt-14' : '' }}"
>
    <div class="lapis-3d absolute -inset-4 pointer-events-none" style="--depth: -12px; --pz: -36px;">
        <img
            src="{{ $urlFotoLatar }}"
            alt=""
            class="w-full h-full object-cover object-center scale-105 opacity-38 animasi-nafas {{ empty($urlFotoLatarCustom) ? '-scale-x-100' : '' }}"
        >
    </div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-b from-black/78 via-[#0B0B0F]/64 to-black/90"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 left-0 w-10 bg-gradient-to-r from-black/55 to-transparent z-30"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-5 xl:inset-7 {{ $tampilBarDemo ? 'top-18 xl:top-20' : '' }} rounded-xl border border-[#D4AF37]/24 z-10"></div>

    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'debu-emas', 'konteks' => 'panggung'])

    <div class="lapis-3d relative z-20 w-full max-w-[270px] xl:max-w-[330px] mx-auto px-6 flex flex-col items-center justify-center text-center text-[#F5EFE6]" style="--depth: 8px; --pz: 20px;">
        <div class="relative w-40 h-40 xl:w-48 xl:h-48 flex items-center justify-center">
            <span aria-hidden="true" class="absolute inset-3 rotate-45 border border-[#D4AF37]/45 bg-black/25"></span>
            <span aria-hidden="true" class="absolute inset-0 rounded-full border border-dashed border-[#D4AF37]/55 animasi-orbit"></span>
            <span aria-hidden="true" class="absolute inset-2.5 rounded-full border border-[#F3E5AB]/40 animasi-orbit-balik"></span>
            <div class="relative z-10 flex items-baseline justify-center gap-1.5 text-[#F3E5AB] drop-shadow">
                <span class="noir-font-judul text-3xl xl:text-4xl font-bold tracking-widest">{{ $undangan->inisialPria() }}</span>
                <span class="font-kaligrafi text-3xl xl:text-4xl text-[#D4AF37]">&amp;</span>
                <span class="noir-font-judul text-3xl xl:text-4xl font-bold tracking-widest">{{ $undangan->inisialWanita() }}</span>
            </div>
        </div>

        <div class="my-5 flex items-center justify-center gap-3 w-full max-w-[140px]" aria-hidden="true">
            <span class="h-px flex-1 bg-[#D4AF37]/45"></span>
            <span class="w-1.5 h-1.5 rotate-45 bg-[#D4AF37]"></span>
            <span class="h-px flex-1 bg-[#D4AF37]/45"></span>
        </div>

        <p class="text-[10px] xl:text-[11px] font-medium uppercase tracking-[0.24em] text-[#D4AF37]">
            {{ $hashtagPasangan }}
        </p>
    </div>
</aside>
