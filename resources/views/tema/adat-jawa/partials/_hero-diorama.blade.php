{{-- SEKSI 2: PANGGUNG HERO VIDEO MOTION ADAT JAWA KERATON (+ DIORAMA 3D FALLBACK / LATAR CUSTOM) --}}
@php
    $pakaiVideoHeroJawa = empty($urlFotoLatarCustom);
    $syaratFallbackAktif = $pakaiVideoHeroJawa ? '(undanganTerbuka && videoHeroGagal)' : 'undanganTerbuka';
@endphp

<section
    data-diorama-3d="{{ $tierAktif }}"
    class="jawa-hero-layar-penuh {{ $tampilBarDemo ? 'dengan-bar-demo' : '' }} relative w-full overflow-hidden diorama-panggung-3d {{ $pakaiVideoHeroJawa ? 'bg-[#3B2316]' : 'bg-[#D9C3B0]' }}"
>
    <div
        class="relative w-full h-full diorama-kamera-3d"
        @if ($pakaiVideoHeroJawa)
            :class="!videoHeroGagal ? 'jawa-kamera-video-aktif' : ''"
        @endif
    >
        {{-- LAPISAN FALLBACK DIORAMA 3D BERLAPIS (HANYA DIRENDER AKTIF BILA LATAR CUSTOM / VIDEO GAGAL) --}}
        <div
            class="absolute inset-0 w-full h-full {{ $pakaiVideoHeroJawa ? 'z-0' : 'z-10' }}"
            @if ($pakaiVideoHeroJawa)
                x-show="videoHeroGagal"
                x-cloak
            @endif
        >
            {{-- Z-0: Lukisan Hutan & Pegunungan Vintage / Foto Latar Custom --}}
            <div class="lapis-paralaks-scroll absolute -inset-5 pointer-events-none" style="--sp: 0.05; --pz: 0px;">
                <img
                    src="{{ $urlFotoLatar }}"
                    alt="Latar Hutan Adat Jawa Keraton"
                    @if ($pakaiVideoHeroJawa) loading="lazy" decoding="async" @endif
                    class="w-full h-full object-cover object-center"
                    :class="{{ $syaratFallbackAktif }} ? 'jawa-latar-dolly' : ''"
                >
            </div>

            {{-- Z-1: Sinar Hangat + Kawanan Burung Terbang + Kupu-Kupu Emas 3D --}}
            <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden z-10">
                <div class="absolute -top-20 left-[15%] w-40 h-[120%] bg-gradient-to-b from-[#FFF6DF]/20 via-[#F3E5AB]/6 to-transparent blur-lg animasi-sinar"></div>

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

                <div class="absolute top-[45%] left-0 animasi-kupu-3d text-[#C78F3E]" style="animation-delay: 1s;">
                    <svg class="w-7 h-6 animasi-sayap-kupu" viewBox="0 0 32 26" fill="currentColor">
                        <path d="M16 12 C11 2, 2 3, 3 11 C4 16, 10 16, 15 14 C10 16, 5 21, 9 24 C13 26, 15 20, 16 16 C17 20, 19 26, 23 24 C27 21, 22 16, 17 14 C22 16, 28 16, 29 11 C30 3, 21 2, 16 12 Z"/>
                    </svg>
                </div>
            </div>

            {{-- Z-2: Bingkai Ukiran Emas Keraton --}}
            <div
                class="absolute top-[4%] inset-x-3 sm:inset-x-5 h-[69%] z-20 flex items-center justify-center"
                :class="{{ $syaratFallbackAktif }} ? 'jawa-bingkai-masuk' : 'opacity-0'"
            >
                <div class="relative w-full max-w-[355px] aspect-[828/1129] flex items-center justify-center">
                    <div
                        aria-hidden="true"
                        class="absolute inset-x-[13%] inset-y-[11%] rounded-[50%] bg-[#472A1C]/86 shadow-[inset_0_0_40px_rgba(215,187,131,0.22)]"
                    ></div>
                    <img
                        src="{{ $asetJawa['bingkaiUkiran'] }}"
                        alt=""
                        aria-hidden="true"
                        @if ($pakaiVideoHeroJawa) loading="lazy" decoding="async" @endif
                        class="pointer-events-none absolute inset-0 w-full h-full object-contain z-10"
                    >
                </div>
            </div>

            {{-- Z-3..Z-6: Janur Kuning, Pendopo Joglo, Mawar Depan & Gerbang Gunungan --}}
            <img
                src="{{ $asetJawa['janur'] }}"
                alt=""
                aria-hidden="true"
                @if ($pakaiVideoHeroJawa) loading="lazy" decoding="async" @endif
                class="pointer-events-none absolute bottom-[15%] -left-5 w-32 sm:w-40 z-30"
                :class="{{ $syaratFallbackAktif }} ? 'jawa-janur-kiri' : 'opacity-0'"
            >
            <img
                src="{{ $asetJawa['janur'] }}"
                alt=""
                aria-hidden="true"
                @if ($pakaiVideoHeroJawa) loading="lazy" decoding="async" @endif
                class="pointer-events-none absolute bottom-[15%] -right-5 w-32 sm:w-40 z-30"
                :class="{{ $syaratFallbackAktif }} ? 'jawa-janur-kanan' : 'opacity-0'"
            >
            <div
                class="pointer-events-none absolute bottom-[5%] inset-x-0 flex justify-center z-30"
                :class="{{ $syaratFallbackAktif }} ? 'jawa-pendopo-masuk' : 'opacity-0'"
            >
                <img src="{{ $asetJawa['pendopo'] }}" alt="Pendopo Joglo Keraton" @if ($pakaiVideoHeroJawa) loading="lazy" decoding="async" @endif class="w-[86%] max-w-[380px]">
            </div>
            <img
                src="{{ $asetJawa['bungaDepan'] }}"
                alt=""
                aria-hidden="true"
                @if ($pakaiVideoHeroJawa) loading="lazy" decoding="async" @endif
                class="pointer-events-none absolute -bottom-1 inset-x-0 w-full z-40"
                :class="{{ $syaratFallbackAktif }} ? 'jawa-bunga-masuk' : 'opacity-0'"
            >
            <img
                src="{{ $asetJawa['gununganBuka'] }}"
                alt=""
                aria-hidden="true"
                @if ($pakaiVideoHeroJawa) loading="lazy" decoding="async" @endif
                class="pointer-events-none absolute top-[6%] -left-10 w-[76%] max-w-[340px] z-50"
                :class="{{ $syaratFallbackAktif }} ? 'jawa-sapu-kiri' : 'opacity-0'"
            >
            <img
                src="{{ $asetJawa['gununganBuka'] }}"
                alt=""
                aria-hidden="true"
                @if ($pakaiVideoHeroJawa) loading="lazy" decoding="async" @endif
                class="pointer-events-none absolute top-[6%] -right-10 w-[76%] max-w-[340px] z-50"
                :class="{{ $syaratFallbackAktif }} ? 'jawa-sapu-kanan' : 'opacity-0'"
            >
        </div>

        {{-- LAPISAN VIDEO MOTION HD ADAT JAWA KERATON (PRE-WARMED DI DETIK 0.72 -> GUNUNGAN LANGSUNG MEMBUKA TANPA JEDA) --}}
        @if ($pakaiVideoHeroJawa)
            <video
                x-ref="heroVideo"
                x-show="!videoHeroGagal"
                src="{{ $asetJawa['videoHero'] }}"
                data-start-at="0.72"
                data-reveal-at="13.15"
                muted
                playsinline
                webkit-playsinline
                preload="auto"
                x-on:timeupdate="pantauVideoHero($event)"
                x-on:ended="selesaiVideoHero()"
                x-on:error="videoHeroGagal = true; teksHeroTampil = true; videoHeroSedangIntro = false;"
                style="transform: translateZ(0);"
                class="absolute inset-0 z-10 w-full h-full object-cover object-center bg-[#3B2316] pointer-events-none select-none"
            ></video>
        @endif

        {{-- OVERLAY TIPOGRAFI MEMPELAI — MUNCUL SINKRON TEPAT DI DALAM BINGKAI EMAS VIDEO (DETIK 13.15) --}}
        <div
            class="absolute inset-x-[16%] top-[18.5%] bottom-[34.5%] z-20 flex flex-col items-center justify-center text-center px-3 jawa-video-teks"
            :class="({{ $pakaiVideoHeroJawa ? 'teksHeroTampil' : 'undanganTerbuka' }}) ? 'opacity-100 scale-100 translate-y-0' : 'opacity-0 scale-95 translate-y-3 pointer-events-none'"
        >
            <div class="space-y-1.5 drop-shadow-[0_3px_14px_rgba(32,18,10,0.65)]">
                <p class="font-kaligrafi text-2xl sm:text-[1.85rem] text-[#FFF8EC] leading-tight">
                    The Wedding of
                </p>

                <h2 class="font-serif text-[2rem] sm:text-[2.45rem] font-semibold uppercase tracking-[0.12em] leading-[1.06] text-[#F3E5AB]">
                    <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
                    <span class="my-0.5 flex items-center justify-center gap-2.5">
                        <span aria-hidden="true" class="h-px w-7 bg-[#D7BB83]/70"></span>
                        <span class="font-kaligrafi normal-case text-3xl text-[#E6C987] leading-none">&amp;</span>
                        <span aria-hidden="true" class="h-px w-7 bg-[#D7BB83]/70"></span>
                    </span>
                    <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
                </h2>

                <p class="text-[11px] font-semibold tracking-[0.34em] text-[#FFFAF5] pt-1.5">
                    {{ $tanggalTitik }}
                </p>
                <p class="text-[10.5px] font-medium tracking-[0.16em] text-[#F3E5AB]/95">
                    {{ $hashtagPasangan }}
                </p>

                {{-- Indikator Gulir Mouse Animasi --}}
                <div aria-hidden="true" class="pt-3 flex flex-col items-center gap-1">
                    <div class="w-4 h-7 rounded-full border-[1.5px] border-[#F3E5AB]/85 flex justify-center pt-1.5">
                        <span class="w-1 h-1.5 rounded-full bg-[#F3E5AB] animasi-gulir-roda"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- KONTROL HALUS: PUTAR ULANG ANIMASI PEMBUKA (SETELAH VIDEO SELESAI) --}}
        @if ($pakaiVideoHeroJawa)
            <button
                type="button"
                x-show="undanganTerbuka && videoHeroSelesai && !videoHeroGagal"
                x-cloak
                x-transition.opacity.duration.400ms
                @click="putarUlangVideoHero()"
                title="Putar ulang animasi pembuka"
                aria-label="Putar ulang animasi pembuka"
                class="absolute bottom-5 left-4 z-30 inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#2B180F]/70 backdrop-blur-md border border-[#D7BB83]/55 text-[#F3E5AB] shadow-md hover:bg-[#472A1C] active:scale-95 transition cursor-pointer"
            >
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M3 12a9 9 0 1 0 3-6.7L3 8"/>
                    <path d="M3 3v5h5"/>
                </svg>
            </button>
        @endif

        {{-- GRADASI HALUS PENYATU TEPI BAWAH HERO KE SEKSI SOGAN KAWUNG --}}
        <div
            aria-hidden="true"
            class="pointer-events-none absolute inset-x-0 bottom-0 h-14 z-20"
            style="background: linear-gradient(180deg, transparent 0%, rgba(71,42,28,0.45) 55%, #472A1C 100%);"
        ></div>
    </div>
</section>
