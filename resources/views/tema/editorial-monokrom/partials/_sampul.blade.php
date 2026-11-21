{{-- SAMPUL PEMBUKA EDITORIAL MONOKROM (MAJALAH VOGUE — ZERO ROUNDED CORNERS) --}}
<section
    data-transisi-sampul="fade-halus"
    class="tirai-fade-halus fixed inset-0 h-dvh lg:left-auto lg:w-[460px] xl:w-[490px] z-40 {{ $tampilBarDemo ? 'pt-28 sm:pt-20 lg:pt-14' : '' }}"
    style="height: 100dvh;"
    :class="undanganTerbuka ? 'tirai-terbuka pointer-events-none' : ''"
>
    <div class="relative w-full h-full flex flex-col justify-between overflow-hidden bg-[#111113]">
        <img
            src="{{ $pakaiFotoSampul ? $urlFotoSampul : $urlFotoLatar }}"
            alt="Sampul {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
            class="absolute inset-0 w-full h-full object-cover grayscale {{ $pakaiFotoSampul ? 'object-top' : 'object-center' }}"
        >
        <div class="absolute inset-0 bg-gradient-to-b from-black/82 via-black/25 to-black/90"></div>

        @include('komponen-undangan.lapisan-motion', ['efekMotion' => 'halus', 'konteks' => 'sampul'])

        {{-- Masthead Majalah --}}
        <div class="relative z-20 px-6 pt-5 sm:pt-7 text-white space-y-3">
            <div class="flex items-center justify-between text-[10px] uppercase tracking-[0.28em] text-white/80 border-b border-white/30 pb-2">
                <span>Vol. 01</span>
                <span>The Wedding Edition</span>
                <span>{{ $tahunAcara }}</span>
            </div>
            <div class="text-left space-y-1">
                <p class="text-[10px] uppercase tracking-[0.36em] text-white/70">Editorial Invitation</p>
                <h1 class="ed-serif text-4xl sm:text-5xl uppercase tracking-[0.06em] leading-[1.02] text-white">
                    {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
                </h1>
                <p class="text-[11px] uppercase tracking-[0.24em] text-white/75 pt-1">
                    {{ $tanggalLengkap }}
                </p>
            </div>
        </div>

        {{-- Kotak Press-Pass Bawah Tajam --}}
        <div class="relative z-20 px-6 pb-6 sm:pb-8">
            <div class="kartu-3d rounded-none bg-[#FAF9F6] border border-[#18181B] px-5 py-5 text-left text-[#18181B] shadow-2xl space-y-3">
                <div class="flex items-center justify-between border-b border-[#18181B]/20 pb-2 text-[10px] font-semibold uppercase tracking-[0.28em] text-[#52525B]">
                    <span>Tamu Kehormatan</span>
                    <span>RSVP PASS</span>
                </div>
                <p class="ed-serif text-2xl text-[#18181B]">
                    Kepada Yth. {{ $namaTamu }}
                </p>
                <button
                    type="button"
                    @click="bukaUndangan()"
                    class="w-full rounded-none bg-[#18181B] text-white px-6 py-3.5 text-xs font-bold uppercase tracking-[0.28em] hover:bg-[#3F3F46] transition cursor-pointer"
                >
                    Buka Undangan &rarr;
                </button>
            </div>
        </div>
    </div>
</section>
