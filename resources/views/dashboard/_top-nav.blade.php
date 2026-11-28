@php
    $halamanAktif = $halamanAktif ?? 'dashboard';
    $judulMobile = $judulMobile ?? null;
    $penggunaAktif = auth()->user();
    $tampilHeaderDesktop = in_array($halamanAktif, ['dashboard', 'katalog'], true);

    $metaHeaderDesktop = match ($halamanAktif) {
        'katalog' => [
            'judul' => 'Buat Baru',
            'badge' => 'Katalog Tema',
            'subjudul' => 'Pilih tema favorit, pratinjau tampilan, lalu mulai susun draft undangan Anda.',
        ],
        default => [
            'judul' => 'Dashboard',
            'badge' => 'Undangan Saya',
            'subjudul' => 'Ringkasan dan pengelolaan seluruh undangan pernikahan digital Anda.',
        ],
    };
@endphp

{{-- Header Mobile (< md) + Header Floating Desktop (md+ untuk Dashboard & Buat Baru) --}}
<header
    aria-label="Header Dashboard Client"
    data-client-header
    class="{{ $tampilHeaderDesktop ? 'sticky top-0 z-30 md:px-6 lg:px-8 xl:px-10 md:pt-3 md:pb-1 md:bg-gradient-to-b md:from-ivory md:via-ivory/90 md:to-transparent' : 'md:hidden sticky top-0 z-30' }}"
>
    {{-- Header Ringkas Mobile (< md) --}}
    <div class="md:hidden bg-white/95 backdrop-blur-md border-b border-champagne/20 px-4 h-14 flex items-center justify-between gap-3">
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

            @if ($halamanAktif !== 'profil')
                <a
                    href="{{ route('dashboard.profil.tampil') }}"
                    title="Profil — {{ $penggunaAktif->nama }}"
                    aria-label="Buka profil {{ $penggunaAktif->nama }}"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-full font-sans text-xs font-bold tracking-wide transition shrink-0 bg-sage text-white ring-2 ring-champagne/40 hover:bg-sage/90 hover:ring-champagne hover:scale-105 shadow-2xs"
                >
                    <span>{{ $penggunaAktif->inisialNama() }}</span>
                    <span class="sr-only">{{ $penggunaAktif->nama }}</span>
                </a>
            @endif
        </div>
    </div>

    @if ($tampilHeaderDesktop)
        {{-- Header Floating Desktop (md+) — Seragam dengan Workspace Header Tamu & RSVP --}}
        <div class="hidden md:flex items-center justify-between gap-4 rounded-2xl bg-white/95 backdrop-blur-md px-5 py-2.5 ring-1 ring-champagne/25 shadow-[0_10px_28px_-16px_rgba(20,32,26,0.18)]">
            <div class="flex items-center gap-3 min-w-0">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-sage/12 text-sage ring-1 ring-sage/15 shrink-0">
                    @if ($halamanAktif === 'katalog')
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h8" />
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                            <path d="M19 16v6" />
                            <path d="M16 19h6" />
                        </svg>
                    @else
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect width="20" height="16" x="2" y="4" rx="2" />
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                        </svg>
                    @endif
                </span>

                <div class="min-w-0 leading-tight">
                    <div class="flex items-center gap-2">
                        <p class="font-sans text-sm font-bold text-charcoal truncate">{{ $metaHeaderDesktop['judul'] }}</p>
                        <span class="inline-flex items-center rounded-full bg-sage/10 px-2 py-0.5 text-[10px] font-semibold text-sage ring-1 ring-sage/15 shrink-0">
                            {{ $metaHeaderDesktop['badge'] }}
                        </span>
                    </div>
                    <p class="text-[11px] text-charcoal/55 truncate">
                        {{ $metaHeaderDesktop['subjudul'] }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                @if ($penggunaAktif->adalahAdmin())
                    <a href="{{ route('admin.ringkasan') }}" class="text-xs font-semibold text-[#8A6D33] hover:underline shrink-0">
                        Panel Admin
                    </a>
                @endif

                <a
                    href="{{ route('dashboard.profil.tampil') }}"
                    title="Profil — {{ $penggunaAktif->nama }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-ivory/80 pl-1.5 pr-3 py-1 ring-1 ring-champagne/30 hover:bg-ivory hover:ring-champagne/60 transition shrink-0"
                >
                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-sage text-white font-sans text-[11px] font-bold">
                        {{ $penggunaAktif->inisialNama() }}
                    </span>
                    <span class="text-xs font-semibold text-charcoal max-w-[10rem] truncate">{{ $penggunaAktif->nama }}</span>
                </a>
            </div>
        </div>
    @endif
</header>
