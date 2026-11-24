@php
    $asetEditorial = [
        'latar' => asset('aset-tema/editorial-monokrom/latar-utama.webp'),
        'bingkai' => asset('aset-tema/editorial-monokrom/ornamen-bingkai.webp'),
    ];

    $dataTema = \App\Support\DataTemaUndangan::siapkan(
        $undangan,
        $modeDemo ?? false,
        $modePratinjau ?? false,
        'premium',
        $asetEditorial['latar'],
    );
    extract($dataTema, EXTR_SKIP);
    $tahunAcara = $acaraPertama?->tanggal_acara?->format('Y') ?? now()->format('Y');
@endphp

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    @include('komponen-undangan.meta-opengraph')
    <link href="https://fonts.googleapis.com/css2?family=Gilda+Display&family=Space+Mono:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        .ed-serif {
            font-family: 'Gilda Display', Georgia, serif;
        }

        .ed-mono {
            font-family: 'Space Mono', ui-monospace, SFMono-Regular, Menlo, monospace;
        }

        /* Tekstur Film Grain 35mm Halus Ringan GPU */
        .ed-film-grain {
            background-image: radial-gradient(rgba(255, 255, 255, 0.09) 1px, transparent 0);
            background-size: 22px 22px;
        }

        /* === TRANSISI BUKA SAMPUL: LEICA MECHANICAL HORIZONTAL SHUTTER APERTURE === */
        .tirai-fade-halus.tirai-shutter-editorial {
            clip-path: inset(0% 0% 0% 0%);
            opacity: 1;
            transform: scale(1);
            filter: contrast(1) brightness(1);
            transition:
                clip-path 1.02s cubic-bezier(0.77, 0, 0.175, 1),
                transform 1.12s cubic-bezier(0.77, 0, 0.175, 1),
                filter 0.72s ease,
                opacity 0.26s ease 0.82s;
            will-change: clip-path, transform, opacity;
        }

        .tirai-fade-halus.tirai-shutter-editorial.tirai-terbuka {
            clip-path: inset(49.7% 0% 49.7% 0%);
            transform: scale(1.06);
            filter: contrast(1.32) brightness(1.22);
            opacity: 0;
        }

        /* === KOREOGRAFI DARKROOM FOCUS & MASKED TYPOGRAPHY REVEAL PADA HERO === */
        @keyframes edDarkroomFocus {
            0% {
                transform: scale(1.22);
                filter: grayscale(1) contrast(1.42) blur(7px) brightness(1.25);
            }
            100% {
                transform: scale(1.02);
                filter: grayscale(1) contrast(1.08) blur(0px) brightness(1);
            }
        }

        @keyframes edShutterFlashLine {
            0% {
                opacity: 0;
                transform: scaleX(0.05);
            }
            28% {
                opacity: 0.95;
                transform: scaleX(1);
            }
            100% {
                opacity: 0;
                transform: scaleX(1.08);
            }
        }

        @keyframes edMaskLineUp {
            0% {
                opacity: 0;
                transform: translate3d(0, 108%, 0) skewY(2.5deg);
            }
            100% {
                opacity: 1;
                transform: translate3d(0, 0, 0) skewY(0deg);
            }
        }

        @keyframes edHairlineDrawX {
            0% {
                transform: scaleX(0);
                opacity: 0;
            }
            100% {
                transform: scaleX(1);
                opacity: 1;
            }
        }

        @keyframes edMarqueeBalik {
            0% {
                transform: translate3d(-50%, 0, 0);
            }
            100% {
                transform: translate3d(0%, 0, 0);
            }
        }

        @keyframes edScanViewfinder {
            0%, 100% {
                transform: translate3d(0, 0%, 0);
                opacity: 0.18;
            }
            50% {
                transform: translate3d(0, 320%, 0);
                opacity: 0.45;
            }
        }

        @keyframes edPutarKompas {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .ed-foto-darkroom-aktif {
            animation: edDarkroomFocus 1.65s cubic-bezier(0.16, 1, 0.3, 1) 0.12s both;
            will-change: transform, filter;
        }

        .ed-kilat-shutter-aktif {
            animation: edShutterFlashLine 1.1s cubic-bezier(0.16, 1, 0.3, 1) 0.18s both;
        }

        .ed-mask-wrap {
            overflow: hidden;
            display: block;
        }

        .ed-mask-baris-1 {
            animation: edMaskLineUp 0.95s cubic-bezier(0.16, 1, 0.3, 1) 0.34s both;
        }

        .ed-mask-baris-2 {
            animation: edMaskLineUp 0.95s cubic-bezier(0.16, 1, 0.3, 1) 0.48s both;
        }

        .ed-mask-baris-3 {
            animation: edMaskLineUp 0.95s cubic-bezier(0.16, 1, 0.3, 1) 0.62s both;
        }

        .ed-mask-baris-4 {
            animation: edMaskLineUp 0.95s cubic-bezier(0.16, 1, 0.3, 1) 0.76s both;
        }

        .ed-garis-hero-aktif {
            transform-origin: left center;
            animation: edHairlineDrawX 1.1s cubic-bezier(0.16, 1, 0.3, 1) 0.28s both;
        }

        .ed-marquee-kanan {
            display: flex;
            width: max-content;
            animation: edMarqueeBalik 26s linear infinite;
            will-change: transform;
        }

        .ed-teks-garis {
            color: transparent;
            -webkit-text-stroke: 1px rgba(250, 249, 246, 0.52);
        }

        .ed-angka-outline {
            color: transparent;
            -webkit-text-stroke: 1.35px #18181B;
        }

        .ed-scanline {
            animation: edScanViewfinder 5.8s ease-in-out infinite;
        }

        .ed-putar-lambat {
            animation: edPutarKompas 34s linear infinite;
        }

        /* === TIRAI TINTA POTRET (INK SHUTTER WIPE ON SCROLL) === */
        .ed-tirai-foto {
            position: relative;
            overflow: hidden;
        }

        .ed-tirai-foto::after {
            content: '';
            position: absolute;
            inset: 0;
            background: #18181B;
            transform-origin: right center;
            transform: scaleX(1);
            transition: transform 0.92s cubic-bezier(0.77, 0, 0.175, 1);
            pointer-events: none;
            z-index: 15;
        }

        .ed-tirai-foto.ed-terbuka::after {
            transform: scaleX(0);
        }

        .ed-tirai-foto img {
            transform: scale(1.09);
            transition:
                transform 1.25s cubic-bezier(0.16, 1, 0.3, 1),
                filter 0.65s ease;
        }

        .ed-tirai-foto.ed-terbuka img {
            transform: scale(1);
        }

        /* Efek Tombol Slide-Invert Khas Editorial Arsitektural */
        .ed-btn-invert {
            position: relative;
            overflow: hidden;
            isolation: isolate;
        }

        .ed-btn-invert::before {
            content: '';
            position: absolute;
            inset: 0;
            background: currentColor;
            opacity: 0.12;
            transform: translate3d(-102%, 0, 0);
            transition: transform 0.38s cubic-bezier(0.22, 1, 0.36, 1);
            z-index: -1;
        }

        .ed-btn-invert:hover::before {
            transform: translate3d(0, 0, 0);
        }

        /* Bayangan Brutalis Arsitektural Halus */
        .ed-bayangan-tajam {
            box-shadow: 6px 6px 0 0 #18181B;
        }

        .ed-bayangan-putih {
            box-shadow: 6px 6px 0 0 rgba(250, 249, 246, 0.22);
        }

        @media (prefers-reduced-motion: reduce) {
            .tirai-fade-halus.tirai-shutter-editorial,
            .ed-foto-darkroom-aktif,
            .ed-kilat-shutter-aktif,
            .ed-mask-baris-1,
            .ed-mask-baris-2,
            .ed-mask-baris-3,
            .ed-mask-baris-4,
            .ed-garis-hero-aktif,
            .ed-marquee-kanan,
            .ed-scanline,
            .ed-putar-lambat {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
                filter: none !important;
            }

            .ed-tirai-foto::after {
                display: none !important;
            }

            .ed-tirai-foto img {
                transform: none !important;
            }
        }
    </style>
</head>

<body
    x-data="{
        ...temaUndangan(),
        modeWarnaEditorial: false,
        amplopTerbuka: false,
        babCeritaAktif: 0,
        semuaBabCerita: false
    }"
    :class="undanganTerbuka ? 'overflow-x-hidden' : 'overflow-hidden h-screen'"
    class="bg-[#0E0E11] text-[#18181B] antialiased relative selection:bg-[#18181B] selection:text-[#FAF9F6]"
>
    @include('komponen-undangan.bar-pratinjau-demo')

    <div data-tata-letak-tema class="min-h-screen w-full lg:flex">
        {{-- PANGGUNG VISUAL DESKTOP KIRI (VOGUE EXHIBITION BACKDROP) --}}
        @include('tema.editorial-monokrom.partials._panggung-desktop')

        {{-- KOLOM UNDANGAN PORTRAIT MOBILE-FIRST (TERPUSAT DI TENGAH WEB — ZERO ROUNDED CORNERS) --}}
        <div
            data-kolom-undangan
            class="w-full lg:w-[460px] xl:w-[490px] shrink-0 min-h-screen relative overflow-x-clip shadow-[0_0_80px_rgba(0,0,0,0.78)] lg:border-x border-white/25 bg-[#FAF9F6]"
        >
            {{-- Progres Baca Vernier Arsitektural + Indikator Persentase Live --}}
            <div
                data-progres-undangan
                aria-hidden="true"
                x-show="undanganTerbuka"
                x-cloak
                class="fixed top-0 inset-x-0 mx-auto w-full lg:w-[460px] xl:w-[490px] z-[60] pointer-events-none"
            >
                <div class="h-[3px] bg-black/15 w-full overflow-hidden">
                    <div class="h-full transition-all duration-150 bg-[#18181B]" :style="'width: ' + scrollPersen + '%'"></div>
                </div>
                <div class="flex justify-end pr-3 pt-1.5">
                    <span class="ed-mono bg-[#18181B]/90 text-[#FAF9F6] px-2 py-0.5 text-[8.5px] tracking-[0.2em] uppercase border border-white/20">
                        IDX <span x-text="String(scrollPersen).padStart(2, '0') + '%'">00%</span>
                    </span>
                </div>
            </div>

            {{-- INTRO PEMBUKA BESPOKE SEBELUM SAMPUL --}}
            @include('komponen-undangan.intro-pembuka')

            {{-- SAMPUL PEMBUKA LEICA SHUTTER APERTURE (VOGUE ISSUE COVER) --}}
            @include('tema.editorial-monokrom.partials._sampul')

            {{-- KONTEN UTAMA EDITORIAL MONOKROM --}}
            <main data-panggung-3d data-sinema-gsap="editorial-monokrom" class="panggung-3d relative z-10 {{ $tampilBarDemo ? 'pt-14' : '' }}">
                @include('tema.editorial-monokrom.partials._hero-dan-pembuka')
                @include('tema.editorial-monokrom.partials._konten-utama')
                @include('tema.editorial-monokrom.partials._penutup-dan-rsvp')
            </main>
        </div>

        {{-- PANGGUNG VISUAL DESKTOP KANAN (EXHIBITION MONOGRAM & TELEMETRY) --}}
        @include('tema.editorial-monokrom.partials._panggung-desktop-kanan')
    </div>

    @include('komponen-undangan.kontrol-sinema')
    @include('komponen-undangan.pemutar-musik')
    @include('komponen-undangan.modal-galeri')
    @include('komponen-undangan.skrip-tema')

    {{-- Pengamat Tirai Tinta Potret (Ink Shutter Wipe Observer) --}}
    <script>
        (function () {
            const daftarFoto = document.querySelectorAll('.ed-tirai-foto');
            if (!daftarFoto.length) return;
            const kurangi = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const embed = new URLSearchParams(window.location.search).get('embed') === '1';
            if (kurangi || embed || !('IntersectionObserver' in window)) {
                daftarFoto.forEach((el) => el.classList.add('ed-terbuka'));
                return;
            }
            const io = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('ed-terbuka');
                    } else if (entry.boundingClientRect.top > window.innerHeight * 0.98) {
                        entry.target.classList.remove('ed-terbuka');
                    }
                });
            }, { threshold: 0.14, rootMargin: '0px 0px -30px 0px' });
            daftarFoto.forEach((el) => io.observe(el));
        })();
    </script>
</body>

</html>
