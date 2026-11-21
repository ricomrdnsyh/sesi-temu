{{-- SEKSI 1: HERO DIORAMA GAPURA PRIANGAN & RONCE MELATI --}}
<section
    data-diorama-3d="{{ $tierAktif }}"
    class="relative min-h-[96dvh] px-3.5 py-4 flex items-stretch overflow-hidden bg-[#3B1414]"
>
    <div class="relative w-full min-h-[calc(96dvh-2rem)] rounded-t-[9rem] rounded-b-3xl border-2 border-[#C59B43]/75 overflow-hidden shadow-2xl bg-[#2B0E0E]">
        <div class="relative w-full h-full flex flex-col justify-between diorama-kamera-3d">
            {{-- Z-0: Latar Utama --}}
            <div class="absolute inset-0 pointer-events-none">
                <img
                    src="{{ $urlFotoLatar }}"
                    alt="Priangan Heritage"
                    class="w-full h-full object-cover object-center"
                >
                <div class="absolute inset-0 bg-gradient-to-b from-[#3B1414]/78 via-[#4A1717]/35 to-[#2B0E0E]/92"></div>
            </div>

            {{-- Z-1: Gapura Priangan Transparan Memeluk Panggung --}}
            <div
                class="pointer-events-none absolute inset-x-1 top-3 bottom-2 flex items-center justify-center z-10"
                :class="undanganTerbuka ? 'sunda-gapura-masuk' : 'opacity-0'"
            >
                <img
                    src="{{ $asetSunda['gapura'] }}"
                    alt=""
                    class="w-full h-full object-contain opacity-95"
                >
            </div>

            {{-- Z-2: Ronce Melati Kiri & Kanan Bergoyang Halus --}}
            <svg aria-hidden="true" viewBox="0 0 80 240" class="pointer-events-none absolute top-0 left-2 w-12 z-20 opacity-90 sunda-melati-kiri">
                <path d="M22 0 C20 65 26 140 20 215" stroke="#E7C87D" stroke-width="1.2" fill="none"/>
                <path d="M48 0 C52 55 44 120 48 180" stroke="#E7C87D" stroke-width="1" fill="none"/>
                <g fill="#FFFDF8" stroke="#C59B43" stroke-width="0.6">
                    <circle cx="22" cy="24" r="4.5"/><circle cx="21" cy="48" r="4"/><circle cx="23" cy="74" r="5"/><circle cx="22" cy="100" r="4"/><circle cx="24" cy="128" r="4.5"/><circle cx="21" cy="156" r="4"/><circle cx="20" cy="184" r="4.5"/>
                    <circle cx="48" cy="28" r="4"/><circle cx="49" cy="54" r="4.5"/><circle cx="47" cy="82" r="4"/><circle cx="46" cy="110" r="4.5"/><circle cx="48" cy="138" r="4"/><circle cx="48" cy="162" r="4"/>
                </g>
                <path d="M16 212 L20 232 L24 212 Z" fill="#C59B43"/>
            </svg>
            <svg aria-hidden="true" viewBox="0 0 80 240" class="pointer-events-none absolute top-0 right-2 w-12 z-20 opacity-90 sunda-melati-kanan">
                <path d="M22 0 C20 65 26 140 20 215" stroke="#E7C87D" stroke-width="1.2" fill="none"/>
                <path d="M48 0 C52 55 44 120 48 180" stroke="#E7C87D" stroke-width="1" fill="none"/>
                <g fill="#FFFDF8" stroke="#C59B43" stroke-width="0.6">
                    <circle cx="22" cy="24" r="4.5"/><circle cx="21" cy="48" r="4"/><circle cx="23" cy="74" r="5"/><circle cx="22" cy="100" r="4"/><circle cx="24" cy="128" r="4.5"/><circle cx="21" cy="156" r="4"/><circle cx="20" cy="184" r="4.5"/>
                    <circle cx="48" cy="28" r="4"/><circle cx="49" cy="54" r="4.5"/><circle cx="47" cy="82" r="4"/><circle cx="46" cy="110" r="4.5"/><circle cx="48" cy="138" r="4"/><circle cx="48" cy="162" r="4"/>
                </g>
                <path d="M16 212 L20 232 L24 212 Z" fill="#C59B43"/>
            </svg>

            {{-- Partikel Melati, Awan & Burung --}}
            @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'melati-burung', 'konteks' => 'utama'])

            {{-- Z-3: Konten Tipografi Tengah Gapura (Ditempatkan di Ruang Terbuka Tengah Gapura) --}}
            <div class="relative z-20 flex-1 flex flex-col justify-between px-12 pt-5 pb-6 text-center text-white">
                <div class="space-y-1">
                    <img src="{{ $asetSunda['siger'] }}" alt="" class="w-12 mx-auto opacity-95 animasi-ayun-3d">
                    <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#F3E5AB]">
                        Wilujeng Sumping
                    </p>
                </div>

                <div class="my-auto pt-16 pb-4">
                    <div class="mx-auto max-w-[235px] rounded-3xl bg-[#2B0E0E]/68 border border-[#C59B43]/45 px-4 py-4 shadow-xl space-y-1.5">
                        <p class="text-[9px] uppercase tracking-[0.26em] text-[#F3E5AB]/90">
                            We Are Getting Married!
                        </p>
                        <h2 class="font-serif text-3xl sm:text-4xl font-bold leading-[1.08] text-white">
                            {{ $undangan->nama_panggilan_pria }}
                            <span class="block font-kaligrafi text-2xl sm:text-3xl font-normal text-[#E7C87D] my-0.5">&amp;</span>
                            {{ $undangan->nama_panggilan_wanita }}
                        </h2>
                        <p class="pt-0.5 text-[11px] font-semibold uppercase tracking-[0.28em] text-[#F3E5AB]">
                            {{ $tanggalTitik }}
                        </p>
                        <p class="text-[10px] tracking-[0.14em] text-white/90 break-all">
                            {{ $hashtagPasangan }}
                        </p>
                    </div>
                </div>

                {{-- Awan Mega Mendung Emas + Indikator Gulir --}}
                <div class="pt-6 space-y-3">
                    <div aria-hidden="true" class="mx-auto w-5 h-8 rounded-full border border-[#F3E5AB]/70 flex justify-center pt-1.5">
                        <span class="w-1 h-1.5 rounded-full bg-[#F3E5AB] animasi-gulir-roda"></span>
                    </div>
                    <svg aria-hidden="true" viewBox="0 0 360 44" class="w-full max-w-[260px] mx-auto opacity-85 animasi-awan">
                        <path d="M10 34 C35 12 72 12 96 26 C115 8 156 6 180 22 C204 6 245 8 264 26 C288 12 325 12 350 34" fill="none" stroke="#E7C87D" stroke-width="2" stroke-linecap="round"/>
                        <path d="M40 38 C68 20 105 22 132 32 C154 16 206 16 228 32 C255 22 292 20 320 38" fill="none" stroke="#C59B43" stroke-width="1.3" stroke-linecap="round" opacity="0.8"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- MARQUEE TICKER PRIANGAN --}}
<div class="py-2.5 bg-[#5A1E1E] border-y border-[#C59B43]/50 overflow-hidden">
    <div class="animasi-marquee flex items-center gap-6 text-[11px] font-semibold uppercase tracking-[0.3em] text-[#F3E5AB]">
        @for ($i = 0; $i < 4; $i++)
            <span>Sampurasun</span>
            <span>&#10022;</span>
            <span>{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</span>
            <span>&#10022;</span>
            <span>{{ $tanggalTitik }}</span>
            <span>&#10022;</span>
            <span>{{ $hashtagPasangan }}</span>
            <span>&#10022;</span>
        @endfor
    </div>
</div>

{{-- SEKSI 2: PRELUDE PRIANGAN, MONOGRAM BERTEMU, FOTO PEMBUKA & PETUAH SUNDA --}}
<section
    data-section-pembuka="priangan"
    class="relative bg-[#5A1E1E] text-[#FAF4E8] px-5 py-12 overflow-hidden"
>
    <div class="max-w-md mx-auto text-center space-y-6">
        {{-- Monogram Pasangan Bertemu Kiri <-> Kanan --}}
        <div class="grid grid-cols-3 items-center max-w-[210px] mx-auto">
            <span class="fx-slide-left font-serif text-4xl sm:text-5xl font-bold text-[#E7C87D]">
                {{ $undangan->inisialPria() }}
            </span>
            <span class="fx-scale-in font-kaligrafi text-3xl text-[#FAF4E8]/85">&amp;</span>
            <span class="fx-slide-right font-serif text-4xl sm:text-5xl font-bold text-[#E7C87D]">
                {{ $undangan->inisialWanita() }}
            </span>
        </div>

        {{-- Foto Pembuka Berbingkai Oval Emas (Tersembunyi pada Mode Tanpa Foto) --}}
        @if ($urlFotoPembuka)
            <div class="fx-scale-in mx-auto w-56 sm:w-64 p-2 rounded-[999px] border-2 border-[#C59B43]/80 bg-[#3B1414]/60 shadow-2xl">
                <div class="overflow-hidden rounded-[999px] aspect-[4/5] border border-[#F3E5AB]/45">
                    <img
                        src="{{ $urlFotoPembuka }}"
                        alt="Potret Pembuka {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                        class="w-full h-full object-cover object-top"
                    >
                </div>
            </div>
        @endif

        @if ($undangan->kutipan_ayat)
            <blockquote class="fx-rise rounded-3xl bg-[#FFFBF4] text-[#4A2020] border-2 border-[#C59B43]/75 px-6 py-6 shadow-xl kartu-3d">
                <img src="{{ $asetSunda['siger'] }}" alt="" class="w-10 mx-auto mb-2.5 opacity-90">
                <p class="italic text-xs sm:text-sm leading-relaxed text-[#4A2020]/90">
                    &ldquo;{{ $undangan->kutipan_ayat }}&rdquo;
                </p>
            </blockquote>
        @endif
    </div>
</section>
