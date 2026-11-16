@extends('layouts.aplikasi')

@section('judul', 'Dasbor Client — SesiTemu')

@section('konten')
@php
    $penggunaAktif = auth()->user();
@endphp
<div x-data="{ modalBuatBaru: {{ request()->boolean('buat') ? 'true' : 'false' }} }" class="min-h-screen flex flex-col bg-ivory">
    {{-- Header Top Navbar --}}
    <header class="bg-white/95 backdrop-blur-md border-b border-champagne/20 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-14 md:h-16 flex items-center justify-between gap-3">
            <div class="flex items-center gap-3 md:gap-6 min-w-0">
                <a href="{{ route('beranda') }}" class="flex items-center gap-2 font-serif text-xl md:text-2xl font-bold text-charcoal shrink-0">
                    <img
                        src="{{ asset('aset-demo/logo-sesi-temu-ikon.webp') }}"
                        alt="Logo SesiTemu"
                        class="h-8 w-8 md:h-9 md:w-9 object-contain"
                    >
                    <span>Sesi<span class="text-champagne">Temu</span></span>
                </a>
                <span class="hidden md:inline-block text-xs font-semibold uppercase tracking-wider text-sage bg-sage/10 px-3 py-1 rounded-full">
                    Dasbor Undangan
                </span>
            </div>

            <div class="flex items-center gap-2.5 md:gap-4 text-xs sm:text-sm min-w-0">
                @if ($penggunaAktif->adalahAdmin())
                    <a href="{{ route('admin.ringkasan') }}" class="font-semibold text-champagne hover:underline shrink-0">
                        Panel Admin
                    </a>
                @endif

                <a
                    href="{{ route('dasbor.profil.tampil') }}"
                    title="Buka Profil Saya"
                    class="inline-flex items-center gap-2 rounded-full border border-champagne/35 bg-ivory/70 pl-1.5 pr-2.5 sm:pr-3.5 py-1 text-charcoal hover:bg-champagne/10 transition min-w-0"
                >
                    <span class="inline-flex h-6 w-6 md:h-7 md:w-7 items-center justify-center rounded-full bg-sage text-white text-[11px] font-bold shrink-0">
                        {{ $penggunaAktif->inisialNama() }}
                    </span>
                    <span class="truncate max-w-[110px] sm:max-w-[160px] font-medium text-xs md:text-sm">{{ $penggunaAktif->nama }}</span>
                </a>

                <form action="{{ route('keluar') }}" method="POST" class="hidden md:inline-flex shrink-0">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl border border-charcoal/15 px-3 py-1.5 font-semibold text-charcoal hover:bg-charcoal/5 transition cursor-pointer">
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main id="daftar-undangan" class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 pt-5 pb-28 md:py-8 space-y-5 md:space-y-6">
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

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
            <div>
                <div class="flex items-center gap-2 md:hidden mb-1">
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-sage bg-sage/10 px-2.5 py-0.5 rounded-full">
                        Halo, {{ \Illuminate\Support\Str::words(auth()->user()->nama, 2, '') }}
                    </span>
                </div>
                <h1 class="font-serif text-2xl sm:text-3xl font-bold text-charcoal">Undangan Saya</h1>
                <p class="text-xs sm:text-sm text-charcoal/70 mt-1">Kelola draft, jadwal acara, galeri foto, amplop digital, dan pantau RSVP tamu Anda.</p>
            </div>

            <button
                type="button"
                @click="modalBuatBaru = true"
                class="hidden md:inline-flex items-center justify-center rounded-xl bg-sage px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-sage/90 transition cursor-pointer shrink-0"
            >
                + Buat Draft Undangan
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
            @forelse ($daftarUndangan as $undangan)
                @php
                    $kedaluwarsa = $undangan->sudahKedaluwarsa();
                    $jumlahHadir = $undangan->bukuTamu->where('status_kehadiran', 'hadir')->count();
                    $jumlahUcapan = $undangan->bukuTamu->count();
                    $urlPublik = Route::has('undangan.tampil') ? route('undangan.tampil', $undangan->slug) : url('/'.$undangan->slug);
                    $pesanWaAktivasi = "Halo Admin SesiTemu, saya ingin mengaktifkan undangan saya dengan link sesitemu.id/{$undangan->slug} (ID Undangan #{$undangan->id}).";
                @endphp

                <div class="rounded-2xl bg-white p-4 sm:p-6 shadow-sm ring-1 ring-champagne/25 flex flex-col justify-between space-y-4 sm:space-y-5">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-2.5 sm:gap-4">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
                                @if ($kedaluwarsa)
                                    <span class="rounded-full bg-red-100 px-2.5 sm:px-3 py-0.5 sm:py-1 text-[11px] sm:text-xs font-semibold text-red-700">Kedaluwarsa</span>
                                @elseif ($undangan->status_publikasi)
                                    <span class="rounded-full bg-sage/15 px-2.5 sm:px-3 py-0.5 sm:py-1 text-[11px] sm:text-xs font-semibold text-sage">Aktif</span>
                                @else
                                    <span class="rounded-full bg-amber-100 px-2.5 sm:px-3 py-0.5 sm:py-1 text-[11px] sm:text-xs font-semibold text-amber-800">Draft</span>
                                @endif
                                <span class="rounded-full bg-ivory px-2.5 sm:px-3 py-0.5 sm:py-1 text-[11px] sm:text-xs font-medium text-charcoal/75 ring-1 ring-charcoal/10">
                                    Tema: {{ $undangan->tema?->nama_tema ?? '-' }}
                                    @if ($undangan->tema)
                                        ({{ $undangan->tema->tierLabel() }} • {{ $undangan->tema->hargaFormatted() }})
                                    @endif
                                </span>
                            </div>

                            <h2 class="mt-2.5 sm:mt-3 font-serif text-xl sm:text-2xl font-bold text-charcoal truncate">
                                {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
                            </h2>
                            <p class="mt-0.5 sm:mt-1 text-xs sm:text-sm font-mono text-sage truncate">sesitemu.id/{{ $undangan->slug }}</p>
                        </div>

                        <div class="sm:text-right text-xs text-charcoal/65 shrink-0 flex sm:block items-center gap-1.5">
                            @if ($undangan->berlaku_sampai)
                                <p>Berlaku sampai:</p>
                                <p class="font-semibold text-charcoal sm:mt-0.5">{{ $undangan->berlaku_sampai->translatedFormat('d M Y') }}</p>
                            @else
                                @php $transaksiTerakhir = $undangan->transaksi->first(); @endphp
                                @if ($transaksiTerakhir)
                                    <p>Invoice {{ $transaksiTerakhir->kode_invoice }}</p>
                                    <p class="font-semibold text-sage sm:mt-0.5">{{ $transaksiTerakhir->labelStatus() }}</p>
                                @else
                                    <p>Belum diaktifkan</p>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2 sm:gap-3 rounded-xl bg-ivory p-3 sm:p-3.5 text-center border border-champagne/15">
                        <div>
                            <p class="text-[11px] sm:text-xs text-charcoal/60">Acara</p>
                            <p class="font-bold text-base sm:text-lg text-charcoal">{{ $undangan->daftarAcara->count() }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] sm:text-xs text-charcoal/60">Tamu Hadir</p>
                            <p class="font-bold text-base sm:text-lg text-sage">{{ $jumlahHadir }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] sm:text-xs text-charcoal/60">Total Ucapan</p>
                            <p class="font-bold text-base sm:text-lg text-champagne">{{ $jumlahUcapan }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:flex sm:flex-wrap items-center gap-2 sm:gap-2.5">
                        <a
                            href="{{ route('dasbor.undangan.kelola', $undangan) }}"
                            class="col-span-2 sm:col-span-1 sm:flex-1 text-center rounded-xl bg-sage px-4 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition"
                        >
                            Kelola Undangan
                        </a>

                        <a
                            href="{{ $urlPublik }}"
                            target="_blank"
                            class="text-center rounded-xl border border-charcoal/15 px-3.5 sm:px-4 py-2.5 text-xs sm:text-sm font-semibold text-charcoal hover:bg-ivory transition {{ ($undangan->status_publikasi || auth()->user()->adalahAdmin()) ? 'col-span-2 sm:col-span-1' : '' }}"
                        >
                            Lihat Undangan
                        </a>

                        @if (! $undangan->status_publikasi && ! auth()->user()->adalahAdmin())
                            <a
                                href="{{ route('dasbor.undangan.kelola', [$undangan, 'tab' => 'aktivasi']) }}"
                                class="text-center rounded-xl bg-champagne px-3.5 sm:px-4 py-2.5 text-xs sm:text-sm font-semibold text-charcoal hover:bg-champagne/90 transition"
                            >
                                Bayar &amp; Aktifkan
                            </a>
                            <a
                                href="{{ \App\Support\PengaturanSesiTemu::urlWaAdmin($pesanWaAktivasi) }}"
                                target="_blank"
                                rel="noopener"
                                class="col-span-2 sm:col-span-1 text-center rounded-xl border border-champagne px-3.5 sm:px-4 py-2.5 text-xs sm:text-sm font-semibold text-charcoal hover:bg-champagne/10 transition"
                            >
                                Chat WA Admin
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-2xl bg-white p-8 sm:p-12 text-center shadow-sm ring-1 ring-champagne/25">
                    <h2 class="font-serif text-xl sm:text-2xl font-bold text-charcoal">Belum Ada Draft Undangan</h2>
                    <p class="mt-2 text-xs sm:text-sm text-charcoal/70 max-w-md mx-auto">
                        Mulai buat undangan pernikahan digital pertama Anda sekarang. Isi data kapan saja, pratinjau gratis, dan aktifkan saat siap disebar.
                    </p>
                    <button
                        type="button"
                        @click="modalBuatBaru = true"
                        class="mt-5 sm:mt-6 w-full sm:w-auto rounded-xl bg-sage px-6 py-3 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer"
                    >
                        + Buat Draft Undangan Pertama
                    </button>
                </div>
            @endforelse
        </div>
    </main>

    @include('dasbor._bottom-nav', ['halamanAktif' => 'undangan', 'modalBuatOnPage' => true])

    {{-- Modal Buat Draft Undangan Baru (Bottom-sheet di mobile, centered di desktop) --}}
    <div
        x-show="modalBuatBaru"
        x-cloak
        class="fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-charcoal/60 backdrop-blur-sm p-0 sm:p-4"
        @keydown.escape.window="modalBuatBaru = false"
    >
        <div @click.away="modalBuatBaru = false" class="w-full max-w-lg rounded-t-3xl sm:rounded-2xl bg-white p-5 sm:p-6 shadow-xl ring-1 ring-champagne/30 max-h-[90dvh] overflow-y-auto">
            <h3 class="font-serif text-2xl font-bold text-charcoal">Buat Draft Undangan Baru</h3>
            <p class="mt-1 text-sm text-charcoal/70">Isi data singkat awal; detail lengkap dapat diatur di editor 6-tab.</p>

            <form action="{{ route('dasbor.undangan.simpan') }}" method="POST" class="mt-5 space-y-4">
                @csrf

                <div>
                    <label for="tema_id" class="block text-sm font-medium text-charcoal">Pilih Tema</label>
                    <select id="tema_id" name="tema_id" required class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm focus:border-champagne focus:bg-white focus:outline-none">
                        @foreach ($daftarTema as $tema)
                            <option value="{{ $tema->id }}">{{ $tema->nama_tema }} ({{ $tema->kategoriLabel() }} • {{ $tema->tierLabel() }} — {{ $tema->hargaFormatted() }})</option>
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
