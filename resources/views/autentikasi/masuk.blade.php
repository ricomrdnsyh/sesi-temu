@extends('layouts.aplikasi')

@section('judul', 'Masuk — SesiTemu')

@section('konten')
<x-tata-letak-auth
    mode="masuk"
    judul-halaman="Selamat Datang Kembali"
    subjudul="Masuk untuk mengelola undangan digital dan memantau RSVP tamu Anda."
>
    @if (session('sukses'))
        <div class="mb-5 rounded-xl bg-sage/10 border border-sage/30 px-4 py-3 text-sm text-sage">
            {{ session('sukses') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-5 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-xs sm:text-sm text-red-700">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        x-data="{ lihatSandi: false }"
        action="{{ route('masuk.proses') }}"
        method="POST"
        class="space-y-4"
        data-swal-loading
        data-swal-loading-title="Memverifikasi Akun..."
        data-swal-loading-text="Sedang masuk ke dasbor Anda..."
    >
        @csrf

        <div>
            <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-charcoal/75">
                Alamat Email
            </label>
            <div class="relative mt-1.5">
                <svg class="w-4 h-4 text-charcoal/40 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect width="20" height="16" x="2" y="4" rx="2" />
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                </svg>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="nama@email.com"
                    class="block w-full rounded-xl border @error('email') border-rose-400 ring-2 ring-rose-500/15 @else border-charcoal/15 @enderror bg-ivory/60 pl-10 pr-4 py-2.5 text-sm text-charcoal placeholder:text-charcoal/40 focus:border-champagne focus:bg-white focus:outline-none focus:ring-2 focus:ring-champagne/25 transition"
                >
            </div>
        </div>

        <div>
            <label for="kata_sandi" class="block text-xs font-semibold uppercase tracking-wider text-charcoal/75">
                Kata Sandi
            </label>
            <div class="relative mt-1.5">
                <svg class="w-4 h-4 text-charcoal/40 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                </svg>
                <input
                    id="kata_sandi"
                    name="kata_sandi"
                    :type="lihatSandi ? 'text' : 'password'"
                    required
                    autocomplete="current-password"
                    placeholder="Masukkan kata sandi"
                    class="block w-full rounded-xl border @error('kata_sandi') border-rose-400 ring-2 ring-rose-500/15 @else border-charcoal/15 @enderror bg-ivory/60 pl-10 pr-11 py-2.5 text-sm text-charcoal placeholder:text-charcoal/40 focus:border-champagne focus:bg-white focus:outline-none focus:ring-2 focus:ring-champagne/25 transition"
                >
                <button
                    type="button"
                    @click="lihatSandi = !lihatSandi"
                    :aria-label="lihatSandi ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                    class="absolute right-3 top-1/2 -translate-y-1/2 p-1 text-charcoal/45 hover:text-charcoal transition cursor-pointer"
                >
                    <svg x-show="!lihatSandi" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    <svg x-show="lihatSandi" x-cloak class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24" />
                        <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68" />
                        <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61" />
                        <line x1="2" x2="22" y1="2" y2="22" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="flex items-center justify-between pt-0.5">
            <label class="inline-flex items-center gap-2 text-xs sm:text-sm text-charcoal/75 cursor-pointer">
                <input type="checkbox" name="ingat_saya" value="1" class="rounded border-charcoal/25 text-sage focus:ring-sage">
                <span>Ingat saya</span>
            </label>

            <a
                href="{{ \App\Support\PengaturanSesiTemu::urlWaAdmin('Halo Admin SesiTemu, saya butuh bantuan reset akses akun saya.') }}"
                target="_blank"
                rel="noopener"
                class="text-xs font-medium text-sage hover:underline"
            >
                Lupa akses?
            </a>
        </div>

        <button
            type="submit"
            class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-sage px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#3A4F45] transition cursor-pointer"
        >
            <span>Masuk Sekarang</span>
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M5 12h14" />
                <path d="m12 5 7 7-7 7" />
            </svg>
        </button>
    </form>

    <p class="mt-6 text-center text-xs sm:text-sm text-charcoal/70">
        Belum punya akun?
        <a href="{{ route('daftar') }}" class="font-semibold text-[#8A6D33] hover:text-sage transition hover:underline">
            Daftar gratis sekarang
        </a>
    </p>
</x-tata-letak-auth>
@endsection
