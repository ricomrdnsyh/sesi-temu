{{-- SEKSI 3: PROFIL MEMPELAI (PAVILIUN OBSERVATORIUM MALAM — URUTAN SELARAS ISLAMI SYAR'I) --}}
<section
    data-layout-mempelai="celestial"
    class="relative bg-gradient-to-b from-[#0E1B2A] via-[#0B1728] to-[#091322] celestial-pola-bintang px-4 py-14 overflow-hidden"
>
    <div class="relative z-10 max-w-md mx-auto space-y-7">
        {{-- Tajuk Seksi Bermahkota Bulan Sabit --}}
        <div class="text-center space-y-2 px-2">
            <div data-gsap="turun">
                <img
                    src="{{ $asetCelestial['sabit'] }}"
                    alt=""
                    loading="lazy"
                    decoding="async"
                    class="w-12 mx-auto drop-shadow-[0_6px_14px_rgba(0,0,0,0.65)] animasi-ayun-3d"
                >
            </div>
            <div data-gsap="mekar" class="flex items-center justify-center gap-2.5 pt-0.5">
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-r from-transparent to-[#D9B664]"></span>
                <span aria-hidden="true" class="text-[9px] text-[#F3E5AB]">&#10022;</span>
                <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#D9B664]">
                    Bismillahirrahmanirrahim
                </p>
                <span aria-hidden="true" class="text-[9px] text-[#F3E5AB]">&#10022;</span>
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-l from-transparent to-[#D9B664]"></span>
            </div>
            <h2 data-gsap="naik" class="font-serif text-[2rem] sm:text-[2.2rem] font-bold leading-tight text-white">
                Mempelai Pengantin
            </h2>
            <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-[13px] text-[#E6EEF8]/80 max-w-xs mx-auto leading-relaxed">
                Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud menyelenggarakan akad nikah &amp; walimatul ursy putra-putri kami:
            </p>
            <svg data-gsap="garis" viewBox="0 0 260 22" class="w-32 mx-auto pt-1 opacity-80" aria-hidden="true">
                <path d="M10 16 H96 Q130 2 164 16 H250" fill="none" stroke="#D9B664" stroke-width="1.5" stroke-linecap="round"/>
                <circle cx="130" cy="11" r="2.2" fill="#F3E5AB"/>
            </svg>
        </div>

        {{-- KARTU MEMPELAI PRIA (PAVILIUN KUBAH SAFIR-EMAS) --}}
        <article class="group relative rounded-[2rem] bg-gradient-to-b from-[#152842] via-[#102036] to-[#0B1626] border border-[#D9B664]/68 shadow-[0_26px_54px_-16px_rgba(0,0,0,0.82)] overflow-hidden kartu-3d">
            <div class="relative bg-gradient-to-b from-[#172F50] via-[#11233D] to-[#0B172A] px-5 pt-7 pb-10 overflow-hidden">
                <div
                    aria-hidden="true"
                    class="pointer-events-none absolute inset-0"
                    style="background: radial-gradient(circle at 50% 45%, rgba(243,229,171,0.2) 0%, rgba(21,40,66,0.06) 52%, rgba(6,13,24,0.6) 100%);"
                ></div>

                {{-- Sepasang Lentera Fanous Mini Di Sudut Atas --}}
                <svg aria-hidden="true" viewBox="0 0 40 90" class="pointer-events-none absolute top-0 left-3.5 w-7 text-[#E5C474]/78 celestial-lentera-kiri" fill="none" stroke="currentColor" stroke-width="1.2">
                    <line x1="20" y1="0" x2="20" y2="30"/>
                    <path d="M13 37 Q20 30 27 37 L29 52 Q20 61 11 52 Z" fill="currentColor" fill-opacity="0.16"/>
                    <circle cx="20" cy="46" r="2" fill="#FFF5D6" stroke="none"/>
                    <path d="M20 59 L20 69"/>
                    <path d="M20 69 L22.5 74 L20 79 L17.5 74 Z" fill="currentColor" stroke="none"/>
                </svg>
                <svg aria-hidden="true" viewBox="0 0 40 90" class="pointer-events-none absolute top-0 right-3.5 w-7 text-[#E5C474]/78 celestial-lentera-kanan" fill="none" stroke="currentColor" stroke-width="1.2">
                    <line x1="20" y1="0" x2="20" y2="24"/>
                    <path d="M13 31 Q20 24 27 31 L29 46 Q20 55 11 46 Z" fill="currentColor" fill-opacity="0.16"/>
                    <circle cx="20" cy="40" r="2" fill="#FFF5D6" stroke="none"/>
                    <path d="M20 53 L20 63"/>
                    <path d="M20 63 L22.5 68 L20 73 L17.5 68 Z" fill="currentColor" stroke="none"/>
                </svg>

                {{-- Potret Kubah Mihrab Emas Ganda (Tegas & Proporsional) --}}
                <div data-gsap="potret" class="relative z-10 mx-auto flex items-center justify-center">
                    @if (! $tanpaFoto && $undangan->urlFotoPria())
                        <div class="relative">
                            <span aria-hidden="true" class="pointer-events-none absolute -inset-2 rounded-t-[8.5rem] rounded-b-[1.5rem] border border-dashed border-[#F3E5AB]/40"></span>
                            <div class="p-[4px] rounded-t-[8rem] rounded-b-[1.3rem] bg-gradient-to-b from-[#FFF1C2] via-[#D9B664] to-[#8C6D32] shadow-[0_18px_38px_rgba(0,0,0,0.75)]">
                                <div class="w-44 sm:w-48 aspect-[4/5] rounded-t-[7.6rem] rounded-b-[1.05rem] overflow-hidden bg-[#091322]">
                                    <img
                                        src="{{ $undangan->urlFotoPria() }}"
                                        alt="{{ $undangan->nama_lengkap_pria }}"
                                        loading="lazy"
                                        decoding="async"
                                        class="w-full h-full object-cover object-top scale-[1.02] group-hover:scale-[1.06] transition duration-700"
                                    >
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="relative h-36 w-36 my-3 flex items-center justify-center">
                            <span aria-hidden="true" class="absolute inset-0 rounded-full border border-dashed border-[#D9B664]/65 animasi-orbit"></span>
                            <span aria-hidden="true" class="absolute inset-2.5 rounded-full border border-[#F3E5AB]/45 bg-[#091322]/85 shadow-inner animasi-orbit-balik"></span>
                            <div class="relative z-10 text-center">
                                <span class="block text-[8px] uppercase tracking-[0.28em] text-[#D9B664]">Al-&lsquo;Aris</span>
                                <span class="font-serif text-5xl font-bold text-[#F3E5AB] leading-none">{{ $undangan->inisialPria() }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Pita Gelar Emas Bertengger Di Sambungan --}}
            <div data-gsap="mekar" class="relative z-30 -mt-4 flex justify-center">
                <span class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#F3E5AB] via-[#D9B664] to-[#F3E5AB] px-4 py-1 text-[10px] font-bold uppercase tracking-[0.24em] text-[#091322] border border-[#FFF8E4]/80 shadow-[0_8px_20px_-6px_rgba(0,0,0,0.65)]">
                    <span aria-hidden="true" class="text-[9px]">&#10022;</span>
                    <span>Al-&lsquo;Aris &middot; Mempelai Pria</span>
                    <span aria-hidden="true" class="text-[9px]">&#10022;</span>
                </span>
            </div>

            {{-- Panel Biografi Malam Safir --}}
            <div class="relative bg-[#0B1626]/82 border-t border-[#D9B664]/28 px-6 pt-5 pb-7 text-center space-y-2">
                <span aria-hidden="true" class="pointer-events-none absolute bottom-3 left-3 h-4 w-4 border-b border-l border-[#D9B664]/55 rounded-bl-md"></span>
                <span aria-hidden="true" class="pointer-events-none absolute bottom-3 right-3 h-4 w-4 border-b border-r border-[#D9B664]/55 rounded-br-md"></span>

                <h3 data-gsap="kiri" class="font-kaligrafi text-[2.8rem] sm:text-[3.1rem] leading-[1.08] text-[#F3E5AB]">
                    {{ $undangan->nama_panggilan_pria }}
                </h3>
                <p data-gsap="teks" data-gsap-delay="0.06" class="font-serif text-base sm:text-[1.08rem] font-bold tracking-wide text-white">
                    {{ $undangan->nama_lengkap_pria }}
                </p>

                @if ($undangan->nama_ayah_pria || $undangan->nama_ibu_pria)
                    <div class="pt-1.5 space-y-1">
                        <div data-gsap="garis" class="flex items-center justify-center gap-2.5 px-12" aria-hidden="true">
                            <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#D9B664]/60"></span>
                            <span class="text-[8px] text-[#F3E5AB]">&#10022;</span>
                            <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#D9B664]/60"></span>
                        </div>
                        <p data-gsap="teks" class="text-[10px] font-bold uppercase tracking-[0.24em] text-[#D9B664] pt-1">
                            Putra dari
                        </p>
                        <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-[13px] font-medium text-[#E6EEF8]/82 leading-relaxed max-w-xs mx-auto">
                            {{ $undangan->nama_ayah_pria }} &amp; {{ $undangan->nama_ibu_pria }}
                        </p>
                    </div>
                @endif

                @if ($instagramPria !== '')
                    <div data-gsap="mekar" data-gsap-delay="0.08" class="pt-2.5">
                        <a
                            href="https://instagram.com/{{ $instagramPria }}"
                            target="_blank"
                            rel="noopener"
                            class="celestial-tombol-safir inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-[11px] font-semibold tracking-wide transition active:scale-95"
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

        {{-- PEMISAH BINTANG RUB EL HIZB BERORBIT --}}
        <div class="flex items-center justify-center gap-4 py-1" aria-hidden="true">
            <span data-gsap="garis" class="h-px flex-1 max-w-[82px] bg-gradient-to-r from-transparent via-[#D9B664]/65 to-[#D9B664]"></span>
            <div data-gsap="mekar" class="relative w-14 h-14 flex items-center justify-center">
                <span class="absolute inset-0 rounded-full border border-dashed border-[#D9B664]/55 animasi-orbit"></span>
                <span class="absolute inset-2 border border-[#D9B664]/80 bg-[#0D1C31] shadow-md"></span>
                <span class="absolute inset-2 rotate-45 border border-[#F3E5AB]/75 bg-[#0D1C31] shadow-md animasi-orbit-balik"></span>
                <span class="relative z-10 font-kaligrafi text-3xl text-[#F3E5AB] leading-none pt-0.5">&amp;</span>
            </div>
            <span data-gsap="garis" class="h-px flex-1 max-w-[82px] bg-gradient-to-l from-transparent via-[#D9B664]/65 to-[#D9B664]"></span>
        </div>

        {{-- KARTU MEMPELAI WANITA (PAVILIUN KUBAH SAFIR-EMAS) --}}
        <article class="group relative rounded-[2rem] bg-gradient-to-b from-[#152842] via-[#102036] to-[#0B1626] border border-[#D9B664]/68 shadow-[0_26px_54px_-16px_rgba(0,0,0,0.82)] overflow-hidden kartu-3d">
            <div class="relative bg-gradient-to-b from-[#172F50] via-[#11233D] to-[#0B172A] px-5 pt-7 pb-10 overflow-hidden">
                <div
                    aria-hidden="true"
                    class="pointer-events-none absolute inset-0"
                    style="background: radial-gradient(circle at 50% 45%, rgba(243,229,171,0.2) 0%, rgba(21,40,66,0.06) 52%, rgba(6,13,24,0.6) 100%);"
                ></div>

                <svg aria-hidden="true" viewBox="0 0 40 90" class="pointer-events-none absolute top-0 left-3.5 w-7 text-[#E5C474]/78 celestial-lentera-kiri" fill="none" stroke="currentColor" stroke-width="1.2">
                    <line x1="20" y1="0" x2="20" y2="30"/>
                    <path d="M13 37 Q20 30 27 37 L29 52 Q20 61 11 52 Z" fill="currentColor" fill-opacity="0.16"/>
                    <circle cx="20" cy="46" r="2" fill="#FFF5D6" stroke="none"/>
                    <path d="M20 59 L20 69"/>
                    <path d="M20 69 L22.5 74 L20 79 L17.5 74 Z" fill="currentColor" stroke="none"/>
                </svg>
                <svg aria-hidden="true" viewBox="0 0 40 90" class="pointer-events-none absolute top-0 right-3.5 w-7 text-[#E5C474]/78 celestial-lentera-kanan" fill="none" stroke="currentColor" stroke-width="1.2">
                    <line x1="20" y1="0" x2="20" y2="24"/>
                    <path d="M13 31 Q20 24 27 31 L29 46 Q20 55 11 46 Z" fill="currentColor" fill-opacity="0.16"/>
                    <circle cx="20" cy="40" r="2" fill="#FFF5D6" stroke="none"/>
                    <path d="M20 53 L20 63"/>
                    <path d="M20 63 L22.5 68 L20 73 L17.5 68 Z" fill="currentColor" stroke="none"/>
                </svg>

                <div data-gsap="potret" class="relative z-10 mx-auto flex items-center justify-center">
                    @if (! $tanpaFoto && $undangan->urlFotoWanita())
                        <div class="relative">
                            <span aria-hidden="true" class="pointer-events-none absolute -inset-2 rounded-t-[8.5rem] rounded-b-[1.5rem] border border-dashed border-[#F3E5AB]/40"></span>
                            <div class="p-[4px] rounded-t-[8rem] rounded-b-[1.3rem] bg-gradient-to-b from-[#FFF1C2] via-[#D9B664] to-[#8C6D32] shadow-[0_18px_38px_rgba(0,0,0,0.75)]">
                                <div class="w-44 sm:w-48 aspect-[4/5] rounded-t-[7.6rem] rounded-b-[1.05rem] overflow-hidden bg-[#091322]">
                                    <img
                                        src="{{ $undangan->urlFotoWanita() }}"
                                        alt="{{ $undangan->nama_lengkap_wanita }}"
                                        loading="lazy"
                                        decoding="async"
                                        class="w-full h-full object-cover object-top scale-[1.02] group-hover:scale-[1.06] transition duration-700"
                                    >
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="relative h-36 w-36 my-3 flex items-center justify-center">
                            <span aria-hidden="true" class="absolute inset-0 rounded-full border border-dashed border-[#D9B664]/65 animasi-orbit"></span>
                            <span aria-hidden="true" class="absolute inset-2.5 rounded-full border border-[#F3E5AB]/45 bg-[#091322]/85 shadow-inner animasi-orbit-balik"></span>
                            <div class="relative z-10 text-center">
                                <span class="block text-[8px] uppercase tracking-[0.28em] text-[#D9B664]">Al-&lsquo;Arus</span>
                                <span class="font-serif text-5xl font-bold text-[#F3E5AB] leading-none">{{ $undangan->inisialWanita() }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div data-gsap="mekar" class="relative z-30 -mt-4 flex justify-center">
                <span class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#F3E5AB] via-[#D9B664] to-[#F3E5AB] px-4 py-1 text-[10px] font-bold uppercase tracking-[0.24em] text-[#091322] border border-[#FFF8E4]/80 shadow-[0_8px_20px_-6px_rgba(0,0,0,0.65)]">
                    <span aria-hidden="true" class="text-[9px]">&#10022;</span>
                    <span>Al-&lsquo;Arus &middot; Mempelai Wanita</span>
                    <span aria-hidden="true" class="text-[9px]">&#10022;</span>
                </span>
            </div>

            <div class="relative bg-[#0B1626]/82 border-t border-[#D9B664]/28 px-6 pt-5 pb-7 text-center space-y-2">
                <span aria-hidden="true" class="pointer-events-none absolute bottom-3 left-3 h-4 w-4 border-b border-l border-[#D9B664]/55 rounded-bl-md"></span>
                <span aria-hidden="true" class="pointer-events-none absolute bottom-3 right-3 h-4 w-4 border-b border-r border-[#D9B664]/55 rounded-br-md"></span>

                <h3 data-gsap="kanan" class="font-kaligrafi text-[2.8rem] sm:text-[3.1rem] leading-[1.08] text-[#F3E5AB]">
                    {{ $undangan->nama_panggilan_wanita }}
                </h3>
                <p data-gsap="teks" data-gsap-delay="0.06" class="font-serif text-base sm:text-[1.08rem] font-bold tracking-wide text-white">
                    {{ $undangan->nama_lengkap_wanita }}
                </p>

                @if ($undangan->nama_ayah_wanita || $undangan->nama_ibu_wanita)
                    <div class="pt-1.5 space-y-1">
                        <div data-gsap="garis" class="flex items-center justify-center gap-2.5 px-12" aria-hidden="true">
                            <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#D9B664]/60"></span>
                            <span class="text-[8px] text-[#F3E5AB]">&#10022;</span>
                            <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#D9B664]/60"></span>
                        </div>
                        <p data-gsap="teks" class="text-[10px] font-bold uppercase tracking-[0.24em] text-[#D9B664] pt-1">
                            Putri dari
                        </p>
                        <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-[13px] font-medium text-[#E6EEF8]/82 leading-relaxed max-w-xs mx-auto">
                            {{ $undangan->nama_ayah_wanita }} &amp; {{ $undangan->nama_ibu_wanita }}
                        </p>
                    </div>
                @endif

                @if ($instagramWanita !== '')
                    <div data-gsap="mekar" data-gsap-delay="0.08" class="pt-2.5">
                        <a
                            href="https://instagram.com/{{ $instagramWanita }}"
                            target="_blank"
                            rel="noopener"
                            class="celestial-tombol-safir inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-[11px] font-semibold tracking-wide transition active:scale-95"
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

{{-- SEKSI 4A: SLIDESHOW FOTO TRANSISI KE HITUNG MUNDUR (URUTAN SELARAS ISLAMI SYAR'I) --}}
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
    class="relative h-64 sm:h-72 w-full overflow-hidden bg-[#091322]"
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
        style="background: linear-gradient(180deg, rgba(9,19,34,0.86) 0%, rgba(9,19,34,0.18) 32%, rgba(9,19,34,0.34) 68%, #091322 100%);"
    ></div>
</div>
@endif

{{-- SEKSI 4B: HITUNG MUNDUR — 4 KUBAH BINTANG SAFIR-EMAS (URUTAN SELARAS ISLAMI SYAR'I) --}}
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
    class="relative bg-gradient-to-b from-[#091322] via-[#07101E] to-[#0B1728] shadow-[0_-2px_0_0_#091322] px-6 py-13 text-center border-b border-[#D9B664]/35 overflow-hidden"
>
    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-0"
        style="background: radial-gradient(ellipse 75% 55% at 50% 35%, rgba(217,182,100,0.15) 0%, transparent 72%);"
    ></div>

    <div class="relative z-10 max-w-md mx-auto space-y-5">
        <div data-gsap="turun" class="flex items-center justify-center gap-3">
            <span aria-hidden="true" class="h-px w-10 bg-gradient-to-r from-transparent to-[#D9B664]/70"></span>
            <img src="{{ $asetCelestial['sabit'] }}" alt="" loading="lazy" decoding="async" class="w-10 drop-shadow">
            <span aria-hidden="true" class="h-px w-10 bg-gradient-to-l from-transparent to-[#D9B664]/70"></span>
        </div>

        <div data-gsap="naik" class="space-y-1">
            <p class="text-[10px] font-bold uppercase tracking-[0.36em] text-[#D9B664]">Menuju Hari Bahagia</p>
            <h2 class="font-kaligrafi text-5xl text-white leading-tight">Save The Date</h2>
        </div>

        {{-- 4 Ubin Kubah Bintang Emas --}}
        <div class="grid grid-cols-4 gap-2.5 pt-1 panggung-3d">
            @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                <div
                    data-gsap="mekar"
                    data-gsap-delay="{{ number_format($loop->index * 0.07, 2, '.', '') }}"
                    class="relative rounded-t-full rounded-b-2xl bg-gradient-to-b from-[#F5E6BC] via-[#E5C474] to-[#C69C46] text-[#091322] border border-[#FFF8E4]/80 pt-5 pb-3.5 px-1 shadow-lg"
                >
                    <div
                        class="font-serif text-2xl sm:text-[1.75rem] font-bold leading-none"
                        x-text="{{ $var }}"
                        x-effect="if ({{ $var }}) { $el.classList.remove('angka-flip-3d'); void $el.offsetWidth; $el.classList.add('angka-flip-3d'); }"
                    >00</div>
                    <div class="mt-2 text-[9px] uppercase tracking-[0.2em] font-bold text-[#091322]/85">{{ $label }}</div>
                </div>
            @endforeach
        </div>

        <p data-gsap="teks" class="text-xs text-[#E6EEF8]/82 max-w-xs mx-auto leading-relaxed pt-1">
            Merupakan kehormatan dan keberkahan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu.
        </p>

        @if ($googleCalUrl)
            <div data-gsap="mekar" data-gsap-delay="0.08" class="pt-1">
                <a
                    href="{{ $googleCalUrl }}"
                    target="_blank"
                    rel="noopener"
                    class="celestial-tombol-emas inline-flex items-center gap-2 rounded-full px-7 py-2.5 text-xs sm:text-sm font-bold uppercase tracking-wider transition active:scale-95"
                >
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
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

{{-- SEKSI 5: JADWAL AKAD & WALIMAH (PLAKAT KUBAH MASJID MALAM CELESTIAL) --}}
@if ($undangan->daftarAcara->isNotEmpty())
<section
    data-layout-acara="celestial"
    class="relative bg-gradient-to-b from-[#0E1B2A] via-[#0B1728] to-[#091322] celestial-pola-bintang px-4 py-14 overflow-hidden"
>
    <div class="relative z-10 max-w-md mx-auto space-y-7">
        <div class="text-center space-y-2">
            <img
                src="{{ $asetCelestial['sabit'] }}"
                alt=""
                loading="lazy"
                decoding="async"
                data-gsap="turun"
                class="w-10 mx-auto opacity-95"
            >
            <div data-gsap="mekar" class="flex items-center justify-center gap-2.5">
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-r from-transparent to-[#D9B664]"></span>
                <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#D9B664]">InsyaAllah Dilaksanakan Pada</p>
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-l from-transparent to-[#D9B664]"></span>
            </div>
            <h2 data-gsap="naik" class="font-serif text-[2rem] sm:text-[2.15rem] font-bold leading-tight text-white">
                Jadwal Akad &amp; Walimah
            </h2>
        </div>

        <div class="space-y-6">
            @foreach ($undangan->daftarAcara as $acara)
                @php
                    $nomorAcara = str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT);
                @endphp
                <article class="relative rounded-t-[8.5rem] rounded-b-[1.85rem] bg-gradient-to-b from-[#152842] via-[#102036] to-[#0B1626] border border-[#D9B664]/65 px-5 sm:px-6 pt-9 pb-7 text-center shadow-[0_24px_52px_-16px_rgba(0,0,0,0.82)] overflow-hidden kartu-3d">
                    {{-- Lapisan Lengkung Putus-Putus Konsentris --}}
                    <span aria-hidden="true" class="pointer-events-none absolute inset-2.5 rounded-t-[7.8rem] rounded-b-[1.35rem] border border-dashed border-[#D9B664]/35"></span>

                    {{-- Pendar Emas Lembut Di Puncak Kubah --}}
                    <div
                        aria-hidden="true"
                        class="pointer-events-none absolute inset-x-0 top-0 h-32 opacity-65"
                        style="background: radial-gradient(ellipse 72% 85% at 50% 0%, rgba(243,229,171,0.22) 0%, rgba(21,40,66,0.08) 58%, transparent 100%);"
                    ></div>

                    <div class="relative z-10 space-y-5">
                        {{-- Siluet Kubah Masjid & Tajuk Prosesi --}}
                        <div class="space-y-2">
                            <svg data-gsap="turun" aria-hidden="true" viewBox="0 0 120 44" class="w-24 mx-auto text-[#D9B664]/85" fill="none" stroke="currentColor" stroke-width="1.2">
                                <path d="M12 40 H108"/>
                                <path d="M26 40 V26 L29 19 L32 26 V40"/>
                                <path d="M88 40 V26 L91 19 L94 26 V40"/>
                                <path d="M40 40 C40 22 52 16 60 8 C68 16 80 22 80 40 Z" fill="rgba(217,182,100,0.14)"/>
                                <circle cx="60" cy="5.5" r="1.6" fill="#F3E5AB" stroke="none"/>
                            </svg>

                            <p data-gsap="teks" class="text-[9.5px] font-bold uppercase tracking-[0.34em] text-[#D9B664]">
                                Prosesi {{ $nomorAcara }}
                            </p>
                            <h3 data-gsap="mekar" data-gsap-delay="0.06" class="font-serif text-[1.6rem] sm:text-[1.8rem] font-bold leading-snug text-[#F3E5AB] px-3">
                                {{ $acara->nama_acara }}
                            </h3>
                        </div>

                        {{-- Pita 3-Kolom Waktu Celestial Dengan Medali Bulan-Lingkaran Tanggal Di Tengah --}}
                        <div class="relative rounded-2xl bg-[#091322]/78 border border-[#D9B664]/40 px-3 py-4">
                            <div class="grid grid-cols-3 items-center gap-2">
                                <div data-gsap="kiri" class="space-y-0.5">
                                    <p class="text-[9px] font-bold uppercase tracking-[0.24em] text-[#D9B664]">Hari</p>
                                    <p class="font-serif text-sm sm:text-[15px] font-bold text-white">
                                        {{ $acara->tanggal_acara->locale('id')->translatedFormat('l') }}
                                    </p>
                                </div>

                                <div data-gsap="mekar" data-gsap-delay="0.06" class="flex flex-col items-center">
                                    <div class="relative h-13 w-13 flex items-center justify-center rounded-full bg-gradient-to-b from-[#1B3456] to-[#0B1728] border-2 border-[#D9B664] shadow-[0_0_20px_-4px_rgba(217,182,100,0.45)]">
                                        <span class="font-serif text-xl font-bold text-[#F3E5AB] leading-none">
                                            {{ $acara->tanggal_acara->format('d') }}
                                        </span>
                                    </div>
                                    <p class="mt-1.5 text-[9.5px] font-bold uppercase tracking-[0.16em] text-[#E6EEF8]">
                                        {{ $acara->tanggal_acara->locale('id')->translatedFormat('M Y') }}
                                    </p>
                                </div>

                                <div data-gsap="kanan" class="space-y-0.5">
                                    <p class="text-[9px] font-bold uppercase tracking-[0.24em] text-[#D9B664]">Waktu</p>
                                    <p class="font-serif text-xs sm:text-[13px] font-bold text-white leading-tight">
                                        {{ \Illuminate\Support\Str::substr($acara->waktu_mulai, 0, 5) }}
                                        @if ($acara->waktu_selesai)
                                            &ndash; {{ \Illuminate\Support\Str::substr($acara->waktu_selesai, 0, 5) }}
                                        @else
                                            &ndash; Selesai
                                        @endif
                                    </p>
                                    <p class="text-[9px] font-semibold uppercase tracking-[0.2em] text-[#D9B664]">
                                        {{ $acara->zona_waktu }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Panel Lokasi Sanctuary Malam --}}
                        <div class="rounded-2xl bg-[#091322]/55 border border-[#D9B664]/25 px-4 py-4 space-y-2">
                            <div data-gsap="turun" class="inline-flex items-center gap-1.5 text-[9.5px] font-bold uppercase tracking-[0.26em] text-[#D9B664]">
                                <svg class="w-3.5 h-3.5 text-[#F3E5AB]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7Zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/>
                                </svg>
                                <span>Lokasi Acara</span>
                            </div>
                            <p data-gsap="naik" class="font-serif text-base sm:text-[1.08rem] font-bold text-white leading-snug">
                                {{ $acara->nama_tempat }}
                            </p>
                            <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-[13px] text-[#E6EEF8]/78 leading-relaxed max-w-[285px] mx-auto">
                                {{ $acara->alamat_lengkap }}
                            </p>

                            @if ($acara->link_maps)
                                <div data-gsap="mekar" data-gsap-delay="0.08" class="pt-2">
                                    <a
                                        href="{{ $acara->link_maps }}"
                                        target="_blank"
                                        rel="noopener"
                                        class="celestial-tombol-emas inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-[11px] font-bold uppercase tracking-[0.14em] transition active:scale-95"
                                    >
                                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7Zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/>
                                        </svg>
                                        <span>Petunjuk Lokasi Maps</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- SEKSI 6: ADAB & NUANSA BUSANA + LIVE STREAMING --}}
@if ($adaDressCode || (! empty($live['aktif']) && ! empty($live['link'])))
<section class="relative bg-[#091322] px-4 py-10 space-y-5 overflow-hidden">
    @if ($adaDressCode)
        <div data-section-dress-code="celestial" class="max-w-md mx-auto rounded-3xl bg-gradient-to-b from-[#13243B] to-[#0D1B2E] border border-[#D9B664]/50 p-6 text-center space-y-3.5 shadow-xl kartu-3d">
            <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#D9B664]">Adab &amp; Nuansa Busana</p>
            @if ($dressCodeCatatan !== '')
                <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-sm text-[#E6EEF8]/88 leading-relaxed">{{ $dressCodeCatatan }}</p>
            @endif
            @if (! empty($dressCodeWarna))
                <div class="flex flex-wrap items-center justify-center gap-4 pt-1">
                    @foreach ($dressCodeWarna as $hex)
                        <div data-gsap="mekar" data-gsap-delay="{{ number_format($loop->index * 0.06, 2, '.', '') }}" class="flex flex-col items-center gap-1.5">
                            <span class="h-9 w-9 rounded-full border-2 border-[#F3E5AB]/85 shadow-[0_0_16px_-4px_rgba(217,182,100,0.45)]" style="background-color: {{ $hex }};"></span>
                            <span class="text-[9px] font-mono text-[#F3E5AB]/85">{{ $hex }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    @if (! empty($live['aktif']) && ! empty($live['link']))
        <div class="max-w-md mx-auto rounded-3xl bg-gradient-to-b from-[#13243B] to-[#0D1B2E] border border-[#D9B664]/55 p-6 text-center space-y-3 shadow-xl efek-shimmer-kartu kartu-3d">
            <span data-gsap="turun" class="inline-flex items-center gap-1.5 rounded-full bg-[#D9B664]/15 border border-[#D9B664]/45 px-3 py-0.5 text-[9.5px] font-bold uppercase tracking-[0.28em] text-[#F3E5AB]">
                <span class="h-1.5 w-1.5 rounded-full bg-[#F3E5AB] animate-pulse"></span>
                Siaran Walimah
            </span>
            <h3 data-gsap="naik" class="font-serif text-2xl font-bold text-[#F3E5AB]">Live Streaming</h3>
            <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-[13px] text-[#E6EEF8]/82 leading-relaxed">
                Saksikan prosesi ijab qabul secara virtual melalui {{ $live['platform'] ?? 'YouTube Live' }}.
            </p>
            <div data-gsap="mekar" data-gsap-delay="0.08" class="pt-1">
                <a
                    href="{{ $live['link'] }}"
                    target="_blank"
                    rel="noopener"
                    class="celestial-tombol-emas inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-xs font-bold uppercase tracking-wider transition active:scale-95"
                >
                    <span>Saksikan Siaran Langsung</span>
                </a>
            </div>
        </div>
    @endif
</section>
@endif

{{-- SEKSI 7: PETA BINTANG KONSTELASI — PERJALANAN TA'ARUF & KISAH PERTEMUAN --}}
@if ($undangan->fiturAktif('cerita_cinta') && ! empty($ceritaList))
<section
    data-layout-cerita="celestial"
    class="relative bg-gradient-to-b from-[#091322] via-[#0E1B2E] to-[#091322] celestial-pola-bintang px-4 py-14 overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-8 overflow-hidden py-1 space-y-1.5">
        <div data-gsap="kiri">
            <p class="scroll-scrub-kiri text-[10px] font-bold uppercase tracking-[0.34em] text-[#D9B664]">Perjalanan Ta&rsquo;aruf</p>
        </div>
        <div data-gsap="kanan" data-gsap-delay="0.06">
            <h2 class="scroll-scrub-kanan font-serif text-[2rem] sm:text-[2.15rem] font-bold text-white">Kisah Pertemuan</h2>
        </div>
        <div data-gsap="garis" class="flex items-center justify-center gap-2.5 pt-1" aria-hidden="true">
            <span class="h-px w-10 bg-gradient-to-r from-transparent to-[#D9B664]"></span>
            <span class="text-[10px] text-[#F3E5AB]">&#10022;</span>
            <span class="h-px w-10 bg-gradient-to-l from-transparent to-[#D9B664]"></span>
        </div>
    </div>

    <div class="relative z-10 max-w-md mx-auto">
        @foreach ($ceritaList as $idx => $cerita)
            @php
                $urlFotoBab = (! $tanpaFoto && ! empty($cerita['foto']))
                    ? \App\Support\MediaPublik::url((string) $cerita['foto'])
                    : null;
                $nomorBab = str_pad((string) ($idx + 1), 2, '0', STR_PAD_LEFT);
            @endphp

            <article class="relative rounded-[1.85rem] bg-gradient-to-b from-[#14263E] via-[#102036] to-[#0B1626] border border-[#D9B664]/55 px-5 sm:px-6 py-6 text-center shadow-[0_20px_46px_-18px_rgba(0,0,0,0.82)] kartu-3d">
                <span aria-hidden="true" class="pointer-events-none absolute top-3 left-3 h-3 w-3 border-t border-l border-[#D9B664]/60"></span>
                <span aria-hidden="true" class="pointer-events-none absolute top-3 right-3 h-3 w-3 border-t border-r border-[#D9B664]/60"></span>
                <span aria-hidden="true" class="pointer-events-none absolute bottom-3 left-3 h-3 w-3 border-b border-l border-[#D9B664]/60"></span>
                <span aria-hidden="true" class="pointer-events-none absolute bottom-3 right-3 h-3 w-3 border-b border-r border-[#D9B664]/60"></span>

                @if ($urlFotoBab)
                    <div data-gsap="potret" class="mx-auto mb-5 p-1.5 rounded-t-[6.5rem] rounded-b-2xl bg-gradient-to-b from-[#F3E5AB]/55 via-[#D9B664]/35 to-[#D9B664]/15 max-w-[270px] shadow-lg">
                        <div class="overflow-hidden rounded-t-[6rem] rounded-b-xl aspect-[4/3] bg-[#091322]">
                            <img
                                src="{{ $urlFotoBab }}"
                                alt="{{ $cerita['judul'] ?? 'Kisah Pertemuan' }}"
                                loading="lazy"
                                decoding="async"
                                class="w-full h-full object-cover object-top"
                            >
                        </div>
                    </div>
                @endif

                <div class="space-y-2.5">
                    <div data-gsap="turun" class="flex items-center justify-center gap-2">
                        <span class="text-[9.5px] font-bold uppercase tracking-[0.3em] text-[#D9B664]">
                            Fase {{ $nomorBab }}
                        </span>
                        @if (! empty($cerita['tanggal']))
                            <span aria-hidden="true" class="text-[8px] text-[#F3E5AB]">&#10022;</span>
                            <span class="rounded-full bg-[#D9B664]/18 border border-[#D9B664]/45 px-3 py-0.5 text-[10px] font-semibold tracking-wider text-[#F3E5AB]">
                                {{ $cerita['tanggal'] }}
                            </span>
                        @endif
                    </div>

                    <h3 data-gsap="mekar" class="font-serif text-xl sm:text-[1.35rem] font-bold text-[#F3E5AB] leading-snug">
                        {{ $cerita['judul'] ?? '' }}
                    </h3>

                    <div data-gsap="garis" class="flex items-center justify-center gap-2.5 px-12" aria-hidden="true">
                        <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#D9B664]/50"></span>
                        <span class="text-[8px] text-[#D9B664]">&#10022;</span>
                        <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#D9B664]/50"></span>
                    </div>

                    <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-[13.5px] text-[#E6EEF8]/85 leading-[1.78] max-w-xs mx-auto">
                        {{ $cerita['cerita'] ?? '' }}
                    </p>
                </div>
            </article>

            @if (! $loop->last)
                <div class="flex flex-col items-center py-1.5" aria-hidden="true">
                    <span class="h-5 w-px border-l border-dashed border-[#D9B664]/70"></span>
                    <span class="my-0.5 flex h-6 w-6 items-center justify-center rounded-full bg-[#132438] border border-[#D9B664]/70 text-[10px] text-[#F3E5AB] shadow-[0_0_14px_rgba(217,182,100,0.5)]">
                        &#10022;
                    </span>
                    <span class="h-5 w-px border-l border-dashed border-[#D9B664]/70"></span>
                </div>
            @endif
        @endforeach
    </div>
</section>
@endif

{{-- SEKSI 8: GALERI KENANGAN (KOLASE EDITORIAL BERVARIASI RASIO CELESTIAL — TERSEMBUNYI SAAT MODE TANPA FOTO) --}}
@if (! $tanpaFoto && $undangan->fiturAktif('galeri') && $undangan->daftarGaleri->isNotEmpty())
@php
    $daftarFotoGaleri = $undangan->daftarGaleri->values();
    $jumlahFotoGaleri = $daftarFotoGaleri->count();
    $blokGaleriCelestial = [];
    $cursorGaleri = 0;

    if ($jumlahFotoGaleri === 2) {
        $blokGaleriCelestial[] = ['tipe' => 'pair-kiri', 'items' => [$daftarFotoGaleri[0], $daftarFotoGaleri[1]]];
        $cursorGaleri = 2;
    } else {
        $blokGaleriCelestial[] = ['tipe' => 'lebar', 'items' => [$daftarFotoGaleri[0]]];
        $cursorGaleri = 1;
        $polaGaleri = ['trio-kiri', 'pair-kiri', 'trio-kanan', 'pair-kanan'];
        $idxPola = 0;

        while ($cursorGaleri < $jumlahFotoGaleri) {
            $sisaGaleri = $jumlahFotoGaleri - $cursorGaleri;
            $tipeSaatIni = $polaGaleri[$idxPola % count($polaGaleri)];

            if ($sisaGaleri === 1) {
                $blokGaleriCelestial[] = ['tipe' => 'lebar', 'items' => [$daftarFotoGaleri[$cursorGaleri]]];
                $cursorGaleri += 1;
            } elseif ($sisaGaleri === 2) {
                $blokGaleriCelestial[] = [
                    'tipe' => ($idxPola % 2 === 0) ? 'pair-kiri' : 'pair-kanan',
                    'items' => [$daftarFotoGaleri[$cursorGaleri], $daftarFotoGaleri[$cursorGaleri + 1]],
                ];
                $cursorGaleri += 2;
            } elseif (in_array($tipeSaatIni, ['trio-kiri', 'trio-kanan'], true) && $sisaGaleri >= 3) {
                $blokGaleriCelestial[] = [
                    'tipe' => $tipeSaatIni,
                    'items' => [
                        $daftarFotoGaleri[$cursorGaleri],
                        $daftarFotoGaleri[$cursorGaleri + 1],
                        $daftarFotoGaleri[$cursorGaleri + 2],
                    ],
                ];
                $cursorGaleri += 3;
            } else {
                $blokGaleriCelestial[] = [
                    'tipe' => $tipeSaatIni,
                    'items' => [$daftarFotoGaleri[$cursorGaleri], $daftarFotoGaleri[$cursorGaleri + 1]],
                ];
                $cursorGaleri += 2;
            }

            $idxPola++;
        }
    }
@endphp

<section
    data-layout-galeri="celestial"
    data-galeri-kolase-heavenly
    class="relative bg-gradient-to-b from-[#07101E] via-[#0A1628] to-[#091322] py-14 px-5 text-white border-t border-[#D9B664]/30 overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-7 overflow-hidden space-y-2">
        <div data-gsap="kanan">
            <p class="scroll-scrub-kanan text-[10px] font-bold uppercase tracking-[0.34em] text-[#D9B664]">Galeri Kenangan</p>
        </div>
        <div data-gsap="kiri" data-gsap-delay="0.06">
            <h2 class="scroll-scrub-kiri font-kaligrafi text-5xl text-[#F3E5AB] leading-tight">Momen Terindah</h2>
        </div>
        <div data-gsap="garis" class="flex items-center justify-center gap-3 text-[10px] font-semibold uppercase tracking-[0.32em] text-[#D9B664]/90 pt-1">
            <span class="h-px w-10 bg-[#D9B664]/50"></span>
            <span>{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</span>
            <span class="h-px w-10 bg-[#D9B664]/50"></span>
        </div>
    </div>

    <div class="max-w-md mx-auto space-y-2.5">
        @foreach ($blokGaleriCelestial as $blok)
            @if ($blok['tipe'] === 'lebar')
                @php $g = $blok['items'][0]; @endphp
                <button
                    type="button"
                    @click="bukaGaleri(@js($g->urlFoto()), @js($g->keterangan))"
                    data-gsap="potret"
                    class="group relative block w-full overflow-hidden rounded-2xl border border-[#D9B664]/55 bg-[#0F1E33] p-1 shadow-xl cursor-pointer kartu-3d aspect-[16/10]"
                >
                    <div class="relative w-full h-full overflow-hidden rounded-[0.8rem]">
                        <img
                            src="{{ $g->urlFoto() }}"
                            alt="{{ $g->keterangan ?? 'Galeri' }}"
                            loading="lazy"
                            decoding="async"
                            class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-700"
                        >
                        @if ($g->keterangan)
                            <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#060D18]/92 via-[#060D18]/45 to-transparent px-3 py-2 text-left text-[10.5px] font-medium text-[#F3E5AB] opacity-0 group-hover:opacity-100 transition duration-300">
                                {{ $g->keterangan }}
                            </span>
                        @endif
                    </div>
                </button>
            @elseif ($blok['tipe'] === 'trio-kiri')
                @php [$gTinggi, $gAtas, $gBawah] = $blok['items']; @endphp
                <div class="grid grid-cols-2 items-stretch gap-2.5">
                    <button
                        type="button"
                        @click="bukaGaleri(@js($gTinggi->urlFoto()), @js($gTinggi->keterangan))"
                        data-gsap="potret"
                        class="group relative w-full h-full min-h-[240px] overflow-hidden rounded-2xl border border-[#D9B664]/55 bg-[#0F1E33] p-1 shadow-lg cursor-pointer kartu-3d"
                    >
                        <div class="relative w-full h-full overflow-hidden rounded-[0.8rem]">
                            <img
                                src="{{ $gTinggi->urlFoto() }}"
                                alt="{{ $gTinggi->keterangan ?? 'Galeri' }}"
                                loading="lazy"
                                decoding="async"
                                class="absolute inset-0 w-full h-full object-cover object-top group-hover:scale-105 transition duration-700"
                            >
                            @if ($gTinggi->keterangan)
                                <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#060D18]/92 via-[#060D18]/45 to-transparent px-2.5 py-2 text-left text-[10px] font-medium text-[#F3E5AB] opacity-0 group-hover:opacity-100 transition duration-300">
                                    {{ $gTinggi->keterangan }}
                                </span>
                            @endif
                        </div>
                    </button>

                    <div class="flex flex-col gap-2.5">
                        @foreach ([$gAtas, $gBawah] as $idxSub => $gSub)
                            <button
                                type="button"
                                @click="bukaGaleri(@js($gSub->urlFoto()), @js($gSub->keterangan))"
                                data-gsap="potret"
                                data-gsap-delay="{{ number_format(($idxSub + 1) * 0.06, 2, '.', '') }}"
                                class="group relative block w-full overflow-hidden rounded-2xl border border-[#D9B664]/55 bg-[#0F1E33] p-1 shadow-lg cursor-pointer kartu-3d aspect-[5/4]"
                            >
                                <div class="relative w-full h-full overflow-hidden rounded-[0.8rem]">
                                    <img
                                        src="{{ $gSub->urlFoto() }}"
                                        alt="{{ $gSub->keterangan ?? 'Galeri' }}"
                                        loading="lazy"
                                        decoding="async"
                                        class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-700"
                                    >
                                    @if ($gSub->keterangan)
                                        <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#060D18]/92 via-[#060D18]/45 to-transparent px-2.5 py-1.5 text-left text-[10px] font-medium text-[#F3E5AB] opacity-0 group-hover:opacity-100 transition duration-300">
                                            {{ $gSub->keterangan }}
                                        </span>
                                    @endif
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>
            @elseif ($blok['tipe'] === 'trio-kanan')
                @php [$gAtas, $gBawah, $gTinggi] = $blok['items']; @endphp
                <div class="grid grid-cols-2 items-stretch gap-2.5">
                    <div class="flex flex-col gap-2.5">
                        @foreach ([$gAtas, $gBawah] as $idxSub => $gSub)
                            <button
                                type="button"
                                @click="bukaGaleri(@js($gSub->urlFoto()), @js($gSub->keterangan))"
                                data-gsap="potret"
                                data-gsap-delay="{{ number_format($idxSub * 0.06, 2, '.', '') }}"
                                class="group relative block w-full overflow-hidden rounded-2xl border border-[#D9B664]/55 bg-[#0F1E33] p-1 shadow-lg cursor-pointer kartu-3d aspect-[5/4]"
                            >
                                <div class="relative w-full h-full overflow-hidden rounded-[0.8rem]">
                                    <img
                                        src="{{ $gSub->urlFoto() }}"
                                        alt="{{ $gSub->keterangan ?? 'Galeri' }}"
                                        loading="lazy"
                                        decoding="async"
                                        class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-700"
                                    >
                                    @if ($gSub->keterangan)
                                        <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#060D18]/92 via-[#060D18]/45 to-transparent px-2.5 py-1.5 text-left text-[10px] font-medium text-[#F3E5AB] opacity-0 group-hover:opacity-100 transition duration-300">
                                            {{ $gSub->keterangan }}
                                        </span>
                                    @endif
                                </div>
                            </button>
                        @endforeach
                    </div>

                    <button
                        type="button"
                        @click="bukaGaleri(@js($gTinggi->urlFoto()), @js($gTinggi->keterangan))"
                        data-gsap="potret"
                        data-gsap-delay="0.08"
                        class="group relative w-full h-full min-h-[240px] overflow-hidden rounded-2xl border border-[#D9B664]/55 bg-[#0F1E33] p-1 shadow-lg cursor-pointer kartu-3d"
                    >
                        <div class="relative w-full h-full overflow-hidden rounded-[0.8rem]">
                            <img
                                src="{{ $gTinggi->urlFoto() }}"
                                alt="{{ $gTinggi->keterangan ?? 'Galeri' }}"
                                loading="lazy"
                                decoding="async"
                                class="absolute inset-0 w-full h-full object-cover object-top group-hover:scale-105 transition duration-700"
                            >
                            @if ($gTinggi->keterangan)
                                <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#060D18]/92 via-[#060D18]/45 to-transparent px-2.5 py-2 text-left text-[10px] font-medium text-[#F3E5AB] opacity-0 group-hover:opacity-100 transition duration-300">
                                    {{ $gTinggi->keterangan }}
                                </span>
                            @endif
                        </div>
                    </button>
                </div>
            @elseif ($blok['tipe'] === 'pair-kiri')
                @php [$gLebar, $gRamping] = $blok['items']; @endphp
                <div class="grid grid-cols-12 items-stretch gap-2.5">
                    <button
                        type="button"
                        @click="bukaGaleri(@js($gLebar->urlFoto()), @js($gLebar->keterangan))"
                        data-gsap="potret"
                        class="col-span-7 group relative overflow-hidden rounded-2xl border border-[#D9B664]/55 bg-[#0F1E33] p-1 shadow-lg cursor-pointer kartu-3d aspect-[4/3]"
                    >
                        <div class="relative w-full h-full overflow-hidden rounded-[0.8rem]">
                            <img
                                src="{{ $gLebar->urlFoto() }}"
                                alt="{{ $gLebar->keterangan ?? 'Galeri' }}"
                                loading="lazy"
                                decoding="async"
                                class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-700"
                            >
                            @if ($gLebar->keterangan)
                                <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#060D18]/92 via-[#060D18]/45 to-transparent px-2.5 py-1.5 text-left text-[10px] font-medium text-[#F3E5AB] opacity-0 group-hover:opacity-100 transition duration-300">
                                    {{ $gLebar->keterangan }}
                                </span>
                            @endif
                        </div>
                    </button>

                    <button
                        type="button"
                        @click="bukaGaleri(@js($gRamping->urlFoto()), @js($gRamping->keterangan))"
                        data-gsap="potret"
                        data-gsap-delay="0.06"
                        class="col-span-5 group relative h-full min-h-[156px] overflow-hidden rounded-2xl border border-[#D9B664]/55 bg-[#0F1E33] p-1 shadow-lg cursor-pointer kartu-3d"
                    >
                        <div class="relative w-full h-full overflow-hidden rounded-[0.8rem]">
                            <img
                                src="{{ $gRamping->urlFoto() }}"
                                alt="{{ $gRamping->keterangan ?? 'Galeri' }}"
                                loading="lazy"
                                decoding="async"
                                class="absolute inset-0 w-full h-full object-cover object-top group-hover:scale-105 transition duration-700"
                            >
                            @if ($gRamping->keterangan)
                                <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#060D18]/92 via-[#060D18]/45 to-transparent px-2.5 py-1.5 text-left text-[10px] font-medium text-[#F3E5AB] opacity-0 group-hover:opacity-100 transition duration-300">
                                    {{ $gRamping->keterangan }}
                                </span>
                            @endif
                        </div>
                    </button>
                </div>
            @else
                @php [$gRamping, $gLebar] = $blok['items']; @endphp
                <div class="grid grid-cols-12 items-stretch gap-2.5">
                    <button
                        type="button"
                        @click="bukaGaleri(@js($gRamping->urlFoto()), @js($gRamping->keterangan))"
                        data-gsap="potret"
                        class="col-span-5 group relative h-full min-h-[156px] overflow-hidden rounded-2xl border border-[#D9B664]/55 bg-[#0F1E33] p-1 shadow-lg cursor-pointer kartu-3d"
                    >
                        <div class="relative w-full h-full overflow-hidden rounded-[0.8rem]">
                            <img
                                src="{{ $gRamping->urlFoto() }}"
                                alt="{{ $gRamping->keterangan ?? 'Galeri' }}"
                                loading="lazy"
                                decoding="async"
                                class="absolute inset-0 w-full h-full object-cover object-top group-hover:scale-105 transition duration-700"
                            >
                            @if ($gRamping->keterangan)
                                <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#060D18]/92 via-[#060D18]/45 to-transparent px-2.5 py-1.5 text-left text-[10px] font-medium text-[#F3E5AB] opacity-0 group-hover:opacity-100 transition duration-300">
                                    {{ $gRamping->keterangan }}
                                </span>
                            @endif
                        </div>
                    </button>

                    <button
                        type="button"
                        @click="bukaGaleri(@js($gLebar->urlFoto()), @js($gLebar->keterangan))"
                        data-gsap="potret"
                        data-gsap-delay="0.06"
                        class="col-span-7 group relative overflow-hidden rounded-2xl border border-[#D9B664]/55 bg-[#0F1E33] p-1 shadow-lg cursor-pointer kartu-3d aspect-[4/3]"
                    >
                        <div class="relative w-full h-full overflow-hidden rounded-[0.8rem]">
                            <img
                                src="{{ $gLebar->urlFoto() }}"
                                alt="{{ $gLebar->keterangan ?? 'Galeri' }}"
                                loading="lazy"
                                decoding="async"
                                class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-700"
                            >
                            @if ($gLebar->keterangan)
                                <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#060D18]/92 via-[#060D18]/45 to-transparent px-2.5 py-1.5 text-left text-[10px] font-medium text-[#F3E5AB] opacity-0 group-hover:opacity-100 transition duration-300">
                                    {{ $gLebar->keterangan }}
                                </span>
                            @endif
                        </div>
                    </button>
                </div>
            @endif
        @endforeach
    </div>

    <div data-gsap="garis" class="mt-7 flex items-center justify-center gap-3 text-[10px] font-semibold uppercase tracking-[0.34em] text-[#D9B664]/85">
        <span class="h-px w-10 bg-[#D9B664]/45"></span>
        <span>{{ $hashtagPasangan }}</span>
        <span class="h-px w-10 bg-[#D9B664]/45"></span>
    </div>
</section>
@endif
