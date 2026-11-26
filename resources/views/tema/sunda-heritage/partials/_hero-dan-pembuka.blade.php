{{-- SEKSI 1: PANGGUNG SINEMA 2.5D 60FPS PRIANGAN HERITAGE (+ SLOT VIDEO MP4 OTOMATIS) --}}
@php
    $pakaiVideoHeroSunda = ! empty($asetSunda['videoHero']) && empty($urlFotoLatarCustom);
@endphp

<section
    data-diorama-3d="{{ $tierAktif }}"
    data-cinema-duration="4300"
    data-autoscroll-delay="6800"
    :class="({{ $pakaiVideoHeroSunda ? 'undanganTerbuka && videoHeroGagal' : 'undanganTerbuka' }}) ? 'cinema-aktif' : ''"
    class="sunda-hero-layar-penuh relative w-full overflow-hidden diorama-panggung-3d bg-[#3B1414]"
>
    <div
        class="relative w-full h-full diorama-kamera-3d"
        @if ($pakaiVideoHeroSunda)
            :class="!videoHeroGagal ? 'sunda-kamera-video-aktif' : ''"
        @endif
    >
        {{-- LAPISAN SINEMA 2.5D BERLAPIS 60FPS (AKTIF DEFAULT & FALLBACK OTOMATIS) --}}
        <div
            class="absolute inset-0 w-full h-full {{ $pakaiVideoHeroSunda ? 'z-0' : 'z-10' }}"
            @if ($pakaiVideoHeroSunda)
                x-show="videoHeroGagal"
                x-cloak
            @endif
        >
            {{-- Z-0: Panorama Lembah Parahyangan & Rumah Panggung Priangan (Dolly Kamera Halus) --}}
            <div class="lapis-paralaks-scroll absolute -inset-4 pointer-events-none" style="--sp: 0.05; --pz: 0px;">
                <img
                    src="{{ $urlFotoLatar }}"
                    alt="Priangan Heritage"
                    @if ($pakaiVideoHeroSunda) loading="lazy" decoding="async" @endif
                    class="w-full h-full object-cover object-center sunda-latar-dolly"
                >
                {{-- Pendar Fajar Hangat & Vignette Tepi Atas-Bawah --}}
                <div
                    aria-hidden="true"
                    class="absolute inset-0"
                    style="background: linear-gradient(180deg, rgba(46,16,16,0.52) 0%, rgba(74,23,23,0.12) 28%, rgba(250,244,232,0.06) 54%, rgba(59,20,20,0.42) 82%, #4A1717 100%);"
                ></div>
            </div>

            {{-- Z-1: Sinar Fajar Parahyangan Menyapu Lembut --}}
            <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden z-10">
                <div class="absolute -top-24 left-[12%] w-44 h-[125%] bg-gradient-to-b from-[#FFF5D6]/26 via-[#E7C87D]/10 to-transparent blur-xl sunda-sinar-pagi"></div>
                <div class="absolute -top-20 right-[14%] w-32 h-[115%] bg-gradient-to-b from-[#FFF8E7]/18 via-[#D5B05C]/6 to-transparent blur-2xl sunda-sinar-pagi" style="animation-delay: 4.5s;"></div>
            </div>

            {{-- Z-2: Gapura Ukiran Priangan Memeluk Panggung --}}
            <div class="pointer-events-none absolute -inset-x-2 top-0 bottom-[8%] flex items-start justify-center z-10 sunda-gapura-masuk">
                <img
                    src="{{ $asetSunda['gapura'] }}"
                    alt=""
                    @if ($pakaiVideoHeroSunda) loading="lazy" decoding="async" @endif
                    class="w-full h-full object-contain object-top drop-shadow-[0_18px_36px_rgba(24,6,6,0.55)]"
                >
            </div>

            {{-- Z-3: Ronce Melati Kiri & Kanan Turun Dari Lengkungan Gapura Lalu Bergoyang Organik --}}
            <svg aria-hidden="true" viewBox="0 0 80 240" class="pointer-events-none absolute top-[10%] left-4 w-11 z-20 sunda-melati-kiri">
                <path d="M22 0 C20 65 26 140 20 215" stroke="#E7C87D" stroke-width="1.2" fill="none"/>
                <path d="M48 0 C52 55 44 120 48 180" stroke="#E7C87D" stroke-width="1" fill="none"/>
                <g fill="#FFFDF8" stroke="#C59B43" stroke-width="0.6">
                    <circle cx="22" cy="24" r="4.5"/><circle cx="21" cy="48" r="4"/><circle cx="23" cy="74" r="5"/><circle cx="22" cy="100" r="4"/><circle cx="24" cy="128" r="4.5"/><circle cx="21" cy="156" r="4"/><circle cx="20" cy="184" r="4.5"/>
                    <circle cx="48" cy="28" r="4"/><circle cx="49" cy="54" r="4.5"/><circle cx="47" cy="82" r="4"/><circle cx="46" cy="110" r="4.5"/><circle cx="48" cy="138" r="4"/><circle cx="48" cy="162" r="4"/>
                </g>
                <path d="M16 212 L20 232 L24 212 Z" fill="#C59B43"/>
            </svg>
            <svg aria-hidden="true" viewBox="0 0 80 240" class="pointer-events-none absolute top-[10%] right-4 w-11 z-20 sunda-melati-kanan">
                <path d="M22 0 C20 65 26 140 20 215" stroke="#E7C87D" stroke-width="1.2" fill="none"/>
                <path d="M48 0 C52 55 44 120 48 180" stroke="#E7C87D" stroke-width="1" fill="none"/>
                <g fill="#FFFDF8" stroke="#C59B43" stroke-width="0.6">
                    <circle cx="22" cy="24" r="4.5"/><circle cx="21" cy="48" r="4"/><circle cx="23" cy="74" r="5"/><circle cx="22" cy="100" r="4"/><circle cx="24" cy="128" r="4.5"/><circle cx="21" cy="156" r="4"/><circle cx="20" cy="184" r="4.5"/>
                    <circle cx="48" cy="28" r="4"/><circle cx="49" cy="54" r="4.5"/><circle cx="47" cy="82" r="4"/><circle cx="46" cy="110" r="4.5"/><circle cx="48" cy="138" r="4"/><circle cx="48" cy="162" r="4"/>
                </g>
                <path d="M16 212 L20 232 L24 212 Z" fill="#C59B43"/>
            </svg>

            {{-- Partikel Melati & Burung Bawaan + Kanvas 60fps Kupu-Kupu Emas & Kelopak Hidup --}}
            @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'melati-burung', 'konteks' => 'utama'])
            <canvas
                aria-hidden="true"
                x-data="kanvasSinemaTema({
                    kupuUtama: '#DFB15B',
                    kupuTepi: '#5A1E1E',
                    kelopak: ['#FFFDF8', '#FAF1DF', '#E7C87D'],
                    kilau: '#FFF2C6',
                    burung: 'rgba(74, 23, 23, 0.36)',
                    jumlahKupu: 5,
                    jumlahKelopak: 16,
                    jumlahKilau: 28
                })"
                class="pointer-events-none absolute inset-0 z-20 h-full w-full"
            ></canvas>

            {{-- Z-5: Bingkai Ukiran Emas Priangan + Mahkota Siger & Anggrek Bulan Mekar Di Tengah --}}
            <div class="absolute inset-x-5 top-[15%] bottom-[20%] z-30 flex items-center justify-center">
                <div class="relative w-full max-w-[298px] max-h-full aspect-[780/1043] flex items-center justify-center sunda-bingkai-mekar">
                    {{-- Lapisan Beludru Marun Halus di Dalam Oval agar Tipografi Emas-Putih Sangat Kontras --}}
                    <div
                        aria-hidden="true"
                        class="absolute inset-x-[14%] inset-y-[10%] rounded-[50%] bg-gradient-to-b from-[#3A1212]/88 via-[#4B1919]/82 to-[#2E0E0E]/92 backdrop-blur-[2px] shadow-[inset_0_0_42px_rgba(231,200,125,0.28),0_20px_50px_rgba(20,5,5,0.55)]"
                    ></div>

                    {{-- Bingkai Emas Priangan Transparan --}}
                    <img
                        src="{{ $asetSunda['bingkaiPriangan'] }}"
                        alt=""
                        aria-hidden="true"
                        @if ($pakaiVideoHeroSunda) loading="lazy" decoding="async" @endif
                        class="pointer-events-none absolute inset-0 w-full h-full object-contain z-10 drop-shadow-[0_12px_28px_rgba(26,7,7,0.55)]"
                    >

                    {{-- Mahkota Siger Sunda & Anggrek Bulan Di Puncak Bingkai --}}
                    <img
                        src="{{ $asetSunda['siger'] }}"
                        alt=""
                        @if ($pakaiVideoHeroSunda) loading="lazy" decoding="async" @endif
                        class="pointer-events-none absolute -top-9 left-1/2 -translate-x-1/2 w-24 sm:w-28 z-20 drop-shadow-[0_8px_18px_rgba(26,7,7,0.6)] sunda-siger-mahkota"
                    >

                    {{-- Tipografi Mempelai Bertahap Di Dalam Bingkai Emas --}}
                    <div class="relative z-20 px-9 pt-7 pb-5 text-center text-white flex flex-col items-center justify-center space-y-1.5">
                        <div class="sunda-teks-1 space-y-0.5">
                            <p class="text-[9.5px] font-bold uppercase tracking-[0.34em] text-[#F3E5AB]">
                                Wilujeng Sumping
                            </p>
                            <p class="text-[9px] uppercase tracking-[0.24em] text-white/80">
                                We Are Getting Married!
                            </p>
                        </div>

                        <h2 class="sunda-teks-2 font-serif text-[2.1rem] sm:text-[2.35rem] font-bold leading-[1.06] text-[#FFFDF8] drop-shadow-[0_3px_14px_rgba(24,6,6,0.65)] pt-1">
                            <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
                            <span class="my-0.5 flex items-center justify-center gap-2.5">
                                <span aria-hidden="true" class="h-px w-6 bg-[#E7C87D]/70"></span>
                                <span class="font-kaligrafi font-normal text-3xl text-[#E7C87D] leading-none">&amp;</span>
                                <span aria-hidden="true" class="h-px w-6 bg-[#E7C87D]/70"></span>
                            </span>
                            <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
                        </h2>

                        <div class="sunda-teks-3 pt-1.5 space-y-0.5">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-[#F3E5AB]">
                                {{ $tanggalTitik }}
                            </p>
                            <p class="text-[10px] tracking-[0.15em] text-white/90">
                                {{ $hashtagPasangan }}
                            </p>
                        </div>

                        {{-- Gelombang Mega Mendung Emas + Indikator Gulir --}}
                        <div class="sunda-teks-4 pt-2 flex flex-col items-center gap-1.5" aria-hidden="true">
                            <svg viewBox="0 0 360 44" class="w-28 opacity-85 animasi-awan">
                                <path d="M10 34 C35 12 72 12 96 26 C115 8 156 6 180 22 C204 6 245 8 264 26 C288 12 325 12 350 34" fill="none" stroke="#E7C87D" stroke-width="2.4" stroke-linecap="round"/>
                            </svg>
                            <div class="w-4 h-7 rounded-full border-[1.5px] border-[#F3E5AB]/80 flex justify-center pt-1.5">
                                <span class="w-1 h-1.5 rounded-full bg-[#F3E5AB] animasi-gulir-roda"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Z-6: Hamparan Bunga Kamelia Marun, Anggrek Bulan & Melati Foreground Bawah --}}
            <img
                src="{{ $asetSunda['bungaDepan'] }}"
                alt=""
                aria-hidden="true"
                @if ($pakaiVideoHeroSunda) loading="lazy" decoding="async" @endif
                class="pointer-events-none absolute -bottom-1 inset-x-0 w-full z-40 drop-shadow-[0_-10px_24px_rgba(32,10,10,0.45)] sunda-bunga-masuk"
            >

            {{-- Z-7: Sepasang Sayap Gerbang Ukiran Kujang & Mega Mendung Menyapu Terbuka Melewati Kamera --}}
            <img
                src="{{ $asetSunda['tiraiKujang'] }}"
                alt=""
                aria-hidden="true"
                @if ($pakaiVideoHeroSunda) loading="lazy" decoding="async" @endif
                class="pointer-events-none absolute -top-2 -left-[12%] h-[104%] w-[70%] object-cover object-right z-50 drop-shadow-[16px_0_32px_rgba(20,5,5,0.65)] sunda-tirai-kiri"
            >
            <img
                src="{{ $asetSunda['tiraiKujang'] }}"
                alt=""
                aria-hidden="true"
                @if ($pakaiVideoHeroSunda) loading="lazy" decoding="async" @endif
                class="pointer-events-none absolute -top-2 -right-[12%] h-[104%] w-[70%] object-cover object-right z-50 drop-shadow-[16px_0_32px_rgba(20,5,5,0.65)] sunda-tirai-kanan"
            >
        </div>

        {{-- LAPISAN VIDEO MOTION HD SUNDA SIGER HERITAGE (24s @ 1.2x = ~20s: 00:00 GERBANG KUJANG -> 00:08 RUMAH PANGGUNG -> 00:20.4 BINGKAI SIGER) --}}
        @if ($pakaiVideoHeroSunda)
            <video
                x-ref="heroVideo"
                x-show="!videoHeroGagal"
                src="{{ $asetSunda['videoHero'] }}"
                data-start-at="0"
                data-playback-rate="1.2"
                data-reveal-at="20.4"
                data-settled-at="22.8"
                muted
                playsinline
                webkit-playsinline
                preload="auto"
                x-on:timeupdate="pantauVideoHero($event)"
                x-on:ended="selesaiVideoHero()"
                x-on:error="videoHeroGagal = true; teksHeroTampil = true; videoHeroSedangIntro = false;"
                style="transform: translateZ(0);"
                class="absolute inset-0 z-10 w-full h-full object-cover object-center bg-[#3B1414] pointer-events-none select-none"
            ></video>

            {{-- OVERLAY TIPOGRAFI MEMPELAI — MUNCUL SINKRON TEPAT DI DALAM BINGKAI OVAL MARUN-EMAS VIDEO (DETIK 20.4 / ~17s NYATA) --}}
            <div
                x-show="!videoHeroGagal"
                class="absolute inset-x-[18%] top-[18%] bottom-[38%] z-20 flex flex-col items-center justify-center text-center px-3 sunda-video-teks"
                :class="teksHeroTampil ? 'opacity-100 scale-100 translate-y-0' : 'opacity-0 scale-95 translate-y-3 pointer-events-none'"
            >
                <div class="space-y-1.5 drop-shadow-[0_3px_14px_rgba(24,6,6,0.72)]">
                    <p class="text-[9.5px] font-bold uppercase tracking-[0.34em] text-[#F3E5AB]">
                        Wilujeng Sumping
                    </p>
                    <p class="text-[9px] uppercase tracking-[0.24em] text-[#FAF4E8]/85">
                        We Are Getting Married!
                    </p>

                    <h2 class="font-serif text-[2rem] sm:text-[2.35rem] font-semibold uppercase tracking-[0.1em] leading-[1.06] text-[#FFFDF8] pt-1">
                        <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
                        <span class="my-0.5 flex items-center justify-center gap-2.5">
                            <span aria-hidden="true" class="h-px w-6 bg-[#E7C87D]/70"></span>
                            <span class="font-kaligrafi normal-case text-3xl text-[#E7C87D] leading-none">&amp;</span>
                            <span aria-hidden="true" class="h-px w-6 bg-[#E7C87D]/70"></span>
                        </span>
                        <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
                    </h2>

                    <p class="text-[11px] font-semibold tracking-[0.32em] text-[#F3E5AB] pt-1.5">
                        {{ $tanggalTitik }}
                    </p>
                    <p class="text-[10px] font-medium tracking-[0.15em] text-[#FAF4E8]/92">
                        {{ $hashtagPasangan }}
                    </p>

                    <div aria-hidden="true" class="pt-2 flex flex-col items-center gap-1.5">
                        <svg viewBox="0 0 360 44" class="w-24 opacity-85 animasi-awan">
                            <path d="M10 34 C35 12 72 12 96 26 C115 8 156 6 180 22 C204 6 245 8 264 26 C288 12 325 12 350 34" fill="none" stroke="#E7C87D" stroke-width="2.4" stroke-linecap="round"/>
                        </svg>
                        <div class="w-4 h-7 rounded-full border-[1.5px] border-[#F3E5AB]/85 flex justify-center pt-1.5">
                            <span class="w-1 h-1.5 rounded-full bg-[#F3E5AB] animasi-gulir-roda"></span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Tombol Putar Ulang Animasi Pembuka Sinema (Halus di Pojok Kiri Bawah) --}}
        <button
            type="button"
            x-show="undanganTerbuka && ({{ $pakaiVideoHeroSunda ? 'videoHeroSelesai' : 'cinema25dSelesai' }})"
            x-cloak
            x-transition.opacity.duration.400ms
            @click="{{ $pakaiVideoHeroSunda ? 'putarUlangVideoHero()' : 'putarUlangCinema25d()' }}"
            title="Putar ulang animasi pembuka"
            aria-label="Putar ulang animasi pembuka"
            class="absolute bottom-5 left-4 z-50 inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#3B1414]/75 backdrop-blur-md border border-[#E7C87D]/60 text-[#F3E5AB] shadow-md hover:bg-[#5A1E1E] active:scale-95 transition cursor-pointer"
        >
            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M3 12a9 9 0 1 0 3-6.7L3 8"/>
                <path d="M3 3v5h5"/>
            </svg>
        </button>

        {{-- Gradasi Halus Penyatu Tepi Bawah Hero Ke Seksi Pembuka Marun --}}
        <div
            aria-hidden="true"
            class="pointer-events-none absolute inset-x-0 bottom-0 h-14 z-40"
            style="background: linear-gradient(180deg, transparent 0%, rgba(74,23,23,0.5) 58%, #5A1E1E 100%);"
        ></div>
    </div>
</section>

{{-- SEKSI 3: PRELUDE PRIANGAN, FOTO PEMBUKA, MONOGRAM BERTEMU & KUTIPAN AYAT --}}
@if ($undangan->fiturAktif('ayat_pembuka'))
<section
    data-section-pembuka="priangan"
    class="relative bg-gradient-to-b from-[#5A1E1E] via-[#4A1717] to-[#3B1414] shadow-[0_-2px_0_0_#5A1E1E] text-[#FAF4E8] px-5 pt-11 pb-14 overflow-hidden"
>
    {{-- Siluet Halus Gapura & Pendar Hangat Latar Beludru Marun --}}
    <img
        src="{{ $asetSunda['gapura'] }}"
        alt=""
        aria-hidden="true"
        loading="lazy"
        decoding="async"
        class="pointer-events-none absolute inset-x-0 top-0 w-full h-full object-cover object-top opacity-[0.07]"
    >
    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-0"
        style="background: radial-gradient(circle at 50% 42%, rgba(231,200,125,0.16) 0%, rgba(74,23,23,0.04) 48%, rgba(34,10,10,0.45) 100%);"
    ></div>

    <div class="relative z-10 max-w-md mx-auto text-center space-y-7">
        {{-- Foto Pembuka Berbingkai Oval Filigree Emas Ganda (Tersembunyi pada Mode Tanpa Foto) --}}
        @if ($urlFotoPembuka)
            <div data-gsap="potret" class="relative mx-auto w-56 sm:w-60">
                <span aria-hidden="true" class="pointer-events-none absolute -inset-2 rounded-[999px] border border-[#E7C87D]/30"></span>
                <div class="p-2 rounded-[999px] border-2 border-[#C59B43]/85 bg-[#321010]/70 shadow-[0_22px_48px_-12px_rgba(14,4,4,0.75)]">
                    <div class="overflow-hidden rounded-[999px] aspect-[4/5] border border-[#F3E5AB]/50">
                        <img
                            src="{{ $urlFotoPembuka }}"
                            alt="Potret Pembuka {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                            loading="lazy"
                            decoding="async"
                            class="w-full h-full object-cover object-top"
                        >
                    </div>
                </div>
            </div>
        @endif

        {{-- Monogram Pasangan Bertemu Kiri <-> Kanan dengan Garis Emas --}}
        <div class="flex items-center justify-center gap-4 px-4">
            <span data-gsap="garis" aria-hidden="true" class="h-px flex-1 max-w-[54px] bg-gradient-to-r from-transparent to-[#E7C87D]/65"></span>
            <div class="grid grid-cols-3 items-center gap-2 min-w-[140px]">
                <span data-gsap="kiri" class="fx-slide-left font-serif text-4xl sm:text-[2.75rem] font-bold text-[#F3E5AB] drop-shadow-[0_3px_10px_rgba(16,4,4,0.5)]">
                    {{ $undangan->inisialPria() }}
                </span>
                <span data-gsap="mekar" data-gsap-delay="0.07" class="font-kaligrafi text-3xl text-[#E7C87D]/90">&amp;</span>
                <span data-gsap="kanan" class="fx-slide-right font-serif text-4xl sm:text-[2.75rem] font-bold text-[#F3E5AB] drop-shadow-[0_3px_10px_rgba(16,4,4,0.5)]">
                    {{ $undangan->inisialWanita() }}
                </span>
            </div>
            <span data-gsap="garis" aria-hidden="true" class="h-px flex-1 max-w-[54px] bg-gradient-to-l from-transparent to-[#E7C87D]/65"></span>
        </div>

        {{-- Petuah / Kutipan Ayat Bergaya Editorial Beludru-Emas Menyatu (Animasi Rinci Per Komponen) --}}
        @if ($undangan->kutipan_ayat)
            <div class="pt-4">
                <blockquote class="relative rounded-[1.75rem] bg-gradient-to-b from-[#3B1414]/88 via-[#441717]/78 to-[#310F0F]/92 backdrop-blur-sm border border-[#E7C87D]/45 px-6 sm:px-7 pt-9 pb-7 shadow-[0_20px_46px_-14px_rgba(14,4,4,0.7),inset_0_1px_0_rgba(243,229,171,0.22)] kartu-3d">
                    {{-- Aksen Sudut Halus Emas --}}
                    <span aria-hidden="true" class="pointer-events-none absolute top-2.5 left-2.5 h-3.5 w-3.5 border-t border-l border-[#E7C87D]/65 rounded-tl-md"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute top-2.5 right-2.5 h-3.5 w-3.5 border-t border-r border-[#E7C87D]/65 rounded-tr-md"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 left-2.5 h-3.5 w-3.5 border-b border-l border-[#E7C87D]/65 rounded-bl-md"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 right-2.5 h-3.5 w-3.5 border-b border-r border-[#E7C87D]/65 rounded-br-md"></span>

                    {{-- Mahkota Siger Bertengger Anggun di Tepi Atas Bingkai Kutipan --}}
                    <div data-gsap="turun" class="absolute -top-6 inset-x-0 mx-auto w-fit rounded-full bg-[#4A1717] border border-[#E7C87D]/60 px-3 py-1.5 shadow-[0_8px_18px_rgba(16,4,4,0.65)]">
                        <img
                            src="{{ $asetSunda['siger'] }}"
                            alt=""
                            loading="lazy"
                            decoding="async"
                            class="w-10 mx-auto"
                        >
                    </div>

                    <p data-gsap="teks" class="text-[9.5px] font-bold uppercase tracking-[0.34em] text-[#E7C87D] pt-1">
                        Petuah &amp; Doa
                    </p>

                    <span data-gsap="mekar" aria-hidden="true" class="block font-serif text-5xl leading-[0.65] text-[#E7C87D]/30 pt-3 select-none">
                        &ldquo;
                    </span>

                    <p data-gsap="naik" data-gsap-delay="0.06" class="font-serif italic text-[15px] sm:text-base leading-[1.78] text-[#FFF8EC]/95 pt-1">
                        {{ $undangan->kutipan_ayat }}
                    </p>

                    <div data-gsap="garis" class="mt-5 flex items-center justify-center gap-3 px-8" aria-hidden="true">
                        <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#E7C87D]/55"></span>
                        <span class="w-1.5 h-1.5 rotate-45 bg-[#E7C87D]/85"></span>
                        <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#E7C87D]/55"></span>
                    </div>

                    <p data-gsap="mekar" data-gsap-delay="0.06" class="mt-2.5 text-[10px] font-medium tracking-[0.22em] text-[#F3E5AB]/80">
                        {{ $hashtagPasangan }}
                    </p>
                </blockquote>
            </div>
        @endif
    </div>
</section>
@endif
