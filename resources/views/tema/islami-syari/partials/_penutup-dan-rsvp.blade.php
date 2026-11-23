{{-- SEKSI 9: AMPLOP DIGITAL SYAR'I (KARTU SYARIAH METALIK ZAMRUD-EMAS) --}}
@if ($undangan->fiturAktif('amplop_digital') && ($undangan->daftarAmplop->isNotEmpty() || $alamatKado !== ''))
    <section class="relative px-4 py-10 overflow-hidden">
        <div class="max-w-md mx-auto space-y-5">
            <div class="text-center space-y-1">
                <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7D40]">Tanda Kasih</p>
                <h2 data-gsap="naik" class="font-serif text-3xl font-bold text-[#0E3A36]">Hadiah Pernikahan</h2>
                <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs text-[#0E3A36]/75 leading-relaxed max-w-xs mx-auto">
                    Doa restu Bapak/Ibu/Saudara/i merupakan karunia terindah. Apabila berkenan memberikan tanda kasih, dapat melalui:
                </p>
            </div>

            <div class="space-y-3.5 text-left">
                @foreach ($undangan->daftarAmplop as $amplop)
                    <div data-gsap="naik" data-gsap-delay="{{ number_format($loop->index * 0.06, 2, '.', '') }}" class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#0D3531] via-[#154C46] to-[#092421] border border-[#C5A059]/65 p-5 text-[#F7FBF8] shadow-[0_18px_36px_-14px_rgba(14,58,54,0.5)] space-y-3.5">
                        {{-- Watermark Geometri Kartu --}}
                        <span aria-hidden="true" class="pointer-events-none absolute -right-8 -top-8 h-32 w-32 rotate-45 border border-[#E6D19C]/15"></span>
                        <span aria-hidden="true" class="pointer-events-none absolute -right-4 -top-4 h-24 w-24 border border-[#E6D19C]/12"></span>

                        <div class="relative z-10 flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2.5">
                                {{-- Chip Metalik Emas --}}
                                <span aria-hidden="true" class="inline-flex h-6 w-8 rounded-md bg-gradient-to-br from-[#F3E5AB] via-[#D4B56E] to-[#9E7D40] border border-[#FFF5D6]/60 shadow-inner"></span>
                                <span class="font-serif text-base font-bold text-[#F3E5AB]">{{ $amplop->nama_bank }}</span>
                            </div>
                            <span class="text-[9.5px] font-bold uppercase tracking-[0.22em] text-[#E6D19C]/85">Syariah Transfer</span>
                        </div>

                        <div class="relative z-10 pt-1">
                            <p class="font-mono text-lg sm:text-xl font-bold tracking-[0.16em] text-white">
                                {{ $amplop->nomor_rekening }}
                            </p>
                            <p class="mt-0.5 text-xs text-[#F7FBF8]/80">a.n. {{ $amplop->atas_nama }}</p>
                        </div>

                        <button
                            type="button"
                            @click="salinRekening(@js($amplop->nomor_rekening), {{ $amplop->id ?? $loop->iteration }})"
                            class="relative z-10 syari-tombol-emas w-full rounded-full py-2.5 text-xs font-bold uppercase tracking-wider transition cursor-pointer"
                        >
                            <span x-text="rekeningTersalin === {{ $amplop->id ?? $loop->iteration }} ? 'Nomor Rekening Tersalin!' : 'Salin Nomor Rekening'"></span>
                        </button>
                    </div>
                @endforeach

                @if ($alamatKado !== '')
                    <div data-gsap="naik" class="rounded-2xl bg-white border border-dashed border-[#C5A059]/75 p-4 text-center space-y-1 shadow-xs">
                        <p class="text-[10px] font-bold uppercase tracking-[0.28em] text-[#9E7D40]">Alamat Kirim Kado</p>
                        <p class="text-xs text-[#0E3A36]/85 leading-relaxed">{{ $alamatKado }}</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif

{{-- SEKSI 10: TURUT MENGUNDANG (PLAKAT KELUARGA BESAR) --}}
@if ($adaTurutMengundang)
    <section data-section-turut-mengundang="mihrab" class="relative px-4 pb-8 overflow-hidden">
        <div class="max-w-md mx-auto overflow-hidden rounded-3xl bg-white border border-[#C5A059]/50 shadow-sm text-center">
            <div class="bg-[#0E3A36]/6 border-b border-[#C5A059]/30 px-5 py-3.5">
                <p data-gsap="turun" class="text-[9.5px] font-bold uppercase tracking-[0.34em] text-[#9E7D40]">Keluarga Besar</p>
                <h2 data-gsap="naik" class="font-serif text-2xl font-bold text-[#0E3A36]">Turut Mengundang</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 divide-y sm:divide-y-0 sm:divide-x divide-[#C5A059]/30 text-xs p-4 gap-3 sm:gap-0">
                @if (! empty($turutPria))
                    <div data-gsap="kiri" class="px-2 space-y-1">
                        <p class="font-bold uppercase tracking-wider text-[#9E7D40] text-[10px]">
                            Pihak {{ $undangan->nama_panggilan_pria }}
                        </p>
                        @foreach ($turutPria as $baris)
                            <p class="text-[#0E3A36]/85">{{ $baris }}</p>
                        @endforeach
                    </div>
                @endif
                @if (! empty($turutWanita))
                    <div data-gsap="kanan" data-gsap-delay="0.06" class="px-2 pt-3 sm:pt-0 space-y-1">
                        <p class="font-bold uppercase tracking-wider text-[#9E7D40] text-[10px]">
                            Pihak {{ $undangan->nama_panggilan_wanita }}
                        </p>
                        @foreach ($turutWanita as $baris)
                            <p class="text-[#0E3A36]/85">{{ $baris }}</p>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif

{{-- SEKSI 11: BUKU TAMU & RSVP (KARTU BERMAHKOTA ZAMRUD) --}}
@if ($undangan->fiturAktif('buku_tamu'))
    <section class="relative px-4 pb-10 overflow-hidden">
        <div class="max-w-md mx-auto overflow-hidden rounded-3xl bg-white border border-[#C5A059]/55 shadow-[0_14px_34px_-16px_rgba(14,58,54,0.28)]">
            <div class="bg-gradient-to-r from-[#0E3A36] via-[#154E48] to-[#0E3A36] px-6 py-4 text-center">
                <p data-gsap="turun" class="text-[9.5px] font-bold uppercase tracking-[0.36em] text-[#E6D19C]">Doa Restu</p>
                <h2 data-gsap="mekar" class="font-serif text-2xl sm:text-3xl font-bold text-white">Buku Tamu &amp; RSVP</h2>
            </div>

            <div data-gsap="naik" class="p-5 sm:p-6 space-y-5">
                @if (! empty($modeDemo))
                    <div x-data="bukuTamuDemo(@js($daftarUcapanAwal), @js($namaTamu))" class="space-y-5">
                        <form @submit.prevent="kirimUcapanDemo()" class="space-y-3.5 text-left">
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#0E3A36]/80">Nama Tamu</label>
                                <input
                                    type="text"
                                    x-model="namaTamu"
                                    required
                                    placeholder="Masukkan nama Anda"
                                    class="mt-1 w-full rounded-xl border border-[#C5A059]/50 bg-[#F7FBF8] px-3.5 py-2.5 text-sm text-[#0E3A36] focus:border-[#0E3A36] focus:outline-none"
                                >
                            </div>
                            <div class="grid gap-3" :class="statusKehadiran === 'hadir' ? 'grid-cols-2' : 'grid-cols-1'">
                                <div>
                                    <label class="block text-[11px] font-bold uppercase tracking-wider text-[#0E3A36]/80">Kehadiran</label>
                                    <select
                                        x-ref="selectKehadiran"
                                        x-model="statusKehadiran"
                                        @change="statusKehadiran = $event.target.value"
                                        class="mt-1 w-full rounded-xl border border-[#C5A059]/50 bg-[#F7FBF8] px-3 py-2.5 text-sm text-[#0E3A36]"
                                    >
                                        <option value="hadir">InsyaAllah Hadir</option>
                                        <option value="ragu">Masih Ragu</option>
                                        <option value="tidak_hadir">Berhalangan</option>
                                    </select>
                                </div>
                                <div x-show="statusKehadiran === 'hadir'" x-cloak>
                                    <label class="block text-[11px] font-bold uppercase tracking-wider text-[#0E3A36]/80">Jumlah</label>
                                    <input
                                        type="number"
                                        x-model.number="jumlahTamu"
                                        min="1"
                                        max="20"
                                        :required="statusKehadiran === 'hadir'"
                                        :disabled="statusKehadiran !== 'hadir'"
                                        class="mt-1 w-full rounded-xl border border-[#C5A059]/50 bg-[#F7FBF8] px-3.5 py-2.5 text-sm text-[#0E3A36]"
                                    >
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#0E3A36]/80">Ucapan &amp; Doa</label>
                                <textarea
                                    x-model="ucapanDoa"
                                    rows="3"
                                    required
                                    placeholder="Tuliskan doa terbaik..."
                                    class="mt-1 w-full rounded-xl border border-[#C5A059]/50 bg-[#F7FBF8] px-3.5 py-2.5 text-sm text-[#0E3A36] focus:border-[#0E3A36] focus:outline-none"
                                ></textarea>
                            </div>
                            <button
                                type="submit"
                                class="syari-tombol w-full rounded-full border border-[#C5A059]/70 py-3 text-xs font-bold uppercase tracking-wider transition cursor-pointer"
                            >
                                Kirim Konfirmasi &amp; Doa
                            </button>
                            <p x-show="pesanGalat" x-cloak x-text="pesanGalat" class="text-xs font-semibold text-rose-700 text-center"></p>
                            <p
                                x-show="pesanSukses"
                                x-cloak
                                x-text="pesanSukses"
                                class="rounded-xl bg-emerald-50 border border-emerald-200 px-3 py-2 text-[11px] font-semibold text-emerald-800 text-center"
                            ></p>
                        </form>

                        <div class="pt-4 border-t border-[#C5A059]/30 space-y-3">
                            <div class="flex items-center justify-between gap-2">
                                <h3 class="font-serif text-base font-bold text-[#0E3A36]">
                                    Doa &amp; Ucapan (<span x-text="daftarUcapan.length">{{ count($daftarUcapanAwal) }}</span>)
                                </h3>
                                <span class="text-[10px] uppercase tracking-wider text-[#9E7D40]">Gulir untuk lainnya</span>
                            </div>
                            <div x-ref="daftarUcapanScroll" data-lenis-prevent class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                                <template x-for="ucapan in daftarUcapan" :key="ucapan.id">
                                    <div
                                        class="rounded-xl bg-[#F7FBF8] border border-l-[3px] border-l-[#C5A059] p-3.5 space-y-1.5 transition"
                                        :class="ucapan.baru ? 'border-[#0E3A36]/55 ring-1 ring-[#0E3A36]/15' : 'border-[#0E3A36]/12'"
                                    >
                                        <div class="flex items-center justify-between gap-2">
                                            <p class="font-bold text-xs text-[#0E3A36]" x-text="ucapan.nama_tamu"></p>
                                            <span
                                                class="shrink-0 rounded-full px-2.5 py-0.5 text-[10px] font-semibold"
                                                :class="kelasStatus(ucapan.status_kehadiran, false, 'bg-[#0E3A36]/10 text-[#0E3A36]')"
                                                x-text="labelStatus(ucapan.status_kehadiran)"
                                            ></span>
                                        </div>
                                        <p class="text-xs text-[#0E3A36]/82 leading-relaxed" x-text="ucapan.ucapan_doa"></p>
                                        <p class="text-[10px] text-[#9E7D40]/90" x-text="ucapan.waktu"></p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                @else
                    @if (! empty($modePratinjau) || ! $undangan->sudahAktifPublik())
                        <div class="rounded-xl bg-[#F7FBF8] border border-[#0E3A36]/20 px-4 py-3 text-center text-xs font-semibold text-[#0E3A36]">
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
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#0E3A36]/80">Nama Tamu</label>
                                <input
                                    type="text"
                                    name="nama_tamu"
                                    value="{{ old('nama_tamu', $namaTamu !== 'Tamu Undangan' ? $namaTamu : '') }}"
                                    required
                                    class="mt-1 w-full rounded-xl border border-[#C5A059]/50 bg-[#F7FBF8] px-3.5 py-2.5 text-sm text-[#0E3A36]"
                                >
                            </div>
                            <div class="grid gap-3" :class="statusKehadiran === 'hadir' ? 'grid-cols-2' : 'grid-cols-1'">
                                <div>
                                    <label class="block text-[11px] font-bold uppercase tracking-wider text-[#0E3A36]/80">Kehadiran</label>
                                    <select
                                        name="status_kehadiran"
                                        x-model="statusKehadiran"
                                        @change="statusKehadiran = $event.target.value"
                                        class="mt-1 w-full rounded-xl border border-[#C5A059]/50 bg-[#F7FBF8] px-3 py-2.5 text-sm text-[#0E3A36]"
                                    >
                                        <option value="hadir" @selected(old('status_kehadiran', 'hadir') === 'hadir')>InsyaAllah Hadir</option>
                                        <option value="ragu" @selected(old('status_kehadiran') === 'ragu')>Masih Ragu</option>
                                        <option value="tidak_hadir" @selected(old('status_kehadiran') === 'tidak_hadir')>Berhalangan</option>
                                    </select>
                                </div>
                                <div x-show="statusKehadiran === 'hadir'" x-cloak>
                                    <label class="block text-[11px] font-bold uppercase tracking-wider text-[#0E3A36]/80">Jumlah</label>
                                    <input
                                        type="number"
                                        name="jumlah_tamu"
                                        value="{{ old('jumlah_tamu', 1) }}"
                                        min="1"
                                        max="20"
                                        :required="statusKehadiran === 'hadir'"
                                        :disabled="statusKehadiran !== 'hadir'"
                                        class="mt-1 w-full rounded-xl border border-[#C5A059]/50 bg-[#F7FBF8] px-3.5 py-2.5 text-sm text-[#0E3A36]"
                                    >
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#0E3A36]/80">Ucapan &amp; Doa</label>
                                <textarea
                                    name="ucapan_doa"
                                    rows="3"
                                    required
                                    placeholder="Tuliskan doa terbaik..."
                                    class="mt-1 w-full rounded-xl border border-[#C5A059]/50 bg-[#F7FBF8] px-3.5 py-2.5 text-sm text-[#0E3A36]"
                                >{{ old('ucapan_doa') }}</textarea>
                            </div>
                            <button
                                type="submit"
                                class="syari-tombol w-full rounded-full border border-[#C5A059]/70 py-3 text-xs font-bold uppercase tracking-wider transition cursor-pointer"
                            >
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
                                <div class="rounded-xl bg-[#F7FBF8] border border-[#0E3A36]/12 border-l-[3px] border-l-[#C5A059] p-3.5 space-y-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="font-bold text-xs text-[#0E3A36]">{{ $ucapan->nama_tamu }}</p>
                                        <span class="rounded-full bg-[#0E3A36]/10 px-2.5 py-0.5 text-[10px] font-semibold text-[#0E3A36]">
                                            {{ str_replace('_', ' ', ucfirst($ucapan->status_kehadiran)) }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-[#0E3A36]/82 leading-relaxed">{{ $ucapan->ucapan_doa }}</p>
                                </div>
                            @empty
                                <p class="text-xs text-[#0E3A36]/60 text-center">Jadilah yang pertama menuliskan doa restu.</p>
                            @endforelse
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif

{{-- SEKSI 12: PENUTUP ALHAMBRA DOME SANCTUARY & FOOTER --}}
<section data-layout-penutup="mihrab" class="relative px-4 pt-2 pb-6 overflow-hidden">
    <div class="relative overflow-hidden max-w-md mx-auto rounded-t-[8.5rem] rounded-b-3xl bg-gradient-to-b from-[#11423D] via-[#0D332F] to-[#08221F] text-[#F7FBF8] border-2 border-[#C5A059]/70 px-6 pt-12 pb-9 text-center shadow-[0_22px_50px_-16px_rgba(14,58,54,0.55)] space-y-4">
        <div aria-hidden="true" class="pointer-events-none absolute inset-2.5 rounded-t-[7.8rem] rounded-b-2xl border border-dashed border-[#E6D19C]/30"></div>

        @if ($urlFotoPenutup)
            <div data-gsap="potret" class="relative z-10 mx-auto w-40 sm:w-44 p-1 rounded-t-full rounded-b-2xl bg-gradient-to-b from-[#E6D19C] to-[#B99348] shadow-lg">
                <img
                    src="{{ $urlFotoPenutup }}"
                    alt="Foto Penutup {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                    class="w-full aspect-[4/5] rounded-t-full rounded-b-xl object-cover object-top"
                >
            </div>
        @endif

        <div class="relative z-10 space-y-3">
            <p data-gsap="mekar" class="text-lg sm:text-xl text-[#F3E5AB] leading-relaxed" style="font-family: 'Amiri', serif;">
                بَارَكَ اللّٰهُ لَكَ وَبَارَكَ عَلَيْكَ وَجَمَعَ بَيْنَكُمَا فِي خَيْرٍ
            </p>
            <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#E6D19C]">Jazakumullahu Khairan</p>
            <p data-gsap="teks" class="text-xs sm:text-sm text-[#F7FBF8]/85 leading-relaxed max-w-xs mx-auto">
                Atas kehadiran dan doa restu Bapak/Ibu/Saudara/i, kami ucapkan terima kasih. Wassalamu&rsquo;alaikum Warahmatullahi Wabarakatuh.
            </p>

            <div class="pt-2">
                <p data-gsap="naik" class="text-[10px] uppercase tracking-[0.28em] text-[#E6D19C]">Kami Yang Berbahagia</p>
                <p data-gsap="mekar" data-gsap-delay="0.06" class="mt-1.5 font-serif text-3xl sm:text-4xl font-bold text-white leading-tight">
                    {{ $undangan->nama_panggilan_pria }}
                    <span class="font-kaligrafi font-normal text-[#E6D19C]">&amp;</span>
                    {{ $undangan->nama_panggilan_wanita }}
                </p>
                <p data-gsap="naik" data-gsap-delay="0.10" class="mt-1.5 text-[10.5px] uppercase tracking-[0.24em] text-[#F3E5AB]">{{ $hashtagPasangan }}</p>
            </div>
        </div>
    </div>
</section>

@include('komponen-undangan.footer-tema', [
    'gelap' => true,
    'warnaOrnamen' => '#D8C082',
    'kelasLatar' => 'bg-gradient-to-b from-[#0E3A36] via-[#0B2D2A] to-[#071E1C] border-t border-[#C5A059]/45',
    'kelasTeks' => 'text-[#F7FBF8]/85',
    'kelasAksen' => 'text-[#F3E5AB]',
    'kelasTombol' => 'bg-white/10 text-[#F3E5AB] border border-[#C5A059]/50 hover:-translate-y-0.5 hover:bg-[#C5A059] hover:text-[#08221F]',
])
