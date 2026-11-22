{{-- PANGGUNG VISUAL DESKTOP KIRI: RUSTIC FLORAL (BERSIH & SEJAJAR TENGAH) --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 min-w-0 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d items-center justify-center bg-[#2F4037] {{ $tampilBarDemo ? 'pt-14' : '' }}"
>
    <div class="lapis-3d absolute -inset-4 pointer-events-none" style="--depth: -12px; --pz: -36px;">
        <img src="{{ $urlFotoLatar }}" alt="Rustic Floral" class="w-full h-full object-cover object-center scale-105 opacity-42 animasi-nafas">
    </div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-b from-[#2F4037]/72 via-[#394D44]/58 to-[#24322B]/84"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 w-10 bg-gradient-to-l from-black/35 to-transparent z-30"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-5 xl:inset-7 {{ $tampilBarDemo ? 'top-18 xl:top-20' : '' }} rounded-3xl border border-[#E5D5C0]/25 z-10"></div>

    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'kelopak', 'konteks' => 'panggung'])

    <div class="lapis-3d relative z-20 w-full max-w-[270px] xl:max-w-[330px] mx-auto px-6 flex flex-col items-center justify-center text-center text-[#FDFBF7]" style="--depth: 8px; --pz: 20px;">
        <div class="h-14 xl:h-16 flex items-center justify-center">
            <img src="{{ $asetRustic['sudut'] }}" alt="" class="w-13 xl:w-15 opacity-95 animasi-ayun-3d">
        </div>

        <p class="mt-4 text-[10px] xl:text-[11px] font-semibold uppercase tracking-[0.36em] text-[#E5D5C0]">
            The Wedding Of
        </p>

        <h2 class="mt-3 font-serif text-3xl xl:text-4xl 2xl:text-5xl font-bold leading-tight text-white drop-shadow">
            <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
            <span class="block font-kaligrafi font-normal text-3xl xl:text-4xl text-[#E5C99B] my-0.5">&amp;</span>
            <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
        </h2>

        <div class="my-5 flex items-center justify-center gap-3 w-full max-w-[140px]" aria-hidden="true">
            <span class="h-px flex-1 bg-[#E5D5C0]/45"></span>
            <span class="w-1.5 h-1.5 rounded-full bg-[#E5C99B]"></span>
            <span class="h-px flex-1 bg-[#E5D5C0]/45"></span>
        </div>

        <p class="text-[10px] xl:text-[11px] font-medium uppercase tracking-[0.24em] text-[#FDFBF7]/85">
            {{ $tanggalLengkap }}
        </p>
    </div>
</aside>
