@props([
    'tema',
])

@php
    $poster = $tema->infoPoster();
    $demo = \App\Support\KatalogKontenDemo::untukTema($tema);

    $priaPanggilan = $demo['pria']['panggilan'] ?? 'Dimas';
    $wanitaPanggilan = $demo['wanita']['panggilan'] ?? 'Rani';
    $wanitaLengkap = $demo['wanita']['lengkap'] ?? $wanitaPanggilan;
    $wanitaAyah = $demo['wanita']['ayah'] ?? 'Keluarga Mempelai';
    $wanitaIbu = $demo['wanita']['ibu'] ?? null;
    $instagramWanita = $demo['sosial_media']['instagram_wanita'] ?? null;
    $namaAcaraUtama = $demo['acara'][0]['nama_acara'] ?? 'Akad Nikah';
    $tempatAcara = $demo['acara'][0]['nama_tempat'] ?? 'Venue Pernikahan';
    $hariLagi = sprintf('%02d', (int) ($demo['hari_lagi'] ?? 21));

    $adalahAdatJawa = $tema->slug === 'adat-jawa';
    $adalahSundaHeritage = $tema->slug === 'sunda-heritage';
    $adalahIslamiSyari = $tema->slug === 'islami-syari';
    $adalahIslamicHeavenly = $tema->slug === 'islamic-heavenly';
    $adalahRusticFloral = $tema->slug === 'rustic-floral';
    $adalahVelvetGarden = $tema->slug === 'velvet-garden';
    $adalahEditorialMonokrom = $tema->slug === 'editorial-monokrom';
    $adalahLuxuryNoir = $tema->slug === 'luxury-noir';
    $adalahRoyalIvory = $tema->slug === 'royal-ivory';
    $adalahAdatShowcase = $adalahAdatJawa || $adalahSundaHeritage || $adalahIslamiSyari || $adalahIslamicHeavenly || $adalahRusticFloral || $adalahVelvetGarden || $adalahEditorialMonokrom || $adalahLuxuryNoir || $adalahRoyalIvory;

    $relatifLatarTema = "aset-tema/{$tema->slug}/latar-utama.webp";
    $gambarLatarTemaUrl = is_file(public_path($relatifLatarTema))
        ? asset($relatifLatarTema)
        : $tema->urlGambarPratinjau();

    $fotoSampulRelatif = $demo['foto_sampul'] ?? 'aset-demo/sampul-rustic.webp';
    $fotoCoupleUrl = \App\Support\MediaPublik::url($fotoSampulRelatif)
        ?? ($gambarLatarTemaUrl ?: asset('aset-demo/mempelai-wanita.webp'));
    $fotoPembukaUrl = \App\Support\MediaPublik::url($demo['foto_pembuka'] ?? $fotoSampulRelatif) ?? $fotoCoupleUrl;
    $fotoWanitaUrl = \App\Support\MediaPublik::url($demo['foto_wanita'] ?? $fotoSampulRelatif) ?? $fotoCoupleUrl;

    $asetPosterJawa = $adalahAdatJawa ? [
        'gunungan' => asset('aset-tema/adat-jawa/ornamen-gunungan.webp'),
        'heroPoster' => asset('aset-tema/adat-jawa/hero-poster.webp'),
        'hutan' => asset('aset-tema/adat-jawa/latar-hutan-jawa.webp'),
        'sayapWayang' => asset('aset-tema/adat-jawa/sayap-wayang.webp'),
        'bungaLili' => asset('aset-tema/adat-jawa/bunga-lili.webp'),
    ] : [];

    $asetPosterSunda = $adalahSundaHeritage ? [
        'siger' => asset('aset-tema/sunda-heritage/ornamen-siger.webp'),
        'heroPoster' => asset('aset-tema/sunda-heritage/hero-poster.webp'),
        'bingkai' => asset('aset-tema/sunda-heritage/bingkai-priangan.webp'),
        'bungaDepan' => asset('aset-tema/sunda-heritage/bunga-depan-sunda.webp'),
    ] : [];

    $asetPosterSyari = $adalahIslamiSyari ? [
        'arabesque' => asset('aset-tema/islami-syari/ornamen-arabesque.webp'),
        'heroPoster' => asset('aset-tema/islami-syari/hero-poster.webp'),
    ] : [];

    $asetPosterHeavenly = $adalahIslamicHeavenly ? [
        'sabit' => asset('aset-tema/islamic-heavenly/ornamen-sabit.webp'),
        'heroPoster' => asset('aset-tema/islamic-heavenly/hero-poster.webp'),
    ] : [];

    $asetPosterRustic = $adalahRusticFloral ? [
        'sudut' => asset('aset-tema/rustic-floral/ornamen-sudut.webp?v=2'),
        'garland' => asset('aset-tema/rustic-floral/garland-bunga-rustic.webp?v=1'),
        'bingkaiMempelai' => asset('aset-tema/rustic-floral/bingkai-bunga-mempelai.webp?v=2'),
        'heroPoster' => asset('aset-tema/rustic-floral/hero-poster.webp'),
    ] : [];

    $asetPosterVelvet = $adalahVelvetGarden ? [
        'botani' => asset('aset-tema/velvet-garden/ornamen-botani.webp'),
        'garland' => asset('aset-tema/velvet-garden/garland-velvet.webp?v=1'),
        'bingkaiMempelai' => asset('aset-tema/velvet-garden/bingkai-konservatori-mempelai.webp?v=1'),
        'heroPoster' => asset('aset-tema/velvet-garden/hero-poster.webp'),
    ] : [];

    $asetPosterEditorial = $adalahEditorialMonokrom ? [
        'latar' => asset('aset-tema/editorial-monokrom/latar-utama.webp'),
        'bingkai' => asset('aset-tema/editorial-monokrom/ornamen-bingkai.webp'),
    ] : [];

    $asetPosterNoir = $adalahLuxuryNoir ? [
        'latar' => asset('aset-tema/luxury-noir/latar-utama.webp'),
        'bingkai' => asset('aset-tema/luxury-noir/bingkai-artdeco.webp'),
        'emas' => asset('aset-tema/luxury-noir/ornamen-emas.webp'),
    ] : [];

    $asetPosterRoyal = $adalahRoyalIvory ? [
        'latar' => asset('aset-tema/royal-ivory/latar-utama.webp'),
        'katedral' => asset('aset-tema/royal-ivory/ornamen-katedral.webp'),
    ] : [];

    $adalahEditorial = !empty($poster['editorial']);
    $adalahIslami = !empty($poster['islami']);
    $radiusArchKiri = $adalahEditorial ? '0.4cqw' : '999px 999px 1.2cqw 1.2cqw';
    $radiusBingkaiKanan = $adalahEditorial ? '0.4cqw' : '999px';
    $radiusKotakCountdown = $adalahEditorial ? '0.2cqw' : '0.65cqw';
    $radiusTombolKiri = $adalahEditorial ? '0.25cqw' : '9999px';

    $judulAtas = mb_strtoupper($tema->nama_tema);
    $ukuranJudul = mb_strlen($tema->nama_tema) > 19 ? '4.85cqw' : '6.0cqw';
@endphp

<div
    class="relative w-full aspect-square overflow-hidden select-none"
    style="container-type: inline-size; background: {{ $poster['latar_css'] }};"
>
    {{-- Pendar Studio Halus di Belakang Mockup Ponsel (Bersih Tanpa Pola Ramai) --}}
    @if ($adalahAdatShowcase)
        <div
            aria-hidden="true"
            class="pointer-events-none absolute inset-0"
            style="background: radial-gradient(circle at 50% 48%, {{ $adalahEditorialMonokrom ? 'rgba(255,255,255,0.14)' : 'rgba(243,229,171,0.16)' }} 0%, {{ $adalahEditorialMonokrom ? 'rgba(255,255,255,0.03)' : 'rgba(243,229,171,0.03)' }} 44%, transparent 72%);"
        ></div>
    @endif

    {{-- Lantai Bawah Ivory Bersih --}}
    <div
        class="absolute inset-x-0 bottom-0 border-t border-black/5"
        style="height: {{ $adalahAdatShowcase ? '22.5%' : '27%' }}; background-color: {{ $poster['lantai_hex'] }};"
    ></div>

    {{-- Bayangan Lembut di Bawah Ketiga Ponsel --}}
    <div
        class="pointer-events-none absolute inset-x-[9cqw]"
        style="bottom: {{ $adalahAdatShowcase ? '5.4cqw' : '9.2cqw' }}; height: 4cqw; background: radial-gradient(ellipse at center, rgba(0, 0, 0, 0.28) 0%, rgba(0, 0, 0, 0) 72%);"
    ></div>

    {{-- Pita Sudut Kiri Atas untuk Diskon --}}
    @if ($tema->adaDiskon())
        <div class="pointer-events-none absolute top-0 left-0 z-30 h-[30cqw] w-[30cqw] overflow-hidden">
            <div
                class="absolute bg-rose-600 text-white text-center font-bold shadow-md"
                style="top: 5.5cqw; left: -9.5cqw; width: 35cqw; transform: rotate(-45deg); padding: 1.05cqw 0; font-size: 2.75cqw; letter-spacing: 0.02em;"
            >
                {{ $tema->labelBadgeDiskon() }}
            </div>
        </div>
    @endif

    {{-- Header Merek & Judul Tema --}}
    <div class="relative z-10 text-center" style="padding: {{ $adalahAdatShowcase ? '3.3cqw 8cqw 0' : '4.4cqw 7cqw 0' }};">
        <p
            class="font-script leading-none drop-shadow-xs"
            style="font-size: {{ $adalahAdatShowcase ? '4.3cqw' : '5.1cqw' }}; color: {{ $adalahAdatShowcase ? '#F5E4BE' : 'rgba(255,255,255,0.95)' }};"
        >
            SesiTemu.
        </p>
        <p
            class="font-serif-poster font-semibold uppercase text-white truncate drop-shadow-xs"
            style="margin-top: 0.42cqw; font-size: {{ $adalahAdatShowcase ? '4.9cqw' : $ukuranJudul }}; line-height: 1.12; letter-spacing: 0.09em;"
        >
            {{ $judulAtas }}
        </p>
        @if ($adalahAdatShowcase)
            <div class="mx-auto flex items-center justify-center gap-[1.15cqw]" style="margin-top: 0.95cqw;" aria-hidden="true">
                <span style="height: 0.15cqw; width: 8.5cqw; background: linear-gradient(90deg, transparent, {{ $adalahEditorialMonokrom ? 'rgba(255,255,255,0.72)' : 'rgba(231,200,125,0.72)' }});"></span>
                <span style="width: 0.65cqw; height: 0.65cqw; {{ $adalahEditorialMonokrom ? '' : 'transform: rotate(45deg);' }} background: {{ $adalahEditorialMonokrom ? '#FFFFFF' : '#E7C87D' }};"></span>
                <span style="height: 0.15cqw; width: 8.5cqw; background: linear-gradient(270deg, transparent, {{ $adalahEditorialMonokrom ? 'rgba(255,255,255,0.72)' : 'rgba(231,200,125,0.72)' }});"></span>
            </div>
        @endif
    </div>

    @if ($adalahAdatShowcase)
        {{-- PANGGUNG LAYERED HERO STUDIO (PROPORSI PONSEL RAMPING & TINGGI ~9:19.5) --}}
        <div class="absolute inset-x-0 bottom-0 z-10" style="height: 82cqw;">
            {{-- PONSEL KIRI: Save The Date + Countdown Emas + Kartu Akad Bersih --}}
            <div
                class="absolute z-10 bg-[#151210] shadow-[0_1.6cqw_3.2cqw_rgba(0,0,0,0.36)] ring-1 {{ $adalahEditorialMonokrom ? 'ring-white/25' : 'ring-[#F3E5AB]/20' }}"
                style="left: 6.2cqw; bottom: 9.8cqw; width: 29.2cqw; height: 63.2cqw; border-radius: 3.7cqw; padding: 0.9cqw;"
            >
                <div
                    class="pointer-events-none absolute left-1/2 -translate-x-1/2 z-20 rounded-full bg-[#151210]"
                    style="top: 1.6cqw; width: 5cqw; height: 0.95cqw;"
                ></div>

                <div
                    class="relative w-full h-full overflow-hidden flex flex-col {{ ($adalahRusticFloral || $adalahVelvetGarden || $adalahEditorialMonokrom || $adalahLuxuryNoir || $adalahRoyalIvory) ? '' : 'justify-between' }}"
                    style="border-radius: 2.85cqw; background: {{ $adalahRusticFloral ? '#FAF5EC' : ($adalahVelvetGarden ? '#0F201D' : ($adalahEditorialMonokrom ? '#FAF9F6' : ($adalahLuxuryNoir ? '#0B0B0F' : ($adalahRoyalIvory ? '#FBF8F3' : $poster['layar_kiri_bg'])))) }}; color: {{ $poster['layar_kiri_teks'] }};"
                >
                    @if ($adalahLuxuryNoir)
                        {{-- PONSEL KIRI LUXURY NOIR: Beveled Gold-Plate Chronograph + Grand Ballroom Programme --}}
                        <div
                            class="relative z-10 text-center"
                            style="background: linear-gradient(180deg, #16151E 0%, #0E0D14 100%); color: #F5EFE6; padding: 3.1cqw 2.05cqw 1.95cqw 1.25cqw; border-bottom: 0.14cqw solid rgba(212,175,55,0.45);"
                        >
                            <img
                                src="{{ $asetPosterNoir['emas'] }}"
                                alt=""
                                aria-hidden="true"
                                loading="lazy"
                                class="mx-auto"
                                style="width: 2.6cqw;"
                            >
                            <p class="uppercase font-bold leading-none" style="margin-top: 0.35cqw; font-size: 0.56cqw; letter-spacing: 0.22em; color: #D4AF37;">
                                Menuju Malam Bahagia
                            </p>
                            <p class="font-serif-poster uppercase font-bold leading-tight" style="margin-top: 0.25cqw; font-size: 1.95cqw; letter-spacing: 0.06em; color: #F3E5AB;">
                                Save The Date
                            </p>

                            <div class="grid grid-cols-4 gap-[0.48cqw]" style="margin-top: 1.05cqw;">
                                @foreach ([[$hariLagi, 'Hari'], ['08', 'Jam'], ['25', 'Mnt'], ['12', 'Dtk']] as [$angka, $satuan])
                                    <div
                                        style="border-radius: 0.55cqw; background-color: #17161E; border: 0.13cqw solid rgba(212,175,55,0.65); padding: 0.68cqw 0.1cqw 0.55cqw;"
                                    >
                                        <div class="font-serif-poster font-bold leading-none" style="font-size: 1.55cqw; color: #F3E5AB;">{{ $angka }}</div>
                                        <div class="uppercase font-bold leading-none" style="margin-top: 0.28cqw; font-size: 0.48cqw; letter-spacing: 0.14em; color: #D4AF37;">{{ $satuan }}</div>
                                    </div>
                                @endforeach
                            </div>

                            <div
                                class="inline-flex items-center justify-center font-bold uppercase"
                                style="margin-top: 1.15cqw; padding: 0.48cqw 1.35cqw; font-size: 0.62cqw; letter-spacing: 0.12em; border-radius: 9999px; background: linear-gradient(135deg, #C59B38 0%, #F3E5AB 50%, #C59B38 100%); color: #0B0B0F;"
                            >
                                <span>Simpan ke Kalender</span>
                            </div>
                        </div>

                        <div
                            class="relative z-10 flex-1 flex flex-col text-center overflow-hidden"
                            style="background-color: #0B0B0F; color: #F5EFE6; padding: 1.45cqw 2.05cqw 1.5cqw 1.25cqw;"
                        >
                            <p class="uppercase font-bold leading-none" style="font-size: 0.56cqw; letter-spacing: 0.22em; color: #D4AF37;">
                                Waktu &amp; Tempat
                            </p>
                            <p class="font-serif-poster uppercase font-bold leading-tight text-white" style="margin-top: 0.24cqw; font-size: 1.55cqw; letter-spacing: 0.05em;">
                                Rangkaian Acara
                            </p>

                            <div
                                class="relative mt-auto w-full flex flex-col justify-between overflow-hidden"
                                style="margin-top: 0.9cqw; flex: 1; border-radius: 0.95cqw; background-color: #15141B; border: 0.16cqw solid rgba(212,175,55,0.62);"
                            >
                                <div style="background: linear-gradient(180deg, #1E1C26 0%, #121118 100%); border-bottom: 0.12cqw solid rgba(212,175,55,0.45); padding: 0.75cqw 0.7cqw;">
                                    <p class="uppercase font-bold leading-none" style="font-size: 0.52cqw; letter-spacing: 0.18em; color: #D4AF37;">
                                        PROSESI 01 &bull; MINGGU
                                    </p>
                                    <p class="font-serif-poster uppercase font-bold truncate leading-tight" style="margin-top: 0.28cqw; font-size: 1.28cqw; color: #F3E5AB;">
                                        {{ Str::limit($namaAcaraUtama, 18, '') }}
                                    </p>
                                </div>

                                <div class="flex-1 flex flex-col items-center justify-center" style="padding: 0.7cqw 0.75cqw;">
                                    <p class="font-serif-poster font-bold uppercase leading-none text-white" style="font-size: 1.05cqw; letter-spacing: 0.08em;">
                                        08 NOV 2026 &middot; 15:00 WIB
                                    </p>
                                    <p class="truncate w-full leading-tight" style="margin-top: 0.42cqw; font-size: 0.76cqw; color: rgba(245,239,230,0.78);">
                                        {{ $tempatAcara }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @elseif ($adalahRoyalIvory)
                        {{-- PONSEL KIRI ROYAL IVORY: Hitung Mundur Perunggu + Piagam Letterpress Katedral --}}
                        <div
                            class="relative z-10 text-center"
                            style="background: linear-gradient(180deg, #7B603F 0%, #58432B 100%); color: #FAF6EE; padding: 3.1cqw 2.05cqw 1.95cqw 1.25cqw; border-bottom: 0.14cqw solid rgba(229,201,155,0.5);"
                        >
                            <img
                                src="{{ $asetPosterRoyal['katedral'] }}"
                                alt=""
                                aria-hidden="true"
                                loading="lazy"
                                class="mx-auto"
                                style="width: 2.8cqw;"
                            >
                            <p class="uppercase font-bold leading-none" style="margin-top: 0.35cqw; font-size: 0.56cqw; letter-spacing: 0.22em; color: #E5C99B;">
                                Menuju Hari Bahagia
                            </p>
                            <p class="font-serif-poster font-bold leading-tight text-white" style="margin-top: 0.22cqw; font-size: 2.05cqw;">
                                Save The Date
                            </p>

                            <div class="grid grid-cols-4 gap-[0.48cqw]" style="margin-top: 1.05cqw;">
                                @foreach ([[$hariLagi, 'Hari'], ['08', 'Jam'], ['25', 'Mnt'], ['12', 'Dtk']] as [$angka, $satuan])
                                    <div
                                        style="border-radius: 0.65cqw; background-color: #FBF8F3; border: 0.13cqw solid #E5C99B; padding: 0.68cqw 0.1cqw 0.55cqw; color: #3B2E25;"
                                    >
                                        <div class="font-serif-poster font-bold leading-none" style="font-size: 1.55cqw; color: #58432B;">{{ $angka }}</div>
                                        <div class="uppercase font-bold leading-none" style="margin-top: 0.28cqw; font-size: 0.48cqw; letter-spacing: 0.12em; color: #9E7B4F;">{{ $satuan }}</div>
                                    </div>
                                @endforeach
                            </div>

                            <div
                                class="inline-flex items-center justify-center font-bold uppercase"
                                style="margin-top: 1.15cqw; padding: 0.48cqw 1.35cqw; font-size: 0.62cqw; letter-spacing: 0.1em; border-radius: 9999px; background-color: #FAF6EE; color: #58432B;"
                            >
                                <span>Simpan ke Kalender</span>
                            </div>
                        </div>

                        <div
                            class="relative z-10 flex-1 flex flex-col text-center overflow-hidden"
                            style="background-color: #FBF8F3; color: #3B2E25; padding: 1.45cqw 2.05cqw 1.5cqw 1.25cqw;"
                        >
                            <p class="uppercase font-bold leading-none" style="font-size: 0.56cqw; letter-spacing: 0.22em; color: #9E7B4F;">
                                Waktu &amp; Tempat
                            </p>
                            <p class="font-serif-poster font-bold leading-tight" style="margin-top: 0.22cqw; font-size: 1.7cqw; color: #3B2E25;">
                                Rangkaian Acara
                            </p>

                            <div
                                class="relative mt-auto w-full flex flex-col justify-between overflow-hidden shadow-xs"
                                style="margin-top: 0.85cqw; flex: 1; border-radius: 1.1cqw; background-color: #FFFFFF; border: 0.16cqw solid rgba(158,123,79,0.58);"
                            >
                                <div style="background: linear-gradient(180deg, #6E5436 0%, #58432B 100%); padding: 0.75cqw 0.7cqw; color: #FAF6EE;">
                                    <p class="uppercase font-bold leading-none" style="font-size: 0.52cqw; letter-spacing: 0.18em; color: #E5C99B;">
                                        PROSESI 01 &bull; MINGGU
                                    </p>
                                    <p class="font-serif-poster font-bold truncate leading-tight text-white" style="margin-top: 0.24cqw; font-size: 1.42cqw;">
                                        {{ Str::limit($namaAcaraUtama, 18, '') }}
                                    </p>
                                </div>

                                <div class="flex-1 flex flex-col items-center justify-center" style="padding: 0.7cqw 0.75cqw;">
                                    <p class="font-serif-poster font-bold uppercase leading-none" style="font-size: 1.05cqw; letter-spacing: 0.08em; color: #58432B;">
                                        15 NOV 2026 &middot; 09:00 WIB
                                    </p>
                                    <p class="truncate w-full leading-tight" style="margin-top: 0.42cqw; font-size: 0.76cqw; color: rgba(59,46,37,0.75);">
                                        {{ $tempatAcara }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @elseif ($adalahEditorialMonokrom)
                        {{-- PONSEL KIRI EDITORIAL MONOKROM: Split-Flap Chronometer + Perforated Exhibition Pass --}}
                        <div
                            class="relative z-10 text-left"
                            style="background: #18181B; color: #FAF9F6; padding: 3.1cqw 2.05cqw 1.95cqw 1.25cqw; border-bottom: 0.16cqw solid #18181B;"
                        >
                            <div class="flex items-center justify-between uppercase font-bold leading-none" style="font-size: 0.56cqw; letter-spacing: 0.2em; color: rgba(250,249,246,0.58); padding-bottom: 0.55cqw; border-bottom: 0.1cqw solid rgba(255,255,255,0.2);">
                                <span>02 / CHRONOMETER</span>
                                <span>COUNTDOWN</span>
                            </div>

                            <p class="font-serif-poster uppercase font-bold leading-tight text-white" style="margin-top: 0.7cqw; font-size: 1.95cqw; letter-spacing: 0.06em;">
                                Save The Date
                            </p>
                            <p class="uppercase leading-none" style="margin-top: 0.2cqw; font-size: 0.58cqw; letter-spacing: 0.18em; color: rgba(250,249,246,0.62);">
                                SABTU, 07 NOVEMBER 2026
                            </p>

                            {{-- 4 Kotak Split-Flap Mekanis Siku Tajam --}}
                            <div class="grid grid-cols-4 gap-[0.48cqw] text-center" style="margin-top: 1.1cqw;">
                                @foreach ([[$hariLagi, 'DAYS'], ['08', 'HRS'], ['25', 'MIN'], ['12', 'SEC']] as [$angka, $satuan])
                                    <div
                                        class="relative"
                                        style="background-color: #0D0D10; border: 0.12cqw solid rgba(255,255,255,0.34); padding: 0.72cqw 0.1cqw 0.58cqw; box-shadow: 0.22cqw 0.22cqw 0 0 rgba(255,255,255,0.14);"
                                    >
                                        <span aria-hidden="true" class="pointer-events-none absolute inset-x-0" style="top: 46%; height: 0.08cqw; background: rgba(255,255,255,0.16);"></span>
                                        <div class="font-serif-poster font-bold leading-none text-white" style="font-size: 1.55cqw;">{{ $angka }}</div>
                                        <div class="uppercase font-bold leading-none" style="margin-top: 0.3cqw; font-size: 0.48cqw; letter-spacing: 0.16em; color: rgba(250,249,246,0.58);">{{ $satuan }}</div>
                                    </div>
                                @endforeach
                            </div>

                            <div
                                class="flex items-center justify-between font-bold uppercase"
                                style="margin-top: 1.15cqw; padding: 0.5cqw 0.85cqw; font-size: 0.6cqw; letter-spacing: 0.16em; background-color: #FAF9F6; color: #18181B;"
                            >
                                <span>Simpan ke Kalender</span>
                                <span>&rarr;</span>
                            </div>
                        </div>

                        {{-- Bagian Bawah: Perforated Exhibition Pass --}}
                        <div
                            class="relative z-10 flex-1 flex flex-col text-left overflow-hidden"
                            style="background-color: #FAF9F6; color: #18181B; padding: 1.35cqw 2.05cqw 0 1.25cqw;"
                        >
                            <div class="flex items-center justify-between uppercase font-bold leading-none" style="font-size: 0.56cqw; letter-spacing: 0.2em; color: #18181B; padding-bottom: 0.5cqw; border-bottom: 0.12cqw solid #18181B;">
                                <span>02 / ITINERARY</span>
                                <span>PASS</span>
                            </div>

                            <div
                                class="relative mt-auto w-full flex flex-col bg-white"
                                style="margin-top: 0.95cqw; flex: 1; border: 0.16cqw solid #18181B; border-bottom: 0; box-shadow: 0.42cqw 0.42cqw 0 0 #18181B;"
                            >
                                <div class="flex items-center justify-between uppercase font-bold text-white" style="background-color: #18181B; padding: 0.62cqw 0.85cqw; font-size: 0.54cqw; letter-spacing: 0.18em;">
                                    <span>PASS 01 &middot; ADMIT ONE</span>
                                    <span>07.11.26</span>
                                </div>

                                <div style="padding: 0.9cqw 0.85cqw 0.7cqw;">
                                    <p class="font-serif-poster uppercase font-bold truncate leading-tight" style="font-size: 1.45cqw; letter-spacing: 0.04em; color: #18181B;">
                                        {{ Str::limit($namaAcaraUtama, 16, '') }}
                                    </p>
                                    <p class="uppercase font-bold leading-none" style="margin-top: 0.35cqw; font-size: 0.58cqw; letter-spacing: 0.12em; color: #52525B;">
                                        SABTU &middot; 09:00 WIB
                                    </p>
                                </div>

                                {{-- Garis Sobekan Tiket Setengah Lingkaran --}}
                                <div class="relative flex items-center" style="padding: 0.2cqw 0;" aria-hidden="true">
                                    <span class="absolute rounded-full bg-[#FAF9F6]" style="left: -0.52cqw; width: 0.95cqw; height: 0.95cqw; border-right: 0.16cqw solid #18181B;"></span>
                                    <div class="w-full" style="margin: 0 0.6cqw; border-top: 0.12cqw dashed rgba(24,24,27,0.45);"></div>
                                    <span class="absolute rounded-full bg-[#FAF9F6]" style="right: -0.52cqw; width: 0.95cqw; height: 0.95cqw; border-left: 0.16cqw solid #18181B;"></span>
                                </div>

                                <div class="flex-1 flex items-center justify-between gap-[0.6cqw]" style="padding: 0.55cqw 0.85cqw 0.75cqw;">
                                    <div class="min-w-0">
                                        <span class="block uppercase font-bold" style="font-size: 0.48cqw; letter-spacing: 0.18em; color: #52525B;">VENUE</span>
                                        <p class="font-bold truncate leading-tight" style="margin-top: 0.16cqw; font-size: 0.74cqw; color: #18181B;">
                                            {{ $tempatAcara }}
                                        </p>
                                    </div>
                                    <div aria-hidden="true" class="shrink-0 flex items-end" style="gap: 0.14cqw; height: 2.1cqw; opacity: 0.75;">
                                        <span style="width: 0.16cqw; height: 100%; background: #18181B;"></span>
                                        <span style="width: 0.09cqw; height: 72%; background: #18181B;"></span>
                                        <span style="width: 0.22cqw; height: 100%; background: #18181B;"></span>
                                        <span style="width: 0.1cqw; height: 82%; background: #18181B;"></span>
                                        <span style="width: 0.16cqw; height: 100%; background: #18181B;"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif ($adalahVelvetGarden)
                        {{-- PONSEL KIRI VELVET GARDEN: Save The Date 4 Kapsul Pil Botani + Kartu Lentera Konservatori --}}
                        <div
                            class="relative z-10 text-center"
                            style="background: linear-gradient(180deg, #294443 0%, #1E3735 58%, #132623 100%); color: #FDFBF7; padding: 3.15cqw 2.05cqw 2.05cqw 1.15cqw; border-bottom: 0.14cqw solid rgba(200,164,100,0.4);"
                        >
                            <img
                                src="{{ $asetPosterVelvet['garland'] }}"
                                alt=""
                                aria-hidden="true"
                                loading="lazy"
                                class="mx-auto drop-shadow"
                                style="width: 8.4cqw;"
                            >
                            <p class="uppercase font-semibold leading-none" style="margin-top: 0.35cqw; font-size: 0.62cqw; letter-spacing: 0.22em; color: #EEDAD4;">
                                Menghitung Hari Bahagia
                            </p>
                            <p class="font-serif-poster font-bold leading-tight text-white" style="margin-top: 0.22cqw; font-size: 2.15cqw;">
                                Save The Date
                            </p>
                            <p class="leading-none" style="margin-top: 0.22cqw; font-size: 0.7cqw; color: rgba(243,223,162,0.92);">
                                Jumat, 11 Desember 2026
                            </p>

                            <div class="grid grid-cols-4 gap-[0.55cqw]" style="margin-top: 1.2cqw;">
                                @foreach ([[$hariLagi, 'Hari'], ['14', 'Jam'], ['28', 'Menit'], ['45', 'Detik']] as [$angka, $satuan])
                                    <div
                                        class="shadow-xs flex flex-col items-center justify-center"
                                        style="border-radius: 9999px; padding: 1.05cqw 0.1cqw; background-color: #FDFBF7; border: 0.16cqw solid rgba(200,164,100,0.8);"
                                    >
                                        <div class="font-serif-poster font-bold leading-none" style="font-size: 1.55cqw; color: #132623;">{{ $angka }}</div>
                                        <div class="uppercase font-bold leading-none" style="margin-top: 0.32cqw; font-size: 0.54cqw; color: #8D6F3A;">{{ $satuan }}</div>
                                    </div>
                                @endforeach
                            </div>

                            <div
                                class="inline-flex items-center justify-center font-bold uppercase shadow-xs"
                                style="margin-top: 1.2cqw; gap: 0.45cqw; padding: 0.52cqw 1.45cqw; font-size: 0.68cqw; letter-spacing: 0.08em; border-radius: 9999px; background: linear-gradient(135deg, #DFC285 0%, #C8A464 55%, #A68344 100%); color: #132623;"
                            >
                                <span>Simpan ke Kalender</span>
                            </div>
                        </div>

                        {{-- Bagian Bawah: Rangkaian Acara Kartu Lentera Konservatori --}}
                        <div
                            class="relative z-10 flex-1 flex flex-col text-center overflow-hidden"
                            style="background: linear-gradient(180deg, #132623 0%, #0E1E1A 100%); color: #F4F8F6; padding: 1.55cqw 2.05cqw 0 1.15cqw;"
                        >
                            <img
                                src="{{ $asetPosterVelvet['garland'] }}"
                                alt=""
                                aria-hidden="true"
                                loading="lazy"
                                class="mx-auto drop-shadow"
                                style="width: 8.4cqw;"
                            >
                            <p class="uppercase font-bold leading-none" style="margin-top: 0.28cqw; font-size: 0.62cqw; letter-spacing: 0.24em; color: #EEDAD4;">
                                Momen Bahagia
                            </p>
                            <p class="font-serif-poster font-bold leading-tight text-white" style="margin-top: 0.22cqw; font-size: 1.8cqw;">
                                Rangkaian Acara
                            </p>

                            {{-- Kartu Lentera Konservatori Zamrud & Pita Tanggal Kuningan --}}
                            <div
                                class="relative mt-auto w-full overflow-hidden shadow-md flex flex-col"
                                style="margin-top: 1.1cqw; flex: 1; border-radius: 1.75cqw 1.75cqw 0 0; background: linear-gradient(180deg, #17302B 0%, #0E1F1C 100%); border: 0.2cqw solid rgba(200,164,100,0.68); border-bottom: 0; padding: 1.65cqw 1.1cqw 0.8cqw;"
                            >
                                <p class="uppercase font-bold leading-none" style="font-size: 0.58cqw; letter-spacing: 0.22em; color: #DFC285;">
                                    Prosesi 01
                                </p>
                                <p class="font-script leading-[1.06] text-[#FDFBF7]" style="margin-top: 0.28cqw; font-size: 2.95cqw;">
                                    Akad Nikah
                                </p>

                                {{-- Pita Tanggal Kuningan 3-Kolom --}}
                                <div
                                    class="grid grid-cols-3 items-center text-center"
                                    style="margin-top: 0.95cqw; border-radius: 0.9cqw; background-color: rgba(11,24,21,0.78); border: 0.14cqw solid rgba(200,164,100,0.48); padding: 0.8cqw 0.35cqw;"
                                >
                                    <div>
                                        <span class="block uppercase font-bold" style="font-size: 0.52cqw; color: rgba(238,218,212,0.75);">Hari</span>
                                        <span class="block font-serif-poster font-bold text-white" style="margin-top: 0.18cqw; font-size: 0.72cqw;">Jumat</span>
                                    </div>
                                    <div style="border-left: 0.1cqw solid rgba(200,164,100,0.35); border-right: 0.1cqw solid rgba(200,164,100,0.35);">
                                        <span class="block font-serif-poster font-bold leading-none" style="font-size: 1.55cqw; color: #F3DFA2;">11</span>
                                        <span class="block uppercase font-bold" style="margin-top: 0.16cqw; font-size: 0.52cqw; color: #DFC285;">DES 2026</span>
                                    </div>
                                    <div>
                                        <span class="block uppercase font-bold" style="font-size: 0.52cqw; color: rgba(238,218,212,0.75);">Pukul</span>
                                        <span class="block font-serif-poster font-bold text-white" style="margin-top: 0.18cqw; font-size: 0.68cqw;">08:00 WIB</span>
                                    </div>
                                </div>

                                {{-- Panel Lokasi Gading --}}
                                <div
                                    class="flex-1 flex flex-col items-center justify-center text-center"
                                    style="margin-top: 0.95cqw; border-radius: 1cqw 1cqw 0 0; background-color: #FDFBF7; color: #132623; border: 0.14cqw solid rgba(200,164,100,0.55); border-bottom: 0; padding: 0.85cqw 0.7cqw;"
                                >
                                    <p class="font-serif-poster font-bold truncate w-full leading-tight" style="font-size: 0.92cqw;">
                                        Rumah Kaca Kebun Raya
                                    </p>
                                    <p class="opacity-70 truncate w-full" style="margin-top: 0.22cqw; font-size: 0.66cqw;">
                                        Bogor, Jawa Barat
                                    </p>
                                </div>
                            </div>
                        </div>
                    @elseif ($adalahRusticFloral)
                        {{-- PONSEL KIRI RUSTIC FLORAL: Save The Date Sage + Rangkaian Acara Paviliun Lengkung --}}
                        <div
                            class="relative z-10 text-center"
                            style="background: linear-gradient(180deg, #4B6358 0%, #3A4E45 55%, #2C3C34 100%); color: #FDFBF7; padding: 3.15cqw 2.05cqw 2.05cqw 1.15cqw;"
                        >
                            <img
                                src="{{ $asetPosterRustic['garland'] }}"
                                alt=""
                                aria-hidden="true"
                                loading="lazy"
                                class="mx-auto drop-shadow"
                                style="width: 8.4cqw;"
                            >
                            <p class="uppercase font-semibold leading-none" style="margin-top: 0.35cqw; font-size: 0.64cqw; letter-spacing: 0.22em; color: #E5D5C0;">
                                Menuju Hari Bahagia
                            </p>
                            <p class="font-serif-poster font-bold leading-tight text-white" style="margin-top: 0.22cqw; font-size: 2.15cqw;">
                                Save The Date
                            </p>
                            <p class="leading-none" style="margin-top: 0.22cqw; font-size: 0.7cqw; color: rgba(229,213,192,0.9);">
                                Sabtu, 24 Oktober 2026
                            </p>

                            <div class="grid grid-cols-4 gap-[0.52cqw]" style="margin-top: 1.25cqw;">
                                @foreach ([[$hariLagi, 'Hari'], ['18', 'Jam'], ['33', 'Menit'], ['30', 'Detik']] as [$angka, $satuan])
                                    <div
                                        class="shadow-xs"
                                        style="border-radius: 0.85cqw; padding: 0.85cqw 0.1cqw; background-color: #FDFBF7; border: 0.14cqw solid rgba(229,213,192,0.72);"
                                    >
                                        <div class="font-serif-poster font-bold leading-none" style="font-size: 1.6cqw; color: #4B6358;">{{ $angka }}</div>
                                        <div class="uppercase font-bold leading-none" style="margin-top: 0.3cqw; font-size: 0.56cqw; color: #B86B4B;">{{ $satuan }}</div>
                                    </div>
                                @endforeach
                            </div>

                            <div
                                class="inline-flex items-center justify-center font-bold uppercase shadow-xs"
                                style="margin-top: 1.25cqw; gap: 0.45cqw; padding: 0.52cqw 1.45cqw; font-size: 0.7cqw; letter-spacing: 0.08em; border-radius: 9999px; background-color: #FDFBF7; border: 0.14cqw solid rgba(229,213,192,0.85); color: #2F4037;"
                            >
                                <svg style="width: 0.9cqw; height: 0.9cqw; color: #B86B4B;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <rect width="18" height="18" x="3" y="4" rx="2"/>
                                    <line x1="16" x2="16" y1="2" y2="6"/>
                                    <line x1="8" x2="8" y1="2" y2="6"/>
                                    <line x1="3" x2="21" y1="10" y2="10"/>
                                </svg>
                                <span>Simpan ke Kalender</span>
                            </div>
                        </div>

                        {{-- Bagian Bawah: Tajuk Rangkaian Acara & Kartu Paviliun Lengkung Taman --}}
                        <div
                            class="relative z-10 flex-1 flex flex-col text-center overflow-hidden"
                            style="background: linear-gradient(180deg, #FAF5EC 0%, #F7F1E7 55%, #F4ECE1 100%); color: #1F2937; padding: 1.65cqw 2.05cqw 0 1.15cqw;"
                        >
                            <img
                                src="{{ $asetPosterRustic['garland'] }}"
                                alt=""
                                aria-hidden="true"
                                loading="lazy"
                                class="mx-auto drop-shadow-xs"
                                style="width: 8.6cqw;"
                            >
                            <p class="uppercase font-bold leading-none" style="margin-top: 0.3cqw; font-size: 0.64cqw; letter-spacing: 0.24em; color: #B86B4B;">
                                Jadwal &amp; Lokasi
                            </p>
                            <p class="font-serif-poster font-bold leading-tight" style="margin-top: 0.24cqw; font-size: 1.85cqw; color: #1F2937;">
                                Rangkaian Acara
                            </p>
                            <p class="leading-[1.32]" style="margin-top: 0.3cqw; font-size: 0.62cqw; color: rgba(75,99,88,0.84); padding: 0 0.35cqw;">
                                Dengan penuh suka cita, kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri momen bahagia kami:
                            </p>

                            {{-- Kartu Paviliun Lengkung Taman & Medali Tanggal Melayang --}}
                            <div
                                class="relative mt-auto w-full overflow-hidden shadow-md flex flex-col"
                                style="margin-top: 1.25cqw; flex: 1; border-radius: 9cqw 9cqw 0 0; background-color: #FDFBF7; border: 0.2cqw solid rgba(191,161,95,0.62); border-bottom: 0;"
                            >
                                {{-- Kubah Lengkung Forest-Sage --}}
                                <div
                                    class="relative text-center text-[#FDFBF7] overflow-hidden"
                                    style="background: linear-gradient(180deg, #34483E 0%, #465E53 55%, #2C3D34 100%); padding: 2.65cqw 1cqw 3.85cqw;"
                                >
                                    @if ($gambarLatarTemaUrl)
                                        <img
                                            src="{{ $gambarLatarTemaUrl }}"
                                            alt=""
                                            aria-hidden="true"
                                            loading="lazy"
                                            class="pointer-events-none absolute inset-0 w-full h-full object-cover object-center opacity-[0.16] mix-blend-luminosity"
                                        >
                                    @endif
                                    <div
                                        aria-hidden="true"
                                        class="pointer-events-none absolute"
                                        style="inset: 0.55cqw 0.55cqw 0 0.55cqw; border-radius: 8.4cqw 8.4cqw 0 0; border-top: 0.14cqw solid rgba(243,229,171,0.42); border-left: 0.14cqw solid rgba(243,229,171,0.42); border-right: 0.14cqw solid rgba(243,229,171,0.42);"
                                    ></div>
                                    <div
                                        aria-hidden="true"
                                        class="pointer-events-none absolute left-1/2 -translate-x-1/2 flex items-center"
                                        style="top: 1.15cqw; gap: 0.45cqw;"
                                    >
                                        <span style="height: 0.12cqw; width: 1.5cqw; background: linear-gradient(90deg, transparent, rgba(243,229,171,0.75));"></span>
                                        <span style="width: 0.4cqw; height: 0.4cqw; transform: rotate(45deg); background: #F3E5AB;"></span>
                                        <span style="height: 0.12cqw; width: 1.5cqw; background: linear-gradient(270deg, transparent, rgba(243,229,171,0.75));"></span>
                                    </div>

                                    <p class="relative z-10 uppercase font-bold leading-none" style="font-size: 0.6cqw; letter-spacing: 0.2em; color: #F3E5AB;">
                                        Acara 01 &bull; Sabtu
                                    </p>
                                    <p class="relative z-10 font-script leading-[1.06] text-[#FDFBF7]" style="margin-top: 0.3cqw; font-size: 2.95cqw;">
                                        Akad Nikah
                                    </p>
                                </div>

                                {{-- Medali Segel Tanggal Melayang --}}
                                <div class="relative z-20 flex items-center justify-center" style="margin-top: -2.85cqw; padding: 0 1.4cqw;">
                                    <span aria-hidden="true" style="height: 0.14cqw; flex: 1; background: linear-gradient(90deg, transparent, #BFA15F);"></span>
                                    <div
                                        class="shrink-0 flex flex-col items-center justify-center text-center"
                                        style="margin: 0 0.7cqw; width: 5.7cqw; height: 5.7cqw; border-radius: 9999px; background-color: #FDFBF7; border: 0.24cqw solid #BFA15F; box-shadow: 0 0 0 0.36cqw #FDFBF7, 0 0.6cqw 1.4cqw rgba(47,64,55,0.28);"
                                    >
                                        <span class="font-serif-poster font-bold leading-none" style="font-size: 1.85cqw; color: #2F4037;">24</span>
                                        <span class="uppercase font-bold leading-none" style="margin-top: 0.2cqw; font-size: 0.56cqw; letter-spacing: 0.1em; color: #B86B4B;">OKT 2026</span>
                                    </div>
                                    <span aria-hidden="true" style="height: 0.14cqw; flex: 1; background: linear-gradient(270deg, transparent, #BFA15F);"></span>
                                </div>

                                {{-- Isi Singkat Waktu & Venue --}}
                                <div class="relative z-10 flex-1 flex flex-col items-center justify-start" style="padding: 0.85cqw 0.9cqw 0.8cqw;">
                                    <span
                                        class="inline-block font-semibold leading-none"
                                        style="padding: 0.34cqw 0.95cqw; border-radius: 9999px; background-color: #F5EFE4; border: 0.12cqw solid rgba(191,161,95,0.45); font-size: 0.62cqw; color: #35493F;"
                                    >
                                        Pukul 08:00 - 10:00 WIB
                                    </span>
                                    <p class="font-serif-poster font-bold truncate w-full leading-tight" style="margin-top: 0.55cqw; font-size: 0.88cqw; color: #1F2937;">
                                        Plataran Kemang
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                    <div>
                        <div class="relative w-full overflow-hidden" style="height: 22.2cqw;">
                            <img
                                src="{{ $fotoPembukaUrl }}"
                                alt=""
                                loading="lazy"
                                class="w-full h-full object-cover"
                                style="object-position: 46% 15%;"
                            >
                            <div
                                class="absolute inset-0"
                                style="background: linear-gradient(180deg, rgba(12,16,28,0.18) 0%, {{ $adalahAdatJawa ? 'rgba(71,42,28,0.36)' : ($adalahIslamiSyari ? 'rgba(14,58,54,0.42)' : ($adalahIslamicHeavenly ? 'rgba(19,38,62,0.45)' : 'rgba(90,30,30,0.36)')) }} 54%, {{ $adalahAdatJawa ? '#472A1C' : ($adalahIslamiSyari ? '#0E3A36' : ($adalahIslamicHeavenly ? '#091322' : '#5A1E1E')) }} 100%);"
                            ></div>
                        </div>

                        <div class="relative z-10 text-center" style="margin-top: -2.4cqw; padding: 0 1.85cqw 0 1.2cqw;">
                            <img
                                src="{{ $adalahAdatJawa ? $asetPosterJawa['gunungan'] : ($adalahIslamiSyari ? $asetPosterSyari['arabesque'] : ($adalahIslamicHeavenly ? $asetPosterHeavenly['sabit'] : $asetPosterSunda['siger'])) }}"
                                alt=""
                                loading="lazy"
                                class="mx-auto drop-shadow"
                                style="width: {{ $adalahAdatJawa ? '3.15cqw' : ($adalahIslamiSyari ? '3.2cqw' : ($adalahIslamicHeavenly ? '3cqw' : '3.65cqw')) }};"
                            >
                            <p class="{{ $adalahAdatJawa ? 'font-serif-poster font-bold tracking-[0.03em]' : 'font-script' }} leading-none text-white" style="margin-top: 0.5cqw; font-size: {{ $adalahAdatJawa ? '2.25cqw' : '3.05cqw' }};">
                                Save The Date
                            </p>

                            <div class="grid grid-cols-4 gap-[0.5cqw]" style="margin-top: 1.35cqw;">
                                @foreach ([[$hariLagi, 'Hari'], ['08', 'Jam'], ['25', 'Mnt'], ['12', 'Dtk']] as [$angka, $satuan])
                                    <div
                                        class="shadow-xs"
                                        style="border-radius: 0.7cqw; padding: 0.65cqw 0.1cqw; background-color: {{ $poster['kotak_countdown_bg'] }}; color: {{ $poster['kotak_countdown_teks'] }};"
                                    >
                                        <div class="font-serif-poster font-bold leading-none" style="font-size: 1.65cqw;">{{ $angka }}</div>
                                        <div class="uppercase font-semibold leading-none opacity-80" style="margin-top: 0.28cqw; font-size: 0.82cqw;">{{ $satuan }}</div>
                                    </div>
                                @endforeach
                            </div>

                            <div
                                class="inline-flex items-center justify-center font-semibold shadow-xs"
                                style="margin-top: 1.45cqw; padding: 0.5cqw 1.75cqw; font-size: 1cqw; border-radius: 9999px; background: {{ $poster['tombol_kiri_bg'] }}; color: {{ $poster['tombol_kiri_teks'] }};"
                            >
                                Simpan ke Kalender
                            </div>
                        </div>
                    </div>

                    {{-- Kartu Acara Bersih & Lega di Bawah --}}
                    <div style="padding: 0 1.85cqw 1.75cqw 1.2cqw;">
                        @if ($adalahAdatJawa)
                            <div
                                class="text-center shadow-md"
                                style="border-radius: 1.35cqw; border: 0.2cqw solid #D7BB83; background-color: #FFFAF5; color: #2B180F; padding: 2.15cqw 1cqw;"
                            >
                                <p class="font-serif-poster font-bold leading-tight truncate" style="font-size: 2.05cqw; color: #472A1C;">
                                    Ijab Qabul
                                </p>
                                <p class="font-serif-poster font-bold uppercase tracking-wider leading-tight" style="margin-top: 0.45cqw; font-size: 1.2cqw;">
                                    28 DES 2026
                                </p>
                                <p class="opacity-70 truncate leading-tight" style="margin-top: 0.35cqw; font-size: 0.95cqw; color: #472A1C;">
                                    Royal Ambarrukmo
                                </p>
                            </div>
                        @elseif ($adalahIslamiSyari)
                            <div
                                class="text-center shadow-md"
                                style="border-radius: 999px 999px 1.25cqw 1.25cqw; background-color: #FCFEFD; border: 0.22cqw solid rgba(197,160,89,0.85); color: #0E3A36; padding: 2.1cqw 1cqw 1.45cqw;"
                            >
                                <p class="font-serif-poster font-bold leading-tight truncate" style="font-size: 1.85cqw; color: #0E3A36;">
                                    Akad Nikah
                                </p>
                                <p class="font-serif-poster font-bold uppercase tracking-wider leading-tight" style="margin-top: 0.45cqw; font-size: 1.15cqw; color: #9E7D40;">
                                    26 DES 2026
                                </p>
                                <p class="opacity-70 truncate leading-tight" style="margin-top: 0.3cqw; font-size: 0.92cqw;">
                                    Masjid Istiqlal
                                </p>
                            </div>
                        @elseif ($adalahIslamicHeavenly)
                            <div
                                class="text-center shadow-md"
                                style="border-radius: 999px 999px 1.25cqw 1.25cqw; background: linear-gradient(180deg, #162B47 0%, #0D1B2E 100%); border: 0.22cqw solid rgba(217,182,100,0.85); color: #E6EEF8; padding: 2.1cqw 1cqw 1.45cqw;"
                            >
                                <p class="font-serif-poster font-bold leading-tight truncate" style="font-size: 1.85cqw; color: #F3E5AB;">
                                    Ijab Qabul
                                </p>
                                <p class="font-serif-poster font-bold uppercase tracking-wider leading-tight" style="margin-top: 0.45cqw; font-size: 1.15cqw; color: #D9B664;">
                                    27 DES 2026
                                </p>
                                <p class="opacity-75 truncate leading-tight" style="margin-top: 0.3cqw; font-size: 0.92cqw;">
                                    Sunda Kelapa
                                </p>
                            </div>
                        @else
                            <div
                                class="overflow-hidden shadow-md"
                                style="border-radius: 1.35cqw; background-color: #FFFBF4; border: 0.2cqw solid rgba(197,155,67,0.8); color: #4A2020;"
                            >
                                <div
                                    class="text-center"
                                    style="background: linear-gradient(180deg, #632222 0%, #4A1717 100%); border-bottom: 0.16cqw solid rgba(197,155,67,0.7); padding: 1cqw 0.85cqw;"
                                >
                                    <p class="font-script leading-tight truncate text-[#FFFDF8]" style="font-size: 2.45cqw;">
                                        Akad Nikah
                                    </p>
                                </div>
                                <div class="text-center" style="padding: 1.3cqw 0.85cqw;">
                                    <p class="font-serif-poster font-bold uppercase tracking-wider leading-tight" style="font-size: 1.2cqw; color: #5A1E1E;">
                                        19 DES 2026
                                    </p>
                                    <p class="opacity-70 truncate leading-tight" style="margin-top: 0.3cqw; font-size: 0.95cqw;">
                                        Pendopo Bandung
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                    @endif

                    {{-- Bayangan Kedalaman Halus di Tepi Dalam (Tertimpa Ponsel Tengah) --}}
                    <div
                        aria-hidden="true"
                        class="pointer-events-none absolute inset-y-0 right-0 z-20"
                        style="width: 3.6cqw; background: linear-gradient(90deg, transparent, rgba(0,0,0,0.3));"
                    ></div>
                </div>
            </div>

            {{-- PONSEL KANAN: Potret Mempelai Bersih & Editorial --}}
            <div
                class="absolute z-10 bg-[#151210] shadow-[0_1.6cqw_3.2cqw_rgba(0,0,0,0.36)] ring-1 {{ $adalahEditorialMonokrom ? 'ring-white/25' : 'ring-[#F3E5AB]/20' }}"
                style="right: 6.2cqw; bottom: 9.8cqw; width: 29.2cqw; height: 63.2cqw; border-radius: 3.7cqw; padding: 0.9cqw;"
            >
                <div
                    class="pointer-events-none absolute left-1/2 -translate-x-1/2 z-20 rounded-full bg-[#151210]"
                    style="top: 1.6cqw; width: 5cqw; height: 0.95cqw;"
                ></div>

                @if ($adalahLuxuryNoir)
                    {{-- PONSEL KANAN LUXURY NOIR: Kartu Mempelai Wanita Art Deco Obsidian-Emas --}}
                    <div
                        class="relative w-full h-full overflow-hidden flex flex-col justify-between text-center"
                        style="border-radius: 2.85cqw; background-color: #0B0B0F; color: #F5EFE6; padding: 2.9cqw 1.2cqw 1.65cqw 1.85cqw;"
                    >
                        <div class="relative z-10 w-full">
                            <img
                                src="{{ $asetPosterNoir['emas'] }}"
                                alt=""
                                aria-hidden="true"
                                loading="lazy"
                                class="mx-auto"
                                style="width: 2.7cqw;"
                            >
                            <p class="uppercase font-bold leading-none" style="margin-top: 0.4cqw; font-size: 0.62cqw; letter-spacing: 0.22em; color: #D4AF37;">
                                The Couple
                            </p>
                            <p class="font-serif-poster uppercase font-bold leading-tight text-white" style="margin-top: 0.28cqw; font-size: 1.65cqw; letter-spacing: 0.05em;">
                                Mempelai Wanita
                            </p>
                        </div>

                        <div
                            class="relative z-10 w-full flex flex-col justify-between overflow-hidden"
                            style="margin-top: 0.9cqw; flex: 1; border-radius: 1.15cqw; background-color: #15141B; border: 0.16cqw solid rgba(212,175,55,0.62); padding: 0.95cqw 0.95cqw 1.2cqw;"
                        >
                            <div
                                class="mx-auto overflow-hidden bg-black"
                                style="width: 14.5cqw; height: 19.6cqw; border-radius: 0.75cqw; border: 0.16cqw solid rgba(212,175,55,0.72);"
                            >
                                <img
                                    src="{{ $fotoWanitaUrl }}"
                                    alt="{{ $wanitaLengkap }}"
                                    loading="lazy"
                                    class="w-full h-full object-cover object-top"
                                >
                            </div>

                            <div class="w-full" style="margin-top: 0.75cqw;">
                                <p class="font-serif-poster uppercase font-bold leading-none" style="font-size: 2.05cqw; letter-spacing: 0.06em; color: #F3E5AB;">
                                    {{ $wanitaPanggilan }}
                                </p>
                                <p class="font-bold truncate w-full leading-tight text-white" style="margin-top: 0.35cqw; font-size: 0.92cqw;">
                                    {{ $wanitaLengkap }}
                                </p>
                                <p class="truncate w-full leading-tight" style="margin-top: 0.2cqw; font-size: 0.7cqw; color: rgba(245,239,230,0.72);">
                                    Putri dari {{ $wanitaAyah }}
                                </p>
                                @if ($instagramWanita)
                                    <div
                                        class="inline-flex items-center justify-center font-semibold"
                                        style="margin-top: 0.58cqw; padding: 0.28cqw 1.1cqw; font-size: 0.72cqw; border-radius: 9999px; background-color: #09090D; border: 0.12cqw solid rgba(212,175,55,0.6); color: #F3E5AB;"
                                    >
                                        <span>&#64;{{ $instagramWanita }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div
                            aria-hidden="true"
                            class="pointer-events-none absolute inset-y-0 left-0 z-20"
                            style="width: 3.4cqw; background: linear-gradient(270deg, transparent, rgba(0,0,0,0.34));"
                        ></div>
                    </div>
                @elseif ($adalahRoyalIvory)
                    {{-- PONSEL KANAN ROYAL IVORY: Kartu Letterpress Katedral Gading & Potret Lengkung Mempelai Wanita --}}
                    <div
                        class="relative w-full h-full overflow-hidden flex flex-col justify-between text-center"
                        style="border-radius: 2.85cqw; background-color: #FBF8F3; color: #3B2E25; padding: 2.9cqw 1.2cqw 1.65cqw 1.85cqw;"
                    >
                        <div class="relative z-10 w-full">
                            <img
                                src="{{ $asetPosterRoyal['katedral'] }}"
                                alt=""
                                aria-hidden="true"
                                loading="lazy"
                                class="mx-auto"
                                style="width: 2.8cqw;"
                            >
                            <p class="uppercase font-bold leading-none" style="margin-top: 0.4cqw; font-size: 0.62cqw; letter-spacing: 0.22em; color: #9E7B4F;">
                                Royal Couple
                            </p>
                            <p class="font-serif-poster font-bold leading-tight" style="margin-top: 0.26cqw; font-size: 1.85cqw; color: #3B2E25;">
                                Mempelai Berbahagia
                            </p>
                        </div>

                        <div
                            class="relative z-10 w-full flex flex-col justify-between overflow-hidden shadow-xs"
                            style="margin-top: 0.85cqw; flex: 1; border-radius: 1.35cqw; background-color: #FFFFFF; border: 0.16cqw solid rgba(158,123,79,0.58); padding: 1.05cqw 0.95cqw 1.2cqw;"
                        >
                            <div
                                class="mx-auto overflow-hidden"
                                style="width: 14cqw; height: 18.8cqw; border-radius: 999px 999px 0.8cqw 0.8cqw; border: 0.2cqw solid rgba(158,123,79,0.72); background-color: #FBF8F3; padding: 0.24cqw;"
                            >
                                <img
                                    src="{{ $fotoWanitaUrl }}"
                                    alt="{{ $wanitaLengkap }}"
                                    loading="lazy"
                                    class="w-full h-full object-cover object-top"
                                    style="border-radius: 999px 999px 0.6cqw 0.6cqw;"
                                >
                            </div>

                            <div class="w-full" style="margin-top: 0.65cqw;">
                                <p class="font-script leading-none" style="font-size: 2.7cqw; color: #3B2E25;">
                                    {{ $wanitaPanggilan }}
                                </p>
                                <p class="font-serif-poster font-bold truncate w-full leading-tight" style="margin-top: 0.3cqw; font-size: 1.05cqw; color: #3B2E25;">
                                    {{ $wanitaLengkap }}
                                </p>
                                <p class="truncate w-full leading-tight" style="margin-top: 0.2cqw; font-size: 0.74cqw; color: rgba(59,46,37,0.72);">
                                    Putri dari {{ $wanitaAyah }}
                                </p>
                                @if ($instagramWanita)
                                    <div
                                        class="inline-flex items-center justify-center font-semibold"
                                        style="margin-top: 0.55cqw; padding: 0.28cqw 1.1cqw; font-size: 0.74cqw; border-radius: 9999px; background-color: #FBF8F3; border: 0.12cqw solid rgba(158,123,79,0.58); color: #58432B;"
                                    >
                                        <span>&#64;{{ $instagramWanita }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div
                            aria-hidden="true"
                            class="pointer-events-none absolute inset-y-0 left-0 z-20"
                            style="width: 3.4cqw; background: linear-gradient(270deg, transparent, rgba(0,0,0,0.22));"
                        ></div>
                    </div>
                @elseif ($adalahEditorialMonokrom)
                    {{-- PONSEL KANAN EDITORIAL MONOKROM: 01 / Dossier & Kartu Obsidian Noir Mempelai Wanita --}}
                    <div
                        class="relative w-full h-full overflow-hidden flex flex-col justify-between text-left"
                        style="border-radius: 2.85cqw; background-color: #FAF9F6; color: #18181B; padding: 2.9cqw 1.25cqw 1.65cqw 2.05cqw;"
                    >
                        <div class="relative z-10 w-full">
                            <div class="flex items-center justify-between uppercase font-bold leading-none" style="font-size: 0.56cqw; letter-spacing: 0.22em; color: #18181B; padding-bottom: 0.55cqw; border-bottom: 0.14cqw solid #18181B;">
                                <span>01 / DOSSIER</span>
                                <span>THE COUPLE</span>
                            </div>
                            <p class="font-serif-poster uppercase font-bold leading-tight" style="margin-top: 0.65cqw; font-size: 1.68cqw; letter-spacing: 0.05em; color: #18181B;">
                                The Bride
                            </p>
                        </div>

                        {{-- Kartu Obsidian Noir Mempelai Wanita (Selaras Tema Asli) --}}
                        <div
                            class="relative z-10 w-full flex flex-col justify-between text-center"
                            style="margin-top: 0.85cqw; flex: 1; background-color: #141417; color: #FAF9F6; border: 0.16cqw solid #18181B; box-shadow: -0.42cqw 0.42cqw 0 0 #71717A; padding: 1.15cqw 1.05cqw 1.25cqw;"
                        >
                            <div class="flex items-center justify-between" style="padding-bottom: 0.55cqw; border-bottom: 0.1cqw solid rgba(255,255,255,0.18);">
                                <img
                                    src="{{ $asetPosterEditorial['bingkai'] }}"
                                    alt=""
                                    aria-hidden="true"
                                    loading="lazy"
                                    class="invert opacity-80"
                                    style="width: 1.9cqw;"
                                >
                                <span class="uppercase font-bold leading-none" style="font-size: 0.56cqw; letter-spacing: 0.2em; color: rgba(250,249,246,0.72);">
                                    02 / THE BRIDE
                                </span>
                            </div>

                            {{-- Bingkai Potret Siku Tajam Monokrom --}}
                            <div
                                class="mx-auto overflow-hidden bg-black"
                                style="margin-top: 0.8cqw; width: 13.6cqw; height: 18.2cqw; border: 0.16cqw solid rgba(255,255,255,0.55); padding: 0.28cqw;"
                            >
                                <img
                                    src="{{ $fotoWanitaUrl }}"
                                    alt="{{ $wanitaLengkap }}"
                                    loading="lazy"
                                    class="w-full h-full object-cover object-top grayscale contrast-[1.08]"
                                >
                            </div>

                            <div class="w-full" style="margin-top: 0.75cqw;">
                                <p class="font-serif-poster uppercase font-bold leading-none text-white" style="font-size: 2.25cqw; letter-spacing: 0.08em;">
                                    {{ $wanitaPanggilan }}
                                </p>
                                <p class="font-bold truncate w-full leading-tight" style="margin-top: 0.35cqw; font-size: 0.88cqw; color: rgba(250,249,246,0.92);">
                                    {{ $wanitaLengkap }}
                                </p>
                                <p class="truncate w-full leading-tight" style="margin-top: 0.2cqw; font-size: 0.66cqw; color: rgba(250,249,246,0.65);">
                                    Putri dari {{ $wanitaAyah }}
                                </p>
                                @if ($instagramWanita)
                                    <div
                                        class="inline-flex items-center justify-center uppercase font-bold"
                                        style="margin-top: 0.6cqw; gap: 0.35cqw; padding: 0.28cqw 0.95cqw; font-size: 0.62cqw; letter-spacing: 0.12em; border: 0.12cqw solid rgba(255,255,255,0.55); color: #FAF9F6;"
                                    >
                                        <span>&#64;{{ $instagramWanita }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div
                            aria-hidden="true"
                            class="pointer-events-none absolute inset-y-0 left-0 z-20"
                            style="width: 3.4cqw; background: linear-gradient(270deg, transparent, rgba(0,0,0,0.24));"
                        ></div>
                    </div>
                @elseif ($adalahAdatJawa)
                    {{-- PONSEL KANAN ADAT JAWA: Kapsul Kubah Kertas Gading di Atas Latar Hutan + Gunungan + Potret Aisyah --}}
                    <div
                        class="relative w-full h-full overflow-hidden flex items-stretch justify-center"
                        style="border-radius: 2.85cqw; background-color: #D9C3B0; padding: 2.2cqw 1.05cqw 0 1.45cqw;"
                    >
                        <img
                            src="{{ $asetPosterJawa['hutan'] }}"
                            alt=""
                            aria-hidden="true"
                            loading="lazy"
                            class="pointer-events-none absolute inset-0 w-full h-full object-cover object-top"
                        >

                        {{-- Kapsul Kubah Tinggi Berborder Emas Persis Seksi 4 Adat Jawa --}}
                        <div
                            class="relative z-10 w-full flex flex-col items-center justify-between text-center overflow-hidden shadow-lg"
                            style="border-radius: 999px 999px 1.8cqw 1.8cqw; border: 0.34cqw solid #D7BB83; background-color: rgba(255,250,245,0.95); color: #2B180F; padding: 3.1cqw 1.35cqw 2.4cqw;"
                        >
                            {{-- Ornamen Halus Tepi Kiri & Kanan (Mengapit Tepi Seperti Tema Asli) --}}
                            <img
                                src="{{ $asetPosterJawa['sayapWayang'] }}"
                                alt=""
                                aria-hidden="true"
                                loading="lazy"
                                class="pointer-events-none absolute -scale-x-100 opacity-85"
                                style="top: 38%; left: -1.8cqw; width: 5.2cqw;"
                            >
                            <img
                                src="{{ $asetPosterJawa['bungaLili'] }}"
                                alt=""
                                aria-hidden="true"
                                loading="lazy"
                                class="pointer-events-none absolute opacity-90"
                                style="top: 48%; right: -2.2cqw; width: 6.2cqw;"
                            >

                            <div class="relative z-10 w-full">
                                <img
                                    src="{{ $asetPosterJawa['gunungan'] }}"
                                    alt=""
                                    loading="lazy"
                                    class="mx-auto"
                                    style="width: 3.1cqw;"
                                >
                                <p class="font-serif-poster font-bold leading-[1.08]" style="margin-top: 0.65cqw; font-size: 2.05cqw; color: #472A1C;">
                                    We Are Getting<br>Married!
                                </p>
                                <p class="opacity-70 leading-tight mx-auto" style="margin-top: 0.6cqw; font-size: 0.88cqw; max-width: 19cqw; color: #472A1C;">
                                    Dengan memohon rahmat &amp; ridho Allah SWT, kami mengundang pernikahan putra-putri kami:
                                </p>
                            </div>

                            {{-- Potret Oval Aisyah Berborder Emas --}}
                            <div
                                class="relative z-10 overflow-hidden shadow-md"
                                style="width: 13.8cqw; height: 20.8cqw; border-radius: 999px; border: 0.28cqw solid #D7BB83; box-shadow: 0 0.7cqw 1.8cqw rgba(71,42,28,0.22);"
                            >
                                <img
                                    src="{{ $fotoWanitaUrl }}"
                                    alt="{{ $wanitaLengkap }}"
                                    loading="lazy"
                                    class="w-full h-full object-cover"
                                    style="object-position: 50% 18%;"
                                >
                            </div>

                            <div class="relative z-10 w-full">
                                <p class="font-serif-poster font-bold leading-none" style="font-size: 2.35cqw; color: #472A1C;">
                                    {{ $wanitaPanggilan }}
                                </p>
                                <p class="font-serif-poster font-bold truncate leading-tight" style="margin-top: 0.35cqw; font-size: 1.15cqw;">
                                    {{ $wanitaLengkap }}
                                </p>
                                <p class="opacity-70 truncate leading-tight" style="margin-top: 0.22cqw; font-size: 0.86cqw; color: #472A1C;">
                                    Putri dari {{ $wanitaAyah }}
                                </p>
                                @if ($instagramWanita)
                                    <div
                                        class="inline-flex items-center justify-center font-semibold"
                                        style="margin-top: 0.65cqw; padding: 0.32cqw 1.3cqw; font-size: 0.84cqw; border-radius: 9999px; background: linear-gradient(135deg, #ECD298 0%, #C79F4B 100%); color: #24130A;"
                                    >
                                        &#64;{{ $instagramWanita }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div
                            aria-hidden="true"
                            class="pointer-events-none absolute inset-y-0 left-0 z-20"
                            style="width: 3.4cqw; background: linear-gradient(270deg, transparent, rgba(0,0,0,0.22));"
                        ></div>
                    </div>
                @elseif ($adalahIslamiSyari)
                    {{-- PONSEL KANAN ISLAMI SYAR'I: Header Arabesque + Kartu Paviliun Kubah Zamrud & Potret Al-Arus --}}
                    <div
                        class="relative w-full h-full overflow-hidden flex flex-col justify-between text-center"
                        style="border-radius: 2.85cqw; background-color: #F7FBF8; color: #0E3A36; padding: 3.1cqw 1.15cqw 1.75cqw 1.65cqw;"
                    >
                        @if ($gambarLatarTemaUrl)
                            <img
                                src="{{ $gambarLatarTemaUrl }}"
                                alt=""
                                aria-hidden="true"
                                loading="lazy"
                                class="pointer-events-none absolute inset-0 w-full h-full object-cover opacity-14"
                            >
                        @endif

                        <div class="relative z-10 w-full">
                            <img
                                src="{{ $asetPosterSyari['arabesque'] }}"
                                alt=""
                                loading="lazy"
                                class="mx-auto drop-shadow-xs"
                                style="width: 3.4cqw;"
                            >
                            <p class="uppercase font-bold leading-none" style="margin-top: 0.45cqw; font-size: 0.8cqw; letter-spacing: 0.18em; color: #9E7D40;">
                                &bull; Bismillahirrahmanirrahim &bull;
                            </p>
                            <p class="font-serif-poster font-bold leading-tight" style="margin-top: 0.35cqw; font-size: 1.9cqw; color: #0E3A36;">
                                Mempelai Pengantin
                            </p>
                            <p class="opacity-70 leading-tight mx-auto" style="margin-top: 0.35cqw; font-size: 0.82cqw; max-width: 21cqw;">
                                Dengan memohon rahmat &amp; ridho Allah SWT:
                            </p>
                        </div>

                        <div
                            class="relative z-10 w-full overflow-hidden shadow-md flex flex-col"
                            style="margin-top: 1cqw; flex: 1; border-radius: 1.8cqw; background-color: #FCFEFD; border: 0.22cqw solid rgba(197,160,89,0.8);"
                        >
                            <div
                                class="relative flex items-center justify-center overflow-hidden"
                                style="flex: 1.18; background: linear-gradient(180deg, #154E48 0%, #0E3A36 58%, #0A2B28 100%); padding: 1.4cqw 1.1cqw 2cqw;"
                            >
                                <div
                                    class="relative z-10 overflow-hidden shadow-md"
                                    style="width: 13cqw; height: 16.5cqw; border-radius: 999px 999px 1.2cqw 1.2cqw; border: 0.28cqw solid #D4B56E; background-color: #08221F;"
                                >
                                    <img
                                        src="{{ $fotoWanitaUrl }}"
                                        alt="{{ $wanitaLengkap }}"
                                        loading="lazy"
                                        class="w-full h-full object-cover"
                                        style="object-position: 50% 18%;"
                                    >
                                </div>
                            </div>

                            <div class="relative z-30 flex justify-center" style="margin-top: -1.15cqw;">
                                <span
                                    class="uppercase font-bold leading-none shadow-xs"
                                    style="border-radius: 9999px; background: linear-gradient(90deg, #EFE0B4 0%, #D4B56E 50%, #EFE0B4 100%); color: #092623; padding: 0.36cqw 1.2cqw; font-size: 0.76cqw; letter-spacing: 0.12em; border: 0.14cqw solid #FFFBF0;"
                                >
                                    &bull; Mempelai Wanita &bull;
                                </span>
                            </div>

                            <div class="text-center" style="padding: 0.9cqw 1cqw 1.35cqw;">
                                <p class="font-script leading-none" style="font-size: 2.7cqw; color: #0E3A36;">
                                    {{ $wanitaPanggilan }}
                                </p>
                                <p class="font-serif-poster font-bold truncate leading-tight" style="margin-top: 0.32cqw; font-size: 1.12cqw; color: #16524C;">
                                    {{ $wanitaLengkap }}
                                </p>
                                <p class="opacity-70 truncate leading-tight" style="margin-top: 0.22cqw; font-size: 0.84cqw;">
                                    Putri dari {{ $wanitaAyah }}
                                </p>
                                @if ($instagramWanita)
                                    <div
                                        class="inline-flex items-center justify-center font-semibold"
                                        style="margin-top: 0.6cqw; padding: 0.3cqw 1.25cqw; font-size: 0.84cqw; border-radius: 9999px; background: linear-gradient(135deg, #16524C 0%, #0E3A36 100%); color: #F7FBF8; border: 0.12cqw solid rgba(197,160,89,0.65);"
                                    >
                                        &#64;{{ $instagramWanita }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div
                            aria-hidden="true"
                            class="pointer-events-none absolute inset-y-0 left-0 z-20"
                            style="width: 3.4cqw; background: linear-gradient(270deg, transparent, rgba(0,0,0,0.22));"
                        ></div>
                    </div>
                @elseif ($adalahRusticFloral)
                    {{-- PONSEL KANAN RUSTIC FLORAL: Seksi Mempelai Berbahagia & Kartu Paviliun Botani Mempelai Wanita --}}
                    <div
                        class="relative w-full h-full overflow-hidden flex flex-col justify-between text-center"
                        style="border-radius: 2.85cqw; background-color: #F8F3EA; color: #2F4037; padding: 2.8cqw 1.15cqw 1.65cqw 2.05cqw;"
                    >
                        @if ($gambarLatarTemaUrl)
                            <img
                                src="{{ $gambarLatarTemaUrl }}"
                                alt=""
                                aria-hidden="true"
                                loading="lazy"
                                class="pointer-events-none absolute inset-0 w-full h-full object-cover opacity-14"
                            >
                        @endif

                        {{-- Header Seksi Mempelai Berbahagia (Selaras Tema Asli) --}}
                        <div class="relative z-10 w-full">
                            <img
                                src="{{ $asetPosterRustic['garland'] }}"
                                alt=""
                                aria-hidden="true"
                                loading="lazy"
                                class="mx-auto drop-shadow-xs"
                                style="width: 9.2cqw;"
                            >
                            <p class="uppercase font-bold leading-none" style="margin-top: 0.3cqw; font-size: 0.7cqw; letter-spacing: 0.24em; color: #B86B4B;">
                                The Couple
                            </p>
                            <p class="font-serif-poster font-bold leading-tight" style="margin-top: 0.28cqw; font-size: 1.72cqw; color: #1F2937;">
                                Mempelai Berbahagia
                            </p>
                            <p class="leading-[1.3]" style="margin-top: 0.3cqw; font-size: 0.64cqw; color: rgba(75,99,88,0.82); padding: 0 0.4cqw;">
                                Dengan memohon rahmat dan ridho Tuhan Yang Maha Esa, kami bermaksud menyelenggarakan pernikahan putra-putri kami:
                            </p>
                        </div>

                        {{-- Kartu Paviliun Botani Mempelai Wanita (Panggung Atas Cat Air + Bingkai Lengkung Emas & Bunga) --}}
                        <div
                            class="relative z-10 w-full overflow-hidden shadow-md flex flex-col"
                            style="margin-top: 0.95cqw; flex: 1; border-radius: 1.7cqw; background-color: #FDFBF7; border: 0.22cqw solid rgba(191,161,95,0.62);"
                        >
                            {{-- Panggung Atas Potret Mempelai Wanita --}}
                            <div
                                class="relative w-full flex items-center justify-center overflow-hidden"
                                style="background: linear-gradient(180deg, #F5EFE2 0%, #FAF6ED 68%, #FDFBF7 100%); padding: 1.45cqw 0.7cqw 0.55cqw;"
                            >
                                @if ($gambarLatarTemaUrl)
                                    <img
                                        src="{{ $gambarLatarTemaUrl }}"
                                        alt=""
                                        aria-hidden="true"
                                        loading="lazy"
                                        class="pointer-events-none absolute inset-0 w-full h-full object-cover object-center opacity-[0.14] -scale-x-100"
                                    >
                                @endif

                                <div
                                    class="relative z-10 flex items-center justify-center"
                                    style="width: 19.6cqw; aspect-ratio: 780 / 960;"
                                >
                                    <div
                                        class="absolute overflow-hidden"
                                        style="inset: 8.5% 12.5% 11.5% 12.5%; border-radius: 999px 999px 0.95cqw 0.95cqw; background-color: #2F4037; box-shadow: 0 0.8cqw 1.6cqw rgba(35,51,43,0.24);"
                                    >
                                        <img
                                            src="{{ $fotoWanitaUrl }}"
                                            alt="{{ $wanitaLengkap }}"
                                            loading="lazy"
                                            class="w-full h-full object-cover object-top scale-[1.04]"
                                        >
                                    </div>
                                    <img
                                        src="{{ $asetPosterRustic['bingkaiMempelai'] }}"
                                        alt=""
                                        aria-hidden="true"
                                        loading="lazy"
                                        class="pointer-events-none relative z-10 w-full h-full object-contain -scale-x-100 drop-shadow-xs"
                                    >
                                </div>
                            </div>

                            {{-- Panel Biografi Mempelai Wanita --}}
                            <div
                                class="relative z-10 flex-1 flex flex-col items-center justify-center text-center w-full"
                                style="background-color: #FDFBF7; padding: 0.35cqw 0.9cqw 1.4cqw;"
                            >
                                <span
                                    class="inline-block uppercase font-bold leading-none"
                                    style="font-size: 0.62cqw; letter-spacing: 0.16em; padding: 0.26cqw 1.05cqw; border-radius: 9999px; background-color: rgba(75,99,88,0.12); border: 0.12cqw solid rgba(75,99,88,0.3); color: #4B6358;"
                                >
                                    Mempelai Wanita
                                </span>

                                <p class="font-script leading-none" style="margin-top: 0.65cqw; font-size: 3.3cqw; color: #4B6358;">
                                    {{ $wanitaPanggilan }}
                                </p>
                                <p class="font-serif-poster font-bold truncate w-full leading-tight" style="margin-top: 0.4cqw; font-size: 1cqw; color: #1F2937;">
                                    {{ $wanitaLengkap }}
                                </p>
                                <p class="leading-[1.32] w-full" style="margin-top: 0.28cqw; font-size: 0.7cqw; color: rgba(31,41,55,0.72);">
                                    Putri dari {{ $wanitaAyah }}@if ($wanitaIbu) &amp; {{ $wanitaIbu }}@endif
                                </p>

                                @if ($instagramWanita)
                                    <div
                                        class="inline-flex items-center justify-center font-semibold"
                                        style="margin-top: 0.75cqw; gap: 0.42cqw; padding: 0.32cqw 1.15cqw; font-size: 0.76cqw; border-radius: 9999px; background-color: rgba(75,99,88,0.1); border: 0.14cqw solid rgba(75,99,88,0.26); color: #4B6358;"
                                    >
                                        <svg style="width: 1cqw; height: 1cqw; color: #B86B4B;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                                            <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                                        </svg>
                                        <span>&#64;{{ $instagramWanita }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div
                            aria-hidden="true"
                            class="pointer-events-none absolute inset-y-0 left-0 z-20"
                            style="width: 3.4cqw; background: linear-gradient(270deg, transparent, rgba(0,0,0,0.2));"
                        ></div>
                    </div>
                @elseif ($adalahVelvetGarden)
                    {{-- PONSEL KANAN VELVET GARDEN: Mempelai Berbahagia & Kartu Paviliun Zamrud Mempelai Wanita --}}
                    <div
                        class="relative w-full h-full overflow-hidden flex flex-col justify-between text-center"
                        style="border-radius: 2.85cqw; background: linear-gradient(180deg, #162C28 0%, #11221F 100%); color: #F4F8F6; padding: 2.8cqw 1.15cqw 1.65cqw 2.05cqw;"
                    >
                        @if ($gambarLatarTemaUrl)
                            <img
                                src="{{ $gambarLatarTemaUrl }}"
                                alt=""
                                aria-hidden="true"
                                loading="lazy"
                                class="pointer-events-none absolute inset-0 w-full h-full object-cover opacity-18"
                            >
                        @endif

                        {{-- Header Seksi Mempelai Berbahagia --}}
                        <div class="relative z-10 w-full">
                            <img
                                src="{{ $asetPosterVelvet['garland'] }}"
                                alt=""
                                aria-hidden="true"
                                loading="lazy"
                                class="mx-auto drop-shadow"
                                style="width: 9.2cqw;"
                            >
                            <p class="uppercase font-bold leading-none" style="margin-top: 0.3cqw; font-size: 0.7cqw; letter-spacing: 0.24em; color: #EEDAD4;">
                                The Couple
                            </p>
                            <p class="font-serif-poster font-bold leading-tight text-white" style="margin-top: 0.28cqw; font-size: 1.72cqw;">
                                Mempelai Berbahagia
                            </p>
                            <p class="leading-[1.3]" style="margin-top: 0.3cqw; font-size: 0.62cqw; color: rgba(238,218,212,0.8); padding: 0 0.4cqw;">
                                Dengan memohon rahmat dan ridho Tuhan Yang Maha Esa, kami bermaksud menyelenggarakan pernikahan putra-putri kami:
                            </p>
                        </div>

                        {{-- Kartu Paviliun Konservatori Mempelai Wanita --}}
                        <div
                            class="relative z-10 w-full overflow-hidden shadow-lg flex flex-col"
                            style="margin-top: 0.95cqw; flex: 1; border-radius: 1.7cqw; background-color: #FDFBF7; border: 0.22cqw solid rgba(200,164,100,0.72);"
                        >
                            {{-- Panggung Atas Potret Zamrud Senja --}}
                            <div
                                class="relative w-full flex items-center justify-center overflow-hidden"
                                style="background: linear-gradient(180deg, #0E201C 0%, #152E28 65%, #1C3B34 100%); padding: 1.4cqw 0.7cqw 0.9cqw;"
                            >
                                @if ($gambarLatarTemaUrl)
                                    <img
                                        src="{{ $gambarLatarTemaUrl }}"
                                        alt=""
                                        aria-hidden="true"
                                        loading="lazy"
                                        class="pointer-events-none absolute inset-0 w-full h-full object-cover object-center opacity-[0.2] -scale-x-100"
                                    >
                                @endif

                                <div
                                    class="relative z-10 flex items-center justify-center"
                                    style="width: 19.4cqw; aspect-ratio: 780 / 960;"
                                >
                                    <div
                                        class="absolute overflow-hidden"
                                        style="inset: 8.5% 12.5% 11.5% 12.5%; border-radius: 999px 999px 0.95cqw 0.95cqw; background-color: #0E1E18; box-shadow: 0 0.8cqw 1.8cqw rgba(4,12,9,0.55);"
                                    >
                                        <img
                                            src="{{ $fotoWanitaUrl }}"
                                            alt="{{ $wanitaLengkap }}"
                                            loading="lazy"
                                            class="w-full h-full object-cover object-top scale-[1.04]"
                                        >
                                    </div>
                                    <img
                                        src="{{ $asetPosterVelvet['bingkaiMempelai'] }}"
                                        alt=""
                                        aria-hidden="true"
                                        loading="lazy"
                                        class="pointer-events-none relative z-10 w-full h-full object-contain -scale-x-100 drop-shadow"
                                    >
                                </div>
                            </div>

                            {{-- Pita Gelar Emas Mempelai Wanita --}}
                            <div class="relative z-20 flex justify-center" style="margin-top: -1cqw;">
                                <span
                                    class="inline-block uppercase font-bold leading-none shadow-xs"
                                    style="font-size: 0.6cqw; letter-spacing: 0.16em; padding: 0.3cqw 1.1cqw; border-radius: 9999px; background: linear-gradient(90deg, #DFC285 0%, #C8A464 50%, #DFC285 100%); color: #132623;"
                                >
                                    Mempelai Wanita
                                </span>
                            </div>

                            {{-- Panel Biografi Gading --}}
                            <div
                                class="relative z-10 flex-1 flex flex-col items-center justify-center text-center w-full"
                                style="background-color: #FDFBF7; color: #1F3431; padding: 0.5cqw 0.9cqw 1.3cqw;"
                            >
                                <p class="font-script leading-none" style="font-size: 3.3cqw; color: #132623;">
                                    {{ $wanitaPanggilan }}
                                </p>
                                <p class="font-serif-poster font-bold truncate w-full leading-tight" style="margin-top: 0.4cqw; font-size: 1cqw; color: #1F3431;">
                                    {{ $wanitaLengkap }}
                                </p>
                                <p class="leading-[1.32] w-full" style="margin-top: 0.28cqw; font-size: 0.68cqw; color: rgba(31,52,49,0.75);">
                                    Putri dari {{ $wanitaAyah }}@if ($wanitaIbu) &amp; {{ $wanitaIbu }}@endif
                                </p>

                                @if ($instagramWanita)
                                    <div
                                        class="inline-flex items-center justify-center font-semibold"
                                        style="margin-top: 0.7cqw; gap: 0.42cqw; padding: 0.32cqw 1.15cqw; font-size: 0.74cqw; border-radius: 9999px; background-color: rgba(19,38,35,0.1); border: 0.14cqw solid rgba(200,164,100,0.55); color: #132623;"
                                    >
                                        <svg style="width: 1cqw; height: 1cqw; color: #8D6F3A;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                                            <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                                        </svg>
                                        <span>&#64;{{ $instagramWanita }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div
                            aria-hidden="true"
                            class="pointer-events-none absolute inset-y-0 left-0 z-20"
                            style="width: 3.4cqw; background: linear-gradient(270deg, transparent, rgba(0,0,0,0.28));"
                        ></div>
                    </div>
                @elseif ($adalahIslamicHeavenly)
                    {{-- PONSEL KANAN ISLAMIC HEAVENLY: Observatorium Malam Safir + Potret Lingkaran Astrolab --}}
                    <div
                        class="relative w-full h-full overflow-hidden flex flex-col justify-between text-center"
                        style="border-radius: 2.85cqw; background: linear-gradient(180deg, #102036 0%, #091322 100%); color: #E6EEF8; padding: 3.1cqw 1.15cqw 1.75cqw 1.65cqw;"
                    >
                        @if ($gambarLatarTemaUrl)
                            <img
                                src="{{ $gambarLatarTemaUrl }}"
                                alt=""
                                aria-hidden="true"
                                loading="lazy"
                                class="pointer-events-none absolute inset-0 w-full h-full object-cover opacity-22"
                            >
                        @endif

                        <div class="relative z-10 w-full">
                            <img
                                src="{{ $asetPosterHeavenly['sabit'] }}"
                                alt=""
                                loading="lazy"
                                class="mx-auto drop-shadow-xs"
                                style="width: 3.1cqw;"
                            >
                            <p class="uppercase font-bold leading-none" style="margin-top: 0.45cqw; font-size: 0.8cqw; letter-spacing: 0.18em; color: #D9B664;">
                                &#10022; Calon Mempelai &#10022;
                            </p>
                            <p class="font-serif-poster font-bold leading-tight text-white" style="margin-top: 0.35cqw; font-size: 1.9cqw;">
                                Mempelai Berbahagia
                            </p>
                            <p class="opacity-75 leading-tight mx-auto" style="margin-top: 0.35cqw; font-size: 0.82cqw; max-width: 21cqw;">
                                Dengan memohon rahmat &amp; ridho Allah SWT:
                            </p>
                        </div>

                        <div
                            class="relative z-10 w-full overflow-hidden shadow-md flex flex-col"
                            style="margin-top: 1cqw; flex: 1; border-radius: 1.8cqw; background: linear-gradient(180deg, #152842 0%, #0B1626 100%); border: 0.22cqw solid rgba(217,182,100,0.72);"
                        >
                            <div
                                class="relative flex items-center justify-center overflow-hidden"
                                style="flex: 1.18; padding: 1.4cqw 1.1cqw 2cqw;"
                            >
                                <div
                                    class="relative z-10 overflow-hidden shadow-md"
                                    style="width: 13cqw; height: 16.5cqw; border-radius: 999px 999px 1.2cqw 1.2cqw; border: 0.28cqw solid #D9B664; background-color: #091322; box-shadow: 0 0 1.4cqw rgba(217,182,100,0.28);"
                                >
                                    <img
                                        src="{{ $fotoWanitaUrl }}"
                                        alt="{{ $wanitaLengkap }}"
                                        loading="lazy"
                                        class="w-full h-full object-cover"
                                        style="object-position: 50% 18%;"
                                    >
                                </div>
                            </div>

                            <div class="relative z-30 flex justify-center" style="margin-top: -1.15cqw;">
                                <span
                                    class="uppercase font-bold leading-none shadow-xs"
                                    style="border-radius: 9999px; background: linear-gradient(90deg, #F3E5AB 0%, #D9B664 50%, #F3E5AB 100%); color: #091322; padding: 0.36cqw 1.2cqw; font-size: 0.76cqw; letter-spacing: 0.12em; border: 0.14cqw solid #FFF8E4;"
                                >
                                    &#10022; Mempelai Wanita &#10022;
                                </span>
                            </div>

                            <div class="text-center" style="padding: 0.9cqw 1cqw 1.35cqw; background-color: rgba(9,19,34,0.45);">
                                <p class="font-script leading-none" style="font-size: 2.75cqw; color: #F3E5AB;">
                                    {{ $wanitaPanggilan }}
                                </p>
                                <p class="font-serif-poster font-bold truncate leading-tight text-white" style="margin-top: 0.32cqw; font-size: 1.12cqw;">
                                    {{ $wanitaLengkap }}
                                </p>
                                <p class="opacity-75 truncate leading-tight" style="margin-top: 0.22cqw; font-size: 0.84cqw;">
                                    Putri dari {{ $wanitaAyah }}
                                </p>
                                @if ($instagramWanita)
                                    <div
                                        class="inline-flex items-center justify-center font-semibold"
                                        style="margin-top: 0.6cqw; padding: 0.3cqw 1.25cqw; font-size: 0.84cqw; border-radius: 9999px; background: linear-gradient(135deg, #18304F 0%, #091322 100%); color: #F3E5AB; border: 0.14cqw solid rgba(217,182,100,0.68);"
                                    >
                                        &#64;{{ $instagramWanita }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div
                            aria-hidden="true"
                            class="pointer-events-none absolute inset-y-0 left-0 z-20"
                            style="width: 3.4cqw; background: linear-gradient(270deg, transparent, rgba(0,0,0,0.34));"
                        ></div>
                    </div>
                @else
                    {{-- PONSEL KANAN SUNDA HERITAGE: Header Pasangan Panganten + Kartu Paviliun Marun Berbingkai Priangan & Bunga --}}
                    <div
                        class="relative w-full h-full overflow-hidden flex flex-col justify-between text-center"
                        style="border-radius: 2.85cqw; background-color: #FAF4E8; color: #4A2020; padding: 3.1cqw 1.15cqw 1.75cqw 1.65cqw;"
                    >
                        @if ($gambarLatarTemaUrl)
                            <img
                                src="{{ $gambarLatarTemaUrl }}"
                                alt=""
                                aria-hidden="true"
                                loading="lazy"
                                class="pointer-events-none absolute inset-0 w-full h-full object-cover opacity-16"
                            >
                        @endif

                        {{-- Tajuk Seksi Bermahkota Siger Sunda (Di Atas Kartu, Persis Tema Asli) --}}
                        <div class="relative z-10 w-full">
                            <img
                                src="{{ $asetPosterSunda['siger'] }}"
                                alt=""
                                loading="lazy"
                                class="mx-auto drop-shadow-xs"
                                style="width: 3.6cqw;"
                            >
                            <p class="uppercase font-bold leading-none" style="margin-top: 0.45cqw; font-size: 0.82cqw; letter-spacing: 0.2em; color: #8E6620;">
                                &bull; Pasangan Panganten &bull;
                            </p>
                            <p class="font-serif-poster font-bold leading-tight" style="margin-top: 0.35cqw; font-size: 1.95cqw; color: #5A1E1E;">
                                Mempelai Berbahagia
                            </p>
                            <p class="opacity-70 leading-tight mx-auto" style="margin-top: 0.35cqw; font-size: 0.82cqw; max-width: 21cqw;">
                                Kalayan nyuhunkeun rido sareng rahmat Gusti Nu Maha Suci:
                            </p>
                        </div>

                        {{-- Kartu Paviliun Panganten Istri (Marun + Bingkai Emas Priangan + Hamparan Bunga + Biodata Gading) --}}
                        <div
                            class="relative z-10 w-full overflow-hidden shadow-md flex flex-col"
                            style="margin-top: 1cqw; flex: 1; border-radius: 1.8cqw; background-color: #FFFBF4; border: 0.22cqw solid rgba(197,155,67,0.8);"
                        >
                            {{-- Panggung Atas Beludru Marun + Bingkai Priangan + Kamelia & Anggrek --}}
                            <div
                                class="relative flex items-center justify-center overflow-hidden"
                                style="flex: 1.18; background: linear-gradient(180deg, #5F2222 0%, #4A1717 58%, #3B1414 100%); padding: 1.3cqw 1.1cqw 2.2cqw;"
                            >
                                <div
                                    class="relative z-10 flex items-center justify-center"
                                    style="width: 14.2cqw; aspect-ratio: 780 / 1043;"
                                >
                                    <div
                                        class="absolute overflow-hidden"
                                        style="inset: 8.5% 13.5%; border-radius: 50%; background-color: #2E0E0E;"
                                    >
                                        <img
                                            src="{{ $fotoWanitaUrl }}"
                                            alt="{{ $wanitaLengkap }}"
                                            loading="lazy"
                                            class="w-full h-full object-cover"
                                            style="object-position: 50% 18%;"
                                        >
                                    </div>
                                    <img
                                        src="{{ $asetPosterSunda['bingkai'] }}"
                                        alt=""
                                        aria-hidden="true"
                                        loading="lazy"
                                        class="pointer-events-none relative z-10 w-full h-full object-contain drop-shadow"
                                    >
                                </div>

                                <img
                                    src="{{ $asetPosterSunda['bungaDepan'] }}"
                                    alt=""
                                    aria-hidden="true"
                                    loading="lazy"
                                    class="pointer-events-none absolute -bottom-[0.3cqw] inset-x-0 w-full z-20"
                                >
                            </div>

                            {{-- Pita Emas Panganten Istri --}}
                            <div class="relative z-30 flex justify-center" style="margin-top: -1.15cqw;">
                                <span
                                    class="uppercase font-bold leading-none shadow-xs"
                                    style="border-radius: 9999px; background: linear-gradient(90deg, #E6C87E 0%, #C59B43 50%, #E6C87E 100%); color: #351010; padding: 0.36cqw 1.3cqw; font-size: 0.78cqw; letter-spacing: 0.13em; border: 0.14cqw solid #FFF7E2;"
                                >
                                    &bull; Panganten Istri &bull;
                                </span>
                            </div>

                            {{-- Biografi Gading --}}
                            <div class="text-center" style="padding: 0.9cqw 1cqw 1.35cqw;">
                                <p class="font-script leading-none" style="font-size: 2.7cqw; color: #5A1E1E;">
                                    {{ $wanitaPanggilan }}
                                </p>
                                <p class="font-serif-poster font-bold truncate leading-tight" style="margin-top: 0.32cqw; font-size: 1.12cqw; color: #4A2020;">
                                    {{ $wanitaLengkap }}
                                </p>
                                <p class="opacity-70 truncate leading-tight" style="margin-top: 0.22cqw; font-size: 0.84cqw;">
                                    Putri ti {{ $wanitaAyah }}
                                </p>
                                @if ($instagramWanita)
                                    <div
                                        class="inline-flex items-center justify-center font-semibold"
                                        style="margin-top: 0.6cqw; padding: 0.3cqw 1.25cqw; font-size: 0.84cqw; border-radius: 9999px; background: linear-gradient(135deg, #6E2C2C 0%, #5A1E1E 100%); color: #FAF4E8; border: 0.12cqw solid rgba(197,155,67,0.65);"
                                    >
                                        &#64;{{ $instagramWanita }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div
                            aria-hidden="true"
                            class="pointer-events-none absolute inset-y-0 left-0 z-20"
                            style="width: 3.4cqw; background: linear-gradient(270deg, transparent, rgba(0,0,0,0.22));"
                        ></div>
                    </div>
                @endif
            </div>

            {{-- PONSEL TENGAH HERO (RAMPING & TINGGI ~9:19.5, MENONJOL DI DEPAN) --}}
            <div
                class="absolute left-1/2 -translate-x-1/2 z-20 bg-[#14110F] shadow-[0_2.4cqw_4.8cqw_rgba(0,0,0,0.52)] ring-1 {{ $adalahEditorialMonokrom ? 'ring-white/35' : 'ring-[#F3E5AB]/32' }}"
                style="bottom: 7.4cqw; width: 33.2cqw; height: 71.5cqw; border-radius: 4.2cqw; padding: 1cqw;"
            >
                <div
                    class="pointer-events-none absolute left-1/2 -translate-x-1/2 z-30 rounded-full bg-[#14110F]"
                    style="top: 1.85cqw; width: 6cqw; height: 1.15cqw;"
                ></div>

                @if ($adalahLuxuryNoir)
                    {{-- PONSEL TENGAH LUXURY NOIR: Panggung Ballroom Art Deco, Lampu Kristal & Monogram Emas --}}
                    <div
                        class="relative w-full h-full overflow-hidden flex flex-col justify-between text-center"
                        style="border-radius: 3.25cqw; background: #09090D; color: #F5EFE6; padding: 3.6cqw 2.4cqw 2.4cqw;"
                    >
                        <img
                            src="{{ $asetPosterNoir['latar'] }}"
                            alt="{{ $tema->nama_tema }}"
                            loading="lazy"
                            class="absolute inset-0 w-full h-full object-cover object-center"
                        >
                        <div
                            aria-hidden="true"
                            class="pointer-events-none absolute inset-0"
                            style="background: linear-gradient(180deg, rgba(9,9,13,0.82) 0%, rgba(9,9,13,0.44) 48%, rgba(6,6,9,0.92) 100%);"
                        ></div>

                        <img
                            src="{{ $asetPosterNoir['bingkai'] }}"
                            alt=""
                            aria-hidden="true"
                            loading="lazy"
                            class="pointer-events-none absolute inset-0 w-full h-full object-contain opacity-92 z-10"
                            style="padding: 0.55cqw;"
                        >

                        <div class="relative z-20 my-auto" style="padding: 3.2cqw 1.2cqw 0;">
                            <img
                                src="{{ $asetPosterNoir['emas'] }}"
                                alt=""
                                aria-hidden="true"
                                loading="lazy"
                                class="mx-auto"
                                style="width: 3.2cqw;"
                            >
                            <p class="uppercase font-bold leading-none" style="margin-top: 0.7cqw; font-size: 0.74cqw; letter-spacing: 0.24em; color: #D4AF37;">
                                The Grand Celebration
                            </p>
                            <p class="font-serif-poster uppercase font-bold leading-[1.06] text-white drop-shadow" style="margin-top: 0.9cqw; font-size: 3.05cqw; letter-spacing: 0.08em;">
                                {{ $priaPanggilan }}
                            </p>
                            <div class="flex items-center justify-center gap-[0.65cqw]" style="margin: 0.25cqw 0;">
                                <span style="height: 0.12cqw; width: 2.2cqw; background: rgba(212,175,55,0.75);"></span>
                                <span class="font-script leading-none" style="font-size: 2.4cqw; color: #F3E5AB;">&amp;</span>
                                <span style="height: 0.12cqw; width: 2.2cqw; background: rgba(212,175,55,0.75);"></span>
                            </div>
                            <p class="font-serif-poster uppercase font-bold leading-[1.06] text-white drop-shadow" style="font-size: 3.05cqw; letter-spacing: 0.08em;">
                                {{ $wanitaPanggilan }}
                            </p>
                            <p class="uppercase font-semibold leading-none" style="margin-top: 1.15cqw; font-size: 0.92cqw; letter-spacing: 0.22em; color: #F3E5AB;">
                                {{ $poster['tanggal_pendek'] }}
                            </p>
                        </div>

                        <div class="relative z-20 flex justify-center" style="padding-bottom: 0.6cqw;">
                            <span
                                class="font-serif-poster font-bold uppercase flex items-center justify-center"
                                style="width: 3.6cqw; height: 3.6cqw; border-radius: 9999px; border: 0.13cqw dashed rgba(212,175,55,0.8); background: rgba(9,9,13,0.75); font-size: 0.88cqw; letter-spacing: 0.08em; color: #F3E5AB;"
                            >
                                {{ mb_substr($priaPanggilan, 0, 1) }}&amp;{{ mb_substr($wanitaPanggilan, 0, 1) }}
                            </span>
                        </div>
                    </div>
                @elseif ($adalahRoyalIvory)
                    {{-- PONSEL TENGAH ROYAL IVORY: Lengkungan Katedral Mutiara Gading & Segel Lilin Perunggu --}}
                    <div
                        class="relative w-full h-full overflow-hidden flex flex-col justify-between text-center"
                        style="border-radius: 3.25cqw; background: #3B2E25; color: #3B2E25; padding: 3.4cqw 2.2cqw 2.4cqw;"
                    >
                        <img
                            src="{{ $asetPosterRoyal['latar'] }}"
                            alt="{{ $tema->nama_tema }}"
                            loading="lazy"
                            class="absolute inset-0 w-full h-full object-cover object-center"
                        >
                        <div
                            aria-hidden="true"
                            class="pointer-events-none absolute inset-0"
                            style="background: linear-gradient(180deg, rgba(250,246,238,0.88) 0%, rgba(250,246,238,0.52) 55%, rgba(59,46,37,0.84) 100%);"
                        ></div>

                        {{-- Lengkungan Rose-Window Katedral --}}
                        <div
                            aria-hidden="true"
                            class="pointer-events-none absolute z-10"
                            style="inset: 1.05cqw; border-radius: 999px 999px 1.8cqw 1.8cqw; border: 0.16cqw solid rgba(158,123,79,0.72);"
                        ></div>

                        <div class="relative z-20 my-auto" style="padding: 1.8cqw 1cqw 0;">
                            <img
                                src="{{ $asetPosterRoyal['katedral'] }}"
                                alt=""
                                aria-hidden="true"
                                loading="lazy"
                                class="mx-auto"
                                style="width: 3.3cqw;"
                            >
                            <p class="uppercase font-bold leading-none" style="margin-top: 0.65cqw; font-size: 0.76cqw; letter-spacing: 0.24em; color: #7B603F;">
                                The Royal Wedding
                            </p>
                            <p class="font-serif-poster font-bold leading-[1.06]" style="margin-top: 0.85cqw; font-size: 3.35cqw; color: #3B2E25;">
                                {{ $priaPanggilan }}
                            </p>
                            <div class="flex items-center justify-center gap-[0.65cqw]" style="margin: 0.2cqw 0;">
                                <span style="height: 0.13cqw; width: 2.2cqw; background: rgba(158,123,79,0.75);"></span>
                                <span class="font-script leading-none" style="font-size: 2.55cqw; color: #9E7B4F;">&amp;</span>
                                <span style="height: 0.13cqw; width: 2.2cqw; background: rgba(158,123,79,0.75);"></span>
                            </div>
                            <p class="font-serif-poster font-bold leading-[1.06]" style="font-size: 3.35cqw; color: #3B2E25;">
                                {{ $wanitaPanggilan }}
                            </p>
                            <p class="uppercase font-bold leading-none" style="margin-top: 1.1cqw; font-size: 0.94cqw; letter-spacing: 0.22em; color: #58432B;">
                                {{ $poster['tanggal_pendek'] }}
                            </p>
                        </div>

                        <div class="relative z-20 flex justify-center" style="padding-bottom: 0.5cqw;">
                            <span
                                class="font-serif-poster font-bold uppercase flex items-center justify-center shadow-md"
                                style="width: 3.6cqw; height: 3.6cqw; border-radius: 9999px; background-color: #9E7B4F; border: 0.16cqw solid #E5C99B; font-size: 0.88cqw; letter-spacing: 0.08em; color: #FAF6EE;"
                            >
                                {{ mb_substr($priaPanggilan, 0, 1) }}&amp;{{ mb_substr($wanitaPanggilan, 0, 1) }}
                            </span>
                        </div>
                    </div>
                @elseif ($adalahEditorialMonokrom)
                    {{-- PONSEL TENGAH EDITORIAL MONOKROM: Visual Hero Exhibition Spread (Viewfinder, Arsitektur Monokrom & Masthead Bertingkat) --}}
                    <div
                        class="relative w-full h-full overflow-hidden flex flex-col justify-between text-left"
                        style="border-radius: 3.25cqw; background: #0E0E11; color: #FAF9F6; padding: 2.85cqw 2.2cqw 2.15cqw;"
                    >
                        <img
                            src="{{ $asetPosterEditorial['latar'] }}"
                            alt="{{ $tema->nama_tema }}"
                            loading="lazy"
                            class="absolute inset-0 w-full h-full object-cover object-center grayscale contrast-[1.12]"
                        >
                        <div
                            aria-hidden="true"
                            class="pointer-events-none absolute inset-0"
                            style="background: linear-gradient(180deg, rgba(12,12,15,0.84) 0%, rgba(12,12,15,0.32) 38%, rgba(12,12,15,0.48) 66%, rgba(10,10,13,0.94) 100%);"
                        ></div>

                        {{-- Bingkai Viewfinder Siku Tajam --}}
                        <div aria-hidden="true" class="pointer-events-none absolute z-10" style="inset: 1.15cqw; border: 0.11cqw solid rgba(255,255,255,0.22);">
                            <span class="absolute -top-px -left-px" style="width: 1.1cqw; height: 1.1cqw; border-top: 0.2cqw solid #FFFFFF; border-left: 0.2cqw solid #FFFFFF;"></span>
                            <span class="absolute -top-px -right-px" style="width: 1.1cqw; height: 1.1cqw; border-top: 0.2cqw solid #FFFFFF; border-right: 0.2cqw solid #FFFFFF;"></span>
                            <span class="absolute -bottom-px -left-px" style="width: 1.1cqw; height: 1.1cqw; border-bottom: 0.2cqw solid #FFFFFF; border-left: 0.2cqw solid #FFFFFF;"></span>
                            <span class="absolute -bottom-px -right-px" style="width: 1.1cqw; height: 1.1cqw; border-bottom: 0.2cqw solid #FFFFFF; border-right: 0.2cqw solid #FFFFFF;"></span>
                        </div>

                        {{-- Baris Telemetri Atas --}}
                        <div class="relative z-20 space-y-[0.55cqw]" style="padding: 0 0.4cqw;">
                            <div class="flex items-center justify-between uppercase font-bold leading-none" style="font-size: 0.62cqw; letter-spacing: 0.18em; color: rgba(255,255,255,0.82); padding-bottom: 0.6cqw; border-bottom: 0.11cqw solid rgba(255,255,255,0.26);">
                                <span>NO. 01 &middot; {{ $poster['tanggal_pendek'] }}</span>
                                <span style="border: 0.1cqw solid rgba(255,255,255,0.48); padding: 0.2cqw 0.45cqw; background: rgba(0,0,0,0.45);">35MM B&amp;W</span>
                            </div>
                            <p class="uppercase font-semibold leading-none" style="padding-top: 0.25cqw; font-size: 0.66cqw; letter-spacing: 0.24em; color: rgba(255,255,255,0.75);">
                                We Are Getting Married!
                            </p>
                        </div>

                        {{-- Masthead Nama Mempelai Bertingkat Asimetris --}}
                        <div class="relative z-20 my-auto" style="padding: 0 0.4cqw;">
                            <p class="font-serif-poster uppercase font-bold leading-[0.96] text-white drop-shadow" style="font-size: 3.75cqw; letter-spacing: 0.05em;">
                                {{ $priaPanggilan }}
                            </p>
                            <div class="flex items-center" style="margin: 0.55cqw 0; gap: 0.65cqw;">
                                <span style="height: 0.12cqw; width: 2.8cqw; background: rgba(255,255,255,0.62);"></span>
                                <span class="uppercase font-bold leading-none" style="font-size: 0.66cqw; letter-spacing: 0.22em; color: rgba(255,255,255,0.82);">&amp; / COLLECTOR EDITION</span>
                            </div>
                            <p class="font-serif-poster uppercase font-bold leading-[0.96] text-white drop-shadow" style="padding-left: 1.8cqw; font-size: 3.75cqw; letter-spacing: 0.05em;">
                                {{ $wanitaPanggilan }}
                            </p>
                        </div>

                        {{-- Footer Colophon & Segel Monogram --}}
                        <div class="relative z-20 flex items-end justify-between" style="padding: 0.65cqw 0.4cqw 0; border-top: 0.11cqw solid rgba(255,255,255,0.26);">
                            <div>
                                <p class="uppercase font-bold leading-none" style="font-size: 0.54cqw; letter-spacing: 0.22em; color: rgba(255,255,255,0.58);">EXHIBITION DATE</p>
                                <p class="uppercase font-bold leading-none text-white" style="margin-top: 0.3cqw; font-size: 0.72cqw; letter-spacing: 0.18em;">{{ $poster['tanggal_pendek'] }}</p>
                            </div>
                            <span class="font-serif-poster font-bold uppercase leading-none text-white" style="font-size: 1.05cqw; letter-spacing: 0.12em; border: 0.12cqw solid rgba(255,255,255,0.52); background: rgba(0,0,0,0.55); padding: 0.42cqw 0.6cqw;">
                                {{ mb_substr($priaPanggilan, 0, 1) }}{{ mb_substr($wanitaPanggilan, 0, 1) }}
                            </span>
                        </div>
                    </div>
                @elseif ($adalahAdatJawa)
                    {{-- PONSEL TENGAH ADAT JAWA: Visual Hero Video Motion Keraton Asli (Bingkai Ukiran, Janur, Joglo & Mawar) --}}
                    <div
                        class="relative w-full h-full overflow-hidden text-center"
                        style="border-radius: 3.25cqw; background: #3B2316;"
                    >
                        <img
                            src="{{ $asetPosterJawa['heroPoster'] }}"
                            alt="{{ $tema->nama_tema }}"
                            loading="lazy"
                            class="absolute inset-0 w-full h-full object-cover object-center"
                        >

                        {{-- Tipografi Mempelai Tepat di Dalam Bingkai Emas Video Hero --}}
                        <div
                            class="absolute z-20 flex flex-col items-center justify-center text-center"
                            style="inset: 15% 15% 39% 15%;"
                        >
                            <p class="font-script leading-none drop-shadow-xs" style="font-size: 2.35cqw; color: #FFF8EC;">
                                The Wedding of
                            </p>
                            <p class="font-serif-poster font-bold uppercase leading-[1.08] drop-shadow-xs" style="margin-top: 0.9cqw; font-size: 3.15cqw; letter-spacing: 0.09em; color: #F3E5AB;">
                                {{ $priaPanggilan }}
                            </p>
                            <div class="flex items-center justify-center gap-[0.75cqw]" style="margin: 0.25cqw 0;">
                                <span style="height: 0.14cqw; width: 2.4cqw; background: rgba(215,187,131,0.75);"></span>
                                <span class="font-script leading-none" style="font-size: 2.5cqw; color: #E6C987;">&amp;</span>
                                <span style="height: 0.14cqw; width: 2.4cqw; background: rgba(215,187,131,0.75);"></span>
                            </div>
                            <p class="font-serif-poster font-bold uppercase leading-[1.08] drop-shadow-xs" style="font-size: 3.15cqw; letter-spacing: 0.09em; color: #F3E5AB;">
                                {{ $wanitaPanggilan }}
                            </p>
                            <p class="uppercase font-semibold leading-none drop-shadow-xs" style="margin-top: 1.25cqw; font-size: 1cqw; letter-spacing: 0.24em; color: #FFFAF5;">
                                {{ $poster['tanggal_pendek'] }}
                            </p>
                        </div>
                    </div>
                @elseif ($adalahIslamiSyari)
                    {{-- PONSEL TENGAH ISLAMI SYAR'I: Visual Hero Video Motion Alhambra (Bingkai Mihrab Zamrud, Paviliun Kubah & Mawar Putih) --}}
                    <div
                        class="relative w-full h-full overflow-hidden text-center"
                        style="border-radius: 3.25cqw; background: #0E3A36;"
                    >
                        <img
                            src="{{ $asetPosterSyari['heroPoster'] }}"
                            alt="{{ $tema->nama_tema }}"
                            loading="lazy"
                            class="absolute inset-0 w-full h-full object-cover object-center"
                        >

                        {{-- Tipografi Mempelai Tepat Di Dalam Bingkai Mihrab Zamrud Video Hero --}}
                        <div
                            class="absolute z-20 flex flex-col items-center justify-center text-center"
                            style="inset: 18% 20% 50.5% 20%;"
                        >
                            <p class="leading-none drop-shadow-xs" style="font-size: 1.45cqw; color: #F3E5AB;">
                                بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                            </p>
                            <p class="uppercase font-bold leading-none drop-shadow-xs" style="margin-top: 0.65cqw; font-size: 0.82cqw; letter-spacing: 0.22em; color: #E6D19C;">
                                Walimatul Ursy
                            </p>
                            <p class="font-serif-poster font-bold uppercase leading-[1.06] drop-shadow-xs" style="margin-top: 0.75cqw; font-size: 2.7cqw; letter-spacing: 0.08em; color: #FFFDF8;">
                                {{ $priaPanggilan }}
                            </p>
                            <div class="flex items-center justify-center gap-[0.65cqw]" style="margin: 0.18cqw 0;">
                                <span style="height: 0.14cqw; width: 2cqw; background: rgba(230,209,156,0.75);"></span>
                                <span class="font-script leading-none" style="font-size: 2.2cqw; color: #E6D19C;">&amp;</span>
                                <span style="height: 0.14cqw; width: 2cqw; background: rgba(230,209,156,0.75);"></span>
                            </div>
                            <p class="font-serif-poster font-bold uppercase leading-[1.06] drop-shadow-xs" style="font-size: 2.7cqw; letter-spacing: 0.08em; color: #FFFDF8;">
                                {{ $wanitaPanggilan }}
                            </p>
                            <p class="uppercase font-semibold leading-none drop-shadow-xs" style="margin-top: 0.85cqw; font-size: 0.92cqw; letter-spacing: 0.22em; color: #F3E5AB;">
                                {{ $poster['tanggal_pendek'] }}
                            </p>
                        </div>
                    </div>
                @elseif ($adalahIslamicHeavenly)
                    {{-- PONSEL TENGAH ISLAMIC HEAVENLY: Visual Hero Video Motion Celestial Night (Bingkai Safir, Kubah Masjid & Teratai Putih) --}}
                    <div
                        class="relative w-full h-full overflow-hidden text-center"
                        style="border-radius: 3.25cqw; background: #091322;"
                    >
                        <img
                            src="{{ $asetPosterHeavenly['heroPoster'] }}"
                            alt="{{ $tema->nama_tema }}"
                            loading="lazy"
                            class="absolute inset-0 w-full h-full object-cover object-center"
                        >

                        {{-- Tipografi Mempelai Tepat Di Dalam Bingkai Safir Video Hero --}}
                        <div
                            class="absolute z-20 flex flex-col items-center justify-center text-center"
                            style="inset: 19.5% 27% 47% 27%;"
                        >
                            <p class="leading-none drop-shadow-xs" style="font-size: 1.3cqw; color: #F3E5AB;">
                                بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                            </p>
                            <p class="uppercase font-bold leading-none drop-shadow-xs" style="margin-top: 0.6cqw; font-size: 0.76cqw; letter-spacing: 0.2em; color: #D9B664;">
                                Walimatul Ursy
                            </p>
                            <p class="font-serif-poster font-bold uppercase leading-[1.06] drop-shadow-xs" style="margin-top: 0.7cqw; font-size: 2.4cqw; letter-spacing: 0.07em; color: #FFFDF8;">
                                {{ $priaPanggilan }}
                            </p>
                            <div class="flex items-center justify-center gap-[0.6cqw]" style="margin: 0.16cqw 0;">
                                <span style="height: 0.14cqw; width: 1.8cqw; background: rgba(217,182,100,0.75);"></span>
                                <span class="font-script leading-none" style="font-size: 2.05cqw; color: #E7C87D;">&amp;</span>
                                <span style="height: 0.14cqw; width: 1.8cqw; background: rgba(217,182,100,0.75);"></span>
                            </div>
                            <p class="font-serif-poster font-bold uppercase leading-[1.06] drop-shadow-xs" style="font-size: 2.4cqw; letter-spacing: 0.07em; color: #FFFDF8;">
                                {{ $wanitaPanggilan }}
                            </p>
                            <p class="uppercase font-semibold leading-none drop-shadow-xs" style="margin-top: 0.8cqw; font-size: 0.86cqw; letter-spacing: 0.2em; color: #F3E5AB;">
                                {{ $poster['tanggal_pendek'] }}
                            </p>
                        </div>
                    </div>
                @elseif ($adalahVelvetGarden)
                    {{-- PONSEL TENGAH VELVET GARDEN: Visual Hero Video Motion Konservatori Kaca Zamrud --}}
                    <div
                        class="relative w-full h-full overflow-hidden text-center"
                        style="border-radius: 3.25cqw; background: #0E1E18;"
                    >
                        <img
                            src="{{ $asetPosterVelvet['heroPoster'] }}"
                            alt="{{ $tema->nama_tema }}"
                            loading="lazy"
                            class="absolute inset-0 w-full h-full object-cover object-center"
                        >

                        {{-- Tipografi Putih-Emas Tepat Di Dalam Bingkai Kaca Emerald Video Hero --}}
                        <div
                            class="absolute z-20 flex flex-col items-center justify-center text-center"
                            style="inset: 14% 12% 22% 12%;"
                        >
                            <img
                                src="{{ $asetPosterVelvet['botani'] }}"
                                alt=""
                                aria-hidden="true"
                                loading="lazy"
                                class="mx-auto drop-shadow"
                                style="width: 3.4cqw;"
                            >
                            <p class="uppercase font-bold leading-none drop-shadow-xs" style="margin-top: 0.7cqw; font-size: 0.82cqw; letter-spacing: 0.24em; color: #EEDAD4;">
                                The Wedding Of
                            </p>
                            <p class="font-serif-poster font-bold leading-[1.06] text-white drop-shadow" style="margin-top: 0.85cqw; font-size: 3.15cqw;">
                                {{ $priaPanggilan }}
                            </p>
                            <div class="flex items-center justify-center gap-[0.75cqw]" style="margin: 0.2cqw 0;">
                                <span style="height: 0.14cqw; width: 2.3cqw; background: rgba(223,194,133,0.85);"></span>
                                <span class="font-script leading-none" style="font-size: 2.6cqw; color: #F3DFA2;">&amp;</span>
                                <span style="height: 0.14cqw; width: 2.3cqw; background: rgba(223,194,133,0.85);"></span>
                            </div>
                            <p class="font-serif-poster font-bold leading-[1.06] text-white drop-shadow" style="font-size: 3.15cqw;">
                                {{ $wanitaPanggilan }}
                            </p>
                            <p class="uppercase font-bold leading-none drop-shadow-xs" style="margin-top: 1.1cqw; font-size: 0.96cqw; letter-spacing: 0.24em; color: #F3DFA2;">
                                {{ $poster['tanggal_pendek'] }}
                            </p>
                        </div>
                    </div>
                @elseif ($adalahRusticFloral)
                    {{-- PONSEL TENGAH RUSTIC FLORAL: Visual Hero Video Motion Watercolor Garden (Kartu Lengkung Ivory, Pergola & Bunga Terakota) --}}
                    <div
                        class="relative w-full h-full overflow-hidden text-center"
                        style="border-radius: 3.25cqw; background: #FBF7EE;"
                    >
                        <img
                            src="{{ $asetPosterRustic['heroPoster'] }}"
                            alt="{{ $tema->nama_tema }}"
                            loading="lazy"
                            class="absolute inset-0 w-full h-full object-cover object-center"
                        >

                        {{-- Tipografi Fine-Art Botani Tepat Di Dalam Lengkungan Ivory Semi-Transparan Video Hero --}}
                        <div
                            class="absolute z-20 flex flex-col items-center justify-center text-center"
                            style="inset: 14.5% 14% 25% 14%;"
                        >
                            <p class="uppercase font-bold leading-none" style="font-size: 0.85cqw; letter-spacing: 0.24em; color: #4B6358;">
                                The Wedding Of
                            </p>
                            <p class="font-serif-poster font-bold leading-[1.06]" style="margin-top: 0.9cqw; font-size: 3.25cqw; color: #223029;">
                                {{ $priaPanggilan }}
                            </p>
                            <div class="flex items-center justify-center gap-[0.75cqw]" style="margin: 0.2cqw 0;">
                                <span style="height: 0.14cqw; width: 2.3cqw; background: rgba(191,161,95,0.85);"></span>
                                <span class="font-script leading-none" style="font-size: 2.65cqw; color: #B86B4B;">&amp;</span>
                                <span style="height: 0.14cqw; width: 2.3cqw; background: rgba(191,161,95,0.85);"></span>
                            </div>
                            <p class="font-serif-poster font-bold leading-[1.06]" style="font-size: 3.25cqw; color: #223029;">
                                {{ $wanitaPanggilan }}
                            </p>
                            <p class="uppercase font-bold leading-none" style="margin-top: 1.15cqw; font-size: 0.98cqw; letter-spacing: 0.24em; color: #4B6358;">
                                {{ $poster['tanggal_pendek'] }}
                            </p>
                        </div>
                    </div>
                @else
                    {{-- PONSEL TENGAH SUNDA HERITAGE: Visual Panggung Hero Priangan (Bingkai Siger, Rumah Panggung & Anggrek) --}}
                    <div
                        class="relative w-full h-full overflow-hidden text-center"
                        style="border-radius: 3.25cqw; background: #3B1414;"
                    >
                        <img
                            src="{{ $asetPosterSunda['heroPoster'] }}"
                            alt="{{ $tema->nama_tema }}"
                            loading="lazy"
                            class="absolute inset-0 w-full h-full object-cover object-center"
                        >

                        {{-- Tipografi Mempelai Tepat di Dalam Bingkai Oval Marun-Emas Siger --}}
                        <div
                            class="absolute z-20 flex flex-col items-center justify-center text-center"
                            style="inset: 19% 15% 38% 15%;"
                        >
                            <p class="uppercase font-bold leading-none drop-shadow-xs" style="font-size: 0.92cqw; letter-spacing: 0.22em; color: #F3E5AB;">
                                Wilujeng Sumping
                            </p>
                            <p class="font-serif-poster font-bold uppercase leading-[1.08] drop-shadow-xs" style="margin-top: 1cqw; font-size: 3.15cqw; letter-spacing: 0.08em; color: #FFFDF8;">
                                {{ $priaPanggilan }}
                            </p>
                            <div class="flex items-center justify-center gap-[0.75cqw]" style="margin: 0.25cqw 0;">
                                <span style="height: 0.14cqw; width: 2.4cqw; background: rgba(231,200,125,0.75);"></span>
                                <span class="font-script leading-none" style="font-size: 2.55cqw; color: #E7C87D;">&amp;</span>
                                <span style="height: 0.14cqw; width: 2.4cqw; background: rgba(231,200,125,0.75);"></span>
                            </div>
                            <p class="font-serif-poster font-bold uppercase leading-[1.08] drop-shadow-xs" style="font-size: 3.15cqw; letter-spacing: 0.08em; color: #FFFDF8;">
                                {{ $wanitaPanggilan }}
                            </p>
                            <p class="uppercase font-semibold leading-none drop-shadow-xs" style="margin-top: 1.25cqw; font-size: 1cqw; letter-spacing: 0.24em; color: #F3E5AB;">
                                {{ $poster['tanggal_pendek'] }}
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @else
        {{-- Panggung 3 Ponsel Mini (Kiri: Save The Date & Akad, Tengah: Sampul Utama, Kanan: Profil Mempelai) --}}
        <div
            class="absolute inset-x-[4.8cqw] z-10 grid grid-cols-3 items-end gap-[2.3cqw]"
            style="bottom: 11.2cqw;"
        >
            {{-- PONSEL KIRI: Save The Date + Countdown + Kartu Acara --}}
            <div
                class="relative w-full bg-[#13161B] shadow-[0_1.5cqw_3cqw_rgba(0,0,0,0.34)] ring-1 ring-white/15"
                style="height: 63.2cqw; border-radius: 3.7cqw; padding: 1.05cqw;"
            >
                <div
                    class="pointer-events-none absolute left-1/2 -translate-x-1/2 z-20 rounded-full bg-[#13161B]"
                    style="top: 1.85cqw; width: 5.8cqw; height: 1.1cqw;"
                ></div>

                <div
                    class="relative w-full h-full overflow-hidden flex flex-col justify-between"
                    style="border-radius: 2.75cqw; background: {{ $poster['layar_kiri_bg'] }}; color: {{ $poster['layar_kiri_teks'] }};"
                >
                    <div class="text-center" style="padding: 3.8cqw 1.6cqw 0;">
                        <svg
                            class="mx-auto opacity-80"
                            style="width: 3.6cqw; height: 3.6cqw;"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.4"
                            aria-hidden="true"
                        >
                            <path d="M12 21c-3.5-2.8-6-5.7-6-9a6 6 0 0 1 12 0c0 3.3-2.5 6.2-6 9Z" />
                            <path d="M12 10.5c1.6-2 4-2.5 5.5-1.5M12 10.5c-1.6-2-4-2.5-5.5-1.5" />
                        </svg>

                        <p class="font-script leading-none" style="margin-top: 0.65cqw; font-size: 3.05cqw;">
                            Save The Date
                        </p>

                        <div class="grid grid-cols-4 gap-[0.65cqw]" style="margin-top: 1.25cqw;">
                            @foreach ([[$hariLagi, 'Hari'], ['08', 'Jam'], ['25', 'Mnt'], ['12', 'Dtk']] as [$angka, $satuan])
                                <div
                                    class="shadow-xs"
                                    style="border-radius: {{ $radiusKotakCountdown }}; padding: 0.55cqw 0.2cqw; background-color: {{ $poster['kotak_countdown_bg'] }}; color: {{ $poster['kotak_countdown_teks'] }};"
                                >
                                    <div class="font-bold leading-none" style="font-size: 1.7cqw;">{{ $angka }}</div>
                                    <div class="opacity-65 leading-none" style="margin-top: 0.25cqw; font-size: 1.05cqw;">{{ $satuan }}</div>
                                </div>
                            @endforeach
                        </div>

                        <p class="opacity-80 leading-tight" style="margin-top: 1.2cqw; font-size: 1.12cqw;">
                            Dengan memohon rahmat &amp; ridho-Nya, kami mengundang Bapak/Ibu hadir di hari bahagia kami.
                        </p>

                        <div
                            class="inline-flex items-center justify-center font-semibold shadow-xs"
                            style="margin-top: 1.05cqw; padding: 0.45cqw 1.8cqw; font-size: 1.18cqw; border-radius: {{ $radiusTombolKiri }}; background-color: {{ $poster['tombol_kiri_bg'] }}; color: {{ $poster['tombol_kiri_teks'] }};"
                        >
                            Simpan ke Kalender
                        </div>
                    </div>

                    {{-- Kartu Acara Bawah (Arch Kubah atau Tajam Editorial) --}}
                    <div
                        class="mx-[1.4cqw] flex flex-col justify-center text-center shadow-md"
                        style="min-height: 21cqw; border-radius: {{ $radiusArchKiri }}; background-color: {{ $poster['kartu_arch_bg'] }}; color: {{ $poster['kartu_arch_teks'] }}; border: 0.22cqw solid {{ $poster['tengah_aksen'] }}38; padding: 4.1cqw 1.4cqw 2.8cqw;"
                    >
                        <p
                            class="{{ $adalahEditorial ? 'font-serif-poster font-bold uppercase tracking-wider' : 'font-script' }} leading-tight truncate"
                            style="font-size: {{ $adalahEditorial ? '2.05cqw' : '2.75cqw' }}; color: {{ $poster['gelap'] ? $poster['tengah_aksen'] : 'inherit' }};"
                        >
                            {{ Str::limit($namaAcaraUtama, 16, '') }}
                        </p>
                        <p class="font-bold uppercase tracking-wider leading-tight" style="margin-top: 0.5cqw; font-size: 1.45cqw;">
                            SABTU, 24 OKT
                        </p>
                        <p class="opacity-75 leading-tight" style="margin-top: 0.35cqw; font-size: 1.15cqw;">
                            08.00 WIB - Selesai
                        </p>
                        <p class="opacity-65 truncate leading-tight" style="margin-top: 0.45cqw; font-size: 1.05cqw;">
                            {{ $tempatAcara }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- PONSEL TENGAH: Sampul Utama Sesuai Latar Tema Nyata --}}
            <div
                class="relative w-full bg-[#13161B] shadow-[0_1.8cqw_3.6cqw_rgba(0,0,0,0.4)] ring-1 ring-white/20"
                style="height: 66cqw; border-radius: 3.8cqw; padding: 1.1cqw;"
            >
                <div
                    class="pointer-events-none absolute left-1/2 -translate-x-1/2 z-20 rounded-full bg-[#13161B]"
                    style="top: 1.9cqw; width: 6cqw; height: 1.15cqw;"
                ></div>

                <div
                    class="relative w-full h-full overflow-hidden flex flex-col items-center justify-center text-center"
                    style="border-radius: 2.85cqw; background: {{ $poster['layar_kiri_bg'] }};"
                >
                    @if ($gambarLatarTemaUrl)
                        <img
                            src="{{ $gambarLatarTemaUrl }}"
                            alt="{{ $tema->nama_tema }}"
                            loading="lazy"
                            class="absolute inset-0 w-full h-full object-cover object-center {{ $adalahEditorial ? 'grayscale' : '' }}"
                        >
                    @endif

                    <div
                        class="absolute inset-0"
                        style="background: {{ $poster['tengah_scrim'] }};"
                    ></div>

                    <div class="relative z-10 w-full" style="padding: 0 2.1cqw; color: {{ $poster['tengah_teks'] }};">
                        @if ($adalahIslami)
                            <p
                                class="leading-none opacity-90"
                                style="font-size: 1.75cqw; color: {{ $poster['tengah_aksen'] }}; margin-bottom: 1.1cqw;"
                            >
                                بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                            </p>
                        @else
                            <div
                                class="mx-auto rounded-full"
                                style="width: 3.4cqw; height: 0.28cqw; background-color: {{ $poster['tengah_aksen'] }}; margin-bottom: 1.35cqw; opacity: 0.78;"
                            ></div>
                        @endif

                        <p
                            class="uppercase font-semibold leading-none"
                            style="font-size: 1.35cqw; letter-spacing: 0.16em; color: {{ $poster['tengah_aksen'] }};"
                        >
                            {{ $poster['tagline'] }}
                        </p>

                        <p
                            class="font-serif-poster font-bold leading-[1.08]"
                            style="margin-top: 1.25cqw; font-size: 3.6cqw;"
                        >
                            {{ $priaPanggilan }}
                        </p>
                        <p
                            class="font-script leading-none"
                            style="margin: 0.3cqw 0; font-size: 2.8cqw; color: {{ $poster['tengah_aksen'] }};"
                        >
                            &amp;
                        </p>
                        <p
                            class="font-serif-poster font-bold leading-[1.08]"
                            style="font-size: 3.6cqw;"
                        >
                            {{ $wanitaPanggilan }}
                        </p>

                        <p
                            class="uppercase font-semibold leading-none opacity-80"
                            style="margin-top: 1.75cqw; font-size: 1.35cqw; letter-spacing: 0.22em;"
                        >
                            {{ $poster['tanggal_pendek'] }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- PONSEL KANAN: We Are Getting Married + Bingkai Oval / Editorial --}}
            <div
                class="relative w-full bg-[#13161B] shadow-[0_1.5cqw_3cqw_rgba(0,0,0,0.34)] ring-1 ring-white/15"
                style="height: 63.2cqw; border-radius: 3.7cqw; padding: 1.05cqw;"
            >
                <div
                    class="pointer-events-none absolute left-1/2 -translate-x-1/2 z-20 rounded-full bg-[#13161B]"
                    style="top: 1.85cqw; width: 5.8cqw; height: 1.1cqw;"
                ></div>

                <div
                    class="relative w-full h-full overflow-hidden flex flex-col items-center justify-between text-center"
                    style="border-radius: 2.75cqw; background-color: {{ $poster['kanan_bg'] }}; color: {{ $poster['kanan_teks'] }}; padding: 3.8cqw 1.6cqw 2.5cqw;"
                >
                    @if ($gambarLatarTemaUrl)
                        <img
                            src="{{ $gambarLatarTemaUrl }}"
                            alt=""
                            aria-hidden="true"
                            loading="lazy"
                            class="pointer-events-none absolute inset-0 w-full h-full object-cover {{ $poster['gelap'] ? 'opacity-20' : 'opacity-12' }} {{ $adalahEditorial ? 'grayscale' : '' }}"
                        >
                    @endif

                    <div class="relative z-10 w-full">
                        <p
                            class="{{ $adalahEditorial ? 'font-serif-poster uppercase tracking-[0.14em] font-semibold' : 'font-script' }} leading-[1.12]"
                            style="font-size: {{ $adalahEditorial ? '1.85cqw' : '2.7cqw' }};"
                        >
                            We Are<br>Getting Married!
                        </p>
                        <p class="opacity-70 leading-tight" style="margin-top: 0.65cqw; font-size: 1.08cqw;">
                            Maha Suci Allah yang telah menciptakan makhluk-Nya berpasang-pasangan.
                        </p>
                    </div>

                    {{-- Bingkai Foto Oval / Persegi Editorial --}}
                    <div
                        class="relative z-10 overflow-hidden shadow-md"
                        style="width: 15.2cqw; height: 22cqw; border-radius: {{ $radiusBingkaiKanan }}; border: 0.38cqw solid {{ $poster['tengah_aksen'] }};"
                    >
                        <img
                            src="{{ $fotoCoupleUrl }}"
                            alt="Pasangan {{ $priaPanggilan }} &amp; {{ $wanitaPanggilan }}"
                            loading="lazy"
                            class="w-full h-full object-cover object-top {{ $adalahEditorial ? 'grayscale' : '' }}"
                        >
                    </div>

                    <div class="relative z-10 w-full">
                        <p
                            class="font-script leading-none"
                            style="font-size: 2.75cqw; color: {{ $poster['tengah_aksen'] }};"
                        >
                            {{ $wanitaPanggilan }}
                        </p>
                        <p class="font-bold truncate leading-tight" style="margin-top: 0.35cqw; font-size: 1.35cqw;">
                            {{ $wanitaLengkap }}
                        </p>
                        <p class="opacity-65 truncate leading-tight" style="margin-top: 0.2cqw; font-size: 1.05cqw;">
                            Putri {{ $wanitaAyah }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
