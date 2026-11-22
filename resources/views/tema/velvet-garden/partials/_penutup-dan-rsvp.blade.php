{{-- SEKSI 9: AMPLOP DIGITAL & KADO FISIK KONSERVATORI --}}
@if ($undangan->fiturAktif('amplop_digital') && ($undangan->daftarAmplop->isNotEmpty() || $alamatKado !== ''))
    <section class="relative px-4 py-12 overflow-hidden">
        <div
            class="max-w-md mx-auto rounded-3xl bg-[#FDFBF7] text-[#1F3431] border-2 border-[#C8A464]/65 p-6 text-center shadow-2xl space-y-5 efek-shimmer-kartu">
            <div class="space-y-1">
                <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#7D6027]">Tanda Kasih</p>
                <h2 class="font-serif text-3xl font-bold text-[#132623]">Amplop Digital</h2>
                <p class="text-xs text-[#1F3431]/75 leading-relaxed">
                    Doa restu Bapak/Ibu/Saudara/i merupakan hadiah terindah. Jika berkenan berbagi tanda kasih, dapat
                    melalui:
                </p>
            </div>

            <div class="space-y-3.5 text-left">
                @foreach ($undangan->daftarAmplop as $amplop)
                    <div
                        class="rounded-2xl bg-gradient-to-br from-[#23413D] via-[#172E2B] to-[#0E1E18] p-5 text-[#FDFBF7] border border-[#C8A464]/60 shadow-lg space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="font-serif text-base font-bold text-[#F3DFA2]">{{ $amplop->nama_bank }}</span>
                            <span class="text-[10px] uppercase tracking-widest text-[#EEDAD4]">Transfer</span>
                        </div>
                        <div>
                            <p class="font-mono text-lg font-bold tracking-[0.16em] text-white">
                                {{ $amplop->nomor_rekening }}</p>
                            <p class="text-xs text-[#F4F8F6]/80 mt-0.5">a.n. {{ $amplop->atas_nama }}</p>
                        </div>
                        <button type="button"
                            @click="salinRekening(@js($amplop->nomor_rekening), {{ $amplop->id ?? $loop->iteration }})"
                            class="garden-tombol-emas w-full rounded-full py-2 text-xs font-bold uppercase tracking-wider transition cursor-pointer">
                            <span
                                x-text="rekeningTersalin === {{ $amplop->id ?? $loop->iteration }} ? 'Berhasil Disalin!' : 'Salin Nomor Rekening'"></span>
                        </button>
                    </div>
                @endforeach

                @if ($alamatKado !== '')
                    <div class="rounded-2xl bg-[#132623]/5 border border-[#C8A464]/50 p-4 text-center space-y-1">
                        <p class="text-[10px] font-bold uppercase tracking-[0.28em] text-[#7D6027]">Alamat Kirim Kado
                        </p>
                        <p class="text-xs text-[#1F3431]/85 leading-relaxed">{{ $alamatKado }}</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif

{{-- SEKSI 10: TURUT MENGUNDANG --}}
@if ($adaTurutMengundang)
    <section data-section-turut-mengundang="taman" class="relative px-4 pb-8 overflow-hidden">
        <div
            class="max-w-md mx-auto rounded-3xl bg-[#0E1E18]/90 border border-[#C8A464]/55 p-6 text-center shadow-xl space-y-4">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#EEDAD4]">Keluarga Besar</p>
            <h2 class="font-serif text-2xl font-bold text-white">Turut Mengundang</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 text-xs">
                @if (!empty($turutPria))
                    <div class="rounded-2xl bg-[#132623] border border-[#C8A464]/35 p-3.5 space-y-1">
                        <p class="font-bold uppercase tracking-wider text-[#C8A464] text-[10px]">Pihak
                            {{ $undangan->nama_panggilan_pria }}</p>
                        @foreach ($turutPria as $baris)
                            <p class="text-[#F4F8F6]/85">{{ $baris }}</p>
                        @endforeach
                    </div>
                @endif
                @if (!empty($turutWanita))
                    <div class="rounded-2xl bg-[#132623] border border-[#C8A464]/35 p-3.5 space-y-1">
                        <p class="font-bold uppercase tracking-wider text-[#C8A464] text-[10px]">Pihak
                            {{ $undangan->nama_panggilan_wanita }}</p>
                        @foreach ($turutWanita as $baris)
                            <p class="text-[#F4F8F6]/85">{{ $baris }}</p>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif

{{-- SEKSI 11: GARDEN GUESTBOOK & RSVP --}}
@if ($undangan->fiturAktif('buku_tamu'))
    <section class="relative px-4 py-8 overflow-hidden">
        <div
            class="max-w-md mx-auto rounded-3xl bg-[#FDFBF7] text-[#1F3431] border-2 border-[#C8A464]/65 p-6 shadow-2xl space-y-5">
            <div class="text-center space-y-1">
                <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#7D6027]">Garden Guestbook</p>
                <h2 class="font-serif text-3xl font-bold text-[#132623]">Ucapan &amp; RSVP</h2>
            </div>

            @if (!empty($modeDemo))
                <div x-data="bukuTamuDemo(@js($daftarUcapanAwal), @js($namaTamu))" class="space-y-5">
                    <form @submit.prevent="kirimUcapanDemo()" class="space-y-3.5 text-left">
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#1F3431]/80">Nama Tamu</label>
                            <input type="text" x-model="namaTamu" required placeholder="Masukkan nama Anda"
                                class="mt-1 w-full rounded-xl border border-[#C8A464]/55 bg-white px-3.5 py-2.5 text-sm">
                        </div>
                        <div class="grid gap-3" :class="statusKehadiran === 'hadir' ? 'grid-cols-2' : 'grid-cols-1'">
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#1F3431]/80">Kehadiran</label>
                                <select x-ref="selectKehadiran" x-model="statusKehadiran" @change="statusKehadiran = $event.target.value"
                                    class="mt-1 w-full rounded-xl border border-[#C8A464]/55 bg-white px-3 py-2.5 text-sm">
                                    <option value="hadir">Hadir</option>
                                    <option value="ragu">Masih Ragu</option>
                                    <option value="tidak_hadir">Berhalangan</option>
                                </select>
                            </div>
                            <div x-show="statusKehadiran === 'hadir'" x-cloak>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#1F3431]/80">Jumlah</label>
                                <input type="number" x-model.number="jumlahTamu" min="1" max="20" :required="statusKehadiran === 'hadir'" :disabled="statusKehadiran !== 'hadir'"
                                    class="mt-1 w-full rounded-xl border border-[#C8A464]/55 bg-white px-3.5 py-2.5 text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#1F3431]/80">Ucapan &amp; Doa</label>
                            <textarea x-model="ucapanDoa" rows="3" required placeholder="Tuliskan doa terbaik untuk kedua mempelai..."
                                class="mt-1 w-full rounded-xl border border-[#C8A464]/55 bg-white px-3.5 py-2.5 text-sm"></textarea>
                        </div>
                        <button type="submit"
                            class="garden-tombol-sage w-full rounded-full py-3 text-xs font-bold uppercase tracking-wider transition cursor-pointer">
                            Kirim Konfirmasi &amp; Doa
                        </button>
                        <p x-show="pesanGalat" x-cloak x-text="pesanGalat" class="text-xs font-semibold text-rose-700 text-center"></p>
                        <p x-show="pesanSukses" x-cloak x-text="pesanSukses" class="rounded-xl bg-emerald-50 border border-emerald-200 px-3 py-2 text-[11px] font-semibold text-emerald-800 text-center"></p>
                    </form>

                    <div class="pt-4 border-t border-[#C8A464]/35 space-y-3">
                        <div class="flex items-center justify-between gap-2">
                            <h3 class="font-serif text-base font-bold text-[#132623]">
                                Doa &amp; Ucapan (<span x-text="daftarUcapan.length">{{ count($daftarUcapanAwal) }}</span>)
                            </h3>
                            <span class="text-[10px] uppercase tracking-wider text-[#7D6027]">Gulir untuk lainnya</span>
                        </div>
                        <div x-ref="daftarUcapanScroll" class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                            <template x-for="ucapan in daftarUcapan" :key="ucapan.id">
                                <div
                                    class="rounded-2xl bg-[#132623]/[0.04] border p-3.5 space-y-1.5 transition"
                                    :class="ucapan.baru ? 'border-[#132623]/55 ring-1 ring-[#C8A464]/50' : 'border-[#C8A464]/35'"
                                >
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="font-bold text-xs text-[#132623]" x-text="ucapan.nama_tamu"></p>
                                        <span class="shrink-0 rounded-full px-2.5 py-0.5 text-[10px] font-semibold" :class="kelasStatus(ucapan.status_kehadiran, false, 'bg-[#3E5A5C]/15 text-[#26403E]')" x-text="labelStatus(ucapan.status_kehadiran)"></span>
                                    </div>
                                    <p class="text-xs text-[#1F3431]/80 leading-relaxed" x-text="ucapan.ucapan_doa"></p>
                                    <p class="text-[10px] text-[#7D6027]/80" x-text="ucapan.waktu"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            @else
                @if (!empty($modePratinjau) || !$undangan->sudahAktifPublik())
                    <div
                        class="rounded-2xl bg-[#132623]/5 border border-[#C8A464]/45 px-4 py-3 text-center text-xs font-semibold text-[#132623]">
                        Mode Pratinjau — Buku Tamu &amp; RSVP Dikunci
                    </div>
                @else
                    <form x-data="{ statusKehadiran: @js(old('status_kehadiran', 'hadir')) }" method="POST" action="{{ route('undangan.ucapan', $undangan->slug) }}"
                        class="space-y-3.5 text-left">
                        @csrf
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#1F3431]/80">Nama
                                Tamu</label>
                            <input type="text" name="nama_tamu"
                                value="{{ old('nama_tamu', $namaTamu !== 'Tamu Undangan' ? $namaTamu : '') }}" required
                                class="mt-1 w-full rounded-xl border border-[#C8A464]/55 bg-white px-3.5 py-2.5 text-sm">
                        </div>
                        <div class="grid gap-3" :class="statusKehadiran === 'hadir' ? 'grid-cols-2' : 'grid-cols-1'">
                            <div>
                                <label
                                    class="block text-[11px] font-bold uppercase tracking-wider text-[#1F3431]/80">Kehadiran</label>
                                <select name="status_kehadiran" x-model="statusKehadiran" @change="statusKehadiran = $event.target.value"
                                    class="mt-1 w-full rounded-xl border border-[#C8A464]/55 bg-white px-3 py-2.5 text-sm">
                                    <option value="hadir" @selected(old('status_kehadiran', 'hadir') === 'hadir')>Hadir</option>
                                    <option value="ragu" @selected(old('status_kehadiran') === 'ragu')>Masih Ragu</option>
                                    <option value="tidak_hadir" @selected(old('status_kehadiran') === 'tidak_hadir')>Berhalangan</option>
                                </select>
                            </div>
                            <div x-show="statusKehadiran === 'hadir'" x-cloak>
                                <label
                                    class="block text-[11px] font-bold uppercase tracking-wider text-[#1F3431]/80">Jumlah</label>
                                <input type="number" name="jumlah_tamu" value="{{ old('jumlah_tamu', 1) }}" min="1"
                                    max="20" :required="statusKehadiran === 'hadir'" :disabled="statusKehadiran !== 'hadir'"
                                    class="mt-1 w-full rounded-xl border border-[#C8A464]/55 bg-white px-3.5 py-2.5 text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#1F3431]/80">Ucapan
                                &amp; Doa</label>
                            <textarea name="ucapan_doa" rows="3" required placeholder="Tuliskan doa terbaik untuk kedua mempelai..."
                                class="mt-1 w-full rounded-xl border border-[#C8A464]/55 bg-white px-3.5 py-2.5 text-sm">{{ old('ucapan_doa') }}</textarea>
                        </div>
                        <button type="submit"
                            class="garden-tombol-sage w-full rounded-full py-3 text-xs font-bold uppercase tracking-wider transition cursor-pointer">
                            Kirim Konfirmasi &amp; Doa
                        </button>
                    </form>
                @endif

                <div class="pt-4 border-t border-[#C8A464]/35 space-y-3">
                    <h3 class="font-serif text-base font-bold text-[#132623]">Doa &amp; Ucapan
                        ({{ $undangan->bukuTamu->count() }})</h3>
                    <div class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                        @forelse ($undangan->bukuTamu as $ucapan)
                            <div class="rounded-2xl bg-[#132623]/[0.04] border border-[#C8A464]/35 p-3.5 space-y-1">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="font-bold text-xs text-[#132623]">{{ $ucapan->nama_tamu }}</p>
                                    <span
                                        class="rounded-full bg-[#3E5A5C]/15 px-2.5 py-0.5 text-[10px] font-semibold text-[#26403E]">
                                        {{ str_replace('_', ' ', ucfirst($ucapan->status_kehadiran)) }}
                                    </span>
                                </div>
                                <p class="text-xs text-[#1F3431]/80 leading-relaxed">{{ $ucapan->ucapan_doa }}</p>
                            </div>
                        @empty
                            <p class="text-xs text-[#1F3431]/60 text-center">Jadilah yang pertama memberikan doa restu.</p>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </section>
@endif

{{-- SEKSI 12: KUBAH PENUTUP KONSERVATORI & FOOTER --}}
<section data-layout-penutup="taman" class="relative px-4 pt-6 pb-12 overflow-hidden">
    <div
        class="fx-scale-in max-w-md mx-auto rounded-t-[10.5rem] rounded-b-3xl bg-[#FDFBF7] text-[#1F3431] border-2 border-[#C8A464]/75 px-6 pt-14 pb-10 text-center shadow-2xl space-y-4 efek-shimmer-kartu">
        @if ($urlFotoPenutup)
            <div
                class="mx-auto w-44 sm:w-48 overflow-hidden rounded-t-[8rem] rounded-b-2xl border-2 border-[#C8A464] shadow-xl">
                <img src="{{ $urlFotoPenutup }}"
                    alt="Foto Penutup {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                    class="w-full aspect-[4/5] object-cover object-top">
            </div>
        @endif

        <img src="{{ $asetGarden['botani'] }}" alt="" class="w-12 mx-auto opacity-95 animasi-melayang">
        <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#7D6027]">Terima Kasih</p>
        <p class="text-xs sm:text-sm text-[#1F3431]/80 leading-relaxed max-w-xs mx-auto">
            Atas kehadiran dan doa restu Bapak/Ibu/Saudara/i, kami menghaturkan terima kasih yang sebesar-besarnya.
        </p>

        <div class="pt-2">
            <p class="text-[10px] uppercase tracking-[0.28em] text-[#7D6027]/85">Kami Yang Berbahagia</p>
            <p class="mt-1.5 font-kaligrafi text-5xl text-[#132623] leading-tight">
                {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
            </p>
            <p class="mt-1 text-[11px] uppercase tracking-[0.22em] text-[#3E5A5C]">
                {{ $hashtagPasangan }}
            </p>
        </div>
    </div>
</section>

@include('komponen-undangan.footer-tema', [
    'gelap' => true,
    'warnaOrnamen' => '#C8A464',
    'kelasLatar' => 'bg-gradient-to-b from-[#12261F] via-[#0D1D17] to-[#08130F] border-t border-[#C8A464]/40',
    'kelasTeks' => 'text-[#F4F8F6]/82',
    'kelasAksen' => 'text-[#F3DFA2]',
    'kelasTombol' => 'bg-white/8 text-[#F3DFA2] border border-[#C8A464]/45 hover:-translate-y-0.5 hover:bg-[#C8A464] hover:text-[#0A1712]',
])
