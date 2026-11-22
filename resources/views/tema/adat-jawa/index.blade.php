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
    $urlFotoPenutup = $tanpaFoto ? null : $undangan->urlFotoPenutup();
    $urlFotoLatarCustom = $tanpaFoto ? null : $undangan->urlFotoLatarCustom();
    $urlFotoLatar = $urlFotoLatarCustom ?? $asetJawa['latarHutan'];

    $urutanTier = ['basic' => 1, 'premium' => 2, 'eksklusif' => 3];
    $tierDb = $undangan->tema?->tier ? $undangan->tema->tierKode() : 'premium';
    $tierAktif = ($urutanTier[$tierDb] ?? 2) >= 2 ? $tierDb : 'premium';

    $pengaturan = $undangan->pengaturan ?? [];
    $ceritaList = $pengaturan['cerita_cinta'] ?? [];
    $live = $pengaturan['live_streaming'] ?? [];
    $alamatKado = trim((string) ($pengaturan['alamat_kado_fisik'] ?? ''));
    $instagramPria = $undangan->instagramPria();
    $instagramWanita = $undangan->instagramWanita();
    $dressCodeCatatan = $undangan->dressCodeCatatan();
    $dressCodeWarna = $undangan->dressCodeWarna();
    $adaDressCode = $dressCodeCatatan !== '' || !empty($dressCodeWarna);
    $turutWanita = $undangan->turutMengundangWanita();
    $turutPria = $undangan->turutMengundangPria();
    $adaTurutMengundang = !empty($turutWanita) || !empty($turutPria);

    $fotoGaleriSlideshow = $tanpaFoto
        ? collect()
        : $undangan->daftarGaleri->take(3)->map(static fn($item) => $item->urlFoto())->filter()->values();

    $galeriPanggungKanan = collect();
    if (! $tanpaFoto) {
        $galeriPanggungKanan = $undangan->daftarGaleri
            ->take(3)
            ->map(static fn ($item) => [
                'url' => $item->urlFoto(),
                'keterangan' => (string) ($item->keterangan ?? ''),
            ])
            ->filter(static fn ($item) => ! empty($item['url']))
            ->values();

        if ($galeriPanggungKanan->isEmpty()) {
            foreach ([$urlFotoPembuka, $urlFotoPenutup] as $fotoAlternatif) {
                if (! empty($fotoAlternatif)) {
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

    $tampilBarDemo = !empty($modeDemo) && !request()->boolean('embed');
    $modeDemo = $modeDemo ?? false;
    $modePratinjau = $modePratinjau ?? false;
@endphp

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    @include('komponen-undangan.meta-opengraph')
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap" rel="stylesheet">
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

            {{-- SAMPUL PEMBUKA FADE HALUS --}}
            @include('tema.adat-jawa.partials._sampul')

            {{-- KONTEN UTAMA 13 SEKSI ADAT JAWA KERATON --}}
            <main data-panggung-3d class="panggung-3d relative z-10 {{ $tampilBarDemo ? 'pt-14' : '' }}">
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
