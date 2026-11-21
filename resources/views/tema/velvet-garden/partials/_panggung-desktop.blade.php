{{-- PANGGUNG VISUAL DESKTOP KIRI: VELVET GARDEN CONSERVATORY --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d bg-[#132623]"
>
    {{-- Layer 0: Latar Taman Senja --}}
    <div class="lapis-3d absolute -inset-5 pointer-events-none" style="--depth: -14px; --pz: -40px;">
        <img src="{{ $urlFotoLatar }}" alt="Velvet Garden Conservatory" class="w-full h-full object-cover object-center scale-105 animasi-nafas">
    </div>
    <div class="absolute inset-0 bg-gradient-to-b from-[#0E1E18]/72 via-[#132623]/42 to-[#0A1712]/90"></div>

    {{-- Layer 1: Lengkungan Konservatori Kuningan & Mawar Gading --}}
    <div class="lapis-3d pointer-events-none absolute inset-0 flex items-center justify-center p-10" style="--depth: 12px; --pz: 20px;">
        <img src="{{ $asetGarden['konservatori'] }}" alt="" class="h-[88%] max-h-[760px] w-auto object-contain opacity-95">
    </div>

    {{-- Kelopak 3D & Kunang-kunang Senja --}}
    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'kelopak-kunang', 'konteks' => 'panggung'])

    {{-- Layer 2: Tipografi Konservatori --}}
    <div class="lapis-3d relative z-20 w-full flex flex-col items-center justify-center text-center px-12 text-[#F4F8F6]" style="--depth: 10px; --pz: 24px;">
        <img src="{{ $asetGarden['botani'] }}" alt="" class="w-20 xl:w-24 mx-auto mb-3 opacity-95 animasi-ayun-3d">
        <p class="text-[11px] font-semibold uppercase tracking-[0.4em] text-[#C8A464]">
            Velvet Garden Motion
        </p>
        <h2 class="mt-3 font-serif text-5xl xl:text-6xl font-bold leading-tight text-white">
            {{ $undangan->nama_panggilan_pria }}
            <span class="font-kaligrafi font-normal text-[#EEDAD4]">&amp;</span>
            {{ $undangan->nama_panggilan_wanita }}
        </h2>
        <div class="mt-4 flex flex-wrap items-center justify-center gap-3 text-xs uppercase tracking-[0.26em] text-[#F4F8F6]/85">
            <span>{{ $tanggalLengkap }}</span>
            <span class="w-1.5 h-1.5 rounded-full bg-[#C8A464]"></span>
            <span>{{ $hashtagPasangan }}</span>
        </div>
    </div>
</aside>
