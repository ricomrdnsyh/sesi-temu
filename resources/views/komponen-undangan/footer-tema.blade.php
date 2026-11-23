@php
    $footerGelap = (bool) ($gelap ?? false);
    $footerSudutTajam = (bool) ($sudutTajam ?? false);
    $urlLogoFooter = $footerGelap ? asset('logo/logo-gelap.webp') : asset('logo/logo-vertikal.webp');
    $urlWaFooter = \App\Support\PengaturanSesiTemu::urlWaAdmin('Halo Admin Sesi Temu, saya tertarik membuat undangan pernikahan digital.');
    $urlIgFooter = 'https://www.instagram.com/sesitemu.id';
    $urlTiktokFooter = 'https://www.tiktok.com/@sesitemu.id';
    $urlWebFooter = route('beranda');
    $warnaOrnamenFooter = $warnaOrnamen ?? ($footerSudutTajam ? '#FFFFFF' : ($footerGelap ? '#D4AF37' : '#BFA15F'));
    $kelasRadiusIkon = $footerSudutTajam ? 'rounded-none' : 'rounded-full';
    $kelasTombolDefault = $footerGelap
        ? 'bg-white/10 text-white/90 border border-white/25 hover:-translate-y-0.5 hover:bg-white hover:text-charcoal'
        : 'bg-white/95 text-[#3A4F45] border border-[#BFA15F]/45 shadow-xs hover:-translate-y-0.5 hover:shadow-md hover:border-[#4B6358] hover:bg-[#4B6358] hover:text-white';
@endphp

<footer class="relative overflow-hidden {{ $kelasLatar ?? 'bg-gradient-to-b from-[#F5EDE1] to-[#EBE0CF] border-t border-[#BFA15F]/35' }} {{ $kelasPadding ?? 'pt-7 pb-8 px-5' }} text-center">
    {{-- Garis Kilau Tipis & Permata Tunggal di Tepi Atas (Bersih Tanpa Kotak / Pola Ramai) --}}
    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-x-0 top-0 h-px opacity-75"
        style="background: linear-gradient(90deg, transparent 8%, {{ $warnaOrnamenFooter }} 50%, transparent 92%);"
    ></div>
    <span
        aria-hidden="true"
        class="pointer-events-none absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 h-2 w-2 rotate-45 opacity-90"
        style="background-color: {{ $warnaOrnamenFooter }}; box-shadow: 0 0 12px {{ $warnaOrnamenFooter }};"
    ></span>

    {{-- Pendar Ambien Sangat Lembut di Belakang Logo --}}
    <div
        aria-hidden="true"
        class="pointer-events-none absolute -top-12 left-1/2 -translate-x-1/2 h-36 w-72 rounded-full blur-3xl {{ $footerGelap ? 'opacity-[0.13]' : 'opacity-[0.18]' }}"
        style="background: radial-gradient(circle, {{ $warnaOrnamenFooter }} 0%, transparent 72%);"
    ></div>

    {{-- Konten Footer Kolofon Minimalis & Elegan --}}
    <div class="fx-rise relative z-10 max-w-xs mx-auto py-2.5 flex flex-col items-center">
        {{-- Logo Resmi SesiTemu --}}
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
                loading="lazy"
                decoding="async"
                class="h-11 sm:h-12 w-auto object-contain drop-shadow-[0_2px_10px_rgba(0,0,0,0.2)] transition-transform duration-300 group-hover:scale-[1.04]"
            >
        </a>

        {{-- Tagline Studio Tipis --}}
        <p class="mt-2 text-[9px] font-medium uppercase tracking-[0.34em] opacity-60 {{ $kelasTeks ?? 'text-[#1F2937]/80' }}">
            Digital Invitation Website
        </p>

        {{-- Bar Ikon Kanal Resmi --}}
        <nav aria-label="Kanal Resmi Sesi Temu" class="mt-4 flex items-center justify-center gap-2.5">
            {{-- WhatsApp --}}
            <a
                href="{{ $urlWaFooter }}"
                target="_blank"
                rel="noopener"
                aria-label="WhatsApp Sesi Temu"
                title="WhatsApp Sesi Temu"
                class="inline-flex h-9 w-9 items-center justify-center {{ $kelasRadiusIkon }} transition duration-200 {{ $kelasTombol ?? $kelasTombolDefault }}"
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
                class="inline-flex h-9 w-9 items-center justify-center {{ $kelasRadiusIkon }} transition duration-200 {{ $kelasTombol ?? $kelasTombolDefault }}"
            >
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
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
                class="inline-flex h-9 w-9 items-center justify-center {{ $kelasRadiusIkon }} transition duration-200 {{ $kelasTombol ?? $kelasTombolDefault }}"
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
                class="inline-flex h-9 w-9 items-center justify-center {{ $kelasRadiusIkon }} transition duration-200 {{ $kelasTombol ?? $kelasTombolDefault }}"
            >
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/>
                    <path d="M2 12h20"/>
                </svg>
            </a>
        </nav>

        {{-- Garis Pembatas Halus & Kredit Penutup --}}
        <div
            aria-hidden="true"
            class="mt-4 mb-3 h-px w-28 opacity-40"
            style="background: linear-gradient(90deg, transparent, {{ $warnaOrnamenFooter }}, transparent);"
        ></div>

        <p class="inline-flex items-center justify-center gap-1 text-[11px] leading-snug tracking-wide {{ $kelasTeks ?? 'text-[#1F2937]/80' }}">
            <span>Made with</span>
            <svg
                class="w-3 h-3 shrink-0"
                viewBox="0 0 24 24"
                fill="currentColor"
                aria-label="cinta"
                style="color: {{ $warnaOrnamenFooter }};"
            >
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>
            <span>by</span>
            <a
                href="{{ $urlWebFooter }}"
                target="_blank"
                rel="noopener"
                class="font-semibold {{ $kelasAksen ?? 'text-[#4B6358]' }} hover:underline underline-offset-4 transition"
            >Sesi Temu</a>
        </p>
    </div>
</footer>
