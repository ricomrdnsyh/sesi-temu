@php
    $jalurVideoSunda = public_path('aset-tema/sunda-heritage/sunda-motion-hero.mp4');
    $asetSunda = [
        'latar' => asset('aset-tema/sunda-heritage/latar-utama.webp'),
        'gapura' => asset('aset-tema/sunda-heritage/gapura-priangan.webp'),
        'siger' => asset('aset-tema/sunda-heritage/ornamen-siger.webp'),
        'tiraiKujang' => asset('aset-tema/sunda-heritage/tirai-kujang-pembuka.webp'),
        'bingkaiPriangan' => asset('aset-tema/sunda-heritage/bingkai-priangan.webp'),
        'bungaDepan' => asset('aset-tema/sunda-heritage/bunga-depan-sunda.webp'),
        'videoHero' => file_exists($jalurVideoSunda) ? asset('aset-tema/sunda-heritage/sunda-motion-hero.mp4?v=2') : null,
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
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Hero Sinema 2.5D Penuh 1 Layar HP, Tablet & Desktop Anti-Zoom */
        .sunda-hero-layar-penuh {
            height: 100svh;
            height: 100dvh;
            min-height: 520px;
        }
        html.desktop-triptych [data-kolom-undangan] .sunda-hero-layar-penuh,
        html.tablet-stage [data-kolom-undangan] .sunda-hero-layar-penuh {
            height: var(--tinggi-tirai-dalam-inv, 100dvh) !important;
            min-height: var(--tinggi-tirai-dalam-inv, 100dvh) !important;
        }

        /* Transisi Sampul Scroll-Ke-Atas 60fps (GPU-Composited) Menyatu Langsung Ke Sinema Priangan */
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
            box-shadow: 0 28px 56px -10px rgba(34, 10, 10, 0.68);
        }
        .tirai-fade-halus.tirai-gulir-atas.tirai-terbuka {
            opacity: 1;
            transform: translate3d(0, -105%, 0);
            visibility: hidden;
            transition:
                transform 0.9s cubic-bezier(0.32, 0.72, 0, 1),
                visibility 0s linear 0.92s;
        }

        /* === KOREOGRAFI SINEMA 2.5D 60FPS PRIANGAN HERITAGE (BERLAPIS 6 BIDANG KEDALAMAN) === */
        @keyframes sundaLatarDolly {
            0% {
                transform: scale(1.26) translate3d(0, 16px, 0);
            }
            100% {
                transform: scale(1.04) translate3d(0, 0, 0);
            }
        }

        @keyframes sundaLatarNafas {
            0%, 100% {
                transform: scale(1.04) translate3d(0, 0, 0);
            }
            50% {
                transform: scale(1.085) translate3d(0, -6px, 0);
            }
        }

        @keyframes sundaTiraiBukaKiri {
            0% {
                opacity: 1;
                transform: perspective(1100px) translate3d(-4%, 0, 40px) scale(1.12) rotateY(0deg);
            }
            22% {
                opacity: 0.98;
                transform: perspective(1100px) translate3d(-22%, 1%, 70px) scale(1.22) rotateY(8deg);
            }
            100% {
                opacity: 0;
                transform: perspective(1100px) translate3d(-126%, 5%, 160px) scale(1.48) rotateY(22deg);
            }
        }

        @keyframes sundaTiraiBukaKanan {
            0% {
                opacity: 1;
                transform: perspective(1100px) scaleX(-1) translate3d(-4%, 0, 40px) scale(1.12) rotateY(0deg);
            }
            22% {
                opacity: 0.98;
                transform: perspective(1100px) scaleX(-1) translate3d(-22%, 1%, 70px) scale(1.22) rotateY(8deg);
            }
            100% {
                opacity: 0;
                transform: perspective(1100px) scaleX(-1) translate3d(-126%, 5%, 160px) scale(1.48) rotateY(22deg);
            }
        }

        @keyframes sundaGapuraMasuk {
            0% {
                opacity: 0;
                transform: translate3d(0, 36px, 0) scale(1.16);
            }
            100% {
                opacity: 0.96;
                transform: translate3d(0, 0, 0) scale(1);
            }
        }

        @keyframes sundaBungaNaik {
            0% {
                opacity: 0;
                transform: translate3d(0, 56px, 0) scale(1.1);
            }
            100% {
                opacity: 1;
                transform: translate3d(0, 0, 0) scale(1);
            }
        }

        @keyframes sundaBungaAngin {
            0%, 100% {
                transform: translate3d(0, 0, 0) scale(1);
            }
            50% {
                transform: translate3d(0, -4px, 0) scale(1.018);
            }
        }

        @keyframes sundaMelatiTurun {
            0% {
                opacity: 0;
                transform: translate3d(0, -42px, 0) rotate(-6deg);
            }
            100% {
                opacity: 0.92;
                transform: translate3d(0, 0, 0) rotate(-2deg);
            }
        }

        @keyframes sundaMelatiTurunBalik {
            0% {
                opacity: 0;
                transform: scaleX(-1) translate3d(0, -42px, 0) rotate(-6deg);
            }
            100% {
                opacity: 0.92;
                transform: scaleX(-1) translate3d(0, 0, 0) rotate(-2deg);
            }
        }

        @keyframes sundaMelatiAyun {
            0%, 100% {
                transform: translate3d(0, 0, 0) rotate(-2.2deg);
            }
            50% {
                transform: translate3d(0, 3px, 0) rotate(2.4deg);
            }
        }

        @keyframes sundaMelatiAyunBalik {
            0%, 100% {
                transform: translate3d(0, 0, 0) scaleX(-1) rotate(-2.2deg);
            }
            50% {
                transform: translate3d(0, 3px, 0) scaleX(-1) rotate(2.4deg);
            }
        }

        @keyframes sundaBingkaiMekar {
            0% {
                opacity: 0;
                transform: translate3d(0, 30px, 0) scale(0.76);
            }
            68% {
                opacity: 1;
                transform: translate3d(0, -2px, 0) scale(1.015);
            }
            100% {
                opacity: 1;
                transform: translate3d(0, 0, 0) scale(1);
            }
        }

        @keyframes sundaSigerTurun {
            0% {
                opacity: 0;
                transform: translate3d(0, -24px, 0) scale(0.84);
            }
            100% {
                opacity: 1;
                transform: translate3d(0, 0, 0) scale(1);
            }
        }

        @keyframes sundaTeksMuncul {
            0% {
                opacity: 0;
                transform: translate3d(0, 14px, 0) scale(0.96);
            }
            100% {
                opacity: 1;
                transform: translate3d(0, 0, 0) scale(1);
            }
        }

        @keyframes sundaSinarSapu {
            0%, 100% {
                opacity: 0.22;
                transform: translate3d(-8%, 0, 0) rotate(-18deg) scaleY(1);
            }
            50% {
                opacity: 0.52;
                transform: translate3d(10%, 0, 0) rotate(-14deg) scaleY(1.06);
            }
        }

        /* Kondisi Awal Sebelum Undangan Dibuka */
        .sunda-latar-dolly {
            transform: scale(1.26) translate3d(0, 16px, 0);
            will-change: transform;
            backface-visibility: hidden;
        }
        .sunda-tirai-kiri {
            transform: perspective(1100px) translate3d(-4%, 0, 40px) scale(1.12);
            will-change: transform, opacity;
            backface-visibility: hidden;
        }
        .sunda-tirai-kanan {
            transform: perspective(1100px) scaleX(-1) translate3d(-4%, 0, 40px) scale(1.12);
            will-change: transform, opacity;
            backface-visibility: hidden;
        }
        .sunda-gapura-masuk,
        .sunda-bunga-masuk,
        .sunda-bingkai-mekar,
        .sunda-siger-mahkota,
        .sunda-teks-1,
        .sunda-teks-2,
        .sunda-teks-3,
        .sunda-teks-4 {
            opacity: 0;
            will-change: transform, opacity;
            backface-visibility: hidden;
        }
        .sunda-melati-kiri,
        .sunda-melati-kanan {
            opacity: 0;
            transform-origin: top center;
            will-change: transform, opacity;
        }

        /* Aktivasi Serentak 60fps Ketika Undangan Dibuka (.cinema-aktif) */
        .cinema-aktif .sunda-latar-dolly {
            animation:
                sundaLatarDolly 4.5s cubic-bezier(0.22, 1, 0.36, 1) 0s forwards,
                sundaLatarNafas 16s ease-in-out 4.5s infinite;
        }
        .cinema-aktif .sunda-tirai-kiri {
            animation: sundaTiraiBukaKiri 2.15s cubic-bezier(0.22, 1, 0.36, 1) 0.1s forwards;
        }
        .cinema-aktif .sunda-tirai-kanan {
            animation: sundaTiraiBukaKanan 2.15s cubic-bezier(0.22, 1, 0.36, 1) 0.1s forwards;
        }
        .cinema-aktif .sunda-gapura-masuk {
            animation: sundaGapuraMasuk 1.85s cubic-bezier(0.16, 1, 0.3, 1) 0.55s both;
        }
        .cinema-aktif .sunda-bunga-masuk {
            animation:
                sundaBungaNaik 1.75s cubic-bezier(0.16, 1, 0.3, 1) 0.72s both,
                sundaBungaAngin 7.5s ease-in-out 2.5s infinite;
        }
        .cinema-aktif .sunda-melati-kiri {
            animation:
                sundaMelatiTurun 1.35s cubic-bezier(0.16, 1, 0.3, 1) 0.95s both,
                sundaMelatiAyun 5.8s ease-in-out 2.3s infinite;
        }
        .cinema-aktif .sunda-melati-kanan {
            animation:
                sundaMelatiTurunBalik 1.35s cubic-bezier(0.16, 1, 0.3, 1) 0.95s both,
                sundaMelatiAyunBalik 6.4s ease-in-out 2.3s infinite;
        }
        .cinema-aktif .sunda-bingkai-mekar {
            animation: sundaBingkaiMekar 1.55s cubic-bezier(0.16, 1, 0.3, 1) 2.0s both;
        }
        .cinema-aktif .sunda-siger-mahkota {
            animation: sundaSigerTurun 1.15s cubic-bezier(0.16, 1, 0.3, 1) 2.55s both;
        }
        .cinema-aktif .sunda-teks-1 {
            animation: sundaTeksMuncul 0.95s cubic-bezier(0.22, 1, 0.36, 1) 2.95s both;
        }
        .cinema-aktif .sunda-teks-2 {
            animation: sundaTeksMuncul 1.1s cubic-bezier(0.22, 1, 0.36, 1) 3.2s both;
        }
        .cinema-aktif .sunda-teks-3 {
            animation: sundaTeksMuncul 0.95s cubic-bezier(0.22, 1, 0.36, 1) 3.55s both;
        }
        .cinema-aktif .sunda-teks-4 {
            animation: sundaTeksMuncul 0.9s cubic-bezier(0.22, 1, 0.36, 1) 3.85s both;
        }

        .sunda-sinar-pagi {
            animation: sundaSinarSapu 10s ease-in-out infinite;
            will-change: transform, opacity;
        }

        .diorama-kamera-3d.sunda-kamera-video-aktif {
            animation: none !important;
            transform-style: flat !important;
            transform: none !important;
        }

        /* Kemunculan Tipografi Mempelai Tepat Di Dalam Bingkai Oval Emas Video Sunda */
        .sunda-video-teks {
            transition:
                opacity 1.15s cubic-bezier(0.22, 1, 0.36, 1),
                transform 1.15s cubic-bezier(0.22, 1, 0.36, 1);
            will-change: opacity, transform;
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
            .tirai-fade-halus.tirai-gulir-atas,
            .tirai-fade-halus.tirai-gulir-atas.tirai-terbuka {
                transition: none !important;
                transform: none !important;
            }
            .tirai-fade-halus.tirai-gulir-atas.tirai-terbuka {
                opacity: 0;
            }
            .sunda-tirai-kiri,
            .sunda-tirai-kanan {
                display: none !important;
            }
            .sunda-latar-dolly,
            .sunda-gapura-masuk,
            .sunda-bunga-masuk,
            .sunda-melati-kiri,
            .sunda-melati-kanan,
            .sunda-bingkai-mekar,
            .sunda-siger-mahkota,
            .sunda-teks-1,
            .sunda-teks-2,
            .sunda-teks-3,
            .sunda-teks-4,
            .sunda-sinar-pagi {
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
