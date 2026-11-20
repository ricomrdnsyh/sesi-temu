@extends('layouts.aplikasi')

@section('judul', 'Tamu & RSVP — ' . $undangan->nama_panggilan_pria . ' & ' . $undangan->nama_panggilan_wanita)

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
            subtab: @js($subtabAktif),
            urlPublikUndangan: @js($urlPublik),
            namaPria: @js($undangan->nama_panggilan_pria),
            namaWanita: @js($undangan->nama_panggilan_wanita),
            siapDisebarUndangan: @js($undanganSiapDisebar),
            csrfToken: @js(csrf_token()),
            daftarTamu: @js($daftarTamuJson),
            filterStatus: 'semua',
            kataCari: '',
            menuTerbukaId: null,
            modalTambah: @js($bukaModalTambahAwal),
            modeTambah: @js($modeTambahAwal),
            modalEdit: false,
            tamuDiedit: null,
            editNama: '',
            editWa: '',
            sedangSimpanEdit: false,
            init() {
                this.daftarTamu.forEach((item) => this.lengkapiDataTamu(item));
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
            daftarTersaring() {
                const kata = (this.kataCari || '').trim().toLowerCase();

                return this.daftarTamu.filter((item) => {
                    if (this.filterStatus === 'belum_dikirim' && item.sudah_dikirim) return false;
                    if (this.filterStatus === 'sudah_dikirim' && !item.sudah_dikirim) return false;
                    if (this.filterStatus === 'sudah_dibuka' && !item.sudah_dibuka) return false;

                    if (kata) {
                        const cocokNama = (item.nama_tamu || '').toLowerCase().includes(kata);
                        const cocokWa = (item.nomor_wa || '').toLowerCase().includes(kata)
                            || (item.nomorWaTampil || '').toLowerCase().includes(kata);
                        return cocokNama || cocokWa;
                    }

                    return true;
                });
            },
            bukaModalTambah(mode) {
                this.modeTambah = mode || 'satuan';
                this.modalTambah = true;
            },
            toggleMenu(id) {
                this.menuTerbukaId = this.menuTerbukaId === id ? null : id;
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
                this.menuTerbukaId = null;
                if (!tamu.urlTamu) return;
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
                this.menuTerbukaId = null;
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

                    this.tamuDiedit.nama_tamu = data.tamu?.nama_tamu || namaBaru;
                    this.tamuDiedit.nomor_wa = data.tamu?.nomor_wa || null;
                    this.lengkapiDataTamu(this.tamuDiedit);
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
        @keydown.escape.window="if (!window.Swal?.isVisible()) { modalTambah = false; modalEdit = false; menuTerbukaId = null; }"
        class="min-h-screen flex bg-ivory"
    >
        {{-- Sidebar Vertikal Ramping Desktop + Bottom Bar Mobile --}}
        @include('dashboard._workspace-sidebar', [
            'undangan' => $undangan,
            'menuAktif' => $subtabAktif === 'rsvp' ? 'rsvp' : 'tamu',
        ])

        <main class="flex-1 min-w-0">
            <div class="max-w-6xl w-full mx-auto px-4 sm:px-6 lg:px-8 pt-5 pb-28 lg:py-7 space-y-5">
            {{-- Header Halaman & Tombol Tambah Tamu --}}
            <section class="flex flex-col sm:flex-row sm:items-center justify-between gap-3.5">
                <div class="space-y-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2 text-xs text-charcoal/55">
                        <a href="{{ auth()->user()->adalahAdmin() ? route('admin.undangan.index') : route('dashboard.index') }}" class="hover:text-sage transition">Dashboard</a>
                        <span aria-hidden="true">&rsaquo;</span>
                        <a href="{{ route('dashboard.undangan.kelola', $undangan) }}" class="hover:text-sage transition truncate">{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</a>
                        <span aria-hidden="true">&rsaquo;</span>
                        <span class="font-semibold text-charcoal/80" x-text="subtab === 'rsvp' ? 'RSVP & Ucapan' : 'Daftar Tamu'"></span>
                    </div>
                    <div class="flex flex-wrap items-center gap-2.5">
                        <h1 class="font-sans text-xl sm:text-2xl font-bold text-charcoal tracking-tight">Tamu &amp; RSVP</h1>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-white px-2.5 py-0.5 text-[11px] font-semibold text-charcoal/75 ring-1 ring-champagne/30">
                            <span class="h-1.5 w-1.5 rounded-full {{ $undanganSiapDisebar ? 'bg-emerald-500' : ($sudahKedaluwarsa ? 'bg-red-500' : 'bg-amber-500') }}"></span>
                            <span class="font-mono text-sage">sesitemu.id/{{ $undangan->slug }}</span>
                        </span>
                    </div>
                    <p class="text-xs sm:text-sm text-charcoal/60">
                        Kelola daftar tamu, kirim undangan langsung ke chat WhatsApp, dan pantau status buka serta ucapan.
                    </p>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    <a
                        href="{{ $urlPublik }}"
                        target="_blank"
                        title="Pratinjau Undangan"
                        class="hidden sm:inline-flex items-center justify-center gap-1.5 rounded-xl bg-white px-3 py-2.5 text-xs sm:text-sm font-semibold text-charcoal ring-1 ring-champagne/40 hover:bg-champagne/10 active:scale-[0.98] transition"
                    >
                        <svg class="h-4 w-4 text-sage shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <span>Pratinjau</span>
                    </a>
                    <button
                        type="button"
                        @click="bukaModalTambah('massal')"
                        class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 rounded-xl bg-white px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-charcoal ring-1 ring-champagne/40 hover:bg-champagne/10 active:scale-[0.98] transition cursor-pointer"
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
                        class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 rounded-xl bg-sage px-4 py-2.5 text-xs sm:text-sm font-semibold text-white shadow-xs hover:bg-[#3b5047] active:scale-[0.98] transition cursor-pointer"
                    >
                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 5v14" />
                            <path d="M5 12h14" />
                        </svg>
                        <span>Tambah Tamu</span>
                    </button>
                </div>
            </section>

            {{-- Banner Lock jika Draft / Kedaluwarsa --}}
            @if (! $undanganSiapDisebar)
                <section class="rounded-2xl border border-amber-300/70 bg-amber-50/90 p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-start gap-3">
                        <div class="shrink-0 w-9 h-9 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </div>
                        <div class="space-y-0.5">
                            <p class="text-sm font-bold text-charcoal">
                                {{ $sudahKedaluwarsa ? 'Kirim WA Dikunci — Masa Aktif Undangan Berakhir' : 'Mode Simulasi — Aktifkan Undangan untuk Menyebar Link WA' }}
                            </p>
                            <p class="text-xs text-charcoal/75 leading-relaxed">
                                @if ($sudahKedaluwarsa)
                                    Perpanjang masa aktif undangan terlebih dahulu agar tamu dapat kembali membuka tautan dan tombol <strong>Kirim WA</strong> aktif kembali.
                                @else
                                    Anda sudah dapat menyiapkan daftar tamu dari sekarang. Tombol <strong>Kirim WA</strong> &amp; <strong>Salin</strong> otomatis aktif setelah pembayaran diverifikasi Admin.
                                    @if ($sedangMenungguVerifikasi)
                                        <span class="block mt-0.5 font-semibold text-amber-900">Bukti pembayaran Anda sedang menunggu verifikasi Admin.</span>
                                    @endif
                                @endif
                            </p>
                        </div>
                    </div>

                    <a
                        href="{{ route('dashboard.undangan.kelola', [$undangan, 'tab' => 'aktivasi']) }}"
                        class="shrink-0 w-full sm:w-auto text-center rounded-xl bg-amber-600 px-4 py-2.5 text-xs font-semibold text-white hover:bg-amber-700 transition"
                    >
                        {{ $sudahKedaluwarsa ? 'Perpanjang Aktivasi' : 'Bayar & Aktifkan Undangan' }} &rarr;
                    </a>
                </section>
            @endif

            {{-- 2 Sub-Tab Bersih: Daftar Tamu | Ucapan & RSVP --}}
            <div class="flex items-center justify-between gap-3 border-b border-champagne/25">
                <div class="flex items-center gap-1 sm:gap-2">
                    <button
                        type="button"
                        @click="subtab = 'tamu'"
                        :class="subtab === 'tamu'
                            ? 'border-sage text-sage font-bold'
                            : 'border-transparent text-charcoal/60 hover:text-charcoal font-medium'"
                        class="inline-flex items-center gap-2 border-b-2 px-3 sm:px-4 py-2.5 text-xs sm:text-sm transition cursor-pointer -mb-px"
                    >
                        <span>Daftar Tamu</span>
                        <span
                            class="rounded-full bg-sage/12 px-2 py-0.5 font-sans tabular-nums text-[11px] font-bold text-sage"
                            x-text="daftarTamu.length"
                        ></span>
                    </button>
                    <button
                        type="button"
                        @click="subtab = 'rsvp'"
                        :class="subtab === 'rsvp'
                            ? 'border-sage text-sage font-bold'
                            : 'border-transparent text-charcoal/60 hover:text-charcoal font-medium'"
                        class="inline-flex items-center gap-2 border-b-2 px-3 sm:px-4 py-2.5 text-xs sm:text-sm transition cursor-pointer -mb-px"
                    >
                        <span>Ucapan &amp; RSVP</span>
                        <span class="rounded-full bg-champagne/20 px-2 py-0.5 font-sans tabular-nums text-[11px] font-bold text-[#8A6D33]">
                            {{ $undangan->bukuTamu->count() }}
                        </span>
                    </button>
                </div>

                <a
                    href="{{ route('dashboard.undangan.tamu', $undangan) }}"
                    x-show="subtab === 'tamu'"
                    title="Muat ulang status terbaru tamu yang sudah membuka undangan"
                    class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-xs font-semibold text-charcoal/65 hover:bg-white hover:text-sage transition mb-1"
                >
                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M21 12a9 9 0 1 1-2.64-6.36L21 8"/>
                        <path d="M21 3v5h-5"/>
                    </svg>
                    <span class="hidden sm:inline">Segarkan</span>
                </a>
            </div>

            {{-- SUB-TAB 1: DAFTAR TAMU & SEBAR WA --}}
            <section x-show="subtab === 'tamu'" class="rounded-[1.5rem] bg-white shadow-xs ring-1 ring-champagne/25">
                {{-- 1 Bar Filter & Pencarian Tunggal --}}
                <div
                    x-show="daftarTamu.length > 0"
                    class="px-4 sm:px-6 py-4 border-b border-champagne/20 flex flex-col lg:flex-row lg:items-center justify-between gap-3"
                >
                    <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar py-0.5">
                        <button
                            type="button"
                            @click="filterStatus = 'semua'"
                            :class="filterStatus === 'semua'
                                ? 'bg-charcoal text-white'
                                : 'bg-ivory text-charcoal/70 hover:text-charcoal'"
                            class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold whitespace-nowrap transition cursor-pointer shrink-0"
                        >
                            <span>Semua</span>
                            <span class="tabular-nums opacity-80" x-text="stat().total"></span>
                        </button>
                        <button
                            type="button"
                            @click="filterStatus = 'belum_dikirim'"
                            :class="filterStatus === 'belum_dikirim'
                                ? 'bg-amber-600 text-white'
                                : 'bg-amber-50 text-amber-800 hover:bg-amber-100'"
                            class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold whitespace-nowrap transition cursor-pointer shrink-0"
                        >
                            <span>Belum Dikirim</span>
                            <span class="tabular-nums opacity-85" x-text="stat().belumDikirim"></span>
                        </button>
                        <button
                            type="button"
                            @click="filterStatus = 'sudah_dikirim'"
                            :class="filterStatus === 'sudah_dikirim'
                                ? 'bg-sage text-white'
                                : 'bg-sage/10 text-sage hover:bg-sage/20'"
                            class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold whitespace-nowrap transition cursor-pointer shrink-0"
                        >
                            <span>Terkirim</span>
                            <span class="tabular-nums opacity-85" x-text="stat().sudahDikirim"></span>
                        </button>
                        <button
                            type="button"
                            @click="filterStatus = 'sudah_dibuka'"
                            :class="filterStatus === 'sudah_dibuka'
                                ? 'bg-emerald-600 text-white'
                                : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100'"
                            class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold whitespace-nowrap transition cursor-pointer shrink-0"
                        >
                            <span>Sudah Dibuka</span>
                            <span class="tabular-nums opacity-85" x-text="stat().sudahDibuka"></span>
                        </button>
                    </div>

                    <div class="relative w-full lg:w-64 shrink-0">
                        <svg class="pointer-events-none h-4 w-4 text-charcoal/40 absolute left-3 top-1/2 -translate-y-1/2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.3-4.3"/>
                        </svg>
                        <input
                            type="search"
                            x-model="kataCari"
                            placeholder="Cari nama atau no. WA..."
                            class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 pl-9 pr-3.5 py-2 text-xs sm:text-sm text-charcoal focus:border-sage focus:bg-white focus:outline-none transition"
                        >
                    </div>
                </div>

                {{-- Empty State Belum Ada Tamu --}}
                <div x-show="daftarTamu.length === 0" class="px-6 py-12 text-center space-y-4">
                    <div class="mx-auto w-12 h-12 rounded-2xl bg-sage/10 text-sage flex items-center justify-center">
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
                            Tambahkan nama &amp; nomor WhatsApp tamu agar bisa langsung kirim undangan personal dan pantau siapa yang sudah membuka.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-2 pt-1">
                        <button
                            type="button"
                            @click="bukaModalTambah('satuan')"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 rounded-xl bg-sage px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#3b5047] transition cursor-pointer"
                        >
                            <span>+ Tambah Tamu</span>
                        </button>
                        <button
                            type="button"
                            @click="bukaModalTambah('massal')"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 rounded-xl bg-ivory px-5 py-2.5 text-sm font-semibold text-charcoal ring-1 ring-champagne/40 hover:bg-champagne/10 transition cursor-pointer"
                        >
                            <span>Import Banyak Sekaligus</span>
                        </button>
                    </div>
                </div>

                {{-- Empty State Hasil Filter Kosong --}}
                <div
                    x-show="daftarTamu.length > 0 && daftarTersaring().length === 0"
                    x-cloak
                    class="px-6 py-10 text-center space-y-2.5"
                >
                    <p class="text-sm font-semibold text-charcoal">Tidak ada tamu yang cocok dengan filter ini.</p>
                    <button
                        type="button"
                        @click="filterStatus = 'semua'; kataCari = ''"
                        class="inline-flex items-center rounded-xl bg-ivory px-4 py-2 text-xs font-semibold text-sage ring-1 ring-sage/25 hover:bg-sage/10 transition cursor-pointer"
                    >
                        Tampilkan Semua Tamu
                    </button>
                </div>

                {{-- TAMPILAN DESKTOP: TABEL CLEAN 3 KOLOM --}}
                <div x-show="daftarTersaring().length > 0" class="hidden md:block">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b border-champagne/20 text-left text-[11px] font-semibold uppercase tracking-wider text-charcoal/50">
                                <th class="py-3 pl-6 pr-4">Tamu</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 pl-4 pr-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-champagne/15">
                            <template x-for="(tamu, idx) in daftarTersaring()" :key="tamu.id">
                                <tr class="hover:bg-ivory/55 transition-colors">
                                    {{-- Kolom 1: Nama & No WA Tipis --}}
                                    <td class="py-3.5 pl-6 pr-4 align-middle">
                                        <p class="font-semibold text-charcoal leading-snug" x-text="tamu.nama_tamu"></p>
                                        <div class="mt-0.5 flex items-center gap-1.5 text-xs text-charcoal/55">
                                            <template x-if="tamu.nomor_wa">
                                                <span class="tabular-nums" x-text="tamu.nomorWaTampil"></span>
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
                                    </td>

                                    {{-- Kolom 2: 1 Indikator Status Progresif --}}
                                    <td class="py-3.5 px-4 align-middle">
                                        <template x-if="tamu.sudah_dibuka">
                                            <div>
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200/80">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                    <span>Sudah Dibuka</span>
                                                </span>
                                                <p
                                                    class="mt-1 text-[11px] text-charcoal/50"
                                                    x-text="'Dibuka ' + tamu.jumlah_dibuka + 'x' + (tamu.dibuka_pada_label ? ' • ' + tamu.dibuka_pada_label : '')"
                                                ></p>
                                            </div>
                                        </template>
                                        <template x-if="!tamu.sudah_dibuka && tamu.sudah_dikirim">
                                            <div>
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-sage/10 px-2.5 py-0.5 text-xs font-semibold text-sage ring-1 ring-sage/20">
                                                    <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                        <path d="M20 6 9 17l-5-5"/>
                                                    </svg>
                                                    <span>Terkirim</span>
                                                </span>
                                                <p
                                                    class="mt-1 text-[11px] text-charcoal/50"
                                                    x-text="(tamu.dikirim_pada_label ? 'Dikirim ' + tamu.dikirim_pada_label + ' • ' : '') + 'Belum dibuka'"
                                                ></p>
                                            </div>
                                        </template>
                                        <template x-if="!tamu.sudah_dibuka && !tamu.sudah_dikirim">
                                            <div>
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-800 ring-1 ring-amber-200/80">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                                    <span>Belum Dikirim</span>
                                                </span>
                                                <p class="mt-1 text-[11px] text-charcoal/45" x-text="tamu.nomor_wa ? 'Langsung ke chat WA' : 'Pilih kontak saat kirim'"></p>
                                            </div>
                                        </template>
                                    </td>

                                    {{-- Kolom 3: Kirim WA + Salin + Menu Titik Tiga --}}
                                    <td class="py-3.5 pl-4 pr-6 align-middle text-right">
                                        <div class="inline-flex items-center justify-end gap-2">
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

                                            {{-- Menu Titik Tiga --}}
                                            <div class="relative" @click.away="if (menuTerbukaId === tamu.id) menuTerbukaId = null">
                                                <button
                                                    type="button"
                                                    @click.stop="toggleMenu(tamu.id)"
                                                    aria-label="Menu lainnya"
                                                    class="inline-flex h-8 w-8 items-center justify-center rounded-xl text-charcoal/55 hover:bg-ivory hover:text-charcoal transition cursor-pointer"
                                                >
                                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                        <circle cx="12" cy="5" r="1.6"/>
                                                        <circle cx="12" cy="12" r="1.6"/>
                                                        <circle cx="12" cy="19" r="1.6"/>
                                                    </svg>
                                                </button>

                                                <div
                                                    x-show="menuTerbukaId === tamu.id"
                                                    x-cloak
                                                    x-transition
                                                    :class="(idx >= daftarTersaring().length - 2 && daftarTersaring().length >= 3) ? 'bottom-full mb-1.5' : 'top-full mt-1.5'"
                                                    class="absolute right-0 z-30 w-48 rounded-2xl bg-white p-1.5 shadow-lg ring-1 ring-champagne/30 text-left"
                                                >
                                                    <button
                                                        type="button"
                                                        @click="salinLinkSaja(tamu)"
                                                        class="w-full rounded-xl px-3 py-2 text-xs font-medium text-charcoal/85 hover:bg-ivory text-left transition cursor-pointer"
                                                    >
                                                        Salin Link Saja
                                                    </button>
                                                    <button
                                                        type="button"
                                                        @click="menuTerbukaId = null; setStatusKirim(tamu, !tamu.sudah_dikirim)"
                                                        class="w-full rounded-xl px-3 py-2 text-xs font-medium text-charcoal/85 hover:bg-ivory text-left transition cursor-pointer"
                                                        x-text="tamu.sudah_dikirim ? 'Tandai Belum Dikirim' : 'Tandai Sudah Dikirim'"
                                                    ></button>
                                                    <button
                                                        type="button"
                                                        @click="bukaModalEdit(tamu)"
                                                        class="w-full rounded-xl px-3 py-2 text-xs font-medium text-charcoal/85 hover:bg-ivory text-left transition cursor-pointer"
                                                    >
                                                        Edit Nama &amp; No. WA
                                                    </button>
                                                    <div class="my-1 border-t border-champagne/20"></div>
                                                    <form
                                                        :action="tamu.url_hapus"
                                                        method="POST"
                                                        data-swal-title="Hapus Tamu?"
                                                        :data-swal-confirm="'Tamu ' + tamu.nama_tamu + ' akan dihapus dari daftar beserta riwayat status kirim & bukanya.'"
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
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                {{-- TAMPILAN MOBILE: KARTU RINGKAS --}}
                <div x-show="daftarTersaring().length > 0" class="md:hidden divide-y divide-champagne/20">
                    <template x-for="tamu in daftarTersaring()" :key="tamu.id">
                        <div class="p-4 space-y-3">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <p class="font-semibold text-sm text-charcoal truncate" x-text="tamu.nama_tamu"></p>
                                    <div class="mt-0.5 text-xs text-charcoal/55">
                                        <template x-if="tamu.nomor_wa">
                                            <span class="tabular-nums" x-text="tamu.nomorWaTampil"></span>
                                        </template>
                                        <template x-if="!tamu.nomor_wa">
                                            <span>
                                                Tanpa no. WA &middot;
                                                <button type="button" @click="bukaModalEdit(tamu)" class="font-semibold text-sage">
                                                    + Tambah
                                                </button>
                                            </span>
                                        </template>
                                    </div>
                                </div>

                                <div class="flex items-center gap-1 shrink-0">
                                    <template x-if="tamu.sudah_dibuka">
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-700 ring-1 ring-emerald-200/80">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Sudah Dibuka
                                        </span>
                                    </template>
                                    <template x-if="!tamu.sudah_dibuka && tamu.sudah_dikirim">
                                        <span class="inline-flex items-center gap-1 rounded-full bg-sage/10 px-2.5 py-0.5 text-[11px] font-semibold text-sage ring-1 ring-sage/20">
                                            Terkirim
                                        </span>
                                    </template>
                                    <template x-if="!tamu.sudah_dibuka && !tamu.sudah_dikirim">
                                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-[11px] font-semibold text-amber-800 ring-1 ring-amber-200/80">
                                            Belum Dikirim
                                        </span>
                                    </template>

                                    <div class="relative" @click.away="if (menuTerbukaId === tamu.id) menuTerbukaId = null">
                                        <button
                                            type="button"
                                            @click.stop="toggleMenu(tamu.id)"
                                            aria-label="Menu lainnya"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-xl text-charcoal/55 hover:bg-ivory cursor-pointer"
                                        >
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                <circle cx="12" cy="5" r="1.6"/>
                                                <circle cx="12" cy="12" r="1.6"/>
                                                <circle cx="12" cy="19" r="1.6"/>
                                            </svg>
                                        </button>

                                        <div
                                            x-show="menuTerbukaId === tamu.id"
                                            x-cloak
                                            x-transition
                                            class="absolute right-0 top-full mt-1 z-30 w-48 rounded-2xl bg-white p-1.5 shadow-lg ring-1 ring-champagne/30 text-left"
                                        >
                                            <button type="button" @click="salinLinkSaja(tamu)" class="w-full rounded-xl px-3 py-2 text-xs font-medium text-charcoal/85 hover:bg-ivory text-left">Salin Link Saja</button>
                                            <button type="button" @click="menuTerbukaId = null; setStatusKirim(tamu, !tamu.sudah_dikirim)" class="w-full rounded-xl px-3 py-2 text-xs font-medium text-charcoal/85 hover:bg-ivory text-left" x-text="tamu.sudah_dikirim ? 'Tandai Belum Dikirim' : 'Tandai Sudah Dikirim'"></button>
                                            <button type="button" @click="bukaModalEdit(tamu)" class="w-full rounded-xl px-3 py-2 text-xs font-medium text-charcoal/85 hover:bg-ivory text-left">Edit Nama &amp; No. WA</button>
                                            <div class="my-1 border-t border-champagne/20"></div>
                                            <form
                                                :action="tamu.url_hapus"
                                                method="POST"
                                                data-swal-title="Hapus Tamu?"
                                                :data-swal-confirm="'Tamu ' + tamu.nama_tamu + ' akan dihapus dari daftar beserta riwayat status kirim & bukanya.'"
                                                data-swal-icon="warning"
                                                data-swal-confirm-button="Ya, Hapus"
                                                data-swal-confirm-color="#DC2626"
                                                data-swal-loading-title="Menghapus Tamu..."
                                                data-swal-loading-text="Menghapus tamu dari daftar..."
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full rounded-xl px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 text-left">Hapus Tamu</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p
                                x-show="tamu.sudah_dibuka || tamu.sudah_dikirim"
                                class="text-[11px] text-charcoal/50"
                                x-text="tamu.sudah_dibuka
                                    ? ('Dibuka ' + tamu.jumlah_dibuka + 'x' + (tamu.dibuka_pada_label ? ' • ' + tamu.dibuka_pada_label : ''))
                                    : ((tamu.dikirim_pada_label ? 'Dikirim ' + tamu.dikirim_pada_label + ' • ' : '') + 'Belum dibuka')"
                            ></p>

                            <div class="grid grid-cols-2 gap-2">
                                @if ($undanganSiapDisebar)
                                    <button
                                        type="button"
                                        @click="salinPesan(tamu)"
                                        class="inline-flex items-center justify-center rounded-xl border border-champagne/50 bg-white px-3 py-2 text-xs font-semibold text-charcoal active:scale-95 transition cursor-pointer"
                                        x-text="tamu.tersalin ? 'Tersalin!' : 'Salin Pesan'"
                                    ></button>
                                    <a
                                        :href="tamu.waUrl"
                                        target="_blank"
                                        rel="noopener"
                                        @click="tandaiKirimSaatKlikWa(tamu)"
                                        :class="tamu.sudah_dikirim ? 'border border-sage/35 bg-sage/10 text-sage' : 'bg-sage text-white'"
                                        class="inline-flex items-center justify-center gap-1.5 rounded-xl px-3 py-2 text-xs font-semibold active:scale-95 transition"
                                    >
                                        <span x-text="tamu.sudah_dikirim ? 'Kirim Lagi' : 'Kirim WA'"></span>
                                    </a>
                                @else
                                    <button type="button" disabled class="rounded-xl border border-charcoal/15 bg-charcoal/5 px-3 py-2 text-xs font-semibold text-charcoal/40 cursor-not-allowed">
                                        Salin Pesan
                                    </button>
                                    <button type="button" disabled class="rounded-xl bg-charcoal/12 px-3 py-2 text-xs font-semibold text-charcoal/45 cursor-not-allowed">
                                        Kirim WA
                                    </button>
                                @endif
                            </div>
                        </div>
                    </template>
                </div>
            </section>

            {{-- SUB-TAB 2: UCAPAN & RSVP --}}
            <section x-show="subtab === 'rsvp'" x-cloak class="space-y-4">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div class="rounded-2xl bg-white p-4 shadow-xs ring-1 ring-champagne/25">
                        <p class="text-xs text-charcoal/65">Konfirmasi Hadir</p>
                        <p class="mt-1 font-sans tabular-nums text-2xl font-bold text-sage">{{ $rekapRsvp['hadir'] }}</p>
                    </div>
                    <div class="rounded-2xl bg-white p-4 shadow-xs ring-1 ring-champagne/25">
                        <p class="text-xs text-charcoal/65">Masih Ragu</p>
                        <p class="mt-1 font-sans tabular-nums text-2xl font-bold text-amber-700">{{ $rekapRsvp['ragu'] }}</p>
                    </div>
                    <div class="rounded-2xl bg-white p-4 shadow-xs ring-1 ring-champagne/25">
                        <p class="text-xs text-charcoal/65">Tidak Hadir</p>
                        <p class="mt-1 font-sans tabular-nums text-2xl font-bold text-red-700">{{ $rekapRsvp['tidak_hadir'] }}</p>
                    </div>
                    <div class="rounded-2xl bg-white p-4 shadow-xs ring-1 ring-champagne/25">
                        <p class="text-xs text-charcoal/65">Estimasi Orang Hadir</p>
                        <p class="mt-1 font-sans tabular-nums text-2xl font-bold text-charcoal">{{ $rekapRsvp['total_orang_hadir'] }}</p>
                    </div>
                </div>

                <div class="rounded-[1.5rem] bg-white shadow-xs ring-1 ring-champagne/25 overflow-hidden">
                    {{-- Mobile RSVP --}}
                    <div class="md:hidden divide-y divide-champagne/20">
                        @forelse ($undangan->bukuTamu as $ucapan)
                            <div class="p-4 space-y-2">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <p class="font-semibold text-sm text-charcoal">{{ $ucapan->nama_tamu }}</p>
                                        <p class="text-xs text-charcoal/55">{{ $ucapan->jumlah_tamu }} orang</p>
                                    </div>
                                    <span class="rounded-full px-2.5 py-0.5 text-[11px] font-semibold {{ $ucapan->status_kehadiran === 'hadir' ? 'bg-sage/12 text-sage' : ($ucapan->status_kehadiran === 'ragu' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-700') }}">
                                        {{ str_replace('_', ' ', ucfirst($ucapan->status_kehadiran)) }}
                                    </span>
                                </div>
                                <p class="text-xs text-charcoal/80 leading-relaxed">{{ $ucapan->ucapan_doa }}</p>
                                <div class="flex justify-end">
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
                                        <button type="submit" class="text-xs font-semibold text-red-600 hover:underline cursor-pointer">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="py-10 px-6 text-center text-xs text-charcoal/60">Belum ada ucapan atau konfirmasi kehadiran dari tamu.</p>
                        @endforelse
                    </div>

                    {{-- Desktop RSVP --}}
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b border-champagne/20 text-left text-[11px] font-semibold uppercase tracking-wider text-charcoal/50">
                                    <th class="py-3 pl-6 pr-4">Nama Tamu</th>
                                    <th class="py-3 px-4">Kehadiran</th>
                                    <th class="py-3 px-4">Jumlah</th>
                                    <th class="py-3 px-4">Ucapan &amp; Doa</th>
                                    <th class="py-3 pl-4 pr-6 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-champagne/15">
                                @forelse ($undangan->bukuTamu as $ucapan)
                                    <tr class="hover:bg-ivory/50 transition-colors">
                                        <td class="py-3.5 pl-6 pr-4 font-semibold text-charcoal">{{ $ucapan->nama_tamu }}</td>
                                        <td class="py-3.5 px-4">
                                            <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $ucapan->status_kehadiran === 'hadir' ? 'bg-sage/12 text-sage' : ($ucapan->status_kehadiran === 'ragu' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-700') }}">
                                                {{ str_replace('_', ' ', ucfirst($ucapan->status_kehadiran)) }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 tabular-nums text-charcoal/75">{{ $ucapan->jumlah_tamu }}</td>
                                        <td class="py-3.5 px-4 text-charcoal/80">{{ $ucapan->ucapan_doa }}</td>
                                        <td class="py-3.5 pl-4 pr-6 text-right">
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
                                                <button type="submit" class="text-xs font-semibold text-red-600 hover:underline cursor-pointer">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-10 text-center text-charcoal/60">Belum ada ucapan atau konfirmasi kehadiran dari tamu.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

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
