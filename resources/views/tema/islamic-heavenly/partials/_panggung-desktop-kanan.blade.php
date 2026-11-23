{{-- PANGGUNG VISUAL DESKTOP KANAN: ISLAMIC HEAVENLY (MONOGRAM ASTROLAB & KEEPSAKE) --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 min-w-0 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d items-center justify-center bg-[#07101E] {{ $tampilBarDemo ? 'pt-14' : '' }}"
>
    <div class="lapis-3d absolute -inset-4 pointer-events-none" style="--depth: -12px; --pz: -36px;">
        <img
            src="{{ empty($urlFotoLatarCustom) ? $asetCelestial['heroPoster'] : $urlFotoLatar }}"
            alt=""
            class="w-full h-full object-cover object-center scale-105 opacity-32 blur-[1px] animasi-nafas {{ empty($urlFotoLatarCustom) ? '-scale-x-100' : '' }}"
        >
    </div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-b from-[#07101E]/82 via-[#0C1B30]/72 to-[#050B14]/92"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 left-0 w-10 bg-gradient-to-r from-black/50 to-transparent z-30"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-5 xl:inset-7 {{ $tampilBarDemo ? 'top-18 xl:top-20' : '' }} rounded-t-[10rem] rounded-b-3xl border border-[#D9B664]/28 z-10"></div>

    <img
        src="{{ $asetCelestial['lentera'] }}"
        alt=""
        aria-hidden="true"
        loading="lazy"
        decoding="async"
        class="pointer-events-none absolute -top-2 right-6 w-16 xl:w-20 opacity-70 z-10 celestial-lentera-kanan"
    >

    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'bintang', 'konteks' => 'panggung'])

    <div class="lapis-3d relative z-20 w-full max-w-[270px] xl:max-w-[330px] mx-auto px-6 flex flex-col items-center justify-center text-center text-[#E6EEF8]" style="--depth: 8px; --pz: 20px;">
        <div class="relative w-40 h-40 xl:w-48 xl:h-48 flex items-center justify-center">
            <span aria-hidden="true" class="absolute inset-0 rounded-full border border-dashed border-[#D9B664]/60 animasi-orbit"></span>
            <span aria-hidden="true" class="absolute inset-2.5 rounded-full border border-[#F3E5AB]/45 bg-[#091322]/45 animasi-orbit-balik shadow-[0_0_40px_-8px_rgba(217,182,100,0.26)]"></span>
            <svg
                aria-hidden="true"
                viewBox="0 0 24 24"
                class="pointer-events-none absolute -top-2.5 left-1/2 -translate-x-1/2 w-5 h-5 text-[#E5C474] bg-[#07101E] px-0.5 rounded-full drop-shadow"
                fill="currentColor"
            >
                <path d="M14.7 3.2a8.4 8.4 0 1 0 6.1 14.1 7.1 7.1 0 0 1-9.3-9.3 8.3 8.3 0 0 1 3.2-4.8Z" />
                <path d="M18.4 5.2l.55 1.45 1.45.55-1.45.55-.55 1.45-.55-1.45-1.45-.55 1.45-.55.55-1.45Z" />
            </svg>
            <div class="relative z-10 flex items-baseline justify-center gap-1.5 text-[#F3E5AB] drop-shadow">
                <span class="font-serif text-4xl xl:text-5xl font-bold tracking-wide">{{ $undangan->inisialPria() }}</span>
                <span class="font-kaligrafi text-3xl xl:text-4xl text-[#D9B664]">&amp;</span>
                <span class="font-serif text-4xl xl:text-5xl font-bold tracking-wide">{{ $undangan->inisialWanita() }}</span>
            </div>
        </div>

        <div class="my-5 flex items-center justify-center gap-3 w-full max-w-[140px]" aria-hidden="true">
            <span class="h-px flex-1 bg-[#D9B664]/45"></span>
            <span class="text-[10px] text-[#F3E5AB]">&#10022;</span>
            <span class="h-px flex-1 bg-[#D9B664]/45"></span>
        </div>

        <p class="text-[10px] xl:text-[11px] font-medium uppercase tracking-[0.24em] text-[#D9B664]">
            {{ $hashtagPasangan }}
        </p>

        <p class="mt-3 text-[11px] italic text-[#E6EEF8]/65 leading-relaxed max-w-[220px]">
            &ldquo;Sakinah, Mawaddah, Warahmah di bawah naungan cahaya berkah-Nya.&rdquo;
        </p>
    </div>
</aside>
