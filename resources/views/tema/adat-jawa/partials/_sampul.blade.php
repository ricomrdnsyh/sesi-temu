{{-- SEKSI 1: SAMPUL CLEAN ROYAL KERATON (EDITORIAL LOWER-THIRD & PANORAMA TANPA FOTO) --}}
<section
    data-transisi-sampul="fade-halus"
    class="tirai-fade-halus tirai-gulir-atas fixed inset-0 mx-auto h-dvh w-full lg:w-[460px] xl:w-[490px] z-40 {{ $tampilBarDemo ? 'pt-28 sm:pt-20 lg:pt-14' : '' }}"
    style="height: 100dvh;"
    :class="undanganTerbuka ? 'tirai-terbuka pointer-events-none' : ''"
>
    <div class="relative w-full h-full flex flex-col justify-between overflow-hidden bg-[#1D0F08]">
        {{-- Latar Penuh: Foto Prewedding (Pakai Foto) atau Panorama Hutan Jawa (Tanpa Foto) --}}
        <img
            src="{{ $pakaiFotoSampul ? $urlFotoSampul : $asetJawa['latarHutan'] }}"
            alt="{{ $pakaiFotoSampul ? "Foto Sampul {$undangan->nama_panggilan_pria} & {$undangan->nama_panggilan_wanita}" : 'Sampul Adat Jawa Keraton' }}"
            fetchpriority="high"
            decoding="sync"
            class="absolute inset-0 w-full h-full object-cover {{ $pakaiFotoSampul ? 'object-top scale-[1.02] animasi-nafas' : 'object-center scale-105 animasi-nafas' }}"
        >

        {{-- Gradasi Sogan Bersih & Kontras Nyaman --}}
        <div
            aria-hidden="true"
            class="pointer-events-none absolute inset-0"
            style="background: {{ $pakaiFotoSampul
                ? 'linear-gradient(180deg, rgba(18,9,4,0.52) 0%, rgba(18,9,4,0.12) 16%, rgba(18,9,4,0.0) 32%, rgba(18,9,4,0.0) 50%, rgba(22,11,5,0.58) 66%, rgba(18,9,4,0.90) 82%, rgba(14,7,3,0.98) 100%)'
                : 'linear-gradient(180deg, rgba(28,15,8,0.74) 0%, rgba(34,19,10,0.56) 36%, rgba(30,16,9,0.58) 66%, rgba(18,9,4,0.76) 100%)' }};"
        ></div>

        {{-- Bingkai Tunggal Garis Tipis Emas (Clean Stationery Frame, Tanpa Kotak Berlapis) --}}
        <div
            aria-hidden="true"
            class="pointer-events-none absolute inset-3.5 rounded-[1.35rem] border {{ $pakaiFotoSampul ? 'border-[#E5C98B]/20' : 'border-[#F3E5AB]/24' }} z-10"
        ></div>

        @if (!$pakaiFotoSampul)
            {{-- Lapisan Panorama Tanpa Foto: Janur Kuning + Pendopo Joglo + Bunga Keraton Utuh di Bawah --}}
            <img
                src="{{ $asetJawa['janur'] }}"
                alt=""
                aria-hidden="true"
                class="pointer-events-none absolute bottom-[14%] -left-10 w-32 sm:w-36 opacity-75 drop-shadow-[0_10px_18px_rgba(20,10,5,0.4)] z-[7]"
            >
            <img
                src="{{ $asetJawa['janur'] }}"
                alt=""
                aria-hidden="true"
                class="pointer-events-none absolute bottom-[14%] -right-10 w-32 sm:w-36 opacity-75 -scale-x-100 drop-shadow-[0_10px_18px_rgba(20,10,5,0.4)] z-[7]"
            >
            <img
                src="{{ $asetJawa['pendopo'] }}"
                alt=""
                aria-hidden="true"
                class="pointer-events-none absolute bottom-[5%] left-1/2 -translate-x-1/2 w-[78%] max-w-[325px] opacity-86 drop-shadow-[0_14px_26px_rgba(20,10,5,0.5)] z-[8]"
            >
            <img
                src="{{ $asetJawa['bungaDepan'] }}"
                alt=""
                aria-hidden="true"
                class="pointer-events-none absolute -bottom-1 inset-x-0 w-full opacity-88 z-[9]"
            >
            {{-- Pendar Sogan Lembut di Area Tengah Agar Teks Terpusat Sangat Jelas & Bersih --}}
            <div
                aria-hidden="true"
                class="pointer-events-none absolute inset-0 z-[10]"
                style="background: radial-gradient(ellipse 78% 50% at 50% 42%, rgba(24,12,6,0.42) 0%, transparent 100%);"
            ></div>
        @endif

        {{-- Aksen Motion Keraton Sangat Halus di Tepi (Menjaga Visual Tetap Bersih) --}}
        <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden z-[12] opacity-55">
            @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'wayang-flora', 'konteks' => 'sampul'])

            @foreach ([
                ['bottom: 22%; left: 10%;', 'w-1 h-1', '0.4s'],
                ['bottom: 34%; right: 11%;', 'w-1.5 h-1.5', '1.6s'],
                ['bottom: 54%; left: 12%;', 'w-1 h-1', '2.5s'],
                ['bottom: 48%; right: 13%;', 'w-1 h-1', '0.9s'],
            ] as [$posisi, $ukuran, $jeda])
                <span
                    class="absolute rounded-full {{ $ukuran }} bg-[#F3E5AB]/85 shadow-[0_0_8px_rgba(215,187,131,0.75)] animasi-debu-emas"
                    style="{{ $posisi }} animation-delay: {{ $jeda }};"
                ></span>
            @endforeach
        </div>

        @if ($pakaiFotoSampul)
            {{-- 1. MASTHEAD ATAS MINIMAL (TENANG & MEMBIARKAN WAJAH MEMPELAI LEGA PENUH) --}}
            <header class="relative z-20 shrink-0 px-7 {{ $tampilBarDemo ? 'pt-5 sm:pt-6' : 'pt-6 sm:pt-7' }} text-center jawa-masuk-1">
                <img
                    src="{{ $asetJawa['gununganKecil'] }}"
                    alt=""
                    aria-hidden="true"
                    class="w-8 sm:w-9 mx-auto opacity-92 drop-shadow-[0_4px_12px_rgba(0,0,0,0.7)] animasi-ayun-3d"
                >
                <p class="mt-1.5 text-[8.5px] font-semibold uppercase tracking-[0.38em] text-[#F3E5AB]/85 drop-shadow">
                    Pawiwahan Ageng
                </p>
            </header>

            {{-- Ruang Lega Penuh Untuk Potret Mempelai --}}
            <div class="flex-1 min-h-0"></div>

            {{-- 2. KOMPOSISI EDITORIAL BAWAH: MELAYANG RAPI TANPA KOTAK BERLAPIS --}}
            <div class="relative z-20 shrink-0 px-7 pb-7 sm:pb-8 text-center text-[#FFFBF4]">
                <div class="jawa-masuk-2 space-y-1">
                    <p class="font-serif italic font-medium text-[1.2rem] sm:text-[1.35rem] tracking-[0.06em] leading-none text-[#EED597] drop-shadow-[0_2px_10px_rgba(0,0,0,0.75)]">
                        {{ $undangan->teksKustom('sampul_judul', 'The Wedding of') }}
                    </p>
                    <h1 class="font-serif text-[2.45rem] sm:text-[2.75rem] font-semibold tracking-[0.03em] leading-[1.06] text-[#FFFBF4] drop-shadow-[0_4px_18px_rgba(0,0,0,0.8)]">
                        {{ $undangan->nama_panggilan_pria }}
                        <span class="font-kaligrafi font-normal text-[#EED597] mx-1">&amp;</span>
                        {{ $undangan->nama_panggilan_wanita }}
                    </h1>
                    <p class="pt-0.5 text-[9.5px] sm:text-[10px] font-medium uppercase tracking-[0.28em] text-[#F3E5AB]/86 drop-shadow">
                        {{ $tanggalLengkap }}
                    </p>
                </div>

                {{-- Garis Pemisah Tipis Minimalis --}}
                <div aria-hidden="true" class="mx-auto my-3.5 h-px w-14 bg-gradient-to-r from-transparent via-[#E5C98B]/60 to-transparent"></div>

                {{-- Blok Tamu & Tombol Pil Emas Satin --}}
                <div class="jawa-masuk-3 space-y-2.5">
                    <div class="space-y-0.5">
                        <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
                        <p class="text-[9px] font-medium uppercase tracking-[0.24em] text-[#E5C98B]/82">
                            {{ $undangan->teksKustom('sampul_sapaan', 'Kepada Yth. Bapak/Ibu/Saudara/i') }}
                        </p>
                        <p class="font-serif text-[1.28rem] sm:text-[1.38rem] font-semibold text-[#FFFBF2] leading-snug drop-shadow">
                            {{ $namaTamu }}
                        </p>
                    </div>

                    <div class="pt-0.5">
                        <button
                            type="button"
                            @click="bukaUndangan()"
                            class="jawa-tombol-kilau relative overflow-hidden inline-flex items-center justify-center gap-2 rounded-full bg-gradient-to-r from-[#C8A152] via-[#E8CA83] to-[#C8A152] border border-[#FFF4CE]/55 px-8 py-2.5 text-[11px] sm:text-xs font-semibold uppercase tracking-[0.2em] text-[#221107] shadow-[0_12px_28px_-6px_rgba(215,187,131,0.45)] hover:brightness-105 active:scale-[0.98] transition cursor-pointer"
                        >
                            <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="20" height="16" x="2" y="4" rx="2"/>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                            </svg>
                            <span>{{ $undangan->teksKustom('sampul_tombol', 'Buka Undangan') }}</span>
                        </button>
                    </div>

                    <p class="text-[9.5px] italic text-white/62 tracking-wide max-w-[240px] mx-auto leading-snug">
                        {{ $undangan->teksKustom('sampul_catatan', 'Mohon maaf apabila ada kesalahan penulisan nama/gelar') }}
                    </p>
                </div>
            </div>
        @else
            {{-- MODE TANPA FOTO: KOMPOSISI EDITORIAL TERPUSAT DI TENGAH SEPERTI SUNDA (JOGLO & BUNGA UTUH DI BAWAH) --}}
            <div class="relative z-20 flex-1 flex flex-col items-center justify-center px-8 pt-10 pb-28 text-center text-[#FFFBF4]">
                <div class="w-full max-w-[300px] space-y-5">
                    <div class="jawa-masuk-1 space-y-1.5">
                        <img
                            src="{{ $asetJawa['gununganKecil'] }}"
                            alt=""
                            aria-hidden="true"
                            class="w-9 sm:w-10 mx-auto opacity-95 drop-shadow-[0_4px_12px_rgba(18,9,4,0.75)] animasi-ayun-3d"
                        >
                        <p class="pt-1 font-serif italic font-medium text-[1.25rem] sm:text-[1.4rem] tracking-[0.06em] leading-none text-[#F4E0AA] drop-shadow-[0_2px_10px_rgba(18,9,4,0.7)]">
                            {{ $undangan->teksKustom('sampul_judul', 'The Wedding of') }}
                        </p>
                        <h1 class="font-serif text-[2.35rem] sm:text-[2.65rem] font-semibold tracking-[0.04em] leading-[1.06] text-[#FFFBF4] drop-shadow-[0_4px_16px_rgba(18,9,4,0.78)] pt-0.5">
                            <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
                            <span class="block font-kaligrafi font-normal text-2xl text-[#EED597] my-0.5">&amp;</span>
                            <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
                        </h1>
                        <div aria-hidden="true" class="mx-auto my-2 h-px w-12 bg-gradient-to-r from-transparent via-[#F3E5AB]/70 to-transparent"></div>
                        <p class="text-[10px] font-medium uppercase tracking-[0.26em] text-[#FFF4DC]/92 drop-shadow">
                            {{ $tanggalLengkap }}
                        </p>
                    </div>

                    <div class="jawa-masuk-2 space-y-1 pt-1">
                        <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
                        <p class="text-[9.5px] font-medium tracking-[0.14em] text-[#EED597]/90 leading-relaxed drop-shadow">
                            @if ($undangan->teksKustom('sampul_sapaan') !== '')
                                {{ $undangan->teksKustom('sampul_sapaan') }}
                            @else
                                Kepada Yth.<br>
                                Bapak/Ibu/Saudara/i
                            @endif
                        </p>
                        <p class="font-serif text-[1.32rem] sm:text-[1.42rem] font-bold text-[#FFFBF4] leading-snug pt-0.5 drop-shadow-[0_2px_12px_rgba(14,7,3,0.85)]">
                            {{ $namaTamu }}
                        </p>
                    </div>

                    <div class="jawa-masuk-3 space-y-2.5 pt-1">
                        <div>
                            <button
                                type="button"
                                @click="bukaUndangan()"
                                class="jawa-tombol-kilau relative overflow-hidden inline-flex items-center justify-center gap-2 rounded-full bg-[#2A160B]/88 hover:bg-[#3A1F10] backdrop-blur-md border border-[#E5C98B]/80 px-8 py-2.5 text-[11px] sm:text-xs font-semibold uppercase tracking-[0.2em] text-[#FFF7E4] shadow-[0_14px_30px_-8px_rgba(0,0,0,0.75)] active:scale-[0.98] transition cursor-pointer"
                            >
                                <svg class="w-3.5 h-3.5 shrink-0 text-[#EED597]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <rect width="20" height="16" x="2" y="4" rx="2"/>
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                                </svg>
                                <span>{{ $undangan->teksKustom('sampul_tombol', 'Buka Undangan') }}</span>
                            </button>
                        </div>

                        <p class="text-[9.5px] italic text-[#FFF7E2]/78 max-w-[235px] mx-auto leading-relaxed drop-shadow">
                            {{ $undangan->teksKustom('sampul_catatan', 'Mohon maaf apabila ada kesalahan penulisan nama/gelar') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
