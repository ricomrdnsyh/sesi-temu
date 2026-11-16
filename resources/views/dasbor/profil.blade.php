@extends('layouts.aplikasi')

@section('judul', 'Profil Akun — Client SesiTemu')

@section('konten')
@php
    $pesanWaBantuan = "Halo Admin SesiTemu, saya {$pengguna->nama} ({$pengguna->email}) butuh bantuan terkait akun saya.";
@endphp

<div class="min-h-screen flex flex-col bg-ivory">
    @include('dasbor._top-nav', ['halamanAktif' => 'profil', 'judulMobile' => 'Akun & Profil', 'lebarKontainer' => 'max-w-6xl'])

    <main class="flex-1 max-w-6xl w-full mx-auto px-4 sm:px-6 lg:px-8 pt-5 pb-28 md:py-8 space-y-5 md:space-y-6">
        @if ($errors->any())
            <div class="rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Kartu Hero Profil Ala Aplikasi Mobile --}}
        <section class="relative overflow-hidden rounded-3xl bg-charcoal text-ivory p-5 sm:p-7 shadow-md ring-1 ring-champagne/30">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-5">
                <div class="flex items-center gap-4 min-w-0">
                    <div class="h-16 w-16 sm:h-18 sm:w-18 rounded-2xl bg-champagne/20 border border-champagne/60 text-champagne font-serif text-2xl sm:text-3xl font-bold flex items-center justify-center shrink-0">
                        {{ $pengguna->inisialNama() }}
                    </div>

                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="rounded-full bg-champagne/20 border border-champagne/40 px-2.5 py-0.5 text-[11px] font-semibold uppercase tracking-wider text-champagne">
                                {{ $pengguna->adalahAdmin() ? 'Administrator' : 'Akun Client' }}
                            </span>
                            <span class="text-[11px] text-ivory/60">
                                Bergabung {{ $pengguna->created_at?->translatedFormat('M Y') ?? 'Baru' }}
                            </span>
                        </div>
                        <h1 class="mt-1.5 font-serif text-xl sm:text-2xl font-bold text-white truncate">
                            {{ $pengguna->nama }}
                        </h1>
                        <p class="text-xs sm:text-sm text-ivory/75 truncate">{{ $pengguna->email }}</p>
                        @if ($pengguna->nomor_wa)
                            <p class="mt-0.5 text-xs font-mono text-champagne/90">+{{ $pengguna->nomor_wa }}</p>
                        @endif
                    </div>
                </div>

                {{-- 3 Metrik Ringkas Akun --}}
                <div class="grid grid-cols-3 gap-2 sm:gap-3 rounded-2xl bg-white/8 border border-white/10 p-3 sm:px-5 sm:py-3.5 text-center shrink-0">
                    <div class="px-1 sm:px-2">
                        <p class="text-[11px] text-ivory/65">Undangan</p>
                        <p class="mt-0.5 font-serif text-lg sm:text-xl font-bold text-white">{{ $totalUndangan }}</p>
                    </div>
                    <div class="px-1 sm:px-2 border-x border-white/10">
                        <p class="text-[11px] text-ivory/65">Aktif</p>
                        <p class="mt-0.5 font-serif text-lg sm:text-xl font-bold text-champagne">{{ $totalUndanganAktif }}</p>
                    </div>
                    <div class="px-1 sm:px-2">
                        <p class="text-[11px] text-ivory/65">Transaksi</p>
                        <p class="mt-0.5 font-serif text-lg sm:text-xl font-bold text-white">{{ $totalTransaksi }}</p>
                    </div>
                </div>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-6 items-start">
            {{-- Kolom Kiri: Form Edit Biodata & Kata Sandi --}}
            <div class="lg:col-span-7 space-y-5">
                {{-- Form Data Profil --}}
                <section class="rounded-2xl bg-white p-4 sm:p-6 shadow-sm ring-1 ring-champagne/20">
                    <div class="flex items-center gap-2.5 pb-4 border-b border-champagne/15">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-sage/10 text-sage shrink-0">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="12" cy="8" r="4"/>
                                <path d="M20 21a8 8 0 0 0-16 0"/>
                            </svg>
                        </span>
                        <div>
                            <h2 class="font-serif text-lg sm:text-xl font-bold text-charcoal">Data Profil Saya</h2>
                            <p class="text-xs text-charcoal/65">Perbarui nama tampilan, email masuk, dan nomor WhatsApp aktif.</p>
                        </div>
                    </div>

                    <form
                        action="{{ route('dasbor.profil.perbarui') }}"
                        method="POST"
                        class="mt-4 space-y-4"
                        data-swal-loading
                        data-swal-loading-title="Menyimpan Profil..."
                        data-swal-loading-text="Sedang memperbarui data akun Anda..."
                    >
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="bagian" value="biodata">

                        <div>
                            <label for="profil_nama" class="block text-xs sm:text-sm font-semibold text-charcoal/85">Nama Lengkap</label>
                            <input
                                id="profil_nama"
                                name="nama"
                                type="text"
                                value="{{ old('nama', $pengguna->nama) }}"
                                required
                                class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm focus:border-champagne focus:bg-white focus:outline-none"
                            >
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="profil_email" class="block text-xs sm:text-sm font-semibold text-charcoal/85">Alamat Email</label>
                                <input
                                    id="profil_email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email', $pengguna->email) }}"
                                    required
                                    class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm focus:border-champagne focus:bg-white focus:outline-none"
                                >
                            </div>

                            <div>
                                <label for="profil_nomor_wa" class="block text-xs sm:text-sm font-semibold text-charcoal/85">Nomor WhatsApp</label>
                                <input
                                    id="profil_nomor_wa"
                                    name="nomor_wa"
                                    type="text"
                                    value="{{ old('nomor_wa', $pengguna->nomor_wa) }}"
                                    placeholder="Contoh: 081234567890"
                                    class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm font-mono focus:border-champagne focus:bg-white focus:outline-none"
                                >
                                <p class="mt-1 text-[11px] text-charcoal/55">Awalan 0 otomatis disimpan ke format 62.</p>
                            </div>
                        </div>

                        <div class="pt-1 flex justify-end">
                            <button type="submit" class="w-full sm:w-auto rounded-xl bg-sage px-6 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer">
                                Simpan Perubahan Profil
                            </button>
                        </div>
                    </form>
                </section>

                {{-- Form Ubah Kata Sandi --}}
                <section class="rounded-2xl bg-white p-4 sm:p-6 shadow-sm ring-1 ring-champagne/20">
                    <div class="flex items-center gap-2.5 pb-4 border-b border-champagne/15">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-champagne/15 text-charcoal shrink-0">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </span>
                        <div>
                            <h2 class="font-serif text-lg sm:text-xl font-bold text-charcoal">Keamanan &amp; Kata Sandi</h2>
                            <p class="text-xs text-charcoal/65">Ganti kata sandi secara berkala untuk menjaga keamanan akun.</p>
                        </div>
                    </div>

                    <form
                        action="{{ route('dasbor.profil.perbarui') }}"
                        method="POST"
                        class="mt-4 space-y-4"
                        data-swal-loading
                        data-swal-loading-title="Memperbarui Kata Sandi..."
                        data-swal-loading-text="Sedang mengenkripsi dan menyimpan kata sandi baru..."
                    >
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="bagian" value="kata_sandi">

                        <div>
                            <label for="kata_sandi_lama" class="block text-xs sm:text-sm font-semibold text-charcoal/85">Kata Sandi Saat Ini</label>
                            <input
                                id="kata_sandi_lama"
                                name="kata_sandi_lama"
                                type="password"
                                required
                                placeholder="Masukkan kata sandi lama"
                                class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm focus:border-champagne focus:bg-white focus:outline-none"
                            >
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="kata_sandi_baru" class="block text-xs sm:text-sm font-semibold text-charcoal/85">Kata Sandi Baru</label>
                                <input
                                    id="kata_sandi_baru"
                                    name="kata_sandi_baru"
                                    type="password"
                                    minlength="8"
                                    required
                                    placeholder="Minimal 8 karakter"
                                    class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm focus:border-champagne focus:bg-white focus:outline-none"
                                >
                            </div>

                            <div>
                                <label for="kata_sandi_baru_confirmation" class="block text-xs sm:text-sm font-semibold text-charcoal/85">Ulangi Kata Sandi Baru</label>
                                <input
                                    id="kata_sandi_baru_confirmation"
                                    name="kata_sandi_baru_confirmation"
                                    type="password"
                                    minlength="8"
                                    required
                                    placeholder="Ketik ulang kata sandi baru"
                                    class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm focus:border-champagne focus:bg-white focus:outline-none"
                                >
                            </div>
                        </div>

                        <div class="pt-1 flex justify-end">
                            <button type="submit" class="w-full sm:w-auto rounded-xl bg-charcoal px-6 py-2.5 text-sm font-semibold text-champagne hover:bg-charcoal/90 transition cursor-pointer">
                                Perbarui Kata Sandi
                            </button>
                        </div>
                    </form>
                </section>
            </div>

            {{-- Kolom Kanan: Menu Akun Gaya Aplikasi Mobile & Transaksi Terbaru --}}
            <div class="lg:col-span-5 space-y-5">
                {{-- Menu Pintas Aplikasi --}}
                <section class="rounded-2xl bg-white shadow-sm ring-1 ring-champagne/20 overflow-hidden">
                    <div class="px-4 sm:px-5 py-3.5 border-b border-champagne/15">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-charcoal/60">Menu Akun &amp; Bantuan</h2>
                    </div>

                    <div class="divide-y divide-champagne/15">
                        <a href="{{ route('dasbor.index') }}" class="flex items-center justify-between gap-3 px-4 sm:px-5 py-3.5 hover:bg-ivory transition">
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-sage/10 text-sage shrink-0">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <rect width="7" height="9" x="3" y="3" rx="1"/>
                                        <rect width="7" height="5" x="14" y="3" rx="1"/>
                                        <rect width="7" height="9" x="14" y="12" rx="1"/>
                                        <rect width="7" height="5" x="3" y="16" rx="1"/>
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-charcoal">Undangan Saya</p>
                                    <p class="text-xs text-charcoal/60 truncate">Kelola {{ $totalUndangan }} undangan digital Anda</p>
                                </div>
                            </div>
                            <span class="text-charcoal/40 text-lg leading-none">›</span>
                        </a>

                        <a href="{{ route('dasbor.katalog') }}" class="flex items-center justify-between gap-3 px-4 sm:px-5 py-3.5 hover:bg-ivory transition">
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-champagne/15 text-charcoal shrink-0">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/>
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-charcoal">Jelajahi Katalog Tema</p>
                                    <p class="text-xs text-charcoal/60 truncate">Lihat demo desain &amp; promo katalog</p>
                                </div>
                            </div>
                            <span class="text-charcoal/40 text-lg leading-none">›</span>
                        </a>

                        <a
                            href="{{ \App\Support\PengaturanSesiTemu::urlWaAdmin($pesanWaBantuan) }}"
                            target="_blank"
                            rel="noopener"
                            class="flex items-center justify-between gap-3 px-4 sm:px-5 py-3.5 hover:bg-ivory transition"
                        >
                            <div class="flex items-center gap-3 min-w-0">
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700 shrink-0">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-charcoal">Customer Service WhatsApp</p>
                                    <p class="text-xs text-charcoal/60 truncate">+{{ \App\Support\PengaturanSesiTemu::nomorWaAdmin() }}</p>
                                </div>
                            </div>
                            <span class="text-charcoal/40 text-lg leading-none">›</span>
                        </a>

                        @if ($pengguna->adalahAdmin())
                            <a href="{{ route('admin.ringkasan') }}" class="flex items-center justify-between gap-3 px-4 sm:px-5 py-3.5 hover:bg-ivory transition">
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-charcoal text-champagne shrink-0">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </span>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-charcoal">Panel Administrator</p>
                                        <p class="text-xs text-charcoal/60 truncate">Kelola seluruh platform SesiTemu</p>
                                    </div>
                                </div>
                                <span class="text-charcoal/40 text-lg leading-none">›</span>
                            </a>
                        @endif

                        <form
                            action="{{ route('keluar') }}"
                            method="POST"
                            data-swal-confirm="Yakin ingin keluar dari akun SesiTemu Anda?"
                            data-swal-title="Keluar dari Akun"
                            data-swal-confirm-button="Ya, Keluar"
                            data-swal-confirm-color="#DC2626"
                            data-swal-loading-title="Keluar dari Akun..."
                            data-swal-loading-text="Sedang mengakhiri sesi akun Anda..."
                        >
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-between gap-3 px-4 sm:px-5 py-3.5 text-left hover:bg-red-50/70 transition cursor-pointer">
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-red-50 text-red-600 shrink-0">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                            <polyline points="16 17 21 12 16 7"/>
                                            <line x1="21" x2="9" y1="12" y2="12"/>
                                        </svg>
                                    </span>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-red-700">Keluar dari Akun</p>
                                        <p class="text-xs text-red-500/80">Akhiri sesi login perangkat ini</p>
                                    </div>
                                </div>
                                <span class="text-red-300 text-lg leading-none">›</span>
                            </button>
                        </form>
                    </div>
                </section>

                {{-- Riwayat Transaksi Terbaru --}}
                <section class="rounded-2xl bg-white p-4 sm:p-5 shadow-sm ring-1 ring-champagne/20 space-y-3">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-charcoal/60">Transaksi Terbaru</h2>
                        <span class="text-xs text-charcoal/55">{{ $totalTransaksi }} total</span>
                    </div>

                    @forelse ($riwayatTransaksi as $trx)
                        <div class="rounded-xl bg-ivory/75 p-3.5 ring-1 ring-champagne/20 space-y-1.5">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <p class="font-mono text-xs font-bold text-charcoal">{{ $trx->kode_invoice }}</p>
                                    <p class="text-xs text-charcoal/70 truncate">
                                        {{ $trx->undangan?->nama_panggilan_pria }} &amp; {{ $trx->undangan?->nama_panggilan_wanita }} • {{ $trx->tema?->nama_tema }}
                                    </p>
                                </div>
                                <span class="rounded-full px-2.5 py-0.5 text-[11px] font-semibold shrink-0 {{ $trx->status === 'lunas' ? 'bg-sage/15 text-sage' : ($trx->status === 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-800') }}">
                                    {{ $trx->labelStatus() }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between pt-1">
                                <span class="text-sm font-bold text-charcoal">{{ \App\Models\Tema::formatRupiah($trx->total_bayar) }}</span>
                                @if ($trx->undangan)
                                    <a href="{{ route('dasbor.undangan.kelola', [$trx->undangan, 'tab' => 'aktivasi']) }}" class="text-xs font-semibold text-sage hover:underline">
                                        Detail Pembayaran ›
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="py-4 text-center text-xs text-charcoal/60">Belum ada riwayat transaksi pembayaran.</p>
                    @endforelse
                </section>
            </div>
        </div>
    </main>

    @include('dasbor._bottom-nav', ['halamanAktif' => 'profil', 'modalBuatOnPage' => false])
</div>
@endsection
