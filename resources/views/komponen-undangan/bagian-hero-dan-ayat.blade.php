@php
    $permukaanPembuka = match ($gayaTataLetak) {
        'keraton' => 'bg-[#472A1C] text-[#FAF3E6]',
        'priangan' => 'bg-[#5A1E1E] text-[#FAF4E8]',
        'editorial' => 'bg-[#111113] text-[#FAF9F6]',
        'artdeco' => 'bg-[#09090D] text-[#F5EFE6]',
        'taman' => 'bg-[#132623] text-[#F4F8F6]',
        'celestial' => 'bg-[#091322] text-[#E6EEF8]',
        'katedral' => 'bg-[#EFE7DA] text-[#3B2E25]',
        'mihrab' => 'bg-[#133D38] text-[#F4FAF6]',
        default => 'bg-[#3E5349] text-[#FDFBF7]',
    };

    $kartuAyatTema = match ($gayaTataLetak) {
        'keraton' => 'bg-[#FCF7EB]/94 text-[#332012] border-2 border-[#D7BB83] rounded-3xl',
        'priangan' => 'bg-[#FFFBF4]/94 text-[#4A2020] border-2 border-[#C59B43]/70 rounded-3xl',
        'editorial' => 'bg-transparent text-[#FAF9F6] border-y border-white/25 rounded-none',
        'artdeco' => 'bg-[#14141A]/90 text-[#F5EFE6] border border-[#D4AF37]/55 rounded-xl',
        'taman' => 'bg-[#FDFBF7]/92 text-[#1F3431] border border-[#C8A464]/55 rounded-3xl',
        'celestial' => 'bg-[#132438]/90 text-[#E6EEF8] border border-[#D9B664]/50 rounded-t-[4rem] rounded-b-2xl',
        'katedral' => 'bg-white/95 text-[#3B2E25] border border-[#9E7B4F]/45 rounded-2xl',
        'mihrab' => 'bg-white/95 text-[#184D47] border border-[#BFA15F]/45 rounded-t-[4rem] rounded-b-2xl',
        default => 'bg-white/94 text-[#1F2937] border border-[#BFA15F]/40 rounded-3xl',
    };

    $tierDiorama = $tierAktif ?? $tierBawaan ?? 'basic';
    $adalahPremiumAtas = in_array($tierDiorama, ['premium', 'eksklusif'], true);
    $adalahEksklusifDiorama = $tierDiorama === 'eksklusif';
@endphp

{{-- BAGIAN 1: HERO DIORAMA 3D LAYAR PENUH BERTINGKAT SESUAI TIER (BASIC 2-LAPIS / PREMIUM 3-LAPIS / EKSKLUSIF 5-LAPIS) --}}
<section
    data-diorama-3d="{{ $tierDiorama }}"
    class="relative {{ $adalahPremiumAtas ? 'min-h-dvh p-3 sm:p-4 flex items-stretch' : 'px-5 pt-6 pb-8' }} overflow-hidden diorama-panggung-3d"
>
    <div
        class="relative w-full {{ $adalahPremiumAtas ? 'min-h-[calc(100dvh-1.5rem)] sm:min-h-[calc(100dvh-2rem)]' : 'h-[30rem] sm:h-[33rem]' }} {{ $heroBingkaiClass }} {{ $kelasBatas }} overflow-hidden shadow-2xl kartu-3d {{ $ekstraKartu }}"
        style="perspective: 1200px; transform-style: preserve-3d;"
    >
        {{-- Panggung Kamera 3D (Berayun Perspektif Halus Terus-Menerus di Premium & Eksklusif, Terasa di HP & Preview) --}}
        <div
            class="relative w-full h-full flex flex-col justify-between {{ $adalahPremiumAtas ? 'diorama-kamera-3d' : '' }}"
            style="transform-style: preserve-3d;"
        >
            {{-- Z-PLANE 0: Latar Utama dengan 3D Camera Dolly-In saat Undangan Dibuka --}}
            <div class="lapis-paralaks-scroll absolute -inset-6 pointer-events-none" style="--sp: 0.08; --pz: -40px;">
                <img
                    src="{{ $latarUtamaUrl }}"
                    alt="Hero {{ $undangan->tema?->nama_tema }}"
                    class="w-full h-full object-cover object-center animasi-nafas {{ $modeMonokrom ? 'grayscale' : '' }}"
                    :class="undanganTerbuka ? '{{ $adalahPremiumAtas ? 'diorama-latar-3d' : 'diorama-latar-basic' }}' : ''"
                >
            </div>
            <div class="absolute inset-0 {{ $overlaySampul }}"></div>

            {{-- Z-PLANE 1 (KHUSUS EKSKLUSIF): Cahaya Volumetrik & Aura Panggung 3D --}}
            @if ($adalahEksklusifDiorama)
                <div aria-hidden="true" class="pointer-events-none absolute -top-24 left-1/2 -translate-x-1/2 w-80 h-80 rounded-full bg-[#F3E5AB]/18 blur-3xl"></div>
                <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-tr from-black/25 via-transparent to-[#F3E5AB]/10"></div>
            @endif

            {{-- Z-PLANE 2 (PREMIUM & EKSKLUSIF): Sayap Ornamen Midground 3D Membelah Keluar Saat Dibuka --}}
            @if ($ornamenUrl && $adalahPremiumAtas && ! $sudutEditorial)
                <img
                    src="{{ $ornamenUrl }}"
                    alt=""
                    aria-hidden="true"
                    class="pointer-events-none absolute top-[22%] -left-10 {{ $adalahEksklusifDiorama ? 'w-36 sm:w-44 opacity-85' : 'w-28 sm:w-36 opacity-70' }} z-10 drop-shadow-[0_20px_30px_rgba(0,0,0,0.45)]"
                    :class="undanganTerbuka ? 'sayap-kiri-3d' : 'opacity-0'"
                >
                <img
                    src="{{ $ornamenUrl }}"
                    alt=""
                    aria-hidden="true"
                    class="pointer-events-none absolute top-[22%] -right-10 {{ $adalahEksklusifDiorama ? 'w-36 sm:w-44 opacity-85' : 'w-28 sm:w-36 opacity-70' }} z-10 drop-shadow-[0_20px_30px_rgba(0,0,0,0.45)]"
                    :class="undanganTerbuka ? 'sayap-kanan-3d' : 'opacity-0'"
                >
            @endif

            {{-- Z-PLANE 2B: Bingkai Arsitektur Bagian Dalam Khas Tema --}}
            @if ($gayaTataLetak === 'keraton' || $gayaTataLetak === 'priangan')
                <div aria-hidden="true" class="pointer-events-none absolute inset-3.5 z-10 {{ $gayaTataLetak === 'keraton' ? 'rounded-t-[8.5rem] rounded-b-2xl border-2 border-[#D7BB83]/70 shadow-[inset_0_0_24px_rgba(215,187,131,0.2)]' : 'rounded-t-[8.5rem] rounded-b-2xl border border-[#C59B43]/65' }}"></div>
            @elseif ($gayaTataLetak === 'artdeco')
                <div aria-hidden="true" class="pointer-events-none absolute inset-3.5 z-10 border border-[#D4AF37]/60 rounded-xl shadow-[inset_0_0_28px_rgba(212,175,55,0.16)]">
                    <span class="absolute -top-1 -left-1 h-5 w-5 border-t-2 border-l-2 border-[#D4AF37]"></span>
                    <span class="absolute -top-1 -right-1 h-5 w-5 border-t-2 border-r-2 border-[#D4AF37]"></span>
                    <span class="absolute -bottom-1 -left-1 h-5 w-5 border-b-2 border-l-2 border-[#D4AF37]"></span>
                    <span class="absolute -bottom-1 -right-1 h-5 w-5 border-b-2 border-r-2 border-[#D4AF37]"></span>
                </div>
            @elseif ($gayaTataLetak === 'celestial' || $gayaTataLetak === 'mihrab' || $gayaTataLetak === 'katedral')
                <div aria-hidden="true" class="pointer-events-none absolute inset-3.5 z-10 rounded-t-[12rem] rounded-b-2xl border {{ $adalahEksklusifDiorama ? 'border-[#D9B664]/65 shadow-[inset_0_0_28px_rgba(217,182,100,0.2)]' : 'border-[#F3E5AB]/50' }}"></div>
            @elseif ($gayaTataLetak === 'taman')
                <div aria-hidden="true" class="pointer-events-none absolute inset-3.5 z-10 rounded-t-[10.5rem] rounded-b-2xl border-2 border-[#C8A464]/60 shadow-[inset_0_0_28px_rgba(200,164,100,0.18)]"></div>
            @endif

            {{-- Z-PLANE 4: Ornamen Foreground Terbang Masuk & Berayun di Sudut --}}
            @if ($ornamenUrl)
                <img
                    src="{{ $ornamenUrl }}"
                    alt=""
                    class="pointer-events-none absolute -top-2 {{ $ornamenGantung ? 'left-4 w-12' : '-left-3 w-24' }} opacity-90 z-20 drop-shadow-xl animasi-ayun-3d"
                >
                <img
                    src="{{ $ornamenUrl }}"
                    alt=""
                    class="pointer-events-none absolute -top-2 {{ $ornamenGantung ? 'right-4 w-12' : '-right-3 w-24' }} opacity-90 z-20 drop-shadow-xl animasi-ayun-3d-balik"
                >
                @if (! $ornamenGantung && ! $sudutEditorial)
                    <img
                        src="{{ $ornamenUrl }}"
                        alt=""
                        class="pointer-events-none absolute -bottom-4 -left-5 {{ $adalahEksklusifDiorama ? 'w-28' : 'w-24' }} z-20 drop-shadow-[0_14px_24px_rgba(0,0,0,0.45)]"
                        :class="undanganTerbuka ? '{{ $adalahPremiumAtas ? 'sudut-terbang-kiri-3d' : 'ayun-kanan opacity-65' }}' : 'opacity-0'"
                    >
                    <img
                        src="{{ $ornamenUrl }}"
                        alt=""
                        class="pointer-events-none absolute -bottom-4 -right-5 {{ $adalahEksklusifDiorama ? 'w-28' : 'w-24' }} z-20 drop-shadow-[0_14px_24px_rgba(0,0,0,0.45)]"
                        :class="undanganTerbuka ? '{{ $adalahPremiumAtas ? 'sudut-terbang-kanan-3d' : 'ayun-kiri opacity-65' }}' : 'opacity-0'"
                    >
                @endif
            @endif

            {{-- Lapisan Partikel & Makhluk Hidup (Kupu-kupu, Burung, Kunang-kunang, Bintang Jatuh, Debu Emas) --}}
            @include('komponen-undangan.lapisan-motion', ['efekMotion' => $efekMotion, 'konteks' => 'utama'])

            {{-- Z-PLANE 3: Bingkai Konten & Tipografi Pasangan Muncul Maju dari Kedalaman 3D --}}
            <div
                class="relative z-20 h-full flex flex-col justify-between p-6 sm:p-7 text-center"
                :class="undanganTerbuka ? '{{ $adalahPremiumAtas ? 'diorama-bingkai-3d' : 'diorama-bingkai-basic' }}' : 'opacity-0'"
            >
                <div class="{{ $sudutEditorial ? 'pt-4 text-left border-b border-current/25 pb-4' : 'pt-10' }} space-y-2">
                    @if ($bismillahHeader)
                        <p class="text-sm sm:text-base {{ $sampulGelap ? 'text-[#F3E5AB]' : $kelasSubAksen }}" style="font-family: 'Amiri', serif;">
                            بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                        </p>
                    @endif
                    <p class="text-[11px] font-semibold uppercase tracking-[0.32em] {{ $sampulGelap ? 'text-[#F3E5AB]' : $kelasSubAksen }}">
                        {{ $sapaanHero }}
                    </p>
                    <h2 class="font-serif text-4xl sm:text-5xl font-bold leading-tight drop-shadow {{ $teksSampul }}">
                        {{ $undangan->nama_panggilan_pria }}
                        <span class="block font-kaligrafi text-3xl sm:text-4xl font-normal my-0.5 {{ $sampulGelap ? 'text-[#F3E5AB]' : $kelasAksen }}">&amp;</span>
                        {{ $undangan->nama_panggilan_wanita }}
                    </h2>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] {{ $sampulGelap ? 'text-white/90' : $teksSampul.' opacity-85' }}">
                        {{ $tanggalTitik }}
                    </p>
                    @if (! $sudutEditorial)
                        <p class="text-[11px] font-medium tracking-[0.2em] {{ $sampulGelap ? 'text-[#F3E5AB]/95' : $kelasSubAksen }}">
                            {{ $hashtagPasangan }}
                        </p>
                    @endif
                </div>

                <div class="space-y-3.5 pb-2">
                    <div aria-hidden="true" class="mx-auto w-5 h-8 rounded-full border {{ $sampulGelap ? 'border-white/60' : 'border-current/45' }} flex justify-center pt-1.5 opacity-85">
                        <span class="w-1 h-1.5 rounded-full {{ $sampulGelap ? 'bg-[#F3E5AB]' : 'bg-current' }} animasi-gulir-roda"></span>
                    </div>

                    @if ($sudutEditorial)
                        <div class="flex items-center justify-between border-t border-current/25 pt-3 text-[10px] uppercase tracking-[0.3em] {{ $teksSampul }}">
                            <span>Issue 01</span>
                            <span class="font-serif font-bold text-sm px-2.5 py-1 border border-current/40">{{ $undangan->inisialPria() }}&amp;{{ $undangan->inisialWanita() }}</span>
                            <span>{{ $hashtagPasangan }}</span>
                        </div>
                    @elseif ($adalahEksklusifDiorama)
                        <div class="mx-auto w-18 h-18 relative flex items-center justify-center">
                            <span class="absolute inset-0 rounded-full border border-dashed border-[#F3E5AB]/70 animasi-orbit"></span>
                            <span class="absolute inset-1.5 rounded-full border border-[#D4AF37]/65 animasi-orbit-balik"></span>
                            <span class="w-12 h-12 rounded-full backdrop-blur-md border {{ $kelasBatas }} {{ $sampulGelap ? 'bg-black/60 text-[#F3E5AB]' : 'bg-white/90 text-[#1F2937]' }} flex items-center justify-center animasi-kilau shadow-lg">
                                <span class="font-serif text-sm font-bold tracking-widest">{{ $undangan->inisialPria() }}&amp;{{ $undangan->inisialWanita() }}</span>
                            </span>
                        </div>
                    @else
                        <div class="mx-auto w-14 h-14 rounded-full backdrop-blur-md border {{ $kelasBatas }} {{ $sampulGelap ? 'bg-black/45 text-[#F3E5AB]' : 'bg-white/85 text-[#1F2937]' }} flex items-center justify-center animasi-kilau">
                            <span class="font-serif text-sm font-bold tracking-widest">{{ $undangan->inisialPria() }}&amp;{{ $undangan->inisialWanita() }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- BAGIAN 2: PERMUKAAN SOLID PEMBUKA + MONOGRAM BERTEMU KIRI/KANAN + AYAT --}}
<section
    data-section-pembuka="{{ $gayaTataLetak }}"
    class="relative py-11 px-5 overflow-hidden {{ $permukaanPembuka }}"
>
    {{-- Trim Pola Tipis Atas & Bawah --}}
    <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 top-0 h-2.5 opacity-35" style="background-image: url(&quot;{{ $polaDataUri }}&quot;); background-repeat: repeat-x;"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 bottom-0 h-2.5 opacity-35" style="background-image: url(&quot;{{ $polaDataUri }}&quot;); background-repeat: repeat-x;"></div>

    <div class="relative z-10 max-w-md mx-auto space-y-6 text-center">
        @if ($gayaTataLetak === 'editorial')
            <div class="flex items-center justify-between text-[10px] uppercase tracking-[0.34em] text-white/60 border-b border-white/15 pb-3 fx-rise-down">
                <span>00 / Prelude</span>
                <span>{{ $tanggalTitik }}</span>
            </div>
        @endif

        {{-- Monogram Pasangan Bertemu dari Kiri & Kanan (fx-slide-left <-> fx-slide-right) --}}
        <div class="grid grid-cols-3 items-center max-w-[200px] mx-auto">
            <span class="fx-slide-left font-serif text-4xl sm:text-5xl font-bold tracking-wider {{ $gayaTataLetak === 'katedral' ? 'text-[#8B6F47]' : 'text-[#E7CB8B]' }}">
                {{ $undangan->inisialPria() }}
            </span>
            <span class="fx-scale-in font-kaligrafi text-3xl opacity-80">&amp;</span>
            <span class="fx-slide-right font-serif text-4xl sm:text-5xl font-bold tracking-wider {{ $gayaTataLetak === 'katedral' ? 'text-[#8B6F47]' : 'text-[#E7CB8B]' }}">
                {{ $undangan->inisialWanita() }}
            </span>
        </div>

        @php
            $urlFotoPembukaTema = (! $tanpaFoto) ? $undangan->urlFotoPembukaKhususDashboard() : null;
        @endphp
        @if ($urlFotoPembukaTema)
            <div class="fx-scale-in mx-auto w-56 sm:w-64 overflow-hidden {{ $sudutEditorial ? 'rounded-none border border-white/30' : 'rounded-t-[10rem] rounded-b-3xl border-2 border-[#D7BB83]/70' }} shadow-2xl">
                <img
                    src="{{ $urlFotoPembukaTema }}"
                    alt="Foto Pembuka {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                    class="w-full aspect-[4/5] object-cover object-top {{ $modeMonokrom ? 'grayscale' : '' }}"
                >
            </div>
        @endif

        @if ($undangan->kutipan_ayat)
            <blockquote class="fx-rise {{ $kartuAyatTema }} p-6 sm:p-7 text-center relative overflow-hidden kartu-3d {{ $ekstraKartu }}">
                @if ($gayaTataLetak === 'editorial')
                    <span aria-hidden="true" class="block font-serif text-4xl leading-none text-white/30 mb-2">&ldquo;</span>
                @elseif ($gayaTataLetak === 'katedral')
                    <span aria-hidden="true" class="mx-auto mb-3 inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#9E7B4F]/15 text-[#9E7B4F] border border-[#9E7B4F]/35 font-serif text-xs font-bold">
                        &#10022;
                    </span>
                @elseif ($gayaTataLetak === 'celestial' || $gayaTataLetak === 'mihrab')
                    <p class="mb-2.5 text-base {{ $gayaTataLetak === 'celestial' ? 'text-[#F3E5AB]' : 'text-[#9E7D40]' }}" style="font-family: 'Amiri', serif;">
                        بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                    </p>
                @endif

                <p class="italic text-xs sm:text-sm leading-relaxed">
                    "{{ $undangan->kutipan_ayat }}"
                </p>
            </blockquote>
        @endif
    </div>
</section>
