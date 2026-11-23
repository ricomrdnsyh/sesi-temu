{{-- SEKSI 3: PROFIL MEMPELAI (KARTU ARSITEKTUR KUBAH ZAMRUD-ALABASTER) --}}
<section
    data-layout-mempelai="mihrab"
    class="relative px-4 py-11 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-6">
        <div class="text-center space-y-1.5">
            <img src="{{ $asetSyari['arabesque'] }}" alt="" data-gsap="turun" class="w-10 mx-auto">
            <p data-gsap="mekar" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7D40]">Bismillahirrahmanirrahim</p>
            <h2 data-gsap="naik" class="font-serif text-3xl font-bold text-[#0E3A36]">Mempelai Pengantin</h2>
            <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs text-[#0E3A36]/75 max-w-xs mx-auto leading-relaxed">
                Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud menyelenggarakan akad &amp; walimatul ursy putra-putri kami:
            </p>
        </div>

        {{-- MEMPELAI PRIA --}}
        <article class="overflow-hidden rounded-3xl bg-white border border-[#C5A059]/50 shadow-[0_14px_34px_-16px_rgba(14,58,54,0.28)] kartu-3d">
            <div class="relative bg-gradient-to-r from-[#0E3A36] via-[#154E48] to-[#0E3A36] px-5 pt-4 pb-12 text-center">
                <span data-gsap="turun" class="inline-flex items-center gap-1.5 rounded-full border border-[#E6D19C]/45 bg-white/10 px-3 py-0.5 text-[9.5px] font-bold uppercase tracking-[0.26em] text-[#F3E5AB]">
                    Al-&lsquo;Aris &middot; Mempelai Pria
                </span>
            </div>

            <div class="relative px-5 pb-6 text-center">
                <div data-gsap="potret" class="-mt-10 mb-3 flex justify-center">
                    @if (! $tanpaFoto && $undangan->urlFotoPria())
                        <div class="p-1 rounded-t-full rounded-b-2xl bg-gradient-to-b from-[#E6D19C] to-[#B99348] shadow-md">
                            <img src="{{ $undangan->urlFotoPria() }}" alt="{{ $undangan->nama_lengkap_pria }}" class="w-28 h-32 rounded-t-full rounded-b-xl object-cover object-top bg-[#0E3A36]">
                        </div>
                    @else
                        <div class="relative h-20 w-20 flex items-center justify-center">
                            <span aria-hidden="true" class="absolute inset-1.5 bg-[#0E3A36] border-2 border-[#C5A059] shadow-md"></span>
                            <span aria-hidden="true" class="absolute inset-1.5 rotate-45 bg-[#0E3A36] border-2 border-[#C5A059] shadow-md"></span>
                            <span class="relative z-10 font-serif text-2xl font-bold text-[#F3E5AB]">{{ $undangan->inisialPria() }}</span>
                        </div>
                    @endif
                </div>

                <h3 data-gsap="kiri" class="font-serif text-3xl font-bold text-[#0E3A36] leading-tight">{{ $undangan->nama_panggilan_pria }}</h3>
                <p data-gsap="teks" data-gsap-delay="0.06" class="mt-1 text-xs sm:text-sm font-bold text-[#16524C]">{{ $undangan->nama_lengkap_pria }}</p>
                @if ($undangan->nama_ayah_pria || $undangan->nama_ibu_pria)
                    <p data-gsap="teks" data-gsap-delay="0.09" class="mt-1.5 text-xs text-[#0E3A36]/75 leading-relaxed">
                        Putra dari {{ $undangan->nama_ayah_pria }} &amp; {{ $undangan->nama_ibu_pria }}
                    </p>
                @endif
                @if ($instagramPria !== '')
                    <div data-gsap="mekar" data-gsap-delay="0.10" class="pt-3">
                        <a href="https://instagram.com/{{ $instagramPria }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 rounded-full border border-[#C5A059]/60 bg-[#F7FBF8] px-3.5 py-1 text-[11px] font-semibold text-[#0E3A36] hover:bg-[#0E3A36] hover:text-[#F3E5AB] transition">
                            &#64;{{ $instagramPria }}
                        </a>
                    </div>
                @endif
            </div>
        </article>

        {{-- Penghubung Bintang 8 Sudut --}}
        <div class="flex items-center justify-center gap-3">
            <span data-gsap="garis" class="h-px w-16 bg-gradient-to-r from-transparent to-[#C5A059]"></span>
            <div data-gsap="mekar" class="relative h-10 w-10 flex items-center justify-center">
                <span aria-hidden="true" class="absolute inset-1 border border-[#C5A059] bg-[#0E3A36]"></span>
                <span aria-hidden="true" class="absolute inset-1 rotate-45 border border-[#C5A059] bg-[#0E3A36]"></span>
                <span class="relative z-10 font-kaligrafi text-2xl text-[#F3E5AB] leading-none">&amp;</span>
            </div>
            <span data-gsap="garis" class="h-px w-16 bg-gradient-to-l from-transparent to-[#C5A059]"></span>
        </div>

        {{-- MEMPELAI WANITA --}}
        <article class="overflow-hidden rounded-3xl bg-white border border-[#C5A059]/50 shadow-[0_14px_34px_-16px_rgba(14,58,54,0.28)] kartu-3d">
            <div class="relative bg-gradient-to-r from-[#0E3A36] via-[#154E48] to-[#0E3A36] px-5 pt-4 pb-12 text-center">
                <span data-gsap="turun" class="inline-flex items-center gap-1.5 rounded-full border border-[#E6D19C]/45 bg-white/10 px-3 py-0.5 text-[9.5px] font-bold uppercase tracking-[0.26em] text-[#F3E5AB]">
                    Al-&lsquo;Arus &middot; Mempelai Wanita
                </span>
            </div>

            <div class="relative px-5 pb-6 text-center">
                <div data-gsap="potret" class="-mt-10 mb-3 flex justify-center">
                    @if (! $tanpaFoto && $undangan->urlFotoWanita())
                        <div class="p-1 rounded-t-full rounded-b-2xl bg-gradient-to-b from-[#E6D19C] to-[#B99348] shadow-md">
                            <img src="{{ $undangan->urlFotoWanita() }}" alt="{{ $undangan->nama_lengkap_wanita }}" class="w-28 h-32 rounded-t-full rounded-b-xl object-cover object-top bg-[#0E3A36]">
                        </div>
                    @else
                        <div class="relative h-20 w-20 flex items-center justify-center">
                            <span aria-hidden="true" class="absolute inset-1.5 bg-[#0E3A36] border-2 border-[#C5A059] shadow-md"></span>
                            <span aria-hidden="true" class="absolute inset-1.5 rotate-45 bg-[#0E3A36] border-2 border-[#C5A059] shadow-md"></span>
                            <span class="relative z-10 font-serif text-2xl font-bold text-[#F3E5AB]">{{ $undangan->inisialWanita() }}</span>
                        </div>
                    @endif
                </div>

                <h3 data-gsap="kanan" class="font-serif text-3xl font-bold text-[#0E3A36] leading-tight">{{ $undangan->nama_panggilan_wanita }}</h3>
                <p data-gsap="teks" data-gsap-delay="0.06" class="mt-1 text-xs sm:text-sm font-bold text-[#16524C]">{{ $undangan->nama_lengkap_wanita }}</p>
                @if ($undangan->nama_ayah_wanita || $undangan->nama_ibu_wanita)
                    <p data-gsap="teks" data-gsap-delay="0.09" class="mt-1.5 text-xs text-[#0E3A36]/75 leading-relaxed">
                        Putri dari {{ $undangan->nama_ayah_wanita }} &amp; {{ $undangan->nama_ibu_wanita }}
                    </p>
                @endif
                @if ($instagramWanita !== '')
                    <div data-gsap="mekar" data-gsap-delay="0.10" class="pt-3">
                        <a href="https://instagram.com/{{ $instagramWanita }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 rounded-full border border-[#C5A059]/60 bg-[#F7FBF8] px-3.5 py-1 text-[11px] font-semibold text-[#0E3A36] hover:bg-[#0E3A36] hover:text-[#F3E5AB] transition">
                            &#64;{{ $instagramWanita }}
                        </a>
                    </div>
                @endif
            </div>
        </article>
    </div>
</section>

{{-- SEKSI 4: HITUNG MUNDUR KUBAH MIHRAB (4 LENGKUNG ZAMRUD DI ATAS ALABASTER) --}}
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
    class="relative bg-[#EAF3ED] syari-pola-zellige border-y border-[#C5A059]/40 px-4 py-10 text-center overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-5">
        <div class="space-y-1">
            <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.36em] text-[#9E7D40]">Menuju Hari Bahagia</p>
            <h2 data-gsap="naik" class="font-serif text-3xl font-bold text-[#0E3A36]">Save The Date</h2>
        </div>

        {{-- 4 Ubin Mihrab Lengkung Zamrud-Emas --}}
        <div class="grid grid-cols-4 gap-2.5 pt-1">
            @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                <div data-gsap="mekar" data-gsap-delay="{{ number_format($loop->index * 0.07, 2, '.', '') }}" class="rounded-t-full rounded-b-xl bg-gradient-to-b from-[#154E48] via-[#0E3A36] to-[#0A2B28] border border-[#C5A059]/75 pt-5 pb-3.5 px-1 shadow-md">
                    <div class="font-serif text-2xl sm:text-[1.75rem] font-bold leading-none text-[#F3E5AB]" x-text="{{ $var }}">00</div>
                    <div class="mt-2 text-[9px] uppercase tracking-[0.2em] font-semibold text-[#F7FBF8]/80">{{ $label }}</div>
                </div>
            @endforeach
        </div>

        @if ($googleCalUrl)
            <div data-gsap="mekar" data-gsap-delay="0.08" class="pt-1">
                <a href="{{ $googleCalUrl }}" target="_blank" rel="noopener" class="syari-tombol inline-flex items-center gap-2 rounded-full border border-[#C5A059]/75 px-6 py-2.5 text-xs font-bold uppercase tracking-wider transition">
                    <svg class="w-4 h-4 text-[#F3E5AB]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
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

{{-- SEKSI 5: JADWAL AKAD & WALIMAH (KARTU KUBAH KEPALA + PITA 3-KOLOM) --}}
@if ($undangan->daftarAcara->isNotEmpty())
<section
    data-layout-acara="mihrab"
    class="relative px-4 py-11 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-5">
        <div class="text-center space-y-1">
            <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7D40]">InsyaAllah Dilaksanakan Pada</p>
            <h2 data-gsap="naik" class="font-serif text-3xl font-bold text-[#0E3A36]">Jadwal Akad &amp; Walimah</h2>
        </div>

        @foreach ($undangan->daftarAcara as $acara)
            <article class="overflow-hidden rounded-3xl bg-white border border-[#C5A059]/55 shadow-[0_14px_34px_-16px_rgba(14,58,54,0.28)] kartu-3d">
                {{-- Kepala Kubah Zamrud --}}
                <div class="bg-gradient-to-r from-[#0E3A36] via-[#16524C] to-[#0E3A36] px-5 py-4 text-center text-white space-y-1">
                    <svg data-gsap="turun" class="w-5 h-5 mx-auto text-[#F3E5AB]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 3c2 2.5 5 4.2 5 7.5V20H7v-9.5C7 7.2 10 5.5 12 3Z"/>
                        <path d="M4 20h16"/>
                    </svg>
                    <h3 data-gsap="mekar" class="font-serif text-xl sm:text-2xl font-bold text-[#F3E5AB] leading-snug">{{ $acara->nama_acara }}</h3>
                </div>

                {{-- Pita 3-Kolom Tanggal & Waktu --}}
                <div class="grid grid-cols-3 items-center divide-x divide-[#C5A059]/40 bg-[#F7FBF8] border-b border-[#C5A059]/35 py-3.5 px-2 text-center">
                    <div data-gsap="kiri">
                        <p class="text-[9.5px] font-bold uppercase tracking-widest text-[#9E7D40]">Hari</p>
                        <p class="mt-0.5 font-serif text-sm font-bold text-[#0E3A36]">{{ $acara->tanggal_acara->locale('id')->translatedFormat('l') }}</p>
                    </div>
                    <div data-gsap="mekar" data-gsap-delay="0.06">
                        <p class="font-serif text-3xl font-bold leading-none text-[#0E3A36]">{{ $acara->tanggal_acara->format('d') }}</p>
                        <p class="mt-0.5 text-[9.5px] font-bold uppercase tracking-wider text-[#9E7D40]">{{ $acara->tanggal_acara->locale('id')->translatedFormat('M Y') }}</p>
                    </div>
                    <div data-gsap="kanan">
                        <p class="text-[9.5px] font-bold uppercase tracking-widest text-[#9E7D40]">Pukul</p>
                        <p class="mt-0.5 font-serif text-sm font-bold text-[#0E3A36]">
                            {{ \Illuminate\Support\Str::substr($acara->waktu_mulai, 0, 5) }} {{ $acara->zona_waktu }}
                        </p>
                    </div>
                </div>

                {{-- Detail Lokasi --}}
                <div class="p-5 text-center space-y-2.5">
                    <div class="space-y-1">
                        <p data-gsap="naik" class="text-sm font-bold text-[#0E3A36]">{{ $acara->nama_tempat }}</p>
                        <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs text-[#0E3A36]/75 leading-relaxed">{{ $acara->alamat_lengkap }}</p>
                    </div>
                    @if ($acara->link_maps)
                        <div data-gsap="mekar" data-gsap-delay="0.08" class="pt-1">
                            <a href="{{ $acara->link_maps }}" target="_blank" rel="noopener" class="syari-tombol inline-flex items-center gap-2 rounded-full border border-[#C5A059]/65 px-5 py-2 text-[11px] font-bold uppercase tracking-wider transition">
                                <svg class="w-3.5 h-3.5 text-[#F3E5AB]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                                <span>Petunjuk Lokasi Maps</span>
                            </a>
                        </div>
                    @endif
                </div>
            </article>
        @endforeach
    </div>
</section>
@endif

{{-- SEKSI 6: ADAB BUSANA & LIVE STREAMING --}}
@if ($adaDressCode || (! empty($live['aktif']) && ! empty($live['link'])))
<section class="relative px-4 pb-6 space-y-4 overflow-hidden">
    @if ($adaDressCode)
        <div data-section-dress-code="mihrab" class="max-w-md mx-auto rounded-3xl bg-white border border-[#C5A059]/45 p-5 text-center shadow-sm space-y-3.5">
            <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7D40]">Nuansa Busana Syar&rsquo;i</p>
            @if ($dressCodeCatatan !== '')
                <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs text-[#0E3A36]/80 leading-relaxed">{{ $dressCodeCatatan }}</p>
            @endif
            @if (! empty($dressCodeWarna))
                <div class="flex flex-wrap items-center justify-center gap-4 pt-1">
                    @foreach ($dressCodeWarna as $hex)
                        <div data-gsap="mekar" data-gsap-delay="{{ number_format($loop->index * 0.06, 2, '.', '') }}" class="flex flex-col items-center gap-2">
                            <span class="h-7 w-7 rotate-45 border-2 border-[#C5A059] shadow-xs" style="background-color: {{ $hex }};"></span>
                            <span class="text-[9px] font-mono text-[#0E3A36]/70">{{ $hex }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    @if (! empty($live['aktif']) && ! empty($live['link']))
        <div class="max-w-md mx-auto rounded-3xl bg-gradient-to-br from-[#0E3A36] to-[#16524C] border border-[#C5A059]/60 p-5 text-center text-[#F7FBF8] shadow-md space-y-3">
            <span data-gsap="turun" class="inline-flex items-center gap-1.5 rounded-full bg-white/10 border border-[#E6D19C]/40 px-3 py-0.5 text-[9.5px] font-bold uppercase tracking-[0.28em] text-[#F3E5AB]">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-300 animate-pulse"></span>
                Siaran Langsung
            </span>
            <h3 data-gsap="naik" class="font-serif text-xl font-bold text-white">Live Streaming Akad</h3>
            <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs text-[#F7FBF8]/80 leading-relaxed">
                Saksikan prosesi akad secara daring melalui {{ $live['platform'] ?? 'YouTube Live' }}.
            </p>
            <div data-gsap="mekar" data-gsap-delay="0.08">
                <a href="{{ $live['link'] }}" target="_blank" rel="noopener" class="syari-tombol-emas inline-flex items-center gap-2 rounded-full px-6 py-2 text-xs font-bold uppercase tracking-wider transition">
                    <span>Gabung Siaran</span>
                </a>
            </div>
        </div>
    @endif
</section>
@endif

{{-- SEKSI 7: PERJALANAN TA'ARUF (LINIMASA VERTIKAL EMAS) --}}
@if ($undangan->fiturAktif('cerita_cinta') && ! empty($ceritaList))
<section
    data-layout-cerita="mihrab"
    class="relative px-4 py-10 overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-6 overflow-hidden">
        <div data-gsap="kiri">
            <p class="scroll-scrub-kiri text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7D40]">Perjalanan Ta&rsquo;aruf</p>
        </div>
        <div data-gsap="kanan" data-gsap-delay="0.06">
            <h2 class="scroll-scrub-kanan mt-1 font-serif text-3xl font-bold text-[#0E3A36]">Kisah Pertemuan</h2>
        </div>
    </div>

    <div class="max-w-md mx-auto relative pl-6 space-y-5">
        {{-- Garis Rel Emas Vertikal --}}
        <span aria-hidden="true" class="pointer-events-none absolute top-2 bottom-2 left-2.5 w-0.5 bg-gradient-to-b from-[#C5A059] via-[#0E3A36]/35 to-[#C5A059]/40"></span>

        @foreach ($ceritaList as $cerita)
            @php
                $urlFotoBab = (! $tanpaFoto && ! empty($cerita['foto']))
                    ? \App\Support\MediaPublik::url((string) $cerita['foto'])
                    : null;
            @endphp
            <article class="relative rounded-2xl bg-white border border-[#C5A059]/45 p-4 sm:p-5 shadow-sm kartu-3d">
                {{-- Simpul Berlian Emas di Rel Linimasa --}}
                <span aria-hidden="true" class="pointer-events-none absolute top-5 -left-[22px] h-3.5 w-3.5 rotate-45 border-2 border-[#F7FBF8] bg-[#C5A059] shadow-xs"></span>

                @if ($urlFotoBab)
                    <div data-gsap="potret" class="mb-3 overflow-hidden rounded-xl border border-[#C5A059]/35">
                        <img src="{{ $urlFotoBab }}" alt="{{ $cerita['judul'] ?? 'Kisah Pertemuan' }}" class="w-full aspect-[16/10] object-cover object-center">
                    </div>
                @endif
                <div class="flex items-center justify-between gap-2">
                    <h3 data-gsap="kiri" class="font-serif text-lg font-bold text-[#0E3A36]">{{ $cerita['judul'] ?? '' }}</h3>
                    @if (! empty($cerita['tanggal']))
                        <span data-gsap="kanan" class="shrink-0 rounded-full bg-[#0E3A36] px-2.5 py-0.5 text-[10px] font-semibold text-[#F3E5AB]">{{ $cerita['tanggal'] }}</span>
                    @endif
                </div>
                <p data-gsap="teks" data-gsap-delay="0.06" class="mt-2 text-xs sm:text-sm text-[#0E3A36]/80 leading-relaxed">{{ $cerita['cerita'] ?? '' }}</p>
            </article>
        @endforeach
    </div>
</section>
@endif

{{-- SEKSI 8: GALERI MOZAIK KUBAH ALHAMBRA (TERSEMBUNYI SAAT MODE TANPA FOTO) --}}
@if (! $tanpaFoto && $undangan->fiturAktif('galeri') && $undangan->daftarGaleri->isNotEmpty())
<section
    data-layout-galeri="mihrab"
    class="relative bg-[#EAF3ED]/75 border-y border-[#C5A059]/35 px-4 py-11 overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-6 overflow-hidden">
        <div data-gsap="kanan">
            <p class="scroll-scrub-kanan text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7D40]">Galeri Kenangan</p>
        </div>
        <div data-gsap="kiri" data-gsap-delay="0.06">
            <h2 class="scroll-scrub-kiri mt-1 font-serif text-3xl font-bold text-[#0E3A36]">Momen Terindah</h2>
        </div>
    </div>

    <div class="max-w-md mx-auto grid grid-cols-12 items-stretch gap-3">
        @foreach ($undangan->daftarGaleri as $galeri)
            @php
                $kelasTile = \App\Support\DataTemaUndangan::kelasGridGaleri($loop->index, $loop->count, 'mihrab');
            @endphp
            <button
                type="button"
                @click="bukaGaleri(@js($galeri->urlFoto()), @js($galeri->keterangan))"
                data-gsap="potret"
                data-gsap-delay="{{ number_format(($loop->index % 3) * 0.06, 2, '.', '') }}"
                class="group relative overflow-hidden border border-[#C5A059]/60 bg-white p-1 shadow-sm cursor-pointer kartu-3d {{ $kelasTile }}"
            >
                <div class="relative w-full h-full overflow-hidden rounded-[inherit]">
                    <img
                        src="{{ $galeri->urlFoto() }}"
                        alt="{{ $galeri->keterangan ?? 'Galeri' }}"
                        class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-700"
                    >
                    @if ($galeri->keterangan)
                        <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#08221F]/85 via-[#08221F]/35 to-transparent px-3 py-2 text-left text-[10.5px] font-medium text-[#F3E5AB] opacity-0 group-hover:opacity-100 transition duration-300">
                            {{ $galeri->keterangan }}
                        </span>
                    @endif
                </div>
            </button>
        @endforeach
    </div>
</section>
@endif
