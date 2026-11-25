@php
    $asetNoir = [
        'latar' => asset('aset-tema/luxury-noir/latar-utama.webp'),
        'bingkai' => asset('aset-tema/luxury-noir/bingkai-artdeco.webp'),
        'emas' => asset('aset-tema/luxury-noir/ornamen-emas.webp'),
    ];

    $dataTema = \App\Support\DataTemaUndangan::siapkan(
        $undangan,
        $modeDemo ?? false,
        $modePratinjau ?? false,
        'eksklusif',
        $asetNoir['latar'],
    );
    extract($dataTema, EXTR_SKIP);
@endphp

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    @include('komponen-undangan.meta-opengraph')
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        @keyframes noirDecoMasuk {
            0% {
                opacity: 0;
                transform: translate3d(0, 18px, 0) scale(0.95);
            }

            100% {
                opacity: 1;
                transform: translate3d(0, 0, 0) scale(1);
            }
        }

        @keyframes noirChandelierTurun {
            0% {
                opacity: 0;
                transform: translate3d(0, -28px, 0);
            }

            100% {
                opacity: 0.95;
                transform: translate3d(0, 0, 0);
            }
        }

        @keyframes noirHeroLensaMasuk {
            0% {
                transform: scale(1.1);
                filter: brightness(0.75) blur(4px);
            }

            100% {
                transform: scale(1);
                filter: brightness(1) blur(0);
            }
        }

        @keyframes noirFadeNaik {
            0% {
                opacity: 0;
                transform: translate3d(0, 20px, 0);
            }

            100% {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        @keyframes noirPitaEmasNaik {
            0% {
                opacity: 0;
                transform: translate3d(0, 110%, 0);
            }

            22% {
                opacity: 0.95;
            }

            78% {
                opacity: 0.85;
            }

            100% {
                opacity: 0;
                transform: translate3d(0, -135%, 0);
            }
        }

        .noir-deco-masuk {
            animation: noirDecoMasuk 1.25s cubic-bezier(0.16, 1, 0.3, 1) 0.28s both;
            will-change: transform, opacity;
        }

        .noir-chandelier-turun {
            animation: noirChandelierTurun 1.3s cubic-bezier(0.16, 1, 0.3, 1) 0.36s both;
            will-change: transform, opacity;
        }

        .noir-hero-lensa-masuk {
            animation: noirHeroLensaMasuk 1.55s cubic-bezier(0.16, 1, 0.3, 1) 0.14s both;
            will-change: transform, filter;
        }

        .noir-hero-baris-1 {
            animation: noirFadeNaik 0.95s cubic-bezier(0.16, 1, 0.3, 1) 0.42s both;
        }

        .noir-hero-baris-2 {
            animation: noirFadeNaik 1.05s cubic-bezier(0.16, 1, 0.3, 1) 0.56s both;
        }

        .noir-hero-baris-3 {
            animation: noirFadeNaik 0.95s cubic-bezier(0.16, 1, 0.3, 1) 0.72s both;
        }

        .noir-hero-bawah {
            animation: noirFadeNaik 1s cubic-bezier(0.16, 1, 0.3, 1) 0.84s both;
        }

        .noir-pita-cahaya-aktif {
            animation: noirPitaEmasNaik 1.22s cubic-bezier(0.76, 0, 0.24, 1) 0.04s both;
            will-change: transform, opacity;
        }

        .noir-font-judul {
            font-family: 'Cinzel', Georgia, serif;
        }

        .noir-tombol-emas {
            background: linear-gradient(135deg, #C59B38 0%, #F3E5AB 48%, #C59B38 100%);
            color: #0B0B0F;
            box-shadow: 0 12px 26px -10px rgba(212, 175, 55, 0.55);
        }

        .noir-tombol-emas:hover {
            filter: brightness(1.08);
        }

        .noir-tombol-obsidian {
            background: linear-gradient(135deg, #211F29 0%, #14131A 55%, #0B0B0F 100%);
            color: #F3E5AB;
            border: 1px solid rgba(212, 175, 55, 0.58);
            box-shadow: 0 10px 24px -10px rgba(0, 0, 0, 0.78);
        }

        .noir-tombol-obsidian:hover {
            filter: brightness(1.12);
        }

        /* Pastikan kontainer <main> bebas transform/overflow agar position: sticky kartu bertumpuk mengunci mulus */
        main[data-sinema-gsap="luxury-noir"] {
            transform: none !important;
            perspective: none !important;
            transform-style: flat !important;
            overflow: visible !important;
        }

        .noir-kartu-tumpuk {
            border-top-left-radius: 1.85rem;
            border-top-right-radius: 1.85rem;
            border-top: 1px solid rgba(212, 175, 55, 0.48);
            box-shadow: 0 -24px 52px -12px rgba(0, 0, 0, 0.88);
            will-change: transform;
        }

        /* Transisi Tirai Beludru Malam Melengkung + Sapuan Cahaya Emas Sampanye 60fps */
        .tirai-fade-halus.tirai-gulir-atas {
            opacity: 1;
            clip-path: inset(0% 0% 0% 0% round 0 0 0% 0%);
            transform: translate3d(0, 0, 0) scale(1);
            filter: brightness(1);
            visibility: visible;
            transition:
                clip-path 1.16s cubic-bezier(0.76, 0, 0.24, 1),
                transform 1.22s cubic-bezier(0.22, 1, 0.36, 1),
                filter 0.72s ease,
                opacity 0.3s ease 0.92s,
                visibility 0s linear 0s;
            will-change: clip-path, transform, opacity;
            backface-visibility: hidden;
        }

        .tirai-fade-halus.tirai-gulir-atas.tirai-terbuka {
            opacity: 0;
            clip-path: inset(0% 0% 100% 0% round 0 0 46% 46%);
            transform: translate3d(0, -3.5%, 0) scale(1.04);
            filter: brightness(1.16);
            visibility: hidden;
            transition:
                clip-path 1.16s cubic-bezier(0.76, 0, 0.24, 1),
                transform 1.22s cubic-bezier(0.22, 1, 0.36, 1),
                filter 0.72s ease,
                opacity 0.3s ease 0.92s,
                visibility 0s linear 1.22s;
        }

        .noir-isi-sampul {
            transition:
                opacity 0.38s cubic-bezier(0.22, 1, 0.36, 1),
                transform 0.5s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .tirai-terbuka .noir-isi-sampul {
            opacity: 0;
            transform: translate3d(0, -18px, 0) scale(0.97);
        }

        @media (prefers-reduced-motion: reduce) {

            .noir-deco-masuk,
            .noir-chandelier-turun,
            .noir-hero-lensa-masuk,
            .noir-hero-baris-1,
            .noir-hero-baris-2,
            .noir-hero-baris-3,
            .noir-hero-bawah,
            .noir-pita-cahaya-aktif {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
                filter: none !important;
            }

            .noir-pita-cahaya-aktif {
                display: none !important;
            }

            .tirai-fade-halus.tirai-gulir-atas,
            .tirai-fade-halus.tirai-gulir-atas.tirai-terbuka {
                transition: none !important;
                clip-path: none !important;
                transform: none !important;
                filter: none !important;
            }

            .tirai-fade-halus.tirai-gulir-atas.tirai-terbuka {
                opacity: 0;
            }
        }
    </style>
</head>

<body x-data="temaUndangan()" :class="undanganTerbuka ? 'overflow-x-hidden' : 'overflow-hidden h-screen'"
    class="bg-[#09090D] text-[#F5EFE6] antialiased relative">
    @include('komponen-undangan.bar-pratinjau-demo')

    <div data-tata-letak-tema class="min-h-screen w-full lg:flex">
        {{-- PANGGUNG VISUAL DESKTOP KIRI (BLACK-TIE ART DECO GALA) --}}
        @include('tema.luxury-noir.partials._panggung-desktop')

        {{-- KOLOM UNDANGAN PORTRAIT MOBILE-FIRST (TERPUSAT DI TENGAH WEB) --}}
        <div
            data-kolom-undangan
            class="w-full lg:w-[460px] xl:w-[490px] shrink-0 min-h-screen relative overflow-x-clip shadow-[0_0_70px_rgba(0,0,0,0.65)] lg:border-x border-[#D4AF37]/40 bg-[#0B0B0F]">
            {{-- Progres Baca Emas Art Deco --}}
            <div data-progres-undangan aria-hidden="true" x-show="undanganTerbuka" x-cloak
                class="fixed top-0 inset-x-0 mx-auto w-full lg:w-[460px] xl:w-[490px] z-[60] h-[3px] bg-black/50">
                <div class="h-full transition-all duration-150 bg-gradient-to-r from-[#B88928] via-[#F3E5AB] to-[#D4AF37]"
                    :style="'width: ' + scrollPersen + '%'"></div>
            </div>

            {{-- Jendela Latar Marmer Hitam Terpin --}}
            <div data-latar-undangan aria-hidden="true"
                class="pointer-events-none fixed inset-y-0 inset-x-0 mx-auto w-full lg:w-[460px] xl:w-[490px] z-0 overflow-hidden bg-[#09090D]">
                <img src="{{ $urlFotoLatar }}" alt=""
                    class="w-full h-full object-cover object-center opacity-30">
                <div class="absolute inset-0 bg-gradient-to-b from-[#09090D]/80 via-[#0B0B0F]/65 to-[#09090D]/90"></div>
            </div>

            {{-- INTRO PEMBUKA BESPOKE SEBELUM SAMPUL --}}
            @include('komponen-undangan.intro-pembuka')

            {{-- SAMPUL PEMBUKA FADE HALUS --}}
            @include('tema.luxury-noir.partials._sampul')

            {{-- KONTEN UTAMA LUXURY NOIR --}}
            <main data-panggung-3d data-sinema-gsap="luxury-noir" class="panggung-3d relative z-10 {{ $tampilBarDemo ? 'pt-14' : '' }}">
                @include('tema.luxury-noir.partials._hero-dan-pembuka')
                @include('tema.luxury-noir.partials._konten-utama')
                @include('tema.luxury-noir.partials._penutup-dan-rsvp')
            </main>
        </div>

        {{-- PANGGUNG VISUAL DESKTOP KANAN (BLACK-TIE ART DECO KEEPSAKE) --}}
        @include('tema.luxury-noir.partials._panggung-desktop-kanan')
    </div>

    @include('komponen-undangan.navigasi-elegan', ['varian' => 'noir', 'tanpaFoto' => $tanpaFoto])
    @include('komponen-undangan.kontrol-sinema')
    @include('komponen-undangan.pemutar-musik')
    @include('komponen-undangan.modal-galeri')
    @include('komponen-undangan.skrip-tema')
</body>

</html>
