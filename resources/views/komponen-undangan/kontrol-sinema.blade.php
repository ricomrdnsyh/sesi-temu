@php
    $adaMusik = ! empty($undangan->musik_latar);
@endphp

{{-- Toast Ringkas Status Auto-Scroll Cinema (Tengah Bawah) --}}
<div
    x-show="undanganTerbuka && autoScrollToast && autoScrollAktif"
    x-cloak
    x-transition:enter="transition ease-out duration-250"
    x-transition:enter-start="opacity-0 translate-y-3"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-2"
    class="fixed bottom-5 left-1/2 -translate-x-1/2 lg:left-auto lg:translate-x-0 lg:right-[145px] xl:right-[160px] z-40"
>
    <button
        type="button"
        @click="hentikanAutoScroll(true)"
        class="inline-flex items-center gap-2 rounded-full bg-[#151817]/90 backdrop-blur-md px-3.5 py-1.5 text-[11px] font-medium text-[#FDFBF7] shadow-xl border border-[#D4AF37]/40 cursor-pointer hover:bg-[#151817] transition"
    >
        <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
        <span>Auto-scroll aktif <strong class="text-[#F3E5AB]" x-text="kecepatanScroll + 'x'"></strong></span>
        <span class="text-white/50">&bull;</span>
        <span class="text-[#F3E5AB] underline">Jeda</span>
    </button>
</div>

{{-- Dock Melayang Auto-Scroll Cinema (Pojok Kanan Bawah, Di Atas Tombol Musik) --}}
<div
    x-show="undanganTerbuka"
    x-cloak
    x-transition
    data-autoscroll-dock
    class="fixed {{ $adaMusik ? 'bottom-[4.75rem]' : 'bottom-5' }} right-5 z-40 flex flex-col items-center gap-2"
>
    {{-- Panel Kontrol Vertikal Saat Dibuka --}}
    <div
        x-show="autoScrollPanelTerbuka"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
        class="flex flex-col items-center gap-1.5 rounded-full bg-[#151817]/92 backdrop-blur-md p-1.5 shadow-2xl border border-[#D4AF37]/45 text-[#F3E5AB]"
    >
        <button
            type="button"
            @click="gulirKeAtas()"
            title="Kembali ke atas"
            aria-label="Kembali ke atas"
            class="inline-flex h-8 w-8 items-center justify-center rounded-full hover:bg-white/15 active:scale-95 transition cursor-pointer"
        >
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="m18 15-6-6-6 6"/>
            </svg>
        </button>

        <button
            type="button"
            @click="toggleAutoScroll()"
            :title="autoScrollAktif ? 'Jeda auto-scroll' : 'Jalankan auto-scroll'"
            :aria-label="autoScrollAktif ? 'Jeda auto-scroll' : 'Jalankan auto-scroll'"
            :class="autoScrollAktif ? 'bg-[#D4AF37] text-[#151817]' : 'bg-white/10 text-[#F3E5AB] hover:bg-white/20'"
            class="inline-flex h-8 w-8 items-center justify-center rounded-full active:scale-95 transition cursor-pointer"
        >
            <svg x-show="autoScrollAktif" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <rect x="6" y="4" width="4" height="16" rx="1"/>
                <rect x="14" y="4" width="4" height="16" rx="1"/>
            </svg>
            <svg x-show="!autoScrollAktif" x-cloak class="h-3.5 w-3.5 ml-0.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <polygon points="6 4 20 12 6 20 6 4"/>
            </svg>
        </button>

        <button
            type="button"
            @click="ubahKecepatanScroll(1)"
            :disabled="kecepatanScroll >= 3"
            title="Percepat auto-scroll"
            aria-label="Percepat auto-scroll"
            class="inline-flex h-7 w-7 items-center justify-center rounded-full hover:bg-white/15 disabled:opacity-35 transition cursor-pointer text-xs font-bold"
        >+</button>

        <span
            class="font-sans tabular-nums text-[10px] font-bold tracking-tight text-white/90 select-none"
            x-text="kecepatanScroll + 'x'"
        ></span>

        <button
            type="button"
            @click="ubahKecepatanScroll(-1)"
            :disabled="kecepatanScroll <= 1"
            title="Perlambat auto-scroll"
            aria-label="Perlambat auto-scroll"
            class="inline-flex h-7 w-7 items-center justify-center rounded-full hover:bg-white/15 disabled:opacity-35 transition cursor-pointer text-xs font-bold"
        >&minus;</button>
    </div>

    {{-- Tombol Pemicu Dock Auto-Scroll --}}
    <button
        type="button"
        @click="autoScrollPanelTerbuka = !autoScrollPanelTerbuka"
        :title="autoScrollPanelTerbuka ? 'Tutup kontrol auto-scroll' : 'Buka kontrol auto-scroll sinema'"
        aria-label="Kontrol Auto-Scroll Sinema"
        class="relative inline-flex h-10 w-10 items-center justify-center rounded-full shadow-lg border-2 border-[#D4AF37]/70 bg-[#151817]/90 text-[#F3E5AB] hover:bg-[#151817] active:scale-95 transition cursor-pointer backdrop-blur-md"
    >
        <span
            x-show="autoScrollAktif"
            class="pointer-events-none absolute -top-0.5 -right-0.5 h-2.5 w-2.5 rounded-full bg-emerald-400 ring-2 ring-[#151817]"
        ></span>
        <svg
            :class="autoScrollPanelTerbuka ? 'rotate-180' : ''"
            class="h-4 w-4 transition-transform duration-200"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2.2"
            stroke-linecap="round"
            stroke-linejoin="round"
            aria-hidden="true"
        >
            <path d="M12 5v14"/>
            <path d="m19 12-7 7-7-7"/>
        </svg>
    </button>
</div>
