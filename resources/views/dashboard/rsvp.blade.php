@extends('layouts.aplikasi')

@section('judul', 'RSVP & Ucapan — ' . $undangan->nama_panggilan_pria . ' & ' . $undangan->nama_panggilan_wanita)

@section('konten')
    @php
        $urlPublik = Route::has('undangan.tampil')
            ? route('undangan.tampil', $undangan->slug)
            : url('/' . $undangan->slug);

        $totalResponRsvp = (int) ($rekapRsvp['hadir'] + $rekapRsvp['ragu'] + $rekapRsvp['tidak_hadir']);
        $persenHadirRsvp = $totalResponRsvp > 0 ? (int) round(($rekapRsvp['hadir'] / $totalResponRsvp) * 100) : 0;

        $daftarUcapanJson = $undangan->bukuTamu
            ->map(function ($ucapan, $idx) use ($undangan): array {
                $potongan = collect(preg_split('/\s+/', trim((string) $ucapan->nama_tamu)) ?: [])->filter();
                $inisial = $potongan->count() >= 2
                    ? mb_strtoupper(mb_substr($potongan->first(), 0, 1) . mb_substr($potongan->last(), 0, 1))
                    : mb_strtoupper(mb_substr((string) $ucapan->nama_tamu, 0, 2));

                return [
                    'id' => $ucapan->id,
                    'urutan_awal' => $idx,
                    'nama_tamu' => (string) $ucapan->nama_tamu,
                    'inisial' => $inisial ?: 'TM',
                    'status_kehadiran' => (string) $ucapan->status_kehadiran,
                    'status_label' => str_replace('_', ' ', ucfirst((string) $ucapan->status_kehadiran)),
                    'jumlah_tamu' => (int) $ucapan->jumlah_tamu,
                    'ucapan_doa' => (string) $ucapan->ucapan_doa,
                    'waktu_label' => $ucapan->created_at
                        ? $ucapan->created_at->locale('id')->translatedFormat('d M Y, H:i')
                        : '',
                    'url_hapus' => route('dashboard.ucapan.hapus', [$undangan, $ucapan]),
                ];
            })
            ->values()
            ->all();
    @endphp

    <div
        x-data="{
            daftarUcapan: @js($daftarUcapanJson),
            filterKehadiran: 'semua',
            kataCari: '',
            urutan: 'terbaru',
            perHalaman: 10,
            halaman: 1,
            setFilterKehadiran(status) {
                this.filterKehadiran = this.filterKehadiran === status && status !== 'semua' ? 'semua' : status;
                this.halaman = 1;
            },
            setUrutan(nilai) {
                this.urutan = nilai;
                this.halaman = 1;
            },
            daftarTersaring() {
                const kata = (this.kataCari || '').trim().toLowerCase();
                const hasil = this.daftarUcapan.filter((item) => {
                    if (this.filterKehadiran !== 'semua' && item.status_kehadiran !== this.filterKehadiran) {
                        return false;
                    }
                    if (kata) {
                        return item.nama_tamu.toLowerCase().includes(kata)
                            || item.ucapan_doa.toLowerCase().includes(kata)
                            || item.status_label.toLowerCase().includes(kata);
                    }
                    return true;
                });

                if (this.urutan === 'jumlah_terbanyak') {
                    return [...hasil].sort((a, b) => (b.jumlah_tamu - a.jumlah_tamu) || (a.urutan_awal - b.urutan_awal));
                }
                if (this.urutan === 'nama_az') {
                    return [...hasil].sort((a, b) => a.nama_tamu.localeCompare(b.nama_tamu, 'id'));
                }

                return hasil;
            },
            totalHalaman() {
                const total = this.daftarTersaring().length;
                if (this.perHalaman <= 0) return 1;
                return Math.max(1, Math.ceil(total / this.perHalaman));
            },
            halamanAman() {
                return Math.min(Math.max(1, this.halaman), this.totalHalaman());
            },
            daftarHalamanIni() {
                const semua = this.daftarTersaring();
                if (this.perHalaman <= 0) return semua;
                const mulai = (this.halamanAman() - 1) * this.perHalaman;
                return semua.slice(mulai, mulai + this.perHalaman);
            },
            ringkasanRentang() {
                const total = this.daftarTersaring().length;
                if (total === 0) return '0 ucapan';
                if (this.perHalaman <= 0) return `Menampilkan semua ${total} ucapan`;
                const mulai = (this.halamanAman() - 1) * this.perHalaman + 1;
                const akhir = Math.min(total, mulai + this.perHalaman - 1);
                return `Menampilkan ${mulai}–${akhir} dari ${total} ucapan`;
            },
        }"
        class="min-h-screen flex bg-ivory"
    >
        {{-- Sidebar Vertikal Ramping Desktop + Bottom Bar Mobile --}}
        @include('dashboard._workspace-sidebar', [
            'undangan' => $undangan,
            'menuAktif' => 'rsvp',
        ])

        <div class="flex-1 min-w-0 flex flex-col">
            @include('dashboard._workspace-header', [
                'undangan' => $undangan,
                'menuAktif' => 'rsvp',
                'judulHalaman' => 'RSVP & Ucapan',
            ])

            <main class="flex-1 min-w-0">
                <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-10 pt-4 sm:pt-5 pb-28 lg:py-5 space-y-5">
                    {{-- Header Editorial Terang + 4 Bento KPI Cards --}}
                    <section class="space-y-3.5">
                        <div class="relative overflow-hidden rounded-[1.75rem] bg-gradient-to-br from-white via-[#FCFBF7] to-[#F4EDE0]/75 px-5 sm:px-7 py-5 sm:py-6 ring-1 ring-champagne/30 shadow-[0_12px_32px_-20px_rgba(32,48,41,0.16)]">
                            <div aria-hidden="true" class="pointer-events-none absolute -right-12 -top-16 h-48 w-48 rounded-full bg-champagne/18 blur-3xl"></div>
                            <div aria-hidden="true" class="pointer-events-none absolute right-14 -bottom-16 h-36 w-36 rounded-full border border-champagne/25"></div>

                            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="space-y-1.5 min-w-0">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-champagne/20 px-3 py-0.5 text-[10.5px] font-semibold uppercase tracking-[0.12em] text-[#8A6D33] ring-1 ring-champagne/30">
                                        <span class="h-1.5 w-1.5 rounded-full bg-champagne"></span>
                                        <span>Buku Tamu &amp; Kehadiran</span>
                                    </span>
                                    <div class="flex flex-wrap items-center gap-2.5">
                                        <h1 class="font-sans text-xl sm:text-2xl font-bold text-charcoal tracking-tight">RSVP &amp; Ucapan</h1>
                                        <span class="inline-flex items-center rounded-full bg-white px-2.5 py-0.5 font-sans tabular-nums text-xs font-bold text-[#8A6D33] ring-1 ring-champagne/35 shadow-2xs">
                                            {{ $undangan->bukuTamu->count() }} Ucapan
                                        </span>
                                    </div>
                                    <p class="text-xs sm:text-sm text-charcoal/60 max-w-xl leading-relaxed">
                                        Pantau konfirmasi kehadiran tamu serta baca doa dan ucapan restu dalam tampilan kartu yang hangat.
                                    </p>
                                </div>

                                <div class="flex items-center gap-2 shrink-0">
                                    <a
                                        href="{{ route('dashboard.undangan.rsvp', $undangan) }}"
                                        title="Muat ulang daftar ucapan dan RSVP terbaru"
                                        class="inline-flex h-10 items-center justify-center gap-1.5 rounded-2xl bg-white px-3.5 text-xs sm:text-sm font-semibold text-charcoal ring-1 ring-champagne/35 hover:bg-ivory active:scale-[0.98] transition shadow-2xs"
                                    >
                                        <svg class="h-4 w-4 text-sage shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M21 12a9 9 0 1 1-2.64-6.36L21 8"/>
                                            <path d="M21 3v5h-5"/>
                                        </svg>
                                        <span>Segarkan</span>
                                    </a>
                                    <a
                                        href="{{ $urlPublik }}"
                                        target="_blank"
                                        title="Pratinjau Undangan"
                                        class="inline-flex h-10 items-center justify-center gap-1.5 rounded-2xl bg-sage px-4 text-xs sm:text-sm font-semibold text-white shadow-[0_10px_22px_-10px_rgba(75,99,88,0.65)] hover:bg-[#3A4F45] active:scale-[0.98] transition"
                                    >
                                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                        <span>Pratinjau</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- 4 Bento KPI Filter Cards --}}
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                            <button
                                type="button"
                                @click="setFilterKehadiran('hadir')"
                                :class="filterKehadiran === 'hadir' ? 'ring-2 ring-sage shadow-md -translate-y-0.5' : 'ring-1 ring-champagne/25 hover:ring-sage/50 shadow-2xs'"
                                class="group rounded-2xl bg-gradient-to-br from-white to-sage/[0.08] p-4 text-left transition-all cursor-pointer flex items-center gap-3.5"
                            >
                                <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-sage/12 text-sage ring-1 ring-sage/20 shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                        <polyline points="22 4 12 14.01 9 11.01"/>
                                    </svg>
                                </span>
                                <div class="min-w-0 flex-1">
                                    <p class="text-[11px] font-semibold uppercase tracking-wider text-sage/85 truncate">Konfirmasi Hadir</p>
                                    <div class="mt-0.5 flex items-baseline justify-between gap-2">
                                        <p class="font-sans tabular-nums text-2xl font-bold text-sage leading-none">{{ $rekapRsvp['hadir'] }}</p>
                                        <span class="text-[11px] font-bold text-sage tabular-nums">{{ $persenHadirRsvp }}%</span>
                                    </div>
                                    <div class="mt-1.5 h-1 w-full rounded-full bg-sage/15 overflow-hidden">
                                        <div class="h-full rounded-full bg-sage" style="width: {{ $persenHadirRsvp }}%"></div>
                                    </div>
                                </div>
                            </button>

                            <button
                                type="button"
                                @click="setFilterKehadiran('ragu')"
                                :class="filterKehadiran === 'ragu' ? 'ring-2 ring-amber-500 shadow-md -translate-y-0.5' : 'ring-1 ring-champagne/25 hover:ring-amber-300 shadow-2xs'"
                                class="group rounded-2xl bg-gradient-to-br from-white to-amber-50/75 p-4 text-left transition-all cursor-pointer flex items-center gap-3.5"
                            >
                                <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-100/80 text-amber-700 ring-1 ring-amber-200/80 shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"/>
                                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                                        <line x1="12" x2="12.01" y1="17" y2="17"/>
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-[11px] font-semibold uppercase tracking-wider text-amber-800/80 truncate">Masih Ragu</p>
                                    <div class="mt-0.5 flex items-baseline gap-1.5">
                                        <p class="font-sans tabular-nums text-2xl font-bold text-amber-700 leading-none">{{ $rekapRsvp['ragu'] }}</p>
                                        <span class="text-[11px] text-charcoal/45 truncate">belum pasti</span>
                                    </div>
                                </div>
                            </button>

                            <button
                                type="button"
                                @click="setFilterKehadiran('tidak_hadir')"
                                :class="filterKehadiran === 'tidak_hadir' ? 'ring-2 ring-rose-500 shadow-md -translate-y-0.5' : 'ring-1 ring-champagne/25 hover:ring-rose-300 shadow-2xs'"
                                class="group rounded-2xl bg-gradient-to-br from-white to-rose-50/75 p-4 text-left transition-all cursor-pointer flex items-center gap-3.5"
                            >
                                <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-rose-100/80 text-rose-600 ring-1 ring-rose-200/80 shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"/>
                                        <line x1="15" x2="9" y1="9" y2="15"/>
                                        <line x1="9" x2="15" y1="9" y2="15"/>
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-[11px] font-semibold uppercase tracking-wider text-rose-800/80 truncate">Tidak Hadir</p>
                                    <div class="mt-0.5 flex items-baseline gap-1.5">
                                        <p class="font-sans tabular-nums text-2xl font-bold text-red-700 leading-none">{{ $rekapRsvp['tidak_hadir'] }}</p>
                                        <span class="text-[11px] text-charcoal/45 truncate">kirim doa</span>
                                    </div>
                                </div>
                            </button>

                            <button
                                type="button"
                                @click="setFilterKehadiran('semua')"
                                :class="filterKehadiran === 'semua' ? 'ring-2 ring-champagne shadow-md -translate-y-0.5' : 'ring-1 ring-champagne/25 hover:ring-champagne/65 shadow-2xs'"
                                class="group rounded-2xl bg-gradient-to-br from-white to-champagne/[0.15] p-4 text-left transition-all cursor-pointer flex items-center gap-3.5"
                            >
                                <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-champagne/25 text-[#8A6D33] ring-1 ring-champagne/35 shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                        <circle cx="9" cy="7" r="4"/>
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-[11px] font-semibold uppercase tracking-wider text-charcoal/55 truncate">Estimasi Orang Hadir</p>
                                    <div class="mt-0.5 flex items-baseline gap-1.5">
                                        <p class="font-sans tabular-nums text-2xl font-bold text-charcoal leading-none">{{ $rekapRsvp['total_orang_hadir'] }}</p>
                                        <span class="text-[11px] text-charcoal/45 truncate">orang</span>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </section>

                    {{-- Toolbar Pencarian & Urutan --}}
                    <section
                        x-show="daftarUcapan.length > 0"
                        class="rounded-2xl bg-white px-3.5 py-3 ring-1 ring-champagne/25 shadow-2xs flex flex-col lg:flex-row lg:items-center justify-between gap-3"
                    >
                        <div class="relative flex-1 max-w-md">
                            <svg class="pointer-events-none h-4 w-4 text-charcoal/40 absolute left-3.5 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="11" cy="11" r="8"/>
                                <path d="m21 21-4.3-4.3"/>
                            </svg>
                            <input
                                type="search"
                                x-model="kataCari"
                                @input="halaman = 1"
                                placeholder="Cari nama tamu atau isi ucapan..."
                                class="w-full rounded-xl border border-champagne/30 bg-ivory/65 pl-10 pr-9 py-2 text-xs sm:text-sm text-charcoal focus:border-sage focus:bg-white focus:outline-none transition"
                            >
                            <button
                                type="button"
                                x-show="kataCari.length > 0"
                                x-cloak
                                @click="kataCari = ''; halaman = 1"
                                aria-label="Hapus pencarian"
                                class="absolute right-2.5 top-1/2 -translate-y-1/2 inline-flex h-6 w-6 items-center justify-center rounded-full text-charcoal/50 hover:bg-ivory hover:text-charcoal cursor-pointer"
                            >
                                &times;
                            </button>
                        </div>

                        <div class="flex flex-wrap items-center justify-between lg:justify-end gap-2">
                            <div class="inline-flex items-center gap-1 rounded-xl bg-ivory p-1 ring-1 ring-champagne/25">
                                <button
                                    type="button"
                                    @click="setUrutan('terbaru')"
                                    :class="urutan === 'terbaru' ? 'bg-white text-sage shadow-2xs font-semibold' : 'text-charcoal/65 hover:text-charcoal'"
                                    class="rounded-lg px-2.5 py-1.5 text-xs transition cursor-pointer"
                                >
                                    Terbaru
                                </button>
                                <button
                                    type="button"
                                    @click="setUrutan('jumlah_terbanyak')"
                                    :class="urutan === 'jumlah_terbanyak' ? 'bg-white text-sage shadow-2xs font-semibold' : 'text-charcoal/65 hover:text-charcoal'"
                                    class="rounded-lg px-2.5 py-1.5 text-xs transition cursor-pointer"
                                >
                                    Tamu Terbanyak
                                </button>
                                <button
                                    type="button"
                                    @click="setUrutan('nama_az')"
                                    :class="urutan === 'nama_az' ? 'bg-white text-sage shadow-2xs font-semibold' : 'text-charcoal/65 hover:text-charcoal'"
                                    class="rounded-lg px-2.5 py-1.5 text-xs transition cursor-pointer"
                                >
                                    A–Z
                                </button>
                            </div>

                            <label class="inline-flex items-center gap-2 text-xs font-medium text-charcoal/65">
                                <span>Tampilkan</span>
                                <select
                                    x-model.number="perHalaman"
                                    @change="halaman = 1"
                                    data-select2-variant="dt-length"
                                    data-select2-width="88px"
                                    aria-label="Jumlah ucapan per halaman"
                                    class="rounded-xl border border-champagne/35 bg-ivory/70 px-2.5 py-1.5 text-xs font-semibold text-charcoal focus:border-sage focus:bg-white focus:outline-none"
                                >
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="25">25</option>
                                    <option value="0">Semua</option>
                                </select>
                            </label>
                        </div>
                    </section>

                    {{-- DAFTAR UCAPAN & RSVP DALAM BENTUK CARD GRID --}}
                    <section id="daftar-kartu-rsvp" data-rsvp-cards class="space-y-4">
                        {{-- Empty State: Belum Ada Ucapan --}}
                        <div
                            x-show="daftarUcapan.length === 0"
                            class="rounded-[1.75rem] bg-white px-6 py-14 text-center ring-1 ring-champagne/25 shadow-2xs space-y-3"
                        >
                            <div class="mx-auto w-14 h-14 rounded-2xl bg-champagne/18 text-[#8A6D33] ring-1 ring-champagne/30 flex items-center justify-center">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                </svg>
                            </div>
                            <div class="max-w-sm mx-auto space-y-1">
                                <p class="font-sans text-base font-bold text-charcoal">Belum ada ucapan atau konfirmasi kehadiran</p>
                                <p class="text-xs sm:text-sm text-charcoal/60 leading-relaxed">
                                    Konfirmasi kehadiran dan doa restu yang dikirim tamu lewat undangan akan otomatis muncul di sini.
                                </p>
                            </div>
                        </div>

                        {{-- Empty State: Hasil Filter Kosong --}}
                        <div
                            x-show="daftarUcapan.length > 0 && daftarTersaring().length === 0"
                            x-cloak
                            class="rounded-[1.75rem] bg-white px-6 py-12 text-center ring-1 ring-champagne/25 shadow-2xs space-y-3"
                        >
                            <p class="text-sm font-bold text-charcoal">Tidak ada ucapan yang cocok dengan filter ini.</p>
                            <button
                                type="button"
                                @click="setFilterKehadiran('semua'); kataCari = ''"
                                class="inline-flex items-center rounded-xl bg-ivory px-4 py-2 text-xs font-semibold text-sage ring-1 ring-sage/25 hover:bg-sage/10 transition cursor-pointer"
                            >
                                Tampilkan Semua Ucapan
                            </button>
                        </div>

                        {{-- Grid Kartu Ucapan & RSVP --}}
                        <div
                            x-show="daftarHalamanIni().length > 0"
                            class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4"
                        >
                            <template x-for="ucapan in daftarHalamanIni()" :key="ucapan.id">
                                <article class="group relative overflow-hidden rounded-[1.5rem] bg-white p-5 ring-1 ring-champagne/25 shadow-[0_6px_22px_-14px_rgba(28,42,35,0.14)] hover:shadow-[0_16px_34px_-16px_rgba(28,42,35,0.2)] hover:-translate-y-0.5 transition-all duration-200 flex flex-col justify-between gap-4">
                                    {{-- Garis Aksen Kehadiran --}}
                                    <span
                                        :class="ucapan.status_kehadiran === 'hadir' ? 'bg-sage' : (ucapan.status_kehadiran === 'ragu' ? 'bg-amber-400' : 'bg-rose-400')"
                                        class="absolute inset-x-0 top-0 h-[3px]"
                                        aria-hidden="true"
                                    ></span>

                                    {{-- Kepala Kartu: Avatar + Nama + Badge Kehadiran --}}
                                    <div class="flex items-start justify-between gap-3 pt-0.5">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <span
                                                :class="ucapan.status_kehadiran === 'hadir'
                                                    ? 'bg-sage/12 text-sage ring-sage/20'
                                                    : (ucapan.status_kehadiran === 'ragu' ? 'bg-amber-50 text-amber-800 ring-amber-200/80' : 'bg-rose-50 text-rose-700 ring-rose-200/80')"
                                                class="inline-flex h-11 w-11 items-center justify-center rounded-2xl font-sans text-xs font-bold shrink-0 ring-1"
                                                x-text="ucapan.inisial"
                                            ></span>
                                            <div class="min-w-0">
                                                <h2 class="font-sans text-[15px] font-bold text-charcoal leading-snug truncate" x-text="ucapan.nama_tamu"></h2>
                                                <p x-show="ucapan.waktu_label" class="mt-0.5 text-[11px] text-charcoal/50" x-text="ucapan.waktu_label"></p>
                                            </div>
                                        </div>

                                        <span
                                            :class="ucapan.status_kehadiran === 'hadir'
                                                ? 'bg-sage/12 text-sage ring-sage/20'
                                                : (ucapan.status_kehadiran === 'ragu' ? 'bg-amber-50 text-amber-800 ring-amber-200/80' : 'bg-rose-50 text-rose-700 ring-rose-200/80')"
                                            class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-[11px] font-semibold ring-1 shrink-0"
                                        >
                                            <span
                                                :class="ucapan.status_kehadiran === 'hadir' ? 'bg-sage' : (ucapan.status_kehadiran === 'ragu' ? 'bg-amber-500' : 'bg-rose-500')"
                                                class="h-1.5 w-1.5 rounded-full"
                                            ></span>
                                            <span x-text="ucapan.status_label"></span>
                                        </span>
                                    </div>

                                    {{-- Isi Ucapan & Doa --}}
                                    <div class="relative flex-1 rounded-2xl bg-ivory/80 px-4 py-3.5 ring-1 ring-champagne/20">
                                        <svg class="h-4 w-4 text-champagne/60 mb-1.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                            <path d="M11 7.5v5.25c0 2.9-1.85 5.2-4.6 5.95l-.65-1.55c1.7-.55 2.75-1.8 2.95-3.4H5.75A1.75 1.75 0 0 1 4 12V7.5C4 6.67 4.67 6 5.5 6h3.75c.97 0 1.75.78 1.75 1.5Zm9 0v5.25c0 2.9-1.85 5.2-4.6 5.95l-.65-1.55c1.7-.55 2.75-1.8 2.95-3.4h-2.95A1.75 1.75 0 0 1 13 12V7.5c0-.83.67-1.5 1.5-1.5h3.75c.97 0 1.75.78 1.75 1.5Z"/>
                                        </svg>
                                        <p class="text-xs sm:text-[13px] text-charcoal/85 leading-relaxed whitespace-pre-line" x-text="ucapan.ucapan_doa"></p>
                                    </div>

                                    {{-- Footer: Jumlah Orang + Tombol Hapus --}}
                                    <div class="flex items-center justify-between gap-3 pt-0.5">
                                        <span class="inline-flex items-center gap-1.5 rounded-xl bg-ivory px-3 py-1.5 font-sans tabular-nums text-xs font-semibold text-charcoal/80 ring-1 ring-champagne/25">
                                            <svg class="h-3.5 w-3.5 text-sage shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                                <circle cx="9" cy="7" r="4"/>
                                            </svg>
                                            <span x-text="ucapan.jumlah_tamu + ' orang'"></span>
                                        </span>

                                        <form
                                            :action="ucapan.url_hapus"
                                            method="POST"
                                            data-swal-title="Hapus Ucapan Tamu?"
                                            :data-swal-confirm="'Yakin ingin menghapus ucapan dari ' + ucapan.nama_tamu + '?'"
                                            data-swal-icon="warning"
                                            data-swal-confirm-button="Ya, Hapus"
                                            data-swal-confirm-color="#DC2626"
                                            data-swal-loading-title="Menghapus Ucapan..."
                                            data-swal-loading-text="Menghapus komentar dari buku tamu..."
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                title="Hapus ucapan"
                                                class="inline-flex items-center gap-1 rounded-xl border border-rose-200/80 bg-rose-50/70 px-3 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-600 hover:text-white hover:border-rose-600 cursor-pointer transition"
                                            >
                                                <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M3 6h18"/>
                                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                                </svg>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </article>
                            </template>
                        </div>

                        {{-- Footer Paginasi Kartu --}}
                        <div
                            x-show="daftarTersaring().length > 0"
                            class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-1"
                        >
                            <p class="text-xs text-charcoal/55 tabular-nums" x-text="ringkasanRentang()"></p>

                            <div x-show="totalHalaman() > 1" x-cloak class="inline-flex items-center gap-1.5">
                                <button
                                    type="button"
                                    @click="halaman = Math.max(1, halamanAman() - 1)"
                                    :disabled="halamanAman() <= 1"
                                    class="rounded-xl border border-champagne/35 bg-white px-3 py-1.5 text-xs font-semibold text-charcoal/80 hover:bg-ivory disabled:opacity-40 disabled:cursor-not-allowed cursor-pointer transition"
                                >
                                    Sebelumnya
                                </button>
                                <span class="px-2.5 text-xs font-semibold text-charcoal tabular-nums" x-text="halamanAman() + ' / ' + totalHalaman()"></span>
                                <button
                                    type="button"
                                    @click="halaman = Math.min(totalHalaman(), halamanAman() + 1)"
                                    :disabled="halamanAman() >= totalHalaman()"
                                    class="rounded-xl border border-champagne/35 bg-white px-3 py-1.5 text-xs font-semibold text-charcoal/80 hover:bg-ivory disabled:opacity-40 disabled:cursor-not-allowed cursor-pointer transition"
                                >
                                    Berikutnya
                                </button>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </div>
@endsection
