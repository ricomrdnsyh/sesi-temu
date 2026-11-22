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
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .syari-tombol {
            background: linear-gradient(135deg, #184D47 0%, #133D38 60%, #0F342F 100%);
            color: #F4FAF6;
            box-shadow: 0 10px 22px -10px rgba(24, 77, 71, 0.55);
        }
        .syari-tombol:hover { filter: brightness(1.08); }
    </style>
</head>
<body
    x-data="temaUndangan()"
    :class="undanganTerbuka ? 'overflow-x-hidden' : 'overflow-hidden h-screen'"
    class="bg-[#E8F3EC] text-[#184D47] antialiased relative"
>
    @include('komponen-undangan.bar-pratinjau-demo')

    <div data-tata-letak-tema class="min-h-screen w-full lg:flex">
        {{-- PANGGUNG VISUAL DESKTOP KIRI (SANCTUARY EMERALD SYAR'I) --}}
        @include('tema.islami-syari.partials._panggung-desktop')

        {{-- KOLOM UNDANGAN PORTRAIT MOBILE-FIRST (TERPUSAT DI TENGAH WEB) --}}
        <div data-kolom-undangan class="w-full lg:w-[460px] xl:w-[490px] shrink-0 min-h-screen relative overflow-x-clip shadow-[0_0_70px_rgba(0,0,0,0.45)] lg:border-x border-[#BFA15F]/40 bg-[#F4FAF6]">
            {{-- Jendela Latar Sunlit Emerald Terpin --}}
            <div data-latar-undangan aria-hidden="true" class="pointer-events-none fixed inset-y-0 inset-x-0 mx-auto w-full lg:w-[460px] xl:w-[490px] z-0 overflow-hidden bg-[#F4FAF6]">
                <img src="{{ $urlFotoLatar }}" alt="" class="w-full h-full object-cover object-center opacity-20">
                <div class="absolute inset-0 bg-gradient-to-b from-[#F4FAF6]/80 via-[#F4FAF6]/55 to-[#E8F3EC]/85"></div>
            </div>

            {{-- SAMPUL PEMBUKA FADE HALUS --}}
            @include('tema.islami-syari.partials._sampul')

            {{-- KONTEN UTAMA ISLAMI SYAR'I --}}
            <main data-panggung-3d class="panggung-3d relative z-10 {{ $tampilBarDemo ? 'pt-14' : '' }}">
                @include('tema.islami-syari.partials._hero-dan-pembuka')
                @include('tema.islami-syari.partials._konten-utama')
                @include('tema.islami-syari.partials._penutup-dan-rsvp')
            </main>
        </div>

        {{-- PANGGUNG VISUAL DESKTOP KANAN (SANCTUARY EMERALD KEEPSAKE) --}}
        @include('tema.islami-syari.partials._panggung-desktop-kanan')
    </div>

    @include('komponen-undangan.kontrol-sinema')
    @include('komponen-undangan.pemutar-musik')
    @include('komponen-undangan.modal-galeri')
    @include('komponen-undangan.skrip-tema')
</body>
</html>
