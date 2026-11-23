{{-- PANGGUNG VISUAL DESKTOP KIRI: EMERALD & GOLD ALHAMBRA SANCTUARY --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 min-w-0 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d items-center justify-center bg-[#092623] {{ $tampilBarDemo ? 'pt-14' : '' }}"
>
    {{-- Latar Lukisan Courtyard Andalusia Di Balik Kabut Zamrud --}}
    <div class="lapis-3d absolute -inset-4 pointer-events-none" style="--depth: -12px; --pz: -36px;">
        <img src="{{ $urlFotoLatar }}" alt="Islami Syar'i Andalusia" class="w-full h-full object-cover object-center scale-105 opacity-32 animasi-nafas">
    </div>
    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-0"
        style="background: radial-gradient(ellipse 84% 72% at 50% 48%, rgba(20,76,69,0.72) 0%, rgba(11,45,42,0.88) 58%, rgba(6,24,22,0.96) 100%);"
    ></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 w-10 bg-gradient-to-l from-black/35 to-transparent z-30"></div>

    {{-- Bingkai Kubah Moorish Ganda Emas --}}
    <div aria-hidden="true" class="pointer-events-none absolute inset-6 xl:inset-8 {{ $tampilBarDemo ? 'top-20 xl:top-22' : '' }} rounded-t-[11rem] rounded-b-3xl border border-[#E6D19C]/38 z-10"></div>
    <div aria-hidden="true" class="pointer-events-none absolute inset-8 xl:inset-10 {{ $tampilBarDemo ? 'top-22 xl:top-24' : '' }} rounded-t-[10.2rem] rounded-b-2xl border border-dashed border-[#E6D19C]/20 z-10"></div>

    {{-- Lentera Fanous Menggantung Halus Di Sudut Atas --}}
    <svg aria-hidden="true" viewBox="0 0 60 130" class="pointer-events-none absolute top-0 left-10 w-9 text-[#E6D19C]/65 z-10 animasi-ayun-3d" fill="none" stroke="currentColor" stroke-width="1.2">
        <line x1="30" y1="0" x2="30" y2="48" stroke-opacity="0.7"/>
        <circle cx="30" cy="51" r="2.8" fill="currentColor"/>
        <path d="M22 59 Q30 51 38 59 L40 78 Q30 90 20 78 Z" fill="currentColor" fill-opacity="0.16"/>
        <circle cx="30" cy="70" r="2.2" fill="#FFF5D6" stroke="none"/>
        <path d="M30 88 L30 100"/>
        <path d="M30 100 L33 106 L30 112 L27 106 Z" fill="currentColor" stroke="none"/>
    </svg>
    <svg aria-hidden="true" viewBox="0 0 60 130" class="pointer-events-none absolute top-0 right-10 w-9 text-[#E6D19C]/65 z-10 animasi-ayun-3d-balik" fill="none" stroke="currentColor" stroke-width="1.2">
        <line x1="30" y1="0" x2="30" y2="38" stroke-opacity="0.7"/>
        <circle cx="30" cy="41" r="2.8" fill="currentColor"/>
        <path d="M22 49 Q30 41 38 49 L40 68 Q30 80 20 68 Z" fill="currentColor" fill-opacity="0.16"/>
        <circle cx="30" cy="60" r="2.2" fill="#FFF5D6" stroke="none"/>
        <path d="M30 78 L30 90"/>
        <path d="M30 90 L33 96 L30 102 L27 96 Z" fill="currentColor" stroke="none"/>
    </svg>

    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'zaitun-kilau', 'konteks' => 'panggung'])

    {{-- Plakat Tipografi Sanctuary Di Tengah --}}
    <div class="lapis-3d relative z-20 w-full max-w-[280px] xl:max-w-[330px] mx-auto px-6 flex flex-col items-center justify-center text-center text-[#F7FBF8]" style="--depth: 8px; --pz: 20px;">
        <div class="relative flex h-16 w-16 xl:h-18 xl:w-18 items-center justify-center">
            <span aria-hidden="true" class="absolute inset-1 rotate-45 border border-[#E6D19C]/65 bg-[#12453F]/60"></span>
            <span aria-hidden="true" class="absolute inset-1 border border-[#E6D19C]/35"></span>
            <img src="{{ $asetSyari['arabesque'] }}" alt="" class="relative z-10 w-11 xl:w-13 opacity-95 animasi-ayun-3d">
        </div>

        <p class="mt-5 text-lg xl:text-xl text-[#F3E5AB] drop-shadow" style="font-family: 'Amiri', serif;">
            بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
        </p>

        <p class="mt-1.5 text-[10px] xl:text-[11px] font-bold uppercase tracking-[0.36em] text-[#E6D19C]">
            Walimatul Ursy
        </p>

        <h2 class="mt-3 font-serif text-3xl xl:text-4xl 2xl:text-[2.8rem] font-bold leading-[1.08] text-white drop-shadow">
            <span class="block">{{ $undangan->nama_panggilan_pria }}</span>
            <span class="my-1 flex items-center justify-center gap-3">
                <span aria-hidden="true" class="h-px w-8 bg-[#E6D19C]/65"></span>
                <span class="font-kaligrafi font-normal text-3xl xl:text-4xl text-[#E6D19C]">&amp;</span>
                <span aria-hidden="true" class="h-px w-8 bg-[#E6D19C]/65"></span>
            </span>
            <span class="block">{{ $undangan->nama_panggilan_wanita }}</span>
        </h2>

        <div class="mt-5 inline-flex items-center gap-2 rounded-full bg-[#08221F]/80 border border-[#C5A059]/70 px-5 py-1.5 shadow-md">
            <span aria-hidden="true" class="h-1.5 w-1.5 rotate-45 bg-[#E6D19C]"></span>
            <p class="text-[10px] xl:text-[11px] font-semibold uppercase tracking-[0.22em] text-[#F3E5AB]">
                {{ $tanggalLengkap }}
            </p>
            <span aria-hidden="true" class="h-1.5 w-1.5 rotate-45 bg-[#E6D19C]"></span>
        </div>
    </div>
</aside>
