@php
    $pengaturan = $undangan->pengaturan ?? [];
    $alamatKado = trim((string) ($pengaturan['alamat_kado_fisik'] ?? ''));
    $live = $pengaturan['live_streaming'] ?? [];
    $gaya = $gayaTataLetak ?? 'klasik';
    $sudutTajam = !empty($sudutEditorial) || $gaya === 'editorial';
    $kelasRadiusBesar = $sudutTajam ? 'rounded-none' : 'rounded-3xl';
    $kelasRadiusSedang = $sudutTajam ? 'rounded-none' : 'rounded-2xl';
    $kelasRadiusKecil = $sudutTajam ? 'rounded-none' : 'rounded-xl';
    $kelasRadiusPill = $sudutTajam ? 'rounded-none' : 'rounded-full';
    $ekstraKartu = $kelasEkstraKartu ?? '';
    $aksenKartu = $kelasAksenKartu ?? ($kelasAksen ?? 'text-champagne');

    $latarRsvp = match ($gaya) {
        'keraton' => 'bg-[#472A1C] text-[#FAF3E6]',
        'priangan' => 'bg-[#5A1E1E] text-[#FAF4E8]',
        'editorial' => 'bg-[#111113] text-[#FAF9F6]',
        'artdeco' => 'bg-[#09090D] text-[#F5EFE6]',
        'taman' => 'bg-[#132623] text-[#F4F8F6]',
        'celestial' => 'bg-[#091322] text-[#E6EEF8]',
        'katedral' => 'bg-[#EFE7DA] text-[#3B2E25]',
        'mihrab' => 'bg-[#133D38] text-[#F4FAF6]',
        default => 'bg-[#3E5349] text-[#FDFBF7]',
    };
@endphp

{{-- Live Streaming --}}
@if (!empty($live['aktif']) && !empty($live['link']))
<section data-aos="fade-up" data-aos-duration="950" class="py-12 px-5">
    <div class="fx-scale-in max-w-2xl mx-auto {{ $kelasRadiusBesar }} p-7 text-center kartu-3d masuk-3d {{ $ekstraKartu }} {{ $kelasKartu ?? 'bg-white ring-1 ring-champagne/25 text-charcoal' }}">
        <span aria-hidden="true" class="mx-auto mb-3 inline-flex h-10 w-10 items-center justify-center rounded-full bg-current/10 {{ $aksenKartu }}">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                <path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"/>
                <rect x="2" y="6" width="14" height="12" rx="2"/>
            </svg>
        </span>
        <p class="text-xs font-semibold uppercase tracking-[0.25em] {{ $aksenKartu }}">Siaran Langsung</p>
        <h2 class="mt-2 font-serif text-3xl font-bold">Live Streaming ({{ $live['platform'] ?? 'Online' }})</h2>
        <p class="mt-2 text-xs sm:text-sm opacity-75 leading-relaxed">Bagi kerabat yang berhalangan hadir langsung, silakan menyaksikan momen sakral kami secara virtual.</p>
        <a href="{{ $live['link'] }}" target="_blank" rel="noopener" class="mt-5 inline-flex items-center gap-2 {{ $kelasRadiusPill }} px-6 py-2.5 text-xs sm:text-sm font-semibold transition {{ $kelasTombol ?? 'bg-sage text-white hover:bg-sage/90' }}">
            Saksikan Siaran Langsung
        </a>
    </div>
</section>
@endif

{{-- Amplop Digital (Kartu ATM / E-Wallet 3D Glossy + Toggle Interaktif) & Kado Fisik --}}
@if ($undangan->fiturAktif('amplop_digital') && ($undangan->daftarAmplop->isNotEmpty() || $alamatKado !== ''))
<section
    data-aos="fade-up"
    data-aos-duration="950"
    x-data="{ amplopTerbuka: true }"
    class="py-12 px-5"
>
    <div class="max-w-md mx-auto text-center">
        <div class="fx-rise {{ $kelasRadiusBesar }} p-6 sm:p-7 kartu-3d masuk-3d {{ $ekstraKartu }} {{ $kelasKartu ?? 'bg-white ring-1 ring-champagne/25 text-charcoal' }}">
            <p class="text-[11px] font-semibold uppercase tracking-[0.28em] {{ $aksenKartu }}">Tanda Kasih</p>
            <h2 class="mt-1.5 {{ $sudutTajam ? 'font-serif text-2xl sm:text-3xl font-bold uppercase tracking-[0.14em]' : 'font-kaligrafi text-4xl font-normal leading-tight' }}">{{ $undangan->teksKustom('judul_amplop', 'Amplop Digital') }}</h2>
            <p class="mt-2 text-xs sm:text-sm opacity-75 leading-relaxed">
                {{ $undangan->teksKustom('pengantar_amplop', 'Doa restu Anda merupakan karunia terindah bagi kami. Apabila hendak mengirimkan tanda kasih, dapat melalui rekening berikut:') }}
            </p>

            <button
                type="button"
                @click="amplopTerbuka = !amplopTerbuka; window.SesiTemuSinema?.refresh(360)"
                class="mt-4 inline-flex items-center gap-2 {{ $kelasRadiusPill }} px-5 py-2 text-xs font-semibold transition cursor-pointer {{ $kelasTombol ?? 'bg-sage text-white hover:bg-sage/90' }}"
            >
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect x="3" y="8" width="18" height="4" rx="1"/>
                    <path d="M12 8v13"/>
                    <path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"/>
                    <path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"/>
                </svg>
                <span x-text="amplopTerbuka ? 'Sembunyikan Rekening' : 'Kirim Tanda Kasih'"></span>
            </button>

            <div x-show="amplopTerbuka" x-transition class="mt-6 space-y-4 text-left panggung-3d">
                @foreach ($undangan->daftarAmplop as $amplop)
                    @php
                        $gayaBank = \App\Support\GayaKartuBank::untukNamaBank($amplop->nama_bank);
                        $nomorTerformat = \App\Support\GayaKartuBank::formatNomor($amplop->nomor_rekening);
                    @endphp
                    <div
                        x-data="{ tersalin: false }"
                        class="fx-flip-in relative {{ $sudutTajam ? 'rounded-none' : 'rounded-2xl' }} p-5 text-white overflow-hidden shadow-xl kartu-3d"
                        style="background: {{ $gayaBank['gradient_css'] }};"
                    >
                        {{-- Efek Kilau Metalik Kartu ATM --}}
                        <div aria-hidden="true" class="pointer-events-none absolute -top-12 -right-12 h-36 w-36 rounded-full bg-white/10 blur-xl"></div>
                        <div aria-hidden="true" class="pointer-events-none absolute -bottom-12 -left-10 h-32 w-32 rounded-full opacity-20 blur-xl" style="background-color: {{ $gayaBank['aksen_hex'] }};"></div>

                        <div class="relative z-10 flex items-start justify-between gap-3">
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-white/75">{{ $gayaBank['label_jenis'] }}</p>
                                <p class="mt-0.5 font-sans text-base font-extrabold tracking-wide text-white">{{ $gayaBank['singkatan'] }}</p>
                            </div>
                            {{-- Chip EMV Emas / Perak --}}
                            <div
                                aria-hidden="true"
                                class="h-7 w-10 rounded-md border border-white/30 shadow-inner {{ $gayaBank['chip_gaya'] === 'perak' ? 'bg-gradient-to-br from-slate-100 via-slate-300 to-slate-400' : 'bg-gradient-to-br from-[#F9E7A8] via-[#D4AF37] to-[#9A7422]' }}"
                            ></div>
                        </div>

                        <div class="relative z-10 mt-5">
                            <p class="font-mono text-lg sm:text-xl font-bold tracking-[0.14em] text-white drop-shadow-xs">
                                {{ $nomorTerformat }}
                            </p>
                            <p class="mt-1 text-xs text-white/85">a.n. {{ $amplop->atas_nama }}</p>
                        </div>

                        <div class="relative z-10 mt-4 pt-3 border-t border-white/15 flex items-center justify-between gap-2">
                            <span class="text-[10px] font-medium text-white/70 truncate">{{ $amplop->nama_bank }}</span>
                            <button
                                type="button"
                                @click="navigator.clipboard?.writeText(@js($amplop->nomor_rekening)); tersalin = true; setTimeout(() => tersalin = false, 2500)"
                                class="inline-flex items-center gap-1.5 rounded-full bg-white/20 hover:bg-white/30 backdrop-blur-xs px-3.5 py-1.5 text-[11px] font-semibold text-white transition cursor-pointer shrink-0"
                            >
                                <span x-show="!tersalin">Salin Nomor Rekening</span>
                                <span x-show="tersalin" x-cloak>Berhasil Disalin!</span>
                            </button>
                        </div>
                    </div>
                @endforeach

                @if ($alamatKado !== '')
                    <div
                        x-data="{ alamatTersalin: false }"
                        class="fx-rise {{ $kelasRadiusSedang }} p-5 text-center border border-current/15 bg-current/[0.04] space-y-2"
                    >
                        <p class="text-[11px] font-bold uppercase tracking-[0.22em] {{ $aksenKartu }}">Alamat Pengiriman Kado Fisik</p>
                        <p class="text-xs sm:text-sm opacity-85 leading-relaxed">{{ $alamatKado }}</p>
                        <button
                            type="button"
                            @click="navigator.clipboard?.writeText(@js($alamatKado)); alamatTersalin = true; setTimeout(() => alamatTersalin = false, 2200)"
                            class="inline-flex items-center gap-1.5 {{ $kelasRadiusPill }} px-4 py-1.5 text-[11px] font-semibold transition cursor-pointer {{ $kelasTombol ?? 'bg-sage text-white' }}"
                        >
                            <span x-show="!alamatTersalin">Salin Alamat</span>
                            <span x-show="alamatTersalin" x-cloak>Alamat Tersalin!</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

{{-- Buku Tamu & RSVP (Permukaan Kontras Solid Sesuai Ritme Tema) --}}
<section id="buku-tamu" data-aos="fade-up" data-aos-duration="950" class="relative py-14 px-5 {{ $latarRsvp }}">
    <div class="max-w-md mx-auto">
        <div class="text-center space-y-1.5">
            @if (! empty($ornamenUrl) && $gaya === 'keraton')
                <img src="{{ $ornamenUrl }}" alt="" class="fx-rise-down w-14 mx-auto drop-shadow mb-2">
            @endif
            <p class="text-[11px] font-semibold uppercase tracking-[0.3em] opacity-80">Konfirmasi &amp; Doa</p>
            <h2 class="fx-scale-in {{ $sudutTajam ? 'font-serif text-2xl sm:text-3xl font-bold uppercase tracking-[0.16em]' : 'font-serif text-3xl sm:text-4xl font-bold' }}">
                {{ $undangan->teksKustom('judul_buku_tamu', 'Buku Tamu & RSVP') }}
            </h2>
        </div>

        <div class="mt-7 fx-rise {{ $kelasRadiusBesar }} p-5 sm:p-6 kartu-3d masuk-3d {{ $kelasKartu ?? 'bg-white ring-1 ring-champagne/25 text-charcoal' }}">
            @if (session('sukses_ucapan'))
                <div data-swal-success="{{ session('sukses_ucapan') }}" hidden aria-hidden="true"></div>
            @endif

            @if ($errors->any())
                <div data-swal-errors="{{ json_encode($errors->all(), JSON_UNESCAPED_UNICODE) }}" hidden aria-hidden="true"></div>
            @endif

            @if (!empty($modeDemo))
                @php
                    $ucapanDemoFallback = $undangan->bukuTamu
                        ->values()
                        ->map(static fn ($ucapan, int $idx) => [
                            'id' => 'awal-' . ($ucapan->id ?? ($idx + 1)),
                            'nama_tamu' => (string) $ucapan->nama_tamu,
                            'status_kehadiran' => (string) $ucapan->status_kehadiran,
                            'jumlah_tamu' => (int) ($ucapan->jumlah_tamu ?? 1),
                            'ucapan_doa' => (string) $ucapan->ucapan_doa,
                            'waktu' => $ucapan->created_at
                                ? $ucapan->created_at->locale('id')->diffForHumans()
                                : 'Baru saja',
                        ])
                        ->all();
                @endphp
                <div x-data="bukuTamuDemo(@js($ucapanDemoFallback), @js($namaTamu))" class="space-y-5">
                    <form @submit.prevent="kirimUcapanDemo()" class="space-y-3.5 text-left">
                        <input type="text" x-model="namaTamu" required class="w-full {{ $kelasRadiusKecil }} border border-current/20 bg-transparent px-4 py-2.5 text-sm" placeholder="Nama Tamu">
                        <div class="grid gap-3" :class="statusKehadiran === 'hadir' ? 'grid-cols-2' : 'grid-cols-1'">
                            <select x-ref="selectKehadiran" x-model="statusKehadiran" @change="statusKehadiran = $event.target.value" class="w-full {{ $kelasRadiusKecil }} border border-current/20 bg-transparent px-3.5 py-2.5 text-sm [&>option]:bg-white [&>option]:text-charcoal">
                                <option value="hadir">InsyaAllah Hadir</option>
                                <option value="ragu">Masih Ragu</option>
                                <option value="tidak_hadir">Berhalangan Hadir</option>
                            </select>
                            <input x-show="statusKehadiran === 'hadir'" x-cloak type="number" x-model.number="jumlahTamu" min="1" max="20" :required="statusKehadiran === 'hadir'" :disabled="statusKehadiran !== 'hadir'" class="{{ $kelasRadiusKecil }} border border-current/20 bg-transparent px-3.5 py-2.5 text-sm">
                        </div>
                        <textarea x-model="ucapanDoa" rows="3" required class="w-full {{ $kelasRadiusKecil }} border border-current/20 bg-transparent px-4 py-2.5 text-sm" placeholder="Tulis doa terbaik untuk kedua mempelai..."></textarea>
                        <button type="submit" class="w-full {{ $kelasRadiusKecil }} px-6 py-3 text-sm font-semibold cursor-pointer {{ $kelasTombol ?? 'bg-sage text-white' }}">
                            Kirim Konfirmasi &amp; Doa
                        </button>
                        <p x-show="pesanGalat" x-cloak x-text="pesanGalat" class="text-xs text-rose-600 font-semibold text-center"></p>
                        <p x-show="pesanSukses" x-cloak x-text="pesanSukses" class="text-xs text-emerald-600 font-semibold text-center"></p>
                    </form>

                    {{-- Daftar Ucapan Demo Scrollable --}}
                    <div class="pt-5 border-t border-current/15 space-y-3">
                        <h3 class="font-serif text-lg font-bold">Doa &amp; Ucapan (<span x-text="daftarUcapan.length">{{ count($ucapanDemoFallback) }}</span>)</h3>
                        <div x-ref="daftarUcapanScroll" data-lenis-prevent class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                            <template x-for="ucapan in daftarUcapan" :key="ucapan.id">
                                <div class="{{ $kelasRadiusSedang }} p-4 border border-current/10 bg-current/[0.03] space-y-1.5">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="font-semibold text-sm" x-text="ucapan.nama_tamu"></p>
                                        <span class="shrink-0 {{ $kelasRadiusPill }} px-2.5 py-0.5 text-[10px] font-semibold" :class="kelasStatus(ucapan.status_kehadiran, false, 'bg-current/10')" x-text="labelStatus(ucapan.status_kehadiran)"></span>
                                    </div>
                                    <p class="text-xs sm:text-sm opacity-80 leading-relaxed" x-text="ucapan.ucapan_doa"></p>
                                    <p class="text-[10px] opacity-60" x-text="ucapan.waktu"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            @else
                @if (! $undangan->sudahAktifPublik())
                    <div class="rounded-2xl border border-amber-300/70 bg-amber-50/95 p-5 text-charcoal space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="shrink-0 w-9 h-9 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                </svg>
                            </div>
                            <div class="space-y-1">
                                <p class="text-sm font-bold text-charcoal">Mode Pratinjau — Buku Tamu &amp; RSVP Dikunci</p>
                                <p class="text-xs text-charcoal/75 leading-relaxed">
                                    Formulir konfirmasi kehadiran dan pengiriman ucapan doa baru dapat diisi tamu setelah undangan dibayar dan diaktifkan.
                                </p>
                            </div>
                        </div>

                        @if ($undangan->bolehDipratinjauOleh(auth()->user()))
                            <div class="pt-1">
                                <a
                                    href="{{ route('dashboard.undangan.kelola', [$undangan, 'tab' => 'aktivasi']) }}"
                                    class="inline-flex items-center gap-1.5 rounded-xl bg-sage px-4 py-2 text-xs font-semibold text-white hover:bg-sage/90 transition"
                                >
                                    Bayar &amp; Aktifkan Undangan &rarr;
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <form x-data="{ statusKehadiran: @js(old('status_kehadiran', 'hadir')) }" action="{{ route('undangan.ucapan', $undangan->slug) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider opacity-75">Nama Lengkap</label>
                            <input type="text" name="nama_tamu" value="{{ old('nama_tamu', $namaTamu !== 'Tamu Undangan' ? $namaTamu : '') }}" required placeholder="Masukkan nama Anda" class="mt-1.5 w-full rounded-xl border border-current/20 bg-transparent px-4 py-2.5 text-sm">
                        </div>

                        <div class="grid grid-cols-1 gap-3.5" :class="statusKehadiran === 'hadir' ? 'sm:grid-cols-2' : 'sm:grid-cols-1'">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider opacity-75">Konfirmasi Kehadiran</label>
                                <select name="status_kehadiran" data-select2-variant="inherit" x-model="statusKehadiran" @change="statusKehadiran = $event.target.value" class="mt-1.5 w-full rounded-xl border border-current/20 bg-transparent px-3.5 py-2.5 text-sm [&>option]:bg-white [&>option]:text-charcoal">
                                    <option value="hadir" @selected(old('status_kehadiran', 'hadir') === 'hadir')>InsyaAllah Hadir</option>
                                    <option value="ragu" @selected(old('status_kehadiran') === 'ragu')>Masih Ragu</option>
                                    <option value="tidak_hadir" @selected(old('status_kehadiran') === 'tidak_hadir')>Tidak Dapat Hadir</option>
                                </select>
                            </div>
                            <div x-show="statusKehadiran === 'hadir'" x-cloak>
                                <label class="block text-xs font-semibold uppercase tracking-wider opacity-75">Jumlah Tamu</label>
                                <input type="number" name="jumlah_tamu" value="{{ old('jumlah_tamu', 1) }}" min="1" max="20" :required="statusKehadiran === 'hadir'" :disabled="statusKehadiran !== 'hadir'" class="mt-1.5 w-full rounded-xl border border-current/20 bg-transparent px-3.5 py-2.5 text-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider opacity-75">Ucapan &amp; Doa Restu</label>
                            <textarea name="ucapan_doa" rows="3" required placeholder="Tuliskan doa terbaik untuk kedua mempelai..." class="mt-1.5 w-full rounded-xl border border-current/20 bg-transparent px-4 py-2.5 text-sm">{{ old('ucapan_doa') }}</textarea>
                        </div>

                        <button type="submit" class="w-full {{ $kelasRadiusKecil }} px-6 py-3 text-sm font-semibold transition cursor-pointer {{ $kelasTombol ?? 'bg-sage text-white hover:bg-sage/90' }}">
                            Kirim Konfirmasi &amp; Doa
                        </button>
                    </form>
                @endif

                {{-- Daftar Ucapan --}}
                <div class="mt-7 pt-5 border-t border-current/15 space-y-3">
                    <h3 class="font-serif text-lg font-bold">Doa &amp; Ucapan ({{ $undangan->bukuTamu->count() }})</h3>
                    <div data-lenis-prevent class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                        @forelse ($undangan->bukuTamu as $ucapan)
                            <div class="{{ $kelasRadiusSedang }} p-4 border border-current/10 bg-current/[0.03] space-y-1.5">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="font-semibold text-sm">{{ $ucapan->nama_tamu }}</p>
                                    <span class="rounded-full px-2.5 py-0.5 text-[10px] font-semibold bg-current/10">
                                        {{ str_replace('_', ' ', ucfirst($ucapan->status_kehadiran)) }}
                                    </span>
                                </div>
                                <p class="text-xs sm:text-sm opacity-80 leading-relaxed">{{ $ucapan->ucapan_doa }}</p>
                            </div>
                        @empty
                            <p class="text-xs sm:text-sm opacity-65">Jadilah yang pertama memberikan doa restu.</p>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

{{-- SEKSI PENUTUP & TERIMA KASIH (Kapsul Arsitektur Berhias Ornamen Miring Simetris di Atas Jendela Paralaks) --}}
<section
    data-aos="fade-up"
    data-aos-duration="950"
    data-layout-penutup="{{ $gaya }}"
    class="relative py-14 px-5 overflow-hidden"
>
    <div class="fx-scale-in relative max-w-md mx-auto {{ $sudutTajam ? 'rounded-none p-8 border' : 'rounded-t-[10.5rem] rounded-b-3xl pt-14 pb-12 px-7 border-2' }} text-center shadow-2xl overflow-hidden kartu-3d {{ $ekstraKartu }} {{ $kelasKartu ?? 'bg-white/90 text-charcoal border-[#BFA15F]/40' }}">
        @if (! empty($ornamenUrl) && ! $sudutTajam)
            <img src="{{ $ornamenUrl }}" alt="" class="pointer-events-none absolute -bottom-5 -left-6 w-24 opacity-60 ayun-kanan">
            <img src="{{ $ornamenUrl }}" alt="" class="pointer-events-none absolute -bottom-5 -right-6 w-24 opacity-60 ayun-kiri">
        @endif

        <div class="relative z-10 space-y-4">
            @php
                $urlFotoPenutupTema = (! $undangan->modeTanpaFoto()) ? $undangan->urlFotoPenutupKhususDashboard() : null;
            @endphp
            @if ($urlFotoPenutupTema)
                <div class="mx-auto w-44 sm:w-52 overflow-hidden {{ $sudutTajam ? 'rounded-none border border-current/25' : 'rounded-t-[8rem] rounded-b-2xl border-2 border-current/25' }} shadow-xl">
                    <img
                        src="{{ $urlFotoPenutupTema }}"
                        alt="Foto Penutup {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                        class="w-full aspect-[4/5] object-cover object-top"
                    >
                </div>
            @endif

            @if (! empty($bismillahHeader))
                <p class="text-base {{ $aksenKartu }}" style="font-family: 'Amiri', serif;">
                    بَارَكَ اللّٰهُ لَكَ وَبَارَكَ عَلَيْكَ وَجَمَعَ بَيْنَكُمَا فِي خَيْرٍ
                </p>
            @endif

            <p class="text-[10px] font-bold uppercase tracking-[0.34em] {{ $aksenKartu }}">{{ $undangan->teksKustom('judul_penutup', 'Terima Kasih') }}</p>

            <p class="text-xs sm:text-sm opacity-80 leading-relaxed max-w-xs mx-auto">
                {{ $undangan->teksKustom('ucapan_penutup', 'Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir serta memberikan doa restu bagi kedua mempelai.') }}
            </p>

            <div class="pt-3">
                <p class="text-[10px] uppercase tracking-[0.28em] opacity-65">{{ $undangan->teksKustom('label_penutup', 'Kami Yang Berbahagia') }}</p>
                <p class="mt-2 {{ $sudutTajam ? 'font-serif text-2xl sm:text-3xl font-bold uppercase tracking-[0.16em]' : 'font-kaligrafi text-4xl sm:text-5xl leading-tight' }} {{ $aksenKartu }}">
                    {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
                </p>
            </div>
        </div>
    </div>
</section>
