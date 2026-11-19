@php
    $halamanAktif = $halamanAktif ?? 'beranda';
    $modalBuatOnPage = $modalBuatOnPage ?? false;
@endphp

<nav
    aria-label="Navigasi Utama Client"
    data-client-bottom-nav
    class="md:hidden fixed bottom-0 inset-x-0 z-40 rounded-t-2xl bg-white/96 backdrop-blur-lg border-t border-champagne/25 shadow-[0_-10px_30px_-12px_rgba(31,41,55,0.14)] pb-[env(safe-area-inset-bottom)]"
>
    <div class="max-w-lg mx-auto grid grid-cols-5 h-[66px] px-1.5 items-center">
        <a
            href="{{ route('dashboard.index') }}"
            data-client-nav="beranda"
            class="group relative flex flex-col items-center justify-center gap-1 py-1 active:scale-95 transition-all duration-200 {{ $halamanAktif === 'beranda' ? 'text-sage font-bold' : 'text-charcoal/55 hover:text-sage font-medium' }}"
        >
            @if ($halamanAktif === 'beranda')
                <span class="pointer-events-none absolute -top-1.5 h-1 w-6 rounded-b-full bg-sage"></span>
            @endif
            <span class="inline-flex items-center justify-center rounded-full px-3.5 py-1 transition-all duration-200 {{ $halamanAktif === 'beranda' ? 'bg-sage/15 text-sage ring-1 ring-sage/20 shadow-2xs' : 'group-hover:bg-sage/10 group-hover:text-sage group-hover:-translate-y-0.5' }}">
                <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $halamanAktif === 'beranda' ? '2.2' : '1.9' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
            </span>
            <span class="text-[10px] leading-none transition-colors duration-200 group-hover:font-semibold">Beranda</span>
        </a>

        <a
            href="{{ route('dashboard.undangan.index') }}"
            data-client-nav="undangan"
            class="group relative flex flex-col items-center justify-center gap-1 py-1 active:scale-95 transition-all duration-200 {{ $halamanAktif === 'undangan' ? 'text-sage font-bold' : 'text-charcoal/55 hover:text-sage font-medium' }}"
        >
            @if ($halamanAktif === 'undangan')
                <span class="pointer-events-none absolute -top-1.5 h-1 w-6 rounded-b-full bg-sage"></span>
            @endif
            <span class="inline-flex items-center justify-center rounded-full px-3.5 py-1 transition-all duration-200 {{ $halamanAktif === 'undangan' ? 'bg-sage/15 text-sage ring-1 ring-sage/20 shadow-2xs' : 'group-hover:bg-sage/10 group-hover:text-sage group-hover:-translate-y-0.5' }}">
                <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $halamanAktif === 'undangan' ? '2.2' : '1.9' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect width="20" height="16" x="2" y="4" rx="2" />
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                </svg>
            </span>
            <span class="text-[10px] leading-none transition-colors duration-200 group-hover:font-semibold">Undangan</span>
        </a>

        @if ($modalBuatOnPage)
            <button
                type="button"
                @click="modalBuatBaru = true"
                data-client-nav="buat"
                class="group flex flex-col items-center justify-center gap-1 py-1 text-sage font-bold cursor-pointer active:scale-95 transition-all duration-200"
            >
                <span class="-mt-6 inline-flex h-12 w-12 items-center justify-center rounded-full bg-sage text-white shadow-lg shadow-sage/30 ring-4 ring-white group-hover:-translate-y-1 group-hover:bg-[#3b5047] group-hover:shadow-xl group-hover:shadow-sage/40 group-active:scale-95 transition-all duration-200">
                    <svg class="h-5 w-5 transition-transform duration-200 group-hover:rotate-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="12" x2="12" y1="5" y2="19" />
                        <line x1="5" x2="19" y1="12" y2="12" />
                    </svg>
                </span>
                <span class="text-[10px] leading-none">Buat</span>
            </button>
        @else
            <a
                href="{{ route('dashboard.undangan.index', ['buat' => 1]) }}"
                data-client-nav="buat"
                class="group flex flex-col items-center justify-center gap-1 py-1 text-sage font-bold active:scale-95 transition-all duration-200"
            >
                <span class="-mt-6 inline-flex h-12 w-12 items-center justify-center rounded-full bg-sage text-white shadow-lg shadow-sage/30 ring-4 ring-white group-hover:-translate-y-1 group-hover:bg-[#3b5047] group-hover:shadow-xl group-hover:shadow-sage/40 group-active:scale-95 transition-all duration-200">
                    <svg class="h-5 w-5 transition-transform duration-200 group-hover:rotate-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="12" x2="12" y1="5" y2="19" />
                        <line x1="5" x2="19" y1="12" y2="12" />
                    </svg>
                </span>
                <span class="text-[10px] leading-none">Buat</span>
            </a>
        @endif

        <a
            href="{{ route('dashboard.katalog') }}"
            data-client-nav="katalog"
            class="group relative flex flex-col items-center justify-center gap-1 py-1 active:scale-95 transition-all duration-200 {{ $halamanAktif === 'katalog' ? 'text-sage font-bold' : 'text-charcoal/55 hover:text-sage font-medium' }}"
        >
            @if ($halamanAktif === 'katalog')
                <span class="pointer-events-none absolute -top-1.5 h-1 w-6 rounded-b-full bg-sage"></span>
            @endif
            <span class="inline-flex items-center justify-center rounded-full px-3.5 py-1 transition-all duration-200 {{ $halamanAktif === 'katalog' ? 'bg-sage/15 text-sage ring-1 ring-sage/20 shadow-2xs' : 'group-hover:bg-sage/10 group-hover:text-sage group-hover:-translate-y-0.5' }}">
                <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $halamanAktif === 'katalog' ? '2.2' : '1.9' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="13.5" cy="6.5" r=".5" fill="currentColor" />
                    <circle cx="17.5" cy="10.5" r=".5" fill="currentColor" />
                    <circle cx="8.5" cy="7.5" r=".5" fill="currentColor" />
                    <circle cx="6.5" cy="12.5" r=".5" fill="currentColor" />
                    <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z" />
                </svg>
            </span>
            <span class="text-[10px] leading-none transition-colors duration-200 group-hover:font-semibold">Katalog</span>
        </a>

        <a
            href="{{ route('dashboard.profil.tampil') }}"
            data-client-nav="profil"
            class="group relative flex flex-col items-center justify-center gap-1 py-1 active:scale-95 transition-all duration-200 {{ $halamanAktif === 'profil' ? 'text-sage font-bold' : 'text-charcoal/55 hover:text-sage font-medium' }}"
        >
            @if ($halamanAktif === 'profil')
                <span class="pointer-events-none absolute -top-1.5 h-1 w-6 rounded-b-full bg-sage"></span>
            @endif
            <span class="inline-flex items-center justify-center rounded-full px-3.5 py-1 transition-all duration-200 {{ $halamanAktif === 'profil' ? 'bg-sage/15 text-sage ring-1 ring-sage/20 shadow-2xs' : 'group-hover:bg-sage/10 group-hover:text-sage group-hover:-translate-y-0.5' }}">
                <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $halamanAktif === 'profil' ? '2.2' : '1.9' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="8" r="4" />
                    <path d="M20 21a8 8 0 0 0-16 0" />
                </svg>
            </span>
            <span class="text-[10px] leading-none transition-colors duration-200 group-hover:font-semibold">Profil</span>
        </a>
    </div>
</nav>
