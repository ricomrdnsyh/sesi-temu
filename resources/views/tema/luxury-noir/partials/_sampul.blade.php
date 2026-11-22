{{-- SAMPUL PEMBUKA LUXURY NOIR (FADE HALUS) --}}
<section
    data-transisi-sampul="fade-halus"
    class="tirai-fade-halus fixed inset-0 mx-auto h-dvh w-full lg:w-[460px] xl:w-[490px] z-40 {{ $tampilBarDemo ? 'pt-28 sm:pt-20 lg:pt-14' : '' }}"
    style="height: 100dvh;"
    :class="undanganTerbuka ? 'tirai-terbuka pointer-events-none' : ''"
>
    <div class="relative w-full h-full flex flex-col {{ $pakaiFotoSampul ? 'justify-between' : 'justify-center items-center px-6 py-8' }} overflow-hidden bg-[#09090D]">
        <img
            src="{{ $pakaiFotoSampul ? $urlFotoSampul : $urlFotoLatar }}"
            alt="Sampul {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
            class="absolute inset-0 w-full h-full object-cover {{ $pakaiFotoSampul ? 'object-top scale-[1.02] animasi-nafas' : 'object-center scale-105 animasi-nafas' }}"
        >

        @if ($pakaiFotoSampul)
            <div
                aria-hidden="true"
                class="pointer-events-none absolute inset-0"
                style="background: linear-gradient(180deg, rgba(9,9,13,0.82) 0%, rgba(9,9,13,0.28) 24%, rgba(9,9,13,0.03) 48%, rgba(9,9,13,0.24) 66%, rgba(9,9,13,0.88) 86%, rgba(6,6,9,0.98) 100%);"
            ></div>
            <div aria-hidden="true" class="pointer-events-none absolute inset-3.5 rounded-xl border border-[#D4AF37]/40 z-10">
                <span class="absolute -top-0.5 -left-0.5 h-5 w-5 border-t-2 border-l-2 border-[#D4AF37]"></span>
                <span class="absolute -top-0.5 -right-0.5 h-5 w-5 border-t-2 border-r-2 border-[#D4AF37]"></span>
                <span class="absolute -bottom-0.5 -left-0.5 h-5 w-5 border-b-2 border-l-2 border-[#D4AF37]"></span>
                <span class="absolute -bottom-0.5 -right-0.5 h-5 w-5 border-b-2 border-r-2 border-[#D4AF37]"></span>
            </div>
        @else
            <div class="absolute inset-0 bg-gradient-to-b from-black/78 via-black/48 to-black/92"></div>
            <img src="{{ $asetNoir['bingkai'] }}" alt="" aria-hidden="true" class="pointer-events-none absolute inset-4 h-[calc(100%-2rem)] w-[calc(100%-2rem)] object-contain opacity-30">
        @endif

        @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'debu-emas', 'konteks' => 'sampul'])

        @if ($pakaiFotoSampul)
            <div class="relative z-20 px-8 pt-8 sm:pt-10 text-center text-[#F5EFE6] space-y-1.5">
                <p class="text-[10px] font-semibold uppercase tracking-[0.4em] text-[#D4AF37] drop-shadow">
                    The Grand Celebration
                </p>
                <h1 class="noir-font-judul text-3xl sm:text-[2.6rem] font-bold tracking-wider leading-tight text-white drop-shadow-[0_4px_16px_rgba(0,0,0,0.55)]">
                    {{ $undangan->nama_panggilan_pria }}
                    <span class="font-kaligrafi font-normal text-[#D4AF37] mx-1">&amp;</span>
                    {{ $undangan->nama_panggilan_wanita }}
                </h1>
                <p class="text-[10px] uppercase tracking-[0.26em] text-[#F5EFE6]/85 drop-shadow">
                    {{ $tanggalLengkap }}
                </p>
            </div>

            <div class="flex-1"></div>

            <div class="relative z-20 px-7 pb-9 sm:pb-11 text-center text-[#F5EFE6] space-y-2.5">
                <div class="flex items-center justify-center gap-3 px-10 pb-0.5" aria-hidden="true">
                    <span class="h-px flex-1 bg-[#D4AF37]/45"></span>
                    <span class="w-1.5 h-1.5 rotate-45 bg-[#D4AF37]"></span>
                    <span class="h-px flex-1 bg-[#D4AF37]/45"></span>
                </div>
                <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
                <p class="text-[10px] font-semibold uppercase tracking-[0.26em] text-[#D4AF37]">
                    Kepada Yth. Bapak/Ibu/Saudara/i
                </p>
                <p class="noir-font-judul text-lg sm:text-xl font-bold tracking-wide text-[#F3E5AB] drop-shadow-[0_2px_12px_rgba(0,0,0,0.65)]">
                    {{ $namaTamu }}
                </p>
                <div class="pt-2">
                    <button
                        type="button"
                        @click="bukaUndangan()"
                        class="noir-tombol-emas animasi-segel inline-flex items-center justify-center gap-2 rounded-full px-8 py-3 text-xs sm:text-sm font-bold uppercase tracking-[0.2em] active:scale-95 transition cursor-pointer"
                    >
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect width="20" height="16" x="2" y="4" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                        <span>Buka Undangan</span>
                    </button>
                </div>
                <p class="text-[10px] italic text-[#F5EFE6]/70 pt-1 max-w-xs mx-auto leading-relaxed">
                    Mohon maaf apabila ada kesalahan penulisan nama/gelar
                </p>
            </div>
        @else
            {{-- Mode Tanpa Foto: Plakat Art Deco Emas Terpusat --}}
            <div class="relative z-20 w-full max-w-[360px]">
                <div class="relative kartu-3d efek-shimmer-kartu rounded-xl bg-[#111016]/90 backdrop-blur-md border border-[#D4AF37]/65 px-6 py-8 text-center text-[#F5EFE6] shadow-[0_28px_70px_-16px_rgba(0,0,0,0.85)] space-y-4">
                    <span aria-hidden="true" class="pointer-events-none absolute -top-1 -left-1 h-5 w-5 border-t-2 border-l-2 border-[#D4AF37]"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute -top-1 -right-1 h-5 w-5 border-t-2 border-r-2 border-[#D4AF37]"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute -bottom-1 -left-1 h-5 w-5 border-b-2 border-l-2 border-[#D4AF37]"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute -bottom-1 -right-1 h-5 w-5 border-b-2 border-r-2 border-[#D4AF37]"></span>

                    <div class="space-y-2">
                        <div class="mx-auto w-16 h-16 relative flex items-center justify-center">
                            <span class="absolute inset-0 rounded-full border border-dashed border-[#D4AF37]/65 animasi-orbit"></span>
                            <span class="noir-font-judul text-sm font-bold tracking-widest text-[#F3E5AB]">{{ $undangan->inisialPria() }}&amp;{{ $undangan->inisialWanita() }}</span>
                        </div>
                        <p class="text-[10px] font-semibold uppercase tracking-[0.4em] text-[#D4AF37]">
                            The Grand Celebration
                        </p>
                        <h1 class="noir-font-judul text-3xl sm:text-[2.45rem] font-bold tracking-wider leading-[1.1] text-white pt-1">
                            <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
                            <span class="block font-kaligrafi font-normal text-3xl text-[#D4AF37] my-0.5">&amp;</span>
                            <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
                        </h1>
                        <p class="text-[11px] uppercase tracking-[0.26em] text-[#F5EFE6]/85 pt-1">
                            {{ $tanggalLengkap }}
                        </p>
                    </div>

                    <div class="flex items-center justify-center gap-3 px-6" aria-hidden="true">
                        <span class="h-px flex-1 bg-[#D4AF37]/45"></span>
                        <span class="w-1.5 h-1.5 rotate-45 bg-[#D4AF37]"></span>
                        <span class="h-px flex-1 bg-[#D4AF37]/45"></span>
                    </div>

                    <div class="space-y-2.5 pt-0.5">
                        <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
                        <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-[#D4AF37]">
                            Kepada Yth. Bapak/Ibu/Saudara/i
                        </p>
                        <p class="noir-font-judul text-lg sm:text-xl font-bold tracking-wide text-[#F3E5AB] leading-snug">
                            {{ $namaTamu }}
                        </p>
                        <div class="pt-2">
                            <button
                                type="button"
                                @click="bukaUndangan()"
                                class="noir-tombol-emas animasi-segel inline-flex items-center justify-center gap-2 rounded-full px-8 py-3 text-xs sm:text-sm font-bold uppercase tracking-[0.2em] transition cursor-pointer"
                            >
                                <span>Buka Undangan</span>
                            </button>
                        </div>
                        <p class="text-[10px] italic text-[#F5EFE6]/70 pt-1 max-w-xs mx-auto leading-relaxed">
                            Mohon maaf apabila ada kesalahan penulisan nama/gelar
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
