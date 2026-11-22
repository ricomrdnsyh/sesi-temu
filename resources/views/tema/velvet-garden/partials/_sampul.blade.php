{{-- SAMPUL PEMBUKA VELVET GARDEN (FADE HALUS) --}}
<section
    data-transisi-sampul="fade-halus"
    class="tirai-fade-halus fixed inset-0 mx-auto h-dvh w-full lg:w-[460px] xl:w-[490px] z-40 {{ $tampilBarDemo ? 'pt-28 sm:pt-20 lg:pt-14' : '' }}"
    style="height: 100dvh;"
    :class="undanganTerbuka ? 'tirai-terbuka pointer-events-none' : ''"
>
    <div class="relative w-full h-full flex flex-col justify-between overflow-hidden bg-[#0E1E18]">
        <img
            src="{{ $pakaiFotoSampul ? $urlFotoSampul : $urlFotoLatar }}"
            alt="Sampul {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
            class="absolute inset-0 w-full h-full object-cover {{ $pakaiFotoSampul ? 'object-top' : 'object-center' }}"
        >
        <div class="absolute inset-0 {{ $pakaiFotoSampul ? 'bg-gradient-to-b from-[#0E1E18]/80 via-[#0E1E18]/22 to-[#0A1712]/92' : 'bg-gradient-to-b from-[#0E1E18]/74 via-[#132623]/32 to-[#0A1712]/90' }}"></div>

        @if (! $pakaiFotoSampul)
            <img src="{{ $asetGarden['konservatori'] }}" alt="" aria-hidden="true" class="pointer-events-none absolute inset-3 h-[calc(100%-1.5rem)] w-[calc(100%-1.5rem)] object-contain opacity-38">
        @endif

        @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'kelopak-kunang', 'konteks' => 'sampul'])

        {{-- Bagian Atas: Crest Botani & Nama Pasangan --}}
        <div class="relative z-20 px-6 pt-5 sm:pt-7 text-center text-white space-y-1.5">
            <img src="{{ $asetGarden['botani'] }}" alt="" class="w-14 mx-auto opacity-95 animasi-melayang">
            <p class="text-[10px] font-semibold uppercase tracking-[0.36em] text-[#EEDAD4]">
                Velvet Garden Motion
            </p>
            <h1 class="font-serif text-4xl sm:text-[2.75rem] font-bold leading-tight text-white">
                {{ $undangan->nama_panggilan_pria }}
                <span class="font-kaligrafi font-normal text-[#C8A464] mx-1">&amp;</span>
                {{ $undangan->nama_panggilan_wanita }}
            </h1>
            <p class="text-[11px] uppercase tracking-[0.24em] text-[#F4F8F6]/85">
                {{ $tanggalLengkap }}
            </p>
        </div>

        {{-- Bagian Bawah: Kartu Kaca Konservatori --}}
        <div class="relative z-20 px-6 pb-6 sm:pb-8">
            <div class="kartu-3d efek-shimmer-kartu rounded-3xl bg-[#FDFBF7]/94 border-2 border-[#C8A464]/70 px-5 py-5 text-center text-[#1F3431] shadow-2xl space-y-2.5">
                <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#8D6F3A]">
                    Tamu Kehormatan
                </p>
                <p class="font-serif text-xl sm:text-2xl font-bold text-[#132623]">
                    Kepada Yth. {{ $namaTamu }}
                </p>
                <p class="text-[11px] text-[#1F3431]/75">
                    Di bawah kanopi zamrud dan lentera senja, kami mengundang kehadiran Anda.
                </p>

                <div class="pt-1">
                    <button
                        type="button"
                        @click="bukaUndangan()"
                        class="garden-tombol-sage inline-flex items-center justify-center gap-2 rounded-full px-8 py-3 text-xs sm:text-sm font-bold uppercase tracking-[0.18em] transition cursor-pointer"
                    >
                        <span>Buka Undangan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
