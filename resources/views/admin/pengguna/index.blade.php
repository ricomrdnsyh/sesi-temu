@extends('admin.tata-letak')

@section('judul', 'Manajemen Pengguna — Admin SesiTemu')

@section('isi_admin')
<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
    <div>
        <h1 class="font-serif text-2xl sm:text-3xl font-bold text-charcoal">Manajemen Client &amp; Follow-Up</h1>
        <p class="text-sm text-charcoal/70 mt-1">Hubungi client via WhatsApp atau lakukan reset kata sandi secara manual.</p>
    </div>

    <form action="{{ route('admin.pengguna.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2 w-full lg:w-auto">
        <input type="text" name="q" value="{{ $pencarian }}" placeholder="Cari nama, email, atau WA..." class="w-full sm:w-72 rounded-xl border border-charcoal/15 bg-white px-4 py-2 text-sm focus:border-champagne focus:outline-none">
        <button type="submit" class="rounded-xl bg-sage px-5 py-2 text-sm font-semibold text-white hover:bg-sage/90 cursor-pointer shrink-0">Cari</button>
    </form>
</div>

<div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/20">
    <table data-datatable data-page-length="10" data-empty-message="Belum ada pengguna client terdaftar." class="w-full text-sm">
        <thead>
            <tr class="border-b border-champagne/20 text-left text-xs uppercase text-charcoal/60">
                <th data-no-sort class="py-3 dt-center text-center">Aksi</th>
                <th class="py-3 pr-4">Nama Client</th>
                <th class="py-3 pr-4">Email</th>
                <th class="py-3 pr-4">WhatsApp</th>
                <th class="py-3 pr-4 dt-left">Jumlah Undangan</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-champagne/15">
            @foreach ($daftarPengguna as $pengguna)
                @php
                    $waBersih = preg_replace('/[^0-9]/', '', (string) $pengguna->nomor_wa);
                    if ($waBersih && str_starts_with($waBersih, '0')) {
                        $waBersih = '62'.substr($waBersih, 1);
                    }
                @endphp
                <tr>
                    <td class="py-3.5 dt-center text-center whitespace-nowrap">
                        <form
                            action="{{ route('admin.pengguna.reset-sandi', $pengguna) }}"
                            method="POST"
                            class="inline-flex items-center justify-center gap-1.5"
                            data-swal-loading
                            data-swal-loading-title="Mereset Kata Sandi..."
                            data-swal-loading-text="Sedang memperbarui kata sandi untuk {{ $pengguna->nama }}..."
                        >
                            @csrf
                            @method('PATCH')
                            <input type="text" name="kata_sandi_baru" required minlength="8" placeholder="Sandi baru (min 8)" class="w-36 rounded-lg border border-charcoal/15 bg-ivory/60 px-2.5 py-1.5 text-xs focus:border-champagne focus:outline-none">
                            <button type="submit" title="Reset Kata Sandi Manual" class="inline-flex items-center gap-1.5 rounded-lg bg-charcoal px-2.5 py-1.5 text-xs font-semibold text-champagne hover:bg-charcoal/90 cursor-pointer transition">
                                <svg class="h-3.5 w-3.5 text-champagne shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="m15.5 7.5 2.3 2.3a1 1 0 0 0 1.4 0l2.1-2.1a1 1 0 0 0 0-1.4L19 4"/>
                                    <path d="m21 2-9.6 9.6"/>
                                    <circle cx="7.5" cy="15.5" r="5.5"/>
                                </svg>
                                <span>Reset Sandi</span>
                            </button>
                        </form>
                    </td>
                    <td class="py-3.5 pr-4 font-semibold text-charcoal">{{ $pengguna->nama }}</td>
                    <td class="py-3.5 pr-4 text-charcoal/80">{{ $pengguna->email }}</td>
                    <td class="py-3.5 pr-4">
                        @if ($waBersih)
                            <a
                                href="https://wa.me/{{ $waBersih }}?text={{ urlencode('Halo Kak '.$pengguna->nama.', kami dari tim SesiTemu siap membantu proses aktivasi undangan Anda.') }}"
                                target="_blank"
                                rel="noopener"
                                class="inline-flex items-center gap-1.5 rounded-lg bg-sage/10 px-3 py-1 text-xs font-semibold text-sage hover:bg-sage/20 transition"
                            >
                                <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/>
                                </svg>
                                <span>Chat {{ $pengguna->nomor_wa }}</span>
                            </a>
                        @else
                            <span class="text-xs text-charcoal/50">-</span>
                        @endif
                    </td>
                    <td class="py-3.5 pr-4 font-semibold dt-left">{{ $pengguna->undangan_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
