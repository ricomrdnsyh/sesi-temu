@php
    $jalurVideoVelvet = public_path('aset-tema/velvet-garden/velvet-garden-motion-hero.mp4');
    $asetGarden = [
        'latar' => asset('aset-tema/velvet-garden/latar-utama.webp'),
        'konservatori' => asset('aset-tema/velvet-garden/lengkungan-konservatori.webp'),
        'botani' => asset('aset-tema/velvet-garden/ornamen-botani.webp'),
        'bingkaiMempelai' => asset('aset-tema/velvet-garden/bingkai-konservatori-mempelai.webp?v=1'),
        'garland' => asset('aset-tema/velvet-garden/garland-velvet.webp?v=1'),
        'bungaPenutup' => asset('aset-tema/velvet-garden/bunga-depan-penutup.webp?v=1'),
        'heroPoster' => asset('aset-tema/velvet-garden/hero-poster.webp'),
        'videoHero' => file_exists($jalurVideoVelvet) ? asset('aset-tema/velvet-garden/velvet-garden-motion-hero.mp4?v=1') : null,
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

        /* Transisi Sampul Scroll-Ke-Atas 60fps Khusus Velvet Garden */
        .tirai-fade-halus.tirai-gulir-atas {
            opacity: 1;
            transform: translate3d(0, 0, 0);
            visibility: visible;
            transition:
                transform 0.9s cubic-bezier(0.32, 0.72, 0, 1),
                visibility 0s linear 0s;
            will-change: transform;
            backface-visibility: hidden;
        }
        .tirai-fade-halus.tirai-gulir-atas > div {
            box-shadow: 0 26px 52px -12px rgba(6, 15, 12, 0.65);
        }
        .tirai-fade-halus.tirai-gulir-atas.tirai-terbuka {
            opacity: 1;
            transform: translate3d(0, -105%, 0);
            visibility: hidden;
            transition:
                transform 0.9s cubic-bezier(0.32, 0.72, 0, 1),
                visibility 0s linear 0.92s;
        }

        /* Hero Sinema Video Penuh 1 Layar HP, Tablet & Desktop Anti-Zoom */
        .velvet-hero-layar-penuh {
            height: 100svh;
            height: 100dvh;
            min-height: 520px;
        }
        html.desktop-triptych [data-kolom-undangan] .velvet-hero-layar-penuh,
        html.tablet-stage [data-kolom-undangan] .velvet-hero-layar-penuh {
            height: var(--tinggi-tirai-dalam-inv, 100dvh) !important;
            min-height: var(--tinggi-tirai-dalam-inv, 100dvh) !important;
        }

        /* Stabilisasi Kamera Video Hero Tanpa Transform 3D Agar Tipografi Tajam */
        .diorama-kamera-3d.velvet-kamera-video-aktif {
            animation: none !important;
            transform-style: flat !important;
            transform: none !important;
        }

        /* Kemunculan Tipografi Konservatori Sinkron Di Dalam Bingkai Kaca Emerald Video */
        .velvet-video-teks {
            transition:
                opacity 1.15s cubic-bezier(0.22, 1, 0.36, 1),
                transform 1.15s cubic-bezier(0.22, 1, 0.36, 1);
            will-change: opacity, transform;
        }

        @media (prefers-reduced-motion: reduce) {
            .garden-arch-masuk,
            .garden-daun-kiri,
            .garden-daun-kanan,
            .tirai-fade-halus.tirai-gulir-atas,
            .tirai-fade-halus.tirai-gulir-atas.tirai-terbuka,
            .velvet-video-teks {
                animation: none !important;
                transition: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
            .tirai-fade-halus.tirai-gulir-atas.tirai-terbuka {
                opacity: 0 !important;
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

    <div data-tata-letak-tema class="min-h-screen w-full lg:flex">
        {{-- PANGGUNG VISUAL DESKTOP KIRI (VICTORIAN CONSERVATORY TWILIGHT) --}}
        @include('tema.velvet-garden.partials._panggung-desktop')

        {{-- KOLOM UNDANGAN PORTRAIT MOBILE-FIRST (TERPUSAT DI TENGAH WEB) --}}
        <div data-kolom-undangan class="w-full lg:w-[460px] xl:w-[490px] shrink-0 min-h-screen relative overflow-x-clip shadow-[0_0_70px_rgba(0,0,0,0.55)] lg:border-x border-[#C8A464]/40 bg-[#132623]">
            {{-- Progres Baca Emas Botani --}}
            <div data-progres-undangan aria-hidden="true" x-show="undanganTerbuka" x-cloak class="fixed top-0 inset-x-0 mx-auto w-full lg:w-[460px] xl:w-[490px] z-[60] h-[3px] bg-black/30">
                <div class="h-full transition-all duration-150 bg-gradient-to-r from-[#8D6F3A] via-[#F3DFA2] to-[#C8A464]" :style="'width: ' + scrollPersen + '%'"></div>
            </div>

            {{-- Jendela Taman Kaca Terpin --}}
            <div data-latar-undangan aria-hidden="true" class="pointer-events-none fixed inset-y-0 inset-x-0 mx-auto w-full lg:w-[460px] xl:w-[490px] z-0 overflow-hidden bg-[#132623]">
                <img src="{{ $urlFotoLatar }}" alt="" class="w-full h-full object-cover object-center opacity-28">
                <div class="absolute inset-0 bg-gradient-to-b from-[#0E1E18]/78 via-[#132623]/64 to-[#0B1915]/88"></div>
            </div>

            {{-- INTRO PEMBUKA BESPOKE SEBELUM SAMPUL --}}
            @include('komponen-undangan.intro-pembuka')

            {{-- SAMPUL PEMBUKA GULIR ATAS HALUS --}}
            @include('tema.velvet-garden.partials._sampul')

            {{-- KONTEN UTAMA VELVET GARDEN --}}
            <main data-panggung-3d data-sinema-gsap="velvet-garden" class="panggung-3d relative z-10 {{ $tampilBarDemo ? 'pt-14' : '' }}">
                @include('tema.velvet-garden.partials._hero-dan-pembuka')
                @include('tema.velvet-garden.partials._konten-utama')
                @include('tema.velvet-garden.partials._penutup-dan-rsvp')
            </main>
        </div>

        {{-- PANGGUNG VISUAL DESKTOP KANAN (VICTORIAN CONSERVATORY KEEPSAKE) --}}
        @include('tema.velvet-garden.partials._panggung-desktop-kanan')
    </div>

    @include('komponen-undangan.kontrol-sinema')
    @include('komponen-undangan.pemutar-musik')
    @include('komponen-undangan.modal-galeri')
    @include('komponen-undangan.skrip-tema')
</body>
</html>
