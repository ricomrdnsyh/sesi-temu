@props([
    'halaman' => 'beranda',
    'dalamBeranda' => false,
])

<nav
    aria-label="Navigasi Mobile Beranda"
    data-landing-bottom-nav
    class="md:hidden fixed bottom-0 inset-x-0 z-40 bg-white/95 backdrop-blur-md border-t border-champagne/25 shadow-[0_-8px_28px_-10px_rgba(31,41,55,0.14)] pb-[env(safe-area-inset-bottom)]"
>
    <div class="max-w-lg mx-auto grid grid-cols-5 h-16 px-1.5 items-center gap-0.5">
        {{-- 1. Beranda --}}
        @if ($dalamBeranda)
            <button
                type="button"
                @click="bukaTabMobile('beranda')"
                :class="tabMobile === 'beranda' ? 'text-sage font-bold bg-sage/10' : 'text-charcoal/65 hover:text-sage font-medium'"
                class="flex flex-col items-center justify-center gap-0.5 py-1.5 rounded-xl transition cursor-pointer"
            >
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
                <span class="text-[10px] leading-tight">Beranda</span>
            </button>
        @else
            <a
                href="{{ route('beranda') }}"
                class="flex flex-col items-center justify-center gap-0.5 py-1.5 rounded-xl transition {{ $halaman === 'beranda' ? 'text-sage font-bold bg-sage/10' : 'text-charcoal/65 hover:text-sage font-medium' }}"
            >
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
                <span class="text-[10px] leading-tight">Beranda</span>
            </a>
        @endif

        {{-- 2. Tema --}}
        @if ($dalamBeranda)
            <button
                type="button"
                @click="bukaTabMobile('tema')"
                :class="tabMobile === 'tema' ? 'text-sage font-bold bg-sage/10' : 'text-charcoal/65 hover:text-sage font-medium'"
                class="flex flex-col items-center justify-center gap-0.5 py-1.5 rounded-xl transition cursor-pointer"
            >
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="13.5" cy="6.5" r=".5" fill="currentColor" />
                    <circle cx="17.5" cy="10.5" r=".5" fill="currentColor" />
                    <circle cx="8.5" cy="7.5" r=".5" fill="currentColor" />
                    <circle cx="6.5" cy="12.5" r=".5" fill="currentColor" />
                    <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z" />
                </svg>
                <span class="text-[10px] leading-tight">Tema</span>
            </button>
        @else
            <a
                href="{{ route('beranda', ['tab' => 'tema']) }}"
                class="flex flex-col items-center justify-center gap-0.5 py-1.5 rounded-xl text-charcoal/65 hover:text-sage font-medium transition"
            >
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="13.5" cy="6.5" r=".5" fill="currentColor" />
                    <circle cx="17.5" cy="10.5" r=".5" fill="currentColor" />
                    <circle cx="8.5" cy="7.5" r=".5" fill="currentColor" />
                    <circle cx="6.5" cy="12.5" r=".5" fill="currentColor" />
                    <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z" />
                </svg>
                <span class="text-[10px] leading-tight">Tema</span>
            </a>
        @endif

        {{-- 3. Buat (Aksi Utama Tengah) --}}
        @if ($dalamBeranda)
            <button
                type="button"
                @click="sheetBuatTerbuka = true"
                :class="sheetBuatTerbuka ? 'text-sage font-bold' : 'text-charcoal/85 hover:text-sage font-semibold'"
                class="flex flex-col items-center justify-center gap-0.5 py-1 rounded-xl transition cursor-pointer"
            >
                <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-gradient-to-br from-[#2D4439] to-sage text-white shadow-sm ring-2 ring-champagne/30">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="12" x2="12" y1="5" y2="19" />
                        <line x1="5" x2="19" y1="12" y2="12" />
                    </svg>
                </span>
                <span class="text-[10px] leading-tight">Buat</span>
            </button>
        @else
            <a
                href="{{ auth()->check() ? route('dasbor.katalog') : route('daftar') }}"
                class="flex flex-col items-center justify-center gap-0.5 py-1 rounded-xl transition {{ $halaman === 'daftar' ? 'text-sage font-bold bg-sage/10' : 'text-charcoal/85 hover:text-sage font-semibold' }}"
            >
                <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-gradient-to-br from-[#2D4439] to-sage text-white shadow-sm ring-2 {{ $halaman === 'daftar' ? 'ring-champagne' : 'ring-champagne/30' }}">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="12" x2="12" y1="5" y2="19" />
                        <line x1="5" x2="19" y1="12" y2="12" />
                    </svg>
                </span>
                <span class="text-[10px] leading-tight">Buat</span>
            </a>
        @endif

        {{-- 4. Paket (Harga, Fitur & FAQ) --}}
        @if ($dalamBeranda)
            <button
                type="button"
                @click="bukaTabMobile('paket')"
                :class="tabMobile === 'paket' ? 'text-sage font-bold bg-sage/10' : 'text-charcoal/65 hover:text-sage font-medium'"
                class="flex flex-col items-center justify-center gap-0.5 py-1.5 rounded-xl transition cursor-pointer"
            >
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z" />
                    <path d="M7 7h.01" />
                </svg>
                <span class="text-[10px] leading-tight">Paket</span>
            </button>
        @else
            <a
                href="{{ route('beranda', ['tab' => 'paket']) }}"
                class="flex flex-col items-center justify-center gap-0.5 py-1.5 rounded-xl text-charcoal/65 hover:text-sage font-medium transition"
            >
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z" />
                    <path d="M7 7h.01" />
                </svg>
                <span class="text-[10px] leading-tight">Paket</span>
            </a>
        @endif

        {{-- 5. Masuk / Akun --}}
        <a
            href="{{ auth()->check() ? (auth()->user()->adalahAdmin() ? '/admin' : '/dasbor') : route('login') }}"
            class="flex flex-col items-center justify-center gap-0.5 py-1.5 rounded-xl transition {{ $halaman === 'masuk' ? 'text-sage font-bold bg-sage/10' : 'text-charcoal/65 hover:text-sage font-medium' }}"
        >
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="12" cy="8" r="4" />
                <path d="M20 21a8 8 0 0 0-16 0" />
            </svg>
            <span class="text-[10px] leading-tight">
                @auth
                    {{ auth()->user()->adalahAdmin() ? 'Admin' : 'Dasbor' }}
                @else
                    Masuk
                @endauth
            </span>
        </a>
    </div>
</nav>
