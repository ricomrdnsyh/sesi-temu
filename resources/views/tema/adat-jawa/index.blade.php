@php
    $asetJawa = [
        'latarHutan' => asset('aset-tema/adat-jawa/latar-hutan-jawa.webp'),
        'pendopo' => asset('aset-tema/adat-jawa/pendopo-joglo.webp'),
        'gununganBuka' => asset('aset-tema/adat-jawa/gunungan-pembuka.webp'),
        'bingkaiUkiran' => asset('aset-tema/adat-jawa/bingkai-ukiran.webp'),
        'janur' => asset('aset-tema/adat-jawa/janur-kuning.webp'),
        'sayapWayang' => asset('aset-tema/adat-jawa/sayap-wayang.webp'),
        'bungaDepan' => asset('aset-tema/adat-jawa/bunga-depan.webp'),
        'bungaLili' => asset('aset-tema/adat-jawa/bunga-lili.webp'),
        'kawungAtas' => asset('aset-tema/adat-jawa/motif-kawung-atas.webp'),
        'kawungBawah' => asset('aset-tema/adat-jawa/motif-kawung-bawah.webp'),
        'gununganKecil' => asset('aset-tema/adat-jawa/ornamen-gunungan.webp'),
        'videoHero' => asset('aset-tema/adat-jawa/jawa-motion-hero.mp4?v=2'),
    ];

    $acaraPertama = $undangan->daftarAcara->first();
    $tanggalTitik = $acaraPertama?->tanggal_acara?->format('d . m . y') ?? now()->format('d . m . y');
    $tanggalLengkap = $acaraPertama?->tanggal_acara
        ? $acaraPertama->tanggal_acara->locale('id')->translatedFormat('l, d F Y')
        : now()->locale('id')->translatedFormat('l, d F Y');
    $hashtagPasangan = $undangan->hashtagPasangan();

    $tanpaFoto = $undangan->modeTanpaFoto();
    $urlFotoSampul = $tanpaFoto ? null : $undangan->urlFotoSampul();
    $pakaiFotoSampul = !$tanpaFoto && !empty($urlFotoSampul);
    $urlFotoPembuka = $tanpaFoto ? null : $undangan->urlFotoPembuka();
    $daftarUrlFotoHitungMundur = $tanpaFoto ? [] : $undangan->daftarUrlFotoHitungMundur();
    $urlFotoHitungMundur = $daftarUrlFotoHitungMundur[0] ?? null;
    $urlFotoPenutup = $tanpaFoto ? null : $undangan->urlFotoPenutup();
    $urlFotoLatarCustom = $tanpaFoto ? null : $undangan->urlFotoLatarCustom();
    $urlFotoLatar = $urlFotoLatarCustom ?? $asetJawa['latarHutan'];

    $urutanTier = ['basic' => 1, 'premium' => 2, 'eksklusif' => 3];
    $tierDb = $undangan->tema?->tier ? $undangan->tema->tierKode() : 'premium';
    $tierAktif = ($urutanTier[$tierDb] ?? 2) >= 2 ? $tierDb : 'premium';

    $pengaturan = $undangan->pengaturan ?? [];
    $ceritaList = $pengaturan['cerita_cinta'] ?? [];
    $live = $pengaturan['live_streaming'] ?? [];
    $live['aktif'] = $undangan->fiturAktif('live_streaming');
    $alamatKado = trim((string) ($pengaturan['alamat_kado_fisik'] ?? ''));
    $instagramPria = $undangan->instagramPria();
    $instagramWanita = $undangan->instagramWanita();
    $dressCodeCatatan = $undangan->dressCodeCatatan();
    $dressCodeWarna = $undangan->dressCodeWarna();
    $adaDressCode = $undangan->fiturAktif('dress_code') && ($dressCodeCatatan !== '' || !empty($dressCodeWarna));
    $turutWanita = $undangan->turutMengundangWanita();
    $turutPria = $undangan->turutMengundangPria();
    $adaTurutMengundang = $undangan->fiturAktif('turut_mengundang') && (!empty($turutWanita) || !empty($turutPria));

    $fotoGaleriSlideshow = collect();
    if (!$tanpaFoto && $undangan->fiturAktif('hitung_mundur')) {
        if (!empty($daftarUrlFotoHitungMundur)) {
            $fotoGaleriSlideshow = collect($daftarUrlFotoHitungMundur)->values();
        } elseif ($modeDemo) {
            $fotoGaleriSlideshow = $undangan->daftarGaleri
                ->take(3)
                ->map(static fn($item) => $item->urlFoto())
                ->filter()
                ->values();
        }
    }

    $galeriPanggungKanan = collect();
    if (!$tanpaFoto) {
        $galeriPanggungKanan = $undangan->daftarGaleri
            ->take(3)
            ->map(
                static fn($item) => [
                    'url' => $item->urlFoto(),
                    'keterangan' => (string) ($item->keterangan ?? ''),
                ],
            )
            ->filter(static fn($item) => !empty($item['url']))
            ->values();

        if ($galeriPanggungKanan->isEmpty()) {
            foreach ([$urlFotoPembuka, $urlFotoPenutup] as $fotoAlternatif) {
                if (!empty($fotoAlternatif)) {
                    $galeriPanggungKanan->push([
                        'url' => $fotoAlternatif,
                        'keterangan' => "{$undangan->nama_panggilan_pria} & {$undangan->nama_panggilan_wanita}",
                    ]);
                }
            }
        }
    }

    $isoTarget = null;
    $googleCalUrl = null;
    if ($acaraPertama) {
        $offset = match ($acaraPertama->zona_waktu) {
            'WITA' => '+08:00',
            'WIT' => '+09:00',
            default => '+07:00',
        };
        $tanggalStr = $acaraPertama->tanggal_acara->format('Y-m-d');
        $waktuMulai = substr($acaraPertama->waktu_mulai, 0, 8);
        if (strlen($waktuMulai) === 5) {
            $waktuMulai .= ':00';
        }
        $isoTarget = "{$tanggalStr}T{$waktuMulai}{$offset}";

        $tz = match ($acaraPertama->zona_waktu) {
            'WITA' => 'Asia/Makassar',
            'WIT' => 'Asia/Jayapura',
            default => 'Asia/Jakarta',
        };
        $mulaiUtc = \Illuminate\Support\Carbon::parse("{$tanggalStr} {$waktuMulai}", $tz)->utc();
        $selesaiUtc = $acaraPertama->waktu_selesai
            ? \Illuminate\Support\Carbon::parse("{$tanggalStr} " . $acaraPertama->waktu_selesai, $tz)->utc()
            : $mulaiUtc->copy()->addHours(2);

        $googleCalUrl =
            'https://calendar.google.com/calendar/render?action=TEMPLATE' .
            '&text=' .
            urlencode(
                "Pernikahan {$undangan->nama_panggilan_pria} & {$undangan->nama_panggilan_wanita} ({$acaraPertama->nama_acara})",
            ) .
            '&dates=' .
            $mulaiUtc->format('Ymd\THis\Z') .
            '/' .
            $selesaiUtc->format('Ymd\THis\Z') .
            '&details=' .
            urlencode(
                "Undangan Pernikahan {$undangan->nama_lengkap_pria} & {$undangan->nama_lengkap_wanita} via SesiTemu.id",
            ) .
            '&location=' .
            urlencode($acaraPertama->nama_tempat . ', ' . $acaraPertama->alamat_lengkap);
    }

    $daftarUcapanAwal = $undangan->bukuTamu
        ->values()
        ->map(
            static fn($ucapan, int $idx) => [
                'id' => 'awal-' . ($ucapan->id ?? $idx + 1),
                'nama_tamu' => (string) $ucapan->nama_tamu,
                'status_kehadiran' => (string) $ucapan->status_kehadiran,
                'jumlah_tamu' => (int) ($ucapan->jumlah_tamu ?? 1),
                'ucapan_doa' => (string) $ucapan->ucapan_doa,
                'waktu' => $ucapan->created_at ? $ucapan->created_at->locale('id')->diffForHumans() : 'Baru saja',
            ],
        )
        ->all();

    $tampilBarDemo = false;
    $modeDemo = $modeDemo ?? false;
    $modePratinjau = $modePratinjau ?? false;
@endphp

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    @include('komponen-undangan.meta-opengraph')
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Hero Video Motion Pas 1 Layar HP & Desktop Anti-Zoom */
        .jawa-hero-layar-penuh {
            height: 100svh;
            height: 100dvh;
            min-height: 520px;
        }

        .jawa-hero-layar-penuh.dengan-bar-demo {
            height: calc(100svh - 3.5rem);
            height: calc(100dvh - 3.5rem);
        }

        html.desktop-triptych [data-kolom-undangan] .jawa-hero-layar-penuh,
        html.tablet-stage [data-kolom-undangan] .jawa-hero-layar-penuh {
            height: var(--tinggi-tirai-dalam-inv, 100dvh) !important;
            min-height: var(--tinggi-tirai-dalam-inv, 100dvh) !important;
        }

        /* Transisi Sampul Scroll-Ke-Atas 60fps GPU-Composited Menyatu Langsung Ke Video Motion */
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

        .tirai-fade-halus.tirai-gulir-atas>div {
            box-shadow: 0 28px 56px -10px rgba(24, 12, 6, 0.65);
        }

        .tirai-fade-halus.tirai-gulir-atas.tirai-terbuka {
            opacity: 1;
            transform: translate3d(0, -105%, 0);
            visibility: hidden;
            transition:
                transform 0.9s cubic-bezier(0.32, 0.72, 0, 1),
                visibility 0s linear 0.92s;
        }

        /* Hentikan animasi sampul saat tirai tergulir naik agar GPU fokus 100% ke video hero */
        .tirai-fade-halus.tirai-terbuka *,
        .tirai-fade-halus.tirai-terbuka *::before,
        .tirai-fade-halus.tirai-terbuka *::after {
            animation-play-state: paused !important;
        }

        /* === ANIMASI SAMPUL FULL-BLEED ROYAL KERATON (ADAT JAWA 60FPS) === */
        .jawa-mask-kawung-atas {
            -webkit-mask-image: linear-gradient(180deg, rgba(0, 0, 0, 0.9) 18%, rgba(0, 0, 0, 0.25) 68%, transparent 100%);
            mask-image: linear-gradient(180deg, rgba(0, 0, 0, 0.9) 18%, rgba(0, 0, 0, 0.25) 68%, transparent 100%);
        }

        .jawa-mask-kawung-bawah {
            -webkit-mask-image: linear-gradient(0deg, rgba(0, 0, 0, 0.9) 18%, rgba(0, 0, 0, 0.25) 68%, transparent 100%);
            mask-image: linear-gradient(0deg, rgba(0, 0, 0, 0.9) 18%, rgba(0, 0, 0, 0.25) 68%, transparent 100%);
        }

        @keyframes jawaSampulMasuk {
            0% {
                opacity: 0;
                transform: translate3d(0, 16px, 0) scale(0.98);
            }

            100% {
                opacity: 1;
                transform: translate3d(0, 0, 0) scale(1);
            }
        }

        @keyframes jawaSayapSampul {

            0%,
            100% {
                transform: rotate(3deg) translate3d(0, 0, 0);
            }

            50% {
                transform: rotate(-4deg) translate3d(3px, -5px, 0);
            }
        }

        @keyframes jawaSinarKeraton {

            0%,
            100% {
                opacity: 0.14;
                transform: translate3d(-10%, 0, 0) rotate(-18deg);
            }

            50% {
                opacity: 0.34;
                transform: translate3d(12%, 0, 0) rotate(-14deg);
            }
        }

        @keyframes jawaTombolKilau {

            0%,
            25% {
                transform: translate3d(-140%, 0, 0) skewX(-20deg);
            }

            60%,
            100% {
                transform: translate3d(260%, 0, 0) skewX(-20deg);
            }
        }

        @keyframes jawaGarisCahaya {

            0%,
            100% {
                opacity: 0.55;
                transform: scaleX(0.92);
            }

            50% {
                opacity: 1;
                transform: scaleX(1);
            }
        }

        .jawa-masuk-1 {
            animation: jawaSampulMasuk 0.75s cubic-bezier(0.22, 1, 0.36, 1) 0.08s both;
        }

        .jawa-masuk-2 {
            animation: jawaSampulMasuk 0.85s cubic-bezier(0.22, 1, 0.36, 1) 0.22s both;
        }

        .jawa-masuk-3 {
            animation: jawaSampulMasuk 0.85s cubic-bezier(0.22, 1, 0.36, 1) 0.38s both;
        }

        .jawa-sayap-sampul {
            transform-origin: 22% 78%;
            animation: jawaSayapSampul 7.2s ease-in-out infinite;
            will-change: transform;
        }

        .jawa-sinar-keraton {
            animation: jawaSinarKeraton 10.5s ease-in-out infinite;
            will-change: transform, opacity;
        }

        .jawa-garis-cahaya {
            animation: jawaGarisCahaya 5.5s ease-in-out infinite;
            will-change: transform, opacity;
        }

        .jawa-tombol-kilau::after {
            content: "";
            position: absolute;
            inset: 0;
            width: 42%;
            background: linear-gradient(90deg, transparent, rgba(255, 250, 232, 0.48), transparent);
            pointer-events: none;
            animation: jawaTombolKilau 4.6s ease-in-out infinite;
        }

        /* Nonaktifkan goyang 3D kamera saat video aktif agar video terkomposisi mulus di hardware GPU */
        .diorama-kamera-3d.jawa-kamera-video-aktif {
            animation: none !important;
            transform-style: flat !important;
            transform: none !important;
        }

        /* Kemunculan Tipografi Mempelai Tepat Di Dalam Bingkai Emas Video */
        .jawa-video-teks {
            transition:
                opacity 1.15s cubic-bezier(0.22, 1, 0.36, 1),
                transform 1.15s cubic-bezier(0.22, 1, 0.36, 1);
            will-change: opacity, transform;
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

            .jawa-masuk-1,
            .jawa-masuk-2,
            .jawa-masuk-3,
            .jawa-sayap-sampul,
            .jawa-sinar-keraton,
            .jawa-garis-cahaya,
            .jawa-tombol-kilau::after {
                animation: none !important;
                opacity: 1;
            }
        }
    </style>
</head>

<body x-data="temaUndangan()" :class="undanganTerbuka ? 'overflow-x-hidden' : 'overflow-hidden h-screen'"
    class="bg-[#2B180F] text-[#332012] antialiased relative">
    @include('komponen-undangan.bar-pratinjau-demo')

    <div data-tata-letak-tema class="min-h-screen w-full lg:flex">
        {{-- PANGGUNG VISUAL DESKTOP KIRI (DIORAMA KERATON JAWA 3D) --}}
        @include('tema.adat-jawa.partials._panggung-desktop')

        {{-- KOLOM UNDANGAN PORTRAIT MOBILE-FIRST (TERPUSAT DI TENGAH WEB) --}}
        <div data-kolom-undangan
            class="w-full lg:w-[460px] xl:w-[490px] shrink-0 min-h-screen relative overflow-x-clip shadow-[0_0_70px_rgba(0,0,0,0.5)] lg:border-x border-[#D7BB83]/40 bg-[#472A1C]">
            {{-- Progres Baca Emas di Atas --}}
            <div data-progres-undangan aria-hidden="true" x-show="undanganTerbuka" x-cloak
                class="fixed top-0 inset-x-0 mx-auto w-full lg:w-[460px] xl:w-[490px] z-[60] h-[3px] bg-black/20">
                <div class="h-full transition-all duration-150 bg-gradient-to-r from-[#8E6B23] via-[#D7BB83] to-[#F3E5AB]"
                    :style="'width: ' + scrollPersen + '%'"></div>
            </div>

            {{-- JENDELA DIORAMA LATAR TERPIN (TERLIHAT DI ANTARA SEKSI KAPSUL & KARTU SEPERTI JAVA HERITAGE) --}}
            <div data-latar-undangan aria-hidden="true"
                class="pointer-events-none fixed inset-y-0 inset-x-0 mx-auto w-full lg:w-[460px] xl:w-[490px] z-0 overflow-hidden bg-[#D9C3B0]">
                <div data-latar-zoom class="relative w-full h-full overflow-hidden">
                    <img src="{{ $urlFotoLatar }}" alt=""
                        class="w-full h-full object-cover object-center scale-105">
                    <img src="{{ $asetJawa['janur'] }}" alt=""
                        class="absolute bottom-[16%] -left-8 w-36 opacity-85">
                    <img src="{{ $asetJawa['janur'] }}" alt=""
                        class="absolute bottom-[16%] -right-8 w-36 opacity-85 -scale-x-100">
                    <img src="{{ $asetJawa['pendopo'] }}" alt=""
                        class="absolute bottom-[7%] left-1/2 -translate-x-1/2 w-[84%] max-w-[380px] opacity-92">
                    <img src="{{ $asetJawa['bungaDepan'] }}" alt=""
                        class="absolute bottom-0 inset-x-0 w-full object-cover">
                </div>
            </div>

            {{-- INTRO PEMBUKA BESPOKE SEBELUM SAMPUL --}}
            @include('komponen-undangan.intro-pembuka')

            {{-- SAMPUL PEMBUKA FADE HALUS --}}
            @include('tema.adat-jawa.partials._sampul')

            {{-- KONTEN UTAMA 13 SEKSI ADAT JAWA KERATON --}}
            <main data-panggung-3d data-sinema-gsap="jawa"
                class="panggung-3d relative z-10 {{ $tampilBarDemo ? 'pt-14' : '' }}">
                @include('tema.adat-jawa.partials._hero-diorama')
                @include('tema.adat-jawa.partials._konten-utama')
                @include('tema.adat-jawa.partials._penutup-dan-rsvp')
            </main>
        </div>

        {{-- PANGGUNG VISUAL DESKTOP KANAN (KEEPSAKE KERATON JAWA) --}}
        @include('tema.adat-jawa.partials._panggung-desktop-kanan')
    </div>

    @include('komponen-undangan.kontrol-sinema')
    @include('komponen-undangan.pemutar-musik')
    @include('komponen-undangan.modal-galeri')
    @include('komponen-undangan.skrip-tema')
</body>

</html>
