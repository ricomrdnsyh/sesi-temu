{{-- BAGIAN 5: CERITA CINTA (JUDUL SCROLL-SCRUBBING HORIZONTAL + 9 LAYOUT UNIK) --}}
@php
    $ceritaList = $undangan->pengaturan['cerita_cinta'] ?? [];
    $angkaRomawi = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X'];
@endphp

@if ($undangan->fiturAktif('cerita_cinta') && !empty($ceritaList))
<section
    data-aos="fade-up"
    data-aos-duration="950"
    data-layout-cerita="{{ $gayaTataLetak }}"
    class="relative py-12 px-5 overflow-hidden"
>
    {{-- Judul Scroll-Scrubbing Horizontal Berlawanan Arah (Aktif di Semua Tema) --}}
    <div data-scroll-scrub class="text-center mb-7 overflow-hidden py-1">
        <p class="scroll-scrub-kiri text-[11px] font-bold uppercase tracking-[0.34em] {{ $kelasAksen }}">
            {{ $subLabelCerita }}
        </p>
        <h2 class="scroll-scrub-kanan mt-1 font-serif text-3xl sm:text-4xl font-bold tracking-wide">
            {{ $labelCerita }}
        </h2>
        <p class="mt-1 text-[10px] font-semibold uppercase tracking-[0.28em] opacity-60">
            {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
        </p>
    </div>

    @if ($gayaTataLetak === 'keraton')
        {{-- ADAT JAWA KERATON: Kapsul Solid Gading #FCF7EB di Atas Jendela Paralaks --}}
        <div class="rounded-t-[10.5rem] rounded-b-3xl bg-[#FCF7EB] text-[#332012] border-2 border-[#472A1C] px-5 pt-12 pb-8 shadow-2xl space-y-5">
            @if ($ornamenUrl)
                <img src="{{ $ornamenUrl }}" alt="" class="fx-rise-down w-14 mx-auto drop-shadow">
            @endif
            @foreach ($ceritaList as $idx => $cerita)
                @php
                    $urlFotoBab = (! $tanpaFoto && ! empty($cerita['foto']))
                        ? \App\Support\MediaPublik::url((string) $cerita['foto'])
                        : null;
                @endphp
                <div class="fx-rise rounded-2xl bg-white border border-[#D7BB83]/60 p-5 shadow-md kartu-3d">
                    @if ($urlFotoBab)
                        <div class="mb-3 overflow-hidden rounded-xl border border-[#D7BB83]/45">
                            <img src="{{ $urlFotoBab }}" alt="{{ $cerita['judul'] ?? 'Cerita Cinta' }}" class="w-full aspect-[16/10] object-cover object-center">
                        </div>
                    @endif
                    <div class="flex items-center justify-between gap-2 border-b border-[#D7BB83]/35 pb-2">
                        <h3 class="font-serif text-lg font-bold text-[#472A1C]">{{ $cerita['judul'] ?? '' }}</h3>
                        <span class="rounded-full bg-[#472A1C] px-3 py-0.5 text-[10px] font-bold text-[#F3E5AB]">{{ $cerita['tanggal'] ?? '' }}</span>
                    </div>
                    <p class="mt-2.5 text-xs sm:text-sm text-[#332012]/80 leading-relaxed">{{ $cerita['cerita'] ?? '' }}</p>
                </div>
            @endforeach
        </div>

    @elseif ($gayaTataLetak === 'priangan')
        {{-- SUNDA SIGER HERITAGE: Kartu Zig-Zag Kiri-Kanan Bergantian --}}
        <div class="space-y-4">
            @foreach ($ceritaList as $idx => $cerita)
                @php
                    $urlFotoBab = (! $tanpaFoto && ! empty($cerita['foto']))
                        ? \App\Support\MediaPublik::url((string) $cerita['foto'])
                        : null;
                @endphp
                <div class="{{ $idx % 2 === 0 ? 'fx-slide-left mr-5' : 'fx-slide-right ml-5' }} rounded-2xl bg-[#FFFBF4]/95 border-2 border-[#C59B43]/50 p-5 text-[#4A2020] shadow-lg kartu-3d">
                    @if ($urlFotoBab)
                        <div class="mb-3 overflow-hidden rounded-xl border border-[#C59B43]/40">
                            <img src="{{ $urlFotoBab }}" alt="{{ $cerita['judul'] ?? 'Cerita Cinta' }}" class="w-full aspect-[16/10] object-cover object-center">
                        </div>
                    @endif
                    <div class="flex items-center justify-between gap-2">
                        <span class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-[#B58931]">
                            <span class="h-2 w-2 rounded-full bg-[#6E2C2C]"></span>
                            <span>Bab {{ $idx + 1 }}</span>
                        </span>
                        <span class="rounded-full bg-[#6E2C2C] px-2.5 py-0.5 text-[10px] font-semibold text-[#FAF4E8]">{{ $cerita['tanggal'] ?? '' }}</span>
                    </div>
                    <h3 class="mt-2 font-serif text-lg font-bold text-[#5A1E1E]">{{ $cerita['judul'] ?? '' }}</h3>
                    <p class="mt-1.5 text-xs sm:text-sm opacity-80 leading-relaxed">{{ $cerita['cerita'] ?? '' }}</p>
                </div>
            @endforeach
        </div>

    @elseif ($gayaTataLetak === 'editorial')
        {{-- EDITORIAL MONOKROM: Indeks Majalah Bernomor Besar 01, 02, 03 --}}
        <div class="divide-y divide-[#18181B]/20 border-y border-[#18181B]/20 bg-white/95 px-4">
            @foreach ($ceritaList as $idx => $cerita)
                @php
                    $urlFotoBab = (! $tanpaFoto && ! empty($cerita['foto']))
                        ? \App\Support\MediaPublik::url((string) $cerita['foto'])
                        : null;
                @endphp
                <div class="fx-rise py-5 grid grid-cols-12 gap-3 items-start">
                    <div class="col-span-3">
                        <span class="font-serif text-3xl font-bold text-[#18181B]/25 leading-none">{{ sprintf('%02d', $idx + 1) }}</span>
                        <span class="block mt-1 text-[10px] font-semibold uppercase tracking-widest text-[#52525B]">{{ $cerita['tanggal'] ?? '' }}</span>
                    </div>
                    <div class="col-span-9 text-left">
                        @if ($urlFotoBab)
                            <div class="mb-2.5 overflow-hidden border border-[#18181B]/20">
                                <img src="{{ $urlFotoBab }}" alt="{{ $cerita['judul'] ?? 'Cerita Cinta' }}" class="w-full aspect-[16/10] object-cover object-center grayscale">
                            </div>
                        @endif
                        <h3 class="font-serif text-lg font-bold uppercase tracking-wide text-[#18181B]">{{ $cerita['judul'] ?? '' }}</h3>
                        <p class="mt-1.5 text-xs sm:text-sm text-[#52525B] leading-relaxed">{{ $cerita['cerita'] ?? '' }}</p>
                    </div>
                </div>
            @endforeach
        </div>

    @elseif ($gayaTataLetak === 'katedral')
        {{-- ROYAL IVORY CATHEDRAL: Bab Surat Bernomor Romawi I, II, III --}}
        <div class="space-y-4">
            @foreach ($ceritaList as $idx => $cerita)
                @php
                    $urlFotoBab = (! $tanpaFoto && ! empty($cerita['foto']))
                        ? \App\Support\MediaPublik::url((string) $cerita['foto'])
                        : null;
                @endphp
                <div class="fx-rise relative rounded-2xl bg-white/95 border border-[#9E7B4F]/40 pl-14 pr-5 py-5 shadow-md kartu-3d">
                    <span class="absolute left-3.5 top-5 inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#9E7B4F]/15 border border-[#9E7B4F]/45 font-serif text-xs font-bold text-[#7B603F]">
                        {{ $angkaRomawi[$idx] ?? ($idx + 1) }}
                    </span>
                    @if ($urlFotoBab)
                        <div class="mb-3 overflow-hidden rounded-xl border border-[#9E7B4F]/35">
                            <img src="{{ $urlFotoBab }}" alt="{{ $cerita['judul'] ?? 'Cerita Cinta' }}" class="w-full aspect-[16/10] object-cover object-center">
                        </div>
                    @endif
                    <div class="flex items-center justify-between gap-2">
                        <h3 class="font-serif text-lg font-bold text-[#3B2E25]">{{ $cerita['judul'] ?? '' }}</h3>
                        <span class="text-[11px] font-semibold text-[#9E7B4F]">{{ $cerita['tanggal'] ?? '' }}</span>
                    </div>
                    <p class="mt-1.5 text-xs sm:text-sm text-[#3B2E25]/80 leading-relaxed">{{ $cerita['cerita'] ?? '' }}</p>
                </div>
            @endforeach
        </div>

    @elseif ($tampilTimelineCerita)
        {{-- TIMELINE EKSKLUSIF: LUXURY NOIR (Diamond Emas), VELVET GARDEN (Botani), ISLAMIC HEAVENLY (Konstelasi Bintang) --}}
        <div class="relative pl-7 space-y-5 border-l-2 {{ $kelasBatas }} ml-2">
            @foreach ($ceritaList as $cerita)
                @php
                    $urlFotoBab = (! $tanpaFoto && ! empty($cerita['foto']))
                        ? \App\Support\MediaPublik::url((string) $cerita['foto'])
                        : null;
                @endphp
                <div class="fx-slide-right relative">
                    @if ($gayaTataLetak === 'artdeco')
                        <span aria-hidden="true" class="absolute -left-[35px] top-5 w-3.5 h-3.5 rotate-45 border border-[#F3E5AB] bg-[#D4AF37] shadow-[0_0_12px_rgba(212,175,55,0.65)]"></span>
                    @elseif ($gayaTataLetak === 'celestial')
                        <span aria-hidden="true" class="absolute -left-[36px] top-4 w-4 h-4 rounded-full bg-[#D9B664] text-[#091322] text-[10px] flex items-center justify-center shadow-[0_0_12px_rgba(217,182,100,0.85)]">&#10022;</span>
                    @else
                        <span aria-hidden="true" class="absolute -left-[35px] top-5 w-3.5 h-3.5 rounded-full border-2 {{ $kelasBatas }} bg-[#C8A464] shadow-[0_0_0_4px_rgba(200,164,100,0.22)]"></span>
                    @endif
                    <div class="{{ $radiusKartuSedang }} p-5 kartu-3d {{ $ekstraKartu }} {{ $kelasKartu }}">
                        @if ($urlFotoBab)
                            <div class="mb-3 overflow-hidden rounded-xl border {{ $kelasBatas }}">
                                <img src="{{ $urlFotoBab }}" alt="{{ $cerita['judul'] ?? 'Cerita Cinta' }}" class="w-full aspect-[16/10] object-cover object-center">
                            </div>
                        @endif
                        <div class="flex items-center justify-between gap-2">
                            <h3 class="font-serif text-lg font-bold">{{ $cerita['judul'] ?? '' }}</h3>
                            <span class="rounded-full px-3 py-0.5 text-[11px] font-semibold {{ $kelasBadge }}">{{ $cerita['tanggal'] ?? '' }}</span>
                        </div>
                        <p class="mt-2 text-xs sm:text-sm opacity-80 leading-relaxed">{{ $cerita['cerita'] ?? '' }}</p>
                    </div>
                </div>
            @endforeach
        </div>

    @else
        {{-- BASIC: RUSTIC FLORAL & ISLAMI SYAR'I --}}
        <div class="space-y-4">
            @foreach ($ceritaList as $cerita)
                @php
                    $urlFotoBab = (! $tanpaFoto && ! empty($cerita['foto']))
                        ? \App\Support\MediaPublik::url((string) $cerita['foto'])
                        : null;
                @endphp
                <div class="fx-rise {{ $radiusKartuSedang }} p-5 kartu-3d {{ $kelasKartu }}">
                    @if ($urlFotoBab)
                        <div class="mb-3 overflow-hidden rounded-xl border {{ $kelasBatas }}">
                            <img src="{{ $urlFotoBab }}" alt="{{ $cerita['judul'] ?? 'Cerita Cinta' }}" class="w-full aspect-[16/10] object-cover object-center">
                        </div>
                    @endif
                    <div class="flex items-center justify-between gap-2">
                        <h3 class="font-serif text-lg font-bold">{{ $cerita['judul'] ?? '' }}</h3>
                        <span class="rounded-full px-3 py-0.5 text-[11px] font-semibold {{ $kelasBadge }}">{{ $cerita['tanggal'] ?? '' }}</span>
                    </div>
                    <p class="mt-2 text-xs sm:text-sm opacity-80 leading-relaxed">{{ $cerita['cerita'] ?? '' }}</p>
                </div>
            @endforeach
        </div>
    @endif
</section>
@endif

{{-- BAGIAN 6: GALERI FOTO (BERBEDA GAYA PER TEMA + HORMATI MODE TANPA FOTO) --}}
@if (! $tanpaFoto && $undangan->fiturAktif('galeri') && $undangan->daftarGaleri->isNotEmpty())
<section
    data-aos="fade-up"
    data-aos-duration="950"
    data-layout-galeri="{{ $gayaTataLetak }}"
    class="relative py-12 px-5 overflow-hidden {{ $gayaTataLetak === 'keraton' ? 'bg-[#2B180F] text-[#FAF3E6]' : '' }}"
>
    <div data-scroll-scrub class="text-center mb-7 overflow-hidden">
        <p class="scroll-scrub-kanan text-[11px] font-semibold uppercase tracking-[0.28em] {{ $gayaTataLetak === 'keraton' ? 'text-[#D7BB83]' : $kelasAksen }}">{{ $subLabelGaleri }}</p>
        <h2 class="scroll-scrub-kiri mt-1.5 font-serif text-3xl font-bold">{{ $labelGaleri }}</h2>
    </div>

    <div class="grid grid-cols-2 gap-3.5">
        @foreach ($undangan->daftarGaleri as $galeri)
            @php
                $adalahUnggulan = ($gayaGaleri === 'unggulan' && $loop->first)
                    || ($gayaTataLetak === 'priangan' && ($loop->index % 3 === 0));

                $bentukGaleri = match (true) {
                    $gayaGaleri === 'unggulan' && $loop->first => 'col-span-2 aspect-[16/10] rounded-3xl',
                    $gayaTataLetak === 'priangan' && ($loop->index % 3 === 0) => 'col-span-2 aspect-[16/10] rounded-t-[3.5rem] rounded-b-2xl',
                    $gayaTataLetak === 'editorial' => $loop->odd ? 'aspect-[3/4] rounded-none' : 'aspect-square rounded-none',
                    $gayaTataLetak === 'taman' => 'aspect-[4/5] rounded-2xl bg-white p-1.5 pb-6 shadow-xl '.($loop->odd ? 'polaroid-3d-kiri' : 'polaroid-3d-kanan'),
                    $gayaTataLetak === 'katedral' => 'aspect-[4/5] rounded-t-[3.5rem] rounded-b-2xl border-2',
                    $gayaTataLetak === 'celestial' => 'aspect-[4/5] rounded-t-[3rem] rounded-b-2xl border',
                    $gayaTataLetak === 'keraton' => 'aspect-[4/5] rounded-2xl border-2 border-[#D7BB83]/65 bg-[#FCF7EB]/10 p-1',
                    default => 'aspect-square rounded-2xl',
                };
            @endphp

            <button
                type="button"
                @click="bukaGaleri(@js($galeri->urlFoto()), @js($galeri->keterangan))"
                class="fx-scale-in group relative overflow-hidden border {{ $kelasBatas }} cursor-pointer kartu-3d masuk-3d {{ $bentukGaleri }}"
            >
                <img
                    src="{{ $galeri->urlFoto() }}"
                    alt="{{ $galeri->keterangan ?? 'Galeri' }}"
                    class="w-full h-full object-cover {{ $gayaTataLetak === 'taman' || $gayaTataLetak === 'keraton' ? 'rounded-xl' : '' }} group-hover:scale-105 transition duration-700 {{ $modeMonokrom ? 'grayscale group-hover:grayscale-0' : '' }}"
                >
                @if ($gayaTataLetak === 'taman' && ! $adalahUnggulan)
                    <span class="pointer-events-none absolute inset-x-2 bottom-1 text-center text-[10px] font-kaligrafi text-[#1F3431] truncate">
                        {{ $galeri->keterangan ?: ($undangan->nama_panggilan_pria.' & '.$undangan->nama_panggilan_wanita) }}
                    </span>
                @elseif (($isEksklusif || $gayaTataLetak === 'editorial') && $galeri->keterangan)
                    <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/75 to-transparent px-3 py-2 text-left text-[11px] font-medium text-white/90 opacity-0 group-hover:opacity-100 transition duration-300">
                        {{ $galeri->keterangan }}
                    </span>
                @endif
            </button>
        @endforeach
    </div>

    @if ($gayaTataLetak === 'keraton' || $gayaTataLetak === 'editorial')
        <div class="mt-7 flex items-center justify-center gap-3 text-[10px] font-semibold uppercase tracking-[0.34em] opacity-75">
            <span class="h-px w-10 bg-current opacity-40"></span>
            <span>{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</span>
            <span class="h-px w-10 bg-current opacity-40"></span>
        </div>
    @endif
</section>
@endif
