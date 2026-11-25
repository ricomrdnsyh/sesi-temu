{{-- SEKSI 3: PROFIL MEMPELAI — KARTU LETTERPRESS ROYAL IVORY + SEGEL LILIN --}}
<section
    id="elegan-mempelai"
    data-kartu-tumpuk
    data-layout-mempelai="katedral"
    class="royal-kartu-tumpuk relative bg-[#FBF8F3] px-4 py-14 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-7">
        <div class="text-center space-y-2 px-2">
            <img data-gsap="turun" src="{{ $asetRoyal['katedral'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async" class="w-11 mx-auto opacity-95 animasi-ayun-3d">
            <p data-gsap="turun" data-gsap-delay="0.04" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7B4F]">Royal Couple</p>
            <h2 data-gsap="naik" data-gsap-delay="0.07" class="font-serif text-3xl font-bold text-[#3B2E25]">Mempelai Berbahagia</h2>
            <p data-gsap="teks" data-gsap-delay="0.10" class="text-xs sm:text-[13px] text-[#3B2E25]/76 max-w-xs mx-auto leading-relaxed">
                Dengan memohon rahmat dan ridho Tuhan Yang Maha Esa, kami bermaksud menyelenggarakan pernikahan putra-putri kami:
            </p>
        </div>

        {{-- MEMPELAI PRIA --}}
        <article class="group rounded-3xl bg-white border border-[#9E7B4F]/55 p-2 shadow-xl kartu-3d">
            <div class="rounded-[1.25rem] border border-dashed border-[#9E7B4F]/45 px-5 py-7 text-center space-y-3">
                @if (! $tanpaFoto && $undangan->urlFotoPria())
                    <div data-gsap="potret" class="mx-auto w-48 sm:w-52 aspect-[4/4.8] p-1.5 rounded-t-[8rem] rounded-b-2xl border-2 border-[#9E7B4F]/65 bg-[#FBF8F3] shadow-md overflow-hidden">
                        <img
                            src="{{ $undangan->urlFotoPria() }}"
                            alt="{{ $undangan->nama_lengkap_pria }}"
                            loading="lazy"
                            decoding="async"
                            class="w-full h-full rounded-t-[7.5rem] rounded-b-xl object-cover object-top group-hover:scale-105 transition duration-700"
                        >
                    </div>
                @else
                    <div data-gsap="mekar" class="mx-auto w-24 h-28 rounded-t-full rounded-b-2xl bg-[#EFE7DA] border-2 border-[#9E7B4F] flex items-center justify-center font-serif text-3xl font-bold text-[#58432B] shadow-inner">
                        {{ $undangan->inisialPria() }}
                    </div>
                @endif

                <div data-gsap="turun" class="pt-1">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-[#EFE7DA]/85 border border-[#9E7B4F]/45 px-3.5 py-0.5 text-[9.5px] font-bold uppercase tracking-[0.26em] text-[#7B603F]">
                        Mempelai Pria
                    </span>
                </div>

                <h3 data-gsap="kiri" data-gsap-delay="0.06" class="font-kaligrafi text-[2.85rem] sm:text-5xl text-[#3B2E25] leading-tight">
                    {{ $undangan->nama_panggilan_pria }}
                </h3>
                <p data-gsap="teks" data-gsap-delay="0.09" class="font-serif text-base font-bold text-[#3B2E25]">
                    {{ $undangan->nama_lengkap_pria }}
                </p>

                @if ($undangan->nama_ayah_pria || $undangan->nama_ibu_pria)
                    <div class="pt-1 space-y-1">
                        <div data-gsap="garis" class="flex items-center justify-center gap-2.5 px-10" aria-hidden="true">
                            <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#9E7B4F]/55"></span>
                            <span class="w-1 h-1 rounded-full bg-[#9E7B4F]"></span>
                            <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#9E7B4F]/55"></span>
                        </div>
                        <p data-gsap="teks" class="text-[9.5px] font-bold uppercase tracking-[0.24em] text-[#9E7B4F] pt-0.5">Putra dari</p>
                        <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-[13px] text-[#3B2E25]/78 leading-relaxed max-w-xs mx-auto">
                            {{ $undangan->nama_ayah_pria }} &amp; {{ $undangan->nama_ibu_pria }}
                        </p>
                    </div>
                @endif

                @if ($instagramPria !== '')
                    <div data-gsap="mekar" data-gsap-delay="0.12" class="pt-1.5">
                        <a
                            href="https://instagram.com/{{ $instagramPria }}"
                            target="_blank"
                            rel="noopener"
                            class="inline-flex items-center gap-1.5 rounded-full border border-[#9E7B4F]/55 bg-[#FBF8F3] px-4 py-1.5 text-[11px] font-semibold text-[#58432B] hover:bg-[#9E7B4F] hover:text-white transition active:scale-95"
                        >
                            <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                            </svg>
                            <span>&#64;{{ $instagramPria }}</span>
                        </a>
                    </div>
                @endif
            </div>
        </article>

        {{-- SEGEL LILIN PEMISAH --}}
        <div class="flex items-center justify-center gap-4 px-6" aria-hidden="true">
            <span data-gsap="garis" class="h-px flex-1 bg-gradient-to-r from-transparent to-[#9E7B4F]"></span>
            <div data-gsap="mekar" data-gsap-delay="0.06">
                <span class="w-11 h-11 rounded-full bg-[#9E7B4F] text-[#FAF6EE] border-2 border-[#E5C99B] shadow-md flex items-center justify-center font-kaligrafi text-2xl animasi-segel">&amp;</span>
            </div>
            <span data-gsap="garis" class="h-px flex-1 bg-gradient-to-l from-transparent to-[#9E7B4F]"></span>
        </div>

        {{-- MEMPELAI WANITA --}}
        <article class="group rounded-3xl bg-white border border-[#9E7B4F]/55 p-2 shadow-xl kartu-3d">
            <div class="rounded-[1.25rem] border border-dashed border-[#9E7B4F]/45 px-5 py-7 text-center space-y-3">
                @if (! $tanpaFoto && $undangan->urlFotoWanita())
                    <div data-gsap="potret" class="mx-auto w-48 sm:w-52 aspect-[4/4.8] p-1.5 rounded-t-[8rem] rounded-b-2xl border-2 border-[#9E7B4F]/65 bg-[#FBF8F3] shadow-md overflow-hidden">
                        <img
                            src="{{ $undangan->urlFotoWanita() }}"
                            alt="{{ $undangan->nama_lengkap_wanita }}"
                            loading="lazy"
                            decoding="async"
                            class="w-full h-full rounded-t-[7.5rem] rounded-b-xl object-cover object-top group-hover:scale-105 transition duration-700"
                        >
                    </div>
                @else
                    <div data-gsap="mekar" class="mx-auto w-24 h-28 rounded-t-full rounded-b-2xl bg-[#EFE7DA] border-2 border-[#9E7B4F] flex items-center justify-center font-serif text-3xl font-bold text-[#58432B] shadow-inner">
                        {{ $undangan->inisialWanita() }}
                    </div>
                @endif

                <div data-gsap="turun" class="pt-1">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-[#EFE7DA]/85 border border-[#9E7B4F]/45 px-3.5 py-0.5 text-[9.5px] font-bold uppercase tracking-[0.26em] text-[#7B603F]">
                        Mempelai Wanita
                    </span>
                </div>

                <h3 data-gsap="kanan" data-gsap-delay="0.06" class="font-kaligrafi text-[2.85rem] sm:text-5xl text-[#3B2E25] leading-tight">
                    {{ $undangan->nama_panggilan_wanita }}
                </h3>
                <p data-gsap="teks" data-gsap-delay="0.09" class="font-serif text-base font-bold text-[#3B2E25]">
                    {{ $undangan->nama_lengkap_wanita }}
                </p>

                @if ($undangan->nama_ayah_wanita || $undangan->nama_ibu_wanita)
                    <div class="pt-1 space-y-1">
                        <div data-gsap="garis" class="flex items-center justify-center gap-2.5 px-10" aria-hidden="true">
                            <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#9E7B4F]/55"></span>
                            <span class="w-1 h-1 rounded-full bg-[#9E7B4F]"></span>
                            <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#9E7B4F]/55"></span>
                        </div>
                        <p data-gsap="teks" class="text-[9.5px] font-bold uppercase tracking-[0.24em] text-[#9E7B4F] pt-0.5">Putri dari</p>
                        <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-[13px] text-[#3B2E25]/78 leading-relaxed max-w-xs mx-auto">
                            {{ $undangan->nama_ayah_wanita }} &amp; {{ $undangan->nama_ibu_wanita }}
                        </p>
                    </div>
                @endif

                @if ($instagramWanita !== '')
                    <div data-gsap="mekar" data-gsap-delay="0.12" class="pt-1.5">
                        <a
                            href="https://instagram.com/{{ $instagramWanita }}"
                            target="_blank"
                            rel="noopener"
                            class="inline-flex items-center gap-1.5 rounded-full border border-[#9E7B4F]/55 bg-[#FBF8F3] px-4 py-1.5 text-[11px] font-semibold text-[#58432B] hover:bg-[#9E7B4F] hover:text-white transition active:scale-95"
                        >
                            <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                            </svg>
                            <span>&#64;{{ $instagramWanita }}</span>
                        </a>
                    </div>
                @endif
            </div>
        </article>
    </div>
</section>

{{-- SEKSI 4A: SLIDESHOW POTRET GADING TRANSISI KE HITUNG MUNDUR PERUNGGU ROYAL --}}
<div id="elegan-tanggal" data-kartu-tumpuk class="royal-kartu-tumpuk bg-[#7B603F] overflow-hidden">
@if ($fotoGaleriSlideshow->isNotEmpty())
<div
    data-slideshow-royal
    data-gsap="potret"
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
    class="relative h-68 sm:h-76 w-full overflow-hidden bg-[#58432B]"
>
    @foreach ($fotoGaleriSlideshow as $idxSlide => $urlSlide)
        <img
            src="{{ $urlSlide }}"
            alt="Momen Bahagia {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
            loading="lazy"
            decoding="async"
            class="absolute inset-0 w-full h-full object-cover object-top transition-opacity duration-1000"
            :class="slideAktif === {{ $idxSlide }} ? 'opacity-90 scale-105' : 'opacity-0 scale-100'"
            style="transition: opacity 1.1s ease, transform 5s ease;"
        >
    @endforeach
    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-0"
        style="background: linear-gradient(180deg, rgba(251,248,243,0.42) 0%, rgba(123,96,63,0.28) 46%, #7B603F 100%);"
    ></div>
</div>
@endif

{{-- SEKSI 4B: SAVE THE DATE & HITUNG MUNDUR PERUNGGU ROYAL --}}
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
    class="relative bg-gradient-to-b from-[#7B603F] via-[#684F33] to-[#58432B] shadow-[0_-2px_0_0_#7B603F] text-[#FAF6EE] px-5 py-13 text-center overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-5">
        <div class="space-y-1.5">
            <img src="{{ $asetRoyal['katedral'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async" data-gsap="turun" class="w-11 mx-auto opacity-95 drop-shadow">
            <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#E5C99B]">Menuju Hari Bahagia</p>
            <h2 data-gsap="naik" data-gsap-delay="0.06" class="font-serif text-3xl sm:text-4xl font-bold text-white">Save The Date</h2>
            <p data-gsap="teks" data-gsap-delay="0.08" class="text-xs font-medium text-[#FAF6EE]/85">
                {{ $tanggalLengkap }}
            </p>
        </div>

        <div class="grid grid-cols-4 gap-2.5 pt-1 panggung-3d">
            @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                <div data-gsap="mekar" data-gsap-delay="{{ number_format($loop->index * 0.06, 2, '.', '') }}" class="rounded-2xl bg-[#FBF8F3] text-[#3B2E25] border border-[#E5C99B] py-3.5 px-1 shadow-lg">
                    <div
                        class="font-serif text-2xl sm:text-3xl font-bold leading-none text-[#58432B] tabular-nums"
                        x-text="{{ $var }}"
                        x-effect="if ({{ $var }}) { $el.classList.remove('angka-flip-3d'); void $el.offsetWidth; $el.classList.add('angka-flip-3d'); }"
                    >00</div>
                    <div class="mt-1.5 text-[9px] uppercase tracking-widest font-bold text-[#9E7B4F]">{{ $label }}</div>
                </div>
            @endforeach
        </div>

        <p data-gsap="teks" class="text-xs text-[#FAF6EE]/85 max-w-xs mx-auto leading-relaxed">
            Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu.
        </p>

        @if ($googleCalUrl)
            <div data-gsap="mekar" data-gsap-delay="0.10" class="pt-1">
                <a href="{{ $googleCalUrl }}" target="_blank" rel="noopener" class="royal-tombol-gading inline-flex items-center gap-2 rounded-full px-7 py-2.5 text-xs font-bold uppercase tracking-wider transition active:scale-95">
                    <svg class="w-3.5 h-3.5 shrink-0 text-[#7B603F]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect width="18" height="18" x="3" y="4" rx="2"/>
                        <path d="M16 2v4M8 2v4M3 10h18"/>
                    </svg>
                    <span>Simpan ke Kalender</span>
                </a>
            </div>
        @endif
    </div>
</section>
@endif
</div>

{{-- SEKSI 5: RANGKAIAN ACARA — PIAGAM LETTERPRESS ROYAL IVORY --}}
@if ($undangan->daftarAcara->isNotEmpty())
<section
    id="elegan-acara"
    data-kartu-tumpuk
    data-layout-acara="katedral"
    class="royal-kartu-tumpuk relative bg-[#FBF8F3] px-4 py-14 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-6">
        <div class="text-center space-y-1.5">
            <div data-gsap="turun" class="flex items-center justify-center gap-2.5">
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-r from-transparent to-[#9E7B4F]"></span>
                <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7B4F]">Waktu &amp; Tempat</p>
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-l from-transparent to-[#9E7B4F]"></span>
            </div>
            <h2 data-gsap="naik" data-gsap-delay="0.06" class="font-serif text-3xl font-bold text-[#3B2E25]">Rangkaian Acara</h2>
            <p data-gsap="teks" data-gsap-delay="0.08" class="text-xs text-[#3B2E25]/74 max-w-xs mx-auto leading-relaxed">
                Dengan penuh suka cita, kami mengundang Bapak/Ibu/Saudara/i pada rangkaian acara pernikahan kami:
            </p>
        </div>

        <div class="space-y-5">
            @foreach ($undangan->daftarAcara as $acara)
                @php
                    $nomorProsesi = str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT);
                @endphp
                <article class="rounded-3xl bg-white border border-[#9E7B4F]/55 p-2 shadow-xl kartu-3d">
                    <div class="rounded-[1.25rem] border border-dashed border-[#9E7B4F]/45 overflow-hidden text-center">
                        {{-- Kubah Tajuk Prosesi Perunggu --}}
                        <div class="bg-gradient-to-b from-[#6E5436] to-[#58432B] px-5 py-5 text-[#FAF6EE] border-b border-[#E5C99B]/55 space-y-1">
                            <p data-gsap="turun" class="text-[9.5px] font-bold uppercase tracking-[0.3em] text-[#E5C99B]">
                                Prosesi {{ $nomorProsesi }} &bull; {{ $acara->tanggal_acara->locale('id')->translatedFormat('l') }}
                            </p>
                            <h3 data-gsap="mekar" data-gsap-delay="0.05" class="font-serif text-2xl font-bold text-white leading-snug">
                                {{ $acara->nama_acara }}
                            </h3>
                        </div>

                        <div class="px-5 py-6 space-y-4">
                            <div data-gsap="naik" data-gsap-delay="0.08" class="border-y-2 border-double border-[#9E7B4F]/40 py-3 space-y-0.5">
                                <p class="font-serif text-xl font-bold text-[#58432B]">
                                    {{ $acara->tanggal_acara->locale('id')->translatedFormat('d F Y') }}
                                </p>
                                <p class="text-xs font-semibold text-[#9E7B4F]">
                                    Pukul {{ \Illuminate\Support\Str::substr($acara->waktu_mulai, 0, 5) }}
                                    @if ($acara->waktu_selesai)
                                        &ndash; {{ \Illuminate\Support\Str::substr($acara->waktu_selesai, 0, 5) }}
                                    @else
                                        &ndash; Selesai
                                    @endif
                                    {{ $acara->zona_waktu }}
                                </p>
                            </div>

                            <div class="space-y-1">
                                <p data-gsap="kiri" data-gsap-delay="0.11" class="font-serif text-base font-bold text-[#3B2E25] leading-snug">
                                    {{ $acara->nama_tempat }}
                                </p>
                                <p data-gsap="teks" data-gsap-delay="0.13" class="text-xs text-[#3B2E25]/75 leading-relaxed max-w-xs mx-auto">
                                    {{ $acara->alamat_lengkap }}
                                </p>
                            </div>

                            @if ($acara->link_maps)
                                <div data-gsap="mekar" data-gsap-delay="0.15" class="pt-1">
                                    <a href="{{ $acara->link_maps }}" target="_blank" rel="noopener" class="royal-tombol inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-xs font-bold uppercase tracking-wider transition active:scale-95">
                                        <svg class="w-3.5 h-3.5 shrink-0 text-[#E5C99B]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7Zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/>
                                        </svg>
                                        <span>Buka Google Maps</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- SEKSI 6: DRESS CODE & LIVE STREAMING --}}
@if ($adaDressCode || (! empty($live['aktif']) && ! empty($live['link'])))
<section data-kartu-tumpuk class="royal-kartu-tumpuk relative bg-[#EFE7DA] px-4 py-11 space-y-5 overflow-hidden">
    @if ($adaDressCode)
        <div data-section-dress-code="katedral" class="max-w-md mx-auto rounded-3xl bg-[#FBF8F3] border border-[#9E7B4F]/50 p-6 text-center space-y-3.5 shadow-md kartu-3d">
            <div class="space-y-1">
                <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7B4F]">Panduan Kehadiran</p>
                <h3 data-gsap="naik" class="font-serif text-2xl font-bold text-[#3B2E25]">Dress Code</h3>
            </div>
            @if ($dressCodeCatatan !== '')
                <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-sm text-[#3B2E25]/82 leading-relaxed">{{ $dressCodeCatatan }}</p>
            @endif
            @if (! empty($dressCodeWarna))
                <div class="flex flex-wrap items-center justify-center gap-3.5 pt-1">
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
        <div class="max-w-md mx-auto rounded-3xl bg-white border border-[#9E7B4F]/50 p-6 text-center space-y-3 shadow-md kartu-3d">
            <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7B4F]">Siaran Langsung</p>
            <h3 data-gsap="naik" data-gsap-delay="0.05" class="font-serif text-2xl font-bold text-[#3B2E25]">Live Streaming</h3>
            <p data-gsap="teks" data-gsap-delay="0.09" class="text-xs text-[#3B2E25]/78 leading-relaxed max-w-xs mx-auto">
                Bagi kerabat dan sahabat yang berhalangan hadir langsung, silakan menyaksikan momen bahagia kami melalui {{ $live['platform'] ?? 'YouTube Live' }}.
            </p>
            <div data-gsap="mekar" data-gsap-delay="0.12" class="pt-1">
                <a href="{{ $live['link'] }}" target="_blank" rel="noopener" class="royal-tombol inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-xs font-bold uppercase tracking-wider transition active:scale-95">
                    <svg class="w-4 h-4 shrink-0 text-[#E5C99B]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
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

{{-- SEKSI 7: CERITA CINTA — BAB SURAT ROMAWI I, II, III (URUTAN SERAGAM SEMUA KATEGORI) --}}
@if ($undangan->fiturAktif('cerita_cinta') && ! empty($ceritaList))
<section
    data-kartu-tumpuk
    data-layout-cerita="katedral"
    class="royal-kartu-tumpuk relative bg-[#FBF8F3] px-4 py-13 overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-7 overflow-hidden py-1">
        <div data-gsap="kiri">
            <p class="scroll-scrub-kiri text-[10px] font-bold uppercase tracking-[0.36em] text-[#9E7B4F]">Kisah Perjalanan Kami</p>
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
            <article class="relative rounded-2xl bg-white border border-[#9E7B4F]/50 pl-14 pr-5 py-5 shadow-md kartu-3d">
                <span data-gsap="mekar" class="absolute left-3.5 top-5 inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#9E7B4F] font-serif text-xs font-bold text-[#FAF6EE] shadow-sm">
                    {{ $angkaRomawi[$idx] ?? ($idx + 1) }}
                </span>
                @if ($urlFotoBab)
                    <div data-gsap="potret" class="mb-3 overflow-hidden rounded-xl border border-[#9E7B4F]/35">
                        <img src="{{ $urlFotoBab }}" alt="{{ $cerita['judul'] ?? 'Cerita Cinta' }}" loading="lazy" decoding="async" class="w-full aspect-[16/10] object-cover object-center">
                    </div>
                @endif
                <div class="flex items-center justify-between gap-2 flex-wrap">
                    <h3 data-gsap="kiri" data-gsap-delay="0.05" class="font-serif text-lg font-bold text-[#3B2E25]">{{ $cerita['judul'] ?? '' }}</h3>
                    @if (! empty($cerita['tanggal']))
                        <span data-gsap="kanan" data-gsap-delay="0.08" class="rounded-full bg-[#EFE7DA] px-2.5 py-0.5 text-[10.5px] font-semibold text-[#7B603F]">{{ $cerita['tanggal'] }}</span>
                    @endif
                </div>
                <p data-gsap="teks" data-gsap-delay="0.1" class="mt-1.5 text-xs sm:text-sm text-[#3B2E25]/80 leading-relaxed">{{ $cerita['cerita'] ?? '' }}</p>
            </article>
        @endforeach
    </div>
</section>
@endif

{{-- SEKSI 8: GALERI MODE GESER + GRID KOTAK RAPI DENGAN BORDER TIPIS 1PX --}}
@if (! $tanpaFoto && $undangan->fiturAktif('galeri') && $undangan->daftarGaleri->isNotEmpty())
<section
    id="elegan-galeri"
    data-kartu-tumpuk
    data-layout-galeri="katedral"
    data-galeri-reel-elegan="ivory"
    x-data="{
        modeGrid: false,
        indeksReel: 0,
        totalFoto: {{ $undangan->daftarGaleri->count() }},
        geserReel(arah) {
            const el = this.$refs.jalurReelRoyal;
            if (!el) return;
            const lebarKartu = el.firstElementChild ? el.firstElementChild.offsetWidth + 14 : 280;
            el.scrollBy({ left: arah * lebarKartu, behavior: 'smooth' });
        },
        perbaruiIndeksReel() {
            const el = this.$refs.jalurReelRoyal;
            if (!el || !el.firstElementChild) return;
            const lebar = el.firstElementChild.offsetWidth + 14;
            this.indeksReel = Math.min(this.totalFoto - 1, Math.max(0, Math.round(el.scrollLeft / Math.max(1, lebar))));
        }
    }"
    class="royal-kartu-tumpuk relative bg-[#EFE7DA] px-4 py-13 overflow-hidden"
>
    <div class="max-w-md mx-auto mb-6 flex items-end justify-between gap-3">
        <div class="text-left min-w-0">
            <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7B4F]">Momen Berharga</p>
            <h2 data-gsap="naik" data-gsap-delay="0.06" class="mt-1 font-serif text-3xl font-bold text-[#3B2E25]">Galeri Kebahagiaan</h2>
        </div>

        <button
            type="button"
            @click="modeGrid = !modeGrid; window.SesiTemuSinema?.refresh(100)"
            class="shrink-0 rounded-full border border-[#9E7B4F]/45 bg-[#FBF8F3] px-3.5 py-1.5 text-[10px] font-bold uppercase tracking-[0.14em] text-[#58432B] hover:bg-[#9E7B4F] hover:text-white transition cursor-pointer"
            x-text="modeGrid ? 'Mode Geser' : 'Lihat Semua'"
        >Lihat Semua</button>
    </div>

    {{-- Mode Utama: Swipeable Horizontal Kotak Rapi Border Tipis 1px --}}
    <div x-show="!modeGrid" class="max-w-md mx-auto space-y-4">
        <div
            x-ref="jalurReelRoyal"
            @scroll.passive="perbaruiIndeksReel()"
            data-horizontal-editorial
            class="flex items-stretch gap-3 overflow-x-auto snap-x snap-mandatory no-scrollbar pb-1 cursor-grab"
        >
            @foreach ($undangan->daftarGaleri as $galeri)
                <button
                    type="button"
                    @click="bukaGaleri(@js($galeri->urlFoto()), @js($galeri->keterangan))"
                    class="group relative w-[78%] sm:w-[74%] shrink-0 snap-center aspect-[4/5] overflow-hidden rounded-xl border border-[#9E7B4F]/30 bg-[#E5DBC9] shadow-md cursor-pointer"
                >
                    <img
                        src="{{ $galeri->urlFoto() }}"
                        alt="{{ $galeri->keterangan ?? 'Galeri' }}"
                        loading="lazy"
                        decoding="async"
                        class="block w-full h-full object-cover object-top group-hover:scale-105 transition duration-700"
                    >
                    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-t from-[#2B211A]/80 via-transparent to-transparent"></div>
                    <span class="pointer-events-none absolute top-3 left-3 rounded-full bg-[#FBF8F3]/90 border border-[#9E7B4F]/35 px-2.5 py-0.5 text-[9px] font-bold uppercase tracking-[0.2em] text-[#58432B]">
                        {{ sprintf('%02d', $loop->iteration) }} / {{ sprintf('%02d', $loop->count) }}
                    </span>
                    @if ($galeri->keterangan)
                        <span class="pointer-events-none absolute inset-x-0 bottom-0 px-3.5 py-3 text-left font-serif text-xs font-medium text-[#FAF6EE] truncate">
                            {{ $galeri->keterangan }}
                        </span>
                    @endif
                </button>
            @endforeach
        </div>

        <div class="flex items-center justify-between gap-3 pt-1">
            <button type="button" @click="geserReel(-1)" aria-label="Foto sebelumnya" class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-[#9E7B4F]/45 bg-[#FBF8F3] text-[#58432B] hover:bg-[#9E7B4F] hover:text-white transition cursor-pointer">&larr;</button>
            <div class="flex-1 h-1 rounded-full bg-[#9E7B4F]/20 overflow-hidden">
                <div class="h-full bg-gradient-to-r from-[#9E7B4F] to-[#58432B] transition-all duration-300" :style="'width: ' + (((indeksReel + 1) / Math.max(1, totalFoto)) * 100) + '%'"></div>
            </div>
            <button type="button" @click="geserReel(1)" aria-label="Foto berikutnya" class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-[#9E7B4F]/45 bg-[#FBF8F3] text-[#58432B] hover:bg-[#9E7B4F] hover:text-white transition cursor-pointer">&rarr;</button>
        </div>
    </div>

    {{-- Mode Lihat Semua: Grid Kotak Bento Rapi Border Tipis 1px --}}
    @php
        $totalGaleriRoyal = $undangan->daftarGaleri->count();
    @endphp
    <div x-show="modeGrid" x-cloak x-transition.opacity.duration.250ms class="max-w-md mx-auto grid grid-cols-12 gap-2.5">
        @foreach ($undangan->daftarGaleri as $galeri)
            @php
                $pola = $loop->index % 5;
                $sisa = $totalGaleriRoyal - $loop->index;
                $kelasTile = match (true) {
                    $pola === 0 => 'col-span-12 aspect-[16/10]',
                    $sisa === 1 && ($pola === 1 || $pola === 3) => 'col-span-12 aspect-[16/10]',
                    $pola === 1 => 'col-span-7 h-48 sm:h-56',
                    $pola === 2 => 'col-span-5 h-48 sm:h-56',
                    $pola === 3 => 'col-span-5 h-48 sm:h-56',
                    default => 'col-span-7 h-48 sm:h-56',
                };
            @endphp
            <button
                type="button"
                @click="bukaGaleri(@js($galeri->urlFoto()), @js($galeri->keterangan))"
                class="group relative block w-full overflow-hidden rounded-xl border border-[#9E7B4F]/30 bg-[#E5DBC9] shadow-sm cursor-pointer kartu-3d {{ $kelasTile }}"
            >
                <img
                    src="{{ $galeri->urlFoto() }}"
                    alt="{{ $galeri->keterangan ?? 'Galeri' }}"
                    loading="lazy"
                    decoding="async"
                    class="block w-full h-full object-cover object-top group-hover:scale-105 transition duration-700"
                >
                @if ($galeri->keterangan)
                    <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#2B211A]/85 via-[#2B211A]/30 to-transparent px-3 py-2 text-left text-[10.5px] font-medium text-[#FAF6EE] opacity-0 group-hover:opacity-100 transition duration-300">
                        {{ $galeri->keterangan }}
                    </span>
                @endif
            </button>
        @endforeach
    </div>
</section>
@endif
