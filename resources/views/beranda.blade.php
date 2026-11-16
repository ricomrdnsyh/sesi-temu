@extends('layouts.aplikasi')

@section('judul', 'SesiTemu — Abadikan Setiap Sesi Bahagia Menuju Hari Pertemuan')

@section('konten')
@php
    $daftarFilterJson = $daftarTema->map(fn ($t) => [
        'kategori' => $t->kategori,
        'tier' => $t->tierKode(),
    ])->values();
@endphp
<div x-data="{
    kategoriAktif: 'semua',
    tierAktif: 'semua',
    daftarFilter: @js($daftarFilterJson),
    modalDemoTerbuka: false,
    temaDemoSlug: '',
    temaDemoNama: '',
    temaDemoInfo: '',
    namaTamuDemo: 'Budi Santoso & Partner',
    tanpaFotoDemo: false,
    fontDemo: 'bawaan',
    temaCocok(kategori, tier) {
        return (this.kategoriAktif === 'semua' || this.kategoriAktif === kategori)
            && (this.tierAktif === 'semua' || this.tierAktif === tier);
    },
    get adaHasilFilter() {
        return this.daftarFilter.some(item => this.temaCocok(item.kategori, item.tier));
    },
    resetFilter() {
        this.kategoriAktif = 'semua';
        this.tierAktif = 'semua';
    },
    bukaModalDemo(slug, nama, info = '') {
        this.temaDemoSlug = slug;
        this.temaDemoNama = nama;
        this.temaDemoInfo = info;
        this.tanpaFotoDemo = false;
        this.fontDemo = 'bawaan';
        this.modalDemoTerbuka = true;
    },
    bukaUrlDemo() {
        const params = new URLSearchParams({
            to: this.namaTamuDemo.trim() || 'Budi Santoso & Partner',
            tf: this.tanpaFotoDemo ? '1' : '0',
            font: this.fontDemo || 'bawaan',
        });
        window.open('/demo/' + this.temaDemoSlug + '?' + params.toString(), '_blank');
        this.modalDemoTerbuka = false;
    }
}">
    {{-- Header / Navbar --}}
    <header class="sticky top-0 z-40 bg-ivory/90 backdrop-blur border-b border-champagne/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('beranda') }}" class="flex items-center gap-2.5 group">
                <img
                    src="{{ asset('aset-demo/logo-sesi-temu-ikon.webp') }}"
                    alt="Logo SesiTemu"
                    class="h-10 w-10 object-contain transition-transform duration-200 group-hover:scale-105"
                >
                <span class="font-serif text-2xl sm:text-3xl font-bold tracking-tight text-charcoal">
                    Sesi<span class="text-champagne">Temu</span>
                </span>
            </a>

            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-charcoal/80">
                <a href="#keunggulan" class="hover:text-sage transition">Keunggulan</a>
                <a href="#katalog-tema" class="hover:text-sage transition">Katalog Tema</a>
                <a href="#paket-harga" class="hover:text-sage transition">Paket Harga</a>
            </nav>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ auth()->user()->adalahAdmin() ? '/admin' : '/dasbor' }}" class="rounded-xl bg-sage px-4 py-2 text-sm font-semibold text-white hover:bg-sage/90 transition">
                        {{ auth()->user()->adalahAdmin() ? 'Panel Admin' : 'Dasbor Saya' }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-charcoal hover:text-sage transition">
                        Masuk
                    </a>
                    <a href="{{ route('daftar') }}" class="rounded-xl bg-sage px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sage/90 transition">
                        Buat Undangan
                    </a>
                @endauth
            </div>
        </div>
    </header>

    {{-- Hero Section + Cek Ketersediaan Link Pasangan --}}
    <section class="relative overflow-hidden py-16 sm:py-24 px-4 sm:px-6 lg:px-8">
        <div class="absolute -top-32 right-0 w-[28rem] h-[28rem] rounded-full bg-champagne/10 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-32 -left-12 w-[24rem] h-[24rem] rounded-full bg-sage/10 blur-3xl pointer-events-none"></div>

        <div class="max-w-4xl mx-auto text-center relative z-10">
            <span class="inline-flex items-center gap-2 rounded-full bg-champagne/15 px-4 py-1.5 text-xs font-semibold uppercase tracking-widest text-champagne">
                Platform Undangan Pernikahan Digital Indonesia
            </span>
            <h1 class="mt-6 font-serif text-4xl sm:text-5xl lg:text-6xl font-bold text-charcoal leading-tight">
                Abadikan Setiap Sesi Bahagia Menuju Hari Pertemuan
            </h1>
            <p class="mt-5 text-base sm:text-lg text-charcoal/75 max-w-2xl mx-auto leading-relaxed">
                Buat undangan pernikahan digital elegan dalam hitungan menit. Dilengkapi foto otomatis hemat kuota (WebP), RSVP buku tamu real-time, amplop digital, hingga kirim link tamu WhatsApp massal.
            </p>

            {{-- Form Cek Link Pasangan --}}
            <div class="mt-10 max-w-2xl mx-auto bg-white p-3 sm:p-4 rounded-2xl shadow-md ring-1 ring-champagne/25">
                <form action="{{ route('cek.link') }}" method="POST" class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
                    @csrf
                    <div class="flex-1 flex items-center rounded-xl border border-charcoal/15 bg-ivory/70 px-4 py-3 focus-within:border-champagne focus-within:bg-white focus-within:ring-2 focus-within:ring-champagne/25">
                        <span class="text-sm font-semibold text-charcoal/50 select-none">sesitemu.id/</span>
                        <input
                            type="text"
                            name="slug"
                            value="{{ old('slug') }}"
                            required
                            placeholder="dimas-rani"
                            aria-label="Nama link pasangan"
                            class="w-full bg-transparent text-sm font-semibold text-charcoal placeholder:font-normal placeholder:text-charcoal/40 focus:outline-none ml-0.5"
                        >
                    </div>
                    <button type="submit" class="rounded-xl bg-sage px-6 py-3.5 text-sm font-semibold text-white hover:bg-sage/90 transition shrink-0 cursor-pointer">
                        Cek Ketersediaan Link
                    </button>
                </form>

                @if (session('saran_link'))
                    <div class="mt-3 rounded-xl bg-amber-50 border border-amber-200 px-4 py-2.5 text-left text-sm text-amber-800">
                        {{ session('saran_link') }}
                    </div>
                @endif

                @error('slug')
                    <div class="mt-3 rounded-xl bg-red-50 border border-red-200 px-4 py-2.5 text-left text-sm text-red-700">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mt-6 flex flex-wrap items-center justify-center gap-6 text-xs text-charcoal/60">
                <span>Aktif {{ $durasiAktifBulan ?? \App\Support\PengaturanSesiTemu::masaAktifBulan() }} Bulan Penuh</span>
                <span>•</span>
                <span>Kompresi Foto Otomatis .WebP</span>
                <span>•</span>
                <span>Siap Mobile &amp; OpenGraph WhatsApp</span>
            </div>
        </div>
    </section>

    {{-- Keunggulan SesiTemu --}}
    <section id="keunggulan" class="py-16 bg-white border-y border-champagne/15 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center max-w-2xl mx-auto">
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-charcoal">Mengapa Memilih SesiTemu?</h2>
                <p class="mt-3 text-sm sm:text-base text-charcoal/70">Dirancang khusus untuk kebutuhan calon pengantin di Indonesia dengan performa ringan dan pengelolaan praktis.</p>
            </div>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="rounded-2xl bg-ivory p-6 ring-1 ring-champagne/20">
                    <div class="w-11 h-11 rounded-xl bg-sage/10 text-sage flex items-center justify-center font-serif text-xl font-bold">01</div>
                    <h3 class="mt-4 font-serif text-xl font-semibold text-charcoal">Pratinjau &amp; Ganti Tema Instan</h3>
                    <p class="mt-2 text-sm text-charcoal/70 leading-relaxed">Coba live demo sebelum daftar, dan ganti tema kapan saja tanpa kehilangan data mempelai maupun acara.</p>
                </div>

                <div class="rounded-2xl bg-ivory p-6 ring-1 ring-champagne/20">
                    <div class="w-11 h-11 rounded-xl bg-champagne/15 text-champagne flex items-center justify-center font-serif text-xl font-bold">02</div>
                    <h3 class="mt-4 font-serif text-xl font-semibold text-charcoal">Otomatis Kompresi WebP</h3>
                    <p class="mt-2 text-sm text-charcoal/70 leading-relaxed">Setiap foto prewedding otomatis di-resize dan dikonversi ke .webp agar undangan terbuka super cepat di HP tamu.</p>
                </div>

                <div class="rounded-2xl bg-ivory p-6 ring-1 ring-champagne/20">
                    <div class="w-11 h-11 rounded-xl bg-sage/10 text-sage flex items-center justify-center font-serif text-xl font-bold">03</div>
                    <h3 class="mt-4 font-serif text-xl font-semibold text-charcoal">Sebar Tamu WhatsApp Massal</h3>
                    <p class="mt-2 text-sm text-charcoal/70 leading-relaxed">Cukup tempel daftar nama tamu, sistem langsung membuat link personal ?to=Nama+Tamu beserta tombol kirim WA.</p>
                </div>

                <div class="rounded-2xl bg-ivory p-6 ring-1 ring-champagne/20">
                    <div class="w-11 h-11 rounded-xl bg-champagne/15 text-champagne flex items-center justify-center font-serif text-xl font-bold">04</div>
                    <h3 class="mt-4 font-serif text-xl font-semibold text-charcoal">RSVP &amp; Amplop Digital</h3>
                    <p class="mt-2 text-sm text-charcoal/70 leading-relaxed">Pantau rekap jumlah tamu hadir, moderasi ucapan doa, serta tampilkan rekening bank/e-wallet dengan fitur salin cepat.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Katalog Tema dengan Filter Kategori, Tingkatan Tier & Modal Simulasi Nama Tamu --}}
    <section id="katalog-tema" class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-widest text-champagne">Pilihan Desain Eksklusif</span>
                    <h2 class="mt-2 font-serif text-3xl sm:text-4xl font-bold text-charcoal">Katalog Tema Undangan</h2>
                </div>

                {{-- Filter Tab Kategori --}}
                <div class="flex flex-wrap gap-2">
                    <button
                        type="button"
                        @click="kategoriAktif = 'semua'"
                        :class="kategoriAktif === 'semua' ? 'bg-sage text-white shadow-sm' : 'bg-white text-charcoal/80 hover:bg-champagne/10 ring-1 ring-charcoal/10'"
                        class="rounded-xl px-4 py-2 text-sm font-semibold transition cursor-pointer"
                    >
                        Semua
                    </button>
                    @foreach (\App\Models\Tema::KATEGORI_TERSEDIA as $kode => $label)
                        <button
                            type="button"
                            @click="kategoriAktif = '{{ $kode }}'"
                            :class="kategoriAktif === '{{ $kode }}' ? 'bg-sage text-white shadow-sm' : 'bg-white text-charcoal/80 hover:bg-champagne/10 ring-1 ring-charcoal/10'"
                            class="rounded-xl px-4 py-2 text-sm font-semibold transition cursor-pointer"
                        >
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Pilihan Tingkatan Kualitas (Tier) Tema --}}
            <div class="mt-7 grid grid-cols-2 lg:grid-cols-4 gap-3">
                <button
                    type="button"
                    @click="tierAktif = 'semua'"
                    :class="tierAktif === 'semua' ? 'bg-sage/10 ring-2 ring-sage shadow-sm' : 'bg-white ring-1 ring-champagne/25 hover:ring-champagne/60'"
                    class="rounded-2xl p-3.5 text-left transition cursor-pointer"
                >
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-sm font-bold text-charcoal">Semua Tier</span>
                        <span class="rounded-full bg-ivory px-2.5 py-0.5 text-[11px] font-semibold text-charcoal/70 ring-1 ring-charcoal/10">
                            {{ $daftarTema->count() }} Tema
                        </span>
                    </div>
                    <p class="mt-1 text-xs text-charcoal/65">Tampilkan seluruh koleksi</p>
                </button>

                @foreach ([
                    'basic' => ['ikon_warna' => 'bg-sage', 'deskripsi' => 'Elegan, clean & cepat dimuat', 'active' => 'bg-sage/10 ring-2 ring-sage shadow-sm'],
                    'premium' => ['ikon_warna' => 'bg-champagne', 'deskripsi' => 'Detail artistik & ornamen adat', 'active' => 'bg-champagne/15 ring-2 ring-champagne shadow-sm'],
                    'eksklusif' => ['ikon_warna' => 'bg-charcoal', 'deskripsi' => 'Efek motion & nuansa luxury', 'active' => 'bg-charcoal text-ivory ring-2 ring-champagne shadow-md'],
                ] as $kodeTier => $metaTier)
                    @php $dataTier = $ringkasanTier[$kodeTier]; @endphp
                    <button
                        type="button"
                        @click="tierAktif = '{{ $kodeTier }}'"
                        :class="tierAktif === '{{ $kodeTier }}' ? '{{ $metaTier['active'] }}' : 'bg-white ring-1 ring-champagne/25 hover:ring-champagne/60'"
                        class="rounded-2xl p-3.5 text-left transition cursor-pointer"
                    >
                        <div class="flex items-center justify-between gap-2">
                            <span class="inline-flex items-center gap-1.5 text-sm font-bold" :class="tierAktif === 'eksklusif' && '{{ $kodeTier }}' === 'eksklusif' ? 'text-champagne' : 'text-charcoal'">
                                <span class="w-2 h-2 rounded-full {{ $metaTier['ikon_warna'] }}" :class="tierAktif === 'eksklusif' && '{{ $kodeTier }}' === 'eksklusif' ? 'bg-champagne' : ''"></span>
                                {{ $dataTier['label'] }}
                            </span>
                            <span
                                class="rounded-full px-2.5 py-0.5 text-[11px] font-semibold"
                                :class="tierAktif === 'eksklusif' && '{{ $kodeTier }}' === 'eksklusif' ? 'bg-champagne/20 text-champagne' : 'bg-ivory text-charcoal/75 ring-1 ring-charcoal/10'"
                            >
                                Mulai {{ \App\Models\Tema::formatRupiah($dataTier['harga_mulai']) }}
                            </span>
                        </div>
                        <p
                            class="mt-1 text-xs"
                            :class="tierAktif === 'eksklusif' && '{{ $kodeTier }}' === 'eksklusif' ? 'text-ivory/80' : 'text-charcoal/65'"
                        >
                            {{ $metaTier['deskripsi'] }} ({{ $dataTier['jumlah'] }} tema)
                        </p>
                    </button>
                @endforeach
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($daftarTema as $tema)
                    @php
                        $infoDesain = $tema->infoDesain();
                        $infoTier = $tema->infoTier();
                    @endphp
                    <div
                        x-show="temaCocok('{{ $tema->kategori }}', '{{ $infoTier['kode'] }}')"
                        x-transition
                        class="group rounded-2xl bg-white overflow-hidden {{ $infoTier['card_ring'] }} flex flex-col transition duration-300"
                    >
                        <div class="aspect-[4/3] bg-ivory relative overflow-hidden">
                            @if ($tema->urlGambarPratinjau())
                                <img
                                    src="{{ $tema->urlGambarPratinjau() }}"
                                    alt="{{ $tema->nama_tema }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                >
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-sage/10 text-sage font-serif text-2xl">
                                    {{ $tema->nama_tema }}
                                </div>
                            @endif
                            <span class="absolute top-3 left-3 rounded-full bg-white/95 backdrop-blur px-3 py-1 text-xs font-semibold uppercase tracking-wider text-charcoal shadow-sm">
                                {{ $tema->kategoriLabel() }}
                            </span>
                            @if ($infoDesain['dukungan_tf'])
                                <span class="absolute top-3 right-3 rounded-full bg-charcoal/85 backdrop-blur px-2.5 py-1 text-[11px] font-medium text-ivory">
                                    Support Tanpa Foto (TF)
                                </span>
                            @endif
                            <span class="absolute bottom-3 left-3 inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-[11px] font-bold uppercase tracking-wider backdrop-blur {{ $infoTier['badge_class'] }}">
                                @if ($infoTier['kode'] === 'eksklusif')
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M2.5 14.5h15v1.75a.75.75 0 01-.75.75H3.25a.75.75 0 01-.75-.75V14.5zm0-2L1.75 6l4.75 3.25L10 4.5l3.5 4.75L18.25 6l-.75 6.5h-15z"/>
                                    </svg>
                                @elseif ($infoTier['kode'] === 'premium')
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.96a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.447a1 1 0 00-.364 1.118l1.286 3.96c.3.921-.755 1.688-1.54 1.118l-3.367-2.447a1 1 0 00-1.175 0l-3.367 2.447c-.784.57-1.838-.197-1.539-1.118l1.285-3.96a1 1 0 00-.363-1.118L2.063 9.387c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.96z"/>
                                    </svg>
                                @else
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 2a1 1 0 01.894.553l1.72 3.44 3.796.552a1 1 0 01.554 1.706l-2.747 2.677.648 3.781a1 1 0 01-1.45 1.054L10 13.978l-3.415 1.785a1 1 0 01-1.45-1.054l.648-3.781L3.036 8.25a1 1 0 01.554-1.706l3.796-.552 1.72-3.44A1 1 0 0110 2z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                                <span>{{ $infoTier['label'] }}</span>
                            </span>
                            @if ($tema->adaDiskon())
                                <span class="absolute bottom-3 right-3 rounded-full bg-rose-600 px-3 py-1 text-[11px] font-bold text-white shadow-sm">
                                    {{ $tema->labelBadgeDiskon() }}
                                </span>
                            @endif
                        </div>

                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between gap-2 pb-3 mb-3 border-b border-champagne/15">
                                    <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-[11px] font-semibold {{ $infoTier['chip_class'] }}">
                                        {{ $infoTier['ringkasan'] }}
                                    </span>
                                    <div class="text-right shrink-0">
                                        @if ($tema->adaDiskon())
                                            <span class="block text-[11px] text-charcoal/45 line-through leading-none mb-0.5">{{ $tema->hargaAsliFormatted() }}</span>
                                        @endif
                                        <span class="text-lg font-extrabold {{ $tema->adaDiskon() ? 'text-rose-600' : 'text-charcoal' }}">{{ $tema->hargaFormatted() }}</span>
                                        <span class="text-[11px] text-charcoal/55">/ {{ $durasiAktifBulan ?? \App\Support\PengaturanSesiTemu::masaAktifBulan() }} bln</span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 text-[11px] font-semibold uppercase tracking-wider text-champagne">
                                    <span class="inline-block w-2 h-2 rounded-full" style="background-color: {{ $infoDesain['warna_aksen'] }}"></span>
                                    <span>{{ $infoDesain['font_label'] }}</span>
                                </div>
                                <h3 class="mt-1.5 font-serif text-2xl font-bold text-charcoal">{{ $tema->nama_tema }}</h3>
                                <p class="mt-1.5 text-sm text-charcoal/65 leading-relaxed">{{ $infoDesain['deskripsi'] }}</p>
                                <p class="mt-2.5 text-[11px] font-medium text-sage">{{ $infoTier['fitur_singkat'] }}</p>
                            </div>

                            <div class="mt-6 flex items-center gap-3">
                                <button
                                    type="button"
                                    @click="bukaModalDemo('{{ $tema->slug }}', '{{ e($tema->nama_tema) }}', '{{ $infoTier['label'] }} • {{ $tema->hargaFormatted() }}')"
                                    class="flex-1 rounded-xl border border-champagne px-4 py-2.5 text-sm font-semibold text-charcoal hover:bg-champagne/10 transition cursor-pointer"
                                >
                                    Lihat Demo
                                </button>
                                <a
                                    href="{{ auth()->check() ? route('dasbor.katalog', ['pakai' => $tema->id]) : route('daftar', ['tema' => $tema->id]) }}"
                                    class="flex-1 text-center rounded-xl bg-sage px-4 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition"
                                >
                                    Pakai Tema Ini
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 bg-white rounded-2xl ring-1 ring-champagne/20">
                        <p class="text-charcoal/70">Belum ada tema aktif tersedia saat ini.</p>
                    </div>
                @endforelse

                @if ($daftarTema->isNotEmpty())
                    <div
                        x-show="!adaHasilFilter"
                        x-cloak
                        class="col-span-full text-center py-12 bg-white rounded-2xl ring-1 ring-champagne/25 px-6"
                    >
                        <p class="text-charcoal/75 font-medium">Tidak ada tema pada kombinasi kategori dan tingkatan yang dipilih.</p>
                        <button
                            type="button"
                            @click="resetFilter()"
                            class="mt-4 rounded-xl bg-sage px-5 py-2 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer"
                        >
                            Tampilkan Semua Tema
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Tabel Perbandingan 2 Paket Harga --}}
    <section id="paket-harga" class="py-20 bg-white border-t border-champagne/15 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <div class="text-center max-w-2xl mx-auto">
                <span class="text-xs font-semibold uppercase tracking-widest text-champagne">Transparan &amp; Fleksibel</span>
                <h2 class="mt-2 font-serif text-3xl sm:text-4xl font-bold text-charcoal">Pilih Paket Sesuai Kebutuhan Anda</h2>
                <p class="mt-3 text-sm sm:text-base text-charcoal/70">Harga dasar mengikuti tema pilihan Anda (Basic, Premium, atau Eksklusif). Susun sendiri lewat dasbor atau serahkan ke tim SesiTemu.</p>
            </div>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Paket Mandiri --}}
                <div class="rounded-2xl bg-ivory p-8 ring-1 ring-champagne/25 flex flex-col justify-between">
                    <div>
                        <span class="inline-block rounded-full bg-sage/10 px-3 py-1 text-xs font-semibold text-sage">Self-Service</span>
                        <h3 class="mt-4 font-serif text-3xl font-bold text-charcoal">Paket Mandiri</h3>
                        <p class="mt-2 text-sm text-charcoal/70">Client mengisi data mempelai, acara, galeri, dan amplop secara mandiri melalui dasbor SesiTemu.</p>
                        <div class="mt-6">
                            <div class="flex items-baseline gap-2">
                                <span class="text-sm font-semibold text-charcoal/65">Mulai</span>
                                <span class="font-serif text-4xl font-bold text-charcoal">{{ \App\Models\Tema::formatRupiah($hargaTermurah) }}</span>
                                <span class="text-sm text-charcoal/60">/ {{ $durasiAktifBulan ?? \App\Support\PengaturanSesiTemu::masaAktifBulan() }} bulan aktif</span>
                            </div>
                            <p class="mt-1 text-xs text-charcoal/60">
                                Mengikuti harga tema pilihan ({{ \App\Models\Tema::formatRupiah($hargaTermurah) }} – {{ \App\Models\Tema::formatRupiah($hargaTermahal) }})
                            </p>
                        </div>

                        <ul class="mt-6 space-y-3 text-sm text-charcoal/80">
                            <li>✓ Harga sesuai tema pilihan (Basic, Premium, atau Eksklusif)</li>
                            <li>✓ Bebas ganti tema setara atau upgrade kapan saja</li>
                            <li>✓ Editor mandiri 6-tab real-time + pratinjau gratis</li>
                            <li>✓ Maksimal 10 foto galeri otomatis WebP</li>
                            <li>✓ Generator link tamu WhatsApp tanpa batas</li>
                            <li>✓ Rekap RSVP, ucapan doa, &amp; amplop digital</li>
                        </ul>
                    </div>

                    <a href="{{ route('daftar') }}" class="mt-8 block text-center rounded-xl bg-sage px-6 py-3.5 text-sm font-semibold text-white hover:bg-sage/90 transition">
                        Mulai Buat Draft Gratis
                    </a>
                </div>

                {{-- Paket Terima Beres --}}
                <div class="rounded-2xl bg-charcoal text-ivory p-8 ring-2 ring-champagne relative flex flex-col justify-between shadow-lg">
                    <span class="absolute -top-3.5 right-6 rounded-full bg-champagne px-3 py-1 text-xs font-bold uppercase tracking-wider text-charcoal">
                        Paling Praktis
                    </span>

                    <div>
                        <span class="inline-block rounded-full bg-champagne/20 px-3 py-1 text-xs font-semibold text-champagne">Full Assistance</span>
                        <h3 class="mt-4 font-serif text-3xl font-bold text-white">Paket Terima Beres</h3>
                        <p class="mt-2 text-sm text-ivory/75">Client cukup mengirimkan data &amp; foto via WhatsApp, Admin SesiTemu yang menginputkan semuanya hingga siap sebar.</p>
                        <div class="mt-6">
                            <div class="flex flex-wrap items-baseline gap-2">
                                <span class="font-serif text-3xl sm:text-4xl font-bold text-champagne">Harga Tema + {{ \App\Models\Tema::formatRupiah($biayaTerimaBeres) }}</span>
                            </div>
                            <p class="mt-1 text-xs text-ivory/65">
                                Total mulai {{ \App\Models\Tema::formatRupiah($hargaTermurah + $biayaTerimaBeres) }} / {{ $durasiAktifBulan ?? \App\Support\PengaturanSesiTemu::masaAktifBulan() }} bulan aktif (sudah termasuk jasa input Admin)
                            </p>
                        </div>

                        <ul class="mt-6 space-y-3 text-sm text-ivory/85">
                            <li>✓ Sudah termasuk harga tema pilihan Anda</li>
                            <li>✓ Biaya jasa input &amp; tata letak Admin (+{{ \App\Models\Tema::formatRupiah($biayaTerimaBeres) }})</li>
                            <li>✓ Konsultasi pemilihan tema &amp; musik latar</li>
                            <li>✓ Bantuan revisi teks &amp; jadwal acara via WhatsApp</li>
                            <li>✓ Prioritas aktivasi instan siap sebar</li>
                        </ul>
                    </div>

                    <a
                        href="{{ $urlWaTerimaBeres ?? \App\Support\PengaturanSesiTemu::urlWaAdmin('Halo Admin SesiTemu, saya tertarik memesan Paket Terima Beres untuk undangan pernikahan digital.') }}"
                        target="_blank"
                        rel="noopener"
                        class="mt-8 block text-center rounded-xl bg-champagne px-6 py-3.5 text-sm font-semibold text-charcoal hover:bg-champagne/90 transition"
                    >
                        Pesan via WhatsApp Admin
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="py-10 px-4 sm:px-6 lg:px-8 border-t border-champagne/20 bg-ivory text-center text-sm text-charcoal/65">
        <a href="{{ route('beranda') }}" class="inline-flex flex-col items-center">
            <img
                src="{{ asset('aset-demo/logo-sesi-temu-lengkap.webp') }}"
                alt="Logo SesiTemu"
                class="h-20 w-auto object-contain mb-2"
            >
            <span class="text-xs font-semibold tracking-widest uppercase text-charcoal/70">SesiTemu.id</span>
        </a>
        <p class="mt-1">Abadikan Setiap Sesi Bahagia Menuju Hari Pertemuan &copy; {{ now()->format('Y') }}</p>
    </footer>

    {{-- Modal Simulasi Nama Tamu Live Demo --}}
    <div
        x-show="modalDemoTerbuka"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-charcoal/60 backdrop-blur-sm p-4"
        @keydown.escape.window="modalDemoTerbuka = false"
    >
        <div @click.away="modalDemoTerbuka = false" class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl ring-1 ring-champagne/30">
            <h3 class="font-serif text-2xl font-bold text-charcoal">Simulasi Tamu Undangan</h3>
            <p class="mt-1 text-sm text-charcoal/70">
                Masukkan nama tamu contoh untuk melihat tampilan sampul tema <span class="font-semibold text-sage" x-text="temaDemoNama"></span><span x-show="temaDemoInfo" class="ml-1 inline-block rounded-full bg-champagne/15 px-2 py-0.5 text-xs font-semibold text-charcoal" x-text="temaDemoInfo"></span>.
            </p>

            <div class="mt-4 space-y-4">
                <div>
                    <label for="nama_tamu_demo" class="block text-sm font-medium text-charcoal">Nama Tamu Undangan</label>
                    <input
                        id="nama_tamu_demo"
                        type="text"
                        x-model="namaTamuDemo"
                        class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/70 px-4 py-2.5 text-sm text-charcoal focus:border-champagne focus:bg-white focus:outline-none focus:ring-2 focus:ring-champagne/25"
                    >
                </div>

                <div>
                    <label for="font_demo" class="block text-sm font-medium text-charcoal">Desain Tipografi (Font)</label>
                    <select
                        id="font_demo"
                        x-model="fontDemo"
                        class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/70 px-4 py-2.5 text-sm text-charcoal focus:border-champagne focus:bg-white focus:outline-none focus:ring-2 focus:ring-champagne/25"
                    >
                        @foreach (\App\Models\Undangan::GAYA_FONT_TERSEDIA as $kodeFont => $infoFont)
                            <option value="{{ $kodeFont }}">{{ $infoFont['label'] }}</option>
                        @endforeach
                    </select>
                </div>

                <label class="flex items-center gap-2.5 rounded-xl border border-champagne/30 bg-ivory/60 px-3.5 py-2.5 text-sm text-charcoal cursor-pointer">
                    <input
                        type="checkbox"
                        x-model="tanpaFotoDemo"
                        class="rounded border-charcoal/25 text-sage focus:ring-sage"
                    >
                    <span>Pratinjau Mode Tanpa Foto (TF / Monogram)</span>
                </label>
            </div>

            <div class="mt-6 flex items-center justify-end gap-3">
                <button type="button" @click="modalDemoTerbuka = false" class="rounded-xl px-4 py-2 text-sm font-semibold text-charcoal/70 hover:bg-charcoal/5 cursor-pointer">
                    Batal
                </button>
                <button type="button" @click="bukaUrlDemo()" class="rounded-xl bg-sage px-5 py-2 text-sm font-semibold text-white hover:bg-sage/90 cursor-pointer">
                    Buka Live Demo
                </button>
            </div>
        </div>
    </div>

    {{-- Tombol WhatsApp Mengambang --}}
    <a
        href="{{ $urlWaKonsultasi ?? \App\Support\PengaturanSesiTemu::urlWaAdmin('Halo SesiTemu, saya ingin konsultasi mengenai undangan pernikahan digital.') }}"
        target="_blank"
        rel="noopener"
        aria-label="Hubungi WhatsApp SesiTemu"
        class="fixed bottom-5 right-5 z-40 inline-flex items-center gap-2 rounded-full bg-sage px-4 py-3 text-sm font-semibold text-white shadow-lg hover:bg-sage/90 transition"
    >
        <span>Konsultasi WA</span>
    </a>
</div>
@endsection
