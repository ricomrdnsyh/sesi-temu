{{-- SAMPUL PEMBUKA EDITORIAL MONOKROM (MAJALAH VOGUE — ZERO ROUNDED CORNERS) --}}
<section
    data-transisi-sampul="fade-halus"
    class="tirai-fade-halus fixed inset-0 mx-auto h-dvh w-full lg:w-[460px] xl:w-[490px] z-40 {{ $tampilBarDemo ? 'pt-28 sm:pt-20 lg:pt-14' : '' }}"
    style="height: 100dvh;"
    :class="undanganTerbuka ? 'tirai-terbuka pointer-events-none' : ''"
>
    <div class="relative w-full h-full flex flex-col {{ $pakaiFotoSampul ? 'justify-between' : 'justify-center items-center px-6 py-8' }} overflow-hidden bg-[#111113]">
        <img
            src="{{ $pakaiFotoSampul ? $urlFotoSampul : $urlFotoLatar }}"
            alt="Sampul {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
            class="absolute inset-0 w-full h-full object-cover grayscale {{ $pakaiFotoSampul ? 'object-top scale-[1.02] animasi-nafas' : 'object-center scale-105 animasi-nafas' }}"
        >

        @if ($pakaiFotoSampul)
            <div
                aria-hidden="true"
                class="pointer-events-none absolute inset-0"
                style="background: linear-gradient(180deg, rgba(17,17,19,0.8) 0%, rgba(17,17,19,0.28) 24%, rgba(17,17,19,0.03) 48%, rgba(17,17,19,0.24) 66%, rgba(17,17,19,0.88) 86%, rgba(11,11,13,0.98) 100%);"
            ></div>
            <div aria-hidden="true" class="pointer-events-none absolute inset-3.5 rounded-none border border-white/30 z-10"></div>
        @else
            <div class="absolute inset-0 bg-gradient-to-b from-black/78 via-black/52 to-black/88"></div>
        @endif

        @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'halus', 'konteks' => 'sampul'])

        @if ($pakaiFotoSampul)
            <div class="relative z-20 px-7 pt-7 sm:pt-8 text-white space-y-3">
                <div class="flex items-center justify-between text-[10px] uppercase tracking-[0.28em] text-white/80 border-b border-white/30 pb-2">
                    <span>Vol. 01</span>
                    <span>The Wedding Edition</span>
                    <span>{{ $tahunAcara }}</span>
                </div>
                <div class="text-center space-y-1">
                    <p class="text-[10px] uppercase tracking-[0.36em] text-white/75">Editorial Invitation</p>
                    <h1 class="ed-serif text-4xl sm:text-5xl uppercase tracking-[0.06em] leading-[1.02] text-white drop-shadow">
                        {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
                    </h1>
                    <p class="text-[10px] uppercase tracking-[0.26em] text-white/80 pt-1">
                        {{ $tanggalLengkap }}
                    </p>
                </div>
            </div>

            <div class="flex-1"></div>

            <div class="relative z-20 px-7 pb-9 sm:pb-11 text-center text-white space-y-2.5">
                <div class="flex items-center justify-center gap-3 px-10 pb-0.5" aria-hidden="true">
                    <span class="h-px flex-1 bg-white/35"></span>
                    <span class="w-1.5 h-1.5 bg-white/80"></span>
                    <span class="h-px flex-1 bg-white/35"></span>
                </div>
                <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
                <p class="text-[10px] font-semibold uppercase tracking-[0.26em] text-white/80">
                    Kepada Yth. Bapak/Ibu/Saudara/i
                </p>
                <p class="ed-serif text-2xl sm:text-[1.65rem] text-white drop-shadow">
                    {{ $namaTamu }}
                </p>
                <div class="pt-2">
                    <button
                        type="button"
                        @click="bukaUndangan()"
                        class="inline-flex items-center justify-center gap-2 rounded-none bg-white text-[#111113] border border-white px-9 py-3 text-xs font-bold uppercase tracking-[0.28em] shadow-2xl hover:bg-white/90 active:scale-95 transition cursor-pointer"
                    >
                        <span>Buka Undangan &rarr;</span>
                    </button>
                </div>
                <p class="text-[10px] italic text-white/70 pt-1 max-w-xs mx-auto leading-relaxed">
                    Mohon maaf apabila ada kesalahan penulisan nama/gelar
                </p>
            </div>
        @else
            {{-- Mode Tanpa Foto: Sampul Editorial Vogue Terpusat (Zero Rounded Corners) --}}
            <div class="relative z-20 w-full max-w-[360px]">
                <div class="kartu-3d rounded-none bg-[#FAF9F6]/96 backdrop-blur-md border border-[#18181B] p-2 shadow-2xl">
                    <div class="rounded-none border border-[#18181B]/25 px-6 py-7 text-center text-[#18181B] space-y-5">
                        <div class="flex items-center justify-between text-[9px] font-semibold uppercase tracking-[0.26em] text-[#52525B] border-b border-[#18181B]/20 pb-2">
                            <span>Vol. 01</span>
                            <span>The Wedding Edition</span>
                            <span>{{ $tahunAcara }}</span>
                        </div>

                        <div class="space-y-1.5 pt-1">
                            <p class="text-[10px] uppercase tracking-[0.34em] text-[#52525B]">Editorial Invitation</p>
                            <h1 class="ed-serif text-4xl sm:text-[2.65rem] uppercase tracking-[0.06em] leading-[1.06] text-[#18181B]">
                                <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
                                <span class="block text-2xl text-[#52525B] my-0.5">&amp;</span>
                                <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
                            </h1>
                            <p class="text-[11px] uppercase tracking-[0.22em] text-[#52525B] pt-1">
                                {{ $tanggalLengkap }}
                            </p>
                        </div>

                        <div class="border-t border-[#18181B]/20 pt-4 space-y-2.5">
                            <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
                            <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-[#52525B]">
                                Kepada Yth. Bapak/Ibu/Saudara/i
                            </p>
                            <p class="ed-serif text-2xl text-[#18181B] leading-snug">
                                {{ $namaTamu }}
                            </p>
                            <div class="pt-1.5">
                                <button
                                    type="button"
                                    @click="bukaUndangan()"
                                    class="w-full rounded-none bg-[#18181B] text-white px-6 py-3.5 text-xs font-bold uppercase tracking-[0.28em] hover:bg-[#3F3F46] transition cursor-pointer"
                                >
                                    Buka Undangan &rarr;
                                </button>
                            </div>
                            <p class="text-[10px] italic text-[#52525B] pt-1 max-w-xs mx-auto leading-relaxed">
                                Mohon maaf apabila ada kesalahan penulisan nama/gelar
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
