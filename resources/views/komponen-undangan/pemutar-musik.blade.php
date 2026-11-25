@if ($undangan->musik_latar)
    @php
        $slugTemaAudio = $undangan->tema?->slug ?? '';
        $adalahEleganAudio = in_array($slugTemaAudio, ['luxury-noir', 'royal-ivory'], true);
        $posisiTombolMusik = $adalahEleganAudio
            ? 'bottom-[4.65rem] right-3.5 sm:right-5 w-10 h-10 sm:w-11 sm:h-11'
            : 'bottom-5 right-5 w-11 h-11 sm:w-12 sm:h-12';
        $srcAudio = str_starts_with($undangan->musik_latar, 'http')
            ? $undangan->musik_latar
            : asset($undangan->musik_latar);

        $kelasTombolMusik = match ($slugTemaAudio) {
            'editorial-monokrom' => 'rounded-none border border-white/80 bg-[#111114]/95 text-white shadow-[4px_4px_0_0_rgba(255,255,255,0.2)]',
            'adat-jawa' => 'rounded-full border-2 border-[#D7BB83] bg-[#2B180F]/92 text-[#F3E5AB] shadow-lg',
            'sunda-heritage' => 'rounded-full border-2 border-[#E7C87D] bg-[#3B1414]/92 text-[#F3E5AB] shadow-lg',
            'islami-syari' => 'rounded-full border-2 border-[#C5A059] bg-[#0A2B28]/92 text-[#F3E5AB] shadow-lg',
            'islamic-heavenly' => 'rounded-full border-2 border-[#D9B664] bg-[#091322]/92 text-[#F3E5AB] shadow-lg',
            'rustic-floral' => 'rounded-full border-2 border-[#D9BE7B] bg-[#2C3C34]/92 text-[#FDFBF7] shadow-lg',
            'velvet-garden' => 'rounded-full border-2 border-[#C8A464] bg-[#112420]/92 text-[#F3DFA2] shadow-lg',
            'royal-ivory' => 'rounded-full border-2 border-[#E5C99B] bg-[#3B2E25]/92 text-[#FAF6EE] shadow-lg',
            default => 'rounded-full border-2 border-[#D4AF37] bg-[#141418]/92 text-[#F3E5AB] shadow-lg',
        };
    @endphp

    <audio
        x-ref="pemutarAudio"
        loop
        preload="auto"
        src="{{ $srcAudio }}"
        @play="musikBerputar = true"
        @pause="musikBerputar = false"
    ></audio>

    <button
        type="button"
        @click="toggleMusik()"
        :title="musikBerputar ? 'Jeda musik latar' : 'Putar musik latar'"
        aria-label="Putar atau jeda musik latar"
        x-show="undanganTerbuka"
        x-cloak
        x-transition
        class="fixed z-40 flex items-center justify-center backdrop-blur-md cursor-pointer transition active:scale-95 {{ $posisiTombolMusik }} {{ $kelasTombolMusik }}"
        :class="musikBerputar ? '{{ $slugTemaAudio === 'editorial-monokrom' ? '' : 'animasi-putar-kaset' }}' : '{{ $slugTemaAudio === 'editorial-monokrom' ? 'opacity-75' : 'animasi-putar-kaset animasi-putar-jeda opacity-80' }}'"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-2v13M9 19a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm12-2a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
            <line x-show="!musikBerputar" x-cloak x1="4" y1="4" x2="20" y2="20" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" />
        </svg>
    </button>
@endif
