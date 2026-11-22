{{-- SAMPUL PEMBUKA LUXURY NOIR (FADE HALUS) --}}
<section
    data-transisi-sampul="fade-halus"
    class="tirai-fade-halus fixed inset-0 mx-auto h-dvh w-full lg:w-[460px] xl:w-[490px] z-40 {{ $tampilBarDemo ? 'pt-28 sm:pt-20 lg:pt-14' : '' }}"
    style="height: 100dvh;"
    :class="undanganTerbuka ? 'tirai-terbuka pointer-events-none' : ''"
>
    <div class="relative w-full h-full flex flex-col justify-between overflow-hidden bg-[#09090D]">
        <img
            src="{{ $pakaiFotoSampul ? $urlFotoSampul : $urlFotoLatar }}"
            alt="Sampul {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
            class="absolute inset-0 w-full h-full object-cover {{ $pakaiFotoSampul ? 'object-top' : 'object-center' }}"
        >
        <div class="absolute inset-0 {{ $pakaiFotoSampul ? 'bg-gradient-to-b from-black/84 via-black/25 to-black/92' : 'bg-gradient-to-b from-black/80 via-black/35 to-black/92' }}"></div>

        @if (! $pakaiFotoSampul)
            <img src="{{ $asetNoir['bingkai'] }}" alt="" aria-hidden="true" class="pointer-events-none absolute inset-4 h-[calc(100%-2rem)] w-[calc(100%-2rem)] object-contain opacity-38">
        @endif

        @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'debu-emas', 'konteks' => 'sampul'])

        {{-- Bagian Atas: Monogram Orbit & Judul Black-Tie --}}
        <div class="relative z-20 px-6 pt-5 sm:pt-7 text-center text-[#F5EFE6] space-y-2">
            @if (! $pakaiFotoSampul)
                <div class="mx-auto w-16 h-16 relative flex items-center justify-center">
                    <span class="absolute inset-0 rounded-full border border-dashed border-[#D4AF37]/65 animasi-orbit"></span>
                    <span class="noir-font-judul text-xs font-bold tracking-widest text-[#F3E5AB]">{{ $undangan->inisialPria() }}&amp;{{ $undangan->inisialWanita() }}</span>
                </div>
            @endif
            <p class="text-[10px] font-semibold uppercase tracking-[0.4em] text-[#D4AF37]">
                The Grand Celebration
            </p>
            <h1 class="noir-font-judul text-3xl sm:text-[2.6rem] font-bold tracking-wider leading-tight text-white">
                {{ $undangan->nama_panggilan_pria }}
                <span class="font-kaligrafi font-normal text-[#D4AF37] mx-1">&amp;</span>
                {{ $undangan->nama_panggilan_wanita }}
            </h1>
            <p class="text-[11px] uppercase tracking-[0.26em] text-[#F5EFE6]/85">
                {{ $tanggalLengkap }}
            </p>
        </div>

        {{-- Bagian Bawah: Plakat Undangan Art Deco --}}
        <div class="relative z-20 px-6 pb-6 sm:pb-8">
            <div class="relative kartu-3d efek-shimmer-kartu rounded-xl bg-[#111016]/92 border border-[#D4AF37]/65 px-5 py-6 text-center text-[#F5EFE6] shadow-2xl space-y-2.5">
                <span aria-hidden="true" class="pointer-events-none absolute -top-1 -left-1 h-4 w-4 border-t-2 border-l-2 border-[#D4AF37]"></span>
                <span aria-hidden="true" class="pointer-events-none absolute -top-1 -right-1 h-4 w-4 border-t-2 border-r-2 border-[#D4AF37]"></span>
                <span aria-hidden="true" class="pointer-events-none absolute -bottom-1 -left-1 h-4 w-4 border-b-2 border-l-2 border-[#D4AF37]"></span>
                <span aria-hidden="true" class="pointer-events-none absolute -bottom-1 -right-1 h-4 w-4 border-b-2 border-r-2 border-[#D4AF37]"></span>

                <p class="text-[10px] font-semibold uppercase tracking-[0.32em] text-[#D4AF37]">
                    Exclusive Invitation For
                </p>
                <p class="noir-font-judul text-lg sm:text-xl font-bold tracking-wide text-[#F3E5AB]">
                    Kepada Yth. {{ $namaTamu }}
                </p>
                <p class="text-[11px] text-[#F5EFE6]/70">
                    Your presence is warmly requested at our black-tie celebration.
                </p>

                <div class="pt-1.5">
                    <button
                        type="button"
                        @click="bukaUndangan()"
                        class="noir-tombol-emas animasi-segel inline-flex items-center justify-center gap-2 rounded-full px-8 py-3 text-xs sm:text-sm font-bold uppercase tracking-[0.2em] transition cursor-pointer"
                    >
                        <span>Buka Undangan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
