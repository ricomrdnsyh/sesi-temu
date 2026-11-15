@extends('admin.tata-letak')

@section('judul', ($modeEdit ? 'Edit Tema' : 'Tambah Tema').' — Admin SesiTemu')

@section('isi_admin')
<div class="max-w-2xl mx-auto rounded-2xl bg-white p-6 sm:p-8 shadow-sm ring-1 ring-champagne/20">
    <div class="flex items-center justify-between mb-6">
        <h1 class="font-serif text-3xl font-bold text-charcoal">{{ $modeEdit ? 'Edit Tema' : 'Tambah Tema Baru' }}</h1>
        <a href="{{ route('admin.tema.index') }}" class="text-sm font-semibold text-charcoal/70 hover:underline">← Kembali</a>
    </div>

    <form
        action="{{ $modeEdit ? route('admin.tema.update', $tema) : route('admin.tema.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-5"
    >
        @csrf
        @if ($modeEdit)
            @method('PUT')
        @endif

        <div>
            <label for="nama_tema" class="block text-sm font-medium text-charcoal">Nama Tema</label>
            <input id="nama_tema" name="nama_tema" type="text" value="{{ old('nama_tema', $tema->nama_tema) }}" required class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm">
        </div>

        <div>
            <label for="slug" class="block text-sm font-medium text-charcoal">Slug Tema</label>
            <input id="slug" name="slug" type="text" value="{{ old('slug', $tema->slug) }}" placeholder="rustic-floral" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="kategori" class="block text-sm font-medium text-charcoal">Kategori</label>
                <select id="kategori" name="kategori" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm">
                    @foreach (\App\Models\Tema::KATEGORI_TERSEDIA as $val => $label)
                        <option value="{{ $val }}" @selected(old('kategori', $tema->kategori) === $val)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="lokasi_view" class="block text-sm font-medium text-charcoal">Lokasi View Blade</label>
                <input id="lokasi_view" name="lokasi_view" type="text" value="{{ old('lokasi_view', $tema->lokasi_view ?: 'tema.rustic-floral.index') }}" required class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm font-mono">
            </div>
        </div>

        <div>
            <label for="gambar_pratinjau" class="block text-sm font-medium text-charcoal">Gambar Pratinjau (Opsional, otomatis WebP)</label>
            <input id="gambar_pratinjau" name="gambar_pratinjau" type="file" accept="image/*" class="mt-1.5 block w-full text-sm text-charcoal">
        </div>

        <label class="inline-flex items-center gap-2 text-sm font-medium text-charcoal cursor-pointer">
            <input type="checkbox" name="aktif" value="1" @checked(old('aktif', $tema->aktif)) class="rounded border-charcoal/25 text-sage focus:ring-sage">
            <span>Tema Aktif di Katalog Publik</span>
        </label>

        <div class="pt-3 flex justify-end gap-3">
            <a href="{{ route('admin.tema.index') }}" class="rounded-xl px-4 py-2.5 text-sm font-semibold text-charcoal/70 hover:bg-charcoal/5">Batal</a>
            <button type="submit" class="rounded-xl bg-sage px-6 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 cursor-pointer">
                {{ $modeEdit ? 'Simpan Perubahan' : 'Simpan Tema' }}
            </button>
        </div>
    </form>
</div>
@endsection
