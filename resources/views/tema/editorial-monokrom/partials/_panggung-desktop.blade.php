{{-- PANGGUNG VISUAL DESKTOP KIRI: EDITORIAL MONOKROM VOGUE SPREAD --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d bg-[#111113]"
>
    <div class="lapis-3d absolute -inset-5 pointer-events-none" style="--depth: -14px; --pz: -40px;">
        <img src="{{ $urlFotoLatar }}" alt="Editorial Monokrom" class="w-full h-full object-cover object-center grayscale scale-105 animasi-nafas">
    </div>
    <div class="absolute inset-0 bg-gradient-to-b from-black/72 via-black/42 to-black/88"></div>

    {{-- Crop-Mark Swiss Editorial Frame --}}
    <div aria-hidden="true" class="pointer-events-none absolute inset-7 border border-white/30"></div>
    <div class="pointer-events-none absolute top-11 left-12 right-12 flex items-center justify-between text-[10px] uppercase tracking-[0.35em] text-white/80">
        <span>Vol. 01 &bull; Monochrome</span>
        <span>The Wedding Edition</span>
        <span>{{ $tahunAcara }}</span>
    </div>

    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'halus', 'konteks' => 'panggung'])

    <div class="lapis-3d relative z-20 w-full flex flex-col items-start justify-end text-left px-12 pb-16 text-white" style="--depth: 10px; --pz: 24px;">
        <img src="{{ $asetEditorial['bingkai'] }}" alt="" class="w-16 mb-5 opacity-80 invert animasi-ayun-3d">
        <p class="text-[11px] font-semibold uppercase tracking-[0.42em] text-white/75">
            The Wedding Edition
        </p>
        <h2 class="mt-2 ed-serif text-6xl xl:text-7xl font-normal uppercase tracking-[0.06em] leading-[1.02] text-white">
            {{ $undangan->nama_panggilan_pria }}
            <span class="block text-3xl text-white/60 my-1">&amp;</span>
            {{ $undangan->nama_panggilan_wanita }}
        </h2>
        <div class="mt-5 pt-4 border-t border-white/25 w-full flex items-center justify-between text-xs uppercase tracking-[0.26em] text-white/80">
            <span>{{ $tanggalLengkap }}</span>
            <span>{{ $hashtagPasangan }}</span>
        </div>
    </div>
</aside>
