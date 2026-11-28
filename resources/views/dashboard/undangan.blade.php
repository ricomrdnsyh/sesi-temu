@extends('layouts.aplikasi')

@section('judul', 'Undangan Saya | SesiTemu')

@section('konten')
    @php
        $pengguna = auth()->user();
        $jumlahSemua = $daftarUndangan->count();
        $jumlahAktif = $daftarUndangan->filter(fn($u) => $u->statusKode() === 'aktif')->count();
        $jumlahDraft = $daftarUndangan->filter(fn($u) => $u->statusKode() === 'draft')->count();
        $jumlahKedaluwarsa = $daftarUndangan->filter(fn($u) => $u->statusKode() === 'kedaluwarsa')->count();
        $totalDaftarTamu = $daftarUndangan->sum(fn($u) => $u->daftarTamu->count());
        $totalTamuDibuka = $daftarUndangan->sum(fn($u) => $u->daftarTamu->filter(fn($t) => $t->sudahDibuka())->count());
        $totalTamuHadir = $daftarUndangan->sum(fn($u) => $u->bukuTamu->where('status_kehadiran', 'hadir')->count());
        $totalUcapan = $daftarUndangan->sum(fn($u) => $u->bukuTamu->count());
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
        $bukaModalBuatAwal = request()->boolean('buat')
            || $errors->hasAny(['tema_id', 'slug', 'nama_panggilan_pria', 'nama_lengkap_pria', 'nama_panggilan_wanita', 'nama_lengkap_wanita']);
        $aktivasiUndanganAwal = (int) session('buka_aktivasi_undangan_id', request()->integer('aktivasi', 0));
        if ($aktivasiUndanganAwal > 0 && ! $daftarUndangan->contains('id', $aktivasiUndanganAwal)) {
            $aktivasiUndanganAwal = 0;
        }
    @endphp

    <div x-data="{
        modalBuatBaru: {{ $bukaModalBuatAwal ? 'true' : 'false' }},
        temaTerpilihModal: @js($temaDefaultId),
        aktivasiUndanganId: {{ $aktivasiUndanganAwal > 0 ? $aktivasiUndanganAwal : 'null' }},
        galeriLightbox: null,
        statusFilter: 'semua',
        kataCari: '',
        daftarItem: @js($daftarFilterJson),
        bukaModalAktivasiUndangan(id) {
            this.aktivasiUndanganId = id;
        },
        tutupModalAktivasi() {
            this.aktivasiUndanganId = null;
        },
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
                class="flex-1 w-full px-4 sm:px-6 lg:px-8 xl:px-10 pt-4 sm:pt-6 pb-28 md:py-8 md:pt-4 space-y-5 md:space-y-6">
            {{-- Hero Banner Forest-Sage & 4 Bento KPI Cards --}}
            <section class="space-y-4">
                <div
                    class="relative overflow-hidden rounded-[1.75rem] bg-gradient-to-br from-[#23362E] via-[#344C41] to-[#435D51] text-ivory px-5 sm:px-7 py-5 sm:py-6 shadow-[0_18px_40px_-24px_rgba(24,38,31,0.55)] ring-1 ring-sage/35">
                    {{-- Dekorasi Ambient & Geometris Halus --}}
                    <div aria-hidden="true"
                        class="pointer-events-none absolute -right-14 -top-20 h-60 w-60 rounded-full bg-champagne/25 blur-3xl">
                    </div>
                    <div aria-hidden="true"
                        class="pointer-events-none absolute right-10 -top-12 h-40 w-40 rounded-full border border-white/10">
                    </div>
                    <div aria-hidden="true"
                        class="pointer-events-none absolute right-24 -bottom-16 h-32 w-32 rounded-full border border-[#F5E3B8]/10">
                    </div>
                    <div aria-hidden="true"
                        class="pointer-events-none absolute -left-10 -bottom-14 h-40 w-40 rounded-full bg-black/20 blur-2xl">
                    </div>

                    <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-2.5 max-w-2xl min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span
                                    class="inline-flex min-w-0 max-w-full items-center gap-2 rounded-full bg-white/12 backdrop-blur-xs px-3 py-1 text-[11px] font-medium tracking-wide text-ivory ring-1 ring-white/15">
                                    <span class="h-1.5 w-1.5 rounded-full bg-[#F5E3B8] shrink-0"></span>
                                    <span class="truncate">{{ $sapaanWaktu }}, {{ $namaTampilAkun }}</span>
                                </span>
                                <span
                                    class="hidden sm:inline-flex items-center rounded-full bg-black/15 px-2.5 py-1 text-[11px] font-medium text-ivory/75 ring-1 ring-white/10">
                                    {{ now()->locale('id')->translatedFormat('l, d M Y') }}
                                </span>
                            </div>

                            <div class="space-y-1">
                                <h1
                                    class="font-sans text-[1.35rem] sm:text-[1.85rem] font-bold text-white leading-snug tracking-tight">
                                    {{ $jumlahSemua > 0 ? 'Kelola Undangan Pernikahan Anda' : 'Wujudkan Undangan Digital Impian' }}
                                </h1>
                                <p class="text-xs sm:text-sm text-white/80 leading-relaxed">
                                    {{ $jumlahSemua > 0
                                        ? 'Pantau kehadiran tamu, atur acara & galeri, atau perbarui tema kapan saja.'
                                        : 'Susun draft undangan gratis dalam hitungan menit, bagikan dengan mudah saat siap disebar.' }}
                                </p>
                            </div>
                        </div>

                        <a href="{{ route('dashboard.katalog') }}"
                            class="hidden sm:inline-flex items-center justify-center gap-2 rounded-2xl bg-[#E2C27D] px-5 py-3 text-sm font-bold text-[#1D2B24] shadow-[0_10px_24px_-10px_rgba(0,0,0,0.45)] ring-1 ring-white/30 hover:bg-[#ebd092] active:scale-95 transition shrink-0">
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

                {{-- 4 Bento KPI Cards (Seragam dengan Workspace Tamu & RSVP) --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-3">
                    <button type="button" @click="statusFilter = 'semua'"
                        :class="statusFilter === 'semua' ? 'ring-2 ring-sage shadow-sm -translate-y-0.5' : 'ring-1 ring-champagne/25 hover:ring-champagne/55 shadow-2xs'"
                        class="group rounded-2xl bg-white p-3.5 sm:p-4 text-left transition-all cursor-pointer flex items-center gap-3">
                        <span
                            class="inline-flex h-10 w-10 sm:h-11 sm:w-11 items-center justify-center rounded-xl bg-ivory text-charcoal/80 ring-1 ring-champagne/30 shrink-0 group-hover:scale-105 transition-transform">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="20" height="16" x="2" y="4" rx="2" />
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                            </svg>
                        </span>
                        <div class="min-w-0">
                            <p class="text-[10px] sm:text-[11px] font-semibold uppercase tracking-wider text-charcoal/55 truncate">
                                Undangan</p>
                            <div class="mt-0.5 flex items-baseline gap-1.5">
                                <p class="font-sans tabular-nums text-lg sm:text-2xl font-bold text-charcoal leading-none">
                                    {{ $jumlahSemua }}</p>
                                <span class="hidden sm:inline text-[11px] text-charcoal/45 truncate">terdaftar</span>
                            </div>
                        </div>
                    </button>

                    <button type="button" @click="statusFilter = 'aktif'"
                        :class="statusFilter === 'aktif' ? 'ring-2 ring-sage shadow-sm -translate-y-0.5' : 'ring-1 ring-champagne/25 hover:ring-sage/50 shadow-2xs'"
                        class="group rounded-2xl bg-gradient-to-br from-white to-sage/[0.06] p-3.5 sm:p-4 text-left transition-all cursor-pointer flex items-center gap-3">
                        <span
                            class="inline-flex h-10 w-10 sm:h-11 sm:w-11 items-center justify-center rounded-xl bg-sage/12 text-sage ring-1 ring-sage/20 shrink-0 group-hover:scale-105 transition-transform">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" />
                                <path d="m9 12 2 2 4-4" />
                            </svg>
                        </span>
                        <div class="min-w-0">
                            <p class="text-[10px] sm:text-[11px] font-semibold uppercase tracking-wider text-sage/85 truncate">
                                Aktif</p>
                            <div class="mt-0.5 flex items-baseline gap-1.5">
                                <p class="font-sans tabular-nums text-lg sm:text-2xl font-bold text-sage leading-none">
                                    {{ $jumlahAktif }}</p>
                                <span class="hidden sm:inline text-[11px] text-charcoal/45 truncate">
                                    {{ $jumlahDraft > 0 ? $jumlahDraft . ' draft' : 'siap disebar' }}
                                </span>
                            </div>
                        </div>
                    </button>

                    <a href="{{ route('dashboard.tamu.index') }}"
                        class="group rounded-2xl bg-gradient-to-br from-white to-emerald-50/70 p-3.5 sm:p-4 text-left ring-1 ring-champagne/25 hover:ring-emerald-300 hover:-translate-y-0.5 hover:shadow-sm shadow-2xs transition-all flex items-center gap-3">
                        <span
                            class="inline-flex h-10 w-10 sm:h-11 sm:w-11 items-center justify-center rounded-xl bg-emerald-100/80 text-emerald-700 ring-1 ring-emerald-200/80 shrink-0 group-hover:scale-105 transition-transform">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                        </span>
                        <div class="min-w-0">
                            <p class="text-[10px] sm:text-[11px] font-semibold uppercase tracking-wider text-emerald-800/80 truncate">
                                Daftar Tamu</p>
                            <div class="mt-0.5 flex items-baseline gap-1.5">
                                <p class="font-sans tabular-nums text-lg sm:text-2xl font-bold text-emerald-700 leading-none">
                                    {{ $totalDaftarTamu }}</p>
                                <span class="hidden sm:inline text-[11px] text-charcoal/45 truncate">
                                    {{ $totalTamuDibuka > 0 ? $totalTamuDibuka . ' dibuka' : 'tercatat' }}
                                </span>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('dashboard.rsvp.index') }}"
                        class="group rounded-2xl bg-gradient-to-br from-white to-[#FBF5E8]/85 p-3.5 sm:p-4 text-left ring-1 ring-champagne/25 hover:ring-champagne/65 hover:-translate-y-0.5 hover:shadow-sm shadow-2xs transition-all flex items-center gap-3">
                        <span
                            class="inline-flex h-10 w-10 sm:h-11 sm:w-11 items-center justify-center rounded-xl bg-champagne/20 text-[#8A6D33] ring-1 ring-champagne/30 shrink-0 group-hover:scale-105 transition-transform">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                                <path d="m9 10 2 2 4-4" />
                            </svg>
                        </span>
                        <div class="min-w-0">
                            <p class="text-[10px] sm:text-[11px] font-semibold uppercase tracking-wider text-[#8A6D33]/90 truncate">
                                Tamu Hadir</p>
                            <div class="mt-0.5 flex items-baseline gap-1.5">
                                <p class="font-sans tabular-nums text-lg sm:text-2xl font-bold text-[#8A6D33] leading-none">
                                    {{ $totalTamuHadir }}</p>
                                <span class="hidden sm:inline text-[11px] text-charcoal/45 truncate">
                                    {{ $totalUcapan > 0 ? $totalUcapan . ' ucapan' : 'konfirmasi' }}
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            </section>

            @if ($daftarUndangan->isNotEmpty())
                {{-- Filter Status Segmented & Pencarian Cepat --}}
                <section class="flex flex-col md:flex-row md:items-center justify-between gap-3">
                    <div
                        class="inline-flex items-center gap-1 rounded-xl bg-white p-1 ring-1 ring-champagne/25 shadow-2xs overflow-x-auto no-scrollbar max-w-full">
                        @foreach ([
                            'semua' => ['label' => 'Semua', 'jumlah' => $jumlahSemua],
                            'aktif' => ['label' => 'Aktif', 'jumlah' => $jumlahAktif],
                            'draft' => ['label' => 'Draft', 'jumlah' => $jumlahDraft],
                            'kedaluwarsa' => ['label' => 'Kedaluwarsa', 'jumlah' => $jumlahKedaluwarsa],
                        ] as $kodeStatus => $metaStatus)
                            <button type="button" @click="statusFilter = '{{ $kodeStatus }}'"
                                :class="statusFilter === '{{ $kodeStatus }}'
                                    ? 'bg-sage text-white shadow-xs'
                                    : 'text-charcoal/70 hover:bg-ivory hover:text-charcoal'"
                                class="inline-flex items-center gap-1.5 rounded-lg px-3.5 py-1.5 text-xs font-semibold whitespace-nowrap active:scale-95 transition cursor-pointer shrink-0">
                                <span>{{ $metaStatus['label'] }}</span>
                                <span
                                    :class="statusFilter === '{{ $kodeStatus }}' ? 'bg-white/20 text-white' : 'bg-ivory text-charcoal/65'"
                                    class="rounded-full px-1.5 py-0.5 font-sans tabular-nums text-[10px] font-bold leading-none">
                                    {{ $metaStatus['jumlah'] }}
                                </span>
                            </button>
                        @endforeach
                    </div>

                    <div class="relative w-full md:w-80 shrink-0">
                        <svg class="w-4 h-4 text-charcoal/40 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" aria-hidden="true">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                        <input type="search" x-model="kataCari" placeholder="Cari pasangan, link, tema..."
                            aria-label="Cari undangan saya"
                            class="w-full h-10 rounded-xl border border-champagne/30 bg-white pl-10 pr-9 text-xs sm:text-sm text-charcoal placeholder:text-charcoal/45 shadow-2xs focus:border-sage focus:outline-none transition">
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
                <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-5">
                    @foreach ($daftarUndangan as $undangan)
                        @php
                            $statusKode = $undangan->statusKode();
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
                            class="group rounded-[1.5rem] bg-white overflow-hidden shadow-2xs ring-1 ring-champagne/25 hover:ring-champagne/60 hover:shadow-[0_18px_40px_-24px_rgba(28,42,35,0.28)] hover:-translate-y-0.5 flex flex-col justify-between transition-all">
                            {{-- Banner Visual (Tinggi & Rasio Konsisten untuk Semua Foto) --}}
                            <div
                                class="relative h-48 overflow-hidden bg-gradient-to-br from-[#23362E] via-sage to-[#3b5047]">
                                @if ($thumbnail)
                                    <img src="{{ $thumbnail }}"
                                        alt="{{ $undangan->nama_panggilan_pria }} & {{ $undangan->nama_panggilan_wanita }}"
                                        class="absolute inset-0 w-full h-full object-cover object-[50%_20%] transition-transform duration-500 group-hover:scale-[1.03]">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-[#16221C]/92 via-[#16221C]/35 to-[#16221C]/15">
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
                                                class="rounded-full bg-black/30 backdrop-blur-md px-2.5 py-0.5 text-[10px] font-semibold text-white ring-1 ring-white/20 truncate max-w-[175px]">
                                                {{ $undangan->tema->nama_tema }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="flex items-center gap-1.5 shrink-0">
                                        @if ($badgeHari)
                                            <span
                                                class="rounded-full bg-black/45 backdrop-blur-md px-2.5 py-0.5 font-sans tabular-nums text-[10px] font-bold text-[#F5E3B8] ring-1 ring-champagne/40 shrink-0">
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

                                {{-- Nama Pasangan & Info Masa Aktif --}}
                                <div class="absolute bottom-3.5 inset-x-4 text-white">
                                    <h2
                                        class="font-sans text-lg sm:text-xl font-bold tracking-tight leading-snug truncate drop-shadow-xs">
                                        {{ $undangan->nama_panggilan_pria }} &amp;
                                        {{ $undangan->nama_panggilan_wanita }}
                                    </h2>
                                    <p class="mt-0.5 text-[11px] sm:text-xs text-white/80 truncate">
                                        @if ($undangan->berlaku_sampai)
                                            Aktif s.d. <strong
                                                class="text-[#F5E3B8]">{{ $undangan->berlaku_sampai->translatedFormat('d M Y') }}</strong>
                                        @elseif ($transaksiTerakhir)
                                            Invoice <span
                                                class="font-mono font-semibold text-[#F5E3B8]">{{ $transaksiTerakhir->kode_invoice }}</span>
                                            &bull; {{ $transaksiTerakhir->labelStatus() }}
                                        @else
                                            Draft gratis &bull; Siap dilengkapi kapan saja
                                        @endif
                                    </p>
                                </div>
                            </div>

                            {{-- Konten Detail + Aksi --}}
                            <div class="p-4 flex-1 flex flex-col justify-between gap-3">
                                <div class="space-y-3">
                                    {{-- Link Publik Ringkas + Tombol Salin 1-Klik --}}
                                    <div
                                        class="flex items-center justify-between gap-2 rounded-xl bg-ivory/90 px-2.5 py-1.5 ring-1 ring-champagne/25">
                                        <div class="flex items-center gap-1.5 min-w-0">
                                            <span
                                                class="inline-flex h-6 w-6 items-center justify-center rounded-lg bg-sage/10 text-sage shrink-0">
                                                <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
                                                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
                                                </svg>
                                            </span>
                                            <span
                                                class="text-[11px] font-mono font-semibold text-sage truncate">sesitemu.id/{{ $undangan->slug }}</span>
                                        </div>
                                        <button type="button"
                                            @click="navigator.clipboard?.writeText(@js($urlPublik)); tersalin = true; setTimeout(() => tersalin = false, 2000)"
                                            :class="tersalin ? 'bg-sage text-white ring-sage' : 'bg-white text-charcoal ring-champagne/35 hover:ring-sage/50 hover:text-sage'"
                                            class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1 text-[10.5px] font-semibold ring-1 active:scale-95 transition shrink-0 cursor-pointer">
                                            <svg x-show="!tersalin" class="h-3 w-3 shrink-0" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                aria-hidden="true">
                                                <rect width="14" height="14" x="8" y="8" rx="2" ry="2" />
                                                <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2" />
                                            </svg>
                                            <svg x-show="tersalin" x-cloak class="h-3 w-3 shrink-0" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"
                                                aria-hidden="true">
                                                <polyline points="20 6 9 17 4 12" />
                                            </svg>
                                            <span x-text="tersalin ? 'Tersalin!' : 'Salin Link'"></span>
                                        </button>
                                    </div>

                                    {{-- 3 Mini-Metrik --}}
                                    <div
                                        class="grid grid-cols-3 gap-2 rounded-2xl bg-ivory/85 p-3 text-center ring-1 ring-champagne/20">
                                        <div class="px-1">
                                            <p
                                                class="font-sans tabular-nums font-bold text-base sm:text-lg text-charcoal leading-none">
                                                {{ $undangan->daftarAcara->count() }}</p>
                                            <p class="mt-1 text-[11px] text-charcoal/60">Acara</p>
                                        </div>
                                        <div class="px-1 border-x border-champagne/20">
                                            <p
                                                class="font-sans tabular-nums font-bold text-base sm:text-lg text-sage leading-none">
                                                {{ $jumlahHadir }}</p>
                                            <p class="mt-1 text-[11px] text-charcoal/60">Tamu Hadir</p>
                                        </div>
                                        <div class="px-1">
                                            <p
                                                class="font-sans tabular-nums font-bold text-base sm:text-lg text-[#8A6D33] leading-none">
                                                {{ $jumlahUcapan }}</p>
                                            <p class="mt-1 text-[11px] text-charcoal/60">Total Ucapan</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Bar Aksi Bawah Kartu --}}
                                <div
                                    class="pt-3 border-t border-champagne/15 grid grid-cols-2 sm:flex sm:flex-wrap items-center gap-2">
                                    <a href="{{ route('dashboard.undangan.kelola', $undangan) }}"
                                        class="col-span-2 sm:col-span-1 sm:flex-1 inline-flex items-center justify-center gap-1.5 rounded-xl bg-sage px-4 py-2.5 text-xs sm:text-sm font-semibold text-white whitespace-nowrap shadow-[0_8px_18px_-10px_rgba(75,99,88,0.75)] hover:bg-[#3b5047] active:scale-[0.98] transition">
                                        <svg class="h-4 w-4 text-[#F5E3B8] shrink-0" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" aria-hidden="true">
                                            <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path d="M18.375 2.625a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4Z" />
                                        </svg>
                                        <span>{{ $statusKode === 'aktif' ? 'Kelola Undangan' : 'Lanjut Kelola' }}</span>
                                    </a>

                                    <a href="{{ $urlPublik }}" target="_blank"
                                        class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-champagne/35 bg-white px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-charcoal whitespace-nowrap hover:bg-ivory hover:border-sage/40 active:scale-[0.98] transition">
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
                                            class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-sage/30 bg-sage/10 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-sage whitespace-nowrap hover:bg-sage hover:text-white active:scale-[0.98] transition">
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
                                        <button type="button"
                                            @click="bukaModalAktivasiUndangan({{ $undangan->id }})"
                                            data-buka-modal-aktivasi="{{ $undangan->id }}"
                                            class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-[#E2C27D] px-3.5 py-2.5 text-xs sm:text-sm font-bold text-[#1D2B24] whitespace-nowrap hover:bg-[#d5b36d] active:scale-[0.98] transition cursor-pointer">
                                            <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" aria-hidden="true">
                                                <rect width="20" height="14" x="2" y="5" rx="2" />
                                                <line x1="2" x2="22" y1="10" y2="10" />
                                            </svg>
                                            <span>{{ $statusKode === 'kedaluwarsa' ? 'Perpanjang' : ($sedangVerifikasi ? 'Status Bayar' : 'Bayar & Aktifkan') }}</span>
                                        </button>
                                    @endif
                                </div>
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

        @if (!auth()->user()->adalahAdmin())
            @foreach ($daftarUndangan as $undanganModal)
                @if (! $undanganModal->sudahAktifPublik())
                    @include('dashboard._kelola-aktivasi', [
                        'undangan' => $undanganModal,
                        'ekspresiTerbuka' => 'aktivasiUndanganId === ' . $undanganModal->id,
                        'idPrefix' => 'dash-akt-' . $undanganModal->id . '-',
                        'asalHalaman' => 'dashboard',
                        'urlPublik' => Route::has('undangan.tampil')
                            ? route('undangan.tampil', $undanganModal->slug)
                            : url('/' . $undanganModal->slug),
                        'pesanWaAktivasi' => "Halo Admin SesiTemu, saya ingin mengaktifkan undangan sesitemu.id/{$undanganModal->slug}.",
                    ])
                @endif
            @endforeach

            {{-- Lightbox Pratinjau Bukti Pembayaran --}}
            <div
                x-show="galeriLightbox"
                x-cloak
                @keydown.escape.window="if (galeriLightbox) galeriLightbox = null"
                @click="galeriLightbox = null"
                class="fixed inset-0 z-[60] bg-black/80 backdrop-blur-xs p-4 flex items-center justify-center"
            >
                <div @click.stop class="relative max-w-2xl w-full rounded-xl overflow-hidden bg-white shadow-2xl">
                    <button
                        type="button"
                        @click="galeriLightbox = null"
                        aria-label="Tutup pratinjau"
                        class="absolute top-3 right-3 z-10 w-9 h-9 rounded-lg bg-black/60 text-white hover:bg-black/80 flex items-center justify-center cursor-pointer transition"
                    >
                        &times;
                    </button>
                    <img :src="galeriLightbox?.url" :alt="galeriLightbox?.caption" class="w-full max-h-[75vh] object-contain bg-charcoal">
                    <div class="px-5 py-3.5 bg-white border-t border-champagne/20 flex items-center justify-between gap-3">
                        <p class="text-sm font-semibold text-charcoal truncate" x-text="galeriLightbox?.caption"></p>
                        <button type="button" @click="galeriLightbox = null" class="text-xs font-semibold text-sage hover:underline cursor-pointer shrink-0">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
