@props([
    'varian' => 'noir',
    'tanpaFoto' => false,
])

@php
    $adalahNoir = $varian === 'noir';

    $kelasKapsul = $adalahNoir
        ? 'bg-[#0E0D14]/94 border-[#D4AF37]/55 text-[#F5EFE6] shadow-[0_18px_42px_-10px_rgba(0,0,0,0.88)]'
        : 'bg-[#FBF8F3]/96 border-[#9E7B4F]/55 text-[#3B2E25] shadow-[0_18px_38px_-10px_rgba(59,46,37,0.34)]';

    $kelasAktif = $adalahNoir
        ? 'bg-gradient-to-b from-[#F3E5AB] via-[#D4AF37] to-[#B88F28] text-[#0B0B0F] shadow-sm'
        : 'bg-gradient-to-b from-[#8B6B43] via-[#6E5436] to-[#58432B] text-[#FAF6EE] shadow-sm';

    $kelasNonAktif = $adalahNoir
        ? 'text-[#F5EFE6]/76 hover:text-[#F3E5AB] hover:bg-white/6'
        : 'text-[#3B2E25]/74 hover:text-[#3B2E25] hover:bg-[#9E7B4F]/10';

    $daftarMenu = array_values(array_filter([
        ['id' => 'elegan-mempelai', 'label' => 'Mempelai', 'ikon' => 'mempelai'],
        ['id' => 'elegan-tanggal', 'label' => 'Tanggal', 'ikon' => 'tanggal'],
        ['id' => 'elegan-acara', 'label' => 'Acara', 'ikon' => 'acara'],
        ! $tanpaFoto ? ['id' => 'elegan-galeri', 'label' => 'Galeri', 'ikon' => 'galeri'] : null,
        ['id' => 'elegan-amplop', 'label' => 'Amplop', 'ikon' => 'amplop'],
        ['id' => 'buku-tamu', 'label' => 'RSVP', 'ikon' => 'rsvp'],
    ]));

    $kelasGridKolom = count($daftarMenu) === 5 ? 'grid-cols-5' : 'grid-cols-6';
@endphp

<nav
    data-nav-elegan="{{ $varian }}"
    aria-label="Navigasi Cepat Undangan"
    x-show="undanganTerbuka && !galeriModalTerbuka"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-data="{
        aktifId: 'elegan-mempelai',
        sedangLompat: false,
        timerLompat: null,
        daftarId: @js(array_column($daftarMenu, 'id')),
        pantau() {
            if (this.sedangLompat) {
                return;
            }
            const vh = window.innerHeight || 760;
            const yBaca = (window.scrollY || window.pageYOffset || 0) + vh * 0.38;
            let terpilih = this.daftarId[0] || '';

            for (const id of this.daftarId) {
                const el = document.getElementById(id);
                if (!el) continue;

                const yAlami = Number(el.dataset.yAlami || '');
                if (Number.isFinite(yAlami) && el.dataset.yAlami !== undefined && el.dataset.yAlami !== '') {
                    if (yBaca >= yAlami - 24) {
                        terpilih = id;
                    }
                } else {
                    const rect = el.getBoundingClientRect();
                    if (rect.top <= vh * 0.42) {
                        terpilih = id;
                    }
                }
            }
            this.aktifId = terpilih;
        },
        init() {
            window.addEventListener('scroll', () => this.pantau(), { passive: true });
            window.setTimeout(() => this.pantau(), 450);
        },
        lompatKe(id) {
            this.aktifId = id;
            this.sedangLompat = true;
            if (this.timerLompat) {
                window.clearTimeout(this.timerLompat);
            }
            this.timerLompat = window.setTimeout(() => {
                this.sedangLompat = false;
                this.pantau();
            }, 1000);

            if (window.SesiTemuSinema?.gulirKeSeksi) {
                window.SesiTemuSinema.gulirKeSeksi('#' + id);
                return;
            }
            const target = document.getElementById(id);
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    }"
    class="fixed bottom-3 inset-x-0 mx-auto w-[calc(100%-1.5rem)] max-w-[388px] z-40 pointer-events-auto select-none"
>
    <div class="grid {{ $kelasGridKolom }} items-center gap-0.5 rounded-2xl border backdrop-blur-md p-1 {{ $kelasKapsul }}">
        @foreach ($daftarMenu as $menu)
            <button
                type="button"
                @click="lompatKe(@js($menu['id']))"
                :class="aktifId === @js($menu['id']) ? @js($kelasAktif) : @js($kelasNonAktif)"
                class="min-w-0 flex flex-col items-center justify-center gap-0.5 rounded-xl px-1 py-1.5 text-[9.5px] leading-tight font-semibold tracking-tight transition-all duration-200 cursor-pointer"
            >
                @switch($menu['ikon'])
                    @case('mempelai')
                        <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                        </svg>
                        @break
                    @case('tanggal')
                        <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 7v5l3 2"/>
                        </svg>
                        @break
                    @case('acara')
                        <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect width="18" height="18" x="3" y="4" rx="2"/>
                            <path d="M16 2v4M8 2v4M3 10h18"/>
                        </svg>
                        @break
                    @case('galeri')
                        <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect width="18" height="18" x="3" y="3" rx="2"/>
                            <circle cx="9" cy="9" r="2"/>
                            <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                        </svg>
                        @break
                    @case('amplop')
                        <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="3" y="8" width="18" height="4" rx="1"/>
                            <path d="M12 8v13M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"/>
                        </svg>
                        @break
                    @default
                        <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                @endswitch
                <span class="truncate max-w-full">{{ $menu['label'] }}</span>
            </button>
        @endforeach
    </div>
</nav>
