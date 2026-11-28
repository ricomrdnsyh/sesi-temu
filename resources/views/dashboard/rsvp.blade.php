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
            dropdownAturTerbuka: false,
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
        @keydown.escape.window="dropdownAturTerbuka = false"
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
                <h1 class="sr-only">RSVP &amp; Ucapan</h1>
                <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-10 pt-4 sm:pt-5 pb-28 lg:py-5 space-y-4">
                    {{-- 4 Bento KPI Filter Cards --}}
                    <section>
                        {{-- 4 Bento KPI Filter Cards --}}
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-3">
                            <button
                                type="button"
                                @click="setFilterKehadiran('hadir')"
                                :class="filterKehadiran === 'hadir' ? 'ring-2 ring-sage shadow-md -translate-y-0.5' : 'ring-1 ring-champagne/25 hover:ring-sage/50 shadow-2xs'"
                                class="group rounded-2xl bg-gradient-to-br from-white to-sage/[0.08] p-3 sm:p-4 text-left transition-all cursor-pointer flex items-center gap-2.5 sm:gap-3.5"
                            >
                                <span class="inline-flex h-9 w-9 sm:h-11 sm:w-11 items-center justify-center rounded-xl sm:rounded-2xl bg-sage/12 text-sage ring-1 ring-sage/20 shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                        <polyline points="22 4 12 14.01 9 11.01"/>
                                    </svg>
                                </span>
                                <div class="min-w-0 flex-1">
                                    <p class="text-[10px] sm:text-[11px] font-semibold uppercase tracking-wider text-sage/85 truncate">Konfirmasi Hadir</p>
                                    <div class="mt-0.5 flex items-baseline justify-between gap-1.5">
                                        <p class="font-sans tabular-nums text-xl sm:text-2xl font-bold text-sage leading-none">{{ $rekapRsvp['hadir'] }}</p>
                                        <span class="text-[10.5px] sm:text-[11px] font-bold text-sage tabular-nums">{{ $persenHadirRsvp }}%</span>
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
                                class="group rounded-2xl bg-gradient-to-br from-white to-amber-50/75 p-3 sm:p-4 text-left transition-all cursor-pointer flex items-center gap-2.5 sm:gap-3.5"
                            >
                                <span class="inline-flex h-9 w-9 sm:h-11 sm:w-11 items-center justify-center rounded-xl sm:rounded-2xl bg-amber-100/80 text-amber-700 ring-1 ring-amber-200/80 shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"/>
                                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                                        <line x1="12" x2="12.01" y1="17" y2="17"/>
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-[10px] sm:text-[11px] font-semibold uppercase tracking-wider text-amber-800/80 truncate">Masih Ragu</p>
                                    <div class="mt-0.5 flex items-baseline gap-1.5">
                                        <p class="font-sans tabular-nums text-xl sm:text-2xl font-bold text-amber-700 leading-none">{{ $rekapRsvp['ragu'] }}</p>
                                        <span class="hidden sm:inline text-[11px] text-charcoal/45 truncate">belum pasti</span>
                                    </div>
                                </div>
                            </button>

                            <button
                                type="button"
                                @click="setFilterKehadiran('tidak_hadir')"
                                :class="filterKehadiran === 'tidak_hadir' ? 'ring-2 ring-rose-500 shadow-md -translate-y-0.5' : 'ring-1 ring-champagne/25 hover:ring-rose-300 shadow-2xs'"
                                class="group rounded-2xl bg-gradient-to-br from-white to-rose-50/75 p-3 sm:p-4 text-left transition-all cursor-pointer flex items-center gap-2.5 sm:gap-3.5"
                            >
                                <span class="inline-flex h-9 w-9 sm:h-11 sm:w-11 items-center justify-center rounded-xl sm:rounded-2xl bg-rose-100/80 text-rose-600 ring-1 ring-rose-200/80 shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"/>
                                        <line x1="15" x2="9" y1="9" y2="15"/>
                                        <line x1="9" x2="15" y1="9" y2="15"/>
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-[10px] sm:text-[11px] font-semibold uppercase tracking-wider text-rose-800/80 truncate">Tidak Hadir</p>
                                    <div class="mt-0.5 flex items-baseline gap-1.5">
                                        <p class="font-sans tabular-nums text-xl sm:text-2xl font-bold text-red-700 leading-none">{{ $rekapRsvp['tidak_hadir'] }}</p>
                                        <span class="hidden sm:inline text-[11px] text-charcoal/45 truncate">kirim doa</span>
                                    </div>
                                </div>
                            </button>

                            <button
                                type="button"
                                @click="setFilterKehadiran('semua')"
                                :class="filterKehadiran === 'semua' ? 'ring-2 ring-champagne shadow-md -translate-y-0.5' : 'ring-1 ring-champagne/25 hover:ring-champagne/65 shadow-2xs'"
                                class="group rounded-2xl bg-gradient-to-br from-white to-champagne/[0.15] p-3 sm:p-4 text-left transition-all cursor-pointer flex items-center gap-2.5 sm:gap-3.5"
                            >
                                <span class="inline-flex h-9 w-9 sm:h-11 sm:w-11 items-center justify-center rounded-xl sm:rounded-2xl bg-champagne/25 text-[#8A6D33] ring-1 ring-champagne/35 shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                        <circle cx="9" cy="7" r="4"/>
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-[10px] sm:text-[11px] font-semibold uppercase tracking-wider text-charcoal/55 truncate">Estimasi Hadir</p>
                                    <div class="mt-0.5 flex items-baseline gap-1.5">
                                        <p class="font-sans tabular-nums text-xl sm:text-2xl font-bold text-charcoal leading-none">{{ $rekapRsvp['total_orang_hadir'] }}</p>
                                        <span class="hidden sm:inline text-[11px] text-charcoal/45 truncate">orang</span>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </section>

                    {{-- Baris Pencarian Lebar + Tombol Atur --}}
                    <section x-show="daftarUcapan.length > 0" class="space-y-2.5">
                        <div class="flex items-center gap-2">
                            <div class="relative flex-1">
                                <svg class="pointer-events-none h-4 w-4 text-charcoal/40 absolute left-4 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="11" cy="11" r="8"/>
                                    <path d="m21 21-4.3-4.3"/>
                                </svg>
                                <input
                                    type="search"
                                    x-model="kataCari"
                                    @input="halaman = 1"
                                    placeholder="Cari nama tamu atau isi ucapan..."
                                    class="w-full h-10 sm:h-11 rounded-xl border border-champagne/30 bg-white pl-10 sm:pl-11 pr-9 text-xs sm:text-sm text-charcoal shadow-2xs focus:border-sage focus:outline-none transition"
                                >
                                <button
                                    type="button"
                                    x-show="kataCari.length > 0"
                                    x-cloak
                                    @click="kataCari = ''; halaman = 1"
                                    aria-label="Hapus pencarian"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 inline-flex h-6 w-6 items-center justify-center rounded-full text-charcoal/50 hover:bg-ivory hover:text-charcoal cursor-pointer"
                                >
                                    &times;
                                </button>
                            </div>

                            <div class="relative shrink-0" @click.away="dropdownAturTerbuka = false">
                                <button
                                    type="button"
                                    @click="dropdownAturTerbuka = !dropdownAturTerbuka"
                                    :class="(urutan !== 'terbaru' || perHalaman !== 10) ? 'ring-sage/50 text-sage' : 'ring-champagne/30 text-charcoal/80'"
                                    class="inline-flex h-10 sm:h-11 items-center justify-center gap-1.5 rounded-xl bg-white px-3.5 sm:px-4 text-xs sm:text-sm font-semibold ring-1 hover:bg-ivory transition cursor-pointer shadow-2xs"
                                >
                                    <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <line x1="21" x2="14" y1="4" y2="4"/>
                                        <line x1="10" x2="3" y1="4" y2="4"/>
                                        <line x1="21" x2="12" y1="12" y2="12"/>
                                        <line x1="8" x2="3" y1="12" y2="12"/>
                                        <line x1="21" x2="16" y1="20" y2="20"/>
                                        <line x1="12" x2="3" y1="20" y2="20"/>
                                        <line x1="14" x2="14" y1="2" y2="6"/>
                                        <line x1="8" x2="8" y1="10" y2="14"/>
                                        <line x1="16" x2="16" y1="18" y2="22"/>
                                    </svg>
                                    <span>Atur</span>
                                    <span x-show="urutan !== 'terbaru' || perHalaman !== 10" x-cloak class="h-1.5 w-1.5 rounded-full bg-sage"></span>
                                </button>

                                <div
                                    x-show="dropdownAturTerbuka"
                                    x-cloak
                                    x-transition.opacity.duration.120ms
                                    class="absolute right-0 top-full mt-2 z-30 w-64 rounded-2xl bg-white p-3.5 shadow-xl ring-1 ring-champagne/35 space-y-3.5 text-left"
                                >
                                    <div class="space-y-1.5">
                                        <p class="text-[11px] font-semibold uppercase tracking-wider text-charcoal/50">Urutkan</p>
                                        <div class="grid grid-cols-1 gap-1">
                                            <button
                                                type="button"
                                                @click="setUrutan('terbaru'); dropdownAturTerbuka = false"
                                                :class="urutan === 'terbaru' ? 'bg-sage/10 text-sage font-semibold' : 'text-charcoal/80 hover:bg-ivory'"
                                                class="flex items-center justify-between rounded-xl px-3 py-2 text-xs transition cursor-pointer"
                                            >
                                                <span>Terbaru</span>
                                                <span x-show="urutan === 'terbaru'" class="text-sage font-bold">&check;</span>
                                            </button>
                                            <button
                                                type="button"
                                                @click="setUrutan('jumlah_terbanyak'); dropdownAturTerbuka = false"
                                                :class="urutan === 'jumlah_terbanyak' ? 'bg-sage/10 text-sage font-semibold' : 'text-charcoal/80 hover:bg-ivory'"
                                                class="flex items-center justify-between rounded-xl px-3 py-2 text-xs transition cursor-pointer"
                                            >
                                                <span>Tamu Terbanyak</span>
                                                <span x-show="urutan === 'jumlah_terbanyak'" class="text-sage font-bold">&check;</span>
                                            </button>
                                            <button
                                                type="button"
                                                @click="setUrutan('nama_az'); dropdownAturTerbuka = false"
                                                :class="urutan === 'nama_az' ? 'bg-sage/10 text-sage font-semibold' : 'text-charcoal/80 hover:bg-ivory'"
                                                class="flex items-center justify-between rounded-xl px-3 py-2 text-xs transition cursor-pointer"
                                            >
                                                <span>Nama A–Z</span>
                                                <span x-show="urutan === 'nama_az'" class="text-sage font-bold">&check;</span>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="pt-2.5 border-t border-champagne/20 space-y-1.5">
                                        <p class="text-[11px] font-semibold uppercase tracking-wider text-charcoal/50">Tampilkan per halaman</p>
                                        <div class="flex flex-wrap gap-1.5">
                                            @foreach ([10 => '10', 15 => '15', 20 => '20', 25 => '25', 0 => 'Semua'] as $valLimit => $lblLimit)
                                                <button
                                                    type="button"
                                                    @click="perHalaman = {{ $valLimit }}; halaman = 1; dropdownAturTerbuka = false"
                                                    :class="perHalaman === {{ $valLimit }} ? 'bg-sage text-white font-semibold' : 'bg-ivory text-charcoal/75 hover:bg-champagne/15'"
                                                    class="rounded-lg px-2.5 py-1 text-xs tabular-nums transition cursor-pointer"
                                                >
                                                    {{ $lblLimit }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div x-show="filterKehadiran !== 'semua'" x-cloak>
                            <button
                                type="button"
                                @click="setFilterKehadiran('semua')"
                                class="inline-flex items-center gap-1.5 rounded-full bg-sage/10 px-3 py-1 text-xs font-semibold text-sage ring-1 ring-sage/20 hover:bg-sage/15 transition cursor-pointer"
                            >
                                <span x-text="'Filter: ' + (filterKehadiran === 'hadir' ? 'Hadir' : (filterKehadiran === 'ragu' ? 'Masih Ragu' : 'Tidak Hadir'))"></span>
                                <span aria-hidden="true">&times;</span>
                            </button>
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

                        {{-- Daftar Baris Ucapan & RSVP Ringkas & Bersih --}}
                        <div
                            x-show="daftarHalamanIni().length > 0"
                            class="space-y-3"
                        >
                            <template x-for="ucapan in daftarHalamanIni()" :key="ucapan.id">
                                <article class="group relative overflow-hidden rounded-2xl bg-white pl-5 pr-4 sm:pl-6 sm:pr-5 py-4 ring-1 ring-champagne/25 shadow-[0_6px_22px_-16px_rgba(28,42,35,0.14)] hover:ring-champagne/60 hover:shadow-[0_14px_30px_-18px_rgba(28,42,35,0.2)] transition-all duration-200">
                                    {{-- Garis Aksen Status Kehadiran di Sisi Kiri --}}
                                    <span
                                        :class="ucapan.status_kehadiran === 'hadir' ? 'bg-sage' : (ucapan.status_kehadiran === 'ragu' ? 'bg-amber-400' : 'bg-rose-500')"
                                        class="absolute inset-y-0 left-0 w-1"
                                        aria-hidden="true"
                                    ></span>

                                    <div class="flex items-start gap-3 sm:gap-3.5">
                                        {{-- Avatar Inisial --}}
                                        <span
                                            :class="ucapan.status_kehadiran === 'hadir'
                                                ? 'bg-sage/12 text-sage ring-sage/25'
                                                : (ucapan.status_kehadiran === 'ragu' ? 'bg-amber-50 text-amber-800 ring-amber-200/80' : 'bg-rose-50 text-rose-700 ring-rose-200/80')"
                                            class="inline-flex h-10 w-10 sm:h-11 sm:w-11 items-center justify-center rounded-xl font-sans text-xs font-bold shrink-0 ring-1"
                                            x-text="ucapan.inisial"
                                        ></span>

                                        {{-- Konten Utama: Baris Identitas + Aksi & Kotak Ucapan --}}
                                        <div class="min-w-0 flex-1 space-y-2.5">
                                            <div class="flex items-start sm:items-center justify-between gap-2.5">
                                                <div class="min-w-0 space-y-1">
                                                    <div class="flex flex-wrap items-center gap-x-2 gap-y-1">
                                                        <h2 class="font-sans text-sm sm:text-[15px] font-bold text-charcoal leading-snug" x-text="ucapan.nama_tamu"></h2>
                                                        <span
                                                            :class="ucapan.status_kehadiran === 'hadir'
                                                                ? 'bg-sage/10 text-sage ring-sage/20'
                                                                : (ucapan.status_kehadiran === 'ragu' ? 'bg-amber-50 text-amber-800 ring-amber-200/80' : 'bg-rose-50 text-rose-700 ring-rose-200/80')"
                                                            class="inline-flex items-center gap-1.5 rounded-lg px-2 py-0.5 text-[11px] font-semibold ring-1"
                                                        >
                                                            <span
                                                                :class="ucapan.status_kehadiran === 'hadir' ? 'bg-sage' : (ucapan.status_kehadiran === 'ragu' ? 'bg-amber-500' : 'bg-rose-500')"
                                                                class="h-1.5 w-1.5 rounded-full"
                                                            ></span>
                                                            <span x-text="ucapan.status_label"></span>
                                                        </span>
                                                        <span class="inline-flex items-center gap-1 rounded-lg bg-ivory px-2 py-0.5 text-[11px] font-semibold text-charcoal/70 ring-1 ring-champagne/30 tabular-nums">
                                                            <svg class="h-3 w-3 text-sage/80 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                                                <circle cx="9" cy="7" r="4"/>
                                                            </svg>
                                                            <span x-text="ucapan.jumlah_tamu + ' orang'"></span>
                                                        </span>
                                                    </div>

                                                    <p x-show="ucapan.waktu_label" class="sm:hidden inline-flex items-center gap-1 text-[11px] text-charcoal/45 tabular-nums">
                                                        <svg class="h-3 w-3 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                            <circle cx="12" cy="12" r="10"/>
                                                            <polyline points="12 6 12 12 16 14"/>
                                                        </svg>
                                                        <span x-text="ucapan.waktu_label"></span>
                                                    </p>
                                                </div>

                                                <div class="flex items-center gap-2.5 shrink-0">
                                                    <span x-show="ucapan.waktu_label" class="hidden sm:inline-flex items-center gap-1.5 text-[11.5px] font-medium text-charcoal/45 tabular-nums">
                                                        <svg class="h-3.5 w-3.5 shrink-0 text-charcoal/35" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                            <circle cx="12" cy="12" r="10"/>
                                                            <polyline points="12 6 12 12 16 14"/>
                                                        </svg>
                                                        <span x-text="ucapan.waktu_label"></span>
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
                                                        class="shrink-0"
                                                    >
                                                        @csrf
                                                        @method('DELETE')
                                                        <button
                                                            type="submit"
                                                            title="Hapus ucapan"
                                                            aria-label="Hapus ucapan"
                                                            class="inline-flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-xl bg-rose-50 text-rose-600 ring-1 ring-rose-200/90 hover:bg-rose-600 hover:text-white hover:ring-rose-600 active:scale-95 cursor-pointer transition shadow-2xs"
                                                        >
                                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                                <path d="M3 6h18"/>
                                                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                                                <line x1="10" x2="10" y1="11" y2="17"/>
                                                                <line x1="14" x2="14" y1="11" y2="17"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>

                                            {{-- Isi Ucapan & Doa dengan Bingkai Hangat --}}
                                            <div class="rounded-xl bg-ivory/75 px-3.5 py-2.5 ring-1 ring-champagne/25 flex items-start gap-2.5">
                                                <svg class="h-3.5 w-3.5 text-champagne shrink-0 mt-0.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M11 7.5v5.25c0 2.9-1.85 5.2-4.6 5.95l-.65-1.55c1.7-.55 2.75-1.8 2.95-3.4H5.75A1.75 1.75 0 0 1 4 12V7.5C4 6.67 4.67 6 5.5 6h3.75c.97 0 1.75.78 1.75 1.5Zm9 0v5.25c0 2.9-1.85 5.2-4.6 5.95l-.65-1.55c1.7-.55 2.75-1.8 2.95-3.4h-2.95A1.75 1.75 0 0 1 13 12V7.5c0-.83.67-1.5 1.5-1.5h3.75c.97 0 1.75.78 1.75 1.5Z"/>
                                                </svg>
                                                <p class="text-xs sm:text-[13.5px] text-charcoal/85 leading-relaxed whitespace-pre-line break-words min-w-0 flex-1" x-text="ucapan.ucapan_doa"></p>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </template>
                        </div>

                        {{-- Footer Paginasi Kartu --}}
                        <div
                            x-show="daftarTersaring().length > 0"
                            class="flex flex-col items-center sm:flex-row sm:justify-between gap-2.5 sm:gap-3 pt-1 text-center sm:text-left"
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
