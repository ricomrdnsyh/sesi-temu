{{-- SAMPUL PEMBUKA ISLAMIC HEAVENLY: KUBAH CELESTIAL BERLENTERA & POTRET ARCH BESAR --}}
<section
    data-transisi-sampul="fade-halus"
    class="tirai-fade-halus tirai-gulir-atas fixed inset-0 mx-auto h-dvh w-full lg:w-[460px] xl:w-[490px] z-40 {{ $tampilBarDemo ? 'pt-28 sm:pt-20 lg:pt-14' : '' }}"
    style="height: 100dvh;"
    :class="undanganTerbuka ? 'tirai-terbuka pointer-events-none' : ''"
>
    @if ($pakaiFotoSampul)
        {{-- MODE FOTO: KUBAH LANGIT MALAM BERLENTERA + POTRET ARCH BESAR BERBINGKAI EMAS + PLAKAT TAMU --}}
        <div class="relative w-full h-full flex flex-col justify-evenly items-center px-5 py-4 sm:py-5 bg-[#060E1B] overflow-hidden">
            {{-- Latar Langit Malam Bintang & Kubah Halus --}}
            <img
                src="{{ empty($urlFotoLatarCustom) ? $asetCelestial['heroPoster'] : $urlFotoLatar }}"
                alt=""
                aria-hidden="true"
                class="pointer-events-none absolute inset-0 w-full h-full object-cover object-center opacity-[0.26] scale-105 animasi-nafas"
            >
            <div
                aria-hidden="true"
                class="pointer-events-none absolute inset-0"
                style="background: radial-gradient(ellipse 88% 58% at 50% 42%, rgba(24,52,92,0.48) 0%, rgba(9,19,34,0.88) 58%, rgba(4,10,19,0.98) 100%);"
            ></div>

            {{-- Pola Konstelasi Geometri Halus --}}
            <svg aria-hidden="true" class="pointer-events-none absolute inset-0 h-full w-full opacity-[0.09] text-[#F3E5AB]">
                <defs>
                    <pattern id="celestial-tirai-lattice" width="36" height="36" patternUnits="userSpaceOnUse">
                        <path d="M18 0 L36 18 L18 36 L0 18 Z" fill="none" stroke="currentColor" stroke-width="0.65" />
                        <circle cx="18" cy="18" r="1.2" fill="currentColor" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#celestial-tirai-lattice)" />
            </svg>

            {{-- Pendar Cahaya Bulan & Emas Di Belakang Kubah Potret --}}
            <div
                aria-hidden="true"
                class="pointer-events-none absolute top-[26%] left-1/2 -translate-x-1/2 h-84 w-84 rounded-full blur-3xl opacity-30"
                style="background: radial-gradient(circle, #F3E5AB 0%, #D9B664 36%, transparent 72%);"
            ></div>

            {{-- Bingkai Kubah Celestial Ganda Tepi Luar --}}
            <div aria-hidden="true" class="pointer-events-none absolute inset-3 rounded-t-[10.5rem] rounded-b-[1.75rem] border border-[#D9B664]/48 z-10"></div>
            <div aria-hidden="true" class="pointer-events-none absolute inset-[18px] rounded-t-[9.9rem] rounded-b-[1.35rem] border border-dashed border-[#F3E5AB]/24 z-10"></div>

            {{-- Sepasang Lentera Fanous Gantung Kiri & Kanan --}}
            <img
                src="{{ $asetCelestial['lentera'] }}"
                alt=""
                aria-hidden="true"
                class="pointer-events-none absolute -top-2 left-1.5 w-16 sm:w-18 z-10 opacity-92 celestial-lentera-kiri"
            >
            <img
                src="{{ $asetCelestial['lentera'] }}"
                alt=""
                aria-hidden="true"
                class="pointer-events-none absolute -top-2 right-1.5 w-16 sm:w-18 z-10 opacity-92 celestial-lentera-kanan"
            >

            @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'bintang', 'konteks' => 'sampul'])

            {{-- BAGIAN ATAS: BASMALAH, WALIMATUL URSY & NAMA MEMPELAI --}}
            <div class="relative z-20 px-6 text-center space-y-1.5">
                <p class="text-lg sm:text-xl text-[#F3E5AB] drop-shadow" style="font-family: 'Amiri', serif;">
                    بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                </p>
                <div class="inline-flex items-center gap-2 rounded-full border border-[#D9B664]/45 bg-[#0D1E36]/70 px-3.5 py-0.5 backdrop-blur-xs">
                    <span aria-hidden="true" class="text-[9px] text-[#F3E5AB]">&#10022;</span>
                    <p class="text-[9.5px] font-bold uppercase tracking-[0.34em] text-[#D9B664]">
                        Walimatul Ursy
                    </p>
                    <span aria-hidden="true" class="text-[9px] text-[#F3E5AB]">&#10022;</span>
                </div>
                <h1 class="pt-0.5 font-serif text-[2.35rem] sm:text-[2.75rem] font-bold leading-[1.06] text-white drop-shadow-[0_4px_16px_rgba(0,0,0,0.58)]">
                    {{ $undangan->nama_panggilan_pria }}
                    <span class="font-kaligrafi font-normal text-[#E5C474] mx-1">&amp;</span>
                    {{ $undangan->nama_panggilan_wanita }}
                </h1>
                <p class="text-[10px] font-semibold uppercase tracking-[0.28em] text-[#F3E5AB]/92">
                    {{ $tanggalLengkap }}
                </p>
            </div>

            {{-- BAGIAN TENGAH: KUBAH POTRET BESAR RESPONSIF BERBINGKAI GANDA EMAS & MAHKOTA SABIT --}}
            <div class="relative z-20 flex items-center justify-center py-1">
                <div class="relative">
                    <span aria-hidden="true" class="pointer-events-none absolute -inset-2.5 rounded-t-full rounded-b-[1.9rem] border border-dashed border-[#E5C474]/48"></span>
                    <svg aria-hidden="true" class="pointer-events-none absolute top-1/2 -left-5 -translate-y-1/2 h-3.5 w-3.5 text-[#F3E5AB]/90" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M8 0.5L9.9 6.1L15.5 8L9.9 9.9L8 15.5L6.1 9.9L0.5 8L6.1 6.1L8 0.5Z" />
                    </svg>
                    <svg aria-hidden="true" class="pointer-events-none absolute top-1/2 -right-5 -translate-y-1/2 h-3.5 w-3.5 text-[#F3E5AB]/90" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M8 0.5L9.9 6.1L15.5 8L9.9 9.9L8 15.5L6.1 9.9L0.5 8L6.1 6.1L8 0.5Z" />
                    </svg>

                    <div class="relative p-[4px] rounded-t-full rounded-b-[1.5rem] bg-gradient-to-b from-[#FFF1C2] via-[#D9B664] to-[#8C6D32] shadow-[0_24px_54px_-12px_rgba(0,0,0,0.85)]">
                        <img
                            src="{{ $asetCelestial['sabit'] }}"
                            alt=""
                            aria-hidden="true"
                            class="pointer-events-none absolute -top-5 left-1/2 -translate-x-1/2 w-10 sm:w-11 z-20 drop-shadow-[0_6px_14px_rgba(0,0,0,0.75)] animasi-ayun-3d"
                        >
                        <div
                            class="relative overflow-hidden rounded-t-full rounded-b-[1.25rem] bg-[#091322] aspect-[4/4.85]"
                            style="height: clamp(208px, 34.5dvh, 332px);"
                        >
                            <img
                                src="{{ $urlFotoSampul }}"
                                alt="Sampul {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                                fetchpriority="high"
                                decoding="sync"
                                class="w-full h-full object-cover object-top scale-[1.03] animasi-nafas"
                            >
                            <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-t from-[#060E1B]/45 via-transparent to-[#060E1B]/12"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- BAGIAN BAWAH: PLAKAT SAPAAN TAMU KACA SAFIR-EMAS DENGAN SHIMMER --}}
            <div class="relative z-20 w-full max-w-[356px] rounded-[1.75rem] bg-gradient-to-b from-[#132642]/92 to-[#0A1629]/95 backdrop-blur-md border border-[#D9B664]/75 px-5 py-4 text-center text-[#E6EEF8] shadow-[0_22px_50px_-14px_rgba(0,0,0,0.82)] efek-shimmer-kartu">
                <span aria-hidden="true" class="pointer-events-none absolute top-2.5 left-2.5 h-2.5 w-2.5 border-t border-l border-[#E5C474]/80"></span>
                <span aria-hidden="true" class="pointer-events-none absolute top-2.5 right-2.5 h-2.5 w-2.5 border-t border-r border-[#E5C474]/80"></span>
                <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 left-2.5 h-2.5 w-2.5 border-b border-l border-[#E5C474]/80"></span>
                <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 right-2.5 h-2.5 w-2.5 border-b border-r border-[#E5C474]/80"></span>

                <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
                <p class="text-[9.5px] font-bold uppercase tracking-[0.24em] text-[#D9B664]">
                    Kepada Yth. Bapak/Ibu/Saudara/i
                </p>
                <p class="mt-1 font-serif text-xl sm:text-[1.35rem] font-bold text-[#F3E5AB] leading-snug drop-shadow-xs">
                    {{ $namaTamu }}
                </p>

                <div class="pt-3">
                    <button
                        type="button"
                        @click="bukaUndangan()"
                        class="celestial-tombol-emas animasi-segel inline-flex items-center justify-center gap-2 rounded-full px-8 py-2.5 text-xs sm:text-[13px] font-bold uppercase tracking-[0.18em] active:scale-95 transition cursor-pointer"
                    >
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect width="20" height="16" x="2" y="4" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                        <span>Buka Undangan</span>
                    </button>
                </div>

                <p class="mt-2.5 text-[9.5px] italic text-[#E6EEF8]/68 leading-relaxed">
                    Mohon maaf apabila ada kesalahan penulisan nama/gelar
                </p>
            </div>
        </div>
    @else
        {{-- MODE TANPA FOTO: KUBAH MIHRAB CELESTIAL TERPUSAT DI ATAS LANGIT BINTANG --}}
        <div class="relative w-full h-full flex flex-col justify-center items-center px-6 py-8 overflow-hidden bg-[#060E1B]">
            <img
                src="{{ $urlFotoLatar }}"
                alt="Sampul {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                fetchpriority="high"
                decoding="sync"
                class="absolute inset-0 w-full h-full object-cover object-center scale-105 animasi-nafas"
            >
            <div class="absolute inset-0 bg-gradient-to-b from-[#071120]/80 via-[#0E1E36]/52 to-[#040A13]/94"></div>
            <img src="{{ $asetCelestial['lentera'] }}" alt="" aria-hidden="true" class="pointer-events-none absolute -top-2 left-2 w-18 opacity-90 celestial-lentera-kiri">
            <img src="{{ $asetCelestial['lentera'] }}" alt="" aria-hidden="true" class="pointer-events-none absolute -top-2 right-2 w-18 opacity-90 celestial-lentera-kanan">

            @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'bintang', 'konteks' => 'sampul'])

            <div class="relative z-20 w-full max-w-[354px]">
                <div class="kartu-3d efek-shimmer-kartu rounded-t-[10.5rem] rounded-b-[2rem] bg-gradient-to-b from-[#132642]/94 to-[#0A1629]/96 backdrop-blur-md border-2 border-[#D9B664]/75 p-2 shadow-[0_28px_70px_-16px_rgba(0,0,0,0.85)]">
                    <div class="rounded-t-[9.7rem] rounded-b-[1.5rem] border border-dashed border-[#D9B664]/40 px-6 pt-9 pb-7 text-center text-[#E6EEF8] space-y-4">
                        <div class="space-y-1.5">
                            <img src="{{ $asetCelestial['sabit'] }}" alt="" class="w-11 mx-auto opacity-95 animasi-ayun-3d">
                            <p class="text-base sm:text-lg text-[#F3E5AB]" style="font-family: 'Amiri', serif;">
                                بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                            </p>
                            <p class="text-[10px] font-semibold uppercase tracking-[0.34em] text-[#D9B664]">
                                Walimatul Ursy &bull; Celestial Night
                            </p>
                            <h1 class="font-serif text-4xl sm:text-[2.65rem] font-bold leading-[1.08] text-white pt-1">
                                <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
                                <span class="block font-kaligrafi font-normal text-3xl text-[#E5C474] my-0.5">&amp;</span>
                                <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
                            </h1>
                            <p class="text-[11px] uppercase tracking-[0.24em] text-[#E6EEF8]/85 pt-1">
                                {{ $tanggalLengkap }}
                            </p>
                        </div>

                        <div class="flex items-center justify-center gap-3 px-6" aria-hidden="true">
                            <span class="h-px flex-1 bg-[#D9B664]/45"></span>
                            <span class="text-[10px] text-[#F3E5AB]">&#10022;</span>
                            <span class="h-px flex-1 bg-[#D9B664]/45"></span>
                        </div>

                        <div class="space-y-2.5 pt-0.5">
                            <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
                            <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-[#D9B664]">
                                Kepada Yth. Bapak/Ibu/Saudara/i
                            </p>
                            <p class="font-serif text-xl sm:text-2xl font-bold text-[#F3E5AB] leading-snug">
                                {{ $namaTamu }}
                            </p>
                            <div class="pt-2">
                                <button
                                    type="button"
                                    @click="bukaUndangan()"
                                    class="celestial-tombol-emas animasi-segel inline-flex items-center justify-center gap-2 rounded-full px-8 py-3 text-xs sm:text-sm font-bold uppercase tracking-[0.18em] active:scale-95 transition cursor-pointer"
                                >
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <rect width="20" height="16" x="2" y="4" rx="2"/>
                                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                                    </svg>
                                    <span>Buka Undangan</span>
                                </button>
                            </div>
                            <p class="text-[10px] italic text-[#E6EEF8]/70 pt-1 max-w-xs mx-auto leading-relaxed">
                                Mohon maaf apabila ada kesalahan penulisan nama/gelar
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>
