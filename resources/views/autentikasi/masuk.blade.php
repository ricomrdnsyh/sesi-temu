@extends('layouts.aplikasi')

@section('judul', 'Masuk — SesiTemu')

@section('konten')
<x-tata-letak-auth
    mode="masuk"
    judul-halaman="Selamat Datang Kembali"
    subjudul="Masuk untuk mengelola undangan digital dan memantau RSVP tamu Anda."
>
    <form
        x-data="{ lihatSandi: false, capsLockAktif: false }"
        action="{{ route('masuk.proses') }}"
        method="POST"
        class="space-y-3.5"
        data-swal-loading
        data-swal-loading-title="Memverifikasi Akun..."
        data-swal-loading-text="Sedang masuk ke dashboard Anda..."
    >
        @csrf

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
                    autofocus
                    autocomplete="email"
                    placeholder="nama@email.com"
                    class="block w-full rounded-xl border @error('email') border-rose-400 ring-2 ring-rose-500/15 @else border-charcoal/12 hover:border-champagne/55 @enderror bg-[#FAF8F4] pl-10 pr-4 py-2.5 text-sm text-charcoal placeholder:text-charcoal/35 focus:border-champagne focus:bg-white focus:outline-none focus:ring-4 focus:ring-champagne/15 transition"
                >
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between gap-2">
                <label for="kata_sandi" class="block text-[13px] font-medium text-charcoal/85">
                    Kata Sandi
                </label>
                <span
                    x-show="capsLockAktif"
                    x-cloak
                    class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2 py-0.5 text-[11px] font-medium text-amber-700 ring-1 ring-amber-200/80"
                >
                    Caps Lock aktif
                </span>
            </div>
            <div class="group relative mt-1.5">
                <svg class="w-4 h-4 text-charcoal/35 group-focus-within:text-sage transition-colors absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                </svg>
                <input
                    id="kata_sandi"
                    name="kata_sandi"
                    :type="lihatSandi ? 'text' : 'password'"
                    @keydown="capsLockAktif = $event.getModifierState && $event.getModifierState('CapsLock')"
                    @keyup="capsLockAktif = $event.getModifierState && $event.getModifierState('CapsLock')"
                    @blur="capsLockAktif = false"
                    required
                    autocomplete="current-password"
                    placeholder="Masukkan kata sandi"
                    class="block w-full rounded-xl border @error('kata_sandi') border-rose-400 ring-2 ring-rose-500/15 @else border-charcoal/12 hover:border-champagne/55 @enderror bg-[#FAF8F4] pl-10 pr-11 py-2.5 text-sm text-charcoal placeholder:text-charcoal/35 focus:border-champagne focus:bg-white focus:outline-none focus:ring-4 focus:ring-champagne/15 transition"
                >
                <button
                    type="button"
                    @click="lihatSandi = !lihatSandi"
                    :aria-label="lihatSandi ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                    class="absolute right-2.5 top-1/2 -translate-y-1/2 rounded-lg p-1.5 text-charcoal/40 hover:text-charcoal hover:bg-charcoal/5 transition cursor-pointer"
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

        <div class="flex items-center justify-between pt-0.5">
            <label class="inline-flex items-center gap-2 text-xs sm:text-[13px] text-charcoal/70 hover:text-charcoal transition cursor-pointer select-none">
                <input type="checkbox" name="ingat_saya" value="1" class="h-4 w-4 rounded border-charcoal/25 text-sage accent-sage focus:ring-champagne/30 cursor-pointer">
                <span>Ingat saya</span>
            </label>

            <a
                href="{{ \App\Support\PengaturanSesiTemu::urlWaAdmin('Halo Admin SesiTemu, saya butuh bantuan reset akses akun saya.') }}"
                target="_blank"
                rel="noopener"
                class="text-xs font-medium text-sage hover:text-[#2D4439] hover:underline transition"
            >
                Lupa akses?
            </a>
        </div>

        <button
            type="submit"
            class="group w-full inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[#2D4439] via-sage to-[#3E584C] px-5 py-2.5 sm:py-3 text-sm font-semibold text-white shadow-[0_10px_24px_-8px_rgba(75,99,88,0.55)] ring-1 ring-inset ring-white/15 hover:-translate-y-0.5 hover:shadow-[0_14px_28px_-8px_rgba(75,99,88,0.65)] active:translate-y-0 transition-all duration-200 cursor-pointer"
        >
            <svg class="w-4 h-4 text-[#F3DFB0] transition-transform duration-200 group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                <polyline points="10 17 15 12 10 7" />
                <line x1="15" x2="3" y1="12" y2="12" />
            </svg>
            <span>Masuk Sekarang</span>
        </button>
    </form>

    <p class="mt-4 pt-4 border-t border-charcoal/8 text-center text-xs sm:text-[13px] text-charcoal/65">
        Belum punya akun?
        <a href="{{ route('daftar') }}" class="group inline-flex items-center gap-1.5 font-semibold text-[#8A6D33] hover:text-sage transition">
            <span>Daftar gratis sekarang</span>
            <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <line x1="19" x2="19" y1="8" y2="14" />
                <line x1="22" x2="16" y1="11" y2="11" />
            </svg>
        </a>
    </p>
</x-tata-letak-auth>
@endsection
