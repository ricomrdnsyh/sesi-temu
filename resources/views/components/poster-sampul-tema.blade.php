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
    $namaAcaraUtama = $demo['acara'][0]['nama_acara'] ?? 'Akad Nikah';
    $tempatAcara = $demo['acara'][0]['nama_tempat'] ?? 'Venue Pernikahan';
    $hariLagi = sprintf('%02d', (int) ($demo['hari_lagi'] ?? 21));

    $relatifLatarTema = "aset-tema/{$tema->slug}/latar-utama.webp";
    $gambarLatarTemaUrl = is_file(public_path($relatifLatarTema))
        ? asset($relatifLatarTema)
        : $tema->urlGambarPratinjau();

    $fotoSampulRelatif = $demo['foto_sampul'] ?? 'aset-demo/sampul-rustic.webp';
    $fotoCoupleUrl = \App\Support\MediaPublik::url($fotoSampulRelatif)
        ?? ($gambarLatarTemaUrl ?: asset('aset-demo/mempelai-wanita.webp'));

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
    {{-- Lantai Bawah Ivory Bersih --}}
    <div
        class="absolute inset-x-0 bottom-0 border-t border-black/5"
        style="height: 27%; background-color: {{ $poster['lantai_hex'] }};"
    ></div>

    {{-- Bayangan Lembut di Bawah Ketiga Ponsel --}}
    <div
        class="pointer-events-none absolute inset-x-[6cqw]"
        style="bottom: 9.2cqw; height: 3.6cqw; background: radial-gradient(ellipse at center, rgba(0, 0, 0, 0.24) 0%, rgba(0, 0, 0, 0) 72%);"
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
    <div class="relative z-10 text-center" style="padding: 4.4cqw 7cqw 0;">
        <p class="font-script text-white/95 leading-none drop-shadow-xs" style="font-size: 5.1cqw;">
            SesiTemu.
        </p>
        <p
            class="font-serif-poster font-semibold uppercase text-white truncate drop-shadow-xs"
            style="margin-top: 0.55cqw; font-size: {{ $ukuranJudul }}; line-height: 1.12; letter-spacing: 0.06em;"
        >
            {{ $judulAtas }}
        </p>
    </div>

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
</div>
