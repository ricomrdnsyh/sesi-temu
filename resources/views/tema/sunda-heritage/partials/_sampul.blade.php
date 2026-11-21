{{-- SAMPUL PEMBUKA SUNDA SIGER HERITAGE (FADE HALUS TANPA BUKA BUKU) --}}
<section
    data-transisi-sampul="fade-halus"
    class="tirai-fade-halus fixed inset-0 h-dvh lg:left-auto lg:w-[460px] xl:w-[490px] z-40 {{ $tampilBarDemo ? 'pt-28 sm:pt-20 lg:pt-14' : '' }}"
    style="height: 100dvh;"
    :class="undanganTerbuka ? 'tirai-terbuka pointer-events-none' : ''"
>
    <div class="relative w-full h-full flex flex-col justify-between overflow-hidden bg-[#3B1414]">
        {{-- Latar Foto Sampul atau Ilustrasi Priangan --}}
        <img
            src="{{ $pakaiFotoSampul ? $urlFotoSampul : $urlFotoLatar }}"
            alt="Sampul {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
            class="absolute inset-0 w-full h-full object-cover {{ $pakaiFotoSampul ? 'object-top' : 'object-center' }}"
        >
        <div class="absolute inset-0 {{ $pakaiFotoSampul ? 'bg-gradient-to-b from-[#3B1414]/82 via-[#3B1414]/22 to-[#2B0E0E]/92' : 'bg-gradient-to-b from-[#3B1414]/75 via-[#4A1717]/30 to-[#2B0E0E]/90' }}"></div>

        {{-- Hiasan Gapura Halus di Sampul (Saat Tanpa Foto) --}}
        @if (! $pakaiFotoSampul)
            <img
                src="{{ $asetSunda['gapura'] }}"
                alt=""
                aria-hidden="true"
                class="pointer-events-none absolute inset-x-3 top-6 bottom-6 h-[calc(100%-3rem)] w-[calc(100%-1.5rem)] object-contain opacity-30"
            >
        @endif

        @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'melati-burung', 'konteks' => 'sampul'])

        {{-- Bagian Atas: Siger & Judul Pasangan --}}
        <div class="relative z-20 px-6 pt-5 sm:pt-7 text-center text-white space-y-1.5">
            <img
                src="{{ $asetSunda['siger'] }}"
                alt=""
                class="w-14 mx-auto opacity-95 animasi-ayun-3d"
            >
            <p class="text-[10px] font-semibold uppercase tracking-[0.35em] text-[#F3E5AB]">
                Sampurasun &bull; Walimatul Ursy
            </p>
            <h1 class="font-serif text-4xl sm:text-[2.75rem] font-bold leading-tight text-white">
                {{ $undangan->nama_panggilan_pria }}
                <span class="font-kaligrafi font-normal text-[#E7C87D] mx-1">&amp;</span>
                {{ $undangan->nama_panggilan_wanita }}
            </h1>
            <p class="text-[11px] uppercase tracking-[0.24em] text-[#FAF4E8]/90">
                {{ $tanggalLengkap }}
            </p>
        </div>

        {{-- Bagian Bawah: Kartu Tamu & Tombol Buka Undangan --}}
        <div class="relative z-20 px-6 pb-6 sm:pb-8">
            <div class="kartu-3d rounded-3xl bg-[#FFFBF4]/92 border-2 border-[#C59B43]/75 px-5 py-5 text-center text-[#4A2020] shadow-2xl space-y-2.5">
                <p class="text-[10px] font-bold uppercase tracking-[0.28em] text-[#8E6620]">
                    Kahatur Bapa/Ibu/Saderek
                </p>
                <p class="font-serif text-xl sm:text-2xl font-bold text-[#5A1E1E]">
                    Kepada Yth. {{ $namaTamu }}
                </p>
                <p class="text-[11px] text-[#4A2020]/75">
                    Hatur nuhun kana kasumpingan sareng pidoana dina dinten bagja sim kuring.
                </p>

                <div class="pt-1">
                    <button
                        type="button"
                        @click="bukaUndangan()"
                        class="sunda-tombol-marun inline-flex items-center justify-center gap-2 rounded-full px-8 py-3 text-xs sm:text-sm font-bold uppercase tracking-[0.18em] transition cursor-pointer"
                    >
                        <span>Buka Undangan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
