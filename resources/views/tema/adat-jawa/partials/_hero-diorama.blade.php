{{-- SEKSI 2: PANGGUNG HERO DIORAMA 3D MULTI-LAPIS PENUH 1 LAYAR (KOREOGRAFI PEMBUKAAN) --}}
<section
    data-diorama-3d="{{ $tierAktif }}"
    class="relative h-dvh min-h-[680px] max-h-[960px] w-full overflow-hidden diorama-panggung-3d bg-[#D9C3B0]"
>
    <div class="relative w-full h-full diorama-kamera-3d">
        {{-- Z-0: Lukisan Hutan & Pegunungan Vintage / Foto Latar Custom (Camera Dolly Zoom-Out 60fps) --}}
        <div class="lapis-paralaks-scroll absolute -inset-5 pointer-events-none" style="--sp: 0.05; --pz: 0px;">
            <img
                src="{{ $urlFotoLatar }}"
                alt="Latar Hutan Adat Jawa Keraton"
                class="w-full h-full object-cover object-center"
                :class="undanganTerbuka ? 'jawa-latar-dolly' : ''"
            >
        </div>

        {{-- Z-1: Sinar Hangat + Kawanan Burung Terbang + Kupu-Kupu Emas 3D --}}
        <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden z-10">
            <div class="absolute -top-20 left-[15%] w-40 h-[120%] bg-gradient-to-b from-[#FFF6DF]/20 via-[#F3E5AB]/6 to-transparent blur-lg animasi-sinar"></div>

            {{-- Kawanan Burung Melintasi Langit --}}
            <div class="absolute top-[24%] left-0 jawa-burung-terbang animasi-burung text-[#472A1C]/75" style="animation-delay: 0.3s;">
                <svg class="w-16 h-10 animasi-kepak" viewBox="0 0 80 44" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                    <path d="M4 26 Q10 18 16 24 Q22 18 28 26"/>
                    <path d="M26 16 Q31 10 36 15 Q41 10 46 16"/>
                    <path d="M46 28 Q52 21 57 26 Q62 21 68 28"/>
                    <path d="M58 12 Q62 7 66 11 Q70 7 74 12"/>
                </svg>
            </div>
            <div class="absolute top-[36%] left-0 jawa-burung-terbang animasi-burung text-[#472A1C]/55" style="animation-delay: 5.5s; animation-duration: 18s;">
                <svg class="w-12 h-8 animasi-kepak" viewBox="0 0 60 36" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round">
                    <path d="M4 22 Q10 14 16 20 Q22 14 28 22"/>
                    <path d="M30 14 Q36 8 42 13 Q48 8 54 14"/>
                </svg>
            </div>

            {{-- Sepasang Kupu-Kupu Emas 3D --}}
            <div class="absolute top-[45%] left-0 animasi-kupu-3d text-[#C78F3E]" style="animation-delay: 1s;">
                <svg class="w-7 h-6 animasi-sayap-kupu" viewBox="0 0 32 26" fill="currentColor">
                    <path d="M16 12 C11 2, 2 3, 3 11 C4 16, 10 16, 15 14 C10 16, 5 21, 9 24 C13 26, 15 20, 16 16 C17 20, 19 26, 23 24 C27 21, 22 16, 17 14 C22 16, 28 16, 29 11 C30 3, 21 2, 16 12 Z"/>
                </svg>
            </div>
            <div class="absolute top-[56%] left-0 animasi-kupu-3d text-[#E5B869]" style="animation-delay: 6.2s; animation-duration: 16s;">
                <svg class="w-5 h-5 animasi-sayap-kupu" viewBox="0 0 32 26" fill="currentColor">
                    <path d="M16 12 C11 2, 2 3, 3 11 C4 16, 10 16, 15 14 C10 16, 5 21, 9 24 C13 26, 15 20, 16 16 C17 20, 19 26, 23 24 C27 21, 22 16, 17 14 C22 16, 28 16, 29 11 C30 3, 21 2, 16 12 Z"/>
                </svg>
            </div>
        </div>

        {{-- Z-2: Bingkai Ukiran Emas Keraton + Nama Mempelai Mekar di Tengah Atas --}}
        <div
            class="absolute top-[4%] inset-x-3 sm:inset-x-5 h-[69%] z-20 flex items-center justify-center"
            :class="undanganTerbuka ? 'jawa-bingkai-masuk' : 'opacity-0'"
        >
            <div class="relative w-full max-w-[355px] aspect-[828/1129] flex items-center justify-center">
                {{-- Medali Sogan Transparan di Dalam Lubang Bingkai --}}
                <div
                    aria-hidden="true"
                    class="absolute inset-x-[13%] inset-y-[11%] rounded-[50%] bg-[#472A1C]/86 shadow-[inset_0_0_40px_rgba(215,187,131,0.22)]"
                ></div>

                {{-- Bingkai Ukiran Emas Asli --}}
                <img
                    src="{{ $asetJawa['bingkaiUkiran'] }}"
                    alt=""
                    aria-hidden="true"
                    class="pointer-events-none absolute inset-0 w-full h-full object-contain z-10"
                >

                {{-- Tipografi Pasangan di Dalam Bingkai --}}
                <div
                    class="relative z-20 px-12 pb-10 text-center space-y-1.5"
                    :class="undanganTerbuka ? 'jawa-teks-masuk' : 'opacity-0'"
                >
                    <p class="font-kaligrafi text-2xl sm:text-[1.75rem] text-white/95">
                        The Wedding of
                    </p>
                    <h2 class="font-serif text-3xl sm:text-[2.35rem] font-semibold uppercase tracking-[0.12em] leading-[1.08] text-[#D7BB83]">
                        <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
                        <span class="block font-kaligrafi normal-case text-3xl text-[#F3E5AB] my-0.5">&amp;</span>
                        <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
                    </h2>
                    <p class="text-[11px] font-semibold tracking-[0.34em] text-white/95 pt-1">
                        {{ $tanggalTitik }}
                    </p>
                    <p class="text-[11px] font-medium tracking-[0.14em] text-[#F3E5AB]/95">
                        {{ $hashtagPasangan }}
                    </p>

                    {{-- Indikator Gulir Mouse Animasi --}}
                    <div aria-hidden="true" class="pt-3 flex flex-col items-center gap-1">
                        <div class="w-5 h-8 rounded-full border-2 border-white/80 flex justify-center pt-1.5">
                            <span class="w-1 h-1.5 rounded-full bg-[#F3E5AB] animasi-gulir-roda"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Z-3: Janur Kuning Kiri & Kanan Melengkung Berayun --}}
        <img
            src="{{ $asetJawa['janur'] }}"
            alt=""
            aria-hidden="true"
            class="pointer-events-none absolute bottom-[15%] -left-5 w-32 sm:w-40 z-30"
            :class="undanganTerbuka ? 'jawa-janur-kiri' : 'opacity-0'"
        >
        <img
            src="{{ $asetJawa['janur'] }}"
            alt=""
            aria-hidden="true"
            class="pointer-events-none absolute bottom-[15%] -right-5 w-32 sm:w-40 z-30"
            :class="undanganTerbuka ? 'jawa-janur-kanan' : 'opacity-0'"
        >

        {{-- Z-4: Pendopo Joglo Ukir di Tengah Bawah --}}
        <div
            class="pointer-events-none absolute bottom-[5%] inset-x-0 flex justify-center z-30"
            :class="undanganTerbuka ? 'jawa-pendopo-masuk' : 'opacity-0'"
        >
            <img
                src="{{ $asetJawa['pendopo'] }}"
                alt="Pendopo Joglo Keraton"
                class="w-[86%] max-w-[380px]"
            >
        </div>

        {{-- Z-5: Hamparan Bunga Mawar Peach/Blush Foreground Bawah --}}
        <img
            src="{{ $asetJawa['bungaDepan'] }}"
            alt=""
            aria-hidden="true"
            class="pointer-events-none absolute -bottom-1 inset-x-0 w-full z-40"
            :class="undanganTerbuka ? 'jawa-bunga-masuk' : 'opacity-0'"
        >

        {{-- Z-6: Gerbang Gunungan Emas Raksasa Menyapu Melewati Kamera Saat Undangan Dibuka --}}
        <img
            src="{{ $asetJawa['gununganBuka'] }}"
            alt=""
            aria-hidden="true"
            class="pointer-events-none absolute top-[6%] -left-10 w-[76%] max-w-[340px] z-50"
            :class="undanganTerbuka ? 'jawa-sapu-kiri' : 'opacity-0'"
        >
        <img
            src="{{ $asetJawa['gununganBuka'] }}"
            alt=""
            aria-hidden="true"
            class="pointer-events-none absolute top-[6%] -right-10 w-[76%] max-w-[340px] z-50"
            :class="undanganTerbuka ? 'jawa-sapu-kanan' : 'opacity-0'"
        >
    </div>
</section>
