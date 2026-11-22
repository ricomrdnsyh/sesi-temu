{{-- PANGGUNG VISUAL DESKTOP KIRI: SUNDA SIGER HERITAGE (BERSIH & SEJAJAR TENGAH) --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 min-w-0 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d items-center justify-center bg-[#3B1414] {{ $tampilBarDemo ? 'pt-14' : '' }}"
>
    <div class="lapis-3d absolute -inset-4 pointer-events-none" style="--depth: -12px; --pz: -36px;">
        <img
            src="{{ $urlFotoLatar }}"
            alt="Latar Sunda Siger Heritage"
            class="w-full h-full object-cover object-center scale-105 opacity-42 animasi-nafas"
        >
    </div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-b from-[#3B1414]/75 via-[#4A1717]/60 to-[#2B0E0E]/86"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 w-10 bg-gradient-to-l from-black/40 to-transparent z-30"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-5 xl:inset-7 {{ $tampilBarDemo ? 'top-18 xl:top-20' : '' }} rounded-3xl border border-[#C59B43]/25 z-10"></div>

    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'melati-burung', 'konteks' => 'panggung'])

    <div class="lapis-3d relative z-20 w-full max-w-[270px] xl:max-w-[330px] mx-auto px-6 flex flex-col items-center justify-center text-center text-[#FAF4E8]" style="--depth: 8px; --pz: 20px;">
        <div class="h-14 xl:h-16 flex items-center justify-center">
            <img
                src="{{ $asetSunda['siger'] }}"
                alt=""
                class="w-13 xl:w-16 opacity-95 drop-shadow-[0_8px_18px_rgba(0,0,0,0.45)] animasi-ayun-3d"
            >
        </div>

        <p class="mt-4 text-[10px] xl:text-[11px] font-semibold uppercase tracking-[0.34em] text-[#F3E5AB]">
            Sampurasun &bull; Sunda Heritage
        </p>

        <h2 class="mt-3 font-serif text-3xl xl:text-4xl 2xl:text-5xl font-bold leading-tight text-white drop-shadow">
            <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
            <span class="block font-kaligrafi font-normal text-3xl xl:text-4xl text-[#E7C87D] my-0.5">&amp;</span>
            <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
        </h2>

        <div class="my-5 flex items-center justify-center gap-3 w-full max-w-[140px]" aria-hidden="true">
            <span class="h-px flex-1 bg-[#C59B43]/50"></span>
            <span class="w-1.5 h-1.5 rounded-full bg-[#E7C87D]"></span>
            <span class="h-px flex-1 bg-[#C59B43]/50"></span>
        </div>

        <p class="text-[10px] xl:text-[11px] font-medium uppercase tracking-[0.24em] text-[#FAF4E8]/85">
            {{ $tanggalLengkap }}
        </p>
    </div>
</aside>
