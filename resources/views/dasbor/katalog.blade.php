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
        tierAktif: 'semua',
        kataCariTema: '',
        previewTerbukaId: null,
        sampulLightboxSlug: null,
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
        temaCocok(tier, nama = '') {
            const cocokTier = this.tierAktif === 'semua' || this.tierAktif === tier;
            const kata = this.kataCariTema.trim().toLowerCase();
            const cocokCari = !kata || nama.toLowerCase().includes(kata);
            return cocokTier && cocokCari;
        },
        resetFilter() {
            this.tierAktif = 'semua';
            this.kataCariTema = '';
        },
        bukaLightboxSampul(slug) {
            this.previewTerbukaId = null;
            this.sampulLightboxSlug = slug;
        },
        tutupLightboxSampul() {
            this.sampulLightboxSlug = null;
        }
    }"
    class="min-h-screen flex flex-col bg-ivory"
>
    @include('dasbor._top-nav', ['halamanAktif' => 'katalog', 'judulMobile' => 'Katalog Tema'])

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 pt-5 pb-28 md:py-8 space-y-5 md:space-y-6">
        @if ($errors->any())
            <div class="rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Judul, Pencarian & Filter Kategori --}}
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4">
            <div>
                <h1 class="font-serif text-2xl sm:text-3xl font-bold text-charcoal">Katalog Tema Undangan</h1>
                <p class="text-xs sm:text-sm text-charcoal/70 mt-1">
                    Sentuh <strong>Preview</strong> lalu pilih <strong>Pakai Foto</strong> atau <strong>Tanpa Foto</strong> untuk uji tampilan sebelum menerapkan tema.
                </p>
            </div>

            <div class="relative w-full sm:w-64 shrink-0">
                <svg class="w-4 h-4 text-charcoal/45 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
                <input
                    type="search"
                    x-model="kataCariTema"
                    placeholder="Cari tema..."
                    aria-label="Cari tema katalog"
                    class="w-full rounded-xl border border-champagne/40 bg-white pl-9 pr-3 py-2 text-xs sm:text-sm text-charcoal placeholder:text-charcoal/45 focus:border-sage focus:outline-none focus:ring-2 focus:ring-sage/15"
                >
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
                    x-show="temaCocok('{{ $infoTier['kode'] }}', '{{ e($tema->nama_tema.' '.$tema->kategoriLabel()) }}')"
                    x-transition
                    class="group rounded-2xl bg-white {{ $infoTier['card_ring'] }} flex flex-col transition duration-300 hover:shadow-xl hover:-translate-y-0.5 relative"
                >
                    <button
                        type="button"
                        @click="bukaLightboxSampul('{{ $tema->slug }}')"
                        aria-label="Perbesar sampul {{ $tema->nama_tema }}"
                        class="group/poster relative block w-full overflow-hidden rounded-t-2xl bg-ivory text-left cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-sage"
                    >
                        <div class="transition-transform duration-500 group-hover/poster:scale-[1.02]">
                            <x-poster-sampul-tema :tema="$tema" />
                        </div>

                        <span class="pointer-events-none absolute bottom-2.5 right-2.5 z-20 inline-flex items-center gap-1 rounded-full bg-charcoal/80 px-2.5 py-1 text-[10px] font-semibold text-white backdrop-blur-xs shadow-sm opacity-90 group-hover/poster:opacity-100 group-hover/poster:bg-sage transition">
                            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.3-4.3" />
                                <path d="M11 8v6" />
                                <path d="M8 11h6" />
                            </svg>
                            <span>Lihat Sampul</span>
                        </span>
                    </button>

                    <div class="p-4 sm:p-6 bg-white rounded-b-2xl flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex flex-wrap items-center justify-between gap-2 text-[11px]">
                                <div class="flex items-center gap-1.5">
                                    <span class="font-bold uppercase tracking-wider text-[#8A6D33]">{{ $tema->kategoriLabel() }}</span>
                                    <span class="text-charcoal/25">&bull;</span>
                                    <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider {{ $infoTier['badge_class'] }}">
                                        <span>{{ $infoTier['label'] }}</span>
                                    </span>
                                </div>
                                @if ($infoDesain['dukungan_tf'])
                                    <span class="rounded-full bg-ivory px-2.5 py-0.5 font-medium text-charcoal/75 ring-1 ring-champagne/30">
                                        Support Tanpa Foto
                                    </span>
                                @endif
                            </div>

                            <h2 class="mt-2 font-logo text-xl sm:text-2xl font-bold text-charcoal leading-snug">{{ $tema->nama_tema }}</h2>
                            <p class="mt-1.5 text-xs sm:text-sm text-charcoal/65 leading-relaxed">{{ $infoDesain['deskripsi'] }}</p>

                            <div class="mt-3 pt-3 border-t border-champagne/15 flex items-end justify-between gap-2">
                                <div>
                                    @if ($tema->adaDiskon())
                                        <span class="block text-[11px] text-charcoal/45 line-through leading-none mb-0.5">{{ $tema->hargaAsliFormatted() }}</span>
                                    @endif
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-base sm:text-lg font-extrabold {{ $tema->adaDiskon() ? 'text-rose-600' : 'text-charcoal' }}">{{ $tema->hargaFormatted() }}</span>
                                        <span class="text-[11px] text-charcoal/55">/ {{ $durasiAktifBulan }} bln</span>
                                    </div>
                                </div>

                                <span class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1 text-[10px] font-semibold {{ $infoTier['chip_class'] }}">
                                    <span class="inline-block w-1.5 h-1.5 rounded-full" style="background-color: {{ $infoDesain['warna_aksen'] }}"></span>
                                    <span>{{ $infoTier['ringkasan'] }}</span>
                                </span>
                            </div>
                        </div>

                        <div class="mt-5 space-y-2">
                            <div
                                class="relative"
                                @click.away="if (previewTerbukaId === {{ $tema->id }}) previewTerbukaId = null"
                                @keydown.escape.window="if (previewTerbukaId === {{ $tema->id }}) previewTerbukaId = null"
                            >
                                {{-- Menu 2 Pilihan Muncul di Atas Tombol Preview --}}
                                <div
                                    x-show="previewTerbukaId === {{ $tema->id }}"
                                    x-cloak
                                    x-transition:enter="transition ease-out duration-150"
                                    x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                    x-transition:leave="transition ease-in duration-100"
                                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                    x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                                    class="absolute bottom-full inset-x-0 mb-2 z-30 rounded-2xl bg-white p-1.5 shadow-xl ring-1 ring-champagne/45 space-y-1.5"
                                >
                                    <a
                                        href="{{ route('tema.demo', ['slugTema' => $tema->slug, 'dari' => 'katalog']) }}"
                                        class="w-full flex items-center justify-between gap-2 rounded-xl bg-ivory/80 hover:bg-sage/10 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-charcoal hover:text-sage transition"
                                    >
                                        <span class="inline-flex items-center gap-2">
                                            <svg class="w-4 h-4 text-sage shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <rect width="18" height="18" x="3" y="3" rx="2" ry="2" />
                                                <circle cx="9" cy="9" r="2" />
                                                <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                                            </svg>
                                            <span>Pakai Foto</span>
                                        </span>
                                        <svg class="w-3.5 h-3.5 text-charcoal/45 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M5 12h14" />
                                            <path d="m12 5 7 7-7 7" />
                                        </svg>
                                    </a>

                                    <a
                                        href="{{ route('tema.demo', ['slugTema' => $tema->slug, 'tf' => 1, 'dari' => 'katalog']) }}"
                                        class="w-full flex items-center justify-between gap-2 rounded-xl bg-ivory/80 hover:bg-champagne/15 px-3.5 py-2.5 text-xs sm:text-sm font-semibold text-charcoal hover:text-[#8A6D33] transition"
                                    >
                                        <span class="inline-flex items-center gap-2">
                                            <svg class="w-4 h-4 text-[#8A6D33] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10" />
                                                <path d="m9 12 2 2 4-4" />
                                            </svg>
                                            <span>Tanpa Foto</span>
                                        </span>
                                        <svg class="w-3.5 h-3.5 text-charcoal/45 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M5 12h14" />
                                            <path d="m12 5 7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>

                                <button
                                    type="button"
                                    @click.stop="previewTerbukaId = (previewTerbukaId === {{ $tema->id }} ? null : {{ $tema->id }})"
                                    :aria-expanded="(previewTerbukaId === {{ $tema->id }}).toString()"
                                    :class="previewTerbukaId === {{ $tema->id }} ? 'border-sage bg-sage/5 text-sage' : 'border-champagne/55 bg-white text-charcoal hover:bg-champagne/10'"
                                    class="w-full inline-flex items-center justify-between gap-2 rounded-xl border px-3.5 py-2.5 text-xs sm:text-sm font-semibold transition cursor-pointer"
                                >
                                    <span class="inline-flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-sage shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                        <span>Preview</span>
                                    </span>
                                    <span class="inline-flex items-center gap-1.5">
                                        <span class="inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-sage text-[10px] font-bold text-white px-1.5">2</span>
                                        <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="previewTerbukaId === {{ $tema->id }} ? 'rotate-180 text-sage' : 'text-charcoal/55'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="m18 15-6-6-6 6" />
                                        </svg>
                                    </span>
                                </button>
                            </div>

                            <button
                                type="button"
                                data-pakai-tema="{{ $tema->id }}"
                                @click="bukaModalPakai(@js($payloadTema))"
                                class="w-full rounded-xl bg-sage px-3 sm:px-4 py-2.5 text-xs sm:text-sm font-bold text-white shadow-xs hover:bg-[#3b5047] transition cursor-pointer"
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
            <h3 class="font-serif text-xl sm:text-2xl font-bold text-charcoal">Pratinjau Tema</h3>
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
                    Buka Preview
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

    <x-modal-lightbox-sampul :daftar-tema="$daftarTema" :mode-katalog-client="true" />
</div>
@endsection
