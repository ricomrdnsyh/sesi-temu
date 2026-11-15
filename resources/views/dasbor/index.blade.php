@extends('layouts.aplikasi')

@section('judul', 'Dasbor Client — SesiTemu')

@section('konten')
<div x-data="{ modalBuatBaru: false }" class="min-h-screen flex flex-col bg-ivory">
    {{-- Navbar --}}
    <header class="bg-white border-b border-champagne/20 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="{{ route('beranda') }}" class="font-serif text-2xl font-bold text-charcoal">
                    Sesi<span class="text-champagne">Temu</span>
                </a>
                <span class="hidden sm:inline-block text-xs font-semibold uppercase tracking-wider text-sage bg-sage/10 px-3 py-1 rounded-full">
                    Dasbor Undangan
                </span>
            </div>

            <div class="flex items-center gap-4 text-sm">
                @if (auth()->user()->adalahAdmin())
                    <a href="{{ route('admin.ringkasan') }}" class="font-semibold text-champagne hover:underline">
                        Panel Admin
                    </a>
                @endif
                <span class="hidden sm:inline text-charcoal/70">{{ auth()->user()->nama }}</span>
                <form action="{{ route('keluar') }}" method="POST">
                    @csrf
                    <button type="submit" class="rounded-xl border border-charcoal/15 px-3.5 py-1.5 font-semibold text-charcoal hover:bg-charcoal/5 transition cursor-pointer">
                        Keluar
                    </button>
                </form>
            </div>
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

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="font-serif text-3xl font-bold text-charcoal">Undangan Saya</h1>
                <p class="text-sm text-charcoal/70 mt-1">Kelola draft, jadwal acara, galeri foto, amplop digital, dan pantau RSVP tamu Anda.</p>
            </div>

            <button
                type="button"
                @click="modalBuatBaru = true"
                class="inline-flex items-center justify-center rounded-xl bg-sage px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-sage/90 transition cursor-pointer"
            >
                + Buat Draft Undangan
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @forelse ($daftarUndangan as $undangan)
                @php
                    $kedaluwarsa = $undangan->sudahKedaluwarsa();
                    $jumlahHadir = $undangan->bukuTamu->where('status_kehadiran', 'hadir')->count();
                    $jumlahUcapan = $undangan->bukuTamu->count();
                    $urlPublik = Route::has('undangan.tampil') ? route('undangan.tampil', $undangan->slug) : url('/'.$undangan->slug);
                    $pesanWaAktivasi = "Halo Admin SesiTemu, saya ingin mengaktifkan undangan saya dengan link sesitemu.id/{$undangan->slug} (ID Undangan #{$undangan->id}).";
                @endphp

                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/25 flex flex-col justify-between space-y-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                @if ($kedaluwarsa)
                                    <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Kedaluwarsa</span>
                                @elseif ($undangan->status_publikasi)
                                    <span class="rounded-full bg-sage/15 px-3 py-1 text-xs font-semibold text-sage">Aktif</span>
                                @else
                                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">Draft</span>
                                @endif
                                <span class="rounded-full bg-ivory px-3 py-1 text-xs font-medium text-charcoal/75 ring-1 ring-charcoal/10">
                                    Tema: {{ $undangan->tema?->nama_tema ?? '-' }}
                                </span>
                            </div>

                            <h2 class="mt-3 font-serif text-2xl font-bold text-charcoal">
                                {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
                            </h2>
                            <p class="mt-1 text-sm font-mono text-sage">sesitemu.id/{{ $undangan->slug }}</p>
                        </div>

                        <div class="text-right text-xs text-charcoal/65 shrink-0">
                            @if ($undangan->berlaku_sampai)
                                <p>Berlaku sampai</p>
                                <p class="font-semibold text-charcoal mt-0.5">{{ $undangan->berlaku_sampai->translatedFormat('d M Y') }}</p>
                            @else
                                <p>Belum diaktifkan</p>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3 rounded-xl bg-ivory p-3.5 text-center border border-champagne/15">
                        <div>
                            <p class="text-xs text-charcoal/60">Acara</p>
                            <p class="font-bold text-lg text-charcoal">{{ $undangan->daftarAcara->count() }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-charcoal/60">Tamu Hadir</p>
                            <p class="font-bold text-lg text-sage">{{ $jumlahHadir }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-charcoal/60">Total Ucapan</p>
                            <p class="font-bold text-lg text-champagne">{{ $jumlahUcapan }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2.5">
                        <a
                            href="{{ route('dasbor.undangan.kelola', $undangan) }}"
                            class="flex-1 text-center rounded-xl bg-sage px-4 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition"
                        >
                            Kelola Undangan
                        </a>

                        <a
                            href="{{ $urlPublik }}"
                            target="_blank"
                            class="rounded-xl border border-charcoal/15 px-4 py-2.5 text-sm font-semibold text-charcoal hover:bg-ivory transition"
                        >
                            Lihat Undangan
                        </a>

                        @if (! $undangan->status_publikasi && ! auth()->user()->adalahAdmin())
                            <a
                                href="https://wa.me/6281234567890?text={{ urlencode($pesanWaAktivasi) }}"
                                target="_blank"
                                rel="noopener"
                                class="rounded-xl bg-champagne px-4 py-2.5 text-sm font-semibold text-charcoal hover:bg-champagne/90 transition"
                            >
                                Aktifkan via WhatsApp
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-2xl bg-white p-12 text-center shadow-sm ring-1 ring-champagne/25">
                    <h2 class="font-serif text-2xl font-bold text-charcoal">Belum Ada Draft Undangan</h2>
                    <p class="mt-2 text-sm text-charcoal/70 max-w-md mx-auto">
                        Mulai buat undangan pernikahan digital pertama Anda sekarang. Isi data kapan saja, pratinjau gratis, dan aktifkan saat siap disebar.
                    </p>
                    <button
                        type="button"
                        @click="modalBuatBaru = true"
                        class="mt-6 rounded-xl bg-sage px-6 py-3 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer"
                    >
                        + Buat Draft Undangan Pertama
                    </button>
                </div>
            @endforelse
        </div>
    </main>

    {{-- Modal Buat Draft Undangan Baru --}}
    <div
        x-show="modalBuatBaru"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-charcoal/60 backdrop-blur-sm p-4"
        @keydown.escape.window="modalBuatBaru = false"
    >
        <div @click.away="modalBuatBaru = false" class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl ring-1 ring-champagne/30">
            <h3 class="font-serif text-2xl font-bold text-charcoal">Buat Draft Undangan Baru</h3>
            <p class="mt-1 text-sm text-charcoal/70">Isi data singkat awal; detail lengkap dapat diatur di editor 6-tab.</p>

            <form action="{{ route('dasbor.undangan.simpan') }}" method="POST" class="mt-5 space-y-4">
                @csrf

                <div>
                    <label for="tema_id" class="block text-sm font-medium text-charcoal">Pilih Tema</label>
                    <select id="tema_id" name="tema_id" required class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm focus:border-champagne focus:bg-white focus:outline-none">
                        @foreach ($daftarTema as $tema)
                            <option value="{{ $tema->id }}">{{ $tema->nama_tema }} ({{ ucfirst($tema->kategori) }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="slug_baru" class="block text-sm font-medium text-charcoal">Link Undangan</label>
                    <div class="mt-1.5 flex items-center rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2.5">
                        <span class="text-sm text-charcoal/50">sesitemu.id/</span>
                        <input id="slug_baru" name="slug" type="text" required placeholder="raka-maya" class="w-full bg-transparent text-sm font-semibold focus:outline-none ml-0.5">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="nama_panggilan_pria" class="block text-sm font-medium text-charcoal">Panggilan Pria</label>
                        <input id="nama_panggilan_pria" name="nama_panggilan_pria" type="text" required placeholder="Raka" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm focus:border-champagne focus:bg-white focus:outline-none">
                    </div>
                    <div>
                        <label for="nama_lengkap_pria" class="block text-sm font-medium text-charcoal">Nama Lengkap Pria</label>
                        <input id="nama_lengkap_pria" name="nama_lengkap_pria" type="text" required placeholder="Raka Wijaya" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm focus:border-champagne focus:bg-white focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="nama_panggilan_wanita" class="block text-sm font-medium text-charcoal">Panggilan Wanita</label>
                        <input id="nama_panggilan_wanita" name="nama_panggilan_wanita" type="text" required placeholder="Maya" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm focus:border-champagne focus:bg-white focus:outline-none">
                    </div>
                    <div>
                        <label for="nama_lengkap_wanita" class="block text-sm font-medium text-charcoal">Nama Lengkap Wanita</label>
                        <input id="nama_lengkap_wanita" name="nama_lengkap_wanita" type="text" required placeholder="Maya Sari" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm focus:border-champagne focus:bg-white focus:outline-none">
                    </div>
                </div>

                <div class="pt-2 flex justify-end gap-3">
                    <button type="button" @click="modalBuatBaru = false" class="rounded-xl px-4 py-2 text-sm font-semibold text-charcoal/70 hover:bg-charcoal/5 cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="rounded-xl bg-sage px-5 py-2 text-sm font-semibold text-white hover:bg-sage/90 cursor-pointer">
                        Simpan Draft
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
