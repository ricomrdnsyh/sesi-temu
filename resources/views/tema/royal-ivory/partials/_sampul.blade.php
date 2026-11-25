{{-- SELENDANG CAHAYA MUTIARA-SAMPANYE PENYINGKAP TIRAI GADING (SAAT BUKA UNDANGAN) --}}
<div aria-hidden="true" data-selendang-transisi="ivory" :class="undanganTerbuka ? 'royal-selendang-aktif' : 'opacity-0'"
    class="pointer-events-none fixed inset-0 mx-auto h-dvh w-full lg:w-[460px] xl:w-[490px] z-[45] overflow-hidden">
    <div class="w-full h-full"
        style="background: linear-gradient(180deg, transparent 0%, rgba(229,201,155,0.14) 30%, rgba(251,248,243,0.72) 48%, rgba(255,252,245,0.92) 51%, rgba(229,201,155,0.38) 56%, rgba(158,123,79,0.22) 68%, transparent 100%);">
    </div>
</div>

{{-- SAMPUL PEMBUKA ROYAL IVORY (TIRAI SUTRA GADING MELENGKUNG + SEGEL LILIN) --}}
<section data-transisi-sampul="fade-halus"
    class="tirai-fade-halus tirai-gulir-atas fixed inset-0 mx-auto h-dvh w-full lg:w-[460px] xl:w-[490px] z-40 {{ $tampilBarDemo ? 'pt-28 sm:pt-20 lg:pt-14' : '' }}"
    style="height: 100dvh;" :class="undanganTerbuka ? 'tirai-terbuka pointer-events-none' : ''">
    <div
        class="relative w-full h-full flex flex-col {{ $pakaiFotoSampul ? 'justify-between bg-[#2D2118]' : 'justify-center items-center px-6 py-8 bg-[#FBF8F3]' }} overflow-hidden">
        <img src="{{ $pakaiFotoSampul ? $urlFotoSampul : $urlFotoLatar }}"
            alt="Sampul {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
            class="absolute inset-0 w-full h-full object-cover {{ $pakaiFotoSampul ? 'object-top scale-[1.02] animasi-nafas' : 'object-center scale-105 animasi-nafas' }}">

        @if ($pakaiFotoSampul)
            <div aria-hidden="true" class="pointer-events-none absolute inset-0"
                style="background: linear-gradient(180deg, rgba(45,33,24,0.75) 0%, rgba(45,33,24,0.28) 24%, rgba(45,33,24,0.02) 48%, rgba(45,33,24,0.22) 66%, rgba(45,33,24,0.84) 86%, rgba(32,23,16,0.96) 100%);">
            </div>
            <div aria-hidden="true"
                class="pointer-events-none absolute inset-3.5 rounded-t-[10rem] rounded-b-[1.75rem] border border-[#E5C99B]/45 z-10">
            </div>
        @else
            {{-- Fade Kabut Gading Hangat di Tengah Lengkungan Katedral --}}
            <div aria-hidden="true" class="pointer-events-none absolute inset-0"
                style="background: radial-gradient(ellipse 78% 60% at 50% 50%, rgba(251,248,243,0.94) 0%, rgba(251,248,243,0.8) 44%, rgba(251,248,243,0.34) 72%, rgba(251,248,243,0.05) 92%, transparent 100%);">
            </div>
        @endif

        @include('komponen-undangan.lapisan-motion', [
            'efekMotion' => 'katedral-cahaya',
            'konteks' => 'sampul',
        ])

        @if ($pakaiFotoSampul)
            <div class="royal-isi-sampul relative z-20 px-8 pt-7 sm:pt-9 text-center text-white space-y-1.5">
                <img src="{{ $asetRoyal['katedral'] }}" alt="" class="w-11 mx-auto opacity-95 animasi-ayun-3d">
                <p class="text-[10px] font-bold uppercase tracking-[0.38em] text-[#E5C99B] drop-shadow">
                    {{ $undangan->teksKustom('sampul_judul', 'The Royal Wedding') }}
                </p>
                <h1
                    class="font-serif text-4xl sm:text-[2.75rem] font-bold leading-tight drop-shadow-[0_4px_16px_rgba(0,0,0,0.45)]">
                    {{ $undangan->nama_panggilan_pria }}
                    <span class="font-kaligrafi font-normal text-[#E5C99B] mx-1">&amp;</span>
                    {{ $undangan->nama_panggilan_wanita }}
                </h1>
                <p class="text-[10px] uppercase tracking-[0.26em] text-[#FAF6EE]/90 drop-shadow">
                    {{ $tanggalLengkap }}
                </p>
            </div>

            <div class="flex-1"></div>

            <div class="royal-isi-sampul relative z-20 px-7 pb-9 sm:pb-11 text-center text-[#FAF6EE] space-y-2.5">
                <div class="flex items-center justify-center gap-3 px-10 pb-0.5" aria-hidden="true">
                    <span class="h-px flex-1 bg-[#E5C99B]/40"></span>
                    <span class="w-1.5 h-1.5 rotate-45 bg-[#E5C99B]"></span>
                    <span class="h-px flex-1 bg-[#E5C99B]/40"></span>
                </div>
                <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
                <p class="text-[10px] font-semibold uppercase tracking-[0.26em] text-[#E5C99B]">
                    {{ $undangan->teksKustom('sampul_sapaan', 'Kepada Yth. Bapak/Ibu/Saudara/i') }}
                </p>
                <p
                    class="font-serif text-xl sm:text-2xl font-bold text-white drop-shadow-[0_2px_12px_rgba(0,0,0,0.55)]">
                    {{ $namaTamu }}
                </p>
                <div class="pt-2">
                    <button type="button" @click="bukaUndangan()"
                        class="animasi-segel inline-flex items-center justify-center gap-2 rounded-full bg-gradient-to-r from-[#FAF6EE] via-[#F3E5CE] to-[#E5C99B] text-[#3B2E25] border border-[#E5C99B] px-8 py-3 text-xs sm:text-sm font-bold uppercase tracking-[0.18em] shadow-[0_14px_30px_-8px_rgba(0,0,0,0.55)] hover:brightness-105 active:scale-95 transition cursor-pointer">
                        <svg class="w-4 h-4 text-[#7B603F]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect width="20" height="16" x="2" y="4" rx="2" />
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                        </svg>
                        <span>{{ $undangan->teksKustom('sampul_tombol', 'Buka Undangan') }}</span>
                    </button>
                </div>
                <p class="text-[10px] italic text-[#FAF6EE]/75 pt-1 max-w-xs mx-auto leading-relaxed">
                    {{ $undangan->teksKustom('sampul_catatan', 'Mohon maaf apabila ada kesalahan penulisan nama/gelar') }}
                </p>
            </div>
        @else
            {{-- Mode Tanpa Foto: Tipografi & Tombol Melayang Halus di Dalam Fade Lengkungan Katedral --}}
            <div
                class="royal-isi-sampul relative z-20 w-full max-w-[330px] px-4 py-6 text-center text-[#3B2E25] space-y-5">
                <div class="space-y-1.5">
                    <img src="{{ $asetRoyal['katedral'] }}" alt=""
                        class="w-11 mx-auto opacity-95 animasi-ayun-3d">
                    <p class="text-[10px] font-bold uppercase tracking-[0.38em] text-[#7B603F]">
                        {{ $undangan->teksKustom('sampul_judul', 'The Royal Wedding') }}
                    </p>
                    <h1 class="font-serif text-[2.65rem] sm:text-5xl font-bold leading-[1.06] text-[#3B2E25] pt-1">
                        <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
                        <span
                            class="block font-kaligrafi font-normal text-3xl sm:text-4xl text-[#9E7B4F] my-0.5">&amp;</span>
                        <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
                    </h1>
                    <p class="text-xs font-semibold tracking-[0.32em] text-[#7B603F] pt-1.5">
                        {{ $tanggalTitik }}
                    </p>
                    <p class="text-[10px] font-medium uppercase tracking-[0.22em] text-[#3B2E25]/75">
                        {{ $tanggalLengkap }}
                    </p>
                </div>

                <div class="flex items-center justify-center gap-3 px-10" aria-hidden="true">
                    <span class="h-px flex-1 bg-[#9E7B4F]/50"></span>
                    <span class="w-1.5 h-1.5 rotate-45 bg-[#9E7B4F]"></span>
                    <span class="h-px flex-1 bg-[#9E7B4F]/50"></span>
                </div>

                <div class="space-y-2.5">
                    <span class="sr-only">Kepada Yth. {{ $namaTamu }}</span>
                    <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-[#7B603F]">
                        {{ $undangan->teksKustom('sampul_sapaan', 'Kepada Yth. Bapak/Ibu/Saudara/i') }}
                    </p>
                    <p class="font-serif text-xl sm:text-2xl font-bold text-[#3B2E25] leading-snug">
                        {{ $namaTamu }}
                    </p>
                    <div class="pt-2">
                        <button type="button" @click="bukaUndangan()"
                            class="royal-tombol animasi-segel inline-flex items-center justify-center gap-2 rounded-full px-8 py-3 text-xs sm:text-sm font-bold uppercase tracking-[0.18em] shadow-xl transition cursor-pointer">
                            <span>{{ $undangan->teksKustom('sampul_tombol', 'Buka Undangan') }}</span>
                        </button>
                    </div>
                    <p class="text-[10px] italic text-[#3B2E25]/70 pt-1 max-w-xs mx-auto leading-relaxed">
                        {{ $undangan->teksKustom('sampul_catatan', 'Mohon maaf apabila ada kesalahan penulisan nama/gelar') }}
                    </p>
                </div>
            </div>
        @endif
    </div>
</section>
