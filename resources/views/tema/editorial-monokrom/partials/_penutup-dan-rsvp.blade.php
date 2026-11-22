{{-- SEKSI 9: WEDDING REGISTRY / AMPLOP DIGITAL TAJAM --}}
@if ($undangan->fiturAktif('amplop_digital') && ($undangan->daftarAmplop->isNotEmpty() || $alamatKado !== ''))
<section class="relative bg-[#FAF9F6] px-5 py-12 overflow-hidden">
    <div class="max-w-md mx-auto bg-white border border-[#18181B] p-6 text-left space-y-5">
        <div class="border-b border-[#18181B]/20 pb-3">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#52525B]">05 / Gift Registry</p>
            <h2 class="mt-1 ed-serif text-3xl uppercase text-[#18181B]">Amplop Digital</h2>
        </div>

        <div class="space-y-3.5">
            @foreach ($undangan->daftarAmplop as $amplop)
                <div class="bg-[#18181B] text-white p-5 space-y-3">
                    <div class="flex items-center justify-between text-[10px] uppercase tracking-[0.28em] text-white/65">
                        <span>{{ $amplop->nama_bank }}</span>
                        <span>WIRE TRANSFER</span>
                    </div>
                    <div>
                        <p class="font-mono text-lg font-bold tracking-[0.16em] text-white">{{ $amplop->nomor_rekening }}</p>
                        <p class="text-xs text-white/75 mt-0.5">{{ $amplop->atas_nama }}</p>
                    </div>
                    <button
                        type="button"
                        @click="salinRekening(@js($amplop->nomor_rekening), {{ $amplop->id ?? $loop->iteration }})"
                        class="w-full bg-white text-[#18181B] py-2 text-[11px] font-bold uppercase tracking-[0.22em] hover:bg-neutral-200 transition cursor-pointer"
                    >
                        <span x-text="rekeningTersalin === {{ $amplop->id ?? $loop->iteration }} ? 'Berhasil Disalin!' : 'Salin Nomor Rekening'"></span>
                    </button>
                </div>
            @endforeach

            @if ($alamatKado !== '')
                <div class="border border-[#18181B]/25 bg-[#FAF9F6] p-4 space-y-1">
                    <p class="text-[10px] font-bold uppercase tracking-[0.28em] text-[#52525B]">Gift Shipping Address</p>
                    <p class="text-xs text-[#18181B]/85 leading-relaxed">{{ $alamatKado }}</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- SEKSI 10: TURUT MENGUNDANG --}}
@if ($adaTurutMengundang)
<section data-section-turut-mengundang="editorial" class="relative bg-[#FAF9F6] px-5 pb-6 overflow-hidden">
    <div class="max-w-md mx-auto bg-white border border-[#18181B]/30 p-6 text-left space-y-4">
        <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#52525B]">Families</p>
        <h2 class="ed-serif text-2xl uppercase text-[#18181B]">Turut Mengundang</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs border-t border-[#18181B]/20 pt-4">
            @if (! empty($turutPria))
                <div class="space-y-1">
                    <p class="font-bold uppercase tracking-widest text-[#18181B] text-[10px]">{{ $undangan->nama_panggilan_pria }}</p>
                    @foreach ($turutPria as $baris)
                        <p class="text-[#52525B]">{{ $baris }}</p>
                    @endforeach
                </div>
            @endif
            @if (! empty($turutWanita))
                <div class="space-y-1">
                    <p class="font-bold uppercase tracking-widest text-[#18181B] text-[10px]">{{ $undangan->nama_panggilan_wanita }}</p>
                    @foreach ($turutWanita as $baris)
                        <p class="text-[#52525B]">{{ $baris }}</p>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- SEKSI 11: MINIMALIST EDITORIAL RSVP --}}
@if ($undangan->fiturAktif('buku_tamu'))
<section class="relative bg-[#FAF9F6] px-5 py-8 overflow-hidden">
    <div class="max-w-md mx-auto bg-white border border-[#18181B] p-6 text-left space-y-5">
        <div class="border-b border-[#18181B]/20 pb-3">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#52525B]">06 / Attendance</p>
            <h2 class="mt-1 ed-serif text-3xl uppercase text-[#18181B]">RSVP &amp; Notes</h2>
        </div>

        @if (! empty($modeDemo))
            <div x-data="bukuTamuDemo(@js($daftarUcapanAwal), @js($namaTamu))" class="space-y-5">
                <form @submit.prevent="kirimUcapanDemo()" class="space-y-3.5">
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-[0.26em] text-[#52525B]">Nama Tamu</label>
                        <input type="text" x-model="namaTamu" required placeholder="Masukkan nama Anda" class="mt-1 w-full rounded-none border border-[#18181B]/35 bg-[#FAF9F6] px-3.5 py-2.5 text-sm">
                    </div>
                    <div class="grid gap-3" :class="statusKehadiran === 'hadir' ? 'grid-cols-2' : 'grid-cols-1'">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-[0.26em] text-[#52525B]">Kehadiran</label>
                            <select x-ref="selectKehadiran" x-model="statusKehadiran" @change="statusKehadiran = $event.target.value" class="mt-1 w-full rounded-none border border-[#18181B]/35 bg-[#FAF9F6] px-3 py-2.5 text-sm">
                                <option value="hadir">Hadir</option>
                                <option value="ragu">Masih Ragu</option>
                                <option value="tidak_hadir">Berhalangan</option>
                            </select>
                        </div>
                        <div x-show="statusKehadiran === 'hadir'" x-cloak>
                            <label class="block text-[10px] font-bold uppercase tracking-[0.26em] text-[#52525B]">Jumlah</label>
                            <input type="number" x-model.number="jumlahTamu" min="1" max="20" :required="statusKehadiran === 'hadir'" :disabled="statusKehadiran !== 'hadir'" class="mt-1 w-full rounded-none border border-[#18181B]/35 bg-[#FAF9F6] px-3.5 py-2.5 text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-[0.26em] text-[#52525B]">Ucapan &amp; Doa</label>
                        <textarea x-model="ucapanDoa" rows="3" required placeholder="Write your wishes..." class="mt-1 w-full rounded-none border border-[#18181B]/35 bg-[#FAF9F6] px-3.5 py-2.5 text-sm"></textarea>
                    </div>
                    <button type="submit" class="w-full rounded-none bg-[#18181B] text-white py-3 text-xs font-bold uppercase tracking-[0.26em] hover:bg-[#3F3F46] transition cursor-pointer">
                        Kirim Konfirmasi &amp; Doa
                    </button>
                    <p x-show="pesanGalat" x-cloak x-text="pesanGalat" class="text-xs font-semibold text-rose-700"></p>
                    <p x-show="pesanSukses" x-cloak x-text="pesanSukses" class="rounded-none border border-[#18181B]/30 bg-[#FAF9F6] px-3 py-2 text-[11px] font-semibold text-[#18181B]"></p>
                </form>

                <div class="pt-4 border-t border-[#18181B]/20 space-y-3">
                    <div class="flex items-center justify-between gap-2">
                        <h3 class="text-[11px] font-bold uppercase tracking-[0.26em] text-[#18181B]">
                            Guest Notes (<span x-text="daftarUcapan.length">{{ count($daftarUcapanAwal) }}</span>)
                        </h3>
                        <span class="text-[9px] uppercase tracking-[0.22em] text-[#52525B]">Scroll</span>
                    </div>
                    <div x-ref="daftarUcapanScroll" class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                        <template x-for="ucapan in daftarUcapan" :key="ucapan.id">
                            <div
                                class="rounded-none border bg-[#FAF9F6] p-3.5 space-y-1.5 transition"
                                :class="ucapan.baru ? 'border-[#18181B]' : 'border-[#18181B]/15'"
                            >
                                <div class="flex items-center justify-between gap-2">
                                    <p class="font-bold text-xs text-[#18181B]" x-text="ucapan.nama_tamu"></p>
                                    <span class="shrink-0 rounded-none px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider" :class="kelasStatus(ucapan.status_kehadiran, false, 'border border-[#18181B]/30 text-[#52525B]')" x-text="labelStatus(ucapan.status_kehadiran)"></span>
                                </div>
                                <p class="text-xs text-[#52525B] leading-relaxed" x-text="ucapan.ucapan_doa"></p>
                                <p class="text-[10px] uppercase tracking-wider text-[#52525B]/75" x-text="ucapan.waktu"></p>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        @else
            @if (! empty($modePratinjau) || ! $undangan->sudahAktifPublik())
                <div class="border border-[#18181B]/25 bg-[#FAF9F6] px-4 py-3 text-xs font-semibold text-[#18181B]">
                    Mode Pratinjau — Buku Tamu &amp; RSVP Dikunci
                </div>
            @else
                <form x-data="{ statusKehadiran: @js(old('status_kehadiran', 'hadir')) }" method="POST" action="{{ route('undangan.ucapan', $undangan->slug) }}" class="space-y-3.5">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-[0.26em] text-[#52525B]">Nama Tamu</label>
                        <input type="text" name="nama_tamu" value="{{ old('nama_tamu', $namaTamu !== 'Tamu Undangan' ? $namaTamu : '') }}" required class="mt-1 w-full rounded-none border border-[#18181B]/35 bg-[#FAF9F6] px-3.5 py-2.5 text-sm">
                    </div>
                    <div class="grid gap-3" :class="statusKehadiran === 'hadir' ? 'grid-cols-2' : 'grid-cols-1'">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-[0.26em] text-[#52525B]">Kehadiran</label>
                            <select name="status_kehadiran" x-model="statusKehadiran" @change="statusKehadiran = $event.target.value" class="mt-1 w-full rounded-none border border-[#18181B]/35 bg-[#FAF9F6] px-3 py-2.5 text-sm">
                                <option value="hadir" @selected(old('status_kehadiran', 'hadir') === 'hadir')>Hadir</option>
                                <option value="ragu" @selected(old('status_kehadiran') === 'ragu')>Masih Ragu</option>
                                <option value="tidak_hadir" @selected(old('status_kehadiran') === 'tidak_hadir')>Berhalangan</option>
                            </select>
                        </div>
                        <div x-show="statusKehadiran === 'hadir'" x-cloak>
                            <label class="block text-[10px] font-bold uppercase tracking-[0.26em] text-[#52525B]">Jumlah</label>
                            <input type="number" name="jumlah_tamu" value="{{ old('jumlah_tamu', 1) }}" min="1" max="20" :required="statusKehadiran === 'hadir'" :disabled="statusKehadiran !== 'hadir'" class="mt-1 w-full rounded-none border border-[#18181B]/35 bg-[#FAF9F6] px-3.5 py-2.5 text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-[0.26em] text-[#52525B]">Ucapan &amp; Doa</label>
                        <textarea name="ucapan_doa" rows="3" required placeholder="Write your wishes..." class="mt-1 w-full rounded-none border border-[#18181B]/35 bg-[#FAF9F6] px-3.5 py-2.5 text-sm">{{ old('ucapan_doa') }}</textarea>
                    </div>
                    <button type="submit" class="w-full rounded-none bg-[#18181B] text-white py-3 text-xs font-bold uppercase tracking-[0.26em] hover:bg-[#3F3F46] transition cursor-pointer">
                        Kirim Konfirmasi &amp; Doa
                    </button>
                </form>
            @endif

            <div class="pt-4 border-t border-[#18181B]/20 space-y-3">
                <h3 class="text-[11px] font-bold uppercase tracking-[0.26em] text-[#18181B]">Guest Notes ({{ $undangan->bukuTamu->count() }})</h3>
                <div class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                    @forelse ($undangan->bukuTamu as $ucapan)
                        <div class="border border-[#18181B]/15 bg-[#FAF9F6] p-3.5 space-y-1">
                            <div class="flex items-center justify-between gap-2">
                                <p class="font-bold text-xs text-[#18181B]">{{ $ucapan->nama_tamu }}</p>
                                <span class="border border-[#18181B]/30 px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider text-[#52525B]">
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
</section>
@endif

{{-- SEKSI 12: EDITORIAL COLOPHON PENUTUP & FOOTER --}}
<section
    data-layout-penutup="editorial"
    class="relative bg-[#111113] text-[#FAF9F6] px-5 py-12 overflow-hidden"
>
    <div class="fx-scale-in max-w-md mx-auto border border-white/25 p-6 text-center space-y-5">
        @if ($urlFotoPenutup)
            <div class="mx-auto w-48 border border-white/30 p-1 bg-black">
                <img src="{{ $urlFotoPenutup }}" alt="Foto Penutup {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}" class="w-full aspect-[4/5] object-cover object-top grayscale">
            </div>
        @endif

        <p class="text-[10px] font-bold uppercase tracking-[0.36em] text-white/60">Fin &bull; Colophon</p>
        <p class="text-xs text-white/80 leading-relaxed max-w-xs mx-auto">
            Merupakan kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir merayakan hari bahagia kami.
        </p>

        <div class="border-t border-white/20 pt-4">
            <p class="text-[10px] uppercase tracking-[0.3em] text-white/60">Kami Yang Berbahagia</p>
            <p class="mt-2 ed-serif text-3xl uppercase tracking-[0.12em] text-white">
                {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
            </p>
            <p class="mt-1.5 text-[10px] uppercase tracking-[0.26em] text-white/65">{{ $hashtagPasangan }}</p>
        </div>
    </div>
</section>

@include('komponen-undangan.footer-tema', [
    'gelap' => true,
    'sudutTajam' => true,
    'warnaOrnamen' => '#FFFFFF',
    'kelasLatar' => 'bg-gradient-to-b from-[#141418] via-[#0C0C0F] to-[#060608] border-t border-white/25',
    'kelasTeks' => 'text-white/78',
    'kelasAksen' => 'text-white',
    'kelasTombol' => 'bg-white/6 text-white/90 border border-white/30 hover:-translate-y-0.5 hover:bg-white hover:text-[#0A0A0C]',
])
