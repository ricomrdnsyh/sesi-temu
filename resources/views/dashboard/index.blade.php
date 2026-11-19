@extends('layouts.aplikasi')

@section('judul', 'Beranda | SesiTemu')

@section('konten')
    @php
        $pengguna = auth()->user();
        $jumlahUndangan = $daftarUndangan->count();
        $jumlahUndanganAktif = $daftarUndangan->filter(fn($u) => $u->sudahAktifPublik())->count();
        $totalTamuHadir = $daftarUndangan->sum(fn($u) => $u->bukuTamu->where('status_kehadiran', 'hadir')->count());
        $temaDefaultId = (string) old('tema_id', (string) ($daftarTema->first()?->id ?? ''));
        $undanganSorotan = $daftarUndangan->first();

        $jamSekarang = now()->hour;
        $sapaanWaktu = match (true) {
            $jamSekarang >= 4 && $jamSekarang < 11 => 'Selamat Pagi',
            $jamSekarang >= 11 && $jamSekarang < 15 => 'Selamat Siang',
            $jamSekarang >= 15 && $jamSekarang < 18 => 'Selamat Sore',
            default => 'Selamat Malam',
        };
        $namaTampilAkun = trim((string) $pengguna->nama);
        $pesanWaBantuan = "Halo Admin SesiTemu, saya {$pengguna->nama} ingin konsultasi pembuatan undangan pernikahan digital.";
    @endphp

    <div x-data="{
        modalBuatBaru: {{ request()->boolean('buat') || $errors->any() ? 'true' : 'false' }},
        temaTerpilihModal: @js($temaDefaultId),
        previewTerbukaId: null,
        sampulLightboxSlug: null,
        bukaModalDenganTema(temaId) {
            this.previewTerbukaId = null;
            this.temaTerpilihModal = String(temaId);
            this.modalBuatBaru = true;
        },
        bukaModalPakai(payload) {
            this.bukaModalDenganTema(payload.id);
        },
        bukaLightboxSampul(slug) {
            this.previewTerbukaId = null;
            this.sampulLightboxSlug = slug;
        },
        tutupLightboxSampul() {
            this.sampulLightboxSlug = null;
        }
    }" class="min-h-screen flex flex-col bg-ivory">
        @include('dashboard._top-nav', ['halamanAktif' => 'beranda'])

        <main id="beranda-client"
            class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 pt-4 sm:pt-6 pb-28 md:py-8 space-y-5 sm:space-y-7">
            @if ($errors->any())
                <div class="rounded-2xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Hero Banner Hijau Sage + Overlapping Floating White Summary Bar --}}
            <section>
                <div
                    class="relative overflow-hidden rounded-[1.75rem] bg-gradient-to-br from-[#354A40] via-sage to-[#445B50] text-ivory px-5 sm:px-7 pt-5 sm:pt-6 pb-12 sm:pb-14 shadow-md ring-1 ring-sage/30">
                    {{-- Dekorasi Geometris & Ambient Halus --}}
                    <div aria-hidden="true"
                        class="pointer-events-none absolute -right-12 -top-16 h-52 w-52 sm:h-64 sm:w-64 rounded-full bg-champagne/25 blur-2xl">
                    </div>
                    <div aria-hidden="true"
                        class="pointer-events-none absolute right-6 -top-10 h-36 w-36 rounded-full border border-white/10">
                    </div>
                    <div aria-hidden="true"
                        class="pointer-events-none absolute -left-10 -bottom-12 h-36 w-36 rounded-full bg-black/15 blur-2xl">
                    </div>

                    <div class="relative z-10 space-y-3.5">
                        {{-- Baris Atas: Pill Sapaan --}}
                        <div class="flex items-center">
                            <span
                                class="inline-flex min-w-0 max-w-full items-center gap-2 rounded-full bg-white/15 backdrop-blur-xs px-3 py-1 text-[11px] font-medium tracking-wide text-ivory ring-1 ring-white/20">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#F5E3B8] shrink-0"></span>
                                <span class="truncate">{{ $sapaanWaktu }}, {{ $namaTampilAkun }}</span>
                            </span>
                        </div>

                        {{-- Judul, Deskripsi & Tombol CTA Desktop --}}
                        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                            <div class="space-y-1.5 max-w-xl">
                                <h1
                                    class="font-sans text-[1.35rem] sm:text-[1.85rem] font-bold text-white leading-snug tracking-tight">
                                    {{ $jumlahUndangan > 0 ? 'Kelola Undangan Pernikahan Anda' : 'Wujudkan Undangan Digital Impian' }}
                                </h1>
                                <p class="text-xs sm:text-sm text-white/85 leading-relaxed">
                                    {{ $jumlahUndangan > 0
                                        ? 'Pantau kehadiran tamu, atur acara & galeri, atau perbarui tema kapan saja.'
                                        : 'Susun draft undangan gratis dalam hitungan menit, bagikan dengan mudah saat siap disebar.' }}
                                </p>
                            </div>

                            <button type="button" @click="modalBuatBaru = true"
                                class="hidden sm:inline-flex items-center justify-center gap-2 rounded-2xl bg-champagne px-5 py-3 text-sm font-bold text-charcoal shadow-md hover:bg-[#d1b26d] active:scale-95 transition cursor-pointer shrink-0">
                                <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M12 5v14" />
                                    <path d="M5 12h14" />
                                </svg>
                                <span>Buat Draft</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Overlapping Floating White Summary Dock --}}
                <div class="relative z-20 mx-3 sm:mx-6 -mt-8 sm:-mt-9">
                    <div
                        class="rounded-2xl bg-white px-2 sm:px-4 py-3.5 sm:py-4 shadow-md ring-1 ring-champagne/30 grid grid-cols-3 divide-x divide-champagne/25 text-center">
                        <a href="{{ route('dashboard.undangan.index') }}"
                            class="group px-2 flex flex-col items-center justify-center active:scale-95 transition">
                            <p
                                class="font-sans tabular-nums text-lg sm:text-2xl font-bold text-charcoal group-hover:text-sage transition-colors leading-none">
                                {{ $jumlahUndangan }}</p>
                            <p class="mt-1.5 text-[11px] sm:text-xs font-medium text-charcoal/60">Undangan</p>
                        </a>

                        <a href="{{ route('dashboard.undangan.index') }}"
                            class="group px-2 flex flex-col items-center justify-center active:scale-95 transition">
                            <p
                                class="font-sans tabular-nums text-lg sm:text-2xl font-bold text-sage group-hover:scale-105 transition-transform leading-none">
                                {{ $jumlahUndanganAktif }}</p>
                            <p class="mt-1.5 text-[11px] sm:text-xs font-medium text-charcoal/60">Aktif</p>
                        </a>

                        <div class="px-2 flex flex-col items-center justify-center">
                            <p
                                class="font-sans tabular-nums text-lg sm:text-2xl font-bold text-[#8A6D33] leading-none">
                                {{ $totalTamuHadir }}</p>
                            <p class="mt-1.5 text-[11px] sm:text-xs font-medium text-charcoal/60">Tamu Hadir</p>
                        </div>
                    </div>
                </div>
            </section>

    {{-- 4 Kartu Putih Elevated dengan Inner Squircle Icon --}}
    <section aria-label="Aksi Cepat">
        <div class="grid grid-cols-4 gap-2.5 sm:gap-4">
            <button type="button" @click="modalBuatBaru = true"
                class="group flex flex-col items-center justify-center gap-2 rounded-2xl bg-white px-2 py-3.5 sm:py-4 shadow-xs ring-1 ring-champagne/25 hover:ring-sage/45 hover:-translate-y-0.5 active:scale-95 transition cursor-pointer">
                <span
                    class="inline-flex h-11 w-11 sm:h-12 sm:w-12 items-center justify-center rounded-xl bg-sage text-white shadow-xs group-hover:bg-[#3b5047] transition">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 5v14" />
                        <path d="M5 12h14" />
                    </svg>
                </span>
                <span class="text-[11px] sm:text-xs font-semibold text-charcoal leading-tight text-center">Buat
                    Draft</span>
            </button>

            <a href="{{ route('dashboard.undangan.index') }}"
                class="group flex flex-col items-center justify-center gap-2 rounded-2xl bg-white px-2 py-3.5 sm:py-4 shadow-xs ring-1 ring-champagne/25 hover:ring-champagne/65 hover:-translate-y-0.5 active:scale-95 transition">
                <span
                    class="relative inline-flex h-11 w-11 sm:h-12 sm:w-12 items-center justify-center rounded-xl bg-ivory text-charcoal ring-1 ring-charcoal/10 group-hover:bg-champagne/15 group-hover:text-[#8A6D33] transition">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect width="20" height="16" x="2" y="4" rx="2" />
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                    </svg>
                    @if ($jumlahUndangan > 0)
                        <span
                            class="absolute -top-1.5 -right-1.5 inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-sage px-1 font-sans tabular-nums text-[10px] font-bold text-white ring-2 ring-white">
                            {{ $jumlahUndangan }}
                        </span>
                    @endif
                </span>
                <span class="text-[11px] sm:text-xs font-semibold text-charcoal leading-tight text-center">Undangan</span>
            </a>

            <a href="{{ route('dashboard.katalog') }}"
                class="group flex flex-col items-center justify-center gap-2 rounded-2xl bg-white px-2 py-3.5 sm:py-4 shadow-xs ring-1 ring-champagne/25 hover:ring-champagne/65 hover:-translate-y-0.5 active:scale-95 transition">
                <span
                    class="inline-flex h-11 w-11 sm:h-12 sm:w-12 items-center justify-center rounded-xl bg-champagne/15 text-[#8A6D33] ring-1 ring-champagne/30 group-hover:bg-champagne/25 transition">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect width="7" height="7" x="3" y="3" rx="1.5" />
                        <rect width="7" height="7" x="14" y="3" rx="1.5" />
                        <rect width="7" height="7" x="14" y="14" rx="1.5" />
                        <rect width="7" height="7" x="3" y="14" rx="1.5" />
                    </svg>
                </span>
                <span class="text-[11px] sm:text-xs font-semibold text-charcoal leading-tight text-center">Katalog</span>
            </a>

            <a href="{{ \App\Support\PengaturanSesiTemu::urlWaAdmin($pesanWaBantuan) }}" target="_blank" rel="noopener"
                class="group flex flex-col items-center justify-center gap-2 rounded-2xl bg-white px-2 py-3.5 sm:py-4 shadow-xs ring-1 ring-champagne/25 hover:ring-emerald-300 hover:-translate-y-0.5 active:scale-95 transition">
                <span
                    class="inline-flex h-11 w-11 sm:h-12 sm:w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/70 group-hover:bg-emerald-100 transition">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path
                            d="M12.031 2c-5.516 0-9.969 4.453-9.969 9.969 0 1.766.469 3.484 1.344 5l-1.406 5.156 5.281-1.375c1.469.797 3.109 1.219 4.75 1.219 5.516 0 9.969-4.453 9.969-9.969S17.547 2 12.031 2Zm5.813 14.125c-.25.703-1.438 1.344-2 1.422-.516.078-1.172.109-1.891-.125-.438-.141-1-.328-1.719-.641-3.016-1.313-4.984-4.359-5.141-4.563-.156-.203-1.234-1.641-1.234-3.125s.781-2.219 1.063-2.516c.281-.297.609-.375.813-.375.203 0 .406 0 .578.016.188.016.438-.078.688.531.25.609.859 2.094.938 2.25.078.156.125.344.016.547-.109.203-.156.344-.313.516-.156.172-.328.391-.469.516-.156.156-.313.328-.141.641.172.313.781 1.297 1.672 2.094 1.156 1.031 2.125 1.344 2.438 1.5.313.156.484.125.672-.078.188-.203.781-.906.984-1.219.203-.313.406-.266.688-.156.281.109 1.797.844 2.109 1 .313.156.516.234.594.359.078.125.078.734-.172 1.438Z" />
                    </svg>
                </span>
                <span class="text-[11px] sm:text-xs font-semibold text-charcoal leading-tight text-center">Bantuan
                    WA</span>
            </a>
        </div>
    </section>

    {{-- Kartu Kontekstual: Lanjutkan Undangan Terakhir ATAU Stepper Mulai Cepat --}}
    @if ($undanganSorotan)
        @php
            $statusSorotan = $undanganSorotan->statusKode();
            $kelengkapanSorotan = $undanganSorotan->ringkasanKelengkapan();
            $acaraTerdekatSorotan = $undanganSorotan->acaraTerdekat();
            $badgeHariSorotan = null;
            if ($acaraTerdekatSorotan?->tanggal_acara) {
                $selisih = now()
                    ->startOfDay()
                    ->diffInDays($acaraTerdekatSorotan->tanggal_acara->copy()->startOfDay(), false);
                $badgeHariSorotan =
                    $selisih > 0
                        ? "H-{$selisih}"
                        : ($selisih === 0
                            ? 'Hari Ini'
                            : $acaraTerdekatSorotan->tanggal_acara->translatedFormat('d M Y'));
            }
            $urlPublikSorotan = Route::has('undangan.tampil')
                ? route('undangan.tampil', $undanganSorotan->slug)
                : url('/' . $undanganSorotan->slug);
            $thumbnailSorotan = $undanganSorotan->urlFotoSampul() ?? $undanganSorotan->tema?->urlGambarPratinjau();
            $jumlahHadirSorotan = $undanganSorotan->bukuTamu->where('status_kehadiran', 'hadir')->count();
            $pesanWaSorotan = "Halo Admin SesiTemu, saya ingin mengaktifkan undangan saya dengan link sesitemu.id/{$undanganSorotan->slug} (ID Undangan #{$undanganSorotan->id}).";
        @endphp

        <section class="space-y-3">
            <div class="flex items-center justify-between gap-2">
                <h2 class="font-logo text-lg sm:text-xl font-bold text-charcoal tracking-tight">
                    Lanjutkan Undangan Terakhir
                </h2>
                <a href="{{ route('dashboard.undangan.index') }}"
                    class="inline-flex items-center gap-1 rounded-full bg-white px-3 py-1 text-xs font-semibold text-sage ring-1 ring-champagne/30 hover:bg-sage hover:text-white transition shrink-0">
                    <span>Semua ({{ $jumlahUndangan }})</span>
                    <span aria-hidden="true">&rsaquo;</span>
                </a>
            </div>

            <div x-data="{ tersalin: false }"
                class="rounded-[1.5rem] bg-white p-4 sm:p-5 shadow-xs ring-1 ring-champagne/25 space-y-4">
                <div class="flex flex-col md:flex-row md:items-center gap-4">
                    <div
                        class="relative h-32 md:h-30 md:w-44 rounded-2xl overflow-hidden bg-gradient-to-br from-sage to-[#3b5047] shrink-0 ring-1 ring-champagne/25">
                        @if ($thumbnailSorotan)
                            <img src="{{ $thumbnailSorotan }}"
                                alt="{{ $undanganSorotan->nama_panggilan_pria }} & {{ $undanganSorotan->nama_panggilan_wanita }}"
                                class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-charcoal/70 via-charcoal/10 to-transparent">
                            </div>
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <span
                                    class="font-logo text-2xl font-bold text-champagne">{{ $undanganSorotan->inisialMempelai() }}</span>
                            </div>
                        @endif

                        <div class="absolute top-2.5 left-2.5">
                            @if ($statusSorotan === 'kedaluwarsa')
                                <span
                                    class="rounded-full bg-red-600/95 px-2.5 py-0.5 text-[10px] font-bold text-white shadow-xs">Kedaluwarsa</span>
                            @elseif ($statusSorotan === 'aktif')
                                <span
                                    class="inline-flex items-center gap-1 rounded-full bg-emerald-600/95 px-2.5 py-0.5 text-[10px] font-bold text-white shadow-xs">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-200 animate-pulse"></span>
                                    Aktif
                                </span>
                            @else
                                <span
                                    class="rounded-full bg-amber-500/95 px-2.5 py-0.5 text-[10px] font-bold text-white shadow-xs">Draft</span>
                            @endif
                        </div>

                        @if ($badgeHariSorotan)
                            <span
                                class="absolute bottom-2.5 right-2.5 rounded-full bg-charcoal/80 backdrop-blur-xs px-2.5 py-0.5 font-sans tabular-nums text-[10px] font-bold text-champagne ring-1 ring-white/15">
                                {{ $badgeHariSorotan }}
                            </span>
                        @endif
                    </div>

                    <div class="min-w-0 flex-1 space-y-2.5">
                        <div class="flex flex-wrap items-start justify-between gap-2">
                            <div class="min-w-0">
                                <p class="text-[11px] font-medium text-charcoal/55 truncate">
                                    {{ $undanganSorotan->tema?->nama_tema ?? 'Tema Pilihan' }}
                                    @if ($undanganSorotan->tema)
                                        &bull; <span
                                            class="font-sans tabular-nums">{{ $undanganSorotan->tema->hargaFormatted() }}</span>
                                    @endif
                                </p>
                                <h3
                                    class="mt-0.5 font-logo text-xl sm:text-2xl font-bold text-charcoal tracking-tight truncate">
                                    {{ $undanganSorotan->nama_panggilan_pria }} &amp;
                                    {{ $undanganSorotan->nama_panggilan_wanita }}
                                </h3>
                            </div>

                            <div
                                class="inline-flex items-center gap-1.5 rounded-xl bg-ivory px-2.5 py-1 ring-1 ring-champagne/25 max-w-full">
                                <span
                                    class="text-xs font-mono text-sage truncate">sesitemu.id/{{ $undanganSorotan->slug }}</span>
                                <button type="button"
                                    @click="navigator.clipboard?.writeText(@js($urlPublikSorotan)); tersalin = true; setTimeout(() => tersalin = false, 2000)"
                                    class="rounded-lg bg-white px-2 py-0.5 text-[10px] font-bold text-charcoal ring-1 ring-champagne/30 hover:text-sage transition shrink-0 cursor-pointer"
                                    x-text="tersalin ? 'Tersalin!' : 'Salin'"></button>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-medium text-charcoal/65">Kelengkapan Konten</span>
                                <span
                                    class="font-sans tabular-nums font-bold text-sage">{{ $kelengkapanSorotan['terpenuhi'] }}/{{ $kelengkapanSorotan['total'] }}
                                    &bull; {{ $kelengkapanSorotan['persen'] }}%</span>
                            </div>
                            <div class="h-1.5 w-full rounded-full bg-ivory overflow-hidden ring-1 ring-champagne/20">
                                <div class="h-full rounded-full transition-all duration-300 {{ $kelengkapanSorotan['persen'] === 100 ? 'bg-sage' : 'bg-gradient-to-r from-sage to-champagne' }}"
                                    style="width: {{ $kelengkapanSorotan['persen'] }}%"></div>
                            </div>
                            <div class="flex flex-wrap gap-1.5 pt-0.5">
                                @foreach ($kelengkapanSorotan['butir'] as $butir)
                                    @if ($butir['selesai'])
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full bg-sage/10 px-2.5 py-0.5 text-[11px] font-semibold text-sage">
                                            <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                                stroke-linejoin="round" aria-hidden="true">
                                                <polyline points="20 6 9 17 4 12" />
                                            </svg>
                                            {{ $butir['label'] }}
                                        </span>
                                    @else
                                        <a href="{{ route('dashboard.undangan.kelola', [$undanganSorotan, 'tab' => $butir['tab']]) }}"
                                            class="inline-flex items-center gap-1 rounded-full bg-ivory px-2.5 py-0.5 text-[11px] font-semibold text-charcoal/70 ring-1 ring-champagne/30 hover:text-sage transition">
                                            <span>+ {{ $butir['label'] }}</span>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="pt-3 border-t border-champagne/15 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-4 text-xs text-charcoal/60">
                        <span><strong
                                class="font-sans tabular-nums text-charcoal">{{ $undanganSorotan->daftarAcara->count() }}</strong>
                            Acara</span>
                        <span><strong class="font-sans tabular-nums text-sage">{{ $jumlahHadirSorotan }}</strong>
                            Hadir</span>
                        <span><strong
                                class="font-sans tabular-nums text-[#8A6D33]">{{ $undanganSorotan->bukuTamu->count() }}</strong>
                            Ucapan</span>
                    </div>

                    <div class="grid grid-cols-2 sm:flex sm:items-center gap-2">
                        <a href="{{ route('dashboard.undangan.kelola', $undanganSorotan) }}"
                            class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-sage px-4 py-2 text-xs sm:text-sm font-semibold text-white hover:bg-[#3b5047] active:scale-95 transition">
                            <svg class="h-4 w-4 text-champagne shrink-0" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.375 2.625a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4Z" />
                            </svg>
                            <span>Lanjut Kelola</span>
                        </a>
                        <a href="{{ $urlPublikSorotan }}" target="_blank"
                            class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-charcoal/15 bg-white px-4 py-2 text-xs sm:text-sm font-semibold text-charcoal hover:bg-ivory active:scale-95 transition">
                            <svg class="h-4 w-4 text-sage shrink-0" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            <span>Lihat</span>
                        </a>
                        @if (!$undanganSorotan->status_publikasi && !auth()->user()->adalahAdmin())
                            <a href="{{ route('dashboard.undangan.kelola', [$undanganSorotan, 'tab' => 'aktivasi']) }}"
                                class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-champagne px-4 py-2 text-xs sm:text-sm font-semibold text-charcoal hover:bg-champagne/90 active:scale-95 transition">
                                <span>Aktifkan</span>
                            </a>
                            <a href="{{ \App\Support\PengaturanSesiTemu::urlWaAdmin($pesanWaSorotan) }}" target="_blank"
                                rel="noopener"
                                class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-champagne px-3.5 py-2 text-xs sm:text-sm font-semibold text-charcoal hover:bg-champagne/10 active:scale-95 transition">
                                <svg class="h-4 w-4 text-sage shrink-0" viewBox="0 0 24 24" fill="currentColor"
                                    aria-hidden="true">
                                    <path
                                        d="M12.031 2c-5.516 0-9.969 4.453-9.969 9.969 0 1.766.469 3.484 1.344 5l-1.406 5.156 5.281-1.375c1.469.797 3.109 1.219 4.75 1.219 5.516 0 9.969-4.453 9.969-9.969S17.547 2 12.031 2Zm5.813 14.125c-.25.703-1.438 1.344-2 1.422-.516.078-1.172.109-1.891-.125-.438-.141-1-.328-1.719-.641-3.016-1.313-4.984-4.359-5.141-4.563-.156-.203-1.234-1.641-1.234-3.125s.781-2.219 1.063-2.516c.281-.297.609-.375.813-.375.203 0 .406 0 .578.016.188.016.438-.078.688.531.25.609.859 2.094.938 2.25.078.156.125.344.016.547-.109.203-.156.344-.313.516-.156.172-.328.391-.469.516-.156.156-.313.328-.141.641.172.313.781 1.297 1.672 2.094 1.156 1.031 2.125 1.344 2.438 1.5.313.156.484.125.672-.078.188-.203.781-.906.984-1.219.203-.313.406-.266.688-.156.281.109 1.797.844 2.109 1 .313.156.516.234.594.359.078.125.078.734-.172 1.438Z" />
                                </svg>
                                <span>Chat Admin</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @else
        {{-- Panduan 3 Langkah Bergaya Bento App Cards (Swipeable di Mobile, 3-Kolom di Desktop) --}}
        <section class="space-y-3">
            <div class="flex items-center justify-between gap-2">
                <div>
                    <h2 class="font-sans text-base sm:text-lg font-bold text-charcoal tracking-tight">
                        Mulai dalam 3 Langkah Mudah
                    </h2>
                    <p class="text-[11.5px] sm:text-xs text-charcoal/55">Alur singkat dari pilih tema sampai sebar
                        undangan.</p>
                </div>
            </div>

            <div
                class="flex overflow-x-auto no-scrollbar gap-3.5 sm:gap-4 snap-x snap-mandatory scroll-px-4 sm:scroll-px-0 pb-1 -mx-4 px-4 sm:mx-0 sm:px-0 md:grid md:grid-cols-3 md:overflow-visible">
                {{-- Langkah 01: Kartu Utama Sage (Identik dengan Warna Hijau Tombol) --}}
                <a href="{{ route('dashboard.katalog') }}"
                    class="group relative w-[256px] sm:w-[272px] md:w-auto shrink-0 snap-start overflow-hidden rounded-[1.45rem] bg-gradient-to-br from-sage via-[#445B50] to-[#3b5047] p-5 text-ivory shadow-md ring-1 ring-sage/30 hover:-translate-y-0.5 active:scale-[0.98] transition flex flex-col justify-between gap-5">
                    <div aria-hidden="true"
                        class="pointer-events-none absolute -bottom-8 -right-8 h-28 w-28 rounded-full bg-white/[0.08]">
                    </div>

                    <div class="relative z-10 flex items-center justify-between gap-2">
                        <span
                            class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/15 text-[#F5E3B8] ring-1 ring-white/20 backdrop-blur-xs">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="13.5" cy="6.5" r=".5" fill="currentColor" />
                                <circle cx="17.5" cy="10.5" r=".5" fill="currentColor" />
                                <circle cx="8.5" cy="7.5" r=".5" fill="currentColor" />
                                <circle cx="6.5" cy="12.5" r=".5" fill="currentColor" />
                                <path
                                    d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z" />
                            </svg>
                        </span>
                        <span class="font-logo text-xl font-bold text-white/35 select-none">01</span>
                    </div>

                    <div class="relative z-10 space-y-1.5">
                        <p class="font-sans text-[15px] font-bold text-white leading-snug">Pilih Tema Desain</p>
                        <p class="text-xs text-white/85 leading-relaxed">Eksplorasi gaya modern, adat, luxury,
                            hingga islami yang sesuai impian.</p>
                    </div>

                    <div class="relative z-10 flex items-center justify-between pt-1 text-xs font-semibold text-[#F5E3B8]">
                        <span>Jelajahi Katalog</span>
                        <svg class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M5 12h14" />
                            <path d="m12 5 7 7-7 7" />
                        </svg>
                    </div>
                </a>

                {{-- Langkah 02: Kartu Putih Aksen Emas --}}
                <button type="button" @click="modalBuatBaru = true"
                    class="group relative w-[256px] sm:w-[272px] md:w-auto shrink-0 snap-start overflow-hidden rounded-[1.45rem] bg-white p-5 text-left shadow-xs ring-1 ring-champagne/30 hover:ring-champagne hover:-translate-y-0.5 active:scale-[0.98] transition cursor-pointer flex flex-col justify-between gap-5">
                    <div aria-hidden="true"
                        class="pointer-events-none absolute -bottom-8 -right-8 h-28 w-28 rounded-full bg-champagne/10">
                    </div>

                    <div class="relative z-10 flex items-center justify-between gap-2">
                        <span
                            class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-champagne/15 text-[#8A6D33] ring-1 ring-champagne/30">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.375 2.625a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4Z" />
                            </svg>
                        </span>
                        <span class="font-logo text-xl font-bold text-champagne/40 select-none">02</span>
                    </div>

                    <div class="relative z-10 space-y-1.5">
                        <p
                            class="font-sans text-[15px] font-bold text-charcoal group-hover:text-[#8A6D33] transition leading-snug">
                            Lengkapi Konten</p>
                        <p class="text-xs text-charcoal/60 leading-relaxed">Isi info mempelai, jadwal acara,
                            lokasi, galeri foto &amp; amplop digital.</p>
                    </div>

                    <div class="relative z-10 flex items-center justify-between pt-1 text-xs font-semibold text-[#8A6D33]">
                        <span>Buat Draft Gratis</span>
                        <svg class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M5 12h14" />
                            <path d="m12 5 7 7-7 7" />
                        </svg>
                    </div>
                </button>

                {{-- Langkah 03: Kartu Putih Aksen Sage --}}
                <div
                    class="relative w-[256px] sm:w-[272px] md:w-auto shrink-0 snap-start overflow-hidden rounded-[1.45rem] bg-white p-5 shadow-xs ring-1 ring-champagne/30 flex flex-col justify-between gap-5">
                    <div aria-hidden="true"
                        class="pointer-events-none absolute -bottom-8 -right-8 h-28 w-28 rounded-full bg-sage/[0.06]">
                    </div>

                    <div class="relative z-10 flex items-center justify-between gap-2">
                        <span
                            class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-sage/10 text-sage ring-1 ring-sage/20">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="m22 2-7 20-4-9-9-4Z" />
                                <path d="M22 2 11 13" />
                            </svg>
                        </span>
                        <span class="font-logo text-xl font-bold text-sage/30 select-none">03</span>
                    </div>

                    <div class="relative z-10 space-y-1.5">
                        <p class="font-sans text-[15px] font-bold text-charcoal leading-snug">Aktif &amp; Sebar WA
                        </p>
                        <p class="text-xs text-charcoal/60 leading-relaxed">Aktifkan undangan &amp; kirim link
                            personal ke tamu tanpa batas.</p>
                    </div>

                    <div class="relative z-10 flex items-center justify-between pt-1 text-xs font-semibold text-sage">
                        <span>Link Personal &amp; RSVP</span>
                        <span class="inline-flex h-2 w-2 rounded-full bg-sage"></span>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Karosel Pilihan Tema Favorit (Selaras dengan Katalog: Poster Bersih + Preview 2 Mode + Pakai Tema Ini) --}}
    @if ($daftarTema->isNotEmpty())
        <section class="space-y-3.5">
            <div class="flex items-center justify-between gap-2">
                <div>
                    <h2 class="font-sans text-base sm:text-lg font-bold text-charcoal tracking-tight">
                        Pilihan Tema Favorit
                    </h2>
                    <p class="text-[11.5px] sm:text-xs text-charcoal/60">Sentuh <strong>Preview</strong> untuk uji
                        mode Pakai Foto atau Tanpa Foto.</p>
                </div>
                <a href="{{ route('dashboard.katalog') }}"
                    class="inline-flex items-center gap-0.5 rounded-full bg-white px-3 py-1.5 text-xs font-semibold text-sage ring-1 ring-champagne/35 hover:bg-sage hover:text-white transition shrink-0">
                    <span>Semua</span>
                    <span aria-hidden="true">&rsaquo;</span>
                </a>
            </div>

            <div
                class="flex overflow-x-auto no-scrollbar gap-4 snap-x snap-mandatory scroll-px-4 sm:scroll-px-0 pb-2 -mx-4 px-4 sm:mx-0 sm:px-0 lg:grid lg:grid-cols-4 lg:overflow-visible">
                @foreach ($daftarTema->take(4) as $tema)
                    @php $infoTier = $tema->infoTier(); @endphp
                    <div
                        class="w-[268px] sm:w-[280px] lg:w-auto shrink-0 snap-start rounded-[1.35rem] bg-white ring-1 ring-champagne/25 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition flex flex-col justify-between relative">
                        {{-- Poster Sampul 3-Ponsel Bersih Tanpa Badge Menumpuk di Atas --}}
                        <div>
                            <button type="button" @click="bukaLightboxSampul('{{ $tema->slug }}')"
                                aria-label="Perbesar sampul {{ $tema->nama_tema }}"
                                class="group/poster relative block w-full overflow-hidden rounded-t-[1.35rem] bg-ivory text-left cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-sage">
                                <div class="transition-transform duration-500 group-hover/poster:scale-[1.02]">
                                    <x-poster-sampul-tema :tema="$tema" />
                                </div>

                                <span
                                    class="pointer-events-none absolute bottom-2 right-2 z-20 inline-flex items-center gap-1 rounded-full bg-charcoal/80 px-2.5 py-1 text-[10px] font-semibold text-white backdrop-blur-xs shadow-sm opacity-90 group-hover/poster:opacity-100 group-hover/poster:bg-sage transition">
                                    <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        aria-hidden="true">
                                        <circle cx="11" cy="11" r="8" />
                                        <path d="m21 21-4.3-4.3" />
                                        <path d="M11 8v6" />
                                        <path d="M8 11h6" />
                                    </svg>
                                    <span>Lihat Sampul</span>
                                </span>
                            </button>

                            <div class="p-3.5 sm:p-4 space-y-1.5">
                                <div class="flex flex-wrap items-center justify-between gap-1.5 text-[10px]">
                                    <div class="flex items-center gap-1.5">
                                        <span
                                            class="font-bold uppercase tracking-wider text-[#8A6D33]">{{ $tema->kategoriLabel() }}</span>
                                        <span class="text-charcoal/25">&bull;</span>
                                        <span
                                            class="inline-flex items-center rounded-full px-2 py-0.5 text-[9.5px] font-bold uppercase tracking-wider {{ $infoTier['badge_class'] }}">
                                            {{ $infoTier['label'] }}
                                        </span>
                                    </div>
                                    @if ($tema->adaDiskon())
                                        <span
                                            class="rounded-full bg-rose-600 px-2 py-0.5 text-[9.5px] font-bold text-white">
                                            {{ $tema->labelBadgeDiskon() }}
                                        </span>
                                    @endif
                                </div>

                                <h3
                                    class="font-logo text-lg sm:text-xl font-bold text-charcoal leading-snug tracking-tight truncate">
                                    {{ $tema->nama_tema }}
                                </h3>

                                <div class="flex items-baseline gap-1.5 pt-0.5">
                                    @if ($tema->adaDiskon())
                                        <span
                                            class="font-sans tabular-nums text-[11px] text-charcoal/45 line-through">{{ $tema->hargaAsliFormatted() }}</span>
                                    @endif
                                    <span
                                        class="font-sans tabular-nums text-[15px] sm:text-base font-bold tracking-tight {{ $tema->adaDiskon() ? 'text-rose-600' : 'text-charcoal' }}">
                                        {{ $tema->hargaFormatted() }}
                                    </span>
                                    <span class="text-[10.5px] text-charcoal/55">/ {{ $durasiAktifBulan }}
                                        bln</span>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Preview Popover 2 Mode (Pakai Foto / Tanpa Foto) + Pakai Tema Ini --}}
                        <div class="px-3.5 sm:px-4 pb-3.5 sm:pb-4 pt-1 space-y-2">
                            <div class="relative"
                                @click.away="if (previewTerbukaId === {{ $tema->id }}) previewTerbukaId = null"
                                @keydown.escape.window="if (previewTerbukaId === {{ $tema->id }}) previewTerbukaId = null">
                                <div x-show="previewTerbukaId === {{ $tema->id }}" x-cloak
                                    x-transition:enter="transition ease-out duration-150"
                                    x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                    x-transition:leave="transition ease-in duration-100"
                                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                    x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                                    class="absolute bottom-full inset-x-0 mb-2 z-30 rounded-2xl bg-white p-1.5 shadow-xl ring-1 ring-champagne/45 space-y-1.5">
                                    <a href="{{ route('tema.demo', ['slugTema' => $tema->slug, 'dari' => 'katalog']) }}"
                                        class="w-full flex items-center justify-between gap-2 rounded-xl bg-ivory/80 hover:bg-sage/10 px-3 py-2 text-xs font-semibold text-charcoal hover:text-sage transition">
                                        <span class="inline-flex items-center gap-2">
                                            <svg class="w-4 h-4 text-sage shrink-0" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" aria-hidden="true">
                                                <rect width="18" height="18" x="3" y="3" rx="2"
                                                    ry="2" />
                                                <circle cx="9" cy="9" r="2" />
                                                <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                                            </svg>
                                            <span>Pakai Foto</span>
                                        </span>
                                        <svg class="w-3.5 h-3.5 text-charcoal/45 shrink-0" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" aria-hidden="true">
                                            <path d="M5 12h14" />
                                            <path d="m12 5 7 7-7 7" />
                                        </svg>
                                    </a>

                                    <a href="{{ route('tema.demo', ['slugTema' => $tema->slug, 'tf' => 1, 'dari' => 'katalog']) }}"
                                        class="w-full flex items-center justify-between gap-2 rounded-xl bg-ivory/80 hover:bg-champagne/15 px-3 py-2 text-xs font-semibold text-charcoal hover:text-[#8A6D33] transition">
                                        <span class="inline-flex items-center gap-2">
                                            <svg class="w-4 h-4 text-[#8A6D33] shrink-0" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10" />
                                                <path d="m9 12 2 2 4-4" />
                                            </svg>
                                            <span>Tanpa Foto</span>
                                        </span>
                                        <svg class="w-3.5 h-3.5 text-charcoal/45 shrink-0" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" aria-hidden="true">
                                            <path d="M5 12h14" />
                                            <path d="m12 5 7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>

                                <button type="button"
                                    @click.stop="previewTerbukaId = (previewTerbukaId === {{ $tema->id }} ? null : {{ $tema->id }})"
                                    :aria-expanded="(previewTerbukaId === {{ $tema->id }}).toString()"
                                    :class="previewTerbukaId === {{ $tema->id }} ?
                                        'border-sage bg-sage/5 text-sage' :
                                        'border-champagne/55 bg-white text-charcoal hover:bg-champagne/10'"
                                    class="w-full inline-flex items-center justify-between gap-2 rounded-xl border px-3 py-2 text-xs font-semibold transition cursor-pointer">
                                    <span class="inline-flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-sage shrink-0" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" aria-hidden="true">
                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                        <span>Preview</span>
                                    </span>
                                    <span class="inline-flex items-center gap-1.5">
                                        <span
                                            class="inline-flex h-4 min-w-4 items-center justify-center rounded-full bg-sage text-[10px] font-bold text-white px-1">2</span>
                                        <svg class="w-3.5 h-3.5 transition-transform duration-200"
                                            :class="previewTerbukaId === {{ $tema->id }} ? 'rotate-180 text-sage' :
                                                'text-charcoal/55'"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                                            stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="m18 15-6-6-6 6" />
                                        </svg>
                                    </span>
                                </button>
                            </div>

                            <button type="button" @click="bukaModalDenganTema({{ $tema->id }})"
                                class="w-full rounded-xl bg-sage px-3.5 py-2 text-xs font-semibold text-white shadow-2xs hover:bg-[#3b5047] active:scale-95 transition cursor-pointer">
                                Pakai Tema Ini
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
    </main>

    @include('dashboard._bottom-nav', ['halamanAktif' => 'beranda', 'modalBuatOnPage' => true])

    @include('dashboard._modal-buat-draft')

    <x-modal-lightbox-sampul :daftar-tema="$daftarTema" :mode-katalog-client="true" />
    </div>
@endsection
