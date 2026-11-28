{{-- SEKSI 9: AMPLOP DIGITAL KONSERVATORI (INTERAKTIF BUKA-TUTUP KARTU BANK GLOSSY) --}}
@if ($undangan->fiturAktif('amplop_digital') && ($undangan->daftarAmplop->isNotEmpty() || $alamatKado !== ''))
    <section data-layout-amplop class="relative bg-[#132623] px-4 pt-12 pb-6 overflow-hidden">
        <div
            x-data="{ amplopTerbuka: false }"
            class="max-w-md mx-auto rounded-3xl bg-[#FDFBF7] text-[#1F3431] border-2 border-[#C8A464]/65 p-6 text-center shadow-2xl kartu-3d efek-shimmer-kartu space-y-5"
        >
            <div class="space-y-1.5">
                <img src="{{ $asetGarden['garland'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async" data-gsap="turun" class="w-32 mx-auto pb-0.5">
                <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#7D6027]">Tanda Kasih</p>
                <h2 data-gsap="naik" class="font-serif text-3xl font-bold text-[#132623]">{{ $undangan->teksKustom('judul_amplop', 'Amplop Digital') }}</h2>
                <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs text-[#1F3431]/75 leading-relaxed max-w-xs mx-auto">
                    {{ $undangan->teksKustom('pengantar_amplop', 'Doa restu Bapak/Ibu/Saudara/i merupakan hadiah terindah bagi kami. Namun apabila ingin memberikan tanda kasih, dapat disalurkan melalui:') }}
                </p>
            </div>

            <div data-gsap="mekar" data-gsap-delay="0.08">
                <button
                    type="button"
                    @click="amplopTerbuka = !amplopTerbuka; window.SesiTemuSinema?.refresh(360)"
                    :aria-expanded="amplopTerbuka.toString()"
                    class="garden-tombol-sage inline-flex items-center justify-center gap-2 rounded-full px-6 py-2.5 text-xs font-bold uppercase tracking-[0.14em] transition active:scale-95 cursor-pointer"
                >
                    <svg class="w-4 h-4 text-[#DFC285] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect width="20" height="16" x="2" y="4" rx="2"/>
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                    </svg>
                    <span x-text="amplopTerbuka ? 'Tutup Amplop Digital' : 'Buka Amplop Digital'">Buka Amplop Digital</span>
                    <svg class="h-3.5 w-3.5 text-[#DFC285] transition-transform duration-300 shrink-0"
                        :class="amplopTerbuka ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
                        aria-hidden="true">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </button>
            </div>

            <div
                x-show="amplopTerbuka"
                x-cloak
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-2 scale-[0.98]"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 -translate-y-2 scale-[0.98]"
                class="space-y-3.5 text-left pt-1"
            >
                @foreach ($undangan->daftarAmplop as $amplop)
                    @include('komponen-undangan.kartu-bank-amplop', ['amplop' => $amplop])
                @endforeach

                @if ($alamatKado !== '')
                    <div x-data="{ alamatTersalin: false }" class="rounded-2xl bg-[#132623]/5 border border-[#C8A464]/50 p-4 text-center space-y-2">
                        <p class="text-[10px] font-bold uppercase tracking-[0.28em] text-[#7D6027]">Alamat Kirim Kado</p>
                        <p class="text-xs text-[#1F3431]/85 leading-relaxed">{{ $alamatKado }}</p>
                        <button type="button"
                            @click="navigator.clipboard?.writeText(@js($alamatKado)); alamatTersalin = true; setTimeout(() => alamatTersalin = false, 2200)"
                            class="garden-tombol-sage inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-[11px] font-semibold transition cursor-pointer">
                            <span x-show="!alamatTersalin">Salin Alamat</span>
                            <span x-show="alamatTersalin" x-cloak>Alamat Tersalin!</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif

{{-- SEKSI 10: BUKU TAMU & RSVP --}}
    <section id="buku-tamu" class="relative bg-[#132623] px-4 py-6 overflow-hidden">
        <div
            class="max-w-md mx-auto rounded-3xl bg-[#FDFBF7] text-[#1F3431] border-2 border-[#C8A464]/65 p-6 shadow-2xl space-y-5">
            <div class="text-center space-y-1">
                <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#7D6027]">Garden Guestbook</p>
                <h2 data-gsap="mekar" class="font-serif text-3xl font-bold text-[#132623]">{{ $undangan->teksKustom('judul_buku_tamu', 'RSVP & Wishes') }}</h2>
                <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs text-[#1F3431]/72">
                    Konfirmasikan kehadiran serta sampaikan doa terbaik bagi kami.
                </p>
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
                                    class="mt-1 w-full rounded-xl border border-[#C8A464]/55 bg-white px-3.5 py-2.5 text-sm">
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
                        <div x-ref="daftarUcapanScroll" data-lenis-prevent class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
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
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#1F3431]/80">Nama Tamu</label>
                            <input type="text" name="nama_tamu"
                                value="{{ old('nama_tamu', $namaTamu !== 'Tamu Undangan' ? $namaTamu : '') }}" required
                                class="mt-1 w-full rounded-xl border border-[#C8A464]/55 bg-white px-3.5 py-2.5 text-sm">
                        </div>
                        <div class="grid gap-3" :class="statusKehadiran === 'hadir' ? 'grid-cols-2' : 'grid-cols-1'">
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#1F3431]/80">Kehadiran</label>
                                <select name="status_kehadiran" x-model="statusKehadiran" @change="statusKehadiran = $event.target.value"
                                    class="mt-1 w-full rounded-xl border border-[#C8A464]/55 bg-white px-3.5 py-2.5 text-sm">
                                    <option value="hadir" @selected(old('status_kehadiran', 'hadir') === 'hadir')>Hadir</option>
                                    <option value="ragu" @selected(old('status_kehadiran') === 'ragu')>Masih Ragu</option>
                                    <option value="tidak_hadir" @selected(old('status_kehadiran') === 'tidak_hadir')>Berhalangan</option>
                                </select>
                            </div>
                            <div x-show="statusKehadiran === 'hadir'" x-cloak>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#1F3431]/80">Jumlah</label>
                                <input type="number" name="jumlah_tamu" value="{{ old('jumlah_tamu', 1) }}" min="1"
                                    max="20" :required="statusKehadiran === 'hadir'" :disabled="statusKehadiran !== 'hadir'"
                                    class="mt-1 w-full rounded-xl border border-[#C8A464]/55 bg-white px-3.5 py-2.5 text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#1F3431]/80">Ucapan &amp; Doa</label>
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
                    <h3 class="font-serif text-base font-bold text-[#132623]">Doa &amp; Ucapan ({{ $undangan->bukuTamu->count() }})</h3>
                    <div data-lenis-prevent class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                        @forelse ($undangan->bukuTamu as $ucapan)
                            <div class="rounded-2xl bg-[#132623]/[0.04] border border-[#C8A464]/35 p-3.5 space-y-1">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="font-bold text-xs text-[#132623]">{{ $ucapan->nama_tamu }}</p>
                                    <span class="rounded-full bg-[#3E5A5C]/15 px-2.5 py-0.5 text-[10px] font-semibold text-[#26403E]">
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

{{-- SEKSI 11: DOA UNTUK PENGANTIN & TURUT MENGUNDANG --}}
@if ($undangan->fiturAktif('doa_pengantin') || $adaTurutMengundang)
<section class="relative bg-[#132623] px-4 py-6 space-y-6 overflow-hidden">
    {{-- Kartu Doa Untuk Pengantin --}}
    @if ($undangan->fiturAktif('doa_pengantin'))
        @php
            $doaPengantin = $undangan->doaPengantin([
                'arab' => '',
                'latin' => 'Bārakallāhu laka wa bāraka ‘alaika wa jama‘a bainakumā fī khair.',
                'isi' => 'Semoga Allah memberkahi kalian berdua di kala suka maupun duka, serta senantiasa menghimpun kalian dalam kebaikan, ketenteraman, dan kasih sayang hingga akhir hayat.',
            ]);
        @endphp
        <div data-section-doa-pengantin="taman" class="max-w-md mx-auto rounded-3xl bg-[#FDFBF7] text-[#1F3431] border-2 border-[#C8A464]/65 p-6 text-center shadow-xl kartu-3d efek-shimmer-kartu space-y-3.5">
            <div data-gsap="turun">
                <img src="{{ $asetGarden['garland'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async" class="w-36 mx-auto opacity-95 animasi-melayang">
            </div>
            <p data-gsap="mekar" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#8D6F3A]">Doa Restu</p>
            <h2 data-gsap="naik" class="font-serif text-2xl sm:text-[1.75rem] font-bold text-[#132623]">{{ $doaPengantin['judul'] }}</h2>
            @if ($doaPengantin['arab'] !== '')
                <p data-gsap="mekar" data-gsap-delay="0.05" class="text-xl leading-loose text-[#132623]" style="font-family: 'Amiri', serif;" dir="rtl">
                    {{ $doaPengantin['arab'] }}
                </p>
            @endif
            @if ($doaPengantin['latin'] !== '')
                <p data-gsap="teks" data-gsap-delay="0.06" class="font-serif italic text-sm sm:text-[15px] text-[#26403E] leading-relaxed">
                    &ldquo;{{ $doaPengantin['latin'] }}&rdquo;
                </p>
            @endif
            <div data-gsap="garis" class="flex items-center justify-center gap-3 px-10" aria-hidden="true">
                <span class="h-px flex-1 bg-[#C8A464]/50"></span>
                <span class="w-1.5 h-1.5 rotate-45 bg-[#C8A464]"></span>
                <span class="h-px flex-1 bg-[#C8A464]/50"></span>
            </div>
            <p data-gsap="teks" data-gsap-delay="0.1" class="text-xs text-[#1F3431]/78 leading-relaxed">
                {{ $doaPengantin['isi'] }}
            </p>
        </div>
    @endif

    {{-- Kartu Turut Mengundang --}}
    @if ($adaTurutMengundang)
        <div data-section-turut-mengundang="taman" class="max-w-md mx-auto rounded-3xl bg-gradient-to-b from-[#0E201C] to-[#0B1815] border border-[#C8A464]/55 p-6 text-center shadow-xl kartu-3d space-y-4">
            <div class="space-y-1">
                <img src="{{ $asetGarden['garland'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async" data-gsap="turun" class="w-32 mx-auto pb-0.5 drop-shadow">
                <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#EEDAD4]">Keluarga Besar</p>
                <h2 data-gsap="naik" class="font-serif text-2xl font-bold text-white">{{ $undangan->teksKustom('judul_turut_mengundang', 'Turut Mengundang') }}</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 text-xs">
                @if (!empty($turutPria))
                    <div data-gsap="kiri" class="rounded-2xl bg-[#132623] border border-[#C8A464]/35 p-3.5 space-y-1">
                        <p class="font-bold uppercase tracking-wider text-[#DFC285] text-[10px] pb-1 border-b border-[#C8A464]/20">
                            Pihak {{ $undangan->nama_panggilan_pria }}
                        </p>
                        @foreach ($turutPria as $baris)
                            <p class="text-[#F4F8F6]/88 leading-relaxed">{{ $baris }}</p>
                        @endforeach
                    </div>
                @endif
                @if (!empty($turutWanita))
                    <div data-gsap="kanan" data-gsap-delay="0.06" class="rounded-2xl bg-[#132623] border border-[#C8A464]/35 p-3.5 space-y-1">
                        <p class="font-bold uppercase tracking-wider text-[#DFC285] text-[10px] pb-1 border-b border-[#C8A464]/20">
                            Pihak {{ $undangan->nama_panggilan_wanita }}
                        </p>
                        @foreach ($turutWanita as $baris)
                            <p class="text-[#F4F8F6]/88 leading-relaxed">{{ $baris }}</p>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif
</section>
@endif

{{-- SEKSI 12: KUBAH PENUTUP KONSERVATORI BERHAMPARAN BUNGA DI ATAS FOOTER --}}
<section
    data-layout-penutup="taman"
    class="relative bg-gradient-to-b from-[#132623] via-[#10211D] to-[#0D1B17] px-4 pt-6 pb-5 overflow-hidden"
>
    <div
        class="relative z-10 max-w-md mx-auto rounded-t-[10.5rem] rounded-b-[2rem] bg-[#FDFBF7] text-[#1F3431] border-2 border-[#C8A464]/70 px-6 pt-12 pb-32 sm:pb-36 text-center shadow-[0_24px_54px_-16px_rgba(3,10,8,0.85)] space-y-4 overflow-hidden kartu-3d efek-shimmer-kartu"
    >
        {{-- Garis Lengkung Halus Bingkai Dalam Kartu Penutup --}}
        <div
            aria-hidden="true"
            class="pointer-events-none absolute inset-2.5 rounded-t-[9.75rem] rounded-b-[1.45rem] border border-[#C8A464]/35"
        ></div>

        <div class="relative z-10 space-y-4">
            @if ($urlFotoPenutup)
                <div data-gsap="potret" class="relative mx-auto w-[224px] sm:w-[242px] aspect-[780/960] flex items-center justify-center">
                    <div class="absolute inset-x-[12.5%] top-[8.5%] bottom-[11.5%] rounded-t-[10rem] rounded-b-[1.35rem] overflow-hidden bg-[#0E1E18] shadow-md">
                        <img src="{{ $urlFotoPenutup }}"
                            alt="Foto Penutup {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                            loading="lazy"
                            decoding="async"
                            class="w-full h-full object-cover object-top">
                    </div>
                    <img
                        src="{{ $asetGarden['bingkaiMempelai'] }}"
                        alt=""
                        aria-hidden="true"
                        loading="lazy"
                        decoding="async"
                        class="pointer-events-none relative z-10 w-full h-full object-contain drop-shadow-[0_8px_18px_rgba(10,23,18,0.28)]"
                    >
                </div>
            @else
                <div data-gsap="potret" class="relative mx-auto w-[196px] sm:w-[210px] aspect-[780/960] flex items-center justify-center">
                    <div class="absolute inset-x-[12.5%] top-[8.5%] bottom-[11.5%] rounded-t-[10rem] rounded-b-[1.35rem] overflow-hidden bg-gradient-to-b from-[#23423B] via-[#172E29] to-[#0E1E18] text-[#F3DFA2] flex flex-col items-center justify-center gap-1 shadow-md">
                        <span class="text-[9px] uppercase tracking-[0.28em] text-[#EEDAD4]">{{ $undangan->teksKustom('judul_penutup', 'Terima Kasih') }}</span>
                        <span class="font-serif text-4xl font-bold tracking-wider">
                            {{ $undangan->inisialPria() }} &amp; {{ $undangan->inisialWanita() }}
                        </span>
                    </div>
                    <img
                        src="{{ $asetGarden['bingkaiMempelai'] }}"
                        alt=""
                        aria-hidden="true"
                        loading="lazy"
                        decoding="async"
                        class="pointer-events-none relative z-10 w-full h-full object-contain drop-shadow-[0_8px_18px_rgba(10,23,18,0.28)]"
                    >
                </div>
            @endif

            <div data-gsap="turun">
                <img src="{{ $asetGarden['garland'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async" class="w-28 mx-auto opacity-95 animasi-melayang">
            </div>
            <p data-gsap="mekar" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#7D6027]">{{ $undangan->teksKustom('judul_penutup', 'Terima Kasih') }}</p>
            <p data-gsap="teks" class="text-xs sm:text-sm text-[#1F3431]/80 leading-relaxed max-w-xs mx-auto">
                {{ $undangan->teksKustom('ucapan_penutup', 'Atas kehadiran dan doa restu Bapak/Ibu/Saudara/i, kami menghaturkan terima kasih yang sebesar-besarnya.') }}
            </p>

            <div data-gsap="garis" class="flex items-center justify-center gap-3 px-10 pt-0.5" aria-hidden="true">
                <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#C8A464]/55"></span>
                <span class="w-1.5 h-1.5 rotate-45 bg-[#C8A464]"></span>
                <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#C8A464]/55"></span>
            </div>

            <div class="pt-1">
                <p data-gsap="naik" class="text-[10px] uppercase tracking-[0.28em] text-[#7D6027]/85">{{ $undangan->teksKustom('label_penutup', 'Kami Yang Berbahagia') }}</p>
                <p data-gsap="mekar" data-gsap-delay="0.06" class="mt-1.5 font-kaligrafi text-5xl text-[#132623] leading-tight">
                    {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
                </p>
                <p data-gsap="naik" data-gsap-delay="0.10" class="mt-1 text-[11px] uppercase tracking-[0.22em] text-[#3E5A5C]">
                    {{ $hashtagPasangan }}
                </p>
            </div>
        </div>
    </div>

    {{-- Hamparan Bunga Konservatori Velvet Garden Rimbun Tepat Di Atas Footer --}}
    <img
        src="{{ $asetGarden['bungaPenutup'] }}"
        alt=""
        aria-hidden="true"
        loading="lazy"
        decoding="async"
        class="pointer-events-none absolute -bottom-1 inset-x-0 w-full z-20 drop-shadow-[0_-10px_22px_rgba(4,12,9,0.5)]"
    >
</section>

@include('komponen-undangan.footer-tema', [
    'gelap' => true,
    'warnaOrnamen' => '#C8A464',
    'kelasLatar' => 'relative z-30 bg-gradient-to-b from-[#12261F] via-[#0D1D17] to-[#08130F] border-t border-[#C8A464]/45',
    'kelasTeks' => 'text-[#F4F8F6]/82',
    'kelasAksen' => 'text-[#F3DFA2]',
    'kelasTombol' => 'bg-white/8 text-[#F3DFA2] border border-[#C8A464]/45 hover:-translate-y-0.5 hover:bg-[#C8A464] hover:text-[#0A1712]',
])
