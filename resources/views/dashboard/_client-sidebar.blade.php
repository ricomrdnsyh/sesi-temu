@php
    $halamanAktif = $halamanAktif ?? 'dashboard';
    $penggunaAktif = auth()->user();
    $dashboardAktifSidebar = in_array($halamanAktif, ['dashboard', 'undangan', 'beranda'], true);
@endphp

{{-- Sidebar Mengambang Ramping Desktop (Identik dengan Studio Workspace Sidebar) --}}
<aside
    aria-label="Navigasi Dashboard Client"
    data-client-sidebar
    class="hidden md:flex md:flex-col w-[74px] shrink-0 h-[calc(100vh-1.5rem)] sticky top-3 my-3 ml-3 rounded-3xl bg-gradient-to-b from-[#2A3E35] to-[#203029] text-ivory py-4 ring-1 ring-white/10 items-center justify-between select-none z-30 shadow-[0_14px_34px_-12px_rgba(16,28,22,0.38)]"
>
    {{-- Logo --}}
    <a
        href="{{ route('beranda') }}"
        title="Beranda SesiTemu"
        class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 p-1.5 ring-1 ring-[#E2C27D]/30 hover:bg-white/15 hover:scale-105 transition"
    >
        <img
            src="{{ asset('logo/logo-ikon-gelap.webp') }}"
            alt="Logo SesiTemu"
            class="h-full w-full object-contain"
        >
    </a>

    {{-- Menu Utama --}}
    <nav aria-label="Menu Dashboard Client" class="flex flex-col items-center gap-3 w-full px-2">
        <a
            href="{{ route('dashboard.index') }}"
            data-client-sidebar-menu="dashboard"
            title="Undangan Saya"
            class="group flex flex-col items-center gap-1 transition {{ $dashboardAktifSidebar ? 'text-white font-semibold' : 'text-ivory/65 hover:text-white font-medium' }}"
        >
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl transition {{ $dashboardAktifSidebar ? 'bg-[#F5E3B8] text-[#203029] shadow-[0_6px_16px_-4px_rgba(245,227,184,0.45)]' : 'group-hover:bg-white/10' }}">
                <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $dashboardAktifSidebar ? '2.1' : '1.85' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect width="20" height="16" x="2" y="4" rx="2"/>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                </svg>
            </span>
            <span class="text-[9.5px] leading-none">Undangan</span>
        </a>

        <a
            href="{{ route('dashboard.katalog') }}"
            data-client-sidebar-menu="katalog"
            title="Buat Undangan Baru — Pilih Tema"
            class="group flex flex-col items-center gap-1 transition {{ $halamanAktif === 'katalog' ? 'text-white font-semibold' : 'text-ivory/65 hover:text-white font-medium' }}"
        >
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl transition {{ $halamanAktif === 'katalog' ? 'bg-[#F5E3B8] text-[#203029] shadow-[0_6px_16px_-4px_rgba(245,227,184,0.45)]' : 'group-hover:bg-white/10' }}">
                <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $halamanAktif === 'katalog' ? '2.1' : '1.85' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h8"/>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                    <path d="M19 16v6"/>
                    <path d="M16 19h6"/>
                </svg>
            </span>
            <span class="text-[9.5px] leading-none">Buat Baru</span>
        </a>

        <a
            href="{{ route('dashboard.profil.tampil') }}"
            data-client-sidebar-menu="profil"
            title="Profil — {{ $penggunaAktif->nama }}"
            class="group flex flex-col items-center gap-1 transition {{ $halamanAktif === 'profil' ? 'text-white font-semibold' : 'text-ivory/65 hover:text-white font-medium' }}"
        >
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl transition {{ $halamanAktif === 'profil' ? 'bg-[#F5E3B8] text-[#203029] shadow-[0_6px_16px_-4px_rgba(245,227,184,0.45)]' : 'group-hover:bg-white/10' }}">
                <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $halamanAktif === 'profil' ? '2.1' : '1.85' }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M20 21a8 8 0 0 0-16 0"/>
                </svg>
            </span>
            <span class="text-[9.5px] leading-none">Profil</span>
        </a>

        @if ($penggunaAktif->adalahAdmin())
            <a
                href="{{ route('admin.ringkasan') }}"
                data-client-sidebar-menu="admin"
                title="Panel Admin"
                class="group flex flex-col items-center gap-1 text-[#F5E3B8]/85 hover:text-white font-medium transition"
            >
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl group-hover:bg-white/10 transition">
                    <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.85" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>
                </span>
                <span class="text-[9.5px] leading-none">Admin</span>
            </a>
        @endif
    </nav>

    {{-- Bawah: Keluar --}}
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
            title="Keluar"
            class="group flex flex-col items-center gap-1 text-ivory/55 hover:text-rose-200 transition cursor-pointer"
        >
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl group-hover:bg-rose-500/20 transition">
                <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.85" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" x2="9" y1="12" y2="12"/>
                </svg>
            </span>
            <span class="text-[9.5px] font-medium leading-none">Keluar</span>
        </button>
    </form>
</aside>
