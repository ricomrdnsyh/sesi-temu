@php
    $teksAmplopDikustom = filled($teksKustom['judul_amplop'] ?? '')
        || filled($teksKustom['pengantar_amplop'] ?? '');
    $adaAlamatKado = filled($pengaturan['alamat_kado_fisik'] ?? '');
    $judulBukuTamuDikustom = filled($teksKustom['judul_buku_tamu'] ?? '');
    $doaDikustom = ! empty($teksKustom['doa_kustom']);
    $turutDikustom = filled($teksKustom['judul_turut_mengundang'] ?? '')
        || filled(data_get($pengaturan, 'turut_mengundang.pihak_wanita', ''))
        || filled(data_get($pengaturan, 'turut_mengundang.pihak_pria', ''));
    $penutupDikustom = filled($undangan->urlFotoPenutupKhususDashboard())
        || filled($teksKustom['judul_penutup'] ?? '')
        || filled($teksKustom['ucapan_penutup'] ?? '')
        || filled($teksKustom['label_penutup'] ?? '')
        || filled(data_get($pengaturan, 'hashtag', ''));
@endphp

{{-- ACCORDION 6: Amplop & Kado (Seksi 9 Undangan) --}}
<div
    :class="tab === 'amplop' ? 'border-sage/45 ring-1 ring-sage/15 shadow-xs' : 'border-champagne/30 hover:border-champagne/60'"
    class="rounded-2xl border bg-white overflow-hidden transition"
>
    <div class="px-4 py-3.5 flex items-center justify-between gap-2 hover:bg-ivory/50 transition">
        <button
            type="button"
            data-mobile-tab="amplop"
            @click="toggleBagian('amplop')"
            class="flex-1 flex items-center justify-between gap-2 min-w-0 text-left cursor-pointer"
        >
            <span class="flex items-center gap-2.5 min-w-0">
                <svg
                    :class="tab === 'amplop' ? 'rotate-90 text-sage' : 'text-charcoal/45'"
                    class="h-4 w-4 shrink-0 transition-transform duration-200"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                >
                    <path d="m9 18 6-6-6-6"/>
                </svg>
                <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-sage/12 text-[11px] font-bold text-sage shrink-0">6</span>
                <span class="font-sans text-sm font-semibold text-charcoal truncate" :class="!sakelarFitur.amplop_digital ? 'opacity-55' : ''">Amplop &amp; Kado</span>
            </span>
            <span class="rounded-full bg-ivory px-2 py-0.5 font-sans tabular-nums text-[11px] font-semibold text-sage ring-1 ring-champagne/25 shrink-0">
                {{ $undangan->daftarAmplop->count() }} Kartu
            </span>
        </button>
        <button
            type="button"
            role="switch"
            data-toggle-fitur="amplop_digital"
            :aria-checked="sakelarFitur.amplop_digital ? 'true' : 'false'"
            :disabled="fiturMenyimpan.amplop_digital"
            @click.stop="toggleFitur('amplop_digital')"
            :class="sakelarFitur.amplop_digital ? 'bg-sage' : 'bg-charcoal/25'"
            class="relative inline-flex h-5 w-9 shrink-0 items-center rounded-full p-0.5 transition-colors cursor-pointer disabled:opacity-60"
            title="Tampilkan atau sembunyikan Amplop Digital"
            aria-label="Tampilkan Amplop Digital"
        >
            <span
                :class="sakelarFitur.amplop_digital ? 'translate-x-4' : 'translate-x-0'"
                class="pointer-events-none block h-4 w-4 rounded-full bg-white shadow-xs transition-transform"
            ></span>
        </button>
    </div>

    <section x-show="tab === 'amplop'" x-cloak class="px-4 pb-5 pt-3 border-t border-champagne/20 space-y-4">
        <div x-show="!sakelarFitur.amplop_digital" x-cloak class="rounded-xl border border-amber-200 bg-amber-50/80 px-3 py-2 text-xs text-amber-800">
            Bagian <strong>Amplop Digital</strong> sedang disembunyikan. Nyalakan sakelar di kanan atas untuk menampilkannya.
        </div>

        {{-- 6A. Judul & Pengantar Amplop (Tampil di Atas Kartu Rekening) --}}
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
                    <span class="text-xs font-semibold text-charcoal truncate">Ubah Judul &amp; Pengantar Amplop</span>
                </span>
                <span class="flex items-center gap-1.5 shrink-0">
                    <span class="rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $teksAmplopDikustom ? 'bg-sage/12 text-sage' : 'bg-white text-charcoal/50 ring-1 ring-champagne/30' }}">
                        {{ $teksAmplopDikustom ? 'Dikustom' : 'Bawaan' }}
                    </span>
                    <svg :class="buka ? 'rotate-180 text-sage' : 'text-charcoal/45'" class="h-3.5 w-3.5 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m6 9 6 6 6-6"/>
                    </svg>
                </span>
            </button>
            <div x-show="buka" x-cloak class="px-3.5 pb-4 pt-3 border-t border-champagne/20 bg-white/80">
                <div data-bagian-utama="amplop_teks" class="space-y-3">
                    <div>
                        <label for="teks_judul_amplop" class="block text-xs font-semibold text-charcoal/80">Judul Bagian Amplop</label>
                        <input
                            id="teks_judul_amplop"
                            type="text"
                            name="teks[judul_amplop]"
                            value="{{ $nilaiTeksEditor('judul_amplop') }}"
                            placeholder="{{ $teksBawaanTema['judul_amplop'] ?: 'Amplop Digital / Hadiah Pernikahan' }}"
                            class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none"
                        >
                    </div>
                    <div>
                        <label for="teks_pengantar_amplop" class="block text-xs font-semibold text-charcoal/80">Kalimat Pengantar</label>
                        <textarea id="teks_pengantar_amplop" name="teks[pengantar_amplop]" rows="2" placeholder="{{ $teksBawaanTema['pengantar_amplop'] ?: 'Doa restu Anda merupakan karunia terindah bagi kami...' }}" class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none">{{ $nilaiTeksEditor('pengantar_amplop') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- 6B. Rekening Bank / E-Wallet + Pratinjau Kartu --}}
        <div class="grid grid-cols-1 gap-4 rounded-2xl bg-ivory/75 p-4 ring-1 ring-champagne/25">
            <form
                action="{{ route('dashboard.amplop.simpan', $undangan) }}"
                method="POST"
                class="space-y-3"
                data-swal-loading
                data-swal-loading-title="Menambahkan Kartu Rekening..."
                data-swal-loading-text="Menyimpan rekening amplop digital ke undangan..."
            >
                @csrf
                <div class="space-y-1.5">
                    <span class="block text-xs font-semibold text-charcoal/80">Pilih Cepat Bank / E-Wallet</span>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach (\App\Support\GayaKartuBank::pilihanCepat() as $opsiBank)
                            @php $gayaOpsi = \App\Support\GayaKartuBank::untukNamaBank($opsiBank); @endphp
                            <button
                                type="button"
                                @click="bankBaru = @js($opsiBank)"
                                :class="bankBaru.toLowerCase() === @js(strtolower($opsiBank)) ? 'bg-sage text-white ring-sage' : 'bg-white text-charcoal ring-champagne/30 hover:bg-ivory'"
                                class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-[11px] font-semibold ring-1 transition cursor-pointer"
                            >
                                <span class="w-2 h-2 rounded-full shrink-0" style="background: {{ $gayaOpsi['gradient_css'] }}"></span>
                                <span>{{ $opsiBank }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-charcoal/80">Nama Bank / E-Wallet</label>
                        <input type="text" name="nama_bank" x-model="bankBaru" required placeholder="BCA / Mandiri / GoPay..." class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-sage focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-charcoal/80">Nomor Rekening / HP</label>
                        <input type="text" name="nomor_rekening" x-model="nomorBaru" required placeholder="1234567890" class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-sage focus:outline-none">
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-end gap-3">
                    <div class="flex-1">
                        <label class="block text-xs font-semibold text-charcoal/80">Atas Nama</label>
                        <input type="text" name="atas_nama" x-model="atasNamaBaru" required placeholder="{{ $undangan->nama_lengkap_pria }}" class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-sage focus:outline-none">
                    </div>
                    <button type="submit" class="rounded-xl bg-sage px-5 py-2 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer shrink-0">
                        + Tambah
                    </button>
                </div>
            </form>

            {{-- Pratinjau Kartu Live --}}
            <div class="space-y-2">
                <div class="flex items-center justify-between px-0.5">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-charcoal/60">Pratinjau Kartu Bank Live</span>
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-sage">
                        <span class="w-1.5 h-1.5 rounded-full bg-sage animate-pulse"></span>
                        Otomatis
                    </span>
                </div>
                @include('dashboard._kartu-bank-digital', ['modeLive' => true])
            </div>
        </div>

        {{-- Daftar Kartu Tersimpan --}}
        @if ($undangan->daftarAmplop->isNotEmpty())
            <div class="space-y-2.5">
                <h3 class="font-sans text-xs font-bold uppercase tracking-wider text-charcoal/65">Koleksi Kartu Rekening Tersimpan</h3>
                <div class="grid grid-cols-1 gap-3">
                    @foreach ($undangan->daftarAmplop as $amplop)
                        @include('dashboard._kartu-bank-digital', [
                            'modeLive' => false,
                            'amplop' => $amplop,
                            'undangan' => $undangan,
                        ])
                    @endforeach
                </div>
            </div>
        @endif

        {{-- 6C. Alamat Pengiriman Kado Fisik (Tampil di Bawah Kartu Rekening) --}}
        <div x-data="{ buka: false }" class="rounded-2xl border border-champagne/30 bg-ivory/50 overflow-hidden">
            <button
                type="button"
                @click="buka = !buka"
                class="w-full px-3.5 py-2.5 flex items-center justify-between gap-2 text-left hover:bg-ivory transition cursor-pointer"
            >
                <span class="flex items-center gap-2 min-w-0">
                    <svg class="h-3.5 w-3.5 text-sage shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="3" y="8" width="18" height="4" rx="1"/>
                        <path d="M12 8v13"/>
                        <path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"/>
                    </svg>
                    <span class="text-xs font-semibold text-charcoal truncate">Alamat Pengiriman Kado Fisik</span>
                </span>
                <span class="flex items-center gap-1.5 shrink-0">
                    <span class="rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $adaAlamatKado ? 'bg-sage/12 text-sage' : 'bg-white text-charcoal/50 ring-1 ring-champagne/30' }}">
                        {{ $adaAlamatKado ? 'Terisi' : 'Opsional' }}
                    </span>
                    <svg :class="buka ? 'rotate-180 text-sage' : 'text-charcoal/45'" class="h-3.5 w-3.5 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m6 9 6 6 6-6"/>
                    </svg>
                </span>
            </button>
            <div x-show="buka" x-cloak class="px-3.5 pb-4 pt-3 border-t border-champagne/20 bg-white/80">
                <div data-bagian-utama="kado_fisik" class="space-y-3">
                    <div>
                        <label for="alamat_kado_fisik" class="block text-xs font-semibold text-charcoal/80">Alamat Lengkap Penerima Kado</label>
                        <textarea id="alamat_kado_fisik" name="alamat_kado_fisik" rows="2" placeholder="Jl. Contoh No. 12, Jakarta Selatan..." class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none">{{ old('alamat_kado_fisik', $pengaturan['alamat_kado_fisik'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- ACCORDION 7: Buku Tamu, Doa, Turut Mengundang & Penutup (Seksi 10, 11 & 12 Undangan) --}}
<div
    :class="tab === 'penutup' ? 'border-sage/45 ring-1 ring-sage/15 shadow-xs' : 'border-champagne/30 hover:border-champagne/60'"
    class="rounded-2xl border bg-white overflow-hidden transition"
>
    <div class="px-4 py-3.5 flex items-center justify-between gap-2 hover:bg-ivory/50 transition">
        <button
            type="button"
            data-mobile-tab="penutup"
            @click="toggleBagian('penutup')"
            class="flex-1 flex items-center justify-between gap-2 min-w-0 text-left cursor-pointer"
        >
            <span class="flex items-center gap-2.5 min-w-0">
                <svg
                    :class="tab === 'penutup' ? 'rotate-90 text-sage' : 'text-charcoal/45'"
                    class="h-4 w-4 shrink-0 transition-transform duration-200"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                >
                    <path d="m9 18 6-6-6-6"/>
                </svg>
                <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-sage/12 text-[11px] font-bold text-sage shrink-0">7</span>
                <span class="font-sans text-sm font-semibold text-charcoal truncate" :class="!sakelarFitur.buku_tamu ? 'opacity-55' : ''">Buku Tamu, Doa &amp; Penutup</span>
            </span>
            <span class="rounded-full bg-ivory px-2 py-0.5 font-sans tabular-nums text-[11px] font-semibold text-sage ring-1 ring-champagne/25 shrink-0">
                {{ $undangan->bukuTamu->count() }} Ucapan
            </span>
        </button>
        <button
            type="button"
            role="switch"
            data-toggle-fitur="buku_tamu"
            :aria-checked="sakelarFitur.buku_tamu ? 'true' : 'false'"
            :disabled="fiturMenyimpan.buku_tamu"
            @click.stop="toggleFitur('buku_tamu')"
            :class="sakelarFitur.buku_tamu ? 'bg-sage' : 'bg-charcoal/25'"
            class="relative inline-flex h-5 w-9 shrink-0 items-center rounded-full p-0.5 transition-colors cursor-pointer disabled:opacity-60"
            title="Tampilkan atau sembunyikan Buku Tamu &amp; RSVP"
            aria-label="Tampilkan Buku Tamu &amp; RSVP"
        >
            <span
                :class="sakelarFitur.buku_tamu ? 'translate-x-4' : 'translate-x-0'"
                class="pointer-events-none block h-4 w-4 rounded-full bg-white shadow-xs transition-transform"
            ></span>
        </button>
    </div>

    <section x-show="tab === 'penutup'" x-cloak class="px-4 pb-5 pt-3 border-t border-champagne/20 space-y-3.5">
        <div x-show="!sakelarFitur.buku_tamu" x-cloak class="rounded-xl border border-amber-200 bg-amber-50/80 px-3 py-2 text-xs text-amber-800">
            Formulir <strong>Buku Tamu &amp; RSVP</strong> sedang disembunyikan. Nyalakan sakelar di kanan atas untuk menampilkannya.
        </div>

        {{-- 7A. Buku Tamu & RSVP (Seksi 10 Undangan) --}}
        <div class="rounded-2xl bg-ivory/75 p-3.5 ring-1 ring-champagne/25 flex items-center justify-between gap-3">
            <div class="min-w-0">
                <p class="text-xs font-bold text-charcoal">Ucapan &amp; Kehadiran (RSVP)</p>
                <p class="text-[11px] text-charcoal/60">Lihat daftar tamu yang hadir dan kelola ucapan.</p>
            </div>
            <a
                href="{{ route('dashboard.undangan.tamu', [$undangan, 'subtab' => 'rsvp']) }}"
                class="inline-flex items-center gap-1 rounded-xl bg-white px-3 py-2 text-xs font-semibold text-sage ring-1 ring-champagne/35 hover:bg-sage hover:text-white transition shrink-0"
            >
                <span>Lihat RSVP</span>
                <span aria-hidden="true">&rarr;</span>
            </a>
        </div>

        {{-- Seksi 10 -> 11 -> 12 Undangan (disimpan lewat tombol Simpan Semua) --}}
        <div data-bagian-utama="penutup" class="space-y-3">

            {{-- 7A (lanjutan): Ubah Judul Buku Tamu --}}
            <div x-data="{ buka: false }" class="rounded-2xl border border-champagne/30 bg-ivory/50 overflow-hidden">
                <button type="button" @click="buka = !buka" class="w-full px-3.5 py-2.5 flex items-center justify-between gap-2 text-left hover:bg-ivory transition cursor-pointer">
                    <span class="text-xs font-semibold text-charcoal truncate">Ubah Judul Buku Tamu / RSVP</span>
                    <span class="flex items-center gap-1.5 shrink-0">
                        <span class="rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $judulBukuTamuDikustom ? 'bg-sage/12 text-sage' : 'bg-white text-charcoal/50 ring-1 ring-champagne/30' }}">{{ $judulBukuTamuDikustom ? 'Dikustom' : 'Bawaan' }}</span>
                        <svg :class="buka ? 'rotate-180 text-sage' : 'text-charcoal/45'" class="h-3.5 w-3.5 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                    </span>
                </button>
                <div x-show="buka" x-cloak class="px-3.5 pb-3.5 pt-2.5 border-t border-champagne/20 bg-white/80">
                    <label for="teks_judul_buku_tamu" class="block text-xs font-semibold text-charcoal/80">Judul Buku Tamu</label>
                    <input
                        id="teks_judul_buku_tamu"
                        type="text"
                        name="teks[judul_buku_tamu]"
                        value="{{ $nilaiTeksEditor('judul_buku_tamu') }}"
                        placeholder="{{ $teksBawaanTema['judul_buku_tamu'] ?: 'RSVP & Wishes / Buku Tamu' }}"
                        class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none"
                    >
                </div>
            </div>

            {{-- 7B. Doa Untuk Pengantin (Seksi 11A Undangan) --}}
            <div class="rounded-2xl border border-champagne/30 bg-ivory/50 overflow-hidden">
                <div class="px-3.5 py-2.5 flex items-center justify-between gap-3">
                    <div class="min-w-0">
                        <span class="block text-xs font-bold text-charcoal">Doa Untuk Pengantin</span>
                        <span class="block text-[11px] text-charcoal/55 mt-0.5">Tampil tepat setelah Buku Tamu &amp; RSVP.</span>
                    </div>
                    <button
                        type="button"
                        role="switch"
                        data-toggle-fitur="doa_pengantin"
                        :aria-checked="sakelarFitur.doa_pengantin ? 'true' : 'false'"
                        :disabled="fiturMenyimpan.doa_pengantin"
                        @click.stop="toggleFitur('doa_pengantin')"
                        :class="sakelarFitur.doa_pengantin ? 'bg-sage' : 'bg-charcoal/25'"
                        class="relative inline-flex h-6 w-11 shrink-0 items-center rounded-full p-0.5 transition-colors cursor-pointer disabled:opacity-60"
                        aria-label="Tampilkan Doa Untuk Pengantin"
                    >
                        <span
                            :class="sakelarFitur.doa_pengantin ? 'translate-x-5' : 'translate-x-0'"
                            class="pointer-events-none block h-5 w-5 rounded-full bg-white shadow-xs transition-transform"
                        ></span>
                    </button>
                </div>

                <div x-show="sakelarFitur.doa_pengantin" x-data="{ buka: false }" class="border-t border-champagne/20">
                    <button type="button" @click="buka = !buka" class="w-full px-3.5 py-2 flex items-center justify-between gap-2 text-left bg-white/50 hover:bg-ivory transition cursor-pointer">
                        <span class="text-xs font-semibold text-charcoal/85 truncate">Edit Isi Doa Untuk Pengantin</span>
                        <span class="flex items-center gap-1.5 shrink-0">
                            <span class="rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $doaDikustom ? 'bg-sage/12 text-sage' : 'bg-white text-charcoal/50 ring-1 ring-champagne/30' }}">{{ $doaDikustom ? 'Dikustom' : 'Bawaan' }}</span>
                            <svg :class="buka ? 'rotate-180 text-sage' : 'text-charcoal/45'" class="h-3.5 w-3.5 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                        </span>
                    </button>
                    <div x-show="buka" x-cloak class="px-3.5 pb-3.5 pt-2.5 border-t border-champagne/20 bg-white/85 space-y-2.5">
                        <div>
                            <label class="block text-xs font-semibold text-charcoal/80">Judul Doa</label>
                            <input type="text" name="teks[doa_judul]" value="{{ old('teks.doa_judul', $doaPengantinAwal['judul']) }}" placeholder="Doa Untuk Pengantin" class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-charcoal/80">Teks Arab / Kutipan Asli <span class="font-normal text-charcoal/45">(Kosongkan bila tidak perlu)</span></label>
                            <input type="text" name="teks[doa_arab]" dir="auto" value="{{ old('teks.doa_arab', $doaPengantinAwal['arab']) }}" placeholder="Kosongkan jika tidak memakai teks Arab" class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-charcoal/80">Teks Latin <span class="font-normal text-charcoal/45">(Opsional)</span></label>
                            <input type="text" name="teks[doa_latin]" value="{{ old('teks.doa_latin', $doaPengantinAwal['latin']) }}" placeholder="Kosongkan jika tidak diperlukan" class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-charcoal/80">Isi / Terjemahan Doa</label>
                            <textarea name="teks[doa_isi]" rows="3" placeholder="Semoga Tuhan memberkahi pernikahan kedua mempelai..." class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm leading-relaxed focus:border-sage focus:outline-none">{{ old('teks.doa_isi', $doaPengantinAwal['isi']) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 7C. Turut Mengundang (Seksi 11B Undangan) --}}
            <div x-data="{ buka: false }" class="rounded-2xl border border-champagne/30 bg-ivory/50 overflow-hidden">
                <button type="button" @click="buka = !buka" class="w-full px-3.5 py-2.5 flex items-center justify-between gap-2 text-left hover:bg-ivory transition cursor-pointer">
                    <span class="text-xs font-semibold text-charcoal truncate">Daftar Turut Mengundang</span>
                    <span class="flex items-center gap-1.5 shrink-0">
                        <span class="rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $turutDikustom ? 'bg-sage/12 text-sage' : 'bg-white text-charcoal/50 ring-1 ring-champagne/30' }}">{{ $turutDikustom ? 'Terisi' : 'Opsional' }}</span>
                        <svg :class="buka ? 'rotate-180 text-sage' : 'text-charcoal/45'" class="h-3.5 w-3.5 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                    </span>
                </button>
                <div x-show="buka" x-cloak class="px-3.5 pb-3.5 pt-2.5 border-t border-champagne/20 bg-white/80 space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-charcoal/80">Judul Turut Mengundang</label>
                        <input type="text" name="teks[judul_turut_mengundang]" value="{{ $nilaiTeksEditor('judul_turut_mengundang') }}" placeholder="{{ $teksBawaanTema['judul_turut_mengundang'] ?: 'Turut Mengundang' }}" class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-charcoal/80">Pihak Wanita <span class="font-normal text-charcoal/45">(1 baris / nama)</span></label>
                            <textarea name="turut_mengundang_wanita" rows="3" placeholder="Keluarga Besar Bpk. ..." class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm leading-relaxed focus:border-sage focus:outline-none">{{ old('turut_mengundang_wanita', data_get($pengaturan, 'turut_mengundang.pihak_wanita', '')) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-charcoal/80">Pihak Pria <span class="font-normal text-charcoal/45">(1 baris / nama)</span></label>
                            <textarea name="turut_mengundang_pria" rows="3" placeholder="Keluarga Besar Bpk. ..." class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm leading-relaxed focus:border-sage focus:outline-none">{{ old('turut_mengundang_pria', data_get($pengaturan, 'turut_mengundang.pihak_pria', '')) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 7D. Kartu Penutup, Foto Penutup & Hashtag (Seksi 12 Undangan) --}}
            <div x-data="{ buka: false }" class="rounded-2xl border border-champagne/30 bg-ivory/50 overflow-hidden">
                <button type="button" @click="buka = !buka" class="w-full px-3.5 py-2.5 flex items-center justify-between gap-2 text-left hover:bg-ivory transition cursor-pointer">
                    <span class="text-xs font-semibold text-charcoal truncate">Foto, Teks Penutup &amp; Hashtag</span>
                    <span class="flex items-center gap-1.5 shrink-0">
                        <span class="rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $penutupDikustom ? 'bg-sage/12 text-sage' : 'bg-white text-charcoal/50 ring-1 ring-champagne/30' }}">{{ $penutupDikustom ? 'Dikustom' : 'Bawaan' }}</span>
                        <svg :class="buka ? 'rotate-180 text-sage' : 'text-charcoal/45'" class="h-3.5 w-3.5 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                    </span>
                </button>
                <div x-show="buka" x-cloak class="px-3.5 pb-4 pt-3 border-t border-champagne/20 bg-white/80 space-y-3">
                    @include('dashboard._input-foto-pratinjau', [
                        'name' => 'foto_penutup',
                        'varian' => 'sampul',
                        'label' => 'Foto Penutup Undangan (Opsional)',
                        'petunjuk' => 'Rasio template: '.$rasioFotoTema['foto_penutup']['label'].' • Kosong = pakai Foto Sampul',
                        'urlAwal' => $undangan->urlFotoPenutupKhususDashboard(),
                        'hapusNama' => 'hapus_foto_penutup',
                        'hapusLabel' => 'Hapus foto penutup',
                    ])

                    <div>
                        <label class="block text-xs font-semibold text-charcoal/80">Judul Penutup</label>
                        <input type="text" name="teks[judul_penutup]" value="{{ $nilaiTeksEditor('judul_penutup') }}" placeholder="{{ $teksBawaanTema['judul_penutup'] ?: 'Terima Kasih / Hatur Nuhun / Jazakumullahu Khairan' }}" class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-charcoal/80">Kalimat Ucapan Terima Kasih</label>
                        <textarea name="teks[ucapan_penutup]" rows="3" placeholder="{{ $teksBawaanTema['ucapan_penutup'] ?: 'Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir...' }}" class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm leading-relaxed focus:border-sage focus:outline-none">{{ $nilaiTeksEditor('ucapan_penutup') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-charcoal/80">Label Penutup</label>
                        <input type="text" name="teks[label_penutup]" value="{{ $nilaiTeksEditor('label_penutup') }}" placeholder="{{ $teksBawaanTema['label_penutup'] ?: 'Kami Yang Berbahagia' }}" class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none">
                    </div>
                    <div>
                        <label for="hashtag" class="block text-xs font-semibold text-charcoal/80">Hashtag Pernikahan <span class="font-normal text-charcoal/45">(Opsional)</span></label>
                        <input
                            id="hashtag"
                            type="text"
                            name="hashtag"
                            value="{{ old('hashtag', $undangan->hashtagPasangan()) }}"
                            placeholder="Contoh: {{ $undangan->hashtagBawaan() }}"
                            class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none"
                        >
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
