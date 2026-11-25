{{-- 3. Panel Kanan: Kanvas Live Preview Interaktif (Desktop >= lg) --}}
<div class="hidden lg:flex flex-1 flex-col h-screen bg-[#F2F1EC] overflow-hidden min-w-0">
    {{-- Toolbar Atas Kanvas Preview --}}
    <div class="px-5 py-3.5 flex items-center justify-between gap-3 shrink-0">
        {{-- Pill Tema Aktif + Ganti Tema + Status Live --}}
        <div class="flex items-center gap-2 min-w-0 max-w-[68%]">
            <div class="inline-flex items-center gap-2 rounded-full bg-white pl-3.5 pr-1.5 py-1.5 shadow-xs ring-1 ring-champagne/30 min-w-0">
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

            <span
                x-show="livePreviewMenyinkron || livePreviewAktif"
                x-cloak
                title="Pratinjau otomatis mengikuti ketikan Anda. Klik Simpan di form untuk menyimpan permanen."
                :class="livePreviewMenyinkron ? 'bg-amber-50 text-amber-800 ring-amber-200' : 'bg-emerald-50 text-emerald-700 ring-emerald-200'"
                class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-[10.5px] font-semibold ring-1 shrink-0 whitespace-nowrap transition"
            >
                <span
                    :class="livePreviewMenyinkron ? 'bg-amber-500 animate-ping' : 'bg-emerald-500'"
                    class="h-1.5 w-1.5 rounded-full"
                ></span>
                <span x-text="livePreviewMenyinkron ? 'Menyinkronkan...' : 'Live'"></span>
            </span>
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
                    :class="(previewMemuat || livePreviewMenyinkron) ? 'animate-spin text-sage' : ''"
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
                x-show="previewMemuat && !livePreviewAktif"
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
