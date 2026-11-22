{{-- PANGGUNG VISUAL DESKTOP KIRI: ROYAL IVORY CATHEDRAL (BERSIH & SEJAJAR TENGAH) --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 min-w-0 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d items-center justify-center bg-[#3B2E25] {{ $tampilBarDemo ? 'pt-14' : '' }}"
>
    <div class="lapis-3d absolute -inset-4 pointer-events-none" style="--depth: -12px; --pz: -36px;">
        <img src="{{ $urlFotoLatar }}" alt="Royal Ivory Cathedral" class="w-full h-full object-cover object-center scale-105 opacity-40 animasi-nafas">
    </div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-b from-[#3B2E25]/74 via-[#4A3826]/60 to-[#2D2118]/86"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 w-10 bg-gradient-to-l from-black/38 to-transparent z-30"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-5 xl:inset-7 {{ $tampilBarDemo ? 'top-18 xl:top-20' : '' }} rounded-t-[10rem] rounded-b-3xl border border-[#E5C99B]/26 z-10"></div>

    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'katedral-cahaya', 'konteks' => 'panggung'])

    <div class="lapis-3d relative z-20 w-full max-w-[270px] xl:max-w-[330px] mx-auto px-6 flex flex-col items-center justify-center text-center text-[#FAF6EE]" style="--depth: 8px; --pz: 20px;">
        <div class="h-14 xl:h-16 flex items-center justify-center">
            <img src="{{ $asetRoyal['katedral'] }}" alt="" class="w-13 xl:w-15 opacity-95 animasi-ayun-3d">
        </div>

        <p class="mt-4 text-[10px] xl:text-[11px] font-semibold uppercase tracking-[0.36em] text-[#E5C99B]">
            The Royal Wedding
        </p>

        <h2 class="mt-3 font-serif text-3xl xl:text-4xl 2xl:text-5xl font-bold leading-tight text-white drop-shadow">
            <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
            <span class="block font-kaligrafi font-normal text-3xl xl:text-4xl text-[#E5C99B] my-0.5">&amp;</span>
            <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
        </h2>

        <div class="my-5 flex items-center justify-center gap-3 w-full max-w-[140px]" aria-hidden="true">
            <span class="h-px flex-1 bg-[#E5C99B]/45"></span>
            <span class="w-1.5 h-1.5 rounded-full bg-[#E5C99B]"></span>
            <span class="h-px flex-1 bg-[#E5C99B]/45"></span>
        </div>

        <p class="text-[10px] xl:text-[11px] font-medium uppercase tracking-[0.24em] text-[#FAF6EE]/85">
            {{ $tanggalLengkap }}
        </p>
    </div>
</aside>
