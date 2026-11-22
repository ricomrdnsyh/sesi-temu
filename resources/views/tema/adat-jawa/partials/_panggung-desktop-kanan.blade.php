{{-- PANGGUNG VISUAL DESKTOP KANAN: ADAT JAWA KERATON (MONOGRAM BERSIH & SEJAJAR TENGAH) --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 min-w-0 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d items-center justify-center bg-[#2B180F] {{ $tampilBarDemo ? 'pt-14' : '' }}"
>
    {{-- Latar Atmosferik Simetris --}}
    <div class="lapis-3d absolute -inset-4 pointer-events-none" style="--depth: -12px; --pz: -36px;">
        <img
            src="{{ $urlFotoLatar }}"
            alt=""
            class="w-full h-full object-cover object-center scale-105 opacity-45 animasi-nafas {{ empty($urlFotoLatarCustom) ? '-scale-x-100' : '' }}"
        >
    </div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-b from-[#2B180F]/72 via-[#3B2316]/58 to-[#24130B]/82"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 left-0 w-10 bg-gradient-to-r from-black/40 to-transparent z-30"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-5 xl:inset-7 {{ $tampilBarDemo ? 'top-18 xl:top-20' : '' }} rounded-3xl border border-[#D7BB83]/22 z-10"></div>

    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'wayang-flora', 'konteks' => 'panggung'])

    {{-- Medali Monogram Keraton Rata Tengah Vertikal & Horizontal --}}
    <div class="lapis-3d relative z-20 w-full max-w-[270px] xl:max-w-[330px] mx-auto px-6 flex flex-col items-center justify-center text-center text-[#FAF3E6]" style="--depth: 8px; --pz: 20px;">
        <div class="relative w-40 h-40 xl:w-48 xl:h-48 flex items-center justify-center">
            <span aria-hidden="true" class="absolute inset-0 rounded-full border border-dashed border-[#D7BB83]/50 animasi-orbit"></span>
            <span aria-hidden="true" class="absolute inset-2.5 rounded-full border border-[#D7BB83]/60 bg-[#2B180F]/30 shadow-[0_12px_36px_rgba(0,0,0,0.35)]"></span>
            <img
                src="{{ $asetJawa['gununganKecil'] }}"
                alt=""
                aria-hidden="true"
                class="pointer-events-none absolute -top-3.5 left-1/2 -translate-x-1/2 w-7 xl:w-8 opacity-95 drop-shadow"
            >
            <div class="relative z-10 flex items-baseline justify-center gap-1.5 text-[#F3E5AB] drop-shadow-[0_4px_14px_rgba(20,10,5,0.65)]">
                <span class="font-serif text-4xl xl:text-5xl font-semibold tracking-wide">{{ $undangan->inisialPria() }}</span>
                <span class="font-kaligrafi text-3xl xl:text-4xl text-[#D7BB83]">&amp;</span>
                <span class="font-serif text-4xl xl:text-5xl font-semibold tracking-wide">{{ $undangan->inisialWanita() }}</span>
            </div>
        </div>

        <div class="my-5 flex items-center justify-center gap-3 w-full max-w-[140px]" aria-hidden="true">
            <span class="h-px flex-1 bg-[#D7BB83]/45"></span>
            <span class="w-1.5 h-1.5 rotate-45 bg-[#E5CE9A]"></span>
            <span class="h-px flex-1 bg-[#D7BB83]/45"></span>
        </div>

        <p class="text-[10px] xl:text-[11px] font-medium uppercase tracking-[0.24em] text-[#E5CE9A]/90">
            {{ $hashtagPasangan }}
        </p>
    </div>
</aside>
