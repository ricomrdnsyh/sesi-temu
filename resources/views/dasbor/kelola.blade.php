@extends('layouts.aplikasi')

@section('judul', 'Kelola Undangan — '.$undangan->nama_panggilan_pria.' & '.$undangan->nama_panggilan_wanita)

@section('konten')
@php
    $pengaturan = array_replace_recursive(\App\Models\Undangan::pengaturanBawaan(), $undangan->pengaturan ?? []);
    $ceritaAwal = $pengaturan['cerita_cinta'] ?? [];
    if (empty($ceritaAwal)) {
        $ceritaAwal = [['judul' => '', 'tanggal' => '', 'cerita' => '']];
    }
    $urlPublik = Route::has('undangan.tampil') ? route('undangan.tampil', $undangan->slug) : url('/'.$undangan->slug);
    $pesanWaAktivasi = "Halo Admin SesiTemu, saya ingin mengaktifkan undangan sesitemu.id/{$undangan->slug}.";
@endphp

<div
    x-data="{
        tab: @js($tabAktif),
        daftarCerita: @js($ceritaAwal),
        teksDaftarTamu: 'Budi Santoso\nSiti Aminah & Partner\nKeluarga Bpk. Hendra',
        acaraEdit: null,
        init() {
            this.$nextTick(() => {
                const btn = this.$el.querySelector(`[data-mobile-tab='${this.tab}']`);
                btn?.scrollIntoView({ behavior: 'auto', inline: 'center', block: 'nearest' });
            });
        },
        pilihTab(kodeTab) {
            this.tab = kodeTab;
            window.scrollTo({ top: 0, behavior: 'smooth' });
            this.$nextTick(() => {
                const btn = this.$el.querySelector(`[data-mobile-tab='${kodeTab}']`);
                btn?.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
            });
        },
        tambahCerita() {
            this.daftarCerita.push({ judul: '', tanggal: '', cerita: '' });
        },
        hapusCerita(index) {
            if (this.daftarCerita.length > 1) {
                this.daftarCerita.splice(index, 1);
            }
        },
        hasilLinkTamu() {
            const dasarUrl = @js($urlPublik);
            const panggilanPria = @js($undangan->nama_panggilan_pria);
            const panggilanWanita = @js($undangan->nama_panggilan_wanita);

            return this.teksDaftarTamu
                .split('\n')
                .map(baris => baris.trim())
                .filter(baris => baris.length > 0)
                .map(nama => {
                    const urlTamu = dasarUrl + '?to=' + encodeURIComponent(nama);
                    const pesan = `Kepada Yth. ${nama},\n\nTanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pernikahan kami:\n\n*${panggilanPria} & ${panggilanWanita}*\n\nInformasi lengkap acara dapat diakses melalui tautan berikut:\n${urlTamu}\n\nMerupakan suatu kehormatan apabila Anda berkenan hadir dan memberikan doa restu.`;
                    return {
                        nama,
                        urlTamu,
                        pesan,
                        waUrl: 'https://wa.me/?text=' + encodeURIComponent(pesan),
                        tersalin: false
                    };
                });
        }
    }"
    class="min-h-screen bg-ivory flex flex-col"
>
    {{-- Header Top Bar --}}
    <header class="bg-white/95 backdrop-blur-md border-b border-champagne/20 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-3.5 sm:px-6 lg:px-8 h-14 md:h-16 flex items-center justify-between gap-2.5 sm:gap-4">
            <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                <a href="{{ auth()->user()->adalahAdmin() ? route('admin.undangan.index') : route('dasbor.index') }}" class="rounded-xl border border-charcoal/15 px-2.5 sm:px-3 py-1.5 text-xs font-semibold text-charcoal hover:bg-ivory transition shrink-0">
                    ← <span class="hidden sm:inline">Kembali</span>
                </a>
                <a href="{{ route('beranda') }}" title="Beranda SesiTemu" class="hidden sm:inline-flex items-center shrink-0">
                    <img
                        src="{{ asset('aset-demo/logo-sesi-temu-ikon.webp') }}"
                        alt="Logo SesiTemu"
                        class="h-8 w-8 object-contain"
                    >
                </a>
                <div class="min-w-0">
                    <h1 class="font-serif text-base sm:text-xl font-bold text-charcoal truncate">
                        {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
                    </h1>
                    <p class="text-[11px] sm:text-xs font-mono text-sage truncate">sesitemu.id/{{ $undangan->slug }}</p>
                </div>
            </div>

            <div class="flex items-center gap-2 sm:gap-2.5 shrink-0">
                <a href="{{ $urlPublik }}" target="_blank" class="inline-flex items-center gap-1 rounded-xl border border-champagne px-3 sm:px-3.5 py-1.5 text-xs sm:text-sm font-semibold text-charcoal hover:bg-champagne/10 transition">
                    <svg class="h-3.5 w-3.5 sm:hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    <span class="sm:hidden">Lihat</span>
                    <span class="hidden sm:inline">Pratinjau Undangan</span>
                </a>

                @if (! $undangan->status_publikasi && ! auth()->user()->adalahAdmin())
                    <a
                        href="{{ \App\Support\PengaturanSesiTemu::urlWaAdmin($pesanWaAktivasi) }}"
                        target="_blank"
                        rel="noopener"
                        class="hidden sm:inline-flex rounded-xl bg-champagne px-3.5 py-1.5 text-xs sm:text-sm font-semibold text-charcoal hover:bg-champagne/90 transition"
                    >
                        Aktifkan via WA
                    </a>
                @endif
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-7xl w-full mx-auto px-3.5 sm:px-6 lg:px-8 pt-4 pb-28 md:py-8 space-y-4 sm:space-y-6">
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

        @php
            $daftarTabEditor = [
                'tema' => ['label_desktop' => '1. Tema & Link', 'label_mobile' => 'Tema', 'langkah' => 1],
                'mempelai' => ['label_desktop' => '2. Data Mempelai', 'label_mobile' => 'Mempelai', 'langkah' => 2],
                'acara' => ['label_desktop' => '3. Rangkaian Acara', 'label_mobile' => 'Acara', 'langkah' => 3],
                'galeri' => ['label_desktop' => '4. Galeri & Cerita', 'label_mobile' => 'Galeri', 'langkah' => 4],
                'amplop' => ['label_desktop' => '5. Amplop Digital', 'label_mobile' => 'Amplop', 'langkah' => 5],
                'tamu' => ['label_desktop' => '6. Sebar Tamu & RSVP', 'label_mobile' => 'Tamu', 'langkah' => 6],
                'aktivasi' => ['label_desktop' => '7. Pembayaran & Aktivasi', 'label_mobile' => 'Bayar', 'langkah' => 7],
            ];
        @endphp

        {{-- Penanda Bagian Aktif di Mobile --}}
        <div class="md:hidden flex items-center justify-between gap-2 rounded-xl bg-white px-3.5 py-2.5 ring-1 ring-champagne/20 shadow-xs">
            <div class="min-w-0">
                @foreach ($daftarTabEditor as $kode => $metaTab)
                    <div x-show="tab === '{{ $kode }}'" x-cloak class="flex items-center gap-2">
                        <span class="rounded-full bg-sage/15 px-2.5 py-0.5 text-[11px] font-bold text-sage shrink-0">
                            {{ $metaTab['langkah'] }}/7
                        </span>
                        <span class="text-xs font-bold text-charcoal truncate">{{ $metaTab['label_desktop'] }}</span>
                    </div>
                @endforeach
            </div>
            <span class="text-[11px] text-charcoal/55 shrink-0">Gunakan menu bawah ↕</span>
        </div>

        {{-- Navigasi 7 Tab Desktop --}}
        <div class="hidden md:flex flex-wrap gap-2 bg-white p-2 rounded-2xl shadow-sm ring-1 ring-champagne/20">
            @foreach ($daftarTabEditor as $kode => $metaTab)
                <button
                    type="button"
                    @click="pilihTab('{{ $kode }}')"
                    :class="tab === '{{ $kode }}' ? 'bg-sage text-white shadow-sm' : 'text-charcoal/75 hover:bg-ivory'"
                    class="rounded-xl px-4 py-2 text-xs sm:text-sm font-semibold transition cursor-pointer"
                >
                    {{ $metaTab['label_desktop'] }}
                </button>
            @endforeach
        </div>

        {{-- TAB 1: Tema & Pengaturan Link --}}
        <section x-show="tab === 'tema'" x-cloak class="rounded-2xl bg-white p-4 sm:p-8 shadow-sm ring-1 ring-champagne/20">
            <h2 class="font-serif text-xl sm:text-2xl font-bold text-charcoal">Tema, Musik &amp; Pengaturan Link</h2>
            <p class="mt-1 text-sm text-charcoal/65">Ganti tema kapan saja tanpa kehilangan data yang sudah diisi.</p>

            <form action="{{ route('dasbor.undangan.perbarui', $undangan) }}" method="POST" class="mt-6 space-y-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="bagian" value="tema">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="tema_id" class="block text-sm font-medium text-charcoal">Tema Undangan</label>
                        <select id="tema_id" name="tema_id" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm focus:border-champagne focus:bg-white focus:outline-none">
                            @foreach ($daftarTema as $tema)
                                <option value="{{ $tema->id }}" @selected($undangan->tema_id === $tema->id)>
                                    {{ $tema->nama_tema }} ({{ $tema->kategoriLabel() }} • {{ $tema->tierLabel() }} — {{ $tema->hargaFormatted() }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-charcoal">Link Undangan (Slug)</label>
                        <div class="mt-1.5 flex items-center rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2.5">
                            <span class="text-sm text-charcoal/50">sesitemu.id/</span>
                            <input
                                id="slug"
                                name="slug"
                                type="text"
                                value="{{ old('slug', $undangan->slug) }}"
                                @if ($undangan->status_publikasi && ! auth()->user()->adalahAdmin()) readonly @endif
                                class="w-full bg-transparent text-sm font-semibold focus:outline-none ml-0.5 @if($undangan->status_publikasi && ! auth()->user()->adalahAdmin()) text-charcoal/60 cursor-not-allowed @endif"
                            >
                        </div>
                        @if ($undangan->status_publikasi && ! auth()->user()->adalahAdmin())
                            <p class="mt-1 text-xs text-amber-700">Slug terkunci karena undangan sudah aktif. Hubungi Admin jika perlu perubahan.</p>
                        @endif
                    </div>

                    <div>
                        <label for="gaya_font" class="block text-sm font-medium text-charcoal">Desain Tipografi (Font Undangan)</label>
                        <select id="gaya_font" name="gaya_font" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm focus:border-champagne focus:bg-white focus:outline-none">
                            @foreach ($daftarGayaFont as $kodeFont => $infoFont)
                                <option value="{{ $kodeFont }}" @selected($undangan->kodeGayaFontTerpilih() === $kodeFont)>
                                    {{ $infoFont['label'] }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-charcoal/60">Pilih kombinasi font klasik, editorial, kaligrafi, atau bawaan tema.</p>
                    </div>

                    <div>
                        <label for="musik_latar" class="block text-sm font-medium text-charcoal">Musik Latar Undangan</label>
                        <select id="musik_latar" name="musik_latar" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm focus:border-champagne focus:bg-white focus:outline-none">
                            <option value="">-- Tanpa Musik Latar --</option>
                            @foreach ($daftarMusik as $musik)
                                <option value="{{ $musik['path'] }}" @selected($undangan->musik_latar === $musik['path'])>
                                    {{ $musik['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="flex items-start gap-3 rounded-2xl border border-champagne/35 bg-ivory/80 px-4 py-3.5 cursor-pointer">
                            <input
                                type="checkbox"
                                name="tanpa_foto"
                                value="1"
                                @checked($undangan->modeTanpaFoto())
                                class="mt-0.5 rounded border-charcoal/25 text-sage focus:ring-sage"
                            >
                            <span>
                                <span class="block text-sm font-semibold text-charcoal">Mode Tanpa Foto (TF / Monogram Privasi)</span>
                                <span class="block text-xs text-charcoal/65 mt-0.5">Sembunyikan potret kedua mempelai &amp; galeri foto; gantikan dengan inisial monogram elegan (seperti variasi TF pada katalog).</span>
                            </span>
                        </label>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-charcoal mb-3">Sakelar Fitur Undangan</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                        @foreach ([
                            'fitur_hitung_mundur' => ['key' => 'hitung_mundur', 'label' => 'Hitung Mundur'],
                            'fitur_cerita_cinta' => ['key' => 'cerita_cinta', 'label' => 'Cerita Cinta'],
                            'fitur_galeri' => ['key' => 'galeri', 'label' => 'Galeri Foto'],
                            'fitur_amplop_digital' => ['key' => 'amplop_digital', 'label' => 'Amplop Digital'],
                            'fitur_buku_tamu' => ['key' => 'buku_tamu', 'label' => 'Buku Tamu'],
                        ] as $inputName => $meta)
                            <label class="flex items-center gap-2.5 rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2.5 text-sm cursor-pointer">
                                <input
                                    type="checkbox"
                                    name="{{ $inputName }}"
                                    value="1"
                                    @checked($undangan->fiturAktif($meta['key']))
                                    class="rounded border-charcoal/25 text-sage focus:ring-sage"
                                >
                                <span>{{ $meta['label'] }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="w-full sm:w-auto rounded-xl bg-sage px-6 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer">
                        Simpan Pengaturan Tema &amp; Link
                    </button>
                </div>
            </form>
        </section>

        {{-- TAB 2: Data Mempelai --}}
        <section x-show="tab === 'mempelai'" x-cloak class="rounded-2xl bg-white p-4 sm:p-8 shadow-sm ring-1 ring-champagne/20">
            <h2 class="font-serif text-xl sm:text-2xl font-bold text-charcoal">Data Kedua Mempelai &amp; Kutipan Doa</h2>
            <p class="mt-1 text-sm text-charcoal/65">Foto profil yang diunggah otomatis dikompresi ke format .webp hemat kuota.</p>

            <form action="{{ route('dasbor.undangan.perbarui', $undangan) }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-8">
                @csrf
                @method('PUT')
                <input type="hidden" name="bagian" value="mempelai">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {{-- Mempelai Pria --}}
                    <div class="rounded-2xl bg-ivory p-5 ring-1 ring-champagne/20 space-y-4">
                        <h3 class="font-serif text-xl font-bold text-charcoal">Mempelai Pria</h3>

                        @if ($undangan->urlFotoPria())
                            <img src="{{ $undangan->urlFotoPria() }}" alt="Foto Mempelai Pria" class="w-24 h-24 rounded-full object-cover ring-2 ring-champagne/40">
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-charcoal">Foto Mempelai Pria (JPG/PNG/WebP)</label>
                            <input type="file" name="foto_pria" accept="image/*" class="mt-1.5 block w-full text-sm text-charcoal file:mr-3 file:rounded-lg file:border-0 file:bg-sage/10 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-sage">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-charcoal">Nama Panggilan Pria</label>
                            <input type="text" name="nama_panggilan_pria" value="{{ old('nama_panggilan_pria', $undangan->nama_panggilan_pria) }}" required class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-white px-4 py-2 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-charcoal">Nama Lengkap &amp; Gelar Pria</label>
                            <input type="text" name="nama_lengkap_pria" value="{{ old('nama_lengkap_pria', $undangan->nama_lengkap_pria) }}" required class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-white px-4 py-2 text-sm">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-charcoal">Nama Ayah</label>
                                <input type="text" name="nama_ayah_pria" value="{{ old('nama_ayah_pria', $undangan->nama_ayah_pria) }}" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-white px-4 py-2 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-charcoal">Nama Ibu</label>
                                <input type="text" name="nama_ibu_pria" value="{{ old('nama_ibu_pria', $undangan->nama_ibu_pria) }}" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-white px-4 py-2 text-sm">
                            </div>
                        </div>
                    </div>

                    {{-- Mempelai Wanita --}}
                    <div class="rounded-2xl bg-ivory p-5 ring-1 ring-champagne/20 space-y-4">
                        <h3 class="font-serif text-xl font-bold text-charcoal">Mempelai Wanita</h3>

                        @if ($undangan->urlFotoWanita())
                            <img src="{{ $undangan->urlFotoWanita() }}" alt="Foto Mempelai Wanita" class="w-24 h-24 rounded-full object-cover ring-2 ring-champagne/40">
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-charcoal">Foto Mempelai Wanita (JPG/PNG/WebP)</label>
                            <input type="file" name="foto_wanita" accept="image/*" class="mt-1.5 block w-full text-sm text-charcoal file:mr-3 file:rounded-lg file:border-0 file:bg-sage/10 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-sage">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-charcoal">Nama Panggilan Wanita</label>
                            <input type="text" name="nama_panggilan_wanita" value="{{ old('nama_panggilan_wanita', $undangan->nama_panggilan_wanita) }}" required class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-white px-4 py-2 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-charcoal">Nama Lengkap &amp; Gelar Wanita</label>
                            <input type="text" name="nama_lengkap_wanita" value="{{ old('nama_lengkap_wanita', $undangan->nama_lengkap_wanita) }}" required class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-white px-4 py-2 text-sm">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-charcoal">Nama Ayah</label>
                                <input type="text" name="nama_ayah_wanita" value="{{ old('nama_ayah_wanita', $undangan->nama_ayah_wanita) }}" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-white px-4 py-2 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-charcoal">Nama Ibu</label>
                                <input type="text" name="nama_ibu_wanita" value="{{ old('nama_ibu_wanita', $undangan->nama_ibu_wanita) }}" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-white px-4 py-2 text-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl bg-ivory p-5 ring-1 ring-champagne/25 space-y-3">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h3 class="font-serif text-lg font-bold text-charcoal">Foto Sampul Gerbang Undangan (Opsional)</h3>
                            <p class="text-xs text-charcoal/65 mt-0.5">
                                Foto potret pasangan yang tampil di gerbang awal saat mode foto aktif. Jika kosong, sistem otomatis mengambil foto pertama dari Galeri atau foto mempelai.
                            </p>
                        </div>
                        @if ($undangan->urlFotoSampulKhususDasbor())
                            <img src="{{ $undangan->urlFotoSampulKhususDasbor() }}" alt="Pratinjau Foto Sampul" class="w-16 h-24 rounded-xl object-cover ring-2 ring-champagne/40 shrink-0">
                        @endif
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        <input type="file" name="foto_sampul" accept="image/*" class="block w-full text-sm text-charcoal file:mr-3 file:rounded-lg file:border-0 file:bg-sage/10 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-sage">
                        @if ($undangan->urlFotoSampulKhususDasbor())
                            <label class="inline-flex items-center gap-2 text-xs text-rose-700 font-medium shrink-0 cursor-pointer">
                                <input type="checkbox" name="hapus_foto_sampul" value="1" class="rounded border-rose-300 text-rose-600 focus:ring-rose-500">
                                <span>Hapus foto sampul khusus</span>
                            </label>
                        @endif
                    </div>
                </div>

                <div>
                    <label for="kutipan_ayat" class="block text-sm font-medium text-charcoal">Kutipan Ayat / Doa / Kata Mutiara</label>
                    <textarea id="kutipan_ayat" name="kutipan_ayat" rows="3" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm">{{ old('kutipan_ayat', $undangan->kutipan_ayat) }}</textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="w-full sm:w-auto rounded-xl bg-sage px-6 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer">
                        Simpan Data Mempelai
                    </button>
                </div>
            </form>
        </section>

        {{-- TAB 3: Rangkaian Acara --}}
        <section x-show="tab === 'acara'" x-cloak class="space-y-6">
            <div class="rounded-2xl bg-white p-4 sm:p-8 shadow-sm ring-1 ring-champagne/20">
                <div class="flex items-center justify-between">
                    <h2 class="font-serif text-xl sm:text-2xl font-bold text-charcoal" x-text="acaraEdit ? 'Edit Jadwal Acara' : 'Tambah Jadwal Acara'"></h2>
                    <button type="button" x-show="acaraEdit" @click="acaraEdit = null" class="text-xs font-semibold text-champagne hover:underline cursor-pointer">
                        + Batal Edit / Tambah Baru
                    </button>
                </div>

                <form action="{{ route('dasbor.acara.simpan', $undangan) }}" method="POST" class="mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @csrf
                    <input type="hidden" name="acara_id" :value="acaraEdit ? acaraEdit.id : ''">

                    <div>
                        <label class="block text-sm font-medium text-charcoal">Nama Acara</label>
                        <input type="text" name="nama_acara" :value="acaraEdit ? acaraEdit.nama_acara : ''" required placeholder="Akad Nikah / Resepsi" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-charcoal">Tanggal Acara</label>
                        <input type="date" name="tanggal_acara" :value="acaraEdit ? acaraEdit.tanggal_acara : ''" required class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm">
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-charcoal">Mulai</label>
                            <input type="time" name="waktu_mulai" :value="acaraEdit ? acaraEdit.waktu_mulai : '08:00'" required class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-2.5 py-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-charcoal">Selesai</label>
                            <input type="time" name="waktu_selesai" :value="acaraEdit ? acaraEdit.waktu_selesai : ''" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-2.5 py-2 text-sm">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label class="block text-sm font-medium text-charcoal">Zona</label>
                            <select name="zona_waktu" :value="acaraEdit ? acaraEdit.zona_waktu : 'WIB'" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-2 py-2 text-sm">
                                <option value="WIB">WIB</option>
                                <option value="WITA">WITA</option>
                                <option value="WIT">WIT</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-charcoal">Nama Tempat / Gedung</label>
                        <input type="text" name="nama_tempat" :value="acaraEdit ? acaraEdit.nama_tempat : ''" required placeholder="Masjid Agung / Hotel..." class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-charcoal">Link Google Maps (Opsional)</label>
                        <input type="url" name="link_maps" :value="acaraEdit ? acaraEdit.link_maps : ''" placeholder="https://maps.google.com/..." class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm">
                    </div>

                    <div class="sm:col-span-2 lg:col-span-3">
                        <label class="block text-sm font-medium text-charcoal">Alamat Lengkap</label>
                        <textarea name="alamat_lengkap" rows="2" required x-text="acaraEdit ? acaraEdit.alamat_lengkap : ''" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm"></textarea>
                    </div>

                    <div class="sm:col-span-2 lg:col-span-3 flex justify-end">
                        <button type="submit" class="w-full sm:w-auto rounded-xl bg-sage px-6 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer" x-text="acaraEdit ? 'Perbarui Acara' : '+ Tambah Acara'">
                        </button>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse ($undangan->daftarAcara as $acara)
                    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-champagne/20 flex flex-col justify-between gap-4">
                        <div>
                            <h3 class="font-serif text-xl font-bold text-charcoal">{{ $acara->nama_acara }}</h3>
                            <p class="mt-1 text-sm text-sage font-semibold">
                                {{ $acara->tanggal_acara->translatedFormat('l, d F Y') }} • {{ substr($acara->waktu_mulai, 0, 5) }}
                                @if ($acara->waktu_selesai) - {{ substr($acara->waktu_selesai, 0, 5) }} @endif
                                {{ $acara->zona_waktu }}
                            </p>
                            <p class="mt-2 text-sm font-medium text-charcoal">{{ $acara->nama_tempat }}</p>
                            <p class="mt-0.5 text-xs text-charcoal/70">{{ $acara->alamat_lengkap }}</p>
                        </div>

                        <div class="flex items-center gap-2">
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
                                ]) }}"
                                class="rounded-xl border border-champagne px-3.5 py-1.5 text-xs font-semibold text-charcoal hover:bg-champagne/10 cursor-pointer"
                            >
                                Edit
                            </button>

                            <form action="{{ route('dasbor.acara.hapus', [$undangan, $acara]) }}" method="POST" onsubmit="return confirm('Hapus acara ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-xl border border-red-200 px-3.5 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-50 cursor-pointer">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full rounded-2xl bg-white p-8 text-center text-sm text-charcoal/65 ring-1 ring-champagne/20">
                        Belum ada rangkaian acara. Tambahkan Akad Nikah / Resepsi di form atas.
                    </div>
                @endforelse
            </div>
        </section>

        {{-- TAB 4: Galeri & Cerita Cinta + Live Streaming --}}
        <section x-show="tab === 'galeri'" x-cloak class="space-y-6">
            {{-- Upload Galeri --}}
            <div class="rounded-2xl bg-white p-4 sm:p-8 shadow-sm ring-1 ring-champagne/20">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-serif text-xl sm:text-2xl font-bold text-charcoal">Galeri Foto Prewedding</h2>
                        <p class="mt-1 text-sm text-charcoal/65">Maksimal 10 foto ({{ $undangan->daftarGaleri->count() }}/10 terunggah). Otomatis dikonversi ke .webp.</p>
                    </div>
                </div>

                <form action="{{ route('dasbor.galeri.unggah', $undangan) }}" method="POST" enctype="multipart/form-data" class="mt-5 grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-charcoal">Pilih Foto</label>
                        <input type="file" name="foto" accept="image/*" required class="mt-1.5 block w-full text-sm text-charcoal file:mr-3 file:rounded-lg file:border-0 file:bg-sage/10 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-sage">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-charcoal">Keterangan (Opsional)</label>
                        <input type="text" name="keterangan" placeholder="Momen bahagia kami" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm">
                    </div>
                    <button type="submit" class="rounded-xl bg-sage px-5 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer">
                        Unggah Foto
                    </button>
                </form>

                <div class="mt-6 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                    @foreach ($undangan->daftarGaleri as $galeri)
                        <div class="rounded-xl overflow-hidden bg-ivory ring-1 ring-champagne/20 flex flex-col">
                            <img src="{{ $galeri->urlFoto() }}" alt="{{ $galeri->keterangan ?? 'Foto Galeri' }}" class="aspect-square w-full object-cover">
                            <div class="p-2.5 flex items-center justify-between gap-2 text-xs">
                                <span class="truncate text-charcoal/75">{{ $galeri->keterangan ?: 'Foto #'.$galeri->urutan }}</span>
                                <form action="{{ route('dasbor.galeri.hapus', [$undangan, $galeri]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-semibold text-red-600 hover:underline cursor-pointer">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Cerita Cinta & Live Streaming --}}
            <div class="rounded-2xl bg-white p-4 sm:p-8 shadow-sm ring-1 ring-champagne/20">
                <h2 class="font-serif text-xl sm:text-2xl font-bold text-charcoal">Cerita Cinta &amp; Live Streaming</h2>

                <form action="{{ route('dasbor.undangan.perbarui', $undangan) }}" method="POST" class="mt-5 space-y-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="bagian" value="cerita_streaming">

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-charcoal">Linimasa Cerita Cinta</h3>
                            <button type="button" @click="tambahCerita()" class="rounded-lg bg-champagne/15 px-3 py-1.5 text-xs font-semibold text-charcoal hover:bg-champagne/25 cursor-pointer">
                                + Tambah Cerita
                            </button>
                        </div>

                        <template x-for="(item, idx) in daftarCerita" :key="idx">
                            <div class="rounded-xl bg-ivory p-4 ring-1 ring-champagne/20 grid grid-cols-1 sm:grid-cols-4 gap-3 items-start">
                                <input type="text" :name="`cerita_cinta[${idx}][judul]`" x-model="item.judul" placeholder="Judul Momen" class="rounded-lg border border-charcoal/15 bg-white px-3 py-2 text-sm">
                                <input type="text" :name="`cerita_cinta[${idx}][tanggal]`" x-model="item.tanggal" placeholder="Tahun / Tanggal" class="rounded-lg border border-charcoal/15 bg-white px-3 py-2 text-sm">
                                <textarea :name="`cerita_cinta[${idx}][cerita]`" x-model="item.cerita" rows="2" placeholder="Ceritakan singkat..." class="sm:col-span-2 rounded-lg border border-charcoal/15 bg-white px-3 py-2 text-sm"></textarea>
                                <div class="sm:col-span-4 flex justify-end" x-show="daftarCerita.length > 1">
                                    <button type="button" @click="hapusCerita(idx)" class="text-xs font-semibold text-red-600 hover:underline cursor-pointer">Hapus Baris</button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="border-t border-champagne/20 pt-5 space-y-4">
                        <label class="inline-flex items-center gap-2 text-sm font-semibold text-charcoal cursor-pointer">
                            <input type="checkbox" name="live_aktif" value="1" @checked($pengaturan['live_streaming']['aktif'] ?? false) class="rounded border-charcoal/25 text-sage focus:ring-sage">
                            <span>Aktifkan Fitur Live Streaming Pernikahan</span>
                        </label>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-charcoal">Platform</label>
                                <input type="text" name="live_platform" value="{{ $pengaturan['live_streaming']['platform'] ?? 'Instagram / YouTube' }}" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-charcoal">Link Live Streaming</label>
                                <input type="url" name="live_link" value="{{ $pengaturan['live_streaming']['link'] ?? '' }}" placeholder="https://youtube.com/live/..." class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="w-full sm:w-auto rounded-xl bg-sage px-6 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer">
                            Simpan Cerita &amp; Live Streaming
                        </button>
                    </div>
                </form>
            </div>
        </section>

        {{-- TAB 5: Amplop Digital --}}
        <section x-show="tab === 'amplop'" x-cloak class="space-y-6">
            <div class="rounded-2xl bg-white p-4 sm:p-8 shadow-sm ring-1 ring-champagne/20">
                <h2 class="font-serif text-xl sm:text-2xl font-bold text-charcoal">Tambah Rekening / E-Wallet Amplop Digital</h2>

                <form action="{{ route('dasbor.amplop.simpan', $undangan) }}" method="POST" class="mt-5 grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-charcoal">Bank / E-Wallet</label>
                        <input type="text" name="nama_bank" required placeholder="BCA / Mandiri / GoPay" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-charcoal">Nomor Rekening / HP</label>
                        <input type="text" name="nomor_rekening" required placeholder="1234567890" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-charcoal">Atas Nama</label>
                        <input type="text" name="atas_nama" required placeholder="Dimas Pratama" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm">
                    </div>
                    <button type="submit" class="rounded-xl bg-sage px-5 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer">
                        + Tambah Rekening
                    </button>
                </form>

                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($undangan->daftarAmplop as $amplop)
                        <div class="rounded-xl bg-ivory p-4 ring-1 ring-champagne/25 flex items-center justify-between gap-3">
                            <div>
                                <p class="text-xs font-bold uppercase text-champagne">{{ $amplop->nama_bank }}</p>
                                <p class="font-mono font-bold text-charcoal mt-0.5">{{ $amplop->nomor_rekening }}</p>
                                <p class="text-xs text-charcoal/70">a.n. {{ $amplop->atas_nama }}</p>
                            </div>
                            <form action="{{ route('dasbor.amplop.hapus', [$undangan, $amplop]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-red-600 hover:underline cursor-pointer">Hapus</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-2xl bg-white p-4 sm:p-8 shadow-sm ring-1 ring-champagne/20">
                <h3 class="font-serif text-lg sm:text-xl font-bold text-charcoal">Alamat Pengiriman Kado Fisik</h3>
                <form action="{{ route('dasbor.undangan.perbarui', $undangan) }}" method="POST" class="mt-4 space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="bagian" value="kado_fisik">
                    <textarea name="alamat_kado_fisik" rows="2" placeholder="Jl. Contoh No. 12, Jakarta Selatan..." class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm">{{ old('alamat_kado_fisik', $pengaturan['alamat_kado_fisik'] ?? '') }}</textarea>
                    <div class="flex justify-end">
                        <button type="submit" class="w-full sm:w-auto rounded-xl bg-sage px-6 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer">
                            Simpan Alamat Kado
                        </button>
                    </div>
                </form>
            </div>
        </section>

        {{-- TAB 6: Sebar Tamu & Buku Tamu (RSVP) --}}
        <section x-show="tab === 'tamu'" x-cloak class="space-y-6">
            {{-- Generator Link Tamu WhatsApp --}}
            <div class="rounded-2xl bg-white p-4 sm:p-8 shadow-sm ring-1 ring-champagne/20">
                <h2 class="font-serif text-xl sm:text-2xl font-bold text-charcoal">Generator Link Tamu WhatsApp</h2>
                <p class="mt-1 text-sm text-charcoal/65">Tulis daftar nama tamu (satu nama per baris) untuk menghasilkan link personal &amp; pesan undangan WhatsApp.</p>

                <div class="mt-5 grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label for="daftar_tamu_wa" class="block text-sm font-medium text-charcoal">Daftar Nama Tamu (Per Baris)</label>
                        <textarea id="daftar_tamu_wa" x-model="teksDaftarTamu" rows="8" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-3 text-sm font-mono"></textarea>
                    </div>

                    <div class="space-y-3 max-h-80 overflow-y-auto pr-1">
                        <template x-for="(tamu, idx) in hasilLinkTamu()" :key="idx">
                            <div class="rounded-xl bg-ivory p-3.5 ring-1 ring-champagne/20 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="font-semibold text-sm text-charcoal truncate" x-text="tamu.nama"></p>
                                    <p class="text-xs font-mono text-sage truncate" x-text="tamu.urlTamu"></p>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <button
                                        type="button"
                                        @click="navigator.clipboard.writeText(tamu.pesan); tamu.tersalin = true; setTimeout(() => tamu.tersalin = false, 2000)"
                                        class="rounded-lg border border-champagne px-3 py-1.5 text-xs font-semibold text-charcoal hover:bg-champagne/10 cursor-pointer"
                                        x-text="tamu.tersalin ? 'Tersalin!' : 'Salin Teks'"
                                    ></button>
                                    <a :href="tamu.waUrl" target="_blank" rel="noopener" class="rounded-lg bg-sage px-3 py-1.5 text-xs font-semibold text-white hover:bg-sage/90">
                                        Kirim WA
                                    </a>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            {{-- Rekapitulasi Kehadiran & Daftar Ucapan --}}
            <div class="rounded-2xl bg-white p-4 sm:p-8 shadow-sm ring-1 ring-champagne/20">
                <h2 class="font-serif text-xl sm:text-2xl font-bold text-charcoal">Rekapitulasi Kehadiran &amp; Buku Tamu</h2>

                <div class="mt-4 sm:mt-5 grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
                    <div class="rounded-xl bg-sage/10 p-3.5 sm:p-4">
                        <p class="text-xs text-charcoal/70">Konfirmasi Hadir</p>
                        <p class="mt-1 font-serif text-2xl sm:text-3xl font-bold text-sage">{{ $rekapRsvp['hadir'] }}</p>
                    </div>
                    <div class="rounded-xl bg-amber-50 p-3.5 sm:p-4">
                        <p class="text-xs text-charcoal/70">Masih Ragu</p>
                        <p class="mt-1 font-serif text-2xl sm:text-3xl font-bold text-amber-700">{{ $rekapRsvp['ragu'] }}</p>
                    </div>
                    <div class="rounded-xl bg-red-50 p-3.5 sm:p-4">
                        <p class="text-xs text-charcoal/70">Tidak Hadir</p>
                        <p class="mt-1 font-serif text-2xl sm:text-3xl font-bold text-red-700">{{ $rekapRsvp['tidak_hadir'] }}</p>
                    </div>
                    <div class="rounded-xl bg-champagne/15 p-3.5 sm:p-4">
                        <p class="text-xs text-charcoal/70">Estimasi Orang Hadir</p>
                        <p class="mt-1 font-serif text-2xl sm:text-3xl font-bold text-charcoal">{{ $rekapRsvp['total_orang_hadir'] }}</p>
                    </div>
                </div>

                {{-- Daftar Ucapan Mobile (Kartu Bertumpuk) --}}
                <div class="mt-5 space-y-3 md:hidden">
                    @forelse ($undangan->bukuTamu as $ucapan)
                        <div class="rounded-xl bg-ivory/75 p-4 ring-1 ring-champagne/20 space-y-2">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <p class="font-semibold text-sm text-charcoal">{{ $ucapan->nama_tamu }}</p>
                                    <p class="text-xs text-charcoal/60">{{ $ucapan->jumlah_tamu }} tamu</p>
                                </div>
                                <span class="rounded-full px-2.5 py-0.5 text-[11px] font-semibold shrink-0 {{ $ucapan->status_kehadiran === 'hadir' ? 'bg-sage/15 text-sage' : ($ucapan->status_kehadiran === 'ragu' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-700') }}">
                                    {{ str_replace('_', ' ', ucfirst($ucapan->status_kehadiran)) }}
                                </span>
                            </div>
                            <p class="text-xs text-charcoal/80 leading-relaxed">{{ $ucapan->ucapan_doa }}</p>
                            <div class="flex justify-end pt-1">
                                <form action="{{ route('dasbor.ucapan.hapus', [$undangan, $ucapan]) }}" method="POST" onsubmit="return confirm('Hapus komentar ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-red-600 hover:underline cursor-pointer">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="py-6 text-center text-xs text-charcoal/60">Belum ada ucapan atau konfirmasi kehadiran dari tamu.</p>
                    @endforelse
                </div>

                {{-- Daftar Ucapan Desktop (Tabel) --}}
                <div class="mt-6 hidden md:block overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b border-champagne/20 text-left text-xs uppercase text-charcoal/60">
                                <th class="py-3 pr-4">Nama Tamu</th>
                                <th class="py-3 pr-4">Status</th>
                                <th class="py-3 pr-4">Jumlah</th>
                                <th class="py-3 pr-4">Ucapan &amp; Doa</th>
                                <th class="py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-champagne/15">
                            @forelse ($undangan->bukuTamu as $ucapan)
                                <tr>
                                    <td class="py-3 pr-4 font-semibold text-charcoal">{{ $ucapan->nama_tamu }}</td>
                                    <td class="py-3 pr-4">
                                        <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $ucapan->status_kehadiran === 'hadir' ? 'bg-sage/15 text-sage' : ($ucapan->status_kehadiran === 'ragu' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-700') }}">
                                            {{ str_replace('_', ' ', ucfirst($ucapan->status_kehadiran)) }}
                                        </span>
                                    </td>
                                    <td class="py-3 pr-4">{{ $ucapan->jumlah_tamu }}</td>
                                    <td class="py-3 pr-4 text-charcoal/80">{{ $ucapan->ucapan_doa }}</td>
                                    <td class="py-3 text-right">
                                        <form action="{{ route('dasbor.ucapan.hapus', [$undangan, $ucapan]) }}" method="POST" onsubmit="return confirm('Hapus komentar ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs font-semibold text-red-600 hover:underline cursor-pointer">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-charcoal/60">Belum ada ucapan atau konfirmasi kehadiran dari tamu.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        {{-- TAB 7: Pembayaran & Aktivasi --}}
        <section x-show="tab === 'aktivasi'" x-cloak class="space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="rounded-2xl bg-white p-4 sm:p-8 shadow-sm ring-1 ring-champagne/20">
                    <h2 class="font-serif text-xl sm:text-2xl font-bold text-charcoal">Ajukan Pembayaran Aktivasi</h2>
                    <p class="mt-1 text-sm text-charcoal/65">
                        Masa aktif standar undangan adalah <strong>{{ $durasiAktifBulan ?? 3 }} bulan</strong> sejak diverifikasi lunas oleh Admin.
                    </p>

                    <form
                        action="{{ route('dasbor.transaksi.ajukan', $undangan) }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="mt-6 space-y-4"
                        data-swal-loading
                        data-swal-loading-title="Membuat Invoice Pembayaran..."
                        data-swal-loading-text="Sedang memproses pengajuan order &amp; voucher Anda..."
                    >
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-charcoal">Paket Layanan</label>
                            <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <label class="flex items-start gap-2.5 rounded-xl border border-champagne/35 bg-ivory/60 p-3 cursor-pointer">
                                    <input type="radio" name="paket" value="mandiri" checked class="mt-1 text-sage">
                                    <span class="text-xs">
                                        <span class="block font-bold text-charcoal">Paket Mandiri</span>
                                        @if ($undangan->tema?->adaDiskon())
                                            <span class="text-charcoal/45 line-through mr-1">{{ $undangan->tema->hargaAsliFormatted() }}</span>
                                            <span class="font-semibold text-rose-600">{{ $undangan->tema->hargaFormatted() }}</span>
                                        @else
                                            <span class="text-charcoal/65">{{ $undangan->tema?->hargaFormatted() }}</span>
                                        @endif
                                    </span>
                                </label>
                                <label class="flex items-start gap-2.5 rounded-xl border border-champagne/35 bg-ivory/60 p-3 cursor-pointer">
                                    <input type="radio" name="paket" value="terima_beres" class="mt-1 text-sage">
                                    <span class="text-xs">
                                        <span class="block font-bold text-charcoal">Paket Terima Beres</span>
                                        <span class="text-charcoal/65">{{ $undangan->tema?->hargaTerimaBeresFormatted() }}</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label for="kode_promo" class="block text-sm font-medium text-charcoal">Kode Promo / Voucher (Opsional)</label>
                            <input
                                id="kode_promo"
                                type="text"
                                name="kode_promo"
                                value="{{ old('kode_promo') }}"
                                placeholder="Masukkan kode voucher bila ada"
                                class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm uppercase font-mono focus:border-champagne focus:outline-none"
                            >
                        </div>

                        <div>
                            <label for="bukti_pembayaran" class="block text-sm font-medium text-charcoal">Unggah Bukti Transfer (Opsional — bisa menyusul)</label>
                            <input
                                id="bukti_pembayaran"
                                type="file"
                                name="bukti_pembayaran"
                                accept="image/*"
                                class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3 py-2 text-xs"
                            >
                        </div>

                        <button type="submit" class="w-full rounded-xl bg-sage px-5 py-3 text-sm font-semibold text-white hover:bg-sage/90 cursor-pointer transition">
                            Buat Invoice &amp; Ajukan Aktivasi
                        </button>
                    </form>
                </div>

                <div class="rounded-2xl bg-charcoal text-ivory p-6 sm:p-8 shadow-sm space-y-5">
                    <div>
                        <p class="text-xs uppercase tracking-widest text-champagne font-semibold">Tujuan Pembayaran Resmi</p>
                        <h3 class="mt-2 font-serif text-2xl font-bold text-white">{{ $infoRekening['bank'] }}</h3>
                        <p class="mt-1 font-mono text-xl font-bold text-champagne">{{ $infoRekening['rekening'] }}</p>
                        <p class="text-sm text-ivory/80">a.n. {{ $infoRekening['atas_nama'] }}</p>
                    </div>

                    <div class="rounded-xl bg-white/5 border border-white/10 p-4 text-xs text-ivory/80 leading-relaxed">
                        {{ $infoRekening['catatan'] }}
                    </div>

                    <a
                        href="{{ \App\Support\PengaturanSesiTemu::urlWaAdmin($pesanWaAktivasi) }}"
                        target="_blank"
                        rel="noopener"
                        class="inline-flex w-full items-center justify-center rounded-xl bg-champagne px-5 py-3 text-sm font-semibold text-charcoal hover:bg-champagne/90 transition"
                    >
                        Konfirmasi Pembayaran via WhatsApp Admin
                    </a>
                </div>
            </div>

            <div class="rounded-2xl bg-white p-4 sm:p-6 shadow-sm ring-1 ring-champagne/20">
                <h3 class="text-base font-bold text-charcoal mb-4">Riwayat Invoice Undangan Ini</h3>

                {{-- Riwayat Invoice Mobile (Kartu) --}}
                <div class="space-y-3 md:hidden">
                    @forelse ($undangan->transaksi as $trx)
                        <div class="rounded-xl bg-ivory/75 p-4 ring-1 ring-champagne/20 space-y-2.5">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <p class="font-mono font-bold text-sm text-charcoal">{{ $trx->kode_invoice }}</p>
                                    <p class="text-xs text-charcoal/70">{{ $trx->labelPaket() }} • {{ $trx->tema?->nama_tema }}</p>
                                </div>
                                <span class="rounded-full px-2.5 py-0.5 text-[11px] font-semibold shrink-0 {{ $trx->status === 'lunas' ? 'bg-sage/15 text-sage' : ($trx->status === 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-800') }}">
                                    {{ $trx->labelStatus() }}
                                </span>
                            </div>
                            <p class="text-sm font-bold text-charcoal">{{ \App\Models\Tema::formatRupiah($trx->total_bayar) }}</p>
                            @if ($trx->catatan_admin)
                                <p class="text-xs text-charcoal/65">{{ $trx->catatan_admin }}</p>
                            @endif
                            <div class="pt-1">
                                @if ($trx->status !== 'lunas')
                                    <form action="{{ route('dasbor.transaksi.unggah', $trx) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-2">
                                        @csrf
                                        <input type="file" name="bukti_pembayaran" accept="image/*" required class="w-full text-xs">
                                        <button type="submit" class="w-full rounded-xl bg-sage px-3 py-2 text-xs font-semibold text-white hover:bg-sage/90 cursor-pointer">
                                            Unggah Bukti Pembayaran
                                        </button>
                                    </form>
                                @elseif ($trx->urlBukti())
                                    <a href="{{ $trx->urlBukti() }}" target="_blank" class="inline-block text-xs font-semibold text-sage hover:underline">Lihat Bukti Transfer</a>
                                @else
                                    <span class="text-xs text-charcoal/50">Terverifikasi Admin</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="py-6 text-center text-xs text-charcoal/60">Belum ada invoice pembayaran untuk undangan ini.</p>
                    @endforelse
                </div>

                {{-- Riwayat Invoice Desktop (Tabel) --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b border-champagne/20 text-left text-xs uppercase text-charcoal/60">
                                <th class="py-3 pr-4">Invoice</th>
                                <th class="py-3 pr-4">Paket &amp; Tema</th>
                                <th class="py-3 pr-4">Total Bayar</th>
                                <th class="py-3 pr-4">Status</th>
                                <th class="py-3 text-right">Bukti Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-champagne/15">
                            @forelse ($undangan->transaksi as $trx)
                                <tr>
                                    <td class="py-3 pr-4 font-mono font-bold text-charcoal">{{ $trx->kode_invoice }}</td>
                                    <td class="py-3 pr-4">
                                        <p class="font-medium">{{ $trx->labelPaket() }}</p>
                                        <p class="text-xs text-charcoal/60">{{ $trx->tema?->nama_tema }}</p>
                                    </td>
                                    <td class="py-3 pr-4 font-bold text-charcoal">{{ \App\Models\Tema::formatRupiah($trx->total_bayar) }}</td>
                                    <td class="py-3 pr-4">
                                        <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $trx->status === 'lunas' ? 'bg-sage/15 text-sage' : ($trx->status === 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-800') }}">
                                            {{ $trx->labelStatus() }}
                                        </span>
                                        @if ($trx->catatan_admin)
                                            <p class="mt-1 text-xs text-charcoal/60">{{ $trx->catatan_admin }}</p>
                                        @endif
                                    </td>
                                    <td class="py-3 text-right">
                                        @if ($trx->status !== 'lunas')
                                            <form action="{{ route('dasbor.transaksi.unggah', $trx) }}" method="POST" enctype="multipart/form-data" class="inline-flex items-center gap-2">
                                                @csrf
                                                <input type="file" name="bukti_pembayaran" accept="image/*" required class="w-40 text-xs">
                                                <button type="submit" class="rounded-lg bg-sage px-3 py-1.5 text-xs font-semibold text-white hover:bg-sage/90 cursor-pointer">
                                                    Unggah Bukti
                                                </button>
                                            </form>
                                        @elseif ($trx->urlBukti())
                                            <a href="{{ $trx->urlBukti() }}" target="_blank" class="text-xs font-semibold text-sage hover:underline">Lihat Bukti</a>
                                        @else
                                            <span class="text-xs text-charcoal/50">Terverifikasi Admin</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-charcoal/60">Belum ada invoice pembayaran untuk undangan ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    {{-- Bottom Navbar Editor 7-Tab Mobile-First (Khusus Tampilan Mobile) --}}
    <nav
        aria-label="Navigasi Editor Undangan"
        data-client-bottom-nav
        class="md:hidden fixed bottom-0 inset-x-0 z-40 bg-white/95 backdrop-blur-md border-t border-champagne/25 shadow-[0_-8px_28px_-10px_rgba(31,41,55,0.14)] pb-[env(safe-area-inset-bottom)]"
    >
        <div class="flex items-stretch overflow-x-auto no-scrollbar h-16 px-1.5 gap-1">
            @foreach ($daftarTabEditor as $kode => $metaTab)
                <button
                    type="button"
                    data-mobile-tab="{{ $kode }}"
                    @click="pilihTab('{{ $kode }}')"
                    :class="tab === '{{ $kode }}' ? 'text-sage bg-sage/10 font-bold' : 'text-charcoal/65 hover:text-charcoal hover:bg-ivory font-medium'"
                    class="relative min-w-[68px] flex-1 flex flex-col items-center justify-center gap-0.5 rounded-xl px-1.5 py-1 transition cursor-pointer shrink-0"
                >
                    <span
                        x-show="tab === '{{ $kode }}'"
                        x-cloak
                        class="absolute top-0.5 inset-x-4 h-0.5 rounded-full bg-sage"
                    ></span>

                    @switch($kode)
                        @case('tema')
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/>
                                <circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/>
                                <circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/>
                                <circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/>
                                <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/>
                            </svg>
                            @break
                        @case('mempelai')
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                            </svg>
                            @break
                        @case('acara')
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                                <line x1="16" x2="16" y1="2" y2="6"/>
                                <line x1="8" x2="8" y1="2" y2="6"/>
                                <line x1="3" x2="21" y1="10" y2="10"/>
                            </svg>
                            @break
                        @case('galeri')
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="18" height="18" x="3" y="3" rx="2" ry="2"/>
                                <circle cx="9" cy="9" r="2"/>
                                <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                            </svg>
                            @break
                        @case('amplop')
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="3" y="8" width="18" height="4" rx="1"/>
                                <path d="M12 8v13"/>
                                <path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"/>
                                <path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"/>
                            </svg>
                            @break
                        @case('tamu')
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="m22 2-7 20-4-9-9-4Z"/>
                                <path d="M22 2 11 13"/>
                            </svg>
                            @break
                        @case('aktivasi')
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="20" height="14" x="2" y="5" rx="2"/>
                                <line x1="2" x2="22" y1="10" y2="10"/>
                            </svg>
                            @break
                    @endswitch

                    <span class="text-[11px] leading-tight whitespace-nowrap">{{ $metaTab['label_mobile'] }}</span>
                </button>
            @endforeach
        </div>
    </nav>
</div>
@endsection
