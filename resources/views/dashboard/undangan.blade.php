@extends('layouts.aplikasi')

@section('judul', 'Undangan Saya | SesiTemu')

@section('konten')
    @php
        $pengguna = auth()->user();
        $jumlahSemua = $daftarUndangan->count();
        $jumlahAktif = $daftarUndangan->filter(fn($u) => $u->statusKode() === 'aktif')->count();
        $jumlahDraft = $daftarUndangan->filter(fn($u) => $u->statusKode() === 'draft')->count();
        $jumlahKedaluwarsa = $daftarUndangan->filter(fn($u) => $u->statusKode() === 'kedaluwarsa')->count();
        $totalTamuHadir = $daftarUndangan->sum(fn($u) => $u->bukuTamu->where('status_kehadiran', 'hadir')->count());
        $temaDefaultId = (string) old('tema_id', (string) ($daftarTema->first()?->id ?? ''));

        $jamSekarang = now()->hour;
        $sapaanWaktu = match (true) {
            $jamSekarang >= 4 && $jamSekarang < 11 => 'Selamat Pagi',
            $jamSekarang >= 11 && $jamSekarang < 15 => 'Selamat Siang',
            $jamSekarang >= 15 && $jamSekarang < 18 => 'Selamat Sore',
            default => 'Selamat Malam',
        };
        $namaTampilAkun = trim((string) $pengguna->nama);

        $daftarFilterJson = $daftarUndangan
            ->map(
                fn($u) => [
                    'status' => $u->statusKode(),
                    'teks' => strtolower(
                        trim(
                            $u->nama_panggilan_pria .
                                ' ' .
                                $u->nama_panggilan_wanita .
                                ' ' .
                                $u->slug .
                                ' ' .
                                ($u->tema?->nama_tema ?? ''),
                        ),
                    ),
                ],
            )
            ->values();
    @endphp

    <div x-data="{
        modalBuatBaru: {{ request()->boolean('buat') || $errors->any() ? 'true' : 'false' }},
        temaTerpilihModal: @js($temaDefaultId),
        statusFilter: 'semua',
        kataCari: '',
        daftarItem: @js($daftarFilterJson),
        cocok(status, teks) {
            const cocokStatus = this.statusFilter === 'semua' || this.statusFilter === status;
            const kata = this.kataCari.trim().toLowerCase();
            const cocokKata = !kata || teks.includes(kata);
            return cocokStatus && cocokKata;
        },
        get adaHasilFilter() {
            return this.daftarItem.some(item => this.cocok(item.status, item.teks));
        },
        resetFilter() {
            this.statusFilter = 'semua';
            this.kataCari = '';
        }
    }" class="min-h-screen flex bg-ivory">
        @include('dashboard._client-sidebar', ['halamanAktif' => 'dashboard'])

        <div class="flex-1 min-w-0 flex flex-col">
            @include('dashboard._top-nav', ['halamanAktif' => 'dashboard'])

            <main id="halaman-undangan-saya"
                class="flex-1 w-full px-4 sm:px-6 lg:px-8 xl:px-10 pt-4 sm:pt-6 pb-28 md:py-8 space-y-5 md:space-y-6">
            {{-- Hero Banner Hijau Sage + Overlapping Floating White Summary Dock --}}
            <section>
                <div
                    class="relative overflow-hidden rounded-[1.75rem] bg-gradient-to-br from-[#354A40] via-sage to-[#445B50] text-ivory px-5 sm:px-7 pt-5 sm:pt-6 pb-12 sm:pb-14 shadow-md ring-1 ring-sage/30">
                    {{-- Dekorasi Geometris & Ambient Halus --}}
                    <div aria-hidden="true"
                        class="pointer-events-none absolute -right-12 -top-16 h-52 w-52 sm:h-64 sm:w-64 rounded-full bg-champagne/25 blur-2xl">
                    </div>
                    <div aria-hidden="true"
                        class="pointer-events-none absolute right-6 -top-10 h-36 w-36 rounded-full border border-white/10">
                    </div>
                    <div aria-hidden="true"
                        class="pointer-events-none absolute -left-10 -bottom-12 h-36 w-36 rounded-full bg-black/15 blur-2xl">
                    </div>

                    <div class="relative z-10 space-y-3.5">
                        {{-- Baris Atas: Pill Sapaan --}}
                        <div class="flex items-center">
                            <span
                                class="inline-flex min-w-0 max-w-full items-center gap-2 rounded-full bg-white/15 backdrop-blur-xs px-3 py-1 text-[11px] font-medium tracking-wide text-ivory ring-1 ring-white/20">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#F5E3B8] shrink-0"></span>
                                <span class="truncate">{{ $sapaanWaktu }}, {{ $namaTampilAkun }}</span>
                            </span>
                        </div>

                        {{-- Judul, Deskripsi & Tombol CTA Desktop --}}
                        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                            <div class="space-y-1.5 max-w-xl">
                                <h1
                                    class="font-sans text-[1.35rem] sm:text-[1.85rem] font-bold text-white leading-snug tracking-tight">
                                    {{ $jumlahSemua > 0 ? 'Kelola Undangan Pernikahan Anda' : 'Wujudkan Undangan Digital Impian' }}
                                </h1>
                                <p class="text-xs sm:text-sm text-white/85 leading-relaxed">
                                    {{ $jumlahSemua > 0
                                        ? 'Pantau kehadiran tamu, atur acara & galeri, atau perbarui tema kapan saja.'
                                        : 'Susun draft undangan gratis dalam hitungan menit, bagikan dengan mudah saat siap disebar.' }}
                                </p>
                            </div>

                            <a href="{{ route('dashboard.katalog') }}"
                                class="hidden sm:inline-flex items-center justify-center gap-2 rounded-2xl bg-champagne px-5 py-3 text-sm font-bold text-charcoal shadow-md hover:bg-[#d1b26d] active:scale-95 transition shrink-0">
                                <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h8" />
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                                    <path d="M19 16v6" />
                                    <path d="M16 19h6" />
                                </svg>
                                <span>Buat Baru</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Overlapping Floating White Summary Dock --}}
                <div class="relative z-20 mx-3 sm:mx-6 -mt-8 sm:-mt-9">
                    <div
                        class="rounded-2xl bg-white px-2 sm:px-4 py-3.5 sm:py-4 shadow-md ring-1 ring-champagne/30 grid grid-cols-3 divide-x divide-champagne/25 text-center">
                        <button type="button" @click="statusFilter = 'semua'"
                            class="group px-2 flex flex-col items-center justify-center active:scale-95 transition cursor-pointer">
                            <p
                                class="font-sans tabular-nums text-lg sm:text-2xl font-bold text-charcoal group-hover:text-sage transition-colors leading-none">
                                {{ $jumlahSemua }}</p>
                            <p class="mt-1.5 text-[11px] sm:text-xs font-medium text-charcoal/60">Undangan</p>
                        </button>

                        <button type="button" @click="statusFilter = 'aktif'"
                            class="group px-2 flex flex-col items-center justify-center active:scale-95 transition cursor-pointer">
                            <p
                                class="font-sans tabular-nums text-lg sm:text-2xl font-bold text-sage group-hover:scale-105 transition-transform leading-none">
                                {{ $jumlahAktif }}</p>
                            <p class="mt-1.5 text-[11px] sm:text-xs font-medium text-charcoal/60">Aktif</p>
                        </button>

                        <a href="{{ route('dashboard.tamu.index', ['subtab' => 'rsvp']) }}"
                            class="group px-2 flex flex-col items-center justify-center active:scale-95 transition">
                            <p
                                class="font-sans tabular-nums text-lg sm:text-2xl font-bold text-[#8A6D33] group-hover:scale-105 transition-transform leading-none">
                                {{ $totalTamuHadir }}</p>
                            <p class="mt-1.5 text-[11px] sm:text-xs font-medium text-charcoal/60">Tamu Hadir</p>
                        </a>
                    </div>
                </div>
            </section>

            @if ($daftarUndangan->isNotEmpty())
                {{-- Filter Status Pill & Pencarian Cepat --}}
                <section class="flex flex-col md:flex-row md:items-center justify-between gap-3">
                    <div
                        class="flex items-center gap-2 overflow-x-auto no-scrollbar scroll-px-4 sm:scroll-px-0 -mx-4 px-4 sm:mx-0 sm:px-0 py-0.5">
                        @foreach ([
                            'semua' => ['label' => 'Semua', 'jumlah' => $jumlahSemua],
                            'aktif' => ['label' => 'Aktif', 'jumlah' => $jumlahAktif],
                            'draft' => ['label' => 'Draft', 'jumlah' => $jumlahDraft],
                            'kedaluwarsa' => ['label' => 'Kedaluwarsa', 'jumlah' => $jumlahKedaluwarsa],
                        ] as $kodeStatus => $metaStatus)
                            <button type="button" @click="statusFilter = '{{ $kodeStatus }}'"
                                :class="statusFilter === '{{ $kodeStatus }}'
                                    ?
                                    'bg-sage text-white ring-1 ring-sage shadow-xs' :
                                    'bg-white text-charcoal/75 ring-1 ring-champagne/25 hover:ring-champagne/65 hover:text-charcoal'"
                                class="inline-flex items-center gap-1.5 rounded-full px-3.5 py-2 text-xs font-semibold whitespace-nowrap active:scale-95 transition cursor-pointer shrink-0">
                                <span>{{ $metaStatus['label'] }}</span>
                                <span
                                    :class="statusFilter === '{{ $kodeStatus }}' ? 'bg-white/20 text-white' :
                                        'bg-ivory text-charcoal/70'"
                                    class="rounded-full px-1.5 py-0.5 font-sans tabular-nums text-[10px] font-bold leading-none">
                                    {{ $metaStatus['jumlah'] }}
                                </span>
                            </button>
                        @endforeach
                    </div>

                    <div class="relative w-full md:w-72 shrink-0">
                        <svg class="w-4 h-4 text-charcoal/45 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" aria-hidden="true">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                        <input type="search" x-model="kataCari" placeholder="Cari pasangan, link, atau tema..."
                            aria-label="Cari undangan saya"
                            class="w-full rounded-2xl border-0 bg-white pl-10 pr-9 py-2.5 text-xs sm:text-sm text-charcoal placeholder:text-charcoal/45 shadow-xs ring-1 ring-champagne/30 focus:ring-2 focus:ring-sage focus:outline-none transition">
                        <button type="button" x-show="kataCari.length > 0" x-cloak @click="kataCari = ''"
                            aria-label="Hapus pencarian"
                            class="absolute right-2.5 top-1/2 -translate-y-1/2 rounded-full p-1 text-charcoal/45 hover:bg-ivory hover:text-charcoal cursor-pointer transition">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M18 6 6 18" />
                                <path d="m6 6 12 12" />
                            </svg>
                        </button>
                    </div>
                </section>

                {{-- Grid Kartu Undangan --}}
                <section class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 gap-4 sm:gap-5">
                    @foreach ($daftarUndangan as $undangan)
                        @php
                            $statusKode = $undangan->statusKode();
                            $kelengkapan = $undangan->ringkasanKelengkapan();
                            $acaraTerdekat = $undangan->acaraTerdekat();
                            $badgeHari = null;
                            if ($acaraTerdekat?->tanggal_acara) {
                                $selisih = now()
                                    ->startOfDay()
                                    ->diffInDays($acaraTerdekat->tanggal_acara->copy()->startOfDay(), false);
                                $badgeHari =
                                    $selisih > 0
                                        ? "H-{$selisih} Hari"
                                        : ($selisih === 0
                                            ? 'Hari Ini'
                                            : $acaraTerdekat->tanggal_acara->translatedFormat('d M Y'));
                            }
                            $jumlahHadir = $undangan->bukuTamu->where('status_kehadiran', 'hadir')->count();
                            $jumlahUcapan = $undangan->bukuTamu->count();
                            $urlPublik = Route::has('undangan.tampil')
                                ? route('undangan.tampil', $undangan->slug)
                                : url('/' . $undangan->slug);
                            $thumbnail = $undangan->urlFotoSampul() ?? $undangan->tema?->urlGambarPratinjau();
                            $transaksiTerakhir = $undangan->transaksi->first();
                            $sedangVerifikasi = $transaksiTerakhir?->status === 'menunggu_verifikasi';
                            $bolehHapusDraft = $undangan->bolehDihapusClient();
                            $kataKunciKartu = strtolower(
                                trim(
                                    $undangan->nama_panggilan_pria .
                                        ' ' .
                                        $undangan->nama_panggilan_wanita .
                                        ' ' .
                                        $undangan->slug .
                                        ' ' .
                                        ($undangan->tema?->nama_tema ?? ''),
                                ),
                            );
                        @endphp

                        <article x-show="cocok('{{ $statusKode }}', @js($kataKunciKartu))" x-transition
                            x-data="{ tersalin: false }"
                            class="group rounded-[1.5rem] bg-white overflow-hidden shadow-xs ring-1 ring-champagne/25 hover:ring-champagne/60 hover:shadow-md hover:-translate-y-0.5 transition flex flex-col justify-between">
                            <div>
                                {{-- Banner Visual Atas --}}
                                <div
                                    class="relative h-40 sm:h-44 overflow-hidden bg-gradient-to-br from-sage via-[#445B50] to-[#3b5047]">
                                    @if ($thumbnail)
                                        <img src="{{ $thumbnail }}"
                                            alt="{{ $undangan->nama_panggilan_pria }} & {{ $undangan->nama_panggilan_wanita }}"
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.03]">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-charcoal/90 via-charcoal/35 to-charcoal/20">
                                        </div>
                                    @else
                                        <div aria-hidden="true"
                                            class="pointer-events-none absolute -top-10 -right-10 h-36 w-36 rounded-full bg-champagne/20 blur-2xl">
                                        </div>
                                        <div aria-hidden="true"
                                            class="pointer-events-none absolute -left-8 -bottom-10 h-28 w-28 rounded-full bg-sage/25 blur-2xl">
                                        </div>
                                        <div
                                            class="pointer-events-none absolute right-5 top-1/2 -translate-y-1/2 font-logo text-5xl font-bold text-champagne/25 select-none">
                                            {{ $undangan->inisialMempelai() }}
                                        </div>
                                    @endif

                                    {{-- Baris Badge Atas --}}
                                    <div class="absolute top-3.5 inset-x-3.5 flex items-center justify-between gap-2">
                                        <div class="flex flex-wrap items-center gap-1.5">
                                            @if ($statusKode === 'kedaluwarsa')
                                                <span
                                                    class="rounded-full bg-red-600/95 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white shadow-xs">
                                                    Kedaluwarsa
                                                </span>
                                            @elseif ($statusKode === 'aktif')
                                                <span
                                                    class="inline-flex items-center gap-1 rounded-full bg-emerald-600/95 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white shadow-xs">
                                                    <span
                                                        class="h-1.5 w-1.5 rounded-full bg-emerald-200 animate-pulse"></span>
                                                    Aktif
                                                </span>
                                            @elseif ($sedangVerifikasi)
                                                <span
                                                    class="rounded-full bg-sky-600/95 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white shadow-xs">
                                                    Menunggu Verifikasi
                                                </span>
                                            @else
                                                <span
                                                    class="rounded-full bg-amber-500/95 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white shadow-xs">
                                                    Draft
                                                </span>
                                            @endif

                                            @if ($undangan->tema)
                                                <span
                                                    class="rounded-full bg-white/15 backdrop-blur-md px-2.5 py-0.5 text-[10px] font-semibold text-white ring-1 ring-white/20 truncate max-w-[165px]">
                                                    {{ $undangan->tema->nama_tema }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="flex items-center gap-1.5 shrink-0">
                                            @if ($badgeHari)
                                                <span
                                                    class="rounded-full bg-charcoal/75 backdrop-blur-md px-2.5 py-0.5 font-sans tabular-nums text-[10px] font-bold text-champagne ring-1 ring-champagne/35 shrink-0">
                                                    {{ $badgeHari }}
                                                </span>
                                            @endif

                                            @if ($bolehHapusDraft)
                                                <form action="{{ route('dashboard.undangan.hapus', $undangan) }}" method="POST"
                                                    data-swal-confirm="Yakin ingin menghapus draft undangan sesitemu.id/{{ $undangan->slug }}? Seluruh data, acara, dan foto draft ini akan dihapus permanen."
                                                    data-swal-title="Hapus Draft Undangan?"
                                                    data-swal-icon="warning"
                                                    data-swal-confirm-button="Ya, Hapus Draft"
                                                    data-swal-confirm-color="#DC2626"
                                                    data-swal-loading-title="Menghapus Draft..."
                                                    data-swal-loading-text="Sedang menghapus draft undangan dan berkas terkait...">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        title="Hapus Draft"
                                                        aria-label="Hapus Draft"
                                                        class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-charcoal/65 backdrop-blur-md text-white/95 ring-1 ring-white/25 hover:bg-red-600 hover:text-white hover:ring-red-400 active:scale-95 transition cursor-pointer shadow-xs">
                                                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" aria-hidden="true">
                                                            <path d="M3 6h18" />
                                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                                            <line x1="10" x2="10" y1="11" y2="17" />
                                                            <line x1="14" x2="14" y1="11" y2="17" />
                                                        </svg>
                                                        <span class="sr-only">Hapus Draft</span>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Nama Pasangan & Info Tanggal/Status Bawah Banner --}}
                                    <div class="absolute bottom-3.5 inset-x-4 text-white">
                                        <h2
                                            class="font-sans text-lg sm:text-xl font-bold tracking-tight leading-snug truncate drop-shadow-xs">
                                            {{ $undangan->nama_panggilan_pria }} &amp;
                                            {{ $undangan->nama_panggilan_wanita }}
                                        </h2>
                                        <p class="mt-0.5 text-[11px] sm:text-xs text-white/80 truncate">
                                            @if ($undangan->berlaku_sampai)
                                                Aktif s.d. <strong
                                                    class="text-champagne">{{ $undangan->berlaku_sampai->translatedFormat('d M Y') }}</strong>
                                            @elseif ($transaksiTerakhir)
                                                Invoice <span
                                                    class="font-mono font-semibold text-champagne">{{ $transaksiTerakhir->kode_invoice }}</span>
                                                &bull; {{ $transaksiTerakhir->labelStatus() }}
                                            @else
                                                Draft gratis &bull; Siap dilengkapi kapan saja
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                {{-- Isi Kartu: Link 1-Klik, Progres Kelengkapan, 3 Mini-Metrik --}}
                                <div class="p-4 sm:p-5 space-y-4">
                                    {{-- Link Publik + Tombol Salin 1-Klik --}}
                                    <div
                                        class="flex items-center justify-between gap-2 rounded-2xl bg-ivory px-3.5 py-2.5 ring-1 ring-champagne/25">
                                        <div class="flex items-center gap-2 min-w-0">
                                            <span
                                                class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-sage/10 text-sage shrink-0">
                                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
                                                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
                                                </svg>
                                            </span>
                                            <span
                                                class="text-xs font-mono font-semibold text-sage truncate">sesitemu.id/{{ $undangan->slug }}</span>
                                        </div>
                                        <button type="button"
                                            @click="navigator.clipboard?.writeText(@js($urlPublik)); tersalin = true; setTimeout(() => tersalin = false, 2000)"
                                            :class="tersalin ? 'bg-sage text-white ring-sage' :
                                                'bg-white text-charcoal ring-champagne/35 hover:text-sage'"
                                            class="inline-flex items-center gap-1 rounded-xl px-3 py-1.5 text-[11px] font-semibold ring-1 active:scale-95 transition shrink-0 cursor-pointer">
                                            <span x-text="tersalin ? 'Tersalin!' : 'Salin Link'"></span>
                                        </button>
                                    </div>

                                    {{-- Progres Kelengkapan 4 Tahap --}}
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between text-xs">
                                            <span class="font-medium text-charcoal/70">Kelengkapan Undangan</span>
                                            <span class="font-sans tabular-nums font-bold text-sage">
                                                {{ $kelengkapan['terpenuhi'] }}/{{ $kelengkapan['total'] }} &bull;
                                                {{ $kelengkapan['persen'] }}%
                                            </span>
                                        </div>
                                        <div
                                            class="h-2 w-full rounded-full bg-ivory overflow-hidden ring-1 ring-champagne/20">
                                            <div class="h-full rounded-full transition-all duration-300 {{ $kelengkapan['persen'] === 100 ? 'bg-sage' : 'bg-gradient-to-r from-sage to-champagne' }}"
                                                style="width: {{ $kelengkapan['persen'] }}%"></div>
                                        </div>
                                        <div class="flex flex-wrap gap-1.5 pt-0.5">
                                            @foreach ($kelengkapan['butir'] as $butir)
                                                @if ($butir['selesai'])
                                                    <span
                                                        class="inline-flex items-center gap-1 rounded-full bg-sage/10 px-2.5 py-0.5 text-[11px] font-semibold text-sage">
                                                        <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2.5"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            aria-hidden="true">
                                                            <polyline points="20 6 9 17 4 12" />
                                                        </svg>
                                                        <span>{{ $butir['label'] }}</span>
                                                    </span>
                                                @else
                                                    <a href="{{ route('dashboard.undangan.kelola', [$undangan, 'tab' => $butir['tab']]) }}"
                                                        class="inline-flex items-center gap-1 rounded-full bg-ivory px-2.5 py-0.5 text-[11px] font-semibold text-charcoal/65 ring-1 ring-champagne/30 hover:bg-sage/10 hover:text-sage transition">
                                                        <span>+ {{ $butir['label'] }}</span>
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- 3 Mini-Metrik --}}
                                    <div
                                        class="grid grid-cols-3 gap-2 rounded-2xl bg-ivory p-3 text-center ring-1 ring-champagne/20">
                                        <div>
                                            <p
                                                class="font-sans tabular-nums font-bold text-base sm:text-lg text-charcoal leading-none">
                                                {{ $undangan->daftarAcara->count() }}</p>
                                            <p class="mt-1 text-[11px] text-charcoal/60">Acara</p>
                                        </div>
                                        <div class="border-x border-champagne/20">
                                            <p
                                                class="font-sans tabular-nums font-bold text-base sm:text-lg text-sage leading-none">
                                                {{ $jumlahHadir }}</p>
                                            <p class="mt-1 text-[11px] text-charcoal/60">Tamu Hadir</p>
                                        </div>
                                        <div>
                                            <p
                                                class="font-sans tabular-nums font-bold text-base sm:text-lg text-[#8A6D33] leading-none">
                                                {{ $jumlahUcapan }}</p>
                                            <p class="mt-1 text-[11px] text-charcoal/60">Total Ucapan</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Bar Aksi Bawah Kartu --}}
                            <div
                                class="px-4 sm:px-5 pb-4 sm:pb-5 pt-1 grid grid-cols-2 sm:flex sm:flex-wrap items-center gap-2">
                                <a href="{{ route('dashboard.undangan.kelola', $undangan) }}"
                                    class="col-span-2 sm:col-span-1 sm:flex-1 inline-flex items-center justify-center gap-1.5 rounded-xl bg-sage px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-white whitespace-nowrap shadow-2xs hover:bg-[#3b5047] active:scale-[0.98] transition">
                                    <svg class="h-4 w-4 text-champagne shrink-0" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" aria-hidden="true">
                                        <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.375 2.625a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4Z" />
                                    </svg>
                                    <span>{{ $statusKode === 'aktif' ? 'Kelola Undangan' : 'Lanjut Kelola' }}</span>
                                </a>

                                <a href="{{ $urlPublik }}" target="_blank"
                                    class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-charcoal/15 bg-white px-3 py-2.5 text-xs sm:text-sm font-semibold text-charcoal whitespace-nowrap hover:bg-ivory active:scale-[0.98] transition">
                                    <svg class="h-4 w-4 text-sage shrink-0" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" aria-hidden="true">
                                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                    <span>{{ $statusKode === 'aktif' ? 'Lihat' : 'Pratinjau' }}</span>
                                </a>

                                @if ($statusKode === 'aktif')
                                    <a href="{{ route('dashboard.undangan.tamu', $undangan) }}"
                                        class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-sage/30 bg-sage/10 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-sage whitespace-nowrap hover:bg-sage/15 active:scale-[0.98] transition">
                                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" aria-hidden="true">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                            <circle cx="9" cy="7" r="4" />
                                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                        </svg>
                                        <span>Tamu &amp; RSVP</span>
                                    </a>
                                @elseif (!auth()->user()->adalahAdmin())
                                    <a href="{{ route('dashboard.undangan.kelola', [$undangan, 'tab' => 'aktivasi']) }}"
                                        class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-champagne px-3.5 py-2.5 text-xs sm:text-sm font-bold text-charcoal whitespace-nowrap hover:bg-[#d1b26d] active:scale-[0.98] transition">
                                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" aria-hidden="true">
                                            <rect width="20" height="14" x="2" y="5" rx="2" />
                                            <line x1="2" x2="22" y1="10" y2="10" />
                                        </svg>
                                        <span>{{ $statusKode === 'kedaluwarsa' ? 'Perpanjang' : 'Bayar & Aktifkan' }}</span>
                                    </a>
                                @endif
                            </div>
                        </article>
                    @endforeach

                    {{-- Empty State Hasil Filter / Pencarian --}}
                    <div x-show="!adaHasilFilter" x-cloak
                        class="col-span-full rounded-[1.5rem] bg-white p-8 text-center shadow-xs ring-1 ring-champagne/25 space-y-3">
                        <div
                            class="mx-auto inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-ivory text-sage ring-1 ring-champagne/30">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                        </div>
                        <p class="font-sans text-base sm:text-lg font-bold text-charcoal tracking-tight">
                            Tidak Ada Undangan yang Cocok
                        </p>
                        <p class="text-xs sm:text-sm text-charcoal/65">Coba ubah filter status atau kata kunci pencarian
                            Anda.</p>
                        <button type="button" @click="resetFilter()"
                            class="inline-flex items-center justify-center rounded-xl bg-sage px-5 py-2.5 text-xs sm:text-sm font-semibold text-white hover:bg-[#3b5047] active:scale-95 transition cursor-pointer">
                            Tampilkan Semua Undangan
                        </button>
                    </div>
                </section>
            @else
                {{-- Empty State Belum Ada Undangan --}}
                <section
                    class="rounded-[1.5rem] bg-white p-6 sm:p-12 shadow-xs ring-1 ring-champagne/25 text-center space-y-5">
                    <div
                        class="mx-auto inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-sage/10 text-sage ring-1 ring-sage/20">
                        <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect width="20" height="16" x="2" y="4" rx="2" />
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                        </svg>
                    </div>
                    <div class="max-w-md mx-auto space-y-2">
                        <h2 class="font-sans text-xl sm:text-2xl font-bold text-charcoal tracking-tight">
                            Belum Ada Undangan Tersimpan
                        </h2>
                        <p class="text-xs sm:text-sm text-charcoal/65 leading-relaxed">
                            Mulai buat draft undangan pernikahan digital pertama Anda secara gratis. Bebas ganti tema dan
                            pratinjau kapan saja sebelum aktivasi.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-2.5 pt-1">
                        <a href="{{ route('dashboard.katalog') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-sage px-6 py-3 text-xs sm:text-sm font-semibold text-white shadow-xs hover:bg-[#3b5047] active:scale-95 transition">
                            <svg class="h-4 w-4 text-champagne shrink-0" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h8" />
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                                <path d="M19 16v6" />
                                <path d="M16 19h6" />
                            </svg>
                            <span>Buat Draft Undangan Pertama</span>
                        </a>
                    </div>
                </section>
            @endif
            </main>
        </div>

        @include('dashboard._bottom-nav', ['halamanAktif' => 'dashboard', 'modalBuatOnPage' => true])

        @include('dashboard._modal-buat-draft')
    </div>
@endsection
