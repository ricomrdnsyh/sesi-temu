{{-- ACCORDION 8: Pembayaran & Aktivasi --}}
@php
    $biayaTerimaBeresNominal = (int) ($biayaTerimaBeres ?? \App\Support\PengaturanSesiTemu::biayaTerimaBeres());
    $hargaTemaNominal = (int) ($undangan->tema?->hargaNominal() ?? 0);
    $undanganSudahAktifBayar = $undangan->sudahAktifPublik();
    $transaksiMenungguBayar = $undangan->transaksiMenungguVerifikasi();
    $transaksiLunasTerakhir = $undangan->transaksi->firstWhere('status', 'lunas');
    $transaksiTerakhirSemua = $undangan->transaksi->first();
    $bolehAjukanBayar = $undangan->bolehAjukanPembayaran();
    $pesanWaKonfirmasiVerifikasi = $transaksiMenungguBayar
        ? "Halo Admin SesiTemu, saya sudah mengirim bukti transfer untuk invoice {$transaksiMenungguBayar->kode_invoice} (sesitemu.id/{$undangan->slug}). Mohon dibantu verifikasinya."
        : $pesanWaAktivasi;
@endphp
<div
    :class="tab === 'aktivasi' ? 'border-sage/45 ring-1 ring-sage/15 shadow-xs' : 'border-champagne/30 hover:border-champagne/60'"
    class="rounded-2xl border bg-white overflow-hidden transition"
>
    <button
        type="button"
        data-mobile-tab="aktivasi"
        @click="toggleBagian('aktivasi')"
        class="w-full px-4 py-3.5 flex items-center justify-between gap-3 text-left cursor-pointer hover:bg-ivory/50 transition"
    >
        <div class="flex items-center gap-3 min-w-0">
            <svg
                :class="tab === 'aktivasi' ? 'rotate-90 text-sage' : 'text-charcoal/45'"
                class="h-4 w-4 shrink-0 transition-transform duration-200"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
            >
                <path d="m9 18 6-6-6-6"/>
            </svg>
            <svg class="h-4 w-4 text-sage shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <rect width="20" height="14" x="2" y="5" rx="2"/>
                <line x1="2" x2="22" y1="10" y2="10"/>
            </svg>
            <span class="font-sans text-sm font-semibold text-charcoal truncate">Pembayaran &amp; Aktivasi</span>
        </div>
        <span class="rounded-full px-2 py-0.5 text-[10px] font-bold shrink-0 {{ $undanganSudahAktifBayar ? 'bg-emerald-50 text-emerald-700' : ($transaksiMenungguBayar ? 'bg-sky-50 text-sky-700' : 'bg-amber-50 text-amber-800') }}">
            {{ $undanganSudahAktifBayar ? 'Lunas' : ($transaksiMenungguBayar ? 'Verifikasi' : 'Belum Aktif') }}
        </span>
    </button>

    <section x-show="tab === 'aktivasi'" x-cloak class="px-4 pb-5 pt-3 border-t border-champagne/20 space-y-5">
        <div class="grid grid-cols-1 gap-4">
            @if ($undanganSudahAktifBayar)
                <div
                    id="form-aktivasi-pembayaran"
                    class="order-1 rounded-[1.5rem] bg-white p-5 sm:p-7 shadow-xs ring-1 ring-emerald-200/80 flex flex-col justify-between gap-5"
                >
                    <div class="space-y-4">
                        <div class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-emerald-700 ring-1 ring-emerald-200">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            <span>Lunas &amp; Aktif</span>
                        </div>

                        <div class="flex items-start gap-3.5">
                            <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 ring-1 ring-emerald-200 shrink-0">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>
                                    <path d="m9 12 2 2 4-4"/>
                                </svg>
                            </span>
                            <div class="space-y-1">
                                <h2 class="font-sans text-lg sm:text-xl font-bold text-charcoal tracking-tight">Undangan Sudah Aktif</h2>
                                <p class="text-xs sm:text-sm text-charcoal/70 leading-relaxed">
                                    Pembayaran telah terverifikasi sehingga pengajuan pembayaran baru dikunci otomatis. Undangan Anda siap disebar ke seluruh tamu.
                                </p>
                            </div>
                        </div>

                        <div class="rounded-2xl bg-ivory/80 p-4 ring-1 ring-champagne/25 space-y-2 text-xs">
                            @if ($undangan->berlaku_sampai)
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-charcoal/65">Masa Aktif Hingga</span>
                                    <span class="font-bold text-sage">{{ $undangan->berlaku_sampai->locale('id')->translatedFormat('d F Y') }}</span>
                                </div>
                            @endif
                            @if ($transaksiLunasTerakhir)
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-charcoal/65">Invoice Terverifikasi</span>
                                    <span class="font-mono font-bold text-charcoal">{{ $transaksiLunasTerakhir->kode_invoice }}</span>
                                </div>
                            @endif
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-charcoal/65">Link Publik</span>
                                <span class="font-mono font-semibold text-sage truncate">sesitemu.id/{{ $undangan->slug }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        <a
                            href="{{ route('dashboard.undangan.tamu', $undangan) }}"
                            class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-sage px-4 py-3 text-xs sm:text-sm font-semibold text-white hover:bg-[#3b5047] active:scale-[0.98] transition"
                        >
                            <span>Buka Halaman Tamu &amp; RSVP</span>
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                        <a
                            href="{{ $urlPublik }}"
                            target="_blank"
                            class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-champagne/50 bg-ivory px-4 py-3 text-xs sm:text-sm font-semibold text-charcoal hover:bg-champagne/10 active:scale-[0.98] transition"
                        >
                            <span>Buka Undangan Publik</span>
                        </a>
                    </div>
                </div>
            @elseif ($transaksiMenungguBayar)
                <div
                    id="form-aktivasi-pembayaran"
                    class="order-1 rounded-[1.5rem] bg-white p-5 sm:p-7 shadow-xs ring-1 ring-amber-200/80 flex flex-col justify-between gap-5"
                >
                    <div class="space-y-4">
                        <div class="inline-flex items-center gap-2 rounded-full bg-amber-50 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-amber-800 ring-1 ring-amber-200">
                            <span class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span>
                            <span>Menunggu Verifikasi Admin</span>
                        </div>

                        <div class="flex items-start gap-3.5">
                            <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-700 ring-1 ring-amber-200 shrink-0">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                            </span>
                            <div class="space-y-1">
                                <h2 class="font-sans text-lg sm:text-xl font-bold text-charcoal tracking-tight">Bukti Pembayaran Sudah Dikirim</h2>
                                <p class="text-xs sm:text-sm text-charcoal/70 leading-relaxed">
                                    Pengajuan pembayaran Anda sedang dalam antrean verifikasi Admin. Form unggah bukti dikunci sementara agar tidak terjadi duplikasi invoice.
                                </p>
                            </div>
                        </div>

                        <div class="rounded-2xl bg-ivory/80 p-4 ring-1 ring-champagne/25 space-y-2 text-xs">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-charcoal/65">Nomor Invoice</span>
                                <span class="font-mono font-bold text-charcoal">{{ $transaksiMenungguBayar->kode_invoice }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-charcoal/65">Paket &amp; Tema</span>
                                <span class="font-semibold text-charcoal text-right">{{ $transaksiMenungguBayar->labelPaket() }} &bull; {{ $transaksiMenungguBayar->tema?->nama_tema }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-charcoal/65">Total Pembayaran</span>
                                <span class="font-sans tabular-nums font-bold text-sage">{{ \App\Models\Tema::formatRupiah($transaksiMenungguBayar->total_bayar) }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-charcoal/65">Waktu Pengajuan</span>
                                <span class="font-medium text-charcoal/80">{{ $transaksiMenungguBayar->created_at?->locale('id')->translatedFormat('d M Y, H:i') }} WIB</span>
                            </div>
                        </div>

                        <p class="text-[11.5px] text-charcoal/60 leading-relaxed">
                            Jika bukti sebelumnya ditolak Admin karena kurang jelas atau nominal berbeda, formulir unggah bukti akan otomatis terbuka kembali.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        @if ($transaksiMenungguBayar->urlBukti())
                            <button
                                type="button"
                                @click="galeriLightbox = { url: @js($transaksiMenungguBayar->urlBukti()), caption: @js('Bukti Pembayaran — '.$transaksiMenungguBayar->kode_invoice) }"
                                class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-sage/35 bg-sage/10 px-4 py-3 text-xs sm:text-sm font-semibold text-sage hover:bg-sage hover:text-white active:scale-[0.98] transition cursor-pointer"
                            >
                                <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                <span>Lihat Bukti Terkirim</span>
                            </button>
                        @endif
                        <a
                            href="{{ \App\Support\PengaturanSesiTemu::urlWaAdmin($pesanWaKonfirmasiVerifikasi) }}"
                            target="_blank"
                            rel="noopener"
                            class="{{ $transaksiMenungguBayar->urlBukti() ? '' : 'sm:col-span-2' }} inline-flex items-center justify-center gap-1.5 rounded-xl bg-champagne px-4 py-3 text-xs sm:text-sm font-semibold text-charcoal hover:bg-champagne/90 active:scale-[0.98] transition"
                        >
                            <span>Konfirmasi ke WA Admin</span>
                        </a>
                    </div>
                </div>
            @else
                <div
                    id="form-aktivasi-pembayaran"
                    x-data="{
                        paket: @js(old('paket', 'mandiri')),
                        hargaTema: {{ $hargaTemaNominal }},
                        biayaTerimaBeres: {{ $biayaTerimaBeresNominal }},
                        kodePromo: @js((string) old('kode_promo', '')),
                        promoTerapan: null,
                        pesanPromo: '',
                        promoError: false,
                        sedangCekPromo: false,
                        buktiNama: '',
                        buktiUkuran: '',
                        buktiPreviewUrl: null,
                        sedangTarikBukti: false,
                        buktiGalat: '',
                        init() {
                            if (this.kodePromo.trim() !== '') {
                                this.cekPromo(true);
                            }
                        },
                        biayaJasa() {
                            return this.paket === 'terima_beres' ? this.biayaTerimaBeres : 0;
                        },
                        subtotal() {
                            return this.hargaTema + this.biayaJasa();
                        },
                        potonganPromo() {
                            return this.promoTerapan ? Number(this.promoTerapan.potongan_promo || 0) : 0;
                        },
                        totalBayar() {
                            return this.promoTerapan ? Number(this.promoTerapan.total_bayar || 0) : this.subtotal();
                        },
                        perluBukti() {
                            return this.totalBayar() > 0;
                        },
                        formatRp(nilai) {
                            return 'Rp ' + Number(nilai || 0).toLocaleString('id-ID');
                        },
                        ubahKodePromo() {
                            if (this.promoTerapan && this.kodePromo.trim().toUpperCase() !== (this.promoTerapan.kode || '')) {
                                this.promoTerapan = null;
                                this.pesanPromo = '';
                                this.promoError = false;
                            }
                        },
                        async paketBerubah() {
                            if (this.promoTerapan?.kode) {
                                await this.cekPromo(true);
                            }
                        },
                        async cekPromo(otomatis = false) {
                            const kode = this.kodePromo.trim();
                            if (kode === '') {
                                this.promoTerapan = null;
                                this.promoError = !otomatis;
                                this.pesanPromo = otomatis ? '' : 'Masukkan kode voucher terlebih dahulu.';
                                return;
                            }

                            this.sedangCekPromo = true;
                            this.promoError = false;
                            this.pesanPromo = '';

                            try {
                                const token = this.$el.querySelector('input[name=_token]')?.value
                                    || document.querySelector('meta[name=csrf-token]')?.content
                                    || '';

                                const respon = await fetch(@js(route('dashboard.transaksi.cek-promo', $undangan, false)), {
                                    method: 'POST',
                                    credentials: 'same-origin',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json',
                                        'X-CSRF-TOKEN': token,
                                    },
                                    body: JSON.stringify({
                                        paket: this.paket,
                                        kode_promo: kode,
                                    }),
                                });

                                const data = await respon.json();
                                if (!respon.ok || !data.valid) {
                                    this.promoTerapan = null;
                                    this.promoError = true;
                                    this.pesanPromo = data.pesan || 'Kode promo tidak valid atau sudah tidak berlaku.';
                                    return;
                                }

                                this.promoTerapan = data;
                                this.kodePromo = data.kode || kode.toUpperCase();
                                this.promoError = false;
                                this.pesanPromo = data.pesan || 'Voucher berhasil diterapkan.';
                            } catch (_) {
                                this.promoTerapan = null;
                                this.promoError = true;
                                this.pesanPromo = 'Gagal memeriksa kode promo. Silakan coba lagi.';
                            } finally {
                                this.sedangCekPromo = false;
                            }
                        },
                        hapusPromo() {
                            this.kodePromo = '';
                            this.promoTerapan = null;
                            this.pesanPromo = '';
                            this.promoError = false;
                        },
                        terimaFileBukti(file) {
                            this.buktiGalat = '';
                            if (!file) {
                                this.resetBukti();
                                return false;
                            }

                            if (!file.type || !file.type.startsWith('image/')) {
                                this.resetBukti();
                                this.buktiGalat = 'Format file harus berupa gambar (JPG, PNG, atau WebP).';
                                return false;
                            }

                            if (file.size > 4 * 1024 * 1024) {
                                this.resetBukti();
                                this.buktiGalat = 'Ukuran foto bukti melebihi batas maksimal 4 MB.';
                                return false;
                            }

                            if (this.buktiPreviewUrl) {
                                URL.revokeObjectURL(this.buktiPreviewUrl);
                            }

                            this.buktiNama = file.name;
                            this.buktiUkuran = file.size >= 1048576
                                ? (file.size / 1048576).toFixed(2) + ' MB'
                                : Math.max(1, Math.round(file.size / 1024)) + ' KB';
                            this.buktiPreviewUrl = URL.createObjectURL(file);
                            return true;
                        },
                        pilihBukti(event) {
                            const file = event.target.files?.[0];
                            if (!this.terimaFileBukti(file) && event.target) {
                                event.target.value = '';
                            }
                        },
                        saatJatuhBukti(event) {
                            this.sedangTarikBukti = false;
                            const file = event.dataTransfer?.files?.[0];
                            if (!file || !this.$refs.inputBukti) return;

                            if (!this.terimaFileBukti(file)) {
                                return;
                            }

                            const dt = new DataTransfer();
                            dt.items.add(file);
                            this.$refs.inputBukti.files = dt.files;
                        },
                        resetBukti() {
                            if (this.buktiPreviewUrl) {
                                URL.revokeObjectURL(this.buktiPreviewUrl);
                            }
                            this.buktiNama = '';
                            this.buktiUkuran = '';
                            this.buktiPreviewUrl = null;
                            if (this.$refs.inputBukti) {
                                this.$refs.inputBukti.value = '';
                            }
                        }
                    }"
                    class="order-2 lg:order-1 rounded-[1.5rem] bg-white p-4 sm:p-7 shadow-xs ring-1 ring-champagne/25 flex flex-col"
                >
                    <div class="inline-flex self-start items-center gap-2 rounded-full bg-sage/10 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-sage mb-2">
                        <span>Langkah Akhir</span>
                        <span>&bull;</span>
                        <span>Aktivasi</span>
                    </div>
                    <h2 class="font-sans text-lg sm:text-2xl font-bold text-charcoal tracking-tight">Ajukan Pembayaran Aktivasi</h2>
                    <p class="mt-1 text-xs sm:text-sm text-charcoal/65">
                        Masa aktif standar undangan adalah <strong>{{ $durasiAktifBulan ?? 3 }} bulan</strong> sejak diverifikasi lunas oleh Admin.
                    </p>

                    @if ($transaksiTerakhirSemua?->status === 'ditolak')
                        <div class="mt-4 rounded-xl border border-rose-200 bg-rose-50/75 px-3.5 py-2.5 text-xs text-rose-700 leading-relaxed">
                            <p class="font-bold">Pengajuan sebelumnya ({{ $transaksiTerakhirSemua->kode_invoice }}) ditolak Admin.</p>
                            @if ($transaksiTerakhirSemua->catatan_admin)
                                <p class="mt-0.5">Catatan: {{ $transaksiTerakhirSemua->catatan_admin }}</p>
                            @endif
                            <p class="mt-0.5 text-rose-600/90">Silakan periksa kembali nominal dan unggah ulang bukti transfer di bawah ini.</p>
                        </div>
                    @endif

                    <form
                        action="{{ route('dashboard.transaksi.ajukan', $undangan) }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="mt-5 flex-1 flex flex-col justify-between gap-4"
                        @submit="if (perluBukti() && !buktiPreviewUrl) { $event.preventDefault(); buktiGalat = 'Silakan pilih atau seret foto/screenshot bukti transfer terlebih dahulu.'; $el.querySelector('[data-zona-bukti]')?.scrollIntoView({ behavior: 'smooth', block: 'center' }); }"
                        data-swal-loading
                        :data-swal-loading-title="perluBukti() ? 'Mengirim Bukti Pembayaran...' : 'Mengajukan Aktivasi...'"
                        :data-swal-loading-text="perluBukti() ? 'Mengunggah bukti transfer &amp; membuat invoice aktivasi...' : 'Memproses pengajuan voucher aktivasi Anda...'"
                    >
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-charcoal">Paket Layanan</label>
                                <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <label
                                        :class="paket === 'mandiri' ? 'border-sage ring-2 ring-sage/20 bg-sage/5' : 'border-champagne/35 bg-ivory/60 hover:bg-ivory'"
                                        class="flex items-start gap-2.5 rounded-2xl border p-3.5 cursor-pointer transition"
                                    >
                                        <input type="radio" name="paket" value="mandiri" x-model="paket" @change="paketBerubah()" class="mt-1 text-sage accent-[#4B6358]">
                                        <span class="text-xs space-y-0.5">
                                            <span class="block font-bold text-charcoal">Paket Mandiri</span>
                                            <span class="block text-[11px] text-charcoal/55">Isi &amp; atur sendiri lewat editor</span>
                                            @if ($undangan->tema?->adaDiskon())
                                                <span class="inline-block pt-0.5 font-sans tabular-nums text-charcoal/45 line-through mr-1">{{ $undangan->tema->hargaAsliFormatted() }}</span>
                                                <span class="inline-block pt-0.5 font-sans tabular-nums font-bold text-rose-600">{{ $undangan->tema->hargaFormatted() }}</span>
                                            @else
                                                <span class="inline-block pt-0.5 font-sans tabular-nums font-bold text-sage">{{ $undangan->tema?->hargaFormatted() }}</span>
                                            @endif
                                        </span>
                                    </label>
                                    <label
                                        :class="paket === 'terima_beres' ? 'border-sage ring-2 ring-sage/20 bg-sage/5' : 'border-champagne/35 bg-ivory/60 hover:bg-ivory'"
                                        class="flex items-start gap-2.5 rounded-2xl border p-3.5 cursor-pointer transition"
                                    >
                                        <input type="radio" name="paket" value="terima_beres" x-model="paket" @change="paketBerubah()" class="mt-1 text-sage accent-[#4B6358]">
                                        <span class="text-xs space-y-0.5">
                                            <span class="block font-bold text-charcoal">Paket Terima Beres</span>
                                            <span class="block text-[11px] text-charcoal/55">Kirim data via WA, Admin isikan</span>
                                            <span class="inline-block pt-0.5 font-sans tabular-nums font-bold text-sage">{{ $undangan->tema?->hargaTerimaBeresFormatted() }}</span>
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label for="kode_promo" class="block text-sm font-medium text-charcoal">Kode Promo / Voucher (Opsional)</label>
                                <div class="mt-1.5 flex items-stretch gap-2">
                                    <input
                                        id="kode_promo"
                                        type="text"
                                        name="kode_promo"
                                        x-model="kodePromo"
                                        @input="ubahKodePromo()"
                                        @keydown.enter.prevent="cekPromo()"
                                        placeholder="Masukkan kode voucher bila ada"
                                        class="flex-1 min-w-0 rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm uppercase font-mono focus:border-champagne focus:outline-none"
                                    >
                                    <button
                                        type="button"
                                        @click="cekPromo()"
                                        :disabled="sedangCekPromo"
                                        class="shrink-0 rounded-xl border border-sage bg-sage/10 px-4 py-2.5 text-xs font-semibold text-sage hover:bg-sage hover:text-white disabled:opacity-60 transition cursor-pointer"
                                        x-text="sedangCekPromo ? 'Mengecek...' : 'Cek Promo'"
                                    ></button>
                                </div>

                                <div
                                    x-show="pesanPromo"
                                    x-cloak
                                    :class="promoError ? 'text-rose-600' : 'text-emerald-700'"
                                    class="mt-1.5 flex items-center justify-between gap-2 text-xs font-medium"
                                >
                                    <span x-text="pesanPromo"></span>
                                    <button
                                        type="button"
                                        x-show="promoTerapan"
                                        @click="hapusPromo()"
                                        class="shrink-0 font-semibold text-charcoal/60 hover:text-rose-600 underline cursor-pointer"
                                    >
                                        Hapus
                                    </button>
                                </div>

                                @error('kode_promo')
                                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Ringkasan Rincian Biaya Live --}}
                            <div class="rounded-xl border border-champagne/35 bg-ivory/80 p-4 space-y-2 text-xs">
                                <div class="flex items-center justify-between text-charcoal/75">
                                    <span>Harga Tema</span>
                                    <span class="font-semibold text-charcoal" x-text="formatRp(hargaTema)"></span>
                                </div>
                                <div x-show="biayaJasa() > 0" x-cloak class="flex items-center justify-between text-charcoal/75">
                                    <span>Jasa Terima Beres</span>
                                    <span class="font-semibold text-charcoal">+ <span x-text="formatRp(biayaJasa())"></span></span>
                                </div>
                                <div x-show="potonganPromo() > 0" x-cloak class="flex items-center justify-between text-emerald-700">
                                    <span>
                                        Potongan Voucher
                                        <span x-show="promoTerapan?.kode" class="font-mono font-semibold" x-text="'(' + promoTerapan?.kode + ')'"></span>
                                    </span>
                                    <span class="font-semibold">- <span x-text="formatRp(potonganPromo())"></span></span>
                                </div>
                                <div class="pt-2 border-t border-champagne/25 flex items-center justify-between">
                                    <span class="font-bold text-charcoal text-xs sm:text-sm">Total yang Harus Ditransfer</span>
                                    <span
                                        class="font-sans tabular-nums text-lg font-bold tracking-tight text-sage"
                                        x-text="totalBayar() === 0 ? 'Rp 0 (Gratis)' : formatRp(totalBayar())"
                                    ></span>
                                </div>
                            </div>

                            <div data-zona-bukti>
                                <div class="flex items-center justify-between gap-2">
                                    <label for="bukti_pembayaran" class="block text-sm font-medium text-charcoal">
                                        Unggah Bukti Transfer
                                        <span x-show="perluBukti()" class="text-rose-600">*</span>
                                    </label>
                                    <span
                                        x-show="perluBukti()"
                                        class="rounded-full bg-rose-50 px-2.5 py-0.5 text-[11px] font-semibold text-rose-700"
                                    >
                                        Wajib
                                    </span>
                                    <span
                                        x-show="!perluBukti()"
                                        x-cloak
                                        class="rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-700"
                                    >
                                        Tidak Diperlukan (Rp 0)
                                    </span>
                                </div>

                                <input
                                    id="bukti_pembayaran"
                                    x-ref="inputBukti"
                                    type="file"
                                    name="bukti_pembayaran"
                                    accept="image/jpeg,image/png,image/webp,image/*"
                                    :disabled="!perluBukti()"
                                    @change="pilihBukti($event)"
                                    class="sr-only"
                                >

                                <div x-show="perluBukti()" class="mt-2 space-y-2">
                                    <label
                                        for="bukti_pembayaran"
                                        x-show="!buktiPreviewUrl"
                                        @dragover.prevent="sedangTarikBukti = true"
                                        @dragleave.prevent="sedangTarikBukti = false"
                                        @drop.prevent="saatJatuhBukti($event)"
                                        :class="sedangTarikBukti
                                            ? 'border-sage bg-sage/10 scale-[1.01]'
                                            : (buktiGalat ? 'border-rose-400 bg-rose-50/60' : 'border-champagne/60 bg-ivory/75 hover:border-sage/70 hover:bg-ivory')"
                                        class="group relative flex flex-col items-center justify-center text-center rounded-2xl border-2 border-dashed px-5 py-6 cursor-pointer transition-all"
                                    >
                                        <div class="w-12 h-12 rounded-2xl bg-white shadow-xs ring-1 ring-champagne/35 text-sage flex items-center justify-center group-hover:scale-105 group-hover:bg-sage group-hover:text-white transition">
                                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"/>
                                                <path d="M12 15V8"/>
                                                <path d="m9 11 3-3 3 3"/>
                                            </svg>
                                        </div>
                                        <p class="mt-3 text-sm font-semibold text-charcoal">
                                            Pilih atau Seret Foto Bukti Transfer
                                        </p>
                                        <p class="mt-1 text-xs text-charcoal/60 max-w-sm leading-relaxed">
                                            Screenshot m-Banking, ATM, e-Wallet, atau QRIS • JPG/PNG/WebP maks. 4 MB
                                        </p>
                                        <span class="mt-3 inline-flex items-center gap-1.5 rounded-xl bg-white px-4 py-1.5 text-xs font-semibold text-sage ring-1 ring-sage/25 shadow-2xs group-hover:bg-sage group-hover:text-white transition">
                                            Pilih dari Perangkat
                                        </span>
                                    </label>

                                    <div
                                        x-show="buktiPreviewUrl"
                                        x-cloak
                                        class="rounded-2xl border border-sage/35 bg-gradient-to-br from-white via-ivory/60 to-sage/5 p-3.5 shadow-xs flex items-center gap-3.5"
                                    >
                                        <button
                                            type="button"
                                            @click="galeriLightbox = { url: buktiPreviewUrl, caption: 'Bukti Transfer — ' + buktiNama }"
                                            title="Klik untuk memperbesar bukti transfer"
                                            class="group relative w-20 h-24 rounded-xl overflow-hidden border border-champagne/40 bg-charcoal shrink-0 cursor-pointer shadow-xs"
                                        >
                                            <img :src="buktiPreviewUrl" alt="Pratinjau Bukti Transfer" class="w-full h-full object-cover transition duration-300 group-hover:scale-105">
                                            <span class="absolute inset-0 bg-black/35 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-[10px] font-semibold text-white">
                                                Perbesar
                                            </span>
                                        </button>

                                        <div class="flex-1 min-w-0 space-y-1.5">
                                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-emerald-800">
                                                <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <polyline points="20 6 9 17 4 12"/>
                                                </svg>
                                                Bukti Siap Dikirim
                                            </span>
                                            <p class="text-xs font-semibold text-charcoal truncate" x-text="buktiNama"></p>
                                            <p class="text-[11px] text-charcoal/60" x-text="buktiUkuran + ' • Klik gambar untuk perbesar'"></p>

                                            <div class="pt-1 flex flex-wrap items-center gap-2">
                                                <label
                                                    for="bukti_pembayaran"
                                                    class="inline-flex items-center rounded-lg border border-champagne bg-white px-2.5 py-1 text-[11px] font-semibold text-charcoal hover:bg-champagne/10 cursor-pointer transition"
                                                >
                                                    Ganti Foto
                                                </label>
                                                <button
                                                    type="button"
                                                    @click="resetBukti()"
                                                    class="inline-flex items-center rounded-lg border border-rose-200 bg-rose-50 px-2.5 py-1 text-[11px] font-semibold text-rose-700 hover:bg-rose-100 cursor-pointer transition"
                                                >
                                                    Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    x-show="!perluBukti()"
                                    x-cloak
                                    class="mt-2 rounded-xl border border-emerald-200 bg-emerald-50/80 px-4 py-3 text-xs text-emerald-800"
                                >
                                    Total tagihan Anda <strong>Rp 0</strong> setelah diskon voucher. Anda dapat langsung menekan tombol ajukan di bawah tanpa bukti transfer.
                                </div>

                                <p x-show="buktiGalat" x-cloak x-text="buktiGalat" class="mt-1.5 text-xs font-medium text-rose-600"></p>
                                @error('bukti_pembayaran')
                                    <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="w-full rounded-xl bg-sage px-5 py-3 text-sm font-semibold text-white hover:bg-sage/90 cursor-pointer transition">
                            <span x-text="perluBukti() ? 'Kirim Bukti & Ajukan Aktivasi' : 'Ajukan Aktivasi Gratis (Rp 0)'">Kirim Bukti &amp; Ajukan Aktivasi</span>
                        </button>
                    </form>
                </div>
            @endif

            <div
                x-data="{ salinRek: false, salinSlug: false }"
                class="{{ $bolehAjukanBayar ? 'order-1 lg:order-2' : 'order-2 lg:order-2' }} rounded-[1.5rem] bg-white p-4 sm:p-7 shadow-xs ring-1 ring-champagne/25 flex flex-col justify-between gap-4"
            >
                <div class="space-y-4">
                    <div class="flex flex-wrap items-start justify-between gap-2">
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-[#8A6D33]">Tujuan Pembayaran Resmi</p>
                            <h3 class="mt-0.5 font-sans text-lg sm:text-xl font-bold text-charcoal tracking-tight">Transfer ke Rekening Resmi</h3>
                        </div>
                        <span class="inline-flex items-center gap-1 rounded-full bg-sage/10 px-3 py-1 text-[11px] font-semibold text-sage ring-1 ring-sage/25">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/>
                                <path d="m9 12 2 2 4-4"/>
                            </svg>
                            Terverifikasi SesiTemu
                        </span>
                    </div>

                    <div class="rounded-2xl bg-ivory/80 px-4 py-3.5 ring-1 ring-champagne/25">
                        <div class="max-w-[330px] mx-auto w-full">
                            @include('dashboard._kartu-bank-digital', [
                                'tanpaHapus' => true,
                                'namaBank' => $infoRekening['bank'],
                                'nomorRekening' => $infoRekening['rekening'],
                                'atasNama' => $infoRekening['atas_nama'],
                            ])
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        <div class="rounded-xl border border-champagne/30 bg-ivory/75 p-2.5 flex items-center justify-between gap-2">
                            <div class="min-w-0">
                                <p class="text-[10px] font-semibold uppercase tracking-wider text-charcoal/55">No. Rekening</p>
                                <p class="font-mono text-xs sm:text-sm font-bold text-charcoal truncate">{{ $infoRekening['rekening'] }}</p>
                            </div>
                            <button
                                type="button"
                                @click="navigator.clipboard?.writeText(@js($infoRekening['rekening'])); salinRek = true; setTimeout(() => salinRek = false, 2000)"
                                class="shrink-0 rounded-lg border border-champagne bg-white px-2.5 py-1 text-[11px] font-semibold text-charcoal hover:bg-champagne/10 cursor-pointer transition"
                                x-text="salinRek ? 'Tersalin!' : 'Salin'"
                            ></button>
                        </div>

                        <div class="rounded-xl border border-champagne/30 bg-ivory/75 p-2.5 flex items-center justify-between gap-2">
                            <div class="min-w-0">
                                <p class="text-[10px] font-semibold uppercase tracking-wider text-charcoal/55">Berita Acara (Slug)</p>
                                <p class="font-mono text-xs sm:text-sm font-bold text-sage truncate">{{ $undangan->slug }}</p>
                            </div>
                            <button
                                type="button"
                                @click="navigator.clipboard?.writeText(@js($undangan->slug)); salinSlug = true; setTimeout(() => salinSlug = false, 2000)"
                                class="shrink-0 rounded-lg border border-champagne bg-white px-2.5 py-1 text-[11px] font-semibold text-charcoal hover:bg-champagne/10 cursor-pointer transition"
                                x-text="salinSlug ? 'Tersalin!' : 'Salin'"
                            ></button>
                        </div>
                    </div>

                    <div class="rounded-xl bg-ivory/70 border border-champagne/25 p-3.5 space-y-2">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <p class="text-xs font-bold text-charcoal">Langkah Cepat Aktivasi:</p>
                            @if ($undangan->tema)
                                <span class="lg:hidden text-[11px] font-medium text-charcoal/70">
                                    Mandiri <strong class="text-sage">{{ $undangan->tema->hargaFormatted() }}</strong> • Terima Beres <strong class="text-sage">{{ $undangan->tema->hargaTerimaBeresFormatted() }}</strong>
                                </span>
                            @endif
                        </div>
                        <ol class="space-y-1 text-xs text-charcoal/75 leading-snug">
                            <li class="flex items-start gap-2">
                                <span class="mt-0.5 inline-flex h-4 w-4 shrink-0 items-center justify-center rounded-full bg-sage text-[10px] font-bold text-white">1</span>
                                <span>Transfer sesuai total tagihan <span class="lg:hidden">di form bawah</span><span class="hidden lg:inline">di sebelah kiri</span> ke <strong>{{ $infoRekening['bank'] }}</strong> a.n. <strong>{{ $infoRekening['atas_nama'] }}</strong>.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="mt-0.5 inline-flex h-4 w-4 shrink-0 items-center justify-center rounded-full bg-sage text-[10px] font-bold text-white">2</span>
                                <span>Cantumkan slug <span class="font-mono font-semibold text-sage">{{ $undangan->slug }}</span> di berita acara / catatan transfer.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="mt-0.5 inline-flex h-4 w-4 shrink-0 items-center justify-center rounded-full bg-sage text-[10px] font-bold text-white">3</span>
                                <span>Unggah foto bukti transfer <span class="lg:hidden">pada form di bawah</span><span class="hidden lg:inline">di sebelah kiri</span> lalu klik ajukan — Admin segera memverifikasi.</span>
                            </li>
                        </ol>
                        @if (!empty($infoRekening['catatan']))
                            <p class="pt-1.5 border-t border-champagne/20 text-[11px] text-charcoal/65 leading-relaxed">
                                {{ $infoRekening['catatan'] }}
                            </p>
                        @endif

                        @if ($bolehAjukanBayar)
                            <a
                                href="#form-aktivasi-pembayaran"
                                class="lg:hidden mt-1 inline-flex w-full items-center justify-center gap-1.5 rounded-lg bg-sage/10 px-3 py-2 text-xs font-semibold text-sage hover:bg-sage hover:text-white transition"
                            >
                                Sudah Transfer? Lanjut Unggah Bukti &darr;
                            </a>
                        @endif
                    </div>
                </div>

                <div class="pt-3 border-t border-champagne/20 space-y-2">
                    <div class="flex items-center justify-between gap-2 text-xs">
                        <span class="font-medium text-charcoal/70">Butuh bantuan verifikasi lebih cepat?</span>
                        <span class="text-[11px] font-semibold text-sage">WhatsApp Admin</span>
                    </div>
                    <a
                        href="{{ \App\Support\PengaturanSesiTemu::urlWaAdmin($pesanWaAktivasi) }}"
                        target="_blank"
                        rel="noopener"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-champagne px-5 py-3 text-sm font-semibold text-charcoal hover:bg-champagne/90 transition"
                    >
                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                        </svg>
                        Konfirmasi Pembayaran via WhatsApp Admin
                    </a>
                </div>
            </div>
        </div>

        <div class="rounded-2xl bg-ivory/60 p-4 ring-1 ring-champagne/25">
            <h3 class="font-sans text-sm font-bold text-charcoal tracking-tight mb-3">Riwayat Invoice Undangan Ini</h3>

            <div class="space-y-2.5">
                @forelse ($undangan->transaksi as $trx)
                    <div class="rounded-xl bg-white p-3.5 ring-1 ring-champagne/20 space-y-2">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0">
                                <p class="font-mono font-bold text-xs text-charcoal">{{ $trx->kode_invoice }}</p>
                                <p class="text-[11px] text-charcoal/65 truncate">{{ $trx->labelPaket() }} &bull; {{ $trx->tema?->nama_tema }}</p>
                            </div>
                            <span class="rounded-full px-2 py-0.5 text-[10px] font-semibold shrink-0 {{ $trx->status === 'lunas' ? 'bg-sage/15 text-sage' : ($trx->status === 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-800') }}">
                                {{ $trx->labelStatus() }}
                            </span>
                        </div>
                        <p class="font-sans tabular-nums text-sm font-bold text-charcoal">{{ \App\Models\Tema::formatRupiah($trx->total_bayar) }}</p>
                        @if ($trx->catatan_admin)
                            <p class="text-[11px] text-charcoal/65">{{ $trx->catatan_admin }}</p>
                        @endif
                        <div class="pt-0.5">
                            @include('dashboard._aksi-bukti-invoice', ['trx' => $trx, 'mode' => 'mobile'])
                        </div>
                    </div>
                @empty
                    <p class="py-4 text-center text-xs text-charcoal/60">Belum ada invoice pembayaran untuk undangan ini.</p>
                @endforelse
            </div>
        </div>
    </section>
</div>
