@extends('admin.kerangka')

@section('judul', 'Katalog Tema — Admin SesiTemu')

@section('isi_admin')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h1 class="font-serif text-3xl font-bold text-charcoal">Manajemen Katalog Tema</h1>
        <p class="text-sm text-charcoal/70 mt-1">Kelola desain tema undangan, view Blade, thumbnail, dan status aktif.</p>
    </div>
    <a href="{{ route('admin.tema.create') }}" class="rounded-xl bg-sage px-5 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition text-center">
        + Tambah Tema Baru
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-6">
    @foreach ($daftarTema as $tema)
        @php $infoTier = $tema->infoTier(); @endphp
        <div class="rounded-2xl bg-white overflow-hidden shadow-sm ring-1 ring-champagne/20 flex flex-col">
            <div class="aspect-[4/3] bg-ivory relative overflow-hidden">
                @if ($tema->urlGambarPratinjau())
                    <img src="{{ $tema->urlGambarPratinjau() }}" alt="{{ $tema->nama_tema }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-sage/10 text-sage font-serif text-xl">
                        {{ $tema->nama_tema }}
                    </div>
                @endif
                <span class="absolute top-3 left-3 rounded-full px-3 py-1 text-xs font-semibold {{ $infoTier['badge_class'] }}">
                    {{ $infoTier['label'] }}
                </span>
                <span class="absolute top-3 right-3 rounded-full px-3 py-1 text-xs font-semibold {{ $tema->aktif ? 'bg-sage text-white' : 'bg-charcoal/80 text-white' }}">
                    {{ $tema->aktif ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>

            <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                <div>
                    <div class="flex items-center justify-between gap-2">
                        <p class="text-xs font-semibold uppercase tracking-wider text-champagne">{{ $tema->kategoriLabel() }}</p>
                        <span class="text-sm font-bold text-charcoal">{{ $tema->hargaFormatted() }}</span>
                    </div>
                    <h2 class="mt-1 font-serif text-2xl font-bold text-charcoal">{{ $tema->nama_tema }}</h2>
                    <p class="mt-1 text-xs font-mono text-charcoal/60">Slug: {{ $tema->slug }}</p>
                    <p class="text-xs font-mono text-charcoal/60">View: {{ $tema->lokasi_view }}</p>
                    <p class="mt-2 text-xs text-charcoal/70">Dipakai oleh {{ $tema->undangan_count }} undangan</p>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.tema.edit', $tema) }}" class="flex-1 text-center rounded-xl border border-champagne px-3.5 py-2 text-xs font-semibold text-charcoal hover:bg-champagne/10">
                        Edit Tema
                    </a>
                    <form
                        action="{{ route('admin.tema.destroy', $tema) }}"
                        method="POST"
                        data-swal-title="Hapus Tema?"
                        data-swal-confirm="Yakin ingin menghapus tema {{ $tema->nama_tema }}?"
                        data-swal-icon="warning"
                        data-swal-confirm-button="Ya, Hapus"
                        data-swal-confirm-color="#DC2626"
                        data-swal-loading-title="Menghapus Tema..."
                        data-swal-loading-text="Sedang menghapus data tema dari katalog..."
                    >
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-xl border border-red-200 px-3.5 py-2 text-xs font-semibold text-red-700 hover:bg-red-50 cursor-pointer">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
