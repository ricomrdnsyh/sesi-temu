{{-- PANGGUNG VISUAL DESKTOP KIRI: ROYAL IVORY CATHEDRAL --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d bg-[#4A3826]"
>
    <div class="lapis-3d absolute -inset-5 pointer-events-none" style="--depth: -14px; --pz: -40px;">
        <img src="{{ $urlFotoLatar }}" alt="Royal Ivory Cathedral" class="w-full h-full object-cover object-center scale-105 animasi-nafas">
    </div>
    <div class="absolute inset-0 bg-gradient-to-b from-[#3B2E25]/62 via-[#58432B]/35 to-[#2D2118]/86"></div>

    {{-- Bingkai Katedral Ganda --}}
    <div aria-hidden="true" class="pointer-events-none absolute inset-8 rounded-t-[16rem] rounded-b-3xl border border-[#E5C99B]/45"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-11 rounded-t-[15rem] rounded-b-2xl border border-dashed border-[#E5C99B]/35"></div>

    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'katedral-cahaya', 'konteks' => 'panggung'])

    <div class="lapis-3d relative z-20 w-full flex flex-col items-center justify-center text-center px-12 text-[#FAF6EE]" style="--depth: 10px; --pz: 24px;">
        <img src="{{ $asetRoyal['katedral'] }}" alt="" class="w-20 xl:w-24 mx-auto mb-3 opacity-95 animasi-ayun-3d">
        <p class="text-[11px] font-semibold uppercase tracking-[0.42em] text-[#E5C99B]">
            The Royal Wedding
        </p>
        <h2 class="mt-3 font-serif text-5xl xl:text-6xl font-bold leading-tight text-white">
            {{ $undangan->nama_panggilan_pria }}
            <span class="font-kaligrafi font-normal text-[#E5C99B]">&amp;</span>
            {{ $undangan->nama_panggilan_wanita }}
        </h2>
        <div class="mt-5 w-14 h-14 rounded-full bg-[#9E7B4F] border-2 border-[#E5C99B] shadow-xl flex items-center justify-center animasi-segel">
            <span class="font-serif text-sm font-bold tracking-widest text-[#FAF6EE]">{{ $undangan->inisialPria() }}&amp;{{ $undangan->inisialWanita() }}</span>
        </div>
        <div class="mt-4 flex flex-wrap items-center justify-center gap-3 text-xs uppercase tracking-[0.26em] text-[#FAF6EE]/85">
            <span>{{ $tanggalLengkap }}</span>
            <span class="w-1.5 h-1.5 rounded-full bg-[#E5C99B]"></span>
            <span>{{ $hashtagPasangan }}</span>
        </div>
    </div>
</aside>
