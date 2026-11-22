{{-- SAMPUL PEMBUKA ISLAMI SYAR'I: KUBAH ANDALUSIA BERLENTERA & TRANSISI GULIR KE ATAS --}}
<section
    data-transisi-sampul="fade-halus"
    class="tirai-fade-halus tirai-gulir-atas fixed inset-0 mx-auto h-dvh w-full lg:w-[460px] xl:w-[490px] z-40 {{ $tampilBarDemo ? 'pt-28 sm:pt-20 lg:pt-14' : '' }}"
    style="height: 100dvh;"
    :class="undanganTerbuka ? 'tirai-terbuka pointer-events-none' : ''"
>
    @if ($pakaiFotoSampul)
        {{-- MODE FOTO: KUBAH MOORISH BERLENTERA + POTRET BESAR BERBINGKAI EMAS + PLAKAT TAMU --}}
        <div class="relative w-full h-full flex flex-col justify-evenly items-center px-5 py-4 sm:py-5 bg-[#0A2C28] overflow-hidden">
            {{-- Latar Lukisan Courtyard Andalusia Halus Di Balik Kabut Zamrud --}}
            <img
                src="{{ $urlFotoLatar }}"
                alt=""
                aria-hidden="true"
                class="pointer-events-none absolute inset-0 w-full h-full object-cover object-center opacity-[0.22] scale-105 animasi-nafas"
            >
            <div
                aria-hidden="true"
                class="pointer-events-none absolute inset-0"
                style="background: radial-gradient(ellipse 88% 58% at 50% 42%, rgba(20,76,69,0.52) 0%, rgba(11,45,41,0.86) 56%, rgba(7,29,26,0.96) 100%);"
            ></div>

            {{-- Pola Geometri Islami Halus --}}
            <svg aria-hidden="true" class="pointer-events-none absolute inset-0 h-full w-full opacity-[0.09] text-[#E6D19C]">
                <defs>
                    <pattern id="syari-tirai-lattice" width="32" height="32" patternUnits="userSpaceOnUse">
                        <path d="M16 0 L32 16 L16 32 L0 16 Z" fill="none" stroke="currentColor" stroke-width="0.7" />
                        <circle cx="16" cy="16" r="1.2" fill="currentColor" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#syari-tirai-lattice)" />
            </svg>

            {{-- Sorotan Cahaya Emas Di Belakang Kubah Potret --}}
            <div
                aria-hidden="true"
                class="pointer-events-none absolute top-[26%] left-1/2 -translate-x-1/2 h-80 w-80 rounded-full blur-3xl opacity-28"
                style="background: radial-gradient(circle, #F3E5AB 0%, #C5A059 38%, transparent 72%);"
            ></div>

            {{-- Bingkai Kubah Moorish Ganda Tepi Luar --}}
            <div aria-hidden="true" class="pointer-events-none absolute inset-3 rounded-t-[10.5rem] rounded-b-[1.75rem] border border-[#E6D19C]/45 z-10"></div>
            <div aria-hidden="true" class="pointer-events-none absolute inset-[18px] rounded-t-[9.9rem] rounded-b-[1.35rem] border border-dashed border-[#E6D19C]/22 z-10"></div>

            {{-- Ornamen Lentera Fanous Emas Menggantung Simetris Kiri & Kanan Atas --}}
            <svg aria-hidden="true" viewBox="0 0 60 130" class="pointer-events-none absolute top-0 left-6 sm:left-8 w-10 sm:w-11 text-[#E6D19C]/75 z-10 animasi-ayun-3d" fill="none" stroke="currentColor" stroke-width="1.25">
                <line x1="30" y1="0" x2="30" y2="54" stroke-opacity="0.7" />
                <circle cx="30" cy="57" r="3" fill="currentColor" />
                <path d="M22 65 Q30 57 38 65 L41 84 Q30 96 19 84 Z" fill="currentColor" fill-opacity="0.16" />
                <path d="M26 67 L26 84 M34 67 L34 84" stroke-opacity="0.55" />
                <circle cx="30" cy="76" r="2.2" fill="#FFF5D6" stroke="none" />
                <path d="M30 93 L30 105" stroke-opacity="0.7" />
                <path d="M30 105 L33 111 L30 117 L27 111 Z" fill="currentColor" stroke="none" />
            </svg>
            <svg aria-hidden="true" viewBox="0 0 60 130" class="pointer-events-none absolute top-0 right-6 sm:right-8 w-10 sm:w-11 text-[#E6D19C]/75 z-10 animasi-ayun-3d-balik" fill="none" stroke="currentColor" stroke-width="1.25">
                <line x1="30" y1="0" x2="30" y2="44" stroke-opacity="0.7" />
                <circle cx="30" cy="47" r="3" fill="currentColor" />
                <path d="M22 55 Q30 47 38 55 L41 74 Q30 86 19 74 Z" fill="currentColor" fill-opacity="0.16" />
                <path d="M26 57 L26 74 M34 57 L34 74" stroke-opacity="0.55" />
                <circle cx="30" cy="66" r="2.2" fill="#FFF5D6" stroke="none" />
                <path d="M30 83 L30 95" stroke-opacity="0.7" />
                <path d="M30 95 L33 101 L30 107 L27 101 Z" fill="currentColor" stroke="none" />
            </svg>

            @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'zaitun-kilau', 'konteks' => 'sampul'])

            {{-- BAGIAN ATAS: KALIGRAFI, WALIMATUL URSY & NAMA MEMPELAI --}}
            <div class="relative z-20 px-6 text-center space-y-1.5">
                <p class="text-lg sm:text-xl text-[#F3E5AB] drop-shadow" style="font-family: 'Amiri', serif;">
                    بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                </p>
                <div class="inline-flex items-center gap-2 rounded-full border border-[#E6D19C]/35 bg-[#08221F]/55 px-3.5 py-0.5">
                    <span aria-hidden="true" class="h-1 w-1 rotate-45 bg-[#E6D19C]"></span>
                    <p class="text-[9.5px] font-bold uppercase tracking-[0.34em] text-[#E6D19C]">
                        Walimatul Ursy
                    </p>
                    <span aria-hidden="true" class="h-1 w-1 rotate-45 bg-[#E6D19C]"></span>
                </div>
                <h1 class="pt-0.5 font-serif text-[2.35rem] sm:text-[2.75rem] font-bold leading-[1.06] text-white drop-shadow-[0_4px_16px_rgba(0,0,0,0.45)]">
                    {{ $undangan->nama_panggilan_pria }}
                    <span class="font-kaligrafi font-normal text-[#E6D19C] mx-1">&amp;</span>
                    {{ $undangan->nama_panggilan_wanita }}
                </h1>
                <p class="text-[10px] font-semibold uppercase tracking-[0.28em] text-[#F3E5AB]/90">
                    {{ $tanggalLengkap }}
                </p>
            </div>

            {{-- BAGIAN TENGAH: KUBAH POTRET BESAR RESPONSIF BERBINGKAI GANDA EMAS --}}
            <div class="relative z-20 flex items-center justify-center py-1">
                <div class="relative">
                    {{-- Halo Lengkung Putus-Putus Emas Di Luar Bingkai --}}
                    <span aria-hidden="true" class="pointer-events-none absolute -inset-2.5 rounded-t-full rounded-b-[1.9rem] border border-dashed border-[#E6D19C]/45"></span>
                    {{-- Bintang Filigree Samping Kiri & Kanan --}}
                    <svg aria-hidden="true" class="pointer-events-none absolute top-1/2 -left-5 -translate-y-1/2 h-3.5 w-3.5 text-[#E6D19C]/85" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M8 0.5L9.9 6.1L15.5 8L9.9 9.9L8 15.5L6.1 9.9L0.5 8L6.1 6.1L8 0.5Z" />
                    </svg>
                    <svg aria-hidden="true" class="pointer-events-none absolute top-1/2 -right-5 -translate-y-1/2 h-3.5 w-3.5 text-[#E6D19C]/85" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M8 0.5L9.9 6.1L15.5 8L9.9 9.9L8 15.5L6.1 9.9L0.5 8L6.1 6.1L8 0.5Z" />
                    </svg>

                    {{-- Bingkai Emas Solid + Mahkota Arabesque --}}
                    <div class="relative p-[4px] rounded-t-full rounded-b-[1.5rem] bg-gradient-to-b from-[#F5E7B2] via-[#C5A059] to-[#8C6D32] shadow-[0_24px_48px_-14px_rgba(0,0,0,0.72)]">
                        <img
                            src="{{ $asetSyari['arabesque'] }}"
                            alt=""
                            aria-hidden="true"
                            class="pointer-events-none absolute -top-5 left-1/2 -translate-x-1/2 w-10 sm:w-11 z-20 drop-shadow-md animasi-ayun-3d"
                        >
                        <div
                            class="relative overflow-hidden rounded-t-full rounded-b-[1.25rem] bg-[#08221F] aspect-[4/4.85]"
                            style="height: clamp(205px, 34dvh, 330px);"
                        >
                            <img
                                src="{{ $urlFotoSampul }}"
                                alt="Sampul {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                                class="w-full h-full object-cover object-top scale-[1.03] animasi-nafas"
                            >
                            <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-t from-[#08221F]/45 via-transparent to-[#08221F]/12"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- BAGIAN BAWAH: PLAKAT SAPAAN TAMU ALABASTER-EMAS --}}
            <div class="relative z-20 w-full max-w-[356px] rounded-[1.75rem] bg-[#F8FCF9]/96 backdrop-blur-md border border-[#C5A059]/80 px-5 py-4 text-center text-[#0E3A36] shadow-[0_22px_48px_-14px_rgba(0,0,0,0.62)]">
                {{-- Siku Filigree 4 Sudut --}}
                <span aria-hidden="true" class="pointer-events-none absolute top-2.5 left-2.5 h-2.5 w-2.5 border-t border-l border-[#C5A059]/75"></span>
                <span aria-hidden="true" class="pointer-events-none absolute top-2.5 right-2.5 h-2.5 w-2.5 border-t border-r border-[#C5A059]/75"></span>
                <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 left-2.5 h-2.5 w-2.5 border-b border-l border-[#C5A059]/75"></span>
                <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 right-2.5 h-2.5 w-2.5 border-b border-r border-[#C5A059]/75"></span>

                <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
                <p class="text-[9.5px] font-bold uppercase tracking-[0.24em] text-[#9E7D40]">
                    Kepada Yth. Bapak/Ibu/Saudara/i
                </p>
                <p class="mt-1 font-serif text-xl sm:text-[1.35rem] font-bold text-[#0E3A36] leading-snug">
                    {{ $namaTamu }}
                </p>

                <div class="pt-3">
                    <button
                        type="button"
                        @click="bukaUndangan()"
                        class="syari-tombol inline-flex items-center justify-center gap-2 rounded-full border border-[#C5A059]/80 px-8 py-2.5 text-xs sm:text-[13px] font-bold uppercase tracking-[0.18em] active:scale-95 transition cursor-pointer"
                    >
                        <svg class="w-4 h-4 text-[#F3E5AB]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect width="20" height="16" x="2" y="4" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                        <span>Buka Undangan</span>
                    </button>
                </div>

                <p class="mt-2.5 text-[9.5px] italic text-[#0E3A36]/65 leading-relaxed">
                    Mohon maaf apabila ada kesalahan penulisan nama/gelar
                </p>
            </div>
        </div>
    @else
        {{-- MODE TANPA FOTO: PLAKAT MIHRAB ALABASTER BERLENTERA DI ATAS LUKISAN COURTYARD --}}
        <div class="relative w-full h-full flex flex-col justify-center items-center px-6 py-8 bg-[#EEF6F1] overflow-hidden">
            <img
                src="{{ $urlFotoLatar }}"
                alt="Sampul {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                class="absolute inset-0 w-full h-full object-cover object-center scale-105 animasi-nafas"
            >
            <div
                aria-hidden="true"
                class="pointer-events-none absolute inset-0"
                style="background: radial-gradient(ellipse 86% 68% at 50% 50%, rgba(247,251,248,0.88) 0%, rgba(238,246,241,0.56) 60%, rgba(14,58,54,0.28) 100%);"
            ></div>

            {{-- Ornamen Lentera Fanous Emas Lembut Di Sisi Atas --}}
            <svg aria-hidden="true" viewBox="0 0 60 120" class="pointer-events-none absolute top-0 left-5 w-9 text-[#9E7D40]/65 z-10 animasi-ayun-3d" fill="none" stroke="currentColor" stroke-width="1.25">
                <line x1="30" y1="0" x2="30" y2="48" />
                <circle cx="30" cy="51" r="2.8" fill="currentColor" />
                <path d="M23 58 Q30 51 37 58 L39 76 Q30 86 21 76 Z" fill="currentColor" fill-opacity="0.14" />
                <path d="M30 84 L30 96" />
                <path d="M30 96 L32.5 101 L30 106 L27.5 101 Z" fill="currentColor" stroke="none" />
            </svg>
            <svg aria-hidden="true" viewBox="0 0 60 120" class="pointer-events-none absolute top-0 right-5 w-9 text-[#9E7D40]/65 z-10 animasi-ayun-3d-balik" fill="none" stroke="currentColor" stroke-width="1.25">
                <line x1="30" y1="0" x2="30" y2="40" />
                <circle cx="30" cy="43" r="2.8" fill="currentColor" />
                <path d="M23 50 Q30 43 37 50 L39 68 Q30 78 21 68 Z" fill="currentColor" fill-opacity="0.14" />
                <path d="M30 76 L30 88" />
                <path d="M30 88 L32.5 93 L30 98 L27.5 93 Z" fill="currentColor" stroke="none" />
            </svg>

            @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'zaitun-kilau', 'konteks' => 'sampul'])

            {{-- Plakat Lengkung Mihrab Berbingkai Emas --}}
            <div class="relative z-20 w-full max-w-[342px] rounded-t-[9rem] rounded-b-[2rem] bg-[#F8FCF9]/94 backdrop-blur-sm border-2 border-[#C5A059]/80 ring-4 ring-[#0E3A36]/10 px-6 pt-9 pb-6 text-center text-[#0E3A36] shadow-[0_26px_60px_-18px_rgba(14,58,54,0.34)]">
                <div aria-hidden="true" class="pointer-events-none absolute inset-2.5 rounded-t-[8rem] rounded-b-[1.45rem] border border-dashed border-[#C5A059]/50"></div>

                <div class="relative z-10 space-y-4">
                    <div class="space-y-1">
                        <img src="{{ $asetSyari['arabesque'] }}" alt="" class="w-12 mx-auto opacity-95 animasi-ayun-3d">
                        <p class="text-lg text-[#0E3A36] pt-0.5" style="font-family: 'Amiri', serif;">
                            بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                        </p>
                        <p class="text-[9.5px] font-bold uppercase tracking-[0.36em] text-[#9E7D40]">
                            Walimatul Ursy
                        </p>
                    </div>

                    <div class="space-y-1.5">
                        <h1 class="font-serif text-[2.55rem] sm:text-[2.85rem] font-bold leading-[1.05] text-[#0E3A36]">
                            <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
                            <span class="my-0.5 flex items-center justify-center gap-3">
                                <span aria-hidden="true" class="h-px w-8 bg-[#C5A059]/75"></span>
                                <span class="font-kaligrafi font-normal text-3xl text-[#B99348]">&amp;</span>
                                <span aria-hidden="true" class="h-px w-8 bg-[#C5A059]/75"></span>
                            </span>
                            <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
                        </h1>
                        <div class="pt-1">
                            <span class="inline-flex items-center gap-2 rounded-full bg-[#0E3A36] border border-[#C5A059]/65 px-4 py-1 text-[10px] font-semibold uppercase tracking-[0.22em] text-[#F3E5AB]">
                                {{ $tanggalLengkap }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center justify-center gap-2.5 px-6" aria-hidden="true">
                        <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#C5A059]/75"></span>
                        <svg class="h-2.5 w-2.5 text-[#0E3A36]" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M8 0.5L9.9 6.1L15.5 8L9.9 9.9L8 15.5L6.1 9.9L0.5 8L6.1 6.1L8 0.5Z" />
                        </svg>
                        <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#C5A059]/75"></span>
                    </div>

                    <div class="space-y-1.5">
                        <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
                        <p class="text-[9.5px] font-bold uppercase tracking-[0.22em] text-[#9E7D40]">
                            Kepada Yth. Bapak/Ibu/Saudara/i
                        </p>
                        <p class="font-serif text-xl font-bold text-[#0E3A36] leading-snug">
                            {{ $namaTamu }}
                        </p>
                        <div class="pt-2">
                            <button
                                type="button"
                                @click="bukaUndangan()"
                                class="syari-tombol inline-flex items-center justify-center gap-2 rounded-full border border-[#C5A059]/80 px-8 py-2.5 text-xs font-bold uppercase tracking-[0.18em] active:scale-95 transition cursor-pointer"
                            >
                                <svg class="w-4 h-4 text-[#F3E5AB]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <rect width="20" height="16" x="2" y="4" rx="2"/>
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                                </svg>
                                <span>Buka Undangan</span>
                            </button>
                        </div>
                        <p class="text-[9.5px] italic text-[#0E3A36]/65 pt-1 leading-relaxed">
                            Mohon maaf apabila ada kesalahan penulisan nama/gelar
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>
