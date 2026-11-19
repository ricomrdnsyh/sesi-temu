@php
    $halamanAktif = $halamanAktif ?? 'beranda';
    $judulMobile = $judulMobile ?? null;
    $lebarKontainer = $lebarKontainer ?? 'max-w-7xl';
    $penggunaAktif = auth()->user();
@endphp

<header class="bg-white/95 backdrop-blur-md border-b border-champagne/20 sticky top-0 z-30">
    <div class="{{ $lebarKontainer }} mx-auto px-4 sm:px-6 lg:px-8 h-14 md:h-16 flex items-center justify-between gap-3">
        <div class="flex items-center gap-3 md:gap-6 min-w-0">
            <a href="{{ route('beranda') }}" class="flex items-center text-charcoal shrink-0 group">
                @if ($judulMobile)
                    <img
                        src="{{ asset('logo/logo-ikon.webp') }}"
                        alt="Logo SesiTemu"
                        class="sm:hidden h-8 w-8 object-contain transition-transform duration-200 group-hover:scale-105"
                    >
                    <img
                        src="{{ asset('logo/logo-horizontal.webp') }}"
                        alt="Logo SesiTemu"
                        class="hidden sm:block h-9 md:h-10 w-auto object-contain transition-transform duration-200 group-hover:scale-[1.03]"
                    >
                @else
                    <img
                        src="{{ asset('logo/logo-horizontal.webp') }}"
                        alt="Logo SesiTemu"
                        class="h-8 sm:h-9 md:h-10 w-auto object-contain transition-transform duration-200 group-hover:scale-[1.03]"
                    >
                @endif
                <span class="sr-only">SesiTemu</span>
            </a>

            @if ($judulMobile)
                <span class="md:hidden font-logo text-lg font-bold tracking-tight text-charcoal truncate">{{ $judulMobile }}</span>
            @endif

            <nav aria-label="Navigasi Dashboard Client" class="hidden md:flex items-center gap-1.5">
                <a
                    href="{{ route('dashboard.index') }}"
                    class="rounded-xl px-3.5 py-1.5 text-sm font-semibold transition {{ $halamanAktif === 'beranda' ? 'bg-sage/12 text-sage' : 'text-charcoal/70 hover:bg-ivory hover:text-charcoal' }}"
                >
                    Beranda
                </a>
                <a
                    href="{{ route('dashboard.undangan.index') }}"
                    class="rounded-xl px-3.5 py-1.5 text-sm font-semibold transition {{ $halamanAktif === 'undangan' ? 'bg-sage/12 text-sage' : 'text-charcoal/70 hover:bg-ivory hover:text-charcoal' }}"
                >
                    Undangan Saya
                </a>
                <a
                    href="{{ route('dashboard.katalog') }}"
                    class="rounded-xl px-3.5 py-1.5 text-sm font-semibold transition {{ $halamanAktif === 'katalog' ? 'bg-sage/12 text-sage' : 'text-charcoal/70 hover:bg-ivory hover:text-charcoal' }}"
                >
                    Katalog Tema
                </a>
            </nav>
        </div>

        <div class="flex items-center gap-2.5 md:gap-4 text-xs sm:text-sm min-w-0">
            @if ($penggunaAktif->adalahAdmin())
                <a href="{{ route('admin.ringkasan') }}" class="font-semibold text-champagne hover:underline shrink-0">
                    Panel Admin
                </a>
            @endif

            <a
                href="{{ route('dashboard.profil.tampil') }}"
                title="Profil — {{ $penggunaAktif->nama }}"
                aria-label="Buka profil {{ $penggunaAktif->nama }}"
                class="inline-flex h-9 w-9 items-center justify-center rounded-full font-sans text-xs font-bold tracking-wide transition shrink-0 {{ $halamanAktif === 'profil' ? 'bg-sage text-white ring-2 ring-champagne shadow-xs' : 'bg-sage text-white ring-2 ring-champagne/40 hover:bg-sage/90 hover:ring-champagne hover:scale-105 shadow-2xs' }}"
            >
                <span>{{ $penggunaAktif->inisialNama() }}</span>
                <span class="sr-only">{{ $penggunaAktif->nama }}</span>
            </a>

            <form
                action="{{ route('keluar') }}"
                method="POST"
                class="hidden md:inline-flex shrink-0"
                data-swal-confirm="Yakin ingin keluar dari akun SesiTemu Anda?"
                data-swal-title="Keluar dari Akun"
                data-swal-confirm-button="Ya, Keluar"
                data-swal-confirm-color="#DC2626"
                data-swal-loading-title="Keluar dari Akun..."
                data-swal-loading-text="Sedang mengakhiri sesi akun Anda..."
            >
                @csrf
                <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl border border-charcoal/15 px-3 py-1.5 font-semibold text-charcoal hover:bg-charcoal/5 transition cursor-pointer">
                    <svg class="h-3.5 w-3.5 text-charcoal/65" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" x2="9" y1="12" y2="12" />
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </div>
</header>
