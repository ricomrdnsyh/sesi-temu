{{-- SAMPUL PEMBUKA ROYAL IVORY (FADE HALUS + SEGEL LILIN) --}}
<section
    data-transisi-sampul="fade-halus"
    class="tirai-fade-halus fixed inset-0 h-dvh lg:left-auto lg:w-[460px] xl:w-[490px] z-40 {{ $tampilBarDemo ? 'pt-28 sm:pt-20 lg:pt-14' : '' }}"
    style="height: 100dvh;"
    :class="undanganTerbuka ? 'tirai-terbuka pointer-events-none' : ''"
>
    <div class="relative w-full h-full flex flex-col justify-between overflow-hidden bg-[#EFE7DA]">
        <img
            src="{{ $pakaiFotoSampul ? $urlFotoSampul : $urlFotoLatar }}"
            alt="Sampul {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
            class="absolute inset-0 w-full h-full object-cover {{ $pakaiFotoSampul ? 'object-top' : 'object-center' }}"
        >
        <div class="absolute inset-0 {{ $pakaiFotoSampul ? 'bg-gradient-to-b from-[#2D2118]/78 via-[#2D2118]/20 to-[#2D2118]/88' : 'bg-gradient-to-b from-[#FAF6EE]/82 via-[#FAF6EE]/35 to-[#3B2E25]/65' }}"></div>

        @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'katedral-cahaya', 'konteks' => 'sampul'])

        {{-- Bagian Atas --}}
        <div class="relative z-20 px-6 pt-5 sm:pt-7 text-center {{ $pakaiFotoSampul ? 'text-white' : 'text-[#3B2E25]' }} space-y-1.5">
            <img src="{{ $asetRoyal['katedral'] }}" alt="" class="w-12 mx-auto opacity-90 animasi-ayun-3d">
            <p class="text-[10px] font-bold uppercase tracking-[0.38em] {{ $pakaiFotoSampul ? 'text-[#E5C99B]' : 'text-[#7B603F]' }}">
                The Royal Wedding
            </p>
            <h1 class="font-serif text-4xl sm:text-[2.75rem] font-bold leading-tight">
                {{ $undangan->nama_panggilan_pria }}
                <span class="font-kaligrafi font-normal {{ $pakaiFotoSampul ? 'text-[#E5C99B]' : 'text-[#9E7B4F]' }} mx-1">&amp;</span>
                {{ $undangan->nama_panggilan_wanita }}
            </h1>
            <p class="text-[11px] uppercase tracking-[0.24em] opacity-85">
                {{ $tanggalLengkap }}
            </p>
        </div>

        {{-- Bagian Bawah: Kartu Surat Letterpress + Segel Lilin --}}
        <div class="relative z-20 px-6 pb-6 sm:pb-8">
            <div class="kartu-3d relative rounded-3xl bg-[#FBF8F3]/96 border-2 border-[#9E7B4F]/65 p-1.5 shadow-2xl">
                <div class="rounded-[1.2rem] border border-dashed border-[#9E7B4F]/45 px-5 py-5 text-center text-[#3B2E25] space-y-2.5">
                    <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#7B603F]">
                        Dengan Hormat Mengundang
                    </p>
                    <p class="font-serif text-xl sm:text-2xl font-bold text-[#3B2E25]">
                        Kepada Yth. {{ $namaTamu }}
                    </p>
                    <p class="text-[11px] text-[#3B2E25]/70">
                        Kehadiran dan doa restu Anda adalah kehormatan terbesar bagi kedua keluarga.
                    </p>
                    <div class="pt-1.5">
                        <button
                            type="button"
                            @click="bukaUndangan()"
                            class="royal-tombol animasi-segel inline-flex items-center justify-center gap-2 rounded-full px-8 py-3 text-xs sm:text-sm font-bold uppercase tracking-[0.18em] transition cursor-pointer"
                        >
                            <span>Buka Undangan</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
