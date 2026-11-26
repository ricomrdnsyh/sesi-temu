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

        $bukaModalTambahAwal = $errors->hasAny(['nama_tamu', 'nomor_wa', 'daftar_bulk']);
        $modeTambahAwal = old('mode', $errors->has('daftar_bulk') ? 'massal' : 'satuan');
    @endphp

    <div
        x-data="{
            urlPublikUndangan: @js($urlPublik),
            namaPria: @js($undangan->nama_panggilan_pria),
            namaWanita: @js($undangan->nama_panggilan_wanita),
            siapDisebarUndangan: @js($undanganSiapDisebar),
            csrfToken: @js(csrf_token()),
            daftarTamu: @js($daftarTamuJson),
            tamuMap: {},
            filterStatus: 'semua',
            menuTamu: null,
            menuStyle: { top: '0px', right: '16px', bottom: 'auto' },
            modalTambah: @js($bukaModalTambahAwal),
            modeTambah: @js($modeTambahAwal),
            modalEdit: false,
            tamuDiedit: null,
            editNama: '',
            editWa: '',
            sedangSimpanEdit: false,
            init() {
                const peta = {};
                this.daftarTamu.forEach((item) => {
                    this.lengkapiDataTamu(item);
                    peta[item.id] = item;
                });
                this.tamuMap = peta;

                if (window.DataTable && !window.__sesiTemuTamuFilterTerdaftar) {
                    window.__sesiTemuTamuFilterTerdaftar = true;
                    window.DataTable.ext.search.push((settings, data, dataIndex) => {
                        const tabelEl = document.getElementById('tabel-daftar-tamu');
                        if (!tabelEl || settings.nTable !== tabelEl) return true;
                        const statusFilter = tabelEl.__sesiTemuFilterStatus || 'semua';
                        if (statusFilter === 'semua') return true;
                        const rowNode = settings.aoData?.[dataIndex]?.nTr;
                        const id = Number(rowNode?.dataset?.tamuRow || 0);
                        const getter = tabelEl.__sesiTemuGetTamu;
                        const item = typeof getter === 'function' ? getter(id) : null;
                        if (!item) return true;
                        if (statusFilter === 'belum_dikirim') return !item.sudah_dikirim;
                        if (statusFilter === 'sudah_dikirim') return item.sudah_dikirim;
                        if (statusFilter === 'sudah_dibuka') return item.sudah_dibuka;
                        return true;
                    });
                }

                this.$nextTick(() => {
                    const tabelEl = document.getElementById('tabel-daftar-tamu');
                    if (tabelEl) {
                        tabelEl.__sesiTemuFilterStatus = this.filterStatus;
                        tabelEl.__sesiTemuGetTamu = (id) => this.tamuMap[id] || null;
                    }
                });
            },
            tamuById(id) {
                return this.tamuMap[id] ?? this.daftarTamu.find((item) => item.id === id) ?? {};
            },
            inisialNama(nama) {
                const bagian = String(nama || '').trim().split(/\s+/).filter(Boolean);
                if (bagian.length === 0) return 'TM';
                if (bagian.length === 1) return bagian[0].slice(0, 2).toUpperCase();
                return (bagian[0][0] + bagian[bagian.length - 1][0]).toUpperCase();
            },
            persenDibuka() {
                if (this.daftarTamu.length === 0) return 0;
                return Math.round((this.stat().sudahDibuka / this.daftarTamu.length) * 100);
            },
            setFilterStatus(status) {
                this.filterStatus = status;
                this.menuTamu = null;
                const tabelEl = document.getElementById('tabel-daftar-tamu');
                if (tabelEl) {
                    tabelEl.__sesiTemuFilterStatus = status;
                    tabelEl._sesiTemuDt?.draw();
                }
            },
            segarBarisTabel(id) {
                this.$nextTick(() => {
                    const dt = document.getElementById('tabel-daftar-tamu')?._sesiTemuDt;
                    const row = dt?.row(`[data-tamu-row=&quot;${id}&quot;]`);
                    if (row?.node()) {
                        row.invalidate('dom').draw(false);
                    }
                });
            },
            formatNomorWaTampil(nomor) {
                const bersih = String(nomor || '').replace(/\D+/g, '');
                if (!bersih) return '';
                if (bersih.startsWith('62') && bersih.length >= 10) {
                    const lokal = bersih.slice(2);
                    return '+62 ' + lokal.replace(/(\d{3})(\d{4})(\d+)/, '$1-$2-$3');
                }
                return '+' + bersih;
            },
            lengkapiDataTamu(item) {
                const urlTamu = `${this.urlPublikUndangan}?to=${encodeURIComponent(item.nama_tamu)}&g=${encodeURIComponent(item.kode_tamu)}`;
                const pesan = `Kepada Yth. ${item.nama_tamu},\n\nTanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pernikahan kami:\n\n*${this.namaPria} & ${this.namaWanita}*\n\nInformasi lengkap acara dapat diakses melalui tautan berikut:\n${urlTamu}\n\nMerupakan suatu kehormatan apabila Anda berkenan hadir dan memberikan doa restu.`;

                item.urlTamu = urlTamu;
                item.pesan = this.siapDisebarUndangan ? pesan : '';
                item.waUrl = this.siapDisebarUndangan
                    ? (item.nomor_wa
                        ? `https://wa.me/${item.nomor_wa}?text=${encodeURIComponent(pesan)}`
                        : `https://wa.me/?text=${encodeURIComponent(pesan)}`)
                    : '#';
                item.nomorWaTampil = this.formatNomorWaTampil(item.nomor_wa);
                return item;
            },
            stat() {
                const total = this.daftarTamu.length;
                let sudahDikirim = 0;
                let sudahDibuka = 0;

                for (const item of this.daftarTamu) {
                    if (item.sudah_dikirim) sudahDikirim++;
                    if (item.sudah_dibuka) sudahDibuka++;
                }

                return {
                    total,
                    belumDikirim: total - sudahDikirim,
                    sudahDikirim,
                    sudahDibuka,
                };
            },
            bukaModalTambah(mode) {
                this.menuTamu = null;
                this.modeTambah = mode || 'satuan';
                this.modalTambah = true;
            },
            toggleMenu(tamu, event) {
                if (this.menuTamu?.id === tamu.id) {
                    this.menuTamu = null;
                    return;
                }
                const rect = event?.currentTarget?.getBoundingClientRect();
                if (rect) {
                    const bukaAtas = (window.innerHeight - rect.bottom) < 220;
                    this.menuStyle = {
                        right: Math.max(12, window.innerWidth - rect.right) + 'px',
                        top: bukaAtas ? 'auto' : (rect.bottom + 6) + 'px',
                        bottom: bukaAtas ? (window.innerHeight - rect.top + 6) + 'px' : 'auto',
                    };
                }
                this.menuTamu = tamu;
            },
            async setStatusKirim(tamu, terkirim) {
                if (!tamu || tamu.sedang_proses_kirim) return;
                const statusSebelumnya = tamu.sudah_dikirim;
                const labelSebelumnya = tamu.dikirim_pada_label;

                tamu.sedang_proses_kirim = true;
                tamu.sudah_dikirim = terkirim;
                if (!terkirim) {
                    tamu.dikirim_pada_label = null;
                }

                try {
                    const token = document.querySelector('meta[name=csrf-token]')?.content || this.csrfToken;
                    const res = await fetch(tamu.url_status_kirim, {
                        method: 'PATCH',
                        keepalive: true,
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token,
                        },
                        body: JSON.stringify({ terkirim }),
                    });

                    if (!res.ok) {
                        throw new Error('Gagal memperbarui status');
                    }

                    const data = await res.json();
                    tamu.sudah_dikirim = Boolean(data.sudah_dikirim);
                    tamu.dikirim_pada_label = data.dikirim_pada_label || null;
                    this.segarBarisTabel(tamu.id);
                } catch {
                    tamu.sudah_dikirim = statusSebelumnya;
                    tamu.dikirim_pada_label = labelSebelumnya;
                } finally {
                    tamu.sedang_proses_kirim = false;
                }
            },
            tandaiKirimSaatKlikWa(tamu) {
                if (!this.siapDisebarUndangan || tamu.sudah_dikirim) return;
                this.setStatusKirim(tamu, true);
            },
            salinPesan(tamu) {
                if (!this.siapDisebarUndangan || !tamu.pesan) return;
                navigator.clipboard?.writeText(tamu.pesan);
                tamu.tersalin = true;
                setTimeout(() => { tamu.tersalin = false; }, 1800);
                if (!tamu.sudah_dikirim) {
                    this.setStatusKirim(tamu, true);
                }
            },
            salinLinkSaja(tamu) {
                this.menuTamu = null;
                if (!tamu?.urlTamu) return;
                navigator.clipboard?.writeText(tamu.urlTamu);
                window.Swal?.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Link personal disalin',
                    showConfirmButton: false,
                    timer: 1800,
                });
            },
            bukaModalEdit(tamu) {
                this.menuTamu = null;
                this.tamuDiedit = tamu;
                this.editNama = tamu.nama_tamu || '';
                this.editWa = tamu.nomor_wa || '';
                this.modalEdit = true;
            },
            tutupModalEdit() {
                this.modalEdit = false;
                this.tamuDiedit = null;
                this.editNama = '';
                this.editWa = '';
            },
            async simpanEdit() {
                if (this.sedangSimpanEdit || !this.tamuDiedit) return;
                const namaBaru = (this.editNama || '').trim();
                if (!namaBaru) {
                    window.Swal?.fire({
                        icon: 'warning',
                        title: 'Nama Tamu Kosong',
                        text: 'Nama tamu wajib diisi.',
                        confirmButtonText: 'Mengerti',
                        confirmButtonColor: '#4B6358',
                    });
                    return;
                }

                this.sedangSimpanEdit = true;
                try {
                    const token = document.querySelector('meta[name=csrf-token]')?.content || this.csrfToken;
                    const res = await fetch(this.tamuDiedit.url_perbarui, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token,
                        },
                        body: JSON.stringify({
                            nama_tamu: namaBaru,
                            nomor_wa: (this.editWa || '').trim(),
                        }),
                    });

                    const data = await res.json().catch(() => ({}));
                    if (!res.ok) {
                        window.Swal?.fire({
                            icon: 'error',
                            title: 'Periksa Data Tamu',
                            text: data?.pesan || data?.message || 'Gagal menyimpan perubahan data tamu.',
                            confirmButtonText: 'Mengerti',
                            confirmButtonColor: '#4B6358',
                        });
                        return;
                    }

                    const idEdited = this.tamuDiedit.id;
                    this.tamuDiedit.nama_tamu = data.tamu?.nama_tamu || namaBaru;
                    this.tamuDiedit.nomor_wa = data.tamu?.nomor_wa || null;
                    this.lengkapiDataTamu(this.tamuDiedit);
                    this.segarBarisTabel(idEdited);
                    this.tutupModalEdit();

                    window.Swal?.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Data tamu diperbarui',
                        showConfirmButton: false,
                        timer: 1800,
                    });
                } catch {
                    window.Swal?.fire({
                        icon: 'error',
                        title: 'Gangguan Koneksi',
                        text: 'Gagal menghubungi server. Silakan coba lagi.',
                        confirmButtonText: 'Mengerti',
                        confirmButtonColor: '#4B6358',
                    });
                } finally {
                    this.sedangSimpanEdit = false;
                }
            }
        }"
        @keydown.escape.window="if (!window.Swal?.isVisible()) { modalTambah = false; modalEdit = false; menuTamu = null; }"
        @scroll.window="menuTamu = null"
        class="min-h-screen flex bg-ivory"
    >
        {{-- Sidebar Vertikal Ramping Desktop + Bottom Bar Mobile --}}
        @include('dashboard._workspace-sidebar', [
            'undangan' => $undangan,
            'menuAktif' => 'tamu',
        ])

        <main class="flex-1 min-w-0">
            <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-10 pt-4 sm:pt-6 pb-28 lg:py-7 space-y-5">
            {{-- Hero Header Sage + Overlapping Stat Dock --}}
            <section>
                <div class="relative overflow-hidden rounded-[1.75rem] bg-gradient-to-br from-[#2B3F36] via-sage to-[#445B50] text-ivory px-5 sm:px-7 pt-5 pb-11 sm:pb-12 shadow-md ring-1 ring-sage/30">
                    <div aria-hidden="true" class="pointer-events-none absolute -right-12 -top-16 h-48 w-48 rounded-full bg-champagne/20 blur-2xl"></div>
                    <div aria-hidden="true" class="pointer-events-none absolute -left-10 -bottom-14 h-36 w-36 rounded-full bg-black/15 blur-2xl"></div>

                    <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                        <div class="space-y-1.5 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 text-xs text-ivory/70">
                                <a href="{{ auth()->user()->adalahAdmin() ? route('admin.undangan.index') : route('dashboard.index') }}" class="hover:text-white transition">Dashboard</a>
                                <span aria-hidden="true">&rsaquo;</span>
                                <a href="{{ route('dashboard.undangan.kelola', $undangan) }}" class="hover:text-white transition truncate">{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</a>
                                <span aria-hidden="true">&rsaquo;</span>
                                <span class="font-semibold text-[#F5E3B8]">Daftar Tamu</span>
                            </div>

                            <div class="flex flex-wrap items-center gap-2.5">
                                <h1 class="font-sans text-xl sm:text-2xl font-bold text-white tracking-tight">Daftar Tamu</h1>
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-white/12 backdrop-blur-xs px-2.5 py-0.5 text-[11px] font-semibold text-ivory ring-1 ring-white/20">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                    <span class="font-mono text-[#F5E3B8]">sesitemu.id/{{ $undangan->slug }}</span>
                                </span>
                            </div>

                            <p class="text-xs sm:text-sm text-ivory/80 max-w-2xl">
                                Kelola daftar tamu, kirim undangan personal ke chat WhatsApp, dan pantau siapa saja yang sudah membuka.
                            </p>
                        </div>

                        <div class="flex flex-wrap items-center gap-2 shrink-0">
                            <a
                                href="{{ route('dashboard.undangan.tamu', $undangan) }}"
                                title="Muat ulang status terbaru tamu yang sudah membuka undangan"
                                class="hidden sm:inline-flex items-center justify-center gap-1.5 rounded-xl bg-white/12 px-3 py-2.5 text-xs sm:text-sm font-semibold text-white ring-1 ring-white/20 hover:bg-white/20 active:scale-[0.98] transition"
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
                                class="hidden sm:inline-flex items-center justify-center gap-1.5 rounded-xl bg-white/12 px-3 py-2.5 text-xs sm:text-sm font-semibold text-white ring-1 ring-white/20 hover:bg-white/20 active:scale-[0.98] transition"
                            >
                                <svg class="h-4 w-4 text-[#F5E3B8] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                <span>Pratinjau</span>
                            </a>
                            <button
                                type="button"
                                @click="bukaModalTambah('massal')"
                                class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 rounded-xl bg-white px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-charcoal shadow-xs hover:bg-ivory active:scale-[0.98] transition cursor-pointer"
                            >
                                <svg class="h-4 w-4 text-sage shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                                    <rect x="8" y="2" width="8" height="4" rx="1" ry="1" />
                                </svg>
                                <span>Import Banyak</span>
                            </button>
                            <button
                                type="button"
                                @click="bukaModalTambah('satuan')"
                                class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 rounded-xl bg-champagne px-4 py-2.5 text-xs sm:text-sm font-bold text-charcoal shadow-sm hover:bg-[#d1b26d] active:scale-[0.98] transition cursor-pointer"
                            >
                                <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M12 5v14" />
                                    <path d="M5 12h14" />
                                </svg>
                                <span>Tambah Tamu</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Overlapping Interactive Stat Cards (Filter DataTable Sekaligus Ringkasan) --}}
                <div class="relative z-20 mx-2 sm:mx-5 -mt-6 sm:-mt-7 grid grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-3">
                    <button
                        type="button"
                        @click="setFilterStatus('semua')"
                        :class="filterStatus === 'semua' ? 'ring-2 ring-sage shadow-md' : 'ring-1 ring-champagne/30 hover:ring-champagne/65 shadow-sm'"
                        class="group rounded-2xl bg-white p-3.5 sm:p-4 text-left transition active:scale-[0.99] cursor-pointer flex items-center justify-between gap-3"
                    >
                        <div class="min-w-0">
                            <p class="text-[11px] font-semibold uppercase tracking-wider text-charcoal/55">Semua Tamu</p>
                            <p class="mt-1 font-sans tabular-nums text-xl sm:text-2xl font-bold text-charcoal leading-none" x-text="stat().total"></p>
                            <p class="mt-1 text-[11px] text-charcoal/50 truncate">Total terdaftar</p>
                        </div>
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-ivory text-charcoal/70 ring-1 ring-champagne/30 shrink-0 group-hover:scale-105 transition-transform">
                            <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        </span>
                    </button>

                    <button
                        type="button"
                        @click="setFilterStatus('belum_dikirim')"
                        :class="filterStatus === 'belum_dikirim' ? 'ring-2 ring-amber-500 shadow-md' : 'ring-1 ring-champagne/30 hover:ring-amber-300 shadow-sm'"
                        class="group rounded-2xl bg-white p-3.5 sm:p-4 text-left transition active:scale-[0.99] cursor-pointer flex items-center justify-between gap-3"
                    >
                        <div class="min-w-0">
                            <p class="text-[11px] font-semibold uppercase tracking-wider text-amber-800/75">Belum Dikirim</p>
                            <p class="mt-1 font-sans tabular-nums text-xl sm:text-2xl font-bold text-amber-700 leading-none" x-text="stat().belumDikirim"></p>
                            <p class="mt-1 text-[11px] text-charcoal/50 truncate">Menunggu disebar</p>
                        </div>
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-700 ring-1 ring-amber-200/70 shrink-0 group-hover:scale-105 transition-transform">
                            <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                        </span>
                    </button>

                    <button
                        type="button"
                        @click="setFilterStatus('sudah_dikirim')"
                        :class="filterStatus === 'sudah_dikirim' ? 'ring-2 ring-sage shadow-md' : 'ring-1 ring-champagne/30 hover:ring-sage/50 shadow-sm'"
                        class="group rounded-2xl bg-white p-3.5 sm:p-4 text-left transition active:scale-[0.99] cursor-pointer flex items-center justify-between gap-3"
                    >
                        <div class="min-w-0">
                            <p class="text-[11px] font-semibold uppercase tracking-wider text-sage/85">Terkirim</p>
                            <p class="mt-1 font-sans tabular-nums text-xl sm:text-2xl font-bold text-sage leading-none" x-text="stat().sudahDikirim"></p>
                            <p class="mt-1 text-[11px] text-charcoal/50 truncate">Sudah dikirim WA / salin</p>
                        </div>
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-sage/10 text-sage ring-1 ring-sage/20 shrink-0 group-hover:scale-105 transition-transform">
                            <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="m22 2-7 20-4-9-9-4Z"/>
                                <path d="M22 2 11 13"/>
                            </svg>
                        </span>
                    </button>

                    <button
                        type="button"
                        @click="setFilterStatus('sudah_dibuka')"
                        :class="filterStatus === 'sudah_dibuka' ? 'ring-2 ring-emerald-600 shadow-md' : 'ring-1 ring-champagne/30 hover:ring-emerald-300 shadow-sm'"
                        class="group rounded-2xl bg-white p-3.5 sm:p-4 text-left transition active:scale-[0.99] cursor-pointer flex items-center justify-between gap-3"
                    >
                        <div class="min-w-0">
                            <p class="text-[11px] font-semibold uppercase tracking-wider text-emerald-800/75">Sudah Dibuka</p>
                            <p class="mt-1 font-sans tabular-nums text-xl sm:text-2xl font-bold text-emerald-700 leading-none" x-text="stat().sudahDibuka"></p>
                            <p class="mt-1 text-[11px] text-emerald-700/80 font-medium truncate" x-text="persenDibuka() + '% telah dibuka'"></p>
                        </div>
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/80 shrink-0 group-hover:scale-105 transition-transform">
                            <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </span>
                    </button>
                </div>
            </section>

            {{-- DAFTAR TAMU & SEBAR WA (DATATABLE) --}}
            <section class="rounded-[1.5rem] bg-white p-4 sm:p-6 shadow-sm ring-1 ring-champagne/25 space-y-3">
                <div
                    x-show="filterStatus !== 'semua'"
                    x-cloak
                    class="flex items-center justify-between gap-2 rounded-xl bg-ivory/80 px-3.5 py-2 ring-1 ring-champagne/25 text-xs"
                >
                    <p class="text-charcoal/75">
                        Menyaring status:
                        <span
                            class="font-bold text-charcoal"
                            x-text="filterStatus === 'belum_dikirim' ? 'Belum Dikirim' : (filterStatus === 'sudah_dikirim' ? 'Terkirim' : 'Sudah Dibuka')"
                        ></span>
                    </p>
                    <button
                        type="button"
                        @click="setFilterStatus('semua')"
                        class="font-semibold text-sage hover:underline cursor-pointer"
                    >
                        Tampilkan Semua
                    </button>
                </div>

                <table
                    id="tabel-daftar-tamu"
                    data-datatable
                    data-page-length="10"
                    data-empty-message="Belum ada tamu di daftar Anda. Klik + Tambah Tamu atau Import Banyak untuk memulai."
                    class="w-full text-sm"
                >
                    <thead>
                        <tr class="border-b border-champagne/20 text-left text-[11px] font-semibold uppercase tracking-wider text-charcoal/55">
                            <th class="py-3 pr-4 dt-left text-left">Tamu</th>
                            <th class="py-3 px-4 dt-center text-center">Status</th>
                            <th class="py-3 px-4 dt-center text-center">Dibuka</th>
                            <th data-no-sort class="py-3 dt-center text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-champagne/15">
                        @foreach ($undangan->daftarTamu as $tamu)
                            @php
                                $statusUrut = $tamu->sudahDibuka() ? 3 : ($tamu->sudahDikirim() ? 2 : 1);
                                $jumlahDibukaUrut = $tamu->sudahDibuka() ? (int) $tamu->jumlah_dibuka : 0;
                                $nomorLokalCari = ($tamu->nomor_wa && str_starts_with($tamu->nomor_wa, '62'))
                                    ? '0' . substr($tamu->nomor_wa, 2)
                                    : '';
                            @endphp
                            <tr
                                data-tamu-row="{{ $tamu->id }}"
                                x-data="{ get tamu() { return tamuById({{ $tamu->id }}); } }"
                                class="hover:bg-ivory/55 transition-colors"
                            >
                                {{-- Kolom 1: Avatar Inisial + Nama & No WA --}}
                                <td
                                    class="py-3.5 pr-4 dt-left text-left align-middle"
                                    data-order="{{ mb_strtolower($tamu->nama_tamu) }}"
                                    data-search="{{ trim($tamu->nama_tamu . ' ' . $tamu->nomor_wa . ' ' . $nomorLokalCari) }}"
                                >
                                    <div class="flex items-center gap-3 min-w-[12rem]">
                                        <span
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-sage/12 text-sage font-sans text-xs font-bold tracking-tight shrink-0 ring-1 ring-sage/15"
                                            x-text="inisialNama(tamu.nama_tamu)"
                                        >{{ mb_strtoupper(mb_substr($tamu->nama_tamu, 0, 2)) }}</span>
                                        <div class="min-w-0">
                                            <p class="font-semibold text-charcoal leading-snug truncate" x-text="tamu.nama_tamu">{{ $tamu->nama_tamu }}</p>
                                            <div class="mt-0.5 flex items-center gap-1.5 text-xs text-charcoal/55">
                                                <template x-if="tamu.nomor_wa">
                                                    <span class="tabular-nums font-mono text-[11.5px]" x-text="tamu.nomorWaTampil">{{ $tamu->nomor_wa }}</span>
                                                </template>
                                                <template x-if="!tamu.nomor_wa">
                                                    <span class="inline-flex items-center gap-1.5">
                                                        <span>Tanpa no. WA</span>
                                                        <span aria-hidden="true">&middot;</span>
                                                        <button
                                                            type="button"
                                                            @click="bukaModalEdit(tamu)"
                                                            class="font-semibold text-sage hover:underline cursor-pointer"
                                                        >
                                                            + Tambah
                                                        </button>
                                                    </span>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Kolom 2: Status Badge --}}
                                <td class="py-3.5 px-4 dt-center text-center align-middle whitespace-nowrap" data-order="{{ $statusUrut }}">
                                    <template x-if="tamu.sudah_dibuka">
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200/80">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            <span>Sudah Dibuka</span>
                                        </span>
                                    </template>
                                    <template x-if="!tamu.sudah_dibuka && tamu.sudah_dikirim">
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-sage/10 px-2.5 py-1 text-xs font-semibold text-sage ring-1 ring-sage/20">
                                            <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M20 6 9 17l-5-5"/>
                                            </svg>
                                            <span>Terkirim</span>
                                        </span>
                                    </template>
                                    <template x-if="!tamu.sudah_dibuka && !tamu.sudah_dikirim">
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-800 ring-1 ring-amber-200/80">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                            <span>Belum Dikirim</span>
                                        </span>
                                    </template>
                                </td>

                                {{-- Kolom 3: Aktivitas Dibuka (1x, 2x, dll) --}}
                                <td class="py-3.5 px-4 dt-center text-center align-middle whitespace-nowrap" data-order="{{ $jumlahDibukaUrut }}">
                                    <template x-if="tamu.sudah_dibuka">
                                        <div class="inline-flex flex-col items-center">
                                            <span
                                                class="inline-flex items-center gap-1 rounded-lg bg-emerald-50/90 px-2.5 py-0.5 font-sans tabular-nums text-xs font-bold text-emerald-700 ring-1 ring-emerald-200/70"
                                                x-text="'Dibuka ' + tamu.jumlah_dibuka + 'x'"
                                            ></span>
                                            <span
                                                x-show="tamu.dibuka_pada_label"
                                                class="mt-1 text-[11px] text-charcoal/50"
                                                x-text="tamu.dibuka_pada_label"
                                            ></span>
                                        </div>
                                    </template>
                                    <template x-if="!tamu.sudah_dibuka && tamu.sudah_dikirim">
                                        <div class="inline-flex flex-col items-center">
                                            <span class="text-xs font-medium text-charcoal/70">Belum dibuka</span>
                                            <span
                                                x-show="tamu.dikirim_pada_label"
                                                class="mt-0.5 text-[11px] text-charcoal/45"
                                                x-text="'Dikirim ' + tamu.dikirim_pada_label"
                                            ></span>
                                        </div>
                                    </template>
                                    <template x-if="!tamu.sudah_dibuka && !tamu.sudah_dikirim">
                                        <span class="text-xs text-charcoal/40" x-text="tamu.nomor_wa ? 'Siap kirim WA' : 'Pilih kontak WA'"></span>
                                    </template>
                                </td>

                                {{-- Kolom 4: Aksi (Rata Tengah) --}}
                                <td class="py-3.5 px-4 dt-center text-center align-middle whitespace-nowrap">
                                    <div class="inline-flex items-center justify-center gap-2">
                                        @if ($undanganSiapDisebar)
                                            <button
                                                type="button"
                                                @click="salinPesan(tamu)"
                                                class="inline-flex items-center justify-center rounded-xl border border-champagne/50 bg-white px-3 py-1.5 text-xs font-semibold text-charcoal/80 hover:bg-ivory hover:text-charcoal active:scale-95 transition cursor-pointer"
                                                x-text="tamu.tersalin ? 'Tersalin!' : 'Salin'"
                                            ></button>
                                            <a
                                                :href="tamu.waUrl"
                                                target="_blank"
                                                rel="noopener"
                                                @click="tandaiKirimSaatKlikWa(tamu)"
                                                :class="tamu.sudah_dikirim
                                                    ? 'border border-sage/35 bg-sage/10 text-sage hover:bg-sage hover:text-white'
                                                    : 'bg-sage text-white hover:bg-[#3b5047] shadow-2xs'"
                                                class="inline-flex items-center justify-center gap-1.5 rounded-xl px-3.5 py-1.5 text-xs font-semibold active:scale-95 transition"
                                            >
                                                <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <path d="m22 2-7 20-4-9-9-4Z"/>
                                                    <path d="M22 2 11 13"/>
                                                </svg>
                                                <span x-text="tamu.sudah_dikirim ? 'Kirim Lagi' : 'Kirim WA'"></span>
                                            </a>
                                        @else
                                            <button
                                                type="button"
                                                disabled
                                                aria-disabled="true"
                                                title="Aktifkan undangan terlebih dahulu"
                                                class="inline-flex items-center justify-center gap-1 rounded-xl border border-charcoal/15 bg-charcoal/5 px-3 py-1.5 text-xs font-semibold text-charcoal/40 cursor-not-allowed"
                                            >
                                                Salin
                                            </button>
                                            <button
                                                type="button"
                                                disabled
                                                aria-disabled="true"
                                                title="Aktifkan undangan terlebih dahulu"
                                                class="inline-flex items-center justify-center gap-1 rounded-xl bg-charcoal/12 px-3.5 py-1.5 text-xs font-semibold text-charcoal/45 cursor-not-allowed"
                                            >
                                                <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                                </svg>
                                                Kirim WA
                                            </button>
                                        @endif

                                        <button
                                            type="button"
                                            @click.stop="toggleMenu(tamu, $event)"
                                            aria-label="Menu lainnya"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-xl text-charcoal/55 hover:bg-ivory hover:text-charcoal transition cursor-pointer"
                                        >
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                <circle cx="12" cy="5" r="1.6"/>
                                                <circle cx="12" cy="12" r="1.6"/>
                                                <circle cx="12" cy="19" r="1.6"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>

            {{-- Floating Menu Aksi Baris Tamu (Fixed, anti-clip di dalam DataTable) --}}
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
                class="fixed inset-0 z-50 bg-charcoal/50 backdrop-blur-xs flex items-end sm:items-center justify-center p-0 sm:p-4"
            >
                <div
                    @click.away="if (!window.Swal?.isVisible() && !$event.target?.closest('.swal2-container')) modalTambah = false"
                    class="w-full sm:max-w-lg rounded-t-[1.75rem] sm:rounded-[1.75rem] bg-white p-5 sm:p-6 shadow-2xl ring-1 ring-champagne/30 space-y-4"
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
                            class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-ivory text-charcoal/60 hover:text-charcoal cursor-pointer"
                        >
                            &times;
                        </button>
                    </div>

                    <div class="grid grid-cols-2 rounded-xl bg-ivory p-1 ring-1 ring-champagne/25">
                        <button
                            type="button"
                            @click="modeTambah = 'satuan'"
                            :class="modeTambah === 'satuan' ? 'bg-white text-sage shadow-xs' : 'text-charcoal/65 hover:text-charcoal'"
                            class="rounded-lg py-2 text-xs font-semibold transition cursor-pointer"
                        >
                            Tambah 1 Tamu
                        </button>
                        <button
                            type="button"
                            @click="modeTambah = 'massal'"
                            :class="modeTambah === 'massal' ? 'bg-white text-sage shadow-xs' : 'text-charcoal/65 hover:text-charcoal'"
                            class="rounded-lg py-2 text-xs font-semibold transition cursor-pointer"
                        >
                            Import Banyak
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
                            <button type="button" @click="modalTambah = false" class="rounded-xl bg-ivory px-4 py-2.5 text-xs font-semibold text-charcoal/75 hover:bg-champagne/15 cursor-pointer">
                                Batal
                            </button>
                            <button type="submit" class="rounded-xl bg-sage px-5 py-2.5 text-xs sm:text-sm font-semibold text-white hover:bg-[#3b5047] cursor-pointer">
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
                        class="space-y-4"
                        data-swal-loading
                        data-swal-loading-title="Menyimpan Daftar Tamu..."
                        data-swal-loading-text="Menambahkan semua tamu ke daftar undangan..."
                    >
                        @csrf
                        <input type="hidden" name="mode" value="massal">
                        <div>
                            <label for="modal_daftar_bulk" class="block text-xs font-semibold text-charcoal/80 mb-1">
                                Daftar Tamu (1 tamu per baris)
                            </label>
                            <textarea
                                id="modal_daftar_bulk"
                                name="daftar_bulk"
                                rows="5"
                                required
                                placeholder="Budi Santoso, 081234567890&#10;Siti Aminah &amp; Partner, 085612345678&#10;Keluarga Bpk. Hendra"
                                class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2.5 text-sm font-mono text-charcoal focus:border-sage focus:bg-white focus:outline-none"
                            >{{ old('mode') === 'massal' ? old('daftar_bulk') : '' }}</textarea>
                            <p class="mt-1.5 text-[11px] text-charcoal/55">
                                Pisahkan nama &amp; nomor WA dengan koma (opsional) atau tempel langsung dari Excel/Sheets. Maks. 200 baris.
                            </p>
                        </div>
                        <div class="flex items-center justify-end gap-2 pt-1">
                            <button type="button" @click="modalTambah = false" class="rounded-xl bg-ivory px-4 py-2.5 text-xs font-semibold text-charcoal/75 hover:bg-champagne/15 cursor-pointer">
                                Batal
                            </button>
                            <button type="submit" class="rounded-xl bg-sage px-5 py-2.5 text-xs sm:text-sm font-semibold text-white hover:bg-[#3b5047] cursor-pointer">
                                Simpan Daftar Tamu
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
                class="fixed inset-0 z-50 bg-charcoal/50 backdrop-blur-xs flex items-end sm:items-center justify-center p-0 sm:p-4"
            >
                <div
                    @click.away="if (!window.Swal?.isVisible() && !$event.target?.closest('.swal2-container')) tutupModalEdit()"
                    class="w-full sm:max-w-md rounded-t-[1.75rem] sm:rounded-[1.75rem] bg-white p-5 sm:p-6 shadow-2xl ring-1 ring-champagne/30 space-y-4"
                >
                    <div class="flex items-center justify-between gap-3">
                        <h2 class="font-sans text-lg font-bold text-charcoal tracking-tight">Edit Data Tamu</h2>
                        <button
                            type="button"
                            @click="tutupModalEdit()"
                            aria-label="Tutup modal edit"
                            class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-ivory text-charcoal/60 hover:text-charcoal cursor-pointer"
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
                        <button type="button" @click="tutupModalEdit()" class="rounded-xl bg-ivory px-4 py-2.5 text-xs font-semibold text-charcoal/75 hover:bg-champagne/15 cursor-pointer">
                            Batal
                        </button>
                        <button
                            type="button"
                            @click="simpanEdit()"
                            :disabled="sedangSimpanEdit"
                            class="rounded-xl bg-sage px-5 py-2.5 text-xs sm:text-sm font-semibold text-white hover:bg-[#3b5047] disabled:opacity-60 cursor-pointer"
                            x-text="sedangSimpanEdit ? 'Menyimpan...' : 'Simpan Perubahan'"
                        ></button>
                    </div>
                </div>
            </div>
            </div>
        </main>
    </div>
@endsection
