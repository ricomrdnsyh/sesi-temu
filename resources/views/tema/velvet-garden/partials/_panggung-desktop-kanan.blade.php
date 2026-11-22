{{-- PANGGUNG VISUAL DESKTOP KANAN: VELVET GARDEN (MONOGRAM BERSIH & SEJAJAR TENGAH) --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 min-w-0 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d items-center justify-center bg-[#132623] {{ $tampilBarDemo ? 'pt-14' : '' }}"
>
    <div class="lapis-3d absolute -inset-4 pointer-events-none" style="--depth: -12px; --pz: -36px;">
        <img
            src="{{ $urlFotoLatar }}"
            alt=""
            class="w-full h-full object-cover object-center scale-105 opacity-42 animasi-nafas {{ empty($urlFotoLatarCustom) ? '-scale-x-100' : '' }}"
        >
    </div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-b from-[#0E1E18]/76 via-[#132623]/60 to-[#0A1712]/88"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 left-0 w-10 bg-gradient-to-r from-black/45 to-transparent z-30"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-5 xl:inset-7 {{ $tampilBarDemo ? 'top-18 xl:top-20' : '' }} rounded-t-[10rem] rounded-b-3xl border border-[#C8A464]/25 z-10"></div>

    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'kelopak-kunang', 'konteks' => 'panggung'])

    <div class="lapis-3d relative z-20 w-full max-w-[270px] xl:max-w-[330px] mx-auto px-6 flex flex-col items-center justify-center text-center text-[#F4F8F6]" style="--depth: 8px; --pz: 20px;">
        <div class="relative w-40 h-40 xl:w-48 xl:h-48 flex items-center justify-center">
            <span aria-hidden="true" class="absolute inset-0 rounded-full border border-dashed border-[#C8A464]/55 animasi-orbit"></span>
            <span aria-hidden="true" class="absolute inset-2.5 rounded-full border border-[#EEDAD4]/45 bg-[#0E1E18]/32 shadow-[0_12px_36px_rgba(0,0,0,0.35)]"></span>
            <img
                src="{{ $asetGarden['botani'] }}"
                alt=""
                aria-hidden="true"
                class="pointer-events-none absolute -top-4 left-1/2 -translate-x-1/2 w-9 xl:w-10 opacity-95 drop-shadow"
            >
            <div class="relative z-10 flex items-baseline justify-center gap-1.5 text-[#F3DFA2] drop-shadow">
                <span class="font-serif text-4xl xl:text-5xl font-bold tracking-wide">{{ $undangan->inisialPria() }}</span>
                <span class="font-kaligrafi text-3xl xl:text-4xl text-[#EEDAD4]">&amp;</span>
                <span class="font-serif text-4xl xl:text-5xl font-bold tracking-wide">{{ $undangan->inisialWanita() }}</span>
            </div>
        </div>

        <div class="my-5 flex items-center justify-center gap-3 w-full max-w-[140px]" aria-hidden="true">
            <span class="h-px flex-1 bg-[#C8A464]/45"></span>
            <span class="w-1.5 h-1.5 rounded-full bg-[#C8A464]"></span>
            <span class="h-px flex-1 bg-[#C8A464]/45"></span>
        </div>

        <p class="text-[10px] xl:text-[11px] font-medium uppercase tracking-[0.24em] text-[#C8A464]">
            {{ $hashtagPasangan }}
        </p>
    </div>
</aside>
