{{-- SEKSI 9: AMPLOP DIGITAL SOLITAIRE VAULT (BUKA-TUTUP KARTU BANK GLOSSY + SALIN ALAMAT) --}}
@if ($undangan->fiturAktif('amplop_digital') && ($undangan->daftarAmplop->isNotEmpty() || $alamatKado !== ''))
<section id="elegan-amplop" data-kartu-tumpuk x-data="{ amplopTerbuka: false }" class="noir-kartu-tumpuk relative bg-[#0B0B0F] px-4 py-12 overflow-hidden">
    <div class="relative max-w-md mx-auto rounded-2xl bg-[#15141B] border border-[#D4AF37]/55 p-6 text-center shadow-2xl space-y-5 kartu-3d efek-shimmer-kartu">
        <span aria-hidden="true" class="pointer-events-none absolute top-2.5 left-2.5 h-4 w-4 border-t-2 border-l-2 border-[#D4AF37]"></span>
        <span aria-hidden="true" class="pointer-events-none absolute top-2.5 right-2.5 h-4 w-4 border-t-2 border-r-2 border-[#D4AF37]"></span>
        <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 left-2.5 h-4 w-4 border-b-2 border-l-2 border-[#D4AF37]"></span>
        <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 right-2.5 h-4 w-4 border-b-2 border-r-2 border-[#D4AF37]"></span>

        <div class="space-y-1.5">
            <p data-gsap="turun" class="text-[10px] font-semibold uppercase tracking-[0.38em] text-[#D4AF37]">Tanda Kasih</p>
            <h2 data-gsap="naik" data-gsap-delay="0.05" class="noir-font-judul text-2xl sm:text-3xl font-bold text-[#F3E5AB]">{{ $undangan->teksKustom('judul_amplop', 'Amplop Digital') }}</h2>
            <p data-gsap="teks" data-gsap-delay="0.09" class="text-xs text-[#F5EFE6]/78 leading-relaxed max-w-xs mx-auto">
                {{ $undangan->teksKustom('pengantar_amplop', 'Doa restu dan kehadiran Bapak/Ibu/Saudara/i adalah kado terindah. Apabila berkenan memberikan tanda kasih, dapat melalui:') }}
            </p>
        </div>

        <div data-gsap="mekar" data-gsap-delay="0.10">
            <button
                type="button"
                @click="amplopTerbuka = !amplopTerbuka; window.SesiTemuSinema?.refresh(360)"
                :aria-expanded="amplopTerbuka.toString()"
                class="noir-tombol-emas inline-flex items-center justify-center gap-2 rounded-full px-7 py-2.5 text-xs font-bold uppercase tracking-[0.16em] transition active:scale-95 cursor-pointer"
            >
                <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect x="3" y="8" width="18" height="4" rx="1"/>
                    <path d="M12 8v13"/>
                    <path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"/>
                    <path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"/>
                </svg>
                <span x-text="amplopTerbuka ? 'Tutup Amplop Digital' : 'Buka Amplop Digital'">Buka Amplop Digital</span>
                <svg class="h-3.5 w-3.5 shrink-0 transition-transform duration-300" :class="amplopTerbuka ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m6 9 6 6 6-6"/>
                </svg>
            </button>
        </div>

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
            <div class="h-px w-full bg-gradient-to-r from-transparent via-[#D4AF37]/45 to-transparent" aria-hidden="true"></div>

            @foreach ($undangan->daftarAmplop as $amplop)
                @php
                    $gayaBank = \App\Support\GayaKartuBank::untukNamaBank($amplop->nama_bank);
                    $nomorTerformat = \App\Support\GayaKartuBank::formatNomor($amplop->nomor_rekening);
                    $idKartuAmplop = $amplop->id ?? $loop->iteration;
                @endphp
                <div
                    class="relative rounded-2xl p-5 text-white overflow-hidden border border-[#F3E5AB]/40 shadow-[0_18px_38px_-12px_rgba(0,0,0,0.78)] kartu-3d"
                    style="background: {{ $gayaBank['gradient_css'] }};"
                >
                    <div aria-hidden="true" class="pointer-events-none absolute -top-12 -right-12 h-36 w-36 rounded-full bg-white/12 blur-xl"></div>
                    <div aria-hidden="true" class="pointer-events-none absolute -bottom-12 -left-10 h-32 w-32 rounded-full opacity-22 blur-xl" style="background-color: {{ $gayaBank['aksen_hex'] }};"></div>

                    <div class="relative z-10 flex items-start justify-between gap-3">
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-white/75">
                                {{ $gayaBank['label_jenis'] }}
                            </p>
                            <p class="mt-0.5 font-sans text-base font-extrabold tracking-wide text-white">
                                {{ $gayaBank['singkatan'] }}
                            </p>
                        </div>
                        <div aria-hidden="true" class="h-7 w-10 rounded-md border border-white/35 shadow-inner {{ $gayaBank['chip_gaya'] === 'perak' ? 'bg-gradient-to-br from-slate-100 via-slate-300 to-slate-400' : 'bg-gradient-to-br from-[#F9E7A8] via-[#D4AF37] to-[#9A7422]' }}"></div>
                    </div>

                    <div class="relative z-10 mt-5">
                        <p class="font-mono text-lg sm:text-xl font-bold tracking-[0.14em] text-white">
                            {{ $nomorTerformat }}
                        </p>
                        <p class="mt-1 text-xs text-white/85">a.n. {{ $amplop->atas_nama }}</p>
                    </div>

                    <div class="relative z-10 mt-4 pt-3 border-t border-white/15 flex items-center justify-between gap-2">
                        <span class="text-[10px] font-medium text-white/75 truncate">{{ $amplop->nama_bank }}</span>
                        <button
                            type="button"
                            @click="salinRekening(@js($amplop->nomor_rekening), {{ $idKartuAmplop }})"
                            class="inline-flex items-center gap-1.5 rounded-full bg-black/45 hover:bg-[#D4AF37] border border-[#F3E5AB]/45 hover:text-[#0B0B0F] px-3.5 py-1.5 text-[11px] font-semibold text-white transition cursor-pointer shrink-0"
                        >
                            <span x-text="rekeningTersalin === {{ $idKartuAmplop }} ? 'Berhasil Disalin!' : 'Salin Nomor Rekening'"></span>
                        </button>
                    </div>
                </div>
            @endforeach

            @if ($alamatKado !== '')
                <div x-data="{ alamatTersalin: false }" class="rounded-xl bg-black/65 border border-[#D4AF37]/40 p-4 text-center space-y-2">
                    <p class="text-[10px] font-bold uppercase tracking-[0.28em] text-[#D4AF37]">Alamat Pengiriman Kado</p>
                    <p class="text-xs text-[#F5EFE6]/85 leading-relaxed">{{ $alamatKado }}</p>
                    <button
                        type="button"
                        @click="navigator.clipboard?.writeText(@js($alamatKado)); alamatTersalin = true; setTimeout(() => alamatTersalin = false, 2200)"
                        class="noir-tombol-obsidian inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-[11px] font-semibold transition active:scale-95 cursor-pointer"
                    >
                        <span x-show="!alamatTersalin">Salin Alamat</span>
                        <span x-show="alamatTersalin" x-cloak>Alamat Tersalin!</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- SEKSI 10: BUKU TAMU — RSVP & WISHES --}}
@if ($undangan->fiturAktif('buku_tamu'))
<section id="buku-tamu" data-kartu-tumpuk class="noir-kartu-tumpuk relative bg-[#0E0D14] px-4 py-13 border-b border-[#D4AF37]/25 overflow-hidden">
    <div class="max-w-md mx-auto">
        <div class="text-center space-y-2 mb-6">
            <img src="{{ $asetNoir['emas'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async" data-gsap="turun" class="w-10 mx-auto opacity-90">
            <p data-gsap="turun" class="text-[10px] font-semibold uppercase tracking-[0.38em] text-[#D4AF37]">Buku Tamu Kehormatan</p>
            <h2 data-gsap="mekar" data-gsap-delay="0.05" class="noir-font-judul text-2xl sm:text-3xl font-bold tracking-wider text-[#F3E5AB]">{{ $undangan->teksKustom('judul_buku_tamu', 'RSVP & Wishes') }}</h2>
            <p data-gsap="teks" data-gsap-delay="0.08" class="text-xs text-[#F5EFE6]/76 max-w-xs mx-auto leading-relaxed">
                Kami mempersilakan Bapak/Ibu/Saudara/i menyampaikan ucapan selamat, doa terbaik, serta konfirmasi kehadiran.
            </p>
        </div>

        <div data-gsap="naik" class="rounded-2xl bg-[#15141B] border border-[#D4AF37]/55 p-5 sm:p-6 shadow-2xl space-y-5 kartu-3d">
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
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D4AF37]">Nama Tamu</label>
                            <input type="text" x-model="namaTamu" required placeholder="Masukkan nama Anda" class="mt-1 w-full rounded-xl border border-[#D4AF37]/45 bg-[#0B0B0F] px-3.5 py-2.5 text-sm text-white">
                        </div>
                        <div class="grid gap-3" :class="statusKehadiran === 'hadir' ? 'grid-cols-2' : 'grid-cols-1'">
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D4AF37]">Kehadiran</label>
                                <select x-ref="selectKehadiran" x-model="statusKehadiran" @change="statusKehadiran = $event.target.value" class="mt-1 w-full rounded-xl border border-[#D4AF37]/45 bg-[#0B0B0F] px-3 py-2.5 text-sm text-white">
                                    <option value="hadir">Hadir</option>
                                    <option value="ragu">Masih Ragu</option>
                                    <option value="tidak_hadir">Berhalangan</option>
                                </select>
                            </div>
                            <div x-show="statusKehadiran === 'hadir'" x-cloak>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D4AF37]">Jumlah</label>
                                <input type="number" x-model.number="jumlahTamu" min="1" max="20" :required="statusKehadiran === 'hadir'" :disabled="statusKehadiran !== 'hadir'" class="mt-1 w-full rounded-xl border border-[#D4AF37]/45 bg-[#0B0B0F] px-3.5 py-2.5 text-sm text-white">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D4AF37]">Ucapan &amp; Doa</label>
                            <textarea x-model="ucapanDoa" rows="3" required placeholder="Tuliskan ucapan &amp; doa terbaik untuk kedua mempelai..." class="mt-1 w-full rounded-xl border border-[#D4AF37]/45 bg-[#0B0B0F] px-3.5 py-2.5 text-sm text-white"></textarea>
                        </div>
                        <button type="submit" class="noir-tombol-emas w-full rounded-full py-3 text-xs font-bold uppercase tracking-[0.18em] transition cursor-pointer">
                            Kirim Konfirmasi &amp; Doa
                        </button>
                        <p x-show="pesanGalat" x-cloak x-text="pesanGalat" class="text-xs font-semibold text-rose-300 text-center"></p>
                        <p x-show="pesanSukses" x-cloak x-text="pesanSukses" class="rounded-xl bg-emerald-950/75 border border-emerald-400/40 px-3 py-2 text-[11px] font-semibold text-emerald-200 text-center"></p>
                    </form>

                    <div class="pt-4 border-t border-[#D4AF37]/25 space-y-3">
                        <div class="flex items-center justify-between gap-2">
                            <h3 class="noir-font-judul text-sm font-bold tracking-wider text-[#F3E5AB]">
                                Doa &amp; Ucapan (<span x-text="daftarUcapan.length">{{ count($daftarUcapanAwal) }}</span>)
                            </h3>
                            <span class="text-[10px] uppercase tracking-wider text-[#D4AF37]/80">Gulir untuk lainnya</span>
                        </div>
                        <div x-ref="daftarUcapanScroll" data-lenis-prevent class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                            <template x-for="ucapan in daftarUcapan" :key="ucapan.id">
                                <div
                                    class="rounded-xl bg-black/60 border p-3.5 space-y-1.5 transition"
                                    :class="ucapan.baru ? 'border-[#F3E5AB]/70 ring-1 ring-[#D4AF37]/45' : 'border-[#D4AF37]/25'"
                                >
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="font-bold text-xs text-[#F3E5AB]" x-text="ucapan.nama_tamu"></p>
                                        <span class="shrink-0 rounded-full px-2.5 py-0.5 text-[10px] font-semibold" :class="kelasStatus(ucapan.status_kehadiran, true, 'border border-[#D4AF37]/35 text-[#D4AF37]')" x-text="labelStatus(ucapan.status_kehadiran)"></span>
                                    </div>
                                    <p class="text-xs text-[#F5EFE6]/80 leading-relaxed" x-text="ucapan.ucapan_doa"></p>
                                    <p class="text-[10px] text-[#D4AF37]/70" x-text="ucapan.waktu"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            @else
                @if (! empty($modePratinjau) || ! $undangan->sudahAktifPublik())
                    <div class="rounded-xl bg-black/60 border border-[#D4AF37]/35 px-4 py-3 text-center text-xs font-semibold text-[#F3E5AB]">
                        Mode Pratinjau — Buku Tamu &amp; RSVP Dikunci
                    </div>
                @else
                    <form x-data="{ statusKehadiran: @js(old('status_kehadiran', 'hadir')) }" method="POST" action="{{ route('undangan.ucapan', $undangan->slug) }}" class="space-y-3.5 text-left">
                        @csrf
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D4AF37]">Nama Tamu</label>
                            <input type="text" name="nama_tamu" value="{{ old('nama_tamu', $namaTamu !== 'Tamu Undangan' ? $namaTamu : '') }}" required class="mt-1 w-full rounded-xl border border-[#D4AF37]/45 bg-[#0B0B0F] px-3.5 py-2.5 text-sm text-white">
                        </div>
                        <div class="grid gap-3" :class="statusKehadiran === 'hadir' ? 'grid-cols-2' : 'grid-cols-1'">
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D4AF37]">Kehadiran</label>
                                <select name="status_kehadiran" x-model="statusKehadiran" @change="statusKehadiran = $event.target.value" class="mt-1 w-full rounded-xl border border-[#D4AF37]/45 bg-[#0B0B0F] px-3 py-2.5 text-sm text-white">
                                    <option value="hadir" @selected(old('status_kehadiran', 'hadir') === 'hadir')>Hadir</option>
                                    <option value="ragu" @selected(old('status_kehadiran') === 'ragu')>Masih Ragu</option>
                                    <option value="tidak_hadir" @selected(old('status_kehadiran') === 'tidak_hadir')>Berhalangan</option>
                                </select>
                            </div>
                            <div x-show="statusKehadiran === 'hadir'" x-cloak>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D4AF37]">Jumlah</label>
                                <input type="number" name="jumlah_tamu" value="{{ old('jumlah_tamu', 1) }}" min="1" max="20" :required="statusKehadiran === 'hadir'" :disabled="statusKehadiran !== 'hadir'" class="mt-1 w-full rounded-xl border border-[#D4AF37]/45 bg-[#0B0B0F] px-3.5 py-2.5 text-sm text-white">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D4AF37]">Ucapan &amp; Doa</label>
                            <textarea name="ucapan_doa" rows="3" required placeholder="Tuliskan ucapan &amp; doa terbaik untuk kedua mempelai..." class="mt-1 w-full rounded-xl border border-[#D4AF37]/45 bg-[#0B0B0F] px-3.5 py-2.5 text-sm text-white">{{ old('ucapan_doa') }}</textarea>
                        </div>
                        <button type="submit" class="noir-tombol-emas w-full rounded-full py-3 text-xs font-bold uppercase tracking-[0.18em] transition cursor-pointer">
                            Kirim Konfirmasi &amp; Doa
                        </button>
                    </form>
                @endif

                <div class="pt-4 border-t border-[#D4AF37]/25 space-y-3">
                    <h3 class="noir-font-judul text-sm font-bold tracking-wider text-[#F3E5AB]">Doa &amp; Ucapan ({{ $undangan->bukuTamu->count() }})</h3>
                    <div data-lenis-prevent class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                        @forelse ($undangan->bukuTamu as $ucapan)
                            <div class="rounded-xl bg-black/55 border border-[#D4AF37]/25 p-3.5 space-y-1">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="font-bold text-xs text-[#F3E5AB]">{{ $ucapan->nama_tamu }}</p>
                                    <span class="rounded-full border border-[#D4AF37]/35 px-2.5 py-0.5 text-[10px] font-semibold text-[#D4AF37]">
                                        {{ str_replace('_', ' ', ucfirst($ucapan->status_kehadiran)) }}
                                    </span>
                                </div>
                                <p class="text-xs text-[#F5EFE6]/80 leading-relaxed">{{ $ucapan->ucapan_doa }}</p>
                            </div>
                        @empty
                            <p class="text-xs text-[#F5EFE6]/60 text-center">Jadilah yang pertama memberikan doa restu.</p>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- SEKSI 11: DOA UNTUK PENGANTIN & TURUT MENGUNDANG (URUTAN SERAGAM SEMUA KATEGORI) --}}
@if ($undangan->fiturAktif('doa_pengantin') || $adaTurutMengundang)
<section data-kartu-tumpuk class="noir-kartu-tumpuk relative bg-[#0B0B0F] px-4 py-12 space-y-6 overflow-hidden">
    {{-- Kartu Doa Untuk Pengantin --}}
    @if ($undangan->fiturAktif('doa_pengantin'))
        @php
            $doaPengantin = $undangan->doaPengantin([
                'arab' => '',
                'latin' => 'Semoga Tuhan Yang Maha Kuasa senantiasa melimpahkan kasih, kedamaian, dan keberkahan dalam setiap langkah rumah tangga yang dibangun bersama.',
                'isi' => 'Kiranya ikatan suci ini menjadi awal perjalanan hidup yang rukun, saling menguatkan dalam suka maupun duka, serta membawa kebahagiaan abadi.',
            ]);
        @endphp
        <div data-section-doa-pengantin="artdeco" class="relative max-w-md mx-auto rounded-2xl bg-[#15141B] border border-[#D4AF37]/55 p-6 text-center shadow-xl kartu-3d efek-shimmer-kartu space-y-3.5">
            <span aria-hidden="true" class="pointer-events-none absolute top-2.5 left-2.5 h-3.5 w-3.5 border-t-2 border-l-2 border-[#D4AF37]"></span>
            <span aria-hidden="true" class="pointer-events-none absolute top-2.5 right-2.5 h-3.5 w-3.5 border-t-2 border-r-2 border-[#D4AF37]"></span>
            <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 left-2.5 h-3.5 w-3.5 border-b-2 border-l-2 border-[#D4AF37]"></span>
            <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 right-2.5 h-3.5 w-3.5 border-b-2 border-r-2 border-[#D4AF37]"></span>

            <img data-gsap="turun" src="{{ $asetNoir['emas'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async" class="w-10 mx-auto opacity-90">
            <p data-gsap="mekar" class="text-[10px] font-semibold uppercase tracking-[0.36em] text-[#D4AF37]">Untaian Doa Restu</p>
            <h2 data-gsap="naik" class="noir-font-judul text-xl sm:text-2xl font-bold text-[#F3E5AB]">{{ $doaPengantin['judul'] }}</h2>
            @if ($doaPengantin['arab'] !== '')
                <p data-gsap="mekar" data-gsap-delay="0.05" class="text-xl leading-loose text-[#F3E5AB]" style="font-family: 'Amiri', serif;" dir="rtl">
                    {{ $doaPengantin['arab'] }}
                </p>
            @endif
            @if ($doaPengantin['latin'] !== '')
                <p data-gsap="teks" data-gsap-delay="0.06" class="font-serif italic text-sm sm:text-[15px] text-white/90 leading-relaxed max-w-xs mx-auto">
                    &ldquo;{{ $doaPengantin['latin'] }}&rdquo;
                </p>
            @endif
            <div data-gsap="garis" class="flex items-center justify-center gap-3 px-10" aria-hidden="true">
                <span class="h-px flex-1 bg-[#D4AF37]/45"></span>
                <span class="w-1.5 h-1.5 rotate-45 bg-[#D4AF37]"></span>
                <span class="h-px flex-1 bg-[#D4AF37]/45"></span>
            </div>
            <p data-gsap="teks" data-gsap-delay="0.10" class="text-xs text-[#F5EFE6]/78 leading-relaxed max-w-xs mx-auto">
                {{ $doaPengantin['isi'] }}
            </p>
        </div>
    @endif

    {{-- Kartu Turut Mengundang --}}
    @if ($adaTurutMengundang)
        <div data-section-turut-mengundang="artdeco" class="max-w-md mx-auto rounded-2xl bg-[#15141B] border border-[#D4AF37]/45 p-6 text-center shadow-xl kartu-3d space-y-4">
            <div class="space-y-1">
                <p data-gsap="turun" class="text-[10px] font-semibold uppercase tracking-[0.38em] text-[#D4AF37]">Keluarga Besar</p>
                <h2 data-gsap="naik" data-gsap-delay="0.05" class="noir-font-judul text-xl font-bold text-[#F3E5AB]">{{ $undangan->teksKustom('judul_turut_mengundang', 'Turut Mengundang') }}</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 text-xs">
                @if (! empty($turutPria))
                    <div data-gsap="kiri" data-gsap-delay="0.08" class="rounded-xl bg-black/55 border border-[#D4AF37]/30 p-3.5 space-y-1">
                        <p class="font-bold uppercase tracking-wider text-[#D4AF37] text-[10px] pb-1 border-b border-[#D4AF37]/20">Pihak {{ $undangan->nama_panggilan_pria }}</p>
                        @foreach ($turutPria as $baris)
                            <p class="text-[#F5EFE6]/85 leading-relaxed">{{ $baris }}</p>
                        @endforeach
                    </div>
                @endif
                @if (! empty($turutWanita))
                    <div data-gsap="kanan" data-gsap-delay="0.10" class="rounded-xl bg-black/55 border border-[#D4AF37]/30 p-3.5 space-y-1">
                        <p class="font-bold uppercase tracking-wider text-[#D4AF37] text-[10px] pb-1 border-b border-[#D4AF37]/20">Pihak {{ $undangan->nama_panggilan_wanita }}</p>
                        @foreach ($turutWanita as $baris)
                            <p class="text-[#F5EFE6]/85 leading-relaxed">{{ $baris }}</p>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif
</section>
@endif

{{-- SEKSI 12: PENUTUP FULL-BLEED CINEMATIC GALA POSTCARD & FOOTER --}}
<div data-kartu-tumpuk class="noir-kartu-tumpuk bg-[#09090D]">
<section
    data-layout-penutup="artdeco"
    data-penutup-sinematik-elegan="noir"
    class="relative px-4 pt-9 pb-11 overflow-hidden"
>
    @if ($urlFotoPenutup)
        <article class="relative max-w-md mx-auto min-h-[520px] rounded-2xl overflow-hidden border border-[#D4AF37]/40 shadow-[0_28px_60px_-16px_rgba(0,0,0,0.92)] flex flex-col justify-between bg-[#0B0B0F] kartu-3d efek-shimmer-kartu">
            {{-- Foto Penutup Full-Bleed Bergradasi Malam Obsidian-Emas --}}
            <img
                src="{{ $urlFotoPenutup }}"
                alt="Foto Penutup {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                loading="lazy"
                decoding="async"
                class="pointer-events-none absolute inset-0 w-full h-full object-cover object-top"
            >
            <div
                aria-hidden="true"
                class="pointer-events-none absolute inset-0"
                style="background: linear-gradient(180deg, rgba(9,9,13,0.42) 0%, rgba(9,9,13,0.08) 34%, rgba(9,9,13,0.72) 64%, rgba(7,7,11,0.96) 100%);"
            ></div>

            {{-- Bingkai Garis Emas Tipis 1px Siku Art Deco --}}
            <span aria-hidden="true" class="pointer-events-none absolute inset-3 rounded-xl border border-[#D4AF37]/30 z-10"></span>

            {{-- Pita Monogram & Tanggal Melayang di Atas --}}
            <div data-gsap="turun" class="relative z-20 pt-6 px-6 flex items-center justify-between gap-2">
                <span class="inline-flex items-center gap-2 rounded-full bg-black/65 backdrop-blur-md border border-[#D4AF37]/45 px-3 py-1 text-[9.5px] font-semibold uppercase tracking-[0.26em] text-[#F3E5AB]">
                    <span class="h-1.5 w-1.5 rotate-45 bg-[#D4AF37]"></span>
                    <span>{{ $undangan->inisialPria() }} &amp; {{ $undangan->inisialWanita() }}</span>
                </span>
                <span class="rounded-full bg-black/65 backdrop-blur-md border border-[#D4AF37]/35 px-3 py-1 text-[9.5px] font-semibold uppercase tracking-[0.22em] text-[#D4AF37]">
                    {{ $tanggalTitik }}
                </span>
            </div>

            {{-- Panel Bawah Overlaid: Ucapan Terima Kasih & Tanda Tangan Pasangan --}}
            <div class="relative z-20 mt-auto pt-24 pb-7 px-6 text-center space-y-4 text-[#F5EFE6]">
                <div data-gsap="garis" class="flex items-center justify-center gap-3 px-6" aria-hidden="true">
                    <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#D4AF37]/65"></span>
                    <span class="w-1.5 h-1.5 rotate-45 bg-[#D4AF37]"></span>
                    <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#D4AF37]/65"></span>
                </div>

                <div class="space-y-1.5">
                    <p data-gsap="naik" class="text-[9.5px] font-semibold uppercase tracking-[0.36em] text-[#D4AF37]">{{ $undangan->teksKustom('judul_penutup', 'Terima Kasih') }}</p>
                    <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-[13px] text-[#F5EFE6]/86 leading-relaxed max-w-xs mx-auto">
                        {{ $undangan->teksKustom('ucapan_penutup', 'Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir serta memberikan doa restu pada malam bahagia kami.') }}
                    </p>
                </div>

                <div class="pt-3 border-t border-[#D4AF37]/25 flex flex-col items-center space-y-1.5">
                    <p data-gsap="naik" data-gsap-delay="0.1" class="text-[9.5px] uppercase tracking-[0.28em] text-[#D4AF37]/85">{{ $undangan->teksKustom('label_penutup', 'Kami Yang Berbahagia') }}</p>
                    <p data-gsap="mekar" data-gsap-delay="0.13" class="noir-font-judul text-2xl sm:text-3xl font-bold tracking-wider text-[#F3E5AB]">
                        {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
                    </p>
                    <p data-gsap="naik" data-gsap-delay="0.16" class="text-[10.5px] uppercase tracking-[0.24em] text-[#F5EFE6]/78">
                        {{ $hashtagPasangan }}
                    </p>
                </div>
            </div>
        </article>
    @else
        {{-- Varian Tanpa Foto: Plakat Gala Obsidian Persegi Panjang --}}
        <article class="relative max-w-md mx-auto rounded-2xl bg-[#15141B] border border-[#D4AF37]/45 px-6 py-11 text-center shadow-2xl space-y-5 kartu-3d efek-shimmer-kartu">
            <span aria-hidden="true" class="pointer-events-none absolute inset-3 rounded-xl border border-[#D4AF37]/22"></span>
            <div data-gsap="potret" class="relative z-10 mx-auto w-24 h-24 flex items-center justify-center">
                <span aria-hidden="true" class="absolute inset-0 rounded-full border border-dashed border-[#D4AF37]/65 animasi-orbit"></span>
                <span aria-hidden="true" class="absolute inset-2 rounded-full border border-[#F3E5AB]/45 bg-[#0B0B0F]"></span>
                <span class="relative noir-font-judul text-xl font-bold tracking-widest text-[#F3E5AB]">{{ $undangan->inisialPria() }}&amp;{{ $undangan->inisialWanita() }}</span>
            </div>
            <div class="relative z-10 space-y-2">
                <p data-gsap="mekar" class="text-[10px] font-semibold uppercase tracking-[0.38em] text-[#D4AF37]">{{ $undangan->teksKustom('judul_penutup', 'Terima Kasih') }}</p>
                <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-sm text-[#F5EFE6]/82 leading-relaxed max-w-xs mx-auto">
                    {{ $undangan->teksKustom('ucapan_penutup', 'Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir serta memberikan doa restu pada malam bahagia kami.') }}
                </p>
            </div>
            <div class="relative z-10 pt-3 border-t border-[#D4AF37]/25 space-y-1.5">
                <p data-gsap="naik" data-gsap-delay="0.1" class="text-[9.5px] uppercase tracking-[0.28em] text-[#D4AF37]/85">{{ $undangan->teksKustom('label_penutup', 'Kami Yang Berbahagia') }}</p>
                <p data-gsap="mekar" data-gsap-delay="0.13" class="noir-font-judul text-2xl sm:text-3xl font-bold tracking-wider text-[#F3E5AB]">
                    {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
                </p>
                <p data-gsap="naik" data-gsap-delay="0.16" class="text-[10.5px] uppercase tracking-[0.24em] text-[#F5EFE6]/75">
                    {{ $hashtagPasangan }}
                </p>
            </div>
        </article>
    @endif
</section>

@include('komponen-undangan.footer-tema', [
    'gelap' => true,
    'warnaOrnamen' => '#D4AF37',
    'kelasLatar' => 'bg-gradient-to-b from-[#111116] via-[#09090D] to-[#050507] border-t border-[#D4AF37]/40 pb-24',
    'kelasTeks' => 'text-[#F5EFE6]/82',
    'kelasAksen' => 'text-[#F3E5AB]',
    'kelasTombol' => 'bg-white/6 text-[#F3E5AB] border border-[#D4AF37]/45 hover:-translate-y-0.5 hover:bg-[#D4AF37] hover:text-[#07070A]',
])
</div>
