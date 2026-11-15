<div
    x-show="galeriModalTerbuka"
    x-cloak
    @keydown.escape.window="galeriModalTerbuka = false"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/85 p-4 backdrop-blur-sm"
>
    <button
        type="button"
        @click="galeriModalTerbuka = false"
        aria-label="Tutup galeri"
        class="absolute top-5 right-5 rounded-full bg-white/15 px-3.5 py-2 text-sm font-semibold text-white hover:bg-white/25 cursor-pointer"
    >
        Tutup ✕
    </button>

    <div @click.away="galeriModalTerbuka = false" class="max-w-3xl w-full text-center">
        <img :src="galeriAktifUrl" :alt="galeriAktifKeterangan" class="max-h-[80vh] mx-auto rounded-2xl object-contain shadow-2xl">
        <p x-show="galeriAktifKeterangan" x-text="galeriAktifKeterangan" class="mt-3 text-sm text-white/85"></p>
    </div>
</div>
