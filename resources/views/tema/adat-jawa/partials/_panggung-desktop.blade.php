{{-- PANGGUNG VISUAL DESKTOP KIRI: ADAT JAWA KERATON (BERSIH & SEJAJAR TENGAH) --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 min-w-0 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d items-center justify-center bg-[#2B180F] {{ $tampilBarDemo ? 'pt-14' : '' }}"
>
    {{-- Latar Atmosferik Halus --}}
    <div class="lapis-3d absolute -inset-4 pointer-events-none" style="--depth: -12px; --pz: -36px;">
        <img
            src="{{ $urlFotoLatar }}"
            alt="Ilustrasi Adat Jawa Keraton"
            class="w-full h-full object-cover object-center scale-105 opacity-45 animasi-nafas"
        >
    </div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-b from-[#2B180F]/72 via-[#3B2316]/58 to-[#24130B]/82"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 w-10 bg-gradient-to-l from-black/40 to-transparent z-30"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-5 xl:inset-7 {{ $tampilBarDemo ? 'top-18 xl:top-20' : '' }} rounded-3xl border border-[#D7BB83]/22 z-10"></div>

    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'wayang-flora', 'konteks' => 'panggung'])

    {{-- Konten Utama Rata Tengah Vertikal & Horizontal --}}
    <div class="lapis-3d relative z-20 w-full max-w-[270px] xl:max-w-[330px] mx-auto px-6 flex flex-col items-center justify-center text-center text-[#FAF3E6]" style="--depth: 8px; --pz: 20px;">
        <div class="h-14 xl:h-16 flex items-center justify-center">
            <img
                src="{{ $asetJawa['gununganKecil'] }}"
                alt=""
                class="w-11 xl:w-13 opacity-95 drop-shadow-[0_8px_18px_rgba(0,0,0,0.45)] animasi-ayun-3d"
            >
        </div>

        <p class="mt-4 text-[10px] xl:text-[11px] font-semibold uppercase tracking-[0.36em] text-[#E5CE9A]">
            The Wedding Of
        </p>

        <h2 class="mt-3 font-kaligrafi text-3xl xl:text-4xl 2xl:text-[2.75rem] font-normal leading-[1.18] text-white drop-shadow-[0_4px_14px_rgba(20,10,5,0.65)]">
            <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
            <span class="block text-xl xl:text-2xl text-[#D7BB83] my-0.5">&amp;</span>
            <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
        </h2>

        <div class="my-5 flex items-center justify-center gap-3 w-full max-w-[140px]" aria-hidden="true">
            <span class="h-px flex-1 bg-[#D7BB83]/45"></span>
            <span class="w-1.5 h-1.5 rotate-45 bg-[#E5CE9A]"></span>
            <span class="h-px flex-1 bg-[#D7BB83]/45"></span>
        </div>

        <p class="text-[10px] xl:text-[11px] font-medium uppercase tracking-[0.24em] text-[#FAF3E6]/85">
            {{ $tanggalLengkap }}
        </p>
    </div>
</aside>
