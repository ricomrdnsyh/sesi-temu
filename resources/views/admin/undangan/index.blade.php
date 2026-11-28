@extends('admin.kerangka')

@section('judul', 'Manajemen Undangan — Admin SesiTemu')

@section('isi_admin')
@php
    $durasiBulanAktif = \App\Support\PengaturanSesiTemu::masaAktifBulan();
    $adaGalatBuatUndangan = $errors->hasAny([
        'pengguna_id',
        'tema_id',
        'slug',
        'nama_panggilan_pria',
        'nama_lengkap_pria',
        'nama_panggilan_wanita',
        'nama_lengkap_wanita',
    ]);
@endphp
<div
    x-data="{ modalBuatTerbuka: {{ $adaGalatBuatUndangan ? 'true' : 'false' }} }"
    @keydown.escape.window="if (!window.Swal?.isVisible()) modalBuatTerbuka = false"
    class="space-y-6"
>
<div class="rounded-2xl bg-white p-5 sm:p-6 shadow-sm ring-1 ring-champagne/20">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 mb-5 border-b border-champagne/20">
        <div>
            <h1 class="text-base sm:text-lg font-bold text-charcoal">Manajemen &amp; Aktivasi Undangan</h1>
            <p class="text-xs text-charcoal/60 mt-0.5">Aktifkan undangan client selama {{ $durasiBulanAktif }} bulan atau bantu edit untuk Paket Terima Beres.</p>
        </div>

        <button
            type="button"
            @click="modalBuatTerbuka = true"
            data-buka-modal-buat-undangan
            class="inline-flex items-center justify-center gap-1.5 rounded-xl px-4 py-2 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs bg-sage font-semibold text-white hover:bg-sage/90 cursor-pointer transition shrink-0"
        >
            <svg class="h-4 w-4 sm:h-3.5 sm:w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <line x1="12" x2="12" y1="5" y2="19"/>
                <line x1="5" x2="19" y1="12" y2="12"/>
            </svg>
            <span>Buat Undangan</span>
        </button>
    </div>

    {{-- Kotak Filter Data --}}
    <form action="{{ route('admin.undangan.index') }}" method="GET" class="rounded-xl border border-dashed border-sage/50 bg-ivory/50 p-4 mb-5">
        <div class="flex items-center gap-1.5 text-xs font-bold text-sage mb-3">
            <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M3 4a1 1 0 0 1 1-1h16a1 1 0 0 1 .78 1.625L15 11.85V19a1 1 0 0 1-1.447.894l-4-2A1 1 0 0 1 9 17v-5.15L3.22 4.625A1 1 0 0 1 3 4Z" />
            </svg>
            <span>Filter Data</span>
        </div>

        <div>
            <label for="filter_status_undangan" class="block text-xs font-medium text-charcoal/75 mb-1.5">Status:</label>
            <select
                id="filter_status_undangan"
                name="status"
                data-auto-submit
                class="w-full rounded-xl px-3.5 py-2 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-white"
            >
                <option value="semua" @selected($status === 'semua')>Semua Status</option>
                <option value="draft" @selected($status === 'draft')>Draft</option>
                <option value="aktif" @selected($status === 'aktif')>Aktif</option>
                <option value="kedaluwarsa" @selected($status === 'kedaluwarsa')>Kedaluwarsa</option>
            </select>
        </div>
    </form>

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
                                class="inline-flex items-center gap-1 rounded-lg border border-charcoal/15 bg-white px-2.5 py-1.5 sm:px-2 sm:py-1 text-xs font-semibold text-charcoal hover:border-sage/40 hover:bg-sage/5 hover:text-sage transition"
                            >
                                <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                <span>Preview</span>
                            </a>
                            <a
                                href="{{ route('dashboard.undangan.kelola', $undangan) }}"
                                title="Edit Isian Client"
                                class="inline-flex items-center gap-1 rounded-lg border border-champagne/50 bg-champagne/10 px-2.5 py-1.5 sm:px-2 sm:py-1 text-xs font-semibold text-charcoal hover:bg-champagne/25 transition"
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
                                    <button type="submit" title="Nonaktifkan Undangan" class="inline-flex items-center gap-1 rounded-lg border border-amber-300 bg-amber-50/70 px-2.5 py-1.5 sm:px-2 sm:py-1 text-xs font-semibold text-amber-800 hover:bg-amber-100/80 cursor-pointer transition">
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
                                    <button type="submit" title="Aktifkan Undangan ({{ $durasiBulanAktif }} Bulan)" class="inline-flex items-center gap-1 rounded-lg bg-sage px-2.5 py-1.5 sm:px-2 sm:py-1 text-xs font-semibold text-white hover:bg-sage/90 cursor-pointer shadow-xs transition">
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

{{-- Modal Buat Undangan untuk Client --}}
<div
    x-show="modalBuatTerbuka"
    x-cloak
    x-transition.opacity.duration.150ms
    @click.self="modalBuatTerbuka = false"
    role="dialog"
    aria-modal="true"
    aria-labelledby="judul-modal-buat-undangan"
    class="fixed inset-0 z-50 flex items-center justify-center bg-charcoal/60 backdrop-blur-xs p-4 overflow-y-auto"
>
    <div class="w-full max-w-xl rounded-2xl bg-white px-5 pt-5 pb-4 sm:px-6 sm:pt-5 sm:pb-4 shadow-2xl ring-1 ring-champagne/25 my-8">
        <div class="flex items-start justify-between gap-4 pb-4 border-b border-champagne/20">
            <div>
                <h2 id="judul-modal-buat-undangan" class="font-serif text-xl sm:text-2xl font-bold text-charcoal">Buat Undangan Client</h2>
                <p class="text-xs sm:text-sm text-charcoal/65 mt-1">Pilih akun client, tema, link, dan nama mempelai. Setelah dibuat Anda langsung diarahkan ke editor isian.</p>
            </div>

            <button
                type="button"
                @click="modalBuatTerbuka = false"
                aria-label="Tutup modal buat undangan"
                class="rounded-lg p-1.5 text-charcoal/55 hover:bg-ivory hover:text-charcoal cursor-pointer transition"
            >
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        @if ($daftarClient->isEmpty())
            <div class="mt-5 rounded-xl border border-amber-200 bg-amber-50/70 p-4 text-xs sm:text-sm text-amber-900 space-y-2">
                <p class="font-semibold">Belum ada akun client terdaftar.</p>
                <p class="text-amber-900/80">Tambahkan akun client terlebih dahulu melalui menu Pengguna sebelum membuatkan undangan.</p>
                <a href="{{ route('admin.pengguna.index') }}" class="inline-flex items-center gap-1.5 rounded-xl px-4 py-2 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs bg-sage font-semibold text-white hover:bg-sage/90 transition">
                    <span>Buka Manajemen Pengguna →</span>
                </a>
            </div>
        @else
            <form
                action="{{ route('admin.undangan.store') }}"
                method="POST"
                class="mt-5 space-y-4"
                data-swal-loading
                data-swal-loading-title="Membuat Draft Undangan Client..."
                data-swal-loading-text="Sedang menyiapkan link dan halaman editor undangan..."
            >
                @csrf

                <div>
                    <label for="buat_pengguna_id" class="block text-xs font-semibold text-charcoal/80 mb-1">Akun Client</label>
                    <select
                        id="buat_pengguna_id"
                        name="pengguna_id"
                        data-select2-search="true"
                        required
                        class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60 focus:border-champagne focus:bg-white focus:outline-none"
                    >
                        <option value="">-- Pilih Client --</option>
                        @foreach ($daftarClient as $clientItem)
                            <option value="{{ $clientItem->id }}" @selected((string) old('pengguna_id') === (string) $clientItem->id)>
                                {{ $clientItem->nama }} ({{ $clientItem->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="buat_tema_id" class="block text-xs font-semibold text-charcoal/80 mb-1">Pilih Tema</label>
                    <select
                        id="buat_tema_id"
                        name="tema_id"
                        data-select2-search="true"
                        required
                        class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60 focus:border-champagne focus:bg-white focus:outline-none"
                    >
                        @foreach ($daftarTema as $temaItem)
                            <option value="{{ $temaItem->id }}" @selected((string) old('tema_id') === (string) $temaItem->id)>
                                {{ $temaItem->nama_tema }} ({{ $temaItem->kategoriLabel() }} — {{ $temaItem->hargaFormatted() }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="buat_slug" class="block text-xs font-semibold text-charcoal/80 mb-1">Link Undangan</label>
                    <div class="flex items-center rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border @error('slug') border-rose-400 ring-2 ring-rose-500/15 @else border-charcoal/15 @enderror bg-ivory/60 focus-within:border-champagne focus-within:bg-white">
                        <span class="text-charcoal/50 shrink-0">sesitemu.id/</span>
                        <input
                            id="buat_slug"
                            name="slug"
                            type="text"
                            value="{{ old('slug') }}"
                            required
                            placeholder="raka-maya"
                            class="w-full bg-transparent font-semibold text-charcoal focus:outline-none ml-0.5"
                        >
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label for="buat_nama_panggilan_pria" class="block text-xs font-semibold text-charcoal/80 mb-1">Panggilan Pria</label>
                        <input
                            id="buat_nama_panggilan_pria"
                            name="nama_panggilan_pria"
                            type="text"
                            value="{{ old('nama_panggilan_pria') }}"
                            required
                            placeholder="Raka"
                            class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60 focus:border-champagne focus:bg-white focus:outline-none"
                        >
                    </div>
                    <div>
                        <label for="buat_nama_lengkap_pria" class="block text-xs font-semibold text-charcoal/80 mb-1">Nama Lengkap Pria</label>
                        <input
                            id="buat_nama_lengkap_pria"
                            name="nama_lengkap_pria"
                            type="text"
                            value="{{ old('nama_lengkap_pria') }}"
                            required
                            placeholder="Raka Wijaya"
                            class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60 focus:border-champagne focus:bg-white focus:outline-none"
                        >
                    </div>
                    <div>
                        <label for="buat_nama_panggilan_wanita" class="block text-xs font-semibold text-charcoal/80 mb-1">Panggilan Wanita</label>
                        <input
                            id="buat_nama_panggilan_wanita"
                            name="nama_panggilan_wanita"
                            type="text"
                            value="{{ old('nama_panggilan_wanita') }}"
                            required
                            placeholder="Maya"
                            class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60 focus:border-champagne focus:bg-white focus:outline-none"
                        >
                    </div>
                    <div>
                        <label for="buat_nama_lengkap_wanita" class="block text-xs font-semibold text-charcoal/80 mb-1">Nama Lengkap Wanita</label>
                        <input
                            id="buat_nama_lengkap_wanita"
                            name="nama_lengkap_wanita"
                            type="text"
                            value="{{ old('nama_lengkap_wanita') }}"
                            required
                            placeholder="Maya Sari"
                            class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60 focus:border-champagne focus:bg-white focus:outline-none"
                        >
                    </div>
                </div>

                <div class="pt-3.5 border-t border-champagne/20 flex items-center justify-end gap-2">
                    <button
                        type="button"
                        @click="modalBuatTerbuka = false"
                        class="inline-flex items-center gap-1.5 rounded-xl px-4 py-2 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 font-semibold text-charcoal hover:bg-ivory cursor-pointer transition"
                    >
                        <svg class="h-4 w-4 sm:h-3.5 sm:w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                        <span>Batal</span>
                    </button>
                    <button
                        type="submit"
                        class="inline-flex items-center gap-1.5 rounded-xl px-4 py-2 text-sm sm:rounded-lg sm:px-3.5 sm:py-1.5 sm:text-xs bg-sage font-semibold text-white hover:bg-sage/90 cursor-pointer transition"
                    >
                        <svg class="h-4 w-4 sm:h-3.5 sm:w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                            <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                            <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                        </svg>
                        <span>Buat &amp; Lanjut Edit</span>
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>
</div>
@endsection
