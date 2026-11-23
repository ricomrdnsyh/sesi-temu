{{-- SEKSI 3: PROFIL MEMPELAI — EDITORIAL POTRET MELT ASIMETRIS CELESTIAL NIGHT --}}
<section
    data-layout-mempelai="celestial"
    class="relative bg-gradient-to-b from-[#0A1526] via-[#091322] to-[#08101E] celestial-pola-bintang px-5 py-14 overflow-hidden"
>
    <div class="relative z-10 max-w-md mx-auto space-y-8">
        {{-- Tajuk Seksi Minimalis Astral --}}
        <div class="text-center space-y-2.5 px-2">
            <div data-gsap="turun" class="inline-flex items-center justify-center gap-2.5">
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-r from-transparent to-[#D9B664]/70"></span>
                <svg aria-hidden="true" viewBox="0 0 20 20" class="w-4 h-4 text-[#F3E5AB]" fill="currentColor">
                    <path d="M10 1l2.1 6.9L19 10l-6.9 2.1L10 19l-2.1-6.9L1 10l6.9-2.1L10 1z" />
                </svg>
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-l from-transparent to-[#D9B664]/70"></span>
            </div>
            <p data-gsap="mekar" class="text-[9.5px] font-bold uppercase tracking-[0.36em] text-[#D9B664]">
                Bismillahirrahmanirrahim
            </p>
            <h2 data-gsap="naik" class="font-serif text-[2rem] sm:text-[2.2rem] font-semibold leading-tight text-white">
                Mempelai Pengantin
            </h2>
            <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-[13px] text-[#E6EEF8]/76 max-w-xs mx-auto leading-relaxed">
                Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud menyelenggarakan akad nikah &amp; walimatul ursy putra-putri kami:
            </p>
        </div>

        {{-- KARTU MEMPELAI PRIA (POTRET FULL-BLEED MELT + TIPOGRAFI EDITORIAL RATA KIRI) --}}
        <article class="group relative rounded-[1.75rem] bg-[#0C192C] border border-[#D9B664]/42 shadow-[0_26px_54px_-18px_rgba(0,0,0,0.85)] overflow-hidden kartu-3d">
            @if (! $tanpaFoto && $undangan->urlFotoPria())
                <div data-gsap="potret" class="relative aspect-[4/4.35] w-full overflow-hidden bg-[#081220]">
                    <img
                        src="{{ $undangan->urlFotoPria() }}"
                        alt="{{ $undangan->nama_lengkap_pria }}"
                        loading="lazy"
                        decoding="async"
                        class="w-full h-full object-cover object-top scale-[1.01] group-hover:scale-[1.05] transition duration-700"
                    >
                    <div
                        aria-hidden="true"
                        class="pointer-events-none absolute inset-0"
                        style="background: linear-gradient(180deg, rgba(8,18,32,0.28) 0%, rgba(8,18,32,0) 32%, rgba(12,25,44,0.62) 76%, #0C192C 100%);"
                    ></div>
                    <span class="absolute top-3.5 left-3.5 inline-flex items-center gap-1.5 rounded-full bg-[#091322]/75 backdrop-blur-md border border-[#D9B664]/45 px-3 py-1 text-[9px] font-semibold uppercase tracking-[0.24em] text-[#F3E5AB]">
                        <span class="h-1 w-1 rounded-full bg-[#D9B664]"></span>
                        Al-&lsquo;Aris &middot; Mempelai Pria
                    </span>
                </div>
            @else
                <div data-gsap="potret" class="relative px-6 pt-8 pb-4 flex items-center justify-between border-b border-[#D9B664]/20 bg-gradient-to-r from-[#11233D] to-[#0C192C]">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-[#091322]/75 border border-[#D9B664]/45 px-3 py-1 text-[9px] font-semibold uppercase tracking-[0.24em] text-[#F3E5AB]">
                        Al-&lsquo;Aris &middot; Mempelai Pria
                    </span>
                    <div class="relative h-14 w-14 flex items-center justify-center">
                        <span aria-hidden="true" class="absolute inset-0 rounded-full border border-dashed border-[#D9B664]/60 animasi-orbit"></span>
                        <span class="font-serif text-2xl font-bold text-[#F3E5AB]">{{ $undangan->inisialPria() }}</span>
                    </div>
                </div>
            @endif

            <div class="relative px-6 {{ (! $tanpaFoto && $undangan->urlFotoPria()) ? '-mt-4 pt-0' : 'pt-5' }} pb-7 text-left space-y-2.5">
                <div class="flex items-end justify-between gap-3">
                    <h3 data-gsap="kiri" class="font-kaligrafi text-[2.9rem] sm:text-[3.2rem] leading-[1.02] text-[#F3E5AB]">
                        {{ $undangan->nama_panggilan_pria }}
                    </h3>
                    <span aria-hidden="true" class="mb-2 h-px flex-1 bg-gradient-to-r from-[#D9B664]/50 to-transparent"></span>
                </div>

                <p data-gsap="teks" data-gsap-delay="0.06" class="font-serif text-[1.05rem] sm:text-lg font-semibold tracking-wide text-white">
                    {{ $undangan->nama_lengkap_pria }}
                </p>

                @if ($undangan->nama_ayah_pria || $undangan->nama_ibu_pria)
                    <div class="pt-1 border-l-2 border-[#D9B664]/55 pl-3.5 space-y-0.5">
                        <p data-gsap="teks" class="text-[9.5px] font-semibold uppercase tracking-[0.26em] text-[#D9B664]">
                            Putra dari
                        </p>
                        <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-[13px] text-[#E6EEF8]/82 leading-relaxed">
                            {{ $undangan->nama_ayah_pria }} &amp; {{ $undangan->nama_ibu_pria }}
                        </p>
                    </div>
                @endif

                @if ($instagramPria !== '')
                    <div data-gsap="mekar" data-gsap-delay="0.08" class="pt-2">
                        <a
                            href="https://instagram.com/{{ $instagramPria }}"
                            target="_blank"
                            rel="noopener"
                            class="celestial-tombol-safir inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-[11px] font-medium tracking-wide transition active:scale-95"
                        >
                            <svg class="w-3.5 h-3.5 text-[#F3E5AB]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                            </svg>
                            <span>&#64;{{ $instagramPria }}</span>
                        </a>
                    </div>
                @endif
            </div>
        </article>

        {{-- PEMISAH GARIS ORBIT CELESTIAL MINIMALIS --}}
        <div class="flex items-center justify-center gap-4 px-6" aria-hidden="true">
            <span data-gsap="garis" class="h-px flex-1 bg-gradient-to-r from-transparent via-[#D9B664]/50 to-[#D9B664]/80"></span>
            <span data-gsap="mekar" class="font-kaligrafi text-4xl text-[#E5C474] leading-none">&amp;</span>
            <span data-gsap="garis" class="h-px flex-1 bg-gradient-to-l from-transparent via-[#D9B664]/50 to-[#D9B664]/80"></span>
        </div>

        {{-- KARTU MEMPELAI WANITA (POTRET FULL-BLEED MELT + TIPOGRAFI EDITORIAL RATA KANAN) --}}
        <article class="group relative rounded-[1.75rem] bg-[#0C192C] border border-[#D9B664]/42 shadow-[0_26px_54px_-18px_rgba(0,0,0,0.85)] overflow-hidden kartu-3d">
            @if (! $tanpaFoto && $undangan->urlFotoWanita())
                <div data-gsap="potret" class="relative aspect-[4/4.35] w-full overflow-hidden bg-[#081220]">
                    <img
                        src="{{ $undangan->urlFotoWanita() }}"
                        alt="{{ $undangan->nama_lengkap_wanita }}"
                        loading="lazy"
                        decoding="async"
                        class="w-full h-full object-cover object-top scale-[1.01] group-hover:scale-[1.05] transition duration-700"
                    >
                    <div
                        aria-hidden="true"
                        class="pointer-events-none absolute inset-0"
                        style="background: linear-gradient(180deg, rgba(8,18,32,0.28) 0%, rgba(8,18,32,0) 32%, rgba(12,25,44,0.62) 76%, #0C192C 100%);"
                    ></div>
                    <span class="absolute top-3.5 right-3.5 inline-flex items-center gap-1.5 rounded-full bg-[#091322]/75 backdrop-blur-md border border-[#D9B664]/45 px-3 py-1 text-[9px] font-semibold uppercase tracking-[0.24em] text-[#F3E5AB]">
                        Al-&lsquo;Arus &middot; Mempelai Wanita
                        <span class="h-1 w-1 rounded-full bg-[#D9B664]"></span>
                    </span>
                </div>
            @else
                <div data-gsap="potret" class="relative px-6 pt-8 pb-4 flex items-center justify-between border-b border-[#D9B664]/20 bg-gradient-to-l from-[#11233D] to-[#0C192C]">
                    <div class="relative h-14 w-14 flex items-center justify-center">
                        <span aria-hidden="true" class="absolute inset-0 rounded-full border border-dashed border-[#D9B664]/60 animasi-orbit"></span>
                        <span class="font-serif text-2xl font-bold text-[#F3E5AB]">{{ $undangan->inisialWanita() }}</span>
                    </div>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-[#091322]/75 border border-[#D9B664]/45 px-3 py-1 text-[9px] font-semibold uppercase tracking-[0.24em] text-[#F3E5AB]">
                        Al-&lsquo;Arus &middot; Mempelai Wanita
                    </span>
                </div>
            @endif

            <div class="relative px-6 {{ (! $tanpaFoto && $undangan->urlFotoWanita()) ? '-mt-4 pt-0' : 'pt-5' }} pb-7 text-right space-y-2.5">
                <div class="flex items-end justify-between gap-3">
                    <span aria-hidden="true" class="mb-2 h-px flex-1 bg-gradient-to-l from-[#D9B664]/50 to-transparent"></span>
                    <h3 data-gsap="kanan" class="font-kaligrafi text-[2.9rem] sm:text-[3.2rem] leading-[1.02] text-[#F3E5AB]">
                        {{ $undangan->nama_panggilan_wanita }}
                    </h3>
                </div>

                <p data-gsap="teks" data-gsap-delay="0.06" class="font-serif text-[1.05rem] sm:text-lg font-semibold tracking-wide text-white">
                    {{ $undangan->nama_lengkap_wanita }}
                </p>

                @if ($undangan->nama_ayah_wanita || $undangan->nama_ibu_wanita)
                    <div class="pt-1 border-r-2 border-[#D9B664]/55 pr-3.5 space-y-0.5">
                        <p data-gsap="teks" class="text-[9.5px] font-semibold uppercase tracking-[0.26em] text-[#D9B664]">
                            Putri dari
                        </p>
                        <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-[13px] text-[#E6EEF8]/82 leading-relaxed">
                            {{ $undangan->nama_ayah_wanita }} &amp; {{ $undangan->nama_ibu_wanita }}
                        </p>
                    </div>
                @endif

                @if ($instagramWanita !== '')
                    <div data-gsap="mekar" data-gsap-delay="0.08" class="pt-2">
                        <a
                            href="https://instagram.com/{{ $instagramWanita }}"
                            target="_blank"
                            rel="noopener"
                            class="celestial-tombol-safir inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-[11px] font-medium tracking-wide transition active:scale-95"
                        >
                            <svg class="w-3.5 h-3.5 text-[#F3E5AB]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                            </svg>
                            <span>&#64;{{ $instagramWanita }}</span>
                        </a>
                    </div>
                @endif
            </div>
        </article>
    </div>
</section>

{{-- SEKSI 4A: SLIDESHOW SINEMATIK TRANSISI KE KRONOGRAF HITUNG MUNDUR --}}
@if ($fotoGaleriSlideshow->isNotEmpty())
<div
    data-slideshow-heavenly
    data-gsap="potret"
    x-data="{
        slideAktif: 0,
        jumlah: {{ $fotoGaleriSlideshow->count() }},
        init() {
            if (this.jumlah > 1) {
                setInterval(() => {
                    this.slideAktif = (this.slideAktif + 1) % this.jumlah;
                }, 4200);
            }
        }
    }"
    class="relative h-64 sm:h-72 w-full overflow-hidden bg-[#060E1B]"
>
    @foreach ($fotoGaleriSlideshow as $idxSlide => $urlSlide)
        <img
            src="{{ $urlSlide }}"
            alt="Momen Bahagia {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
            loading="lazy"
            decoding="async"
            class="absolute inset-0 w-full h-full object-cover object-top transition-opacity duration-1000"
            :class="slideAktif === {{ $idxSlide }} ? 'opacity-90 scale-105' : 'opacity-0 scale-100'"
            style="transition: opacity 1.1s ease, transform 5s ease;"
        >
    @endforeach
    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-0"
        style="background: linear-gradient(180deg, rgba(8,16,30,0.82) 0%, rgba(8,16,30,0.12) 34%, rgba(8,16,30,0.28) 68%, #07101E 100%);"
    ></div>
</div>
@endif

{{-- SEKSI 4B: HITUNG MUNDUR — KRONOGRAF KACA MALAM TERPADU (BERBEDA DARI UBIN KUBAH SYAR'I) --}}
@if ($undangan->fiturAktif('hitung_mundur') && $isoTarget)
<section
    data-layout-countdown="celestial"
    x-data="{
        targetMs: new Date(@js($isoTarget)).getTime(),
        hari: '00', jam: '00', menit: '00', detik: '00',
        perbarui() {
            const selisih = Math.max(0, this.targetMs - Date.now());
            this.hari = String(Math.floor(selisih / 86400000)).padStart(2, '0');
            this.jam = String(Math.floor((selisih % 86400000) / 3600000)).padStart(2, '0');
            this.menit = String(Math.floor((selisih % 3600000) / 60000)).padStart(2, '0');
            this.detik = String(Math.floor((selisih % 60000) / 1000)).padStart(2, '0');
        },
        init() { this.perbarui(); setInterval(() => this.perbarui(), 1000); }
    }"
    class="relative bg-gradient-to-b from-[#07101E] via-[#091322] to-[#0B1728] shadow-[0_-2px_0_0_#07101E] px-5 py-14 text-center border-b border-[#D9B664]/28 overflow-hidden"
>
    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-0"
        style="background: radial-gradient(ellipse 70% 50% at 50% 42%, rgba(217,182,100,0.12) 0%, transparent 70%);"
    ></div>

    <div class="relative z-10 max-w-md mx-auto space-y-6">
        <div data-gsap="naik" class="space-y-1.5">
            <p class="text-[9.5px] font-bold uppercase tracking-[0.38em] text-[#D9B664]">Menuju Hari Bahagia</p>
            <h2 class="font-kaligrafi text-5xl text-white leading-tight">Save The Date</h2>
            <p class="text-[10.5px] font-medium uppercase tracking-[0.26em] text-[#F3E5AB]/80 pt-0.5">
                {{ $tanggalLengkap }}
            </p>
        </div>

        {{-- Bar Kronograf Kaca Safir 4-Kolom Bersekat Garis Emas Tipis --}}
        <div data-gsap="mekar" class="relative rounded-2xl bg-gradient-to-b from-[#13253E]/88 to-[#0B1729]/95 border border-[#D9B664]/45 px-2 py-5 shadow-[0_20px_44px_-16px_rgba(0,0,0,0.85)] overflow-hidden">
            <span aria-hidden="true" class="pointer-events-none absolute inset-x-8 top-0 h-px bg-gradient-to-r from-transparent via-[#F3E5AB]/70 to-transparent"></span>

            <div class="grid grid-cols-4 divide-x divide-[#D9B664]/25">
                @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                    <div class="px-1.5 py-1">
                        <div
                            class="font-serif text-[1.75rem] sm:text-[2.05rem] font-semibold leading-none text-[#F3E5AB] tabular-nums"
                            x-text="{{ $var }}"
                            x-effect="if ({{ $var }}) { $el.classList.remove('angka-flip-3d'); void $el.offsetWidth; $el.classList.add('angka-flip-3d'); }"
                        >00</div>
                        <div class="mt-2 text-[8.5px] uppercase tracking-[0.24em] font-semibold text-[#E6EEF8]/65">{{ $label }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <p data-gsap="teks" class="text-xs text-[#E6EEF8]/76 max-w-xs mx-auto leading-relaxed">
            Merupakan kehormatan dan keberkahan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu.
        </p>

        @if ($googleCalUrl)
            <div data-gsap="mekar" data-gsap-delay="0.08">
                <a
                    href="{{ $googleCalUrl }}"
                    target="_blank"
                    rel="noopener"
                    class="celestial-tombol-emas inline-flex items-center gap-2 rounded-full px-7 py-2.5 text-xs font-semibold uppercase tracking-[0.16em] transition active:scale-95"
                >
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect width="18" height="18" x="3" y="4" rx="2"/>
                        <path d="M16 2v4M8 2v4M3 10h18"/>
                    </svg>
                    <span>Simpan ke Kalender</span>
                </a>
            </div>
        @endif
    </div>
</section>
@endif

{{-- SEKSI 5: JADWAL AKAD & WALIMAH — ROYAL CELESTIAL INVITATION PASS (GAYA TIKET EDITORIAL ARSITEKTURAL) --}}
@if ($undangan->daftarAcara->isNotEmpty())
<section
    data-layout-acara="celestial"
    class="relative bg-gradient-to-b from-[#0B1728] via-[#091322] to-[#08101E] celestial-pola-bintang px-5 py-14 overflow-hidden"
>
    <div class="relative z-10 max-w-md mx-auto space-y-7">
        <div class="text-center space-y-2">
            <div data-gsap="mekar" class="flex items-center justify-center gap-2.5">
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-r from-transparent to-[#D9B664]/70"></span>
                <p class="text-[9.5px] font-bold uppercase tracking-[0.36em] text-[#D9B664]">InsyaAllah Dilaksanakan Pada</p>
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-l from-transparent to-[#D9B664]/70"></span>
            </div>
            <h2 data-gsap="naik" class="font-serif text-[2rem] sm:text-[2.15rem] font-semibold leading-tight text-white">
                Jadwal Akad &amp; Walimah
            </h2>
        </div>

        <div class="space-y-5">
            @foreach ($undangan->daftarAcara as $acara)
                @php
                    $nomorAcara = str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT);
                @endphp
                <article class="relative rounded-2xl bg-gradient-to-br from-[#13253E] via-[#0E1C31] to-[#091322] border border-[#D9B664]/45 shadow-[0_24px_50px_-18px_rgba(0,0,0,0.85)] overflow-hidden kartu-3d">
                    {{-- Garis Aksen Atas Emas Tipis --}}
                    <span aria-hidden="true" class="pointer-events-none absolute inset-x-0 top-0 h-[2px] bg-gradient-to-r from-transparent via-[#E5C474]/80 to-transparent"></span>

                    {{-- Bagian Atas Tiket: Tajuk Prosesi Kiri + Blok Tanggal Besar Kanan --}}
                    <div class="px-5 sm:px-6 pt-6 pb-5 flex items-center justify-between gap-4">
                        <div class="text-left space-y-1 min-w-0">
                            <span data-gsap="turun" class="inline-flex items-center gap-1.5 text-[9px] font-bold uppercase tracking-[0.3em] text-[#D9B664]">
                                <span class="h-1.5 w-1.5 rotate-45 bg-[#F3E5AB]"></span>
                                Prosesi {{ $nomorAcara }}
                            </span>
                            <h3 data-gsap="kiri" class="font-serif text-[1.45rem] sm:text-[1.65rem] font-semibold leading-snug text-white">
                                {{ $acara->nama_acara }}
                            </h3>
                            <p data-gsap="teks" class="text-[11px] font-medium text-[#E6EEF8]/72">
                                {{ $acara->tanggal_acara->locale('id')->translatedFormat('l, d F Y') }}
                            </p>
                        </div>

                        <div data-gsap="mekar" class="shrink-0 w-[4.6rem] rounded-xl bg-[#081220]/90 border border-[#D9B664]/50 px-2 py-2.5 text-center shadow-inner">
                            <span class="block text-[8.5px] font-bold uppercase tracking-[0.2em] text-[#D9B664]">
                                {{ $acara->tanggal_acara->locale('id')->translatedFormat('M') }}
                            </span>
                            <span class="block font-serif text-[1.95rem] font-bold leading-none text-[#F3E5AB] my-0.5 tabular-nums">
                                {{ $acara->tanggal_acara->format('d') }}
                            </span>
                            <span class="block text-[8.5px] font-semibold tracking-[0.16em] text-[#E6EEF8]/70">
                                {{ $acara->tanggal_acara->format('Y') }}
                            </span>
                        </div>
                    </div>

                    {{-- Garis Perforasi Tiket Bintang Dengan Coakan Samping --}}
                    <div class="relative flex items-center" aria-hidden="true">
                        <span class=" -ml-2.5 h-5 w-5 rounded-full bg-[#091322] border-r border-[#D9B664]/45 shrink-0"></span>
                        <span class="mx-2 h-px flex-1 border-t border-dashed border-[#D9B664]/38"></span>
                        <span class="text-[9px] text-[#E5C474]/80">&#10022;</span>
                        <span class="mx-2 h-px flex-1 border-t border-dashed border-[#D9B664]/38"></span>
                        <span class="-mr-2.5 h-5 w-5 rounded-full bg-[#091322] border-l border-[#D9B664]/45 shrink-0"></span>
                    </div>

                    {{-- Bagian Bawah Tiket: Rincian Waktu & Lokasi Rata Kiri + Tombol Maps --}}
                    <div class="px-5 sm:px-6 pt-4 pb-6 text-left space-y-4">
                        <div data-gsap="naik" class="flex items-start gap-3">
                            <span class="mt-0.5 inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#D9B664]/12 border border-[#D9B664]/35 text-[#F3E5AB]">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path d="M12 7v5l3 2"/>
                                </svg>
                            </span>
                            <div class="space-y-0.5">
                                <p class="text-[9px] font-bold uppercase tracking-[0.26em] text-[#D9B664]">Waktu Pelaksanaan</p>
                                <p class="font-serif text-sm sm:text-[15px] font-semibold text-white">
                                    {{ \Illuminate\Support\Str::substr($acara->waktu_mulai, 0, 5) }}
                                    @if ($acara->waktu_selesai)
                                        &ndash; {{ \Illuminate\Support\Str::substr($acara->waktu_selesai, 0, 5) }}
                                    @else
                                        &ndash; Selesai
                                    @endif
                                    <span class="ml-1 text-[11px] font-sans font-semibold text-[#F3E5AB]">{{ $acara->zona_waktu }}</span>
                                </p>
                            </div>
                        </div>

                        <div data-gsap="naik" data-gsap-delay="0.06" class="flex items-start gap-3">
                            <span class="mt-0.5 inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#D9B664]/12 border border-[#D9B664]/35 text-[#F3E5AB]">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M12 21s-6-5.3-6-10a6 6 0 1 1 12 0c0 4.7-6 10-6 10Z"/>
                                    <circle cx="12" cy="11" r="2.2"/>
                                </svg>
                            </span>
                            <div class="space-y-0.5">
                                <p class="text-[9px] font-bold uppercase tracking-[0.26em] text-[#D9B664]">Lokasi Acara</p>
                                <p class="font-serif text-sm sm:text-[15px] font-semibold text-white leading-snug">
                                    {{ $acara->nama_tempat }}
                                </p>
                                <p class="text-xs text-[#E6EEF8]/72 leading-relaxed">
                                    {{ $acara->alamat_lengkap }}
                                </p>
                            </div>
                        </div>

                        @if ($acara->link_maps)
                            <div data-gsap="mekar" data-gsap-delay="0.08" class="pt-1">
                                <a
                                    href="{{ $acara->link_maps }}"
                                    target="_blank"
                                    rel="noopener"
                                    class="celestial-tombol-emas w-full inline-flex items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-[11px] font-bold uppercase tracking-[0.16em] transition active:scale-[0.98]"
                                >
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7Zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/>
                                    </svg>
                                    <span>Petunjuk Lokasi Maps</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- SEKSI 6: ADAB & NUANSA BUSANA (SWATCH PALETTE) + LIVE STREAMING (BANNER HORIZONTAL) --}}
@if ($adaDressCode || (! empty($live['aktif']) && ! empty($live['link'])))
<section class="relative bg-[#08101E] px-5 py-10 space-y-5 overflow-hidden">
    @if ($adaDressCode)
        <div data-section-dress-code="celestial" class="max-w-md mx-auto rounded-2xl bg-[#0D1B2E]/90 border border-[#D9B664]/35 p-5 sm:p-6 text-left space-y-4 shadow-xl kartu-3d">
            <div class="flex items-center justify-between gap-3">
                <div class="space-y-0.5">
                    <p data-gsap="turun" class="text-[9px] font-bold uppercase tracking-[0.32em] text-[#D9B664]">Panduan Kehadiran</p>
                    <h3 data-gsap="kiri" class="font-serif text-lg font-semibold text-white">Adab &amp; Nuansa Busana</h3>
                </div>
                <span aria-hidden="true" class="text-sm text-[#D9B664]/75">&#10022;</span>
            </div>

            @if ($dressCodeCatatan !== '')
                <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-[13px] text-[#E6EEF8]/80 leading-relaxed">{{ $dressCodeCatatan }}</p>
            @endif

            @if (! empty($dressCodeWarna))
                <div class="grid grid-cols-4 gap-2 pt-1">
                    @foreach ($dressCodeWarna as $hex)
                        <div data-gsap="mekar" data-gsap-delay="{{ number_format($loop->index * 0.06, 2, '.', '') }}" class="rounded-xl bg-[#081220]/85 border border-[#D9B664]/25 p-1.5 text-center space-y-1.5">
                            <span class="block h-7 w-full rounded-lg border border-white/20 shadow-inner" style="background-color: {{ $hex }};"></span>
                            <span class="block text-[8.5px] font-mono text-[#F3E5AB]/80">{{ $hex }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    @if (! empty($live['aktif']) && ! empty($live['link']))
        <div class="max-w-md mx-auto rounded-2xl bg-gradient-to-r from-[#132642] via-[#0F1F36] to-[#0B1628] border border-[#D9B664]/45 p-5 sm:p-6 shadow-xl kartu-3d">
            <div class="flex flex-col gap-4 text-left">
                <div class="flex items-start justify-between gap-3">
                    <div class="space-y-1">
                        <span data-gsap="turun" class="inline-flex items-center gap-1.5 text-[9px] font-bold uppercase tracking-[0.28em] text-[#F3E5AB]">
                            <span class="h-1.5 w-1.5 rounded-full bg-amber-300 animate-pulse"></span>
                            Siaran Walimah
                        </span>
                        <h3 data-gsap="naik" class="font-serif text-xl font-semibold text-white">Live Streaming</h3>
                    </div>
                    <span aria-hidden="true" class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#D9B664]/15 border border-[#D9B664]/35 text-[#F3E5AB]">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="6 4 20 12 6 20 6 4"/>
                        </svg>
                    </span>
                </div>

                <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-[13px] text-[#E6EEF8]/78 leading-relaxed">
                    Saksikan prosesi ijab qabul secara virtual melalui {{ $live['platform'] ?? 'YouTube Live' }}.
                </p>

                <div data-gsap="mekar" data-gsap-delay="0.08">
                    <a
                        href="{{ $live['link'] }}"
                        target="_blank"
                        rel="noopener"
                        class="celestial-tombol-safir inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-[11px] font-semibold uppercase tracking-[0.16em] transition active:scale-95"
                    >
                        <span>Saksikan Siaran Langsung</span>
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    @endif
</section>
@endif

{{-- SEKSI 7: LINIMASA KONSTELASI BINTANG — PERJALANAN TA'ARUF (LEFT-RAIL TIMELINE EDITORIAL) --}}
@if ($undangan->fiturAktif('cerita_cinta') && ! empty($ceritaList))
<section
    data-layout-cerita="celestial"
    class="relative bg-gradient-to-b from-[#08101E] via-[#0B172A] to-[#08101E] celestial-pola-bintang px-5 py-14 overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-9 overflow-hidden py-1 space-y-1.5">
        <div data-gsap="kiri">
            <p class="scroll-scrub-kiri text-[9.5px] font-bold uppercase tracking-[0.36em] text-[#D9B664]">Perjalanan Ta&rsquo;aruf</p>
        </div>
        <div data-gsap="kanan" data-gsap-delay="0.06">
            <h2 class="scroll-scrub-kanan font-serif text-[2rem] sm:text-[2.15rem] font-semibold text-white">Kisah Pertemuan</h2>
        </div>
        <div data-gsap="garis" class="flex items-center justify-center gap-2.5 pt-1" aria-hidden="true">
            <span class="h-px w-10 bg-gradient-to-r from-transparent to-[#D9B664]/70"></span>
            <span class="text-[9px] text-[#F3E5AB]">&#10022;</span>
            <span class="h-px w-10 bg-gradient-to-l from-transparent to-[#D9B664]/70"></span>
        </div>
    </div>

    <div class="relative z-10 max-w-md mx-auto pl-8 space-y-6">
        {{-- Garis Vertikal Konstelasi Di Sisi Kiri --}}
        <span
            aria-hidden="true"
            class="pointer-events-none absolute left-[11px] top-3 bottom-3 w-px bg-gradient-to-b from-[#D9B664]/15 via-[#D9B664]/65 to-[#D9B664]/15"
        ></span>

        @foreach ($ceritaList as $idx => $cerita)
            @php
                $urlFotoBab = (! $tanpaFoto && ! empty($cerita['foto']))
                    ? \App\Support\MediaPublik::url((string) $cerita['foto'])
                    : null;
                $nomorBab = str_pad((string) ($idx + 1), 2, '0', STR_PAD_LEFT);
            @endphp

            <article class="relative">
                {{-- Simpul Bintang Bernomor Pada Rel Kiri --}}
                <div
                    data-gsap="mekar"
                    aria-hidden="true"
                    class="absolute -left-8 top-4 flex h-6 w-6 items-center justify-center rounded-full bg-[#091322] border border-[#D9B664]/80 text-[9px] font-bold text-[#F3E5AB] shadow-[0_0_16px_rgba(217,182,100,0.45)]"
                >
                    {{ $nomorBab }}
                </div>

                <div class="rounded-2xl bg-[#0E1C31]/92 border border-[#D9B664]/35 overflow-hidden shadow-[0_20px_44px_-18px_rgba(0,0,0,0.82)] kartu-3d">
                    @if ($urlFotoBab)
                        <div data-gsap="potret" class="relative aspect-[16/10] w-full overflow-hidden bg-[#081220]">
                            <img
                                src="{{ $urlFotoBab }}"
                                alt="{{ $cerita['judul'] ?? 'Kisah Pertemuan' }}"
                                loading="lazy"
                                decoding="async"
                                class="w-full h-full object-cover object-top"
                            >
                            <div
                                aria-hidden="true"
                                class="pointer-events-none absolute inset-0"
                                style="background: linear-gradient(180deg, transparent 40%, rgba(14,28,49,0.92) 100%);"
                            ></div>
                            @if (! empty($cerita['tanggal']))
                                <span class="absolute bottom-3 left-4 inline-flex items-center gap-1.5 rounded-full bg-[#091322]/82 backdrop-blur-md border border-[#D9B664]/45 px-3 py-0.5 text-[9.5px] font-semibold tracking-wider text-[#F3E5AB]">
                                    {{ $cerita['tanggal'] }}
                                </span>
                            @endif
                        </div>
                    @endif

                    <div class="px-5 {{ $urlFotoBab ? 'pt-3.5 pb-5' : 'py-5' }} text-left space-y-2">
                        @if (! $urlFotoBab && ! empty($cerita['tanggal']))
                            <p data-gsap="turun" class="text-[9.5px] font-bold uppercase tracking-[0.26em] text-[#D9B664]">
                                {{ $cerita['tanggal'] }}
                            </p>
                        @endif

                        <h3 data-gsap="kiri" class="font-serif text-lg sm:text-[1.25rem] font-semibold text-[#F3E5AB] leading-snug">
                            {{ $cerita['judul'] ?? '' }}
                        </h3>

                        <span data-gsap="garis" aria-hidden="true" class="block h-px w-10 bg-[#D9B664]/55"></span>

                        <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-[13px] text-[#E6EEF8]/80 leading-[1.78]">
                            {{ $cerita['cerita'] ?? '' }}
                        </p>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
</section>
@endif

{{-- SEKSI 8: GALERI KENANGAN — SPOTLIGHT SINEMA & PASANGAN 2-KOLOM SIMETRIS (SELALU GENAP DI BARIS BAWAH) --}}
@if (! $tanpaFoto && $undangan->fiturAktif('galeri') && $undangan->daftarGaleri->isNotEmpty())
@php
    $daftarFotoGaleri = $undangan->daftarGaleri->values();
    $totalGaleri = $daftarFotoGaleri->count();
    $barisGaleriCelestial = [];

    if ($totalGaleri === 1) {
        $barisGaleriCelestial[] = ['tipe' => 'sorotan', 'nomor' => 1, 'items' => [$daftarFotoGaleri[0]]];
    } elseif ($totalGaleri === 2) {
        $barisGaleriCelestial[] = ['tipe' => 'pasang', 'rasio' => 'aspect-[4/5]', 'items' => [$daftarFotoGaleri[0], $daftarFotoGaleri[1]]];
    } elseif ($totalGaleri === 4) {
        $barisGaleriCelestial[] = ['tipe' => 'pasang', 'rasio' => 'aspect-[4/5]', 'items' => [$daftarFotoGaleri[0], $daftarFotoGaleri[1]]];
        $barisGaleriCelestial[] = ['tipe' => 'pasang', 'rasio' => 'aspect-[4/5]', 'items' => [$daftarFotoGaleri[2], $daftarFotoGaleri[3]]];
    } else {
        // Jumlah ganjil (3,5,7,9...): 1 sorotan utama di atas + baris 2-kolom simetris hingga bawah.
        // Jumlah genap >= 6 (6,8,10...): 1 sorotan utama + pasangan 2-kolom + 1 jeda sorotan tengah + pasangan 2-kolom,
        // sehingga baris paling bawah SELALU 2 foto simetris tanpa foto sendirian.
        $barisGaleriCelestial[] = ['tipe' => 'sorotan', 'nomor' => 1, 'items' => [$daftarFotoGaleri[0]]];
        $sisaGaleri = $daftarFotoGaleri->slice(1)->values();

        if ($sisaGaleri->count() % 2 === 1) {
            $jumlahPasang = intdiv($sisaGaleri->count() - 1, 2);
            $pasangAwal = (int) ceil($jumlahPasang / 2);
            $indeksTengah = $pasangAwal * 2;
            $idxPasang = 0;

            for ($i = 0; $i < $indeksTengah; $i += 2) {
                $barisGaleriCelestial[] = [
                    'tipe' => 'pasang',
                    'rasio' => $idxPasang % 2 === 0 ? 'aspect-[4/5]' : 'aspect-square',
                    'items' => [$sisaGaleri[$i], $sisaGaleri[$i + 1]],
                ];
                $idxPasang++;
            }

            $barisGaleriCelestial[] = [
                'tipe' => 'sorotan',
                'nomor' => $indeksTengah + 2,
                'items' => [$sisaGaleri[$indeksTengah]],
            ];

            $sisaPasangAkhir = intdiv($sisaGaleri->count() - ($indeksTengah + 1), 2);
            for ($k = 0; $k < $sisaPasangAkhir; $k++) {
                $pos = $indeksTengah + 1 + ($k * 2);
                $adalahTerakhir = ($k === $sisaPasangAkhir - 1);
                $barisGaleriCelestial[] = [
                    'tipe' => 'pasang',
                    'rasio' => $adalahTerakhir ? 'aspect-[4/5]' : (($sisaPasangAkhir - 1 - $k) % 2 === 1 ? 'aspect-square' : 'aspect-[4/5]'),
                    'items' => [$sisaGaleri[$pos], $sisaGaleri[$pos + 1]],
                ];
            }
        } else {
            $totalPasang = intdiv($sisaGaleri->count(), 2);
            for ($k = 0; $k < $totalPasang; $k++) {
                $pos = $k * 2;
                $adalahTerakhir = ($k === $totalPasang - 1);
                $barisGaleriCelestial[] = [
                    'tipe' => 'pasang',
                    'rasio' => $adalahTerakhir ? 'aspect-[4/5]' : (($totalPasang - 1 - $k) % 2 === 1 ? 'aspect-square' : 'aspect-[4/5]'),
                    'items' => [$sisaGaleri[$pos], $sisaGaleri[$pos + 1]],
                ];
            }
        }
    }
@endphp

<section
    data-layout-galeri="celestial"
    data-galeri-kolase-heavenly
    class="relative bg-gradient-to-b from-[#07101E] via-[#091425] to-[#08101E] py-14 px-5 text-white border-t border-[#D9B664]/25 overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-8 overflow-hidden space-y-1.5">
        <div data-gsap="kanan">
            <p class="scroll-scrub-kanan text-[9.5px] font-bold uppercase tracking-[0.36em] text-[#D9B664]">Galeri Kenangan</p>
        </div>
        <div data-gsap="kiri" data-gsap-delay="0.06">
            <h2 class="scroll-scrub-kiri font-kaligrafi text-5xl text-[#F3E5AB] leading-tight">Momen Terindah</h2>
        </div>
        <div data-gsap="garis" class="flex items-center justify-center gap-3 text-[9.5px] font-medium uppercase tracking-[0.32em] text-[#D9B664]/85 pt-1">
            <span class="h-px w-8 bg-[#D9B664]/45"></span>
            <span>{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</span>
            <span class="h-px w-8 bg-[#D9B664]/45"></span>
        </div>
    </div>

    <div class="max-w-md mx-auto space-y-3">
        @foreach ($barisGaleriCelestial as $baris)
            @if ($baris['tipe'] === 'sorotan')
                @php $g = $baris['items'][0]; @endphp
                <button
                    type="button"
                    @click="bukaGaleri(@js($g->urlFoto()), @js($g->keterangan))"
                    data-gsap="potret"
                    class="group relative block w-full overflow-hidden rounded-2xl border border-[#D9B664]/45 bg-[#0C192C] shadow-[0_22px_46px_-18px_rgba(0,0,0,0.85)] cursor-pointer aspect-[16/10]"
                >
                    <img
                        src="{{ $g->urlFoto() }}"
                        alt="{{ $g->keterangan ?? 'Galeri' }}"
                        loading="lazy"
                        decoding="async"
                        class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-700"
                    >
                    <div
                        aria-hidden="true"
                        class="pointer-events-none absolute inset-x-0 bottom-0 h-20"
                        style="background: linear-gradient(180deg, transparent 0%, rgba(6,13,24,0.88) 100%);"
                    ></div>
                    <div class="pointer-events-none absolute inset-x-3.5 bottom-2.5 flex items-center justify-between gap-2">
                        <span class="text-left text-[10.5px] font-medium text-[#F3E5AB] truncate">
                            {{ $g->keterangan ?: 'Momen Bahagia' }}
                        </span>
                        <span class="shrink-0 text-[9px] font-mono tracking-widest text-[#D9B664]/90">
                            {{ str_pad((string) $baris['nomor'], 2, '0', STR_PAD_LEFT) }} / {{ str_pad((string) $totalGaleri, 2, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>
                </button>
            @else
                <div class="grid grid-cols-2 gap-3">
                    @foreach ($baris['items'] as $idxItem => $g)
                        <button
                            type="button"
                            @click="bukaGaleri(@js($g->urlFoto()), @js($g->keterangan))"
                            data-gsap="potret"
                            data-gsap-delay="{{ $idxItem === 1 ? '0.06' : '0' }}"
                            class="group relative block w-full overflow-hidden rounded-xl border border-[#D9B664]/30 bg-[#0C192C] shadow-lg cursor-pointer {{ $baris['rasio'] }}"
                        >
                            <img
                                src="{{ $g->urlFoto() }}"
                                alt="{{ $g->keterangan ?? 'Galeri' }}"
                                loading="lazy"
                                decoding="async"
                                class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-700"
                            >
                            @if ($g->keterangan)
                                <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#060D18]/90 via-[#060D18]/45 to-transparent px-2.5 py-2 text-left text-[10px] font-medium text-[#F3E5AB] opacity-0 group-hover:opacity-100 transition duration-300">
                                    {{ $g->keterangan }}
                                </span>
                            @endif
                        </button>
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>

    <div data-gsap="garis" class="mt-8 flex items-center justify-center gap-3 text-[10px] font-medium uppercase tracking-[0.34em] text-[#D9B664]/80">
        <span class="h-px w-8 bg-[#D9B664]/40"></span>
        <span>{{ $hashtagPasangan }}</span>
        <span class="h-px w-8 bg-[#D9B664]/40"></span>
    </div>
</section>
@endif
