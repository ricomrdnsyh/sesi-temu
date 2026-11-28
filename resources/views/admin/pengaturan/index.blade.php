@extends('admin.kerangka')

@section('judul', 'Pengaturan Platform — Admin SesiTemu')

@section('isi_admin')
<div>
    <h1 class="font-serif text-2xl sm:text-3xl font-bold text-charcoal">Pengaturan Platform SesiTemu</h1>
    <p class="text-sm text-charcoal/70 mt-1">Atur nomor WhatsApp resmi CS, durasi masa aktif default, tarif jasa Terima Beres, dan rekening pembayaran Client.</p>
</div>

<form
    action="{{ route('admin.pengaturan.update') }}"
    method="POST"
    class="w-full space-y-6"
    data-swal-loading
    data-swal-loading-title="Menyimpan Pengaturan..."
    data-swal-loading-text="Sedang menerapkan konfigurasi baru untuk Admin, Beranda, dan Client..."
>
    @csrf
    @method('PUT')

    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/20 space-y-5">
        <h2 class="text-base font-bold text-charcoal border-b border-champagne/20 pb-3">Operasional &amp; Tarif Layanan</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="nomor_wa_admin" class="block text-xs font-semibold text-charcoal/75 mb-1">Nomor WhatsApp Admin (CS)</label>
                <input
                    id="nomor_wa_admin"
                    type="text"
                    name="nomor_wa_admin"
                    required
                    value="{{ old('nomor_wa_admin', $pengaturan['nomor_wa_admin']) }}"
                    placeholder="6281234567890"
                    class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60 font-mono focus:border-champagne focus:outline-none"
                >
                <p class="mt-1 text-[11px] text-charcoal/55">Format 628... (otomatis terhubung ke Beranda &amp; Dashboard Client).</p>
            </div>

            <div>
                <label for="masa_aktif_bulan" class="block text-xs font-semibold text-charcoal/75 mb-1">Masa Aktif Bawaan (Bulan)</label>
                <input
                    id="masa_aktif_bulan"
                    type="number"
                    name="masa_aktif_bulan"
                    min="1"
                    max="36"
                    required
                    value="{{ old('masa_aktif_bulan', $pengaturan['masa_aktif_bulan']) }}"
                    class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60 focus:border-champagne focus:outline-none"
                >
                <p class="mt-1 text-[11px] text-charcoal/55">Dipakai saat aktivasi manual &amp; verifikasi transaksi lunas.</p>
            </div>

            <div>
                <label for="biaya_terima_beres" class="block text-xs font-semibold text-charcoal/75 mb-1">Biaya Jasa Terima Beres (Rp)</label>
                <input
                    id="biaya_terima_beres"
                    type="number"
                    name="biaya_terima_beres"
                    min="0"
                    required
                    value="{{ old('biaya_terima_beres', $pengaturan['biaya_terima_beres']) }}"
                    class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60 focus:border-champagne focus:outline-none"
                >
                <p class="mt-1 text-[11px] text-charcoal/55">Ditambahkan ke harga tema jika client memilih Paket Terima Beres.</p>
            </div>
        </div>
    </div>

    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/20 space-y-5">
        <h2 class="text-base font-bold text-charcoal border-b border-champagne/20 pb-3">Informasi Rekening Pembayaran</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="nama_bank_pembayaran" class="block text-xs font-semibold text-charcoal/75 mb-1">Nama Bank / E-Wallet</label>
                <input
                    id="nama_bank_pembayaran"
                    type="text"
                    name="nama_bank_pembayaran"
                    required
                    value="{{ old('nama_bank_pembayaran', $pengaturan['nama_bank_pembayaran']) }}"
                    class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60 focus:border-champagne focus:outline-none"
                >
            </div>

            <div>
                <label for="nomor_rekening_pembayaran" class="block text-xs font-semibold text-charcoal/75 mb-1">Nomor Rekening</label>
                <input
                    id="nomor_rekening_pembayaran"
                    type="text"
                    name="nomor_rekening_pembayaran"
                    required
                    value="{{ old('nomor_rekening_pembayaran', $pengaturan['nomor_rekening_pembayaran']) }}"
                    class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60 font-mono focus:border-champagne focus:outline-none"
                >
            </div>

            <div>
                <label for="atas_nama_rekening" class="block text-xs font-semibold text-charcoal/75 mb-1">Atas Nama</label>
                <input
                    id="atas_nama_rekening"
                    type="text"
                    name="atas_nama_rekening"
                    required
                    value="{{ old('atas_nama_rekening', $pengaturan['atas_nama_rekening']) }}"
                    class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60 focus:border-champagne focus:outline-none"
                >
            </div>
        </div>

        <div>
            <label for="catatan_pembayaran" class="block text-xs font-semibold text-charcoal/75 mb-1">Petunjuk Pembayaran (Tampil di Dashboard Client)</label>
            <textarea
                id="catatan_pembayaran"
                name="catatan_pembayaran"
                rows="3"
                class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60 focus:border-champagne focus:outline-none"
            >{{ old('catatan_pembayaran', $pengaturan['catatan_pembayaran']) }}</textarea>
        </div>

        <div class="pt-2 flex justify-end">
            <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl px-4 py-2 text-sm sm:rounded-lg sm:px-3.5 sm:py-1.5 sm:text-xs bg-sage font-semibold text-white hover:bg-sage/90 cursor-pointer transition">
                <span>Simpan Pengaturan</span>
            </button>
        </div>
    </div>
</form>
@endsection
