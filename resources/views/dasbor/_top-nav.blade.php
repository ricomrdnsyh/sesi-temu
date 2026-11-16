@php
    $halamanAktif = $halamanAktif ?? 'undangan';
    $judulMobile = $judulMobile ?? null;
    $lebarKontainer = $lebarKontainer ?? 'max-w-7xl';
    $penggunaAktif = auth()->user();
@endphp

<header class="bg-white/95 backdrop-blur-md border-b border-champagne/20 sticky top-0 z-30">
    <div class="{{ $lebarKontainer }} mx-auto px-4 sm:px-6 lg:px-8 h-14 md:h-16 flex items-center justify-between gap-3">
        <div class="flex items-center gap-3 md:gap-6 min-w-0">
            <a href="{{ route('beranda') }}" class="flex items-center gap-2 font-serif text-xl md:text-2xl font-bold text-charcoal shrink-0">
                <img
                    src="{{ asset('aset-demo/logo-sesi-temu-ikon.webp') }}"
                    alt="Logo SesiTemu"
                    class="h-8 w-8 md:h-9 md:w-9 object-contain"
                >
                <span class="{{ $judulMobile ? 'hidden sm:inline' : '' }}">Sesi<span class="text-champagne">Temu</span></span>
            </a>

            @if ($judulMobile)
                <span class="md:hidden font-serif text-lg font-bold text-charcoal truncate">{{ $judulMobile }}</span>
            @endif

            <nav aria-label="Navigasi Dasbor Client" class="hidden md:flex items-center gap-1.5">
                <a
                    href="{{ route('dasbor.index') }}"
                    class="rounded-xl px-3.5 py-1.5 text-sm font-semibold transition {{ $halamanAktif === 'undangan' ? 'bg-sage/12 text-sage' : 'text-charcoal/70 hover:bg-ivory hover:text-charcoal' }}"
                >
                    Undangan Saya
                </a>
                <a
                    href="{{ route('dasbor.katalog') }}"
                    class="rounded-xl px-3.5 py-1.5 text-sm font-semibold transition {{ $halamanAktif === 'katalog' ? 'bg-sage/12 text-sage' : 'text-charcoal/70 hover:bg-ivory hover:text-charcoal' }}"
                >
                    Katalog Tema
                </a>
            </nav>
        </div>

        <div class="flex items-center gap-2.5 md:gap-4 text-xs sm:text-sm min-w-0">
            @if ($penggunaAktif->adalahAdmin())
                <a href="{{ route('admin.ringkasan') }}" class="font-semibold text-champagne hover:underline shrink-0">
                    Panel Admin
                </a>
            @endif

            <a
                href="{{ route('dasbor.profil.tampil') }}"
                title="Buka Profil Saya"
                class="inline-flex items-center gap-2 rounded-full border pl-1.5 pr-2.5 sm:pr-3.5 py-1 transition min-w-0 {{ $halamanAktif === 'profil' ? 'border-sage bg-sage/10 text-sage' : 'border-champagne/35 bg-ivory/70 text-charcoal hover:bg-champagne/10' }}"
            >
                <span class="inline-flex h-6 w-6 md:h-7 md:w-7 items-center justify-center rounded-full bg-sage text-white text-[11px] font-bold shrink-0">
                    {{ $penggunaAktif->inisialNama() }}
                </span>
                <span class="truncate max-w-[110px] sm:max-w-[160px] font-medium text-xs md:text-sm">{{ $penggunaAktif->nama }}</span>
            </a>

            <form action="{{ route('keluar') }}" method="POST" class="hidden md:inline-flex shrink-0">
                @csrf
                <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl border border-charcoal/15 px-3 py-1.5 font-semibold text-charcoal hover:bg-charcoal/5 transition cursor-pointer">
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </div>
</header>
