@php
    $pengaturan = $undangan->pengaturan ?? [];
    $alamatKado = trim((string) ($pengaturan['alamat_kado_fisik'] ?? ''));
    $live = $pengaturan['live_streaming'] ?? [];
    $sudutTajam = !empty($sudutEditorial);
    $kelasRadiusBesar = $sudutTajam ? 'rounded-none' : 'rounded-3xl';
    $kelasRadiusSedang = $sudutTajam ? 'rounded-none' : 'rounded-2xl';
    $kelasRadiusKecil = $sudutTajam ? 'rounded-none' : 'rounded-xl';
    $kelasRadiusPill = $sudutTajam ? 'rounded-none' : 'rounded-full';
    $ekstraKartu = $kelasEkstraKartu ?? '';
    $aksenKartu = $kelasAksenKartu ?? ($kelasAksen ?? 'text-champagne');
@endphp

{{-- Live Streaming --}}
@if (!empty($live['aktif']) && !empty($live['link']))
<section data-aos="fade-up" data-aos-duration="1000" class="py-12 px-4">
    <div class="max-w-2xl mx-auto {{ $kelasRadiusBesar }} p-7 text-center kartu-3d masuk-3d {{ $ekstraKartu }} {{ $kelasKartu ?? 'bg-white ring-1 ring-champagne/25 text-charcoal' }}">
        <p class="text-xs font-semibold uppercase tracking-[0.25em] {{ $aksenKartu }}">Siaran Langsung</p>
        <h2 class="mt-2 font-serif text-3xl font-bold">Live Streaming ({{ $live['platform'] ?? 'Online' }})</h2>
        <p class="mt-2 text-sm opacity-75">Bagi kerabat yang berhalangan hadir langsung, silakan menyaksikan momen sakral kami secara virtual.</p>
        <a href="{{ $live['link'] }}" target="_blank" rel="noopener" class="mt-5 inline-flex items-center gap-2 {{ $kelasRadiusPill }} px-6 py-2.5 text-sm font-semibold transition {{ $kelasTombol ?? 'bg-sage text-white hover:bg-sage/90' }}">
            Saksikan Siaran Langsung
        </a>
    </div>
</section>
@endif

{{-- Amplop Digital & Kado Fisik --}}
@if ($undangan->fiturAktif('amplop_digital') && ($undangan->daftarAmplop->isNotEmpty() || $alamatKado !== ''))
<section data-aos="fade-up" data-aos-duration="1000" class="py-14 px-4">
    <div class="max-w-3xl mx-auto text-center">
        <p class="text-xs font-semibold uppercase tracking-[0.25em] {{ $kelasAksen ?? 'text-champagne' }}">Tanda Kasih</p>
        <h2 class="mt-2 font-serif text-3xl sm:text-4xl font-bold">Amplop Digital</h2>
        <p class="mt-2 text-sm opacity-75 max-w-xl mx-auto">Doa restu Anda merupakan karunia terindah bagi kami. Apabila hendak mengirimkan tanda kasih, dapat melalui rekening berikut:</p>

        <div class="mt-7 grid grid-cols-1 gap-4 text-left panggung-3d">
            @foreach ($undangan->daftarAmplop as $amplop)
                <div
                    x-data="{ tersalin: false }"
                    class="{{ $kelasRadiusSedang }} p-5 kartu-3d masuk-3d flex flex-col justify-between gap-4 {{ $ekstraKartu }} {{ $kelasKartu ?? 'bg-white ring-1 ring-champagne/25 text-charcoal' }}"
                >
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider {{ $aksenKartu }}">{{ $amplop->nama_bank }}</p>
                        <p class="mt-1 font-mono text-xl font-bold">{{ $amplop->nomor_rekening }}</p>
                        <p class="mt-0.5 text-xs opacity-75">a.n. {{ $amplop->atas_nama }}</p>
                    </div>
                    <button
                        type="button"
                        @click="navigator.clipboard?.writeText(@js($amplop->nomor_rekening)); tersalin = true; setTimeout(() => tersalin = false, 2500)"
                        class="w-full {{ $kelasRadiusKecil }} px-4 py-2 text-xs font-semibold transition cursor-pointer {{ $kelasTombol ?? 'bg-sage text-white hover:bg-sage/90' }}"
                    >
                        <span x-show="!tersalin">Salin Nomor Rekening</span>
                        <span x-show="tersalin" x-cloak>Berhasil Disalin!</span>
                    </button>
                </div>
            @endforeach
        </div>

        @if ($alamatKado !== '')
            <div class="mt-6 {{ $kelasRadiusSedang }} p-5 text-center kartu-3d masuk-3d {{ $ekstraKartu }} {{ $kelasKartu ?? 'bg-white ring-1 ring-champagne/25 text-charcoal' }}">
                <p class="text-xs font-bold uppercase tracking-wider {{ $aksenKartu }}">Alamat Pengiriman Kado Fisik</p>
                <p class="mt-1.5 text-sm opacity-85">{{ $alamatKado }}</p>
            </div>
        @endif
    </div>
</section>
@endif

{{-- Buku Tamu & RSVP --}}
@if ($undangan->fiturAktif('buku_tamu'))
<section id="buku-tamu" data-aos="fade-up" data-aos-duration="1000" class="py-14 px-4 pb-24">
    <div class="max-w-3xl mx-auto">
        <div class="text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] {{ $kelasAksen ?? 'text-champagne' }}">Konfirmasi &amp; Doa</p>
            <h2 class="mt-2 font-serif text-3xl sm:text-4xl font-bold">Buku Tamu &amp; RSVP</h2>
        </div>

        <div class="mt-8 {{ $kelasRadiusBesar }} p-6 sm:p-8 kartu-3d masuk-3d {{ $kelasKartu ?? 'bg-white ring-1 ring-champagne/25 text-charcoal' }}">
            @if (session('sukses_ucapan'))
                <div data-swal-success="{{ session('sukses_ucapan') }}" hidden aria-hidden="true"></div>
            @endif

            @if ($errors->any())
                <div data-swal-errors="{{ json_encode($errors->all(), JSON_UNESCAPED_UNICODE) }}" hidden aria-hidden="true"></div>
            @endif

            @if (!empty($modeDemo))
                <div x-data="{ demoTerkirim: false }" class="space-y-4">
                    <div class="rounded-xl bg-amber-50 border border-amber-200 px-4 py-2.5 text-xs text-amber-800">
                        Mode Demo: Pengiriman ucapan tidak disimpan ke database.
                    </div>
                    <form @submit.prevent="demoTerkirim = true" class="space-y-4">
                        <input type="text" value="{{ $namaTamu }}" class="w-full rounded-xl border border-current/20 bg-transparent px-4 py-2.5 text-sm" placeholder="Nama Tamu">
                        <div class="grid grid-cols-2 gap-3">
                            <select data-select2-variant="inherit" class="w-full rounded-xl border border-current/20 bg-transparent px-3.5 py-2.5 text-sm [&>option]:bg-white [&>option]:text-charcoal">
                                <option value="hadir">InsyaAllah Hadir</option>
                                <option value="ragu">Masih Ragu</option>
                                <option value="tidak_hadir">Berhalangan Hadir</option>
                            </select>
                            <input type="number" min="1" max="10" value="1" class="rounded-xl border border-current/20 bg-transparent px-3.5 py-2.5 text-sm">
                        </div>
                        <textarea rows="3" class="w-full rounded-xl border border-current/20 bg-transparent px-4 py-2.5 text-sm" placeholder="Tulis doa terbaik untuk kedua mempelai..."></textarea>
                        <button type="submit" class="w-full {{ $kelasRadiusKecil }} px-6 py-3 text-sm font-semibold cursor-pointer {{ $kelasTombol ?? 'bg-sage text-white' }}">
                            Kirim Ucapan (Simulasi)
                        </button>
                        <p x-show="demoTerkirim" x-cloak class="text-xs text-emerald-600 font-semibold">Simulasi ucapan berhasil ditampilkan pada mode demo!</p>
                    </form>
                </div>
            @elseif (! $undangan->sudahAktifPublik())
                <div class="rounded-2xl border border-amber-300/70 bg-amber-50/90 p-5 text-charcoal space-y-3">
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
                <form action="{{ route('undangan.ucapan', $undangan->slug) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider opacity-75">Nama Lengkap</label>
                        <input type="text" name="nama_tamu" value="{{ old('nama_tamu', $namaTamu !== 'Tamu Undangan' ? $namaTamu : '') }}" required placeholder="Masukkan nama Anda" class="mt-1.5 w-full rounded-xl border border-current/20 bg-transparent px-4 py-2.5 text-sm">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider opacity-75">Konfirmasi Kehadiran</label>
                            <select name="status_kehadiran" data-select2-variant="inherit" class="mt-1.5 w-full rounded-xl border border-current/20 bg-transparent px-3.5 py-2.5 text-sm [&>option]:bg-white [&>option]:text-charcoal">
                                <option value="hadir" @selected(old('status_kehadiran') === 'hadir')>InsyaAllah Hadir</option>
                                <option value="ragu" @selected(old('status_kehadiran') === 'ragu')>Masih Ragu</option>
                                <option value="tidak_hadir" @selected(old('status_kehadiran') === 'tidak_hadir')>Tidak Dapat Hadir</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider opacity-75">Jumlah Tamu</label>
                            <input type="number" name="jumlah_tamu" value="{{ old('jumlah_tamu', 1) }}" min="1" max="20" required class="mt-1.5 w-full rounded-xl border border-current/20 bg-transparent px-3.5 py-2.5 text-sm">
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
            <div class="mt-8 pt-6 border-t border-current/10 space-y-4">
                <h3 class="font-serif text-xl font-bold">Doa &amp; Ucapan ({{ $undangan->bukuTamu->count() }})</h3>
                @forelse ($undangan->bukuTamu as $ucapan)
                    <div class="{{ $kelasRadiusSedang }} p-4 border border-current/10 space-y-1.5">
                        <div class="flex items-center justify-between gap-2">
                            <p class="font-semibold text-sm">{{ $ucapan->nama_tamu }}</p>
                            <span class="rounded-full px-2.5 py-0.5 text-[11px] font-semibold bg-current/10">
                                {{ str_replace('_', ' ', ucfirst($ucapan->status_kehadiran)) }}
                            </span>
                        </div>
                        <p class="text-sm opacity-80 leading-relaxed">{{ $ucapan->ucapan_doa }}</p>
                    </div>
                @empty
                    <p class="text-sm opacity-65">Jadilah yang pertama memberikan doa restu.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endif
