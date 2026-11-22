{{-- SEKSI 1: SAMPUL FULL-BLEED BERSIH DENGAN TRANSISI FADE HALUS (TANPA BUKA BUKU) --}}
<section
    data-transisi-sampul="fade-halus"
    class="tirai-fade-halus fixed inset-0 mx-auto h-dvh w-full lg:w-[460px] xl:w-[490px] z-40 {{ $tampilBarDemo ? 'pt-28 sm:pt-20 lg:pt-14' : '' }}"
    style="height: 100dvh;"
    :class="undanganTerbuka ? 'tirai-terbuka pointer-events-none' : ''"
>
    <div class="relative w-full h-full flex flex-col justify-between overflow-hidden bg-[#472A1C]">
        {{-- Foto Sampul Penuh atau Diorama Ilustrasi (Mode Tanpa Foto) --}}
        <img
            src="{{ $pakaiFotoSampul ? $urlFotoSampul : $asetJawa['latarHutan'] }}"
            alt="{{ $pakaiFotoSampul ? "Foto Sampul {$undangan->nama_panggilan_pria} & {$undangan->nama_panggilan_wanita}" : 'Sampul Adat Jawa Keraton' }}"
            class="absolute inset-0 w-full h-full object-cover {{ $pakaiFotoSampul ? 'object-top' : 'object-center' }}"
        >

        {{-- Gradasi Sogan Khas Java Heritage (Terang di Tengah Wajah, Pekat di Bawah) --}}
        <div
            aria-hidden="true"
            class="absolute inset-0"
            style="background: linear-gradient(180deg, rgba(20,11,6,0.58) 0%, rgba(20,11,6,0.16) 36%, rgba(71,42,28,0.58) 72%, #472A1C 100%);"
        ></div>

        @if (! $pakaiFotoSampul)
            <img src="{{ $asetJawa['pendopo'] }}" alt="" aria-hidden="true" class="pointer-events-none absolute bottom-32 left-1/2 -translate-x-1/2 w-[82%] opacity-90 drop-shadow-xl">
            <img src="{{ $asetJawa['bungaDepan'] }}" alt="" aria-hidden="true" class="pointer-events-none absolute bottom-0 inset-x-0 w-full opacity-40">
        @endif

        {{-- Blok Atas: Tajuk Mempelai --}}
        <div class="relative z-20 px-6 {{ $tampilBarDemo ? 'pt-5 sm:pt-8' : 'pt-12 sm:pt-14' }} text-center space-y-1 text-white">
            <p class="font-kaligrafi text-3xl sm:text-[2rem] leading-tight text-white/95 drop-shadow">
                The Wedding of
            </p>
            <h1 class="font-serif text-3xl sm:text-4xl font-semibold tracking-wide text-white drop-shadow-md">
                {{ $undangan->nama_panggilan_pria }}
                <span class="text-[#D7BB83] font-normal mx-0.5">&amp;</span>
                {{ $undangan->nama_panggilan_wanita }}
            </h1>
            <p class="text-[11px] font-medium uppercase tracking-[0.26em] text-white/85 pt-0.5 drop-shadow">
                {{ $tanggalLengkap }}
            </p>
        </div>

        {{-- Ruang Tengah Lega Menampilkan Foto Mempelai Tanpa Tertutup Kotak --}}
        <div class="flex-1 flex items-center justify-center relative z-10">
            @if (! $pakaiFotoSampul)
                <img
                    src="{{ $asetJawa['gununganKecil'] }}"
                    alt=""
                    class="w-24 opacity-95 drop-shadow-[0_14px_24px_rgba(0,0,0,0.5)] animasi-ayun-3d"
                >
            @endif
        </div>

        {{-- Blok Bawah Bersih Tanpa Kotak Kartu Kaca --}}
        <div class="relative z-20 px-6 pb-8 sm:pb-10 text-center text-white space-y-2">
            <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
            <p class="text-[11px] font-medium tracking-[0.2em] text-white/85">Kepada Yth:</p>
            <p class="font-serif text-xl sm:text-2xl font-bold text-[#F3E5AB] drop-shadow">
                {{ $namaTamu }}
            </p>

            <div class="pt-2">
                <button
                    type="button"
                    @click="bukaUndangan()"
                    class="jawa-tombol-emas inline-flex items-center justify-center gap-2 rounded-full px-8 py-2.5 text-xs sm:text-sm font-medium tracking-[0.14em] transition active:scale-95 cursor-pointer"
                >
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect width="20" height="16" x="2" y="4" rx="2"/>
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                    </svg>
                    <span>Buka Undangan</span>
                </button>
            </div>

            <p class="text-[10px] italic text-white/75 pt-1 max-w-xs mx-auto leading-relaxed">
                *Mohon maaf jika ada kesalahan dalam penulisan nama / gelar.
            </p>
        </div>
    </div>
</section>
