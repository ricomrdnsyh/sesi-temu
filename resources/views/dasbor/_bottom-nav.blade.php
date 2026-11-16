@php
    $halamanAktif = $halamanAktif ?? 'undangan';
    $modalBuatOnPage = $modalBuatOnPage ?? false;
@endphp

<nav
    aria-label="Navigasi Utama Client"
    data-client-bottom-nav
    class="md:hidden fixed bottom-0 inset-x-0 z-40 bg-white/95 backdrop-blur-md border-t border-champagne/25 shadow-[0_-8px_28px_-10px_rgba(31,41,55,0.14)] pb-[env(safe-area-inset-bottom)]"
>
    <div class="max-w-lg mx-auto grid grid-cols-4 h-16 px-2 items-center gap-1">
        <a
            href="{{ route('dasbor.index') }}"
            data-client-nav="undangan"
            class="flex flex-col items-center justify-center gap-0.5 py-1 rounded-xl transition {{ $halamanAktif === 'undangan' ? 'text-sage font-bold bg-sage/10' : 'text-charcoal/70 hover:text-sage hover:bg-ivory font-medium' }}"
        >
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <rect width="7" height="9" x="3" y="3" rx="1"/>
                <rect width="7" height="5" x="14" y="3" rx="1"/>
                <rect width="7" height="9" x="14" y="12" rx="1"/>
                <rect width="7" height="5" x="3" y="16" rx="1"/>
            </svg>
            <span class="text-[11px] leading-tight">Undangan</span>
        </a>

        @if ($modalBuatOnPage)
            <button
                type="button"
                @click="modalBuatBaru = true"
                data-client-nav="buat"
                class="flex flex-col items-center justify-center gap-0.5 py-1 rounded-xl text-charcoal/80 hover:text-sage hover:bg-ivory font-semibold transition cursor-pointer"
            >
                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-sage text-white shadow-xs">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="12" x2="12" y1="5" y2="19"/>
                        <line x1="5" x2="19" y1="12" y2="12"/>
                    </svg>
                </span>
                <span class="text-[11px] leading-tight">Buat Draft</span>
            </button>
        @else
            <a
                href="{{ route('dasbor.index', ['buat' => 1]) }}"
                data-client-nav="buat"
                class="flex flex-col items-center justify-center gap-0.5 py-1 rounded-xl text-charcoal/80 hover:text-sage hover:bg-ivory font-semibold transition"
            >
                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-sage text-white shadow-xs">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="12" x2="12" y1="5" y2="19"/>
                        <line x1="5" x2="19" y1="12" y2="12"/>
                    </svg>
                </span>
                <span class="text-[11px] leading-tight">Buat Draft</span>
            </a>
        @endif

        <a
            href="{{ route('beranda') }}#katalog-tema"
            data-client-nav="katalog"
            class="flex flex-col items-center justify-center gap-0.5 py-1 rounded-xl text-charcoal/70 hover:text-sage hover:bg-ivory font-medium transition"
        >
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/>
                <circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/>
                <circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/>
                <circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/>
                <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/>
            </svg>
            <span class="text-[11px] leading-tight">Katalog</span>
        </a>

        <a
            href="{{ route('dasbor.profil.tampil') }}"
            data-client-nav="profil"
            class="flex flex-col items-center justify-center gap-0.5 py-1 rounded-xl transition {{ $halamanAktif === 'profil' ? 'text-sage font-bold bg-sage/10' : 'text-charcoal/70 hover:text-sage hover:bg-ivory font-medium' }}"
        >
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="12" cy="8" r="4"/>
                <path d="M20 21a8 8 0 0 0-16 0"/>
            </svg>
            <span class="text-[11px] leading-tight">Profil</span>
        </a>
    </div>
</nav>
