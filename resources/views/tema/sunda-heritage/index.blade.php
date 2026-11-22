@php
    $asetSunda = [
        'latar' => asset('aset-tema/sunda-heritage/latar-utama.webp'),
        'gapura' => asset('aset-tema/sunda-heritage/gapura-priangan.webp'),
        'siger' => asset('aset-tema/sunda-heritage/ornamen-siger.webp'),
    ];

    $dataTema = \App\Support\DataTemaUndangan::siapkan(
        $undangan,
        $modeDemo ?? false,
        $modePratinjau ?? false,
        'premium',
        $asetSunda['latar'],
    );
    extract($dataTema, EXTR_SKIP);
@endphp

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    @include('komponen-undangan.meta-opengraph')
    <style>
        @keyframes sundaGapuraMasuk {
            0% {
                opacity: 0;
                transform: translate3d(0, 26px, 0) scale(0.95);
            }

            100% {
                opacity: 1;
                transform: translate3d(0, 0, 0) scale(1);
            }
        }

        @keyframes sundaMelatiAyun {

            0%,
            100% {
                transform: translate3d(0, 0, 0) rotate(-2.2deg);
            }

            50% {
                transform: translate3d(0, 3px, 0) rotate(2.2deg);
            }
        }

        @keyframes sundaMelatiAyunBalik {

            0%,
            100% {
                transform: translate3d(0, 0, 0) scaleX(-1) rotate(-2.2deg);
            }

            50% {
                transform: translate3d(0, 3px, 0) scaleX(-1) rotate(2.2deg);
            }
        }

        .sunda-gapura-masuk {
            animation: sundaGapuraMasuk 1.15s cubic-bezier(0.16, 1, 0.3, 1) 0.12s both;
            will-change: transform, opacity;
        }

        .sunda-melati-kiri {
            transform-origin: top center;
            animation: sundaMelatiAyun 5.8s ease-in-out infinite;
            will-change: transform;
        }

        .sunda-melati-kanan {
            transform-origin: top center;
            animation: sundaMelatiAyunBalik 6.4s ease-in-out infinite;
            will-change: transform;
        }

        .sunda-tombol-marun {
            background: linear-gradient(135deg, #6E2C2C 0%, #5A1E1E 55%, #7D362A 100%);
            color: #FAF4E8;
            border: 1px solid rgba(197, 155, 67, 0.65);
            box-shadow: 0 10px 24px -10px rgba(90, 30, 30, 0.65);
        }

        .sunda-tombol-marun:hover {
            filter: brightness(1.08);
        }

        .sunda-tombol-emas {
            background: linear-gradient(135deg, #D5B05C 0%, #B58931 55%, #DFC078 100%);
            color: #3B1414;
            box-shadow: 0 10px 24px -10px rgba(0, 0, 0, 0.45);
        }

        .sunda-tombol-emas:hover {
            filter: brightness(1.06);
        }

        @media (prefers-reduced-motion: reduce) {

            .sunda-gapura-masuk,
            .sunda-melati-kiri,
            .sunda-melati-kanan {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
        }
    </style>
</head>

<body x-data="temaUndangan()" :class="undanganTerbuka ? 'overflow-x-hidden' : 'overflow-hidden h-screen'"
    class="bg-[#4A1717] text-[#4A2020] antialiased relative">
    @include('komponen-undangan.bar-pratinjau-demo')

    <div data-tata-letak-tema class="min-h-screen w-full lg:flex">
        {{-- PANGGUNG VISUAL DESKTOP KIRI (PRIANGAN HERITAGE) --}}
        @include('tema.sunda-heritage.partials._panggung-desktop')

        {{-- KOLOM UNDANGAN PORTRAIT MOBILE-FIRST (TERPUSAT DI TENGAH WEB) --}}
        <div
            data-kolom-undangan
            class="w-full lg:w-[460px] xl:w-[490px] shrink-0 min-h-screen relative overflow-x-clip shadow-[0_0_70px_rgba(0,0,0,0.5)] lg:border-x border-[#C59B43]/45 bg-[#FAF4E8]">
            {{-- Progres Baca Emas-Marun --}}
            <div data-progres-undangan aria-hidden="true" x-show="undanganTerbuka" x-cloak
                class="fixed top-0 inset-x-0 mx-auto w-full lg:w-[460px] xl:w-[490px] z-[60] h-[3px] bg-black/20">
                <div class="h-full transition-all duration-150 bg-gradient-to-r from-[#6E2C2C] via-[#C59B43] to-[#F3E5AB]"
                    :style="'width: ' + scrollPersen + '%'"></div>
            </div>

            {{-- Jendela Latar Terpin Priangan --}}
            <div data-latar-undangan aria-hidden="true"
                class="pointer-events-none fixed inset-y-0 inset-x-0 mx-auto w-full lg:w-[460px] xl:w-[490px] z-0 overflow-hidden bg-[#F3E8D6]">
                <img src="{{ $urlFotoLatar }}" alt=""
                    class="w-full h-full object-cover object-center opacity-28">
                <div class="absolute inset-0 bg-gradient-to-b from-[#FAF4E8]/70 via-[#FAF4E8]/45 to-[#FAF4E8]/75"></div>
            </div>

            {{-- SAMPUL PEMBUKA FADE HALUS --}}
            @include('tema.sunda-heritage.partials._sampul')

            {{-- KONTEN UTAMA SUNDA SIGER HERITAGE --}}
            <main data-panggung-3d class="panggung-3d relative z-10 {{ $tampilBarDemo ? 'pt-14' : '' }}">
                @include('tema.sunda-heritage.partials._hero-dan-pembuka')
                @include('tema.sunda-heritage.partials._konten-utama')
                @include('tema.sunda-heritage.partials._penutup-dan-rsvp')
            </main>
        </div>

        {{-- PANGGUNG VISUAL DESKTOP KANAN (KEEPSAKE PRIANGAN HERITAGE) --}}
        @include('tema.sunda-heritage.partials._panggung-desktop-kanan')
    </div>

    @include('komponen-undangan.kontrol-sinema')
    @include('komponen-undangan.pemutar-musik')
    @include('komponen-undangan.modal-galeri')
    @include('komponen-undangan.skrip-tema')
</body>

</html>
