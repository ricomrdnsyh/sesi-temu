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
    <link href="https://fonts.googleapis.com/css2?family=Gilda+Display&display=swap" rel="stylesheet">
    <style>
        .ed-serif {
            font-family: 'Gilda Display', Georgia, serif;
        }

        @keyframes edSpreadMasuk {
            0% {
                opacity: 0;
                transform: translate3d(0, 18px, 0);
            }

            100% {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        .ed-spread-masuk {
            animation: edSpreadMasuk 1s cubic-bezier(0.16, 1, 0.3, 1) 0.1s both;
            will-change: transform, opacity;
        }

        @media (prefers-reduced-motion: reduce) {
            .ed-spread-masuk {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
        }
    </style>
</head>

<body x-data="temaUndangan()" :class="undanganTerbuka ? 'overflow-x-hidden' : 'overflow-hidden h-screen'"
    class="bg-[#111113] text-[#18181B] antialiased relative">
    @include('komponen-undangan.bar-pratinjau-demo')

    <div data-tata-letak-tema class="min-h-screen w-full lg:flex">
        {{-- PANGGUNG VISUAL DESKTOP KIRI (VOGUE MONOCHROME SPREAD) --}}
        @include('tema.editorial-monokrom.partials._panggung-desktop')

        {{-- KOLOM UNDANGAN PORTRAIT MOBILE-FIRST (TERPUSAT DI TENGAH WEB — ZERO ROUNDED CORNERS) --}}
        <div
            data-kolom-undangan
            class="w-full lg:w-[460px] xl:w-[490px] shrink-0 min-h-screen relative overflow-x-clip shadow-[0_0_70px_rgba(0,0,0,0.65)] lg:border-x border-white/25 bg-[#FAF9F6]">
            {{-- Progres Baca Hitam Tajam --}}
            <div data-progres-undangan aria-hidden="true" x-show="undanganTerbuka" x-cloak
                class="fixed top-0 inset-x-0 mx-auto w-full lg:w-[460px] xl:w-[490px] z-[60] h-[3px] bg-black/15">
                <div class="h-full transition-all duration-150 bg-[#18181B]" :style="'width: ' + scrollPersen + '%'">
                </div>
            </div>

            {{-- SAMPUL PEMBUKA FADE HALUS (VOGUE COVER) --}}
            @include('tema.editorial-monokrom.partials._sampul')

            {{-- KONTEN UTAMA EDITORIAL MONOKROM --}}
            <main data-panggung-3d class="panggung-3d relative z-10 {{ $tampilBarDemo ? 'pt-14' : '' }}">
                @include('tema.editorial-monokrom.partials._hero-dan-pembuka')
                @include('tema.editorial-monokrom.partials._konten-utama')
                @include('tema.editorial-monokrom.partials._penutup-dan-rsvp')
            </main>
        </div>

        {{-- PANGGUNG VISUAL DESKTOP KANAN (VOGUE MONOCHROME PROGRAM & PASS) --}}
        @include('tema.editorial-monokrom.partials._panggung-desktop-kanan')
    </div>

    @include('komponen-undangan.kontrol-sinema')
    @include('komponen-undangan.pemutar-musik')
    @include('komponen-undangan.modal-galeri')
    @include('komponen-undangan.skrip-tema')
</body>

</html>
