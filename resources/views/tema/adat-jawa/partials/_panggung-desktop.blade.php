<aside data-panggung-3d class="hidden lg:flex lg:flex-1 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d bg-[#3B2316]">
    {{-- Layer Z-0: Lukisan Hutan Sepia-Emas / Foto Latar Custom --}}
    <div class="lapis-3d absolute -inset-4 pointer-events-none" style="--depth: -14px; --pz: -40px;">
        <img
            src="{{ $urlFotoLatar }}"
            alt="Ilustrasi Adat Jawa Keraton"
            class="w-full h-full object-cover object-center scale-105 animasi-nafas"
        >
    </div>

    {{-- Gradasi Sogan Atas & Hangat --}}
    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-0"
        style="background: linear-gradient(180deg, rgba(71,42,28,0.82) 0%, rgba(71,42,28,0.28) 40%, rgba(43,24,15,0.45) 100%);"
    ></div>

    {{-- Layer Z-1: Cahaya Emas Lembut + Kawanan Burung & Kupu-Kupu --}}
    <div aria-hidden="true" class="pointer-events-none absolute top-1/3 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[32rem] h-[32rem] rounded-full bg-[#F3E5AB]/14 blur-3xl"></div>
    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'wayang-flora', 'konteks' => 'panggung'])

    {{-- Layer Z-2: Pendopo Joglo di Tengah Bawah --}}
    <div class="lapis-3d pointer-events-none absolute bottom-8 left-1/2 -translate-x-1/2 w-[26rem] xl:w-[35rem] z-10" style="--depth: 8px; --pz: 16px;">
        <img
            src="{{ $asetJawa['pendopo'] }}"
            alt=""
            class="w-full drop-shadow-[0_24px_34px_rgba(30,15,8,0.55)]"
        >
    </div>

    {{-- Layer Z-3: Janur Kuning Kiri & Kanan Berayun --}}
    <div class="lapis-3d pointer-events-none absolute bottom-12 left-4 xl:left-10 w-40 xl:w-52 z-20" style="--depth: 22px; --pz: 34px;">
        <img
            src="{{ $asetJawa['janur'] }}"
            alt=""
            class="w-full drop-shadow-xl animasi-ayun-3d"
        >
    </div>
    <div class="lapis-3d pointer-events-none absolute bottom-12 right-4 xl:right-10 w-40 xl:w-52 z-20" style="--depth: 22px; --pz: 34px;">
        <img
            src="{{ $asetJawa['janur'] }}"
            alt=""
            class="w-full drop-shadow-xl animasi-ayun-3d-balik"
        >
    </div>

    {{-- Layer Z-4: Hamparan Mawar Foreground Bawah --}}
    <div class="lapis-3d pointer-events-none absolute -bottom-2 inset-x-0 z-30" style="--depth: 30px; --pz: 48px;">
        <img
            src="{{ $asetJawa['bungaDepan'] }}"
            alt=""
            class="w-full max-h-52 object-cover object-top drop-shadow-[0_-10px_24px_rgba(30,15,8,0.35)]"
        >
    </div>

    {{-- Tipografi Pasangan di Langit Atas --}}
    <div class="lapis-3d relative z-20 w-full flex flex-col items-center justify-start pt-10 xl:pt-16 text-center px-10 text-white" style="--depth: 10px; --pz: 22px;">
        <div class="max-w-xl space-y-2">
            <img
                src="{{ $asetJawa['gununganKecil'] }}"
                alt=""
                class="w-14 xl:w-18 mx-auto mb-0.5 opacity-95 drop-shadow-[0_10px_20px_rgba(0,0,0,0.45)] animasi-ayun-3d"
            >
            <p class="text-[11px] font-semibold uppercase tracking-[0.42em] text-[#FFF1C9] drop-shadow-[0_2px_6px_rgba(30,15,8,0.75)]">
                The Wedding Of
            </p>
            <h2 class="font-kaligrafi text-5xl xl:text-6xl font-normal leading-tight text-white drop-shadow-[0_4px_14px_rgba(30,15,8,0.75)]">
                {{ $undangan->nama_panggilan_pria }}
                <span class="text-[#FFF0BE] mx-1">&amp;</span>
                {{ $undangan->nama_panggilan_wanita }}
            </h2>
            <div class="flex flex-wrap items-center justify-center gap-3 pt-0.5 text-xs font-medium uppercase tracking-[0.28em] text-white/95 drop-shadow-[0_2px_8px_rgba(30,15,8,0.85)]">
                <span>{{ $tanggalLengkap }}</span>
                <span class="w-1 h-1 rounded-full bg-[#FFF0BE]"></span>
                <span>{{ $hashtagPasangan }}</span>
            </div>
        </div>
    </div>
</aside>
