{{-- SEKSI 9: AMPLOP DIGITAL RUSTIC LINEN (INTERAKTIF BUKA-TUTUP) --}}
@if ($undangan->fiturAktif('amplop_digital') && ($undangan->daftarAmplop->isNotEmpty() || $alamatKado !== ''))
    <section class="relative px-4 pt-12 pb-6 overflow-hidden">
        <div
            x-data="{ amplopTerbuka: false }"
            class="max-w-md mx-auto rounded-3xl bg-white/95 border border-[#BFA15F]/50 p-6 text-center shadow-[0_18px_42px_-16px_rgba(47,64,55,0.2)] kartu-3d space-y-5"
        >
            <div class="space-y-1.5">
                <img src="{{ $asetRustic['garland'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async" data-gsap="turun" class="w-32 mx-auto pb-0.5">
                <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#B86B4B]">Tanda Kasih</p>
                <h2 data-gsap="naik" class="font-serif text-3xl font-bold text-[#1F2937]">Amplop Digital</h2>
                <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs text-[#1F2937]/75 leading-relaxed max-w-xs mx-auto">
                    Doa restu Bapak/Ibu/Saudara/i merupakan kado terindah bagi kami. Namun apabila ingin memberikan tanda kasih, dapat disalurkan melalui:
                </p>
            </div>

            <div data-gsap="mekar" data-gsap-delay="0.08">
                <button
                    type="button"
                    @click="amplopTerbuka = !amplopTerbuka"
                    class="rustic-tombol-sage inline-flex items-center justify-center gap-2 rounded-full px-6 py-2.5 text-xs font-bold uppercase tracking-[0.18em] transition cursor-pointer"
                >
                    <svg class="w-4 h-4 text-[#E5D5C0]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect width="20" height="16" x="2" y="4" rx="2"/>
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                    </svg>
                    <span x-text="amplopTerbuka ? 'Tutup Amplop Digital' : 'Buka Amplop Digital'">Buka Amplop Digital</span>
                </button>
            </div>

            <div x-show="amplopTerbuka" x-cloak x-transition.opacity.duration.300ms class="space-y-3 text-left pt-1">
                @foreach ($undangan->daftarAmplop as $amplop)
                    <div class="rounded-2xl bg-gradient-to-br from-[#4B6358] via-[#3A4E45] to-[#2B3B33] border border-[#E5D5C0]/35 p-5 text-[#FDFBF7] space-y-2.5 shadow-md">
                        <div class="flex items-center justify-between">
                            <span class="font-serif text-base font-bold text-[#E5D5C0]">{{ $amplop->nama_bank }}</span>
                            <span class="text-[10px] uppercase tracking-widest text-white/75">Transfer</span>
                        </div>
                        <div>
                            <p class="font-mono text-lg font-bold tracking-[0.14em] text-white">
                                {{ $amplop->nomor_rekening }}</p>
                            <p class="text-xs text-white/80">a.n. {{ $amplop->atas_nama }}</p>
                        </div>
                        <button type="button"
                            @click="salinRekening(@js($amplop->nomor_rekening), {{ $amplop->id ?? $loop->iteration }})"
                            class="w-full rounded-full bg-[#FDFBF7] py-2 text-xs font-bold uppercase tracking-wider text-[#2F4037] hover:bg-white transition cursor-pointer">
                            <span
                                x-text="rekeningTersalin === {{ $amplop->id ?? $loop->iteration }} ? 'Berhasil Disalin!' : 'Salin Nomor Rekening'"></span>
                        </button>
                    </div>
                @endforeach

                @if ($alamatKado !== '')
                    <div class="rounded-2xl bg-[#FDFBF7] border border-[#BFA15F]/40 p-4 text-center space-y-1">
                        <p class="text-[10px] font-bold uppercase tracking-[0.28em] text-[#B86B4B]">Alamat Kirim Kado</p>
                        <p class="text-xs text-[#1F2937]/85 leading-relaxed">{{ $alamatKado }}</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif

{{-- SEKSI 10: BUKU TAMU & RSVP --}}
@if ($undangan->fiturAktif('buku_tamu'))
    <section id="buku-tamu" class="relative px-4 py-6 overflow-hidden">
        <div class="max-w-md mx-auto rounded-3xl bg-white/95 border border-[#BFA15F]/50 p-6 shadow-[0_18px_42px_-16px_rgba(47,64,55,0.2)] space-y-5">
            <div class="text-center space-y-1">
                <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#B86B4B]">Guestbook</p>
                <h2 data-gsap="mekar" class="font-serif text-3xl font-bold text-[#1F2937]">RSVP &amp; Wishes</h2>
                <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs text-[#1F2937]/70">
                    Konfirmasikan kehadiran serta sampaikan doa terbaik bagi kami.
                </p>
            </div>

            @if (!empty($modeDemo))
                <div x-data="bukuTamuDemo(@js($daftarUcapanAwal), @js($namaTamu))" class="space-y-5">
                    <form @submit.prevent="kirimUcapanDemo()" class="space-y-3.5 text-left">
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#1F2937]/80">Nama Tamu</label>
                            <input type="text" x-model="namaTamu" required placeholder="Masukkan nama Anda"
                                class="mt-1 w-full rounded-xl border border-[#BFA15F]/45 bg-[#FDFBF7] px-3.5 py-2.5 text-sm text-[#1F2937]">
                        </div>
                        <div class="grid gap-3" :class="statusKehadiran === 'hadir' ? 'grid-cols-2' : 'grid-cols-1'">
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#1F2937]/80">Kehadiran</label>
                                <select x-ref="selectKehadiran" x-model="statusKehadiran"
                                    @change="statusKehadiran = $event.target.value"
                                    class="mt-1 w-full rounded-xl border border-[#BFA15F]/45 bg-[#FDFBF7] px-3.5 py-2.5 text-sm text-[#1F2937]">
                                    <option value="hadir">Hadir</option>
                                    <option value="ragu">Masih Ragu</option>
                                    <option value="tidak_hadir">Berhalangan</option>
                                </select>
                            </div>
                            <div x-show="statusKehadiran === 'hadir'" x-cloak>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#1F2937]/80">Jumlah</label>
                                <input type="number" x-model.number="jumlahTamu" min="1" max="20"
                                    :required="statusKehadiran === 'hadir'"
                                    :disabled="statusKehadiran !== 'hadir'"
                                    class="mt-1 w-full rounded-xl border border-[#BFA15F]/45 bg-[#FDFBF7] px-3.5 py-2.5 text-sm text-[#1F2937]">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#1F2937]/80">Ucapan &amp; Doa</label>
                            <textarea x-model="ucapanDoa" rows="3" required placeholder="Tuliskan doa terbaik..."
                                class="mt-1 w-full rounded-xl border border-[#BFA15F]/45 bg-[#FDFBF7] px-3.5 py-2.5 text-sm text-[#1F2937]"></textarea>
                        </div>
                        <button type="submit"
                            class="rustic-tombol-sage w-full rounded-full py-3 text-xs font-bold uppercase tracking-wider transition cursor-pointer">
                            Kirim Konfirmasi &amp; Doa
                        </button>
                        <p x-show="pesanGalat" x-cloak x-text="pesanGalat"
                            class="text-xs font-semibold text-rose-700 text-center"></p>
                        <p x-show="pesanSukses" x-cloak x-text="pesanSukses"
                            class="rounded-xl bg-emerald-50 border border-emerald-200 px-3 py-2 text-[11px] font-semibold text-emerald-800 text-center">
                        </p>
                    </form>

                    <div class="pt-4 border-t border-[#BFA15F]/25 space-y-3">
                        <div class="flex items-center justify-between gap-2">
                            <h3 class="font-serif text-base font-bold text-[#1F2937]">
                                Doa &amp; Ucapan (<span x-text="daftarUcapan.length">{{ count($daftarUcapanAwal) }}</span>)
                            </h3>
                            <span class="text-[10px] uppercase tracking-wider text-[#4B6358]/75">Gulir untuk lainnya</span>
                        </div>
                        <div x-ref="daftarUcapanScroll" data-lenis-prevent
                            class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                            <template x-for="ucapan in daftarUcapan" :key="ucapan.id">
                                <div class="rounded-2xl bg-[#FDFBF7] border p-3.5 space-y-1.5 transition"
                                    :class="ucapan.baru ? 'border-[#4B6358]/60 ring-1 ring-[#4B6358]/20' : 'border-[#BFA15F]/25'">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="font-bold text-xs text-[#1F2937]" x-text="ucapan.nama_tamu"></p>
                                        <span class="shrink-0 rounded-full px-2.5 py-0.5 text-[10px] font-semibold"
                                            :class="kelasStatus(ucapan.status_kehadiran, false, 'bg-[#4B6358]/10 text-[#4B6358]')"
                                            x-text="labelStatus(ucapan.status_kehadiran)"></span>
                                    </div>
                                    <p class="text-xs text-[#1F2937]/80 leading-relaxed" x-text="ucapan.ucapan_doa"></p>
                                    <p class="text-[10px] text-[#4B6358]/65" x-text="ucapan.waktu"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            @else
                @if (!empty($modePratinjau) || !$undangan->sudahAktifPublik())
                    <div
                        class="rounded-2xl bg-[#FDFBF7] border border-[#BFA15F]/35 px-4 py-3 text-center text-xs font-semibold text-[#4B6358]">
                        Mode Pratinjau — Buku Tamu &amp; RSVP Dikunci
                    </div>
                @else
                    <form x-data="{ statusKehadiran: @js(old('status_kehadiran', 'hadir')) }" method="POST"
                        action="{{ route('undangan.ucapan', $undangan->slug) }}" class="space-y-3.5 text-left">
                        @csrf
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#1F2937]/80">Nama Tamu</label>
                            <input type="text" name="nama_tamu"
                                value="{{ old('nama_tamu', $namaTamu !== 'Tamu Undangan' ? $namaTamu : '') }}"
                                required
                                class="mt-1 w-full rounded-xl border border-[#BFA15F]/45 bg-[#FDFBF7] px-3.5 py-2.5 text-sm">
                        </div>
                        <div class="grid gap-3"
                            :class="statusKehadiran === 'hadir' ? 'grid-cols-2' : 'grid-cols-1'">
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#1F2937]/80">Kehadiran</label>
                                <select name="status_kehadiran" x-model="statusKehadiran"
                                    @change="statusKehadiran = $event.target.value"
                                    class="mt-1 w-full rounded-xl border border-[#BFA15F]/45 bg-[#FDFBF7] px-3.5 py-2.5 text-sm">
                                    <option value="hadir" @selected(old('status_kehadiran', 'hadir') === 'hadir')>Hadir</option>
                                    <option value="ragu" @selected(old('status_kehadiran') === 'ragu')>Masih Ragu</option>
                                    <option value="tidak_hadir" @selected(old('status_kehadiran') === 'tidak_hadir')>Berhalangan</option>
                                </select>
                            </div>
                            <div x-show="statusKehadiran === 'hadir'" x-cloak>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#1F2937]/80">Jumlah</label>
                                <input type="number" name="jumlah_tamu" value="{{ old('jumlah_tamu', 1) }}"
                                    min="1" max="20" :required="statusKehadiran === 'hadir'"
                                    :disabled="statusKehadiran !== 'hadir'"
                                    class="mt-1 w-full rounded-xl border border-[#BFA15F]/45 bg-[#FDFBF7] px-3.5 py-2.5 text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#1F2937]/80">Ucapan &amp; Doa</label>
                            <textarea name="ucapan_doa" rows="3" required placeholder="Tuliskan doa terbaik..."
                                class="mt-1 w-full rounded-xl border border-[#BFA15F]/45 bg-[#FDFBF7] px-3.5 py-2.5 text-sm">{{ old('ucapan_doa') }}</textarea>
                        </div>
                        <button type="submit"
                            class="rustic-tombol-sage w-full rounded-full py-3 text-xs font-bold uppercase tracking-wider transition cursor-pointer">
                            Kirim Konfirmasi &amp; Doa
                        </button>
                    </form>
                @endif

                <div class="pt-4 border-t border-[#BFA15F]/25 space-y-3">
                    <h3 class="font-serif text-base font-bold text-[#1F2937]">Doa &amp; Ucapan ({{ $undangan->bukuTamu->count() }})</h3>
                    <div data-lenis-prevent class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                        @forelse ($undangan->bukuTamu as $ucapan)
                            <div class="rounded-2xl bg-[#FDFBF7] border border-[#BFA15F]/25 p-3.5 space-y-1">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="font-bold text-xs text-[#1F2937]">{{ $ucapan->nama_tamu }}</p>
                                    <span class="rounded-full bg-[#4B6358]/10 px-2.5 py-0.5 text-[10px] font-semibold text-[#4B6358]">
                                        {{ str_replace('_', ' ', ucfirst($ucapan->status_kehadiran)) }}
                                    </span>
                                </div>
                                <p class="text-xs text-[#1F2937]/80 leading-relaxed">{{ $ucapan->ucapan_doa }}</p>
                            </div>
                        @empty
                            <p class="text-xs text-[#1F2937]/60 text-center">Jadilah yang pertama memberikan doa restu.</p>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </section>
@endif

{{-- SEKSI 11: DOA UNTUK PENGANTIN & TURUT MENGUNDANG --}}
<section class="relative px-4 py-6 space-y-6 overflow-hidden">
    {{-- Kartu Doa Untuk Pengantin --}}
    <div data-section-doa-pengantin="klasik" class="max-w-md mx-auto rounded-3xl bg-[#FDFBF7] border border-[#BFA15F]/55 p-6 text-center shadow-lg kartu-3d space-y-3.5">
        <div data-gsap="turun">
            <img src="{{ $asetRustic['garland'] }}" alt="" loading="lazy" decoding="async" class="w-36 mx-auto opacity-95 animasi-melayang">
        </div>
        <p data-gsap="mekar" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#B86B4B]">Doa Restu</p>
        <h2 data-gsap="naik" class="font-serif text-2xl sm:text-[1.75rem] font-bold text-[#2F4037]">Doa Untuk Pengantin</h2>
        <p data-gsap="teks" data-gsap-delay="0.06" class="font-serif italic text-sm sm:text-[15px] text-[#4B6358] leading-relaxed">
            &ldquo;B&#257;rakall&#257;hu laka wa b&#257;raka &lsquo;alaika wa jama&lsquo;a bainakum&#257; f&#299; khair.&rdquo;
        </p>
        <div data-gsap="garis" class="flex items-center justify-center gap-3 px-10" aria-hidden="true">
            <span class="h-px flex-1 bg-[#BFA15F]/50"></span>
            <span class="w-1.5 h-1.5 rotate-45 bg-[#B86B4B]"></span>
            <span class="h-px flex-1 bg-[#BFA15F]/50"></span>
        </div>
        <p data-gsap="teks" data-gsap-delay="0.1" class="text-xs text-[#1F2937]/75 leading-relaxed">
            Semoga Allah memberkahi kalian berdua di kala suka maupun duka, serta senantiasa menghimpun kalian dalam kebaikan, ketenteraman, dan kasih sayang hingga akhir hayat.
        </p>
    </div>

    {{-- Kartu Turut Mengundang (Harmoni Forest-Sage) --}}
    @if ($adaTurutMengundang)
        <div data-section-turut-mengundang="klasik" class="max-w-md mx-auto rounded-3xl bg-gradient-to-b from-[#3E5349] to-[#2C3D35] border border-[#E5D5C0]/35 p-6 text-center text-[#FDFBF7] shadow-lg kartu-3d space-y-4">
            <div class="space-y-1">
                <img src="{{ $asetRustic['garland'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async" data-gsap="turun" class="w-32 mx-auto pb-0.5 drop-shadow">
                <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#E5D5C0]">Keluarga Besar</p>
                <h2 data-gsap="naik" class="font-serif text-2xl font-bold text-white">Turut Mengundang</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                @if (!empty($turutPria))
                    <div data-gsap="kiri" class="rounded-2xl bg-[#FDFBF7]/10 border border-[#E5D5C0]/25 p-3.5 space-y-1">
                        <p class="font-bold uppercase tracking-wider text-[#E5D5C0] text-[10px] pb-1 border-b border-[#E5D5C0]/20">Pihak {{ $undangan->nama_panggilan_pria }}</p>
                        @foreach ($turutPria as $baris)
                            <p class="text-[#FDFBF7]/90 leading-relaxed">{{ $baris }}</p>
                        @endforeach
                    </div>
                @endif
                @if (!empty($turutWanita))
                    <div data-gsap="kanan" data-gsap-delay="0.06" class="rounded-2xl bg-[#FDFBF7]/10 border border-[#E5D5C0]/25 p-3.5 space-y-1">
                        <p class="font-bold uppercase tracking-wider text-[#E5D5C0] text-[10px] pb-1 border-b border-[#E5D5C0]/20">Pihak {{ $undangan->nama_panggilan_wanita }}</p>
                        @foreach ($turutWanita as $baris)
                            <p class="text-[#FDFBF7]/90 leading-relaxed">{{ $baris }}</p>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif
</section>

{{-- SEKSI 12: PENUTUP LINEN RUSTIC BERBINGKAI HAMPARAN BUNGA DI ATAS FOOTER --}}
<section
    data-layout-penutup="klasik"
    class="relative bg-gradient-to-b from-[#F4ECE1] via-[#EFE5D6] to-[#E7D9C4] px-4 pt-6 pb-5 overflow-hidden"
>
    <div
        class="relative z-10 max-w-md mx-auto rounded-t-[10.5rem] rounded-b-[2rem] bg-[#FDFBF7] border-2 border-[#BFA15F]/60 px-6 pt-12 pb-32 sm:pb-36 text-center shadow-[0_24px_52px_-16px_rgba(47,64,55,0.26)] space-y-4 overflow-hidden kartu-3d">
        {{-- Garis Lengkung Halus Bingkai Dalam Kartu Penutup --}}
        <div
            aria-hidden="true"
            class="pointer-events-none absolute inset-2.5 rounded-t-[9.75rem] rounded-b-[1.45rem] border border-[#BFA15F]/35"
        ></div>

        <div class="relative z-10 space-y-4">
            @if ($urlFotoPenutup)
                <div data-gsap="potret" class="relative mx-auto w-[224px] sm:w-[242px] aspect-[780/960] flex items-center justify-center">
                    <div class="absolute inset-x-[12.5%] top-[8.5%] bottom-[11.5%] rounded-t-[10rem] rounded-b-[1.35rem] overflow-hidden bg-[#2F4037] shadow-md">
                        <img src="{{ $urlFotoPenutup }}"
                            alt="Foto Penutup {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                            loading="lazy"
                            decoding="async"
                            class="w-full h-full object-cover object-top">
                    </div>
                    <img
                        src="{{ $asetRustic['bingkaiMempelai'] }}"
                        alt=""
                        aria-hidden="true"
                        loading="lazy"
                        decoding="async"
                        class="pointer-events-none relative z-10 w-full h-full object-contain drop-shadow-[0_8px_18px_rgba(47,64,55,0.2)]"
                    >
                </div>
            @else
                <div data-gsap="potret" class="relative mx-auto w-[196px] sm:w-[210px] aspect-[780/960] flex items-center justify-center">
                    <div class="absolute inset-x-[12.5%] top-[8.5%] bottom-[11.5%] rounded-t-[10rem] rounded-b-[1.35rem] overflow-hidden bg-gradient-to-b from-[#4B6358] via-[#3A4E45] to-[#26352E] text-[#FDFBF7] flex flex-col items-center justify-center gap-1 shadow-md">
                        <span class="text-[9px] uppercase tracking-[0.28em] text-[#E5D5C0]">Terima Kasih</span>
                        <span class="font-serif text-4xl font-bold tracking-wider text-[#F3E5AB]">
                            {{ $undangan->inisialPria() }} &amp; {{ $undangan->inisialWanita() }}
                        </span>
                    </div>
                    <img
                        src="{{ $asetRustic['bingkaiMempelai'] }}"
                        alt=""
                        aria-hidden="true"
                        loading="lazy"
                        decoding="async"
                        class="pointer-events-none relative z-10 w-full h-full object-contain drop-shadow-[0_8px_18px_rgba(47,64,55,0.2)]"
                    >
                </div>
            @endif

            <div data-gsap="turun">
                <img src="{{ $asetRustic['garland'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async" class="w-28 mx-auto opacity-95 animasi-melayang">
            </div>
            <p data-gsap="mekar" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#B86B4B]">Terima Kasih</p>
            <p data-gsap="teks" class="text-xs sm:text-sm text-[#1F2937]/80 leading-relaxed max-w-xs mx-auto">
                Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir serta
                memberikan doa restu.
            </p>

            <div data-gsap="garis" class="flex items-center justify-center gap-3 px-10 pt-0.5" aria-hidden="true">
                <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#BFA15F]/55"></span>
                <span class="w-1.5 h-1.5 rotate-45 bg-[#B86B4B]"></span>
                <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#BFA15F]/55"></span>
            </div>

            <div class="pt-1">
                <p data-gsap="naik" class="text-[10px] uppercase tracking-[0.28em] text-[#4B6358]">Kami Yang Berbahagia</p>
                <p data-gsap="mekar" data-gsap-delay="0.06" class="mt-1.5 font-kaligrafi text-5xl text-[#4B6358] leading-tight">
                    {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
                </p>
                <p data-gsap="naik" data-gsap-delay="0.10" class="mt-1 text-[11px] uppercase tracking-[0.22em] text-[#B86B4B]">{{ $hashtagPasangan }}</p>
            </div>
        </div>
    </div>

    {{-- Hamparan Frame Bunga Cat Air Menyatukan Tepi Bawah Ucapan Penutup Tepat Di Atas Footer --}}
    <img
        src="{{ $asetRustic['bungaPenutup'] }}"
        alt=""
        aria-hidden="true"
        loading="lazy"
        decoding="async"
        class="pointer-events-none absolute -bottom-1 inset-x-0 w-full z-20 drop-shadow-[0_-8px_18px_rgba(35,51,43,0.28)]"
    >
</section>

@include('komponen-undangan.footer-tema', [
    'gelap' => true,
    'warnaOrnamen' => '#D9BE7B',
    'kelasLatar' => 'bg-gradient-to-b from-[#2E4238] via-[#24362D] to-[#1B2922] border-t border-[#D9BE7B]/40',
    'kelasTeks' => 'text-[#F6F1E7]/85',
    'kelasAksen' => 'text-[#E7D094]',
    'kelasTombol' => 'bg-[#FDFBF7]/10 text-[#F3E2B3] border border-[#D9BE7B]/45 hover:-translate-y-0.5 hover:bg-[#D9BE7B] hover:text-[#1B2922]',
])
