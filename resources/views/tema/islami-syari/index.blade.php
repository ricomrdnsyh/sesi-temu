@php
    $jalurVideoSyari = public_path('aset-tema/islami-syari/islami-syari-motion-hero.mp4');
    $asetSyari = [
        'latar' => asset('aset-tema/islami-syari/latar-utama.webp'),
        'arabesque' => asset('aset-tema/islami-syari/ornamen-arabesque.webp'),
        'heroPoster' => asset('aset-tema/islami-syari/hero-poster.webp'),
        'videoHero' => file_exists($jalurVideoSyari) ? asset('aset-tema/islami-syari/islami-syari-motion-hero.mp4?v=1') : null,
    ];

    $dataTema = \App\Support\DataTemaUndangan::siapkan(
        $undangan,
        $modeDemo ?? false,
        $modePratinjau ?? false,
        'basic',
        $asetSyari['latar']
    );
    extract($dataTema, EXTR_SKIP);
@endphp

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    @include('komponen-undangan.meta-opengraph')
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        .syari-tombol {
            background: linear-gradient(135deg, #16524C 0%, #0E3A36 55%, #0A2B28 100%);
            color: #F7FBF8;
            border: 1px solid rgba(197, 160, 89, 0.72);
            box-shadow: 0 12px 24px -10px rgba(14, 58, 54, 0.58);
        }
        .syari-tombol:hover {
            filter: brightness(1.09);
        }

        .syari-tombol-emas {
            background: linear-gradient(135deg, #EFE0B4 0%, #D4B56E 52%, #B99348 100%);
            color: #092623;
            box-shadow: 0 10px 24px -10px rgba(197, 160, 89, 0.65);
        }
        .syari-tombol-emas:hover {
            filter: brightness(1.06);
        }

        /* Hero Sinema Video Penuh 1 Layar HP, Tablet & Desktop Anti-Zoom */
        .syari-hero-layar-penuh {
            height: 100svh;
            height: 100dvh;
            min-height: 520px;
        }
        html.desktop-triptych [data-kolom-undangan] .syari-hero-layar-penuh,
        html.tablet-stage [data-kolom-undangan] .syari-hero-layar-penuh {
            height: var(--tinggi-tirai-dalam-inv, 100dvh) !important;
            min-height: var(--tinggi-tirai-dalam-inv, 100dvh) !important;
        }

        /* Transisi Sampul Scroll-Ke-Atas 60fps Khusus Islami Syar'i */
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
            box-shadow: 0 28px 56px -12px rgba(8, 34, 31, 0.65);
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
        .diorama-kamera-3d.syari-kamera-video-aktif {
            animation: none !important;
            transform-style: flat !important;
            transform: none !important;
        }

        /* Kemunculan Tipografi Mempelai Sinkron Tepat Di Dalam Bingkai Mihrab Zamrud Video */
        .syari-video-teks {
            transition:
                opacity 1.15s cubic-bezier(0.22, 1, 0.36, 1),
                transform 1.15s cubic-bezier(0.22, 1, 0.36, 1);
            will-change: opacity, transform;
        }

        /* Gerak Naik Sinkron Hero Fallback Saat Sampul Digulir Ke Atas */
        .syari-hero-stagger-1,
        .syari-hero-stagger-2,
        .syari-hero-stagger-3 {
            transform: translate3d(0, 22px, 0);
            transition: transform 0.92s cubic-bezier(0.22, 1, 0.36, 1);
            will-change: transform;
        }
        .syari-hero-stagger-2 { transition-delay: 0.1s; }
        .syari-hero-stagger-3 { transition-delay: 0.2s; }
        .syari-hero-terbuka .syari-hero-stagger-1,
        .syari-hero-terbuka .syari-hero-stagger-2,
        .syari-hero-terbuka .syari-hero-stagger-3 {
            transform: translate3d(0, 0, 0);
        }

        /* Pola Geometri Islami Halus untuk Permukaan Sanctuary Alabaster */
        .syari-pola-zellige {
            background-image: radial-gradient(rgba(197, 160, 89, 0.22) 1px, transparent 1px),
                radial-gradient(rgba(14, 58, 54, 0.08) 1px, transparent 1px);
            background-size: 24px 24px;
            background-position: 0 0, 12px 12px;
        }

        @media (prefers-reduced-motion: reduce) {
            .tirai-fade-halus.tirai-gulir-atas,
            .tirai-fade-halus.tirai-gulir-atas.tirai-terbuka,
            .syari-hero-stagger-1,
            .syari-hero-stagger-2,
            .syari-hero-stagger-3,
            .syari-video-teks {
                transition: none !important;
                transform: none !important;
            }
            .tirai-fade-halus.tirai-gulir-atas.tirai-terbuka {
                opacity: 0;
            }
        }
    </style>
</head>
<body
    x-data="temaUndangan()"
    :class="undanganTerbuka ? 'overflow-x-hidden' : 'overflow-hidden h-screen'"
    class="bg-[#0B2D2A] text-[#0E3A36] antialiased relative"
>
    @include('komponen-undangan.bar-pratinjau-demo')

    <div data-tata-letak-tema class="min-h-screen w-full lg:flex">
        {{-- PANGGUNG VISUAL DESKTOP KIRI (ALABASTER ANDALUSIAN COURTYARD) --}}
        @include('tema.islami-syari.partials._panggung-desktop')

        {{-- KOLOM UNDANGAN PORTRAIT MOBILE-FIRST (TERPUSAT DI TENGAH WEB) --}}
        <div
            data-kolom-undangan
            class="w-full lg:w-[460px] xl:w-[490px] shrink-0 min-h-screen relative overflow-x-clip shadow-[0_0_70px_rgba(8,34,31,0.45)] lg:border-x-2 border-[#C5A059]/45 bg-[#F7FBF8]"
        >
            {{-- Progres Baca Emas-Zamrud --}}
            <div data-progres-undangan aria-hidden="true" x-show="undanganTerbuka" x-cloak
                class="fixed top-0 inset-x-0 mx-auto w-full lg:w-[460px] xl:w-[490px] z-[60] h-[3px] bg-[#0A2B28]/30">
                <div class="h-full transition-all duration-150 bg-gradient-to-r from-[#16524C] via-[#C5A059] to-[#F3E5AB]"
                    :style="'width: ' + scrollPersen + '%'"></div>
            </div>

            {{-- Jendela Latar Alabaster Zellige Terpin --}}
            <div data-latar-undangan aria-hidden="true" class="pointer-events-none fixed inset-y-0 inset-x-0 mx-auto w-full lg:w-[460px] xl:w-[490px] z-0 overflow-hidden bg-[#F7FBF8]">
                <img src="{{ $urlFotoLatar }}" alt="" class="w-full h-full object-cover object-center opacity-[0.14]">
                <div class="absolute inset-0 bg-gradient-to-b from-[#F7FBF8]/82 via-[#F7FBF8]/62 to-[#EAF3ED]/88"></div>
            </div>

            {{-- INTRO PEMBUKA BESPOKE SEBELUM SAMPUL --}}
            @include('komponen-undangan.intro-pembuka')

            {{-- SAMPUL PEMBUKA ISLAMI SYAR'I --}}
            @include('tema.islami-syari.partials._sampul')

            {{-- KONTEN UTAMA ANDALUSIAN SANCTUARY --}}
            <main data-panggung-3d data-sinema-gsap="islami-syari" class="panggung-3d relative z-10 {{ $tampilBarDemo ? 'pt-14' : '' }}">
                @include('tema.islami-syari.partials._hero-dan-pembuka')
                @include('tema.islami-syari.partials._konten-utama')
                @include('tema.islami-syari.partials._penutup-dan-rsvp')
            </main>
        </div>

        {{-- PANGGUNG VISUAL DESKTOP KANAN (RUB EL HIZB SEAL KEEPSAKE) --}}
        @include('tema.islami-syari.partials._panggung-desktop-kanan')
    </div>

    @include('komponen-undangan.kontrol-sinema')
    @include('komponen-undangan.pemutar-musik')
    @include('komponen-undangan.modal-galeri')
    @include('komponen-undangan.skrip-tema')
</body>
</html>
