@extends('admin.kerangka')

@section('judul', ($modeEdit ? 'Edit Tema' : 'Tambah Tema').' — Admin SesiTemu')

@section('isi_admin')
<div class="w-full rounded-2xl bg-white p-6 sm:p-8 shadow-sm ring-1 ring-champagne/20">
    <div class="flex items-center justify-between mb-6">
        <h1 class="font-serif text-3xl font-bold text-charcoal">{{ $modeEdit ? 'Edit Tema' : 'Tambah Tema Baru' }}</h1>
        <a href="{{ route('admin.tema.index') }}" class="text-sm font-semibold text-charcoal/70 hover:underline">← Kembali</a>
    </div>

    <form
        action="{{ $modeEdit ? route('admin.tema.update', $tema) : route('admin.tema.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-5"
        data-swal-loading
        data-swal-loading-title="{{ $modeEdit ? 'Memperbarui Tema...' : 'Menyimpan Tema Baru...' }}"
        data-swal-loading-text="Sedang mengunggah aset dan menyimpan konfigurasi tema..."
        x-data="{
            tierTerpilih: '{{ old('tier', $tema->tierKode()) }}',
            hargaTersimpan: '{{ old('harga', $tema->hargaAsliNominal()) }}',
            hargaBawaan: {{ json_encode(\App\Models\Tema::HARGA_BAWAAN_TIER) }},
            terapkanHargaSaran(tier) {
                if (this.hargaBawaan[tier] !== undefined) {
                    this.hargaTersimpan = this.hargaBawaan[tier];
                }
            }
        }"
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
                <label for="lokasi_view" class="block text-sm font-medium text-charcoal">Template View Blade</label>
                @php
                    $daftarLokasiView = $daftarLokasiView ?? \App\Models\Tema::daftarLokasiViewTersedia();
                    $nilaiLokasiView = old('lokasi_view', $tema->lokasi_view ?: 'tema.rustic-floral.index');
                @endphp
                <select id="lokasi_view" name="lokasi_view" required class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm">
                    @foreach ($daftarLokasiView as $viewDot => $viewLabel)
                        <option value="{{ $viewDot }}" @selected($nilaiLokasiView === $viewDot)>{{ $viewLabel }}</option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-charcoal/60">Dipindai otomatis dari folder <code class="font-mono">resources/views/tema/</code>.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="tier" class="block text-sm font-medium text-charcoal">Tingkatan Kualitas (Tier)</label>
                <select
                    id="tier"
                    name="tier"
                    x-model="tierTerpilih"
                    required
                    class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm"
                >
                    @foreach (\App\Models\Tema::TIER_TERSEDIA as $val => $label)
                        <option value="{{ $val }}" @selected(old('tier', $tema->tierKode()) === $val)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <div class="flex items-center justify-between">
                    <label for="harga" class="block text-sm font-medium text-charcoal">Harga Tema (Rp)</label>
                    <button
                        type="button"
                        @click="terapkanHargaSaran(tierTerpilih)"
                        class="text-xs font-semibold text-sage hover:underline cursor-pointer"
                    >
                        Pakai saran tier
                    </button>
                </div>
                <input
                    id="harga"
                    name="harga"
                    type="number"
                    min="0"
                    step="1000"
                    x-model="hargaTersimpan"
                    value="{{ old('harga', $tema->hargaAsliNominal()) }}"
                    required
                    class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm font-semibold"
                >
                <p class="mt-1 text-xs text-charcoal/60">
                    Terima Beres otomatis menjadi harga tema + {{ \App\Models\Tema::formatRupiah(\App\Models\Tema::BIAYA_JASA_TERIMA_BERES) }} jasa input admin.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 rounded-2xl border border-champagne/25 bg-ivory/50 p-4">
            <div>
                <label for="diskon_tipe" class="block text-sm font-medium text-charcoal">Tipe Diskon Katalog (Opsional)</label>
                <select id="diskon_tipe" name="diskon_tipe" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-white px-4 py-2.5 text-sm">
                    <option value="">Tanpa Diskon</option>
                    <option value="persen" @selected(old('diskon_tipe', $tema->diskonTipe()) === 'persen')>Persentase (%)</option>
                    <option value="nominal" @selected(old('diskon_tipe', $tema->diskonTipe()) === 'nominal')>Potongan Nominal (Rp)</option>
                </select>
            </div>
            <div>
                <label for="diskon_nilai" class="block text-sm font-medium text-charcoal">Nilai Diskon</label>
                <input id="diskon_nilai" name="diskon_nilai" type="number" min="0" value="{{ old('diskon_nilai', $tema->diskonNilai()) }}" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-white px-4 py-2.5 text-sm">
            </div>
        </div>

        <div>
            <label for="gambar_pratinjau" class="block text-sm font-medium text-charcoal mb-1.5">Gambar Pratinjau (Opsional, otomatis WebP)</label>
            <label for="gambar_pratinjau" class="flex flex-col sm:flex-row items-center gap-4 rounded-2xl border-2 border-dashed border-champagne/45 bg-ivory/70 p-4 hover:border-champagne hover:bg-champagne/5 cursor-pointer transition">
                @if ($tema->urlGambarPratinjau())
                    <img src="{{ $tema->urlGambarPratinjau() }}" alt="{{ $tema->nama_tema }}" class="h-20 w-28 rounded-xl object-cover shrink-0 ring-1 ring-champagne/25">
                @endif
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-charcoal">Klik untuk memilih gambar pratinjau (JPG, PNG, WebP • Maks 5 MB)</p>
                    <input id="gambar_pratinjau" name="gambar_pratinjau" type="file" accept="image/jpeg,image/png,image/webp" class="mt-2 block w-full text-xs text-charcoal/70 file:mr-3 file:rounded-lg file:border-0 file:bg-champagne/20 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-charcoal hover:file:bg-champagne/30">
                </div>
            </label>
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
