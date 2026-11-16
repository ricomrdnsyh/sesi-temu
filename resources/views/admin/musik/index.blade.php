@extends('admin.kerangka')

@section('judul', 'Musik Latar — Admin SesiTemu')

@section('isi_admin')
<div>
    <h1 class="font-serif text-2xl sm:text-3xl font-bold text-charcoal">Manajemen Musik Latar</h1>
    <p class="text-sm text-charcoal/70 mt-1">Kelola koleksi lagu MP3/audio bawaan yang otomatis muncul di pilihan editor undangan Client.</p>
</div>

<div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/20">
    <h2 class="text-base font-bold text-charcoal mb-4">Unggah Musik Latar Baru</h2>
    <form
        action="{{ route('admin.musik.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end"
        data-swal-loading
        data-swal-loading-title="Mengunggah Musik..."
        data-swal-loading-text="Sedang menyimpan file audio ke katalog musik platform..."
    >
        @csrf
        <div>
            <label class="block text-xs font-semibold text-charcoal/75 mb-1">Judul Lagu</label>
            <input type="text" name="judul" required placeholder="Contoh: Piano Senja" class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs font-semibold text-charcoal/75 mb-1">Artis / Label</label>
            <input type="text" name="artis" placeholder="Contoh: SesiTemu Acoustic" class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs font-semibold text-charcoal/75 mb-1">Kategori</label>
            <input type="text" name="kategori" placeholder="Contoh: Romantis / Adat" class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs font-semibold text-charcoal/75 mb-1">File Audio (MP3/WAV/OGG)</label>
            <input type="file" name="file_audio" accept=".mp3,.wav,.ogg,.m4a,audio/*" required class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3 py-1.5 text-xs">
        </div>
        <div>
            <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 rounded-xl bg-sage px-4 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 cursor-pointer">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="17 8 12 3 7 8"/>
                    <line x1="12" x2="12" y1="3" y2="15"/>
                </svg>
                <span>Tambah Musik</span>
            </button>
        </div>
    </form>
</div>

<div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/20">
    <table data-datatable data-page-length="10" data-empty-message="Belum ada data musik latar terdaftar." class="w-full text-sm">
        <thead>
            <tr class="border-b border-champagne/20 text-left text-xs uppercase text-charcoal/60">
                <th data-no-sort class="py-3 dt-center text-center">Aksi</th>
                <th class="py-3 pr-4">Judul &amp; Artis</th>
                <th class="py-3 pr-4">Kategori</th>
                <th class="py-3 pr-4">Pratinjau Audio</th>
                <th class="py-3 pr-4 dt-left">Dipakai</th>
                <th class="py-3 pr-4">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-champagne/15">
            @foreach ($daftarMusik as $musik)
                <tr>
                    <td class="py-3.5 dt-center text-center whitespace-nowrap">
                        <div class="inline-flex items-center justify-center gap-1.5">
                            <form
                                action="{{ route('admin.musik.toggle', $musik) }}"
                                method="POST"
                                data-swal-title="{{ $musik->aktif ? 'Nonaktifkan Musik?' : 'Aktifkan Musik?' }}"
                                data-swal-confirm="Ubah status tampil musik {{ $musik->judul }} di pilihan editor Client?"
                                data-swal-icon="question"
                                data-swal-confirm-button="Ya, Ubah"
                                data-swal-confirm-color="#4B6358"
                                data-swal-loading-title="Memperbarui Status Musik..."
                            >
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-flex items-center gap-1 rounded-lg border px-2.5 py-1.5 text-xs font-semibold cursor-pointer transition {{ $musik->aktif ? 'border-amber-300 bg-amber-50 text-amber-800 hover:bg-amber-100' : 'border-sage bg-sage text-white hover:bg-sage/90' }}">
                                    <span>{{ $musik->aktif ? 'Nonaktifkan' : 'Aktifkan' }}</span>
                                </button>
                            </form>

                            <form
                                action="{{ route('admin.musik.destroy', $musik) }}"
                                method="POST"
                                data-swal-title="Hapus Musik?"
                                data-swal-confirm="Hapus {{ $musik->judul }} dari katalog musik latar?"
                                data-swal-icon="warning"
                                data-swal-confirm-button="Ya, Hapus"
                                data-swal-confirm-color="#DC2626"
                                data-swal-loading-title="Menghapus Musik..."
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
                        <p class="font-semibold text-charcoal">{{ $musik->judul }}</p>
                        <p class="text-xs text-charcoal/60">{{ $musik->artis ?: '-' }}</p>
                    </td>
                    <td class="py-3.5 pr-4 text-charcoal/80">{{ $musik->kategori ?: 'Umum' }}</td>
                    <td class="py-3.5 pr-4">
                        <audio controls preload="none" class="h-8 w-48 max-w-full" src="{{ $musik->urlAudio() }}"></audio>
                    </td>
                    <td class="py-3.5 pr-4 font-semibold dt-left">{{ (int) ($pemakaianMusik[$musik->path_file] ?? 0) }} undangan</td>
                    <td class="py-3.5 pr-4">
                        <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $musik->aktif ? 'bg-sage/15 text-sage' : 'bg-charcoal/10 text-charcoal/70' }}">
                            {{ $musik->aktif ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
