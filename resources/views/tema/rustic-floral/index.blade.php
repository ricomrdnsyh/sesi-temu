@php
    $asetRustic = [
        'latar' => asset('aset-tema/rustic-floral/latar-utama.webp?v=2'),
        'sudut' => asset('aset-tema/rustic-floral/ornamen-sudut.webp'),
    ];

    $dataTema = \App\Support\DataTemaUndangan::siapkan(
        $undangan,
        $modeDemo ?? false,
        $modePratinjau ?? false,
        'basic',
        $asetRustic['latar'],
    );
    extract($dataTema, EXTR_SKIP);
@endphp

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    @include('komponen-undangan.meta-opengraph')
    <style>
        .rustic-tombol-sage {
            background: linear-gradient(135deg, #4B6358 0%, #3A4D44 60%, #2F4037 100%);
            color: #FDFBF7;
            box-shadow: 0 10px 20px -10px rgba(75, 99, 88, 0.55);
        }

        .rustic-tombol-sage:hover {
            filter: brightness(1.07);
        }

        /* Transisi Sampul Scroll-Ke-Atas Khusus Rustic Floral */
        .tirai-fade-halus.tirai-gulir-atas {
            opacity: 1;
            transform: translate3d(0, 0, 0);
            visibility: visible;
            transition:
                transform 0.95s cubic-bezier(0.65, 0, 0.35, 1),
                visibility 0s linear 0s;
            will-change: transform;
        }

        .tirai-fade-halus.tirai-gulir-atas > div {
            box-shadow: 0 26px 52px -12px rgba(20, 32, 26, 0.45);
        }

        .tirai-fade-halus.tirai-gulir-atas.tirai-terbuka {
            opacity: 1;
            transform: translate3d(0, -105%, 0);
            visibility: hidden;
            transition:
                transform 0.95s cubic-bezier(0.65, 0, 0.35, 1),
                visibility 0s linear 0.96s;
        }

        /* Tinggi Hero Pas 1 Layar HP & Terkunci Proporsional di Desktop Anti-Zoom */
        .rustic-hero-layar-penuh {
            min-height: 100svh;
            min-height: 100dvh;
        }

        .rustic-hero-layar-penuh.dengan-bar-demo {
            min-height: calc(100svh - 3.5rem);
            min-height: calc(100dvh - 3.5rem);
        }

        html.desktop-triptych [data-kolom-undangan] .rustic-hero-layar-penuh {
            min-height: var(--tinggi-tirai-dalam-inv, 100dvh) !important;
        }

        /* Gerak Naik Sinkron Saat Sampul Digulir Ke Atas */
        .rustic-hero-kartu {
            transform: translate3d(0, 38px, 0) scale(0.985);
            transition: transform 0.98s cubic-bezier(0.22, 1, 0.36, 1);
            will-change: transform;
        }

        .rustic-hero-kartu.rustic-hero-terbuka {
            transform: translate3d(0, 0, 0) scale(1);
        }

        .rustic-hero-stagger-1,
        .rustic-hero-stagger-2,
        .rustic-hero-stagger-3 {
            transform: translate3d(0, 20px, 0);
            transition: transform 0.9s cubic-bezier(0.22, 1, 0.36, 1);
            will-change: transform;
        }

        .rustic-hero-stagger-2 {
            transition-delay: 0.12s;
        }

        .rustic-hero-stagger-3 {
            transition-delay: 0.22s;
        }

        .rustic-hero-terbuka .rustic-hero-stagger-1,
        .rustic-hero-terbuka .rustic-hero-stagger-2,
        .rustic-hero-terbuka .rustic-hero-stagger-3 {
            transform: translate3d(0, 0, 0);
        }

        @media (prefers-reduced-motion: reduce) {
            .tirai-fade-halus.tirai-gulir-atas,
            .tirai-fade-halus.tirai-gulir-atas.tirai-terbuka,
            .rustic-hero-kartu,
            .rustic-hero-stagger-1,
            .rustic-hero-stagger-2,
            .rustic-hero-stagger-3 {
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
    class="bg-[#EFE6DA] text-[#1F2937] antialiased relative">
    @include('komponen-undangan.bar-pratinjau-demo')

    <div data-tata-letak-tema class="min-h-screen w-full lg:flex">
        {{-- PANGGUNG VISUAL DESKTOP KIRI (WARM LINEN & BOTANICAL SCRAPBOOK) --}}
        @include('tema.rustic-floral.partials._panggung-desktop')

        {{-- KOLOM UNDANGAN PORTRAIT MOBILE-FIRST (TERPUSAT DI TENGAH WEB) --}}
        <div
            data-kolom-undangan
            class="w-full lg:w-[460px] xl:w-[490px] shrink-0 min-h-screen relative overflow-x-clip shadow-[0_0_70px_rgba(0,0,0,0.45)] lg:border-x border-[#BFA15F]/45 bg-[#FDFBF7]">
            {{-- Jendela Latar Linen Terpin --}}
            <div data-latar-undangan aria-hidden="true"
                class="pointer-events-none fixed inset-y-0 inset-x-0 mx-auto w-full lg:w-[460px] xl:w-[490px] z-0 overflow-hidden bg-[#FDFBF7]">
                <img src="{{ $urlFotoLatar }}" alt="" class="w-full h-full object-cover object-center opacity-30">
                <div class="absolute inset-0 bg-gradient-to-b from-[#FDFBF7]/72 via-[#FDFBF7]/45 to-[#F4ECE1]/78"></div>
            </div>

            {{-- INTRO PEMBUKA BESPOKE SEBELUM SAMPUL --}}
            @include('komponen-undangan.intro-pembuka')

            {{-- SAMPUL PEMBUKA FADE HALUS --}}
            @include('tema.rustic-floral.partials._sampul')

            {{-- KONTEN UTAMA RUSTIC FLORAL SCRAPBOOK --}}
            <main data-panggung-3d data-sinema-gsap="rustic-floral" class="panggung-3d relative z-10 {{ $tampilBarDemo ? 'pt-14' : '' }}">
                @include('tema.rustic-floral.partials._hero-dan-pembuka')
                @include('tema.rustic-floral.partials._konten-utama')
                @include('tema.rustic-floral.partials._penutup-dan-rsvp')
            </main>
        </div>

        {{-- PANGGUNG VISUAL DESKTOP KANAN (WARM LINEN & BOTANICAL KEEPSAKE) --}}
        @include('tema.rustic-floral.partials._panggung-desktop-kanan')
    </div>

    @include('komponen-undangan.kontrol-sinema')
    @include('komponen-undangan.pemutar-musik')
    @include('komponen-undangan.modal-galeri')
    @include('komponen-undangan.skrip-tema')
</body>

</html>
