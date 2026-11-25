@php
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
                <form
                    action="{{ route('dashboard.undangan.perbarui', $undangan) }}"
                    method="POST"
                    class="space-y-3"
                    data-swal-loading
                    data-swal-loading-title="Menyimpan Teks Acara..."
                    data-swal-loading-text="Memperbarui judul hitung mundur dan judul bagian acara..."
                >
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="bagian" value="acara_teks">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="teks_judul_hitung_mundur" class="block text-xs font-semibold text-charcoal/80">Judul Hitung Mundur</label>
                            <input
                                id="teks_judul_hitung_mundur"
                                type="text"
                                name="teks[judul_hitung_mundur]"
                                value="{{ old('teks.judul_hitung_mundur', $teksKustom['judul_hitung_mundur'] ?? '') }}"
                                placeholder="Save The Date"
                                class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none"
                            >
                        </div>
                        <div>
                            <label for="teks_judul_acara" class="block text-xs font-semibold text-charcoal/80">Judul Bagian Acara</label>
                            <input
                                id="teks_judul_acara"
                                type="text"
                                name="teks[judul_acara]"
                                value="{{ old('teks.judul_acara', $teksKustom['judul_acara'] ?? '') }}"
                                placeholder="Rangkaian Acara"
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
                            placeholder="Merupakan kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir..."
                            class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm leading-relaxed focus:border-sage focus:outline-none"
                        >{{ old('teks.pengantar_hitung_mundur', $teksKustom['pengantar_hitung_mundur'] ?? '') }}</textarea>
                    </div>
                    <button type="submit" class="w-full rounded-xl bg-sage px-4 py-2 text-xs font-semibold text-white hover:bg-[#3b5047] transition cursor-pointer">
                        Simpan Teks Hitung Mundur &amp; Acara
                    </button>
                </form>
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
        <form
            action="{{ route('dashboard.undangan.perbarui', $undangan) }}"
            method="POST"
            class="space-y-3 pt-1"
            data-swal-loading
            data-swal-loading-title="Menyimpan Dress Code &amp; Live..."
            data-swal-loading-text="Memperbarui panduan busana dan siaran langsung..."
        >
            @csrf
            @method('PUT')
            <input type="hidden" name="bagian" value="acara_tambahan">
            <input type="hidden" name="dress_code_disertakan" value="1">
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
                                <button type="button" @click="pakaiPreset(['#472A1C', '#D7BB83', '#F5E9D6']); $nextTick(() => jadwalkanLivePreview(true))" class="rounded-full bg-white px-2 py-0.5 text-[10px] font-semibold text-sage ring-1 ring-sage/25 hover:bg-sage hover:text-white transition cursor-pointer">Jawa Sogan</button>
                                <button type="button" @click="pakaiPreset(['#2F4F4F', '#C8A464', '#FDFBF7']); $nextTick(() => jadwalkanLivePreview(true))" class="rounded-full bg-white px-2 py-0.5 text-[10px] font-semibold text-sage ring-1 ring-sage/25 hover:bg-sage hover:text-white transition cursor-pointer">Sage Ivory</button>
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
                                <button type="button" @click="tambahWarna(); $nextTick(() => jadwalkanLivePreview(true))" x-show="warnaList.length < 5" class="rounded-full bg-sage/10 px-2.5 py-0.5 text-[11px] font-semibold text-sage hover:bg-sage hover:text-white transition cursor-pointer">+ Warna</button>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <template x-for="(hex, idx) in warnaList" :key="idx">
                                    <div class="inline-flex items-center gap-1.5 rounded-full bg-white pl-1.5 pr-2 py-1 ring-1 ring-charcoal/15">
                                        <input type="color" :name="'dress_code_warna[' + idx + ']'" x-model="warnaList[idx]" class="h-5 w-5 rounded-full border-0 bg-transparent cursor-pointer p-0">
                                        <span class="font-mono text-[10px] font-semibold uppercase text-charcoal/75" x-text="hex"></span>
                                        <button type="button" @click="hapusWarna(idx); $nextTick(() => jadwalkanLivePreview(true))" class="text-charcoal/45 hover:text-rose-600 text-xs font-bold leading-none cursor-pointer" title="Hapus warna">&times;</button>
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
                                            @click="$refs.livePlatformInput.value = @js($presetLive); jadwalkanLivePreview(true)"
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

                    <button type="submit" class="w-full rounded-xl bg-sage px-4 py-2.5 text-xs font-semibold text-white hover:bg-[#3b5047] transition cursor-pointer">
                        Simpan Dress Code &amp; Live Streaming &rarr; Cerita Cinta
                    </button>
                </div>
            </div>
        </form>
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

        <form
            action="{{ route('dashboard.undangan.perbarui', $undangan) }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-4"
            data-swal-loading
            data-swal-loading-title="Menyimpan Cerita Cinta..."
            data-swal-loading-text="Menyimpan linimasa cerita dan foto bab..."
        >
            @csrf
            @method('PUT')
            <input type="hidden" name="bagian" value="cerita">

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
                        value="{{ old('teks.judul_cerita', $teksKustom['judul_cerita'] ?? '') }}"
                        placeholder="Cerita Cinta / Our Love Story"
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
                                <div class="flex flex-wrap items-center gap-2.5">
                                    <template x-if="item.foto_url">
                                        <div class="h-11 w-11 rounded-lg overflow-hidden ring-1 ring-champagne/45 shrink-0 bg-white">
                                            <img :src="item.foto_url" alt="Pratinjau foto bab" class="h-full w-full object-cover">
                                        </div>
                                    </template>
                                    <label class="inline-flex items-center gap-1.5 rounded-xl border border-charcoal/15 bg-white px-3 py-1.5 text-xs font-semibold text-charcoal/80 hover:border-sage hover:text-sage cursor-pointer transition">
                                        <span x-text="item.foto_url ? 'Ganti Foto Bab' : '+ Foto Bab (Opsional)'"></span>
                                        <input type="file" accept="image/jpeg,image/png,image/webp" :name="`cerita_cinta[${idx}][foto_file]`" @change="pilihFotoCerita(idx, $event)" class="sr-only">
                                    </label>
                                    <button type="button" x-show="item.foto_url" @click="hapusFotoCerita(idx)" class="text-xs font-semibold text-rose-600 hover:underline cursor-pointer">Hapus Foto</button>
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

            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-sage px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#3b5047] active:scale-[0.98] transition cursor-pointer">
                <span>Simpan Cerita &amp; Lanjut ke Galeri</span>
                <span aria-hidden="true">&rarr;</span>
            </button>
        </form>
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
            <span class="rounded-full bg-ivory px-2 py-0.5 font-sans tabular-nums text-[11px] font-semibold text-sage ring-1 ring-champagne/25 shrink-0">
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
                <form
                    action="{{ route('dashboard.undangan.perbarui', $undangan) }}"
                    method="POST"
                    class="flex items-end gap-2"
                    data-swal-loading
                    data-swal-loading-title="Menyimpan Judul Galeri..."
                    data-swal-loading-text="Memperbarui judul bagian galeri foto..."
                >
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="bagian" value="galeri">
                    <div class="flex-1 min-w-0">
                        <label for="teks_judul_galeri" class="block text-xs font-semibold text-charcoal/80">Judul Bagian Galeri</label>
                        <input
                            id="teks_judul_galeri"
                            type="text"
                            name="teks[judul_galeri]"
                            value="{{ old('teks.judul_galeri', $teksKustom['judul_galeri'] ?? '') }}"
                            placeholder="Our Gallery / Potret Kebahagiaan"
                            class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none"
                        >
                    </div>
                    <button type="submit" class="rounded-xl bg-sage px-4 py-2 text-xs font-semibold text-white hover:bg-[#3b5047] transition cursor-pointer shrink-0">Simpan</button>
                </form>
            </div>
        </div>

        {{-- Kuota Ringkas --}}
        <div class="rounded-xl bg-ivory p-3 ring-1 ring-champagne/25">
            <div class="flex items-center justify-between text-xs font-semibold text-charcoal">
                <span>Kuota Galeri Prewedding</span>
                <span class="text-sage font-bold">{{ $jumlahGaleri }}/10 Foto</span>
            </div>
            <div class="mt-2 h-1.5 w-full rounded-full bg-champagne/20 overflow-hidden">
                <div class="h-full rounded-full bg-gradient-to-r from-sage to-champagne transition-all duration-500" style="width: {{ $persenGaleri }}%"></div>
            </div>
        </div>

        {{-- Upload Galeri --}}
        <form
            action="{{ route('dashboard.galeri.unggah', $undangan) }}"
            method="POST"
            enctype="multipart/form-data"
            @submit="if (!$el.querySelector('input[type=file]')?.files?.length) { $event.preventDefault(); window.Swal?.fire({ icon: 'warning', title: 'Pilih Foto Dulu', text: 'Silakan pilih file foto prewedding yang ingin diunggah.', confirmButtonColor: '#4B6358' }); }"
            class="grid grid-cols-1 gap-3.5"
            data-swal-loading
            data-swal-loading-title="Mengunggah &amp; Mengompresi Foto..."
            data-swal-loading-text="Mengonversi foto galeri ke .webp dan menyimpannya..."
        >
            @csrf
            <div class="flex">
                @include('dashboard._input-foto-pratinjau', [
                    'name' => 'foto',
                    'varian' => 'galeri',
                    'label' => 'Pilih atau Seret Foto Prewedding',
                    'petunjuk' => 'JPG/PNG/WebP • Maks. 5 MB • Otomatis WebP',
                ])
            </div>

            <div class="rounded-2xl bg-ivory/75 ring-1 ring-champagne/25 p-3.5 space-y-2.5">
                <label for="keterangan_galeri" class="block text-xs font-semibold text-charcoal/80">
                    Keterangan Foto <span class="font-normal text-charcoal/45">(Opsional)</span>
                </label>
                <div class="flex flex-wrap gap-1">
                    @foreach (['Prewedding Outdoor', 'Momen Lamaran', 'Persiapan Akad', 'Senja Bersama'] as $saranKet)
                        <button
                            type="button"
                            @click="$refs.ketGaleriInput.value = @js($saranKet)"
                            class="rounded-full bg-white px-2.5 py-0.5 text-[11px] font-semibold text-sage ring-1 ring-sage/25 hover:bg-sage hover:text-white transition cursor-pointer"
                        >
                            + {{ $saranKet }}
                        </button>
                    @endforeach
                </div>
                <input
                    id="keterangan_galeri"
                    x-ref="ketGaleriInput"
                    type="text"
                    name="keterangan"
                    placeholder="Contoh: Sesi prewedding di Bandung"
                    class="w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-sage focus:outline-none"
                >
                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-sage px-5 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer shadow-xs">
                    <span>Unggah Foto (#{{ $jumlahGaleri + 1 }})</span>
                </button>
            </div>
        </form>

        @if ($undangan->daftarGaleri->isNotEmpty())
            <div class="pt-3 border-t border-champagne/20 space-y-3">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-charcoal/65">Foto Terunggah</h3>
                    <span class="text-[11px] text-charcoal/50">Klik foto untuk perbesar</span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                    @foreach ($undangan->daftarGaleri as $galeri)
                        <div class="group rounded-xl overflow-hidden bg-white ring-1 ring-champagne/25 shadow-xs flex flex-col">
                            <div
                                @click="galeriLightbox = { url: @js($galeri->urlFoto()), caption: @js($galeri->keterangan ?: 'Foto #'.$galeri->urutan) }"
                                class="relative aspect-[4/5] overflow-hidden bg-ivory cursor-zoom-in"
                            >
                                <img src="{{ $galeri->urlFoto() }}" alt="{{ $galeri->keterangan ?? 'Foto Galeri' }}" class="w-full h-full object-cover object-top transition duration-500 group-hover:scale-105">
                                <span class="absolute top-2 left-2 rounded-full bg-black/55 px-2 py-0.5 text-[10px] font-bold text-white">#{{ $galeri->urutan }}</span>
                            </div>
                            <div class="p-2 flex items-center justify-between gap-1.5 text-[11px] bg-white">
                                <span class="truncate font-medium text-charcoal/80">{{ $galeri->keterangan ?: 'Foto #'.$galeri->urutan }}</span>
                                <form
                                    action="{{ route('dashboard.galeri.hapus', [$undangan, $galeri]) }}"
                                    method="POST"
                                    data-swal-title="Hapus Foto Galeri?"
                                    data-swal-confirm="Yakin ingin menghapus foto ini dari galeri?"
                                    data-swal-icon="warning"
                                    data-swal-confirm-button="Ya, Hapus"
                                    data-swal-confirm-color="#DC2626"
                                    data-swal-loading-title="Menghapus Foto Galeri..."
                                    data-swal-loading-text="Menghapus foto dari galeri..."
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-md bg-rose-50 px-1.5 py-0.5 text-[10px] font-semibold text-rose-700 hover:bg-rose-100 cursor-pointer shrink-0">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
</div>
