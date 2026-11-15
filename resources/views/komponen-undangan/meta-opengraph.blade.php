@php
    $gayaFont = $undangan->resolusiGayaFont();
    $tanpaFoto = $undangan->modeTanpaFoto();
    $ogJudul = 'The Wedding of '.$undangan->nama_panggilan_pria.' & '.$undangan->nama_panggilan_wanita;
    $ogDeskripsi = 'Kepada Yth. '.$namaTamu.'. Tanpa mengurangi rasa hormat, kami mengundang Anda untuk hadir di acara pernikahan kami.';
    $ogGambar = $tanpaFoto
        ? ($undangan->tema?->urlGambarPratinjau() ?? asset('aset-demo/tema-rustic-floral.webp'))
        : ($undangan->urlFotoSampul()
            ?? $undangan->urlFotoPria()
            ?? $undangan->urlFotoWanita()
            ?? $undangan->tema?->urlGambarPratinjau()
            ?? asset('aset-demo/tema-rustic-floral.webp'));
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
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.06);
        }
    }

    @keyframes goyangAngin {
        0%, 100% {
            transform: rotate(-3deg) translateY(0px);
        }
        50% {
            transform: rotate(3deg) translateY(-6px);
        }
    }

    @keyframes melayangHalus {
        0%, 100% {
            transform: translateY(0px) translateX(0px) rotate(0deg);
            opacity: 0.45;
        }
        50% {
            transform: translateY(-14px) translateX(8px) rotate(8deg);
            opacity: 0.9;
        }
    }

    @keyframes kelipBintang {
        0%, 100% {
            opacity: 0.25;
            transform: scale(0.85);
        }
        50% {
            opacity: 1;
            transform: scale(1.2);
        }
    }

    @keyframes kilauEmas {
        0%, 100% {
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
        0%, 100% {
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
        45%, 100% {
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
        0%, 100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(212, 175, 55, 0.35);
        }
        50% {
            transform: scale(1.04);
            box-shadow: 0 0 0 12px rgba(212, 175, 55, 0);
        }
    }

    @keyframes awanGeser {
        0%, 100% {
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
        0%, 100% {
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
</style>
