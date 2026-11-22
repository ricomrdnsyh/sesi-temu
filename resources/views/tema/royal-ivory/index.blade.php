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
        .royal-arch-masuk {
            animation: royalArchMasuk 1.15s cubic-bezier(0.16, 1, 0.3, 1) 0.1s both;
            will-change: transform, opacity;
        }
        .royal-tombol {
            background: linear-gradient(135deg, #9E7B4F 0%, #7B603F 60%, #58432B 100%);
            color: #FAF6EE;
            box-shadow: 0 10px 22px -10px rgba(88, 67, 43, 0.6);
        }
        .royal-tombol:hover { filter: brightness(1.07); }
        @media (prefers-reduced-motion: reduce) {
            .royal-arch-masuk { animation: none !important; opacity: 1 !important; transform: none !important; }
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

            {{-- SAMPUL PEMBUKA FADE HALUS --}}
            @include('tema.royal-ivory.partials._sampul')

            {{-- KONTEN UTAMA ROYAL IVORY CATHEDRAL --}}
            <main data-panggung-3d class="panggung-3d relative z-10 {{ $tampilBarDemo ? 'pt-14' : '' }}">
                @include('tema.royal-ivory.partials._hero-dan-pembuka')
                @include('tema.royal-ivory.partials._konten-utama')
                @include('tema.royal-ivory.partials._penutup-dan-rsvp')
            </main>
        </div>

        {{-- PANGGUNG VISUAL DESKTOP KANAN (ROYAL CATHEDRAL KEEPSAKE) --}}
        @include('tema.royal-ivory.partials._panggung-desktop-kanan')
    </div>

    @include('komponen-undangan.kontrol-sinema')
    @include('komponen-undangan.pemutar-musik')
    @include('komponen-undangan.modal-galeri')
    @include('komponen-undangan.skrip-tema')
</body>
</html>
