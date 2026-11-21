@php
    $asetGarden = [
        'latar' => asset('aset-tema/velvet-garden/latar-utama.webp'),
        'konservatori' => asset('aset-tema/velvet-garden/lengkungan-konservatori.webp'),
        'botani' => asset('aset-tema/velvet-garden/ornamen-botani.webp'),
    ];

    $dataTema = \App\Support\DataTemaUndangan::siapkan(
        $undangan,
        $modeDemo ?? false,
        $modePratinjau ?? false,
        'eksklusif',
        $asetGarden['latar']
    );
    extract($dataTema, EXTR_SKIP);
@endphp

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    @include('komponen-undangan.meta-opengraph')
    <style>
        @keyframes gardenArchMasuk {
            0% { opacity: 0; transform: translate3d(0, 24px, 0) scale(0.95); }
            100% { opacity: 1; transform: translate3d(0, 0, 0) scale(1); }
        }
        @keyframes gardenDaunKiri {
            0%, 100% { transform: translate3d(0, 0, 0) rotate(-2.5deg); }
            50% { transform: translate3d(3px, -2px, 0) rotate(2.5deg); }
        }
        @keyframes gardenDaunKanan {
            0%, 100% { transform: translate3d(0, 0, 0) scaleX(-1) rotate(-2.5deg); }
            50% { transform: translate3d(-3px, -2px, 0) scaleX(-1) rotate(2.5deg); }
        }
        .garden-arch-masuk {
            animation: gardenArchMasuk 1.2s cubic-bezier(0.16, 1, 0.3, 1) 0.12s both;
            will-change: transform, opacity;
        }
        .garden-daun-kiri {
            transform-origin: bottom center;
            animation: gardenDaunKiri 5.8s ease-in-out infinite;
            will-change: transform;
        }
        .garden-daun-kanan {
            transform-origin: bottom center;
            animation: gardenDaunKanan 6.4s ease-in-out infinite;
            will-change: transform;
        }
        .garden-tombol-sage {
            background: linear-gradient(135deg, #3E5A5C 0%, #26403E 60%, #1C3230 100%);
            color: #FDFBF7;
            border: 1px solid rgba(200, 164, 100, 0.6);
            box-shadow: 0 12px 24px -10px rgba(19, 38, 35, 0.65);
        }
        .garden-tombol-sage:hover { filter: brightness(1.08); }
        .garden-tombol-emas {
            background: linear-gradient(135deg, #DFC285 0%, #C8A464 55%, #A68344 100%);
            color: #132623;
            box-shadow: 0 12px 24px -10px rgba(0, 0, 0, 0.45);
        }
        .garden-tombol-emas:hover { filter: brightness(1.06); }
        @media (prefers-reduced-motion: reduce) {
            .garden-arch-masuk, .garden-daun-kiri, .garden-daun-kanan {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
        }
    </style>
</head>
<body
    x-data="temaUndangan()"
    :class="undanganTerbuka ? 'overflow-x-hidden' : 'overflow-hidden h-screen'"
    class="bg-[#132623] text-[#F4F8F6] antialiased relative"
>
    @include('komponen-undangan.bar-pratinjau-demo')

    <div class="min-h-screen w-full lg:flex">
        {{-- PANGGUNG VISUAL DESKTOP KIRI (VICTORIAN CONSERVATORY TWILIGHT) --}}
        @include('tema.velvet-garden.partials._panggung-desktop')

        {{-- KOLOM UNDANGAN PORTRAIT MOBILE-FIRST --}}
        <div class="w-full lg:w-[460px] xl:w-[490px] shrink-0 min-h-screen relative overflow-x-clip shadow-2xl border-l border-[#C8A464]/35 bg-[#1D3532]">
            {{-- Progres Baca Emas Botani --}}
            <div aria-hidden="true" x-show="undanganTerbuka" x-cloak class="fixed top-0 lg:left-auto lg:w-[460px] xl:w-[490px] left-0 right-0 z-[60] h-[3px] bg-black/30">
                <div class="h-full transition-all duration-150 bg-gradient-to-r from-[#8D6F3A] via-[#F3DFA2] to-[#C8A464]" :style="'width: ' + scrollPersen + '%'"></div>
            </div>

            {{-- Jendela Taman Kaca Terpin --}}
            <div aria-hidden="true" class="pointer-events-none fixed top-0 bottom-0 right-0 w-full lg:w-[460px] xl:w-[490px] z-0 overflow-hidden bg-[#132623]">
                <img src="{{ $urlFotoLatar }}" alt="" class="w-full h-full object-cover object-center opacity-32">
                <div class="absolute inset-0 bg-gradient-to-b from-[#132623]/70 via-[#1D3532]/50 to-[#132623]/80"></div>
            </div>

            {{-- SAMPUL PEMBUKA FADE HALUS --}}
            @include('tema.velvet-garden.partials._sampul')

            {{-- KONTEN UTAMA VELVET GARDEN --}}
            <main data-panggung-3d class="panggung-3d relative z-10 {{ $tampilBarDemo ? 'pt-14' : '' }}">
                @include('tema.velvet-garden.partials._hero-dan-pembuka')
                @include('tema.velvet-garden.partials._konten-utama')
                @include('tema.velvet-garden.partials._penutup-dan-rsvp')
            </main>
        </div>
    </div>

    @include('komponen-undangan.kontrol-sinema')
    @include('komponen-undangan.pemutar-musik')
    @include('komponen-undangan.modal-galeri')
    @include('komponen-undangan.skrip-tema')
</body>
</html>
