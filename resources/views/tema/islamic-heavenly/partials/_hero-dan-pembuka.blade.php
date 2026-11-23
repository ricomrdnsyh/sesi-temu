{{-- SEKSI 1: HERO DIORAMA GERBANG MIHRAB & LENTERA FANOUS --}}
<section
    data-diorama-3d="{{ $tierAktif }}"
    class="relative min-h-[96dvh] px-3.5 py-4 flex items-stretch overflow-hidden bg-[#091322]"
>
    <div class="relative w-full min-h-[calc(96dvh-2rem)] rounded-t-[10.5rem] rounded-b-3xl border-2 border-[#D9B664]/65 overflow-hidden shadow-2xl bg-[#0B1728]">
        <div class="relative w-full h-full flex flex-col justify-between diorama-kamera-3d">
            {{-- Z-0: Langit Berbintang --}}
            <div class="absolute inset-0 pointer-events-none">
                <img src="{{ $urlFotoLatar }}" alt="Islamic Heavenly" class="w-full h-full object-cover object-center">
                <div class="absolute inset-0 bg-gradient-to-b from-[#091322]/72 via-[#0E1B2A]/35 to-[#060D18]/92"></div>
            </div>

            {{-- Z-1: Gerbang Mihrab Emas-Safir Transparan --}}
            <div
                class="pointer-events-none absolute inset-x-1 top-2 bottom-2 flex items-center justify-center z-10"
                :class="undanganTerbuka ? 'celestial-mihrab-masuk' : 'opacity-0'"
            >
                <img src="{{ $asetCelestial['mihrab'] }}" alt="" class="w-full h-full object-contain opacity-95">
            </div>

            {{-- Z-2: Lentera Fanous Gantung Kiri & Kanan --}}
            <img src="{{ $asetCelestial['lentera'] }}" alt="" class="pointer-events-none absolute -top-2 left-1 w-20 sm:w-24 z-20 opacity-95 celestial-lentera-kiri">
            <img src="{{ $asetCelestial['lentera'] }}" alt="" class="pointer-events-none absolute -top-2 right-1 w-20 sm:w-24 z-20 opacity-95 celestial-lentera-kanan">

            {{-- Lapisan Bintang Berkedip & Bintang Jatuh --}}
            @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'bintang', 'konteks' => 'utama'])

            {{-- Z-3: Konten Tipografi Tengah Mihrab (Tepat di Dalam Lengkungan Gelap Mihrab) --}}
            <div class="relative z-20 flex-1 flex flex-col justify-between px-11 pt-6 pb-6 text-center text-[#E6EEF8]">
                <div class="space-y-1">
                    <p class="text-base text-[#F3E5AB]" style="font-family: 'Amiri', serif;">
                        بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                    </p>
                    <p class="text-[9px] font-semibold uppercase tracking-[0.22em] text-[#D9B664]">
                        Assalamu&rsquo;alaikum Warahmatullahi Wabarakatuh
                    </p>
                </div>

                <div class="my-auto pt-20 pb-2 space-y-2">
                    <p class="text-[10px] uppercase tracking-[0.28em] text-[#F3E5AB]/90">
                        We Are Getting Married!
                    </p>
                    <h2 class="font-serif text-4xl sm:text-[2.65rem] font-bold leading-[1.08] text-white">
                        {{ $undangan->nama_panggilan_pria }}
                        <span class="block font-kaligrafi text-3xl font-normal text-[#D9B664] my-0.5">&amp;</span>
                        {{ $undangan->nama_panggilan_wanita }}
                    </h2>
                    <p class="pt-1 text-xs font-semibold uppercase tracking-[0.3em] text-[#F3E5AB]">
                        {{ $tanggalTitik }}
                    </p>
                    <p class="text-[10px] tracking-[0.16em] text-[#D9B664]">
                        {{ $hashtagPasangan }}
                    </p>
                </div>

                {{-- Siluet Kubah Masjid Emas-Safir + Emblem Orbit --}}
                <div class="pt-5 space-y-3">
                    <div class="mx-auto w-14 h-14 relative flex items-center justify-center">
                        <span class="absolute inset-0 rounded-full border border-dashed border-[#D9B664]/70 animasi-orbit"></span>
                        <img src="{{ $asetCelestial['sabit'] }}" alt="" class="w-8 opacity-95 animasi-ayun-3d">
                    </div>
                    <svg aria-hidden="true" viewBox="0 0 360 56" class="w-full max-w-[280px] mx-auto opacity-85">
                        <path d="M0 54 H360 M36 54 V34 L42 20 L48 34 V54 M312 54 V34 L318 20 L324 34 V54 M96 54 C96 34 118 28 128 20 C138 28 160 34 160 54 M200 54 C200 34 222 28 232 20 C242 28 264 34 264 54 M134 54 C134 26 164 18 180 6 C196 18 226 26 226 54" fill="rgba(19,36,56,0.75)" stroke="#D9B664" stroke-width="1.3"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- SEKSI 2: SANCTUARY AYAT AL-QUR'AN & FOTO PEMBUKA MIHRAB --}}
<section
    data-section-pembuka="celestial"
    class="relative px-4 py-12 overflow-hidden bg-[#0E1B2A]"
>
    <div class="max-w-md mx-auto rounded-t-[10.5rem] rounded-b-3xl bg-[#132438] border border-[#D9B664]/50 px-6 pt-12 pb-8 text-center shadow-2xl space-y-6 efek-shimmer-kartu">
        {{-- Monogram Pasangan Bertemu --}}
        <div class="grid grid-cols-3 items-center max-w-[200px] mx-auto">
            <span data-gsap="kiri" class="fx-slide-left font-serif text-4xl sm:text-5xl font-bold text-[#F3E5AB]">
                {{ $undangan->inisialPria() }}
            </span>
            <span data-gsap="mekar" data-gsap-delay="0.07" class="font-kaligrafi text-3xl text-[#D9B664]">&amp;</span>
            <span data-gsap="kanan" class="fx-slide-right font-serif text-4xl sm:text-5xl font-bold text-[#F3E5AB]">
                {{ $undangan->inisialWanita() }}
            </span>
        </div>

        @if ($urlFotoPembuka)
            <div data-gsap="potret" class="mx-auto w-56 sm:w-64 p-1.5 rounded-t-[9rem] rounded-b-2xl border border-[#D9B664]/75 bg-[#091322] shadow-xl">
                <div class="overflow-hidden rounded-t-[8.5rem] rounded-b-xl aspect-[4/5]">
                    <img
                        src="{{ $urlFotoPembuka }}"
                        alt="Foto Pembuka {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                        class="w-full h-full object-cover object-top"
                    >
                </div>
            </div>
        @endif

        @if ($undangan->kutipan_ayat)
            <blockquote class="space-y-3 border-t border-[#D9B664]/30 pt-5">
                <p data-gsap="turun" class="text-base text-[#F3E5AB]" style="font-family: 'Amiri', serif;">
                    بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                </p>
                <p data-gsap="naik" data-gsap-delay="0.06" class="italic text-xs sm:text-sm text-[#E6EEF8]/90 leading-relaxed">
                    &ldquo;{{ $undangan->kutipan_ayat }}&rdquo;
                </p>
            </blockquote>
        @endif
    </div>
</section>
