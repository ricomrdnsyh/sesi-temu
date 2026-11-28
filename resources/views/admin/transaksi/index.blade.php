@extends('admin.kerangka')

@section('judul', 'Transaksi & Pembayaran — Admin SesiTemu')

@section('isi_admin')
<div x-data="{ modalOrderTerbuka: false }" class="space-y-6">
    {{-- 4 KPI Transaksi --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-champagne/20">
            <p class="text-xs font-medium text-charcoal/60">Total Omzet Lunas</p>
            <p class="mt-1.5 text-xl sm:text-2xl font-bold text-charcoal">{{ \App\Models\Tema::formatRupiah($totalOmzetLunas) }}</p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-amber-200">
            <p class="text-xs font-medium text-charcoal/60">Menunggu Verifikasi</p>
            <p class="mt-1.5 text-2xl font-bold text-amber-700">{{ $jumlahMenungguVerifikasi }}</p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-champagne/20">
            <p class="text-xs font-medium text-charcoal/60">Menunggu Pembayaran</p>
            <p class="mt-1.5 text-2xl font-bold text-charcoal">{{ $jumlahMenungguBayar }}</p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-sage/25">
            <p class="text-xs font-medium text-charcoal/60">Transaksi Lunas</p>
            <p class="mt-1.5 text-2xl font-bold text-sage">{{ $jumlahLunas }}</p>
        </div>
    </div>

    {{-- Form Catat Order Manual --}}
    <div x-show="modalOrderTerbuka" x-cloak class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/30">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-bold text-charcoal">Catat Order / Transaksi Manual</h2>
            <button type="button" @click="modalOrderTerbuka = false" class="text-xs font-semibold text-charcoal/60 hover:text-charcoal cursor-pointer">Tutup ✕</button>
        </div>

        <form
            action="{{ route('admin.transaksi.store') }}"
            method="POST"
            class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4"
            data-swal-loading
            data-swal-loading-title="Menyimpan Order Transaksi..."
            data-swal-loading-text="Sedang menghitung rincian tagihan &amp; membuat invoice..."
        >
            @csrf
            <div>
                <label class="block text-xs font-semibold text-charcoal/75 mb-1">Undangan Client</label>
                <select name="undangan_id" required class="w-full rounded-xl px-3.5 py-2 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60">
                    @foreach ($daftarUndangan as $itemUndangan)
                        <option value="{{ $itemUndangan->id }}">
                            {{ $itemUndangan->nama_panggilan_pria }} &amp; {{ $itemUndangan->nama_panggilan_wanita }} (sesitemu.id/{{ $itemUndangan->slug }}) — {{ $itemUndangan->pengguna?->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-charcoal/75 mb-1">Tema Dipilih</label>
                <select name="tema_id" required class="w-full rounded-xl px-3.5 py-2 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60">
                    @foreach ($daftarTema as $temaItem)
                        <option value="{{ $temaItem->id }}">
                            {{ $temaItem->nama_tema }} ({{ $temaItem->kategoriLabel() }} — {{ $temaItem->hargaFormatted() }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-charcoal/75 mb-1">Paket Layanan</label>
                <select name="paket" required class="w-full rounded-xl px-3.5 py-2 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60">
                    <option value="mandiri">Paket Mandiri (Harga Tema)</option>
                    <option value="terima_beres">Paket Terima Beres (+{{ \App\Models\Tema::formatRupiah(\App\Support\PengaturanSesiTemu::biayaTerimaBeres()) }})</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-charcoal/75 mb-1">Kode Promo (Opsional)</label>
                <select name="kode_promo" class="w-full rounded-xl px-3.5 py-2 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60">
                    <option value="">-- Tanpa Promo --</option>
                    @foreach ($daftarPromo as $promoItem)
                        <option value="{{ $promoItem->kode }}">{{ $promoItem->kode }} — {{ $promoItem->labelDiskon() }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-charcoal/75 mb-1">Catatan Admin (Opsional)</label>
                <input type="text" name="catatan_admin" placeholder="Contoh: Transfer BCA terkonfirmasi via WA" class="w-full rounded-xl px-3.5 py-2 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60">
            </div>

            <div class="flex items-end justify-between gap-3">
                <label class="inline-flex items-center gap-2 text-xs font-semibold text-charcoal cursor-pointer pb-2">
                    <input type="checkbox" name="langsung_lunas" value="1" checked class="rounded border-charcoal/25 text-sage">
                    <span>Langsung Lunas &amp; Aktifkan</span>
                </label>

                <button type="submit" class="rounded-xl px-4 py-2 text-sm sm:rounded-lg sm:px-3.5 sm:py-1.5 sm:text-xs bg-charcoal font-semibold text-champagne hover:bg-charcoal/90 cursor-pointer shrink-0">
                    Simpan Order
                </button>
            </div>
        </form>
    </div>

    {{-- DataTables Daftar Transaksi --}}
    <div class="rounded-2xl bg-white p-5 sm:p-6 shadow-sm ring-1 ring-champagne/20">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 mb-5 border-b border-champagne/20">
            <div>
                <h1 class="text-base sm:text-lg font-bold text-charcoal">Daftar Transaksi &amp; Pembayaran</h1>
                <p class="text-xs text-charcoal/60 mt-0.5">Verifikasi bukti transfer client, catat order manual, dan aktifkan undangan otomatis saat lunas.</p>
            </div>

            <button
                type="button"
                @click="modalOrderTerbuka = !modalOrderTerbuka"
                class="inline-flex items-center justify-center gap-1.5 rounded-xl px-4 py-2 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs bg-sage font-semibold text-white hover:bg-sage/90 cursor-pointer transition shrink-0"
            >
                <svg class="h-4 w-4 sm:h-3.5 sm:w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" x2="12" y1="5" y2="19"/>
                    <line x1="5" x2="19" y1="12" y2="12"/>
                </svg>
                <span>Catat Order Manual</span>
            </button>
        </div>

        {{-- Kotak Filter Data --}}
        <form action="{{ route('admin.transaksi.index') }}" method="GET" class="rounded-xl border border-dashed border-sage/50 bg-ivory/50 p-4 mb-5">
            <div class="flex items-center gap-1.5 text-xs font-bold text-sage mb-3">
                <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M3 4a1 1 0 0 1 1-1h16a1 1 0 0 1 .78 1.625L15 11.85V19a1 1 0 0 1-1.447.894l-4-2A1 1 0 0 1 9 17v-5.15L3.22 4.625A1 1 0 0 1 3 4Z" />
                </svg>
                <span>Filter Data</span>
            </div>

            <div>
                <label for="filter_status_transaksi" class="block text-xs font-medium text-charcoal/75 mb-1.5">Status Pembayaran:</label>
                <select
                    id="filter_status_transaksi"
                    name="status"
                    data-auto-submit
                    class="w-full rounded-xl px-3.5 py-2 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-white"
                >
                    <option value="semua" @selected($status === 'semua')>Semua Status</option>
                    @foreach (\App\Models\Transaksi::STATUS_TERSEDIA as $kode => $label)
                        <option value="{{ $kode }}" @selected($status === $kode)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </form>

        <table data-datatable data-page-length="10" data-empty-message="Belum ada data transaksi tercatat." class="w-full text-sm">
            <thead>
                <tr class="border-b border-champagne/20 text-left text-xs uppercase text-charcoal/60">
                    <th data-no-sort class="py-3 dt-center text-center">Aksi</th>
                    <th class="py-3 pr-4">Invoice &amp; Undangan</th>
                    <th class="py-3 pr-4">Client &amp; Tema</th>
                    <th class="py-3 pr-4">Paket &amp; Promo</th>
                    <th class="py-3 pr-4">Total Bayar</th>
                    <th class="py-3 pr-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-champagne/15">
                @foreach ($daftarTransaksi as $transaksi)
                    <tr>
                        <td class="py-3.5 dt-center text-center whitespace-nowrap">
                            <div class="inline-flex items-center justify-center gap-1.5">
                                @if ($transaksi->urlBukti())
                                    <a
                                        href="{{ $transaksi->urlBukti() }}"
                                        target="_blank"
                                        rel="noopener"
                                        title="Lihat Bukti Pembayaran"
                                        class="inline-flex items-center gap-1 rounded-lg border border-charcoal/15 bg-white px-2.5 py-1.5 sm:px-2 sm:py-1 text-xs font-semibold text-charcoal hover:border-sage/40 hover:text-sage transition"
                                    >
                                        <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                        <span>Bukti</span>
                                    </a>
                                @endif

                                @if ($transaksi->status !== 'lunas')
                                    <form
                                        action="{{ route('admin.transaksi.verifikasi', $transaksi) }}"
                                        method="POST"
                                        data-swal-title="Verifikasi Lunas?"
                                        data-swal-confirm="Tandai invoice {{ $transaksi->kode_invoice }} sebagai Lunas dan aktifkan undangan secara otomatis?"
                                        data-swal-icon="question"
                                        data-swal-confirm-button="Ya, Verifikasi Lunas"
                                        data-swal-confirm-color="#4B6358"
                                        data-swal-loading-title="Memverifikasi Transaksi..."
                                        data-swal-loading-text="Sedang mengaktifkan undangan dan menyimpan status lunas..."
                                    >
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-sage px-2.5 py-1.5 sm:px-2 sm:py-1 text-xs font-semibold text-white hover:bg-sage/90 cursor-pointer transition">
                                            <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M21.801 10A10 10 0 1 1 17 3.335"/>
                                                <path d="m9 11 3 3L22 4"/>
                                            </svg>
                                            <span>Verifikasi</span>
                                        </button>
                                    </form>
                                @endif

                                @if (in_array($transaksi->status, ['menunggu_pembayaran', 'menunggu_verifikasi'], true))
                                    <form
                                        action="{{ route('admin.transaksi.tolak', $transaksi) }}"
                                        method="POST"
                                        data-swal-title="Tolak Pembayaran?"
                                        data-swal-confirm="Invoice {{ $transaksi->kode_invoice }} akan ditandai Ditolak agar client mengunggah ulang bukti transfer."
                                        data-swal-icon="warning"
                                        data-swal-confirm-button="Ya, Tolak"
                                        data-swal-confirm-color="#DC2626"
                                        data-swal-loading-title="Memperbarui Status..."
                                        data-swal-loading-text="Sedang mencatat penolakan transaksi..."
                                    >
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center gap-1 rounded-lg border border-red-200 bg-red-50 px-2.5 py-1.5 sm:px-2 sm:py-1 text-xs font-semibold text-red-700 hover:bg-red-100 cursor-pointer transition">
                                            <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <circle cx="12" cy="12" r="10"/>
                                                <path d="m15 9-6 6"/>
                                                <path d="m9 9 6 6"/>
                                            </svg>
                                            <span>Tolak</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                        <td class="py-3.5 pr-4">
                            <p class="font-mono font-bold text-charcoal">{{ $transaksi->kode_invoice }}</p>
                            <p class="text-xs text-sage">sesitemu.id/{{ $transaksi->undangan?->slug ?? '-' }}</p>
                        </td>
                        <td class="py-3.5 pr-4">
                            <p class="font-medium text-charcoal">{{ $transaksi->pengguna?->nama ?? '-' }}</p>
                            <p class="text-xs text-charcoal/60">{{ $transaksi->tema?->nama_tema ?? '-' }}</p>
                        </td>
                        <td class="py-3.5 pr-4">
                            <p class="font-medium text-charcoal">{{ $transaksi->labelPaket() }}</p>
                            @if ($transaksi->promo)
                                <p class="text-xs text-sage">Promo {{ $transaksi->promo->kode }} (-{{ \App\Models\Tema::formatRupiah($transaksi->potongan_promo) }})</p>
                            @endif
                        </td>
                        <td class="py-3.5 pr-4 font-bold text-charcoal">
                            {{ \App\Models\Tema::formatRupiah($transaksi->total_bayar) }}
                        </td>
                        <td class="py-3.5 pr-4">
                            @php
                                $badgeStatus = match ($transaksi->status) {
                                    'lunas' => 'bg-sage/15 text-sage',
                                    'menunggu_verifikasi' => 'bg-amber-100 text-amber-800',
                                    'ditolak' => 'bg-red-100 text-red-700',
                                    default => 'bg-charcoal/10 text-charcoal/80',
                                };
                            @endphp
                            <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $badgeStatus }}">
                                {{ $transaksi->labelStatus() }}
                            </span>
                            @if ($transaksi->diverifikasi_pada)
                                <p class="mt-1 text-[11px] text-charcoal/55">{{ $transaksi->diverifikasi_pada->translatedFormat('d M Y H:i') }}</p>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
