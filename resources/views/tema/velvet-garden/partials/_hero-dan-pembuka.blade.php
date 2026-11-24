{{-- SEKSI 1: PANGGUNG VIDEO MOTION HD VELVET GARDEN CONSERVATORY (+ FALLBACK DIORAMA OTOMATIS) --}}
@php
    $pakaiVideoHeroVelvet = ! empty($asetGarden['videoHero']) && empty($urlFotoLatarCustom);
@endphp

<section
    data-diorama-3d="{{ $tierAktif }}"
    data-cinema-duration="4200"
    data-autoscroll-delay="6400"
    class="velvet-hero-layar-penuh relative w-full overflow-hidden diorama-panggung-3d bg-[#0E1E18]"
>
    <div
        class="relative w-full h-full diorama-kamera-3d"
        @if ($pakaiVideoHeroVelvet)
            :class="!videoHeroGagal ? 'velvet-kamera-video-aktif' : ''"
        @endif
    >
        {{-- LAPISAN FALLBACK DIORAMA KONSERVATORI KACA VICTORIAN (AKTIF SAAT LATAR KUSTOM / VIDEO GAGAL) --}}
        <div
            class="absolute inset-0 w-full h-full flex flex-col px-3.5 py-4 bg-[#132623] {{ $pakaiVideoHeroVelvet ? 'z-0' : 'z-10' }}"
            @if ($pakaiVideoHeroVelvet)
                x-show="videoHeroGagal"
                x-cloak
            @endif
        >
            <div class="relative flex-1 w-full rounded-t-[10.5rem] rounded-b-3xl border-2 border-[#C8A464]/65 overflow-hidden shadow-2xl bg-[#0E1E18] flex flex-col justify-between">
                {{-- Z-0: Latar Taman Senja --}}
                <div class="absolute inset-0 pointer-events-none">
                    <img src="{{ $urlFotoLatar }}" alt="Velvet Garden" @if ($pakaiVideoHeroVelvet) loading="lazy" decoding="async" @endif class="w-full h-full object-cover object-center">
                    <div class="absolute inset-0 bg-gradient-to-b from-[#0E1E18]/75 via-[#132623]/32 to-[#0A1712]/90"></div>
                </div>

                {{-- Z-1: Lengkungan Konservatori Kuningan & Mawar Gading --}}
                <div
                    class="pointer-events-none absolute inset-x-1 top-2 bottom-2 flex items-center justify-center z-10"
                    :class="undanganTerbuka ? 'garden-arch-masuk' : 'opacity-0'"
                >
                    <img src="{{ $asetGarden['konservatori'] }}" alt="" @if ($pakaiVideoHeroVelvet) loading="lazy" decoding="async" @endif class="w-full h-full object-contain opacity-96">
                </div>

                {{-- Z-2: Ranting Pakis Botani Kiri & Kanan Bawah --}}
                <svg aria-hidden="true" viewBox="0 0 110 130" class="pointer-events-none absolute -bottom-2 -left-2 w-24 z-20 opacity-85 garden-daun-kiri">
                    <path d="M10 126 C24 84 48 48 92 16" fill="none" stroke="#C8A464" stroke-width="1.6"/>
                    <g fill="#2C5248" stroke="#C8A464" stroke-width="0.7">
                        <ellipse cx="26" cy="96" rx="16" ry="6" transform="rotate(-35 26 96)"/>
                        <ellipse cx="44" cy="76" rx="15" ry="5.5" transform="rotate(-42 44 76)"/>
                        <ellipse cx="62" cy="54" rx="13" ry="5" transform="rotate(-46 62 54)"/>
                        <ellipse cx="78" cy="34" rx="10" ry="4" transform="rotate(-50 78 34)"/>
                        <ellipse cx="46" cy="104" rx="14" ry="5" transform="rotate(-12 46 104)"/>
                        <ellipse cx="68" cy="84" rx="12" ry="4.5" transform="rotate(-16 68 84)"/>
                    </g>
                </svg>
                <svg aria-hidden="true" viewBox="0 0 110 130" class="pointer-events-none absolute -bottom-2 -right-2 w-24 z-20 opacity-85 garden-daun-kanan">
                    <path d="M10 126 C24 84 48 48 92 16" fill="none" stroke="#C8A464" stroke-width="1.6"/>
                    <g fill="#2C5248" stroke="#C8A464" stroke-width="0.7">
                        <ellipse cx="26" cy="96" rx="16" ry="6" transform="rotate(-35 26 96)"/>
                        <ellipse cx="44" cy="76" rx="15" ry="5.5" transform="rotate(-42 44 76)"/>
                        <ellipse cx="62" cy="54" rx="13" ry="5" transform="rotate(-46 62 54)"/>
                        <ellipse cx="78" cy="34" rx="10" ry="4" transform="rotate(-50 78 34)"/>
                        <ellipse cx="46" cy="104" rx="14" ry="5" transform="rotate(-12 46 104)"/>
                        <ellipse cx="68" cy="84" rx="12" ry="4.5" transform="rotate(-16 68 84)"/>
                    </g>
                </svg>

                {{-- Partikel Kelopak 3D & Kunang-kunang --}}
                @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'kelopak-kunang', 'konteks' => 'utama'])

                {{-- Z-3: Tipografi Tengah Rumah Kaca --}}
                <div class="relative z-20 flex-1 flex flex-col justify-between px-10 pt-24 pb-8 text-center text-[#F4F8F6]">
                    <div class="my-auto rounded-3xl bg-[#0E1E18]/66 border border-[#C8A464]/45 px-4 py-6 shadow-xl space-y-2.5">
                        <img src="{{ $asetGarden['botani'] }}" alt="" @if ($pakaiVideoHeroVelvet) loading="lazy" decoding="async" @endif class="w-11 mx-auto opacity-95 animasi-ayun-3d">
                        <p class="text-[9.5px] font-semibold uppercase tracking-[0.26em] text-[#EEDAD4]">
                            Undangan Pernikahan
                        </p>
                        <p class="text-[9.5px] uppercase tracking-[0.26em] text-[#C8A464]">
                            We Are Getting Married!
                        </p>
                        <h2 class="pt-0.5 font-serif text-4xl sm:text-[2.75rem] font-bold leading-[1.06] text-white">
                            {{ $undangan->nama_panggilan_pria }}
                            <span class="block font-kaligrafi text-3xl sm:text-4xl font-normal text-[#F3DFA2] my-0.5">&amp;</span>
                            {{ $undangan->nama_panggilan_wanita }}
                        </h2>
                        <p class="pt-0.5 text-xs font-semibold uppercase tracking-[0.28em] text-[#F3DFA2]">
                            {{ $tanggalTitik }}
                        </p>
                        <p class="text-[10.5px] tracking-[0.14em] text-[#EEDAD4] break-all">
                            {{ $hashtagPasangan }}
                        </p>
                    </div>

                    <div class="pt-4 space-y-2">
                        <div aria-hidden="true" class="mx-auto w-4 h-7 rounded-full border border-[#EEDAD4]/65 flex justify-center pt-1.5">
                            <span class="w-1 h-1.5 rounded-full bg-[#C8A464] animasi-gulir-roda"></span>
                        </div>
                        <p class="text-[9px] uppercase tracking-[0.34em] text-[#C8A464]/90">Velvet Garden Conservatory</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- LAPISAN VIDEO MOTION HD VELVET GARDEN CONSERVATORY (15s @ 1.0x: GERBANG EMAS -> KUPU-KUPU -> BINGKAI KACA EMERALD) --}}
        @if ($pakaiVideoHeroVelvet)
            <video
                x-ref="heroVideo"
                x-show="!videoHeroGagal"
                src="{{ $asetGarden['videoHero'] }}"
                data-start-at="0"
                data-playback-rate="1"
                data-reveal-at="10.4"
                data-settled-at="14.2"
                muted
                playsinline
                webkit-playsinline
                preload="auto"
                x-on:timeupdate="pantauVideoHero($event)"
                x-on:ended="selesaiVideoHero()"
                x-on:error="videoHeroGagal = true; teksHeroTampil = true; videoHeroSedangIntro = false;"
                style="transform: translateZ(0);"
                class="absolute inset-0 z-10 w-full h-full object-cover object-center bg-[#0E1E18] pointer-events-none select-none"
            ></video>

            {{-- OVERLAY TIPOGRAFI KONSERVATORI KACA EMERALD — TERPUSAT SIMETRIS TEPAT DI DALAM LENGKUNGAN KACA VIDEO (DETIK 10.4) --}}
            <div
                x-show="!videoHeroGagal"
                class="absolute inset-x-[11%] top-[14%] bottom-[21.5%] z-20 flex flex-col items-center justify-center text-center px-3 velvet-video-teks"
                :class="teksHeroTampil ? 'opacity-100 scale-100 translate-y-0' : 'opacity-0 scale-95 translate-y-3 pointer-events-none'"
            >
                {{-- Pendar Kaca Zamrud Lembut Agar Tipografi Putih-Emas Sangat Tajam Namun Konservatori Tetap Tampak --}}
                <div
                    aria-hidden="true"
                    class="pointer-events-none absolute -inset-3 rounded-t-[10rem] rounded-b-3xl"
                    style="background: radial-gradient(ellipse 86% 74% at 50% 48%, rgba(10,25,21,0.52) 0%, rgba(10,25,21,0.24) 58%, transparent 100%);"
                ></div>

                <div class="relative z-10 w-full space-y-3 drop-shadow-[0_3px_16px_rgba(6,16,13,0.92)]">
                    <div class="space-y-1">
                        <img
                            src="{{ $asetGarden['botani'] }}"
                            alt=""
                            aria-hidden="true"
                            loading="lazy"
                            decoding="async"
                            class="w-11 sm:w-12 mx-auto opacity-95 drop-shadow-[0_4px_12px_rgba(0,0,0,0.45)]"
                        >
                        <p class="text-[10px] sm:text-[10.5px] font-bold uppercase tracking-[0.34em] text-[#EEDAD4]">
                            Undangan Pernikahan
                        </p>
                        <p class="text-[10px] sm:text-[10.5px] font-semibold uppercase tracking-[0.26em] text-[#DFC285]">
                            We Are Getting Married!
                        </p>
                    </div>

                    <h2
                        class="font-serif font-bold leading-[1.02] tracking-tight text-white pt-0.5"
                        style="font-size: clamp(2.65rem, 11vw, 3.35rem);"
                    >
                        <span class="block truncate">{{ $undangan->nama_panggilan_pria }}</span>
                        <span class="my-1 flex items-center justify-center gap-3.5">
                            <span aria-hidden="true" class="h-px w-10 bg-gradient-to-r from-transparent to-[#DFC285]"></span>
                            <span class="font-kaligrafi font-normal text-[2.45rem] sm:text-[2.9rem] text-[#F3DFA2] leading-none">&amp;</span>
                            <span aria-hidden="true" class="h-px w-10 bg-gradient-to-l from-transparent to-[#DFC285]"></span>
                        </span>
                        <span class="block truncate">{{ $undangan->nama_panggilan_wanita }}</span>
                    </h2>

                    <div class="pt-1 space-y-2.5">
                        <div class="inline-flex items-center gap-2 rounded-full bg-[#0E1E18]/65 backdrop-blur-xs border border-[#C8A464]/55 px-4 py-1.5 shadow-md max-w-full">
                            <span aria-hidden="true" class="w-1.5 h-1.5 rotate-45 bg-[#DFC285] shrink-0"></span>
                            <p class="text-[10.5px] sm:text-[11px] font-semibold uppercase tracking-[0.18em] text-[#F3DFA2] truncate">
                                {{ $tanggalLengkap }}
                            </p>
                            <span aria-hidden="true" class="w-1.5 h-1.5 rotate-45 bg-[#DFC285] shrink-0"></span>
                        </div>

                        <div class="space-y-0.5">
                            <p class="text-[13px] sm:text-sm font-bold uppercase tracking-[0.3em] text-[#EEDAD4]">
                                {{ $tanggalTitik }}
                            </p>
                            <p class="text-[11px] sm:text-xs font-medium tracking-[0.16em] text-[#DFC285] truncate">
                                {{ $hashtagPasangan }}
                            </p>
                        </div>
                    </div>

                    <div aria-hidden="true" class="pt-1 flex justify-center">
                        <div class="w-4 h-7 rounded-full border-[1.5px] border-[#EEDAD4]/70 flex justify-center pt-1.5">
                            <span class="w-1 h-1.5 rounded-full bg-[#DFC285] animasi-gulir-roda"></span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Tombol Putar Ulang Animasi Video Pembuka (Halus di Pojok Kiri Bawah) --}}
        @if ($pakaiVideoHeroVelvet)
            <button
                type="button"
                x-show="undanganTerbuka && videoHeroSelesai"
                x-cloak
                x-transition.opacity.duration.400ms
                @click="putarUlangVideoHero()"
                title="Putar ulang animasi pembuka"
                aria-label="Putar ulang animasi pembuka"
                class="absolute bottom-5 left-4 z-50 inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#0E1E18]/85 backdrop-blur-md border border-[#C8A464]/65 text-[#F3DFA2] shadow-md hover:bg-[#1E3B34] active:scale-95 transition cursor-pointer"
            >
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M3 12a9 9 0 1 0 3-6.7L3 8"/>
                    <path d="M3 3v5h5"/>
                </svg>
            </button>
        @endif

        {{-- Gradasi Halus Penyatu Tepi Bawah Hero Ke Marquee & Prelude Zamrud --}}
        <div
            aria-hidden="true"
            class="pointer-events-none absolute inset-x-0 bottom-0 h-14 z-40"
            style="background: linear-gradient(180deg, transparent 0%, rgba(14,30,24,0.58) 58%, #0E1E18 100%);"
        ></div>
    </div>
</section>

{{-- BOTANICAL MARQUEE --}}
<div class="py-2.5 bg-[#0E1E18] border-y border-[#C8A464]/45 overflow-hidden">
    <div class="animasi-marquee flex items-center gap-6 text-[10px] font-semibold uppercase tracking-[0.32em] text-[#EEDAD4]">
        @for ($i = 0; $i < 4; $i++)
            <span>Velvet Garden Motion</span>
            <span>&#10047;</span>
            <span>{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</span>
            <span>&#10047;</span>
            <span>{{ $tanggalTitik }}</span>
            <span>&#10047;</span>
            <span>{{ $hashtagPasangan }}</span>
            <span>&#10047;</span>
        @endfor
    </div>
</div>

{{-- SEKSI 2: PRELUDE GREENHOUSE SANCTUARY — MONOGRAM, POTRET LENGKUNG & KALAM DOA --}}
<section
    data-section-pembuka="taman"
    class="relative bg-gradient-to-b from-[#0E1E18] via-[#132623] to-[#162C28] text-[#F4F8F6] px-5 pt-11 pb-14 overflow-hidden"
>
    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-0"
        style="background: radial-gradient(circle at 50% 34%, rgba(200,164,100,0.12) 0%, transparent 58%);"
    ></div>

    <div class="relative z-10 max-w-md mx-auto text-center space-y-7">
        <div class="space-y-1.5">
            <p data-gsap="turun" class="text-[10px] font-semibold uppercase tracking-[0.34em] text-[#EEDAD4]">
                The Wedding Celebration
            </p>
            <div class="flex items-center justify-center gap-4 pt-1">
                <span data-gsap="garis" aria-hidden="true" class="h-px w-10 bg-gradient-to-r from-transparent to-[#C8A464]/70"></span>
                <div class="grid grid-cols-3 items-center min-w-[148px]">
                    <span data-gsap="kiri" class="fx-slide-left font-serif text-4xl sm:text-5xl font-bold text-[#F3DFA2]">
                        {{ $undangan->inisialPria() }}
                    </span>
                    <span data-gsap="mekar" data-gsap-delay="0.07" class="font-kaligrafi text-3xl text-[#EEDAD4]">&amp;</span>
                    <span data-gsap="kanan" class="fx-slide-right font-serif text-4xl sm:text-5xl font-bold text-[#F3DFA2]">
                        {{ $undangan->inisialWanita() }}
                    </span>
                </div>
                <span data-gsap="garis" aria-hidden="true" class="h-px w-10 bg-gradient-to-l from-transparent to-[#C8A464]/70"></span>
            </div>
        </div>

        @if ($urlFotoPembuka)
            <div data-gsap="potret" class="mx-auto w-56 sm:w-64 p-2 rounded-t-[9rem] rounded-b-3xl bg-[#FDFBF7]/10 border border-[#C8A464]/70 shadow-[0_24px_48px_-14px_rgba(5,12,10,0.75)]">
                <div class="overflow-hidden rounded-t-[8.5rem] rounded-b-2xl aspect-[4/5]">
                    <img
                        src="{{ $urlFotoPembuka }}"
                        alt="Foto Pembuka {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                        loading="lazy"
                        decoding="async"
                        class="w-full h-full object-cover object-top"
                    >
                </div>
            </div>
        @endif

        @if ($undangan->kutipan_ayat)
            <div class="pt-4">
                <blockquote data-gsap="naik" class="relative rounded-3xl bg-[#FDFBF7] text-[#1F3431] border-2 border-[#C8A464]/65 px-6 sm:px-7 pt-10 pb-7 shadow-2xl kartu-3d efek-shimmer-kartu space-y-3">
                    <span aria-hidden="true" class="pointer-events-none absolute top-2.5 left-2.5 h-3 w-3 border-t border-l border-[#C8A464]/75 rounded-tl-md"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute top-2.5 right-2.5 h-3 w-3 border-t border-r border-[#C8A464]/75 rounded-tr-md"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 left-2.5 h-3 w-3 border-b border-l border-[#C8A464]/75 rounded-bl-md"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 right-2.5 h-3 w-3 border-b border-r border-[#C8A464]/75 rounded-br-md"></span>

                    <img
                        src="{{ $asetGarden['garland'] }}"
                        alt=""
                        aria-hidden="true"
                        loading="lazy"
                        decoding="async"
                        class="pointer-events-none absolute -top-7 left-1/2 -translate-x-1/2 w-36 sm:w-40 drop-shadow-sm"
                    >

                    <p class="text-[9.5px] font-bold uppercase tracking-[0.32em] text-[#8D6F3A]">Kalam &amp; Doa</p>
                    <p class="font-serif italic text-sm sm:text-[15px] text-[#1F3431] leading-[1.78]">
                        &ldquo;{{ $undangan->kutipan_ayat }}&rdquo;
                    </p>
                    <div class="flex items-center justify-center gap-3 px-8 pt-1" aria-hidden="true">
                        <span class="h-px flex-1 bg-[#C8A464]/45"></span>
                        <span class="w-1.5 h-1.5 rotate-45 bg-[#C8A464]"></span>
                        <span class="h-px flex-1 bg-[#C8A464]/45"></span>
                    </div>
                    <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-[#3E5A5C]">{{ $hashtagPasangan }}</p>
                </blockquote>
            </div>
        @endif
    </div>
</section>
