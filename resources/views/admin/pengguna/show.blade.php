@extends('admin.kerangka')

@section('judul', 'Detail Pengguna: '.$pengguna->nama.' — Admin SesiTemu')

@section('isi_admin')
@php
    $waBersih = preg_replace('/[^0-9]/', '', (string) $pengguna->nomor_wa);
    if ($waBersih && str_starts_with($waBersih, '0')) {
        $waBersih = '62'.substr($waBersih, 1);
    }
    $totalTransaksiLunas = (int) $pengguna->transaksi->where('status', 'lunas')->sum('total_bayar');
@endphp

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <a href="{{ route('admin.pengguna.index') }}" class="text-xs font-semibold text-sage hover:underline">← Kembali ke Daftar Pengguna</a>
        <h1 class="mt-1 font-serif text-2xl sm:text-3xl font-bold text-charcoal">Detail Pengguna</h1>
    </div>

    <div class="flex flex-wrap items-center gap-2">
        @if ($waBersih)
            <a
                href="https://wa.me/{{ $waBersih }}?text={{ urlencode('Halo Kak '.$pengguna->nama.', kami dari tim SesiTemu siap membantu Anda.') }}"
                target="_blank"
                rel="noopener"
                class="inline-flex items-center gap-1.5 rounded-xl bg-sage/10 border border-sage/30 px-4 py-2 text-sm font-semibold text-sage hover:bg-sage/20 transition"
            >
                <span>Chat WhatsApp</span>
            </a>
        @endif

        <a
            href="{{ route('admin.pengguna.index', ['edit' => $pengguna->id]) }}"
            class="inline-flex items-center gap-1.5 rounded-xl bg-champagne px-4 py-2 text-sm font-semibold text-charcoal hover:bg-champagne/90 transition"
        >
            <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/>
            </svg>
            <span>Edit &amp; Reset Sandi</span>
        </a>
    </div>
</div>

{{-- Kartu Info Akun --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/20">
        <div class="flex flex-wrap items-start justify-between gap-4 pb-4 border-b border-champagne/20">
            <div>
                <h2 class="text-xl font-bold text-charcoal">{{ $pengguna->nama }}</h2>
                <p class="text-sm text-charcoal/70 mt-0.5">{{ $pengguna->email }}</p>
            </div>
            @if ($pengguna->peran === 'admin')
                <span class="rounded-full bg-charcoal px-3 py-1 text-xs font-semibold text-champagne">Administrator</span>
            @else
                <span class="rounded-full bg-sage/15 px-3 py-1 text-xs font-semibold text-sage">Client</span>
            @endif
        </div>

        <dl class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div>
                <dt class="text-xs text-charcoal/55">Nomor WhatsApp</dt>
                <dd class="font-medium font-mono text-charcoal mt-0.5">{{ $pengguna->nomor_wa ?: '-' }}</dd>
            </div>
            <div>
                <dt class="text-xs text-charcoal/55">Tanggal Terdaftar</dt>
                <dd class="font-medium text-charcoal mt-0.5">{{ $pengguna->created_at?->translatedFormat('d M Y, H:i') ?? '-' }}</dd>
            </div>
        </dl>
    </div>

    <div class="rounded-2xl bg-charcoal text-ivory p-6 shadow-sm flex flex-col justify-between space-y-4">
        <div>
            <p class="text-xs uppercase tracking-widest text-champagne font-semibold">Ringkasan Aktivitas</p>
            <div class="mt-4 grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-ivory/65">Jumlah Undangan</p>
                    <p class="text-2xl font-bold text-white mt-0.5">{{ $pengguna->undangan->count() }}</p>
                </div>
                <div>
                    <p class="text-xs text-ivory/65">Total Transaksi Lunas</p>
                    <p class="text-lg font-bold text-champagne mt-0.5">{{ \App\Models\Tema::formatRupiah($totalTransaksiLunas) }}</p>
                </div>
            </div>
        </div>
        <p class="text-xs text-ivory/65">Semua data undangan &amp; invoice terkait akun ini tercantum di bawah.</p>
    </div>
</div>

{{-- Daftar Undangan Milik Pengguna --}}
<div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/20">
    <h2 class="text-base font-bold text-charcoal mb-4">Undangan Milik {{ $pengguna->nama }}</h2>
    <table data-datatable data-page-length="5" data-empty-message="Pengguna ini belum memiliki undangan." class="w-full text-sm">
        <thead>
            <tr class="border-b border-champagne/20 text-left text-xs uppercase text-charcoal/60">
                <th data-no-sort class="py-3 dt-center text-center">Aksi</th>
                <th class="py-3 pr-4">Pasangan &amp; Slug</th>
                <th class="py-3 pr-4">Tema</th>
                <th class="py-3 pr-4">Status &amp; Masa Aktif</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-champagne/15">
            @foreach ($pengguna->undangan as $item)
                @php
                    $urlPublik = Route::has('undangan.tampil') ? route('undangan.tampil', $item->slug) : url('/'.$item->slug);
                @endphp
                <tr>
                    <td class="py-3 dt-center text-center whitespace-nowrap">
                        <div class="inline-flex items-center justify-center gap-1.5">
                            <a href="{{ $urlPublik }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1 rounded-lg border border-charcoal/15 bg-white px-2.5 py-1.5 text-xs font-semibold text-charcoal hover:border-sage/40 hover:text-sage transition">
                                <span>Preview</span>
                            </a>
                            <a href="{{ route('dashboard.undangan.kelola', $item) }}" class="inline-flex items-center gap-1 rounded-lg border border-champagne/50 bg-champagne/10 px-2.5 py-1.5 text-xs font-semibold text-charcoal hover:bg-champagne/25 transition">
                                <span>Edit Isian</span>
                            </a>
                        </div>
                    </td>
                    <td class="py-3 pr-4">
                        <p class="font-semibold text-charcoal">{{ $item->nama_panggilan_pria }} &amp; {{ $item->nama_panggilan_wanita }}</p>
                        <p class="text-xs font-mono text-sage">sesitemu.id/{{ $item->slug }}</p>
                    </td>
                    <td class="py-3 pr-4 text-charcoal/80">{{ $item->tema?->nama_tema ?? '-' }}</td>
                    <td class="py-3 pr-4">
                        @if ($item->sudahKedaluwarsa())
                            <span class="rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-700">Kedaluwarsa</span>
                        @elseif ($item->status_publikasi)
                            <span class="rounded-full bg-sage/15 px-2.5 py-0.5 text-xs font-semibold text-sage">Aktif</span>
                        @else
                            <span class="rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-800">Draft</span>
                        @endif
                        @if ($item->berlaku_sampai)
                            <span class="ml-2 text-xs text-charcoal/60">s.d. {{ $item->berlaku_sampai->translatedFormat('d M Y') }}</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Riwayat Transaksi Milik Pengguna --}}
<div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/20">
    <h2 class="text-base font-bold text-charcoal mb-4">Riwayat Transaksi {{ $pengguna->nama }}</h2>
    <table data-datatable data-page-length="5" data-disable-last-sort="false" data-empty-message="Belum ada riwayat transaksi untuk pengguna ini." class="w-full text-sm">
        <thead>
            <tr class="border-b border-champagne/20 text-left text-xs uppercase text-charcoal/60">
                <th class="py-3 pr-4">Kode Invoice</th>
                <th class="py-3 pr-4">Undangan &amp; Paket</th>
                <th class="py-3 pr-4">Total Bayar</th>
                <th class="py-3 pr-4">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-champagne/15">
            @foreach ($pengguna->transaksi as $trx)
                <tr>
                    <td class="py-3 pr-4 font-mono font-bold text-charcoal">{{ $trx->kode_invoice }}</td>
                    <td class="py-3 pr-4">
                        <p class="font-medium text-charcoal">{{ $trx->labelPaket() }}</p>
                        <p class="text-xs text-charcoal/60">sesitemu.id/{{ $trx->undangan?->slug ?? '-' }}</p>
                    </td>
                    <td class="py-3 pr-4 font-bold text-charcoal">{{ \App\Models\Tema::formatRupiah($trx->total_bayar) }}</td>
                    <td class="py-3 pr-4">
                        <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $trx->status === 'lunas' ? 'bg-sage/15 text-sage' : ($trx->status === 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-800') }}">
                            {{ $trx->labelStatus() }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
