{{-- SAMPUL PEMBUKA SUNDA SIGER HERITAGE (FADE HALUS TANPA BUKA BUKU) --}}
<section
    data-transisi-sampul="fade-halus"
    class="tirai-fade-halus fixed inset-0 mx-auto h-dvh w-full lg:w-[460px] xl:w-[490px] z-40 {{ $tampilBarDemo ? 'pt-28 sm:pt-20 lg:pt-14' : '' }}"
    style="height: 100dvh;"
    :class="undanganTerbuka ? 'tirai-terbuka pointer-events-none' : ''"
>
    <div class="relative w-full h-full flex flex-col {{ $pakaiFotoSampul ? 'justify-between' : 'justify-center items-center px-6 py-8' }} overflow-hidden bg-[#3B1414]">
        <img
            src="{{ $pakaiFotoSampul ? $urlFotoSampul : $urlFotoLatar }}"
            alt="Sampul {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
            class="absolute inset-0 w-full h-full object-cover {{ $pakaiFotoSampul ? 'object-top scale-[1.02] animasi-nafas' : 'object-center scale-105 animasi-nafas' }}"
        >

        @if ($pakaiFotoSampul)
            <div
                aria-hidden="true"
                class="pointer-events-none absolute inset-0"
                style="background: linear-gradient(180deg, rgba(43,14,14,0.78) 0%, rgba(43,14,14,0.28) 24%, rgba(43,14,14,0.02) 48%, rgba(43,14,14,0.24) 66%, rgba(43,14,14,0.86) 86%, rgba(34,10,10,0.97) 100%);"
            ></div>
            <div aria-hidden="true" class="pointer-events-none absolute inset-3.5 rounded-t-[10rem] rounded-b-[1.75rem] border border-[#E7C87D]/45 z-10"></div>
        @else
            <div class="absolute inset-0 bg-gradient-to-b from-[#3B1414]/72 via-[#4A1717]/42 to-[#2B0E0E]/88"></div>
            <img
                src="{{ $asetSunda['gapura'] }}"
                alt=""
                aria-hidden="true"
                class="pointer-events-none absolute inset-x-3 top-6 bottom-6 h-[calc(100%-3rem)] w-[calc(100%-1.5rem)] object-contain opacity-28"
            >
        @endif

        @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'melati-burung', 'konteks' => 'sampul'])

        @if ($pakaiFotoSampul)
            <div class="relative z-20 px-8 pt-7 sm:pt-9 text-center text-white space-y-1.5">
                <img src="{{ $asetSunda['siger'] }}" alt="" class="w-12 mx-auto opacity-95 animasi-ayun-3d">
                <p class="text-[10px] font-semibold uppercase tracking-[0.35em] text-[#F3E5AB] drop-shadow">
                    Sampurasun &bull; Walimatul Ursy
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
                    Kepada Yth. Bapak/Ibu/Saudara/i
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
                        <span>Buka Undangan</span>
                    </button>
                </div>
                <p class="text-[10px] italic text-[#FAF4E8]/75 pt-1 max-w-xs mx-auto leading-relaxed">
                    Mohon maaf apabila ada kesalahan penulisan nama/gelar
                </p>
            </div>
        @else
            {{-- Mode Tanpa Foto: Kartu Gapura Priangan Terpusat di Tengah --}}
            <div class="relative z-20 w-full max-w-[360px]">
                <div class="kartu-3d rounded-t-[10rem] rounded-b-[2rem] bg-[#FFFBF4]/94 backdrop-blur-md border-2 border-[#C59B43]/75 p-2 shadow-[0_28px_70px_-16px_rgba(0,0,0,0.65)]">
                    <div class="rounded-t-[9.3rem] rounded-b-[1.5rem] border border-[#C59B43]/40 px-6 pt-9 pb-7 text-center text-[#4A2020] space-y-4">
                        <div class="space-y-1.5">
                            <img src="{{ $asetSunda['siger'] }}" alt="" class="w-14 mx-auto opacity-95 animasi-ayun-3d">
                            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#8E6620]">
                                Sampurasun &bull; Walimatul Ursy
                            </p>
                            <h1 class="font-serif text-4xl sm:text-[2.65rem] font-bold leading-[1.08] text-[#5A1E1E] pt-1">
                                <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
                                <span class="block font-kaligrafi font-normal text-3xl text-[#B58931] my-0.5">&amp;</span>
                                <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
                            </h1>
                            <p class="text-[11px] font-medium uppercase tracking-[0.24em] text-[#4A2020]/80 pt-1">
                                {{ $tanggalLengkap }}
                            </p>
                        </div>

                        <div class="flex items-center justify-center gap-3 px-6" aria-hidden="true">
                            <span class="h-px flex-1 bg-[#C59B43]/50"></span>
                            <span class="w-1.5 h-1.5 rotate-45 bg-[#5A1E1E]"></span>
                            <span class="h-px flex-1 bg-[#C59B43]/50"></span>
                        </div>

                        <div class="space-y-2.5 pt-0.5">
                            <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
                            <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-[#8E6620]">
                                Kepada Yth. Bapak/Ibu/Saudara/i
                            </p>
                            <p class="font-serif text-xl sm:text-2xl font-bold text-[#5A1E1E] leading-snug">
                                {{ $namaTamu }}
                            </p>
                            <div class="pt-2">
                                <button
                                    type="button"
                                    @click="bukaUndangan()"
                                    class="sunda-tombol-marun inline-flex items-center justify-center gap-2 rounded-full px-8 py-3 text-xs sm:text-sm font-bold uppercase tracking-[0.18em] transition cursor-pointer"
                                >
                                    <span>Buka Undangan</span>
                                </button>
                            </div>
                            <p class="text-[10px] italic text-[#4A2020]/70 pt-1 max-w-xs mx-auto leading-relaxed">
                                Mohon maaf apabila ada kesalahan penulisan nama/gelar
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
