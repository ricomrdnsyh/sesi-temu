@php
    $varian = $varian ?? 'lingkaran';
    $label = $label ?? 'Unggah Foto';
    $petunjuk = $petunjuk ?? 'JPG, PNG, atau WebP • Maks. 5 MB';
    $urlAwal = $urlAwal ?? null;
    $inisial = $inisial ?? 'S&T';
    $hapusNama = $hapusNama ?? null;
    $hapusLabel = $hapusLabel ?? 'Hapus foto';
    $idInput = 'input-'.str_replace(['[', ']', '_'], '-', $name);
@endphp

<div
    x-data="{
        urlAwal: @js($urlAwal),
        pratinjauUrl: null,
        namaFile: '',
        ukuranFile: '',
        sedangTarik: false,
        ditandaiHapus: false,
        pesanGalat: '',
        get gambarTampil() {
            if (this.pratinjauUrl) {
                return this.pratinjauUrl;
            }
            if (this.ditandaiHapus) {
                return null;
            }
            return this.urlAwal;
        },
        formatUkuran(bytes) {
            if (!bytes) return '';
            if (bytes < 1024 * 1024) {
                return Math.max(1, Math.round(bytes / 1024)) + ' KB';
            }
            return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
        },
        terimaFile(file) {
            this.pesanGalat = '';
            if (!file) return;

            if (!file.type || !file.type.startsWith('image/')) {
                this.pesanGalat = 'Format berkas harus berupa gambar (JPG, PNG, atau WebP).';
                return;
            }

            if (file.size > 5 * 1024 * 1024) {
                this.pesanGalat = 'Ukuran foto melebihi batas maksimal 5 MB.';
                return;
            }

            if (this.pratinjauUrl) {
                URL.revokeObjectURL(this.pratinjauUrl);
            }

            this.pratinjauUrl = URL.createObjectURL(file);
            this.namaFile = file.name;
            this.ukuranFile = this.formatUkuran(file.size);
            this.ditandaiHapus = false;
            this.$dispatch('foto-live-berubah', { nama: @js($name), url: this.pratinjauUrl });
        },
        saatPilih(event) {
            const file = event.target.files?.[0];
            this.terimaFile(file);
            if (this.pesanGalat) {
                event.target.value = '';
            }
        },
        saatJatuh(event) {
            this.sedangTarik = false;
            const file = event.dataTransfer?.files?.[0];
            if (!file) return;

            const dt = new DataTransfer();
            dt.items.add(file);
            this.$refs.berkas.files = dt.files;
            this.terimaFile(file);
            if (this.pesanGalat) {
                this.$refs.berkas.value = '';
            }
        },
        batalkanPilihan() {
            if (this.pratinjauUrl) {
                URL.revokeObjectURL(this.pratinjauUrl);
            }
            this.pratinjauUrl = null;
            this.namaFile = '';
            this.ukuranFile = '';
            this.pesanGalat = '';
            if (this.$refs.berkas) {
                this.$refs.berkas.value = '';
            }
            this.$dispatch('foto-live-berubah', { nama: @js($name), url: '' });
        }
    }"
    class="{{ $varian === 'galeri' ? 'w-full h-full flex flex-col gap-2' : 'space-y-2.5' }}"
>
    <input
        id="{{ $idInput }}"
        x-ref="berkas"
        type="file"
        name="{{ $name }}"
        accept="image/jpeg,image/png,image/webp,image/*"
        @change="saatPilih($event)"
        class="sr-only"
    >

    @if ($varian === 'sampul')
        <div class="flex flex-col md:flex-row gap-5 items-stretch">
            {{-- Mockup Live Pratinjau Gerbang Undangan --}}
            <div class="mx-auto md:mx-0 w-40 sm:w-44 aspect-[3/4] rounded-2xl overflow-hidden relative shadow-lg ring-1 ring-champagne/40 bg-gradient-to-b from-charcoal via-[#28352F] to-charcoal shrink-0 select-none">
                <template x-if="gambarTampil">
                    <img
                        :src="gambarTampil"
                        alt="Pratinjau Sampul Undangan"
                        class="absolute inset-0 w-full h-full object-cover object-top"
                    >
                </template>
                <div
                    class="absolute inset-0 transition-opacity"
                    :class="gambarTampil ? 'bg-gradient-to-b from-black/75 via-black/15 to-black/85' : 'bg-[radial-gradient(circle_at_center,rgba(191,161,95,0.22),transparent_70%)]'"
                ></div>

                <div class="relative z-10 h-full flex flex-col justify-between p-3 text-center text-white">
                    <div class="pt-1 space-y-0.5">
                        <p class="text-[8px] uppercase tracking-[0.25em] text-[#F3E5AB]">The Wedding Of</p>
                        <p class="font-logo text-sm font-bold leading-tight drop-shadow">
                            <span x-text="namaPriaLive || @js($undangan->nama_panggilan_pria)"></span>
                            <span class="text-[#F3E5AB]">&amp;</span>
                            <span x-text="namaWanitaLive || @js($undangan->nama_panggilan_wanita)"></span>
                        </p>
                    </div>

                    <template x-if="!gambarTampil">
                        <div class="my-auto px-2 py-2.5 rounded-xl border border-dashed border-[#F3E5AB]/40 bg-white/5 backdrop-blur-xs space-y-1">
                            <svg class="mx-auto h-5 w-5 text-[#F3E5AB]/85" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                <rect x="3" y="3" width="18" height="18" rx="3"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <path d="m21 15-5-5L5 21"/>
                            </svg>
                            <p class="text-[9px] leading-tight text-white/80">
                                <span x-show="!ditandaiHapus">Mengikuti foto galeri / tema</span>
                                <span x-show="ditandaiHapus" x-cloak class="text-rose-200">Foto sampul akan dihapus</span>
                            </p>
                        </div>
                    </template>

                    <div class="rounded-xl bg-black/45 backdrop-blur-xs border border-[#F3E5AB]/30 px-2 py-1.5 space-y-1">
                        <p class="text-[7px] uppercase tracking-[0.2em] text-white/75">Kepada Yth. Tamu</p>
                        <span class="inline-block rounded-full bg-sage px-2.5 py-0.5 text-[8px] font-bold uppercase tracking-wider text-white">
                            Buka Undangan
                        </span>
                    </div>
                </div>

                <span
                    x-show="pratinjauUrl"
                    x-cloak
                    class="absolute top-2 right-2 z-20 rounded-full bg-sage px-2 py-0.5 text-[9px] font-bold text-white shadow"
                >
                    Baru
                </span>
            </div>

            {{-- Zona Dropzone Sampul --}}
            <div class="flex-1 flex flex-col justify-between gap-3">
                <label
                    for="{{ $idInput }}"
                    @dragover.prevent="sedangTarik = true"
                    @dragleave.prevent="sedangTarik = false"
                    @drop.prevent="saatJatuh($event)"
                    :class="sedangTarik ? 'border-sage bg-sage/10 scale-[1.01]' : 'border-champagne/45 bg-white/85 hover:border-sage/60 hover:bg-white'"
                    class="flex-1 rounded-2xl border-2 border-dashed p-5 flex flex-col items-center justify-center text-center cursor-pointer transition-all"
                >
                    <div class="w-11 h-11 rounded-2xl bg-sage/10 text-sage flex items-center justify-center mb-2.5">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="17 8 12 3 7 8"/>
                            <line x1="12" y1="3" x2="12" y2="15"/>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-charcoal">
                        <span x-text="gambarTampil ? 'Ganti Foto Sampul' : 'Pilih atau Seret Foto Sampul'"></span>
                    </p>
                    <p class="mt-1 text-xs text-charcoal/60">{{ $petunjuk }}</p>
                    <span class="mt-3 inline-flex items-center gap-1.5 rounded-xl bg-sage/10 px-3.5 py-1.5 text-xs font-semibold text-sage">
                        Jelajahi Galeri Perangkat
                    </span>
                </label>

                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div x-show="namaFile" x-cloak class="inline-flex items-center gap-2 rounded-xl bg-sage/10 border border-sage/25 px-3 py-1.5 text-xs text-sage">
                        <span class="font-semibold truncate max-w-[190px]" x-text="namaFile"></span>
                        <span class="text-sage/75" x-text="'(' + ukuranFile + ')'"></span>
                        <button type="button" @click="batalkanPilihan()" class="font-bold text-rose-700 hover:underline cursor-pointer">Batal</button>
                    </div>

                    @if ($hapusNama && $urlAwal)
                        <label class="inline-flex items-center gap-2 rounded-xl border border-rose-200 bg-rose-50/70 px-3 py-1.5 text-xs text-rose-700 font-medium cursor-pointer hover:bg-rose-50 transition">
                            <input type="checkbox" name="{{ $hapusNama }}" value="1" x-model="ditandaiHapus" class="rounded border-rose-300 text-rose-600 focus:ring-rose-500">
                            <span>{{ $hapusLabel }}</span>
                        </label>
                    @endif
                </div>
            </div>
        </div>

    @elseif ($varian === 'galeri')
        <div class="w-full h-full flex flex-col">
            <label
                for="{{ $idInput }}"
                @dragover.prevent="sedangTarik = true"
                @dragleave.prevent="sedangTarik = false"
                @drop.prevent="saatJatuh($event)"
                :class="sedangTarik ? 'border-sage bg-sage/10 scale-[1.01]' : (gambarTampil ? 'border-sage/55 bg-charcoal' : 'border-champagne/50 bg-ivory/75 hover:border-sage/60 hover:bg-ivory')"
                class="relative overflow-hidden flex-1 w-full min-h-[212px] rounded-2xl border-2 border-dashed flex flex-col items-center justify-center text-center cursor-pointer transition-all group"
            >
                <template x-if="gambarTampil">
                    <div class="absolute inset-0">
                        <img :src="gambarTampil" alt="Pratinjau Foto Galeri" class="w-full h-full object-cover object-center transition duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/15 to-black/35"></div>

                        <div class="absolute top-3 left-3 right-3 flex items-center justify-between gap-2">
                            <span class="rounded-full bg-sage px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white shadow">
                                Pratinjau Siap
                            </span>
                            <button
                                type="button"
                                @click.prevent.stop="batalkanPilihan()"
                                class="rounded-full bg-black/60 backdrop-blur-xs px-3 py-1 text-[11px] font-semibold text-white hover:bg-rose-600 transition cursor-pointer"
                            >
                                Batalkan
                            </button>
                        </div>

                        <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between gap-3 text-left text-white">
                            <div class="min-w-0">
                                <p class="text-xs font-semibold truncate" x-text="namaFile"></p>
                                <p class="text-[11px] text-white/75" x-text="ukuranFile + ' • Otomatis WebP'"></p>
                            </div>
                            <span class="rounded-xl bg-white/90 px-3 py-1.5 text-xs font-semibold text-charcoal shrink-0 group-hover:bg-white transition">
                                Ganti Foto
                            </span>
                        </div>
                    </div>
                </template>

                <template x-if="!gambarTampil">
                    <div class="p-6 flex flex-col items-center justify-center space-y-2.5">
                        <div class="w-12 h-12 rounded-2xl bg-white shadow-xs ring-1 ring-champagne/30 text-sage flex items-center justify-center group-hover:scale-105 transition">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="3"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <path d="m21 15-5-5L5 21"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-charcoal" x-text="@js($label)"></p>
                            <p class="text-xs text-charcoal/60 mt-0.5" x-text="@js($petunjuk)"></p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 rounded-xl bg-white px-4 py-1.5 text-xs font-semibold text-sage ring-1 ring-sage/25 shadow-2xs group-hover:bg-sage group-hover:text-white transition">
                            Pilih dari Perangkat
                        </span>
                    </div>
                </template>
            </label>
        </div>

    @else
        {{-- Varian Lingkaran: Mempelai Pria & Wanita --}}
        <div class="flex flex-col sm:flex-row items-center gap-4">
            <label for="{{ $idInput }}" class="relative group cursor-pointer shrink-0" title="Klik untuk ganti {{ $label }}">
                <div class="w-24 h-24 rounded-full overflow-hidden ring-2 ring-champagne/50 shadow-md bg-gradient-to-br from-champagne/25 via-white to-sage/15 flex items-center justify-center">
                    <template x-if="gambarTampil">
                        <img :src="gambarTampil" alt="{{ $label }}" class="w-full h-full object-cover transition duration-300 group-hover:scale-105">
                    </template>
                    <template x-if="!gambarTampil">
                        <span class="font-logo text-3xl font-bold text-champagne">{{ $inisial }}</span>
                    </template>
                </div>

                <span class="absolute -bottom-1 -right-1 w-8 h-8 rounded-full bg-sage text-white shadow-md ring-2 ring-white flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/>
                        <circle cx="12" cy="13" r="3"/>
                    </svg>
                </span>

                <span
                    x-show="pratinjauUrl"
                    x-cloak
                    class="absolute -top-1 -left-1 rounded-full bg-sage px-2 py-0.5 text-[9px] font-bold text-white shadow"
                >
                    Baru
                </span>
            </label>

            <div class="w-full flex-1 space-y-2">
                <label
                    for="{{ $idInput }}"
                    @dragover.prevent="sedangTarik = true"
                    @dragleave.prevent="sedangTarik = false"
                    @drop.prevent="saatJatuh($event)"
                    :class="sedangTarik ? 'border-sage bg-sage/10' : 'border-champagne/45 bg-white hover:border-sage/60'"
                    class="block rounded-2xl border-2 border-dashed px-4 py-3 cursor-pointer transition-all"
                >
                    <div class="flex items-center justify-between gap-2">
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-charcoal truncate" x-text="namaFile ? namaFile : (gambarTampil ? @js('Ganti '.$label) : @js('Unggah '.$label))"></p>
                            <p class="text-[11px] text-charcoal/55 mt-0.5" x-text="namaFile ? ('Pratinjau siap • ' + ukuranFile) : @js($petunjuk)"></p>
                        </div>
                        <span class="rounded-lg bg-sage/10 px-2.5 py-1 text-[11px] font-semibold text-sage shrink-0">
                            <span x-text="gambarTampil ? 'Ubah' : 'Pilih'"></span>
                        </span>
                    </div>
                </label>

                <div x-show="pratinjauUrl" x-cloak class="flex items-center justify-between text-[11px] text-sage font-medium px-1">
                    <span>Pratinjau aktif — klik Simpan di bawah untuk menyimpan.</span>
                    <button type="button" @click="batalkanPilihan()" class="text-rose-700 font-semibold hover:underline cursor-pointer">Batal pilih</button>
                </div>
            </div>
        </div>
    @endif

    <p x-show="pesanGalat" x-cloak x-text="pesanGalat" class="text-xs font-medium text-rose-600"></p>
</div>
