{{-- SEKSI 3: PROFIL MEMPELAI (PAVILIUN KUBAH MIHRAB ZAMRUD-ALABASTER) --}}
<section
    data-layout-mempelai="mihrab"
    class="relative bg-[#F7FBF8] syari-pola-zellige px-4 py-14 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-7">
        {{-- Tajuk Seksi Bermahkota Ornamen Arabesque --}}
        <div class="text-center space-y-2 px-2">
            <div data-gsap="turun">
                <img
                    src="{{ $asetSyari['arabesque'] }}"
                    alt=""
                    loading="lazy"
                    decoding="async"
                    class="w-14 mx-auto drop-shadow-[0_6px_14px_rgba(14,58,54,0.22)] animasi-ayun-3d"
                >
            </div>
            <div data-gsap="mekar" class="flex items-center justify-center gap-2.5 pt-0.5">
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-r from-transparent to-[#C5A059]"></span>
                <span aria-hidden="true" class="w-1.5 h-1.5 rotate-45 bg-[#C5A059]"></span>
                <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7D40]">
                    Bismillahirrahmanirrahim
                </p>
                <span aria-hidden="true" class="w-1.5 h-1.5 rotate-45 bg-[#C5A059]"></span>
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-l from-transparent to-[#C5A059]"></span>
            </div>
            <h2 data-gsap="naik" class="font-serif text-[2rem] sm:text-[2.2rem] font-bold leading-tight text-[#0E3A36]">
                {{ $undangan->teksKustom('judul_mempelai', 'Mempelai Pengantin') }}
            </h2>
            <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-[13px] text-[#0E3A36]/78 max-w-xs mx-auto leading-relaxed">
                {{ $undangan->teksKustom('pengantar_mempelai', 'Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud menyelenggarakan akad nikah & walimatul ursy putra-putri kami:') }}
            </p>
            <svg data-gsap="garis" viewBox="0 0 260 22" class="w-32 mx-auto pt-1 opacity-80" aria-hidden="true">
                <path d="M10 16 H96 Q130 2 164 16 H250" fill="none" stroke="#C5A059" stroke-width="1.6" stroke-linecap="round"/>
                <circle cx="130" cy="11" r="2.2" fill="#0E3A36"/>
            </svg>
        </div>

        {{-- KARTU MEMPELAI PRIA (PAVILIUN KUBAH ZAMRUD-ALABASTER) --}}
        <article class="group relative rounded-[2rem] bg-[#FCFEFD] border-2 border-[#C5A059]/70 shadow-[0_24px_52px_-16px_rgba(14,58,54,0.28)] overflow-hidden kartu-3d">
            <div class="relative bg-gradient-to-b from-[#154E48] via-[#0E3A36] to-[#0A2B28] px-5 pt-7 pb-10 overflow-hidden">
                <div
                    aria-hidden="true"
                    class="pointer-events-none absolute inset-0"
                    style="background: radial-gradient(circle at 50% 45%, rgba(230,209,156,0.22) 0%, rgba(14,58,54,0.06) 50%, rgba(7,29,26,0.58) 100%);"
                ></div>

                {{-- Sepasang Lentera Fanous Mini Di Sudut Atas Kartu --}}
                <svg aria-hidden="true" viewBox="0 0 40 90" class="pointer-events-none absolute top-0 left-3.5 w-7 text-[#E6D19C]/75 ayun-kiri" fill="none" stroke="currentColor" stroke-width="1.2">
                    <line x1="20" y1="0" x2="20" y2="32"/>
                    <path d="M13 39 Q20 32 27 39 L29 54 Q20 63 11 54 Z" fill="currentColor" fill-opacity="0.16"/>
                    <circle cx="20" cy="48" r="2" fill="#FFF5D6" stroke="none"/>
                    <path d="M20 61 L20 71"/>
                    <path d="M20 71 L22.5 76 L20 81 L17.5 76 Z" fill="currentColor" stroke="none"/>
                </svg>
                <svg aria-hidden="true" viewBox="0 0 40 90" class="pointer-events-none absolute top-0 right-3.5 w-7 text-[#E6D19C]/75 ayun-kanan" fill="none" stroke="currentColor" stroke-width="1.2">
                    <line x1="20" y1="0" x2="20" y2="26"/>
                    <path d="M13 33 Q20 26 27 33 L29 48 Q20 57 11 48 Z" fill="currentColor" fill-opacity="0.16"/>
                    <circle cx="20" cy="42" r="2" fill="#FFF5D6" stroke="none"/>
                    <path d="M20 55 L20 65"/>
                    <path d="M20 65 L22.5 70 L20 75 L17.5 70 Z" fill="currentColor" stroke="none"/>
                </svg>

                {{-- Potret Besar Kubah Moorish atau Segel Monogram Rub el Hizb --}}
                <div data-gsap="potret" class="relative z-10 mx-auto flex items-center justify-center">
                    @if (! $tanpaFoto && $undangan->urlFotoPria())
                        <div class="relative">
                            <span aria-hidden="true" class="pointer-events-none absolute -inset-2 rounded-t-[8.5rem] rounded-b-[1.5rem] border border-dashed border-[#E6D19C]/40"></span>
                            <div class="p-[4px] rounded-t-[8rem] rounded-b-[1.3rem] bg-gradient-to-b from-[#F5E7B2] via-[#C5A059] to-[#8C6D32] shadow-[0_18px_36px_rgba(4,16,14,0.62)]">
                                <div class="w-44 sm:w-48 aspect-[4/5] rounded-t-[7.6rem] rounded-b-[1.05rem] overflow-hidden bg-[#08221F]">
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
                            <span aria-hidden="true" class="absolute inset-2 bg-gradient-to-br from-[#17564F] to-[#08221F] border-2 border-[#C5A059] shadow-lg"></span>
                            <span aria-hidden="true" class="absolute inset-2 rotate-45 bg-gradient-to-br from-[#17564F] to-[#08221F] border-2 border-[#C5A059] shadow-lg"></span>
                            <span aria-hidden="true" class="absolute inset-4 border border-[#E6D19C]/35"></span>
                            <div class="relative z-10 text-center">
                                <span class="block text-[8px] uppercase tracking-[0.28em] text-[#E6D19C]/80">Al-&lsquo;Aris</span>
                                <span class="font-serif text-5xl font-bold text-[#F3E5AB] leading-none">{{ $undangan->inisialPria() }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Pita Gelar Emas Bertengger Di Sambungan --}}
            <div data-gsap="mekar" class="relative z-30 -mt-4 flex justify-center">
                <span class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#EFE0B4] via-[#D4B56E] to-[#EFE0B4] px-4 py-1 text-[10px] font-bold uppercase tracking-[0.24em] text-[#092623] border border-[#FFFBF0]/80 shadow-[0_8px_20px_-6px_rgba(14,58,54,0.45)]">
                    <span aria-hidden="true" class="w-1 h-1 rotate-45 bg-[#0E3A36]"></span>
                    <span>Al-&lsquo;Aris &middot; Mempelai Pria</span>
                    <span aria-hidden="true" class="w-1 h-1 rotate-45 bg-[#0E3A36]"></span>
                </span>
            </div>

            {{-- Panel Biografi Alabaster --}}
            <div class="relative px-6 pt-5 pb-7 text-center space-y-2">
                <span aria-hidden="true" class="pointer-events-none absolute bottom-3 left-3 h-4 w-4 border-b border-l border-[#C5A059]/60 rounded-bl-md"></span>
                <span aria-hidden="true" class="pointer-events-none absolute bottom-3 right-3 h-4 w-4 border-b border-r border-[#C5A059]/60 rounded-br-md"></span>

                <h3 data-gsap="kiri" class="font-kaligrafi text-[2.75rem] sm:text-[3rem] leading-[1.08] text-[#0E3A36]">
                    {{ $undangan->nama_panggilan_pria }}
                </h3>
                <p data-gsap="teks" data-gsap-delay="0.06" class="font-serif text-base sm:text-[1.08rem] font-bold tracking-wide text-[#16524C]">
                    {{ $undangan->nama_lengkap_pria }}
                </p>

                @if ($undangan->nama_ayah_pria || $undangan->nama_ibu_pria)
                    <div class="pt-1.5 space-y-1">
                        <div data-gsap="garis" class="flex items-center justify-center gap-2.5 px-12" aria-hidden="true">
                            <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#C5A059]/65"></span>
                            <span class="w-1 h-1 rotate-45 bg-[#C5A059]"></span>
                            <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#C5A059]/65"></span>
                        </div>
                        <p data-gsap="teks" class="text-[10px] font-bold uppercase tracking-[0.24em] text-[#9E7D40] pt-1">
                            {{ $undangan->teksKustom('label_pria', 'Putra dari') }}
                        </p>
                        <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-[13px] font-medium text-[#0E3A36]/82 leading-relaxed max-w-xs mx-auto">
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
                            class="syari-tombol inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-[11px] font-semibold tracking-wide transition active:scale-95"
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

        {{-- PENGHUBUNG BINTANG 8 SUDUT RUB EL HIZB --}}
        <div class="flex items-center justify-center gap-4 py-1" aria-hidden="true">
            <span data-gsap="garis" class="h-px flex-1 max-w-[82px] bg-gradient-to-r from-transparent via-[#C5A059]/70 to-[#C5A059]"></span>
            <div data-gsap="mekar" class="relative h-14 w-14 flex items-center justify-center">
                <span class="absolute inset-1.5 border border-[#C5A059] bg-gradient-to-br from-[#16524C] to-[#0A2B28] shadow-md"></span>
                <span class="absolute inset-1.5 rotate-45 border border-[#C5A059] bg-gradient-to-br from-[#16524C] to-[#0A2B28] shadow-md"></span>
                <span class="relative z-10 font-kaligrafi text-3xl text-[#F3E5AB] leading-none pt-0.5">&amp;</span>
            </div>
            <span data-gsap="garis" class="h-px flex-1 max-w-[82px] bg-gradient-to-l from-transparent via-[#C5A059]/70 to-[#C5A059]"></span>
        </div>

        {{-- KARTU MEMPELAI WANITA (PAVILIUN KUBAH ZAMRUD-ALABASTER) --}}
        <article class="group relative rounded-[2rem] bg-[#FCFEFD] border-2 border-[#C5A059]/70 shadow-[0_24px_52px_-16px_rgba(14,58,54,0.28)] overflow-hidden kartu-3d">
            <div class="relative bg-gradient-to-b from-[#154E48] via-[#0E3A36] to-[#0A2B28] px-5 pt-7 pb-10 overflow-hidden">
                <div
                    aria-hidden="true"
                    class="pointer-events-none absolute inset-0"
                    style="background: radial-gradient(circle at 50% 45%, rgba(230,209,156,0.22) 0%, rgba(14,58,54,0.06) 50%, rgba(7,29,26,0.58) 100%);"
                ></div>

                <svg aria-hidden="true" viewBox="0 0 40 90" class="pointer-events-none absolute top-0 left-3.5 w-7 text-[#E6D19C]/75 ayun-kiri" fill="none" stroke="currentColor" stroke-width="1.2">
                    <line x1="20" y1="0" x2="20" y2="32"/>
                    <path d="M13 39 Q20 32 27 39 L29 54 Q20 63 11 54 Z" fill="currentColor" fill-opacity="0.16"/>
                    <circle cx="20" cy="48" r="2" fill="#FFF5D6" stroke="none"/>
                    <path d="M20 61 L20 71"/>
                    <path d="M20 71 L22.5 76 L20 81 L17.5 76 Z" fill="currentColor" stroke="none"/>
                </svg>
                <svg aria-hidden="true" viewBox="0 0 40 90" class="pointer-events-none absolute top-0 right-3.5 w-7 text-[#E6D19C]/75 ayun-kanan" fill="none" stroke="currentColor" stroke-width="1.2">
                    <line x1="20" y1="0" x2="20" y2="26"/>
                    <path d="M13 33 Q20 26 27 33 L29 48 Q20 57 11 48 Z" fill="currentColor" fill-opacity="0.16"/>
                    <circle cx="20" cy="42" r="2" fill="#FFF5D6" stroke="none"/>
                    <path d="M20 55 L20 65"/>
                    <path d="M20 65 L22.5 70 L20 75 L17.5 70 Z" fill="currentColor" stroke="none"/>
                </svg>

                <div data-gsap="potret" class="relative z-10 mx-auto flex items-center justify-center">
                    @if (! $tanpaFoto && $undangan->urlFotoWanita())
                        <div class="relative">
                            <span aria-hidden="true" class="pointer-events-none absolute -inset-2 rounded-t-[8.5rem] rounded-b-[1.5rem] border border-dashed border-[#E6D19C]/40"></span>
                            <div class="p-[4px] rounded-t-[8rem] rounded-b-[1.3rem] bg-gradient-to-b from-[#F5E7B2] via-[#C5A059] to-[#8C6D32] shadow-[0_18px_36px_rgba(4,16,14,0.62)]">
                                <div class="w-44 sm:w-48 aspect-[4/5] rounded-t-[7.6rem] rounded-b-[1.05rem] overflow-hidden bg-[#08221F]">
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
                            <span aria-hidden="true" class="absolute inset-2 bg-gradient-to-br from-[#17564F] to-[#08221F] border-2 border-[#C5A059] shadow-lg"></span>
                            <span aria-hidden="true" class="absolute inset-2 rotate-45 bg-gradient-to-br from-[#17564F] to-[#08221F] border-2 border-[#C5A059] shadow-lg"></span>
                            <span aria-hidden="true" class="absolute inset-4 border border-[#E6D19C]/35"></span>
                            <div class="relative z-10 text-center">
                                <span class="block text-[8px] uppercase tracking-[0.28em] text-[#E6D19C]/80">Al-&lsquo;Arus</span>
                                <span class="font-serif text-5xl font-bold text-[#F3E5AB] leading-none">{{ $undangan->inisialWanita() }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div data-gsap="mekar" class="relative z-30 -mt-4 flex justify-center">
                <span class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#EFE0B4] via-[#D4B56E] to-[#EFE0B4] px-4 py-1 text-[10px] font-bold uppercase tracking-[0.24em] text-[#092623] border border-[#FFFBF0]/80 shadow-[0_8px_20px_-6px_rgba(14,58,54,0.45)]">
                    <span aria-hidden="true" class="w-1 h-1 rotate-45 bg-[#0E3A36]"></span>
                    <span>Al-&lsquo;Arus &middot; Mempelai Wanita</span>
                    <span aria-hidden="true" class="w-1 h-1 rotate-45 bg-[#0E3A36]"></span>
                </span>
            </div>

            <div class="relative px-6 pt-5 pb-7 text-center space-y-2">
                <span aria-hidden="true" class="pointer-events-none absolute bottom-3 left-3 h-4 w-4 border-b border-l border-[#C5A059]/60 rounded-bl-md"></span>
                <span aria-hidden="true" class="pointer-events-none absolute bottom-3 right-3 h-4 w-4 border-b border-r border-[#C5A059]/60 rounded-br-md"></span>

                <h3 data-gsap="kanan" class="font-kaligrafi text-[2.75rem] sm:text-[3rem] leading-[1.08] text-[#0E3A36]">
                    {{ $undangan->nama_panggilan_wanita }}
                </h3>
                <p data-gsap="teks" data-gsap-delay="0.06" class="font-serif text-base sm:text-[1.08rem] font-bold tracking-wide text-[#16524C]">
                    {{ $undangan->nama_lengkap_wanita }}
                </p>

                @if ($undangan->nama_ayah_wanita || $undangan->nama_ibu_wanita)
                    <div class="pt-1.5 space-y-1">
                        <div data-gsap="garis" class="flex items-center justify-center gap-2.5 px-12" aria-hidden="true">
                            <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#C5A059]/65"></span>
                            <span class="w-1 h-1 rotate-45 bg-[#C5A059]"></span>
                            <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#C5A059]/65"></span>
                        </div>
                        <p data-gsap="teks" class="text-[10px] font-bold uppercase tracking-[0.24em] text-[#9E7D40] pt-1">
                            {{ $undangan->teksKustom('label_wanita', 'Putri dari') }}
                        </p>
                        <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-[13px] font-medium text-[#0E3A36]/82 leading-relaxed max-w-xs mx-auto">
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
                            class="syari-tombol inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-[11px] font-semibold tracking-wide transition active:scale-95"
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

{{-- SEKSI 4A: SLIDESHOW FOTO TRANSISI KE BLOK ZAMRUD (TERSEMBUNYI SAAT MODE TANPA FOTO) --}}
@if ($fotoGaleriSlideshow->isNotEmpty())
<div
    data-slideshow-syari
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
    class="relative h-64 sm:h-72 w-full overflow-hidden bg-[#0E3A36]"
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
        style="background: linear-gradient(180deg, rgba(247,251,248,0.36) 0%, rgba(14,58,54,0.44) 55%, #0E3A36 100%);"
    ></div>
</div>
@endif

{{-- SEKSI 4B: HITUNG MUNDUR KUBAH MIHRAB (BLOK ZAMRUD & 4 UBIN EMAS) --}}
@if ($undangan->fiturAktif('hitung_mundur') && $isoTarget)
<section
    data-layout-countdown="mihrab"
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
    class="relative bg-gradient-to-b from-[#0E3A36] to-[#0A2B28] shadow-[0_-2px_0_0_#0E3A36] text-[#F7FBF8] px-6 py-12 text-center overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-5">
        <img
            src="{{ $asetSyari['arabesque'] }}"
            alt=""
            loading="lazy"
            decoding="async"
            data-gsap="turun"
            class="w-12 mx-auto drop-shadow-lg"
        >

        <div data-gsap="naik" class="space-y-1">
            <p class="text-[10px] font-bold uppercase tracking-[0.36em] text-[#E6D19C]">Menuju Hari Bahagia</p>
            <h2 class="font-kaligrafi text-5xl text-white leading-tight">{{ $undangan->teksKustom('judul_hitung_mundur', 'Save The Date') }}</h2>
        </div>

        {{-- 4 Ubin Kubah Mihrab Emas --}}
        <div class="grid grid-cols-4 gap-2.5 pt-1 panggung-3d">
            @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                <div
                    data-gsap="mekar"
                    data-gsap-delay="{{ number_format($loop->index * 0.07, 2, '.', '') }}"
                    class="rounded-t-full rounded-b-2xl bg-gradient-to-b from-[#F5E6BC] via-[#E5C982] to-[#CFA858] text-[#092623] border border-[#FFF8E4]/75 pt-5 pb-3.5 px-1 shadow-lg"
                >
                    <div
                        class="font-serif text-2xl sm:text-[1.75rem] font-bold leading-none"
                        x-text="{{ $var }}"
                        x-effect="if ({{ $var }}) { $el.classList.remove('angka-flip-3d'); void $el.offsetWidth; $el.classList.add('angka-flip-3d'); }"
                    >00</div>
                    <div class="mt-2 text-[9px] uppercase tracking-[0.2em] font-bold text-[#0E3A36]/85">{{ $label }}</div>
                </div>
            @endforeach
        </div>

        <p data-gsap="teks" class="text-xs text-[#F7FBF8]/82 max-w-xs mx-auto leading-relaxed pt-1">
            {{ $undangan->teksKustom('pengantar_hitung_mundur', 'Merupakan kehormatan dan keberkahan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu.') }}
        </p>

        @if ($googleCalUrl)
            <div data-gsap="mekar" data-gsap-delay="0.08" class="pt-1">
                <a href="{{ $googleCalUrl }}" target="_blank" rel="noopener" class="syari-tombol-emas inline-flex items-center gap-2 rounded-full px-7 py-2.5 text-xs sm:text-sm font-bold uppercase tracking-wider transition active:scale-95">
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

{{-- SEKSI 5: JADWAL AKAD & WALIMAH (PLAKAT LENGKUNG KUBAH MIHRAB ALHAMBRA) --}}
@if ($undangan->daftarAcara->isNotEmpty())
<section
    data-layout-acara="mihrab"
    class="relative bg-[#F7FBF8] syari-pola-zellige px-4 py-14 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-7">
        <div class="text-center space-y-2">
            <img
                src="{{ $asetSyari['arabesque'] }}"
                alt=""
                loading="lazy"
                decoding="async"
                data-gsap="turun"
                class="w-11 mx-auto opacity-95"
            >
            <div data-gsap="mekar" class="flex items-center justify-center gap-2.5">
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-r from-transparent to-[#C5A059]"></span>
                <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7D40]">InsyaAllah Dilaksanakan Pada</p>
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-l from-transparent to-[#C5A059]"></span>
            </div>
            <h2 data-gsap="naik" class="font-serif text-[2rem] sm:text-[2.15rem] font-bold leading-tight text-[#0E3A36]">
                {{ $undangan->teksKustom('judul_acara', 'Jadwal Akad & Walimah') }}
            </h2>
        </div>

        <div class="space-y-6">
            @foreach ($undangan->daftarAcara as $acara)
                @php
                    $nomorAcara = str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT);
                @endphp
                <article class="relative rounded-t-[9.5rem] rounded-b-[1.75rem] bg-[#FCFEFD] border-2 border-[#C5A059]/75 px-5 sm:px-6 pt-10 pb-7 text-center text-[#0E3A36] shadow-[0_20px_46px_-18px_rgba(14,58,54,0.22)] overflow-hidden kartu-3d">
                    {{-- Lapisan Lengkung Mihrab Putus-Putus Konsentris di Dalam Kartu --}}
                    <span aria-hidden="true" class="pointer-events-none absolute inset-2.5 rounded-t-[8.7rem] rounded-b-[1.3rem] border border-dashed border-[#C5A059]/45"></span>

                    {{-- Pendar Alabaster-Emas Lembut di Puncak Kubah --}}
                    <div
                        aria-hidden="true"
                        class="pointer-events-none absolute inset-x-0 top-0 h-32 opacity-70"
                        style="background: radial-gradient(ellipse 72% 85% at 50% 0%, rgba(230,209,156,0.28) 0%, rgba(238,246,241,0.12) 58%, transparent 100%);"
                    ></div>

                    {{-- Ornamen Lentera Fanous Halus Mengapit Lengkung Atas --}}
                    <svg aria-hidden="true" viewBox="0 0 36 80" class="pointer-events-none absolute top-4 left-7 w-6 text-[#C5A059]/65" fill="none" stroke="currentColor" stroke-width="1.2">
                        <line x1="18" y1="0" x2="18" y2="26"/>
                        <path d="M12 32 Q18 26 24 32 L25.5 46 Q18 54 10.5 46 Z" fill="currentColor" fill-opacity="0.14"/>
                        <circle cx="18" cy="40" r="1.8" fill="#C5A059" stroke="none"/>
                        <path d="M18 53 L18 63"/>
                    </svg>
                    <svg aria-hidden="true" viewBox="0 0 36 80" class="pointer-events-none absolute top-4 right-7 w-6 text-[#C5A059]/65" fill="none" stroke="currentColor" stroke-width="1.2">
                        <line x1="18" y1="0" x2="18" y2="20"/>
                        <path d="M12 26 Q18 20 24 26 L25.5 40 Q18 48 10.5 40 Z" fill="currentColor" fill-opacity="0.14"/>
                        <circle cx="18" cy="34" r="1.8" fill="#C5A059" stroke="none"/>
                        <path d="M18 47 L18 57"/>
                    </svg>

                    <div class="relative z-10 space-y-5">
                        {{-- Segel Kubah & Nomor Rangkaian --}}
                        <div class="space-y-2">
                            <div data-gsap="turun" class="relative mx-auto h-12 w-12 flex items-center justify-center">
                                <span aria-hidden="true" class="absolute inset-1 bg-[#0E3A36] border border-[#C5A059]"></span>
                                <span aria-hidden="true" class="absolute inset-1 rotate-45 bg-[#0E3A36] border border-[#C5A059]"></span>
                                <svg class="relative z-10 w-5 h-5 text-[#F3E5AB]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M12 3c2 2.5 5 4.2 5 7.5V20H7v-9.5C7 7.2 10 5.5 12 3Z"/>
                                    <path d="M4 20h16"/>
                                </svg>
                            </div>
                            <p data-gsap="teks" class="text-[9.5px] font-bold uppercase tracking-[0.34em] text-[#9E7D40]">
                                Prosesi {{ $nomorAcara }}
                            </p>
                            <h3 data-gsap="mekar" data-gsap-delay="0.06" class="font-serif text-[1.6rem] sm:text-[1.8rem] font-bold leading-snug text-[#0E3A36] px-3">
                                {{ $acara->nama_acara }}
                            </h3>
                        </div>

                        {{-- Pita 3-Bagian Khas Zellige Andalusia dengan Medali Tanggal Zamrud di Tengah --}}
                        <div class="relative rounded-2xl bg-[#EEF6F1]/90 border border-[#C5A059]/45 px-3 py-4">
                            <div class="grid grid-cols-3 items-center gap-2">
                                <div data-gsap="kiri" class="space-y-0.5">
                                    <p class="text-[9px] font-bold uppercase tracking-[0.24em] text-[#9E7D40]">Hari</p>
                                    <p class="font-serif text-sm sm:text-[15px] font-bold text-[#0E3A36]">
                                        {{ $acara->tanggal_acara->locale('id')->translatedFormat('l') }}
                                    </p>
                                </div>

                                <div data-gsap="mekar" data-gsap-delay="0.06" class="flex flex-col items-center">
                                    <div class="relative h-12 w-12 flex items-center justify-center">
                                        <span aria-hidden="true" class="absolute inset-1 rotate-45 rounded-[4px] bg-[#0E3A36] border border-[#C5A059] shadow-sm"></span>
                                        <span class="relative z-10 font-serif text-xl font-bold text-[#F3E5AB] leading-none">
                                            {{ $acara->tanggal_acara->format('d') }}
                                        </span>
                                    </div>
                                    <p class="mt-1.5 text-[9.5px] font-bold uppercase tracking-[0.16em] text-[#0E3A36]">
                                        {{ $acara->tanggal_acara->locale('id')->translatedFormat('M Y') }}
                                    </p>
                                </div>

                                <div data-gsap="kanan" class="space-y-0.5">
                                    <p class="text-[9px] font-bold uppercase tracking-[0.24em] text-[#9E7D40]">Waktu</p>
                                    <p class="font-serif text-xs sm:text-[13px] font-bold text-[#0E3A36] leading-tight">
                                        {{ \Illuminate\Support\Str::substr($acara->waktu_mulai, 0, 5) }}
                                        @if ($acara->waktu_selesai)
                                            &ndash; {{ \Illuminate\Support\Str::substr($acara->waktu_selesai, 0, 5) }}
                                        @else
                                            &ndash; Selesai
                                        @endif
                                    </p>
                                    <p class="text-[9px] font-semibold uppercase tracking-[0.2em] text-[#9E7D40]">
                                        {{ $acara->zona_waktu }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Panel Lokasi Bersih Bernuansa Sanctuary --}}
                        <div class="rounded-2xl bg-[#F7FBF8] border border-[#0E3A36]/10 px-4 py-4 space-y-2">
                            <div data-gsap="turun" class="inline-flex items-center gap-1.5 text-[9.5px] font-bold uppercase tracking-[0.26em] text-[#9E7D40]">
                                <svg class="w-3.5 h-3.5 text-[#B99348]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7Zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/>
                                </svg>
                                <span>Lokasi Acara</span>
                            </div>
                            <p data-gsap="naik" class="font-serif text-base sm:text-[1.08rem] font-bold text-[#0E3A36] leading-snug">
                                {{ $acara->nama_tempat }}
                            </p>
                            <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-[13px] text-[#0E3A36]/75 leading-relaxed max-w-[285px] mx-auto">
                                {{ $acara->alamat_lengkap }}
                            </p>

                            @if ($acara->link_maps)
                                <div data-gsap="mekar" data-gsap-delay="0.08" class="pt-2">
                                    <a href="{{ $acara->link_maps }}" target="_blank" rel="noopener" class="syari-tombol-emas inline-flex items-center gap-2 rounded-full border border-[#B99348]/60 px-6 py-2.5 text-[11px] font-bold uppercase tracking-[0.14em] transition active:scale-95">
                                        <svg class="w-3.5 h-3.5 text-[#092623]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
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

{{-- SEKSI 6: ADAB BUSANA SYAR'I & LIVE STREAMING (BLOK ZAMRUD ELEGAN) --}}
@if ($adaDressCode || (! empty($live['aktif']) && ! empty($live['link'])))
<section class="relative bg-[#0E3A36] text-[#F7FBF8] px-5 py-11 space-y-5 overflow-hidden">
    @if ($adaDressCode)
        <div data-section-dress-code="mihrab" class="max-w-md mx-auto rounded-3xl bg-[#08221F]/80 border border-[#C5A059]/55 p-6 text-center space-y-3.5">
            <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#E6D19C]">Nuansa Busana Syar&rsquo;i</p>
            @if ($dressCodeCatatan !== '')
                <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-sm text-[#F7FBF8]/90 leading-relaxed">{{ $dressCodeCatatan }}</p>
            @endif
            @if (! empty($dressCodeWarna))
                <div class="flex flex-wrap items-center justify-center gap-4 pt-1">
                    @foreach ($dressCodeWarna as $hex)
                        <div data-gsap="mekar" data-gsap-delay="{{ number_format($loop->index * 0.06, 2, '.', '') }}" class="flex flex-col items-center gap-2">
                            <span class="h-8 w-8 rotate-45 border-2 border-[#E6D19C] shadow-md" style="background-color: {{ $hex }};"></span>
                            <span class="text-[9px] font-mono text-[#F3E5AB]/85">{{ $hex }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    @if (! empty($live['aktif']) && ! empty($live['link']))
        <div class="max-w-md mx-auto rounded-3xl bg-[#F8FCF9] text-[#0E3A36] border-2 border-[#C5A059]/70 p-6 text-center space-y-3 shadow-xl">
            <span data-gsap="turun" class="inline-flex items-center gap-1.5 rounded-full bg-[#0E3A36]/10 border border-[#C5A059]/50 px-3 py-0.5 text-[9.5px] font-bold uppercase tracking-[0.28em] text-[#0E3A36]">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                Siaran Langsung
            </span>
            <h3 data-gsap="naik" class="font-serif text-2xl font-bold text-[#0E3A36]">Live Streaming Akad</h3>
            <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-[13px] text-[#0E3A36]/78 leading-relaxed">
                Saksikan prosesi akad secara daring melalui {{ $live['platform'] ?? 'YouTube Live' }}.
            </p>
            <div data-gsap="mekar" data-gsap-delay="0.08" class="pt-1">
                <a href="{{ $live['link'] }}" target="_blank" rel="noopener" class="syari-tombol inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-xs font-bold uppercase tracking-wider transition active:scale-95">
                    <span>Gabung Siaran</span>
                </a>
            </div>
        </div>
    @endif
</section>
@endif

{{-- SEKSI 7: PERJALANAN TA'ARUF (LEMBARAN MANUSKRIP BERPOROS TENGAH RUB EL HIZB) --}}
@if ($undangan->fiturAktif('cerita_cinta') && ! empty($ceritaList))
<section
    data-layout-cerita="mihrab"
    class="relative bg-[#F7FBF8] syari-pola-zellige px-4 py-14 overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-8 overflow-hidden py-1 space-y-1.5">
        <div data-gsap="kiri">
            <p class="scroll-scrub-kiri text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7D40]">Perjalanan Ta&rsquo;aruf</p>
        </div>
        <div data-gsap="kanan" data-gsap-delay="0.06">
            <h2 class="scroll-scrub-kanan font-serif text-[2rem] sm:text-[2.15rem] font-bold text-[#0E3A36]">{{ $undangan->teksKustom('judul_cerita', 'Kisah Pertemuan') }}</h2>
        </div>
        <div data-gsap="garis" class="flex items-center justify-center gap-2.5 pt-1" aria-hidden="true">
            <span class="h-px w-10 bg-gradient-to-r from-transparent to-[#C5A059]"></span>
            <span class="h-1.5 w-1.5 rotate-45 bg-[#0E3A36]"></span>
            <span class="h-px w-10 bg-gradient-to-l from-transparent to-[#C5A059]"></span>
        </div>
    </div>

    <div class="max-w-md mx-auto">
        @foreach ($ceritaList as $idx => $cerita)
            @php
                $urlFotoBab = (! $tanpaFoto && ! empty($cerita['foto']))
                    ? \App\Support\MediaPublik::url((string) $cerita['foto'])
                    : null;
                $nomorBab = str_pad((string) ($idx + 1), 2, '0', STR_PAD_LEFT);
            @endphp

            <article class="relative rounded-[1.85rem] bg-[#FCFEFD] border border-[#C5A059]/70 px-5 sm:px-6 py-6 text-center shadow-[0_16px_38px_-18px_rgba(14,58,54,0.22)] kartu-3d">
                {{-- Siku Filigree 4 Sudut Manuskrip --}}
                <span aria-hidden="true" class="pointer-events-none absolute top-3 left-3 h-3 w-3 border-t border-l border-[#C5A059]/70"></span>
                <span aria-hidden="true" class="pointer-events-none absolute top-3 right-3 h-3 w-3 border-t border-r border-[#C5A059]/70"></span>
                <span aria-hidden="true" class="pointer-events-none absolute bottom-3 left-3 h-3 w-3 border-b border-l border-[#C5A059]/70"></span>
                <span aria-hidden="true" class="pointer-events-none absolute bottom-3 right-3 h-3 w-3 border-b border-r border-[#C5A059]/70"></span>

                @if ($urlFotoBab)
                    <div data-gsap="potret" class="mx-auto mb-5 p-1.5 rounded-t-[6.5rem] rounded-b-2xl bg-gradient-to-b from-[#E6D19C]/75 via-[#C5A059]/45 to-[#C5A059]/25 max-w-[270px] shadow-sm">
                        <div class="overflow-hidden rounded-t-[6rem] rounded-b-xl aspect-[4/3] bg-[#0E3A36]">
                            <img
                                src="{{ $urlFotoBab }}"
                                alt="{{ $cerita['judul'] ?? 'Kisah Pertemuan' }}"
                                loading="lazy"
                                decoding="async"
                                class="w-full h-full object-cover object-center"
                            >
                        </div>
                    </div>
                @endif

                <div class="space-y-2.5">
                    <div data-gsap="turun" class="flex items-center justify-center gap-2">
                        <span class="text-[9.5px] font-bold uppercase tracking-[0.3em] text-[#9E7D40]">
                            Fase {{ $nomorBab }}
                        </span>
                        @if (! empty($cerita['tanggal']))
                            <span aria-hidden="true" class="h-1 w-1 rotate-45 bg-[#C5A059]"></span>
                            <span class="rounded-full bg-[#0E3A36] border border-[#C5A059]/45 px-3 py-0.5 text-[10px] font-semibold tracking-wider text-[#F3E5AB]">
                                {{ $cerita['tanggal'] }}
                            </span>
                        @endif
                    </div>

                    <h3 data-gsap="mekar" class="font-serif text-xl sm:text-[1.35rem] font-bold text-[#0E3A36] leading-snug">
                        {{ $cerita['judul'] ?? '' }}
                    </h3>

                    <div data-gsap="garis" class="flex items-center justify-center gap-2.5 px-12" aria-hidden="true">
                        <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#C5A059]/55"></span>
                        <span class="h-1.5 w-1.5 rotate-45 bg-[#C5A059]"></span>
                        <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#C5A059]/55"></span>
                    </div>

                    <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-[13.5px] text-[#0E3A36]/82 leading-[1.75] max-w-xs mx-auto">
                        {{ $cerita['cerita'] ?? '' }}
                    </p>
                </div>
            </article>

            {{-- Penghubung Rantai Emas & Bintang 8 Sudut Antar Fase --}}
            @if (! $loop->last)
                <div class="flex flex-col items-center py-1.5" aria-hidden="true">
                    <span class="h-5 w-px bg-gradient-to-b from-[#C5A059] to-[#C5A059]/40"></span>
                    <span class="relative h-5 w-5 flex items-center justify-center my-0.5">
                        <span class="absolute inset-1 bg-[#0E3A36] border border-[#C5A059]"></span>
                        <span class="absolute inset-1 rotate-45 bg-[#0E3A36] border border-[#C5A059]"></span>
                    </span>
                    <span class="h-5 w-px bg-gradient-to-b from-[#C5A059]/40 to-[#C5A059]"></span>
                </div>
            @endif
        @endforeach
    </div>
</section>
@endif

{{-- SEKSI 8: GALERI KENANGAN (KOLASE EDITORIAL BERVARIASI RASIO — TERSEMBUNYI SAAT MODE TANPA FOTO) --}}
@if (! $tanpaFoto && $undangan->fiturAktif('galeri') && $undangan->daftarGaleri->isNotEmpty())
@php
    $daftarFotoGaleri = $undangan->daftarGaleri->values();
    $jumlahFotoGaleri = $daftarFotoGaleri->count();
    $blokGaleriSyari = [];
    $cursorGaleri = 0;

    if ($jumlahFotoGaleri === 2) {
        $blokGaleriSyari[] = ['tipe' => 'pair-kiri', 'items' => [$daftarFotoGaleri[0], $daftarFotoGaleri[1]]];
        $cursorGaleri = 2;
    } else {
        // Foto pembuka lebar sinematik (16:10)
        $blokGaleriSyari[] = ['tipe' => 'lebar', 'items' => [$daftarFotoGaleri[0]]];
        $cursorGaleri = 1;
        $polaGaleri = ['trio-kiri', 'pair-kiri', 'trio-kanan', 'pair-kanan'];
        $idxPola = 0;

        while ($cursorGaleri < $jumlahFotoGaleri) {
            $sisaGaleri = $jumlahFotoGaleri - $cursorGaleri;
            $tipeSaatIni = $polaGaleri[$idxPola % count($polaGaleri)];

            if ($sisaGaleri === 1) {
                $blokGaleriSyari[] = ['tipe' => 'lebar', 'items' => [$daftarFotoGaleri[$cursorGaleri]]];
                $cursorGaleri += 1;
            } elseif ($sisaGaleri === 2) {
                $blokGaleriSyari[] = [
                    'tipe' => ($idxPola % 2 === 0) ? 'pair-kiri' : 'pair-kanan',
                    'items' => [$daftarFotoGaleri[$cursorGaleri], $daftarFotoGaleri[$cursorGaleri + 1]],
                ];
                $cursorGaleri += 2;
            } elseif (in_array($tipeSaatIni, ['trio-kiri', 'trio-kanan'], true) && $sisaGaleri >= 3) {
                $blokGaleriSyari[] = [
                    'tipe' => $tipeSaatIni,
                    'items' => [
                        $daftarFotoGaleri[$cursorGaleri],
                        $daftarFotoGaleri[$cursorGaleri + 1],
                        $daftarFotoGaleri[$cursorGaleri + 2],
                    ],
                ];
                $cursorGaleri += 3;
            } else {
                $blokGaleriSyari[] = [
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
    data-layout-galeri="mihrab"
    data-galeri-kolase-syari
    class="relative bg-[#08221F]/96 py-14 px-5 text-white overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-7 overflow-hidden space-y-2">
        <div data-gsap="kiri">
            <p class="scroll-scrub-kiri text-[10px] font-bold uppercase tracking-[0.34em] text-[#E6D19C]">Galeri Kenangan</p>
        </div>
        <div data-gsap="kanan" data-gsap-delay="0.06">
            <h2 class="scroll-scrub-kanan font-kaligrafi text-5xl text-white leading-tight">{{ $undangan->teksKustom('judul_galeri', 'Momen Terindah') }}</h2>
        </div>
        <div data-gsap="garis" class="flex items-center justify-center gap-3 text-[10px] font-semibold uppercase tracking-[0.32em] text-[#E6D19C]/90 pt-1">
            <span class="h-px w-10 bg-[#E6D19C]/55"></span>
            <span>{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</span>
            <span class="h-px w-10 bg-[#E6D19C]/55"></span>
        </div>
    </div>

    <div class="max-w-md mx-auto space-y-2.5">
        @foreach ($blokGaleriSyari as $blok)
            @if ($blok['tipe'] === 'lebar')
                @php $g = $blok['items'][0]; @endphp
                <button
                    type="button"
                    @click="bukaGaleri(@js($g->urlFoto()), @js($g->keterangan))"
                    data-gsap="potret"
                    class="group relative block w-full overflow-hidden rounded-2xl border border-[#C5A059]/55 bg-[#0E3A36] p-1 shadow-xl cursor-pointer kartu-3d aspect-[16/10]"
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
                            <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#071E1C]/90 via-[#071E1C]/40 to-transparent px-3 py-2 text-left text-[10.5px] font-medium text-[#F3E5AB] opacity-0 group-hover:opacity-100 transition duration-300">
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
                        class="group relative w-full h-full min-h-[240px] overflow-hidden rounded-2xl border border-[#C5A059]/55 bg-[#0E3A36] p-1 shadow-lg cursor-pointer kartu-3d"
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
                                <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#071E1C]/90 via-[#071E1C]/40 to-transparent px-2.5 py-2 text-left text-[10px] font-medium text-[#F3E5AB] opacity-0 group-hover:opacity-100 transition duration-300">
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
                                class="group relative block w-full overflow-hidden rounded-2xl border border-[#C5A059]/55 bg-[#0E3A36] p-1 shadow-lg cursor-pointer kartu-3d aspect-[5/4]"
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
                                        <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#071E1C]/90 via-[#071E1C]/40 to-transparent px-2.5 py-1.5 text-left text-[10px] font-medium text-[#F3E5AB] opacity-0 group-hover:opacity-100 transition duration-300">
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
                                class="group relative block w-full overflow-hidden rounded-2xl border border-[#C5A059]/55 bg-[#0E3A36] p-1 shadow-lg cursor-pointer kartu-3d aspect-[5/4]"
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
                                        <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#071E1C]/90 via-[#071E1C]/40 to-transparent px-2.5 py-1.5 text-left text-[10px] font-medium text-[#F3E5AB] opacity-0 group-hover:opacity-100 transition duration-300">
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
                        class="group relative w-full h-full min-h-[240px] overflow-hidden rounded-2xl border border-[#C5A059]/55 bg-[#0E3A36] p-1 shadow-lg cursor-pointer kartu-3d"
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
                                <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#071E1C]/90 via-[#071E1C]/40 to-transparent px-2.5 py-2 text-left text-[10px] font-medium text-[#F3E5AB] opacity-0 group-hover:opacity-100 transition duration-300">
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
                        class="col-span-7 group relative overflow-hidden rounded-2xl border border-[#C5A059]/55 bg-[#0E3A36] p-1 shadow-lg cursor-pointer kartu-3d aspect-[4/3]"
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
                                <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#071E1C]/90 via-[#071E1C]/40 to-transparent px-2.5 py-1.5 text-left text-[10px] font-medium text-[#F3E5AB] opacity-0 group-hover:opacity-100 transition duration-300">
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
                        class="col-span-5 group relative h-full min-h-[156px] overflow-hidden rounded-2xl border border-[#C5A059]/55 bg-[#0E3A36] p-1 shadow-lg cursor-pointer kartu-3d"
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
                                <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#071E1C]/90 via-[#071E1C]/40 to-transparent px-2.5 py-1.5 text-left text-[10px] font-medium text-[#F3E5AB] opacity-0 group-hover:opacity-100 transition duration-300">
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
                        class="col-span-5 group relative h-full min-h-[156px] overflow-hidden rounded-2xl border border-[#C5A059]/55 bg-[#0E3A36] p-1 shadow-lg cursor-pointer kartu-3d"
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
                                <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#071E1C]/90 via-[#071E1C]/40 to-transparent px-2.5 py-1.5 text-left text-[10px] font-medium text-[#F3E5AB] opacity-0 group-hover:opacity-100 transition duration-300">
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
                        class="col-span-7 group relative overflow-hidden rounded-2xl border border-[#C5A059]/55 bg-[#0E3A36] p-1 shadow-lg cursor-pointer kartu-3d aspect-[4/3]"
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
                                <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#071E1C]/90 via-[#071E1C]/40 to-transparent px-2.5 py-1.5 text-left text-[10px] font-medium text-[#F3E5AB] opacity-0 group-hover:opacity-100 transition duration-300">
                                    {{ $gLebar->keterangan }}
                                </span>
                            @endif
                        </div>
                    </button>
                </div>
            @endif
        @endforeach
    </div>

    <div data-gsap="garis" class="mt-7 flex items-center justify-center gap-3 text-[10px] font-semibold uppercase tracking-[0.34em] text-[#E6D19C]/85">
        <span class="h-px w-10 bg-[#E6D19C]/45"></span>
        <span>{{ $hashtagPasangan }}</span>
        <span class="h-px w-10 bg-[#E6D19C]/45"></span>
    </div>
</section>
@endif
