{{-- SEKSI 1: PANGGUNG VIDEO MOTION HD CELESTIAL NIGHT SANCTUARY (+ FALLBACK DIORAMA MIHRAB OTOMATIS) --}}
@php
    $pakaiVideoHeroCelestial = ! empty($asetCelestial['videoHero']) && empty($urlFotoLatarCustom);
@endphp

<section
    data-diorama-3d="{{ $tierAktif }}"
    data-cinema-duration="3800"
    data-autoscroll-delay="6200"
    class="celestial-hero-layar-penuh relative w-full overflow-hidden diorama-panggung-3d bg-[#091322]"
>
    <div
        class="relative w-full h-full diorama-kamera-3d"
        @if ($pakaiVideoHeroCelestial)
            :class="!videoHeroGagal ? 'celestial-kamera-video-aktif' : ''"
        @endif
    >
        {{-- LAPISAN FALLBACK DIORAMA GERBANG MIHRAB & LENTERA FANOUS (AKTIF SAAT LATAR KUSTOM / VIDEO GAGAL) --}}
        <div
            class="absolute inset-0 w-full h-full px-3.5 py-4 flex items-stretch {{ $pakaiVideoHeroCelestial ? 'z-0' : 'z-10' }}"
            @if ($pakaiVideoHeroCelestial)
                x-show="videoHeroGagal"
                x-cloak
            @endif
        >
            <div class="relative w-full h-full rounded-t-[10.5rem] rounded-b-3xl border-2 border-[#D9B664]/65 overflow-hidden shadow-2xl bg-[#0B1728] flex flex-col justify-between">
                {{-- Z-0: Langit Berbintang --}}
                <div class="absolute inset-0 pointer-events-none">
                    <img
                        src="{{ $urlFotoLatar }}"
                        alt="Islamic Heavenly"
                        @if ($pakaiVideoHeroCelestial) loading="lazy" decoding="async" @endif
                        class="w-full h-full object-cover object-center"
                    >
                    <div class="absolute inset-0 bg-gradient-to-b from-[#091322]/72 via-[#0E1B2A]/35 to-[#060D18]/92"></div>
                </div>

                {{-- Z-1: Gerbang Mihrab Emas-Safir Transparan --}}
                <div
                    class="pointer-events-none absolute inset-x-1 top-2 bottom-2 flex items-center justify-center z-10"
                    :class="undanganTerbuka ? 'celestial-mihrab-masuk' : 'opacity-0'"
                >
                    <img
                        src="{{ $asetCelestial['mihrab'] }}"
                        alt=""
                        @if ($pakaiVideoHeroCelestial) loading="lazy" decoding="async" @endif
                        class="w-full h-full object-contain opacity-95"
                    >
                </div>

                {{-- Z-2: Lentera Fanous Gantung Kiri & Kanan --}}
                <img
                    src="{{ $asetCelestial['lentera'] }}"
                    alt=""
                    @if ($pakaiVideoHeroCelestial) loading="lazy" decoding="async" @endif
                    class="pointer-events-none absolute -top-2 left-1 w-20 sm:w-24 z-20 opacity-95 celestial-lentera-kiri"
                >
                <img
                    src="{{ $asetCelestial['lentera'] }}"
                    alt=""
                    @if ($pakaiVideoHeroCelestial) loading="lazy" decoding="async" @endif
                    class="pointer-events-none absolute -top-2 right-1 w-20 sm:w-24 z-20 opacity-95 celestial-lentera-kanan"
                >

                {{-- Lapisan Bintang Berkedip & Bintang Jatuh --}}
                @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'bintang', 'konteks' => 'utama'])

                {{-- Z-3: Konten Tipografi Tengah Mihrab --}}
                <div class="relative z-20 flex-1 flex flex-col justify-between px-11 pt-6 pb-6 text-center text-[#E6EEF8]">
                    <div class="space-y-1">
                        <p class="text-base text-[#F3E5AB]" style="font-family: 'Amiri', serif;">
                            بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                        </p>
                        <p class="text-[9px] font-semibold uppercase tracking-[0.22em] text-[#D9B664]">
                            Assalamu&rsquo;alaikum Warahmatullahi Wabarakatuh
                        </p>
                    </div>

                    <div class="my-auto pt-16 pb-2 space-y-2">
                        <p class="text-[10px] uppercase tracking-[0.28em] text-[#F3E5AB]/90">
                            We Are Getting Married!
                        </p>
                        <h2 class="font-serif text-4xl sm:text-[2.65rem] font-bold leading-[1.08] text-white">
                            {{ $undangan->nama_panggilan_pria }}
                            <span class="block font-kaligrafi text-3xl font-normal text-[#D9B664] my-0.5">&amp;</span>
                            {{ $undangan->nama_panggilan_wanita }}
                        </h2>
                        <p class="pt-1 text-xs font-semibold uppercase tracking-[0.3em] text-[#F3E5AB]">
                            {{ $tanggalTitik }}
                        </p>
                        <p class="text-[10px] tracking-[0.16em] text-[#D9B664]">
                            {{ $hashtagPasangan }}
                        </p>
                    </div>

                    {{-- Siluet Kubah Masjid Emas-Safir + Emblem Orbit --}}
                    <div class="pt-4 space-y-3">
                        <div class="mx-auto w-14 h-14 relative flex items-center justify-center">
                            <span class="absolute inset-0 rounded-full border border-dashed border-[#D9B664]/70 animasi-orbit"></span>
                            <img src="{{ $asetCelestial['sabit'] }}" alt="" class="h-10 w-auto opacity-95 animasi-ayun-3d">
                        </div>
                        <svg aria-hidden="true" viewBox="0 0 360 56" class="w-full max-w-[280px] mx-auto opacity-85">
                            <path d="M0 54 H360 M36 54 V34 L42 20 L48 34 V54 M312 54 V34 L318 20 L324 34 V54 M96 54 C96 34 118 28 128 20 C138 28 160 34 160 54 M200 54 C200 34 222 28 232 20 C242 28 264 34 264 54 M134 54 C134 26 164 18 180 6 C196 18 226 26 226 54" fill="rgba(19,36,56,0.75)" stroke="#D9B664" stroke-width="1.3"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- LAPISAN VIDEO MOTION HD CELESTIAL NIGHT (00:00 PORTAL SABIT -> 00:06 KUBAH MASJID & TERATAI -> 00:16.8 BINGKAI SAFIR) --}}
        @if ($pakaiVideoHeroCelestial)
            <video
                x-ref="heroVideo"
                x-show="!videoHeroGagal"
                src="{{ $asetCelestial['videoHero'] }}"
                data-start-at="0"
                data-playback-rate="1.05"
                data-reveal-at="16.8"
                data-settled-at="19.8"
                muted
                playsinline
                webkit-playsinline
                preload="auto"
                x-on:timeupdate="pantauVideoHero($event)"
                x-on:ended="selesaiVideoHero()"
                x-on:error="videoHeroGagal = true; teksHeroTampil = true; videoHeroSedangIntro = false;"
                style="transform: translateZ(0);"
                class="absolute inset-0 z-10 w-full h-full object-cover object-center bg-[#091322] pointer-events-none select-none"
            ></video>

            {{-- OVERLAY TIPOGRAFI MEMPELAI — TERKALIBRASI TEPAT DI DALAM BINGKAI SAFIR #0E1728 VIDEO (DETIK 16.8) --}}
            <div
                x-show="!videoHeroGagal"
                class="absolute inset-x-[27.5%] top-[19.5%] bottom-[47%] z-20 flex flex-col items-center justify-center text-center px-2 celestial-video-teks"
                :class="teksHeroTampil ? 'opacity-100 scale-100 translate-y-0' : 'opacity-0 scale-95 translate-y-3 pointer-events-none'"
            >
                <div class="w-full space-y-1 drop-shadow-[0_3px_14px_rgba(4,10,19,0.85)]">
                    <p
                        class="text-[#F3E5AB] leading-tight"
                        style="font-family: 'Amiri', serif; font-size: clamp(0.8rem, 3vw, 1rem);"
                    >
                        بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                    </p>
                    <p class="text-[8px] font-bold uppercase tracking-[0.3em] text-[#D9B664]">
                        Walimatul Ursy
                    </p>

                    <h2
                        class="font-serif font-bold uppercase tracking-[0.07em] leading-[1.04] text-[#FFFDF8] pt-1"
                        style="font-size: clamp(1.38rem, 5.8vw, 1.95rem);"
                    >
                        <span class="block truncate">{{ $undangan->nama_panggilan_pria }}</span>
                        <span class="my-0.5 flex items-center justify-center gap-2">
                            <span aria-hidden="true" class="h-px w-4 bg-[#D9B664]/75"></span>
                            <span class="font-kaligrafi normal-case font-normal text-2xl sm:text-[1.65rem] text-[#E7C87D] leading-none">&amp;</span>
                            <span aria-hidden="true" class="h-px w-4 bg-[#D9B664]/75"></span>
                        </span>
                        <span class="block truncate">{{ $undangan->nama_panggilan_wanita }}</span>
                    </h2>

                    <div class="pt-1 space-y-0.5">
                        <p class="text-[10px] font-semibold tracking-[0.28em] text-[#F3E5AB]">
                            {{ $tanggalTitik }}
                        </p>
                        <p class="text-[9px] font-medium tracking-[0.12em] text-[#E6EEF8]/88 truncate">
                            {{ $hashtagPasangan }}
                        </p>
                    </div>

                    <div aria-hidden="true" class="pt-1.5 flex justify-center">
                        <div class="w-3.5 h-6 rounded-full border-[1.5px] border-[#F3E5AB]/80 flex justify-center pt-1">
                            <span class="w-1 h-1.5 rounded-full bg-[#F3E5AB] animasi-gulir-roda"></span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Tombol Putar Ulang Animasi Video Pembuka (Halus di Pojok Kiri Bawah) --}}
        @if ($pakaiVideoHeroCelestial)
            <button
                type="button"
                x-show="undanganTerbuka && videoHeroSelesai"
                x-cloak
                x-transition.opacity.duration.400ms
                @click="putarUlangVideoHero()"
                title="Putar ulang animasi pembuka"
                aria-label="Putar ulang animasi pembuka"
                class="absolute bottom-5 left-4 z-50 inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#091322]/80 backdrop-blur-md border border-[#D9B664]/65 text-[#F3E5AB] shadow-md hover:bg-[#132438] active:scale-95 transition cursor-pointer"
            >
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M3 12a9 9 0 1 0 3-6.7L3 8"/>
                    <path d="M3 3v5h5"/>
                </svg>
            </button>
        @endif

        {{-- Gradasi Halus Penyatu Tepi Bawah Hero Ke Seksi Prelude Celestial --}}
        <div
            aria-hidden="true"
            class="pointer-events-none absolute inset-x-0 bottom-0 h-14 z-40"
            style="background: linear-gradient(180deg, transparent 0%, rgba(9,19,34,0.62) 56%, #091322 100%);"
        ></div>
    </div>
</section>

{{-- SEKSI 2: PRELUDE EDITORIAL OBSERVATORIUM MALAM — SALAM, POTRET BERSIH, MONOGRAM & KALAM DOA --}}
<section
    data-section-pembuka="celestial"
    class="relative bg-gradient-to-b from-[#091322] via-[#0B172A] to-[#0A1526] shadow-[0_-2px_0_0_#091322] celestial-pola-bintang px-5 pt-12 pb-14 overflow-hidden"
>
    {{-- Pendar Cahaya Bulan Lembut Di Latar Prelude --}}
    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-0"
        style="background: radial-gradient(circle at 50% 24%, rgba(217,182,100,0.12) 0%, rgba(19,36,56,0.06) 44%, rgba(6,13,24,0.72) 100%);"
    ></div>

    <div class="relative z-10 max-w-md mx-auto space-y-8">
        {{-- Salam Pembuka & Tajuk Editorial --}}
        <div class="text-center space-y-2">
            <svg
                data-gsap="turun"
                aria-hidden="true"
                viewBox="0 0 24 24"
                class="w-5 h-5 mx-auto text-[#E5C474]/90"
                fill="currentColor"
            >
                <path d="M14.7 3.2a8.4 8.4 0 1 0 6.1 14.1 7.1 7.1 0 0 1-9.3-9.3 8.3 8.3 0 0 1 3.2-4.8Z" />
                <path d="M18.4 5.2l.55 1.45 1.45.55-1.45.55-.55 1.45-.55-1.45-1.45-.55 1.45-.55.55-1.45Z" />
            </svg>
            <p data-gsap="turun" class="text-xl sm:text-2xl text-[#F3E5AB]" style="font-family: 'Amiri', serif;">
                بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
            </p>
            <p data-gsap="teks" class="text-[9.5px] font-semibold uppercase tracking-[0.26em] text-[#D9B664]">
                Assalamu&rsquo;alaikum Warahmatullahi Wabarakatuh
            </p>
            <div data-gsap="mekar" data-gsap-delay="0.06" class="flex items-center justify-center gap-2.5 pt-0.5">
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-r from-transparent to-[#D9B664]/65"></span>
                <p class="text-[10px] font-medium uppercase tracking-[0.34em] text-[#E6EEF8]/82">
                    We Are Getting Married!
                </p>
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-l from-transparent to-[#D9B664]/65"></span>
            </div>
        </div>

        {{-- Potret Pembuka Bergaya Editorial Galeri Malam (Tanpa Ornamen Menghalangi Foto) --}}
        @if ($urlFotoPembuka)
            <div data-gsap="potret" class="relative mx-auto max-w-[300px] sm:max-w-[320px]">
                {{-- Garis Bingkai Offset Arsitektural Emas --}}
                <div
                    aria-hidden="true"
                    class="pointer-events-none absolute -inset-2 translate-x-1.5 translate-y-1.5 rounded-[1.6rem] border border-[#D9B664]/28"
                ></div>

                <div class="relative overflow-hidden rounded-[1.4rem] border border-[#D9B664]/55 bg-[#081220] shadow-[0_26px_54px_-16px_rgba(0,0,0,0.85)]">
                    <div class="aspect-[4/4.6] overflow-hidden">
                        <img
                            src="{{ $urlFotoPembuka }}"
                            alt="Foto Pembuka {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                            loading="lazy"
                            decoding="async"
                            class="w-full h-full object-cover object-top"
                        >
                    </div>
                    <div
                        aria-hidden="true"
                        class="pointer-events-none absolute inset-x-0 bottom-0 h-20"
                        style="background: linear-gradient(180deg, transparent 0%, rgba(6,14,27,0.86) 100%);"
                    ></div>
                    <div class="absolute inset-x-4 bottom-3 flex items-center justify-between text-[9.5px] font-medium uppercase tracking-[0.24em] text-[#F3E5AB]/90">
                        <span>{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</span>
                        <span class="text-[#D9B664]">{{ $tanggalTitik }}</span>
                    </div>
                </div>
            </div>
        @endif

        {{-- Pita Monogram Pasangan Minimalis Bergaya Astrolab --}}
        <div class="flex items-center justify-center gap-4 px-4">
            <span data-gsap="garis" aria-hidden="true" class="h-px flex-1 bg-gradient-to-r from-transparent to-[#D9B664]/55"></span>
            <div data-gsap="mekar" class="inline-flex items-center gap-2 rounded-full border border-[#D9B664]/45 bg-[#0F1E33]/85 px-5 py-2 shadow-[0_10px_28px_-10px_rgba(0,0,0,0.75)]">
                <span data-gsap="kiri" class="fx-slide-left font-serif text-xl sm:text-2xl font-semibold text-[#F3E5AB] leading-none">{{ $undangan->inisialPria() }}</span>
                <span class="font-kaligrafi text-xl text-[#D9B664] leading-none">&amp;</span>
                <span data-gsap="kanan" class="fx-slide-right font-serif text-xl sm:text-2xl font-semibold text-[#F3E5AB] leading-none">{{ $undangan->inisialWanita() }}</span>
            </div>
            <span data-gsap="garis" aria-hidden="true" class="h-px flex-1 bg-gradient-to-l from-transparent to-[#D9B664]/55"></span>
        </div>

        {{-- Kalam & Cahaya Doa: Panel Editorial Terbuka Berbingkai Garis Emas Tipis (Tanpa Ornamen Menutupi Teks) --}}
        @if ($undangan->kutipan_ayat)
            <blockquote class="relative rounded-2xl bg-gradient-to-b from-[#112238]/78 to-[#091425]/88 border border-[#D9B664]/35 px-6 sm:px-7 py-7 text-center shadow-[0_22px_48px_-18px_rgba(0,0,0,0.82)] kartu-3d">
                <div data-gsap="turun" class="inline-flex items-center gap-2 rounded-full border border-[#D9B664]/35 bg-[#091322]/75 px-3.5 py-1">
                    <svg aria-hidden="true" viewBox="0 0 16 16" class="h-2.5 w-2.5 text-[#F3E5AB]" fill="currentColor">
                        <path d="M8 0.5L9.7 6.3L15.5 8L9.7 9.7L8 15.5L6.3 9.7L0.5 8L6.3 6.3L8 0.5Z" />
                    </svg>
                    <p class="text-[9px] font-bold uppercase tracking-[0.32em] text-[#D9B664]">
                        Kalam &amp; Cahaya Doa
                    </p>
                    <svg aria-hidden="true" viewBox="0 0 16 16" class="h-2.5 w-2.5 text-[#F3E5AB]" fill="currentColor">
                        <path d="M8 0.5L9.7 6.3L15.5 8L9.7 9.7L8 15.5L6.3 9.7L0.5 8L6.3 6.3L8 0.5Z" />
                    </svg>
                </div>

                <p data-gsap="naik" data-gsap-delay="0.06" class="mt-5 font-serif italic text-[14.5px] sm:text-[15.5px] leading-[1.88] text-[#F4F7FC]/92">
                    &ldquo;{{ $undangan->kutipan_ayat }}&rdquo;
                </p>

                <div data-gsap="garis" class="mt-5 flex items-center justify-center gap-3 px-8" aria-hidden="true">
                    <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#D9B664]/45"></span>
                    <span class="h-1 w-1 rotate-45 bg-[#F3E5AB]/85"></span>
                    <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#D9B664]/45"></span>
                </div>

                <p data-gsap="mekar" data-gsap-delay="0.06" class="mt-3 text-[10px] font-medium tracking-[0.24em] text-[#E5C474]/85">
                    {{ $hashtagPasangan }}
                </p>
            </blockquote>
        @endif
    </div>
</section>
