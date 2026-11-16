@extends('admin.kerangka')

@section('judul', 'Manajemen Undangan — Admin SesiTemu')

@section('isi_admin')
@php
    $durasiBulanAktif = \App\Support\PengaturanSesiTemu::masaAktifBulan();
@endphp
<div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4">
    <div>
        <h1 class="font-serif text-2xl sm:text-3xl font-bold text-charcoal">Manajemen &amp; Aktivasi Undangan</h1>
        <p class="text-sm text-charcoal/70 mt-1">Aktifkan undangan client selama {{ $durasiBulanAktif }} bulan atau bantu edit untuk Paket Terima Beres.</p>
    </div>

    <form action="{{ route('admin.undangan.index') }}" method="GET" class="flex flex-col sm:flex-row flex-wrap gap-2 w-full xl:w-auto">
        <input
            type="text"
            name="q"
            value="{{ $pencarian }}"
            placeholder="Cari slug atau nama client..."
            class="w-full sm:w-64 lg:w-72 rounded-xl border border-charcoal/15 bg-white px-4 py-2 text-sm focus:border-champagne focus:outline-none"
        >
        <select name="status" class="w-full sm:w-auto rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm">
            <option value="semua" @selected($status === 'semua')>Semua Status</option>
            <option value="draft" @selected($status === 'draft')>Draft</option>
            <option value="aktif" @selected($status === 'aktif')>Aktif</option>
            <option value="kedaluwarsa" @selected($status === 'kedaluwarsa')>Kedaluwarsa</option>
        </select>
        <button type="submit" class="rounded-xl bg-sage px-5 py-2 text-sm font-semibold text-white hover:bg-sage/90 cursor-pointer shrink-0">
            Filter
        </button>
    </form>
</div>

<div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/20">
    <table data-datatable data-page-length="10" data-empty-message="Tidak ada undangan yang cocok dengan filter." class="w-full text-sm">
        <thead>
            <tr class="border-b border-champagne/20 text-left text-xs uppercase text-charcoal/60">
                <th data-no-sort class="py-3 dt-center text-center">Aksi</th>
                <th class="py-3 pr-4">Undangan &amp; Slug</th>
                <th class="py-3 pr-4">Client</th>
                <th class="py-3 pr-4">Tema</th>
                <th class="py-3 pr-4">Status &amp; Masa Aktif</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-champagne/15">
            @foreach ($daftarUndangan as $undangan)
                @php
                    $urlPublik = Route::has('undangan.tampil') ? route('undangan.tampil', $undangan->slug) : url('/'.$undangan->slug);
                @endphp
                <tr>
                    <td class="py-3.5 dt-center text-center whitespace-nowrap">
                        <div class="inline-flex items-center justify-center gap-1.5">
                            <a
                                href="{{ $urlPublik }}"
                                target="_blank"
                                rel="noopener"
                                title="Preview Undangan"
                                class="inline-flex items-center gap-1.5 rounded-lg border border-charcoal/15 bg-white px-2.5 py-1.5 text-xs font-semibold text-charcoal hover:border-sage/40 hover:bg-sage/5 hover:text-sage transition"
                            >
                                <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                <span>Preview</span>
                            </a>
                            <a
                                href="{{ route('dasbor.undangan.kelola', $undangan) }}"
                                title="Edit Isian Client"
                                class="inline-flex items-center gap-1.5 rounded-lg border border-champagne/50 bg-champagne/10 px-2.5 py-1.5 text-xs font-semibold text-charcoal hover:bg-champagne/25 transition"
                            >
                                <svg class="h-3.5 w-3.5 text-amber-700 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/>
                                </svg>
                                <span>Edit Isian</span>
                            </a>

                            @if ($undangan->status_publikasi && ! $undangan->sudahKedaluwarsa())
                                <form
                                    action="{{ route('admin.undangan.nonaktifkan', $undangan) }}"
                                    method="POST"
                                    data-swal-title="Nonaktifkan Undangan?"
                                    data-swal-confirm="Undangan {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }} (sesitemu.id/{{ $undangan->slug }}) akan dikembalikan ke mode Draft."
                                    data-swal-icon="warning"
                                    data-swal-confirm-button="Ya, Nonaktifkan"
                                    data-swal-confirm-color="#D97706"
                                    data-swal-loading-title="Menonaktifkan Undangan..."
                                    data-swal-loading-text="Sedang mengembalikan status undangan ke mode Draft..."
                                >
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" title="Nonaktifkan Undangan" class="inline-flex items-center gap-1.5 rounded-lg border border-amber-300 bg-amber-50/70 px-2.5 py-1.5 text-xs font-semibold text-amber-800 hover:bg-amber-100/80 cursor-pointer transition">
                                        <svg class="h-3.5 w-3.5 text-amber-700 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10"/>
                                            <line x1="10" x2="10" y1="15" y2="9"/>
                                            <line x1="14" x2="14" y1="15" y2="9"/>
                                        </svg>
                                        <span>Nonaktifkan</span>
                                    </button>
                                </form>
                            @else
                                <form
                                    action="{{ route('admin.undangan.aktifkan', $undangan) }}"
                                    method="POST"
                                    data-swal-title="Aktifkan Undangan?"
                                    data-swal-confirm="Undangan {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }} (sesitemu.id/{{ $undangan->slug }}) akan dipublikasikan dan aktif selama {{ $durasiBulanAktif }} bulan."
                                    data-swal-icon="question"
                                    data-swal-confirm-button="Ya, Aktifkan"
                                    data-swal-confirm-color="#4B6358"
                                    data-swal-loading-title="Mengaktifkan Undangan..."
                                    data-swal-loading-text="Sedang memublikasikan undangan &amp; mengatur masa aktif {{ $durasiBulanAktif }} bulan..."
                                >
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" title="Aktifkan Undangan ({{ $durasiBulanAktif }} Bulan)" class="inline-flex items-center gap-1.5 rounded-lg bg-sage px-2.5 py-1.5 text-xs font-semibold text-white hover:bg-sage/90 cursor-pointer shadow-xs transition">
                                        <svg class="h-3.5 w-3.5 text-white shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M21.801 10A10 10 0 1 1 17 3.335"/>
                                            <path d="m9 11 3 3L22 4"/>
                                        </svg>
                                        <span>Aktifkan</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
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
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
