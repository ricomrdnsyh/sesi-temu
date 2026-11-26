@php
    $menuAktif = $menuAktif ?? 'tamu';
    $judulHalaman = $judulHalaman ?? ($menuAktif === 'rsvp' ? 'RSVP & Ucapan' : 'Daftar Tamu');
    $penggunaAktif = auth()->user();
    $namaMempelaiHeader = trim($undangan->nama_panggilan_pria . ' & ' . $undangan->nama_panggilan_wanita);
@endphp

<header
    aria-label="Header Ruang Kerja Undangan"
    data-workspace-header
    class="sticky top-0 z-30 lg:static lg:px-8 xl:px-10 lg:pt-3"
>
    {{-- Header Mobile & Tablet (< lg) --}}
    <div class="lg:hidden bg-white/95 backdrop-blur-md border-b border-champagne/25 px-4 h-14 flex items-center justify-between gap-3 shadow-[0_6px_18px_-14px_rgba(20,32,26,0.22)]">
        <div class="flex items-center gap-2.5 min-w-0">
            <a href="{{ route('beranda') }}" class="flex items-center shrink-0 group">
                <img
                    src="{{ asset('logo/logo-ikon.webp') }}"
                    alt="Logo SesiTemu"
                    class="h-8 w-8 object-contain transition-transform duration-200 group-hover:scale-105"
                >
                <span class="sr-only">SesiTemu</span>
            </a>

            <div class="min-w-0 leading-tight">
                <p class="font-sans text-sm font-bold text-charcoal tracking-tight truncate">{{ $judulHalaman }}</p>
                <p class="text-[11px] font-medium text-charcoal/55 truncate">{{ $namaMempelaiHeader }}</p>
            </div>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            @if ($penggunaAktif->adalahAdmin())
                <a href="{{ route('admin.ringkasan') }}" class="rounded-lg bg-champagne/15 px-2.5 py-1 text-[11px] font-semibold text-[#8A6D33] hover:bg-champagne/25 transition shrink-0">
                    Admin
                </a>
            @endif

            <a
                href="{{ route('dashboard.profil.tampil') }}"
                title="Profil — {{ $penggunaAktif->nama }}"
                aria-label="Buka profil {{ $penggunaAktif->nama }}"
                class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-sage text-white font-sans text-xs font-bold tracking-wide ring-2 ring-champagne/40 hover:bg-sage/90 hover:ring-champagne hover:scale-105 transition shrink-0 shadow-2xs"
            >
                <span>{{ $penggunaAktif->inisialNama() }}</span>
                <span class="sr-only">{{ $penggunaAktif->nama }}</span>
            </a>
        </div>
    </div>

    {{-- Header Floating Desktop (lg+) --}}
    <div class="hidden lg:flex items-center justify-between gap-4 rounded-2xl bg-white/95 backdrop-blur-md px-5 py-2.5 ring-1 ring-champagne/25 shadow-[0_10px_28px_-16px_rgba(20,32,26,0.18)]">
        <div class="flex items-center gap-3 min-w-0">
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-sage/12 text-sage ring-1 ring-sage/15 shrink-0">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                </svg>
            </span>

            <div class="min-w-0 leading-tight">
                <div class="flex items-center gap-2">
                    <p class="font-sans text-sm font-bold text-charcoal truncate">{{ $namaMempelaiHeader }}</p>
                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-semibold text-emerald-700 ring-1 ring-emerald-200/80 shrink-0">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        <span>Aktif</span>
                    </span>
                </div>
                <p class="text-[11px] text-charcoal/55 truncate">
                    {{ $undangan->tema?->nama_tema ?? 'Tema Pilihan' }} &bull; sesitemu.id/{{ $undangan->slug }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            <nav aria-label="Pindah Cepat Ruang Kerja" class="inline-flex items-center gap-1 rounded-xl bg-ivory p-1 ring-1 ring-champagne/25">
                <a
                    href="{{ route('dashboard.undangan.kelola', $undangan) }}"
                    class="rounded-lg px-3 py-1.5 text-xs font-semibold transition {{ $menuAktif === 'undangan' ? 'bg-sage text-white shadow-2xs' : 'text-charcoal/70 hover:text-charcoal' }}"
                >
                    Edit Undangan
                </a>
                <a
                    href="{{ route('dashboard.undangan.tamu', $undangan) }}"
                    class="rounded-lg px-3 py-1.5 text-xs font-semibold transition {{ $menuAktif === 'tamu' ? 'bg-sage text-white shadow-2xs' : 'text-charcoal/70 hover:text-charcoal' }}"
                >
                    Tamu
                </a>
                <a
                    href="{{ route('dashboard.undangan.rsvp', $undangan) }}"
                    class="rounded-lg px-3 py-1.5 text-xs font-semibold transition {{ $menuAktif === 'rsvp' ? 'bg-sage text-white shadow-2xs' : 'text-charcoal/70 hover:text-charcoal' }}"
                >
                    RSVP
                </a>
            </nav>

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
                <span class="text-xs font-semibold text-charcoal max-w-[8rem] truncate">{{ $penggunaAktif->nama }}</span>
            </a>
        </div>
    </div>
</header>
