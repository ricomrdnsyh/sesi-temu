{{-- SEKSI 1: HERO ROYAL IVORY FINE-STATIONERY LETTERPRESS & EMBOSSED WAX SEAL (TANPA FOTO) --}}
<div data-kartu-tumpuk class="bg-[#EFE7DA]">
<section
    data-diorama-3d="{{ $tierAktif }}"
    data-hero-royal-letterpress
    class="relative min-h-[96dvh] px-3 py-3.5 flex items-stretch overflow-hidden bg-[#EFE7DA]"
>
    <div class="relative w-full min-h-[calc(96dvh-1.75rem)] rounded-t-[10.5rem] rounded-b-3xl border border-[#9E7B4F]/45 ring-1 ring-[#FBF8F3]/80 overflow-hidden shadow-[0_24px_54px_-18px_rgba(59,46,37,0.34)] bg-[#FBF8F3]">
        <div class="relative w-full h-full flex flex-col justify-between diorama-kamera-3d">
            {{-- Lapisan Latar Lukisan Lengkungan Katedral & Taman Gading dengan Gerak Lensa Halus --}}
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                <img
                    src="{{ $urlFotoLatar }}"
                    alt="Royal Ivory"
                    :class="undanganTerbuka ? 'royal-hero-lensa-masuk' : 'scale-110'"
                    class="w-full h-full object-cover object-center scale-[1.01]"
                >
                {{-- Sapuan Cahaya Gading-Sampanye Hangat (Menjaga Mawar Cat Air & Balustrade Taman Tetap Cerah) --}}
                <div
                    aria-hidden="true"
                    class="absolute inset-0"
                    style="background: linear-gradient(180deg, rgba(251,248,243,0.74) 0%, rgba(251,248,243,0.28) 26%, rgba(251,248,243,0.18) 54%, rgba(246,238,225,0.76) 82%, rgba(239,231,218,0.94) 100%);"
                ></div>
                <div
                    aria-hidden="true"
                    class="absolute inset-0"
                    style="background: radial-gradient(ellipse 64% 52% at 50% 45%, rgba(251,248,243,0.72) 0%, rgba(251,248,243,0.28) 62%, transparent 100%);"
                ></div>
            </div>

            {{-- Bingkai Garis Halus Dalam Mengikuti Lengkungan Katedral --}}
            <div
                aria-hidden="true"
                :class="undanganTerbuka ? 'royal-arch-masuk' : 'opacity-0'"
                class="pointer-events-none absolute inset-2.5 rounded-t-[9.9rem] rounded-b-[1.35rem] border border-[#9E7B4F]/32 z-10"
            ></div>

            @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'katedral-cahaya', 'konteks' => 'utama'])

            {{-- Konten Utama Hero Royal Letterpress --}}
            <div class="relative z-20 flex-1 flex flex-col justify-between items-center px-7 pt-14 sm:pt-16 pb-20 text-center text-[#3B2E25]">
                {{-- Blok Atas: Mahkota Crest & Tajuk Royal --}}
                <div :class="undanganTerbuka ? 'royal-hero-baris-1' : 'opacity-0'" class="space-y-2">
                    <img
                        src="{{ $asetRoyal['katedral'] }}"
                        alt=""
                        aria-hidden="true"
                        class="w-13 mx-auto opacity-95 drop-shadow-[0_3px_8px_rgba(88,67,43,0.2)] animasi-ayun-3d"
                    >
                    <div class="inline-flex items-center gap-2 rounded-full border border-[#9E7B4F]/35 bg-[#FBF8F3]/85 backdrop-blur-xs px-4 py-1 shadow-2xs">
                        <span class="h-1 w-1 rounded-full bg-[#9E7B4F]"></span>
                        <p class="text-[9px] font-bold uppercase tracking-[0.36em] text-[#7B603F]">
                            The Royal Wedding
                        </p>
                        <span class="h-1 w-1 rounded-full bg-[#9E7B4F]"></span>
                    </div>
                    <p class="text-[9.5px] font-medium uppercase tracking-[0.3em] text-[#58432B]/75">
                        We Are Getting Married!
                    </p>
                </div>

                {{-- Blok Tengah: Tipografi Agung Mempelai di Atas Watermark Monogram & Pita Tanggal Berkolom --}}
                <div class="relative my-auto py-4 w-full max-w-[296px] flex flex-col items-center space-y-5">
                    {{-- Watermark Monogram Emboss Halus di Balik Nama --}}
                    <span
                        aria-hidden="true"
                        class="pointer-events-none select-none absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-[58%] font-serif text-[6.5rem] sm:text-[7.2rem] font-bold tracking-[0.06em] text-[#9E7B4F]/[0.11] leading-none whitespace-nowrap"
                    >
                        {{ $undangan->inisialPria() }}{{ $undangan->inisialWanita() }}
                    </span>

                    <div :class="undanganTerbuka ? 'royal-hero-baris-2' : 'opacity-0'" class="relative z-10 space-y-1">
                        <h2 class="font-serif text-[3.1rem] sm:text-[3.45rem] font-bold leading-[0.98] tracking-[0.02em] text-[#2C2119] drop-shadow-[0_1px_0_rgba(255,255,255,0.9)]">
                            <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
                            <span class="my-1.5 flex items-center justify-center gap-3.5" aria-hidden="true">
                                <span class="h-px w-10 bg-gradient-to-r from-transparent to-[#9E7B4F]/70"></span>
                                <span class="font-kaligrafi font-normal text-[2.35rem] text-[#9E7B4F] leading-none">&amp;</span>
                                <span class="h-px w-10 bg-gradient-to-l from-transparent to-[#9E7B4F]/70"></span>
                            </span>
                            <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
                        </h2>
                    </div>

                    {{-- Tanggal Bersih & Minimalis --}}
                    <div :class="undanganTerbuka ? 'royal-hero-kameo' : 'opacity-0'" class="relative z-10 pt-1 space-y-1">
                        <p class="font-serif text-[13.5px] sm:text-sm font-semibold tracking-[0.14em] text-[#58432B]">
                            {{ $tanggalLengkap }}
                        </p>
                        <p class="text-[10px] font-medium uppercase tracking-[0.34em] text-[#9E7B4F]">
                            {{ $tanggalTitik }}
                        </p>
                    </div>
                </div>

                {{-- Blok Bawah: Segel Lilin Perunggu Timbul & Hashtag Pasangan --}}
                <div :class="undanganTerbuka ? 'royal-hero-bawah' : 'opacity-0'" class="w-full max-w-[290px] flex flex-col items-center space-y-2.5">
                    <div class="flex items-center justify-center gap-3 w-full">
                        <span aria-hidden="true" class="h-px flex-1 bg-gradient-to-r from-transparent to-[#9E7B4F]/55"></span>
                        <div
                            :class="undanganTerbuka ? 'royal-hero-segel' : 'opacity-0'"
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-[#B8945F] via-[#8E6C42] to-[#5C4327] border-2 border-[#FAF6EE] shadow-[0_10px_22px_-6px_rgba(59,46,37,0.58)] ring-1 ring-[#9E7B4F]/45 animasi-segel"
                        >
                            <span class="font-serif text-[11px] font-bold tracking-widest text-[#FAF6EE]">
                                {{ $undangan->inisialPria() }}&amp;{{ $undangan->inisialWanita() }}
                            </span>
                        </div>
                        <span aria-hidden="true" class="h-px flex-1 bg-gradient-to-l from-transparent to-[#9E7B4F]/55"></span>
                    </div>

                    <p class="text-[10px] font-semibold uppercase tracking-[0.26em] text-[#58432B]">
                        {{ $hashtagPasangan }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- MARQUEE LETTERPRESS --}}
<div class="py-2.5 bg-[#58432B] border-y border-[#E5C99B]/40 overflow-hidden">
    <div class="animasi-marquee flex items-center gap-6 text-[10px] font-semibold uppercase tracking-[0.34em] text-[#E5C99B]">
        @for ($i = 0; $i < 4; $i++)
            <span>The Royal Wedding</span>
            <span>&#10022;</span>
            <span>{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</span>
            <span>&#10022;</span>
            <span>{{ $tanggalTitik }}</span>
            <span>&#10022;</span>
            <span>{{ $hashtagPasangan }}</span>
            <span>&#10022;</span>
        @endfor
    </div>
</div>
</div>

{{-- SEKSI 2: PRELUDE KARTU SURAT GANDA + FOTO PEMBUKA ROYAL IVORY --}}
<section
    data-kartu-tumpuk
    data-section-pembuka="katedral"
    class="royal-kartu-tumpuk relative bg-[#EFE7DA] px-4 py-12 overflow-hidden"
>
    <div class="max-w-md mx-auto rounded-3xl bg-[#FBF8F3] border border-[#9E7B4F]/50 p-2 shadow-xl">
        <div class="rounded-[1.2rem] border border-dashed border-[#9E7B4F]/45 px-5 py-8 text-center space-y-6">
            <div class="grid grid-cols-3 items-center max-w-[200px] mx-auto">
                <span data-gsap="kiri" class="fx-slide-left font-serif text-4xl sm:text-5xl font-bold text-[#7B603F]">
                    {{ $undangan->inisialPria() }}
                </span>
                <span data-gsap="mekar" data-gsap-delay="0.06" class="font-kaligrafi text-3xl text-[#9E7B4F]">&amp;</span>
                <span data-gsap="kanan" data-gsap-delay="0.08" class="fx-slide-right font-serif text-4xl sm:text-5xl font-bold text-[#7B603F]">
                    {{ $undangan->inisialWanita() }}
                </span>
            </div>

            @if ($urlFotoPembuka)
                <div data-gsap="potret" data-gsap-delay="0.1" class="mx-auto w-56 sm:w-64 p-1.5 rounded-t-[9rem] rounded-b-2xl border-2 border-[#9E7B4F]/55 bg-white shadow-lg">
                    <div class="overflow-hidden rounded-t-[8.5rem] rounded-b-xl aspect-[4/5]">
                        <img src="{{ $urlFotoPembuka }}" alt="Foto Pembuka {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}" class="w-full h-full object-cover object-top">
                    </div>
                </div>
            @endif

            @if ($undangan->kutipan_ayat)
                <blockquote data-gsap="naik" data-gsap-delay="0.06" class="border-t border-double border-[#9E7B4F]/45 pt-5">
                    <p class="italic text-xs sm:text-sm text-[#3B2E25]/85 leading-relaxed">
                        &ldquo;{{ $undangan->kutipan_ayat }}&rdquo;
                    </p>
                </blockquote>
            @endif
        </div>
    </div>
</section>
