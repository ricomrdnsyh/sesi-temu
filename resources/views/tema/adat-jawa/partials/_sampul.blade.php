{{-- SEKSI 1: SAMPUL FULL-BLEED CINEMATIC ROYAL KERATON (POSTER LOWER-THIRD + ANIMASI 60FPS) --}}
<section
    data-transisi-sampul="fade-halus"
    class="tirai-fade-halus tirai-gulir-atas fixed inset-0 mx-auto h-dvh w-full lg:w-[460px] xl:w-[490px] z-40 {{ $tampilBarDemo ? 'pt-28 sm:pt-20 lg:pt-14' : '' }}"
    style="height: 100dvh;"
    :class="undanganTerbuka ? 'tirai-terbuka pointer-events-none' : ''"
>
    <div class="relative w-full h-full flex flex-col {{ $pakaiFotoSampul ? 'justify-between' : 'justify-center items-center px-6 py-7' }} overflow-hidden bg-[#24130A]">
        {{-- Foto Sampul Penuh Full-Layar dengan Animasi Nafas Halus (Ken Burns) --}}
        <img
            src="{{ $pakaiFotoSampul ? $urlFotoSampul : $asetJawa['latarHutan'] }}"
            alt="{{ $pakaiFotoSampul ? "Foto Sampul {$undangan->nama_panggilan_pria} & {$undangan->nama_panggilan_wanita}" : 'Sampul Adat Jawa Keraton' }}"
            fetchpriority="high"
            decoding="sync"
            class="absolute inset-0 w-full h-full object-cover {{ $pakaiFotoSampul ? 'object-top scale-[1.03] animasi-nafas' : 'object-center scale-105 animasi-nafas' }}"
        >

        {{-- Gradasi Sogan Sinematik (Bening di Area Wajah & Gebyok Atas, Pekat Elegan di Sepertiga Bawah) --}}
        <div
            aria-hidden="true"
            class="pointer-events-none absolute inset-0"
            style="background: {{ $pakaiFotoSampul
                ? 'linear-gradient(180deg, rgba(22,11,6,0.68) 0%, rgba(22,11,6,0.16) 17%, rgba(22,11,6,0.0) 34%, rgba(22,11,6,0.06) 49%, rgba(28,14,7,0.68) 67%, rgba(22,11,6,0.94) 84%, rgba(16,8,4,0.99) 100%)'
                : 'linear-gradient(180deg, rgba(28,14,8,0.82) 0%, rgba(54,30,18,0.58) 48%, rgba(24,12,6,0.92) 100%)' }};"
        ></div>

        {{-- Berkas Cahaya Lilin Keraton Diagonal Menyapu Lembut --}}
        <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden z-[5]">
            <div class="absolute -top-24 left-[16%] w-40 h-[130%] bg-gradient-to-b from-[#F3E5AB]/20 via-[#D7BB83]/6 to-transparent blur-2xl jawa-sinar-keraton"></div>
            <div class="absolute -top-20 right-[12%] w-32 h-[120%] bg-gradient-to-b from-[#E5C98B]/14 via-transparent to-transparent blur-2xl jawa-sinar-keraton" style="animation-delay: 4.5s;"></div>
        </div>

        {{-- Trim Halus Batik Kawung Tepi Atas & Bawah --}}
        <img
            src="{{ $asetJawa['kawungAtas'] }}"
            alt=""
            aria-hidden="true"
            class="pointer-events-none absolute top-0 inset-x-0 w-full h-9 sm:h-10 object-cover object-bottom opacity-24 jawa-mask-kawung-atas z-[6]"
        >
        <img
            src="{{ $asetJawa['kawungBawah'] }}"
            alt=""
            aria-hidden="true"
            class="pointer-events-none absolute bottom-0 inset-x-0 w-full h-10 sm:h-11 object-cover object-top opacity-22 jawa-mask-kawung-bawah z-[6]"
        >

        @if (! $pakaiFotoSampul)
            <img src="{{ $asetJawa['pendopo'] }}" alt="" aria-hidden="true" class="pointer-events-none absolute bottom-10 left-1/2 -translate-x-1/2 w-[84%] opacity-38 drop-shadow-xl z-[6]">
            <img src="{{ $asetJawa['bungaDepan'] }}" alt="" aria-hidden="true" class="pointer-events-none absolute bottom-0 inset-x-0 w-full opacity-42 z-[6]">
        @endif

        {{-- Bingkai Persegi Bertingkat Bersudut L-Emas Khas Keraton (Kontras dari Lengkungan Sunda) --}}
        <div aria-hidden="true" class="pointer-events-none absolute inset-3 rounded-xl border border-[#D7BB83]/30 z-10">
            <span class="absolute -top-[1px] -left-[1px] h-5 w-5 rounded-tl-lg border-t-2 border-l-2 border-[#E5C98B]/85"></span>
            <span class="absolute -top-[1px] -right-[1px] h-5 w-5 rounded-tr-lg border-t-2 border-r-2 border-[#E5C98B]/85"></span>
            <span class="absolute -bottom-[1px] -left-[1px] h-5 w-5 rounded-bl-lg border-b-2 border-l-2 border-[#E5C98B]/85"></span>
            <span class="absolute -bottom-[1px] -right-[1px] h-5 w-5 rounded-br-lg border-b-2 border-r-2 border-[#E5C98B]/85"></span>
        </div>

        {{-- Lapisan Animasi Hidup Keraton: Kelopak Wayang-Flora + Bara Debu Emas Prada --}}
        <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden z-[15]">
            @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'wayang-flora', 'konteks' => 'sampul'])

            @foreach ([
                ['bottom: 16%; left: 10%;', 'w-1.5 h-1.5', '0s'],
                ['bottom: 28%; left: 22%;', 'w-2 h-2', '1.4s'],
                ['bottom: 20%; right: 12%;', 'w-1.5 h-1.5', '0.7s'],
                ['bottom: 36%; right: 18%;', 'w-2 h-2', '2.2s'],
                ['bottom: 48%; left: 14%;', 'w-1.5 h-1.5', '3.0s'],
                ['bottom: 56%; right: 14%;', 'w-1.5 h-1.5', '1.8s'],
                ['bottom: 12%; left: 50%;', 'w-1.5 h-1.5', '2.6s'],
            ] as [$posisi, $ukuran, $jeda])
                <span
                    class="absolute rounded-full {{ $ukuran }} bg-[#F3E5AB] shadow-[0_0_12px_rgba(215,187,131,0.95)] animasi-debu-emas"
                    style="{{ $posisi }} animation-delay: {{ $jeda }};"
                ></span>
            @endforeach
        </div>

        @if ($pakaiFotoSampul)
            {{-- 1. MASTHEAD KERATON MINIMAL DI TEPI ATAS (MEMBIARKAN WAJAH & GEBYOK 100% LEGA) --}}
            <header class="relative z-20 shrink-0 px-7 {{ $tampilBarDemo ? 'pt-5 sm:pt-6' : 'pt-6 sm:pt-7' }} jawa-masuk-1">
                <div class="grid grid-cols-[1fr_auto_1fr] items-center gap-3">
                    <div class="flex items-center gap-2 justify-end">
                        <span class="text-[9px] font-semibold uppercase tracking-[0.3em] text-[#F3E5AB]/92 drop-shadow">
                            Pawiwahan
                        </span>
                        <span aria-hidden="true" class="h-px flex-1 max-w-[34px] bg-gradient-to-l from-[#E5C98B]/80 to-transparent"></span>
                    </div>

                    <img
                        src="{{ $asetJawa['gununganKecil'] }}"
                        alt=""
                        aria-hidden="true"
                        class="w-10 sm:w-11 drop-shadow-[0_4px_12px_rgba(0,0,0,0.75)] animasi-ayun-3d"
                    >

                    <div class="flex items-center gap-2 justify-start">
                        <span aria-hidden="true" class="h-px flex-1 max-w-[34px] bg-gradient-to-r from-[#E5C98B]/80 to-transparent"></span>
                        <span class="text-[9px] font-semibold uppercase tracking-[0.26em] text-[#F3E5AB]/92 drop-shadow">
                            {{ $tanggalTitik }}
                        </span>
                    </div>
                </div>
            </header>

            {{-- RUANG BEBAS PENUH UNTUK FOTO MEMPELAI FULL-SCREEN --}}
            <div class="flex-1 min-h-0"></div>

            {{-- 2. PANGGUNG POSTER SINEMATIK BAWAH: NAMA MEMPELAI + KARTU TAMU BELUDRU SOGAN --}}
            <div class="relative z-20 shrink-0 px-5 pb-5 sm:pb-7 text-center text-white space-y-3">
                {{-- Blok Tajuk Mempelai Menyatu di Sepertiga Bawah (Beda Total dari Layout Atas-Bawah Sunda) --}}
                <div class="space-y-0.5 px-2 jawa-masuk-2">
                    <p class="font-kaligrafi text-[1.75rem] sm:text-[2rem] leading-none text-[#E5C98B] drop-shadow-[0_2px_10px_rgba(0,0,0,0.75)]">
                        The Wedding of
                    </p>
                    <h1 class="font-serif text-[2.3rem] sm:text-[2.7rem] font-semibold tracking-[0.03em] leading-[1.04] text-[#FFFBF4] drop-shadow-[0_4px_18px_rgba(0,0,0,0.8)]">
                        {{ $undangan->nama_panggilan_pria }}
                        <span class="font-kaligrafi font-normal text-[#D7BB83] mx-1">&amp;</span>
                        {{ $undangan->nama_panggilan_wanita }}
                    </h1>
                    <div class="flex items-center justify-center gap-2.5 pt-1.5 px-4">
                        <span aria-hidden="true" class="h-px flex-1 max-w-[46px] bg-gradient-to-r from-transparent to-[#D7BB83]/75 jawa-garis-cahaya"></span>
                        <span aria-hidden="true" class="w-1 h-1 rotate-45 bg-[#E5C98B]"></span>
                        <p class="text-[9.5px] sm:text-[10px] font-medium uppercase tracking-[0.26em] text-[#F3E5AB]/92 drop-shadow">
                            {{ $tanggalLengkap }}
                        </p>
                        <span aria-hidden="true" class="w-1 h-1 rotate-45 bg-[#E5C98B]"></span>
                        <span aria-hidden="true" class="h-px flex-1 max-w-[46px] bg-gradient-to-l from-transparent to-[#D7BB83]/75 jawa-garis-cahaya"></span>
                    </div>
                </div>

                {{-- Kartu Tamu Beludru-Kaca Sogan dengan Tombol Keraton Berkilau --}}
                <div class="jawa-masuk-3 space-y-2">
                    <div class="relative mx-auto w-full max-w-[332px] rounded-xl bg-gradient-to-b from-[#2A150B]/76 via-[#1E0F08]/84 to-[#170A05]/90 backdrop-blur-md border border-[#D7BB83]/42 px-4 py-3.5 shadow-[0_18px_40px_-14px_rgba(0,0,0,0.85),inset_0_1px_0_rgba(243,229,171,0.2)] space-y-2">
                        <span aria-hidden="true" class="pointer-events-none absolute top-1.5 left-1.5 h-2.5 w-2.5 border-t border-l border-[#E5C98B]/75"></span>
                        <span aria-hidden="true" class="pointer-events-none absolute top-1.5 right-1.5 h-2.5 w-2.5 border-t border-r border-[#E5C98B]/75"></span>
                        <span aria-hidden="true" class="pointer-events-none absolute bottom-1.5 left-1.5 h-2.5 w-2.5 border-b border-l border-[#E5C98B]/75"></span>
                        <span aria-hidden="true" class="pointer-events-none absolute bottom-1.5 right-1.5 h-2.5 w-2.5 border-b border-r border-[#E5C98B]/75"></span>

                        <div class="space-y-0.5">
                            <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
                            <p class="text-[9px] font-semibold uppercase tracking-[0.24em] text-[#D7BB83]/92">
                                Kepada Yth. Bapak/Ibu/Saudara/i
                            </p>
                            <p class="font-serif text-lg sm:text-[1.32rem] font-bold text-[#FFF7E2] leading-snug drop-shadow">
                                {{ $namaTamu }}
                            </p>
                        </div>

                        <button
                            type="button"
                            @click="bukaUndangan()"
                            class="jawa-tombol-emas relative w-full inline-flex items-center justify-center gap-2 rounded-lg border border-[#F3E5AB]/55 px-6 py-2.5 text-xs sm:text-[13px] font-semibold uppercase tracking-[0.18em] transition active:scale-[0.98] cursor-pointer"
                        >
                            <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="20" height="16" x="2" y="4" rx="2"/>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                            </svg>
                            <span>Buka Undangan</span>
                        </button>
                    </div>

                    <p class="text-[9.5px] italic text-white/68 max-w-xs mx-auto leading-snug">
                        Mohon maaf apabila ada kesalahan penulisan nama/gelar
                    </p>
                </div>
            </div>
        @else
            {{-- MODE TANPA FOTO: PLAKAT HERITAGE KERATON PERSEGI BERTINGKAT + SAYAP WAYANG & GUNUNGAN --}}
            <div class="relative z-20 w-full max-w-[356px] jawa-masuk-2">
                <div class="relative kartu-3d rounded-2xl bg-gradient-to-b from-[#331B10]/92 via-[#24120A]/94 to-[#1A0C06]/96 backdrop-blur-md border border-[#D7BB83]/60 p-2 shadow-[0_28px_70px_-16px_rgba(0,0,0,0.82)]">
                    <span aria-hidden="true" class="pointer-events-none absolute -top-1 -left-1 h-5 w-5 rounded-tl-xl border-t-2 border-l-2 border-[#F3E5AB]"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute -top-1 -right-1 h-5 w-5 rounded-tr-xl border-t-2 border-r-2 border-[#F3E5AB]"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute -bottom-1 -left-1 h-5 w-5 rounded-bl-xl border-b-2 border-l-2 border-[#F3E5AB]"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute -bottom-1 -right-1 h-5 w-5 rounded-br-xl border-b-2 border-r-2 border-[#F3E5AB]"></span>

                    <div class="rounded-xl border border-[#D7BB83]/32 px-5 pt-7 pb-6 text-center text-white space-y-4">
                        <div class="space-y-1.5">
                            <div class="relative mx-auto w-32 h-16 flex items-center justify-center">
                                <div aria-hidden="true" class="pointer-events-none absolute left-0 bottom-1 w-11 -scale-x-100">
                                    <img
                                        src="{{ $asetJawa['sayapWayang'] }}"
                                        alt=""
                                        class="w-full h-auto opacity-80 jawa-sayap-sampul"
                                    >
                                </div>
                                <div aria-hidden="true" class="pointer-events-none absolute right-0 bottom-1 w-11">
                                    <img
                                        src="{{ $asetJawa['sayapWayang'] }}"
                                        alt=""
                                        class="w-full h-auto opacity-80 jawa-sayap-sampul"
                                    >
                                </div>
                                <img
                                    src="{{ $asetJawa['gununganKecil'] }}"
                                    alt=""
                                    class="relative z-10 w-14 mx-auto opacity-95 drop-shadow-[0_6px_14px_rgba(0,0,0,0.75)] animasi-ayun-3d"
                                >
                            </div>

                            <p class="text-[9.5px] font-semibold uppercase tracking-[0.34em] text-[#D7BB83]">
                                Pawiwahan &bull; {{ $tanggalTitik }}
                            </p>
                            <p class="font-kaligrafi text-2xl sm:text-[1.75rem] leading-tight text-[#F3E5AB]">
                                The Wedding of
                            </p>
                            <h1 class="font-serif text-[2.2rem] sm:text-[2.5rem] font-semibold tracking-wide leading-[1.08] text-[#FFFBF4]">
                                <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
                                <span class="block font-kaligrafi font-normal text-3xl text-[#D7BB83] my-0.5">&amp;</span>
                                <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
                            </h1>
                            <p class="text-[10.5px] font-medium uppercase tracking-[0.24em] text-white/85 pt-1">
                                {{ $tanggalLengkap }}
                            </p>
                        </div>

                        <div class="flex items-center justify-center gap-3 px-6" aria-hidden="true">
                            <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#D7BB83]/60"></span>
                            <span class="w-1.5 h-1.5 rotate-45 bg-[#F3E5AB]"></span>
                            <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#D7BB83]/60"></span>
                        </div>

                        <div class="space-y-2 pt-0.5">
                            <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
                            <p class="text-[9.5px] font-semibold uppercase tracking-[0.22em] text-[#D7BB83]/90">
                                Kepada Yth. Bapak/Ibu/Saudara/i
                            </p>
                            <p class="font-serif text-xl sm:text-2xl font-bold text-[#FFF7E2]">
                                {{ $namaTamu }}
                            </p>
                            <div class="pt-2">
                                <button
                                    type="button"
                                    @click="bukaUndangan()"
                                    class="jawa-tombol-emas relative w-full inline-flex items-center justify-center gap-2 rounded-lg border border-[#F3E5AB]/55 px-6 py-2.5 text-xs sm:text-sm font-semibold uppercase tracking-[0.18em] transition active:scale-[0.98] cursor-pointer"
                                >
                                    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <rect width="20" height="16" x="2" y="4" rx="2"/>
                                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                                    </svg>
                                    <span>Buka Undangan</span>
                                </button>
                            </div>
                            <p class="text-[9.5px] italic text-white/70 pt-1 max-w-xs mx-auto leading-relaxed">
                                Mohon maaf apabila ada kesalahan penulisan nama/gelar
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
