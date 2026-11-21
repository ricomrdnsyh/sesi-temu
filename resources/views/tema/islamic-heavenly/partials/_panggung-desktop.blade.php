{{-- PANGGUNG VISUAL DESKTOP KIRI: ISLAMIC HEAVENLY CELESTIAL NIGHT --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d bg-[#091322]"
>
    {{-- Layer 0: Langit Malam Berbintang --}}
    <div class="lapis-3d absolute -inset-5 pointer-events-none" style="--depth: -14px; --pz: -40px;">
        <img
            src="{{ $urlFotoLatar }}"
            alt="Latar Islamic Heavenly"
            class="w-full h-full object-cover object-center scale-105 animasi-nafas"
        >
    </div>
    <div class="absolute inset-0 bg-gradient-to-b from-[#091322]/70 via-[#0E1B2A]/45 to-[#060D18]/92"></div>

    {{-- Layer 1: Gerbang Mihrab Emas-Safir --}}
    <div class="lapis-3d pointer-events-none absolute inset-0 flex items-center justify-center p-10" style="--depth: 12px; --pz: 20px;">
        <img src="{{ $asetCelestial['mihrab'] }}" alt="" class="h-[88%] max-h-[760px] w-auto object-contain opacity-92">
    </div>

    {{-- Layer 2: Lentera Fanous Gantung Kiri & Kanan --}}
    <img src="{{ $asetCelestial['lentera'] }}" alt="" class="pointer-events-none absolute -top-2 left-6 w-28 xl:w-36 z-10 opacity-95 celestial-lentera-kiri">
    <img src="{{ $asetCelestial['lentera'] }}" alt="" class="pointer-events-none absolute -top-2 right-6 w-28 xl:w-36 z-10 opacity-95 celestial-lentera-kanan">

    {{-- Lapisan Bintang Jatuh & Gemerlap --}}
    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'bintang', 'konteks' => 'panggung'])

    {{-- Layer 3: Tipografi & Monogram Orbit --}}
    <div class="lapis-3d relative z-20 w-full flex flex-col items-center justify-center text-center px-12 text-[#E6EEF8]" style="--depth: 10px; --pz: 24px;">
        <div class="relative w-24 h-24 flex items-center justify-center mb-3">
            <span class="absolute inset-0 rounded-full border border-dashed border-[#D9B664]/60 animasi-orbit"></span>
            <span class="absolute inset-2 rounded-full border border-[#F3E5AB]/50 animasi-orbit-balik"></span>
            <img src="{{ $asetCelestial['sabit'] }}" alt="" class="w-12 opacity-95 animasi-ayun-3d">
        </div>
        <p class="text-lg text-[#F3E5AB]" style="font-family: 'Amiri', serif;">
            بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
        </p>
        <p class="mt-2 text-[11px] font-semibold uppercase tracking-[0.4em] text-[#D9B664]">
            Walimatul Ursy &bull; Celestial Night
        </p>
        <h2 class="mt-3 font-serif text-5xl xl:text-6xl font-bold leading-tight text-white">
            {{ $undangan->nama_panggilan_pria }}
            <span class="font-kaligrafi font-normal text-[#D9B664]">&amp;</span>
            {{ $undangan->nama_panggilan_wanita }}
        </h2>
        <div class="mt-4 flex flex-wrap items-center justify-center gap-3 text-xs uppercase tracking-[0.26em] text-[#E6EEF8]/85">
            <span>{{ $tanggalLengkap }}</span>
            <span class="w-1.5 h-1.5 rounded-full bg-[#D9B664]"></span>
            <span>{{ $hashtagPasangan }}</span>
        </div>
    </div>
</aside>
