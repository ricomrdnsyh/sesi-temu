{{-- SAMPUL PEMBUKA ISLAMIC HEAVENLY: EDITORIAL FULL-BLEED CELESTIAL NIGHT & MIHRAB TANPA FOTO --}}
<section
    data-transisi-sampul="fade-halus"
    class="tirai-fade-halus tirai-gulir-atas fixed inset-0 mx-auto h-dvh w-full lg:w-[460px] xl:w-[490px] z-40 {{ $tampilBarDemo ? 'pt-28 sm:pt-20 lg:pt-14' : '' }}"
    style="height: 100dvh;"
    :class="undanganTerbuka ? 'tirai-terbuka pointer-events-none' : ''"
>
    @if ($pakaiFotoSampul)
        {{-- MODE FOTO: EDITORIAL FULL-BLEED BERSIH (FOTO MEMPELAI LEGA TANPA ORNAMEN MENGHALANGI + LOWER-THIRD MELAYANG) --}}
        <div class="relative w-full h-full flex flex-col justify-between overflow-hidden bg-[#060E1B]">
            {{-- Foto Prewedding Penuh Layar --}}
            <img
                src="{{ $urlFotoSampul }}"
                alt="Sampul {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                fetchpriority="high"
                decoding="sync"
                class="absolute inset-0 w-full h-full object-cover object-top scale-[1.02] animasi-nafas"
            >

            {{-- Gradasi Editorial Safir Malam (Jernih Penuh di Tengah/Wajah Mempelai, Kontras Rapi di Atas & Bawah) --}}
            <div
                aria-hidden="true"
                class="pointer-events-none absolute inset-0"
                style="background: linear-gradient(180deg, rgba(6,14,27,0.84) 0%, rgba(6,14,27,0.50) 16%, rgba(6,14,27,0.08) 30%, rgba(6,14,27,0.0) 40%, rgba(6,14,27,0.0) 54%, rgba(6,14,27,0.62) 70%, rgba(5,12,24,0.93) 84%, rgba(4,9,18,0.99) 100%);"
            ></div>

            {{-- Bingkai Tunggal Garis Tipis Mihrab Emas (Clean Stationery Frame) --}}
            <div
                aria-hidden="true"
                class="pointer-events-none absolute inset-3.5 rounded-t-[10.5rem] rounded-b-[1.5rem] border border-[#E5C474]/30 z-10"
            ></div>

            {{-- Kilau Bintang Mikro Sangat Halus Di Tepi Luar (Tidak Menghalangi Foto) --}}
            <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden z-[12] opacity-70">
                @foreach ([
                    ['top: 22%; left: 9%;', 'w-1 h-1 bg-[#F3E5AB]', '0.2s'],
                    ['top: 30%; right: 9%;', 'w-1.5 h-1.5 bg-[#E5C474]', '1.4s'],
                    ['bottom: 32%; left: 10%;', 'w-1 h-1 bg-white/90', '2.1s'],
                    ['bottom: 26%; right: 10%;', 'w-1 h-1 bg-[#F3E5AB]', '0.9s'],
                ] as [$posisi, $ukuran, $jeda])
                    <span
                        class="absolute rounded-full {{ $ukuran }} animasi-bintang shadow-[0_0_8px_rgba(243,229,171,0.75)]"
                        style="{{ $posisi }} animation-delay: {{ $jeda }};"
                    ></span>
                @endforeach
            </div>

            {{-- 1. MASTHEAD ATAS BERSIH: IKON SABIT MINIMALIS, BASMALAH, NAMA MEMPELAI & TANGGAL --}}
            <header class="relative z-20 shrink-0 px-7 {{ $tampilBarDemo ? 'pt-5 sm:pt-6' : 'pt-7 sm:pt-8' }} text-center">
                <svg
                    aria-hidden="true"
                    viewBox="0 0 24 24"
                    class="w-5 h-5 mx-auto text-[#E5C474]/92 drop-shadow-[0_2px_8px_rgba(0,0,0,0.6)]"
                    fill="currentColor"
                >
                    <path d="M14.7 3.2a8.4 8.4 0 1 0 6.1 14.1 7.1 7.1 0 0 1-9.3-9.3 8.3 8.3 0 0 1 3.2-4.8Z" />
                    <path d="M18.4 5.2l.55 1.45 1.45.55-1.45.55-.55 1.45-.55-1.45-1.45-.55 1.45-.55.55-1.45Z" />
                </svg>
                <p class="mt-1.5 text-[1.05rem] sm:text-lg text-[#F3E5AB]/95 drop-shadow-[0_2px_10px_rgba(0,0,0,0.65)]" style="font-family: 'Amiri', serif;">
                    بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                </p>
                <p class="mt-0.5 text-[9px] font-semibold uppercase tracking-[0.38em] text-[#D9B664]/92 drop-shadow">
                    Walimatul Ursy
                </p>
                <h1 class="mt-1 font-serif text-[2.35rem] sm:text-[2.65rem] font-semibold tracking-[0.02em] leading-[1.06] text-white drop-shadow-[0_4px_18px_rgba(0,0,0,0.75)]">
                    {{ $undangan->nama_panggilan_pria }}
                    <span class="font-kaligrafi font-normal text-[#E5C474] mx-1">&amp;</span>
                    {{ $undangan->nama_panggilan_wanita }}
                </h1>
                <p class="mt-1.5 text-[9.5px] sm:text-[10px] font-medium uppercase tracking-[0.28em] text-[#F3E5AB]/86 drop-shadow">
                    {{ $tanggalLengkap }}
                </p>
            </header>

            {{-- Ruang Lega Penuh Untuk Potret Mempelai --}}
            <div class="flex-1 min-h-0"></div>

            {{-- 2. KOMPOSISI EDITORIAL BAWAH: SAPAAN TAMU & TOMBOL MELAYANG BERSIH TANPA KOTAK --}}
            <div class="relative z-20 shrink-0 px-7 pb-7 sm:pb-8 text-center text-[#E6EEF8]">
                {{-- Garis Pemisah Tipis Celestial --}}
                <div aria-hidden="true" class="mx-auto mb-3.5 flex items-center justify-center gap-2.5 w-28">
                    <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#E5C474]/60"></span>
                    <svg class="h-2.5 w-2.5 text-[#F3E5AB]/85 shrink-0" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M8 0.5L9.7 6.3L15.5 8L9.7 9.7L8 15.5L6.3 9.7L0.5 8L6.3 6.3L8 0.5Z" />
                    </svg>
                    <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#E5C474]/60"></span>
                </div>

                <div class="space-y-2.5">
                    <div class="space-y-0.5">
                        <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
                        <p class="text-[9px] font-medium uppercase tracking-[0.26em] text-[#E5C474]/82">
                            Kepada Yth. Bapak/Ibu/Saudara/i
                        </p>
                        <p class="font-serif text-[1.32rem] sm:text-[1.45rem] font-semibold text-white leading-snug tracking-[0.01em] drop-shadow-[0_2px_12px_rgba(0,0,0,0.75)]">
                            {{ $namaTamu }}
                        </p>
                    </div>

                    <div class="pt-1">
                        <button
                            type="button"
                            @click="bukaUndangan()"
                            class="inline-flex items-center justify-center gap-2 rounded-full bg-gradient-to-r from-[#CFA756] via-[#EED694] to-[#CFA756] border border-[#FFF6D8]/60 px-8 py-2.5 text-[11px] sm:text-xs font-semibold uppercase tracking-[0.2em] text-[#091322] shadow-[0_14px_30px_-8px_rgba(217,182,100,0.45)] hover:brightness-105 active:scale-[0.98] transition cursor-pointer"
                        >
                            <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="20" height="16" x="2" y="4" rx="2"/>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                            </svg>
                            <span>Buka Undangan</span>
                        </button>
                    </div>

                    <p class="text-[9.5px] italic text-[#E6EEF8]/60 max-w-[240px] mx-auto leading-snug">
                        Mohon maaf apabila ada kesalahan penulisan nama/gelar
                    </p>
                </div>
            </div>
        </div>
    @else
        {{-- MODE TANPA FOTO: TIPOGRAFI EDITORIAL MELAYANG BERSIH DI DALAM GERBANG LANGIT BINTANG & TERATAI --}}
        <div class="relative w-full h-full flex flex-col justify-center items-center px-9 pt-24 pb-24 overflow-hidden bg-[#060E1B]">
            {{-- Karya Latar Penuh: Gerbang Emas, Bulan Sabit, Lentera Tepi & Kolam Teratai Putih --}}
            <img
                src="{{ $urlFotoLatar }}"
                alt="Sampul {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                fetchpriority="high"
                decoding="sync"
                class="absolute inset-0 w-full h-full object-cover object-center scale-[1.02] animasi-nafas"
            >

            {{-- Kabut Safir Lembut Terpusat Agar Teks Tajam Tanpa Menutupi Lengkung Atas, Bulan & Teratai Bawah --}}
            <div
                aria-hidden="true"
                class="pointer-events-none absolute inset-0"
                style="background: radial-gradient(ellipse 68% 54% at 50% 52%, rgba(6,14,27,0.74) 0%, rgba(6,14,27,0.46) 48%, rgba(6,14,27,0.12) 78%, rgba(4,10,19,0.28) 100%);"
            ></div>

            {{-- Kilau Bintang Mikro Halus Di Sisi Tepi --}}
            <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden z-10 opacity-75">
                @foreach ([
                    ['top: 26%; left: 16%;', 'w-1 h-1 bg-[#F3E5AB]', '0.2s'],
                    ['top: 34%; right: 16%;', 'w-1.5 h-1.5 bg-[#E5C474]', '1.3s'],
                    ['bottom: 28%; left: 18%;', 'w-1 h-1 bg-white/90', '2.1s'],
                    ['bottom: 32%; right: 18%;', 'w-1 h-1 bg-[#F3E5AB]', '0.8s'],
                ] as [$posisi, $ukuran, $jeda])
                    <span
                        class="absolute rounded-full {{ $ukuran }} animasi-bintang shadow-[0_0_8px_rgba(243,229,171,0.8)]"
                        style="{{ $posisi }} animation-delay: {{ $jeda }};"
                    ></span>
                @endforeach
            </div>

            {{-- Komposisi Tipografi Editorial Bersih Tanpa Kotak Kartu --}}
            <div class="relative z-20 w-full max-w-[300px] text-center text-[#F4F8FF] space-y-5">
                <div class="space-y-1.5">
                    <p class="text-[1.05rem] sm:text-lg text-[#F3E5AB] drop-shadow-[0_2px_10px_rgba(0,0,0,0.75)]" style="font-family: 'Amiri', serif;">
                        بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                    </p>
                    <p class="text-[9px] font-semibold uppercase tracking-[0.38em] text-[#E5C474]/95 drop-shadow">
                        Walimatul Ursy
                    </p>

                    <h1 class="pt-1 font-serif text-[2.45rem] sm:text-[2.75rem] font-semibold tracking-[0.03em] leading-[1.04] text-white drop-shadow-[0_4px_18px_rgba(4,10,19,0.85)]">
                        <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
                        <span class="my-1 flex items-center justify-center gap-3">
                            <span aria-hidden="true" class="h-px w-7 bg-gradient-to-r from-transparent to-[#E5C474]/75"></span>
                            <span class="font-kaligrafi font-normal text-2xl sm:text-3xl text-[#E5C474] leading-none">&amp;</span>
                            <span aria-hidden="true" class="h-px w-7 bg-gradient-to-l from-transparent to-[#E5C474]/75"></span>
                        </span>
                        <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
                    </h1>

                    <p class="pt-1.5 text-[9.5px] sm:text-[10px] font-medium uppercase tracking-[0.28em] text-[#F3E5AB]/90 drop-shadow">
                        {{ $tanggalLengkap }}
                    </p>
                </div>

                {{-- Garis Bintang Tipis Pemisah --}}
                <div aria-hidden="true" class="mx-auto flex items-center justify-center gap-2.5 w-24">
                    <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#E5C474]/60"></span>
                    <svg class="h-2.5 w-2.5 text-[#F3E5AB]/90 shrink-0" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M8 0.5L9.7 6.3L15.5 8L9.7 9.7L8 15.5L6.3 9.7L0.5 8L6.3 6.3L8 0.5Z" />
                    </svg>
                    <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#E5C474]/60"></span>
                </div>

                {{-- Sapaan Tamu & Tombol Melayang Bersih --}}
                <div class="space-y-2.5">
                    <div class="space-y-0.5">
                        <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
                        <p class="text-[9px] font-medium uppercase tracking-[0.24em] text-[#E5C474]/85">
                            Kepada Yth. Bapak/Ibu/Saudara/i
                        </p>
                        <p class="font-serif text-[1.32rem] sm:text-[1.45rem] font-semibold text-white leading-snug drop-shadow-[0_2px_12px_rgba(0,0,0,0.85)]">
                            {{ $namaTamu }}
                        </p>
                    </div>

                    <div class="pt-1">
                        <button
                            type="button"
                            @click="bukaUndangan()"
                            class="inline-flex items-center justify-center gap-2 rounded-full bg-gradient-to-r from-[#CFA756] via-[#EED694] to-[#CFA756] border border-[#FFF6D8]/60 px-8 py-2.5 text-[11px] sm:text-xs font-semibold uppercase tracking-[0.2em] text-[#091322] shadow-[0_14px_30px_-8px_rgba(0,0,0,0.68)] hover:brightness-105 active:scale-[0.98] transition cursor-pointer"
                        >
                            <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="20" height="16" x="2" y="4" rx="2"/>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                            </svg>
                            <span>Buka Undangan</span>
                        </button>
                    </div>

                    <p class="text-[9.5px] italic text-[#E6EEF8]/65 max-w-[230px] mx-auto leading-snug drop-shadow">
                        Mohon maaf apabila ada kesalahan penulisan nama/gelar
                    </p>
                </div>
            </div>
        </div>
    @endif
</section>
