{{-- SEKSI 1: PANGGUNG VIDEO MOTION HD ALHAMBRA SANCTUARY (+ FALLBACK COURTYARD OTOMATIS) --}}
@php
    $pakaiVideoHeroSyari = ! empty($asetSyari['videoHero']) && empty($urlFotoLatarCustom);
@endphp

<section
    data-diorama-3d="{{ $tierAktif }}"
    data-cinema-duration="3800"
    data-autoscroll-delay="6200"
    :class="undanganTerbuka ? 'syari-hero-terbuka' : ''"
    class="syari-hero-layar-penuh relative w-full overflow-hidden diorama-panggung-3d bg-[#0E3A36]"
>
    <div
        class="relative w-full h-full diorama-kamera-3d"
        @if ($pakaiVideoHeroSyari)
            :class="!videoHeroGagal ? 'syari-kamera-video-aktif' : ''"
        @endif
    >
        {{-- LAPISAN FALLBACK ALHAMBRA SANCTUARY (AKTIF SAAT LATAR KUSTOM / VIDEO GAGAL) --}}
        <div
            class="absolute inset-0 w-full h-full flex flex-col justify-between {{ $pakaiVideoHeroSyari ? 'z-0' : 'z-10' }}"
            @if ($pakaiVideoHeroSyari)
                x-show="videoHeroGagal"
                x-cloak
            @endif
        >
            <div class="absolute inset-0 pointer-events-none">
                <img
                    src="{{ $urlFotoLatar }}"
                    alt="Islami Syar'i"
                    @if ($pakaiVideoHeroSyari) loading="lazy" decoding="async" @endif
                    class="w-full h-full object-cover object-center"
                    :class="undanganTerbuka ? 'diorama-latar-basic' : ''"
                >
                <div
                    aria-hidden="true"
                    class="absolute inset-0"
                    style="background: linear-gradient(180deg, rgba(11,45,42,0.92) 0%, rgba(14,58,54,0.68) 28%, rgba(247,251,248,0.52) 55%, rgba(247,251,248,0.78) 78%, rgba(14,58,54,0.95) 100%);"
                ></div>
            </div>

            {{-- Bingkai Kubah Lengkung Mihrab Tipis Menyatu dengan Layar --}}
            <div aria-hidden="true" class="pointer-events-none absolute inset-3 rounded-t-[10.5rem] rounded-b-3xl border border-[#E6D19C]/55 z-10"></div>

            @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'zaitun-kilau', 'konteks' => 'utama'])

            {{-- Kanopi Tajuk Zamrud-Emas Atas --}}
            <div class="syari-hero-stagger-1 relative z-20 px-7 pt-10 sm:pt-12 text-center text-[#F7FBF8] space-y-1.5">
                <div class="relative mx-auto flex h-14 w-14 items-center justify-center">
                    <span aria-hidden="true" class="absolute inset-1 rotate-45 border border-[#E6D19C]/65 bg-[#0A2B28]/55"></span>
                    <img src="{{ $asetSyari['arabesque'] }}" alt="" class="relative z-10 w-10 opacity-95 animasi-ayun-3d">
                </div>
                <p class="pt-1 text-lg sm:text-xl text-[#F3E5AB] drop-shadow" style="font-family: 'Amiri', serif;">
                    بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                </p>
                <p class="text-[9.5px] font-bold uppercase tracking-[0.26em] text-[#E6D19C]">
                    Assalamu&rsquo;alaikum Warahmatullahi Wabarakatuh
                </p>
                <p class="text-[10px] font-medium uppercase tracking-[0.34em] text-white/80">
                    We Are Getting Married!
                </p>
            </div>

            {{-- Kartus Manuskrip Mempelai Di Tengah --}}
            <div class="syari-hero-stagger-2 relative z-20 px-6 my-auto py-4">
                <div class="relative mx-auto max-w-[340px] rounded-3xl bg-[#F8FCF9]/94 backdrop-blur-md border-2 border-[#C5A059]/75 px-6 py-6 text-center shadow-[0_22px_50px_-14px_rgba(11,45,42,0.45)]">
                    <span aria-hidden="true" class="pointer-events-none absolute top-2.5 left-2.5 h-3 w-3 border-t-2 border-l-2 border-[#C5A059]"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute top-2.5 right-2.5 h-3 w-3 border-t-2 border-r-2 border-[#C5A059]"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 left-2.5 h-3 w-3 border-b-2 border-l-2 border-[#C5A059]"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 right-2.5 h-3 w-3 border-b-2 border-r-2 border-[#C5A059]"></span>

                    <p class="text-[9.5px] font-bold uppercase tracking-[0.36em] text-[#9E7D40]">
                        Walimatul Ursy
                    </p>
                    <h2 class="mt-2 font-serif text-[2.75rem] sm:text-[3.1rem] font-bold leading-[1.04] text-[#0E3A36]">
                        <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
                        <span class="my-1 flex items-center justify-center gap-3">
                            <span aria-hidden="true" class="h-px w-10 bg-gradient-to-r from-transparent to-[#C5A059]"></span>
                            <span class="font-kaligrafi text-4xl font-normal text-[#B99348] leading-none">&amp;</span>
                            <span aria-hidden="true" class="h-px w-10 bg-gradient-to-l from-transparent to-[#C5A059]"></span>
                        </span>
                        <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
                    </h2>
                    <p class="mt-3 text-[10.5px] font-semibold uppercase tracking-[0.24em] text-[#16524C]">
                        {{ $tanggalLengkap }}
                    </p>
                </div>
            </div>

            {{-- Pita Tanggal 3-Kolom & Hashtag Bawah --}}
            <div class="syari-hero-stagger-3 relative z-20 px-6 pb-7 sm:pb-8 text-center text-[#F7FBF8] space-y-3">
                <div class="mx-auto max-w-[320px] grid grid-cols-3 items-center divide-x divide-[#C5A059]/45 rounded-2xl bg-[#0A2B28]/75 backdrop-blur-md border border-[#C5A059]/45 py-2.5 px-2 shadow-lg">
                    <div>
                        <p class="text-[9px] uppercase tracking-[0.22em] text-[#E6D19C]/80">Tanggal</p>
                        <p class="font-serif text-sm font-bold text-white">{{ $tanggalTitik }}</p>
                    </div>
                    <div class="col-span-2 px-2">
                        <p class="text-[9px] uppercase tracking-[0.22em] text-[#E6D19C]/80">Momen Bahagia</p>
                        <p class="text-[11px] font-semibold tracking-[0.14em] text-[#F3E5AB] truncate">{{ $hashtagPasangan }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- LAPISAN VIDEO MOTION HD ISLAMI SYAR'I (00:00 TIRAI MIHRAB -> 00:08 PAVILIUN KUBAH -> 00:20 BINGKAI MIHRAB ZAMRUD) --}}
        @if ($pakaiVideoHeroSyari)
            <video
                x-ref="heroVideo"
                x-show="!videoHeroGagal"
                src="{{ $asetSyari['videoHero'] }}"
                data-start-at="0.15"
                data-playback-rate="1.2"
                data-reveal-at="20.2"
                data-settled-at="22.8"
                muted
                playsinline
                webkit-playsinline
                preload="auto"
                x-on:timeupdate="pantauVideoHero($event)"
                x-on:ended="selesaiVideoHero()"
                x-on:error="videoHeroGagal = true; teksHeroTampil = true; videoHeroSedangIntro = false;"
                style="transform: translateZ(0);"
                class="absolute inset-0 z-10 w-full h-full object-cover object-center bg-[#0E3A36] pointer-events-none select-none"
            ></video>

            {{-- OVERLAY TIPOGRAFI MEMPELAI — MUNCUL SINKRON TEPAT DI DALAM BINGKAI MIHRAB ZAMRUD VIDEO (DETIK 20.2) --}}
            <div
                x-show="!videoHeroGagal"
                class="absolute inset-x-[22%] top-[18%] bottom-[50.5%] z-20 flex flex-col items-center justify-center text-center px-2 syari-video-teks"
                :class="teksHeroTampil ? 'opacity-100 scale-100 translate-y-0' : 'opacity-0 scale-95 translate-y-3 pointer-events-none'"
            >
                <div class="w-full space-y-1 drop-shadow-[0_3px_14px_rgba(6,24,22,0.78)]">
                    <p
                        class="text-[#F3E5AB] leading-tight"
                        style="font-family: 'Amiri', serif; font-size: clamp(0.85rem, 3.3vw, 1.05rem);"
                    >
                        بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                    </p>
                    <p class="text-[8.5px] font-bold uppercase tracking-[0.34em] text-[#E6D19C]">
                        Walimatul Ursy
                    </p>

                    <h2
                        class="font-serif font-bold uppercase tracking-[0.08em] leading-[1.04] text-[#FFFDF8] pt-1"
                        style="font-size: clamp(1.5rem, 6.4vw, 2.1rem);"
                    >
                        <span class="block truncate">{{ $undangan->nama_panggilan_pria }}</span>
                        <span class="my-0.5 flex items-center justify-center gap-2">
                            <span aria-hidden="true" class="h-px w-5 bg-[#E6D19C]/70"></span>
                            <span class="font-kaligrafi normal-case font-normal text-2xl sm:text-[1.75rem] text-[#E6D19C] leading-none">&amp;</span>
                            <span aria-hidden="true" class="h-px w-5 bg-[#E6D19C]/70"></span>
                        </span>
                        <span class="block truncate">{{ $undangan->nama_panggilan_wanita }}</span>
                    </h2>

                    <div class="pt-1 space-y-0.5">
                        <p class="text-[10.5px] font-semibold tracking-[0.3em] text-[#F3E5AB]">
                            {{ $tanggalTitik }}
                        </p>
                        <p class="text-[9.5px] font-medium tracking-[0.14em] text-[#F7FBF8]/90 truncate">
                            {{ $hashtagPasangan }}
                        </p>
                    </div>

                    <div aria-hidden="true" class="pt-1 flex justify-center">
                        <div class="w-3.5 h-6 rounded-full border-[1.5px] border-[#F3E5AB]/80 flex justify-center pt-1">
                            <span class="w-1 h-1.5 rounded-full bg-[#F3E5AB] animasi-gulir-roda"></span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Tombol Putar Ulang Animasi Video Pembuka (Halus di Pojok Kiri Bawah) --}}
        @if ($pakaiVideoHeroSyari)
            <button
                type="button"
                x-show="undanganTerbuka && videoHeroSelesai"
                x-cloak
                x-transition.opacity.duration.400ms
                @click="putarUlangVideoHero()"
                title="Putar ulang animasi pembuka"
                aria-label="Putar ulang animasi pembuka"
                class="absolute bottom-5 left-4 z-50 inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#0A2B28]/80 backdrop-blur-md border border-[#E6D19C]/65 text-[#F3E5AB] shadow-md hover:bg-[#16524C] active:scale-95 transition cursor-pointer"
            >
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M3 12a9 9 0 1 0 3-6.7L3 8"/>
                    <path d="M3 3v5h5"/>
                </svg>
            </button>
        @endif

        {{-- Gradasi Halus Penyatu Tepi Bawah Hero Ke Seksi Prelude Zamrud --}}
        <div
            aria-hidden="true"
            class="pointer-events-none absolute inset-x-0 bottom-0 h-14 z-40"
            style="background: linear-gradient(180deg, transparent 0%, rgba(14,58,54,0.55) 56%, #0E3A36 100%);"
        ></div>
    </div>
</section>

{{-- SEKSI 2: PRELUDE SANCTUARY ZAMRUD — SALAM, POTRET PEMBUKA, SEGEL RUB EL HIZB & KALAM AYAT --}}
<section
    data-section-pembuka="mihrab"
    class="relative bg-gradient-to-b from-[#0E3A36] via-[#0B2E2A] to-[#08221F] shadow-[0_-2px_0_0_#0E3A36] text-[#F7FBF8] px-5 pt-11 pb-14 overflow-hidden"
>
    {{-- Pola Geometri Halus & Pendar Cahaya Emas di Latar Zamrud --}}
    <svg aria-hidden="true" class="pointer-events-none absolute inset-0 h-full w-full opacity-[0.06] text-[#E6D19C]">
        <defs>
            <pattern id="syari-prelude-lattice" width="36" height="36" patternUnits="userSpaceOnUse">
                <path d="M18 0 L36 18 L18 36 L0 18 Z" fill="none" stroke="currentColor" stroke-width="0.7" />
                <circle cx="18" cy="18" r="1.2" fill="currentColor" />
            </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#syari-prelude-lattice)" />
    </svg>
    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-0"
        style="background: radial-gradient(circle at 50% 38%, rgba(230,209,156,0.16) 0%, rgba(14,58,54,0.04) 48%, rgba(6,24,22,0.52) 100%);"
    ></div>

    <div class="relative z-10 max-w-md mx-auto text-center space-y-7">
        {{-- Pembuka Salam & We Are Getting Married --}}
        <div class="space-y-1.5">
            <p data-gsap="turun" class="text-xl sm:text-2xl text-[#F3E5AB]" style="font-family: 'Amiri', serif;">
                بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
            </p>
            <p data-gsap="teks" class="text-[9.5px] font-bold uppercase tracking-[0.26em] text-[#E6D19C]">
                Assalamu&rsquo;alaikum Warahmatullahi Wabarakatuh
            </p>
            <p data-gsap="mekar" data-gsap-delay="0.06" class="text-[10px] font-medium uppercase tracking-[0.34em] text-[#F7FBF8]/78">
                We Are Getting Married!
            </p>
        </div>

        {{-- Potret Pembuka Berbingkai Kubah Mihrab Emas Ganda (Tersembunyi Pada Mode Tanpa Foto) --}}
        @if ($urlFotoPembuka)
            <div data-gsap="potret" class="relative mx-auto w-56 sm:w-60">
                <span aria-hidden="true" class="pointer-events-none absolute -inset-2 rounded-t-[9rem] rounded-b-[1.5rem] border border-dashed border-[#E6D19C]/35"></span>
                <div class="relative p-2 rounded-t-[8.5rem] rounded-b-2xl border-2 border-[#C5A059]/85 bg-[#08221F]/80 shadow-[0_24px_48px_-14px_rgba(4,16,14,0.75)]">
                    <img
                        src="{{ $asetSyari['arabesque'] }}"
                        alt=""
                        aria-hidden="true"
                        loading="lazy"
                        decoding="async"
                        class="pointer-events-none absolute -top-5 left-1/2 -translate-x-1/2 w-10 z-20 drop-shadow-md"
                    >
                    <div class="overflow-hidden rounded-t-[7.8rem] rounded-b-xl aspect-[4/5] border border-[#F3E5AB]/45">
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

        {{-- Segel Bintang 8 Sudut (Rub el Hizb) & Monogram Pasangan Bertemu Kiri <-> Kanan --}}
        <div class="flex items-center justify-center gap-4 px-4">
            <span data-gsap="garis" aria-hidden="true" class="h-px flex-1 max-w-[60px] bg-gradient-to-r from-transparent to-[#E6D19C]/65"></span>
            <div data-gsap="mekar" class="relative h-24 w-24 flex items-center justify-center">
                <span aria-hidden="true" class="absolute inset-2 bg-[#12453F] border border-[#C5A059] shadow-lg"></span>
                <span aria-hidden="true" class="absolute inset-2 rotate-45 bg-[#12453F] border border-[#C5A059] shadow-lg"></span>
                <span aria-hidden="true" class="absolute inset-3.5 border border-[#E6D19C]/35"></span>
                <div class="relative z-10 flex items-baseline gap-1 text-[#F3E5AB]">
                    <span data-gsap="kiri" class="fx-slide-left font-serif text-2xl sm:text-[1.75rem] font-bold">{{ $undangan->inisialPria() }}</span>
                    <span class="font-kaligrafi text-2xl text-[#E6D19C]">&amp;</span>
                    <span data-gsap="kanan" class="fx-slide-right font-serif text-2xl sm:text-[1.75rem] font-bold">{{ $undangan->inisialWanita() }}</span>
                </div>
            </div>
            <span data-gsap="garis" aria-hidden="true" class="h-px flex-1 max-w-[60px] bg-gradient-to-l from-transparent to-[#E6D19C]/65"></span>
        </div>

        {{-- Kartu Manuskrip Ayat Suci & Doa Zamrud-Emas --}}
        @if ($undangan->kutipan_ayat)
            <div class="pt-3">
                <blockquote class="relative rounded-[1.75rem] bg-gradient-to-b from-[#134640]/88 via-[#0E3934]/82 to-[#092724]/94 backdrop-blur-sm border border-[#E6D19C]/45 px-6 sm:px-7 pt-9 pb-7 shadow-[0_22px_48px_-16px_rgba(4,16,14,0.75),inset_0_1px_0_rgba(243,229,171,0.2)] kartu-3d">
                    <span aria-hidden="true" class="pointer-events-none absolute top-2.5 left-2.5 h-3.5 w-3.5 border-t border-l border-[#E6D19C]/65 rounded-tl-md"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute top-2.5 right-2.5 h-3.5 w-3.5 border-t border-r border-[#E6D19C]/65 rounded-tr-md"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 left-2.5 h-3.5 w-3.5 border-b border-l border-[#E6D19C]/65 rounded-bl-md"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 right-2.5 h-3.5 w-3.5 border-b border-r border-[#E6D19C]/65 rounded-br-md"></span>

                    {{-- Medali Arabesque Bertengger Di Tepi Atas Kartu Ayat --}}
                    <div data-gsap="turun" class="absolute -top-6 inset-x-0 mx-auto w-fit rounded-full bg-[#0E3A36] border border-[#E6D19C]/65 px-3 py-1.5 shadow-[0_8px_18px_rgba(4,16,14,0.65)]">
                        <img
                            src="{{ $asetSyari['arabesque'] }}"
                            alt=""
                            loading="lazy"
                            decoding="async"
                            class="w-9 mx-auto"
                        >
                    </div>

                    <p data-gsap="teks" class="text-[9.5px] font-bold uppercase tracking-[0.34em] text-[#E6D19C] pt-1">
                        Kalam &amp; Doa
                    </p>

                    <span data-gsap="mekar" aria-hidden="true" class="block font-serif text-5xl leading-[0.65] text-[#E6D19C]/30 pt-3 select-none">
                        &ldquo;
                    </span>

                    <p data-gsap="naik" data-gsap-delay="0.06" class="font-serif italic text-[14.5px] sm:text-[15.5px] leading-[1.8] text-[#F7FBF8]/95 pt-1">
                        {{ $undangan->kutipan_ayat }}
                    </p>

                    <div data-gsap="garis" class="mt-5 flex items-center justify-center gap-3 px-8" aria-hidden="true">
                        <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#E6D19C]/55"></span>
                        <span class="w-1.5 h-1.5 rotate-45 bg-[#E6D19C]/85"></span>
                        <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#E6D19C]/55"></span>
                    </div>

                    <p data-gsap="mekar" data-gsap-delay="0.06" class="mt-2.5 text-[10px] font-medium tracking-[0.22em] text-[#F3E5AB]/85">
                        {{ $hashtagPasangan }}
                    </p>
                </blockquote>
            </div>
        @endif
    </div>
</section>
