{{-- SAMPUL PEMBUKA RUSTIC FLORAL (GULIR KE ATAS) --}}
<section
    data-transisi-sampul="fade-halus"
    class="tirai-fade-halus tirai-gulir-atas fixed inset-0 mx-auto h-dvh w-full lg:w-[460px] xl:w-[490px] z-40 {{ $tampilBarDemo ? 'pt-28 sm:pt-20 lg:pt-14' : '' }}"
    style="height: 100dvh;"
    :class="undanganTerbuka ? 'tirai-terbuka pointer-events-none' : ''"
>
    <div class="relative w-full h-full flex flex-col {{ $pakaiFotoSampul ? 'justify-between bg-[#1F2D25]' : 'justify-center items-center px-6 py-8 bg-[#FDFBF7]' }} overflow-hidden">
        <img
            src="{{ $pakaiFotoSampul ? $urlFotoSampul : $urlFotoLatar }}"
            alt="Sampul {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
            class="absolute inset-0 w-full h-full object-cover {{ $pakaiFotoSampul ? 'object-top scale-[1.02] animasi-nafas' : 'object-center scale-105 animasi-nafas' }}"
        >

        @if ($pakaiFotoSampul)
            {{-- Gradasi Sinematik Hangat-Zamrud (Jernih di Wajah, Lembut Menyatu di Atas & Bawah) --}}
            <div
                aria-hidden="true"
                class="pointer-events-none absolute inset-0"
                style="background: linear-gradient(180deg, rgba(25,38,31,0.72) 0%, rgba(25,38,31,0.28) 22%, rgba(25,38,31,0.02) 45%, rgba(25,38,31,0.18) 64%, rgba(22,34,28,0.82) 86%, rgba(18,28,23,0.96) 100%);"
            ></div>
            {{-- Bingkai Lengkung Tipis Fine-Art di Tepi Potret --}}
            <div aria-hidden="true" class="pointer-events-none absolute inset-3.5 rounded-t-[10rem] rounded-b-[1.75rem] border border-[#E5D5C0]/45 z-10"></div>
        @else
            {{-- Fade Kabut Krem Lembut di Tengah (Menyatu Halus dengan Lukisan Pergola Botani) --}}
            <div
                aria-hidden="true"
                class="pointer-events-none absolute inset-0"
                style="background: radial-gradient(ellipse 78% 60% at 50% 50%, rgba(253,251,247,0.94) 0%, rgba(253,251,247,0.8) 44%, rgba(253,251,247,0.34) 72%, rgba(253,251,247,0.06) 92%, transparent 100%);"
            ></div>
        @endif

        @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'kelopak', 'konteks' => 'sampul'])

        @if ($pakaiFotoSampul)
            {{-- Mode Foto: Tajuk Editorial Botani di Atas, Potret Mempelai Utuh di Tengah, Sapaan Melayang Halus di Bawah --}}
            <div class="relative z-20 px-8 pt-8 sm:pt-10 text-center text-white space-y-1.5">
                <svg aria-hidden="true" viewBox="0 0 64 20" class="w-14 h-4 mx-auto text-[#E5C99B] opacity-90" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round">
                    <path d="M32 14 C25 8, 17 6, 8 9 C15 13, 24 14, 32 14 Z" fill="currentColor" fill-opacity="0.25"/>
                    <path d="M32 14 C39 8, 47 6, 56 9 C49 13, 40 14, 32 14 Z" fill="currentColor" fill-opacity="0.25"/>
                    <circle cx="32" cy="12" r="2" fill="currentColor"/>
                </svg>
                <p class="text-[10px] font-semibold uppercase tracking-[0.38em] text-[#E5D5C0] drop-shadow">
                    {{ $undangan->teksKustom('sampul_judul', 'The Wedding Of') }}
                </p>
                <h1 class="font-serif text-4xl sm:text-[2.75rem] font-bold leading-tight text-white drop-shadow-[0_4px_16px_rgba(0,0,0,0.45)]">
                    {{ $undangan->nama_panggilan_pria }}
                    <span class="font-kaligrafi font-normal text-[#E5C99B] mx-1">&amp;</span>
                    {{ $undangan->nama_panggilan_wanita }}
                </h1>
                <div class="flex items-center justify-center gap-2.5 pt-0.5 text-[10px] font-medium uppercase tracking-[0.26em] text-[#FDFBF7]/90 drop-shadow">
                    <span>{{ $tanggalLengkap }}</span>
                </div>
            </div>

            <div class="flex-1"></div>

            <div class="relative z-20 px-7 pb-9 sm:pb-11 text-center text-[#FDFBF7] space-y-2.5">
                <div class="flex items-center justify-center gap-3 px-10 pb-0.5" aria-hidden="true">
                    <span class="h-px flex-1 bg-[#E5D5C0]/40"></span>
                    <span class="w-1.5 h-1.5 rotate-45 bg-[#E5C99B]"></span>
                    <span class="h-px flex-1 bg-[#E5D5C0]/40"></span>
                </div>

                <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
                <p class="text-[10px] font-semibold uppercase tracking-[0.26em] text-[#E5D5C0]/90">
                    {{ $undangan->teksKustom('sampul_sapaan', 'Kepada Yth. Bapak/Ibu/Saudara/i') }}
                </p>
                <p class="font-serif text-xl sm:text-2xl font-bold text-white drop-shadow-[0_2px_12px_rgba(0,0,0,0.55)]">
                    {{ $namaTamu }}
                </p>

                <div class="pt-2">
                    <button
                        type="button"
                        @click="bukaUndangan()"
                        class="inline-flex items-center justify-center gap-2 rounded-full bg-gradient-to-r from-[#FDFBF7] via-[#F7EFE2] to-[#EFE2CE] text-[#23322A] border border-[#E5C99B]/80 px-8 py-3 text-xs sm:text-sm font-bold uppercase tracking-[0.18em] shadow-[0_14px_30px_-8px_rgba(0,0,0,0.55)] hover:brightness-105 active:scale-95 transition cursor-pointer"
                    >
                        <svg class="w-4 h-4 text-[#4B6358]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect width="20" height="16" x="2" y="4" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                        <span>{{ $undangan->teksKustom('sampul_tombol', 'Buka Undangan') }}</span>
                    </button>
                </div>

                <p class="text-[10px] italic text-[#FDFBF7]/75 pt-1 max-w-xs mx-auto leading-relaxed">
                    {{ $undangan->teksKustom('sampul_catatan', 'Mohon maaf apabila ada kesalahan penulisan nama/gelar') }}
                </p>
            </div>
        @else
            {{-- Mode Tanpa Foto: Tipografi & Tombol Melayang Halus di Dalam Fade Cahaya Pergola --}}
            <div class="relative z-20 w-full max-w-[330px] px-4 py-6 text-center text-[#2B3732] space-y-5">
                <div class="space-y-2">
                    <span aria-hidden="true" class="block w-8 h-[1.5px] mx-auto bg-[#BFA15F]"></span>
                    <p class="text-[10px] font-bold uppercase tracking-[0.36em] text-[#4B6358]">
                        {{ $undangan->teksKustom('sampul_judul', 'The Wedding Of') }}
                    </p>
                    <h1 class="font-serif text-[2.65rem] sm:text-5xl font-bold leading-[1.06] text-[#26332D] pt-1">
                        <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
                        <span class="block font-kaligrafi font-normal text-3xl sm:text-4xl text-[#B86B4B] my-0.5">&amp;</span>
                        <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
                    </h1>
                    <p class="text-xs font-semibold tracking-[0.32em] text-[#4B6358] pt-1.5">
                        {{ $tanggalTitik }}
                    </p>
                    <p class="text-[10px] font-medium uppercase tracking-[0.22em] text-[#4B6358]/75">
                        {{ $tanggalLengkap }}
                    </p>
                </div>

                <div class="flex items-center justify-center gap-3 px-10" aria-hidden="true">
                    <span class="h-px flex-1 bg-[#BFA15F]/55"></span>
                    <span class="w-1.5 h-1.5 rotate-45 bg-[#B86B4B]"></span>
                    <span class="h-px flex-1 bg-[#BFA15F]/55"></span>
                </div>

                <div class="space-y-2.5">
                    <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
                    <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-[#B86B4B]">
                        {{ $undangan->teksKustom('sampul_sapaan', 'Kepada Yth. Bapak/Ibu/Saudara/i') }}
                    </p>
                    <p class="font-serif text-xl sm:text-2xl font-bold text-[#1F2937] leading-snug">
                        {{ $namaTamu }}
                    </p>
                    <div class="pt-2">
                        <button
                            type="button"
                            @click="bukaUndangan()"
                            class="rustic-tombol-sage inline-flex items-center justify-center gap-2 rounded-full px-8 py-3 text-xs sm:text-sm font-bold uppercase tracking-[0.18em] shadow-xl transition cursor-pointer"
                        >
                            <span>{{ $undangan->teksKustom('sampul_tombol', 'Buka Undangan') }}</span>
                        </button>
                    </div>
                    <p class="text-[10px] italic text-[#4B6358]/75 pt-1 max-w-xs mx-auto leading-relaxed">
                        {{ $undangan->teksKustom('sampul_catatan', 'Mohon maaf apabila ada kesalahan penulisan nama/gelar') }}
                    </p>
                </div>
            </div>
        @endif
    </div>
</section>
