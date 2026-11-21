{{-- SEKSI 9: AMPLOP DIGITAL & KADO FISIK PRIANGAN --}}
@if ($undangan->fiturAktif('amplop_digital') && ($undangan->daftarAmplop->isNotEmpty() || $alamatKado !== ''))
<section class="relative px-4 py-12 overflow-hidden">
    <div class="max-w-md mx-auto rounded-3xl bg-[#FFFBF4] border-2 border-[#C59B43]/65 p-6 text-center shadow-xl space-y-5">
        <div class="space-y-1">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#8E6620]">Tanda Kasih</p>
            <h2 class="font-serif text-3xl font-bold text-[#5A1E1E]">Amplop Digital</h2>
            <p class="text-xs text-[#4A2020]/75 leading-relaxed">
                Doa restu Bapa/Ibu/Saderek mangrupikeun kado pangsaena. Bilih kersa ngintun tanda kasih, mangga tiasa liwat:
            </p>
        </div>

        <div class="space-y-3.5 text-left">
            @foreach ($undangan->daftarAmplop as $amplop)
                <div class="rounded-2xl bg-gradient-to-br from-[#5A1E1E] via-[#4A1717] to-[#2B0E0E] p-5 text-[#FAF4E8] border border-[#C59B43]/65 shadow-lg space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="font-serif text-base font-bold tracking-wider text-[#F3E5AB]">{{ $amplop->nama_bank }}</span>
                        <span class="text-[10px] uppercase tracking-widest text-[#E7C87D]/80">Transfer</span>
                    </div>
                    <div>
                        <p class="font-mono text-lg font-bold tracking-[0.16em] text-white">{{ $amplop->nomor_rekening }}</p>
                        <p class="text-xs text-[#FAF4E8]/80 mt-0.5">a.n. {{ $amplop->atas_nama }}</p>
                    </div>
                    <button
                        type="button"
                        @click="salinRekening(@js($amplop->nomor_rekening), {{ $amplop->id ?? $loop->iteration }})"
                        class="sunda-tombol-emas w-full rounded-full py-2 text-xs font-bold uppercase tracking-wider transition cursor-pointer"
                    >
                        <span x-text="rekeningTersalin === {{ $amplop->id ?? $loop->iteration }} ? 'Berhasil Disalin!' : 'Salin Nomor Rekening'"></span>
                    </button>
                </div>
            @endforeach

            @if ($alamatKado !== '')
                <div class="rounded-2xl bg-[#FAF4E8] border border-[#C59B43]/55 p-4 text-center space-y-1.5">
                    <p class="text-[10px] font-bold uppercase tracking-[0.28em] text-[#8E6620]">Alamat Kirim Kado</p>
                    <p class="text-xs text-[#4A2020]/85 leading-relaxed">{{ $alamatKado }}</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- SEKSI 10: TURUT MENGUNDANG (OPSIONAL) --}}
@if ($adaTurutMengundang)
<section data-section-turut-mengundang="priangan" class="relative px-4 pb-8 overflow-hidden">
    <div class="max-w-md mx-auto rounded-3xl bg-[#5A1E1E] text-[#FAF4E8] border-2 border-[#C59B43]/65 p-6 text-center shadow-xl space-y-4">
        <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#E7C87D]">Keluarga Besar</p>
        <h2 class="font-serif text-2xl font-bold text-white">Turut Mengundang</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
            @if (! empty($turutPria))
                <div class="rounded-2xl bg-[#3B1414]/75 border border-[#C59B43]/40 p-3.5 space-y-1">
                    <p class="font-bold uppercase tracking-wider text-[#E7C87D] text-[10px]">Pihak {{ $undangan->nama_panggilan_pria }}</p>
                    @foreach ($turutPria as $baris)
                        <p class="text-[#FAF4E8]/90">{{ $baris }}</p>
                    @endforeach
                </div>
            @endif
            @if (! empty($turutWanita))
                <div class="rounded-2xl bg-[#3B1414]/75 border border-[#C59B43]/40 p-3.5 space-y-1">
                    <p class="font-bold uppercase tracking-wider text-[#E7C87D] text-[10px]">Pihak {{ $undangan->nama_panggilan_wanita }}</p>
                    @foreach ($turutWanita as $baris)
                        <p class="text-[#FAF4E8]/90">{{ $baris }}</p>
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
    <div class="max-w-md mx-auto rounded-3xl bg-[#FFFBF4] border-2 border-[#C59B43]/65 p-6 shadow-xl space-y-5 text-[#4A2020]">
        <div class="text-center space-y-1">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#8E6620]">Doa &amp; Pangestu</p>
            <h2 class="font-serif text-3xl font-bold text-[#5A1E1E]">Buku Tamu &amp; RSVP</h2>
        </div>

        @if (! empty($modeDemo))
            <div class="rounded-2xl bg-[#FAF4E8] border border-[#C59B43]/50 px-4 py-3 text-center text-xs font-semibold text-[#5A1E1E]">
                Mode Live Demo — Formulir RSVP &amp; Ucapan aktif penuh setelah undangan dipublikasikan.
            </div>
        @elseif (! empty($modePratinjau) || ! $undangan->sudahAktifPublik())
            <div class="rounded-2xl bg-[#FAF4E8] border border-[#C59B43]/50 px-4 py-3 text-center text-xs font-semibold text-[#5A1E1E]">
                Mode Pratinjau — Buku Tamu &amp; RSVP Dikunci
            </div>
        @else
            <form method="POST" action="{{ route('undangan.ucapan', $undangan->slug) }}" class="space-y-3.5 text-left">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-[#5A1E1E]/80">Nama Tamu</label>
                    <input type="text" name="nama_tamu" value="{{ old('nama_tamu', $namaTamu !== 'Tamu Undangan' ? $namaTamu : '') }}" required class="mt-1 w-full rounded-xl border border-[#C59B43]/60 bg-white px-3.5 py-2.5 text-sm">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-[#5A1E1E]/80">Kehadiran</label>
                        <select name="status_kehadiran" class="mt-1 w-full rounded-xl border border-[#C59B43]/60 bg-white px-3 py-2.5 text-sm">
                            <option value="hadir">Hadir</option>
                            <option value="ragu">Masih Ragu</option>
                            <option value="tidak_hadir">Tidak Hadir</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-[#5A1E1E]/80">Jumlah</label>
                        <input type="number" name="jumlah_tamu" value="{{ old('jumlah_tamu', 1) }}" min="1" max="20" required class="mt-1 w-full rounded-xl border border-[#C59B43]/60 bg-white px-3.5 py-2.5 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-[#5A1E1E]/80">Ucapan &amp; Doa</label>
                    <textarea name="ucapan_doa" rows="3" required placeholder="Tulis doa terbaik untuk kedua mempelai..." class="mt-1 w-full rounded-xl border border-[#C59B43]/60 bg-white px-3.5 py-2.5 text-sm">{{ old('ucapan_doa') }}</textarea>
                </div>
                <button type="submit" class="sunda-tombol-marun w-full rounded-full py-3 text-xs font-bold uppercase tracking-wider transition cursor-pointer">
                    Kirim Konfirmasi &amp; Doa
                </button>
            </form>
        @endif

        <div class="pt-4 border-t border-[#C59B43]/35 space-y-3">
            <h3 class="font-serif text-base font-bold text-[#5A1E1E]">Doa &amp; Ucapan ({{ $undangan->bukuTamu->count() }})</h3>
            @forelse ($undangan->bukuTamu as $ucapan)
                <div class="rounded-2xl bg-[#FAF4E8]/90 border border-[#C59B43]/35 p-3.5 space-y-1">
                    <div class="flex items-center justify-between gap-2">
                        <p class="font-bold text-xs text-[#5A1E1E]">{{ $ucapan->nama_tamu }}</p>
                        <span class="rounded-full bg-[#5A1E1E]/10 px-2.5 py-0.5 text-[10px] font-semibold text-[#5A1E1E]">
                            {{ str_replace('_', ' ', ucfirst($ucapan->status_kehadiran)) }}
                        </span>
                    </div>
                    <p class="text-xs text-[#4A2020]/80 leading-relaxed">{{ $ucapan->ucapan_doa }}</p>
                </div>
            @empty
                <p class="text-xs text-[#4A2020]/60 text-center">Jadilah yang pertama memberikan doa restu.</p>
            @endforelse
        </div>
    </div>
</section>
@endif

{{-- SEKSI 12: KAPSUL PENUTUP PRIANGAN & FOOTER --}}
<section
    data-layout-penutup="priangan"
    class="relative px-4 pt-6 pb-12 overflow-hidden"
>
    <div class="fx-scale-in max-w-md mx-auto rounded-t-[10.5rem] rounded-b-3xl bg-[#5A1E1E] text-[#FAF4E8] border-2 border-[#C59B43]/80 px-6 pt-14 pb-10 text-center shadow-2xl space-y-4">
        @if ($urlFotoPenutup)
            <div class="mx-auto w-44 sm:w-48 overflow-hidden rounded-t-[8rem] rounded-b-2xl border-2 border-[#E7C87D] shadow-xl">
                <img
                    src="{{ $urlFotoPenutup }}"
                    alt="Foto Penutup {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                    class="w-full aspect-[4/5] object-cover object-top"
                >
            </div>
        @endif

        <img src="{{ $asetSunda['siger'] }}" alt="" class="w-12 mx-auto opacity-95">
        <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#E7C87D]">Hatur Nuhun</p>
        <p class="text-xs sm:text-sm text-[#FAF4E8]/85 leading-relaxed max-w-xs mx-auto">
            Mugia kahadiran sareng doa restu Bapa/Ibu/Saderek ngajantenkeun amal soleh sareng kabagjaan kangge rumah tangga sim kuring.
        </p>

        <div class="pt-2">
            <p class="text-[10px] uppercase tracking-[0.28em] text-[#E7C87D]/85">Kami Yang Berbahagia</p>
            <p class="mt-1.5 font-kaligrafi text-5xl text-white leading-tight">
                {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
            </p>
            <p class="mt-1 text-[11px] uppercase tracking-[0.22em] text-[#F3E5AB]">
                {{ $hashtagPasangan }}
            </p>
        </div>
    </div>
</section>

<footer class="bg-[#3B1414] text-[#FAF4E8]/80 border-t border-[#C59B43]/35 pt-7 pb-24 px-16 text-center text-xs">
    <img src="{{ asset('logo/logo-ikon-gelap.webp') }}" alt="Logo SesiTemu" class="mx-auto mb-2 h-8 w-8 object-contain">
    <p>Adat Sunda Siger Heritage oleh <a href="{{ route('beranda') }}" class="font-semibold text-[#E7C87D] hover:underline">SesiTemu.id</a></p>
</footer>
