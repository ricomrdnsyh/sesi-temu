@props([
    'tanpaFoto' => false,
])

@php
    $babEditorial = array_values(array_filter([
        ['id' => 'ed-bab-01', 'no' => '01', 'judul' => 'HERO'],
        ['id' => 'ed-bab-02', 'no' => '02', 'judul' => 'COUPLE'],
        ['id' => 'ed-bab-03', 'no' => '03', 'judul' => 'DATE'],
        ['id' => 'ed-bab-04', 'no' => '04', 'judul' => 'PASS'],
        ['id' => 'ed-bab-05', 'no' => '05', 'judul' => 'STORY'],
        ! $tanpaFoto ? ['id' => 'ed-bab-06', 'no' => '06', 'judul' => 'PLATES'] : null,
        ['id' => 'buku-tamu', 'no' => $tanpaFoto ? '06' : '07', 'judul' => 'RSVP'],
    ]));
@endphp

<nav
    data-indeks-editorial
    aria-label="Indeks Bab Editorial"
    x-show="undanganTerbuka && !galeriModalTerbuka"
    x-cloak
    x-transition.opacity.duration.300ms
    x-data="{
        babAktif: 'ed-bab-01',
        daftarId: @js(array_column($babEditorial, 'id')),
        init() {
            const pantau = () => {
                const batas = (window.innerHeight || 760) * 0.42;
                let terpilih = this.daftarId[0] || '';
                for (const id of this.daftarId) {
                    const el = document.getElementById(id);
                    if (!el) continue;
                    if (el.getBoundingClientRect().top <= batas) {
                        terpilih = id;
                    }
                }
                this.babAktif = terpilih;
            };
            window.addEventListener('scroll', pantau, { passive: true });
            setTimeout(pantau, 400);
        },
        lompat(id) {
            this.babAktif = id;
            if (window.SesiTemuSinema?.gulirKeSeksi) {
                window.SesiTemuSinema.gulirKeSeksi('#' + id);
                return;
            }
            const el = document.getElementById(id);
            if (el) {
                el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    }"
    class="fixed right-2 sm:right-3 lg:right-[calc(50%-238px)] xl:right-[calc(50%-253px)] top-1/2 -translate-y-1/2 z-40 flex flex-col items-end gap-1 select-none"
>
    <div class="flex flex-col items-stretch border border-[#18181B] bg-[#FAF9F6]/92 backdrop-blur-md shadow-[3px_3px_0_0_#18181B]">
        <span
            aria-hidden="true"
            class="ed-mono bg-[#18181B] text-[#FAF9F6] px-1.5 py-0.5 text-[7.5px] font-bold tracking-wider text-center border-b border-white/20 tabular-nums"
            x-text="String(scrollPersen).padStart(2, '0') + '%'"
        >00%</span>
        @foreach ($babEditorial as $bab)
            <button
                type="button"
                @click="lompat(@js($bab['id']))"
                :title="@js($bab['no'] . ' / ' . $bab['judul'])"
                :class="babAktif === @js($bab['id'])
                    ? 'bg-[#18181B] text-[#FAF9F6]'
                    : 'text-[#18181B]/65 hover:text-[#18181B] hover:bg-black/5'"
                class="ed-mono px-1.5 py-1 text-[8.5px] font-bold tracking-wider border-b border-[#18181B]/15 last:border-b-0 transition-colors cursor-pointer"
            >
                {{ $bab['no'] }}
            </button>
        @endforeach
    </div>
</nav>
