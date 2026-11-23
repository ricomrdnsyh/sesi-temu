{{-- PANGGUNG VISUAL DESKTOP KANAN: RUB EL HIZB 8-POINT STAR MONOGRAM SEAL --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 min-w-0 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d items-center justify-center bg-[#092623] {{ $tampilBarDemo ? 'pt-14' : '' }}"
>
    {{-- Latar Lukisan Courtyard Andalusia Cermin Di Balik Kabut Zamrud --}}
    <div class="lapis-3d absolute -inset-4 pointer-events-none" style="--depth: -12px; --pz: -36px;">
        <img
            src="{{ $urlFotoLatar }}"
            alt=""
            class="w-full h-full object-cover object-center scale-105 opacity-32 animasi-nafas {{ empty($urlFotoLatarCustom) ? '-scale-x-100' : '' }}"
        >
    </div>
    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-0"
        style="background: radial-gradient(ellipse 84% 72% at 50% 48%, rgba(20,76,69,0.72) 0%, rgba(11,45,42,0.88) 58%, rgba(6,24,22,0.96) 100%);"
    ></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 left-0 w-10 bg-gradient-to-r from-black/35 to-transparent z-30"></div>

    {{-- Bingkai Kubah Moorish Ganda Emas --}}
    <div aria-hidden="true" class="pointer-events-none absolute inset-6 xl:inset-8 {{ $tampilBarDemo ? 'top-20 xl:top-22' : '' }} rounded-t-[11rem] rounded-b-3xl border border-[#E6D19C]/38 z-10"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-8 xl:inset-10 {{ $tampilBarDemo ? 'top-22 xl:top-24' : '' }} rounded-t-[10.2rem] rounded-b-2xl border border-dashed border-[#E6D19C]/20 z-10"></div>

    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'zaitun-kilau', 'konteks' => 'panggung'])

    <div class="lapis-3d relative z-20 w-full max-w-[280px] xl:max-w-[330px] mx-auto px-6 flex flex-col items-center justify-center text-center text-[#F7FBF8]" style="--depth: 8px; --pz: 20px;">
        {{-- Segel Bintang 8 Sudut Islami (Rub el Hizb) --}}
        <div class="relative w-36 h-36 xl:w-44 xl:h-44 flex items-center justify-center">
            <span aria-hidden="true" class="absolute -inset-2 rounded-full border border-dashed border-[#E6D19C]/35 animasi-orbit"></span>
            <span aria-hidden="true" class="absolute inset-2 bg-gradient-to-br from-[#16524C] to-[#08221F] border-2 border-[#C5A059] shadow-[0_18px_36px_-12px_rgba(4,16,14,0.65)]"></span>
            <span aria-hidden="true" class="absolute inset-2 rotate-45 bg-gradient-to-br from-[#16524C] to-[#08221F] border-2 border-[#C5A059] shadow-[0_18px_36px_-12px_rgba(4,16,14,0.65)]"></span>
            <span aria-hidden="true" class="absolute inset-4 border border-[#E6D19C]/45"></span>
            <span aria-hidden="true" class="absolute inset-4 rotate-45 border border-[#E6D19C]/45"></span>
            <div class="relative z-10 flex items-baseline justify-center gap-1.5 text-[#F3E5AB] drop-shadow">
                <span class="font-serif text-4xl xl:text-5xl font-bold tracking-wide">{{ $undangan->inisialPria() }}</span>
                <span class="font-kaligrafi text-3xl xl:text-4xl text-[#E6D19C]">&amp;</span>
                <span class="font-serif text-4xl xl:text-5xl font-bold tracking-wide">{{ $undangan->inisialWanita() }}</span>
            </div>
        </div>

        <div class="my-6 flex items-center justify-center gap-2.5 w-36" aria-hidden="true">
            <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#E6D19C]/65"></span>
            <svg class="h-3 w-3 text-[#E6D19C]" viewBox="0 0 16 16" fill="currentColor">
                <path d="M8 0.5L9.9 6.1L15.5 8L9.9 9.9L8 15.5L6.1 9.9L0.5 8L6.1 6.1L8 0.5Z" />
            </svg>
            <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#E6D19C]/65"></span>
        </div>

        <p class="rounded-full bg-[#08221F]/80 border border-[#C5A059]/60 px-4 py-1 text-[10px] xl:text-[11px] font-bold uppercase tracking-[0.22em] text-[#F3E5AB] shadow-xs">
            {{ $hashtagPasangan }}
        </p>

        <p class="mt-2.5 text-[10px] font-medium uppercase tracking-[0.28em] text-[#E6D19C]/80">
            {{ $tanggalTitik }}
        </p>
    </div>
</aside>
