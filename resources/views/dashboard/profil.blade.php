@extends('layouts.aplikasi')

@section('judul', 'Profil Akun — Client SesiTemu')

@section('konten')
    @php
        $pesanWaBantuan = "Halo Admin SesiTemu, saya {$pengguna->nama} ({$pengguna->email}) butuh bantuan terkait akun saya.";
    @endphp

    <div class="min-h-screen flex bg-ivory">
        @include('dashboard._client-sidebar', ['halamanAktif' => 'profil'])

        <div class="flex-1 min-w-0 flex flex-col">
            @include('dashboard._top-nav', ['halamanAktif' => 'profil'])

            <main class="flex-1 w-full px-4 sm:px-6 lg:px-8 xl:px-10 pt-4 sm:pt-6 pb-28 md:py-8 space-y-5 sm:space-y-6">
            {{-- Kartu Profil Bergaya Centered Floating Card & Geometric Backdrop --}}
            <section
                class="relative overflow-hidden rounded-[1.75rem] bg-ivory/90 shadow-xs ring-1 ring-champagne/25 pb-4 sm:pb-6">
                {{-- Latar Atas Geometris 2-Warna (Hijau Sage & Lingkaran Champagne) --}}
                <div class="relative h-28 sm:h-32 overflow-hidden bg-gradient-to-r from-[#354A40] via-sage to-[#445B50]">
                    <div aria-hidden="true"
                        class="pointer-events-none absolute -right-10 -top-16 h-56 w-56 sm:h-72 sm:w-72 rounded-full bg-champagne/85">
                    </div>
                    <div aria-hidden="true"
                        class="pointer-events-none absolute right-24 -bottom-16 h-36 w-36 rounded-full bg-champagne/35">
                    </div>
                    <div aria-hidden="true"
                        class="pointer-events-none absolute -left-10 -bottom-12 h-36 w-36 rounded-full bg-black/15">
                    </div>
                </div>

                {{-- Kartu Putih Mengambang di Tengah dengan Avatar Lingkaran Menonjol di Atas --}}
                <div class="relative z-10 px-4 sm:px-6">
                    <div
                        class="mx-auto max-w-2xl -mt-12 sm:-mt-14 rounded-3xl bg-white px-5 sm:px-8 pb-6 pt-0 text-center shadow-md ring-1 ring-champagne/20">
                        {{-- Avatar Lingkaran Tengah --}}
                        <div class="relative -top-10 sm:-top-11 -mb-7 sm:-mb-8 inline-flex">
                            <div class="rounded-full bg-white p-1.5 shadow-md ring-1 ring-champagne/20">
                                <div
                                    class="h-20 w-20 sm:h-24 sm:w-24 rounded-full bg-gradient-to-br from-sage via-[#445B50] to-[#354A40] text-[#F5E3B8] font-sans text-2xl sm:text-3xl font-bold flex items-center justify-center ring-2 ring-champagne/40 select-none">
                                    {{ $pengguna->inisialNama() }}
                                </div>
                            </div>
                            <span class="absolute bottom-2 right-2 h-4 w-4 rounded-full bg-emerald-500 ring-2 ring-white"
                                title="Akun Aktif"></span>
                        </div>

                        {{-- Nama Lengkap & Email --}}
                        <div class="space-y-1">
                            <h1 class="font-sans text-xl sm:text-2xl font-bold text-charcoal tracking-tight leading-snug">
                                {{ $pengguna->nama }}
                            </h1>
                            <p class="text-xs sm:text-sm text-charcoal/60">
                                {{ $pengguna->email }}
                            </p>
                        </div>

                        {{-- Baris Info Kontak & Tanggal Bergabung --}}
                        <div class="mt-3.5 flex flex-wrap items-center justify-center gap-2 sm:gap-2.5 text-xs">
                            @if ($pengguna->nomor_wa)
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full bg-sage/10 px-3 py-1 font-mono font-semibold text-sage ring-1 ring-sage/20">
                                    <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" aria-hidden="true">
                                        <path
                                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                                    </svg>
                                    <span>+{{ $pengguna->nomor_wa }}</span>
                                </span>
                            @endif

                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-ivory px-3 py-1 font-medium text-charcoal/70 ring-1 ring-champagne/30">
                                <svg class="h-3.5 w-3.5 text-[#8A6D33] shrink-0" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    aria-hidden="true">
                                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                                    <line x1="16" x2="16" y1="2" y2="6" />
                                    <line x1="8" x2="8" y1="2" y2="6" />
                                    <line x1="3" x2="21" y1="10" y2="10" />
                                </svg>
                                <span>Bergabung {{ $pengguna->created_at?->translatedFormat('M Y') ?? 'Baru' }}</span>
                            </span>
                        </div>

                        {{-- 3 Metrik Akun dengan Garis Pemisah Vertikal --}}
                        <div class="mt-5 pt-5 border-t border-champagne/20 grid grid-cols-3 max-w-md mx-auto text-center">
                            <div class="px-2">
                                <p class="font-sans tabular-nums text-lg sm:text-xl font-bold text-charcoal leading-none">
                                    {{ $totalUndangan }}</p>
                                <p class="mt-1.5 text-xs font-medium text-charcoal/55">Undangan</p>
                            </div>
                            <div class="px-2 border-x border-champagne/30">
                                <p class="font-sans tabular-nums text-lg sm:text-xl font-bold text-sage leading-none">
                                    {{ $totalUndanganAktif }}</p>
                                <p class="mt-1.5 text-xs font-medium text-charcoal/55">Aktif</p>
                            </div>
                            <div class="px-2">
                                <p class="font-sans tabular-nums text-lg sm:text-xl font-bold text-[#8A6D33] leading-none">
                                    {{ $totalTransaksi }}</p>
                                <p class="mt-1.5 text-xs font-medium text-charcoal/55">Transaksi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Grid 2x2 Sejajar Penuh (Row 1: Data Profil + Menu Akun, Row 2: Keamanan + Transaksi) --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-6 items-stretch">
                {{-- Kartu 1 (Kiri Atas): Form Data Profil --}}
                <section
                    class="order-1 lg:col-span-7 h-full rounded-[1.5rem] bg-white p-5 sm:p-6 shadow-xs ring-1 ring-champagne/25 flex flex-col justify-between">
                    <div class="flex items-center gap-3 pb-4 border-b border-champagne/15">
                        <span
                            class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-sage/10 text-sage ring-1 ring-sage/20 shrink-0">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="12" cy="8" r="4" />
                                <path d="M20 21a8 8 0 0 0-16 0" />
                            </svg>
                        </span>
                        <div>
                            <h2 class="font-sans text-base sm:text-lg font-bold text-charcoal tracking-tight">
                                Data Profil Saya
                            </h2>
                            <p class="text-xs text-charcoal/60">Perbarui nama tampilan, email masuk, dan nomor WhatsApp
                                aktif.</p>
                        </div>
                    </div>

                    <form action="{{ route('dashboard.profil.perbarui') }}" method="POST"
                        class="mt-4 flex-1 flex flex-col justify-between gap-4" data-swal-loading
                        data-swal-loading-title="Menyimpan Profil..."
                        data-swal-loading-text="Sedang memperbarui data akun Anda...">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="bagian" value="biodata">

                        <div class="space-y-4">
                            <div>
                                <label for="profil_nama"
                                    class="block text-xs sm:text-sm font-semibold text-charcoal/85">Nama Lengkap</label>
                                <div class="relative mt-1.5">
                                    <svg class="h-4 w-4 text-charcoal/40 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <circle cx="12" cy="8" r="4" />
                                        <path d="M20 21a8 8 0 0 0-16 0" />
                                    </svg>
                                    <input id="profil_nama" name="nama" type="text"
                                        value="{{ old('nama', $pengguna->nama) }}" required
                                        class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 pl-10 pr-4 py-2.5 text-sm text-charcoal focus:border-sage focus:bg-white focus:ring-2 focus:ring-sage/15 focus:outline-none transition">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="profil_email"
                                        class="block text-xs sm:text-sm font-semibold text-charcoal/85">Alamat
                                        Email</label>
                                    <div class="relative mt-1.5">
                                        <svg class="h-4 w-4 text-charcoal/40 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <rect width="20" height="16" x="2" y="4" rx="2" />
                                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                                        </svg>
                                        <input id="profil_email" name="email" type="email"
                                            value="{{ old('email', $pengguna->email) }}" required
                                            class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 pl-10 pr-4 py-2.5 text-sm text-charcoal focus:border-sage focus:bg-white focus:ring-2 focus:ring-sage/15 focus:outline-none transition">
                                    </div>
                                </div>

                                <div>
                                    <label for="profil_nomor_wa"
                                        class="block text-xs sm:text-sm font-semibold text-charcoal/85">Nomor
                                        WhatsApp</label>
                                    <div class="relative mt-1.5">
                                        <svg class="h-4 w-4 text-charcoal/40 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path
                                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                                        </svg>
                                        <input id="profil_nomor_wa" name="nomor_wa" type="text"
                                            value="{{ old('nomor_wa', $pengguna->nomor_wa) }}"
                                            placeholder="Contoh: 081234567890"
                                            class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 pl-10 pr-4 py-2.5 text-sm font-mono text-charcoal focus:border-sage focus:bg-white focus:ring-2 focus:ring-sage/15 focus:outline-none transition">
                                    </div>
                                    <p class="mt-1 text-[11px] text-charcoal/55">Awalan 0 otomatis disimpan ke format 62.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-1 flex justify-end">
                            <button type="submit"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-sage px-5 py-2.5 text-xs sm:text-sm font-semibold text-white shadow-xs hover:bg-[#3b5047] active:scale-95 transition cursor-pointer">
                                <svg class="h-4 w-4 text-[#F5E3B8] shrink-0" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" aria-hidden="true">
                                    <path
                                        d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                                    <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                                    <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                                </svg>
                                <span>Simpan Perubahan Profil</span>
                            </button>
                        </div>
                    </form>
                </section>

                {{-- Kartu 2 (Kanan Atas di Web, Urutan 3 di Mobile): Menu Akun & Bantuan --}}
                <section
                    class="order-3 lg:order-2 lg:col-span-5 h-full rounded-[1.5rem] bg-white shadow-xs ring-1 ring-champagne/25 overflow-hidden flex flex-col">
                    <div class="px-5 py-4 border-b border-champagne/15 flex items-center gap-3">
                        <span
                            class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-ivory text-sage ring-1 ring-champagne/25 shrink-0">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="7" height="7" x="3" y="3" rx="1.5" />
                                <rect width="7" height="7" x="14" y="3" rx="1.5" />
                                <rect width="7" height="7" x="14" y="14" rx="1.5" />
                                <rect width="7" height="7" x="3" y="14" rx="1.5" />
                            </svg>
                        </span>
                        <div>
                            <h2 class="font-sans text-base sm:text-lg font-bold text-charcoal tracking-tight">Menu Akun
                                &amp; Bantuan</h2>
                            <p class="text-xs text-charcoal/60">Navigasi cepat &amp; layanan bantuan SesiTemu.</p>
                        </div>
                    </div>

                    <div class="flex-1 flex flex-col justify-between p-3.5 sm:p-4 gap-2.5">
                        <a href="{{ route('dashboard.index') }}"
                            class="group flex items-center justify-between gap-3 rounded-2xl bg-ivory/65 px-3.5 py-3 ring-1 ring-champagne/20 hover:bg-sage/[0.08] hover:ring-sage/35 hover:-translate-y-0.5 hover:shadow-xs active:scale-[0.99] transition-all duration-200">
                            <div class="flex items-center gap-3.5 min-w-0">
                                <span
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-sage/10 text-sage ring-1 ring-sage/20 group-hover:bg-sage group-hover:text-white group-hover:scale-105 group-hover:shadow-xs transition-all duration-200 shrink-0">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        aria-hidden="true">
                                        <rect width="20" height="16" x="2" y="4" rx="2" />
                                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-charcoal group-hover:text-sage transition-colors">
                                        Undangan Saya</p>
                                    <p class="text-xs text-charcoal/60 truncate">Kelola {{ $totalUndangan }} undangan
                                        digital Anda</p>
                                </div>
                            </div>
                            <span
                                class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-white text-charcoal/40 ring-1 ring-champagne/25 group-hover:bg-sage group-hover:text-white group-hover:ring-sage group-hover:translate-x-0.5 transition-all duration-200 shrink-0">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
                                    aria-hidden="true">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </span>
                        </a>

                        <a href="{{ route('dashboard.katalog') }}"
                            class="group flex items-center justify-between gap-3 rounded-2xl bg-ivory/65 px-3.5 py-3 ring-1 ring-champagne/20 hover:bg-champagne/12 hover:ring-champagne/55 hover:-translate-y-0.5 hover:shadow-xs active:scale-[0.99] transition-all duration-200">
                            <div class="flex items-center gap-3.5 min-w-0">
                                <span
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-champagne/15 text-[#8A6D33] ring-1 ring-champagne/30 group-hover:bg-[#8A6D33] group-hover:text-white group-hover:scale-105 group-hover:shadow-xs transition-all duration-200 shrink-0">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        aria-hidden="true">
                                        <circle cx="13.5" cy="6.5" r=".5" fill="currentColor" />
                                        <circle cx="17.5" cy="10.5" r=".5" fill="currentColor" />
                                        <circle cx="8.5" cy="7.5" r=".5" fill="currentColor" />
                                        <circle cx="6.5" cy="12.5" r=".5" fill="currentColor" />
                                        <path
                                            d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z" />
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <p
                                        class="text-sm font-semibold text-charcoal group-hover:text-[#8A6D33] transition-colors">
                                        Jelajahi Katalog Tema</p>
                                    <p class="text-xs text-charcoal/60 truncate">Lihat demo desain &amp; promo katalog</p>
                                </div>
                            </div>
                            <span
                                class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-white text-charcoal/40 ring-1 ring-champagne/25 group-hover:bg-[#8A6D33] group-hover:text-white group-hover:ring-[#8A6D33] group-hover:translate-x-0.5 transition-all duration-200 shrink-0">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
                                    aria-hidden="true">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </span>
                        </a>

                        <a href="{{ \App\Support\PengaturanSesiTemu::urlWaAdmin($pesanWaBantuan) }}" target="_blank"
                            rel="noopener"
                            class="group flex items-center justify-between gap-3 rounded-2xl bg-ivory/65 px-3.5 py-3 ring-1 ring-champagne/20 hover:bg-emerald-50/90 hover:ring-emerald-300/80 hover:-translate-y-0.5 hover:shadow-xs active:scale-[0.99] transition-all duration-200">
                            <div class="flex items-center gap-3.5 min-w-0">
                                <span
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/70 group-hover:bg-emerald-600 group-hover:text-white group-hover:scale-105 group-hover:shadow-xs transition-all duration-200 shrink-0">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path
                                            d="M12.031 2c-5.516 0-9.969 4.453-9.969 9.969 0 1.766.469 3.484 1.344 5l-1.406 5.156 5.281-1.375c1.469.797 3.109 1.219 4.75 1.219 5.516 0 9.969-4.453 9.969-9.969S17.547 2 12.031 2Zm5.813 14.125c-.25.703-1.438 1.344-2 1.422-.516.078-1.172.109-1.891-.125-.438-.141-1-.328-1.719-.641-3.016-1.313-4.984-4.359-5.141-4.563-.156-.203-1.234-1.641-1.234-3.125s.781-2.219 1.063-2.516c.281-.297.609-.375.813-.375.203 0 .406 0 .578.016.188.016.438-.078.688.531.25.609.859 2.094.938 2.25.078.156.125.344.016.547-.109.203-.156.344-.313.516-.156.172-.328.391-.469.516-.156.156-.313.328-.141.641.172.313.781 1.297 1.672 2.094 1.156 1.031 2.125 1.344 2.438 1.5.313.156.484.125.672-.078.188-.203.781-.906.984-1.219.203-.313.406-.266.688-.156.281.109 1.797.844 2.109 1 .313.156.516.234.594.359.078.125.078.734-.172 1.438Z" />
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <p
                                        class="text-sm font-semibold text-charcoal group-hover:text-emerald-700 transition-colors">
                                        Customer Service WhatsApp</p>
                                    <p class="text-xs text-charcoal/60 truncate">
                                        +{{ \App\Support\PengaturanSesiTemu::nomorWaAdmin() }}</p>
                                </div>
                            </div>
                            <span
                                class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-white text-charcoal/40 ring-1 ring-champagne/25 group-hover:bg-emerald-600 group-hover:text-white group-hover:ring-emerald-600 group-hover:translate-x-0.5 transition-all duration-200 shrink-0">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
                                    aria-hidden="true">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </span>
                        </a>

                        @if ($pengguna->adalahAdmin())
                            <a href="{{ route('admin.ringkasan') }}"
                                class="group flex items-center justify-between gap-3 rounded-2xl bg-ivory/65 px-3.5 py-3 ring-1 ring-champagne/20 hover:bg-sage/[0.08] hover:ring-sage/35 hover:-translate-y-0.5 hover:shadow-xs active:scale-[0.99] transition-all duration-200">
                                <div class="flex items-center gap-3.5 min-w-0">
                                    <span
                                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-sage text-[#F5E3B8] group-hover:scale-105 transition-transform duration-200 shrink-0">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            aria-hidden="true">
                                            <path
                                                d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </span>
                                    <div class="min-w-0">
                                        <p
                                            class="text-sm font-semibold text-charcoal group-hover:text-sage transition-colors">
                                            Panel Administrator</p>
                                        <p class="text-xs text-charcoal/60 truncate">Kelola seluruh platform SesiTemu</p>
                                    </div>
                                </div>
                                <span
                                    class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-white text-charcoal/40 ring-1 ring-champagne/25 group-hover:bg-sage group-hover:text-white group-hover:ring-sage group-hover:translate-x-0.5 transition-all duration-200 shrink-0">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
                                        aria-hidden="true">
                                        <path d="m9 18 6-6-6-6" />
                                    </svg>
                                </span>
                            </a>
                        @endif

                        <form action="{{ route('keluar') }}" method="POST"
                            data-swal-confirm="Yakin ingin keluar dari akun SesiTemu Anda?"
                            data-swal-title="Keluar dari Akun" data-swal-confirm-button="Ya, Keluar"
                            data-swal-confirm-color="#DC2626" data-swal-loading-title="Keluar dari Akun..."
                            data-swal-loading-text="Sedang mengakhiri sesi akun Anda...">
                            @csrf
                            <button type="submit"
                                class="group w-full flex items-center justify-between gap-3 rounded-2xl bg-red-50/45 px-3.5 py-3 text-left ring-1 ring-red-100 hover:bg-red-50 hover:ring-red-200 hover:-translate-y-0.5 hover:shadow-xs active:scale-[0.99] transition-all duration-200 cursor-pointer">
                                <div class="flex items-center gap-3.5 min-w-0">
                                    <span
                                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 text-red-600 ring-1 ring-red-200/70 group-hover:bg-red-600 group-hover:text-white group-hover:scale-105 group-hover:shadow-xs transition-all duration-200 shrink-0">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            aria-hidden="true">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                            <polyline points="16 17 21 12 16 7" />
                                            <line x1="21" x2="9" y1="12" y2="12" />
                                        </svg>
                                    </span>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-red-700">Keluar dari Akun</p>
                                        <p class="text-xs text-red-500/80">Akhiri sesi login perangkat ini</p>
                                    </div>
                                </div>
                                <span
                                    class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-white text-red-400 ring-1 ring-red-100 group-hover:bg-red-600 group-hover:text-white group-hover:ring-red-600 group-hover:translate-x-0.5 transition-all duration-200 shrink-0">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
                                        aria-hidden="true">
                                        <path d="m9 18 6-6-6-6" />
                                    </svg>
                                </span>
                            </button>
                        </form>
                    </div>
                </section>

                {{-- Kartu 3 (Kiri Bawah di Web, Urutan 2 di Mobile): Keamanan & Kata Sandi --}}
                <section
                    class="order-2 lg:order-3 lg:col-span-7 h-full rounded-[1.5rem] bg-white p-5 sm:p-6 shadow-xs ring-1 ring-champagne/25 flex flex-col justify-between">
                    <div class="flex items-center gap-3 pb-4 border-b border-champagne/15">
                        <span
                            class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-champagne/15 text-[#8A6D33] ring-1 ring-champagne/30 shrink-0">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                        </span>
                        <div>
                            <h2 class="font-sans text-base sm:text-lg font-bold text-charcoal tracking-tight">Keamanan
                                &amp; Kata Sandi</h2>
                            <p class="text-xs text-charcoal/60">Ganti kata sandi secara berkala untuk menjaga keamanan
                                akun.</p>
                        </div>
                    </div>

                    <form action="{{ route('dashboard.profil.perbarui') }}" method="POST"
                        class="mt-4 flex-1 flex flex-col justify-between gap-4" data-swal-loading
                        data-swal-loading-title="Memperbarui Kata Sandi..."
                        data-swal-loading-text="Sedang mengenkripsi dan menyimpan kata sandi baru...">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="bagian" value="kata_sandi">

                        <div class="space-y-4">
                            <div>
                                <label for="kata_sandi_lama"
                                    class="block text-xs sm:text-sm font-semibold text-charcoal/85">Kata Sandi Saat
                                    Ini</label>
                                <div class="relative mt-1.5">
                                    <svg class="h-4 w-4 text-charcoal/40 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <rect width="18" height="11" x="3" y="11" rx="2"
                                            ry="2" />
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                    </svg>
                                    <input id="kata_sandi_lama" name="kata_sandi_lama" type="password" required
                                        placeholder="Masukkan kata sandi lama"
                                        class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 pl-10 pr-4 py-2.5 text-sm text-charcoal focus:border-sage focus:bg-white focus:ring-2 focus:ring-sage/15 focus:outline-none transition">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="kata_sandi_baru"
                                        class="block text-xs sm:text-sm font-semibold text-charcoal/85">Kata Sandi
                                        Baru</label>
                                    <div class="relative mt-1.5">
                                        <svg class="h-4 w-4 text-charcoal/40 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="m15.5 7.5 2.3 2.3a1 1 0 0 0 1.4 0l2.1-2.1a1 1 0 0 0 0-1.4L19 4" />
                                            <path d="m21 2-9.6 9.6" />
                                            <circle cx="7.5" cy="15.5" r="5.5" />
                                        </svg>
                                        <input id="kata_sandi_baru" name="kata_sandi_baru" type="password"
                                            minlength="8" required placeholder="Minimal 8 karakter"
                                            class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 pl-10 pr-4 py-2.5 text-sm text-charcoal focus:border-sage focus:bg-white focus:ring-2 focus:ring-sage/15 focus:outline-none transition">
                                    </div>
                                </div>

                                <div>
                                    <label for="kata_sandi_baru_confirmation"
                                        class="block text-xs sm:text-sm font-semibold text-charcoal/85">Ulangi Kata Sandi
                                        Baru</label>
                                    <div class="relative mt-1.5">
                                        <svg class="h-4 w-4 text-charcoal/40 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10" />
                                            <path d="m9 12 2 2 4-4" />
                                        </svg>
                                        <input id="kata_sandi_baru_confirmation" name="kata_sandi_baru_confirmation"
                                            type="password" minlength="8" required
                                            placeholder="Ketik ulang kata sandi baru"
                                            class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 pl-10 pr-4 py-2.5 text-sm text-charcoal focus:border-sage focus:bg-white focus:ring-2 focus:ring-sage/15 focus:outline-none transition">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-1 flex justify-end">
                            <button type="submit"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-sage px-5 py-2.5 text-xs sm:text-sm font-semibold text-white shadow-xs hover:bg-[#3b5047] active:scale-95 transition cursor-pointer">
                                <svg class="h-4 w-4 text-[#F5E3B8] shrink-0" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" aria-hidden="true">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10" />
                                    <path d="m9 12 2 2 4-4" />
                                </svg>
                                <span>Perbarui Kata Sandi</span>
                            </button>
                        </div>
                    </form>
                </section>

                {{-- Kartu 4 (Kanan Bawah): Riwayat Transaksi Terbaru --}}
                <section
                    class="order-4 lg:col-span-5 h-full rounded-[1.5rem] bg-white p-5 sm:p-6 shadow-xs ring-1 ring-champagne/25 flex flex-col">
                    <div class="flex items-center justify-between pb-4 border-b border-champagne/15">
                        <div class="flex items-center gap-3">
                            <span
                                class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-sage/10 text-sage ring-1 ring-sage/20 shrink-0">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z" />
                                    <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8" />
                                    <path d="M12 17.5v-11" />
                                </svg>
                            </span>
                            <div>
                                <h2 class="font-sans text-base sm:text-lg font-bold text-charcoal tracking-tight">Transaksi
                                    Terbaru</h2>
                                <p class="text-xs text-charcoal/60">Riwayat aktivasi &amp; pembayaran undangan.</p>
                            </div>
                        </div>
                        <span
                            class="rounded-full bg-ivory px-2.5 py-0.5 font-sans tabular-nums text-[11px] font-semibold text-charcoal/65 ring-1 ring-champagne/25 shrink-0">{{ $totalTransaksi }}
                            total</span>
                    </div>

                    <div class="mt-4 flex-1 flex flex-col gap-3">
                        @forelse ($riwayatTransaksi as $trx)
                            <div class="rounded-2xl bg-ivory/80 p-3.5 ring-1 ring-champagne/25 space-y-2">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <p class="font-mono text-xs font-bold text-charcoal">{{ $trx->kode_invoice }}</p>
                                        <p class="text-xs text-charcoal/70 truncate">
                                            {{ $trx->undangan?->nama_panggilan_pria }} &amp;
                                            {{ $trx->undangan?->nama_panggilan_wanita }} &bull;
                                            {{ $trx->tema?->nama_tema }}
                                        </p>
                                    </div>
                                    <span
                                        class="rounded-full px-2.5 py-0.5 text-[11px] font-semibold shrink-0 {{ $trx->status === 'lunas' ? 'bg-sage/15 text-sage' : ($trx->status === 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-800') }}">
                                        {{ $trx->labelStatus() }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between pt-1">
                                    <span
                                        class="font-sans tabular-nums text-sm font-bold text-charcoal">{{ \App\Models\Tema::formatRupiah($trx->total_bayar) }}</span>
                                    @if ($trx->undangan)
                                        <a href="{{ route('dashboard.undangan.kelola', [$trx->undangan, 'tab' => 'aktivasi']) }}"
                                            class="inline-flex items-center gap-1 text-xs font-semibold text-sage hover:underline">
                                            <span>Detail Pembayaran</span>
                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                                stroke-linejoin="round" aria-hidden="true">
                                                <path d="m9 18 6-6-6-6" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div
                                class="flex-1 flex flex-col items-center justify-center rounded-2xl bg-ivory/60 py-8 px-4 text-center ring-1 ring-champagne/20 space-y-2">
                                <span
                                    class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-white text-sage ring-1 ring-champagne/25 shadow-2xs">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                        aria-hidden="true">
                                        <path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z" />
                                        <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8" />
                                        <path d="M12 17.5v-11" />
                                    </svg>
                                </span>
                                <div class="space-y-1">
                                    <p class="text-xs sm:text-sm font-semibold text-charcoal/80">Belum Ada Riwayat
                                        Transaksi</p>
                                    <p class="text-[11px] sm:text-xs text-charcoal/55 max-w-xs mx-auto">Riwayat pembayaran
                                        aktivasi undangan Anda akan muncul di sini.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>
            </main>
        </div>

        @include('dashboard._bottom-nav', ['halamanAktif' => 'profil', 'modalBuatOnPage' => false])
    </div>
@endsection
