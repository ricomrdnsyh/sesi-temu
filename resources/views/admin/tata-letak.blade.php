@extends('layouts.aplikasi')

@section('konten')
@php
    $judulHeaderAdmin = match (true) {
        request()->routeIs('admin.undangan.*') => 'Manajemen Undangan',
        request()->routeIs('admin.tema.*') => 'Katalog Tema',
        request()->routeIs('admin.pengguna.*') => 'Manajemen Pengguna',
        default => 'Ringkasan Platform',
    };

    $namaAdmin = auth()->user()?->nama ?? 'Administrator';
    $inisialAdmin = strtoupper(mb_substr($namaAdmin, 0, 1));
@endphp

<div x-data="{ sidebarTerbuka: false }" class="min-h-screen w-full bg-ivory flex">
    {{-- Backdrop Mobile Drawer --}}
    <div
        x-show="sidebarTerbuka"
        x-cloak
        @click="sidebarTerbuka = false"
        aria-hidden="true"
        class="fixed inset-0 z-30 bg-black/50 backdrop-blur-xs md:hidden"
    ></div>

    {{-- Sidebar Admin --}}
    <aside
        aria-label="Navigasi Panel Admin"
        :class="sidebarTerbuka ? 'translate-x-0 shadow-2xl' : '-translate-x-full md:translate-x-0'"
        class="fixed inset-y-0 left-0 z-40 w-64 xl:w-72 shrink-0 bg-charcoal text-ivory border-r border-champagne/25 flex flex-col justify-between transition-transform duration-200 ease-in-out md:sticky md:top-0 md:h-screen md:translate-x-0"
    >
        <div class="flex flex-col flex-1 min-h-0">
            {{-- Brand Sidebar --}}
            <div class="px-5 py-5 border-b border-white/10 flex items-center justify-between gap-3">
                <a href="{{ route('admin.ringkasan') }}" class="flex items-center gap-2.5 font-serif text-xl font-bold text-white min-w-0">
                    <span class="inline-flex items-center justify-center rounded-xl bg-[#FBF3E6] p-1 shadow-sm shrink-0">
                        <img
                            src="{{ asset('aset-demo/logo-sesi-temu-ikon.webp') }}"
                            alt="Logo SesiTemu"
                            class="h-7 w-7 object-contain"
                        >
                    </span>
                    <span class="truncate">Sesi<span class="text-champagne">Temu</span></span>
                    <span class="rounded-md bg-champagne/15 border border-champagne/30 px-1.5 py-0.5 text-[10px] font-sans font-semibold uppercase tracking-wider text-champagne shrink-0">
                        Admin
                    </span>
                </a>

                <button
                    type="button"
                    @click="sidebarTerbuka = false"
                    aria-label="Tutup menu admin"
                    class="md:hidden rounded-lg p-1.5 text-ivory/70 hover:bg-white/10 hover:text-white cursor-pointer"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Navigasi Vertikal --}}
            <nav class="flex-1 px-4 py-5 space-y-1.5 overflow-y-auto text-sm">
                <p class="px-3 pb-1.5 text-[10px] font-semibold uppercase tracking-[0.2em] text-ivory/45">
                    Menu Utama
                </p>

                <a
                    href="{{ route('admin.ringkasan') }}"
                    class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 transition {{ request()->routeIs('admin.ringkasan') ? 'bg-champagne text-charcoal font-semibold shadow-sm' : 'text-ivory/80 hover:bg-white/10 hover:text-white' }}"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Ringkasan</span>
                </a>

                <a
                    href="{{ route('admin.undangan.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 transition {{ request()->routeIs('admin.undangan.*') ? 'bg-champagne text-charcoal font-semibold shadow-sm' : 'text-ivory/80 hover:bg-white/10 hover:text-white' }}"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span>Undangan</span>
                </a>

                <a
                    href="{{ route('admin.tema.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 transition {{ request()->routeIs('admin.tema.*') ? 'bg-champagne text-charcoal font-semibold shadow-sm' : 'text-ivory/80 hover:bg-white/10 hover:text-white' }}"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                    </svg>
                    <span>Katalog Tema</span>
                </a>

                <a
                    href="{{ route('admin.pengguna.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 transition {{ request()->routeIs('admin.pengguna.*') ? 'bg-champagne text-charcoal font-semibold shadow-sm' : 'text-ivory/80 hover:bg-white/10 hover:text-white' }}"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Pengguna</span>
                </a>

                <div class="pt-5 mt-5 border-t border-white/10 space-y-1.5">
                    <p class="px-3 pb-1.5 text-[10px] font-semibold uppercase tracking-[0.2em] text-ivory/45">
                        Pintasan
                    </p>

                    <a
                        href="{{ route('beranda') }}"
                        class="flex items-center gap-3 rounded-xl px-3.5 py-2 text-xs text-ivory/75 hover:bg-white/10 hover:text-white transition"
                    >
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        <span>Lihat Beranda</span>
                    </a>

                    <a
                        href="{{ route('dasbor.index') }}"
                        class="flex items-center gap-3 rounded-xl px-3.5 py-2 text-xs text-ivory/75 hover:bg-white/10 hover:text-white transition"
                    >
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Dasbor Client</span>
                    </a>
                </div>
            </nav>
        </div>

        {{-- Profil Admin & Keluar --}}
        <div class="p-4 border-t border-white/10 bg-black/15 space-y-3">
            @auth
                <div class="px-1">
                    <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->nama }}</p>
                    <p class="text-[11px] text-ivory/60 truncate">{{ auth()->user()->email }}</p>
                </div>
            @endauth

            <form action="{{ route('keluar') }}" method="POST">
                @csrf
                <button
                    type="submit"
                    class="w-full flex items-center justify-center gap-2 rounded-xl border border-ivory/25 px-3.5 py-2 text-xs font-semibold text-ivory hover:bg-white/10 hover:text-white transition cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Konten Utama + Header Panel Admin --}}
    <div class="flex-1 min-w-0 flex flex-col">
        <header
            aria-label="Header Panel Admin"
            class="sticky top-0 z-20 bg-white/95 backdrop-blur-md border-b border-champagne/25"
        >
            <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-10 h-16 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3 min-w-0">
                    <button
                        type="button"
                        @click="sidebarTerbuka = true"
                        aria-label="Buka menu admin"
                        class="md:hidden inline-flex items-center justify-center rounded-xl border border-charcoal/15 p-2 text-charcoal hover:bg-ivory transition cursor-pointer"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="min-w-0">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-champagne">
                            Panel Admin &bull; SesiTemu
                        </p>
                        <p class="text-sm sm:text-base font-bold text-charcoal truncate">
                            @yield('header_admin', $judulHeaderAdmin)
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3 sm:gap-4 shrink-0">
                    <span class="hidden lg:inline-flex items-center gap-1.5 rounded-full bg-ivory px-3 py-1 text-xs font-medium text-charcoal/75 border border-champagne/25">
                        <span class="w-1.5 h-1.5 rounded-full bg-sage"></span>
                        <span>{{ now()->locale('id')->translatedFormat('l, d M Y') }} WIB</span>
                    </span>

                    <a
                        href="{{ route('beranda') }}"
                        class="hidden sm:inline-flex items-center gap-1.5 rounded-xl border border-charcoal/15 px-3 py-1.5 text-xs font-semibold text-charcoal hover:bg-ivory transition"
                    >
                        <span>Lihat Beranda</span>
                    </a>

                    <div class="flex items-center gap-2.5 pl-1 border-l border-charcoal/10">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-charcoal text-xs font-bold text-champagne">
                            {{ $inisialAdmin }}
                        </span>
                        <div class="hidden sm:block text-left leading-tight">
                            <p class="text-xs font-semibold text-charcoal">{{ $namaAdmin }}</p>
                            <p class="text-[11px] text-charcoal/55">Administrator</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 w-full px-4 sm:px-6 lg:px-8 xl:px-10 py-6 sm:py-8 space-y-6">
            @if (session('sukses'))
                <div class="rounded-xl bg-sage/10 border border-sage/30 px-4 py-3 text-sm text-sage">
                    {{ session('sukses') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('isi_admin')
        </main>
    </div>
</div>
@endsection
