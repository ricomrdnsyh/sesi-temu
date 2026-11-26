@extends('layouts.aplikasi')

@section('judul', 'RSVP & Ucapan — ' . $undangan->nama_panggilan_pria . ' & ' . $undangan->nama_panggilan_wanita)

@section('konten')
    @php
        $urlPublik = Route::has('undangan.tampil')
            ? route('undangan.tampil', $undangan->slug)
            : url('/' . $undangan->slug);
    @endphp

    <div
        x-data="{
            filterKehadiran: 'semua',
            init() {
                if (window.DataTable && !window.__sesiTemuRsvpFilterTerdaftar) {
                    window.__sesiTemuRsvpFilterTerdaftar = true;
                    window.DataTable.ext.search.push((settings, data, dataIndex) => {
                        const tabelEl = document.getElementById('tabel-rsvp-ucapan');
                        if (!tabelEl || settings.nTable !== tabelEl) return true;
                        const statusAktif = tabelEl.__sesiTemuFilterKehadiran || 'semua';
                        if (statusAktif === 'semua') return true;
                        const rowNode = settings.aoData?.[dataIndex]?.nTr;
                        return (rowNode?.dataset?.kehadiran || '') === statusAktif;
                    });
                }

                this.$nextTick(() => {
                    const tabelEl = document.getElementById('tabel-rsvp-ucapan');
                    if (tabelEl) {
                        tabelEl.__sesiTemuFilterKehadiran = this.filterKehadiran;
                    }
                });
            },
            setFilterKehadiran(status) {
                this.filterKehadiran = this.filterKehadiran === status && status !== 'semua' ? 'semua' : status;
                const tabelEl = document.getElementById('tabel-rsvp-ucapan');
                if (tabelEl) {
                    tabelEl.__sesiTemuFilterKehadiran = this.filterKehadiran;
                    tabelEl._sesiTemuDt?.draw();
                }
            },
        }"
        class="min-h-screen flex bg-ivory"
    >
        {{-- Sidebar Vertikal Ramping Desktop + Bottom Bar Mobile --}}
        @include('dashboard._workspace-sidebar', [
            'undangan' => $undangan,
            'menuAktif' => 'rsvp',
        ])

        <main class="flex-1 min-w-0">
            <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-10 pt-4 sm:pt-6 pb-28 lg:py-7 space-y-5">
                {{-- Hero Header Sage + Overlapping Summary Stat Dock --}}
                <section>
                    <div class="relative overflow-hidden rounded-[1.75rem] bg-gradient-to-br from-[#2B3F36] via-sage to-[#445B50] text-ivory px-5 sm:px-7 pt-5 pb-11 sm:pb-12 shadow-md ring-1 ring-sage/30">
                        <div aria-hidden="true" class="pointer-events-none absolute -right-12 -top-16 h-48 w-48 rounded-full bg-champagne/20 blur-2xl"></div>
                        <div aria-hidden="true" class="pointer-events-none absolute -left-10 -bottom-14 h-36 w-36 rounded-full bg-black/15 blur-2xl"></div>

                        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="space-y-1.5 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 text-xs text-ivory/70">
                                    <a href="{{ auth()->user()->adalahAdmin() ? route('admin.undangan.index') : route('dashboard.index') }}" class="hover:text-white transition">Dashboard</a>
                                    <span aria-hidden="true">&rsaquo;</span>
                                    <a href="{{ route('dashboard.undangan.kelola', $undangan) }}" class="hover:text-white transition truncate">{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</a>
                                    <span aria-hidden="true">&rsaquo;</span>
                                    <span class="font-semibold text-[#F5E3B8]">RSVP &amp; Ucapan</span>
                                </div>
                                <div class="flex flex-wrap items-center gap-2.5">
                                    <h1 class="font-sans text-xl sm:text-2xl font-bold text-white tracking-tight">RSVP &amp; Ucapan</h1>
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white/12 backdrop-blur-xs px-2.5 py-0.5 text-[11px] font-semibold text-ivory ring-1 ring-white/20">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                        <span class="font-mono text-[#F5E3B8]">sesitemu.id/{{ $undangan->slug }}</span>
                                    </span>
                                </div>
                                <p class="text-xs sm:text-sm text-ivory/80 max-w-2xl">
                                    Pantau konfirmasi kehadiran tamu secara real-time serta kelola doa dan ucapan di buku tamu.
                                </p>
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                                <a
                                    href="{{ route('dashboard.undangan.rsvp', $undangan) }}"
                                    title="Muat ulang daftar ucapan dan RSVP terbaru"
                                    class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-white/12 px-3 py-2.5 text-xs sm:text-sm font-semibold text-white ring-1 ring-white/20 hover:bg-white/20 active:scale-[0.98] transition"
                                >
                                    <svg class="h-4 w-4 text-[#F5E3B8] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M21 12a9 9 0 1 1-2.64-6.36L21 8"/>
                                        <path d="M21 3v5h-5"/>
                                    </svg>
                                    <span>Segarkan</span>
                                </a>
                                <a
                                    href="{{ $urlPublik }}"
                                    target="_blank"
                                    title="Pratinjau Undangan"
                                    class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-champagne px-4 py-2.5 text-xs sm:text-sm font-bold text-charcoal shadow-sm hover:bg-[#d1b26d] active:scale-[0.98] transition"
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

                    {{-- Overlapping Interactive Stat Cards --}}
                    <div class="relative z-20 mx-2 sm:mx-5 -mt-6 sm:-mt-7 grid grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-3">
                        <button
                            type="button"
                            @click="setFilterKehadiran('hadir')"
                            :class="filterKehadiran === 'hadir' ? 'ring-2 ring-sage shadow-md' : 'ring-1 ring-champagne/30 hover:ring-sage/50 shadow-sm'"
                            class="group rounded-2xl bg-white p-3.5 sm:p-4 text-left transition active:scale-[0.99] cursor-pointer flex items-center justify-between gap-3"
                        >
                            <div class="min-w-0">
                                <p class="text-[11px] font-semibold uppercase tracking-wider text-sage/85">Konfirmasi Hadir</p>
                                <p class="mt-1 font-sans tabular-nums text-2xl font-bold text-sage leading-none">{{ $rekapRsvp['hadir'] }}</p>
                                <p class="mt-1 text-[11px] text-charcoal/50 truncate">Klik untuk saring</p>
                            </div>
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-sage/12 text-sage ring-1 ring-sage/20 shrink-0 group-hover:scale-105 transition-transform">
                                <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                    <polyline points="22 4 12 14.01 9 11.01"/>
                                </svg>
                            </span>
                        </button>

                        <button
                            type="button"
                            @click="setFilterKehadiran('ragu')"
                            :class="filterKehadiran === 'ragu' ? 'ring-2 ring-amber-500 shadow-md' : 'ring-1 ring-champagne/30 hover:ring-amber-300 shadow-sm'"
                            class="group rounded-2xl bg-white p-3.5 sm:p-4 text-left transition active:scale-[0.99] cursor-pointer flex items-center justify-between gap-3"
                        >
                            <div class="min-w-0">
                                <p class="text-[11px] font-semibold uppercase tracking-wider text-amber-800/75">Masih Ragu</p>
                                <p class="mt-1 font-sans tabular-nums text-2xl font-bold text-amber-700 leading-none">{{ $rekapRsvp['ragu'] }}</p>
                                <p class="mt-1 text-[11px] text-charcoal/50 truncate">Belum pasti hadir</p>
                            </div>
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-700 ring-1 ring-amber-200/80 shrink-0 group-hover:scale-105 transition-transform">
                                <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"/>
                                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                                    <line x1="12" x2="12.01" y1="17" y2="17"/>
                                </svg>
                            </span>
                        </button>

                        <button
                            type="button"
                            @click="setFilterKehadiran('tidak_hadir')"
                            :class="filterKehadiran === 'tidak_hadir' ? 'ring-2 ring-rose-500 shadow-md' : 'ring-1 ring-champagne/30 hover:ring-rose-300 shadow-sm'"
                            class="group rounded-2xl bg-white p-3.5 sm:p-4 text-left transition active:scale-[0.99] cursor-pointer flex items-center justify-between gap-3"
                        >
                            <div class="min-w-0">
                                <p class="text-[11px] font-semibold uppercase tracking-wider text-rose-800/75">Tidak Hadir</p>
                                <p class="mt-1 font-sans tabular-nums text-2xl font-bold text-red-700 leading-none">{{ $rekapRsvp['tidak_hadir'] }}</p>
                                <p class="mt-1 text-[11px] text-charcoal/50 truncate">Mengirim doa restu</p>
                            </div>
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-rose-50 text-rose-600 ring-1 ring-rose-200/80 shrink-0 group-hover:scale-105 transition-transform">
                                <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="15" x2="9" y1="9" y2="15"/>
                                    <line x1="9" x2="15" y1="9" y2="15"/>
                                </svg>
                            </span>
                        </button>

                        <button
                            type="button"
                            @click="setFilterKehadiran('semua')"
                            :class="filterKehadiran === 'semua' ? 'ring-2 ring-champagne shadow-md' : 'ring-1 ring-champagne/30 hover:ring-champagne/65 shadow-sm'"
                            class="group rounded-2xl bg-white p-3.5 sm:p-4 text-left transition active:scale-[0.99] cursor-pointer flex items-center justify-between gap-3"
                        >
                            <div class="min-w-0">
                                <p class="text-[11px] font-semibold uppercase tracking-wider text-charcoal/55">Estimasi Orang Hadir</p>
                                <p class="mt-1 font-sans tabular-nums text-2xl font-bold text-charcoal leading-none">{{ $rekapRsvp['total_orang_hadir'] }}</p>
                                <p class="mt-1 text-[11px] text-charcoal/50 truncate">Tampilkan semua ucapan</p>
                            </div>
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-champagne/20 text-[#8A6D33] ring-1 ring-champagne/35 shrink-0 group-hover:scale-105 transition-transform">
                                <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                            </span>
                        </button>
                    </div>
                </section>

                {{-- Daftar Ucapan & Konfirmasi Kehadiran (DataTable) --}}
                <section class="rounded-[1.5rem] bg-white p-4 sm:p-6 shadow-sm ring-1 ring-champagne/25 space-y-3">
                    <div
                        x-show="filterKehadiran !== 'semua'"
                        x-cloak
                        class="flex items-center justify-between gap-2 rounded-xl bg-ivory/80 px-3.5 py-2 ring-1 ring-champagne/25 text-xs"
                    >
                        <p class="text-charcoal/75">
                            Menyaring kehadiran:
                            <span
                                class="font-bold text-charcoal"
                                x-text="filterKehadiran === 'hadir' ? 'Hadir' : (filterKehadiran === 'ragu' ? 'Masih Ragu' : 'Tidak Hadir')"
                            ></span>
                        </p>
                        <button
                            type="button"
                            @click="setFilterKehadiran('semua')"
                            class="font-semibold text-sage hover:underline cursor-pointer"
                        >
                            Tampilkan Semua
                        </button>
                    </div>

                    <table
                        id="tabel-rsvp-ucapan"
                        data-datatable
                        data-page-length="10"
                        data-empty-message="Belum ada ucapan atau konfirmasi kehadiran dari tamu."
                        class="w-full text-sm"
                    >
                        <thead>
                            <tr class="border-b border-champagne/20 text-left text-[11px] font-semibold uppercase tracking-wider text-charcoal/55">
                                <th class="py-3 pr-4 dt-left text-left">Nama Tamu</th>
                                <th class="py-3 px-4 dt-center text-center">Kehadiran</th>
                                <th class="py-3 px-4 dt-center text-center">Jumlah</th>
                                <th class="py-3 px-4 dt-left text-left">Ucapan &amp; Doa</th>
                                <th data-no-sort class="py-3 dt-center text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-champagne/15">
                            @foreach ($undangan->bukuTamu as $ucapan)
                                @php
                                    $potonganNama = collect(preg_split('/\s+/', trim((string) $ucapan->nama_tamu)) ?: [])->filter();
                                    $inisialUcapan = $potonganNama->count() >= 2
                                        ? mb_strtoupper(mb_substr($potonganNama->first(), 0, 1) . mb_substr($potonganNama->last(), 0, 1))
                                        : mb_strtoupper(mb_substr((string) $ucapan->nama_tamu, 0, 2));
                                @endphp
                                <tr data-kehadiran="{{ $ucapan->status_kehadiran }}" class="hover:bg-ivory/50 transition-colors">
                                    <td class="py-3.5 pr-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-champagne/18 text-[#7D6128] font-sans text-xs font-bold ring-1 ring-champagne/30 shrink-0">
                                                {{ $inisialUcapan ?: 'TM' }}
                                            </span>
                                            <div>
                                                <p class="font-semibold text-charcoal leading-snug">{{ $ucapan->nama_tamu }}</p>
                                                @if ($ucapan->created_at)
                                                    <p class="mt-0.5 text-[11px] text-charcoal/50">
                                                        {{ $ucapan->created_at->locale('id')->translatedFormat('d M Y, H:i') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 dt-center text-center whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold {{ $ucapan->status_kehadiran === 'hadir' ? 'bg-sage/12 text-sage ring-1 ring-sage/20' : ($ucapan->status_kehadiran === 'ragu' ? 'bg-amber-50 text-amber-800 ring-1 ring-amber-200/80' : 'bg-rose-50 text-rose-700 ring-1 ring-rose-200/80') }}">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $ucapan->status_kehadiran === 'hadir' ? 'bg-sage' : ($ucapan->status_kehadiran === 'ragu' ? 'bg-amber-500' : 'bg-rose-500') }}"></span>
                                            <span>{{ str_replace('_', ' ', ucfirst($ucapan->status_kehadiran)) }}</span>
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 dt-center text-center whitespace-nowrap" data-order="{{ (int) $ucapan->jumlah_tamu }}">
                                        <span class="inline-flex items-center gap-1 rounded-lg bg-ivory px-2.5 py-1 font-sans tabular-nums text-xs font-semibold text-charcoal/80 ring-1 ring-champagne/25">
                                            {{ $ucapan->jumlah_tamu }} orang
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-charcoal/80 min-w-[14rem] max-w-md leading-relaxed">
                                        {{ $ucapan->ucapan_doa }}
                                    </td>
                                    <td class="py-3.5 dt-center text-center whitespace-nowrap">
                                        <form
                                            action="{{ route('dashboard.ucapan.hapus', [$undangan, $ucapan]) }}"
                                            method="POST"
                                            data-swal-title="Hapus Ucapan Tamu?"
                                            data-swal-confirm="Yakin ingin menghapus ucapan dari {{ $ucapan->nama_tamu }}?"
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
                                                class="inline-flex items-center gap-1 rounded-xl border border-rose-200/80 bg-rose-50/70 px-2.5 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-600 hover:text-white hover:border-rose-600 cursor-pointer transition"
                                            >
                                                <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M3 6h18"/>
                                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                                </svg>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>
            </div>
        </main>
    </div>
@endsection
