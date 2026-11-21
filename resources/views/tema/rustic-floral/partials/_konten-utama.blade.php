{{-- SEKSI 3: KARTU SCRAPBOOK BOTANI MEMPELAI (MIRING ORGANIK + STEMPEL TERAKOTA) --}}
<section
    data-aos="fade-up"
    data-layout-mempelai="klasik"
    class="relative px-4 py-12 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-6">
        <div class="fx-rise text-center space-y-1.5">
            <img src="{{ $asetRustic['sudut'] }}" alt="" class="w-11 mx-auto animasi-melayang">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#B86B4B]">The Couple</p>
            <h2 class="font-serif text-3xl font-bold text-[#1F2937]">Mempelai Berbahagia</h2>
        </div>

        {{-- MEMPELAI PRIA --}}
        <article class="fx-slide-left relative rounded-3xl bg-white border border-[#BFA15F]/45 p-6 text-center shadow-lg -rotate-[0.6deg] kartu-3d space-y-3">
            <span aria-hidden="true" class="pointer-events-none absolute -top-2.5 left-1/2 -translate-x-1/2 w-20 h-5 bg-[#E5D5C0]/85 border border-[#BFA15F]/35 rotate-1"></span>
            @if (! $tanpaFoto && $undangan->urlFotoPria())
                <div class="mx-auto w-36 h-36 p-1.5 rounded-full border-2 border-dashed border-[#4B6358]/55 bg-[#FDFBF7]">
                    <img src="{{ $undangan->urlFotoPria() }}" alt="{{ $undangan->nama_lengkap_pria }}" class="w-full h-full rounded-full object-cover object-top">
                </div>
            @else
                <div class="mx-auto w-20 h-20 rounded-full bg-[#4B6358] text-[#FDFBF7] flex items-center justify-center font-serif text-2xl font-bold">
                    {{ $undangan->inisialPria() }}
                </div>
            @endif
            <span class="inline-block rounded-full bg-[#B86B4B]/12 border border-[#B86B4B]/30 px-3 py-0.5 text-[10px] font-bold uppercase tracking-widest text-[#B86B4B]">The Groom</span>
            <h3 class="font-kaligrafi text-5xl text-[#4B6358] leading-tight">{{ $undangan->nama_panggilan_pria }}</h3>
            <p class="font-serif text-base font-bold text-[#1F2937]">{{ $undangan->nama_lengkap_pria }}</p>
            @if ($undangan->nama_ayah_pria || $undangan->nama_ibu_pria)
                <p class="text-xs text-[#1F2937]/75 leading-relaxed">Putra dari {{ $undangan->nama_ayah_pria }} &amp; {{ $undangan->nama_ibu_pria }}</p>
            @endif
            @if ($instagramPria !== '')
                <div class="pt-1">
                    <a href="https://instagram.com/{{ $instagramPria }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 rounded-full bg-[#4B6358]/10 px-3.5 py-1 text-[11px] font-semibold text-[#4B6358] hover:bg-[#4B6358] hover:text-white transition">&#64;{{ $instagramPria }}</a>
                </div>
            @endif
        </article>

        <div class="flex items-center justify-center gap-4 text-[#B86B4B]">
            <span class="h-px w-14 bg-[#BFA15F]/50"></span>
            <span class="font-kaligrafi text-4xl text-[#4B6358]">&amp;</span>
            <span class="h-px w-14 bg-[#BFA15F]/50"></span>
        </div>

        {{-- MEMPELAI WANITA --}}
        <article class="fx-slide-right relative rounded-3xl bg-white border border-[#BFA15F]/45 p-6 text-center shadow-lg rotate-[0.6deg] kartu-3d space-y-3">
            <span aria-hidden="true" class="pointer-events-none absolute -top-2.5 left-1/2 -translate-x-1/2 w-20 h-5 bg-[#E5D5C0]/85 border border-[#BFA15F]/35 -rotate-1"></span>
            @if (! $tanpaFoto && $undangan->urlFotoWanita())
                <div class="mx-auto w-36 h-36 p-1.5 rounded-full border-2 border-dashed border-[#B86B4B]/55 bg-[#FDFBF7]">
                    <img src="{{ $undangan->urlFotoWanita() }}" alt="{{ $undangan->nama_lengkap_wanita }}" class="w-full h-full rounded-full object-cover object-top">
                </div>
            @else
                <div class="mx-auto w-20 h-20 rounded-full bg-[#B86B4B] text-[#FDFBF7] flex items-center justify-center font-serif text-2xl font-bold">
                    {{ $undangan->inisialWanita() }}
                </div>
            @endif
            <span class="inline-block rounded-full bg-[#4B6358]/12 border border-[#4B6358]/30 px-3 py-0.5 text-[10px] font-bold uppercase tracking-widest text-[#4B6358]">The Bride</span>
            <h3 class="font-kaligrafi text-5xl text-[#4B6358] leading-tight">{{ $undangan->nama_panggilan_wanita }}</h3>
            <p class="font-serif text-base font-bold text-[#1F2937]">{{ $undangan->nama_lengkap_wanita }}</p>
            @if ($undangan->nama_ayah_wanita || $undangan->nama_ibu_wanita)
                <p class="text-xs text-[#1F2937]/75 leading-relaxed">Putri dari {{ $undangan->nama_ayah_wanita }} &amp; {{ $undangan->nama_ibu_wanita }}</p>
            @endif
            @if ($instagramWanita !== '')
                <div class="pt-1">
                    <a href="https://instagram.com/{{ $instagramWanita }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 rounded-full bg-[#4B6358]/10 px-3.5 py-1 text-[11px] font-semibold text-[#4B6358] hover:bg-[#4B6358] hover:text-white transition">&#64;{{ $instagramWanita }}</a>
                </div>
            @endif
        </article>
    </div>
</section>

{{-- SEKSI 4: HITUNG MUNDUR STEMPEL SAGE --}}
@if ($undangan->fiturAktif('hitung_mundur') && $isoTarget)
<section
    data-layout-countdown="klasik"
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
    class="relative bg-gradient-to-b from-[#4B6358] to-[#394D44] text-white px-5 py-11 text-center overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-5">
        <p class="text-[10px] font-semibold uppercase tracking-[0.34em] text-[#E5D5C0]">Countdown</p>
        <h2 class="fx-rise font-serif text-3xl font-bold text-white">Save The Date</h2>

        <div class="grid grid-cols-4 gap-2.5 pt-1">
            @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                <div class="rounded-2xl bg-[#FDFBF7] text-[#1F2937] py-3.5 px-1 shadow-sm">
                    <div class="font-serif text-2xl sm:text-3xl font-bold leading-none text-[#4B6358]" x-text="{{ $var }}">00</div>
                    <div class="mt-1.5 text-[9px] uppercase tracking-wider font-bold text-[#B86B4B]">{{ $label }}</div>
                </div>
            @endforeach
        </div>

        @if ($googleCalUrl)
            <div class="pt-1">
                <a href="{{ $googleCalUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full bg-white px-6 py-2.5 text-xs font-bold uppercase tracking-wider text-[#2F4037] shadow-sm hover:bg-[#FDFBF7] transition">
                    <span>Simpan ke Kalender</span>
                </a>
            </div>
        @endif
    </div>
</section>
@endif

{{-- SEKSI 5: KARTU POS BOTANI RANGKAIAN ACARA --}}
@if ($undangan->daftarAcara->isNotEmpty())
<section
    data-layout-acara="klasik"
    class="relative px-4 py-12 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-6">
        <div class="fx-rise text-center space-y-1">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#B86B4B]">Save The Date</p>
            <h2 class="font-serif text-3xl font-bold text-[#1F2937]">Rangkaian Acara</h2>
        </div>

        @foreach ($undangan->daftarAcara as $acara)
            <article class="fx-scale-in relative rounded-3xl bg-white border border-[#BFA15F]/45 p-6 text-left shadow-lg kartu-3d space-y-4">
                {{-- Prangko Tanggal Sudut Kanan Atas --}}
                <div class="flex items-start justify-between gap-3 border-b border-dashed border-[#BFA15F]/50 pb-4">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.26em] text-[#B86B4B]">{{ $acara->tanggal_acara->locale('id')->translatedFormat('l') }}</p>
                        <h3 class="mt-0.5 font-serif text-2xl font-bold text-[#1F2937]">{{ $acara->nama_acara }}</h3>
                    </div>
                    <div class="shrink-0 rounded-xl border-2 border-dashed border-[#4B6358]/50 bg-[#F4ECE1] px-3 py-2 text-center">
                        <span class="block font-serif text-2xl font-bold leading-none text-[#4B6358]">{{ $acara->tanggal_acara->format('d') }}</span>
                        <span class="block text-[9px] font-bold uppercase text-[#B86B4B]">{{ $acara->tanggal_acara->locale('id')->translatedFormat('M Y') }}</span>
                    </div>
                </div>

                <div class="space-y-1.5 text-xs">
                    <p class="font-bold text-[#4B6358]">
                        Pukul {{ \Illuminate\Support\Str::substr($acara->waktu_mulai, 0, 5) }}
                        @if ($acara->waktu_selesai) - {{ \Illuminate\Support\Str::substr($acara->waktu_selesai, 0, 5) }} @else - Selesai @endif
                        {{ $acara->zona_waktu }}
                    </p>
                    <p class="font-serif text-base font-bold text-[#1F2937]">{{ $acara->nama_tempat }}</p>
                    <p class="text-[#1F2937]/75 leading-relaxed">{{ $acara->alamat_lengkap }}</p>
                </div>

                @if ($acara->link_maps)
                    <a href="{{ $acara->link_maps }}" target="_blank" rel="noopener" class="rustic-tombol-sage inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-xs font-bold uppercase tracking-wider transition">
                        <span>Buka Google Maps</span>
                    </a>
                @endif
            </article>
        @endforeach
    </div>
</section>
@endif

{{-- SEKSI 6: DRESS CODE & LIVE STREAMING --}}
@if ($adaDressCode || (! empty($live['aktif']) && ! empty($live['link'])))
<section class="relative bg-[#F4ECE1] px-4 py-8 space-y-4 overflow-hidden">
    @if ($adaDressCode)
        <div data-section-dress-code="klasik" class="fx-rise max-w-md mx-auto rounded-3xl bg-white border border-[#BFA15F]/40 p-5 text-center space-y-3">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#B86B4B]">Dress Code</p>
            @if ($dressCodeCatatan !== '')
                <p class="text-xs text-[#1F2937]/80 leading-relaxed">{{ $dressCodeCatatan }}</p>
            @endif
            @if (! empty($dressCodeWarna))
                <div class="flex flex-wrap items-center justify-center gap-3">
                    @foreach ($dressCodeWarna as $hex)
                        <div class="flex flex-col items-center gap-1">
                            <span class="h-8 w-8 rounded-full border-2 border-[#BFA15F]/60" style="background-color: {{ $hex }};"></span>
                            <span class="text-[9px] font-mono text-[#1F2937]/70">{{ $hex }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    @if (! empty($live['aktif']) && ! empty($live['link']))
        <div class="fx-rise max-w-md mx-auto rounded-3xl bg-white border border-[#BFA15F]/40 p-5 text-center space-y-3">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#B86B4B]">Siaran Langsung</p>
            <h3 class="font-serif text-xl font-bold text-[#1F2937]">Live Streaming</h3>
            <p class="text-xs text-[#1F2937]/75 leading-relaxed">
                Ikuti prosesi kebahagiaan kami secara virtual melalui {{ $live['platform'] ?? 'YouTube Live' }}.
            </p>
            <a href="{{ $live['link'] }}" target="_blank" rel="noopener" class="rustic-tombol-sage inline-flex items-center gap-2 rounded-full px-6 py-2 text-xs font-bold uppercase tracking-wider transition">
                <span>Tonton Live Streaming</span>
            </a>
        </div>
    @endif
</section>
@endif

{{-- SEKSI 7: SCRAPBOOK MEMORIES CERITA CINTA --}}
@if ($undangan->fiturAktif('cerita_cinta') && ! empty($ceritaList))
<section
    data-layout-cerita="klasik"
    class="relative px-4 py-12 overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-7 overflow-hidden">
        <p class="scroll-scrub-kiri text-[10px] font-bold uppercase tracking-[0.34em] text-[#B86B4B]">Kisah Kami</p>
        <h2 class="scroll-scrub-kanan mt-1 font-serif text-3xl font-bold text-[#1F2937]">Cerita Cinta</h2>
    </div>

    <div class="max-w-md mx-auto space-y-5">
        @foreach ($ceritaList as $cerita)
            @php
                $urlFotoBab = (! $tanpaFoto && ! empty($cerita['foto']))
                    ? \App\Support\MediaPublik::url((string) $cerita['foto'])
                    : null;
            @endphp
            <article class="fx-rise relative rounded-2xl bg-white border border-[#BFA15F]/40 p-5 shadow-md kartu-3d">
                <span aria-hidden="true" class="pointer-events-none absolute -top-2 left-6 w-14 h-4 bg-[#E5D5C0]/85"></span>
                @if ($urlFotoBab)
                    <div class="mb-3 overflow-hidden rounded-xl border border-[#BFA15F]/35">
                        <img src="{{ $urlFotoBab }}" alt="{{ $cerita['judul'] ?? 'Cerita Cinta' }}" class="w-full aspect-[16/10] object-cover object-center">
                    </div>
                @endif
                <div class="flex items-center justify-between gap-2">
                    <h3 class="font-serif text-lg font-bold text-[#1F2937]">{{ $cerita['judul'] ?? '' }}</h3>
                    @if (! empty($cerita['tanggal']))
                        <span class="rounded-full bg-[#B86B4B]/12 px-2.5 py-0.5 text-[10px] font-semibold text-[#B86B4B]">{{ $cerita['tanggal'] }}</span>
                    @endif
                </div>
                <p class="mt-2 text-xs sm:text-sm text-[#1F2937]/80 leading-relaxed">{{ $cerita['cerita'] ?? '' }}</p>
            </article>
        @endforeach
    </div>
</section>
@endif

{{-- SEKSI 8: GALERI KOLASE LINEN --}}
@if (! $tanpaFoto && $undangan->fiturAktif('galeri') && $undangan->daftarGaleri->isNotEmpty())
<section
    data-layout-galeri="klasik"
    class="relative bg-[#F4ECE1] px-4 py-12 overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-7 overflow-hidden">
        <p class="scroll-scrub-kanan text-[10px] font-bold uppercase tracking-[0.34em] text-[#B86B4B]">Galeri Momen</p>
        <h2 class="scroll-scrub-kiri mt-1 font-serif text-3xl font-bold text-[#1F2937]">Potret Kebahagiaan</h2>
    </div>

    <div class="max-w-md mx-auto grid grid-cols-2 gap-3.5">
        @foreach ($undangan->daftarGaleri as $galeri)
            <button
                type="button"
                @click="bukaGaleri(@js($galeri->urlFoto()), @js($galeri->keterangan))"
                class="fx-scale-in group relative aspect-square overflow-hidden rounded-2xl bg-white p-1.5 border border-[#BFA15F]/40 shadow-md cursor-pointer kartu-3d"
            >
                <img src="{{ $galeri->urlFoto() }}" alt="{{ $galeri->keterangan ?? 'Galeri' }}" class="w-full h-full object-cover object-center rounded-xl group-hover:scale-105 transition duration-700">
            </button>
        @endforeach
    </div>
</section>
@endif
