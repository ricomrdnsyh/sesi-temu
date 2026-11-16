@extends('layouts.aplikasi')

@section('judul', 'Daftar Akun — SesiTemu')

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
            Buat Akun SesiTemu
        </h1>
        <p class="mt-2 text-center text-sm text-charcoal/70">
            Mulai susun undangan pernikahan digital impian Anda secara gratis.
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md relative z-10">
        <div class="bg-white py-8 px-6 shadow-sm ring-1 ring-champagne/20 rounded-2xl sm:px-10">
            @if (session('sukses'))
                <div class="mb-5 rounded-xl bg-sage/10 border border-sage/30 px-4 py-3 text-sm text-sage">
                    {{ session('sukses') }}
                </div>
            @endif

            @if ($slugTerpilih || $temaTerpilih)
                <div class="mb-5 rounded-xl bg-champagne/10 border border-champagne/30 px-4 py-3 text-xs text-charcoal space-y-1">
                    <p class="font-semibold text-charcoal">Draft Undangan Awal Anda Siap Dibuat:</p>
                    @if ($slugTerpilih)
                        <p>Link Undangan: <span class="font-mono font-semibold text-sage">sesitemu.id/{{ $slugTerpilih }}</span></p>
                    @endif
                    @if ($temaTerpilih)
                        <p>
                            Tema Pilihan:
                            <span class="font-semibold text-sage">{{ $temaTerpilih->nama_tema }}</span>
                            <span class="ml-1 inline-block rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $temaTerpilih->infoTier()['chip_class'] }}">
                                {{ $temaTerpilih->tierLabel() }} — {{ $temaTerpilih->hargaFormatted() }}
                            </span>
                        </p>
                    @endif
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

            <form
                action="{{ route('daftar.proses') }}"
                method="POST"
                class="space-y-4"
                data-swal-loading
                data-swal-loading-title="Membuat Akun &amp; Draft..."
                data-swal-loading-text="Menyiapkan akun client dan link undangan pertama Anda..."
            >
                @csrf
                <input type="hidden" name="slug" value="{{ old('slug', $slugTerpilih) }}">
                <input type="hidden" name="tema_id" value="{{ old('tema_id', $temaTerpilih?->id) }}">

                <div>
                    <label for="nama" class="block text-sm font-medium text-charcoal">Nama Lengkap</label>
                    <input
                        id="nama"
                        name="nama"
                        type="text"
                        value="{{ old('nama') }}"
                        required
                        autofocus
                        placeholder="Contoh: Dimas Pratama"
                        class="mt-1.5 block w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm text-charcoal placeholder:text-charcoal/40 focus:border-champagne focus:bg-white focus:outline-none focus:ring-2 focus:ring-champagne/25"
                    >
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-charcoal">Alamat Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        placeholder="nama@email.com"
                        class="mt-1.5 block w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm text-charcoal placeholder:text-charcoal/40 focus:border-champagne focus:bg-white focus:outline-none focus:ring-2 focus:ring-champagne/25"
                    >
                </div>

                <div>
                    <label for="nomor_wa" class="block text-sm font-medium text-charcoal">Nomor WhatsApp</label>
                    <input
                        id="nomor_wa"
                        name="nomor_wa"
                        type="text"
                        value="{{ old('nomor_wa') }}"
                        placeholder="Contoh: 081234567890"
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
                        placeholder="Minimal 8 karakter"
                        class="mt-1.5 block w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm text-charcoal placeholder:text-charcoal/40 focus:border-champagne focus:bg-white focus:outline-none focus:ring-2 focus:ring-champagne/25"
                    >
                </div>

                <div>
                    <label for="kata_sandi_confirmation" class="block text-sm font-medium text-charcoal">Konfirmasi Kata Sandi</label>
                    <input
                        id="kata_sandi_confirmation"
                        name="kata_sandi_confirmation"
                        type="password"
                        required
                        placeholder="Ulangi kata sandi"
                        class="mt-1.5 block w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm text-charcoal placeholder:text-charcoal/40 focus:border-champagne focus:bg-white focus:outline-none focus:ring-2 focus:ring-champagne/25"
                    >
                </div>

                <button type="submit" class="w-full rounded-xl bg-sage px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-sage/90 transition cursor-pointer">
                    Daftar &amp; Buat Undangan
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-charcoal/70">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-semibold text-champagne hover:underline">
                    Masuk di sini
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
