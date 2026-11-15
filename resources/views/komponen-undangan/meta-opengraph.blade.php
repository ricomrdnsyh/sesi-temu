@php
    $gayaFont = $undangan->resolusiGayaFont();
    $tanpaFoto = $undangan->modeTanpaFoto();
    $ogJudul = 'The Wedding of '.$undangan->nama_panggilan_pria.' & '.$undangan->nama_panggilan_wanita;
    $ogDeskripsi = 'Kepada Yth. '.$namaTamu.'. Tanpa mengurangi rasa hormat, kami mengundang Anda untuk hadir di acara pernikahan kami.';
    $ogGambar = $tanpaFoto
        ? ($undangan->tema?->urlGambarPratinjau() ?? asset('aset-demo/tema-rustic-floral.webp'))
        : ($undangan->urlFotoPria()
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
</style>
