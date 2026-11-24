{{-- PANGGUNG VISUAL DESKTOP KIRI: RUSTIC FLORAL (BERSIH & SEJAJAR TENGAH) --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 min-w-0 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d items-center justify-center bg-[#23322A] {{ $tampilBarDemo ? 'pt-14' : '' }}"
>
    <div class="lapis-3d absolute -inset-4 pointer-events-none" style="--depth: -12px; --pz: -36px;">
        <img
            src="{{ empty($urlFotoLatarCustom) ? $asetRustic['heroPoster'] : $urlFotoLatar }}"
            alt="Rustic Floral"
            class="w-full h-full object-cover object-center scale-105 opacity-48 blur-[1px] animasi-nafas"
        >
    </div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-b from-[#1F2D25]/76 via-[#2A3C32]/66 to-[#19241E]/86"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 w-10 bg-gradient-to-l from-black/38 to-transparent z-30"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-5 xl:inset-7 {{ $tampilBarDemo ? 'top-18 xl:top-20' : '' }} rounded-t-[10rem] rounded-b-3xl border border-[#E5D5C0]/30 z-10"></div>

    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'kelopak', 'konteks' => 'panggung'])

    <div class="lapis-3d relative z-20 w-full max-w-[270px] xl:max-w-[330px] mx-auto px-6 flex flex-col items-center justify-center text-center text-[#FDFBF7]" style="--depth: 8px; --pz: 20px;">
        <div class="h-14 xl:h-16 flex items-center justify-center">
            <svg aria-hidden="true" viewBox="0 0 80 40" class="w-16 xl:w-20 h-9 text-[#E5C99B] opacity-95 drop-shadow animasi-ayun-3d" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round">
                <path d="M40 28 C31 18, 20 14, 8 18 C17 24, 28 28, 40 28 Z" fill="currentColor" fill-opacity="0.22"/>
                <path d="M40 28 C49 18, 60 14, 72 18 C63 24, 52 28, 40 28 Z" fill="currentColor" fill-opacity="0.22"/>
                <path d="M40 26 C35 16, 34 8, 40 4 C46 8, 45 16, 40 26 Z" fill="currentColor" fill-opacity="0.32"/>
                <circle cx="40" cy="28" r="2.2" fill="currentColor"/>
            </svg>
        </div>

        <p class="mt-4 text-[10px] xl:text-[11px] font-semibold uppercase tracking-[0.36em] text-[#E5D5C0] drop-shadow">
            The Wedding Of
        </p>

        <h2 class="mt-3 font-serif text-3xl xl:text-4xl 2xl:text-5xl font-bold leading-tight text-white drop-shadow-[0_4px_14px_rgba(0,0,0,0.45)]">
            <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
            <span class="block font-kaligrafi font-normal text-3xl xl:text-4xl text-[#E5C99B] my-0.5">&amp;</span>
            <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
        </h2>

        <div class="my-5 flex items-center justify-center gap-3 w-full max-w-[140px]" aria-hidden="true">
            <span class="h-px flex-1 bg-[#E5D5C0]/50"></span>
            <span class="w-1.5 h-1.5 rounded-full bg-[#E5C99B]"></span>
            <span class="h-px flex-1 bg-[#E5D5C0]/50"></span>
        </div>

        <p class="text-[10px] xl:text-[11px] font-medium uppercase tracking-[0.24em] text-[#FDFBF7]/90 drop-shadow">
            {{ $tanggalLengkap }}
        </p>
    </div>
</aside>
