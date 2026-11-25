{{-- SEKSI 3: ASYMMETRIC MAGAZINE DOSSIER SPREADS (01 / WHITE SHEET GROOM & 02 / OBSIDIAN NOIR BRIDE) --}}
<section
    id="ed-bab-02"
    data-layout-mempelai="editorial"
    class="relative bg-[#FAF9F6] px-5 pb-14 pt-4 overflow-x-clip"
>
    <div class="max-w-md mx-auto space-y-9">
        <div
            data-masthead-lengket
            class="sticky {{ $tampilBarDemo ? 'top-14' : 'top-0' }} z-30 -mx-5 px-5 py-3 bg-[#FAF9F6]/95 backdrop-blur-md ed-mono flex items-center justify-between border-b border-[#18181B] text-[9.5px] font-bold uppercase tracking-[0.3em] text-[#18181B]"
        >
            <span>01 / DOSSIER</span>
            <span>THE COUPLE</span>
        </div>

        {{-- 01 / THE GROOM — GALLERY IVORY SHEET --}}
        <article class="relative bg-white border border-[#18181B] p-5 ed-bayangan-tajam kartu-3d space-y-4">
            <div data-gsap="turun" class="flex items-center justify-between border-b border-[#18181B]/15 pb-2.5">
                <div class="flex items-baseline gap-2.5">
                    <span class="ed-serif ed-angka-outline text-3xl leading-none">01</span>
                    <span class="ed-mono text-[9.5px] font-bold uppercase tracking-[0.28em] text-[#52525B]">01 / The Groom</span>
                </div>
                <img src="{{ $asetEditorial['bingkai'] }}" alt="" class="w-5 opacity-70">
            </div>

            <div class="grid grid-cols-12 gap-4 items-center">
                @if (! $tanpaFoto && $undangan->urlFotoPria())
                    <div data-gsap="potret" class="col-span-5">
                        <div class="ed-tirai-foto border border-[#18181B] p-1 bg-[#FAF9F6]">
                            <img
                                src="{{ $undangan->urlFotoPria() }}"
                                alt="{{ $undangan->nama_lengkap_pria }}"
                                :class="modeWarnaEditorial ? 'grayscale-0' : 'grayscale hover:grayscale-0'"
                                class="w-full aspect-[3/4] object-cover object-top contrast-[1.06] transition duration-500"
                            >
                        </div>
                    </div>
                @endif

                <div class="{{ (! $tanpaFoto && $undangan->urlFotoPria()) ? 'col-span-7 text-left' : 'col-span-12 text-left' }} space-y-1.5">
                    <h3 data-gsap="kiri" data-gsap-delay="0.05" class="ed-serif text-3xl uppercase tracking-wide text-[#18181B] leading-none">
                        {{ $undangan->nama_panggilan_pria }}
                    </h3>
                    <p data-gsap="teks" data-gsap-delay="0.08" class="text-xs font-bold uppercase tracking-wider text-[#18181B] pt-0.5">
                        {{ $undangan->nama_lengkap_pria }}
                    </p>
                    @if ($undangan->nama_ayah_pria || $undangan->nama_ibu_pria)
                        <p data-gsap="teks" data-gsap-delay="0.11" class="text-xs text-[#52525B] leading-relaxed border-l-2 border-[#18181B]/25 pl-2.5">
                            Putra dari {{ $undangan->nama_ayah_pria }} &amp; {{ $undangan->nama_ibu_pria }}
                        </p>
                    @endif
                    @if ($instagramPria !== '')
                        <a
                            data-gsap="mekar"
                            data-gsap-delay="0.13"
                            href="https://instagram.com/{{ $instagramPria }}"
                            target="_blank"
                            rel="noopener"
                            class="ed-btn-invert mt-2 inline-flex items-center gap-1.5 border border-[#18181B] px-3 py-1 text-[9.5px] ed-mono font-bold uppercase tracking-wider text-[#18181B] hover:bg-[#18181B] hover:text-white transition"
                        >
                            <svg class="w-3 h-3 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg>
                            <span>&#64;{{ $instagramPria }}</span>
                        </a>
                    @endif
                </div>
            </div>
        </article>

        {{-- 02 / THE BRIDE — INVERTED OBSIDIAN NOIR SPREAD --}}
        <article class="relative bg-[#141417] text-[#FAF9F6] border border-[#18181B] p-5 shadow-[-6px_6px_0_0_#71717A] kartu-3d space-y-4">
            <div data-gsap="turun" class="flex items-center justify-between border-b border-white/15 pb-2.5">
                <img src="{{ $asetEditorial['bingkai'] }}" alt="" class="w-5 opacity-75 invert">
                <div class="flex items-baseline gap-2.5">
                    <span class="ed-mono text-[9.5px] font-bold uppercase tracking-[0.28em] text-white/65">02 / The Bride</span>
                    <span class="ed-serif ed-teks-garis text-3xl leading-none">02</span>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-4 items-center">
                <div class="{{ (! $tanpaFoto && $undangan->urlFotoWanita()) ? 'col-span-7 text-left' : 'col-span-12 text-left' }} space-y-1.5">
                    <h3 data-gsap="kanan" data-gsap-delay="0.05" class="ed-serif text-3xl uppercase tracking-wide text-white leading-none">
                        {{ $undangan->nama_panggilan_wanita }}
                    </h3>
                    <p data-gsap="teks" data-gsap-delay="0.08" class="text-xs font-bold uppercase tracking-wider text-white/90 pt-0.5">
                        {{ $undangan->nama_lengkap_wanita }}
                    </p>
                    @if ($undangan->nama_ayah_wanita || $undangan->nama_ibu_wanita)
                        <p data-gsap="teks" data-gsap-delay="0.11" class="text-xs text-white/70 leading-relaxed border-l-2 border-white/30 pl-2.5">
                            Putri dari {{ $undangan->nama_ayah_wanita }} &amp; {{ $undangan->nama_ibu_wanita }}
                        </p>
                    @endif
                    @if ($instagramWanita !== '')
                        <a
                            data-gsap="mekar"
                            data-gsap-delay="0.13"
                            href="https://instagram.com/{{ $instagramWanita }}"
                            target="_blank"
                            rel="noopener"
                            class="ed-btn-invert mt-2 inline-flex items-center gap-1.5 border border-white/60 px-3 py-1 text-[9.5px] ed-mono font-bold uppercase tracking-wider text-white hover:bg-white hover:text-[#111113] transition"
                        >
                            <svg class="w-3 h-3 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg>
                            <span>&#64;{{ $instagramWanita }}</span>
                        </a>
                    @endif
                </div>

                @if (! $tanpaFoto && $undangan->urlFotoWanita())
                    <div data-gsap="potret" data-gsap-delay="0.06" class="col-span-5">
                        <div class="ed-tirai-foto border border-white/40 p-1 bg-black">
                            <img
                                src="{{ $undangan->urlFotoWanita() }}"
                                alt="{{ $undangan->nama_lengkap_wanita }}"
                                :class="modeWarnaEditorial ? 'grayscale-0' : 'grayscale hover:grayscale-0'"
                                class="w-full aspect-[3/4] object-cover object-top contrast-[1.06] transition duration-500"
                            >
                        </div>
                    </div>
                @endif
            </div>
        </article>
    </div>
</section>

{{-- SEKSI 4A: 35MM FILMSTRIP CONTACT-SHEET SLIDESHOW (TERSEMBUNYI SAAT MODE TANPA FOTO) --}}
@if ($fotoGaleriSlideshow->isNotEmpty())
<div
    data-slideshow-editorial
    data-gsap="potret"
    x-data="{
        slideAktif: 0,
        jumlah: {{ $fotoGaleriSlideshow->count() }},
        timerSlide: null,
        init() {
            if (this.jumlah > 1) {
                this.timerSlide = setInterval(() => {
                    this.slideAktif = (this.slideAktif + 1) % this.jumlah;
                }, 4000);
            }
        },
        pilihSlide(idx) {
            this.slideAktif = (idx + this.jumlah) % this.jumlah;
        }
    }"
    class="relative w-full bg-[#0B0B0E] border-t border-[#18181B] select-none overflow-hidden"
>
    {{-- Lubang Sprocket Film 35mm Atas --}}
    <div aria-hidden="true" class="px-3 py-1.5 bg-[#09090B] border-b border-white/15 flex items-center justify-between gap-2">
        @for ($s = 0; $s < 12; $s++)
            <span class="h-2 w-3 border border-white/25 bg-white/[0.04]"></span>
        @endfor
    </div>

    <div class="relative h-72 sm:h-80 w-full overflow-hidden bg-[#111113]">
        @foreach ($fotoGaleriSlideshow as $idxSlide => $urlSlide)
            <img
                src="{{ $urlSlide }}"
                alt="Potret Editorial {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                loading="lazy"
                decoding="async"
                :class="[
                    slideAktif === {{ $idxSlide }} ? 'opacity-92 scale-105' : 'opacity-0 scale-100',
                    modeWarnaEditorial ? 'grayscale-0' : 'grayscale'
                ]"
                class="absolute inset-0 w-full h-full object-cover object-top contrast-[1.08]"
                style="transition: opacity 0.95s cubic-bezier(0.22, 1, 0.36, 1), transform 4.8s ease, filter 0.6s ease;"
            >
        @endforeach

        <div
            aria-hidden="true"
            class="pointer-events-none absolute inset-0"
            style="background: linear-gradient(180deg, rgba(11,11,14,0.45) 0%, rgba(11,11,14,0.04) 30%, rgba(17,17,20,0.22) 66%, #18181B 100%);"
        ></div>

        {{-- Telemetri Frame Film & Kontrol Geser Manual --}}
        <div class="absolute inset-x-4 top-3 z-20 flex items-center justify-between ed-mono text-[9px] uppercase tracking-[0.24em] text-white/85">
            <span class="bg-black/65 backdrop-blur-xs border border-white/25 px-2.5 py-1">
                ROLL 01 &middot; FR <span x-text="String(slideAktif + 1).padStart(2, '0')">01</span>/<span x-text="String(jumlah).padStart(2, '0')">01</span>
            </span>

            @if ($fotoGaleriSlideshow->count() > 1)
                <div class="inline-flex items-center border border-white/30 bg-black/65 backdrop-blur-xs">
                    <button type="button" @click="pilihSlide(slideAktif - 1)" aria-label="Frame sebelumnya" class="px-2 py-1 text-white hover:bg-white hover:text-black transition cursor-pointer">&larr;</button>
                    <button type="button" @click="pilihSlide(slideAktif + 1)" aria-label="Frame berikutnya" class="px-2 py-1 text-white border-l border-white/25 hover:bg-white hover:text-black transition cursor-pointer">&rarr;</button>
                </div>
            @endif
        </div>
    </div>

    {{-- Lubang Sprocket Film 35mm Bawah --}}
    <div aria-hidden="true" class="px-3 py-1.5 bg-[#09090B] border-y border-white/15 flex items-center justify-between gap-2">
        @for ($s = 0; $s < 12; $s++)
            <span class="h-2 w-3 border border-white/25 bg-white/[0.04]"></span>
        @endfor
    </div>
</div>
@endif

{{-- SEKSI 4B: MECHANICAL SPLIT-FLAP ARCHITECTURAL COUNTDOWN --}}
@if ($undangan->fiturAktif('hitung_mundur') && $isoTarget)
<section
    id="ed-bab-03"
    data-layout-countdown="editorial"
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
    class="relative bg-[#18181B] shadow-[0_-2px_0_0_#18181B] text-[#FAF9F6] px-5 pt-4 pb-14 overflow-x-clip"
>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 ed-film-grain opacity-30"></div>

    <div class="relative z-10 max-w-md mx-auto space-y-6">
        <div
            data-masthead-lengket
            class="sticky {{ $tampilBarDemo ? 'top-14' : 'top-0' }} z-30 -mx-5 px-5 py-3 bg-[#18181B]/95 backdrop-blur-md ed-mono flex items-center justify-between text-[9.5px] uppercase tracking-[0.3em] text-white/70 border-b border-white/20"
        >
            <span>02 / CHRONOMETER</span>
            <span>COUNTDOWN</span>
        </div>

        <div class="text-left space-y-1">
            <h2 data-gsap="naik" data-gsap-delay="0.05" class="ed-serif text-3xl sm:text-4xl uppercase tracking-[0.06em] text-white">
                Save The Date
            </h2>
            <p class="ed-mono text-[9.5px] uppercase tracking-[0.22em] text-white/60">{{ $tanggalLengkap }}</p>
        </div>

        {{-- Kotak Split-Flap Mekanis Arsitektural --}}
        <div class="grid grid-cols-4 gap-2.5 text-center">
            @foreach (['hari' => 'DAYS', 'jam' => 'HRS', 'menit' => 'MIN', 'detik' => 'SEC'] as $var => $label)
                <div data-gsap="mekar" data-gsap-delay="{{ number_format($loop->index * 0.06, 2, '.', '') }}" class="relative bg-[#0D0D10] border border-white/30 pt-3.5 pb-3 px-1 shadow-[4px_4px_0_0_rgba(255,255,255,0.14)]">
                    {{-- Garis Belah Tengah Split-Flap --}}
                    <span aria-hidden="true" class="pointer-events-none absolute inset-x-0 top-[44%] h-px bg-white/15"></span>
                    <div
                        class="relative z-10 ed-serif text-3xl sm:text-4xl text-white leading-none tabular-nums"
                        x-text="{{ $var }}"
                        x-effect="if ({{ $var }}) { $el.classList.remove('angka-flip-3d'); void $el.offsetWidth; $el.classList.add('angka-flip-3d'); }"
                    >00</div>
                    <div class="mt-2.5 ed-mono text-[8.5px] uppercase tracking-[0.24em] text-white/55">{{ $label }}</div>
                </div>
            @endforeach
        </div>

        @if ($googleCalUrl)
            <a
                data-gsap="mekar"
                data-gsap-delay="0.12"
                href="{{ $googleCalUrl }}"
                target="_blank"
                rel="noopener"
                class="ed-btn-invert flex items-center justify-between w-full bg-[#FAF9F6] text-[#18181B] border border-white px-5 py-3 text-[11px] font-bold uppercase tracking-[0.24em] hover:bg-white transition"
            >
                <span>Simpan ke Kalender</span>
                <span class="ed-mono">&rarr;</span>
            </a>
        @endif
    </div>
</section>
@endif

{{-- SEKSI 5: DIE-CUT PERFORATED EXHIBITION / BOARDING-PASS EVENT TICKETS --}}
@if ($undangan->daftarAcara->isNotEmpty())
<section
    id="ed-bab-04"
    data-layout-acara="editorial"
    class="relative bg-[#FAF9F6] px-5 pt-4 pb-14 overflow-x-clip"
>
    <div class="max-w-md mx-auto space-y-7">
        <div
            data-masthead-lengket
            class="sticky {{ $tampilBarDemo ? 'top-14' : 'top-0' }} z-30 -mx-5 px-5 py-3 bg-[#FAF9F6]/95 backdrop-blur-md ed-mono flex items-center justify-between border-b border-[#18181B] text-[9.5px] font-bold uppercase tracking-[0.3em] text-[#18181B]"
        >
            <span>02 / ITINERARY</span>
            <span>EXHIBITION PASS</span>
        </div>

        @foreach ($undangan->daftarAcara as $idx => $acara)
            <article class="relative bg-white border border-[#18181B] text-left ed-bayangan-tajam kartu-3d">
                {{-- Header Tiket Hitam --}}
                <div data-gsap="turun" class="bg-[#18181B] text-white px-5 py-3 flex items-center justify-between ed-mono text-[9.5px] font-bold uppercase tracking-[0.24em]">
                    <span class="inline-flex items-center gap-2">
                        <span class="inline-block h-1.5 w-1.5 bg-white"></span>
                        <span>PASS {{ sprintf('%02d', $idx + 1) }} &middot; ADMIT ONE</span>
                    </span>
                    <span>{{ $acara->tanggal_acara->format('d.m.Y') }}</span>
                </div>

                {{-- Bagian Atas Tiket: Judul & Jadwal --}}
                <div class="px-5 pt-5 pb-4 space-y-3">
                    <div class="flex items-start justify-between gap-3">
                        <h3 data-gsap="mekar" data-gsap-delay="0.05" class="ed-serif text-2xl sm:text-[1.7rem] uppercase tracking-wide text-[#18181B] leading-tight">
                            {{ $acara->nama_acara }}
                        </h3>
                        <span class="ed-mono shrink-0 border border-[#18181B] px-2 py-0.5 text-[9px] font-bold uppercase tracking-widest text-[#18181B]">
                            {{ $acara->zona_waktu }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-3 pt-1 text-xs">
                        <div data-gsap="kiri" data-gsap-delay="0.08" class="border-l-2 border-[#18181B] pl-2.5">
                            <span class="ed-mono block text-[8.5px] uppercase tracking-[0.24em] text-[#52525B]">DATE</span>
                            <span class="font-bold text-[#18181B]">{{ $acara->tanggal_acara->locale('id')->translatedFormat('l, d F Y') }}</span>
                        </div>
                        <div data-gsap="kanan" data-gsap-delay="0.1" class="border-l-2 border-[#18181B] pl-2.5">
                            <span class="ed-mono block text-[8.5px] uppercase tracking-[0.24em] text-[#52525B]">TIME</span>
                            <span class="ed-mono font-bold text-[#18181B]">
                                {{ \Illuminate\Support\Str::substr($acara->waktu_mulai, 0, 5) }}
                                @if ($acara->waktu_selesai) &ndash; {{ \Illuminate\Support\Str::substr($acara->waktu_selesai, 0, 5) }} @endif
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Garis Sobekan Tiket + Lekukan Setengah Lingkaran Kiri & Kanan --}}
                <div class="relative py-1 flex items-center" aria-hidden="true">
                    <span class="absolute -left-[9px] h-4 w-4 rounded-full bg-[#FAF9F6] border-r border-[#18181B]"></span>
                    <div class="w-full border-t border-dashed border-[#18181B]/45 mx-3"></div>
                    <span class="absolute -right-[9px] h-4 w-4 rounded-full bg-[#FAF9F6] border-l border-[#18181B]"></span>
                </div>

                {{-- Bagian Bawah Tiket: Lokasi + Barcode + Peta --}}
                <div class="px-5 pt-3.5 pb-5 space-y-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="space-y-1 min-w-0">
                            <span data-gsap="turun" data-gsap-delay="0.11" class="ed-mono block text-[8.5px] uppercase tracking-[0.24em] text-[#52525B]">VENUE LOCATION</span>
                            <p data-gsap="naik" data-gsap-delay="0.12" class="font-bold text-sm text-[#18181B]">{{ $acara->nama_tempat }}</p>
                            <p data-gsap="teks" data-gsap-delay="0.14" class="text-xs text-[#52525B] leading-relaxed">{{ $acara->alamat_lengkap }}</p>
                        </div>

                        <div aria-hidden="true" class="shrink-0 flex items-end gap-[2px] h-10 pt-1 opacity-70">
                            <span class="w-[2px] h-full bg-[#18181B]"></span>
                            <span class="w-px h-7 bg-[#18181B]"></span>
                            <span class="w-[3px] h-full bg-[#18181B]"></span>
                            <span class="w-px h-8 bg-[#18181B]"></span>
                            <span class="w-[2px] h-full bg-[#18181B]"></span>
                            <span class="w-px h-6 bg-[#18181B]"></span>
                        </div>
                    </div>

                    @if ($acara->link_maps)
                        <a
                            data-gsap="mekar"
                            data-gsap-delay="0.16"
                            href="{{ $acara->link_maps }}"
                            target="_blank"
                            rel="noopener"
                            class="ed-btn-invert flex items-center justify-between w-full bg-[#18181B] text-white px-4 py-2.5 text-[10.5px] font-bold uppercase tracking-[0.24em] hover:bg-black transition"
                        >
                            <span>Open Google Maps</span>
                            <span class="ed-mono">&rarr;</span>
                        </a>
                    @endif
                </div>
            </article>
        @endforeach
    </div>
</section>
@endif

{{-- SEKSI 6: PANTONE-STYLE DRESS CODE SWATCHES & LIVE BROADCAST --}}
@if ($adaDressCode || (! empty($live['aktif']) && ! empty($live['link'])))
<section class="relative bg-[#FAF9F6] px-5 pb-10 space-y-6 overflow-hidden">
    @if ($adaDressCode)
        <div data-section-dress-code="editorial" class="max-w-md mx-auto bg-white border border-[#18181B] p-5 text-left space-y-3.5 ed-bayangan-tajam">
            <div class="ed-mono flex items-center justify-between text-[9px] font-bold uppercase tracking-[0.28em] text-[#52525B] border-b border-[#18181B]/15 pb-2">
                <span>ATTIRE PALETTE</span>
                <span>SWATCH CARD</span>
            </div>
            @if ($dressCodeCatatan !== '')
                <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs text-[#18181B]/85 leading-relaxed">{{ $dressCodeCatatan }}</p>
            @endif
            @if (! empty($dressCodeWarna))
                <div class="grid grid-cols-4 gap-2.5 pt-1">
                    @foreach ($dressCodeWarna as $hex)
                        <div data-gsap="mekar" data-gsap-delay="{{ number_format($loop->index * 0.05, 2, '.', '') }}" class="border border-[#18181B] p-1 bg-white">
                            <span class="block h-9 w-full border border-[#18181B]/20" style="background-color: {{ $hex }};"></span>
                            <span class="ed-mono block pt-1 text-[8.5px] font-bold uppercase text-[#18181B] truncate">{{ $hex }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    @if (! empty($live['aktif']) && ! empty($live['link']))
        <div class="max-w-md mx-auto bg-[#18181B] text-white border border-[#18181B] p-5 text-left space-y-3">
            <div class="ed-mono flex items-center justify-between text-[9px] uppercase tracking-[0.28em] text-white/65">
                <span class="inline-flex items-center gap-1.5">
                    <span class="inline-block h-2 w-2 rounded-full bg-rose-500 animate-pulse"></span>
                    <span>LIVE BROADCAST</span>
                </span>
                <span>STREAM</span>
            </div>
            <h3 data-gsap="naik" data-gsap-delay="0.05" class="ed-serif text-2xl uppercase">Live Streaming</h3>
            <p data-gsap="teks" data-gsap-delay="0.09" class="text-xs text-white/75 leading-relaxed">
                Saksikan siaran langsung acara melalui {{ $live['platform'] ?? 'YouTube / Instagram Live' }}.
            </p>
            <a data-gsap="mekar" data-gsap-delay="0.12" href="{{ $live['link'] }}" target="_blank" rel="noopener" class="ed-btn-invert inline-flex items-center gap-2 bg-white text-[#18181B] px-5 py-2.5 text-[10.5px] font-bold uppercase tracking-[0.24em] hover:bg-neutral-200 transition">
                <span>Watch Stream</span>
                <span class="ed-mono">&rarr;</span>
            </a>
        </div>
    @endif
</section>
@endif

{{-- SEKSI 7: 03 / STORYLINE — HORIZONTAL DRAG & SWIPE MAGAZINE LOOKBOOK SPREAD --}}
@if ($undangan->fiturAktif('cerita_cinta') && ! empty($ceritaList))
<section
    id="ed-bab-05"
    data-layout-cerita="editorial"
    x-data="{
        babAktifLokal: 0,
        progresCerita: {{ count($ceritaList) > 1 ? number_format(100 / count($ceritaList), 2, '.', '') : '100' }},
        totalBab: {{ count($ceritaList) }},
        sinkronScrollCerita() {
            const el = this.$refs.jalurCerita;
            if (!el) return;
            const maks = Math.max(1, el.scrollWidth - el.clientWidth);
            const rasio = Math.min(1, Math.max(0, el.scrollLeft / maks));
            this.babAktifLokal = Math.min(this.totalBab - 1, Math.round(rasio * (this.totalBab - 1)));
            this.progresCerita = ((this.babAktifLokal + 1) / this.totalBab) * 100;
        },
        keBab(idx) {
            const target = (idx + this.totalBab) % this.totalBab;
            this.babAktifLokal = target;
            const el = this.$refs.jalurCerita;
            if (!el) return;
            const kartu = el.children[target];
            if (kartu) {
                el.scrollTo({ left: kartu.offsetLeft - 4, behavior: 'smooth' });
            }
        }
    }"
    class="relative bg-[#FAF9F6] px-5 pt-4 pb-14 border-t border-[#18181B]/15 overflow-x-clip"
>
    <div class="max-w-md mx-auto space-y-5">
        <div
            data-masthead-lengket
            class="sticky {{ $tampilBarDemo ? 'top-14' : 'top-0' }} z-30 -mx-5 px-5 py-3 bg-[#FAF9F6]/95 backdrop-blur-md ed-mono flex items-center justify-between border-b border-[#18181B] text-[9.5px] font-bold uppercase tracking-[0.3em] text-[#18181B]"
        >
            <span>03 / CHRONICLE</span>
            @if (count($ceritaList) > 1)
                <button
                    type="button"
                    @click="semuaBabCerita = !semuaBabCerita; window.SesiTemuSinema?.refresh(80)"
                    class="ed-mono border border-[#18181B] px-2.5 py-0.5 text-[8.5px] font-bold uppercase tracking-[0.18em] transition cursor-pointer"
                    :class="semuaBabCerita ? 'bg-[#18181B] text-white' : 'bg-white text-[#18181B] hover:bg-[#18181B] hover:text-white'"
                    x-text="semuaBabCerita ? 'MODE GESER' : 'LIHAT SEMUA'"
                >LIHAT SEMUA</button>
            @else
                <span>STORY ISSUE</span>
            @endif
        </div>

        <div data-scroll-scrub class="overflow-hidden">
            <div data-gsap="kanan" class="flex items-end justify-between gap-3">
                <h2 class="scroll-scrub-kanan ed-serif text-3xl sm:text-4xl uppercase tracking-wide text-[#18181B]">Kisah Kami</h2>
                @if (count($ceritaList) > 1)
                    <span x-show="!semuaBabCerita" class="ed-mono text-[8.5px] uppercase tracking-[0.22em] text-[#52525B] pb-1">
                        SWIPE &harr;
                    </span>
                @endif
            </div>
        </div>

        {{-- Baris Indeks Bab + Jalur Horizontal Lookbook (Default) --}}
        <div x-show="!semuaBabCerita" class="space-y-3.5">
            @if (count($ceritaList) > 1)
                <div class="flex items-stretch border border-[#18181B] bg-[#18181B] overflow-x-auto no-scrollbar">
                    @foreach ($ceritaList as $idx => $cerita)
                        <button
                            type="button"
                            @click="keBab({{ $idx }})"
                            :class="babAktifLokal === {{ $idx }} ? 'bg-white text-[#18181B]' : 'bg-[#18181B] text-white/70 hover:text-white'"
                            class="ed-mono flex-1 min-w-[76px] py-2 px-3 text-[9px] font-bold uppercase tracking-[0.2em] border-r border-white/15 last:border-r-0 transition cursor-pointer"
                        >
                            CH. {{ sprintf('%02d', $idx + 1) }}
                        </button>
                    @endforeach
                </div>
            @endif

            <div
                x-ref="jalurCerita"
                data-horizontal-editorial
                data-lookbook-cerita="editorial"
                @scroll.passive="sinkronScrollCerita()"
                class="flex gap-4 overflow-x-auto snap-x snap-mandatory pb-3 pr-4 no-scrollbar cursor-grab select-none"
            >
                @foreach ($ceritaList as $idx => $cerita)
                    @php
                        $urlFotoBab = (! $tanpaFoto && ! empty($cerita['foto']))
                            ? \App\Support\MediaPublik::url((string) $cerita['foto'])
                            : null;
                    @endphp
                    <article class="{{ count($ceritaList) > 1 ? 'w-[86%] sm:w-[84%]' : 'w-full' }} shrink-0 snap-start bg-white border border-[#18181B] p-5 ed-bayangan-tajam space-y-4 text-left">
                        <div class="flex items-baseline justify-between gap-3 border-b border-[#18181B]/15 pb-3">
                            <span class="ed-serif ed-angka-outline text-4xl leading-none">
                                {{ sprintf('%02d', $idx + 1) }}
                            </span>
                            @if (! empty($cerita['tanggal']))
                                <span class="ed-mono border border-[#18181B] px-2.5 py-0.5 text-[9px] font-bold uppercase tracking-[0.2em] text-[#18181B]">
                                    {{ $cerita['tanggal'] }}
                                </span>
                            @endif
                        </div>

                        @if ($urlFotoBab)
                            <div class="ed-tirai-foto border border-[#18181B] p-1 bg-[#FAF9F6]">
                                <img
                                    src="{{ $urlFotoBab }}"
                                    alt="{{ $cerita['judul'] ?? 'Kisah Kami' }}"
                                    draggable="false"
                                    :class="modeWarnaEditorial ? 'grayscale-0' : 'grayscale hover:grayscale-0'"
                                    class="w-full aspect-[16/10] object-cover object-center contrast-[1.06] transition duration-500"
                                >
                            </div>
                        @endif

                        <div class="space-y-2">
                            <h3 class="ed-serif text-xl sm:text-2xl uppercase tracking-wide text-[#18181B]">
                                {{ $cerita['judul'] ?? '' }}
                            </h3>
                            <p class="text-xs sm:text-[13px] text-[#52525B] leading-relaxed">
                                {{ $cerita['cerita'] ?? '' }}
                            </p>
                        </div>
                    </article>
                @endforeach
            </div>

            @if (count($ceritaList) > 1)
                <div class="flex items-center gap-3 pt-0.5 ed-mono text-[9px] font-bold uppercase tracking-[0.2em]">
                    <button
                        type="button"
                        @click="keBab(babAktifLokal - 1)"
                        class="border border-[#18181B] bg-white px-2.5 py-1 text-[#18181B] hover:bg-[#18181B] hover:text-white transition cursor-pointer"
                    >
                        &larr; PREV
                    </button>
                    <div class="h-[3px] flex-1 bg-[#18181B]/15 overflow-hidden">
                        <div class="h-full bg-[#18181B] transition-all duration-300" :style="'width: ' + progresCerita + '%'"></div>
                    </div>
                    <span class="text-[#52525B] tabular-nums">
                        <span x-text="String(babAktifLokal + 1).padStart(2, '0')">01</span>/{{ sprintf('%02d', count($ceritaList)) }}
                    </span>
                    <button
                        type="button"
                        @click="keBab(babAktifLokal + 1)"
                        class="border border-[#18181B] bg-white px-2.5 py-1 text-[#18181B] hover:bg-[#18181B] hover:text-white transition cursor-pointer"
                    >
                        NEXT &rarr;
                    </button>
                </div>
            @endif
        </div>

        {{-- Mode Lihat Semua (Vertikal Penuh) --}}
        <div x-show="semuaBabCerita" x-cloak x-transition.opacity.duration.250ms class="bg-white border border-[#18181B] ed-bayangan-tajam divide-y divide-[#18181B]/20">
            @foreach ($ceritaList as $idx => $cerita)
                @php
                    $urlFotoBab = (! $tanpaFoto && ! empty($cerita['foto']))
                        ? \App\Support\MediaPublik::url((string) $cerita['foto'])
                        : null;
                @endphp
                <article class="p-5 sm:p-6 space-y-4 text-left">
                    <div class="flex items-baseline justify-between gap-3 border-b border-[#18181B]/15 pb-3">
                        <span class="ed-serif ed-angka-outline text-4xl leading-none">
                            {{ sprintf('%02d', $idx + 1) }}
                        </span>
                        @if (! empty($cerita['tanggal']))
                            <span class="ed-mono border border-[#18181B] px-2.5 py-0.5 text-[9px] font-bold uppercase tracking-[0.2em] text-[#18181B]">
                                {{ $cerita['tanggal'] }}
                            </span>
                        @endif
                    </div>

                    @if ($urlFotoBab)
                        <div class="ed-tirai-foto ed-terbuka border border-[#18181B] p-1 bg-[#FAF9F6]">
                            <img
                                src="{{ $urlFotoBab }}"
                                alt="{{ $cerita['judul'] ?? 'Kisah Kami' }}"
                                :class="modeWarnaEditorial ? 'grayscale-0' : 'grayscale hover:grayscale-0'"
                                class="w-full aspect-[16/10] object-cover object-center contrast-[1.06] transition duration-500"
                            >
                        </div>
                    @endif

                    <div class="space-y-2">
                        <h3 class="ed-serif text-xl sm:text-2xl uppercase tracking-wide text-[#18181B]">
                            {{ $cerita['judul'] ?? '' }}
                        </h3>
                        <p class="text-xs sm:text-[13px] text-[#52525B] leading-relaxed">
                            {{ $cerita['cerita'] ?? '' }}
                        </p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- SEKSI 8: 04 / PORTRAITS — HORIZONTAL EXHIBITION LOOKBOOK + CONTACT SHEET TOGGLE --}}
@if (! $tanpaFoto && $undangan->fiturAktif('galeri') && $undangan->daftarGaleri->isNotEmpty())
<section
    id="ed-bab-06"
    data-layout-galeri="editorial"
    x-data="{
        modeContactSheet: false,
        plateAktif: 0,
        totalPlate: {{ $undangan->daftarGaleri->count() }},
        progresPlate: {{ $undangan->daftarGaleri->count() > 1 ? number_format(100 / $undangan->daftarGaleri->count(), 2, '.', '') : '100' }},
        sinkronLookbook() {
            const el = this.$refs.jalurGaleriEditorial;
            if (!el) return;
            const maks = Math.max(1, el.scrollWidth - el.clientWidth);
            const rasio = Math.min(1, Math.max(0, el.scrollLeft / maks));
            this.plateAktif = Math.min(this.totalPlate - 1, Math.round(rasio * (this.totalPlate - 1)));
            this.progresPlate = ((this.plateAktif + 1) / this.totalPlate) * 100;
        },
        geserPlate(arah) {
            const el = this.$refs.jalurGaleriEditorial;
            if (!el) return;
            el.scrollBy({ left: arah * Math.round(el.clientWidth * 0.78), behavior: 'smooth' });
        }
    }"
    class="relative bg-[#111113] text-[#FAF9F6] px-5 pt-4 pb-14 overflow-x-clip"
>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 ed-film-grain opacity-30"></div>

    <div class="relative z-10 max-w-md mx-auto space-y-5">
        <div
            data-masthead-lengket
            class="sticky {{ $tampilBarDemo ? 'top-14' : 'top-0' }} z-30 -mx-5 px-5 py-3 bg-[#111113]/95 backdrop-blur-md ed-mono flex items-center justify-between border-b border-white/20 text-[9.5px] font-bold uppercase tracking-[0.3em] text-white/75"
        >
            <span>04 / EXHIBITION</span>
            @if ($undangan->daftarGaleri->count() > 1)
                <button
                    type="button"
                    @click="modeContactSheet = !modeContactSheet; window.SesiTemuSinema?.refresh(80)"
                    class="ed-mono border border-white/40 px-2.5 py-0.5 text-[8.5px] font-bold uppercase tracking-[0.18em] transition cursor-pointer"
                    :class="modeContactSheet ? 'bg-white text-[#111113]' : 'bg-black/60 text-white hover:bg-white hover:text-[#111113]'"
                    x-text="modeContactSheet ? 'MODE LOOKBOOK' : 'CONTACT SHEET'"
                >CONTACT SHEET</button>
            @else
                <span class="text-white/45">TAP TO ENLARGE</span>
            @endif
        </div>

        <div data-scroll-scrub class="overflow-hidden">
            <div data-gsap="kiri" class="flex items-end justify-between gap-3">
                <h2 class="scroll-scrub-kiri ed-serif text-3xl sm:text-4xl uppercase tracking-wide text-white">Editorial Galeri</h2>
                <span class="ed-mono text-[8.5px] uppercase tracking-[0.22em] text-white/50 pb-1" x-text="modeContactSheet ? 'TAP TO ENLARGE' : 'DRAG / SWIPE'">DRAG / SWIPE</span>
            </div>
        </div>

        {{-- Mode Default: Horizontal Exhibition Lookbook Strip --}}
        <div x-show="!modeContactSheet" class="space-y-4">
            <div
                x-ref="jalurGaleriEditorial"
                data-horizontal-editorial
                data-lookbook-galeri="editorial"
                @scroll.passive="sinkronLookbook()"
                class="flex gap-3.5 overflow-x-auto snap-x snap-mandatory pb-2 pr-4 no-scrollbar cursor-grab select-none"
            >
                @foreach ($undangan->daftarGaleri as $galeri)
                    <button
                        type="button"
                        @click="bukaGaleri(@js($galeri->urlFoto()), @js($galeri->keterangan))"
                        class="ed-tirai-foto group relative w-[78%] sm:w-[75%] shrink-0 snap-center aspect-[4/5] overflow-hidden rounded-none border border-white/35 bg-black p-1.5 cursor-pointer shadow-[5px_5px_0_0_rgba(250,249,246,0.18)]"
                    >
                        <div class="relative w-full h-full overflow-hidden bg-[#0A0A0D]">
                            <img
                                src="{{ $galeri->urlFoto() }}"
                                alt="{{ $galeri->keterangan ?? 'Editorial Portrait' }}"
                                draggable="false"
                                :class="modeWarnaEditorial ? 'grayscale-0' : 'grayscale group-hover:grayscale-0'"
                                class="w-full h-full object-cover object-top contrast-[1.06] group-hover:scale-105 transition duration-700"
                            >

                            <span class="pointer-events-none absolute top-2.5 left-2.5 z-10 ed-mono bg-black/80 backdrop-blur-xs border border-white/30 px-2 py-0.5 text-[8.5px] font-bold uppercase tracking-[0.2em] text-white">
                                PL. {{ sprintf('%02d', $loop->iteration) }}
                            </span>

                            <span aria-hidden="true" class="pointer-events-none absolute top-2.5 right-2.5 z-10 h-3 w-3 border-t border-r border-white/85"></span>
                            <span aria-hidden="true" class="pointer-events-none absolute bottom-9 left-2.5 z-10 h-3 w-3 border-b border-l border-white/85"></span>

                            @if ($galeri->keterangan)
                                <span class="pointer-events-none absolute inset-x-0 bottom-0 z-10 bg-black/85 border-t border-white/15 px-3 py-2 text-left ed-mono text-[9px] uppercase tracking-wider text-white/90 truncate">
                                    {{ $galeri->keterangan }}
                                </span>
                            @endif
                        </div>
                    </button>
                @endforeach
            </div>

            @if ($undangan->daftarGaleri->count() > 1)
                <div class="flex items-center gap-3 ed-mono text-[9px] font-bold uppercase tracking-[0.2em] text-white/80">
                    <button
                        type="button"
                        @click="geserPlate(-1)"
                        aria-label="Plate sebelumnya"
                        class="border border-white/35 bg-white/[0.04] px-2.5 py-1 hover:bg-white hover:text-[#111113] transition cursor-pointer"
                    >
                        &larr;
                    </button>
                    <div class="h-[2px] flex-1 bg-white/15 overflow-hidden">
                        <div class="h-full bg-white transition-all duration-300" :style="'width: ' + progresPlate + '%'"></div>
                    </div>
                    <span class="tabular-nums text-white/65">
                        PL <span x-text="String(plateAktif + 1).padStart(2, '0')">01</span>/{{ sprintf('%02d', $undangan->daftarGaleri->count()) }}
                    </span>
                    <button
                        type="button"
                        @click="geserPlate(1)"
                        aria-label="Plate berikutnya"
                        class="border border-white/35 bg-white/[0.04] px-2.5 py-1 hover:bg-white hover:text-[#111113] transition cursor-pointer"
                    >
                        &rarr;
                    </button>
                </div>
            @endif
        </div>

        {{-- Mode Contact Sheet 12-Kolom (Bebas data-gsap tersembunyi & tirai langsung terbuka agar tampil instan) --}}
        <div x-show="modeContactSheet" x-cloak x-transition.opacity.duration.250ms class="grid grid-cols-12 items-stretch gap-3">
            @foreach ($undangan->daftarGaleri as $galeri)
                @php
                    $kelasTile = \App\Support\DataTemaUndangan::kelasGridGaleri($loop->index, $loop->count, 'editorial');
                @endphp
                <button
                    type="button"
                    @click="bukaGaleri(@js($galeri->urlFoto()), @js($galeri->keterangan))"
                    class="ed-tirai-foto ed-terbuka group relative overflow-hidden rounded-none border border-white/30 bg-black cursor-pointer kartu-3d {{ $kelasTile }}"
                >
                    <img
                        src="{{ $galeri->urlFoto() }}"
                        alt="{{ $galeri->keterangan ?? 'Editorial Portrait' }}"
                        :class="modeWarnaEditorial ? 'grayscale-0' : 'grayscale group-hover:grayscale-0'"
                        class="w-full h-full object-cover object-top contrast-[1.06] group-hover:scale-105 transition duration-700"
                    >

                    <span class="pointer-events-none absolute top-2 left-2 z-10 ed-mono bg-black/75 backdrop-blur-xs border border-white/25 px-1.5 py-0.5 text-[8px] font-bold uppercase tracking-[0.2em] text-white/90">
                        PL. {{ sprintf('%02d', $loop->iteration) }}
                    </span>

                    <span aria-hidden="true" class="pointer-events-none absolute top-2 right-2 z-10 h-2.5 w-2.5 border-t border-r border-white opacity-0 group-hover:opacity-100 transition"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute bottom-2 left-2 z-10 h-2.5 w-2.5 border-b border-l border-white opacity-0 group-hover:opacity-100 transition"></span>

                    @if ($galeri->keterangan)
                        <span class="pointer-events-none absolute inset-x-0 bottom-0 z-10 bg-black/80 px-3 py-2 text-left ed-mono text-[9px] uppercase tracking-wider text-white/90 truncate">
                            {{ $galeri->keterangan }}
                        </span>
                    @endif
                </button>
            @endforeach
        </div>
    </div>
</section>
@endif
