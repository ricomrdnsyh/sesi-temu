@extends('admin.tata-letak')

@section('judul', 'Promo & Voucher — Admin SesiTemu')

@section('isi_admin')
<div>
    <h1 class="font-serif text-2xl sm:text-3xl font-bold text-charcoal">Manajemen Promo &amp; Voucher</h1>
    <p class="text-sm text-charcoal/70 mt-1">Buat kode potongan harga untuk digunakan client saat mengajukan pembayaran aktivasi atau di order manual admin.</p>
</div>

<div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/20">
    <h2 class="text-base font-bold text-charcoal mb-4">Buat Kode Promo Baru</h2>
    <form
        action="{{ route('admin.promo.store') }}"
        method="POST"
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-end"
        data-swal-loading
        data-swal-loading-title="Menyimpan Kode Promo..."
        data-swal-loading-text="Sedang mendaftarkan voucher promo baru..."
    >
        @csrf
        <div>
            <label class="block text-xs font-semibold text-charcoal/75 mb-1">Kode Voucher</label>
            <input type="text" name="kode" required placeholder="Contoh: NIKAHBERKAH" class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm uppercase font-mono">
        </div>
        <div>
            <label class="block text-xs font-semibold text-charcoal/75 mb-1">Nama Promo</label>
            <input type="text" name="nama_promo" required placeholder="Contoh: Promo Akhir Tahun" class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs font-semibold text-charcoal/75 mb-1">Tipe Diskon</label>
            <select name="tipe_diskon" class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm">
                <option value="nominal">Nominal (Rp)</option>
                <option value="persen">Persentase (%)</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-charcoal/75 mb-1">Nilai Diskon</label>
            <input type="number" name="nilai_diskon" min="1" required placeholder="Contoh: 15000 atau 20" class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs font-semibold text-charcoal/75 mb-1">Maksimal Potongan Rp (Jika Persen)</label>
            <input type="number" name="maksimal_diskon" min="1000" placeholder="Opsional" class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs font-semibold text-charcoal/75 mb-1">Kuota Pemakaian</label>
            <input type="number" name="kuota" min="1" placeholder="Kosong = Tanpa batas" class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs font-semibold text-charcoal/75 mb-1">Berlaku Sampai (Opsional)</label>
            <input type="date" name="berlaku_sampai" class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm">
        </div>
        <div>
            <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 rounded-xl bg-sage px-4 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 cursor-pointer">
                <span>+ Buat Kode Promo</span>
            </button>
        </div>
    </form>
</div>

<div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/20">
    <table data-datatable data-page-length="10" data-empty-message="Belum ada kode promo atau voucher terdaftar." class="w-full text-sm">
        <thead>
            <tr class="border-b border-champagne/20 text-left text-xs uppercase text-charcoal/60">
                <th data-no-sort class="py-3 dt-center text-center">Aksi</th>
                <th class="py-3 pr-4">Kode &amp; Nama Promo</th>
                <th class="py-3 pr-4">Nilai Diskon</th>
                <th class="py-3 pr-4 dt-left">Pemakaian / Kuota</th>
                <th class="py-3 pr-4">Masa Berlaku</th>
                <th class="py-3 pr-4">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-champagne/15">
            @foreach ($daftarPromo as $promo)
                <tr>
                    <td class="py-3.5 dt-center text-center whitespace-nowrap">
                        <div class="inline-flex items-center justify-center gap-1.5">
                            <form
                                action="{{ route('admin.promo.toggle', $promo) }}"
                                method="POST"
                                data-swal-title="{{ $promo->aktif ? 'Nonaktifkan Promo?' : 'Aktifkan Promo?' }}"
                                data-swal-confirm="Ubah status keaktifan voucher {{ $promo->kode }}?"
                                data-swal-icon="question"
                                data-swal-confirm-button="Ya, Ubah"
                                data-swal-confirm-color="#4B6358"
                                data-swal-loading-title="Memperbarui Status Promo..."
                            >
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-flex items-center gap-1 rounded-lg border px-2.5 py-1.5 text-xs font-semibold cursor-pointer transition {{ $promo->aktif ? 'border-amber-300 bg-amber-50 text-amber-800 hover:bg-amber-100' : 'border-sage bg-sage text-white hover:bg-sage/90' }}">
                                    <span>{{ $promo->aktif ? 'Nonaktifkan' : 'Aktifkan' }}</span>
                                </button>
                            </form>

                            <form
                                action="{{ route('admin.promo.destroy', $promo) }}"
                                method="POST"
                                data-swal-title="Hapus Voucher?"
                                data-swal-confirm="Yakin ingin menghapus kode promo {{ $promo->kode }}?"
                                data-swal-icon="warning"
                                data-swal-confirm-button="Ya, Hapus"
                                data-swal-confirm-color="#DC2626"
                                data-swal-loading-title="Menghapus Promo..."
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 rounded-lg border border-red-200 bg-red-50 px-2.5 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-100 cursor-pointer transition">
                                    <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M3 6h18"/>
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                    </svg>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </div>
                    </td>
                    <td class="py-3.5 pr-4">
                        <p class="font-mono font-bold text-charcoal">{{ $promo->kode }}</p>
                        <p class="text-xs text-charcoal/65">{{ $promo->nama_promo }}</p>
                    </td>
                    <td class="py-3.5 pr-4 font-semibold text-sage">{{ $promo->labelDiskon() }}</td>
                    <td class="py-3.5 pr-4 font-semibold dt-left">
                        {{ $promo->jumlah_terpakai }} / {{ $promo->kuota ?? '∞' }}
                    </td>
                    <td class="py-3.5 pr-4 text-xs text-charcoal/70">
                        @if ($promo->berlaku_sampai)
                            s.d. {{ $promo->berlaku_sampai->translatedFormat('d M Y') }}
                        @else
                            Tanpa batas waktu
                        @endif
                    </td>
                    <td class="py-3.5 pr-4">
                        @if ($promo->layakDigunakan())
                            <span class="rounded-full bg-sage/15 px-2.5 py-0.5 text-xs font-semibold text-sage">Aktif</span>
                        @else
                            <span class="rounded-full bg-charcoal/10 px-2.5 py-0.5 text-xs font-semibold text-charcoal/70">Nonaktif / Habis</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
