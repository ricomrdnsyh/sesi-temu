@extends('admin.tata-letak')

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

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($daftarTema as $tema)
        <div class="rounded-2xl bg-white overflow-hidden shadow-sm ring-1 ring-champagne/20 flex flex-col">
            <div class="aspect-[4/3] bg-ivory relative overflow-hidden">
                @if ($tema->urlGambarPratinjau())
                    <img src="{{ $tema->urlGambarPratinjau() }}" alt="{{ $tema->nama_tema }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-sage/10 text-sage font-serif text-xl">
                        {{ $tema->nama_tema }}
                    </div>
                @endif
                <span class="absolute top-3 right-3 rounded-full px-3 py-1 text-xs font-semibold {{ $tema->aktif ? 'bg-sage text-white' : 'bg-charcoal/80 text-white' }}">
                    {{ $tema->aktif ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>

            <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-champagne">{{ ucfirst($tema->kategori) }}</p>
                    <h2 class="mt-1 font-serif text-2xl font-bold text-charcoal">{{ $tema->nama_tema }}</h2>
                    <p class="mt-1 text-xs font-mono text-charcoal/60">Slug: {{ $tema->slug }}</p>
                    <p class="text-xs font-mono text-charcoal/60">View: {{ $tema->lokasi_view }}</p>
                    <p class="mt-2 text-xs text-charcoal/70">Dipakai oleh {{ $tema->undangan_count }} undangan</p>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.tema.edit', $tema) }}" class="flex-1 text-center rounded-xl border border-champagne px-3.5 py-2 text-xs font-semibold text-charcoal hover:bg-champagne/10">
                        Edit Tema
                    </a>
                    <form action="{{ route('admin.tema.destroy', $tema) }}" method="POST" onsubmit="return confirm('Hapus tema ini?')">
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
