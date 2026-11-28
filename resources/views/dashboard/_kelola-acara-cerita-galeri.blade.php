@php
    $jumlahFotoHitungMundur = count($undangan->daftarFotoHitungMundurKhususDashboard());
    $adaDressCode = filled($undangan->dressCodeCatatan())
        || ! empty($undangan->dressCodeWarna());
    $judulCeritaDikustom = filled($teksKustom['judul_cerita'] ?? '');
    $judulGaleriDikustom = filled($teksKustom['judul_galeri'] ?? '');
@endphp

{{-- ACCORDION 4: Hitung Mundur (Save The Date) --}}
<div
    :class="tab === 'hitung_mundur' ? 'border-sage/45 ring-1 ring-sage/15 shadow-xs' : 'border-champagne/30 hover:border-champagne/60'"
    class="rounded-2xl border bg-white overflow-hidden transition"
>
    <div class="px-4 py-3.5 flex items-center justify-between gap-2 hover:bg-ivory/50 transition">
        <button
            type="button"
            data-mobile-tab="hitung_mundur"
            @click="toggleBagian('hitung_mundur')"
            class="flex-1 flex items-center justify-between gap-2 min-w-0 text-left cursor-pointer"
        >
            <span class="flex items-center gap-2.5 min-w-0">
                <svg
                    :class="tab === 'hitung_mundur' ? 'rotate-90 text-sage' : 'text-charcoal/45'"
                    class="h-4 w-4 shrink-0 transition-transform duration-200"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                >
                    <path d="m9 18 6-6-6-6"/>
                </svg>
                <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-sage/12 text-[11px] font-bold text-sage shrink-0">4</span>
                <span class="font-sans text-sm font-semibold text-charcoal truncate" :class="!sakelarFitur.hitung_mundur ? 'opacity-55' : ''">Hitung Mundur</span>
            </span>
            <span
                class="rounded-full bg-ivory px-2 py-0.5 font-sans tabular-nums text-[11px] font-semibold text-sage ring-1 ring-champagne/25 shrink-0"
                x-text="daftarFotoHitungMundur.length > 0 ? daftarFotoHitungMundur.length + '/' + maksFotoHitungMundur + ' Foto' : (sakelarFitur.hitung_mundur ? 'Aktif' : 'Nonaktif')"
            >
                {{ $jumlahFotoHitungMundur > 0 ? $jumlahFotoHitungMundur.'/'.\App\Models\Undangan::MAKS_FOTO_HITUNG_MUNDUR.' Foto' : ($sakelarFiturAwal['hitung_mundur'] ? 'Aktif' : 'Nonaktif') }}
            </span>
        </button>
        <button
            type="button"
            role="switch"
            data-toggle-fitur="hitung_mundur"
            :aria-checked="sakelarFitur.hitung_mundur ? 'true' : 'false'"
            :disabled="Boolean(fiturMenyimpan.hitung_mundur)"
            @click.stop="toggleFitur('hitung_mundur')"
            :class="sakelarFitur.hitung_mundur ? 'bg-sage' : 'bg-charcoal/25'"
            class="relative inline-flex h-5 w-9 shrink-0 items-center rounded-full p-0.5 transition-colors cursor-pointer disabled:opacity-60"
            title="Tampilkan atau sembunyikan Hitung Mundur"
            aria-label="Tampilkan Hitung Mundur"
        >
            <span
                :class="sakelarFitur.hitung_mundur ? 'translate-x-4' : 'translate-x-0'"
                class="pointer-events-none block h-4 w-4 rounded-full bg-white shadow-xs transition-transform"
            ></span>
        </button>
    </div>

    <section x-show="tab === 'hitung_mundur'" x-cloak class="px-4 pb-5 pt-3 border-t border-champagne/20 space-y-4">
        <div x-show="!sakelarFitur.hitung_mundur" x-cloak class="rounded-xl border border-amber-200 bg-amber-50/80 px-3 py-2 text-xs text-amber-800">
            Bagian <strong>Hitung Mundur (Save The Date)</strong> sedang disembunyikan. Nyalakan sakelar di kanan atas untuk menampilkannya.
        </div>

        {{-- Foto Slideshow Hitung Mundur (1-4 Foto di atas Save The Date) --}}
        <div class="rounded-2xl bg-ivory/65 p-4 ring-1 ring-champagne/25 space-y-3">
            <div class="flex items-center justify-between gap-2">
                <div>
                    <span class="block text-xs font-bold text-charcoal">Foto Slideshow Hitung Mundur</span>
                    <p class="mt-0.5 text-[11px] leading-relaxed text-charcoal/60">
                        Unggah 1&ndash;{{ \App\Models\Undangan::MAKS_FOTO_HITUNG_MUNDUR }} foto agar berganti otomatis di atas <strong>Save The Date</strong>. Rasio: <span class="font-semibold text-charcoal/80">{{ $rasioFotoTema['foto_hitung_mundur']['label'] }}</span>.
                    </p>
                </div>
                <span
                    :class="daftarFotoHitungMundur.length > 0 ? 'bg-sage/12 text-sage' : 'bg-white text-charcoal/50 ring-1 ring-champagne/30'"
                    class="rounded-full px-2 py-0.5 text-[10px] font-semibold tabular-nums shrink-0"
                    x-text="daftarFotoHitungMundur.length > 0 ? daftarFotoHitungMundur.length + '/' + maksFotoHitungMundur + ' Foto' : 'Opsional'"
                >{{ $jumlahFotoHitungMundur > 0 ? $jumlahFotoHitungMundur.'/'.\App\Models\Undangan::MAKS_FOTO_HITUNG_MUNDUR.' Foto' : 'Opsional' }}</span>
            </div>

            <input
                id="input-foto-hitung-mundur"
                type="file"
                name="foto_hitung_mundur[]"
                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                multiple
                @change="pilihFotoHitungMundur($event)"
                class="sr-only"
            >

            {{-- Keadaan Kosong: Area Unggah Penuh --}}
            <label
                x-show="daftarFotoHitungMundur.length === 0"
                for="input-foto-hitung-mundur"
                @dragover.prevent="sedangTarikHitungMundur = true"
                @dragleave.prevent="sedangTarikHitungMundur = false"
                @drop.prevent="jatuhFotoHitungMundur($event)"
                :class="sedangTarikHitungMundur ? 'border-sage bg-sage/[0.06] ring-4 ring-sage/10' : 'border-champagne/60 bg-white/80 hover:border-sage/60 hover:bg-white'"
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
                    :class="sedangTarikHitungMundur ? 'border-sage bg-sage/[0.08] ring-2 ring-sage/20' : 'border-champagne/60 bg-white/80 hover:border-sage/60 hover:bg-white'"
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

        {{-- Teks Judul & Pengantar Hitung Mundur --}}
        <div data-bagian-utama="hitung_mundur_teks" class="rounded-2xl bg-ivory/65 p-4 ring-1 ring-champagne/25 space-y-3">
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
                <label for="teks_pengantar_hitung_mundur" class="block text-xs font-semibold text-charcoal/80">Kalimat Pengantar Hitung Mundur</label>
                <textarea
                    id="teks_pengantar_hitung_mundur"
                    name="teks[pengantar_hitung_mundur]"
                    rows="2"
                    placeholder="{{ $teksBawaanTema['pengantar_hitung_mundur'] ?: 'Merupakan kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir...' }}"
                    class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm leading-relaxed focus:border-sage focus:outline-none"
                >{{ $nilaiTeksEditor('pengantar_hitung_mundur') }}</textarea>
            </div>
        </div>
    </section>
</div>

{{-- ACCORDION 5: Rangkaian Acara (Jadwal Akad, Resepsi, dll.) --}}
<div
    :class="tab === 'acara' ? 'border-sage/45 ring-1 ring-sage/15 shadow-xs overflow-visible' : 'border-champagne/30 hover:border-champagne/60 overflow-hidden'"
    class="rounded-2xl border bg-white transition"
>
    <div :class="tab === 'acara' ? 'rounded-t-2xl' : 'rounded-2xl'" class="px-4 py-3.5 flex items-center justify-between gap-2 hover:bg-ivory/50 transition">
        <button
            type="button"
            data-mobile-tab="acara"
            @click="toggleBagian('acara')"
            class="flex-1 flex items-center justify-between gap-2 min-w-0 text-left cursor-pointer"
        >
            <span class="flex items-center gap-2.5 min-w-0">
                <svg
                    :class="tab === 'acara' ? 'rotate-90 text-sage' : 'text-charcoal/45'"
                    class="h-4 w-4 shrink-0 transition-transform duration-200"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                >
                    <path d="m9 18 6-6-6-6"/>
                </svg>
                <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-sage/12 text-[11px] font-bold text-sage shrink-0">5</span>
                <span class="font-sans text-sm font-semibold text-charcoal truncate" :class="!sakelarFitur.acara ? 'opacity-55' : ''">Rangkaian Acara</span>
            </span>
            <span
                class="rounded-full bg-ivory px-2 py-0.5 font-sans tabular-nums text-[11px] font-semibold text-sage ring-1 ring-champagne/25 shrink-0"
                x-text="daftarAcara.length + ' Acara'"
            >
                {{ $undangan->daftarAcara->count() }} Acara
            </span>
        </button>
        <button
            type="button"
            role="switch"
            data-toggle-fitur="acara"
            :aria-checked="sakelarFitur.acara ? 'true' : 'false'"
            :disabled="Boolean(fiturMenyimpan.acara)"
            @click.stop="toggleFitur('acara')"
            :class="sakelarFitur.acara ? 'bg-sage' : 'bg-charcoal/25'"
            class="relative inline-flex h-5 w-9 shrink-0 items-center rounded-full p-0.5 transition-colors cursor-pointer disabled:opacity-60"
            title="Tampilkan atau sembunyikan Rangkaian Acara"
            aria-label="Tampilkan Rangkaian Acara"
        >
            <span
                :class="sakelarFitur.acara ? 'translate-x-4' : 'translate-x-0'"
                class="pointer-events-none block h-4 w-4 rounded-full bg-white shadow-xs transition-transform"
            ></span>
        </button>
    </div>

    <section x-show="tab === 'acara'" x-cloak class="px-4 pb-5 pt-3 border-t border-champagne/20 space-y-4">
        <div x-show="!sakelarFitur.acara" x-cloak class="rounded-xl border border-amber-200 bg-amber-50/80 px-3 py-2 text-xs text-amber-800">
            Bagian <strong>Rangkaian Acara</strong> sedang disembunyikan. Nyalakan sakelar di kanan atas untuk menampilkannya.
        </div>
        {{-- Judul Bagian Acara --}}
        <div data-bagian-utama="acara_teks" class="rounded-2xl bg-ivory/65 p-3.5 ring-1 ring-champagne/25">
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

        {{-- Form Tambah / Edit Jadwal Acara --}}
        <div x-ref="formAcaraPanel" class="rounded-2xl bg-ivory/65 p-4 ring-1 ring-champagne/20 space-y-3.5">
            <div class="flex items-center justify-between gap-2">
                <h2 class="font-sans text-sm font-bold text-charcoal" x-text="acaraEdit ? ('Edit: ' + acaraEdit.nama_acara) : 'Tambah Jadwal Acara'"></h2>
                <button type="button" x-show="acaraEdit" x-cloak @click="batalEditAcara()" class="rounded-lg border border-champagne/50 bg-white px-2.5 py-1 text-[11px] font-semibold text-charcoal hover:bg-champagne/15 transition cursor-pointer shrink-0">
                    + Batal Edit
                </button>
            </div>

            <form
                action="{{ route('dashboard.acara.simpan', $undangan) }}"
                method="POST"
                @submit.prevent="simpanAcara($event)"
                class="grid grid-cols-1 gap-3"
            >
                @csrf
                <input type="hidden" name="acara_id" :value="formAcara.id">

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-charcoal/80">Nama Acara</label>
                    <div class="flex flex-wrap gap-1">
                        @foreach (['Akad Nikah', 'Resepsi', 'Pemberkatan', 'Ngunduh Mantu', 'Walimatul Ursy'] as $presetAcara)
                            <button
                                type="button"
                                @click="formAcara.nama_acara = @js($presetAcara)"
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
                        x-model="formAcara.nama_acara"
                        required
                        placeholder="Akad Nikah / Resepsi"
                        class="w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-sage focus:outline-none"
                    >
                </div>

                {{-- Tanggal Acara: 1 Kotak + Kalender Kustom Tema Select2 SesiTemu --}}
                <div
                    class="relative"
                    @click.outside="if (pickerAcaraAktif === 'tanggal') tutupPickerAcara()"
                    @keydown.escape.window="tutupPickerAcara()"
                >
                    <label class="block text-xs font-semibold text-charcoal/80">Tanggal Acara</label>
                    <input type="hidden" name="tanggal_acara" :value="formAcara.tanggal_acara">
                    <button
                        type="button"
                        x-ref="acaraTanggalTrigger"
                        data-picker-acara="tanggal"
                        @click="togglePickerAcara('tanggal')"
                        :class="pickerAcaraAktif === 'tanggal' ? 'border-champagne ring-[3px] ring-champagne/15' : 'border-charcoal/15 hover:border-champagne/60'"
                        class="mt-1 h-[38px] w-full rounded-xl border bg-white px-3 flex items-center justify-between gap-2 text-left text-[13px] transition cursor-pointer"
                    >
                        <span class="flex items-center gap-2 min-w-0">
                            <svg class="h-4 w-4 text-sage/80 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                                <line x1="16" x2="16" y1="2" y2="6"/>
                                <line x1="8" x2="8" y1="2" y2="6"/>
                                <line x1="3" x2="21" y1="10" y2="10"/>
                            </svg>
                            <span
                                class="truncate"
                                :class="formAcara.tanggal_acara ? 'font-medium text-charcoal' : 'text-charcoal/45'"
                                x-text="labelTanggalAcara()"
                            >Pilih tanggal acara...</span>
                        </span>
                        <svg
                            :class="pickerAcaraAktif === 'tanggal' ? 'rotate-180 text-champagne' : 'text-charcoal/50'"
                            class="h-3.5 w-3.5 shrink-0 transition-transform duration-150"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                        >
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>

                    {{-- Popover Kalender SesiTemu --}}
                    <div
                        x-show="pickerAcaraAktif === 'tanggal'"
                        x-cloak
                        x-transition.opacity.duration.150ms
                        class="absolute left-0 right-0 top-full mt-1.5 z-40 rounded-xl border border-champagne/35 bg-white shadow-[0_14px_32px_-8px_rgba(31,41,55,0.18),0_4px_10px_-4px_rgba(31,41,55,0.08)] overflow-hidden"
                    >
                        <div class="flex items-center justify-between gap-2 bg-ivory px-3 py-2 border-b border-champagne/20">
                            <button
                                type="button"
                                @click="modePilihBulan ? (kalenderTahun--) : geserBulanKalender(-1)"
                                class="inline-flex h-7 w-7 items-center justify-center rounded-lg text-charcoal/70 hover:bg-champagne/15 hover:text-charcoal transition cursor-pointer"
                                title="Sebelumnya"
                            >
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
                            </button>

                            <button
                                type="button"
                                @click="modePilihBulan = !modePilihBulan"
                                class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1 text-xs font-bold text-charcoal hover:bg-champagne/15 transition cursor-pointer"
                            >
                                <span x-text="modePilihBulan ? kalenderTahun : (namaBulanKalender[kalenderBulan] + ' ' + kalenderTahun)"></span>
                                <svg :class="modePilihBulan ? 'rotate-180 text-champagne' : 'text-charcoal/45'" class="h-3 w-3 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </button>

                            <button
                                type="button"
                                @click="modePilihBulan ? (kalenderTahun++) : geserBulanKalender(1)"
                                class="inline-flex h-7 w-7 items-center justify-center rounded-lg text-charcoal/70 hover:bg-champagne/15 hover:text-charcoal transition cursor-pointer"
                                title="Berikutnya"
                            >
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
                            </button>
                        </div>

                        {{-- Mode Pilih Cepat Bulan --}}
                        <div x-show="modePilihBulan" x-cloak class="p-2.5 grid grid-cols-3 gap-1.5">
                            <template x-for="(namaBln, idxBln) in namaBulanKalender" :key="idxBln">
                                <button
                                    type="button"
                                    @click="kalenderBulan = idxBln; modePilihBulan = false"
                                    :class="kalenderBulan === idxBln ? 'bg-sage text-white font-semibold' : 'text-charcoal/80 hover:bg-champagne/15'"
                                    class="rounded-lg py-2 text-xs transition cursor-pointer"
                                    x-text="namaBln.slice(0, 3)"
                                ></button>
                            </template>
                        </div>

                        {{-- Grid Hari Kalender --}}
                        <div x-show="!modePilihBulan" class="p-2.5">
                            <div class="grid grid-cols-7 gap-1 mb-1 text-center">
                                @foreach (['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $hariSingkat)
                                    <span class="text-[10px] font-semibold uppercase tracking-wider text-charcoal/45 py-1">{{ $hariSingkat }}</span>
                                @endforeach
                            </div>
                            <div class="grid grid-cols-7 gap-1">
                                <template x-for="sel in daftarSelKalender()" :key="sel.kunci">
                                    <button
                                        type="button"
                                        @click="pilihTanggalKalender(sel.iso)"
                                        :class="sel.terpilih
                                            ? 'bg-sage text-white font-semibold shadow-xs'
                                            : (sel.hariIni
                                                ? 'bg-ivory text-sage font-semibold ring-1 ring-champagne/70 hover:bg-champagne/15'
                                                : (sel.bulanAktif
                                                    ? 'text-charcoal hover:bg-champagne/15'
                                                    : 'text-charcoal/30 hover:bg-ivory'))"
                                        class="h-8 w-full rounded-lg text-xs tabular-nums transition cursor-pointer"
                                        x-text="sel.angka"
                                    ></button>
                                </template>
                            </div>
                        </div>

                        <div class="flex items-center justify-between bg-ivory/70 px-3 py-2 border-t border-champagne/15 text-[11px]">
                            <button
                                type="button"
                                @click="pilihHariIniAcara()"
                                class="font-semibold text-sage hover:underline cursor-pointer"
                            >Hari Ini</button>
                            <button
                                type="button"
                                x-show="formAcara.tanggal_acara"
                                @click="formAcara.tanggal_acara = ''; tutupPickerAcara()"
                                class="font-medium text-charcoal/55 hover:text-rose-600 transition cursor-pointer"
                            >Hapus</button>
                        </div>
                    </div>
                </div>

                {{-- Mulai, Selesai & Zona: 3 Kolom Rapi Tema Select2 SesiTemu --}}
                <div class="grid grid-cols-3 gap-2">
                    {{-- Jam Mulai --}}
                    <div
                        class="relative"
                        @click.outside="if (pickerAcaraAktif === 'mulai') tutupPickerAcara()"
                    >
                        <label class="block text-xs font-semibold text-charcoal/80">Mulai</label>
                        <input type="hidden" name="waktu_mulai" :value="formAcara.waktu_mulai">
                        <button
                            type="button"
                            x-ref="acaraMulaiTrigger"
                            data-picker-acara="mulai"
                            @click="togglePickerAcara('mulai')"
                            :class="pickerAcaraAktif === 'mulai' ? 'border-champagne ring-[3px] ring-champagne/15' : 'border-charcoal/15 hover:border-champagne/60'"
                            class="mt-1 h-[38px] w-full rounded-xl border bg-white px-2.5 flex items-center justify-between gap-1.5 text-left text-[13px] transition cursor-pointer"
                        >
                            <span class="flex items-center gap-1.5 min-w-0">
                                <svg class="h-3.5 w-3.5 text-sage/75 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                <span class="tabular-nums font-medium text-charcoal truncate" x-text="formAcara.waktu_mulai || '08:00'">08:00</span>
                            </span>
                            <svg :class="pickerAcaraAktif === 'mulai' ? 'rotate-180 text-champagne' : 'text-charcoal/50'" class="h-3 w-3 shrink-0 transition-transform duration-150" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                        </button>

                        <div
                            x-show="pickerAcaraAktif === 'mulai'"
                            x-cloak
                            x-transition.opacity.duration.150ms
                            class="absolute left-0 top-full mt-1.5 z-40 w-[214px] rounded-xl border border-champagne/35 bg-white shadow-[0_14px_32px_-8px_rgba(31,41,55,0.18),0_4px_10px_-4px_rgba(31,41,55,0.08)] overflow-hidden"
                        >
                            <div class="flex items-center justify-between bg-ivory px-3 py-2 border-b border-champagne/20">
                                <span class="text-[11px] font-semibold text-charcoal/70">Jam Mulai</span>
                                <span class="rounded-md bg-sage/10 px-2 py-0.5 text-xs font-bold text-sage tabular-nums" x-text="formAcara.waktu_mulai || '08:00'"></span>
                            </div>
                            <div class="grid grid-cols-2 divide-x divide-champagne/15">
                                <div class="p-1.5">
                                    <p class="pb-1 text-center text-[10px] font-bold uppercase tracking-wider text-charcoal/45">Jam</p>
                                    <div x-ref="mulaiJamList" class="max-h-44 overflow-y-auto space-y-0.5 pr-0.5">
                                        @for ($j = 0; $j < 24; $j++)
                                            @php $jStr = str_pad((string) $j, 2, '0', STR_PAD_LEFT); @endphp
                                            <button
                                                type="button"
                                                data-jam="{{ $jStr }}"
                                                @click="aturBagianWaktuAcara('waktu_mulai', 'jam', '{{ $jStr }}')"
                                                :class="bagianWaktuAcara('waktu_mulai', 'jam') === '{{ $jStr }}' ? 'bg-sage text-white font-semibold' : 'text-charcoal/80 hover:bg-champagne/15'"
                                                class="w-full rounded-lg py-1.5 text-center text-xs tabular-nums transition cursor-pointer"
                                            >{{ $jStr }}</button>
                                        @endfor
                                    </div>
                                </div>
                                <div class="p-1.5">
                                    <p class="pb-1 text-center text-[10px] font-bold uppercase tracking-wider text-charcoal/45">Menit</p>
                                    <div x-ref="mulaiMenitList" class="max-h-44 overflow-y-auto space-y-0.5 pr-0.5">
                                        @for ($m = 0; $m < 60; $m++)
                                            @php $mStr = str_pad((string) $m, 2, '0', STR_PAD_LEFT); @endphp
                                            <button
                                                type="button"
                                                data-menit="{{ $mStr }}"
                                                @click="aturBagianWaktuAcara('waktu_mulai', 'menit', '{{ $mStr }}')"
                                                :class="bagianWaktuAcara('waktu_mulai', 'menit') === '{{ $mStr }}' ? 'bg-sage text-white font-semibold' : 'text-charcoal/80 hover:bg-champagne/15'"
                                                class="w-full rounded-lg py-1.5 text-center text-xs tabular-nums transition cursor-pointer"
                                            >{{ $mStr }}</button>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between gap-1 bg-ivory/70 px-2.5 py-1.5 border-t border-champagne/15">
                                <div class="flex items-center gap-1">
                                    <button type="button" @click="formAcara.waktu_mulai = '08:00'; tutupPickerAcara()" class="rounded-md bg-white px-1.5 py-0.5 text-[10px] font-semibold text-charcoal/70 ring-1 ring-champagne/30 hover:text-sage cursor-pointer">08:00</button>
                                    <button type="button" @click="formAcara.waktu_mulai = '11:00'; tutupPickerAcara()" class="rounded-md bg-white px-1.5 py-0.5 text-[10px] font-semibold text-charcoal/70 ring-1 ring-champagne/30 hover:text-sage cursor-pointer">11:00</button>
                                </div>
                                <button type="button" @click="tutupPickerAcara()" class="rounded-lg bg-sage px-2.5 py-1 text-[11px] font-semibold text-white hover:bg-sage/90 cursor-pointer">Selesai</button>
                            </div>
                        </div>
                    </div>

                    {{-- Jam Selesai --}}
                    <div
                        class="relative"
                        @click.outside="if (pickerAcaraAktif === 'selesai') tutupPickerAcara()"
                    >
                        <label class="block text-xs font-semibold text-charcoal/80">Selesai</label>
                        <input type="hidden" name="waktu_selesai" :value="formAcara.waktu_selesai">
                        <button
                            type="button"
                            x-ref="acaraSelesaiTrigger"
                            data-picker-acara="selesai"
                            @click="togglePickerAcara('selesai')"
                            :class="pickerAcaraAktif === 'selesai' ? 'border-champagne ring-[3px] ring-champagne/15' : 'border-charcoal/15 hover:border-champagne/60'"
                            class="mt-1 h-[38px] w-full rounded-xl border bg-white px-2.5 flex items-center justify-between gap-1.5 text-left text-[13px] transition cursor-pointer"
                        >
                            <span class="flex items-center gap-1.5 min-w-0">
                                <svg class="h-3.5 w-3.5 text-sage/75 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                <span
                                    class="tabular-nums truncate"
                                    :class="formAcara.waktu_selesai ? 'font-medium text-charcoal' : 'text-charcoal/45'"
                                    x-text="formAcara.waktu_selesai || '--:--'"
                                >--:--</span>
                            </span>
                            <svg :class="pickerAcaraAktif === 'selesai' ? 'rotate-180 text-champagne' : 'text-charcoal/50'" class="h-3 w-3 shrink-0 transition-transform duration-150" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                        </button>

                        <div
                            x-show="pickerAcaraAktif === 'selesai'"
                            x-cloak
                            x-transition.opacity.duration.150ms
                            class="absolute left-1/2 -translate-x-1/2 top-full mt-1.5 z-40 w-[214px] rounded-xl border border-champagne/35 bg-white shadow-[0_14px_32px_-8px_rgba(31,41,55,0.18),0_4px_10px_-4px_rgba(31,41,55,0.08)] overflow-hidden"
                        >
                            <div class="flex items-center justify-between bg-ivory px-3 py-2 border-b border-champagne/20">
                                <span class="text-[11px] font-semibold text-charcoal/70">Jam Selesai</span>
                                <span class="rounded-md bg-sage/10 px-2 py-0.5 text-xs font-bold text-sage tabular-nums" x-text="formAcara.waktu_selesai || '--:--'"></span>
                            </div>
                            <div class="grid grid-cols-2 divide-x divide-champagne/15">
                                <div class="p-1.5">
                                    <p class="pb-1 text-center text-[10px] font-bold uppercase tracking-wider text-charcoal/45">Jam</p>
                                    <div x-ref="selesaiJamList" class="max-h-44 overflow-y-auto space-y-0.5 pr-0.5">
                                        @for ($j = 0; $j < 24; $j++)
                                            @php $jStr = str_pad((string) $j, 2, '0', STR_PAD_LEFT); @endphp
                                            <button
                                                type="button"
                                                data-jam="{{ $jStr }}"
                                                @click="aturBagianWaktuAcara('waktu_selesai', 'jam', '{{ $jStr }}')"
                                                :class="bagianWaktuAcara('waktu_selesai', 'jam') === '{{ $jStr }}' ? 'bg-sage text-white font-semibold' : 'text-charcoal/80 hover:bg-champagne/15'"
                                                class="w-full rounded-lg py-1.5 text-center text-xs tabular-nums transition cursor-pointer"
                                            >{{ $jStr }}</button>
                                        @endfor
                                    </div>
                                </div>
                                <div class="p-1.5">
                                    <p class="pb-1 text-center text-[10px] font-bold uppercase tracking-wider text-charcoal/45">Menit</p>
                                    <div x-ref="selesaiMenitList" class="max-h-44 overflow-y-auto space-y-0.5 pr-0.5">
                                        @for ($m = 0; $m < 60; $m++)
                                            @php $mStr = str_pad((string) $m, 2, '0', STR_PAD_LEFT); @endphp
                                            <button
                                                type="button"
                                                data-menit="{{ $mStr }}"
                                                @click="aturBagianWaktuAcara('waktu_selesai', 'menit', '{{ $mStr }}')"
                                                :class="bagianWaktuAcara('waktu_selesai', 'menit') === '{{ $mStr }}' ? 'bg-sage text-white font-semibold' : 'text-charcoal/80 hover:bg-champagne/15'"
                                                class="w-full rounded-lg py-1.5 text-center text-xs tabular-nums transition cursor-pointer"
                                            >{{ $mStr }}</button>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between gap-1 bg-ivory/70 px-2.5 py-1.5 border-t border-champagne/15">
                                <button type="button" @click="formAcara.waktu_selesai = ''; tutupPickerAcara()" class="text-[11px] font-medium text-charcoal/60 hover:text-rose-600 transition cursor-pointer">Kosongkan</button>
                                <button type="button" @click="tutupPickerAcara()" class="rounded-lg bg-sage px-2.5 py-1 text-[11px] font-semibold text-white hover:bg-sage/90 cursor-pointer">Selesai</button>
                            </div>
                        </div>
                    </div>

                    {{-- Zona Waktu (Select2) --}}
                    <div>
                        <label class="block text-xs font-semibold text-charcoal/80">Zona</label>
                        <select
                            x-ref="acaraZonaSelect"
                            name="zona_waktu"
                            x-model="formAcara.zona_waktu"
                            data-select2-variant="white-compact"
                            data-select2-search="false"
                            class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-2 py-2 text-sm"
                        >
                            <option value="WIB">WIB</option>
                            <option value="WITA">WITA</option>
                            <option value="WIT">WIT</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-charcoal/80">Nama Tempat / Gedung</label>
                    <input type="text" name="nama_tempat" x-model="formAcara.nama_tempat" required placeholder="Masjid Agung / Hotel..." class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-sage focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-charcoal/80">Alamat Lengkap</label>
                    <textarea name="alamat_lengkap" rows="2" required placeholder="Jl. Raya Merdeka No. 10, Kecamatan, Kota..." x-model="formAcara.alamat_lengkap" class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-sage focus:outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-charcoal/80">Link Google Maps <span class="font-normal text-charcoal/45">(Opsional)</span></label>
                    <input type="url" name="link_maps" x-model="formAcara.link_maps" placeholder="https://maps.google.com/..." class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-sage focus:outline-none">
                </div>

                <button
                    type="submit"
                    :disabled="sedangSimpanAcara"
                    class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-sage px-5 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 disabled:opacity-60 transition cursor-pointer shadow-xs"
                >
                    <svg x-show="sedangSimpanAcara" x-cloak class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" />
                        <path class="opacity-85" d="M12 2a10 10 0 0 1 10 10" />
                    </svg>
                    <span x-text="sedangSimpanAcara ? (acaraEdit ? 'Memperbarui...' : 'Menambahkan...') : (acaraEdit ? 'Perbarui Acara' : '+ Tambah Acara')"></span>
                </button>
            </form>
        </div>

        {{-- Daftar Kartu Rangkaian Acara --}}
        <div class="space-y-2.5">
            <div class="flex items-center justify-between px-1">
                <h3 class="font-sans text-xs font-bold uppercase tracking-wider text-charcoal/65">
                    Daftar Jadwal Terpasang
                    <span
                        class="ml-1 inline-flex items-center rounded-full bg-sage/10 px-2 py-0.5 font-sans tabular-nums text-[10px] font-bold tracking-normal text-sage"
                        x-text="daftarAcara.length + ' Acara'"
                    >
                        {{ $undangan->daftarAcara->count() }} Acara
                    </span>
                </h3>
            </div>

            <div class="grid grid-cols-1 gap-3">
                <template x-for="(acara, idx) in daftarAcara" :key="acara.id">
                    <article
                        :class="acaraEdit?.id === acara.id ? 'ring-2 ring-sage bg-sage/[0.02]' : 'ring-1 ring-champagne/25 bg-white'"
                        class="rounded-2xl p-3.5 shadow-xs space-y-2.5 transition"
                    >
                        <div class="flex items-start gap-3">
                            <div class="w-12 rounded-xl bg-sage text-white text-center overflow-hidden shrink-0 select-none">
                                <div class="bg-black/20 py-0.5 text-[9px] font-bold uppercase" x-text="acara.bulan_singkat"></div>
                                <div class="pt-1 font-sans tabular-nums text-lg font-bold leading-none" x-text="acara.hari_angka"></div>
                                <div class="pb-1 text-[9px] font-semibold text-[#F3E5AB]" x-text="acara.tahun"></div>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-champagne" x-text="acara.label_urutan || ('Acara #' + (idx + 1))"></span>
                                    <span
                                        class="rounded-full px-2 py-0.5 text-[10px] font-bold shrink-0"
                                        :class="acara.selisih_hari >= 0 ? 'bg-sage/10 text-sage' : 'bg-charcoal/10 text-charcoal/60'"
                                        x-text="acara.badge_hari"
                                    ></span>
                                </div>
                                <h4 class="font-sans text-sm font-bold text-charcoal truncate mt-0.5" x-text="acara.nama_acara"></h4>
                                <p class="text-[11px] text-charcoal/65 mt-0.5" x-text="acara.tanggal_label + ' · ' + acara.waktu_label"></p>
                                <p class="text-xs font-medium text-charcoal/85 mt-1" x-text="acara.nama_tempat"></p>
                                <p class="text-[11px] text-charcoal/60 line-clamp-2" x-text="acara.alamat_lengkap"></p>
                            </div>
                        </div>

                        <div class="pt-2 border-t border-champagne/15 flex items-center justify-between gap-2">
                            <span x-show="acaraEdit?.id === acara.id" x-cloak class="text-[11px] font-bold text-sage">Sedang diedit di atas</span>
                            <span x-show="acaraEdit?.id !== acara.id" class="text-[11px] text-charcoal/45">
                                <a x-show="acara.link_maps" :href="acara.link_maps" target="_blank" rel="noopener noreferrer" class="text-sage hover:underline font-medium">Buka Google Maps &nearr;</a>
                                <span x-show="!acara.link_maps">Siap tampil</span>
                            </span>

                            <div class="flex items-center gap-1.5">
                                <button
                                    type="button"
                                    @click="mulaiEditAcara(acara)"
                                    class="rounded-lg border border-champagne/60 bg-ivory/70 px-2.5 py-1 text-[11px] font-semibold text-charcoal hover:bg-champagne/15 transition cursor-pointer"
                                >
                                    Edit
                                </button>

                                <button
                                    type="button"
                                    :disabled="acaraHapusId === acara.id"
                                    @click="hapusAcara(acara)"
                                    class="rounded-lg border border-rose-200 bg-rose-50/70 px-2.5 py-1 text-[11px] font-semibold text-rose-700 hover:bg-rose-100 disabled:opacity-55 transition cursor-pointer"
                                    x-text="acaraHapusId === acara.id ? 'Menghapus...' : 'Hapus'"
                                ></button>
                            </div>
                        </div>
                    </article>
                </template>

                <div x-show="daftarAcara.length === 0" x-cloak class="rounded-2xl border border-dashed border-champagne/40 bg-ivory/40 p-6 text-center space-y-1">
                    <p class="text-sm font-bold text-charcoal">Belum Ada Jadwal Acara</p>
                    <p class="text-xs text-charcoal/60">Tambahkan Akad Nikah atau Resepsi di formulir atas.</p>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- ACCORDION 6: Dress Code (Panduan Busana & Palet Warna) --}}
<div
    :class="tab === 'dress_code' ? 'border-sage/45 ring-1 ring-sage/15 shadow-xs' : 'border-champagne/30 hover:border-champagne/60'"
    class="rounded-2xl border bg-white overflow-hidden transition"
>
    <div class="px-4 py-3.5 flex items-center justify-between gap-2 hover:bg-ivory/50 transition">
        <button
            type="button"
            data-mobile-tab="dress_code"
            @click="toggleBagian('dress_code')"
            class="flex-1 flex items-center justify-between gap-2 min-w-0 text-left cursor-pointer"
        >
            <span class="flex items-center gap-2.5 min-w-0">
                <svg
                    :class="tab === 'dress_code' ? 'rotate-90 text-sage' : 'text-charcoal/45'"
                    class="h-4 w-4 shrink-0 transition-transform duration-200"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                >
                    <path d="m9 18 6-6-6-6"/>
                </svg>
                <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-sage/12 text-[11px] font-bold text-sage shrink-0">6</span>
                <span class="font-sans text-sm font-semibold text-charcoal truncate" :class="!sakelarFitur.dress_code ? 'opacity-55' : ''">Dress Code</span>
            </span>
            <span class="rounded-full px-2 py-0.5 text-[11px] font-semibold shrink-0 {{ $adaDressCode ? 'bg-sage/12 text-sage' : 'bg-ivory text-charcoal/55 ring-1 ring-champagne/25' }}">
                {{ $adaDressCode ? 'Terisi' : 'Opsional' }}
            </span>
        </button>
        <button
            type="button"
            role="switch"
            data-toggle-fitur="dress_code"
            :aria-checked="sakelarFitur.dress_code ? 'true' : 'false'"
            :disabled="Boolean(fiturMenyimpan.dress_code)"
            @click.stop="toggleFitur('dress_code')"
            :class="sakelarFitur.dress_code ? 'bg-sage' : 'bg-charcoal/25'"
            class="relative inline-flex h-5 w-9 shrink-0 items-center rounded-full p-0.5 transition-colors cursor-pointer disabled:opacity-60"
            title="Tampilkan atau sembunyikan Dress Code"
            aria-label="Tampilkan Dress Code"
        >
            <span
                :class="sakelarFitur.dress_code ? 'translate-x-4' : 'translate-x-0'"
                class="pointer-events-none block h-4 w-4 rounded-full bg-white shadow-xs transition-transform"
            ></span>
        </button>
    </div>

    <section x-show="tab === 'dress_code'" x-cloak class="px-4 pb-5 pt-3 border-t border-champagne/20 space-y-4">
        <div x-show="!sakelarFitur.dress_code" x-cloak class="rounded-xl border border-amber-200 bg-amber-50/80 px-3 py-2 text-xs text-amber-800">
            Bagian <strong>Dress Code</strong> sedang disembunyikan. Nyalakan sakelar di kanan atas untuk menampilkannya.
        </div>
        <div
            data-bagian-utama="dress_code"
            x-data="{
                warnaList: @js(old('dress_code_warna', $undangan->dressCodeWarna())),
                tambahWarna(hex = '#D7BB83') { if (this.warnaList.length < 5) this.warnaList.push(hex); },
                hapusWarna(idx) { this.warnaList.splice(idx, 1); },
                pakaiPreset(daftar) { this.warnaList = [...daftar]; }
            }"
            class="rounded-2xl bg-ivory/75 p-4 ring-1 ring-champagne/25 space-y-3.5"
        >
            <div class="flex flex-wrap items-center justify-between gap-2">
                <h3 class="font-sans text-xs font-bold text-charcoal">Dress Code &amp; Palet Warna</h3>
                <div class="flex flex-wrap gap-1">
                    <button type="button" @click="pakaiPreset(['#472A1C', '#D7BB83', '#F5E9D6']); tandaiPerubahan(); $nextTick(() => jadwalkanLivePreview(true))" class="rounded-full bg-white px-2.5 py-0.5 text-[10px] font-semibold text-sage ring-1 ring-sage/25 hover:bg-sage hover:text-white transition cursor-pointer">Jawa Sogan</button>
                    <button type="button" @click="pakaiPreset(['#2F4F4F', '#C8A464', '#FDFBF7']); tandaiPerubahan(); $nextTick(() => jadwalkanLivePreview(true))" class="rounded-full bg-white px-2.5 py-0.5 text-[10px] font-semibold text-sage ring-1 ring-sage/25 hover:bg-sage hover:text-white transition cursor-pointer">Sage Ivory</button>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-charcoal/80">Catatan Busana <span class="font-normal text-charcoal/45">(Opsional)</span></label>
                <input
                    type="text"
                    name="dress_code_catatan"
                    value="{{ old('dress_code_catatan', $undangan->dressCodeCatatan()) }}"
                    placeholder="Contoh: Busana bernuansa Batik Sogan atau Krem Hangat"
                    class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none"
                >
            </div>

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
    </section>
</div>

{{-- ACCORDION 7: Live Streaming Pernikahan --}}
<div
    :class="tab === 'live_streaming' ? 'border-sage/45 ring-1 ring-sage/15 shadow-xs' : 'border-champagne/30 hover:border-champagne/60'"
    class="rounded-2xl border bg-white overflow-hidden transition"
>
    <input type="hidden" name="live_aktif" :value="sakelarFitur.live_streaming ? '1' : '0'">

    <div class="px-4 py-3.5 flex items-center justify-between gap-2 hover:bg-ivory/50 transition">
        <button
            type="button"
            data-mobile-tab="live_streaming"
            @click="toggleBagian('live_streaming')"
            class="flex-1 flex items-center justify-between gap-2 min-w-0 text-left cursor-pointer"
        >
            <span class="flex items-center gap-2.5 min-w-0">
                <svg
                    :class="tab === 'live_streaming' ? 'rotate-90 text-sage' : 'text-charcoal/45'"
                    class="h-4 w-4 shrink-0 transition-transform duration-200"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                >
                    <path d="m9 18 6-6-6-6"/>
                </svg>
                <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-sage/12 text-[11px] font-bold text-sage shrink-0">7</span>
                <span class="font-sans text-sm font-semibold text-charcoal truncate" :class="!sakelarFitur.live_streaming ? 'opacity-55' : ''">Live Streaming</span>
            </span>
            <span
                :class="sakelarFitur.live_streaming ? 'bg-sage/12 text-sage' : 'bg-ivory text-charcoal/55 ring-1 ring-champagne/25'"
                class="rounded-full px-2 py-0.5 text-[11px] font-semibold shrink-0"
                x-text="sakelarFitur.live_streaming ? 'Aktif' : 'Nonaktif'"
            >
                {{ $sakelarFiturAwal['live_streaming'] ? 'Aktif' : 'Nonaktif' }}
            </span>
        </button>
        <button
            type="button"
            role="switch"
            data-toggle-fitur="live_streaming"
            :aria-checked="sakelarFitur.live_streaming ? 'true' : 'false'"
            :disabled="Boolean(fiturMenyimpan.live_streaming)"
            @click.stop="toggleFitur('live_streaming')"
            :class="sakelarFitur.live_streaming ? 'bg-sage' : 'bg-charcoal/25'"
            class="relative inline-flex h-5 w-9 shrink-0 items-center rounded-full p-0.5 transition-colors cursor-pointer disabled:opacity-60"
            title="Aktifkan atau nonaktifkan Live Streaming"
            aria-label="Aktifkan Live Streaming"
        >
            <span
                :class="sakelarFitur.live_streaming ? 'translate-x-4' : 'translate-x-0'"
                class="pointer-events-none block h-4 w-4 rounded-full bg-white shadow-xs transition-transform"
            ></span>
        </button>
    </div>

    <section x-show="tab === 'live_streaming'" x-cloak class="px-4 pb-5 pt-3 border-t border-champagne/20 space-y-3.5">
        <div x-show="!sakelarFitur.live_streaming" x-cloak class="rounded-xl border border-amber-200 bg-amber-50/80 px-3 py-2 text-xs text-amber-800">
            <strong>Fitur Live Streaming Pernikahan</strong> sedang nonaktif. Nyalakan sakelar di kanan atas untuk menampilkannya di undangan.
        </div>

        <div data-bagian-utama="live_streaming" class="rounded-2xl bg-ivory/75 p-4 ring-1 ring-champagne/25 space-y-3">
            <div class="flex flex-wrap items-start justify-between gap-2">
                <div class="min-w-0">
                    <h3 class="font-sans text-xs font-bold text-charcoal">Fitur Live Streaming Pernikahan</h3>
                    <p class="text-[11px] text-charcoal/55 mt-0.5">Tautan siaran langsung bagi kerabat jauh yang belum dapat hadir langsung.</p>
                </div>
                <div class="flex flex-wrap gap-1 shrink-0">
                    @foreach (['YouTube Live', 'Instagram Live', 'Zoom'] as $presetLive)
                        <button
                            type="button"
                            @click="$refs.livePlatformInput.value = @js($presetLive); tandaiPerubahan(); jadwalkanLivePreview(true)"
                            class="rounded-full bg-white px-2.5 py-0.5 text-[10px] font-semibold text-sage ring-1 ring-sage/25 hover:bg-sage hover:text-white transition cursor-pointer"
                        >
                            {{ $presetLive }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-start" :class="!sakelarFitur.live_streaming ? 'opacity-65' : ''">
                <div class="space-y-1.5">
                    <label for="live_platform" class="block text-xs font-semibold text-charcoal/80">Platform</label>
                    <input
                        id="live_platform"
                        x-ref="livePlatformInput"
                        type="text"
                        name="live_platform"
                        value="{{ $pengaturan['live_streaming']['platform'] ?? 'Instagram / YouTube' }}"
                        class="w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none"
                    >
                </div>
                <div class="space-y-1.5">
                    <label for="live_link" class="block text-xs font-semibold text-charcoal/80">Link Live</label>
                    <input
                        id="live_link"
                        type="url"
                        name="live_link"
                        value="{{ $pengaturan['live_streaming']['link'] ?? '' }}"
                        placeholder="https://youtube.com/live/..."
                        class="w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none"
                    >
                </div>
            </div>
        </div>
    </section>
</div>

{{-- ACCORDION 8: Cerita Cinta (Seksi 7 Undangan) --}}
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
                <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-sage/12 text-[11px] font-bold text-sage shrink-0">8</span>
                <span class="font-sans text-sm font-semibold text-charcoal truncate" :class="!sakelarFitur.cerita_cinta ? 'opacity-55' : ''">Cerita Cinta</span>
            </span>
            <span class="rounded-full bg-ivory px-2 py-0.5 font-sans tabular-nums text-[11px] font-semibold text-sage ring-1 ring-champagne/25 shrink-0" x-text="jumlahCeritaTerisi() + ' Bab'"></span>
        </button>
        <button
            type="button"
            role="switch"
            data-toggle-fitur="cerita_cinta"
            :aria-checked="sakelarFitur.cerita_cinta ? 'true' : 'false'"
            :disabled="Boolean(fiturMenyimpan.cerita_cinta)"
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
                                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
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
                <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-sage/12 text-[11px] font-bold text-sage shrink-0">9</span>
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
            :disabled="Boolean(fiturMenyimpan.galeri)"
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
                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
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
