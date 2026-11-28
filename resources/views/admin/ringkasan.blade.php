@extends('admin.kerangka')

@section('judul', 'Dashboard Admin — SesiTemu')

@section('isi_admin')
@php
    $jamWib = (int) now()->format('H');
    $sapaanWaktu = match (true) {
        $jamWib >= 4 && $jamWib < 11 => 'Selamat Pagi,',
        $jamWib >= 11 && $jamWib < 15 => 'Selamat Siang,',
        $jamWib >= 15 && $jamWib < 18 => 'Selamat Sore,',
        default => 'Selamat Malam,',
    };

    $namaPengguna = auth()->user()?->nama ?? 'Administrator';
    $hurufAwal = strtoupper(mb_substr($namaPengguna, 0, 1));
@endphp

{{-- Welcome Banner --}}
<div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#23362E] via-[#344C41] to-[#435D51] p-6 sm:p-8 text-white shadow-sm border border-champagne/25">
    <div aria-hidden="true" class="pointer-events-none absolute -right-12 -top-12 w-56 h-56 rounded-full bg-champagne/10 blur-3xl"></div>

    <div class="relative flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div class="space-y-2.5 max-w-2xl">
            <div class="flex items-center gap-3.5">
                <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white/10 ring-1 ring-white/20 text-lg font-bold text-champagne">
                    {{ $hurufAwal }}
                </span>
                <div>
                    <p class="text-xs text-ivory/75">{{ $sapaanWaktu }}</p>
                    <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-white">{{ $namaPengguna }}</h1>
                </div>
            </div>

            <p class="text-xs sm:text-sm text-ivory/75 leading-relaxed">
                Selamat datang di Dashboard Admin SesiTemu. Pantau statistik client, aktivasi undangan, kelola katalog tema, dan bersihkan storage kedaluwarsa dengan mudah dalam satu tempat.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3 shrink-0">
            <form
                action="{{ route('admin.undangan.bersihkan') }}"
                method="POST"
                data-swal-title="Bersihkan Storage Kedaluwarsa?"
                data-swal-confirm="Jalankan pembersihan foto untuk seluruh undangan yang sudah kedaluwarsa?"
                data-swal-icon="warning"
                data-swal-confirm-button="Ya, Bersihkan"
                data-swal-confirm-color="#BFA15F"
                data-swal-loading-title="Membersihkan Storage..."
                data-swal-loading-text="Sedang menghapus foto undangan yang kedaluwarsa..."
            >
                @csrf
                <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl px-4 py-2 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs bg-champagne font-semibold text-[#203029] hover:brightness-105 transition shadow-sm cursor-pointer">
                    <svg class="w-4 h-4 sm:w-3.5 sm:h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span>Bersihkan Storage Kedaluwarsa ({{ $totalKedaluwarsa }})</span>
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Kartu Statistik Utama (6 KPI) --}}
<div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4">
    <div class="rounded-2xl bg-white p-5 shadow-sm border border-charcoal/10 flex items-center gap-3.5">
        <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-charcoal/10 text-charcoal">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </span>
        <div class="min-w-0">
            <p class="text-[11px] font-medium text-charcoal/60 truncate">Total Client</p>
            <p class="text-2xl font-bold text-charcoal leading-tight mt-0.5">{{ $totalClient }}</p>
        </div>
    </div>

    <div class="rounded-2xl bg-emerald-50/70 p-5 shadow-sm border border-emerald-200/80 flex items-center gap-3.5">
        <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </span>
        <div class="min-w-0">
            <p class="text-[11px] font-medium text-emerald-800/75 truncate">Undangan Aktif</p>
            <p class="text-2xl font-bold text-emerald-900 leading-tight mt-0.5">{{ $totalUndanganAktif }}</p>
        </div>
    </div>

    <div class="rounded-2xl bg-amber-50/75 p-5 shadow-sm border border-amber-200/80 flex items-center gap-3.5">
        <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </span>
        <div class="min-w-0">
            <p class="text-[11px] font-medium text-amber-900/75 truncate">Draft Aktivasi</p>
            <p class="text-2xl font-bold text-amber-950 leading-tight mt-0.5">{{ $totalDraft }}</p>
        </div>
    </div>

    <div class="rounded-2xl bg-rose-50/70 p-5 shadow-sm border border-rose-200/80 flex items-center gap-3.5">
        <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-rose-100 text-rose-700">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </span>
        <div class="min-w-0">
            <p class="text-[11px] font-medium text-rose-900/75 truncate">Kedaluwarsa</p>
            <p class="text-2xl font-bold text-rose-950 leading-tight mt-0.5">{{ $totalKedaluwarsa }}</p>
        </div>
    </div>

    <div class="rounded-2xl bg-sky-50/70 p-5 shadow-sm border border-sky-200/80 flex items-center gap-3.5">
        <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-sky-100 text-sky-700">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
            </svg>
        </span>
        <div class="min-w-0">
            <p class="text-[11px] font-medium text-sky-900/75 truncate">Tema Aktif</p>
            <p class="text-2xl font-bold text-sky-950 leading-tight mt-0.5">{{ $totalTemaAktif }}</p>
        </div>
    </div>

    <div class="rounded-2xl bg-violet-50/70 p-5 shadow-sm border border-violet-200/80 flex items-center gap-3.5">
        <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-violet-100 text-violet-700">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
        </span>
        <div class="min-w-0">
            <p class="text-[11px] font-medium text-violet-900/75 truncate">Ucapan &amp; RSVP</p>
            <p class="text-2xl font-bold text-violet-950 leading-tight mt-0.5">{{ $totalUcapan ?? 0 }}</p>
        </div>
    </div>
</div>

{{-- Pintasan Cepat --}}
<div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/20 space-y-4">
    <div class="flex items-center gap-3">
        <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-champagne/15 text-champagne">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
        </span>
        <div>
            <h2 class="text-base font-bold text-charcoal">Pintasan Cepat</h2>
            <p class="text-xs text-charcoal/60">Akses cepat ke fitur utama pengelolaan platform SesiTemu</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="{{ route('admin.undangan.index', ['status' => 'draft']) }}" class="group rounded-xl border border-charcoal/10 bg-ivory/40 p-4 hover:border-champagne hover:bg-ivory transition flex items-center gap-3.5">
            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-700">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </span>
            <div class="min-w-0">
                <p class="text-sm font-semibold text-charcoal group-hover:text-sage transition truncate">Aktivasi Undangan</p>
                <p class="text-xs text-charcoal/60 truncate">{{ $totalDraft }} draft menunggu</p>
            </div>
        </a>

        <a href="{{ route('admin.tema.index') }}" class="group rounded-xl border border-charcoal/10 bg-ivory/40 p-4 hover:border-champagne hover:bg-ivory transition flex items-center gap-3.5">
            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-sky-100 text-sky-700">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </span>
            <div class="min-w-0">
                <p class="text-sm font-semibold text-charcoal group-hover:text-sage transition truncate">Katalog Tema</p>
                <p class="text-xs text-charcoal/60 truncate">Atur kategori &amp; harga tema</p>
            </div>
        </a>

        <a href="{{ route('admin.pengguna.index') }}" class="group rounded-xl border border-charcoal/10 bg-ivory/40 p-4 hover:border-champagne hover:bg-ivory transition flex items-center gap-3.5">
            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </span>
            <div class="min-w-0">
                <p class="text-sm font-semibold text-charcoal group-hover:text-sage transition truncate">Manajemen Client</p>
                <p class="text-xs text-charcoal/60 truncate">Follow-up WA &amp; reset sandi</p>
            </div>
        </a>

        <a href="{{ route('admin.tema.create') }}" class="group rounded-xl border border-charcoal/10 bg-ivory/40 p-4 hover:border-champagne hover:bg-ivory transition flex items-center gap-3.5">
            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-champagne/20 text-champagne">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </span>
            <div class="min-w-0">
                <p class="text-sm font-semibold text-charcoal group-hover:text-sage transition truncate">Tambah Tema Baru</p>
                <p class="text-xs text-charcoal/60 truncate">Unggah desain tema baru</p>
            </div>
        </a>
    </div>
</div>

{{-- Undangan Terbaru --}}
<div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-champagne/20">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-base font-bold text-charcoal">Undangan Terbaru</h2>
            <p class="text-xs text-charcoal/60">Data undangan digital terbaru yang terdaftar</p>
        </div>
        <a href="{{ route('admin.undangan.index') }}" class="text-xs sm:text-sm font-semibold text-sage hover:underline">Lihat Semua →</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-champagne/20 text-left text-xs uppercase text-charcoal/60">
                    <th class="py-3 pr-4 text-center">Aksi</th>
                    <th class="py-3 pr-4">Pasangan &amp; Link</th>
                    <th class="py-3 pr-4">Client</th>
                    <th class="py-3 pr-4">Tema</th>
                    <th class="py-3 pr-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-champagne/15">
                @forelse ($undanganTerbaru as $item)
                    @php
                        $urlPublik = Route::has('undangan.tampil') ? route('undangan.tampil', $item->slug) : url('/'.$item->slug);
                    @endphp
                    <tr class="hover:bg-champagne/5 transition">
                        <td class="py-3 pr-4 text-center whitespace-nowrap">
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
                                    href="{{ route('dashboard.undangan.kelola', $item) }}"
                                    title="Edit Isian Client"
                                    class="inline-flex items-center gap-1 rounded-lg border border-champagne/50 bg-champagne/10 px-2.5 py-1.5 sm:px-2 sm:py-1 text-xs font-semibold text-charcoal hover:bg-champagne/25 transition"
                                >
                                    <svg class="h-3.5 w-3.5 text-amber-700 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/>
                                    </svg>
                                    <span>Edit Isian</span>
                                </a>
                            </div>
                        </td>
                        <td class="py-3 pr-4">
                            <p class="font-semibold text-charcoal">{{ $item->nama_panggilan_pria }} &amp; {{ $item->nama_panggilan_wanita }}</p>
                            <p class="text-xs font-mono text-sage">sesitemu.id/{{ $item->slug }}</p>
                        </td>
                        <td class="py-3 pr-4 text-charcoal/80">{{ $item->pengguna?->nama ?? '-' }}</td>
                        <td class="py-3 pr-4 text-charcoal/80">{{ $item->tema?->nama_tema ?? '-' }}</td>
                        <td class="py-3 pr-4">
                            @if ($item->sudahKedaluwarsa())
                                <span class="rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-700">Kedaluwarsa</span>
                            @elseif ($item->status_publikasi)
                                <span class="rounded-full bg-sage/15 px-2.5 py-0.5 text-xs font-semibold text-sage">Aktif</span>
                            @else
                                <span class="rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-800">Draft</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-sm text-charcoal/55">
                            Belum ada data undangan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
