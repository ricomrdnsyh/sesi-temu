{{-- SEKSI 3: PROFIL MEMPELAI — GRAND BALLROOM SPOTLIGHT DOSSIER (URUTAN SERAGAM SEMUA KATEGORI) --}}
<section
    id="elegan-mempelai"
    data-kartu-tumpuk
    data-layout-mempelai="artdeco"
    class="noir-kartu-tumpuk relative bg-gradient-to-b from-[#0E0D15] via-[#0B0B0F] to-[#0E0D14] px-4 py-14 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-7">
        <div class="text-center space-y-2 px-2">
            <div data-gsap="turun">
                <img src="{{ $asetNoir['emas'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async" class="w-11 mx-auto opacity-95 animasi-ayun-3d">
            </div>
            <p data-gsap="mekar" class="text-[10px] font-semibold uppercase tracking-[0.38em] text-[#D4AF37]">The Couple</p>
            <h2 data-gsap="naik" class="noir-font-judul text-2xl sm:text-3xl font-bold tracking-wider text-white">{{ $undangan->teksKustom('judul_mempelai', 'Mempelai Berbahagia') }}</h2>
            <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-[13px] text-[#F5EFE6]/78 max-w-xs mx-auto leading-relaxed">
                {{ $undangan->teksKustom('pengantar_mempelai', 'Dengan memohon rahmat dan ridho Tuhan Yang Maha Esa, kami bermaksud menyelenggarakan pernikahan putra-putri kami:') }}
            </p>
        </div>

        {{-- KARTU MEMPELAI PRIA (PANGGUNG POTRET ART DECO + SUDUT EMAS) --}}
        <article class="group relative rounded-2xl bg-[#15141B] border border-[#D4AF37]/55 shadow-[0_26px_54px_-18px_rgba(0,0,0,0.88)] overflow-hidden kartu-3d efek-shimmer-kartu">
            <span aria-hidden="true" class="pointer-events-none absolute top-2.5 left-2.5 h-4 w-4 border-t-2 border-l-2 border-[#D4AF37] z-20"></span>
            <span aria-hidden="true" class="pointer-events-none absolute top-2.5 right-2.5 h-4 w-4 border-t-2 border-r-2 border-[#D4AF37] z-20"></span>
            <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 left-2.5 h-4 w-4 border-b-2 border-l-2 border-[#D4AF37] z-20"></span>
            <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 right-2.5 h-4 w-4 border-b-2 border-r-2 border-[#D4AF37] z-20"></span>

            @if (! $tanpaFoto && $undangan->urlFotoPria())
                <div data-gsap="potret" class="relative aspect-[4/4.3] w-full overflow-hidden bg-[#09090D]">
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
                        style="background: linear-gradient(180deg, rgba(9,9,13,0.32) 0%, rgba(9,9,13,0) 34%, rgba(21,20,27,0.68) 76%, #15141B 100%);"
                    ></div>
                    <span class="absolute top-4 left-4 inline-flex items-center gap-1.5 rounded-full bg-[#09090D]/80 backdrop-blur-md border border-[#D4AF37]/55 px-3.5 py-1 text-[9px] font-bold uppercase tracking-[0.26em] text-[#F3E5AB]">
                        <span class="h-1.5 w-1.5 rotate-45 bg-[#D4AF37]"></span>
                        <span>Mempelai Pria</span>
                    </span>
                </div>
            @else
                <div data-gsap="potret" class="pt-8 pb-3 flex flex-col items-center justify-center gap-2.5">
                    <div class="relative mx-auto w-24 h-24 flex items-center justify-center">
                        <span aria-hidden="true" class="absolute inset-0 rounded-full border border-dashed border-[#D4AF37]/65 animasi-orbit"></span>
                        <span aria-hidden="true" class="absolute inset-2 rounded-full border border-[#F3E5AB]/45 animasi-orbit-balik"></span>
                        <span class="noir-font-judul text-3xl font-bold text-[#F3E5AB]">{{ $undangan->inisialPria() }}</span>
                    </div>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-[#09090D] border border-[#D4AF37]/50 px-3.5 py-1 text-[9px] font-bold uppercase tracking-[0.26em] text-[#D4AF37]">
                        Mempelai Pria
                    </span>
                </div>
            @endif

            <div class="relative px-6 {{ (! $tanpaFoto && $undangan->urlFotoPria()) ? '-mt-2 pt-0' : 'pt-2' }} pb-8 text-center space-y-2">
                <h3 data-gsap="kiri" data-gsap-delay="0.05" class="noir-font-judul text-2xl sm:text-3xl font-bold tracking-wider text-[#F3E5AB]">
                    {{ $undangan->nama_panggilan_pria }}
                </h3>
                <p data-gsap="teks" data-gsap-delay="0.08" class="font-serif text-base font-semibold text-white">
                    {{ $undangan->nama_lengkap_pria }}
                </p>

                @if ($undangan->nama_ayah_pria || $undangan->nama_ibu_pria)
                    <div class="pt-1 space-y-1">
                        <div data-gsap="garis" class="flex items-center justify-center gap-2.5 px-12" aria-hidden="true">
                            <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#D4AF37]/55"></span>
                            <span class="w-1 h-1 rotate-45 bg-[#D4AF37]"></span>
                            <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#D4AF37]/55"></span>
                        </div>
                        <p data-gsap="teks" class="text-[9.5px] font-bold uppercase tracking-[0.24em] text-[#D4AF37] pt-0.5">{{ $undangan->teksKustom('label_pria', 'Putra dari') }}</p>
                        <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-[13px] text-[#F5EFE6]/80 leading-relaxed max-w-xs mx-auto">
                            {{ $undangan->nama_ayah_pria }} &amp; {{ $undangan->nama_ibu_pria }}
                        </p>
                    </div>
                @endif

                @if ($instagramPria !== '')
                    <div data-gsap="mekar" data-gsap-delay="0.10" class="pt-2">
                        <a
                            href="https://instagram.com/{{ $instagramPria }}"
                            target="_blank"
                            rel="noopener"
                            class="noir-tombol-obsidian inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-[11px] font-semibold tracking-wide transition active:scale-95"
                        >
                            <svg class="w-3.5 h-3.5 text-[#D4AF37]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
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

        {{-- PEMISAH BERLIAN ART DECO --}}
        <div class="flex items-center justify-center gap-4 px-6" aria-hidden="true">
            <span data-gsap="garis" class="h-px flex-1 bg-gradient-to-r from-transparent to-[#D4AF37]/75"></span>
            <span data-gsap="mekar" class="relative w-10 h-10 flex items-center justify-center">
                <span class="absolute inset-0 rotate-45 border border-[#D4AF37]/65 bg-[#15141B]"></span>
                <span class="relative font-kaligrafi text-2xl text-[#F3E5AB] leading-none">&amp;</span>
            </span>
            <span data-gsap="garis" class="h-px flex-1 bg-gradient-to-l from-transparent to-[#D4AF37]/75"></span>
        </div>

        {{-- KARTU MEMPELAI WANITA (PANGGUNG POTRET ART DECO + SUDUT EMAS) --}}
        <article class="group relative rounded-2xl bg-[#15141B] border border-[#D4AF37]/55 shadow-[0_26px_54px_-18px_rgba(0,0,0,0.88)] overflow-hidden kartu-3d efek-shimmer-kartu">
            <span aria-hidden="true" class="pointer-events-none absolute top-2.5 left-2.5 h-4 w-4 border-t-2 border-l-2 border-[#D4AF37] z-20"></span>
            <span aria-hidden="true" class="pointer-events-none absolute top-2.5 right-2.5 h-4 w-4 border-t-2 border-r-2 border-[#D4AF37] z-20"></span>
            <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 left-2.5 h-4 w-4 border-b-2 border-l-2 border-[#D4AF37] z-20"></span>
            <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 right-2.5 h-4 w-4 border-b-2 border-r-2 border-[#D4AF37] z-20"></span>

            @if (! $tanpaFoto && $undangan->urlFotoWanita())
                <div data-gsap="potret" class="relative aspect-[4/4.3] w-full overflow-hidden bg-[#09090D]">
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
                        style="background: linear-gradient(180deg, rgba(9,9,13,0.32) 0%, rgba(9,9,13,0) 34%, rgba(21,20,27,0.68) 76%, #15141B 100%);"
                    ></div>
                    <span class="absolute top-4 right-4 inline-flex items-center gap-1.5 rounded-full bg-[#09090D]/80 backdrop-blur-md border border-[#D4AF37]/55 px-3.5 py-1 text-[9px] font-bold uppercase tracking-[0.26em] text-[#F3E5AB]">
                        <span>Mempelai Wanita</span>
                        <span class="h-1.5 w-1.5 rotate-45 bg-[#D4AF37]"></span>
                    </span>
                </div>
            @else
                <div data-gsap="potret" class="pt-8 pb-3 flex flex-col items-center justify-center gap-2.5">
                    <div class="relative mx-auto w-24 h-24 flex items-center justify-center">
                        <span aria-hidden="true" class="absolute inset-0 rounded-full border border-dashed border-[#D4AF37]/65 animasi-orbit"></span>
                        <span aria-hidden="true" class="absolute inset-2 rounded-full border border-[#F3E5AB]/45 animasi-orbit-balik"></span>
                        <span class="noir-font-judul text-3xl font-bold text-[#F3E5AB]">{{ $undangan->inisialWanita() }}</span>
                    </div>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-[#09090D] border border-[#D4AF37]/50 px-3.5 py-1 text-[9px] font-bold uppercase tracking-[0.26em] text-[#D4AF37]">
                        Mempelai Wanita
                    </span>
                </div>
            @endif

            <div class="relative px-6 {{ (! $tanpaFoto && $undangan->urlFotoWanita()) ? '-mt-2 pt-0' : 'pt-2' }} pb-8 text-center space-y-2">
                <h3 data-gsap="kanan" data-gsap-delay="0.05" class="noir-font-judul text-2xl sm:text-3xl font-bold tracking-wider text-[#F3E5AB]">
                    {{ $undangan->nama_panggilan_wanita }}
                </h3>
                <p data-gsap="teks" data-gsap-delay="0.08" class="font-serif text-base font-semibold text-white">
                    {{ $undangan->nama_lengkap_wanita }}
                </p>

                @if ($undangan->nama_ayah_wanita || $undangan->nama_ibu_wanita)
                    <div class="pt-1 space-y-1">
                        <div data-gsap="garis" class="flex items-center justify-center gap-2.5 px-12" aria-hidden="true">
                            <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#D4AF37]/55"></span>
                            <span class="w-1 h-1 rotate-45 bg-[#D4AF37]"></span>
                            <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#D4AF37]/55"></span>
                        </div>
                        <p data-gsap="teks" class="text-[9.5px] font-bold uppercase tracking-[0.24em] text-[#D4AF37] pt-0.5">{{ $undangan->teksKustom('label_wanita', 'Putri dari') }}</p>
                        <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-[13px] text-[#F5EFE6]/80 leading-relaxed max-w-xs mx-auto">
                            {{ $undangan->nama_ayah_wanita }} &amp; {{ $undangan->nama_ibu_wanita }}
                        </p>
                    </div>
                @endif

                @if ($instagramWanita !== '')
                    <div data-gsap="mekar" data-gsap-delay="0.10" class="pt-2">
                        <a
                            href="https://instagram.com/{{ $instagramWanita }}"
                            target="_blank"
                            rel="noopener"
                            class="noir-tombol-obsidian inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-[11px] font-semibold tracking-wide transition active:scale-95"
                        >
                            <svg class="w-3.5 h-3.5 text-[#D4AF37]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
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

{{-- SEKSI 4A: SLIDESHOW SINEMATIK BALLROOM TRANSISI KE SAVE THE DATE --}}
<div id="elegan-tanggal" data-kartu-tumpuk class="noir-kartu-tumpuk bg-[#0E0D14] overflow-hidden">
@if ($fotoGaleriSlideshow->isNotEmpty())
<div
    data-slideshow-noir
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
    class="relative h-68 sm:h-76 w-full overflow-hidden bg-[#09090D]"
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
        style="background: linear-gradient(180deg, rgba(14,13,20,0.82) 0%, rgba(9,9,13,0.12) 35%, rgba(9,9,13,0.34) 68%, #0E0D14 100%);"
    ></div>
</div>
@endif

{{-- SEKSI 4B: SAVE THE DATE & HITUNG MUNDUR — BEVELED GOLD-PLATE CHRONOGRAPH --}}
@if ($undangan->fiturAktif('hitung_mundur') && $isoTarget)
<section
    data-layout-countdown="artdeco"
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
    class="relative bg-gradient-to-b from-[#0E0D14] via-[#121119] to-[#0B0B0F] shadow-[0_-2px_0_0_#0E0D14] px-5 py-13 text-center border-b border-[#D4AF37]/30 overflow-hidden"
>
    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-0"
        style="background: radial-gradient(ellipse 70% 50% at 50% 42%, rgba(212,175,55,0.12) 0%, transparent 72%);"
    ></div>

    <div class="relative z-10 max-w-md mx-auto space-y-5">
        <div class="space-y-1.5">
            <img src="{{ $asetNoir['emas'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async" data-gsap="turun" class="w-10 mx-auto opacity-90">
            <p data-gsap="turun" class="text-[10px] font-semibold uppercase tracking-[0.38em] text-[#D4AF37]">Menuju Malam Bahagia</p>
            <h2 data-gsap="naik" data-gsap-delay="0.06" class="noir-font-judul text-2xl sm:text-3xl font-bold tracking-wider text-[#F3E5AB]">{{ $undangan->teksKustom('judul_hitung_mundur', 'Save The Date') }}</h2>
            <p data-gsap="teks" data-gsap-delay="0.08" class="text-[11px] font-medium uppercase tracking-[0.24em] text-[#F5EFE6]/78">
                {{ $tanggalLengkap }}
            </p>
        </div>

        <div class="grid grid-cols-4 gap-2.5 pt-1 panggung-3d">
            @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                <div
                    data-gsap="mekar"
                    data-gsap-delay="{{ number_format($loop->index * 0.06, 2, '.', '') }}"
                    class="relative rounded-xl bg-[#17161E] border border-[#D4AF37]/60 py-4 px-1 shadow-xl overflow-hidden"
                >
                    <span aria-hidden="true" class="pointer-events-none absolute inset-x-3 top-0 h-px bg-gradient-to-r from-transparent via-[#F3E5AB]/70 to-transparent"></span>
                    <div
                        class="noir-font-judul text-2xl sm:text-3xl font-bold text-[#F3E5AB] leading-none tabular-nums"
                        x-text="{{ $var }}"
                        x-effect="if ({{ $var }}) { $el.classList.remove('angka-flip-3d'); void $el.offsetWidth; $el.classList.add('angka-flip-3d'); }"
                    >00</div>
                    <div class="mt-2 text-[9px] uppercase tracking-[0.22em] font-semibold text-[#D4AF37]">{{ $label }}</div>
                </div>
            @endforeach
        </div>

        <p data-gsap="teks" class="text-xs text-[#F5EFE6]/78 max-w-xs mx-auto leading-relaxed">
            {{ $undangan->teksKustom('pengantar_hitung_mundur', 'Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu.') }}
        </p>

        @if ($googleCalUrl)
            <div data-gsap="mekar" data-gsap-delay="0.10" class="pt-1">
                <a href="{{ $googleCalUrl }}" target="_blank" rel="noopener" class="noir-tombol-emas inline-flex items-center gap-2 rounded-full px-7 py-2.5 text-xs font-bold uppercase tracking-[0.18em] transition active:scale-95">
                    <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
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
</div>

{{-- SEKSI 5: RANGKAIAN ACARA — GRAND BALLROOM GALA PROGRAMME --}}
@if ($undangan->daftarAcara->isNotEmpty())
<section
    id="elegan-acara"
    data-kartu-tumpuk
    data-layout-acara="artdeco"
    class="noir-kartu-tumpuk relative bg-[#0B0B0F] px-4 py-14 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-6">
        <div class="text-center space-y-1.5">
            <div data-gsap="turun" class="flex items-center justify-center gap-2.5">
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-r from-transparent to-[#D4AF37]/70"></span>
                <p class="text-[10px] font-semibold uppercase tracking-[0.38em] text-[#D4AF37]">Waktu &amp; Tempat</p>
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-l from-transparent to-[#D4AF37]/70"></span>
            </div>
            <h2 data-gsap="naik" data-gsap-delay="0.05" class="noir-font-judul text-2xl sm:text-3xl font-bold tracking-wider text-white">{{ $undangan->teksKustom('judul_acara', 'Rangkaian Acara') }}</h2>
            <p data-gsap="teks" data-gsap-delay="0.08" class="text-xs text-[#F5EFE6]/75 max-w-xs mx-auto leading-relaxed">
                {{ $undangan->teksKustom('pengantar_hitung_mundur', 'Dengan penuh suka cita, kami mengundang Bapak/Ibu/Saudara/i pada rangkaian acara pernikahan kami:') }}
            </p>
        </div>

        <div class="space-y-5">
            @foreach ($undangan->daftarAcara as $acara)
                @php
                    $nomorProsesi = str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT);
                @endphp
                <article class="relative rounded-2xl bg-[#15141B] border border-[#D4AF37]/60 shadow-[0_24px_50px_-18px_rgba(0,0,0,0.88)] overflow-hidden kartu-3d efek-shimmer-kartu">
                    <span aria-hidden="true" class="pointer-events-none absolute top-2.5 left-2.5 h-4 w-4 border-t-2 border-l-2 border-[#D4AF37] z-20"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute top-2.5 right-2.5 h-4 w-4 border-t-2 border-r-2 border-[#D4AF37] z-20"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 left-2.5 h-4 w-4 border-b-2 border-l-2 border-[#D4AF37] z-20"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 right-2.5 h-4 w-4 border-b-2 border-r-2 border-[#D4AF37] z-20"></span>

                    {{-- Header Pita Obsidian-Emas --}}
                    <div class="bg-gradient-to-b from-[#1E1C26] to-[#121118] border-b border-[#D4AF37]/45 px-6 py-5 text-center space-y-1.5">
                        <p data-gsap="turun" class="text-[9.5px] font-bold uppercase tracking-[0.32em] text-[#D4AF37]">
                            Prosesi {{ $nomorProsesi }} &bull; {{ $acara->tanggal_acara->locale('id')->translatedFormat('l') }}
                        </p>
                        <h3 data-gsap="mekar" data-gsap-delay="0.05" class="noir-font-judul text-xl sm:text-2xl font-bold tracking-wide text-[#F3E5AB]">
                            {{ $acara->nama_acara }}
                        </h3>
                    </div>

                    {{-- Detail Tanggal, Waktu & Lokasi --}}
                    <div class="px-6 py-6 text-center space-y-4">
                        <div class="flex items-center justify-center gap-5">
                            <div data-gsap="kiri" class="flex items-center gap-2.5 text-left">
                                <span class="noir-font-judul text-3xl font-bold leading-none text-[#F3E5AB] tabular-nums">
                                    {{ $acara->tanggal_acara->format('d') }}
                                </span>
                                <div class="leading-tight">
                                    <p class="text-[11px] font-bold uppercase tracking-[0.14em] text-white">
                                        {{ $acara->tanggal_acara->locale('id')->translatedFormat('F') }}
                                    </p>
                                    <p class="text-[11px] font-semibold tracking-[0.16em] text-[#D4AF37]">
                                        {{ $acara->tanggal_acara->format('Y') }}
                                    </p>
                                </div>
                            </div>

                            <span data-gsap="mekar" aria-hidden="true" class="h-9 w-px bg-[#D4AF37]/40"></span>

                            <div data-gsap="kanan" class="text-left leading-tight">
                                <p class="text-[9.5px] font-bold uppercase tracking-[0.22em] text-[#D4AF37]">Pukul</p>
                                <p class="mt-0.5 text-xs sm:text-[13px] font-bold text-white">
                                    {{ \Illuminate\Support\Str::substr($acara->waktu_mulai, 0, 5) }}
                                    @if ($acara->waktu_selesai)
                                        &ndash; {{ \Illuminate\Support\Str::substr($acara->waktu_selesai, 0, 5) }}
                                    @else
                                        &ndash; Selesai
                                    @endif
                                    <span class="font-semibold text-[#F3E5AB]">{{ $acara->zona_waktu }}</span>
                                </p>
                            </div>
                        </div>

                        <div data-gsap="garis" class="flex items-center justify-center gap-3 px-8" aria-hidden="true">
                            <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#D4AF37]/45"></span>
                            <span class="w-1.5 h-1.5 rotate-45 bg-[#D4AF37]"></span>
                            <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#D4AF37]/45"></span>
                        </div>

                        <div class="space-y-1">
                            <p data-gsap="naik" data-gsap-delay="0.06" class="font-serif text-base font-bold text-white leading-snug">
                                {{ $acara->nama_tempat }}
                            </p>
                            <p data-gsap="teks" data-gsap-delay="0.09" class="text-xs text-[#F5EFE6]/72 leading-relaxed max-w-xs mx-auto">
                                {{ $acara->alamat_lengkap }}
                            </p>
                        </div>

                        @if ($acara->link_maps)
                            <div data-gsap="mekar" data-gsap-delay="0.12" class="pt-1">
                                <a href="{{ $acara->link_maps }}" target="_blank" rel="noopener" class="noir-tombol-emas inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-[11px] font-bold uppercase tracking-[0.18em] transition active:scale-95">
                                    <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
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

{{-- SEKSI 6: PANDUAN BUSANA (DRESS CODE) & LIVE STREAMING --}}
@if ($adaDressCode || (! empty($live['aktif']) && ! empty($live['link'])))
<section data-kartu-tumpuk class="noir-kartu-tumpuk relative bg-[#0E0D14] px-4 py-12 space-y-5 overflow-hidden">
    @if ($adaDressCode)
        <div data-section-dress-code="artdeco" class="max-w-md mx-auto rounded-2xl bg-[#15141B] border border-[#D4AF37]/50 p-6 text-center space-y-3.5 shadow-xl kartu-3d">
            <div class="space-y-1">
                <p data-gsap="turun" class="text-[10px] font-semibold uppercase tracking-[0.36em] text-[#D4AF37]">Panduan Kehadiran</p>
                <h3 data-gsap="naik" class="noir-font-judul text-xl font-bold text-[#F3E5AB]">Dress Code</h3>
            </div>
            @if ($dressCodeCatatan !== '')
                <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-sm text-[#F5EFE6]/82 leading-relaxed">{{ $dressCodeCatatan }}</p>
            @endif
            @if (! empty($dressCodeWarna))
                <div class="flex flex-wrap items-center justify-center gap-3.5 pt-1">
                    @foreach ($dressCodeWarna as $hex)
                        <div data-gsap="mekar" data-gsap-delay="{{ number_format($loop->index * 0.05, 2, '.', '') }}" class="flex flex-col items-center gap-1">
                            <span class="h-9 w-9 rounded-lg border border-[#F3E5AB]/80 shadow-md" style="background-color: {{ $hex }};"></span>
                            <span class="text-[9px] font-mono text-[#F3E5AB]/75">{{ $hex }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    @if (! empty($live['aktif']) && ! empty($live['link']))
        <div class="max-w-md mx-auto rounded-2xl bg-[#15141B] border border-[#D4AF37]/55 p-6 text-center space-y-3 shadow-xl kartu-3d efek-shimmer-kartu">
            <p data-gsap="turun" class="text-[10px] font-semibold uppercase tracking-[0.36em] text-[#D4AF37]">Siaran Langsung</p>
            <h3 data-gsap="naik" data-gsap-delay="0.05" class="noir-font-judul text-xl font-bold text-[#F3E5AB]">Live Streaming</h3>
            <p data-gsap="teks" data-gsap-delay="0.09" class="text-xs text-[#F5EFE6]/80 leading-relaxed max-w-xs mx-auto">
                Bagi kerabat dan sahabat yang berhalangan hadir langsung, silakan menyaksikan momen bahagia kami melalui {{ $live['platform'] ?? 'YouTube Live' }}.
            </p>
            <div data-gsap="mekar" data-gsap-delay="0.12" class="pt-1">
                <a href="{{ $live['link'] }}" target="_blank" rel="noopener" class="noir-tombol-emas inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-xs font-bold uppercase tracking-[0.18em] transition active:scale-95">
                    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"/>
                        <rect x="2" y="6" width="14" height="12" rx="2"/>
                    </svg>
                    <span>Gabung Live Streaming</span>
                </a>
            </div>
        </div>
    @endif
</section>
@endif

{{-- SEKSI 7: CERITA CINTA — GOLD-DIAMOND VERTICAL TIMELINE --}}
@if ($undangan->fiturAktif('cerita_cinta') && ! empty($ceritaList))
<section
    data-kartu-tumpuk
    data-layout-cerita="artdeco"
    class="noir-kartu-tumpuk relative bg-[#0B0B0F] px-4 py-13 overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-7 overflow-hidden py-1">
        <div data-gsap="kiri">
            <p class="scroll-scrub-kiri text-[10px] font-semibold uppercase tracking-[0.38em] text-[#D4AF37]">Kisah Perjalanan Kami</p>
        </div>
        <div data-gsap="kanan" data-gsap-delay="0.06">
            <h2 class="scroll-scrub-kanan mt-1 noir-font-judul text-2xl sm:text-3xl font-bold tracking-wider text-white">{{ $undangan->teksKustom('judul_cerita', 'Cerita Cinta') }}</h2>
        </div>
    </div>

    <div class="max-w-md mx-auto relative pl-7 space-y-5 border-l border-[#D4AF37]/50 ml-3">
        @foreach ($ceritaList as $cerita)
            @php
                $urlFotoBab = (! $tanpaFoto && ! empty($cerita['foto']))
                    ? \App\Support\MediaPublik::url((string) $cerita['foto'])
                    : null;
            @endphp
            <article class="relative">
                <span aria-hidden="true" data-gsap="mekar" class="absolute -left-[35px] top-5 inline-flex">
                    <span class="w-3.5 h-3.5 rotate-45 border border-[#F3E5AB] bg-[#D4AF37] shadow-[0_0_12px_rgba(212,175,55,0.65)]"></span>
                </span>
                <div class="rounded-2xl bg-[#15141B] border border-[#D4AF37]/50 p-5 shadow-xl kartu-3d efek-shimmer-kartu">
                    @if ($urlFotoBab)
                        <div data-gsap="potret" class="mb-3.5 overflow-hidden rounded-xl border border-[#D4AF37]/40">
                            <img src="{{ $urlFotoBab }}" alt="{{ $cerita['judul'] ?? 'Cerita Cinta' }}" loading="lazy" decoding="async" class="w-full aspect-[16/10] object-cover object-center">
                        </div>
                    @endif
                    <div class="flex items-center justify-between gap-2 flex-wrap">
                        <h3 data-gsap="kiri" data-gsap-delay="0.05" class="noir-font-judul text-base font-bold text-[#F3E5AB]">{{ $cerita['judul'] ?? '' }}</h3>
                        @if (! empty($cerita['tanggal']))
                            <span data-gsap="kanan" data-gsap-delay="0.08" class="rounded-full border border-[#D4AF37]/45 bg-black/55 px-2.5 py-0.5 text-[10px] font-semibold text-[#D4AF37]">{{ $cerita['tanggal'] }}</span>
                        @endif
                    </div>
                    <p data-gsap="teks" data-gsap-delay="0.1" class="mt-2 text-xs sm:text-sm text-[#F5EFE6]/80 leading-relaxed">{{ $cerita['cerita'] ?? '' }}</p>
                </div>
            </article>
        @endforeach
    </div>
</section>
@endif

{{-- SEKSI 8: GRAND BALLROOM GALLERY (MODE GESER + GRID KOTAK BORDER TIPIS 1PX, FEATURED col-span-2 aspect-[16/10]) --}}
@if (! $tanpaFoto && $undangan->fiturAktif('galeri') && $undangan->daftarGaleri->isNotEmpty())
<section
    id="elegan-galeri"
    data-kartu-tumpuk
    data-layout-galeri="artdeco"
    data-galeri-reel-elegan="noir"
    x-data="{
        modeGrid: false,
        indeksReel: 0,
        totalFoto: {{ $undangan->daftarGaleri->count() }},
        geserReel(arah) {
            const el = this.$refs.jalurReel;
            if (!el) return;
            const lebarKartu = el.firstElementChild ? el.firstElementChild.offsetWidth + 14 : 280;
            el.scrollBy({ left: arah * lebarKartu, behavior: 'smooth' });
        },
        perbaruiIndeksReel() {
            const el = this.$refs.jalurReel;
            if (!el || !el.firstElementChild) return;
            const lebar = el.firstElementChild.offsetWidth + 14;
            this.indeksReel = Math.min(this.totalFoto - 1, Math.max(0, Math.round(el.scrollLeft / Math.max(1, lebar))));
        }
    }"
    class="noir-kartu-tumpuk relative bg-[#111016] px-4 py-13 overflow-hidden"
>
    <div class="max-w-md mx-auto mb-6 flex items-end justify-between gap-3">
        <div class="text-left min-w-0">
            <p data-gsap="turun" class="text-[10px] font-semibold uppercase tracking-[0.38em] text-[#D4AF37]">Momen Berharga</p>
            <h2 data-gsap="naik" data-gsap-delay="0.06" class="mt-1 noir-font-judul text-2xl sm:text-3xl font-bold tracking-wider text-white">{{ $undangan->teksKustom('judul_galeri', 'Galeri Kebahagiaan') }}</h2>
        </div>

        <button
            type="button"
            @click="modeGrid = !modeGrid; window.SesiTemuSinema?.refresh(100)"
            class="shrink-0 rounded-full border border-[#D4AF37]/45 bg-[#0B0B0F] px-3.5 py-1.5 text-[10px] font-bold uppercase tracking-[0.16em] text-[#F3E5AB] hover:bg-[#D4AF37] hover:text-[#0B0B0F] transition cursor-pointer"
            x-text="modeGrid ? 'Mode Geser' : 'Lihat Semua'"
        >Lihat Semua</button>
    </div>

    {{-- Mode Utama: Swipeable Horizontal Kotak Rapi Border Emas Tipis 1px --}}
    <div x-show="!modeGrid" class="max-w-md mx-auto space-y-4">
        <div
            x-ref="jalurReel"
            @scroll.passive="perbaruiIndeksReel()"
            data-horizontal-editorial
            class="flex items-stretch gap-3 overflow-x-auto snap-x snap-mandatory no-scrollbar pb-1 cursor-grab"
        >
            @foreach ($undangan->daftarGaleri as $galeri)
                <button
                    type="button"
                    @click="bukaGaleri(@js($galeri->urlFoto()), @js($galeri->keterangan))"
                    class="group relative w-[78%] sm:w-[74%] shrink-0 snap-center aspect-[4/5] overflow-hidden rounded-xl border border-[#D4AF37]/30 bg-[#0B0B0F] shadow-xl cursor-pointer"
                >
                    <img
                        src="{{ $galeri->urlFoto() }}"
                        alt="{{ $galeri->keterangan ?? 'Galeri' }}"
                        loading="lazy"
                        decoding="async"
                        class="block w-full h-full object-cover object-top group-hover:scale-105 transition duration-700"
                    >
                    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/82 via-black/10 to-transparent"></div>
                    <span class="pointer-events-none absolute top-3 left-3 rounded-full bg-black/70 backdrop-blur-xs border border-[#D4AF37]/40 px-2.5 py-0.5 text-[9px] font-bold uppercase tracking-[0.22em] text-[#F3E5AB]">
                        {{ sprintf('%02d', $loop->iteration) }} / {{ sprintf('%02d', $loop->count) }}
                    </span>
                    @if ($galeri->keterangan)
                        <span class="pointer-events-none absolute inset-x-0 bottom-0 p-3.5 text-left font-serif text-xs sm:text-sm font-medium text-[#F5EFE6] truncate">
                            {{ $galeri->keterangan }}
                        </span>
                    @endif
                </button>
            @endforeach
        </div>

        <div class="flex items-center justify-between gap-3 pt-1">
            <button type="button" @click="geserReel(-1)" aria-label="Foto sebelumnya" class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-[#D4AF37]/45 bg-[#0B0B0F] text-[#F3E5AB] hover:bg-[#D4AF37] hover:text-[#0B0B0F] transition cursor-pointer">&larr;</button>
            <div class="flex-1 h-1 rounded-full bg-white/10 overflow-hidden">
                <div class="h-full bg-gradient-to-r from-[#C59B38] via-[#F3E5AB] to-[#D4AF37] transition-all duration-300" :style="'width: ' + (((indeksReel + 1) / Math.max(1, totalFoto)) * 100) + '%'"></div>
            </div>
            <button type="button" @click="geserReel(1)" aria-label="Foto berikutnya" class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-[#D4AF37]/45 bg-[#0B0B0F] text-[#F3E5AB] hover:bg-[#D4AF37] hover:text-[#0B0B0F] transition cursor-pointer">&rarr;</button>
        </div>
    </div>

    {{-- Mode Lihat Semua: Grid Kotak Rapi Border Tipis 1px --}}
    <div x-show="modeGrid" x-cloak x-transition.opacity.duration.250ms class="max-w-md mx-auto grid grid-cols-2 items-stretch gap-2.5">
        @foreach ($undangan->daftarGaleri as $galeri)
            @php
                $kelasTile = \App\Support\DataTemaUndangan::kelasGridGaleri($loop->index, $loop->count, 'artdeco');
            @endphp
            <button
                type="button"
                @click="bukaGaleri(@js($galeri->urlFoto()), @js($galeri->keterangan))"
                class="group relative block w-full overflow-hidden rounded-xl border border-[#D4AF37]/30 bg-[#0B0B0F] shadow-md cursor-pointer kartu-3d {{ $kelasTile }}"
            >
                <img
                    src="{{ $galeri->urlFoto() }}"
                    alt="{{ $galeri->keterangan ?? 'Galeri' }}"
                    loading="lazy"
                    decoding="async"
                    class="block w-full h-full object-cover object-top group-hover:scale-105 transition duration-700"
                >
                @if ($galeri->keterangan)
                    <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent px-3 py-2 text-left text-[10.5px] font-medium text-[#F3E5AB] opacity-0 group-hover:opacity-100 transition duration-300">
                        {{ $galeri->keterangan }}
                    </span>
                @endif
            </button>
        @endforeach
    </div>
</section>
@endif
