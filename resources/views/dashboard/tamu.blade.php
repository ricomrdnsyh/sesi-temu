@extends('layouts.aplikasi')

@section('judul', 'Daftar Tamu — ' . $undangan->nama_panggilan_pria . ' & ' . $undangan->nama_panggilan_wanita)

@section('konten')
    @php
        $undanganSiapDisebar = $undangan->sudahAktifPublik();
        $sudahKedaluwarsa = $undangan->sudahKedaluwarsa();
        $sedangMenungguVerifikasi = $undangan->transaksi->contains('status', 'menunggu_verifikasi');
        $urlPublik = Route::has('undangan.tampil')
            ? route('undangan.tampil', $undangan->slug)
            : url('/' . $undangan->slug);

        $daftarTamuJson = $undangan->daftarTamu
            ->map(fn (\App\Models\TamuUndangan $tamu): array => [
                'id' => $tamu->id,
                'kode_tamu' => $tamu->kode_tamu,
                'nama_tamu' => $tamu->nama_tamu,
                'nomor_wa' => $tamu->nomor_wa,
                'sudah_dikirim' => $tamu->sudahDikirim(),
                'dikirim_pada_label' => $tamu->dikirim_pada
                    ? $tamu->dikirim_pada->locale('id')->translatedFormat('d M, H:i')
                    : null,
                'sudah_dibuka' => $tamu->sudahDibuka(),
                'dibuka_pada_label' => $tamu->dibuka_pada
                    ? $tamu->dibuka_pada->locale('id')->translatedFormat('d M, H:i')
                    : null,
                'terakhir_dibuka_label' => $tamu->terakhir_dibuka_pada
                    ? $tamu->terakhir_dibuka_pada->locale('id')->translatedFormat('d M, H:i')
                    : null,
                'jumlah_dibuka' => (int) $tamu->jumlah_dibuka,
                'url_status_kirim' => route('dashboard.tamu.status-kirim', [$undangan, $tamu]),
                'url_perbarui' => route('dashboard.tamu.perbarui', [$undangan, $tamu]),
                'url_hapus' => route('dashboard.tamu.hapus', [$undangan, $tamu]),
                'tersalin' => false,
                'sedang_proses_kirim' => false,
            ])
            ->values()
            ->all();

        $bukaModalTambahAwal = $errors->hasAny(['nama_tamu', 'nomor_wa', 'daftar_bulk', 'file_csv']);
        $modeTambahAwal = old('mode', $errors->has('file_csv') ? 'csv' : ($errors->has('daftar_bulk') ? 'massal' : 'satuan'));
        $konfigTemplatePesanWa = [
            'urlPublikUndangan' => $urlPublik,
            'namaPria' => $undangan->nama_panggilan_pria,
            'namaWanita' => $undangan->nama_panggilan_wanita,
            'siapDisebarUndangan' => $undanganSiapDisebar,
            'csrfToken' => csrf_token(),
            'daftarTamu' => $daftarTamuJson,
            'modalTambah' => $bukaModalTambahAwal,
            'modeTambah' => $modeTambahAwal,
            'daftarBulkAwal' => old('mode') === 'massal' ? (string) old('daftar_bulk', '') : '',
            'templateAwal' => $undangan->templatePesanWa(),
            'templateBawaan' => $undangan->templatePesanWaBawaan(),
            'presets' => $undangan->daftarPresetPesanWa(),
            'urlSimpan' => route('dashboard.tamu.template-pesan', $undangan, false),
        ];
    @endphp

    <script id="tamu-template-pesan-config" type="application/json">{!! json_encode($konfigTemplatePesanWa, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>

    <div
        x-data="halamanTamuUndangan()"
        @keydown.escape.window="if (!window.Swal?.isVisible()) { modalTambah = false; modalEdit = false; dropdownKelolaTerbuka = false; dropdownAturTerbuka = false; tutupModalTemplatePesan(); menuTamu = null; }"
        @scroll.window="menuTamu = null"
        class="min-h-screen flex bg-ivory"
    >
        {{-- Sidebar Vertikal Ramping Desktop + Bottom Bar Mobile --}}
        @include('dashboard._workspace-sidebar', [
            'undangan' => $undangan,
            'menuAktif' => 'tamu',
        ])

        <div class="flex-1 min-w-0 flex flex-col">
            @include('dashboard._workspace-header', [
                'undangan' => $undangan,
                'menuAktif' => 'tamu',
                'judulHalaman' => 'Daftar Tamu',
            ])

            <main class="flex-1 min-w-0">
                <h1 class="sr-only">Daftar Tamu</h1>
                <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-10 pt-4 sm:pt-5 pb-28 lg:py-5 space-y-4">
            {{-- 4 Kartu Bento KPI SesiTemu --}}
            <section class="space-y-3.5">
                @if (! $undanganSiapDisebar)
                    <div class="rounded-2xl bg-amber-50/85 px-4 py-3 text-xs sm:text-[13px] text-amber-900 ring-1 ring-amber-200/80 flex flex-wrap items-center justify-between gap-2">
                        <p class="leading-relaxed">
                            @if ($sudahKedaluwarsa)
                                <strong class="font-semibold">Masa aktif undangan sudah berakhir.</strong> Daftar tamu tetap tersimpan, aktifkan kembali undangan agar tombol <strong>Kirim</strong> dan <strong>Salin</strong> bisa dipakai.
                            @elseif ($sedangMenungguVerifikasi)
                                <strong class="font-semibold">Pembayaran sedang diverifikasi.</strong> Susun daftar tamu dari sekarang — tombol <strong>Kirim</strong> dan <strong>Salin</strong> otomatis aktif begitu disetujui.
                            @else
                                <strong class="font-semibold">Undangan masih draft.</strong> Susun daftar tamu dari sekarang. Tombol <strong>Kirim</strong> dan <strong>Salin</strong> aktif begitu undangan aktif.
                            @endif
                        </p>
                        @if (Route::has('dashboard.pembayaran'))
                            <a href="{{ route('dashboard.pembayaran', $undangan) }}" class="inline-flex items-center font-semibold text-amber-900 underline decoration-amber-400 underline-offset-2 hover:text-charcoal shrink-0">
                                Lihat Status &rarr;
                            </a>
                        @endif
                    </div>
                @endif

                {{-- 4 Bento Filter KPI Cards --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-3">
                    <button
                        type="button"
                        @click="setFilterStatus('semua')"
                        :class="filterStatus === 'semua' ? 'ring-2 ring-sage shadow-md -translate-y-0.5' : 'ring-1 ring-champagne/25 hover:ring-champagne/55 shadow-2xs'"
                        class="group rounded-2xl bg-white p-3 sm:p-4 text-left transition-all cursor-pointer flex items-center gap-2.5 sm:gap-3.5"
                    >
                        <span class="inline-flex h-9 w-9 sm:h-11 sm:w-11 items-center justify-center rounded-xl sm:rounded-2xl bg-ivory text-charcoal/75 ring-1 ring-champagne/30 shrink-0 group-hover:scale-105 transition-transform">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        </span>
                        <div class="min-w-0">
                            <p class="text-[10px] sm:text-[11px] font-semibold uppercase tracking-wider text-charcoal/55 truncate">Semua Tamu</p>
                            <div class="mt-0.5 flex items-baseline gap-1.5">
                                <p class="font-sans tabular-nums text-xl sm:text-2xl font-bold text-charcoal leading-none" x-text="stat().total"></p>
                                <span class="hidden sm:inline text-[11px] text-charcoal/45 truncate">terdaftar</span>
                            </div>
                        </div>
                    </button>

                    <button
                        type="button"
                        @click="setFilterStatus('belum_dikirim')"
                        :class="filterStatus === 'belum_dikirim' ? 'ring-2 ring-amber-500 shadow-md -translate-y-0.5' : 'ring-1 ring-champagne/25 hover:ring-amber-300 shadow-2xs'"
                        class="group rounded-2xl bg-gradient-to-br from-white to-amber-50/75 p-3 sm:p-4 text-left transition-all cursor-pointer flex items-center gap-2.5 sm:gap-3.5"
                    >
                        <span class="inline-flex h-9 w-9 sm:h-11 sm:w-11 items-center justify-center rounded-xl sm:rounded-2xl bg-amber-100/80 text-amber-700 ring-1 ring-amber-200/80 shrink-0 group-hover:scale-105 transition-transform">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                        </span>
                        <div class="min-w-0">
                            <p class="text-[10px] sm:text-[11px] font-semibold uppercase tracking-wider text-amber-800/80 truncate">Belum Dikirim</p>
                            <div class="mt-0.5 flex items-baseline gap-1.5">
                                <p class="font-sans tabular-nums text-xl sm:text-2xl font-bold text-amber-700 leading-none" x-text="stat().belumDikirim"></p>
                                <span class="hidden sm:inline text-[11px] text-charcoal/45 truncate">menunggu</span>
                            </div>
                        </div>
                    </button>

                    <button
                        type="button"
                        @click="setFilterStatus('sudah_dikirim')"
                        :class="filterStatus === 'sudah_dikirim' ? 'ring-2 ring-sage shadow-md -translate-y-0.5' : 'ring-1 ring-champagne/25 hover:ring-sage/50 shadow-2xs'"
                        class="group rounded-2xl bg-gradient-to-br from-white to-sage/[0.07] p-3 sm:p-4 text-left transition-all cursor-pointer flex items-center gap-2.5 sm:gap-3.5"
                    >
                        <span class="inline-flex h-9 w-9 sm:h-11 sm:w-11 items-center justify-center rounded-xl sm:rounded-2xl bg-sage/12 text-sage ring-1 ring-sage/20 shrink-0 group-hover:scale-105 transition-transform">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="m22 2-7 20-4-9-9-4Z"/>
                                <path d="M22 2 11 13"/>
                            </svg>
                        </span>
                        <div class="min-w-0">
                            <p class="text-[10px] sm:text-[11px] font-semibold uppercase tracking-wider text-sage/85 truncate">Terkirim</p>
                            <div class="mt-0.5 flex items-baseline gap-1.5">
                                <p class="font-sans tabular-nums text-xl sm:text-2xl font-bold text-sage leading-none" x-text="stat().sudahDikirim"></p>
                                <span class="hidden sm:inline text-[11px] text-charcoal/45 truncate">dibagikan</span>
                            </div>
                        </div>
                    </button>

                    <button
                        type="button"
                        @click="setFilterStatus('sudah_dibuka')"
                        :class="filterStatus === 'sudah_dibuka' ? 'ring-2 ring-emerald-600 shadow-md -translate-y-0.5' : 'ring-1 ring-champagne/25 hover:ring-emerald-300 shadow-2xs'"
                        class="group rounded-2xl bg-gradient-to-br from-white to-emerald-50/80 p-3 sm:p-4 text-left transition-all cursor-pointer flex items-center gap-2.5 sm:gap-3.5"
                    >
                        <span class="inline-flex h-9 w-9 sm:h-11 sm:w-11 items-center justify-center rounded-xl sm:rounded-2xl bg-emerald-100/80 text-emerald-700 ring-1 ring-emerald-200/80 shrink-0 group-hover:scale-105 transition-transform">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="text-[10px] sm:text-[11px] font-semibold uppercase tracking-wider text-emerald-800/80 truncate">Sudah Dibuka</p>
                            <div class="mt-0.5 flex items-baseline justify-between gap-1.5">
                                <p class="font-sans tabular-nums text-xl sm:text-2xl font-bold text-emerald-700 leading-none" x-text="stat().sudahDibuka"></p>
                                <span class="text-[10.5px] sm:text-[11px] font-bold text-emerald-700 tabular-nums" x-text="persenDibuka() + '%'"></span>
                            </div>
                            <div class="mt-1.5 h-1 w-full rounded-full bg-emerald-200/60 overflow-hidden">
                                <div class="h-full rounded-full bg-emerald-500 transition-all duration-500" :style="{ width: persenDibuka() + '%' }"></div>
                            </div>
                        </div>
                    </button>
                </div>
            </section>

            {{-- Baris Aksi Ringkas (Kelola + Tambah Tamu) & Pencarian Lebar + Atur --}}
            <section class="space-y-3">
                <div class="flex flex-wrap items-center justify-between gap-2.5">
                    <div class="min-w-0 flex items-center gap-2">
                        <button
                            type="button"
                            x-show="filterStatus !== 'semua'"
                            x-cloak
                            @click="setFilterStatus('semua')"
                            class="inline-flex items-center gap-1.5 rounded-full bg-sage/10 px-3 py-1.5 text-xs font-semibold text-sage ring-1 ring-sage/20 hover:bg-sage/15 transition cursor-pointer"
                        >
                            <span x-text="filterStatus === 'belum_dikirim' ? 'Filter: Belum Dikirim' : (filterStatus === 'sudah_dikirim' ? 'Filter: Terkirim' : 'Filter: Sudah Dibuka')"></span>
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="flex items-center gap-2 w-full sm:w-auto sm:ml-auto shrink-0">
                        {{-- Dropdown Kelola (Template Pesan, Import CSV, Ekspor Excel/CSV) --}}
                        <div class="relative flex-1 sm:flex-initial" @click.away="dropdownKelolaTerbuka = false">
                            <button
                                type="button"
                                @click="dropdownKelolaTerbuka = !dropdownKelolaTerbuka; dropdownAturTerbuka = false"
                                data-tombol-kelola-tamu
                                :aria-expanded="dropdownKelolaTerbuka ? 'true' : 'false'"
                                class="w-full sm:w-auto inline-flex h-10 items-center justify-center gap-1.5 rounded-xl bg-white px-4 text-xs sm:text-[13px] font-semibold text-charcoal ring-1 ring-champagne/40 hover:bg-ivory hover:ring-sage/45 active:scale-[0.98] transition cursor-pointer shadow-2xs"
                            >
                                <svg class="h-3.5 w-3.5 text-sage shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <line x1="4" x2="20" y1="21" y2="21"/>
                                    <line x1="4" x2="20" y1="3" y2="3"/>
                                    <line x1="4" x2="20" y1="12" y2="12"/>
                                    <circle cx="8" cy="3" r="2" fill="currentColor"/>
                                    <circle cx="16" cy="12" r="2" fill="currentColor"/>
                                    <circle cx="10" cy="21" r="2" fill="currentColor"/>
                                </svg>
                                <span>Kelola</span>
                                <svg
                                    :class="dropdownKelolaTerbuka ? 'rotate-180 text-sage' : 'text-charcoal/45'"
                                    class="h-3.5 w-3.5 transition-transform shrink-0"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                                >
                                    <path d="m6 9 6 6 6-6"/>
                                </svg>
                            </button>

                            <div
                                x-show="dropdownKelolaTerbuka"
                                x-cloak
                                x-transition.opacity.duration.120ms
                                class="absolute left-0 sm:left-auto sm:right-0 top-full mt-2 z-30 w-64 max-w-[calc(100vw-2rem)] rounded-2xl bg-white p-1.5 shadow-xl ring-1 ring-champagne/35 text-left space-y-0.5"
                            >
                                <button
                                    type="button"
                                    @click="bukaModalTemplatePesan()"
                                    data-tombol-template-pesan
                                    class="w-full flex items-center gap-2.5 rounded-xl px-2.5 py-2 text-left hover:bg-ivory transition group cursor-pointer"
                                >
                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-sage/10 text-sage ring-1 ring-sage/15 shrink-0">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                            <path d="M8 9h8"/>
                                            <path d="M8 13h5"/>
                                        </svg>
                                    </span>
                                    <span class="min-w-0 flex-1">
                                        <span class="flex items-center justify-between gap-2">
                                            <span class="text-xs font-semibold text-charcoal group-hover:text-sage">Template Pesan</span>
                                            <span class="rounded-md bg-ivory px-1.5 py-0.5 text-[10px] font-semibold text-sage ring-1 ring-champagne/30" x-text="presetPesanTerpilih === 'kustom' ? 'Kustom' : labelPresetAktif()"></span>
                                        </span>
                                        <span class="block text-[10.5px] text-charcoal/55 truncate">Ubah isi pesan WhatsApp</span>
                                    </span>
                                </button>

                                <button
                                    type="button"
                                    @click="bukaModalTambah('csv')"
                                    data-tombol-import-csv
                                    class="w-full flex items-center gap-2.5 rounded-xl px-2.5 py-2 text-left hover:bg-ivory transition group cursor-pointer"
                                >
                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-champagne/20 text-[#8A6D33] ring-1 ring-champagne/30 shrink-0">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                            <polyline points="17 8 12 3 7 8"/>
                                            <line x1="12" x2="12" y1="3" y2="15"/>
                                        </svg>
                                    </span>
                                    <span class="min-w-0">
                                        <span class="block text-xs font-semibold text-charcoal group-hover:text-sage">Import CSV</span>
                                        <span class="block text-[10.5px] text-charcoal/55 truncate">Unggah daftar tamu dari CSV</span>
                                    </span>
                                </button>

                                <div class="my-1 border-t border-champagne/20"></div>

                                <a
                                    href="{{ route('dashboard.tamu.ekspor', [$undangan, 'format' => 'xlsx']) }}"
                                    @click="dropdownKelolaTerbuka = false"
                                    class="flex items-center gap-2.5 rounded-xl px-2.5 py-2 hover:bg-ivory transition group"
                                >
                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-50 text-[10px] font-bold text-emerald-700 ring-1 ring-emerald-200/80 shrink-0">XLSX</span>
                                    <span class="min-w-0">
                                        <span class="block text-xs font-semibold text-charcoal group-hover:text-sage">Export Excel</span>
                                        <span class="block text-[10.5px] text-charcoal/55 truncate">Unduh tabel rapi (.xlsx)</span>
                                    </span>
                                </a>

                                <a
                                    href="{{ route('dashboard.tamu.ekspor', [$undangan, 'format' => 'csv']) }}"
                                    @click="dropdownKelolaTerbuka = false"
                                    class="flex items-center gap-2.5 rounded-xl px-2.5 py-2 hover:bg-ivory transition group"
                                >
                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-ivory text-[10px] font-bold text-charcoal/75 ring-1 ring-champagne/35 shrink-0">CSV</span>
                                    <span class="min-w-0">
                                        <span class="block text-xs font-semibold text-charcoal group-hover:text-sage">Export CSV</span>
                                        <span class="block text-[10.5px] text-charcoal/55 truncate">Format teks ringan (.csv)</span>
                                    </span>
                                </a>
                            </div>
                        </div>

                        <button
                            type="button"
                            @click="bukaModalTambah('satuan')"
                            class="flex-1 sm:flex-initial inline-flex h-10 items-center justify-center gap-1.5 rounded-xl bg-sage px-4 sm:px-5 text-xs sm:text-[13px] font-semibold text-white shadow-[0_8px_18px_-8px_rgba(75,99,88,0.65)] hover:bg-[#3A4F45] active:scale-[0.98] transition cursor-pointer shrink-0"
                        >
                            <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 5v14" />
                                <path d="M5 12h14" />
                            </svg>
                            <span>Tambah Tamu</span>
                        </button>
                    </div>
                </div>

                {{-- Baris Pencarian Lebar + Tombol Atur (Urutkan & Jumlah Tampil) --}}
                <div x-show="daftarTamu.length > 0" class="flex items-center gap-2">
                    <div class="relative flex-1">
                        <svg class="pointer-events-none h-4 w-4 text-charcoal/40 absolute left-4 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.3-4.3"/>
                        </svg>
                        <input
                            type="search"
                            x-model="kataCari"
                            @input="halaman = 1"
                            placeholder="Cari nama tamu atau nomor WA..."
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
                            @click="dropdownAturTerbuka = !dropdownAturTerbuka; dropdownKelolaTerbuka = false"
                            :class="(urutan !== 'terbaru' || perHalaman !== 10) ? 'ring-sage/50 text-sage' : 'ring-champagne/30 text-charcoal/80'"
                            class="relative inline-flex h-10 sm:h-11 items-center justify-center gap-1.5 rounded-xl bg-white px-3.5 sm:px-4 text-xs sm:text-sm font-semibold ring-1 hover:bg-ivory transition cursor-pointer shadow-2xs"
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
                            <span
                                x-show="urutan !== 'terbaru' || perHalaman !== 10"
                                x-cloak
                                class="h-1.5 w-1.5 rounded-full bg-sage"
                            ></span>
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
                                        @click="setUrutan('nama_az'); dropdownAturTerbuka = false"
                                        :class="urutan === 'nama_az' ? 'bg-sage/10 text-sage font-semibold' : 'text-charcoal/80 hover:bg-ivory'"
                                        class="flex items-center justify-between rounded-xl px-3 py-2 text-xs transition cursor-pointer"
                                    >
                                        <span>Nama A–Z</span>
                                        <span x-show="urutan === 'nama_az'" class="text-sage font-bold">&check;</span>
                                    </button>
                                    <button
                                        type="button"
                                        @click="setUrutan('sering_dibuka'); dropdownAturTerbuka = false"
                                        :class="urutan === 'sering_dibuka' ? 'bg-sage/10 text-sage font-semibold' : 'text-charcoal/80 hover:bg-ivory'"
                                        class="flex items-center justify-between rounded-xl px-3 py-2 text-xs transition cursor-pointer"
                                    >
                                        <span>Sering Dibuka</span>
                                        <span x-show="urutan === 'sering_dibuka'" class="text-sage font-bold">&check;</span>
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
            </section>

            {{-- DAFTAR TAMU DALAM BENTUK CARD GRID --}}
            <section id="daftar-kartu-tamu" data-tamu-cards class="space-y-4">
                {{-- Empty State: Belum Ada Tamu --}}
                <div
                    x-show="daftarTamu.length === 0"
                    class="rounded-[1.75rem] bg-white px-6 py-14 text-center ring-1 ring-champagne/25 shadow-2xs space-y-4"
                >
                    <div class="mx-auto w-14 h-14 rounded-2xl bg-sage/10 text-sage ring-1 ring-sage/15 flex items-center justify-center">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M19 8v6"/>
                            <path d="M22 11h-6"/>
                        </svg>
                    </div>
                    <div class="max-w-sm mx-auto space-y-1">
                        <p class="font-sans text-base font-bold text-charcoal">Belum ada tamu di daftar Anda</p>
                        <p class="text-xs sm:text-sm text-charcoal/60 leading-relaxed">
                            Tambahkan nama &amp; nomor WhatsApp tamu untuk langsung mengirim link personal dan memantau status buka.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-2 pt-1">
                        <button
                            type="button"
                            @click="bukaModalTambah('satuan')"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 rounded-xl bg-sage px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#3A4F45] transition cursor-pointer"
                        >
                            <span>+ Tambah Tamu</span>
                        </button>
                        <button
                            type="button"
                            @click="bukaModalTambah('csv')"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 rounded-xl bg-ivory px-5 py-2.5 text-sm font-semibold text-charcoal ring-1 ring-champagne/40 hover:bg-champagne/10 transition cursor-pointer"
                        >
                            <span>Import dari CSV</span>
                        </button>
                    </div>
                </div>

                {{-- Empty State: Hasil Filter / Pencarian Kosong --}}
                <div
                    x-show="daftarTamu.length > 0 && daftarTersaring().length === 0"
                    x-cloak
                    class="rounded-[1.75rem] bg-white px-6 py-12 text-center ring-1 ring-champagne/25 shadow-2xs space-y-3"
                >
                    <p class="text-sm font-bold text-charcoal">Tidak ada tamu yang cocok dengan filter ini.</p>
                    <p class="text-xs text-charcoal/55">Coba ubah kata kunci pencarian atau tampilkan semua status tamu.</p>
                    <button
                        type="button"
                        @click="setFilterStatus('semua'); kataCari = ''"
                        class="inline-flex items-center rounded-xl bg-ivory px-4 py-2 text-xs font-semibold text-sage ring-1 ring-sage/25 hover:bg-sage/10 transition cursor-pointer"
                    >
                        Tampilkan Semua Tamu
                    </button>
                </div>

                {{-- Daftar Baris Tamu Ringkas & Bersih --}}
                <div
                    x-show="daftarHalamanIni().length > 0"
                    class="space-y-2.5"
                >
                    <template x-for="tamu in daftarHalamanIni()" :key="tamu.id">
                        <article class="group rounded-2xl bg-white px-4 sm:px-5 py-3.5 ring-1 ring-champagne/25 hover:ring-champagne/60 hover:shadow-[0_10px_26px_-18px_rgba(28,42,35,0.22)] transition flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            {{-- Kiri: Avatar Inisial + Nama, No WA & Badge Status Ringkas --}}
                            <div class="flex items-start sm:items-center gap-3 min-w-0 flex-1">
                                <span
                                    :class="tamu.sudah_dibuka
                                        ? 'bg-emerald-50 text-emerald-700 ring-emerald-200/80'
                                        : (tamu.sudah_dikirim ? 'bg-sage/12 text-sage ring-sage/20' : 'bg-ivory text-charcoal/70 ring-champagne/35')"
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl font-sans text-xs font-bold tracking-tight shrink-0 ring-1 mt-0.5 sm:mt-0"
                                    x-text="inisialNama(tamu.nama_tamu)"
                                ></span>

                                <div class="min-w-0 flex-1 space-y-1">
                                    <div class="flex flex-wrap items-baseline gap-x-2.5 gap-y-0.5">
                                        <h2 class="font-sans text-sm sm:text-[15px] font-bold text-charcoal leading-snug truncate max-w-full" x-text="tamu.nama_tamu"></h2>
                                        <template x-if="tamu.nomor_wa">
                                            <span class="tabular-nums font-mono text-[11.5px] text-charcoal/50" x-text="tamu.nomorWaTampil"></span>
                                        </template>
                                        <template x-if="!tamu.nomor_wa">
                                            <button
                                                type="button"
                                                @click="bukaModalEdit(tamu)"
                                                class="text-[11px] font-medium text-sage/85 hover:text-sage hover:underline cursor-pointer"
                                            >
                                                + Tambah No. WA
                                            </button>
                                        </template>
                                    </div>

                                    <div class="flex flex-wrap items-center gap-1.5">
                                        {{-- Status Kirim --}}
                                        <template x-if="tamu.sudah_dikirim">
                                            <span class="inline-flex items-center gap-1 rounded-full bg-sage/10 px-2.5 py-0.5 text-[11px] font-semibold text-sage">
                                                <svg class="h-3 w-3 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M20 6 9 17l-5-5"/>
                                                </svg>
                                                <span>Terkirim</span>
                                                <span x-show="tamu.dikirim_pada_label" class="font-normal text-sage/75" x-text="'· ' + tamu.dikirim_pada_label"></span>
                                            </span>
                                        </template>
                                        <template x-if="!tamu.sudah_dikirim">
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-ivory px-2.5 py-0.5 text-[11px] font-medium text-charcoal/60 ring-1 ring-champagne/25">
                                                <span class="h-1.5 w-1.5 rounded-full bg-amber-400"></span>
                                                <span>Belum Dikirim</span>
                                            </span>
                                        </template>

                                        {{-- Status Buka --}}
                                        <template x-if="tamu.sudah_dibuka">
                                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-700 ring-1 ring-emerald-200/70">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                <span x-text="'Dibuka ' + tamu.jumlah_dibuka + 'x'"></span>
                                                <span x-show="tamu.dibuka_pada_label" class="font-normal text-emerald-700/75" x-text="'· ' + tamu.dibuka_pada_label"></span>
                                            </span>
                                        </template>
                                        <template x-if="!tamu.sudah_dibuka">
                                            <span class="inline-flex items-center gap-1 rounded-full bg-charcoal/[0.04] px-2.5 py-0.5 text-[11px] font-medium text-charcoal/50">
                                                <span>Belum Dibuka</span>
                                            </span>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            {{-- Kanan: Aksi Cepat (Salin, Kirim WA, Opsi Lain) --}}
                            <div class="flex items-center justify-end gap-2 pt-2 sm:pt-0 border-t sm:border-t-0 border-champagne/15 shrink-0">
                                @if ($undanganSiapDisebar)
                                    <button
                                        type="button"
                                        @click="salinPesan(tamu)"
                                        title="Salin pesan undangan"
                                        class="inline-flex h-9 items-center justify-center gap-1.5 rounded-xl border border-champagne/35 bg-ivory/60 px-3 text-xs font-semibold text-charcoal/80 hover:bg-ivory hover:text-charcoal active:scale-[0.98] transition cursor-pointer"
                                    >
                                        <svg class="h-3.5 w-3.5 text-sage shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <rect width="14" height="14" x="8" y="8" rx="2" ry="2"/>
                                            <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>
                                        </svg>
                                        <span x-text="tamu.tersalin ? 'Tersalin!' : 'Salin'"></span>
                                    </button>
                                    <a
                                        :href="tamu.waUrl"
                                        target="_blank"
                                        rel="noopener"
                                        @click="tandaiKirimSaatKlikWa(tamu)"
                                        :class="tamu.sudah_dikirim
                                            ? 'border border-sage/35 bg-white text-sage hover:bg-sage hover:text-white'
                                            : 'border border-emerald-200 bg-emerald-50/70 text-emerald-700 hover:bg-emerald-600 hover:text-white hover:border-emerald-600'"
                                        class="inline-flex h-9 items-center justify-center gap-1.5 rounded-xl px-3.5 text-xs font-semibold active:scale-[0.98] transition"
                                    >
                                        <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="m22 2-7 20-4-9-9-4Z"/>
                                            <path d="M22 2 11 13"/>
                                        </svg>
                                        <span x-text="tamu.sudah_dikirim ? 'Kirim Lagi' : 'Kirim'"></span>
                                    </a>
                                @else
                                    <button type="button" disabled class="inline-flex h-9 items-center rounded-xl border border-charcoal/12 bg-charcoal/[0.03] px-3 text-xs font-semibold text-charcoal/40 cursor-not-allowed">
                                        Salin
                                    </button>
                                    <button type="button" disabled class="inline-flex h-9 items-center rounded-xl border border-charcoal/12 bg-charcoal/[0.05] px-3.5 text-xs font-semibold text-charcoal/40 cursor-not-allowed">
                                        Kirim
                                    </button>
                                @endif

                                <button
                                    type="button"
                                    @click.stop="toggleMenu(tamu, $event)"
                                    title="Opsi lain"
                                    aria-label="Opsi lain"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-charcoal/50 hover:bg-ivory hover:text-charcoal transition cursor-pointer shrink-0"
                                >
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <circle cx="12" cy="5" r="1.6"/>
                                        <circle cx="12" cy="12" r="1.6"/>
                                        <circle cx="12" cy="19" r="1.6"/>
                                    </svg>
                                </button>
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

            {{-- Floating Menu Aksi Kartu Tamu --}}
            <div
                x-show="menuTamu !== null"
                x-cloak
                x-transition.opacity.duration.100ms
                @click.away="menuTamu = null"
                :style="{ top: menuStyle.top, bottom: menuStyle.bottom, right: menuStyle.right }"
                class="fixed z-50 w-52 rounded-2xl bg-white p-1.5 shadow-xl ring-1 ring-champagne/35 text-left"
            >
                <button
                    type="button"
                    @click="salinLinkSaja(menuTamu)"
                    class="w-full rounded-xl px-3 py-2 text-xs font-medium text-charcoal/85 hover:bg-ivory text-left transition cursor-pointer"
                >
                    Salin Link Saja
                </button>
                <button
                    type="button"
                    @click="const t = menuTamu; menuTamu = null; setStatusKirim(t, !t?.sudah_dikirim)"
                    class="w-full rounded-xl px-3 py-2 text-xs font-medium text-charcoal/85 hover:bg-ivory text-left transition cursor-pointer"
                    x-text="menuTamu?.sudah_dikirim ? 'Tandai Belum Dikirim' : 'Tandai Sudah Dikirim'"
                ></button>
                <button
                    type="button"
                    @click="bukaModalEdit(menuTamu)"
                    class="w-full rounded-xl px-3 py-2 text-xs font-medium text-charcoal/85 hover:bg-ivory text-left transition cursor-pointer"
                >
                    Edit Nama &amp; No. WA
                </button>
                <div class="my-1 border-t border-champagne/20"></div>
                <form
                    :action="menuTamu?.url_hapus || '#'"
                    method="POST"
                    data-swal-title="Hapus Tamu?"
                    :data-swal-confirm="'Tamu ' + (menuTamu?.nama_tamu || '') + ' akan dihapus dari daftar beserta riwayat status kirim & bukanya.'"
                    data-swal-icon="warning"
                    data-swal-confirm-button="Ya, Hapus"
                    data-swal-confirm-color="#DC2626"
                    data-swal-loading-title="Menghapus Tamu..."
                    data-swal-loading-text="Menghapus tamu dari daftar..."
                >
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="w-full rounded-xl px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 text-left transition cursor-pointer"
                    >
                        Hapus Tamu
                    </button>
                </form>
            </div>

            {{-- MODAL TAMBAH TAMU (SATUAN / IMPORT BANYAK) --}}
            <div
                x-show="modalTambah"
                x-cloak
                x-transition.opacity
                class="fixed inset-0 z-50 bg-charcoal/50 backdrop-blur-xs flex items-center justify-center p-3 sm:p-4"
            >
                <div
                    @click.away="if (!window.Swal?.isVisible() && !$event.target?.closest('.swal2-container')) modalTambah = false"
                    class="w-full max-w-lg max-h-[90dvh] overflow-y-auto rounded-xl bg-white p-5 sm:p-6 shadow-2xl ring-1 ring-champagne/30 space-y-4"
                >
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <h2 class="font-sans text-lg font-bold text-charcoal tracking-tight">Tambah Tamu Undangan</h2>
                            <p class="text-xs text-charcoal/60">Tamu otomatis mendapat link personal &amp; pelacakan buka.</p>
                        </div>
                        <button
                            type="button"
                            @click="modalTambah = false"
                            aria-label="Tutup modal"
                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-ivory text-charcoal/60 hover:text-charcoal cursor-pointer"
                        >
                            &times;
                        </button>
                    </div>

                    <div class="grid grid-cols-3 rounded-lg bg-ivory p-1 ring-1 ring-champagne/25 gap-1">
                        <button
                            type="button"
                            @click="modeTambah = 'satuan'"
                            :class="modeTambah === 'satuan' ? 'bg-white text-sage shadow-xs' : 'text-charcoal/65 hover:text-charcoal'"
                            class="rounded-md py-2 text-xs font-semibold transition cursor-pointer"
                        >
                            1 Tamu
                        </button>
                        <button
                            type="button"
                            @click="modeTambah = 'massal'"
                            :class="modeTambah === 'massal' ? 'bg-white text-sage shadow-xs' : 'text-charcoal/65 hover:text-charcoal'"
                            class="rounded-md py-2 text-xs font-semibold transition cursor-pointer"
                        >
                            Import Banyak
                        </button>
                        <button
                            type="button"
                            @click="modeTambah = 'csv'"
                            :class="modeTambah === 'csv' ? 'bg-white text-sage shadow-xs' : 'text-charcoal/65 hover:text-charcoal'"
                            class="rounded-md py-2 text-xs font-semibold transition cursor-pointer"
                        >
                            Import CSV
                        </button>
                    </div>

                    {{-- Form 1 Tamu --}}
                    <form
                        x-show="modeTambah === 'satuan'"
                        action="{{ route('dashboard.tamu.simpan', $undangan) }}"
                        method="POST"
                        class="space-y-4"
                        data-swal-loading
                        data-swal-loading-title="Menyimpan Tamu..."
                        data-swal-loading-text="Menambahkan tamu ke daftar undangan..."
                    >
                        @csrf
                        <input type="hidden" name="mode" value="satuan">
                        <div>
                            <label for="modal_nama_tamu" class="block text-xs font-semibold text-charcoal/80 mb-1">
                                Nama Tamu <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="modal_nama_tamu"
                                type="text"
                                name="nama_tamu"
                                value="{{ old('mode') === 'satuan' ? old('nama_tamu') : '' }}"
                                required
                                maxlength="120"
                                placeholder="Contoh: Budi Santoso / Keluarga Bpk. Hendra"
                                class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2.5 text-sm text-charcoal focus:border-sage focus:bg-white focus:outline-none"
                            >
                        </div>
                        <div>
                            <label for="modal_nomor_wa" class="block text-xs font-semibold text-charcoal/80 mb-1">
                                Nomor WhatsApp <span class="font-normal text-charcoal/50">(Opsional)</span>
                            </label>
                            <input
                                id="modal_nomor_wa"
                                type="tel"
                                inputmode="tel"
                                name="nomor_wa"
                                value="{{ old('mode') === 'satuan' ? old('nomor_wa') : '' }}"
                                maxlength="30"
                                placeholder="Contoh: 081234567890"
                                class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2.5 text-sm text-charcoal focus:border-sage focus:bg-white focus:outline-none"
                            >
                            <p class="mt-1.5 text-[11px] text-charcoal/55">
                                Diisi &rarr; klik Kirim WA langsung membuka chat tamu. Kosong &rarr; pilih kontak di WhatsApp.
                            </p>
                        </div>
                        <div class="flex items-center justify-end gap-2 pt-1">
                            <button type="button" @click="modalTambah = false" class="rounded-lg border border-charcoal/20 bg-charcoal/[0.06] px-4 py-2.5 text-xs sm:text-sm font-semibold text-charcoal/85 hover:bg-charcoal/[0.11] hover:border-charcoal/30 active:scale-[0.98] transition cursor-pointer">
                                Batal
                            </button>
                            <button type="submit" class="rounded-lg bg-sage px-5 py-2.5 text-xs sm:text-sm font-semibold text-white hover:bg-[#3b5047] active:scale-[0.98] transition cursor-pointer">
                                Simpan Tamu
                            </button>
                        </div>
                    </form>

                    {{-- Form Import Banyak --}}
                    <form
                        x-show="modeTambah === 'massal'"
                        x-cloak
                        action="{{ route('dashboard.tamu.simpan', $undangan) }}"
                        method="POST"
                        @submit="cekKirimDaftarBulk($event)"
                        class="space-y-3.5"
                        data-swal-loading
                        data-swal-loading-title="Menyimpan Daftar Tamu..."
                        data-swal-loading-text="Menambahkan semua tamu ke daftar undangan..."
                    >
                        @csrf
                        <input type="hidden" name="mode" value="massal">
                        <div class="space-y-2">
                            <label for="modal_daftar_bulk" class="block text-xs font-semibold text-charcoal/80">
                                Daftar Tamu (1 tamu per baris)
                            </label>
                            <textarea
                                id="modal_daftar_bulk"
                                name="daftar_bulk"
                                x-model="daftarBulkTeks"
                                rows="5"
                                required
                                placeholder="Budi Santoso, 081234567890&#10;Siti Aminah &amp; Partner, 085612345678&#10;Keluarga Bpk. Hendra"
                                :class="analisisDaftarBulk().galat.length > 0
                                    ? 'border-rose-400 bg-rose-50/40 focus:border-rose-500'
                                    : 'border-charcoal/15 bg-ivory/60 focus:border-sage focus:bg-white'"
                                class="w-full rounded-lg border px-3.5 py-2.5 text-sm font-mono text-charcoal focus:outline-none transition"
                            >{{ old('mode') === 'massal' ? old('daftar_bulk') : '' }}</textarea>

                            {{-- Indikator Validasi Realtime: Siap Disimpan --}}
                            <div
                                x-show="analisisDaftarBulk().barisTerisi > 0 && analisisDaftarBulk().galat.length === 0"
                                x-cloak
                                class="rounded-lg border border-emerald-200 bg-emerald-50/80 px-3 py-2 text-[11.5px] font-medium text-emerald-800 flex items-center gap-2"
                            >
                                <svg class="h-4 w-4 text-emerald-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M20 6 9 17l-5-5"/>
                                </svg>
                                <span>
                                    <strong x-text="analisisDaftarBulk().validCount + ' tamu'"></strong> siap disimpan
                                    <span
                                        x-show="analisisDaftarBulk().denganWaCount > 0 && analisisDaftarBulk().tanpaWaCount === 0"
                                        class="text-emerald-700/85"
                                    >&bull; sudah dilengkapi nomor WA</span>
                                    <span
                                        x-show="analisisDaftarBulk().denganWaCount === 0 && analisisDaftarBulk().tanpaWaCount > 0"
                                        class="text-emerald-700/85"
                                    >&bull; tanpa nomor WA</span>
                                    <span
                                        x-show="analisisDaftarBulk().denganWaCount > 0 && analisisDaftarBulk().tanpaWaCount > 0"
                                        class="text-emerald-700/85"
                                        x-text="'• ' + analisisDaftarBulk().denganWaCount + ' dengan nomor WA, ' + analisisDaftarBulk().tanpaWaCount + ' tanpa nomor WA'"
                                    ></span>
                                </span>
                            </div>

                            {{-- Peringatan Validasi Realtime (Salah Ketik Titik / Tanpa Koma / Nomor WA Tidak Valid) --}}
                            <div
                                x-show="analisisDaftarBulk().galat.length > 0"
                                x-cloak
                                class="rounded-lg border border-rose-200 bg-rose-50/85 p-3 space-y-2"
                            >
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <p class="text-xs font-bold text-rose-700" x-text="'Periksa format penulisan (' + analisisDaftarBulk().galat.length + ' baris)'"></p>
                                    <button
                                        type="button"
                                        x-show="analisisDaftarBulk().bisaDiperbaikiOtomatis"
                                        @click="perbaikiFormatBulkOtomatis()"
                                        class="inline-flex items-center gap-1 rounded-md bg-rose-600 px-2.5 py-1 text-[11px] font-semibold text-white hover:bg-rose-700 active:scale-95 transition cursor-pointer"
                                    >
                                        Perbaiki Otomatis ke Koma (,)
                                    </button>
                                </div>
                                <ul class="space-y-1 text-[11.5px] leading-snug text-rose-800 max-h-28 overflow-y-auto pr-1">
                                    <template x-for="err in analisisDaftarBulk().galat.slice(0, 5)" :key="err.baris + '-' + err.pesan">
                                        <li class="flex items-start gap-1.5">
                                            <span class="font-bold shrink-0" x-text="'Baris ' + err.baris + ':'"></span>
                                            <span class="break-words" x-text="err.pesan"></span>
                                        </li>
                                    </template>
                                    <li x-show="analisisDaftarBulk().galat.length > 5" class="font-semibold text-rose-700" x-text="'...dan ' + (analisisDaftarBulk().galat.length - 5) + ' baris lainnya.'"></li>
                                </ul>
                            </div>

                            @error('daftar_bulk')
                                <p class="rounded-lg border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-medium text-rose-700">{{ $message }}</p>
                            @enderror

                            <p class="text-[11px] text-charcoal/55 leading-relaxed">
                                Pisahkan nama &amp; nomor WA dengan <strong class="text-charcoal/80">koma (,)</strong> — bukan titik (.). Contoh: <code class="font-mono text-charcoal/75">Budi Santoso, 081234567890</code>. Nomor WA opsional, maks. 200 baris.
                            </p>
                        </div>
                        <div class="flex items-center justify-end gap-2 pt-1">
                            <button type="button" @click="modalTambah = false" class="rounded-lg border border-charcoal/20 bg-charcoal/[0.06] px-4 py-2.5 text-xs sm:text-sm font-semibold text-charcoal/85 hover:bg-charcoal/[0.11] hover:border-charcoal/30 active:scale-[0.98] transition cursor-pointer">
                                Batal
                            </button>
                            <button
                                type="submit"
                                :disabled="analisisDaftarBulk().galat.length > 0"
                                class="rounded-lg bg-sage px-5 py-2.5 text-xs sm:text-sm font-semibold text-white hover:bg-[#3b5047] active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed transition cursor-pointer"
                            >
                                Simpan Daftar Tamu
                            </button>
                        </div>
                    </form>

                    {{-- Form Import CSV --}}
                    <form
                        x-show="modeTambah === 'csv'"
                        x-cloak
                        action="{{ route('dashboard.tamu.simpan', $undangan) }}"
                        method="POST"
                        enctype="multipart/form-data"
                        @submit="if (!$refs.inputFileCsv?.files?.length) { $event.preventDefault(); pesanGalatCsv = 'Silakan pilih file CSV terlebih dahulu.'; }"
                        class="space-y-4"
                        data-swal-loading
                        data-swal-loading-title="Mengimpor File CSV..."
                        data-swal-loading-text="Membaca daftar tamu dari file CSV Anda..."
                    >
                        @csrf
                        <input type="hidden" name="mode" value="csv">

                        <div class="space-y-2.5">
                            <div class="flex items-center justify-between gap-2">
                                <label for="modal_file_csv" class="block text-xs font-semibold text-charcoal/80">
                                    Unggah File CSV <span class="text-red-500">*</span>
                                </label>
                                <a
                                    href="{{ route('dashboard.tamu.template-csv', $undangan) }}"
                                    class="inline-flex items-center gap-1 text-[11px] font-semibold text-sage hover:underline"
                                >
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                        <polyline points="7 10 12 15 17 10"/>
                                        <line x1="12" x2="12" y1="15" y2="3"/>
                                    </svg>
                                    <span>Unduh Contoh CSV</span>
                                </a>
                            </div>

                            <input
                                id="modal_file_csv"
                                x-ref="inputFileCsv"
                                type="file"
                                name="file_csv"
                                accept=".csv,.txt,text/csv"
                                @change="pilihFileCsv($event)"
                                class="sr-only"
                            >

                            <label
                                for="modal_file_csv"
                                @dragover.prevent="sedangTarikCsv = true"
                                @dragleave.prevent="sedangTarikCsv = false"
                                @drop.prevent="jatuhFileCsv($event)"
                                :class="sedangTarikCsv ? 'border-sage bg-sage/[0.06] ring-4 ring-sage/10' : 'border-champagne/60 bg-ivory/60 hover:border-sage/60 hover:bg-ivory'"
                                class="flex flex-col items-center justify-center gap-2 rounded-xl border-2 border-dashed px-4 py-6 text-center cursor-pointer transition select-none"
                            >
                                <template x-if="!namaFileCsv">
                                    <div class="flex flex-col items-center gap-2">
                                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-sage/10 text-sage">
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                                <polyline points="14 2 14 8 20 8"/>
                                                <line x1="12" x2="12" y1="18" y2="12"/>
                                                <polyline points="9 15 12 12 15 15"/>
                                            </svg>
                                        </span>
                                        <div>
                                            <p class="text-xs font-semibold text-charcoal">Pilih atau Seret File CSV ke Sini</p>
                                            <p class="mt-0.5 text-[11px] text-charcoal/55">Format .csv (maks. 2 MB &bull; hingga 500 tamu)</p>
                                        </div>
                                        <span class="rounded-lg bg-sage/10 px-3 py-1 text-[11px] font-semibold text-sage">Pilih File CSV</span>
                                    </div>
                                </template>

                                <template x-if="namaFileCsv">
                                    <div class="w-full flex items-center justify-between gap-3 text-left">
                                        <div class="flex items-center gap-2.5 min-w-0">
                                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-sage text-white text-[10px] font-bold shrink-0">CSV</span>
                                            <div class="min-w-0">
                                                <p class="text-xs font-bold text-charcoal truncate" x-text="namaFileCsv"></p>
                                                <p class="text-[11px] text-charcoal/60">
                                                    <span x-text="ukuranFileCsv"></span>
                                                    <span x-show="jumlahBarisCsv !== null" x-text="' • Terdeteksi ~' + jumlahBarisCsv + ' tamu'"></span>
                                                </p>
                                            </div>
                                        </div>
                                        <button
                                            type="button"
                                            @click.prevent.stop="hapusFileCsv()"
                                            class="rounded-lg bg-rose-50 px-2.5 py-1 text-[11px] font-semibold text-rose-700 hover:bg-rose-100 shrink-0 cursor-pointer"
                                        >
                                            Hapus
                                        </button>
                                    </div>
                                </template>
                            </label>

                            <p x-show="pesanGalatCsv" x-cloak x-text="pesanGalatCsv" class="text-xs font-medium text-rose-600"></p>
                            @error('file_csv')
                                <p class="text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror

                            <div class="rounded-xl bg-ivory/80 px-3 py-2.5 ring-1 ring-champagne/25 text-[11px] leading-relaxed text-charcoal/65">
                                Kolom CSV: <strong class="text-charcoal">Nama Tamu, Nomor WhatsApp</strong> (nomor WA opsional). Mendukung pemisah koma (<code>,</code>) maupun titik koma (<code>;</code>) dari Microsoft Excel atau Google Sheets.
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-2 pt-1">
                            <button type="button" @click="modalTambah = false" class="rounded-lg border border-charcoal/20 bg-charcoal/[0.06] px-4 py-2.5 text-xs sm:text-sm font-semibold text-charcoal/85 hover:bg-charcoal/[0.11] hover:border-charcoal/30 active:scale-[0.98] transition cursor-pointer">
                                Batal
                            </button>
                            <button type="submit" class="rounded-lg bg-sage px-5 py-2.5 text-xs sm:text-sm font-semibold text-white hover:bg-[#3b5047] active:scale-[0.98] transition cursor-pointer">
                                Impor CSV
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- MODAL EDIT TAMU --}}
            <div
                x-show="modalEdit"
                x-cloak
                x-transition.opacity
                class="fixed inset-0 z-50 bg-charcoal/50 backdrop-blur-xs flex items-center justify-center p-3 sm:p-4"
            >
                <div
                    @click.away="if (!window.Swal?.isVisible() && !$event.target?.closest('.swal2-container')) tutupModalEdit()"
                    class="w-full max-w-md max-h-[90dvh] overflow-y-auto rounded-xl bg-white p-5 sm:p-6 shadow-2xl ring-1 ring-champagne/30 space-y-4"
                >
                    <div class="flex items-center justify-between gap-3">
                        <h2 class="font-sans text-lg font-bold text-charcoal tracking-tight">Edit Data Tamu</h2>
                        <button
                            type="button"
                            @click="tutupModalEdit()"
                            aria-label="Tutup modal edit"
                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-ivory text-charcoal/60 hover:text-charcoal cursor-pointer"
                        >
                            &times;
                        </button>
                    </div>

                    <div class="space-y-3.5">
                        <div>
                            <label class="block text-xs font-semibold text-charcoal/80 mb-1">Nama Tamu <span class="text-red-500">*</span></label>
                            <input
                                type="text"
                                x-model="editNama"
                                maxlength="120"
                                @keydown.enter.prevent="simpanEdit()"
                                class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2.5 text-sm text-charcoal focus:border-sage focus:bg-white focus:outline-none"
                            >
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-charcoal/80 mb-1">Nomor WhatsApp <span class="font-normal text-charcoal/50">(Opsional)</span></label>
                            <input
                                type="tel"
                                inputmode="tel"
                                x-model="editWa"
                                maxlength="30"
                                placeholder="Contoh: 081234567890"
                                @keydown.enter.prevent="simpanEdit()"
                                class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2.5 text-sm text-charcoal focus:border-sage focus:bg-white focus:outline-none"
                            >
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-1">
                        <button type="button" @click="tutupModalEdit()" class="rounded-lg border border-charcoal/20 bg-charcoal/[0.06] px-4 py-2.5 text-xs sm:text-sm font-semibold text-charcoal/85 hover:bg-charcoal/[0.11] hover:border-charcoal/30 active:scale-[0.98] transition cursor-pointer">
                            Batal
                        </button>
                        <button
                            type="button"
                            @click="simpanEdit()"
                            :disabled="sedangSimpanEdit"
                            class="rounded-lg bg-sage px-5 py-2.5 text-xs sm:text-sm font-semibold text-white hover:bg-[#3b5047] active:scale-[0.98] transition disabled:opacity-60 cursor-pointer"
                            x-text="sedangSimpanEdit ? 'Menyimpan...' : 'Simpan Perubahan'"
                        ></button>
                    </div>
                </div>
            </div>

            {{-- MODAL TEMPLATE PESAN WHATSAPP --}}
            <div
                x-show="modalTemplatePesan"
                x-cloak
                x-transition.opacity
                class="fixed inset-0 z-50 bg-charcoal/50 backdrop-blur-xs flex items-center justify-center p-3 sm:p-4"
            >
                <div
                    @click.away="if (!window.Swal?.isVisible() && !$event.target?.closest('.swal2-container')) tutupModalTemplatePesan()"
                    class="w-full max-w-xl max-h-[90dvh] rounded-xl bg-white shadow-2xl ring-1 ring-champagne/30 flex flex-col overflow-hidden"
                >
                    {{-- Header Modal --}}
                    <div class="px-5 sm:px-6 pt-5 pb-3.5 border-b border-champagne/20 flex items-start justify-between gap-3 shrink-0">
                        <div class="min-w-0">
                            <h2 class="font-sans text-lg font-bold text-charcoal tracking-tight">Template Pesan</h2>
                            <p class="mt-0.5 text-xs text-charcoal/60 leading-relaxed">
                                Pesan ini akan dipakai saat Anda mengirim undangan ke tamu melalui WhatsApp.
                            </p>
                        </div>
                        <button
                            type="button"
                            @click="tutupModalTemplatePesan()"
                            aria-label="Tutup modal template pesan"
                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-ivory text-charcoal/60 hover:text-charcoal cursor-pointer shrink-0"
                        >
                            &times;
                        </button>
                    </div>

                    {{-- Body Scrollable Modal --}}
                    <div class="flex-1 min-h-0 overflow-y-auto px-5 sm:px-6 py-4 space-y-4">
                        {{-- Pilih Preset --}}
                        <div class="space-y-1.5 relative" @click.away="dropdownPresetTerbuka = false">
                            <label class="block text-xs font-semibold text-charcoal/80">Pilih Preset</label>
                            <button
                                type="button"
                                @click="dropdownPresetTerbuka = !dropdownPresetTerbuka"
                                class="w-full flex items-center justify-between gap-2 rounded-lg border border-champagne/40 bg-ivory/60 px-3.5 py-2.5 text-sm font-medium text-charcoal hover:border-sage/50 focus:border-sage focus:bg-white focus:outline-none transition cursor-pointer"
                            >
                                <span x-text="labelPresetAktif()" class="truncate"></span>
                                <svg
                                    :class="dropdownPresetTerbuka ? 'rotate-180 text-sage' : 'text-charcoal/45'"
                                    class="h-4 w-4 shrink-0 transition-transform"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                                >
                                    <path d="m6 9 6 6 6-6"/>
                                </svg>
                            </button>

                            <div
                                x-show="dropdownPresetTerbuka"
                                x-cloak
                                x-transition.opacity.duration.120ms
                                class="absolute left-0 right-0 top-full mt-1.5 z-30 rounded-xl bg-white p-1.5 shadow-xl ring-1 ring-champagne/30 max-h-64 overflow-y-auto"
                            >
                                <template x-for="preset in daftarPresetPesan" :key="preset.kode">
                                    <button
                                        type="button"
                                        @click="pilihPresetPesan(preset)"
                                        :class="presetPesanTerpilih === preset.kode ? 'bg-sage/10 text-sage font-semibold' : 'text-charcoal/85 hover:bg-ivory'"
                                        class="w-full flex items-center justify-between gap-2 rounded-lg px-3 py-2 text-left text-sm transition cursor-pointer"
                                    >
                                        <span x-text="preset.label"></span>
                                        <svg
                                            x-show="presetPesanTerpilih === preset.kode"
                                            class="h-4 w-4 text-sage shrink-0"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                                        >
                                            <polyline points="20 6 9 17 4 12"/>
                                        </svg>
                                    </button>
                                </template>
                            </div>
                        </div>

                        {{-- Kartu Panduan 2 Kode Wajib --}}
                        <div class="rounded-xl bg-ivory/80 p-3.5 ring-1 ring-champagne/30 space-y-2.5">
                            <div class="flex items-start gap-2">
                                <span class="mt-0.5 inline-flex h-4 w-4 items-center justify-center rounded-full border border-charcoal/40 text-[10px] font-bold text-charcoal/70 shrink-0" aria-hidden="true">i</span>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-charcoal">Wajib ada 2 kode ini</p>
                                    <p class="mt-0.5 text-[11px] leading-relaxed text-charcoal/65">
                                        Gunakan <code class="font-semibold text-charcoal">{nama}</code> untuk nama tamu dan <code class="font-semibold text-charcoal">{link}</code> untuk link undangan. Jangan hapus atau ubah penulisannya.
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <button
                                    type="button"
                                    @click="sisipkanKodeTemplate('{nama}')"
                                    title="Klik untuk sisipkan {nama} ke pesan"
                                    :class="templateMemilikiNama() ? 'ring-emerald-200/80 bg-white' : 'ring-rose-300 bg-rose-50/60'"
                                    class="rounded-xl p-2.5 text-left ring-1 hover:ring-sage/50 transition cursor-pointer"
                                >
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="font-mono text-xs font-bold text-charcoal">{nama}</span>
                                        <span
                                            :class="templateMemilikiNama() ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-100 text-rose-700'"
                                            class="rounded-full px-2 py-0.5 text-[10px] font-semibold"
                                            x-text="templateMemilikiNama() ? '✓ Ada' : 'Wajib ada'"
                                        ></span>
                                    </div>
                                    <p class="mt-1 text-[11px] leading-snug text-charcoal/60">
                                        Diganti otomatis dengan nama tamu yang dikirimi pesan.
                                    </p>
                                </button>

                                <button
                                    type="button"
                                    @click="sisipkanKodeTemplate('{link}')"
                                    title="Klik untuk sisipkan {link} ke pesan"
                                    :class="templateMemilikiLink() ? 'ring-emerald-200/80 bg-white' : 'ring-rose-300 bg-rose-50/60'"
                                    class="rounded-xl p-2.5 text-left ring-1 hover:ring-sage/50 transition cursor-pointer"
                                >
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="font-mono text-xs font-bold text-charcoal">{link}</span>
                                        <span
                                            :class="templateMemilikiLink() ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-100 text-rose-700'"
                                            class="rounded-full px-2 py-0.5 text-[10px] font-semibold"
                                            x-text="templateMemilikiLink() ? '✓ Ada' : 'Wajib ada'"
                                        ></span>
                                    </div>
                                    <p class="mt-1 text-[11px] leading-snug text-charcoal/60">
                                        Diganti otomatis dengan link undangan khusus tamu tersebut.
                                    </p>
                                </button>
                            </div>

                            <p class="text-[11px] text-charcoal/55">
                                Contoh: Halo <span class="font-medium text-charcoal/80">{nama}</span>, silakan buka <span class="font-medium text-charcoal/80">{link}</span>
                            </p>
                        </div>

                        {{-- Toolbar Format WhatsApp + Editor Pesan --}}
                        <div class="space-y-2">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <div class="inline-flex items-center gap-1.5">
                                    <button
                                        type="button"
                                        @click="formatTeksTemplate('*')"
                                        title="Tebal (*teks*)"
                                        aria-label="Format tebal"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-champagne/40 bg-white text-xs font-bold text-charcoal hover:border-sage hover:text-sage transition cursor-pointer"
                                    >B</button>
                                    <button
                                        type="button"
                                        @click="formatTeksTemplate('_')"
                                        title="Miring (_teks_)"
                                        aria-label="Format miring"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-champagne/40 bg-white text-xs italic font-serif text-charcoal hover:border-sage hover:text-sage transition cursor-pointer"
                                    >I</button>
                                    <button
                                        type="button"
                                        @click="formatTeksTemplate('~')"
                                        title="Coret (~teks~)"
                                        aria-label="Format coret"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-champagne/40 bg-white text-xs line-through text-charcoal hover:border-sage hover:text-sage transition cursor-pointer"
                                    >S</button>
                                </div>

                                <span class="font-sans tabular-nums text-[11px] text-charcoal/50" x-text="(draftTemplatePesan || '').length + '/2500'"></span>
                            </div>

                            <textarea
                                x-ref="textareaTemplatePesan"
                                x-model="draftTemplatePesan"
                                @input="presetPesanTerpilih = deteksiPresetDariTeks(draftTemplatePesan); pesanGalatTemplate = ''"
                                rows="9"
                                maxlength="2500"
                                placeholder="Tulis pesan undangan Anda di sini... Pastikan ada {nama} dan {link}."
                                class="w-full rounded-xl border border-champagne/40 bg-ivory/50 px-3.5 py-3 text-sm leading-relaxed text-charcoal focus:border-sage focus:bg-white focus:outline-none transition"
                            ></textarea>

                            <p x-show="pesanGalatTemplate" x-cloak x-text="pesanGalatTemplate" class="text-xs font-medium text-rose-600"></p>
                        </div>

                        {{-- Preview WhatsApp --}}
                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-xs font-semibold text-charcoal/75">Preview WhatsApp</span>
                                <span class="text-[11px] text-charcoal/50" x-text="'Contoh: ' + (daftarTamu[0]?.nama_tamu || 'Budi & Keluarga')"></span>
                            </div>
                            <div class="rounded-xl bg-[#EFEAE2] p-3.5 sm:p-4 ring-1 ring-champagne/25">
                                <div class="ml-auto max-w-[95%] rounded-xl rounded-tr-xs bg-[#D9FDD3] px-3.5 py-2.5 text-[13px] leading-relaxed text-[#111B21] shadow-xs">
                                    <div class="break-words" x-html="renderPreviewWaHtml()"></div>
                                    <div class="mt-1.5 flex items-center justify-end gap-1 text-[10px] text-[#667781] tabular-nums">
                                        <span x-text="waktuPreviewWa()"></span>
                                        <svg class="h-3.5 w-3.5 text-[#53BDEB]" viewBox="0 0 18 12" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M1 6.5 4.2 9.7 11.5 2"/>
                                            <path d="M6.2 9.7 13.5 2"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer Sticky Modal --}}
                    <div class="px-5 sm:px-6 py-3.5 border-t border-champagne/20 bg-white flex flex-wrap items-center justify-between gap-2 shrink-0">
                        <button
                            type="button"
                            @click="resetTemplateBawaan()"
                            class="text-xs font-semibold text-charcoal/60 hover:text-sage transition cursor-pointer"
                        >
                            Reset Bawaan
                        </button>
                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                @click="tutupModalTemplatePesan()"
                                class="rounded-lg border border-charcoal/20 bg-charcoal/[0.06] px-4 py-2.5 text-xs sm:text-sm font-semibold text-charcoal/85 hover:bg-charcoal/[0.11] hover:border-charcoal/30 active:scale-[0.98] transition cursor-pointer"
                            >
                                Batal
                            </button>
                            <button
                                type="button"
                                @click="simpanTemplatePesan()"
                                :disabled="sedangSimpanTemplatePesan || !templatePesanValid()"
                                class="rounded-lg bg-sage px-5 py-2.5 text-xs sm:text-sm font-semibold text-white hover:bg-[#3b5047] disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer transition"
                                x-text="sedangSimpanTemplatePesan ? 'Menyimpan...' : 'Simpan Template'"
                            ></button>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </main>
        </div>
    </div>
@endsection
