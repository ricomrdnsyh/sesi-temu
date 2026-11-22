{{-- SEKSI 3: KUTIPAN / AYAT DI ATAS BLOK SOGAN BERBORDER BATIK KAWUNG --}}
<section data-section-pembuka="keraton" class="relative bg-[#472A1C] shadow-[0_0_0_2px_#472A1C] text-[#2B180F] overflow-hidden">
    {{-- Border Batik Kawung Atas --}}
    <img src="{{ $asetJawa['kawungAtas'] }}" alt="" aria-hidden="true" class="pointer-events-none w-full h-16 sm:h-20 object-cover object-bottom opacity-80">

    <div class="relative z-10 px-6 py-4">
        <div class="fx-rise relative rounded-[22px] bg-[#FFFAF5] shadow-2xl overflow-hidden border border-[#D7BB83]/50 kartu-3d">
            {{-- Watermark Ilustrasi Tipis di Bagian Bawah Kartu --}}
            <img
                src="{{ $urlFotoLatar }}"
                alt=""
                aria-hidden="true"
                class="pointer-events-none absolute inset-0 w-full h-full object-cover opacity-15"
            >

            @if (! $tanpaFoto && ! empty($urlFotoPembuka))
                <div class="relative z-10 overflow-hidden">
                    <img
                        src="{{ $urlFotoPembuka }}"
                        alt="{{ $undangan->nama_panggilan_pria }} & {{ $undangan->nama_panggilan_wanita }}"
                        class="w-full aspect-[4/4.2] object-cover object-top shadow-md"
                    >
                </div>
            @endif

            <div class="relative z-10 px-6 py-9 text-center space-y-5">
                {{-- Monogram Pasangan Meluncur Bertemu Kiri & Kanan --}}
                <div class="grid grid-cols-3 items-center max-w-[185px] mx-auto text-[#472A1C]">
                    <span class="fx-slide-left font-serif text-4xl sm:text-5xl font-semibold tracking-wider">
                        {{ $undangan->inisialPria() }}
                    </span>
                    <span class="fx-scale-in font-kaligrafi text-3xl text-[#A38C5E]">&amp;</span>
                    <span class="fx-slide-right font-serif text-4xl sm:text-5xl font-semibold tracking-wider">
                        {{ $undangan->inisialWanita() }}
                    </span>
                </div>

                @if ($undangan->kutipan_ayat)
                    <blockquote class="font-serif text-[15px] sm:text-base leading-relaxed text-[#2B180F]">
                        &ldquo;{{ $undangan->kutipan_ayat }}&rdquo;
                    </blockquote>
                @endif
            </div>
        </div>
    </div>

    {{-- Border Batik Kawung Bawah --}}
    <img src="{{ $asetJawa['kawungBawah'] }}" alt="" aria-hidden="true" class="pointer-events-none w-full h-16 sm:h-20 object-cover object-top opacity-80">
</section>

{{-- SEKSI 4: PROFIL KEDUA MEMPELAI — KAPSUL KUBAH RAKSASA DI ATAS DIORAMA TERPIN --}}
<section
    data-layout-mempelai="keraton"
    class="relative py-14 px-5 overflow-hidden"
>
    <div class="relative mx-auto max-w-[395px] rounded-[500px] border-[4px] border-[#D7BB83] bg-[#FFFAF5]/93 px-6 pt-16 pb-20 text-center text-[#2B180F] shadow-2xl overflow-hidden kartu-3d">
        <div class="relative z-10 space-y-6">
            <img
                src="{{ $asetJawa['gununganKecil'] }}"
                alt=""
                class="fx-rise-down w-14 mx-auto drop-shadow-md animasi-ayun-3d"
            >

            <div class="space-y-2.5">
                <h2 class="fx-rise font-kaligrafi text-[2.55rem] leading-tight text-[#472A1C]">
                    We Are Getting Married!
                </h2>
                <p class="text-xs text-[#472A1C]/80 leading-relaxed px-2">
                    Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud menyelenggarakan upacara pernikahan putra-putri kami:
                </p>
            </div>

            {{-- Mempelai Wanita --}}
            <div class="space-y-3 pt-3">
                <div class="relative mx-auto w-fit py-2">
                    <img
                        src="{{ $asetJawa['sayapWayang'] }}"
                        alt=""
                        aria-hidden="true"
                        class="pointer-events-none absolute -top-4 -left-10 w-28 opacity-92 z-0 -scale-x-100 ayun-kanan"
                    >
                    @if (! $tanpaFoto && $undangan->urlFotoWanita())
                        <img
                            src="{{ $undangan->urlFotoWanita() }}"
                            alt="{{ $undangan->nama_lengkap_wanita }}"
                            class="fx-scale-out relative z-10 mx-auto w-44 h-72 rounded-[500px] object-cover object-top border-2 border-[#D7BB83] shadow-xl"
                        >
                    @else
                        <div class="fx-scale-out relative z-10 mx-auto w-40 h-56 rounded-[500px] border-2 border-[#D7BB83] bg-[#472A1C] text-[#F3E5AB] flex items-center justify-center shadow-xl">
                            <span class="font-serif text-5xl font-semibold">{{ $undangan->inisialWanita() }}</span>
                        </div>
                    @endif
                    <img
                        src="{{ $asetJawa['bungaLili'] }}"
                        alt=""
                        aria-hidden="true"
                        class="pointer-events-none absolute -bottom-5 -right-8 w-32 z-20 drop-shadow-lg ayun-kiri"
                    >
                </div>

                <div class="fx-rise pt-3 space-y-1">
                    <p class="font-kaligrafi text-4xl text-[#472A1C] leading-none">{{ $undangan->nama_panggilan_wanita }}</p>
                    <h3 class="font-serif text-xl font-bold text-[#2B180F]">{{ $undangan->nama_lengkap_wanita }}</h3>
                    @if ($undangan->nama_ayah_wanita || $undangan->nama_ibu_wanita)
                        <p class="text-xs text-[#472A1C]/80 leading-relaxed pt-0.5">
                            Putri dari<br>
                            {{ $undangan->nama_ayah_wanita }} &amp; {{ $undangan->nama_ibu_wanita }}
                        </p>
                    @endif
                    @if ($instagramWanita !== '')
                        <div class="pt-2">
                            <a
                                href="https://instagram.com/{{ $instagramWanita }}"
                                target="_blank"
                                rel="noopener"
                                class="jawa-tombol-emas inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-[11px] font-medium transition"
                            >
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                                    <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                                </svg>
                                <span>&#64;{{ $instagramWanita }}</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Penghubung & --}}
            <div class="fx-scale-in font-kaligrafi text-5xl text-[#8C6823] py-2">&amp;</div>

            {{-- Mempelai Pria --}}
            <div class="space-y-3 pb-2">
                <div class="relative mx-auto w-fit py-2">
                    <img
                        src="{{ $asetJawa['sayapWayang'] }}"
                        alt=""
                        aria-hidden="true"
                        class="pointer-events-none absolute -top-4 -right-10 w-28 opacity-92 z-0 ayun-kiri"
                    >
                    @if (! $tanpaFoto && $undangan->urlFotoPria())
                        <img
                            src="{{ $undangan->urlFotoPria() }}"
                            alt="{{ $undangan->nama_lengkap_pria }}"
                            class="fx-scale-out relative z-10 mx-auto w-44 h-72 rounded-[500px] object-cover object-top border-2 border-[#D7BB83] shadow-xl"
                        >
                    @else
                        <div class="fx-scale-out relative z-10 mx-auto w-40 h-56 rounded-[500px] border-2 border-[#D7BB83] bg-[#472A1C] text-[#F3E5AB] flex items-center justify-center shadow-xl">
                            <span class="font-serif text-5xl font-semibold">{{ $undangan->inisialPria() }}</span>
                        </div>
                    @endif
                    <img
                        src="{{ $asetJawa['bungaLili'] }}"
                        alt=""
                        aria-hidden="true"
                        class="pointer-events-none absolute -bottom-5 -left-8 w-32 z-20 drop-shadow-lg -scale-x-100 ayun-kanan"
                    >
                </div>

                <div class="fx-rise pt-3 space-y-1">
                    <p class="font-kaligrafi text-4xl text-[#472A1C] leading-none">{{ $undangan->nama_panggilan_pria }}</p>
                    <h3 class="font-serif text-xl font-bold text-[#2B180F]">{{ $undangan->nama_lengkap_pria }}</h3>
                    @if ($undangan->nama_ayah_pria || $undangan->nama_ibu_pria)
                        <p class="text-xs text-[#472A1C]/80 leading-relaxed pt-0.5">
                            Putra dari<br>
                            {{ $undangan->nama_ayah_pria }} &amp; {{ $undangan->nama_ibu_pria }}
                        </p>
                    @endif
                    @if ($instagramPria !== '')
                        <div class="pt-2">
                            <a
                                href="https://instagram.com/{{ $instagramPria }}"
                                target="_blank"
                                rel="noopener"
                                class="jawa-tombol-emas inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-[11px] font-medium transition"
                            >
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                                    <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                                </svg>
                                <span>&#64;{{ $instagramPria }}</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- SEKSI 5A: SLIDESHOW FOTO TRANSISI KE BLOK SOGAN --}}
@if ($fotoGaleriSlideshow->isNotEmpty())
<div
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
    class="relative h-72 w-full overflow-hidden bg-[#472A1C]"
>
    @foreach ($fotoGaleriSlideshow as $idxSlide => $urlSlide)
        <img
            src="{{ $urlSlide }}"
            alt="Momen Bahagia {{ $undangan->nama_panggilan_pria }} & {{ $undangan->nama_panggilan_wanita }}"
            class="absolute inset-0 w-full h-full object-cover object-top transition-opacity duration-1000"
            :class="slideAktif === {{ $idxSlide }} ? 'opacity-90 scale-105' : 'opacity-0 scale-100'"
            style="transition: opacity 1.1s ease, transform 5s ease;"
        >
    @endforeach
    <div aria-hidden="true" class="pointer-events-none absolute inset-0" style="background: linear-gradient(180deg, rgba(217,195,176,0.25) 0%, rgba(71,42,28,0.45) 55%, #472A1C 100%);"></div>
</div>
@endif

{{-- SEKSI 5B: SAVE THE DATE & HITUNG MUNDUR (BLOK SOGAN GELAP #472A1C) --}}
@if ($undangan->fiturAktif('hitung_mundur') && $acaraPertama && $isoTarget)
<section
    data-layout-countdown="keraton"
    x-data="{
        targetMs: new Date(@js($isoTarget)).getTime(),
        hari: '00',
        jam: '00',
        menit: '00',
        detik: '00',
        perbarui() {
            const selisih = Math.max(0, this.targetMs - Date.now());
            this.hari = String(Math.floor(selisih / 86400000)).padStart(2, '0');
            this.jam = String(Math.floor((selisih % 86400000) / 3600000)).padStart(2, '0');
            this.menit = String(Math.floor((selisih % 3600000) / 60000)).padStart(2, '0');
            this.detik = String(Math.floor((selisih % 60000) / 1000)).padStart(2, '0');
        },
        init() {
            this.perbarui();
            setInterval(() => this.perbarui(), 1000);
        }
    }"
    class="relative bg-[#472A1C] shadow-[0_0_0_2px_#472A1C] text-[#FFFAF5] px-6 py-12 text-center overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-5">
        <img src="{{ $asetJawa['gununganKecil'] }}" alt="" class="fx-rise-down w-14 mx-auto drop-shadow-lg">

        <div class="fx-rise space-y-1">
            <h2 class="font-kaligrafi text-5xl text-white leading-tight">Save The Date</h2>
        </div>

        <div class="grid grid-cols-4 gap-2.5 pt-1 panggung-3d">
            @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                <div class="rounded-2xl bg-[#D7BB83] text-[#2B180F] py-3.5 px-1.5 shadow-lg border border-[#F3E5AB]/55">
                    <div
                        class="font-serif text-2xl sm:text-3xl font-bold leading-none"
                        x-text="{{ $var }}"
                        x-effect="if ({{ $var }}) { $el.classList.remove('angka-flip-3d'); void $el.offsetWidth; $el.classList.add('angka-flip-3d'); }"
                    >00</div>
                    <div class="mt-1.5 text-[10px] uppercase tracking-wider font-semibold text-[#472A1C]">{{ $label }}</div>
                </div>
            @endforeach
        </div>

        <p class="text-xs text-[#FFFAF5]/85 max-w-xs mx-auto leading-relaxed pt-1">
            Merupakan kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu.
        </p>

        @if ($googleCalUrl)
            <div class="pt-1">
                <a
                    href="{{ $googleCalUrl }}"
                    target="_blank"
                    rel="noopener"
                    class="jawa-tombol-emas inline-flex items-center gap-2 rounded-full px-7 py-2.5 text-xs sm:text-sm font-medium transition"
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

{{-- SEKSI 6: RANGKAIAN ACARA — KARTU DOUBLE-FRAME BERBINGKAI ILUSTRASI JAWA --}}
@if ($undangan->daftarAcara->isNotEmpty())
<section
    data-layout-acara="keraton"
    class="relative bg-[#472A1C] shadow-[0_0_0_2px_#472A1C] px-5 pt-2 pb-14 space-y-6"
>
    @foreach ($undangan->daftarAcara as $acara)
        <div class="fx-scale-in relative rounded-[24px] p-3.5 overflow-hidden shadow-2xl kartu-3d">
            {{-- Mat Luar Ilustrasi Penuh (Hutan + Joglo + Mawar) --}}
            <img src="{{ $urlFotoLatar }}" alt="" aria-hidden="true" class="pointer-events-none absolute inset-0 w-full h-full object-cover">
            <img src="{{ $asetJawa['bungaDepan'] }}" alt="" aria-hidden="true" class="pointer-events-none absolute bottom-0 inset-x-0 w-full opacity-95">

            {{-- Kartu Dalam Gading Berborder Emas --}}
            <div class="relative z-10 rounded-[18px] border-2 border-[#D7BB83] bg-[#FFFAF5]/90 px-5 py-9 text-center text-[#2B180F] space-y-3">
                <h3 class="fx-scale-in font-kaligrafi text-[2.5rem] leading-tight text-[#472A1C]">
                    {{ $acara->nama_acara }}
                </h3>

                <div class="space-y-0.5 pt-1">
                    <p class="font-serif text-base font-bold uppercase tracking-[0.14em] text-[#2B180F]">
                        {{ $acara->tanggal_acara->locale('id')->translatedFormat('l') }}
                    </p>
                    <p class="font-serif text-lg font-bold uppercase tracking-wider text-[#2B180F]">
                        {{ $acara->tanggal_acara->locale('id')->translatedFormat('d F Y') }}
                    </p>
                    <p class="text-xs font-medium text-[#472A1C] pt-1">
                        Pukul {{ substr($acara->waktu_mulai, 0, 5) }} {{ $acara->zona_waktu }}
                        @if ($acara->waktu_selesai) - {{ substr($acara->waktu_selesai, 0, 5) }} {{ $acara->zona_waktu }} @endif
                    </p>
                </div>

                <div class="flex items-center justify-center py-1 text-[#C5A467]" aria-hidden="true">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7Zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/>
                    </svg>
                </div>

                <div class="space-y-1">
                    <p class="font-serif text-base font-bold text-[#2B180F]">{{ $acara->nama_tempat }}</p>
                    <p class="text-xs text-[#472A1C]/85 leading-relaxed max-w-xs mx-auto">{{ $acara->alamat_lengkap }}</p>
                </div>

                @if ($acara->link_maps)
                    <div class="pt-2">
                        <a
                            href="{{ $acara->link_maps }}"
                            target="_blank"
                            rel="noopener"
                            class="jawa-tombol-emas inline-flex items-center gap-1.5 rounded-full px-6 py-2 text-xs font-medium transition"
                        >
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7Zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/>
                            </svg>
                            <span>Google Maps</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</section>
@endif

{{-- SEKSI 7: DRESS CODE & LIVE STREAMING (DI ATAS JENDELA DIORAMA TERPIN) --}}
@if ($adaDressCode || (! empty($live['aktif']) && ! empty($live['link'])))
<section class="relative py-12 px-5 space-y-6">
    @if ($adaDressCode)
        <div data-section-dress-code="keraton" class="fx-rise rounded-[22px] border-[3px] border-[#D7BB83] bg-[#FFFAF5]/92 px-6 py-9 text-center text-[#2B180F] shadow-xl space-y-4 kartu-3d">
            <h2 class="font-kaligrafi text-4xl text-[#472A1C] leading-tight">Dress Code</h2>
            @if ($dressCodeCatatan !== '')
                <p class="text-xs sm:text-sm text-[#472A1C]/85 leading-relaxed max-w-xs mx-auto">
                    {{ $dressCodeCatatan }}
                </p>
            @endif
            @if (! empty($dressCodeWarna))
                <div class="flex items-center justify-center gap-3.5 pt-2">
                    @foreach ($dressCodeWarna as $hexWarna)
                        <span
                            title="{{ $hexWarna }}"
                            class="h-11 w-11 rounded-full ring-2 ring-white shadow-[0_6px_14px_rgba(43,24,15,0.24)] border border-[#D7BB83]/45"
                            style="background-color: {{ $hexWarna }};"
                        ></span>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    @if (! empty($live['aktif']) && ! empty($live['link']))
        <div class="fx-scale-in rounded-[22px] border-[3px] border-[#D7BB83] bg-[#FFFAF5]/92 px-6 py-9 text-center text-[#2B180F] shadow-xl space-y-3 kartu-3d">
            <h2 class="font-kaligrafi text-4xl text-[#472A1C] leading-tight">Live Streaming</h2>
            <p class="text-xs sm:text-sm text-[#472A1C]/85 leading-relaxed max-w-xs mx-auto">
                Bagi kerabat yang berhalangan hadir secara langsung, silakan menyaksikan momen bahagia kami via {{ $live['platform'] ?? 'Online' }}.
            </p>
            <div class="pt-2">
                <a
                    href="{{ $live['link'] }}"
                    target="_blank"
                    rel="noopener"
                    class="jawa-tombol-emas inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-xs font-medium transition"
                >
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
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

{{-- SEKSI 8: OUR LOVE STORY (KUBAH TINGGI BERBORDER COKLAT SOGAN #472A1C + FOTO PER BAB) --}}
@if ($undangan->fiturAktif('cerita_cinta') && ! empty($ceritaList))
<section
    data-layout-cerita="keraton"
    class="relative py-12 px-5 overflow-hidden"
>
    <div class="mx-auto max-w-[395px] rounded-[500px] border-[4px] border-[#472A1C] bg-[#FFFAF5]/95 px-9 pt-16 pb-28 text-center text-[#2B180F] shadow-2xl space-y-7 kartu-3d">
        <div data-scroll-scrub class="space-y-1.5 overflow-hidden">
            <img src="{{ $asetJawa['gununganKecil'] }}" alt="" class="fx-rise-down w-14 mx-auto">
            <h2 class="scroll-scrub-kanan font-serif text-sm font-bold uppercase tracking-[0.34em] text-[#472A1C] pt-1">
                Our Love Story
            </h2>
            <p class="scroll-scrub-kiri font-serif text-xl font-bold uppercase tracking-[0.14em] text-[#8C6823]">
                {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
            </p>
        </div>

        <div class="space-y-7">
            @foreach ($ceritaList as $cerita)
                @php
                    $urlFotoBab = (! $tanpaFoto && ! empty($cerita['foto']))
                        ? \App\Support\MediaPublik::url((string) $cerita['foto'])
                        : null;
                @endphp
                <article class="fx-rise space-y-2.5 border-t border-[#D7BB83]/45 pt-6 first:border-t-0 first:pt-0">
                    @if ($urlFotoBab)
                        <div class="mx-auto w-full max-w-[260px] overflow-hidden rounded-2xl border-[3px] border-white shadow-lg">
                            <img
                                src="{{ $urlFotoBab }}"
                                alt="{{ $cerita['judul'] ?? 'Cerita Cinta' }}"
                                class="w-full aspect-[4/3] object-cover object-center"
                            >
                        </div>
                    @endif
                    <h3 class="font-serif text-base font-bold uppercase tracking-[0.12em] text-[#472A1C] pt-1">
                        {{ $cerita['judul'] ?? '' }}
                    </h3>
                    @if (! empty($cerita['tanggal']))
                        <p class="inline-block rounded-full bg-[#472A1C] px-3 py-0.5 text-[10px] font-semibold uppercase tracking-widest text-[#F3E5AB]">
                            {{ $cerita['tanggal'] }}
                        </p>
                    @endif
                    <p class="text-xs sm:text-sm text-[#472A1C]/85 leading-relaxed">
                        {{ $cerita['cerita'] ?? '' }}
                    </p>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- SEKSI 9: OUR GALLERY (NUANSA SEPIA GELAP #472A1C/90) --}}
@if (! $tanpaFoto && $undangan->fiturAktif('galeri') && $undangan->daftarGaleri->isNotEmpty())
<section
    data-layout-galeri="keraton"
    class="relative bg-[#472A1C]/92 py-14 px-5 text-white overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-6 overflow-hidden space-y-2">
        <h2 class="scroll-scrub-kiri font-kaligrafi text-5xl text-white leading-tight">Our Gallery</h2>
        <div class="scroll-scrub-kanan flex items-center justify-center gap-3 text-[10px] font-semibold uppercase tracking-[0.34em] text-[#D7BB83]">
            <span class="h-px w-10 bg-[#D7BB83]/60"></span>
            <span>{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</span>
            <span class="h-px w-10 bg-[#D7BB83]/60"></span>
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
                class="fx-scale-in group relative overflow-hidden border border-[#D7BB83]/55 bg-[#2B180F] shadow-xl cursor-pointer kartu-3d {{ $kelasTile }}"
            >
                <img
                    src="{{ $galeri->urlFoto() }}"
                    alt="{{ $galeri->keterangan ?? 'Galeri Foto' }}"
                    class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-700"
                >
                @if ($galeri->keterangan)
                    <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#2B180F]/90 via-[#2B180F]/35 to-transparent px-3 py-2 text-left text-[10.5px] font-medium text-[#F5E9D6] opacity-0 group-hover:opacity-100 transition duration-300">
                        {{ $galeri->keterangan }}
                    </span>
                @endif
            </button>
        @endforeach
    </div>

    <div class="mt-7 flex items-center justify-center gap-3 text-[10px] font-semibold uppercase tracking-[0.34em] text-[#D7BB83]/85">
        <span class="h-px w-10 bg-[#D7BB83]/50"></span>
        <span>{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</span>
        <span class="h-px w-10 bg-[#D7BB83]/50"></span>
    </div>
</section>
@endif
