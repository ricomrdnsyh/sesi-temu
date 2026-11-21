@php
    $menuAktif = $menuAktif ?? 'undangan';
    $jumlahTamuRail = $undangan->relationLoaded('daftarTamu')
        ? $undangan->daftarTamu->count()
        : $undangan->daftarTamu()->count();
    $jumlahRsvpRail = $undangan->relationLoaded('bukuTamu')
        ? $undangan->bukuTamu->count()
        : $undangan->bukuTamu()->count();
    $urlKembaliRail = auth()->user()->adalahAdmin()
        ? route('admin.undangan.index')
        : route('dashboard.index');
    $labelKembaliRail = auth()->user()->adalahAdmin() ? 'Admin' : 'Dashboard';
@endphp

{{-- Sidebar Vertikal Ramping Desktop (Gaya Studio Editor) --}}
<aside
    aria-label="Navigasi Ruang Kerja Undangan"
    data-workspace-sidebar
    class="hidden lg:flex lg:flex-col relative overflow-hidden w-[84px] shrink-0 bg-gradient-to-b from-[#2F4239] via-[#3A5045] to-[#2B3C34] text-ivory h-screen sticky top-0 py-4 border-r border-champagne/20 items-center justify-between select-none z-30 shadow-[4px_0_24px_-8px_rgba(20,32,26,0.28)]"
>
    <div aria-hidden="true" class="pointer-events-none absolute -top-10 inset-x-0 h-32 bg-champagne/12 blur-2xl"></div>

    <div class="relative z-10 w-full flex flex-col items-center flex-1 min-h-0">
        {{-- Atas: Logo Gelap SesiTemu --}}
        <div class="w-full px-2 pb-4 border-b border-white/10 flex flex-col items-center gap-1.5">
            <a
                href="{{ route('beranda') }}"
                title="Beranda SesiTemu"
                class="group inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-white/[0.06] p-1 ring-1 ring-champagne/25 hover:bg-white/[0.12] hover:ring-champagne/55 hover:scale-105 transition-all duration-200"
            >
                <img
                    src="{{ asset('logo/logo-ikon-gelap.webp') }}"
                    alt="Logo SesiTemu"
                    class="h-full w-full object-contain"
                >
            </a>
            <span class="font-logo text-[11px] font-bold tracking-tight text-white leading-none">
                Sesi<span class="text-[#F5E3B8]">Temu</span>
            </span>
        </div>

        {{-- Menu Utama Ruang Kerja --}}
        <nav aria-label="Menu Ruang Kerja" class="mt-4 flex flex-col items-center gap-2 w-full px-2.5">
            <a
                href="{{ $urlKembaliRail }}"
                title="Kembali ke {{ $labelKembaliRail }}"
                class="group flex flex-col items-center justify-center gap-1.5 w-full rounded-2xl py-2.5 text-ivory/75 hover:bg-white/10 hover:text-white hover:-translate-y-0.5 transition-all duration-200"
            >
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect width="7" height="7" x="3" y="3" rx="1"/>
                    <rect width="7" height="7" x="14" y="3" rx="1"/>
                    <rect width="7" height="7" x="14" y="14" rx="1"/>
                    <rect width="7" height="7" x="3" y="14" rx="1"/>
                </svg>
                <span class="text-[10px] font-medium leading-none">{{ $labelKembaliRail }}</span>
            </a>

            <a
                href="{{ route('dashboard.undangan.kelola', $undangan) }}"
                data-workspace-menu="undangan"
                class="relative group flex flex-col items-center justify-center gap-1.5 w-full rounded-2xl py-2.5 transition-all duration-200 {{ $menuAktif === 'undangan' ? 'bg-gradient-to-b from-white/18 to-white/10 text-white ring-1 ring-champagne/35 shadow-sm font-semibold' : 'text-ivory/75 hover:bg-white/10 hover:text-white hover:-translate-y-0.5 font-medium' }}"
            >
                @if ($menuAktif === 'undangan')
                    <span class="pointer-events-none absolute -left-2.5 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r-full bg-champagne shadow-[0_0_8px_rgba(191,161,95,0.75)]"></span>
                @endif
                <svg class="h-5 w-5 shrink-0 {{ $menuAktif === 'undangan' ? 'text-[#F5E3B8]' : '' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $menuAktif === 'undangan' ? '2.1' : '1.9' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect width="20" height="16" x="2" y="4" rx="2"/>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                </svg>
                <span class="text-[10px] leading-none">Undangan</span>
            </a>

            <a
                href="{{ route('dashboard.undangan.tamu', $undangan) }}"
                data-workspace-menu="tamu"
                class="relative group flex flex-col items-center justify-center gap-1.5 w-full rounded-2xl py-2.5 transition-all duration-200 {{ $menuAktif === 'tamu' ? 'bg-gradient-to-b from-white/18 to-white/10 text-white ring-1 ring-champagne/35 shadow-sm font-semibold' : 'text-ivory/75 hover:bg-white/10 hover:text-white hover:-translate-y-0.5 font-medium' }}"
            >
                @if ($menuAktif === 'tamu')
                    <span class="pointer-events-none absolute -left-2.5 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r-full bg-champagne shadow-[0_0_8px_rgba(191,161,95,0.75)]"></span>
                @endif
                @if ($jumlahTamuRail > 0)
                    <span class="absolute top-1.5 right-2 rounded-full bg-champagne px-1.5 py-0.5 font-sans tabular-nums text-[9px] font-bold leading-none text-charcoal">
                        {{ $jumlahTamuRail }}
                    </span>
                @endif
                <svg class="h-5 w-5 shrink-0 {{ $menuAktif === 'tamu' ? 'text-[#F5E3B8]' : '' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $menuAktif === 'tamu' ? '2.1' : '1.9' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                <span class="text-[10px] leading-none">Tamu</span>
            </a>

            <a
                href="{{ route('dashboard.undangan.tamu', ['undangan' => $undangan, 'subtab' => 'rsvp']) }}"
                data-workspace-menu="rsvp"
                class="relative group flex flex-col items-center justify-center gap-1.5 w-full rounded-2xl py-2.5 transition-all duration-200 {{ $menuAktif === 'rsvp' ? 'bg-gradient-to-b from-white/18 to-white/10 text-white ring-1 ring-champagne/35 shadow-sm font-semibold' : 'text-ivory/75 hover:bg-white/10 hover:text-white hover:-translate-y-0.5 font-medium' }}"
            >
                @if ($menuAktif === 'rsvp')
                    <span class="pointer-events-none absolute -left-2.5 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r-full bg-champagne shadow-[0_0_8px_rgba(191,161,95,0.75)]"></span>
                @endif
                @if ($jumlahRsvpRail > 0)
                    <span class="absolute top-1.5 right-2 rounded-full bg-white/20 px-1.5 py-0.5 font-sans tabular-nums text-[9px] font-bold leading-none text-white">
                        {{ $jumlahRsvpRail }}
                    </span>
                @endif
                <svg class="h-5 w-5 shrink-0 {{ $menuAktif === 'rsvp' ? 'text-[#F5E3B8]' : '' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $menuAktif === 'rsvp' ? '2.1' : '1.9' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                <span class="text-[10px] leading-none">RSVP</span>
            </a>
        </nav>
    </div>

    {{-- Bawah: Keluar --}}
    <div class="relative z-10 w-full px-2.5 pt-3 border-t border-white/10">
        <form
            action="{{ route('keluar') }}"
            method="POST"
            data-swal-confirm="Yakin ingin keluar dari akun SesiTemu Anda?"
            data-swal-title="Keluar dari Akun"
            data-swal-confirm-button="Ya, Keluar"
            data-swal-confirm-color="#DC2626"
            data-swal-loading-title="Keluar dari Akun..."
            data-swal-loading-text="Sedang mengakhiri sesi akun Anda..."
        >
            @csrf
            <button
                type="submit"
                class="group flex flex-col items-center justify-center gap-1.5 w-full rounded-2xl py-2.5 text-ivory/70 hover:bg-rose-500/20 hover:text-rose-200 hover:ring-1 hover:ring-rose-300/30 transition-all duration-200 cursor-pointer"
            >
                <svg class="h-5 w-5 shrink-0 transition-transform duration-200 group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" x2="9" y1="12" y2="12"/>
                </svg>
                <span class="text-[10px] font-medium leading-none">Keluar</span>
            </button>
        </form>
    </div>
</aside>

{{-- Navigasi Bottom Bar Ruang Kerja (Khusus Mobile & Tablet < lg) --}}
<nav
    aria-label="Navigasi Ruang Kerja Mobile"
    data-client-bottom-nav
    class="lg:hidden fixed bottom-0 inset-x-0 z-40 rounded-t-2xl bg-white/96 backdrop-blur-lg border-t border-champagne/25 shadow-[0_-10px_30px_-12px_rgba(31,41,55,0.14)] pb-[env(safe-area-inset-bottom)]"
>
    <div class="max-w-lg mx-auto grid grid-cols-4 h-[64px] px-2 items-center">
        <a
            href="{{ $urlKembaliRail }}"
            class="flex flex-col items-center justify-center gap-1 py-1 text-charcoal/60 hover:text-sage font-medium active:scale-95 transition"
        >
            <span class="inline-flex items-center justify-center rounded-full px-3 py-1">
                <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect width="7" height="7" x="3" y="3" rx="1"/>
                    <rect width="7" height="7" x="14" y="3" rx="1"/>
                    <rect width="7" height="7" x="14" y="14" rx="1"/>
                    <rect width="7" height="7" x="3" y="14" rx="1"/>
                </svg>
            </span>
            <span class="text-[10px] leading-none">{{ $labelKembaliRail }}</span>
        </a>

        <a
            href="{{ route('dashboard.undangan.kelola', $undangan) }}"
            class="relative flex flex-col items-center justify-center gap-1 py-1 active:scale-95 transition {{ $menuAktif === 'undangan' ? 'text-sage font-bold' : 'text-charcoal/60 hover:text-sage font-medium' }}"
        >
            @if ($menuAktif === 'undangan')
                <span class="pointer-events-none absolute -top-1 h-1 w-6 rounded-b-full bg-sage"></span>
            @endif
            <span class="inline-flex items-center justify-center rounded-full px-3 py-1 {{ $menuAktif === 'undangan' ? 'bg-sage/15 text-sage ring-1 ring-sage/20' : '' }}">
                <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $menuAktif === 'undangan' ? '2.2' : '1.9' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect width="20" height="16" x="2" y="4" rx="2"/>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                </svg>
            </span>
            <span class="text-[10px] leading-none">Undangan</span>
        </a>

        <a
            href="{{ route('dashboard.undangan.tamu', $undangan) }}"
            class="relative flex flex-col items-center justify-center gap-1 py-1 active:scale-95 transition {{ $menuAktif === 'tamu' ? 'text-sage font-bold' : 'text-charcoal/60 hover:text-sage font-medium' }}"
        >
            @if ($menuAktif === 'tamu')
                <span class="pointer-events-none absolute -top-1 h-1 w-6 rounded-b-full bg-sage"></span>
            @endif
            <span class="inline-flex items-center justify-center rounded-full px-3 py-1 {{ $menuAktif === 'tamu' ? 'bg-sage/15 text-sage ring-1 ring-sage/20' : '' }}">
                <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $menuAktif === 'tamu' ? '2.2' : '1.9' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </span>
            <span class="text-[10px] leading-none">Tamu</span>
        </a>

        <a
            href="{{ route('dashboard.undangan.tamu', ['undangan' => $undangan, 'subtab' => 'rsvp']) }}"
            class="relative flex flex-col items-center justify-center gap-1 py-1 active:scale-95 transition {{ $menuAktif === 'rsvp' ? 'text-sage font-bold' : 'text-charcoal/60 hover:text-sage font-medium' }}"
        >
            @if ($menuAktif === 'rsvp')
                <span class="pointer-events-none absolute -top-1 h-1 w-6 rounded-b-full bg-sage"></span>
            @endif
            <span class="inline-flex items-center justify-center rounded-full px-3 py-1 {{ $menuAktif === 'rsvp' ? 'bg-sage/15 text-sage ring-1 ring-sage/20' : '' }}">
                <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $menuAktif === 'rsvp' ? '2.2' : '1.9' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
            </span>
            <span class="text-[10px] leading-none">RSVP</span>
        </a>
    </div>
</nav>
