@php
    $asetCelestial = [
        'latar' => asset('aset-tema/islamic-heavenly/latar-utama.webp'),
        'mihrab' => asset('aset-tema/islamic-heavenly/gerbang-mihrab.webp'),
        'lentera' => asset('aset-tema/islamic-heavenly/lentera-fanous.webp'),
        'sabit' => asset('aset-tema/islamic-heavenly/ornamen-sabit.webp'),
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
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap" rel="stylesheet">
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
            background: linear-gradient(135deg, #E7C87D 0%, #D9B664 55%, #B8903D 100%);
            color: #091322;
            box-shadow: 0 12px 26px -10px rgba(217, 182, 100, 0.55);
        }

        .celestial-tombol-emas:hover {
            filter: brightness(1.08);
        }

        @media (prefers-reduced-motion: reduce) {

            .celestial-mihrab-masuk,
            .celestial-lentera-kiri,
            .celestial-lentera-kanan {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
        }
    </style>
</head>

<body x-data="temaUndangan()" :class="undanganTerbuka ? 'overflow-x-hidden' : 'overflow-hidden h-screen'"
    class="bg-[#091322] text-[#E6EEF8] antialiased relative">
    @include('komponen-undangan.bar-pratinjau-demo')

    <div data-tata-letak-tema class="min-h-screen w-full lg:flex">
        {{-- PANGGUNG VISUAL DESKTOP KIRI (CELESTIAL NIGHT SANCTUARY) --}}
        @include('tema.islamic-heavenly.partials._panggung-desktop')

        {{-- KOLOM UNDANGAN PORTRAIT MOBILE-FIRST (TERPUSAT DI TENGAH WEB) --}}
        <div
            data-kolom-undangan
            class="w-full lg:w-[460px] xl:w-[490px] shrink-0 min-h-screen relative overflow-x-clip shadow-[0_0_70px_rgba(0,0,0,0.55)] lg:border-x border-[#D9B664]/40 bg-[#091322]">
            {{-- Progres Baca Emas Bintang --}}
            <div data-progres-undangan aria-hidden="true" x-show="undanganTerbuka" x-cloak
                class="fixed top-0 inset-x-0 mx-auto w-full lg:w-[460px] xl:w-[490px] z-[60] h-[3px] bg-black/40">
                <div class="h-full transition-all duration-150 bg-gradient-to-r from-[#B8903D] via-[#F3E5AB] to-[#D9B664]"
                    :style="'width: ' + scrollPersen + '%'"></div>
            </div>

            {{-- Jendela Langit Bintang Terpin --}}
            <div data-latar-undangan aria-hidden="true"
                class="pointer-events-none fixed inset-y-0 inset-x-0 mx-auto w-full lg:w-[460px] xl:w-[490px] z-0 overflow-hidden bg-[#091322]">
                <img src="{{ $urlFotoLatar }}" alt=""
                    class="w-full h-full object-cover object-center opacity-35">
                <div class="absolute inset-0 bg-gradient-to-b from-[#091322]/75 via-[#0E1B2A]/55 to-[#091322]/85"></div>
            </div>

            {{-- SAMPUL PEMBUKA FADE HALUS --}}
            @include('tema.islamic-heavenly.partials._sampul')

            {{-- KONTEN UTAMA ISLAMIC HEAVENLY --}}
            <main data-panggung-3d class="panggung-3d relative z-10 {{ $tampilBarDemo ? 'pt-14' : '' }}">
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
