@php
    $ogJudul = 'The Wedding of '.$undangan->nama_panggilan_pria.' & '.$undangan->nama_panggilan_wanita;
    $ogDeskripsi = 'Kepada Yth. '.$namaTamu.'. Tanpa mengurangi rasa hormat, kami mengundang Anda untuk hadir di acara pernikahan kami.';
    $ogGambar = $undangan->urlFotoPria()
        ?? $undangan->urlFotoWanita()
        ?? $undangan->tema?->urlGambarPratinjau()
        ?? asset('aset-demo/tema-rustic-floral.webp');
@endphp

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $ogJudul }}</title>
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

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=cormorant-garamond:500,600,700|great-vibes:400|plus-jakarta-sans:400,500,600,700" rel="stylesheet" />
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
    @keyframes goyangAngin {
        0%, 100% {
            transform: rotate(-3deg) translateY(0px);
        }
        50% {
            transform: rotate(3deg) translateY(-6px);
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

    .animasi-goyang {
        animation: goyangAngin 6s ease-in-out infinite;
    }

    .animasi-putar-kaset {
        animation: putarKaset 5s linear infinite;
    }

    .animasi-putar-jeda {
        animation-play-state: paused;
    }
</style>
