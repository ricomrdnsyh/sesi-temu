@extends('layouts.aplikasi')

@section('judul', 'Daftar Akun — SesiTemu')

@section('konten')
<x-tata-letak-auth
    mode="daftar"
    judul-halaman="Buat Akun Gratis"
    subjudul="Mulai rancang undangan pernikahan digital impian Anda dalam hitungan menit."
    :tema-terpilih="$temaTerpilih"
>
    @if ($slugTerpilih || $temaTerpilih)
        <div class="mb-5 rounded-2xl bg-champagne/10 border border-champagne/30 px-4 py-3.5 text-xs text-charcoal space-y-1.5">
            <p class="font-semibold text-charcoal flex items-center gap-1.5">
                <svg class="w-4 h-4 text-sage shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" />
                    <path d="m9 12 2 2 4-4" />
                </svg>
                <span>Draft Undangan Awal Anda Siap Dibuat</span>
            </p>
            @if ($slugTerpilih)
                <p>Link Undangan: <span class="font-mono font-semibold text-sage">sesitemu.id/{{ $slugTerpilih }}</span></p>
            @endif
            @if ($temaTerpilih)
                <p class="flex flex-wrap items-center gap-1.5">
                    <span>Tema Pilihan:</span>
                    <span class="font-semibold text-sage">{{ $temaTerpilih->nama_tema }}</span>
                    <span class="inline-block rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $temaTerpilih->infoKategori()['chip_class'] }}">
                        {{ $temaTerpilih->kategoriLabel() }} — {{ $temaTerpilih->hargaFormatted() }}
                    </span>
                </p>
            @endif
        </div>
    @endif

    <form
        x-data="{ lihatSandi: false, lihatKonfirmasi: false }"
        action="{{ route('daftar.proses') }}"
        method="POST"
        class="space-y-3.5"
        data-swal-loading
        data-swal-loading-title="Membuat Akun &amp; Draft..."
        data-swal-loading-text="Menyiapkan akun client dan link undangan pertama Anda..."
    >
        @csrf
        <input type="hidden" name="slug" value="{{ old('slug', $slugTerpilih) }}">
        <input type="hidden" name="tema_id" value="{{ old('tema_id', $temaTerpilih?->id) }}">

        <div>
            <label for="nama" class="block text-[13px] font-medium text-charcoal/85">
                Nama Lengkap
            </label>
            <div class="group relative mt-1.5">
                <svg class="w-4 h-4 text-charcoal/35 group-focus-within:text-sage transition-colors absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="8" r="4" />
                    <path d="M20 21a8 8 0 0 0-16 0" />
                </svg>
                <input
                    id="nama"
                    name="nama"
                    type="text"
                    value="{{ old('nama') }}"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Contoh: Dimas Pratama"
                    class="block w-full rounded-xl border @error('nama') border-rose-400 ring-2 ring-rose-500/15 @else border-charcoal/12 hover:border-champagne/55 @enderror bg-[#FAF8F4] pl-10 pr-4 py-2.5 text-sm text-charcoal placeholder:text-charcoal/35 focus:border-champagne focus:bg-white focus:outline-none focus:ring-4 focus:ring-champagne/15 transition"
                >
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
            <div>
                <label for="email" class="block text-[13px] font-medium text-charcoal/85">
                    Alamat Email
                </label>
                <div class="group relative mt-1.5">
                    <svg class="w-4 h-4 text-charcoal/35 group-focus-within:text-sage transition-colors absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect width="20" height="16" x="2" y="4" rx="2" />
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                    </svg>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        placeholder="nama@email.com"
                        class="block w-full rounded-xl border @error('email') border-rose-400 ring-2 ring-rose-500/15 @else border-charcoal/12 hover:border-champagne/55 @enderror bg-[#FAF8F4] pl-10 pr-3.5 py-2.5 text-sm text-charcoal placeholder:text-charcoal/35 focus:border-champagne focus:bg-white focus:outline-none focus:ring-4 focus:ring-champagne/15 transition"
                    >
                </div>
            </div>

            <div>
                <label for="nomor_wa" class="block text-[13px] font-medium text-charcoal/85">
                    Nomor WhatsApp
                </label>
                <div class="group relative mt-1.5">
                    <svg class="w-4 h-4 text-charcoal/35 group-focus-within:text-sage transition-colors absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                    </svg>
                    <input
                        id="nomor_wa"
                        name="nomor_wa"
                        type="text"
                        value="{{ old('nomor_wa') }}"
                        autocomplete="tel"
                        placeholder="081234567890"
                        class="block w-full rounded-xl border @error('nomor_wa') border-rose-400 ring-2 ring-rose-500/15 @else border-charcoal/12 hover:border-champagne/55 @enderror bg-[#FAF8F4] pl-10 pr-3.5 py-2.5 text-sm text-charcoal placeholder:text-charcoal/35 focus:border-champagne focus:bg-white focus:outline-none focus:ring-4 focus:ring-champagne/15 transition"
                    >
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
            <div>
                <label for="kata_sandi" class="block text-[13px] font-medium text-charcoal/85">
                    Kata Sandi
                </label>
                <div class="group relative mt-1.5">
                    <svg class="w-4 h-4 text-charcoal/35 group-focus-within:text-sage transition-colors absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    <input
                        id="kata_sandi"
                        name="kata_sandi"
                        :type="lihatSandi ? 'text' : 'password'"
                        required
                        autocomplete="new-password"
                        placeholder="Min. 8 karakter"
                        class="block w-full rounded-xl border @error('kata_sandi') border-rose-400 ring-2 ring-rose-500/15 @else border-charcoal/12 hover:border-champagne/55 @enderror bg-[#FAF8F4] pl-10 pr-10 py-2.5 text-sm text-charcoal placeholder:text-charcoal/35 focus:border-champagne focus:bg-white focus:outline-none focus:ring-4 focus:ring-champagne/15 transition"
                    >
                    <button
                        type="button"
                        @click="lihatSandi = !lihatSandi"
                        :aria-label="lihatSandi ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                        class="absolute right-2 top-1/2 -translate-y-1/2 rounded-lg p-1.5 text-charcoal/40 hover:text-charcoal hover:bg-charcoal/5 transition cursor-pointer"
                    >
                        <svg x-show="!lihatSandi" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                        <svg x-show="lihatSandi" x-cloak class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24" />
                            <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68" />
                            <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61" />
                            <line x1="2" x2="22" y1="2" y2="22" />
                        </svg>
                    </button>
                </div>
            </div>

            <div>
                <label for="kata_sandi_confirmation" class="block text-[13px] font-medium text-charcoal/85">
                    Konfirmasi Sandi
                </label>
                <div class="group relative mt-1.5">
                    <svg class="w-4 h-4 text-charcoal/35 group-focus-within:text-sage transition-colors absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10" />
                    </svg>
                    <input
                        id="kata_sandi_confirmation"
                        name="kata_sandi_confirmation"
                        :type="lihatKonfirmasi ? 'text' : 'password'"
                        required
                        autocomplete="new-password"
                        placeholder="Ulangi kata sandi"
                        class="block w-full rounded-xl border border-charcoal/12 hover:border-champagne/55 bg-[#FAF8F4] pl-10 pr-10 py-2.5 text-sm text-charcoal placeholder:text-charcoal/35 focus:border-champagne focus:bg-white focus:outline-none focus:ring-4 focus:ring-champagne/15 transition"
                    >
                    <button
                        type="button"
                        @click="lihatKonfirmasi = !lihatKonfirmasi"
                        :aria-label="lihatKonfirmasi ? 'Sembunyikan konfirmasi kata sandi' : 'Tampilkan konfirmasi kata sandi'"
                        class="absolute right-2 top-1/2 -translate-y-1/2 rounded-lg p-1.5 text-charcoal/40 hover:text-charcoal hover:bg-charcoal/5 transition cursor-pointer"
                    >
                        <svg x-show="!lihatKonfirmasi" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                        <svg x-show="lihatKonfirmasi" x-cloak class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24" />
                            <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68" />
                            <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61" />
                            <line x1="2" x2="22" y1="2" y2="22" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <button
            type="submit"
            class="group w-full inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[#2D4439] via-sage to-[#3E584C] px-5 py-3 sm:py-3.5 text-sm font-semibold text-white shadow-[0_10px_24px_-8px_rgba(75,99,88,0.55)] ring-1 ring-inset ring-white/15 hover:-translate-y-0.5 hover:shadow-[0_14px_28px_-8px_rgba(75,99,88,0.65)] active:translate-y-0 transition-all duration-200 cursor-pointer"
        >
            <svg class="w-4 h-4 text-[#F3DFB0] transition-transform duration-200 group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <line x1="19" x2="19" y1="8" y2="14" />
                <line x1="22" x2="16" y1="11" y2="11" />
            </svg>
            <span>Daftar &amp; Buat Undangan</span>
        </button>
    </form>

    <p class="mt-6 pt-5 border-t border-charcoal/8 text-center text-xs sm:text-sm text-charcoal/65">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="group inline-flex items-center gap-1.5 font-semibold text-[#8A6D33] hover:text-sage transition">
            <span>Masuk di sini</span>
            <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                <polyline points="10 17 15 12 10 7" />
                <line x1="15" x2="3" y1="12" y2="12" />
            </svg>
        </a>
    </p>
</x-tata-letak-auth>
@endsection
