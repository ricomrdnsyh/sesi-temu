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

    /* === ENGINE DIORAMA & PERGERAKAN 3D === */
    .panggung-3d {
        perspective: 1600px;
        transform-style: preserve-3d;
    }

    .lapis-3d {
        transform-style: preserve-3d;
        transform: translate3d(calc(var(--px, 0) * var(--depth, 10px)),
                calc(var(--py, 0) * var(--depth, 8px) + var(--ps, 0px)),
                var(--pz, 0px));
        transition: transform 0.32s cubic-bezier(0.22, 1, 0.36, 1);
        will-change: transform;
    }

    .kartu-3d {
        position: relative;
        transition: box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow:
            0 16px 36px -14px rgba(0, 0, 0, 0.2),
            0 4px 12px -4px rgba(0, 0, 0, 0.1),
            inset 0 1px 0 0 rgba(255, 255, 255, 0.24);
    }

    .kartu-3d.sedang-tilt {
        transform: perspective(1200px) rotateX(var(--rx, 0deg)) rotateY(var(--ry, 0deg)) translateZ(0) !important;
        transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s ease;
        will-change: transform;
    }

    .kartu-3d:hover {
        box-shadow:
            0 24px 48px -16px rgba(0, 0, 0, 0.28),
            0 8px 20px -8px rgba(191, 161, 95, 0.22),
            inset 0 1px 0 0 rgba(255, 255, 255, 0.34);
    }

    body.siap-3d .masuk-3d {
        opacity: 0;
        transform: translate3d(0, 26px, 0) scale(0.98);
        transition:
            opacity 0.78s cubic-bezier(0.16, 1, 0.3, 1),
            transform 0.88s cubic-bezier(0.16, 1, 0.3, 1);
        backface-visibility: hidden;
    }

    body.siap-3d .masuk-3d.terlihat {
        opacity: 1;
        transform: translate3d(0, 0, 0) scale(1);
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
        will-change: transform;
    }

    .animasi-ayun-3d-balik {
        animation: ayun3dBalik 7.4s ease-in-out infinite;
        transform-origin: top center;
        will-change: transform;
    }

    .animasi-kelopak-3d {
        animation: kelopak3d 11.5s linear infinite;
        will-change: transform, opacity;
    }

    .animasi-burung {
        animation: burungTerbang 18s linear infinite;
        will-change: transform, opacity;
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
        will-change: transform;
    }

    .ayun-kiri {
        transform-origin: bottom right;
        animation: ayunKiriOrganik 9s ease-in-out infinite;
        will-change: transform;
    }

    .bingkai-hero-aktif {
        animation: bingkaiHeroMuncul 1.15s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }

    .lapis-paralaks-scroll {
        transform: translate3d(0, calc(var(--sy, 0) * var(--sp, 0.06) * -1px), var(--pz, 0px));
        will-change: transform;
    }

    .scroll-scrub-kiri {
        transform: translate3d(calc(var(--scrub, 0) * -22px), 0, 0);
        will-change: transform;
    }

    .scroll-scrub-kanan {
        transform: translate3d(calc(var(--scrub, 0) * 22px), 0, 0);
        will-change: transform;
    }

    /* Kit Reveal 60fps Berbasis Scroll (Murni GPU transform + opacity, bebas konflik tilt) */
    body.siap-3d .fx-rise {
        opacity: 0;
        transform: translate3d(0, 24px, 0);
        transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.88s cubic-bezier(0.16, 1, 0.3, 1);
        backface-visibility: hidden;
    }

    body.siap-3d .fx-rise-down {
        opacity: 0;
        transform: translate3d(0, -20px, 0);
        transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.88s cubic-bezier(0.16, 1, 0.3, 1);
        backface-visibility: hidden;
    }

    body.siap-3d .fx-scale-in {
        opacity: 0;
        transform: translate3d(0, 14px, 0) scale(0.93);
        transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.9s cubic-bezier(0.16, 1, 0.3, 1);
        backface-visibility: hidden;
    }

    body.siap-3d .fx-scale-out {
        opacity: 0;
        transform: scale(1.06);
        transition: opacity 0.85s cubic-bezier(0.16, 1, 0.3, 1), transform 0.95s cubic-bezier(0.16, 1, 0.3, 1);
        backface-visibility: hidden;
    }

    body.siap-3d .fx-slide-left {
        opacity: 0;
        transform: translate3d(-28px, 0, 0);
        transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.9s cubic-bezier(0.16, 1, 0.3, 1);
        backface-visibility: hidden;
    }

    body.siap-3d .fx-slide-right {
        opacity: 0;
        transform: translate3d(28px, 0, 0);
        transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.9s cubic-bezier(0.16, 1, 0.3, 1);
        backface-visibility: hidden;
    }

    body.siap-3d .fx-flip-in {
        opacity: 0;
        transform: perspective(1000px) rotateY(-12deg) translate3d(0, 18px, 0) scale(0.96);
        transition: opacity 0.85s cubic-bezier(0.16, 1, 0.3, 1), transform 0.95s cubic-bezier(0.16, 1, 0.3, 1);
        backface-visibility: hidden;
    }

    body.siap-3d .fx-rise.active,
    body.siap-3d .fx-rise-down.active,
    body.siap-3d .fx-scale-in.active,
    body.siap-3d .fx-scale-out.active,
    body.siap-3d .fx-slide-left.active,
    body.siap-3d .fx-slide-right.active,
    body.siap-3d .fx-flip-in.active {
        opacity: 1;
        transform: translate3d(0, 0, 0) scale(1);
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
</style>
