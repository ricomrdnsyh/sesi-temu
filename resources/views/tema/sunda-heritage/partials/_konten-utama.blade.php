{{-- SEKSI 3: PASANGAN PANGANTEN (TATA LETAK HORIZONTAL BERSEBERANGAN — BEDA TOTAL DARI ADAT JAWA) --}}
<section
    data-layout-mempelai="priangan"
    class="relative px-4 py-12 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-6">
        <div class="fx-rise text-center space-y-1.5">
            <img src="{{ $asetSunda['siger'] }}" alt="" class="w-12 mx-auto">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#8E6620]">Pasangan Panganten</p>
            <h2 class="font-serif text-3xl font-bold text-[#5A1E1E]">Mempelai Berbahagia</h2>
            <p class="text-xs text-[#4A2020]/75 max-w-xs mx-auto leading-relaxed">
                Kalayan nyuhunkeun rido sareng rahmat Gusti Nu Maha Suci, sim kuring nyanggakeun pangulem nikah:
            </p>
        </div>

        {{-- KARTU MEMPELAI PRIA: FOTO KIRI, BIO KANAN --}}
        <article class="fx-slide-left rounded-3xl bg-[#FFFBF4] border-2 border-[#C59B43]/65 p-5 shadow-xl kartu-3d">
            <div class="flex {{ $tanpaFoto ? 'flex-col items-center text-center' : 'flex-col sm:flex-row items-center gap-4 text-center sm:text-left' }}">
                @if (! $tanpaFoto && $undangan->urlFotoPria())
                    <div class="relative shrink-0 w-32 h-32 p-1.5 rounded-full border-2 border-[#C59B43] bg-[#5A1E1E]/5">
                        <img
                            src="{{ $undangan->urlFotoPria() }}"
                            alt="{{ $undangan->nama_lengkap_pria }}"
                            class="w-full h-full rounded-full object-cover object-top"
                        >
                        <span aria-hidden="true" class="pointer-events-none absolute -inset-1 rounded-full border border-dashed border-[#C59B43]/65"></span>
                    </div>
                @elseif ($tanpaFoto)
                    <div class="w-16 h-16 rounded-full bg-[#5A1E1E] text-[#F3E5AB] border-2 border-[#C59B43] flex items-center justify-center font-serif text-2xl font-bold">
                        {{ $undangan->inisialPria() }}
                    </div>
                @endif

                <div class="flex-1 space-y-1.5">
                    <span class="inline-block rounded-full bg-[#5A1E1E] px-3 py-0.5 text-[10px] font-bold uppercase tracking-widest text-[#F3E5AB]">
                        Panganten Pameget
                    </span>
                    <h3 class="font-kaligrafi text-4xl leading-tight text-[#5A1E1E]">
                        {{ $undangan->nama_panggilan_pria }}
                    </h3>
                    <p class="font-serif text-sm font-bold text-[#4A2020]">
                        {{ $undangan->nama_lengkap_pria }}
                    </p>
                    @if ($undangan->nama_ayah_pria || $undangan->nama_ibu_pria)
                        <p class="text-xs text-[#4A2020]/75 leading-relaxed">
                            Putra ti {{ $undangan->nama_ayah_pria }} &amp; {{ $undangan->nama_ibu_pria }}
                        </p>
                    @endif
                    @if ($instagramPria !== '')
                        <a
                            href="https://instagram.com/{{ $instagramPria }}"
                            target="_blank"
                            rel="noopener"
                            class="mt-1 inline-flex items-center gap-1.5 rounded-full bg-[#5A1E1E]/10 border border-[#C59B43]/50 px-3 py-1 text-[11px] font-semibold text-[#5A1E1E] hover:bg-[#5A1E1E] hover:text-[#FAF4E8] transition"
                        >
                            <span>&#64;{{ $instagramPria }}</span>
                        </a>
                    @endif
                </div>
            </div>
        </article>

        {{-- PEMISAH EMAS --}}
        <div class="flex items-center justify-center gap-4 text-[#B58931]">
            <span class="h-px w-16 bg-gradient-to-r from-transparent to-[#C59B43]"></span>
            <span class="font-kaligrafi text-4xl text-[#5A1E1E]">&amp;</span>
            <span class="h-px w-16 bg-gradient-to-l from-transparent to-[#C59B43]"></span>
        </div>

        {{-- KARTU MEMPELAI WANITA: BIO KIRI, FOTO KANAN (BERGANTIAN) --}}
        <article class="fx-slide-right rounded-3xl bg-[#FFFBF4] border-2 border-[#C59B43]/65 p-5 shadow-xl kartu-3d">
            <div class="flex {{ $tanpaFoto ? 'flex-col items-center text-center' : 'flex-col-reverse sm:flex-row items-center gap-4 text-center sm:text-right' }}">
                <div class="flex-1 space-y-1.5">
                    <span class="inline-block rounded-full bg-[#C59B43]/20 border border-[#C59B43]/55 px-3 py-0.5 text-[10px] font-bold uppercase tracking-widest text-[#5A1E1E]">
                        Panganten Istri
                    </span>
                    <h3 class="font-kaligrafi text-4xl leading-tight text-[#5A1E1E]">
                        {{ $undangan->nama_panggilan_wanita }}
                    </h3>
                    <p class="font-serif text-sm font-bold text-[#4A2020]">
                        {{ $undangan->nama_lengkap_wanita }}
                    </p>
                    @if ($undangan->nama_ayah_wanita || $undangan->nama_ibu_wanita)
                        <p class="text-xs text-[#4A2020]/75 leading-relaxed">
                            Putri ti {{ $undangan->nama_ayah_wanita }} &amp; {{ $undangan->nama_ibu_wanita }}
                        </p>
                    @endif
                    @if ($instagramWanita !== '')
                        <a
                            href="https://instagram.com/{{ $instagramWanita }}"
                            target="_blank"
                            rel="noopener"
                            class="mt-1 inline-flex items-center gap-1.5 rounded-full bg-[#5A1E1E]/10 border border-[#C59B43]/50 px-3 py-1 text-[11px] font-semibold text-[#5A1E1E] hover:bg-[#5A1E1E] hover:text-[#FAF4E8] transition"
                        >
                            <span>&#64;{{ $instagramWanita }}</span>
                        </a>
                    @endif
                </div>

                @if (! $tanpaFoto && $undangan->urlFotoWanita())
                    <div class="relative shrink-0 w-32 h-32 p-1.5 rounded-full border-2 border-[#C59B43] bg-[#5A1E1E]/5">
                        <img
                            src="{{ $undangan->urlFotoWanita() }}"
                            alt="{{ $undangan->nama_lengkap_wanita }}"
                            class="w-full h-full rounded-full object-cover object-top"
                        >
                        <span aria-hidden="true" class="pointer-events-none absolute -inset-1 rounded-full border border-dashed border-[#C59B43]/65"></span>
                    </div>
                @elseif ($tanpaFoto)
                    <div class="w-16 h-16 rounded-full bg-[#5A1E1E] text-[#F3E5AB] border-2 border-[#C59B43] flex items-center justify-center font-serif text-2xl font-bold">
                        {{ $undangan->inisialWanita() }}
                    </div>
                @endif
            </div>
        </article>
    </div>
</section>

{{-- SEKSI 4: HITUNG MUNDUR — 4 MEDALI EMAS BULAT DI ATAS PITA MARUN --}}
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
    class="relative bg-gradient-to-b from-[#6E2C2C] to-[#4B1818] text-[#FAF4E8] px-5 py-12 text-center overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-5">
        <p class="text-[10px] font-bold uppercase tracking-[0.35em] text-[#E7C87D]">Waktos Nu Diantos-antos</p>
        <h2 class="fx-rise font-serif text-3xl font-bold text-white">Save The Date</h2>

        {{-- 4 Medali Lingkaran Emas --}}
        <div class="grid grid-cols-4 gap-2.5 pt-2">
            @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                <div class="aspect-square rounded-full bg-[#FFFBF4] text-[#5A1E1E] border-2 border-[#C59B43] shadow-lg flex flex-col items-center justify-center p-1">
                    <span class="font-serif text-2xl sm:text-[1.75rem] font-bold leading-none" x-text="{{ $var }}">00</span>
                    <span class="mt-1 text-[9px] uppercase tracking-wider font-bold text-[#8E6620]">{{ $label }}</span>
                </div>
            @endforeach
        </div>

        @if ($googleCalUrl)
            <div class="pt-2">
                <a
                    href="{{ $googleCalUrl }}"
                    target="_blank"
                    rel="noopener"
                    class="sunda-tombol-emas inline-flex items-center gap-2 rounded-full px-7 py-2.5 text-xs font-bold uppercase tracking-wider transition"
                >
                    <span>Simpan ke Kalender</span>
                </a>
            </div>
        @endif
    </div>
</section>
@endif

{{-- SEKSI 5: RANGKAIAN ACARA — PIAGAM PITA MARUN PRIANGAN --}}
@if ($undangan->daftarAcara->isNotEmpty())
<section
    data-layout-acara="priangan"
    class="relative px-4 py-12 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-6">
        <div class="fx-rise text-center space-y-1">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#8E6620]">Waktos &amp; Tempat</p>
            <h2 class="font-serif text-3xl font-bold text-[#5A1E1E]">Rangkaian Acara</h2>
        </div>

        @foreach ($undangan->daftarAcara as $acara)
            <article class="fx-scale-in rounded-3xl bg-[#FFFBF4] border-2 border-[#C59B43]/65 overflow-hidden shadow-xl kartu-3d">
                {{-- Header Pita Marun-Emas --}}
                <div class="bg-[#5A1E1E] text-[#FAF4E8] px-5 py-4 text-center border-b-2 border-[#C59B43]">
                    <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#E7C87D]">
                        {{ $acara->tanggal_acara->locale('id')->translatedFormat('l') }}
                    </p>
                    <h3 class="mt-0.5 font-serif text-2xl font-bold text-white">
                        {{ $acara->nama_acara }}
                    </h3>
                </div>

                {{-- Isi Piagam --}}
                <div class="px-5 py-6 text-center space-y-3 text-[#4A2020]">
                    <div class="inline-flex items-center gap-3 rounded-2xl bg-[#FAF4E8] border border-[#C59B43]/50 px-4 py-2">
                        <span class="font-serif text-3xl font-bold text-[#5A1E1E]">{{ $acara->tanggal_acara->format('d') }}</span>
                        <div class="text-left leading-tight">
                            <p class="text-xs font-bold uppercase text-[#5A1E1E]">{{ $acara->tanggal_acara->locale('id')->translatedFormat('F Y') }}</p>
                            <p class="text-[11px] font-semibold text-[#8E6620]">
                                {{ \Illuminate\Support\Str::substr($acara->waktu_mulai, 0, 5) }}
                                @if ($acara->waktu_selesai)
                                    - {{ \Illuminate\Support\Str::substr($acara->waktu_selesai, 0, 5) }}
                                @else
                                    - Selesai
                                @endif
                                {{ $acara->zona_waktu }}
                            </p>
                        </div>
                    </div>

                    <div class="pt-1 space-y-1">
                        <p class="font-serif text-base font-bold text-[#5A1E1E]">{{ $acara->nama_tempat }}</p>
                        <p class="text-xs text-[#4A2020]/75 leading-relaxed max-w-xs mx-auto">{{ $acara->alamat_lengkap }}</p>
                    </div>

                    @if ($acara->link_maps)
                        <div class="pt-2">
                            <a
                                href="{{ $acara->link_maps }}"
                                target="_blank"
                                rel="noopener"
                                class="sunda-tombol-marun inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-xs font-bold uppercase tracking-wider transition"
                            >
                                <span>Buka Google Maps</span>
                            </a>
                        </div>
                    @endif
                </div>
            </article>
        @endforeach
    </div>
</section>
@endif

{{-- SEKSI 6: DRESS CODE & LIVE STREAMING (OPSIONAL) --}}
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

{{-- SEKSI 7: LALAKON TRESNA / CERITA CINTA (KARTU ZIG-ZAG KIRI-KANAN + FOTO PER-BAB) --}}
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
                        <span class="h-2 w-2 rounded-full bg-[#5A1E1E]"></span>
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

{{-- SEKSI 8: GALERI MOMEN PRIANGAN (FEATURED ARCH + GRID) --}}
@if (! $tanpaFoto && $undangan->fiturAktif('galeri') && $undangan->daftarGaleri->isNotEmpty())
<section
    data-layout-galeri="priangan"
    class="relative bg-[#3B1414] text-[#FAF4E8] px-4 py-12 overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-7 overflow-hidden">
        <p class="scroll-scrub-kanan text-[10px] font-bold uppercase tracking-[0.34em] text-[#E7C87D]">Galeri Momen</p>
        <h2 class="scroll-scrub-kiri mt-1 font-serif text-3xl font-bold text-white">Potret Kebahagiaan</h2>
    </div>

    <div class="max-w-md mx-auto grid grid-cols-2 gap-3">
        @foreach ($undangan->daftarGaleri as $galeri)
            <button
                type="button"
                @click="bukaGaleri(@js($galeri->urlFoto()), @js($galeri->keterangan))"
                class="fx-scale-in group relative overflow-hidden border-2 border-[#C59B43]/65 bg-[#2B0E0E] cursor-pointer kartu-3d {{ $loop->index % 3 === 0 ? 'col-span-2 aspect-[16/10] rounded-t-[3.5rem] rounded-b-2xl' : 'aspect-square rounded-2xl' }}"
            >
                <img
                    src="{{ $galeri->urlFoto() }}"
                    alt="{{ $galeri->keterangan ?? 'Galeri' }}"
                    class="w-full h-full object-cover object-center group-hover:scale-105 transition duration-700"
                >
                @if ($galeri->keterangan)
                    <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/75 to-transparent px-3 py-2 text-left text-[11px] font-medium text-[#FAF4E8]">
                        {{ $galeri->keterangan }}
                    </span>
                @endif
            </button>
        @endforeach
    </div>
</section>
@endif
