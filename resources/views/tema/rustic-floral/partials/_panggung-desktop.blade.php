{{-- PANGGUNG VISUAL DESKTOP KIRI: RUSTIC FLORAL BOTANICAL SCRAPBOOK --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d bg-[#394D44]"
>
    <div class="lapis-3d absolute -inset-5 pointer-events-none" style="--depth: -14px; --pz: -40px;">
        <img src="{{ $urlFotoLatar }}" alt="Rustic Floral" class="w-full h-full object-cover object-center scale-105 animasi-nafas">
    </div>
    <div class="absolute inset-0 bg-gradient-to-b from-[#2F4037]/65 via-[#3E5349]/40 to-[#24322B]/85"></div>

    <img src="{{ $asetRustic['sudut'] }}" alt="" class="pointer-events-none absolute top-10 left-6 w-28 xl:w-36 opacity-85 animasi-ayun-3d">
    <img src="{{ $asetRustic['sudut'] }}" alt="" class="pointer-events-none absolute top-10 right-6 w-28 xl:w-36 opacity-85 animasi-ayun-3d-balik">

    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'kelopak', 'konteks' => 'panggung'])

    <div class="lapis-3d relative z-20 w-full flex flex-col items-center justify-center text-center px-12 text-[#FDFBF7]" style="--depth: 10px; --pz: 24px;">
        <img src="{{ $asetRustic['sudut'] }}" alt="" class="w-20 mx-auto mb-3 opacity-90 animasi-melayang">
        <p class="text-[11px] font-semibold uppercase tracking-[0.42em] text-[#E5D5C0]">
            The Wedding Of
        </p>
        <h2 class="mt-3 font-serif text-5xl xl:text-6xl font-bold leading-tight text-white">
            {{ $undangan->nama_panggilan_pria }}
            <span class="font-kaligrafi font-normal text-[#E5C99B]">&amp;</span>
            {{ $undangan->nama_panggilan_wanita }}
        </h2>
        <div class="mt-4 flex flex-wrap items-center justify-center gap-3 text-xs uppercase tracking-[0.26em] text-[#FDFBF7]/85">
            <span>{{ $tanggalLengkap }}</span>
            <span class="w-1.5 h-1.5 rounded-full bg-[#B86B4B]"></span>
            <span>{{ $hashtagPasangan }}</span>
        </div>
    </div>
</aside>
