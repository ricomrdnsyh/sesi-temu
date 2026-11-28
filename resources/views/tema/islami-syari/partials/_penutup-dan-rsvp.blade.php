{{-- SEKSI 9: AMPLOP DIGITAL SYAR'I (PLAKAT ALABASTER MIHRAB & LACI KARTU BANK GLOSSY) --}}
@if ($undangan->fiturAktif('amplop_digital') && ($undangan->daftarAmplop->isNotEmpty() || $alamatKado !== ''))
    <section data-layout-amplop x-data="{ amplopTerbuka: false }"
        class="relative bg-[#F7FBF8] syari-pola-zellige px-4 py-12 overflow-hidden">
        <div
            class="relative max-w-md mx-auto rounded-t-[8.5rem] rounded-b-[1.75rem] bg-[#FCFEFD] border-2 border-[#C5A059]/75 px-5 sm:px-6 pt-9 pb-7 text-center text-[#0E3A36] shadow-[0_18px_42px_-16px_rgba(14,58,54,0.2)] overflow-hidden kartu-3d">
            <span aria-hidden="true"
                class="pointer-events-none absolute inset-2.5 rounded-t-[7.8rem] rounded-b-[1.3rem] border border-dashed border-[#C5A059]/45"></span>

            <div class="relative z-10 space-y-4">
                <div data-gsap="turun" class="relative mx-auto h-11 w-11 flex items-center justify-center">
                    <span aria-hidden="true" class="absolute inset-1 bg-[#0E3A36] border border-[#C5A059]"></span>
                    <span aria-hidden="true"
                        class="absolute inset-1 rotate-45 bg-[#0E3A36] border border-[#C5A059]"></span>
                    <svg class="relative z-10 h-4 w-4 text-[#F3E5AB]" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"
                        aria-hidden="true">
                        <rect x="3" y="8" width="18" height="4" rx="1" />
                        <path d="M12 8v13" />
                        <path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7" />
                        <path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5" />
                    </svg>
                </div>

                <div class="space-y-1">
                    <p data-gsap="turun" class="text-[9.5px] font-bold uppercase tracking-[0.34em] text-[#9E7D40]">Tanda
                        Kasih</p>
                    <h2 data-gsap="mekar" data-gsap-delay="0.06"
                        class="font-serif text-[1.75rem] sm:text-[1.95rem] font-bold leading-tight text-[#0E3A36]">
                        {{ $undangan->teksKustom('judul_amplop', 'Hadiah Pernikahan') }}
                    </h2>
                </div>

                <p data-gsap="teks" class="text-xs sm:text-[13px] text-[#0E3A36]/78 leading-relaxed max-w-xs mx-auto">
                    {{ $undangan->teksKustom('pengantar_amplop', 'Doa restu Bapak/Ibu/Saudara/i merupakan karunia terindah. Apabila berkenan memberikan tanda kasih, dapat melalui:') }}
                </p>

                <div data-gsap="mekar" data-gsap-delay="0.08" class="pt-1">
                    <button type="button" @click="amplopTerbuka = !amplopTerbuka; window.SesiTemuSinema?.refresh(360)"
                        :aria-expanded="amplopTerbuka.toString()"
                        class="syari-tombol inline-flex items-center justify-center gap-2 rounded-full px-6 py-2.5 text-xs font-bold uppercase tracking-[0.14em] transition active:scale-95 cursor-pointer">
                        <svg class="h-3.5 w-3.5 text-[#F3E5AB]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="3" y="8" width="18" height="4" rx="1" />
                            <path d="M12 8v13" />
                            <path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7" />
                            <path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5" />
                        </svg>
                        <span x-text="amplopTerbuka ? 'Tutup Rekening' : 'Buka Amplop Digital'"></span>
                        <svg class="h-3.5 w-3.5 text-[#F3E5AB] transition-transform duration-300"
                            :class="amplopTerbuka ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
                            aria-hidden="true">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                    </button>
                </div>

                {{-- Daftar Kartu Bank Glossy & Alamat Kado --}}
                <div x-show="amplopTerbuka" x-cloak x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-2 scale-[0.98]"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 -translate-y-2 scale-[0.98]"
                    class="pt-2 space-y-4 text-left panggung-3d">
                    <div class="flex items-center justify-center gap-3 px-10 pb-1" aria-hidden="true">
                        <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#C5A059]/55"></span>
                        <span class="w-1.5 h-1.5 rotate-45 bg-[#C5A059]"></span>
                        <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#C5A059]/55"></span>
                    </div>

                    @foreach ($undangan->daftarAmplop as $amplop)
                        @include('komponen-undangan.kartu-bank-amplop', ['amplop' => $amplop])
                    @endforeach

                    @if ($alamatKado !== '')
                        <div x-data="{ alamatTersalin: false }"
                            class="rounded-2xl bg-[#EEF6F1] border border-dashed border-[#C5A059]/75 p-4 text-center space-y-2">
                            <p class="text-[10px] font-bold uppercase tracking-[0.28em] text-[#9E7D40]">Alamat Kirim
                                Kado</p>
                            <p class="text-xs sm:text-[13px] text-[#0E3A36]/85 leading-relaxed">{{ $alamatKado }}
                            </p>
                            <button type="button"
                                @click="navigator.clipboard?.writeText(@js($alamatKado)); alamatTersalin = true; setTimeout(() => alamatTersalin = false, 2200)"
                                class="syari-tombol-emas inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-[11px] font-bold uppercase tracking-wider transition active:scale-95 cursor-pointer">
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

{{-- SEKSI 10: RSVP & WISHES (BLOK ZAMRUD ELEGAN) --}}
<section id="buku-tamu"
    class="relative bg-[#0E3A36] shadow-[0_0_0_2px_#0E3A36] text-[#F7FBF8] py-14 px-5 overflow-hidden">
    <div class="max-w-md mx-auto">
        <div class="text-center space-y-2">
            <img src="{{ $asetSyari['arabesque'] }}" alt="" loading="lazy" decoding="async" data-gsap="turun"
                class="w-12 mx-auto drop-shadow-lg">
            <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.36em] text-[#E6D19C]">Doa
                Restu</p>
            <h2 data-gsap="mekar"
                class="font-serif text-4xl sm:text-5xl font-bold uppercase tracking-[0.12em] text-white leading-tight">
                {{ $undangan->teksKustom('judul_buku_tamu', 'RSVP & Wishes') }}
            </h2>
            <p data-gsap="teks" data-gsap-delay="0.06"
                class="text-xs text-[#F7FBF8]/80 max-w-xs mx-auto leading-relaxed">
                Kami mempersilakan Bapak/Ibu/Saudara/i menyampaikan ucapan, doa terbaik, serta konfirmasi kehadiran.
            </p>
            <div data-gsap="garis" aria-hidden="true" class="mx-auto w-24 h-px bg-[#E6D19C]/55 pt-1"></div>
        </div>

        <div data-gsap="naik"
            class="mt-7 rounded-[22px] bg-[#FCFEFD] border-2 border-[#C5A059]/65 p-5 sm:p-6 shadow-2xl space-y-5 text-[#0E3A36] kartu-3d">
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
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#0E3A36]/80">Nama
                                Tamu</label>
                            <input type="text" x-model="namaTamu" required placeholder="Masukkan nama Anda"
                                class="mt-1 w-full rounded-xl border border-[#C5A059]/55 bg-[#F7FBF8] px-3.5 py-2.5 text-sm text-[#0E3A36] focus:border-[#0E3A36] focus:outline-none">
                        </div>
                        <div class="grid gap-3"
                            :class="statusKehadiran === 'hadir' ? 'grid-cols-2' : 'grid-cols-1'">
                            <div>
                                <label
                                    class="block text-[11px] font-bold uppercase tracking-wider text-[#0E3A36]/80">Kehadiran</label>
                                <select x-ref="selectKehadiran" x-model="statusKehadiran"
                                    @change="statusKehadiran = $event.target.value"
                                    class="mt-1 w-full rounded-xl border border-[#C5A059]/55 bg-[#F7FBF8] px-3 py-2.5 text-sm text-[#0E3A36]">
                                    <option value="hadir">InsyaAllah Hadir</option>
                                    <option value="ragu">Masih Ragu</option>
                                    <option value="tidak_hadir">Berhalangan</option>
                                </select>
                            </div>
                            <div x-show="statusKehadiran === 'hadir'" x-cloak>
                                <label
                                    class="block text-[11px] font-bold uppercase tracking-wider text-[#0E3A36]/80">Jumlah</label>
                                <input type="number" x-model.number="jumlahTamu" min="1" max="20"
                                    :required="statusKehadiran === 'hadir'"
                                    :disabled="statusKehadiran !== 'hadir'"
                                    class="mt-1 w-full rounded-xl border border-[#C5A059]/55 bg-[#F7FBF8] px-3.5 py-2.5 text-sm text-[#0E3A36]">
                            </div>
                        </div>
                        <div>
                            <label
                                class="block text-[11px] font-bold uppercase tracking-wider text-[#0E3A36]/80">Ucapan
                                &amp; Doa</label>
                            <textarea x-model="ucapanDoa" rows="3" required placeholder="Tuliskan doa terbaik..."
                                class="mt-1 w-full rounded-xl border border-[#C5A059]/55 bg-[#F7FBF8] px-3.5 py-2.5 text-sm text-[#0E3A36] focus:border-[#0E3A36] focus:outline-none"></textarea>
                        </div>
                        <button type="submit"
                            class="syari-tombol w-full rounded-full py-3 text-xs font-bold uppercase tracking-wider transition cursor-pointer">
                            Kirim Konfirmasi &amp; Doa
                        </button>
                        <p x-show="pesanGalat" x-cloak x-text="pesanGalat"
                            class="text-xs font-semibold text-rose-700 text-center"></p>
                        <p x-show="pesanSukses" x-cloak x-text="pesanSukses"
                            class="rounded-xl bg-emerald-50 border border-emerald-200 px-3 py-2 text-[11px] font-semibold text-emerald-800 text-center">
                        </p>
                    </form>

                    <div class="pt-4 border-t border-[#C5A059]/30 space-y-3">
                        <div class="flex items-center justify-between gap-2">
                            <h3 class="font-serif text-base font-bold text-[#0E3A36]">
                                Doa &amp; Ucapan (<span
                                    x-text="daftarUcapan.length">{{ count($daftarUcapanAwal) }}</span>)
                            </h3>
                            <span class="text-[10px] uppercase tracking-wider text-[#9E7D40]">Gulir untuk
                                lainnya</span>
                        </div>
                        <div x-ref="daftarUcapanScroll" data-lenis-prevent
                            class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                            <template x-for="ucapan in daftarUcapan" :key="ucapan.id">
                                <div class="rounded-xl bg-[#F7FBF8] border border-l-[3px] border-l-[#C5A059] p-3.5 space-y-1.5 transition"
                                    :class="ucapan.baru ? 'border-[#0E3A36]/55 ring-1 ring-[#0E3A36]/15' :
                                        'border-[#0E3A36]/12'">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="font-bold text-xs text-[#0E3A36]" x-text="ucapan.nama_tamu"></p>
                                        <span class="shrink-0 rounded-full px-2.5 py-0.5 text-[10px] font-semibold"
                                            :class="kelasStatus(ucapan.status_kehadiran, false,
                                                'bg-[#0E3A36]/10 text-[#0E3A36]')"
                                            x-text="labelStatus(ucapan.status_kehadiran)"></span>
                                    </div>
                                    <p class="text-xs text-[#0E3A36]/82 leading-relaxed" x-text="ucapan.ucapan_doa">
                                    </p>
                                    <p class="text-[10px] text-[#9E7D40]/90" x-text="ucapan.waktu"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            @else
                @if (!empty($modePratinjau) || !$undangan->sudahAktifPublik())
                    <div
                        class="rounded-xl bg-[#F7FBF8] border border-[#0E3A36]/20 px-4 py-3 text-center text-xs font-semibold text-[#0E3A36]">
                        Mode Pratinjau — Buku Tamu &amp; RSVP Dikunci
                    </div>
                @else
                    <form x-data="{ statusKehadiran: @js(old('status_kehadiran', 'hadir')) }" method="POST"
                        action="{{ route('undangan.ucapan', $undangan->slug) }}" class="space-y-3.5 text-left">
                        @csrf
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#0E3A36]/80">Nama
                                Tamu</label>
                            <input type="text" name="nama_tamu"
                                value="{{ old('nama_tamu', $namaTamu !== 'Tamu Undangan' ? $namaTamu : '') }}" required
                                class="mt-1 w-full rounded-xl border border-[#C5A059]/55 bg-[#F7FBF8] px-3.5 py-2.5 text-sm text-[#0E3A36]">
                        </div>
                        <div class="grid gap-3"
                            :class="statusKehadiran === 'hadir' ? 'grid-cols-2' : 'grid-cols-1'">
                            <div>
                                <label
                                    class="block text-[11px] font-bold uppercase tracking-wider text-[#0E3A36]/80">Kehadiran</label>
                                <select name="status_kehadiran" x-model="statusKehadiran"
                                    @change="statusKehadiran = $event.target.value"
                                    class="mt-1 w-full rounded-xl border border-[#C5A059]/55 bg-[#F7FBF8] px-3 py-2.5 text-sm text-[#0E3A36]">
                                    <option value="hadir" @selected(old('status_kehadiran', 'hadir') === 'hadir')>InsyaAllah Hadir</option>
                                    <option value="ragu" @selected(old('status_kehadiran') === 'ragu')>Masih Ragu</option>
                                    <option value="tidak_hadir" @selected(old('status_kehadiran') === 'tidak_hadir')>Berhalangan</option>
                                </select>
                            </div>
                            <div x-show="statusKehadiran === 'hadir'" x-cloak>
                                <label
                                    class="block text-[11px] font-bold uppercase tracking-wider text-[#0E3A36]/80">Jumlah</label>
                                <input type="number" name="jumlah_tamu" value="{{ old('jumlah_tamu', 1) }}"
                                    min="1" max="20" :required="statusKehadiran === 'hadir'"
                                    :disabled="statusKehadiran !== 'hadir'"
                                    class="mt-1 w-full rounded-xl border border-[#C5A059]/55 bg-[#F7FBF8] px-3.5 py-2.5 text-sm text-[#0E3A36]">
                            </div>
                        </div>
                        <div>
                            <label
                                class="block text-[11px] font-bold uppercase tracking-wider text-[#0E3A36]/80">Ucapan
                                &amp; Doa</label>
                            <textarea name="ucapan_doa" rows="3" required placeholder="Tuliskan doa terbaik..."
                                class="mt-1 w-full rounded-xl border border-[#C5A059]/55 bg-[#F7FBF8] px-3.5 py-2.5 text-sm text-[#0E3A36]">{{ old('ucapan_doa') }}</textarea>
                        </div>
                        <button type="submit"
                            class="syari-tombol w-full rounded-full py-3 text-xs font-bold uppercase tracking-wider transition cursor-pointer">
                            Kirim Konfirmasi &amp; Doa
                        </button>
                    </form>
                @endif

                <div class="pt-4 border-t border-[#C5A059]/30 space-y-3">
                    <h3 class="font-serif text-base font-bold text-[#0E3A36]">
                        Doa &amp; Ucapan ({{ $undangan->bukuTamu->count() }})
                    </h3>
                    <div data-lenis-prevent class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                        @forelse ($undangan->bukuTamu as $ucapan)
                            <div
                                class="rounded-xl bg-[#F7FBF8] border border-[#0E3A36]/12 border-l-[3px] border-l-[#C5A059] p-3.5 space-y-1">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="font-bold text-xs text-[#0E3A36]">{{ $ucapan->nama_tamu }}</p>
                                    <span
                                        class="rounded-full bg-[#0E3A36]/10 px-2.5 py-0.5 text-[10px] font-semibold text-[#0E3A36]">
                                        {{ str_replace('_', ' ', ucfirst($ucapan->status_kehadiran)) }}
                                    </span>
                                </div>
                                <p class="text-xs text-[#0E3A36]/82 leading-relaxed">{{ $ucapan->ucapan_doa }}</p>
                            </div>
                        @empty
                            <p class="text-xs text-[#0E3A36]/60 text-center">Jadilah yang pertama menuliskan doa
                                restu.</p>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

{{-- SEKSI 11: DOA UNTUK PENGANTIN & TURUT MENGUNDANG --}}
@if ($undangan->fiturAktif('doa_pengantin') || $adaTurutMengundang)
    <section class="relative bg-[#F7FBF8] syari-pola-zellige px-4 py-12 space-y-6 overflow-hidden">
        {{-- Kartu Doa Untuk Pengantin --}}
        @if ($undangan->fiturAktif('doa_pengantin'))
            @php $doaPengantin = $undangan->doaPengantin(); @endphp
            <div data-section-doa-pengantin="mihrab"
                class="relative max-w-md mx-auto rounded-[1.75rem] border-2 border-[#C5A059]/75 bg-[#FCFEFD] px-6 py-9 text-center text-[#0E3A36] shadow-[0_18px_42px_-16px_rgba(14,58,54,0.2)] space-y-4 kartu-3d">
                <span aria-hidden="true"
                    class="pointer-events-none absolute top-3 left-3 h-3.5 w-3.5 border-t border-l border-[#C5A059]/70"></span>
                <span aria-hidden="true"
                    class="pointer-events-none absolute top-3 right-3 h-3.5 w-3.5 border-t border-r border-[#C5A059]/70"></span>
                <span aria-hidden="true"
                    class="pointer-events-none absolute bottom-3 left-3 h-3.5 w-3.5 border-b border-l border-[#C5A059]/70"></span>
                <span aria-hidden="true"
                    class="pointer-events-none absolute bottom-3 right-3 h-3.5 w-3.5 border-b border-r border-[#C5A059]/70"></span>

                <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7D40]">Doa
                    Restu</p>
                <h2 data-gsap="naik"
                    class="font-serif text-2xl sm:text-3xl font-bold uppercase tracking-[0.1em] text-[#0E3A36]">
                    {{ $doaPengantin['judul'] }}
                </h2>
                @if ($doaPengantin['arab'] !== '')
                    <p data-gsap="mekar" data-gsap-delay="0.06"
                        class="text-xl sm:text-2xl leading-loose text-[#0E3A36]" style="font-family: 'Amiri', serif;"
                        dir="rtl">
                        {{ $doaPengantin['arab'] }}
                    </p>
                @endif
                @if ($doaPengantin['latin'] !== '')
                    <p data-gsap="teks" data-gsap-delay="0.08" class="text-xs italic text-[#9E7D40]">
                        &ldquo;{{ $doaPengantin['latin'] }}&rdquo;
                    </p>
                @endif
                <p data-gsap="teks" data-gsap-delay="0.10"
                    class="text-xs sm:text-sm text-[#0E3A36]/82 leading-relaxed">
                    {{ $doaPengantin['isi'] }}
                </p>
            </div>
        @endif

        {{-- Kartu Turut Mengundang (Opsional) --}}
        @if ($adaTurutMengundang)
            <div data-section-turut-mengundang="mihrab"
                class="max-w-md mx-auto rounded-[1.75rem] bg-[#0E3A36] text-[#F7FBF8] border-2 border-[#C5A059]/65 p-6 text-center shadow-xl space-y-4 kartu-3d">
                <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#E6D19C]">Keluarga
                    Besar</p>
                <h2 data-gsap="naik" class="font-serif text-2xl font-bold text-white">
                    {{ $undangan->teksKustom('judul_turut_mengundang', 'Turut Mengundang') }}</h2>
                <div class="grid grid-cols-1 {{ !empty($turutPria) && !empty($turutWanita) ? 'sm:grid-cols-2' : '' }} gap-4 text-xs">
                    @if (!empty($turutPria))
                        <div data-gsap="kiri"
                            class="rounded-2xl bg-[#08221F]/75 border border-[#C5A059]/40 p-3.5 space-y-1">
                            <p class="font-bold uppercase tracking-wider text-[#E6D19C] text-[10px]">
                                Pihak {{ $undangan->nama_panggilan_pria }}
                            </p>
                            @foreach ($turutPria as $baris)
                                <p class="text-[#F7FBF8]/90">{{ $baris }}</p>
                            @endforeach
                        </div>
                    @endif
                    @if (!empty($turutWanita))
                        <div data-gsap="kanan" data-gsap-delay="0.06"
                            class="rounded-2xl bg-[#08221F]/75 border border-[#C5A059]/40 p-3.5 space-y-1">
                            <p class="font-bold uppercase tracking-wider text-[#E6D19C] text-[10px]">
                                Pihak {{ $undangan->nama_panggilan_wanita }}
                            </p>
                            @foreach ($turutWanita as $baris)
                                <p class="text-[#F7FBF8]/90">{{ $baris }}</p>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </section>
@endif

{{-- SEKSI 12: KAPSUL PENUTUP KUBAH ALHAMBRA & FOOTER --}}
<section data-layout-penutup="mihrab"
    class="relative bg-[#F7FBF8] syari-pola-zellige px-4 pt-4 pb-14 overflow-hidden">
    <div
        class="relative z-10 max-w-md mx-auto rounded-t-[10.5rem] rounded-b-[2rem] bg-gradient-to-b from-[#134640] via-[#0D332F] to-[#08221F] text-[#F7FBF8] border-2 border-[#C5A059]/80 shadow-[0_26px_58px_-16px_rgba(14,58,54,0.48)] overflow-hidden kartu-3d">
        {{-- Potret Penutup Besar Mengisi Lengkungan Kubah Penuh (Konsetris Dengan Bingkai Emas) --}}
        @if ($urlFotoPenutup)
            <div data-gsap="potret" class="relative p-2.5 sm:p-3 pb-0">
                <div
                    class="relative overflow-hidden rounded-t-[9.6rem] rounded-b-[1.35rem] border border-[#E6D19C]/70 bg-[#071E1C] shadow-[0_18px_38px_-12px_rgba(4,16,14,0.75)]">
                    <img src="{{ $urlFotoPenutup }}"
                        alt="Foto Penutup {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                        loading="lazy" decoding="async"
                        class="w-full h-[21.5rem] sm:h-[23.5rem] object-cover object-top">
                    <div aria-hidden="true" class="pointer-events-none absolute inset-0"
                        style="background: linear-gradient(180deg, rgba(7,30,28,0.08) 0%, rgba(7,30,28,0) 46%, rgba(11,45,42,0.5) 82%, rgba(13,51,47,0.94) 100%);">
                    </div>
                </div>
            </div>
        @else
            <div data-gsap="potret" class="pt-14 pb-2 flex justify-center">
                <div
                    class="relative w-36 h-44 rounded-t-[6rem] rounded-b-2xl border-2 border-[#E6D19C]/75 bg-gradient-to-b from-[#17564F]/85 to-[#08221F] flex flex-col items-center justify-center shadow-xl">
                    <span aria-hidden="true"
                        class="pointer-events-none absolute inset-1.5 rounded-t-[5.4rem] rounded-b-xl border border-[#F3E5AB]/30"></span>
                    <span class="font-serif text-4xl font-bold text-[#F3E5AB] tracking-wider">
                        {{ $undangan->inisialPria() }} &amp; {{ $undangan->inisialWanita() }}
                    </span>
                </div>
            </div>
        @endif

        {{-- Medali Arabesque & Panel Terima Kasih Syar'i --}}
        <div class="relative z-10 px-6 {{ $urlFotoPenutup ? '-mt-7 pt-0' : 'pt-4' }} pb-10 text-center space-y-4">
            <span aria-hidden="true"
                class="pointer-events-none absolute bottom-3 left-3 h-4 w-4 border-b border-l border-[#E6D19C]/60 rounded-bl-md"></span>
            <span aria-hidden="true"
                class="pointer-events-none absolute bottom-3 right-3 h-4 w-4 border-b border-r border-[#E6D19C]/60 rounded-br-md"></span>

            <div data-gsap="mekar"
                class="mx-auto inline-flex items-center justify-center rounded-full bg-[#0E3A36] border border-[#E6D19C]/70 px-3.5 py-2 shadow-[0_10px_22px_rgba(4,16,14,0.65)]">
                <img src="{{ $asetSyari['arabesque'] }}" alt="" loading="lazy" decoding="async"
                    class="w-10 opacity-95">
            </div>

            <div data-gsap="turun" class="flex items-center justify-center gap-2.5 pt-0.5">
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-r from-transparent to-[#E6D19C]/70"></span>
                <span aria-hidden="true" class="w-1.5 h-1.5 rotate-45 bg-[#E6D19C]"></span>
                <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#E6D19C]">
                    {{ $undangan->teksKustom('judul_penutup', 'Jazakumullahu Khairan') }}</p>
                <span aria-hidden="true" class="w-1.5 h-1.5 rotate-45 bg-[#E6D19C]"></span>
                <span aria-hidden="true" class="h-px w-8 bg-gradient-to-l from-transparent to-[#E6D19C]/70"></span>
            </div>

            <p data-gsap="teks" class="text-xs sm:text-[13px] text-[#F7FBF8]/88 leading-relaxed max-w-xs mx-auto">
                {{ $undangan->teksKustom('ucapan_penutup', 'Atas kehadiran dan doa restu Bapak/Ibu/Saudara/i, kami ucapkan terima kasih. Wassalamu’alaikum Warahmatullahi Wabarakatuh.') }}
            </p>

            <div data-gsap="garis" class="flex items-center justify-center gap-3 px-10 pt-1" aria-hidden="true">
                <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#E6D19C]/45"></span>
                <span class="w-1 h-1 rotate-45 bg-[#E6D19C]"></span>
                <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#E6D19C]/45"></span>
            </div>

            <div class="pt-0.5 space-y-1.5">
                <p data-gsap="naik" class="text-[10px] font-semibold uppercase tracking-[0.28em] text-[#E6D19C]/85">
                    {{ $undangan->teksKustom('label_penutup', 'Kami Yang Berbahagia') }}
                </p>
                <p data-gsap="mekar" data-gsap-delay="0.06"
                    class="font-kaligrafi text-[2.75rem] sm:text-5xl text-white leading-[1.12] drop-shadow-[0_3px_12px_rgba(4,16,14,0.55)]">
                    {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
                </p>
                <p data-gsap="naik" data-gsap-delay="0.10"
                    class="inline-block rounded-full border border-[#E6D19C]/35 bg-[#08221F]/65 px-3.5 py-1 text-[10px] font-medium uppercase tracking-[0.22em] text-[#F3E5AB]">
                    {{ $hashtagPasangan }}
                </p>
            </div>
        </div>
    </div>
</section>

@include('komponen-undangan.footer-tema', [
    'gelap' => true,
    'warnaOrnamen' => '#E6D19C',
    'kelasLatar' => 'bg-gradient-to-b from-[#0E3A36] via-[#0B2D2A] to-[#071E1C] border-t border-[#C5A059]/45',
    'kelasTeks' => 'text-[#F7FBF8]/85',
    'kelasAksen' => 'text-[#F3E5AB]',
    'kelasTombol' =>
        'bg-white/10 text-[#F3E5AB] border border-[#C5A059]/50 hover:-translate-y-0.5 hover:bg-[#C5A059] hover:text-[#08221F]',
])
