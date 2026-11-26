@php
    $sampulDikustom = filled($teksKustom['sampul_judul'] ?? '')
        || filled($teksKustom['sampul_tombol'] ?? '')
        || filled($teksKustom['sampul_sapaan'] ?? '')
        || filled($teksKustom['sampul_catatan'] ?? '');
    $adaFotoSampul = filled($undangan->urlFotoSampulKhususDashboard());
    $adaFotoPembuka = filled($undangan->urlFotoPembukaKhususDashboard());
    $teksMempelaiDikustom = filled($teksKustom['judul_mempelai'] ?? '')
        || filled($teksKustom['pengantar_mempelai'] ?? '')
        || filled($teksKustom['label_pria'] ?? '')
        || filled($teksKustom['label_wanita'] ?? '');
@endphp

{{-- ACCORDION 1: Sampul & Tampilan Tema (Seksi 1 Undangan) --}}
<div
    :class="tab === 'tema' ? 'border-sage/45 ring-1 ring-sage/15 shadow-xs' : 'border-champagne/30 hover:border-champagne/60'"
    class="rounded-2xl border bg-white overflow-hidden transition"
>
    <button
        type="button"
        data-mobile-tab="tema"
        @click="toggleBagian('tema')"
        class="w-full px-4 py-3.5 flex items-center justify-between gap-3 text-left cursor-pointer hover:bg-ivory/50 transition"
    >
        <div class="flex items-center gap-2.5 min-w-0">
            <svg
                :class="tab === 'tema' ? 'rotate-90 text-sage' : 'text-charcoal/45'"
                class="h-4 w-4 shrink-0 transition-transform duration-200"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
            >
                <path d="m9 18 6-6-6-6"/>
            </svg>
            <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-sage/12 text-[11px] font-bold text-sage shrink-0">1</span>
            <span class="font-sans text-sm font-semibold text-charcoal truncate">Sampul &amp; Tampilan Tema</span>
        </div>
        <span class="text-[11px] font-medium text-charcoal/50 truncate max-w-[130px]">{{ $temaAktifEditor?->nama_tema }}</span>
    </button>

    <section x-show="tab === 'tema'" x-cloak class="px-4 pb-5 pt-3 border-t border-champagne/20">
        <div class="pb-3 mb-3 border-b border-champagne/15">
            <h2 class="font-sans text-lg sm:text-2xl font-bold text-charcoal tracking-tight">Tema, Musik &amp; Pengaturan Link</h2>
            <p class="mt-0.5 text-xs text-charcoal/60">Layar pertama undangan: pilih tema, link, musik, foto sampul, dan teks gerbang pembuka.</p>
        </div>

        <div data-bagian-utama="tema" class="space-y-4">
            <audio x-ref="audioPreview" @ended="audioSedangPutar = false" class="hidden" preload="none"></audio>

            {{-- Tema & Link --}}
            <div class="rounded-2xl bg-ivory/65 p-4 ring-1 ring-champagne/20 space-y-3.5">
                <div>
                    <input type="hidden" name="tema_id" value="{{ $undangan->tema_id }}">
                    <div class="flex items-center justify-between gap-2 mb-1.5">
                        <span class="block text-xs font-semibold text-charcoal/80">Tema Undangan</span>
                        @if ($temaTerkunciClient)
                            <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2 py-0.5 text-[10px] font-semibold text-amber-700 ring-1 ring-amber-200">
                                {{ $sedangVerifikasiEditor ? 'Terkunci (Verifikasi)' : 'Terkunci (Aktif)' }}
                            </span>
                        @elseif (auth()->user()->adalahAdmin() && $undangan->temaTerkunciUntukClient())
                            <span class="inline-flex items-center gap-1 rounded-full bg-sage/10 px-2 py-0.5 text-[10px] font-semibold text-sage ring-1 ring-sage/25">
                                Mode Admin
                            </span>
                        @endif
                    </div>

                    <div class="rounded-xl bg-white p-2.5 ring-1 {{ $temaTerkunciClient ? 'ring-amber-200/80' : 'ring-champagne/30' }} flex items-center gap-3">
                        @if ($temaAktifEditor)
                            <div class="h-14 w-14 rounded-lg overflow-hidden shrink-0 ring-1 ring-champagne/25 bg-ivory">
                                <x-poster-sampul-tema :tema="$temaAktifEditor" />
                            </div>
                        @endif

                        <div class="min-w-0 flex-1">
                            <span class="inline-flex items-center rounded-full bg-ivory px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-[#8A6D33] ring-1 ring-champagne/35">
                                {{ $temaAktifEditor?->kategoriLabel() }}
                            </span>
                            <p class="mt-0.5 font-sans text-sm font-bold text-charcoal truncate">
                                {{ $temaAktifEditor?->nama_tema ?? 'Rustic Floral' }}
                            </p>
                            <div class="flex flex-wrap items-center gap-x-1.5 font-sans tabular-nums text-xs">
                                @if ($temaAktifEditor?->adaDiskon())
                                    <span class="text-charcoal/45 line-through text-[11px]">{{ $temaAktifEditor->hargaAsliFormatted() }}</span>
                                @endif
                                <span class="font-bold text-sage">{{ $temaAktifEditor?->hargaFormatted() }}</span>
                            </div>
                        </div>

                        <div class="shrink-0">
                            @if ($bolehGantiTema)
                                <button
                                    type="button"
                                    @click="bukaDrawerTema()"
                                    data-buka-drawer-tema
                                    class="inline-flex items-center gap-1.5 rounded-xl bg-[#3B4F45] px-3 py-2 text-xs font-semibold text-white hover:bg-sage active:scale-95 transition cursor-pointer"
                                >
                                    <span>Ganti</span>
                                </button>
                            @else
                                <a
                                    href="{{ $urlWaGantiTema }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-1 rounded-xl bg-amber-50 px-2.5 py-2 text-[11px] font-semibold text-amber-800 ring-1 ring-amber-200 hover:bg-amber-100 transition"
                                >
                                    <span>Hubungi Admin</span>
                                </a>
                            @endif
                        </div>
                    </div>

                    @if ($temaTerkunciClient)
                        <p class="mt-1.5 text-[11px] text-amber-700 leading-relaxed">{{ $alasanTemaTerkunci }}</p>
                    @endif
                </div>

                <div>
                    <div class="flex items-center justify-between gap-2 mb-1">
                        <label for="slug" class="block text-xs font-semibold text-charcoal/80">Link Undangan</label>
                        @if ($undangan->status_publikasi && ! auth()->user()->adalahAdmin())
                            <span class="inline-flex items-center rounded-full bg-amber-50 px-2 py-0.5 text-[10px] font-semibold text-amber-700 ring-1 ring-amber-200">Terkunci</span>
                        @endif
                    </div>
                    <div class="flex items-center rounded-xl border border-charcoal/15 bg-white px-3 py-2 focus-within:border-sage focus-within:ring-2 focus-within:ring-sage/15 transition">
                        <span class="text-xs text-charcoal/45 select-none shrink-0">sesitemu.id/</span>
                        <input
                            id="slug"
                            name="slug"
                            type="text"
                            value="{{ old('slug', $undangan->slug) }}"
                            @if ($undangan->status_publikasi && ! auth()->user()->adalahAdmin()) readonly @endif
                            class="w-full min-w-0 bg-transparent text-sm font-semibold text-charcoal focus:outline-none ml-0.5 @if($undangan->status_publikasi && ! auth()->user()->adalahAdmin()) text-charcoal/60 cursor-not-allowed @endif"
                        >
                        <button
                            type="button"
                            @click="navigator.clipboard?.writeText(urlPublikSalin || @js($urlPublik)); slugTersalin = true; setTimeout(() => slugTersalin = false, 2000)"
                            :class="slugTersalin ? 'bg-sage text-white ring-sage' : 'bg-ivory text-charcoal/75 ring-champagne/30 hover:text-sage'"
                            class="ml-2 rounded-lg px-2.5 py-1 text-[11px] font-semibold ring-1 transition shrink-0 cursor-pointer"
                            x-text="slugTersalin ? 'Tersalin!' : 'Salin'"
                        ></button>
                    </div>
                </div>
            </div>

            {{-- Font & Musik Latar --}}
            <div class="rounded-2xl bg-ivory/65 p-4 ring-1 ring-champagne/20 space-y-3.5">
                <div>
                    <label for="gaya_font" class="block text-xs font-semibold text-charcoal/80 mb-1">Gaya Huruf (Font)</label>
                    <select
                        id="gaya_font"
                        name="gaya_font"
                        data-select2-variant="white"
                        data-select2-search="true"
                        class="w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-sage focus:outline-none"
                    >
                        @foreach ($daftarGayaFont as $kodeFont => $infoFont)
                            <option value="{{ $kodeFont }}" @selected($undangan->kodeGayaFontTerpilih() === $kodeFont)>
                                {{ $infoFont['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2.5">
                    <div class="flex items-center justify-between gap-2">
                        <label for="musik_latar" class="block text-xs font-semibold text-charcoal/80">Musik Latar</label>
                        <div class="inline-flex items-center rounded-lg bg-white p-0.5 ring-1 ring-champagne/30">
                            <button
                                type="button"
                                @click="ubahModeMusik('katalog')"
                                :class="modeMusik === 'katalog' ? 'bg-sage text-white shadow-2xs' : 'text-charcoal/65 hover:text-charcoal'"
                                class="rounded-md px-2.5 py-1 text-[11px] font-semibold transition cursor-pointer"
                            >
                                Katalog
                            </button>
                            <button
                                type="button"
                                @click="ubahModeMusik('kustom')"
                                :class="modeMusik === 'kustom' ? 'bg-sage text-white shadow-2xs' : 'text-charcoal/65 hover:text-charcoal'"
                                class="rounded-md px-2.5 py-1 text-[11px] font-semibold transition cursor-pointer"
                            >
                                Musik Sendiri
                            </button>
                        </div>
                    </div>

                    <input type="hidden" name="sumber_musik" :value="modeMusik">
                    <input type="hidden" name="hapus_musik_kustom" :value="hapusMusikKustom ? '1' : '0'">
                    <input
                        id="file_musik_kustom"
                        x-ref="inputMusikKustom"
                        type="file"
                        name="file_musik_kustom"
                        accept=".mp3,.wav,.ogg,.m4a,audio/mpeg,audio/wav,audio/ogg,audio/mp4,audio/x-m4a"
                        @change="saatPilihMusikKustom($event)"
                        class="sr-only"
                    >

                    {{-- Mode 1: Pilih dari Katalog Musik --}}
                    <div x-show="modeMusik === 'katalog'" class="space-y-2">
                        <select
                            id="musik_latar"
                            name="musik_latar"
                            x-model="musikDipilih"
                            @change="hentikanAudioPreview()"
                            data-select2-variant="white"
                            data-select2-search="true"
                            class="w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-sage focus:outline-none"
                        >
                            <option value="">-- Tanpa Musik Latar --</option>
                            @foreach ($daftarMusik as $musik)
                                <option value="{{ $musik['path'] }}" @selected(! $pakaiMusikKustom && $undangan->musik_latar === $musik['path'])>
                                    {{ $musik['label'] }}
                                </option>
                            @endforeach
                        </select>

                        <div x-show="urlMusikAktif()" x-cloak class="flex items-center justify-between gap-2 rounded-xl bg-white px-3 py-1.5 ring-1 ring-champagne/25">
                            <span class="text-[11px] font-medium text-charcoal/70 truncate" x-text="audioSedangPutar ? 'Memutar contoh lagu...' : 'Coba dengarkan musik pilihan'"></span>
                            <button
                                type="button"
                                @click="toggleAudioPreview()"
                                :class="audioSedangPutar ? 'bg-charcoal text-white' : 'bg-sage/12 text-sage hover:bg-sage hover:text-white'"
                                class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1 text-[11px] font-semibold transition shrink-0 cursor-pointer"
                            >
                                <span x-text="audioSedangPutar ? 'Berhenti' : 'Putar'"></span>
                            </button>
                        </div>
                    </div>

                    {{-- Mode 2: Unggah & Gunakan Musik Sendiri --}}
                    <div x-show="modeMusik === 'kustom'" x-cloak class="space-y-2">
                        <div x-show="namaMusikKustomTampil()" class="rounded-xl bg-white p-3 ring-1 ring-champagne/30 space-y-2.5">
                            <div class="flex items-center justify-between gap-2.5">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-sage/12 text-sage">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M9 18V5l12-2v13"/>
                                            <circle cx="6" cy="18" r="3"/>
                                            <circle cx="18" cy="16" r="3"/>
                                        </svg>
                                    </span>
                                    <div class="min-w-0">
                                        <p class="text-xs font-semibold text-charcoal truncate" x-text="namaMusikKustomTampil()"></p>
                                        <p class="text-[11px] text-charcoal/55 truncate" x-text="musikKustomUkuranBaru ? (musikKustomUkuranBaru + ' • Klik Simpan untuk menerapkan') : 'Musik sendiri terpasang'"></p>
                                    </div>
                                </div>
                                <button
                                    type="button"
                                    x-show="urlMusikAktif()"
                                    @click="toggleAudioPreview()"
                                    :class="audioSedangPutar ? 'bg-charcoal text-white' : 'bg-sage/12 text-sage hover:bg-sage hover:text-white'"
                                    class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1.5 text-[11px] font-semibold transition shrink-0 cursor-pointer"
                                >
                                    <span x-text="audioSedangPutar ? 'Berhenti' : 'Putar'"></span>
                                </button>
                            </div>

                            <div class="flex flex-wrap items-center justify-between gap-2 pt-2 border-t border-champagne/20">
                                <label
                                    for="file_musik_kustom"
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-ivory px-2.5 py-1 text-[11px] font-semibold text-charcoal/80 ring-1 ring-champagne/35 hover:text-sage transition cursor-pointer"
                                >
                                    <span>Ganti File Audio</span>
                                </label>
                                <button
                                    type="button"
                                    x-show="musikKustomPreviewUrl"
                                    @click="batalkanMusikKustomBaru()"
                                    class="rounded-lg bg-rose-50 px-2.5 py-1 text-[11px] font-semibold text-rose-700 hover:bg-rose-100 transition cursor-pointer"
                                >
                                    Batalkan
                                </button>
                                <button
                                    type="button"
                                    x-show="!musikKustomPreviewUrl && musikKustomUrlAwal"
                                    @click="tandaiHapusMusikKustom()"
                                    class="rounded-lg bg-rose-50 px-2.5 py-1 text-[11px] font-semibold text-rose-700 hover:bg-rose-100 transition cursor-pointer"
                                >
                                    Hapus Musik
                                </button>
                            </div>
                        </div>

                        <label
                            for="file_musik_kustom"
                            x-show="!namaMusikKustomTampil()"
                            class="block rounded-xl border-2 border-dashed border-champagne/50 bg-white/85 hover:border-sage/60 hover:bg-white p-4 text-center cursor-pointer transition"
                        >
                            <div class="mx-auto mb-2 flex h-9 w-9 items-center justify-center rounded-xl bg-sage/10 text-sage">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M9 18V5l12-2v13"/>
                                    <circle cx="6" cy="18" r="3"/>
                                    <circle cx="18" cy="16" r="3"/>
                                </svg>
                            </div>
                            <p class="text-xs font-semibold text-charcoal">Unggah Musik Sendiri</p>
                            <p class="mt-0.5 text-[11px] text-charcoal/55">Format MP3, M4A, WAV, atau OGG • Maks. 15 MB</p>
                            <span class="mt-2.5 inline-flex items-center rounded-lg bg-sage/10 px-3 py-1 text-[11px] font-semibold text-sage">
                                Pilih File Audio
                            </span>
                        </label>

                        <div
                            x-show="hapusMusikKustom && !musikKustomPreviewUrl && musikKustomUrlAwal"
                            x-cloak
                            class="flex items-center justify-between gap-2 rounded-xl border border-rose-200 bg-rose-50/80 px-3 py-2 text-xs text-rose-700"
                        >
                            <span class="font-medium">Musik sendiri akan dihapus saat disimpan.</span>
                            <button type="button" @click="batalHapusMusikKustom()" class="font-bold text-rose-800 hover:underline shrink-0 cursor-pointer">Urungkan</button>
                        </div>

                        <p x-show="pesanGalatMusik" x-cloak x-text="pesanGalatMusik" class="text-xs font-medium text-rose-600"></p>
                        @error('file_musik_kustom')
                            <p class="text-xs font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Mode Tanpa Foto --}}
            <div
                :class="tanpaFotoAktif ? 'border-champagne bg-champagne/10' : 'border-champagne/25 bg-ivory/65'"
                class="flex items-center justify-between gap-3 rounded-2xl border px-3.5 py-3 transition"
            >
                <div class="min-w-0">
                    <div class="flex items-center gap-2">
                        <span class="text-xs sm:text-[13px] font-bold text-charcoal">Mode Tanpa Foto</span>
                        <span
                            :class="tanpaFotoAktif ? 'bg-champagne/25 text-[#755A22]' : 'bg-charcoal/8 text-charcoal/55'"
                            class="rounded-full px-2 py-0.5 text-[10px] font-bold uppercase"
                            x-text="tanpaFotoAktif ? 'Aktif' : 'Nonaktif'"
                        ></span>
                    </div>
                    <p class="mt-0.5 text-[11px] text-charcoal/60 leading-snug">Ganti semua foto mempelai &amp; galeri dengan inisial elegan.</p>
                </div>
                <button
                    type="button"
                    role="switch"
                    :aria-checked="tanpaFotoAktif ? 'true' : 'false'"
                    @click="tanpaFotoAktif = !tanpaFotoAktif"
                    :class="tanpaFotoAktif ? 'bg-sage' : 'bg-charcoal/25'"
                    class="relative inline-flex h-6 w-11 shrink-0 items-center rounded-full p-0.5 transition-colors cursor-pointer"
                    aria-label="Aktifkan Mode Tanpa Foto"
                >
                    <span
                        :class="tanpaFotoAktif ? 'translate-x-5' : 'translate-x-0'"
                        class="pointer-events-none block h-5 w-5 rounded-full bg-white shadow-xs transition-transform"
                    ></span>
                </button>
                <input type="hidden" name="tanpa_foto" :value="tanpaFotoAktif ? '1' : '0'">
            </div>

            {{-- Drawer Lipat 1: Foto Sampul Depan --}}
            <div x-data="{ buka: false }" class="rounded-2xl border border-champagne/30 bg-ivory/50 overflow-hidden">
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
                        <span class="text-xs font-semibold text-charcoal truncate">Foto Sampul Depan</span>
                    </span>
                    <span class="flex items-center gap-1.5 shrink-0">
                        <span class="rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $adaFotoSampul ? 'bg-sage/12 text-sage' : 'bg-white text-charcoal/50 ring-1 ring-champagne/30' }}">
                            {{ $adaFotoSampul ? 'Terisi' : 'Bawaan' }}
                        </span>
                        <svg :class="buka ? 'rotate-180 text-sage' : 'text-charcoal/45'" class="h-3.5 w-3.5 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </span>
                </button>
                <div x-show="buka" x-cloak class="px-3.5 pb-4 pt-3 border-t border-champagne/20 bg-white/80">
                    @include('dashboard._input-foto-pratinjau', [
                        'name' => 'foto_sampul',
                        'varian' => 'sampul',
                        'label' => 'Foto Sampul Depan',
                        'petunjuk' => 'Rasio template: '.$rasioFotoTema['foto_sampul']['label'].' • Bisa dipotong saat unggah',
                        'urlAwal' => $undangan->urlFotoSampulKhususDashboard(),
                        'hapusNama' => 'hapus_foto_sampul',
                        'hapusLabel' => 'Hapus foto sampul khusus',
                    ])
                </div>
            </div>

            {{-- Drawer Lipat 2: Ubah Teks Sampul --}}
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
                        <span class="text-xs font-semibold text-charcoal truncate">Ubah Teks Sampul</span>
                    </span>
                    <span class="flex items-center gap-1.5 shrink-0">
                        <span class="rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $sampulDikustom ? 'bg-sage/12 text-sage' : 'bg-white text-charcoal/50 ring-1 ring-champagne/30' }}">
                            {{ $sampulDikustom ? 'Dikustom' : 'Bawaan' }}
                        </span>
                        <svg :class="buka ? 'rotate-180 text-sage' : 'text-charcoal/45'" class="h-3.5 w-3.5 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </span>
                </button>
                <div x-show="buka" x-cloak class="px-3.5 pb-3.5 pt-2.5 border-t border-champagne/20 bg-white/80 space-y-3">
                    <p class="text-[11px] text-charcoal/55">Sudah terisi teks bawaan tema — ubah seperlunya atau kosongkan untuk kembali ke bawaan.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="teks_sampul_judul" class="block text-xs font-semibold text-charcoal/80">Label Atas Sampul</label>
                            <input
                                id="teks_sampul_judul"
                                type="text"
                                name="teks[sampul_judul]"
                                value="{{ $nilaiTeksEditor('sampul_judul') }}"
                                placeholder="{{ $teksBawaanTema['sampul_judul'] ?: 'The Wedding of / Walimatul Ursy' }}"
                                class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none"
                            >
                        </div>
                        <div>
                            <label for="teks_sampul_tombol" class="block text-xs font-semibold text-charcoal/80">Teks Tombol</label>
                            <input
                                id="teks_sampul_tombol"
                                type="text"
                                name="teks[sampul_tombol]"
                                value="{{ $nilaiTeksEditor('sampul_tombol') }}"
                                placeholder="{{ $teksBawaanTema['sampul_tombol'] ?: 'Buka Undangan' }}"
                                class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none"
                            >
                        </div>
                    </div>
                    <div>
                        <label for="teks_sampul_sapaan" class="block text-xs font-semibold text-charcoal/80">Sapaan Tamu</label>
                        <input
                            id="teks_sampul_sapaan"
                            type="text"
                            name="teks[sampul_sapaan]"
                            value="{{ $nilaiTeksEditor('sampul_sapaan') }}"
                            placeholder="{{ $teksBawaanTema['sampul_sapaan'] ?: 'Kepada Yth. Bapak/Ibu/Saudara/i' }}"
                            class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none"
                        >
                    </div>
                    <div>
                        <label for="teks_sampul_catatan" class="block text-xs font-semibold text-charcoal/80">Catatan Bawah Sampul</label>
                        <input
                            id="teks_sampul_catatan"
                            type="text"
                            name="teks[sampul_catatan]"
                            value="{{ $nilaiTeksEditor('sampul_catatan') }}"
                            placeholder="{{ $teksBawaanTema['sampul_catatan'] ?: 'Mohon maaf apabila ada kesalahan penulisan nama/gelar' }}"
                            class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none"
                        >
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- ACCORDION 2: Ayat Pembuka (Seksi 2 Undangan) --}}
<div
    :class="tab === 'ayat' ? 'border-sage/45 ring-1 ring-sage/15 shadow-xs' : 'border-champagne/30 hover:border-champagne/60'"
    class="rounded-2xl border bg-white overflow-hidden transition"
>
    <div class="px-4 py-3.5 flex items-center justify-between gap-2 hover:bg-ivory/50 transition">
        <button
            type="button"
            data-mobile-tab="ayat"
            @click="toggleBagian('ayat')"
            class="flex-1 flex items-center justify-between gap-2 min-w-0 text-left cursor-pointer"
        >
            <span class="flex items-center gap-2.5 min-w-0">
                <svg
                    :class="tab === 'ayat' ? 'rotate-90 text-sage' : 'text-charcoal/45'"
                    class="h-4 w-4 shrink-0 transition-transform duration-200"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                >
                    <path d="m9 18 6-6-6-6"/>
                </svg>
                <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-sage/12 text-[11px] font-bold text-sage shrink-0">2</span>
                <span class="font-sans text-sm font-semibold text-charcoal truncate" :class="!sakelarFitur.ayat_pembuka ? 'opacity-55' : ''">Ayat Pembuka</span>
            </span>
            @if ($tabSelesai['ayat'])
                <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-sage/12 text-sage shrink-0">
                    <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                </span>
            @endif
        </button>
        <button
            type="button"
            role="switch"
            data-toggle-fitur="ayat_pembuka"
            :aria-checked="sakelarFitur.ayat_pembuka ? 'true' : 'false'"
            :disabled="Boolean(fiturMenyimpan.ayat_pembuka)"
            @click.stop="toggleFitur('ayat_pembuka')"
            :class="sakelarFitur.ayat_pembuka ? 'bg-sage' : 'bg-charcoal/25'"
            class="relative inline-flex h-5 w-9 shrink-0 items-center rounded-full p-0.5 transition-colors cursor-pointer disabled:opacity-60"
            title="Tampilkan atau sembunyikan Ayat Pembuka"
            aria-label="Tampilkan Ayat Pembuka"
        >
            <span
                :class="sakelarFitur.ayat_pembuka ? 'translate-x-4' : 'translate-x-0'"
                class="pointer-events-none block h-4 w-4 rounded-full bg-white shadow-xs transition-transform"
            ></span>
        </button>
    </div>

    <section x-show="tab === 'ayat'" x-cloak class="px-4 pb-5 pt-3 border-t border-champagne/20 space-y-4">
        <div x-show="!sakelarFitur.ayat_pembuka" x-cloak class="rounded-xl border border-amber-200 bg-amber-50/80 px-3 py-2 text-xs text-amber-800">
            Bagian <strong>Ayat Pembuka</strong> sedang disembunyikan. Nyalakan sakelar di kanan atas untuk menampilkannya.
        </div>
        <div data-bagian-utama="ayat" class="rounded-2xl bg-ivory/75 p-4 ring-1 ring-champagne/25 space-y-4">
            {{-- Foto Pembuka / Seksi Ayat (Langsung Tampil) --}}
            <div class="space-y-2">
                <div class="flex items-center justify-between gap-2">
                    <span class="text-xs font-bold text-charcoal">Foto Pembuka / Seksi Ayat</span>
                    <span class="rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $adaFotoPembuka ? 'bg-sage/12 text-sage' : 'bg-white text-charcoal/50 ring-1 ring-champagne/30' }}">
                        {{ $adaFotoPembuka ? 'Terisi' : 'Opsional' }}
                    </span>
                </div>
                @include('dashboard._input-foto-pratinjau', [
                    'name' => 'foto_pembuka',
                    'varian' => 'sampul',
                    'label' => 'Foto Pembuka / Seksi Ayat',
                    'petunjuk' => 'Rasio template: '.$rasioFotoTema['foto_pembuka']['label'].' • Kosong = pakai Foto Sampul',
                    'urlAwal' => $undangan->urlFotoPembukaKhususDashboard(),
                    'hapusNama' => 'hapus_foto_pembuka',
                    'hapusLabel' => 'Hapus foto pembuka',
                ])
            </div>

            <div class="space-y-3 pt-1 border-t border-champagne/20">
                <div>
                    <label for="kutipan_ayat" class="block text-xs font-bold text-charcoal">Kutipan Ayat / Doa Pembuka</label>
                    <p class="text-[11px] text-charcoal/55 mt-0.5">Tampil tepat setelah sampul dibuka, sebelum profil mempelai.</p>
                </div>
                <div class="flex flex-wrap gap-1.5">
                    @foreach ([
                        'QS. Ar-Rum: 21' => 'Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu pasangan hidup dari jenismu sendiri, supaya kamu merasa tenteram di sampingnya. (QS. Ar-Rum: 21)',
                        'Doa Barakallahu' => 'Baarakallahu laka wa baaraka ‘alaika wa jama’a bainakuma fii khair. Semoga Allah menghimpun kami dalam keberkahan dan kebaikan.',
                        'QS. Adz-Dzariyat: 49' => 'Dan segala sesuatu Kami ciptakan berpasang-pasangan supaya kamu mengingat kebesaran Allah. (QS. Adz-Dzariyat: 49)',
                        'Puitis Klasik' => 'Dua jiwa yang berjalan terpisah kini bertemu pada satu garis takdir yang sama, berjanji menjaga cinta di setiap musim kehidupan.',
                    ] as $judulTemplate => $isiTemplate)
                        <button
                            type="button"
                            @click="$refs.kutipanInput.value = @js($isiTemplate); tandaiPerubahan(); jadwalkanLivePreview(true)"
                            class="rounded-full bg-white px-2.5 py-1 text-[11px] font-semibold text-sage ring-1 ring-sage/25 hover:bg-sage hover:text-white transition cursor-pointer"
                        >
                            + {{ $judulTemplate }}
                        </button>
                    @endforeach
                </div>
                <textarea
                    x-ref="kutipanInput"
                    id="kutipan_ayat"
                    name="kutipan_ayat"
                    rows="3"
                    placeholder="Masukkan ayat suci, doa pernikahan, atau kata mutiara..."
                    class="w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2.5 text-sm leading-relaxed focus:border-sage focus:outline-none"
                >{{ old('kutipan_ayat', $undangan->kutipan_ayat) }}</textarea>
            </div>
        </div>
    </section>
</div>

{{-- ACCORDION 3: Profil Mempelai (Seksi 3 Undangan) --}}
<div
    :class="tab === 'mempelai' ? 'border-sage/45 ring-1 ring-sage/15 shadow-xs' : 'border-champagne/30 hover:border-champagne/60'"
    class="rounded-2xl border bg-white overflow-hidden transition"
>
    <button
        type="button"
        data-mobile-tab="mempelai"
        @click="toggleBagian('mempelai')"
        class="w-full px-4 py-3.5 flex items-center justify-between gap-3 text-left cursor-pointer hover:bg-ivory/50 transition"
    >
        <div class="flex items-center gap-2.5 min-w-0">
            <svg
                :class="tab === 'mempelai' ? 'rotate-90 text-sage' : 'text-charcoal/45'"
                class="h-4 w-4 shrink-0 transition-transform duration-200"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
            >
                <path d="m9 18 6-6-6-6"/>
            </svg>
            <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-sage/12 text-[11px] font-bold text-sage shrink-0">3</span>
            <span class="font-sans text-sm font-semibold text-charcoal truncate">Profil Mempelai</span>
        </div>
        @if ($tabSelesai['mempelai'])
            <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-sage/12 text-sage shrink-0">
                <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </span>
        @endif
    </button>

    <section x-show="tab === 'mempelai'" x-cloak class="px-4 pb-5 pt-3 border-t border-champagne/20 space-y-4">
        @if ($undangan->modeTanpaFoto())
            <button
                type="button"
                @click="pilihTab('tema')"
                class="w-full inline-flex items-center gap-2 rounded-xl border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-medium text-amber-800 hover:bg-amber-100 transition cursor-pointer text-left"
            >
                <span class="w-2 h-2 rounded-full bg-amber-500 shrink-0"></span>
                <span>Mode Tanpa Foto aktif &mdash; ubah di bagian Sampul &amp; Tema jika ingin menampilkan foto</span>
            </button>
        @endif

        <div data-bagian-utama="mempelai" class="space-y-4">
            {{-- Judul, Pengantar & Label Mempelai (Tampil di Atas Kartu Mempelai) --}}
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
                        <span class="text-xs font-semibold text-charcoal truncate">Ubah Judul, Pengantar &amp; Label Putra/Putri</span>
                    </span>
                    <span class="flex items-center gap-1.5 shrink-0">
                        <span class="rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $teksMempelaiDikustom ? 'bg-sage/12 text-sage' : 'bg-white text-charcoal/50 ring-1 ring-champagne/30' }}">
                            {{ $teksMempelaiDikustom ? 'Dikustom' : 'Bawaan' }}
                        </span>
                        <svg :class="buka ? 'rotate-180 text-sage' : 'text-charcoal/45'" class="h-3.5 w-3.5 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </span>
                </button>
                <div x-show="buka" x-cloak class="px-3.5 pb-3.5 pt-2.5 border-t border-champagne/20 bg-white/80 space-y-3">
                    <p class="text-[11px] text-charcoal/55">Sudah terisi teks bawaan tema — ubah seperlunya atau kosongkan untuk kembali ke bawaan.</p>
                    <div>
                        <label for="teks_judul_mempelai" class="block text-xs font-semibold text-charcoal/80">Judul Bagian Mempelai</label>
                        <input
                            id="teks_judul_mempelai"
                            type="text"
                            name="teks[judul_mempelai]"
                            value="{{ $nilaiTeksEditor('judul_mempelai') }}"
                            placeholder="{{ $teksBawaanTema['judul_mempelai'] ?: 'Mempelai Berbahagia / We Are Getting Married!' }}"
                            class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none"
                        >
                    </div>
                    <div>
                        <label for="teks_pengantar_mempelai" class="block text-xs font-semibold text-charcoal/80">Kalimat Pengantar</label>
                        <textarea
                            id="teks_pengantar_mempelai"
                            name="teks[pengantar_mempelai]"
                            rows="2"
                            placeholder="{{ $teksBawaanTema['pengantar_mempelai'] ?: 'Dengan memohon rahmat dan ridho Tuhan Yang Maha Esa...' }}"
                            class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm leading-relaxed focus:border-sage focus:outline-none"
                        >{{ $nilaiTeksEditor('pengantar_mempelai') }}</textarea>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-charcoal/80">Keterangan Putra</label>
                            <input
                                type="text"
                                name="teks[label_pria]"
                                value="{{ $nilaiTeksEditor('label_pria') }}"
                                placeholder="{{ $teksBawaanTema['label_pria'] ?: 'Putra dari' }}"
                                class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none"
                            >
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-charcoal/80">Keterangan Putri</label>
                            <input
                                type="text"
                                name="teks[label_wanita]"
                                value="{{ $nilaiTeksEditor('label_wanita') }}"
                                placeholder="{{ $teksBawaanTema['label_wanita'] ?: 'Putri dari' }}"
                                class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none"
                            >
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mempelai Pria --}}
            <div class="rounded-2xl bg-gradient-to-br from-ivory via-white to-sage/[0.04] p-4 ring-1 ring-champagne/25 space-y-4">
                <div class="flex items-center justify-between border-b border-champagne/20 pb-2.5">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-sage">Mempelai Pria</p>
                        <h3 class="font-logo text-lg font-bold text-charcoal tracking-tight" x-text="namaPriaLive || 'Mempelai Pria'">{{ $undangan->nama_panggilan_pria }}</h3>
                    </div>
                    <span class="rounded-full bg-sage/10 px-2.5 py-0.5 text-[11px] font-bold text-sage">Putra</span>
                </div>

                @include('dashboard._input-foto-pratinjau', [
                    'name' => 'foto_pria',
                    'varian' => 'lingkaran',
                    'label' => 'Foto Mempelai Pria',
                    'petunjuk' => 'Rasio template: '.$rasioFotoTema['foto_pria']['label'].' • Otomatis WebP',
                    'urlAwal' => $undangan->urlFotoPria(),
                    'inisial' => $undangan->inisialPria(),
                ])

                <div class="space-y-3">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-charcoal/80">Nama Panggilan</label>
                            <input type="text" name="nama_panggilan_pria" x-model="namaPriaLive" value="{{ old('nama_panggilan_pria', $undangan->nama_panggilan_pria) }}" required placeholder="Contoh: Dimas" class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-sage focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-charcoal/80">Instagram <span class="font-normal text-charcoal/45">(Opsional)</span></label>
                            <div class="mt-1 flex items-center rounded-xl border border-charcoal/15 bg-white focus-within:border-sage overflow-hidden">
                                <span class="pl-3 pr-1 text-xs font-semibold text-charcoal/45 select-none">@</span>
                                <input type="text" name="instagram_pria" value="{{ old('instagram_pria', $undangan->instagramPria()) }}" placeholder="username" class="w-full border-0 bg-transparent py-2 pr-3 text-sm focus:outline-none">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-charcoal/80">Nama Lengkap &amp; Gelar</label>
                        <input type="text" name="nama_lengkap_pria" value="{{ old('nama_lengkap_pria', $undangan->nama_lengkap_pria) }}" required placeholder="Contoh: Dimas Pratama Putra, S.Kom." class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-sage focus:outline-none">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-charcoal/80">Nama Ayah</label>
                            <input type="text" name="nama_ayah_pria" value="{{ old('nama_ayah_pria', $undangan->nama_ayah_pria) }}" placeholder="Bpk. ..." class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-sage focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-charcoal/80">Nama Ibu</label>
                            <input type="text" name="nama_ibu_pria" value="{{ old('nama_ibu_pria', $undangan->nama_ibu_pria) }}" placeholder="Ibu ..." class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-sage focus:outline-none">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mempelai Wanita --}}
            <div class="rounded-2xl bg-gradient-to-br from-ivory via-white to-champagne/[0.06] p-4 ring-1 ring-champagne/25 space-y-4">
                <div class="flex items-center justify-between border-b border-champagne/20 pb-2.5">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-champagne">Mempelai Wanita</p>
                        <h3 class="font-logo text-lg font-bold text-charcoal tracking-tight" x-text="namaWanitaLive || 'Mempelai Wanita'">{{ $undangan->nama_panggilan_wanita }}</h3>
                    </div>
                    <span class="rounded-full bg-champagne/15 px-2.5 py-0.5 text-[11px] font-bold text-champagne">Putri</span>
                </div>

                @include('dashboard._input-foto-pratinjau', [
                    'name' => 'foto_wanita',
                    'varian' => 'lingkaran',
                    'label' => 'Foto Mempelai Wanita',
                    'petunjuk' => 'Rasio template: '.$rasioFotoTema['foto_wanita']['label'].' • Otomatis WebP',
                    'urlAwal' => $undangan->urlFotoWanita(),
                    'inisial' => $undangan->inisialWanita(),
                ])

                <div class="space-y-3">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-charcoal/80">Nama Panggilan</label>
                            <input type="text" name="nama_panggilan_wanita" x-model="namaWanitaLive" value="{{ old('nama_panggilan_wanita', $undangan->nama_panggilan_wanita) }}" required placeholder="Contoh: Maya" class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-champagne focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-charcoal/80">Instagram <span class="font-normal text-charcoal/45">(Opsional)</span></label>
                            <div class="mt-1 flex items-center rounded-xl border border-charcoal/15 bg-white focus-within:border-champagne overflow-hidden">
                                <span class="pl-3 pr-1 text-xs font-semibold text-charcoal/45 select-none">@</span>
                                <input type="text" name="instagram_wanita" value="{{ old('instagram_wanita', $undangan->instagramWanita()) }}" placeholder="username" class="w-full border-0 bg-transparent py-2 pr-3 text-sm focus:outline-none">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-charcoal/80">Nama Lengkap &amp; Gelar</label>
                        <input type="text" name="nama_lengkap_wanita" value="{{ old('nama_lengkap_wanita', $undangan->nama_lengkap_wanita) }}" required placeholder="Contoh: Maya Sari Kusuma, S.E." class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-champagne focus:outline-none">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-charcoal/80">Nama Ayah</label>
                            <input type="text" name="nama_ayah_wanita" value="{{ old('nama_ayah_wanita', $undangan->nama_ayah_wanita) }}" placeholder="Bpk. ..." class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-champagne focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-charcoal/80">Nama Ibu</label>
                            <input type="text" name="nama_ibu_wanita" value="{{ old('nama_ibu_wanita', $undangan->nama_ibu_wanita) }}" placeholder="Ibu ..." class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-champagne focus:outline-none">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
