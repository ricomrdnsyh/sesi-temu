@extends('layouts.aplikasi')

@section('judul', 'Masuk — SesiTemu')

@section('konten')
<div class="min-h-screen flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8 bg-ivory relative overflow-hidden">
    <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-champagne/10 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 rounded-full bg-sage/10 blur-3xl pointer-events-none"></div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md relative z-10">
        <a href="{{ route('beranda') }}" class="flex flex-col items-center justify-center text-charcoal">
            <img
                src="{{ asset('aset-demo/logo-sesi-temu-lengkap.webp') }}"
                alt="Logo SesiTemu"
                class="h-24 w-auto object-contain"
            >
            <span class="sr-only">SesiTemu</span>
        </a>
        <h1 class="mt-3 text-center font-serif text-3xl font-semibold text-charcoal">
            Masuk ke Akun Anda
        </h1>
        <p class="mt-2 text-center text-sm text-charcoal/70">
            Kelola undangan pernikahan digital dan pantau buku tamu Anda.
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md relative z-10">
        <div class="bg-white py-8 px-6 shadow-sm ring-1 ring-champagne/20 rounded-2xl sm:px-10">
            @if (session('sukses'))
                <div class="mb-5 rounded-xl bg-sage/10 border border-sage/30 px-4 py-3 text-sm text-sage">
                    {{ session('sukses') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('masuk.proses') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-charcoal">Alamat Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        placeholder="nama@email.com"
                        class="mt-1.5 block w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm text-charcoal placeholder:text-charcoal/40 focus:border-champagne focus:bg-white focus:outline-none focus:ring-2 focus:ring-champagne/25"
                    >
                </div>

                <div>
                    <label for="kata_sandi" class="block text-sm font-medium text-charcoal">Kata Sandi</label>
                    <input
                        id="kata_sandi"
                        name="kata_sandi"
                        type="password"
                        required
                        placeholder="Masukkan kata sandi"
                        class="mt-1.5 block w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm text-charcoal placeholder:text-charcoal/40 focus:border-champagne focus:bg-white focus:outline-none focus:ring-2 focus:ring-champagne/25"
                    >
                </div>

                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center gap-2 text-sm text-charcoal/75 cursor-pointer">
                        <input type="checkbox" name="ingat_saya" value="1" class="rounded border-charcoal/25 text-sage focus:ring-sage">
                        <span>Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="w-full rounded-xl bg-sage px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-sage/90 transition cursor-pointer">
                    Masuk Sekarang
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-charcoal/70">
                Belum punya akun?
                <a href="{{ route('daftar') }}" class="font-semibold text-champagne hover:underline">
                    Daftar gratis sekarang
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
