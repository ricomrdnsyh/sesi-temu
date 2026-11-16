@props([
    'undangan',
    'namaTamu',
    'modeDemo' => false,
    'modePratinjau' => false,
    'slugTema' => 'rustic-floral',
    'tierBawaan' => 'basic',
    'gayaTataLetak' => 'klasik',
    'animasiSampul' => 'geser-atas',
    'gayaGaleri' => 'grid',
    'tampilMarquee' => false,
    'tampilScrollProgress' => false,
    'tampilTimelineCerita' => false,
    'bismillahHeader' => false,
    'gelap' => false,
    'gelapSampul' => null,
    'kelasTeksSampul' => null,
    'kelasBody' => 'bg-[#FDFBF7] text-[#1F2937]',
    'kelasAksen' => 'text-[#BFA15F]',
    'kelasSubAksen' => 'text-[#4B6358]',
    'kelasKartu' => 'bg-white/90 backdrop-blur-md border border-[#BFA15F]/35 text-[#1F2937]',
    'kelasTombol' => 'bg-[#4B6358] text-white hover:bg-[#3A4D44]',
    'kelasBadge' => 'bg-[#BFA15F]/15 text-[#BFA15F] border border-[#BFA15F]/30',
    'kelasBatas' => 'border-[#BFA15F]/35',
    'kelasTirai' => null,
    'kelasProgres' => 'bg-gradient-to-r from-[#BFA15F] via-[#F3E5AB] to-[#BFA15F]',
    'subjudulPanggung' => 'The Wedding Of',
    'taglineSampul' => 'Undangan Pernikahan',
    'sapaanSampul' => 'Kepada Yth. Bapak/Ibu/Saudara/i',
    'sapaanHero' => 'Undangan Pernikahan',
    'labelPutra' => 'Putra dari',
    'labelPutri' => 'Putri dari',
    'labelAcara' => 'Rangkaian Acara',
    'subLabelAcara' => 'Save The Date',
    'labelCerita' => 'Cerita Cinta',
    'subLabelCerita' => 'Kisah Kami',
    'labelGaleri' => 'Potret Kebahagiaan',
    'subLabelGaleri' => 'Galeri Momen',
    'footerTeks' => 'SesiTemu.id',
    'ornamenUrl' => null,
    'efekMotion' => 'kilau',
    'bingkaiFoto' => 'bulat',
    'polaTekstur' => 'floral',
    'modeMonokrom' => false,
    'editionHeader' => null,
])

@php
    $latarUtamaUrl = asset("aset-tema/{$slugTema}/latar-utama.webp");
    $acaraPertama = $undangan->daftarAcara->first();
    $tanggalTitik = $acaraPertama?->tanggal_acara?->format('d . m . y') ?? now()->format('d . m . y');
    $tanggalLengkap = $acaraPertama?->tanggal_acara
        ? $acaraPertama->tanggal_acara->locale('id')->translatedFormat('l, d F Y')
        : now()->locale('id')->translatedFormat('l, d F Y');
    $hashtagPasangan = '#' . \Illuminate\Support\Str::studly($undangan->nama_panggilan_pria . $undangan->nama_panggilan_wanita) . 'Together';
    $tanpaFoto = $undangan->modeTanpaFoto();
    $urlFotoSampul = $tanpaFoto ? null : $undangan->urlFotoSampul();
    $pakaiFotoSampul = ! $tanpaFoto && ! empty($urlFotoSampul);

    $tierAktif = $undangan->tema?->tierKode() ?? $tierBawaan;
    $isEksklusif = $tierBawaan === 'eksklusif' || $tierAktif === 'eksklusif';
    $sudutEditorial = $gayaTataLetak === 'editorial';
    $radiusKartuBesar = $sudutEditorial ? 'rounded-none' : 'rounded-3xl';
    $radiusKartuSedang = $sudutEditorial ? 'rounded-none' : 'rounded-2xl';
    $radiusTombol = $sudutEditorial ? 'rounded-none' : 'rounded-full';
    $ekstraKartu = $isEksklusif ? 'efek-shimmer-kartu' : '';

    $polaDataUri = match ($polaTekstur) {
        'batik' => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='64' height='64' viewBox='0 0 64 64'%3E%3Cg fill='none' stroke='%23BFA15F' stroke-opacity='0.14' stroke-width='1'%3E%3Ccircle cx='32' cy='32' r='22'/%3E%3Ccircle cx='0' cy='0' r='22'/%3E%3Ccircle cx='64' cy='0' r='22'/%3E%3Ccircle cx='0' cy='64' r='22'/%3E%3Ccircle cx='64' cy='64' r='22'/%3E%3Ccircle cx='32' cy='32' r='4'/%3E%3C/g%3E%3C/svg%3E",
        'arabesque' => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Cg fill='none' stroke='%23D9B664' stroke-opacity='0.14' stroke-width='1'%3E%3Cpath d='M30 2 L58 30 L30 58 L2 30 Z'/%3E%3Crect x='11' y='11' width='38' height='38'/%3E%3Ccircle cx='30' cy='30' r='6'/%3E%3C/g%3E%3C/svg%3E",
        'deco' => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='56' height='56' viewBox='0 0 56 56'%3E%3Cg fill='none' stroke='%23D4AF37' stroke-opacity='0.12' stroke-width='1'%3E%3Cpath d='M0 28 H56 M28 0 V56'/%3E%3Cpath d='M28 6 L50 28 L28 50 L6 28 Z'/%3E%3C/g%3E%3C/svg%3E",
        'editorial' => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='48' height='48' viewBox='0 0 48 48'%3E%3Cg fill='none' stroke='%2318181B' stroke-opacity='0.06' stroke-width='1'%3E%3Cpath d='M48 0 V48 M0 48 H48'/%3E%3C/g%3E%3C/svg%3E",
        default => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='72' height='72' viewBox='0 0 72 72'%3E%3Cg fill='none' stroke='%23BFA15F' stroke-opacity='0.12' stroke-width='1'%3E%3Ccircle cx='36' cy='36' r='26'/%3E%3Cpath d='M36 10 Q46 26 36 36 Q26 26 36 10 Z'/%3E%3Cpath d='M36 62 Q46 46 36 36 Q26 46 36 62 Z'/%3E%3Cpath d='M10 36 Q26 26 36 36 Q26 46 10 36 Z'/%3E%3Cpath d='M62 36 Q46 26 36 36 Q46 46 62 36 Z'/%3E%3C/g%3E%3C/svg%3E",
    };

    $sampulGelap = $gelapSampul ?? $gelap;
    $teksSampul = $kelasTeksSampul ?? ($sampulGelap ? 'text-white drop-shadow-md' : 'text-current');
    $tiraiPanel = $kelasTirai ?? ($sampulGelap ? 'bg-[#0C0C10]/95 border-[#D4AF37]/50' : 'bg-[#FAF5EB]/95 border-[#BFA15F]/50');

    $overlayPanggung = $sampulGelap
        ? 'bg-gradient-to-b from-black/45 via-black/45 to-black/80'
        : 'bg-gradient-to-b from-black/35 via-black/30 to-black/65';

    $overlaySampul = $sampulGelap
        ? 'bg-gradient-to-b from-black/70 via-black/35 to-black/85'
        : 'bg-gradient-to-b from-[#FFFDF8]/78 via-[#FFFDF8]/22 to-black/55';

    $sampulPakaiModeGelap = $pakaiFotoSampul || $sampulGelap;
    $gambarSampul = $pakaiFotoSampul ? $urlFotoSampul : $latarUtamaUrl;
    $altSampul = $pakaiFotoSampul
        ? "Foto Sampul {$undangan->nama_panggilan_pria} & {$undangan->nama_panggilan_wanita}"
        : "Sampul {$undangan->tema?->nama_tema}";
    $kelasImgSampul = $pakaiFotoSampul ? 'object-cover object-top' : 'object-cover object-center';
    $overlaySampulAktif = $pakaiFotoSampul
        ? 'bg-gradient-to-b from-black/80 via-black/15 to-black/85'
        : $overlaySampul;
    $teksGerbangSampul = $pakaiFotoSampul ? 'text-white drop-shadow-md' : $teksSampul;

    $heroBingkaiClass = match ($gayaTataLetak) {
        'editorial' => 'rounded-none border',
        'mihrab', 'celestial' => 'rounded-t-[13rem] rounded-b-3xl border-2',
        'katedral' => 'rounded-t-[13rem] rounded-b-3xl border-2 ring-4 ring-offset-4 ring-offset-transparent ring-[#9E7B4F]/25',
        'artdeco' => 'rounded-2xl border-2 ring-1 ring-inset ring-[#D4AF37]/45',
        'taman' => 'rounded-t-[11rem] rounded-b-3xl border-2 ring-1 ring-[#C8A464]/35',
        'keraton', 'priangan' => 'rounded-t-[9rem] rounded-b-3xl border-2 ring-1 ring-inset ring-[#D4AF37]/30',
        default => 'rounded-t-[10rem] rounded-b-3xl border-2',
    };

    $haloMempelaiClass = $bingkaiFoto === 'katedral'
        ? 'rounded-t-full rounded-b-3xl border border-dashed border-[#D4AF37]/50 animasi-kilau'
        : 'rounded-full border border-dashed border-[#D4AF37]/50 animasi-orbit';

    $adalahGerbangBelah = in_array($animasiSampul, ['belah-pintu-3d', 'tirai-portal-3d', 'belah-pintu', 'tirai-mewah'], true);
    $adalahLipatKatedral = in_array($animasiSampul, ['lipat-katedral-3d', 'zoom-elegan'], true);
    $adalahHalamanEditorial = in_array($animasiSampul, ['halaman-editorial-3d', 'editorial-tirai'], true);
    $ornamenGantung = $gayaTataLetak === 'celestial';
    $ukuranOrnamenPanggung = $ornamenGantung ? 'w-20 xl:w-24' : 'w-40 xl:w-52';
    $ukuranOrnamenMobile = $ornamenGantung ? 'w-11 sm:w-12' : 'w-24 sm:w-28';
@endphp

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    @include('komponen-undangan.meta-opengraph')
</head>
<body
    x-data="temaUndangan()"
    :class="undanganTerbuka ? 'overflow-x-hidden' : 'overflow-hidden h-screen'"
    class="{{ $kelasBody }} antialiased relative"
>
    @include('komponen-undangan.bar-pratinjau-demo')

    <div class="min-h-screen w-full lg:flex">
        {{-- PANGGUNG VISUAL DESKTOP KIRI (DIORAMA 3D 5-LAPIS) --}}
        <aside data-panggung-3d class="hidden lg:flex lg:flex-1 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d">
            {{-- Layer Z-0: Latar Jauh --}}
            <div class="lapis-3d absolute -inset-4 pointer-events-none" style="--depth: -14px; --pz: -40px;">
                <img
                    src="{{ $latarUtamaUrl }}"
                    alt="Ilustrasi {{ $undangan->tema?->nama_tema }}"
                    class="w-full h-full object-cover object-center scale-105 animasi-nafas {{ $modeMonokrom ? 'grayscale' : '' }}"
                >
            </div>
            <div class="absolute inset-0 {{ $overlayPanggung }}"></div>
            {{-- Layer Z-1: Aura Cahaya Volumetrik --}}
            <div aria-hidden="true" class="pointer-events-none absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[30rem] h-[30rem] rounded-full bg-[#F3E5AB]/10 blur-3xl"></div>

            @if ($ornamenUrl)
                {{-- Layer Z-3: Ornamen Foreground Transparan 4 Sudut --}}
                <div class="lapis-3d pointer-events-none absolute -top-2 {{ $ornamenGantung ? 'left-6' : '-left-3' }} z-20" style="--depth: 26px; --pz: 42px;">
                    <img src="{{ $ornamenUrl }}" alt="" class="{{ $ukuranOrnamenPanggung }} opacity-90 drop-shadow-[0_18px_30px_rgba(0,0,0,0.45)] animasi-ayun-3d">
                </div>
                <div class="lapis-3d pointer-events-none absolute -top-2 {{ $ornamenGantung ? 'right-6' : '-right-3' }} z-20" style="--depth: 26px; --pz: 42px;">
                    <img src="{{ $ornamenUrl }}" alt="" class="{{ $ukuranOrnamenPanggung }} opacity-90 drop-shadow-[0_18px_30px_rgba(0,0,0,0.45)] animasi-ayun-3d-balik">
                </div>
                @if (! $ornamenGantung)
                    <div class="lapis-3d pointer-events-none absolute -bottom-5 -left-4 z-20" style="--depth: 34px; --pz: 56px;">
                        <img src="{{ $ornamenUrl }}" alt="" class="w-36 xl:w-44 opacity-80 drop-shadow-[0_18px_30px_rgba(0,0,0,0.45)] rotate-12 animasi-ayun-3d">
                    </div>
                    <div class="lapis-3d pointer-events-none absolute -bottom-5 -right-4 z-20" style="--depth: 34px; --pz: 56px;">
                        <img src="{{ $ornamenUrl }}" alt="" class="w-36 xl:w-44 opacity-80 drop-shadow-[0_18px_30px_rgba(0,0,0,0.45)] -rotate-12 animasi-ayun-3d-balik">
                    </div>
                @endif
            @endif

            @if ($sudutEditorial)
                <div aria-hidden="true" class="pointer-events-none absolute inset-7 border border-white/30"></div>
                <div class="pointer-events-none absolute top-11 left-12 right-12 flex items-center justify-between text-[10px] uppercase tracking-[0.35em] text-white/80">
                    <span>Vol. 01 &bull; Monochrome</span>
                    <span>{{ $editionHeader ?? 'The Wedding Edition' }}</span>
                </div>
            @elseif ($isEksklusif)
                <div aria-hidden="true" class="pointer-events-none absolute inset-6 border border-[#F3E5AB]/25 rounded-3xl"></div>
                <div aria-hidden="true" class="pointer-events-none absolute top-12 right-12 w-24 h-24 flex items-center justify-center">
                    <div class="absolute inset-0 rounded-full border border-dashed border-[#F3E5AB]/45 animasi-orbit"></div>
                    <div class="absolute inset-2 rounded-full border border-[#D4AF37]/50 animasi-orbit-balik"></div>
                    <span class="font-serif text-sm font-bold tracking-widest text-[#F3E5AB]">{{ $undangan->inisialPria() }}&amp;{{ $undangan->inisialWanita() }}</span>
                </div>
            @elseif ($gayaTataLetak === 'katedral' || $gayaTataLetak === 'keraton' || $gayaTataLetak === 'priangan')
                <div aria-hidden="true" class="pointer-events-none absolute inset-6 border border-[#F3E5AB]/25 rounded-2xl"></div>
            @endif

            @include('komponen-undangan.lapisan-motion', ['efekMotion' => $efekMotion, 'konteks' => 'panggung'])

            {{-- Layer Z-2: Tipografi Pasangan Mengambang --}}
            <div class="lapis-3d relative z-10 w-full flex flex-col items-center justify-center text-center px-10 pb-20 xl:px-14 text-white" style="--depth: 10px; --pz: 24px;">
                <div class="max-w-xl space-y-3">
                    @if ($bismillahHeader)
                        <p class="text-base sm:text-lg text-[#F3E5AB]/95 tracking-wide drop-shadow" style="font-family: 'Amiri', serif;">
                            بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                        </p>
                    @endif
                    <p class="text-xs font-semibold uppercase tracking-[0.42em] text-[#F3E5AB] drop-shadow">
                        {{ $subjudulPanggung }}
                    </p>
                    <h2 class="font-serif text-5xl xl:text-6xl font-bold leading-tight drop-shadow-xl">
                        {{ $undangan->nama_panggilan_pria }}
                        <span class="font-kaligrafi font-normal text-[#F3E5AB]">&amp;</span>
                        {{ $undangan->nama_panggilan_wanita }}
                    </h2>
                    <div class="flex flex-wrap items-center justify-center gap-3 pt-1 text-xs font-medium uppercase tracking-[0.28em] text-white/90 drop-shadow">
                        <span>{{ $tanggalLengkap }}</span>
                        <span class="w-1 h-1 rounded-full bg-[#F3E5AB]"></span>
                        <span>{{ $hashtagPasangan }}</span>
                    </div>
                </div>
            </div>
        </aside>

        {{-- KOLOM UNDANGAN MOBILE-FIRST PORTRAIT --}}
        <div data-panggung-3d class="w-full lg:w-[445px] xl:w-[475px] shrink-0 min-h-screen relative overflow-x-clip shadow-2xl border-l {{ $kelasBatas }} panggung-3d">
            @if ($tampilScrollProgress)
                <div aria-hidden="true" x-show="undanganTerbuka" x-cloak class="fixed top-0 lg:left-auto lg:w-[445px] xl:w-[475px] left-0 right-0 z-[60] h-[3px] bg-black/15">
                    <div class="h-full transition-all duration-150 {{ $kelasProgres }}" :style="'width: ' + scrollPersen + '%'"></div>
                </div>
            @endif

            {{-- Tekstur Budaya / Botani --}}
            <div
                aria-hidden="true"
                class="pointer-events-none fixed top-0 bottom-0 right-0 w-full lg:w-[445px] xl:w-[475px] z-0"
                style="background-image: url(&quot;{{ $polaDataUri }}&quot;); background-repeat: repeat;"
            ></div>
            <img
                src="{{ $latarUtamaUrl }}"
                alt=""
                aria-hidden="true"
                class="pointer-events-none fixed top-0 bottom-0 right-0 w-full lg:w-[445px] xl:w-[475px] h-full object-cover {{ $gelap ? 'opacity-15' : 'opacity-10' }} {{ $modeMonokrom ? 'grayscale' : '' }} z-0"
            >

            @if ($ornamenUrl)
                <img src="{{ $ornamenUrl }}" alt="" class="pointer-events-none fixed {{ $ornamenGantung ? 'top-8 left-3 lg:left-auto lg:right-[385px] xl:right-[410px]' : 'top-8 left-0 lg:left-auto lg:right-[335px] xl:right-[360px]' }} {{ $ukuranOrnamenMobile }} opacity-80 z-20 drop-shadow-xl animasi-ayun-3d">
                @if (! $ornamenGantung)
                    <img src="{{ $ornamenUrl }}" alt="" class="pointer-events-none fixed bottom-0 right-0 {{ $ukuranOrnamenMobile }} opacity-75 z-20 drop-shadow-xl animasi-ayun-3d-balik">
                @endif
            @endif

            {{-- COVER GATE DENGAN ANIMASI BUKA 3D SESUAI TIER & TEMA --}}
            <section
                class="gerbang-3d fixed inset-0 lg:left-auto lg:w-[445px] xl:w-[475px] z-40 flex flex-col justify-between overflow-hidden {{ !empty($modeDemo) ? 'pt-14' : '' }} {{ $adalahLipatKatedral ? 'lipat-katedral-3d' : ($adalahHalamanEditorial ? 'halaman-editorial-3d' : 'transition-all duration-1000 ease-in-out') }}"
                :class="undanganTerbuka ? 'pointer-events-none' : ''"
                :style="undanganTerbuka ? '{{
                    match (true) {
                        $adalahLipatKatedral => 'transform: perspective(1600px) rotateX(78deg) translateY(-16%) scale(0.94); opacity: 0;',
                        $adalahHalamanEditorial => 'transform: perspective(1800px) rotateY(-108deg); opacity: 0;',
                        $adalahGerbangBelah => 'transform: scale(1.07) translateZ(36px); opacity: 0; transition-delay: 0.45s;',
                        default => 'transform: perspective(1400px) translateY(-100%) rotateX(18deg); opacity: 0;',
                    }
                }}' : 'transform: perspective(1600px) translateY(0) scale(1) rotateX(0deg) rotateY(0deg); opacity: 1;'"
            >
                <img
                    src="{{ $gambarSampul }}"
                    alt="{{ $altSampul }}"
                    class="absolute inset-0 w-full h-full {{ $kelasImgSampul }} {{ $modeMonokrom ? 'grayscale' : '' }}"
                >
                <div class="absolute inset-0 {{ $overlaySampulAktif }}"></div>

                @if ($ornamenUrl && ! $pakaiFotoSampul)
                    <img src="{{ $ornamenUrl }}" alt="" class="pointer-events-none absolute -top-2 {{ $ornamenGantung ? 'left-4' : '-left-3' }} {{ $ukuranOrnamenMobile }} opacity-85 z-10 drop-shadow-xl animasi-ayun-3d">
                    <img src="{{ $ornamenUrl }}" alt="" class="pointer-events-none absolute -top-2 {{ $ornamenGantung ? 'right-4' : '-right-3' }} {{ $ukuranOrnamenMobile }} opacity-85 z-10 drop-shadow-xl animasi-ayun-3d-balik">
                @endif

                @if ($adalahGerbangBelah)
                    <div
                        aria-hidden="true"
                        class="panel-gerbang-kiri pointer-events-none absolute inset-y-0 left-0 w-1/2 z-10 border-r shadow-[10px_0_32px_rgba(0,0,0,0.45)] {{ $tiraiPanel }}"
                        :style="undanganTerbuka ? 'transform: perspective(1800px) rotateY(-112deg); opacity: 0.1;' : 'transform: perspective(1800px) rotateY(0deg); opacity: 1;'"
                    >
                        <div class="absolute inset-3 border border-current/15"></div>
                    </div>
                    <div
                        aria-hidden="true"
                        class="panel-gerbang-kanan pointer-events-none absolute inset-y-0 right-0 w-1/2 z-10 border-l shadow-[-10px_0_32px_rgba(0,0,0,0.45)] {{ $tiraiPanel }}"
                        :style="undanganTerbuka ? 'transform: perspective(1800px) rotateY(112deg); opacity: 0.1;' : 'transform: perspective(1800px) rotateY(0deg); opacity: 1;'"
                    >
                        <div class="absolute inset-3 border border-current/15"></div>
                    </div>
                @endif

                @include('komponen-undangan.lapisan-motion', ['efekMotion' => $efekMotion, 'konteks' => 'sampul'])

                <div
                    class="relative z-20 px-6 {{ $pakaiFotoSampul ? 'pt-6 sm:pt-8 space-y-1.5' : 'pt-8 sm:pt-10 space-y-2.5' }} text-center transition-all duration-700"
                    :style="undanganTerbuka && @js($adalahGerbangBelah) ? 'opacity: 0; transform: perspective(1000px) scale(0.92) translateZ(-30px);' : ''"
                >
                    @if ($editionHeader)
                        <div class="flex items-center justify-between text-[10px] uppercase tracking-[0.28em] opacity-80 border-b {{ $sampulPakaiModeGelap ? 'border-white/25 text-white/85' : $kelasBatas }} pb-2 mb-3">
                            <span>Vol. 01</span>
                            <span>{{ $editionHeader }}</span>
                            <span>{{ $acaraPertama?->tanggal_acara?->format('Y') ?? now()->format('Y') }}</span>
                        </div>
                    @endif

                    @if ($bismillahHeader)
                        <p class="text-base sm:text-lg {{ $sampulPakaiModeGelap ? 'text-[#F3E5AB]' : $kelasSubAksen }}" style="font-family: 'Amiri', serif;">
                            بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                        </p>
                    @endif

                    @if ($isEksklusif && ! $pakaiFotoSampul)
                        <div class="mx-auto w-16 h-16 relative flex items-center justify-center mb-1">
                            <span class="absolute inset-0 rounded-full border border-dashed border-[#F3E5AB]/55 animasi-orbit"></span>
                            <span class="absolute inset-1.5 rounded-full border border-[#D4AF37]/60 animasi-orbit-balik"></span>
                            <span class="font-serif text-sm font-bold tracking-widest {{ $sampulPakaiModeGelap ? 'text-[#F3E5AB]' : $kelasAksen }}">
                                {{ $undangan->inisialPria() }}&amp;{{ $undangan->inisialWanita() }}
                            </span>
                        </div>
                    @endif

                    <p class="text-[11px] font-semibold uppercase tracking-[0.35em] {{ $sampulPakaiModeGelap ? 'text-[#F3E5AB]' : $kelasSubAksen }}">
                        {{ $taglineSampul }}
                    </p>

                    <h1 class="font-serif {{ $pakaiFotoSampul ? 'text-3xl sm:text-[2.5rem]' : 'text-4xl sm:text-5xl' }} font-bold leading-tight {{ $teksGerbangSampul }}">
                        {{ $undangan->nama_panggilan_pria }}
                        <span class="{{ $pakaiFotoSampul ? 'inline font-kaligrafi font-normal mx-1' : 'block font-kaligrafi text-3xl sm:text-4xl font-normal my-0.5' }} {{ $sampulPakaiModeGelap ? 'text-[#F3E5AB]' : $kelasAksen }}">&amp;</span>
                        {{ $undangan->nama_panggilan_wanita }}
                    </h1>

                    <p class="text-[11px] uppercase tracking-[0.25em] {{ $sampulPakaiModeGelap ? 'text-white/90' : $teksGerbangSampul.' opacity-80' }}">
                        {{ $tanggalLengkap }}
                        @if (! $pakaiFotoSampul)
                            &bull; {{ $hashtagPasangan }}
                        @endif
                    </p>
                </div>

                <div
                    class="relative z-20 px-6 {{ $pakaiFotoSampul ? 'pb-6 sm:pb-8' : 'pb-8 sm:pb-10' }} transition-all duration-700"
                    :style="undanganTerbuka && @js($adalahGerbangBelah) ? 'opacity: 0; transform: translateY(18px);' : ''"
                >
                    <div class="kartu-3d {{ $radiusKartuBesar }} {{ $pakaiFotoSampul ? 'p-4 sm:p-5 bg-black/50 border-[#F3E5AB]/40 text-white' : 'p-5 sm:p-6 '.($sampulPakaiModeGelap ? 'bg-black/60 border-[#D4AF37]/45 text-white' : 'bg-white/88 border-[#BFA15F]/45 text-[#1F2937]') }} text-center backdrop-blur-md shadow-2xl border {{ $ekstraKartu }} space-y-2.5">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.28em] opacity-80">{{ $sapaanSampul }}</p>
                        <p class="font-serif text-xl sm:text-2xl font-bold {{ $sampulPakaiModeGelap ? 'text-[#F3E5AB]' : $kelasSubAksen }}">
                            Kepada Yth. {{ $namaTamu }}
                        </p>
                        @if (! $pakaiFotoSampul)
                            <p class="text-[11px] opacity-75">Tanpa mengurangi rasa hormat, kami mengundang Anda untuk hadir di hari bahagia kami.</p>
                        @endif

                        <div class="pt-1">
                            <button
                                type="button"
                                @click="bukaUndangan()"
                                class="w-full sm:w-auto {{ $radiusTombol }} px-8 py-3 text-xs sm:text-sm font-bold uppercase tracking-[0.18em] shadow-lg transition cursor-pointer {{ $kelasTombol }} {{ $animasiSampul === 'zoom-elegan' || $isEksklusif ? 'animasi-segel' : '' }}"
                            >
                                Buka Undangan
                            </button>
                        </div>

                        <p class="text-[10px] italic opacity-75">
                            *Mohon maaf jika ada kesalahan dalam penulisan nama / gelar.
                        </p>
                    </div>
                </div>
            </section>

            {{-- KONTEN UTAMA UNDANGAN --}}
            <main class="relative z-10 {{ !empty($modeDemo) ? 'pt-14' : '' }}">
                <section data-aos="fade-up" data-aos-duration="1000" class="px-5 pt-6 pb-8">
                    <div class="relative h-[28rem] sm:h-[31rem] {{ $heroBingkaiClass }} {{ $kelasBatas }} overflow-hidden shadow-2xl kartu-3d {{ $ekstraKartu }}">
                        <img
                            src="{{ $latarUtamaUrl }}"
                            alt="Hero {{ $undangan->tema?->nama_tema }}"
                            class="absolute inset-0 w-full h-full object-cover object-center animasi-nafas {{ $modeMonokrom ? 'grayscale' : '' }}"
                        >
                        <div class="absolute inset-0 {{ $overlaySampul }}"></div>

                        @if ($ornamenUrl)
                            <img src="{{ $ornamenUrl }}" alt="" class="pointer-events-none absolute -top-2 {{ $ornamenGantung ? 'left-3 w-12' : '-left-3 w-24' }} opacity-80 z-10 drop-shadow-xl animasi-ayun-3d">
                            <img src="{{ $ornamenUrl }}" alt="" class="pointer-events-none absolute -top-2 {{ $ornamenGantung ? 'right-3 w-12' : '-right-3 w-24' }} opacity-80 z-10 drop-shadow-xl animasi-ayun-3d-balik">
                        @endif

                        @include('komponen-undangan.lapisan-motion', ['efekMotion' => $efekMotion, 'konteks' => 'utama'])

                        <div class="relative z-10 h-full flex flex-col justify-between p-6 text-center">
                            <div class="{{ $sudutEditorial ? 'pt-3 text-left border-b border-current/20 pb-3' : 'pt-8' }} space-y-1.5">
                                @if ($bismillahHeader)
                                    <p class="text-sm {{ $sampulGelap ? 'text-[#F3E5AB]' : $kelasSubAksen }}" style="font-family: 'Amiri', serif;">
                                        بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                                    </p>
                                @endif
                                <p class="text-[11px] font-semibold uppercase tracking-[0.3em] {{ $sampulGelap ? 'text-[#F3E5AB]' : $kelasSubAksen }}">
                                    {{ $sapaanHero }}
                                </p>
                                <h2 class="font-serif text-4xl sm:text-5xl font-bold leading-tight {{ $teksSampul }}">
                                    {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
                                </h2>
                                <p class="text-xs uppercase tracking-[0.25em] {{ $sampulGelap ? 'text-white/80' : $teksSampul.' opacity-80' }}">
                                    {{ $tanggalTitik }}
                                </p>
                                @if (! $sudutEditorial)
                                    <p class="text-[11px] font-medium tracking-[0.18em] {{ $sampulGelap ? 'text-[#F3E5AB]/90' : $kelasSubAksen }}">
                                        {{ $hashtagPasangan }}
                                    </p>
                                @endif
                            </div>

                            <div class="space-y-3">
                                <div aria-hidden="true" class="mx-auto w-5 h-8 rounded-full border {{ $sampulGelap ? 'border-white/55' : 'border-current/40' }} flex justify-center pt-1.5 opacity-80">
                                    <span class="w-1 h-1.5 rounded-full {{ $sampulGelap ? 'bg-[#F3E5AB]' : 'bg-current' }} animasi-gulir-roda"></span>
                                </div>

                            @if ($sudutEditorial)
                                <div class="flex items-center justify-between border-t border-current/25 pt-3 text-[10px] uppercase tracking-[0.3em] {{ $teksSampul }}">
                                    <span>Issue 01</span>
                                    <span class="font-serif font-bold text-sm px-2.5 py-1 border border-current/40">{{ $undangan->inisialPria() }}&amp;{{ $undangan->inisialWanita() }}</span>
                                    <span>{{ $hashtagPasangan }}</span>
                                </div>
                            @elseif ($isEksklusif)
                                <div class="mx-auto w-16 h-16 relative flex items-center justify-center">
                                    <span class="absolute inset-0 rounded-full border border-dashed border-[#F3E5AB]/60 animasi-orbit"></span>
                                    <span class="w-12 h-12 rounded-full backdrop-blur-md border {{ $kelasBatas }} {{ $sampulGelap ? 'bg-black/55 text-[#F3E5AB]' : 'bg-white/90 text-[#1F2937]' }} flex items-center justify-center animasi-kilau">
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

                    @if ($undangan->kutipan_ayat)
                        <blockquote class="mt-6 {{ $radiusKartuSedang }} p-6 text-center italic text-xs sm:text-sm leading-relaxed kartu-3d masuk-3d {{ $ekstraKartu }} {{ $kelasKartu }}">
                            "{{ $undangan->kutipan_ayat }}"
                        </blockquote>
                    @endif
                </section>

                @if ($tampilMarquee)
                    <div class="my-2 py-2.5 border-y {{ $kelasBatas }} overflow-hidden bg-black/5">
                        <div class="animasi-marquee flex items-center gap-6 text-[11px] font-semibold uppercase tracking-[0.3em] {{ $kelasAksen }}">
                            @for ($i = 0; $i < 4; $i++)
                                <span>{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</span>
                                <span>&#10022;</span>
                                <span>{{ $tanggalTitik }}</span>
                                <span>&#10022;</span>
                                <span>{{ $hashtagPasangan }}</span>
                                <span>&#10022;</span>
                            @endfor
                        </div>
                    </div>
                @endif

                @include('komponen-undangan.divider-tema', [
                    'gayaTataLetak' => $gayaTataLetak,
                    'kelasAksen' => $kelasAksen,
                    'kelasBatas' => $kelasBatas,
                ])

                {{-- Profil Kedua Mempelai --}}
                <section data-aos="fade-up" data-aos-duration="1000" class="py-10 px-5 space-y-6">
                    {{-- Mempelai Pria --}}
                    <div
                        data-aos="fade-up"
                        data-aos-duration="1000"
                        class="{{ $radiusKartuBesar }} p-6 sm:p-7 {{ $sudutEditorial ? 'text-left' : 'text-center' }} kartu-3d masuk-3d {{ $ekstraKartu }} {{ $kelasKartu }}"
                    >
                        @if ($sudutEditorial)
                            <p class="text-[10px] font-semibold uppercase tracking-[0.3em] opacity-60 mb-4">01 / The Groom</p>
                        @endif

                        @if (! $tanpaFoto && $undangan->urlFotoPria())
                            <div class="{{ $sudutEditorial ? '' : 'mx-auto' }} w-fit relative">
                                @if ($isEksklusif)
                                    <span aria-hidden="true" class="pointer-events-none absolute -inset-2 {{ $haloMempelaiClass }}"></span>
                                @endif
                                <img
                                    src="{{ $undangan->urlFotoPria() }}"
                                    alt="{{ $undangan->nama_lengkap_pria }}"
                                    class="{{ $sudutEditorial ? '' : 'mx-auto' }} object-cover ring-4 {{ $kelasBatas }} {{ $bingkaiFoto === 'katedral' ? 'w-36 h-44 rounded-t-full rounded-b-2xl' : ($bingkaiFoto === 'kotak-editorial' ? 'w-44 h-52 grayscale hover:grayscale-0 transition duration-700' : 'w-36 h-36 rounded-full') }}"
                                >
                            </div>
                        @else
                            <div class="{{ $sudutEditorial ? '' : 'mx-auto' }} relative flex items-center justify-center border-2 {{ $kelasBatas }} {{ $bingkaiFoto === 'katedral' ? 'w-28 h-32 rounded-t-full rounded-b-2xl' : ($bingkaiFoto === 'kotak-editorial' ? 'w-28 h-32' : 'w-28 h-28 rounded-full') }} {{ $gelap ? 'bg-black/35' : 'bg-white/60' }}">
                                @if ($isEksklusif)
                                    <span aria-hidden="true" class="pointer-events-none absolute -inset-2 {{ $haloMempelaiClass }}"></span>
                                @endif
                                <span class="font-serif text-4xl font-bold {{ $kelasAksen }}">{{ $undangan->inisialPria() }}</span>
                            </div>
                        @endif

                        <p class="mt-4 text-[10px] font-semibold uppercase tracking-[0.3em] {{ $kelasAksen }}">Mempelai Pria</p>
                        <h3 class="mt-1 font-serif text-2xl sm:text-3xl font-bold">{{ $undangan->nama_lengkap_pria }}</h3>
                        @if ($undangan->nama_ayah_pria || $undangan->nama_ibu_pria)
                            <p class="mt-1.5 text-xs opacity-75">{{ $labelPutra }} {{ $undangan->nama_ayah_pria }} &amp; {{ $undangan->nama_ibu_pria }}</p>
                        @endif
                    </div>

                    <div class="text-center">
                        <span class="font-kaligrafi text-4xl {{ $kelasAksen }}">&amp;</span>
                    </div>

                    {{-- Mempelai Wanita --}}
                    <div
                        data-aos="fade-up"
                        data-aos-duration="1000"
                        class="{{ $radiusKartuBesar }} p-6 sm:p-7 {{ $sudutEditorial ? 'text-right' : 'text-center' }} kartu-3d masuk-3d {{ $ekstraKartu }} {{ $kelasKartu }}"
                    >
                        @if ($sudutEditorial)
                            <p class="text-[10px] font-semibold uppercase tracking-[0.3em] opacity-60 mb-4">02 / The Bride</p>
                        @endif

                        @if (! $tanpaFoto && $undangan->urlFotoWanita())
                            <div class="{{ $sudutEditorial ? 'ml-auto' : 'mx-auto' }} w-fit relative">
                                @if ($isEksklusif)
                                    <span aria-hidden="true" class="pointer-events-none absolute -inset-2 {{ $haloMempelaiClass }}"></span>
                                @endif
                                <img
                                    src="{{ $undangan->urlFotoWanita() }}"
                                    alt="{{ $undangan->nama_lengkap_wanita }}"
                                    class="{{ $sudutEditorial ? 'ml-auto' : 'mx-auto' }} object-cover ring-4 {{ $kelasBatas }} {{ $bingkaiFoto === 'katedral' ? 'w-36 h-44 rounded-t-full rounded-b-2xl' : ($bingkaiFoto === 'kotak-editorial' ? 'w-44 h-52 grayscale hover:grayscale-0 transition duration-700' : 'w-36 h-36 rounded-full') }}"
                                >
                            </div>
                        @else
                            <div class="{{ $sudutEditorial ? 'ml-auto' : 'mx-auto' }} relative flex items-center justify-center border-2 {{ $kelasBatas }} {{ $bingkaiFoto === 'katedral' ? 'w-28 h-32 rounded-t-full rounded-b-2xl' : ($bingkaiFoto === 'kotak-editorial' ? 'w-28 h-32' : 'w-28 h-28 rounded-full') }} {{ $gelap ? 'bg-black/35' : 'bg-white/60' }}">
                                @if ($isEksklusif)
                                    <span aria-hidden="true" class="pointer-events-none absolute -inset-2 {{ $haloMempelaiClass }}"></span>
                                @endif
                                <span class="font-serif text-4xl font-bold {{ $kelasAksen }}">{{ $undangan->inisialWanita() }}</span>
                            </div>
                        @endif

                        <p class="mt-4 text-[10px] font-semibold uppercase tracking-[0.3em] {{ $kelasAksen }}">Mempelai Wanita</p>
                        <h3 class="mt-1 font-serif text-2xl sm:text-3xl font-bold">{{ $undangan->nama_lengkap_wanita }}</h3>
                        @if ($undangan->nama_ayah_wanita || $undangan->nama_ibu_wanita)
                            <p class="mt-1.5 text-xs opacity-75">{{ $labelPutri }} {{ $undangan->nama_ayah_wanita }} &amp; {{ $undangan->nama_ibu_wanita }}</p>
                        @endif
                    </div>
                </section>

                {{-- Hitung Mundur & Google Calendar --}}
                @include('komponen-undangan.hitung-mundur', [
                    'kelasAksen' => $kelasAksen,
                    'kelasKartu' => $kelasKartu,
                    'kelasTombol' => $kelasTombol,
                    'sudutEditorial' => $sudutEditorial,
                    'kelasEkstraKartu' => $ekstraKartu,
                ])

                {{-- Rangkaian Acara --}}
                @if ($undangan->daftarAcara->isNotEmpty())
                <section data-aos="fade-up" data-aos-duration="1000" class="py-10 px-5">
                    <div class="text-center mb-6">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.28em] {{ $kelasAksen }}">{{ $subLabelAcara }}</p>
                        <h2 class="mt-1.5 font-serif text-3xl font-bold">{{ $labelAcara }}</h2>
                    </div>

                    <div class="space-y-5">
                        @foreach ($undangan->daftarAcara as $acara)
                            <div data-aos="zoom-in" data-aos-duration="1000" class="{{ $radiusKartuBesar }} p-6 text-center space-y-2.5 kartu-3d masuk-3d {{ $ekstraKartu }} {{ $kelasKartu }}">
                                <h3 class="font-serif text-2xl font-bold {{ $kelasAksen }}">{{ $acara->nama_acara }}</h3>
                                <p class="text-sm font-semibold">{{ $acara->tanggal_acara->translatedFormat('l, d F Y') }}</p>
                                <p class="text-xs font-semibold {{ $kelasAksen }}">
                                    {{ substr($acara->waktu_mulai, 0, 5) }}
                                    @if ($acara->waktu_selesai) - {{ substr($acara->waktu_selesai, 0, 5) }} @endif
                                    {{ $acara->zona_waktu }}
                                </p>
                                <div class="pt-2 border-t {{ $kelasBatas }}">
                                    <p class="font-semibold text-sm">{{ $acara->nama_tempat }}</p>
                                    <p class="text-xs opacity-75 mt-1">{{ $acara->alamat_lengkap }}</p>
                                </div>
                                @if ($acara->link_maps)
                                    <a href="{{ $acara->link_maps }}" target="_blank" rel="noopener" class="inline-block mt-2 {{ $radiusTombol }} px-6 py-2 text-xs font-semibold transition {{ $kelasTombol }}">
                                        Buka Google Maps
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
                @endif

                {{-- Cerita Cinta --}}
                @php $ceritaList = $undangan->pengaturan['cerita_cinta'] ?? []; @endphp
                @if ($undangan->fiturAktif('cerita_cinta') && !empty($ceritaList))
                <section data-aos="fade-up" data-aos-duration="1000" class="py-10 px-5">
                    <div class="text-center mb-6">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.28em] {{ $kelasAksen }}">{{ $subLabelCerita }}</p>
                        <h2 class="mt-1.5 font-serif text-3xl font-bold">{{ $labelCerita }}</h2>
                    </div>

                    @if ($tampilTimelineCerita)
                        <div class="relative pl-6 space-y-5 border-l-2 {{ $kelasBatas }} ml-2">
                            @foreach ($ceritaList as $cerita)
                                <div data-aos="fade-left" data-aos-duration="900" class="relative">
                                    <span aria-hidden="true" class="absolute -left-[31px] top-5 w-3.5 h-3.5 rounded-full border-2 {{ $kelasBatas }} {{ $gelap ? 'bg-[#D4AF37]' : 'bg-[#4B6358]' }} shadow-[0_0_0_4px_rgba(191,161,95,0.2)]"></span>
                                    <div class="{{ $radiusKartuSedang }} p-5 kartu-3d masuk-3d {{ $ekstraKartu }} {{ $kelasKartu }}">
                                        <div class="flex items-center justify-between gap-2">
                                            <h3 class="font-serif text-lg font-bold">{{ $cerita['judul'] ?? '' }}</h3>
                                            <span class="{{ $sudutEditorial ? 'rounded-none' : 'rounded-full' }} px-3 py-0.5 text-[11px] font-semibold {{ $kelasBadge }}">{{ $cerita['tanggal'] ?? '' }}</span>
                                        </div>
                                        <p class="mt-2 text-xs sm:text-sm opacity-80 leading-relaxed">{{ $cerita['cerita'] ?? '' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach ($ceritaList as $cerita)
                                <div data-aos="fade-up" data-aos-duration="1000" class="{{ $radiusKartuSedang }} p-5 kartu-3d masuk-3d {{ $kelasKartu }}">
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

                {{-- Galeri Foto --}}
                @if (! $tanpaFoto && $undangan->fiturAktif('galeri') && $undangan->daftarGaleri->isNotEmpty())
                <section data-aos="fade-up" data-aos-duration="1000" class="py-10 px-5">
                    <div class="text-center mb-6">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.28em] {{ $kelasAksen }}">{{ $subLabelGaleri }}</p>
                        <h2 class="mt-1.5 font-serif text-3xl font-bold">{{ $labelGaleri }}</h2>
                    </div>

                    <div class="grid grid-cols-2 gap-3.5">
                        @foreach ($undangan->daftarGaleri as $galeri)
                            @php
                                $adalahUnggulan = $gayaGaleri === 'unggulan' && $loop->first;
                                $bentukGaleri = $adalahUnggulan
                                    ? 'col-span-2 aspect-[16/10] rounded-3xl'
                                    : ($gayaGaleri === 'editorial'
                                        ? ($loop->odd ? 'aspect-[3/4] rounded-none' : 'aspect-square rounded-none')
                                        : ($bingkaiFoto === 'katedral' ? 'aspect-[4/5] rounded-t-[3rem] rounded-b-2xl' : 'aspect-square rounded-2xl'));
                            @endphp
                            <button
                                type="button"
                                data-aos="zoom-in"
                                data-aos-duration="1000"
                                @click="bukaGaleri(@js($galeri->urlFoto()), @js($galeri->keterangan))"
                                class="group relative overflow-hidden border {{ $kelasBatas }} cursor-pointer kartu-3d masuk-3d {{ $bentukGaleri }}"
                            >
                                <img
                                    src="{{ $galeri->urlFoto() }}"
                                    alt="{{ $galeri->keterangan ?? 'Galeri' }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-700 {{ $modeMonokrom ? 'grayscale group-hover:grayscale-0' : '' }}"
                                >
                                @if ($isEksklusif && $galeri->keterangan)
                                    <span class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/75 to-transparent px-3 py-2 text-left text-[11px] font-medium text-white/90 opacity-0 group-hover:opacity-100 transition duration-300">
                                        {{ $galeri->keterangan }}
                                    </span>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </section>
                @endif

                {{-- Live Streaming, Amplop Digital & Buku Tamu --}}
                @include('komponen-undangan.amplop-dan-tamu', [
                    'kelasAksen' => $kelasAksen,
                    'kelasKartu' => $kelasKartu,
                    'kelasTombol' => $kelasTombol,
                    'sudutEditorial' => $sudutEditorial,
                    'kelasEkstraKartu' => $ekstraKartu,
                ])

                <footer class="py-8 px-4 text-center text-xs opacity-80">
                    <img
                        src="{{ asset('aset-demo/logo-sesi-temu-ikon.webp') }}"
                        alt="Logo SesiTemu"
                        class="mx-auto mb-2 h-7 w-7 rounded-lg bg-[#FBF3E6]/90 p-0.5 object-contain"
                    >
                    {{ $footerTeks }} &bull; <a href="{{ route('beranda') }}" class="font-semibold {{ $kelasAksen }} hover:underline">SesiTemu.id</a>
                </footer>
            </main>
        </div>
    </div>

    @include('komponen-undangan.pemutar-musik')
    @include('komponen-undangan.modal-galeri')
    @include('komponen-undangan.skrip-tema')
</body>
</html>
