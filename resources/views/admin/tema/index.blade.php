@extends('admin.kerangka')

@section('judul', 'Katalog Tema — Admin SesiTemu')

@section('isi_admin')
@php
    $adaGalat = $errors->any();
    $galatDariDiskonMassal = $adaGalat && old('target_kategori') !== null;
    $galatDariModalTema = $adaGalat && ! $galatDariDiskonMassal;
    $modeAwalEdit = $galatDariModalTema && old('_modal_mode') === 'edit';
    $biayaTerimaBeres = \App\Support\PengaturanSesiTemu::biayaTerimaBeres();
    $daftarLokasiView = $daftarLokasiView ?? \App\Models\Tema::daftarLokasiViewTersedia();
    $lokasiViewBawaan = array_key_exists('tema.rustic-floral.index', $daftarLokasiView)
        ? 'tema.rustic-floral.index'
        : (array_key_first($daftarLokasiView) ?? 'tema.rustic-floral.index');

    $modalInit = [
        'modalTerbuka' => $galatDariModalTema,
        'modalDiskonMassalTerbuka' => $galatDariDiskonMassal,
        'modeEdit' => $modeAwalEdit,
        'editId' => $galatDariModalTema ? old('_edit_id') : null,
        'form' => [
            'nama_tema' => (string) ($galatDariModalTema ? old('nama_tema', '') : ''),
            'slug' => (string) ($galatDariModalTema ? old('slug', '') : ''),
            'kategori' => (string) ($galatDariModalTema ? old('kategori', 'adat') : 'adat'),
            'lokasi_view' => (string) ($galatDariModalTema ? old('lokasi_view', $lokasiViewBawaan) : $lokasiViewBawaan),
            'harga' => (int) ($galatDariModalTema ? old('harga', 59000) : 59000),
            'diskon_tipe' => (string) ($galatDariModalTema ? old('diskon_tipe', '') : ''),
            'diskon_nilai' => (int) ($galatDariModalTema ? old('diskon_nilai', 0) : 0),
            'aktif' => $galatDariModalTema ? (bool) old('aktif', false) : true,
            'gambar_url' => '',
        ],
        'lokasiViewBawaan' => $lokasiViewBawaan,
        'biayaTerimaBeres' => $biayaTerimaBeres,
        'storeUrl' => route('admin.tema.store'),
        'updateBaseUrl' => url('/admin/tema'),
    ];
@endphp

<div
    x-data="{
        modalTerbuka: false,
        modalDiskonMassalTerbuka: false,
        modeEdit: false,
        editId: null,
        sedangSeretFile: false,
        previewObjectUrl: null,
        namaFileDipilih: '',
        ukuranFileDipilih: '',
        biayaTerimaBeres: 50000,
        lokasiViewBawaan: 'tema.rustic-floral.index',
        form: {
            nama_tema: '',
            slug: '',
            kategori: 'adat',
            lokasi_view: 'tema.rustic-floral.index',
            harga: 59000,
            diskon_tipe: '',
            diskon_nilai: 0,
            aktif: true,
            gambar_url: '',
        },
        storeUrl: '',
        updateBaseUrl: '',
        init() {
            const initEl = document.getElementById('tema-modal-init');
            if (initEl) {
                const data = JSON.parse(initEl.textContent);
                this.modalTerbuka = Boolean(data.modalTerbuka);
                this.modalDiskonMassalTerbuka = Boolean(data.modalDiskonMassalTerbuka);
                this.modeEdit = Boolean(data.modeEdit);
                this.editId = data.editId ?? null;
                this.lokasiViewBawaan = data.lokasiViewBawaan ?? 'tema.rustic-floral.index';
                this.form = { ...this.form, ...(data.form ?? {}) };
                this.biayaTerimaBeres = Number(data.biayaTerimaBeres ?? 50000);
                this.storeUrl = data.storeUrl ?? '';
                this.updateBaseUrl = data.updateBaseUrl ?? '';
            }

            this.$el.addEventListener('click', (event) => {
                const tombolEdit = event.target.closest('[data-buka-modal-edit-tema]');
                if (!tombolEdit) {
                    return;
                }

                const payload = JSON.parse(tombolEdit.dataset.tema || '{}');
                this.bukaModalEdit(payload);
            });
        },
        bukaModalTambah() {
            this.modeEdit = false;
            this.editId = null;
            this.resetFilePreview();
            this.form = {
                nama_tema: '',
                slug: '',
                kategori: 'adat',
                lokasi_view: this.lokasiViewBawaan,
                harga: 59000,
                diskon_tipe: '',
                diskon_nilai: 0,
                aktif: true,
                gambar_url: '',
            };
            this.modalTerbuka = true;
        },
        bukaModalEdit(tema) {
            this.modeEdit = true;
            this.editId = tema.id;
            this.resetFilePreview();
            this.form = {
                nama_tema: tema.nama_tema || '',
                slug: tema.slug || '',
                kategori: tema.kategori || 'adat',
                lokasi_view: tema.lokasi_view || this.lokasiViewBawaan,
                harga: Number(tema.harga ?? 59000),
                diskon_tipe: tema.diskon_tipe || '',
                diskon_nilai: Number(tema.diskon_nilai ?? 0),
                aktif: Boolean(tema.aktif),
                gambar_url: tema.gambar_url || '',
            };
            this.modalTerbuka = true;
        },
        bukaModalDiskonMassal() {
            this.modalDiskonMassalTerbuka = true;
        },
        tutupModal() {
            this.modalTerbuka = false;
            this.modalDiskonMassalTerbuka = false;
        },
        hargaAkhirEstimasi() {
            const hargaDasar = Math.max(0, Number(this.form.harga || 0));
            const nilai = Math.max(0, Number(this.form.diskon_nilai || 0));
            if (!this.form.diskon_tipe || nilai <= 0) {
                return hargaDasar;
            }
            if (this.form.diskon_tipe === 'persen') {
                const persen = Math.min(100, nilai);
                return Math.max(0, hargaDasar - Math.floor(hargaDasar * persen / 100));
            }
            return Math.max(0, hargaDasar - nilai);
        },
        formatRupiah(angka) {
            return 'Rp ' + Number(angka || 0).toLocaleString('id-ID');
        },
        actionForm() {
            return this.modeEdit && this.editId
                ? `${this.updateBaseUrl}/${this.editId}`
                : this.storeUrl;
        },
        urlPratinjauSaatIni() {
            return this.previewObjectUrl || this.form.gambar_url || '';
        },
        pilihGambar(event) {
            const file = event.target.files?.[0];
            if (file) {
                this.setPreviewFile(file);
            }
        },
        jatuhkanGambar(event) {
            this.sedangSeretFile = false;
            const file = event.dataTransfer?.files?.[0];
            if (!file || !file.type.startsWith('image/')) {
                return;
            }

            if (this.$refs.inputGambar) {
                const dt = new DataTransfer();
                dt.items.add(file);
                this.$refs.inputGambar.files = dt.files;
            }

            this.setPreviewFile(file);
        },
        setPreviewFile(file) {
            if (this.previewObjectUrl) {
                URL.revokeObjectURL(this.previewObjectUrl);
            }
            this.previewObjectUrl = URL.createObjectURL(file);
            this.namaFileDipilih = file.name;
            this.ukuranFileDipilih = `${Math.max(1, Math.round(file.size / 1024))} KB`;
        },
        resetFilePreview() {
            if (this.previewObjectUrl) {
                URL.revokeObjectURL(this.previewObjectUrl);
                this.previewObjectUrl = null;
            }
            this.namaFileDipilih = '';
            this.ukuranFileDipilih = '';
            if (this.$refs.inputGambar) {
                this.$refs.inputGambar.value = '';
            }
        },
    }"
    @keydown.escape.window="if (!window.Swal?.isVisible()) tutupModal()"
    class="space-y-6"
>
    <script type="application/json" id="tema-modal-init">{!! json_encode($modalInit, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!}</script>

    <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4">
        <div>
            <h1 class="font-serif text-3xl font-bold text-charcoal">Manajemen Katalog Tema</h1>
            <p class="text-sm text-charcoal/70 mt-1">Kelola desain tema, harga, diskon satuan/massal, thumbnail, dan status aktif.</p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            @if ($jumlahTemaDiskon > 0)
                <form
                    action="{{ route('admin.tema.reset-diskon') }}"
                    method="POST"
                    data-swal-title="Reset Semua Diskon Katalog?"
                    data-swal-confirm="Kembalikan harga seluruh tema yang sedang promo ({{ $jumlahTemaDiskon }} tema) ke harga normal?"
                    data-swal-icon="warning"
                    data-swal-confirm-button="Ya, Reset Diskon"
                    data-swal-confirm-color="#D97706"
                    data-swal-loading-title="Mereset Diskon Katalog..."
                    data-swal-loading-text="Sedang mengembalikan seluruh harga tema ke harga normal..."
                >
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl px-4 py-2 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-amber-300 bg-amber-50 font-semibold text-amber-800 hover:bg-amber-100 cursor-pointer transition">
                        <span>Reset Diskon ({{ $jumlahTemaDiskon }})</span>
                    </button>
                </form>
            @endif

            <button
                type="button"
                @click="bukaModalDiskonMassal()"
                data-buka-modal-diskon-massal
                class="inline-flex items-center justify-center gap-1.5 rounded-xl px-4 py-2 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-champagne bg-champagne/15 font-semibold text-charcoal hover:bg-champagne/25 cursor-pointer transition"
            >
                <svg class="h-4 w-4 sm:h-3.5 sm:w-3.5 text-amber-700 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M19 5 5 19"/>
                    <circle cx="6.5" cy="6.5" r="2.5"/>
                    <circle cx="17.5" cy="17.5" r="2.5"/>
                </svg>
                <span>Diskon Massal</span>
            </button>

            <button
                type="button"
                @click="bukaModalTambah()"
                data-buka-modal-tambah-tema
                class="inline-flex items-center justify-center gap-1.5 rounded-xl px-4 py-2 text-sm sm:rounded-lg sm:px-3.5 sm:py-1.5 sm:text-xs bg-sage font-semibold text-white hover:bg-sage/90 cursor-pointer transition text-center"
            >
                <span>+ Tambah Tema Baru</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-6">
        @foreach ($daftarTema as $tema)
            @php
                $infoKategori = $tema->infoKategori();
                $payloadTema = json_encode([
                    'id' => $tema->id,
                    'nama_tema' => $tema->nama_tema,
                    'slug' => $tema->slug,
                    'kategori' => $tema->kategoriKode(),
                    'lokasi_view' => $tema->lokasi_view,
                    'harga' => $tema->hargaAsliNominal(),
                    'diskon_tipe' => $tema->diskonTipe() ?? '',
                    'diskon_nilai' => $tema->diskonNilai(),
                    'aktif' => (bool) $tema->aktif,
                    'gambar_url' => $tema->urlGambarPratinjau() ?? '',
                ], JSON_UNESCAPED_UNICODE);
            @endphp
            <div class="rounded-2xl bg-white overflow-hidden shadow-sm ring-1 ring-champagne/20 flex flex-col">
                <div class="aspect-[4/3] bg-ivory relative overflow-hidden">
                    @if ($tema->urlGambarPratinjau())
                        <img src="{{ $tema->urlGambarPratinjau() }}" alt="{{ $tema->nama_tema }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-sage/10 text-sage font-serif text-xl">
                            {{ $tema->nama_tema }}
                        </div>
                    @endif
                    <span class="absolute top-3 left-3 rounded-full px-3 py-1 text-xs font-semibold {{ $infoKategori['badge_class'] }}">
                        {{ $infoKategori['label'] }}
                    </span>
                    <span class="absolute top-3 right-3 rounded-full px-3 py-1 text-xs font-semibold {{ $tema->aktif ? 'bg-sage text-white' : 'bg-charcoal/80 text-white' }}">
                        {{ $tema->aktif ? 'Aktif' : 'Nonaktif' }}
                    </span>
                    @if ($tema->adaDiskon())
                        <span class="absolute bottom-3 left-3 rounded-full bg-rose-600 px-3 py-1 text-xs font-bold text-white shadow-sm">
                            {{ $tema->labelBadgeDiskon() }}
                        </span>
                    @endif
                </div>

                <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex items-start justify-between gap-2">
                            <p class="text-xs font-semibold text-charcoal/60">{{ $infoKategori['ringkasan'] }}</p>
                            <div class="text-right leading-tight">
                                @if ($tema->adaDiskon())
                                    <span class="block text-[11px] text-charcoal/45 line-through">{{ $tema->hargaAsliFormatted() }}</span>
                                    <span class="text-sm font-bold text-rose-600">{{ $tema->hargaFormatted() }}</span>
                                @else
                                    <span class="text-sm font-bold text-charcoal">{{ $tema->hargaFormatted() }}</span>
                                @endif
                            </div>
                        </div>
                        <h2 class="mt-1 font-serif text-2xl font-bold text-charcoal">{{ $tema->nama_tema }}</h2>
                        <p class="mt-1 text-xs font-mono text-charcoal/60">Slug: {{ $tema->slug }}</p>
                        <p class="text-xs font-mono text-charcoal/60">View: {{ $tema->lokasi_view }}</p>
                        <p class="mt-2 text-xs text-charcoal/70">Dipakai oleh {{ $tema->undangan_count }} undangan</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <button
                            type="button"
                            data-buka-modal-edit-tema
                            data-tema="{{ $payloadTema }}"
                            class="flex-1 inline-flex items-center justify-center gap-1.5 rounded-xl px-3.5 py-2 sm:rounded-lg sm:px-2.5 sm:py-1.5 border border-champagne text-xs font-semibold text-charcoal hover:bg-champagne/10 cursor-pointer transition"
                        >
                            <svg class="h-3.5 w-3.5 text-amber-700 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/>
                            </svg>
                            <span>Edit Tema</span>
                        </button>
                        <form
                            action="{{ route('admin.tema.destroy', $tema) }}"
                            method="POST"
                            data-swal-title="Hapus Tema?"
                            data-swal-confirm="Yakin ingin menghapus tema {{ $tema->nama_tema }}?"
                            data-swal-icon="warning"
                            data-swal-confirm-button="Ya, Hapus"
                            data-swal-confirm-color="#DC2626"
                            data-swal-loading-title="Menghapus Tema..."
                            data-swal-loading-text="Sedang menghapus data tema dari katalog..."
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-xl px-3.5 py-2 sm:rounded-lg sm:px-2.5 sm:py-1.5 border border-red-200 text-xs font-semibold text-red-700 hover:bg-red-50 cursor-pointer">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Modal Form Tambah & Edit Katalog Tema --}}
    <div
        x-show="modalTerbuka"
        x-cloak
        x-transition.opacity.duration.150ms
        @click.self="tutupModal()"
        role="dialog"
        aria-modal="true"
        aria-labelledby="judul-modal-tema"
        class="fixed inset-0 z-50 flex items-center justify-center bg-charcoal/60 backdrop-blur-xs p-4 overflow-y-auto"
    >
        <div class="w-full max-w-3xl lg:max-w-4xl rounded-2xl bg-white px-5 pt-5 pb-4 sm:px-6 sm:pt-5 sm:pb-4 shadow-2xl ring-1 ring-champagne/25 my-8">
            <div class="flex items-start justify-between gap-4 pb-5 border-b border-champagne/20">
                <div>
                    <h2 id="judul-modal-tema" class="font-serif text-2xl sm:text-3xl font-bold text-charcoal" x-text="modeEdit ? 'Edit Tema Katalog' : 'Tambah Tema Baru'"></h2>
                    <p class="text-xs sm:text-sm text-charcoal/65 mt-1" x-text="modeEdit ? 'Perbarui desain thumbnail, kategori, harga, diskon katalog, view Blade, atau status aktif tema.' : 'Lengkapi informasi tema baru beserta gambar pratinjau untuk katalog SesiTemu.'"></p>
                </div>

                <button
                    type="button"
                    @click="tutupModal()"
                    aria-label="Tutup modal"
                    class="rounded-lg p-1.5 text-charcoal/55 hover:bg-ivory hover:text-charcoal cursor-pointer transition"
                >
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form
                :action="actionForm()"
                method="POST"
                enctype="multipart/form-data"
                class="mt-6"
                data-swal-loading
                :data-swal-loading-title="modeEdit ? 'Memperbarui Tema...' : 'Menyimpan Tema Baru...'"
                data-swal-loading-text="Sedang mengunggah gambar pratinjau &amp; menyimpan konfigurasi tema..."
            >
                @csrf
                <template x-if="modeEdit">
                    <input type="hidden" name="_method" value="PUT">
                </template>
                <input type="hidden" name="_modal_mode" :value="modeEdit ? 'edit' : 'create'">
                <input type="hidden" name="_edit_id" :value="editId ?? ''">

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    {{-- Kolom Kiri: Dropzone Gambar Pratinjau Modern --}}
                    <div class="lg:col-span-5 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="block text-xs font-semibold text-charcoal/80">Gambar Pratinjau (WebP Otomatis)</span>
                            <template x-if="previewObjectUrl">
                                <button
                                    type="button"
                                    @click="resetFilePreview()"
                                    class="text-[11px] font-semibold text-red-600 hover:underline cursor-pointer"
                                >
                                    Reset Pilihan
                                </button>
                            </template>
                        </div>

                        <label
                            for="modal_gambar_pratinjau"
                            @dragover.prevent="sedangSeretFile = true"
                            @dragleave.prevent="sedangSeretFile = false"
                            @drop.prevent="jatuhkanGambar($event)"
                            :class="sedangSeretFile ? 'border-sage bg-sage/10 ring-2 ring-sage/25' : 'border-champagne/45 bg-ivory/70 hover:border-champagne hover:bg-champagne/5'"
                            class="group relative block aspect-[4/3] w-full overflow-hidden rounded-2xl border-2 border-dashed cursor-pointer transition"
                        >
                            <input
                                id="modal_gambar_pratinjau"
                                x-ref="inputGambar"
                                name="gambar_pratinjau"
                                type="file"
                                accept="image/jpeg,image/png,image/webp"
                                @change="pilihGambar($event)"
                                class="sr-only"
                            >

                            <template x-if="urlPratinjauSaatIni()">
                                <div class="relative h-full w-full">
                                    <img
                                        :src="urlPratinjauSaatIni()"
                                        alt="Pratinjau gambar tema"
                                        class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.02]"
                                    >
                                    <div class="absolute inset-0 bg-charcoal/55 opacity-0 group-hover:opacity-100 transition flex flex-col items-center justify-center text-white px-4 text-center">
                                        <svg class="h-7 w-7 text-champagne mb-1.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                            <polyline points="17 8 12 3 7 8"/>
                                            <line x1="12" x2="12" y1="3" y2="15"/>
                                        </svg>
                                        <span class="text-xs font-semibold">Klik atau tarik gambar baru ke sini</span>
                                        <span class="text-[11px] text-ivory/75 mt-0.5">JPG, PNG, WebP • Maks 5 MB</span>
                                    </div>
                                </div>
                            </template>

                            <template x-if="!urlPratinjauSaatIni()">
                                <div class="h-full w-full flex flex-col items-center justify-center px-5 text-center">
                                    <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-champagne/15 text-amber-700 mb-3 group-hover:scale-105 transition">
                                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <rect width="18" height="18" x="3" y="3" rx="2" ry="2"/>
                                            <circle cx="9" cy="9" r="2"/>
                                            <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                                        </svg>
                                    </span>
                                    <p class="text-xs font-semibold text-charcoal">
                                        Tarik &amp; lepas thumbnail tema ke sini
                                    </p>
                                    <p class="mt-1 text-[11px] text-charcoal/60">
                                        atau <span class="font-semibold text-sage underline">klik untuk memilih berkas</span>
                                    </p>
                                    <p class="mt-2 rounded-full bg-white px-2.5 py-0.5 text-[10px] font-medium text-charcoal/65 ring-1 ring-charcoal/10">
                                        JPG, PNG, WebP • Maks 5 MB
                                    </p>
                                </div>
                            </template>
                        </label>

                        <template x-if="namaFileDipilih">
                            <div class="flex items-center justify-between gap-2 rounded-xl bg-sage/10 border border-sage/25 px-3 py-2 text-xs text-sage">
                                <span class="font-medium truncate" x-text="namaFileDipilih"></span>
                                <span class="font-mono text-[11px] shrink-0" x-text="ukuranFileDipilih"></span>
                            </div>
                        </template>

                        {{-- Ringkasan Estimasi Harga Jual Akhir --}}
                        <div class="rounded-xl bg-ivory/80 border border-champagne/25 p-3.5 text-xs space-y-1">
                            <div class="flex items-center justify-between text-charcoal/70">
                                <span>Harga Jual Katalog:</span>
                                <strong class="text-sm text-charcoal" x-text="formatRupiah(hargaAkhirEstimasi())"></strong>
                            </div>
                            <div class="flex items-center justify-between text-charcoal/65">
                                <span>Terima Beres:</span>
                                <span class="font-semibold text-sage" x-text="formatRupiah(hargaAkhirEstimasi() + biayaTerimaBeres)"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Pengaturan Metadata, Kategori, Harga, & Diskon --}}
                    <div class="lg:col-span-7 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="modal_nama_tema" class="block text-xs font-semibold text-charcoal/80 mb-1">Nama Tema</label>
                                <input
                                    id="modal_nama_tema"
                                    name="nama_tema"
                                    type="text"
                                    x-model="form.nama_tema"
                                    required
                                    placeholder="Contoh: Royal Ivory"
                                    class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60 focus:border-champagne focus:bg-white focus:outline-none"
                                >
                            </div>

                            <div>
                                <label for="modal_slug" class="block text-xs font-semibold text-charcoal/80 mb-1">Slug Tema</label>
                                <input
                                    id="modal_slug"
                                    name="slug"
                                    type="text"
                                    x-model="form.slug"
                                    placeholder="Kosongkan agar otomatis dari nama"
                                    class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60 font-mono focus:border-champagne focus:bg-white focus:outline-none"
                                >
                            </div>

                            <div>
                                <label for="modal_kategori" class="block text-xs font-semibold text-charcoal/80 mb-1">Kategori</label>
                                <select
                                    id="modal_kategori"
                                    name="kategori"
                                    x-model="form.kategori"
                                    class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60 focus:border-champagne focus:bg-white focus:outline-none"
                                >
                                    @foreach (\App\Models\Tema::KATEGORI_TERSEDIA as $val => $label)
                                        <option value="{{ $val }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="modal_harga" class="block text-xs font-semibold text-charcoal/80 mb-1">Harga Normal (Rp)</label>
                                <input
                                    id="modal_harga"
                                    name="harga"
                                    type="number"
                                    min="0"
                                    step="1000"
                                    x-model="form.harga"
                                    required
                                    class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60 font-semibold focus:border-champagne focus:bg-white focus:outline-none"
                                >
                            </div>

                            <div class="sm:col-span-2">
                                <label for="modal_lokasi_view" class="block text-xs font-semibold text-charcoal/80 mb-1">Template View Blade</label>
                                <select
                                    id="modal_lokasi_view"
                                    name="lokasi_view"
                                    x-model="form.lokasi_view"
                                    required
                                    class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60 focus:border-champagne focus:bg-white focus:outline-none"
                                >
                                    @foreach ($daftarLokasiView as $viewDot => $viewLabel)
                                        <option value="{{ $viewDot }}">{{ $viewLabel }}</option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-[11px] text-charcoal/55">Otomatis membaca file Blade di <code class="font-mono">resources/views/tema/</code>.</p>
                            </div>
                        </div>

                        {{-- Pengaturan Diskon Tema (Opsional) --}}
                        <div class="rounded-xl border border-champagne/25 bg-ivory/50 p-4 space-y-3">
                            <p class="text-xs font-bold text-charcoal">Diskon Tema (Opsional — Tampil sebagai Harga Coret di Beranda)</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label for="modal_diskon_tipe" class="block text-[11px] font-semibold text-charcoal/70 mb-1">Tipe Diskon</label>
                                    <select
                                        id="modal_diskon_tipe"
                                        name="diskon_tipe"
                                        x-model="form.diskon_tipe"
                                        class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-white focus:border-champagne focus:outline-none"
                                    >
                                        <option value="">Tanpa Diskon</option>
                                        <option value="persen">Persentase (%)</option>
                                        <option value="nominal">Potongan Nominal (Rp)</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="modal_diskon_nilai" class="block text-[11px] font-semibold text-charcoal/70 mb-1">Nilai Diskon</label>
                                    <input
                                        id="modal_diskon_nilai"
                                        name="diskon_nilai"
                                        type="number"
                                        min="0"
                                        x-model="form.diskon_nilai"
                                        :disabled="!form.diskon_tipe"
                                        placeholder="0"
                                        class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-white disabled:opacity-50 focus:border-champagne focus:outline-none"
                                    >
                                </div>
                            </div>
                        </div>

                        <label class="flex items-center gap-2 rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-2 sm:text-xs border border-champagne/25 bg-ivory/50 font-medium text-charcoal cursor-pointer">
                            <input
                                type="checkbox"
                                name="aktif"
                                value="1"
                                x-model="form.aktif"
                                class="rounded border-charcoal/25 text-sage focus:ring-sage"
                            >
                            <span>Tema Aktif di Katalog Publik</span>
                        </label>
                    </div>
                </div>

                <div class="pt-3.5 mt-5 border-t border-champagne/20 flex items-center justify-end gap-2">
                    <button
                        type="button"
                        @click="tutupModal()"
                        class="inline-flex items-center gap-1.5 rounded-xl px-4 py-2 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 font-semibold text-charcoal hover:bg-ivory cursor-pointer transition"
                    >
                        <svg class="h-4 w-4 sm:h-3.5 sm:w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                        <span>Batal</span>
                    </button>
                    <button
                        type="submit"
                        class="inline-flex items-center gap-1.5 rounded-xl px-4 py-2 text-sm sm:rounded-lg sm:px-3.5 sm:py-1.5 sm:text-xs bg-sage font-semibold text-white hover:bg-sage/90 cursor-pointer transition"
                    >
                        <svg class="h-4 w-4 sm:h-3.5 sm:w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                            <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                            <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                        </svg>
                        <span x-text="modeEdit ? 'Simpan Perubahan' : 'Simpan Tema'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Diskon Massal Katalog Tema --}}
    <div
        x-show="modalDiskonMassalTerbuka"
        x-cloak
        x-transition.opacity.duration.150ms
        @click.self="tutupModal()"
        role="dialog"
        aria-modal="true"
        aria-labelledby="judul-modal-diskon-massal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-charcoal/60 backdrop-blur-xs p-4 overflow-y-auto"
    >
        <div class="w-full max-w-xl rounded-2xl bg-white px-5 pt-5 pb-4 sm:px-6 sm:pt-5 sm:pb-4 shadow-2xl ring-1 ring-champagne/25 my-8">
            <div class="flex items-start justify-between gap-4 pb-4 border-b border-champagne/20">
                <div>
                    <h2 id="judul-modal-diskon-massal" class="font-serif text-2xl font-bold text-charcoal">Terapkan Diskon Massal</h2>
                    <p class="text-xs sm:text-sm text-charcoal/65 mt-1">Pasang harga promo ke seluruh katalog tema atau khusus kategori tertentu secara bersamaan.</p>
                </div>

                <button
                    type="button"
                    @click="tutupModal()"
                    aria-label="Tutup modal diskon massal"
                    class="rounded-lg p-1.5 text-charcoal/55 hover:bg-ivory hover:text-charcoal cursor-pointer transition"
                >
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form
                action="{{ route('admin.tema.diskon-massal') }}"
                method="POST"
                class="mt-5 space-y-4"
                data-swal-loading
                data-swal-loading-title="Menerapkan Diskon Katalog..."
                data-swal-loading-text="Sedang memperbarui harga promo untuk tema terpilih..."
            >
                @csrf

                <div>
                    <label for="massal_target_kategori" class="block text-xs font-semibold text-charcoal/80 mb-1">Target Penerapan</label>
                    <select
                        id="massal_target_kategori"
                        name="target_kategori"
                        class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60 focus:border-champagne focus:outline-none"
                    >
                        <option value="semua" @selected(old('target_kategori') === 'semua')>Semua Tema Katalog ({{ $daftarTema->count() }} tema)</option>
                        @foreach (\App\Models\Tema::KATEGORI_TERSEDIA as $val => $label)
                            <option value="{{ $val }}" @selected(old('target_kategori') === $val)>Hanya Kategori {{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="massal_diskon_tipe" class="block text-xs font-semibold text-charcoal/80 mb-1">Tipe Diskon</label>
                        <select
                            id="massal_diskon_tipe"
                            name="diskon_tipe"
                            class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60 focus:border-champagne focus:outline-none"
                        >
                            <option value="persen" @selected(old('diskon_tipe', 'persen') === 'persen')>Persentase (%)</option>
                            <option value="nominal" @selected(old('diskon_tipe') === 'nominal')>Potongan Nominal (Rp)</option>
                        </select>
                    </div>

                    <div>
                        <label for="massal_diskon_nilai" class="block text-xs font-semibold text-charcoal/80 mb-1">Nilai Diskon</label>
                        <input
                            id="massal_diskon_nilai"
                            name="diskon_nilai"
                            type="number"
                            min="1"
                            required
                            value="{{ old('diskon_nilai', 20) }}"
                            placeholder="Contoh: 20 atau 25000"
                            class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60 focus:border-champagne focus:outline-none"
                        >
                    </div>
                </div>

                <p class="text-xs text-charcoal/60 bg-ivory/70 rounded-xl px-3.5 py-2.5 border border-champagne/15">
                    Harga setelah diskon otomatis ditampilkan sebagai harga coret di Beranda, Dashboard Client, serta dihitung ke order/transaksi baru.
                </p>

                <div class="pt-3.5 border-t border-champagne/20 flex items-center justify-end gap-2">
                    <button
                        type="button"
                        @click="tutupModal()"
                        class="inline-flex items-center gap-1.5 rounded-xl px-4 py-2 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 font-semibold text-charcoal hover:bg-ivory cursor-pointer transition"
                    >
                        <svg class="h-4 w-4 sm:h-3.5 sm:w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                        <span>Batal</span>
                    </button>
                    <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl px-4 py-2 text-sm sm:rounded-lg sm:px-3.5 sm:py-1.5 sm:text-xs bg-sage font-semibold text-white hover:bg-sage/90 cursor-pointer transition">
                        <svg class="h-4 w-4 sm:h-3.5 sm:w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M20 6 9 17l-5-5" />
                        </svg>
                        <span>Terapkan Diskon</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
