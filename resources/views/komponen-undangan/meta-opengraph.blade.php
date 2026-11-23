@php
    $gayaFont = $undangan->resolusiGayaFont();
    $tanpaFoto = $undangan->modeTanpaFoto();
    $ogJudul = 'The Wedding of ' . $undangan->nama_panggilan_pria . ' & ' . $undangan->nama_panggilan_wanita;
    $ogDeskripsi =
        'Kepada Yth. ' .
        $namaTamu .
        '. Tanpa mengurangi rasa hormat, kami mengundang Anda untuk hadir di acara pernikahan kami.';
    $ogGambar = $tanpaFoto
        ? $undangan->tema?->urlGambarPratinjau() ?? asset('aset-demo/tema-rustic-floral.webp')
        : $undangan->urlFotoSampul() ??
            ($undangan->urlFotoPria() ??
                ($undangan->urlFotoWanita() ??
                    ($undangan->tema?->urlGambarPratinjau() ?? asset('aset-demo/tema-rustic-floral.webp'))));
@endphp

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $ogJudul }}</title>
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
<link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">
<meta name="description" content="{{ $ogDeskripsi }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="{{ $ogJudul }}">
<meta property="og:description" content="{{ $ogDeskripsi }}">
<meta property="og:image" content="{{ $ogGambar }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $ogJudul }}">
<meta name="twitter:description" content="{{ $ogDeskripsi }}">
<meta name="twitter:image" content="{{ $ogGambar }}">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="{{ $gayaFont['google_fonts_url'] }}" rel="stylesheet" />
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
    :root {
        --font-tema-judul: {!! $gayaFont['judul_css'] !!};
        --font-tema-isi: {!! $gayaFont['isi_css'] !!};
        --font-tema-aksen: {!! $gayaFont['aksen_css'] !!};
        --font-serif: var(--font-tema-judul);
        --font-sans: var(--font-tema-isi);
    }

    body {
        font-family: var(--font-tema-isi);
    }

    .font-serif {
        font-family: var(--font-tema-judul) !important;
    }

    .font-kaligrafi {
        font-family: var(--font-tema-aksen) !important;
    }

    @keyframes nafasAmbient {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.06);
        }
    }

    @keyframes goyangAngin {

        0%,
        100% {
            transform: rotate(-3deg) translateY(0px);
        }

        50% {
            transform: rotate(3deg) translateY(-6px);
        }
    }

    @keyframes melayangHalus {

        0%,
        100% {
            transform: translateY(0px) translateX(0px) rotate(0deg);
            opacity: 0.45;
        }

        50% {
            transform: translateY(-14px) translateX(8px) rotate(8deg);
            opacity: 0.9;
        }
    }

    @keyframes kelipBintang {

        0%,
        100% {
            opacity: 0.25;
            transform: scale(0.85);
        }

        50% {
            opacity: 1;
            transform: scale(1.2);
        }
    }

    @keyframes kilauEmas {

        0%,
        100% {
            opacity: 0.55;
        }

        50% {
            opacity: 1;
        }
    }

    @keyframes putarKaset {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    @keyframes kelopakJatuh {
        0% {
            transform: translate3d(0, -12%, 0) rotate(0deg) scale(0.9);
            opacity: 0;
        }

        15% {
            opacity: 0.85;
        }

        50% {
            transform: translate3d(26px, 48vh, 0) rotate(140deg) scale(1);
            opacity: 0.75;
        }

        85% {
            opacity: 0.8;
        }

        100% {
            transform: translate3d(-18px, 105vh, 0) rotate(300deg) scale(0.85);
            opacity: 0;
        }
    }

    @keyframes kunangKunang {

        0%,
        100% {
            transform: translate3d(0, 0, 0) scale(0.75);
            opacity: 0.2;
        }

        35% {
            transform: translate3d(18px, -22px, 0) scale(1.25);
            opacity: 0.95;
        }

        70% {
            transform: translate3d(-14px, -10px, 0) scale(0.95);
            opacity: 0.55;
        }
    }

    @keyframes debuEmasNaik {
        0% {
            transform: translate3d(0, 24px, 0) scale(0.6);
            opacity: 0;
        }

        25% {
            opacity: 0.85;
        }

        75% {
            opacity: 0.65;
        }

        100% {
            transform: translate3d(10px, -110px, 0) scale(1.15);
            opacity: 0;
        }
    }

    @keyframes bintangJatuh {
        0% {
            transform: translate3d(0, 0, 0) rotate(-32deg) scaleX(0.2);
            opacity: 0;
        }

        8% {
            opacity: 1;
            transform: translate3d(-35px, 22px, 0) rotate(-32deg) scaleX(1);
        }

        22% {
            transform: translate3d(-220px, 138px, 0) rotate(-32deg) scaleX(0.6);
            opacity: 0;
        }

        100% {
            transform: translate3d(-220px, 138px, 0) rotate(-32deg) scaleX(0.2);
            opacity: 0;
        }
    }

    @keyframes orbitHalus {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    @keyframes shimmerSweep {
        0% {
            transform: translateX(-120%) skewX(-18deg);
        }

        45%,
        100% {
            transform: translateX(220%) skewX(-18deg);
        }
    }

    @keyframes marqueeGeser {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    @keyframes denyutSegel {

        0%,
        100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(212, 175, 55, 0.35);
        }

        50% {
            transform: scale(1.04);
            box-shadow: 0 0 0 12px rgba(212, 175, 55, 0);
        }
    }

    @keyframes awanGeser {

        0%,
        100% {
            transform: translateX(-10px);
        }

        50% {
            transform: translateX(12px);
        }
    }

    .animasi-nafas {
        animation: nafasAmbient 18s ease-in-out infinite;
    }

    .animasi-goyang {
        animation: goyangAngin 6s ease-in-out infinite;
    }

    .animasi-melayang {
        animation: melayangHalus 7s ease-in-out infinite;
    }

    .animasi-bintang {
        animation: kelipBintang 4s ease-in-out infinite;
    }

    .animasi-kilau {
        animation: kilauEmas 4.5s ease-in-out infinite;
    }

    .animasi-putar-kaset {
        animation: putarKaset 5s linear infinite;
    }

    .animasi-putar-jeda {
        animation-play-state: paused;
    }

    .animasi-kelopak-jatuh {
        animation: kelopakJatuh 11s linear infinite;
    }

    .animasi-kunang {
        animation: kunangKunang 5.5s ease-in-out infinite;
    }

    .animasi-debu-emas {
        animation: debuEmasNaik 6.5s ease-in-out infinite;
    }

    .animasi-bintang-jatuh {
        animation: bintangJatuh 7.5s ease-out infinite;
    }

    .animasi-orbit {
        animation: orbitHalus 30s linear infinite;
    }

    .animasi-orbit-balik {
        animation: orbitHalus 42s linear infinite reverse;
    }

    .animasi-segel {
        animation: denyutSegel 3.2s ease-in-out infinite;
    }

    .animasi-awan {
        animation: awanGeser 9s ease-in-out infinite;
    }

    .animasi-marquee {
        display: flex;
        width: max-content;
        animation: marqueeGeser 26s linear infinite;
    }

    .efek-shimmer-kartu {
        position: relative;
        overflow: hidden;
    }

    @keyframes gulirRoda {

        0%,
        100% {
            transform: translateY(0);
            opacity: 0.95;
        }

        65% {
            transform: translateY(10px);
            opacity: 0.2;
        }
    }

    .animasi-gulir-roda {
        animation: gulirRoda 1.8s ease-in-out infinite;
    }

    .efek-shimmer-kartu::after {
        content: "";
        position: absolute;
        inset: 0;
        width: 45%;
        background: linear-gradient(90deg, transparent, rgba(243, 229, 171, 0.14), transparent);
        pointer-events: none;
        animation: shimmerSweep 6s ease-in-out infinite;
    }

    /* === ENGINE DIORAMA & PERGERAKAN 3D (RINGAN & RESPONSIF DI SEMUA BROWSER) === */
    .panggung-3d {
        perspective: 1600px;
    }

    main.panggung-3d {
        perspective: none;
        transform-style: flat;
    }

    .lapis-3d {
        transform: translate3d(calc(var(--px, 0) * var(--depth, 10px)),
                calc(var(--py, 0) * var(--depth, 8px) + var(--ps, 0px)),
                var(--pz, 0px));
        transition: transform 0.28s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .kartu-3d {
        position: relative;
        transition: box-shadow 0.18s ease, border-color 0.18s ease;
        box-shadow:
            0 16px 36px -14px rgba(0, 0, 0, 0.2),
            0 4px 12px -4px rgba(0, 0, 0, 0.1),
            inset 0 1px 0 0 rgba(255, 255, 255, 0.24);
    }

    .kartu-3d:hover {
        box-shadow:
            0 24px 48px -16px rgba(0, 0, 0, 0.28),
            0 8px 20px -8px rgba(191, 161, 95, 0.22),
            inset 0 1px 0 0 rgba(255, 255, 255, 0.34);
    }

    /* Jeda seluruh animasi di balik tirai sampul yang sudah terbuka dan hero yang sudah terlewat gulir */
    .tirai-fade-halus.tirai-terbuka,
    .tirai-fade-halus.tirai-terbuka *,
    .tirai-fade-halus.tirai-terbuka *::before,
    .tirai-fade-halus.tirai-terbuka *::after,
    [data-diorama-3d].hero-tidak-terlihat *,
    [data-diorama-3d].hero-tidak-terlihat *::before,
    [data-diorama-3d].hero-tidak-terlihat *::after {
        animation-play-state: paused !important;
    }

    /* Pastikan tombol & tautan selalu responsif instan saat di-hover/klik */
    [data-transisi-sampul] button,
    main[data-panggung-3d] a,
    main[data-panggung-3d] button {
        transition-duration: 120ms;
    }

    body.siap-3d .masuk-3d {
        opacity: 0;
        transform: translate3d(0, 26px, 0) scale(0.98);
        transition: none;
        backface-visibility: hidden;
    }

    body.siap-3d .masuk-3d.fx-dari-atas {
        transform: translate3d(0, -24px, 0) scale(0.98);
    }

    body.siap-3d .masuk-3d.terlihat {
        opacity: 1;
        transform: translate3d(0, 0, 0) scale(1);
        transition:
            opacity 0.78s cubic-bezier(0.16, 1, 0.3, 1),
            transform 0.88s cubic-bezier(0.16, 1, 0.3, 1),
            box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes ayun3d {

        0%,
        100% {
            transform: perspective(900px) rotateZ(-2.5deg) rotateY(-7deg) translate3d(0, 0px, 18px);
        }

        50% {
            transform: perspective(900px) rotateZ(2.5deg) rotateY(7deg) translate3d(0, -7px, 28px);
        }
    }

    @keyframes ayun3dBalik {

        0%,
        100% {
            transform: perspective(900px) scaleX(-1) rotateZ(-2.5deg) rotateY(-7deg) translate3d(0, 0px, 18px);
        }

        50% {
            transform: perspective(900px) scaleX(-1) rotateZ(2.5deg) rotateY(7deg) translate3d(0, -7px, 28px);
        }
    }

    @keyframes kelopak3d {
        0% {
            transform: perspective(700px) translate3d(0, -10%, 0) rotate3d(1, 0.8, 0.3, 0deg) scale(0.9);
            opacity: 0;
        }

        15% {
            opacity: 0.92;
        }

        50% {
            transform: perspective(700px) translate3d(28px, 48vh, 45px) rotate3d(1, 0.9, 0.5, 190deg) scale(1.05);
            opacity: 0.82;
        }

        85% {
            opacity: 0.78;
        }

        100% {
            transform: perspective(700px) translate3d(-20px, 104vh, 10px) rotate3d(1, 0.6, 0.4, 360deg) scale(0.85);
            opacity: 0;
        }
    }

    @keyframes burungTerbang {
        0% {
            transform: translate3d(-18%, 32px, 15px) scale(0.75);
            opacity: 0;
        }

        12% {
            opacity: 0.78;
        }

        55% {
            transform: translate3d(52vw, -18px, 45px) scale(0.95);
            opacity: 0.72;
        }

        88% {
            opacity: 0.65;
        }

        100% {
            transform: translate3d(115%, -48px, 25px) scale(0.82);
            opacity: 0;
        }
    }

    @keyframes sayapKepak {

        0%,
        100% {
            transform: scaleY(1);
        }

        50% {
            transform: scaleY(0.32);
        }
    }

    @keyframes sinarCahaya {

        0%,
        100% {
            opacity: 0.25;
            transform: rotate(-18deg) scaleY(1);
        }

        50% {
            opacity: 0.55;
            transform: rotate(-14deg) scaleY(1.08);
        }
    }

    @keyframes flipAngka3d {
        0% {
            transform: perspective(500px) rotateX(-68deg) scale(0.92);
            opacity: 0.45;
        }

        100% {
            transform: perspective(500px) rotateX(0deg) scale(1);
            opacity: 1;
        }
    }

    .animasi-ayun-3d {
        animation: ayun3d 7s ease-in-out infinite;
        transform-origin: top left;
    }

    .animasi-ayun-3d-balik {
        animation: ayun3dBalik 7.4s ease-in-out infinite;
        transform-origin: top center;
    }

    .animasi-kelopak-3d {
        animation: kelopak3d 11.5s linear infinite;
    }

    .animasi-burung {
        animation: burungTerbang 18s linear infinite;
    }

    .animasi-kepak {
        transform-box: fill-box;
        transform-origin: center;
        animation: sayapKepak 0.55s ease-in-out infinite;
    }

    .animasi-sinar {
        animation: sinarCahaya 9s ease-in-out infinite;
        pointer-events: none;
    }

    .angka-flip-3d {
        display: inline-block;
        animation: flipAngka3d 0.36s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .tirai-fade-halus {
        opacity: 1;
        transform: scale(1);
        transition:
            opacity 0.6s cubic-bezier(0.22, 1, 0.36, 1),
            transform 0.65s cubic-bezier(0.22, 1, 0.36, 1);
        will-change: opacity, transform;
    }

    .tirai-fade-halus.tirai-terbuka {
        opacity: 0;
        transform: scale(1.03);
    }

    /* === KOREOGRAFI DIORAMA 3D MULTI-LAPIS ADAT JAWA KERATON (60FPS GPU-COMPOSITED) === */
    @keyframes sapuGununganKiri {
        0% {
            opacity: 0.98;
            transform: translate3d(-10%, 2%, 0) scale(1.52);
        }

        35% {
            opacity: 0.92;
            transform: translate3d(-32%, 3%, 0) scale(1.72);
        }

        100% {
            opacity: 0;
            transform: translate3d(-118%, 8%, 0) scale(2.05);
        }
    }

    @keyframes sapuGununganKanan {
        0% {
            opacity: 0.98;
            transform: scaleX(-1) translate3d(-10%, 2%, 0) scale(1.52);
        }

        35% {
            opacity: 0.92;
            transform: scaleX(-1) translate3d(-32%, 3%, 0) scale(1.72);
        }

        100% {
            opacity: 0;
            transform: scaleX(-1) translate3d(-118%, 8%, 0) scale(2.05);
        }
    }

    @keyframes latarHutanDolly {
        0% {
            transform: scale(1.18) translate3d(0, 12px, 0);
        }

        100% {
            transform: scale(1.03) translate3d(0, 0, 0);
        }
    }

    @keyframes pendopoNaik3D {
        0% {
            opacity: 0;
            transform: translate3d(0, 48px, 0) scale(0.93);
        }

        100% {
            opacity: 1;
            transform: translate3d(0, 0, 0) scale(1);
        }
    }

    @keyframes janurMasukKiri {
        0% {
            opacity: 0;
            transform: translate3d(-34%, 14px, 0) rotate(-10deg) scale(1.08);
        }

        100% {
            opacity: 1;
            transform: translate3d(0, 0, 0) rotate(0deg) scale(1);
        }
    }

    @keyframes janurMasukKanan {
        0% {
            opacity: 0;
            transform: scaleX(-1) translate3d(-34%, 14px, 0) rotate(-10deg) scale(1.08);
        }

        100% {
            opacity: 1;
            transform: scaleX(-1) translate3d(0, 0, 0) rotate(0deg) scale(1);
        }
    }

    @keyframes ayunJanurKiri {

        0%,
        100% {
            transform: rotate(-2.2deg) translate3d(0, 0, 0);
        }

        50% {
            transform: rotate(2.6deg) translate3d(3px, -3px, 0);
        }
    }

    @keyframes ayunJanurKanan {

        0%,
        100% {
            transform: scaleX(-1) rotate(-2.2deg) translate3d(0, 0, 0);
        }

        50% {
            transform: scaleX(-1) rotate(2.6deg) translate3d(3px, -3px, 0);
        }
    }

    @keyframes bungaMekarBawah {
        0% {
            opacity: 0;
            transform: translate3d(0, 44px, 0) scale(1.08);
        }

        100% {
            opacity: 1;
            transform: translate3d(0, 0, 0) scale(1);
        }
    }

    @keyframes bingkaiUkiranMekar {
        0% {
            opacity: 0;
            transform: translate3d(0, 26px, 0) scale(0.86);
        }

        100% {
            opacity: 1;
            transform: translate3d(0, 0, 0) scale(1);
        }
    }

    @keyframes jawaTeksMekar {
        0% {
            opacity: 0;
            transform: translate3d(0, 14px, 0) scale(0.97);
        }

        100% {
            opacity: 1;
            transform: translate3d(0, 0, 0) scale(1);
        }
    }

    @keyframes kawananBurungJawa {
        0% {
            opacity: 0;
            transform: translate3d(-15%, 45px, 0) scale(0.68);
        }

        14% {
            opacity: 0.82;
        }

        62% {
            opacity: 0.78;
            transform: translate3d(48%, -38px, 0) scale(0.9);
        }

        100% {
            opacity: 0;
            transform: translate3d(118%, -105px, 0) scale(0.72);
        }
    }

    .jawa-sapu-kiri {
        animation: sapuGununganKiri 1.7s cubic-bezier(0.16, 1, 0.3, 1) 0.05s forwards;
        will-change: transform, opacity;
        backface-visibility: hidden;
    }

    .jawa-sapu-kanan {
        animation: sapuGununganKanan 1.7s cubic-bezier(0.16, 1, 0.3, 1) 0.05s forwards;
        will-change: transform, opacity;
        backface-visibility: hidden;
    }

    .jawa-latar-dolly {
        animation: latarHutanDolly 2.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        will-change: transform;
        backface-visibility: hidden;
    }

    .jawa-pendopo-masuk {
        animation: pendopoNaik3D 1.45s cubic-bezier(0.16, 1, 0.3, 1) 0.25s both;
        will-change: transform, opacity;
        backface-visibility: hidden;
    }

    .jawa-janur-kiri {
        transform-origin: bottom left;
        animation:
            janurMasukKiri 1.4s cubic-bezier(0.16, 1, 0.3, 1) 0.4s both,
            ayunJanurKiri 9s ease-in-out 1.8s infinite;
        will-change: transform, opacity;
        backface-visibility: hidden;
    }

    .jawa-janur-kanan {
        transform-origin: bottom center;
        animation:
            janurMasukKanan 1.4s cubic-bezier(0.16, 1, 0.3, 1) 0.4s both,
            ayunJanurKanan 9.6s ease-in-out 1.8s infinite;
        will-change: transform, opacity;
        backface-visibility: hidden;
    }

    .jawa-bunga-masuk {
        animation: bungaMekarBawah 1.4s cubic-bezier(0.16, 1, 0.3, 1) 0.35s both;
        will-change: transform, opacity;
        backface-visibility: hidden;
    }

    .jawa-bingkai-masuk {
        animation: bingkaiUkiranMekar 1.35s cubic-bezier(0.16, 1, 0.3, 1) 1.3s both;
        will-change: transform, opacity;
        backface-visibility: hidden;
    }

    .jawa-teks-masuk {
        animation: jawaTeksMekar 1.05s cubic-bezier(0.16, 1, 0.3, 1) 1.75s both;
        will-change: transform, opacity;
        backface-visibility: hidden;
    }

    .jawa-burung-terbang {
        animation: kawananBurungJawa 15s linear infinite;
        will-change: transform, opacity;
    }

    .jawa-tombol-emas {
        background-image: linear-gradient(180deg, #D7BB83 0%, #A38C5E 100%);
        color: #FFFFFF;
        box-shadow: 0 10px 24px -10px rgba(71, 42, 28, 0.55);
    }

    .jawa-tombol-emas:hover {
        filter: brightness(1.06);
    }

    .jawa-potret-tutup-kiri {
        transform: rotate(-32deg) scaleX(-1);
    }

    .jawa-potret-tutup-kanan {
        transform: rotate(32deg);
    }

    /* === DIORAMA 3D PEMBUKAAN BERTINGKAT SESUAI TIER (BASIC / PREMIUM / EKSKLUSIF) === */
    @keyframes kameraDiorama3D {

        0%,
        100% {
            transform: translate3d(0, 0, 0);
        }

        50% {
            transform: translate3d(0, -3px, 0);
        }
    }

    @keyframes latarDolly3D {
        0% {
            transform: scale(1.32) translate3d(0, 18px, -110px);
        }

        100% {
            transform: scale(1.04) translate3d(0, 0, 0);
        }
    }

    @keyframes latarDollyBasic {
        0% {
            transform: scale(1.18) translate3d(0, 8px, -40px);
        }

        100% {
            transform: scale(1.02) translate3d(0, 0, 0);
        }
    }

    @keyframes sayapBukaKiri3D {
        0% {
            opacity: 0;
            transform: perspective(1100px) translate3d(42%, 8%, 120px) rotateY(-28deg) scale(1.48);
        }

        25% {
            opacity: 0.95;
        }

        100% {
            opacity: 0.85;
            transform: perspective(1100px) translate3d(-10%, 0%, 28px) rotateY(14deg) scale(1);
        }
    }

    @keyframes sayapBukaKanan3D {
        0% {
            opacity: 0;
            transform: perspective(1100px) scaleX(-1) translate3d(42%, 8%, 120px) rotateY(-28deg) scale(1.48);
        }

        25% {
            opacity: 0.95;
        }

        100% {
            opacity: 0.85;
            transform: perspective(1100px) scaleX(-1) translate3d(-10%, 0%, 28px) rotateY(14deg) scale(1);
        }
    }

    @keyframes sudutTerbangKiri3D {
        0% {
            opacity: 0;
            transform: perspective(1000px) translate3d(-44px, 56px, 165px) rotateZ(-16deg) scale(1.65);
        }

        100% {
            opacity: 0.92;
            transform: perspective(1000px) translate3d(0, 0, 48px) rotateZ(0deg) scale(1);
        }
    }

    @keyframes sudutTerbangKanan3D {
        0% {
            opacity: 0;
            transform: perspective(1000px) scaleX(-1) translate3d(-44px, 56px, 165px) rotateZ(-16deg) scale(1.65);
        }

        100% {
            opacity: 0.92;
            transform: perspective(1000px) scaleX(-1) translate3d(0, 0, 48px) rotateZ(0deg) scale(1);
        }
    }

    @keyframes portalBingkaiMasuk3D {
        0% {
            opacity: 0;
            transform: perspective(1200px) translate3d(0, 36px, -220px) rotateX(18deg) scale(0.74);
        }

        100% {
            opacity: 1;
            transform: perspective(1200px) translate3d(0, 0, 20px) rotateX(0deg) scale(1);
        }
    }

    @keyframes portalBingkaiBasic3D {
        0% {
            opacity: 0;
            transform: perspective(1200px) translate3d(0, 26px, -90px) rotateX(10deg) scale(0.88);
        }

        100% {
            opacity: 1;
            transform: perspective(1200px) translate3d(0, 0, 0) rotateX(0deg) scale(1);
        }
    }

    @keyframes ledakanMonogramPortal {
        0% {
            opacity: 1;
            transform: perspective(1200px) translate3d(-50%, -50%, 40px) scale(1) rotateZ(0deg);
        }

        65% {
            opacity: 0.85;
            transform: perspective(1200px) translate3d(-50%, -50%, 210px) scale(2.15) rotateZ(12deg);
        }

        100% {
            opacity: 0;
            transform: perspective(1200px) translate3d(-50%, -50%, 300px) scale(2.85) rotateZ(22deg);
        }
    }

    @keyframes kupuTerbang3D {
        0% {
            transform: perspective(800px) translate3d(-20%, 60px, 20px) rotateZ(-12deg) scale(0.75);
            opacity: 0;
        }

        12% {
            opacity: 0.92;
        }

        38% {
            transform: perspective(800px) translate3d(38%, -18px, 75px) rotateZ(10deg) scale(1.05);
            opacity: 0.95;
        }

        70% {
            transform: perspective(800px) translate3d(78%, 22px, 50px) rotateZ(-8deg) scale(0.92);
            opacity: 0.88;
        }

        100% {
            transform: perspective(800px) translate3d(125%, -42px, 30px) rotateZ(12deg) scale(0.78);
            opacity: 0;
        }
    }

    @keyframes sayapKupu {

        0%,
        100% {
            transform: scaleX(1) rotateY(0deg);
        }

        50% {
            transform: scaleX(0.32) rotateY(55deg);
        }
    }

    .diorama-panggung-3d {
        perspective: 1200px;
        transform-style: preserve-3d;
    }

    .diorama-kamera-3d {
        transform-style: preserve-3d;
        animation: kameraDiorama3D 11s ease-in-out infinite;
        will-change: transform;
    }

    .diorama-latar-3d {
        animation: latarDolly3D 2.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        will-change: transform;
    }

    .diorama-latar-basic {
        animation: latarDollyBasic 1.7s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        will-change: transform;
    }

    .sayap-kiri-3d {
        animation: sayapBukaKiri3D 1.85s cubic-bezier(0.16, 1, 0.3, 1) 0.15s both;
        will-change: transform, opacity;
    }

    .sayap-kanan-3d {
        animation: sayapBukaKanan3D 1.85s cubic-bezier(0.16, 1, 0.3, 1) 0.15s both;
        will-change: transform, opacity;
    }

    .sudut-terbang-kiri-3d {
        animation: sudutTerbangKiri3D 1.6s cubic-bezier(0.16, 1, 0.3, 1) 0.25s both;
        will-change: transform, opacity;
    }

    .sudut-terbang-kanan-3d {
        animation: sudutTerbangKanan3D 1.6s cubic-bezier(0.16, 1, 0.3, 1) 0.25s both;
        will-change: transform, opacity;
    }

    .diorama-bingkai-3d {
        animation: portalBingkaiMasuk3D 1.4s cubic-bezier(0.16, 1, 0.3, 1) 0.35s both;
        will-change: transform, opacity;
    }

    .diorama-bingkai-basic {
        animation: portalBingkaiBasic3D 1.15s cubic-bezier(0.22, 1, 0.36, 1) 0.25s both;
        will-change: transform, opacity;
    }

    .portal-crest-ledak {
        animation: ledakanMonogramPortal 1.1s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        will-change: transform, opacity;
    }

    .animasi-kupu-3d {
        animation: kupuTerbang3D 14s ease-in-out infinite;
        will-change: transform, opacity;
    }

    .animasi-sayap-kupu {
        transform-box: fill-box;
        transform-origin: center;
        animation: sayapKupu 0.38s ease-in-out infinite;
    }

    /* === ENGINE SINEMA 3D SCROLL-REVEAL, SWAY & PARALAKS (TERINSPIRASI 2.5D/3D MOTION) === */
    html.mode-autoscroll {
        scroll-behavior: auto !important;
    }

    @keyframes ayunKananOrganik {

        0%,
        100% {
            transform: perspective(900px) rotateZ(-4deg) rotateY(-6deg) translate3d(0, 0, 14px);
        }

        50% {
            transform: perspective(900px) rotateZ(4.5deg) rotateY(8deg) translate3d(4px, -6px, 24px);
        }
    }

    @keyframes ayunKiriOrganik {

        0%,
        100% {
            transform: perspective(900px) scaleX(-1) rotateZ(-4deg) rotateY(-6deg) translate3d(0, 0, 14px);
        }

        50% {
            transform: perspective(900px) scaleX(-1) rotateZ(4.5deg) rotateY(8deg) translate3d(-4px, -6px, 24px);
        }
    }

    @keyframes bingkaiHeroMuncul {
        0% {
            opacity: 0;
            transform: perspective(1200px) scale(0.9) translateZ(-40px);
        }

        100% {
            opacity: 1;
            transform: perspective(1200px) scale(1) translateZ(0);
        }
    }

    .ayun-kanan {
        transform-origin: bottom left;
        animation: ayunKananOrganik 8.5s ease-in-out infinite;
    }

    .ayun-kiri {
        transform-origin: bottom right;
        animation: ayunKiriOrganik 9s ease-in-out infinite;
    }

    .bingkai-hero-aktif {
        animation: bingkaiHeroMuncul 1.15s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }

    .lapis-paralaks-scroll {
        transform: translate3d(0, calc(var(--sy, 0) * var(--sp, 0.06) * -1px), var(--pz, 0px));
    }

    .scroll-scrub-kiri {
        transform: translate3d(calc(var(--scrub, 0) * -22px), 0, 0);
    }

    .scroll-scrub-kanan {
        transform: translate3d(calc(var(--scrub, 0) * 22px), 0, 0);
    }

    /* Kit Reveal 60fps Berbasis Scroll Dua Arah (Aktif Saat Scroll Bawah & Kembali Scroll Atas, Reset Instan di Luar Layar) */
    html.lenis,
    html.lenis body {
        height: auto;
    }

    .lenis.lenis-smooth {
        scroll-behavior: auto !important;
    }

    .lenis.lenis-smooth [data-lenis-prevent] {
        overscroll-behavior: contain;
    }

    body.sinema-gsap-aktif [data-gsap] {
        will-change: transform, opacity;
        backface-visibility: hidden;
    }

    body.siap-3d .fx-rise:not([data-gsap]) {
        opacity: 0;
        transform: translate3d(0, 26px, 0);
        transition: none;
        backface-visibility: hidden;
    }

    body.siap-3d .fx-rise:not([data-gsap]).fx-dari-atas {
        transform: translate3d(0, -24px, 0);
    }

    body.siap-3d .fx-rise-down:not([data-gsap]) {
        opacity: 0;
        transform: translate3d(0, -20px, 0);
        transition: none;
        backface-visibility: hidden;
    }

    body.siap-3d .fx-rise-down:not([data-gsap]).fx-dari-atas {
        transform: translate3d(0, 22px, 0);
    }

    body.siap-3d .fx-scale-in:not([data-gsap]) {
        opacity: 0;
        transform: translate3d(0, 16px, 0) scale(0.93);
        transition: none;
        backface-visibility: hidden;
    }

    body.siap-3d .fx-scale-in:not([data-gsap]).fx-dari-atas {
        transform: translate3d(0, -16px, 0) scale(0.93);
    }

    body.siap-3d .fx-scale-out:not([data-gsap]) {
        opacity: 0;
        transform: scale(1.06);
        transition: none;
        backface-visibility: hidden;
    }

    body.siap-3d .fx-slide-left:not([data-gsap]) {
        opacity: 0;
        transform: translate3d(-28px, 0, 0);
        transition: none;
        backface-visibility: hidden;
    }

    body.siap-3d .fx-slide-right:not([data-gsap]) {
        opacity: 0;
        transform: translate3d(28px, 0, 0);
        transition: none;
        backface-visibility: hidden;
    }

    body.siap-3d .fx-flip-in:not([data-gsap]) {
        opacity: 0;
        transform: perspective(1000px) rotateY(-12deg) translate3d(0, 18px, 0) scale(0.96);
        transition: none;
        backface-visibility: hidden;
    }

    body.siap-3d .fx-flip-in:not([data-gsap]).fx-dari-atas {
        transform: perspective(1000px) rotateY(12deg) translate3d(0, -18px, 0) scale(0.96);
    }

    body.siap-3d .fx-rise:not([data-gsap]).active,
    body.siap-3d .fx-rise-down:not([data-gsap]).active,
    body.siap-3d .fx-scale-in:not([data-gsap]).active,
    body.siap-3d .fx-scale-out:not([data-gsap]).active,
    body.siap-3d .fx-slide-left:not([data-gsap]).active,
    body.siap-3d .fx-slide-right:not([data-gsap]).active,
    body.siap-3d .fx-flip-in:not([data-gsap]).active {
        opacity: 1;
        transform: translate3d(0, 0, 0) scale(1);
        transition:
            opacity 0.65s cubic-bezier(0.16, 1, 0.3, 1),
            transform 0.72s cubic-bezier(0.16, 1, 0.3, 1),
            box-shadow 0.18s ease;
    }

    body.siap-3d .fx-selesai.active {
        transition: box-shadow 0.18s ease, border-color 0.18s ease, background-color 0.15s ease, color 0.15s ease;
    }

    .polaroid-3d-kiri {
        transform: rotate(-1.6deg);
        transition: transform 0.45s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.45s ease;
    }

    .polaroid-3d-kanan {
        transform: rotate(1.6deg);
        transition: transform 0.45s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.45s ease;
    }

    .polaroid-3d-kiri:hover,
    .polaroid-3d-kanan:hover {
        transform: perspective(900px) rotate(0deg) translateY(-4px) scale(1.02);
    }

    @media (prefers-reduced-motion: reduce) {

        .animasi-nafas,
        .animasi-goyang,
        .animasi-melayang,
        .animasi-bintang,
        .animasi-kilau,
        .animasi-kelopak-jatuh,
        .animasi-kunang,
        .animasi-debu-emas,
        .animasi-bintang-jatuh,
        .animasi-orbit,
        .animasi-orbit-balik,
        .animasi-segel,
        .animasi-awan,
        .animasi-marquee,
        .animasi-ayun-3d,
        .animasi-ayun-3d-balik,
        .animasi-kelopak-3d,
        .animasi-burung,
        .animasi-kepak,
        .animasi-sinar,
        .ayun-kanan,
        .ayun-kiri,
        .bingkai-hero-aktif,
        .diorama-kamera-3d,
        .diorama-latar-3d,
        .diorama-latar-basic,
        .sayap-kiri-3d,
        .sayap-kanan-3d,
        .sudut-terbang-kiri-3d,
        .sudut-terbang-kanan-3d,
        .diorama-bingkai-3d,
        .diorama-bingkai-basic,
        .portal-crest-ledak,
        .animasi-kupu-3d,
        .animasi-sayap-kupu,
        .jawa-sapu-kiri,
        .jawa-sapu-kanan,
        .jawa-latar-dolly,
        .jawa-pendopo-masuk,
        .jawa-janur-kiri,
        .jawa-janur-kanan,
        .jawa-bunga-masuk,
        .jawa-bingkai-masuk,
        .jawa-teks-masuk,
        .jawa-burung-terbang,
        .efek-shimmer-kartu::after {
            animation: none !important;
        }

        .jawa-sapu-kiri,
        .jawa-sapu-kanan {
            opacity: 0 !important;
        }

        body.siap-3d .masuk-3d,
        body.siap-3d .fx-rise,
        body.siap-3d .fx-rise-down,
        body.siap-3d .fx-scale-in,
        body.siap-3d .fx-scale-out,
        body.siap-3d .fx-slide-left,
        body.siap-3d .fx-slide-right,
        body.siap-3d .fx-flip-in {
            opacity: 1 !important;
            transform: none !important;
        }

        .scroll-scrub-kiri,
        .scroll-scrub-kanan,
        .lapis-paralaks-scroll {
            transform: none !important;
        }
    }

    .buku-tamu-scroll {
        scrollbar-width: thin;
        scrollbar-color: rgba(191, 161, 95, 0.48) transparent;
    }

    .buku-tamu-scroll::-webkit-scrollbar {
        width: 5px;
    }

    .buku-tamu-scroll::-webkit-scrollbar-track {
        background: transparent;
    }

    .buku-tamu-scroll::-webkit-scrollbar-thumb {
        background: rgba(191, 161, 95, 0.42);
        border-radius: 9999px;
    }

    .buku-tamu-scroll::-webkit-scrollbar-thumb:hover {
        background: rgba(191, 161, 95, 0.72);
    }

    /* === KUNCI SKALA ANTI-ZOOM KOLOM UNDANGAN TENGAH (TAMPILAN WEB/DESKTOP) === */
    html.desktop-triptych [data-tata-letak-tema] {
        display: flex !important;
    }

    html.desktop-triptych [data-tata-letak-tema] > aside {
        display: flex !important;
        flex: 1 1 0% !important;
        min-width: 0 !important;
        position: sticky !important;
        top: 0 !important;
        height: 100vh !important;
        height: 100dvh !important;
        align-items: center !important;
        justify-content: center !important;
        padding-top: var(--tinggi-bar-demo-viewport, 0px) !important;
    }

    /* Kolom luar tidak memakai zoom agar elemen position:fixed di dalamnya tidak terkena bug koordinat Chrome 128+ */
    html.desktop-triptych [data-kolom-undangan] {
        box-sizing: content-box !important;
        width: var(--lebar-kolom-viewport, 460px) !important;
        flex-shrink: 0 !important;
        border-left-width: 1px !important;
        border-right-width: 1px !important;
    }

    html.desktop-triptych [data-kolom-undangan] > [data-progres-undangan] {
        width: var(--lebar-kolom-viewport, 460px) !important;
        left: 0 !important;
        right: 0 !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }

    html.desktop-triptych [data-kolom-undangan] > [data-latar-undangan] {
        width: var(--lebar-kolom-viewport, 460px) !important;
        top: 0 !important;
        bottom: 0 !important;
        left: 0 !important;
        right: 0 !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }

    html.desktop-triptych [data-kolom-undangan] > [data-latar-undangan] > [data-latar-zoom] {
        width: var(--lebar-kolom-undangan, 460px) !important;
        height: var(--tinggi-layar-inv, 100dvh) !important;
        zoom: var(--inv-zoom, 1);
    }

    html.desktop-triptych [data-kolom-undangan] > [data-transisi-sampul],
    html.desktop-triptych [data-kolom-undangan] > [data-intro-pembuka] {
        width: var(--lebar-kolom-viewport, 460px) !important;
        top: 0 !important;
        bottom: 0 !important;
        left: 0 !important;
        right: 0 !important;
        margin-left: auto !important;
        margin-right: auto !important;
        height: auto !important;
        padding-top: var(--tinggi-bar-demo-viewport, 0px) !important;
    }

    html.desktop-triptych [data-kolom-undangan] > [data-transisi-sampul] > div,
    html.desktop-triptych [data-kolom-undangan] > [data-intro-pembuka] > div {
        width: var(--lebar-kolom-undangan, 460px) !important;
        height: var(--tinggi-tirai-dalam-inv, 100%) !important;
        zoom: var(--inv-zoom, 1);
    }

    html.desktop-triptych [data-kolom-undangan] > main[data-panggung-3d] {
        width: var(--lebar-kolom-undangan, 460px) !important;
        zoom: var(--inv-zoom, 1);
        padding-top: var(--tinggi-bar-demo-inv, 0px) !important;
    }

    /* Jaga tinggi hero diorama tetap proporsional 1 layar normal saat browser di-zoom in/out */
    html.desktop-triptych [data-kolom-undangan] section[data-diorama-3d].h-dvh {
        height: var(--tinggi-layar-inv, 100dvh) !important;
    }

    html.desktop-triptych [data-kolom-undangan] section[data-diorama-3d][class*="min-h-[96dvh]"] {
        min-height: calc(var(--tinggi-layar-inv, 100dvh) * 0.96) !important;
    }

    html.desktop-triptych [data-kolom-undangan] section[data-diorama-3d][class*="min-h-[96dvh]"] > div {
        min-height: calc(var(--tinggi-layar-inv, 100dvh) * 0.96 - 2rem) !important;
    }

    /* === TATA LETAK PANGGUNG TABLET (KOLOM PORTRAIT TERPUSAT + SAYAP ARTWORK KIRI & KANAN) === */
    @media (min-width: 680px) and (max-width: 1023px) {
        html:not(.desktop-triptych):not(.tablet-stage) [data-tata-letak-tema] {
            display: flex !important;
        }

        html:not(.desktop-triptych):not(.tablet-stage) [data-tata-letak-tema] > aside {
            display: flex !important;
            flex: 1 1 0% !important;
            min-width: 0 !important;
            position: sticky !important;
            top: 0 !important;
            height: 100vh !important;
            height: 100dvh !important;
            align-items: center !important;
            justify-content: center !important;
            padding-top: 0 !important;
        }

        html:not(.desktop-triptych):not(.tablet-stage) [data-tata-letak-tema] > aside > .lapis-3d.z-20 {
            display: none !important;
        }

        html:not(.desktop-triptych):not(.tablet-stage) [data-kolom-undangan] {
            box-sizing: content-box !important;
            width: 440px !important;
            flex-shrink: 0 !important;
            border-left-width: 1px !important;
            border-right-width: 1px !important;
        }

        html:not(.desktop-triptych):not(.tablet-stage) [data-kolom-undangan] > [data-progres-undangan],
        html:not(.desktop-triptych):not(.tablet-stage) [data-kolom-undangan] > [data-latar-undangan],
        html:not(.desktop-triptych):not(.tablet-stage) [data-kolom-undangan] > [data-transisi-sampul],
        html:not(.desktop-triptych):not(.tablet-stage) [data-kolom-undangan] > [data-intro-pembuka] {
            width: 440px !important;
            left: 0 !important;
            right: 0 !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }
    }

    /* === KUNCI SKALA ANTI-ZOOM MODE TABLET (KUNJUNGAN LANGSUNG) === */
    html.tablet-stage [data-tata-letak-tema] {
        display: flex !important;
    }

    html.tablet-stage [data-tata-letak-tema] > aside {
        display: flex !important;
        flex: 1 1 0% !important;
        min-width: 0 !important;
        position: sticky !important;
        top: 0 !important;
        height: 100vh !important;
        height: 100dvh !important;
        align-items: center !important;
        justify-content: center !important;
        padding-top: var(--tinggi-bar-demo-viewport, 0px) !important;
    }

    html.tablet-stage [data-tata-letak-tema] > aside > .lapis-3d.z-20 {
        display: none !important;
    }

    html.tablet-stage [data-kolom-undangan] {
        box-sizing: content-box !important;
        width: var(--lebar-kolom-viewport, 440px) !important;
        flex-shrink: 0 !important;
        border-left-width: 1px !important;
        border-right-width: 1px !important;
    }

    html.tablet-stage [data-kolom-undangan] > [data-progres-undangan],
    html.tablet-stage [data-kolom-undangan] > [data-latar-undangan] {
        width: var(--lebar-kolom-viewport, 440px) !important;
        left: 0 !important;
        right: 0 !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }

    html.tablet-stage [data-kolom-undangan] > [data-latar-undangan] {
        top: 0 !important;
        bottom: 0 !important;
    }

    html.tablet-stage [data-kolom-undangan] > [data-latar-undangan] > [data-latar-zoom] {
        width: var(--lebar-kolom-undangan, 440px) !important;
        height: var(--tinggi-layar-inv, 100dvh) !important;
        zoom: var(--inv-zoom, 1);
    }

    html.tablet-stage [data-kolom-undangan] > [data-transisi-sampul],
    html.tablet-stage [data-kolom-undangan] > [data-intro-pembuka] {
        width: var(--lebar-kolom-viewport, 440px) !important;
        top: 0 !important;
        bottom: 0 !important;
        left: 0 !important;
        right: 0 !important;
        margin-left: auto !important;
        margin-right: auto !important;
        height: auto !important;
        padding-top: var(--tinggi-bar-demo-viewport, 0px) !important;
    }

    html.tablet-stage [data-kolom-undangan] > [data-transisi-sampul] > div,
    html.tablet-stage [data-kolom-undangan] > [data-intro-pembuka] > div {
        width: var(--lebar-kolom-undangan, 440px) !important;
        height: var(--tinggi-tirai-dalam-inv, 100%) !important;
        zoom: var(--inv-zoom, 1);
    }

    html.tablet-stage [data-kolom-undangan] > main[data-panggung-3d] {
        width: var(--lebar-kolom-undangan, 440px) !important;
        zoom: var(--inv-zoom, 1);
        padding-top: var(--tinggi-bar-demo-inv, 0px) !important;
    }

    html.tablet-stage [data-kolom-undangan] .jawa-hero-layar-penuh,
    html.tablet-stage [data-kolom-undangan] .rustic-hero-layar-penuh,
    html.tablet-stage [data-kolom-undangan] .syari-hero-layar-penuh,
    html.tablet-stage [data-kolom-undangan] section[data-diorama-3d].h-dvh {
        height: var(--tinggi-tirai-dalam-inv, 100dvh) !important;
        min-height: var(--tinggi-tirai-dalam-inv, 100dvh) !important;
    }

    /* === INTRO PEMBUKA SINEMATIK AWAL BUKA (UNIK PER TEMA, 60FPS GPU-COMPOSITED) === */
    @keyframes introBingkaiMasuk {
        0% { opacity: 0; transform: scale(0.95); }
        100% { opacity: 1; transform: scale(1); }
    }
    @keyframes introElemenNaik {
        0% { opacity: 0; transform: translate3d(0, 16px, 0) scale(0.97); }
        100% { opacity: 1; transform: translate3d(0, 0, 0) scale(1); }
    }
    @keyframes introMonogramMekar {
        0% { opacity: 0; transform: scale(0.84) translate3d(0, 10px, 0); }
        100% { opacity: 1; transform: scale(1) translate3d(0, 0, 0); }
    }
    @keyframes introGarisBentang {
        0% { opacity: 0; transform: scaleX(0); }
        100% { opacity: 1; transform: scaleX(1); }
    }
    @keyframes introPutarPelan {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .intro-pembuka-tirai {
        will-change: transform, opacity;
        backface-visibility: hidden;
    }
    .intro-pembuka-tirai .intro-bingkai {
        animation: introBingkaiMasuk 0.72s cubic-bezier(0.22, 1, 0.36, 1) 0.06s both;
    }
    .intro-pembuka-tirai .intro-tahap-1 {
        animation: introElemenNaik 0.65s cubic-bezier(0.22, 1, 0.36, 1) 0.14s both;
    }
    .intro-pembuka-tirai .intro-tahap-2 {
        animation: introElemenNaik 0.65s cubic-bezier(0.22, 1, 0.36, 1) 0.36s both;
    }
    .intro-pembuka-tirai .intro-tahap-3 {
        animation: introMonogramMekar 0.78s cubic-bezier(0.16, 1, 0.3, 1) 0.62s both;
    }
    .intro-pembuka-tirai .intro-tahap-4 {
        animation: introElemenNaik 0.72s cubic-bezier(0.22, 1, 0.36, 1) 0.92s both;
    }
    .intro-pembuka-tirai .intro-garis {
        transform-origin: center;
        animation: introGarisBentang 0.75s cubic-bezier(0.22, 1, 0.36, 1) 1.08s both;
    }
    .intro-pembuka-tirai .intro-petunjuk {
        animation: introElemenNaik 0.55s ease 1.15s both;
    }
    .intro-pembuka-tirai .intro-putar-pelan {
        animation: introPutarPelan 18s linear infinite;
    }

    /* Transisi Keluar 1: Belah Tengah (Adat Jawa, Islamic Heavenly, Luxury Noir, Editorial Monokrom) */
    .intro-pembuka-tirai .intro-panel-kiri,
    .intro-pembuka-tirai .intro-panel-kanan {
        transition: transform 0.78s cubic-bezier(0.76, 0, 0.24, 1);
        will-change: transform;
    }
    .intro-pembuka-tirai .intro-pusat,
    .intro-pembuka-tirai .intro-bingkai,
    .intro-pembuka-tirai .intro-pendar,
    .intro-pembuka-tirai .intro-petunjuk {
        transition: opacity 0.34s ease, transform 0.38s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .intro-pembuka-tirai.intro-keluar {
        pointer-events: none;
    }
    .intro-pembuka-tirai.intro-keluar[data-intro-keluar="belah-tengah"] .intro-pusat,
    .intro-pembuka-tirai.intro-keluar[data-intro-keluar="belah-tengah"] .intro-bingkai,
    .intro-pembuka-tirai.intro-keluar[data-intro-keluar="belah-tengah"] .intro-pendar,
    .intro-pembuka-tirai.intro-keluar[data-intro-keluar="belah-tengah"] .intro-petunjuk {
        animation: none !important;
        opacity: 0;
        transform: scale(1.04);
    }
    .intro-pembuka-tirai.intro-keluar[data-intro-keluar="belah-tengah"] .intro-panel-kiri {
        transform: translate3d(-104%, 0, 0);
    }
    .intro-pembuka-tirai.intro-keluar[data-intro-keluar="belah-tengah"] .intro-panel-kanan {
        transform: translate3d(104%, 0, 0);
    }

    /* Transisi Keluar 2: Gulir Halus Ke Atas (Sunda Heritage, Rustic Floral, Royal Ivory) */
    .intro-pembuka-tirai[data-intro-keluar="gulir-atas"] {
        transition: transform 0.78s cubic-bezier(0.76, 0, 0.24, 1), opacity 0.45s ease 0.32s;
    }
    .intro-pembuka-tirai.intro-keluar[data-intro-keluar="gulir-atas"] {
        transform: translate3d(0, -104%, 0);
        opacity: 0;
    }

    /* Transisi Keluar 3: Mekar Halus (Islami Syar'i, Velvet Garden) */
    .intro-pembuka-tirai[data-intro-keluar="mekar-halus"] {
        transition: opacity 0.72s cubic-bezier(0.22, 1, 0.36, 1), transform 0.78s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .intro-pembuka-tirai.intro-keluar[data-intro-keluar="mekar-halus"] {
        opacity: 0;
        transform: scale(1.065);
    }

    /* Transisi Keluar 4: Fade Halus Murni (Sunda Heritage — agar kontras dengan sampul gulir ke atas) */
    .intro-pembuka-tirai[data-intro-keluar="fade-halus"] {
        transition: opacity 0.76s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .intro-pembuka-tirai.intro-keluar[data-intro-keluar="fade-halus"] {
        opacity: 0;
    }

    .intro-pembuka-tirai.intro-selesai,
    .intro-pembuka-tirai.intro-selesai * {
        animation: none !important;
    }

    /* === KOREOGRAFI KHUSUS INTRO ADAT JAWA KERATON (TANCEP KAYON -> UKIRAN -> GEBYOK) === */
    .intro-jawa-mask-atas {
        -webkit-mask-image: linear-gradient(180deg, rgba(0, 0, 0, 0.92) 15%, rgba(0, 0, 0, 0.3) 65%, transparent 100%);
        mask-image: linear-gradient(180deg, rgba(0, 0, 0, 0.92) 15%, rgba(0, 0, 0, 0.3) 65%, transparent 100%);
    }
    .intro-jawa-mask-bawah {
        -webkit-mask-image: linear-gradient(0deg, rgba(0, 0, 0, 0.92) 15%, rgba(0, 0, 0, 0.3) 65%, transparent 100%);
        mask-image: linear-gradient(0deg, rgba(0, 0, 0, 0.92) 15%, rgba(0, 0, 0, 0.3) 65%, transparent 100%);
    }
    .intro-jawa-foil {
        background: linear-gradient(180deg, #FFFBE4 0%, #F1D384 46%, #C4933B 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        filter: drop-shadow(0 3px 10px rgba(0, 0, 0, 0.55));
    }

    @keyframes introJawaGununganBabak1 {
        0% { opacity: 0; transform: translate3d(0, 28px, 0) scale(0.84); }
        34% { opacity: 1; transform: translate3d(0, 0, 0) scale(1); }
        74% { opacity: 1; transform: translate3d(0, -4px, 0) scale(1.03); }
        100% { opacity: 0; transform: translate3d(0, -14px, 0) scale(1.12); }
    }
    @keyframes introJawaTajukBabak1 {
        0% { opacity: 0; transform: translate3d(0, 14px, 0); }
        32% { opacity: 1; transform: translate3d(0, 0, 0); }
        74% { opacity: 1; transform: translate3d(0, 0, 0); }
        100% { opacity: 0; transform: translate3d(0, -10px, 0); }
    }
    @keyframes introJawaEyebrowBentang {
        0% { letter-spacing: 0.16em; }
        55%, 100% { letter-spacing: 0.36em; }
    }
    @keyframes introJawaWatermarkMasuk {
        0% { opacity: 0; transform: scale(0.92); }
        100% { opacity: 0.14; transform: scale(1.04); }
    }
    @keyframes introJawaMedaliMekar {
        0% { opacity: 0; transform: scale(0.86) translate3d(0, 14px, 0); }
        100% { opacity: 1; transform: scale(1) translate3d(0, 0, 0); }
    }
    @keyframes introJawaSayapKiri {
        0% { opacity: 0; transform: translate3d(-24px, 14px, 0) rotate(-14deg) scale(0.88); }
        100% { opacity: 0.72; transform: translate3d(0, 0, 0) rotate(0deg) scale(1); }
    }
    @keyframes introJawaSayapKanan {
        0% { opacity: 0; transform: translate3d(24px, 14px, 0) scaleX(-1) rotate(-14deg) scale(0.88); }
        100% { opacity: 0.72; transform: translate3d(0, 0, 0) scaleX(-1) rotate(0deg) scale(1); }
    }
    @keyframes introJawaHaloNafas {
        0%, 100% { opacity: 0.78; transform: scale(0.98); }
        50% { opacity: 1; transform: scale(1.06); }
    }
    @keyframes introJawaSinarSapu {
        0% { opacity: 0; transform: translate3d(-45%, 0, 0) rotate(-18deg); }
        45% { opacity: 0.9; }
        100% { opacity: 0; transform: translate3d(145%, 0, 0) rotate(-14deg); }
    }
    @keyframes introJawaDebuNaik {
        0% { opacity: 0; transform: translate3d(0, 16px, 0) scale(0.7); }
        35% { opacity: 0.85; }
        100% { opacity: 0; transform: translate3d(6px, -68px, 0) scale(1.15); }
    }

    [data-intro-pembuka="adat-jawa"] .intro-panel-kiri,
    [data-intro-pembuka="adat-jawa"] .intro-panel-kanan {
        transition: transform 0.94s cubic-bezier(0.76, 0, 0.24, 1);
    }
    [data-intro-pembuka="adat-jawa"] .intro-jawa-watermark {
        opacity: 0;
        animation: introJawaWatermarkMasuk 0.95s cubic-bezier(0.22, 1, 0.36, 1) 1.38s both;
        transition: opacity 0.4s ease, transform 0.45s ease;
    }
    [data-intro-pembuka="adat-jawa"] .intro-jawa-gunungan {
        animation: introJawaGununganBabak1 1.62s cubic-bezier(0.22, 1, 0.36, 1) 0.08s both;
    }
    [data-intro-pembuka="adat-jawa"] .intro-jawa-tajuk-1 {
        animation: introJawaTajukBabak1 1.48s cubic-bezier(0.22, 1, 0.36, 1) 0.2s both;
    }
    [data-intro-pembuka="adat-jawa"] .intro-jawa-eyebrow {
        animation: introJawaEyebrowBentang 1.35s cubic-bezier(0.22, 1, 0.36, 1) 0.22s both;
    }
    [data-intro-pembuka="adat-jawa"] .intro-jawa-medali {
        animation: introJawaMedaliMekar 0.78s cubic-bezier(0.16, 1, 0.3, 1) 1.48s both;
    }
    [data-intro-pembuka="adat-jawa"] .intro-jawa-mahkota {
        animation: introElemenNaik 0.58s cubic-bezier(0.22, 1, 0.36, 1) 1.66s both;
    }
    [data-intro-pembuka="adat-jawa"] .intro-jawa-monogram {
        animation: introMonogramMekar 0.72s cubic-bezier(0.16, 1, 0.3, 1) 1.76s both;
    }
    [data-intro-pembuka="adat-jawa"] .intro-jawa-pemisah {
        transform-origin: center;
        animation: introGarisBentang 0.65s cubic-bezier(0.22, 1, 0.36, 1) 1.98s both;
    }
    [data-intro-pembuka="adat-jawa"] .intro-jawa-nama {
        animation: introElemenNaik 0.65s cubic-bezier(0.22, 1, 0.36, 1) 2.08s both;
    }
    [data-intro-pembuka="adat-jawa"] .intro-jawa-tanggal {
        animation: introElemenNaik 0.58s cubic-bezier(0.22, 1, 0.36, 1) 2.26s both;
    }
    [data-intro-pembuka="adat-jawa"] .intro-jawa-sayap-kiri {
        transform-origin: 18% 82%;
        animation: introJawaSayapKiri 0.95s cubic-bezier(0.22, 1, 0.36, 1) 0.16s both;
    }
    [data-intro-pembuka="adat-jawa"] .intro-jawa-sayap-kanan {
        transform-origin: 82% 82%;
        animation: introJawaSayapKanan 0.95s cubic-bezier(0.22, 1, 0.36, 1) 0.16s both;
    }
    [data-intro-pembuka="adat-jawa"] .intro-jawa-halo {
        animation: introJawaHaloNafas 3.2s ease-in-out infinite;
    }
    [data-intro-pembuka="adat-jawa"] .intro-jawa-sinar {
        animation: introJawaSinarSapu 3.4s cubic-bezier(0.25, 0.46, 0.45, 0.94) 0.15s both;
    }
    [data-intro-pembuka="adat-jawa"] .intro-jawa-debu {
        animation: introJawaDebuNaik 2.6s ease-out infinite;
    }
    [data-intro-pembuka="adat-jawa"].intro-keluar .intro-pusat,
    [data-intro-pembuka="adat-jawa"].intro-keluar .intro-pendar,
    [data-intro-pembuka="adat-jawa"].intro-keluar .intro-petunjuk {
        animation: none !important;
        opacity: 0;
        transform: scale(1.08);
        transition: opacity 0.42s ease, transform 0.48s cubic-bezier(0.22, 1, 0.36, 1);
    }

    @media (prefers-reduced-motion: reduce) {
        .intro-pembuka-tirai {
            display: none !important;
        }
    }
</style>
@if (request()->boolean('kanvas'))
<style>
    @media (max-width: 1023px) {
        html,
        body {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        html::-webkit-scrollbar,
        body::-webkit-scrollbar {
            display: none;
        }
    }
</style>
@endif
<script>
    (function () {
        if (window.self !== window.top) {
            return;
        }

        const root = document.documentElement;
        const KUNCI_OS_DPR = 'sesitemu_os_dpr_v1';

        function hitungSkalaOs(dpr, lebarLuar, lebarDalam) {
            if (lebarLuar > 0 && lebarDalam > 0) {
                const rasioLuar = lebarLuar / lebarDalam;
                if (Math.abs(rasioLuar - 1) <= 0.03) {
                    return dpr;
                }
                const estimasi = dpr / rasioLuar;
                const dibulatkan = Math.round(estimasi * 4) / 4;
                if (dibulatkan >= 1 && dibulatkan <= 3 && Math.abs(estimasi - dibulatkan) <= 0.14) {
                    return dibulatkan;
                }
            }
            return null;
        }

        function ambilSkalaOs(dpr, lebarLuar, lebarDalam) {
            const terhitung = hitungSkalaOs(dpr, lebarLuar, lebarDalam);
            if (terhitung !== null) {
                try {
                    sessionStorage.setItem(KUNCI_OS_DPR, String(terhitung));
                } catch (e) {}
                return terhitung;
            }
            try {
                const tersimpan = Number.parseFloat(sessionStorage.getItem(KUNCI_OS_DPR) || '');
                if (Number.isFinite(tersimpan) && tersimpan >= 1 && tersimpan <= 3) {
                    return tersimpan;
                }
            } catch (e) {}
            return 1;
        }

        function sinkronkanSkalaUndangan() {
            const lebarDalam = window.innerWidth || root.clientWidth || 0;
            const lebarKlien = root.clientWidth || lebarDalam;
            const tinggiDalam = window.innerHeight || root.clientHeight || 0;
            const dpr = window.devicePixelRatio || 1;

            let lebarLuar = window.outerWidth || 0;
            const availW = window.screen && window.screen.availWidth ? window.screen.availWidth : 0;
            if (availW > 0 && lebarLuar > availW && lebarLuar - availW <= 32) {
                lebarLuar = availW;
            }

            const osDpr = ambilSkalaOs(dpr, lebarLuar, lebarDalam);
            let browserZoom = osDpr > 0 ? dpr / osDpr : 1;

            if (Math.abs(browserZoom - 1) < 0.015) {
                browserZoom = 1;
            }
            browserZoom = Math.max(0.25, Math.min(4, browserZoom));

            const lebarTanpaZoom = lebarDalam * browserZoom;
            const tinggiTanpaZoom = tinggiDalam * browserZoom;

            if (lebarTanpaZoom >= 1024) {
                const invZoom = Number((1 / browserZoom).toFixed(4));
                const kolomEl = document.querySelector('[data-kolom-undangan]');
                const lebarLg = Number.parseInt(kolomEl?.dataset.lebarLg || '460', 10) || 460;
                const lebarXl = Number.parseInt(kolomEl?.dataset.lebarXl || '490', 10) || 490;
                const lebarKolom = lebarTanpaZoom >= 1280 ? lebarXl : lebarLg;
                const lebarViewport = Math.min(Math.max(320, lebarKlien - 2), lebarKolom * invZoom);

                const barEl = document.querySelector('[data-bar-pratinjau]');
                const tinggiBarViewport = barEl ? Math.ceil(barEl.getBoundingClientRect().height) : 0;
                const tinggiBarInv = tinggiBarViewport / invZoom;
                const tinggiSampulDalam = Math.max(320, (tinggiDalam - tinggiBarViewport) / invZoom);

                root.classList.remove('tablet-stage');
                root.classList.add('desktop-triptych');
                root.style.setProperty('--browser-zoom', browserZoom.toFixed(4));
                root.style.setProperty('--inv-zoom', String(invZoom));
                root.style.setProperty('--lebar-kolom-undangan', `${lebarKolom}px`);
                root.style.setProperty('--lebar-kolom-viewport', `${lebarViewport.toFixed(2)}px`);
                root.style.setProperty('--tinggi-layar-inv', `${Math.round(tinggiTanpaZoom)}px`);
                root.style.setProperty('--tinggi-bar-demo-viewport', `${tinggiBarViewport}px`);
                root.style.setProperty('--tinggi-bar-demo-inv', `${tinggiBarInv.toFixed(2)}px`);
                root.style.setProperty('--tinggi-tirai-dalam-inv', `${tinggiSampulDalam.toFixed(2)}px`);
            } else if (lebarTanpaZoom >= 680) {
                const invZoom = Number((1 / browserZoom).toFixed(4));
                const lebarKolom = 440;
                const lebarViewport = Math.min(Math.max(320, lebarKlien - 2), lebarKolom * invZoom);

                const barEl = document.querySelector('[data-bar-pratinjau]');
                const tinggiBarViewport = barEl ? Math.ceil(barEl.getBoundingClientRect().height) : 0;
                const tinggiBarInv = tinggiBarViewport / invZoom;
                const tinggiSampulDalam = Math.max(320, (tinggiDalam - tinggiBarViewport) / invZoom);

                root.classList.remove('desktop-triptych');
                root.classList.add('tablet-stage');
                root.style.setProperty('--browser-zoom', browserZoom.toFixed(4));
                root.style.setProperty('--inv-zoom', String(invZoom));
                root.style.setProperty('--lebar-kolom-undangan', `${lebarKolom}px`);
                root.style.setProperty('--lebar-kolom-viewport', `${lebarViewport.toFixed(2)}px`);
                root.style.setProperty('--tinggi-layar-inv', `${Math.round(tinggiTanpaZoom)}px`);
                root.style.setProperty('--tinggi-bar-demo-viewport', `${tinggiBarViewport}px`);
                root.style.setProperty('--tinggi-bar-demo-inv', `${tinggiBarInv.toFixed(2)}px`);
                root.style.setProperty('--tinggi-tirai-dalam-inv', `${tinggiSampulDalam.toFixed(2)}px`);
            } else {
                root.classList.remove('desktop-triptych', 'tablet-stage');
                root.style.removeProperty('--browser-zoom');
                root.style.removeProperty('--inv-zoom');
                root.style.removeProperty('--lebar-kolom-undangan');
                root.style.removeProperty('--lebar-kolom-viewport');
                root.style.removeProperty('--tinggi-layar-inv');
                root.style.removeProperty('--tinggi-bar-demo-viewport');
                root.style.removeProperty('--tinggi-bar-demo-inv');
                root.style.removeProperty('--tinggi-tirai-dalam-inv');
            }
        }

        sinkronkanSkalaUndangan();
        window.addEventListener('resize', sinkronkanSkalaUndangan, { passive: true });
        window.addEventListener('load', sinkronkanSkalaUndangan);
        document.addEventListener('DOMContentLoaded', () => {
            sinkronkanSkalaUndangan();
            const barEl = document.querySelector('[data-bar-pratinjau]');
            if (barEl && 'ResizeObserver' in window) {
                new ResizeObserver(sinkronkanSkalaUndangan).observe(barEl);
            }
        });

        let mediaDpr = null;
        function pantauDpr() {
            if (mediaDpr && mediaDpr.removeEventListener) {
                mediaDpr.removeEventListener('change', saatDprBerubah);
            }
            if (window.matchMedia) {
                mediaDpr = window.matchMedia(`(resolution: ${window.devicePixelRatio}dppx)`);
                if (mediaDpr.addEventListener) {
                    mediaDpr.addEventListener('change', saatDprBerubah);
                }
            }
        }
        function saatDprBerubah() {
            sinkronkanSkalaUndangan();
            pantauDpr();
        }
        pantauDpr();
    })();
</script>
