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
                            <img src="{{ $asetCelestial['sabit'] }}" alt="" class="w-8 opacity-95 animasi-ayun-3d">
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

{{-- SEKSI 2: PRELUDE SANCTUARY LANGIT MALAM — SALAM, POTRET ASTROLAB, MONOGRAM ORBIT & AYAT --}}
<section
    data-section-pembuka="celestial"
    class="relative bg-gradient-to-b from-[#091322] via-[#0C192C] to-[#0E1B2A] shadow-[0_-2px_0_0_#091322] celestial-pola-bintang px-5 pt-11 pb-14 overflow-hidden"
>
    {{-- Pendar Bimasakti Lembut Di Latar Prelude --}}
    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-0"
        style="background: radial-gradient(circle at 50% 34%, rgba(217,182,100,0.14) 0%, rgba(19,36,56,0.08) 46%, rgba(6,13,24,0.65) 100%);"
    ></div>

    <div class="relative z-10 max-w-md mx-auto text-center space-y-7">
        {{-- Salam Pembuka & Tajuk --}}
        <div class="space-y-1.5">
            <p data-gsap="turun" class="text-xl sm:text-2xl text-[#F3E5AB]" style="font-family: 'Amiri', serif;">
                بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
            </p>
            <p data-gsap="teks" class="text-[9.5px] font-bold uppercase tracking-[0.26em] text-[#D9B664]">
                Assalamu&rsquo;alaikum Warahmatullahi Wabarakatuh
            </p>
            <p data-gsap="mekar" data-gsap-delay="0.06" class="text-[10px] font-medium uppercase tracking-[0.34em] text-[#E6EEF8]/78">
                We Are Getting Married!
            </p>
        </div>

        {{-- Potret Pembuka Berbingkai Lengkung Kubah Malam (Tersembunyi Saat Mode Tanpa Foto) --}}
        @if ($urlFotoPembuka)
            <div data-gsap="potret" class="relative mx-auto w-56 sm:w-60">
                <span aria-hidden="true" class="pointer-events-none absolute -inset-2.5 rounded-t-[9.2rem] rounded-b-[1.6rem] border border-dashed border-[#D9B664]/40"></span>
                <div class="relative p-2 rounded-t-[8.5rem] rounded-b-2xl border-2 border-[#D9B664]/80 bg-[#0A1526]/90 shadow-[0_24px_52px_-14px_rgba(0,0,0,0.82)]">
                    <img
                        src="{{ $asetCelestial['sabit'] }}"
                        alt=""
                        aria-hidden="true"
                        loading="lazy"
                        decoding="async"
                        class="pointer-events-none absolute -top-5 left-1/2 -translate-x-1/2 w-9 z-20 drop-shadow-md animasi-ayun-3d"
                    >
                    <div class="overflow-hidden rounded-t-[7.8rem] rounded-b-xl aspect-[4/5] border border-[#F3E5AB]/40">
                        <img
                            src="{{ $urlFotoPembuka }}"
                            alt="Foto Pembuka {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                            loading="lazy"
                            decoding="async"
                            class="w-full h-full object-cover object-top"
                        >
                    </div>
                </div>
            </div>
        @endif

        {{-- Medali Monogram Orbit Astrolab Pasangan --}}
        <div class="flex items-center justify-center gap-4 px-4">
            <span data-gsap="garis" aria-hidden="true" class="h-px flex-1 max-w-[62px] bg-gradient-to-r from-transparent to-[#D9B664]/70"></span>
            <div data-gsap="mekar" class="relative h-24 w-24 flex items-center justify-center">
                <span aria-hidden="true" class="absolute inset-0 rounded-full border border-dashed border-[#D9B664]/65 animasi-orbit"></span>
                <span aria-hidden="true" class="absolute inset-2 rounded-full border border-[#F3E5AB]/45 bg-[#102036]/85 shadow-[0_0_28px_-6px_rgba(217,182,100,0.3)] animasi-orbit-balik"></span>
                <div class="relative z-10 flex items-baseline gap-1 text-[#F3E5AB]">
                    <span data-gsap="kiri" class="fx-slide-left font-serif text-2xl sm:text-[1.75rem] font-bold">{{ $undangan->inisialPria() }}</span>
                    <span class="font-kaligrafi text-2xl text-[#D9B664]">&amp;</span>
                    <span data-gsap="kanan" class="fx-slide-right font-serif text-2xl sm:text-[1.75rem] font-bold">{{ $undangan->inisialWanita() }}</span>
                </div>
            </div>
            <span data-gsap="garis" aria-hidden="true" class="h-px flex-1 max-w-[62px] bg-gradient-to-l from-transparent to-[#D9B664]/70"></span>
        </div>

        {{-- Plakat Ayat Suci Malam Bintang & Siluet Teratai Putih --}}
        @if ($undangan->kutipan_ayat)
            <div class="pt-3">
                <blockquote class="relative rounded-[1.85rem] bg-gradient-to-b from-[#13243B]/92 via-[#0F1E33]/90 to-[#0A1525]/96 backdrop-blur-sm border border-[#D9B664]/50 px-6 sm:px-7 pt-9 pb-7 shadow-[0_24px_52px_-16px_rgba(0,0,0,0.8),inset_0_1px_0_rgba(243,229,171,0.18)] kartu-3d">
                    <span aria-hidden="true" class="pointer-events-none absolute top-2.5 left-2.5 h-3.5 w-3.5 border-t border-l border-[#D9B664]/65 rounded-tl-md"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute top-2.5 right-2.5 h-3.5 w-3.5 border-t border-r border-[#D9B664]/65 rounded-tr-md"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 left-2.5 h-3.5 w-3.5 border-b border-l border-[#D9B664]/65 rounded-bl-md"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 right-2.5 h-3.5 w-3.5 border-b border-r border-[#D9B664]/65 rounded-br-md"></span>

                    {{-- Medali Bulan Sabit Di Puncak Plakat Ayat --}}
                    <div data-gsap="turun" class="absolute -top-6 inset-x-0 mx-auto w-fit rounded-full bg-[#0E1C30] border border-[#D9B664]/70 px-3.5 py-1.5 shadow-[0_8px_20px_rgba(0,0,0,0.7)]">
                        <img
                            src="{{ $asetCelestial['sabit'] }}"
                            alt=""
                            loading="lazy"
                            decoding="async"
                            class="w-7 mx-auto"
                        >
                    </div>

                    <p data-gsap="teks" class="text-[9.5px] font-bold uppercase tracking-[0.34em] text-[#D9B664] pt-1">
                        Kalam &amp; Cahaya Doa
                    </p>

                    <span data-gsap="mekar" aria-hidden="true" class="block font-serif text-5xl leading-[0.65] text-[#D9B664]/30 pt-3 select-none">
                        &ldquo;
                    </span>

                    <p data-gsap="naik" data-gsap-delay="0.06" class="font-serif italic text-[14.5px] sm:text-[15.5px] leading-[1.82] text-[#F4F7FC]/95 pt-1">
                        {{ $undangan->kutipan_ayat }}
                    </p>

                    {{-- Ornamen Teratai Putih Celestial (Selaras Video Hero) --}}
                    <div data-gsap="garis" class="mt-5 flex items-center justify-center gap-3 px-6" aria-hidden="true">
                        <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#D9B664]/55"></span>
                        <svg viewBox="0 0 48 22" class="w-10 text-[#F3E5AB]/85" fill="none" stroke="currentColor" stroke-width="1.2">
                            <path d="M24 3 C20 9 20 15 24 19 C28 15 28 9 24 3 Z" fill="currentColor" fill-opacity="0.22"/>
                            <path d="M24 19 C17 17 12 12 11 7 C16 8 20 12 24 19 Z" fill="currentColor" fill-opacity="0.14"/>
                            <path d="M24 19 C31 17 36 12 37 7 C32 8 28 12 24 19 Z" fill="currentColor" fill-opacity="0.14"/>
                            <path d="M5 19 Q24 21 43 19" stroke-opacity="0.55"/>
                        </svg>
                        <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#D9B664]/55"></span>
                    </div>

                    <p data-gsap="mekar" data-gsap-delay="0.06" class="mt-2 text-[10px] font-medium tracking-[0.22em] text-[#F3E5AB]/85">
                        {{ $hashtagPasangan }}
                    </p>
                </blockquote>
            </div>
        @endif
    </div>
</section>
