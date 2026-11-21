{{-- SEKSI 9: AMPLOP DIGITAL SYAR'I --}}
@if ($undangan->fiturAktif('amplop_digital') && ($undangan->daftarAmplop->isNotEmpty() || $alamatKado !== ''))
<section class="relative px-4 pb-10 overflow-hidden">
    <div class="max-w-md mx-auto rounded-2xl bg-white border border-[#184D47]/20 p-6 text-center shadow-sm space-y-5">
        <div class="space-y-1">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7D40]">Tanda Kasih</p>
            <h2 class="font-serif text-3xl font-bold text-[#184D47]">Hadiah Pernikahan</h2>
            <p class="text-xs text-[#184D47]/75 leading-relaxed">
                Doa restu Bapak/Ibu/Saudara/i merupakan hadiah terindah bagi kami.
            </p>
        </div>

        <div class="space-y-3 text-left">
            @foreach ($undangan->daftarAmplop as $amplop)
                <div class="rounded-2xl bg-[#184D47] p-5 text-[#F4FAF6] space-y-2.5">
                    <div class="flex items-center justify-between">
                        <span class="font-serif text-base font-bold text-[#F3E5AB]">{{ $amplop->nama_bank }}</span>
                        <span class="text-[10px] uppercase tracking-widest text-[#E6D19C]">Transfer</span>
                    </div>
                    <div>
                        <p class="font-mono text-lg font-bold tracking-[0.14em] text-white">{{ $amplop->nomor_rekening }}</p>
                        <p class="text-xs text-white/80">a.n. {{ $amplop->atas_nama }}</p>
                    </div>
                    <button
                        type="button"
                        @click="salinRekening(@js($amplop->nomor_rekening), {{ $amplop->id ?? $loop->iteration }})"
                        class="w-full rounded-full bg-white py-2 text-xs font-bold uppercase tracking-wider text-[#184D47] hover:bg-[#F4FAF6] transition cursor-pointer"
                    >
                        <span x-text="rekeningTersalin === {{ $amplop->id ?? $loop->iteration }} ? 'Berhasil Disalin!' : 'Salin Nomor Rekening'"></span>
                    </button>
                </div>
            @endforeach

            @if ($alamatKado !== '')
                <div class="rounded-2xl bg-[#F4FAF6] border border-[#184D47]/15 p-4 text-center space-y-1">
                    <p class="text-[10px] font-bold uppercase tracking-[0.28em] text-[#9E7D40]">Alamat Kirim Kado</p>
                    <p class="text-xs text-[#184D47]/85 leading-relaxed">{{ $alamatKado }}</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- SEKSI 10: TURUT MENGUNDANG --}}
@if ($adaTurutMengundang)
<section data-section-turut-mengundang="mihrab" class="relative px-4 pb-6 overflow-hidden">
    <div class="max-w-md mx-auto rounded-2xl bg-white border border-[#184D47]/20 p-5 text-center space-y-3">
        <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7D40]">Keluarga Besar</p>
        <h2 class="font-serif text-2xl font-bold text-[#184D47]">Turut Mengundang</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
            @if (! empty($turutPria))
                <div class="rounded-xl bg-[#F4FAF6] p-3 space-y-1">
                    <p class="font-bold uppercase tracking-wider text-[#9E7D40] text-[10px]">Pihak {{ $undangan->nama_panggilan_pria }}</p>
                    @foreach ($turutPria as $baris)
                        <p class="text-[#184D47]/85">{{ $baris }}</p>
                    @endforeach
                </div>
            @endif
            @if (! empty($turutWanita))
                <div class="rounded-xl bg-[#F4FAF6] p-3 space-y-1">
                    <p class="font-bold uppercase tracking-wider text-[#9E7D40] text-[10px]">Pihak {{ $undangan->nama_panggilan_wanita }}</p>
                    @foreach ($turutWanita as $baris)
                        <p class="text-[#184D47]/85">{{ $baris }}</p>
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
    <div class="max-w-md mx-auto rounded-2xl bg-white border border-[#184D47]/20 p-6 shadow-sm space-y-5">
        <div class="text-center space-y-1">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7D40]">Doa Restu</p>
            <h2 class="font-serif text-3xl font-bold text-[#184D47]">Buku Tamu &amp; RSVP</h2>
        </div>

        @if (! empty($modeDemo))
            <div class="rounded-xl bg-[#F4FAF6] border border-[#184D47]/20 px-4 py-3 text-center text-xs font-semibold text-[#184D47]">
                Mode Live Demo — Formulir RSVP &amp; Ucapan aktif penuh setelah undangan dipublikasikan.
            </div>
        @elseif (! empty($modePratinjau) || ! $undangan->sudahAktifPublik())
            <div class="rounded-xl bg-[#F4FAF6] border border-[#184D47]/20 px-4 py-3 text-center text-xs font-semibold text-[#184D47]">
                Mode Pratinjau — Buku Tamu &amp; RSVP Dikunci
            </div>
        @else
            <form method="POST" action="{{ route('undangan.ucapan', $undangan->slug) }}" class="space-y-3.5 text-left">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-[#184D47]/80">Nama Tamu</label>
                    <input type="text" name="nama_tamu" value="{{ old('nama_tamu', $namaTamu !== 'Tamu Undangan' ? $namaTamu : '') }}" required class="mt-1 w-full rounded-xl border border-[#184D47]/25 bg-[#F4FAF6] px-3.5 py-2.5 text-sm">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-[#184D47]/80">Kehadiran</label>
                        <select name="status_kehadiran" class="mt-1 w-full rounded-xl border border-[#184D47]/25 bg-[#F4FAF6] px-3 py-2.5 text-sm">
                            <option value="hadir">InsyaAllah Hadir</option>
                            <option value="ragu">Masih Ragu</option>
                            <option value="tidak_hadir">Berhalangan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-[#184D47]/80">Jumlah</label>
                        <input type="number" name="jumlah_tamu" value="{{ old('jumlah_tamu', 1) }}" min="1" max="20" required class="mt-1 w-full rounded-xl border border-[#184D47]/25 bg-[#F4FAF6] px-3.5 py-2.5 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-[#184D47]/80">Ucapan &amp; Doa</label>
                    <textarea name="ucapan_doa" rows="3" required placeholder="Tuliskan doa terbaik..." class="mt-1 w-full rounded-xl border border-[#184D47]/25 bg-[#F4FAF6] px-3.5 py-2.5 text-sm">{{ old('ucapan_doa') }}</textarea>
                </div>
                <button type="submit" class="syari-tombol w-full rounded-full py-3 text-xs font-bold uppercase tracking-wider transition cursor-pointer">
                    Kirim Konfirmasi &amp; Doa
                </button>
            </form>
        @endif

        <div class="pt-4 border-t border-[#184D47]/15 space-y-3">
            <h3 class="font-serif text-base font-bold text-[#184D47]">Doa &amp; Ucapan ({{ $undangan->bukuTamu->count() }})</h3>
            @forelse ($undangan->bukuTamu as $ucapan)
                <div class="rounded-xl bg-[#F4FAF6] border border-[#184D47]/15 p-3.5 space-y-1">
                    <div class="flex items-center justify-between gap-2">
                        <p class="font-bold text-xs text-[#184D47]">{{ $ucapan->nama_tamu }}</p>
                        <span class="rounded-full bg-[#184D47]/10 px-2.5 py-0.5 text-[10px] font-semibold text-[#184D47]">
                            {{ str_replace('_', ' ', ucfirst($ucapan->status_kehadiran)) }}
                        </span>
                    </div>
                    <p class="text-xs text-[#184D47]/80 leading-relaxed">{{ $ucapan->ucapan_doa }}</p>
                </div>
            @empty
                <p class="text-xs text-[#184D47]/60 text-center">Jadilah yang pertama menuliskan doa restu.</p>
            @endforelse
        </div>
    </div>
</section>
@endif

{{-- SEKSI 12: PENUTUP MIHRAB SYAR'I & FOOTER --}}
<section
    data-layout-penutup="mihrab"
    class="relative px-4 pt-4 pb-12 overflow-hidden"
>
    <div class="fx-scale-in max-w-md mx-auto rounded-t-[10.5rem] rounded-b-3xl bg-[#184D47] text-[#F4FAF6] border-2 border-[#BFA15F]/65 px-6 pt-14 pb-10 text-center shadow-xl space-y-4">
        @if ($urlFotoPenutup)
            <div class="mx-auto w-44 sm:w-48 overflow-hidden rounded-t-[8rem] rounded-b-2xl border-2 border-[#BFA15F]/70 shadow-lg">
                <img src="{{ $urlFotoPenutup }}" alt="Foto Penutup {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}" class="w-full aspect-[4/5] object-cover object-top">
            </div>
        @endif

        <p class="text-lg text-[#F3E5AB]" style="font-family: 'Amiri', serif;">
            بَارَكَ اللّٰهُ لَكَ وَبَارَكَ عَلَيْكَ وَجَمَعَ بَيْنَكُمَا فِي خَيْرٍ
        </p>
        <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#E6D19C]">Jazakumullahu Khairan</p>
        <p class="text-xs sm:text-sm text-[#F4FAF6]/85 leading-relaxed max-w-xs mx-auto">
            Atas kehadiran dan doa restu Bapak/Ibu/Saudara/i, kami ucapkan terima kasih.
        </p>

        <div class="pt-2">
            <p class="text-[10px] uppercase tracking-[0.28em] text-[#E6D19C]">Kami Yang Berbahagia</p>
            <p class="mt-1.5 font-kaligrafi text-5xl text-white leading-tight">
                {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
            </p>
            <p class="mt-1 text-[11px] uppercase tracking-[0.22em] text-[#F3E5AB]">{{ $hashtagPasangan }}</p>
        </div>
    </div>
</section>

<footer class="bg-[#0F342F] text-[#F4FAF6]/80 border-t border-[#BFA15F]/30 pt-7 pb-24 px-16 text-center text-xs">
    <img src="{{ asset('logo/logo-ikon-gelap.webp') }}" alt="Logo SesiTemu" class="mx-auto mb-2 h-8 w-8 object-contain">
    <p>Wassalamu&rsquo;alaikum Warahmatullahi Wabarakatuh &bull; <a href="{{ route('beranda') }}" class="font-semibold text-[#E6D19C] hover:underline">SesiTemu.id</a></p>
</footer>
