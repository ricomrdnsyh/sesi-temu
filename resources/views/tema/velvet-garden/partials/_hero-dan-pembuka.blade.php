{{-- SEKSI 1: HERO DIORAMA KONSERVATORI KACA VICTORIAN & KUNANG-KUNANG --}}
<section
    data-diorama-3d="{{ $tierAktif }}"
    class="relative min-h-[96dvh] px-3.5 py-4 flex items-stretch overflow-hidden bg-[#132623]"
>
    <div class="relative w-full min-h-[calc(96dvh-2rem)] rounded-t-[10.5rem] rounded-b-3xl border-2 border-[#C8A464]/65 overflow-hidden shadow-2xl bg-[#0E1E18]">
        <div class="relative w-full h-full flex flex-col justify-between diorama-kamera-3d">
            {{-- Z-0: Latar Taman Senja --}}
            <div class="absolute inset-0 pointer-events-none">
                <img src="{{ $urlFotoLatar }}" alt="Velvet Garden" class="w-full h-full object-cover object-center">
                <div class="absolute inset-0 bg-gradient-to-b from-[#0E1E18]/75 via-[#132623]/32 to-[#0A1712]/90"></div>
            </div>

            {{-- Z-1: Lengkungan Konservatori Kuningan & Mawar Gading --}}
            <div
                class="pointer-events-none absolute inset-x-1 top-2 bottom-2 flex items-center justify-center z-10"
                :class="undanganTerbuka ? 'garden-arch-masuk' : 'opacity-0'"
            >
                <img src="{{ $asetGarden['konservatori'] }}" alt="" class="w-full h-full object-contain opacity-96">
            </div>

            {{-- Z-2: Ranting Pakis Botani Kiri & Kanan Bawah --}}
            <svg aria-hidden="true" viewBox="0 0 110 130" class="pointer-events-none absolute -bottom-2 -left-2 w-24 z-20 opacity-85 garden-daun-kiri">
                <path d="M10 126 C24 84 48 48 92 16" fill="none" stroke="#C8A464" stroke-width="1.6"/>
                <g fill="#2C5248" stroke="#C8A464" stroke-width="0.7">
                    <ellipse cx="26" cy="96" rx="16" ry="6" transform="rotate(-35 26 96)"/>
                    <ellipse cx="44" cy="76" rx="15" ry="5.5" transform="rotate(-42 44 76)"/>
                    <ellipse cx="62" cy="54" rx="13" ry="5" transform="rotate(-46 62 54)"/>
                    <ellipse cx="78" cy="34" rx="10" ry="4" transform="rotate(-50 78 34)"/>
                    <ellipse cx="46" cy="104" rx="14" ry="5" transform="rotate(-12 46 104)"/>
                    <ellipse cx="68" cy="84" rx="12" ry="4.5" transform="rotate(-16 68 84)"/>
                </g>
            </svg>
            <svg aria-hidden="true" viewBox="0 0 110 130" class="pointer-events-none absolute -bottom-2 -right-2 w-24 z-20 opacity-85 garden-daun-kanan">
                <path d="M10 126 C24 84 48 48 92 16" fill="none" stroke="#C8A464" stroke-width="1.6"/>
                <g fill="#2C5248" stroke="#C8A464" stroke-width="0.7">
                    <ellipse cx="26" cy="96" rx="16" ry="6" transform="rotate(-35 26 96)"/>
                    <ellipse cx="44" cy="76" rx="15" ry="5.5" transform="rotate(-42 44 76)"/>
                    <ellipse cx="62" cy="54" rx="13" ry="5" transform="rotate(-46 62 54)"/>
                    <ellipse cx="78" cy="34" rx="10" ry="4" transform="rotate(-50 78 34)"/>
                    <ellipse cx="46" cy="104" rx="14" ry="5" transform="rotate(-12 46 104)"/>
                    <ellipse cx="68" cy="84" rx="12" ry="4.5" transform="rotate(-16 68 84)"/>
                </g>
            </svg>

            {{-- Partikel Kelopak 3D & Kunang-kunang --}}
            @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'kelopak-kunang', 'konteks' => 'utama'])

            {{-- Z-3: Tipografi Tengah Rumah Kaca (Tepat di Ruang Terbuka Lengkungan Konservatori) --}}
            <div class="relative z-20 flex-1 flex flex-col justify-between px-12 pt-32 pb-10 text-center text-[#F4F8F6]">
                <div class="my-auto rounded-3xl bg-[#0E1E18]/62 border border-[#C8A464]/40 px-4 py-5 shadow-xl space-y-2">
                    <img src="{{ $asetGarden['botani'] }}" alt="" class="w-10 mx-auto opacity-95 animasi-ayun-3d">
                    <p class="text-[9px] font-semibold uppercase tracking-[0.24em] text-[#EEDAD4]">
                        Dengan Memohon Rahmat &amp; Ridho-Nya
                    </p>
                    <p class="text-[9px] uppercase tracking-[0.26em] text-[#C8A464]">
                        We Are Getting Married!
                    </p>
                    <h2 class="pt-0.5 font-serif text-3xl sm:text-4xl font-bold leading-[1.08] text-white">
                        {{ $undangan->nama_panggilan_pria }}
                        <span class="block font-kaligrafi text-2xl sm:text-3xl font-normal text-[#EEDAD4] my-0.5">&amp;</span>
                        {{ $undangan->nama_panggilan_wanita }}
                    </h2>
                    <p class="pt-0.5 text-[11px] font-semibold uppercase tracking-[0.28em] text-[#F3DFA2]">
                        {{ $tanggalTitik }}
                    </p>
                    <p class="text-[10px] tracking-[0.14em] text-[#EEDAD4] break-all">
                        {{ $hashtagPasangan }}
                    </p>
                </div>

                <div class="pt-6 space-y-2">
                    <div aria-hidden="true" class="mx-auto w-5 h-8 rounded-full border border-[#EEDAD4]/65 flex justify-center pt-1.5">
                        <span class="w-1 h-1.5 rounded-full bg-[#C8A464] animasi-gulir-roda"></span>
                    </div>
                    <p class="text-[9px] uppercase tracking-[0.34em] text-[#C8A464]/90">Velvet Garden Conservatory</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- BOTANICAL MARQUEE --}}
<div class="py-2.5 bg-[#0E1E18] border-y border-[#C8A464]/45 overflow-hidden">
    <div class="animasi-marquee flex items-center gap-6 text-[10px] font-semibold uppercase tracking-[0.32em] text-[#EEDAD4]">
        @for ($i = 0; $i < 4; $i++)
            <span>Velvet Garden Motion</span>
            <span>&#10047;</span>
            <span>{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</span>
            <span>&#10047;</span>
            <span>{{ $tanggalTitik }}</span>
            <span>&#10047;</span>
            <span>{{ $hashtagPasangan }}</span>
            <span>&#10047;</span>
        @endfor
    </div>
</div>

{{-- SEKSI 2: PRELUDE GREENHOUSE SANCTUARY & FOTO PEMBUKA --}}
<section
    data-section-pembuka="taman"
    class="relative bg-[#132623] px-4 py-12 overflow-hidden"
>
    <div class="max-w-md mx-auto text-center space-y-6">
        <div class="grid grid-cols-3 items-center max-w-[200px] mx-auto">
            <span data-gsap="kiri" class="fx-slide-left font-serif text-4xl sm:text-5xl font-bold text-[#F3DFA2]">
                {{ $undangan->inisialPria() }}
            </span>
            <span data-gsap="mekar" data-gsap-delay="0.07" class="font-kaligrafi text-3xl text-[#EEDAD4]">&amp;</span>
            <span data-gsap="kanan" class="fx-slide-right font-serif text-4xl sm:text-5xl font-bold text-[#F3DFA2]">
                {{ $undangan->inisialWanita() }}
            </span>
        </div>

        @if ($urlFotoPembuka)
            <div data-gsap="potret" class="mx-auto w-56 sm:w-64 p-2 rounded-t-[9rem] rounded-b-3xl bg-[#FDFBF7]/10 border border-[#C8A464]/70 shadow-2xl">
                <div class="overflow-hidden rounded-t-[8.5rem] rounded-b-2xl aspect-[4/5]">
                    <img
                        src="{{ $urlFotoPembuka }}"
                        alt="Foto Pembuka {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                        class="w-full h-full object-cover object-top"
                    >
                </div>
            </div>
        @endif

        @if ($undangan->kutipan_ayat)
            <blockquote class="rounded-3xl bg-[#FDFBF7] text-[#1F3431] border-2 border-[#C8A464]/65 p-6 shadow-xl kartu-3d efek-shimmer-kartu">
                <div data-gsap="turun">
                    <img src="{{ $asetGarden['botani'] }}" alt="" class="w-10 mx-auto mb-2.5 opacity-90 animasi-melayang">
                </div>
                <p data-gsap="naik" data-gsap-delay="0.06" class="italic text-xs sm:text-sm leading-relaxed text-[#1F3431]/85">
                    &ldquo;{{ $undangan->kutipan_ayat }}&rdquo;
                </p>
            </blockquote>
        @endif
    </div>
</section>
