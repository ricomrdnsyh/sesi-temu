@extends('admin.tata-letak')

@section('judul', 'Ringkasan Admin — SesiTemu')

@section('isi_admin')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h1 class="font-serif text-3xl font-bold text-charcoal">Ringkasan Platform SesiTemu</h1>
        <p class="text-sm text-charcoal/70 mt-1">Pantau statistik client, aktivasi undangan, dan pembersihan storage kedaluwarsa.</p>
    </div>

    <form action="{{ route('admin.undangan.bersihkan') }}" method="POST" onsubmit="return confirm('Jalankan pembersihan foto untuk seluruh undangan yang sudah kedaluwarsa?')">
        @csrf
        <button type="submit" class="rounded-xl bg-charcoal px-4 py-2.5 text-sm font-semibold text-champagne hover:bg-charcoal/90 transition cursor-pointer">
            Bersihkan Storage Kedaluwarsa ({{ $totalKedaluwarsa }})
        </button>
    </form>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/20">
        <p class="text-xs font-semibold uppercase tracking-wider text-charcoal/60">Total Client Terdaftar</p>
        <p class="mt-2 font-serif text-4xl font-bold text-charcoal">{{ $totalClient }}</p>
    </div>
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/20">
        <p class="text-xs font-semibold uppercase tracking-wider text-charcoal/60">Undangan Aktif</p>
        <p class="mt-2 font-serif text-4xl font-bold text-sage">{{ $totalUndanganAktif }}</p>
    </div>
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/20">
        <p class="text-xs font-semibold uppercase tracking-wider text-charcoal/60">Draft Menunggu Aktivasi</p>
        <p class="mt-2 font-serif text-4xl font-bold text-champagne">{{ $totalDraft }}</p>
    </div>
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/20">
        <p class="text-xs font-semibold uppercase tracking-wider text-charcoal/60">Tema Aktif</p>
        <p class="mt-2 font-serif text-4xl font-bold text-charcoal">{{ $totalTemaAktif }}</p>
    </div>
</div>

<div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/20">
    <div class="flex items-center justify-between mb-4">
        <h2 class="font-serif text-2xl font-bold text-charcoal">Undangan Terbaru</h2>
        <a href="{{ route('admin.undangan.index') }}" class="text-sm font-semibold text-sage hover:underline">Lihat Semua →</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="border-b border-champagne/20 text-left text-xs uppercase text-charcoal/60">
                    <th class="py-3 pr-4">Pasangan &amp; Link</th>
                    <th class="py-3 pr-4">Client</th>
                    <th class="py-3 pr-4">Tema</th>
                    <th class="py-3 pr-4">Status</th>
                    <th class="py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-champagne/15">
                @forelse ($undanganTerbaru as $item)
                    <tr>
                        <td class="py-3 pr-4">
                            <p class="font-semibold text-charcoal">{{ $item->nama_panggilan_pria }} &amp; {{ $item->nama_panggilan_wanita }}</p>
                            <p class="text-xs font-mono text-sage">sesitemu.id/{{ $item->slug }}</p>
                        </td>
                        <td class="py-3 pr-4 text-charcoal/80">{{ $item->pengguna?->nama ?? '-' }}</td>
                        <td class="py-3 pr-4 text-charcoal/80">{{ $item->tema?->nama_tema ?? '-' }}</td>
                        <td class="py-3 pr-4">
                            @if ($item->sudahKedaluwarsa())
                                <span class="rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-700">Kedaluwarsa</span>
                            @elseif ($item->status_publikasi)
                                <span class="rounded-full bg-sage/15 px-2.5 py-0.5 text-xs font-semibold text-sage">Aktif</span>
                            @else
                                <span class="rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-800">Draft</span>
                            @endif
                        </td>
                        <td class="py-3 text-right">
                            <a href="{{ route('dasbor.undangan.kelola', $item) }}" class="text-xs font-semibold text-sage hover:underline">Edit Isian Client</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-charcoal/60">Belum ada data undangan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
