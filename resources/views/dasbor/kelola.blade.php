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
    {{-- Header --}}
    <header class="bg-white border-b border-champagne/20 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3 min-w-0">
                <a href="{{ auth()->user()->adalahAdmin() ? route('admin.undangan.index') : route('dasbor.index') }}" class="rounded-xl border border-charcoal/15 px-3 py-1.5 text-xs font-semibold text-charcoal hover:bg-ivory transition shrink-0">
                    ← Kembali
                </a>
                <div class="truncate">
                    <h1 class="font-serif text-lg sm:text-xl font-bold text-charcoal truncate">
                        {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
                    </h1>
                    <p class="text-xs font-mono text-sage truncate">sesitemu.id/{{ $undangan->slug }}</p>
                </div>
            </div>

            <div class="flex items-center gap-2.5 shrink-0">
                <a href="{{ $urlPublik }}" target="_blank" class="rounded-xl border border-champagne px-3.5 py-1.5 text-xs sm:text-sm font-semibold text-charcoal hover:bg-champagne/10 transition">
                    Pratinjau Undangan
                </a>

                @if (! $undangan->status_publikasi && ! auth()->user()->adalahAdmin())
                    <a
                        href="https://wa.me/6281234567890?text={{ urlencode($pesanWaAktivasi) }}"
                        target="_blank"
                        rel="noopener"
                        class="rounded-xl bg-champagne px-3.5 py-1.5 text-xs sm:text-sm font-semibold text-charcoal hover:bg-champagne/90 transition"
                    >
                        Aktifkan via WA
                    </a>
                @endif
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
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

        {{-- Navigasi 6 Tab --}}
        <div class="flex flex-wrap gap-2 bg-white p-2 rounded-2xl shadow-sm ring-1 ring-champagne/20">
            @foreach ([
                'tema' => '1. Tema & Link',
                'mempelai' => '2. Data Mempelai',
                'acara' => '3. Rangkaian Acara',
                'galeri' => '4. Galeri & Cerita',
                'amplop' => '5. Amplop Digital',
                'tamu' => '6. Sebar Tamu & RSVP',
            ] as $kode => $label)
                <button
                    type="button"
                    @click="tab = '{{ $kode }}'"
                    :class="tab === '{{ $kode }}' ? 'bg-sage text-white shadow-sm' : 'text-charcoal/75 hover:bg-ivory'"
                    class="rounded-xl px-4 py-2 text-xs sm:text-sm font-semibold transition cursor-pointer"
                >
                    {{ $label }}
                </button>
            @endforeach
        </div>

        {{-- TAB 1: Tema & Pengaturan Link --}}
        <section x-show="tab === 'tema'" x-cloak class="rounded-2xl bg-white p-6 sm:p-8 shadow-sm ring-1 ring-champagne/20">
            <h2 class="font-serif text-2xl font-bold text-charcoal">Tema, Musik &amp; Pengaturan Link</h2>
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
                                    {{ $tema->nama_tema }} ({{ ucfirst($tema->kategori) }})
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

                    <div class="md:col-span-2">
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
                    <button type="submit" class="rounded-xl bg-sage px-6 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer">
                        Simpan Pengaturan Tema &amp; Link
                    </button>
                </div>
            </form>
        </section>

        {{-- TAB 2: Data Mempelai --}}
        <section x-show="tab === 'mempelai'" x-cloak class="rounded-2xl bg-white p-6 sm:p-8 shadow-sm ring-1 ring-champagne/20">
            <h2 class="font-serif text-2xl font-bold text-charcoal">Data Kedua Mempelai &amp; Kutipan Doa</h2>
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

                <div>
                    <label for="kutipan_ayat" class="block text-sm font-medium text-charcoal">Kutipan Ayat / Doa / Kata Mutiara</label>
                    <textarea id="kutipan_ayat" name="kutipan_ayat" rows="3" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm">{{ old('kutipan_ayat', $undangan->kutipan_ayat) }}</textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="rounded-xl bg-sage px-6 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer">
                        Simpan Data Mempelai
                    </button>
                </div>
            </form>
        </section>

        {{-- TAB 3: Rangkaian Acara --}}
        <section x-show="tab === 'acara'" x-cloak class="space-y-6">
            <div class="rounded-2xl bg-white p-6 sm:p-8 shadow-sm ring-1 ring-champagne/20">
                <div class="flex items-center justify-between">
                    <h2 class="font-serif text-2xl font-bold text-charcoal" x-text="acaraEdit ? 'Edit Jadwal Acara' : 'Tambah Jadwal Acara'"></h2>
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

                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <label class="block text-sm font-medium text-charcoal">Mulai</label>
                            <input type="time" name="waktu_mulai" :value="acaraEdit ? acaraEdit.waktu_mulai : '08:00'" required class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-2.5 py-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-charcoal">Selesai</label>
                            <input type="time" name="waktu_selesai" :value="acaraEdit ? acaraEdit.waktu_selesai : ''" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-2.5 py-2 text-sm">
                        </div>
                        <div>
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
                        <button type="submit" class="rounded-xl bg-sage px-6 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer" x-text="acaraEdit ? 'Perbarui Acara' : '+ Tambah Acara'">
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
            <div class="rounded-2xl bg-white p-6 sm:p-8 shadow-sm ring-1 ring-champagne/20">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-serif text-2xl font-bold text-charcoal">Galeri Foto Prewedding</h2>
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
            <div class="rounded-2xl bg-white p-6 sm:p-8 shadow-sm ring-1 ring-champagne/20">
                <h2 class="font-serif text-2xl font-bold text-charcoal">Cerita Cinta &amp; Live Streaming</h2>

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
                        <button type="submit" class="rounded-xl bg-sage px-6 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer">
                            Simpan Cerita &amp; Live Streaming
                        </button>
                    </div>
                </form>
            </div>
        </section>

        {{-- TAB 5: Amplop Digital --}}
        <section x-show="tab === 'amplop'" x-cloak class="space-y-6">
            <div class="rounded-2xl bg-white p-6 sm:p-8 shadow-sm ring-1 ring-champagne/20">
                <h2 class="font-serif text-2xl font-bold text-charcoal">Tambah Rekening / E-Wallet Amplop Digital</h2>

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

            <div class="rounded-2xl bg-white p-6 sm:p-8 shadow-sm ring-1 ring-champagne/20">
                <h3 class="font-serif text-xl font-bold text-charcoal">Alamat Pengiriman Kado Fisik</h3>
                <form action="{{ route('dasbor.undangan.perbarui', $undangan) }}" method="POST" class="mt-4 space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="bagian" value="kado_fisik">
                    <textarea name="alamat_kado_fisik" rows="2" placeholder="Jl. Contoh No. 12, Jakarta Selatan..." class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm">{{ old('alamat_kado_fisik', $pengaturan['alamat_kado_fisik'] ?? '') }}</textarea>
                    <div class="flex justify-end">
                        <button type="submit" class="rounded-xl bg-sage px-6 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer">
                            Simpan Alamat Kado
                        </button>
                    </div>
                </form>
            </div>
        </section>

        {{-- TAB 6: Sebar Tamu & Buku Tamu (RSVP) --}}
        <section x-show="tab === 'tamu'" x-cloak class="space-y-6">
            {{-- Generator Link Tamu WhatsApp --}}
            <div class="rounded-2xl bg-white p-6 sm:p-8 shadow-sm ring-1 ring-champagne/20">
                <h2 class="font-serif text-2xl font-bold text-charcoal">Generator Link Tamu WhatsApp</h2>
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
            <div class="rounded-2xl bg-white p-6 sm:p-8 shadow-sm ring-1 ring-champagne/20">
                <h2 class="font-serif text-2xl font-bold text-charcoal">Rekapitulasi Kehadiran &amp; Buku Tamu</h2>

                <div class="mt-5 grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="rounded-xl bg-sage/10 p-4">
                        <p class="text-xs text-charcoal/70">Konfirmasi Hadir</p>
                        <p class="mt-1 font-serif text-3xl font-bold text-sage">{{ $rekapRsvp['hadir'] }}</p>
                    </div>
                    <div class="rounded-xl bg-amber-50 p-4">
                        <p class="text-xs text-charcoal/70">Masih Ragu</p>
                        <p class="mt-1 font-serif text-3xl font-bold text-amber-700">{{ $rekapRsvp['ragu'] }}</p>
                    </div>
                    <div class="rounded-xl bg-red-50 p-4">
                        <p class="text-xs text-charcoal/70">Tidak Hadir</p>
                        <p class="mt-1 font-serif text-3xl font-bold text-red-700">{{ $rekapRsvp['tidak_hadir'] }}</p>
                    </div>
                    <div class="rounded-xl bg-champagne/15 p-4">
                        <p class="text-xs text-charcoal/70">Estimasi Orang Hadir</p>
                        <p class="mt-1 font-serif text-3xl font-bold text-charcoal">{{ $rekapRsvp['total_orang_hadir'] }}</p>
                    </div>
                </div>

                <div class="mt-6 overflow-x-auto">
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
    </main>
</div>
@endsection
