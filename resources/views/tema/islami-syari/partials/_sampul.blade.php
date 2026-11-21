{{-- SAMPUL PEMBUKA ISLAMI SYAR'I (FADE HALUS) --}}
<section
    data-transisi-sampul="fade-halus"
    class="tirai-fade-halus fixed inset-0 h-dvh lg:left-auto lg:w-[460px] xl:w-[490px] z-40 {{ $tampilBarDemo ? 'pt-28 sm:pt-20 lg:pt-14' : '' }}"
    style="height: 100dvh;"
    :class="undanganTerbuka ? 'tirai-terbuka pointer-events-none' : ''"
>
    <div class="relative w-full h-full flex flex-col justify-between overflow-hidden bg-[#F4FAF6]">
        <img
            src="{{ $pakaiFotoSampul ? $urlFotoSampul : $urlFotoLatar }}"
            alt="Sampul {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
            class="absolute inset-0 w-full h-full object-cover {{ $pakaiFotoSampul ? 'object-top' : 'object-center' }}"
        >
        <div class="absolute inset-0 {{ $pakaiFotoSampul ? 'bg-gradient-to-b from-[#0F342F]/80 via-[#0F342F]/22 to-[#0F342F]/90' : 'bg-gradient-to-b from-[#F4FAF6]/85 via-[#F4FAF6]/40 to-[#184D47]/55' }}"></div>

        @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'zaitun-kilau', 'konteks' => 'sampul'])

        <div class="relative z-20 px-6 pt-5 sm:pt-7 text-center {{ $pakaiFotoSampul ? 'text-white' : 'text-[#184D47]' }} space-y-1.5">
            <img src="{{ $asetSyari['arabesque'] }}" alt="" class="w-12 mx-auto opacity-90 animasi-ayun-3d">
            <p class="text-base sm:text-lg {{ $pakaiFotoSampul ? 'text-[#F3E5AB]' : 'text-[#184D47]' }}" style="font-family: 'Amiri', serif;">
                بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
            </p>
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] {{ $pakaiFotoSampul ? 'text-[#E6D19C]' : 'text-[#9E7D40]' }}">
                Walimatul Ursy
            </p>
            <h1 class="font-serif text-4xl sm:text-[2.75rem] font-bold leading-tight">
                {{ $undangan->nama_panggilan_pria }}
                <span class="font-kaligrafi font-normal {{ $pakaiFotoSampul ? 'text-[#E6D19C]' : 'text-[#BFA15F]' }} mx-1">&amp;</span>
                {{ $undangan->nama_panggilan_wanita }}
            </h1>
            <p class="text-[11px] uppercase tracking-[0.24em] opacity-85">{{ $tanggalLengkap }}</p>
        </div>

        <div class="relative z-20 px-6 pb-6 sm:pb-8">
            <div class="kartu-3d rounded-t-[3.5rem] rounded-b-3xl bg-white/95 border border-[#184D47]/25 px-5 py-6 text-center text-[#184D47] shadow-2xl space-y-2.5">
                <p class="text-[10px] font-bold uppercase tracking-[0.28em] text-[#9E7D40]">
                    Kepada Yth. Saudara/i
                </p>
                <p class="font-serif text-xl sm:text-2xl font-bold text-[#184D47]">
                    Kepada Yth. {{ $namaTamu }}
                </p>
                <p class="text-[11px] text-[#184D47]/75">
                    Dengan memohon rahmat dan ridho Allah SWT, kami mengundang kehadiran Anda.
                </p>
                <div class="pt-1">
                    <button
                        type="button"
                        @click="bukaUndangan()"
                        class="syari-tombol inline-flex items-center justify-center gap-2 rounded-full px-8 py-3 text-xs sm:text-sm font-bold uppercase tracking-[0.18em] transition cursor-pointer"
                    >
                        <span>Buka Undangan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
