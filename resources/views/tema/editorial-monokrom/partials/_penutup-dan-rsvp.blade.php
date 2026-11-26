{{-- SEKSI 9: 05 / TANDA KASIH — FOLD-OUT PRIVATE BLACK-CARD VAULT (BUKA AMPLOP DIGITAL) --}}
@if ($undangan->fiturAktif('amplop_digital') && ($undangan->daftarAmplop->isNotEmpty() || $alamatKado !== ''))
    <section data-layout-amplop class="relative bg-[#FAF9F6] px-5 pt-4 pb-7 overflow-x-clip">
        <div class="max-w-md mx-auto space-y-5">
            <div data-masthead-lengket
                class="sticky {{ $tampilBarDemo ? 'top-14' : 'top-0' }} z-30 -mx-5 px-5 py-3 bg-[#FAF9F6]/95 backdrop-blur-md ed-mono flex items-center justify-between border-b border-[#18181B] text-[9.5px] font-bold uppercase tracking-[0.3em] text-[#18181B]">
                <span>05 / TANDA KASIH</span>
                <span>DIGITAL VAULT</span>
            </div>

            <div class="bg-white border border-[#18181B] p-6 text-left space-y-5 ed-bayangan-tajam kartu-3d">
                <div class="border-b border-[#18181B]/20 pb-3.5 space-y-1">
                    <h2 data-gsap="naik" data-gsap-delay="0.05"
                        class="ed-serif text-3xl uppercase tracking-wide text-[#18181B]">
                        {{ $undangan->teksKustom('judul_amplop', 'Amplop Digital') }}</h2>
                </div>

                <p data-gsap="teks" data-gsap-delay="0.08" class="text-xs text-[#52525B] leading-relaxed">
                    {{ $undangan->teksKustom('pengantar_amplop', 'Doa restu Bapak/Ibu/Saudara/i merupakan karunia terindah bagi kami. Namun apabila bermaksud memberikan tanda kasih secara digital, dapat melalui akses di bawah ini:') }}
                </p>

                <div>
                    <button type="button" @click="amplopTerbuka = !amplopTerbuka; window.SesiTemuSinema?.refresh(80)"
                        :aria-expanded="amplopTerbuka.toString()"
                        class="ed-btn-invert w-full inline-flex items-center justify-between gap-2 bg-[#18181B] text-[#FAF9F6] px-4 py-3 text-[11px] font-bold uppercase tracking-[0.24em] hover:bg-black transition cursor-pointer">
                        <span class="inline-flex items-center gap-2.5">
                            <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="20" height="16" x="2" y="4" rx="1" />
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                            </svg>
                            <span x-text="amplopTerbuka ? 'Tutup Amplop Digital' : 'Buka Amplop Digital'">Buka Amplop
                                Digital</span>
                        </span>
                        <svg class="w-4 h-4 shrink-0 transition-transform duration-300"
                            :class="amplopTerbuka ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
                            aria-hidden="true">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                    </button>
                </div>

                <div x-show="amplopTerbuka" x-cloak x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0" class="space-y-3.5 pt-1">
                    @foreach ($undangan->daftarAmplop as $amplop)
                        <div
                            class="relative bg-[#111114] text-white border border-[#18181B] p-5 space-y-4 overflow-hidden">
                            <div aria-hidden="true"
                                class="pointer-events-none absolute inset-0 ed-film-grain opacity-30"></div>

                            <div class="relative z-10 flex items-center justify-between">
                                <span
                                    class="ed-mono text-[10px] font-bold uppercase tracking-[0.26em] text-white">{{ $amplop->nama_bank }}</span>
                                {{-- Ornamen Chip Kartu Titanium Minimalis --}}
                                <span aria-hidden="true"
                                    class="inline-grid grid-cols-2 gap-[2px] w-7 h-5 border border-white/45 p-[2px]">
                                    <span class="border border-white/25"></span>
                                    <span class="border border-white/25"></span>
                                    <span class="border border-white/25"></span>
                                    <span class="border border-white/25"></span>
                                </span>
                            </div>

                            <div class="relative z-10 space-y-0.5">
                                <p class="ed-mono text-base sm:text-lg font-bold tracking-[0.16em] text-white">
                                    {{ $amplop->nomor_rekening }}</p>
                                <p class="ed-mono text-[10px] uppercase tracking-[0.18em] text-white/70">A/N
                                    {{ $amplop->atas_nama }}</p>
                            </div>

                            <button type="button"
                                @click="salinRekening(@js($amplop->nomor_rekening), {{ $amplop->id ?? $loop->iteration }})"
                                class="relative z-10 w-full bg-[#FAF9F6] text-[#18181B] py-2.5 text-[10.5px] font-bold uppercase tracking-[0.22em] hover:bg-white transition cursor-pointer">
                                <span
                                    x-text="rekeningTersalin === {{ $amplop->id ?? $loop->iteration }} ? 'Berhasil Disalin!' : 'Salin Nomor Rekening'">Salin
                                    Nomor Rekening</span>
                            </button>
                        </div>
                    @endforeach

                    @if ($alamatKado !== '')
                        <div class="border border-[#18181B] bg-[#FAF9F6] p-4 space-y-1.5">
                            <p class="ed-mono text-[9.5px] font-bold uppercase tracking-[0.26em] text-[#18181B]">GIFT
                                SHIPPING ADDRESS</p>
                            <p class="text-xs text-[#52525B] leading-relaxed">{{ $alamatKado }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endif

{{-- SEKSI 10: 06 / ATTENDANCE — ARCHITECTURAL EDITORIAL RSVP --}}
    <section id="buku-tamu" class="relative bg-[#FAF9F6] px-5 pt-4 pb-7 overflow-x-clip">
        <div class="max-w-md mx-auto space-y-5">
            <div data-masthead-lengket
                class="sticky {{ $tampilBarDemo ? 'top-14' : 'top-0' }} z-30 -mx-5 px-5 py-3 bg-[#FAF9F6]/95 backdrop-blur-md ed-mono flex items-center justify-between border-b border-[#18181B] text-[9.5px] font-bold uppercase tracking-[0.3em] text-[#18181B]">
                <span>06 / ATTENDANCE</span>
                <span>GUESTBOOK</span>
            </div>

            <div class="bg-white border border-[#18181B] p-6 text-left space-y-5 ed-bayangan-tajam">
                <div class="border-b border-[#18181B]/20 pb-3.5 space-y-1">
                    <h2 data-gsap="mekar" data-gsap-delay="0.06"
                        class="ed-serif text-3xl uppercase tracking-wide text-[#18181B]">
                        {{ $undangan->teksKustom('judul_buku_tamu', 'RSVP & Notes') }}</h2>
                </div>

                @if (!empty($modeDemo))
                    <div x-data="bukuTamuDemo(@js($daftarUcapanAwal), @js($namaTamu))" class="space-y-5">
                        <form @submit.prevent="kirimUcapanDemo()" class="space-y-3.5">
                            <div>
                                <label
                                    class="ed-mono block text-[9.5px] font-bold uppercase tracking-[0.24em] text-[#52525B]">Nama
                                    Tamu</label>
                                <input type="text" x-model="namaTamu" required placeholder="Masukkan nama Anda"
                                    class="mt-1 w-full rounded-none border border-[#18181B]/45 bg-[#FAF9F6] px-3.5 py-2.5 text-sm focus:border-[#18181B] focus:bg-white focus:outline-none">
                            </div>
                            <div class="grid gap-3"
                                :class="statusKehadiran === 'hadir' ? 'grid-cols-2' : 'grid-cols-1'">
                                <div>
                                    <label
                                        class="ed-mono block text-[9.5px] font-bold uppercase tracking-[0.24em] text-[#52525B]">Kehadiran</label>
                                    <select x-ref="selectKehadiran" x-model="statusKehadiran"
                                        @change="statusKehadiran = $event.target.value"
                                        class="mt-1 w-full rounded-none border border-[#18181B]/45 bg-[#FAF9F6] px-3 py-2.5 text-sm">
                                        <option value="hadir">Hadir</option>
                                        <option value="ragu">Masih Ragu</option>
                                        <option value="tidak_hadir">Berhalangan</option>
                                    </select>
                                </div>
                                <div x-show="statusKehadiran === 'hadir'" x-cloak>
                                    <label
                                        class="ed-mono block text-[9.5px] font-bold uppercase tracking-[0.24em] text-[#52525B]">Jumlah</label>
                                    <input type="number" x-model.number="jumlahTamu" min="1" max="20"
                                        :required="statusKehadiran === 'hadir'"
                                        :disabled="statusKehadiran !== 'hadir'"
                                        class="mt-1 w-full rounded-none border border-[#18181B]/45 bg-[#FAF9F6] px-3.5 py-2.5 text-sm">
                                </div>
                            </div>
                            <div>
                                <label
                                    class="ed-mono block text-[9.5px] font-bold uppercase tracking-[0.24em] text-[#52525B]">Ucapan
                                    &amp; Doa</label>
                                <textarea x-model="ucapanDoa" rows="3" required placeholder="Tuliskan doa & harapan terbaik..."
                                    class="mt-1 w-full rounded-none border border-[#18181B]/45 bg-[#FAF9F6] px-3.5 py-2.5 text-sm focus:border-[#18181B] focus:bg-white focus:outline-none"></textarea>
                            </div>
                            <button type="submit"
                                class="ed-btn-invert w-full rounded-none bg-[#18181B] text-white py-3 text-[11px] font-bold uppercase tracking-[0.26em] hover:bg-black transition cursor-pointer">
                                Kirim Konfirmasi &amp; Doa &rarr;
                            </button>
                            <p x-show="pesanGalat" x-cloak x-text="pesanGalat"
                                class="text-xs font-semibold text-rose-700"></p>
                            <p x-show="pesanSukses" x-cloak x-text="pesanSukses"
                                class="rounded-none border border-[#18181B] bg-[#FAF9F6] px-3 py-2 text-[11px] font-semibold text-[#18181B]">
                            </p>
                        </form>

                        <div class="pt-4 border-t border-[#18181B]/20 space-y-3">
                            <div class="flex items-center justify-between gap-2">
                                <h3 class="ed-mono text-[10px] font-bold uppercase tracking-[0.24em] text-[#18181B]">
                                    GUEST ARCHIVE (<span
                                        x-text="daftarUcapan.length">{{ count($daftarUcapanAwal) }}</span>)
                                </h3>
                                <span class="ed-mono text-[8.5px] uppercase tracking-[0.22em] text-[#52525B]">SCROLL
                                    &darr;</span>
                            </div>
                            <div x-ref="daftarUcapanScroll" data-lenis-prevent
                                class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                                <template x-for="ucapan in daftarUcapan" :key="ucapan.id">
                                    <div class="rounded-none border bg-[#FAF9F6] p-3.5 space-y-1.5 transition"
                                        :class="ucapan.baru ? 'border-[#18181B]' : 'border-[#18181B]/20'">
                                        <div class="flex items-center justify-between gap-2">
                                            <p class="font-bold text-xs text-[#18181B]" x-text="ucapan.nama_tamu"></p>
                                            <span
                                                class="ed-mono shrink-0 rounded-none px-2 py-0.5 text-[8.5px] font-bold uppercase tracking-wider"
                                                :class="kelasStatus(ucapan.status_kehadiran, false,
                                                    'border border-[#18181B]/35 text-[#18181B]')"
                                                x-text="labelStatus(ucapan.status_kehadiran)"></span>
                                        </div>
                                        <p class="text-xs text-[#52525B] leading-relaxed" x-text="ucapan.ucapan_doa">
                                        </p>
                                        <p class="ed-mono text-[9px] uppercase tracking-wider text-[#52525B]/75"
                                            x-text="ucapan.waktu"></p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                @else
                    @if (!empty($modePratinjau) || !$undangan->sudahAktifPublik())
                        <div
                            class="border border-[#18181B] bg-[#FAF9F6] px-4 py-3 text-xs font-semibold text-[#18181B]">
                            Mode Pratinjau — Buku Tamu &amp; RSVP Dikunci
                        </div>
                    @else
                        <form x-data="{ statusKehadiran: @js(old('status_kehadiran', 'hadir')) }" method="POST"
                            action="{{ route('undangan.ucapan', $undangan->slug) }}" class="space-y-3.5">
                            @csrf
                            <div>
                                <label
                                    class="ed-mono block text-[9.5px] font-bold uppercase tracking-[0.24em] text-[#52525B]">Nama
                                    Tamu</label>
                                <input type="text" name="nama_tamu"
                                    value="{{ old('nama_tamu', $namaTamu !== 'Tamu Undangan' ? $namaTamu : '') }}"
                                    required
                                    class="mt-1 w-full rounded-none border border-[#18181B]/45 bg-[#FAF9F6] px-3.5 py-2.5 text-sm focus:border-[#18181B] focus:bg-white focus:outline-none">
                            </div>
                            <div class="grid gap-3"
                                :class="statusKehadiran === 'hadir' ? 'grid-cols-2' : 'grid-cols-1'">
                                <div>
                                    <label
                                        class="ed-mono block text-[9.5px] font-bold uppercase tracking-[0.24em] text-[#52525B]">Kehadiran</label>
                                    <select name="status_kehadiran" x-model="statusKehadiran"
                                        @change="statusKehadiran = $event.target.value"
                                        class="mt-1 w-full rounded-none border border-[#18181B]/45 bg-[#FAF9F6] px-3 py-2.5 text-sm">
                                        <option value="hadir" @selected(old('status_kehadiran', 'hadir') === 'hadir')>Hadir</option>
                                        <option value="ragu" @selected(old('status_kehadiran') === 'ragu')>Masih Ragu</option>
                                        <option value="tidak_hadir" @selected(old('status_kehadiran') === 'tidak_hadir')>Berhalangan</option>
                                    </select>
                                </div>
                                <div x-show="statusKehadiran === 'hadir'" x-cloak>
                                    <label
                                        class="ed-mono block text-[9.5px] font-bold uppercase tracking-[0.24em] text-[#52525B]">Jumlah</label>
                                    <input type="number" name="jumlah_tamu" value="{{ old('jumlah_tamu', 1) }}"
                                        min="1" max="20" :required="statusKehadiran === 'hadir'"
                                        :disabled="statusKehadiran !== 'hadir'"
                                        class="mt-1 w-full rounded-none border border-[#18181B]/45 bg-[#FAF9F6] px-3.5 py-2.5 text-sm">
                                </div>
                            </div>
                            <div>
                                <label
                                    class="ed-mono block text-[9.5px] font-bold uppercase tracking-[0.24em] text-[#52525B]">Ucapan
                                    &amp; Doa</label>
                                <textarea name="ucapan_doa" rows="3" required placeholder="Tuliskan doa & harapan terbaik..."
                                    class="mt-1 w-full rounded-none border border-[#18181B]/45 bg-[#FAF9F6] px-3.5 py-2.5 text-sm focus:border-[#18181B] focus:bg-white focus:outline-none">{{ old('ucapan_doa') }}</textarea>
                            </div>
                            <button type="submit"
                                class="ed-btn-invert w-full rounded-none bg-[#18181B] text-white py-3 text-[11px] font-bold uppercase tracking-[0.26em] hover:bg-black transition cursor-pointer">
                                Kirim Konfirmasi &amp; Doa &rarr;
                            </button>
                        </form>
                    @endif

                    <div class="pt-4 border-t border-[#18181B]/20 space-y-3">
                        <h3 class="ed-mono text-[10px] font-bold uppercase tracking-[0.24em] text-[#18181B]">GUEST
                            ARCHIVE ({{ $undangan->bukuTamu->count() }})</h3>
                        <div data-lenis-prevent class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                            @forelse ($undangan->bukuTamu as $ucapan)
                                <div class="border border-[#18181B]/20 bg-[#FAF9F6] p-3.5 space-y-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="font-bold text-xs text-[#18181B]">{{ $ucapan->nama_tamu }}</p>
                                        <span
                                            class="ed-mono border border-[#18181B]/35 px-2 py-0.5 text-[8.5px] font-bold uppercase tracking-wider text-[#18181B]">
                                            {{ str_replace('_', ' ', ucfirst($ucapan->status_kehadiran)) }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-[#52525B] leading-relaxed">{{ $ucapan->ucapan_doa }}</p>
                                </div>
                            @empty
                                <p class="text-xs text-[#52525B]">Jadilah yang pertama memberikan ucapan.</p>
                            @endforelse
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

{{-- SEKSI 11: 07 / BLESSING & VOW + 08 / TURUT MENGUNDANG --}}
@if ($undangan->fiturAktif('doa_pengantin') || $adaTurutMengundang)
    <section class="relative bg-[#FAF9F6] px-5 pt-7 pb-14 space-y-7 overflow-hidden">
        @if ($undangan->fiturAktif('doa_pengantin'))
            @php
                $doaPengantin = $undangan->doaPengantin([
                    'judul' => 'Doa & Harapan',
                    'arab' => '',
                    'latin' =>
                        'May your home always be a quiet sanctuary of grace, patience, and enduring love — growing deeper with every passing season.',
                    'isi' =>
                        'Semoga cinta yang dipersatukan hari ini senantiasa dilimpahi keteduhan, keberkahan, kesetiaan, dan kebahagiaan dalam setiap langkah kehidupan bersama — hari ini, esok, dan selamanya.',
                ]);
            @endphp
            <div data-section-doa-pengantin="editorial"
                class="max-w-md mx-auto bg-white border border-[#18181B] p-2 ed-bayangan-tajam kartu-3d">
                <div class="border border-[#18181B]/25 px-6 py-7 text-center space-y-4">
                    <div data-gsap="turun"
                        class="ed-mono flex items-center justify-between text-[9px] font-bold uppercase tracking-[0.28em] text-[#52525B] border-b border-[#18181B]/15 pb-2.5">
                        <span>07 / BLESSING</span>
                        <span>DOA RESTU</span>
                    </div>

                    <img src="{{ $asetEditorial['bingkai'] }}" alt="" loading="lazy" decoding="async"
                        data-gsap="mekar" class="w-11 mx-auto opacity-85">

                    <h2 data-gsap="naik"
                        class="ed-serif text-2xl sm:text-[1.85rem] uppercase tracking-[0.08em] text-[#18181B]">
                        {{ $doaPengantin['judul'] }}
                    </h2>

                    @if ($doaPengantin['arab'] !== '')
                        <p data-gsap="mekar" data-gsap-delay="0.05" class="text-xl leading-loose text-[#18181B]"
                            style="font-family: 'Amiri', serif;" dir="rtl">
                            {{ $doaPengantin['arab'] }}
                        </p>
                    @endif

                    @if ($doaPengantin['latin'] !== '')
                        <p data-gsap="teks" data-gsap-delay="0.06"
                            class="ed-serif italic text-base sm:text-[1.06rem] leading-relaxed text-[#18181B]">
                            &ldquo;{{ $doaPengantin['latin'] }}&rdquo;
                        </p>
                    @endif

                    <div data-gsap="garis" class="flex items-center justify-center gap-3 px-10" aria-hidden="true">
                        <span class="h-px flex-1 bg-[#18181B]/25"></span>
                        <span class="w-1.5 h-1.5 bg-[#18181B]"></span>
                        <span class="h-px flex-1 bg-[#18181B]/25"></span>
                    </div>

                    <p data-gsap="teks" data-gsap-delay="0.1"
                        class="text-xs sm:text-[13px] text-[#52525B] leading-relaxed">
                        {{ $doaPengantin['isi'] }}
                    </p>

                    <p data-gsap="naik" data-gsap-delay="0.12"
                        class="pt-1 ed-mono text-[9px] font-bold uppercase tracking-[0.3em] text-[#18181B]/80">
                        {{ $undangan->inisialPria() }} / {{ $undangan->inisialWanita() }} &middot; FOREVER &amp;
                        ALWAYS
                    </p>
                </div>
            </div>
        @endif

        {{-- 08 / TURUT MENGUNDANG — OBSIDIAN ARCHIVE SPREAD --}}
        @if ($adaTurutMengundang)
            <div data-section-turut-mengundang="editorial"
                class="max-w-md mx-auto bg-[#141417] text-[#FAF9F6] border border-[#18181B] p-6 text-left space-y-4 shadow-[-6px_6px_0_0_#71717A] kartu-3d">
                <div data-gsap="turun"
                    class="ed-mono flex items-center justify-between text-[9px] font-bold uppercase tracking-[0.28em] text-white/60 border-b border-white/20 pb-2.5">
                    <span>08 / FAMILIES</span>
                    <span>KELUARGA BESAR</span>
                </div>

                <h2 data-gsap="naik" data-gsap-delay="0.05"
                    class="ed-serif text-2xl sm:text-[1.75rem] uppercase tracking-[0.06em] text-white">
                    {{ $undangan->teksKustom('judul_turut_mengundang', 'Turut Mengundang') }}
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 text-xs pt-1">
                    @if (!empty($turutPria))
                        <div data-gsap="kiri" data-gsap-delay="0.08"
                            class="border border-white/25 bg-white/[0.03] p-4 space-y-1.5">
                            <p
                                class="ed-mono font-bold uppercase tracking-[0.2em] text-white text-[9.5px] border-b border-white/15 pb-1.5">
                                Pihak {{ $undangan->nama_panggilan_pria }}
                            </p>
                            @foreach ($turutPria as $baris)
                                <p class="text-white/80 leading-relaxed">{{ $baris }}</p>
                            @endforeach
                        </div>
                    @endif
                    @if (!empty($turutWanita))
                        <div data-gsap="kanan" data-gsap-delay="0.1"
                            class="border border-white/25 bg-white/[0.03] p-4 space-y-1.5">
                            <p
                                class="ed-mono font-bold uppercase tracking-[0.2em] text-white text-[9.5px] border-b border-white/15 pb-1.5">
                                Pihak {{ $undangan->nama_panggilan_wanita }}
                            </p>
                            @foreach ($turutWanita as $baris)
                                <p class="text-white/80 leading-relaxed">{{ $baris }}</p>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </section>
@endif

{{-- SEKSI 12: EDITORIAL COLOPHON PENUTUP & FOOTER --}}
<section data-layout-penutup="editorial" class="relative bg-[#0E0E11] text-[#FAF9F6] px-5 py-14 overflow-hidden">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 ed-film-grain opacity-35"></div>

    <div
        class="relative z-10 max-w-md mx-auto border border-white/30 bg-[#141418] p-6 text-center space-y-5 shadow-[6px_6px_0_0_rgba(255,255,255,0.14)]">
        <div
            class="ed-mono flex items-center justify-between text-[8.5px] uppercase tracking-[0.26em] text-white/55 border-b border-white/15 pb-3">
            <span>FIN &middot; COLOPHON</span>
            <span>FIRST EDITION</span>
        </div>

        @if ($urlFotoPenutup)
            <div data-gsap="potret" class="mx-auto w-52">
                <div class="ed-tirai-foto border border-white/35 p-1 bg-black">
                    <img src="{{ $urlFotoPenutup }}"
                        alt="Foto Penutup {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                        :class="modeWarnaEditorial ? 'grayscale-0' : 'grayscale hover:grayscale-0'"
                        class="w-full aspect-[4/5] object-cover object-top contrast-[1.06] transition duration-700">
                </div>
            </div>
        @endif

        @if ($undangan->teksKustom('judul_penutup') !== '')
            <p data-gsap="mekar" class="ed-mono text-[10px] font-bold uppercase tracking-[0.34em] text-white/80">
                {{ $undangan->teksKustom('judul_penutup') }}
            </p>
        @endif

        <p data-gsap="teks" data-gsap-delay="0.08" class="text-xs text-white/80 leading-relaxed max-w-xs mx-auto">
            {{ $undangan->teksKustom('ucapan_penutup', 'Merupakan kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir serta memberikan doa restu pada hari bahagia kami.') }}
        </p>

        <div class="border-t border-white/20 pt-4 space-y-1.5">
            <p data-gsap="naik" data-gsap-delay="0.12"
                class="ed-mono text-[9.5px] uppercase tracking-[0.28em] text-white/60">
                {{ $undangan->teksKustom('label_penutup', 'Kami Yang Berbahagia') }}
            </p>
            <p data-gsap="mekar" data-gsap-delay="0.15"
                class="ed-serif text-3xl uppercase tracking-[0.1em] text-white">
                {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
            </p>
            <p data-gsap="naik" data-gsap-delay="0.18"
                class="ed-mono text-[9.5px] uppercase tracking-[0.24em] text-white/60">
                {{ $hashtagPasangan }}
            </p>
        </div>
    </div>
</section>

@include('komponen-undangan.footer-tema', [
    'gelap' => true,
    'sudutTajam' => true,
    'warnaOrnamen' => '#FFFFFF',
    'kelasLatar' => 'bg-gradient-to-b from-[#121216] via-[#0B0B0E] to-[#060608] border-t border-white/25',
    'kelasTeks' => 'text-white/78',
    'kelasAksen' => 'text-white',
    'kelasTombol' =>
        'bg-white/6 text-white/90 border border-white/30 hover:-translate-y-0.5 hover:bg-white hover:text-[#0A0A0C]',
])
