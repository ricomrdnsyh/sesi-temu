@php
    $asetRustic = [
        'latar' => asset('aset-tema/rustic-floral/latar-utama.webp'),
        'sudut' => asset('aset-tema/rustic-floral/ornamen-sudut.webp'),
    ];

    $dataTema = \App\Support\DataTemaUndangan::siapkan(
        $undangan,
        $modeDemo ?? false,
        $modePratinjau ?? false,
        'basic',
        $asetRustic['latar'],
    );
    extract($dataTema, EXTR_SKIP);
@endphp

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    @include('komponen-undangan.meta-opengraph')
    <style>
        .rustic-tombol-sage {
            background: linear-gradient(135deg, #4B6358 0%, #3A4D44 60%, #2F4037 100%);
            color: #FDFBF7;
            box-shadow: 0 10px 20px -10px rgba(75, 99, 88, 0.55);
        }

        .rustic-tombol-sage:hover {
            filter: brightness(1.07);
        }
    </style>
</head>

<body x-data="temaUndangan()" :class="undanganTerbuka ? 'overflow-x-hidden' : 'overflow-hidden h-screen'"
    class="bg-[#EFE6DA] text-[#1F2937] antialiased relative">
    @include('komponen-undangan.bar-pratinjau-demo')

    <div data-tata-letak-tema class="min-h-screen w-full lg:flex">
        {{-- PANGGUNG VISUAL DESKTOP KIRI (WARM LINEN & BOTANICAL SCRAPBOOK) --}}
        @include('tema.rustic-floral.partials._panggung-desktop')

        {{-- KOLOM UNDANGAN PORTRAIT MOBILE-FIRST (TERPUSAT DI TENGAH WEB) --}}
        <div
            data-kolom-undangan
            class="w-full lg:w-[460px] xl:w-[490px] shrink-0 min-h-screen relative overflow-x-clip shadow-[0_0_70px_rgba(0,0,0,0.45)] lg:border-x border-[#BFA15F]/45 bg-[#FDFBF7]">
            {{-- Jendela Latar Linen Terpin --}}
            <div data-latar-undangan aria-hidden="true"
                class="pointer-events-none fixed inset-y-0 inset-x-0 mx-auto w-full lg:w-[460px] xl:w-[490px] z-0 overflow-hidden bg-[#FDFBF7]">
                <img src="{{ $urlFotoLatar }}" alt="" class="w-full h-full object-cover object-center opacity-22">
                <div class="absolute inset-0 bg-gradient-to-b from-[#FDFBF7]/78 via-[#FDFBF7]/50 to-[#F4ECE1]/82"></div>
            </div>

            {{-- SAMPUL PEMBUKA FADE HALUS --}}
            @include('tema.rustic-floral.partials._sampul')

            {{-- KONTEN UTAMA RUSTIC FLORAL SCRAPBOOK --}}
            <main data-panggung-3d class="panggung-3d relative z-10 {{ $tampilBarDemo ? 'pt-14' : '' }}">
                @include('tema.rustic-floral.partials._hero-dan-pembuka')
                @include('tema.rustic-floral.partials._konten-utama')
                @include('tema.rustic-floral.partials._penutup-dan-rsvp')
            </main>
        </div>

        {{-- PANGGUNG VISUAL DESKTOP KANAN (WARM LINEN & BOTANICAL KEEPSAKE) --}}
        @include('tema.rustic-floral.partials._panggung-desktop-kanan')
    </div>

    @include('komponen-undangan.kontrol-sinema')
    @include('komponen-undangan.pemutar-musik')
    @include('komponen-undangan.modal-galeri')
    @include('komponen-undangan.skrip-tema')
</body>

</html>
