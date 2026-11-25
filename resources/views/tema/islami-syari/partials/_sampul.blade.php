{{-- SAMPUL PEMBUKA ISLAMI SYAR'I: EDITORIAL FULL-BLEED ANDALUSIA & PLAKAT MIHRAB TANPA FOTO --}}
<section
    data-transisi-sampul="fade-halus"
    class="tirai-fade-halus tirai-gulir-atas fixed inset-0 mx-auto h-dvh w-full lg:w-[460px] xl:w-[490px] z-40 {{ $tampilBarDemo ? 'pt-28 sm:pt-20 lg:pt-14' : '' }}"
    style="height: 100dvh;"
    :class="undanganTerbuka ? 'tirai-terbuka pointer-events-none' : ''"
>
    @if ($pakaiFotoSampul)
        {{-- MODE FOTO: EDITORIAL FULL-BLEED BERSIH (POTRET LEGA TANPA KOTAK/ORNAMEN MENGHALANGI + LOWER-THIRD MELAYANG) --}}
        <div class="relative w-full h-full flex flex-col justify-between overflow-hidden bg-[#08221F]">
            {{-- Foto Prewedding Penuh Layar --}}
            <img
                src="{{ $urlFotoSampul }}"
                alt="Sampul {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                fetchpriority="high"
                decoding="sync"
                class="absolute inset-0 w-full h-full object-cover object-top scale-[1.02] animasi-nafas"
            >

            {{-- Gradasi Editorial Zamrud Andalusia (Jernih Penuh di Wajah Mempelai, Kontras Halus di Atas & Bawah) --}}
            <div
                aria-hidden="true"
                class="pointer-events-none absolute inset-0"
                style="background: linear-gradient(180deg, rgba(7,31,28,0.82) 0%, rgba(7,31,28,0.50) 17%, rgba(7,31,28,0.08) 31%, rgba(7,31,28,0.0) 41%, rgba(7,31,28,0.0) 55%, rgba(7,31,28,0.62) 70%, rgba(6,26,24,0.92) 84%, rgba(4,19,17,0.98) 100%);"
            ></div>

            {{-- Bingkai Tunggal Garis Tipis Kubah Emas (Clean Stationery Frame) --}}
            <div
                aria-hidden="true"
                class="pointer-events-none absolute inset-3.5 rounded-t-[10.5rem] rounded-b-[1.5rem] border border-[#E6D19C]/34 z-10"
            ></div>

            {{-- Kilau Halus Di Tepi Luar (Menjaga Visual Tetap Bersih) --}}
            <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden z-[12] opacity-60">
                @foreach ([
                    ['top: 24%; left: 9%;', 'w-1 h-1 bg-[#F3E5AB]', '0.3s'],
                    ['top: 32%; right: 9%;', 'w-1.5 h-1.5 bg-[#E6D19C]', '1.5s'],
                    ['bottom: 30%; left: 10%;', 'w-1 h-1 bg-[#F3E5AB]', '2.2s'],
                    ['bottom: 24%; right: 10%;', 'w-1 h-1 bg-[#E6D19C]', '0.9s'],
                ] as [$posisi, $ukuran, $jeda])
                    <span
                        class="absolute rounded-full {{ $ukuran }} animasi-kilau shadow-[0_0_8px_rgba(230,209,156,0.7)]"
                        style="{{ $posisi }} animation-delay: {{ $jeda }};"
                    ></span>
                @endforeach
            </div>

            {{-- 1. MASTHEAD ATAS BERSIH: RUB EL HIZB MINIMALIS, BASMALAH, NAMA MEMPELAI & TANGGAL --}}
            <header class="relative z-20 shrink-0 px-7 {{ $tampilBarDemo ? 'pt-5 sm:pt-6' : 'pt-7 sm:pt-8' }} text-center">
                <svg
                    aria-hidden="true"
                    viewBox="0 0 24 24"
                    class="w-5 h-5 mx-auto text-[#E6D19C]/92 drop-shadow-[0_2px_8px_rgba(0,0,0,0.5)]"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.35"
                >
                    <rect x="6" y="6" width="12" height="12" rx="1" />
                    <rect x="6" y="6" width="12" height="12" rx="1" transform="rotate(45 12 12)" />
                    <circle cx="12" cy="12" r="1.6" fill="currentColor" stroke="none" />
                </svg>
                <p class="mt-1.5 text-[1.05rem] sm:text-lg text-[#F3E5AB]/95 drop-shadow-[0_2px_10px_rgba(0,0,0,0.58)]" style="font-family: 'Amiri', serif;">
                    بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                </p>
                <p class="mt-0.5 text-[9px] font-semibold uppercase tracking-[0.38em] text-[#E6D19C]/92 drop-shadow">
                    {{ $undangan->teksKustom('sampul_judul', 'Walimatul Ursy') }}
                </p>
                <h1 class="mt-1 font-serif text-[2.35rem] sm:text-[2.65rem] font-semibold tracking-[0.02em] leading-[1.06] text-white drop-shadow-[0_4px_18px_rgba(0,0,0,0.65)]">
                    {{ $undangan->nama_panggilan_pria }}
                    <span class="font-kaligrafi font-normal text-[#E6D19C] mx-1">&amp;</span>
                    {{ $undangan->nama_panggilan_wanita }}
                </h1>
                <p class="mt-1.5 text-[9.5px] sm:text-[10px] font-medium uppercase tracking-[0.28em] text-[#F3E5AB]/88 drop-shadow">
                    {{ $tanggalLengkap }}
                </p>
            </header>

            {{-- Ruang Lega Penuh Untuk Potret Mempelai --}}
            <div class="flex-1 min-h-0"></div>

            {{-- 2. KOMPOSISI EDITORIAL BAWAH: SAPAAN TAMU & TOMBOL MELAYANG BERSIH TANPA KOTAK --}}
            <div class="relative z-20 shrink-0 px-7 pb-7 sm:pb-8 text-center text-[#F7FBF8]">
                <div aria-hidden="true" class="mx-auto mb-3.5 flex items-center justify-center gap-2.5 w-28">
                    <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#E6D19C]/60"></span>
                    <span class="h-1.5 w-1.5 rotate-45 bg-[#E6D19C]/90"></span>
                    <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#E6D19C]/60"></span>
                </div>

                <div class="space-y-2.5">
                    <div class="space-y-0.5">
                        <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
                        <p class="text-[9px] font-medium uppercase tracking-[0.26em] text-[#E6D19C]/85">
                            {{ $undangan->teksKustom('sampul_sapaan', 'Kepada Yth. Bapak/Ibu/Saudara/i') }}
                        </p>
                        <p class="font-serif text-[1.32rem] sm:text-[1.45rem] font-semibold text-white leading-snug tracking-[0.01em] drop-shadow-[0_2px_12px_rgba(0,0,0,0.65)]">
                            {{ $namaTamu }}
                        </p>
                    </div>

                    <div class="pt-1">
                        <button
                            type="button"
                            @click="bukaUndangan()"
                            class="inline-flex items-center justify-center gap-2 rounded-full bg-gradient-to-r from-[#C9A85F] via-[#EFE0B4] to-[#C9A85F] border border-[#FFF7DE]/60 px-8 py-2.5 text-[11px] sm:text-xs font-semibold uppercase tracking-[0.2em] text-[#092623] shadow-[0_14px_30px_-8px_rgba(197,160,89,0.45)] hover:brightness-105 active:scale-[0.98] transition cursor-pointer"
                        >
                            <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="20" height="16" x="2" y="4" rx="2"/>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                            </svg>
                            <span>{{ $undangan->teksKustom('sampul_tombol', 'Buka Undangan') }}</span>
                        </button>
                    </div>

                    <p class="text-[9.5px] italic text-[#F7FBF8]/62 max-w-[240px] mx-auto leading-snug">
                        {{ $undangan->teksKustom('sampul_catatan', 'Mohon maaf apabila ada kesalahan penulisan nama/gelar') }}
                    </p>
                </div>
            </div>
        </div>
    @else
        {{-- MODE TANPA FOTO: STATIONERY CAT AIR ALHAMBRA BERSIH (TIPOGRAFI MELAYANG DI DALAM BINGKAI LUKISAN ZAMRUD) --}}
        <div class="relative w-full h-full flex flex-col justify-center items-center px-10 pt-24 pb-20 bg-[#EEF6F1] overflow-hidden">
            {{-- Karya Latar Penuh: Bingkai Zamrud Alhambra, Bunga Melati Zaitun & Courtyard Cerah --}}
            <img
                src="{{ $urlFotoLatar }}"
                alt="Sampul {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                fetchpriority="high"
                decoding="sync"
                class="absolute inset-0 w-full h-full object-cover object-center scale-[1.01] animasi-nafas"
            >

            {{-- Kabut Alabaster Cat Air Sangat Halus Di Pusat Agar Huruf Tajam Tanpa Menutupi Bingkai Bunga & Ornamen Tepi --}}
            <div
                aria-hidden="true"
                class="pointer-events-none absolute inset-0"
                style="background: radial-gradient(ellipse 72% 56% at 50% 56%, rgba(250,253,251,0.90) 0%, rgba(245,250,247,0.70) 48%, rgba(245,250,247,0.14) 78%, transparent 100%);"
            ></div>

            {{-- Kilau Zaitun Mikro Halus Di Tepi --}}
            <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden z-10 opacity-55">
                @foreach ([
                    ['top: 28%; left: 16%;', 'w-1 h-1 bg-[#C5A059]', '0.3s'],
                    ['top: 34%; right: 16%;', 'w-1.5 h-1.5 bg-[#B99348]', '1.4s'],
                    ['bottom: 24%; left: 18%;', 'w-1 h-1 bg-[#C5A059]', '2.0s'],
                    ['bottom: 28%; right: 18%;', 'w-1 h-1 bg-[#B99348]', '0.9s'],
                ] as [$posisi, $ukuran, $jeda])
                    <span
                        class="absolute rounded-full {{ $ukuran }} animasi-kilau"
                        style="{{ $posisi }} animation-delay: {{ $jeda }};"
                    ></span>
                @endforeach
            </div>

            {{-- Komposisi Letterpress Bersih Tanpa Kotak Kartu --}}
            <div class="relative z-20 w-full max-w-[295px] text-center text-[#0E3A36] space-y-5">
                <div class="space-y-1.5">
                    <svg
                        aria-hidden="true"
                        viewBox="0 0 24 24"
                        class="w-6 h-6 mx-auto text-[#A6833E]"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.35"
                    >
                        <rect x="6" y="6" width="12" height="12" rx="1" />
                        <rect x="6" y="6" width="12" height="12" rx="1" transform="rotate(45 12 12)" />
                        <circle cx="12" cy="12" r="1.5" fill="currentColor" stroke="none" />
                    </svg>

                    <p class="pt-0.5 text-[1.1rem] sm:text-lg text-[#0E3A36]" style="font-family: 'Amiri', serif;">
                        بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                    </p>
                    <p class="text-[9px] font-bold uppercase tracking-[0.38em] text-[#9E7D40]">
                        {{ $undangan->teksKustom('sampul_judul', 'Walimatul Ursy') }}
                    </p>

                    <h1 class="pt-1 font-serif text-[2.45rem] sm:text-[2.75rem] font-semibold tracking-[0.02em] leading-[1.04] text-[#0E3A36]">
                        <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
                        <span class="my-1 flex items-center justify-center gap-3">
                            <span aria-hidden="true" class="h-px w-7 bg-gradient-to-r from-transparent to-[#C5A059]/80"></span>
                            <span class="font-kaligrafi font-normal text-2xl sm:text-3xl text-[#B99348] leading-none">&amp;</span>
                            <span aria-hidden="true" class="h-px w-7 bg-gradient-to-l from-transparent to-[#C5A059]/80"></span>
                        </span>
                        <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
                    </h1>

                    <p class="pt-1.5 text-[9.5px] sm:text-[10px] font-semibold uppercase tracking-[0.26em] text-[#0E3A36]/75">
                        {{ $tanggalLengkap }}
                    </p>
                </div>

                {{-- Garis Berlian Tipis Pemisah --}}
                <div aria-hidden="true" class="mx-auto flex items-center justify-center gap-2.5 w-24">
                    <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#C5A059]/75"></span>
                    <span class="h-1.5 w-1.5 rotate-45 bg-[#0E3A36]/80"></span>
                    <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#C5A059]/75"></span>
                </div>

                {{-- Sapaan Tamu & Tombol Zamrud Bersih --}}
                <div class="space-y-2.5">
                    <div class="space-y-0.5">
                        <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
                        <p class="text-[9px] font-bold uppercase tracking-[0.24em] text-[#9E7D40]">
                            {{ $undangan->teksKustom('sampul_sapaan', 'Kepada Yth. Bapak/Ibu/Saudara/i') }}
                        </p>
                        <p class="font-serif text-[1.32rem] sm:text-[1.45rem] font-bold text-[#0E3A36] leading-snug">
                            {{ $namaTamu }}
                        </p>
                    </div>

                    <div class="pt-1">
                        <button
                            type="button"
                            @click="bukaUndangan()"
                            class="syari-tombol inline-flex items-center justify-center gap-2 rounded-full px-8 py-2.5 text-[11px] sm:text-xs font-semibold uppercase tracking-[0.2em] shadow-[0_14px_28px_-10px_rgba(14,58,54,0.45)] active:scale-[0.98] transition cursor-pointer"
                        >
                            <svg class="w-3.5 h-3.5 text-[#F3E5AB] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="20" height="16" x="2" y="4" rx="2"/>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                            </svg>
                            <span>{{ $undangan->teksKustom('sampul_tombol', 'Buka Undangan') }}</span>
                        </button>
                    </div>

                    <p class="text-[9.5px] italic text-[#0E3A36]/62 max-w-[230px] mx-auto leading-snug">
                        {{ $undangan->teksKustom('sampul_catatan', 'Mohon maaf apabila ada kesalahan penulisan nama/gelar') }}
                    </p>
                </div>
            </div>
        </div>
    @endif
</section>
