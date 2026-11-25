{{-- Modal Atur Potongan Foto (Crop Interaktif Sesuai Rasio Template Tema) --}}
<div
    x-show="cropTerbuka"
    x-cloak
    x-transition.opacity.duration.150ms
    @keydown.escape.window="if (cropTerbuka) tutupCropperFoto(true)"
    class="fixed inset-0 z-[80] flex items-center justify-center bg-black/75 backdrop-blur-xs p-3 sm:p-5"
    role="dialog"
    aria-modal="true"
    aria-label="Atur Potongan Foto"
>
    <div
        @click.stop
        class="w-full max-w-lg rounded-2xl bg-white shadow-2xl ring-1 ring-champagne/30 overflow-hidden flex flex-col max-h-[92vh]"
    >
        {{-- Header Modal --}}
        <div class="px-4 py-3 border-b border-champagne/25 flex items-center justify-between gap-3 bg-ivory/60 shrink-0">
            <div class="min-w-0">
                <h3 class="text-sm font-bold text-charcoal truncate" x-text="cropJudul">Atur Potongan Foto</h3>
                <p class="text-[11px] text-charcoal/60 truncate">
                    Geser &amp; perbesar foto agar pas dengan bingkai template
                    <span class="font-semibold text-sage" x-text="'(' + cropLabelTemplate + ')'"></span>
                </p>
            </div>
            <button
                type="button"
                @click="tutupCropperFoto(true)"
                class="h-8 w-8 rounded-xl bg-white ring-1 ring-champagne/35 text-charcoal/65 hover:text-charcoal hover:bg-ivory inline-flex items-center justify-center transition cursor-pointer shrink-0"
                aria-label="Tutup editor potong foto"
            >
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M18 6 6 18"/>
                    <path d="m6 6 12 12"/>
                </svg>
            </button>
        </div>

        {{-- Area Kanvas Crop Interaktif --}}
        <div class="px-4 pt-3.5 pb-3 space-y-3 overflow-y-auto">
            <div
                x-ref="wadahKanvasCrop"
                class="relative w-full h-[300px] sm:h-[340px] rounded-2xl overflow-hidden bg-[#111315] select-none touch-none ring-1 ring-charcoal/15"
            >
                <canvas
                    x-ref="kanvasCrop"
                    @pointerdown="cropPointerDown($event)"
                    @pointermove="cropPointerMove($event)"
                    @pointerup="cropPointerUp($event)"
                    @pointercancel="cropPointerUp($event)"
                    @wheel.prevent="cropWheelZoom($event)"
                    class="w-full h-full block cursor-grab active:cursor-grabbing touch-none"
                ></canvas>

                <div
                    x-show="cropMemuat"
                    class="absolute inset-0 flex flex-col items-center justify-center gap-2 bg-[#111315]/90 text-white/85"
                >
                    <span class="h-6 w-6 rounded-full border-2 border-white/30 border-t-white animate-spin"></span>
                    <span class="text-xs font-medium">Memuat gambar...</span>
                </div>

                <div
                    x-show="!cropMemuat && !cropGalat"
                    class="pointer-events-none absolute bottom-2.5 left-1/2 -translate-x-1/2 rounded-full bg-black/55 backdrop-blur-xs px-3 py-1 text-[10px] font-medium text-white/90 whitespace-nowrap"
                >
                    Geser foto untuk atur posisi &bull; Scroll / cubit untuk zoom
                </div>
            </div>

            <p x-show="cropGalat" x-cloak x-text="cropGalat" class="rounded-xl bg-rose-50 border border-rose-200 px-3 py-2 text-xs font-medium text-rose-700"></p>

            {{-- Kontrol Zoom & Rotasi --}}
            <div class="rounded-xl bg-ivory/75 p-3 ring-1 ring-champagne/25 space-y-2.5">
                <div class="flex items-center gap-2.5">
                    <button
                        type="button"
                        @click="ubahZoomCrop(cropZoom - 0.15)"
                        class="h-7 w-7 rounded-lg bg-white ring-1 ring-champagne/35 text-charcoal hover:text-sage inline-flex items-center justify-center font-bold text-sm transition cursor-pointer shrink-0"
                        title="Perkecil"
                        aria-label="Perkecil"
                    >&minus;</button>

                    <input
                        type="range"
                        min="1"
                        max="3"
                        step="0.01"
                        :value="cropZoom"
                        @input="ubahZoomCrop($event.target.value)"
                        aria-label="Perbesar atau perkecil foto"
                        class="flex-1 accent-sage cursor-pointer"
                    >

                    <button
                        type="button"
                        @click="ubahZoomCrop(cropZoom + 0.15)"
                        class="h-7 w-7 rounded-lg bg-white ring-1 ring-champagne/35 text-charcoal hover:text-sage inline-flex items-center justify-center font-bold text-sm transition cursor-pointer shrink-0"
                        title="Perbesar"
                        aria-label="Perbesar"
                    >+</button>

                    <span class="w-11 text-right font-sans tabular-nums text-[11px] font-semibold text-charcoal/70 shrink-0" x-text="Math.round(cropZoom * 100) + '%'"></span>
                </div>

                <div class="flex items-center justify-between gap-2 pt-1.5 border-t border-champagne/20">
                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-sage/10 px-2.5 py-1 text-[11px] font-semibold text-sage truncate">
                        <span x-text="cropLabelTemplate"></span>
                    </span>

                    <div class="flex items-center gap-1.5 shrink-0">
                        <button
                            type="button"
                            @click="putarCrop(90)"
                            class="inline-flex items-center gap-1 rounded-lg bg-white px-2.5 py-1 text-[11px] font-semibold text-charcoal/80 ring-1 ring-champagne/35 hover:text-sage transition cursor-pointer"
                            title="Putar 90 derajat"
                        >
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M21 12a9 9 0 1 1-9-9c2.52 0 4.93 1 6.74 2.74L21 8"/>
                                <path d="M21 3v5h-5"/>
                            </svg>
                            <span>Putar</span>
                        </button>
                        <button
                            type="button"
                            @click="resetCrop()"
                            class="rounded-lg bg-white px-2.5 py-1 text-[11px] font-semibold text-charcoal/75 ring-1 ring-champagne/35 hover:text-sage transition cursor-pointer"
                        >
                            Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer Aksi Modal --}}
        <div class="px-4 py-3 border-t border-champagne/25 bg-white flex items-center justify-end gap-2 shrink-0">
            <button
                type="button"
                @click="tutupCropperFoto(true)"
                class="rounded-xl border border-champagne/45 bg-white px-3.5 py-2 text-xs font-semibold text-charcoal hover:bg-ivory transition cursor-pointer"
            >
                Batal
            </button>
            <button
                type="button"
                :disabled="cropMemuat || cropMenyimpan || Boolean(cropGalat)"
                @click="terapkanPotonganFoto()"
                class="inline-flex items-center gap-1.5 rounded-xl bg-sage px-4 py-2 text-xs font-semibold text-white shadow-xs hover:bg-[#3b5047] disabled:opacity-55 transition cursor-pointer"
            >
                <span x-text="cropMenyimpan ? 'Memproses...' : 'Terapkan Potongan'"></span>
            </button>
        </div>
    </div>
</div>
