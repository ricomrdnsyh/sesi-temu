@extends('layouts.aplikasi')

@section('judul', 'Masa Aktif Undangan Berakhir — SesiTemu')

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
            <span class="inline-block rounded-full bg-amber-100 px-3.5 py-1 text-xs font-semibold text-amber-800">
                Undangan Nonaktif
            </span>
        </div>
        <h1 class="font-serif text-3xl font-bold text-charcoal">Masa Aktif Undangan Telah Berakhir</h1>
        <p class="text-sm text-charcoal/70 leading-relaxed">
            Mohon maaf, masa aktif undangan digital untuk pasangan
            <strong class="text-charcoal">{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</strong>
            (<span class="font-mono text-sage">sesitemu.id/{{ $undangan->slug }}</span>) telah berakhir.
        </p>
        <p class="text-xs text-charcoal/60">
            Jika Anda pemilik undangan dan ingin memperpanjang masa aktif, silakan hubungi Admin SesiTemu melalui WhatsApp.
        </p>
        <div class="pt-2 flex flex-wrap justify-center gap-3">
            <a href="{{ route('beranda') }}" class="rounded-xl border border-charcoal/15 px-5 py-2.5 text-sm font-semibold text-charcoal hover:bg-ivory">
                Ke Beranda SesiTemu
            </a>
            <a
                href="{{ \App\Support\PengaturanSesiTemu::urlWaAdmin('Halo Admin SesiTemu, saya ingin memperpanjang masa aktif undangan sesitemu.id/'.$undangan->slug) }}"
                target="_blank"
                rel="noopener"
                class="rounded-xl bg-sage px-5 py-2.5 text-sm font-semibold text-white hover:bg-sage/90"
            >
                Hubungi Admin WA
            </a>
        </div>
    </div>
</div>
@endsection
