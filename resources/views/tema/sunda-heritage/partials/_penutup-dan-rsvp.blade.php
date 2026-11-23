{{-- SEKSI 10: AMPLOP DIGITAL & KADO FISIK PRIANGAN (BUKA-TUTUP KARTU BANK GLOSSY) --}}
@if ($undangan->fiturAktif('amplop_digital') && ($undangan->daftarAmplop->isNotEmpty() || $alamatKado !== ''))
    <section x-data="{ amplopTerbuka: false }" class="relative px-4 py-12 overflow-hidden">
        <div
            class="max-w-md mx-auto rounded-[1.75rem] bg-[#FFFBF4] border border-[#C59B43]/70 overflow-hidden shadow-[0_18px_42px_-16px_rgba(74,23,23,0.24)] kartu-3d">
            {{-- Header Pita Marun Priangan --}}
            <div
                class="relative bg-gradient-to-b from-[#602121] to-[#4A1717] px-6 py-5 text-center text-[#FAF4E8] border-b border-[#C59B43]/65">
                <span aria-hidden="true"
                    class="pointer-events-none absolute top-2.5 left-2.5 h-3 w-3 border-t border-l border-[#E7C87D]/55 rounded-tl-sm"></span>
                <span aria-hidden="true"
                    class="pointer-events-none absolute top-2.5 right-2.5 h-3 w-3 border-t border-r border-[#E7C87D]/55 rounded-tr-sm"></span>

                <p data-gsap="turun" class="text-[9.5px] font-bold uppercase tracking-[0.32em] text-[#E7C87D]">Tanda Kasih</p>
                <h2 data-gsap="mekar" data-gsap-delay="0.06" class="mt-1 font-kaligrafi text-[2.45rem] sm:text-[2.65rem] leading-[1.08] text-[#FFFDF8]">
                    Amplop Digital
                </h2>
            </div>

            {{-- Badan Piagam Gading + Tombol Buka/Tutup & Laci Kartu Bank --}}
            <div class="px-5 sm:px-6 py-7 text-center text-[#4A2020] space-y-5">
                <p data-gsap="teks" class="text-xs sm:text-[13px] text-[#4A2020]/78 leading-relaxed max-w-xs mx-auto">
                    Doa restu Bapa/Ibu/Saderek mangrupikeun kado pangsaena. Bilih kersa ngintun tanda kasih, mangga
                    tiasa liwat:
                </p>

                <div data-gsap="mekar" data-gsap-delay="0.08">
                    <button
                        type="button"
                        @click="amplopTerbuka = !amplopTerbuka; window.SesiTemuSinema?.refresh(360)"
                        :aria-expanded="amplopTerbuka.toString()"
                        class="sunda-tombol-marun inline-flex items-center justify-center gap-2 rounded-full px-6 py-2.5 text-xs font-bold uppercase tracking-[0.14em] transition active:scale-95 cursor-pointer"
                    >
                        <svg class="h-3.5 w-3.5 text-[#E7C87D]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="3" y="8" width="18" height="4" rx="1" />
                            <path d="M12 8v13" />
                            <path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7" />
                            <path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5" />
                        </svg>
                        <span x-text="amplopTerbuka ? 'Tutup Rekening' : 'Buka Amplop Digital'"></span>
                        <svg class="h-3.5 w-3.5 text-[#E7C87D] transition-transform duration-300"
                            :class="amplopTerbuka ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
                            aria-hidden="true">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                    </button>
                </div>

                {{-- Daftar Kartu Bank Glossy & Alamat Kado (Bisa Dibuka & Ditutup) --}}
                <div
                    x-show="amplopTerbuka"
                    x-cloak
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-2 scale-[0.98]"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 -translate-y-2 scale-[0.98]"
                    class="pt-2 space-y-4 text-left panggung-3d"
                >
                    <div class="flex items-center justify-center gap-3 px-10 pb-1" aria-hidden="true">
                        <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#C59B43]/55"></span>
                        <span class="w-1.5 h-1.5 rotate-45 bg-[#C59B43]"></span>
                        <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#C59B43]/55"></span>
                    </div>

                    @foreach ($undangan->daftarAmplop as $amplop)
                        @php
                            $gayaBank = \App\Support\GayaKartuBank::untukNamaBank($amplop->nama_bank);
                            $nomorTerformat = \App\Support\GayaKartuBank::formatNomor($amplop->nomor_rekening);
                            $idKartuAmplop = $amplop->id ?? $loop->iteration;
                        @endphp
                        <div
                            class="relative rounded-2xl p-5 text-white overflow-hidden border border-[#E7C87D]/45 shadow-[0_16px_34px_-12px_rgba(43,14,14,0.55)] kartu-3d"
                            style="background: {{ $gayaBank['gradient_css'] }};"
                        >
                            {{-- Pendar Glossy Kartu Bank --}}
                            <div aria-hidden="true"
                                class="pointer-events-none absolute -top-12 -right-12 h-36 w-36 rounded-full bg-white/12 blur-xl">
                            </div>
                            <div aria-hidden="true"
                                class="pointer-events-none absolute -bottom-12 -left-10 h-32 w-32 rounded-full opacity-22 blur-xl"
                                style="background-color: {{ $gayaBank['aksen_hex'] }};"></div>
                            <span aria-hidden="true"
                                class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-[#F3E5AB]/55 to-transparent"></span>

                            {{-- Baris Atas: Jenis & Nama Bank + Chip EMV / Dompet Digital --}}
                            <div class="relative z-10 flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-white/75">
                                        {{ $gayaBank['label_jenis'] }}
                                    </p>
                                    <p class="mt-0.5 font-sans text-base font-extrabold tracking-wide text-white drop-shadow-xs">
                                        {{ $gayaBank['singkatan'] }}
                                    </p>
                                </div>

                                @if ($gayaBank['chip_gaya'] === 'wallet')
                                    <div aria-hidden="true"
                                        class="h-8 w-10 rounded-lg border border-white/30 bg-white/15 backdrop-blur-xs flex items-center justify-center shadow-inner">
                                        <svg class="w-4 h-4 text-[#F3E5AB]" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1" />
                                            <path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4" />
                                        </svg>
                                    </div>
                                @else
                                    <div aria-hidden="true"
                                        class="h-7 w-10 rounded-md border border-white/35 shadow-inner {{ $gayaBank['chip_gaya'] === 'perak' ? 'bg-gradient-to-br from-slate-100 via-slate-300 to-slate-400' : 'bg-gradient-to-br from-[#F9E7A8] via-[#D4AF37] to-[#9A7422]' }}">
                                    </div>
                                @endif
                            </div>

                            {{-- Nomor Rekening Timbul & Nama Pemilik --}}
                            <div class="relative z-10 mt-5">
                                <p class="font-mono text-lg sm:text-xl font-bold tracking-[0.14em] text-white drop-shadow-xs">
                                    {{ $nomorTerformat }}
                                </p>
                                <p class="mt-1 text-xs text-white/85">a.n. {{ $amplop->atas_nama }}</p>
                            </div>

                            {{-- Footer Kartu: Label Bank + Tombol Salin --}}
                            <div
                                class="relative z-10 mt-4 pt-3 border-t border-white/15 flex items-center justify-between gap-2">
                                <span class="text-[10px] font-medium text-white/75 truncate">{{ $amplop->nama_bank }}</span>
                                <button
                                    type="button"
                                    @click="salinRekening(@js($amplop->nomor_rekening), {{ $idKartuAmplop }})"
                                    class="inline-flex items-center gap-1.5 rounded-full bg-[#3B1414]/45 hover:bg-[#C59B43] border border-[#F3E5AB]/45 hover:border-[#F3E5AB] hover:text-[#3B1414] px-3.5 py-1.5 text-[11px] font-semibold text-[#FFFDF8] transition cursor-pointer shrink-0"
                                >
                                    <svg x-show="rekeningTersalin !== {{ $idKartuAmplop }}" class="w-3 h-3"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1"
                                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <rect width="14" height="14" x="8" y="8" rx="2" ry="2" />
                                        <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2" />
                                    </svg>
                                    <svg x-show="rekeningTersalin === {{ $idKartuAmplop }}" x-cloak class="w-3 h-3"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"
                                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M20 6 9 17l-5-5" />
                                    </svg>
                                    <span
                                        x-text="rekeningTersalin === {{ $idKartuAmplop }} ? 'Berhasil Disalin!' : 'Salin Nomor'"></span>
                                </button>
                            </div>
                        </div>
                    @endforeach

                    @if ($alamatKado !== '')
                        <div x-data="{ alamatTersalin: false }"
                            class="rounded-2xl bg-[#FAF4E8] border border-[#C59B43]/55 p-4.5 text-center space-y-2.5">
                            <p class="text-[10px] font-bold uppercase tracking-[0.28em] text-[#8E6620]">
                                Alamat Pengiriman Kado
                            </p>
                            <p class="text-xs sm:text-[13px] text-[#4A2020]/85 leading-relaxed">{{ $alamatKado }}</p>
                            <button
                                type="button"
                                @click="navigator.clipboard?.writeText(@js($alamatKado)); alamatTersalin = true; setTimeout(() => alamatTersalin = false, 2200)"
                                class="sunda-tombol-emas inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-[11px] font-bold uppercase tracking-wider transition active:scale-95 cursor-pointer"
                            >
                                <span x-show="!alamatTersalin">Salin Alamat</span>
                                <span x-show="alamatTersalin" x-cloak>Alamat Tersalin!</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endif

{{-- SEKSI 11: RSVP & WISHES (BLOK MARUN PRIANGAN) --}}
@if ($undangan->fiturAktif('buku_tamu'))
    <section id="buku-tamu" class="relative bg-[#5A1E1E] shadow-[0_0_0_2px_#5A1E1E] text-[#FAF4E8] py-14 px-5 overflow-hidden">
        <div class="max-w-md mx-auto">
            <div class="text-center space-y-2">
                <img src="{{ $asetSunda['siger'] }}" alt="" loading="lazy" decoding="async"
                    data-gsap="turun"
                    class="w-14 mx-auto drop-shadow-lg">
                <h2 data-gsap="mekar" class="font-serif text-4xl sm:text-5xl font-bold uppercase tracking-[0.12em] text-white leading-tight">
                    RSVP &amp; Wishes
                </h2>
                <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs text-[#FAF4E8]/80 max-w-xs mx-auto leading-relaxed">
                    Kami mempersilakan Bapak/Ibu/Saudara/i untuk menyampaikan ucapan selamat, doa restu, serta konfirmasi kehadiran.
                </p>
                <div data-gsap="garis" aria-hidden="true" class="mx-auto w-24 h-px bg-[#E7C87D]/55 pt-1"></div>
            </div>

            <div
                data-gsap="naik"
                class="mt-7 rounded-[22px] bg-[#FFFBF4] border-2 border-[#C59B43]/65 p-5 sm:p-6 shadow-2xl space-y-5 text-[#4A2020] kartu-3d">
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
                                <label class="block text-xs font-semibold uppercase tracking-wider text-[#5A1E1E]/80">Nama
                                    Lengkap</label>
                                <input type="text" x-model="namaTamu" required placeholder="Nama Anda"
                                    class="mt-1 w-full rounded-xl border border-[#C59B43]/60 bg-white px-4 py-2.5 text-sm">
                            </div>
                            <div class="grid gap-3" :class="statusKehadiran === 'hadir' ? 'grid-cols-2' : 'grid-cols-1'">
                                <div>
                                    <label
                                        class="block text-xs font-semibold uppercase tracking-wider text-[#5A1E1E]/80">Kehadiran</label>
                                    <select x-ref="selectKehadiran" x-model="statusKehadiran"
                                        @change="statusKehadiran = $event.target.value"
                                        class="mt-1 w-full rounded-xl border border-[#C59B43]/60 bg-white px-3.5 py-2.5 text-sm">
                                        <option value="hadir">Hadir</option>
                                        <option value="ragu">Masih Ragu</option>
                                        <option value="tidak_hadir">Tidak Hadir</option>
                                    </select>
                                </div>
                                <div x-show="statusKehadiran === 'hadir'" x-cloak>
                                    <label
                                        class="block text-xs font-semibold uppercase tracking-wider text-[#5A1E1E]/80">Jumlah</label>
                                    <input type="number" x-model.number="jumlahTamu" min="1" max="20"
                                        :required="statusKehadiran === 'hadir'"
                                        :disabled="statusKehadiran !== 'hadir'"
                                        class="mt-1 w-full rounded-xl border border-[#C59B43]/60 bg-white px-3.5 py-2.5 text-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-[#5A1E1E]/80">Ucapan
                                    &amp; Doa</label>
                                <textarea x-model="ucapanDoa" rows="3" required placeholder="Tulis ucapan &amp; doa terbaik..."
                                    class="mt-1 w-full rounded-xl border border-[#C59B43]/60 bg-white px-4 py-2.5 text-sm"></textarea>
                            </div>
                            <button type="submit"
                                class="sunda-tombol-marun w-full rounded-full py-3 text-xs font-bold uppercase tracking-wider transition cursor-pointer">
                                Kirim Konfirmasi &amp; Doa
                            </button>
                            <p x-show="pesanGalat" x-cloak x-text="pesanGalat"
                                class="text-xs font-semibold text-rose-700 text-center"></p>
                            <p x-show="pesanSukses" x-cloak x-text="pesanSukses"
                                class="rounded-xl bg-emerald-50 border border-emerald-200 px-3 py-2 text-[11px] font-semibold text-emerald-800 text-center">
                            </p>
                        </form>

                        <div class="pt-4 border-t border-[#C59B43]/35 space-y-3">
                            <div class="flex items-center justify-between gap-2">
                                <h3 class="font-serif text-base font-bold text-[#5A1E1E]">
                                    Doa &amp; Ucapan (<span
                                        x-text="daftarUcapan.length">{{ count($daftarUcapanAwal) }}</span>)
                                </h3>
                                <span class="text-[10px] uppercase tracking-wider text-[#8E6620]">Gulir untuk lainnya</span>
                            </div>
                            <div x-ref="daftarUcapanScroll" data-lenis-prevent
                                class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                                <template x-for="ucapan in daftarUcapan" :key="ucapan.id">
                                    <div class="rounded-2xl bg-[#FAF4E8]/90 border p-3.5 space-y-1.5 transition"
                                        :class="ucapan.baru ? 'border-[#5A1E1E]/60 ring-1 ring-[#C59B43]/50' : 'border-[#C59B43]/35'">
                                        <div class="flex items-center justify-between gap-2">
                                            <p class="font-bold text-xs text-[#5A1E1E]" x-text="ucapan.nama_tamu"></p>
                                            <span class="shrink-0 rounded-full px-2.5 py-0.5 text-[10px] font-semibold"
                                                :class="kelasStatus(ucapan.status_kehadiran, false,
                                                    'bg-[#5A1E1E]/10 text-[#5A1E1E]')"
                                                x-text="labelStatus(ucapan.status_kehadiran)"></span>
                                        </div>
                                        <p class="text-xs text-[#4A2020]/80 leading-relaxed" x-text="ucapan.ucapan_doa"></p>
                                        <p class="text-[10px] text-[#8E6620]/80" x-text="ucapan.waktu"></p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                @else
                    @if (!empty($modePratinjau) || !$undangan->sudahAktifPublik())
                        <div
                            class="rounded-2xl bg-[#FAF4E8] border border-[#C59B43]/50 px-4 py-3 text-center text-xs font-semibold text-[#5A1E1E]">
                            Mode Pratinjau — Buku Tamu &amp; RSVP Dikunci
                        </div>
                    @else
                        <form x-data="{ statusKehadiran: @js(old('status_kehadiran', 'hadir')) }" method="POST"
                            action="{{ route('undangan.ucapan', $undangan->slug) }}" class="space-y-4 text-left">
                            @csrf
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-[#5A1E1E]/80">Nama
                                    Lengkap</label>
                                <input type="text" name="nama_tamu"
                                    value="{{ old('nama_tamu', $namaTamu !== 'Tamu Undangan' ? $namaTamu : '') }}"
                                    required placeholder="Masukkan nama Anda"
                                    class="mt-1.5 w-full rounded-xl border border-[#C59B43]/60 bg-white px-4 py-2.5 text-sm">
                            </div>
                            <div class="grid grid-cols-1 gap-3.5"
                                :class="statusKehadiran === 'hadir' ? 'sm:grid-cols-2' : 'sm:grid-cols-1'">
                                <div>
                                    <label
                                        class="block text-xs font-semibold uppercase tracking-wider text-[#5A1E1E]/80">Konfirmasi
                                        Kehadiran</label>
                                    <select name="status_kehadiran" x-model="statusKehadiran"
                                        @change="statusKehadiran = $event.target.value"
                                        class="mt-1.5 w-full rounded-xl border border-[#C59B43]/60 bg-white px-3.5 py-2.5 text-sm">
                                        <option value="hadir" @selected(old('status_kehadiran', 'hadir') === 'hadir')>InsyaAllah Hadir</option>
                                        <option value="ragu" @selected(old('status_kehadiran') === 'ragu')>Masih Ragu</option>
                                        <option value="tidak_hadir" @selected(old('status_kehadiran') === 'tidak_hadir')>Tidak Dapat Hadir</option>
                                    </select>
                                </div>
                                <div x-show="statusKehadiran === 'hadir'" x-cloak>
                                    <label
                                        class="block text-xs font-semibold uppercase tracking-wider text-[#5A1E1E]/80">Jumlah
                                        Tamu</label>
                                    <input type="number" name="jumlah_tamu" value="{{ old('jumlah_tamu', 1) }}"
                                        min="1" max="20" :required="statusKehadiran === 'hadir'"
                                        :disabled="statusKehadiran !== 'hadir'"
                                        class="mt-1.5 w-full rounded-xl border border-[#C59B43]/60 bg-white px-3.5 py-2.5 text-sm">
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-semibold uppercase tracking-wider text-[#5A1E1E]/80">Ucapan
                                    &amp; Doa Restu</label>
                                <textarea name="ucapan_doa" rows="3" required placeholder="Tuliskan doa terbaik untuk kedua mempelai..."
                                    class="mt-1.5 w-full rounded-xl border border-[#C59B43]/60 bg-white px-4 py-2.5 text-sm">{{ old('ucapan_doa') }}</textarea>
                            </div>
                            <button type="submit"
                                class="sunda-tombol-marun w-full rounded-full py-3 text-xs font-bold uppercase tracking-wider transition cursor-pointer">
                                Kirim Konfirmasi &amp; Doa
                            </button>
                        </form>
                    @endif

                    <div class="pt-4 border-t border-[#C59B43]/35 space-y-3">
                        <h3 class="font-serif text-base font-bold text-[#5A1E1E]">Doa &amp; Ucapan
                            ({{ $undangan->bukuTamu->count() }})</h3>
                        <div data-lenis-prevent class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                            @forelse ($undangan->bukuTamu as $ucapan)
                                <div class="rounded-2xl bg-[#FAF4E8]/90 border border-[#C59B43]/35 p-3.5 space-y-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="font-bold text-xs text-[#5A1E1E]">{{ $ucapan->nama_tamu }}</p>
                                        <span
                                            class="rounded-full bg-[#5A1E1E]/10 px-2.5 py-0.5 text-[10px] font-semibold text-[#5A1E1E]">
                                            {{ str_replace('_', ' ', ucfirst($ucapan->status_kehadiran)) }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-[#4A2020]/80 leading-relaxed">{{ $ucapan->ucapan_doa }}</p>
                                </div>
                            @empty
                                <p class="text-xs text-[#4A2020]/60 text-center">Jadilah yang pertama memberikan doa restu.
                                </p>
                            @endforelse
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif

{{-- SEKSI 12: DOA UNTUK PENGANTIN & TURUT MENGUNDANG --}}
<section class="relative px-4 py-12 space-y-6 overflow-hidden">
    {{-- Kartu Doa Untuk Pengantin --}}
    <div data-section-doa-pengantin="priangan"
        class="max-w-md mx-auto rounded-[1.75rem] border-2 border-[#C59B43]/75 bg-[#FFFBF4] px-6 py-9 text-center text-[#4A2020] shadow-[0_18px_42px_-16px_rgba(74,23,23,0.22)] space-y-4 kartu-3d">
        <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#8E6620]">Doa Restu</p>
        <h2 data-gsap="naik" class="font-serif text-2xl sm:text-3xl font-bold uppercase tracking-[0.12em] text-[#5A1E1E]">
            Doa Untuk Pengantin
        </h2>
        <p data-gsap="mekar" data-gsap-delay="0.06" class="text-xl sm:text-2xl leading-loose text-[#5A1E1E]" style="font-family: 'Amiri', serif;"
            dir="rtl">
            بَارَكَ اللّٰهُ لَكَ وَبَارَكَ عَلَيْكَ وَجَمَعَ بَيْنَكُمَا فِي خَيْرٍ
        </p>
        <p data-gsap="teks" data-gsap-delay="0.08" class="text-xs italic text-[#8E6620]">
            &ldquo;Baarakallahu laka wa baaraka &lsquo;alaika wa jama&lsquo;a bainakuma fii khair.&rdquo;
        </p>
        <p data-gsap="teks" data-gsap-delay="0.10" class="text-xs sm:text-sm text-[#4A2020]/85 leading-relaxed">
            Semoga Allah memberkahimu di waktu bahagia dan memberkahimu di waktu susah, serta semoga Allah mempersatukan
            kalian berdua dalam kebaikan. <span class="font-semibold text-[#5A1E1E]">(HR. Abu Daud)</span>
        </p>
    </div>

    {{-- Kartu Turut Mengundang (Opsional) --}}
    @if ($adaTurutMengundang)
        <div data-section-turut-mengundang="priangan"
            class="max-w-md mx-auto rounded-[1.75rem] bg-[#5A1E1E] text-[#FAF4E8] border-2 border-[#C59B43]/65 p-6 text-center shadow-xl space-y-4 kartu-3d">
            <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#E7C87D]">Keluarga Besar</p>
            <h2 data-gsap="naik" class="font-serif text-2xl font-bold text-white">Turut Mengundang</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                @if (!empty($turutWanita))
                    <div data-gsap="kiri" class="rounded-2xl bg-[#3B1414]/75 border border-[#C59B43]/40 p-3.5 space-y-1">
                        <p class="font-bold uppercase tracking-wider text-[#E7C87D] text-[10px]">Pihak
                            {{ $undangan->nama_panggilan_wanita }}</p>
                        @foreach ($turutWanita as $baris)
                            <p class="text-[#FAF4E8]/90">{{ $baris }}</p>
                        @endforeach
                    </div>
                @endif
                @if (!empty($turutPria))
                    <div data-gsap="kanan" data-gsap-delay="0.06" class="rounded-2xl bg-[#3B1414]/75 border border-[#C59B43]/40 p-3.5 space-y-1">
                        <p class="font-bold uppercase tracking-wider text-[#E7C87D] text-[10px]">Pihak
                            {{ $undangan->nama_panggilan_pria }}</p>
                        @foreach ($turutPria as $baris)
                            <p class="text-[#FAF4E8]/90">{{ $baris }}</p>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif
</section>

{{-- SEKSI 13: KAPSUL PENUTUP PRIANGAN & FOOTER --}}
<section data-layout-penutup="priangan" class="relative px-4 pt-6 pb-16 overflow-hidden">
    <div
        class="relative z-10 max-w-md mx-auto rounded-t-[10.5rem] rounded-b-[2rem] bg-gradient-to-b from-[#5F2222] via-[#4A1717] to-[#340F0F] text-[#FAF4E8] border-2 border-[#C59B43]/85 shadow-[0_26px_58px_-16px_rgba(59,20,20,0.5)] overflow-hidden kartu-3d">
        {{-- Siluet Halus Gapura Priangan di Latar Teks --}}
        <img src="{{ $asetSunda['gapura'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async"
            class="pointer-events-none absolute inset-x-0 bottom-0 w-full h-3/4 object-cover object-bottom opacity-[0.07]">

        {{-- Potret Penutup Besar Mengisi Lengkungan Kubah Penuh (Konsetris dengan Bingkai Emas) --}}
        @if ($urlFotoPenutup)
            <div data-gsap="potret" class="relative p-2.5 sm:p-3 pb-0">
                <div
                    class="relative overflow-hidden rounded-t-[9.6rem] rounded-b-[1.35rem] border border-[#E7C87D]/70 bg-[#2E0E0E] shadow-[0_18px_38px_-12px_rgba(16,4,4,0.75)]">
                    <img src="{{ $urlFotoPenutup }}"
                        alt="Foto Penutup {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                        loading="lazy" decoding="async"
                        class="w-full h-[22.5rem] sm:h-[24.5rem] object-cover object-top">
                    <div aria-hidden="true"
                        class="pointer-events-none absolute inset-0"
                        style="background: linear-gradient(180deg, rgba(43,14,14,0.08) 0%, rgba(43,14,14,0) 45%, rgba(59,20,20,0.48) 82%, rgba(74,23,23,0.92) 100%);">
                    </div>
                </div>
            </div>
        @else
            <div data-gsap="potret" class="pt-14 pb-2 flex justify-center">
                <div
                    class="relative w-36 h-44 rounded-t-[6rem] rounded-b-2xl border-2 border-[#E7C87D]/75 bg-gradient-to-b from-[#6E2C2C]/85 to-[#320F0F] flex flex-col items-center justify-center shadow-xl">
                    <span aria-hidden="true"
                        class="pointer-events-none absolute inset-1.5 rounded-t-[5.4rem] rounded-b-xl border border-[#F3E5AB]/30"></span>
                    <span class="font-serif text-4xl font-bold text-[#F3E5AB] tracking-wider">
                        {{ $undangan->inisialPria() }} &amp; {{ $undangan->inisialWanita() }}
                    </span>
                </div>
            </div>
        @endif

        {{-- Mahkota Siger & Panel Terima Kasih Priangan (Animasi Per Komponen) --}}
        <div class="relative z-10 px-6 {{ $urlFotoPenutup ? '-mt-7 pt-0' : 'pt-4' }} pb-10 text-center space-y-4">
            {{-- Sudut Filigree Emas Bawah --}}
            <span aria-hidden="true"
                class="pointer-events-none absolute bottom-3 left-3 h-4 w-4 border-b border-l border-[#E7C87D]/60 rounded-bl-md"></span>
            <span aria-hidden="true"
                class="pointer-events-none absolute bottom-3 right-3 h-4 w-4 border-b border-r border-[#E7C87D]/60 rounded-br-md"></span>

            {{-- Medali Siger Bertengger di Sambungan Potret --}}
            <div
                data-gsap="mekar"
                class="mx-auto inline-flex items-center justify-center rounded-full bg-[#4A1717] border border-[#E7C87D]/70 px-3.5 py-2 shadow-[0_10px_22px_rgba(16,4,4,0.65)]">
                <img src="{{ $asetSunda['siger'] }}" alt="" loading="lazy" decoding="async"
                    class="w-12 opacity-95">
            </div>

            <div data-gsap="turun" class="flex items-center justify-center gap-2.5 pt-0.5">
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-r from-transparent to-[#E7C87D]/70"></span>
                <span aria-hidden="true" class="w-1.5 h-1.5 rotate-45 bg-[#E7C87D]"></span>
                <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#E7C87D]">Hatur Nuhun</p>
                <span aria-hidden="true" class="w-1.5 h-1.5 rotate-45 bg-[#E7C87D]"></span>
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-l from-transparent to-[#E7C87D]/70"></span>
            </div>

            <p data-gsap="teks" class="text-xs sm:text-[13px] text-[#FAF4E8]/88 leading-relaxed max-w-xs mx-auto">
                Mugia kahadiran sareng doa restu Bapa/Ibu/Saderek ngajantenkeun amal soleh sareng kabagjaan kangge rumah
                tangga sim kuring.
            </p>

            <div data-gsap="garis" class="flex items-center justify-center gap-3 px-10 pt-1" aria-hidden="true">
                <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#E7C87D]/45"></span>
                <span class="w-1 h-1 rotate-45 bg-[#E7C87D]"></span>
                <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#E7C87D]/45"></span>
            </div>

            <div class="pt-0.5 space-y-1.5">
                <p data-gsap="naik" class="text-[10px] font-semibold uppercase tracking-[0.28em] text-[#E7C87D]/85">
                    Kami Yang Berbahagia
                </p>
                <p data-gsap="mekar" data-gsap-delay="0.06" class="font-kaligrafi text-[2.75rem] sm:text-5xl text-white leading-[1.12] drop-shadow-[0_3px_12px_rgba(16,4,4,0.55)]">
                    {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
                </p>
                <p data-gsap="naik" data-gsap-delay="0.10" class="inline-block rounded-full border border-[#E7C87D]/35 bg-[#3B1414]/65 px-3.5 py-1 text-[10px] font-medium uppercase tracking-[0.22em] text-[#F3E5AB]">
                    {{ $hashtagPasangan }}
                </p>
            </div>
        </div>
    </div>

    {{-- Hamparan Bunga Priangan Halus Menyatukan Tepi Bawah Seksi Penutup ke Footer --}}
    <img src="{{ $asetSunda['bungaDepan'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async"
        class="pointer-events-none absolute -bottom-2 inset-x-0 w-full z-20 opacity-95 drop-shadow-[0_-8px_18px_rgba(32,10,10,0.45)]">
</section>

@include('komponen-undangan.footer-tema', [
    'gelap' => true,
    'warnaOrnamen' => '#E7C87D',
    'kelasLatar' => 'bg-gradient-to-b from-[#3B1414] via-[#2F1010] to-[#230B0B] border-t border-[#C59B43]/40',
    'kelasTeks' => 'text-[#FAF4E8]/85',
    'kelasAksen' => 'text-[#E7C87D]',
    'kelasTombol' =>
        'bg-[#FAF4E8]/10 text-[#F3E5AB] border border-[#C59B43]/45 hover:-translate-y-0.5 hover:bg-[#C59B43] hover:text-[#3B1414]',
])
