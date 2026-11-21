{{-- PANGGUNG VISUAL DESKTOP KIRI: ISLAMI SYAR'I EMERALD SANCTUARY --}}
<aside
    data-panggung-3d
    class="hidden lg:flex lg:flex-1 lg:sticky lg:top-0 lg:h-screen relative overflow-hidden select-none panggung-3d bg-[#133D38]"
>
    <div class="lapis-3d absolute -inset-5 pointer-events-none" style="--depth: -14px; --pz: -40px;">
        <img src="{{ $urlFotoLatar }}" alt="Islami Syar'i Emerald" class="w-full h-full object-cover object-center scale-105 animasi-nafas">
    </div>
    <div class="absolute inset-0 bg-gradient-to-b from-[#133D38]/72 via-[#184D47]/45 to-[#0D2C28]/88"></div>

    <div aria-hidden="true" class="pointer-events-none absolute inset-8 rounded-t-[16rem] rounded-b-3xl border border-[#BFA15F]/45"></div>

    @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'zaitun-kilau', 'konteks' => 'panggung'])

    <div class="lapis-3d relative z-20 w-full flex flex-col items-center justify-center text-center px-12 text-[#F4FAF6]" style="--depth: 10px; --pz: 24px;">
        <img src="{{ $asetSyari['arabesque'] }}" alt="" class="w-20 xl:w-24 mx-auto mb-3 opacity-95 animasi-ayun-3d">
        <p class="text-lg text-[#F3E5AB]" style="font-family: 'Amiri', serif;">
            بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
        </p>
        <p class="mt-2 text-[11px] font-semibold uppercase tracking-[0.38em] text-[#E6D19C]">
            Walimatul Ursy &bull; Syar&rsquo;i
        </p>
        <h2 class="mt-3 font-serif text-5xl xl:text-6xl font-bold leading-tight text-white">
            {{ $undangan->nama_panggilan_pria }}
            <span class="font-kaligrafi font-normal text-[#E6D19C]">&amp;</span>
            {{ $undangan->nama_panggilan_wanita }}
        </h2>
        <div class="mt-4 flex flex-wrap items-center justify-center gap-3 text-xs uppercase tracking-[0.26em] text-[#F4FAF6]/85">
            <span>{{ $tanggalLengkap }}</span>
            <span class="w-1.5 h-1.5 rounded-full bg-[#BFA15F]"></span>
            <span>{{ $hashtagPasangan }}</span>
        </div>
    </div>
</aside>
