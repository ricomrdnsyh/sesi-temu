@props([
    'tema',
])

@php
    $poster = $tema->infoPoster();
    $demo = \App\Support\KatalogKontenDemo::untukTema($tema);

    $priaPanggilan = $demo['pria']['panggilan'] ?? 'Dimas';
    $wanitaPanggilan = $demo['wanita']['panggilan'] ?? 'Rani';
    $wanitaLengkap = $demo['wanita']['lengkap'] ?? $wanitaPanggilan;
    $wanitaAyah = $demo['wanita']['ayah'] ?? 'Keluarga Mempelai';
    $wanitaIbu = $demo['wanita']['ibu'] ?? null;
    $instagramWanita = $demo['sosial_media']['instagram_wanita'] ?? null;

    $adalahAdatJawa = $tema->slug === 'adat-jawa';
    $adalahSundaHeritage = $tema->slug === 'sunda-heritage';
    $adalahIslamiSyari = $tema->slug === 'islami-syari';
    $adalahIslamicHeavenly = $tema->slug === 'islamic-heavenly';
    $adalahRusticFloral = $tema->slug === 'rustic-floral';
    $adalahVelvetGarden = $tema->slug === 'velvet-garden';
    $adalahEditorialMonokrom = $tema->slug === 'editorial-monokrom';
    $adalahLuxuryNoir = $tema->slug === 'luxury-noir';
    $adalahRoyalIvory = $tema->slug === 'royal-ivory';

    $relatifLatarTema = "aset-tema/{$tema->slug}/latar-utama.webp";
    $gambarLatarTemaUrl = is_file(public_path($relatifLatarTema))
        ? asset($relatifLatarTema)
        : $tema->urlGambarPratinjau();

    $fotoSampulRelatif = $demo['foto_sampul'] ?? 'aset-demo/sampul-rustic.webp';
    $fotoCoupleUrl = \App\Support\MediaPublik::url($fotoSampulRelatif)
        ?? ($gambarLatarTemaUrl ?: asset('aset-demo/mempelai-wanita.webp'));
    $fotoWanitaUrl = \App\Support\MediaPublik::url($demo['foto_wanita'] ?? $fotoSampulRelatif) ?? $fotoCoupleUrl;

    $asetPosterJawa = $adalahAdatJawa ? [
        'gunungan' => asset('aset-tema/adat-jawa/ornamen-gunungan.webp'),
        'heroPoster' => asset('aset-tema/adat-jawa/hero-poster.webp'),
        'hutan' => asset('aset-tema/adat-jawa/latar-hutan-jawa.webp'),
        'sayapWayang' => asset('aset-tema/adat-jawa/sayap-wayang.webp'),
        'bungaLili' => asset('aset-tema/adat-jawa/bunga-lili.webp'),
    ] : [];

    $asetPosterSunda = $adalahSundaHeritage ? [
        'siger' => asset('aset-tema/sunda-heritage/ornamen-siger.webp'),
        'heroPoster' => asset('aset-tema/sunda-heritage/hero-poster.webp'),
        'bingkai' => asset('aset-tema/sunda-heritage/bingkai-priangan.webp'),
        'bungaDepan' => asset('aset-tema/sunda-heritage/bunga-depan-sunda.webp'),
    ] : [];

    $asetPosterSyari = $adalahIslamiSyari ? [
        'arabesque' => asset('aset-tema/islami-syari/ornamen-arabesque.webp'),
        'heroPoster' => asset('aset-tema/islami-syari/hero-poster.webp'),
    ] : [];

    $asetPosterHeavenly = $adalahIslamicHeavenly ? [
        'sabit' => asset('aset-tema/islamic-heavenly/ornamen-sabit.webp'),
        'heroPoster' => asset('aset-tema/islamic-heavenly/hero-poster.webp'),
    ] : [];

    $asetPosterRustic = $adalahRusticFloral ? [
        'garland' => asset('aset-tema/rustic-floral/garland-bunga-rustic.webp?v=1'),
        'bingkaiMempelai' => asset('aset-tema/rustic-floral/bingkai-bunga-mempelai.webp?v=2'),
        'heroPoster' => asset('aset-tema/rustic-floral/hero-poster.webp'),
    ] : [];

    $asetPosterVelvet = $adalahVelvetGarden ? [
        'botani' => asset('aset-tema/velvet-garden/ornamen-botani.webp'),
        'garland' => asset('aset-tema/velvet-garden/garland-velvet.webp?v=1'),
        'bingkaiMempelai' => asset('aset-tema/velvet-garden/bingkai-konservatori-mempelai.webp?v=1'),
        'heroPoster' => asset('aset-tema/velvet-garden/hero-poster.webp'),
    ] : [];

    $asetPosterEditorial = $adalahEditorialMonokrom ? [
        'latar' => asset('aset-tema/editorial-monokrom/latar-utama.webp'),
        'bingkai' => asset('aset-tema/editorial-monokrom/ornamen-bingkai.webp'),
    ] : [];

    $asetPosterNoir = $adalahLuxuryNoir ? [
        'latar' => asset('aset-tema/luxury-noir/latar-utama.webp'),
        'bingkai' => asset('aset-tema/luxury-noir/bingkai-artdeco.webp'),
        'emas' => asset('aset-tema/luxury-noir/ornamen-emas.webp'),
    ] : [];

    $asetPosterRoyal = $adalahRoyalIvory ? [
        'latar' => asset('aset-tema/royal-ivory/latar-utama.webp'),
        'katedral' => asset('aset-tema/royal-ivory/ornamen-katedral.webp'),
    ] : [];

    $adalahEditorial = !empty($poster['editorial']);
    $adalahIslami = !empty($poster['islami']);
    $judulAtas = mb_strtoupper($tema->nama_tema);
    $ukuranJudul = mb_strlen($tema->nama_tema) > 19 ? '4.4cqw' : '4.9cqw';

    // Paduan Warna Bodi Titanium iPhone Pro Serasi Karakter Tiap Tema
    $warnaTitanium = match (true) {
        $adalahRoyalIvory, $adalahRusticFloral, $adalahAdatJawa, $adalahSundaHeritage => 'desert',
        $adalahEditorialMonokrom, $adalahIslamiSyari => 'natural',
        default => 'black',
    };

    // Kontras Ikon Status Bar & Home Indicator iOS untuk Tiap Layar
    $statusHeroGelap = $adalahRusticFloral || $adalahRoyalIvory || (!$adalahAdatJawa && !$adalahSundaHeritage && !$adalahIslamiSyari && !$adalahIslamicHeavenly && !$adalahVelvetGarden && !$adalahEditorialMonokrom && !$adalahLuxuryNoir && empty($poster['gelap']));
    $homeHeroGelap = $adalahRusticFloral;

    $statusInteriorGelap = $adalahRusticFloral || $adalahRoyalIvory || $adalahEditorialMonokrom || $adalahIslamiSyari || $adalahSundaHeritage || (!$adalahLuxuryNoir && !$adalahVelvetGarden && !$adalahIslamicHeavenly && !$adalahAdatJawa && empty($poster['gelap']));
    $homeInteriorGelap = $adalahRusticFloral || $adalahRoyalIvory || $adalahVelvetGarden || $adalahAdatJawa || $adalahSundaHeritage || $adalahIslamiSyari || (!$adalahLuxuryNoir && !$adalahEditorialMonokrom && !$adalahIslamicHeavenly && empty($poster['gelap']));

    // Koordinat Panggung Dual-iPhone Studio (Layar Besar, Rapi, 0% Terpotong, Bebas Badge Lihat Sampul)
    $posisiIphoneKiri = 'left: 10.6cqw; bottom: 5.1cqw; width: 37.8cqw; height: 75.8cqw;';
    $posisiIphoneKanan = 'right: 10.6cqw; bottom: 10.4cqw; width: 36.2cqw; height: 72.6cqw;';
@endphp

<div
    data-mockup-iphone="2"
    class="relative w-full aspect-square overflow-hidden select-none"
    style="container-type: inline-size; background: {{ $poster['latar_css'] }};"
>
    {{-- Pendar Cahaya Studio Lembut di Belakang Dual iPhone --}}
    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-0"
        style="background: radial-gradient(circle at 50% 48%, {{ $adalahEditorialMonokrom ? 'rgba(255,255,255,0.16)' : 'rgba(243,229,171,0.18)' }} 0%, {{ $adalahEditorialMonokrom ? 'rgba(255,255,255,0.03)' : 'rgba(243,229,171,0.03)' }} 45%, transparent 72%);"
    ></div>

    {{-- Plinth Lantai Ivory Bersih --}}
    <div
        class="absolute inset-x-0 bottom-0 border-t border-black/5"
        style="height: 21.5%; background-color: {{ $poster['lantai_hex'] }};"
    ></div>

    {{-- Bayangan Kontak Studio di Bawah Masing-Masing iPhone --}}
    <div
        aria-hidden="true"
        class="pointer-events-none absolute"
        style="left: 7.5cqw; bottom: 3.1cqw; width: 44cqw; height: 4.4cqw; background: radial-gradient(ellipse at center, rgba(0, 0, 0, 0.34) 0%, rgba(0, 0, 0, 0) 72%);"
    ></div>
    <div
        aria-hidden="true"
        class="pointer-events-none absolute"
        style="right: 8cqw; bottom: 8.4cqw; width: 41.5cqw; height: 4cqw; background: radial-gradient(ellipse at center, rgba(0, 0, 0, 0.24) 0%, rgba(0, 0, 0, 0) 72%);"
    ></div>

    {{-- Pita Sudut Kiri Atas untuk Diskon --}}
    @if ($tema->adaDiskon())
        <div class="pointer-events-none absolute top-0 left-0 z-30 h-[30cqw] w-[30cqw] overflow-hidden">
            <div
                class="absolute bg-rose-600 text-white text-center font-bold shadow-md"
                style="top: 5.5cqw; left: -9.5cqw; width: 35cqw; transform: rotate(-45deg); padding: 1.05cqw 0; font-size: 2.75cqw; letter-spacing: 0.02em;"
            >
                {{ $tema->labelBadgeDiskon() }}
            </div>
        </div>
    @endif

    {{-- Header Merek & Nama Tema --}}
    <div class="relative z-10 text-center" style="padding: 3.1cqw 8cqw 0;">
        <p
            class="font-script leading-none drop-shadow-xs"
            style="font-size: 4.15cqw; color: {{ $adalahEditorialMonokrom ? 'rgba(255,255,255,0.92)' : '#F5E4BE' }};"
        >
            SesiTemu.
        </p>
        <p
            class="font-serif-poster font-semibold uppercase text-white truncate drop-shadow-xs"
            style="margin-top: 0.38cqw; font-size: {{ $ukuranJudul }}; line-height: 1.12; letter-spacing: 0.09em;"
        >
            {{ $judulAtas }}
        </p>
        <div class="mx-auto flex items-center justify-center gap-[1.1cqw]" style="margin-top: 0.85cqw;" aria-hidden="true">
            <span style="height: 0.14cqw; width: 8.2cqw; background: linear-gradient(90deg, transparent, {{ $adalahEditorialMonokrom ? 'rgba(255,255,255,0.72)' : 'rgba(231,200,125,0.72)' }});"></span>
            <span style="width: 0.6cqw; height: 0.6cqw; {{ $adalahEditorialMonokrom ? '' : 'transform: rotate(45deg);' }} background: {{ $adalahEditorialMonokrom ? '#FFFFFF' : '#E7C87D' }};"></span>
            <span style="height: 0.14cqw; width: 8.2cqw; background: linear-gradient(270deg, transparent, {{ $adalahEditorialMonokrom ? 'rgba(255,255,255,0.72)' : 'rgba(231,200,125,0.72)' }});"></span>
        </div>
    </div>

    {{-- PANGGUNG DUAL IPHONE PRO TITANIUM --}}
    <div class="absolute inset-x-0 bottom-0 z-10" style="height: 84cqw;">
        {{-- ================================================================= --}}
        {{-- IPHONE 1 (KIRI - UTAMA): SAMPUL / HERO IKONIK TIAP TEMA           --}}
        {{-- ================================================================= --}}
        <x-mockup-iphone
            peran="hero"
            :titanium="$warnaTitanium"
            :status-gelap="$statusHeroGelap"
            :home-gelap="$homeHeroGelap"
            :posisi-style="$posisiIphoneKiri"
            z-class="z-20"
            bayangan="0 2.4cqw 4.8cqw rgba(0,0,0,0.46)"
        >
            @if ($adalahLuxuryNoir)
                {{-- HERO LUXURY NOIR: Panggung Ballroom Art Deco & Monogram Emas --}}
                <div
                    class="relative w-full h-full overflow-hidden flex flex-col justify-between text-center"
                    style="background: #09090D; color: #F5EFE6; padding: 5.4cqw 2.6cqw 3.4cqw;"
                >
                    <img
                        src="{{ $asetPosterNoir['latar'] }}"
                        alt="{{ $tema->nama_tema }}"
                        loading="lazy"
                        class="absolute inset-0 w-full h-full object-cover object-center"
                    >
                    <div
                        aria-hidden="true"
                        class="pointer-events-none absolute inset-0"
                        style="background: linear-gradient(180deg, rgba(9,9,13,0.82) 0%, rgba(9,9,13,0.42) 48%, rgba(6,6,9,0.92) 100%);"
                    ></div>
                    <img
                        src="{{ $asetPosterNoir['bingkai'] }}"
                        alt=""
                        aria-hidden="true"
                        loading="lazy"
                        class="pointer-events-none absolute inset-0 w-full h-full object-contain opacity-92 z-10"
                        style="padding: 1.6cqw 0.75cqw 1.2cqw;"
                    >

                    <div class="relative z-20 my-auto" style="padding: 2.2cqw 1.2cqw 0;">
                        <img
                            src="{{ $asetPosterNoir['emas'] }}"
                            alt=""
                            aria-hidden="true"
                            loading="lazy"
                            class="mx-auto"
                            style="width: 3.6cqw;"
                        >
                        <p class="uppercase font-bold leading-none" style="margin-top: 0.85cqw; font-size: 0.86cqw; letter-spacing: 0.24em; color: #D4AF37;">
                            The Grand Celebration
                        </p>
                        <p class="font-serif-poster uppercase font-bold leading-[1.06] text-white drop-shadow" style="margin-top: 1.1cqw; font-size: 3.55cqw; letter-spacing: 0.08em;">
                            {{ $priaPanggilan }}
                        </p>
                        <div class="flex items-center justify-center gap-[0.8cqw]" style="margin: 0.35cqw 0;">
                            <span style="height: 0.13cqw; width: 2.6cqw; background: rgba(212,175,55,0.78);"></span>
                            <span class="font-script leading-none" style="font-size: 2.85cqw; color: #F3E5AB;">&amp;</span>
                            <span style="height: 0.13cqw; width: 2.6cqw; background: rgba(212,175,55,0.78);"></span>
                        </div>
                        <p class="font-serif-poster uppercase font-bold leading-[1.06] text-white drop-shadow" style="font-size: 3.55cqw; letter-spacing: 0.08em;">
                            {{ $wanitaPanggilan }}
                        </p>
                        <p class="uppercase font-semibold leading-none" style="margin-top: 1.35cqw; font-size: 1.05cqw; letter-spacing: 0.22em; color: #F3E5AB;">
                            {{ $poster['tanggal_pendek'] }}
                        </p>
                    </div>

                    <div class="relative z-20 flex justify-center">
                        <span
                            class="font-serif-poster font-bold uppercase flex items-center justify-center"
                            style="width: 4.4cqw; height: 4.4cqw; border-radius: 9999px; border: 0.15cqw dashed rgba(212,175,55,0.82); background: rgba(9,9,13,0.78); font-size: 1.05cqw; letter-spacing: 0.08em; color: #F3E5AB;"
                        >
                            {{ mb_substr($priaPanggilan, 0, 1) }}&amp;{{ mb_substr($wanitaPanggilan, 0, 1) }}
                        </span>
                    </div>
                </div>
            @elseif ($adalahRoyalIvory)
                {{-- HERO ROYAL IVORY: Royal Fine-Stationery Letterpress Tanpa Foto & Segel Lilin Perunggu --}}
                <div
                    class="relative w-full h-full overflow-hidden flex flex-col justify-between text-center"
                    style="background: #F6EFE4; color: #3B2E25; padding: 5.2cqw 2.4cqw 3.4cqw;"
                >
                    <img
                        src="{{ $asetPosterRoyal['latar'] }}"
                        alt="{{ $tema->nama_tema }}"
                        loading="lazy"
                        class="absolute inset-0 w-full h-full object-cover object-center"
                    >
                    <div
                        aria-hidden="true"
                        class="pointer-events-none absolute inset-0"
                        style="background: linear-gradient(180deg, rgba(251,247,240,0.92) 0%, rgba(250,245,237,0.68) 54%, rgba(62,47,36,0.72) 100%);"
                    ></div>

                    {{-- Lengkungan Tipis Katedral Letterpress --}}
                    <div
                        aria-hidden="true"
                        class="pointer-events-none absolute z-10"
                        style="inset: 3.4cqw 1.4cqw 2.1cqw 1.4cqw; border-radius: 999px 999px 2.1cqw 2.1cqw; border: 0.16cqw solid rgba(158,123,79,0.72);"
                    ></div>

                    {{-- Watermark Monogram Halus --}}
                    <div
                        aria-hidden="true"
                        class="pointer-events-none absolute inset-0 z-10 flex items-center justify-center font-serif-poster font-bold select-none"
                        style="font-size: 13.5cqw; letter-spacing: 0.08em; color: rgba(158,123,79,0.1); padding-bottom: 4cqw;"
                    >
                        {{ mb_substr($priaPanggilan, 0, 1) }}{{ mb_substr($wanitaPanggilan, 0, 1) }}
                    </div>

                    <div class="relative z-20 my-auto" style="padding: 1.6cqw 1.2cqw 0;">
                        <img
                            src="{{ $asetPosterRoyal['katedral'] }}"
                            alt=""
                            aria-hidden="true"
                            loading="lazy"
                            class="mx-auto"
                            style="width: 3.7cqw;"
                        >
                        <p class="uppercase font-bold leading-none" style="margin-top: 0.85cqw; font-size: 0.86cqw; letter-spacing: 0.24em; color: #7B603F;">
                            The Royal Wedding
                        </p>
                        <p class="font-serif-poster font-bold leading-[1.06]" style="margin-top: 1.05cqw; font-size: 3.85cqw; color: #3B2E25;">
                            {{ $priaPanggilan }}
                        </p>
                        <div class="flex items-center justify-center gap-[0.8cqw]" style="margin: 0.25cqw 0;">
                            <span style="height: 0.14cqw; width: 2.6cqw; background: rgba(158,123,79,0.78);"></span>
                            <span class="font-script leading-none" style="font-size: 2.9cqw; color: #9E7B4F;">&amp;</span>
                            <span style="height: 0.14cqw; width: 2.6cqw; background: rgba(158,123,79,0.78);"></span>
                        </div>
                        <p class="font-serif-poster font-bold leading-[1.06]" style="font-size: 3.85cqw; color: #3B2E25;">
                            {{ $wanitaPanggilan }}
                        </p>

                        <div class="mx-auto" style="margin-top: 1.4cqw; width: 14cqw; height: 0.12cqw; background: linear-gradient(90deg, transparent, rgba(158,123,79,0.72), transparent);"></div>
                        <p class="uppercase font-bold leading-none" style="margin-top: 1cqw; font-size: 1.04cqw; letter-spacing: 0.22em; color: #58432B;">
                            {{ $poster['tanggal_pendek'] }}
                        </p>
                    </div>

                    <div class="relative z-20 flex justify-center">
                        <span
                            class="font-serif-poster font-bold uppercase flex items-center justify-center shadow-md"
                            style="width: 4.5cqw; height: 4.5cqw; border-radius: 9999px; background: radial-gradient(circle at 32% 30%, #B99462 0%, #8E6D43 68%, #6D5231 100%); border: 0.18cqw solid #E5C99B; font-size: 1.05cqw; letter-spacing: 0.08em; color: #FAF6EE;"
                        >
                            {{ mb_substr($priaPanggilan, 0, 1) }}&amp;{{ mb_substr($wanitaPanggilan, 0, 1) }}
                        </span>
                    </div>
                </div>
            @elseif ($adalahEditorialMonokrom)
                {{-- HERO EDITORIAL MONOKROM: High-Fashion Exhibition Spread B&W --}}
                <div
                    class="relative w-full h-full overflow-hidden flex flex-col justify-between text-left"
                    style="background: #0E0E11; color: #FAF9F6; padding: 5.2cqw 2.6cqw 3.2cqw;"
                >
                    <img
                        src="{{ $asetPosterEditorial['latar'] }}"
                        alt="{{ $tema->nama_tema }}"
                        loading="lazy"
                        class="absolute inset-0 w-full h-full object-cover object-center grayscale contrast-[1.12]"
                    >
                    <div
                        aria-hidden="true"
                        class="pointer-events-none absolute inset-0"
                        style="background: linear-gradient(180deg, rgba(12,12,15,0.82) 0%, rgba(12,12,15,0.3) 38%, rgba(12,12,15,0.46) 66%, rgba(10,10,13,0.94) 100%);"
                    ></div>

                    {{-- Bingkai Viewfinder Siku Tajam --}}
                    <div aria-hidden="true" class="pointer-events-none absolute z-10" style="inset: 4.1cqw 1.4cqw 2.1cqw 1.4cqw; border: 0.12cqw solid rgba(255,255,255,0.22);">
                        <span class="absolute -top-px -left-px" style="width: 1.25cqw; height: 1.25cqw; border-top: 0.22cqw solid #FFFFFF; border-left: 0.22cqw solid #FFFFFF;"></span>
                        <span class="absolute -top-px -right-px" style="width: 1.25cqw; height: 1.25cqw; border-top: 0.22cqw solid #FFFFFF; border-right: 0.22cqw solid #FFFFFF;"></span>
                        <span class="absolute -bottom-px -left-px" style="width: 1.25cqw; height: 1.25cqw; border-bottom: 0.22cqw solid #FFFFFF; border-left: 0.22cqw solid #FFFFFF;"></span>
                        <span class="absolute -bottom-px -right-px" style="width: 1.25cqw; height: 1.25cqw; border-bottom: 0.22cqw solid #FFFFFF; border-right: 0.22cqw solid #FFFFFF;"></span>
                    </div>

                    <div class="relative z-20 space-y-[0.65cqw]" style="padding: 0 0.45cqw;">
                        <div class="flex items-center justify-between uppercase font-bold leading-none" style="font-size: 0.72cqw; letter-spacing: 0.16em; color: rgba(255,255,255,0.84); padding-bottom: 0.7cqw; border-bottom: 0.12cqw solid rgba(255,255,255,0.28);">
                            <span>NO. 01 &middot; {{ $poster['tanggal_pendek'] }}</span>
                            <span style="border: 0.12cqw solid rgba(255,255,255,0.52); padding: 0.24cqw 0.55cqw; background: rgba(0,0,0,0.48);">35MM B&amp;W</span>
                        </div>
                        <p class="uppercase font-semibold leading-none" style="padding-top: 0.3cqw; font-size: 0.76cqw; letter-spacing: 0.24em; color: rgba(255,255,255,0.78);">
                            We Are Getting Married!
                        </p>
                    </div>

                    <div class="relative z-20 my-auto" style="padding: 0 0.45cqw;">
                        <p class="font-serif-poster uppercase font-bold leading-[0.95] text-white drop-shadow" style="font-size: 4.35cqw; letter-spacing: 0.05em;">
                            {{ $priaPanggilan }}
                        </p>
                        <div class="flex items-center" style="margin: 0.65cqw 0; gap: 0.75cqw;">
                            <span style="height: 0.13cqw; width: 3.1cqw; background: rgba(255,255,255,0.65);"></span>
                            <span class="uppercase font-bold leading-none" style="font-size: 0.74cqw; letter-spacing: 0.2em; color: rgba(255,255,255,0.84);">&amp; / EDITION</span>
                        </div>
                        <p class="font-serif-poster uppercase font-bold leading-[0.95] text-white drop-shadow" style="padding-left: 2cqw; font-size: 4.35cqw; letter-spacing: 0.05em;">
                            {{ $wanitaPanggilan }}
                        </p>
                    </div>

                    <div class="relative z-20 flex items-end justify-between" style="padding: 0.75cqw 0.45cqw 0; border-top: 0.12cqw solid rgba(255,255,255,0.28);">
                        <div>
                            <p class="uppercase font-bold leading-none" style="font-size: 0.62cqw; letter-spacing: 0.22em; color: rgba(255,255,255,0.62);">EXHIBITION DATE</p>
                            <p class="uppercase font-bold leading-none text-white" style="margin-top: 0.35cqw; font-size: 0.84cqw; letter-spacing: 0.18em;">{{ $poster['tanggal_pendek'] }}</p>
                        </div>
                        <span class="font-serif-poster font-bold uppercase leading-none text-white" style="font-size: 1.2cqw; letter-spacing: 0.12em; border: 0.14cqw solid rgba(255,255,255,0.56); background: rgba(0,0,0,0.58); padding: 0.48cqw 0.7cqw;">
                            {{ mb_substr($priaPanggilan, 0, 1) }}{{ mb_substr($wanitaPanggilan, 0, 1) }}
                        </span>
                    </div>
                </div>
            @elseif ($adalahRusticFloral)
                {{-- HERO RUSTIC FLORAL: Watercolor Garden Pergola & Lengkungan Ivory Bersih --}}
                <div class="relative w-full h-full overflow-hidden text-center" style="background: #FBF7EE;">
                    <img
                        src="{{ $asetPosterRustic['heroPoster'] }}"
                        alt="{{ $tema->nama_tema }}"
                        loading="lazy"
                        class="absolute inset-0 w-full h-full object-cover object-center"
                    >
                    <div
                        class="absolute z-20 flex flex-col items-center justify-center text-center"
                        style="inset: 17% 13% 23% 13%;"
                    >
                        <p class="uppercase font-bold leading-none" style="font-size: 0.96cqw; letter-spacing: 0.24em; color: #4B6358;">
                            The Wedding Of
                        </p>
                        <p class="font-serif-poster font-bold leading-[1.06]" style="margin-top: 1.05cqw; font-size: 3.85cqw; color: #223029;">
                            {{ $priaPanggilan }}
                        </p>
                        <div class="flex items-center justify-center gap-[0.85cqw]" style="margin: 0.25cqw 0;">
                            <span style="height: 0.15cqw; width: 2.7cqw; background: rgba(191,161,95,0.88);"></span>
                            <span class="font-script leading-none" style="font-size: 3.1cqw; color: #B86B4B;">&amp;</span>
                            <span style="height: 0.15cqw; width: 2.7cqw; background: rgba(191,161,95,0.88);"></span>
                        </div>
                        <p class="font-serif-poster font-bold leading-[1.06]" style="font-size: 3.85cqw; color: #223029;">
                            {{ $wanitaPanggilan }}
                        </p>
                        <p class="uppercase font-bold leading-none" style="margin-top: 1.35cqw; font-size: 1.12cqw; letter-spacing: 0.24em; color: #4B6358;">
                            {{ $poster['tanggal_pendek'] }}
                        </p>
                    </div>
                </div>
            @elseif ($adalahVelvetGarden)
                {{-- HERO VELVET GARDEN: Konservatori Kaca Zamrud & Tipografi Emas --}}
                <div class="relative w-full h-full overflow-hidden text-center" style="background: #0E1E18;">
                    <img
                        src="{{ $asetPosterVelvet['heroPoster'] }}"
                        alt="{{ $tema->nama_tema }}"
                        loading="lazy"
                        class="absolute inset-0 w-full h-full object-cover object-center"
                    >
                    <div
                        class="absolute z-20 flex flex-col items-center justify-center text-center"
                        style="inset: 16% 12% 21% 12%;"
                    >
                        <img
                            src="{{ $asetPosterVelvet['botani'] }}"
                            alt=""
                            aria-hidden="true"
                            loading="lazy"
                            class="mx-auto drop-shadow"
                            style="width: 4cqw;"
                        >
                        <p class="uppercase font-bold leading-none drop-shadow-xs" style="margin-top: 0.85cqw; font-size: 0.94cqw; letter-spacing: 0.24em; color: #EEDAD4;">
                            The Wedding Of
                        </p>
                        <p class="font-serif-poster font-bold leading-[1.06] text-white drop-shadow" style="margin-top: 1cqw; font-size: 3.75cqw;">
                            {{ $priaPanggilan }}
                        </p>
                        <div class="flex items-center justify-center gap-[0.85cqw]" style="margin: 0.25cqw 0;">
                            <span style="height: 0.15cqw; width: 2.7cqw; background: rgba(223,194,133,0.88);"></span>
                            <span class="font-script leading-none" style="font-size: 3.05cqw; color: #F3DFA2;">&amp;</span>
                            <span style="height: 0.15cqw; width: 2.7cqw; background: rgba(223,194,133,0.88);"></span>
                        </div>
                        <p class="font-serif-poster font-bold leading-[1.06] text-white drop-shadow" style="font-size: 3.75cqw;">
                            {{ $wanitaPanggilan }}
                        </p>
                        <p class="uppercase font-bold leading-none drop-shadow-xs" style="margin-top: 1.3cqw; font-size: 1.1cqw; letter-spacing: 0.24em; color: #F3DFA2;">
                            {{ $poster['tanggal_pendek'] }}
                        </p>
                    </div>
                </div>
            @elseif ($adalahAdatJawa)
                {{-- HERO ADAT JAWA: Panggung Ukiran Keraton, Janur & Joglo --}}
                <div class="relative w-full h-full overflow-hidden text-center" style="background: #3B2316;">
                    <img
                        src="{{ $asetPosterJawa['heroPoster'] }}"
                        alt="{{ $tema->nama_tema }}"
                        loading="lazy"
                        class="absolute inset-0 w-full h-full object-cover object-center"
                    >
                    <div
                        class="absolute z-20 flex flex-col items-center justify-center text-center"
                        style="inset: 17% 14% 37% 14%;"
                    >
                        <p class="font-script leading-none drop-shadow-xs" style="font-size: 2.75cqw; color: #FFF8EC;">
                            The Wedding of
                        </p>
                        <p class="font-serif-poster font-bold uppercase leading-[1.08] drop-shadow-xs" style="margin-top: 1.05cqw; font-size: 3.65cqw; letter-spacing: 0.09em; color: #F3E5AB;">
                            {{ $priaPanggilan }}
                        </p>
                        <div class="flex items-center justify-center gap-[0.85cqw]" style="margin: 0.3cqw 0;">
                            <span style="height: 0.15cqw; width: 2.7cqw; background: rgba(215,187,131,0.78);"></span>
                            <span class="font-script leading-none" style="font-size: 2.9cqw; color: #E6C987;">&amp;</span>
                            <span style="height: 0.15cqw; width: 2.7cqw; background: rgba(215,187,131,0.78);"></span>
                        </div>
                        <p class="font-serif-poster font-bold uppercase leading-[1.08] drop-shadow-xs" style="font-size: 3.65cqw; letter-spacing: 0.09em; color: #F3E5AB;">
                            {{ $wanitaPanggilan }}
                        </p>
                        <p class="uppercase font-semibold leading-none drop-shadow-xs" style="margin-top: 1.45cqw; font-size: 1.15cqw; letter-spacing: 0.24em; color: #FFFAF5;">
                            {{ $poster['tanggal_pendek'] }}
                        </p>
                    </div>
                </div>
            @elseif ($adalahSundaHeritage)
                {{-- HERO SUNDA HERITAGE: Bingkai Oval Marun-Emas Siger Priangan --}}
                <div class="relative w-full h-full overflow-hidden text-center" style="background: #3B1414;">
                    <img
                        src="{{ $asetPosterSunda['heroPoster'] }}"
                        alt="{{ $tema->nama_tema }}"
                        loading="lazy"
                        class="absolute inset-0 w-full h-full object-cover object-center"
                    >
                    <div
                        class="absolute z-20 flex flex-col items-center justify-center text-center"
                        style="inset: 20% 15% 37% 15%;"
                    >
                        <p class="uppercase font-bold leading-none drop-shadow-xs" style="font-size: 1.05cqw; letter-spacing: 0.22em; color: #F3E5AB;">
                            Wilujeng Sumping
                        </p>
                        <p class="font-serif-poster font-bold uppercase leading-[1.08] drop-shadow-xs" style="margin-top: 1.1cqw; font-size: 3.65cqw; letter-spacing: 0.08em; color: #FFFDF8;">
                            {{ $priaPanggilan }}
                        </p>
                        <div class="flex items-center justify-center gap-[0.85cqw]" style="margin: 0.3cqw 0;">
                            <span style="height: 0.15cqw; width: 2.7cqw; background: rgba(231,200,125,0.78);"></span>
                            <span class="font-script leading-none" style="font-size: 2.9cqw; color: #E7C87D;">&amp;</span>
                            <span style="height: 0.15cqw; width: 2.7cqw; background: rgba(231,200,125,0.78);"></span>
                        </div>
                        <p class="font-serif-poster font-bold uppercase leading-[1.08] drop-shadow-xs" style="font-size: 3.65cqw; letter-spacing: 0.08em; color: #FFFDF8;">
                            {{ $wanitaPanggilan }}
                        </p>
                        <p class="uppercase font-semibold leading-none drop-shadow-xs" style="margin-top: 1.45cqw; font-size: 1.15cqw; letter-spacing: 0.24em; color: #F3E5AB;">
                            {{ $poster['tanggal_pendek'] }}
                        </p>
                    </div>
                </div>
            @elseif ($adalahIslamiSyari)
                {{-- HERO ISLAMI SYAR'I: Mihrab Zamrud Alhambra & Mawar Putih --}}
                <div class="relative w-full h-full overflow-hidden text-center" style="background: #0E3A36;">
                    <img
                        src="{{ $asetPosterSyari['heroPoster'] }}"
                        alt="{{ $tema->nama_tema }}"
                        loading="lazy"
                        class="absolute inset-0 w-full h-full object-cover object-center"
                    >
                    <div
                        class="absolute z-20 flex flex-col items-center justify-center text-center"
                        style="inset: 19% 18% 49% 18%;"
                    >
                        <p class="leading-none drop-shadow-xs" style="font-size: 1.7cqw; color: #F3E5AB;">
                            بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                        </p>
                        <p class="uppercase font-bold leading-none drop-shadow-xs" style="margin-top: 0.78cqw; font-size: 0.94cqw; letter-spacing: 0.22em; color: #E6D19C;">
                            Walimatul Ursy
                        </p>
                        <p class="font-serif-poster font-bold uppercase leading-[1.06] drop-shadow-xs" style="margin-top: 0.9cqw; font-size: 3.15cqw; letter-spacing: 0.08em; color: #FFFDF8;">
                            {{ $priaPanggilan }}
                        </p>
                        <div class="flex items-center justify-center gap-[0.75cqw]" style="margin: 0.22cqw 0;">
                            <span style="height: 0.15cqw; width: 2.3cqw; background: rgba(230,209,156,0.78);"></span>
                            <span class="font-script leading-none" style="font-size: 2.55cqw; color: #E6D19C;">&amp;</span>
                            <span style="height: 0.15cqw; width: 2.3cqw; background: rgba(230,209,156,0.78);"></span>
                        </div>
                        <p class="font-serif-poster font-bold uppercase leading-[1.06] drop-shadow-xs" style="font-size: 3.15cqw; letter-spacing: 0.08em; color: #FFFDF8;">
                            {{ $wanitaPanggilan }}
                        </p>
                        <p class="uppercase font-semibold leading-none drop-shadow-xs" style="margin-top: 1cqw; font-size: 1.06cqw; letter-spacing: 0.22em; color: #F3E5AB;">
                            {{ $poster['tanggal_pendek'] }}
                        </p>
                    </div>
                </div>
            @elseif ($adalahIslamicHeavenly)
                {{-- HERO ISLAMIC HEAVENLY: Celestial Sapphire Night & Teratai Putih --}}
                <div class="relative w-full h-full overflow-hidden text-center" style="background: #091322;">
                    <img
                        src="{{ $asetPosterHeavenly['heroPoster'] }}"
                        alt="{{ $tema->nama_tema }}"
                        loading="lazy"
                        class="absolute inset-0 w-full h-full object-cover object-center"
                    >
                    <div
                        class="absolute z-20 flex flex-col items-center justify-center text-center"
                        style="inset: 20% 24% 46% 24%;"
                    >
                        <p class="leading-none drop-shadow-xs" style="font-size: 1.55cqw; color: #F3E5AB;">
                            بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                        </p>
                        <p class="uppercase font-bold leading-none drop-shadow-xs" style="margin-top: 0.72cqw; font-size: 0.88cqw; letter-spacing: 0.2em; color: #D9B664;">
                            Walimatul Ursy
                        </p>
                        <p class="font-serif-poster font-bold uppercase leading-[1.06] drop-shadow-xs" style="margin-top: 0.85cqw; font-size: 2.8cqw; letter-spacing: 0.07em; color: #FFFDF8;">
                            {{ $priaPanggilan }}
                        </p>
                        <div class="flex items-center justify-center gap-[0.7cqw]" style="margin: 0.2cqw 0;">
                            <span style="height: 0.14cqw; width: 2.1cqw; background: rgba(217,182,100,0.78);"></span>
                            <span class="font-script leading-none" style="font-size: 2.4cqw; color: #E7C87D;">&amp;</span>
                            <span style="height: 0.14cqw; width: 2.1cqw; background: rgba(217,182,100,0.78);"></span>
                        </div>
                        <p class="font-serif-poster font-bold uppercase leading-[1.06] drop-shadow-xs" style="font-size: 2.8cqw; letter-spacing: 0.07em; color: #FFFDF8;">
                            {{ $wanitaPanggilan }}
                        </p>
                        <p class="uppercase font-semibold leading-none drop-shadow-xs" style="margin-top: 0.95cqw; font-size: 1cqw; letter-spacing: 0.2em; color: #F3E5AB;">
                            {{ $poster['tanggal_pendek'] }}
                        </p>
                    </div>
                </div>
            @else
                {{-- HERO FALLBACK TEMA KUSTOM --}}
                <div
                    class="relative w-full h-full overflow-hidden flex flex-col items-center justify-center text-center"
                    style="background: {{ $poster['layar_kiri_bg'] }}; padding: 5.5cqw 2.6cqw 3.4cqw;"
                >
                    @if ($gambarLatarTemaUrl)
                        <img
                            src="{{ $gambarLatarTemaUrl }}"
                            alt="{{ $tema->nama_tema }}"
                            loading="lazy"
                            class="absolute inset-0 w-full h-full object-cover object-center {{ $adalahEditorial ? 'grayscale' : '' }}"
                        >
                    @endif
                    <div class="absolute inset-0" style="background: {{ $poster['tengah_scrim'] }};"></div>

                    <div class="relative z-10 w-full" style="color: {{ $poster['tengah_teks'] }};">
                        @if ($adalahIslami)
                            <p class="leading-none opacity-90" style="font-size: 1.9cqw; color: {{ $poster['tengah_aksen'] }}; margin-bottom: 1.2cqw;">
                                بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                            </p>
                        @else
                            <div class="mx-auto rounded-full" style="width: 3.8cqw; height: 0.28cqw; background-color: {{ $poster['tengah_aksen'] }}; margin-bottom: 1.4cqw; opacity: 0.8;"></div>
                        @endif

                        <p class="uppercase font-semibold leading-none" style="font-size: 1.15cqw; letter-spacing: 0.18em; color: {{ $poster['tengah_aksen'] }};">
                            {{ $poster['tagline'] }}
                        </p>
                        <p class="font-serif-poster font-bold leading-[1.08]" style="margin-top: 1.3cqw; font-size: 3.95cqw;">
                            {{ $priaPanggilan }}
                        </p>
                        <p class="font-script leading-none" style="margin: 0.35cqw 0; font-size: 3.05cqw; color: {{ $poster['tengah_aksen'] }};">
                            &amp;
                        </p>
                        <p class="font-serif-poster font-bold leading-[1.08]" style="font-size: 3.95cqw;">
                            {{ $wanitaPanggilan }}
                        </p>
                        <p class="uppercase font-semibold leading-none opacity-85" style="margin-top: 1.8cqw; font-size: 1.2cqw; letter-spacing: 0.22em;">
                            {{ $poster['tanggal_pendek'] }}
                        </p>
                    </div>
                </div>
            @endif
        </x-mockup-iphone>

        {{-- ================================================================= --}}
        {{-- IPHONE 2 (KANAN - PENDAMPING): SEKSI MEMPELAI BERSIH & TERKURASI  --}}
        {{-- ================================================================= --}}
        <x-mockup-iphone
            peran="interior"
            :titanium="$warnaTitanium"
            :status-gelap="$statusInteriorGelap"
            :home-gelap="$homeInteriorGelap"
            :posisi-style="$posisiIphoneKanan"
            z-class="z-10"
            bayangan="0 2cqw 4cqw rgba(0,0,0,0.36)"
        >
            @if ($adalahLuxuryNoir)
                {{-- INTERIOR LUXURY NOIR: Potret Ballroom Obsidian & Emas Bersih --}}
                <div
                    class="relative w-full h-full overflow-hidden flex flex-col justify-between text-center"
                    style="background-color: #0B0B0F; color: #F5EFE6; padding: 5cqw 2cqw 2.8cqw;"
                >
                    <div class="relative z-10 w-full">
                        <img
                            src="{{ $asetPosterNoir['emas'] }}"
                            alt=""
                            aria-hidden="true"
                            loading="lazy"
                            class="mx-auto"
                            style="width: 3cqw;"
                        >
                        <p class="uppercase font-bold leading-none" style="margin-top: 0.45cqw; font-size: 0.76cqw; letter-spacing: 0.22em; color: #D4AF37;">
                            The Couple
                        </p>
                        <p class="font-serif-poster uppercase font-bold leading-tight text-white" style="margin-top: 0.3cqw; font-size: 1.95cqw; letter-spacing: 0.06em;">
                            Mempelai Wanita
                        </p>
                    </div>

                    <div
                        class="relative z-10 w-full flex flex-col justify-between overflow-hidden"
                        style="margin-top: 1.05cqw; flex: 1; border-radius: 1.45cqw; background-color: #15141B; border: 0.16cqw solid rgba(212,175,55,0.58); padding: 1.25cqw 1.15cqw 1.35cqw;"
                    >
                        <div
                            class="mx-auto overflow-hidden bg-black w-full"
                            style="flex: 1; max-height: 29.5cqw; border-radius: 1cqw; border: 0.16cqw solid rgba(212,175,55,0.68);"
                        >
                            <img
                                src="{{ $fotoWanitaUrl }}"
                                alt="{{ $wanitaLengkap }}"
                                loading="lazy"
                                class="w-full h-full object-cover object-top"
                            >
                        </div>

                        <div class="w-full" style="margin-top: 1.1cqw;">
                            <p class="font-serif-poster uppercase font-bold leading-none" style="font-size: 2.35cqw; letter-spacing: 0.06em; color: #F3E5AB;">
                                {{ $wanitaPanggilan }}
                            </p>
                            <p class="font-semibold truncate w-full leading-tight text-white" style="margin-top: 0.42cqw; font-size: 1.05cqw;">
                                {{ $wanitaLengkap }}
                            </p>
                            <p class="truncate w-full leading-tight" style="margin-top: 0.24cqw; font-size: 0.82cqw; color: rgba(245,239,230,0.68);">
                                Putri dari {{ $wanitaAyah }}
                            </p>
                            <div
                                class="inline-flex items-center justify-center uppercase font-bold"
                                style="margin-top: 0.85cqw; padding: 0.36cqw 1.25cqw; font-size: 0.72cqw; letter-spacing: 0.16em; border-radius: 9999px; background: rgba(212,175,55,0.14); border: 0.13cqw solid rgba(212,175,55,0.52); color: #F3E5AB;"
                            >
                                Save The Date &middot; {{ $poster['tanggal_pendek'] }}
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($adalahRoyalIvory)
                {{-- INTERIOR ROYAL IVORY: Kartu Letterpress Katedral & Potret Lengkung Bersih --}}
                <div
                    class="relative w-full h-full overflow-hidden flex flex-col justify-between text-center"
                    style="background-color: #FBF8F3; color: #3B2E25; padding: 5cqw 2cqw 2.8cqw;"
                >
                    <div class="relative z-10 w-full">
                        <img
                            src="{{ $asetPosterRoyal['katedral'] }}"
                            alt=""
                            aria-hidden="true"
                            loading="lazy"
                            class="mx-auto"
                            style="width: 3.1cqw;"
                        >
                        <p class="uppercase font-bold leading-none" style="margin-top: 0.45cqw; font-size: 0.76cqw; letter-spacing: 0.22em; color: #9E7B4F;">
                            Royal Couple
                        </p>
                        <p class="font-serif-poster font-bold leading-tight" style="margin-top: 0.28cqw; font-size: 2.15cqw; color: #3B2E25;">
                            Mempelai Berbahagia
                        </p>
                    </div>

                    <div
                        class="relative z-10 w-full flex flex-col justify-between overflow-hidden shadow-xs"
                        style="margin-top: 1cqw; flex: 1; border-radius: 1.55cqw; background-color: #FFFFFF; border: 0.16cqw solid rgba(158,123,79,0.52); padding: 1.35cqw 1.2cqw 1.35cqw;"
                    >
                        <div
                            class="mx-auto overflow-hidden"
                            style="width: 19.5cqw; height: 27cqw; border-radius: 999px 999px 1.05cqw 1.05cqw; border: 0.22cqw solid rgba(158,123,79,0.68); background-color: #FBF8F3; padding: 0.3cqw;"
                        >
                            <img
                                src="{{ $fotoWanitaUrl }}"
                                alt="{{ $wanitaLengkap }}"
                                loading="lazy"
                                class="w-full h-full object-cover object-top"
                                style="border-radius: 999px 999px 0.75cqw 0.75cqw;"
                            >
                        </div>

                        <div class="w-full" style="margin-top: 0.85cqw;">
                            <p class="font-script leading-none" style="font-size: 3.35cqw; color: #3B2E25;">
                                {{ $wanitaPanggilan }}
                            </p>
                            <p class="font-serif-poster font-bold truncate w-full leading-tight" style="margin-top: 0.35cqw; font-size: 1.18cqw; color: #3B2E25;">
                                {{ $wanitaLengkap }}
                            </p>
                            <p class="truncate w-full leading-tight" style="margin-top: 0.22cqw; font-size: 0.84cqw; color: rgba(59,46,37,0.7);">
                                Putri dari {{ $wanitaAyah }}
                            </p>
                            <div
                                class="inline-flex items-center justify-center uppercase font-bold"
                                style="margin-top: 0.8cqw; padding: 0.36cqw 1.25cqw; font-size: 0.72cqw; letter-spacing: 0.15em; border-radius: 9999px; background-color: #FBF8F3; border: 0.13cqw solid rgba(158,123,79,0.55); color: #58432B;"
                            >
                                Save The Date &middot; {{ $poster['tanggal_pendek'] }}
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($adalahEditorialMonokrom)
                {{-- INTERIOR EDITORIAL MONOKROM: 01 / DOSSIER Obsidian Bride Card --}}
                <div
                    class="relative w-full h-full overflow-hidden flex flex-col justify-between text-left"
                    style="background-color: #FAF9F6; color: #18181B; padding: 5cqw 2cqw 2.8cqw;"
                >
                    <div class="relative z-10 w-full">
                        <div class="flex items-center justify-between uppercase font-bold leading-none" style="font-size: 0.68cqw; letter-spacing: 0.2em; color: #18181B; padding-bottom: 0.65cqw; border-bottom: 0.15cqw solid #18181B;">
                            <span>01 / DOSSIER</span>
                            <span>THE COUPLE</span>
                        </div>
                        <p class="font-serif-poster uppercase font-bold leading-tight" style="margin-top: 0.75cqw; font-size: 2.05cqw; letter-spacing: 0.05em; color: #18181B;">
                            The Bride
                        </p>
                    </div>

                    <div
                        class="relative z-10 w-full flex flex-col justify-between text-center"
                        style="margin-top: 1cqw; flex: 1; background-color: #141417; color: #FAF9F6; border: 0.16cqw solid #18181B; box-shadow: -0.45cqw 0.45cqw 0 0 #71717A; padding: 1.3cqw 1.25cqw 1.4cqw;"
                    >
                        <div class="flex items-center justify-between" style="padding-bottom: 0.65cqw; border-bottom: 0.11cqw solid rgba(255,255,255,0.18);">
                            <img
                                src="{{ $asetPosterEditorial['bingkai'] }}"
                                alt=""
                                aria-hidden="true"
                                loading="lazy"
                                class="invert opacity-85"
                                style="width: 2.15cqw;"
                            >
                            <span class="uppercase font-bold leading-none" style="font-size: 0.66cqw; letter-spacing: 0.2em; color: rgba(250,249,246,0.75);">
                                02 / THE BRIDE
                            </span>
                        </div>

                        <div
                            class="mx-auto overflow-hidden bg-black"
                            style="margin-top: 0.95cqw; width: 18.8cqw; height: 25.5cqw; border: 0.16cqw solid rgba(255,255,255,0.58); padding: 0.34cqw;"
                        >
                            <img
                                src="{{ $fotoWanitaUrl }}"
                                alt="{{ $wanitaLengkap }}"
                                loading="lazy"
                                class="w-full h-full object-cover object-top grayscale contrast-[1.08]"
                            >
                        </div>

                        <div class="w-full" style="margin-top: 0.9cqw;">
                            <p class="font-serif-poster uppercase font-bold leading-none text-white" style="font-size: 2.65cqw; letter-spacing: 0.08em;">
                                {{ $wanitaPanggilan }}
                            </p>
                            <p class="font-semibold truncate w-full leading-tight" style="margin-top: 0.4cqw; font-size: 1cqw; color: rgba(250,249,246,0.92);">
                                {{ $wanitaLengkap }}
                            </p>
                            <div
                                class="inline-flex items-center justify-center uppercase font-bold"
                                style="margin-top: 0.8cqw; padding: 0.34cqw 1.05cqw; font-size: 0.68cqw; letter-spacing: 0.16em; border: 0.12cqw solid rgba(255,255,255,0.52); color: #FAF9F6;"
                            >
                                Save The Date &middot; {{ $poster['tanggal_pendek'] }}
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($adalahRusticFloral)
                {{-- INTERIOR RUSTIC FLORAL: Paviliun Botani Bersih & Bingkai Bunga Mempelai --}}
                <div
                    class="relative w-full h-full overflow-hidden flex flex-col justify-between text-center"
                    style="background-color: #F8F3EA; color: #2F4037; padding: 4.9cqw 1.85cqw 2.7cqw;"
                >
                    @if ($gambarLatarTemaUrl)
                        <img
                            src="{{ $gambarLatarTemaUrl }}"
                            alt=""
                            aria-hidden="true"
                            loading="lazy"
                            class="pointer-events-none absolute inset-0 w-full h-full object-cover opacity-14"
                        >
                    @endif

                    <div class="relative z-10 w-full">
                        <img
                            src="{{ $asetPosterRustic['garland'] }}"
                            alt=""
                            aria-hidden="true"
                            loading="lazy"
                            class="mx-auto drop-shadow-xs"
                            style="width: 11.2cqw;"
                        >
                        <p class="uppercase font-bold leading-none" style="margin-top: 0.38cqw; font-size: 0.78cqw; letter-spacing: 0.24em; color: #B86B4B;">
                            The Couple
                        </p>
                        <p class="font-serif-poster font-bold leading-tight" style="margin-top: 0.3cqw; font-size: 2.05cqw; color: #1F2937;">
                            Mempelai Berbahagia
                        </p>
                    </div>

                    <div
                        class="relative z-10 w-full overflow-hidden shadow-sm flex flex-col"
                        style="margin-top: 0.95cqw; flex: 1; border-radius: 1.9cqw; background-color: #FDFBF7; border: 0.2cqw solid rgba(191,161,95,0.62);"
                    >
                        <div
                            class="relative w-full flex items-center justify-center overflow-hidden"
                            style="background: linear-gradient(180deg, #F5EFE2 0%, #FAF6ED 68%, #FDFBF7 100%); padding: 1.35cqw 0.8cqw 0.4cqw;"
                        >
                            <div
                                class="relative z-10 flex items-center justify-center"
                                style="width: 23.2cqw; aspect-ratio: 780 / 960;"
                            >
                                <div
                                    class="absolute overflow-hidden"
                                    style="inset: 8.5% 12.5% 11.5% 12.5%; border-radius: 999px 999px 1.1cqw 1.1cqw; background-color: #2F4037; box-shadow: 0 0.8cqw 1.6cqw rgba(35,51,43,0.22);"
                                >
                                    <img
                                        src="{{ $fotoWanitaUrl }}"
                                        alt="{{ $wanitaLengkap }}"
                                        loading="lazy"
                                        class="w-full h-full object-cover object-top scale-[1.04]"
                                    >
                                </div>
                                <img
                                    src="{{ $asetPosterRustic['bingkaiMempelai'] }}"
                                    alt=""
                                    aria-hidden="true"
                                    loading="lazy"
                                    class="pointer-events-none relative z-10 w-full h-full object-contain -scale-x-100 drop-shadow-xs"
                                >
                            </div>
                        </div>

                        <div
                            class="relative z-10 flex-1 flex flex-col items-center justify-center text-center w-full"
                            style="background-color: #FDFBF7; padding: 0.35cqw 1.1cqw 1.3cqw;"
                        >
                            <span
                                class="inline-block uppercase font-bold leading-none"
                                style="font-size: 0.72cqw; letter-spacing: 0.16em; padding: 0.32cqw 1.2cqw; border-radius: 9999px; background-color: rgba(75,99,88,0.12); border: 0.12cqw solid rgba(75,99,88,0.28); color: #4B6358;"
                            >
                                Mempelai Wanita
                            </span>
                            <p class="font-script leading-none" style="margin-top: 0.65cqw; font-size: 3.75cqw; color: #4B6358;">
                                {{ $wanitaPanggilan }}
                            </p>
                            <p class="font-serif-poster font-bold truncate w-full leading-tight" style="margin-top: 0.38cqw; font-size: 1.12cqw; color: #1F2937;">
                                {{ $wanitaLengkap }}
                            </p>
                            <div
                                class="inline-flex items-center justify-center uppercase font-bold"
                                style="margin-top: 0.75cqw; padding: 0.34cqw 1.2cqw; font-size: 0.72cqw; letter-spacing: 0.14em; border-radius: 9999px; background-color: rgba(75,99,88,0.08); border: 0.12cqw solid rgba(75,99,88,0.24); color: #4B6358;"
                            >
                                Save The Date &middot; {{ $poster['tanggal_pendek'] }}
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($adalahVelvetGarden)
                {{-- INTERIOR VELVET GARDEN: Paviliun Konservatori Zamrud & Bingkai Emas --}}
                <div
                    class="relative w-full h-full overflow-hidden flex flex-col justify-between text-center"
                    style="background: linear-gradient(180deg, #162C28 0%, #11221F 100%); color: #F4F8F6; padding: 4.9cqw 1.85cqw 2.7cqw;"
                >
                    @if ($gambarLatarTemaUrl)
                        <img
                            src="{{ $gambarLatarTemaUrl }}"
                            alt=""
                            aria-hidden="true"
                            loading="lazy"
                            class="pointer-events-none absolute inset-0 w-full h-full object-cover opacity-18"
                        >
                    @endif

                    <div class="relative z-10 w-full">
                        <img
                            src="{{ $asetPosterVelvet['garland'] }}"
                            alt=""
                            aria-hidden="true"
                            loading="lazy"
                            class="mx-auto drop-shadow"
                            style="width: 11.2cqw;"
                        >
                        <p class="uppercase font-bold leading-none" style="margin-top: 0.38cqw; font-size: 0.78cqw; letter-spacing: 0.24em; color: #EEDAD4;">
                            The Couple
                        </p>
                        <p class="font-serif-poster font-bold leading-tight text-white" style="margin-top: 0.3cqw; font-size: 2.05cqw;">
                            Mempelai Berbahagia
                        </p>
                    </div>

                    <div
                        class="relative z-10 w-full overflow-hidden shadow-lg flex flex-col"
                        style="margin-top: 0.95cqw; flex: 1; border-radius: 1.9cqw; background-color: #FDFBF7; border: 0.2cqw solid rgba(200,164,100,0.72);"
                    >
                        <div
                            class="relative w-full flex items-center justify-center overflow-hidden"
                            style="background: linear-gradient(180deg, #0E201C 0%, #152E28 65%, #1C3B34 100%); padding: 1.3cqw 0.8cqw 0.85cqw;"
                        >
                            <div
                                class="relative z-10 flex items-center justify-center"
                                style="width: 22.8cqw; aspect-ratio: 780 / 960;"
                            >
                                <div
                                    class="absolute overflow-hidden"
                                    style="inset: 8.5% 12.5% 11.5% 12.5%; border-radius: 999px 999px 1.1cqw 1.1cqw; background-color: #0E1E18; box-shadow: 0 0.8cqw 1.8cqw rgba(4,12,9,0.55);"
                                >
                                    <img
                                        src="{{ $fotoWanitaUrl }}"
                                        alt="{{ $wanitaLengkap }}"
                                        loading="lazy"
                                        class="w-full h-full object-cover object-top scale-[1.04]"
                                    >
                                </div>
                                <img
                                    src="{{ $asetPosterVelvet['bingkaiMempelai'] }}"
                                    alt=""
                                    aria-hidden="true"
                                    loading="lazy"
                                    class="pointer-events-none relative z-10 w-full h-full object-contain -scale-x-100 drop-shadow"
                                >
                            </div>
                        </div>

                        <div class="relative z-20 flex justify-center" style="margin-top: -1.15cqw;">
                            <span
                                class="inline-block uppercase font-bold leading-none shadow-xs"
                                style="font-size: 0.7cqw; letter-spacing: 0.16em; padding: 0.34cqw 1.25cqw; border-radius: 9999px; background: linear-gradient(90deg, #DFC285 0%, #C8A464 50%, #DFC285 100%); color: #132623;"
                            >
                                Mempelai Wanita
                            </span>
                        </div>

                        <div
                            class="relative z-10 flex-1 flex flex-col items-center justify-center text-center w-full"
                            style="background-color: #FDFBF7; color: #1F3431; padding: 0.55cqw 1.1cqw 1.25cqw;"
                        >
                            <p class="font-script leading-none" style="font-size: 3.7cqw; color: #132623;">
                                {{ $wanitaPanggilan }}
                            </p>
                            <p class="font-serif-poster font-bold truncate w-full leading-tight" style="margin-top: 0.38cqw; font-size: 1.12cqw; color: #1F3431;">
                                {{ $wanitaLengkap }}
                            </p>
                            <div
                                class="inline-flex items-center justify-center uppercase font-bold"
                                style="margin-top: 0.72cqw; padding: 0.34cqw 1.2cqw; font-size: 0.72cqw; letter-spacing: 0.14em; border-radius: 9999px; background-color: rgba(19,38,35,0.08); border: 0.12cqw solid rgba(200,164,100,0.52); color: #132623;"
                            >
                                Save The Date &middot; {{ $poster['tanggal_pendek'] }}
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($adalahAdatJawa)
                {{-- INTERIOR ADAT JAWA: Kapsul Kubah Gading Gunungan & Potret Oval Emas --}}
                <div
                    class="relative w-full h-full overflow-hidden flex items-stretch justify-center"
                    style="background-color: #3B2316; padding: 4.5cqw 1.65cqw 0;"
                >
                    <img
                        src="{{ $asetPosterJawa['hutan'] }}"
                        alt=""
                        aria-hidden="true"
                        loading="lazy"
                        class="pointer-events-none absolute inset-0 w-full h-full object-cover object-top"
                    >

                    <div
                        class="relative z-10 w-full flex flex-col items-center justify-between text-center overflow-hidden shadow-lg"
                        style="border-radius: 999px 999px 2.4cqw 2.4cqw; border: 0.32cqw solid #D7BB83; background-color: rgba(255,250,245,0.96); color: #2B180F; padding: 3.2cqw 1.5cqw 2.9cqw;"
                    >
                        <img
                            src="{{ $asetPosterJawa['sayapWayang'] }}"
                            alt=""
                            aria-hidden="true"
                            loading="lazy"
                            class="pointer-events-none absolute -scale-x-100 opacity-85"
                            style="top: 38%; left: -2.1cqw; width: 6.2cqw;"
                        >
                        <img
                            src="{{ $asetPosterJawa['bungaLili'] }}"
                            alt=""
                            aria-hidden="true"
                            loading="lazy"
                            class="pointer-events-none absolute opacity-90"
                            style="top: 48%; right: -2.4cqw; width: 7.2cqw;"
                        >

                        <div class="relative z-10 w-full">
                            <img
                                src="{{ $asetPosterJawa['gunungan'] }}"
                                alt=""
                                aria-hidden="true"
                                loading="lazy"
                                class="mx-auto"
                                style="width: 3.5cqw;"
                            >
                            <p class="font-serif-poster font-bold leading-[1.08]" style="margin-top: 0.65cqw; font-size: 2.35cqw; color: #472A1C;">
                                We Are Getting<br>Married!
                            </p>
                        </div>

                        <div
                            class="relative z-10 overflow-hidden shadow-md"
                            style="width: 17.5cqw; height: 25.5cqw; border-radius: 999px; border: 0.3cqw solid #D7BB83; box-shadow: 0 0.8cqw 2cqw rgba(71,42,28,0.22);"
                        >
                            <img
                                src="{{ $fotoWanitaUrl }}"
                                alt="{{ $wanitaLengkap }}"
                                loading="lazy"
                                class="w-full h-full object-cover"
                                style="object-position: 50% 18%;"
                            >
                        </div>

                        <div class="relative z-10 w-full">
                            <p class="font-serif-poster font-bold leading-none" style="font-size: 2.65cqw; color: #472A1C;">
                                {{ $wanitaPanggilan }}
                            </p>
                            <p class="font-serif-poster font-bold truncate leading-tight" style="margin-top: 0.35cqw; font-size: 1.22cqw;">
                                {{ $wanitaLengkap }}
                            </p>
                            <div
                                class="inline-flex items-center justify-center uppercase font-bold"
                                style="margin-top: 0.72cqw; padding: 0.36cqw 1.35cqw; font-size: 0.74cqw; letter-spacing: 0.14em; border-radius: 9999px; background: linear-gradient(135deg, #ECD298 0%, #C79F4B 100%); color: #24130A;"
                            >
                                Save The Date &middot; {{ $poster['tanggal_pendek'] }}
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($adalahSundaHeritage)
                {{-- INTERIOR SUNDA HERITAGE: Paviliun Marun Priangan & Bingkai Emas Siger --}}
                <div
                    class="relative w-full h-full overflow-hidden flex flex-col justify-between text-center"
                    style="background-color: #FAF4E8; color: #4A2020; padding: 4.9cqw 1.85cqw 2.7cqw;"
                >
                    @if ($gambarLatarTemaUrl)
                        <img
                            src="{{ $gambarLatarTemaUrl }}"
                            alt=""
                            aria-hidden="true"
                            loading="lazy"
                            class="pointer-events-none absolute inset-0 w-full h-full object-cover opacity-15"
                        >
                    @endif

                    <div class="relative z-10 w-full">
                        <img
                            src="{{ $asetPosterSunda['siger'] }}"
                            alt=""
                            aria-hidden="true"
                            loading="lazy"
                            class="mx-auto drop-shadow-xs"
                            style="width: 4cqw;"
                        >
                        <p class="uppercase font-bold leading-none" style="margin-top: 0.45cqw; font-size: 0.82cqw; letter-spacing: 0.18em; color: #8E6620;">
                            Pasangan Panganten
                        </p>
                        <p class="font-serif-poster font-bold leading-tight" style="margin-top: 0.3cqw; font-size: 2.1cqw; color: #5A1E1E;">
                            Mempelai Berbahagia
                        </p>
                    </div>

                    <div
                        class="relative z-10 w-full overflow-hidden shadow-md flex flex-col"
                        style="margin-top: 0.95cqw; flex: 1; border-radius: 1.9cqw; background-color: #FFFBF4; border: 0.22cqw solid rgba(197,155,67,0.8);"
                    >
                        <div
                            class="relative flex items-center justify-center overflow-hidden"
                            style="flex: 1.25; background: linear-gradient(180deg, #5F2222 0%, #4A1717 58%, #3B1414 100%); padding: 1.3cqw 1.1cqw 2.4cqw;"
                        >
                            <div
                                class="relative z-10 flex items-center justify-center"
                                style="width: 17.5cqw; aspect-ratio: 780 / 1043;"
                            >
                                <div
                                    class="absolute overflow-hidden"
                                    style="inset: 8.5% 13.5%; border-radius: 50%; background-color: #2E0E0E;"
                                >
                                    <img
                                        src="{{ $fotoWanitaUrl }}"
                                        alt="{{ $wanitaLengkap }}"
                                        loading="lazy"
                                        class="w-full h-full object-cover"
                                        style="object-position: 50% 18%;"
                                    >
                                </div>
                                <img
                                    src="{{ $asetPosterSunda['bingkai'] }}"
                                    alt=""
                                    aria-hidden="true"
                                    loading="lazy"
                                    class="pointer-events-none relative z-10 w-full h-full object-contain drop-shadow"
                                >
                            </div>

                            <img
                                src="{{ $asetPosterSunda['bungaDepan'] }}"
                                alt=""
                                aria-hidden="true"
                                loading="lazy"
                                class="pointer-events-none absolute -bottom-[0.35cqw] inset-x-0 w-full z-20"
                            >
                        </div>

                        <div class="relative z-30 flex justify-center" style="margin-top: -1.25cqw;">
                            <span
                                class="uppercase font-bold leading-none shadow-xs"
                                style="border-radius: 9999px; background: linear-gradient(90deg, #E6C87E 0%, #C59B43 50%, #E6C87E 100%); color: #351010; padding: 0.38cqw 1.35cqw; font-size: 0.78cqw; letter-spacing: 0.14em; border: 0.14cqw solid #FFF7E2;"
                            >
                                Panganten Istri
                            </span>
                        </div>

                        <div class="text-center" style="padding: 0.85cqw 1.1cqw 1.25cqw;">
                            <p class="font-script leading-none" style="font-size: 3.15cqw; color: #5A1E1E;">
                                {{ $wanitaPanggilan }}
                            </p>
                            <p class="font-serif-poster font-bold truncate leading-tight" style="margin-top: 0.35cqw; font-size: 1.18cqw; color: #4A2020;">
                                {{ $wanitaLengkap }}
                            </p>
                            <div
                                class="inline-flex items-center justify-center uppercase font-bold"
                                style="margin-top: 0.7cqw; padding: 0.34cqw 1.2cqw; font-size: 0.72cqw; letter-spacing: 0.14em; border-radius: 9999px; background: linear-gradient(135deg, #6E2C2C 0%, #5A1E1E 100%); color: #FAF4E8; border: 0.12cqw solid rgba(197,155,67,0.65);"
                            >
                                Save The Date &middot; {{ $poster['tanggal_pendek'] }}
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($adalahIslamiSyari)
                {{-- INTERIOR ISLAMI SYAR'I: Paviliun Kubah Zamrud Alhambra & Arabesque --}}
                <div
                    class="relative w-full h-full overflow-hidden flex flex-col justify-between text-center"
                    style="background-color: #F7FBF8; color: #0E3A36; padding: 4.9cqw 1.85cqw 2.7cqw;"
                >
                    @if ($gambarLatarTemaUrl)
                        <img
                            src="{{ $gambarLatarTemaUrl }}"
                            alt=""
                            aria-hidden="true"
                            loading="lazy"
                            class="pointer-events-none absolute inset-0 w-full h-full object-cover opacity-14"
                        >
                    @endif

                    <div class="relative z-10 w-full">
                        <img
                            src="{{ $asetPosterSyari['arabesque'] }}"
                            alt=""
                            aria-hidden="true"
                            loading="lazy"
                            class="mx-auto drop-shadow-xs"
                            style="width: 3.8cqw;"
                        >
                        <p class="uppercase font-bold leading-none" style="margin-top: 0.45cqw; font-size: 0.8cqw; letter-spacing: 0.18em; color: #9E7D40;">
                            Al-Arus
                        </p>
                        <p class="font-serif-poster font-bold leading-tight" style="margin-top: 0.3cqw; font-size: 2.1cqw; color: #0E3A36;">
                            Mempelai Pengantin
                        </p>
                    </div>

                    <div
                        class="relative z-10 w-full overflow-hidden shadow-md flex flex-col"
                        style="margin-top: 0.95cqw; flex: 1; border-radius: 1.9cqw; background-color: #FCFEFD; border: 0.22cqw solid rgba(197,160,89,0.78);"
                    >
                        <div
                            class="relative flex items-center justify-center overflow-hidden"
                            style="flex: 1.25; background: linear-gradient(180deg, #154E48 0%, #0E3A36 58%, #0A2B28 100%); padding: 1.5cqw 1.2cqw 2.2cqw;"
                        >
                            <div
                                class="relative z-10 overflow-hidden shadow-md"
                                style="width: 16.8cqw; height: 21.8cqw; border-radius: 999px 999px 1.4cqw 1.4cqw; border: 0.3cqw solid #D4B56E; background-color: #08221F;"
                            >
                                <img
                                    src="{{ $fotoWanitaUrl }}"
                                    alt="{{ $wanitaLengkap }}"
                                    loading="lazy"
                                    class="w-full h-full object-cover"
                                    style="object-position: 50% 18%;"
                                >
                            </div>
                        </div>

                        <div class="relative z-30 flex justify-center" style="margin-top: -1.25cqw;">
                            <span
                                class="uppercase font-bold leading-none shadow-xs"
                                style="border-radius: 9999px; background: linear-gradient(90deg, #EFE0B4 0%, #D4B56E 50%, #EFE0B4 100%); color: #092623; padding: 0.38cqw 1.35cqw; font-size: 0.78cqw; letter-spacing: 0.14em; border: 0.14cqw solid #FFFBF0;"
                            >
                                Mempelai Wanita
                            </span>
                        </div>

                        <div class="text-center" style="padding: 0.85cqw 1.1cqw 1.25cqw;">
                            <p class="font-script leading-none" style="font-size: 3.15cqw; color: #0E3A36;">
                                {{ $wanitaPanggilan }}
                            </p>
                            <p class="font-serif-poster font-bold truncate leading-tight" style="margin-top: 0.35cqw; font-size: 1.18cqw; color: #16524C;">
                                {{ $wanitaLengkap }}
                            </p>
                            <div
                                class="inline-flex items-center justify-center uppercase font-bold"
                                style="margin-top: 0.7cqw; padding: 0.34cqw 1.2cqw; font-size: 0.72cqw; letter-spacing: 0.14em; border-radius: 9999px; background: linear-gradient(135deg, #16524C 0%, #0E3A36 100%); color: #F7FBF8; border: 0.12cqw solid rgba(197,160,89,0.65);"
                            >
                                Save The Date &middot; {{ $poster['tanggal_pendek'] }}
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($adalahIslamicHeavenly)
                {{-- INTERIOR ISLAMIC HEAVENLY: Observatorium Malam Safir & Kubah Emas --}}
                <div
                    class="relative w-full h-full overflow-hidden flex flex-col justify-between text-center"
                    style="background: linear-gradient(180deg, #102036 0%, #091322 100%); color: #E6EEF8; padding: 4.9cqw 1.85cqw 2.7cqw;"
                >
                    @if ($gambarLatarTemaUrl)
                        <img
                            src="{{ $gambarLatarTemaUrl }}"
                            alt=""
                            aria-hidden="true"
                            loading="lazy"
                            class="pointer-events-none absolute inset-0 w-full h-full object-cover opacity-22"
                        >
                    @endif

                    <div class="relative z-10 w-full">
                        <img
                            src="{{ $asetPosterHeavenly['sabit'] }}"
                            alt=""
                            aria-hidden="true"
                            loading="lazy"
                            class="mx-auto drop-shadow-xs"
                            style="width: 3.5cqw;"
                        >
                        <p class="uppercase font-bold leading-none" style="margin-top: 0.45cqw; font-size: 0.8cqw; letter-spacing: 0.18em; color: #D9B664;">
                            &#10022; Calon Mempelai &#10022;
                        </p>
                        <p class="font-serif-poster font-bold leading-tight text-white" style="margin-top: 0.3cqw; font-size: 2.1cqw;">
                            Mempelai Berbahagia
                        </p>
                    </div>

                    <div
                        class="relative z-10 w-full overflow-hidden shadow-md flex flex-col"
                        style="margin-top: 0.95cqw; flex: 1; border-radius: 1.9cqw; background: linear-gradient(180deg, #152842 0%, #0B1626 100%); border: 0.22cqw solid rgba(217,182,100,0.72);"
                    >
                        <div
                            class="relative flex items-center justify-center overflow-hidden"
                            style="flex: 1.25; padding: 1.5cqw 1.2cqw 2.2cqw;"
                        >
                            <div
                                class="relative z-10 overflow-hidden shadow-md"
                                style="width: 16.8cqw; height: 21.8cqw; border-radius: 999px 999px 1.4cqw 1.4cqw; border: 0.3cqw solid #D9B664; background-color: #091322; box-shadow: 0 0 1.6cqw rgba(217,182,100,0.28);"
                            >
                                <img
                                    src="{{ $fotoWanitaUrl }}"
                                    alt="{{ $wanitaLengkap }}"
                                    loading="lazy"
                                    class="w-full h-full object-cover"
                                    style="object-position: 50% 18%;"
                                >
                            </div>
                        </div>

                        <div class="relative z-30 flex justify-center" style="margin-top: -1.25cqw;">
                            <span
                                class="uppercase font-bold leading-none shadow-xs"
                                style="border-radius: 9999px; background: linear-gradient(90deg, #F3E5AB 0%, #D9B664 50%, #F3E5AB 100%); color: #091322; padding: 0.38cqw 1.35cqw; font-size: 0.78cqw; letter-spacing: 0.14em; border: 0.14cqw solid #FFF8E4;"
                            >
                                Mempelai Wanita
                            </span>
                        </div>

                        <div class="text-center" style="padding: 0.85cqw 1.1cqw 1.25cqw; background-color: rgba(9,19,34,0.45);">
                            <p class="font-script leading-none" style="font-size: 3.15cqw; color: #F3E5AB;">
                                {{ $wanitaPanggilan }}
                            </p>
                            <p class="font-serif-poster font-bold truncate leading-tight text-white" style="margin-top: 0.35cqw; font-size: 1.18cqw;">
                                {{ $wanitaLengkap }}
                            </p>
                            <div
                                class="inline-flex items-center justify-center uppercase font-bold"
                                style="margin-top: 0.7cqw; padding: 0.34cqw 1.2cqw; font-size: 0.72cqw; letter-spacing: 0.14em; border-radius: 9999px; background: linear-gradient(135deg, #18304F 0%, #091322 100%); color: #F3E5AB; border: 0.13cqw solid rgba(217,182,100,0.68);"
                            >
                                Save The Date &middot; {{ $poster['tanggal_pendek'] }}
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- INTERIOR FALLBACK TEMA KUSTOM --}}
                <div
                    class="relative w-full h-full overflow-hidden flex flex-col items-center justify-between text-center"
                    style="background-color: {{ $poster['kanan_bg'] }}; color: {{ $poster['kanan_teks'] }}; padding: 5.2cqw 2cqw 3cqw;"
                >
                    @if ($gambarLatarTemaUrl)
                        <img
                            src="{{ $gambarLatarTemaUrl }}"
                            alt=""
                            aria-hidden="true"
                            loading="lazy"
                            class="pointer-events-none absolute inset-0 w-full h-full object-cover {{ $poster['gelap'] ? 'opacity-20' : 'opacity-12' }} {{ $adalahEditorial ? 'grayscale' : '' }}"
                        >
                    @endif

                    <div class="relative z-10 w-full">
                        <p
                            class="{{ $adalahEditorial ? 'font-serif-poster uppercase tracking-[0.14em] font-semibold' : 'font-script' }} leading-[1.12]"
                            style="font-size: {{ $adalahEditorial ? '2.1cqw' : '3.15cqw' }};"
                        >
                            We Are<br>Getting Married!
                        </p>
                    </div>

                    <div
                        class="relative z-10 overflow-hidden shadow-md"
                        style="width: 19cqw; height: 27cqw; border-radius: {{ $adalahEditorial ? '0.6cqw' : '999px' }}; border: 0.34cqw solid {{ $poster['tengah_aksen'] }};"
                    >
                        <img
                            src="{{ $fotoCoupleUrl }}"
                            alt="Pasangan {{ $priaPanggilan }} &amp; {{ $wanitaPanggilan }}"
                            loading="lazy"
                            class="w-full h-full object-cover object-top {{ $adalahEditorial ? 'grayscale' : '' }}"
                        >
                    </div>

                    <div class="relative z-10 w-full">
                        <p class="font-script leading-none" style="font-size: 3.15cqw; color: {{ $poster['tengah_aksen'] }};">
                            {{ $wanitaPanggilan }}
                        </p>
                        <p class="font-bold truncate leading-tight" style="margin-top: 0.35cqw; font-size: 1.35cqw;">
                            {{ $wanitaLengkap }}
                        </p>
                        <div
                            class="inline-flex items-center justify-center uppercase font-bold"
                            style="margin-top: 0.7cqw; padding: 0.34cqw 1.2cqw; font-size: 0.74cqw; letter-spacing: 0.14em; border-radius: 9999px; border: 0.13cqw solid {{ $poster['tengah_aksen'] }}88;"
                        >
                            Save The Date &middot; {{ $poster['tanggal_pendek'] }}
                        </div>
                    </div>
                </div>
            @endif
        </x-mockup-iphone>
    </div>
</div>
