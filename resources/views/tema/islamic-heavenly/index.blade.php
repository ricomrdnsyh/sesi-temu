@php
    $jalurVideoCelestial = public_path('aset-tema/islamic-heavenly/islamic-heavenly-motion-hero.mp4');
    $asetCelestial = [
        'latar' => asset('aset-tema/islamic-heavenly/latar-utama.webp'),
        'mihrab' => asset('aset-tema/islamic-heavenly/gerbang-mihrab.webp'),
        'lentera' => asset('aset-tema/islamic-heavenly/lentera-fanous.webp'),
        'sabit' => asset('aset-tema/islamic-heavenly/ornamen-sabit.webp'),
        'heroPoster' => asset('aset-tema/islamic-heavenly/hero-poster.webp'),
        'videoHero' => file_exists($jalurVideoCelestial) ? asset('aset-tema/islamic-heavenly/islamic-heavenly-motion-hero.mp4?v=1') : null,
    ];

    $dataTema = \App\Support\DataTemaUndangan::siapkan(
        $undangan,
        $modeDemo ?? false,
        $modePratinjau ?? false,
        'eksklusif',
        $asetCelestial['latar'],
    );
    extract($dataTema, EXTR_SKIP);
@endphp

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    @include('komponen-undangan.meta-opengraph')
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        @keyframes celestialMihrabMasuk {
            0% {
                opacity: 0;
                transform: translate3d(0, 22px, 0) scale(0.95);
            }

            100% {
                opacity: 1;
                transform: translate3d(0, 0, 0) scale(1);
            }
        }

        @keyframes celestialLenteraAyun {
            0%,
            100% {
                transform: translate3d(0, 0, 0) rotate(-2.8deg);
            }

            50% {
                transform: translate3d(0, 4px, 0) rotate(2.8deg);
            }
        }

        @keyframes celestialLenteraAyunBalik {
            0%,
            100% {
                transform: translate3d(0, 0, 0) scaleX(-1) rotate(-2.6deg);
            }

            50% {
                transform: translate3d(0, 4px, 0) scaleX(-1) rotate(2.6deg);
            }
        }

        .celestial-mihrab-masuk {
            animation: celestialMihrabMasuk 1.2s cubic-bezier(0.16, 1, 0.3, 1) 0.12s both;
            will-change: transform, opacity;
        }

        .celestial-lentera-kiri {
            transform-origin: top center;
            animation: celestialLenteraAyun 6.2s ease-in-out infinite;
            will-change: transform;
        }

        .celestial-lentera-kanan {
            transform-origin: top center;
            animation: celestialLenteraAyunBalik 6.8s ease-in-out infinite;
            will-change: transform;
        }

        .celestial-tombol-emas {
            background: linear-gradient(135deg, #F3E5AB 0%, #D9B664 52%, #B8903D 100%);
            color: #091322;
            box-shadow: 0 12px 26px -10px rgba(217, 182, 100, 0.58);
        }

        .celestial-tombol-emas:hover {
            filter: brightness(1.07);
        }

        .celestial-tombol-safir {
            background: linear-gradient(135deg, #18304F 0%, #102036 55%, #091322 100%);
            color: #F3E5AB;
            border: 1px solid rgba(217, 182, 100, 0.6);
            box-shadow: 0 10px 24px -10px rgba(4, 10, 19, 0.72);
        }

        .celestial-tombol-safir:hover {
            filter: brightness(1.12);
        }

        /* Hero Sinema Video Penuh 1 Layar HP, Tablet & Desktop Anti-Zoom */
        .celestial-hero-layar-penuh {
            height: 100svh;
            height: 100dvh;
            min-height: 520px;
        }

        html.desktop-triptych [data-kolom-undangan] .celestial-hero-layar-penuh,
        html.tablet-stage [data-kolom-undangan] .celestial-hero-layar-penuh {
            height: var(--tinggi-tirai-dalam-inv, 100dvh) !important;
            min-height: var(--tinggi-tirai-dalam-inv, 100dvh) !important;
        }

        /* Transisi Sampul Scroll-Ke-Atas 60fps Khusus Islamic Heavenly */
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
            box-shadow: 0 28px 56px -12px rgba(4, 10, 19, 0.8);
        }

        .tirai-fade-halus.tirai-gulir-atas.tirai-terbuka {
            opacity: 1;
            transform: translate3d(0, -105%, 0);
            visibility: hidden;
            transition:
                transform 0.9s cubic-bezier(0.32, 0.72, 0, 1),
                visibility 0s linear 0.92s;
        }

        /* Stabilisasi Kamera Video Hero Tanpa Transform 3D Agar Teks Tetap Tajam */
        .diorama-kamera-3d.celestial-kamera-video-aktif {
            animation: none !important;
            transform-style: flat !important;
            transform: none !important;
        }

        /* Kemunculan Tipografi Mempelai Sinkron Tepat Di Dalam Bingkai Safir Video */
        .celestial-video-teks {
            transition:
                opacity 1.15s cubic-bezier(0.22, 1, 0.36, 1),
                transform 1.15s cubic-bezier(0.22, 1, 0.36, 1);
            will-change: opacity, transform;
        }

        /* Pola Langit Bintang Halus untuk Permukaan Sanctuary Malam */
        .celestial-pola-bintang {
            background-image:
                radial-gradient(rgba(243, 229, 171, 0.22) 1px, transparent 1px),
                radial-gradient(rgba(217, 182, 100, 0.12) 1px, transparent 1px);
            background-size: 32px 32px, 22px 22px;
            background-position: 0 0, 11px 15px;
        }

        @media (prefers-reduced-motion: reduce) {
            .celestial-mihrab-masuk,
            .celestial-lentera-kiri,
            .celestial-lentera-kanan {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
            }

            .tirai-fade-halus.tirai-gulir-atas,
            .tirai-fade-halus.tirai-gulir-atas.tirai-terbuka,
            .celestial-video-teks {
                transition: none !important;
                transform: none !important;
            }

            .tirai-fade-halus.tirai-gulir-atas.tirai-terbuka {
                opacity: 0;
            }
        }
    </style>
</head>

<body x-data="temaUndangan()" :class="undanganTerbuka ? 'overflow-x-hidden' : 'overflow-hidden h-screen'"
    class="bg-[#060D18] text-[#E6EEF8] antialiased relative">
    @include('komponen-undangan.bar-pratinjau-demo')

    <div data-tata-letak-tema class="min-h-screen w-full lg:flex">
        {{-- PANGGUNG VISUAL DESKTOP KIRI (CELESTIAL NIGHT SANCTUARY) --}}
        @include('tema.islamic-heavenly.partials._panggung-desktop')

        {{-- KOLOM UNDANGAN PORTRAIT MOBILE-FIRST (TERPUSAT DI TENGAH WEB) --}}
        <div
            data-kolom-undangan
            class="w-full lg:w-[460px] xl:w-[490px] shrink-0 min-h-screen relative overflow-x-clip shadow-[0_0_70px_rgba(0,0,0,0.62)] lg:border-x border-[#D9B664]/40 bg-[#091322]">
            {{-- Progres Baca Emas Bintang --}}
            <div data-progres-undangan aria-hidden="true" x-show="undanganTerbuka" x-cloak
                class="fixed top-0 inset-x-0 mx-auto w-full lg:w-[460px] xl:w-[490px] z-[60] h-[3px] bg-black/45">
                <div class="h-full transition-all duration-150 bg-gradient-to-r from-[#B8903D] via-[#F3E5AB] to-[#D9B664]"
                    :style="'width: ' + scrollPersen + '%'"></div>
            </div>

            {{-- Jendela Langit Bintang Terpin --}}
            <div data-latar-undangan aria-hidden="true"
                class="pointer-events-none fixed inset-y-0 inset-x-0 mx-auto w-full lg:w-[460px] xl:w-[490px] z-0 overflow-hidden bg-[#091322]">
                <img src="{{ $urlFotoLatar }}" alt=""
                    class="w-full h-full object-cover object-center opacity-25">
                <div class="absolute inset-0 bg-gradient-to-b from-[#091322]/80 via-[#0E1B2A]/68 to-[#060D18]/92"></div>
            </div>

            {{-- INTRO PEMBUKA BESPOKE SEBELUM SAMPUL --}}
            @include('komponen-undangan.intro-pembuka')

            {{-- SAMPUL PEMBUKA CELESTIAL NIGHT --}}
            @include('tema.islamic-heavenly.partials._sampul')

            {{-- KONTEN UTAMA ISLAMIC HEAVENLY --}}
            <main data-panggung-3d data-sinema-gsap="islamic-heavenly" class="panggung-3d relative z-10 {{ $tampilBarDemo ? 'pt-14' : '' }}">
                @include('tema.islamic-heavenly.partials._hero-dan-pembuka')
                @include('tema.islamic-heavenly.partials._konten-utama')
                @include('tema.islamic-heavenly.partials._penutup-dan-rsvp')
            </main>
        </div>

        {{-- PANGGUNG VISUAL DESKTOP KANAN (CELESTIAL NIGHT KEEPSAKE) --}}
        @include('tema.islamic-heavenly.partials._panggung-desktop-kanan')
    </div>

    @include('komponen-undangan.kontrol-sinema')
    @include('komponen-undangan.pemutar-musik')
    @include('komponen-undangan.modal-galeri')
    @include('komponen-undangan.skrip-tema')
</body>

</html>
