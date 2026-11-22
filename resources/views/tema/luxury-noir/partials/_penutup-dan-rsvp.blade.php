{{-- SEKSI 9: SOLITAIRE DIGITAL GIFT CARDS --}}
@if ($undangan->fiturAktif('amplop_digital') && ($undangan->daftarAmplop->isNotEmpty() || $alamatKado !== ''))
<section class="relative px-4 py-12 overflow-hidden">
    <div class="max-w-md mx-auto rounded-xl bg-[#16151B] border border-[#D4AF37]/55 p-6 text-center shadow-2xl space-y-5 efek-shimmer-kartu">
        <div class="space-y-1">
            <p class="text-[10px] font-semibold uppercase tracking-[0.38em] text-[#D4AF37]">Wedding Gift</p>
            <h2 class="noir-font-judul text-2xl sm:text-3xl font-bold text-[#F3E5AB]">Amplop Digital</h2>
            <p class="text-xs text-[#F5EFE6]/75 leading-relaxed">
                Kehadiran Anda adalah kehormatan terbesar. Apabila berkenan mengirimkan tanda kasih, dapat melalui rekening berikut:
            </p>
        </div>

        <div class="space-y-3.5 text-left">
            @foreach ($undangan->daftarAmplop as $amplop)
                <div class="rounded-xl bg-gradient-to-br from-[#23202A] via-[#121118] to-[#09090D] p-5 border border-[#D4AF37]/60 shadow-lg space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="noir-font-judul text-sm font-bold tracking-wider text-[#F3E5AB]">{{ $amplop->nama_bank }}</span>
                        <span class="text-[10px] uppercase tracking-widest text-[#D4AF37]">Solitaire</span>
                    </div>
                    <div>
                        <p class="font-mono text-lg font-bold tracking-[0.16em] text-white">{{ $amplop->nomor_rekening }}</p>
                        <p class="text-xs text-[#F5EFE6]/75 mt-0.5">a.n. {{ $amplop->atas_nama }}</p>
                    </div>
                    <button
                        type="button"
                        @click="salinRekening(@js($amplop->nomor_rekening), {{ $amplop->id ?? $loop->iteration }})"
                        class="noir-tombol-emas w-full rounded-full py-2 text-xs font-bold uppercase tracking-[0.16em] transition cursor-pointer"
                    >
                        <span x-text="rekeningTersalin === {{ $amplop->id ?? $loop->iteration }} ? 'Berhasil Disalin!' : 'Salin Nomor Rekening'"></span>
                    </button>
                </div>
            @endforeach

            @if ($alamatKado !== '')
                <div class="rounded-xl bg-black/60 border border-[#D4AF37]/35 p-4 text-center space-y-1">
                    <p class="text-[10px] font-bold uppercase tracking-[0.28em] text-[#D4AF37]">Gift Delivery Address</p>
                    <p class="text-xs text-[#F5EFE6]/85 leading-relaxed">{{ $alamatKado }}</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- SEKSI 10: TURUT MENGUNDANG --}}
@if ($adaTurutMengundang)
<section data-section-turut-mengundang="artdeco" class="relative px-4 pb-8 overflow-hidden">
    <div class="max-w-md mx-auto rounded-xl bg-[#16151B] border border-[#D4AF37]/45 p-6 text-center shadow-xl space-y-4">
        <p class="text-[10px] font-semibold uppercase tracking-[0.38em] text-[#D4AF37]">With Our Families</p>
        <h2 class="noir-font-judul text-xl font-bold text-[#F3E5AB]">Turut Mengundang</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 text-xs">
            @if (! empty($turutPria))
                <div class="rounded-lg bg-black/55 border border-[#D4AF37]/30 p-3.5 space-y-1">
                    <p class="font-bold uppercase tracking-wider text-[#D4AF37] text-[10px]">Family of {{ $undangan->nama_panggilan_pria }}</p>
                    @foreach ($turutPria as $baris)
                        <p class="text-[#F5EFE6]/85">{{ $baris }}</p>
                    @endforeach
                </div>
            @endif
            @if (! empty($turutWanita))
                <div class="rounded-lg bg-black/55 border border-[#D4AF37]/30 p-3.5 space-y-1">
                    <p class="font-bold uppercase tracking-wider text-[#D4AF37] text-[10px]">Family of {{ $undangan->nama_panggilan_wanita }}</p>
                    @foreach ($turutWanita as $baris)
                        <p class="text-[#F5EFE6]/85">{{ $baris }}</p>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- SEKSI 11: VIP GUESTBOOK & RSVP --}}
@if ($undangan->fiturAktif('buku_tamu'))
<section class="relative px-4 py-8 overflow-hidden">
    <div class="max-w-md mx-auto rounded-xl bg-[#16151B] border border-[#D4AF37]/55 p-6 shadow-2xl space-y-5">
        <div class="text-center space-y-1">
            <p class="text-[10px] font-semibold uppercase tracking-[0.38em] text-[#D4AF37]">VIP Guestbook</p>
            <h2 class="noir-font-judul text-2xl font-bold text-[#F3E5AB]">RSVP &amp; Wishes</h2>
        </div>

        @if (! empty($modeDemo))
            <div x-data="bukuTamuDemo(@js($daftarUcapanAwal), @js($namaTamu))" class="space-y-5">
                <form @submit.prevent="kirimUcapanDemo()" class="space-y-3.5 text-left">
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D4AF37]">Nama Tamu</label>
                        <input type="text" x-model="namaTamu" required placeholder="Masukkan nama Anda" class="mt-1 w-full rounded-lg border border-[#D4AF37]/45 bg-[#0B0B0F] px-3.5 py-2.5 text-sm text-white">
                    </div>
                    <div class="grid gap-3" :class="statusKehadiran === 'hadir' ? 'grid-cols-2' : 'grid-cols-1'">
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D4AF37]">Kehadiran</label>
                            <select x-ref="selectKehadiran" x-model="statusKehadiran" @change="statusKehadiran = $event.target.value" class="mt-1 w-full rounded-lg border border-[#D4AF37]/45 bg-[#0B0B0F] px-3 py-2.5 text-sm text-white">
                                <option value="hadir">Hadir</option>
                                <option value="ragu">Masih Ragu</option>
                                <option value="tidak_hadir">Berhalangan</option>
                            </select>
                        </div>
                        <div x-show="statusKehadiran === 'hadir'" x-cloak>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D4AF37]">Jumlah</label>
                            <input type="number" x-model.number="jumlahTamu" min="1" max="20" :required="statusKehadiran === 'hadir'" :disabled="statusKehadiran !== 'hadir'" class="mt-1 w-full rounded-lg border border-[#D4AF37]/45 bg-[#0B0B0F] px-3.5 py-2.5 text-sm text-white">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D4AF37]">Ucapan &amp; Doa</label>
                        <textarea x-model="ucapanDoa" rows="3" required placeholder="Leave your warm wishes..." class="mt-1 w-full rounded-lg border border-[#D4AF37]/45 bg-[#0B0B0F] px-3.5 py-2.5 text-sm text-white"></textarea>
                    </div>
                    <button type="submit" class="noir-tombol-emas w-full rounded-full py-3 text-xs font-bold uppercase tracking-[0.18em] transition cursor-pointer">
                        Kirim Konfirmasi &amp; Doa
                    </button>
                    <p x-show="pesanGalat" x-cloak x-text="pesanGalat" class="text-xs font-semibold text-rose-300 text-center"></p>
                    <p x-show="pesanSukses" x-cloak x-text="pesanSukses" class="rounded-lg bg-emerald-950/75 border border-emerald-400/40 px-3 py-2 text-[11px] font-semibold text-emerald-200 text-center"></p>
                </form>

                <div class="pt-4 border-t border-[#D4AF37]/25 space-y-3">
                    <div class="flex items-center justify-between gap-2">
                        <h3 class="noir-font-judul text-sm font-bold tracking-wider text-[#F3E5AB]">
                            Wishes (<span x-text="daftarUcapan.length">{{ count($daftarUcapanAwal) }}</span>)
                        </h3>
                        <span class="text-[10px] uppercase tracking-wider text-[#D4AF37]/80">Gulir untuk lainnya</span>
                    </div>
                    <div x-ref="daftarUcapanScroll" class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                        <template x-for="ucapan in daftarUcapan" :key="ucapan.id">
                            <div
                                class="rounded-lg bg-black/60 border p-3.5 space-y-1.5 transition"
                                :class="ucapan.baru ? 'border-[#F3E5AB]/70 ring-1 ring-[#D4AF37]/45' : 'border-[#D4AF37]/25'"
                            >
                                <div class="flex items-center justify-between gap-2">
                                    <p class="font-bold text-xs text-[#F3E5AB]" x-text="ucapan.nama_tamu"></p>
                                    <span class="shrink-0 px-2 py-0.5 text-[10px] font-semibold" :class="kelasStatus(ucapan.status_kehadiran, true, 'border border-[#D4AF37]/35 text-[#D4AF37]')" x-text="labelStatus(ucapan.status_kehadiran)"></span>
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
                <div class="rounded-lg bg-black/60 border border-[#D4AF37]/35 px-4 py-3 text-center text-xs font-semibold text-[#F3E5AB]">
                    Mode Pratinjau — Buku Tamu &amp; RSVP Dikunci
                </div>
            @else
                <form x-data="{ statusKehadiran: @js(old('status_kehadiran', 'hadir')) }" method="POST" action="{{ route('undangan.ucapan', $undangan->slug) }}" class="space-y-3.5 text-left">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D4AF37]">Nama Tamu</label>
                        <input type="text" name="nama_tamu" value="{{ old('nama_tamu', $namaTamu !== 'Tamu Undangan' ? $namaTamu : '') }}" required class="mt-1 w-full rounded-lg border border-[#D4AF37]/45 bg-[#0B0B0F] px-3.5 py-2.5 text-sm text-white">
                    </div>
                    <div class="grid gap-3" :class="statusKehadiran === 'hadir' ? 'grid-cols-2' : 'grid-cols-1'">
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D4AF37]">Kehadiran</label>
                            <select name="status_kehadiran" x-model="statusKehadiran" @change="statusKehadiran = $event.target.value" class="mt-1 w-full rounded-lg border border-[#D4AF37]/45 bg-[#0B0B0F] px-3 py-2.5 text-sm text-white">
                                <option value="hadir" @selected(old('status_kehadiran', 'hadir') === 'hadir')>Hadir</option>
                                <option value="ragu" @selected(old('status_kehadiran') === 'ragu')>Masih Ragu</option>
                                <option value="tidak_hadir" @selected(old('status_kehadiran') === 'tidak_hadir')>Berhalangan</option>
                            </select>
                        </div>
                        <div x-show="statusKehadiran === 'hadir'" x-cloak>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D4AF37]">Jumlah</label>
                            <input type="number" name="jumlah_tamu" value="{{ old('jumlah_tamu', 1) }}" min="1" max="20" :required="statusKehadiran === 'hadir'" :disabled="statusKehadiran !== 'hadir'" class="mt-1 w-full rounded-lg border border-[#D4AF37]/45 bg-[#0B0B0F] px-3.5 py-2.5 text-sm text-white">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D4AF37]">Ucapan &amp; Doa</label>
                        <textarea name="ucapan_doa" rows="3" required placeholder="Leave your warm wishes..." class="mt-1 w-full rounded-lg border border-[#D4AF37]/45 bg-[#0B0B0F] px-3.5 py-2.5 text-sm text-white">{{ old('ucapan_doa') }}</textarea>
                    </div>
                    <button type="submit" class="noir-tombol-emas w-full rounded-full py-3 text-xs font-bold uppercase tracking-[0.18em] transition cursor-pointer">
                        Kirim Konfirmasi &amp; Doa
                    </button>
                </form>
            @endif

            <div class="pt-4 border-t border-[#D4AF37]/25 space-y-3">
                <h3 class="noir-font-judul text-sm font-bold tracking-wider text-[#F3E5AB]">Wishes ({{ $undangan->bukuTamu->count() }})</h3>
                <div class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                    @forelse ($undangan->bukuTamu as $ucapan)
                        <div class="rounded-lg bg-black/55 border border-[#D4AF37]/25 p-3.5 space-y-1">
                            <div class="flex items-center justify-between gap-2">
                                <p class="font-bold text-xs text-[#F3E5AB]">{{ $ucapan->nama_tamu }}</p>
                                <span class="border border-[#D4AF37]/35 px-2 py-0.5 text-[10px] font-semibold text-[#D4AF37]">
                                    {{ str_replace('_', ' ', ucfirst($ucapan->status_kehadiran)) }}
                                </span>
                            </div>
                            <p class="text-xs text-[#F5EFE6]/80 leading-relaxed">{{ $ucapan->ucapan_doa }}</p>
                        </div>
                    @empty
                        <p class="text-xs text-[#F5EFE6]/60 text-center">Be the first to share your blessing.</p>
                    @endforelse
                </div>
            </div>
        @endif
    </div>
</section>
@endif

{{-- SEKSI 12: PENUTUP GALA NOIR & FOOTER --}}
<section
    data-layout-penutup="artdeco"
    class="relative px-4 pt-6 pb-12 overflow-hidden"
>
    <div class="fx-scale-in max-w-md mx-auto rounded-t-[10.5rem] rounded-b-2xl bg-[#16151B] border-2 border-[#D4AF37]/65 px-6 pt-14 pb-10 text-center shadow-2xl space-y-4 efek-shimmer-kartu">
        @if ($urlFotoPenutup)
            <div class="mx-auto w-44 sm:w-48 overflow-hidden rounded-t-[8rem] rounded-b-xl border-2 border-[#D4AF37]/75 shadow-xl">
                <img
                    src="{{ $urlFotoPenutup }}"
                    alt="Foto Penutup {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                    class="w-full aspect-[4/5] object-cover object-top"
                >
            </div>
        @endif

        <img src="{{ $asetNoir['emas'] }}" alt="" class="w-11 mx-auto opacity-90">
        <p class="text-[10px] font-semibold uppercase tracking-[0.38em] text-[#D4AF37]">Thank You</p>
        <p class="text-xs sm:text-sm text-[#F5EFE6]/80 leading-relaxed max-w-xs mx-auto">
            Merupakan kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir merayakan malam bahagia kami.
        </p>

        <div class="pt-2">
            <p class="text-[10px] uppercase tracking-[0.28em] text-[#D4AF37]/85">Kami Yang Berbahagia</p>
            <p class="mt-2 noir-font-judul text-2xl sm:text-3xl font-bold tracking-wider text-[#F3E5AB]">
                {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
            </p>
            <p class="mt-1.5 text-[11px] uppercase tracking-[0.24em] text-[#F5EFE6]/75">
                {{ $hashtagPasangan }}
            </p>
        </div>
    </div>
</section>

@include('komponen-undangan.footer-tema', [
    'gelap' => true,
    'warnaOrnamen' => '#D4AF37',
    'kelasLatar' => 'bg-gradient-to-b from-[#111116] via-[#09090D] to-[#050507] border-t border-[#D4AF37]/40',
    'kelasTeks' => 'text-[#F5EFE6]/82',
    'kelasAksen' => 'text-[#F3E5AB]',
    'kelasTombol' => 'bg-white/6 text-[#F3E5AB] border border-[#D4AF37]/45 hover:-translate-y-0.5 hover:bg-[#D4AF37] hover:text-[#07070A]',
])
