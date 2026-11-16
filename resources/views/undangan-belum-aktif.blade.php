@extends('layouts.aplikasi')

@section('judul', 'Undangan Belum Diaktifkan — SesiTemu')

@section('konten')
<div class="min-h-screen flex items-center justify-center bg-ivory px-4 py-16">
    <div class="max-w-lg w-full rounded-2xl bg-white p-8 sm:p-10 text-center shadow-sm ring-1 ring-champagne/25 space-y-5">
        <a href="{{ route('beranda') }}" class="inline-block">
            <img
                src="{{ asset('aset-demo/logo-sesi-temu-lengkap.webp') }}"
                alt="Logo SesiTemu"
                class="h-20 w-auto mx-auto object-contain"
            >
        </a>

        <div>
            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3.5 py-1 text-xs font-semibold text-amber-800">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                Undangan Belum Diaktifkan
            </span>
        </div>

        <h1 class="font-serif text-3xl font-bold text-charcoal">Undangan Belum Dapat Diakses</h1>

        <p class="text-sm text-charcoal/70 leading-relaxed">
            Mohon maaf, undangan digital untuk pasangan
            <strong class="text-charcoal">{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</strong>
            (<span class="font-mono text-sage">sesitemu.id/{{ $undangan->slug }}</span>)
            saat ini masih berstatus <strong class="text-charcoal">Draft</strong> dan belum diaktifkan oleh pemilik undangan.
        </p>

        <p class="text-xs text-charcoal/60 leading-relaxed">
            Jika Anda adalah pemilik undangan ini, silakan masuk ke akun SesiTemu untuk melihat pratinjau atau menyelesaikan pembayaran &amp; aktivasi.
        </p>

        <div class="pt-2 flex flex-wrap justify-center gap-3">
            <a href="{{ route('beranda') }}" class="rounded-xl border border-charcoal/15 px-5 py-2.5 text-sm font-semibold text-charcoal hover:bg-ivory transition">
                Ke Beranda SesiTemu
            </a>

            @auth
                <a href="{{ route('dasbor.index') }}" class="rounded-xl bg-sage px-5 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition">
                    Buka Dasbor Saya
                </a>
            @else
                <a href="{{ route('login') }}" class="rounded-xl bg-sage px-5 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition">
                    Masuk sebagai Pemilik
                </a>
            @endauth
        </div>
    </div>
</div>
@endsection
