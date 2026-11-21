@php
    $halamanAktif = $halamanAktif ?? 'dashboard';
    $judulMobile = $judulMobile ?? null;
    $penggunaAktif = auth()->user();
@endphp

{{-- Header Ringkas Khusus Mobile (Desktop Menggunakan Sidebar Kiri Ramping) --}}
<header class="md:hidden bg-white/95 backdrop-blur-md border-b border-champagne/20 sticky top-0 z-30">
    <div class="px-4 h-14 flex items-center justify-between gap-3">
        <div class="flex items-center gap-3 min-w-0">
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
                        class="hidden sm:block h-9 w-auto object-contain transition-transform duration-200 group-hover:scale-[1.03]"
                    >
                @else
                    <img
                        src="{{ asset('logo/logo-horizontal.webp') }}"
                        alt="Logo SesiTemu"
                        class="h-8 sm:h-9 w-auto object-contain transition-transform duration-200 group-hover:scale-[1.03]"
                    >
                @endif
                <span class="sr-only">SesiTemu</span>
            </a>

            @if ($judulMobile)
                <span class="font-logo text-lg font-bold tracking-tight text-charcoal truncate">{{ $judulMobile }}</span>
            @endif
        </div>

        <div class="flex items-center gap-2.5 text-xs min-w-0">
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
        </div>
    </div>
</header>
