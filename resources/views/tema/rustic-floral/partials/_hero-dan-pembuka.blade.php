{{-- SEKSI 1: PANGGUNG VIDEO MOTION HD RUSTIC WATERCOLOR GARDEN (+ FALLBACK PERGOLA OTOMATIS) --}}
@php
    $pakaiVideoHeroRustic = ! empty($asetRustic['videoHero']) && empty($urlFotoLatarCustom);
@endphp

<section
    data-diorama-3d="basic"
    data-cinema-duration="3800"
    data-autoscroll-delay="6200"
    class="rustic-hero-layar-penuh relative w-full overflow-hidden diorama-panggung-3d bg-[#FBF7EE]"
>
    <div
        class="relative w-full h-full diorama-kamera-3d"
        @if ($pakaiVideoHeroRustic)
            :class="!videoHeroGagal ? 'rustic-kamera-video-aktif' : ''"
        @endif
    >
        {{-- LAPISAN FALLBACK DIORAMA PERGOLA BOTANI (AKTIF SAAT LATAR KUSTOM / VIDEO GAGAL) --}}
        <div
            class="absolute inset-0 w-full h-full flex flex-col px-3.5 py-3.5 sm:px-4 sm:py-4 bg-gradient-to-b from-[#FDFBF7] via-[#F9F4EC] to-[#EFE6DA] {{ $pakaiVideoHeroRustic ? 'z-0' : 'z-10' }}"
            @if ($pakaiVideoHeroRustic)
                x-show="videoHeroGagal"
                x-cloak
            @endif
        >
            <div
                class="rustic-hero-kartu relative flex-1 flex flex-col justify-between w-full rounded-t-[10.5rem] rounded-b-[2rem] border border-[#BFA15F]/60 ring-4 ring-[#BFA15F]/12 overflow-hidden shadow-[0_24px_60px_-18px_rgba(43,60,51,0.36)] bg-[#2F4037]"
                :class="undanganTerbuka ? 'rustic-hero-terbuka' : ''"
            >
                <div class="absolute inset-0 pointer-events-none">
                    <img
                        src="{{ $urlFotoLatar }}"
                        alt="Rustic Floral"
                        @if ($pakaiVideoHeroRustic) loading="lazy" decoding="async" @endif
                        class="w-full h-full object-cover object-center"
                        :class="undanganTerbuka ? 'diorama-latar-basic' : ''"
                    >
                    <div
                        aria-hidden="true"
                        class="absolute inset-0"
                        style="background: radial-gradient(ellipse 80% 54% at 50% 44%, rgba(253,251,247,0.93) 0%, rgba(253,251,247,0.78) 44%, rgba(253,251,247,0.28) 74%, transparent 100%);"
                    ></div>
                    <div
                        aria-hidden="true"
                        class="absolute inset-0"
                        style="background: linear-gradient(180deg, rgba(253,251,247,0.35) 0%, rgba(253,251,247,0.06) 24%, transparent 56%, rgba(35,51,43,0.68) 84%, rgba(25,38,31,0.93) 100%);"
                    ></div>
                </div>

                <div aria-hidden="true" class="pointer-events-none absolute inset-3 rounded-t-[9.75rem] rounded-b-[1.45rem] border border-[#BFA15F]/70 z-10"></div>
                <div aria-hidden="true" class="pointer-events-none absolute inset-[18px] rounded-t-[9.35rem] rounded-b-[1.1rem] border border-dashed border-[#BFA15F]/35 z-10"></div>

                <div aria-hidden="true" class="pointer-events-none absolute top-5 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2">
                    <span class="h-px w-8 bg-gradient-to-r from-transparent to-[#BFA15F]"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-[#4B6358]"></span>
                    <span class="w-2.5 h-2.5 rotate-45 bg-[#B86B4B] ring-2 ring-[#FDFBF7]/80"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-[#4B6358]"></span>
                    <span class="h-px w-8 bg-gradient-to-l from-transparent to-[#BFA15F]"></span>
                </div>

                <img src="{{ $asetRustic['sudut'] }}" alt="" @if ($pakaiVideoHeroRustic) loading="lazy" decoding="async" @endif class="pointer-events-none absolute -top-2 -left-2 w-20 sm:w-24 opacity-80 z-20 animasi-ayun-3d">
                <img src="{{ $asetRustic['sudut'] }}" alt="" @if ($pakaiVideoHeroRustic) loading="lazy" decoding="async" @endif class="pointer-events-none absolute -top-2 -right-2 w-20 sm:w-24 opacity-80 z-20 animasi-ayun-3d-balik">

                @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'kelopak', 'konteks' => 'utama'])

                <div class="relative z-20 flex-1 flex flex-col justify-between px-7 pt-16 sm:pt-20 pb-7 sm:pb-8 text-center">
                    <div class="rustic-hero-stagger-1 space-y-2">
                        <p class="text-[10px] font-bold uppercase tracking-[0.36em] text-[#3F554A]">Undangan Pernikahan</p>
                        <p class="text-[10.5px] font-semibold uppercase tracking-[0.28em] text-[#B86B4B]">We Are Getting Married!</p>
                    </div>

                    <div class="rustic-hero-stagger-2 my-auto py-6 space-y-4">
                        <h2 class="font-serif text-[3.15rem] sm:text-[3.55rem] font-bold leading-[1.02] tracking-tight text-[#223029] drop-shadow-[0_2px_16px_rgba(253,251,247,0.95)]">
                            <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
                            <span class="my-1.5 flex items-center justify-center gap-3">
                                <span aria-hidden="true" class="h-px w-10 bg-gradient-to-r from-transparent to-[#BFA15F]/85"></span>
                                <span class="font-kaligrafi text-4xl sm:text-[2.75rem] font-normal text-[#B86B4B] leading-none">&amp;</span>
                                <span aria-hidden="true" class="h-px w-10 bg-gradient-to-l from-transparent to-[#BFA15F]/85"></span>
                            </span>
                            <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
                        </h2>

                        <div class="inline-flex items-center gap-2.5 rounded-full bg-[#FDFBF7]/85 backdrop-blur-xs border border-[#BFA15F]/45 px-4 py-1.5 shadow-xs">
                            <span aria-hidden="true" class="w-1.5 h-1.5 rotate-45 bg-[#B86B4B]"></span>
                            <p class="text-[10.5px] font-semibold uppercase tracking-[0.24em] text-[#3A4F45]">{{ $tanggalLengkap }}</p>
                            <span aria-hidden="true" class="w-1.5 h-1.5 rotate-45 bg-[#B86B4B]"></span>
                        </div>
                    </div>

                    <div class="rustic-hero-stagger-3 space-y-4">
                        <div class="mx-auto inline-flex flex-col items-center gap-1 rounded-2xl bg-[#1E3027]/55 backdrop-blur-md border border-[#E5D5C0]/35 px-6 py-3 shadow-[0_14px_30px_-10px_rgba(0,0,0,0.45)]">
                            <p class="text-xs font-bold uppercase tracking-[0.34em] text-[#F3E5AB]">{{ $tanggalTitik }}</p>
                            <p class="text-[11px] font-medium tracking-[0.2em] text-[#FDFBF7]/92">{{ $hashtagPasangan }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- LAPISAN VIDEO MOTION HD RUSTIC WATERCOLOR GARDEN (15s @ 1.0x: TERKALIBRASI SIMETRIS TENGAH) --}}
        @if ($pakaiVideoHeroRustic)
            <video
                x-ref="heroVideo"
                x-show="!videoHeroGagal"
                src="{{ $asetRustic['videoHero'] }}"
                data-start-at="0"
                data-playback-rate="1"
                data-reveal-at="11.6"
                data-settled-at="14.2"
                muted
                playsinline
                webkit-playsinline
                preload="auto"
                x-on:timeupdate="pantauVideoHero($event)"
                x-on:ended="selesaiVideoHero()"
                x-on:error="videoHeroGagal = true; teksHeroTampil = true; videoHeroSedangIntro = false;"
                style="transform: translate3d(2.2%, 0, 0) scale(1.06);"
                class="absolute inset-0 z-10 w-full h-full object-cover object-center bg-[#FBF7EE] pointer-events-none select-none"
            ></video>

            {{-- OVERLAY TIPOGRAFI FINE-ART BOTANI — TERPUSAT SIMETRIS DI DALAM LENGKUNGAN IVORY SEMI-TRANSPARAN VIDEO (DETIK 11.6) --}}
            <div
                x-show="!videoHeroGagal"
                class="absolute inset-x-[10.5%] top-[12.5%] bottom-[27.5%] z-20 flex flex-col items-center justify-center text-center px-3 rustic-video-teks"
                :class="teksHeroTampil ? 'opacity-100 scale-100 translate-y-0' : 'opacity-0 scale-95 translate-y-3 pointer-events-none'"
            >
                {{-- Kabut Cahaya Ivory Ultra-Lembut di Belakang Tipografi Agar Sangat Kontras Namun Pergola Tetap Terlihat --}}
                <div
                    aria-hidden="true"
                    class="pointer-events-none absolute -inset-4 rounded-t-[10rem] rounded-b-3xl"
                    style="background: radial-gradient(ellipse 86% 74% at 50% 48%, rgba(253,251,247,0.8) 0%, rgba(253,251,247,0.42) 58%, transparent 100%);"
                ></div>

                <div class="relative z-10 w-full space-y-3 drop-shadow-[0_2px_14px_rgba(253,251,247,0.95)]">
                    <div class="space-y-1">
                        <svg aria-hidden="true" viewBox="0 0 64 20" class="w-14 h-4 mx-auto text-[#BFA15F]" fill="none" stroke="currentColor" stroke-width="1.35" stroke-linecap="round">
                            <path d="M32 14 C25 8, 17 6, 8 9 C15 13, 24 14, 32 14 Z" fill="currentColor" fill-opacity="0.22"/>
                            <path d="M32 14 C39 8, 47 6, 56 9 C49 13, 40 14, 32 14 Z" fill="currentColor" fill-opacity="0.22"/>
                            <circle cx="32" cy="12" r="2" fill="#B86B4B" stroke="none"/>
                        </svg>
                        <p class="text-[10.5px] sm:text-[11px] font-bold uppercase tracking-[0.34em] text-[#3F554A]">
                            Undangan Pernikahan
                        </p>
                        <p class="text-[10.5px] sm:text-[11px] font-semibold uppercase tracking-[0.26em] text-[#B86B4B]">
                            We Are Getting Married!
                        </p>
                    </div>

                    <h2
                        class="font-serif font-bold leading-[1.02] tracking-tight text-[#223029] pt-0.5"
                        style="font-size: clamp(2.85rem, 11.8vw, 3.5rem);"
                    >
                        <span class="block truncate">{{ $undangan->nama_panggilan_pria }}</span>
                        <span class="my-1 flex items-center justify-center gap-3.5">
                            <span aria-hidden="true" class="h-px w-10 bg-gradient-to-r from-transparent to-[#BFA15F]"></span>
                            <span class="font-kaligrafi font-normal text-[2.5rem] sm:text-[3rem] text-[#B86B4B] leading-none">&amp;</span>
                            <span aria-hidden="true" class="h-px w-10 bg-gradient-to-l from-transparent to-[#BFA15F]"></span>
                        </span>
                        <span class="block truncate">{{ $undangan->nama_panggilan_wanita }}</span>
                    </h2>

                    <div class="pt-1 space-y-2.5">
                        <div class="inline-flex items-center gap-2 rounded-full bg-[#FDFBF7]/92 backdrop-blur-xs border border-[#BFA15F]/55 px-4 py-1.5 shadow-xs max-w-full">
                            <span aria-hidden="true" class="w-1.5 h-1.5 rotate-45 bg-[#B86B4B] shrink-0"></span>
                            <p class="text-[11px] sm:text-[11.5px] font-semibold uppercase tracking-[0.18em] text-[#35493F] truncate">
                                {{ $tanggalLengkap }}
                            </p>
                            <span aria-hidden="true" class="w-1.5 h-1.5 rotate-45 bg-[#B86B4B] shrink-0"></span>
                        </div>

                        <div class="space-y-0.5">
                            <p class="text-[13px] sm:text-sm font-bold uppercase tracking-[0.3em] text-[#3F554A]">
                                {{ $tanggalTitik }}
                            </p>
                            <p class="text-[11px] sm:text-xs font-semibold tracking-[0.16em] text-[#B86B4B] truncate">
                                {{ $hashtagPasangan }}
                            </p>
                        </div>
                    </div>

                    <div aria-hidden="true" class="pt-1 flex justify-center">
                        <div class="w-4 h-7 rounded-full border-[1.5px] border-[#4B6358]/65 flex justify-center pt-1.5">
                            <span class="w-1 h-1.5 rounded-full bg-[#B86B4B] animasi-gulir-roda"></span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Tombol Putar Ulang Animasi Video Pembuka (Halus di Pojok Kiri Bawah) --}}
        @if ($pakaiVideoHeroRustic)
            <button
                type="button"
                x-show="undanganTerbuka && videoHeroSelesai"
                x-cloak
                x-transition.opacity.duration.400ms
                @click="putarUlangVideoHero()"
                title="Putar ulang animasi pembuka"
                aria-label="Putar ulang animasi pembuka"
                class="absolute bottom-5 left-4 z-50 inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#2F4037]/82 backdrop-blur-md border border-[#E5D5C0]/65 text-[#FDFBF7] shadow-md hover:bg-[#4B6358] active:scale-95 transition cursor-pointer"
            >
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M3 12a9 9 0 1 0 3-6.7L3 8"/>
                    <path d="M3 3v5h5"/>
                </svg>
            </button>
        @endif

        {{-- Gradasi Halus Penyatu Tepi Bawah Hero Ke Seksi Prelude Sage --}}
        <div
            aria-hidden="true"
            class="pointer-events-none absolute inset-x-0 bottom-0 h-14 z-40"
            style="background: linear-gradient(180deg, transparent 0%, rgba(62,83,73,0.48) 58%, #3E5349 100%);"
        ></div>
    </div>
</section>

{{-- SEKSI 2: PRELUDE BOTANICAL SCRAPBOOK — MONOGRAM, POTRET WASHI-TAPE & KUTIPAN AYAT --}}
<section
    data-section-pembuka="klasik"
    class="relative bg-gradient-to-b from-[#3E5349] via-[#34473E] to-[#2B3B33] shadow-[0_-2px_0_0_#3E5349] text-[#FDFBF7] px-5 pt-11 pb-14 overflow-hidden"
>
    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-0"
        style="background: radial-gradient(circle at 50% 34%, rgba(229,213,192,0.12) 0%, transparent 56%);"
    ></div>

    <div class="relative z-10 max-w-md mx-auto text-center space-y-7">
        <div class="space-y-1.5">
            <p data-gsap="turun" class="text-[10px] font-semibold uppercase tracking-[0.34em] text-[#E5D5C0]">
                The Wedding Celebration
            </p>
            <div class="flex items-center justify-center gap-4 pt-1">
                <span data-gsap="garis" aria-hidden="true" class="h-px w-10 bg-gradient-to-r from-transparent to-[#E5D5C0]/65"></span>
                <div class="grid grid-cols-3 items-center min-w-[148px]">
                    <span data-gsap="kiri" class="fx-slide-left font-serif text-4xl sm:text-5xl font-bold text-[#FDFBF7]">{{ $undangan->inisialPria() }}</span>
                    <span data-gsap="mekar" data-gsap-delay="0.07" class="font-kaligrafi text-3xl text-[#E5C99B]">&amp;</span>
                    <span data-gsap="kanan" class="fx-slide-right font-serif text-4xl sm:text-5xl font-bold text-[#FDFBF7]">{{ $undangan->inisialWanita() }}</span>
                </div>
                <span data-gsap="garis" aria-hidden="true" class="h-px w-10 bg-gradient-to-l from-transparent to-[#E5D5C0]/65"></span>
            </div>
        </div>

        @if ($urlFotoPembuka)
            <div data-gsap="potret" class="mx-auto w-56 sm:w-64">
                <div class="relative bg-[#FDFBF7] p-2.5 pb-5 shadow-[0_24px_48px_-14px_rgba(16,26,21,0.72)] -rotate-1 border border-[#E5D5C0]/80">
                    <span aria-hidden="true" class="pointer-events-none absolute -top-2.5 left-1/2 -translate-x-1/2 w-20 h-5 bg-[#E5D5C0]/92 border border-[#BFA15F]/40 rotate-1 shadow-xs"></span>
                    <img src="{{ $urlFotoPembuka }}" alt="Foto Pembuka {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}" loading="lazy" decoding="async" class="w-full aspect-[4/5] object-cover object-top">
                    <p class="mt-2.5 font-kaligrafi text-xl text-[#4B6358]">{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</p>
                    <p class="text-[9px] font-semibold uppercase tracking-[0.26em] text-[#B86B4B]">{{ $tanggalTitik }}</p>
                </div>
            </div>
        @endif

        @if ($undangan->kutipan_ayat)
            <div class="pt-4">
                <blockquote data-gsap="naik" class="relative rounded-3xl bg-[#FDFBF7] text-[#1F2937] border border-[#BFA15F]/55 px-6 sm:px-7 pt-10 pb-7 shadow-xl kartu-3d space-y-3">
                    <span aria-hidden="true" class="pointer-events-none absolute top-2.5 left-2.5 h-3 w-3 border-t border-l border-[#BFA15F]/75 rounded-tl-md"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute top-2.5 right-2.5 h-3 w-3 border-t border-r border-[#BFA15F]/75 rounded-tr-md"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 left-2.5 h-3 w-3 border-b border-l border-[#BFA15F]/75 rounded-bl-md"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 right-2.5 h-3 w-3 border-b border-r border-[#BFA15F]/75 rounded-br-md"></span>

                    {{-- Karangan Bunga Cat Air Mahkota Kartu Kalam & Doa --}}
                    <img
                        src="{{ $asetRustic['garland'] }}"
                        alt=""
                        aria-hidden="true"
                        loading="lazy"
                        decoding="async"
                        class="pointer-events-none absolute -top-7 left-1/2 -translate-x-1/2 w-36 sm:w-40 drop-shadow-sm"
                    >

                    <p class="text-[9.5px] font-bold uppercase tracking-[0.32em] text-[#B86B4B]">Kalam &amp; Doa</p>
                    <p class="font-serif italic text-sm sm:text-[15px] text-[#2F4037] leading-[1.78]">
                        &ldquo;{{ $undangan->kutipan_ayat }}&rdquo;
                    </p>
                    <div class="flex items-center justify-center gap-3 px-8 pt-1" aria-hidden="true">
                        <span class="h-px flex-1 bg-[#BFA15F]/45"></span>
                        <span class="w-1.5 h-1.5 rotate-45 bg-[#B86B4B]"></span>
                        <span class="h-px flex-1 bg-[#BFA15F]/45"></span>
                    </div>
                    <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-[#4B6358]">{{ $hashtagPasangan }}</p>
                </blockquote>
            </div>
        @endif
    </div>
</section>
