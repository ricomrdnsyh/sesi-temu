@props([
    'undangan',
    'namaTamu',
    'modeDemo' => false,
    'modePratinjau' => false,
    'slugTema' => 'rustic-floral',
    'gelap' => false,
    'gelapSampul' => null,
    'kelasTeksSampul' => null,
    'kelasBody' => 'bg-[#FDFBF7] text-[#1F2937]',
    'kelasAksen' => 'text-[#BFA15F]',
    'kelasSubAksen' => 'text-[#4B6358]',
    'kelasKartu' => 'bg-white/90 backdrop-blur-md border border-[#BFA15F]/35 text-[#1F2937]',
    'kelasTombol' => 'bg-[#4B6358] text-white hover:bg-[#3A4D44]',
    'kelasBadge' => 'bg-[#BFA15F]/15 text-[#BFA15F] border border-[#BFA15F]/30',
    'kelasBatas' => 'border-[#BFA15F]/35',
    'subjudulPanggung' => 'The Wedding Of',
    'taglineSampul' => 'Undangan Pernikahan',
    'sapaanSampul' => 'Kepada Yth. Bapak/Ibu/Saudara/i',
    'sapaanHero' => 'Undangan Pernikahan',
    'labelPutra' => 'Putra dari',
    'labelPutri' => 'Putri dari',
    'labelAcara' => 'Rangkaian Acara',
    'subLabelAcara' => 'Save The Date',
    'labelCerita' => 'Cerita Cinta',
    'subLabelCerita' => 'Kisah Kami',
    'labelGaleri' => 'Potret Kebahagiaan',
    'subLabelGaleri' => 'Galeri Momen',
    'footerTeks' => 'SesiTemu.id',
    'ornamenUrl' => null,
    'efekMotion' => 'kilau',
    'bingkaiFoto' => 'bulat',
    'polaTekstur' => 'floral',
    'modeMonokrom' => false,
    'editionHeader' => null,
])

@php
    $latarUtamaUrl = asset("aset-tema/{$slugTema}/latar-utama.webp");
    $acaraPertama = $undangan->daftarAcara->first();
    $tanggalTitik = $acaraPertama?->tanggal_acara?->format('d . m . Y') ?? now()->format('d . m . Y');
    $hashtagPasangan = '#' . \Illuminate\Support\Str::studly($undangan->nama_panggilan_pria . $undangan->nama_panggilan_wanita) . 'Together';
    $tanpaFoto = $undangan->modeTanpaFoto();

    $polaDataUri = match ($polaTekstur) {
        'batik' => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='64' height='64' viewBox='0 0 64 64'%3E%3Cg fill='none' stroke='%23BFA15F' stroke-opacity='0.14' stroke-width='1'%3E%3Ccircle cx='32' cy='32' r='22'/%3E%3Ccircle cx='0' cy='0' r='22'/%3E%3Ccircle cx='64' cy='0' r='22'/%3E%3Ccircle cx='0' cy='64' r='22'/%3E%3Ccircle cx='64' cy='64' r='22'/%3E%3Ccircle cx='32' cy='32' r='4'/%3E%3C/g%3E%3C/svg%3E",
        'arabesque' => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Cg fill='none' stroke='%23D9B664' stroke-opacity='0.14' stroke-width='1'%3E%3Cpath d='M30 2 L58 30 L30 58 L2 30 Z'/%3E%3Crect x='11' y='11' width='38' height='38'/%3E%3Ccircle cx='30' cy='30' r='6'/%3E%3C/g%3E%3C/svg%3E",
        'deco' => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='56' height='56' viewBox='0 0 56 56'%3E%3Cg fill='none' stroke='%23D4AF37' stroke-opacity='0.12' stroke-width='1'%3E%3Cpath d='M0 28 H56 M28 0 V56'/%3E%3Cpath d='M28 6 L50 28 L28 50 L6 28 Z'/%3E%3C/g%3E%3C/svg%3E",
        'editorial' => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='48' height='48' viewBox='0 0 48 48'%3E%3Cg fill='none' stroke='%2318181B' stroke-opacity='0.06' stroke-width='1'%3E%3Cpath d='M48 0 V48 M0 48 H48'/%3E%3C/g%3E%3C/svg%3E",
        default => "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='72' height='72' viewBox='0 0 72 72'%3E%3Cg fill='none' stroke='%23BFA15F' stroke-opacity='0.12' stroke-width='1'%3E%3Ccircle cx='36' cy='36' r='26'/%3E%3Cpath d='M36 10 Q46 26 36 36 Q26 26 36 10 Z'/%3E%3Cpath d='M36 62 Q46 46 36 36 Q26 46 36 62 Z'/%3E%3Cpath d='M10 36 Q26 26 36 36 Q26 46 10 36 Z'/%3E%3Cpath d='M62 36 Q46 26 36 36 Q46 46 62 36 Z'/%3E%3C/g%3E%3C/svg%3E",
    };

    $sampulGelap = $gelapSampul ?? $gelap;
    $teksSampul = $kelasTeksSampul ?? ($sampulGelap ? 'text-white drop-shadow-md' : 'text-current');

    $overlayPanggung = $sampulGelap
        ? 'bg-gradient-to-t from-black/90 via-black/35 to-black/25'
        : 'bg-gradient-to-t from-black/80 via-black/20 to-transparent';

    $overlaySampul = $sampulGelap
        ? 'bg-gradient-to-b from-black/65 via-black/35 to-black/85'
        : 'bg-gradient-to-b from-[#FFFDF8]/75 via-[#FFFDF8]/20 to-black/50';
@endphp

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    @include('komponen-undangan.meta-opengraph')
</head>
<body
    x-data="temaUndangan()"
    :class="undanganTerbuka ? 'overflow-x-hidden' : 'overflow-hidden h-screen'"
    class="{{ $kelasBody }} antialiased relative"
>
    @include('komponen-undangan.bar-pratinjau-demo')

    <div class="min-h-screen w-full lg:flex">
        {{-- PANGGUNG VISUAL DESKTOP KIRI (FIXED / STICKY SEPERTI TEMUWAKTU.ID) --}}
        <aside class="hidden lg:flex lg:flex-1 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none">
            <img
                src="{{ $latarUtamaUrl }}"
                alt="Ilustrasi {{ $undangan->tema?->nama_tema }}"
                class="absolute inset-0 w-full h-full object-cover object-center animasi-nafas"
            >
            <div class="absolute inset-0 {{ $overlayPanggung }}"></div>

            @if ($ornamenUrl)
                <img src="{{ $ornamenUrl }}" alt="" class="pointer-events-none absolute top-0 left-0 w-36 opacity-50 animasi-goyang">
                <img src="{{ $ornamenUrl }}" alt="" class="pointer-events-none absolute top-0 right-0 w-36 opacity-50 -scale-x-100 animasi-goyang">
            @endif

            {{-- Efek Motion Partikel --}}
            @if ($efekMotion === 'bintang')
                <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden">
                    <span class="absolute top-[16%] left-[18%] w-2 h-2 rounded-full bg-[#F3E5AB] animasi-bintang"></span>
                    <span class="absolute top-[25%] right-[22%] w-2.5 h-2.5 rounded-full bg-[#D9B664] animasi-bintang" style="animation-delay: 0.9s;"></span>
                    <span class="absolute top-[42%] left-[44%] w-1.5 h-1.5 rounded-full bg-white/90 animasi-bintang" style="animation-delay: 1.7s;"></span>
                    <span class="absolute top-[30%] left-[65%] w-2 h-2 rounded-full bg-[#D9B664] animasi-bintang" style="animation-delay: 2.3s;"></span>
                </div>
            @elseif ($efekMotion === 'kelopak')
                <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden">
                    <span class="absolute top-[18%] left-[16%] w-3 h-3 rounded-full bg-[#EEDAD4]/55 blur-[1px] animasi-melayang"></span>
                    <span class="absolute top-[35%] right-[24%] w-3.5 h-3.5 rounded-full bg-[#C8A464]/55 blur-[1px] animasi-melayang" style="animation-delay: 1.3s;"></span>
                    <span class="absolute top-[52%] left-[32%] w-2.5 h-2.5 rounded-full bg-[#EEDAD4]/60 animasi-melayang" style="animation-delay: 2.1s;"></span>
                </div>
            @endif

            <div class="relative z-10 w-full flex flex-col justify-end p-10 xl:p-14 text-white">
                <div class="max-w-xl space-y-2.5">
                    <p class="text-xs font-semibold uppercase tracking-[0.4em] text-[#F3E5AB]">
                        {{ $subjudulPanggung }}
                    </p>
                    <h2 class="font-serif text-5xl xl:text-6xl font-bold leading-tight drop-shadow-lg">
                        {{ $undangan->nama_panggilan_pria }}
                        <span class="font-kaligrafi font-normal text-[#F3E5AB]">&amp;</span>
                        {{ $undangan->nama_panggilan_wanita }}
                    </h2>
                    <div class="flex flex-wrap items-center gap-4 pt-1 text-xs uppercase tracking-[0.25em] text-white/85">
                        <span>{{ $tanggalTitik }}</span>
                        <span class="w-1 h-1 rounded-full bg-[#F3E5AB]"></span>
                        <span>{{ $hashtagPasangan }}</span>
                    </div>
                </div>
            </div>
        </aside>

        {{-- KOLOM UNDANGAN MOBILE-FIRST PORTRAIT (KANAN PADA DESKTOP, FULLSCREEN PADA HP) --}}
        <div class="w-full lg:w-[445px] xl:w-[475px] shrink-0 min-h-screen relative overflow-x-clip shadow-2xl border-l {{ $kelasBatas }}">
            {{-- Lapisan Tekstur Budaya/Botani Di Balik Konten Scroll --}}
            <div
                aria-hidden="true"
                class="pointer-events-none fixed top-0 bottom-0 right-0 w-full lg:w-[445px] xl:w-[475px] z-0"
                style="background-image: url(&quot;{{ $polaDataUri }}&quot;); background-repeat: repeat;"
            ></div>
            <img
                src="{{ $latarUtamaUrl }}"
                alt=""
                aria-hidden="true"
                class="pointer-events-none fixed top-0 bottom-0 right-0 w-full lg:w-[445px] xl:w-[475px] h-full object-cover {{ $gelap ? 'opacity-15' : 'opacity-10' }} z-0"
            >

            {{-- Ornamen Sudut Bergerak --}}
            @if ($ornamenUrl)
                <img src="{{ $ornamenUrl }}" alt="" class="pointer-events-none fixed top-10 lg:left-auto lg:right-[325px] xl:right-[355px] left-0 w-24 sm:w-28 opacity-45 z-20 animasi-goyang">
                <img src="{{ $ornamenUrl }}" alt="" class="pointer-events-none fixed bottom-0 right-0 w-24 sm:w-28 opacity-45 z-20 rotate-180 animasi-goyang">
            @endif

            {{-- COVER GATE TERILUSTRASI (MENUTUPI KOLOM UNDANGAN HINGGA TOMBOL DIKLIK) --}}
            <section
                class="fixed inset-0 lg:left-auto lg:w-[445px] xl:w-[475px] z-40 flex flex-col justify-between overflow-hidden transition-transform duration-1000 ease-in-out {{ !empty($modeDemo) ? 'pt-14' : '' }}"
                :style="undanganTerbuka ? 'transform: translateY(-100%); pointer-events: none;' : 'transform: translateY(0);'"
            >
                <img
                    src="{{ $latarUtamaUrl }}"
                    alt="Sampul {{ $undangan->tema?->nama_tema }}"
                    class="absolute inset-0 w-full h-full object-cover object-center"
                >
                <div class="absolute inset-0 {{ $overlaySampul }}"></div>

                @if ($efekMotion === 'bintang')
                    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden">
                        <span class="absolute top-[14%] left-[18%] w-2 h-2 rounded-full bg-[#D9B664] animasi-bintang"></span>
                        <span class="absolute top-[24%] right-[16%] w-2.5 h-2.5 rounded-full bg-[#F3E5AB] animasi-bintang" style="animation-delay: 0.9s;"></span>
                        <span class="absolute bottom-[32%] left-[12%] w-1.5 h-1.5 rounded-full bg-[#D9B664] animasi-bintang" style="animation-delay: 1.8s;"></span>
                    </div>
                @elseif ($efekMotion === 'kelopak')
                    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden">
                        <span class="absolute top-[16%] left-[14%] w-2.5 h-2.5 rounded-full bg-[#EEDAD4]/60 blur-[1px] animasi-melayang"></span>
                        <span class="absolute top-[30%] right-[16%] w-3 h-3 rounded-full bg-[#C8A464]/55 blur-[1px] animasi-melayang" style="animation-delay: 1.2s;"></span>
                    </div>
                @endif

                {{-- Bagian Atas Cover: Judul & Nama Mempelai di Area Langit Ilustrasi --}}
                <div class="relative z-10 px-6 pt-8 sm:pt-10 text-center space-y-2.5">
                    @if ($editionHeader)
                        <div class="flex items-center justify-between text-[10px] uppercase tracking-[0.28em] opacity-75 border-b {{ $kelasBatas }} pb-2 mb-3">
                            <span>Vol. 01</span>
                            <span>{{ $editionHeader }}</span>
                            <span>{{ $acaraPertama?->tanggal_acara?->format('Y') ?? now()->format('Y') }}</span>
                        </div>
                    @endif

                    <p class="text-[11px] font-semibold uppercase tracking-[0.35em] {{ $sampulGelap ? 'text-[#F3E5AB]' : $kelasSubAksen }}">
                        {{ $taglineSampul }}
                    </p>

                    <h1 class="font-serif text-4xl sm:text-5xl font-bold leading-tight {{ $teksSampul }}">
                        {{ $undangan->nama_panggilan_pria }}
                        <span class="block font-kaligrafi text-3xl sm:text-4xl font-normal my-0.5 {{ $sampulGelap ? 'text-[#F3E5AB]' : $kelasAksen }}">&amp;</span>
                        {{ $undangan->nama_panggilan_wanita }}
                    </h1>

                    <p class="text-[11px] uppercase tracking-[0.28em] {{ $sampulGelap ? 'text-white/80' : $teksSampul.' opacity-80' }}">
                        {{ $hashtagPasangan }} &bull; {{ $tanggalTitik }}
                    </p>
                </div>

                {{-- Bagian Bawah Cover: Kotak Tamu Frosted + Tombol Buka Undangan --}}
                <div class="relative z-10 px-6 pb-8 sm:pb-10">
                    <div class="rounded-3xl p-5 sm:p-6 text-center backdrop-blur-md shadow-2xl border {{ $sampulGelap ? 'bg-black/60 border-[#D4AF37]/45 text-white' : 'bg-white/88 border-[#BFA15F]/45 text-[#1F2937]' }} space-y-3">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.28em] opacity-70">{{ $sapaanSampul }}</p>
                        <p class="font-serif text-xl sm:text-2xl font-bold {{ $sampulGelap ? 'text-[#F3E5AB]' : $kelasSubAksen }}">
                            Kepada Yth. {{ $namaTamu }}
                        </p>
                        <p class="text-[11px] opacity-75">Tanpa mengurangi rasa hormat, kami mengundang Anda untuk hadir di hari bahagia kami.</p>

                        <div class="pt-1">
                            <button
                                type="button"
                                @click="bukaUndangan()"
                                class="w-full sm:w-auto rounded-full px-8 py-3 text-xs sm:text-sm font-bold uppercase tracking-[0.18em] shadow-lg transition cursor-pointer {{ $kelasTombol }}"
                            >
                                Buka Undangan
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            {{-- KONTEN UTAMA UNDANGAN (SCROLLABLE DALAM BINGKAI PORTRAIT) --}}
            <main class="relative z-10 {{ !empty($modeDemo) ? 'pt-14' : '' }}">
                {{-- Hero Pembuka dengan Jendela Lengkung Ilustrasi Tema --}}
                <section data-aos="fade-up" data-aos-duration="1000" class="px-5 pt-6 pb-10">
                    <div class="relative h-[28rem] sm:h-[31rem] rounded-t-[10rem] rounded-b-3xl overflow-hidden border-2 {{ $kelasBatas }} shadow-2xl">
                        <img
                            src="{{ $latarUtamaUrl }}"
                            alt="Hero {{ $undangan->tema?->nama_tema }}"
                            class="absolute inset-0 w-full h-full object-cover object-center"
                        >
                        <div class="absolute inset-0 {{ $overlaySampul }}"></div>
                        <div class="relative z-10 h-full flex flex-col justify-between p-6 text-center">
                            <div class="pt-8 space-y-1.5">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.3em] {{ $sampulGelap ? 'text-[#F3E5AB]' : $kelasSubAksen }}">
                                    {{ $sapaanHero }}
                                </p>
                                <h2 class="font-serif text-4xl sm:text-5xl font-bold leading-tight {{ $teksSampul }}">
                                    {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
                                </h2>
                                <p class="text-xs uppercase tracking-[0.25em] {{ $sampulGelap ? 'text-white/80' : $teksSampul.' opacity-80' }}">
                                    {{ $tanggalTitik }}
                                </p>
                            </div>

                            <div class="mx-auto w-14 h-14 rounded-full backdrop-blur-md border {{ $kelasBatas }} {{ $sampulGelap ? 'bg-black/45 text-[#F3E5AB]' : 'bg-white/85 text-[#1F2937]' }} flex items-center justify-center animasi-kilau">
                                <span class="font-serif text-sm font-bold tracking-widest">{{ $undangan->inisialPria() }}&amp;{{ $undangan->inisialWanita() }}</span>
                            </div>
                        </div>
                    </div>

                    @if ($undangan->kutipan_ayat)
                        <blockquote class="mt-6 rounded-2xl p-6 shadow-md text-center italic text-xs sm:text-sm leading-relaxed {{ $kelasKartu }}">
                            "{{ $undangan->kutipan_ayat }}"
                        </blockquote>
                    @endif
                </section>

                {{-- Divider Ornamen --}}
                <div class="flex items-center justify-center gap-3 px-10 opacity-70">
                    <span class="h-px flex-1 border-t {{ $kelasBatas }}"></span>
                    <span class="text-xs font-serif {{ $kelasAksen }}">&#10022; &bull; &#10022;</span>
                    <span class="h-px flex-1 border-t {{ $kelasBatas }}"></span>
                </div>

                {{-- Profil Kedua Mempelai (Ditata Vertikal Anggun Dalam Viewport Portrait) --}}
                <section data-aos="fade-up" data-aos-duration="1000" class="py-10 px-5 space-y-6">
                    {{-- Mempelai Pria --}}
                    <div data-aos="fade-up" data-aos-duration="1000" class="rounded-3xl p-6 sm:p-7 text-center shadow-lg {{ $kelasKartu }}">
                        @if (! $tanpaFoto && $undangan->urlFotoPria())
                            <img
                                src="{{ $undangan->urlFotoPria() }}"
                                alt="{{ $undangan->nama_lengkap_pria }}"
                                class="mx-auto object-cover ring-4 {{ $kelasBatas }} {{ $bingkaiFoto === 'katedral' ? 'w-36 h-44 rounded-t-full rounded-b-2xl' : ($bingkaiFoto === 'kotak-editorial' ? 'w-40 h-48 grayscale hover:grayscale-0 transition duration-700' : 'w-36 h-36 rounded-full') }}"
                            >
                        @else
                            <div class="mx-auto flex items-center justify-center border-2 {{ $kelasBatas }} {{ $bingkaiFoto === 'katedral' ? 'w-28 h-32 rounded-t-full rounded-b-2xl' : ($bingkaiFoto === 'kotak-editorial' ? 'w-28 h-32' : 'w-28 h-28 rounded-full') }} {{ $gelap ? 'bg-black/35' : 'bg-white/60' }}">
                                <span class="font-serif text-4xl font-bold {{ $kelasAksen }}">{{ $undangan->inisialPria() }}</span>
                            </div>
                        @endif

                        <p class="mt-4 text-[10px] font-semibold uppercase tracking-[0.3em] {{ $kelasAksen }}">Mempelai Pria</p>
                        <h3 class="mt-1 font-serif text-2xl sm:text-3xl font-bold">{{ $undangan->nama_lengkap_pria }}</h3>
                        @if ($undangan->nama_ayah_pria || $undangan->nama_ibu_pria)
                            <p class="mt-1.5 text-xs opacity-75">{{ $labelPutra }} {{ $undangan->nama_ayah_pria }} &amp; {{ $undangan->nama_ibu_pria }}</p>
                        @endif
                    </div>

                    <div class="text-center">
                        <span class="font-kaligrafi text-4xl {{ $kelasAksen }}">&amp;</span>
                    </div>

                    {{-- Mempelai Wanita --}}
                    <div data-aos="fade-up" data-aos-duration="1000" class="rounded-3xl p-6 sm:p-7 text-center shadow-lg {{ $kelasKartu }}">
                        @if (! $tanpaFoto && $undangan->urlFotoWanita())
                            <img
                                src="{{ $undangan->urlFotoWanita() }}"
                                alt="{{ $undangan->nama_lengkap_wanita }}"
                                class="mx-auto object-cover ring-4 {{ $kelasBatas }} {{ $bingkaiFoto === 'katedral' ? 'w-36 h-44 rounded-t-full rounded-b-2xl' : ($bingkaiFoto === 'kotak-editorial' ? 'w-40 h-48 grayscale hover:grayscale-0 transition duration-700' : 'w-36 h-36 rounded-full') }}"
                            >
                        @else
                            <div class="mx-auto flex items-center justify-center border-2 {{ $kelasBatas }} {{ $bingkaiFoto === 'katedral' ? 'w-28 h-32 rounded-t-full rounded-b-2xl' : ($bingkaiFoto === 'kotak-editorial' ? 'w-28 h-32' : 'w-28 h-28 rounded-full') }} {{ $gelap ? 'bg-black/35' : 'bg-white/60' }}">
                                <span class="font-serif text-4xl font-bold {{ $kelasAksen }}">{{ $undangan->inisialWanita() }}</span>
                            </div>
                        @endif

                        <p class="mt-4 text-[10px] font-semibold uppercase tracking-[0.3em] {{ $kelasAksen }}">Mempelai Wanita</p>
                        <h3 class="mt-1 font-serif text-2xl sm:text-3xl font-bold">{{ $undangan->nama_lengkap_wanita }}</h3>
                        @if ($undangan->nama_ayah_wanita || $undangan->nama_ibu_wanita)
                            <p class="mt-1.5 text-xs opacity-75">{{ $labelPutri }} {{ $undangan->nama_ayah_wanita }} &amp; {{ $undangan->nama_ibu_wanita }}</p>
                        @endif
                    </div>
                </section>

                {{-- Hitung Mundur & Google Calendar --}}
                @include('komponen-undangan.hitung-mundur', [
                    'kelasAksen' => $kelasAksen,
                    'kelasKartu' => $kelasKartu,
                    'kelasTombol' => $kelasTombol,
                ])

                {{-- Rangkaian Acara --}}
                @if ($undangan->daftarAcara->isNotEmpty())
                <section data-aos="fade-up" data-aos-duration="1000" class="py-10 px-5">
                    <div class="text-center mb-6">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.28em] {{ $kelasAksen }}">{{ $subLabelAcara }}</p>
                        <h2 class="mt-1.5 font-serif text-3xl font-bold">{{ $labelAcara }}</h2>
                    </div>

                    <div class="space-y-5">
                        @foreach ($undangan->daftarAcara as $acara)
                            <div data-aos="zoom-in" data-aos-duration="1000" class="rounded-3xl p-6 text-center shadow-lg space-y-2.5 {{ $kelasKartu }}">
                                <h3 class="font-serif text-2xl font-bold {{ $kelasAksen }}">{{ $acara->nama_acara }}</h3>
                                <p class="text-sm font-semibold">{{ $acara->tanggal_acara->translatedFormat('l, d F Y') }}</p>
                                <p class="text-xs font-semibold {{ $kelasAksen }}">
                                    {{ substr($acara->waktu_mulai, 0, 5) }}
                                    @if ($acara->waktu_selesai) - {{ substr($acara->waktu_selesai, 0, 5) }} @endif
                                    {{ $acara->zona_waktu }}
                                </p>
                                <div class="pt-2 border-t {{ $kelasBatas }}">
                                    <p class="font-semibold text-sm">{{ $acara->nama_tempat }}</p>
                                    <p class="text-xs opacity-75 mt-1">{{ $acara->alamat_lengkap }}</p>
                                </div>
                                @if ($acara->link_maps)
                                    <a href="{{ $acara->link_maps }}" target="_blank" rel="noopener" class="inline-block mt-2 rounded-full px-6 py-2 text-xs font-semibold transition {{ $kelasTombol }}">
                                        Buka Google Maps
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
                @endif

                {{-- Cerita Cinta --}}
                @php $ceritaList = $undangan->pengaturan['cerita_cinta'] ?? []; @endphp
                @if ($undangan->fiturAktif('cerita_cinta') && !empty($ceritaList))
                <section data-aos="fade-up" data-aos-duration="1000" class="py-10 px-5">
                    <div class="text-center mb-6">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.28em] {{ $kelasAksen }}">{{ $subLabelCerita }}</p>
                        <h2 class="mt-1.5 font-serif text-3xl font-bold">{{ $labelCerita }}</h2>
                    </div>

                    <div class="space-y-4">
                        @foreach ($ceritaList as $cerita)
                            <div data-aos="fade-up" data-aos-duration="1000" class="rounded-2xl p-5 shadow-md {{ $kelasKartu }}">
                                <div class="flex items-center justify-between gap-2">
                                    <h3 class="font-serif text-lg font-bold">{{ $cerita['judul'] ?? '' }}</h3>
                                    <span class="rounded-full px-3 py-0.5 text-[11px] font-semibold {{ $kelasBadge }}">{{ $cerita['tanggal'] ?? '' }}</span>
                                </div>
                                <p class="mt-2 text-xs sm:text-sm opacity-80 leading-relaxed">{{ $cerita['cerita'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>
                @endif

                {{-- Galeri Foto --}}
                @if (! $tanpaFoto && $undangan->fiturAktif('galeri') && $undangan->daftarGaleri->isNotEmpty())
                <section data-aos="fade-up" data-aos-duration="1000" class="py-10 px-5">
                    <div class="text-center mb-6">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.28em] {{ $kelasAksen }}">{{ $subLabelGaleri }}</p>
                        <h2 class="mt-1.5 font-serif text-3xl font-bold">{{ $labelGaleri }}</h2>
                    </div>

                    <div class="grid grid-cols-2 gap-3.5">
                        @foreach ($undangan->daftarGaleri as $galeri)
                            <button
                                type="button"
                                data-aos="zoom-in"
                                data-aos-duration="1000"
                                @click="bukaGaleri(@js($galeri->urlFoto()), @js($galeri->keterangan))"
                                class="group overflow-hidden border {{ $kelasBatas }} cursor-pointer {{ $bingkaiFoto === 'katedral' ? 'aspect-[4/5] rounded-t-[3rem] rounded-b-2xl' : 'aspect-square rounded-2xl' }}"
                            >
                                <img
                                    src="{{ $galeri->urlFoto() }}"
                                    alt="{{ $galeri->keterangan ?? 'Galeri' }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-700 {{ $modeMonokrom ? 'grayscale group-hover:grayscale-0' : '' }}"
                                >
                            </button>
                        @endforeach
                    </div>
                </section>
                @endif

                {{-- Live Streaming, Amplop Digital & Buku Tamu --}}
                @include('komponen-undangan.amplop-dan-tamu', [
                    'kelasAksen' => $kelasAksen,
                    'kelasKartu' => $kelasKartu,
                    'kelasTombol' => $kelasTombol,
                ])

                <footer class="py-8 px-4 text-center text-xs opacity-80">
                    <img
                        src="{{ asset('aset-demo/logo-sesi-temu-ikon.webp') }}"
                        alt="Logo SesiTemu"
                        class="mx-auto mb-2 h-7 w-7 rounded-lg bg-[#FBF3E6]/90 p-0.5 object-contain"
                    >
                    {{ $footerTeks }} &bull; <a href="{{ route('beranda') }}" class="font-semibold {{ $kelasAksen }} hover:underline">SesiTemu.id</a>
                </footer>
            </main>
        </div>
    </div>

    @include('komponen-undangan.pemutar-musik')
    @include('komponen-undangan.modal-galeri')
    @include('komponen-undangan.skrip-tema')
</body>
</html>
