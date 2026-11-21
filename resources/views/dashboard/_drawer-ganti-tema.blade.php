@php
    $ringkasanTierModal = \App\Models\Tema::ringkasanTier($daftarTema);
    $indeksTemaStudio = $daftarTema->map(fn (\App\Models\Tema $item): array => [
        'tier' => $item->tierKode(),
        'teks' => strtolower($item->nama_tema.' '.$item->tierLabel()),
    ])->values()->all();
@endphp

{{-- Studio Modal Terpusat Ganti Tema (Filter Tier + Live Try-On Preview) --}}
<div
    x-data="{ indeksTemaStudio: @js($indeksTemaStudio) }"
    x-show="drawerTemaTerbuka"
    x-cloak
    data-drawer-ganti-tema
    data-modal-ganti-tema
    @keydown.escape.window="if (temaKonfirmasi) { temaKonfirmasi = null; } else if (drawerTemaTerbuka && !window.Swal?.isVisible()) { tutupDrawerTema(); }"
    class="fixed inset-0 z-50 flex items-center justify-center p-2.5 sm:p-4 lg:p-6"
    role="dialog"
    aria-modal="true"
    aria-label="Studio Pilih dan Ganti Tema Undangan"
>
    {{-- Backdrop Gelap Blur --}}
    <div
        x-show="drawerTemaTerbuka"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="if (!temaKonfirmasi) tutupDrawerTema()"
        class="fixed inset-0 bg-charcoal/60 backdrop-blur-xs"
    ></div>

    {{-- Panel Modal Tengah Split-Stage --}}
    <div
        x-show="drawerTemaTerbuka"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-2"
        @click.stop
        class="relative z-10 w-full max-w-6xl h-[92dvh] lg:h-[86dvh] max-h-[840px] rounded-[1.75rem] bg-[#FDFBF7] shadow-[0_30px_90px_-18px_rgba(20,32,26,0.48)] ring-1 ring-champagne/40 overflow-hidden flex flex-col"
    >
        {{-- Header Modal + Filter Tier Saja --}}
        <div class="bg-white border-b border-champagne/25 px-4 sm:px-6 pt-4 pb-3.5 space-y-3.5 shrink-0">
            <div class="flex items-start sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-[#3B4F45] text-[#F5E3B8] shadow-xs shrink-0">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/>
                            <circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/>
                            <circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/>
                            <circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/>
                            <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/>
                        </svg>
                    </span>
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="font-sans text-base sm:text-lg font-bold text-charcoal tracking-tight">
                                Studio Pilih Tema
                            </h2>
                            @if (auth()->user()->adalahAdmin() && $undangan->temaTerkunciUntukClient())
                                <span class="rounded-full bg-sage/12 px-2 py-0.5 text-[10px] font-bold text-sage ring-1 ring-sage/25">
                                    Mode Admin
                                </span>
                            @endif
                        </div>
                        <p class="text-[11px] sm:text-xs text-charcoal/60 truncate">
                            Coba langsung tampilan <strong>{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</strong> di tiap tema — seluruh data tetap aman.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    {{-- Pencarian Cepat Desktop --}}
                    <div class="relative hidden md:block w-56">
                        <svg class="h-3.5 w-3.5 text-charcoal/45 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.3-4.3"/>
                        </svg>
                        <input
                            type="search"
                            x-model="cariDrawerTema"
                            placeholder="Cari nama tema..."
                            aria-label="Cari nama tema"
                            class="w-full rounded-xl border border-champagne/35 bg-ivory/70 pl-8.5 pr-7 py-2 text-xs text-charcoal placeholder:text-charcoal/45 focus:bg-white focus:border-sage focus:outline-none transition"
                        >
                        <button
                            type="button"
                            x-show="cariDrawerTema.length > 0"
                            x-cloak
                            @click="cariDrawerTema = ''"
                            aria-label="Bersihkan pencarian"
                            class="absolute right-2 top-1/2 -translate-y-1/2 rounded-full p-0.5 text-charcoal/45 hover:text-charcoal cursor-pointer"
                        >
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M18 6 6 18"/>
                                <path d="m6 6 12 12"/>
                            </svg>
                        </button>
                    </div>

                    <button
                        type="button"
                        @click="tutupDrawerTema()"
                        aria-label="Tutup studio pilih tema"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-ivory text-charcoal/60 ring-1 ring-champagne/30 hover:bg-champagne/15 hover:text-charcoal active:scale-95 transition cursor-pointer"
                    >
                        <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M18 6 6 18"/>
                            <path d="m6 6 12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Filter Tier Saja (Semua Tier, Basic, Premium, Eksklusif) --}}
            <div data-filter-tier-studio class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                <button
                    type="button"
                    data-filter-tier="semua"
                    @click="tierDrawerTema = 'semua'"
                    :class="tierDrawerTema === 'semua'
                        ? 'bg-[#3B4F45] text-white ring-1 ring-[#3B4F45] shadow-sm'
                        : 'bg-[#FAF7F0] text-charcoal/75 ring-1 ring-champagne/30 hover:bg-white hover:ring-champagne/65 hover:text-charcoal'"
                    class="flex items-center justify-between gap-2 rounded-xl px-3 py-2 text-left transition cursor-pointer"
                >
                    <span class="flex items-center gap-2 min-w-0">
                        <span
                            :class="tierDrawerTema === 'semua' ? 'bg-white/15 text-[#F5E3B8]' : 'bg-white text-sage ring-1 ring-champagne/25'"
                            class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-lg"
                        >
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect width="7" height="7" x="3" y="3" rx="1.5"/>
                                <rect width="7" height="7" x="14" y="3" rx="1.5"/>
                                <rect width="7" height="7" x="14" y="14" rx="1.5"/>
                                <rect width="7" height="7" x="3" y="14" rx="1.5"/>
                            </svg>
                        </span>
                        <span class="text-xs font-bold truncate">Semua Tier</span>
                    </span>
                    <span
                        :class="tierDrawerTema === 'semua' ? 'bg-white/20 text-ivory' : 'bg-white text-charcoal/60 ring-1 ring-charcoal/10'"
                        class="rounded-full px-2 py-0.5 font-sans tabular-nums text-[10px] font-bold shrink-0"
                    >{{ $daftarTema->count() }}</span>
                </button>

                @foreach ([
                    'basic' => [
                        'ikon' => 'leaf',
                        'active' => 'bg-gradient-to-r from-[#2D4439] to-sage text-white ring-1 ring-sage shadow-sm',
                        'icon_active' => 'bg-white/15 text-ivory',
                        'icon_idle' => 'bg-white text-sage ring-1 ring-champagne/25',
                        'badge_active' => 'bg-white/20 text-ivory',
                    ],
                    'premium' => [
                        'ikon' => 'gem',
                        'active' => 'bg-gradient-to-r from-[#BFA15F] to-[#A68743] text-white ring-1 ring-champagne shadow-sm',
                        'icon_active' => 'bg-white/20 text-white',
                        'icon_idle' => 'bg-white text-[#8A6D33] ring-1 ring-champagne/25',
                        'badge_active' => 'bg-white/20 text-white',
                    ],
                    'eksklusif' => [
                        'ikon' => 'crown',
                        'active' => 'bg-gradient-to-r from-[#141C24] via-charcoal to-[#262E38] text-[#F3DFB0] ring-1 ring-champagne/70 shadow-sm',
                        'icon_active' => 'bg-champagne/20 text-[#F3DFB0]',
                        'icon_idle' => 'bg-white text-charcoal ring-1 ring-champagne/25',
                        'badge_active' => 'bg-champagne/20 text-[#F3DFB0]',
                    ],
                ] as $kodeTier => $metaTier)
                    @php $dataTier = $ringkasanTierModal[$kodeTier]; @endphp
                    <button
                        type="button"
                        data-filter-tier="{{ $kodeTier }}"
                        @click="tierDrawerTema = '{{ $kodeTier }}'"
                        :class="tierDrawerTema === '{{ $kodeTier }}'
                            ? '{{ $metaTier['active'] }}'
                            : 'bg-[#FAF7F0] text-charcoal/75 ring-1 ring-champagne/30 hover:bg-white hover:ring-champagne/65 hover:text-charcoal'"
                        class="flex items-center justify-between gap-2 rounded-xl px-3 py-2 text-left transition cursor-pointer"
                    >
                        <span class="flex items-center gap-2 min-w-0">
                            <span
                                :class="tierDrawerTema === '{{ $kodeTier }}' ? '{{ $metaTier['icon_active'] }}' : '{{ $metaTier['icon_idle'] }}'"
                                class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-lg"
                            >
                                @if ($metaTier['ikon'] === 'leaf')
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/>
                                        <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>
                                    </svg>
                                @elseif ($metaTier['ikon'] === 'gem')
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M6 3h12l4 6-10 13L2 9Z"/>
                                        <path d="M11 3 8 9l4 13 4-13-3-6"/>
                                        <path d="M2 9h20"/>
                                    </svg>
                                @else
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M11.562 3.266a.5.5 0 0 1 .876 0L15.39 8.87a1 1 0 0 0 1.516.294L21.183 5.5a.5.5 0 0 1 .798.519l-2.834 10.246a1 1 0 0 1-.956.734H5.81a1 1 0 0 1-.957-.734L2.02 6.02a.5.5 0 0 1 .798-.519l4.276 3.664a1 1 0 0 0 1.516-.294z"/>
                                        <path d="M5 21h14"/>
                                    </svg>
                                @endif
                            </span>
                            <span class="min-w-0">
                                <span class="block text-xs font-bold leading-tight truncate">{{ $dataTier['label'] }}</span>
                                <span
                                    :class="tierDrawerTema === '{{ $kodeTier }}' ? 'opacity-80' : 'text-charcoal/50'"
                                    class="hidden sm:block font-sans tabular-nums text-[10px] leading-tight truncate"
                                >Mulai {{ \App\Models\Tema::formatRupiah($dataTier['harga_mulai']) }}</span>
                            </span>
                        </span>
                        <span
                            :class="tierDrawerTema === '{{ $kodeTier }}' ? '{{ $metaTier['badge_active'] }}' : 'bg-white text-charcoal/60 ring-1 ring-charcoal/10'"
                            class="rounded-full px-2 py-0.5 font-sans tabular-nums text-[10px] font-bold shrink-0"
                        >{{ $dataTier['jumlah'] }}</span>
                    </button>
                @endforeach
            </div>

            {{-- Tab Mobile: Koleksi Tema vs Pratinjau Live --}}
            <div class="lg:hidden grid grid-cols-2 gap-1.5 rounded-xl bg-ivory p-1 ring-1 ring-champagne/25">
                <button
                    type="button"
                    @click="tabMobileStudio = 'daftar'"
                    :class="tabMobileStudio === 'daftar' ? 'bg-white text-sage shadow-xs font-bold ring-1 ring-champagne/30' : 'text-charcoal/65 font-semibold'"
                    class="rounded-lg py-1.5 text-xs transition cursor-pointer"
                >
                    Koleksi Tema
                </button>
                <button
                    type="button"
                    @click="tabMobileStudio = 'pratinjau'; previewStudioMemuat = true; $nextTick(() => hitungSkalaPreviewStudio())"
                    :class="tabMobileStudio === 'pratinjau' ? 'bg-white text-sage shadow-xs font-bold ring-1 ring-champagne/30' : 'text-charcoal/65 font-semibold'"
                    class="rounded-lg py-1.5 text-xs transition cursor-pointer flex items-center justify-center gap-1.5"
                >
                    <span class="h-1.5 w-1.5 rounded-full bg-sage"></span>
                    <span>Pratinjau Live</span>
                </button>
            </div>
        </div>

        {{-- Body Split-Stage: Kiri Galeri Tema | Kanan Live Try-On Phone Preview --}}
        <div class="flex-1 min-h-0 flex flex-col lg:flex-row overflow-hidden">
            {{-- PANEL KIRI: Grid Kartu Tema Visual --}}
            <div
                :class="tabMobileStudio === 'daftar' ? 'flex' : 'hidden lg:flex'"
                class="flex-1 min-w-0 flex-col overflow-y-auto p-4 sm:p-5 space-y-4 bg-[#FDFBF7]"
            >
                {{-- Pencarian Mobile --}}
                <div class="relative md:hidden">
                    <svg class="h-4 w-4 text-charcoal/45 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.3-4.3"/>
                    </svg>
                    <input
                        type="search"
                        x-model="cariDrawerTema"
                        placeholder="Cari nama tema..."
                        aria-label="Cari nama tema mobile"
                        class="w-full rounded-xl border border-champagne/35 bg-white pl-10 pr-8 py-2 text-xs text-charcoal placeholder:text-charcoal/45 focus:border-sage focus:outline-none transition"
                    >
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3.5">
                    @foreach ($daftarTema as $itemTema)
                        @php
                            $sedangDipakai = (int) $undangan->tema_id === (int) $itemTema->id;
                            $infoTierStudio = $itemTema->infoTier();
                            $infoDesainStudio = $itemTema->infoDesain();
                            $payloadStudioTema = [
                                'id' => $itemTema->id,
                                'slug' => $itemTema->slug,
                                'nama_tema' => $itemTema->nama_tema,
                                'tier' => $infoTierStudio['label'],
                                'tier_kode' => $infoTierStudio['kode'],
                                'ringkasan_tier' => $infoTierStudio['ringkasan'],
                                'deskripsi' => $infoDesainStudio['deskripsi'],
                                'harga_nominal' => $itemTema->hargaNominal(),
                                'harga' => $itemTema->hargaFormatted(),
                                'harga_asli' => $itemTema->adaDiskon() ? $itemTema->hargaAsliFormatted() : null,
                                'badge_diskon' => $itemTema->labelBadgeDiskon(),
                                'url_pratinjau' => route('dashboard.undangan.pratinjau-tema', ['undangan' => $undangan, 'tema' => $itemTema, 'embed' => 1]),
                                'url_demo_embed' => route('tema.demo', ['slugTema' => $itemTema->slug, 'embed' => 1]),
                                'url_demo' => route('tema.demo', ['slugTema' => $itemTema->slug]),
                            ];
                            $kataKunciTema = $itemTema->nama_tema.' '.$infoTierStudio['label'];
                        @endphp

                        <button
                            type="button"
                            x-show="temaCocokDrawer('{{ $infoTierStudio['kode'] }}', @js($kataKunciTema))"
                            x-transition.opacity.duration.150ms
                            @click="pilihTemaStudio(@js($payloadStudioTema))"
                            data-drawer-tema-card="{{ $itemTema->id }}"
                            :class="temaPreviewStudio?.id === {{ $itemTema->id }}
                                ? 'ring-2 ring-sage shadow-lg -translate-y-0.5'
                                : '{{ $sedangDipakai ? 'ring-2 ring-champagne/75 shadow-sm' : 'ring-1 ring-champagne/30 hover:ring-sage/65 hover:shadow-md hover:-translate-y-0.5' }}'"
                            class="group relative flex flex-col rounded-2xl overflow-hidden bg-white text-left transition-all duration-200 cursor-pointer focus:outline-none"
                        >
                            {{-- Poster Pratinjau Visual --}}
                            <div class="relative overflow-hidden bg-ivory w-full">
                                <div class="transition-transform duration-300 group-hover:scale-[1.03]">
                                    <x-poster-sampul-tema :tema="$itemTema" />
                                </div>

                                {{-- Indikator Sedang Dipratinjau (Kanan Atas) --}}
                                <span
                                    x-show="temaPreviewStudio?.id === {{ $itemTema->id }}"
                                    x-cloak
                                    class="pointer-events-none absolute top-2 right-2 z-20 inline-flex items-center gap-1 rounded-full bg-[#3B4F45] px-2 py-0.5 text-[10px] font-bold text-white shadow-sm ring-1 ring-white/40"
                                >
                                    <svg class="h-2.5 w-2.5 text-[#F5E3B8]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    <span>Dipilih</span>
                                </span>

                                {{-- Badge Status Dipakai / Tier (Kiri Bawah) --}}
                                @if ($sedangDipakai)
                                    <span class="pointer-events-none absolute bottom-2 left-2 z-20 inline-flex items-center gap-1 rounded-full bg-sage px-2 py-0.5 text-[10px] font-bold text-white shadow-sm ring-1 ring-white/40">
                                        <svg class="h-2.5 w-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M20 6 9 17l-5-5"/>
                                        </svg>
                                        <span>Dipakai</span>
                                    </span>
                                @else
                                    <span class="pointer-events-none absolute bottom-2 left-2 z-20 inline-flex items-center rounded-full px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider {{ $infoTierStudio['badge_class'] }}">
                                        {{ $infoTierStudio['label'] }}
                                    </span>
                                @endif
                            </div>

                            {{-- Detail Singkat Kartu --}}
                            <div class="p-2.5 sm:p-3 flex-1 flex flex-col justify-between gap-1.5 w-full bg-white">
                                <div>
                                    <p class="font-sans text-xs sm:text-[13px] font-bold text-charcoal leading-snug line-clamp-1">
                                        {{ $itemTema->nama_tema }}
                                    </p>
                                    <p class="mt-0.5 text-[10px] {{ $sedangDipakai ? 'font-semibold italic text-sage' : 'text-charcoal/55 truncate' }}">
                                        {{ $sedangDipakai ? 'Tema saat ini' : $infoTierStudio['ringkasan'] }}
                                    </p>
                                </div>

                                <div class="pt-1.5 border-t border-champagne/15 flex items-baseline justify-between gap-1">
                                    <div class="min-w-0">
                                        @if ($itemTema->adaDiskon())
                                            <span class="block font-sans tabular-nums text-[10px] text-charcoal/45 line-through leading-none">
                                                {{ $itemTema->hargaAsliFormatted() }}
                                            </span>
                                        @endif
                                        <span class="font-sans tabular-nums text-xs sm:text-[13px] font-bold {{ $itemTema->adaDiskon() ? 'text-rose-600' : 'text-charcoal' }}">
                                            {{ $itemTema->hargaFormatted() }}
                                        </span>
                                    </div>
                                    <span
                                        class="text-[10px] font-semibold shrink-0"
                                        :class="temaPreviewStudio?.id === {{ $itemTema->id }} ? 'text-sage' : 'text-charcoal/45 group-hover:text-sage'"
                                        x-text="temaPreviewStudio?.id === {{ $itemTema->id }} ? 'Pratinjau' : 'Coba →'"
                                    ></span>
                                </div>
                            </div>
                        </button>
                    @endforeach
                </div>

                {{-- Status Kosong Saat Filter Tidak Cocok --}}
                <div
                    x-show="!indeksTemaStudio.some((item) => temaCocokDrawer(item.tier, item.teks))"
                    x-cloak
                    class="rounded-2xl bg-white p-8 text-center ring-1 ring-champagne/30 space-y-2.5"
                >
                    <p class="text-sm font-semibold text-charcoal">Tidak ada tema yang cocok dengan filter ini.</p>
                    <button
                        type="button"
                        @click="tierDrawerTema = 'semua'; cariDrawerTema = ''"
                        class="inline-flex items-center justify-center rounded-full bg-sage px-4 py-2 text-xs font-semibold text-white hover:bg-[#3b5047] transition cursor-pointer"
                    >
                        Tampilkan Semua Tier
                    </button>
                </div>
            </div>

            {{-- PANEL KANAN: Live Interactive Try-On Phone Stage --}}
            <div
                :class="tabMobileStudio === 'pratinjau' ? 'flex' : 'hidden lg:flex'"
                class="w-full lg:w-[390px] xl:w-[420px] shrink-0 bg-[#F2F1EC] lg:border-l border-champagne/30 flex-col min-h-0"
            >
                {{-- Kontrol Sumber Preview (Data Anda vs Contoh Penuh) + Buka Tab Baru --}}
                <div class="px-4 pt-3.5 pb-2 flex items-center justify-between gap-2 shrink-0">
                    <div class="inline-flex items-center gap-1 rounded-full bg-white p-1 shadow-xs ring-1 ring-champagne/30">
                        <button
                            type="button"
                            @click="ubahSumberPreviewStudio('undangan')"
                            :class="sumberPreviewStudio === 'undangan' ? 'bg-[#3B4F45] text-white shadow-xs' : 'text-charcoal/65 hover:text-charcoal'"
                            class="rounded-full px-3 py-1 text-[11px] font-semibold transition cursor-pointer"
                        >
                            Data Anda
                        </button>
                        <button
                            type="button"
                            @click="ubahSumberPreviewStudio('demo')"
                            :class="sumberPreviewStudio === 'demo' ? 'bg-[#3B4F45] text-white shadow-xs' : 'text-charcoal/65 hover:text-charcoal'"
                            class="rounded-full px-3 py-1 text-[11px] font-semibold transition cursor-pointer"
                        >
                            Contoh Penuh
                        </button>
                    </div>

                    <a
                        :href="temaPreviewStudio?.url_demo || '#'"
                        target="_blank"
                        rel="noopener noreferrer"
                        title="Buka live demo penuh di tab baru"
                        class="inline-flex items-center gap-1 rounded-full bg-white px-2.5 py-1.5 text-[11px] font-semibold text-charcoal/70 shadow-xs ring-1 ring-champagne/30 hover:text-sage transition shrink-0"
                    >
                        <span>Tab Baru</span>
                        <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M15 3h6v6"/>
                            <path d="M10 14 21 3"/>
                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                        </svg>
                    </a>
                </div>

                {{-- Bingkai HP Pratinjau Langsung (Skala Proporsional 390x780) --}}
                <div data-stage-preview-studio class="flex-1 min-h-0 flex items-center justify-center p-3 overflow-hidden">
                    <div
                        :style="`width: ${Math.round(390 * previewStudioScale) + 12}px; height: ${Math.round(780 * previewStudioScale) + 12}px;`"
                        class="relative rounded-[1.85rem] bg-[#1E2421] p-1.5 shadow-[0_22px_50px_-14px_rgba(20,32,26,0.36)] ring-1 ring-white/15 shrink-0"
                    >
                        <div class="relative w-full h-full rounded-[1.45rem] overflow-hidden bg-white">
                            <div
                                x-show="previewStudioMemuat"
                                class="absolute inset-0 z-10 bg-ivory/95 flex flex-col items-center justify-center gap-2 text-charcoal/65 px-4 text-center"
                            >
                                <svg class="h-6 w-6 animate-spin text-sage" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10" class="opacity-20"/>
                                    <path d="M22 12a10 10 0 0 0-10-10"/>
                                </svg>
                                <span class="text-[11px] font-medium" x-text="'Memuat pratinjau ' + (temaPreviewStudio?.nama_tema || '') + '...'"></span>
                            </div>

                            <iframe
                                :src="urlPreviewStudio()"
                                :style="`width: 390px; height: 780px; transform: scale(${previewStudioScale}); transform-origin: top left;`"
                                title="Pratinjau Langsung Tema Pilihan"
                                class="block border-0 bg-white"
                                @load="previewStudioMemuat = false"
                            ></iframe>
                        </div>
                    </div>
                </div>

                {{-- Footer Aksi Terapkan Tema --}}
                <div class="bg-white border-t border-champagne/25 px-4 py-3.5 space-y-3 shrink-0">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <div class="flex items-center gap-1.5">
                                <span
                                    class="inline-flex items-center rounded-full bg-ivory px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-[#8A6D33] ring-1 ring-champagne/35"
                                    x-text="temaPreviewStudio?.tier || ''"
                                ></span>
                                <span
                                    x-show="temaPreviewStudio && temaPreviewStudio.id !== temaAktifEditorId"
                                    x-cloak
                                    :class="selisihHargaStudio().kelas"
                                    class="inline-flex items-center rounded-full px-2 py-0.5 font-sans tabular-nums text-[10px] font-bold"
                                    x-text="selisihHargaStudio().teks"
                                ></span>
                            </div>
                            <p class="mt-1 font-sans text-sm font-bold text-charcoal truncate" x-text="temaPreviewStudio?.nama_tema || ''"></p>
                        </div>

                        <div class="text-right shrink-0">
                            <span
                                x-show="temaPreviewStudio?.harga_asli"
                                class="block font-sans tabular-nums text-[10px] text-charcoal/45 line-through leading-none"
                                x-text="temaPreviewStudio?.harga_asli"
                            ></span>
                            <span class="font-sans tabular-nums text-base font-bold text-charcoal" x-text="temaPreviewStudio?.harga || ''"></span>
                        </div>
                    </div>

                    <template x-if="temaPreviewStudio && temaPreviewStudio.id === temaAktifEditorId">
                        <div class="w-full rounded-xl bg-sage/10 px-4 py-2.5 text-center text-xs font-bold text-sage ring-1 ring-sage/20">
                            ✓ Tema Ini Sedang Digunakan — Pilih kartu lain untuk mencoba
                        </div>
                    </template>

                    <template x-if="temaPreviewStudio && temaPreviewStudio.id !== temaAktifEditorId">
                        <button
                            type="button"
                            @click="pilihTemaKonfirmasi(temaPreviewStudio)"
                            class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-[#3B4F45] px-4 py-2.5 text-xs sm:text-sm font-bold text-white shadow-xs hover:bg-sage active:scale-[0.98] transition cursor-pointer"
                        >
                            <span>Terapkan Tema Ini</span>
                            <span aria-hidden="true">&rarr;</span>
                        </button>
                    </template>
                </div>
            </div>
        </div>

        {{-- Sticky Footer Mobile saat sedang di tab Koleksi Tema --}}
        <div
            x-show="tabMobileStudio === 'daftar' && temaPreviewStudio"
            class="lg:hidden bg-white border-t border-champagne/25 px-4 py-3 flex items-center justify-between gap-2.5 shrink-0"
        >
            <div class="min-w-0">
                <p class="text-xs font-bold text-charcoal truncate" x-text="temaPreviewStudio?.nama_tema"></p>
                <p class="font-sans tabular-nums text-[11px] font-semibold text-sage" x-text="(temaPreviewStudio?.tier || '') + ' • ' + (temaPreviewStudio?.harga || '')"></p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <button
                    type="button"
                    @click="tabMobileStudio = 'pratinjau'; previewStudioMemuat = true; $nextTick(() => hitungSkalaPreviewStudio())"
                    class="rounded-xl bg-ivory px-3 py-2 text-xs font-semibold text-charcoal ring-1 ring-champagne/35 hover:bg-champagne/15 transition cursor-pointer"
                >
                    Lihat Live
                </button>
                <button
                    type="button"
                    x-show="temaPreviewStudio && temaPreviewStudio.id !== temaAktifEditorId"
                    @click="pilihTemaKonfirmasi(temaPreviewStudio)"
                    class="rounded-xl bg-[#3B4F45] px-3.5 py-2 text-xs font-bold text-white hover:bg-sage transition cursor-pointer"
                >
                    Terapkan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Ganti Tema --}}
<div
    x-show="temaKonfirmasi !== null"
    x-cloak
    data-modal-konfirmasi-ganti-tema
    class="fixed inset-0 z-[60] flex items-center justify-center bg-charcoal/70 backdrop-blur-xs p-4"
    role="dialog"
    aria-modal="true"
    aria-label="Konfirmasi Ganti Tema"
>
    <div
        x-show="temaKonfirmasi !== null"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        @click.away="if (!window.Swal?.isVisible()) temaKonfirmasi = null"
        class="relative w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl ring-1 ring-champagne/35"
    >
        <button
            type="button"
            @click="temaKonfirmasi = null"
            aria-label="Tutup konfirmasi ganti tema"
            class="absolute top-4 right-4 inline-flex h-8 w-8 items-center justify-center rounded-full text-charcoal/45 hover:bg-ivory hover:text-charcoal transition cursor-pointer"
        >
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M18 6 6 18"/>
                <path d="m6 6 12 12"/>
            </svg>
        </button>

        <div class="text-center">
            <div class="mx-auto inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-ivory text-sage ring-1 ring-champagne/35">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <rect width="7" height="7" x="3" y="3" rx="1.5"/>
                    <rect width="7" height="7" x="14" y="3" rx="1.5"/>
                    <rect width="7" height="7" x="14" y="14" rx="1.5"/>
                    <rect width="7" height="7" x="3" y="14" rx="1.5"/>
                </svg>
            </div>

            <h3 class="mt-4 font-sans text-lg font-bold text-charcoal">Ganti Tema?</h3>
            <p class="mt-1.5 text-xs sm:text-sm text-charcoal/65 leading-relaxed">
                Seluruh data mempelai, acara, galeri, amplop, dan tamu tetap tersimpan aman. Lanjut terapkan tema pilihan berikut?
            </p>
        </div>

        <div class="mt-4 rounded-2xl bg-ivory/80 px-4 py-3 ring-1 ring-champagne/30 flex items-center justify-between gap-3">
            <div class="min-w-0">
                <p class="text-[10px] font-bold uppercase tracking-wider text-sage" x-text="'Tier ' + (temaKonfirmasi?.tier || '')"></p>
                <p class="mt-0.5 font-sans text-sm font-bold text-charcoal truncate" x-text="temaKonfirmasi?.nama_tema"></p>
            </div>
            <div class="text-right shrink-0">
                <span
                    x-show="temaKonfirmasi?.harga_asli"
                    class="block font-sans tabular-nums text-[10px] text-charcoal/45 line-through"
                    x-text="temaKonfirmasi?.harga_asli"
                ></span>
                <span class="font-sans tabular-nums text-sm font-bold text-charcoal" x-text="temaKonfirmasi?.harga"></span>
            </div>
        </div>

        <form
            action="{{ route('dashboard.undangan.ganti-tema', $undangan) }}"
            method="POST"
            class="mt-5 grid grid-cols-2 gap-2.5"
            data-swal-loading
            data-swal-loading-title="Mengganti Tema Undangan..."
            data-swal-loading-text="Menerapkan tampilan tema baru ke undangan Anda..."
        >
            @csrf
            @method('PATCH')
            <input type="hidden" name="tema_id" :value="temaKonfirmasi?.id">
            <input type="hidden" name="tab_kembali" :value="tab || 'tema'">

            <button
                type="button"
                @click="temaKonfirmasi = null"
                class="w-full rounded-full border border-charcoal/15 bg-white px-4 py-2.5 text-sm font-semibold text-charcoal/75 hover:bg-ivory active:scale-[0.98] transition cursor-pointer"
            >
                Batal
            </button>
            <button
                type="submit"
                class="w-full rounded-full bg-[#3B4F45] px-4 py-2.5 text-sm font-semibold text-white hover:bg-sage shadow-xs active:scale-[0.98] transition cursor-pointer"
            >
                Ya, Ganti Tema
            </button>
        </form>
    </div>
</div>
