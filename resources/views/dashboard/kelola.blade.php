@extends('layouts.aplikasi')

@section('judul', 'Kelola Undangan — ' . $undangan->nama_panggilan_pria . ' & ' . $undangan->nama_panggilan_wanita)

@push('kepala')
    <style>
        @media (min-width: 1024px) {

            html,
            body {
                height: 100%;
                overflow: hidden;
            }
        }
    </style>
@endpush

@section('konten')
    @php
        $pengaturan = array_replace_recursive(\App\Models\Undangan::pengaturanBawaan(), $undangan->pengaturan ?? []);
        $ceritaAwal = collect($pengaturan['cerita_cinta'] ?? [])
            ->map(static function (array $item): array {
                $jalurFoto = is_string($item['foto'] ?? null) ? trim($item['foto']) : '';

                return [
                    'judul' => (string) ($item['judul'] ?? ''),
                    'tanggal' => (string) ($item['tanggal'] ?? ''),
                    'cerita' => (string) ($item['cerita'] ?? ''),
                    'foto' => $jalurFoto,
                    'foto_url' => $jalurFoto !== '' ? \App\Support\MediaPublik::url($jalurFoto) ?? '' : '',
                    'hapus_foto' => false,
                ];
            })
            ->values()
            ->all();
        if (empty($ceritaAwal)) {
            $ceritaAwal = [
                ['judul' => '', 'tanggal' => '', 'cerita' => '', 'foto' => '', 'foto_url' => '', 'hapus_foto' => false],
            ];
        }
        $urlPublik = Route::has('undangan.tampil')
            ? route('undangan.tampil', $undangan->slug)
            : url('/' . $undangan->slug);
        $urlPublikRelatif = Route::has('undangan.tampil')
            ? route('undangan.tampil', $undangan->slug, false)
            : '/' . $undangan->slug;
        $pesanWaAktivasi = "Halo Admin SesiTemu, saya ingin mengaktifkan undangan sesitemu.id/{$undangan->slug}.";

        $kelengkapanEditor = $undangan->ringkasanKelengkapan();
        $statusKodeEditor = $undangan->statusKode();
        $sedangVerifikasiEditor = $undangan->transaksi->contains('status', 'menunggu_verifikasi');
        $temaAktifEditor = $undangan->tema;
        $hargaTemaEditor = (int) ($temaAktifEditor?->hargaNominal() ?? 0);
        $hargaAsliEditor = (int) ($temaAktifEditor?->hargaAsliNominal() ?? 0);
        $persenDiskonEditor = $temaAktifEditor?->persenDiskon() ?? 0;
        $bolehGantiTema = $undangan->bolehGantiTemaOleh(auth()->user());
        $temaTerkunciClient = !$bolehGantiTema;
        $alasanTemaTerkunci = $undangan->alasanTemaTerkunci();
        $pesanWaGantiTema = "Halo Admin SesiTemu, saya ingin mengganti atau upgrade tema untuk undangan sesitemu.id/{$undangan->slug}.";
        $urlWaGantiTema = \App\Support\PengaturanSesiTemu::urlWaAdmin($pesanWaGantiTema);

        $temaAwalStudioPayload = $temaAktifEditor
            ? [
                'id' => $temaAktifEditor->id,
                'slug' => $temaAktifEditor->slug,
                'nama_tema' => $temaAktifEditor->nama_tema,
                'kategori' => $temaAktifEditor->kategoriLabel(),
                'kategori_kode' => $temaAktifEditor->kategoriKode(),
                'ringkasan_kategori' => $temaAktifEditor->infoKategori()['ringkasan'],
                'deskripsi' => $temaAktifEditor->infoDesain()['deskripsi'],
                'harga_nominal' => $temaAktifEditor->hargaNominal(),
                'harga' => $temaAktifEditor->hargaFormatted(),
                'harga_asli' => $temaAktifEditor->adaDiskon() ? $temaAktifEditor->hargaAsliFormatted() : null,
                'badge_diskon' => $temaAktifEditor->labelBadgeDiskon(),
                'url_pratinjau' => route('dashboard.undangan.pratinjau-tema', [
                    'undangan' => $undangan,
                    'tema' => $temaAktifEditor,
                    'embed' => 1,
                ]),
                'url_demo_embed' => route('tema.demo', ['slugTema' => $temaAktifEditor->slug, 'embed' => 1]),
                'url_demo' => route('tema.demo', ['slugTema' => $temaAktifEditor->slug]),
            ]
            : null;

        $tabSelesai = [
            'tema' => true,
            'mempelai' =>
                trim((string) $undangan->nama_lengkap_pria) !== '' &&
                trim((string) $undangan->nama_lengkap_wanita) !== '',
            'acara' => $undangan->daftarAcara->isNotEmpty(),
            'cerita' => !empty($pengaturan['cerita_cinta']),
            'galeri' => $undangan->modeTanpaFoto() || $undangan->daftarGaleri->isNotEmpty(),
            'amplop' =>
                $undangan->daftarAmplop->isNotEmpty() || trim((string) ($pengaturan['alamat_kado_fisik'] ?? '')) !== '',
            'penutup' =>
                trim((string) data_get($pengaturan, 'turut_mengundang.pihak_wanita', '')) !== '' ||
                trim((string) data_get($pengaturan, 'turut_mengundang.pihak_pria', '')) !== '',
            'aktivasi' => $undangan->sudahAktifPublik(),
        ];

        $daftarUrlMusik = collect($daftarMusik)
            ->mapWithKeys(fn(array $m): array => [$m['path'] => asset($m['path'])])
            ->all();

        $sakelarFiturAwal = [
            'hitung_mundur' => $undangan->fiturAktif('hitung_mundur'),
            'cerita_cinta' => $undangan->fiturAktif('cerita_cinta'),
            'galeri' => $undangan->fiturAktif('galeri'),
            'amplop_digital' => $undangan->fiturAktif('amplop_digital'),
            'buku_tamu' => $undangan->fiturAktif('buku_tamu'),
            'doa_pengantin' => $undangan->fiturAktif('doa_pengantin'),
        ];
        $teksKustom = (array) data_get($pengaturan, 'teks', []);
        $doaPengantinAwal = $undangan->doaPengantin();

        $configEditor = [
            'tab' => $tabAktif,
            'urlPublikPreview' => $urlPublikRelatif,
            'urlSimpanFitur' => route('dashboard.undangan.perbarui', $undangan, false),
            'urlPratinjauLangsung' => route('dashboard.undangan.pratinjau-langsung', $undangan, false),
            'csrfToken' => csrf_token(),
            'namaPriaLive' => old('nama_panggilan_pria', $undangan->nama_panggilan_pria),
            'namaWanitaLive' => old('nama_panggilan_wanita', $undangan->nama_panggilan_wanita),
            'tanpaFotoAktif' => $undangan->modeTanpaFoto(),
            'sakelarFitur' => $sakelarFiturAwal,
            'musikDipilih' => (string) ($undangan->musik_latar ?? ''),
            'daftarUrlMusik' => $daftarUrlMusik,
            'daftarCerita' => $ceritaAwal,
            'liveAktifLive' => (bool) ($pengaturan['live_streaming']['aktif'] ?? false),
            'katalogBank' => \App\Support\GayaKartuBank::katalogFrontend(),
            'temaAktifEditorId' => (int) $undangan->tema_id,
            'hargaTemaAktifEditor' => $hargaTemaEditor,
            'temaAwalStudio' => $temaAwalStudioPayload,
        ];
    @endphp

    <div x-data="editorKelolaUndangan(@js($configEditor))" class="relative min-h-screen lg:h-screen lg:overflow-hidden flex bg-[#F2F1EC]">
        {{-- 1. Sidebar Vertikal Ramping Desktop + Bottom Bar Mobile --}}
        @include('dashboard._workspace-sidebar', ['undangan' => $undangan, 'menuAktif' => 'undangan'])

        {{-- 2. Panel Kiri: Studio Editor Accordion --}}
        <div
            class="relative w-full lg:w-[44%] xl:w-[42%] lg:min-w-[440px] lg:max-w-[960px] shrink-0 bg-white lg:border-r lg:border-champagne/25 flex flex-col lg:h-screen min-h-0">
            {{-- Header Sticky Panel Kiri --}}
            <div
                class="px-4 sm:px-5 py-3.5 border-b border-champagne/20 bg-white flex items-center justify-between gap-3 shrink-0 sticky top-0 z-20 lg:static">
                <div class="min-w-0">
                    <h1 class="font-sans text-lg sm:text-xl font-bold text-charcoal tracking-tight leading-snug">
                        Edit Undangan
                    </h1>
                    <div class="mt-0.5 flex items-center gap-1.5 text-[11px] text-charcoal/55">
                        <a href="{{ auth()->user()->adalahAdmin() ? route('admin.undangan.index') : route('dashboard.index') }}"
                            class="hover:text-sage transition">Dashboard</a>
                        <span aria-hidden="true">&rsaquo;</span>
                        <span class="font-medium text-charcoal/80 truncate">{{ $undangan->nama_panggilan_pria }} &amp;
                            {{ $undangan->nama_panggilan_wanita }}</span>
                    </div>
                </div>

                <a href="{{ $urlPublik }}" target="_blank"
                    class="lg:hidden inline-flex items-center gap-1.5 rounded-xl bg-ivory px-3 py-2 text-xs font-semibold text-charcoal ring-1 ring-champagne/35 hover:bg-champagne/15 active:scale-95 transition shrink-0">
                    <svg class="h-3.5 w-3.5 text-sage shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    <span>Pratinjau</span>
                </a>
            </div>

            {{-- Body Scrollable Panel Kiri --}}
            <div x-ref="panelKiri" data-select2-parent x-on:input="saatInputLive($event)"
                x-on:change="saatInputLive($event)" x-on:foto-live-berubah="perbaruiFotoLive($event.detail)"
                class="relative flex-1 min-h-0 lg:overflow-y-auto px-4 sm:px-5 py-4 pb-28 lg:pb-8 space-y-3.5">
                {{-- Kartu Status / Aktivasi Ringkas --}}
                @if ($statusKodeEditor === 'aktif')
                    <div
                        class="rounded-2xl bg-emerald-50/80 px-4 py-3 ring-1 ring-emerald-200/80 flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <div class="flex items-center gap-1.5">
                                <span class="h-2 w-2 rounded-full bg-emerald-500 shrink-0"></span>
                                <p class="text-xs font-bold text-emerald-800">Undangan Aktif</p>
                            </div>
                            <p class="mt-0.5 text-[11px] text-emerald-800/75 truncate">
                                @if ($undangan->berlaku_sampai)
                                    Berlaku s.d. {{ $undangan->berlaku_sampai->locale('id')->translatedFormat('d M Y') }}
                                @else
                                    Siap disebar ke seluruh tamu
                                @endif
                            </p>
                        </div>
                        <a href="{{ route('dashboard.undangan.tamu', $undangan) }}"
                            class="inline-flex items-center gap-1 rounded-xl bg-sage px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#3b5047] transition shrink-0">
                            <span>Sebar Tamu</span>
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                @else
                    <div class="rounded-2xl bg-ivory/75 p-4 ring-1 ring-champagne/30 space-y-3">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <div class="flex flex-wrap items-center gap-1.5">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-charcoal/60">
                                        {{ $statusKodeEditor === 'kedaluwarsa' ? 'Masa Aktif Berakhir' : 'Aktifkan Undangan' }}
                                    </span>
                                    @if ($persenDiskonEditor > 0)
                                        <span class="rounded-full bg-rose-600 px-2 py-0.5 text-[10px] font-bold text-white">
                                            Diskon {{ $persenDiskonEditor }}%
                                        </span>
                                    @endif
                                </div>
                                <div class="mt-1 flex items-baseline gap-2">
                                    <span class="font-sans tabular-nums text-lg font-bold text-charcoal">
                                        {{ \App\Models\Tema::formatRupiah($hargaTemaEditor) }}
                                    </span>
                                    @if ($hargaAsliEditor > $hargaTemaEditor)
                                        <span class="font-sans tabular-nums text-xs text-charcoal/45 line-through">
                                            {{ \App\Models\Tema::formatRupiah($hargaAsliEditor) }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <span
                                class="rounded-full px-2.5 py-0.5 text-[10px] font-bold shrink-0 {{ $sedangVerifikasiEditor ? 'bg-sky-100 text-sky-800' : ($statusKodeEditor === 'kedaluwarsa' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-800') }}">
                                {{ $sedangVerifikasiEditor ? 'Verifikasi' : ($statusKodeEditor === 'kedaluwarsa' ? 'Kedaluwarsa' : 'Draft Gratis') }}
                            </span>
                        </div>

                        @if ($sedangVerifikasiEditor)
                            <button type="button" @click="bukaBagian('aktivasi')"
                                class="w-full inline-flex items-center justify-center gap-1.5 rounded-xl bg-sky-600 px-4 py-2.5 text-xs font-semibold text-white hover:bg-sky-700 active:scale-[0.98] transition cursor-pointer">
                                <span>Bukti Terkirim &bull; Lihat Status Verifikasi</span>
                            </button>
                        @else
                            <div class="grid grid-cols-2 gap-2">
                                <button type="button" @click="bukaBagian('aktivasi')"
                                    class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-sage px-3.5 py-2.5 text-xs font-semibold text-white shadow-xs hover:bg-[#3b5047] active:scale-[0.98] transition cursor-pointer">
                                    <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2.1" stroke-linecap="round"
                                        stroke-linejoin="round" aria-hidden="true">
                                        <rect width="20" height="14" x="2" y="5" rx="2" />
                                        <line x1="2" x2="22" y1="10" y2="10" />
                                    </svg>
                                    <span>{{ $statusKodeEditor === 'kedaluwarsa' ? 'Perpanjang' : 'Bayar & Aktifkan' }}</span>
                                </button>
                                <button type="button" @click="bukaDrawerTema()" data-buka-drawer-tema
                                    class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-white px-3.5 py-2.5 text-xs font-semibold text-charcoal ring-1 ring-champagne/45 hover:bg-champagne/10 active:scale-[0.98] transition cursor-pointer">
                                    <span>Ganti Tema</span>
                                </button>
                            </div>
                        @endif

                        <p class="text-[11px] text-charcoal/55 leading-relaxed">
                            @if ($sedangVerifikasiEditor)
                                Bukti pembayaran sedang diverifikasi Admin. Tema dikunci sementara hingga verifikasi
                                selesai.
                            @else
                                Draft tersimpan aman. Bebas lengkapi data &amp; ganti tema kapan saja sebelum aktivasi.
                            @endif
                        </p>
                    </div>
                @endif

                {{-- Baris Link Undangan Cepat --}}
                <div class="px-1 py-1.5 border-b border-champagne/20 space-y-1">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-1.5 min-w-0">
                            <span
                                class="font-mono text-xs sm:text-[13px] font-bold text-charcoal truncate">sesitemu.id/{{ $undangan->slug }}</span>
                            @if (!$undangan->status_publikasi)
                                <button type="button" x-on:click="bukaBagian('tema')" title="Ubah link undangan"
                                    class="inline-flex h-6 w-6 items-center justify-center rounded-lg text-charcoal/50 hover:bg-ivory hover:text-sage transition cursor-pointer shrink-0">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        aria-hidden="true">
                                        <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.375 2.625a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4Z" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                        <button type="button"
                            x-on:click="navigator.clipboard?.writeText(@js($urlPublik)); slugTersalin = true; setTimeout(() => slugTersalin = false, 1800)"
                            class="rounded-lg bg-ivory px-2.5 py-1 text-[11px] font-semibold text-sage ring-1 ring-champagne/30 hover:bg-sage hover:text-white transition cursor-pointer shrink-0"
                            x-text="slugTersalin ? 'Tersalin!' : 'Salin Link'"></button>
                    </div>
                    <p class="text-[11px] text-charcoal/50">
                        {{ $undangan->status_publikasi ? 'Link undangan dikunci otomatis saat aktif.' : 'Link undangan bebas diubah sebelum undangan diaktifkan.' }}
                    </p>
                </div>

                {{-- Daftar Bagian Editor Accordion (Urutan Mengikuti Alur Undangan dari Atas ke Bawah) --}}
                <div class="space-y-2.5">
                    <p class="px-1 pt-0.5 text-[10px] font-bold uppercase tracking-[0.18em] text-charcoal/45">
                        Urutan Isi Undangan (Atas &rarr; Bawah)
                    </p>

                    @include('dashboard._kelola-tema-mempelai')
                    @include('dashboard._kelola-acara-cerita-galeri')
                    @include('dashboard._kelola-amplop-penutup')

                    <p class="px-1 pt-2 text-[10px] font-bold uppercase tracking-[0.18em] text-charcoal/45">
                        Langkah Akhir
                    </p>

                    @include('dashboard._kelola-aktivasi')

                    {{-- Aksi Hapus Draft (Khusus Undangan Belum Aktif / Belum Diverifikasi) --}}
                    @if ($undangan->bolehDihapusClient())
                        <form action="{{ route('dashboard.undangan.hapus', $undangan) }}" method="POST"
                            data-swal-confirm="Yakin ingin menghapus draft undangan sesitemu.id/{{ $undangan->slug }}? Seluruh data, acara, dan foto draft ini akan dihapus permanen."
                            data-swal-title="Hapus Draft Undangan?" data-swal-icon="warning"
                            data-swal-confirm-button="Ya, Hapus Draft" data-swal-confirm-color="#DC2626"
                            data-swal-loading-title="Menghapus Draft..."
                            data-swal-loading-text="Sedang menghapus draft undangan dan berkas terkait...">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full rounded-2xl border border-red-200/90 bg-red-50/40 px-4 py-3.5 flex items-center justify-between gap-3 text-left text-red-600 hover:bg-red-50 hover:border-red-300 active:scale-[0.99] transition cursor-pointer">
                                <span class="flex items-center gap-3">
                                    <svg class="h-4 w-4 shrink-0 opacity-70" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                        stroke-linejoin="round" aria-hidden="true">
                                        <path d="m9 18 6-6-6-6" />
                                    </svg>
                                    <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" aria-hidden="true">
                                        <path d="M3 6h18" />
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                        <line x1="10" x2="10" y1="11" y2="17" />
                                        <line x1="14" x2="14" y1="11" y2="17" />
                                    </svg>
                                    <span class="font-sans text-sm font-semibold">Hapus Draft</span>
                                </span>
                                <span class="text-[11px] font-medium text-red-500/80">Permanen</span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- 3. Panel Kanan: Kanvas Live Preview Interaktif + Drawer Tema + Lightbox --}}
        @include('dashboard._kelola-panel-kanan')
    </div>
@endsection
