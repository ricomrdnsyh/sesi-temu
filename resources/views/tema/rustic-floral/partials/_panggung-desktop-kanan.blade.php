{{-- PANGGUNG VISUAL DESKTOP KANAN: RUSTIC FLORAL (MONOGRAM BERSIH & SEJAJAR TENGAH) --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 min-w-0 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d items-center justify-center bg-[#23322A] {{ $tampilBarDemo ? 'pt-14' : '' }}"
>
    <div class="lapis-3d absolute -inset-4 pointer-events-none" style="--depth: -12px; --pz: -36px;">
        <img
            src="{{ $urlFotoLatar }}"
            alt=""
            class="w-full h-full object-cover object-center scale-105 opacity-62 animasi-nafas {{ empty($urlFotoLatarCustom) ? '-scale-x-100' : '' }}"
        >
    </div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-b from-[#1F2D25]/66 via-[#2A3C32]/52 to-[#19241E]/80"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 left-0 w-10 bg-gradient-to-r from-black/38 to-transparent z-30"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-5 xl:inset-7 {{ $tampilBarDemo ? 'top-18 xl:top-20' : '' }} rounded-3xl border border-[#E5D5C0]/28 z-10"></div>

    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'kelopak', 'konteks' => 'panggung'])

    <div class="lapis-3d relative z-20 w-full max-w-[270px] xl:max-w-[330px] mx-auto px-6 flex flex-col items-center justify-center text-center text-[#FDFBF7]" style="--depth: 8px; --pz: 20px;">
        <div class="relative w-40 h-40 xl:w-48 xl:h-48 flex items-center justify-center">
            <span aria-hidden="true" class="absolute inset-0 rounded-full border border-dashed border-[#E5D5C0]/55 animasi-orbit"></span>
            <span aria-hidden="true" class="absolute inset-2.5 rounded-full border border-[#E5D5C0]/65 bg-[#1F2D25]/38 shadow-[0_12px_36px_rgba(0,0,0,0.35)]"></span>
            <svg aria-hidden="true" viewBox="0 0 64 24" class="pointer-events-none absolute -top-2.5 left-1/2 -translate-x-1/2 w-14 h-6 text-[#E5C99B] drop-shadow" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
                <path d="M32 16 C25 10, 17 8, 8 11 C15 15, 24 16, 32 16 Z" fill="currentColor" fill-opacity="0.28"/>
                <path d="M32 16 C39 10, 47 8, 56 11 C49 15, 40 16, 32 16 Z" fill="currentColor" fill-opacity="0.28"/>
                <circle cx="32" cy="14" r="2.2" fill="currentColor"/>
            </svg>
            <div class="relative z-10 flex items-baseline justify-center gap-1.5 text-[#FDFBF7] drop-shadow-[0_4px_14px_rgba(0,0,0,0.45)]">
                <span class="font-serif text-4xl xl:text-5xl font-bold tracking-wide">{{ $undangan->inisialPria() }}</span>
                <span class="font-kaligrafi text-3xl xl:text-4xl text-[#E5C99B]">&amp;</span>
                <span class="font-serif text-4xl xl:text-5xl font-bold tracking-wide">{{ $undangan->inisialWanita() }}</span>
            </div>
        </div>

        <div class="my-5 flex items-center justify-center gap-3 w-full max-w-[140px]" aria-hidden="true">
            <span class="h-px flex-1 bg-[#E5D5C0]/50"></span>
            <span class="w-1.5 h-1.5 rounded-full bg-[#E5C99B]"></span>
            <span class="h-px flex-1 bg-[#E5D5C0]/50"></span>
        </div>

        <p class="text-[10px] xl:text-[11px] font-medium uppercase tracking-[0.24em] text-[#E5C99B] drop-shadow">
            {{ $hashtagPasangan }}
        </p>
    </div>
</aside>
