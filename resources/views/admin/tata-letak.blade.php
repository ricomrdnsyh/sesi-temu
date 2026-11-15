@extends('layouts.aplikasi')

@section('konten')
<div class="min-h-screen bg-ivory flex flex-col">
    <header class="bg-charcoal text-ivory border-b border-champagne/30 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
            <div class="flex items-center gap-6">
                <a href="{{ route('admin.ringkasan') }}" class="flex items-center gap-2.5 font-serif text-2xl font-bold text-white">
                    <span class="inline-flex items-center justify-center rounded-xl bg-[#FBF3E6] p-1 shadow-sm">
                        <img
                            src="{{ asset('aset-demo/logo-sesi-temu-ikon.webp') }}"
                            alt="Logo SesiTemu"
                            class="h-7 w-7 object-contain"
                        >
                    </span>
                    <span>Sesi<span class="text-champagne">Temu</span></span>
                    <span class="ml-0.5 text-xs font-sans font-semibold uppercase tracking-wider text-champagne">Admin</span>
                </a>

                <nav class="hidden md:flex items-center gap-2 text-sm">
                    <a href="{{ route('admin.ringkasan') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('admin.ringkasan') ? 'bg-champagne text-charcoal font-semibold' : 'text-ivory/80 hover:bg-white/10' }}">
                        Ringkasan
                    </a>
                    <a href="{{ route('admin.undangan.index') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('admin.undangan.*') ? 'bg-champagne text-charcoal font-semibold' : 'text-ivory/80 hover:bg-white/10' }}">
                        Undangan
                    </a>
                    <a href="{{ route('admin.tema.index') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('admin.tema.*') ? 'bg-champagne text-charcoal font-semibold' : 'text-ivory/80 hover:bg-white/10' }}">
                        Katalog Tema
                    </a>
                    <a href="{{ route('admin.pengguna.index') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('admin.pengguna.*') ? 'bg-champagne text-charcoal font-semibold' : 'text-ivory/80 hover:bg-white/10' }}">
                        Pengguna
                    </a>
                </nav>
            </div>

            <div class="flex items-center gap-3 text-sm">
                <a href="{{ route('beranda') }}" class="hidden sm:inline text-xs text-ivory/70 hover:text-white">Lihat Beranda</a>
                <form action="{{ route('keluar') }}" method="POST">
                    @csrf
                    <button type="submit" class="rounded-xl border border-ivory/25 px-3.5 py-1.5 text-xs font-semibold text-ivory hover:bg-white/10 transition cursor-pointer">
                        Keluar
                    </button>
                </form>
            </div>
        </div>

        {{-- Mobile Nav --}}
        <div class="md:hidden border-t border-white/10 px-4 py-2 flex gap-2 overflow-x-auto text-xs">
            <a href="{{ route('admin.ringkasan') }}" class="rounded-lg px-3 py-1.5 shrink-0 {{ request()->routeIs('admin.ringkasan') ? 'bg-champagne text-charcoal font-semibold' : 'text-ivory/80' }}">Ringkasan</a>
            <a href="{{ route('admin.undangan.index') }}" class="rounded-lg px-3 py-1.5 shrink-0 {{ request()->routeIs('admin.undangan.*') ? 'bg-champagne text-charcoal font-semibold' : 'text-ivory/80' }}">Undangan</a>
            <a href="{{ route('admin.tema.index') }}" class="rounded-lg px-3 py-1.5 shrink-0 {{ request()->routeIs('admin.tema.*') ? 'bg-champagne text-charcoal font-semibold' : 'text-ivory/80' }}">Katalog Tema</a>
            <a href="{{ route('admin.pengguna.index') }}" class="rounded-lg px-3 py-1.5 shrink-0 {{ request()->routeIs('admin.pengguna.*') ? 'bg-champagne text-charcoal font-semibold' : 'text-ivory/80' }}">Pengguna</a>
        </div>
    </header>

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
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
@endsection
