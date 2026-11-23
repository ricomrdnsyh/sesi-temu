{{-- SEKSI 1: HERO BOTANICAL SCRAPBOOK LINEN (FULL 1 LAYAR HP + LENGKUNGAN PERGOLA) --}}
<section
    data-diorama-3d="basic"
    class="rustic-hero-layar-penuh {{ $tampilBarDemo ? 'dengan-bar-demo' : '' }} relative flex flex-col px-3.5 py-3.5 sm:px-4 sm:py-4 overflow-hidden bg-gradient-to-b from-[#FDFBF7] via-[#F9F4EC] to-[#EFE6DA]"
>
    <div
        class="rustic-hero-kartu relative flex-1 flex flex-col justify-between w-full rounded-t-[10.5rem] rounded-b-[2rem] border border-[#BFA15F]/60 ring-4 ring-[#BFA15F]/12 overflow-hidden shadow-[0_24px_60px_-18px_rgba(43,60,51,0.36)] bg-[#2F4037]"
        :class="undanganTerbuka ? 'rustic-hero-terbuka' : ''"
    >
        {{-- Latar Lukisan Pergola Botani + Dolly Halus --}}
        <div class="absolute inset-0 pointer-events-none">
            <img
                src="{{ $urlFotoLatar }}"
                alt="Rustic Floral"
                class="w-full h-full object-cover object-center"
                :class="undanganTerbuka ? 'diorama-latar-basic' : ''"
            >
            {{-- Kabut Cahaya Krem Lembut di Tengah Pergola agar Bunga di Tepi Tetap Hidup --}}
            <div
                aria-hidden="true"
                class="absolute inset-0"
                style="background: radial-gradient(ellipse 80% 54% at 50% 44%, rgba(253,251,247,0.93) 0%, rgba(253,251,247,0.78) 44%, rgba(253,251,247,0.28) 74%, transparent 100%);"
            ></div>
            {{-- Gradasi Zamrud-Senja Halus di Bagian Bawah untuk Kontras Tanggal & Scroll Cue --}}
            <div
                aria-hidden="true"
                class="absolute inset-0"
                style="background: linear-gradient(180deg, rgba(253,251,247,0.35) 0%, rgba(253,251,247,0.06) 24%, transparent 56%, rgba(35,51,43,0.68) 84%, rgba(25,38,31,0.93) 100%);"
            ></div>
        </div>

        {{-- Bingkai Lengkung Ganda Fine-Art (Responsif di Semua Rasio Layar HP) --}}
        <div aria-hidden="true" class="pointer-events-none absolute inset-3 rounded-t-[9.75rem] rounded-b-[1.45rem] border border-[#BFA15F]/70 z-10"></div>
        <div aria-hidden="true" class="pointer-events-none absolute inset-[18px] rounded-t-[9.35rem] rounded-b-[1.1rem] border border-dashed border-[#BFA15F]/35 z-10"></div>

        {{-- Mahkota Ranting Botani di Puncak Lengkung --}}
        <div aria-hidden="true" class="pointer-events-none absolute top-5 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2">
            <span class="h-px w-8 bg-gradient-to-r from-transparent to-[#BFA15F]"></span>
            <span class="w-1.5 h-1.5 rounded-full bg-[#4B6358]"></span>
            <span class="w-2.5 h-2.5 rotate-45 bg-[#B86B4B] ring-2 ring-[#FDFBF7]/80"></span>
            <span class="w-1.5 h-1.5 rounded-full bg-[#4B6358]"></span>
            <span class="h-px w-8 bg-gradient-to-l from-transparent to-[#BFA15F]"></span>
        </div>

        <img src="{{ $asetRustic['sudut'] }}" alt="" class="pointer-events-none absolute -top-2 -left-2 w-20 sm:w-24 opacity-80 z-20 animasi-ayun-3d">
        <img src="{{ $asetRustic['sudut'] }}" alt="" class="pointer-events-none absolute -top-2 -right-2 w-20 sm:w-24 opacity-80 z-20 animasi-ayun-3d-balik">

        @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'kelopak', 'konteks' => 'utama'])

        {{-- Komposisi Tipografi Editorial Memenuhi 1 Layar Penuh --}}
        <div class="relative z-20 flex-1 flex flex-col justify-between px-7 pt-16 sm:pt-20 pb-7 sm:pb-8 text-center">
            {{-- Tajuk Pembuka Atas --}}
            <div class="rustic-hero-stagger-1 space-y-2">
                <svg aria-hidden="true" viewBox="0 0 64 20" class="w-14 h-4 mx-auto text-[#BFA15F]" fill="none" stroke="currentColor" stroke-width="1.35" stroke-linecap="round">
                    <path d="M32 14 C25 8, 17 6, 8 9 C15 13, 24 14, 32 14 Z" fill="currentColor" fill-opacity="0.22"/>
                    <path d="M32 14 C39 8, 47 6, 56 9 C49 13, 40 14, 32 14 Z" fill="currentColor" fill-opacity="0.22"/>
                    <circle cx="32" cy="12" r="2" fill="#B86B4B" stroke="none"/>
                </svg>
                <p class="text-[10px] font-bold uppercase tracking-[0.36em] text-[#3F554A]">
                    Undangan Pernikahan
                </p>
                <p class="text-[10.5px] font-semibold uppercase tracking-[0.28em] text-[#B86B4B]">
                    We Are Getting Married!
                </p>
            </div>

            {{-- Fokus Utama Nama Mempelai di Tengah Cahaya Pergola --}}
            <div class="rustic-hero-stagger-2 my-auto py-6 space-y-4">
                <h2 class="font-serif text-[3.15rem] sm:text-[3.55rem] font-bold leading-[1.02] tracking-tight text-[#223029] drop-shadow-[0_2px_16px_rgba(253,251,247,0.95)]">
                    <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
                    <span class="my-1.5 flex items-center justify-center gap-3">
                        <span aria-hidden="true" class="h-px w-10 bg-gradient-to-r from-transparent to-[#BFA15F]/85"></span>
                        <span class="font-kaligrafi text-4xl sm:text-[2.75rem] font-normal text-[#B86B4B] leading-none">&amp;</span>
                        <span aria-hidden="true" class="h-px w-10 bg-gradient-to-l from-transparent to-[#BFA15F]/85"></span>
                    </span>
                    <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
                </h2>

                <div class="inline-flex items-center gap-2.5 rounded-full bg-[#FDFBF7]/85 backdrop-blur-xs border border-[#BFA15F]/45 px-4 py-1.5 shadow-xs">
                    <span aria-hidden="true" class="w-1.5 h-1.5 rotate-45 bg-[#B86B4B]"></span>
                    <p class="text-[10.5px] font-semibold uppercase tracking-[0.24em] text-[#3A4F45]">
                        {{ $tanggalLengkap }}
                    </p>
                    <span aria-hidden="true" class="w-1.5 h-1.5 rotate-45 bg-[#B86B4B]"></span>
                </div>
            </div>

            {{-- Lencana Tanggal, Hashtag & Isyarat Gulir di Bawah --}}
            <div class="rustic-hero-stagger-3 space-y-4">
                <div class="mx-auto inline-flex flex-col items-center gap-1 rounded-2xl bg-[#1E3027]/55 backdrop-blur-md border border-[#E5D5C0]/35 px-6 py-3 shadow-[0_14px_30px_-10px_rgba(0,0,0,0.45)]">
                    <p class="text-xs font-bold uppercase tracking-[0.34em] text-[#F3E5AB]">
                        {{ $tanggalTitik }}
                    </p>
                    <p class="text-[11px] font-medium tracking-[0.2em] text-[#FDFBF7]/92">
                        {{ $hashtagPasangan }}
                    </p>
                </div>

                <div class="flex flex-col items-center gap-1.5 pt-0.5 text-[#E5D5C0]/90" aria-hidden="true">
                    <span class="w-4 h-7 rounded-full border border-[#E5D5C0]/60 flex justify-center pt-1.5">
                        <span class="w-1 h-1.5 rounded-full bg-[#F3E5AB] animasi-gulir-roda"></span>
                    </span>
                    <span class="text-[9px] font-medium uppercase tracking-[0.3em] text-[#FDFBF7]/80">
                        Gulir ke Bawah
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- SEKSI 2: SCRAPBOOK SNAPSHOT WASHI-TAPE + MONOGRAM + AYAT --}}
<section
    data-section-pembuka="klasik"
    class="relative bg-[#3E5349] text-[#FDFBF7] px-5 py-12 overflow-hidden"
>
    <div class="max-w-md mx-auto text-center space-y-6">
        <div class="grid grid-cols-3 items-center max-w-[200px] mx-auto">
            <span data-gsap="kiri" class="fx-slide-left font-serif text-4xl sm:text-5xl font-bold text-[#E5D5C0]">{{ $undangan->inisialPria() }}</span>
            <span data-gsap="mekar" data-gsap-delay="0.07" class="font-kaligrafi text-3xl text-[#BFA15F]">&amp;</span>
            <span data-gsap="kanan" class="fx-slide-right font-serif text-4xl sm:text-5xl font-bold text-[#E5D5C0]">{{ $undangan->inisialWanita() }}</span>
        </div>

        @if ($urlFotoPembuka)
            <div data-gsap="potret" class="mx-auto w-56 sm:w-64">
                <div class="relative bg-white p-2 pb-5 shadow-2xl -rotate-1">
                    <span aria-hidden="true" class="pointer-events-none absolute -top-2.5 left-1/2 -translate-x-1/2 w-20 h-5 bg-[#E5D5C0]/90 rotate-1 shadow-xs"></span>
                    <img src="{{ $urlFotoPembuka }}" alt="Foto Pembuka {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}" class="w-full aspect-[4/5] object-cover object-top">
                    <p class="mt-2 font-kaligrafi text-lg text-[#4B6358]">{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</p>
                </div>
            </div>
        @endif

        @if ($undangan->kutipan_ayat)
            <blockquote data-gsap="naik" class="rounded-2xl bg-[#FDFBF7] text-[#1F2937] border border-[#BFA15F]/45 px-6 py-6 shadow-md kartu-3d">
                <p class="italic text-xs sm:text-sm text-[#1F2937]/85 leading-relaxed">
                    &ldquo;{{ $undangan->kutipan_ayat }}&rdquo;
                </p>
            </blockquote>
        @endif
    </div>
</section>
