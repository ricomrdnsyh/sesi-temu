@php
    $asetSyari = [
        'latar' => asset('aset-tema/islami-syari/latar-utama.webp'),
        'arabesque' => asset('aset-tema/islami-syari/ornamen-arabesque.webp'),
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
            box-shadow: 0 12px 24px -10px rgba(14, 58, 54, 0.58);
        }
        .syari-tombol:hover {
            filter: brightness(1.09);
        }

        .syari-tombol-emas {
            background: linear-gradient(135deg, #EAD6A4 0%, #D4B56E 52%, #B99348 100%);
            color: #0B2D2A;
            box-shadow: 0 10px 22px -10px rgba(197, 160, 89, 0.65);
        }
        .syari-tombol-emas:hover {
            filter: brightness(1.06);
        }

        /* Transisi Sampul Scroll-Ke-Atas Khusus Islami Syar'i */
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
            box-shadow: 0 28px 54px -12px rgba(8, 34, 31, 0.55);
        }
        .tirai-fade-halus.tirai-gulir-atas.tirai-terbuka {
            opacity: 1;
            transform: translate3d(0, -105%, 0);
            visibility: hidden;
            transition:
                transform 0.95s cubic-bezier(0.65, 0, 0.35, 1),
                visibility 0s linear 0.96s;
        }

        /* Gerak Naik Sinkron Hero Saat Sampul Digulir Ke Atas */
        .syari-hero-stagger-1,
        .syari-hero-stagger-2,
        .syari-hero-stagger-3 {
            transform: translate3d(0, 24px, 0);
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

        /* Hero Andalusian Sanctuary Pas 1 Layar Penuh */
        .syari-hero-layar-penuh {
            min-height: 100svh;
            min-height: 100dvh;
        }
        .syari-hero-layar-penuh.dengan-bar-demo {
            min-height: calc(100svh - 3.5rem);
            min-height: calc(100dvh - 3.5rem);
        }
        html.desktop-triptych [data-kolom-undangan] .syari-hero-layar-penuh {
            min-height: var(--tinggi-tirai-dalam-inv, 100dvh) !important;
        }

        /* Pola Geometri Islami Halus untuk Permukaan Sanctuary */
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
            .syari-hero-stagger-3 {
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
    class="bg-[#EAF3ED] text-[#0E3A36] antialiased relative"
>
    @include('komponen-undangan.bar-pratinjau-demo')

    <div data-tata-letak-tema class="min-h-screen w-full lg:flex">
        {{-- PANGGUNG VISUAL DESKTOP KIRI (ALABASTER ANDALUSIAN COURTYARD) --}}
        @include('tema.islami-syari.partials._panggung-desktop')

        {{-- KOLOM UNDANGAN PORTRAIT MOBILE-FIRST (TERPUSAT DI TENGAH WEB) --}}
        <div
            data-kolom-undangan
            class="w-full lg:w-[460px] xl:w-[490px] shrink-0 min-h-screen relative overflow-x-clip shadow-[0_0_68px_rgba(14,58,54,0.24)] lg:border-x-2 border-[#C5A059]/45 bg-[#F7FBF8]"
        >
            {{-- Jendela Latar Alabaster Zellige Terpin --}}
            <div data-latar-undangan aria-hidden="true" class="pointer-events-none fixed inset-y-0 inset-x-0 mx-auto w-full lg:w-[460px] xl:w-[490px] z-0 overflow-hidden bg-[#F7FBF8]">
                <img src="{{ $urlFotoLatar }}" alt="" class="w-full h-full object-cover object-center opacity-[0.14]">
                <div class="absolute inset-0 bg-gradient-to-b from-[#F7FBF8]/82 via-[#F7FBF8]/62 to-[#EAF3ED]/88"></div>
            </div>

            {{-- SAMPUL PEMBUKA ISLAMI SYAR'I --}}
            @include('tema.islami-syari.partials._sampul')

            {{-- KONTEN UTAMA ANDALUSIAN SANCTUARY --}}
            <main data-panggung-3d class="panggung-3d relative z-10 {{ $tampilBarDemo ? 'pt-14' : '' }}">
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
