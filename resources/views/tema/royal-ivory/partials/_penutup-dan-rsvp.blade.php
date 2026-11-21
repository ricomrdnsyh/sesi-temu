{{-- SEKSI 9: AMPLOP DIGITAL ROYAL --}}
@if ($undangan->fiturAktif('amplop_digital') && ($undangan->daftarAmplop->isNotEmpty() || $alamatKado !== ''))
<section class="relative bg-[#EFE7DA] px-4 py-12 overflow-hidden">
    <div class="max-w-md mx-auto rounded-3xl bg-[#FBF8F3] border border-[#9E7B4F]/55 p-6 text-center shadow-xl space-y-5">
        <div class="space-y-1">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7B4F]">Wedding Gift</p>
            <h2 class="font-serif text-3xl font-bold text-[#3B2E25]">Amplop Digital</h2>
            <p class="text-xs text-[#3B2E25]/75 leading-relaxed">
                Doa restu Anda adalah kado terindah. Bila berkenan memberikan tanda kasih, dapat melalui rekening berikut:
            </p>
        </div>

        <div class="space-y-3.5 text-left">
            @foreach ($undangan->daftarAmplop as $amplop)
                <div class="rounded-2xl bg-gradient-to-br from-[#7B603F] via-[#58432B] to-[#3B2E25] p-5 text-[#FAF6EE] border border-[#E5C99B]/55 shadow-lg space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="font-serif text-base font-bold text-[#E5C99B]">{{ $amplop->nama_bank }}</span>
                        <span class="text-[10px] uppercase tracking-widest text-[#FAF6EE]/75">Transfer</span>
                    </div>
                    <div>
                        <p class="font-mono text-lg font-bold tracking-[0.16em] text-white">{{ $amplop->nomor_rekening }}</p>
                        <p class="text-xs text-[#FAF6EE]/80 mt-0.5">a.n. {{ $amplop->atas_nama }}</p>
                    </div>
                    <button
                        type="button"
                        @click="salinRekening(@js($amplop->nomor_rekening), {{ $amplop->id ?? $loop->iteration }})"
                        class="w-full rounded-full bg-[#FAF6EE] py-2 text-xs font-bold uppercase tracking-wider text-[#58432B] hover:bg-white transition cursor-pointer"
                    >
                        <span x-text="rekeningTersalin === {{ $amplop->id ?? $loop->iteration }} ? 'Berhasil Disalin!' : 'Salin Nomor Rekening'"></span>
                    </button>
                </div>
            @endforeach

            @if ($alamatKado !== '')
                <div class="rounded-2xl bg-white border border-[#9E7B4F]/40 p-4 text-center space-y-1">
                    <p class="text-[10px] font-bold uppercase tracking-[0.28em] text-[#9E7B4F]">Alamat Kirim Kado</p>
                    <p class="text-xs text-[#3B2E25]/85 leading-relaxed">{{ $alamatKado }}</p>
                </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- SEKSI 10: TURUT MENGUNDANG --}}
@if ($adaTurutMengundang)
<section data-section-turut-mengundang="katedral" class="relative px-4 pt-8 pb-4 overflow-hidden">
    <div class="max-w-md mx-auto rounded-3xl bg-white border border-[#9E7B4F]/45 p-6 text-center shadow-md space-y-4">
        <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7B4F]">Keluarga Besar</p>
        <h2 class="font-serif text-2xl font-bold text-[#3B2E25]">Turut Mengundang</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 text-xs">
            @if (! empty($turutPria))
                <div class="rounded-2xl bg-[#FBF8F3] border border-[#9E7B4F]/30 p-3.5 space-y-1">
                    <p class="font-bold uppercase tracking-wider text-[#7B603F] text-[10px]">Pihak {{ $undangan->nama_panggilan_pria }}</p>
                    @foreach ($turutPria as $baris)
                        <p class="text-[#3B2E25]/85">{{ $baris }}</p>
                    @endforeach
                </div>
            @endif
            @if (! empty($turutWanita))
                <div class="rounded-2xl bg-[#FBF8F3] border border-[#9E7B4F]/30 p-3.5 space-y-1">
                    <p class="font-bold uppercase tracking-wider text-[#7B603F] text-[10px]">Pihak {{ $undangan->nama_panggilan_wanita }}</p>
                    @foreach ($turutWanita as $baris)
                        <p class="text-[#3B2E25]/85">{{ $baris }}</p>
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
    <div class="max-w-md mx-auto rounded-3xl bg-white border border-[#9E7B4F]/50 p-6 shadow-xl space-y-5">
        <div class="text-center space-y-1">
            <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7B4F]">Guestbook</p>
            <h2 class="font-serif text-3xl font-bold text-[#3B2E25]">Ucapan &amp; RSVP</h2>
        </div>

        @if (! empty($modeDemo))
            <div class="rounded-2xl bg-[#FBF8F3] border border-[#9E7B4F]/40 px-4 py-3 text-center text-xs font-semibold text-[#58432B]">
                Mode Live Demo — Formulir RSVP &amp; Ucapan aktif penuh setelah undangan dipublikasikan.
            </div>
        @elseif (! empty($modePratinjau) || ! $undangan->sudahAktifPublik())
            <div class="rounded-2xl bg-[#FBF8F3] border border-[#9E7B4F]/40 px-4 py-3 text-center text-xs font-semibold text-[#58432B]">
                Mode Pratinjau — Buku Tamu &amp; RSVP Dikunci
            </div>
        @else
            <form method="POST" action="{{ route('undangan.ucapan', $undangan->slug) }}" class="space-y-3.5 text-left">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-[#58432B]/80">Nama Tamu</label>
                    <input type="text" name="nama_tamu" value="{{ old('nama_tamu', $namaTamu !== 'Tamu Undangan' ? $namaTamu : '') }}" required class="mt-1 w-full rounded-xl border border-[#9E7B4F]/45 bg-[#FBF8F3] px-3.5 py-2.5 text-sm">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-[#58432B]/80">Kehadiran</label>
                        <select name="status_kehadiran" class="mt-1 w-full rounded-xl border border-[#9E7B4F]/45 bg-[#FBF8F3] px-3 py-2.5 text-sm">
                            <option value="hadir">Hadir</option>
                            <option value="ragu">Masih Ragu</option>
                            <option value="tidak_hadir">Berhalangan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-[#58432B]/80">Jumlah</label>
                        <input type="number" name="jumlah_tamu" value="{{ old('jumlah_tamu', 1) }}" min="1" max="20" required class="mt-1 w-full rounded-xl border border-[#9E7B4F]/45 bg-[#FBF8F3] px-3.5 py-2.5 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-[#58432B]/80">Ucapan &amp; Doa</label>
                    <textarea name="ucapan_doa" rows="3" required placeholder="Tuliskan doa terbaik untuk kedua mempelai..." class="mt-1 w-full rounded-xl border border-[#9E7B4F]/45 bg-[#FBF8F3] px-3.5 py-2.5 text-sm">{{ old('ucapan_doa') }}</textarea>
                </div>
                <button type="submit" class="royal-tombol w-full rounded-full py-3 text-xs font-bold uppercase tracking-wider transition cursor-pointer">
                    Kirim Konfirmasi &amp; Doa
                </button>
            </form>
        @endif

        <div class="pt-4 border-t border-[#9E7B4F]/30 space-y-3">
            <h3 class="font-serif text-base font-bold text-[#3B2E25]">Doa &amp; Ucapan ({{ $undangan->bukuTamu->count() }})</h3>
            @forelse ($undangan->bukuTamu as $ucapan)
                <div class="rounded-2xl bg-[#FBF8F3] border border-[#9E7B4F]/25 p-3.5 space-y-1">
                    <div class="flex items-center justify-between gap-2">
                        <p class="font-bold text-xs text-[#3B2E25]">{{ $ucapan->nama_tamu }}</p>
                        <span class="rounded-full bg-[#9E7B4F]/15 px-2.5 py-0.5 text-[10px] font-semibold text-[#7B603F]">
                            {{ str_replace('_', ' ', ucfirst($ucapan->status_kehadiran)) }}
                        </span>
                    </div>
                    <p class="text-xs text-[#3B2E25]/80 leading-relaxed">{{ $ucapan->ucapan_doa }}</p>
                </div>
            @empty
                <p class="text-xs text-[#3B2E25]/60 text-center">Jadilah yang pertama memberikan doa restu.</p>
            @endforelse
        </div>
    </div>
</section>
@endif

{{-- SEKSI 12: KAPSUL PENUTUP KATEDRAL & FOOTER --}}
<section
    data-layout-penutup="katedral"
    class="relative px-4 pt-6 pb-12 overflow-hidden"
>
    <div class="fx-scale-in max-w-md mx-auto rounded-t-[10.5rem] rounded-b-3xl bg-[#FBF8F3] border-2 border-[#9E7B4F]/65 px-6 pt-14 pb-10 text-center shadow-2xl space-y-4">
        @if ($urlFotoPenutup)
            <div class="mx-auto w-44 sm:w-48 overflow-hidden rounded-t-[8rem] rounded-b-2xl border-2 border-[#9E7B4F]/65 shadow-lg">
                <img src="{{ $urlFotoPenutup }}" alt="Foto Penutup {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}" class="w-full aspect-[4/5] object-cover object-top">
            </div>
        @endif

        <img src="{{ $asetRoyal['katedral'] }}" alt="" class="w-11 mx-auto opacity-90">
        <p class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7B4F]">Terima Kasih</p>
        <p class="text-xs sm:text-sm text-[#3B2E25]/80 leading-relaxed max-w-xs mx-auto">
            Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.
        </p>

        <div class="pt-2">
            <p class="text-[10px] uppercase tracking-[0.28em] text-[#7B603F]">Kami Yang Berbahagia</p>
            <p class="mt-1.5 font-kaligrafi text-5xl text-[#3B2E25] leading-tight">
                {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
            </p>
            <p class="mt-1 text-[11px] uppercase tracking-[0.22em] text-[#9E7B4F]">
                {{ $hashtagPasangan }}
            </p>
        </div>
    </div>
</section>

<footer class="bg-[#3B2E25] text-[#FAF6EE]/80 border-t border-[#9E7B4F]/35 pt-7 pb-24 px-16 text-center text-xs">
    <img src="{{ asset('logo/logo-ikon-gelap.webp') }}" alt="Logo SesiTemu" class="mx-auto mb-2 h-8 w-8 object-contain">
    <p>Luxury Royal Ivory oleh <a href="{{ route('beranda') }}" class="font-semibold text-[#E5C99B] hover:underline">SesiTemu.id</a></p>
</footer>
