{{-- SEKSI 4: PASANGAN PANGANTEN PRIANGAN (GALERI POTRET BINGKAI EMAS & ANGGREK BULAN) --}}
<section
    data-layout-mempelai="priangan"
    class="relative px-4 py-14 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-7">
        {{-- Tajuk Seksi Bermahkota Siger Sunda --}}
        <div class="fx-rise text-center space-y-2 px-2">
            <img
                src="{{ $asetSunda['siger'] }}"
                alt=""
                loading="lazy"
                decoding="async"
                class="w-16 mx-auto drop-shadow-[0_6px_14px_rgba(90,30,30,0.28)] animasi-ayun-3d"
            >
            <div class="flex items-center justify-center gap-2.5 pt-0.5">
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-r from-transparent to-[#C59B43]"></span>
                <span aria-hidden="true" class="w-1.5 h-1.5 rotate-45 bg-[#C59B43]"></span>
                <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#8E6620]">
                    Pasangan Panganten
                </p>
                <span aria-hidden="true" class="w-1.5 h-1.5 rotate-45 bg-[#C59B43]"></span>
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-l from-transparent to-[#C59B43]"></span>
            </div>
            <h2 class="font-serif text-[2rem] sm:text-[2.2rem] font-bold leading-tight text-[#5A1E1E]">
                Mempelai Berbahagia
            </h2>
            <p class="text-xs sm:text-[13px] text-[#4A2020]/80 max-w-xs mx-auto leading-relaxed">
                Kalayan nyuhunkeun rido sareng rahmat Gusti Nu Maha Suci, sim kuring nyanggakeun pangulem nikah:
            </p>
            <svg viewBox="0 0 280 24" class="w-36 mx-auto pt-1 opacity-80" aria-hidden="true">
                <path d="M12 18 C36 4 68 4 92 14 C112 2 168 2 188 14 C212 4 244 4 268 18" fill="none" stroke="#C59B43" stroke-width="1.8" stroke-linecap="round"/>
            </svg>
        </div>

        {{-- KARTU PANGANTEN ISTRI (PAVILIUN POTRET MARUN-EMAS PRIANGAN) --}}
        <article class="fx-slide-left group relative rounded-[2rem] bg-[#FFFBF4] border-2 border-[#C59B43]/75 shadow-[0_24px_52px_-16px_rgba(74,23,23,0.34)] overflow-hidden kartu-3d">
            {{-- Panggung Atas Beludru Marun + Bingkai Ukiran Priangan + Bunga Kamelia & Anggrek --}}
            <div class="relative bg-gradient-to-b from-[#5F2222] via-[#4A1717] to-[#3B1414] px-5 pt-7 pb-11 overflow-hidden">
                <img
                    src="{{ $asetSunda['gapura'] }}"
                    alt=""
                    aria-hidden="true"
                    loading="lazy"
                    decoding="async"
                    class="pointer-events-none absolute inset-x-0 top-0 w-full h-full object-cover object-top opacity-[0.14] scale-105"
                >
                <div
                    aria-hidden="true"
                    class="pointer-events-none absolute inset-0"
                    style="background: radial-gradient(circle at 50% 45%, rgba(231,200,125,0.24) 0%, rgba(90,30,30,0.08) 48%, rgba(43,14,14,0.62) 100%);"
                ></div>

                {{-- Untaian Ronce Melati Sudut Kiri & Kanan --}}
                <svg aria-hidden="true" viewBox="0 0 48 130" class="pointer-events-none absolute top-0 left-3 w-8 opacity-80 ayun-kiri">
                    <path d="M16 0 C14 38 20 80 15 118" stroke="#E7C87D" stroke-width="1" fill="none"/>
                    <g fill="#FFFDF8" stroke="#C59B43" stroke-width="0.5">
                        <circle cx="16" cy="18" r="3.4"/><circle cx="15" cy="38" r="3.2"/><circle cx="17" cy="58" r="3.6"/><circle cx="16" cy="78" r="3.2"/><circle cx="15" cy="98" r="3.4"/>
                    </g>
                    <path d="M12 115 L15 127 L18 115 Z" fill="#E7C87D"/>
                </svg>
                <svg aria-hidden="true" viewBox="0 0 48 130" class="pointer-events-none absolute top-0 right-3 w-8 opacity-80 -scale-x-100 ayun-kanan">
                    <path d="M16 0 C14 38 20 80 15 118" stroke="#E7C87D" stroke-width="1" fill="none"/>
                    <g fill="#FFFDF8" stroke="#C59B43" stroke-width="0.5">
                        <circle cx="16" cy="18" r="3.4"/><circle cx="15" cy="38" r="3.2"/><circle cx="17" cy="58" r="3.6"/><circle cx="16" cy="78" r="3.2"/><circle cx="15" cy="98" r="3.4"/>
                    </g>
                    <path d="M12 115 L15 127 L18 115 Z" fill="#E7C87D"/>
                </svg>

                {{-- Potret Besar Panganten Istri di Dalam Bingkai Emas Priangan (780x1043) --}}
                <div class="fx-scale-in relative z-10 mx-auto w-[220px] sm:w-[238px] aspect-[780/1043] flex items-center justify-center">
                    <div class="absolute inset-x-[13.5%] inset-y-[8.5%] rounded-[50%] overflow-hidden bg-[#2E0E0E] shadow-[0_14px_30px_rgba(16,4,4,0.65)]">
                        @if (! $tanpaFoto && $undangan->urlFotoWanita())
                            <img
                                src="{{ $undangan->urlFotoWanita() }}"
                                alt="{{ $undangan->nama_lengkap_wanita }}"
                                loading="lazy"
                                decoding="async"
                                class="w-full h-full object-cover object-top scale-[1.03] group-hover:scale-[1.07] transition duration-700"
                            >
                            <div aria-hidden="true" class="pointer-events-none absolute inset-0 rounded-[50%] shadow-[inset_0_0_24px_rgba(32,10,10,0.42)]"></div>
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center gap-1.5 bg-gradient-to-b from-[#6E2C2C] via-[#4E1A1A] to-[#320F0F] text-[#F3E5AB]">
                                <span class="text-[9px] uppercase tracking-[0.3em] text-[#E7C87D]/80">Panganten</span>
                                <span class="font-serif text-6xl font-bold leading-none drop-shadow">{{ $undangan->inisialWanita() }}</span>
                            </div>
                        @endif
                    </div>

                    <img
                        src="{{ $asetSunda['bingkaiPriangan'] }}"
                        alt=""
                        aria-hidden="true"
                        loading="lazy"
                        decoding="async"
                        class="pointer-events-none relative z-10 w-full h-full object-contain drop-shadow-[0_12px_24px_rgba(20,5,5,0.7)]"
                    >
                </div>

                {{-- Hamparan Bunga Kamelia Marun & Anggrek Bulan Memeluk Bagian Bawah Bingkai --}}
                <img
                    src="{{ $asetSunda['bungaDepan'] }}"
                    alt=""
                    aria-hidden="true"
                    loading="lazy"
                    decoding="async"
                    class="pointer-events-none absolute -bottom-2 inset-x-0 w-full z-20 drop-shadow-[0_-6px_14px_rgba(24,6,6,0.45)]"
                >
            </div>

            {{-- Pita Gelar Panganten Emas Bertengger di Sambungan Panggung --}}
            <div class="relative z-30 -mt-4 flex justify-center">
                <span class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#DFC078] via-[#C59B43] to-[#DFC078] px-4 py-1 text-[10px] font-bold uppercase tracking-[0.26em] text-[#3B1414] border border-[#FFF7E2]/70 shadow-[0_8px_20px_-6px_rgba(59,20,20,0.55)]">
                    <span aria-hidden="true" class="w-1 h-1 rotate-45 bg-[#5A1E1E]"></span>
                    <span>Panganten Istri</span>
                    <span aria-hidden="true" class="w-1 h-1 rotate-45 bg-[#5A1E1E]"></span>
                </span>
            </div>

            {{-- Panel Biografi Gading Hangat Priangan --}}
            <div class="relative px-6 pt-5 pb-7 text-center space-y-2">
                <span aria-hidden="true" class="pointer-events-none absolute bottom-3 left-3 h-4 w-4 border-b border-l border-[#C59B43]/60 rounded-bl-md"></span>
                <span aria-hidden="true" class="pointer-events-none absolute bottom-3 right-3 h-4 w-4 border-b border-r border-[#C59B43]/60 rounded-br-md"></span>

                <h3 class="font-kaligrafi text-[2.85rem] sm:text-[3.1rem] leading-[1.06] text-[#5A1E1E]">
                    {{ $undangan->nama_panggilan_wanita }}
                </h3>
                <p class="font-serif text-base sm:text-[1.08rem] font-bold tracking-wide text-[#4A2020]">
                    {{ $undangan->nama_lengkap_wanita }}
                </p>

                @if ($undangan->nama_ayah_wanita || $undangan->nama_ibu_wanita)
                    <div class="pt-1.5 space-y-1">
                        <div class="flex items-center justify-center gap-2.5 px-12" aria-hidden="true">
                            <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#C59B43]/65"></span>
                            <span class="w-1 h-1 rotate-45 bg-[#C59B43]"></span>
                            <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#C59B43]/65"></span>
                        </div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.24em] text-[#8E6620] pt-1">
                            Putri ti
                        </p>
                        <p class="text-xs sm:text-[13px] font-medium text-[#4A2020]/85 leading-relaxed max-w-xs mx-auto">
                            {{ $undangan->nama_ayah_wanita }} &amp; {{ $undangan->nama_ibu_wanita }}
                        </p>
                    </div>
                @endif

                @if ($instagramWanita !== '')
                    <div class="pt-2.5">
                        <a
                            href="https://instagram.com/{{ $instagramWanita }}"
                            target="_blank"
                            rel="noopener"
                            class="sunda-tombol-marun inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-[11px] font-semibold tracking-wide transition active:scale-95"
                        >
                            <svg class="w-3.5 h-3.5 text-[#E7C87D]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
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

        {{-- SEGEL MEDALI PENGHUBUNG "&" EMAS-MARUN BERORBIT --}}
        <div class="fx-scale-in flex items-center justify-center gap-4 py-1" aria-hidden="true">
            <span class="h-px flex-1 max-w-[82px] bg-gradient-to-r from-transparent via-[#C59B43]/70 to-[#C59B43]"></span>
            <div class="relative w-14 h-14 flex items-center justify-center">
                <span class="absolute -inset-1.5 rounded-full border border-dashed border-[#C59B43]/65 animasi-orbit"></span>
                <div class="w-12 h-12 rounded-full bg-gradient-to-b from-[#6E2C2C] to-[#4A1717] border-2 border-[#E7C87D] shadow-[0_10px_24px_-6px_rgba(90,30,30,0.6)] flex items-center justify-center">
                    <span class="font-kaligrafi text-3xl text-[#F3E5AB] leading-none pt-0.5">&amp;</span>
                </div>
            </div>
            <span class="h-px flex-1 max-w-[82px] bg-gradient-to-l from-transparent via-[#C59B43]/70 to-[#C59B43]"></span>
        </div>

        {{-- KARTU PANGANTEN PAMEGET (PAVILIUN POTRET MARUN-EMAS PRIANGAN) --}}
        <article class="fx-slide-right group relative rounded-[2rem] bg-[#FFFBF4] border-2 border-[#C59B43]/75 shadow-[0_24px_52px_-16px_rgba(74,23,23,0.34)] overflow-hidden kartu-3d">
            {{-- Panggung Atas Beludru Marun + Bingkai Ukiran Priangan + Bunga Kamelia & Anggrek --}}
            <div class="relative bg-gradient-to-b from-[#5F2222] via-[#4A1717] to-[#3B1414] px-5 pt-7 pb-11 overflow-hidden">
                {{-- Siluet Tipis Gapura Priangan & Pendar Emas Hangat di Latar --}}
                <img
                    src="{{ $asetSunda['gapura'] }}"
                    alt=""
                    aria-hidden="true"
                    loading="lazy"
                    decoding="async"
                    class="pointer-events-none absolute inset-x-0 top-0 w-full h-full object-cover object-top opacity-[0.14] scale-105"
                >
                <div
                    aria-hidden="true"
                    class="pointer-events-none absolute inset-0"
                    style="background: radial-gradient(circle at 50% 45%, rgba(231,200,125,0.24) 0%, rgba(90,30,30,0.08) 48%, rgba(43,14,14,0.62) 100%);"
                ></div>

                {{-- Untaian Ronce Melati Sudut Kiri & Kanan --}}
                <svg aria-hidden="true" viewBox="0 0 48 130" class="pointer-events-none absolute top-0 left-3 w-8 opacity-80 ayun-kiri">
                    <path d="M16 0 C14 38 20 80 15 118" stroke="#E7C87D" stroke-width="1" fill="none"/>
                    <g fill="#FFFDF8" stroke="#C59B43" stroke-width="0.5">
                        <circle cx="16" cy="18" r="3.4"/><circle cx="15" cy="38" r="3.2"/><circle cx="17" cy="58" r="3.6"/><circle cx="16" cy="78" r="3.2"/><circle cx="15" cy="98" r="3.4"/>
                    </g>
                    <path d="M12 115 L15 127 L18 115 Z" fill="#E7C87D"/>
                </svg>
                <svg aria-hidden="true" viewBox="0 0 48 130" class="pointer-events-none absolute top-0 right-3 w-8 opacity-80 -scale-x-100 ayun-kanan">
                    <path d="M16 0 C14 38 20 80 15 118" stroke="#E7C87D" stroke-width="1" fill="none"/>
                    <g fill="#FFFDF8" stroke="#C59B43" stroke-width="0.5">
                        <circle cx="16" cy="18" r="3.4"/><circle cx="15" cy="38" r="3.2"/><circle cx="17" cy="58" r="3.6"/><circle cx="16" cy="78" r="3.2"/><circle cx="15" cy="98" r="3.4"/>
                    </g>
                    <path d="M12 115 L15 127 L18 115 Z" fill="#E7C87D"/>
                </svg>

                {{-- Potret Besar Panganten Pameget di Dalam Bingkai Emas Priangan (780x1043) --}}
                <div class="fx-scale-in relative z-10 mx-auto w-[220px] sm:w-[238px] aspect-[780/1043] flex items-center justify-center">
                    <div class="absolute inset-x-[13.5%] inset-y-[8.5%] rounded-[50%] overflow-hidden bg-[#2E0E0E] shadow-[0_14px_30px_rgba(16,4,4,0.65)]">
                        @if (! $tanpaFoto && $undangan->urlFotoPria())
                            <img
                                src="{{ $undangan->urlFotoPria() }}"
                                alt="{{ $undangan->nama_lengkap_pria }}"
                                loading="lazy"
                                decoding="async"
                                class="w-full h-full object-cover object-top scale-[1.03] group-hover:scale-[1.07] transition duration-700"
                            >
                            <div aria-hidden="true" class="pointer-events-none absolute inset-0 rounded-[50%] shadow-[inset_0_0_24px_rgba(32,10,10,0.42)]"></div>
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center gap-1.5 bg-gradient-to-b from-[#6E2C2C] via-[#4E1A1A] to-[#320F0F] text-[#F3E5AB]">
                                <span class="text-[9px] uppercase tracking-[0.3em] text-[#E7C87D]/80">Panganten</span>
                                <span class="font-serif text-6xl font-bold leading-none drop-shadow">{{ $undangan->inisialPria() }}</span>
                            </div>
                        @endif
                    </div>

                    <img
                        src="{{ $asetSunda['bingkaiPriangan'] }}"
                        alt=""
                        aria-hidden="true"
                        loading="lazy"
                        decoding="async"
                        class="pointer-events-none relative z-10 w-full h-full object-contain drop-shadow-[0_12px_24px_rgba(20,5,5,0.7)]"
                    >
                </div>

                {{-- Hamparan Bunga Kamelia Marun & Anggrek Bulan Memeluk Bagian Bawah Bingkai --}}
                <img
                    src="{{ $asetSunda['bungaDepan'] }}"
                    alt=""
                    aria-hidden="true"
                    loading="lazy"
                    decoding="async"
                    class="pointer-events-none absolute -bottom-2 inset-x-0 w-full z-20 drop-shadow-[0_-6px_14px_rgba(24,6,6,0.45)]"
                >
            </div>

            {{-- Pita Gelar Panganten Emas Bertengger di Sambungan Panggung --}}
            <div class="relative z-30 -mt-4 flex justify-center">
                <span class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#DFC078] via-[#C59B43] to-[#DFC078] px-4 py-1 text-[10px] font-bold uppercase tracking-[0.26em] text-[#3B1414] border border-[#FFF7E2]/70 shadow-[0_8px_20px_-6px_rgba(59,20,20,0.55)]">
                    <span aria-hidden="true" class="w-1 h-1 rotate-45 bg-[#5A1E1E]"></span>
                    <span>Panganten Pameget</span>
                    <span aria-hidden="true" class="w-1 h-1 rotate-45 bg-[#5A1E1E]"></span>
                </span>
            </div>

            {{-- Panel Biografi Gading Hangat Priangan --}}
            <div class="relative px-6 pt-5 pb-7 text-center space-y-2">
                <span aria-hidden="true" class="pointer-events-none absolute bottom-3 left-3 h-4 w-4 border-b border-l border-[#C59B43]/60 rounded-bl-md"></span>
                <span aria-hidden="true" class="pointer-events-none absolute bottom-3 right-3 h-4 w-4 border-b border-r border-[#C59B43]/60 rounded-br-md"></span>

                <h3 class="font-kaligrafi text-[2.85rem] sm:text-[3.1rem] leading-[1.06] text-[#5A1E1E]">
                    {{ $undangan->nama_panggilan_pria }}
                </h3>
                <p class="font-serif text-base sm:text-[1.08rem] font-bold tracking-wide text-[#4A2020]">
                    {{ $undangan->nama_lengkap_pria }}
                </p>

                @if ($undangan->nama_ayah_pria || $undangan->nama_ibu_pria)
                    <div class="pt-1.5 space-y-1">
                        <div class="flex items-center justify-center gap-2.5 px-12" aria-hidden="true">
                            <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#C59B43]/65"></span>
                            <span class="w-1 h-1 rotate-45 bg-[#C59B43]"></span>
                            <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#C59B43]/65"></span>
                        </div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.24em] text-[#8E6620] pt-1">
                            Putra ti
                        </p>
                        <p class="text-xs sm:text-[13px] font-medium text-[#4A2020]/85 leading-relaxed max-w-xs mx-auto">
                            {{ $undangan->nama_ayah_pria }} &amp; {{ $undangan->nama_ibu_pria }}
                        </p>
                    </div>
                @endif

                @if ($instagramPria !== '')
                    <div class="pt-2.5">
                        <a
                            href="https://instagram.com/{{ $instagramPria }}"
                            target="_blank"
                            rel="noopener"
                            class="sunda-tombol-marun inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-[11px] font-semibold tracking-wide transition active:scale-95"
                        >
                            <svg class="w-3.5 h-3.5 text-[#E7C87D]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
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
    </div>
</section>

{{-- SEKSI 5A: SLIDESHOW FOTO TRANSISI KE BLOK MARUN (BERSIH TANPA BULLET) --}}
@if ($fotoGaleriSlideshow->isNotEmpty())
<div
    data-slideshow-sunda
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
    class="relative h-72 w-full overflow-hidden bg-[#5A1E1E]"
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
        style="background: linear-gradient(180deg, rgba(250,244,232,0.34) 0%, rgba(90,30,30,0.42) 55%, #5A1E1E 100%);"
    ></div>
</div>
@endif

{{-- SEKSI 5B: SAVE THE DATE & HITUNG MUNDUR (BLOK MARUN PRIANGAN) --}}
@if ($undangan->fiturAktif('hitung_mundur') && $isoTarget)
<section
    data-layout-countdown="priangan"
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
    class="relative bg-gradient-to-b from-[#5A1E1E] to-[#4B1818] shadow-[0_-2px_0_0_#5A1E1E] text-[#FAF4E8] px-6 py-12 text-center overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-5">
        <img
            src="{{ $asetSunda['siger'] }}"
            alt=""
            loading="lazy"
            decoding="async"
            class="fx-rise-down w-14 mx-auto drop-shadow-lg"
        >

        <div class="fx-rise space-y-1">
            <h2 class="font-kaligrafi text-5xl text-white leading-tight">Save The Date</h2>
        </div>

        <div class="grid grid-cols-4 gap-2.5 pt-1 panggung-3d">
            @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                <div class="rounded-2xl bg-[#E7C87D] text-[#3B1414] py-3.5 px-1.5 shadow-lg border border-[#F3E5AB]/65">
                    <div
                        class="font-serif text-2xl sm:text-3xl font-bold leading-none"
                        x-text="{{ $var }}"
                        x-effect="if ({{ $var }}) { $el.classList.remove('angka-flip-3d'); void $el.offsetWidth; $el.classList.add('angka-flip-3d'); }"
                    >00</div>
                    <div class="mt-1.5 text-[10px] uppercase tracking-wider font-semibold text-[#5A1E1E]">{{ $label }}</div>
                </div>
            @endforeach
        </div>

        <p class="text-xs text-[#FAF4E8]/85 max-w-xs mx-auto leading-relaxed pt-1">
            Merupakan kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu.
        </p>

        @if ($googleCalUrl)
            <div class="pt-1">
                <a
                    href="{{ $googleCalUrl }}"
                    target="_blank"
                    rel="noopener"
                    class="sunda-tombol-emas inline-flex items-center gap-2 rounded-full px-7 py-2.5 text-xs sm:text-sm font-semibold transition"
                >
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect width="18" height="18" x="3" y="4" rx="2"/>
                        <line x1="16" x2="16" y1="2" y2="6"/>
                        <line x1="8" x2="8" y1="2" y2="6"/>
                        <line x1="3" x2="21" y1="10" y2="10"/>
                    </svg>
                    <span>Simpan ke Kalender</span>
                </a>
            </div>
        @endif
    </div>
</section>
@endif

{{-- SEKSI 6: RANGKAIAN ACARA — PIAGAM ELEGAN PRIANGAN (BERSIH, BERSAHAJA & MEWAH) --}}
@if ($undangan->daftarAcara->isNotEmpty())
<section
    data-layout-acara="priangan"
    class="relative px-4 py-14 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-6">
        {{-- Tajuk Seksi Bersih & Terukur --}}
        <div class="fx-rise text-center space-y-1.5">
            <div class="flex items-center justify-center gap-2.5">
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-r from-transparent to-[#C59B43]"></span>
                <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#8E6620]">
                    Waktos &amp; Tempat
                </p>
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-l from-transparent to-[#C59B43]"></span>
            </div>
            <h2 class="font-serif text-[2rem] sm:text-[2.15rem] font-bold leading-tight text-[#5A1E1E]">
                Rangkaian Acara
            </h2>
        </div>

        <div class="space-y-5">
            @foreach ($undangan->daftarAcara as $acara)
                @php
                    $nomorProsesi = str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT);
                    $kelasGerakAcara = $loop->even ? 'fx-slide-right' : 'fx-slide-left';
                @endphp

                <article class="{{ $kelasGerakAcara }} relative rounded-[1.75rem] bg-[#FFFBF4] border border-[#C59B43]/70 overflow-hidden shadow-[0_18px_42px_-16px_rgba(74,23,23,0.24)] kartu-3d">
                    {{-- Header Pita Marun Rapi & Berkelas --}}
                    <div class="relative bg-gradient-to-b from-[#602121] to-[#4A1717] px-6 py-5 text-center text-[#FAF4E8] border-b border-[#C59B43]/65">
                        <span aria-hidden="true" class="pointer-events-none absolute top-2.5 left-2.5 h-3 w-3 border-t border-l border-[#E7C87D]/55 rounded-tl-sm"></span>
                        <span aria-hidden="true" class="pointer-events-none absolute top-2.5 right-2.5 h-3 w-3 border-t border-r border-[#E7C87D]/55 rounded-tr-sm"></span>

                        <p class="text-[9.5px] font-bold uppercase tracking-[0.32em] text-[#E7C87D]">
                            Prosesi {{ $nomorProsesi }} &bull; {{ $acara->tanggal_acara->locale('id')->translatedFormat('l') }}
                        </p>
                        <h3 class="mt-1 font-kaligrafi text-[2.4rem] sm:text-[2.65rem] leading-[1.08] text-[#FFFDF8]">
                            {{ $acara->nama_acara }}
                        </h3>
                    </div>

                    {{-- Badan Piagam Lega & Rapi Tanpa Ornamen Berlebihan --}}
                    <div class="px-6 py-7 text-center text-[#4A2020] space-y-5">
                        {{-- Baris Tanggal & Waktu 2 Kolom Simetris --}}
                        <div class="flex items-center justify-center gap-5">
                            <div class="flex items-center gap-2.5 text-left">
                                <span class="font-serif text-[2.45rem] font-bold leading-none text-[#5A1E1E]">
                                    {{ $acara->tanggal_acara->format('d') }}
                                </span>
                                <div class="leading-tight">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.12em] text-[#5A1E1E]">
                                        {{ $acara->tanggal_acara->locale('id')->translatedFormat('F') }}
                                    </p>
                                    <p class="text-[11px] font-semibold tracking-[0.16em] text-[#8E6620]">
                                        {{ $acara->tanggal_acara->format('Y') }}
                                    </p>
                                </div>
                            </div>

                            <span aria-hidden="true" class="h-9 w-px bg-[#C59B43]/45"></span>

                            <div class="text-left leading-tight">
                                <p class="text-[9.5px] font-bold uppercase tracking-[0.22em] text-[#8E6620]">
                                    Pukul
                                </p>
                                <p class="mt-0.5 text-xs sm:text-[13px] font-bold text-[#5A1E1E]">
                                    {{ \Illuminate\Support\Str::substr($acara->waktu_mulai, 0, 5) }}
                                    @if ($acara->waktu_selesai)
                                        &ndash; {{ \Illuminate\Support\Str::substr($acara->waktu_selesai, 0, 5) }}
                                    @else
                                        &ndash; Selesai
                                    @endif
                                    <span class="font-semibold text-[#8E6620]">{{ $acara->zona_waktu }}</span>
                                </p>
                            </div>
                        </div>

                        {{-- Garis Pemisah Emas Halus --}}
                        <div class="flex items-center justify-center gap-3 px-10" aria-hidden="true">
                            <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#C59B43]/55"></span>
                            <span class="w-1.5 h-1.5 rotate-45 bg-[#C59B43]"></span>
                            <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#C59B43]/55"></span>
                        </div>

                        {{-- Lokasi Acara Bersih --}}
                        <div class="space-y-1.5">
                            <svg class="w-4 h-4 mx-auto text-[#B58931]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7Zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/>
                            </svg>
                            <p class="font-serif text-base sm:text-[1.08rem] font-bold text-[#5A1E1E] leading-snug">
                                {{ $acara->nama_tempat }}
                            </p>
                            <p class="text-xs sm:text-[13px] text-[#4A2020]/75 leading-relaxed max-w-[275px] mx-auto">
                                {{ $acara->alamat_lengkap }}
                            </p>
                        </div>

                        @if ($acara->link_maps)
                            <div class="pt-1">
                                <a
                                    href="{{ $acara->link_maps }}"
                                    target="_blank"
                                    rel="noopener"
                                    class="sunda-tombol-marun inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-xs font-bold uppercase tracking-[0.14em] transition active:scale-95"
                                >
                                    <svg class="w-3.5 h-3.5 text-[#E7C87D]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7Zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/>
                                    </svg>
                                    <span>Buka Google Maps</span>
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

{{-- SEKSI 7: DRESS CODE & LIVE STREAMING (OPSIONAL) --}}
@if ($adaDressCode || (! empty($live['aktif']) && ! empty($live['link'])))
<section class="relative bg-[#5A1E1E] text-[#FAF4E8] px-5 py-11 space-y-5 overflow-hidden">
    @if ($adaDressCode)
        <div data-section-dress-code="priangan" class="fx-rise max-w-md mx-auto rounded-3xl bg-[#3B1414]/80 border border-[#C59B43]/55 p-6 text-center space-y-3">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#E7C87D]">Raksukan / Dress Code</p>
            @if ($dressCodeCatatan !== '')
                <p class="text-xs sm:text-sm text-[#FAF4E8]/90 leading-relaxed">{{ $dressCodeCatatan }}</p>
            @endif
            @if (! empty($dressCodeWarna))
                <div class="flex flex-wrap items-center justify-center gap-3 pt-1">
                    @foreach ($dressCodeWarna as $hex)
                        <div class="flex flex-col items-center gap-1">
                            <span class="h-9 w-9 rounded-full border-2 border-[#F3E5AB] shadow-md" style="background-color: {{ $hex }};"></span>
                            <span class="text-[9px] font-mono text-[#F3E5AB]/80">{{ $hex }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    @if (! empty($live['aktif']) && ! empty($live['link']))
        <div class="fx-rise max-w-md mx-auto rounded-3xl bg-[#FFFBF4] text-[#4A2020] border-2 border-[#C59B43]/70 p-6 text-center space-y-3 shadow-xl">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#8E6620]">Siaran Langsung</p>
            <h3 class="font-serif text-2xl font-bold text-[#5A1E1E]">Live Streaming</h3>
            <p class="text-xs text-[#4A2020]/75 leading-relaxed">
                Saksikan prosesi ijab qabul sareng sawer panganten secara langsung melalui {{ $live['platform'] ?? 'YouTube Live' }}.
            </p>
            <a
                href="{{ $live['link'] }}"
                target="_blank"
                rel="noopener"
                class="sunda-tombol-marun inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-xs font-bold uppercase tracking-wider transition"
            >
                <span>Tonton Live Streaming</span>
            </a>
        </div>
    @endif
</section>
@endif

{{-- SEKSI 8: LALAKON TRESNA / CERITA CINTA (KARTU ZIG-ZAG KIRI-KANAN + FOTO PER-BAB) --}}
@if ($undangan->fiturAktif('cerita_cinta') && ! empty($ceritaList))
<section
    data-layout-cerita="priangan"
    class="relative px-4 py-12 overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-7 overflow-hidden py-1">
        <p class="scroll-scrub-kiri text-[11px] font-bold uppercase tracking-[0.34em] text-[#8E6620]">Lalakon Tresna</p>
        <h2 class="scroll-scrub-kanan mt-1 font-serif text-3xl font-bold text-[#5A1E1E]">Cerita Cinta</h2>
    </div>

    <div class="max-w-md mx-auto space-y-4">
        @foreach ($ceritaList as $idx => $cerita)
            @php
                $urlFotoBab = (! $tanpaFoto && ! empty($cerita['foto']))
                    ? \App\Support\MediaPublik::url((string) $cerita['foto'])
                    : null;
            @endphp
            <article class="{{ $idx % 2 === 0 ? 'fx-slide-left mr-4' : 'fx-slide-right ml-4' }} rounded-3xl bg-[#FFFBF4] border-2 border-[#C59B43]/60 p-4 sm:p-5 text-[#4A2020] shadow-lg kartu-3d">
                @if ($urlFotoBab)
                    <div class="mb-3 overflow-hidden rounded-2xl border border-[#C59B43]/45">
                        <img
                            src="{{ $urlFotoBab }}"
                            alt="{{ $cerita['judul'] ?? 'Cerita Cinta' }}"
                            class="w-full aspect-[16/10] object-cover object-center"
                        >
                    </div>
                @endif
                <div class="flex items-center justify-between gap-2">
                    <span class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-[#8E6620]">
                        <span aria-hidden="true" class="w-1.5 h-1.5 rotate-45 bg-[#C59B43]"></span>
                        <span>Bab {{ $idx + 1 }}</span>
                    </span>
                    @if (! empty($cerita['tanggal']))
                        <span class="rounded-full bg-[#5A1E1E] px-2.5 py-0.5 text-[10px] font-semibold text-[#FAF4E8]">{{ $cerita['tanggal'] }}</span>
                    @endif
                </div>
                <h3 class="mt-2 font-serif text-lg font-bold text-[#5A1E1E]">{{ $cerita['judul'] ?? '' }}</h3>
                <p class="mt-1 text-xs sm:text-sm text-[#4A2020]/80 leading-relaxed">{{ $cerita['cerita'] ?? '' }}</p>
            </article>
        @endforeach
    </div>
</section>
@endif

{{-- SEKSI 9: OUR GALLERY (GRID & HOVER SELARAS ADAT JAWA, PALET MARUN-EMAS PRIANGAN) --}}
@if (! $tanpaFoto && $undangan->fiturAktif('galeri') && $undangan->daftarGaleri->isNotEmpty())
<section
    data-layout-galeri="priangan"
    class="relative bg-[#3B1414]/95 py-14 px-5 text-white overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-6 overflow-hidden space-y-2">
        <h2 class="scroll-scrub-kiri font-kaligrafi text-5xl text-white leading-tight">Our Gallery</h2>
        <div class="scroll-scrub-kanan flex items-center justify-center gap-3 text-[10px] font-semibold uppercase tracking-[0.34em] text-[#E7C87D]">
            <span class="h-px w-10 bg-[#E7C87D]/60"></span>
            <span>{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</span>
            <span class="h-px w-10 bg-[#E7C87D]/60"></span>
        </div>
    </div>

    <div class="grid grid-cols-12 items-stretch gap-3">
        @foreach ($undangan->daftarGaleri as $galeri)
            @php
                $kelasTile = \App\Support\DataTemaUndangan::kelasGridGaleri($loop->index, $loop->count, 'keraton');
            @endphp
            <button
                type="button"
                @click="bukaGaleri(@js($galeri->urlFoto()), @js($galeri->keterangan))"
                class="fx-scale-in group relative overflow-hidden border border-[#E7C87D]/55 bg-[#2B0E0E] shadow-xl cursor-pointer kartu-3d {{ $kelasTile }}"
            >
                <img
                    src="{{ $galeri->urlFoto() }}"
                    alt="{{ $galeri->keterangan ?? 'Galeri Foto' }}"
                    loading="lazy"
                    decoding="async"
                    class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-700"
                >
                @if ($galeri->keterangan)
                    <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#2B0E0E]/90 via-[#2B0E0E]/35 to-transparent px-3 py-2 text-left text-[10.5px] font-medium text-[#FAF4E8] opacity-0 group-hover:opacity-100 transition duration-300">
                        {{ $galeri->keterangan }}
                    </span>
                @endif
            </button>
        @endforeach
    </div>

    <div class="mt-7 flex items-center justify-center gap-3 text-[10px] font-semibold uppercase tracking-[0.34em] text-[#E7C87D]/85">
        <span class="h-px w-10 bg-[#E7C87D]/50"></span>
        <span>{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</span>
        <span class="h-px w-10 bg-[#E7C87D]/50"></span>
    </div>
</section>
@endif
