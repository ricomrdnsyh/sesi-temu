{{-- SAMPUL PEMBUKA SUNDA SIGER HERITAGE (GULIR KE ATAS 60FPS) --}}
<section
    data-transisi-sampul="fade-halus"
    class="tirai-fade-halus tirai-gulir-atas fixed inset-0 mx-auto h-dvh w-full lg:w-[460px] xl:w-[490px] z-40 {{ $tampilBarDemo ? 'pt-28 sm:pt-20 lg:pt-14' : '' }}"
    style="height: 100dvh;"
    :class="undanganTerbuka ? 'tirai-terbuka pointer-events-none' : ''"
>
    <div class="relative w-full h-full flex flex-col {{ $pakaiFotoSampul ? 'justify-between bg-[#3B1414]' : 'justify-between bg-[#F3ECE1]' }} overflow-hidden">
        @if ($pakaiFotoSampul)
            <img
                src="{{ $urlFotoSampul }}"
                alt="Sampul {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                fetchpriority="high"
                decoding="sync"
                class="absolute inset-0 w-full h-full object-cover object-top scale-[1.02] animasi-nafas"
            >
            <div
                aria-hidden="true"
                class="pointer-events-none absolute inset-0"
                style="background: linear-gradient(180deg, rgba(43,14,14,0.78) 0%, rgba(43,14,14,0.28) 24%, rgba(43,14,14,0.02) 48%, rgba(43,14,14,0.24) 66%, rgba(43,14,14,0.86) 86%, rgba(34,10,10,0.97) 100%);"
            ></div>
            <div aria-hidden="true" class="pointer-events-none absolute inset-3.5 rounded-t-[10rem] rounded-b-[1.75rem] border border-[#E7C87D]/45 z-10"></div>
        @else
            {{-- Latar Kertas Gading Priangan & Bingkai Arch Penuh Berhiaskan Bunga Kamelia-Anggrek Atas & Bawah --}}
            <img
                src="{{ $urlFotoLatar }}"
                alt="Sampul Sunda Siger Heritage"
                fetchpriority="high"
                decoding="sync"
                class="absolute inset-0 w-full h-full object-cover object-bottom opacity-22"
            >
            <div
                aria-hidden="true"
                class="pointer-events-none absolute inset-0"
                style="background: linear-gradient(180deg, rgba(243,236,225,0.86) 0%, rgba(250,244,232,0.78) 48%, rgba(243,236,225,0.62) 100%);"
            ></div>

            {{-- Kanvas Arch Emas Penuh Tinggi Layar dengan Siluet Rumah Panggung Halus di Bawah --}}
            <div
                aria-hidden="true"
                class="pointer-events-none absolute inset-x-3.5 top-5 bottom-4 rounded-t-[13rem] rounded-b-[2rem] border-[2px] border-[#C59B43]/85 bg-[#FAF4E8]/90 shadow-[0_24px_60px_-20px_rgba(74,23,23,0.28)] overflow-hidden z-[8]"
            >
                <img
                    src="{{ $urlFotoLatar }}"
                    alt=""
                    class="absolute inset-0 w-full h-full object-cover object-bottom opacity-24"
                >
                <div
                    class="absolute inset-0"
                    style="background: linear-gradient(180deg, #FAF4E8 0%, rgba(250,244,232,0.94) 48%, rgba(250,244,232,0.68) 76%, rgba(250,244,232,0.22) 100%);"
                ></div>
                <div class="absolute inset-2 rounded-t-[12.4rem] rounded-b-[1.6rem] border border-[#C59B43]/35"></div>
            </div>

            {{-- Rangkaian Bunga Kamelia Marun & Anggrek Bulan Membingkai Tepi Atas & Bawah --}}
            <img
                src="{{ $asetSunda['bungaDepan'] }}"
                alt=""
                aria-hidden="true"
                class="pointer-events-none absolute -top-4 inset-x-0 w-full rotate-180 opacity-92 drop-shadow-[0_6px_14px_rgba(59,20,20,0.25)] z-[14]"
            >
            <img
                src="{{ $asetSunda['bungaDepan'] }}"
                alt=""
                aria-hidden="true"
                class="pointer-events-none absolute -bottom-1 inset-x-0 w-full opacity-96 drop-shadow-[0_-8px_18px_rgba(59,20,20,0.3)] z-[14]"
            >
        @endif

        @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'melati-burung', 'konteks' => 'sampul'])

        @if ($pakaiFotoSampul)
            <div class="relative z-20 px-8 pt-7 sm:pt-9 text-center text-white space-y-1.5">
                <img src="{{ $asetSunda['siger'] }}" alt="" class="w-12 mx-auto opacity-95 animasi-ayun-3d">
                <p class="text-[10px] font-semibold uppercase tracking-[0.35em] text-[#F3E5AB] drop-shadow">
                    {{ $undangan->teksKustom('sampul_judul', 'Sampurasun • Walimatul Ursy') }}
                </p>
                <h1 class="font-serif text-4xl sm:text-[2.75rem] font-bold leading-tight text-white drop-shadow-[0_4px_16px_rgba(0,0,0,0.5)]">
                    {{ $undangan->nama_panggilan_pria }}
                    <span class="font-kaligrafi font-normal text-[#E7C87D] mx-1">&amp;</span>
                    {{ $undangan->nama_panggilan_wanita }}
                </h1>
                <p class="text-[10px] uppercase tracking-[0.26em] text-[#FAF4E8]/90 drop-shadow">
                    {{ $tanggalLengkap }}
                </p>
            </div>

            <div class="flex-1"></div>

            <div class="relative z-20 px-7 pb-9 sm:pb-11 text-center text-[#FAF4E8] space-y-2.5">
                <div class="flex items-center justify-center gap-3 px-10 pb-0.5" aria-hidden="true">
                    <span class="h-px flex-1 bg-[#E7C87D]/45"></span>
                    <span class="w-1.5 h-1.5 rotate-45 bg-[#E7C87D]"></span>
                    <span class="h-px flex-1 bg-[#E7C87D]/45"></span>
                </div>
                <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
                <p class="text-[10px] font-semibold uppercase tracking-[0.24em] text-[#F3E5AB]">
                    {{ $undangan->teksKustom('sampul_sapaan', 'Kepada Yth. Bapak/Ibu/Saudara/i') }}
                </p>
                <p class="font-serif text-xl sm:text-2xl font-bold text-white drop-shadow-[0_2px_12px_rgba(0,0,0,0.55)]">
                    {{ $namaTamu }}
                </p>
                <div class="pt-2">
                    <button
                        type="button"
                        @click="bukaUndangan()"
                        class="sunda-tombol-emas inline-flex items-center justify-center gap-2 rounded-full px-8 py-3 text-xs sm:text-sm font-bold uppercase tracking-[0.18em] shadow-[0_14px_30px_-8px_rgba(0,0,0,0.6)] active:scale-95 transition cursor-pointer"
                    >
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect width="20" height="16" x="2" y="4" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                        <span>{{ $undangan->teksKustom('sampul_tombol', 'Buka Undangan') }}</span>
                    </button>
                </div>
                <p class="text-[10px] italic text-[#FAF4E8]/75 pt-1 max-w-xs mx-auto leading-relaxed">
                    {{ $undangan->teksKustom('sampul_catatan', 'Mohon maaf apabila ada kesalahan penulisan nama/gelar') }}
                </p>
            </div>
        @else
            {{-- Mode Tanpa Foto: Tipografi Editorial Bersih di Dalam Arch Emas Berhiaskan Kamelia & Anggrek --}}
            <div class="relative z-20 flex-1 flex flex-col items-center justify-center px-9 pt-20 pb-28 text-center text-[#4A2020]">
                <div class="w-full max-w-[300px] space-y-5">
                    <div class="space-y-2">
                        <img
                            src="{{ $asetSunda['siger'] }}"
                            alt=""
                            class="w-11 sm:w-12 mx-auto opacity-95 drop-shadow-[0_4px_10px_rgba(90,30,30,0.2)]"
                        >
                        <p class="text-[9.5px] font-semibold uppercase tracking-[0.34em] text-[#8E6620]">
                            {{ $undangan->teksKustom('sampul_judul', 'The Wedding Of') }}
                        </p>
                        <h1 class="font-serif text-[2.35rem] sm:text-[2.65rem] font-semibold uppercase tracking-[0.1em] leading-[1.08] text-[#5A1E1E] pt-0.5">
                            <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
                            <span class="block font-kaligrafi normal-case font-normal text-3xl text-[#B58931] my-0.5">&amp;</span>
                            <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
                        </h1>
                        <p class="text-[10.5px] font-medium uppercase tracking-[0.22em] text-[#5A1E1E]/75 pt-1">
                            {{ $tanggalLengkap }}
                        </p>
                    </div>

                    <div class="space-y-1.5 pt-2">
                        <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
                        <p class="text-[10px] font-medium tracking-[0.12em] text-[#6E3434]/85 leading-relaxed">
                            @if ($undangan->teksKustom('sampul_sapaan') !== '')
                                {{ $undangan->teksKustom('sampul_sapaan') }}
                            @else
                                Kepada Yth.<br>
                                Bapak/Ibu/Saudara/i
                            @endif
                        </p>
                        <p class="font-serif text-xl sm:text-[1.4rem] font-bold text-[#4A1818] leading-snug pt-0.5">
                            {{ $namaTamu }}
                        </p>
                    </div>

                    <div class="pt-1.5">
                        <button
                            type="button"
                            @click="bukaUndangan()"
                            class="sunda-tombol-marun inline-flex items-center justify-center gap-2 rounded-full px-8 py-2.5 text-[11px] sm:text-xs font-bold uppercase tracking-[0.2em] shadow-[0_12px_26px_-8px_rgba(90,30,30,0.55)] active:scale-[0.98] transition cursor-pointer"
                        >
                            <svg class="w-3.5 h-3.5 text-[#F3E5AB]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="20" height="16" x="2" y="4" rx="2"/>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                            </svg>
                            <span>{{ $undangan->teksKustom('sampul_tombol', 'Buka Undangan') }}</span>
                        </button>
                    </div>

                    <p class="text-[9.5px] italic text-[#4A2020]/68 max-w-[230px] mx-auto leading-relaxed">
                        {{ $undangan->teksKustom('sampul_catatan', 'Mohon maaf apabila ada kesalahan penulisan nama/gelar') }}
                    </p>
                </div>
            </div>
        @endif
    </div>
</section>
