{{-- SEKSI 9: HADIAH & AMPLOP DIGITAL SAFIR-EMAS --}}
@if ($undangan->fiturAktif('amplop_digital') && ($undangan->daftarAmplop->isNotEmpty() || $alamatKado !== ''))
<section class="relative px-4 py-12 overflow-hidden">
    <div class="max-w-md mx-auto rounded-3xl bg-[#132438] border border-[#D9B664]/50 p-6 text-center shadow-2xl space-y-5 efek-shimmer-kartu">
        <div class="space-y-1">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#D9B664]">Tanda Kasih</p>
            <h2 class="font-serif text-3xl font-bold text-[#F3E5AB]">Hadiah Pernikahan</h2>
            <p class="text-xs text-[#E6EEF8]/80 leading-relaxed">
                Doa restu Bapak/Ibu/Saudara/i adalah karunia terindah. Apabila berkenan memberikan tanda kasih, dapat melalui rekening berikut:
            </p>
        </div>

        <div class="space-y-3.5 text-left">
            @foreach ($undangan->daftarAmplop as $amplop)
                <div class="rounded-2xl bg-gradient-to-br from-[#1A304C] via-[#102034] to-[#091322] p-5 border border-[#D9B664]/55 shadow-lg space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="font-serif text-base font-bold text-[#F3E5AB]">{{ $amplop->nama_bank }}</span>
                        <span class="text-[10px] uppercase tracking-widest text-[#D9B664]">Transfer</span>
                    </div>
                    <div>
                        <p class="font-mono text-lg font-bold tracking-[0.16em] text-white">{{ $amplop->nomor_rekening }}</p>
                        <p class="text-xs text-[#E6EEF8]/80 mt-0.5">a.n. {{ $amplop->atas_nama }}</p>
                    </div>
                    <button
                        type="button"
                        @click="salinRekening(@js($amplop->nomor_rekening), {{ $amplop->id ?? $loop->iteration }})"
                        class="celestial-tombol-emas w-full rounded-full py-2 text-xs font-bold uppercase tracking-wider transition cursor-pointer"
                    >
                        <span x-text="rekeningTersalin === {{ $amplop->id ?? $loop->iteration }} ? 'Berhasil Disalin!' : 'Salin Nomor Rekening'"></span>
                    </button>
                </div>
            @endforeach

            @if ($alamatKado !== '')
                <div class="rounded-2xl bg-[#091322]/75 border border-[#D9B664]/35 p-4 text-center space-y-1">
                    <p class="text-[10px] font-bold uppercase tracking-[0.28em] text-[#D9B664]">Alamat Kirim Kado</p>
                    <p class="text-xs text-[#E6EEF8]/85 leading-relaxed">{{ $alamatKado }}</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- SEKSI 10: TURUT MENGUNDANG (OPSIONAL) --}}
@if ($adaTurutMengundang)
<section data-section-turut-mengundang="celestial" class="relative px-4 pb-8 overflow-hidden">
    <div class="max-w-md mx-auto rounded-3xl bg-[#132438] border border-[#D9B664]/45 p-6 text-center shadow-xl space-y-4">
        <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#D9B664]">Keluarga Besar</p>
        <h2 class="font-serif text-2xl font-bold text-[#F3E5AB]">Turut Mengundang</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 text-xs">
            @if (! empty($turutPria))
                <div class="rounded-2xl bg-[#091322]/75 border border-[#D9B664]/30 p-3.5 space-y-1">
                    <p class="font-bold uppercase tracking-wider text-[#D9B664] text-[10px]">Pihak {{ $undangan->nama_panggilan_pria }}</p>
                    @foreach ($turutPria as $baris)
                        <p class="text-[#E6EEF8]/85">{{ $baris }}</p>
                    @endforeach
                </div>
            @endif
            @if (! empty($turutWanita))
                <div class="rounded-2xl bg-[#091322]/75 border border-[#D9B664]/30 p-3.5 space-y-1">
                    <p class="font-bold uppercase tracking-wider text-[#D9B664] text-[10px]">Pihak {{ $undangan->nama_panggilan_wanita }}</p>
                    @foreach ($turutWanita as $baris)
                        <p class="text-[#E6EEF8]/85">{{ $baris }}</p>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- SEKSI 11: BUKU TAMU & RSVP --}}
@if ($undangan->fiturAktif('buku_tamu'))
<section class="relative px-4 py-8 overflow-hidden">
    <div class="max-w-md mx-auto rounded-3xl bg-[#132438] border border-[#D9B664]/50 p-6 shadow-2xl space-y-5">
        <div class="text-center space-y-1">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#D9B664]">Untaian Doa</p>
            <h2 class="font-serif text-3xl font-bold text-[#F3E5AB]">Ucapan &amp; RSVP</h2>
        </div>

        @if (! empty($modeDemo))
            <div class="rounded-2xl bg-[#091322]/75 border border-[#D9B664]/35 px-4 py-3 text-center text-xs font-semibold text-[#F3E5AB]">
                Mode Live Demo — Formulir RSVP &amp; Ucapan aktif penuh setelah undangan dipublikasikan.
            </div>
        @elseif (! empty($modePratinjau) || ! $undangan->sudahAktifPublik())
            <div class="rounded-2xl bg-[#091322]/75 border border-[#D9B664]/35 px-4 py-3 text-center text-xs font-semibold text-[#F3E5AB]">
                Mode Pratinjau — Buku Tamu &amp; RSVP Dikunci
            </div>
        @else
            <form method="POST" action="{{ route('undangan.ucapan', $undangan->slug) }}" class="space-y-3.5 text-left">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D9B664]">Nama Tamu</label>
                    <input type="text" name="nama_tamu" value="{{ old('nama_tamu', $namaTamu !== 'Tamu Undangan' ? $namaTamu : '') }}" required class="mt-1 w-full rounded-xl border border-[#D9B664]/45 bg-[#091322] px-3.5 py-2.5 text-sm text-white">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D9B664]">Kehadiran</label>
                        <select name="status_kehadiran" class="mt-1 w-full rounded-xl border border-[#D9B664]/45 bg-[#091322] px-3 py-2.5 text-sm text-white">
                            <option value="hadir">InsyaAllah Hadir</option>
                            <option value="ragu">Masih Ragu</option>
                            <option value="tidak_hadir">Berhalangan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D9B664]">Jumlah</label>
                        <input type="number" name="jumlah_tamu" value="{{ old('jumlah_tamu', 1) }}" min="1" max="20" required class="mt-1 w-full rounded-xl border border-[#D9B664]/45 bg-[#091322] px-3.5 py-2.5 text-sm text-white">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-[#D9B664]">Ucapan &amp; Doa</label>
                    <textarea name="ucapan_doa" rows="3" required placeholder="Tuliskan doa terbaik untuk mempelai..." class="mt-1 w-full rounded-xl border border-[#D9B664]/45 bg-[#091322] px-3.5 py-2.5 text-sm text-white">{{ old('ucapan_doa') }}</textarea>
                </div>
                <button type="submit" class="celestial-tombol-emas w-full rounded-full py-3 text-xs font-bold uppercase tracking-wider transition cursor-pointer">
                    Kirim Konfirmasi &amp; Doa
                </button>
            </form>
        @endif

        <div class="pt-4 border-t border-[#D9B664]/25 space-y-3">
            <h3 class="font-serif text-base font-bold text-[#F3E5AB]">Doa &amp; Ucapan ({{ $undangan->bukuTamu->count() }})</h3>
            @forelse ($undangan->bukuTamu as $ucapan)
                <div class="rounded-2xl bg-[#091322]/70 border border-[#D9B664]/25 p-3.5 space-y-1">
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
</section>
@endif

{{-- SEKSI 12: KUBAH PENUTUP CELESTIAL & FOOTER --}}
<section
    data-layout-penutup="celestial"
    class="relative px-4 pt-6 pb-12 overflow-hidden"
>
    <div class="fx-scale-in max-w-md mx-auto rounded-t-[10.5rem] rounded-b-3xl bg-[#132438] border-2 border-[#D9B664]/65 px-6 pt-14 pb-10 text-center shadow-2xl space-y-4 efek-shimmer-kartu">
        @if ($urlFotoPenutup)
            <div class="mx-auto w-44 sm:w-48 overflow-hidden rounded-t-[8rem] rounded-b-2xl border-2 border-[#D9B664]/75 shadow-xl">
                <img
                    src="{{ $urlFotoPenutup }}"
                    alt="Foto Penutup {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                    class="w-full aspect-[4/5] object-cover object-top"
                >
            </div>
        @endif

        <p class="text-lg text-[#F3E5AB]" style="font-family: 'Amiri', serif;">
            بَارَكَ اللّٰهُ لَكَ وَبَارَكَ عَلَيْكَ وَجَمَعَ بَيْنَكُمَا فِي خَيْرٍ
        </p>
        <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#D9B664]">Wassalamu&rsquo;alaikum Wr. Wb.</p>
        <p class="text-xs sm:text-sm text-[#E6EEF8]/85 leading-relaxed max-w-xs mx-auto">
            Merupakan kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.
        </p>

        <div class="pt-2">
            <p class="text-[10px] uppercase tracking-[0.28em] text-[#D9B664]/85">Kami Yang Berbahagia</p>
            <p class="mt-1.5 font-kaligrafi text-5xl text-[#F3E5AB] leading-tight">
                {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
            </p>
            <p class="mt-1 text-[11px] uppercase tracking-[0.22em] text-[#E6EEF8]/80">
                {{ $hashtagPasangan }}
            </p>
        </div>
    </div>
</section>

<footer class="bg-[#060D18] text-[#E6EEF8]/75 border-t border-[#D9B664]/30 pt-7 pb-24 px-16 text-center text-xs">
    <img src="{{ asset('logo/logo-ikon-gelap.webp') }}" alt="Logo SesiTemu" class="mx-auto mb-2 h-8 w-8 object-contain">
    <p>Islamic Heavenly Motion oleh <a href="{{ route('beranda') }}" class="font-semibold text-[#D9B664] hover:underline">SesiTemu.id</a></p>
</footer>
