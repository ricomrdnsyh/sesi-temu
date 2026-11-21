{{-- PANGGUNG VISUAL DESKTOP KIRI: LUXURY NOIR ART DECO GALA --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d bg-[#09090D]"
>
    {{-- Layer 0: Latar Ballroom Obsidian --}}
    <div class="lapis-3d absolute -inset-5 pointer-events-none" style="--depth: -14px; --pz: -40px;">
        <img src="{{ $urlFotoLatar }}" alt="Luxury Noir Gala" class="w-full h-full object-cover object-center scale-105 animasi-nafas">
    </div>
    <div class="absolute inset-0 bg-gradient-to-b from-black/75 via-black/45 to-black/92"></div>

    {{-- Layer 1: Bingkai Art Deco Emas Geometris --}}
    <div class="lapis-3d pointer-events-none absolute inset-0 flex items-center justify-center p-10" style="--depth: 12px; --pz: 20px;">
        <img src="{{ $asetNoir['bingkai'] }}" alt="" class="h-[88%] max-h-[760px] w-auto object-contain opacity-92">
    </div>

    {{-- Partikel Debu Emas Mengambang --}}
    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'debu-emas', 'konteks' => 'panggung'])

    {{-- Layer 2: Tipografi Gala & Monogram Orbit --}}
    <div class="lapis-3d relative z-20 w-full flex flex-col items-center justify-center text-center px-12 text-[#F5EFE6]" style="--depth: 10px; --pz: 24px;">
        <div class="relative w-24 h-24 flex items-center justify-center mb-4">
            <span class="absolute inset-0 rounded-full border border-dashed border-[#D4AF37]/65 animasi-orbit"></span>
            <span class="absolute inset-2 rounded-full border border-[#F3E5AB]/55 animasi-orbit-balik"></span>
            <span class="noir-font-judul text-lg font-bold tracking-widest text-[#F3E5AB]">{{ $undangan->inisialPria() }}&amp;{{ $undangan->inisialWanita() }}</span>
        </div>

        <p class="text-[11px] font-semibold uppercase tracking-[0.44em] text-[#D4AF37]">
            The Grand Celebration
        </p>
        <h2 class="mt-3 noir-font-judul text-5xl xl:text-6xl font-bold leading-tight tracking-wider text-white">
            {{ $undangan->nama_panggilan_pria }}
            <span class="font-kaligrafi font-normal text-[#D4AF37] mx-1">&amp;</span>
            {{ $undangan->nama_panggilan_wanita }}
        </h2>
        <div class="mt-4 flex flex-wrap items-center justify-center gap-3 text-xs uppercase tracking-[0.28em] text-[#F5EFE6]/85">
            <span>{{ $tanggalLengkap }}</span>
            <span class="w-1.5 h-1.5 rotate-45 bg-[#D4AF37]"></span>
            <span>{{ $hashtagPasangan }}</span>
        </div>
    </div>
</aside>
