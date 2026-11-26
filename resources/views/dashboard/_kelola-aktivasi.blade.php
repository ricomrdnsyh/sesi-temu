{{-- Modal Checkout Terpusat: Pembayaran & Aktivasi (Ringkas Mobile & 2 Kolom Desktop) --}}
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
    x-show="modalAktivasiTerbuka"
    x-cloak
    data-modal-aktivasi
    @keydown.escape.window="if (modalAktivasiTerbuka && !galeriLightbox && !window.Swal?.isVisible()) { tutupModalAktivasi(); }"
    class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-2 sm:p-4 lg:p-6"
    role="dialog"
    aria-modal="true"
    aria-label="Pembayaran dan Aktivasi Undangan"
>
    {{-- Backdrop Gelap Blur --}}
    <div
        x-show="modalAktivasiTerbuka"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="tutupModalAktivasi()"
        class="fixed inset-0 bg-charcoal/60 backdrop-blur-xs"
    ></div>

    {{-- Panel Modal Checkout --}}
    <div
        x-show="modalAktivasiTerbuka"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-2 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-2 sm:scale-95"
        @click.stop
        class="relative z-10 w-full max-w-4xl max-h-[90dvh] rounded-3xl bg-[#FDFBF7] shadow-[0_30px_90px_-18px_rgba(20,32,26,0.48)] ring-1 ring-champagne/40 overflow-hidden flex flex-col"
    >
        {{-- Header Modal Ringkas --}}
        <div class="bg-white border-b border-champagne/25 px-4 sm:px-5 py-3 flex items-center justify-between gap-2.5 shrink-0">
            <div class="flex items-center gap-2.5 min-w-0">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-[#3B4F45] text-[#F5E3B8] shadow-xs shrink-0">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect width="20" height="14" x="2" y="5" rx="2"/>
                        <line x1="2" x2="22" y1="10" y2="10"/>
                    </svg>
                </span>
                <div class="min-w-0">
                    <div class="flex items-center gap-2">
                        <h2 class="font-sans text-sm sm:text-base font-bold text-charcoal tracking-tight truncate">
                            Pembayaran &amp; Aktivasi
                        </h2>
                        <span class="rounded-full px-2 py-0.5 text-[10px] font-bold shrink-0 {{ $undanganSudahAktifBayar ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' : ($transaksiMenungguBayar ? 'bg-sky-50 text-sky-700 ring-1 ring-sky-200' : 'bg-amber-50 text-amber-800 ring-1 ring-amber-200') }}">
                            {{ $undanganSudahAktifBayar ? 'Aktif' : ($transaksiMenungguBayar ? 'Verifikasi' : 'Belum Aktif') }}
                        </span>
                    </div>
                    <p class="text-[11px] text-charcoal/55 truncate">
                        sesitemu.id/{{ $undangan->slug }} &bull; {{ $undangan->tema?->nama_tema ?? 'Tema Pilihan' }} &bull; Aktif {{ $durasiAktifBulan ?? 3 }} bln
                    </p>
                </div>
            </div>

            <button
                type="button"
                @click="tutupModalAktivasi()"
                aria-label="Tutup modal pembayaran"
                class="inline-flex h-8 w-8 items-center justify-center rounded-xl border border-champagne/35 bg-ivory text-charcoal/70 hover:bg-champagne/15 hover:text-charcoal transition cursor-pointer shrink-0"
            >
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M18 6 6 18"/>
                    <path d="m6 6 12 12"/>
                </svg>
            </button>
        </div>

        {{-- Body Modal Scrollable --}}
        <div class="flex-1 min-h-0 overflow-y-auto p-3.5 sm:p-5 space-y-3.5 sm:space-y-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-3.5 sm:gap-4 items-start">
                @if ($undanganSudahAktifBayar)
                    <div
                        id="form-aktivasi-pembayaran"
                        class="lg:col-span-7 order-1 rounded-2xl bg-white p-4 sm:p-5 shadow-xs ring-1 ring-emerald-200/80 space-y-3.5"
                    >
                        <div class="flex items-start gap-3">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 ring-1 ring-emerald-200 shrink-0">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>
                                    <path d="m9 12 2 2 4-4"/>
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <h3 class="font-sans text-base font-bold text-charcoal tracking-tight">Undangan Sudah Aktif</h3>
                                <p class="mt-0.5 text-xs text-charcoal/65 leading-relaxed">
                                    Pembayaran telah terverifikasi. Undangan siap disebar ke seluruh tamu.
                                </p>
                            </div>
                        </div>

                        <div class="rounded-xl bg-ivory/80 p-3 ring-1 ring-champagne/25 space-y-1.5 text-xs">
                            @if ($undangan->berlaku_sampai)
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-charcoal/60">Masa Aktif Hingga</span>
                                    <span class="font-bold text-sage">{{ $undangan->berlaku_sampai->locale('id')->translatedFormat('d F Y') }}</span>
                                </div>
                            @endif
                            @if ($transaksiLunasTerakhir)
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-charcoal/60">Invoice Terverifikasi</span>
                                    <span class="font-mono font-bold text-charcoal">{{ $transaksiLunasTerakhir->kode_invoice }}</span>
                                </div>
                            @endif
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-charcoal/60">Link Publik</span>
                                <span class="font-mono font-semibold text-sage truncate">sesitemu.id/{{ $undangan->slug }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <a
                                href="{{ route('dashboard.undangan.tamu', $undangan) }}"
                                class="inline-flex items-center justify-center gap-1 rounded-xl bg-sage px-3 py-2.5 text-xs font-semibold text-white hover:bg-[#3b5047] transition"
                            >
                                <span>Daftar Tamu</span>
                                <span aria-hidden="true">&rarr;</span>
                            </a>
                            <a
                                href="{{ $urlPublik }}"
                                target="_blank"
                                class="inline-flex items-center justify-center rounded-xl border border-champagne/50 bg-ivory px-3 py-2.5 text-xs font-semibold text-charcoal hover:bg-champagne/10 transition"
                            >
                                Buka Undangan
                            </a>
                        </div>
                    </div>
                @elseif ($transaksiMenungguBayar)
                    <div
                        id="form-aktivasi-pembayaran"
                        class="lg:col-span-7 order-1 rounded-2xl bg-white p-4 sm:p-5 shadow-xs ring-1 ring-amber-200/80 space-y-3.5"
                    >
                        <div class="flex items-start gap-3">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-700 ring-1 ring-amber-200 shrink-0">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <h3 class="font-sans text-base font-bold text-charcoal tracking-tight">Bukti Pembayaran Sudah Dikirim</h3>
                                <p class="mt-0.5 text-xs text-charcoal/65 leading-relaxed">
                                    Sedang diverifikasi Admin. Form dikunci sementara agar tidak ada duplikasi invoice.
                                </p>
                            </div>
                        </div>

                        <div class="rounded-xl bg-ivory/80 p-3 ring-1 ring-champagne/25 space-y-1.5 text-xs">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-charcoal/60">Nomor Invoice</span>
                                <span class="font-mono font-bold text-charcoal">{{ $transaksiMenungguBayar->kode_invoice }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-charcoal/60">Paket &amp; Tema</span>
                                <span class="font-semibold text-charcoal text-right">{{ $transaksiMenungguBayar->labelPaket() }} &bull; {{ $transaksiMenungguBayar->tema?->nama_tema }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-charcoal/60">Total Pembayaran</span>
                                <span class="font-sans tabular-nums font-bold text-sage">{{ \App\Models\Tema::formatRupiah($transaksiMenungguBayar->total_bayar) }}</span>
                            </div>
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-charcoal/60">Waktu Pengajuan</span>
                                <span class="font-medium text-charcoal/80">{{ $transaksiMenungguBayar->created_at?->locale('id')->translatedFormat('d M Y, H:i') }} WIB</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            @if ($transaksiMenungguBayar->urlBukti())
                                <button
                                    type="button"
                                    @click="galeriLightbox = { url: @js($transaksiMenungguBayar->urlBukti()), caption: @js('Bukti Pembayaran — '.$transaksiMenungguBayar->kode_invoice) }"
                                    class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-sage/35 bg-sage/10 px-3.5 py-2.5 text-xs font-semibold text-sage hover:bg-sage hover:text-white transition cursor-pointer"
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
                                class="{{ $transaksiMenungguBayar->urlBukti() ? '' : 'sm:col-span-2' }} inline-flex items-center justify-center gap-1.5 rounded-xl bg-champagne px-3.5 py-2.5 text-xs font-semibold text-charcoal hover:bg-champagne/90 transition"
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
                        class="lg:col-span-7 order-2 lg:order-1 rounded-2xl bg-white p-3.5 sm:p-5 shadow-xs ring-1 ring-champagne/25 flex flex-col"
                    >
                        @if ($transaksiTerakhirSemua?->status === 'ditolak')
                            <div class="mb-3 rounded-xl border border-rose-200 bg-rose-50/75 px-3 py-2 text-xs text-rose-700 leading-relaxed">
                                <p class="font-bold">Pengajuan {{ $transaksiTerakhirSemua->kode_invoice }} ditolak Admin.</p>
                                @if ($transaksiTerakhirSemua->catatan_admin)
                                    <p class="mt-0.5">Catatan: {{ $transaksiTerakhirSemua->catatan_admin }}</p>
                                @endif
                            </div>
                        @endif

                        <form
                            action="{{ route('dashboard.transaksi.ajukan', $undangan) }}"
                            method="POST"
                            enctype="multipart/form-data"
                            class="space-y-3"
                            @submit="if (perluBukti() && !buktiPreviewUrl) { $event.preventDefault(); buktiGalat = 'Silakan pilih atau seret foto/screenshot bukti transfer terlebih dahulu.'; $el.querySelector('[data-zona-bukti]')?.scrollIntoView({ behavior: 'smooth', block: 'center' }); }"
                            data-swal-loading
                            :data-swal-loading-title="perluBukti() ? 'Mengirim Bukti Pembayaran...' : 'Mengajukan Aktivasi...'"
                            :data-swal-loading-text="perluBukti() ? 'Mengunggah bukti transfer &amp; membuat invoice aktivasi...' : 'Memproses pengajuan voucher aktivasi Anda...'"
                        >
                            @csrf

                            {{-- 1. Pilih Paket (Selalu 2 Kolom Rapi) --}}
                            <div>
                                <label class="block text-xs font-semibold text-charcoal/80">Paket Layanan</label>
                                <div class="mt-1.5 grid grid-cols-2 gap-2">
                                    <label
                                        :class="paket === 'mandiri' ? 'border-sage ring-2 ring-sage/15 bg-sage/5' : 'border-champagne/35 bg-ivory/60 hover:bg-ivory'"
                                        class="flex items-start gap-2 rounded-xl border p-2.5 sm:p-3 cursor-pointer transition"
                                    >
                                        <input type="radio" name="paket" value="mandiri" x-model="paket" @change="paketBerubah()" class="mt-0.5 text-sage accent-[#4B6358] shrink-0">
                                        <span class="text-xs min-w-0 space-y-0.5">
                                            <span class="block font-bold text-charcoal leading-tight">Mandiri</span>
                                            <span class="block text-[10.5px] text-charcoal/55 leading-snug">Edit sendiri</span>
                                            <span class="block pt-0.5 font-sans tabular-nums leading-tight">
                                                @if ($undangan->tema?->adaDiskon())
                                                    <span class="text-[10px] text-charcoal/45 line-through mr-1">{{ $undangan->tema->hargaAsliFormatted() }}</span>
                                                    <span class="font-bold text-rose-600">{{ $undangan->tema->hargaFormatted() }}</span>
                                                @else
                                                    <span class="font-bold text-sage">{{ $undangan->tema?->hargaFormatted() }}</span>
                                                @endif
                                            </span>
                                        </span>
                                    </label>
                                    <label
                                        :class="paket === 'terima_beres' ? 'border-sage ring-2 ring-sage/15 bg-sage/5' : 'border-champagne/35 bg-ivory/60 hover:bg-ivory'"
                                        class="flex items-start gap-2 rounded-xl border p-2.5 sm:p-3 cursor-pointer transition"
                                    >
                                        <input type="radio" name="paket" value="terima_beres" x-model="paket" @change="paketBerubah()" class="mt-0.5 text-sage accent-[#4B6358] shrink-0">
                                        <span class="text-xs min-w-0 space-y-0.5">
                                            <span class="block font-bold text-charcoal leading-tight">Terima Beres</span>
                                            <span class="block text-[10.5px] text-charcoal/55 leading-snug">Admin isikan</span>
                                            <span class="block pt-0.5 font-sans tabular-nums font-bold text-sage leading-tight">{{ $undangan->tema?->hargaTerimaBeresFormatted() }}</span>
                                        </span>
                                    </label>
                                </div>
                            </div>

                            {{-- 2. Kode Promo --}}
                            <div>
                                <label for="kode_promo" class="block text-xs font-semibold text-charcoal/80">Kode Promo / Voucher <span class="font-normal text-charcoal/45">(Opsional)</span></label>
                                <div class="mt-1 flex items-stretch gap-2">
                                    <input
                                        id="kode_promo"
                                        type="text"
                                        name="kode_promo"
                                        x-model="kodePromo"
                                        @input="ubahKodePromo()"
                                        @keydown.enter.prevent="cekPromo()"
                                        placeholder="Masukkan kode voucher"
                                        class="flex-1 min-w-0 rounded-xl border border-charcoal/15 bg-ivory/60 px-3 py-2 text-xs sm:text-sm uppercase font-mono focus:border-champagne focus:outline-none"
                                    >
                                    <button
                                        type="button"
                                        @click="cekPromo()"
                                        :disabled="sedangCekPromo"
                                        class="shrink-0 rounded-xl border border-sage bg-sage/10 px-3.5 py-2 text-xs font-semibold text-sage hover:bg-sage hover:text-white disabled:opacity-60 transition cursor-pointer"
                                        x-text="sedangCekPromo ? 'Cek...' : 'Cek Promo'"
                                    ></button>
                                </div>

                                <div
                                    x-show="pesanPromo"
                                    x-cloak
                                    :class="promoError ? 'text-rose-600' : 'text-emerald-700'"
                                    class="mt-1 flex items-center justify-between gap-2 text-[11px] font-medium"
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

                            {{-- 3. Ringkasan Total Ringkas --}}
                            <div class="rounded-xl border border-champagne/30 bg-ivory/80 px-3 py-2.5 space-y-1 text-xs">
                                <div class="flex items-center justify-between text-charcoal/70">
                                    <span>Harga Tema</span>
                                    <span class="font-semibold text-charcoal tabular-nums" x-text="formatRp(hargaTema)"></span>
                                </div>
                                <div x-show="biayaJasa() > 0" x-cloak class="flex items-center justify-between text-charcoal/70">
                                    <span>Jasa Terima Beres</span>
                                    <span class="font-semibold text-charcoal tabular-nums">+ <span x-text="formatRp(biayaJasa())"></span></span>
                                </div>
                                <div x-show="potonganPromo() > 0" x-cloak class="flex items-center justify-between text-emerald-700">
                                    <span>
                                        Potongan Voucher
                                        <span x-show="promoTerapan?.kode" class="font-mono font-semibold" x-text="'(' + promoTerapan?.kode + ')'"></span>
                                    </span>
                                    <span class="font-semibold tabular-nums">- <span x-text="formatRp(potonganPromo())"></span></span>
                                </div>
                                <div class="pt-1.5 border-t border-champagne/25 flex items-center justify-between gap-2">
                                    <span class="font-bold text-charcoal text-xs">Total yang Harus Ditransfer</span>
                                    <span
                                        class="font-sans tabular-nums text-base font-bold tracking-tight text-sage"
                                        x-text="totalBayar() === 0 ? 'Rp 0 (Gratis)' : formatRp(totalBayar())"
                                    ></span>
                                </div>
                            </div>

                            {{-- 4. Unggah Bukti Transfer (Horizontal Compact) --}}
                            <div data-zona-bukti>
                                <div class="flex items-center justify-between gap-2">
                                    <label for="bukti_pembayaran" class="block text-xs font-semibold text-charcoal/80">
                                        Unggah Bukti Transfer <span x-show="perluBukti()" class="text-rose-600">*</span>
                                    </label>
                                    <span
                                        x-show="perluBukti()"
                                        class="rounded-full bg-rose-50 px-2 py-0.5 text-[10px] font-semibold text-rose-700"
                                    >
                                        Wajib
                                    </span>
                                    <span
                                        x-show="!perluBukti()"
                                        x-cloak
                                        class="rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-semibold text-emerald-700"
                                    >
                                        Gratis (Rp 0)
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

                                <div x-show="perluBukti()" class="mt-1.5">
                                    <label
                                        for="bukti_pembayaran"
                                        x-show="!buktiPreviewUrl"
                                        @dragover.prevent="sedangTarikBukti = true"
                                        @dragleave.prevent="sedangTarikBukti = false"
                                        @drop.prevent="saatJatuhBukti($event)"
                                        :class="sedangTarikBukti
                                            ? 'border-sage bg-sage/[0.06] ring-4 ring-sage/10'
                                            : (buktiGalat ? 'border-rose-400 bg-rose-50/60' : 'border-champagne/60 bg-ivory/75 hover:border-sage/70 hover:bg-white')"
                                        class="group flex flex-col items-center justify-center gap-2 rounded-2xl border-2 border-dashed px-4 py-4 text-center cursor-pointer transition select-none"
                                    >
                                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-sage/10 text-sage group-hover:bg-sage group-hover:text-white transition">
                                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                                <polyline points="17 8 12 3 7 8"/>
                                                <line x1="12" x2="12" y1="3" y2="15"/>
                                            </svg>
                                        </span>
                                        <div>
                                            <p class="text-xs font-semibold text-charcoal">Pilih atau Seret Foto Bukti Transfer</p>
                                            <p class="mt-0.5 text-[11px] text-charcoal/55">Screenshot m-Banking, e-Wallet, atau QRIS • JPG, PNG, WebP maks. 4 MB</p>
                                        </div>
                                        <span class="rounded-lg bg-sage/10 px-3 py-1.5 text-[11px] font-semibold text-sage group-hover:bg-sage group-hover:text-white transition">
                                            Pilih dari Perangkat
                                        </span>
                                    </label>

                                    <div
                                        x-show="buktiPreviewUrl"
                                        x-cloak
                                        class="rounded-xl border border-sage/35 bg-ivory/70 p-2.5 flex items-center gap-3"
                                    >
                                        <button
                                            type="button"
                                            @click="galeriLightbox = { url: buktiPreviewUrl, caption: 'Bukti Transfer — ' + buktiNama }"
                                            title="Klik untuk memperbesar bukti transfer"
                                            class="relative w-14 h-14 rounded-lg overflow-hidden border border-champagne/40 bg-charcoal shrink-0 cursor-pointer"
                                        >
                                            <img :src="buktiPreviewUrl" alt="Pratinjau Bukti Transfer" class="w-full h-full object-cover">
                                        </button>

                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-semibold text-charcoal truncate" x-text="buktiNama"></p>
                                            <p class="text-[10.5px] text-emerald-700 font-medium" x-text="'Siap dikirim • ' + buktiUkuran"></p>
                                            <div class="mt-1 flex items-center gap-1.5">
                                                <label for="bukti_pembayaran" class="rounded-md border border-champagne bg-white px-2 py-0.5 text-[10.5px] font-semibold text-charcoal hover:bg-champagne/10 cursor-pointer transition">Ganti</label>
                                                <button type="button" @click="resetBukti()" class="rounded-md border border-rose-200 bg-rose-50 px-2 py-0.5 text-[10.5px] font-semibold text-rose-700 hover:bg-rose-100 cursor-pointer transition">Hapus</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    x-show="!perluBukti()"
                                    x-cloak
                                    class="mt-1.5 rounded-xl border border-emerald-200 bg-emerald-50/80 px-3 py-2 text-[11px] text-emerald-800"
                                >
                                    Total tagihan <strong>Rp 0</strong> setelah voucher. Langsung klik ajukan tanpa bukti transfer.
                                </div>

                                <p x-show="buktiGalat" x-cloak x-text="buktiGalat" class="mt-1 text-xs font-medium text-rose-600"></p>
                                @error('bukti_pembayaran')
                                    <p class="mt-1 text-xs font-medium text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full rounded-xl bg-sage px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-semibold text-white hover:bg-[#3b5047] active:scale-[0.99] cursor-pointer transition">
                                <span x-text="perluBukti() ? 'Kirim Bukti & Ajukan Aktivasi' : 'Ajukan Aktivasi Gratis (Rp 0)'">Kirim Bukti &amp; Ajukan Aktivasi</span>
                            </button>
                        </form>
                    </div>
                @endif

                {{-- Kolom Tujuan Transfer Ringkas --}}
                <div
                    x-data="{ salinSlug: false }"
                    class="lg:col-span-5 {{ $bolehAjukanBayar ? 'order-1 lg:order-2' : 'order-2 lg:order-2' }} rounded-2xl bg-white p-3.5 sm:p-5 shadow-xs ring-1 ring-champagne/25 space-y-2.5"
                >
                    <div class="flex items-center justify-between gap-2">
                        <h3 class="font-sans text-xs sm:text-sm font-bold text-charcoal tracking-tight">Transfer ke Rekening Resmi</h3>
                        <span class="inline-flex items-center gap-1 rounded-full bg-sage/10 px-2 py-0.5 text-[10px] font-semibold text-sage ring-1 ring-sage/20 shrink-0">
                            <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/>
                                <path d="m9 12 2 2 4-4"/>
                            </svg>
                            Terverifikasi SesiTemu
                        </span>
                    </div>

                    {{-- Kartu Bank Grafis Resmi (Tampil Rapi di Mobile & Desktop) --}}
                    <div class="rounded-2xl bg-ivory/80 p-2.5 sm:p-3 ring-1 ring-champagne/25">
                        <div class="max-w-[285px] sm:max-w-[300px] mx-auto w-full">
                            @include('dashboard._kartu-bank-digital', [
                                'tanpaHapus' => true,
                                'namaBank' => $infoRekening['bank'],
                                'nomorRekening' => $infoRekening['rekening'],
                                'atasNama' => $infoRekening['atas_nama'],
                            ])
                        </div>
                    </div>

                    {{-- Berita Acara (Slug) --}}
                    <div class="rounded-xl border border-champagne/30 bg-ivory/75 px-3 py-2 flex items-center justify-between gap-2">
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

                    {{-- Langkah Singkat (Desktop) --}}
                    <ol class="hidden lg:block rounded-xl bg-ivory/65 border border-champagne/25 p-3 space-y-1.5 text-[11.5px] text-charcoal/75 leading-snug">
                        <li class="flex items-start gap-2">
                            <span class="mt-0.5 inline-flex h-4 w-4 shrink-0 items-center justify-center rounded-full bg-sage text-[9.5px] font-bold text-white">1</span>
                            <span>Transfer sesuai total tagihan ke rekening resmi di atas.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-0.5 inline-flex h-4 w-4 shrink-0 items-center justify-center rounded-full bg-sage text-[9.5px] font-bold text-white">2</span>
                            <span>Cantumkan <span class="font-mono font-semibold text-sage">{{ $undangan->slug }}</span> pada catatan transfer.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-0.5 inline-flex h-4 w-4 shrink-0 items-center justify-center rounded-full bg-sage text-[9.5px] font-bold text-white">3</span>
                            <span>Unggah bukti transfer di sebelah kiri lalu klik kirim.</span>
                        </li>
                    </ol>

                    {{-- Aksi Cepat: Mobile (Unggah + WA Sejajar) / Desktop (WA Penuh) --}}
                    <div class="flex items-center gap-2 pt-0.5">
                        @if ($bolehAjukanBayar)
                            <a
                                href="#form-aktivasi-pembayaran"
                                class="lg:hidden flex-1 inline-flex items-center justify-center gap-1 rounded-xl bg-sage/10 px-3 py-2 text-xs font-semibold text-sage hover:bg-sage hover:text-white transition"
                            >
                                <span>Lanjut Unggah Bukti &darr;</span>
                            </a>
                        @endif
                        <a
                            href="{{ \App\Support\PengaturanSesiTemu::urlWaAdmin($pesanWaAktivasi) }}"
                            target="_blank"
                            rel="noopener"
                            class="{{ $bolehAjukanBayar ? 'shrink-0 lg:flex-1' : 'flex-1' }} inline-flex items-center justify-center gap-1.5 rounded-xl bg-champagne px-3.5 py-2 lg:py-2.5 text-xs font-semibold text-charcoal hover:bg-champagne/90 transition"
                        >
                            <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                            </svg>
                            <span class="lg:hidden">WA Admin</span>
                            <span class="hidden lg:inline">Konfirmasi via WhatsApp Admin</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Riwayat Invoice: Hanya Tampil Jika Sudah Ada Transaksi --}}
            @if ($undangan->transaksi->isNotEmpty())
                <div class="rounded-2xl bg-white p-3.5 sm:p-4 ring-1 ring-champagne/25">
                    <h3 class="font-sans text-xs font-bold uppercase tracking-wider text-charcoal/60 mb-2.5">Riwayat Invoice</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2.5">
                        @foreach ($undangan->transaksi as $trx)
                            <div class="rounded-xl bg-ivory/75 p-3 ring-1 ring-champagne/25 space-y-1.5">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <p class="font-mono font-bold text-xs text-charcoal">{{ $trx->kode_invoice }}</p>
                                        <p class="text-[11px] text-charcoal/60 truncate">{{ $trx->labelPaket() }} &bull; {{ $trx->tema?->nama_tema }}</p>
                                    </div>
                                    <span class="rounded-full px-2 py-0.5 text-[10px] font-semibold shrink-0 {{ $trx->status === 'lunas' ? 'bg-sage/15 text-sage' : ($trx->status === 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-800') }}">
                                        {{ $trx->labelStatus() }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between gap-2">
                                    <p class="font-sans tabular-nums text-xs font-bold text-charcoal">{{ \App\Models\Tema::formatRupiah($trx->total_bayar) }}</p>
                                    @include('dashboard._aksi-bukti-invoice', ['trx' => $trx, 'mode' => 'mobile'])
                                </div>
                                @if ($trx->catatan_admin)
                                    <p class="text-[11px] text-charcoal/65">{{ $trx->catatan_admin }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
