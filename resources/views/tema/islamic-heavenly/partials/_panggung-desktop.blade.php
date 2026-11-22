{{-- PANGGUNG VISUAL DESKTOP KIRI: ISLAMIC HEAVENLY (BERSIH & SEJAJAR TENGAH) --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 min-w-0 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d items-center justify-center bg-[#091322] {{ $tampilBarDemo ? 'pt-14' : '' }}"
>
    <div class="lapis-3d absolute -inset-4 pointer-events-none" style="--depth: -12px; --pz: -36px;">
        <img
            src="{{ $urlFotoLatar }}"
            alt="Latar Islamic Heavenly"
            class="w-full h-full object-cover object-center scale-105 opacity-45 animasi-nafas"
        >
    </div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-b from-[#091322]/76 via-[#0E1B2A]/60 to-[#060D18]/88"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 w-10 bg-gradient-to-l from-black/45 to-transparent z-30"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-5 xl:inset-7 {{ $tampilBarDemo ? 'top-18 xl:top-20' : '' }} rounded-t-[10rem] rounded-b-3xl border border-[#D9B664]/24 z-10"></div>

    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'bintang', 'konteks' => 'panggung'])

    <div class="lapis-3d relative z-20 w-full max-w-[270px] xl:max-w-[330px] mx-auto px-6 flex flex-col items-center justify-center text-center text-[#E6EEF8]" style="--depth: 8px; --pz: 20px;">
        <div class="h-16 xl:h-18 flex items-center justify-center">
            <div class="relative w-16 h-16 xl:w-18 xl:h-18 flex items-center justify-center">
                <span class="absolute inset-0 rounded-full border border-dashed border-[#D9B664]/55 animasi-orbit"></span>
                <img src="{{ $asetCelestial['sabit'] }}" alt="" class="w-8 xl:w-9 opacity-95 animasi-ayun-3d">
            </div>
        </div>

        <p class="mt-4 text-base xl:text-lg text-[#F3E5AB]" style="font-family: 'Amiri', serif;">
            بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
        </p>

        <p class="mt-1.5 text-[10px] xl:text-[11px] font-semibold uppercase tracking-[0.34em] text-[#D9B664]">
            Walimatul Ursy &bull; Celestial Night
        </p>

        <h2 class="mt-3 font-serif text-3xl xl:text-4xl 2xl:text-5xl font-bold leading-tight text-white drop-shadow">
            <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
            <span class="block font-kaligrafi font-normal text-3xl xl:text-4xl text-[#D9B664] my-0.5">&amp;</span>
            <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
        </h2>

        <div class="my-5 flex items-center justify-center gap-3 w-full max-w-[140px]" aria-hidden="true">
            <span class="h-px flex-1 bg-[#D9B664]/45"></span>
            <span class="w-1.5 h-1.5 rounded-full bg-[#F3E5AB]"></span>
            <span class="h-px flex-1 bg-[#D9B664]/45"></span>
        </div>

        <p class="text-[10px] xl:text-[11px] font-medium uppercase tracking-[0.24em] text-[#E6EEF8]/85">
            {{ $tanggalLengkap }}
        </p>
    </div>
</aside>
