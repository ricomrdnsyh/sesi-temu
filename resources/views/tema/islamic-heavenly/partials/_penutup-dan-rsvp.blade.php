{{-- SEKSI 9: AMPLOP DIGITAL CELESTIAL (PLAKAT KUBAH SAFIR & LACI KARTU BANK GLOSSY) --}}
@if ($undangan->fiturAktif('amplop_digital') && ($undangan->daftarAmplop->isNotEmpty() || $alamatKado !== ''))
    <section x-data="{ amplopTerbuka: false }" class="relative bg-[#091322] celestial-pola-bintang px-4 py-12 overflow-hidden">
        <div class="relative max-w-md mx-auto rounded-t-[8.5rem] rounded-b-[1.85rem] bg-gradient-to-b from-[#14263E] via-[#102036] to-[#0B1626] border border-[#D9B664]/65 px-5 sm:px-6 pt-9 pb-7 text-center shadow-[0_24px_52px_-16px_rgba(0,0,0,0.82)] overflow-hidden kartu-3d">
            <span aria-hidden="true" class="pointer-events-none absolute inset-2.5 rounded-t-[7.8rem] rounded-b-[1.35rem] border border-dashed border-[#D9B664]/35"></span>

            <div class="relative z-10 space-y-4">
                <div data-gsap="turun" class="relative mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-[#091322]/90 border border-[#D9B664]/70 shadow-[0_0_20px_-4px_rgba(217,182,100,0.45)]">
                    <svg class="h-4.5 w-4.5 text-[#F3E5AB]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="3" y="8" width="18" height="4" rx="1"/>
                        <path d="M12 8v13"/>
                        <path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"/>
                        <path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"/>
                    </svg>
                </div>

                <div class="space-y-1">
                    <p data-gsap="turun" class="text-[9.5px] font-bold uppercase tracking-[0.34em] text-[#D9B664]">Tanda Kasih</p>
                    <h2 data-gsap="mekar" data-gsap-delay="0.06" class="font-serif text-[1.75rem] sm:text-[1.95rem] font-bold leading-tight text-[#F3E5AB]">
                        Hadiah Pernikahan
                    </h2>
                </div>

                <p data-gsap="teks" class="text-xs sm:text-[13px] text-[#E6EEF8]/82 leading-relaxed max-w-xs mx-auto">
                    Doa restu Bapak/Ibu/Saudara/i adalah karunia terindah. Apabila berkenan memberikan tanda kasih, dapat melalui:
                </p>

                <div data-gsap="mekar" data-gsap-delay="0.08" class="pt-1">
                    <button
                        type="button"
                        @click="amplopTerbuka = !amplopTerbuka; window.SesiTemuSinema?.refresh(360)"
                        :aria-expanded="amplopTerbuka.toString()"
                        class="celestial-tombol-emas inline-flex items-center justify-center gap-2 rounded-full px-6 py-2.5 text-xs font-bold uppercase tracking-[0.14em] transition active:scale-95 cursor-pointer"
                    >
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="3" y="8" width="18" height="4" rx="1"/>
                            <path d="M12 8v13"/>
                            <path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"/>
                            <path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"/>
                        </svg>
                        <span x-text="amplopTerbuka ? 'Tutup Rekening' : 'Buka Amplop Digital'"></span>
                        <svg class="h-3.5 w-3.5 transition-transform duration-300" :class="amplopTerbuka ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>
                </div>

                {{-- Daftar Kartu Bank Glossy & Alamat Kado --}}
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
                        <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#D9B664]/55"></span>
                        <span class="text-[9px] text-[#F3E5AB]">&#10022;</span>
                        <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#D9B664]/55"></span>
                    </div>

                    @foreach ($undangan->daftarAmplop as $amplop)
                        @php
                            $gayaBank = \App\Support\GayaKartuBank::untukNamaBank($amplop->nama_bank);
                            $nomorTerformat = \App\Support\GayaKartuBank::formatNomor($amplop->nomor_rekening);
                            $idKartuAmplop = $amplop->id ?? $loop->iteration;
                        @endphp
                        <div
                            class="relative rounded-2xl p-5 text-white overflow-hidden border border-[#F3E5AB]/45 shadow-[0_18px_38px_-12px_rgba(0,0,0,0.72)] kartu-3d"
                            style="background: {{ $gayaBank['gradient_css'] }};"
                        >
                            <div aria-hidden="true" class="pointer-events-none absolute -top-12 -right-12 h-36 w-36 rounded-full bg-white/12 blur-xl"></div>
                            <div aria-hidden="true" class="pointer-events-none absolute -bottom-12 -left-10 h-32 w-32 rounded-full opacity-22 blur-xl" style="background-color: {{ $gayaBank['aksen_hex'] }};"></div>
                            <span aria-hidden="true" class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-[#F3E5AB]/55 to-transparent"></span>

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
                                    <div aria-hidden="true" class="h-8 w-10 rounded-lg border border-white/30 bg-white/15 backdrop-blur-xs flex items-center justify-center shadow-inner">
                                        <svg class="w-4 h-4 text-[#F3E5AB]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/>
                                            <path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/>
                                        </svg>
                                    </div>
                                @else
                                    <div aria-hidden="true" class="h-7 w-10 rounded-md border border-white/35 shadow-inner {{ $gayaBank['chip_gaya'] === 'perak' ? 'bg-gradient-to-br from-slate-100 via-slate-300 to-slate-400' : 'bg-gradient-to-br from-[#F9E7A8] via-[#D4AF37] to-[#9A7422]' }}"></div>
                                @endif
                            </div>

                            <div class="relative z-10 mt-5">
                                <p class="font-mono text-lg sm:text-xl font-bold tracking-[0.14em] text-white drop-shadow-xs">
                                    {{ $nomorTerformat }}
                                </p>
                                <p class="mt-1 text-xs text-white/85">a.n. {{ $amplop->atas_nama }}</p>
                            </div>

                            <div class="relative z-10 mt-4 pt-3 border-t border-white/15 flex items-center justify-between gap-2">
                                <span class="text-[10px] font-medium text-white/75 truncate">{{ $amplop->nama_bank }}</span>
                                <button
                                    type="button"
                                    @click="salinRekening(@js($amplop->nomor_rekening), {{ $idKartuAmplop }})"
                                    class="inline-flex items-center gap-1.5 rounded-full bg-[#091322]/55 hover:bg-[#D9B664] border border-[#F3E5AB]/45 hover:border-[#F3E5AB] hover:text-[#091322] px-3.5 py-1.5 text-[11px] font-semibold text-[#FFFDF8] transition cursor-pointer shrink-0"
                                >
                                    <svg x-show="rekeningTersalin !== {{ $idKartuAmplop }}" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <rect width="14" height="14" x="8" y="8" rx="2" ry="2"/>
                                        <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>
                                    </svg>
                                    <svg x-show="rekeningTersalin === {{ $idKartuAmplop }}" x-cloak class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M20 6 9 17l-5-5"/>
                                    </svg>
                                    <span x-text="rekeningTersalin === {{ $idKartuAmplop }} ? 'Berhasil Disalin!' : 'Salin Nomor'"></span>
                                </button>
                            </div>
                        </div>
                    @endforeach

                    @if ($alamatKado !== '')
                        <div x-data="{ alamatTersalin: false }" class="rounded-2xl bg-[#091322]/80 border border-dashed border-[#D9B664]/55 p-4 text-center space-y-2">
                            <p class="text-[10px] font-bold uppercase tracking-[0.28em] text-[#D9B664]">Alamat Kirim Kado</p>
                            <p class="text-xs sm:text-[13px] text-[#E6EEF8]/88 leading-relaxed">{{ $alamatKado }}</p>
                            <button
                                type="button"
                                @click="navigator.clipboard?.writeText(@js($alamatKado)); alamatTersalin = true; setTimeout(() => alamatTersalin = false, 2200)"
                                class="celestial-tombol-emas inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-[11px] font-bold uppercase tracking-wider transition active:scale-95 cursor-pointer"
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

{{-- SEKSI 10: RSVP & WISHES (OBSERVATORIUM MALAM SAFIR) --}}
@if ($undangan->fiturAktif('buku_tamu'))
    <section id="buku-tamu" class="relative bg-gradient-to-b from-[#0B1728] via-[#091322] to-[#0B1728] py-14 px-5 overflow-hidden">
        <div class="max-w-md mx-auto">
            <div class="text-center space-y-2">
                <img src="{{ $asetCelestial['sabit'] }}" alt="" loading="lazy" decoding="async" data-gsap="turun" class="w-10 mx-auto drop-shadow-lg">
                <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.36em] text-[#D9B664]">Untaian Doa</p>
                <h2 data-gsap="mekar" class="font-serif text-4xl sm:text-5xl font-bold uppercase tracking-[0.12em] text-[#F3E5AB] leading-tight">
                    RSVP &amp; Wishes
                </h2>
                <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs text-[#E6EEF8]/80 max-w-xs mx-auto leading-relaxed">
                    Kami mempersilakan Bapak/Ibu/Saudara/i menyampaikan ucapan, doa terbaik, serta konfirmasi kehadiran.
                </p>
                <div data-gsap="garis" aria-hidden="true" class="mx-auto w-24 h-px bg-[#D9B664]/55 pt-1"></div>
            </div>

            <div data-gsap="naik" class="mt-7 rounded-[22px] bg-gradient-to-b from-[#13243B] to-[#0D1B2E] border border-[#D9B664]/60 p-5 sm:p-6 shadow-[0_24px_52px_-16px_rgba(0,0,0,0.82)] space-y-5 kartu-3d">
                @if (session('sukses_ucapan'))
                    <div data-swal-success="{{ session('sukses_ucapan') }}" hidden aria-hidden="true"></div>
                @endif

                @if ($errors->any())
                    <div data-swal-errors="{{ json_encode($errors->all(), JSON_UNESCAPED_UNICODE) }}" hidden aria-hidden="true"></div>
                @endif

                @if (! empty($modeDemo))
                    <div x-data="bukuTamuDemo(@js($daftarUcapanAwal), @js($namaTamu))" class="space-y-5">
                        <form @submit.prevent="kirimUcapanDemo()" class="space-y-3.5 text-left">
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D9B664]">Nama Tamu</label>
                                <input
                                    type="text"
                                    x-model="namaTamu"
                                    required
                                    placeholder="Masukkan nama Anda"
                                    class="mt-1 w-full rounded-xl border border-[#D9B664]/45 bg-[#091322] px-3.5 py-2.5 text-sm text-white focus:border-[#F3E5AB] focus:outline-none"
                                >
                            </div>
                            <div class="grid gap-3" :class="statusKehadiran === 'hadir' ? 'grid-cols-2' : 'grid-cols-1'">
                                <div>
                                    <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D9B664]">Kehadiran</label>
                                    <select
                                        x-ref="selectKehadiran"
                                        x-model="statusKehadiran"
                                        @change="statusKehadiran = $event.target.value"
                                        class="mt-1 w-full rounded-xl border border-[#D9B664]/45 bg-[#091322] px-3 py-2.5 text-sm text-white"
                                    >
                                        <option value="hadir">InsyaAllah Hadir</option>
                                        <option value="ragu">Masih Ragu</option>
                                        <option value="tidak_hadir">Berhalangan</option>
                                    </select>
                                </div>
                                <div x-show="statusKehadiran === 'hadir'" x-cloak>
                                    <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D9B664]">Jumlah</label>
                                    <input
                                        type="number"
                                        x-model.number="jumlahTamu"
                                        min="1"
                                        max="20"
                                        :required="statusKehadiran === 'hadir'"
                                        :disabled="statusKehadiran !== 'hadir'"
                                        class="mt-1 w-full rounded-xl border border-[#D9B664]/45 bg-[#091322] px-3.5 py-2.5 text-sm text-white"
                                    >
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D9B664]">Ucapan &amp; Doa</label>
                                <textarea
                                    x-model="ucapanDoa"
                                    rows="3"
                                    required
                                    placeholder="Tuliskan doa terbaik untuk mempelai..."
                                    class="mt-1 w-full rounded-xl border border-[#D9B664]/45 bg-[#091322] px-3.5 py-2.5 text-sm text-white focus:border-[#F3E5AB] focus:outline-none"
                                ></textarea>
                            </div>
                            <button
                                type="submit"
                                class="celestial-tombol-emas w-full rounded-full py-3 text-xs font-bold uppercase tracking-wider transition cursor-pointer"
                            >
                                Kirim Konfirmasi &amp; Doa
                            </button>
                            <p x-show="pesanGalat" x-cloak x-text="pesanGalat" class="text-xs font-semibold text-rose-300 text-center"></p>
                            <p
                                x-show="pesanSukses"
                                x-cloak
                                x-text="pesanSukses"
                                class="rounded-xl bg-emerald-950/70 border border-emerald-400/40 px-3 py-2 text-[11px] font-semibold text-emerald-200 text-center"
                            ></p>
                        </form>

                        <div class="pt-4 border-t border-[#D9B664]/25 space-y-3">
                            <div class="flex items-center justify-between gap-2">
                                <h3 class="font-serif text-base font-bold text-[#F3E5AB]">
                                    Doa &amp; Ucapan (<span x-text="daftarUcapan.length">{{ count($daftarUcapanAwal) }}</span>)
                                </h3>
                                <span class="text-[10px] uppercase tracking-wider text-[#D9B664]/80">Gulir untuk lainnya</span>
                            </div>
                            <div x-ref="daftarUcapanScroll" data-lenis-prevent class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                                <template x-for="ucapan in daftarUcapan" :key="ucapan.id">
                                    <div
                                        class="rounded-2xl bg-[#091322]/78 border border-l-[3px] border-l-[#D9B664] p-3.5 space-y-1.5 transition"
                                        :class="ucapan.baru ? 'border-[#F3E5AB]/70 ring-1 ring-[#D9B664]/45' : 'border-[#D9B664]/25'"
                                    >
                                        <div class="flex items-center justify-between gap-2">
                                            <p class="font-bold text-xs text-[#F3E5AB]" x-text="ucapan.nama_tamu"></p>
                                            <span
                                                class="shrink-0 rounded-full px-2.5 py-0.5 text-[10px] font-semibold"
                                                :class="kelasStatus(ucapan.status_kehadiran, true, 'bg-[#D9B664]/15 text-[#D9B664]')"
                                                x-text="labelStatus(ucapan.status_kehadiran)"
                                            ></span>
                                        </div>
                                        <p class="text-xs text-[#E6EEF8]/85 leading-relaxed" x-text="ucapan.ucapan_doa"></p>
                                        <p class="text-[10px] text-[#D9B664]/70" x-text="ucapan.waktu"></p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                @else
                    @if (! empty($modePratinjau) || ! $undangan->sudahAktifPublik())
                        <div class="rounded-2xl bg-[#091322]/75 border border-[#D9B664]/35 px-4 py-3 text-center text-xs font-semibold text-[#F3E5AB]">
                            Mode Pratinjau — Buku Tamu &amp; RSVP Dikunci
                        </div>
                    @else
                        <form
                            x-data="{ statusKehadiran: @js(old('status_kehadiran', 'hadir')) }"
                            method="POST"
                            action="{{ route('undangan.ucapan', $undangan->slug) }}"
                            class="space-y-3.5 text-left"
                        >
                            @csrf
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D9B664]">Nama Tamu</label>
                                <input
                                    type="text"
                                    name="nama_tamu"
                                    value="{{ old('nama_tamu', $namaTamu !== 'Tamu Undangan' ? $namaTamu : '') }}"
                                    required
                                    class="mt-1 w-full rounded-xl border border-[#D9B664]/45 bg-[#091322] px-3.5 py-2.5 text-sm text-white"
                                >
                            </div>
                            <div class="grid gap-3" :class="statusKehadiran === 'hadir' ? 'grid-cols-2' : 'grid-cols-1'">
                                <div>
                                    <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D9B664]">Kehadiran</label>
                                    <select
                                        name="status_kehadiran"
                                        x-model="statusKehadiran"
                                        @change="statusKehadiran = $event.target.value"
                                        class="mt-1 w-full rounded-xl border border-[#D9B664]/45 bg-[#091322] px-3 py-2.5 text-sm text-white"
                                    >
                                        <option value="hadir" @selected(old('status_kehadiran', 'hadir') === 'hadir')>InsyaAllah Hadir</option>
                                        <option value="ragu" @selected(old('status_kehadiran') === 'ragu')>Masih Ragu</option>
                                        <option value="tidak_hadir" @selected(old('status_kehadiran') === 'tidak_hadir')>Berhalangan</option>
                                    </select>
                                </div>
                                <div x-show="statusKehadiran === 'hadir'" x-cloak>
                                    <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D9B664]">Jumlah</label>
                                    <input
                                        type="number"
                                        name="jumlah_tamu"
                                        value="{{ old('jumlah_tamu', 1) }}"
                                        min="1"
                                        max="20"
                                        :required="statusKehadiran === 'hadir'"
                                        :disabled="statusKehadiran !== 'hadir'"
                                        class="mt-1 w-full rounded-xl border border-[#D9B664]/45 bg-[#091322] px-3.5 py-2.5 text-sm text-white"
                                    >
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D9B664]">Ucapan &amp; Doa</label>
                                <textarea
                                    name="ucapan_doa"
                                    rows="3"
                                    required
                                    placeholder="Tuliskan doa terbaik untuk mempelai..."
                                    class="mt-1 w-full rounded-xl border border-[#D9B664]/45 bg-[#091322] px-3.5 py-2.5 text-sm text-white"
                                >{{ old('ucapan_doa') }}</textarea>
                            </div>
                            <button
                                type="submit"
                                class="celestial-tombol-emas w-full rounded-full py-3 text-xs font-bold uppercase tracking-wider transition cursor-pointer"
                            >
                                Kirim Konfirmasi &amp; Doa
                            </button>
                        </form>
                    @endif

                    <div class="pt-4 border-t border-[#D9B664]/25 space-y-3">
                        <h3 class="font-serif text-base font-bold text-[#F3E5AB]">
                            Doa &amp; Ucapan ({{ $undangan->bukuTamu->count() }})
                        </h3>
                        <div data-lenis-prevent class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                            @forelse ($undangan->bukuTamu as $ucapan)
                                <div class="rounded-2xl bg-[#091322]/75 border border-[#D9B664]/25 border-l-[3px] border-l-[#D9B664] p-3.5 space-y-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="font-bold text-xs text-[#F3E5AB]">{{ $ucapan->nama_tamu }}</p>
                                        <span class="rounded-full bg-[#D9B664]/15 px-2.5 py-0.5 text-[10px] font-semibold text-[#D9B664]">
                                            {{ str_replace('_', ' ', ucfirst($ucapan->status_kehadiran)) }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-[#E6EEF8]/85 leading-relaxed">{{ $ucapan->ucapan_doa }}</p>
                                </div>
                            @empty
                                <p class="text-xs text-[#E6EEF8]/60 text-center">Jadilah yang pertama menuliskan doa restu.</p>
                            @endforelse
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif

{{-- SEKSI 11: DOA UNTUK PENGANTIN & TURUT MENGUNDANG --}}
<section class="relative bg-[#091322] celestial-pola-bintang px-4 py-12 space-y-6 overflow-hidden">
    {{-- Kartu Doa Untuk Pengantin --}}
    <div data-section-doa-pengantin="celestial" class="relative max-w-md mx-auto rounded-[1.85rem] border border-[#D9B664]/65 bg-gradient-to-b from-[#14263E] via-[#102036] to-[#0B1626] px-6 py-9 text-center shadow-[0_22px_48px_-16px_rgba(0,0,0,0.8)] space-y-4 kartu-3d">
        <span aria-hidden="true" class="pointer-events-none absolute top-3 left-3 h-3.5 w-3.5 border-t border-l border-[#D9B664]/65"></span>
        <span aria-hidden="true" class="pointer-events-none absolute top-3 right-3 h-3.5 w-3.5 border-t border-r border-[#D9B664]/65"></span>
        <span aria-hidden="true" class="pointer-events-none absolute bottom-3 left-3 h-3.5 w-3.5 border-b border-l border-[#D9B664]/65"></span>
        <span aria-hidden="true" class="pointer-events-none absolute bottom-3 right-3 h-3.5 w-3.5 border-b border-r border-[#D9B664]/65"></span>

        <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#D9B664]">Doa Keberkahan</p>
        <h2 data-gsap="naik" class="font-serif text-2xl sm:text-3xl font-bold uppercase tracking-[0.1em] text-[#F3E5AB]">
            Doa Untuk Pengantin
        </h2>
        <p data-gsap="mekar" data-gsap-delay="0.06" class="text-xl sm:text-2xl leading-loose text-[#F3E5AB]" style="font-family: 'Amiri', serif;" dir="rtl">
            بَارَكَ اللّٰهُ لَكَ وَبَارَكَ عَلَيْكَ وَجَمَعَ بَيْنَكُمَا فِي خَيْرٍ
        </p>
        <p data-gsap="teks" data-gsap-delay="0.08" class="text-xs italic text-[#D9B664]">
            &ldquo;Baarakallahu laka wa baaraka &lsquo;alaika wa jama&lsquo;a bainakuma fii khair.&rdquo;
        </p>
        <p data-gsap="teks" data-gsap-delay="0.10" class="text-xs sm:text-sm text-[#E6EEF8]/85 leading-relaxed">
            Semoga Allah memberkahimu di waktu bahagia dan memberkahimu di waktu susah, serta semoga Allah mempersatukan kalian berdua dalam kebaikan. <span class="font-semibold text-[#F3E5AB]">(HR. Abu Daud)</span>
        </p>
    </div>

    {{-- Kartu Turut Mengundang (Opsional) --}}
    @if ($adaTurutMengundang)
        <div data-section-turut-mengundang="celestial" class="max-w-md mx-auto rounded-[1.85rem] bg-[#102036] border border-[#D9B664]/50 p-6 text-center shadow-xl space-y-4 kartu-3d">
            <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#D9B664]">Keluarga Besar</p>
            <h2 data-gsap="naik" class="font-serif text-2xl font-bold text-[#F3E5AB]">Turut Mengundang</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 text-xs">
                @if (! empty($turutPria))
                    <div data-gsap="kiri" class="rounded-2xl bg-[#091322]/78 border border-[#D9B664]/35 p-3.5 space-y-1">
                        <p class="font-bold uppercase tracking-wider text-[#D9B664] text-[10px]">
                            Pihak {{ $undangan->nama_panggilan_pria }}
                        </p>
                        @foreach ($turutPria as $baris)
                            <p class="text-[#E6EEF8]/88">{{ $baris }}</p>
                        @endforeach
                    </div>
                @endif
                @if (! empty($turutWanita))
                    <div data-gsap="kanan" data-gsap-delay="0.06" class="rounded-2xl bg-[#091322]/78 border border-[#D9B664]/35 p-3.5 space-y-1">
                        <p class="font-bold uppercase tracking-wider text-[#D9B664] text-[10px]">
                            Pihak {{ $undangan->nama_panggilan_wanita }}
                        </p>
                        @foreach ($turutWanita as $baris)
                            <p class="text-[#E6EEF8]/88">{{ $baris }}</p>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif
</section>

{{-- SEKSI 12: KUBAH PENUTUP CELESTIAL & FOOTER --}}
<section data-layout-penutup="celestial" class="relative bg-[#091322] px-4 pt-4 pb-14 overflow-hidden">
    <div class="relative z-10 max-w-md mx-auto rounded-t-[10.5rem] rounded-b-[2rem] bg-gradient-to-b from-[#152842] via-[#102036] to-[#0A1525] border-2 border-[#D9B664]/75 shadow-[0_26px_58px_-16px_rgba(0,0,0,0.85)] overflow-hidden kartu-3d">
        {{-- Potret Penutup Besar Mengisi Lengkungan Kubah Penuh --}}
        @if ($urlFotoPenutup)
            <div data-gsap="potret" class="relative p-2.5 sm:p-3 pb-0">
                <div class="relative overflow-hidden rounded-t-[9.6rem] rounded-b-[1.35rem] border border-[#F3E5AB]/55 bg-[#07101E] shadow-[0_18px_38px_-12px_rgba(0,0,0,0.8)]">
                    <img
                        src="{{ $urlFotoPenutup }}"
                        alt="Foto Penutup {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                        loading="lazy"
                        decoding="async"
                        class="w-full h-[21rem] sm:h-[23rem] object-cover object-top"
                    >
                    <div
                        aria-hidden="true"
                        class="pointer-events-none absolute inset-0"
                        style="background: linear-gradient(180deg, rgba(7,16,30,0.08) 0%, rgba(7,16,30,0) 46%, rgba(16,32,54,0.52) 82%, rgba(16,32,54,0.95) 100%);"
                    ></div>
                </div>
            </div>
        @else
            <div data-gsap="potret" class="pt-14 pb-2 flex justify-center">
                <div class="relative w-36 h-36 rounded-full border border-dashed border-[#D9B664]/65 flex items-center justify-center">
                    <div class="w-28 h-28 rounded-full border-2 border-[#D9B664]/80 bg-gradient-to-b from-[#18304F] to-[#091322] flex items-center justify-center shadow-xl">
                        <span class="font-serif text-3xl font-bold text-[#F3E5AB] tracking-wider">
                            {{ $undangan->inisialPria() }} &amp; {{ $undangan->inisialWanita() }}
                        </span>
                    </div>
                </div>
            </div>
        @endif

        {{-- Medali Bulan Sabit & Panel Terima Kasih Celestial --}}
        <div class="relative z-10 px-6 {{ $urlFotoPenutup ? '-mt-7 pt-0' : 'pt-4' }} pb-10 text-center space-y-4">
            <span aria-hidden="true" class="pointer-events-none absolute bottom-3 left-3 h-4 w-4 border-b border-l border-[#D9B664]/55 rounded-bl-md"></span>
            <span aria-hidden="true" class="pointer-events-none absolute bottom-3 right-3 h-4 w-4 border-b border-r border-[#D9B664]/55 rounded-br-md"></span>

            <div data-gsap="mekar" class="mx-auto inline-flex items-center justify-center rounded-full bg-[#0E1D32] border border-[#D9B664]/75 px-3.5 py-2 shadow-[0_10px_22px_rgba(0,0,0,0.72)]">
                <img src="{{ $asetCelestial['sabit'] }}" alt="" loading="lazy" decoding="async" class="w-8 opacity-95">
            </div>

            <div data-gsap="turun" class="flex items-center justify-center gap-2.5 pt-0.5">
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-r from-transparent to-[#D9B664]/70"></span>
                <span aria-hidden="true" class="text-[9px] text-[#F3E5AB]">&#10022;</span>
                <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#D9B664]">Jazakumullahu Khairan</p>
                <span aria-hidden="true" class="text-[9px] text-[#F3E5AB]">&#10022;</span>
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-l from-transparent to-[#D9B664]/70"></span>
            </div>

            <p data-gsap="teks" class="text-xs sm:text-[13px] text-[#E6EEF8]/88 leading-relaxed max-w-xs mx-auto">
                Atas kehadiran dan doa restu Bapak/Ibu/Saudara/i, kami ucapkan terima kasih. Wassalamu&rsquo;alaikum Warahmatullahi Wabarakatuh.
            </p>

            <div data-gsap="garis" class="flex items-center justify-center gap-3 px-10 pt-1" aria-hidden="true">
                <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#D9B664]/45"></span>
                <span class="text-[8px] text-[#F3E5AB]">&#10022;</span>
                <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#D9B664]/45"></span>
            </div>

            <div class="pt-0.5 space-y-1.5">
                <p data-gsap="naik" class="text-[10px] font-semibold uppercase tracking-[0.28em] text-[#D9B664]/85">
                    Kami Yang Berbahagia
                </p>
                <p data-gsap="mekar" data-gsap-delay="0.06" class="font-kaligrafi text-[2.8rem] sm:text-5xl text-[#F3E5AB] leading-[1.12] drop-shadow-[0_3px_12px_rgba(0,0,0,0.65)]">
                    {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
                </p>
                <p data-gsap="naik" data-gsap-delay="0.10" class="inline-block rounded-full border border-[#D9B664]/40 bg-[#091322]/75 px-3.5 py-1 text-[10px] font-medium uppercase tracking-[0.22em] text-[#E6EEF8]/88">
                    {{ $hashtagPasangan }}
                </p>
            </div>
        </div>
    </div>
</section>

@include('komponen-undangan.footer-tema', [
    'gelap' => true,
    'warnaOrnamen' => '#D9B664',
    'kelasLatar' => 'bg-gradient-to-b from-[#0A1628] via-[#07101E] to-[#040A13] border-t border-[#D9B664]/40',
    'kelasTeks' => 'text-[#E6EEF8]/82',
    'kelasAksen' => 'text-[#F3E5AB]',
    'kelasTombol' =>
        'bg-white/8 text-[#F3E5AB] border border-[#D9B664]/45 hover:-translate-y-0.5 hover:bg-[#D9B664] hover:text-[#060D18]',
])
