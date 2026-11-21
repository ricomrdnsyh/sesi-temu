@extends('layouts.aplikasi')

@section('judul', 'Kelola Undangan — '.$undangan->nama_panggilan_pria.' & '.$undangan->nama_panggilan_wanita)

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
    $ceritaAwal = $pengaturan['cerita_cinta'] ?? [];
    if (empty($ceritaAwal)) {
        $ceritaAwal = [['judul' => '', 'tanggal' => '', 'cerita' => '']];
    }
    $urlPublik = Route::has('undangan.tampil') ? route('undangan.tampil', $undangan->slug) : url('/'.$undangan->slug);
    $pesanWaAktivasi = "Halo Admin SesiTemu, saya ingin mengaktifkan undangan sesitemu.id/{$undangan->slug}.";

    $kelengkapanEditor = $undangan->ringkasanKelengkapan();
    $statusKodeEditor = $undangan->statusKode();
    $sedangVerifikasiEditor = $undangan->transaksi->contains('status', 'menunggu_verifikasi');
    $temaAktifEditor = $undangan->tema;
    $hargaTemaEditor = (int) ($temaAktifEditor?->hargaNominal() ?? 0);
    $hargaAsliEditor = (int) ($temaAktifEditor?->hargaAsliNominal() ?? 0);
    $persenDiskonEditor = $temaAktifEditor?->persenDiskon() ?? 0;
    $bolehGantiTema = $undangan->bolehGantiTemaOleh(auth()->user());
    $temaTerkunciClient = ! $bolehGantiTema;
    $alasanTemaTerkunci = $undangan->alasanTemaTerkunci();
    $pesanWaGantiTema = "Halo Admin SesiTemu, saya ingin mengganti atau upgrade tema untuk undangan sesitemu.id/{$undangan->slug}.";
    $urlWaGantiTema = \App\Support\PengaturanSesiTemu::urlWaAdmin($pesanWaGantiTema);

    $temaAwalStudioPayload = $temaAktifEditor
        ? [
            'id' => $temaAktifEditor->id,
            'slug' => $temaAktifEditor->slug,
            'nama_tema' => $temaAktifEditor->nama_tema,
            'tier' => $temaAktifEditor->tierLabel(),
            'tier_kode' => $temaAktifEditor->tierKode(),
            'ringkasan_tier' => $temaAktifEditor->infoTier()['ringkasan'],
            'deskripsi' => $temaAktifEditor->infoDesain()['deskripsi'],
            'harga_nominal' => $temaAktifEditor->hargaNominal(),
            'harga' => $temaAktifEditor->hargaFormatted(),
            'harga_asli' => $temaAktifEditor->adaDiskon() ? $temaAktifEditor->hargaAsliFormatted() : null,
            'badge_diskon' => $temaAktifEditor->labelBadgeDiskon(),
            'url_pratinjau' => route('dashboard.undangan.pratinjau-tema', ['undangan' => $undangan, 'tema' => $temaAktifEditor, 'embed' => 1]),
            'url_demo_embed' => route('tema.demo', ['slugTema' => $temaAktifEditor->slug, 'embed' => 1]),
            'url_demo' => route('tema.demo', ['slugTema' => $temaAktifEditor->slug]),
        ]
        : null;

    $tabSelesai = [
        'tema' => true,
        'mempelai' => trim((string) $undangan->nama_lengkap_pria) !== '' && trim((string) $undangan->nama_lengkap_wanita) !== '',
        'acara' => $undangan->daftarAcara->isNotEmpty(),
        'galeri' => $undangan->modeTanpaFoto() || $undangan->daftarGaleri->isNotEmpty(),
        'amplop' => $undangan->daftarAmplop->isNotEmpty() || trim((string) ($pengaturan['alamat_kado_fisik'] ?? '')) !== '',
        'aktivasi' => $undangan->sudahAktifPublik(),
    ];

    $daftarUrlMusik = collect($daftarMusik)
        ->mapWithKeys(fn (array $m): array => [$m['path'] => asset($m['path'])])
        ->all();

    $sakelarFiturAwal = [
        'hitung_mundur' => $undangan->fiturAktif('hitung_mundur'),
        'cerita_cinta' => $undangan->fiturAktif('cerita_cinta'),
        'galeri' => $undangan->fiturAktif('galeri'),
        'amplop_digital' => $undangan->fiturAktif('amplop_digital'),
        'buku_tamu' => $undangan->fiturAktif('buku_tamu'),
    ];
@endphp

<div
    x-data="{
        tab: @js($tabAktif),
        urutanTab: ['tema', 'mempelai', 'acara', 'galeri', 'amplop', 'aktivasi'],
        urlPublikPreview: @js($urlPublik),
        modePreview: 'mobile',
        previewKey: 1,
        previewMemuat: true,
        previewScale: 0.9,
        previewStudioScale: 0.56,
        previewObserver: null,
        previewStudioObserver: null,
        namaPriaLive: @js(old('nama_panggilan_pria', $undangan->nama_panggilan_pria)),
        namaWanitaLive: @js(old('nama_panggilan_wanita', $undangan->nama_panggilan_wanita)),
        tanpaFotoAktif: @js($undangan->modeTanpaFoto()),
        sakelarFitur: @js($sakelarFiturAwal),
        musikDipilih: @js((string) ($undangan->musik_latar ?? '')),
        daftarUrlMusik: @js($daftarUrlMusik),
        audioSedangPutar: false,
        slugTersalin: false,
        daftarCerita: @js($ceritaAwal),
        liveAktifLive: @js((bool) ($pengaturan['live_streaming']['aktif'] ?? false)),
        katalogBank: @js(\App\Support\GayaKartuBank::katalogFrontend()),
        bankBaru: '',
        nomorBaru: '',
        atasNamaBaru: '',
        acaraEdit: null,
        galeriLightbox: null,
        drawerTemaTerbuka: false,
        tierDrawerTema: 'semua',
        cariDrawerTema: '',
        tabMobileStudio: 'daftar',
        sumberPreviewStudio: 'undangan',
        previewStudioMemuat: false,
        temaAktifEditorId: @js((int) $undangan->tema_id),
        hargaTemaAktifEditor: @js($hargaTemaEditor),
        temaAwalStudio: @js($temaAwalStudioPayload),
        temaPreviewStudio: @js($temaAwalStudioPayload),
        temaKonfirmasi: null,
        init() {
            if (this.tab) {
                this.$nextTick(() => {
                    const el = this.$el.querySelector(`[data-mobile-tab='${this.tab}']`);
                    el?.scrollIntoView({ behavior: 'auto', block: 'nearest' });
                });
            }
            this.$nextTick(() => {
                this.hitungSkalaPreview();
                this.hitungSkalaPreviewStudio();
                if (typeof ResizeObserver !== 'undefined') {
                    if (this.$refs.stagePreview) {
                        this.previewObserver = new ResizeObserver(() => this.hitungSkalaPreview());
                        this.previewObserver.observe(this.$refs.stagePreview);
                    }
                    const stageStudio = this.$el.querySelector('[data-stage-preview-studio]');
                    if (stageStudio) {
                        this.previewStudioObserver = new ResizeObserver(() => this.hitungSkalaPreviewStudio());
                        this.previewStudioObserver.observe(stageStudio);
                    }
                }
            });
            window.addEventListener('resize', () => {
                this.hitungSkalaPreview();
                this.hitungSkalaPreviewStudio();
            });
            setTimeout(() => { this.previewMemuat = false; }, 2500);
        },
        previewVirtualW() {
            return this.modePreview === 'mobile' ? 390 : 1280;
        },
        previewVirtualH() {
            return this.modePreview === 'mobile' ? 780 : 800;
        },
        hitungSkalaPreview() {
            const stage = this.$refs.stagePreview;
            if (!stage || stage.clientWidth === 0 || stage.clientHeight === 0) return;
            const padX = this.modePreview === 'mobile' ? 40 : 32;
            const padY = this.modePreview === 'mobile' ? 44 : 32;
            const tersediaW = Math.max(180, stage.clientWidth - padX);
            const tersediaH = Math.max(240, stage.clientHeight - padY);
            const batasMaks = this.modePreview === 'mobile' ? 1.55 : 1.25;
            const skala = Math.min(tersediaW / this.previewVirtualW(), tersediaH / this.previewVirtualH(), batasMaks);
            this.previewScale = Math.max(0.28, Number(skala.toFixed(4)));
        },
        hitungSkalaPreviewStudio() {
            const stage = this.$el.querySelector('[data-stage-preview-studio]');
            if (!stage || stage.clientWidth === 0 || stage.clientHeight === 0) return;
            const tersediaW = Math.max(160, stage.clientWidth - 28);
            const tersediaH = Math.max(220, stage.clientHeight - 24);
            const skala = Math.min(tersediaW / 390, tersediaH / 780, 1.0);
            this.previewStudioScale = Math.max(0.28, Number(skala.toFixed(4)));
        },
        ubahModePreview(mode) {
            this.modePreview = mode;
            this.$nextTick(() => this.hitungSkalaPreview());
        },
        urlPreviewAktif() {
            const pemisah = this.urlPublikPreview.includes('?') ? '&' : '?';
            return `${this.urlPublikPreview}${pemisah}_preview=${this.previewKey}`;
        },
        muatUlangPreview() {
            this.previewMemuat = true;
            this.previewKey++;
            setTimeout(() => { this.previewMemuat = false; }, 2500);
        },
        toggleBagian(kodeTab) {
            this.hentikanAudioPreview();
            if (this.tab === kodeTab) {
                this.tab = '';
                return;
            }
            this.tab = kodeTab;
            this.$nextTick(() => {
                const el = this.$el.querySelector(`[data-mobile-tab='${kodeTab}']`);
                el?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            });
        },
        bukaBagian(kodeTab) {
            this.hentikanAudioPreview();
            this.tab = kodeTab;
            this.$nextTick(() => {
                const el = this.$el.querySelector(`[data-mobile-tab='${kodeTab}']`);
                el?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        },
        pilihTab(kodeTab) {
            this.bukaBagian(kodeTab);
        },
        bukaDrawerTema() {
            this.temaPreviewStudio = this.temaAwalStudio;
            this.sumberPreviewStudio = 'undangan';
            this.tabMobileStudio = 'daftar';
            this.previewStudioMemuat = true;
            this.drawerTemaTerbuka = true;
            this.temaKonfirmasi = null;
            this.$nextTick(() => this.hitungSkalaPreviewStudio());
            setTimeout(() => { this.previewStudioMemuat = false; }, 2500);
        },
        tutupDrawerTema() {
            this.drawerTemaTerbuka = false;
            this.temaKonfirmasi = null;
        },
        pilihTemaStudio(payload) {
            if (!payload) return;
            if (this.temaPreviewStudio?.id !== payload.id) {
                this.previewStudioMemuat = true;
                setTimeout(() => { this.previewStudioMemuat = false; }, 2500);
            }
            this.temaPreviewStudio = payload;
        },
        ubahSumberPreviewStudio(sumber) {
            if (this.sumberPreviewStudio === sumber) return;
            this.sumberPreviewStudio = sumber;
            this.previewStudioMemuat = true;
            setTimeout(() => { this.previewStudioMemuat = false; }, 2500);
        },
        urlPreviewStudio() {
            if (!this.drawerTemaTerbuka || !this.temaPreviewStudio) {
                return 'about:blank';
            }
            return this.sumberPreviewStudio === 'demo'
                ? this.temaPreviewStudio.url_demo_embed
                : this.temaPreviewStudio.url_pratinjau;
        },
        selisihHargaStudio() {
            if (!this.temaPreviewStudio) {
                return { teks: '', kelas: '' };
            }
            const selisih = Number(this.temaPreviewStudio.harga_nominal || 0) - Number(this.hargaTemaAktifEditor || 0);
            if (selisih === 0) {
                return { teks: 'Harga Sama', kelas: 'bg-ivory text-charcoal/70 ring-1 ring-champagne/30' };
            }
            const nominal = 'Rp ' + Math.abs(selisih).toLocaleString('id-ID');
            if (selisih > 0) {
                return { teks: '+' + nominal, kelas: 'bg-amber-50 text-amber-800 ring-1 ring-amber-200' };
            }
            return { teks: 'Hemat ' + nominal, kelas: 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' };
        },
        pilihTemaKonfirmasi(payload) {
            this.temaKonfirmasi = payload;
        },
        temaCocokDrawer(tier, teks) {
            const cocokTier = this.tierDrawerTema === 'semua' || this.tierDrawerTema === tier;
            const q = this.cariDrawerTema.trim().toLowerCase();
            const cocokCari = !q || teks.toLowerCase().includes(q);
            return cocokTier && cocokCari;
        },
        urlMusikAktif() {
            return this.musikDipilih ? (this.daftarUrlMusik[this.musikDipilih] || '') : '';
        },
        hentikanAudioPreview() {
            const audio = this.$refs.audioPreview;
            if (audio) {
                audio.pause();
                audio.currentTime = 0;
            }
            this.audioSedangPutar = false;
        },
        toggleAudioPreview() {
            const url = this.urlMusikAktif();
            const audio = this.$refs.audioPreview;
            if (!url || !audio) return;

            if (this.audioSedangPutar) {
                audio.pause();
                this.audioSedangPutar = false;
                return;
            }

            if (audio.src !== url) {
                audio.src = url;
            }
            audio.play().then(() => {
                this.audioSedangPutar = true;
            }).catch(() => {
                this.audioSedangPutar = false;
            });
        },
        tambahCerita() {
            this.daftarCerita.push({ judul: '', tanggal: '', cerita: '' });
        },
        tambahCeritaPreset(judul, tanggal, cerita) {
            const barisKosong = this.daftarCerita.length === 1
                && !this.daftarCerita[0].judul?.trim()
                && !this.daftarCerita[0].cerita?.trim();

            if (barisKosong) {
                this.daftarCerita[0] = { judul, tanggal, cerita };
                return;
            }

            this.daftarCerita.push({ judul, tanggal, cerita });
        },
        pindahCerita(index, arah) {
            const target = index + arah;
            if (target < 0 || target >= this.daftarCerita.length) {
                return;
            }
            const salinan = [...this.daftarCerita];
            [salinan[index], salinan[target]] = [salinan[target], salinan[index]];
            this.daftarCerita = salinan;
        },
        hapusCerita(index) {
            if (this.daftarCerita.length > 1) {
                this.daftarCerita.splice(index, 1);
            }
        },
        gayaKartuLive() {
            const teks = (this.bankBaru || '').trim().toLowerCase();
            if (teks) {
                for (const item of this.katalogBank.items) {
                    if (item.kata_kunci.some((kata) => teks.includes(kata))) {
                        return item;
                    }
                }
            }
            const namaBersih = (this.bankBaru || '').trim();
            return {
                ...this.katalogBank.fallback,
                singkatan: namaBersih ? namaBersih.slice(0, 14).toUpperCase() : this.katalogBank.fallback.singkatan,
                subjudul: namaBersih || this.katalogBank.fallback.subjudul,
            };
        },
        formatNomorLive(nomor) {
            const bersih = (nomor || '').trim();
            if (!bersih) return '1234 5678 90';
            if (/^\d{6,}$/.test(bersih)) {
                return bersih.replace(/(\d{4})(?=\d)/g, '$1 ');
            }
            return bersih;
        }
    }"
    class="relative min-h-screen lg:h-screen lg:overflow-hidden flex bg-[#F2F1EC]"
>
    {{-- 1. Sidebar Vertikal Ramping Desktop + Bottom Bar Mobile --}}
    @include('dashboard._workspace-sidebar', ['undangan' => $undangan, 'menuAktif' => 'undangan'])

    {{-- 2. Panel Kiri: Studio Editor Accordion --}}
    <div class="relative w-full lg:w-[44%] xl:w-[42%] lg:min-w-[440px] lg:max-w-[960px] shrink-0 bg-white lg:border-r lg:border-champagne/25 flex flex-col lg:h-screen min-h-0">
        {{-- Header Sticky Panel Kiri --}}
        <div class="px-4 sm:px-5 py-3.5 border-b border-champagne/20 bg-white flex items-center justify-between gap-3 shrink-0 sticky top-0 z-20 lg:static">
            <div class="min-w-0">
                <h1 class="font-sans text-lg sm:text-xl font-bold text-charcoal tracking-tight leading-snug">Edit Undangan</h1>
                <div class="mt-0.5 flex items-center gap-1.5 text-[11px] text-charcoal/55">
                    <a href="{{ auth()->user()->adalahAdmin() ? route('admin.undangan.index') : route('dashboard.index') }}" class="hover:text-sage transition">Dashboard</a>
                    <span aria-hidden="true">&rsaquo;</span>
                    <span class="font-medium text-charcoal/80 truncate">{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</span>
                </div>
            </div>

            <a
                href="{{ $urlPublik }}"
                target="_blank"
                class="lg:hidden inline-flex items-center gap-1.5 rounded-xl bg-ivory px-3 py-2 text-xs font-semibold text-charcoal ring-1 ring-champagne/35 hover:bg-champagne/15 active:scale-95 transition shrink-0"
            >
                <svg class="h-3.5 w-3.5 text-sage shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
                <span>Pratinjau</span>
            </a>
        </div>

        {{-- Body Scrollable Panel Kiri --}}
        <div x-ref="panelKiri" data-select2-parent class="relative flex-1 min-h-0 lg:overflow-y-auto px-4 sm:px-5 py-4 pb-28 lg:pb-8 space-y-3.5">
            {{-- Kartu Status / Aktivasi Ringkas --}}
            @if ($statusKodeEditor === 'aktif')
                <div class="rounded-2xl bg-emerald-50/80 px-4 py-3 ring-1 ring-emerald-200/80 flex items-center justify-between gap-3">
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
                    <a
                        href="{{ route('dashboard.undangan.tamu', $undangan) }}"
                        class="inline-flex items-center gap-1 rounded-xl bg-sage px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#3b5047] transition shrink-0"
                    >
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

                        <span class="rounded-full px-2.5 py-0.5 text-[10px] font-bold shrink-0 {{ $sedangVerifikasiEditor ? 'bg-sky-100 text-sky-800' : ($statusKodeEditor === 'kedaluwarsa' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-800') }}">
                            {{ $sedangVerifikasiEditor ? 'Verifikasi' : ($statusKodeEditor === 'kedaluwarsa' ? 'Kedaluwarsa' : 'Draft Gratis') }}
                        </span>
                    </div>

                    @if ($sedangVerifikasiEditor)
                        <button
                            type="button"
                            @click="bukaBagian('aktivasi')"
                            class="w-full inline-flex items-center justify-center gap-1.5 rounded-xl bg-sky-600 px-4 py-2.5 text-xs font-semibold text-white hover:bg-sky-700 active:scale-[0.98] transition cursor-pointer"
                        >
                            <span>Bukti Terkirim &bull; Lihat Status Verifikasi</span>
                        </button>
                    @else
                        <div class="grid grid-cols-2 gap-2">
                            <button
                                type="button"
                                @click="bukaBagian('aktivasi')"
                                class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-sage px-3.5 py-2.5 text-xs font-semibold text-white shadow-xs hover:bg-[#3b5047] active:scale-[0.98] transition cursor-pointer"
                            >
                                <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <rect width="20" height="14" x="2" y="5" rx="2"/>
                                    <line x1="2" x2="22" y1="10" y2="10"/>
                                </svg>
                                <span>{{ $statusKodeEditor === 'kedaluwarsa' ? 'Perpanjang' : 'Bayar & Aktifkan' }}</span>
                            </button>
                            <button
                                type="button"
                                @click="bukaDrawerTema()"
                                data-buka-drawer-tema
                                class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-white px-3.5 py-2.5 text-xs font-semibold text-charcoal ring-1 ring-champagne/45 hover:bg-champagne/10 active:scale-[0.98] transition cursor-pointer"
                            >
                                <span>Ganti Tema</span>
                            </button>
                        </div>
                    @endif

                    <p class="text-[11px] text-charcoal/55 leading-relaxed">
                        @if ($sedangVerifikasiEditor)
                            Bukti pembayaran sedang diverifikasi Admin. Tema dikunci sementara hingga verifikasi selesai.
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
                        <span class="font-mono text-xs sm:text-[13px] font-bold text-charcoal truncate">sesitemu.id/{{ $undangan->slug }}</span>
                        @if (! $undangan->status_publikasi)
                            <button
                                type="button"
                                @click="bukaBagian('tema')"
                                title="Ubah link undangan"
                                class="inline-flex h-6 w-6 items-center justify-center rounded-lg text-charcoal/50 hover:bg-ivory hover:text-sage transition cursor-pointer shrink-0"
                            >
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.375 2.625a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4Z"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                    <button
                        type="button"
                        @click="navigator.clipboard?.writeText(@js($urlPublik)); slugTersalin = true; setTimeout(() => slugTersalin = false, 1800)"
                        class="rounded-lg bg-ivory px-2.5 py-1 text-[11px] font-semibold text-sage ring-1 ring-champagne/30 hover:bg-sage hover:text-white transition cursor-pointer shrink-0"
                        x-text="slugTersalin ? 'Tersalin!' : 'Salin Link'"
                    ></button>
                </div>
                <p class="text-[11px] text-charcoal/50">
                    {{ $undangan->status_publikasi ? 'Link undangan dikunci otomatis saat aktif.' : 'Link undangan bebas diubah sebelum undangan diaktifkan.' }}
                </p>
            </div>

            {{-- Daftar 6 Bagian Editor Accordion --}}
            <div class="space-y-2.5">
                {{-- ACCORDION 1: Tema & Tampilan --}}
                <div
                    :class="tab === 'tema' ? 'border-sage/45 ring-1 ring-sage/15 shadow-xs' : 'border-champagne/30 hover:border-champagne/60'"
                    class="rounded-2xl border bg-white overflow-hidden transition"
                >
                    <button
                        type="button"
                        data-mobile-tab="tema"
                        @click="toggleBagian('tema')"
                        class="w-full px-4 py-3.5 flex items-center justify-between gap-3 text-left cursor-pointer hover:bg-ivory/50 transition"
                    >
                        <div class="flex items-center gap-3 min-w-0">
                            <svg
                                :class="tab === 'tema' ? 'rotate-90 text-sage' : 'text-charcoal/45'"
                                class="h-4 w-4 shrink-0 transition-transform duration-200"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                            >
                                <path d="m9 18 6-6-6-6"/>
                            </svg>
                            <svg class="h-4 w-4 text-sage shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/>
                                <circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/>
                                <circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/>
                                <circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/>
                                <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/>
                            </svg>
                            <span class="font-sans text-sm font-semibold text-charcoal truncate">Tema &amp; Tampilan</span>
                        </div>
                        <span class="text-[11px] font-medium text-charcoal/50 truncate max-w-[130px]">{{ $temaAktifEditor?->nama_tema }}</span>
                    </button>

                    <section x-show="tab === 'tema'" x-cloak class="px-4 pb-5 pt-2 border-t border-champagne/20">
                        <div class="flex items-start justify-between gap-2 pb-3 mb-1 border-b border-champagne/15">
                            <div>
                                <h2 class="font-sans text-lg sm:text-2xl font-bold text-charcoal tracking-tight">Tema, Musik &amp; Pengaturan Link</h2>
                                <p class="mt-0.5 text-xs text-charcoal/60">Atur tema, link, font, musik latar, dan fitur aktif.</p>
                            </div>
                            @if ($bolehGantiTema)
                                <button
                                    type="button"
                                    @click="bukaDrawerTema()"
                                    data-buka-drawer-tema
                                    class="inline-flex items-center gap-1 rounded-xl bg-ivory px-2.5 py-1.5 text-[11px] font-semibold text-sage ring-1 ring-champagne/35 hover:bg-sage hover:text-white transition shrink-0 cursor-pointer"
                                >
                                    <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <rect width="7" height="7" x="3" y="3" rx="1.5"/>
                                        <rect width="7" height="7" x="14" y="3" rx="1.5"/>
                                        <rect width="7" height="7" x="14" y="14" rx="1.5"/>
                                        <rect width="7" height="7" x="3" y="14" rx="1.5"/>
                                    </svg>
                                    <span>Ganti Tema</span>
                                </button>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-xl bg-amber-50 px-2.5 py-1.5 text-[11px] font-semibold text-amber-700 ring-1 ring-amber-200 shrink-0">
                                    <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                    </svg>
                                    <span>Tema Terkunci</span>
                                </span>
                            @endif
                        </div>

            <form
                action="{{ route('dashboard.undangan.perbarui', $undangan) }}"
                method="POST"
                class="mt-5 sm:mt-6 space-y-5 sm:space-y-6"
                data-swal-loading
                data-swal-loading-title="Menyimpan Pengaturan Tema..."
                data-swal-loading-text="Memperbarui tema, tipografi, musik latar, dan link undangan..."
            >
                @csrf
                @method('PUT')
                <input type="hidden" name="bagian" value="tema">

                <audio x-ref="audioPreview" @ended="audioSedangPutar = false" class="hidden" preload="none"></audio>

                {{-- Grup 1: Desain & Alamat Link --}}
                <div class="rounded-2xl bg-ivory/65 p-4 sm:p-5 ring-1 ring-champagne/20 space-y-4">
                    <div class="flex items-center gap-2.5">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-sage/12 text-sage shrink-0">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/>
                                <circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/>
                                <circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/>
                                <circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/>
                                <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/>
                            </svg>
                        </span>
                        <div>
                            <h3 class="font-sans text-sm font-bold text-charcoal leading-tight">Tema &amp; Alamat Link</h3>
                            <p class="text-[11px] text-charcoal/55">Pilih desain favorit dan tautan unik pasangan Anda.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-3.5">
                        <div>
                            <input type="hidden" name="tema_id" value="{{ $undangan->tema_id }}">
                            <div class="flex items-center justify-between gap-2 mb-1.5">
                                <span class="block text-xs font-semibold text-charcoal/80">Tema Undangan</span>
                                @if ($temaTerkunciClient)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2 py-0.5 text-[10px] font-semibold text-amber-700 ring-1 ring-amber-200">
                                        {{ $sedangVerifikasiEditor ? 'Terkunci (Verifikasi)' : 'Terkunci (Aktif)' }}
                                    </span>
                                @elseif (auth()->user()->adalahAdmin() && $undangan->temaTerkunciUntukClient())
                                    <span class="inline-flex items-center gap-1 rounded-full bg-sage/10 px-2 py-0.5 text-[10px] font-semibold text-sage ring-1 ring-sage/25">
                                        Mode Admin
                                    </span>
                                @endif
                            </div>

                            <div class="rounded-2xl bg-white p-3 ring-1 {{ $temaTerkunciClient ? 'ring-amber-200/80' : 'ring-champagne/30' }} flex items-center gap-3">
                                @if ($temaAktifEditor)
                                    <div class="h-16 w-16 rounded-xl overflow-hidden shrink-0 ring-1 ring-champagne/25 bg-ivory">
                                        <x-poster-sampul-tema :tema="$temaAktifEditor" />
                                    </div>
                                @endif

                                <div class="min-w-0 flex-1">
                                    <span class="inline-flex items-center rounded-full bg-ivory px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-[#8A6D33] ring-1 ring-champagne/35">
                                        Tier {{ $temaAktifEditor?->tierLabel() }}
                                    </span>
                                    <p class="mt-1 font-sans text-sm font-bold text-charcoal truncate">
                                        {{ $temaAktifEditor?->nama_tema ?? 'Rustic Floral' }}
                                    </p>
                                    <div class="mt-0.5 flex flex-wrap items-center gap-x-1.5 gap-y-0.5 font-sans tabular-nums text-xs">
                                        @if ($temaAktifEditor?->adaDiskon())
                                            <span class="text-charcoal/45 line-through text-[11px]">{{ $temaAktifEditor->hargaAsliFormatted() }}</span>
                                        @endif
                                        <span class="font-bold text-sage">{{ $temaAktifEditor?->hargaFormatted() }}</span>
                                    </div>
                                </div>

                                <div class="shrink-0">
                                    @if ($bolehGantiTema)
                                        <button
                                            type="button"
                                            @click="bukaDrawerTema()"
                                            data-buka-drawer-tema
                                            class="inline-flex items-center gap-1.5 rounded-xl bg-[#3B4F45] px-3 py-2 text-xs font-semibold text-white hover:bg-sage active:scale-95 transition cursor-pointer"
                                        >
                                            <span>Ganti</span>
                                        </button>
                                    @else
                                        <a
                                            href="{{ $urlWaGantiTema }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="inline-flex items-center gap-1 rounded-xl bg-amber-50 px-2.5 py-2 text-[11px] font-semibold text-amber-800 ring-1 ring-amber-200 hover:bg-amber-100 transition"
                                        >
                                            <span>Hubungi Admin</span>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            @if ($temaTerkunciClient)
                                <p class="mt-1.5 text-[11px] text-amber-700 leading-relaxed">
                                    {{ $alasanTemaTerkunci }}
                                </p>
                            @else
                                <p class="mt-1.5 text-[11px] text-charcoal/55">
                                    Klik <strong class="text-charcoal">Ganti</strong> untuk memilih tema dari galeri pratinjau visual.
                                </p>
                            @endif
                        </div>

                        <div>
                            <div class="flex items-center justify-between gap-2 mb-1.5">
                                <label for="slug" class="block text-xs font-semibold text-charcoal/80">Link Undangan (Slug)</label>
                                @if ($undangan->status_publikasi && ! auth()->user()->adalahAdmin())
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2 py-0.5 text-[10px] font-semibold text-amber-700 ring-1 ring-amber-200">
                                        Terkunci (Aktif)
                                    </span>
                                @endif
                            </div>
                            <div class="flex items-center rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 focus-within:border-sage focus-within:ring-2 focus-within:ring-sage/15 transition">
                                <span class="text-xs sm:text-sm text-charcoal/45 select-none shrink-0">sesitemu.id/</span>
                                <input
                                    id="slug"
                                    name="slug"
                                    type="text"
                                    value="{{ old('slug', $undangan->slug) }}"
                                    @if ($undangan->status_publikasi && ! auth()->user()->adalahAdmin()) readonly @endif
                                    class="w-full min-w-0 bg-transparent text-sm font-semibold text-charcoal focus:outline-none ml-0.5 @if($undangan->status_publikasi && ! auth()->user()->adalahAdmin()) text-charcoal/60 cursor-not-allowed @endif"
                                >
                                <button
                                    type="button"
                                    @click="navigator.clipboard?.writeText(@js($urlPublik)); slugTersalin = true; setTimeout(() => slugTersalin = false, 2000)"
                                    :class="slugTersalin ? 'bg-sage text-white ring-sage' : 'bg-ivory text-charcoal/75 ring-champagne/30 hover:text-sage'"
                                    class="ml-2 rounded-lg px-2.5 py-1 text-[11px] font-semibold ring-1 transition shrink-0 cursor-pointer"
                                    x-text="slugTersalin ? 'Tersalin!' : 'Salin'"
                                ></button>
                            </div>
                            @if ($undangan->status_publikasi && ! auth()->user()->adalahAdmin())
                                <p class="mt-1 text-[11px] text-amber-700">Slug dikunci otomatis saat undangan aktif. Hubungi Admin jika perlu perubahan.</p>
                            @else
                                <p class="mt-1 text-[11px] text-charcoal/55">Gunakan huruf kecil &amp; tanda strip, contoh: <span class="font-mono text-sage">dimas-maya</span>.</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Grup 2: Tipografi & Musik Latar --}}
                <div class="rounded-2xl bg-ivory/65 p-4 sm:p-5 ring-1 ring-champagne/20 space-y-4">
                    <div class="flex items-center gap-2.5">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-champagne/20 text-[#8A6D33] shrink-0">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M9 18V5l12-2v13"/>
                                <circle cx="6" cy="18" r="3"/>
                                <circle cx="18" cy="16" r="3"/>
                            </svg>
                        </span>
                        <div>
                            <h3 class="font-sans text-sm font-bold text-charcoal leading-tight">Tipografi &amp; Musik Latar</h3>
                            <p class="text-[11px] text-charcoal/55">Sesuaikan gaya huruf dan lagu romantis pengiring undangan.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-3.5">
                        <div>
                            <label for="gaya_font" class="block text-xs font-semibold text-charcoal/80 mb-1.5">Desain Tipografi (Font Undangan)</label>
                            <select id="gaya_font" name="gaya_font" class="w-full rounded-xl border border-charcoal/15 bg-white px-4 py-2.5 text-sm focus:border-champagne focus:outline-none">
                                @foreach ($daftarGayaFont as $kodeFont => $infoFont)
                                    <option value="{{ $kodeFont }}" @selected($undangan->kodeGayaFontTerpilih() === $kodeFont)>
                                        {{ $infoFont['label'] }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1.5 text-[11px] text-charcoal/55">Gunakan bawaan tema atau pilih gaya klasik, editorial, hingga kaligrafi.</p>
                        </div>

                        <div>
                            <label for="musik_latar" class="block text-xs font-semibold text-charcoal/80 mb-1.5">Musik Latar Undangan</label>
                            <select
                                id="musik_latar"
                                name="musik_latar"
                                @change="musikDipilih = $event.target.value; hentikanAudioPreview()"
                                class="w-full rounded-xl border border-charcoal/15 bg-white px-4 py-2.5 text-sm focus:border-champagne focus:outline-none"
                            >
                                <option value="">-- Tanpa Musik Latar --</option>
                                @foreach ($daftarMusik as $musik)
                                    <option value="{{ $musik['path'] }}" @selected($undangan->musik_latar === $musik['path'])>
                                        {{ $musik['label'] }}
                                    </option>
                                @endforeach
                            </select>

                            <div x-show="urlMusikAktif()" x-cloak class="mt-2 flex items-center justify-between gap-2 rounded-xl bg-white px-3 py-2 ring-1 ring-champagne/25">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span
                                        :class="audioSedangPutar ? 'bg-sage text-white animate-pulse' : 'bg-sage/10 text-sage'"
                                        class="inline-flex h-6 w-6 items-center justify-center rounded-lg shrink-0 transition"
                                    >
                                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M9 18V5l12-2v13"/>
                                            <circle cx="6" cy="18" r="3"/>
                                            <circle cx="18" cy="16" r="3"/>
                                        </svg>
                                    </span>
                                    <span class="text-[11px] font-medium text-charcoal/70 truncate" x-text="audioSedangPutar ? 'Sedang memutar contoh musik...' : 'Dengarkan contoh lagu pilihan'"></span>
                                </div>
                                <button
                                    type="button"
                                    @click="toggleAudioPreview()"
                                    :class="audioSedangPutar ? 'bg-charcoal text-white' : 'bg-sage/12 text-sage hover:bg-sage hover:text-white'"
                                    class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1 text-[11px] font-semibold transition shrink-0 cursor-pointer"
                                >
                                    <svg x-show="!audioSedangPutar" class="h-3 w-3" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <polygon points="6 4 20 12 6 20 6 4"/>
                                    </svg>
                                    <svg x-show="audioSedangPutar" x-cloak class="h-3 w-3" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <rect x="6" y="4" width="4" height="16"/>
                                        <rect x="14" y="4" width="4" height="16"/>
                                    </svg>
                                    <span x-text="audioSedangPutar ? 'Berhenti' : 'Putar'"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Grup 3: Mode Privasi (Toggle Switch Modern) --}}
                <label
                    :class="tanpaFotoAktif ? 'border-champagne bg-champagne/10 ring-1 ring-champagne/30' : 'border-champagne/30 bg-ivory/65 hover:bg-ivory'"
                    class="flex items-center justify-between gap-3.5 rounded-2xl border p-4 sm:p-5 cursor-pointer transition"
                >
                    <div class="flex items-start gap-3 min-w-0">
                        <span
                            :class="tanpaFotoAktif ? 'bg-champagne text-white' : 'bg-white text-[#8A6D33] ring-1 ring-champagne/30'"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-xl shrink-0 transition"
                        >
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/>
                                <path d="m9 12 2 2 4-4"/>
                            </svg>
                        </span>
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-sm font-bold text-charcoal">Mode Tanpa Foto (TF / Monogram Privasi)</span>
                                <span
                                    :class="tanpaFotoAktif ? 'bg-champagne/25 text-[#755A22]' : 'bg-charcoal/8 text-charcoal/55'"
                                    class="rounded-full px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider"
                                    x-text="tanpaFotoAktif ? 'Aktif' : 'Nonaktif'"
                                ></span>
                            </div>
                            <p class="mt-0.5 text-xs text-charcoal/65 leading-relaxed">
                                Sembunyikan foto mempelai &amp; galeri, gantikan dengan inisial monogram elegan.
                            </p>
                        </div>
                    </div>

                    <span class="relative inline-flex items-center shrink-0">
                        <input
                            type="checkbox"
                            name="tanpa_foto"
                            value="1"
                            x-model="tanpaFotoAktif"
                            @checked($undangan->modeTanpaFoto())
                            class="sr-only peer"
                        >
                        <span class="w-11 h-6 rounded-full bg-charcoal/20 peer-checked:bg-sage peer-focus-visible:ring-2 peer-focus-visible:ring-sage/30 transition-colors after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow-xs after:transition-transform peer-checked:after:translate-x-5"></span>
                    </span>
                </label>

                {{-- Grup 4: Sakelar Fitur Undangan (Kartu Toggle Switch Interaktif) --}}
                <div class="space-y-3">
                    <div class="flex items-center justify-between gap-2">
                        <div>
                            <h3 class="font-sans text-sm font-bold text-charcoal">Sakelar Fitur Undangan</h3>
                            <p class="text-[11px] text-charcoal/55">Aktifkan atau sembunyikan bagian yang ingin ditampilkan ke tamu.</p>
                        </div>
                        <span
                            class="rounded-full bg-sage/10 px-2.5 py-1 font-sans tabular-nums text-[11px] font-bold text-sage shrink-0"
                            x-text="Object.values(sakelarFitur).filter(Boolean).length + '/5 Aktif'"
                        ></span>
                    </div>

                    <div class="grid grid-cols-1 gap-2">
                        @foreach ([
                            'fitur_hitung_mundur' => ['key' => 'hitung_mundur', 'label' => 'Hitung Mundur', 'desc' => 'Timer menuju hari H', 'ikon' => 'clock'],
                            'fitur_cerita_cinta' => ['key' => 'cerita_cinta', 'label' => 'Cerita Cinta', 'desc' => 'Linimasa kisah pasangan', 'ikon' => 'heart'],
                            'fitur_galeri' => ['key' => 'galeri', 'label' => 'Galeri Foto', 'desc' => 'Album foto prewedding', 'ikon' => 'image'],
                            'fitur_amplop_digital' => ['key' => 'amplop_digital', 'label' => 'Amplop Digital', 'desc' => 'Rekening & alamat kado', 'ikon' => 'gift'],
                            'fitur_buku_tamu' => ['key' => 'buku_tamu', 'label' => 'Buku Tamu', 'desc' => 'Form RSVP & ucapan doa', 'ikon' => 'message'],
                        ] as $inputName => $meta)
                            <label
                                :class="sakelarFitur['{{ $meta['key'] }}'] ? 'bg-sage/[0.06] border-sage/35 shadow-2xs' : 'bg-ivory/60 border-charcoal/10 opacity-80 hover:opacity-100'"
                                class="flex items-center justify-between gap-3 rounded-2xl border px-3.5 py-3 cursor-pointer transition"
                            >
                                <div class="flex items-center gap-3 min-w-0">
                                    <span
                                        :class="sakelarFitur['{{ $meta['key'] }}'] ? 'bg-sage text-white' : 'bg-white text-charcoal/50 ring-1 ring-charcoal/10'"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-xl shrink-0 transition"
                                    >
                                        @switch($meta['ikon'])
                                            @case('clock')
                                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"/>
                                                    <polyline points="12 6 12 12 16 14"/>
                                                </svg>
                                                @break
                                            @case('heart')
                                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                                                </svg>
                                                @break
                                            @case('image')
                                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <rect width="18" height="18" x="3" y="3" rx="2" ry="2"/>
                                                    <circle cx="9" cy="9" r="2"/>
                                                    <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                                                </svg>
                                                @break
                                            @case('gift')
                                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <rect x="3" y="8" width="18" height="4" rx="1"/>
                                                    <path d="M12 8v13"/>
                                                    <path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"/>
                                                    <path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"/>
                                                </svg>
                                                @break
                                            @default
                                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                                </svg>
                                        @endswitch
                                    </span>
                                    <div class="min-w-0">
                                        <span class="block text-xs sm:text-[13px] font-bold text-charcoal leading-tight truncate">{{ $meta['label'] }}</span>
                                        <span class="block text-[11px] text-charcoal/55 leading-tight truncate mt-0.5">{{ $meta['desc'] }}</span>
                                    </div>
                                </div>

                                <span class="relative inline-flex items-center shrink-0">
                                    <input
                                        type="checkbox"
                                        name="{{ $inputName }}"
                                        value="1"
                                        x-model="sakelarFitur['{{ $meta['key'] }}']"
                                        @checked($undangan->fiturAktif($meta['key']))
                                        class="sr-only peer"
                                    >
                                    <span class="w-10 h-5.5 rounded-full bg-charcoal/20 peer-checked:bg-sage peer-focus-visible:ring-2 peer-focus-visible:ring-sage/30 transition-colors after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:h-4.5 after:w-4.5 after:rounded-full after:bg-white after:shadow-xs after:transition-transform peer-checked:after:translate-x-4.5"></span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-sage px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#3b5047] active:scale-[0.98] transition cursor-pointer">
                        <span>Simpan Tema &amp; Lanjut ke Mempelai</span>
                        <span aria-hidden="true">&rarr;</span>
                    </button>
                </div>
            </form>
                    </section>
                </div>

                {{-- ACCORDION 2: Data Mempelai --}}
                <div
                    :class="tab === 'mempelai' ? 'border-sage/45 ring-1 ring-sage/15 shadow-xs' : 'border-champagne/30 hover:border-champagne/60'"
                    class="rounded-2xl border bg-white overflow-hidden transition"
                >
                    <button
                        type="button"
                        data-mobile-tab="mempelai"
                        @click="toggleBagian('mempelai')"
                        class="w-full px-4 py-3.5 flex items-center justify-between gap-3 text-left cursor-pointer hover:bg-ivory/50 transition"
                    >
                        <div class="flex items-center gap-3 min-w-0">
                            <svg
                                :class="tab === 'mempelai' ? 'rotate-90 text-sage' : 'text-charcoal/45'"
                                class="h-4 w-4 shrink-0 transition-transform duration-200"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                            >
                                <path d="m9 18 6-6-6-6"/>
                            </svg>
                            <svg class="h-4 w-4 text-sage shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                            </svg>
                            <span class="font-sans text-sm font-semibold text-charcoal truncate">Data Mempelai</span>
                        </div>
                        @if ($tabSelesai['mempelai'])
                            <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-sage/12 text-sage shrink-0">
                                <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                            </span>
                        @endif
                    </button>

                    <section x-show="tab === 'mempelai'" x-cloak class="px-4 pb-5 pt-2 border-t border-champagne/20">
                        <div class="pb-3 mb-1 border-b border-champagne/15 space-y-2">
                            <div>
                                <h2 class="font-sans text-base font-bold text-charcoal tracking-tight">Data Kedua Mempelai &amp; Kutipan Doa</h2>
                                <p class="mt-0.5 text-xs text-charcoal/60">Foto otomatis dikompresi ke format <span class="font-mono font-semibold text-sage">.webp</span> agar ringan dibuka.</p>
                            </div>

                            @if ($undangan->modeTanpaFoto())
                                <button
                                    type="button"
                                    @click="pilihTab('tema')"
                                    class="inline-flex items-center gap-2 rounded-xl border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-medium text-amber-800 hover:bg-amber-100 transition cursor-pointer text-left"
                                >
                                    <span class="w-2 h-2 rounded-full bg-amber-500 shrink-0"></span>
                                    <span>Mode Tanpa Foto aktif &mdash; ubah di Tema &amp; Tampilan jika ingin tampilkan foto</span>
                                </button>
                            @endif
                        </div>

            <form
                action="{{ route('dashboard.undangan.perbarui', $undangan) }}"
                method="POST"
                enctype="multipart/form-data"
                class="mt-6 space-y-6 sm:space-y-8"
                data-swal-loading
                data-swal-loading-title="Menyimpan &amp; Mengompresi Foto..."
                data-swal-loading-text="Mengonversi foto ke .webp hemat kuota dan menyimpan data mempelai..."
            >
                @csrf
                @method('PUT')
                <input type="hidden" name="bagian" value="mempelai">

                <div class="grid grid-cols-1 gap-4">
                    {{-- Mempelai Pria --}}
                    <div class="rounded-2xl bg-gradient-to-br from-ivory via-white to-sage/[0.04] p-5 sm:p-6 ring-1 ring-champagne/25 shadow-xs space-y-5">
                        <div class="flex items-center justify-between border-b border-champagne/20 pb-3.5">
                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-sage">Calon Pengantin Pria</p>
                                <h3 class="font-logo text-xl font-bold text-charcoal tracking-tight mt-0.5" x-text="namaPriaLive || 'Mempelai Pria'">{{ $undangan->nama_panggilan_pria }}</h3>
                            </div>
                            <span class="rounded-full bg-sage/10 px-3 py-1 text-xs font-sans font-bold text-sage">Putra</span>
                        </div>

                        @include('dashboard._input-foto-pratinjau', [
                            'name' => 'foto_pria',
                            'varian' => 'lingkaran',
                            'label' => 'Foto Mempelai Pria',
                            'petunjuk' => 'Rekomendasi rasio 1:1 • JPG/PNG/WebP maks. 5 MB',
                            'urlAwal' => $undangan->urlFotoPria(),
                            'inisial' => $undangan->inisialPria(),
                        ])

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal/75">Nama Panggilan Pria</label>
                                <input type="text" name="nama_panggilan_pria" x-model="namaPriaLive" value="{{ old('nama_panggilan_pria', $undangan->nama_panggilan_pria) }}" required placeholder="Contoh: Dimas" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-white px-4 py-2.5 text-sm focus:border-sage focus:ring-2 focus:ring-sage/15 focus:outline-none transition">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal/75">Nama Lengkap &amp; Gelar Pria</label>
                                <input type="text" name="nama_lengkap_pria" value="{{ old('nama_lengkap_pria', $undangan->nama_lengkap_pria) }}" required placeholder="Contoh: Dimas Pratama Putra, S.Kom." class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-white px-4 py-2.5 text-sm focus:border-sage focus:ring-2 focus:ring-sage/15 focus:outline-none transition">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                                <div>
                                    <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal/75">Nama Ayah</label>
                                    <input type="text" name="nama_ayah_pria" value="{{ old('nama_ayah_pria', $undangan->nama_ayah_pria) }}" placeholder="Bpk. ..." class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2.5 text-sm focus:border-sage focus:ring-2 focus:ring-sage/15 focus:outline-none transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal/75">Nama Ibu</label>
                                    <input type="text" name="nama_ibu_pria" value="{{ old('nama_ibu_pria', $undangan->nama_ibu_pria) }}" placeholder="Ibu ..." class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2.5 text-sm focus:border-sage focus:ring-2 focus:ring-sage/15 focus:outline-none transition">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Mempelai Wanita --}}
                    <div class="rounded-2xl bg-gradient-to-br from-ivory via-white to-champagne/[0.06] p-5 sm:p-6 ring-1 ring-champagne/25 shadow-xs space-y-5">
                        <div class="flex items-center justify-between border-b border-champagne/20 pb-3.5">
                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-champagne">Calon Pengantin Wanita</p>
                                <h3 class="font-logo text-xl font-bold text-charcoal tracking-tight mt-0.5" x-text="namaWanitaLive || 'Mempelai Wanita'">{{ $undangan->nama_panggilan_wanita }}</h3>
                            </div>
                            <span class="rounded-full bg-champagne/15 px-3 py-1 text-xs font-sans font-bold text-champagne">Putri</span>
                        </div>

                        @include('dashboard._input-foto-pratinjau', [
                            'name' => 'foto_wanita',
                            'varian' => 'lingkaran',
                            'label' => 'Foto Mempelai Wanita',
                            'petunjuk' => 'Rekomendasi rasio 1:1 • JPG/PNG/WebP maks. 5 MB',
                            'urlAwal' => $undangan->urlFotoWanita(),
                            'inisial' => $undangan->inisialWanita(),
                        ])

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal/75">Nama Panggilan Wanita</label>
                                <input type="text" name="nama_panggilan_wanita" x-model="namaWanitaLive" value="{{ old('nama_panggilan_wanita', $undangan->nama_panggilan_wanita) }}" required placeholder="Contoh: Maya" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-white px-4 py-2.5 text-sm focus:border-champagne focus:ring-2 focus:ring-champagne/20 focus:outline-none transition">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal/75">Nama Lengkap &amp; Gelar Wanita</label>
                                <input type="text" name="nama_lengkap_wanita" value="{{ old('nama_lengkap_wanita', $undangan->nama_lengkap_wanita) }}" required placeholder="Contoh: Maya Sari Kusuma, S.E." class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-white px-4 py-2.5 text-sm focus:border-champagne focus:ring-2 focus:ring-champagne/20 focus:outline-none transition">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                                <div>
                                    <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal/75">Nama Ayah</label>
                                    <input type="text" name="nama_ayah_wanita" value="{{ old('nama_ayah_wanita', $undangan->nama_ayah_wanita) }}" placeholder="Bpk. ..." class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2.5 text-sm focus:border-champagne focus:ring-2 focus:ring-champagne/20 focus:outline-none transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal/75">Nama Ibu</label>
                                    <input type="text" name="nama_ibu_wanita" value="{{ old('nama_ibu_wanita', $undangan->nama_ibu_wanita) }}" placeholder="Ibu ..." class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2.5 text-sm focus:border-champagne focus:ring-2 focus:ring-champagne/20 focus:outline-none transition">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Foto Sampul Gerbang Undangan dengan Pratinjau Mockup Live --}}
                <div class="rounded-2xl bg-gradient-to-br from-ivory to-champagne/[0.06] p-5 sm:p-6 ring-1 ring-champagne/25 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <div>
                            <h3 class="font-sans text-base sm:text-lg font-bold text-charcoal tracking-tight">Foto Sampul Gerbang Undangan <span class="text-xs font-semibold text-charcoal/50">(Opsional)</span></h3>
                            <p class="text-xs text-charcoal/65 mt-0.5 leading-relaxed">
                                Tampil sebagai layar pembuka sebelum tamu menekan <em>Buka Undangan</em>. Jika kosong, otomatis memakai foto pertama Galeri atau foto mempelai.
                            </p>
                        </div>
                        <span class="self-start sm:self-auto rounded-full bg-white px-3 py-1 text-[11px] font-semibold text-champagne ring-1 ring-champagne/30 shrink-0">
                            Rasio 3:4 / 9:16
                        </span>
                    </div>

                    @include('dashboard._input-foto-pratinjau', [
                        'name' => 'foto_sampul',
                        'varian' => 'sampul',
                        'label' => 'Foto Sampul Gerbang',
                        'petunjuk' => 'Seret & lepas atau klik untuk pilih foto potret (JPG/PNG/WebP maks. 5 MB)',
                        'urlAwal' => $undangan->urlFotoSampulKhususDashboard(),
                        'hapusNama' => 'hapus_foto_sampul',
                        'hapusLabel' => 'Hapus foto sampul khusus',
                    ])
                </div>

                {{-- Kutipan Ayat / Doa dengan Pilihan Cepat --}}
                <div class="rounded-2xl bg-ivory/75 p-5 sm:p-6 ring-1 ring-champagne/25 space-y-3">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <div>
                            <label for="kutipan_ayat" class="block font-sans text-base sm:text-lg font-bold text-charcoal tracking-tight">Kutipan Ayat / Doa / Kata Mutiara</label>
                            <p class="text-xs text-charcoal/60 mt-0.5">Tulis kutipan sendiri atau pilih langsung dari inspirasi cepat di bawah.</p>
                        </div>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach ([
                                'QS. Ar-Rum: 21' => 'Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu pasangan hidup dari jenismu sendiri, supaya kamu merasa tenteram di sampingnya. (QS. Ar-Rum: 21)',
                                'Doa Barakallahu' => 'Baarakallahu laka wa baaraka ‘alaika wa jama’a bainakuma fii khair. Semoga Allah menghimpun kami dalam keberkahan dan kebaikan.',
                                'QS. Adz-Dzariyat: 49' => 'Dan segala sesuatu Kami ciptakan berpasang-pasangan supaya kamu mengingat kebesaran Allah. (QS. Adz-Dzariyat: 49)',
                                'Puitis Klasik' => 'Dua jiwa yang berjalan terpisah kini bertemu pada satu garis takdir yang sama, berjanji menjaga cinta di setiap musim kehidupan.',
                            ] as $judulTemplate => $isiTemplate)
                                <button
                                    type="button"
                                    @click="$refs.kutipanInput.value = @js($isiTemplate)"
                                    class="rounded-full bg-white px-3 py-1 text-[11px] font-semibold text-sage ring-1 ring-sage/25 hover:bg-sage hover:text-white transition cursor-pointer"
                                >
                                    + {{ $judulTemplate }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <textarea
                        x-ref="kutipanInput"
                        id="kutipan_ayat"
                        name="kutipan_ayat"
                        rows="3"
                        placeholder="Masukkan ayat suci, doa pernikahan, atau untaian kata indah untuk tamu..."
                        class="w-full rounded-xl border border-charcoal/15 bg-white px-4 py-3 text-sm leading-relaxed focus:border-sage focus:ring-2 focus:ring-sage/15 focus:outline-none transition"
                    >{{ old('kutipan_ayat', $undangan->kutipan_ayat) }}</textarea>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-sage px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#3b5047] active:scale-[0.98] transition cursor-pointer">
                        <span>Simpan Mempelai &amp; Lanjut ke Acara</span>
                        <span aria-hidden="true">&rarr;</span>
                    </button>
                </div>
            </form>
                    </section>
                </div>

                {{-- ACCORDION 3: Rangkaian Acara --}}
                <div
                    :class="tab === 'acara' ? 'border-sage/45 ring-1 ring-sage/15 shadow-xs' : 'border-champagne/30 hover:border-champagne/60'"
                    class="rounded-2xl border bg-white overflow-hidden transition"
                >
                    <button
                        type="button"
                        data-mobile-tab="acara"
                        @click="toggleBagian('acara')"
                        class="w-full px-4 py-3.5 flex items-center justify-between gap-3 text-left cursor-pointer hover:bg-ivory/50 transition"
                    >
                        <div class="flex items-center gap-3 min-w-0">
                            <svg
                                :class="tab === 'acara' ? 'rotate-90 text-sage' : 'text-charcoal/45'"
                                class="h-4 w-4 shrink-0 transition-transform duration-200"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                            >
                                <path d="m9 18 6-6-6-6"/>
                            </svg>
                            <svg class="h-4 w-4 text-sage shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                                <line x1="16" x2="16" y1="2" y2="6"/>
                                <line x1="8" x2="8" y1="2" y2="6"/>
                                <line x1="3" x2="21" y1="10" y2="10"/>
                            </svg>
                            <span class="font-sans text-sm font-semibold text-charcoal truncate">Rangkaian Acara</span>
                        </div>
                        <span class="rounded-full bg-ivory px-2 py-0.5 font-sans tabular-nums text-[11px] font-semibold text-sage ring-1 ring-champagne/25 shrink-0">
                            {{ $undangan->daftarAcara->count() }} Acara
                        </span>
                    </button>

                    <section x-show="tab === 'acara'" x-cloak class="px-4 pb-5 pt-3 border-t border-champagne/20 space-y-5">
                        <div x-ref="formAcaraPanel" class="space-y-4">
                            <div class="flex items-center justify-between gap-2 pb-2.5 border-b border-champagne/15">
                                <div>
                                    <h2 class="font-sans text-base font-bold text-charcoal tracking-tight" x-text="acaraEdit ? ('Edit Acara: ' + acaraEdit.nama_acara) : 'Tambah Jadwal Acara'"></h2>
                                    <p class="mt-0.5 text-xs text-charcoal/60">Akad Nikah, Pemberkatan, Resepsi, dll.</p>
                                </div>
                    <button type="button" x-show="acaraEdit" x-cloak @click="acaraEdit = null" class="self-start sm:self-auto rounded-xl border border-champagne/50 bg-ivory px-3.5 py-2 text-xs font-semibold text-charcoal hover:bg-champagne/15 transition cursor-pointer shrink-0">
                        + Batal Edit / Tambah Baru
                    </button>
                </div>

                <form
                    action="{{ route('dashboard.acara.simpan', $undangan) }}"
                    method="POST"
                    class="mt-4 grid grid-cols-1 gap-3.5"
                    data-swal-loading
                    :data-swal-loading-title="acaraEdit ? 'Memperbarui Jadwal Acara...' : 'Menambahkan Jadwal Acara...'"
                    data-swal-loading-text="Menyimpan jadwal dan lokasi acara ke undangan..."
                >
                    @csrf
                    <input type="hidden" name="acara_id" :value="acaraEdit ? acaraEdit.id : ''">

                    <div class="space-y-2">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal/75">Nama Acara</label>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach (['Akad Nikah', 'Resepsi', 'Pemberkatan', 'Ngunduh Mantu', 'Walimatul Ursy'] as $presetAcara)
                                    <button
                                        type="button"
                                        @click="$refs.namaAcaraInput.value = @js($presetAcara)"
                                        class="rounded-full bg-ivory px-2.5 py-0.5 text-[11px] font-semibold text-sage ring-1 ring-sage/25 hover:bg-sage hover:text-white transition cursor-pointer"
                                    >
                                        + {{ $presetAcara }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        <input
                            x-ref="namaAcaraInput"
                            type="text"
                            name="nama_acara"
                            :value="acaraEdit ? acaraEdit.nama_acara : ''"
                            required
                            placeholder="Akad Nikah / Resepsi"
                            class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm focus:border-sage focus:bg-white focus:ring-2 focus:ring-sage/15 focus:outline-none transition"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal/75">Tanggal Acara</label>
                        <input type="date" name="tanggal_acara" :value="acaraEdit ? acaraEdit.tanggal_acara : ''" required class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2.5 text-sm focus:border-sage focus:bg-white focus:outline-none transition">
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal/75">Mulai</label>
                            <input type="time" name="waktu_mulai" :value="acaraEdit ? acaraEdit.waktu_mulai : '08:00'" required class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-2.5 py-2.5 text-sm focus:border-sage focus:bg-white focus:outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal/75">Selesai</label>
                            <input type="time" name="waktu_selesai" :value="acaraEdit ? acaraEdit.waktu_selesai : ''" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-2.5 py-2.5 text-sm focus:border-sage focus:bg-white focus:outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal/75">Zona</label>
                            <select name="zona_waktu" :value="acaraEdit ? acaraEdit.zona_waktu : 'WIB'" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-2 py-2.5 text-sm">
                                <option value="WIB">WIB</option>
                                <option value="WITA">WITA</option>
                                <option value="WIT">WIT</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal/75">Nama Tempat / Gedung</label>
                        <input type="text" name="nama_tempat" :value="acaraEdit ? acaraEdit.nama_tempat : ''" required placeholder="Masjid Agung / Hotel..." class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2.5 text-sm focus:border-sage focus:bg-white focus:outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal/75">Link Google Maps <span class="font-normal normal-case text-charcoal/50">(Opsional)</span></label>
                        <input type="url" name="link_maps" :value="acaraEdit ? acaraEdit.link_maps : ''" placeholder="https://maps.google.com/..." class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2.5 text-sm focus:border-sage focus:bg-white focus:outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal/75">Alamat Lengkap</label>
                        <textarea name="alamat_lengkap" rows="2" required placeholder="Jl. Raya Merdeka No. 10, Kecamatan, Kota..." x-text="acaraEdit ? acaraEdit.alamat_lengkap : ''" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2.5 text-sm focus:border-sage focus:bg-white focus:outline-none transition"></textarea>
                    </div>

                    <div>
                        <button type="submit" class="w-full rounded-xl bg-sage px-5 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer shadow-xs" x-text="acaraEdit ? 'Perbarui Acara' : '+ Tambah Acara'">
                        </button>
                    </div>
                </form>
            </div>

            {{-- Daftar Kartu Rangkaian Acara --}}
            <div class="space-y-3">
                <div class="flex items-center justify-between px-1">
                    <h3 class="font-sans text-sm font-bold text-charcoal tracking-tight">
                        Daftar Jadwal Terpasang
                        <span class="ml-1.5 inline-flex items-center rounded-full bg-sage/10 px-2 py-0.5 font-sans tabular-nums text-[11px] font-bold tracking-normal text-sage">
                            {{ $undangan->daftarAcara->count() }} Acara
                        </span>
                    </h3>
                </div>

                <div class="grid grid-cols-1 gap-3.5">
                    @forelse ($undangan->daftarAcara as $idx => $acara)
                        @php
                            $selisihHari = now()->startOfDay()->diffInDays($acara->tanggal_acara->copy()->startOfDay(), false);
                            $badgeHari = match (true) {
                                $selisihHari > 0 => "H-{$selisihHari} Hari",
                                $selisihHari === 0 => 'Hari Ini',
                                default => 'Sudah Lewat',
                            };
                            $bulanSingkat = \Illuminate\Support\Str::upper($acara->tanggal_acara->locale('id')->translatedFormat('M'));
                        @endphp
                        <article
                            :class="acaraEdit?.id === {{ $acara->id }} ? 'ring-2 ring-sage shadow-md bg-sage/[0.02]' : 'ring-1 ring-champagne/25 hover:ring-champagne/55 hover:shadow-md bg-white'"
                            class="group rounded-2xl shadow-sm overflow-hidden transition-all duration-200 flex flex-col justify-between"
                        >
                            <div class="h-1.5 w-full {{ $idx % 2 === 0 ? 'bg-gradient-to-r from-sage via-champagne to-sage/40' : 'bg-gradient-to-r from-champagne via-sage to-champagne/40' }}"></div>

                            <div class="p-5 sm:p-6 flex-1 flex flex-col justify-between gap-4">
                                <div class="space-y-4">
                                    {{-- Header: Blok Tanggal Kalender + Nama & Jam Acara --}}
                                    <div class="flex items-start gap-4">
                                        <div class="w-16 rounded-2xl bg-gradient-to-b from-sage to-[#3A4D44] text-white text-center overflow-hidden shadow-sm shrink-0 select-none">
                                            <div class="bg-black/20 py-1 text-[10px] font-bold uppercase tracking-[0.2em]">
                                                {{ $bulanSingkat }}
                                            </div>
                                            <div class="pt-1.5 font-sans tabular-nums text-2xl font-bold leading-none">
                                                {{ $acara->tanggal_acara->format('d') }}
                                            </div>
                                            <div class="pb-1.5 pt-0.5 font-sans tabular-nums text-[10px] font-semibold text-[#F3E5AB]">
                                                {{ $acara->tanggal_acara->format('Y') }}
                                            </div>
                                        </div>

                                        <div class="min-w-0 flex-1 space-y-1.5">
                                            <div class="flex flex-wrap items-center justify-between gap-1.5">
                                                <span class="inline-flex items-center gap-1 rounded-full bg-champagne/15 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-champagne">
                                                    Acara #{{ $idx + 1 }}
                                                </span>
                                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[10px] font-bold {{ $selisihHari >= 0 ? 'bg-sage/10 text-sage' : 'bg-charcoal/10 text-charcoal/60' }}">
                                                    {{ $badgeHari }}
                                                </span>
                                            </div>

                                            <h4 class="font-logo text-xl sm:text-[1.35rem] font-bold text-charcoal tracking-tight leading-snug">
                                                {{ $acara->nama_acara }}
                                            </h4>

                                            <p class="text-xs text-charcoal/70 font-medium">
                                                {{ $acara->tanggal_acara->locale('id')->translatedFormat('l, d F Y') }}
                                            </p>

                                            <div class="inline-flex items-center gap-1.5 rounded-lg bg-ivory px-2.5 py-1 ring-1 ring-champagne/25 text-xs font-semibold text-sage">
                                                <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <circle cx="12" cy="12" r="10"/>
                                                    <polyline points="12 6 12 12 16 14"/>
                                                </svg>
                                                <span>
                                                    {{ substr($acara->waktu_mulai, 0, 5) }}
                                                    @if ($acara->waktu_selesai) - {{ substr($acara->waktu_selesai, 0, 5) }} @endif
                                                    {{ $acara->zona_waktu }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Detail Lokasi & Google Maps --}}
                                    <div class="rounded-xl bg-ivory/80 p-3.5 ring-1 ring-champagne/20 space-y-1.5">
                                        <div class="flex items-start gap-2.5">
                                            <svg class="h-4 w-4 text-champagne mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                                                <circle cx="12" cy="10" r="3"/>
                                            </svg>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-semibold text-charcoal">{{ $acara->nama_tempat }}</p>
                                                <p class="mt-0.5 text-xs text-charcoal/70 leading-relaxed">{{ $acara->alamat_lengkap }}</p>
                                            </div>
                                        </div>

                                        @if ($acara->link_maps)
                                            <div class="pl-6.5 pt-0.5">
                                                <a
                                                    href="{{ $acara->link_maps }}"
                                                    target="_blank"
                                                    rel="noopener"
                                                    class="inline-flex items-center gap-1 rounded-full bg-white px-2.5 py-1 text-[11px] font-semibold text-sage ring-1 ring-sage/25 hover:bg-sage hover:text-white transition"
                                                >
                                                    <span>Buka Google Maps</span>
                                                    <span aria-hidden="true">&nearr;</span>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Footer Tombol Aksi --}}
                                <div class="pt-3 border-t border-champagne/15 flex items-center justify-between gap-3">
                                    <span
                                        x-show="acaraEdit?.id === {{ $acara->id }}"
                                        x-cloak
                                        class="inline-flex items-center gap-1.5 text-[11px] font-bold text-sage"
                                    >
                                        <span class="w-1.5 h-1.5 rounded-full bg-sage animate-pulse"></span>
                                        Sedang diedit di atas
                                    </span>
                                    <span x-show="acaraEdit?.id !== {{ $acara->id }}" class="text-[11px] text-charcoal/45">
                                        Siap tampil di undangan
                                    </span>

                                    <div class="flex items-center gap-2">
                                        <button
                                            type="button"
                                            @click="acaraEdit = {{ Js::from([
                                                'id' => $acara->id,
                                                'nama_acara' => $acara->nama_acara,
                                                'tanggal_acara' => $acara->tanggal_acara->format('Y-m-d'),
                                                'waktu_mulai' => substr($acara->waktu_mulai, 0, 5),
                                                'waktu_selesai' => $acara->waktu_selesai ? substr($acara->waktu_selesai, 0, 5) : '',
                                                'zona_waktu' => $acara->zona_waktu,
                                                'nama_tempat' => $acara->nama_tempat,
                                                'alamat_lengkap' => $acara->alamat_lengkap,
                                                'link_maps' => $acara->link_maps ?? '',
                                            ]) }}; $refs.formAcaraPanel?.scrollIntoView({ behavior: 'smooth', block: 'start' })"
                                            class="inline-flex items-center gap-1.5 rounded-xl border border-champagne/60 bg-ivory/70 px-3.5 py-1.5 text-xs font-semibold text-charcoal hover:bg-champagne/15 transition cursor-pointer"
                                        >
                                            <svg class="h-3.5 w-3.5 text-champagne" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                                            </svg>
                                            <span>Edit</span>
                                        </button>

                                        <form
                                            action="{{ route('dashboard.acara.hapus', [$undangan, $acara]) }}"
                                            method="POST"
                                            data-swal-title="Hapus Jadwal Acara?"
                                            data-swal-confirm="Yakin ingin menghapus acara {{ $acara->nama_acara }}?"
                                            data-swal-icon="warning"
                                            data-swal-confirm-button="Ya, Hapus"
                                            data-swal-confirm-color="#DC2626"
                                            data-swal-loading-title="Menghapus Jadwal Acara..."
                                            data-swal-loading-text="Menghapus jadwal acara dari undangan..."
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl border border-rose-200 bg-rose-50/70 px-3.5 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-100 transition cursor-pointer">
                                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M3 6h18"/>
                                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                                </svg>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full rounded-2xl bg-white p-10 text-center ring-1 ring-champagne/25 space-y-2.5">
                            <div class="mx-auto w-12 h-12 rounded-2xl bg-ivory ring-1 ring-champagne/30 text-champagne flex items-center justify-center">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                                    <line x1="16" x2="16" y1="2" y2="6"/>
                                    <line x1="8" x2="8" y1="2" y2="6"/>
                                    <line x1="3" x2="21" y1="10" y2="10"/>
                                </svg>
                            </div>
                            <p class="font-logo text-lg font-bold text-charcoal tracking-tight">Belum Ada Rangkaian Acara</p>
                            <p class="text-sm text-charcoal/65 max-w-md mx-auto">Tambahkan jadwal seperti Akad Nikah atau Resepsi lewat formulir di atas agar langsung tampil di undangan tamu.</p>
                        </div>
                    @endforelse
                </div>
            </div>

                    </section>
                </div>

                {{-- ACCORDION 4: Galeri & Cerita --}}
                @php
                    $jumlahGaleri = $undangan->daftarGaleri->count();
                    $persenGaleri = min(100, (int) round(($jumlahGaleri / 10) * 100));
                @endphp
                <div
                    :class="tab === 'galeri' ? 'border-sage/45 ring-1 ring-sage/15 shadow-xs' : 'border-champagne/30 hover:border-champagne/60'"
                    class="rounded-2xl border bg-white overflow-hidden transition"
                >
                    <button
                        type="button"
                        data-mobile-tab="galeri"
                        @click="toggleBagian('galeri')"
                        class="w-full px-4 py-3.5 flex items-center justify-between gap-3 text-left cursor-pointer hover:bg-ivory/50 transition"
                    >
                        <div class="flex items-center gap-3 min-w-0">
                            <svg
                                :class="tab === 'galeri' ? 'rotate-90 text-sage' : 'text-charcoal/45'"
                                class="h-4 w-4 shrink-0 transition-transform duration-200"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                            >
                                <path d="m9 18 6-6-6-6"/>
                            </svg>
                            <svg class="h-4 w-4 text-sage shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="18" height="18" x="3" y="3" rx="2" ry="2"/>
                                <circle cx="9" cy="9" r="2"/>
                                <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                            </svg>
                            <span class="font-sans text-sm font-semibold text-charcoal truncate">Galeri &amp; Cerita</span>
                        </div>
                        <span class="rounded-full bg-ivory px-2 py-0.5 font-sans tabular-nums text-[11px] font-semibold text-sage ring-1 ring-champagne/25 shrink-0">
                            {{ $jumlahGaleri }}/10 Foto
                        </span>
                    </button>

                    <section x-show="tab === 'galeri'" x-cloak class="px-4 pb-5 pt-3 border-t border-champagne/20 space-y-5">
                        {{-- Upload Galeri --}}
                        <div class="space-y-4">
                            <div class="space-y-3 pb-3 border-b border-champagne/15">
                                <div>
                                    <h2 class="font-sans text-base font-bold text-charcoal tracking-tight">Galeri Foto Prewedding</h2>
                                    <p class="mt-0.5 text-xs text-charcoal/60">Semua foto otomatis dikompresi ke format <span class="font-mono font-semibold text-sage">.webp</span> agar undangan cepat dibuka.</p>
                                </div>
                                <div class="rounded-xl bg-ivory p-3 ring-1 ring-champagne/25">
                                    <div class="flex items-center justify-between text-xs font-semibold text-charcoal">
                                        <span>Kuota Galeri</span>
                                        <span class="text-sage font-bold">{{ $jumlahGaleri }}/10 Foto</span>
                                    </div>
                                    <div class="mt-2 h-1.5 w-full rounded-full bg-champagne/20 overflow-hidden">
                                        <div class="h-full rounded-full bg-gradient-to-r from-sage to-champagne transition-all duration-500" style="width: {{ $persenGaleri }}%"></div>
                                    </div>
                                </div>
                            </div>

                <form
                    action="{{ route('dashboard.galeri.unggah', $undangan) }}"
                    method="POST"
                    enctype="multipart/form-data"
                    @submit="if (!$el.querySelector('input[type=file]')?.files?.length) { $event.preventDefault(); window.Swal?.fire({ icon: 'warning', title: 'Pilih Foto Dulu', text: 'Silakan pilih file foto prewedding yang ingin diunggah.', confirmButtonColor: '#4B6358' }); }"
                    class="mt-4 grid grid-cols-1 gap-4"
                    data-swal-loading
                    data-swal-loading-title="Mengunggah &amp; Mengompresi Foto..."
                    data-swal-loading-text="Mengonversi foto galeri ke .webp dan menyimpannya..."
                >
                    @csrf
                    <div class="flex">
                        @include('dashboard._input-foto-pratinjau', [
                            'name' => 'foto',
                            'varian' => 'galeri',
                            'label' => 'Pilih atau Seret Foto Prewedding',
                            'petunjuk' => 'JPG/PNG/WebP • Maks. 5 MB • Klik foto untuk melihat pratinjau penuh',
                        ])
                    </div>

                    <div class="rounded-2xl bg-gradient-to-br from-ivory via-white to-champagne/[0.06] ring-1 ring-champagne/25 p-4 flex flex-col justify-between gap-4">
                        <div class="space-y-2.5 flex-1 flex flex-col">
                            <div class="flex items-center justify-between gap-2">
                                <label for="keterangan_galeri" class="text-xs font-semibold uppercase tracking-wider text-charcoal/80">
                                    Keterangan Foto <span class="font-normal normal-case text-charcoal/50">(Opsional)</span>
                                </label>
                                <span class="text-[11px] text-charcoal/50">Tampil di galeri tamu</span>
                            </div>

                            <div class="flex flex-wrap gap-1.5">
                                @foreach (['Prewedding Outdoor', 'Momen Lamaran', 'Persiapan Akad', 'Senja Bersama'] as $saranKet)
                                    <button
                                        type="button"
                                        @click="$refs.ketGaleriInput.value = @js($saranKet)"
                                        class="rounded-full bg-white px-2.5 py-1 text-[11px] font-semibold text-sage ring-1 ring-sage/25 hover:bg-sage hover:text-white transition cursor-pointer"
                                    >
                                        + {{ $saranKet }}
                                    </button>
                                @endforeach
                            </div>

                            <textarea
                                id="keterangan_galeri"
                                x-ref="ketGaleriInput"
                                name="keterangan"
                                rows="3"
                                placeholder="Ceritakan singkat momen foto ini (misal: Sesi prewedding di Bandung)..."
                                class="w-full flex-1 resize-none rounded-xl border border-charcoal/15 bg-white px-3.5 py-2.5 text-sm leading-relaxed focus:border-sage focus:ring-2 focus:ring-sage/15 focus:outline-none transition"
                            ></textarea>
                        </div>

                        <div class="flex items-center justify-between gap-3 pt-1">
                            <p class="text-[11px] text-charcoal/55">Urutan foto otomatis ke-#{{ $jumlahGaleri + 1 }}</p>
                            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-sage px-5 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer shadow-sm">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="17 8 12 3 7 8"/>
                                    <line x1="12" y1="3" x2="12" y2="15"/>
                                </svg>
                                <span>Unggah Foto</span>
                            </button>
                        </div>
                    </div>
                </form>

                @if ($undangan->daftarGaleri->isNotEmpty())
                    <div class="mt-7 pt-6 border-t border-champagne/20">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-semibold text-charcoal">Koleksi Foto Terunggah</h3>
                            <span class="text-xs text-charcoal/55">Klik foto untuk memperbesar</span>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach ($undangan->daftarGaleri as $galeri)
                                <div class="group rounded-2xl overflow-hidden bg-white ring-1 ring-champagne/25 shadow-xs hover:shadow-md transition flex flex-col">
                                    <div
                                        @click="galeriLightbox = { url: @js($galeri->urlFoto()), caption: @js($galeri->keterangan ?: 'Foto #'.$galeri->urutan) }"
                                        class="relative aspect-[4/5] overflow-hidden bg-ivory cursor-zoom-in"
                                    >
                                        <img src="{{ $galeri->urlFoto() }}" alt="{{ $galeri->keterangan ?? 'Foto Galeri' }}" class="w-full h-full object-cover object-top transition duration-500 group-hover:scale-105">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/55 via-transparent to-black/15 opacity-75 group-hover:opacity-100 transition"></div>
                                        <span class="absolute top-2.5 left-2.5 rounded-full bg-black/55 backdrop-blur-xs px-2.5 py-0.5 text-[10px] font-bold text-white">
                                            #{{ $galeri->urutan }}
                                        </span>
                                        <span class="absolute top-2.5 right-2.5 w-7 h-7 rounded-full bg-white/90 text-charcoal flex items-center justify-center opacity-0 group-hover:opacity-100 transition shadow">
                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <circle cx="11" cy="11" r="8"/>
                                                <path d="m21 21-4.3-4.3"/>
                                                <line x1="11" y1="8" x2="11" y2="14"/>
                                                <line x1="8" y1="11" x2="14" y2="11"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="p-3 flex items-center justify-between gap-2 text-xs bg-white">
                                        <span class="truncate font-medium text-charcoal/85" title="{{ $galeri->keterangan ?: 'Foto #'.$galeri->urutan }}">
                                            {{ $galeri->keterangan ?: 'Foto #'.$galeri->urutan }}
                                        </span>
                                        <form
                                            action="{{ route('dashboard.galeri.hapus', [$undangan, $galeri]) }}"
                                            method="POST"
                                            data-swal-title="Hapus Foto Galeri?"
                                            data-swal-confirm="Yakin ingin menghapus foto ini dari galeri undangan?"
                                            data-swal-icon="warning"
                                            data-swal-confirm-button="Ya, Hapus"
                                            data-swal-confirm-color="#DC2626"
                                            data-swal-loading-title="Menghapus Foto Galeri..."
                                            data-swal-loading-text="Menghapus foto dari penyimpanan galeri..."
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg bg-rose-50 px-2 py-1 text-[11px] font-semibold text-rose-700 hover:bg-rose-100 transition cursor-pointer shrink-0">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Cerita Cinta & Live Streaming --}}
            <div class="rounded-[1.5rem] bg-white p-4 sm:p-7 shadow-xs ring-1 ring-champagne/25">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 sm:pb-5 border-b border-champagne/20">
                    <div>
                        <div class="inline-flex items-center gap-2 rounded-full bg-champagne/15 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-[#8A6D33] mb-2">
                            <span>Linimasa Romantis</span>
                            <span>&bull;</span>
                            <span x-text="daftarCerita.length + ' Bab'"></span>
                        </div>
                        <h2 class="font-sans text-lg sm:text-2xl font-bold text-charcoal tracking-tight">Cerita Cinta &amp; Live Streaming</h2>
                        <p class="mt-1 text-xs sm:text-sm text-charcoal/65">Rangkai babak perjalanan cinta Anda — tampilannya langsung terlihat di pratinjau linimasa.</p>
                    </div>
                    <button type="button" @click="tambahCerita()" class="self-start sm:self-auto inline-flex items-center gap-1.5 rounded-xl bg-sage px-4 py-2 text-xs font-semibold text-white hover:bg-[#3b5047] active:scale-95 transition cursor-pointer shadow-xs shrink-0">
                        <span>+ Tambah Momen Cerita</span>
                    </button>
                </div>

                <form
                    action="{{ route('dashboard.undangan.perbarui', $undangan) }}"
                    method="POST"
                    class="mt-6 space-y-6"
                    data-swal-loading
                    data-swal-loading-title="Menyimpan Cerita Cinta..."
                    data-swal-loading-text="Menyimpan linimasa cerita &amp; pengaturan live streaming..."
                >
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="bagian" value="cerita_streaming">

                    <div class="grid grid-cols-1 gap-5 items-start">
                        {{-- Kolom Kiri: Timeline Editor Bab Cerita --}}
                        <div class="space-y-4">
                            <div class="relative pl-7 sm:pl-9 space-y-4 before:content-[''] before:absolute before:left-3 sm:before:left-3.5 before:top-5 before:bottom-5 before:w-0.5 before:bg-gradient-to-b before:from-sage before:via-champagne before:to-sage/30">
                                <template x-for="(item, idx) in daftarCerita" :key="idx">
                                    <div class="relative rounded-2xl bg-gradient-to-br from-ivory via-white to-champagne/[0.05] p-4 sm:p-5 ring-1 ring-champagne/25 shadow-xs hover:ring-champagne/50 transition space-y-3.5">
                                        {{-- Node Nomor / Hati pada Garis Timeline --}}
                                        <span class="absolute -left-7 sm:-left-9 top-5 w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-sage text-white ring-4 ring-white shadow-xs flex items-center justify-center text-[10px] font-bold" x-text="String(idx + 1).padStart(2, '0')"></span>

                                        <div class="flex items-center justify-between gap-2 pb-2.5 border-b border-champagne/15">
                                            <div class="min-w-0 flex items-center gap-2">
                                                <span class="text-[11px] font-bold uppercase tracking-wider text-champagne" x-text="'Bab ' + String(idx + 1).padStart(2, '0')"></span>
                                                <span class="text-xs font-sans font-semibold text-charcoal truncate" x-text="item.judul ? ('• ' + item.judul) : '• Momen Baru'"></span>
                                            </div>

                                            <div class="flex items-center gap-1 shrink-0">
                                                <button
                                                    type="button"
                                                    x-show="idx > 0"
                                                    @click="pindahCerita(idx, -1)"
                                                    title="Naikkan urutan"
                                                    class="w-7 h-7 rounded-lg bg-white ring-1 ring-charcoal/10 text-charcoal/70 hover:bg-ivory hover:text-sage flex items-center justify-center text-xs font-bold cursor-pointer transition"
                                                >
                                                    &uarr;
                                                </button>
                                                <button
                                                    type="button"
                                                    x-show="idx < daftarCerita.length - 1"
                                                    @click="pindahCerita(idx, 1)"
                                                    title="Turunkan urutan"
                                                    class="w-7 h-7 rounded-lg bg-white ring-1 ring-charcoal/10 text-charcoal/70 hover:bg-ivory hover:text-sage flex items-center justify-center text-xs font-bold cursor-pointer transition"
                                                >
                                                    &darr;
                                                </button>
                                                <button
                                                    type="button"
                                                    x-show="daftarCerita.length > 1"
                                                    @click="hapusCerita(idx)"
                                                    class="ml-1 rounded-lg bg-rose-50 px-2.5 py-1 text-[11px] font-semibold text-rose-700 hover:bg-rose-100 cursor-pointer transition"
                                                >
                                                    Hapus
                                                </button>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                                            <div class="sm:col-span-8">
                                                <label class="block text-[11px] font-semibold uppercase tracking-wider text-charcoal/70">Judul Momen</label>
                                                <input
                                                    type="text"
                                                    :name="`cerita_cinta[${idx}][judul]`"
                                                    x-model="item.judul"
                                                    placeholder="Contoh: Pertama Bertemu"
                                                    class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-sage focus:ring-2 focus:ring-sage/15 focus:outline-none transition"
                                                >
                                            </div>
                                            <div class="sm:col-span-4">
                                                <label class="block text-[11px] font-semibold uppercase tracking-wider text-charcoal/70">Tahun / Waktu</label>
                                                <input
                                                    type="text"
                                                    :name="`cerita_cinta[${idx}][tanggal]`"
                                                    x-model="item.tanggal"
                                                    placeholder="2022 / Okt 2024"
                                                    class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm focus:border-sage focus:ring-2 focus:ring-sage/15 focus:outline-none transition"
                                                >
                                            </div>
                                            <div class="sm:col-span-12">
                                                <div class="flex items-center justify-between">
                                                    <label class="block text-[11px] font-semibold uppercase tracking-wider text-charcoal/70">Kisah Singkat</label>
                                                    <span class="text-[10px] text-charcoal/45" x-text="(item.cerita?.length || 0) + ' karakter'"></span>
                                                </div>
                                                <textarea
                                                    :name="`cerita_cinta[${idx}][cerita]`"
                                                    x-model="item.cerita"
                                                    rows="2"
                                                    placeholder="Ceritakan secara singkat kenangan indah pada momen ini..."
                                                    class="mt-1 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2 text-sm leading-relaxed focus:border-sage focus:ring-2 focus:ring-sage/15 focus:outline-none transition"
                                                ></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            {{-- Tombol Inspirasi Bab Cepat --}}
                            <div class="rounded-2xl bg-ivory/75 p-4 ring-1 ring-champagne/20 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <span class="text-xs font-semibold text-charcoal/75 shrink-0">Inspirasi Bab Cepat:</span>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach ([
                                        ['judul' => 'Pertama Bertemu', 'tanggal' => '2022', 'cerita' => 'Pertemuan sederhana yang berawal dari obrolan hangat dan perlahan menumbuhkan rasa nyaman.'],
                                        ['judul' => 'Mulai Komitmen', 'tanggal' => '2024', 'cerita' => 'Berjalan beriringan, saling menguatkan mimpi, dan memantapkan langkah menuju masa depan.'],
                                        ['judul' => 'Momen Lamaran', 'tanggal' => '2026', 'cerita' => 'Dengan doa dan restu kedua orang tua, kami mengikat janji suci menuju hari pernikahan.'],
                                    ] as $presetCerita)
                                        <button
                                            type="button"
                                            @click="tambahCeritaPreset(@js($presetCerita['judul']), @js($presetCerita['tanggal']), @js($presetCerita['cerita']))"
                                            class="rounded-full bg-white px-3 py-1 text-[11px] font-semibold text-sage ring-1 ring-sage/25 hover:bg-sage hover:text-white transition cursor-pointer"
                                        >
                                            + {{ $presetCerita['judul'] }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Kolom Kanan: Pratinjau Live Tampilan Linimasa di Undangan --}}
                        <aside>
                            <div class="rounded-3xl bg-gradient-to-b from-[#FAF5EA] via-white to-[#F6EFE0] p-5 sm:p-6 ring-1 ring-champagne/35 shadow-sm space-y-5">
                                <div class="flex items-center justify-between border-b border-champagne/25 pb-3.5">
                                    <div>
                                        <p class="text-[10px] font-bold uppercase tracking-[0.28em] text-champagne">Pratinjau Tampilan Tamu</p>
                                        <h3 class="font-logo text-lg font-bold text-charcoal tracking-tight mt-0.5">
                                            Kisah <span x-text="namaPriaLive || @js($undangan->nama_panggilan_pria)"></span>
                                            <span class="text-champagne">&amp;</span>
                                            <span x-text="namaWanitaLive || @js($undangan->nama_panggilan_wanita)"></span>
                                        </h3>
                                    </div>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-sage/10 px-2.5 py-1 text-[10px] font-bold text-sage">
                                        <span class="w-1.5 h-1.5 rounded-full bg-sage animate-pulse"></span>
                                        Live
                                    </span>
                                </div>

                                <div class="relative border-l-2 border-champagne/40 ml-2 pl-5 space-y-5">
                                    <template x-for="(item, idx) in daftarCerita" :key="'prev-' + idx">
                                        <div class="relative">
                                            <span class="absolute -left-[27px] top-1 w-3 h-3 rotate-45 bg-champagne ring-4 ring-[#FAF5EA]"></span>
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span
                                                    x-show="item.tanggal"
                                                    class="inline-block rounded-full bg-champagne/15 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-champagne"
                                                    x-text="item.tanggal"
                                                ></span>
                                            </div>
                                            <h4 class="font-logo text-base font-bold text-charcoal tracking-tight mt-1" x-text="item.judul || 'Judul Momen ' + (idx + 1)"></h4>
                                            <p class="mt-1 text-xs leading-relaxed text-charcoal/70" x-text="item.cerita || 'Deskripsi kisah akan tampil di sini saat Anda mengetik...'"></p>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </aside>
                    </div>

                    {{-- Panel Live Streaming --}}
                    <div class="rounded-2xl bg-gradient-to-br from-ivory via-white to-sage/[0.04] p-4 sm:p-6 ring-1 ring-champagne/25 space-y-4">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-start sm:items-center gap-3 min-w-0">
                                <div class="w-10 h-10 rounded-xl bg-sage/10 text-sage flex items-center justify-center shrink-0">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="m22 8-6 4 6 4V8Z"/>
                                        <rect width="14" height="12" x="2" y="6" rx="2" ry="2"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h3 class="font-sans text-sm sm:text-base font-bold text-charcoal tracking-tight">Fitur Live Streaming Pernikahan</h3>
                                        <span
                                            :class="liveAktifLive ? 'bg-sage/15 text-sage' : 'bg-charcoal/10 text-charcoal/60'"
                                            class="rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase"
                                            x-text="liveAktifLive ? 'Aktif' : 'Nonaktif'"
                                        ></span>
                                    </div>
                                    <p class="text-xs text-charcoal/65 mt-0.5">Sertakan tautan siaran langsung untuk kerabat yang menyaksikan dari jauh.</p>
                                </div>
                            </div>

                            <label class="relative inline-flex items-center cursor-pointer shrink-0" aria-label="Aktifkan Live Streaming">
                                <input type="checkbox" name="live_aktif" value="1" x-model="liveAktifLive" class="sr-only peer">
                                <span class="w-11 h-6 rounded-full bg-charcoal/20 peer-checked:bg-sage peer-focus-visible:ring-2 peer-focus-visible:ring-sage/30 transition-colors after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:h-5 after:w-5 after:rounded-full after:bg-white after:shadow-xs after:transition-transform peer-checked:after:translate-x-5"></span>
                            </label>
                        </div>

                        <div
                            x-show="liveAktifLive"
                            x-cloak
                            x-transition
                            class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-3 border-t border-champagne/20"
                        >
                            <div class="space-y-2">
                                <div class="flex flex-wrap items-center justify-between gap-1.5">
                                    <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal/75">Platform Siaran</label>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach (['YouTube Live', 'Instagram Live', 'Zoom'] as $presetLive)
                                            <button
                                                type="button"
                                                @click="$refs.livePlatformInput.value = @js($presetLive)"
                                                class="rounded-full bg-white px-2 py-0.5 text-[10px] font-semibold text-sage ring-1 ring-sage/25 hover:bg-sage hover:text-white transition cursor-pointer"
                                            >
                                                {{ $presetLive }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                                <input
                                    x-ref="livePlatformInput"
                                    type="text"
                                    name="live_platform"
                                    value="{{ $pengaturan['live_streaming']['platform'] ?? 'Instagram / YouTube' }}"
                                    class="w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2.5 text-sm focus:border-sage focus:outline-none"
                                >
                            </div>
                            <div class="space-y-2">
                                <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal/75">Link Live Streaming</label>
                                <input
                                    type="url"
                                    name="live_link"
                                    value="{{ $pengaturan['live_streaming']['link'] ?? '' }}"
                                    placeholder="https://youtube.com/live/..."
                                    class="w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2.5 text-sm focus:border-sage focus:outline-none"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-sage px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#3b5047] active:scale-[0.98] transition cursor-pointer">
                            <span>Simpan Cerita &amp; Lanjut ke Amplop</span>
                            <span aria-hidden="true">&rarr;</span>
                        </button>
                    </div>
                </form>
            </div>
                    </section>
                </div>

                {{-- ACCORDION 5: Amplop & Kado --}}
                <div
                    :class="tab === 'amplop' ? 'border-sage/45 ring-1 ring-sage/15 shadow-xs' : 'border-champagne/30 hover:border-champagne/60'"
                    class="rounded-2xl border bg-white overflow-hidden transition"
                >
                    <button
                        type="button"
                        data-mobile-tab="amplop"
                        @click="toggleBagian('amplop')"
                        class="w-full px-4 py-3.5 flex items-center justify-between gap-3 text-left cursor-pointer hover:bg-ivory/50 transition"
                    >
                        <div class="flex items-center gap-3 min-w-0">
                            <svg
                                :class="tab === 'amplop' ? 'rotate-90 text-sage' : 'text-charcoal/45'"
                                class="h-4 w-4 shrink-0 transition-transform duration-200"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                            >
                                <path d="m9 18 6-6-6-6"/>
                            </svg>
                            <svg class="h-4 w-4 text-sage shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="3" y="8" width="18" height="4" rx="1"/>
                                <path d="M12 8v13"/>
                                <path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"/>
                                <path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"/>
                            </svg>
                            <span class="font-sans text-sm font-semibold text-charcoal truncate">Amplop &amp; Kado</span>
                        </div>
                        <span class="rounded-full bg-ivory px-2 py-0.5 font-sans tabular-nums text-[11px] font-semibold text-sage ring-1 ring-champagne/25 shrink-0">
                            {{ $undangan->daftarAmplop->count() }} Kartu
                        </span>
                    </button>

                    <section x-show="tab === 'amplop'" x-cloak class="px-4 pb-5 pt-3 border-t border-champagne/20 space-y-5">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between gap-2 pb-2.5 border-b border-champagne/15">
                                <div>
                                    <h2 class="font-sans text-base font-bold text-charcoal tracking-tight">Rekening Bank &amp; E-Wallet Amplop Digital</h2>
                                    <p class="mt-0.5 text-xs text-charcoal/60">Desain kartu otomatis menyesuaikan bank/e-wallet.</p>
                                </div>
                                <span class="rounded-full bg-ivory px-2.5 py-1 text-[11px] font-bold text-sage ring-1 ring-champagne/30 shrink-0">
                                    {{ $undangan->daftarAmplop->count() }} Kartu Tersimpan
                                </span>
                            </div>

                {{-- Form + Pratinjau Kartu ATM Live --}}
                <div class="grid grid-cols-1 gap-4 rounded-2xl bg-ivory/75 p-4 ring-1 ring-champagne/25">
                    <form
                        action="{{ route('dashboard.amplop.simpan', $undangan) }}"
                        method="POST"
                        class="space-y-3.5"
                        data-swal-loading
                        data-swal-loading-title="Menambahkan Kartu Rekening..."
                        data-swal-loading-text="Menyimpan rekening amplop digital ke undangan..."
                    >
                        @csrf
                        <div class="space-y-2">
                            <span class="block text-xs font-semibold uppercase tracking-wider text-charcoal/75">Pilih Cepat Bank / E-Wallet</span>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach (\App\Support\GayaKartuBank::pilihanCepat() as $opsiBank)
                                    @php
                                        $gayaOpsi = \App\Support\GayaKartuBank::untukNamaBank($opsiBank);
                                    @endphp
                                    <button
                                        type="button"
                                        @click="bankBaru = @js($opsiBank)"
                                        :class="bankBaru.toLowerCase() === @js(strtolower($opsiBank)) ? 'bg-sage text-white ring-sage' : 'bg-white text-charcoal ring-champagne/30 hover:bg-ivory'"
                                        class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold ring-1 transition cursor-pointer"
                                    >
                                        <span class="w-2 h-2 rounded-full shrink-0" style="background: {{ $gayaOpsi['gradient_css'] }}"></span>
                                        <span>{{ $opsiBank }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal/75">Nama Bank / E-Wallet</label>
                                <input
                                    type="text"
                                    name="nama_bank"
                                    x-model="bankBaru"
                                    required
                                    placeholder="BCA / Mandiri / GoPay..."
                                    class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2.5 text-sm focus:border-sage focus:ring-2 focus:ring-sage/15 focus:outline-none transition"
                                >
                            </div>
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal/75">Nomor Rekening / HP</label>
                                <input
                                    type="text"
                                    name="nomor_rekening"
                                    x-model="nomorBaru"
                                    required
                                    placeholder="1234567890"
                                    class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2.5 text-sm focus:border-sage focus:ring-2 focus:ring-sage/15 focus:outline-none transition"
                                >
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-end gap-3.5">
                            <div class="flex-1">
                                <label class="block text-xs font-semibold uppercase tracking-wider text-charcoal/75">Atas Nama Pemilik Rekening</label>
                                <input
                                    type="text"
                                    name="atas_nama"
                                    x-model="atasNamaBaru"
                                    required
                                    placeholder="{{ $undangan->nama_lengkap_pria }}"
                                    class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-white px-3.5 py-2.5 text-sm focus:border-sage focus:ring-2 focus:ring-sage/15 focus:outline-none transition"
                                >
                            </div>
                            <button type="submit" class="rounded-xl bg-sage px-6 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 transition cursor-pointer shadow-xs shrink-0">
                                + Tambah Rekening
                            </button>
                        </div>
                    </form>

                    {{-- Pratinjau Kartu Live --}}
                    <div class="space-y-2">
                        <div class="flex items-center justify-between px-1">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-charcoal/60">Pratinjau Kartu Bank Live</span>
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-sage">
                                <span class="w-1.5 h-1.5 rounded-full bg-sage animate-pulse"></span>
                                Otomatis
                            </span>
                        </div>
                        @include('dashboard._kartu-bank-digital', ['modeLive' => true])
                    </div>
                </div>

                {{-- Daftar Kartu ATM / E-Wallet Tersimpan --}}
                @if ($undangan->daftarAmplop->isNotEmpty())
                    <div class="space-y-3 pt-2">
                        <h3 class="font-sans text-base sm:text-lg font-bold text-charcoal tracking-tight">Koleksi Kartu Rekening Tersimpan</h3>
                        <div class="grid grid-cols-1 gap-3.5">
                            @foreach ($undangan->daftarAmplop as $amplop)
                                @include('dashboard._kartu-bank-digital', [
                                    'modeLive' => false,
                                    'amplop' => $amplop,
                                    'undangan' => $undangan,
                                ])
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="rounded-2xl border border-dashed border-champagne/40 bg-ivory/40 p-8 text-center space-y-1.5">
                        <p class="font-sans text-sm sm:text-base font-bold text-charcoal tracking-tight">Belum Ada Kartu Amplop Digital</p>
                        <p class="text-xs text-charcoal/65">Pilih bank/e-wallet dan isi nomor rekening di atas agar tampil sebagai kartu amplop digital di sini.</p>
                    </div>
                @endif
            </div>

            <div class="rounded-[1.5rem] bg-white p-4 sm:p-7 shadow-xs ring-1 ring-champagne/25">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-champagne/15 text-[#8A6D33] flex items-center justify-center shrink-0">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="3" y="8" width="18" height="4" rx="1"/>
                            <path d="M12 8v13"/>
                            <path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"/>
                            <path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-sans text-base sm:text-lg font-bold text-charcoal tracking-tight">Alamat Pengiriman Kado Fisik</h3>
                        <p class="text-xs text-charcoal/65">Opsional — tampil bagi tamu yang ingin mengirimkan bingkisan langsung ke alamat Anda.</p>
                    </div>
                </div>
                <form
                    action="{{ route('dashboard.undangan.perbarui', $undangan) }}"
                    method="POST"
                    class="mt-4 space-y-4"
                    data-swal-loading
                    data-swal-loading-title="Menyimpan Alamat Kado..."
                    data-swal-loading-text="Memperbarui alamat pengiriman kado fisik..."
                >
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="bagian" value="kado_fisik">
                    <textarea name="alamat_kado_fisik" rows="2" placeholder="Jl. Contoh No. 12, Jakarta Selatan..." class="w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm focus:border-sage focus:bg-white focus:outline-none transition">{{ old('alamat_kado_fisik', $pengaturan['alamat_kado_fisik'] ?? '') }}</textarea>
                    <div class="pt-1">
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-sage px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#3b5047] active:scale-[0.98] transition cursor-pointer">
                            <span>Simpan Alamat Kado &amp; Lanjut ke Pembayaran</span>
                            <span aria-hidden="true">&rarr;</span>
                        </button>
                    </div>
                </form>
            </div>
                    </section>
                </div>

                {{-- ACCORDION 6: Pembayaran & Aktivasi --}}
                @php
                    $biayaTerimaBeresNominal = (int) ($biayaTerimaBeres ?? \App\Support\PengaturanSesiTemu::biayaTerimaBeres());
                    $hargaTemaNominal = (int) ($undangan->tema?->hargaNominal() ?? 0);
                    $undanganSudahAktifBayar = $undangan->sudahAktifPublik();
                    $transaksiMenungguBayar = $undangan->transaksiMenungguVerifikasi();
                    $transaksiLunasTerakhir = $undangan->transaksi->firstWhere('status', 'lunas');
                    $transaksiTerakhirSemua = $undangan->transaksi->first();
                    $bolehAjukanBayar = $undangan->bolehAjukanPembayaran();
                    $pesanWaKonfirmasiVerifikasi = $transaksiMenungguBayar
                        ? "Halo Admin SesiTemu, saya sudah mengirim bukti transfer untuk invoice {$transaksiMenungguBayar->kode_invoice} (sesitemu.id/{$undangan->slug}). Mohon dibantu verifikasinya."
                        : $pesanWaAktivasi;
                @endphp
                <div
                    :class="tab === 'aktivasi' ? 'border-sage/45 ring-1 ring-sage/15 shadow-xs' : 'border-champagne/30 hover:border-champagne/60'"
                    class="rounded-2xl border bg-white overflow-hidden transition"
                >
                    <button
                        type="button"
                        data-mobile-tab="aktivasi"
                        @click="toggleBagian('aktivasi')"
                        class="w-full px-4 py-3.5 flex items-center justify-between gap-3 text-left cursor-pointer hover:bg-ivory/50 transition"
                    >
                        <div class="flex items-center gap-3 min-w-0">
                            <svg
                                :class="tab === 'aktivasi' ? 'rotate-90 text-sage' : 'text-charcoal/45'"
                                class="h-4 w-4 shrink-0 transition-transform duration-200"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                            >
                                <path d="m9 18 6-6-6-6"/>
                            </svg>
                            <svg class="h-4 w-4 text-sage shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="20" height="14" x="2" y="5" rx="2"/>
                                <line x1="2" x2="22" y1="10" y2="10"/>
                            </svg>
                            <span class="font-sans text-sm font-semibold text-charcoal truncate">Pembayaran &amp; Aktivasi</span>
                        </div>
                        <span class="rounded-full px-2 py-0.5 text-[10px] font-bold shrink-0 {{ $undanganSudahAktifBayar ? 'bg-emerald-50 text-emerald-700' : ($transaksiMenungguBayar ? 'bg-sky-50 text-sky-700' : 'bg-amber-50 text-amber-800') }}">
                            {{ $undanganSudahAktifBayar ? 'Lunas' : ($transaksiMenungguBayar ? 'Verifikasi' : 'Belum Aktif') }}
                        </span>
                    </button>

                    <section x-show="tab === 'aktivasi'" x-cloak class="px-4 pb-5 pt-3 border-t border-champagne/20 space-y-5">
                        <div class="grid grid-cols-1 gap-4">
                @if ($undanganSudahAktifBayar)
                    <div
                        id="form-aktivasi-pembayaran"
                        class="order-1 rounded-[1.5rem] bg-white p-5 sm:p-7 shadow-xs ring-1 ring-emerald-200/80 flex flex-col justify-between gap-5"
                    >
                        <div class="space-y-4">
                            <div class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-emerald-700 ring-1 ring-emerald-200">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                <span>Lunas &amp; Aktif</span>
                            </div>

                            <div class="flex items-start gap-3.5">
                                <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 ring-1 ring-emerald-200 shrink-0">
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>
                                        <path d="m9 12 2 2 4-4"/>
                                    </svg>
                                </span>
                                <div class="space-y-1">
                                    <h2 class="font-sans text-lg sm:text-xl font-bold text-charcoal tracking-tight">Undangan Sudah Aktif</h2>
                                    <p class="text-xs sm:text-sm text-charcoal/70 leading-relaxed">
                                        Pembayaran telah terverifikasi sehingga pengajuan pembayaran baru dikunci otomatis. Undangan Anda siap disebar ke seluruh tamu.
                                    </p>
                                </div>
                            </div>

                            <div class="rounded-2xl bg-ivory/80 p-4 ring-1 ring-champagne/25 space-y-2 text-xs">
                                @if ($undangan->berlaku_sampai)
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="text-charcoal/65">Masa Aktif Hingga</span>
                                        <span class="font-bold text-sage">{{ $undangan->berlaku_sampai->locale('id')->translatedFormat('d F Y') }}</span>
                                    </div>
                                @endif
                                @if ($transaksiLunasTerakhir)
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="text-charcoal/65">Invoice Terverifikasi</span>
                                        <span class="font-mono font-bold text-charcoal">{{ $transaksiLunasTerakhir->kode_invoice }}</span>
                                    </div>
                                @endif
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-charcoal/65">Link Publik</span>
                                    <span class="font-mono font-semibold text-sage truncate">sesitemu.id/{{ $undangan->slug }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                            <a
                                href="{{ route('dashboard.undangan.tamu', $undangan) }}"
                                class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-sage px-4 py-3 text-xs sm:text-sm font-semibold text-white hover:bg-[#3b5047] active:scale-[0.98] transition"
                            >
                                <span>Buka Halaman Tamu &amp; RSVP</span>
                                <span aria-hidden="true">&rarr;</span>
                            </a>
                            <a
                                href="{{ $urlPublik }}"
                                target="_blank"
                                class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-champagne/50 bg-ivory px-4 py-3 text-xs sm:text-sm font-semibold text-charcoal hover:bg-champagne/10 active:scale-[0.98] transition"
                            >
                                <span>Buka Undangan Publik</span>
                            </a>
                        </div>
                    </div>
                @elseif ($transaksiMenungguBayar)
                    <div
                        id="form-aktivasi-pembayaran"
                        class="order-1 rounded-[1.5rem] bg-white p-5 sm:p-7 shadow-xs ring-1 ring-amber-200/80 flex flex-col justify-between gap-5"
                    >
                        <div class="space-y-4">
                            <div class="inline-flex items-center gap-2 rounded-full bg-amber-50 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-amber-800 ring-1 ring-amber-200">
                                <span class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span>
                                <span>Menunggu Verifikasi Admin</span>
                            </div>

                            <div class="flex items-start gap-3.5">
                                <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-700 ring-1 ring-amber-200 shrink-0">
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                </span>
                                <div class="space-y-1">
                                    <h2 class="font-sans text-lg sm:text-xl font-bold text-charcoal tracking-tight">Bukti Pembayaran Sudah Dikirim</h2>
                                    <p class="text-xs sm:text-sm text-charcoal/70 leading-relaxed">
                                        Pengajuan pembayaran Anda sedang dalam antrean verifikasi Admin. Form unggah bukti dikunci sementara agar tidak terjadi duplikasi invoice.
                                    </p>
                                </div>
                            </div>

                            <div class="rounded-2xl bg-ivory/80 p-4 ring-1 ring-champagne/25 space-y-2 text-xs">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-charcoal/65">Nomor Invoice</span>
                                    <span class="font-mono font-bold text-charcoal">{{ $transaksiMenungguBayar->kode_invoice }}</span>
                                </div>
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-charcoal/65">Paket &amp; Tema</span>
                                    <span class="font-semibold text-charcoal text-right">{{ $transaksiMenungguBayar->labelPaket() }} &bull; {{ $transaksiMenungguBayar->tema?->nama_tema }}</span>
                                </div>
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-charcoal/65">Total Pembayaran</span>
                                    <span class="font-sans tabular-nums font-bold text-sage">{{ \App\Models\Tema::formatRupiah($transaksiMenungguBayar->total_bayar) }}</span>
                                </div>
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-charcoal/65">Waktu Pengajuan</span>
                                    <span class="font-medium text-charcoal/80">{{ $transaksiMenungguBayar->created_at?->locale('id')->translatedFormat('d M Y, H:i') }} WIB</span>
                                </div>
                            </div>

                            <p class="text-[11.5px] text-charcoal/60 leading-relaxed">
                                Jika bukti sebelumnya ditolak Admin karena kurang jelas atau nominal berbeda, formulir unggah bukti akan otomatis terbuka kembali.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                            @if ($transaksiMenungguBayar->urlBukti())
                                <button
                                    type="button"
                                    @click="galeriLightbox = { url: @js($transaksiMenungguBayar->urlBukti()), caption: @js('Bukti Pembayaran — '.$transaksiMenungguBayar->kode_invoice) }"
                                    class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-sage/35 bg-sage/10 px-4 py-3 text-xs sm:text-sm font-semibold text-sage hover:bg-sage hover:text-white active:scale-[0.98] transition cursor-pointer"
                                >
                                    <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    <span>Lihat Bukti Terkirim</span>
                                </button>
                            @endif
                            <a
                                href="{{ \App\Support\PengaturanSesiTemu::urlWaAdmin($pesanWaKonfirmasiVerifikasi) }}"
                                target="_blank"
                                rel="noopener"
                                class="{{ $transaksiMenungguBayar->urlBukti() ? '' : 'sm:col-span-2' }} inline-flex items-center justify-center gap-1.5 rounded-xl bg-champagne px-4 py-3 text-xs sm:text-sm font-semibold text-charcoal hover:bg-champagne/90 active:scale-[0.98] transition"
                            >
                                <span>Konfirmasi ke WA Admin</span>
                            </a>
                        </div>
                    </div>
                @else
                <div
                    id="form-aktivasi-pembayaran"
                    x-data="{
                        paket: @js(old('paket', 'mandiri')),
                        hargaTema: {{ $hargaTemaNominal }},
                        biayaTerimaBeres: {{ $biayaTerimaBeresNominal }},
                        kodePromo: @js((string) old('kode_promo', '')),
                        promoTerapan: null,
                        pesanPromo: '',
                        promoError: false,
                        sedangCekPromo: false,
                        buktiNama: '',
                        buktiUkuran: '',
                        buktiPreviewUrl: null,
                        sedangTarikBukti: false,
                        buktiGalat: '',
                        init() {
                            if (this.kodePromo.trim() !== '') {
                                this.cekPromo(true);
                            }
                        },
                        biayaJasa() {
                            return this.paket === 'terima_beres' ? this.biayaTerimaBeres : 0;
                        },
                        subtotal() {
                            return this.hargaTema + this.biayaJasa();
                        },
                        potonganPromo() {
                            return this.promoTerapan ? Number(this.promoTerapan.potongan_promo || 0) : 0;
                        },
                        totalBayar() {
                            return this.promoTerapan ? Number(this.promoTerapan.total_bayar || 0) : this.subtotal();
                        },
                        perluBukti() {
                            return this.totalBayar() > 0;
                        },
                        formatRp(nilai) {
                            return 'Rp ' + Number(nilai || 0).toLocaleString('id-ID');
                        },
                        ubahKodePromo() {
                            if (this.promoTerapan && this.kodePromo.trim().toUpperCase() !== (this.promoTerapan.kode || '')) {
                                this.promoTerapan = null;
                                this.pesanPromo = '';
                                this.promoError = false;
                            }
                        },
                        async paketBerubah() {
                            if (this.promoTerapan?.kode) {
                                await this.cekPromo(true);
                            }
                        },
                        async cekPromo(otomatis = false) {
                            const kode = this.kodePromo.trim();
                            if (kode === '') {
                                this.promoTerapan = null;
                                this.promoError = !otomatis;
                                this.pesanPromo = otomatis ? '' : 'Masukkan kode voucher terlebih dahulu.';
                                return;
                            }

                            this.sedangCekPromo = true;
                            this.promoError = false;
                            this.pesanPromo = '';

                            try {
                                const token = this.$el.querySelector('input[name=_token]')?.value
                                    || document.querySelector('meta[name=csrf-token]')?.content
                                    || '';

                                const respon = await fetch(@js(route('dashboard.transaksi.cek-promo', $undangan)), {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json',
                                        'X-CSRF-TOKEN': token,
                                    },
                                    body: JSON.stringify({
                                        paket: this.paket,
                                        kode_promo: kode,
                                    }),
                                });

                                const data = await respon.json();
                                if (!respon.ok || !data.valid) {
                                    this.promoTerapan = null;
                                    this.promoError = true;
                                    this.pesanPromo = data.pesan || 'Kode promo tidak valid atau sudah tidak berlaku.';
                                    return;
                                }

                                this.promoTerapan = data;
                                this.kodePromo = data.kode || kode.toUpperCase();
                                this.promoError = false;
                                this.pesanPromo = data.pesan || 'Voucher berhasil diterapkan.';
                            } catch (_) {
                                this.promoTerapan = null;
                                this.promoError = true;
                                this.pesanPromo = 'Gagal memeriksa kode promo. Silakan coba lagi.';
                            } finally {
                                this.sedangCekPromo = false;
                            }
                        },
                        hapusPromo() {
                            this.kodePromo = '';
                            this.promoTerapan = null;
                            this.pesanPromo = '';
                            this.promoError = false;
                        },
                        terimaFileBukti(file) {
                            this.buktiGalat = '';
                            if (!file) {
                                this.resetBukti();
                                return false;
                            }

                            if (!file.type || !file.type.startsWith('image/')) {
                                this.resetBukti();
                                this.buktiGalat = 'Format file harus berupa gambar (JPG, PNG, atau WebP).';
                                return false;
                            }

                            if (file.size > 4 * 1024 * 1024) {
                                this.resetBukti();
                                this.buktiGalat = 'Ukuran foto bukti melebihi batas maksimal 4 MB.';
                                return false;
                            }

                            if (this.buktiPreviewUrl) {
                                URL.revokeObjectURL(this.buktiPreviewUrl);
                            }

                            this.buktiNama = file.name;
                            this.buktiUkuran = file.size >= 1048576
                                ? (file.size / 1048576).toFixed(2) + ' MB'
                                : Math.max(1, Math.round(file.size / 1024)) + ' KB';
                            this.buktiPreviewUrl = URL.createObjectURL(file);
                            return true;
                        },
                        pilihBukti(event) {
                            const file = event.target.files?.[0];
                            if (!this.terimaFileBukti(file) && event.target) {
                                event.target.value = '';
                            }
                        },
                        saatJatuhBukti(event) {
                            this.sedangTarikBukti = false;
                            const file = event.dataTransfer?.files?.[0];
                            if (!file || !this.$refs.inputBukti) return;

                            if (!this.terimaFileBukti(file)) {
                                return;
                            }

                            const dt = new DataTransfer();
                            dt.items.add(file);
                            this.$refs.inputBukti.files = dt.files;
                        },
                        resetBukti() {
                            if (this.buktiPreviewUrl) {
                                URL.revokeObjectURL(this.buktiPreviewUrl);
                            }
                            this.buktiNama = '';
                            this.buktiUkuran = '';
                            this.buktiPreviewUrl = null;
                            if (this.$refs.inputBukti) {
                                this.$refs.inputBukti.value = '';
                            }
                        }
                    }"
                    class="order-2 lg:order-1 rounded-[1.5rem] bg-white p-4 sm:p-7 shadow-xs ring-1 ring-champagne/25 flex flex-col"
                >
                    <div class="inline-flex self-start items-center gap-2 rounded-full bg-sage/10 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-sage mb-2">
                        <span>Langkah 6 dari 6</span>
                        <span>&bull;</span>
                        <span>Aktivasi</span>
                    </div>
                    <h2 class="font-sans text-lg sm:text-2xl font-bold text-charcoal tracking-tight">Ajukan Pembayaran Aktivasi</h2>
                    <p class="mt-1 text-xs sm:text-sm text-charcoal/65">
                        Masa aktif standar undangan adalah <strong>{{ $durasiAktifBulan ?? 3 }} bulan</strong> sejak diverifikasi lunas oleh Admin.
                    </p>

                    @if ($transaksiTerakhirSemua?->status === 'ditolak')
                        <div class="mt-4 rounded-xl border border-rose-200 bg-rose-50/75 px-3.5 py-2.5 text-xs text-rose-700 leading-relaxed">
                            <p class="font-bold">Pengajuan sebelumnya ({{ $transaksiTerakhirSemua->kode_invoice }}) ditolak Admin.</p>
                            @if ($transaksiTerakhirSemua->catatan_admin)
                                <p class="mt-0.5">Catatan: {{ $transaksiTerakhirSemua->catatan_admin }}</p>
                            @endif
                            <p class="mt-0.5 text-rose-600/90">Silakan periksa kembali nominal dan unggah ulang bukti transfer di bawah ini.</p>
                        </div>
                    @endif

                    <form
                        action="{{ route('dashboard.transaksi.ajukan', $undangan) }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="mt-5 flex-1 flex flex-col justify-between gap-4"
                        @submit="if (perluBukti() && !buktiPreviewUrl) { $event.preventDefault(); buktiGalat = 'Silakan pilih atau seret foto/screenshot bukti transfer terlebih dahulu.'; $el.querySelector('[data-zona-bukti]')?.scrollIntoView({ behavior: 'smooth', block: 'center' }); }"
                        data-swal-loading
                        :data-swal-loading-title="perluBukti() ? 'Mengirim Bukti Pembayaran...' : 'Mengajukan Aktivasi...'"
                        :data-swal-loading-text="perluBukti() ? 'Mengunggah bukti transfer &amp; membuat invoice aktivasi...' : 'Memproses pengajuan voucher aktivasi Anda...'"
                    >
                        @csrf
                        <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-charcoal">Paket Layanan</label>
                            <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <label
                                    :class="paket === 'mandiri' ? 'border-sage ring-2 ring-sage/20 bg-sage/5' : 'border-champagne/35 bg-ivory/60 hover:bg-ivory'"
                                    class="flex items-start gap-2.5 rounded-2xl border p-3.5 cursor-pointer transition"
                                >
                                    <input type="radio" name="paket" value="mandiri" x-model="paket" @change="paketBerubah()" class="mt-1 text-sage accent-[#4B6358]">
                                    <span class="text-xs space-y-0.5">
                                        <span class="block font-bold text-charcoal">Paket Mandiri</span>
                                        <span class="block text-[11px] text-charcoal/55">Isi &amp; atur sendiri lewat editor</span>
                                        @if ($undangan->tema?->adaDiskon())
                                            <span class="inline-block pt-0.5 font-sans tabular-nums text-charcoal/45 line-through mr-1">{{ $undangan->tema->hargaAsliFormatted() }}</span>
                                            <span class="inline-block pt-0.5 font-sans tabular-nums font-bold text-rose-600">{{ $undangan->tema->hargaFormatted() }}</span>
                                        @else
                                            <span class="inline-block pt-0.5 font-sans tabular-nums font-bold text-sage">{{ $undangan->tema?->hargaFormatted() }}</span>
                                        @endif
                                    </span>
                                </label>
                                <label
                                    :class="paket === 'terima_beres' ? 'border-sage ring-2 ring-sage/20 bg-sage/5' : 'border-champagne/35 bg-ivory/60 hover:bg-ivory'"
                                    class="flex items-start gap-2.5 rounded-2xl border p-3.5 cursor-pointer transition"
                                >
                                    <input type="radio" name="paket" value="terima_beres" x-model="paket" @change="paketBerubah()" class="mt-1 text-sage accent-[#4B6358]">
                                    <span class="text-xs space-y-0.5">
                                        <span class="block font-bold text-charcoal">Paket Terima Beres</span>
                                        <span class="block text-[11px] text-charcoal/55">Kirim data via WA, Admin isikan</span>
                                        <span class="inline-block pt-0.5 font-sans tabular-nums font-bold text-sage">{{ $undangan->tema?->hargaTerimaBeresFormatted() }}</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label for="kode_promo" class="block text-sm font-medium text-charcoal">Kode Promo / Voucher (Opsional)</label>
                            <div class="mt-1.5 flex items-stretch gap-2">
                                <input
                                    id="kode_promo"
                                    type="text"
                                    name="kode_promo"
                                    x-model="kodePromo"
                                    @input="ubahKodePromo()"
                                    @keydown.enter.prevent="cekPromo()"
                                    placeholder="Masukkan kode voucher bila ada"
                                    class="flex-1 min-w-0 rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm uppercase font-mono focus:border-champagne focus:outline-none"
                                >
                                <button
                                    type="button"
                                    @click="cekPromo()"
                                    :disabled="sedangCekPromo"
                                    class="shrink-0 rounded-xl border border-sage bg-sage/10 px-4 py-2.5 text-xs font-semibold text-sage hover:bg-sage hover:text-white disabled:opacity-60 transition cursor-pointer"
                                    x-text="sedangCekPromo ? 'Mengecek...' : 'Cek Promo'"
                                ></button>
                            </div>

                            <div
                                x-show="pesanPromo"
                                x-cloak
                                :class="promoError ? 'text-rose-600' : 'text-emerald-700'"
                                class="mt-1.5 flex items-center justify-between gap-2 text-xs font-medium"
                            >
                                <span x-text="pesanPromo"></span>
                                <button
                                    type="button"
                                    x-show="promoTerapan"
                                    @click="hapusPromo()"
                                    class="shrink-0 font-semibold text-charcoal/60 hover:text-rose-600 underline cursor-pointer"
                                >
                                    Hapus
                                </button>
                            </div>

                            @error('kode_promo')
                                <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Ringkasan Rincian Biaya Live --}}
                        <div class="rounded-xl border border-champagne/35 bg-ivory/80 p-4 space-y-2 text-xs">
                            <div class="flex items-center justify-between text-charcoal/75">
                                <span>Harga Tema</span>
                                <span class="font-semibold text-charcoal" x-text="formatRp(hargaTema)"></span>
                            </div>
                            <div x-show="biayaJasa() > 0" x-cloak class="flex items-center justify-between text-charcoal/75">
                                <span>Jasa Terima Beres</span>
                                <span class="font-semibold text-charcoal">+ <span x-text="formatRp(biayaJasa())"></span></span>
                            </div>
                            <div x-show="potonganPromo() > 0" x-cloak class="flex items-center justify-between text-emerald-700">
                                <span>
                                    Potongan Voucher
                                    <span x-show="promoTerapan?.kode" class="font-mono font-semibold" x-text="'(' + promoTerapan?.kode + ')'"></span>
                                </span>
                                <span class="font-semibold">- <span x-text="formatRp(potonganPromo())"></span></span>
                            </div>
                            <div class="pt-2 border-t border-champagne/25 flex items-center justify-between">
                                <span class="font-bold text-charcoal text-xs sm:text-sm">Total yang Harus Ditransfer</span>
                                <span
                                    class="font-sans tabular-nums text-lg font-bold tracking-tight text-sage"
                                    x-text="totalBayar() === 0 ? 'Rp 0 (Gratis)' : formatRp(totalBayar())"
                                ></span>
                            </div>
                        </div>

                        <div data-zona-bukti>
                            <div class="flex items-center justify-between gap-2">
                                <label for="bukti_pembayaran" class="block text-sm font-medium text-charcoal">
                                    Unggah Bukti Transfer
                                    <span x-show="perluBukti()" class="text-rose-600">*</span>
                                </label>
                                <span
                                    x-show="perluBukti()"
                                    class="rounded-full bg-rose-50 px-2.5 py-0.5 text-[11px] font-semibold text-rose-700"
                                >
                                    Wajib
                                </span>
                                <span
                                    x-show="!perluBukti()"
                                    x-cloak
                                    class="rounded-full bg-emerald-50 px-2.5 py-0.5 text-[11px] font-semibold text-emerald-700"
                                >
                                    Tidak Diperlukan (Rp 0)
                                </span>
                            </div>

                            <input
                                id="bukti_pembayaran"
                                x-ref="inputBukti"
                                type="file"
                                name="bukti_pembayaran"
                                accept="image/jpeg,image/png,image/webp,image/*"
                                :disabled="!perluBukti()"
                                @change="pilihBukti($event)"
                                class="sr-only"
                            >

                            <div x-show="perluBukti()" class="mt-2 space-y-2">
                                {{-- Keadaan Belum Ada File: Dropzone Elegan --}}
                                <label
                                    for="bukti_pembayaran"
                                    x-show="!buktiPreviewUrl"
                                    @dragover.prevent="sedangTarikBukti = true"
                                    @dragleave.prevent="sedangTarikBukti = false"
                                    @drop.prevent="saatJatuhBukti($event)"
                                    :class="sedangTarikBukti
                                        ? 'border-sage bg-sage/10 scale-[1.01]'
                                        : (buktiGalat ? 'border-rose-400 bg-rose-50/60' : 'border-champagne/60 bg-ivory/75 hover:border-sage/70 hover:bg-ivory')"
                                    class="group relative flex flex-col items-center justify-center text-center rounded-2xl border-2 border-dashed px-5 py-6 cursor-pointer transition-all"
                                >
                                    <div class="w-12 h-12 rounded-2xl bg-white shadow-xs ring-1 ring-champagne/35 text-sage flex items-center justify-center group-hover:scale-105 group-hover:bg-sage group-hover:text-white transition">
                                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"/>
                                            <path d="M12 15V8"/>
                                            <path d="m9 11 3-3 3 3"/>
                                        </svg>
                                    </div>
                                    <p class="mt-3 text-sm font-semibold text-charcoal">
                                        Pilih atau Seret Foto Bukti Transfer
                                    </p>
                                    <p class="mt-1 text-xs text-charcoal/60 max-w-sm leading-relaxed">
                                        Screenshot m-Banking, ATM, e-Wallet, atau QRIS • JPG/PNG/WebP maks. 4 MB
                                    </p>
                                    <span class="mt-3 inline-flex items-center gap-1.5 rounded-xl bg-white px-4 py-1.5 text-xs font-semibold text-sage ring-1 ring-sage/25 shadow-2xs group-hover:bg-sage group-hover:text-white transition">
                                        Pilih dari Perangkat
                                    </span>
                                </label>

                                {{-- Keadaan Sudah Ada File: Kartu Pratinjau Bukti --}}
                                <div
                                    x-show="buktiPreviewUrl"
                                    x-cloak
                                    class="rounded-2xl border border-sage/35 bg-gradient-to-br from-white via-ivory/60 to-sage/5 p-3.5 shadow-xs flex items-center gap-3.5"
                                >
                                    <button
                                        type="button"
                                        @click="galeriLightbox = { url: buktiPreviewUrl, caption: 'Bukti Transfer — ' + buktiNama }"
                                        title="Klik untuk memperbesar bukti transfer"
                                        class="group relative w-20 h-24 rounded-xl overflow-hidden border border-champagne/40 bg-charcoal shrink-0 cursor-pointer shadow-xs"
                                    >
                                        <img :src="buktiPreviewUrl" alt="Pratinjau Bukti Transfer" class="w-full h-full object-cover transition duration-300 group-hover:scale-105">
                                        <span class="absolute inset-0 bg-black/35 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-[10px] font-semibold text-white">
                                            Perbesar
                                        </span>
                                    </button>

                                    <div class="flex-1 min-w-0 space-y-1.5">
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-emerald-800">
                                            <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <polyline points="20 6 9 17 4 12"/>
                                            </svg>
                                            Bukti Siap Dikirim
                                        </span>
                                        <p class="text-xs font-semibold text-charcoal truncate" x-text="buktiNama"></p>
                                        <p class="text-[11px] text-charcoal/60" x-text="buktiUkuran + ' • Klik gambar untuk perbesar'"></p>

                                        <div class="pt-1 flex flex-wrap items-center gap-2">
                                            <label
                                                for="bukti_pembayaran"
                                                class="inline-flex items-center rounded-lg border border-champagne bg-white px-2.5 py-1 text-[11px] font-semibold text-charcoal hover:bg-champagne/10 cursor-pointer transition"
                                            >
                                                Ganti Foto
                                            </label>
                                            <button
                                                type="button"
                                                @click="resetBukti()"
                                                class="inline-flex items-center rounded-lg border border-rose-200 bg-rose-50 px-2.5 py-1 text-[11px] font-semibold text-rose-700 hover:bg-rose-100 cursor-pointer transition"
                                            >
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                x-show="!perluBukti()"
                                x-cloak
                                class="mt-2 rounded-xl border border-emerald-200 bg-emerald-50/80 px-4 py-3 text-xs text-emerald-800"
                            >
                                Total tagihan Anda <strong>Rp 0</strong> setelah diskon voucher. Anda dapat langsung menekan tombol ajukan di bawah tanpa bukti transfer.
                            </div>

                            <p x-show="buktiGalat" x-cloak x-text="buktiGalat" class="mt-1.5 text-xs font-medium text-rose-600"></p>
                            @error('bukti_pembayaran')
                                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                        </div>

                        <button type="submit" class="w-full rounded-xl bg-sage px-5 py-3 text-sm font-semibold text-white hover:bg-sage/90 cursor-pointer transition">
                            <span x-text="perluBukti() ? 'Kirim Bukti & Ajukan Aktivasi' : 'Ajukan Aktivasi Gratis (Rp 0)'">Kirim Bukti &amp; Ajukan Aktivasi</span>
                        </button>
                    </form>
                </div>
                @endif

                <div
                    x-data="{ salinRek: false, salinSlug: false }"
                    class="{{ $bolehAjukanBayar ? 'order-1 lg:order-2' : 'order-2 lg:order-2' }} rounded-[1.5rem] bg-white p-4 sm:p-7 shadow-xs ring-1 ring-champagne/25 flex flex-col justify-between gap-4"
                >
                    <div class="space-y-4">
                        <div class="flex flex-wrap items-start justify-between gap-2">
                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-[0.22em] text-[#8A6D33]">Tujuan Pembayaran Resmi</p>
                                <h3 class="mt-0.5 font-sans text-lg sm:text-xl font-bold text-charcoal tracking-tight">Transfer ke Rekening Resmi</h3>
                            </div>
                            <span class="inline-flex items-center gap-1 rounded-full bg-sage/10 px-3 py-1 text-[11px] font-semibold text-sage ring-1 ring-sage/25">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/>
                                    <path d="m9 12 2 2 4-4"/>
                                </svg>
                                Terverifikasi SesiTemu
                            </span>
                        </div>

                        {{-- Kartu Bank Bergaya ATM Proporsional Sesuai Konfigurasi Bank Resmi --}}
                        <div class="rounded-2xl bg-ivory/80 px-4 py-3.5 ring-1 ring-champagne/25">
                            <div class="max-w-[330px] mx-auto w-full">
                                @include('dashboard._kartu-bank-digital', [
                                    'tanpaHapus' => true,
                                    'namaBank' => $infoRekening['bank'],
                                    'nomorRekening' => $infoRekening['rekening'],
                                    'atasNama' => $infoRekening['atas_nama'],
                                ])
                            </div>
                        </div>

                        {{-- Tombol Salin Cepat No. Rekening & Berita Acara --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                            <div class="rounded-xl border border-champagne/30 bg-ivory/75 p-2.5 flex items-center justify-between gap-2">
                                <div class="min-w-0">
                                    <p class="text-[10px] font-semibold uppercase tracking-wider text-charcoal/55">No. Rekening</p>
                                    <p class="font-mono text-xs sm:text-sm font-bold text-charcoal truncate">{{ $infoRekening['rekening'] }}</p>
                                </div>
                                <button
                                    type="button"
                                    @click="navigator.clipboard?.writeText(@js($infoRekening['rekening'])); salinRek = true; setTimeout(() => salinRek = false, 2000)"
                                    class="shrink-0 rounded-lg border border-champagne bg-white px-2.5 py-1 text-[11px] font-semibold text-charcoal hover:bg-champagne/10 cursor-pointer transition"
                                    x-text="salinRek ? 'Tersalin!' : 'Salin'"
                                ></button>
                            </div>

                            <div class="rounded-xl border border-champagne/30 bg-ivory/75 p-2.5 flex items-center justify-between gap-2">
                                <div class="min-w-0">
                                    <p class="text-[10px] font-semibold uppercase tracking-wider text-charcoal/55">Berita Acara (Slug)</p>
                                    <p class="font-mono text-xs sm:text-sm font-bold text-sage truncate">{{ $undangan->slug }}</p>
                                </div>
                                <button
                                    type="button"
                                    @click="navigator.clipboard?.writeText(@js($undangan->slug)); salinSlug = true; setTimeout(() => salinSlug = false, 2000)"
                                    class="shrink-0 rounded-lg border border-champagne bg-white px-2.5 py-1 text-[11px] font-semibold text-charcoal hover:bg-champagne/10 cursor-pointer transition"
                                    x-text="salinSlug ? 'Tersalin!' : 'Salin'"
                                ></button>
                            </div>
                        </div>

                        {{-- Alur Singkat & Catatan Transfer --}}
                        <div class="rounded-xl bg-ivory/70 border border-champagne/25 p-3.5 space-y-2">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <p class="text-xs font-bold text-charcoal">Langkah Cepat Aktivasi:</p>
                                @if ($undangan->tema)
                                    <span class="lg:hidden text-[11px] font-medium text-charcoal/70">
                                        Mandiri <strong class="text-sage">{{ $undangan->tema->hargaFormatted() }}</strong> • Terima Beres <strong class="text-sage">{{ $undangan->tema->hargaTerimaBeresFormatted() }}</strong>
                                    </span>
                                @endif
                            </div>
                            <ol class="space-y-1 text-xs text-charcoal/75 leading-snug">
                                <li class="flex items-start gap-2">
                                    <span class="mt-0.5 inline-flex h-4 w-4 shrink-0 items-center justify-center rounded-full bg-sage text-[10px] font-bold text-white">1</span>
                                    <span>Transfer sesuai total tagihan <span class="lg:hidden">di form bawah</span><span class="hidden lg:inline">di sebelah kiri</span> ke <strong>{{ $infoRekening['bank'] }}</strong> a.n. <strong>{{ $infoRekening['atas_nama'] }}</strong>.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="mt-0.5 inline-flex h-4 w-4 shrink-0 items-center justify-center rounded-full bg-sage text-[10px] font-bold text-white">2</span>
                                    <span>Cantumkan slug <span class="font-mono font-semibold text-sage">{{ $undangan->slug }}</span> di berita acara / catatan transfer.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="mt-0.5 inline-flex h-4 w-4 shrink-0 items-center justify-center rounded-full bg-sage text-[10px] font-bold text-white">3</span>
                                    <span>Unggah foto bukti transfer <span class="lg:hidden">pada form di bawah</span><span class="hidden lg:inline">di sebelah kiri</span> lalu klik ajukan — Admin segera memverifikasi.</span>
                                </li>
                            </ol>
                            @if (!empty($infoRekening['catatan']))
                                <p class="pt-1.5 border-t border-champagne/20 text-[11px] text-charcoal/65 leading-relaxed">
                                    {{ $infoRekening['catatan'] }}
                                </p>
                            @endif

                            @if ($bolehAjukanBayar)
                                <a
                                    href="#form-aktivasi-pembayaran"
                                    class="lg:hidden mt-1 inline-flex w-full items-center justify-center gap-1.5 rounded-lg bg-sage/10 px-3 py-2 text-xs font-semibold text-sage hover:bg-sage hover:text-white transition"
                                >
                                    Sudah Transfer? Lanjut Unggah Bukti &darr;
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Panel Bantuan & Konfirmasi WhatsApp Admin --}}
                    <div class="pt-3 border-t border-champagne/20 space-y-2">
                        <div class="flex items-center justify-between gap-2 text-xs">
                            <span class="font-medium text-charcoal/70">Butuh bantuan verifikasi lebih cepat?</span>
                            <span class="text-[11px] font-semibold text-sage">WhatsApp Admin</span>
                        </div>
                        <a
                            href="{{ \App\Support\PengaturanSesiTemu::urlWaAdmin($pesanWaAktivasi) }}"
                            target="_blank"
                            rel="noopener"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-champagne px-5 py-3 text-sm font-semibold text-charcoal hover:bg-champagne/90 transition"
                        >
                            <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                            </svg>
                            Konfirmasi Pembayaran via WhatsApp Admin
                        </a>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl bg-ivory/60 p-4 ring-1 ring-champagne/25">
                <h3 class="font-sans text-sm font-bold text-charcoal tracking-tight mb-3">Riwayat Invoice Undangan Ini</h3>

                <div class="space-y-2.5">
                    @forelse ($undangan->transaksi as $trx)
                        <div class="rounded-xl bg-white p-3.5 ring-1 ring-champagne/20 space-y-2">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <p class="font-mono font-bold text-xs text-charcoal">{{ $trx->kode_invoice }}</p>
                                    <p class="text-[11px] text-charcoal/65 truncate">{{ $trx->labelPaket() }} &bull; {{ $trx->tema?->nama_tema }}</p>
                                </div>
                                <span class="rounded-full px-2 py-0.5 text-[10px] font-semibold shrink-0 {{ $trx->status === 'lunas' ? 'bg-sage/15 text-sage' : ($trx->status === 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-800') }}">
                                    {{ $trx->labelStatus() }}
                                </span>
                            </div>
                            <p class="font-sans tabular-nums text-sm font-bold text-charcoal">{{ \App\Models\Tema::formatRupiah($trx->total_bayar) }}</p>
                            @if ($trx->catatan_admin)
                                <p class="text-[11px] text-charcoal/65">{{ $trx->catatan_admin }}</p>
                            @endif
                            <div class="pt-0.5">
                                @include('dashboard._aksi-bukti-invoice', ['trx' => $trx, 'mode' => 'mobile'])
                            </div>
                        </div>
                    @empty
                        <p class="py-4 text-center text-xs text-charcoal/60">Belum ada invoice pembayaran untuk undangan ini.</p>
                    @endforelse
                </div>
            </div>
                    </section>
                </div>

                {{-- Aksi Hapus Draft (Khusus Undangan Belum Aktif / Belum Diverifikasi) --}}
                @if ($undangan->bolehDihapusClient())
                    <form
                        action="{{ route('dashboard.undangan.hapus', $undangan) }}"
                        method="POST"
                        data-swal-confirm="Yakin ingin menghapus draft undangan sesitemu.id/{{ $undangan->slug }}? Seluruh data, acara, dan foto draft ini akan dihapus permanen."
                        data-swal-title="Hapus Draft Undangan?"
                        data-swal-icon="warning"
                        data-swal-confirm-button="Ya, Hapus Draft"
                        data-swal-confirm-color="#DC2626"
                        data-swal-loading-title="Menghapus Draft..."
                        data-swal-loading-text="Sedang menghapus draft undangan dan berkas terkait..."
                    >
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="w-full rounded-2xl border border-red-200/90 bg-red-50/40 px-4 py-3.5 flex items-center justify-between gap-3 text-left text-red-600 hover:bg-red-50 hover:border-red-300 active:scale-[0.99] transition cursor-pointer"
                        >
                            <span class="flex items-center gap-3">
                                <svg class="h-4 w-4 shrink-0 opacity-70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="m9 18 6-6-6-6"/>
                                </svg>
                                <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M3 6h18"/>
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                    <line x1="10" x2="10" y1="11" y2="17"/>
                                    <line x1="14" x2="14" y1="11" y2="17"/>
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

    {{-- 3. Panel Kanan: Kanvas Live Preview Interaktif (Desktop >= lg) --}}
    <div class="hidden lg:flex flex-1 flex-col h-screen bg-[#F2F1EC] overflow-hidden min-w-0">
        {{-- Toolbar Atas Kanvas Preview --}}
        <div class="px-5 py-3.5 flex items-center justify-between gap-3 shrink-0">
            {{-- Pill Tema Aktif + Ganti Tema --}}
            <div class="inline-flex items-center gap-2 rounded-full bg-white pl-3.5 pr-1.5 py-1.5 shadow-xs ring-1 ring-champagne/30 min-w-0 max-w-[60%]">
                <svg class="h-4 w-4 text-sage shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/>
                    <circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/>
                    <circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/>
                    <circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/>
                    <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/>
                </svg>
                <span class="text-xs font-semibold text-charcoal truncate">{{ $temaAktifEditor?->nama_tema ?? 'Rustic Floral' }}</span>
                @if ($bolehGantiTema)
                    <button
                        type="button"
                        @click="bukaDrawerTema()"
                        data-buka-drawer-tema
                        class="rounded-full bg-[#3B4F45] px-3 py-1 text-[11px] font-semibold text-white hover:bg-sage active:scale-95 transition cursor-pointer shrink-0 whitespace-nowrap"
                    >
                        Ganti Tema
                    </button>
                @else
                    <span
                        title="{{ $alasanTemaTerkunci }}"
                        data-tema-terkunci-badge
                        class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-1 text-[11px] font-semibold text-amber-700 ring-1 ring-amber-200 shrink-0 whitespace-nowrap"
                    >
                        <svg class="h-3 w-3 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <span>{{ $sedangVerifikasiEditor ? 'Verifikasi' : 'Terkunci' }}</span>
                    </span>
                @endif
            </div>

            {{-- Kontrol Kanan: Refresh, Buka Tab Baru, Toggle Desktop/Mobile --}}
            <div class="flex items-center gap-2">
                <button
                    type="button"
                    @click="muatUlangPreview()"
                    title="Muat ulang pratinjau"
                    aria-label="Muat ulang pratinjau"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white text-charcoal/70 shadow-xs ring-1 ring-champagne/30 hover:text-sage active:scale-95 transition cursor-pointer"
                >
                    <svg
                        :class="previewMemuat ? 'animate-spin text-sage' : ''"
                        class="h-4 w-4"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
                    >
                        <path d="M21 12a9 9 0 1 1-2.64-6.36L21 8"/>
                        <path d="M21 3v5h-5"/>
                    </svg>
                </button>

                <a
                    href="{{ $urlPublik }}"
                    target="_blank"
                    title="Buka undangan di tab baru"
                    aria-label="Buka undangan di tab baru"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white text-charcoal/70 shadow-xs ring-1 ring-champagne/30 hover:text-sage active:scale-95 transition"
                >
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M15 3h6v6"/>
                        <path d="M10 14 21 3"/>
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                    </svg>
                </a>

                {{-- Toggle Mode Desktop vs Mobile --}}
                <div
                    role="group"
                    aria-label="Ubah ukuran pratinjau"
                    class="inline-flex items-center gap-1 rounded-full bg-white p-1 shadow-xs ring-1 ring-champagne/30"
                >
                    <button
                        type="button"
                        @click="ubahModePreview('desktop')"
                        title="Tampilan Desktop"
                        aria-label="Tampilan Desktop"
                        :class="modePreview === 'desktop' ? 'bg-[#3B4F45] text-white shadow-xs' : 'text-charcoal/60 hover:text-charcoal'"
                        class="inline-flex h-7 w-8 items-center justify-center rounded-full transition cursor-pointer"
                    >
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect width="20" height="14" x="2" y="3" rx="2"/>
                            <line x1="8" x2="16" y1="21" y2="21"/>
                            <line x1="12" x2="12" y1="17" y2="21"/>
                        </svg>
                    </button>
                    <button
                        type="button"
                        @click="ubahModePreview('mobile')"
                        title="Tampilan HP"
                        aria-label="Tampilan HP"
                        :class="modePreview === 'mobile' ? 'bg-[#3B4F45] text-white shadow-xs' : 'text-charcoal/60 hover:text-charcoal'"
                        class="inline-flex h-7 w-8 items-center justify-center rounded-full transition cursor-pointer"
                    >
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect width="14" height="20" x="5" y="2" rx="2" ry="2"/>
                            <path d="M12 18h.01"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Stage Pratinjau Iframe Langsung (Skala Proporsional Tahan Zoom Browser) --}}
        <div x-ref="stagePreview" class="flex-1 min-h-0 flex items-center justify-center p-4 overflow-hidden">
            <div
                :style="`width: ${Math.round(previewVirtualW() * previewScale)}px; height: ${Math.round(previewVirtualH() * previewScale)}px;`"
                :class="modePreview === 'mobile' ? 'rounded-[1.85rem]' : 'rounded-2xl'"
                class="relative bg-white shadow-[0_24px_56px_-16px_rgba(31,41,55,0.22)] ring-1 ring-charcoal/12 overflow-hidden shrink-0"
            >
                <div
                    x-show="previewMemuat"
                    class="absolute inset-0 z-10 bg-ivory/90 flex flex-col items-center justify-center gap-2 text-charcoal/60"
                >
                    <svg class="h-6 w-6 animate-spin text-sage" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <circle cx="12" cy="12" r="10" class="opacity-20"/>
                        <path d="M22 12a10 10 0 0 0-10-10"/>
                    </svg>
                    <span class="text-xs font-medium">Memuat pratinjau undangan...</span>
                </div>

                <iframe
                    x-ref="iframePreview"
                    :src="urlPreviewAktif()"
                    :style="`width: ${previewVirtualW()}px; height: ${previewVirtualH()}px; transform: scale(${previewScale}); transform-origin: top left;`"
                    title="Pratinjau Langsung Undangan {{ $undangan->nama_panggilan_pria }} & {{ $undangan->nama_panggilan_wanita }}"
                    class="block border-0 bg-white"
                    @load="previewMemuat = false"
                ></iframe>
            </div>
        </div>
    </div>

    @if ($bolehGantiTema)
        @include('dashboard._drawer-ganti-tema')
    @endif

    {{-- Lightbox Pratinjau Penuh Foto Galeri --}}
    <div
        x-show="galeriLightbox"
        x-cloak
        @keydown.escape.window="galeriLightbox = null"
        @click="galeriLightbox = null"
        class="fixed inset-0 z-50 bg-black/80 backdrop-blur-xs p-4 flex items-center justify-center"
    >
        <div @click.stop class="relative max-w-2xl w-full rounded-3xl overflow-hidden bg-white shadow-2xl">
            <button
                type="button"
                @click="galeriLightbox = null"
                aria-label="Tutup pratinjau"
                class="absolute top-3 right-3 z-10 w-9 h-9 rounded-full bg-black/60 text-white hover:bg-black/80 flex items-center justify-center cursor-pointer transition"
            >
                &times;
            </button>
            <img :src="galeriLightbox?.url" :alt="galeriLightbox?.caption" class="w-full max-h-[75vh] object-contain bg-charcoal">
            <div class="px-5 py-3.5 bg-white border-t border-champagne/20 flex items-center justify-between gap-3">
                <p class="text-sm font-semibold text-charcoal truncate" x-text="galeriLightbox?.caption"></p>
                <button type="button" @click="galeriLightbox = null" class="text-xs font-semibold text-sage hover:underline cursor-pointer shrink-0">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
