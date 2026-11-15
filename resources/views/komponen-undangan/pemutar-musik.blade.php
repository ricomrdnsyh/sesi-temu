@if ($undangan->musik_latar)
    <audio x-ref="pemutarAudio" loop preload="auto" src="{{ asset($undangan->musik_latar) }}"></audio>

    <button
        type="button"
        @click="toggleMusik()"
        aria-label="Putar atau jeda musik latar"
        x-show="undanganTerbuka"
        x-transition
        class="fixed bottom-5 right-5 z-40 w-12 h-12 rounded-full shadow-lg flex items-center justify-center border-2 border-champagne bg-charcoal text-champagne cursor-pointer"
        :class="musikBerputar ? 'animasi-putar-kaset' : 'animasi-putar-kaset animasi-putar-jeda'"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-2v13M9 19a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm12-2a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
        </svg>
    </button>
@endif
