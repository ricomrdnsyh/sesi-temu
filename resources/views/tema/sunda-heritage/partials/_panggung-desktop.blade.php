{{-- PANGGUNG VISUAL DESKTOP KIRI: SUNDA SIGER HERITAGE PRIANGAN --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d bg-[#3B1414]"
>
    {{-- Layer 0: Latar Priangan --}}
    <div class="lapis-3d absolute -inset-5 pointer-events-none" style="--depth: -14px; --pz: -40px;">
        <img
            src="{{ $urlFotoLatar }}"
            alt="Latar Sunda Siger Heritage"
            class="w-full h-full object-cover object-center scale-105 animasi-nafas"
        >
    </div>
    <div class="absolute inset-0 bg-gradient-to-b from-[#3B1414]/65 via-[#4A1717]/40 to-[#2B0E0E]/88"></div>

    {{-- Layer 1: Bingkai Gapura Priangan Ukiran Marun-Emas --}}
    <div class="lapis-3d pointer-events-none absolute inset-0 flex items-center justify-center p-10" style="--depth: 12px; --pz: 20px;">
        <img
            src="{{ $asetSunda['gapura'] }}"
            alt=""
            class="h-[88%] max-h-[760px] w-auto object-contain opacity-92"
        >
    </div>

    {{-- Layer 2: Ronce Melati Gantung Kiri & Kanan (Inline SVG Tajam) --}}
    <svg aria-hidden="true" viewBox="0 0 90 280" class="pointer-events-none absolute top-0 left-8 w-16 xl:w-20 opacity-90 z-10 sunda-melati-kiri">
        <g stroke="#E7C87D" stroke-width="1.2" fill="none">
            <path d="M24 0 C22 70 28 150 22 250"/>
            <path d="M54 0 C58 60 50 135 56 215"/>
        </g>
        <g fill="#FFFDF8" stroke="#C59B43" stroke-width="0.7">
            <circle cx="24" cy="24" r="5"/><circle cx="23" cy="46" r="4.5"/><circle cx="25" cy="70" r="5.5"/><circle cx="24" cy="96" r="4.5"/><circle cx="26" cy="122" r="5"/><circle cx="24" cy="148" r="4.5"/><circle cx="23" cy="176" r="5"/><circle cx="22" cy="204" r="4.5"/><circle cx="22" cy="232" r="5"/>
            <circle cx="54" cy="30" r="4.5"/><circle cx="56" cy="56" r="5"/><circle cx="53" cy="84" r="4.5"/><circle cx="52" cy="112" r="5"/><circle cx="54" cy="140" r="4.5"/><circle cx="56" cy="168" r="5"/><circle cx="56" cy="196" r="4.5"/>
        </g>
        <path d="M17 248 L22 272 L27 248 Z" fill="#C59B43"/>
        <path d="M51 212 L56 234 L61 212 Z" fill="#C59B43"/>
    </svg>
    <svg aria-hidden="true" viewBox="0 0 90 280" class="pointer-events-none absolute top-0 right-8 w-16 xl:w-20 opacity-90 z-10 sunda-melati-kanan">
        <g stroke="#E7C87D" stroke-width="1.2" fill="none">
            <path d="M24 0 C22 70 28 150 22 250"/>
            <path d="M54 0 C58 60 50 135 56 215"/>
        </g>
        <g fill="#FFFDF8" stroke="#C59B43" stroke-width="0.7">
            <circle cx="24" cy="24" r="5"/><circle cx="23" cy="46" r="4.5"/><circle cx="25" cy="70" r="5.5"/><circle cx="24" cy="96" r="4.5"/><circle cx="26" cy="122" r="5"/><circle cx="24" cy="148" r="4.5"/><circle cx="23" cy="176" r="5"/><circle cx="22" cy="204" r="4.5"/><circle cx="22" cy="232" r="5"/>
            <circle cx="54" cy="30" r="4.5"/><circle cx="56" cy="56" r="5"/><circle cx="53" cy="84" r="4.5"/><circle cx="52" cy="112" r="5"/><circle cx="54" cy="140" r="4.5"/><circle cx="56" cy="168" r="5"/><circle cx="56" cy="196" r="4.5"/>
        </g>
        <path d="M17 248 L22 272 L27 248 Z" fill="#C59B43"/>
        <path d="M51 212 L56 234 L61 212 Z" fill="#C59B43"/>
    </svg>

    {{-- Partikel Kelopak Melati, Awan & Burung --}}
    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'melati-burung', 'konteks' => 'panggung'])

    {{-- Layer 3: Tipografi Pasangan di Tengah Gapura --}}
    <div class="lapis-3d relative z-20 w-full flex flex-col items-center justify-center text-center px-12 pt-16 text-white" style="--depth: 10px; --pz: 24px;">
        <img
            src="{{ $asetSunda['siger'] }}"
            alt=""
            class="w-20 xl:w-24 mx-auto mb-3 opacity-95 animasi-ayun-3d"
        >
        <p class="text-[11px] font-semibold uppercase tracking-[0.4em] text-[#F3E5AB]">
            Sampurasun &bull; Sunda Heritage
        </p>
        <h2 class="mt-3 font-serif text-5xl xl:text-6xl font-bold leading-tight text-white">
            {{ $undangan->nama_panggilan_pria }}
            <span class="font-kaligrafi font-normal text-[#E7C87D]">&amp;</span>
            {{ $undangan->nama_panggilan_wanita }}
        </h2>
        <div class="mt-4 flex flex-wrap items-center justify-center gap-3 text-xs uppercase tracking-[0.26em] text-[#FAF4E8]/90">
            <span>{{ $tanggalLengkap }}</span>
            <span class="w-1.5 h-1.5 rounded-full bg-[#C59B43]"></span>
            <span>{{ $hashtagPasangan }}</span>
        </div>
    </div>
</aside>
