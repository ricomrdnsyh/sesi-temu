{{-- SAMPUL PEMBUKA ISLAMIC HEAVENLY (FADE HALUS) --}}
<section
    data-transisi-sampul="fade-halus"
    class="tirai-fade-halus fixed inset-0 h-dvh lg:left-auto lg:w-[460px] xl:w-[490px] z-40 {{ $tampilBarDemo ? 'pt-28 sm:pt-20 lg:pt-14' : '' }}"
    style="height: 100dvh;"
    :class="undanganTerbuka ? 'tirai-terbuka pointer-events-none' : ''"
>
    <div class="relative w-full h-full flex flex-col justify-between overflow-hidden bg-[#091322]">
        <img
            src="{{ $pakaiFotoSampul ? $urlFotoSampul : $urlFotoLatar }}"
            alt="Sampul {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
            class="absolute inset-0 w-full h-full object-cover {{ $pakaiFotoSampul ? 'object-top' : 'object-center' }}"
        >
        <div class="absolute inset-0 {{ $pakaiFotoSampul ? 'bg-gradient-to-b from-[#091322]/82 via-[#091322]/25 to-[#060D18]/92' : 'bg-gradient-to-b from-[#091322]/78 via-[#0E1B2A]/35 to-[#060D18]/92' }}"></div>

        @if (! $pakaiFotoSampul)
            <img src="{{ $asetCelestial['lentera'] }}" alt="" aria-hidden="true" class="pointer-events-none absolute -top-2 left-2 w-20 opacity-85 celestial-lentera-kiri">
            <img src="{{ $asetCelestial['lentera'] }}" alt="" aria-hidden="true" class="pointer-events-none absolute -top-2 right-2 w-20 opacity-85 celestial-lentera-kanan">
        @endif

        @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'bintang', 'konteks' => 'sampul'])

        {{-- Bagian Atas: Bismillah & Nama Pasangan --}}
        <div class="relative z-20 px-6 pt-5 sm:pt-7 text-center text-white space-y-1.5">
            <p class="text-base sm:text-lg text-[#F3E5AB]" style="font-family: 'Amiri', serif;">
                بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
            </p>
            <p class="text-[10px] font-semibold uppercase tracking-[0.34em] text-[#D9B664]">
                Walimatul Ursy &bull; Celestial Night
            </p>
            <h1 class="font-serif text-4xl sm:text-[2.75rem] font-bold leading-tight text-white">
                {{ $undangan->nama_panggilan_pria }}
                <span class="font-kaligrafi font-normal text-[#D9B664] mx-1">&amp;</span>
                {{ $undangan->nama_panggilan_wanita }}
            </h1>
            <p class="text-[11px] uppercase tracking-[0.24em] text-[#E6EEF8]/85">
                {{ $tanggalLengkap }}
            </p>
        </div>

        {{-- Bagian Bawah: Kartu Tamu Safir-Emas --}}
        <div class="relative z-20 px-6 pb-6 sm:pb-8">
            <div class="kartu-3d efek-shimmer-kartu rounded-t-[4rem] rounded-b-3xl bg-[#112238]/92 border border-[#D9B664]/65 px-5 py-6 text-center text-[#E6EEF8] shadow-2xl space-y-2.5">
                <p class="text-[10px] font-semibold uppercase tracking-[0.28em] text-[#D9B664]">
                    Kepada Yth. Saudara/i
                </p>
                <p class="font-serif text-xl sm:text-2xl font-bold text-[#F3E5AB]">
                    Kepada Yth. {{ $namaTamu }}
                </p>
                <p class="text-[11px] text-[#E6EEF8]/75">
                    Dengan memohon rahmat dan ridho Allah SWT, kami mengundang Anda menghadiri walimatul ursy kami.
                </p>

                <div class="pt-1.5">
                    <button
                        type="button"
                        @click="bukaUndangan()"
                        class="celestial-tombol-emas inline-flex items-center justify-center gap-2 rounded-full px-8 py-3 text-xs sm:text-sm font-bold uppercase tracking-[0.18em] transition cursor-pointer"
                    >
                        <span>Buka Undangan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
