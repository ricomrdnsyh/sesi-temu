{{-- SEKSI 3: PROFIL MEMPELAI SYAR'I (KARTU GARIS ZAMRUD TENANG — SANGAT RAMAH MODE TANPA FOTO) --}}
<section
    data-layout-mempelai="mihrab"
    class="relative px-4 py-12 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-5">
        <div class="fx-rise text-center space-y-1.5">
            <img src="{{ $asetSyari['arabesque'] }}" alt="" class="w-10 mx-auto">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7D40]">Mempelai</p>
            <h2 class="font-serif text-3xl font-bold text-[#184D47]">Calon Pengantin</h2>
        </div>

        {{-- MEMPELAI PRIA --}}
        <article class="fx-slide-left rounded-2xl bg-white border border-[#184D47]/20 border-l-4 border-l-[#184D47] p-5 shadow-md kartu-3d">
            <div class="flex items-center gap-4">
                @if (! $tanpaFoto && $undangan->urlFotoPria())
                    <img src="{{ $undangan->urlFotoPria() }}" alt="{{ $undangan->nama_lengkap_pria }}" class="w-24 h-28 rounded-t-full rounded-b-xl object-cover object-top border border-[#BFA15F]/60 shrink-0">
                @else
                    <div class="w-16 h-16 rounded-t-full rounded-b-xl bg-[#184D47] text-[#F3E5AB] border border-[#BFA15F]/60 flex items-center justify-center font-serif text-2xl font-bold shrink-0">
                        {{ $undangan->inisialPria() }}
                    </div>
                @endif
                <div class="text-left space-y-1">
                    <span class="inline-block text-[10px] font-bold uppercase tracking-widest text-[#9E7D40]">Mempelai Pria</span>
                    <h3 class="font-serif text-2xl font-bold text-[#184D47] leading-tight">{{ $undangan->nama_panggilan_pria }}</h3>
                    <p class="text-xs font-semibold text-[#184D47]/90">{{ $undangan->nama_lengkap_pria }}</p>
                    @if ($undangan->nama_ayah_pria || $undangan->nama_ibu_pria)
                        <p class="text-[11px] text-[#184D47]/70 leading-relaxed">Putra dari {{ $undangan->nama_ayah_pria }} &amp; {{ $undangan->nama_ibu_pria }}</p>
                    @endif
                    @if ($instagramPria !== '')
                        <a href="https://instagram.com/{{ $instagramPria }}" target="_blank" rel="noopener" class="mt-1 inline-block rounded-full bg-[#184D47]/10 px-3 py-0.5 text-[10px] font-semibold text-[#184D47] hover:bg-[#184D47] hover:text-white transition">&#64;{{ $instagramPria }}</a>
                    @endif
                </div>
            </div>
        </article>

        <div class="flex items-center justify-center gap-3 text-[#BFA15F]">
            <span class="h-px w-14 bg-[#184D47]/20"></span>
            <span class="font-kaligrafi text-3xl text-[#184D47]">&amp;</span>
            <span class="h-px w-14 bg-[#184D47]/20"></span>
        </div>

        {{-- MEMPELAI WANITA --}}
        <article class="fx-slide-right rounded-2xl bg-white border border-[#184D47]/20 border-r-4 border-r-[#BFA15F] p-5 shadow-md kartu-3d">
            <div class="flex items-center justify-between gap-4">
                <div class="text-left space-y-1">
                    <span class="inline-block text-[10px] font-bold uppercase tracking-widest text-[#9E7D40]">Mempelai Wanita</span>
                    <h3 class="font-serif text-2xl font-bold text-[#184D47] leading-tight">{{ $undangan->nama_panggilan_wanita }}</h3>
                    <p class="text-xs font-semibold text-[#184D47]/90">{{ $undangan->nama_lengkap_wanita }}</p>
                    @if ($undangan->nama_ayah_wanita || $undangan->nama_ibu_wanita)
                        <p class="text-[11px] text-[#184D47]/70 leading-relaxed">Putri dari {{ $undangan->nama_ayah_wanita }} &amp; {{ $undangan->nama_ibu_wanita }}</p>
                    @endif
                    @if ($instagramWanita !== '')
                        <a href="https://instagram.com/{{ $instagramWanita }}" target="_blank" rel="noopener" class="mt-1 inline-block rounded-full bg-[#184D47]/10 px-3 py-0.5 text-[10px] font-semibold text-[#184D47] hover:bg-[#184D47] hover:text-white transition">&#64;{{ $instagramWanita }}</a>
                    @endif
                </div>
                @if (! $tanpaFoto && $undangan->urlFotoWanita())
                    <img src="{{ $undangan->urlFotoWanita() }}" alt="{{ $undangan->nama_lengkap_wanita }}" class="w-24 h-28 rounded-t-full rounded-b-xl object-cover object-top border border-[#BFA15F]/60 shrink-0">
                @else
                    <div class="w-16 h-16 rounded-t-full rounded-b-xl bg-[#184D47] text-[#F3E5AB] border border-[#BFA15F]/60 flex items-center justify-center font-serif text-2xl font-bold shrink-0">
                        {{ $undangan->inisialWanita() }}
                    </div>
                @endif
            </div>
        </article>
    </div>
</section>

{{-- SEKSI 4: JADWAL AKAD & WALIMAH (TIMETABLE 2-KOLOM BERSIH & TERSTRUKTUR) --}}
@if ($undangan->daftarAcara->isNotEmpty())
<section
    data-layout-acara="mihrab"
    class="relative bg-white/80 px-4 py-12 border-y border-[#184D47]/15 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-5">
        <div class="fx-rise text-center space-y-1">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7D40]">InsyaAllah Dilaksanakan Pada</p>
            <h2 class="font-serif text-3xl font-bold text-[#184D47]">Jadwal Akad &amp; Walimah</h2>
        </div>

        @foreach ($undangan->daftarAcara as $acara)
            <article class="fx-scale-in rounded-2xl bg-white border border-[#184D47]/20 overflow-hidden shadow-md kartu-3d">
                <div class="grid grid-cols-12">
                    {{-- Kolom Kiri Tanggal & Jam --}}
                    <div class="col-span-4 bg-[#184D47] text-[#F4FAF6] p-4 flex flex-col items-center justify-center text-center">
                        <span class="text-[10px] uppercase tracking-widest text-[#E6D19C]">{{ $acara->tanggal_acara->locale('id')->translatedFormat('M') }}</span>
                        <span class="font-serif text-3xl font-bold leading-none my-1">{{ $acara->tanggal_acara->format('d') }}</span>
                        <span class="text-[10px] opacity-85">{{ $acara->tanggal_acara->format('Y') }}</span>
                        <span class="mt-2 rounded-full bg-white/15 px-2 py-0.5 text-[10px] font-semibold">
                            {{ \Illuminate\Support\Str::substr($acara->waktu_mulai, 0, 5) }} {{ $acara->zona_waktu }}
                        </span>
                    </div>

                    {{-- Kolom Kanan Detail Lokasi --}}
                    <div class="col-span-8 p-4 text-left space-y-2">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-[#9E7D40]">{{ $acara->tanggal_acara->locale('id')->translatedFormat('l') }}</p>
                        <h3 class="font-serif text-lg font-bold text-[#184D47] leading-snug">{{ $acara->nama_acara }}</h3>
                        <p class="text-xs font-bold text-[#184D47]/90">{{ $acara->nama_tempat }}</p>
                        <p class="text-[11px] text-[#184D47]/70 leading-relaxed">{{ $acara->alamat_lengkap }}</p>
                        @if ($acara->link_maps)
                            <a href="{{ $acara->link_maps }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 rounded-full bg-[#184D47] px-4 py-1.5 text-[10px] font-bold uppercase tracking-wider text-white hover:bg-[#133D38] transition">
                                <span>Lokasi Maps</span>
                            </a>
                        @endif
                    </div>
                </div>
            </article>
        @endforeach
    </div>
</section>
@endif

{{-- SEKSI 5: HITUNG MUNDUR EMERALD --}}
@if ($undangan->fiturAktif('hitung_mundur') && $isoTarget)
<section
    data-layout-countdown="mihrab"
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
    class="relative bg-gradient-to-b from-[#184D47] to-[#0F342F] text-white px-5 py-11 text-center overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-5">
        <p class="text-[10px] font-semibold uppercase tracking-[0.34em] text-[#E6D19C]">Menuju Hari Bahagia</p>
        <h2 class="fx-rise font-serif text-3xl font-bold text-white">Save The Date</h2>

        <div class="grid grid-cols-4 gap-2.5 pt-1">
            @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                <div class="rounded-2xl bg-white text-[#184D47] py-3.5 px-1 shadow-sm">
                    <div class="font-serif text-2xl sm:text-3xl font-bold leading-none" x-text="{{ $var }}">00</div>
                    <div class="mt-1.5 text-[9px] uppercase tracking-wider font-bold text-[#9E7D40]">{{ $label }}</div>
                </div>
            @endforeach
        </div>

        @if ($googleCalUrl)
            <div class="pt-1">
                <a href="{{ $googleCalUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full bg-white px-6 py-2.5 text-xs font-bold uppercase tracking-wider text-[#184D47] shadow-sm hover:bg-[#F4FAF6] transition">
                    <span>Simpan ke Kalender</span>
                </a>
            </div>
        @endif
    </div>
</section>
@endif

{{-- SEKSI 6: ADAB BUSANA & LIVE STREAMING --}}
@if ($adaDressCode || (! empty($live['aktif']) && ! empty($live['link'])))
<section class="relative px-4 pt-8 space-y-4 overflow-hidden">
    @if ($adaDressCode)
        <div data-section-dress-code="mihrab" class="fx-rise max-w-md mx-auto rounded-2xl bg-white border border-[#184D47]/20 p-5 text-center space-y-3">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7D40]">Nuansa Busana Syar&rsquo;i</p>
            @if ($dressCodeCatatan !== '')
                <p class="text-xs text-[#184D47]/80 leading-relaxed">{{ $dressCodeCatatan }}</p>
            @endif
            @if (! empty($dressCodeWarna))
                <div class="flex flex-wrap items-center justify-center gap-3">
                    @foreach ($dressCodeWarna as $hex)
                        <div class="flex flex-col items-center gap-1">
                            <span class="h-8 w-8 rounded-full border-2 border-[#184D47]/30" style="background-color: {{ $hex }};"></span>
                            <span class="text-[9px] font-mono text-[#184D47]/70">{{ $hex }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    @if (! empty($live['aktif']) && ! empty($live['link']))
        <div class="fx-rise max-w-md mx-auto rounded-2xl bg-white border border-[#184D47]/20 p-5 text-center space-y-3">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7D40]">Siaran Langsung</p>
            <h3 class="font-serif text-xl font-bold text-[#184D47]">Live Streaming Akad</h3>
            <p class="text-xs text-[#184D47]/75 leading-relaxed">
                Saksikan prosesi akad melalui {{ $live['platform'] ?? 'YouTube Live' }}.
            </p>
            <a href="{{ $live['link'] }}" target="_blank" rel="noopener" class="syari-tombol inline-flex items-center gap-2 rounded-full px-6 py-2 text-xs font-bold uppercase tracking-wider transition">
                <span>Gabung Siaran</span>
            </a>
        </div>
    @endif
</section>
@endif

{{-- SEKSI 7: PERJALANAN TA'ARUF --}}
@if ($undangan->fiturAktif('cerita_cinta') && ! empty($ceritaList))
<section
    data-layout-cerita="mihrab"
    class="relative px-4 py-12 overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-6 overflow-hidden">
        <p class="scroll-scrub-kiri text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7D40]">Perjalanan Ta&rsquo;aruf</p>
        <h2 class="scroll-scrub-kanan mt-1 font-serif text-3xl font-bold text-[#184D47]">Kisah Pertemuan</h2>
    </div>

    <div class="max-w-md mx-auto space-y-4">
        @foreach ($ceritaList as $cerita)
            @php
                $urlFotoBab = (! $tanpaFoto && ! empty($cerita['foto']))
                    ? \App\Support\MediaPublik::url((string) $cerita['foto'])
                    : null;
            @endphp
            <article class="fx-rise rounded-2xl bg-white border border-[#184D47]/20 border-t-2 border-t-[#BFA15F] p-5 shadow-sm kartu-3d">
                @if ($urlFotoBab)
                    <div class="mb-3 overflow-hidden rounded-xl border border-[#184D47]/15">
                        <img src="{{ $urlFotoBab }}" alt="{{ $cerita['judul'] ?? 'Kisah Pertemuan' }}" class="w-full aspect-[16/10] object-cover object-center">
                    </div>
                @endif
                <div class="flex items-center justify-between gap-2">
                    <h3 class="font-serif text-lg font-bold text-[#184D47]">{{ $cerita['judul'] ?? '' }}</h3>
                    @if (! empty($cerita['tanggal']))
                        <span class="rounded-full bg-[#BFA15F]/15 px-2.5 py-0.5 text-[10px] font-semibold text-[#184D47]">{{ $cerita['tanggal'] }}</span>
                    @endif
                </div>
                <p class="mt-2 text-xs sm:text-sm text-[#184D47]/80 leading-relaxed">{{ $cerita['cerita'] ?? '' }}</p>
            </article>
        @endforeach
    </div>
</section>
@endif

{{-- SEKSI 8: GALERI (TERSEMBUNYI SAAT MODE TANPA FOTO) --}}
@if (! $tanpaFoto && $undangan->fiturAktif('galeri') && $undangan->daftarGaleri->isNotEmpty())
<section
    data-layout-galeri="mihrab"
    class="relative px-4 pb-12 overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-6 overflow-hidden">
        <p class="scroll-scrub-kanan text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7D40]">Galeri Kenangan</p>
        <h2 class="scroll-scrub-kiri mt-1 font-serif text-3xl font-bold text-[#184D47]">Momen Terindah</h2>
    </div>

    <div class="max-w-md mx-auto grid grid-cols-2 gap-3">
        @foreach ($undangan->daftarGaleri as $galeri)
            <button
                type="button"
                @click="bukaGaleri(@js($galeri->urlFoto()), @js($galeri->keterangan))"
                class="fx-scale-in group relative aspect-square overflow-hidden rounded-2xl border border-[#184D47]/20 bg-white cursor-pointer kartu-3d"
            >
                <img src="{{ $galeri->urlFoto() }}" alt="{{ $galeri->keterangan ?? 'Galeri' }}" class="w-full h-full object-cover object-center group-hover:scale-105 transition duration-700">
            </button>
        @endforeach
    </div>
</section>
@endif
