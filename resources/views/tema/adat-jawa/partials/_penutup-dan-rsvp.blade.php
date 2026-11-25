{{-- SEKSI 10: AMPLOP DIGITAL KERATON (BUKA-TUTUP KARTU BANK GLOSSY) --}}
@if ($undangan->fiturAktif('amplop_digital') && ($undangan->daftarAmplop->isNotEmpty() || $alamatKado !== ''))
    <section x-data="{ amplopTerbuka: false }" class="relative py-12 px-5">
        <div
            class="rounded-[22px] border-[3px] border-[#D7BB83] bg-[#FFFAF5]/93 px-6 py-9 text-center text-[#2B180F] shadow-2xl space-y-4 kartu-3d">
            <div class="space-y-1">
                <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.32em] text-[#8C6823]">Tanda Kasih</p>
                <h2 data-gsap="naik" class="font-kaligrafi text-[1.95rem] sm:text-[2.15rem] tracking-[0.01em] text-[#472A1C] leading-tight">{{ $undangan->teksKustom('judul_amplop', 'Amplop Digital') }}</h2>
            </div>
            <p data-gsap="teks" data-gsap-delay="0.06"
                class="text-xs sm:text-sm text-[#472A1C]/85 leading-relaxed max-w-xs mx-auto">
                {{ $undangan->teksKustom('pengantar_amplop', 'Tanpa mengurangi rasa hormat, bagi Bapak/Ibu/Saudara/i yang ingin memberikan tanda kasih untuk kami, dapat melalui:') }}
            </p>

            <div data-gsap="mekar" data-gsap-delay="0.09">
                <button type="button" @click="amplopTerbuka = !amplopTerbuka; window.SesiTemuSinema?.refresh(360)"
                    :aria-expanded="amplopTerbuka.toString()"
                    class="jawa-tombol-emas inline-flex items-center justify-center gap-2 rounded-full px-6 py-2.5 text-xs font-bold uppercase tracking-[0.14em] transition active:scale-95 cursor-pointer">
                    <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect width="20" height="16" x="2" y="4" rx="2" />
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                    </svg>
                    <span x-text="amplopTerbuka ? 'Tutup Amplop Digital' : 'Buka Amplop Digital'">Buka Amplop
                        Digital</span>
                    <svg class="h-3.5 w-3.5 shrink-0 transition-transform duration-300"
                        :class="amplopTerbuka ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
                        aria-hidden="true">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </button>
            </div>

            <div x-show="amplopTerbuka" x-cloak x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-2 scale-[0.98]"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 -translate-y-2 scale-[0.98]"
                class="pt-4 space-y-4 text-left panggung-3d">
                @foreach ($undangan->daftarAmplop as $amplop)
                    @php
                        $gayaBank = \App\Support\GayaKartuBank::untukNamaBank($amplop->nama_bank);
                        $nomorTerformat = \App\Support\GayaKartuBank::formatNomor($amplop->nomor_rekening);
                    @endphp
                    <div x-data="{ tersalin: false }"
                        class="relative rounded-2xl p-5 text-white overflow-hidden shadow-xl kartu-3d"
                        style="background: {{ $gayaBank['gradient_css'] }};">
                        <div aria-hidden="true"
                            class="pointer-events-none absolute -top-12 -right-12 h-36 w-36 rounded-full bg-white/10 blur-xl">
                        </div>
                        <div aria-hidden="true"
                            class="pointer-events-none absolute -bottom-12 -left-10 h-32 w-32 rounded-full opacity-20 blur-xl"
                            style="background-color: {{ $gayaBank['aksen_hex'] }};"></div>

                        <div class="relative z-10 flex items-start justify-between gap-3">
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-white/75">
                                    {{ $gayaBank['label_jenis'] }}</p>
                                <p class="mt-0.5 font-sans text-base font-extrabold tracking-wide text-white">
                                    {{ $gayaBank['singkatan'] }}</p>
                            </div>
                            <div aria-hidden="true"
                                class="h-7 w-10 rounded-md border border-white/30 shadow-inner {{ $gayaBank['chip_gaya'] === 'perak' ? 'bg-gradient-to-br from-slate-100 via-slate-300 to-slate-400' : 'bg-gradient-to-br from-[#F9E7A8] via-[#D4AF37] to-[#9A7422]' }}">
                            </div>
                        </div>

                        <div class="relative z-10 mt-5">
                            <p class="font-mono text-lg sm:text-xl font-bold tracking-[0.14em] text-white">
                                {{ $nomorTerformat }}
                            </p>
                            <p class="mt-1 text-xs text-white/85">a.n. {{ $amplop->atas_nama }}</p>
                        </div>

                        <div
                            class="relative z-10 mt-4 pt-3 border-t border-white/15 flex items-center justify-between gap-2">
                            <span class="text-[10px] font-medium text-white/75 truncate">{{ $amplop->nama_bank }}</span>
                            <button type="button"
                                @click="navigator.clipboard?.writeText(@js($amplop->nomor_rekening)); tersalin = true; setTimeout(() => tersalin = false, 2500)"
                                class="inline-flex items-center gap-1.5 rounded-full bg-white/20 hover:bg-white/30 px-3.5 py-1.5 text-[11px] font-semibold text-white transition cursor-pointer shrink-0">
                                <span x-show="!tersalin">Salin Nomor Rekening</span>
                                <span x-show="tersalin" x-cloak>Berhasil Disalin!</span>
                            </button>
                        </div>
                    </div>
                @endforeach

                @if ($alamatKado !== '')
                    <div x-data="{ alamatTersalin: false }"
                        class="rounded-2xl p-5 text-center border border-[#D7BB83]/50 bg-white/75 space-y-2">
                        <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-[#8C6823]">Alamat Pengiriman
                            Kado</p>
                        <p class="text-xs sm:text-sm text-[#472A1C]/85 leading-relaxed">{{ $alamatKado }}</p>
                        <button type="button"
                            @click="navigator.clipboard?.writeText(@js($alamatKado)); alamatTersalin = true; setTimeout(() => alamatTersalin = false, 2200)"
                            class="jawa-tombol-emas inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-[11px] font-medium transition cursor-pointer">
                            <span x-show="!alamatTersalin">Salin Alamat</span>
                            <span x-show="alamatTersalin" x-cloak>Alamat Tersalin!</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif

{{-- SEKSI 11: RSVP & WISHES (BLOK SOGAN PADAT #472A1C) --}}
@if ($undangan->fiturAktif('buku_tamu'))
    <section id="buku-tamu" class="relative bg-[#472A1C] shadow-[0_0_0_2px_#472A1C] text-[#FFFAF5] py-14 px-5">
        <div class="max-w-md mx-auto">
            <div class="text-center space-y-2">
                <img src="{{ $asetJawa['gununganKecil'] }}" alt="" data-gsap="turun" class="w-14 mx-auto">
                <h2 data-gsap="mekar"
                    class="font-serif text-4xl sm:text-5xl font-bold uppercase tracking-[0.12em] text-white leading-tight">
                    {{ $undangan->teksKustom('judul_buku_tamu', 'RSVP & Wishes') }}
                </h2>
                <p data-gsap="teks" data-gsap-delay="0.06"
                    class="text-xs text-[#FFFAF5]/80 max-w-xs mx-auto leading-relaxed">
                    Kami mempersilakan Bapak/Ibu/Saudara/i untuk menyampaikan ucapan selamat, doa restu, serta
                    konfirmasi kehadiran.
                </p>
                <div data-gsap="garis" aria-hidden="true" class="mx-auto w-24 h-px bg-[#D7BB83]/55 pt-1"></div>
            </div>

            <div data-gsap="naik"
                class="mt-7 relative rounded-[22px] bg-[#FFFAF5]/95 p-5 sm:p-6 text-[#2B180F] shadow-2xl border border-[#D7BB83]/50 overflow-hidden kartu-3d">
                <img src="{{ $urlFotoLatar }}" alt="" aria-hidden="true"
                    class="pointer-events-none absolute inset-0 w-full h-full object-cover opacity-10">

                <div class="relative z-10">
                    @if (session('sukses_ucapan'))
                        <div data-swal-success="{{ session('sukses_ucapan') }}" hidden aria-hidden="true"></div>
                    @endif

                    @if ($errors->any())
                        <div data-swal-errors="{{ json_encode($errors->all(), JSON_UNESCAPED_UNICODE) }}" hidden
                            aria-hidden="true"></div>
                    @endif

                    @if (!empty($modeDemo))
                        <div x-data="bukuTamuDemo(@js($daftarUcapanAwal), @js($namaTamu))" class="space-y-5">
                            <form @submit.prevent="kirimUcapanDemo()" class="space-y-3.5 text-left">
                                <div>
                                    <label
                                        class="block text-xs font-semibold uppercase tracking-wider text-[#472A1C]/80">Nama
                                        Lengkap</label>
                                    <input type="text" x-model="namaTamu" required
                                        class="mt-1 w-full rounded-xl border border-[#472A1C]/20 bg-white px-4 py-2.5 text-sm"
                                        placeholder="Nama Anda">
                                </div>
                                <div class="grid gap-3"
                                    :class="statusKehadiran === 'hadir' ? 'grid-cols-2' : 'grid-cols-1'">
                                    <div>
                                        <label
                                            class="block text-xs font-semibold uppercase tracking-wider text-[#472A1C]/80">Kehadiran</label>
                                        <select x-ref="selectKehadiran" x-model="statusKehadiran"
                                            @change="statusKehadiran = $event.target.value"
                                            class="mt-1 w-full rounded-xl border border-[#472A1C]/20 bg-white px-3.5 py-2.5 text-sm">
                                            <option value="hadir">Hadir</option>
                                            <option value="ragu">Masih Ragu</option>
                                            <option value="tidak_hadir">Tidak Hadir</option>
                                        </select>
                                    </div>
                                    <div x-show="statusKehadiran === 'hadir'" x-cloak>
                                        <label
                                            class="block text-xs font-semibold uppercase tracking-wider text-[#472A1C]/80">Jumlah</label>
                                        <input type="number" x-model.number="jumlahTamu" min="1"
                                            max="20" :required="statusKehadiran === 'hadir'"
                                            :disabled="statusKehadiran !== 'hadir'"
                                            class="mt-1 w-full rounded-xl border border-[#472A1C]/20 bg-white px-3.5 py-2.5 text-sm">
                                    </div>
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold uppercase tracking-wider text-[#472A1C]/80">Ucapan
                                        &amp; Doa</label>
                                    <textarea x-model="ucapanDoa" rows="3" required
                                        class="mt-1 w-full rounded-xl border border-[#472A1C]/20 bg-white px-4 py-2.5 text-sm"
                                        placeholder="Tulis ucapan &amp; doa terbaik..."></textarea>
                                </div>
                                <button type="submit"
                                    class="w-full rounded-xl bg-[#472A1C] px-6 py-3 text-sm font-semibold text-[#F3E5AB] hover:bg-[#382015] transition cursor-pointer">
                                    Kirim Konfirmasi &amp; Doa
                                </button>
                                <p x-show="pesanGalat" x-cloak x-text="pesanGalat"
                                    class="text-xs text-rose-700 font-semibold text-center"></p>
                                <p x-show="pesanSukses" x-cloak x-text="pesanSukses"
                                    class="rounded-xl bg-emerald-50 border border-emerald-200 px-3 py-2 text-[11px] text-emerald-800 font-semibold text-center">
                                </p>
                            </form>

                            {{-- Daftar Ucapan Demo Scrollable --}}
                            <div class="pt-5 border-t border-[#472A1C]/15 space-y-3">
                                <div class="flex items-center justify-between gap-2">
                                    <h3 class="font-serif text-lg font-bold text-[#472A1C]">
                                        Doa &amp; Ucapan (<span
                                            x-text="daftarUcapan.length">{{ count($daftarUcapanAwal) }}</span>)
                                    </h3>
                                    <span class="text-[10px] uppercase tracking-wider text-[#8C6823]">Gulir untuk
                                        lainnya</span>
                                </div>
                                <div x-ref="daftarUcapanScroll" data-lenis-prevent
                                    class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                                    <template x-for="ucapan in daftarUcapan" :key="ucapan.id">
                                        <div class="rounded-2xl p-4 border bg-white/85 space-y-1.5 transition"
                                            :class="ucapan.baru ? 'border-[#472A1C]/60 ring-1 ring-[#D7BB83]/60' :
                                                'border-[#D7BB83]/40'">
                                            <div class="flex items-center justify-between gap-2">
                                                <p class="font-semibold text-sm text-[#2B180F]"
                                                    x-text="ucapan.nama_tamu"></p>
                                                <span
                                                    class="shrink-0 rounded-full px-2.5 py-0.5 text-[10px] font-semibold"
                                                    :class="kelasStatus(ucapan.status_kehadiran, false,
                                                        'bg-[#472A1C]/10 text-[#472A1C]')"
                                                    x-text="labelStatus(ucapan.status_kehadiran)"></span>
                                            </div>
                                            <p class="text-xs sm:text-sm text-[#472A1C]/85 leading-relaxed"
                                                x-text="ucapan.ucapan_doa"></p>
                                            <p class="text-[10px] text-[#8C6823]/80" x-text="ucapan.waktu"></p>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        @else
                            @if (!$undangan->sudahAktifPublik())
                                <div
                                    class="rounded-2xl border border-amber-300/70 bg-amber-50/95 p-5 text-[#2B180F] space-y-3">
                                    <p class="text-sm font-bold">Mode Pratinjau — Buku Tamu &amp; RSVP Dikunci</p>
                                    <p class="text-xs opacity-75 leading-relaxed">
                                        Formulir konfirmasi kehadiran dan pengiriman ucapan doa baru dapat diisi tamu
                                        setelah undangan dibayar dan diaktifkan.
                                    </p>
                                    @if ($undangan->bolehDipratinjauOleh(auth()->user()))
                                        <a href="{{ route('dashboard.undangan.kelola', [$undangan, 'tab' => 'aktivasi']) }}"
                                            class="inline-flex items-center gap-1.5 rounded-xl bg-[#472A1C] px-4 py-2 text-xs font-semibold text-[#F3E5AB] hover:bg-[#382015] transition">
                                            Bayar &amp; Aktifkan Undangan &rarr;
                                        </a>
                                    @endif
                                </div>
                            @else
                                <form x-data="{ statusKehadiran: @js(old('status_kehadiran', 'hadir')) }"
                                    action="{{ route('undangan.ucapan', $undangan->slug) }}" method="POST"
                                    class="space-y-4">
                                    @csrf
                                    <div>
                                        <label
                                            class="block text-xs font-semibold uppercase tracking-wider text-[#472A1C]/80">Nama
                                            Lengkap</label>
                                        <input type="text" name="nama_tamu"
                                            value="{{ old('nama_tamu', $namaTamu !== 'Tamu Undangan' ? $namaTamu : '') }}"
                                            required placeholder="Masukkan nama Anda"
                                            class="mt-1.5 w-full rounded-xl border border-[#472A1C]/20 bg-white px-4 py-2.5 text-sm">
                                    </div>

                                    <div class="grid grid-cols-1 gap-3.5"
                                        :class="statusKehadiran === 'hadir' ? 'sm:grid-cols-2' : 'sm:grid-cols-1'">
                                        <div>
                                            <label
                                                class="block text-xs font-semibold uppercase tracking-wider text-[#472A1C]/80">Konfirmasi
                                                Kehadiran</label>
                                            <select name="status_kehadiran" data-select2-variant="inherit"
                                                x-model="statusKehadiran"
                                                @change="statusKehadiran = $event.target.value"
                                                class="mt-1.5 w-full rounded-xl border border-[#472A1C]/20 bg-white px-3.5 py-2.5 text-sm">
                                                <option value="hadir" @selected(old('status_kehadiran', 'hadir') === 'hadir')>InsyaAllah Hadir
                                                </option>
                                                <option value="ragu" @selected(old('status_kehadiran') === 'ragu')>Masih Ragu</option>
                                                <option value="tidak_hadir" @selected(old('status_kehadiran') === 'tidak_hadir')>Tidak Dapat
                                                    Hadir
                                                </option>
                                            </select>
                                        </div>
                                        <div x-show="statusKehadiran === 'hadir'" x-cloak>
                                            <label
                                                class="block text-xs font-semibold uppercase tracking-wider text-[#472A1C]/80">Jumlah
                                                Tamu</label>
                                            <input type="number" name="jumlah_tamu"
                                                value="{{ old('jumlah_tamu', 1) }}" min="1" max="20"
                                                :required="statusKehadiran === 'hadir'"
                                                :disabled="statusKehadiran !== 'hadir'"
                                                class="mt-1.5 w-full rounded-xl border border-[#472A1C]/20 bg-white px-3.5 py-2.5 text-sm">
                                        </div>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-xs font-semibold uppercase tracking-wider text-[#472A1C]/80">Ucapan
                                            &amp; Doa Restu</label>
                                        <textarea name="ucapan_doa" rows="3" required placeholder="Tuliskan doa terbaik untuk kedua mempelai..."
                                            class="mt-1.5 w-full rounded-xl border border-[#472A1C]/20 bg-white px-4 py-2.5 text-sm">{{ old('ucapan_doa') }}</textarea>
                                    </div>

                                    <button type="submit"
                                        class="w-full rounded-xl bg-[#472A1C] px-6 py-3 text-sm font-semibold text-[#F3E5AB] hover:bg-[#382015] transition cursor-pointer">
                                        Kirim Konfirmasi &amp; Doa
                                    </button>
                                </form>
                            @endif

                            {{-- Daftar Ucapan --}}
                            <div class="mt-7 pt-5 border-t border-[#472A1C]/15 space-y-3">
                                <h3 class="font-serif text-lg font-bold text-[#472A1C]">
                                    Doa &amp; Ucapan ({{ $undangan->bukuTamu->count() }})
                                </h3>
                                <div data-lenis-prevent
                                    class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                                    @forelse ($undangan->bukuTamu as $ucapan)
                                        <div
                                            class="rounded-2xl p-4 border border-[#D7BB83]/40 bg-white/80 space-y-1.5">
                                            <div class="flex items-center justify-between gap-2">
                                                <p class="font-semibold text-sm text-[#2B180F]">
                                                    {{ $ucapan->nama_tamu }}
                                                </p>
                                                <span
                                                    class="rounded-full px-2.5 py-0.5 text-[10px] font-semibold bg-[#472A1C]/10 text-[#472A1C]">
                                                    {{ str_replace('_', ' ', ucfirst($ucapan->status_kehadiran)) }}
                                                </span>
                                            </div>
                                            <p class="text-xs sm:text-sm text-[#472A1C]/85 leading-relaxed">
                                                {{ $ucapan->ucapan_doa }}</p>
                                        </div>
                                    @empty
                                        <p class="text-xs text-[#472A1C]/65">Jadilah yang pertama memberikan doa restu.
                                        </p>
                                    @endforelse
                                </div>
                            </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endif

{{-- SEKSI 12: DOA UNTUK PENGANTIN & TURUT MENGUNDANG (DI ATAS DIORAMA TERPIN) --}}
@php $doaPengantin = $undangan->doaPengantin(); @endphp
@if ($undangan->fiturAktif('doa_pengantin') || $adaTurutMengundang)
    <section class="relative py-12 px-5 space-y-6">
        {{-- Kartu Doa Untuk Pengantin --}}
        @if ($undangan->fiturAktif('doa_pengantin'))
            <div data-section-doa-pengantin="keraton"
                class="rounded-[22px] border-[4px] border-[#D7BB83] bg-[#FFFAF5]/93 px-6 py-10 text-center text-[#2B180F] shadow-xl space-y-4 kartu-3d">
                <h2 data-gsap="naik"
                    class="font-serif text-2xl sm:text-3xl font-bold uppercase tracking-[0.14em] text-[#2B180F]">
                    {{ $doaPengantin['judul'] }}
                </h2>
                @if ($doaPengantin['arab'] !== '')
                    <p data-gsap="mekar" data-gsap-delay="0.06"
                        class="text-xl sm:text-2xl leading-loose text-[#472A1C]" style="font-family: 'Amiri', serif;"
                        dir="rtl">
                        {{ $doaPengantin['arab'] }}
                    </p>
                @endif
                @if ($doaPengantin['latin'] !== '')
                    <p data-gsap="teks" data-gsap-delay="0.08" class="text-xs italic text-[#8C6823]">
                        &ldquo;{{ $doaPengantin['latin'] }}&rdquo;
                    </p>
                @endif
                <p data-gsap="teks" data-gsap-delay="0.10"
                    class="text-xs sm:text-sm text-[#472A1C]/85 leading-relaxed">
                    {{ $doaPengantin['isi'] }}
                </p>
            </div>
        @endif

    {{-- Kartu Turut Mengundang (Opsional) --}}
    @if ($adaTurutMengundang)
        <div data-section-turut-mengundang="keraton"
            class="rounded-[22px] border-[4px] border-[#D7BB83] bg-[#FFFAF5]/93 px-6 py-10 text-center text-[#2B180F] shadow-xl space-y-6 kartu-3d">
            <h2 data-gsap="naik" class="font-serif text-2xl sm:text-3xl font-bold uppercase tracking-[0.14em] text-[#2B180F]">
                {{ $undangan->teksKustom('judul_turut_mengundang', 'Turut Mengundang') }}
            </h2>

                @if (!empty($turutWanita))
                    <div class="space-y-1.5">
                        <p data-gsap="kiri" class="text-[11px] font-bold uppercase tracking-[0.26em] text-[#8C6823]">
                            Pihak Wanita</p>
                        <ul class="space-y-1 text-xs sm:text-sm text-[#472A1C]/90">
                            @foreach ($turutWanita as $baris)
                                <li data-gsap="teks"
                                    data-gsap-delay="{{ number_format(min($loop->index, 5) * 0.04, 2, '.', '') }}">
                                    {{ $baris }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (!empty($turutPria))
                    <div class="space-y-1.5 {{ !empty($turutWanita) ? 'pt-4 border-t border-[#D7BB83]/45' : '' }}">
                        <p data-gsap="kanan" class="text-[11px] font-bold uppercase tracking-[0.26em] text-[#8C6823]">
                            Pihak Pria</p>
                        <ul class="space-y-1 text-xs sm:text-sm text-[#472A1C]/90">
                            @foreach ($turutPria as $baris)
                                <li data-gsap="teks"
                                    data-gsap-delay="{{ number_format(min($loop->index, 5) * 0.04, 2, '.', '') }}">
                                    {{ $baris }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @endif
    </section>
@endif

{{-- SEKSI 13: PENUTUP KAPSUL SIMETRIS + ORNAMEN SUDUT MIRING & FOOTER SOGAN --}}
<section data-layout-penutup="keraton" class="relative pt-8 pb-20 px-5 overflow-hidden">
    <div
        class="relative mx-auto max-w-[395px] rounded-[500px] border-[3px] border-[#D7BB83]/85 bg-[#FFFAF5]/92 px-7 pt-5 pb-36 text-center text-[#2B180F] shadow-2xl overflow-hidden kartu-3d">
        {{-- Sepasang Ornamen Sudut Bawah Miring Simetris di Belakang Teks agar Nama Mempelai 100% Terbaca --}}
        <div data-gsap="kiri" class="pointer-events-none absolute -bottom-10 -left-9 w-32 z-0">
            <img src="{{ $asetJawa['bungaLili'] }}" alt="" aria-hidden="true" loading="lazy"
                decoding="async" class="w-full opacity-75 jawa-potret-tutup-kiri">
        </div>
        <div data-gsap="kanan" class="pointer-events-none absolute -bottom-10 -right-9 w-32 z-0">
            <img src="{{ $asetJawa['bungaLili'] }}" alt="" aria-hidden="true" loading="lazy"
                decoding="async" class="w-full opacity-75 jawa-potret-tutup-kanan">
        </div>

        <div class="relative z-10 space-y-5">
            @if (!$tanpaFoto && !empty($urlFotoPenutup))
                <img src="{{ $urlFotoPenutup }}"
                    alt="{{ $undangan->nama_panggilan_pria }} & {{ $undangan->nama_panggilan_wanita }}"
                    loading="lazy" decoding="async" data-gsap="potret"
                    class="w-full h-80 rounded-t-[500px] rounded-b-[20px] object-cover object-top shadow-lg">
            @else
                <div data-gsap="potret"
                    class="mx-auto mt-6 w-36 h-44 rounded-t-[500px] rounded-b-2xl border-2 border-[#D7BB83] bg-[#472A1C] text-[#F3E5AB] flex flex-col items-center justify-center shadow-lg">
                    <span class="font-serif text-4xl font-semibold">{{ $undangan->inisialPria() }} &amp;
                        {{ $undangan->inisialWanita() }}</span>
                </div>
            @endif

            @if ($undangan->teksKustom('judul_penutup') !== '')
                <p data-gsap="mekar" class="text-[10px] font-bold uppercase tracking-[0.32em] text-[#8C6823]">
                    {{ $undangan->teksKustom('judul_penutup') }}
                </p>
            @endif

            <p data-gsap="teks" class="text-xs sm:text-sm text-[#472A1C]/85 leading-relaxed px-2">
                {{ $undangan->teksKustom('ucapan_penutup', 'Atas kehadiran dan doa restu yang Bapak/Ibu/Saudara/i berikan, kami ucapkan terima kasih. Semoga Allah SWT senantiasa melimpahkan rahmat dan berkah-Nya kepada kita semua.') }}
            </p>

            <div class="pt-2 space-y-1.5">
                <p data-gsap="naik" class="text-xs font-semibold text-[#472A1C]">
                    {{ $undangan->teksKustom('label_penutup', 'Kami Yang Berbahagia,') }}</p>
                <p data-gsap="mekar" data-gsap-delay="0.08"
                    class="font-serif text-2xl sm:text-3xl font-bold uppercase tracking-[0.14em] text-[#472A1C] drop-shadow-[0_1px_4px_rgba(255,250,245,0.95)]">
                    {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
                </p>
            </div>
        </div>
    </div>

    {{-- Hamparan Bunga Mawar Menutup Tepi Bawah di Atas Footer --}}
    <img src="{{ $asetJawa['bungaDepan'] }}" alt="" aria-hidden="true"
        class="pointer-events-none absolute bottom-0 inset-x-0 w-full z-20">
</section>

@include('komponen-undangan.footer-tema', [
    'gelap' => true,
    'warnaOrnamen' => '#D7BB83',
    'kelasLatar' =>
        'relative z-30 bg-gradient-to-b from-[#472A1C] via-[#3A2116] to-[#2C180F] shadow-[0_0_0_2px_#472A1C] border-t border-[#D7BB83]/35',
    'kelasPadding' => 'pt-5 pb-6 px-4',
    'kelasTeks' => 'text-[#FFFAF5]/85',
    'kelasAksen' => 'text-[#E5C98E]',
    'kelasTombol' =>
        'bg-[#FFFAF5]/10 text-[#F3E5AB] border border-[#D7BB83]/45 hover:-translate-y-0.5 hover:bg-[#D7BB83] hover:text-[#2B180F]',
])
