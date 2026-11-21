{{-- SEKSI 3: HITUNG MUNDUR — 4 KUBAH MINI SAFIR-EMAS (DI ATAS MEMPELAI AGAR RITME UNIK!) --}}
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
    class="relative bg-[#091322] px-5 py-12 text-center border-y border-[#D9B664]/30 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-5">
        <p class="text-[10px] font-semibold uppercase tracking-[0.34em] text-[#D9B664]">Menuju Hari Berkah</p>
        <h2 class="fx-rise font-serif text-3xl font-bold text-[#F3E5AB]">Save The Date</h2>

        {{-- 4 Kubah Mini Masjid --}}
        <div class="grid grid-cols-4 gap-2.5 pt-2">
            @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                <div class="rounded-t-full rounded-b-xl bg-[#132438] border border-[#D9B664]/55 pt-5 pb-3 px-1 shadow-lg">
                    <div class="font-serif text-2xl sm:text-3xl font-bold text-[#F3E5AB] leading-none" x-text="{{ $var }}">00</div>
                    <div class="mt-1.5 text-[9px] uppercase tracking-widest font-semibold text-[#D9B664]">{{ $label }}</div>
                </div>
            @endforeach
        </div>

        @if ($googleCalUrl)
            <div class="pt-2">
                <a
                    href="{{ $googleCalUrl }}"
                    target="_blank"
                    rel="noopener"
                    class="celestial-tombol-emas inline-flex items-center gap-2 rounded-full px-7 py-2.5 text-xs font-bold uppercase tracking-wider transition"
                >
                    <span>Simpan ke Kalender</span>
                </a>
            </div>
        @endif
    </div>
</section>
@endif

{{-- SEKSI 4: MEMPELAI DI DALAM MIHRAB LENGKUNG + BINTANG RUB EL HIZB BERPUTAR --}}
<section
    data-layout-mempelai="celestial"
    class="relative px-4 py-12 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-7">
        <div class="fx-rise text-center space-y-1.5">
            <img src="{{ $asetCelestial['sabit'] }}" alt="" class="w-10 mx-auto animasi-ayun-3d">
            <p class="text-[10px] font-semibold uppercase tracking-[0.34em] text-[#D9B664]">Calon Mempelai</p>
            <h2 class="font-serif text-3xl font-bold text-white">Mempelai Berbahagia</h2>
        </div>

        {{-- MIHRAB MEMPELAI PRIA --}}
        <article class="fx-slide-left rounded-t-[9rem] rounded-b-3xl bg-[#132438]/95 border border-[#D9B664]/55 px-6 pt-10 pb-8 text-center shadow-2xl kartu-3d efek-shimmer-kartu space-y-3">
            @if (! $tanpaFoto && $undangan->urlFotoPria())
                <div class="relative mx-auto w-44 h-52 p-1.5 rounded-t-full rounded-b-2xl border-2 border-[#D9B664]/75 bg-[#091322]">
                    <img
                        src="{{ $undangan->urlFotoPria() }}"
                        alt="{{ $undangan->nama_lengkap_pria }}"
                        class="w-full h-full rounded-t-full rounded-b-xl object-cover object-top"
                    >
                </div>
            @else
                <div class="relative mx-auto w-24 h-24 flex items-center justify-center">
                    <span class="absolute inset-0 rounded-full border border-dashed border-[#D9B664]/65 animasi-orbit"></span>
                    <span class="font-serif text-3xl font-bold text-[#F3E5AB]">{{ $undangan->inisialPria() }}</span>
                </div>
            @endif

            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#D9B664]">Mempelai Pria</p>
            <h3 class="font-kaligrafi text-5xl text-[#F3E5AB] leading-tight">{{ $undangan->nama_panggilan_pria }}</h3>
            <p class="font-serif text-base font-bold text-white">{{ $undangan->nama_lengkap_pria }}</p>
            @if ($undangan->nama_ayah_pria || $undangan->nama_ibu_pria)
                <p class="text-xs text-[#E6EEF8]/80 leading-relaxed">
                    Putra dari {{ $undangan->nama_ayah_pria }} &amp; {{ $undangan->nama_ibu_pria }}
                </p>
            @endif
            @if ($instagramPria !== '')
                <div class="pt-1">
                    <a href="https://instagram.com/{{ $instagramPria }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 rounded-full border border-[#D9B664]/55 bg-[#091322]/75 px-3.5 py-1 text-[11px] font-semibold text-[#F3E5AB] hover:bg-[#D9B664] hover:text-[#091322] transition">
                        <span>&#64;{{ $instagramPria }}</span>
                    </a>
                </div>
            @endif
        </article>

        {{-- PEMISAH BINTANG RUB EL HIZB BERPUTAR --}}
        <div class="flex items-center justify-center gap-4">
            <span class="h-px w-16 bg-gradient-to-r from-transparent to-[#D9B664]/70"></span>
            <div class="relative w-12 h-12 flex items-center justify-center">
                <span aria-hidden="true" class="absolute inset-1 border border-[#D9B664]/75 animasi-orbit"></span>
                <span aria-hidden="true" class="absolute inset-1 border border-[#F3E5AB]/75 rotate-45 animasi-orbit-balik"></span>
                <span class="font-kaligrafi text-2xl text-[#F3E5AB]">&amp;</span>
            </div>
            <span class="h-px w-16 bg-gradient-to-l from-transparent to-[#D9B664]/70"></span>
        </div>

        {{-- MIHRAB MEMPELAI WANITA --}}
        <article class="fx-slide-right rounded-t-[9rem] rounded-b-3xl bg-[#132438]/95 border border-[#D9B664]/55 px-6 pt-10 pb-8 text-center shadow-2xl kartu-3d efek-shimmer-kartu space-y-3">
            @if (! $tanpaFoto && $undangan->urlFotoWanita())
                <div class="relative mx-auto w-44 h-52 p-1.5 rounded-t-full rounded-b-2xl border-2 border-[#D9B664]/75 bg-[#091322]">
                    <img
                        src="{{ $undangan->urlFotoWanita() }}"
                        alt="{{ $undangan->nama_lengkap_wanita }}"
                        class="w-full h-full rounded-t-full rounded-b-xl object-cover object-top"
                    >
                </div>
            @else
                <div class="relative mx-auto w-24 h-24 flex items-center justify-center">
                    <span class="absolute inset-0 rounded-full border border-dashed border-[#D9B664]/65 animasi-orbit"></span>
                    <span class="font-serif text-3xl font-bold text-[#F3E5AB]">{{ $undangan->inisialWanita() }}</span>
                </div>
            @endif

            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#D9B664]">Mempelai Wanita</p>
            <h3 class="font-kaligrafi text-5xl text-[#F3E5AB] leading-tight">{{ $undangan->nama_panggilan_wanita }}</h3>
            <p class="font-serif text-base font-bold text-white">{{ $undangan->nama_lengkap_wanita }}</p>
            @if ($undangan->nama_ayah_wanita || $undangan->nama_ibu_wanita)
                <p class="text-xs text-[#E6EEF8]/80 leading-relaxed">
                    Putri dari {{ $undangan->nama_ayah_wanita }} &amp; {{ $undangan->nama_ibu_wanita }}
                </p>
            @endif
            @if ($instagramWanita !== '')
                <div class="pt-1">
                    <a href="https://instagram.com/{{ $instagramWanita }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 rounded-full border border-[#D9B664]/55 bg-[#091322]/75 px-3.5 py-1 text-[11px] font-semibold text-[#F3E5AB] hover:bg-[#D9B664] hover:text-[#091322] transition">
                        <span>&#64;{{ $instagramWanita }}</span>
                    </a>
                </div>
            @endif
        </article>
    </div>
</section>

{{-- SEKSI 5: JADWAL AKAD & WALIMAH --}}
@if ($undangan->daftarAcara->isNotEmpty())
<section
    data-layout-acara="celestial"
    class="relative bg-[#0E1B2A] px-4 py-12 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-6">
        <div class="fx-rise text-center space-y-1">
            <p class="text-[10px] font-semibold uppercase tracking-[0.34em] text-[#D9B664]">InsyaAllah Dilaksanakan Pada</p>
            <h2 class="font-serif text-3xl font-bold text-white">Jadwal Akad &amp; Walimah</h2>
        </div>

        @foreach ($undangan->daftarAcara as $acara)
            <article class="fx-scale-in rounded-t-[4.5rem] rounded-b-3xl bg-[#132438] border border-[#D9B664]/55 p-6 text-center shadow-2xl kartu-3d efek-shimmer-kartu space-y-3.5">
                <div class="inline-flex items-center gap-2 rounded-full bg-[#D9B664]/15 border border-[#D9B664]/45 px-4 py-1 text-[10px] font-bold uppercase tracking-[0.26em] text-[#F3E5AB]">
                    <span>&#10022;</span>
                    <span>{{ $acara->tanggal_acara->locale('id')->translatedFormat('l') }}</span>
                </div>

                <h3 class="font-serif text-2xl font-bold text-[#F3E5AB]">{{ $acara->nama_acara }}</h3>

                <div class="border-y border-[#D9B664]/25 py-3 space-y-1">
                    <p class="font-serif text-lg font-bold text-white">
                        {{ $acara->tanggal_acara->locale('id')->translatedFormat('d F Y') }}
                    </p>
                    <p class="text-xs font-semibold text-[#D9B664]">
                        Pukul {{ \Illuminate\Support\Str::substr($acara->waktu_mulai, 0, 5) }}
                        @if ($acara->waktu_selesai)
                            - {{ \Illuminate\Support\Str::substr($acara->waktu_selesai, 0, 5) }}
                        @else
                            - Selesai
                        @endif
                        {{ $acara->zona_waktu }}
                    </p>
                </div>

                <div class="space-y-1">
                    <p class="font-serif text-base font-bold text-white">{{ $acara->nama_tempat }}</p>
                    <p class="text-xs text-[#E6EEF8]/75 leading-relaxed max-w-xs mx-auto">{{ $acara->alamat_lengkap }}</p>
                </div>

                @if ($acara->link_maps)
                    <div class="pt-1">
                        <a
                            href="{{ $acara->link_maps }}"
                            target="_blank"
                            rel="noopener"
                            class="celestial-tombol-emas inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-xs font-bold uppercase tracking-wider transition"
                        >
                            <span>Petunjuk Arah Maps</span>
                        </a>
                    </div>
                @endif
            </article>
        @endforeach
    </div>
</section>
@endif

{{-- SEKSI 6: DRESS CODE & LIVE STREAMING --}}
@if ($adaDressCode || (! empty($live['aktif']) && ! empty($live['link'])))
<section class="relative px-4 py-8 space-y-5 overflow-hidden">
    @if ($adaDressCode)
        <div data-section-dress-code="celestial" class="fx-rise max-w-md mx-auto rounded-3xl bg-[#132438] border border-[#D9B664]/45 p-6 text-center space-y-3">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#D9B664]">Adab &amp; Nuansa Busana</p>
            @if ($dressCodeCatatan !== '')
                <p class="text-xs sm:text-sm text-[#E6EEF8]/85 leading-relaxed">{{ $dressCodeCatatan }}</p>
            @endif
            @if (! empty($dressCodeWarna))
                <div class="flex flex-wrap items-center justify-center gap-3 pt-1">
                    @foreach ($dressCodeWarna as $hex)
                        <div class="flex flex-col items-center gap-1">
                            <span class="h-9 w-9 rounded-full border-2 border-[#F3E5AB]/80 shadow-md" style="background-color: {{ $hex }};"></span>
                            <span class="text-[9px] font-mono text-[#F3E5AB]/80">{{ $hex }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    @if (! empty($live['aktif']) && ! empty($live['link']))
        <div class="fx-rise max-w-md mx-auto rounded-3xl bg-[#132438] border border-[#D9B664]/50 p-6 text-center space-y-3 efek-shimmer-kartu">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#D9B664]">Siaran Walimah</p>
            <h3 class="font-serif text-2xl font-bold text-[#F3E5AB]">Live Streaming</h3>
            <p class="text-xs text-[#E6EEF8]/80 leading-relaxed">
                Saksikan prosesi ijab qabul secara virtual melalui {{ $live['platform'] ?? 'YouTube Live' }}.
            </p>
            <a
                href="{{ $live['link'] }}"
                target="_blank"
                rel="noopener"
                class="celestial-tombol-emas inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-xs font-bold uppercase tracking-wider transition"
            >
                <span>Saksikan Siaran Langsung</span>
            </a>
        </div>
    @endif
</section>
@endif

{{-- SEKSI 7: KONSTELASI BINTANG — PERJALANAN TA'ARUF & CERITA CINTA --}}
@if ($undangan->fiturAktif('cerita_cinta') && ! empty($ceritaList))
<section
    data-layout-cerita="celestial"
    class="relative px-4 py-12 overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-7 overflow-hidden py-1">
        <p class="scroll-scrub-kiri text-[10px] font-bold uppercase tracking-[0.34em] text-[#D9B664]">Perjalanan Ta&rsquo;aruf</p>
        <h2 class="scroll-scrub-kanan mt-1 font-serif text-3xl font-bold text-white">Kisah Pertemuan</h2>
    </div>

    <div class="max-w-md mx-auto relative pl-7 space-y-5 border-l-2 border-[#D9B664]/45 ml-3">
        @foreach ($ceritaList as $cerita)
            @php
                $urlFotoBab = (! $tanpaFoto && ! empty($cerita['foto']))
                    ? \App\Support\MediaPublik::url((string) $cerita['foto'])
                    : null;
            @endphp
            <article class="fx-slide-right relative">
                <span aria-hidden="true" class="absolute -left-[37px] top-4 w-5 h-5 rounded-full bg-[#D9B664] text-[#091322] text-[11px] flex items-center justify-center shadow-[0_0_12px_rgba(217,182,100,0.85)]">&#10022;</span>
                <div class="rounded-2xl bg-[#132438] border border-[#D9B664]/45 p-5 shadow-xl kartu-3d efek-shimmer-kartu">
                    @if ($urlFotoBab)
                        <div class="mb-3 overflow-hidden rounded-xl border border-[#D9B664]/40">
                            <img src="{{ $urlFotoBab }}" alt="{{ $cerita['judul'] ?? 'Kisah Pertemuan' }}" class="w-full aspect-[16/10] object-cover object-center">
                        </div>
                    @endif
                    <div class="flex items-center justify-between gap-2">
                        <h3 class="font-serif text-lg font-bold text-[#F3E5AB]">{{ $cerita['judul'] ?? '' }}</h3>
                        @if (! empty($cerita['tanggal']))
                            <span class="rounded-full bg-[#D9B664]/20 border border-[#D9B664]/40 px-2.5 py-0.5 text-[10px] font-semibold text-[#F3E5AB]">{{ $cerita['tanggal'] }}</span>
                        @endif
                    </div>
                    <p class="mt-2 text-xs sm:text-sm text-[#E6EEF8]/85 leading-relaxed">{{ $cerita['cerita'] ?? '' }}</p>
                </div>
            </article>
        @endforeach
    </div>
</section>
@endif

{{-- SEKSI 8: GALERI LENGKUNG CELESTIAL --}}
@if (! $tanpaFoto && $undangan->fiturAktif('galeri') && $undangan->daftarGaleri->isNotEmpty())
<section
    data-layout-galeri="celestial"
    class="relative bg-[#0E1B2A] px-4 py-12 overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-7 overflow-hidden">
        <p class="scroll-scrub-kanan text-[10px] font-bold uppercase tracking-[0.34em] text-[#D9B664]">Galeri Kenangan</p>
        <h2 class="scroll-scrub-kiri mt-1 font-serif text-3xl font-bold text-white">Momen Terindah</h2>
    </div>

    <div class="max-w-md mx-auto grid grid-cols-2 gap-3">
        @foreach ($undangan->daftarGaleri as $galeri)
            <button
                type="button"
                @click="bukaGaleri(@js($galeri->urlFoto()), @js($galeri->keterangan))"
                class="fx-scale-in group relative overflow-hidden border border-[#D9B664]/55 bg-[#091322] cursor-pointer kartu-3d {{ $loop->first ? 'col-span-2 aspect-[16/10] rounded-3xl' : 'aspect-[4/5] rounded-t-[3.5rem] rounded-b-2xl' }}"
            >
                <img
                    src="{{ $galeri->urlFoto() }}"
                    alt="{{ $galeri->keterangan ?? 'Galeri' }}"
                    class="w-full h-full object-cover object-center group-hover:scale-105 transition duration-700"
                >
                @if ($galeri->keterangan)
                    <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#091322]/90 to-transparent px-3 py-2 text-left text-[11px] font-medium text-[#F3E5AB]">
                        {{ $galeri->keterangan }}
                    </span>
                @endif
            </button>
        @endforeach
    </div>
</section>
@endif
