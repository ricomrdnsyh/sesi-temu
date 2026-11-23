@if (! request()->boolean('embed'))
@php
    $slugIntro = $undangan->tema?->slug ?? 'rustic-floral';
    $inisialPriaIntro = $undangan->inisialPria();
    $inisialWanitaIntro = $undangan->inisialWanita();
    $acaraIntro = $acaraPertama ?? $undangan->acaraTerdekat();
    $tanggalIntro = $tanggalTitik ?? ($acaraIntro?->tanggal_acara?->format('d . m . y') ?? now()->format('d . m . y'));

    $daftarGayaIntro = [
        'adat-jawa' => [
            'bg' => 'radial-gradient(circle at 50% 42%, #392013 0%, #24130A 58%, #140904 100%)',
            'teks' => '#FFFBF4',
            'aksen' => '#E5C98B',
            'aksen_lembut' => 'rgba(229, 201, 139, 0.28)',
            'pendar' => 'rgba(229, 201, 139, 0.14)',
            'eyebrow' => 'Pawiwahan Ageng',
            'bismillah' => false,
            'tajam' => false,
            'nama_class' => 'font-serif text-[1.95rem] sm:text-[2.2rem] font-semibold tracking-[0.05em]',
        ],
        'sunda-heritage' => [
            'bg' => 'radial-gradient(circle at 50% 42%, #5C1D1D 0%, #3E1212 58%, #220909 100%)',
            'teks' => '#FFFDF8',
            'aksen' => '#E7C87D',
            'aksen_lembut' => 'rgba(231, 200, 125, 0.28)',
            'pendar' => 'rgba(231, 200, 125, 0.14)',
            'eyebrow' => 'Sampurasun · Walimatul Ursy',
            'bismillah' => false,
            'tajam' => false,
            'nama_class' => 'font-serif text-[1.95rem] sm:text-[2.2rem] font-semibold tracking-[0.04em]',
        ],
        'islami-syari' => [
            'bg' => 'radial-gradient(circle at 50% 42%, #F9FCF9 0%, #EEF6F1 58%, #DFECE4 100%)',
            'teks' => '#0E3A36',
            'aksen' => '#B38E43',
            'aksen_lembut' => 'rgba(179, 142, 67, 0.30)',
            'pendar' => 'rgba(179, 142, 67, 0.12)',
            'eyebrow' => 'Walimatul Ursy',
            'bismillah' => true,
            'tajam' => false,
            'nama_class' => 'font-serif text-[1.95rem] sm:text-[2.2rem] font-semibold tracking-[0.04em]',
        ],
        'islamic-heavenly' => [
            'bg' => 'radial-gradient(circle at 50% 42%, #142744 0%, #0B172A 58%, #050C17 100%)',
            'teks' => '#F4F8FF',
            'aksen' => '#E5C474',
            'aksen_lembut' => 'rgba(229, 196, 116, 0.28)',
            'pendar' => 'rgba(229, 196, 116, 0.14)',
            'eyebrow' => 'Walimatul Ursy',
            'bismillah' => true,
            'tajam' => false,
            'nama_class' => 'font-serif text-[1.95rem] sm:text-[2.2rem] font-semibold tracking-[0.05em]',
        ],
        'rustic-floral' => [
            'bg' => 'radial-gradient(circle at 50% 42%, #FDFBF7 0%, #F4ECE0 58%, #EAE0D0 100%)',
            'teks' => '#2F4037',
            'aksen' => '#9E7D44',
            'aksen_lembut' => 'rgba(75, 99, 88, 0.24)',
            'pendar' => 'rgba(191, 161, 95, 0.12)',
            'eyebrow' => 'The Wedding Of',
            'bismillah' => false,
            'tajam' => false,
            'nama_class' => 'font-serif text-[1.95rem] sm:text-[2.2rem] font-semibold tracking-[0.04em]',
        ],
        'velvet-garden' => [
            'bg' => 'radial-gradient(circle at 50% 42%, #213D3A 0%, #142926 58%, #0B1917 100%)',
            'teks' => '#F7FAF8',
            'aksen' => '#D8B776',
            'aksen_lembut' => 'rgba(216, 183, 118, 0.28)',
            'pendar' => 'rgba(216, 183, 118, 0.13)',
            'eyebrow' => 'The Wedding Of',
            'bismillah' => false,
            'tajam' => false,
            'nama_class' => 'font-serif text-[1.95rem] sm:text-[2.2rem] font-semibold tracking-[0.04em]',
        ],
        'luxury-noir' => [
            'bg' => 'radial-gradient(circle at 50% 42%, #191820 0%, #0D0D12 58%, #050507 100%)',
            'teks' => '#FAF3E0',
            'aksen' => '#D9B65A',
            'aksen_lembut' => 'rgba(217, 182, 90, 0.28)',
            'pendar' => 'rgba(217, 182, 90, 0.13)',
            'eyebrow' => 'The Grand Celebration',
            'bismillah' => false,
            'tajam' => false,
            'nama_class' => 'noir-font-judul font-serif text-[1.85rem] sm:text-[2.1rem] font-semibold uppercase tracking-[0.12em]',
        ],
        'royal-ivory' => [
            'bg' => 'radial-gradient(circle at 50% 42%, #FDFBF7 0%, #F4ECDE 58%, #E8DCC7 100%)',
            'teks' => '#3B2E25',
            'aksen' => '#9E7B4F',
            'aksen_lembut' => 'rgba(158, 123, 79, 0.28)',
            'pendar' => 'rgba(158, 123, 79, 0.11)',
            'eyebrow' => 'The Royal Wedding',
            'bismillah' => false,
            'tajam' => false,
            'nama_class' => 'font-serif text-[1.95rem] sm:text-[2.2rem] font-semibold tracking-[0.05em]',
        ],
        'editorial-monokrom' => [
            'bg' => 'linear-gradient(180deg, #121215 0%, #09090B 100%)',
            'teks' => '#FAF9F6',
            'aksen' => '#D4D4D8',
            'aksen_lembut' => 'rgba(250, 249, 246, 0.20)',
            'pendar' => 'rgba(255, 255, 255, 0.06)',
            'eyebrow' => 'Editorial Invitation',
            'bismillah' => false,
            'tajam' => true,
            'nama_class' => 'ed-serif font-serif text-[1.9rem] sm:text-[2.15rem] font-normal uppercase tracking-[0.14em]',
        ],
    ];

    $gayaIntro = $daftarGayaIntro[$slugIntro] ?? $daftarGayaIntro['rustic-floral'];
    $lebarKolomIntro = $lebarKolomIntro ?? 'lg:w-[460px] xl:w-[490px]';
    $durasiIntroMs = 3100;
    $durasiKeluarMs = 1350;
@endphp

<div
    data-intro-pembuka="{{ $slugIntro }}"
    data-intro-keluar="fade-halus"
    data-intro-durasi="{{ $durasiIntroMs }}"
    data-intro-keluar-ms="{{ $durasiKeluarMs }}"
    role="presentation"
    aria-hidden="true"
    class="intro-pembuka-tirai fixed inset-0 mx-auto h-dvh w-full {{ $lebarKolomIntro }} z-[45] cursor-pointer select-none overflow-hidden {{ !empty($tampilBarDemo) ? 'pt-28 sm:pt-20 lg:pt-14' : '' }}"
    style="height: 100dvh; --intro-aksen: {{ $gayaIntro['aksen'] }}; --intro-aksen-lembut: {{ $gayaIntro['aksen_lembut'] }}; color: {{ $gayaIntro['teks'] }};"
>
    {{-- INTRO SERAGAM CLEAN & ELEGAN UNTUK SELURUH TEMA --}}
    <div
        class="intro-seragam-panggung relative w-full h-full flex flex-col items-center justify-center overflow-hidden"
        style="background: {{ $gayaIntro['bg'] }};"
    >
        {{-- Pendar Cahaya Ambient Lembut Di Tengah --}}
        <div
            class="intro-pendar pointer-events-none absolute inset-0"
            style="background: radial-gradient(circle at 50% 46%, {{ $gayaIntro['pendar'] }} 0%, transparent 62%);"
        ></div>

        {{-- Bingkai Garis Tipis Minimalis Tunggal --}}
        <div
            class="intro-bingkai pointer-events-none absolute inset-5 {{ $gayaIntro['tajam'] ? 'rounded-none' : 'rounded-[1.5rem]' }} border"
            style="border-color: var(--intro-aksen-lembut);"
        ></div>

        {{-- Konten Tipografi Tengah Yang Tenang & Bersih --}}
        <div class="intro-pusat relative z-20 px-8 text-center flex flex-col items-center justify-center max-w-[330px]">
            {{-- Tahap 1: Aksen Garis Berlian + Basmalah (Tema Islami) + Eyebrow --}}
            <div class="intro-tahap-1 flex flex-col items-center space-y-2">
                <div class="flex items-center justify-center gap-2.5" aria-hidden="true">
                    <span class="h-px w-8" style="background: linear-gradient(90deg, transparent, var(--intro-aksen));"></span>
                    <span class="h-1.5 w-1.5 rotate-45" style="background: var(--intro-aksen);"></span>
                    <span class="h-px w-8" style="background: linear-gradient(270deg, transparent, var(--intro-aksen));"></span>
                </div>

                @if ($gayaIntro['bismillah'])
                    <p class="text-base sm:text-lg pt-0.5" style="font-family: 'Amiri', serif; color: var(--intro-aksen);">
                        بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                    </p>
                @endif

                <p class="text-[9.5px] sm:text-[10px] font-semibold uppercase tracking-[0.38em]" style="color: var(--intro-aksen);">
                    {{ $gayaIntro['eyebrow'] }}
                </p>
            </div>

            {{-- Tahap 2: Medali Monogram Garis Tipis Timeless --}}
            <div class="intro-tahap-2 my-6 flex items-center justify-center">
                <div
                    class="relative h-24 w-24 {{ $gayaIntro['tajam'] ? 'rounded-none' : 'rounded-full' }} border flex items-center justify-center"
                    style="border-color: var(--intro-aksen-lembut);"
                >
                    <span
                        aria-hidden="true"
                        class="absolute inset-2 {{ $gayaIntro['tajam'] ? 'rounded-none' : 'rounded-full' }} border opacity-45"
                        style="border-color: var(--intro-aksen);"
                    ></span>
                    <div class="relative z-10 flex items-baseline gap-1.5 font-serif text-[2rem] font-semibold tracking-wider leading-none">
                        <span>{{ $inisialPriaIntro }}</span>
                        <span class="font-kaligrafi text-[1.65rem] font-normal" style="color: var(--intro-aksen);">&amp;</span>
                        <span>{{ $inisialWanitaIntro }}</span>
                    </div>
                </div>
            </div>

            {{-- Tahap 3: Nama Mempelai (Pria dari Kiri, & Mekar, Wanita dari Kanan) + Garis Halus + Tanggal --}}
            <div class="space-y-2.5">
                <p class="{{ $gayaIntro['nama_class'] }} leading-tight flex flex-wrap items-baseline justify-center gap-x-1.5">
                    <span class="intro-nama-pria inline-block">{{ $undangan->nama_panggilan_pria }}</span>
                    <span class="intro-nama-amp inline-block font-kaligrafi normal-case font-normal" style="color: var(--intro-aksen);">&amp;</span>
                    <span class="intro-nama-wanita inline-block">{{ $undangan->nama_panggilan_wanita }}</span>
                </p>

                <div
                    class="intro-garis mx-auto h-px w-24"
                    style="background: linear-gradient(90deg, transparent, var(--intro-aksen), transparent);"
                ></div>

                <p class="intro-tanggal text-[10px] font-medium uppercase tracking-[0.34em]">
                    <span class="opacity-78">{{ $tanggalIntro }}</span>
                </p>
            </div>
        </div>

        {{-- Petunjuk Halus Lewati --}}
        <span class="intro-petunjuk pointer-events-none absolute bottom-7 z-20 text-[9px] uppercase tracking-[0.28em]">
            <span class="opacity-45">Ketuk untuk melewati</span>
        </span>
    </div>
</div>

<script>
    (function () {
        const el = document.querySelector('[data-intro-pembuka]');
        if (!el) return;

        const kurangiGerak = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (kurangiGerak) {
            el.style.display = 'none';
            return;
        }

        const durasiOtomatis = Number.parseInt(el.dataset.introDurasi || '3100', 10) || 3100;
        const durasiKeluar = Number.parseInt(el.dataset.introKeluarMs || '1350', 10) || 1350;
        const dalamIframe = window.self !== window.top;

        let sudahMulai = false;
        let selesai = false;
        let timerOtomatis = null;
        let timerMulaiFallback = null;

        function tutupIntro() {
            if (selesai) return;
            selesai = true;
            if (timerOtomatis) {
                window.clearTimeout(timerOtomatis);
                timerOtomatis = null;
            }
            if (timerMulaiFallback) {
                window.clearTimeout(timerMulaiFallback);
                timerMulaiFallback = null;
            }
            el.classList.add('intro-keluar');
            window.setTimeout(() => {
                el.classList.add('intro-selesai');
                el.style.display = 'none';
            }, durasiKeluar);
        }

        function mulaiIntro() {
            if (sudahMulai || selesai) return;
            sudahMulai = true;
            if (timerMulaiFallback) {
                window.clearTimeout(timerMulaiFallback);
                timerMulaiFallback = null;
            }
            window.requestAnimationFrame(() => {
                window.requestAnimationFrame(() => {
                    if (selesai) return;
                    el.classList.add('intro-mulai');
                    timerOtomatis = window.setTimeout(tutupIntro, durasiOtomatis);
                });
            });
        }

        el.addEventListener('click', tutupIntro, { once: true });

        if (dalamIframe) {
            // Tunggu iframe selesai dimuat + jeda singkat agar overlay spinner pratinjau memudar dulu
            const jadwalkanSetelahLoad = () => window.setTimeout(mulaiIntro, 260);
            if (document.readyState === 'complete') {
                jadwalkanSetelahLoad();
            } else {
                window.addEventListener('load', jadwalkanSetelahLoad, { once: true });
            }
            timerMulaiFallback = window.setTimeout(mulaiIntro, 1400);
        } else {
            // Kunjungan langsung: mulai segera setelah font/DOM siap agar setiap tahap terlihat utuh dari awal
            const jalankanLangsung = () => mulaiIntro();
            if (document.fonts && document.fonts.ready) {
                document.fonts.ready.then(jalankanLangsung).catch(jalankanLangsung);
                timerMulaiFallback = window.setTimeout(jalankanLangsung, 320);
            } else if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', jalankanLangsung, { once: true });
                timerMulaiFallback = window.setTimeout(jalankanLangsung, 320);
            } else {
                jalankanLangsung();
            }
        }
    })();
</script>
@endif
