{{-- SAMPUL PEMBUKA RUSTIC FLORAL (FADE HALUS) --}}
<section
    data-transisi-sampul="fade-halus"
    class="tirai-fade-halus fixed inset-0 h-dvh lg:left-auto lg:w-[460px] xl:w-[490px] z-40 {{ $tampilBarDemo ? 'pt-28 sm:pt-20 lg:pt-14' : '' }}"
    style="height: 100dvh;"
    :class="undanganTerbuka ? 'tirai-terbuka pointer-events-none' : ''"
>
    <div class="relative w-full h-full flex flex-col justify-between overflow-hidden bg-[#F4ECE1]">
        <img
            src="{{ $pakaiFotoSampul ? $urlFotoSampul : $urlFotoLatar }}"
            alt="Sampul {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
            class="absolute inset-0 w-full h-full object-cover {{ $pakaiFotoSampul ? 'object-top' : 'object-center' }}"
        >
        <div class="absolute inset-0 {{ $pakaiFotoSampul ? 'bg-gradient-to-b from-[#24322B]/80 via-[#24322B]/20 to-[#24322B]/88' : 'bg-gradient-to-b from-[#FDFBF7]/84 via-[#FDFBF7]/35 to-[#394D44]/65' }}"></div>

        @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'kelopak', 'konteks' => 'sampul'])

        <div class="relative z-20 px-6 pt-5 sm:pt-7 text-center {{ $pakaiFotoSampul ? 'text-white' : 'text-[#1F2937]' }} space-y-1.5">
            <img src="{{ $asetRustic['sudut'] }}" alt="" class="w-12 mx-auto opacity-90 animasi-melayang">
            <p class="text-[10px] font-bold uppercase tracking-[0.36em] {{ $pakaiFotoSampul ? 'text-[#E5D5C0]' : 'text-[#4B6358]' }}">
                The Wedding Of
            </p>
            <h1 class="font-serif text-4xl sm:text-[2.75rem] font-bold leading-tight">
                {{ $undangan->nama_panggilan_pria }}
                <span class="font-kaligrafi font-normal {{ $pakaiFotoSampul ? 'text-[#E5C99B]' : 'text-[#B86B4B]' }} mx-1">&amp;</span>
                {{ $undangan->nama_panggilan_wanita }}
            </h1>
            <p class="text-[11px] uppercase tracking-[0.24em] opacity-85">{{ $tanggalLengkap }}</p>
        </div>

        <div class="relative z-20 px-6 pb-6 sm:pb-8">
            <div class="kartu-3d relative rounded-3xl bg-[#FDFBF7]/95 border border-[#BFA15F]/50 px-5 py-6 text-center text-[#1F2937] shadow-2xl space-y-2.5">
                <span aria-hidden="true" class="pointer-events-none absolute -top-2.5 left-1/2 -translate-x-1/2 w-20 h-5 bg-[#E5D5C0]/85 border border-[#BFA15F]/40 -rotate-1"></span>
                <p class="text-[10px] font-bold uppercase tracking-[0.28em] text-[#B86B4B]">
                    Kepada Yth. Bapak/Ibu/Saudara/i
                </p>
                <p class="font-serif text-xl sm:text-2xl font-bold text-[#1F2937]">
                    Kepada Yth. {{ $namaTamu }}
                </p>
                <p class="text-[11px] text-[#1F2937]/70">
                    Tanpa mengurangi rasa hormat, kami mengundang Anda menghadiri hari bahagia kami.
                </p>
                <div class="pt-1">
                    <button
                        type="button"
                        @click="bukaUndangan()"
                        class="rustic-tombol-sage inline-flex items-center justify-center gap-2 rounded-full px-8 py-3 text-xs sm:text-sm font-bold uppercase tracking-[0.18em] transition cursor-pointer"
                    >
                        <span>Buka Undangan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
