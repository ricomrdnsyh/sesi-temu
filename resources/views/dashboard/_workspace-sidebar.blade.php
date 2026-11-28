@php
    $menuAktif = $menuAktif ?? 'undangan';
    $menuTamuRsvpTerkunci = !$undangan->sudahAktifPublik();
    $urlAktivasiTerkunci = route('dashboard.undangan.kelola', [$undangan, 'tab' => 'aktivasi']);
    $jumlahTamuRail = $undangan->relationLoaded('daftarTamu')
        ? $undangan->daftarTamu->count()
        : $undangan->daftarTamu()->count();
    $jumlahRsvpRail = $undangan->relationLoaded('bukuTamu')
        ? $undangan->bukuTamu->count()
        : $undangan->bukuTamu()->count();
    $urlKembaliRail = auth()->user()->adalahAdmin() ? route('admin.undangan.index') : route('dashboard.index');
    $labelKembaliRail = auth()->user()->adalahAdmin() ? 'Admin' : 'Dashboard';
    $menuTamuRsvp = [
        [
            'kode' => 'tamu',
            'label' => 'Tamu',
            'judul' => 'Daftar Tamu',
            'href' => $menuTamuRsvpTerkunci ? $urlAktivasiTerkunci : route('dashboard.undangan.tamu', $undangan),
            'jumlah' => $jumlahTamuRail,
        ],
        [
            'kode' => 'rsvp',
            'label' => 'RSVP',
            'judul' => 'RSVP & Ucapan',
            'href' => $menuTamuRsvpTerkunci ? $urlAktivasiTerkunci : route('dashboard.undangan.rsvp', $undangan),
            'jumlah' => $jumlahRsvpRail,
        ],
    ];
@endphp

{{-- Sidebar Mengambang Ramping Desktop --}}
<aside aria-label="Navigasi Ruang Kerja Undangan" data-workspace-sidebar
    class="hidden lg:flex lg:flex-col w-[74px] shrink-0 h-[calc(100vh-1.5rem)] sticky top-3 my-3 ml-3 rounded-3xl bg-gradient-to-b from-[#2A3E35] to-[#203029] text-ivory py-4 ring-1 ring-white/10 items-center justify-between select-none z-30 shadow-[0_14px_34px_-12px_rgba(16,28,22,0.38)]">
    {{-- Logo --}}
    <a href="{{ route('beranda') }}" title="Beranda SesiTemu"
        class="flex items-center justify-center w-full px-2 py-0.5 hover:scale-105 transition">
        <img src="{{ asset('logo/logo-gelap.webp') }}" alt="Logo SesiTemu"
            class="w-14 max-h-14 object-contain drop-shadow-xs" />
    </a>

    {{-- Menu Utama --}}
    <nav aria-label="Menu Ruang Kerja" class="flex flex-col items-center gap-3 w-full px-2">
        <a href="{{ $urlKembaliRail }}" title="Kembali ke {{ $labelKembaliRail }}"
            class="group flex flex-col items-center gap-1 text-ivory/60 hover:text-white transition">
            <span
                class="inline-flex h-10 w-10 items-center justify-center rounded-2xl group-hover:bg-white/10 transition">
                <svg class="h-[18px] w-[18px] group-hover:-translate-x-0.5 transition-transform" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round"
                    stroke-linejoin="round" aria-hidden="true">
                    <path d="m15 18-6-6 6-6" />
                </svg>
            </span>
            <span class="text-[9.5px] font-medium leading-none">{{ $labelKembaliRail }}</span>
        </a>

        <div class="w-6 h-px bg-white/12" aria-hidden="true"></div>

        <a href="{{ route('dashboard.undangan.kelola', $undangan) }}" data-workspace-menu="undangan"
            title="Edit Undangan"
            class="group flex flex-col items-center gap-1 transition {{ $menuAktif === 'undangan' ? 'text-white font-semibold' : 'text-ivory/65 hover:text-white font-medium' }}">
            <span
                class="inline-flex h-10 w-10 items-center justify-center rounded-2xl transition {{ $menuAktif === 'undangan' ? 'bg-[#F5E3B8] text-[#203029] shadow-[0_6px_16px_-4px_rgba(245,227,184,0.45)]' : 'group-hover:bg-white/10' }}">
                <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="{{ $menuAktif === 'undangan' ? '2.1' : '1.85' }}" stroke-linecap="round"
                    stroke-linejoin="round" aria-hidden="true">
                    <rect width="20" height="16" x="2" y="4" rx="2" />
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                </svg>
            </span>
            <span class="text-[9.5px] leading-none">Undangan</span>
        </a>

        @foreach ($menuTamuRsvp as $itemRail)
            @php
                $sedangAktifRail = !$menuTamuRsvpTerkunci && $menuAktif === $itemRail['kode'];
            @endphp
            <a href="{{ $itemRail['href'] }}"
                @if ($menuTamuRsvpTerkunci) @click="if (typeof bukaModalAktivasi === 'function') { $event.preventDefault(); bukaModalAktivasi(); }"
                    data-workspace-locked="true" @endif
                data-workspace-menu="{{ $itemRail['kode'] }}"
                title="{{ $menuTamuRsvpTerkunci ? $itemRail['judul'] . ' terkunci — selesaikan pembayaran & aktivasi terlebih dahulu' : $itemRail['judul'] }}"
                class="group flex flex-col items-center gap-1 transition {{ $menuTamuRsvpTerkunci ? 'text-ivory/40 hover:text-amber-200 font-medium' : ($sedangAktifRail ? 'text-white font-semibold' : 'text-ivory/65 hover:text-white font-medium') }}">
                <span
                    class="relative inline-flex h-10 w-10 items-center justify-center rounded-2xl transition {{ $menuTamuRsvpTerkunci ? 'bg-white/6 text-ivory/45 ring-1 ring-white/10 group-hover:bg-amber-400/15 group-hover:text-amber-200' : ($sedangAktifRail ? 'bg-[#F5E3B8] text-[#203029] shadow-[0_6px_16px_-4px_rgba(245,227,184,0.45)]' : 'group-hover:bg-white/10') }}">
                    @if ($itemRail['kode'] === 'tamu')
                        <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="{{ $sedangAktifRail ? '2.1' : '1.85' }}" stroke-linecap="round"
                            stroke-linejoin="round" aria-hidden="true">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    @else
                        <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="{{ $sedangAktifRail ? '2.1' : '1.85' }}" stroke-linecap="round"
                            stroke-linejoin="round" aria-hidden="true">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                        </svg>
                    @endif
                    @if ($menuTamuRsvpTerkunci)
                        <span
                            class="absolute -top-1 -right-1 inline-flex h-[17px] w-[17px] items-center justify-center rounded-full bg-amber-400 ring-2 ring-[#25372F] text-[#203029]"
                            aria-hidden="true">
                            <svg class="h-2.5 w-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                        </span>
                    @elseif ($itemRail['jumlah'] > 0)
                        <span
                            class="absolute -top-1 -right-1 min-w-[16px] h-[16px] px-1 inline-flex items-center justify-center rounded-full bg-[#E2C27D] ring-2 ring-[#25372F] font-sans tabular-nums text-[8.5px] font-bold leading-none text-[#203029]">
                            {{ $itemRail['jumlah'] }}
                        </span>
                    @endif
                </span>
                <span class="text-[9.5px] leading-none">{{ $itemRail['label'] }}</span>
            </a>
        @endforeach
    </nav>

    {{-- Bawah: Keluar --}}
    <form action="{{ route('keluar') }}" method="POST" data-swal-confirm="Yakin ingin keluar dari akun SesiTemu Anda?"
        data-swal-title="Keluar dari Akun" data-swal-confirm-button="Ya, Keluar" data-swal-confirm-color="#DC2626"
        data-swal-loading-title="Keluar dari Akun..." data-swal-loading-text="Sedang mengakhiri sesi akun Anda...">
        @csrf
        <button type="submit" title="Keluar"
            class="group flex flex-col items-center gap-1 text-ivory/55 hover:text-rose-200 transition cursor-pointer">
            <span
                class="inline-flex h-10 w-10 items-center justify-center rounded-2xl group-hover:bg-rose-500/20 transition">
                <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.85" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" x2="9" y1="12" y2="12" />
                </svg>
            </span>
            <span class="text-[9.5px] font-medium leading-none">Keluar</span>
        </button>
    </form>
</aside>

{{-- Navigasi Bottom Bar Ruang Kerja (Mobile & Tablet < lg) --}}
<nav aria-label="Navigasi Ruang Kerja Mobile" data-client-bottom-nav
    class="lg:hidden fixed bottom-0 inset-x-0 z-40 rounded-t-2xl bg-white/96 backdrop-blur-lg border-t border-champagne/25 shadow-[0_-10px_30px_-12px_rgba(31,41,55,0.14)] pb-[env(safe-area-inset-bottom)]">
    <div class="max-w-lg mx-auto grid grid-cols-4 h-[66px] px-2 items-center">
        <a href="{{ $urlKembaliRail }}"
            class="group relative flex flex-col items-center justify-center gap-1 py-1 text-charcoal/55 hover:text-sage font-medium active:scale-95 transition-all duration-200">
            <span
                class="inline-flex items-center justify-center rounded-full px-4 py-1 transition-all duration-200 group-hover:bg-sage/10 group-hover:text-sage group-hover:-translate-y-0.5">
                <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m15 18-6-6 6-6" />
                </svg>
            </span>
            <span
                class="text-[10px] leading-none transition-colors duration-200 group-hover:font-semibold">{{ $labelKembaliRail }}</span>
        </a>

        <a href="{{ route('dashboard.undangan.kelola', $undangan) }}"
            class="group relative flex flex-col items-center justify-center gap-1 py-1 active:scale-95 transition-all duration-200 {{ $menuAktif === 'undangan' ? 'text-sage font-bold' : 'text-charcoal/55 hover:text-sage font-medium' }}">
            @if ($menuAktif === 'undangan')
                <span class="pointer-events-none absolute -top-1.5 h-1 w-6 rounded-b-full bg-sage"></span>
            @endif
            <span
                class="inline-flex items-center justify-center rounded-full px-4 py-1 transition-all duration-200 {{ $menuAktif === 'undangan' ? 'bg-sage/15 text-sage ring-1 ring-sage/20 shadow-2xs' : 'group-hover:bg-sage/10 group-hover:text-sage group-hover:-translate-y-0.5' }}">
                <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="{{ $menuAktif === 'undangan' ? '2.2' : '1.9' }}" stroke-linecap="round"
                    stroke-linejoin="round" aria-hidden="true">
                    <rect width="20" height="16" x="2" y="4" rx="2" />
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                </svg>
            </span>
            <span
                class="text-[10px] leading-none transition-colors duration-200 group-hover:font-semibold">Undangan</span>
        </a>

        @foreach ($menuTamuRsvp as $itemRail)
            @php
                $sedangAktifMobile = !$menuTamuRsvpTerkunci && $menuAktif === $itemRail['kode'];
            @endphp
            <a href="{{ $itemRail['href'] }}"
                @if ($menuTamuRsvpTerkunci) @click="if (typeof bukaModalAktivasi === 'function') { $event.preventDefault(); bukaModalAktivasi(); }" @endif
                title="{{ $menuTamuRsvpTerkunci ? $itemRail['judul'] . ' terkunci — bayar & aktifkan terlebih dahulu' : $itemRail['judul'] }}"
                class="group relative flex flex-col items-center justify-center gap-1 py-1 active:scale-95 transition-all duration-200 {{ $menuTamuRsvpTerkunci ? 'text-charcoal/40 hover:text-amber-700 font-medium' : ($sedangAktifMobile ? 'text-sage font-bold' : 'text-charcoal/55 hover:text-sage font-medium') }}">
                @if ($sedangAktifMobile)
                    <span class="pointer-events-none absolute -top-1.5 h-1 w-6 rounded-b-full bg-sage"></span>
                @endif
                <span
                    class="relative inline-flex items-center justify-center rounded-full px-4 py-1 transition-all duration-200 {{ $menuTamuRsvpTerkunci ? 'bg-charcoal/5 text-charcoal/40 group-hover:bg-amber-50 group-hover:text-amber-700 group-hover:-translate-y-0.5' : ($sedangAktifMobile ? 'bg-sage/15 text-sage ring-1 ring-sage/20 shadow-2xs' : 'group-hover:bg-sage/10 group-hover:text-sage group-hover:-translate-y-0.5') }}">
                    @if ($itemRail['kode'] === 'tamu')
                        <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="{{ $sedangAktifMobile ? '2.2' : '1.9' }}" stroke-linecap="round"
                            stroke-linejoin="round" aria-hidden="true">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    @else
                        <svg class="h-[19px] w-[19px]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="{{ $sedangAktifMobile ? '2.2' : '1.9' }}" stroke-linecap="round"
                            stroke-linejoin="round" aria-hidden="true">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                        </svg>
                    @endif
                    @if ($menuTamuRsvpTerkunci)
                        <span
                            class="absolute -top-0.5 right-0.5 inline-flex h-[15px] w-[15px] items-center justify-center rounded-full bg-amber-400 text-[#203029] ring-1 ring-white"
                            aria-hidden="true">
                            <svg class="h-2.5 w-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                        </span>
                    @elseif ($itemRail['jumlah'] > 0)
                        <span
                            class="absolute -top-0.5 right-0.5 min-w-[15px] h-[15px] px-1 inline-flex items-center justify-center rounded-full bg-champagne font-sans tabular-nums text-[8.5px] font-bold leading-none text-charcoal">
                            {{ $itemRail['jumlah'] }}
                        </span>
                    @endif
                </span>
                <span
                    class="text-[10px] leading-none transition-colors duration-200 group-hover:font-semibold">{{ $itemRail['label'] }}</span>
            </a>
        @endforeach
    </div>
</nav>
