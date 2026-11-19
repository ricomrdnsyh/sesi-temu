@props([
    'halaman' => 'beranda',
    'dalamBeranda' => false,
])

<nav
    aria-label="Navigasi Mobile Beranda"
    data-landing-bottom-nav
    class="md:hidden fixed bottom-0 inset-x-0 z-40 rounded-t-2xl bg-white/96 backdrop-blur-lg border-t border-champagne/25 shadow-[0_-10px_30px_-12px_rgba(31,41,55,0.14)] pb-[env(safe-area-inset-bottom)]"
>
    <div class="max-w-lg mx-auto grid grid-cols-5 h-[66px] px-1.5 items-center">
        {{-- 1. Beranda --}}
        @if ($dalamBeranda)
            <button
                type="button"
                @click="bukaTabMobile('beranda')"
                :class="tabMobile === 'beranda' ? 'text-sage font-bold' : 'text-charcoal/55 hover:text-sage font-medium'"
                class="group relative flex flex-col items-center justify-center gap-1 py-1 active:scale-95 transition-all duration-200 cursor-pointer"
            >
                <span x-show="tabMobile === 'beranda'" x-cloak class="pointer-events-none absolute -top-1.5 h-1 w-6 rounded-b-full bg-sage"></span>
                <span
                    :class="tabMobile === 'beranda' ? 'bg-sage/15 text-sage ring-1 ring-sage/20 shadow-2xs' : 'group-hover:bg-sage/10 group-hover:text-sage group-hover:-translate-y-0.5'"
                    class="inline-flex items-center justify-center rounded-full px-3.5 py-1 transition-all duration-200"
                >
                    <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" :stroke-width="tabMobile === 'beranda' ? '2.2' : '1.9'" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                </span>
                <span class="text-[10px] leading-none transition-colors duration-200 group-hover:font-semibold">Beranda</span>
            </button>
        @else
            <a
                href="{{ route('beranda') }}"
                class="group relative flex flex-col items-center justify-center gap-1 py-1 active:scale-95 transition-all duration-200 {{ $halaman === 'beranda' ? 'text-sage font-bold' : 'text-charcoal/55 hover:text-sage font-medium' }}"
            >
                @if ($halaman === 'beranda')
                    <span class="pointer-events-none absolute -top-1.5 h-1 w-6 rounded-b-full bg-sage"></span>
                @endif
                <span class="inline-flex items-center justify-center rounded-full px-3.5 py-1 transition-all duration-200 {{ $halaman === 'beranda' ? 'bg-sage/15 text-sage ring-1 ring-sage/20 shadow-2xs' : 'group-hover:bg-sage/10 group-hover:text-sage group-hover:-translate-y-0.5' }}">
                    <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $halaman === 'beranda' ? '2.2' : '1.9' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                </span>
                <span class="text-[10px] leading-none transition-colors duration-200 group-hover:font-semibold">Beranda</span>
            </a>
        @endif

        {{-- 2. Tema --}}
        @if ($dalamBeranda)
            <button
                type="button"
                @click="bukaTabMobile('tema')"
                :class="tabMobile === 'tema' ? 'text-sage font-bold' : 'text-charcoal/55 hover:text-sage font-medium'"
                class="group relative flex flex-col items-center justify-center gap-1 py-1 active:scale-95 transition-all duration-200 cursor-pointer"
            >
                <span x-show="tabMobile === 'tema'" x-cloak class="pointer-events-none absolute -top-1.5 h-1 w-6 rounded-b-full bg-sage"></span>
                <span
                    :class="tabMobile === 'tema' ? 'bg-sage/15 text-sage ring-1 ring-sage/20 shadow-2xs' : 'group-hover:bg-sage/10 group-hover:text-sage group-hover:-translate-y-0.5'"
                    class="inline-flex items-center justify-center rounded-full px-3.5 py-1 transition-all duration-200"
                >
                    <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" :stroke-width="tabMobile === 'tema' ? '2.2' : '1.9'" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="13.5" cy="6.5" r=".5" fill="currentColor" />
                        <circle cx="17.5" cy="10.5" r=".5" fill="currentColor" />
                        <circle cx="8.5" cy="7.5" r=".5" fill="currentColor" />
                        <circle cx="6.5" cy="12.5" r=".5" fill="currentColor" />
                        <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z" />
                    </svg>
                </span>
                <span class="text-[10px] leading-none transition-colors duration-200 group-hover:font-semibold">Tema</span>
            </button>
        @else
            <a
                href="{{ route('beranda', ['tab' => 'tema']) }}"
                class="group relative flex flex-col items-center justify-center gap-1 py-1 active:scale-95 transition-all duration-200 text-charcoal/55 hover:text-sage font-medium"
            >
                <span class="inline-flex items-center justify-center rounded-full px-3.5 py-1 transition-all duration-200 group-hover:bg-sage/10 group-hover:text-sage group-hover:-translate-y-0.5">
                    <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="13.5" cy="6.5" r=".5" fill="currentColor" />
                        <circle cx="17.5" cy="10.5" r=".5" fill="currentColor" />
                        <circle cx="8.5" cy="7.5" r=".5" fill="currentColor" />
                        <circle cx="6.5" cy="12.5" r=".5" fill="currentColor" />
                        <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z" />
                    </svg>
                </span>
                <span class="text-[10px] leading-none transition-colors duration-200 group-hover:font-semibold">Tema</span>
            </a>
        @endif

        {{-- 3. Buat (Tombol Tengah Mengambang Identik dengan Dashboard Client) --}}
        @if ($dalamBeranda)
            <button
                type="button"
                @click="sheetBuatTerbuka = true"
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
                href="{{ auth()->check() ? route('dashboard.katalog') : route('daftar') }}"
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

        {{-- 4. Paket (Harga, Fitur & FAQ) --}}
        @if ($dalamBeranda)
            <button
                type="button"
                @click="bukaTabMobile('paket')"
                :class="tabMobile === 'paket' ? 'text-sage font-bold' : 'text-charcoal/55 hover:text-sage font-medium'"
                class="group relative flex flex-col items-center justify-center gap-1 py-1 active:scale-95 transition-all duration-200 cursor-pointer"
            >
                <span x-show="tabMobile === 'paket'" x-cloak class="pointer-events-none absolute -top-1.5 h-1 w-6 rounded-b-full bg-sage"></span>
                <span
                    :class="tabMobile === 'paket' ? 'bg-sage/15 text-sage ring-1 ring-sage/20 shadow-2xs' : 'group-hover:bg-sage/10 group-hover:text-sage group-hover:-translate-y-0.5'"
                    class="inline-flex items-center justify-center rounded-full px-3.5 py-1 transition-all duration-200"
                >
                    <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" :stroke-width="tabMobile === 'paket' ? '2.2' : '1.9'" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z" />
                        <path d="M7 7h.01" />
                    </svg>
                </span>
                <span class="text-[10px] leading-none transition-colors duration-200 group-hover:font-semibold">Paket</span>
            </button>
        @else
            <a
                href="{{ route('beranda', ['tab' => 'paket']) }}"
                class="group relative flex flex-col items-center justify-center gap-1 py-1 active:scale-95 transition-all duration-200 text-charcoal/55 hover:text-sage font-medium"
            >
                <span class="inline-flex items-center justify-center rounded-full px-3.5 py-1 transition-all duration-200 group-hover:bg-sage/10 group-hover:text-sage group-hover:-translate-y-0.5">
                    <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z" />
                        <path d="M7 7h.01" />
                    </svg>
                </span>
                <span class="text-[10px] leading-none transition-colors duration-200 group-hover:font-semibold">Paket</span>
            </a>
        @endif

        {{-- 5. Masuk / Akun --}}
        <a
            href="{{ auth()->check() ? (auth()->user()->adalahAdmin() ? '/admin' : '/dashboard') : route('login') }}"
            class="group relative flex flex-col items-center justify-center gap-1 py-1 active:scale-95 transition-all duration-200 {{ $halaman === 'masuk' ? 'text-sage font-bold' : 'text-charcoal/55 hover:text-sage font-medium' }}"
        >
            @if ($halaman === 'masuk')
                <span class="pointer-events-none absolute -top-1.5 h-1 w-6 rounded-b-full bg-sage"></span>
            @endif
            <span class="inline-flex items-center justify-center rounded-full px-3.5 py-1 transition-all duration-200 {{ $halaman === 'masuk' ? 'bg-sage/15 text-sage ring-1 ring-sage/20 shadow-2xs' : 'group-hover:bg-sage/10 group-hover:text-sage group-hover:-translate-y-0.5' }}">
                <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $halaman === 'masuk' ? '2.2' : '1.9' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="8" r="4" />
                    <path d="M20 21a8 8 0 0 0-16 0" />
                </svg>
            </span>
            <span class="text-[10px] leading-none transition-colors duration-200 group-hover:font-semibold">
                @auth
                    {{ auth()->user()->adalahAdmin() ? 'Admin' : 'Dashboard' }}
                @else
                    Masuk
                @endauth
            </span>
        </a>
    </div>
</nav>
