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
    'kelasAksenKartu' => null,
    'kelasSubAksen' => 'text-[#4B6358]',
    'kelasKartu' => 'bg-white/90 backdrop-blur-md border border-[#BFA15F]/35 text-[#1F2937]',
    'kelasTombol' => 'bg-[#4B6358] text-white hover:bg-[#3A4D44]',
    'kelasBadge' => 'bg-[#BFA15F]/15 text-[#BFA15F] border border-[#BFA15F]/30',
    'kelasBatas' => 'border-[#BFA15F]/35',
    'kelasTirai' => null,
    'kelasProgres' => 'bg-gradient-to-r from-[#BFA15F] via-[#F3E5AB] to-[#BFA15F]',
    'kelasBandCountdown' => null,
    'kelasKotakCountdown' => null,
    'kelasTombolCountdown' => null,
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
    $tanpaFoto = $undangan->modeTanpaFoto();
    $latarUtamaUrl = (! $tanpaFoto ? $undangan->urlFotoLatarCustom() : null) ?? asset("aset-tema/{$slugTema}/latar-utama.webp");
    $acaraPertama = $undangan->daftarAcara->first();
    $tanggalTitik = $acaraPertama?->tanggal_acara?->format('d . m . y') ?? now()->format('d . m . y');
    $tanggalLengkap = $acaraPertama?->tanggal_acara
        ? $acaraPertama->tanggal_acara->locale('id')->translatedFormat('l, d F Y')
        : now()->locale('id')->translatedFormat('l, d F Y');
    $hashtagPasangan = $undangan->hashtagPasangan();
    $urlFotoSampul = $tanpaFoto ? null : $undangan->urlFotoSampul();
    $pakaiFotoSampul = !$tanpaFoto && !empty($urlFotoSampul);

    $urutanTier = ['basic' => 1, 'premium' => 2, 'eksklusif' => 3];
    $tierDb = $undangan->tema?->tier ? $undangan->tema->tierKode() : $tierBawaan;
    $tierAktif = ($urutanTier[$tierDb] ?? 1) >= ($urutanTier[$tierBawaan] ?? 1) ? $tierDb : $tierBawaan;
    $isEksklusif = $tierAktif === 'eksklusif';
    $isPremiumAtas = in_array($tierAktif, ['premium', 'eksklusif'], true);
    $sudutEditorial = $gayaTataLetak === 'editorial';
    $radiusKartuBesar = $sudutEditorial ? 'rounded-none' : 'rounded-3xl';
    $radiusKartuSedang = $sudutEditorial ? 'rounded-none' : 'rounded-2xl';
    $radiusTombol = $sudutEditorial ? 'rounded-none' : 'rounded-full';
    $ekstraKartu = $isEksklusif ? 'efek-shimmer-kartu' : '';
    $aksenKartu = $kelasAksenKartu ?? $kelasAksen;

    $polaDataUri = match ($polaTekstur) {
        'batik'
            => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='64' height='64' viewBox='0 0 64 64'%3E%3Cg fill='none' stroke='%23BFA15F' stroke-opacity='0.14' stroke-width='1'%3E%3Ccircle cx='32' cy='32' r='22'/%3E%3Ccircle cx='0' cy='0' r='22'/%3E%3Ccircle cx='64' cy='0' r='22'/%3E%3Ccircle cx='0' cy='64' r='22'/%3E%3Ccircle cx='64' cy='64' r='22'/%3E%3Ccircle cx='32' cy='32' r='4'/%3E%3C/g%3E%3C/svg%3E",
        'arabesque'
            => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Cg fill='none' stroke='%23D9B664' stroke-opacity='0.14' stroke-width='1'%3E%3Cpath d='M30 2 L58 30 L30 58 L2 30 Z'/%3E%3Crect x='11' y='11' width='38' height='38'/%3E%3Ccircle cx='30' cy='30' r='6'/%3E%3C/g%3E%3C/svg%3E",
        'deco'
            => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='56' height='56' viewBox='0 0 56 56'%3E%3Cg fill='none' stroke='%23D4AF37' stroke-opacity='0.12' stroke-width='1'%3E%3Cpath d='M0 28 H56 M28 0 V56'/%3E%3Cpath d='M28 6 L50 28 L28 50 L6 28 Z'/%3E%3C/g%3E%3C/svg%3E",
        'editorial'
            => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='48' height='48' viewBox='0 0 48 48'%3E%3Cg fill='none' stroke='%2318181B' stroke-opacity='0.06' stroke-width='1'%3E%3Cpath d='M48 0 V48 M0 48 H48'/%3E%3C/g%3E%3C/svg%3E",
        default
            => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='72' height='72' viewBox='0 0 72 72'%3E%3Cg fill='none' stroke='%23BFA15F' stroke-opacity='0.12' stroke-width='1'%3E%3Ccircle cx='36' cy='36' r='26'/%3E%3Cpath d='M36 10 Q46 26 36 36 Q26 26 36 10 Z'/%3E%3Cpath d='M36 62 Q46 46 36 36 Q26 46 36 62 Z'/%3E%3Cpath d='M10 36 Q26 26 36 36 Q26 46 10 36 Z'/%3E%3Cpath d='M62 36 Q46 26 36 36 Q46 46 62 36 Z'/%3E%3C/g%3E%3C/svg%3E",
    };

    $sampulGelap = $gelapSampul ?? $gelap;
    $teksSampul = $kelasTeksSampul ?? ($sampulGelap ? 'text-white drop-shadow-md' : 'text-current');
    $tiraiPanel =
        $kelasTirai ?? ($sampulGelap ? 'bg-[#0C0C10]/95 border-[#D4AF37]/50' : 'bg-[#FAF5EB]/95 border-[#BFA15F]/50');

    $overlayPanggung = $sampulGelap
        ? 'bg-gradient-to-b from-black/45 via-black/45 to-black/80'
        : 'bg-gradient-to-b from-black/35 via-black/30 to-black/65';

    $overlaySampul = $sampulGelap
        ? 'bg-gradient-to-b from-black/70 via-black/35 to-black/85'
        : 'bg-gradient-to-b from-[#FFFDF8]/68 via-[#FFFDF8]/18 to-black/32';

    $sampulPakaiModeGelap = $pakaiFotoSampul || $sampulGelap;
    $gambarSampul = $pakaiFotoSampul ? $urlFotoSampul : $latarUtamaUrl;
    $altSampul = $pakaiFotoSampul
        ? "Foto Sampul {$undangan->nama_panggilan_pria} & {$undangan->nama_panggilan_wanita}"
        : "Sampul {$undangan->tema?->nama_tema}";
    $kelasImgSampul = $pakaiFotoSampul ? 'object-cover object-top' : 'object-cover object-center';
    $overlaySampulAktif = $pakaiFotoSampul ? 'bg-gradient-to-b from-black/80 via-black/15 to-black/85' : $overlaySampul;
    $teksGerbangSampul = $pakaiFotoSampul ? 'text-white drop-shadow-md' : $teksSampul;

    $heroBingkaiClass = match ($gayaTataLetak) {
        'editorial' => 'rounded-none border',
        'mihrab', 'celestial' => 'rounded-t-[13rem] rounded-b-3xl border-2',
        'katedral'
            => 'rounded-t-[13rem] rounded-b-3xl border-2 ring-4 ring-offset-4 ring-offset-transparent ring-[#9E7B4F]/25',
        'artdeco' => 'rounded-2xl border-2 ring-1 ring-inset ring-[#D4AF37]/45',
        'taman' => 'rounded-t-[11rem] rounded-b-3xl border-2 ring-1 ring-[#C8A464]/35',
        'keraton', 'priangan' => 'rounded-t-[9rem] rounded-b-3xl border-2 ring-1 ring-inset ring-[#D4AF37]/30',
        default => 'rounded-t-[10rem] rounded-b-3xl border-2',
    };

    $haloMempelaiClass =
        $bingkaiFoto === 'katedral'
            ? 'rounded-t-full rounded-b-3xl border border-dashed border-[#D4AF37]/50 animasi-kilau'
            : 'rounded-full border border-dashed border-[#D4AF37]/50 animasi-orbit';

    $ornamenGantung = $gayaTataLetak === 'celestial';
    $ukuranOrnamenPanggung = $ornamenGantung ? 'w-20 xl:w-24' : 'w-40 xl:w-52';
    $ukuranOrnamenMobile = $ornamenGantung ? 'w-11 sm:w-12' : 'w-24 sm:w-28';
@endphp

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    @include('komponen-undangan.meta-opengraph')
</head>

<body x-data="temaUndangan()" :class="undanganTerbuka ? 'overflow-x-hidden' : 'overflow-hidden h-screen'"
    class="{{ $kelasBody }} antialiased relative">
    @include('komponen-undangan.bar-pratinjau-demo')

    <div class="min-h-screen w-full lg:flex">
        {{-- PANGGUNG VISUAL DESKTOP KIRI (DIORAMA 3D 5-LAPIS) --}}
        <aside data-panggung-3d
            class="hidden lg:flex lg:flex-1 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d">
            {{-- Layer Z-0: Latar Jauh --}}
            <div class="lapis-3d absolute -inset-4 pointer-events-none" style="--depth: -14px; --pz: -40px;">
                <img src="{{ $latarUtamaUrl }}" alt="Ilustrasi {{ $undangan->tema?->nama_tema }}"
                    class="w-full h-full object-cover object-center scale-105 animasi-nafas {{ $modeMonokrom ? 'grayscale' : '' }}">
            </div>
            <div class="absolute inset-0 {{ $overlayPanggung }}"></div>
            {{-- Layer Z-1: Aura Cahaya Volumetrik --}}
            <div aria-hidden="true"
                class="pointer-events-none absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[30rem] h-[30rem] rounded-full bg-[#F3E5AB]/10 blur-3xl">
            </div>

            @if ($ornamenUrl)
                {{-- Layer Z-3: Ornamen Foreground Transparan di Sudut Atas Stage --}}
                <div class="lapis-3d pointer-events-none absolute {{ $ornamenGantung ? 'top-14 left-6' : 'top-16 left-4' }} z-20"
                    style="--depth: 26px; --pz: 42px;">
                    <img src="{{ $ornamenUrl }}" alt=""
                        class="{{ $ornamenGantung ? 'w-16 xl:w-20' : 'w-28 xl:w-36' }} opacity-90 drop-shadow-[0_18px_30px_rgba(0,0,0,0.45)] animasi-ayun-3d">
                </div>
                <div class="lapis-3d pointer-events-none absolute {{ $ornamenGantung ? 'top-14 right-6' : 'top-16 right-4' }} z-20"
                    style="--depth: 26px; --pz: 42px;">
                    <img src="{{ $ornamenUrl }}" alt=""
                        class="{{ $ornamenGantung ? 'w-16 xl:w-20' : 'w-28 xl:w-36' }} opacity-90 drop-shadow-[0_18px_30px_rgba(0,0,0,0.45)] animasi-ayun-3d-balik">
                </div>
            @endif

            @if ($sudutEditorial)
                <div aria-hidden="true" class="pointer-events-none absolute inset-7 border border-white/30"></div>
                <div
                    class="pointer-events-none absolute top-11 left-12 right-12 flex items-center justify-between text-[10px] uppercase tracking-[0.35em] text-white/80">
                    <span>Vol. 01 &bull; Monochrome</span>
                    <span>{{ $editionHeader ?? 'The Wedding Edition' }}</span>
                </div>
            @elseif ($isEksklusif)
                <div aria-hidden="true"
                    class="pointer-events-none absolute inset-6 border border-[#F3E5AB]/25 rounded-3xl"></div>
                <div aria-hidden="true"
                    class="pointer-events-none absolute top-12 right-12 w-24 h-24 flex items-center justify-center">
                    <div class="absolute inset-0 rounded-full border border-dashed border-[#F3E5AB]/45 animasi-orbit">
                    </div>
                    <div class="absolute inset-2 rounded-full border border-[#D4AF37]/50 animasi-orbit-balik"></div>
                    <span
                        class="font-serif text-sm font-bold tracking-widest text-[#F3E5AB]">{{ $undangan->inisialPria() }}&amp;{{ $undangan->inisialWanita() }}</span>
                </div>
            @elseif ($gayaTataLetak === 'katedral' || $gayaTataLetak === 'keraton' || $gayaTataLetak === 'priangan')
                <div aria-hidden="true"
                    class="pointer-events-none absolute inset-6 border border-[#F3E5AB]/25 rounded-2xl"></div>
            @endif

            @include('komponen-undangan.lapisan-motion', [
                'efekMotion' => $efekMotion,
                'konteks' => 'panggung',
            ])

            {{-- Layer Z-2: Tipografi Pasangan Mengambang --}}
            <div class="lapis-3d relative z-10 w-full flex flex-col items-center justify-center text-center px-10 pb-20 xl:px-14 text-white"
                style="--depth: 10px; --pz: 24px;">
                <div class="max-w-xl space-y-3">
                    @if ($ornamenUrl && !$ornamenGantung)
                        <img src="{{ $ornamenUrl }}" alt=""
                            class="w-20 xl:w-24 mx-auto mb-1 opacity-95 drop-shadow-[0_12px_20px_rgba(0,0,0,0.45)] animasi-ayun-3d">
                    @endif
                    @if ($bismillahHeader)
                        <p class="text-base sm:text-lg text-[#F3E5AB]/95 tracking-wide drop-shadow"
                            style="font-family: 'Amiri', serif;">
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
                    <div
                        class="flex flex-wrap items-center justify-center gap-3 pt-1 text-xs font-medium uppercase tracking-[0.28em] text-white/90 drop-shadow">
                        <span>{{ $tanggalLengkap }}</span>
                        <span class="w-1 h-1 rounded-full bg-[#F3E5AB]"></span>
                        <span>{{ $hashtagPasangan }}</span>
                    </div>
                </div>
            </div>
        </aside>

        {{-- KOLOM UNDANGAN MOBILE-FIRST PORTRAIT --}}
        <div
            class="w-full lg:w-[445px] xl:w-[475px] shrink-0 min-h-screen relative overflow-x-clip shadow-2xl border-l {{ $kelasBatas }}">
            @if ($tampilScrollProgress)
                <div aria-hidden="true" x-show="undanganTerbuka" x-cloak
                    class="fixed top-0 lg:left-auto lg:w-[445px] xl:w-[475px] left-0 right-0 z-[60] h-[3px] bg-black/15">
                    <div class="h-full transition-all duration-150 {{ $kelasProgres }}"
                        :style="'width: ' + scrollPersen + '%'"></div>
                </div>
            @endif

            {{-- Tekstur Budaya / Botani & Jendela Paralaks Tetap Khusus Kolom Undangan --}}
            <div aria-hidden="true"
                class="pointer-events-none fixed top-0 bottom-0 right-0 w-full lg:w-[445px] xl:w-[475px] z-0"
                style="background-image: url(&quot;{{ $polaDataUri }}&quot;); background-repeat: repeat;"></div>
            <img src="{{ $latarUtamaUrl }}" alt="" aria-hidden="true"
                class="pointer-events-none fixed top-0 bottom-0 right-0 w-full lg:w-[445px] xl:w-[475px] h-full object-cover {{ $gelap ? 'opacity-28' : 'opacity-22' }} {{ $modeMonokrom ? 'grayscale opacity-12' : '' }} z-0">

            @if ($ornamenUrl)
                <img src="{{ $ornamenUrl }}" alt=""
                    class="pointer-events-none fixed {{ !empty($modeDemo) && !request()->boolean('embed') ? 'top-16' : 'top-3' }} {{ $ornamenGantung ? 'left-3 lg:left-auto lg:right-[390px] xl:right-[418px] w-10 sm:w-12' : 'left-2 lg:left-auto lg:right-[345px] xl:right-[375px] w-16 sm:w-20' }} opacity-65 z-20 drop-shadow-lg animasi-ayun-3d">
                <img src="{{ $ornamenUrl }}" alt=""
                    class="pointer-events-none fixed {{ !empty($modeDemo) && !request()->boolean('embed') ? 'top-16' : 'top-3' }} {{ $ornamenGantung ? 'right-3 w-10 sm:w-12' : 'right-2 w-16 sm:w-20' }} opacity-65 z-20 drop-shadow-lg animasi-ayun-3d-balik">
            @endif

            {{-- SAMPUL PEMBUKA DENGAN TRANSISI FADE HALUS (TANPA EFEK BUKA BUKU / BELAH PINTU) --}}
            <section data-transisi-sampul="fade-halus"
                class="tirai-fade-halus fixed inset-0 h-dvh lg:left-auto lg:w-[445px] xl:w-[475px] z-40 {{ !empty($modeDemo) && !request()->boolean('embed') ? 'pt-14' : '' }}"
                style="height: 100dvh;" :class="undanganTerbuka ? 'tirai-terbuka pointer-events-none' : ''">
                <div class="relative w-full h-full flex flex-col justify-between">
                    <div class="absolute inset-0 overflow-hidden shadow-2xl">
                        <img src="{{ $gambarSampul }}" alt="{{ $altSampul }}"
                            class="w-full h-full {{ $kelasImgSampul }} {{ $modeMonokrom ? 'grayscale' : '' }}">
                        <div class="absolute inset-0 {{ $overlaySampulAktif }}"></div>
                    </div>

                    @if ($ornamenUrl && !$pakaiFotoSampul)
                        <img src="{{ $ornamenUrl }}" alt=""
                            class="pointer-events-none absolute top-2 {{ $ornamenGantung ? 'left-4 w-12' : 'left-1 w-20' }} opacity-85 z-10 drop-shadow-xl animasi-ayun-3d">
                        <img src="{{ $ornamenUrl }}" alt=""
                            class="pointer-events-none absolute top-2 {{ $ornamenGantung ? 'right-4 w-12' : 'right-1 w-20' }} opacity-85 z-10 drop-shadow-xl animasi-ayun-3d-balik">
                    @endif

                    @include('komponen-undangan.lapisan-motion', [
                        'efekMotion' => $efekMotion,
                        'konteks' => 'sampul',
                    ])

                    <div
                        class="relative z-20 px-6 {{ $pakaiFotoSampul ? 'pt-5 sm:pt-7 space-y-1' : 'pt-6 sm:pt-9 space-y-2' }} text-center">
                        @if ($editionHeader)
                            <div
                                class="flex items-center justify-between text-[10px] uppercase tracking-[0.28em] opacity-80 border-b {{ $sampulPakaiModeGelap ? 'border-white/25 text-white/85' : $kelasBatas }} pb-2 mb-3">
                                <span>Vol. 01</span>
                                <span>{{ $editionHeader }}</span>
                                <span>{{ $acaraPertama?->tanggal_acara?->format('Y') ?? now()->format('Y') }}</span>
                            </div>
                        @endif

                        @if ($bismillahHeader)
                            <p class="text-base sm:text-lg {{ $sampulPakaiModeGelap ? 'text-[#F3E5AB]' : $kelasSubAksen }}"
                                style="font-family: 'Amiri', serif;">
                                بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                            </p>
                        @endif

                        @if ($isEksklusif && !$pakaiFotoSampul)
                            <div class="mx-auto w-16 h-16 relative flex items-center justify-center mb-1">
                                <span
                                    class="absolute inset-0 rounded-full border border-dashed border-[#F3E5AB]/55 animasi-orbit"></span>
                                <span
                                    class="absolute inset-1.5 rounded-full border border-[#D4AF37]/60 animasi-orbit-balik"></span>
                                <span
                                    class="font-serif text-sm font-bold tracking-widest {{ $sampulPakaiModeGelap ? 'text-[#F3E5AB]' : $kelasAksen }}">
                                    {{ $undangan->inisialPria() }}&amp;{{ $undangan->inisialWanita() }}
                                </span>
                            </div>
                        @endif

                        <p
                            class="text-[11px] font-semibold uppercase tracking-[0.35em] {{ $sampulPakaiModeGelap ? 'text-[#F3E5AB]' : $kelasSubAksen }}">
                            {{ $taglineSampul }}
                        </p>

                        <h1
                            class="font-serif {{ $pakaiFotoSampul ? 'text-3xl sm:text-[2.5rem]' : 'text-4xl sm:text-5xl' }} font-bold leading-tight {{ $teksGerbangSampul }}">
                            {{ $undangan->nama_panggilan_pria }}
                            <span
                                class="{{ $pakaiFotoSampul ? 'inline font-kaligrafi font-normal mx-1' : 'block font-kaligrafi text-3xl sm:text-4xl font-normal my-0.5' }} {{ $sampulPakaiModeGelap ? 'text-[#F3E5AB]' : $kelasAksen }}">&amp;</span>
                            {{ $undangan->nama_panggilan_wanita }}
                        </h1>

                        <p
                            class="text-[11px] uppercase tracking-[0.25em] {{ $sampulPakaiModeGelap ? 'text-white/90' : $teksGerbangSampul . ' opacity-80' }}">
                            {{ $tanggalLengkap }}
                            @if (!$pakaiFotoSampul)
                                &bull; {{ $hashtagPasangan }}
                            @endif
                        </p>
                    </div>

                    <div class="relative z-20 px-6 {{ $pakaiFotoSampul ? 'pb-5 sm:pb-7' : 'pb-6 sm:pb-8' }}">
                        <div
                            class="kartu-3d {{ $radiusKartuBesar }} {{ $pakaiFotoSampul ? 'p-4 sm:p-5 bg-black/50 border-[#F3E5AB]/40 text-white' : 'p-5 sm:p-6 ' . ($sampulPakaiModeGelap ? 'bg-black/60 border-[#D4AF37]/45 text-white' : 'bg-white/88 border-[#BFA15F]/45 text-[#1F2937]') }} text-center backdrop-blur-md shadow-2xl border {{ $ekstraKartu }} space-y-2.5">
                            <p class="text-[10px] font-semibold uppercase tracking-[0.28em] opacity-80">
                                {{ $sapaanSampul }}</p>
                            <p
                                class="font-serif text-xl sm:text-2xl font-bold {{ $sampulPakaiModeGelap ? 'text-[#F3E5AB]' : $kelasSubAksen }}">
                                Kepada Yth. {{ $namaTamu }}
                            </p>
                            @if (!$pakaiFotoSampul)
                                <p class="text-[11px] opacity-75">Tanpa mengurangi rasa hormat, kami mengundang Anda
                                    untuk hadir di hari bahagia kami.</p>
                            @endif

                            <div class="pt-1">
                                <button type="button" @click="bukaUndangan()"
                                    class="w-full sm:w-auto {{ $radiusTombol }} px-8 py-3 text-xs sm:text-sm font-bold uppercase tracking-[0.18em] shadow-lg transition cursor-pointer {{ $kelasTombol }} {{ $isEksklusif ? 'animasi-segel' : '' }}">
                                    Buka Undangan
                                </button>
                            </div>

                            <p class="text-[10px] italic opacity-75">
                                *Mohon maaf jika ada kesalahan dalam penulisan nama / gelar.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- KONTEN UTAMA UNDANGAN (ARSITEKTUR MODULAR 9 TEMA UNIK + 3D MOTION SCROLL) --}}
            <main data-panggung-3d
                class="panggung-3d relative z-10 {{ !empty($modeDemo) && !request()->boolean('embed') ? 'pt-14' : '' }}">
                {{-- 1 & 2. Hero Diorama 3D Multi-Lapis + Permukaan Pembuka & Ayat --}}
                @include('komponen-undangan.bagian-hero-dan-ayat')

                @if ($tampilMarquee)
                    <div class="py-2.5 border-y {{ $kelasBatas }} overflow-hidden bg-black/15">
                        <div
                            class="animasi-marquee flex items-center gap-6 text-[11px] font-semibold uppercase tracking-[0.3em] {{ $kelasAksen }}">
                            @for ($i = 0; $i < 4; $i++)
                                <span>{{ $undangan->nama_panggilan_pria }} &amp;
                                    {{ $undangan->nama_panggilan_wanita }}</span>
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

                {{-- 3. Profil Kedua Mempelai (9 Arsitektur Unik per Tema) --}}
                @include('komponen-undangan.bagian-mempelai')

                {{-- 4. Hitung Mundur & Google Calendar (9 Desain Unik per Tema) --}}
                @include('komponen-undangan.hitung-mundur', [
                    'gayaTataLetak' => $gayaTataLetak,
                    'ornamenUrl' => $ornamenUrl,
                    'kelasAksen' => $kelasAksen,
                    'kelasAksenKartu' => $aksenKartu,
                    'kelasKartu' => $kelasKartu,
                    'kelasTombol' => $kelasTombol,
                    'kelasBandCountdown' => $kelasBandCountdown,
                    'kelasKotakCountdown' => $kelasKotakCountdown,
                    'kelasTombolCountdown' => $kelasTombolCountdown,
                    'sudutEditorial' => $sudutEditorial,
                    'kelasEkstraKartu' => $ekstraKartu,
                ])

                {{-- 5. Rangkaian Acara (9 Gaya Kartu Unik per Tema) --}}
                @include('komponen-undangan.bagian-acara')

                {{-- 6 & 7. Cerita Cinta (Scroll-Scrubbing Horizontal) + Galeri Foto --}}
                @include('komponen-undangan.bagian-cerita-dan-galeri')

                {{-- 8, 9 & 10. Live Streaming, Amplop ATM Glossy, Buku Tamu & Kapsul Penutup --}}
                @include('komponen-undangan.amplop-dan-tamu', [
                    'gayaTataLetak' => $gayaTataLetak,
                    'ornamenUrl' => $ornamenUrl,
                    'bismillahHeader' => $bismillahHeader,
                    'kelasAksen' => $kelasAksen,
                    'kelasAksenKartu' => $aksenKartu,
                    'kelasKartu' => $kelasKartu,
                    'kelasTombol' => $kelasTombol,
                    'sudutEditorial' => $sudutEditorial,
                    'kelasEkstraKartu' => $ekstraKartu,
                ])

                <footer class="py-8 px-4 text-center text-xs opacity-85">
                    <img src="{{ $gelap ? asset('logo/logo-ikon-gelap.webp') : asset('logo/logo-ikon.webp') }}"
                        alt="Logo SesiTemu" class="mx-auto mb-2 h-8 w-8 object-contain">
                    {{ $footerTeks }} &bull; <a href="{{ route('beranda') }}"
                        class="font-semibold {{ $kelasAksen }} hover:underline">SesiTemu.id</a>
                </footer>
            </main>
        </div>
    </div>

    @include('komponen-undangan.kontrol-sinema')
    @include('komponen-undangan.pemutar-musik')
    @include('komponen-undangan.modal-galeri')
    @include('komponen-undangan.skrip-tema')
</body>

</html>
