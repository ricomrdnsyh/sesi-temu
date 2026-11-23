@if (! request()->boolean('embed'))
@php
    $slugIntro = $undangan->tema?->slug ?? 'rustic-floral';
    $inisialPriaIntro = $undangan->inisialPria();
    $inisialWanitaIntro = $undangan->inisialWanita();
    $acaraIntro = $acaraPertama ?? $undangan->acaraTerdekat();
    $tanggalIntro = $tanggalTitik ?? ($acaraIntro?->tanggal_acara?->format('d . m . y') ?? now()->format('d . m . y'));
    $tahunIntro = $acaraIntro?->tanggal_acara?->format('Y') ?? now()->format('Y');

    $daftarGayaIntro = [
        'adat-jawa' => [
            'keluar' => 'belah-tengah',
            'bg' => 'radial-gradient(circle at 50% 42%, #472A1C 0%, #2B170D 58%, #160A05 100%)',
            'panel' => 'linear-gradient(180deg, #3A2114 0%, #24130A 55%, #160A05 100%)',
            'teks' => '#FFFBF4',
            'aksen' => '#E5C98B',
            'aksen_lembut' => 'rgba(229, 201, 139, 0.34)',
            'eyebrow' => 'Pawiwahan Ageng',
            'bingkai' => 'sudut-keraton',
            'lambang' => 'gambar',
            'gambar' => asset('aset-tema/adat-jawa/ornamen-gunungan.webp'),
            'gambar_class' => 'w-12 sm:w-14',
            'bismillah' => false,
            'monogram' => 'berlian',
            'nama_class' => 'font-serif text-[2rem] sm:text-[2.25rem] font-semibold tracking-[0.06em]',
        ],
        'sunda-heritage' => [
            'keluar' => 'fade-halus',
            'bg' => 'radial-gradient(circle at 50% 42%, #6E2424 0%, #4A1616 58%, #280B0B 100%)',
            'panel' => 'linear-gradient(180deg, #5F2020 0%, #431414 55%, #2B0C0C 100%)',
            'teks' => '#FFFDF8',
            'aksen' => '#E7C87D',
            'aksen_lembut' => 'rgba(231, 200, 125, 0.36)',
            'eyebrow' => 'Sampurasun • Walimatul Ursy',
            'bingkai' => 'arch-priangan',
            'lambang' => 'gambar',
            'gambar' => asset('aset-tema/sunda-heritage/ornamen-siger.webp'),
            'gambar_class' => 'w-14 sm:w-16',
            'bismillah' => false,
            'monogram' => 'medali-lingkar',
            'nama_class' => 'font-serif text-[2rem] sm:text-[2.25rem] font-bold tracking-[0.05em]',
        ],
        'islami-syari' => [
            'keluar' => 'mekar-halus',
            'bg' => 'radial-gradient(circle at 50% 44%, #F9FCF9 0%, #EBF5EE 62%, #D7EAE0 100%)',
            'panel' => 'linear-gradient(180deg, #F7FBF8 0%, #EAF4ED 60%, #DBECE2 100%)',
            'teks' => '#0E3A36',
            'aksen' => '#B38E43',
            'aksen_lembut' => 'rgba(179, 142, 67, 0.35)',
            'eyebrow' => 'Walimatul Ursy',
            'bingkai' => 'mihrab-syari',
            'lambang' => 'rub-el-hizb',
            'gambar' => null,
            'gambar_class' => '',
            'bismillah' => true,
            'monogram' => 'bintang-islami',
            'nama_class' => 'font-serif text-[2rem] sm:text-[2.2rem] font-bold tracking-[0.04em]',
        ],
        'islamic-heavenly' => [
            'keluar' => 'belah-tengah',
            'bg' => 'radial-gradient(circle at 50% 40%, #1B3358 0%, #0D1C33 58%, #060E1B 100%)',
            'panel' => 'linear-gradient(180deg, #132542 0%, #0B1629 55%, #060D1A 100%)',
            'teks' => '#F4F8FF',
            'aksen' => '#E5C474',
            'aksen_lembut' => 'rgba(229, 196, 116, 0.34)',
            'eyebrow' => 'Walimatul Ursy',
            'bingkai' => 'orbit-bintang',
            'lambang' => 'gambar',
            'gambar' => asset('aset-tema/islamic-heavenly/ornamen-sabit.webp'),
            'gambar_class' => 'w-12 sm:w-14',
            'bismillah' => true,
            'monogram' => 'orbit-celestial',
            'nama_class' => 'font-serif text-[2rem] sm:text-[2.25rem] font-semibold tracking-[0.06em]',
        ],
        'rustic-floral' => [
            'keluar' => 'gulir-atas',
            'bg' => 'radial-gradient(circle at 50% 42%, #FDFBF7 0%, #F4ECE0 60%, #E7DAC8 100%)',
            'panel' => 'linear-gradient(180deg, #FDFBF7 0%, #F5EDE2 60%, #EAE0D1 100%)',
            'teks' => '#2F4037',
            'aksen' => '#9E7D44',
            'aksen_lembut' => 'rgba(75, 99, 88, 0.28)',
            'eyebrow' => 'The Wedding Of',
            'bingkai' => 'garis-linen',
            'lambang' => 'ranting-botani',
            'gambar' => null,
            'gambar_class' => '',
            'bismillah' => false,
            'monogram' => 'lingkar-daun',
            'nama_class' => 'font-kaligrafi text-[2.45rem] sm:text-[2.7rem] font-normal leading-tight',
        ],
        'velvet-garden' => [
            'keluar' => 'mekar-halus',
            'bg' => 'radial-gradient(circle at 50% 42%, #294945 0%, #17302D 58%, #0E1F1D 100%)',
            'panel' => 'linear-gradient(180deg, #213D3A 0%, #152C29 58%, #0D1D1B 100%)',
            'teks' => '#F7FAF8',
            'aksen' => '#D8B776',
            'aksen_lembut' => 'rgba(216, 183, 118, 0.34)',
            'eyebrow' => 'Conservatory Wedding',
            'bingkai' => 'arch-konservatori',
            'lambang' => 'gambar',
            'gambar' => asset('aset-tema/velvet-garden/ornamen-botani.webp'),
            'gambar_class' => 'w-14 sm:w-16',
            'bismillah' => false,
            'monogram' => 'medali-lingkar',
            'nama_class' => 'font-serif text-[2rem] sm:text-[2.25rem] font-semibold tracking-[0.05em]',
        ],
        'luxury-noir' => [
            'keluar' => 'belah-tengah',
            'bg' => 'radial-gradient(circle at 50% 42%, #1D1C24 0%, #0E0E13 56%, #060608 100%)',
            'panel' => 'linear-gradient(180deg, #16151C 0%, #0B0B0F 58%, #060608 100%)',
            'teks' => '#FAF3E0',
            'aksen' => '#D9B65A',
            'aksen_lembut' => 'rgba(217, 182, 90, 0.36)',
            'eyebrow' => 'The Grand Celebration',
            'bingkai' => 'art-deco',
            'lambang' => 'kipas-deco',
            'gambar' => null,
            'gambar_class' => '',
            'bismillah' => false,
            'monogram' => 'berlian',
            'nama_class' => 'noir-font-judul font-serif text-[1.85rem] sm:text-[2.1rem] font-semibold uppercase tracking-[0.14em]',
        ],
        'royal-ivory' => [
            'keluar' => 'gulir-atas',
            'bg' => 'radial-gradient(circle at 50% 42%, #FDFBF7 0%, #F3EBDC 60%, #E5D8C2 100%)',
            'panel' => 'linear-gradient(180deg, #FBF8F3 0%, #F2E9D9 60%, #E7DAC4 100%)',
            'teks' => '#3B2E25',
            'aksen' => '#9E7B4F',
            'aksen_lembut' => 'rgba(158, 123, 79, 0.36)',
            'eyebrow' => 'The Royal Wedding',
            'bingkai' => 'katedral-ganda',
            'lambang' => 'mahkota-royal',
            'gambar' => null,
            'gambar_class' => '',
            'bismillah' => false,
            'monogram' => 'segel-lilin',
            'nama_class' => 'font-serif text-[2rem] sm:text-[2.25rem] font-semibold tracking-[0.06em]',
        ],
        'editorial-monokrom' => [
            'keluar' => 'belah-tengah',
            'bg' => 'linear-gradient(180deg, #111113 0%, #09090B 100%)',
            'panel' => 'linear-gradient(180deg, #111113 0%, #09090B 100%)',
            'teks' => '#FAF9F6',
            'aksen' => '#D4D4D8',
            'aksen_lembut' => 'rgba(250, 249, 246, 0.24)',
            'eyebrow' => 'Special Wedding Edition',
            'bingkai' => 'swiss-editorial',
            'lambang' => 'editorial-masthead',
            'gambar' => null,
            'gambar_class' => '',
            'bismillah' => false,
            'monogram' => 'editorial-slash',
            'nama_class' => 'ed-serif font-serif text-[1.95rem] sm:text-[2.2rem] font-normal uppercase tracking-[0.16em]',
        ],
    ];

    $gayaIntro = $daftarGayaIntro[$slugIntro] ?? $daftarGayaIntro['rustic-floral'];
    $adalahAdatJawa = $slugIntro === 'adat-jawa';
    $adalahBelahTengah = $gayaIntro['keluar'] === 'belah-tengah';
    $lebarKolomIntro = $lebarKolomIntro ?? 'lg:w-[460px] xl:w-[490px]';
    $durasiIntroMs = $adalahAdatJawa ? 3450 : 2350;
    $durasiKeluarMs = $adalahAdatJawa ? 980 : 820;
@endphp

<div
    data-intro-pembuka="{{ $slugIntro }}"
    data-intro-keluar="{{ $gayaIntro['keluar'] }}"
    data-intro-durasi="{{ $durasiIntroMs }}"
    data-intro-keluar-ms="{{ $durasiKeluarMs }}"
    role="presentation"
    aria-hidden="true"
    class="intro-pembuka-tirai fixed inset-0 mx-auto h-dvh w-full {{ $lebarKolomIntro }} z-[45] cursor-pointer select-none overflow-hidden {{ !empty($tampilBarDemo) ? 'pt-28 sm:pt-20 lg:pt-14' : '' }}"
    style="height: 100dvh; --intro-aksen: {{ $gayaIntro['aksen'] }}; --intro-aksen-lembut: {{ $gayaIntro['aksen_lembut'] }}; color: {{ $gayaIntro['teks'] }};"
>
    @if ($adalahAdatJawa)
        {{-- INTRO BESPOKE ADAT JAWA KERATON: 2-BABAK TANCEP KAYON (GUNUNGAN -> BINGKAI UKIRAN -> PINTU GEBYOK TERBELAH) --}}
        <div class="intro-jawa-panggung relative w-full h-full flex flex-col items-center justify-center overflow-hidden">
            {{-- PINTU GEBYOK KIRI (TERMASUK SEPARUH BATIK KAWUNG, SUDUT KERATON, & SAYAP WAYANG) --}}
            <div
                class="intro-panel-kiri intro-jawa-pintu pointer-events-none absolute inset-y-0 left-0 w-1/2 overflow-hidden"
                style="background: linear-gradient(180deg, #351D10 0%, #201008 48%, #130804 100%); border-right: 1px solid rgba(229, 201, 139, 0.45);"
            >
                <img
                    src="{{ asset('aset-tema/adat-jawa/motif-kawung-atas.webp') }}"
                    alt=""
                    loading="eager"
                    decoding="sync"
                    class="absolute top-0 left-0 w-[200%] max-w-none h-11 sm:h-12 object-cover object-bottom opacity-32 intro-jawa-mask-atas"
                >
                <img
                    src="{{ asset('aset-tema/adat-jawa/motif-kawung-bawah.webp') }}"
                    alt=""
                    loading="eager"
                    decoding="sync"
                    class="absolute bottom-0 left-0 w-[200%] max-w-none h-11 sm:h-12 object-cover object-top opacity-30 intro-jawa-mask-bawah"
                >
                <div class="absolute inset-y-4 left-3.5 right-0 rounded-l-xl border-y border-l border-[#E5C98B]/24">
                    <span class="absolute -top-[1px] -left-[1px] h-6 w-6 rounded-tl-lg border-t-2 border-l-2 border-[#E5C98B]/85"></span>
                    <span class="absolute -bottom-[1px] -left-[1px] h-6 w-6 rounded-bl-lg border-b-2 border-l-2 border-[#E5C98B]/85"></span>
                </div>
                <span class="absolute inset-y-10 right-1.5 w-px bg-gradient-to-b from-transparent via-[#E5C98B]/38 to-transparent"></span>
                <img
                    src="{{ asset('aset-tema/adat-jawa/sayap-wayang.webp') }}"
                    alt=""
                    loading="eager"
                    decoding="sync"
                    class="intro-jawa-sayap-kiri absolute bottom-[9%] -left-5 w-28 sm:w-32 opacity-72 drop-shadow-[0_10px_22px_rgba(0,0,0,0.65)]"
                >
            </div>

            {{-- PINTU GEBYOK KANAN (SIMETRIS CERMIN) --}}
            <div
                class="intro-panel-kanan intro-jawa-pintu pointer-events-none absolute inset-y-0 right-0 w-1/2 overflow-hidden"
                style="background: linear-gradient(180deg, #351D10 0%, #201008 48%, #130804 100%); border-left: 1px solid rgba(229, 201, 139, 0.45);"
            >
                <img
                    src="{{ asset('aset-tema/adat-jawa/motif-kawung-atas.webp') }}"
                    alt=""
                    loading="eager"
                    decoding="sync"
                    class="absolute top-0 right-0 w-[200%] max-w-none h-11 sm:h-12 object-cover object-bottom opacity-32 intro-jawa-mask-atas"
                >
                <img
                    src="{{ asset('aset-tema/adat-jawa/motif-kawung-bawah.webp') }}"
                    alt=""
                    loading="eager"
                    decoding="sync"
                    class="absolute bottom-0 right-0 w-[200%] max-w-none h-11 sm:h-12 object-cover object-top opacity-30 intro-jawa-mask-bawah"
                >
                <div class="absolute inset-y-4 right-3.5 left-0 rounded-r-xl border-y border-r border-[#E5C98B]/24">
                    <span class="absolute -top-[1px] -right-[1px] h-6 w-6 rounded-tr-lg border-t-2 border-r-2 border-[#E5C98B]/85"></span>
                    <span class="absolute -bottom-[1px] -right-[1px] h-6 w-6 rounded-br-lg border-b-2 border-r-2 border-[#E5C98B]/85"></span>
                </div>
                <span class="absolute inset-y-10 left-1.5 w-px bg-gradient-to-b from-transparent via-[#E5C98B]/38 to-transparent"></span>
                <img
                    src="{{ asset('aset-tema/adat-jawa/sayap-wayang.webp') }}"
                    alt=""
                    loading="eager"
                    decoding="sync"
                    class="intro-jawa-sayap-kanan absolute bottom-[9%] -right-5 w-28 sm:w-32 opacity-72 drop-shadow-[0_10px_22px_rgba(0,0,0,0.65)]"
                >
            </div>

            {{-- PENDAR CAHAYA BLENCONG & DEBU PRADA EMAS --}}
            <div class="intro-pendar pointer-events-none absolute inset-0 overflow-hidden z-10">
                <div
                    class="intro-jawa-halo absolute inset-0"
                    style="background: radial-gradient(circle at 50% 47%, rgba(235, 198, 118, 0.30) 0%, rgba(176, 124, 48, 0.11) 36%, transparent 66%);"
                ></div>
                <div class="intro-jawa-sinar absolute -top-24 left-[18%] w-36 h-[135%] bg-gradient-to-b from-[#FFF3C4]/22 via-[#E5C98B]/8 to-transparent blur-2xl"></div>
                @foreach ([
                    ['bottom: 16%; left: 18%;', 'w-1.5 h-1.5', '0.1s'],
                    ['bottom: 26%; right: 20%;', 'w-2 h-2', '0.5s'],
                    ['bottom: 38%; left: 14%;', 'w-1.5 h-1.5', '1.1s'],
                    ['bottom: 44%; right: 15%;', 'w-1.5 h-1.5', '0.8s'],
                    ['bottom: 22%; left: 48%;', 'w-1.5 h-1.5', '1.4s'],
                    ['bottom: 62%; left: 26%;', 'w-1 h-1', '0.3s'],
                    ['bottom: 60%; right: 26%;', 'w-1 h-1', '1.2s'],
                ] as [$posisiDebu, $ukuranDebu, $jedaDebu])
                    <span
                        class="intro-jawa-debu absolute rounded-full {{ $ukuranDebu }} bg-[#F7E7B8] shadow-[0_0_10px_rgba(235,198,118,0.95)]"
                        style="{{ $posisiDebu }} animation-delay: {{ $jedaDebu }};"
                    ></span>
                @endforeach
            </div>

            {{-- SILUET GUNUNGAN BAYANGAN KELIR DI BELAKANG BABAK 2 --}}
            <div class="intro-pusat pointer-events-none absolute inset-0 z-[12] flex items-center justify-center">
                <img
                    src="{{ asset('aset-tema/adat-jawa/gunungan-pembuka.webp') }}"
                    alt=""
                    loading="eager"
                    decoding="sync"
                    class="intro-jawa-watermark w-60 sm:w-64 select-none drop-shadow-[0_0_32px_rgba(229,193,115,0.28)]"
                >
            </div>

            {{-- BABAK 1 (0.08s - 1.65s): TANCEP KAYON GUNUNGAN AGUNG + TAJUK PAWIWAHAN --}}
            <div class="intro-pusat intro-jawa-babak-1 pointer-events-none absolute inset-0 z-20 flex flex-col items-center justify-center px-8 text-center">
                <div class="relative mb-5 flex items-center justify-center">
                    <span
                        class="absolute h-44 w-44 rounded-full blur-2xl opacity-75"
                        style="background: radial-gradient(circle, rgba(235, 198, 118, 0.36) 0%, transparent 70%);"
                    ></span>
                    <img
                        src="{{ asset('aset-tema/adat-jawa/gunungan-pembuka.webp') }}"
                        alt=""
                        loading="eager"
                        decoding="sync"
                        class="intro-jawa-gunungan relative w-36 sm:w-40 drop-shadow-[0_14px_34px_rgba(0,0,0,0.75)]"
                    >
                </div>

                <div class="intro-jawa-tajuk-1 space-y-1.5">
                    <p class="intro-jawa-eyebrow text-[10px] sm:text-[11px] font-semibold uppercase text-[#E5C98B]">
                        Pawiwahan Ageng
                    </p>
                    <p class="font-kaligrafi text-[1.95rem] sm:text-[2.2rem] leading-none text-[#FFF4D6] drop-shadow-[0_3px_14px_rgba(0,0,0,0.65)]">
                        The Wedding of
                    </p>
                </div>
            </div>

            {{-- BABAK 2 (1.50s - 3.45s): BINGKAI UKIRAN EMAS KERATON + MONOGRAM + NAMA MEMPELAI --}}
            <div class="intro-pusat intro-jawa-babak-2 relative z-20 flex flex-col items-center justify-center px-6 text-center">
                <div class="intro-jawa-medali relative w-[266px] sm:w-[292px] flex items-center justify-center">
                    {{-- Lapisan Beludru Sogan Gelap di Dalam Rongga Oval Ukiran --}}
                    <div
                        class="absolute inset-x-[13%] inset-y-[10%] rounded-[50%]"
                        style="background: radial-gradient(ellipse at 50% 42%, rgba(56, 30, 16, 0.90) 0%, rgba(27, 13, 6, 0.96) 72%, rgba(18, 8, 4, 0.98) 100%); box-shadow: inset 0 0 28px rgba(229, 201, 139, 0.16), 0 24px 48px rgba(0, 0, 0, 0.68);"
                    ></div>

                    {{-- Bingkai Ukiran Emas Keraton Asli --}}
                    <img
                        src="{{ asset('aset-tema/adat-jawa/bingkai-ukiran.webp') }}"
                        alt=""
                        loading="eager"
                        decoding="sync"
                        class="relative z-10 w-full h-auto block drop-shadow-[0_16px_38px_rgba(0,0,0,0.78)]"
                    >

                    {{-- Mahkota Gunungan & Mawar Merah di Puncak Bingkai --}}
                    <img
                        src="{{ asset('aset-tema/adat-jawa/ornamen-gunungan.webp') }}"
                        alt=""
                        loading="eager"
                        decoding="sync"
                        class="intro-jawa-mahkota absolute -top-5 inset-x-0 mx-auto z-20 w-14 sm:w-16 drop-shadow-[0_6px_14px_rgba(0,0,0,0.75)]"
                    >

                    {{-- Isi Pusat Oval: Monogram Foil Emas + Garis Berlian + Nama Mempelai + Tanggal --}}
                    <div class="absolute inset-0 z-20 flex flex-col items-center justify-center px-12 pt-5 pb-3 text-center">
                        <div class="intro-jawa-monogram flex items-baseline justify-center gap-1.5 font-serif text-[3rem] sm:text-[3.35rem] font-semibold leading-none tracking-[0.06em]">
                            <span class="intro-jawa-foil">{{ $inisialPriaIntro }}</span>
                            <span class="font-kaligrafi text-[2.2rem] sm:text-[2.45rem] font-normal text-[#E5C98B] drop-shadow">&amp;</span>
                            <span class="intro-jawa-foil">{{ $inisialWanitaIntro }}</span>
                        </div>

                        <div class="intro-jawa-pemisah my-3 flex items-center justify-center gap-2 w-28">
                            <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#E5C98B]/85"></span>
                            <span class="h-1.5 w-1.5 rotate-45 bg-[#F3E5AB] shadow-[0_0_8px_rgba(243,229,171,0.85)]"></span>
                            <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#E5C98B]/85"></span>
                        </div>

                        <p class="intro-jawa-nama font-serif text-[1.4rem] sm:text-[1.6rem] font-semibold leading-[1.15] tracking-[0.04em] text-[#FFFBF4] drop-shadow-[0_2px_10px_rgba(0,0,0,0.75)]">
                            {{ $undangan->nama_panggilan_pria }}
                            <span class="font-kaligrafi font-normal text-[#E5C98B] mx-0.5">&amp;</span>
                            {{ $undangan->nama_panggilan_wanita }}
                        </p>

                        <p class="intro-jawa-tanggal mt-2 text-[9.5px] sm:text-[10.5px] font-medium uppercase tracking-[0.3em] text-[#E5C98B]/92">
                            {{ $tanggalIntro }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- PETUNJUK HALUS LEWATI --}}
            <span class="intro-petunjuk pointer-events-none absolute bottom-7 z-20 text-[9.5px] uppercase tracking-[0.28em] text-[#F3E5AB]/60">
                Ketuk untuk melewati
            </span>
        </div>
    @else
    <div class="relative w-full h-full flex flex-col items-center justify-center overflow-hidden">
        {{-- LAPISAN LATAR (BELAH DUA PINTU ATAU KANVAS PENUH) --}}
        @if ($adalahBelahTengah)
            <div
                class="intro-panel-kiri pointer-events-none absolute inset-y-0 left-0 w-1/2"
                style="background: {{ $gayaIntro['panel'] }}; border-right: 1px solid {{ $gayaIntro['aksen_lembut'] }};"
            ></div>
            <div
                class="intro-panel-kanan pointer-events-none absolute inset-y-0 right-0 w-1/2"
                style="background: {{ $gayaIntro['panel'] }}; border-left: 1px solid {{ $gayaIntro['aksen_lembut'] }};"
            ></div>
        @else
            <div
                class="intro-panel-penuh pointer-events-none absolute inset-0"
                style="background: {{ $gayaIntro['bg'] }};"
            ></div>
        @endif

        {{-- PENDAR CAHAYA AMBIENT TENGAH (BERNAPAS HALUS) --}}
        <div
            class="intro-pendar pointer-events-none absolute inset-0"
            style="background: radial-gradient(circle at 50% 46%, {{ $gayaIntro['aksen_lembut'] }} 0%, transparent 62%);"
        ></div>

        {{-- BINGKAI ARSITEKTUR KHAS TIAP TEMA --}}
        @if ($gayaIntro['bingkai'] === 'sudut-keraton')
            <div class="intro-bingkai pointer-events-none absolute inset-4 rounded-xl border" style="border-color: var(--intro-aksen-lembut);">
                <span class="absolute -top-[1px] -left-[1px] h-6 w-6 rounded-tl-lg border-t-2 border-l-2" style="border-color: var(--intro-aksen);"></span>
                <span class="absolute -top-[1px] -right-[1px] h-6 w-6 rounded-tr-lg border-t-2 border-r-2" style="border-color: var(--intro-aksen);"></span>
                <span class="absolute -bottom-[1px] -left-[1px] h-6 w-6 rounded-bl-lg border-b-2 border-l-2" style="border-color: var(--intro-aksen);"></span>
                <span class="absolute -bottom-[1px] -right-[1px] h-6 w-6 rounded-br-lg border-b-2 border-r-2" style="border-color: var(--intro-aksen);"></span>
            </div>
        @elseif (in_array($gayaIntro['bingkai'], ['arch-priangan', 'arch-konservatori', 'mihrab-syari'], true))
            <div class="intro-bingkai pointer-events-none absolute inset-4 rounded-t-[13rem] rounded-b-[2rem] border" style="border-color: var(--intro-aksen-lembut);">
                <div class="absolute inset-2 rounded-t-[12.4rem] rounded-b-[1.5rem] border opacity-55" style="border-color: var(--intro-aksen-lembut);"></div>
            </div>
        @elseif ($gayaIntro['bingkai'] === 'art-deco')
            <div class="intro-bingkai pointer-events-none absolute inset-4 border" style="border-color: var(--intro-aksen-lembut);">
                <div class="absolute inset-2 border" style="border-color: var(--intro-aksen);"></div>
                <span class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 h-3 w-3 rotate-45 border bg-[#0B0B0F]" style="border-color: var(--intro-aksen);"></span>
                <span class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2 h-3 w-3 rotate-45 border bg-[#0B0B0F]" style="border-color: var(--intro-aksen);"></span>
            </div>
        @elseif ($gayaIntro['bingkai'] === 'katedral-ganda')
            <div class="intro-bingkai pointer-events-none absolute inset-4 rounded-t-[11rem] rounded-b-2xl border-2" style="border-color: var(--intro-aksen-lembut);">
                <div class="absolute inset-2.5 rounded-t-[10.2rem] rounded-b-xl border" style="border-color: var(--intro-aksen-lembut);"></div>
            </div>
        @elseif ($gayaIntro['bingkai'] === 'swiss-editorial')
            <div class="intro-bingkai pointer-events-none absolute inset-5 border-y flex flex-col justify-between py-2.5" style="border-color: var(--intro-aksen-lembut);">
                <div class="flex items-center justify-between text-[9px] uppercase tracking-[0.28em] opacity-65">
                    <span>Vol. 01</span>
                    <span>SesiTemu Editorial</span>
                    <span>{{ $tahunIntro }}</span>
                </div>
                <div class="flex items-center justify-between text-[9px] uppercase tracking-[0.28em] opacity-55">
                    <span>Invitation</span>
                    <span>{{ $tanggalIntro }}</span>
                </div>
            </div>
        @elseif ($gayaIntro['bingkai'] === 'orbit-bintang')
            <div class="intro-bingkai pointer-events-none absolute inset-4 rounded-t-[12rem] rounded-b-[2rem] border" style="border-color: var(--intro-aksen-lembut);">
                <span class="absolute top-[16%] left-[18%] h-1.5 w-1.5 rounded-full" style="background: var(--intro-aksen); box-shadow: 0 0 10px var(--intro-aksen);"></span>
                <span class="absolute top-[24%] right-[20%] h-1 w-1 rounded-full opacity-80" style="background: var(--intro-aksen);"></span>
                <span class="absolute bottom-[22%] left-[22%] h-1 w-1 rounded-full opacity-75" style="background: var(--intro-aksen);"></span>
                <span class="absolute bottom-[18%] right-[18%] h-1.5 w-1.5 rounded-full" style="background: var(--intro-aksen); box-shadow: 0 0 10px var(--intro-aksen);"></span>
            </div>
        @else
            <div class="intro-bingkai pointer-events-none absolute inset-4 rounded-[2rem] border" style="border-color: var(--intro-aksen-lembut);"></div>
        @endif

        {{-- KONTEN PUSAT KOREOGRAFI PEMBUKA --}}
        <div class="intro-pusat relative z-20 px-8 text-center flex flex-col items-center justify-center max-w-[340px]">
            {{-- TAHAP 1: LAMBANG / ORNAMEN KHAS TEMA --}}
            <div class="intro-tahap-1 mb-4">
                @if ($gayaIntro['lambang'] === 'gambar' && $gayaIntro['gambar'])
                    <img
                        src="{{ $gayaIntro['gambar'] }}"
                        alt=""
                        class="{{ $gayaIntro['gambar_class'] }} mx-auto drop-shadow-[0_6px_16px_rgba(0,0,0,0.35)]"
                    >
                @elseif ($gayaIntro['lambang'] === 'rub-el-hizb')
                    <svg class="w-11 h-11 mx-auto" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="1.6" style="color: var(--intro-aksen);">
                        <rect x="16" y="16" width="32" height="32" />
                        <rect x="16" y="16" width="32" height="32" transform="rotate(45 32 32)" />
                        <circle cx="32" cy="32" r="5" fill="currentColor" opacity="0.3" />
                    </svg>
                @elseif ($gayaIntro['lambang'] === 'ranting-botani')
                    <svg class="w-14 h-9 mx-auto" viewBox="0 0 80 44" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" style="color: var(--intro-aksen);">
                        <path d="M12 34 C28 30 34 18 40 8 C46 18 52 30 68 34" />
                        <path d="M40 8 C35 16 28 20 20 19 C24 26 32 28 40 24" />
                        <path d="M40 8 C45 16 52 20 60 19 C56 26 48 28 40 24" />
                        <circle cx="40" cy="6" r="2.2" fill="currentColor" />
                    </svg>
                @elseif ($gayaIntro['lambang'] === 'kipas-deco')
                    <svg class="w-16 h-9 mx-auto" viewBox="0 0 96 48" fill="none" stroke="currentColor" stroke-width="1.4" style="color: var(--intro-aksen);">
                        <path d="M8 42 L48 10 L88 42" />
                        <path d="M22 42 L48 18 L74 42" />
                        <path d="M36 42 L48 28 L60 42" />
                        <line x1="48" y1="6" x2="48" y2="42" />
                        <circle cx="48" cy="6" r="2.5" fill="currentColor" />
                    </svg>
                @elseif ($gayaIntro['lambang'] === 'mahkota-royal')
                    <svg class="w-12 h-9 mx-auto" viewBox="0 0 64 44" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" style="color: var(--intro-aksen);">
                        <path d="M10 34 L16 14 L26 24 L32 10 L38 24 L48 14 L54 34 Z" />
                        <line x1="12" y1="38" x2="52" y2="38" />
                        <circle cx="32" cy="7" r="2" fill="currentColor" />
                    </svg>
                @elseif ($gayaIntro['lambang'] === 'editorial-masthead')
                    <div class="inline-flex items-center gap-2.5 text-[9.5px] uppercase tracking-[0.34em] opacity-80">
                        <span class="h-px w-7 bg-current opacity-50"></span>
                        <span>Issue No. 01</span>
                        <span class="h-px w-7 bg-current opacity-50"></span>
                    </div>
                @endif
            </div>

            {{-- BISMILLAH KHUSUS TEMA ISLAMI --}}
            @if ($gayaIntro['bismillah'])
                <p class="intro-tahap-2 text-lg sm:text-xl mb-1.5" style="font-family: 'Amiri', serif; color: var(--intro-aksen);">
                    بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                </p>
            @endif

            {{-- TAHAP 2: EYEBROW / TAGLINE --}}
            <p
                class="intro-tahap-2 text-[10px] sm:text-[11px] font-semibold uppercase tracking-[0.36em]"
                style="color: var(--intro-aksen);"
            >
                {{ $gayaIntro['eyebrow'] }}
            </p>

            {{-- TAHAP 3: MONOGRAM KHAS TEMA --}}
            <div class="intro-tahap-3 my-5 flex items-center justify-center">
                @if ($gayaIntro['monogram'] === 'berlian')
                    <div class="relative h-24 w-24 flex items-center justify-center">
                        <span class="absolute inset-2 rotate-45 border" style="border-color: var(--intro-aksen);"></span>
                        <span class="absolute inset-3.5 rotate-45 border opacity-45" style="border-color: var(--intro-aksen);"></span>
                        <div class="relative z-10 flex items-baseline gap-1.5 font-serif text-3xl font-semibold tracking-wider">
                            <span>{{ $inisialPriaIntro }}</span>
                            <span class="font-kaligrafi text-2xl font-normal" style="color: var(--intro-aksen);">&amp;</span>
                            <span>{{ $inisialWanitaIntro }}</span>
                        </div>
                    </div>
                @elseif ($gayaIntro['monogram'] === 'orbit-celestial')
                    <div class="relative h-24 w-24 flex items-center justify-center">
                        <span class="absolute inset-0 rounded-full border border-dashed intro-putar-pelan" style="border-color: var(--intro-aksen-lembut);"></span>
                        <span class="absolute inset-2 rounded-full border" style="border-color: var(--intro-aksen);"></span>
                        <div class="relative z-10 flex items-baseline gap-1.5 font-serif text-3xl font-semibold tracking-wider">
                            <span>{{ $inisialPriaIntro }}</span>
                            <span class="font-kaligrafi text-2xl font-normal" style="color: var(--intro-aksen);">&amp;</span>
                            <span>{{ $inisialWanitaIntro }}</span>
                        </div>
                    </div>
                @elseif ($gayaIntro['monogram'] === 'bintang-islami')
                    <div class="relative h-24 w-24 flex items-center justify-center">
                        <span class="absolute inset-2.5 border opacity-75" style="border-color: var(--intro-aksen);"></span>
                        <span class="absolute inset-2.5 rotate-45 border opacity-75" style="border-color: var(--intro-aksen);"></span>
                        <div class="relative z-10 flex items-baseline gap-1.5 font-serif text-3xl font-bold tracking-wider">
                            <span>{{ $inisialPriaIntro }}</span>
                            <span class="font-kaligrafi text-2xl font-normal" style="color: var(--intro-aksen);">&amp;</span>
                            <span>{{ $inisialWanitaIntro }}</span>
                        </div>
                    </div>
                @elseif ($gayaIntro['monogram'] === 'editorial-slash')
                    <div class="flex items-center gap-4 ed-serif font-serif text-5xl tracking-[0.12em]">
                        <span>{{ $inisialPriaIntro }}</span>
                        <span class="h-10 w-px rotate-[22deg] opacity-55" style="background: var(--intro-aksen);"></span>
                        <span>{{ $inisialWanitaIntro }}</span>
                    </div>
                @elseif ($gayaIntro['monogram'] === 'segel-lilin')
                    <div class="relative h-24 w-24 rounded-full border-2 flex items-center justify-center shadow-inner" style="border-color: var(--intro-aksen);">
                        <span class="absolute inset-1.5 rounded-full border border-dashed opacity-70" style="border-color: var(--intro-aksen);"></span>
                        <div class="relative z-10 flex items-baseline gap-1.5 font-serif text-3xl font-semibold tracking-wider">
                            <span>{{ $inisialPriaIntro }}</span>
                            <span class="font-kaligrafi text-2xl font-normal" style="color: var(--intro-aksen);">&amp;</span>
                            <span>{{ $inisialWanitaIntro }}</span>
                        </div>
                    </div>
                @else
                    <div class="relative h-24 w-24 rounded-full border flex items-center justify-center" style="border-color: var(--intro-aksen);">
                        <span class="absolute -inset-1.5 rounded-full border opacity-35" style="border-color: var(--intro-aksen);"></span>
                        <div class="relative z-10 flex items-baseline gap-1.5 font-serif text-3xl font-semibold tracking-wider">
                            <span>{{ $inisialPriaIntro }}</span>
                            <span class="font-kaligrafi text-2xl font-normal" style="color: var(--intro-aksen);">&amp;</span>
                            <span>{{ $inisialWanitaIntro }}</span>
                        </div>
                    </div>
                @endif
            </div>

            {{-- TAHAP 4: NAMA MEMPELAI + GARIS PEMISAH + TANGGAL --}}
            <div class="intro-tahap-4 space-y-2.5">
                <p class="{{ $gayaIntro['nama_class'] }} leading-tight">
                    {{ $undangan->nama_panggilan_pria }}
                    <span class="font-kaligrafi normal-case font-normal mx-1" style="color: var(--intro-aksen);">&amp;</span>
                    {{ $undangan->nama_panggilan_wanita }}
                </p>

                <div class="intro-garis mx-auto h-px w-28" style="background: linear-gradient(90deg, transparent, var(--intro-aksen), transparent);"></div>

                <p class="text-[10.5px] font-medium uppercase tracking-[0.3em] opacity-80">
                    {{ $tanggalIntro }}
                </p>
            </div>
        </div>

        {{-- PETUNJUK HALUS LEWATI --}}
        <span class="intro-petunjuk pointer-events-none absolute bottom-7 z-20 text-[9.5px] uppercase tracking-[0.26em] opacity-55">
            Ketuk untuk melewati
        </span>
    </div>
    @endif
</div>

<script>
    (function () {
        const el = document.querySelector('[data-intro-pembuka]');
        if (!el) return;

        const kurangiGerak = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (kurangiGerak) {
            el.style.display = 'none';
            return;
        }

        const durasiOtomatis = Number.parseInt(el.dataset.introDurasi || '2350', 10) || 2350;
        const durasiKeluar = Number.parseInt(el.dataset.introKeluarMs || '820', 10) || 820;

        let selesai = false;
        let timerOtomatis = null;

        function tutupIntro() {
            if (selesai) return;
            selesai = true;
            if (timerOtomatis) {
                window.clearTimeout(timerOtomatis);
                timerOtomatis = null;
            }
            el.classList.add('intro-keluar');
            window.setTimeout(() => {
                el.classList.add('intro-selesai');
                el.style.display = 'none';
            }, durasiKeluar);
        }

        el.addEventListener('click', tutupIntro, { once: true });
        timerOtomatis = window.setTimeout(tutupIntro, durasiOtomatis);
    })();
</script>
@endif
