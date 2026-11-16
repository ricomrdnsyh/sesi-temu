@extends('layouts.aplikasi')

@section('judul', 'Katalog Tema — Client SesiTemu')

@section('konten')
@php
    $adaGalatModalPakai = $errors->hasAny(['slug', 'tema_id', 'undangan_id', 'nama_panggilan_pria', 'nama_lengkap_pria', 'nama_panggilan_wanita', 'nama_lengkap_wanita']);
    $punyaUndanganSebelumnya = $daftarUndanganSaya->isNotEmpty();

    $temaInitial = $temaPrepilih ? [
        'id' => $temaPrepilih->id,
        'nama_tema' => $temaPrepilih->nama_tema,
        'kategori' => $temaPrepilih->kategoriLabel(),
        'tier' => $temaPrepilih->tierLabel(),
        'harga' => $temaPrepilih->hargaFormatted(),
        'harga_asli' => $temaPrepilih->adaDiskon() ? $temaPrepilih->hargaAsliFormatted() : null,
        'badge_diskon' => $temaPrepilih->labelBadgeDiskon(),
        'gambar_url' => $temaPrepilih->urlGambarPratinjau(),
    ] : null;
@endphp

<div
    x-data="{
        kategoriAktif: 'semua',
        tierAktif: 'semua',
        modalDemoTerbuka: false,
        temaDemoSlug: '',
        temaDemoNama: '',
        temaDemoInfo: '',
        namaTamuDemo: 'Budi Santoso',
        fontDemo: 'bawaan',
        tanpaFotoDemo: false,
        modalPakaiTerbuka: {{ ($temaInitial !== null) ? 'true' : 'false' }},
        alurPakai: '{{ $adaGalatModalPakai && ! old('undangan_id') ? 'buat' : ($punyaUndanganSebelumnya ? 'terapkan' : 'buat') }}',
        temaDipilih: @js($temaInitial ?? [
            'id' => null,
            'nama_tema' => '',
            'kategori' => '',
            'tier' => '',
            'harga' => '',
            'harga_asli' => null,
            'badge_diskon' => null,
            'gambar_url' => null,
        ]),
        bukaModalDemo(slug, nama, info) {
            this.temaDemoSlug = slug;
            this.temaDemoNama = nama;
            this.temaDemoInfo = info;
            this.tanpaFotoDemo = false;
            this.fontDemo = 'bawaan';
            this.modalDemoTerbuka = true;
        },
        bukaUrlDemo() {
            const url = new URL('{{ url('/demo') }}/' + this.temaDemoSlug, window.location.origin);
            url.searchParams.set('to', this.namaTamuDemo.trim() || 'Tamu Spesial');
            url.searchParams.set('dari', 'katalog');
            if (this.fontDemo && this.fontDemo !== 'bawaan') {
                url.searchParams.set('font', this.fontDemo);
            }
            if (this.tanpaFotoDemo) {
                url.searchParams.set('tf', '1');
            }
            window.location.href = url.toString();
        },
        bukaModalPakai(payload) {
            this.temaDipilih = payload;
            this.alurPakai = {{ $punyaUndanganSebelumnya ? 'true' : 'false' }} ? 'terapkan' : 'buat';
            this.modalPakaiTerbuka = true;
        },
        temaCocok(kategori, tier) {
            const cocokKategori = this.kategoriAktif === 'semua' || this.kategoriAktif === kategori;
            const cocokTier = this.tierAktif === 'semua' || this.tierAktif === tier;
            return cocokKategori && cocokTier;
        },
        resetFilter() {
            this.kategoriAktif = 'semua';
            this.tierAktif = 'semua';
        }
    }"
    class="min-h-screen flex flex-col bg-ivory"
>
    @include('dasbor._top-nav', ['halamanAktif' => 'katalog', 'judulMobile' => 'Katalog Tema'])

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 pt-5 pb-28 md:py-8 space-y-5 md:space-y-6">
        @if (session('sukses'))
            <div class="rounded-xl bg-sage/10 border border-sage/30 px-4 py-3 text-sm text-sage">
                {{ session('sukses') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Judul & Filter Kategori --}}
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4">
            <div>
                <h1 class="font-serif text-2xl sm:text-3xl font-bold text-charcoal">Katalog Tema Undangan</h1>
                <p class="text-xs sm:text-sm text-charcoal/70 mt-1">
                    Pilih desain favorit Anda lalu langsung terapkan ke undangan yang ada atau buat draft baru.
                </p>
            </div>

            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1 lg:pb-0">
                <button
                    type="button"
                    @click="kategoriAktif = 'semua'"
                    :class="kategoriAktif === 'semua' ? 'bg-sage text-white shadow-sm' : 'bg-white text-charcoal/80 hover:bg-champagne/10 ring-1 ring-charcoal/10'"
                    class="rounded-xl px-3.5 sm:px-4 py-2 text-xs sm:text-sm font-semibold transition cursor-pointer shrink-0"
                >
                    Semua
                </button>
                @foreach (\App\Models\Tema::KATEGORI_TERSEDIA as $kode => $label)
                    <button
                        type="button"
                        @click="kategoriAktif = '{{ $kode }}'"
                        :class="kategoriAktif === '{{ $kode }}' ? 'bg-sage text-white shadow-sm' : 'bg-white text-charcoal/80 hover:bg-champagne/10 ring-1 ring-charcoal/10'"
                        class="rounded-xl px-3.5 sm:px-4 py-2 text-xs sm:text-sm font-semibold transition cursor-pointer shrink-0"
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Filter Tingkatan Kualitas (Tier) --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-3">
            <button
                type="button"
                @click="tierAktif = 'semua'"
                :class="tierAktif === 'semua' ? 'bg-sage/10 ring-2 ring-sage shadow-sm' : 'bg-white ring-1 ring-champagne/25 hover:ring-champagne/60'"
                class="rounded-2xl p-3 sm:p-3.5 text-left transition cursor-pointer"
            >
                <div class="flex items-center justify-between gap-1.5">
                    <span class="text-xs sm:text-sm font-bold text-charcoal">Semua Tier</span>
                    <span class="rounded-full bg-ivory px-2 py-0.5 text-[10px] sm:text-[11px] font-semibold text-charcoal/70 ring-1 ring-charcoal/10">
                        {{ $daftarTema->count() }}
                    </span>
                </div>
                <p class="mt-1 text-[11px] sm:text-xs text-charcoal/65 truncate">Semua koleksi desain</p>
            </button>

            @foreach ([
                'basic' => ['ikon_warna' => 'bg-sage', 'deskripsi' => 'Elegan, clean & ringan', 'active' => 'bg-sage/10 ring-2 ring-sage shadow-sm'],
                'premium' => ['ikon_warna' => 'bg-champagne', 'deskripsi' => 'Detail artistik & adat', 'active' => 'bg-champagne/15 ring-2 ring-champagne shadow-sm'],
                'eksklusif' => ['ikon_warna' => 'bg-charcoal', 'deskripsi' => 'Motion & nuansa luxury', 'active' => 'bg-charcoal text-ivory ring-2 ring-champagne shadow-md'],
            ] as $kodeTier => $metaTier)
                @php $dataTier = $ringkasanTier[$kodeTier]; @endphp
                <button
                    type="button"
                    @click="tierAktif = '{{ $kodeTier }}'"
                    :class="tierAktif === '{{ $kodeTier }}' ? '{{ $metaTier['active'] }}' : 'bg-white ring-1 ring-champagne/25 hover:ring-champagne/60'"
                    class="rounded-2xl p-3 sm:p-3.5 text-left transition cursor-pointer"
                >
                    <div class="flex items-center justify-between gap-1.5">
                        <span class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold" :class="tierAktif === 'eksklusif' && '{{ $kodeTier }}' === 'eksklusif' ? 'text-champagne' : 'text-charcoal'">
                            <span class="w-2 h-2 rounded-full {{ $metaTier['ikon_warna'] }}" :class="tierAktif === 'eksklusif' && '{{ $kodeTier }}' === 'eksklusif' ? 'bg-champagne' : ''"></span>
                            {{ $dataTier['label'] }}
                        </span>
                        <span
                            class="rounded-full px-2 py-0.5 text-[10px] sm:text-[11px] font-semibold"
                            :class="tierAktif === 'eksklusif' && '{{ $kodeTier }}' === 'eksklusif' ? 'bg-champagne/20 text-champagne' : 'bg-ivory text-charcoal/75 ring-1 ring-charcoal/10'"
                        >
                            {{ \App\Models\Tema::formatRupiah($dataTier['harga_mulai']) }}
                        </span>
                    </div>
                    <p
                        class="mt-1 text-[11px] sm:text-xs truncate"
                        :class="tierAktif === 'eksklusif' && '{{ $kodeTier }}' === 'eksklusif' ? 'text-ivory/80' : 'text-charcoal/65'"
                    >
                        {{ $metaTier['deskripsi'] }} ({{ $dataTier['jumlah'] }})
                    </p>
                </button>
            @endforeach
        </div>

        {{-- Daftar Kartu Tema --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @forelse ($daftarTema as $tema)
                @php
                    $infoDesain = $tema->infoDesain();
                    $infoTier = $tema->infoTier();
                    $payloadTema = [
                        'id' => $tema->id,
                        'nama_tema' => $tema->nama_tema,
                        'kategori' => $tema->kategoriLabel(),
                        'tier' => $infoTier['label'],
                        'harga' => $tema->hargaFormatted(),
                        'harga_asli' => $tema->adaDiskon() ? $tema->hargaAsliFormatted() : null,
                        'badge_diskon' => $tema->labelBadgeDiskon(),
                        'gambar_url' => $tema->urlGambarPratinjau(),
                    ];
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
                            <div class="w-full h-full flex items-center justify-center bg-sage/10 text-sage font-serif text-xl sm:text-2xl">
                                {{ $tema->nama_tema }}
                            </div>
                        @endif

                        <span class="absolute top-3 left-3 rounded-full bg-white/95 backdrop-blur px-2.5 sm:px-3 py-1 text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-charcoal shadow-sm">
                            {{ $tema->kategoriLabel() }}
                        </span>

                        @if ($infoDesain['dukungan_tf'])
                            <span class="absolute top-3 right-3 rounded-full bg-charcoal/85 backdrop-blur px-2.5 py-1 text-[10px] sm:text-[11px] font-medium text-ivory">
                                Support Tanpa Foto
                            </span>
                        @endif

                        <span class="absolute bottom-3 left-3 inline-flex items-center gap-1 rounded-full px-2.5 sm:px-3 py-1 text-[11px] font-bold uppercase tracking-wider backdrop-blur {{ $infoTier['badge_class'] }}">
                            <span>{{ $infoTier['label'] }}</span>
                        </span>

                        @if ($tema->adaDiskon())
                            <span class="absolute bottom-3 right-3 rounded-full bg-rose-600 px-2.5 sm:px-3 py-1 text-[11px] font-bold text-white shadow-sm">
                                {{ $tema->labelBadgeDiskon() }}
                            </span>
                        @endif
                    </div>

                    <div class="p-4 sm:p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between gap-2 pb-3 mb-3 border-b border-champagne/15">
                                <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-[11px] font-semibold {{ $infoTier['chip_class'] }}">
                                    {{ $infoTier['ringkasan'] }}
                                </span>
                                <div class="text-right shrink-0">
                                    @if ($tema->adaDiskon())
                                        <span class="block text-[11px] text-charcoal/45 line-through leading-none mb-0.5">{{ $tema->hargaAsliFormatted() }}</span>
                                    @endif
                                    <span class="text-base sm:text-lg font-extrabold {{ $tema->adaDiskon() ? 'text-rose-600' : 'text-charcoal' }}">{{ $tema->hargaFormatted() }}</span>
                                    <span class="text-[11px] text-charcoal/55">/ {{ $durasiAktifBulan }} bln</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 text-[11px] font-semibold uppercase tracking-wider text-champagne">
                                <span class="inline-block w-2 h-2 rounded-full" style="background-color: {{ $infoDesain['warna_aksen'] }}"></span>
                                <span>{{ $infoDesain['font_label'] }}</span>
                            </div>
                            <h2 class="mt-1.5 font-serif text-xl sm:text-2xl font-bold text-charcoal">{{ $tema->nama_tema }}</h2>
                            <p class="mt-1.5 text-xs sm:text-sm text-charcoal/65 leading-relaxed">{{ $infoDesain['deskripsi'] }}</p>
                            <p class="mt-2 text-[11px] font-medium text-sage">{{ $infoTier['fitur_singkat'] }}</p>
                        </div>

                        <div class="mt-5 grid grid-cols-2 gap-2.5">
                            <button
                                type="button"
                                @click="bukaModalDemo('{{ $tema->slug }}', '{{ e($tema->nama_tema) }}', '{{ $infoTier['label'] }} • {{ $tema->hargaFormatted() }}')"
                                class="rounded-xl border border-champagne px-3 sm:px-4 py-2.5 text-xs sm:text-sm font-semibold text-charcoal hover:bg-champagne/10 transition cursor-pointer"
                            >
                                Lihat Demo
                            </button>

                            <button
                                type="button"
                                data-pakai-tema="{{ $tema->id }}"
                                @click="bukaModalPakai(@js($payloadTema))"
                                class="rounded-xl bg-sage px-3 sm:px-4 py-2.5 text-xs sm:text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer"
                            >
                                Pakai Tema Ini
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white rounded-2xl ring-1 ring-champagne/20">
                    <p class="text-sm text-charcoal/70">Belum ada tema aktif tersedia saat ini.</p>
                </div>
            @endforelse
        </div>
    </main>

    @include('dasbor._bottom-nav', ['halamanAktif' => 'katalog', 'modalBuatOnPage' => false])

    {{-- Modal Demo Pratinjau (Tetap di Portal Client) --}}
    <div
        x-show="modalDemoTerbuka"
        x-cloak
        class="fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-charcoal/60 backdrop-blur-sm p-0 sm:p-4"
        @keydown.escape.window="modalDemoTerbuka = false"
    >
        <div @click.away="modalDemoTerbuka = false" class="w-full max-w-md rounded-t-3xl sm:rounded-2xl bg-white p-5 sm:p-6 shadow-xl ring-1 ring-champagne/30 max-h-[90dvh] overflow-y-auto">
            <h3 class="font-serif text-xl sm:text-2xl font-bold text-charcoal">Pratinjau Live Demo</h3>
            <p class="mt-1 text-xs sm:text-sm text-charcoal/70">
                Uji tampilan tema <span class="font-semibold text-sage" x-text="temaDemoNama"></span><span x-show="temaDemoInfo" class="ml-1 inline-block rounded-full bg-champagne/15 px-2 py-0.5 text-[11px] font-semibold text-charcoal" x-text="temaDemoInfo"></span>.
            </p>

            <div class="mt-4 space-y-4">
                <div>
                    <label for="katalog_nama_tamu_demo" class="block text-sm font-medium text-charcoal">Nama Tamu Undangan</label>
                    <input
                        id="katalog_nama_tamu_demo"
                        type="text"
                        x-model="namaTamuDemo"
                        class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/70 px-4 py-2.5 text-sm text-charcoal focus:border-champagne focus:bg-white focus:outline-none"
                    >
                </div>

                <div>
                    <label for="katalog_font_demo" class="block text-sm font-medium text-charcoal">Desain Tipografi (Font)</label>
                    <select
                        id="katalog_font_demo"
                        x-model="fontDemo"
                        class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/70 px-4 py-2.5 text-sm text-charcoal focus:border-champagne focus:bg-white focus:outline-none"
                    >
                        @foreach (\App\Models\Undangan::GAYA_FONT_TERSEDIA as $kodeFont => $infoFont)
                            <option value="{{ $kodeFont }}">{{ $infoFont['label'] }}</option>
                        @endforeach
                    </select>
                </div>

                <label class="flex items-center gap-2.5 rounded-xl border border-champagne/30 bg-ivory/60 px-3.5 py-2.5 text-sm text-charcoal cursor-pointer">
                    <input type="checkbox" x-model="tanpaFotoDemo" class="rounded border-charcoal/25 text-sage focus:ring-sage">
                    <span>Pratinjau Mode Tanpa Foto (TF / Monogram)</span>
                </label>
            </div>

            <div class="mt-6 flex items-center justify-end gap-3">
                <button type="button" @click="modalDemoTerbuka = false" class="rounded-xl px-4 py-2 text-sm font-semibold text-charcoal/70 hover:bg-charcoal/5 cursor-pointer">
                    Batal
                </button>
                <button type="button" @click="bukaUrlDemo()" class="rounded-xl bg-sage px-5 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 cursor-pointer">
                    Buka Live Demo
                </button>
            </div>
        </div>
    </div>

    {{-- Modal Bottom-Sheet Lanjut Pakai Tema Ini --}}
    <div
        x-show="modalPakaiTerbuka"
        x-cloak
        data-modal-pakai-tema
        class="fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-charcoal/60 backdrop-blur-sm p-0 sm:p-4"
        @keydown.escape.window="modalPakaiTerbuka = false"
    >
        <div @click.away="modalPakaiTerbuka = false" class="w-full max-w-lg rounded-t-3xl sm:rounded-2xl bg-white p-5 sm:p-6 shadow-2xl ring-1 ring-champagne/30 max-h-[92dvh] overflow-y-auto space-y-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-sage">Langkah Berikutnya</p>
                    <h3 class="font-serif text-xl sm:text-2xl font-bold text-charcoal">Gunakan Tema Pilihan</h3>
                </div>
                <button type="button" @click="modalPakaiTerbuka = false" aria-label="Tutup modal tema" class="rounded-lg p-1.5 text-charcoal/55 hover:bg-ivory cursor-pointer">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Kartu Ringkas Tema Terpilih --}}
            <div class="flex items-center gap-3.5 rounded-2xl bg-ivory p-3.5 ring-1 ring-champagne/25">
                <template x-if="temaDipilih.gambar_url">
                    <img :src="temaDipilih.gambar_url" :alt="temaDipilih.nama_tema" class="h-16 w-20 rounded-xl object-cover shrink-0 ring-1 ring-champagne/25">
                </template>
                <template x-if="!temaDipilih.gambar_url">
                    <div class="h-16 w-20 rounded-xl bg-sage/15 text-sage font-serif text-sm font-bold flex items-center justify-center shrink-0">Tema</div>
                </template>
                <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-1.5">
                        <span class="rounded-full bg-white px-2 py-0.5 text-[10px] font-bold uppercase text-charcoal ring-1 ring-charcoal/10" x-text="temaDipilih.tier"></span>
                        <span x-show="temaDipilih.badge_diskon" class="rounded-full bg-rose-600 px-2 py-0.5 text-[10px] font-bold text-white" x-text="temaDipilih.badge_diskon"></span>
                    </div>
                    <p class="mt-1 font-serif text-base sm:text-lg font-bold text-charcoal truncate" x-text="temaDipilih.nama_tema"></p>
                    <div class="flex items-center gap-1.5 text-xs">
                        <span x-show="temaDipilih.harga_asli" class="text-charcoal/45 line-through" x-text="temaDipilih.harga_asli"></span>
                        <span class="font-bold text-sage" x-text="temaDipilih.harga"></span>
                    </div>
                </div>
            </div>

            @if ($punyaUndanganSebelumnya)
                {{-- Switcher Lanjut ke Undangan Ada vs Buat Undangan Baru --}}
                <div class="grid grid-cols-2 gap-2 rounded-xl bg-ivory p-1.5 border border-champagne/20">
                    <button
                        type="button"
                        @click="alurPakai = 'terapkan'"
                        :class="alurPakai === 'terapkan' ? 'bg-white text-sage shadow-xs font-bold ring-1 ring-champagne/30' : 'text-charcoal/70 font-semibold'"
                        class="rounded-lg py-2 px-3 text-xs sm:text-sm transition cursor-pointer"
                    >
                        Pakai di Undangan Ada
                    </button>
                    <button
                        type="button"
                        @click="alurPakai = 'buat'"
                        :class="alurPakai === 'buat' ? 'bg-white text-sage shadow-xs font-bold ring-1 ring-champagne/30' : 'text-charcoal/70 font-semibold'"
                        class="rounded-lg py-2 px-3 text-xs sm:text-sm transition cursor-pointer"
                    >
                        Buat Draft Baru
                    </button>
                </div>

                {{-- Alur 1: Terapkan ke Undangan yang Sudah Ada --}}
                <form
                    x-show="alurPakai === 'terapkan'"
                    action="{{ route('dasbor.katalog.terapkan') }}"
                    method="POST"
                    class="space-y-4"
                    data-swal-loading
                    data-swal-loading-title="Menerapkan Tema..."
                    data-swal-loading-text="Sedang memperbarui tema &amp; membuka editor undangan..."
                >
                    @csrf
                    <input type="hidden" name="tema_id" :value="temaDipilih.id">

                    <div>
                        <label for="katalog_undangan_id" class="block text-sm font-medium text-charcoal">Pilih Undangan Anda</label>
                        <select
                            id="katalog_undangan_id"
                            name="undangan_id"
                            required
                            class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm focus:border-champagne focus:bg-white focus:outline-none"
                        >
                            @foreach ($daftarUndanganSaya as $itemUndangan)
                                <option value="{{ $itemUndangan->id }}" @selected((int) old('undangan_id') === $itemUndangan->id)>
                                    {{ $itemUndangan->nama_panggilan_pria }} &amp; {{ $itemUndangan->nama_panggilan_wanita }} (sesitemu.id/{{ $itemUndangan->slug }}) — {{ $itemUndangan->tema?->nama_tema }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1.5 text-xs text-charcoal/60">Data mempelai, acara, foto, dan tamu Anda aman dan tidak akan terhapus.</p>
                    </div>

                    <div class="pt-1 flex justify-end gap-2.5">
                        <button type="button" @click="modalPakaiTerbuka = false" class="rounded-xl px-4 py-2.5 text-sm font-semibold text-charcoal/70 hover:bg-charcoal/5 cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 sm:flex-none rounded-xl bg-sage px-5 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer">
                            Terapkan &amp; Lanjut Kelola →
                        </button>
                    </div>
                </form>
            @endif

            {{-- Alur 2: Buat Draft Undangan Baru dengan Tema Ini --}}
            <form
                x-show="alurPakai === 'buat'"
                action="{{ route('dasbor.undangan.simpan') }}"
                method="POST"
                class="space-y-4"
                data-swal-loading
                data-swal-loading-title="Membuat Draft Undangan..."
                data-swal-loading-text="Menyiapkan editor undangan dengan tema pilihan Anda..."
            >
                @csrf
                <input type="hidden" name="tema_id" :value="temaDipilih.id">

                <div>
                    <label for="katalog_slug_baru" class="block text-sm font-medium text-charcoal">Link Undangan</label>
                    <div class="mt-1.5 flex items-center rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2.5">
                        <span class="text-sm text-charcoal/50">sesitemu.id/</span>
                        <input id="katalog_slug_baru" name="slug" type="text" value="{{ old('slug') }}" required placeholder="raka-maya" class="w-full bg-transparent text-sm font-semibold focus:outline-none ml-0.5">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label for="katalog_panggilan_pria" class="block text-sm font-medium text-charcoal">Panggilan Pria</label>
                        <input id="katalog_panggilan_pria" name="nama_panggilan_pria" type="text" value="{{ old('nama_panggilan_pria') }}" required placeholder="Raka" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm focus:border-champagne focus:bg-white focus:outline-none">
                    </div>
                    <div>
                        <label for="katalog_lengkap_pria" class="block text-sm font-medium text-charcoal">Nama Lengkap Pria</label>
                        <input id="katalog_lengkap_pria" name="nama_lengkap_pria" type="text" value="{{ old('nama_lengkap_pria') }}" required placeholder="Raka Wijaya" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm focus:border-champagne focus:bg-white focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label for="katalog_panggilan_wanita" class="block text-sm font-medium text-charcoal">Panggilan Wanita</label>
                        <input id="katalog_panggilan_wanita" name="nama_panggilan_wanita" type="text" value="{{ old('nama_panggilan_wanita') }}" required placeholder="Maya" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm focus:border-champagne focus:bg-white focus:outline-none">
                    </div>
                    <div>
                        <label for="katalog_lengkap_wanita" class="block text-sm font-medium text-charcoal">Nama Lengkap Wanita</label>
                        <input id="katalog_lengkap_wanita" name="nama_lengkap_wanita" type="text" value="{{ old('nama_lengkap_wanita') }}" required placeholder="Maya Sari" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm focus:border-champagne focus:bg-white focus:outline-none">
                    </div>
                </div>

                <div class="pt-1 flex justify-end gap-2.5">
                    <button type="button" @click="modalPakaiTerbuka = false" class="rounded-xl px-4 py-2.5 text-sm font-semibold text-charcoal/70 hover:bg-charcoal/5 cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 sm:flex-none rounded-xl bg-sage px-5 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer">
                        Buat &amp; Lanjut Isi Undangan →
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
