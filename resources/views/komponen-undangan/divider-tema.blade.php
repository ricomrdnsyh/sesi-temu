@props([
    'gayaTataLetak' => 'klasik',
    'kelasAksen' => 'text-[#BFA15F]',
    'kelasBatas' => 'border-[#BFA15F]/35',
])

<div class="masuk-3d flex items-center justify-center gap-3 px-8 py-3 opacity-90" aria-hidden="true">
    <span class="h-px flex-1 border-t {{ $kelasBatas }}"></span>

    <span class="inline-flex items-center justify-center rounded-full px-3 py-1 backdrop-blur-sm border {{ $kelasBatas }} shadow-sm">
        @if ($gayaTataLetak === 'keraton')
            <svg class="w-7 h-7 {{ $kelasAksen }} animasi-kilau drop-shadow" viewBox="0 0 32 32" fill="currentColor">
                <path d="M16 3 L24 18 L27 27 H5 L8 18 Z" fill="none" stroke="currentColor" stroke-width="1.5"/>
                <path d="M16 8 L20 18 L16 25 L12 18 Z" opacity="0.65"/>
                <circle cx="16" cy="17" r="2"/>
            </svg>
        @elseif ($gayaTataLetak === 'priangan')
            <svg class="w-10 h-6 {{ $kelasAksen }} animasi-awan drop-shadow" viewBox="0 0 48 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M4 16 C8 10, 14 10, 18 14 C21 8, 27 8, 30 14 C34 10, 40 10, 44 16"/>
                <path d="M10 19 C15 15, 21 15, 24 18 C27 15, 33 15, 38 19" opacity="0.65"/>
            </svg>
        @elseif ($gayaTataLetak === 'mihrab' || $gayaTataLetak === 'celestial')
            <svg class="w-7 h-7 {{ $kelasAksen }} animasi-orbit drop-shadow" style="animation-duration: 24s;" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.4">
                <rect x="7" y="7" width="18" height="18"/>
                <rect x="7" y="7" width="18" height="18" transform="rotate(45 16 16)"/>
                <circle cx="16" cy="16" r="2.5" fill="currentColor"/>
            </svg>
        @elseif ($gayaTataLetak === 'artdeco')
            <svg class="w-9 h-6 {{ $kelasAksen }} animasi-kilau drop-shadow" viewBox="0 0 40 24" fill="none" stroke="currentColor" stroke-width="1.4">
                <path d="M2 12 L12 4 L20 12 L28 4 L38 12 L28 20 L20 12 L12 20 Z"/>
                <circle cx="20" cy="12" r="2.5" fill="currentColor"/>
            </svg>
        @elseif ($gayaTataLetak === 'editorial')
            <span class="inline-flex items-center gap-2 text-[10px] font-semibold uppercase tracking-[0.3em] {{ $kelasAksen }}">
                <span>&#9670;</span>
                <span>Section</span>
                <span>&#9670;</span>
            </span>
        @elseif ($gayaTataLetak === 'katedral')
            <svg class="w-8 h-6 {{ $kelasAksen }} animasi-kilau drop-shadow" viewBox="0 0 36 24" fill="none" stroke="currentColor" stroke-width="1.4">
                <path d="M6 18 C8 10, 14 6, 18 4 C22 6, 28 10, 30 18"/>
                <path d="M12 18 C13 13, 16 10, 18 9 C20 10, 23 13, 24 18"/>
                <circle cx="18" cy="15" r="2" fill="currentColor"/>
            </svg>
        @else
            <span class="text-xs font-serif {{ $kelasAksen }}">&#10022; &bull; &#10022;</span>
        @endif
    </span>

    <span class="h-px flex-1 border-t {{ $kelasBatas }}"></span>
</div>
