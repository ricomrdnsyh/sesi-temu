@php
    $varian = $varian ?? 'lingkaran';
    $label = $label ?? 'Unggah Foto';
    $petunjuk = $petunjuk ?? 'JPG, PNG, atau WebP • Maks. 5 MB';
    $urlAwal = $urlAwal ?? null;
    $inisial = $inisial ?? 'S&T';
    $hapusNama = $hapusNama ?? null;
    $hapusLabel = $hapusLabel ?? 'Hapus foto';
    $idInput = 'input-'.str_replace(['[', ']', '_'], '-', $name);
    $teksPilih = $teksPilih ?? ($name === 'foto_sampul' ? 'Pilih atau Seret Foto Sampul' : ($varian === 'lingkaran' ? 'Unggah '.$label : 'Pilih atau Seret '.$label));
    $teksGanti = $teksGanti ?? ($name === 'foto_sampul' ? 'Ganti Foto Sampul' : 'Ganti '.$label);
    $altGambar = $altGambar ?? ($name === 'foto_sampul' ? 'Pratinjau Sampul Undangan' : 'Pratinjau '.$label);

    $cropKunci = $cropKunci ?? match ($name) {
        'foto' => 'foto_galeri',
        default => $name,
    };
    $metaRasioBawaan = isset($rasioFotoTema[$cropKunci]) && is_array($rasioFotoTema[$cropKunci])
        ? $rasioFotoTema[$cropKunci]
        : ['rasio' => ($varian === 'galeri' ? 1.6 : 0.75), 'label' => '3:4', 'bentuk' => 'rect'];
    $cropRasio = (float) ($cropRasio ?? $metaRasioBawaan['rasio']);
    $cropLabel = (string) ($cropLabel ?? $metaRasioBawaan['label']);
    $cropBentuk = (string) ($cropBentuk ?? $metaRasioBawaan['bentuk']);
    $maksTinggiPratinjau = match ($varian) {
        'lingkaran' => 320,
        'galeri' => 380,
        default => 440,
    };
@endphp

<div
    x-data="{
        urlAwal: @js($urlAwal),
        pratinjauUrl: null,
        namaFile: '',
        ukuranFile: '',
        rasioGambar: null,
        sedangTarik: false,
        ditandaiHapus: false,
        pesanGalat: '',
        cropRasio: @js($cropRasio),
        cropLabel: @js($cropLabel),
        cropBentuk: @js($cropBentuk),
        get gambarTampil() {
            if (this.pratinjauUrl) {
                return this.pratinjauUrl;
            }
            if (this.ditandaiHapus) {
                return null;
            }
            return this.urlAwal;
        },
        saatGambarMuat(event) {
            const img = event?.target;
            if (img?.naturalWidth && img?.naturalHeight) {
                this.rasioGambar = img.naturalWidth / img.naturalHeight;
            }
        },
        gayaBingkaiPratinjau(maksTinggi = @js($maksTinggiPratinjau)) {
            if (!this.gambarTampil || !this.rasioGambar) {
                return '';
            }
            const lebarIdeal = Math.max(220, Math.round(maksTinggi * this.rasioGambar));
            return `max-width: min(100%, ${lebarIdeal}px);`;
        },
        formatUkuran(bytes) {
            if (!bytes) return '';
            if (bytes < 1024 * 1024) {
                return Math.max(1, Math.round(bytes / 1024)) + ' KB';
            }
            return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
        },
        setBerkasInput(file) {
            if (!this.$refs.berkas) return;
            if (!file) {
                this.$refs.berkas.value = '';
                return;
            }
            const dt = new DataTransfer();
            dt.items.add(file);
            this.$refs.berkas.files = dt.files;
        },
        terapkanFileHasil(fileHasil, fileAsli = null) {
            this.pesanGalat = '';
            if (!fileHasil) return;
            if (fileHasil.size > 5 * 1024 * 1024) {
                this.pesanGalat = 'Ukuran hasil foto melebihi batas maksimal 5 MB.';
                return;
            }

            this.setBerkasInput(fileHasil);
            this.$el._fileHasilTerakhir = fileHasil;
            if (fileAsli) {
                this.$el._fileAsliCrop = fileAsli;
            }

            if (this.pratinjauUrl) {
                URL.revokeObjectURL(this.pratinjauUrl);
            }

            this.pratinjauUrl = URL.createObjectURL(fileHasil);
            this.namaFile = fileHasil.name;
            this.ukuranFile = this.formatUkuran(fileHasil.size);
            this.rasioGambar = null;
            this.ditandaiHapus = false;
            if (this.$refs.hapusCheckbox) {
                this.$refs.hapusCheckbox.checked = false;
            }
            this.$dispatch('foto-live-berubah', { nama: @js($name), url: this.pratinjauUrl });
        },
        async mulaiPilihAtauCrop(file) {
            this.pesanGalat = '';
            if (!file) return;

            const validator = window.SesiTemuValidasiBerkas;
            if (validator?.validasi) {
                const cek = await validator.validasi(file, 'gambar', {
                    maksMb: 15,
                    pesanUkuran: 'Ukuran foto terlalu besar (maks. 15 MB sebelum dipotong).',
                });
                if (!cek.valid) {
                    this.pesanGalat = cek.pesan;
                    this.setBerkasInput(this.$el._fileHasilTerakhir || null);
                    return;
                }
            } else {
                if (!file.type || !['image/jpeg', 'image/png', 'image/webp'].includes(file.type.toLowerCase())) {
                    this.pesanGalat = 'Format berkas harus berupa gambar (JPG, PNG, atau WebP).';
                    this.setBerkasInput(this.$el._fileHasilTerakhir || null);
                    return;
                }
                if (file.size > 15 * 1024 * 1024) {
                    this.pesanGalat = 'Ukuran foto terlalu besar (maks. 15 MB sebelum dipotong).';
                    this.setBerkasInput(this.$el._fileHasilTerakhir || null);
                    return;
                }
            }

            this.$dispatch('buka-cropper-foto', {
                file,
                judul: @js('Atur Potongan '.$label),
                rasio: this.cropRasio,
                labelRasio: this.cropLabel,
                bentuk: this.cropBentuk,
                namaAsli: file.name,
                onSelesai: (fileHasil) => {
                    this.terapkanFileHasil(fileHasil, file);
                },
                onBatal: () => {
                    this.setBerkasInput(this.$el._fileHasilTerakhir || null);
                },
            });
        },
        potongUlang() {
            if (!this.gambarTampil) return;
            const fileAsli = this.$el._fileAsliCrop || null;
            this.$dispatch('buka-cropper-foto', {
                file: fileAsli,
                srcUrl: fileAsli ? '' : this.gambarTampil,
                judul: @js('Atur Potongan '.$label),
                rasio: this.cropRasio,
                labelRasio: this.cropLabel,
                bentuk: this.cropBentuk,
                namaAsli: fileAsli?.name || this.namaFile || @js($name.'.jpg'),
                onSelesai: (fileHasil) => {
                    this.terapkanFileHasil(fileHasil, fileAsli);
                },
            });
        },
        tandaiHapus() {
            this.ditandaiHapus = true;
            this.rasioGambar = null;
            if (this.$refs.hapusCheckbox) {
                this.$refs.hapusCheckbox.checked = true;
                this.$refs.hapusCheckbox.dispatchEvent(new Event('change', { bubbles: true }));
            }
        },
        batalHapus() {
            this.ditandaiHapus = false;
            this.rasioGambar = null;
            if (this.$refs.hapusCheckbox) {
                this.$refs.hapusCheckbox.checked = false;
                this.$refs.hapusCheckbox.dispatchEvent(new Event('change', { bubbles: true }));
            }
        },
        saatPilih(event) {
            const file = event.target.files?.[0];
            if (!file) return;
            this.mulaiPilihAtauCrop(file);
        },
        saatJatuh(event) {
            this.sedangTarik = false;
            const file = event.dataTransfer?.files?.[0];
            if (!file) return;
            this.mulaiPilihAtauCrop(file);
        },
        batalkanPilihan() {
            if (this.pratinjauUrl) {
                URL.revokeObjectURL(this.pratinjauUrl);
            }
            this.pratinjauUrl = null;
            this.namaFile = '';
            this.ukuranFile = '';
            this.rasioGambar = null;
            this.pesanGalat = '';
            this.$el._fileAsliCrop = null;
            this.$el._fileHasilTerakhir = null;
            this.setBerkasInput(null);
            this.$dispatch('foto-live-berubah', { nama: @js($name), url: '' });
        },
        sinkronTersimpan(fotoMap) {
            if (!fotoMap || !Object.prototype.hasOwnProperty.call(fotoMap, @js($name))) {
                return;
            }
            this.urlAwal = fotoMap[@js($name)] || null;
            if (this.pratinjauUrl) {
                URL.revokeObjectURL(this.pratinjauUrl);
            }
            this.pratinjauUrl = null;
            this.namaFile = '';
            this.ukuranFile = '';
            this.rasioGambar = null;
            this.ditandaiHapus = false;
            this.pesanGalat = '';
            this.$el._fileAsliCrop = null;
            this.$el._fileHasilTerakhir = null;
            this.setBerkasInput(null);
            if (this.$refs.hapusCheckbox) {
                this.$refs.hapusCheckbox.checked = false;
            }
        }
    }"
    @editor-tersimpan.window="sinkronTersimpan($event.detail?.foto)"
    class="{{ $varian === 'galeri' ? 'w-full h-full flex flex-col gap-2' : 'space-y-2.5' }}"
>
    <input
        id="{{ $idInput }}"
        x-ref="berkas"
        type="file"
        name="{{ $name }}"
        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
        @change="saatPilih($event)"
        class="sr-only"
    >

    @if ($hapusNama)
        <input
            type="checkbox"
            x-ref="hapusCheckbox"
            name="{{ $hapusNama }}"
            value="1"
            x-model="ditandaiHapus"
            class="sr-only"
        >
    @endif

    @if ($varian === 'galeri')
        <div
            @dragover.prevent="sedangTarik = true"
            @dragleave.prevent="if (!$el.contains($event.relatedTarget)) sedangTarik = false"
            @drop.prevent="saatJatuh($event)"
            :style="gayaBingkaiPratinjau(380)"
            :class="sedangTarik
                ? 'border-dashed border-sage bg-sage/10 scale-[1.01]'
                : (gambarTampil
                    ? 'border-solid border-sage/55 bg-charcoal shadow-sm'
                    : 'border-dashed border-champagne/50 bg-ivory/75 hover:border-sage/60 hover:bg-ivory')"
            class="relative overflow-hidden w-full mx-auto rounded-2xl border-2 transition-all group"
        >
            <label
                for="{{ $idInput }}"
                :class="gambarTampil ? 'block w-full' : 'min-h-[212px] p-6 flex flex-col items-center justify-center text-center'"
                class="relative w-full cursor-pointer select-none"
            >
                <template x-if="gambarTampil">
                    <div class="relative w-full min-h-[168px] flex items-center justify-center bg-charcoal">
                        <img
                            :src="gambarTampil"
                            @load="saatGambarMuat($event)"
                            x-init="$nextTick(() => { if ($el.complete && $el.naturalWidth) saatGambarMuat({ target: $el }); })"
                            alt="Pratinjau Foto Galeri"
                            class="block w-full h-auto max-h-[380px] object-contain transition duration-500 group-hover:scale-[1.02]"
                        >
                        <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-black/55 via-transparent to-black/80"></div>

                        <div class="absolute top-3 left-3 pr-36 flex items-center gap-1.5">
                            <span class="rounded-full bg-sage px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white shadow">
                                Pratinjau Siap
                            </span>
                        </div>

                        <div class="absolute bottom-3 inset-x-3 flex items-end justify-between gap-2.5 text-left text-white">
                            <div class="min-w-0">
                                <p class="text-xs font-semibold truncate" x-text="namaFile"></p>
                                <p class="text-[11px] text-white/80 truncate" x-text="ukuranFile + ' • Otomatis WebP'"></p>
                            </div>
                            <span class="rounded-xl bg-white/95 group-hover:bg-white px-3 py-1.5 text-xs font-semibold text-charcoal shrink-0 transition">
                                Ganti
                            </span>
                        </div>
                    </div>
                </template>

                <template x-if="!gambarTampil">
                    <div class="flex flex-col items-center justify-center space-y-2.5">
                        <div class="w-12 h-12 rounded-2xl bg-white shadow-xs ring-1 ring-champagne/30 text-sage flex items-center justify-center group-hover:scale-105 transition">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="3" y="3" width="18" height="18" rx="3"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <path d="m21 15-5-5L5 21"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-charcoal">{{ $label }}</p>
                            <p class="text-xs text-charcoal/60 mt-0.5">{{ $petunjuk }}</p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 rounded-xl bg-white px-4 py-1.5 text-xs font-semibold text-sage ring-1 ring-sage/25 shadow-2xs group-hover:bg-sage group-hover:text-white transition">
                            Pilih dari Perangkat
                        </span>
                    </div>
                </template>
            </label>

            {{-- Tombol aksi melayang di luar <label> --}}
            <div x-show="gambarTampil" x-cloak class="absolute top-3 right-3 z-20 flex items-center gap-1.5">
                <button
                    type="button"
                    @click="potongUlang()"
                    class="inline-flex items-center gap-1 rounded-full bg-black/55 hover:bg-sage backdrop-blur-xs px-2.5 py-1 text-[11px] font-semibold text-white ring-1 ring-white/15 transition cursor-pointer"
                    title="Atur ulang potongan foto"
                >
                    <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M6 2v14a2 2 0 0 0 2 2h14"/>
                        <path d="M18 22V8a2 2 0 0 0-2-2H2"/>
                    </svg>
                    <span>Potong</span>
                </button>
                <button
                    type="button"
                    @click="batalkanPilihan()"
                    class="rounded-full bg-black/55 hover:bg-rose-600 backdrop-blur-xs px-2.5 py-1 text-[11px] font-semibold text-white ring-1 ring-white/15 transition cursor-pointer"
                >
                    Batalkan
                </button>
            </div>

            <div
                x-show="sedangTarik"
                x-cloak
                class="pointer-events-none absolute inset-0 z-30 bg-sage/85 backdrop-blur-xs flex flex-col items-center justify-center gap-1.5 text-white"
            >
                <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="17 8 12 3 7 8"/>
                    <line x1="12" y1="3" x2="12" y2="15"/>
                </svg>
                <p class="text-sm font-bold">Lepaskan foto untuk potong</p>
            </div>
        </div>

    @else
        {{-- Varian Terpadu: Sampul, Pembuka, Penutup, serta Mempelai Pria & Wanita --}}
        <div
            @dragover.prevent="sedangTarik = true"
            @dragleave.prevent="if (!$el.contains($event.relatedTarget)) sedangTarik = false"
            @drop.prevent="saatJatuh($event)"
            :style="gayaBingkaiPratinjau({{ $maksTinggiPratinjau }})"
            :class="sedangTarik
                ? 'border-dashed border-sage bg-sage/10 scale-[1.01]'
                : (gambarTampil
                    ? 'border-solid border-champagne/35 bg-charcoal shadow-sm hover:border-sage/70'
                    : (ditandaiHapus
                        ? 'border-dashed border-rose-300 bg-rose-50/50 hover:border-sage/60'
                        : 'border-dashed border-champagne/50 bg-ivory/70 hover:border-sage/60 hover:bg-ivory'))"
            class="relative overflow-hidden w-full mx-auto rounded-2xl border-2 transition-all group"
        >
            <label
                for="{{ $idInput }}"
                :class="gambarTampil ? 'block w-full' : '{{ $varian === 'lingkaran' ? 'min-h-[164px] p-4' : 'min-h-[192px] p-5' }} flex flex-col items-center justify-center text-center'"
                class="relative w-full cursor-pointer select-none"
            >
                <template x-if="gambarTampil">
                    <div class="relative w-full min-h-[168px] flex items-center justify-center bg-charcoal">
                        <img
                            :src="gambarTampil"
                            @load="saatGambarMuat($event)"
                            x-init="$nextTick(() => { if ($el.complete && $el.naturalWidth) saatGambarMuat({ target: $el }); })"
                            alt="{{ $altGambar }}"
                            class="block w-full h-auto {{ $varian === 'lingkaran' ? 'max-h-[320px]' : 'max-h-[440px]' }} object-contain transition duration-500 group-hover:scale-[1.02]"
                        >
                        <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-black/55 via-transparent to-black/80"></div>

                        <div class="absolute top-3 left-3 pr-36 flex items-center gap-1.5">
                            <span
                                x-show="pratinjauUrl"
                                x-cloak
                                class="inline-flex items-center rounded-full bg-sage px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-white shadow-sm"
                            >
                                Pratinjau Baru
                            </span>
                            <span
                                x-show="!pratinjauUrl"
                                class="inline-flex items-center rounded-full bg-black/45 backdrop-blur-xs px-2.5 py-1 text-[10px] font-semibold text-white/95 ring-1 ring-white/15"
                            >
                                {{ $label }}
                            </span>
                        </div>

                        <div class="absolute bottom-3 inset-x-3 flex items-end justify-between gap-2.5 text-left text-white">
                            <div class="min-w-0">
                                <p class="text-xs font-semibold truncate drop-shadow-xs" x-text="namaFile || @js($teksGanti)"></p>
                                <p class="mt-0.5 text-[11px] text-white/80 truncate" x-text="namaFile ? (ukuranFile + ' • Klik Simpan di bawah') : @js($petunjuk)"></p>
                            </div>
                            <span class="inline-flex items-center gap-1.5 rounded-xl bg-white/95 group-hover:bg-white px-3 py-1.5 text-xs font-semibold text-charcoal shadow-sm shrink-0 transition">
                                <svg class="h-3.5 w-3.5 text-sage" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="17 8 12 3 7 8"/>
                                    <line x1="12" y1="3" x2="12" y2="15"/>
                                </svg>
                                <span>Ganti</span>
                            </span>
                        </div>
                    </div>
                </template>

                <template x-if="!gambarTampil">
                    <div class="flex flex-col items-center justify-center space-y-2.5">
                        @if ($varian === 'lingkaran')
                            <div class="relative">
                                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-champagne/25 via-white to-sage/15 ring-2 ring-champagne/45 shadow-xs flex items-center justify-center group-hover:scale-105 transition">
                                    <span class="font-logo text-xl font-bold text-champagne">{{ $inisial }}</span>
                                </div>
                                <span class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-sage text-white ring-2 ring-white flex items-center justify-center shadow-xs">
                                    <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/>
                                        <circle cx="12" cy="13" r="3"/>
                                    </svg>
                                </span>
                            </div>
                        @else
                            <div class="w-11 h-11 rounded-2xl bg-white shadow-2xs ring-1 ring-champagne/30 text-sage flex items-center justify-center group-hover:scale-105 transition">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="17 8 12 3 7 8"/>
                                    <line x1="12" y1="3" x2="12" y2="15"/>
                                </svg>
                            </div>
                        @endif

                        <div class="space-y-0.5">
                            <p class="text-sm font-semibold text-charcoal">
                                <span x-show="!ditandaiHapus">{{ $teksPilih }}</span>
                                <span x-show="ditandaiHapus" x-cloak class="text-rose-700">Foto akan dihapus saat disimpan</span>
                            </p>
                            <p class="text-xs text-charcoal/60 max-w-xs">{{ $petunjuk }}</p>
                        </div>

                        <span class="inline-flex items-center gap-1.5 rounded-xl bg-white px-3.5 py-1.5 text-xs font-semibold text-sage ring-1 ring-sage/25 shadow-2xs group-hover:bg-sage group-hover:text-white transition">
                            Jelajahi Galeri Perangkat
                        </span>
                    </div>
                </template>
            </label>

            {{-- Tombol aksi melayang (di luar <label> agar klik tidak membuka dialog berkas) --}}
            <div x-show="gambarTampil" x-cloak class="absolute top-3 right-3 z-20 flex items-center gap-1.5">
                <button
                    type="button"
                    @click="potongUlang()"
                    class="inline-flex items-center gap-1 rounded-full bg-black/55 hover:bg-sage backdrop-blur-xs px-2.5 py-1 text-[11px] font-semibold text-white ring-1 ring-white/15 transition cursor-pointer"
                    title="Atur ulang potongan foto"
                >
                    <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M6 2v14a2 2 0 0 0 2 2h14"/>
                        <path d="M18 22V8a2 2 0 0 0-2-2H2"/>
                    </svg>
                    <span>Potong</span>
                </button>

                <button
                    type="button"
                    x-show="pratinjauUrl"
                    x-cloak
                    @click="batalkanPilihan()"
                    class="inline-flex items-center gap-1 rounded-full bg-black/55 hover:bg-rose-600 backdrop-blur-xs px-2.5 py-1 text-[11px] font-semibold text-white ring-1 ring-white/15 transition cursor-pointer"
                >
                    Batalkan
                </button>

                @if ($hapusNama)
                    <button
                        type="button"
                        x-show="!pratinjauUrl && urlAwal"
                        x-cloak
                        @click="tandaiHapus()"
                        title="{{ $hapusLabel }}"
                        class="inline-flex items-center gap-1 rounded-full bg-black/55 hover:bg-rose-600 backdrop-blur-xs px-2.5 py-1 text-[11px] font-semibold text-white ring-1 ring-white/15 transition cursor-pointer"
                    >
                        <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M3 6h18"/>
                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                        </svg>
                        <span>Hapus</span>
                    </button>
                @endif
            </div>

            {{-- Umpan balik seret berkas --}}
            <div
                x-show="sedangTarik"
                x-cloak
                class="pointer-events-none absolute inset-0 z-30 bg-sage/85 backdrop-blur-xs flex flex-col items-center justify-center gap-1.5 text-white"
            >
                <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="17 8 12 3 7 8"/>
                    <line x1="12" y1="3" x2="12" y2="15"/>
                </svg>
                <p class="text-sm font-bold">Lepaskan foto untuk potong</p>
            </div>
        </div>

        @if ($hapusNama)
            <div
                x-show="ditandaiHapus && !pratinjauUrl && urlAwal"
                x-cloak
                class="flex items-center justify-between gap-2 rounded-xl border border-rose-200 bg-rose-50/80 px-3 py-2 text-xs text-rose-700"
            >
                <span class="font-medium">{{ $hapusLabel }} aktif &mdash; klik Simpan Semua untuk menerapkan.</span>
                <button
                    type="button"
                    @click="batalHapus()"
                    class="font-bold text-rose-800 hover:underline shrink-0 cursor-pointer"
                >
                    Urungkan
                </button>
            </div>
        @endif
    @endif

    <p x-show="pesanGalat" x-cloak x-text="pesanGalat" class="text-xs font-medium text-rose-600"></p>
</div>
