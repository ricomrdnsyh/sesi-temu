@php
    $halamanAktif = $halamanAktif ?? 'dashboard';
    $penggunaAktif = auth()->user();
    $dashboardAktifSidebar = in_array($halamanAktif, ['dashboard', 'undangan', 'beranda'], true);
@endphp

{{-- Sidebar Vertikal Ramping Desktop (Identik dengan Studio Workspace Sidebar) --}}
<aside
    aria-label="Navigasi Dashboard Client"
    data-client-sidebar
    class="hidden md:flex md:flex-col relative overflow-hidden w-[84px] shrink-0 bg-gradient-to-b from-[#2F4239] via-[#3A5045] to-[#2B3C34] text-ivory h-screen sticky top-0 py-4 border-r border-champagne/20 items-center justify-between select-none z-30 shadow-[4px_0_24px_-8px_rgba(20,32,26,0.28)]"
>
    {{-- Cahaya Ambient Halus Atas --}}
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

        {{-- Menu Utama Client --}}
        <nav aria-label="Menu Dashboard Client" class="mt-4 flex flex-col items-center gap-2 w-full px-2.5">
            <a
                href="{{ route('dashboard.index') }}"
                data-client-sidebar-menu="dashboard"
                title="Undangan Saya"
                class="relative group flex flex-col items-center justify-center gap-1.5 w-full rounded-2xl py-2.5 transition-all duration-200 {{ $dashboardAktifSidebar ? 'bg-gradient-to-b from-white/18 to-white/10 text-white ring-1 ring-champagne/35 shadow-sm font-semibold' : 'text-ivory/75 hover:bg-white/10 hover:text-white hover:-translate-y-0.5 font-medium' }}"
            >
                @if ($dashboardAktifSidebar)
                    <span class="pointer-events-none absolute -left-2.5 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r-full bg-champagne shadow-[0_0_8px_rgba(191,161,95,0.75)]"></span>
                @endif
                <svg class="h-5 w-5 shrink-0 {{ $dashboardAktifSidebar ? 'text-[#F5E3B8]' : '' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $dashboardAktifSidebar ? '2.1' : '1.9' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect width="20" height="16" x="2" y="4" rx="2"/>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                </svg>
                <span class="text-[10px] leading-none">Undangan</span>
            </a>

            <a
                href="{{ route('dashboard.katalog') }}"
                data-client-sidebar-menu="katalog"
                title="Buat Undangan Baru — Pilih Tema"
                class="relative group flex flex-col items-center justify-center gap-1.5 w-full rounded-2xl py-2.5 transition-all duration-200 {{ $halamanAktif === 'katalog' ? 'bg-gradient-to-b from-white/18 to-white/10 text-white ring-1 ring-champagne/35 shadow-sm font-semibold' : 'text-ivory/75 hover:bg-white/10 hover:text-white hover:-translate-y-0.5 font-medium' }}"
            >
                @if ($halamanAktif === 'katalog')
                    <span class="pointer-events-none absolute -left-2.5 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r-full bg-champagne shadow-[0_0_8px_rgba(191,161,95,0.75)]"></span>
                @endif
                <svg class="h-5 w-5 shrink-0 transition-transform duration-200 group-hover:scale-105 {{ $halamanAktif === 'katalog' ? 'text-[#F5E3B8]' : '' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $halamanAktif === 'katalog' ? '2.1' : '1.9' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h8"/>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                    <path d="M19 16v6"/>
                    <path d="M16 19h6"/>
                </svg>
                <span class="text-[10px] leading-none">Buat Baru</span>
            </a>

            <a
                href="{{ route('dashboard.profil.tampil') }}"
                data-client-sidebar-menu="profil"
                title="Profil — {{ $penggunaAktif->nama }}"
                class="relative group flex flex-col items-center justify-center gap-1.5 w-full rounded-2xl py-2.5 transition-all duration-200 {{ $halamanAktif === 'profil' ? 'bg-gradient-to-b from-white/18 to-white/10 text-white ring-1 ring-champagne/35 shadow-sm font-semibold' : 'text-ivory/75 hover:bg-white/10 hover:text-white hover:-translate-y-0.5 font-medium' }}"
            >
                @if ($halamanAktif === 'profil')
                    <span class="pointer-events-none absolute -left-2.5 top-1/2 -translate-y-1/2 h-6 w-1 rounded-r-full bg-champagne shadow-[0_0_8px_rgba(191,161,95,0.75)]"></span>
                @endif
                <svg class="h-5 w-5 shrink-0 {{ $halamanAktif === 'profil' ? 'text-[#F5E3B8]' : '' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $halamanAktif === 'profil' ? '2.1' : '1.9' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M20 21a8 8 0 0 0-16 0"/>
                </svg>
                <span class="text-[10px] leading-none">Profil</span>
            </a>

            @if ($penggunaAktif->adalahAdmin())
                <a
                    href="{{ route('admin.ringkasan') }}"
                    data-client-sidebar-menu="admin"
                    title="Panel Admin"
                    class="group flex flex-col items-center justify-center gap-1.5 w-full rounded-2xl py-2.5 text-[#F5E3B8] hover:bg-white/10 hover:text-white hover:-translate-y-0.5 font-medium transition-all duration-200"
                >
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>
                    <span class="text-[10px] leading-none">Admin</span>
                </a>
            @endif
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
