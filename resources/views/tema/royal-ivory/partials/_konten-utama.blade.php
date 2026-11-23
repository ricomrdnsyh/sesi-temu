{{-- SEKSI 3: KARTU LETTERPRESS MEMPELAI + PEMISAH SEGEL LILIN --}}
<section
    data-layout-mempelai="katedral"
    class="relative px-4 py-12 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-6">
        <div class="text-center space-y-1.5">
            <img data-gsap="turun" src="{{ $asetRoyal['katedral'] }}" alt="" class="w-11 mx-auto">
            <p data-gsap="turun" data-gsap-delay="0.05" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7B4F]">Royal Couple</p>
            <h2 data-gsap="naik" data-gsap-delay="0.09" class="font-serif text-3xl font-bold text-[#3B2E25]">Mempelai Berbahagia</h2>
        </div>

        {{-- MEMPELAI PRIA --}}
        <article class="rounded-3xl bg-white border border-[#9E7B4F]/50 p-2 shadow-xl kartu-3d">
            <div class="rounded-[1.2rem] border border-dashed border-[#9E7B4F]/45 px-5 py-7 text-center space-y-3">
                @if (! $tanpaFoto && $undangan->urlFotoPria())
                    <div data-gsap="potret" class="mx-auto w-44 h-52 p-1.5 rounded-t-full rounded-b-2xl border-2 border-[#9E7B4F]/65 bg-[#FBF8F3]">
                        <img src="{{ $undangan->urlFotoPria() }}" alt="{{ $undangan->nama_lengkap_pria }}" class="w-full h-full rounded-t-full rounded-b-xl object-cover object-top">
                    </div>
                @else
                    <div data-gsap="mekar" class="mx-auto w-20 h-20 rounded-full bg-[#EFE7DA] border-2 border-[#9E7B4F] flex items-center justify-center font-serif text-2xl font-bold text-[#58432B]">
                        {{ $undangan->inisialPria() }}
                    </div>
                @endif

                <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#9E7B4F]">The Groom</p>
                <h3 data-gsap="kiri" data-gsap-delay="0.06" class="font-kaligrafi text-5xl text-[#3B2E25] leading-tight">{{ $undangan->nama_panggilan_pria }}</h3>
                <p data-gsap="teks" data-gsap-delay="0.09" class="font-serif text-base font-bold text-[#3B2E25]">{{ $undangan->nama_lengkap_pria }}</p>
                @if ($undangan->nama_ayah_pria || $undangan->nama_ibu_pria)
                    <p data-gsap="teks" data-gsap-delay="0.12" class="text-xs text-[#3B2E25]/75 leading-relaxed">
                        Putra dari {{ $undangan->nama_ayah_pria }} &amp; {{ $undangan->nama_ibu_pria }}
                    </p>
                @endif
                @if ($instagramPria !== '')
                    <div data-gsap="mekar" data-gsap-delay="0.14" class="pt-1">
                        <a href="https://instagram.com/{{ $instagramPria }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 rounded-full border border-[#9E7B4F]/50 bg-[#FBF8F3] px-3.5 py-1 text-[11px] font-semibold text-[#58432B] hover:bg-[#9E7B4F] hover:text-white transition">
                            <span>&#64;{{ $instagramPria }}</span>
                        </a>
                    </div>
                @endif
            </div>
        </article>

        {{-- SEGEL LILIN PEMISAH --}}
        <div class="flex items-center justify-center gap-4">
            <span data-gsap="garis" class="h-px w-16 bg-gradient-to-r from-transparent to-[#9E7B4F]"></span>
            <div data-gsap="mekar" data-gsap-delay="0.06">
                <span class="w-11 h-11 rounded-full bg-[#9E7B4F] text-[#FAF6EE] border-2 border-[#E5C99B] shadow-md flex items-center justify-center font-kaligrafi text-2xl animasi-segel">&amp;</span>
            </div>
            <span data-gsap="garis" data-gsap-delay="0.08" class="h-px w-16 bg-gradient-to-l from-transparent to-[#9E7B4F]"></span>
        </div>

        {{-- MEMPELAI WANITA --}}
        <article class="rounded-3xl bg-white border border-[#9E7B4F]/50 p-2 shadow-xl kartu-3d">
            <div class="rounded-[1.2rem] border border-dashed border-[#9E7B4F]/45 px-5 py-7 text-center space-y-3">
                @if (! $tanpaFoto && $undangan->urlFotoWanita())
                    <div data-gsap="potret" class="mx-auto w-44 h-52 p-1.5 rounded-t-full rounded-b-2xl border-2 border-[#9E7B4F]/65 bg-[#FBF8F3]">
                        <img src="{{ $undangan->urlFotoWanita() }}" alt="{{ $undangan->nama_lengkap_wanita }}" class="w-full h-full rounded-t-full rounded-b-xl object-cover object-top">
                    </div>
                @else
                    <div data-gsap="mekar" class="mx-auto w-20 h-20 rounded-full bg-[#EFE7DA] border-2 border-[#9E7B4F] flex items-center justify-center font-serif text-2xl font-bold text-[#58432B]">
                        {{ $undangan->inisialWanita() }}
                    </div>
                @endif

                <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#9E7B4F]">The Bride</p>
                <h3 data-gsap="kanan" data-gsap-delay="0.06" class="font-kaligrafi text-5xl text-[#3B2E25] leading-tight">{{ $undangan->nama_panggilan_wanita }}</h3>
                <p data-gsap="teks" data-gsap-delay="0.09" class="font-serif text-base font-bold text-[#3B2E25]">{{ $undangan->nama_lengkap_wanita }}</p>
                @if ($undangan->nama_ayah_wanita || $undangan->nama_ibu_wanita)
                    <p data-gsap="teks" data-gsap-delay="0.12" class="text-xs text-[#3B2E25]/75 leading-relaxed">
                        Putri dari {{ $undangan->nama_ayah_wanita }} &amp; {{ $undangan->nama_ibu_wanita }}
                    </p>
                @endif
                @if ($instagramWanita !== '')
                    <div data-gsap="mekar" data-gsap-delay="0.14" class="pt-1">
                        <a href="https://instagram.com/{{ $instagramWanita }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 rounded-full border border-[#9E7B4F]/50 bg-[#FBF8F3] px-3.5 py-1 text-[11px] font-semibold text-[#58432B] hover:bg-[#9E7B4F] hover:text-white transition">
                            <span>&#64;{{ $instagramWanita }}</span>
                        </a>
                    </div>
                @endif
            </div>
        </article>
    </div>
</section>

{{-- SEKSI 4: BAB SURAT ROMAWI I, II, III (CERITA CINTA DITEMPATKAN SEBELUM ACARA!) --}}
@if ($undangan->fiturAktif('cerita_cinta') && ! empty($ceritaList))
<section
    data-layout-cerita="katedral"
    class="relative bg-[#EFE7DA] px-4 py-12 overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-7 overflow-hidden py-1">
        <div data-gsap="kiri">
            <p class="scroll-scrub-kiri text-[10px] font-bold uppercase tracking-[0.36em] text-[#9E7B4F]">Kisah Kami</p>
        </div>
        <div data-gsap="kanan" data-gsap-delay="0.06">
            <h2 class="scroll-scrub-kanan mt-1 font-serif text-3xl font-bold text-[#3B2E25]">Cerita Cinta</h2>
        </div>
    </div>

    <div class="max-w-md mx-auto space-y-4">
        @foreach ($ceritaList as $idx => $cerita)
            @php
                $urlFotoBab = (! $tanpaFoto && ! empty($cerita['foto']))
                    ? \App\Support\MediaPublik::url((string) $cerita['foto'])
                    : null;
            @endphp
            <article class="relative rounded-2xl bg-[#FBF8F3] border border-[#9E7B4F]/50 pl-14 pr-5 py-5 shadow-md kartu-3d">
                <span data-gsap="mekar" class="absolute left-3.5 top-5 inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#9E7B4F] font-serif text-xs font-bold text-[#FAF6EE] shadow-sm">
                    {{ $angkaRomawi[$idx] ?? ($idx + 1) }}
                </span>
                @if ($urlFotoBab)
                    <div data-gsap="potret" class="mb-3 overflow-hidden rounded-xl border border-[#9E7B4F]/35">
                        <img src="{{ $urlFotoBab }}" alt="{{ $cerita['judul'] ?? 'Cerita Cinta' }}" class="w-full aspect-[16/10] object-cover object-center">
                    </div>
                @endif
                <div class="flex items-center justify-between gap-2">
                    <h3 data-gsap="kiri" data-gsap-delay="0.05" class="font-serif text-lg font-bold text-[#3B2E25]">{{ $cerita['judul'] ?? '' }}</h3>
                    @if (! empty($cerita['tanggal']))
                        <span data-gsap="kanan" data-gsap-delay="0.08" class="text-[11px] font-semibold text-[#9E7B4F]">{{ $cerita['tanggal'] }}</span>
                    @endif
                </div>
                <p data-gsap="teks" data-gsap-delay="0.1" class="mt-1.5 text-xs sm:text-sm text-[#3B2E25]/80 leading-relaxed">{{ $cerita['cerita'] ?? '' }}</p>
            </article>
        @endforeach
    </div>
</section>
@endif

{{-- SEKSI 5: ROYAL RECEPTION — KARTU ACARA GARIS GANDA --}}
@if ($undangan->daftarAcara->isNotEmpty())
<section
    data-layout-acara="katedral"
    class="relative px-4 py-12 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-6">
        <div class="text-center space-y-1">
            <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7B4F]">Royal Reception</p>
            <h2 data-gsap="naik" data-gsap-delay="0.06" class="font-serif text-3xl font-bold text-[#3B2E25]">Rangkaian Acara</h2>
        </div>

        @foreach ($undangan->daftarAcara as $acara)
            <article class="rounded-3xl bg-white border border-[#9E7B4F]/55 p-2 shadow-xl kartu-3d">
                <div class="rounded-[1.2rem] border border-dashed border-[#9E7B4F]/45 px-5 py-7 text-center space-y-3.5">
                    <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.32em] text-[#9E7B4F]">
                        {{ $acara->tanggal_acara->locale('id')->translatedFormat('l') }}
                    </p>
                    <h3 data-gsap="mekar" data-gsap-delay="0.05" class="font-serif text-2xl font-bold text-[#3B2E25]">{{ $acara->nama_acara }}</h3>

                    <div data-gsap="naik" data-gsap-delay="0.09" class="border-y-2 border-double border-[#9E7B4F]/45 py-3 space-y-0.5">
                        <p class="font-serif text-xl font-bold text-[#58432B]">
                            {{ $acara->tanggal_acara->locale('id')->translatedFormat('d F Y') }}
                        </p>
                        <p class="text-xs font-semibold text-[#9E7B4F]">
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
                        <p data-gsap="kiri" data-gsap-delay="0.12" class="font-serif text-base font-bold text-[#3B2E25]">{{ $acara->nama_tempat }}</p>
                        <p data-gsap="teks" data-gsap-delay="0.14" class="text-xs text-[#3B2E25]/75 leading-relaxed max-w-xs mx-auto">{{ $acara->alamat_lengkap }}</p>
                    </div>

                    @if ($acara->link_maps)
                        <div data-gsap="mekar" data-gsap-delay="0.16" class="pt-1">
                            <a href="{{ $acara->link_maps }}" target="_blank" rel="noopener" class="royal-tombol inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-xs font-bold uppercase tracking-wider transition">
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

{{-- SEKSI 6: HITUNG MUNDUR PERUNGGU ROYAL --}}
@if ($undangan->fiturAktif('hitung_mundur') && $isoTarget)
<section
    data-layout-countdown="katedral"
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
    class="relative bg-gradient-to-b from-[#7B603F] to-[#58432B] text-[#FAF6EE] px-5 py-12 text-center overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-5">
        <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#E5C99B]">Countdown</p>
        <h2 data-gsap="naik" data-gsap-delay="0.06" class="font-serif text-3xl font-bold text-white">Save The Date</h2>

        <div class="grid grid-cols-4 gap-2.5 pt-1">
            @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                <div data-gsap="mekar" data-gsap-delay="{{ number_format($loop->index * 0.06, 2, '.', '') }}" class="rounded-2xl bg-[#FBF8F3] text-[#3B2E25] border border-[#E5C99B] py-3.5 px-1 shadow-lg">
                    <div class="font-serif text-2xl sm:text-3xl font-bold leading-none text-[#58432B]" x-text="{{ $var }}">00</div>
                    <div class="mt-1.5 text-[9px] uppercase tracking-widest font-bold text-[#9E7B4F]">{{ $label }}</div>
                </div>
            @endforeach
        </div>

        @if ($googleCalUrl)
            <div data-gsap="mekar" data-gsap-delay="0.12" class="pt-2">
                <a href="{{ $googleCalUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full bg-[#FAF6EE] px-7 py-2.5 text-xs font-bold uppercase tracking-wider text-[#58432B] shadow-md hover:bg-white transition">
                    <span>Simpan ke Kalender</span>
                </a>
            </div>
        @endif
    </div>
</section>
@endif

{{-- SEKSI 7: DRESS CODE & LIVE STREAMING --}}
@if ($adaDressCode || (! empty($live['aktif']) && ! empty($live['link'])))
<section class="relative bg-[#EFE7DA] px-4 py-8 space-y-5 overflow-hidden">
    @if ($adaDressCode)
        <div data-section-dress-code="katedral" class="max-w-md mx-auto rounded-3xl bg-[#FBF8F3] border border-[#9E7B4F]/45 p-6 text-center space-y-3">
            <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7B4F]">Dress Code</p>
            @if ($dressCodeCatatan !== '')
                <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-sm text-[#3B2E25]/85 leading-relaxed">{{ $dressCodeCatatan }}</p>
            @endif
            @if (! empty($dressCodeWarna))
                <div class="flex flex-wrap items-center justify-center gap-3 pt-1">
                    @foreach ($dressCodeWarna as $hex)
                        <div data-gsap="mekar" data-gsap-delay="{{ number_format($loop->index * 0.05, 2, '.', '') }}" class="flex flex-col items-center gap-1">
                            <span class="h-9 w-9 rounded-full border-2 border-[#9E7B4F] shadow-sm" style="background-color: {{ $hex }};"></span>
                            <span class="text-[9px] font-mono text-[#58432B]">{{ $hex }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    @if (! empty($live['aktif']) && ! empty($live['link']))
        <div class="max-w-md mx-auto rounded-3xl bg-white border border-[#9E7B4F]/50 p-6 text-center space-y-3 shadow-md">
            <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7B4F]">Siaran Langsung</p>
            <h3 data-gsap="naik" data-gsap-delay="0.05" class="font-serif text-2xl font-bold text-[#3B2E25]">Live Streaming</h3>
            <p data-gsap="teks" data-gsap-delay="0.09" class="text-xs text-[#3B2E25]/75 leading-relaxed">
                Saksikan prosesi suci kami secara virtual melalui {{ $live['platform'] ?? 'YouTube Live' }}.
            </p>
            <a data-gsap="mekar" data-gsap-delay="0.12" href="{{ $live['link'] }}" target="_blank" rel="noopener" class="royal-tombol inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-xs font-bold uppercase tracking-wider transition">
                <span>Gabung Live Streaming</span>
            </a>
        </div>
    @endif
</section>
@endif

{{-- SEKSI 8: GALERI LENGKUNG KATEDRAL --}}
@if (! $tanpaFoto && $undangan->fiturAktif('galeri') && $undangan->daftarGaleri->isNotEmpty())
<section
    data-layout-galeri="katedral"
    class="relative px-4 py-12 overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-7 overflow-hidden">
        <div data-gsap="kanan">
            <p class="scroll-scrub-kanan text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7B4F]">Captured Moments</p>
        </div>
        <div data-gsap="kiri" data-gsap-delay="0.06">
            <h2 class="scroll-scrub-kiri mt-1 font-serif text-3xl font-bold text-[#3B2E25]">Galeri Kebahagiaan</h2>
        </div>
    </div>

    <div class="max-w-md mx-auto grid grid-cols-12 items-stretch gap-3">
        @foreach ($undangan->daftarGaleri as $galeri)
            @php
                $kelasTile = \App\Support\DataTemaUndangan::kelasGridGaleri($loop->index, $loop->count, 'mihrab');
            @endphp
            <button
                type="button"
                data-gsap="potret"
                data-gsap-delay="{{ number_format(($loop->index % 2) * 0.07, 2, '.', '') }}"
                @click="bukaGaleri(@js($galeri->urlFoto()), @js($galeri->keterangan))"
                class="group relative overflow-hidden border-2 border-[#9E7B4F]/60 bg-white p-1 shadow-lg cursor-pointer kartu-3d {{ $kelasTile }}"
            >
                <div class="relative w-full h-full overflow-hidden rounded-[inherit]">
                    <img
                        src="{{ $galeri->urlFoto() }}"
                        alt="{{ $galeri->keterangan ?? 'Galeri' }}"
                        class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-700"
                    >
                    @if ($galeri->keterangan)
                        <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#3B2E25]/85 via-[#3B2E25]/30 to-transparent px-3 py-2 text-left text-[10.5px] font-medium text-[#FAF6EE] opacity-0 group-hover:opacity-100 transition duration-300">
                            {{ $galeri->keterangan }}
                        </span>
                    @endif
                </div>
            </button>
        @endforeach
    </div>
</section>
@endif
