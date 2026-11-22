{{-- PANGGUNG VISUAL DESKTOP KIRI: LUXURY NOIR GOLD (BERSIH & SEJAJAR TENGAH) --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 min-w-0 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d items-center justify-center bg-[#09090D] {{ $tampilBarDemo ? 'pt-14' : '' }}"
>
    <div class="lapis-3d absolute -inset-4 pointer-events-none" style="--depth: -12px; --pz: -36px;">
        <img src="{{ $urlFotoLatar }}" alt="Luxury Noir Gala" class="w-full h-full object-cover object-center scale-105 opacity-38 animasi-nafas">
    </div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-b from-black/78 via-[#0B0B0F]/64 to-black/90"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 w-10 bg-gradient-to-l from-black/55 to-transparent z-30"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-5 xl:inset-7 {{ $tampilBarDemo ? 'top-18 xl:top-20' : '' }} rounded-xl border border-[#D4AF37]/24 z-10"></div>

    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'debu-emas', 'konteks' => 'panggung'])

    <div class="lapis-3d relative z-20 w-full max-w-[270px] xl:max-w-[330px] mx-auto px-6 flex flex-col items-center justify-center text-center text-[#F5EFE6]" style="--depth: 8px; --pz: 20px;">
        <div class="h-16 xl:h-18 flex items-center justify-center">
            <img src="{{ $asetNoir['emas'] }}" alt="" class="w-12 xl:w-14 opacity-95 animasi-ayun-3d">
        </div>

        <p class="mt-4 text-[10px] xl:text-[11px] font-semibold uppercase tracking-[0.38em] text-[#D4AF37]">
            The Grand Celebration
        </p>

        <h2 class="mt-3 noir-font-judul text-3xl xl:text-4xl 2xl:text-5xl font-bold leading-tight tracking-wider text-white drop-shadow">
            <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
            <span class="block font-kaligrafi font-normal text-3xl xl:text-4xl text-[#D4AF37] my-0.5">&amp;</span>
            <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
        </h2>

        <div class="my-5 flex items-center justify-center gap-3 w-full max-w-[140px]" aria-hidden="true">
            <span class="h-px flex-1 bg-[#D4AF37]/45"></span>
            <span class="w-1.5 h-1.5 rotate-45 bg-[#D4AF37]"></span>
            <span class="h-px flex-1 bg-[#D4AF37]/45"></span>
        </div>

        <p class="text-[10px] xl:text-[11px] font-medium uppercase tracking-[0.24em] text-[#F5EFE6]/85">
            {{ $tanggalLengkap }}
        </p>
    </div>
</aside>
