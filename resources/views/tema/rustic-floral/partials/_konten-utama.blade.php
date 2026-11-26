{{-- SEKSI 3: KARTU PAVILIUN BOTANI MEMPELAI (BINGKAI BUNGA CAT AIR + PAMPAS & MAWAR TERAKOTA) --}}
<section
    data-layout-mempelai="klasik"
    class="relative px-4 py-12 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-7">
        <div class="text-center space-y-2">
            <div data-gsap="turun">
                <img src="{{ $asetRustic['garland'] }}" alt="" loading="lazy" decoding="async" class="w-36 mx-auto drop-shadow-xs animasi-melayang">
            </div>
            <p data-gsap="mekar" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#B86B4B]">The Couple</p>
            <h2 data-gsap="naik" class="font-serif text-3xl font-bold text-[#1F2937]">{{ $undangan->teksKustom('judul_mempelai', 'Mempelai Berbahagia') }}</h2>
            <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs text-[#4B6358]/85 max-w-xs mx-auto leading-relaxed">
                {{ $undangan->teksKustom('pengantar_mempelai', 'Dengan memohon rahmat dan ridho Tuhan Yang Maha Esa, kami bermaksud menyelenggarakan pernikahan putra-putri kami:') }}
            </p>
        </div>

        {{-- MEMPELAI PRIA (BINGKAI KARANGAN BUNGA CAT AIR 780x960) --}}
        <article class="group relative rounded-[2rem] bg-[#FDFBF7] border-2 border-[#BFA15F]/55 shadow-[0_22px_50px_-16px_rgba(47,64,55,0.26)] overflow-hidden kartu-3d">
            {{-- Panggung Atas Potret + Bingkai Bunga Pampas & Mawar Terakota --}}
            <div class="relative bg-gradient-to-b from-[#F5EFE2] via-[#FAF6ED] to-[#FDFBF7] px-5 pt-7 pb-4 overflow-hidden">
                <img
                    src="{{ $asetRustic['latar'] }}"
                    alt=""
                    aria-hidden="true"
                    loading="lazy"
                    decoding="async"
                    class="pointer-events-none absolute inset-0 w-full h-full object-cover object-center opacity-[0.13]"
                >

                <div data-gsap="potret" class="relative z-10 mx-auto w-[248px] sm:w-[266px] aspect-[780/960] flex items-center justify-center">
                    <div class="absolute inset-x-[12.5%] top-[8.5%] bottom-[11.5%] rounded-t-[10rem] rounded-b-[1.35rem] overflow-hidden bg-[#2F4037] shadow-[0_14px_30px_rgba(35,51,43,0.28)]">
                        @if (! $tanpaFoto && $undangan->urlFotoPria())
                            <img
                                src="{{ $undangan->urlFotoPria() }}"
                                alt="{{ $undangan->nama_lengkap_pria }}"
                                loading="lazy"
                                decoding="async"
                                class="w-full h-full object-cover object-top scale-[1.03] group-hover:scale-[1.07] transition duration-700"
                            >
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center gap-1 bg-gradient-to-b from-[#4B6358] via-[#3A4E45] to-[#26352E] text-[#FDFBF7]">
                                <span class="text-[9px] uppercase tracking-[0.28em] text-[#E5D5C0]">The Groom</span>
                                <span class="font-serif text-6xl font-bold leading-none">{{ $undangan->inisialPria() }}</span>
                            </div>
                        @endif
                    </div>

                    <img
                        src="{{ $asetRustic['bingkaiMempelai'] }}"
                        alt=""
                        aria-hidden="true"
                        loading="lazy"
                        decoding="async"
                        class="pointer-events-none relative z-10 w-full h-full object-contain drop-shadow-[0_10px_22px_rgba(47,64,55,0.2)]"
                    >
                </div>
            </div>

            {{-- Biografi Mempelai Pria --}}
            <div class="relative z-10 px-6 pb-7 pt-1 text-center space-y-2.5">
                <div data-gsap="turun">
                    <span class="inline-block rounded-full bg-[#B86B4B]/12 border border-[#B86B4B]/30 px-4 py-0.5 text-[10px] font-bold uppercase tracking-widest text-[#B86B4B]">Mempelai Pria</span>
                </div>
                <h3 data-gsap="kiri" class="font-kaligrafi text-5xl text-[#4B6358] leading-tight">{{ $undangan->nama_panggilan_pria }}</h3>
                <p data-gsap="teks" data-gsap-delay="0.06" class="font-serif text-base font-bold text-[#1F2937]">{{ $undangan->nama_lengkap_pria }}</p>
                @if ($undangan->nama_ayah_pria || $undangan->nama_ibu_pria)
                    <p data-gsap="teks" data-gsap-delay="0.09" class="text-xs text-[#1F2937]/75 leading-relaxed">{{ $undangan->teksKustom('label_pria', 'Putra dari') }} {{ $undangan->nama_ayah_pria }} &amp; {{ $undangan->nama_ibu_pria }}</p>
                @endif
                @if ($instagramPria !== '')
                    <div data-gsap="mekar" data-gsap-delay="0.10" class="pt-1.5">
                        <a
                            href="https://instagram.com/{{ $instagramPria }}"
                            target="_blank"
                            rel="noopener"
                            class="group/ig inline-flex items-center gap-1.5 rounded-full bg-[#4B6358]/10 border border-[#4B6358]/25 px-4 py-1.5 text-[11px] font-semibold text-[#4B6358] hover:bg-[#4B6358] hover:text-[#FDFBF7] transition active:scale-95"
                        >
                            <svg class="w-3.5 h-3.5 text-[#B86B4B] group-hover/ig:text-[#F3E5AB] transition-colors shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
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

        <div class="flex items-center justify-center gap-4 text-[#B86B4B]">
            <span data-gsap="garis" class="h-px w-14 bg-[#BFA15F]/55"></span>
            <span data-gsap="mekar" class="font-kaligrafi text-4xl text-[#4B6358]">&amp;</span>
            <span data-gsap="garis" class="h-px w-14 bg-[#BFA15F]/55"></span>
        </div>

        {{-- MEMPELAI WANITA (BINGKAI KARANGAN BUNGA CAT AIR 780x960) --}}
        <article class="group relative rounded-[2rem] bg-[#FDFBF7] border-2 border-[#BFA15F]/55 shadow-[0_22px_50px_-16px_rgba(47,64,55,0.26)] overflow-hidden kartu-3d">
            {{-- Panggung Atas Potret + Bingkai Bunga Pampas & Mawar Terakota --}}
            <div class="relative bg-gradient-to-b from-[#F5EFE2] via-[#FAF6ED] to-[#FDFBF7] px-5 pt-7 pb-4 overflow-hidden">
                <img
                    src="{{ $asetRustic['latar'] }}"
                    alt=""
                    aria-hidden="true"
                    loading="lazy"
                    decoding="async"
                    class="pointer-events-none absolute inset-0 w-full h-full object-cover object-center opacity-[0.13] -scale-x-100"
                >

                <div data-gsap="potret" class="relative z-10 mx-auto w-[248px] sm:w-[266px] aspect-[780/960] flex items-center justify-center">
                    <div class="absolute inset-x-[12.5%] top-[8.5%] bottom-[11.5%] rounded-t-[10rem] rounded-b-[1.35rem] overflow-hidden bg-[#2F4037] shadow-[0_14px_30px_rgba(35,51,43,0.28)]">
                        @if (! $tanpaFoto && $undangan->urlFotoWanita())
                            <img
                                src="{{ $undangan->urlFotoWanita() }}"
                                alt="{{ $undangan->nama_lengkap_wanita }}"
                                loading="lazy"
                                decoding="async"
                                class="w-full h-full object-cover object-top scale-[1.03] group-hover:scale-[1.07] transition duration-700"
                            >
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center gap-1 bg-gradient-to-b from-[#B86B4B] via-[#9E573B] to-[#7C4029] text-[#FDFBF7]">
                                <span class="text-[9px] uppercase tracking-[0.28em] text-[#F5E4CF]">The Bride</span>
                                <span class="font-serif text-6xl font-bold leading-none">{{ $undangan->inisialWanita() }}</span>
                            </div>
                        @endif
                    </div>

                    <img
                        src="{{ $asetRustic['bingkaiMempelai'] }}"
                        alt=""
                        aria-hidden="true"
                        loading="lazy"
                        decoding="async"
                        class="pointer-events-none relative z-10 w-full h-full object-contain -scale-x-100 drop-shadow-[0_10px_22px_rgba(47,64,55,0.2)]"
                    >
                </div>
            </div>

            {{-- Biografi Mempelai Wanita --}}
            <div class="relative z-10 px-6 pb-7 pt-1 text-center space-y-2.5">
                <div data-gsap="turun">
                    <span class="inline-block rounded-full bg-[#4B6358]/12 border border-[#4B6358]/30 px-4 py-0.5 text-[10px] font-bold uppercase tracking-widest text-[#4B6358]">Mempelai Wanita</span>
                </div>
                <h3 data-gsap="kanan" class="font-kaligrafi text-5xl text-[#4B6358] leading-tight">{{ $undangan->nama_panggilan_wanita }}</h3>
                <p data-gsap="teks" data-gsap-delay="0.06" class="font-serif text-base font-bold text-[#1F2937]">{{ $undangan->nama_lengkap_wanita }}</p>
                @if ($undangan->nama_ayah_wanita || $undangan->nama_ibu_wanita)
                    <p data-gsap="teks" data-gsap-delay="0.09" class="text-xs text-[#1F2937]/75 leading-relaxed">{{ $undangan->teksKustom('label_wanita', 'Putri dari') }} {{ $undangan->nama_ayah_wanita }} &amp; {{ $undangan->nama_ibu_wanita }}</p>
                @endif
                @if ($instagramWanita !== '')
                    <div data-gsap="mekar" data-gsap-delay="0.10" class="pt-1.5">
                        <a
                            href="https://instagram.com/{{ $instagramWanita }}"
                            target="_blank"
                            rel="noopener"
                            class="group/ig inline-flex items-center gap-1.5 rounded-full bg-[#4B6358]/10 border border-[#4B6358]/25 px-4 py-1.5 text-[11px] font-semibold text-[#4B6358] hover:bg-[#4B6358] hover:text-[#FDFBF7] transition active:scale-95"
                        >
                            <svg class="w-3.5 h-3.5 text-[#B86B4B] group-hover/ig:text-[#F3E5AB] transition-colors shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
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

{{-- SEKSI 4A: SLIDESHOW BOTANICAL GARDEN TRANSISI KE COUNTDOWN (TERSEMBUNYI SAAT MODE TANPA FOTO) --}}
@if ($fotoGaleriSlideshow->isNotEmpty())
<div
    data-slideshow-rustic
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
    class="relative h-72 sm:h-80 w-full overflow-hidden bg-[#2F4037]"
>
    @foreach ($fotoGaleriSlideshow as $idxSlide => $urlSlide)
        <img
            src="{{ $urlSlide }}"
            alt="Potret Taman {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
            loading="lazy"
            decoding="async"
            class="absolute inset-0 w-full h-full object-cover object-top transition-opacity duration-1000"
            :class="slideAktif === {{ $idxSlide }} ? 'opacity-92 scale-105' : 'opacity-0 scale-100'"
            style="transition: opacity 1.15s ease, transform 5.2s ease;"
        >
    @endforeach

    {{-- Gradasi Halus Menyatu Ke Seksi Hitung Mundur Forest-Sage --}}
    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-0"
        style="background: linear-gradient(180deg, rgba(253,251,247,0.34) 0%, rgba(47,64,55,0.06) 28%, rgba(57,77,68,0.28) 62%, #4B6358 100%);"
    ></div>

    {{-- Bingkai Lengkung Tipis Fine-Art Sampanye --}}
    <div aria-hidden="true" class="pointer-events-none absolute inset-x-4 top-4 bottom-0 rounded-t-[9rem] border-x border-t border-[#E5D5C0]/45 z-10"></div>
</div>
@endif

{{-- SEKSI 4B: HITUNG MUNDUR STEMPEL SAGE --}}
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
    class="relative bg-gradient-to-b from-[#4B6358] via-[#3A4E45] to-[#2C3C34] shadow-[0_-2px_0_0_#4B6358] text-white px-5 {{ $fotoGaleriSlideshow->isNotEmpty() ? 'pt-7 pb-12' : 'py-12' }} text-center overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-5">
        <div class="space-y-1">
            <img src="{{ $asetRustic['garland'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async" data-gsap="turun" class="w-32 mx-auto pb-1 drop-shadow">
            <p data-gsap="turun" class="text-[10px] font-semibold uppercase tracking-[0.34em] text-[#E5D5C0]">Menuju Hari Bahagia</p>
            <h2 data-gsap="naik" class="font-serif text-3xl font-bold text-white">{{ $undangan->teksKustom('judul_hitung_mundur', 'Save The Date') }}</h2>
            <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs text-[#E5D5C0]/90">{{ $tanggalLengkap }}</p>
        </div>

        <div class="grid grid-cols-4 gap-2.5 pt-1">
            @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                <div data-gsap="mekar" data-gsap-delay="{{ number_format($loop->index * 0.07, 2, '.', '') }}" class="rounded-2xl bg-[#FDFBF7] border border-[#E5D5C0]/65 text-[#1F2937] py-3.5 px-1 shadow-md">
                    <div
                        class="font-serif text-2xl sm:text-3xl font-bold leading-none text-[#4B6358] tabular-nums"
                        x-text="{{ $var }}"
                        x-effect="if ({{ $var }}) { $el.classList.remove('angka-flip-3d'); void $el.offsetWidth; $el.classList.add('angka-flip-3d'); }"
                    >00</div>
                    <div class="mt-1.5 text-[9px] uppercase tracking-wider font-bold text-[#B86B4B]">{{ $label }}</div>
                </div>
            @endforeach
        </div>

        @if ($googleCalUrl)
            <div data-gsap="mekar" data-gsap-delay="0.1" class="pt-2">
                <a href="{{ $googleCalUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full bg-[#FDFBF7] border border-[#E5D5C0]/80 px-6 py-2.5 text-xs font-bold uppercase tracking-wider text-[#2F4037] shadow-md hover:bg-white transition">
                    <svg class="w-3.5 h-3.5 text-[#B86B4B]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect width="18" height="18" x="3" y="4" rx="2"/>
                        <line x1="16" x2="16" y1="2" y2="6"/>
                        <line x1="8" x2="8" y1="2" y2="6"/>
                        <line x1="3" x2="21" y1="10" y2="10"/>
                    </svg>
                    <span>Simpan ke Kalender</span>
                </a>
            </div>
        @endif
    </div>
</section>
@endif

{{-- SEKSI 5: PAVILIUN LENGKUNG TAMAN & MEDALI TANGGAL RANGKAIAN ACARA --}}
@if ($undangan->fiturAktif('acara') && $undangan->daftarAcara->isNotEmpty())
<section
    data-layout-acara="klasik"
    data-acara-paviliun-rustic
    class="relative bg-gradient-to-b from-[#FAF5EC] via-[#F7F1E7] to-[#F4ECE1] px-4 py-14 overflow-hidden"
>
    <div class="max-w-md mx-auto">
        <div class="text-center space-y-1.5 mb-8">
            <img src="{{ $asetRustic['garland'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async" data-gsap="turun" class="w-36 mx-auto pb-1 drop-shadow-xs">
            <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#B86B4B]">Jadwal &amp; Lokasi</p>
            <h2 data-gsap="naik" class="font-serif text-3xl font-bold text-[#1F2937]">{{ $undangan->teksKustom('judul_acara', 'Rangkaian Acara') }}</h2>
            <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs text-[#4B6358]/85 max-w-xs mx-auto leading-relaxed">
                {{ $undangan->teksKustom('pengantar_hitung_mundur', 'Dengan penuh suka cita, kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri momen bahagia kami:') }}
            </p>
        </div>

        <div class="space-y-0">
            @foreach ($undangan->daftarAcara as $acara)
                @php
                    $adalahGenap = $loop->even;
                    $nomorAcara = str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT);
                @endphp

                <article class="relative rounded-t-[8.5rem] rounded-b-[1.75rem] bg-[#FDFBF7] border border-[#BFA15F]/60 shadow-[0_22px_50px_-18px_rgba(47,64,55,0.26)] overflow-hidden kartu-3d">
                    {{-- Kubah Lengkung Paviliun Taman (Bergantian Hijau Sage & Terakota Hangat) --}}
                    <div class="relative px-6 pt-11 pb-13 text-center text-[#FDFBF7] overflow-hidden {{ $adalahGenap ? 'bg-gradient-to-b from-[#8F5239] via-[#A15E43] to-[#74402C]' : 'bg-gradient-to-b from-[#34483E] via-[#465E53] to-[#2C3D34]' }}">
                        <img
                            src="{{ $asetRustic['latar'] }}"
                            alt=""
                            aria-hidden="true"
                            loading="lazy"
                            decoding="async"
                            class="pointer-events-none absolute inset-0 w-full h-full object-cover object-center opacity-[0.16] mix-blend-luminosity"
                        >
                        <div
                            aria-hidden="true"
                            class="pointer-events-none absolute inset-2.5 bottom-0 rounded-t-[7.8rem] border-x border-t border-[#F3E5AB]/40"
                        ></div>

                        {{-- Puncak Ornamen Berlian Botani --}}
                        <div aria-hidden="true" class="pointer-events-none absolute top-5 left-1/2 -translate-x-1/2 flex items-center gap-2">
                            <span class="h-px w-6 bg-gradient-to-r from-transparent to-[#F3E5AB]/75"></span>
                            <span class="w-1.5 h-1.5 rotate-45 bg-[#F3E5AB]"></span>
                            <span class="h-px w-6 bg-gradient-to-l from-transparent to-[#F3E5AB]/75"></span>
                        </div>

                        <div class="relative z-10 space-y-1">
                            <p data-gsap="turun" class="text-[9.5px] font-bold uppercase tracking-[0.3em] text-[#F3E5AB]">
                                Acara {{ $nomorAcara }} &bull; {{ $acara->tanggal_acara->locale('id')->translatedFormat('l') }}
                            </p>
                            <h3 data-gsap="mekar" data-gsap-delay="0.06" class="font-kaligrafi text-[2.65rem] sm:text-[2.85rem] leading-[1.06] text-[#FDFBF7] drop-shadow-xs">
                                {{ $acara->nama_acara }}
                            </h3>
                        </div>
                    </div>

                    {{-- Medali Segel Tanggal Botani Melayang Di Pertemuan Kubah & Kartu Linen --}}
                    <div class="relative z-20 -mt-10 flex items-center justify-center px-6">
                        <span aria-hidden="true" class="h-px flex-1 bg-gradient-to-r from-transparent via-[#BFA15F]/55 to-[#BFA15F]"></span>
                        <div
                            data-gsap="mekar"
                            data-gsap-delay="0.08"
                            class="mx-3 w-[82px] h-[82px] shrink-0 rounded-full bg-[#FDFBF7] border-2 border-[#BFA15F] ring-4 ring-[#FDFBF7] shadow-[0_12px_26px_-8px_rgba(47,64,55,0.32)] flex flex-col items-center justify-center text-center"
                        >
                            <span class="font-serif text-[1.9rem] font-bold leading-none {{ $adalahGenap ? 'text-[#8F5239]' : 'text-[#2F4037]' }}">
                                {{ $acara->tanggal_acara->format('d') }}
                            </span>
                            <span class="mt-0.5 text-[8.5px] font-bold uppercase tracking-[0.16em] text-[#B86B4B]">
                                {{ $acara->tanggal_acara->locale('id')->translatedFormat('M Y') }}
                            </span>
                        </div>
                        <span aria-hidden="true" class="h-px flex-1 bg-gradient-to-l from-transparent via-[#BFA15F]/55 to-[#BFA15F]"></span>
                    </div>

                    {{-- Panel Isi Kartu Linen Hangat --}}
                    <div class="relative px-6 pt-5 pb-7 text-center space-y-4 overflow-hidden">
                        <img src="{{ $asetRustic['sudut'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async" class="pointer-events-none absolute -bottom-7 -left-7 w-24 opacity-[0.14]">
                        <img src="{{ $asetRustic['sudut'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async" class="pointer-events-none absolute -bottom-7 -right-7 w-24 opacity-[0.14] -scale-x-100">

                        {{-- Kapsul Waktu --}}
                        <div data-gsap="teks" class="relative z-10 inline-flex items-center gap-2 rounded-full bg-[#F5EFE4] border border-[#BFA15F]/45 px-4 py-1.5 text-xs font-semibold text-[#35493F]">
                            <svg class="w-3.5 h-3.5 text-[#B86B4B] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                            <span>
                                Pukul {{ \Illuminate\Support\Str::substr($acara->waktu_mulai, 0, 5) }}
                                @if ($acara->waktu_selesai) - {{ \Illuminate\Support\Str::substr($acara->waktu_selesai, 0, 5) }} @else - Selesai @endif
                                {{ $acara->zona_waktu }}
                            </span>
                        </div>

                        {{-- Detail Tempat & Alamat --}}
                        <div class="relative z-10 space-y-1.5 pt-0.5">
                            <div class="mx-auto w-8 h-8 rounded-full {{ $adalahGenap ? 'bg-[#B86B4B]/12 border-[#B86B4B]/30 text-[#B86B4B]' : 'bg-[#4B6358]/10 border-[#4B6358]/25 text-[#4B6358]' }} border flex items-center justify-center" aria-hidden="true">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                            </div>
                            <p data-gsap="naik" data-gsap-delay="0.05" class="font-serif text-lg font-bold text-[#1F2937] leading-snug">
                                {{ $acara->nama_tempat }}
                            </p>
                            <p data-gsap="teks" data-gsap-delay="0.08" class="text-xs text-[#4B6358]/85 leading-relaxed max-w-[270px] mx-auto">
                                {{ $acara->alamat_lengkap }}
                            </p>
                        </div>

                        @if ($acara->link_maps)
                            <div data-gsap="mekar" data-gsap-delay="0.08" class="relative z-10 pt-1">
                                <a
                                    href="{{ $acara->link_maps }}"
                                    target="_blank"
                                    rel="noopener"
                                    class="{{ $adalahGenap ? 'bg-gradient-to-r from-[#9C573C] to-[#7D432C] text-[#FDFBF7] shadow-[0_10px_20px_-10px_rgba(156,87,60,0.55)] hover:brightness-105' : 'rustic-tombol-sage' }} inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-xs font-bold uppercase tracking-wider transition active:scale-95"
                                >
                                    <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                                        <circle cx="12" cy="10" r="3"/>
                                    </svg>
                                    <span>Buka Google Maps</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </article>

                {{-- Tangkai Penghubung Botani Antar Prosesi --}}
                @if (! $loop->last)
                    <div aria-hidden="true" class="flex flex-col items-center py-2">
                        <span class="h-5 w-px border-l border-dashed border-[#BFA15F]/80"></span>
                        <span class="my-1 flex h-6 w-6 items-center justify-center rounded-full bg-[#FDFBF7] border border-[#BFA15F]/65 shadow-xs">
                            <span class="h-1.5 w-1.5 rotate-45 bg-[#B86B4B]"></span>
                        </span>
                        <span class="h-5 w-px border-l border-dashed border-[#BFA15F]/80"></span>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- SEKSI 6: DRESS CODE & LIVE STREAMING --}}
@if ($adaDressCode || (! empty($live['aktif']) && ! empty($live['link'])))
<section class="relative bg-[#F4ECE1] px-4 py-9 space-y-4 overflow-hidden">
    @if ($adaDressCode)
        <div data-section-dress-code="klasik" class="max-w-md mx-auto rounded-3xl bg-white border border-[#BFA15F]/45 p-6 text-center shadow-md space-y-3">
            <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#B86B4B]">Panduan Busana</p>
            <h3 data-gsap="naik" class="font-serif text-xl font-bold text-[#1F2937]">Dress Code</h3>
            @if ($dressCodeCatatan !== '')
                <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs text-[#1F2937]/80 leading-relaxed">{{ $dressCodeCatatan }}</p>
            @endif
            @if (! empty($dressCodeWarna))
                <div class="flex flex-wrap items-center justify-center gap-3.5 pt-1">
                    @foreach ($dressCodeWarna as $hex)
                        <div data-gsap="mekar" data-gsap-delay="{{ number_format($loop->index * 0.06, 2, '.', '') }}" class="flex flex-col items-center gap-1">
                            <span class="h-8 w-8 rounded-full border-2 border-[#BFA15F]/65 shadow-xs" style="background-color: {{ $hex }};"></span>
                            <span class="text-[9px] font-mono text-[#1F2937]/70">{{ $hex }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    @if (! empty($live['aktif']) && ! empty($live['link']))
        <div class="max-w-md mx-auto rounded-3xl bg-white border border-[#BFA15F]/45 p-6 text-center shadow-md space-y-3">
            <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#B86B4B]">Siaran Langsung</p>
            <h3 data-gsap="naik" class="font-serif text-xl font-bold text-[#1F2937]">Live Streaming</h3>
            <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs text-[#1F2937]/75 leading-relaxed">
                Ikuti prosesi kebahagiaan kami secara virtual melalui {{ $live['platform'] ?? 'YouTube Live' }}.
            </p>
            <div data-gsap="mekar" data-gsap-delay="0.08">
                <a href="{{ $live['link'] }}" target="_blank" rel="noopener" class="rustic-tombol-sage inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-xs font-bold uppercase tracking-wider transition">
                    <span>Tonton Live Streaming</span>
                </a>
            </div>
        </div>
    @endif
</section>
@endif

{{-- SEKSI 7: JURNAL HERBARIUM CERITA CINTA INTERAKTIF (BUKU KISAH BERHALAMAN) --}}
@if ($undangan->fiturAktif('cerita_cinta') && ! empty($ceritaList))
@php
    $jumlahBabCerita = count($ceritaList);
@endphp
<section
    data-layout-cerita="klasik"
    data-cerita-herbarium-rustic
    x-data="{
        babAktif: 0,
        totalBab: {{ $jumlahBabCerita }},
        sebelumnya() { this.babAktif = (this.babAktif - 1 + this.totalBab) % this.totalBab; },
        berikutnya() { this.babAktif = (this.babAktif + 1) % this.totalBab; }
    }"
    class="relative bg-gradient-to-b from-[#2F4138] via-[#283830] to-[#223029] text-[#FDFBF7] px-4 py-14 overflow-hidden"
>
    {{-- Pendar Cahaya Hangat Latar Herbarium --}}
    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-0"
        style="background: radial-gradient(ellipse 80% 56% at 50% 42%, rgba(229,213,192,0.12) 0%, transparent 72%);"
    ></div>

    <div class="relative z-10 max-w-md mx-auto">
        {{-- Tajuk Seksi --}}
        <div data-scroll-scrub class="text-center mb-7 space-y-1.5 overflow-hidden">
            <img src="{{ $asetRustic['garland'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async" data-gsap="turun" class="w-36 mx-auto pb-0.5 drop-shadow">
            <div data-gsap="kiri">
                <p class="scroll-scrub-kiri text-[10px] font-bold uppercase tracking-[0.36em] text-[#E5D5C0]">Kisah Kami</p>
            </div>
            <div data-gsap="kanan" data-gsap-delay="0.06">
                <h2 class="scroll-scrub-kanan font-kaligrafi text-5xl text-[#FDFBF7] leading-tight">{{ $undangan->teksKustom('judul_cerita', 'Cerita Cinta') }}</h2>
            </div>
            <p data-gsap="teks" data-gsap-delay="0.09" class="text-xs text-[#E5D5C0]/82 max-w-xs mx-auto leading-relaxed">
                Lembaran perjalanan singkat yang merangkai pertemuan kami hingga melangkah ke pelaminan.
            </p>
        </div>

        {{-- Pemilih Bab Linimasa Botani Interaktif --}}
        @if ($jumlahBabCerita > 1)
            <div data-gsap="mekar" class="relative mb-7 px-2">
                <span aria-hidden="true" class="pointer-events-none absolute left-8 right-8 top-4 h-px bg-gradient-to-r from-[#E5D5C0]/20 via-[#E5D5C0]/55 to-[#E5D5C0]/20"></span>
                <div class="relative z-10 flex items-start justify-between gap-2">
                    @foreach ($ceritaList as $idx => $cerita)
                        <button
                            type="button"
                            @click="babAktif = {{ $idx }}"
                            class="group flex-1 flex flex-col items-center gap-1.5 cursor-pointer focus:outline-none"
                        >
                            <span
                                class="flex h-8 w-8 items-center justify-center rounded-full border text-[11px] font-serif font-bold transition-all duration-300"
                                :class="babAktif === {{ $idx }}
                                    ? 'bg-[#B86B4B] border-[#F3E5AB] text-[#FDFBF7] scale-110 shadow-[0_0_0_4px_rgba(243,229,171,0.22)]'
                                    : 'bg-[#26362E] border-[#E5D5C0]/45 text-[#E5D5C0] group-hover:border-[#F3E5AB] group-hover:text-white'"
                            >
                                {{ sprintf('%02d', $idx + 1) }}
                            </span>
                            <span
                                class="text-[9.5px] font-semibold tracking-wider text-center leading-tight line-clamp-1 transition-colors"
                                :class="babAktif === {{ $idx }} ? 'text-[#F3E5AB]' : 'text-[#E5D5C0]/65 group-hover:text-[#E5D5C0]'"
                            >
                                {{ ! empty($cerita['tanggal']) ? $cerita['tanggal'] : 'Bab '.($idx + 1) }}
                            </span>
                        </button>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Buku Jurnal Linen Bertumpuk 3D --}}
        <div data-gsap="naik" class="relative pb-4">
            {{-- Efek Tumpukan Lembar Kertas Di Bawah Halaman Aktif --}}
            <div aria-hidden="true" class="pointer-events-none absolute bottom-2 inset-x-3 h-8 rounded-b-[1.5rem] bg-[#E8DEC9] border border-[#BFA15F]/45 shadow-md"></div>
            <div aria-hidden="true" class="pointer-events-none absolute bottom-0 inset-x-6 h-8 rounded-b-[1.4rem] bg-[#D6C7AA] border border-[#BFA15F]/35 shadow-sm"></div>

            {{-- Halaman Aktif Jurnal Herbarium --}}
            <div class="relative z-10 rounded-[1.75rem] bg-[#FDFBF7] text-[#1F2937] border border-[#BFA15F]/65 shadow-[0_26px_54px_-16px_rgba(10,18,14,0.65)] overflow-hidden kartu-3d">
                {{-- Lipatan Jilid Buku Linen Sisi Kiri --}}
                <div
                    aria-hidden="true"
                    class="pointer-events-none absolute inset-y-0 left-0 w-3.5 bg-gradient-to-r from-[#E4D5BC]/85 via-[#F4ECDD]/45 to-transparent border-r border-[#BFA15F]/25"
                ></div>

                {{-- Watermark Bunga Sudut Halus Di Pojok Kanan Bawah Halaman --}}
                <img
                    src="{{ $asetRustic['sudut'] }}"
                    alt=""
                    aria-hidden="true"
                    loading="lazy"
                    decoding="async"
                    class="pointer-events-none absolute -bottom-8 -right-8 w-28 opacity-[0.13]"
                >

                <div class="relative z-10 pl-7 pr-5 sm:pl-8 sm:pr-6 pt-6 pb-5">
                    @foreach ($ceritaList as $idx => $cerita)
                        @php
                            $urlFotoBab = (! $tanpaFoto && ! empty($cerita['foto']))
                                ? \App\Support\MediaPublik::url((string) $cerita['foto'])
                                : null;
                        @endphp
                        <article
                            x-show="babAktif === {{ $idx }}"
                            @if ($idx > 0) x-cloak @endif
                            x-transition:enter="transition ease-out duration-350"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="space-y-4 text-left"
                        >
                            {{-- Kepala Bab: Segel Nomor + Tanggal --}}
                            <div class="flex items-center justify-between gap-2 pb-2 border-b border-dashed border-[#BFA15F]/45">
                                <div class="flex items-center gap-2.5">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#3A4E45] text-[#F3E5AB] font-serif text-xs font-bold shadow-xs">
                                        {{ sprintf('%02d', $idx + 1) }}
                                    </span>
                                    <div>
                                        <span class="block text-[9px] font-bold uppercase tracking-[0.28em] text-[#B86B4B]">Lembaran {{ sprintf('%02d', $idx + 1) }}</span>
                                        <span class="block text-[10px] font-medium text-[#4B6358]/80">Jurnal Kisah Kami</span>
                                    </div>
                                </div>
                                @if (! empty($cerita['tanggal']))
                                    <span class="shrink-0 rounded-full bg-[#B86B4B]/12 border border-[#B86B4B]/30 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-[#B86B4B]">
                                        {{ $cerita['tanggal'] }}
                                    </span>
                                @endif
                            </div>

                            {{-- Foto Album Berpojok Emas Antik (Opsional) --}}
                            @if ($urlFotoBab)
                                <div class="relative p-1.5 rounded-2xl bg-[#F6EFE2]/80 border border-[#BFA15F]/35">
                                    <span aria-hidden="true" class="pointer-events-none absolute top-1 left-1 h-3 w-3 border-t-2 border-l-2 border-[#BFA15F] rounded-tl-md z-10"></span>
                                    <span aria-hidden="true" class="pointer-events-none absolute top-1 right-1 h-3 w-3 border-t-2 border-r-2 border-[#BFA15F] rounded-tr-md z-10"></span>
                                    <span aria-hidden="true" class="pointer-events-none absolute bottom-1 left-1 h-3 w-3 border-b-2 border-l-2 border-[#BFA15F] rounded-bl-md z-10"></span>
                                    <span aria-hidden="true" class="pointer-events-none absolute bottom-1 right-1 h-3 w-3 border-b-2 border-r-2 border-[#BFA15F] rounded-br-md z-10"></span>
                                    <div class="overflow-hidden rounded-xl">
                                        <img
                                            src="{{ $urlFotoBab }}"
                                            alt="{{ $cerita['judul'] ?? 'Cerita Cinta' }}"
                                            loading="lazy"
                                            decoding="async"
                                            class="w-full aspect-[16/10] object-cover object-center"
                                        >
                                    </div>
                                </div>
                            @endif

                            {{-- Judul & Narasi Editorial --}}
                            <div class="space-y-2.5">
                                <h3 class="font-serif text-[1.4rem] font-bold text-[#223029] leading-snug">
                                    {{ $cerita['judul'] ?? '' }}
                                </h3>
                                <div class="flex items-center gap-2" aria-hidden="true">
                                    <span class="h-px w-8 bg-[#B86B4B]/65"></span>
                                    <span class="h-1.5 w-1.5 rotate-45 bg-[#BFA15F]"></span>
                                    <span class="h-px flex-1 bg-gradient-to-r from-[#BFA15F]/40 to-transparent"></span>
                                </div>
                                <p class="text-xs sm:text-[13.5px] text-[#35493F]/90 leading-[1.82]">
                                    {{ $cerita['cerita'] ?? '' }}
                                </p>
                            </div>
                        </article>
                    @endforeach

                    {{-- Navigasi Balik Halaman Jurnal --}}
                    @if ($jumlahBabCerita > 1)
                        <div class="mt-6 pt-4 border-t border-[#BFA15F]/30 flex items-center justify-between gap-2">
                            <button
                                type="button"
                                @click="sebelumnya()"
                                class="inline-flex items-center gap-1.5 rounded-full border border-[#4B6358]/30 bg-[#F5EFE4] px-3.5 py-1.5 text-[10.5px] font-bold uppercase tracking-wider text-[#3A4E45] hover:bg-[#4B6358] hover:text-[#FDFBF7] transition cursor-pointer active:scale-95"
                            >
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="m15 18-6-6 6-6"/>
                                </svg>
                                <span>Kembali</span>
                            </button>

                            <span class="text-[10.5px] font-serif font-semibold text-[#4B6358]">
                                Hal. <span x-text="babAktif + 1">1</span> / {{ $jumlahBabCerita }}
                            </span>

                            <button
                                type="button"
                                @click="berikutnya()"
                                class="rustic-tombol-sage inline-flex items-center gap-1.5 rounded-full px-3.5 py-1.5 text-[10.5px] font-bold uppercase tracking-wider transition cursor-pointer active:scale-95"
                            >
                                <span>Lanjut</span>
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="m9 18 6-6-6-6"/>
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- SEKSI 8: GALERI KOLASE BOTANI PRESISI RAPI & BORDER TIPIS ELEGAN --}}
@if (! $tanpaFoto && $undangan->fiturAktif('galeri') && $undangan->daftarGaleri->isNotEmpty())
<section
    data-layout-galeri="klasik"
    data-galeri-kolase-rustic
    class="relative bg-[#F4ECE1] px-4 py-12 overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-7 overflow-hidden">
        <img src="{{ $asetRustic['garland'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async" data-gsap="turun" class="w-32 mx-auto pb-1">
        <div data-gsap="kanan">
            <p class="scroll-scrub-kanan text-[10px] font-bold uppercase tracking-[0.34em] text-[#B86B4B]">Galeri Momen</p>
        </div>
        <div data-gsap="kiri" data-gsap-delay="0.06">
            <h2 class="scroll-scrub-kiri mt-1 font-serif text-3xl font-bold text-[#1F2937]">{{ $undangan->teksKustom('judul_galeri', 'Potret Kebahagiaan') }}</h2>
        </div>
    </div>

    @php
        $totalGaleriRustic = $undangan->daftarGaleri->count();
    @endphp
    <div class="max-w-md mx-auto grid grid-cols-12 gap-2.5">
        @foreach ($undangan->daftarGaleri as $galeri)
            @php
                $pola = $loop->index % 5;
                $sisa = $totalGaleriRustic - $loop->index;
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
                data-gsap="potret"
                data-gsap-delay="{{ number_format(($loop->index % 3) * 0.06, 2, '.', '') }}"
                class="group relative block w-full overflow-hidden rounded-xl border border-[#BFA15F]/40 bg-[#EAE0D2] shadow-[0_8px_22px_-12px_rgba(47,64,55,0.28)] cursor-pointer kartu-3d {{ $kelasTile }}"
            >
                <img
                    src="{{ $galeri->urlFoto() }}"
                    alt="{{ $galeri->keterangan ?? 'Galeri' }}"
                    loading="lazy"
                    decoding="async"
                    class="block w-full h-full object-cover object-top group-hover:scale-105 transition duration-700"
                >
                @if ($galeri->keterangan)
                    <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#1E2E26]/82 via-[#1E2E26]/28 to-transparent px-3 py-2 text-left text-[10.5px] font-medium text-[#FDFBF7] opacity-0 group-hover:opacity-100 transition duration-300">
                        {{ $galeri->keterangan }}
                    </span>
                @endif
            </button>
        @endforeach
    </div>
</section>
@endif
