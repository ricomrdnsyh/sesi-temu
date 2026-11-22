{{-- SEKSI 3: HITUNG MUNDUR — 4 KAPSUL PIL BOTANI TINGGI (rounded-full) --}}
@if ($undangan->fiturAktif('hitung_mundur') && $isoTarget)
<section
    data-layout-countdown="taman"
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
    class="relative bg-gradient-to-b from-[#3E5A5C] to-[#1C3331] text-white px-5 py-12 text-center border-y border-[#C8A464]/40 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-5">
        <p class="text-[10px] font-semibold uppercase tracking-[0.34em] text-[#EEDAD4]">Menghitung Hari Bahagia</p>
        <h2 class="fx-rise font-serif text-3xl font-bold text-white">Save The Date</h2>

        {{-- 4 Kapsul Pil Botani Tinggi --}}
        <div class="grid grid-cols-4 gap-2.5 pt-2">
            @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                <div class="rounded-full bg-[#FDFBF7] text-[#1F3431] border-2 border-[#C8A464]/75 py-5 px-1.5 shadow-xl flex flex-col items-center justify-center">
                    <span class="font-serif text-2xl sm:text-3xl font-bold leading-none text-[#132623]" x-text="{{ $var }}">00</span>
                    <span class="mt-2 text-[9px] uppercase tracking-widest font-bold text-[#8D6F3A]">{{ $label }}</span>
                </div>
            @endforeach
        </div>

        @if ($googleCalUrl)
            <div class="pt-2">
                <a href="{{ $googleCalUrl }}" target="_blank" rel="noopener" class="garden-tombol-emas inline-flex items-center gap-2 rounded-full px-7 py-2.5 text-xs font-bold uppercase tracking-wider transition">
                    <span>Simpan ke Kalender</span>
                </a>
            </div>
        @endif
    </div>
</section>
@endif

{{-- SEKSI 4: PAVILIUN MEMPELAI KONSERVATORI (KARTU GADING + BINGKAI KACA LENGKUNG) --}}
<section
    data-layout-mempelai="taman"
    class="relative px-4 py-12 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-7">
        <div class="fx-rise text-center space-y-1.5">
            <img src="{{ $asetGarden['botani'] }}" alt="" class="w-11 mx-auto animasi-melayang">
            <p class="text-[10px] font-semibold uppercase tracking-[0.34em] text-[#EEDAD4]">Kedua Mempelai</p>
            <h2 class="font-serif text-3xl font-bold text-white">Bride &amp; Groom</h2>
        </div>

        {{-- MEMPELAI PRIA --}}
        <article class="fx-slide-left relative rounded-3xl bg-[#FDFBF7] text-[#1F3431] border-2 border-[#C8A464]/65 px-6 py-8 text-center shadow-2xl kartu-3d efek-shimmer-kartu space-y-3">
            @if (! $tanpaFoto && $undangan->urlFotoPria())
                <div class="mx-auto w-44 h-52 p-1.5 rounded-t-full rounded-b-2xl border-2 border-[#C8A464] bg-[#132623]/5">
                    <img
                        src="{{ $undangan->urlFotoPria() }}"
                        alt="{{ $undangan->nama_lengkap_pria }}"
                        class="w-full h-full rounded-t-full rounded-b-xl object-cover object-top"
                    >
                </div>
            @else
                <div class="mx-auto w-20 h-20 rounded-full bg-[#1D3532] text-[#F3DFA2] border-2 border-[#C8A464] flex items-center justify-center font-serif text-2xl font-bold">
                    {{ $undangan->inisialPria() }}
                </div>
            @endif

            <span class="inline-block rounded-full bg-[#3E5A5C]/15 border border-[#3E5A5C]/30 px-3 py-0.5 text-[10px] font-bold uppercase tracking-widest text-[#26403E]">
                The Groom
            </span>
            <h3 class="font-kaligrafi text-5xl text-[#132623] leading-tight">{{ $undangan->nama_panggilan_pria }}</h3>
            <p class="font-serif text-base font-bold text-[#1F3431]">{{ $undangan->nama_lengkap_pria }}</p>
            @if ($undangan->nama_ayah_pria || $undangan->nama_ibu_pria)
                <p class="text-xs text-[#1F3431]/75 leading-relaxed">
                    Putra dari {{ $undangan->nama_ayah_pria }} &amp; {{ $undangan->nama_ibu_pria }}
                </p>
            @endif
            @if ($instagramPria !== '')
                <div class="pt-1">
                    <a href="https://instagram.com/{{ $instagramPria }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 rounded-full bg-[#3E5A5C]/12 border border-[#C8A464]/55 px-3.5 py-1 text-[11px] font-semibold text-[#1F3431] hover:bg-[#3E5A5C] hover:text-white transition">
                        <span>&#64;{{ $instagramPria }}</span>
                    </a>
                </div>
            @endif
        </article>

        <div class="flex items-center justify-center gap-4 text-[#C8A464]">
            <span class="h-px w-16 bg-gradient-to-r from-transparent to-[#C8A464]"></span>
            <span class="font-kaligrafi text-4xl text-[#EEDAD4]">&amp;</span>
            <span class="h-px w-16 bg-gradient-to-l from-transparent to-[#C8A464]"></span>
        </div>

        {{-- MEMPELAI WANITA --}}
        <article class="fx-slide-right relative rounded-3xl bg-[#FDFBF7] text-[#1F3431] border-2 border-[#C8A464]/65 px-6 py-8 text-center shadow-2xl kartu-3d efek-shimmer-kartu space-y-3">
            @if (! $tanpaFoto && $undangan->urlFotoWanita())
                <div class="mx-auto w-44 h-52 p-1.5 rounded-t-full rounded-b-2xl border-2 border-[#C8A464] bg-[#132623]/5">
                    <img
                        src="{{ $undangan->urlFotoWanita() }}"
                        alt="{{ $undangan->nama_lengkap_wanita }}"
                        class="w-full h-full rounded-t-full rounded-b-xl object-cover object-top"
                    >
                </div>
            @else
                <div class="mx-auto w-20 h-20 rounded-full bg-[#1D3532] text-[#F3DFA2] border-2 border-[#C8A464] flex items-center justify-center font-serif text-2xl font-bold">
                    {{ $undangan->inisialWanita() }}
                </div>
            @endif

            <span class="inline-block rounded-full bg-[#C8A464]/20 border border-[#C8A464]/50 px-3 py-0.5 text-[10px] font-bold uppercase tracking-widest text-[#7D6027]">
                The Bride
            </span>
            <h3 class="font-kaligrafi text-5xl text-[#132623] leading-tight">{{ $undangan->nama_panggilan_wanita }}</h3>
            <p class="font-serif text-base font-bold text-[#1F3431]">{{ $undangan->nama_lengkap_wanita }}</p>
            @if ($undangan->nama_ayah_wanita || $undangan->nama_ibu_wanita)
                <p class="text-xs text-[#1F3431]/75 leading-relaxed">
                    Putri dari {{ $undangan->nama_ayah_wanita }} &amp; {{ $undangan->nama_ibu_wanita }}
                </p>
            @endif
            @if ($instagramWanita !== '')
                <div class="pt-1">
                    <a href="https://instagram.com/{{ $instagramWanita }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 rounded-full bg-[#3E5A5C]/12 border border-[#C8A464]/55 px-3.5 py-1 text-[11px] font-semibold text-[#1F3431] hover:bg-[#3E5A5C] hover:text-white transition">
                        <span>&#64;{{ $instagramWanita }}</span>
                    </a>
                </div>
            @endif
        </article>
    </div>
</section>

{{-- SEKSI 5: RANGKAIAN ACARA PAVILIUN TAMAN --}}
@if ($undangan->daftarAcara->isNotEmpty())
<section
    data-layout-acara="taman"
    class="relative bg-[#132623] px-4 py-12 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-6">
        <div class="fx-rise text-center space-y-1">
            <p class="text-[10px] font-semibold uppercase tracking-[0.34em] text-[#EEDAD4]">Momen Bahagia</p>
            <h2 class="font-serif text-3xl font-bold text-white">Rangkaian Acara</h2>
        </div>

        @foreach ($undangan->daftarAcara as $acara)
            <article class="fx-scale-in rounded-3xl bg-[#FDFBF7] text-[#1F3431] border-2 border-[#C8A464]/65 p-6 text-center shadow-2xl kartu-3d efek-shimmer-kartu space-y-3.5">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-[#3E5A5C] px-4 py-1 text-[10px] font-bold uppercase tracking-[0.25em] text-[#FDFBF7]">
                    <span>&#10047;</span>
                    <span>{{ $acara->tanggal_acara->locale('id')->translatedFormat('l') }}</span>
                </span>

                <h3 class="font-serif text-2xl font-bold text-[#132623]">{{ $acara->nama_acara }}</h3>

                <div class="rounded-2xl bg-[#132623]/5 border border-[#C8A464]/45 py-3 px-4 space-y-0.5">
                    <p class="font-serif text-lg font-bold text-[#132623]">
                        {{ $acara->tanggal_acara->locale('id')->translatedFormat('d F Y') }}
                    </p>
                    <p class="text-xs font-semibold text-[#7D6027]">
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
                    <p class="font-serif text-base font-bold text-[#132623]">{{ $acara->nama_tempat }}</p>
                    <p class="text-xs text-[#1F3431]/75 leading-relaxed max-w-xs mx-auto">{{ $acara->alamat_lengkap }}</p>
                </div>

                @if ($acara->link_maps)
                    <div class="pt-1">
                        <a href="{{ $acara->link_maps }}" target="_blank" rel="noopener" class="garden-tombol-sage inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-xs font-bold uppercase tracking-wider transition">
                            <span>Buka Google Maps</span>
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
        <div data-section-dress-code="taman" class="fx-rise max-w-md mx-auto rounded-3xl bg-[#0E1E18]/90 border border-[#C8A464]/50 p-6 text-center space-y-3">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#EEDAD4]">Botanical Dress Code</p>
            @if ($dressCodeCatatan !== '')
                <p class="text-xs sm:text-sm text-[#F4F8F6]/85 leading-relaxed">{{ $dressCodeCatatan }}</p>
            @endif
            @if (! empty($dressCodeWarna))
                <div class="flex flex-wrap items-center justify-center gap-3 pt-1">
                    @foreach ($dressCodeWarna as $hex)
                        <div class="flex flex-col items-center gap-1">
                            <span class="h-9 w-9 rounded-full border-2 border-[#EEDAD4] shadow-md" style="background-color: {{ $hex }};"></span>
                            <span class="text-[9px] font-mono text-[#EEDAD4]/80">{{ $hex }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    @if (! empty($live['aktif']) && ! empty($live['link']))
        <div class="fx-rise max-w-md mx-auto rounded-3xl bg-[#FDFBF7] text-[#1F3431] border-2 border-[#C8A464]/65 p-6 text-center space-y-3 shadow-xl">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#7D6027]">Sanctuary Broadcast</p>
            <h3 class="font-serif text-2xl font-bold text-[#132623]">Live Streaming</h3>
            <p class="text-xs text-[#1F3431]/75 leading-relaxed">
                Saksikan momen sakral kami secara langsung melalui {{ $live['platform'] ?? 'YouTube Live' }}.
            </p>
            <a href="{{ $live['link'] }}" target="_blank" rel="noopener" class="garden-tombol-sage inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-xs font-bold uppercase tracking-wider transition">
                <span>Gabung Live Streaming</span>
            </a>
        </div>
    @endif
</section>
@endif

{{-- SEKSI 7: JEJAK LANGKAH — LINIMASA SULUR BOTANI + FOTO PER-BAB --}}
@if ($undangan->fiturAktif('cerita_cinta') && ! empty($ceritaList))
<section
    data-layout-cerita="taman"
    class="relative px-4 py-12 overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-7 overflow-hidden py-1">
        <p class="scroll-scrub-kiri text-[10px] font-bold uppercase tracking-[0.34em] text-[#EEDAD4]">Jejak Langkah</p>
        <h2 class="scroll-scrub-kanan mt-1 font-serif text-3xl font-bold text-white">Cerita Cinta</h2>
    </div>

    <div class="max-w-md mx-auto relative pl-7 space-y-5 border-l-2 border-[#C8A464]/55 ml-3">
        @foreach ($ceritaList as $cerita)
            @php
                $urlFotoBab = (! $tanpaFoto && ! empty($cerita['foto']))
                    ? \App\Support\MediaPublik::url((string) $cerita['foto'])
                    : null;
            @endphp
            <article class="fx-slide-right relative">
                <span aria-hidden="true" class="absolute -left-[35px] top-5 w-3.5 h-3.5 rounded-full border-2 border-[#FDFBF7] bg-[#C8A464] shadow-[0_0_0_4px_rgba(200,164,100,0.28)]"></span>
                <div class="rounded-2xl bg-[#FDFBF7] text-[#1F3431] border border-[#C8A464]/60 p-5 shadow-xl kartu-3d efek-shimmer-kartu">
                    @if ($urlFotoBab)
                        <div class="mb-3 overflow-hidden rounded-xl border border-[#C8A464]/45">
                            <img src="{{ $urlFotoBab }}" alt="{{ $cerita['judul'] ?? 'Cerita Cinta' }}" class="w-full aspect-[16/10] object-cover object-center">
                        </div>
                    @endif
                    <div class="flex items-center justify-between gap-2">
                        <h3 class="font-serif text-lg font-bold text-[#132623]">{{ $cerita['judul'] ?? '' }}</h3>
                        @if (! empty($cerita['tanggal']))
                            <span class="rounded-full bg-[#C8A464]/20 border border-[#C8A464]/50 px-2.5 py-0.5 text-[10px] font-semibold text-[#7D6027]">{{ $cerita['tanggal'] }}</span>
                        @endif
                    </div>
                    <p class="mt-2 text-xs sm:text-sm text-[#1F3431]/80 leading-relaxed">{{ $cerita['cerita'] ?? '' }}</p>
                </div>
            </article>
        @endforeach
    </div>
</section>
@endif

{{-- SEKSI 8: GARDEN POLAROID GALLERY (KARTU POLAROID MIRING + CAPTION KALIGRAFI!) --}}
@if (! $tanpaFoto && $undangan->fiturAktif('galeri') && $undangan->daftarGaleri->isNotEmpty())
<section
    data-layout-galeri="taman"
    class="relative bg-[#132623] px-4 py-12 overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-7 overflow-hidden">
        <p class="scroll-scrub-kanan text-[10px] font-bold uppercase tracking-[0.34em] text-[#EEDAD4]">Garden Gallery</p>
        <h2 class="scroll-scrub-kiri mt-1 font-serif text-3xl font-bold text-white">Potret Kebahagiaan</h2>
    </div>

    <div class="max-w-md mx-auto grid grid-cols-12 items-stretch gap-3.5">
        @foreach ($undangan->daftarGaleri as $galeri)
            @php
                $kelasTile = \App\Support\DataTemaUndangan::kelasGridGaleri($loop->index, $loop->count, 'bento');
                $adalahLebar = str_contains($kelasTile, 'col-span-12');
            @endphp
            @if ($adalahLebar)
                <button
                    type="button"
                    @click="bukaGaleri(@js($galeri->urlFoto()), @js($galeri->keterangan))"
                    class="fx-scale-in group relative overflow-hidden rounded-3xl border-2 border-[#C8A464]/70 bg-[#0E1E18] shadow-2xl cursor-pointer kartu-3d {{ $kelasTile }}"
                >
                    <img src="{{ $galeri->urlFoto() }}" alt="{{ $galeri->keterangan ?? 'Galeri' }}" class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-700">
                    @if ($galeri->keterangan)
                        <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#0E1E18]/85 to-transparent px-4 py-2.5 text-left text-xs font-medium text-[#FDFBF7]">
                            {{ $galeri->keterangan }}
                        </span>
                    @endif
                </button>
            @else
                <button
                    type="button"
                    @click="bukaGaleri(@js($galeri->urlFoto()), @js($galeri->keterangan))"
                    class="fx-scale-in group relative rounded-2xl bg-white p-1.5 pb-7 shadow-xl border border-[#C8A464]/45 cursor-pointer kartu-3d {{ $kelasTile }} {{ $loop->odd ? 'polaroid-3d-kiri' : 'polaroid-3d-kanan' }}"
                >
                    <img src="{{ $galeri->urlFoto() }}" alt="{{ $galeri->keterangan ?? 'Galeri' }}" class="w-full h-full object-cover object-top rounded-xl group-hover:scale-105 transition duration-700">
                    <span class="pointer-events-none absolute inset-x-2 bottom-1.5 text-center text-[11px] font-kaligrafi text-[#1F3431] truncate">
                        {{ $galeri->keterangan ?: ($undangan->nama_panggilan_pria.' & '.$undangan->nama_panggilan_wanita) }}
                    </span>
                </button>
            @endif
        @endforeach
    </div>
</section>
@endif
