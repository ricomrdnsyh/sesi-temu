@extends('admin.tata-letak')

@section('judul', 'Manajemen Undangan — Admin SesiTemu')

@section('isi_admin')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="font-serif text-3xl font-bold text-charcoal">Manajemen &amp; Aktivasi Undangan</h1>
        <p class="text-sm text-charcoal/70 mt-1">Aktifkan undangan client selama 3 bulan atau bantu edit untuk Paket Terima Beres.</p>
    </div>

    <form action="{{ route('admin.undangan.index') }}" method="GET" class="flex flex-wrap gap-2">
        <input
            type="text"
            name="q"
            value="{{ $pencarian }}"
            placeholder="Cari slug atau nama client..."
            class="rounded-xl border border-charcoal/15 bg-white px-4 py-2 text-sm focus:border-champagne focus:outline-none"
        >
        <select name="status" class="rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm">
            <option value="semua" @selected($status === 'semua')>Semua Status</option>
            <option value="draft" @selected($status === 'draft')>Draft</option>
            <option value="aktif" @selected($status === 'aktif')>Aktif</option>
            <option value="kedaluwarsa" @selected($status === 'kedaluwarsa')>Kedaluwarsa</option>
        </select>
        <button type="submit" class="rounded-xl bg-sage px-4 py-2 text-sm font-semibold text-white hover:bg-sage/90 cursor-pointer">
            Filter
        </button>
    </form>
</div>

<div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/20 overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead>
            <tr class="border-b border-champagne/20 text-left text-xs uppercase text-charcoal/60">
                <th class="py-3 pr-4">Undangan &amp; Slug</th>
                <th class="py-3 pr-4">Client</th>
                <th class="py-3 pr-4">Tema</th>
                <th class="py-3 pr-4">Status &amp; Masa Aktif</th>
                <th class="py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-champagne/15">
            @forelse ($daftarUndangan as $undangan)
                @php
                    $urlPublik = Route::has('undangan.tampil') ? route('undangan.tampil', $undangan->slug) : url('/'.$undangan->slug);
                @endphp
                <tr>
                    <td class="py-3.5 pr-4">
                        <p class="font-semibold text-charcoal">{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</p>
                        <a href="{{ $urlPublik }}" target="_blank" class="text-xs font-mono text-sage hover:underline">sesitemu.id/{{ $undangan->slug }}</a>
                    </td>
                    <td class="py-3.5 pr-4">
                        <p class="font-medium text-charcoal">{{ $undangan->pengguna?->nama ?? '-' }}</p>
                        <p class="text-xs text-charcoal/60">{{ $undangan->pengguna?->email }}</p>
                    </td>
                    <td class="py-3.5 pr-4 text-charcoal/80">{{ $undangan->tema?->nama_tema ?? '-' }}</td>
                    <td class="py-3.5 pr-4">
                        @if ($undangan->sudahKedaluwarsa())
                            <span class="rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-700">Kedaluwarsa</span>
                        @elseif ($undangan->status_publikasi)
                            <span class="rounded-full bg-sage/15 px-2.5 py-0.5 text-xs font-semibold text-sage">Aktif</span>
                        @else
                            <span class="rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-800">Draft</span>
                        @endif

                        @if ($undangan->berlaku_sampai)
                            <p class="mt-1 text-xs text-charcoal/60">s.d. {{ $undangan->berlaku_sampai->translatedFormat('d M Y') }}</p>
                        @endif
                    </td>
                    <td class="py-3.5 text-right">
                        <div class="inline-flex flex-wrap items-center justify-end gap-2">
                            <a href="{{ route('dasbor.undangan.kelola', $undangan) }}" class="rounded-lg border border-champagne px-3 py-1.5 text-xs font-semibold text-charcoal hover:bg-champagne/10">
                                Edit Isian Client
                            </a>

                            @if ($undangan->status_publikasi && ! $undangan->sudahKedaluwarsa())
                                <form action="{{ route('admin.undangan.nonaktifkan', $undangan) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="rounded-lg border border-amber-300 px-3 py-1.5 text-xs font-semibold text-amber-800 hover:bg-amber-50 cursor-pointer">
                                        Nonaktifkan
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.undangan.aktifkan', $undangan) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="rounded-lg bg-sage px-3 py-1.5 text-xs font-semibold text-white hover:bg-sage/90 cursor-pointer">
                                        Aktifkan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-charcoal/60">Tidak ada undangan yang cocok dengan filter.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $daftarUndangan->links() }}
    </div>
</div>
@endsection
