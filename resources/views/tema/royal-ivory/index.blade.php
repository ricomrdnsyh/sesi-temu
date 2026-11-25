@php
    $asetRoyal = [
        'latar' => asset('aset-tema/royal-ivory/latar-utama.webp'),
        'katedral' => asset('aset-tema/royal-ivory/ornamen-katedral.webp'),
    ];

    $dataTema = \App\Support\DataTemaUndangan::siapkan(
        $undangan,
        $modeDemo ?? false,
        $modePratinjau ?? false,
        'premium',
        $asetRoyal['latar']
    );
    extract($dataTema, EXTR_SKIP);
    $angkaRomawi = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X'];
@endphp

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    @include('komponen-undangan.meta-opengraph')
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,700;1,500&display=swap" rel="stylesheet">
    <style>
        @keyframes royalArchMasuk {
            0% { opacity: 0; transform: translate3d(0, 20px, 0) scale(0.96); }
            100% { opacity: 1; transform: translate3d(0, 0, 0) scale(1); }
        }
        @keyframes royalFadeTurun {
            0% { opacity: 0; transform: translate3d(0, -14px, 0); }
            100% { opacity: 1; transform: translate3d(0, 0, 0); }
        }
        @keyframes royalFadeNaik {
            0% { opacity: 0; transform: translate3d(0, 18px, 0); }
            100% { opacity: 1; transform: translate3d(0, 0, 0); }
        }
        @keyframes royalKameoMekar {
            0% { opacity: 0; transform: translate3d(0, 22px, 0) scale(0.92); filter: blur(4px); }
            100% { opacity: 1; transform: translate3d(0, 0, 0) scale(1); filter: blur(0); }
        }
        @keyframes royalSegelCap {
            0% { opacity: 0; transform: scale(1.25) rotate(-10deg); }
            100% { opacity: 1; transform: scale(1) rotate(0deg); }
        }
        @keyframes royalHeroLensaMasuk {
            0% { transform: scale(1.09); filter: brightness(1.08) blur(3px); }
            100% { transform: scale(1.01); filter: brightness(1) blur(0); }
        }
        @keyframes royalSelendangNaik {
            0% { opacity: 0; transform: translate3d(0, 110%, 0); }
            22% { opacity: 0.96; }
            78% { opacity: 0.88; }
            100% { opacity: 0; transform: translate3d(0, -135%, 0); }
        }
        .royal-arch-masuk {
            animation: royalArchMasuk 1.25s cubic-bezier(0.16, 1, 0.3, 1) 0.28s both;
            will-change: transform, opacity;
        }
        .royal-hero-lensa-masuk {
            animation: royalHeroLensaMasuk 1.55s cubic-bezier(0.16, 1, 0.3, 1) 0.14s both;
            will-change: transform, filter;
        }
        .royal-selendang-aktif {
            animation: royalSelendangNaik 1.24s cubic-bezier(0.76, 0, 0.24, 1) 0.04s both;
            will-change: transform, opacity;
        }
        .royal-hero-baris-1 {
            animation: royalFadeTurun 0.95s cubic-bezier(0.16, 1, 0.3, 1) 0.36s both;
        }
        .royal-hero-baris-2 {
            animation: royalFadeNaik 1.05s cubic-bezier(0.16, 1, 0.3, 1) 0.5s both;
        }
        .royal-hero-kameo {
            animation: royalKameoMekar 1.05s cubic-bezier(0.16, 1, 0.3, 1) 0.64s both;
            will-change: transform, opacity, filter;
        }
        .royal-hero-segel {
            animation: royalSegelCap 0.82s cubic-bezier(0.22, 1, 0.36, 1) 0.8s both;
        }
        .royal-hero-bawah {
            animation: royalFadeNaik 1s cubic-bezier(0.16, 1, 0.3, 1) 0.76s both;
        }
        .royal-tombol {
            background: linear-gradient(135deg, #9E7B4F 0%, #7B603F 60%, #58432B 100%);
            color: #FAF6EE;
            box-shadow: 0 10px 22px -10px rgba(88, 67, 43, 0.6);
        }
        .royal-tombol:hover { filter: brightness(1.07); }
        .royal-tombol-gading {
            background: linear-gradient(135deg, #FAF6EE 0%, #F1E3CB 55%, #E5C99B 100%);
            color: #3B2E25;
            border: 1px solid rgba(158, 123, 79, 0.55);
            box-shadow: 0 10px 22px -10px rgba(59, 46, 37, 0.35);
        }
        .royal-tombol-gading:hover { filter: brightness(1.04); }
        main[data-sinema-gsap="royal-ivory"] {
            transform: none !important;
            perspective: none !important;
            transform-style: flat !important;
            overflow: visible !important;
        }
        .royal-kartu-tumpuk {
            border-top-left-radius: 1.85rem;
            border-top-right-radius: 1.85rem;
            border-top: 1px solid rgba(158, 123, 79, 0.45);
            box-shadow: 0 -20px 44px -12px rgba(59, 46, 37, 0.24);
            will-change: transform;
        }
        /* Transisi Selendang Sutra Gading Melengkung + Cahaya Mutiara Sampanye 60fps */
        .tirai-fade-halus.tirai-gulir-atas {
            opacity: 1;
            clip-path: inset(0% 0% 0% 0% round 0 0 0% 0%);
            transform: translate3d(0, 0, 0) scale(1);
            filter: brightness(1);
            visibility: visible;
            transition:
                clip-path 1.18s cubic-bezier(0.76, 0, 0.24, 1),
                transform 1.24s cubic-bezier(0.22, 1, 0.36, 1),
                filter 0.72s ease,
                opacity 0.3s ease 0.94s,
                visibility 0s linear 0s;
            will-change: clip-path, transform, opacity;
            backface-visibility: hidden;
        }
        .tirai-fade-halus.tirai-gulir-atas.tirai-terbuka {
            opacity: 0;
            clip-path: inset(0% 0% 100% 0% round 0 0 48% 48%);
            transform: translate3d(0, -3.5%, 0) scale(1.04);
            filter: brightness(1.16);
            visibility: hidden;
            transition:
                clip-path 1.18s cubic-bezier(0.76, 0, 0.24, 1),
                transform 1.24s cubic-bezier(0.22, 1, 0.36, 1),
                filter 0.72s ease,
                opacity 0.3s ease 0.94s,
                visibility 0s linear 1.24s;
        }
        .royal-isi-sampul {
            transition:
                opacity 0.38s cubic-bezier(0.22, 1, 0.36, 1),
                transform 0.5s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .tirai-terbuka .royal-isi-sampul {
            opacity: 0;
            transform: translate3d(0, -18px, 0) scale(0.97);
        }
        @media (prefers-reduced-motion: reduce) {
            .royal-arch-masuk,
            .royal-hero-lensa-masuk,
            .royal-selendang-aktif,
            .royal-hero-baris-1,
            .royal-hero-baris-2,
            .royal-hero-kameo,
            .royal-hero-segel,
            .royal-hero-bawah { animation: none !important; opacity: 1 !important; transform: none !important; filter: none !important; }
            .royal-selendang-aktif { display: none !important; }
            .tirai-fade-halus.tirai-gulir-atas,
            .tirai-fade-halus.tirai-gulir-atas.tirai-terbuka {
                transition: none !important;
                clip-path: none !important;
                transform: none !important;
                filter: none !important;
            }
            .tirai-fade-halus.tirai-gulir-atas.tirai-terbuka { opacity: 0; }
        }
    </style>
</head>
<body
    x-data="temaUndangan()"
    :class="undanganTerbuka ? 'overflow-x-hidden' : 'overflow-hidden h-screen'"
    class="bg-[#EFE7DA] text-[#3B2E25] antialiased relative"
>
    @include('komponen-undangan.bar-pratinjau-demo')

    <div data-tata-letak-tema class="min-h-screen w-full lg:flex">
        {{-- PANGGUNG VISUAL DESKTOP KIRI (ROYAL CATHEDRAL LETTERPRESS) --}}
        @include('tema.royal-ivory.partials._panggung-desktop')

        {{-- KOLOM UNDANGAN PORTRAIT MOBILE-FIRST (TERPUSAT DI TENGAH WEB) --}}
        <div data-kolom-undangan class="w-full lg:w-[460px] xl:w-[490px] shrink-0 min-h-screen relative overflow-x-clip shadow-[0_0_70px_rgba(0,0,0,0.45)] lg:border-x border-[#9E7B4F]/45 bg-[#FBF8F3]">
            {{-- Progres Baca Perunggu --}}
            <div data-progres-undangan aria-hidden="true" x-show="undanganTerbuka" x-cloak class="fixed top-0 inset-x-0 mx-auto w-full lg:w-[460px] xl:w-[490px] z-[60] h-[3px] bg-black/15">
                <div class="h-full transition-all duration-150 bg-gradient-to-r from-[#9E7B4F] via-[#E5C99B] to-[#9E7B4F]" :style="'width: ' + scrollPersen + '%'"></div>
            </div>

            {{-- Jendela Kertas Surat Terpin --}}
            <div data-latar-undangan aria-hidden="true" class="pointer-events-none fixed inset-y-0 inset-x-0 mx-auto w-full lg:w-[460px] xl:w-[490px] z-0 overflow-hidden bg-[#FBF8F3]">
                <img src="{{ $urlFotoLatar }}" alt="" class="w-full h-full object-cover object-center opacity-22">
                <div class="absolute inset-0 bg-gradient-to-b from-[#FBF8F3]/75 via-[#FBF8F3]/50 to-[#EFE7DA]/80"></div>
            </div>

            {{-- INTRO PEMBUKA BESPOKE SEBELUM SAMPUL --}}
            @include('komponen-undangan.intro-pembuka')

            {{-- SAMPUL PEMBUKA FADE HALUS --}}
            @include('tema.royal-ivory.partials._sampul')

            {{-- KONTEN UTAMA ROYAL IVORY CATHEDRAL --}}
            <main data-panggung-3d data-sinema-gsap="royal-ivory" class="panggung-3d relative z-10 {{ $tampilBarDemo ? 'pt-14' : '' }}">
                @include('tema.royal-ivory.partials._hero-dan-pembuka')
                @include('tema.royal-ivory.partials._konten-utama')
                @include('tema.royal-ivory.partials._penutup-dan-rsvp')
            </main>
        </div>

        {{-- PANGGUNG VISUAL DESKTOP KANAN (ROYAL CATHEDRAL KEEPSAKE) --}}
        @include('tema.royal-ivory.partials._panggung-desktop-kanan')
    </div>

    @include('komponen-undangan.navigasi-elegan', ['varian' => 'ivory', 'tanpaFoto' => $tanpaFoto])
    @include('komponen-undangan.kontrol-sinema')
    @include('komponen-undangan.pemutar-musik')
    @include('komponen-undangan.modal-galeri')
    @include('komponen-undangan.skrip-tema')
</body>
</html>
