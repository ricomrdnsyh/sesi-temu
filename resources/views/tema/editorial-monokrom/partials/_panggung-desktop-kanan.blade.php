{{-- PANGGUNG VISUAL DESKTOP KANAN: ARCHITECTURAL SEAL & EDITION TELEMETRY --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 min-w-0 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d items-center justify-center bg-[#0E0E11] {{ $tampilBarDemo ? 'pt-14' : '' }}"
>
    <div class="lapis-3d absolute -inset-4 pointer-events-none" style="--depth: -12px; --pz: -36px;">
        <img
            src="{{ $urlFotoLatar }}"
            alt=""
            :class="modeWarnaEditorial ? 'grayscale-0 opacity-40' : 'grayscale opacity-34'"
            class="w-full h-full object-cover object-center scale-105 animasi-nafas transition duration-700 {{ empty($urlFotoLatarCustom) ? '-scale-x-100' : '' }}"
        >
    </div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-b from-black/82 via-[#0E0E11]/68 to-black/92"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 ed-film-grain opacity-35"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 left-0 w-10 bg-gradient-to-r from-black/65 to-transparent z-30"></div>

    <div aria-hidden="true" class="pointer-events-none absolute inset-5 xl:inset-7 {{ $tampilBarDemo ? 'top-18 xl:top-20' : '' }} rounded-none border border-white/20 z-10">
        <span class="absolute -top-px -left-px h-4 w-4 border-t-2 border-l-2 border-white/80"></span>
        <span class="absolute -top-px -right-px h-4 w-4 border-t-2 border-r-2 border-white/80"></span>
        <span class="absolute -bottom-px -left-px h-4 w-4 border-b-2 border-l-2 border-white/80"></span>
        <span class="absolute -bottom-px -right-px h-4 w-4 border-b-2 border-r-2 border-white/80"></span>
    </div>

    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'halus', 'konteks' => 'panggung'])

    <div class="lapis-3d relative z-20 w-full max-w-[270px] xl:max-w-[330px] mx-auto px-6 flex flex-col items-center justify-center text-center text-white" style="--depth: 8px; --pz: 20px;">
        {{-- Segel Monogram Arsitektural Berputar --}}
        <div class="relative w-40 h-40 xl:w-48 xl:h-48 flex items-center justify-center">
            <svg aria-hidden="true" viewBox="0 0 120 120" class="ed-putar-lambat absolute inset-0 w-full h-full text-white/65">
                <defs>
                    <path id="ed-ring-desktop" d="M 60, 60 m -48, 0 a 48,48 0 1,1 96,0 a 48,48 0 1,1 -96,0" />
                </defs>
                <text font-size="7.2" fill="currentColor" letter-spacing="3.1" class="ed-mono uppercase">
                    <textPath href="#ed-ring-desktop">COLLECTOR EDITION &bull; FIRST PRINTING &bull;</textPath>
                </text>
            </svg>

            <div class="relative w-28 h-28 xl:w-32 xl:h-32 border border-white/55 bg-black/55 backdrop-blur-xs flex items-center justify-center shadow-[6px_6px_0_0_rgba(255,255,255,0.16)]">
                <span aria-hidden="true" class="absolute inset-1.5 border border-white/20"></span>
                <div class="relative z-10 flex items-baseline justify-center gap-1.5 text-white">
                    <span class="ed-serif text-3xl xl:text-4xl tracking-[0.08em]">{{ $undangan->inisialPria() }}</span>
                    <span class="ed-mono text-sm text-white/55">/</span>
                    <span class="ed-serif text-3xl xl:text-4xl tracking-[0.08em]">{{ $undangan->inisialWanita() }}</span>
                </div>
            </div>
        </div>

        <div class="mt-6 space-y-1.5">
            <p class="ed-mono text-[9.5px] xl:text-[10.5px] uppercase tracking-[0.26em] text-white/85">
                {{ $hashtagPasangan }}
            </p>
            <p class="ed-mono text-[8.5px] uppercase tracking-[0.24em] text-white/45">
                SCROLL TO EXPLORE ISSUE &darr;
            </p>
        </div>
    </div>
</aside>
