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
            ->map(
                fn(\App\Models\TamuUndangan $tamu): array => [
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
                ],
            )
            ->values()
            ->all();

        $bukaModalTambahAwal = $errors->hasAny(['nama_tamu', 'nomor_wa', 'daftar_bulk']);
        $modeTambahAwal = old('mode', $errors->has('daftar_bulk') ? 'massal' : 'satuan');
    @endphp

    <div x-data="{
        urlPublikUndangan: @js($urlPublik),
        namaPria: @js($undangan->nama_panggilan_pria),
        namaWanita: @js($undangan->nama_panggilan_wanita),
        siapDisebarUndangan: @js($undanganSiapDisebar),
        csrfToken: @js(csrf_token()),
        daftarTamu: @js($daftarTamuJson),
        filterStatus: 'semua',
        kataCari: '',
        urutan: 'terbaru',
        perHalaman: 10,
        halaman: 1,
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
            this.daftarTamu.forEach((item, idx) => {
                item._urutanAwal = idx;
                this.lengkapiDataTamu(item);
            });
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
            this.halaman = 1;
            this.menuTamu = null;
        },
        setUrutan(nilai) {
            this.urutan = nilai;
            this.halaman = 1;
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
            const nomorBersih = String(item.nomor_wa || '');
    
            item.urlTamu = urlTamu;
            item.pesan = this.siapDisebarUndangan ? pesan : '';
            item.waUrl = this.siapDisebarUndangan ?
                (item.nomor_wa ?
                    `https://wa.me/${item.nomor_wa}?text=${encodeURIComponent(pesan)}` :
                    `https://wa.me/?text=${encodeURIComponent(pesan)}`) :
                '#';
            item.nomorWaTampil = this.formatNomorWaTampil(item.nomor_wa);
            item.nomorLokalCari = nomorBersih.startsWith('62') ? '0' + nomorBersih.slice(2) : nomorBersih;
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
            const hasil = this.daftarTamu.filter((item) => {
                if (this.filterStatus === 'belum_dikirim' && item.sudah_dikirim) return false;
                if (this.filterStatus === 'sudah_dikirim' && !item.sudah_dikirim) return false;
                if (this.filterStatus === 'sudah_dibuka' && !item.sudah_dibuka) return false;
    
                if (kata) {
                    const cocokNama = (item.nama_tamu || '').toLowerCase().includes(kata);
                    const cocokWa = (item.nomor_wa || '').toLowerCase().includes(kata) ||
                        (item.nomorWaTampil || '').toLowerCase().includes(kata) ||
                        (item.nomorLokalCari || '').toLowerCase().includes(kata);
                    return cocokNama || cocokWa;
                }
    
                return true;
            });
    
            if (this.urutan === 'nama_az') {
                return [...hasil].sort((a, b) => (a.nama_tamu || '').localeCompare(b.nama_tamu || '', 'id'));
            }
            if (this.urutan === 'sering_dibuka') {
                return [...hasil].sort((a, b) => (b.jumlah_dibuka - a.jumlah_dibuka) || (a._urutanAwal - b._urutanAwal));
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
            if (total === 0) return '0 tamu';
            if (this.perHalaman <= 0) return `Menampilkan semua ${total} tamu`;
            const mulai = (this.halamanAman() - 1) * this.perHalaman + 1;
            const akhir = Math.min(total, mulai + this.perHalaman - 1);
            return `Menampilkan ${mulai}–${akhir} dari ${total} tamu`;
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
        @keydown.escape.window="if (!window.Swal?.isVisible()) { modalTambah = false; modalEdit = false; menuTamu = null; }"
        @scroll.window="menuTamu = null" class="min-h-screen flex bg-ivory">
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
                <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-10 pt-4 sm:pt-5 pb-28 lg:py-5 space-y-5">
                    {{-- Header Editorial Terang + Bento Metrik --}}
                    <section class="space-y-3.5">
                        <div
                            class="relative overflow-hidden rounded-[1.75rem] bg-gradient-to-br from-white via-[#FCFBF7] to-[#F4EDE0]/75 px-5 sm:px-7 py-5 sm:py-6 ring-1 ring-champagne/30 shadow-[0_12px_32px_-20px_rgba(32,48,41,0.16)]">
                            <div aria-hidden="true"
                                class="pointer-events-none absolute -right-12 -top-16 h-48 w-48 rounded-full bg-champagne/18 blur-3xl">
                            </div>
                            <div aria-hidden="true"
                                class="pointer-events-none absolute right-14 -bottom-16 h-36 w-36 rounded-full border border-champagne/25">
                            </div>

                            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                                <div class="space-y-1.5 min-w-0">
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-sage/10 px-3 py-0.5 text-[10.5px] font-semibold uppercase tracking-[0.12em] text-sage ring-1 ring-sage/15">
                                        <span class="h-1.5 w-1.5 rounded-full bg-sage"></span>
                                        <span>Daftar Sebar Undangan</span>
                                    </span>
                                    <div class="flex flex-wrap items-center gap-2.5">
                                        <h1 class="font-sans text-xl sm:text-2xl font-bold text-charcoal tracking-tight">
                                            Daftar Tamu</h1>
                                        <span
                                            class="inline-flex items-center rounded-full bg-white px-2.5 py-0.5 font-sans tabular-nums text-xs font-bold text-sage ring-1 ring-champagne/35 shadow-2xs"
                                            x-text="stat().total + ' Tamu'"></span>
                                    </div>
                                    <p class="text-xs sm:text-sm text-charcoal/60 max-w-xl leading-relaxed">
                                        Kirim tautan personal langsung ke WhatsApp dan pantau status buka setiap tamu dalam
                                        tampilan kartu yang ringkas.
                                    </p>
                                </div>

                                <div class="flex flex-wrap items-center gap-2 shrink-0">
                                    <a href="{{ route('dashboard.undangan.tamu', $undangan) }}"
                                        title="Segarkan status terbaru tamu" aria-label="Segarkan daftar tamu"
                                        class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-white text-charcoal/70 ring-1 ring-champagne/35 hover:bg-ivory hover:text-sage active:scale-95 transition shrink-0 shadow-2xs">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            aria-hidden="true">
                                            <path d="M21 12a9 9 0 1 1-2.64-6.36L21 8" />
                                            <path d="M21 3v5h-5" />
                                        </svg>
                                    </a>
                                    <a href="{{ $urlPublik }}" target="_blank" title="Pratinjau Undangan"
                                        class="inline-flex h-10 items-center justify-center gap-1.5 rounded-2xl bg-white px-3.5 text-xs sm:text-sm font-semibold text-charcoal ring-1 ring-champagne/35 hover:bg-ivory active:scale-[0.98] transition shrink-0 shadow-2xs">
                                        <svg class="h-4 w-4 text-sage shrink-0" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" aria-hidden="true">
                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                        <span>Pratinjau</span>
                                    </a>
                                    <button type="button" @click="bukaModalTambah('massal')"
                                        class="flex-1 sm:flex-none inline-flex h-10 items-center justify-center gap-1.5 rounded-2xl bg-white px-3.5 text-xs sm:text-sm font-semibold text-sage ring-1 ring-sage/30 hover:bg-sage/5 active:scale-[0.98] transition cursor-pointer shadow-2xs">
                                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" aria-hidden="true">
                                            <path
                                                d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                                            <rect x="8" y="2" width="8" height="4" rx="1" ry="1" />
                                        </svg>
                                        <span>Import Banyak</span>
                                    </button>
                                    <button type="button" @click="bukaModalTambah('satuan')"
                                        class="flex-1 sm:flex-none inline-flex h-10 items-center justify-center gap-1.5 rounded-2xl bg-sage px-4 text-xs sm:text-sm font-semibold text-white shadow-[0_10px_22px_-10px_rgba(75,99,88,0.65)] hover:bg-[#3A4F45] active:scale-[0.98] transition cursor-pointer">
                                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.4" stroke-linecap="round"
                                            stroke-linejoin="round" aria-hidden="true">
                                            <path d="M12 5v14" />
                                            <path d="M5 12h14" />
                                        </svg>
                                        <span>Tambah Tamu</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- 4 Bento Filter KPI Cards --}}
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                            <button type="button" @click="setFilterStatus('semua')"
                                :class="filterStatus === 'semua' ? 'ring-2 ring-sage shadow-md -translate-y-0.5' :
                                    'ring-1 ring-champagne/25 hover:ring-champagne/55 shadow-2xs'"
                                class="group rounded-2xl bg-white p-4 text-left transition-all cursor-pointer flex items-center gap-3.5">
                                <span
                                    class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-ivory text-charcoal/75 ring-1 ring-champagne/30 shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"
                                        aria-hidden="true">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-[11px] font-semibold uppercase tracking-wider text-charcoal/55 truncate">
                                        Semua Tamu</p>
                                    <div class="mt-0.5 flex items-baseline gap-1.5">
                                        <p class="font-sans tabular-nums text-2xl font-bold text-charcoal leading-none"
                                            x-text="stat().total"></p>
                                        <span class="text-[11px] text-charcoal/45 truncate">terdaftar</span>
                                    </div>
                                </div>
                            </button>

                            <button type="button" @click="setFilterStatus('belum_dikirim')"
                                :class="filterStatus === 'belum_dikirim' ? 'ring-2 ring-amber-500 shadow-md -translate-y-0.5' :
                                    'ring-1 ring-champagne/25 hover:ring-amber-300 shadow-2xs'"
                                class="group rounded-2xl bg-gradient-to-br from-white to-amber-50/75 p-4 text-left transition-all cursor-pointer flex items-center gap-3.5">
                                <span
                                    class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-100/80 text-amber-700 ring-1 ring-amber-200/80 shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"
                                        aria-hidden="true">
                                        <circle cx="12" cy="12" r="10" />
                                        <polyline points="12 6 12 12 16 14" />
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <p
                                        class="text-[11px] font-semibold uppercase tracking-wider text-amber-800/80 truncate">
                                        Belum Dikirim</p>
                                    <div class="mt-0.5 flex items-baseline gap-1.5">
                                        <p class="font-sans tabular-nums text-2xl font-bold text-amber-700 leading-none"
                                            x-text="stat().belumDikirim"></p>
                                        <span class="text-[11px] text-charcoal/45 truncate">menunggu</span>
                                    </div>
                                </div>
                            </button>

                            <button type="button" @click="setFilterStatus('sudah_dikirim')"
                                :class="filterStatus === 'sudah_dikirim' ? 'ring-2 ring-sage shadow-md -translate-y-0.5' :
                                    'ring-1 ring-champagne/25 hover:ring-sage/50 shadow-2xs'"
                                class="group rounded-2xl bg-gradient-to-br from-white to-sage/[0.07] p-4 text-left transition-all cursor-pointer flex items-center gap-3.5">
                                <span
                                    class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-sage/12 text-sage ring-1 ring-sage/20 shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"
                                        aria-hidden="true">
                                        <path d="m22 2-7 20-4-9-9-4Z" />
                                        <path d="M22 2 11 13" />
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-[11px] font-semibold uppercase tracking-wider text-sage/85 truncate">
                                        Terkirim</p>
                                    <div class="mt-0.5 flex items-baseline gap-1.5">
                                        <p class="font-sans tabular-nums text-2xl font-bold text-sage leading-none"
                                            x-text="stat().sudahDikirim"></p>
                                        <span class="text-[11px] text-charcoal/45 truncate">dibagikan</span>
                                    </div>
                                </div>
                            </button>

                            <button type="button" @click="setFilterStatus('sudah_dibuka')"
                                :class="filterStatus === 'sudah_dibuka' ?
                                    'ring-2 ring-emerald-600 shadow-md -translate-y-0.5' :
                                    'ring-1 ring-champagne/25 hover:ring-emerald-300 shadow-2xs'"
                                class="group rounded-2xl bg-gradient-to-br from-white to-emerald-50/80 p-4 text-left transition-all cursor-pointer flex items-center gap-3.5">
                                <span
                                    class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-100/80 text-emerald-700 ring-1 ring-emerald-200/80 shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"
                                        aria-hidden="true">
                                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </span>
                                <div class="min-w-0 flex-1">
                                    <p
                                        class="text-[11px] font-semibold uppercase tracking-wider text-emerald-800/80 truncate">
                                        Sudah Dibuka</p>
                                    <div class="mt-0.5 flex items-baseline justify-between gap-2">
                                        <p class="font-sans tabular-nums text-2xl font-bold text-emerald-700 leading-none"
                                            x-text="stat().sudahDibuka"></p>
                                        <span class="text-[11px] font-bold text-emerald-700 tabular-nums"
                                            x-text="persenDibuka() + '%'"></span>
                                    </div>
                                    <div class="mt-1.5 h-1 w-full rounded-full bg-emerald-200/60 overflow-hidden">
                                        <div class="h-full rounded-full bg-emerald-500 transition-all duration-500"
                                            :style="{ width: persenDibuka() + '%' }"></div>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </section>

                    {{-- Toolbar Pencarian & Urutan --}}
                    <section x-show="daftarTamu.length > 0"
                        class="rounded-2xl bg-white px-3.5 py-3 ring-1 ring-champagne/25 shadow-2xs flex flex-col lg:flex-row lg:items-center justify-between gap-3">
                        <div class="relative flex-1 max-w-md">
                            <svg class="pointer-events-none h-4 w-4 text-charcoal/40 absolute left-3.5 top-1/2 -translate-y-1/2"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                            <input type="search" x-model="kataCari" @input="halaman = 1"
                                placeholder="Cari nama tamu atau nomor WA..."
                                class="w-full rounded-xl border border-champagne/30 bg-ivory/65 pl-10 pr-9 py-2 text-xs sm:text-sm text-charcoal focus:border-sage focus:bg-white focus:outline-none transition">
                            <button type="button" x-show="kataCari.length > 0" x-cloak
                                @click="kataCari = ''; halaman = 1" aria-label="Hapus pencarian"
                                class="absolute right-2.5 top-1/2 -translate-y-1/2 inline-flex h-6 w-6 items-center justify-center rounded-full text-charcoal/50 hover:bg-ivory hover:text-charcoal cursor-pointer">
                                &times;
                            </button>
                        </div>

                        <div class="flex flex-wrap items-center justify-between lg:justify-end gap-2">
                            <div class="inline-flex items-center gap-1 rounded-xl bg-ivory p-1 ring-1 ring-champagne/25">
                                <button type="button" @click="setUrutan('terbaru')"
                                    :class="urutan === 'terbaru' ? 'bg-white text-sage shadow-2xs font-semibold' :
                                        'text-charcoal/65 hover:text-charcoal'"
                                    class="rounded-lg px-2.5 py-1.5 text-xs transition cursor-pointer">
                                    Terbaru
                                </button>
                                <button type="button" @click="setUrutan('nama_az')"
                                    :class="urutan === 'nama_az' ? 'bg-white text-sage shadow-2xs font-semibold' :
                                        'text-charcoal/65 hover:text-charcoal'"
                                    class="rounded-lg px-2.5 py-1.5 text-xs transition cursor-pointer">
                                    A–Z
                                </button>
                                <button type="button" @click="setUrutan('sering_dibuka')"
                                    :class="urutan === 'sering_dibuka' ? 'bg-white text-sage shadow-2xs font-semibold' :
                                        'text-charcoal/65 hover:text-charcoal'"
                                    class="rounded-lg px-2.5 py-1.5 text-xs transition cursor-pointer">
                                    Sering Dibuka
                                </button>
                            </div>

                            <label class="inline-flex items-center gap-2 text-xs font-medium text-charcoal/65">
                                <span>Tampilkan</span>
                                <select x-model.number="perHalaman" @change="halaman = 1"
                                    data-select2-variant="dt-length" data-select2-width="88px"
                                    aria-label="Jumlah tamu per halaman"
                                    class="rounded-xl border border-champagne/35 bg-ivory/70 px-2.5 py-1.5 text-xs font-semibold text-charcoal focus:border-sage focus:bg-white focus:outline-none">
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="25">25</option>
                                    <option value="0">Semua</option>
                                </select>
                            </label>
                        </div>
                    </section>

                    {{-- DAFTAR TAMU DALAM BENTUK CARD GRID --}}
                    <section id="daftar-kartu-tamu" data-tamu-cards class="space-y-4">
                        {{-- Empty State: Belum Ada Tamu --}}
                        <div x-show="daftarTamu.length === 0"
                            class="rounded-[1.75rem] bg-white px-6 py-14 text-center ring-1 ring-champagne/25 shadow-2xs space-y-4">
                            <div
                                class="mx-auto w-14 h-14 rounded-2xl bg-sage/10 text-sage ring-1 ring-sage/15 flex items-center justify-center">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                    aria-hidden="true">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M19 8v6" />
                                    <path d="M22 11h-6" />
                                </svg>
                            </div>
                            <div class="max-w-sm mx-auto space-y-1">
                                <p class="font-sans text-base font-bold text-charcoal">Belum ada tamu di daftar Anda</p>
                                <p class="text-xs sm:text-sm text-charcoal/60 leading-relaxed">
                                    Tambahkan nama &amp; nomor WhatsApp tamu untuk langsung mengirim link personal dan
                                    memantau status buka.
                                </p>
                            </div>
                            <div class="flex flex-col sm:flex-row items-center justify-center gap-2 pt-1">
                                <button type="button" @click="bukaModalTambah('satuan')"
                                    class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 rounded-2xl bg-sage px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#3A4F45] transition cursor-pointer">
                                    <span>+ Tambah Tamu</span>
                                </button>
                                <button type="button" @click="bukaModalTambah('massal')"
                                    class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 rounded-2xl bg-ivory px-5 py-2.5 text-sm font-semibold text-charcoal ring-1 ring-champagne/40 hover:bg-champagne/10 transition cursor-pointer">
                                    <span>Import Banyak Sekaligus</span>
                                </button>
                            </div>
                        </div>

                        {{-- Empty State: Hasil Filter / Pencarian Kosong --}}
                        <div x-show="daftarTamu.length > 0 && daftarTersaring().length === 0" x-cloak
                            class="rounded-[1.75rem] bg-white px-6 py-12 text-center ring-1 ring-champagne/25 shadow-2xs space-y-3">
                            <p class="text-sm font-bold text-charcoal">Tidak ada tamu yang cocok dengan filter ini.</p>
                            <p class="text-xs text-charcoal/55">Coba ubah kata kunci pencarian atau tampilkan semua status
                                tamu.</p>
                            <button type="button" @click="setFilterStatus('semua'); kataCari = ''"
                                class="inline-flex items-center rounded-xl bg-ivory px-4 py-2 text-xs font-semibold text-sage ring-1 ring-sage/25 hover:bg-sage/10 transition cursor-pointer">
                                Tampilkan Semua Tamu
                            </button>
                        </div>

                        {{-- Grid Kartu Tamu --}}
                        <div x-show="daftarHalamanIni().length > 0"
                            class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                            <template x-for="tamu in daftarHalamanIni()" :key="tamu.id">
                                <article
                                    class="group relative overflow-hidden rounded-[1.5rem] bg-white p-4 sm:p-5 ring-1 ring-champagne/25 shadow-[0_6px_22px_-14px_rgba(28,42,35,0.14)] hover:shadow-[0_16px_34px_-16px_rgba(28,42,35,0.2)] hover:-translate-y-0.5 transition-all duration-200 flex flex-col justify-between gap-4">
                                    {{-- Garis Aksen Status Tipis di Atas Kartu --}}
                                    <span
                                        :class="tamu.sudah_dibuka ? 'bg-emerald-500' : (tamu.sudah_dikirim ? 'bg-sage' :
                                            'bg-amber-400')"
                                        class="absolute inset-x-0 top-0 h-[3px]" aria-hidden="true"></span>

                                    {{-- Kepala Kartu: Avatar + Nama & WA + Menu --}}
                                    <div class="flex items-start justify-between gap-3 pt-0.5">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <span
                                                :class="tamu.sudah_dibuka ?
                                                    'bg-emerald-50 text-emerald-700 ring-emerald-200/80' :
                                                    (tamu.sudah_dikirim ? 'bg-sage/12 text-sage ring-sage/20' :
                                                        'bg-amber-50 text-amber-800 ring-amber-200/80')"
                                                class="inline-flex h-11 w-11 items-center justify-center rounded-2xl font-sans text-xs font-bold tracking-tight shrink-0 ring-1"
                                                x-text="inisialNama(tamu.nama_tamu)"></span>
                                            <div class="min-w-0">
                                                <h2 class="font-sans text-[15px] font-bold text-charcoal leading-snug truncate"
                                                    x-text="tamu.nama_tamu"></h2>
                                                <div class="mt-0.5 flex items-center gap-1.5 text-xs text-charcoal/55">
                                                    <template x-if="tamu.nomor_wa">
                                                        <span class="tabular-nums font-mono text-[11.5px] truncate"
                                                            x-text="tamu.nomorWaTampil"></span>
                                                    </template>
                                                    <template x-if="!tamu.nomor_wa">
                                                        <span class="inline-flex items-center gap-1.5">
                                                            <span>Tanpa no. WA</span>
                                                            <span aria-hidden="true">&middot;</span>
                                                            <button type="button" @click="bukaModalEdit(tamu)"
                                                                class="font-semibold text-sage hover:underline cursor-pointer">
                                                                + Tambah
                                                            </button>
                                                        </span>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="button" @click.stop="toggleMenu(tamu, $event)"
                                            aria-label="Menu lainnya"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-xl text-charcoal/50 hover:bg-ivory hover:text-charcoal transition cursor-pointer shrink-0">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"
                                                aria-hidden="true">
                                                <circle cx="12" cy="5" r="1.6" />
                                                <circle cx="12" cy="12" r="1.6" />
                                                <circle cx="12" cy="19" r="1.6" />
                                            </svg>
                                        </button>
                                    </div>

                                    {{-- Isi Kartu: 2 Petak Terpisah untuk Status & Aktivitas Buka --}}
                                    <div
                                        class="grid grid-cols-2 gap-2 rounded-2xl bg-ivory/80 p-3 ring-1 ring-champagne/20">
                                        <div class="space-y-1 min-w-0">
                                            <p class="text-[10px] font-semibold uppercase tracking-wider text-charcoal/45">
                                                Status</p>
                                            <template x-if="tamu.sudah_dibuka">
                                                <span
                                                    class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-700 ring-1 ring-emerald-200/80">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                    <span>Sudah Dibuka</span>
                                                </span>
                                            </template>
                                            <template x-if="!tamu.sudah_dibuka && tamu.sudah_dikirim">
                                                <span
                                                    class="inline-flex items-center gap-1.5 rounded-full bg-sage/10 px-2.5 py-0.5 text-[11px] font-semibold text-sage ring-1 ring-sage/20">
                                                    <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2.6" stroke-linecap="round"
                                                        stroke-linejoin="round" aria-hidden="true">
                                                        <path d="M20 6 9 17l-5-5" />
                                                    </svg>
                                                    <span>Terkirim</span>
                                                </span>
                                            </template>
                                            <template x-if="!tamu.sudah_dibuka && !tamu.sudah_dikirim">
                                                <span
                                                    class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-0.5 text-[11px] font-semibold text-amber-800 ring-1 ring-amber-200/80">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                                    <span>Belum Dikirim</span>
                                                </span>
                                            </template>
                                        </div>

                                        <div class="space-y-0.5 min-w-0 border-l border-champagne/25 pl-3">
                                            <p class="text-[10px] font-semibold uppercase tracking-wider text-charcoal/45">
                                                Aktivitas</p>
                                            <template x-if="tamu.sudah_dibuka">
                                                <div>
                                                    <p class="text-xs font-bold text-emerald-700 tabular-nums leading-snug"
                                                        x-text="'Dibuka ' + tamu.jumlah_dibuka + 'x'"></p>
                                                    <p x-show="tamu.dibuka_pada_label"
                                                        class="text-[10.5px] text-charcoal/50 truncate"
                                                        x-text="tamu.dibuka_pada_label"></p>
                                                </div>
                                            </template>
                                            <template x-if="!tamu.sudah_dibuka && tamu.sudah_dikirim">
                                                <div>
                                                    <p class="text-xs font-semibold text-charcoal/75 leading-snug">Belum
                                                        dibuka</p>
                                                    <p x-show="tamu.dikirim_pada_label"
                                                        class="text-[10.5px] text-charcoal/45 truncate"
                                                        x-text="'Kirim ' + tamu.dikirim_pada_label"></p>
                                                </div>
                                            </template>
                                            <template x-if="!tamu.sudah_dibuka && !tamu.sudah_dikirim">
                                                <p class="text-xs text-charcoal/50 leading-snug"
                                                    x-text="tamu.nomor_wa ? 'Siap kirim WA' : 'Pilih kontak WA'"></p>
                                            </template>
                                        </div>
                                    </div>

                                    {{-- Footer Aksi Kartu (Seimbang Rata Tengah) --}}
                                    <div class="grid grid-cols-2 gap-2">
                                        @if ($undanganSiapDisebar)
                                            <button type="button" @click="salinPesan(tamu)"
                                                class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-champagne/45 bg-ivory/50 px-3 py-2.5 text-xs font-semibold text-charcoal/85 hover:bg-ivory hover:text-charcoal active:scale-[0.98] transition cursor-pointer">
                                                <svg class="h-3.5 w-3.5 text-sage shrink-0" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <rect width="14" height="14" x="8" y="8" rx="2"
                                                        ry="2" />
                                                    <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2" />
                                                </svg>
                                                <span x-text="tamu.tersalin ? 'Tersalin!' : 'Salin Pesan'"></span>
                                            </button>
                                            <a :href="tamu.waUrl" target="_blank" rel="noopener"
                                                @click="tandaiKirimSaatKlikWa(tamu)"
                                                :class="tamu.sudah_dikirim ?
                                                    'border border-sage/35 bg-sage/10 text-sage hover:bg-sage hover:text-white' :
                                                    'bg-sage text-white hover:bg-[#3A4F45] shadow-2xs'"
                                                class="inline-flex items-center justify-center gap-1.5 rounded-xl px-3 py-2.5 text-xs font-semibold active:scale-[0.98] transition">
                                                <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" aria-hidden="true">
                                                    <path d="m22 2-7 20-4-9-9-4Z" />
                                                    <path d="M22 2 11 13" />
                                                </svg>
                                                <span x-text="tamu.sudah_dikirim ? 'Kirim Lagi' : 'Kirim WA'"></span>
                                            </a>
                                        @else
                                            <button type="button" disabled
                                                class="rounded-xl border border-charcoal/15 bg-charcoal/5 px-3 py-2.5 text-xs font-semibold text-charcoal/40 cursor-not-allowed">
                                                Salin Pesan
                                            </button>
                                            <button type="button" disabled
                                                class="rounded-xl bg-charcoal/12 px-3 py-2.5 text-xs font-semibold text-charcoal/45 cursor-not-allowed">
                                                Kirim WA
                                            </button>
                                        @endif
                                    </div>
                                </article>
                            </template>
                        </div>

                        {{-- Footer Paginasi Kartu --}}
                        <div x-show="daftarTersaring().length > 0"
                            class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-1">
                            <p class="text-xs text-charcoal/55 tabular-nums" x-text="ringkasanRentang()"></p>

                            <div x-show="totalHalaman() > 1" x-cloak class="inline-flex items-center gap-1.5">
                                <button type="button" @click="halaman = Math.max(1, halamanAman() - 1)"
                                    :disabled="halamanAman() <= 1"
                                    class="rounded-xl border border-champagne/35 bg-white px-3 py-1.5 text-xs font-semibold text-charcoal/80 hover:bg-ivory disabled:opacity-40 disabled:cursor-not-allowed cursor-pointer transition">
                                    Sebelumnya
                                </button>
                                <span class="px-2.5 text-xs font-semibold text-charcoal tabular-nums"
                                    x-text="halamanAman() + ' / ' + totalHalaman()"></span>
                                <button type="button" @click="halaman = Math.min(totalHalaman(), halamanAman() + 1)"
                                    :disabled="halamanAman() >= totalHalaman()"
                                    class="rounded-xl border border-champagne/35 bg-white px-3 py-1.5 text-xs font-semibold text-charcoal/80 hover:bg-ivory disabled:opacity-40 disabled:cursor-not-allowed cursor-pointer transition">
                                    Berikutnya
                                </button>
                            </div>
                        </div>
                    </section>

                    {{-- Floating Menu Aksi Kartu Tamu --}}
                    <div x-show="menuTamu !== null" x-cloak x-transition.opacity.duration.100ms
                        @click.away="menuTamu = null"
                        :style="{ top: menuStyle.top, bottom: menuStyle.bottom, right: menuStyle.right }"
                        class="fixed z-50 w-52 rounded-2xl bg-white p-1.5 shadow-xl ring-1 ring-champagne/35 text-left">
                        <button type="button" @click="salinLinkSaja(menuTamu)"
                            class="w-full rounded-xl px-3 py-2 text-xs font-medium text-charcoal/85 hover:bg-ivory text-left transition cursor-pointer">
                            Salin Link Saja
                        </button>
                        <button type="button"
                            @click="const t = menuTamu; menuTamu = null; setStatusKirim(t, !t?.sudah_dikirim)"
                            class="w-full rounded-xl px-3 py-2 text-xs font-medium text-charcoal/85 hover:bg-ivory text-left transition cursor-pointer"
                            x-text="menuTamu?.sudah_dikirim ? 'Tandai Belum Dikirim' : 'Tandai Sudah Dikirim'"></button>
                        <button type="button" @click="bukaModalEdit(menuTamu)"
                            class="w-full rounded-xl px-3 py-2 text-xs font-medium text-charcoal/85 hover:bg-ivory text-left transition cursor-pointer">
                            Edit Nama &amp; No. WA
                        </button>
                        <div class="my-1 border-t border-champagne/20"></div>
                        <form :action="menuTamu?.url_hapus || '#'" method="POST" data-swal-title="Hapus Tamu?"
                            :data-swal-confirm="'Tamu ' + (menuTamu?.nama_tamu || '') +
                            ' akan dihapus dari daftar beserta riwayat status kirim & bukanya.'"
                            data-swal-icon="warning" data-swal-confirm-button="Ya, Hapus"
                            data-swal-confirm-color="#DC2626" data-swal-loading-title="Menghapus Tamu..."
                            data-swal-loading-text="Menghapus tamu dari daftar...">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full rounded-xl px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 text-left transition cursor-pointer">
                                Hapus Tamu
                            </button>
                        </form>
                    </div>

                    {{-- MODAL TAMBAH TAMU (SATUAN / IMPORT BANYAK) --}}
                    <div x-show="modalTambah" x-cloak x-transition.opacity
                        class="fixed inset-0 z-50 bg-charcoal/50 backdrop-blur-xs flex items-end sm:items-center justify-center p-0 sm:p-4">
                        <div @click.away="if (!window.Swal?.isVisible() && !$event.target?.closest('.swal2-container')) modalTambah = false"
                            class="w-full sm:max-w-lg rounded-t-[1.75rem] sm:rounded-[1.75rem] bg-white p-5 sm:p-6 shadow-2xl ring-1 ring-champagne/30 space-y-4">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <h2 class="font-sans text-lg font-bold text-charcoal tracking-tight">Tambah Tamu
                                        Undangan</h2>
                                    <p class="text-xs text-charcoal/60">Tamu otomatis mendapat link personal &amp;
                                        pelacakan buka.</p>
                                </div>
                                <button type="button" @click="modalTambah = false" aria-label="Tutup modal"
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-ivory text-charcoal/60 hover:text-charcoal cursor-pointer">
                                    &times;
                                </button>
                            </div>

                            <div class="grid grid-cols-2 rounded-xl bg-ivory p-1 ring-1 ring-champagne/25">
                                <button type="button" @click="modeTambah = 'satuan'"
                                    :class="modeTambah === 'satuan' ? 'bg-white text-sage shadow-xs' :
                                        'text-charcoal/65 hover:text-charcoal'"
                                    class="rounded-lg py-2 text-xs font-semibold transition cursor-pointer">
                                    Tambah 1 Tamu
                                </button>
                                <button type="button" @click="modeTambah = 'massal'"
                                    :class="modeTambah === 'massal' ? 'bg-white text-sage shadow-xs' :
                                        'text-charcoal/65 hover:text-charcoal'"
                                    class="rounded-lg py-2 text-xs font-semibold transition cursor-pointer">
                                    Import Banyak
                                </button>
                            </div>

                            {{-- Form 1 Tamu --}}
                            <form x-show="modeTambah === 'satuan'"
                                action="{{ route('dashboard.tamu.simpan', $undangan) }}" method="POST" class="space-y-4"
                                data-swal-loading data-swal-loading-title="Menyimpan Tamu..."
                                data-swal-loading-text="Menambahkan tamu ke daftar undangan...">
                                @csrf
                                <input type="hidden" name="mode" value="satuan">
                                <div>
                                    <label for="modal_nama_tamu"
                                        class="block text-xs font-semibold text-charcoal/80 mb-1">
                                        Nama Tamu <span class="text-red-500">*</span>
                                    </label>
                                    <input id="modal_nama_tamu" type="text" name="nama_tamu"
                                        value="{{ old('mode') === 'satuan' ? old('nama_tamu') : '' }}" required
                                        maxlength="120" placeholder="Contoh: Budi Santoso / Keluarga Bpk. Hendra"
                                        class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2.5 text-sm text-charcoal focus:border-sage focus:bg-white focus:outline-none">
                                </div>
                                <div>
                                    <label for="modal_nomor_wa" class="block text-xs font-semibold text-charcoal/80 mb-1">
                                        Nomor WhatsApp <span class="font-normal text-charcoal/50">(Opsional)</span>
                                    </label>
                                    <input id="modal_nomor_wa" type="tel" inputmode="tel" name="nomor_wa"
                                        value="{{ old('mode') === 'satuan' ? old('nomor_wa') : '' }}" maxlength="30"
                                        placeholder="Contoh: 081234567890"
                                        class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2.5 text-sm text-charcoal focus:border-sage focus:bg-white focus:outline-none">
                                    <p class="mt-1.5 text-[11px] text-charcoal/55">
                                        Diisi &rarr; klik Kirim WA langsung membuka chat tamu. Kosong &rarr; pilih kontak di
                                        WhatsApp.
                                    </p>
                                </div>
                                <div class="flex items-center justify-end gap-2 pt-1">
                                    <button type="button" @click="modalTambah = false"
                                        class="rounded-xl bg-ivory px-4 py-2.5 text-xs font-semibold text-charcoal/75 hover:bg-champagne/15 cursor-pointer">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="rounded-xl bg-sage px-5 py-2.5 text-xs sm:text-sm font-semibold text-white hover:bg-[#3b5047] cursor-pointer">
                                        Simpan Tamu
                                    </button>
                                </div>
                            </form>

                            {{-- Form Import Banyak --}}
                            <form x-show="modeTambah === 'massal'" x-cloak
                                action="{{ route('dashboard.tamu.simpan', $undangan) }}" method="POST" class="space-y-4"
                                data-swal-loading data-swal-loading-title="Menyimpan Daftar Tamu..."
                                data-swal-loading-text="Menambahkan semua tamu ke daftar undangan...">
                                @csrf
                                <input type="hidden" name="mode" value="massal">
                                <div>
                                    <label for="modal_daftar_bulk"
                                        class="block text-xs font-semibold text-charcoal/80 mb-1">
                                        Daftar Tamu (1 tamu per baris)
                                    </label>
                                    <textarea id="modal_daftar_bulk" name="daftar_bulk" rows="5" required
                                        placeholder="Budi Santoso, 081234567890&#10;Siti Aminah &amp; Partner, 085612345678&#10;Keluarga Bpk. Hendra"
                                        class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2.5 text-sm font-mono text-charcoal focus:border-sage focus:bg-white focus:outline-none">{{ old('mode') === 'massal' ? old('daftar_bulk') : '' }}</textarea>
                                    <p class="mt-1.5 text-[11px] text-charcoal/55">
                                        Pisahkan nama &amp; nomor WA dengan koma (opsional) atau tempel langsung dari
                                        Excel/Sheets. Maks. 200 baris.
                                    </p>
                                </div>
                                <div class="flex items-center justify-end gap-2 pt-1">
                                    <button type="button" @click="modalTambah = false"
                                        class="rounded-xl bg-ivory px-4 py-2.5 text-xs font-semibold text-charcoal/75 hover:bg-champagne/15 cursor-pointer">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="rounded-xl bg-sage px-5 py-2.5 text-xs sm:text-sm font-semibold text-white hover:bg-[#3b5047] cursor-pointer">
                                        Simpan Daftar Tamu
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- MODAL EDIT TAMU --}}
                    <div x-show="modalEdit" x-cloak x-transition.opacity
                        class="fixed inset-0 z-50 bg-charcoal/50 backdrop-blur-xs flex items-end sm:items-center justify-center p-0 sm:p-4">
                        <div @click.away="if (!window.Swal?.isVisible() && !$event.target?.closest('.swal2-container')) tutupModalEdit()"
                            class="w-full sm:max-w-md rounded-t-[1.75rem] sm:rounded-[1.75rem] bg-white p-5 sm:p-6 shadow-2xl ring-1 ring-champagne/30 space-y-4">
                            <div class="flex items-center justify-between gap-3">
                                <h2 class="font-sans text-lg font-bold text-charcoal tracking-tight">Edit Data Tamu</h2>
                                <button type="button" @click="tutupModalEdit()" aria-label="Tutup modal edit"
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-ivory text-charcoal/60 hover:text-charcoal cursor-pointer">
                                    &times;
                                </button>
                            </div>

                            <div class="space-y-3.5">
                                <div>
                                    <label class="block text-xs font-semibold text-charcoal/80 mb-1">Nama Tamu <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" x-model="editNama" maxlength="120"
                                        @keydown.enter.prevent="simpanEdit()"
                                        class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2.5 text-sm text-charcoal focus:border-sage focus:bg-white focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-charcoal/80 mb-1">Nomor WhatsApp <span
                                            class="font-normal text-charcoal/50">(Opsional)</span></label>
                                    <input type="tel" inputmode="tel" x-model="editWa" maxlength="30"
                                        placeholder="Contoh: 081234567890" @keydown.enter.prevent="simpanEdit()"
                                        class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2.5 text-sm text-charcoal focus:border-sage focus:bg-white focus:outline-none">
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-2 pt-1">
                                <button type="button" @click="tutupModalEdit()"
                                    class="rounded-xl bg-ivory px-4 py-2.5 text-xs font-semibold text-charcoal/75 hover:bg-champagne/15 cursor-pointer">
                                    Batal
                                </button>
                                <button type="button" @click="simpanEdit()" :disabled="sedangSimpanEdit"
                                    class="rounded-xl bg-sage px-5 py-2.5 text-xs sm:text-sm font-semibold text-white hover:bg-[#3b5047] disabled:opacity-60 cursor-pointer"
                                    x-text="sedangSimpanEdit ? 'Menyimpan...' : 'Simpan Perubahan'"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
