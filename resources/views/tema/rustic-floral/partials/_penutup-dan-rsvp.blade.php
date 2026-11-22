{{-- SEKSI 9: AMPLOP DIGITAL RUSTIC LINEN --}}
@if ($undangan->fiturAktif('amplop_digital') && ($undangan->daftarAmplop->isNotEmpty() || $alamatKado !== ''))
    <section class="relative px-4 py-12 overflow-hidden">
        <div
            class="max-w-md mx-auto rounded-3xl bg-white border border-[#BFA15F]/45 p-6 text-center shadow-lg space-y-5">
            <div class="space-y-1">
                <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#B86B4B]">Tanda Kasih</p>
                <h2 class="font-serif text-3xl font-bold text-[#1F2937]">Amplop Digital</h2>
                <p class="text-xs text-[#1F2937]/75 leading-relaxed">
                    Doa restu Bapak/Ibu/Saudara/i merupakan kado terbaik bagi kami.
                </p>
            </div>

            <div class="space-y-3 text-left">
                @foreach ($undangan->daftarAmplop as $amplop)
                    <div class="rounded-2xl bg-[#4B6358] p-5 text-[#FDFBF7] space-y-2.5 shadow-sm">
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
                            class="w-full rounded-full bg-white py-2 text-xs font-bold uppercase tracking-wider text-[#2F4037] hover:bg-[#FDFBF7] transition cursor-pointer">
                            <span
                                x-text="rekeningTersalin === {{ $amplop->id ?? $loop->iteration }} ? 'Berhasil Disalin!' : 'Salin Nomor Rekening'"></span>
                        </button>
                    </div>
                @endforeach

                @if ($alamatKado !== '')
                    <div class="rounded-2xl bg-[#FDFBF7] border border-[#BFA15F]/35 p-4 text-center space-y-1">
                        <p class="text-[10px] font-bold uppercase tracking-[0.28em] text-[#B86B4B]">Alamat Kirim Kado
                        </p>
                        <p class="text-xs text-[#1F2937]/85 leading-relaxed">{{ $alamatKado }}</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif

{{-- SEKSI 10: TURUT MENGUNDANG --}}
@if ($adaTurutMengundang)
    <section data-section-turut-mengundang="klasik" class="relative px-4 pb-6 overflow-hidden">
        <div class="max-w-md mx-auto rounded-3xl bg-white border border-[#BFA15F]/40 p-5 text-center space-y-3">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#B86B4B]">Keluarga Besar</p>
            <h2 class="font-serif text-2xl font-bold text-[#1F2937]">Turut Mengundang</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                @if (!empty($turutPria))
                    <div class="rounded-xl bg-[#FDFBF7] p-3 space-y-1">
                        <p class="font-bold uppercase tracking-wider text-[#4B6358] text-[10px]">Pihak
                            {{ $undangan->nama_panggilan_pria }}</p>
                        @foreach ($turutPria as $baris)
                            <p class="text-[#1F2937]/80">{{ $baris }}</p>
                        @endforeach
                    </div>
                @endif
                @if (!empty($turutWanita))
                    <div class="rounded-xl bg-[#FDFBF7] p-3 space-y-1">
                        <p class="font-bold uppercase tracking-wider text-[#4B6358] text-[10px]">Pihak
                            {{ $undangan->nama_panggilan_wanita }}</p>
                        @foreach ($turutWanita as $baris)
                            <p class="text-[#1F2937]/80">{{ $baris }}</p>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif

{{-- SEKSI 11: BUKU TAMU & RSVP --}}
@if ($undangan->fiturAktif('buku_tamu'))
    <section class="relative px-4 pb-10 overflow-hidden">
        <div class="max-w-md mx-auto rounded-3xl bg-white border border-[#BFA15F]/45 p-6 shadow-lg space-y-5">
            <div class="text-center space-y-1">
                <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#B86B4B]">Guestbook</p>
                <h2 class="font-serif text-3xl font-bold text-[#1F2937]">Ucapan &amp; RSVP</h2>
            </div>

            @if (!empty($modeDemo))
                <div x-data="bukuTamuDemo(@js($daftarUcapanAwal), @js($namaTamu))" class="space-y-5">
                    <form @submit.prevent="kirimUcapanDemo()" class="space-y-3.5 text-left">
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#1F2937]/80">Nama
                                Tamu</label>
                            <input type="text" x-model="namaTamu" required placeholder="Masukkan nama Anda"
                                class="mt-1 w-full rounded-xl border border-[#BFA15F]/45 bg-[#FDFBF7] px-3.5 py-2.5 text-sm text-[#1F2937]">
                        </div>
                        <div class="grid gap-3" :class="statusKehadiran === 'hadir' ? 'grid-cols-2' : 'grid-cols-1'">
                            <div>
                                <label
                                    class="block text-[11px] font-bold uppercase tracking-wider text-[#1F2937]/80">Kehadiran</label>
                                <select x-ref="selectKehadiran" x-model="statusKehadiran"
                                    @change="statusKehadiran = $event.target.value"
                                    class="mt-1 w-full rounded-xl border border-[#BFA15F]/45 bg-[#FDFBF7] px-3.5 py-2.5 text-sm text-[#1F2937]">
                                    <option value="hadir">Hadir</option>
                                    <option value="ragu">Masih Ragu</option>
                                    <option value="tidak_hadir">Berhalangan</option>
                                </select>
                            </div>
                            <div x-show="statusKehadiran === 'hadir'" x-cloak>
                                <label
                                    class="block text-[11px] font-bold uppercase tracking-wider text-[#1F2937]/80">Jumlah</label>
                                <input type="number" x-model.number="jumlahTamu" min="1" max="20"
                                    :required="statusKehadiran === 'hadir'"
                                    :disabled="statusKehadiran !== 'hadir'"
                                    class="mt-1 w-full rounded-xl border border-[#BFA15F]/45 bg-[#FDFBF7] px-3.5 py-2.5 text-sm text-[#1F2937]">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#1F2937]/80">Ucapan
                                &amp; Doa</label>
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
                                Doa &amp; Ucapan (<span
                                    x-text="daftarUcapan.length">{{ count($daftarUcapanAwal) }}</span>)
                            </h3>
                            <span class="text-[10px] uppercase tracking-wider text-[#4B6358]/75">Gulir untuk
                                lainnya</span>
                        </div>
                        <div x-ref="daftarUcapanScroll"
                            class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                            <template x-for="ucapan in daftarUcapan" :key="ucapan.id">
                                <div class="rounded-2xl bg-[#FDFBF7] border p-3.5 space-y-1.5 transition"
                                    :class="ucapan.baru ? 'border-[#4B6358]/60 ring-1 ring-[#4B6358]/20' : 'border-[#BFA15F]/25'">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="font-bold text-xs text-[#1F2937]" x-text="ucapan.nama_tamu"></p>
                                        <span class="shrink-0 rounded-full px-2.5 py-0.5 text-[10px] font-semibold"
                                            :class="kelasStatus(ucapan.status_kehadiran, false,
                                                'bg-[#4B6358]/10 text-[#4B6358]')"
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
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#1F2937]/80">Nama
                                Tamu</label>
                            <input type="text" name="nama_tamu"
                                value="{{ old('nama_tamu', $namaTamu !== 'Tamu Undangan' ? $namaTamu : '') }}"
                                required
                                class="mt-1 w-full rounded-xl border border-[#BFA15F]/45 bg-[#FDFBF7] px-3.5 py-2.5 text-sm">
                        </div>
                        <div class="grid gap-3"
                            :class="statusKehadiran === 'hadir' ? 'grid-cols-2' : 'grid-cols-1'">
                            <div>
                                <label
                                    class="block text-[11px] font-bold uppercase tracking-wider text-[#1F2937]/80">Kehadiran</label>
                                <select name="status_kehadiran" x-model="statusKehadiran"
                                    @change="statusKehadiran = $event.target.value"
                                    class="mt-1 w-full rounded-xl border border-[#BFA15F]/45 bg-[#FDFBF7] px-3 py-2.5 text-sm">
                                    <option value="hadir" @selected(old('status_kehadiran', 'hadir') === 'hadir')>Hadir</option>
                                    <option value="ragu" @selected(old('status_kehadiran') === 'ragu')>Masih Ragu</option>
                                    <option value="tidak_hadir" @selected(old('status_kehadiran') === 'tidak_hadir')>Berhalangan</option>
                                </select>
                            </div>
                            <div x-show="statusKehadiran === 'hadir'" x-cloak>
                                <label
                                    class="block text-[11px] font-bold uppercase tracking-wider text-[#1F2937]/80">Jumlah</label>
                                <input type="number" name="jumlah_tamu" value="{{ old('jumlah_tamu', 1) }}"
                                    min="1" max="20" :required="statusKehadiran === 'hadir'"
                                    :disabled="statusKehadiran !== 'hadir'"
                                    class="mt-1 w-full rounded-xl border border-[#BFA15F]/45 bg-[#FDFBF7] px-3.5 py-2.5 text-sm">
                            </div>
                        </div>
                        <div>
                            <label
                                class="block text-[11px] font-bold uppercase tracking-wider text-[#1F2937]/80">Ucapan
                                &amp; Doa</label>
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
                    <h3 class="font-serif text-base font-bold text-[#1F2937]">Doa &amp; Ucapan
                        ({{ $undangan->bukuTamu->count() }})</h3>
                    <div class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                        @forelse ($undangan->bukuTamu as $ucapan)
                            <div class="rounded-2xl bg-[#FDFBF7] border border-[#BFA15F]/25 p-3.5 space-y-1">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="font-bold text-xs text-[#1F2937]">{{ $ucapan->nama_tamu }}</p>
                                    <span
                                        class="rounded-full bg-[#4B6358]/10 px-2.5 py-0.5 text-[10px] font-semibold text-[#4B6358]">
                                        {{ str_replace('_', ' ', ucfirst($ucapan->status_kehadiran)) }}
                                    </span>
                                </div>
                                <p class="text-xs text-[#1F2937]/80 leading-relaxed">{{ $ucapan->ucapan_doa }}</p>
                            </div>
                        @empty
                            <p class="text-xs text-[#1F2937]/60 text-center">Jadilah yang pertama memberikan doa restu.
                            </p>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </section>
@endif

{{-- SEKSI 12: PENUTUP LINEN RUSTIC & FOOTER --}}
<section data-layout-penutup="klasik" class="relative px-4 pt-4 pb-6 overflow-hidden">
    <div
        class="fx-scale-in max-w-md mx-auto rounded-t-[10.5rem] rounded-b-3xl bg-[#FDFBF7] border-2 border-[#BFA15F]/55 px-6 pt-14 pb-10 text-center shadow-xl space-y-4">
        @if ($urlFotoPenutup)
            <div
                class="mx-auto w-44 sm:w-48 overflow-hidden rounded-t-[8rem] rounded-b-2xl border-2 border-[#BFA15F]/55 shadow-md">
                <img src="{{ $urlFotoPenutup }}"
                    alt="Foto Penutup {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                    class="w-full aspect-[4/5] object-cover object-top">
            </div>
        @endif

        <img src="{{ $asetRustic['sudut'] }}" alt="" class="w-11 mx-auto opacity-90 animasi-melayang">
        <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#B86B4B]">Terima Kasih</p>
        <p class="text-xs sm:text-sm text-[#1F2937]/80 leading-relaxed max-w-xs mx-auto">
            Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir serta
            memberikan doa restu.
        </p>

        <div class="pt-2">
            <p class="text-[10px] uppercase tracking-[0.28em] text-[#4B6358]">Kami Yang Berbahagia</p>
            <p class="mt-1.5 font-kaligrafi text-5xl text-[#4B6358] leading-tight">
                {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
            </p>
            <p class="mt-1 text-[11px] uppercase tracking-[0.22em] text-[#B86B4B]">{{ $hashtagPasangan }}</p>
        </div>
    </div>
</section>

@include('komponen-undangan.footer-tema', [
    'gelap' => true,
    'warnaOrnamen' => '#D9BE7B',
    'kelasLatar' => 'bg-gradient-to-b from-[#2E4238] via-[#24362D] to-[#1B2922] border-t border-[#D9BE7B]/40',
    'kelasTeks' => 'text-[#F6F1E7]/85',
    'kelasAksen' => 'text-[#E7D094]',
    'kelasTombol' => 'bg-[#FDFBF7]/10 text-[#F3E2B3] border border-[#D9BE7B]/45 hover:-translate-y-0.5 hover:bg-[#D9BE7B] hover:text-[#1B2922]',
])
