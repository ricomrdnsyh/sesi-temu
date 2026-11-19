@extends('layouts.aplikasi')

@section('judul', 'Dasbor Client — SesiTemu')

@section('konten')
@php
    $pengguna = auth()->user();
    $jumlahUndangan = $daftarUndangan->count();
    $jumlahUndanganAktif = $daftarUndangan->filter(fn ($u) => $u->status_publikasi && ! $u->sudahKedaluwarsa())->count();
    $totalTamuHadir = $daftarUndangan->sum(fn ($u) => $u->bukuTamu->where('status_kehadiran', 'hadir')->count());
    $temaDefaultId = (string) old('tema_id', (string) ($daftarTema->first()?->id ?? ''));
@endphp

<div
    x-data="{
        modalBuatBaru: {{ request()->boolean('buat') ? 'true' : 'false' }},
        temaTerpilihModal: @js($temaDefaultId),
        bukaModalDenganTema(temaId) {
            this.temaTerpilihModal = String(temaId);
            this.modalBuatBaru = true;
        }
    }"
    class="min-h-screen flex flex-col bg-ivory"
>
    @include('dasbor._top-nav', ['halamanAktif' => 'undangan'])

    <main id="daftar-undangan" class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6 pb-28 md:py-8 space-y-6">
        @if ($errors->any())
            <div class="rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Kartu Sambutan Hero Mobile-First --}}
        <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#1B2D24] via-charcoal to-[#262B31] text-ivory p-5 sm:p-7 shadow-lg ring-1 ring-champagne/30">
            <div class="pointer-events-none absolute -top-12 -right-12 h-44 w-44 rounded-full bg-champagne/15 blur-2xl"></div>
            <div class="pointer-events-none absolute -bottom-14 -left-10 h-36 w-36 rounded-full bg-sage/20 blur-2xl"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-5">
                <div class="space-y-2 max-w-2xl">
                    <div class="inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/10 px-3 py-1">
                        <span class="h-1.5 w-1.5 rounded-full bg-champagne"></span>
                        <span class="text-[11px] font-semibold uppercase tracking-wider text-champagne">
                            Halo, {{ \Illuminate\Support\Str::words($pengguna->nama, 3, '') }}
                        </span>
                    </div>

                    <h1 class="font-logo text-2xl sm:text-3xl font-bold text-white leading-snug">
                        {{ $jumlahUndangan > 0 ? 'Kelola Undangan Pernikahan Anda' : 'Wujudkan Undangan Digital Impian' }}
                    </h1>
                    <p class="text-xs sm:text-sm text-ivory/75 leading-relaxed">
                        {{ $jumlahUndangan > 0
                            ? 'Pantau konfirmasi kehadiran tamu, perbarui galeri & acara, atau ganti tema kapan saja tanpa kehilangan data.'
                            : 'Susun undangan elegan dalam hitungan menit, pratinjau sepuasnya gratis, dan aktifkan saat siap disebar.' }}
                    </p>

                    <div class="pt-2 grid grid-cols-2 sm:flex sm:flex-wrap gap-2.5">
                        <button
                            type="button"
                            @click="modalBuatBaru = true"
                            class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-champagne px-4 py-2.5 text-xs sm:text-sm font-bold text-charcoal shadow-sm hover:bg-champagne/90 transition cursor-pointer"
                        >
                            <span>+ Buat Draft</span>
                        </button>
                        <a
                            href="{{ route('dasbor.katalog') }}"
                            class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-white/10 border border-white/15 px-4 py-2.5 text-xs sm:text-sm font-semibold text-ivory hover:bg-white/15 transition"
                        >
                            <span>Jelajahi Katalog</span>
                        </a>
                    </div>
                </div>

                {{-- 3 Metrik Ringkas --}}
                <div class="grid grid-cols-3 gap-2 sm:gap-3 rounded-2xl bg-white/8 border border-white/10 p-3 sm:px-5 sm:py-4 text-center shrink-0">
                    <div class="px-1 sm:px-2">
                        <p class="text-[11px] text-ivory/65">Undangan</p>
                        <p class="mt-0.5 text-lg sm:text-2xl font-bold text-white">{{ $jumlahUndangan }}</p>
                    </div>
                    <div class="px-1 sm:px-2 border-x border-white/10">
                        <p class="text-[11px] text-ivory/65">Aktif</p>
                        <p class="mt-0.5 text-lg sm:text-2xl font-bold text-champagne">{{ $jumlahUndanganAktif }}</p>
                    </div>
                    <div class="px-1 sm:px-2">
                        <p class="text-[11px] text-ivory/65">Tamu Hadir</p>
                        <p class="mt-0.5 text-lg sm:text-2xl font-bold text-white">{{ $totalTamuHadir }}</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Daftar Undangan Client --}}
        <section class="space-y-3.5">
            <div class="flex items-center justify-between gap-2">
                <h2 class="text-base sm:text-lg font-bold text-charcoal">Undangan Saya</h2>
                @if ($jumlahUndangan > 0)
                    <span class="text-xs text-charcoal/60">{{ $jumlahUndangan }} undangan tersimpan</span>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-5">
                @forelse ($daftarUndangan as $undangan)
                    @php
                        $kedaluwarsa = $undangan->sudahKedaluwarsa();
                        $jumlahHadir = $undangan->bukuTamu->where('status_kehadiran', 'hadir')->count();
                        $jumlahUcapan = $undangan->bukuTamu->count();
                        $urlPublik = Route::has('undangan.tampil') ? route('undangan.tampil', $undangan->slug) : url('/'.$undangan->slug);
                        $pesanWaAktivasi = "Halo Admin SesiTemu, saya ingin mengaktifkan undangan saya dengan link sesitemu.id/{$undangan->slug} (ID Undangan #{$undangan->id}).";
                    @endphp

                    <div class="rounded-2xl bg-white p-4 sm:p-5 shadow-sm ring-1 ring-champagne/25 flex flex-col justify-between space-y-4">
                        <div class="flex items-start gap-3.5">
                            @if ($undangan->tema?->urlGambarPratinjau())
                                <img
                                    src="{{ $undangan->tema->urlGambarPratinjau() }}"
                                    alt="{{ $undangan->tema->nama_tema }}"
                                    class="h-16 w-16 sm:h-20 sm:w-20 rounded-2xl object-cover ring-1 ring-champagne/30 shrink-0"
                                >
                            @else
                                <div class="h-16 w-16 sm:h-20 sm:w-20 rounded-2xl bg-sage/10 text-sage flex items-center justify-center font-logo font-bold text-lg shrink-0">
                                    ST
                                </div>
                            @endif

                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center justify-between gap-1.5">
                                    <div class="flex flex-wrap items-center gap-1.5">
                                        @if ($kedaluwarsa)
                                            <span class="rounded-full bg-red-100 px-2.5 py-0.5 text-[11px] font-semibold text-red-700">Kedaluwarsa</span>
                                        @elseif ($undangan->status_publikasi)
                                            <span class="rounded-full bg-sage/15 px-2.5 py-0.5 text-[11px] font-semibold text-sage">Aktif</span>
                                        @else
                                            <span class="rounded-full bg-amber-100 px-2.5 py-0.5 text-[11px] font-semibold text-amber-800">Draft</span>
                                        @endif

                                        <span class="rounded-full bg-ivory px-2.5 py-0.5 text-[11px] font-medium text-charcoal/75 ring-1 ring-charcoal/10 truncate max-w-[170px] sm:max-w-none">
                                            {{ $undangan->tema?->nama_tema ?? '-' }}
                                            @if ($undangan->tema)
                                                • {{ $undangan->tema->hargaFormatted() }}
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <h3 class="mt-2 font-logo text-lg sm:text-xl font-bold text-charcoal truncate">
                                    {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
                                </h3>
                                <p class="text-xs font-mono text-sage truncate">sesitemu.id/{{ $undangan->slug }}</p>

                                <p class="mt-1 text-[11px] text-charcoal/60">
                                    @if ($undangan->berlaku_sampai)
                                        Aktif s.d. <span class="font-semibold text-charcoal">{{ $undangan->berlaku_sampai->translatedFormat('d M Y') }}</span>
                                    @else
                                        @php $transaksiTerakhir = $undangan->transaksi->first(); @endphp
                                        @if ($transaksiTerakhir)
                                            Invoice <span class="font-mono font-semibold">{{ $transaksiTerakhir->kode_invoice }}</span> • {{ $transaksiTerakhir->labelStatus() }}
                                        @else
                                            Draft gratis • Siap dilengkapi
                                        @endif
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-2 rounded-xl bg-ivory p-2.5 sm:p-3 text-center border border-champagne/15">
                            <div>
                                <p class="text-[11px] text-charcoal/60">Acara</p>
                                <p class="font-bold text-sm sm:text-base text-charcoal">{{ $undangan->daftarAcara->count() }}</p>
                            </div>
                            <div>
                                <p class="text-[11px] text-charcoal/60">Tamu Hadir</p>
                                <p class="font-bold text-sm sm:text-base text-sage">{{ $jumlahHadir }}</p>
                            </div>
                            <div>
                                <p class="text-[11px] text-charcoal/60">Total Ucapan</p>
                                <p class="font-bold text-sm sm:text-base text-champagne">{{ $jumlahUcapan }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 sm:flex sm:flex-wrap items-center gap-2">
                            <a
                                href="{{ route('dasbor.undangan.kelola', $undangan) }}"
                                class="col-span-2 sm:col-span-1 sm:flex-1 text-center rounded-xl bg-sage px-4 py-2.5 text-xs sm:text-sm font-semibold text-white hover:bg-sage/90 transition"
                            >
                                Kelola Undangan
                            </a>

                            <a
                                href="{{ $urlPublik }}"
                                target="_blank"
                                class="text-center rounded-xl border border-charcoal/15 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-charcoal hover:bg-ivory transition {{ ($undangan->status_publikasi || auth()->user()->adalahAdmin()) ? 'col-span-2 sm:col-span-1' : '' }}"
                            >
                                Lihat Undangan
                            </a>

                            @if (! $undangan->status_publikasi && ! auth()->user()->adalahAdmin())
                                <a
                                    href="{{ route('dasbor.undangan.kelola', [$undangan, 'tab' => 'aktivasi']) }}"
                                    class="text-center rounded-xl bg-champagne px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-charcoal hover:bg-champagne/90 transition"
                                >
                                    Bayar &amp; Aktifkan
                                </a>
                                <a
                                    href="{{ \App\Support\PengaturanSesiTemu::urlWaAdmin($pesanWaAktivasi) }}"
                                    target="_blank"
                                    rel="noopener"
                                    class="col-span-2 sm:col-span-1 text-center rounded-xl border border-champagne px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-charcoal hover:bg-champagne/10 transition"
                                >
                                    Chat WA Admin
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full rounded-3xl bg-white p-6 sm:p-10 shadow-sm ring-1 ring-champagne/25 space-y-6">
                        <div class="text-center max-w-md mx-auto space-y-3">
                            <div class="mx-auto inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-sage/15 to-champagne/25 ring-1 ring-champagne/35">
                                <img
                                    src="{{ asset('logo/logo-ikon.webp') }}"
                                    alt="SesiTemu"
                                    class="h-11 w-11 object-contain"
                                >
                            </div>
                            <h3 class="font-logo text-xl sm:text-2xl font-bold text-charcoal">Belum Ada Draft Undangan</h3>
                            <p class="text-xs sm:text-sm text-charcoal/70 leading-relaxed">
                                Mulai buat undangan pernikahan digital pertama Anda. Cukup pilih tema di bawah atau klik tombol mulai untuk menyiapkan draft gratis.
                            </p>
                            <div class="pt-1">
                                <button
                                    type="button"
                                    @click="modalBuatBaru = true"
                                    class="w-full sm:w-auto rounded-xl bg-sage px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-sage/90 transition cursor-pointer"
                                >
                                    + Buat Draft Undangan Pertama
                                </button>
                            </div>
                        </div>

                        {{-- 3 Langkah Mudah --}}
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 sm:gap-4 pt-4 border-t border-champagne/15">
                            <div class="flex sm:flex-col items-center sm:text-center gap-3 sm:gap-1.5 rounded-2xl bg-ivory/80 p-3.5 ring-1 ring-champagne/15">
                                <span class="h-7 w-7 rounded-full bg-sage text-white text-xs font-bold flex items-center justify-center shrink-0">1</span>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-charcoal">Pilih Tema Desain</p>
                                    <p class="text-[11px] text-charcoal/65">Sesuaikan konsep modern, adat, luxury, atau islami.</p>
                                </div>
                            </div>
                            <div class="flex sm:flex-col items-center sm:text-center gap-3 sm:gap-1.5 rounded-2xl bg-ivory/80 p-3.5 ring-1 ring-champagne/15">
                                <span class="h-7 w-7 rounded-full bg-champagne text-charcoal text-xs font-bold flex items-center justify-center shrink-0">2</span>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-charcoal">Lengkapi Konten</p>
                                    <p class="text-[11px] text-charcoal/65">Isi data mempelai, jadwal acara, galeri foto, &amp; amplop.</p>
                                </div>
                            </div>
                            <div class="flex sm:flex-col items-center sm:text-center gap-3 sm:gap-1.5 rounded-2xl bg-ivory/80 p-3.5 ring-1 ring-champagne/15">
                                <span class="h-7 w-7 rounded-full bg-charcoal text-champagne text-xs font-bold flex items-center justify-center shrink-0">3</span>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-charcoal">Aktif &amp; Sebar Tamu</p>
                                    <p class="text-[11px] text-charcoal/65">Kirim undangan personal langsung via WhatsApp.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- Rekomendasi Tema Populer (Swipe Carousel di Mobile, Grid di Desktop) --}}
        @if ($daftarTema->isNotEmpty())
            <section class="space-y-3.5">
                <div class="flex items-center justify-between gap-2">
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-charcoal">Pilihan Tema Favorit</h2>
                        <p class="text-xs text-charcoal/60">Tap tema untuk langsung membuat draft undangan.</p>
                    </div>
                    <a href="{{ route('dasbor.katalog') }}" class="text-xs sm:text-sm font-semibold text-sage hover:underline shrink-0">
                        Lihat Semua ›
                    </a>
                </div>

                <div class="flex overflow-x-auto no-scrollbar gap-3.5 snap-x pb-1 lg:grid lg:grid-cols-4 lg:overflow-visible">
                    @foreach ($daftarTema->take(4) as $tema)
                        @php $infoTier = $tema->infoTier(); @endphp
                        <div class="w-64 sm:w-72 lg:w-auto shrink-0 snap-start rounded-2xl bg-white overflow-hidden ring-1 ring-champagne/25 shadow-xs flex flex-col justify-between">
                            <div>
                                <div class="aspect-[16/10] bg-ivory relative overflow-hidden">
                                    @if ($tema->urlGambarPratinjau())
                                        <img
                                            src="{{ $tema->urlGambarPratinjau() }}"
                                            alt="{{ $tema->nama_tema }}"
                                            class="w-full h-full object-cover"
                                        >
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-sage/10 text-sage font-logo font-bold text-lg">
                                            {{ $tema->nama_tema }}
                                        </div>
                                    @endif

                                    <span class="absolute top-2.5 left-2.5 rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider {{ $infoTier['badge_class'] }}">
                                        {{ $infoTier['label'] }}
                                    </span>

                                    @if ($tema->adaDiskon())
                                        <span class="absolute top-2.5 right-2.5 rounded-full bg-rose-600 px-2 py-0.5 text-[10px] font-bold text-white shadow-xs">
                                            {{ $tema->labelBadgeDiskon() }}
                                        </span>
                                    @endif
                                </div>

                                <div class="p-3.5 space-y-1">
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-champagne">{{ $tema->kategoriLabel() }}</p>
                                    <h3 class="font-logo text-base font-bold text-charcoal truncate">{{ $tema->nama_tema }}</h3>
                                    <div class="flex items-baseline gap-1.5 pt-0.5">
                                        @if ($tema->adaDiskon())
                                            <span class="text-[11px] text-charcoal/45 line-through">{{ $tema->hargaAsliFormatted() }}</span>
                                        @endif
                                        <span class="text-sm font-extrabold {{ $tema->adaDiskon() ? 'text-rose-600' : 'text-sage' }}">
                                            {{ $tema->hargaFormatted() }}
                                        </span>
                                        <span class="text-[11px] text-charcoal/55">/ {{ $durasiAktifBulan }} bln</span>
                                    </div>
                                </div>
                            </div>

                            <div class="px-3.5 pb-3.5 flex items-center gap-2">
                                <a
                                    href="{{ route('tema.demo', ['slugTema' => $tema->slug, 'dari' => 'katalog']) }}"
                                    class="rounded-xl border border-champagne/60 px-3 py-2 text-xs font-semibold text-charcoal hover:bg-champagne/10 transition"
                                >
                                    Demo
                                </a>
                                <button
                                    type="button"
                                    @click="bukaModalDenganTema({{ $tema->id }})"
                                    class="flex-1 rounded-xl bg-sage px-3 py-2 text-xs font-semibold text-white hover:bg-sage/90 transition cursor-pointer"
                                >
                                    Pakai Tema →
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
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
            <h3 class="font-logo text-2xl font-bold text-charcoal">Buat Draft Undangan Baru</h3>
            <p class="mt-1 text-sm text-charcoal/70">Isi data singkat awal; detail lengkap dapat diatur di editor 7-tab.</p>

            <form
                action="{{ route('dasbor.undangan.simpan') }}"
                method="POST"
                class="mt-5 space-y-4"
                data-swal-loading
                data-swal-loading-title="Membuat Draft Undangan..."
                data-swal-loading-text="Menyiapkan link dan halaman editor undangan Anda..."
            >
                @csrf

                <div>
                    <label for="tema_id" class="block text-sm font-medium text-charcoal">Pilih Tema</label>
                    <select id="tema_id" name="tema_id" x-model="temaTerpilihModal" required class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm focus:border-champagne focus:bg-white focus:outline-none">
                        @foreach ($daftarTema as $tema)
                            <option value="{{ $tema->id }}">{{ $tema->nama_tema }} ({{ $tema->kategoriLabel() }} • {{ $tema->tierLabel() }} — {{ $tema->hargaFormatted() }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="slug_baru" class="block text-sm font-medium text-charcoal">Link Undangan</label>
                    <div class="mt-1.5 flex items-center rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2.5">
                        <span class="text-sm text-charcoal/50">sesitemu.id/</span>
                        <input id="slug_baru" name="slug" type="text" value="{{ old('slug', request()->query('slug', '')) }}" required placeholder="raka-maya" class="w-full bg-transparent text-sm font-semibold focus:outline-none ml-0.5">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="nama_panggilan_pria" class="block text-sm font-medium text-charcoal">Panggilan Pria</label>
                        <input id="nama_panggilan_pria" name="nama_panggilan_pria" type="text" value="{{ old('nama_panggilan_pria') }}" required placeholder="Raka" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm focus:border-champagne focus:bg-white focus:outline-none">
                    </div>
                    <div>
                        <label for="nama_lengkap_pria" class="block text-sm font-medium text-charcoal">Nama Lengkap Pria</label>
                        <input id="nama_lengkap_pria" name="nama_lengkap_pria" type="text" value="{{ old('nama_lengkap_pria') }}" required placeholder="Raka Wijaya" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm focus:border-champagne focus:bg-white focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="nama_panggilan_wanita" class="block text-sm font-medium text-charcoal">Panggilan Wanita</label>
                        <input id="nama_panggilan_wanita" name="nama_panggilan_wanita" type="text" value="{{ old('nama_panggilan_wanita') }}" required placeholder="Maya" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm focus:border-champagne focus:bg-white focus:outline-none">
                    </div>
                    <div>
                        <label for="nama_lengkap_wanita" class="block text-sm font-medium text-charcoal">Nama Lengkap Wanita</label>
                        <input id="nama_lengkap_wanita" name="nama_lengkap_wanita" type="text" value="{{ old('nama_lengkap_wanita') }}" required placeholder="Maya Sari" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm focus:border-champagne focus:bg-white focus:outline-none">
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
