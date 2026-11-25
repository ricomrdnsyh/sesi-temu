@php
    $jumlahFotoHitungMundur = count($undangan->daftarFotoHitungMundurKhususDashboard());
    $teksAcaraDikustom = filled($teksKustom['judul_hitung_mundur'] ?? '')
        || filled($teksKustom['pengantar_hitung_mundur'] ?? '')
        || filled($teksKustom['judul_acara'] ?? '');
    $adaDressCodeAtauLive = filled($undangan->dressCodeCatatan())
        || ! empty($undangan->dressCodeWarna())
        || ! empty($pengaturan['live_streaming']['aktif']);
    $judulCeritaDikustom = filled($teksKustom['judul_cerita'] ?? '');
    $judulGaleriDikustom = filled($teksKustom['judul_galeri'] ?? '');
@endphp

{{-- ACCORDION 3: Hitung Mundur, Acara & Info (Seksi 4, 5 & 6 Undangan) --}}
<div
    :class="tab === 'acara' ? 'border-sage/45 ring-1 ring-sage/15 shadow-xs' : 'border-champagne/30 hover:border-champagne/60'"
    class="rounded-2xl border bg-white overflow-hidden transition"
>
    <button
        type="button"
        data-mobile-tab="acara"
        @click="toggleBagian('acara')"
        class="w-full px-4 py-3.5 flex items-center justify-between gap-3 text-left cursor-pointer hover:bg-ivory/50 transition"
    >
        <div class="flex items-center gap-2.5 min-w-0">
            <svg
                :class="tab === 'acara' ? 'rotate-90 text-sage' : 'text-charcoal/45'"
                class="h-4 w-4 shrink-0 transition-transform duration-200"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
            >
                <path d="m9 18 6-6-6-6"/>
            </svg>
            <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-sage/12 text-[11px] font-bold text-sage shrink-0">3</span>
            <span class="font-sans text-sm font-semibold text-charcoal truncate">Hitung Mundur &amp; Acara</span>
        </div>
        <span class="rounded-full bg-ivory px-2 py-0.5 font-sans tabular-nums text-[11px] font-semibold text-sage ring-1 ring-champagne/25 shrink-0">
            {{ $undangan->daftarAcara->count() }} Acara
        </span>
    </button>

    <section x-show="tab === 'acara'" x-cloak class="px-4 pb-5 pt-3 border-t border-champagne/20 space-y-4">
        {{-- 3A. Hitung Mundur (Save The Date) — Tampil Pertama di Undangan --}}
        <div
            :class="sakelarFitur.hitung_mundur ? 'bg-sage/[0.06] border-sage/35' : 'bg-ivory/65 border-charcoal/10 opacity-85'"
            class="flex items-center justify-between gap-3 rounded-2xl border px-3.5 py-2.5 transition"
        >
            <div class="min-w-0">
                <span class="block text-xs font-bold text-charcoal">Tampilkan Hitung Mundur</span>
                <span class="block text-[11px] text-charcoal/55 mt-0.5">Timer otomatis ke jadwal acara pertama.</span>
            </div>
            <button
                type="button"
                role="switch"
                data-toggle-fitur="hitung_mundur"
                :aria-checked="sakelarFitur.hitung_mundur ? 'true' : 'false'"
                :disabled="fiturMenyimpan.hitung_mundur"
                @click.stop="toggleFitur('hitung_mundur')"
                :class="sakelarFitur.hitung_mundur ? 'bg-sage' : 'bg-charcoal/25'"
                class="relative inline-flex h-6 w-11 shrink-0 items-center rounded-full p-0.5 transition-colors cursor-pointer disabled:opacity-60"
                aria-label="Tampilkan Hitung Mundur"
            >
                <span
                    :class="sakelarFitur.hitung_mundur ? 'translate-x-5' : 'translate-x-0'"
                    class="pointer-events-none block h-5 w-5 rounded-full bg-white shadow-xs transition-transform"
                ></span>
            </button>
        </div>

        {{-- Drawer Lipat: Foto Slideshow Hitung Mundur (1-4 Foto di atas Save The Date) --}}
        <div
            x-show="sakelarFitur.hitung_mundur"
            x-cloak
            x-data="{ buka: false }"
            class="rounded-2xl border border-champagne/30 bg-ivory/50 overflow-hidden"
        >
            <button
                type="button"
                @click="buka = !buka"
                class="w-full px-3.5 py-2.5 flex items-center justify-between gap-2 text-left hover:bg-ivory transition cursor-pointer"
            >
                <span class="flex items-center gap-2 min-w-0">
                    <svg class="h-3.5 w-3.5 text-sage shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect width="18" height="18" x="3" y="3" rx="2" ry="2"/>
                        <circle cx="9" cy="9" r="2"/>
                        <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                    </svg>
                    <span class="text-xs font-semibold text-charcoal truncate">Foto Slideshow Hitung Mundur</span>
                </span>
                <span class="flex items-center gap-1.5 shrink-0">
                    <span
                        :class="daftarFotoHitungMundur.length > 0 ? 'bg-sage/12 text-sage' : 'bg-white text-charcoal/50 ring-1 ring-champagne/30'"
                        class="rounded-full px-2 py-0.5 text-[10px] font-semibold tabular-nums"
                        x-text="daftarFotoHitungMundur.length > 0 ? daftarFotoHitungMundur.length + '/' + maksFotoHitungMundur + ' Foto' : 'Opsional'"
                    >{{ $jumlahFotoHitungMundur > 0 ? $jumlahFotoHitungMundur.'/'.\App\Models\Undangan::MAKS_FOTO_HITUNG_MUNDUR.' Foto' : 'Opsional' }}</span>
                    <svg :class="buka ? 'rotate-180 text-sage' : 'text-charcoal/45'" class="h-3.5 w-3.5 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m6 9 6 6 6-6"/>
                    </svg>
                </span>
            </button>
            <div x-show="buka" x-cloak class="px-3.5 pb-4 pt-3 border-t border-champagne/20 bg-white/80 space-y-3">
                <input
                    id="input-foto-hitung-mundur"
                    type="file"
                    name="foto_hitung_mundur[]"
                    accept="image/jpeg,image/png,image/webp,image/*"
                    multiple
                    @change="pilihFotoHitungMundur($event)"
                    class="sr-only"
                >

                <div class="flex items-start justify-between gap-2">
                    <p class="text-[11px] leading-relaxed text-charcoal/60">
                        Unggah 1&ndash;{{ \App\Models\Undangan::MAKS_FOTO_HITUNG_MUNDUR }} foto agar berganti otomatis di atas <strong>Save The Date</strong>. Rasio template: <span class="font-semibold text-charcoal/80">{{ $rasioFotoTema['foto_hitung_mundur']['label'] }}</span>.
                    </p>
                </div>

                {{-- Keadaan Kosong: Area Unggah Penuh --}}
                <label
                    x-show="daftarFotoHitungMundur.length === 0"
                    for="input-foto-hitung-mundur"
                    @dragover.prevent="sedangTarikHitungMundur = true"
                    @dragleave.prevent="sedangTarikHitungMundur = false"
                    @drop.prevent="jatuhFotoHitungMundur($event)"
                    :class="sedangTarikHitungMundur ? 'border-sage bg-sage/[0.06] ring-4 ring-sage/10' : 'border-champagne/60 bg-ivory/50 hover:border-sage/60 hover:bg-ivory'"
                    class="flex flex-col items-center justify-center gap-2 rounded-2xl border-2 border-dashed px-4 py-6 text-center cursor-pointer transition select-none"
                >
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-sage/10 text-sage">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="17 8 12 3 7 8"/>
                            <line x1="12" x2="12" y1="3" y2="15"/>
                        </svg>
                    </span>
                    <div>
                        <p class="text-xs font-semibold text-charcoal">Pilih atau Seret Foto Slideshow</p>
                        <p class="mt-0.5 text-[11px] text-charcoal/55">Bisa pilih sekaligus hingga {{ \App\Models\Undangan::MAKS_FOTO_HITUNG_MUNDUR }} foto • JPG, PNG, WebP</p>
                    </div>
                    <span class="rounded-lg bg-sage/10 px-3 py-1.5 text-[11px] font-semibold text-sage">Pilih Foto</span>
                </label>

                {{-- Grid Foto Slideshow + Tombol Tambah Foto --}}
                <div
                    x-show="daftarFotoHitungMundur.length > 0"
                    x-cloak
                    class="grid grid-cols-2 gap-2.5"
                >
                    <template x-for="(item, idx) in daftarFotoHitungMundur" :key="item.uid">
                        <div
                            class="relative overflow-hidden rounded-xl border border-champagne/40 bg-charcoal shadow-2xs group"
                            style="aspect-ratio: {{ $rasioFotoTema['foto_hitung_mundur']['rasio'] }};"
                        >
                            <img
                                :src="item.url"
                                :alt="'Foto Hitung Mundur #' + (idx + 1)"
                                class="block h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]"
                            >
                            <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-black/60 via-transparent to-black/70"></div>

                            {{-- Nomor Slide & Urutan --}}
                            <div class="absolute top-2 left-2 z-10 flex items-center gap-1">
                                <span class="rounded-full bg-black/60 backdrop-blur-xs px-2 py-0.5 text-[10px] font-bold text-white ring-1 ring-white/15 tabular-nums" x-text="'#' + (idx + 1)"></span>
                                <button
                                    type="button"
                                    x-show="idx > 0"
                                    @click="pindahFotoHitungMundur(idx, -1)"
                                    title="Geser ke kiri"
                                    aria-label="Geser foto ke kiri"
                                    class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-black/55 hover:bg-sage text-[10px] font-bold text-white ring-1 ring-white/15 transition cursor-pointer"
                                >&larr;</button>
                                <button
                                    type="button"
                                    x-show="idx < daftarFotoHitungMundur.length - 1"
                                    @click="pindahFotoHitungMundur(idx, 1)"
                                    title="Geser ke kanan"
                                    aria-label="Geser foto ke kanan"
                                    class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-black/55 hover:bg-sage text-[10px] font-bold text-white ring-1 ring-white/15 transition cursor-pointer"
                                >&rarr;</button>
                            </div>

                            {{-- Aksi Potong & Hapus --}}
                            <div class="absolute bottom-2 inset-x-2 z-10 flex items-center justify-end gap-1.5">
                                <button
                                    type="button"
                                    @click="potongFotoHitungMundur(idx)"
                                    class="rounded-full bg-black/60 hover:bg-sage backdrop-blur-xs px-2.5 py-1 text-[10px] font-semibold text-white ring-1 ring-white/15 transition cursor-pointer"
                                >Potong</button>
                                <button
                                    type="button"
                                    @click="hapusFotoHitungMundur(idx)"
                                    class="rounded-full bg-black/60 hover:bg-rose-600 backdrop-blur-xs px-2.5 py-1 text-[10px] font-semibold text-white ring-1 ring-white/15 transition cursor-pointer"
                                >Hapus</button>
                            </div>
                        </div>
                    </template>

                    {{-- Kartu Tambah Foto Baru (selama belum mencapai 4 foto) --}}
                    <label
                        x-show="daftarFotoHitungMundur.length < maksFotoHitungMundur"
                        for="input-foto-hitung-mundur"
                        @dragover.prevent="sedangTarikHitungMundur = true"
                        @dragleave.prevent="sedangTarikHitungMundur = false"
                        @drop.prevent="jatuhFotoHitungMundur($event)"
                        :class="sedangTarikHitungMundur ? 'border-sage bg-sage/[0.08] ring-2 ring-sage/20' : 'border-champagne/60 bg-ivory/60 hover:border-sage/60 hover:bg-ivory'"
                        class="flex flex-col items-center justify-center gap-1.5 rounded-xl border-2 border-dashed p-3 text-center cursor-pointer transition select-none"
                        style="aspect-ratio: {{ $rasioFotoTema['foto_hitung_mundur']['rasio'] }};"
                    >
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-sage/10 text-sage text-base font-bold">+</span>
                        <span class="text-[11px] font-semibold text-charcoal">Tambah Foto</span>
                        <span class="text-[10px] text-charcoal/55 tabular-nums" x-text="'Sisa ' + (maksFotoHitungMundur - daftarFotoHitungMundur.length) + ' slot'"></span>
                    </label>
                </div>

                <p x-show="daftarFotoHitungMundur.length >= maksFotoHitungMundur" x-cloak class="text-[11px] text-charcoal/55">
                    Batas {{ \App\Models\Undangan::MAKS_FOTO_HITUNG_MUNDUR }} foto slideshow tercapai. Hapus salah satu foto jika ingin mengganti.
                </p>

                <p x-show="pesanGalatHitungMundur" x-cloak x-text="pesanGalatHitungMundur" class="text-xs font-medium text-rose-600"></p>
            </div>
        </div>

        {{-- Drawer Lipat: Ubah Judul Hitung Mundur, Pengantar & Judul Acara --}}
        <div x-data="{ buka: false }" class="rounded-2xl border border-champagne/30 bg-ivory/50 overflow-hidden">
            <button
                type="button"
                @click="buka = !buka"
                class="w-full px-3.5 py-2.5 flex items-center justify-between gap-2 text-left hover:bg-ivory transition cursor-pointer"
            >
                <span class="flex items-center gap-2 min-w-0">
                    <svg class="h-3.5 w-3.5 text-sage shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                    </svg>
                    <span class="text-xs font-semibold text-charcoal truncate">Ubah Judul Hitung Mundur &amp; Acara</span>
                </span>
                <span class="flex items-center gap-1.5 shrink-0">
                    <span class="rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $teksAcaraDikustom ? 'bg-sage/12 text-sage' : 'bg-white text-charcoal/50 ring-1 ring-champagne/30' }}">
                        {{ $teksAcaraDikustom ? 'Dikustom' : 'Bawaan' }}
                    </span>
                    <svg :class="buka ? 'rotate-180 text-sage' : 'text-charcoal/45'" class="h-3.5 w-3.5 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m6 9 6 6 6-6"/>
                    </svg>
                </span>
            </button>
            <div x-show="buka" x-cloak class="px-3.5 pb-3.5 pt-2.5 border-t border-champagne/20 bg-white/80">
                <div data-bagian-utama="acara_teks" class="space-y-3">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="teks_judul_hitung_mundur" class="block text-xs font-semibold text-charcoal/80">Judul Hitung Mundur</label>
                            <input
                                id="teks_judul_hitung_mundur"
                                type="text"
                                name="teks[judul_hitung_mundur]"
                                value="{{ $nilaiTeksEditor('judul_hitung_mundur') }}"
                                placeholder="{{ $teksBawaanTema['judul_hitung_mundur'] ?: 'Save The Date' }}"
                                class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none"
                            >
                        </div>
                        <div>
                            <label for="teks_judul_acara" class="block text-xs font-semibold text-charcoal/80">Judul Bagian Acara</label>
                            <input
                                id="teks_judul_acara"
                                type="text"
                                name="teks[judul_acara]"
                                value="{{ $nilaiTeksEditor('judul_acara') }}"
                                placeholder="{{ $teksBawaanTema['judul_acara'] ?: 'Rangkaian Acara' }}"
                                class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none"
                            >
                        </div>
                    </div>
                    <div>
                        <label for="teks_pengantar_hitung_mundur" class="block text-xs font-semibold text-charcoal/80">Kalimat Pengantar Acara</label>
                        <textarea
                            id="teks_pengantar_hitung_mundur"
                            name="teks[pengantar_hitung_mundur]"
                            rows="2"
                            placeholder="{{ $teksBawaanTema['pengantar_hitung_mundur'] ?: 'Merupakan kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir...' }}"
                            class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm leading-relaxed focus:border-sage focus:outline-none"
                        >{{ $nilaiTeksEditor('pengantar_hitung_mundur') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3B. Rangkaian Acara (Jadwal Akad, Resepsi, dll.) --}}
        <div x-ref="formAcaraPanel" class="rounded-2xl bg-ivory/65 p-4 ring-1 ring-champagne/20 space-y-3.5">
            <div class="flex items-center justify-between gap-2">
                <h2 class="font-sans text-sm font-bold text-charcoal" x-text="acaraEdit ? ('Edit: ' + acaraEdit.nama_acara) : 'Tambah Jadwal Acara'"></h2>
                <button type="button" x-show="acaraEdit" x-cloak @click="acaraEdit = null" class="rounded-lg border border-champagne/50 bg-white px-2.5 py-1 text-[11px] font-semibold text-charcoal hover:bg-champagne/15 transition cursor-pointer shrink-0">
                    + Batal Edit
                </button>
            </div>

            <form
                action="{{ route('dashboard.acara.simpan', $undangan) }}"
                method="POST"
                class="grid grid-cols-1 gap-3"
                data-swal-loading
                :data-swal-loading-title="acaraEdit ? 'Memperbarui Jadwal Acara...' : 'Menambahkan Jadwal Acara...'"
                data-swal-loading-text="Menyimpan jadwal dan lokasi acara ke undangan..."
            >
                @csrf
                <input type="hidden" name="acara_id" :value="acaraEdit ? acaraEdit.id : ''">

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-charcoal/80">Nama Acara</label>
                    <div class="flex flex-wrap gap-1">
                        @foreach (['Akad Nikah', 'Resepsi', 'Pemberkatan', 'Ngunduh Mantu', 'Walimatul Ursy'] as $presetAcara)
                            <button
                                type="button"
                                @click="$refs.namaAcaraInput.value = @js($presetAcara)"
                                class="rounded-full bg-white px-2.5 py-0.5 text-[11px] font-semibold text-sage ring-1 ring-sage/25 hover:bg-sage hover:text-white transition cursor-pointer"
                            >
                                + {{ $presetAcara }}
                            </button>
                        @endforeach
                    </div>
                    <input
                        x-ref="namaAcaraInput"
                        type="text"
                        name="nama_acara"
                        :value="acaraEdit ? acaraEdit.nama_acara : ''"
                        required
                        placeholder="Akad Nikah / Resepsi"
                        class="w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-sage focus:outline-none"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-charcoal/80">Tanggal Acara</label>
                    <input type="date" name="tanggal_acara" :value="acaraEdit ? acaraEdit.tanggal_acara : ''" required class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-sage focus:outline-none">
                </div>

                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <label class="block text-xs font-semibold text-charcoal/80">Mulai</label>
                        <input type="time" name="waktu_mulai" :value="acaraEdit ? acaraEdit.waktu_mulai : '08:00'" required class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-2.5 py-2 text-sm focus:border-sage focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-charcoal/80">Selesai</label>
                        <input type="time" name="waktu_selesai" :value="acaraEdit ? acaraEdit.waktu_selesai : ''" class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-2.5 py-2 text-sm focus:border-sage focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-charcoal/80">Zona</label>
                        <select name="zona_waktu" :value="acaraEdit ? acaraEdit.zona_waktu : 'WIB'" class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-2 py-2 text-sm">
                            <option value="WIB">WIB</option>
                            <option value="WITA">WITA</option>
                            <option value="WIT">WIT</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-charcoal/80">Nama Tempat / Gedung</label>
                    <input type="text" name="nama_tempat" :value="acaraEdit ? acaraEdit.nama_tempat : ''" required placeholder="Masjid Agung / Hotel..." class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-sage focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-charcoal/80">Alamat Lengkap</label>
                    <textarea name="alamat_lengkap" rows="2" required placeholder="Jl. Raya Merdeka No. 10, Kecamatan, Kota..." x-text="acaraEdit ? acaraEdit.alamat_lengkap : ''" class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-sage focus:outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-charcoal/80">Link Google Maps <span class="font-normal text-charcoal/45">(Opsional)</span></label>
                    <input type="url" name="link_maps" :value="acaraEdit ? acaraEdit.link_maps : ''" placeholder="https://maps.google.com/..." class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-sage focus:outline-none">
                </div>

                <button type="submit" class="w-full rounded-xl bg-sage px-5 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer shadow-xs" x-text="acaraEdit ? 'Perbarui Acara' : '+ Tambah Acara'"></button>
            </form>
        </div>

        {{-- Daftar Kartu Rangkaian Acara --}}
        <div class="space-y-2.5">
            <div class="flex items-center justify-between px-1">
                <h3 class="font-sans text-xs font-bold uppercase tracking-wider text-charcoal/65">
                    Daftar Jadwal Terpasang
                    <span class="ml-1 inline-flex items-center rounded-full bg-sage/10 px-2 py-0.5 font-sans tabular-nums text-[10px] font-bold tracking-normal text-sage">
                        {{ $undangan->daftarAcara->count() }} Acara
                    </span>
                </h3>
            </div>

            <div class="grid grid-cols-1 gap-3">
                @forelse ($undangan->daftarAcara as $idx => $acara)
                    @php
                        $selisihHari = now()->startOfDay()->diffInDays($acara->tanggal_acara->copy()->startOfDay(), false);
                        $badgeHari = match (true) {
                            $selisihHari > 0 => "H-{$selisihHari} Hari",
                            $selisihHari === 0 => 'Hari Ini',
                            default => 'Sudah Lewat',
                        };
                        $bulanSingkat = \Illuminate\Support\Str::upper($acara->tanggal_acara->locale('id')->translatedFormat('M'));
                    @endphp
                    <article
                        :class="acaraEdit?.id === {{ $acara->id }} ? 'ring-2 ring-sage bg-sage/[0.02]' : 'ring-1 ring-champagne/25 bg-white'"
                        class="rounded-2xl p-3.5 shadow-xs space-y-2.5 transition"
                    >
                        <div class="flex items-start gap-3">
                            <div class="w-12 rounded-xl bg-sage text-white text-center overflow-hidden shrink-0 select-none">
                                <div class="bg-black/20 py-0.5 text-[9px] font-bold uppercase">{{ $bulanSingkat }}</div>
                                <div class="pt-1 font-sans tabular-nums text-lg font-bold leading-none">{{ $acara->tanggal_acara->format('d') }}</div>
                                <div class="pb-1 text-[9px] font-semibold text-[#F3E5AB]">{{ $acara->tanggal_acara->format('Y') }}</div>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-champagne">Acara #{{ $idx + 1 }}</span>
                                    <span class="rounded-full px-2 py-0.5 text-[10px] font-bold shrink-0 {{ $selisihHari >= 0 ? 'bg-sage/10 text-sage' : 'bg-charcoal/10 text-charcoal/60' }}">{{ $badgeHari }}</span>
                                </div>
                                <h4 class="font-sans text-sm font-bold text-charcoal truncate mt-0.5">{{ $acara->nama_acara }}</h4>
                                <p class="text-[11px] text-charcoal/65 mt-0.5">
                                    {{ $acara->tanggal_acara->locale('id')->translatedFormat('l, d F Y') }} &middot;
                                    {{ substr($acara->waktu_mulai, 0, 5) }}@if ($acara->waktu_selesai) - {{ substr($acara->waktu_selesai, 0, 5) }}@endif {{ $acara->zona_waktu }}
                                </p>
                                <p class="text-xs font-medium text-charcoal/85 mt-1">{{ $acara->nama_tempat }}</p>
                                <p class="text-[11px] text-charcoal/60 line-clamp-2">{{ $acara->alamat_lengkap }}</p>
                            </div>
                        </div>

                        <div class="pt-2 border-t border-champagne/15 flex items-center justify-between gap-2">
                            <span x-show="acaraEdit?.id === {{ $acara->id }}" x-cloak class="text-[11px] font-bold text-sage">Sedang diedit di atas</span>
                            <span x-show="acaraEdit?.id !== {{ $acara->id }}" class="text-[11px] text-charcoal/45">
                                @if ($acara->link_maps)
                                    <a href="{{ $acara->link_maps }}" target="_blank" rel="noopener" class="text-sage hover:underline font-medium">Buka Google Maps &nearr;</a>
                                @else
                                    Siap tampil
                                @endif
                            </span>

                            <div class="flex items-center gap-1.5">
                                <button
                                    type="button"
                                    @click="acaraEdit = {{ Js::from([
                                        'id' => $acara->id,
                                        'nama_acara' => $acara->nama_acara,
                                        'tanggal_acara' => $acara->tanggal_acara->format('Y-m-d'),
                                        'waktu_mulai' => substr($acara->waktu_mulai, 0, 5),
                                        'waktu_selesai' => $acara->waktu_selesai ? substr($acara->waktu_selesai, 0, 5) : '',
                                        'zona_waktu' => $acara->zona_waktu,
                                        'nama_tempat' => $acara->nama_tempat,
                                        'alamat_lengkap' => $acara->alamat_lengkap,
                                        'link_maps' => $acara->link_maps ?? '',
                                    ]) }}; $refs.formAcaraPanel?.scrollIntoView({ behavior: 'smooth', block: 'start' })"
                                    class="rounded-lg border border-champagne/60 bg-ivory/70 px-2.5 py-1 text-[11px] font-semibold text-charcoal hover:bg-champagne/15 transition cursor-pointer"
                                >
                                    Edit
                                </button>

                                <form
                                    action="{{ route('dashboard.acara.hapus', [$undangan, $acara]) }}"
                                    method="POST"
                                    data-swal-title="Hapus Jadwal Acara?"
                                    data-swal-confirm="Yakin ingin menghapus acara {{ $acara->nama_acara }}?"
                                    data-swal-icon="warning"
                                    data-swal-confirm-button="Ya, Hapus"
                                    data-swal-confirm-color="#DC2626"
                                    data-swal-loading-title="Menghapus Jadwal Acara..."
                                    data-swal-loading-text="Menghapus jadwal acara dari undangan..."
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg border border-rose-200 bg-rose-50/70 px-2.5 py-1 text-[11px] font-semibold text-rose-700 hover:bg-rose-100 transition cursor-pointer">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-2xl border border-dashed border-champagne/40 bg-ivory/40 p-6 text-center space-y-1">
                        <p class="text-sm font-bold text-charcoal">Belum Ada Jadwal Acara</p>
                        <p class="text-xs text-charcoal/60">Tambahkan Akad Nikah atau Resepsi di formulir atas.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- 3C. Dress Code & Live Streaming (Tampil Setelah Rangkaian Acara di Semua Tema) --}}
        <div data-bagian-utama="acara_tambahan" class="space-y-3 pt-1">
            <input type="hidden" name="live_aktif" :value="liveAktifLive ? '1' : '0'">

            <div x-data="{ buka: false }" class="rounded-2xl border border-champagne/30 bg-ivory/50 overflow-hidden">
                <button
                    type="button"
                    @click="buka = !buka"
                    class="w-full px-3.5 py-2.5 flex items-center justify-between gap-2 text-left hover:bg-ivory transition cursor-pointer"
                >
                    <span class="flex items-center gap-2 min-w-0">
                        <svg class="h-3.5 w-3.5 text-sage shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m22 8-6 4 6 4V8Z"/>
                            <rect width="14" height="12" x="2" y="6" rx="2" ry="2"/>
                        </svg>
                        <span class="text-xs font-semibold text-charcoal truncate">Dress Code &amp; Live Streaming</span>
                    </span>
                    <span class="flex items-center gap-1.5 shrink-0">
                        <span class="rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $adaDressCodeAtauLive ? 'bg-sage/12 text-sage' : 'bg-white text-charcoal/50 ring-1 ring-champagne/30' }}">
                            {{ $adaDressCodeAtauLive ? 'Terisi' : 'Opsional' }}
                        </span>
                        <svg :class="buka ? 'rotate-180 text-sage' : 'text-charcoal/45'" class="h-3.5 w-3.5 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </span>
                </button>
                <div x-show="buka" x-cloak class="px-3.5 pb-4 pt-3 border-t border-champagne/20 bg-white/80 space-y-4">
                    {{-- Dress Code (Pertama di Seksi 6 Undangan) --}}
                    <div
                        x-data="{
                            warnaList: @js(old('dress_code_warna', $undangan->dressCodeWarna())),
                            tambahWarna(hex = '#D7BB83') { if (this.warnaList.length < 5) this.warnaList.push(hex); },
                            hapusWarna(idx) { this.warnaList.splice(idx, 1); },
                            pakaiPreset(daftar) { this.warnaList = [...daftar]; }
                        }"
                        class="rounded-xl bg-ivory/75 p-3.5 ring-1 ring-champagne/25 space-y-3"
                    >
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <h3 class="font-sans text-xs font-bold text-charcoal">Dress Code &amp; Palet Warna</h3>
                            <div class="flex flex-wrap gap-1">
                                <button type="button" @click="pakaiPreset(['#472A1C', '#D7BB83', '#F5E9D6']); tandaiPerubahan(); $nextTick(() => jadwalkanLivePreview(true))" class="rounded-full bg-white px-2 py-0.5 text-[10px] font-semibold text-sage ring-1 ring-sage/25 hover:bg-sage hover:text-white transition cursor-pointer">Jawa Sogan</button>
                                <button type="button" @click="pakaiPreset(['#2F4F4F', '#C8A464', '#FDFBF7']); tandaiPerubahan(); $nextTick(() => jadwalkanLivePreview(true))" class="rounded-full bg-white px-2 py-0.5 text-[10px] font-semibold text-sage ring-1 ring-sage/25 hover:bg-sage hover:text-white transition cursor-pointer">Sage Ivory</button>
                            </div>
                        </div>

                        <input
                            type="text"
                            name="dress_code_catatan"
                            value="{{ old('dress_code_catatan', $undangan->dressCodeCatatan()) }}"
                            placeholder="Contoh: Busana bernuansa Batik Sogan atau Krem Hangat"
                            class="w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none"
                        >

                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-semibold text-charcoal/70">Warna Pilihan (Maks. 5)</span>
                                <button type="button" @click="tambahWarna(); tandaiPerubahan(); $nextTick(() => jadwalkanLivePreview(true))" x-show="warnaList.length < 5" class="rounded-full bg-sage/10 px-2.5 py-0.5 text-[11px] font-semibold text-sage hover:bg-sage hover:text-white transition cursor-pointer">+ Warna</button>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <template x-for="(hex, idx) in warnaList" :key="idx">
                                    <div class="inline-flex items-center gap-1.5 rounded-full bg-white pl-1.5 pr-2 py-1 ring-1 ring-charcoal/15">
                                        <input type="color" :name="'dress_code_warna[' + idx + ']'" x-model="warnaList[idx]" class="h-5 w-5 rounded-full border-0 bg-transparent cursor-pointer p-0">
                                        <span class="font-mono text-[10px] font-semibold uppercase text-charcoal/75" x-text="hex"></span>
                                        <button type="button" @click="hapusWarna(idx); tandaiPerubahan(); $nextTick(() => jadwalkanLivePreview(true))" class="text-charcoal/45 hover:text-rose-600 text-xs font-bold leading-none cursor-pointer" title="Hapus warna">&times;</button>
                                    </div>
                                </template>
                                <p x-show="warnaList.length === 0" class="text-[11px] italic text-charcoal/50">Belum ada warna ditambahkan.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Live Streaming (Kedua di Seksi 6 Undangan) --}}
                    <div class="rounded-xl bg-ivory/75 p-3.5 ring-1 ring-champagne/25 space-y-3">
                        <div class="flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-sans text-xs font-bold text-charcoal">Fitur Live Streaming Pernikahan</h3>
                                    <span
                                        :class="liveAktifLive ? 'bg-sage/15 text-sage' : 'bg-charcoal/10 text-charcoal/60'"
                                        class="rounded-full px-2 py-0.5 text-[10px] font-bold uppercase"
                                        x-text="liveAktifLive ? 'Aktif' : 'Nonaktif'"
                                    ></span>
                                </div>
                                <p class="text-[11px] text-charcoal/55 mt-0.5">Tautan siaran langsung bagi kerabat jauh.</p>
                            </div>
                            <button
                                type="button"
                                role="switch"
                                :aria-checked="liveAktifLive ? 'true' : 'false'"
                                @click="liveAktifLive = !liveAktifLive"
                                :class="liveAktifLive ? 'bg-sage' : 'bg-charcoal/25'"
                                class="relative inline-flex h-6 w-11 shrink-0 items-center rounded-full p-0.5 transition-colors cursor-pointer"
                                aria-label="Aktifkan Live Streaming"
                            >
                                <span
                                    :class="liveAktifLive ? 'translate-x-5' : 'translate-x-0'"
                                    class="pointer-events-none block h-5 w-5 rounded-full bg-white shadow-xs transition-transform"
                                ></span>
                            </button>
                        </div>

                        <div x-show="liveAktifLive" x-cloak class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2 border-t border-champagne/20">
                            <div class="space-y-1.5">
                                <label class="block text-xs font-semibold text-charcoal/80">Platform</label>
                                <div class="flex flex-wrap gap-1">
                                    @foreach (['YouTube Live', 'Instagram Live', 'Zoom'] as $presetLive)
                                        <button
                                            type="button"
                                            @click="$refs.livePlatformInput.value = @js($presetLive); tandaiPerubahan(); jadwalkanLivePreview(true)"
                                            class="rounded-full bg-white px-2 py-0.5 text-[10px] font-semibold text-sage ring-1 ring-sage/25 hover:bg-sage hover:text-white transition cursor-pointer"
                                        >
                                            {{ $presetLive }}
                                        </button>
                                    @endforeach
                                </div>
                                <input
                                    x-ref="livePlatformInput"
                                    type="text"
                                    name="live_platform"
                                    value="{{ $pengaturan['live_streaming']['platform'] ?? 'Instagram / YouTube' }}"
                                    class="w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none"
                                >
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-semibold text-charcoal/80">Link Live</label>
                                <input
                                    type="url"
                                    name="live_link"
                                    value="{{ $pengaturan['live_streaming']['link'] ?? '' }}"
                                    placeholder="https://youtube.com/live/..."
                                    class="w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none"
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- ACCORDION 4: Cerita Cinta (Seksi 7 Undangan) --}}
<div
    :class="tab === 'cerita' ? 'border-sage/45 ring-1 ring-sage/15 shadow-xs' : 'border-champagne/30 hover:border-champagne/60'"
    class="rounded-2xl border bg-white overflow-hidden transition"
>
    <div class="px-4 py-3.5 flex items-center justify-between gap-2 hover:bg-ivory/50 transition">
        <button
            type="button"
            data-mobile-tab="cerita"
            @click="toggleBagian('cerita')"
            class="flex-1 flex items-center justify-between gap-2 min-w-0 text-left cursor-pointer"
        >
            <span class="flex items-center gap-2.5 min-w-0">
                <svg
                    :class="tab === 'cerita' ? 'rotate-90 text-sage' : 'text-charcoal/45'"
                    class="h-4 w-4 shrink-0 transition-transform duration-200"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                >
                    <path d="m9 18 6-6-6-6"/>
                </svg>
                <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-sage/12 text-[11px] font-bold text-sage shrink-0">4</span>
                <span class="font-sans text-sm font-semibold text-charcoal truncate" :class="!sakelarFitur.cerita_cinta ? 'opacity-55' : ''">Cerita Cinta</span>
            </span>
            <span class="rounded-full bg-ivory px-2 py-0.5 font-sans tabular-nums text-[11px] font-semibold text-sage ring-1 ring-champagne/25 shrink-0" x-text="daftarCerita.length + ' Bab'"></span>
        </button>
        <button
            type="button"
            role="switch"
            data-toggle-fitur="cerita_cinta"
            :aria-checked="sakelarFitur.cerita_cinta ? 'true' : 'false'"
            :disabled="fiturMenyimpan.cerita_cinta"
            @click.stop="toggleFitur('cerita_cinta')"
            :class="sakelarFitur.cerita_cinta ? 'bg-sage' : 'bg-charcoal/25'"
            class="relative inline-flex h-5 w-9 shrink-0 items-center rounded-full p-0.5 transition-colors cursor-pointer disabled:opacity-60"
            title="Tampilkan atau sembunyikan Cerita Cinta"
            aria-label="Tampilkan Cerita Cinta"
        >
            <span
                :class="sakelarFitur.cerita_cinta ? 'translate-x-4' : 'translate-x-0'"
                class="pointer-events-none block h-4 w-4 rounded-full bg-white shadow-xs transition-transform"
            ></span>
        </button>
    </div>

    <section x-show="tab === 'cerita'" x-cloak class="px-4 pb-5 pt-3 border-t border-champagne/20 space-y-4">
        <div x-show="!sakelarFitur.cerita_cinta" x-cloak class="rounded-xl border border-amber-200 bg-amber-50/80 px-3 py-2 text-xs text-amber-800">
            Bagian <strong>Cerita Cinta</strong> sedang disembunyikan. Nyalakan sakelar di kanan atas untuk menampilkannya.
        </div>

        <div class="flex items-center justify-between gap-2 pb-2 border-b border-champagne/15">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-wider text-[#8A6D33]">Linimasa Romantis</p>
                <p class="text-xs text-charcoal/60">Tambahkan momen perjalanan cinta pasangan Anda.</p>
            </div>
            <button type="button" @click="tambahCerita()" class="inline-flex items-center gap-1 rounded-xl bg-sage px-3 py-2 text-xs font-semibold text-white hover:bg-[#3b5047] active:scale-95 transition cursor-pointer shrink-0">
                <span>+ Momen</span>
            </button>
        </div>

        <div data-bagian-utama="cerita" class="space-y-4">
            {{-- Judul Bagian Cerita (Di Atas Daftar Bab) --}}
            <div x-data="{ buka: false }" class="rounded-2xl border border-champagne/30 bg-ivory/50 overflow-hidden">
                <button
                    type="button"
                    @click="buka = !buka"
                    class="w-full px-3.5 py-2.5 flex items-center justify-between gap-2 text-left hover:bg-ivory transition cursor-pointer"
                >
                    <span class="flex items-center gap-2 min-w-0">
                        <svg class="h-3.5 w-3.5 text-sage shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                        </svg>
                        <span class="text-xs font-semibold text-charcoal truncate">Ubah Judul Bagian Cerita</span>
                    </span>
                    <span class="flex items-center gap-1.5 shrink-0">
                        <span class="rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $judulCeritaDikustom ? 'bg-sage/12 text-sage' : 'bg-white text-charcoal/50 ring-1 ring-champagne/30' }}">
                            {{ $judulCeritaDikustom ? 'Dikustom' : 'Bawaan' }}
                        </span>
                        <svg :class="buka ? 'rotate-180 text-sage' : 'text-charcoal/45'" class="h-3.5 w-3.5 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </span>
                </button>
                <div x-show="buka" x-cloak class="px-3.5 pb-3.5 pt-2.5 border-t border-champagne/20 bg-white/80">
                    <label for="teks_judul_cerita" class="block text-xs font-semibold text-charcoal/80">Judul Bagian Cerita</label>
                    <input
                        id="teks_judul_cerita"
                        type="text"
                        name="teks[judul_cerita]"
                        value="{{ $nilaiTeksEditor('judul_cerita') }}"
                        placeholder="{{ $teksBawaanTema['judul_cerita'] ?: 'Cerita Cinta / Our Love Story' }}"
                        class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none"
                    >
                </div>
            </div>

            {{-- Daftar Bab Cerita --}}
            <div class="space-y-3">
                <template x-for="(item, idx) in daftarCerita" :key="idx">
                    <div class="rounded-2xl bg-ivory/65 p-3.5 ring-1 ring-champagne/25 space-y-3">
                        <div class="flex items-center justify-between gap-2 pb-2 border-b border-champagne/15">
                            <div class="min-w-0 flex items-center gap-2">
                                <span class="inline-flex h-5 w-5 rounded-full bg-sage text-white text-[10px] font-bold items-center justify-center shrink-0" x-text="idx + 1"></span>
                                <span class="text-xs font-semibold text-charcoal truncate" x-text="item.judul || 'Momen Baru'"></span>
                            </div>
                            <div class="flex items-center gap-1 shrink-0">
                                <button type="button" x-show="idx > 0" @click="pindahCerita(idx, -1)" title="Naikkan" class="w-6 h-6 rounded-md bg-white ring-1 ring-charcoal/10 text-charcoal/70 hover:text-sage text-xs font-bold cursor-pointer">&uarr;</button>
                                <button type="button" x-show="idx < daftarCerita.length - 1" @click="pindahCerita(idx, 1)" title="Turunkan" class="w-6 h-6 rounded-md bg-white ring-1 ring-charcoal/10 text-charcoal/70 hover:text-sage text-xs font-bold cursor-pointer">&darr;</button>
                                <button type="button" x-show="daftarCerita.length > 1" @click="hapusCerita(idx)" class="rounded-md bg-rose-50 px-2 py-0.5 text-[11px] font-semibold text-rose-700 hover:bg-rose-100 cursor-pointer">Hapus</button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-2.5">
                            <div class="sm:col-span-8">
                                <label class="block text-[11px] font-semibold text-charcoal/75">Judul Momen</label>
                                <input type="text" :name="`cerita_cinta[${idx}][judul]`" x-model="item.judul" placeholder="Pertama Bertemu" class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none">
                            </div>
                            <div class="sm:col-span-4">
                                <label class="block text-[11px] font-semibold text-charcoal/75">Waktu</label>
                                <input type="text" :name="`cerita_cinta[${idx}][tanggal]`" x-model="item.tanggal" placeholder="2022" class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none">
                            </div>
                            <div class="sm:col-span-12">
                                <label class="block text-[11px] font-semibold text-charcoal/75">Kisah Singkat</label>
                                <textarea :name="`cerita_cinta[${idx}][cerita]`" x-model="item.cerita" rows="2" placeholder="Ceritakan singkat momen ini..." class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm leading-relaxed focus:border-sage focus:outline-none"></textarea>
                            </div>
                            <div class="sm:col-span-12">
                                <input type="hidden" :name="`cerita_cinta[${idx}][foto]`" :value="item.foto || ''">
                                <input type="hidden" :name="`cerita_cinta[${idx}][hapus_foto]`" :value="item.hapus_foto ? '1' : '0'">
                                <input
                                    :id="`cerita-foto-${idx}`"
                                    type="file"
                                    accept="image/jpeg,image/png,image/webp,image/*"
                                    :name="`cerita_cinta[${idx}][foto_file]`"
                                    @change="pilihFotoCerita(idx, $event)"
                                    class="sr-only"
                                >

                                <div
                                    :class="item.foto_url ? 'border-solid border-champagne/40 bg-charcoal shadow-2xs' : 'border-dashed border-champagne/50 bg-white/80 hover:border-sage/60 hover:bg-white'"
                                    class="relative overflow-hidden rounded-xl border-2 transition-all group"
                                >
                                    <label :for="`cerita-foto-${idx}`" class="block w-full cursor-pointer select-none">
                                        <template x-if="item.foto_url">
                                            <div class="relative w-full min-h-[140px] flex items-center justify-center bg-charcoal">
                                                <img :src="item.foto_url" alt="Pratinjau foto bab" class="block w-full h-auto max-h-[240px] object-contain transition duration-500 group-hover:scale-[1.02]">
                                                <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-black/50 via-transparent to-black/75"></div>
                                                <div class="absolute bottom-2.5 inset-x-2.5 flex items-center justify-between gap-2 text-white">
                                                    <span class="text-[11px] font-medium text-white/90 truncate">Klik foto untuk ganti</span>
                                                    <span class="rounded-lg bg-white/95 group-hover:bg-white px-2.5 py-1 text-[11px] font-semibold text-charcoal shrink-0 transition">Ganti</span>
                                                </div>
                                            </div>
                                        </template>
                                        <template x-if="!item.foto_url">
                                            <div class="px-3.5 py-3 flex items-center justify-between gap-2">
                                                <div class="flex items-center gap-2.5 min-w-0">
                                                    <span class="inline-flex h-8 w-8 rounded-lg bg-sage/10 text-sage items-center justify-center shrink-0">
                                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                            <rect x="3" y="3" width="18" height="18" rx="3"/>
                                                            <circle cx="8.5" cy="8.5" r="1.5"/>
                                                            <path d="m21 15-5-5L5 21"/>
                                                        </svg>
                                                    </span>
                                                    <div class="min-w-0">
                                                        <p class="text-xs font-semibold text-charcoal truncate">+ Foto Bab (Opsional)</p>
                                                        <p class="text-[11px] text-charcoal/55 truncate">Rasio template: {{ $rasioFotoTema['foto_cerita']['label'] }}</p>
                                                    </div>
                                                </div>
                                                <span class="rounded-lg bg-sage/10 px-2.5 py-1 text-[11px] font-semibold text-sage shrink-0">Pilih</span>
                                            </div>
                                        </template>
                                    </label>

                                    <div x-show="item.foto_url" x-cloak class="absolute top-2.5 right-2.5 z-20 flex items-center gap-1.5">
                                        <button
                                            type="button"
                                            @click="potongFotoCerita(idx)"
                                            class="inline-flex items-center gap-1 rounded-full bg-black/55 hover:bg-sage backdrop-blur-xs px-2.5 py-1 text-[11px] font-semibold text-white ring-1 ring-white/15 transition cursor-pointer"
                                        >
                                            Potong
                                        </button>
                                        <button
                                            type="button"
                                            @click="hapusFotoCerita(idx)"
                                            class="rounded-full bg-black/55 hover:bg-rose-600 backdrop-blur-xs px-2.5 py-1 text-[11px] font-semibold text-white ring-1 ring-white/15 transition cursor-pointer"
                                        >
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Inspirasi Cepat --}}
            <div class="rounded-xl bg-ivory/75 p-3 ring-1 ring-champagne/20 space-y-2">
                <span class="block text-[11px] font-semibold text-charcoal/70">Isi Cepat Inspirasi Bab:</span>
                <div class="flex flex-wrap gap-1.5">
                    @foreach ([
                        ['judul' => 'Pertama Bertemu', 'tanggal' => '2022', 'cerita' => 'Pertemuan sederhana yang berawal dari obrolan hangat dan perlahan menumbuhkan rasa nyaman.'],
                        ['judul' => 'Mulai Komitmen', 'tanggal' => '2024', 'cerita' => 'Berjalan beriringan, saling menguatkan mimpi, dan memantapkan langkah menuju masa depan.'],
                        ['judul' => 'Momen Lamaran', 'tanggal' => '2026', 'cerita' => 'Dengan doa dan restu kedua orang tua, kami mengikat janji suci menuju hari pernikahan.'],
                    ] as $presetCerita)
                        <button
                            type="button"
                            @click="tambahCeritaPreset(@js($presetCerita['judul']), @js($presetCerita['tanggal']), @js($presetCerita['cerita']))"
                            class="rounded-full bg-white px-2.5 py-1 text-[11px] font-semibold text-sage ring-1 ring-sage/25 hover:bg-sage hover:text-white transition cursor-pointer"
                        >
                            + {{ $presetCerita['judul'] }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Pratinjau Linimasa Lipat --}}
            <div x-data="{ buka: false }" class="rounded-2xl border border-champagne/30 bg-ivory/50 overflow-hidden">
                <button
                    type="button"
                    @click="buka = !buka"
                    class="w-full px-3.5 py-2.5 flex items-center justify-between gap-2 text-left hover:bg-ivory transition cursor-pointer"
                >
                    <span class="text-xs font-semibold text-charcoal">Pratinjau Tampilan Tamu</span>
                    <svg :class="buka ? 'rotate-180 text-sage' : 'text-charcoal/45'" class="h-3.5 w-3.5 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m6 9 6 6 6-6"/>
                    </svg>
                </button>
                <div x-show="buka" x-cloak class="px-4 pb-4 pt-3 border-t border-champagne/20 bg-white space-y-3">
                    <div class="relative border-l-2 border-champagne/40 ml-2 pl-4 space-y-4">
                        <template x-for="(item, idx) in daftarCerita" :key="'prev-' + idx">
                            <div class="relative">
                                <span class="absolute -left-[22px] top-1 w-2.5 h-2.5 rotate-45 bg-champagne ring-4 ring-white"></span>
                                <span x-show="item.tanggal" class="inline-block rounded-full bg-champagne/15 px-2 py-0.5 text-[10px] font-bold text-champagne" x-text="item.tanggal"></span>
                                <h4 class="font-logo text-sm font-bold text-charcoal mt-0.5" x-text="item.judul || 'Judul Momen ' + (idx + 1)"></h4>
                                <p class="mt-0.5 text-xs leading-relaxed text-charcoal/70" x-text="item.cerita || 'Deskripsi kisah akan tampil di sini...'"></p>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- ACCORDION 5: Galeri Foto (Seksi 8 Undangan) --}}
@php
    $jumlahGaleri = $undangan->daftarGaleri->count();
    $persenGaleri = min(100, (int) round(($jumlahGaleri / 10) * 100));
@endphp
<div
    :class="tab === 'galeri' ? 'border-sage/45 ring-1 ring-sage/15 shadow-xs' : 'border-champagne/30 hover:border-champagne/60'"
    class="rounded-2xl border bg-white overflow-hidden transition"
>
    <div class="px-4 py-3.5 flex items-center justify-between gap-2 hover:bg-ivory/50 transition">
        <button
            type="button"
            data-mobile-tab="galeri"
            @click="toggleBagian('galeri')"
            class="flex-1 flex items-center justify-between gap-2 min-w-0 text-left cursor-pointer"
        >
            <span class="flex items-center gap-2.5 min-w-0">
                <svg
                    :class="tab === 'galeri' ? 'rotate-90 text-sage' : 'text-charcoal/45'"
                    class="h-4 w-4 shrink-0 transition-transform duration-200"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                >
                    <path d="m9 18 6-6-6-6"/>
                </svg>
                <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-sage/12 text-[11px] font-bold text-sage shrink-0">5</span>
                <span class="font-sans text-sm font-semibold text-charcoal truncate" :class="!sakelarFitur.galeri ? 'opacity-55' : ''">Galeri Foto</span>
            </span>
            <span
                class="rounded-full bg-ivory px-2 py-0.5 font-sans tabular-nums text-[11px] font-semibold text-sage ring-1 ring-champagne/25 shrink-0"
                x-text="daftarGaleri.length + '/' + maksGaleri + ' Foto'"
            >
                {{ $jumlahGaleri }}/10 Foto
            </span>
        </button>
        <button
            type="button"
            role="switch"
            data-toggle-fitur="galeri"
            :aria-checked="sakelarFitur.galeri ? 'true' : 'false'"
            :disabled="fiturMenyimpan.galeri"
            @click.stop="toggleFitur('galeri')"
            :class="sakelarFitur.galeri ? 'bg-sage' : 'bg-charcoal/25'"
            class="relative inline-flex h-5 w-9 shrink-0 items-center rounded-full p-0.5 transition-colors cursor-pointer disabled:opacity-60"
            title="Tampilkan atau sembunyikan Galeri Foto"
            aria-label="Tampilkan Galeri Foto"
        >
            <span
                :class="sakelarFitur.galeri ? 'translate-x-4' : 'translate-x-0'"
                class="pointer-events-none block h-4 w-4 rounded-full bg-white shadow-xs transition-transform"
            ></span>
        </button>
    </div>

    <section x-show="tab === 'galeri'" x-cloak class="px-4 pb-5 pt-3 border-t border-champagne/20 space-y-4">
        <div x-show="!sakelarFitur.galeri" x-cloak class="rounded-xl border border-amber-200 bg-amber-50/80 px-3 py-2 text-xs text-amber-800">
            Bagian <strong>Galeri Foto</strong> sedang disembunyikan. Nyalakan sakelar di kanan atas untuk menampilkannya.
        </div>

        {{-- Judul Bagian Galeri (Tampil di Atas Galeri Foto) --}}
        <div x-data="{ buka: false }" class="rounded-2xl border border-champagne/30 bg-ivory/50 overflow-hidden">
            <button
                type="button"
                @click="buka = !buka"
                class="w-full px-3.5 py-2.5 flex items-center justify-between gap-2 text-left hover:bg-ivory transition cursor-pointer"
            >
                <span class="flex items-center gap-2 min-w-0">
                    <svg class="h-3.5 w-3.5 text-sage shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                    </svg>
                    <span class="text-xs font-semibold text-charcoal truncate">Ubah Judul Bagian Galeri</span>
                </span>
                <span class="flex items-center gap-1.5 shrink-0">
                    <span class="rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $judulGaleriDikustom ? 'bg-sage/12 text-sage' : 'bg-white text-charcoal/50 ring-1 ring-champagne/30' }}">
                        {{ $judulGaleriDikustom ? 'Dikustom' : 'Bawaan' }}
                    </span>
                    <svg :class="buka ? 'rotate-180 text-sage' : 'text-charcoal/45'" class="h-3.5 w-3.5 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m6 9 6 6 6-6"/>
                    </svg>
                </span>
            </button>
            <div x-show="buka" x-cloak class="px-3.5 pb-3.5 pt-2.5 border-t border-champagne/20 bg-white/80">
                <div data-bagian-utama="galeri">
                    <label for="teks_judul_galeri" class="block text-xs font-semibold text-charcoal/80">Judul Bagian Galeri</label>
                    <input
                        id="teks_judul_galeri"
                        type="text"
                        name="teks[judul_galeri]"
                        value="{{ $nilaiTeksEditor('judul_galeri') }}"
                        placeholder="{{ $teksBawaanTema['judul_galeri'] ?: 'Our Gallery / Potret Kebahagiaan' }}"
                        class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none"
                    >
                </div>
            </div>
        </div>

        {{-- Kuota Ringkas (Live) --}}
        <div class="rounded-xl bg-ivory p-3 ring-1 ring-champagne/25">
            <div class="flex items-center justify-between text-xs font-semibold text-charcoal">
                <span>Kuota Galeri Prewedding</span>
                <span class="text-sage font-bold tabular-nums" x-text="daftarGaleri.length + '/' + maksGaleri + ' Foto'">{{ $jumlahGaleri }}/10 Foto</span>
            </div>
            <div class="mt-2 h-1.5 w-full rounded-full bg-champagne/20 overflow-hidden">
                <div
                    class="h-full rounded-full bg-gradient-to-r from-sage to-champagne transition-all duration-300"
                    :style="'width: ' + Math.min(100, Math.round((daftarGaleri.length / maksGaleri) * 100)) + '%'"
                    style="width: {{ $persenGaleri }}%"
                ></div>
            </div>
        </div>

        {{-- Multi-Unggah Galeri Tanpa Refresh (Tersimpan Bersama Simpan Semua) --}}
        <div class="space-y-3">
            <input
                id="input-galeri-foto"
                type="file"
                name="galeri_foto[]"
                accept="image/jpeg,image/png,image/webp,image/*"
                multiple
                @change="pilihFotoGaleri($event)"
                class="sr-only"
            >

            <div class="flex items-center justify-between gap-2">
                <p class="text-[11px] leading-relaxed text-charcoal/60">
                    Pilih 1&ndash;10 foto sekaligus (rasio template: <span class="font-semibold text-charcoal/80">{{ $rasioFotoTema['foto_galeri']['label'] }}</span>). Perubahan langsung tampil di pratinjau dan tersimpan lewat <strong>Simpan Semua</strong>.
                </p>
            </div>

            {{-- Keadaan Kosong: Area Unggah Penuh --}}
            <label
                x-show="daftarGaleri.length === 0"
                for="input-galeri-foto"
                @dragover.prevent="sedangTarikGaleri = true"
                @dragleave.prevent="sedangTarikGaleri = false"
                @drop.prevent="jatuhFotoGaleri($event)"
                :class="sedangTarikGaleri ? 'border-sage bg-sage/[0.06] ring-4 ring-sage/10' : 'border-champagne/60 bg-ivory/50 hover:border-sage/60 hover:bg-ivory'"
                class="flex flex-col items-center justify-center gap-2 rounded-2xl border-2 border-dashed px-4 py-7 text-center cursor-pointer transition select-none"
            >
                <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-sage/10 text-sage">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="17 8 12 3 7 8"/>
                        <line x1="12" x2="12" y1="3" y2="15"/>
                    </svg>
                </span>
                <div>
                    <p class="text-xs font-semibold text-charcoal">Pilih atau Seret Foto Prewedding</p>
                    <p class="mt-0.5 text-[11px] text-charcoal/55">Bisa pilih sekaligus hingga 10 foto • Otomatis dipotong &amp; WebP</p>
                </div>
                <span class="rounded-lg bg-sage/10 px-3 py-1.5 text-[11px] font-semibold text-sage">Pilih Foto</span>
            </label>

            {{-- Grid Foto Galeri + Kartu Tambah Foto --}}
            <div x-show="daftarGaleri.length > 0" x-cloak class="space-y-2.5">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-charcoal/65">Koleksi Foto Galeri</h3>
                    <span class="text-[11px] text-charcoal/50">Klik foto untuk perbesar</span>
                </div>

                <div class="grid grid-cols-2 gap-2.5">
                    <template x-for="(item, idx) in daftarGaleri" :key="item.uid">
                        <div class="group rounded-xl overflow-hidden bg-white ring-1 ring-champagne/30 shadow-2xs flex flex-col">
                            <div
                                @click="galeriLightbox = { url: item.url, caption: item.keterangan || ('Foto #' + (idx + 1)) }"
                                class="relative overflow-hidden bg-charcoal cursor-zoom-in"
                                style="aspect-ratio: {{ $rasioFotoTema['foto_galeri']['rasio'] }};"
                            >
                                <img
                                    :src="item.url"
                                    :alt="item.keterangan || ('Foto Galeri #' + (idx + 1))"
                                    class="block h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]"
                                >
                                <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-black/55 via-transparent to-black/70"></div>

                                {{-- Nomor & Urutan --}}
                                <div class="absolute top-2 left-2 z-10 flex items-center gap-1">
                                    <span class="rounded-full bg-black/60 backdrop-blur-xs px-2 py-0.5 text-[10px] font-bold text-white ring-1 ring-white/15 tabular-nums" x-text="'#' + (idx + 1)"></span>
                                    <button
                                        type="button"
                                        x-show="idx > 0"
                                        @click.stop="pindahFotoGaleri(idx, -1)"
                                        title="Geser ke kiri"
                                        aria-label="Geser foto galeri ke kiri"
                                        class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-black/55 hover:bg-sage text-[10px] font-bold text-white ring-1 ring-white/15 transition cursor-pointer"
                                    >&larr;</button>
                                    <button
                                        type="button"
                                        x-show="idx < daftarGaleri.length - 1"
                                        @click.stop="pindahFotoGaleri(idx, 1)"
                                        title="Geser ke kanan"
                                        aria-label="Geser foto galeri ke kanan"
                                        class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-black/55 hover:bg-sage text-[10px] font-bold text-white ring-1 ring-white/15 transition cursor-pointer"
                                    >&rarr;</button>
                                </div>

                                {{-- Aksi Potong & Hapus --}}
                                <div class="absolute bottom-2 inset-x-2 z-10 flex items-center justify-end gap-1.5">
                                    <button
                                        type="button"
                                        @click.stop="potongFotoGaleri(idx)"
                                        class="rounded-full bg-black/60 hover:bg-sage backdrop-blur-xs px-2.5 py-1 text-[10px] font-semibold text-white ring-1 ring-white/15 transition cursor-pointer"
                                    >Potong</button>
                                    <button
                                        type="button"
                                        @click.stop="hapusFotoGaleri(idx)"
                                        class="rounded-full bg-black/60 hover:bg-rose-600 backdrop-blur-xs px-2.5 py-1 text-[10px] font-semibold text-white ring-1 ring-white/15 transition cursor-pointer"
                                    >Hapus</button>
                                </div>
                            </div>

                            {{-- Keterangan Opsional Langsung di Kartu --}}
                            <div class="p-2 bg-white border-t border-champagne/20">
                                <input
                                    type="text"
                                    x-model="item.keterangan"
                                    @input="saatUbahKeteranganGaleri()"
                                    maxlength="255"
                                    placeholder="Keterangan (opsional)..."
                                    class="w-full rounded-lg border border-charcoal/10 bg-ivory/50 px-2 py-1 text-[11px] text-charcoal placeholder:text-charcoal/40 focus:border-sage focus:bg-white focus:outline-none"
                                >
                            </div>
                        </div>
                    </template>

                    {{-- Kartu Tambah Foto Baru (selama < 10 foto) --}}
                    <label
                        x-show="daftarGaleri.length < maksGaleri"
                        for="input-galeri-foto"
                        @dragover.prevent="sedangTarikGaleri = true"
                        @dragleave.prevent="sedangTarikGaleri = false"
                        @drop.prevent="jatuhFotoGaleri($event)"
                        :class="sedangTarikGaleri ? 'border-sage bg-sage/[0.08] ring-2 ring-sage/20' : 'border-champagne/60 bg-ivory/60 hover:border-sage/60 hover:bg-ivory'"
                        class="flex flex-col items-center justify-center gap-1.5 rounded-xl border-2 border-dashed p-3 text-center cursor-pointer transition select-none min-h-[160px]"
                    >
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-sage/10 text-sage text-lg font-bold">+</span>
                        <span class="text-xs font-semibold text-charcoal">Tambah Foto</span>
                        <span class="text-[10px] text-charcoal/55 tabular-nums" x-text="'Sisa ' + (maksGaleri - daftarGaleri.length) + ' slot'"></span>
                    </label>
                </div>

                <p x-show="daftarGaleri.length >= maksGaleri" x-cloak class="text-[11px] text-charcoal/55">
                    Kuota maksimal 10 foto galeri sudah tercapai. Hapus salah satu foto jika ingin mengganti.
                </p>
            </div>

            <p x-show="pesanGalatGaleri" x-cloak x-text="pesanGalatGaleri" class="text-xs font-medium text-rose-600"></p>
        </div>
    </section>
</div>
