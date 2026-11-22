@php
    $footerGelap = (bool) ($gelap ?? false);
    $footerSudutTajam = (bool) ($sudutTajam ?? false);
    $urlLogoFooter = $footerGelap ? asset('logo/logo-gelap.webp') : asset('logo/logo-vertikal.webp');
    $urlWaFooter = \App\Support\PengaturanSesiTemu::urlWaAdmin('Halo Admin Sesi Temu, saya tertarik membuat undangan pernikahan digital.');
    $urlIgFooter = 'https://www.instagram.com/sesitemu.id';
    $urlTiktokFooter = 'https://www.tiktok.com/@sesitemu.id';
    $urlWebFooter = route('beranda');
    $warnaOrnamenFooter = $warnaOrnamen ?? ($footerSudutTajam ? '#FFFFFF' : ($footerGelap ? '#D4AF37' : '#BFA15F'));
    $kelasRadiusKartu = $footerSudutTajam ? 'rounded-none' : 'rounded-2xl';
    $kelasRadiusIkon = $footerSudutTajam ? 'rounded-none' : 'rounded-full';
    $kelasKartuDefault = $footerGelap
        ? 'bg-white/[0.045] backdrop-blur-[2px] shadow-[0_12px_28px_-16px_rgba(0,0,0,0.65)]'
        : 'bg-white/75 backdrop-blur-xs shadow-[0_10px_24px_-14px_rgba(75,99,88,0.25)]';
    $kelasTombolDefault = $footerGelap
        ? 'bg-white/10 text-white/90 border border-white/25 hover:-translate-y-0.5 hover:bg-white hover:text-charcoal'
        : 'bg-white/95 text-[#3A4F45] border border-[#BFA15F]/45 shadow-xs hover:-translate-y-0.5 hover:shadow-md hover:border-[#4B6358] hover:bg-[#4B6358] hover:text-white';
@endphp

<footer class="relative overflow-hidden {{ $kelasLatar ?? 'bg-gradient-to-b from-[#F5EDE1] to-[#EBE0CF] border-t border-[#BFA15F]/35' }} {{ $kelasPadding ?? 'pt-5 pb-6 px-4' }} text-center">
    {{-- Pola Ornamen Geometris Halus --}}
    <svg aria-hidden="true" class="pointer-events-none absolute inset-0 h-full w-full {{ $footerGelap ? 'opacity-[0.085]' : 'opacity-[0.11]' }}" style="color: {{ $warnaOrnamenFooter }};">
        <defs>
            <pattern id="st-footer-lattice" width="28" height="28" patternUnits="userSpaceOnUse">
                <path d="M14 0 L28 14 L14 28 L0 14 Z" fill="none" stroke="currentColor" stroke-width="0.65" />
                <circle cx="14" cy="14" r="1" fill="currentColor" />
            </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#st-footer-lattice)" />
    </svg>

    {{-- Sorotan Kilau Halus Di Bagian Atas Tengah --}}
    <div
        aria-hidden="true"
        class="pointer-events-none absolute -top-10 left-1/2 -translate-x-1/2 h-32 w-72 rounded-full blur-2xl {{ $footerGelap ? 'opacity-[0.18]' : 'opacity-[0.22]' }}"
        style="background: radial-gradient(circle, {{ $warnaOrnamenFooter }} 0%, transparent 72%);"
    ></div>

    {{-- Garis Kilau Tipis Pada Tepi Atas --}}
    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-x-0 top-0 h-[1.5px] opacity-65"
        style="background: linear-gradient(90deg, transparent 0%, {{ $warnaOrnamenFooter }} 50%, transparent 100%);"
    ></div>

    {{-- Kartu Bingkai Ringkas & Berornamen --}}
    <div
        class="relative z-10 max-w-[336px] mx-auto {{ $kelasRadiusKartu }} border px-5 py-4 {{ $kelasKartu ?? $kelasKartuDefault }}"
        style="border-color: color-mix(in srgb, {{ $warnaOrnamenFooter }} {{ $footerGelap ? '30%' : '42%' }}, transparent);"
    >
        {{-- Ornamen Siku Filigree 4 Sudut --}}
        <span aria-hidden="true" class="pointer-events-none absolute top-2 left-2 h-2.5 w-2.5 border-t border-l opacity-60" style="border-color: {{ $warnaOrnamenFooter }};"></span>
        <span aria-hidden="true" class="pointer-events-none absolute top-2 right-2 h-2.5 w-2.5 border-t border-r opacity-60" style="border-color: {{ $warnaOrnamenFooter }};"></span>
        <span aria-hidden="true" class="pointer-events-none absolute bottom-2 left-2 h-2.5 w-2.5 border-b border-l opacity-60" style="border-color: {{ $warnaOrnamenFooter }};"></span>
        <span aria-hidden="true" class="pointer-events-none absolute bottom-2 right-2 h-2.5 w-2.5 border-b border-r opacity-60" style="border-color: {{ $warnaOrnamenFooter }};"></span>

        <div class="flex flex-col items-center">
            {{-- Logo Berteks SesiTemu --}}
            <a
                href="{{ $urlWebFooter }}"
                target="_blank"
                rel="noopener"
                aria-label="Sesi Temu"
                class="inline-flex items-center justify-center group"
            >
                <img
                    src="{{ $urlLogoFooter }}"
                    alt="Logo SesiTemu"
                    class="h-12 sm:h-[52px] w-auto object-contain drop-shadow-[0_2px_8px_rgba(0,0,0,0.22)] transition-transform duration-300 group-hover:scale-[1.04]"
                >
            </a>

            {{-- Teks Kredit --}}
            <p class="mt-2 text-[11.5px] leading-snug tracking-wide {{ $kelasTeks ?? 'text-[#1F2937]/80' }}">
                Made with <span aria-label="cinta" class="inline-block text-rose-500">❤️</span> by
                <a
                    href="{{ $urlWebFooter }}"
                    target="_blank"
                    rel="noopener"
                    class="font-semibold {{ $kelasAksen ?? 'text-[#4B6358]' }} hover:underline underline-offset-4 transition"
                >Sesi Temu</a>
            </p>

            {{-- Pembatas Ornamen Bintang Tipis --}}
            <div aria-hidden="true" class="my-2.5 flex items-center justify-center gap-2 w-36">
                <span class="h-px flex-1 opacity-55" style="background: linear-gradient(90deg, transparent, {{ $warnaOrnamenFooter }});"></span>
                <svg class="h-2.5 w-2.5 shrink-0 opacity-85" viewBox="0 0 16 16" fill="currentColor" style="color: {{ $warnaOrnamenFooter }};">
                    <path d="M8 0.5L9.9 6.1L15.5 8L9.9 9.9L8 15.5L6.1 9.9L0.5 8L6.1 6.1L8 0.5Z" />
                </svg>
                <span class="h-px flex-1 opacity-55" style="background: linear-gradient(90deg, {{ $warnaOrnamenFooter }}, transparent);"></span>
            </div>

            {{-- Ikon Kanal Resmi Sesi Temu --}}
            <nav aria-label="Kanal Resmi Sesi Temu" class="flex items-center justify-center gap-2.5">
                {{-- WhatsApp --}}
                <a
                    href="{{ $urlWaFooter }}"
                    target="_blank"
                    rel="noopener"
                    aria-label="WhatsApp Sesi Temu"
                    title="WhatsApp Sesi Temu"
                    class="inline-flex h-[34px] w-[34px] items-center justify-center {{ $kelasRadiusIkon }} transition duration-200 {{ $kelasTombol ?? $kelasTombolDefault }}"
                >
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M20.52 3.48A11.82 11.82 0 0 0 12.06 0C5.5 0 .16 5.33.16 11.9c0 2.1.55 4.15 1.59 5.95L0 24l6.33-1.66a11.86 11.86 0 0 0 5.73 1.46h.01c6.56 0 11.9-5.34 11.9-11.9 0-3.18-1.24-6.17-3.45-8.42ZM12.07 21.8h-.01a9.86 9.86 0 0 1-5.03-1.38l-.36-.21-3.76.99 1-3.66-.24-.38a9.85 9.85 0 0 1-1.51-5.26c0-5.45 4.44-9.89 9.9-9.89 2.64 0 5.13 1.03 7 2.9a9.82 9.82 0 0 1 2.9 7c0 5.45-4.44 9.89-9.89 9.89Zm5.42-7.41c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07-.3-.15-1.25-.46-2.39-1.47-.88-.79-1.48-1.76-1.65-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.8.37-.27.3-1.04 1.02-1.04 2.48 0 1.46 1.07 2.88 1.22 3.08.15.2 2.1 3.21 5.09 4.5.71.31 1.27.49 1.7.63.72.23 1.37.2 1.88.12.57-.09 1.76-.72 2.01-1.41.25-.7.25-1.29.17-1.41-.07-.12-.27-.2-.57-.35Z"/>
                    </svg>
                </a>

                {{-- Instagram --}}
                <a
                    href="{{ $urlIgFooter }}"
                    target="_blank"
                    rel="noopener"
                    aria-label="Instagram Sesi Temu"
                    title="Instagram @sesitemu.id"
                    class="inline-flex h-[34px] w-[34px] items-center justify-center {{ $kelasRadiusIkon }} transition duration-200 {{ $kelasTombol ?? $kelasTombolDefault }}"
                >
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                        <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                    </svg>
                </a>

                {{-- TikTok --}}
                <a
                    href="{{ $urlTiktokFooter }}"
                    target="_blank"
                    rel="noopener"
                    aria-label="TikTok Sesi Temu"
                    title="TikTok @sesitemu.id"
                    class="inline-flex h-[34px] w-[34px] items-center justify-center {{ $kelasRadiusIkon }} transition duration-200 {{ $kelasTombol ?? $kelasTombolDefault }}"
                >
                    <svg class="w-[15px] h-[15px]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1v-3.5a6.37 6.37 0 0 0-.79-.05A6.34 6.34 0 0 0 3.15 15a6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.34-6.34V8.87a8.16 8.16 0 0 0 4.76 1.52v-3.4a4.85 4.85 0 0 1-1-.3Z"/>
                    </svg>
                </a>

                {{-- Website --}}
                <a
                    href="{{ $urlWebFooter }}"
                    target="_blank"
                    rel="noopener"
                    aria-label="Website Sesi Temu"
                    title="Website Sesi Temu"
                    class="inline-flex h-[34px] w-[34px] items-center justify-center {{ $kelasRadiusIkon }} transition duration-200 {{ $kelasTombol ?? $kelasTombolDefault }}"
                >
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/>
                        <path d="M2 12h20"/>
                    </svg>
                </a>
            </nav>
        </div>
    </div>
</footer>
