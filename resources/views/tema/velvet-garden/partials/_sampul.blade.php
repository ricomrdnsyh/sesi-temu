{{-- SAMPUL PEMBUKA VELVET GARDEN (GULIR ATAS HALUS) --}}
<section
    data-transisi-sampul="fade-halus"
    class="tirai-fade-halus tirai-gulir-atas fixed inset-0 mx-auto h-dvh w-full lg:w-[460px] xl:w-[490px] z-40 {{ $tampilBarDemo ? 'pt-28 sm:pt-20 lg:pt-14' : '' }}"
    style="height: 100dvh;"
    :class="undanganTerbuka ? 'tirai-terbuka pointer-events-none' : ''"
>
    <div class="relative w-full h-full flex flex-col {{ $pakaiFotoSampul ? 'justify-between' : 'justify-center items-center px-6 py-8' }} overflow-hidden bg-[#0E1E18]">
        <img
            src="{{ $pakaiFotoSampul ? $urlFotoSampul : $urlFotoLatar }}"
            alt="Sampul {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
            class="absolute inset-0 w-full h-full object-cover {{ $pakaiFotoSampul ? 'object-top scale-[1.02] animasi-nafas' : 'object-center scale-105 animasi-nafas' }}"
        >

        @if ($pakaiFotoSampul)
            <div
                aria-hidden="true"
                class="pointer-events-none absolute inset-0"
                style="background: linear-gradient(180deg, rgba(14,30,24,0.78) 0%, rgba(14,30,24,0.28) 24%, rgba(14,30,24,0.03) 48%, rgba(14,30,24,0.24) 66%, rgba(14,30,24,0.86) 86%, rgba(10,23,18,0.97) 100%);"
            ></div>
            <div aria-hidden="true" class="pointer-events-none absolute inset-3.5 rounded-t-[10rem] rounded-b-[1.75rem] border border-[#C8A464]/45 z-10"></div>
        @else
            <div class="absolute inset-0 bg-gradient-to-b from-[#0E1E18]/70 via-[#132623]/38 to-[#0A1712]/88"></div>
            <img src="{{ $asetGarden['konservatori'] }}" alt="" aria-hidden="true" class="pointer-events-none absolute inset-3 h-[calc(100%-1.5rem)] w-[calc(100%-1.5rem)] object-contain opacity-30">
        @endif

        @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'kelopak-kunang', 'konteks' => 'sampul'])

        @if ($pakaiFotoSampul)
            <div class="relative z-20 px-8 pt-7 sm:pt-9 text-center text-white space-y-1.5">
                <img src="{{ $asetGarden['botani'] }}" alt="" class="w-12 mx-auto opacity-95 animasi-melayang">
                <p class="text-[10px] font-semibold uppercase tracking-[0.36em] text-[#EEDAD4] drop-shadow">
                    {{ $undangan->teksKustom('sampul_judul', 'Velvet Garden Motion') }}
                </p>
                <h1 class="font-serif text-4xl sm:text-[2.75rem] font-bold leading-tight text-white drop-shadow-[0_4px_16px_rgba(0,0,0,0.5)]">
                    {{ $undangan->nama_panggilan_pria }}
                    <span class="font-kaligrafi font-normal text-[#C8A464] mx-1">&amp;</span>
                    {{ $undangan->nama_panggilan_wanita }}
                </h1>
                <p class="text-[10px] uppercase tracking-[0.26em] text-[#F4F8F6]/90 drop-shadow">
                    {{ $tanggalLengkap }}
                </p>
            </div>

            <div class="flex-1"></div>

            <div class="relative z-20 px-7 pb-9 sm:pb-11 text-center text-[#F4F8F6] space-y-2.5">
                <div class="flex items-center justify-center gap-3 px-10 pb-0.5" aria-hidden="true">
                    <span class="h-px flex-1 bg-[#C8A464]/45"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-[#EEDAD4]"></span>
                    <span class="h-px flex-1 bg-[#C8A464]/45"></span>
                </div>
                <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
                <p class="text-[10px] font-semibold uppercase tracking-[0.26em] text-[#EEDAD4]">
                    {{ $undangan->teksKustom('sampul_sapaan', 'Kepada Yth. Bapak/Ibu/Saudara/i') }}
                </p>
                <p class="font-serif text-xl sm:text-2xl font-bold text-[#F3DFA2] drop-shadow-[0_2px_12px_rgba(0,0,0,0.6)]">
                    {{ $namaTamu }}
                </p>
                <div class="pt-2">
                    <button
                        type="button"
                        @click="bukaUndangan()"
                        class="garden-tombol-emas inline-flex items-center justify-center gap-2 rounded-full px-8 py-3 text-xs sm:text-sm font-bold uppercase tracking-[0.18em] active:scale-95 transition cursor-pointer"
                    >
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect width="20" height="16" x="2" y="4" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                        <span>{{ $undangan->teksKustom('sampul_tombol', 'Buka Undangan') }}</span>
                    </button>
                </div>
                <p class="text-[10px] italic text-[#F4F8F6]/75 pt-1 max-w-xs mx-auto leading-relaxed">
                    {{ $undangan->teksKustom('sampul_catatan', 'Mohon maaf apabila ada kesalahan penulisan nama/gelar') }}
                </p>
            </div>
        @else
            {{-- Mode Tanpa Foto: Kartu Konservatori Botani Terpusat --}}
            <div class="relative z-20 w-full max-w-[360px]">
                <div class="kartu-3d efek-shimmer-kartu rounded-t-[10rem] rounded-b-[2rem] bg-[#FDFBF7]/94 backdrop-blur-md border-2 border-[#C8A464]/70 p-2 shadow-[0_28px_70px_-16px_rgba(0,0,0,0.7)]">
                    <div class="rounded-t-[9.3rem] rounded-b-[1.5rem] border border-[#C8A464]/35 px-6 pt-9 pb-7 text-center text-[#1F3431] space-y-4">
                        <div class="space-y-1.5">
                            <img src="{{ $asetGarden['botani'] }}" alt="" class="w-14 mx-auto opacity-95 animasi-melayang">
                            <p class="text-[10px] font-bold uppercase tracking-[0.36em] text-[#8D6F3A]">
                                {{ $undangan->teksKustom('sampul_judul', 'Velvet Garden Motion') }}
                            </p>
                            <h1 class="font-serif text-4xl sm:text-[2.65rem] font-bold leading-[1.08] text-[#132623] pt-1">
                                <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
                                <span class="block font-kaligrafi font-normal text-3xl text-[#C8A464] my-0.5">&amp;</span>
                                <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
                            </h1>
                            <p class="text-[11px] font-medium uppercase tracking-[0.24em] text-[#1F3431]/80 pt-1">
                                {{ $tanggalLengkap }}
                            </p>
                        </div>

                        <div class="flex items-center justify-center gap-3 px-6" aria-hidden="true">
                            <span class="h-px flex-1 bg-[#C8A464]/50"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-[#132623]"></span>
                            <span class="h-px flex-1 bg-[#C8A464]/50"></span>
                        </div>

                        <div class="space-y-2.5 pt-0.5">
                            <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
                            <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-[#8D6F3A]">
                                {{ $undangan->teksKustom('sampul_sapaan', 'Kepada Yth. Bapak/Ibu/Saudara/i') }}
                            </p>
                            <p class="font-serif text-xl sm:text-2xl font-bold text-[#132623] leading-snug">
                                {{ $namaTamu }}
                            </p>
                            <div class="pt-2">
                                <button
                                    type="button"
                                    @click="bukaUndangan()"
                                    class="garden-tombol-sage inline-flex items-center justify-center gap-2 rounded-full px-8 py-3 text-xs sm:text-sm font-bold uppercase tracking-[0.18em] transition cursor-pointer"
                                >
                                    <span>{{ $undangan->teksKustom('sampul_tombol', 'Buka Undangan') }}</span>
                                </button>
                            </div>
                            <p class="text-[10px] italic text-[#1F3431]/70 pt-1 max-w-xs mx-auto leading-relaxed">
                                {{ $undangan->teksKustom('sampul_catatan', 'Mohon maaf apabila ada kesalahan penulisan nama/gelar') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
