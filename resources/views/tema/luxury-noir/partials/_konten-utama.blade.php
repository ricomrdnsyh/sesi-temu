{{-- SEKSI 3: SPOTLIGHT COUPLE DOSSIER (KARTU CORNER-BRACKET ART DECO + RING ORBIT) --}}
<section
    data-layout-mempelai="artdeco"
    class="relative px-4 py-12 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-6">
        <div class="fx-rise text-center space-y-1.5">
            <p class="text-[10px] font-semibold uppercase tracking-[0.38em] text-[#D4AF37]">The Couple</p>
            <h2 class="noir-font-judul text-2xl sm:text-3xl font-bold tracking-wider text-white">Bride &amp; Groom</h2>
        </div>

        {{-- GROOM SPOTLIGHT CARD --}}
        <article class="fx-slide-left relative rounded-xl bg-[#16151B] border border-[#D4AF37]/55 px-6 py-8 text-center shadow-2xl kartu-3d efek-shimmer-kartu space-y-3">
            <span aria-hidden="true" class="pointer-events-none absolute top-2 left-2 h-4 w-4 border-t-2 border-l-2 border-[#D4AF37]"></span>
            <span aria-hidden="true" class="pointer-events-none absolute top-2 right-2 h-4 w-4 border-t-2 border-r-2 border-[#D4AF37]"></span>
            <span aria-hidden="true" class="pointer-events-none absolute bottom-2 left-2 h-4 w-4 border-b-2 border-l-2 border-[#D4AF37]"></span>
            <span aria-hidden="true" class="pointer-events-none absolute bottom-2 right-2 h-4 w-4 border-b-2 border-r-2 border-[#D4AF37]"></span>

            @if (! $tanpaFoto && $undangan->urlFotoPria())
                <div class="relative mx-auto w-40 h-40 p-2 flex items-center justify-center">
                    <span aria-hidden="true" class="absolute inset-0 rounded-full border border-dashed border-[#D4AF37]/65 animasi-orbit"></span>
                    <span aria-hidden="true" class="absolute inset-1.5 rounded-full border border-[#F3E5AB]/55 animasi-orbit-balik"></span>
                    <img
                        src="{{ $undangan->urlFotoPria() }}"
                        alt="{{ $undangan->nama_lengkap_pria }}"
                        class="w-32 h-32 rounded-full object-cover object-top border-2 border-[#D4AF37]"
                    >
                </div>
            @else
                <div class="mx-auto w-20 h-20 rounded-full border-2 border-[#D4AF37] bg-[#0B0B0F] flex items-center justify-center noir-font-judul text-2xl font-bold text-[#F3E5AB]">
                    {{ $undangan->inisialPria() }}
                </div>
            @endif

            <p class="text-[10px] font-semibold uppercase tracking-[0.34em] text-[#D4AF37]">The Groom</p>
            <h3 class="noir-font-judul text-2xl sm:text-3xl font-bold tracking-wide text-[#F3E5AB]">
                {{ $undangan->nama_panggilan_pria }}
            </h3>
            <p class="font-serif text-sm font-semibold text-white">{{ $undangan->nama_lengkap_pria }}</p>
            @if ($undangan->nama_ayah_pria || $undangan->nama_ibu_pria)
                <p class="text-xs text-[#F5EFE6]/75 leading-relaxed">
                    Putra tercinta dari {{ $undangan->nama_ayah_pria }} &amp; {{ $undangan->nama_ibu_pria }}
                </p>
            @endif
            @if ($instagramPria !== '')
                <div class="pt-1">
                    <a href="https://instagram.com/{{ $instagramPria }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 rounded-full border border-[#D4AF37]/55 bg-black/50 px-3.5 py-1 text-[11px] font-semibold text-[#F3E5AB] hover:bg-[#D4AF37] hover:text-[#0B0B0F] transition">
                        <span>&#64;{{ $instagramPria }}</span>
                    </a>
                </div>
            @endif
        </article>

        {{-- DIAMOND ART DECO DIVIDER --}}
        <div class="flex items-center justify-center gap-4">
            <span class="h-px w-16 bg-gradient-to-r from-transparent to-[#D4AF37]"></span>
            <span class="w-3 h-3 rotate-45 border border-[#F3E5AB] bg-[#D4AF37]"></span>
            <span class="h-px w-16 bg-gradient-to-l from-transparent to-[#D4AF37]"></span>
        </div>

        {{-- BRIDE SPOTLIGHT CARD --}}
        <article class="fx-slide-right relative rounded-xl bg-[#16151B] border border-[#D4AF37]/55 px-6 py-8 text-center shadow-2xl kartu-3d efek-shimmer-kartu space-y-3">
            <span aria-hidden="true" class="pointer-events-none absolute top-2 left-2 h-4 w-4 border-t-2 border-l-2 border-[#D4AF37]"></span>
            <span aria-hidden="true" class="pointer-events-none absolute top-2 right-2 h-4 w-4 border-t-2 border-r-2 border-[#D4AF37]"></span>
            <span aria-hidden="true" class="pointer-events-none absolute bottom-2 left-2 h-4 w-4 border-b-2 border-l-2 border-[#D4AF37]"></span>
            <span aria-hidden="true" class="pointer-events-none absolute bottom-2 right-2 h-4 w-4 border-b-2 border-r-2 border-[#D4AF37]"></span>

            @if (! $tanpaFoto && $undangan->urlFotoWanita())
                <div class="relative mx-auto w-40 h-40 p-2 flex items-center justify-center">
                    <span aria-hidden="true" class="absolute inset-0 rounded-full border border-dashed border-[#D4AF37]/65 animasi-orbit"></span>
                    <span aria-hidden="true" class="absolute inset-1.5 rounded-full border border-[#F3E5AB]/55 animasi-orbit-balik"></span>
                    <img
                        src="{{ $undangan->urlFotoWanita() }}"
                        alt="{{ $undangan->nama_lengkap_wanita }}"
                        class="w-32 h-32 rounded-full object-cover object-top border-2 border-[#D4AF37]"
                    >
                </div>
            @else
                <div class="mx-auto w-20 h-20 rounded-full border-2 border-[#D4AF37] bg-[#0B0B0F] flex items-center justify-center noir-font-judul text-2xl font-bold text-[#F3E5AB]">
                    {{ $undangan->inisialWanita() }}
                </div>
            @endif

            <p class="text-[10px] font-semibold uppercase tracking-[0.34em] text-[#D4AF37]">The Bride</p>
            <h3 class="noir-font-judul text-2xl sm:text-3xl font-bold tracking-wide text-[#F3E5AB]">
                {{ $undangan->nama_panggilan_wanita }}
            </h3>
            <p class="font-serif text-sm font-semibold text-white">{{ $undangan->nama_lengkap_wanita }}</p>
            @if ($undangan->nama_ayah_wanita || $undangan->nama_ibu_wanita)
                <p class="text-xs text-[#F5EFE6]/75 leading-relaxed">
                    Putri tercinta dari {{ $undangan->nama_ayah_wanita }} &amp; {{ $undangan->nama_ibu_wanita }}
                </p>
            @endif
            @if ($instagramWanita !== '')
                <div class="pt-1">
                    <a href="https://instagram.com/{{ $instagramWanita }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 rounded-full border border-[#D4AF37]/55 bg-black/50 px-3.5 py-1 text-[11px] font-semibold text-[#F3E5AB] hover:bg-[#D4AF37] hover:text-[#0B0B0F] transition">
                        <span>&#64;{{ $instagramWanita }}</span>
                    </a>
                </div>
            @endif
        </article>
    </div>
</section>

{{-- SEKSI 4: ROYAL BALLROOM SCHEDULE (UNIFIED ART DECO PROGRAMME — SEBELUM COUNTDOWN!) --}}
@if ($undangan->daftarAcara->isNotEmpty())
<section
    data-layout-acara="artdeco"
    class="relative bg-[#111016] px-4 py-12 border-y border-[#D4AF37]/35 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-6">
        <div class="fx-rise text-center space-y-1">
            <p class="text-[10px] font-semibold uppercase tracking-[0.38em] text-[#D4AF37]">Royal Ballroom Schedule</p>
            <h2 class="noir-font-judul text-2xl sm:text-3xl font-bold tracking-wider text-white">Rangkaian Acara</h2>
        </div>

        <div class="relative rounded-xl bg-[#16151B] border border-[#D4AF37]/60 p-6 shadow-2xl divide-y divide-[#D4AF37]/30 efek-shimmer-kartu">
            <span aria-hidden="true" class="pointer-events-none absolute top-2 left-2 h-4 w-4 border-t-2 border-l-2 border-[#D4AF37]"></span>
            <span aria-hidden="true" class="pointer-events-none absolute top-2 right-2 h-4 w-4 border-t-2 border-r-2 border-[#D4AF37]"></span>
            <span aria-hidden="true" class="pointer-events-none absolute bottom-2 left-2 h-4 w-4 border-b-2 border-l-2 border-[#D4AF37]"></span>
            <span aria-hidden="true" class="pointer-events-none absolute bottom-2 right-2 h-4 w-4 border-b-2 border-r-2 border-[#D4AF37]"></span>

            @foreach ($undangan->daftarAcara as $acara)
                <article class="fx-scale-in py-6 first:pt-2 last:pb-2 text-center space-y-3">
                    <span class="inline-block border border-[#D4AF37]/50 bg-[#0B0B0F] px-3.5 py-1 text-[10px] font-bold uppercase tracking-[0.28em] text-[#F3E5AB]">
                        {{ $acara->tanggal_acara->locale('id')->translatedFormat('l, d F Y') }}
                    </span>

                    <h3 class="noir-font-judul text-xl sm:text-2xl font-bold tracking-wide text-[#F3E5AB]">
                        {{ $acara->nama_acara }}
                    </h3>

                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#D4AF37]">
                        {{ \Illuminate\Support\Str::substr($acara->waktu_mulai, 0, 5) }}
                        @if ($acara->waktu_selesai)
                            &mdash; {{ \Illuminate\Support\Str::substr($acara->waktu_selesai, 0, 5) }}
                        @else
                            &mdash; Selesai
                        @endif
                        {{ $acara->zona_waktu }}
                    </p>

                    <div class="space-y-1">
                        <p class="font-serif text-base font-bold text-white">{{ $acara->nama_tempat }}</p>
                        <p class="text-xs text-[#F5EFE6]/70 leading-relaxed max-w-xs mx-auto">{{ $acara->alamat_lengkap }}</p>
                    </div>

                    @if ($acara->link_maps)
                        <div class="pt-1">
                            <a href="{{ $acara->link_maps }}" target="_blank" rel="noopener" class="noir-tombol-emas inline-flex items-center gap-2 rounded-full px-6 py-2 text-[11px] font-bold uppercase tracking-[0.18em] transition">
                                <span>Venue Directions</span>
                            </a>
                        </div>
                    @endif
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- SEKSI 5: BEVELED GOLD-PLATE COUNTDOWN --}}
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
    class="relative px-4 py-12 text-center overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-5">
        <p class="text-[10px] font-semibold uppercase tracking-[0.38em] text-[#D4AF37]">Countdown To The Gala</p>
        <h2 class="fx-rise noir-font-judul text-2xl sm:text-3xl font-bold tracking-wider text-[#F3E5AB]">Save The Date</h2>

        <div class="grid grid-cols-4 gap-2.5 pt-1">
            @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                <div class="rounded-lg bg-[#16151B] border border-[#D4AF37]/60 py-4 px-1 shadow-lg">
                    <div class="noir-font-judul text-2xl sm:text-3xl font-bold text-[#F3E5AB] leading-none" x-text="{{ $var }}">00</div>
                    <div class="mt-2 text-[9px] uppercase tracking-[0.22em] font-semibold text-[#D4AF37]">{{ $label }}</div>
                </div>
            @endforeach
        </div>

        @if ($googleCalUrl)
            <div class="pt-2">
                <a href="{{ $googleCalUrl }}" target="_blank" rel="noopener" class="noir-tombol-emas inline-flex items-center gap-2 rounded-full px-7 py-2.5 text-xs font-bold uppercase tracking-[0.18em] transition">
                    <span>Simpan ke Kalender</span>
                </a>
            </div>
        @endif
    </div>
</section>
@endif

{{-- SEKSI 6: BLACK-TIE DRESS CODE & VIP LIVE STREAMING --}}
@if ($adaDressCode || (! empty($live['aktif']) && ! empty($live['link'])))
<section class="relative px-4 pb-8 space-y-5 overflow-hidden">
    @if ($adaDressCode)
        <div data-section-dress-code="artdeco" class="fx-rise max-w-md mx-auto rounded-xl bg-[#16151B] border border-[#D4AF37]/50 p-6 text-center space-y-3">
            <p class="text-[10px] font-semibold uppercase tracking-[0.36em] text-[#D4AF37]">Black-Tie Dress Code</p>
            @if ($dressCodeCatatan !== '')
                <p class="text-xs sm:text-sm text-[#F5EFE6]/85 leading-relaxed">{{ $dressCodeCatatan }}</p>
            @endif
            @if (! empty($dressCodeWarna))
                <div class="flex flex-wrap items-center justify-center gap-3 pt-1">
                    @foreach ($dressCodeWarna as $hex)
                        <div class="flex flex-col items-center gap-1">
                            <span class="h-9 w-9 rounded-lg border border-[#F3E5AB]/80 shadow-md" style="background-color: {{ $hex }};"></span>
                            <span class="text-[9px] font-mono text-[#F3E5AB]/75">{{ $hex }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    @if (! empty($live['aktif']) && ! empty($live['link']))
        <div class="fx-rise max-w-md mx-auto rounded-xl bg-[#16151B] border border-[#D4AF37]/55 p-6 text-center space-y-3 efek-shimmer-kartu">
            <p class="text-[10px] font-semibold uppercase tracking-[0.36em] text-[#D4AF37]">VIP Private Broadcast</p>
            <h3 class="noir-font-judul text-xl font-bold text-[#F3E5AB]">Live Streaming</h3>
            <p class="text-xs text-[#F5EFE6]/80 leading-relaxed">
                Join our virtual ballroom broadcast via {{ $live['platform'] ?? 'YouTube Live' }}.
            </p>
            <a href="{{ $live['link'] }}" target="_blank" rel="noopener" class="noir-tombol-emas inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-xs font-bold uppercase tracking-[0.18em] transition">
                <span>Join Live Cast</span>
            </a>
        </div>
    @endif
</section>
@endif

{{-- SEKSI 7: GOLD-DIAMOND VERTICAL TIMELINE LOVE STORY --}}
@if ($undangan->fiturAktif('cerita_cinta') && ! empty($ceritaList))
<section
    data-layout-cerita="artdeco"
    class="relative px-4 py-12 overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-7 overflow-hidden py-1">
        <p class="scroll-scrub-kiri text-[10px] font-semibold uppercase tracking-[0.38em] text-[#D4AF37]">Our Golden Journey</p>
        <h2 class="scroll-scrub-kanan mt-1 noir-font-judul text-2xl sm:text-3xl font-bold tracking-wider text-white">Cerita Cinta</h2>
    </div>

    <div class="max-w-md mx-auto relative pl-7 space-y-5 border-l border-[#D4AF37]/50 ml-3">
        @foreach ($ceritaList as $cerita)
            @php
                $urlFotoBab = (! $tanpaFoto && ! empty($cerita['foto']))
                    ? \App\Support\MediaPublik::url((string) $cerita['foto'])
                    : null;
            @endphp
            <article class="fx-slide-right relative">
                <span aria-hidden="true" class="absolute -left-[35px] top-5 w-3.5 h-3.5 rotate-45 border border-[#F3E5AB] bg-[#D4AF37] shadow-[0_0_12px_rgba(212,175,55,0.65)]"></span>
                <div class="rounded-xl bg-[#16151B] border border-[#D4AF37]/50 p-5 shadow-xl kartu-3d efek-shimmer-kartu">
                    @if ($urlFotoBab)
                        <div class="mb-3 overflow-hidden rounded-lg border border-[#D4AF37]/40">
                            <img src="{{ $urlFotoBab }}" alt="{{ $cerita['judul'] ?? 'Cerita Cinta' }}" class="w-full aspect-[16/10] object-cover object-center">
                        </div>
                    @endif
                    <div class="flex items-center justify-between gap-2">
                        <h3 class="noir-font-judul text-base font-bold text-[#F3E5AB]">{{ $cerita['judul'] ?? '' }}</h3>
                        @if (! empty($cerita['tanggal']))
                            <span class="border border-[#D4AF37]/45 bg-black/50 px-2.5 py-0.5 text-[10px] font-semibold text-[#D4AF37]">{{ $cerita['tanggal'] }}</span>
                        @endif
                    </div>
                    <p class="mt-2 text-xs sm:text-sm text-[#F5EFE6]/80 leading-relaxed">{{ $cerita['cerita'] ?? '' }}</p>
                </div>
            </article>
        @endforeach
    </div>
</section>
@endif

{{-- SEKSI 8: GRAND BALLROOM HERO GALLERY (WAJIB col-span-2 aspect-[16/10] UNTUK FEATURED HERO) --}}
@if (! $tanpaFoto && $undangan->fiturAktif('galeri') && $undangan->daftarGaleri->isNotEmpty())
<section
    data-layout-galeri="artdeco"
    class="relative bg-[#111016] px-4 py-12 border-t border-[#D4AF37]/30 overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-7 overflow-hidden">
        <p class="scroll-scrub-kanan text-[10px] font-semibold uppercase tracking-[0.38em] text-[#D4AF37]">Captured Memories</p>
        <h2 class="scroll-scrub-kiri mt-1 noir-font-judul text-2xl sm:text-3xl font-bold tracking-wider text-white">Galeri Potret</h2>
    </div>

    <div class="max-w-md mx-auto grid grid-cols-2 items-stretch gap-3">
        @foreach ($undangan->daftarGaleri as $galeri)
            @php
                $kelasTile = \App\Support\DataTemaUndangan::kelasGridGaleri($loop->index, $loop->count, 'artdeco');
            @endphp
            <button
                type="button"
                @click="bukaGaleri(@js($galeri->urlFoto()), @js($galeri->keterangan))"
                class="fx-scale-in group relative overflow-hidden border border-[#D4AF37]/60 bg-black cursor-pointer kartu-3d {{ $kelasTile }}"
            >
                <img
                    src="{{ $galeri->urlFoto() }}"
                    alt="{{ $galeri->keterangan ?? 'Galeri' }}"
                    class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-700"
                >
                @if ($galeri->keterangan)
                    <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/85 via-black/35 to-transparent px-3 py-2 text-left text-[10.5px] font-medium text-[#F3E5AB]">
                        {{ $galeri->keterangan }}
                    </span>
                @endif
            </button>
        @endforeach
    </div>
</section>
@endif
