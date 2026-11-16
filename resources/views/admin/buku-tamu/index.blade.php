@extends('admin.tata-letak')

@section('judul', 'Buku Tamu & RSVP — Admin SesiTemu')

@section('isi_admin')
<div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4">
    <div>
        <h1 class="font-serif text-2xl sm:text-3xl font-bold text-charcoal">Moderasi Buku Tamu &amp; RSVP</h1>
        <p class="text-sm text-charcoal/70 mt-1">Pantau ucapan tamu dari seluruh undangan dan bersihkan komentar spam atau tidak pantas.</p>
    </div>

    <form action="{{ route('admin.buku-tamu.index') }}" method="GET" class="flex flex-wrap gap-2">
        <select name="undangan_id" class="rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm">
            <option value="0">Semua Undangan</option>
            @foreach ($daftarUndangan as $undanganItem)
                <option value="{{ $undanganItem->id }}" @selected($undanganId === $undanganItem->id)>
                    {{ $undanganItem->nama_panggilan_pria }} &amp; {{ $undanganItem->nama_panggilan_wanita }} ({{ $undanganItem->slug }})
                </option>
            @endforeach
        </select>

        <select name="status" class="rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm">
            <option value="semua" @selected($statusKehadiran === 'semua')>Semua Kehadiran</option>
            <option value="hadir" @selected($statusKehadiran === 'hadir')>Hadir</option>
            <option value="ragu" @selected($statusKehadiran === 'ragu')>Ragu-Ragu</option>
            <option value="tidak_hadir" @selected($statusKehadiran === 'tidak_hadir')>Tidak Hadir</option>
        </select>

        <button type="submit" class="rounded-xl bg-sage px-4 py-2 text-sm font-semibold text-white hover:bg-sage/90 cursor-pointer">
            Filter
        </button>
    </form>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-champagne/20">
        <p class="text-xs font-medium text-charcoal/60">Total Ucapan</p>
        <p class="mt-1.5 text-2xl font-bold text-charcoal">{{ $totalUcapan }}</p>
    </div>
    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-sage/25">
        <p class="text-xs font-medium text-charcoal/60">Konfirmasi Hadir</p>
        <p class="mt-1.5 text-2xl font-bold text-sage">{{ $totalHadir }}</p>
    </div>
    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-amber-200">
        <p class="text-xs font-medium text-charcoal/60">Masih Ragu</p>
        <p class="mt-1.5 text-2xl font-bold text-amber-700">{{ $totalRagu }}</p>
    </div>
    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-red-200">
        <p class="text-xs font-medium text-charcoal/60">Tidak Hadir</p>
        <p class="mt-1.5 text-2xl font-bold text-red-700">{{ $totalTidakHadir }}</p>
    </div>
</div>

<div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/20">
    <table data-datatable data-page-length="10" data-empty-message="Belum ada ucapan tamu atau RSVP yang cocok dengan filter." class="w-full text-sm">
        <thead>
            <tr class="border-b border-champagne/20 text-left text-xs uppercase text-charcoal/60">
                <th data-no-sort class="py-3 dt-center text-center">Aksi</th>
                <th class="py-3 pr-4">Nama Tamu</th>
                <th class="py-3 pr-4">Undangan</th>
                <th class="py-3 pr-4">Status Kehadiran</th>
                <th class="py-3 pr-4">Ucapan &amp; Doa</th>
                <th class="py-3 pr-4">Waktu</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-champagne/15">
            @foreach ($daftarUcapan as $ucapan)
                @php
                    $urlUndangan = $ucapan->undangan ? (Route::has('undangan.tampil') ? route('undangan.tampil', $ucapan->undangan->slug) : url('/'.$ucapan->undangan->slug)) : '#';
                @endphp
                <tr>
                    <td class="py-3.5 dt-center text-center whitespace-nowrap">
                        <div class="inline-flex items-center justify-center gap-1.5">
                            @if ($ucapan->undangan)
                                <a
                                    href="{{ $urlUndangan }}"
                                    target="_blank"
                                    rel="noopener"
                                    title="Preview Undangan"
                                    class="inline-flex items-center gap-1.5 rounded-lg border border-charcoal/15 bg-white px-2.5 py-1.5 text-xs font-semibold text-charcoal hover:border-sage/40 hover:text-sage transition"
                                >
                                    <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    <span>Preview</span>
                                </a>
                            @endif

                            <form
                                action="{{ route('admin.buku-tamu.destroy', $ucapan) }}"
                                method="POST"
                                data-swal-title="Hapus Ucapan Tamu?"
                                data-swal-confirm="Yakin ingin menghapus ucapan dari {{ $ucapan->nama_tamu }}?"
                                data-swal-icon="warning"
                                data-swal-confirm-button="Ya, Hapus"
                                data-swal-confirm-color="#DC2626"
                                data-swal-loading-title="Menghapus Ucapan..."
                                data-swal-loading-text="Sedang menghapus komentar dari buku tamu..."
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
                    <td class="py-3.5 pr-4 font-semibold text-charcoal">{{ $ucapan->nama_tamu }}</td>
                    <td class="py-3.5 pr-4">
                        @if ($ucapan->undangan)
                            <p class="font-medium text-charcoal">{{ $ucapan->undangan->nama_panggilan_pria }} &amp; {{ $ucapan->undangan->nama_panggilan_wanita }}</p>
                            <p class="text-xs font-mono text-sage">/{{ $ucapan->undangan->slug }}</p>
                        @else
                            <span class="text-charcoal/50">-</span>
                        @endif
                    </td>
                    <td class="py-3.5 pr-4">
                        @php
                            $badgeHadir = match ($ucapan->status_kehadiran) {
                                'hadir' => 'bg-sage/15 text-sage',
                                'ragu' => 'bg-amber-100 text-amber-800',
                                default => 'bg-red-100 text-red-700',
                            };
                            $labelHadir = match ($ucapan->status_kehadiran) {
                                'hadir' => 'Hadir ('.$ucapan->jumlah_tamu.' org)',
                                'ragu' => 'Ragu-Ragu',
                                default => 'Tidak Hadir',
                            };
                        @endphp
                        <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $badgeHadir }}">
                            {{ $labelHadir }}
                        </span>
                    </td>
                    <td class="py-3.5 pr-4 text-charcoal/80 max-w-md">{{ $ucapan->ucapan_doa }}</td>
                    <td class="py-3.5 pr-4 text-xs text-charcoal/60 whitespace-nowrap">{{ $ucapan->created_at?->translatedFormat('d M Y, H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
