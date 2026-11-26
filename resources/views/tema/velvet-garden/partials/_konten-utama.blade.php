{{-- SEKSI 3: PAVILIUN MEMPELAI KONSERVATORI (PANGGUNG ZAMRUD + BINGKAI LENGKUNG EMAS ANTIK) --}}
<section
    data-layout-mempelai="taman"
    class="relative bg-gradient-to-b from-[#162C28] via-[#132623] to-[#11221F] px-4 py-12 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-7">
        <div class="text-center space-y-2">
            <div data-gsap="turun">
                <img src="{{ $asetGarden['garland'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async" class="w-36 mx-auto drop-shadow animasi-melayang">
            </div>
            <p data-gsap="mekar" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#EEDAD4]">The Couple</p>
            <h2 data-gsap="naik" class="font-serif text-3xl font-bold text-white">{{ $undangan->teksKustom('judul_mempelai', 'Mempelai Berbahagia') }}</h2>
            <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs text-[#EEDAD4]/80 max-w-xs mx-auto leading-relaxed">
                {{ $undangan->teksKustom('pengantar_mempelai', 'Dengan memohon rahmat dan ridho Tuhan Yang Maha Esa, kami bermaksud menyelenggarakan pernikahan putra-putri kami:') }}
            </p>
        </div>

        {{-- MEMPELAI PRIA (PANGGUNG ZAMRUD GELAP + BINGKAI LENGKUNG KUNINGAN ANTIK) --}}
        <article class="group relative rounded-[2rem] bg-[#FDFBF7] text-[#1F3431] border-2 border-[#C8A464]/70 shadow-[0_24px_54px_-16px_rgba(4,12,9,0.75)] overflow-hidden kartu-3d efek-shimmer-kartu">
            {{-- Panggung Atas Potret Zamrud Senja --}}
            <div class="relative bg-gradient-to-b from-[#0E201C] via-[#152E28] to-[#1C3B34] px-5 pt-7 pb-6 overflow-hidden">
                <img
                    src="{{ $asetGarden['latar'] }}"
                    alt=""
                    aria-hidden="true"
                    loading="lazy"
                    decoding="async"
                    class="pointer-events-none absolute inset-0 w-full h-full object-cover object-center opacity-[0.2]"
                >
                <div
                    aria-hidden="true"
                    class="pointer-events-none absolute inset-0"
                    style="background: radial-gradient(circle at 50% 45%, rgba(200,164,100,0.22) 0%, transparent 66%);"
                ></div>

                <div data-gsap="potret" class="relative z-10 mx-auto w-[248px] sm:w-[266px] aspect-[780/960] flex items-center justify-center">
                    <div class="absolute inset-x-[12.5%] top-[8.5%] bottom-[11.5%] rounded-t-[10rem] rounded-b-[1.35rem] overflow-hidden bg-[#0E1E18] shadow-[0_14px_32px_rgba(4,12,9,0.6)]">
                        @if (! $tanpaFoto && $undangan->urlFotoPria())
                            <img
                                src="{{ $undangan->urlFotoPria() }}"
                                alt="{{ $undangan->nama_lengkap_pria }}"
                                loading="lazy"
                                decoding="async"
                                class="w-full h-full object-cover object-top scale-[1.03] group-hover:scale-[1.07] transition duration-700"
                            >
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center gap-1 bg-gradient-to-b from-[#23423B] via-[#172E29] to-[#0E1E18] text-[#F3DFA2]">
                                <span class="text-[9px] uppercase tracking-[0.28em] text-[#EEDAD4]">The Groom</span>
                                <span class="font-serif text-6xl font-bold leading-none">{{ $undangan->inisialPria() }}</span>
                            </div>
                        @endif
                    </div>

                    <img
                        src="{{ $asetGarden['bingkaiMempelai'] }}"
                        alt=""
                        aria-hidden="true"
                        loading="lazy"
                        decoding="async"
                        class="pointer-events-none relative z-10 w-full h-full object-contain drop-shadow-[0_10px_24px_rgba(4,12,9,0.55)]"
                    >
                </div>
            </div>

            {{-- Pita Gelar Mempelai Pria --}}
            <div data-gsap="mekar" class="relative z-20 -mt-3.5 flex justify-center">
                <span class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#213B35] via-[#172D28] to-[#213B35] border border-[#C8A464]/75 px-4 py-1 text-[10px] font-bold uppercase tracking-[0.24em] text-[#F3DFA2] shadow-md">
                    <span aria-hidden="true" class="w-1 h-1 rotate-45 bg-[#DFC285]"></span>
                    <span>Mempelai Pria</span>
                    <span aria-hidden="true" class="w-1 h-1 rotate-45 bg-[#DFC285]"></span>
                </span>
            </div>

            {{-- Biografi Mempelai Pria --}}
            <div class="relative z-10 px-6 pb-7 pt-4 text-center space-y-2">
                <h3 data-gsap="kiri" class="font-kaligrafi text-5xl text-[#132623] leading-tight">{{ $undangan->nama_panggilan_pria }}</h3>
                <p data-gsap="teks" data-gsap-delay="0.06" class="font-serif text-base font-bold text-[#1F3431]">{{ $undangan->nama_lengkap_pria }}</p>
                @if ($undangan->nama_ayah_pria || $undangan->nama_ibu_pria)
                    <p data-gsap="teks" data-gsap-delay="0.09" class="text-xs text-[#1F3431]/75 leading-relaxed">
                        {{ $undangan->teksKustom('label_pria', 'Putra dari') }} {{ $undangan->nama_ayah_pria }} &amp; {{ $undangan->nama_ibu_pria }}
                    </p>
                @endif
                @if ($instagramPria !== '')
                    <div data-gsap="mekar" data-gsap-delay="0.10" class="pt-1.5">
                        <a
                            href="https://instagram.com/{{ $instagramPria }}"
                            target="_blank"
                            rel="noopener"
                            class="group/ig inline-flex items-center gap-1.5 rounded-full bg-[#132623]/10 border border-[#C8A464]/55 px-4 py-1.5 text-[11px] font-semibold text-[#132623] hover:bg-[#132623] hover:text-[#F3DFA2] transition active:scale-95"
                        >
                            <svg class="w-3.5 h-3.5 text-[#8D6F3A] group-hover/ig:text-[#F3DFA2] transition-colors shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
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

        {{-- Penghubung Medali & Zamrud Emas --}}
        <div class="flex items-center justify-center gap-4 text-[#C8A464]" aria-hidden="true">
            <span data-gsap="garis" class="h-px w-16 bg-gradient-to-r from-transparent to-[#C8A464]"></span>
            <span data-gsap="mekar" class="font-kaligrafi text-4xl text-[#F3DFA2]">&amp;</span>
            <span data-gsap="garis" class="h-px w-16 bg-gradient-to-l from-transparent to-[#C8A464]"></span>
        </div>

        {{-- MEMPELAI WANITA (PANGGUNG ZAMRUD GELAP + BINGKAI LENGKUNG KUNINGAN CERMIN) --}}
        <article class="group relative rounded-[2rem] bg-[#FDFBF7] text-[#1F3431] border-2 border-[#C8A464]/70 shadow-[0_24px_54px_-16px_rgba(4,12,9,0.75)] overflow-hidden kartu-3d efek-shimmer-kartu">
            {{-- Panggung Atas Potret Zamrud Senja --}}
            <div class="relative bg-gradient-to-b from-[#0E201C] via-[#152E28] to-[#1C3B34] px-5 pt-7 pb-6 overflow-hidden">
                <img
                    src="{{ $asetGarden['latar'] }}"
                    alt=""
                    aria-hidden="true"
                    loading="lazy"
                    decoding="async"
                    class="pointer-events-none absolute inset-0 w-full h-full object-cover object-center opacity-[0.2] -scale-x-100"
                >
                <div
                    aria-hidden="true"
                    class="pointer-events-none absolute inset-0"
                    style="background: radial-gradient(circle at 50% 45%, rgba(238,218,212,0.18) 0%, transparent 66%);"
                ></div>

                <div data-gsap="potret" class="relative z-10 mx-auto w-[248px] sm:w-[266px] aspect-[780/960] flex items-center justify-center">
                    <div class="absolute inset-x-[12.5%] top-[8.5%] bottom-[11.5%] rounded-t-[10rem] rounded-b-[1.35rem] overflow-hidden bg-[#0E1E18] shadow-[0_14px_32px_rgba(4,12,9,0.6)]">
                        @if (! $tanpaFoto && $undangan->urlFotoWanita())
                            <img
                                src="{{ $undangan->urlFotoWanita() }}"
                                alt="{{ $undangan->nama_lengkap_wanita }}"
                                loading="lazy"
                                decoding="async"
                                class="w-full h-full object-cover object-top scale-[1.03] group-hover:scale-[1.07] transition duration-700"
                            >
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center gap-1 bg-gradient-to-b from-[#3E5A5C] via-[#26403E] to-[#132623] text-[#F3DFA2]">
                                <span class="text-[9px] uppercase tracking-[0.28em] text-[#EEDAD4]">The Bride</span>
                                <span class="font-serif text-6xl font-bold leading-none">{{ $undangan->inisialWanita() }}</span>
                            </div>
                        @endif
                    </div>

                    <img
                        src="{{ $asetGarden['bingkaiMempelai'] }}"
                        alt=""
                        aria-hidden="true"
                        loading="lazy"
                        decoding="async"
                        class="pointer-events-none relative z-10 w-full h-full object-contain -scale-x-100 drop-shadow-[0_10px_24px_rgba(4,12,9,0.55)]"
                    >
                </div>
            </div>

            {{-- Pita Gelar Mempelai Wanita --}}
            <div data-gsap="mekar" class="relative z-20 -mt-3.5 flex justify-center">
                <span class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#DFC285] via-[#C8A464] to-[#DFC285] border border-[#FFF7E2]/70 px-4 py-1 text-[10px] font-bold uppercase tracking-[0.24em] text-[#132623] shadow-md">
                    <span aria-hidden="true" class="w-1 h-1 rotate-45 bg-[#132623]"></span>
                    <span>Mempelai Wanita</span>
                    <span aria-hidden="true" class="w-1 h-1 rotate-45 bg-[#132623]"></span>
                </span>
            </div>

            {{-- Biografi Mempelai Wanita --}}
            <div class="relative z-10 px-6 pb-7 pt-4 text-center space-y-2">
                <h3 data-gsap="kanan" class="font-kaligrafi text-5xl text-[#132623] leading-tight">{{ $undangan->nama_panggilan_wanita }}</h3>
                <p data-gsap="teks" data-gsap-delay="0.06" class="font-serif text-base font-bold text-[#1F3431]">{{ $undangan->nama_lengkap_wanita }}</p>
                @if ($undangan->nama_ayah_wanita || $undangan->nama_ibu_wanita)
                    <p data-gsap="teks" data-gsap-delay="0.09" class="text-xs text-[#1F3431]/75 leading-relaxed">
                        {{ $undangan->teksKustom('label_wanita', 'Putri dari') }} {{ $undangan->nama_ayah_wanita }} &amp; {{ $undangan->nama_ibu_wanita }}
                    </p>
                @endif
                @if ($instagramWanita !== '')
                    <div data-gsap="mekar" data-gsap-delay="0.10" class="pt-1.5">
                        <a
                            href="https://instagram.com/{{ $instagramWanita }}"
                            target="_blank"
                            rel="noopener"
                            class="group/ig inline-flex items-center gap-1.5 rounded-full bg-[#132623]/10 border border-[#C8A464]/55 px-4 py-1.5 text-[11px] font-semibold text-[#132623] hover:bg-[#132623] hover:text-[#F3DFA2] transition active:scale-95"
                        >
                            <svg class="w-3.5 h-3.5 text-[#8D6F3A] group-hover/ig:text-[#F3DFA2] transition-colors shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
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

{{-- SEKSI 4A: SLIDESHOW KONSERVATORI SENJA TRANSISI KE SAVE THE DATE (TERSEMBUNYI SAAT MODE TANPA FOTO) --}}
@if ($fotoGaleriSlideshow->isNotEmpty())
<div
    data-slideshow-velvet
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
    class="relative h-72 sm:h-80 w-full overflow-hidden bg-[#0E1E18]"
>
    @foreach ($fotoGaleriSlideshow as $idxSlide => $urlSlide)
        <img
            src="{{ $urlSlide }}"
            alt="Potret Konservatori {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
            loading="lazy"
            decoding="async"
            class="absolute inset-0 w-full h-full object-cover object-top transition-opacity duration-1000"
            :class="slideAktif === {{ $idxSlide }} ? 'opacity-92 scale-105' : 'opacity-0 scale-100'"
            style="transition: opacity 1.15s ease, transform 5.2s ease;"
        >
    @endforeach

    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-0"
        style="background: linear-gradient(180deg, rgba(17,34,31,0.52) 0%, rgba(17,34,31,0.08) 32%, rgba(28,51,49,0.34) 66%, #294443 100%);"
    ></div>

    <div aria-hidden="true" class="pointer-events-none absolute inset-x-4 top-4 bottom-0 rounded-t-[9rem] border-x border-t border-[#C8A464]/45 z-10"></div>
</div>
@endif

{{-- SEKSI 4B: HITUNG MUNDUR — 4 KAPSUL PIL BOTANI TINGGI (rounded-full) --}}
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
    class="relative bg-gradient-to-b from-[#294443] via-[#1E3735] to-[#132623] shadow-[0_-2px_0_0_#294443] text-white px-5 {{ $fotoGaleriSlideshow->isNotEmpty() ? 'pt-7 pb-13' : 'py-13' }} text-center border-b border-[#C8A464]/35 overflow-hidden"
>
    <div class="max-w-md mx-auto space-y-5">
        <div class="space-y-1">
            <img src="{{ $asetGarden['garland'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async" data-gsap="turun" class="w-32 mx-auto pb-1 drop-shadow">
            <p data-gsap="turun" class="text-[10px] font-semibold uppercase tracking-[0.34em] text-[#EEDAD4]">Menghitung Hari Bahagia</p>
            <h2 data-gsap="naik" class="font-serif text-3xl font-bold text-white">{{ $undangan->teksKustom('judul_hitung_mundur', 'Save The Date') }}</h2>
            <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs text-[#F3DFA2]/90">{{ $tanggalLengkap }}</p>
        </div>

        {{-- 4 Kapsul Pil Botani Tinggi Khas Velvet Garden --}}
        <div class="grid grid-cols-4 gap-2.5 pt-2">
            @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                <div data-gsap="mekar" data-gsap-delay="{{ number_format($loop->index * 0.07, 2, '.', '') }}" class="rounded-full bg-[#FDFBF7] text-[#1F3431] border-2 border-[#C8A464]/75 py-5 px-1.5 shadow-xl flex flex-col items-center justify-center">
                    <span
                        class="font-serif text-2xl sm:text-3xl font-bold leading-none text-[#132623] tabular-nums"
                        x-text="{{ $var }}"
                        x-effect="if ({{ $var }}) { $el.classList.remove('angka-flip-3d'); void $el.offsetWidth; $el.classList.add('angka-flip-3d'); }"
                    >00</span>
                    <span class="mt-2 text-[9px] uppercase tracking-widest font-bold text-[#8D6F3A]">{{ $label }}</span>
                </div>
            @endforeach
        </div>

        @if ($googleCalUrl)
            <div data-gsap="mekar" data-gsap-delay="0.08" class="pt-2">
                <a href="{{ $googleCalUrl }}" target="_blank" rel="noopener" class="garden-tombol-emas inline-flex items-center gap-2 rounded-full px-7 py-2.5 text-xs font-bold uppercase tracking-wider transition active:scale-95">
                    <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
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

{{-- SEKSI 5: RANGKAIAN ACARA — KARTU LENTERA KONSERVATORI KACA ZAMRUD & PITA KUNINGAN --}}
@if ($undangan->fiturAktif('acara') && $undangan->daftarAcara->isNotEmpty())
<section
    data-layout-acara="taman"
    data-acara-konservatori-velvet
    class="relative bg-gradient-to-b from-[#132623] via-[#0F201D] to-[#0D1B18] px-4 py-14 overflow-hidden"
>
    <div class="max-w-md mx-auto">
        <div class="text-center space-y-1.5 mb-8">
            <img src="{{ $asetGarden['garland'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async" data-gsap="turun" class="w-36 mx-auto pb-1 drop-shadow">
            <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#EEDAD4]">Momen Bahagia</p>
            <h2 data-gsap="naik" class="font-serif text-3xl font-bold text-white">{{ $undangan->teksKustom('judul_acara', 'Rangkaian Acara') }}</h2>
            <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs text-[#EEDAD4]/78 max-w-xs mx-auto leading-relaxed">
                {{ $undangan->teksKustom('pengantar_hitung_mundur', 'Merupakan kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir pada rangkaian acara berikut:') }}
            </p>
        </div>

        <div class="space-y-0">
            @foreach ($undangan->daftarAcara as $acara)
                @php
                    $nomorAcara = str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT);
                @endphp

                <article class="relative rounded-[1.85rem] bg-gradient-to-b from-[#17302B] via-[#112420] to-[#0C1B18] border border-[#C8A464]/65 text-[#F4F8F6] shadow-[0_24px_54px_-16px_rgba(3,10,8,0.85)] overflow-hidden kartu-3d">
                    {{-- Bingkai Sudut Filigree Kuningan Victorian --}}
                    <span aria-hidden="true" class="pointer-events-none absolute top-3 left-3 h-4 w-4 border-t-2 border-l-2 border-[#DFC285]/70 rounded-tl-md z-20"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute top-3 right-3 h-4 w-4 border-t-2 border-r-2 border-[#DFC285]/70 rounded-tr-md z-20"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute bottom-3 left-3 h-4 w-4 border-b-2 border-l-2 border-[#DFC285]/70 rounded-bl-md z-20"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute bottom-3 right-3 h-4 w-4 border-b-2 border-r-2 border-[#DFC285]/70 rounded-br-md z-20"></span>

                    {{-- Pendar Cahaya Lentera Konservatori --}}
                    <div
                        aria-hidden="true"
                        class="pointer-events-none absolute inset-x-0 top-0 h-36"
                        style="background: radial-gradient(ellipse 75% 85% at 50% 0%, rgba(223,194,133,0.18) 0%, transparent 72%);"
                    ></div>

                    {{-- Tajuk Acara --}}
                    <div class="relative z-10 px-6 pt-7 pb-5 text-center space-y-1.5">
                        <p data-gsap="turun" class="inline-flex items-center gap-2 text-[9.5px] font-bold uppercase tracking-[0.3em] text-[#DFC285]">
                            <span aria-hidden="true" class="h-px w-4 bg-[#C8A464]/70"></span>
                            <span>Prosesi {{ $nomorAcara }}</span>
                            <span aria-hidden="true" class="h-px w-4 bg-[#C8A464]/70"></span>
                        </p>
                        <h3 data-gsap="mekar" data-gsap-delay="0.06" class="font-kaligrafi text-[2.7rem] sm:text-[2.95rem] leading-[1.06] text-[#FDFBF7] drop-shadow-xs">
                            {{ $acara->nama_acara }}
                        </h3>
                    </div>

                    {{-- Pita Tanggal & Waktu Kuningan 3-Kolom Khas Velvet Garden --}}
                    <div data-gsap="naik" class="relative z-10 mx-5 rounded-2xl bg-[#0B1815]/75 border border-[#C8A464]/45 px-3 py-3.5">
                        <div class="grid grid-cols-3 items-center divide-x divide-[#C8A464]/30 text-center">
                            <div class="px-1.5">
                                <span class="block text-[8.5px] font-bold uppercase tracking-[0.22em] text-[#EEDAD4]/75">Hari</span>
                                <span class="mt-1 block font-serif text-xs sm:text-sm font-bold text-[#FDFBF7]">
                                    {{ $acara->tanggal_acara->locale('id')->translatedFormat('l') }}
                                </span>
                            </div>
                            <div class="px-1.5">
                                <span class="block font-serif text-2xl sm:text-[1.7rem] font-bold leading-none text-[#F3DFA2]">
                                    {{ $acara->tanggal_acara->format('d') }}
                                </span>
                                <span class="mt-1 block text-[8.5px] font-bold uppercase tracking-[0.18em] text-[#DFC285]">
                                    {{ $acara->tanggal_acara->locale('id')->translatedFormat('M Y') }}
                                </span>
                            </div>
                            <div class="px-1.5">
                                <span class="block text-[8.5px] font-bold uppercase tracking-[0.22em] text-[#EEDAD4]/75">Pukul</span>
                                <span class="mt-1 block font-serif text-[11px] sm:text-xs font-bold text-[#FDFBF7] leading-tight">
                                    {{ \Illuminate\Support\Str::substr($acara->waktu_mulai, 0, 5) }}
                                    @if ($acara->waktu_selesai) - {{ \Illuminate\Support\Str::substr($acara->waktu_selesai, 0, 5) }} @else - Selesai @endif
                                    <span class="block text-[9px] text-[#DFC285]">{{ $acara->zona_waktu }}</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Panel Lokasi Gading Hangat di Bawah Kartu --}}
                    <div class="relative z-10 mt-5 mx-5 mb-5 rounded-2xl bg-[#FDFBF7] text-[#1F3431] border border-[#C8A464]/55 px-5 py-5 text-center space-y-2.5 shadow-inner">
                        <div class="mx-auto w-8 h-8 rounded-full bg-[#132623]/10 border border-[#C8A464]/45 flex items-center justify-center text-[#8D6F3A]" aria-hidden="true">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                        </div>
                        <p data-gsap="kiri" class="font-serif text-base sm:text-lg font-bold text-[#132623] leading-snug">
                            {{ $acara->nama_tempat }}
                        </p>
                        <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs text-[#1F3431]/78 leading-relaxed max-w-[260px] mx-auto">
                            {{ $acara->alamat_lengkap }}
                        </p>

                        @if ($acara->link_maps)
                            <div data-gsap="mekar" data-gsap-delay="0.08" class="pt-1.5">
                                <a href="{{ $acara->link_maps }}" target="_blank" rel="noopener" class="garden-tombol-sage inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-xs font-bold uppercase tracking-wider transition active:scale-95">
                                    <svg class="w-3.5 h-3.5 text-[#DFC285] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                                        <circle cx="12" cy="10" r="3"/>
                                    </svg>
                                    <span>Buka Google Maps</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </article>

                @if (! $loop->last)
                    <div aria-hidden="true" class="flex flex-col items-center py-2">
                        <span class="h-5 w-px bg-gradient-to-b from-[#C8A464]/75 to-[#C8A464]/25"></span>
                        <span class="my-1 flex h-6 w-6 items-center justify-center rounded-full bg-[#132623] border border-[#C8A464]/75 shadow-[0_0_12px_rgba(223,194,133,0.4)]">
                            <span class="h-1.5 w-1.5 rotate-45 bg-[#F3DFA2]"></span>
                        </span>
                        <span class="h-5 w-px bg-gradient-to-t from-[#C8A464]/75 to-[#C8A464]/25"></span>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- SEKSI 6: DRESS CODE & LIVE STREAMING --}}
@if ($adaDressCode || (! empty($live['aktif']) && ! empty($live['link'])))
<section class="relative bg-[#132623] px-4 py-9 space-y-5 overflow-hidden">
    @if ($adaDressCode)
        <div data-section-dress-code="taman" class="max-w-md mx-auto rounded-3xl bg-[#0E1E18]/92 border border-[#C8A464]/55 p-6 text-center shadow-xl space-y-3">
            <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#EEDAD4]">Panduan Busana</p>
            <h3 data-gsap="naik" class="font-serif text-xl font-bold text-white">Botanical Dress Code</h3>
            @if ($dressCodeCatatan !== '')
                <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-sm text-[#F4F8F6]/82 leading-relaxed">{{ $dressCodeCatatan }}</p>
            @endif
            @if (! empty($dressCodeWarna))
                <div class="flex flex-wrap items-center justify-center gap-3.5 pt-1">
                    @foreach ($dressCodeWarna as $hex)
                        <div data-gsap="mekar" data-gsap-delay="{{ number_format($loop->index * 0.06, 2, '.', '') }}" class="flex flex-col items-center gap-1">
                            <span class="h-9 w-9 rounded-full border-2 border-[#EEDAD4] shadow-md" style="background-color: {{ $hex }};"></span>
                            <span class="text-[9px] font-mono text-[#EEDAD4]/80">{{ $hex }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    @if (! empty($live['aktif']) && ! empty($live['link']))
        <div class="max-w-md mx-auto rounded-3xl bg-[#FDFBF7] text-[#1F3431] border-2 border-[#C8A464]/65 p-6 text-center space-y-3 shadow-xl">
            <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#7D6027]">Sanctuary Broadcast</p>
            <h3 data-gsap="naik" class="font-serif text-2xl font-bold text-[#132623]">Live Streaming</h3>
            <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs text-[#1F3431]/75 leading-relaxed">
                Saksikan momen sakral kami secara langsung melalui {{ $live['platform'] ?? 'YouTube Live' }}.
            </p>
            <div data-gsap="mekar" data-gsap-delay="0.08">
                <a href="{{ $live['link'] }}" target="_blank" rel="noopener" class="garden-tombol-sage inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-xs font-bold uppercase tracking-wider transition">
                    <span>Gabung Live Streaming</span>
                </a>
            </div>
        </div>
    @endif
</section>
@endif

{{-- SEKSI 7: CERITA CINTA — LINIMASA LENTERA SULUR EMAS KONSERVATORI --}}
@if ($undangan->fiturAktif('cerita_cinta') && ! empty($ceritaList))
<section
    data-layout-cerita="taman"
    data-cerita-konservatori-velvet
    class="relative bg-gradient-to-b from-[#0D1B18] via-[#132623] to-[#0E1E18] px-4 py-14 overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-8 space-y-1.5 overflow-hidden py-1">
        <img src="{{ $asetGarden['garland'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async" data-gsap="turun" class="w-36 mx-auto pb-0.5 drop-shadow">
        <div data-gsap="kiri">
            <p class="scroll-scrub-kiri text-[10px] font-bold uppercase tracking-[0.36em] text-[#EEDAD4]">Jejak Langkah</p>
        </div>
        <div data-gsap="kanan" data-gsap-delay="0.06">
            <h2 class="scroll-scrub-kanan font-kaligrafi text-5xl text-white leading-tight">{{ $undangan->teksKustom('judul_cerita', 'Cerita Cinta') }}</h2>
        </div>
    </div>

    <div class="max-w-md mx-auto relative pl-8 space-y-6">
        {{-- Sulur Emas Vertikal Berpendar --}}
        <span aria-hidden="true" class="pointer-events-none absolute left-3 top-2 bottom-2 w-0.5 bg-gradient-to-b from-[#DFC285] via-[#C8A464]/65 to-transparent"></span>

        @foreach ($ceritaList as $idx => $cerita)
            @php
                $urlFotoBab = (! $tanpaFoto && ! empty($cerita['foto']))
                    ? \App\Support\MediaPublik::url((string) $cerita['foto'])
                    : null;
            @endphp
            <article class="relative">
                {{-- Simpul Lentera Kunang-kunang Emas --}}
                <span
                    data-gsap="mekar"
                    aria-hidden="true"
                    class="absolute -left-[29px] top-6 flex h-5 w-5 items-center justify-center rounded-full bg-[#132623] border-2 border-[#DFC285] shadow-[0_0_16px_rgba(243,223,162,0.7)]"
                >
                    <span class="h-1.5 w-1.5 rounded-full bg-[#F3DFA2]"></span>
                </span>

                <div class="relative rounded-3xl bg-[#FDFBF7] text-[#1F3431] border border-[#C8A464]/65 p-5 shadow-[0_20px_44px_-16px_rgba(3,10,8,0.8)] kartu-3d efek-shimmer-kartu overflow-hidden">
                    <span aria-hidden="true" class="pointer-events-none absolute top-2 right-2 h-3 w-3 border-t border-r border-[#C8A464]/65 rounded-tr-md"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute bottom-2 left-2 h-3 w-3 border-b border-l border-[#C8A464]/65 rounded-bl-md"></span>

                    @if ($urlFotoBab)
                        <div data-gsap="potret" class="mb-3.5 overflow-hidden rounded-xl border border-[#C8A464]/40">
                            <img src="{{ $urlFotoBab }}" alt="{{ $cerita['judul'] ?? 'Cerita Cinta' }}" loading="lazy" decoding="async" class="w-full aspect-[16/10] object-cover object-center">
                        </div>
                    @endif

                    <div class="flex items-start justify-between gap-2">
                        <div data-gsap="kiri">
                            <span class="block text-[9px] font-bold uppercase tracking-[0.26em] text-[#8D6F3A]">
                                Kisah {{ sprintf('%02d', $idx + 1) }}
                            </span>
                            <h3 class="mt-0.5 font-serif text-lg font-bold text-[#132623] leading-snug">{{ $cerita['judul'] ?? '' }}</h3>
                        </div>
                        @if (! empty($cerita['tanggal']))
                            <span data-gsap="kanan" class="shrink-0 rounded-full bg-[#132623] border border-[#C8A464]/65 px-3 py-0.5 text-[10px] font-semibold text-[#F3DFA2]">
                                {{ $cerita['tanggal'] }}
                            </span>
                        @endif
                    </div>

                    <p data-gsap="teks" data-gsap-delay="0.06" class="mt-2.5 text-xs sm:text-sm text-[#1F3431]/82 leading-relaxed">
                        {{ $cerita['cerita'] ?? '' }}
                    </p>
                </div>
            </article>
        @endforeach
    </div>
</section>
@endif

{{-- SEKSI 8: GALERI KONSERVATORI PRESISI RAPI & BORDER EMAS TIPIS 1PX --}}
@if (! $tanpaFoto && $undangan->fiturAktif('galeri') && $undangan->daftarGaleri->isNotEmpty())
<section
    data-layout-galeri="taman"
    data-galeri-kolase-velvet
    class="relative bg-gradient-to-b from-[#0E1E18] via-[#132623] to-[#162C28] px-4 py-12 overflow-hidden"
>
    <div data-scroll-scrub class="text-center mb-7 space-y-1 overflow-hidden">
        <img src="{{ $asetGarden['garland'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async" data-gsap="turun" class="w-32 mx-auto pb-0.5 drop-shadow">
        <div data-gsap="kanan">
            <p class="scroll-scrub-kanan text-[10px] font-bold uppercase tracking-[0.34em] text-[#EEDAD4]">Garden Gallery</p>
        </div>
        <div data-gsap="kiri" data-gsap-delay="0.06">
            <h2 class="scroll-scrub-kiri mt-1 font-serif text-3xl font-bold text-white">{{ $undangan->teksKustom('judul_galeri', 'Potret Kebahagiaan') }}</h2>
        </div>
    </div>

    @php
        $totalGaleriVelvet = $undangan->daftarGaleri->count();
    @endphp
    <div class="max-w-md mx-auto grid grid-cols-12 gap-2.5">
        @foreach ($undangan->daftarGaleri as $galeri)
            @php
                $pola = $loop->index % 5;
                $sisa = $totalGaleriVelvet - $loop->index;
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
                class="group relative block w-full overflow-hidden rounded-xl border border-[#C8A464]/45 bg-[#0E1E18] shadow-[0_12px_28px_-12px_rgba(3,10,8,0.85)] cursor-pointer kartu-3d {{ $kelasTile }}"
            >
                <img
                    src="{{ $galeri->urlFoto() }}"
                    alt="{{ $galeri->keterangan ?? 'Galeri' }}"
                    loading="lazy"
                    decoding="async"
                    class="block w-full h-full object-cover object-top group-hover:scale-105 transition duration-700"
                >
                @if ($galeri->keterangan)
                    <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#0A1712]/88 via-[#0A1712]/30 to-transparent px-3 py-2 text-left text-[10.5px] font-medium text-[#FDFBF7] opacity-0 group-hover:opacity-100 transition duration-300">
                        {{ $galeri->keterangan }}
                    </span>
                @endif
            </button>
        @endforeach
    </div>
</section>
@endif
