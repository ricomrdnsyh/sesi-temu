{{-- SEKSI 3: ASYMMETRIC MAGAZINE COUPLE SPREADS (01 / THE GROOM & 02 / THE BRIDE) --}}
<section
    data-layout-mempelai="editorial"
    class="relative bg-[#FAF9F6] px-5 py-12 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-8">
        <div class="flex items-center justify-between border-b border-[#18181B]/25 pb-3 text-[10px] font-semibold uppercase tracking-[0.34em] text-[#52525B]">
            <span>01 / Profiles</span>
            <span>The Couple</span>
        </div>

        {{-- 01 / THE GROOM --}}
        <article class="fx-slide-left bg-white border border-[#18181B]/25 p-5 kartu-3d space-y-4">
            <div class="flex items-center justify-between border-b border-[#18181B]/15 pb-2 text-[10px] font-bold uppercase tracking-[0.3em] text-[#52525B]">
                <span>01 / The Groom</span>
                <img src="{{ $asetEditorial['bingkai'] }}" alt="" class="w-5 opacity-60">
            </div>

            <div class="grid grid-cols-12 gap-4 items-center">
                @if (! $tanpaFoto && $undangan->urlFotoPria())
                    <div class="col-span-5 border border-[#18181B]/20 p-1 bg-[#FAF9F6]">
                        <img src="{{ $undangan->urlFotoPria() }}" alt="{{ $undangan->nama_lengkap_pria }}" class="w-full aspect-[3/4] object-cover object-top grayscale hover:grayscale-0 transition duration-500">
                    </div>
                @endif
                <div class="{{ (! $tanpaFoto && $undangan->urlFotoPria()) ? 'col-span-7 text-left' : 'col-span-12 text-left' }} space-y-1.5">
                    <h3 class="ed-serif text-3xl uppercase tracking-wide text-[#18181B]">{{ $undangan->nama_panggilan_pria }}</h3>
                    <p class="text-xs font-bold uppercase tracking-wider text-[#18181B]">{{ $undangan->nama_lengkap_pria }}</p>
                    @if ($undangan->nama_ayah_pria || $undangan->nama_ibu_pria)
                        <p class="text-xs text-[#52525B] leading-relaxed">
                            Putra dari {{ $undangan->nama_ayah_pria }} &amp; {{ $undangan->nama_ibu_pria }}
                        </p>
                    @endif
                    @if ($instagramPria !== '')
                        <a href="https://instagram.com/{{ $instagramPria }}" target="_blank" rel="noopener" class="mt-2 inline-block border border-[#18181B] px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-[#18181B] hover:bg-[#18181B] hover:text-white transition">
                            &#64;{{ $instagramPria }}
                        </a>
                    @endif
                </div>
            </div>
        </article>

        {{-- 02 / THE BRIDE --}}
        <article class="fx-slide-right bg-white border border-[#18181B]/25 p-5 kartu-3d space-y-4">
            <div class="flex items-center justify-between border-b border-[#18181B]/15 pb-2 text-[10px] font-bold uppercase tracking-[0.3em] text-[#52525B]">
                <span>02 / The Bride</span>
                <img src="{{ $asetEditorial['bingkai'] }}" alt="" class="w-5 opacity-60">
            </div>

            <div class="grid grid-cols-12 gap-4 items-center">
                <div class="{{ (! $tanpaFoto && $undangan->urlFotoWanita()) ? 'col-span-7 text-left' : 'col-span-12 text-left' }} space-y-1.5">
                    <h3 class="ed-serif text-3xl uppercase tracking-wide text-[#18181B]">{{ $undangan->nama_panggilan_wanita }}</h3>
                    <p class="text-xs font-bold uppercase tracking-wider text-[#18181B]">{{ $undangan->nama_lengkap_wanita }}</p>
                    @if ($undangan->nama_ayah_wanita || $undangan->nama_ibu_wanita)
                        <p class="text-xs text-[#52525B] leading-relaxed">
                            Putri dari {{ $undangan->nama_ayah_wanita }} &amp; {{ $undangan->nama_ibu_wanita }}
                        </p>
                    @endif
                    @if ($instagramWanita !== '')
                        <a href="https://instagram.com/{{ $instagramWanita }}" target="_blank" rel="noopener" class="mt-2 inline-block border border-[#18181B] px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-[#18181B] hover:bg-[#18181B] hover:text-white transition">
                            &#64;{{ $instagramWanita }}
                        </a>
                    @endif
                </div>
                @if (! $tanpaFoto && $undangan->urlFotoWanita())
                    <div class="col-span-5 border border-[#18181B]/20 p-1 bg-[#FAF9F6]">
                        <img src="{{ $undangan->urlFotoWanita() }}" alt="{{ $undangan->nama_lengkap_wanita }}" class="w-full aspect-[3/4] object-cover object-top grayscale hover:grayscale-0 transition duration-500">
                    </div>
                @endif
            </div>
        </article>
    </div>
</section>

{{-- SEKSI 4: GIANT HAIRLINE-DIVIDED TICKER COUNTDOWN --}}
@if ($undangan->fiturAktif('hitung_mundur') && $isoTarget)
<section
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
    class="relative bg-[#18181B] text-[#FAF9F6] px-5 py-12 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-6">
        <div class="flex items-center justify-between text-[10px] uppercase tracking-[0.34em] text-white/60 border-b border-white/20 pb-3">
            <span>02 / Save The Date</span>
            <span>Countdown</span>
        </div>

        <h2 class="fx-rise ed-serif text-3xl uppercase tracking-[0.08em] text-white text-center">Save The Date</h2>

        {{-- Ticker Garis Tipis Tanpa Sudut Lengkung --}}
        <div class="grid grid-cols-4 border-y border-white/25 divide-x divide-white/25 text-center">
            @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                <div class="py-4 px-1">
                    <div class="ed-serif text-3xl sm:text-4xl text-white leading-none" x-text="{{ $var }}">00</div>
                    <div class="mt-2 text-[9px] uppercase tracking-[0.28em] text-white/60">{{ $label }}</div>
                </div>
            @endforeach
        </div>

        @if ($googleCalUrl)
            <a href="{{ $googleCalUrl }}" target="_blank" rel="noopener" class="block w-full text-center bg-[#FAF9F6] text-[#18181B] py-3 text-xs font-bold uppercase tracking-[0.26em] hover:bg-white transition">
                Simpan ke Kalender &rarr;
            </a>
        @endif
    </div>
</section>
@endif

{{-- SEKSI 5: PERFORATED BOARDING-PASS EVENT TICKETS --}}
@if ($undangan->daftarAcara->isNotEmpty())
<section
    data-layout-acara="editorial"
    class="relative bg-[#FAF9F6] px-5 py-12 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-6">
        <div class="flex items-center justify-between border-b border-[#18181B]/25 pb-3 text-[10px] font-semibold uppercase tracking-[0.34em] text-[#52525B]">
            <span>02 / Save The Date</span>
            <span>Agenda Pernikahan</span>
        </div>

        @foreach ($undangan->daftarAcara as $idx => $acara)
            <article class="fx-scale-in bg-white border border-[#18181B] text-left kartu-3d">
                <div class="bg-[#18181B] text-white px-5 py-3 flex items-center justify-between text-[10px] font-bold uppercase tracking-[0.28em]">
                    <span>PASS {{ sprintf('%02d', $idx + 1) }}</span>
                    <span>{{ $acara->tanggal_acara->format('d.m.Y') }}</span>
                </div>

                <div class="p-5 space-y-3">
                    <h3 class="ed-serif text-2xl uppercase tracking-wide text-[#18181B]">{{ $acara->nama_acara }}</h3>
                    <div class="border-y border-dashed border-[#18181B]/35 py-3 grid grid-cols-2 gap-3 text-xs">
                        <div>
                            <span class="block text-[9px] uppercase tracking-[0.26em] text-[#52525B]">Date</span>
                            <span class="font-bold text-[#18181B]">{{ $acara->tanggal_acara->locale('id')->translatedFormat('l, d F Y') }}</span>
                        </div>
                        <div>
                            <span class="block text-[9px] uppercase tracking-[0.26em] text-[#52525B]">Time</span>
                            <span class="font-mono font-bold text-[#18181B]">
                                {{ \Illuminate\Support\Str::substr($acara->waktu_mulai, 0, 5) }}
                                @if ($acara->waktu_selesai) - {{ \Illuminate\Support\Str::substr($acara->waktu_selesai, 0, 5) }} @endif
                                {{ $acara->zona_waktu }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <span class="block text-[9px] uppercase tracking-[0.26em] text-[#52525B]">Venue</span>
                        <p class="font-bold text-sm text-[#18181B]">{{ $acara->nama_tempat }}</p>
                        <p class="text-xs text-[#52525B] leading-relaxed">{{ $acara->alamat_lengkap }}</p>
                    </div>

                    @if ($acara->link_maps)
                        <a href="{{ $acara->link_maps }}" target="_blank" rel="noopener" class="block w-full text-center bg-[#18181B] text-white py-2.5 text-[11px] font-bold uppercase tracking-[0.24em] hover:bg-[#3F3F46] transition">
                            Open Google Maps &rarr;
                        </a>
                    @endif
                </div>
            </article>
        @endforeach
    </div>
</section>
@endif

{{-- SEKSI 6: DRESS CODE & LIVE STREAMING --}}
@if ($adaDressCode || (! empty($live['aktif']) && ! empty($live['link'])))
<section class="relative bg-[#FAF9F6] px-5 pb-8 space-y-5 overflow-hidden">
    @if ($adaDressCode)
        <div data-section-dress-code="editorial" class="fx-rise max-w-md mx-auto bg-white border border-[#18181B]/30 p-5 text-left space-y-3">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#52525B]">Dress Code Palette</p>
            @if ($dressCodeCatatan !== '')
                <p class="text-xs text-[#18181B]/85 leading-relaxed">{{ $dressCodeCatatan }}</p>
            @endif
            @if (! empty($dressCodeWarna))
                <div class="grid grid-cols-4 gap-2 pt-1">
                    @foreach ($dressCodeWarna as $hex)
                        <div class="space-y-1">
                            <span class="block h-8 w-full border border-[#18181B]/30" style="background-color: {{ $hex }};"></span>
                            <span class="block text-[9px] font-mono text-[#52525B]">{{ $hex }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    @if (! empty($live['aktif']) && ! empty($live['link']))
        <div class="fx-rise max-w-md mx-auto bg-[#18181B] text-white p-5 text-left space-y-3">
            <p class="text-[10px] uppercase tracking-[0.34em] text-white/60">Private Stream</p>
            <h3 class="ed-serif text-2xl uppercase">Live Streaming</h3>
            <p class="text-xs text-white/75 leading-relaxed">
                Watch live via {{ $live['platform'] ?? 'Vimeo / YouTube Live' }}.
            </p>
            <a href="{{ $live['link'] }}" target="_blank" rel="noopener" class="inline-block bg-white text-[#18181B] px-5 py-2.5 text-[11px] font-bold uppercase tracking-[0.24em] hover:bg-neutral-200 transition">
                Watch Stream &rarr;
            </a>
        </div>
    @endif
</section>
@endif

{{-- SEKSI 7: 03 / STORYLINE — INDEKS MAJALAH BERNOMOR BESAR (01, 02, 03) --}}
@if ($undangan->fiturAktif('cerita_cinta') && ! empty($ceritaList))
<section
    data-layout-cerita="editorial"
    class="relative bg-[#FAF9F6] px-5 py-12 overflow-hidden"
>
    <div data-scroll-scrub class="max-w-md mx-auto mb-6 overflow-hidden">
        <p class="scroll-scrub-kiri text-[10px] font-bold uppercase tracking-[0.34em] text-[#52525B]">03 / Storyline</p>
        <h2 class="scroll-scrub-kanan mt-1 ed-serif text-3xl uppercase tracking-wide text-[#18181B]">Kisah Kami</h2>
    </div>

    <div class="max-w-md mx-auto divide-y divide-[#18181B]/25 border-y border-[#18181B]/25 bg-white px-4">
        @foreach ($ceritaList as $idx => $cerita)
            @php
                $urlFotoBab = (! $tanpaFoto && ! empty($cerita['foto']))
                    ? \App\Support\MediaPublik::url((string) $cerita['foto'])
                    : null;
            @endphp
            <article class="fx-rise py-5 grid grid-cols-12 gap-3 items-start">
                <div class="col-span-3">
                    <span class="ed-serif text-3xl text-[#18181B]/30 leading-none">{{ sprintf('%02d', $idx + 1) }}</span>
                    @if (! empty($cerita['tanggal']))
                        <span class="block mt-1 text-[9px] font-bold uppercase tracking-widest text-[#52525B]">{{ $cerita['tanggal'] }}</span>
                    @endif
                </div>
                <div class="col-span-9 text-left space-y-2">
                    @if ($urlFotoBab)
                        <div class="border border-[#18181B]/20 overflow-hidden">
                            <img src="{{ $urlFotoBab }}" alt="{{ $cerita['judul'] ?? 'Kisah Kami' }}" class="w-full aspect-[16/10] object-cover object-center grayscale">
                        </div>
                    @endif
                    <h3 class="ed-serif text-lg uppercase tracking-wide text-[#18181B]">{{ $cerita['judul'] ?? '' }}</h3>
                    <p class="text-xs text-[#52525B] leading-relaxed">{{ $cerita['cerita'] ?? '' }}</p>
                </div>
            </article>
        @endforeach
    </div>
</section>
@endif

{{-- SEKSI 8: 04 / PORTRAITS — LOOKBOOK GRAYSCALE-TO-COLOR GALLERY --}}
@if (! $tanpaFoto && $undangan->fiturAktif('galeri') && $undangan->daftarGaleri->isNotEmpty())
<section
    data-layout-galeri="editorial"
    class="relative bg-[#111113] text-[#FAF9F6] px-5 py-12 overflow-hidden"
>
    <div data-scroll-scrub class="max-w-md mx-auto mb-6 overflow-hidden">
        <p class="scroll-scrub-kanan text-[10px] font-bold uppercase tracking-[0.34em] text-white/60">04 / Portraits</p>
        <h2 class="scroll-scrub-kiri mt-1 ed-serif text-3xl uppercase tracking-wide text-white">Editorial Galeri</h2>
    </div>

    <div class="max-w-md mx-auto grid grid-cols-12 items-stretch gap-3">
        @foreach ($undangan->daftarGaleri as $galeri)
            @php
                $kelasTile = \App\Support\DataTemaUndangan::kelasGridGaleri($loop->index, $loop->count, 'editorial');
            @endphp
            <button
                type="button"
                @click="bukaGaleri(@js($galeri->urlFoto()), @js($galeri->keterangan))"
                class="fx-scale-in group relative overflow-hidden rounded-none border border-white/25 bg-black cursor-pointer kartu-3d {{ $kelasTile }}"
            >
                <img
                    src="{{ $galeri->urlFoto() }}"
                    alt="{{ $galeri->keterangan ?? 'Editorial Portrait' }}"
                    class="w-full h-full object-cover object-top grayscale group-hover:grayscale-0 group-hover:scale-105 transition duration-700"
                >
                @if ($galeri->keterangan)
                    <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-black/75 px-3 py-2 text-left text-[10px] uppercase tracking-wider text-white/90">
                        {{ $galeri->keterangan }}
                    </span>
                @endif
            </button>
        @endforeach
    </div>
</section>
@endif
