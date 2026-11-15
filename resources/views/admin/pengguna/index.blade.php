@extends('admin.tata-letak')

@section('judul', 'Manajemen Pengguna — Admin SesiTemu')

@section('isi_admin')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h1 class="font-serif text-3xl font-bold text-charcoal">Manajemen Client &amp; Follow-Up</h1>
        <p class="text-sm text-charcoal/70 mt-1">Hubungi client via WhatsApp atau lakukan reset kata sandi secara manual.</p>
    </div>

    <form action="{{ route('admin.pengguna.index') }}" method="GET" class="flex gap-2">
        <input type="text" name="q" value="{{ $pencarian }}" placeholder="Cari nama, email, atau WA..." class="rounded-xl border border-charcoal/15 bg-white px-4 py-2 text-sm">
        <button type="submit" class="rounded-xl bg-sage px-4 py-2 text-sm font-semibold text-white hover:bg-sage/90 cursor-pointer">Cari</button>
    </form>
</div>

<div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/20 overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead>
            <tr class="border-b border-champagne/20 text-left text-xs uppercase text-charcoal/60">
                <th class="py-3 pr-4">Nama Client</th>
                <th class="py-3 pr-4">Email</th>
                <th class="py-3 pr-4">WhatsApp</th>
                <th class="py-3 pr-4">Jumlah Undangan</th>
                <th class="py-3 text-right">Reset Kata Sandi Manual</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-champagne/15">
            @forelse ($daftarPengguna as $pengguna)
                @php
                    $waBersih = preg_replace('/[^0-9]/', '', (string) $pengguna->nomor_wa);
                    if ($waBersih && str_starts_with($waBersih, '0')) {
                        $waBersih = '62'.substr($waBersih, 1);
                    }
                @endphp
                <tr>
                    <td class="py-3.5 pr-4 font-semibold text-charcoal">{{ $pengguna->nama }}</td>
                    <td class="py-3.5 pr-4 text-charcoal/80">{{ $pengguna->email }}</td>
                    <td class="py-3.5 pr-4">
                        @if ($waBersih)
                            <a
                                href="https://wa.me/{{ $waBersih }}?text={{ urlencode('Halo Kak '.$pengguna->nama.', kami dari tim SesiTemu siap membantu proses aktivasi undangan Anda.') }}"
                                target="_blank"
                                rel="noopener"
                                class="inline-flex items-center gap-1 rounded-lg bg-sage/10 px-3 py-1 text-xs font-semibold text-sage hover:bg-sage/20"
                            >
                                Chat {{ $pengguna->nomor_wa }}
                            </a>
                        @else
                            <span class="text-xs text-charcoal/50">-</span>
                        @endif
                    </td>
                    <td class="py-3.5 pr-4 font-semibold">{{ $pengguna->undangan_count }}</td>
                    <td class="py-3.5 text-right">
                        <form action="{{ route('admin.pengguna.reset-sandi', $pengguna) }}" method="POST" class="inline-flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <input type="text" name="kata_sandi_baru" required minlength="8" placeholder="Sandi baru (min 8)" class="w-40 rounded-lg border border-charcoal/15 bg-ivory/60 px-3 py-1.5 text-xs">
                            <button type="submit" class="rounded-lg bg-charcoal px-3 py-1.5 text-xs font-semibold text-champagne hover:bg-charcoal/90 cursor-pointer">
                                Reset Sandi
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-charcoal/60">Belum ada pengguna client terdaftar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $daftarPengguna->links() }}
    </div>
</div>
@endsection
