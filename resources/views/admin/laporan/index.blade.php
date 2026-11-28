@extends('admin.kerangka')

@section('judul', 'Laporan & Analitik — Admin SesiTemu')

@section('isi_admin')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h1 class="font-serif text-2xl sm:text-3xl font-bold text-charcoal">Laporan &amp; Analitik Platform</h1>
        <p class="text-sm text-charcoal/70 mt-1">Ringkasan omzet transaksi, performa katalog tema, dan pemantauan masa aktif undangan.</p>
    </div>

    <a
        href="{{ route('admin.laporan.ekspor') }}"
        class="inline-flex items-center justify-center gap-1.5 rounded-xl px-4 py-2 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs bg-charcoal font-semibold text-champagne hover:bg-charcoal/90 transition shrink-0"
    >
        <svg class="h-4 w-4 sm:h-3.5 sm:w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
            <polyline points="7 10 12 15 17 10"/>
            <line x1="12" x2="12" y1="15" y2="3"/>
        </svg>
        <span>Unduh CSV Transaksi</span>
    </a>
</div>

{{-- 4 KPI Keuangan & Platform --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-champagne/20">
        <p class="text-xs font-medium text-charcoal/60">Total Omzet Lunas</p>
        <p class="mt-1.5 text-xl sm:text-2xl font-bold text-charcoal">{{ \App\Models\Tema::formatRupiah($totalOmzet) }}</p>
    </div>
    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-sage/25">
        <p class="text-xs font-medium text-charcoal/60">Omzet Bulan Ini</p>
        <p class="mt-1.5 text-xl sm:text-2xl font-bold text-sage">{{ \App\Models\Tema::formatRupiah($omzetBulanIni) }}</p>
    </div>
    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-amber-200">
        <p class="text-xs font-medium text-charcoal/60">Tagihan Menunggu Lunas</p>
        <p class="mt-1.5 text-xl sm:text-2xl font-bold text-amber-700">{{ \App\Models\Tema::formatRupiah($nominalPending) }}</p>
    </div>
    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-champagne/20">
        <p class="text-xs font-medium text-charcoal/60">Paket Mandiri vs Terima Beres</p>
        <p class="mt-1.5 text-xl sm:text-2xl font-bold text-charcoal">{{ $transaksiMandiri }} / {{ $transaksiTerimaBeres }}</p>
    </div>
</div>

{{-- Tren 6 Bulan & Distribusi Kategori --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/20">
        <h2 class="text-base font-bold text-charcoal mb-1">Tren 6 Bulan Terakhir</h2>
        <p class="text-xs text-charcoal/60 mb-4">Pertumbuhan undangan baru &amp; omzet transaksi lunas per bulan</p>

        @php
            $maksOmzet = max(1, collect($rekapBulanan)->max('omzet'));
        @endphp

        <div class="space-y-3">
            @foreach ($rekapBulanan as $barisBulan)
                @php
                    $persen = (int) round(($barisBulan['omzet'] / $maksOmzet) * 100);
                @endphp
                <div>
                    <div class="flex items-center justify-between text-xs mb-1">
                        <span class="font-semibold text-charcoal">{{ $barisBulan['label'] }}</span>
                        <span class="text-charcoal/70">{{ $barisBulan['undangan'] }} undangan • <strong>{{ \App\Models\Tema::formatRupiah($barisBulan['omzet']) }}</strong></span>
                    </div>
                    <div class="h-2.5 w-full rounded-full bg-ivory overflow-hidden">
                        <div class="h-full rounded-full bg-sage" style="width: {{ max(4, $persen) }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/20">
        <h2 class="text-base font-bold text-charcoal mb-1">Distribusi Kategori Katalog Tema</h2>
        <p class="text-xs text-charcoal/60 mb-4">Total {{ $totalUndangan }} undangan • {{ $totalClient }} client • {{ $totalUcapan }} ucapan tamu</p>

        <div class="space-y-3">
            @foreach ($distribusiKategori as $kategoriItem)
                <div class="flex items-center justify-between rounded-xl border border-champagne/20 bg-ivory/60 px-4 py-3">
                    <div>
                        <p class="text-sm font-bold text-charcoal">{{ $kategoriItem['label'] }}</p>
                        <p class="text-xs text-charcoal/60">{{ $kategoriItem['jumlah_tema'] }} desain tersedia</p>
                    </div>
                    <span class="rounded-full bg-champagne/20 px-3 py-1 text-xs font-bold text-charcoal">
                        {{ $kategoriItem['jumlah_undangan'] }} dipakai
                    </span>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Ranking Tema Terlaris --}}
<div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/20">
    <h2 class="text-base font-bold text-charcoal mb-4">Ranking Tema Terlaris</h2>
    <table data-datatable data-page-length="10" data-disable-last-sort="false" data-empty-message="Belum ada data tema." class="w-full text-sm">
        <thead>
            <tr class="border-b border-champagne/20 text-left text-xs uppercase text-charcoal/60">
                <th class="py-3 pr-4">Nama Tema</th>
                <th class="py-3 pr-4">Kategori</th>
                <th class="py-3 pr-4">Harga Dasar</th>
                <th class="py-3 pr-4 dt-left">Jumlah Undangan</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-champagne/15">
            @foreach ($temaTerlaris as $tema)
                <tr>
                    <td class="py-3 pr-4 font-semibold text-charcoal">{{ $tema->nama_tema }}</td>
                    <td class="py-3 pr-4">{{ $tema->kategoriLabel() }}</td>
                    <td class="py-3 pr-4 font-medium">{{ $tema->hargaFormatted() }}</td>
                    <td class="py-3 pr-4 font-bold text-sage dt-left">{{ $tema->undangan_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Undangan Mendekati / Lewat Kedaluwarsa --}}
<div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/20">
    <h2 class="text-base font-bold text-charcoal mb-1">Undangan Aktif Mendekati / Melewati Kedaluwarsa</h2>
    <p class="text-xs text-charcoal/60 mb-4">Undangan dengan batas berlaku dalam 14 hari ke depan atau sudah lewat</p>

    <table data-datatable data-page-length="5" data-empty-message="Tidak ada undangan yang mendekati kedaluwarsa saat ini." class="w-full text-sm">
        <thead>
            <tr class="border-b border-champagne/20 text-left text-xs uppercase text-charcoal/60">
                <th data-no-sort class="py-3 dt-center text-center">Aksi</th>
                <th class="py-3 pr-4">Undangan</th>
                <th class="py-3 pr-4">Client</th>
                <th class="py-3 pr-4">Tema</th>
                <th class="py-3 pr-4">Berlaku Sampai</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-champagne/15">
            @foreach ($undanganAkanKedaluwarsa as $item)
                <tr>
                    <td class="py-3 dt-center text-center whitespace-nowrap">
                        <a href="{{ route('admin.undangan.index', ['q' => $item->slug]) }}" class="inline-flex items-center gap-1 rounded-lg border border-champagne/50 bg-champagne/10 px-2.5 py-1.5 sm:px-2 sm:py-1 text-xs font-semibold text-charcoal hover:bg-champagne/25">
                            <span>Kelola</span>
                        </a>
                    </td>
                    <td class="py-3 pr-4">
                        <p class="font-semibold text-charcoal">{{ $item->nama_panggilan_pria }} &amp; {{ $item->nama_panggilan_wanita }}</p>
                        <p class="text-xs font-mono text-sage">sesitemu.id/{{ $item->slug }}</p>
                    </td>
                    <td class="py-3 pr-4">{{ $item->pengguna?->nama ?? '-' }}</td>
                    <td class="py-3 pr-4">{{ $item->tema?->nama_tema ?? '-' }}</td>
                    <td class="py-3 pr-4 text-xs font-semibold {{ $item->sudahKedaluwarsa() ? 'text-red-700' : 'text-amber-700' }}">
                        {{ $item->berlaku_sampai?->translatedFormat('d M Y') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
