@extends('admin.kerangka')

@section('judul', 'Katalog Tema — Admin SesiTemu')

@section('isi_admin')
@php
    $adaGalat = $errors->any();
    $modeAwalEdit = $adaGalat && old('_modal_mode') === 'edit';
    $biayaTerimaBeres = \App\Support\PengaturanSesiTemu::biayaTerimaBeres();

    $modalInit = [
        'modalTerbuka' => $adaGalat,
        'modeEdit' => $modeAwalEdit,
        'editId' => $adaGalat ? old('_edit_id') : null,
        'form' => [
            'nama_tema' => (string) ($adaGalat ? old('nama_tema', '') : ''),
            'slug' => (string) ($adaGalat ? old('slug', '') : ''),
            'kategori' => (string) ($adaGalat ? old('kategori', 'modern') : 'modern'),
            'lokasi_view' => (string) ($adaGalat ? old('lokasi_view', 'tema.rustic-floral.index') : 'tema.rustic-floral.index'),
            'tier' => (string) ($adaGalat ? old('tier', 'basic') : 'basic'),
            'harga' => (int) ($adaGalat ? old('harga', \App\Models\Tema::HARGA_BAWAAN_TIER['basic']) : \App\Models\Tema::HARGA_BAWAAN_TIER['basic']),
            'aktif' => $adaGalat ? (bool) old('aktif', false) : true,
            'gambar_url' => '',
        ],
        'hargaBawaan' => \App\Models\Tema::HARGA_BAWAAN_TIER,
        'storeUrl' => route('admin.tema.store'),
        'updateBaseUrl' => url('/admin/tema'),
    ];
@endphp

<div
    x-data="{
        modalTerbuka: false,
        modeEdit: false,
        editId: null,
        sedangSeretFile: false,
        previewObjectUrl: null,
        namaFileDipilih: '',
        ukuranFileDipilih: '',
        form: {
            nama_tema: '',
            slug: '',
            kategori: 'modern',
            lokasi_view: 'tema.rustic-floral.index',
            tier: 'basic',
            harga: 59000,
            aktif: true,
            gambar_url: '',
        },
        hargaBawaan: {},
        storeUrl: '',
        updateBaseUrl: '',
        init() {
            const initEl = document.getElementById('tema-modal-init');
            if (initEl) {
                const data = JSON.parse(initEl.textContent);
                this.modalTerbuka = Boolean(data.modalTerbuka);
                this.modeEdit = Boolean(data.modeEdit);
                this.editId = data.editId ?? null;
                this.form = { ...this.form, ...(data.form ?? {}) };
                this.hargaBawaan = data.hargaBawaan ?? {};
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
                kategori: 'modern',
                lokasi_view: 'tema.rustic-floral.index',
                tier: 'basic',
                harga: this.hargaBawaan.basic ?? 59000,
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
                kategori: tema.kategori || 'modern',
                lokasi_view: tema.lokasi_view || 'tema.rustic-floral.index',
                tier: tema.tier || 'basic',
                harga: Number(tema.harga ?? 59000),
                aktif: Boolean(tema.aktif),
                gambar_url: tema.gambar_url || '',
            };
            this.modalTerbuka = true;
        },
        tutupModal() {
            this.modalTerbuka = false;
        },
        terapkanHargaSaran(tier) {
            if (this.hargaBawaan[tier] !== undefined) {
                this.form.harga = this.hargaBawaan[tier];
            }
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
    @keydown.escape.window="tutupModal()"
    class="space-y-6"
>
    <script type="application/json" id="tema-modal-init">{!! json_encode($modalInit, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!}</script>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-serif text-3xl font-bold text-charcoal">Manajemen Katalog Tema</h1>
            <p class="text-sm text-charcoal/70 mt-1">Kelola desain tema undangan, view Blade, thumbnail, dan status aktif.</p>
        </div>
        <button
            type="button"
            @click="bukaModalTambah()"
            data-buka-modal-tambah-tema
            class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-sage px-5 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 cursor-pointer transition text-center"
        >
            <span>+ Tambah Tema Baru</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-6">
        @foreach ($daftarTema as $tema)
            @php
                $infoTier = $tema->infoTier();
                $payloadTema = json_encode([
                    'id' => $tema->id,
                    'nama_tema' => $tema->nama_tema,
                    'slug' => $tema->slug,
                    'kategori' => $tema->kategori,
                    'lokasi_view' => $tema->lokasi_view,
                    'tier' => $tema->tierKode(),
                    'harga' => $tema->hargaNominal(),
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
                    <span class="absolute top-3 left-3 rounded-full px-3 py-1 text-xs font-semibold {{ $infoTier['badge_class'] }}">
                        {{ $infoTier['label'] }}
                    </span>
                    <span class="absolute top-3 right-3 rounded-full px-3 py-1 text-xs font-semibold {{ $tema->aktif ? 'bg-sage text-white' : 'bg-charcoal/80 text-white' }}">
                        {{ $tema->aktif ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>

                <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex items-center justify-between gap-2">
                            <p class="text-xs font-semibold uppercase tracking-wider text-champagne">{{ $tema->kategoriLabel() }}</p>
                            <span class="text-sm font-bold text-charcoal">{{ $tema->hargaFormatted() }}</span>
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
                            class="flex-1 inline-flex items-center justify-center gap-1.5 rounded-xl border border-champagne px-3.5 py-2 text-xs font-semibold text-charcoal hover:bg-champagne/10 cursor-pointer transition"
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
                            <button type="submit" class="rounded-xl border border-red-200 px-3.5 py-2 text-xs font-semibold text-red-700 hover:bg-red-50 cursor-pointer">
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
        <div class="w-full max-w-3xl lg:max-w-4xl rounded-2xl bg-white p-6 sm:p-8 shadow-2xl ring-1 ring-champagne/25 my-8">
            <div class="flex items-start justify-between gap-4 pb-5 border-b border-champagne/20">
                <div>
                    <h2 id="judul-modal-tema" class="font-serif text-2xl sm:text-3xl font-bold text-charcoal" x-text="modeEdit ? 'Edit Tema Katalog' : 'Tambah Tema Baru'"></h2>
                    <p class="text-xs sm:text-sm text-charcoal/65 mt-1" x-text="modeEdit ? 'Perbarui desain thumbnail, harga tier, view Blade, atau status aktif tema.' : 'Lengkapi informasi tema baru beserta gambar pratinjau untuk katalog SesiTemu.'"></p>
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
                    </div>

                    {{-- Kolom Kanan: Pengaturan Metadata, Tier, & Harga --}}
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
                                    class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2.5 text-sm focus:border-champagne focus:bg-white focus:outline-none"
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
                                    class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2.5 text-sm font-mono focus:border-champagne focus:bg-white focus:outline-none"
                                >
                            </div>

                            <div>
                                <label for="modal_kategori" class="block text-xs font-semibold text-charcoal/80 mb-1">Kategori</label>
                                <select
                                    id="modal_kategori"
                                    name="kategori"
                                    x-model="form.kategori"
                                    class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2.5 text-sm focus:border-champagne focus:bg-white focus:outline-none"
                                >
                                    @foreach (\App\Models\Tema::KATEGORI_TERSEDIA as $val => $label)
                                        <option value="{{ $val }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="modal_lokasi_view" class="block text-xs font-semibold text-charcoal/80 mb-1">Lokasi View Blade</label>
                                <input
                                    id="modal_lokasi_view"
                                    name="lokasi_view"
                                    type="text"
                                    x-model="form.lokasi_view"
                                    required
                                    class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2.5 text-sm font-mono focus:border-champagne focus:bg-white focus:outline-none"
                                >
                            </div>

                            <div>
                                <label for="modal_tier" class="block text-xs font-semibold text-charcoal/80 mb-1">Tingkatan Kualitas (Tier)</label>
                                <select
                                    id="modal_tier"
                                    name="tier"
                                    x-model="form.tier"
                                    required
                                    class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2.5 text-sm focus:border-champagne focus:bg-white focus:outline-none"
                                >
                                    @foreach (\App\Models\Tema::TIER_TERSEDIA as $val => $label)
                                        <option value="{{ $val }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <label for="modal_harga" class="block text-xs font-semibold text-charcoal/80">Harga Tema (Rp)</label>
                                    <button
                                        type="button"
                                        @click="terapkanHargaSaran(form.tier)"
                                        class="text-[11px] font-semibold text-sage hover:underline cursor-pointer"
                                    >
                                        Pakai saran tier
                                    </button>
                                </div>
                                <input
                                    id="modal_harga"
                                    name="harga"
                                    type="number"
                                    min="0"
                                    step="1000"
                                    x-model="form.harga"
                                    required
                                    class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2.5 text-sm font-semibold focus:border-champagne focus:bg-white focus:outline-none"
                                >
                            </div>
                        </div>

                        <p class="text-xs text-charcoal/60 bg-ivory/70 rounded-xl px-3.5 py-2.5 border border-champagne/15">
                            Paket Terima Beres otomatis menjadi harga tema + <strong>{{ \App\Models\Tema::formatRupiah($biayaTerimaBeres) }}</strong> jasa input admin.
                        </p>

                        <label class="flex items-center gap-2.5 rounded-xl border border-champagne/25 bg-ivory/50 px-4 py-3 text-sm font-medium text-charcoal cursor-pointer">
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

                <div class="pt-6 mt-6 border-t border-champagne/20 flex items-center justify-end gap-3">
                    <button
                        type="button"
                        @click="tutupModal()"
                        class="rounded-xl border border-charcoal/15 px-5 py-2.5 text-sm font-semibold text-charcoal hover:bg-ivory cursor-pointer transition"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="rounded-xl bg-sage px-6 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 cursor-pointer transition"
                        x-text="modeEdit ? 'Simpan Perubahan' : 'Simpan Tema'"
                    ></button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
