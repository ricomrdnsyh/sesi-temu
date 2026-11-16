@extends('admin.kerangka')

@section('judul', 'Manajemen Pengguna — Admin SesiTemu')

@section('isi_admin')
<div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4">
    <div>
        <h1 class="font-serif text-2xl sm:text-3xl font-bold text-charcoal">Manajemen Pengguna</h1>
        <p class="text-sm text-charcoal/70 mt-1">Kelola akun Admin &amp; Client, ubah data atau reset sandi lewat form Edit, dan pantau detail undangan tiap pengguna.</p>
    </div>

    <div class="flex flex-col sm:flex-row flex-wrap items-stretch sm:items-center gap-2 w-full xl:w-auto">
        <form action="{{ route('admin.pengguna.index') }}" method="GET" class="flex flex-col sm:flex-row flex-wrap gap-2">
            <input
                type="text"
                name="q"
                value="{{ $pencarian }}"
                placeholder="Cari nama, email, atau WA..."
                class="w-full sm:w-56 rounded-xl border border-charcoal/15 bg-white px-4 py-2 text-sm focus:border-champagne focus:outline-none"
            >
            <select name="peran" class="w-full sm:w-auto rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm">
                <option value="semua" @selected($peran === 'semua')>Semua Peran</option>
                <option value="admin" @selected($peran === 'admin')>Admin</option>
                <option value="client" @selected($peran === 'client')>Client</option>
            </select>
            <button type="submit" class="rounded-xl border border-charcoal/15 bg-white px-4 py-2 text-sm font-semibold text-charcoal hover:bg-ivory cursor-pointer shrink-0">
                Filter
            </button>
        </form>

        <a
            href="{{ route('admin.pengguna.create') }}"
            class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-sage px-4 py-2 text-sm font-semibold text-white hover:bg-sage/90 transition shrink-0"
        >
            <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <line x1="19" x2="19" y1="8" y2="14"/>
                <line x1="22" x2="16" y1="11" y2="11"/>
            </svg>
            <span>+ Tambah Pengguna</span>
        </a>
    </div>
</div>

{{-- 3 KPI Ringkas Pengguna --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-champagne/20">
        <p class="text-xs font-medium text-charcoal/60">Total Semua Pengguna</p>
        <p class="mt-1.5 text-2xl font-bold text-charcoal">{{ $totalSemua }}</p>
    </div>
    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-champagne/30">
        <p class="text-xs font-medium text-charcoal/60">Akun Administrator</p>
        <p class="mt-1.5 text-2xl font-bold text-charcoal">{{ $totalAdmin }}</p>
    </div>
    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-sage/25">
        <p class="text-xs font-medium text-charcoal/60">Akun Client</p>
        <p class="mt-1.5 text-2xl font-bold text-sage">{{ $totalClient }}</p>
    </div>
</div>

<div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/20">
    <table data-datatable data-page-length="10" data-empty-message="Belum ada pengguna yang cocok dengan filter." class="w-full text-sm">
        <thead>
            <tr class="border-b border-champagne/20 text-left text-xs uppercase text-charcoal/60">
                <th data-no-sort class="py-3 dt-center text-center">Aksi</th>
                <th class="py-3 pr-4">Nama &amp; Email</th>
                <th class="py-3 pr-4">Peran</th>
                <th class="py-3 pr-4">WhatsApp</th>
                <th class="py-3 pr-4 dt-left">Undangan</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-champagne/15">
            @foreach ($daftarPengguna as $pengguna)
                @php
                    $waBersih = preg_replace('/[^0-9]/', '', (string) $pengguna->nomor_wa);
                    if ($waBersih && str_starts_with($waBersih, '0')) {
                        $waBersih = '62'.substr($waBersih, 1);
                    }
                    $akunSendiri = auth()->id() === $pengguna->id;
                @endphp
                <tr>
                    <td class="py-3.5 dt-center text-center whitespace-nowrap">
                        <div class="inline-flex items-center justify-center gap-1.5">
                            <a
                                href="{{ route('admin.pengguna.show', $pengguna) }}"
                                title="Lihat Detail Pengguna"
                                class="inline-flex items-center gap-1.5 rounded-lg border border-charcoal/15 bg-white px-2.5 py-1.5 text-xs font-semibold text-charcoal hover:border-sage/40 hover:bg-sage/5 hover:text-sage transition"
                            >
                                <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                <span>Detail</span>
                            </a>

                            <a
                                href="{{ route('admin.pengguna.edit', $pengguna) }}"
                                title="Edit Data &amp; Reset Kata Sandi"
                                class="inline-flex items-center gap-1.5 rounded-lg border border-champagne/50 bg-champagne/10 px-2.5 py-1.5 text-xs font-semibold text-charcoal hover:bg-champagne/25 transition"
                            >
                                <svg class="h-3.5 w-3.5 text-amber-700 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/>
                                </svg>
                                <span>Edit</span>
                            </a>

                            @if (! $akunSendiri)
                                <form
                                    action="{{ route('admin.pengguna.destroy', $pengguna) }}"
                                    method="POST"
                                    data-swal-title="Hapus Pengguna?"
                                    data-swal-confirm="Yakin ingin menghapus akun {{ $pengguna->nama }} ({{ $pengguna->email }})?"
                                    data-swal-icon="warning"
                                    data-swal-confirm-button="Ya, Hapus"
                                    data-swal-confirm-color="#DC2626"
                                    data-swal-loading-title="Menghapus Pengguna..."
                                    data-swal-loading-text="Sedang menghapus akun pengguna..."
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Pengguna" class="inline-flex items-center gap-1 rounded-lg border border-red-200 bg-red-50 px-2.5 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-100 cursor-pointer transition">
                                        <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M3 6h18"/>
                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                        </svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                    <td class="py-3.5 pr-4">
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-charcoal">{{ $pengguna->nama }}</span>
                            @if ($akunSendiri)
                                <span class="rounded-full bg-champagne/25 px-2 py-0.5 text-[10px] font-bold text-charcoal">Akun Anda</span>
                            @endif
                        </div>
                        <p class="text-xs text-charcoal/65">{{ $pengguna->email }}</p>
                    </td>
                    <td class="py-3.5 pr-4">
                        @if ($pengguna->peran === 'admin')
                            <span class="rounded-full bg-charcoal px-2.5 py-0.5 text-xs font-semibold text-champagne">Admin</span>
                        @else
                            <span class="rounded-full bg-sage/15 px-2.5 py-0.5 text-xs font-semibold text-sage">Client</span>
                        @endif
                    </td>
                    <td class="py-3.5 pr-4">
                        @if ($waBersih)
                            <a
                                href="https://wa.me/{{ $waBersih }}?text={{ urlencode('Halo Kak '.$pengguna->nama.', kami dari tim SesiTemu siap membantu Anda.') }}"
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
