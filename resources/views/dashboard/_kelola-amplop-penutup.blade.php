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
                <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-sage/12 text-[11px] font-bold text-sage shrink-0">10</span>
                <span class="font-sans text-sm font-semibold text-charcoal truncate" :class="!sakelarFitur.amplop_digital ? 'opacity-55' : ''">Amplop &amp; Kado</span>
            </span>
            <span
                class="rounded-full bg-ivory px-2 py-0.5 font-sans tabular-nums text-[11px] font-semibold text-sage ring-1 ring-champagne/25 shrink-0"
                x-text="daftarAmplop.length + ' Kartu'"
            >
                {{ $undangan->daftarAmplop->count() }} Kartu
            </span>
        </button>
        <button
            type="button"
            role="switch"
            data-toggle-fitur="amplop_digital"
            :aria-checked="sakelarFitur.amplop_digital ? 'true' : 'false'"
            :disabled="Boolean(fiturMenyimpan.amplop_digital)"
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

        {{-- 6B. Tambah Rekening Bank / E-Wallet --}}
        <div class="rounded-2xl bg-ivory/75 p-4 ring-1 ring-champagne/25">
            <form
                action="{{ route('dashboard.amplop.simpan', $undangan) }}"
                method="POST"
                @submit.prevent="simpanAmplop($event)"
                class="space-y-3"
            >
                @csrf
                <input type="hidden" name="nama_bank" :value="bankBaru">

                <div class="space-y-3">
                    <div>
                        <label for="pilih_bank_amplop" class="block text-xs font-semibold text-charcoal/80">Pilih Bank / E-Wallet</label>
                        <select
                            id="pilih_bank_amplop"
                            x-ref="bankSelect"
                            x-model="bankPilihan"
                            @change="saatPilihBank($event)"
                            data-select2-bank="true"
                            data-select2-variant="white"
                            data-select2-search="true"
                            class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-sage focus:outline-none"
                        >
                            <option value="">-- Pilih Bank / E-Wallet --</option>
                            @foreach (\App\Support\GayaKartuBank::opsiDropdown() as $opsiBank)
                                <option value="{{ $opsiBank['label_cepat'] }}" data-bank-logo="{{ $opsiBank['logo_url'] }}">
                                    {{ $opsiBank['label_cepat'] }}
                                </option>
                            @endforeach
                            <option value="__lainnya__">Bank / E-Wallet Lainnya...</option>
                        </select>
                    </div>

                    <div x-show="bankPilihan === '__lainnya__'" x-cloak>
                        <label for="bank_kustom_amplop" class="block text-xs font-semibold text-charcoal/80">Nama Bank / E-Wallet Lainnya</label>
                        <input
                            id="bank_kustom_amplop"
                            type="text"
                            x-model="bankKustom"
                            @input="bankBaru = bankKustom.trim()"
                            :required="bankPilihan === '__lainnya__'"
                            placeholder="Ketik nama bank / e-wallet..."
                            class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-sage focus:outline-none"
                        >
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-charcoal/80">Nomor Rekening / HP</label>
                        <input
                            type="text"
                            name="nomor_rekening"
                            x-model="formAmplop.nomor_rekening"
                            required
                            placeholder="1234567890"
                            class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-sage focus:outline-none"
                        >
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-charcoal/80">Atas Nama</label>
                        <input
                            type="text"
                            name="atas_nama"
                            x-model="formAmplop.atas_nama"
                            required
                            placeholder="{{ $undangan->nama_lengkap_pria }}"
                            class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-sage focus:outline-none"
                        >
                    </div>
                </div>

                <button
                    type="submit"
                    :disabled="sedangSimpanAmplop"
                    class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-sage px-5 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer shadow-xs disabled:opacity-60 disabled:cursor-wait"
                >
                    <svg x-show="sedangSimpanAmplop" x-cloak class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                        <circle cx="12" cy="12" r="9" class="opacity-25"/>
                        <path d="M21 12a9 9 0 0 0-9-9" stroke-linecap="round"/>
                    </svg>
                    <span x-show="!sedangSimpanAmplop">+ Tambah Rekening</span>
                    <span x-show="sedangSimpanAmplop" x-cloak>Menambahkan Kartu Rekening...</span>
                </button>
            </form>
        </div>

        {{-- Daftar Kartu Tersimpan (Ukuran Ringkas & Reaktif Tanpa Refresh) --}}
        <div x-show="daftarAmplop.length > 0" x-cloak class="space-y-2.5">
            <h3 class="font-sans text-xs font-bold uppercase tracking-wider text-charcoal/65">Koleksi Kartu Rekening Tersimpan</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <template x-for="amplop in daftarAmplop" :key="amplop.id">
                    <div
                        x-data="{ tersalin: false }"
                        :aria-label="amplop.subjudul"
                        :style="'--warna-bank: ' + amplop.warna_utama + ';'"
                        class="group relative aspect-[1.68/1] w-full rounded-2xl p-3.5 sm:p-4 text-[#1F2937] bg-gradient-to-br from-[#FAFAFB] via-[#FFFFFF] to-[#F1F3F5] shadow-[0_10px_24px_-10px_rgba(15,23,42,0.16),0_2px_5px_-1px_rgba(15,23,42,0.06)] hover:shadow-[0_14px_28px_-10px_rgba(15,23,42,0.2)] ring-1 ring-black/[0.08] overflow-hidden flex flex-col justify-between transition-all duration-300"
                    >
                        <div
                            aria-hidden="true"
                            class="pointer-events-none absolute inset-0 opacity-75"
                            style="background-image: radial-gradient(rgba(148, 163, 184, 0.24) 1px, transparent 1px); background-size: 7px 7px; -webkit-mask-image: radial-gradient(ellipse 70% 75% at 36% 42%, #000 0%, transparent 78%); mask-image: radial-gradient(ellipse 70% 75% at 36% 42%, #000 0%, transparent 78%);"
                        ></div>
                        <svg aria-hidden="true" viewBox="0 0 400 248" preserveAspectRatio="none" class="pointer-events-none absolute inset-0 h-full w-full">
                            <path d="M-10 56 C82 94, 96 184, 178 258 L-10 258 Z" fill="#E5E7EB" fill-opacity="0.46"/>
                            <path d="M-10 86 C64 128, 72 204, 134 258 L-10 258 Z" fill="#FFFFFF" fill-opacity="0.72"/>
                            <path d="M118 258 C178 166, 294 150, 412 224 L412 258 Z" fill="#E2E8F0" fill-opacity="0.52"/>
                            <path d="M148 258 C202 184, 304 176, 412 240 L412 258 Z" fill="#FFFFFF" fill-opacity="0.65"/>
                            <path d="M326 -10 C346 58, 378 96, 412 116 L412 -10 Z" fill="#F1F5F9" fill-opacity="0.7"/>
                        </svg>

                        {{-- Baris Atas: Hapus (Kiri) + Logo Resmi (Kanan) --}}
                        <div class="relative z-10 flex items-start justify-between gap-2 min-h-[24px]">
                            <button
                                type="button"
                                @click="hapusAmplop(amplop)"
                                :disabled="amplopHapusId === amplop.id"
                                title="Hapus Rekening"
                                class="rounded-lg bg-rose-50 hover:bg-rose-600 border border-rose-200/90 px-2 py-0.5 text-[10px] font-semibold text-rose-600 hover:text-white transition cursor-pointer disabled:opacity-60 disabled:cursor-wait"
                            >
                                <span x-show="amplopHapusId !== amplop.id">Hapus</span>
                                <span x-show="amplopHapusId === amplop.id" x-cloak>Menghapus Rekening...</span>
                            </button>

                            <div class="flex items-center justify-end" :title="amplop.subjudul">
                                <img
                                    x-show="amplop.logo_url"
                                    :src="amplop.logo_url"
                                    :alt="amplop.nama_bank"
                                    loading="lazy"
                                    decoding="async"
                                    class="h-5 sm:h-6 max-w-[100px] w-auto object-contain object-right"
                                >
                                <span
                                    x-show="!amplop.logo_url"
                                    x-text="amplop.nama_bank"
                                    class="font-sans text-xs sm:text-sm font-extrabold tracking-tight text-[#1F2937] uppercase truncate max-w-[125px]"
                                ></span>
                            </div>
                        </div>

                        {{-- Baris Tengah: Chip EMV Emas --}}
                        <div class="relative z-10 flex items-center">
                            <div
                                class="w-9 h-[26px] rounded-[5px] border border-[#B78B36]/65 shadow-[inset_0_1px_1px_rgba(255,255,255,0.7),0_1px_2px_rgba(15,23,42,0.12)] overflow-hidden"
                                style="background: linear-gradient(135deg, #F6E2A8 0%, #E0B55A 48%, #C49336 100%);"
                                aria-hidden="true"
                            >
                                <svg viewBox="0 0 44 32" fill="none" class="h-full w-full">
                                    <rect x="14" y="7" width="16" height="18" rx="3" stroke="#8C641D" stroke-opacity="0.55" stroke-width="1"/>
                                    <line x1="0" y1="11" x2="14" y2="11" stroke="#8C641D" stroke-opacity="0.55" stroke-width="1"/>
                                    <line x1="0" y1="21" x2="14" y2="21" stroke="#8C641D" stroke-opacity="0.55" stroke-width="1"/>
                                    <line x1="30" y1="11" x2="44" y2="11" stroke="#8C641D" stroke-opacity="0.55" stroke-width="1"/>
                                    <line x1="30" y1="21" x2="44" y2="21" stroke="#8C641D" stroke-opacity="0.55" stroke-width="1"/>
                                    <line x1="22" y1="0" x2="22" y2="7" stroke="#8C641D" stroke-opacity="0.55" stroke-width="1"/>
                                    <line x1="22" y1="25" x2="22" y2="32" stroke="#8C641D" stroke-opacity="0.55" stroke-width="1"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Baris Bawah: Nomor Rekening & Atas Nama + Tombol Copy --}}
                        <div class="relative z-10 flex items-end justify-between gap-2">
                            <div class="min-w-0 flex-1">
                                <p
                                    class="font-mono text-[13px] sm:text-sm font-semibold tracking-[0.09em] text-[#1F2937] tabular-nums truncate leading-tight"
                                    :data-nomor-asli="amplop.nomor_rekening"
                                    x-text="amplop.nomor_tampil"
                                ></p>
                                <p class="mt-0.5 text-[11px] font-medium text-[#4B5563] truncate" x-text="amplop.atas_nama"></p>
                            </div>

                            <button
                                type="button"
                                @click="navigator.clipboard?.writeText(amplop.nomor_rekening); tersalin = true; setTimeout(() => tersalin = false, 2000)"
                                class="shrink-0 inline-flex items-center gap-1 rounded-md bg-[#2B2B2B] hover:bg-[#171717] px-2.5 py-1 text-[11px] font-semibold text-white shadow-xs transition cursor-pointer"
                            >
                                <svg class="h-3 w-3 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <rect width="14" height="14" x="8" y="8" rx="2" ry="2"/>
                                    <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>
                                </svg>
                                <span x-show="!tersalin">Copy</span>
                                <span x-show="tersalin" x-cloak class="text-emerald-300">Tersalin!</span>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

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

{{-- ACCORDION 11: Buku Tamu & RSVP (Seksi 10 Undangan) --}}
<div
    :class="tab === 'buku_tamu' ? 'border-sage/45 ring-1 ring-sage/15 shadow-xs' : 'border-champagne/30 hover:border-champagne/60'"
    class="rounded-2xl border bg-white overflow-hidden transition"
>
    <button
        type="button"
        data-mobile-tab="buku_tamu"
        @click="toggleBagian('buku_tamu')"
        class="w-full px-4 py-3.5 flex items-center justify-between gap-2 text-left hover:bg-ivory/50 transition cursor-pointer"
    >
        <span class="flex items-center gap-2.5 min-w-0">
            <svg
                :class="tab === 'buku_tamu' ? 'rotate-90 text-sage' : 'text-charcoal/45'"
                class="h-4 w-4 shrink-0 transition-transform duration-200"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
            >
                <path d="m9 18 6-6-6-6"/>
            </svg>
            <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-sage/12 text-[11px] font-bold text-sage shrink-0">11</span>
            <span class="font-sans text-sm font-semibold text-charcoal truncate">Buku Tamu &amp; RSVP</span>
        </span>
        <span class="rounded-full bg-ivory px-2 py-0.5 font-sans tabular-nums text-[11px] font-semibold text-sage ring-1 ring-champagne/25 shrink-0">
            {{ $undangan->bukuTamu->count() }} Ucapan
        </span>
    </button>

    <section x-show="tab === 'buku_tamu'" x-cloak class="px-4 pb-5 pt-3 border-t border-champagne/20 space-y-3.5">

        <div class="rounded-2xl bg-ivory/75 p-3.5 ring-1 ring-champagne/25 flex items-center justify-between gap-3">
            <div class="min-w-0">
                <p class="text-xs font-bold text-charcoal">Ucapan &amp; Kehadiran (RSVP)</p>
                <p class="text-[11px] text-charcoal/60">Lihat daftar tamu yang hadir dan kelola ucapan.</p>
            </div>
            @if ($undangan->sudahAktifPublik())
                <a
                    href="{{ route('dashboard.undangan.rsvp', $undangan) }}"
                    class="inline-flex items-center gap-1 rounded-xl bg-white px-3 py-2 text-xs font-semibold text-sage ring-1 ring-champagne/35 hover:bg-sage hover:text-white transition shrink-0"
                >
                    <span>Lihat RSVP</span>
                    <span aria-hidden="true">&rarr;</span>
                </a>
            @else
                <button
                    type="button"
                    @click="bukaModalAktivasi()"
                    class="inline-flex items-center gap-1.5 rounded-xl bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-800 ring-1 ring-amber-200 hover:bg-amber-100 transition shrink-0 cursor-pointer"
                >
                    <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    <span>Terkunci</span>
                </button>
            @endif
        </div>

        <div data-bagian-utama="buku_tamu" class="rounded-2xl bg-ivory/65 p-3.5 ring-1 ring-champagne/25">
            <label for="teks_judul_buku_tamu" class="block text-xs font-semibold text-charcoal/80">Judul Buku Tamu / RSVP</label>
            <input
                id="teks_judul_buku_tamu"
                type="text"
                name="teks[judul_buku_tamu]"
                value="{{ $nilaiTeksEditor('judul_buku_tamu') }}"
                placeholder="{{ $teksBawaanTema['judul_buku_tamu'] ?: 'RSVP & Wishes / Buku Tamu' }}"
                class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none"
            >
        </div>
    </section>
</div>

{{-- ACCORDION 12: Doa Untuk Pengantin (Seksi 11A Undangan) --}}
<div
    :class="tab === 'doa_pengantin' ? 'border-sage/45 ring-1 ring-sage/15 shadow-xs' : 'border-champagne/30 hover:border-champagne/60'"
    class="rounded-2xl border bg-white overflow-hidden transition"
>
    <div class="px-4 py-3.5 flex items-center justify-between gap-2 hover:bg-ivory/50 transition">
        <button
            type="button"
            data-mobile-tab="doa_pengantin"
            @click="toggleBagian('doa_pengantin')"
            class="flex-1 flex items-center justify-between gap-2 min-w-0 text-left cursor-pointer"
        >
            <span class="flex items-center gap-2.5 min-w-0">
                <svg
                    :class="tab === 'doa_pengantin' ? 'rotate-90 text-sage' : 'text-charcoal/45'"
                    class="h-4 w-4 shrink-0 transition-transform duration-200"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                >
                    <path d="m9 18 6-6-6-6"/>
                </svg>
                <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-sage/12 text-[11px] font-bold text-sage shrink-0">12</span>
                <span class="font-sans text-sm font-semibold text-charcoal truncate" :class="!sakelarFitur.doa_pengantin ? 'opacity-55' : ''">Doa Untuk Pengantin</span>
            </span>
            <span class="rounded-full px-2 py-0.5 text-[11px] font-semibold shrink-0 {{ $doaDikustom ? 'bg-sage/12 text-sage' : 'bg-ivory text-charcoal/55 ring-1 ring-champagne/25' }}">
                {{ $doaDikustom ? 'Dikustom' : 'Bawaan' }}
            </span>
        </button>
        <button
            type="button"
            role="switch"
            data-toggle-fitur="doa_pengantin"
            :aria-checked="sakelarFitur.doa_pengantin ? 'true' : 'false'"
            :disabled="Boolean(fiturMenyimpan.doa_pengantin)"
            @click.stop="toggleFitur('doa_pengantin')"
            :class="sakelarFitur.doa_pengantin ? 'bg-sage' : 'bg-charcoal/25'"
            class="relative inline-flex h-5 w-9 shrink-0 items-center rounded-full p-0.5 transition-colors cursor-pointer disabled:opacity-60"
            title="Tampilkan atau sembunyikan Doa Untuk Pengantin"
            aria-label="Tampilkan Doa Untuk Pengantin"
        >
            <span
                :class="sakelarFitur.doa_pengantin ? 'translate-x-4' : 'translate-x-0'"
                class="pointer-events-none block h-4 w-4 rounded-full bg-white shadow-xs transition-transform"
            ></span>
        </button>
    </div>

    <section x-show="tab === 'doa_pengantin'" x-cloak class="px-4 pb-5 pt-3 border-t border-champagne/20 space-y-3.5">
        <div x-show="!sakelarFitur.doa_pengantin" x-cloak class="rounded-xl border border-amber-200 bg-amber-50/80 px-3 py-2 text-xs text-amber-800">
            Bagian <strong>Doa Untuk Pengantin</strong> sedang disembunyikan. Nyalakan sakelar di kanan atas untuk menampilkannya.
        </div>

        <div data-bagian-utama="doa_pengantin" class="rounded-2xl bg-ivory/65 p-4 ring-1 ring-champagne/25 space-y-3">
            <div>
                <label for="teks_doa_judul" class="block text-xs font-semibold text-charcoal/80">Judul Doa</label>
                <input id="teks_doa_judul" type="text" name="teks[doa_judul]" value="{{ old('teks.doa_judul', $doaPengantinAwal['judul']) }}" placeholder="Doa Untuk Pengantin" class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none">
            </div>
            <div>
                <label for="teks_doa_arab" class="block text-xs font-semibold text-charcoal/80">Teks Arab / Kutipan Asli <span class="font-normal text-charcoal/45">(Kosongkan bila tidak perlu)</span></label>
                <input id="teks_doa_arab" type="text" name="teks[doa_arab]" dir="auto" value="{{ old('teks.doa_arab', $doaPengantinAwal['arab']) }}" placeholder="Kosongkan jika tidak memakai teks Arab" class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none">
            </div>
            <div>
                <label for="teks_doa_latin" class="block text-xs font-semibold text-charcoal/80">Teks Latin <span class="font-normal text-charcoal/45">(Opsional)</span></label>
                <input id="teks_doa_latin" type="text" name="teks[doa_latin]" value="{{ old('teks.doa_latin', $doaPengantinAwal['latin']) }}" placeholder="Kosongkan jika tidak diperlukan" class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none">
            </div>
            <div>
                <label for="teks_doa_isi" class="block text-xs font-semibold text-charcoal/80">Isi / Terjemahan Doa</label>
                <textarea id="teks_doa_isi" name="teks[doa_isi]" rows="3" placeholder="Semoga Tuhan memberkahi pernikahan kedua mempelai..." class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm leading-relaxed focus:border-sage focus:outline-none">{{ old('teks.doa_isi', $doaPengantinAwal['isi']) }}</textarea>
            </div>
        </div>
    </section>
</div>

{{-- ACCORDION 13: Daftar Turut Mengundang (Seksi 11B Undangan) --}}
<div
    :class="tab === 'turut_mengundang' ? 'border-sage/45 ring-1 ring-sage/15 shadow-xs' : 'border-champagne/30 hover:border-champagne/60'"
    class="rounded-2xl border bg-white overflow-hidden transition"
>
    <div class="px-4 py-3.5 flex items-center justify-between gap-2 hover:bg-ivory/50 transition">
        <button
            type="button"
            data-mobile-tab="turut_mengundang"
            @click="toggleBagian('turut_mengundang')"
            class="flex-1 flex items-center justify-between gap-2 min-w-0 text-left cursor-pointer"
        >
            <span class="flex items-center gap-2.5 min-w-0">
                <svg
                    :class="tab === 'turut_mengundang' ? 'rotate-90 text-sage' : 'text-charcoal/45'"
                    class="h-4 w-4 shrink-0 transition-transform duration-200"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                >
                    <path d="m9 18 6-6-6-6"/>
                </svg>
                <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-sage/12 text-[11px] font-bold text-sage shrink-0">13</span>
                <span class="font-sans text-sm font-semibold text-charcoal truncate" :class="!sakelarFitur.turut_mengundang ? 'opacity-55' : ''">Daftar Turut Mengundang</span>
            </span>
            <span class="rounded-full px-2 py-0.5 text-[11px] font-semibold shrink-0 {{ $turutDikustom ? 'bg-sage/12 text-sage' : 'bg-ivory text-charcoal/55 ring-1 ring-champagne/25' }}">
                {{ $turutDikustom ? 'Terisi' : 'Opsional' }}
            </span>
        </button>
        <button
            type="button"
            role="switch"
            data-toggle-fitur="turut_mengundang"
            :aria-checked="sakelarFitur.turut_mengundang ? 'true' : 'false'"
            :disabled="Boolean(fiturMenyimpan.turut_mengundang)"
            @click.stop="toggleFitur('turut_mengundang')"
            :class="sakelarFitur.turut_mengundang ? 'bg-sage' : 'bg-charcoal/25'"
            class="relative inline-flex h-5 w-9 shrink-0 items-center rounded-full p-0.5 transition-colors cursor-pointer disabled:opacity-60"
            title="Tampilkan atau sembunyikan Daftar Turut Mengundang"
            aria-label="Tampilkan Daftar Turut Mengundang"
        >
            <span
                :class="sakelarFitur.turut_mengundang ? 'translate-x-4' : 'translate-x-0'"
                class="pointer-events-none block h-4 w-4 rounded-full bg-white shadow-xs transition-transform"
            ></span>
        </button>
    </div>

    <section x-show="tab === 'turut_mengundang'" x-cloak class="px-4 pb-5 pt-3 border-t border-champagne/20 space-y-3.5">
        <div x-show="!sakelarFitur.turut_mengundang" x-cloak class="rounded-xl border border-amber-200 bg-amber-50/80 px-3 py-2 text-xs text-amber-800">
            Bagian <strong>Daftar Turut Mengundang</strong> sedang disembunyikan. Nyalakan sakelar di kanan atas untuk menampilkannya.
        </div>

        <div data-bagian-utama="turut_mengundang" class="rounded-2xl bg-ivory/65 p-4 ring-1 ring-champagne/25 space-y-3">
            <div>
                <label for="teks_judul_turut_mengundang" class="block text-xs font-semibold text-charcoal/80">Judul Turut Mengundang</label>
                <input id="teks_judul_turut_mengundang" type="text" name="teks[judul_turut_mengundang]" value="{{ $nilaiTeksEditor('judul_turut_mengundang') }}" placeholder="{{ $teksBawaanTema['judul_turut_mengundang'] ?: 'Turut Mengundang' }}" class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none">
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
    </section>
</div>

{{-- ACCORDION 14: Foto, Teks Penutup & Hashtag (Seksi 12 Undangan) --}}
<div
    :class="tab === 'penutup' ? 'border-sage/45 ring-1 ring-sage/15 shadow-xs' : 'border-champagne/30 hover:border-champagne/60'"
    class="rounded-2xl border bg-white overflow-hidden transition"
>
    <button
        type="button"
        data-mobile-tab="penutup"
        @click="toggleBagian('penutup')"
        class="w-full px-4 py-3.5 flex items-center justify-between gap-2 text-left hover:bg-ivory/50 transition cursor-pointer"
    >
        <span class="flex items-center gap-2.5 min-w-0">
            <svg
                :class="tab === 'penutup' ? 'rotate-90 text-sage' : 'text-charcoal/45'"
                class="h-4 w-4 shrink-0 transition-transform duration-200"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
            >
                <path d="m9 18 6-6-6-6"/>
            </svg>
            <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-sage/12 text-[11px] font-bold text-sage shrink-0">14</span>
            <span class="font-sans text-sm font-semibold text-charcoal truncate">Penutup &amp; Hashtag</span>
        </span>
        <span class="rounded-full px-2 py-0.5 text-[11px] font-semibold shrink-0 {{ $penutupDikustom ? 'bg-sage/12 text-sage' : 'bg-ivory text-charcoal/55 ring-1 ring-champagne/25' }}">
            {{ $penutupDikustom ? 'Dikustom' : 'Bawaan' }}
        </span>
    </button>

    <section x-show="tab === 'penutup'" x-cloak class="px-4 pb-5 pt-3 border-t border-champagne/20 space-y-3.5">
        <div data-bagian-utama="penutup" class="rounded-2xl bg-ivory/65 p-4 ring-1 ring-champagne/25 space-y-3">
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
                <label for="teks_judul_penutup" class="block text-xs font-semibold text-charcoal/80">Judul Penutup</label>
                <input id="teks_judul_penutup" type="text" name="teks[judul_penutup]" value="{{ $nilaiTeksEditor('judul_penutup') }}" placeholder="{{ $teksBawaanTema['judul_penutup'] ?: 'Terima Kasih / Hatur Nuhun / Jazakumullahu Khairan' }}" class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none">
            </div>
            <div>
                <label for="teks_ucapan_penutup" class="block text-xs font-semibold text-charcoal/80">Kalimat Ucapan Terima Kasih</label>
                <textarea id="teks_ucapan_penutup" name="teks[ucapan_penutup]" rows="3" placeholder="{{ $teksBawaanTema['ucapan_penutup'] ?: 'Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir...' }}" class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm leading-relaxed focus:border-sage focus:outline-none">{{ $nilaiTeksEditor('ucapan_penutup') }}</textarea>
            </div>
            <div>
                <label for="teks_label_penutup" class="block text-xs font-semibold text-charcoal/80">Label Penutup</label>
                <input id="teks_label_penutup" type="text" name="teks[label_penutup]" value="{{ $nilaiTeksEditor('label_penutup') }}" placeholder="{{ $teksBawaanTema['label_penutup'] ?: 'Kami Yang Berbahagia' }}" class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3 py-2 text-sm focus:border-sage focus:outline-none">
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
    </section>
</div>
