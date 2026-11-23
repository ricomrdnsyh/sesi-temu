@php
    $tanpaFoto = $undangan->modeTanpaFoto();
    $ogJudul = 'Pratinjau '.$tema->nama_tema.' — SesiTemu';
    $ogDeskripsi = 'Pratinjau live demo tema '.$tema->nama_tema.' — The Wedding of '.$undangan->nama_panggilan_pria.' & '.$undangan->nama_panggilan_wanita.'.';
    $ogGambar = $tanpaFoto
        ? ($tema->urlGambarPratinjau() ?? asset('aset-demo/tema-rustic-floral.webp'))
        : ($undangan->urlFotoSampul() ?? ($tema->urlGambarPratinjau() ?? asset('aset-demo/tema-rustic-floral.webp')));
@endphp

<!DOCTYPE html>
<html lang="id" class="h-full overflow-hidden">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $ogJudul }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">
    <meta name="description" content="{{ $ogDeskripsi }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $ogJudul }}">
    <meta property="og:description" content="{{ $ogDeskripsi }}">
    <meta property="og:image" content="{{ $ogGambar }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $ogJudul }}">
    <meta name="twitter:description" content="{{ $ogDeskripsi }}">
    <meta name="twitter:image" content="{{ $ogGambar }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Latar Galeri Studio SesiTemu (Beda dari latar polos biasa: grid titik champagne + pendar lembut) */
        .studio-kanvas-sesitemu {
            background-color: #F5F1E8;
            background-image:
                radial-gradient(circle at 14% 18%, rgba(191, 161, 95, 0.14) 0%, transparent 42%),
                radial-gradient(circle at 86% 84%, rgba(75, 99, 88, 0.11) 0%, transparent 44%),
                radial-gradient(rgba(191, 161, 95, 0.22) 1px, transparent 1px);
            background-size: 100% 100%, 100% 100%, 24px 24px;
            background-position: 0 0, 0 0, 12px 12px;
        }

        /* Default Mobile Asli (< 768px tanpa zoom): langsung layar penuh tanpa bingkai & header */
        [data-shell-pratinjau] {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100dvh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        [data-bar-pratinjau-perangkat] {
            display: none;
        }

        [data-stage-pratinjau] {
            flex: 1 1 0%;
            min-height: 0;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            overflow: hidden;
        }

        [data-slot-bingkai] {
            position: relative;
            width: 100%;
            height: 100%;
            flex-shrink: 0;
        }

        [data-bingkai-pratinjau] {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: #FFFFFF;
            transition:
                width 0.34s cubic-bezier(0.22, 1, 0.36, 1),
                height 0.34s cubic-bezier(0.22, 1, 0.36, 1),
                transform 0.34s cubic-bezier(0.22, 1, 0.36, 1),
                border-radius 0.34s cubic-bezier(0.22, 1, 0.36, 1),
                padding 0.34s cubic-bezier(0.22, 1, 0.36, 1),
                box-shadow 0.34s cubic-bezier(0.22, 1, 0.36, 1),
                background-color 0.25s ease;
        }

        [data-layar-bingkai] {
            position: relative;
            flex: 1 1 0%;
            min-height: 0;
            width: 100%;
            overflow: hidden;
            background: #1F2937;
            contain: layout paint;
            transition: border-radius 0.34s cubic-bezier(0.22, 1, 0.36, 1);
        }

        [data-aksen-bezel-hp],
        [data-aksen-bezel-tablet],
        [data-chrome-desktop] {
            display: none;
        }

        /* === STUDIO ANTI-ZOOM (TABLET & DESKTOP >= 768px — KEBAL ZOOM IN / ZOOM OUT BROWSER) === */
        html.pratinjau-anti-zoom [data-shell-pratinjau] {
            inset: auto;
            top: 0;
            left: 0;
            width: var(--pz-w, 100vw);
            height: var(--pz-h, 100dvh);
            transform: var(--pz-transform, none);
            transform-origin: top left;
        }

        html.pratinjau-anti-zoom [data-bar-pratinjau-perangkat] {
            display: flex !important;
        }

        html.pratinjau-anti-zoom [data-stage-pratinjau] {
            padding: var(--pz-stage-py, 18px) var(--pz-stage-px, 24px);
        }

        html.pratinjau-anti-zoom [data-slot-bingkai] {
            transition:
                width 0.34s cubic-bezier(0.22, 1, 0.36, 1),
                height 0.34s cubic-bezier(0.22, 1, 0.36, 1);
        }

        html.pratinjau-anti-zoom [data-bingkai-pratinjau] {
            position: absolute;
            top: 0;
            left: 0;
            transform-origin: top left;
        }

        /* 1. Mode Handphone: Chassis Obsidian Titanium + Aksen Speaker Rim + Layar 390px */
        html.pratinjau-anti-zoom [data-slot-bingkai][data-mode="handphone"] {
            width: var(--pz-phone-vis-w, 408px);
            height: var(--pz-phone-vis-h, 820px);
        }

        html.pratinjau-anti-zoom [data-bingkai-pratinjau][data-mode="handphone"] {
            width: var(--pz-phone-w, 408px);
            height: var(--pz-phone-h, 820px);
            transform: var(--pz-phone-transform, none);
            padding: 9px;
            border-radius: 2.85rem;
            background: linear-gradient(165deg, #2D3542 0%, #1C232D 52%, #131820 100%);
            box-shadow:
                0 34px 72px -18px rgba(17, 24, 39, 0.42),
                0 12px 26px -10px rgba(17, 24, 39, 0.2),
                0 0 0 1px rgba(191, 161, 95, 0.45),
                inset 0 1px 0 rgba(255, 255, 255, 0.16);
        }

        html.pratinjau-anti-zoom [data-bingkai-pratinjau][data-mode="handphone"] [data-layar-bingkai] {
            border-radius: 2.25rem;
        }

        html.pratinjau-anti-zoom [data-bingkai-pratinjau][data-mode="handphone"] [data-aksen-bezel-hp] {
            display: flex;
        }

        /* 2. Mode Tablet: Chassis Slate-Champagne + Layar 768px (Portrait Tengah + Sayap Artwork) */
        html.pratinjau-anti-zoom [data-slot-bingkai][data-mode="tablet"] {
            width: var(--pz-tablet-vis-w, 790px);
            height: var(--pz-tablet-vis-h, 860px);
        }

        html.pratinjau-anti-zoom [data-bingkai-pratinjau][data-mode="tablet"] {
            width: var(--pz-tablet-w, 790px);
            height: var(--pz-tablet-h, 860px);
            transform: var(--pz-tablet-transform, none);
            padding: 11px;
            border-radius: 2.05rem;
            background: linear-gradient(165deg, #2A323F 0%, #1B222C 55%, #141922 100%);
            box-shadow:
                0 34px 74px -18px rgba(17, 24, 39, 0.4),
                0 12px 26px -10px rgba(17, 24, 39, 0.18),
                0 0 0 1px rgba(191, 161, 95, 0.42),
                inset 0 1px 0 rgba(255, 255, 255, 0.14);
        }

        html.pratinjau-anti-zoom [data-bingkai-pratinjau][data-mode="tablet"] [data-layar-bingkai] {
            border-radius: 1.4rem;
        }

        html.pratinjau-anti-zoom [data-bingkai-pratinjau][data-mode="tablet"] [data-aksen-bezel-tablet] {
            display: flex;
        }

        /* 3. Mode Desktop: Jendela Studio Browser SesiTemu Berbingkai Elegan (Triptych 3-Kolom) */
        html.pratinjau-anti-zoom [data-slot-bingkai][data-mode="desktop"] {
            width: var(--pz-desktop-vis-w, 1280px);
            height: var(--pz-desktop-vis-h, 780px);
        }

        html.pratinjau-anti-zoom [data-bingkai-pratinjau][data-mode="desktop"] {
            width: var(--pz-desktop-w, 1280px);
            height: var(--pz-desktop-h, 780px);
            transform: var(--pz-desktop-transform, none);
            padding: 0;
            border-radius: 1.25rem;
            background: #FDFBF7;
            box-shadow:
                0 36px 80px -20px rgba(17, 24, 39, 0.32),
                0 14px 30px -12px rgba(17, 24, 39, 0.14),
                0 0 0 1px rgba(191, 161, 95, 0.36);
        }

        html.pratinjau-anti-zoom [data-bingkai-pratinjau][data-mode="desktop"] [data-layar-bingkai] {
            border-radius: 0 0 1.25rem 1.25rem;
        }

        html.pratinjau-anti-zoom [data-bingkai-pratinjau][data-mode="desktop"] [data-chrome-desktop] {
            display: flex;
        }
    </style>

    <script>
        (function () {
            const root = document.documentElement;
            const KUNCI_OS_DPR = 'sesitemu_os_dpr_v1';

            function hitungSkalaOs(dpr, lebarLuar, lebarDalam) {
                if (lebarLuar > 0 && lebarDalam > 0) {
                    const rasioLuar = lebarLuar / lebarDalam;
                    if (Math.abs(rasioLuar - 1) <= 0.03) {
                        return dpr;
                    }
                    const estimasi = dpr / rasioLuar;
                    const dibulatkan = Math.round(estimasi * 4) / 4;
                    if (dibulatkan >= 1 && dibulatkan <= 3 && Math.abs(estimasi - dibulatkan) <= 0.14) {
                        return dibulatkan;
                    }
                }
                return null;
            }

            function ambilSkalaOs(dpr, lebarLuar, lebarDalam) {
                const terhitung = hitungSkalaOs(dpr, lebarLuar, lebarDalam);
                if (terhitung !== null) {
                    try {
                        sessionStorage.setItem(KUNCI_OS_DPR, String(terhitung));
                    } catch (e) {}
                    return terhitung;
                }
                try {
                    const tersimpan = Number.parseFloat(sessionStorage.getItem(KUNCI_OS_DPR) || '');
                    if (Number.isFinite(tersimpan) && tersimpan >= 1 && tersimpan <= 3) {
                        return tersimpan;
                    }
                } catch (e) {}
                return 1;
            }

            function kunciSkalaPratinjau() {
                const lebarDalam = window.innerWidth || root.clientWidth || 0;
                const tinggiDalam = window.innerHeight || root.clientHeight || 0;
                const dpr = window.devicePixelRatio || 1;

                let lebarLuar = window.outerWidth || 0;
                const availW = window.screen && window.screen.availWidth ? window.screen.availWidth : 0;
                if (availW > 0 && lebarLuar > availW && lebarLuar - availW <= 32) {
                    lebarLuar = availW;
                }

                const osDpr = ambilSkalaOs(dpr, lebarLuar, lebarDalam);
                let browserZoom = osDpr > 0 ? dpr / osDpr : 1;
                if (Math.abs(browserZoom - 1) < 0.015) {
                    browserZoom = 1;
                }
                browserZoom = Math.max(0.25, Math.min(4, browserZoom));

                const lebarTanpaZoom = lebarDalam * browserZoom;
                const tinggiTanpaZoom = tinggiDalam * browserZoom;

                if (lebarTanpaZoom >= 768) {
                    const invZoom = Number((1 / browserZoom).toFixed(5));
                    const tinggiHeader = 64;
                    const padY = tinggiTanpaZoom < 760 ? 12 : 18;
                    const padX = lebarTanpaZoom < 960 ? 16 : 24;
                    const ruangLebar = Math.max(200, lebarTanpaZoom - padX * 2);
                    const ruangTinggi = Math.max(160, tinggiTanpaZoom - tinggiHeader - padY * 2);

                    function hitungDimensiPerangkat(lebarLogis, tinggiMinLogis, tinggiMaksLogis) {
                        const tinggiLogis = Math.round(Math.min(tinggiMaksLogis, Math.max(tinggiMinLogis, ruangTinggi)));
                        const skalaMentah = Math.min(1, ruangLebar / lebarLogis, ruangTinggi / tinggiLogis);
                        const skala = skalaMentah >= 0.995 ? 1 : Number(skalaMentah.toFixed(5));
                        return {
                            w: lebarLogis,
                            h: tinggiLogis,
                            visW: Number((lebarLogis * skala).toFixed(2)),
                            visH: Number((tinggiLogis * skala).toFixed(2)),
                            transform: skala === 1 ? 'none' : `scale(${skala})`,
                        };
                    }

                    // Pertahankan rasio perangkat sejati (HP 390px, Tablet 768px, Desktop >=1280px) lalu skalakan proporsional di layar pendek (laptop)
                    const phone = hitungDimensiPerangkat(408, 800, 844);
                    const tablet = hitungDimensiPerangkat(790, 840, 920);
                    const lebarDesktopLogis = Math.min(1320, Math.max(1280, Math.round(lebarTanpaZoom - 88)));
                    const desktop = hitungDimensiPerangkat(lebarDesktopLogis, 760, 820);

                    root.classList.add('pratinjau-anti-zoom');
                    root.style.setProperty('--pz-w', `${lebarTanpaZoom.toFixed(2)}px`);
                    root.style.setProperty('--pz-h', `${tinggiTanpaZoom.toFixed(2)}px`);
                    root.style.setProperty('--pz-transform', browserZoom === 1 ? 'none' : `scale(${invZoom})`);
                    root.style.setProperty('--pz-stage-py', `${padY}px`);
                    root.style.setProperty('--pz-stage-px', `${padX}px`);
                    root.style.setProperty('--pz-phone-w', `${phone.w}px`);
                    root.style.setProperty('--pz-phone-h', `${phone.h}px`);
                    root.style.setProperty('--pz-phone-vis-w', `${phone.visW}px`);
                    root.style.setProperty('--pz-phone-vis-h', `${phone.visH}px`);
                    root.style.setProperty('--pz-phone-transform', phone.transform);
                    root.style.setProperty('--pz-tablet-w', `${tablet.w}px`);
                    root.style.setProperty('--pz-tablet-h', `${tablet.h}px`);
                    root.style.setProperty('--pz-tablet-vis-w', `${tablet.visW}px`);
                    root.style.setProperty('--pz-tablet-vis-h', `${tablet.visH}px`);
                    root.style.setProperty('--pz-tablet-transform', tablet.transform);
                    root.style.setProperty('--pz-desktop-w', `${desktop.w}px`);
                    root.style.setProperty('--pz-desktop-h', `${desktop.h}px`);
                    root.style.setProperty('--pz-desktop-vis-w', `${desktop.visW}px`);
                    root.style.setProperty('--pz-desktop-vis-h', `${desktop.visH}px`);
                    root.style.setProperty('--pz-desktop-transform', desktop.transform);
                } else {
                    root.classList.remove('pratinjau-anti-zoom');
                    [
                        '--pz-w',
                        '--pz-h',
                        '--pz-transform',
                        '--pz-stage-py',
                        '--pz-stage-px',
                        '--pz-phone-w',
                        '--pz-phone-h',
                        '--pz-phone-vis-w',
                        '--pz-phone-vis-h',
                        '--pz-phone-transform',
                        '--pz-tablet-w',
                        '--pz-tablet-h',
                        '--pz-tablet-vis-w',
                        '--pz-tablet-vis-h',
                        '--pz-tablet-transform',
                        '--pz-desktop-w',
                        '--pz-desktop-h',
                        '--pz-desktop-vis-w',
                        '--pz-desktop-vis-h',
                        '--pz-desktop-transform',
                    ].forEach((prop) => root.style.removeProperty(prop));
                }
            }

            kunciSkalaPratinjau();
            window.addEventListener('resize', kunciSkalaPratinjau, { passive: true });
            window.addEventListener('load', kunciSkalaPratinjau);
            if (window.visualViewport) {
                window.visualViewport.addEventListener('resize', kunciSkalaPratinjau, { passive: true });
            }

            let mediaDpr = null;
            function pantauDpr() {
                if (mediaDpr && mediaDpr.removeEventListener) {
                    mediaDpr.removeEventListener('change', saatDprBerubah);
                }
                if (window.matchMedia) {
                    mediaDpr = window.matchMedia(`(resolution: ${window.devicePixelRatio}dppx)`);
                    if (mediaDpr.addEventListener) {
                        mediaDpr.addEventListener('change', saatDprBerubah);
                    }
                }
            }
            function saatDprBerubah() {
                kunciSkalaPratinjau();
                pantauDpr();
            }
            pantauDpr();
        })();
    </script>
</head>

<body
    x-data="{
        perangkat: @js($modePerangkat ?? 'handphone'),
        kanvasSiap: false,
        init() {
            const frame = this.$refs.kanvasFrame;
            try {
                if (frame && frame.contentDocument && frame.contentDocument.readyState === 'complete' && frame.contentWindow && frame.contentWindow.location.href !== 'about:blank') {
                    this.kanvasSiap = true;
                }
            } catch (e) {}
            window.setTimeout(() => {
                this.kanvasSiap = true;
            }, 1600);
        },
        pilihPerangkat(mode) {
            this.perangkat = mode;
        },
        muatUlangKanvas() {
            const frame = this.$refs.kanvasFrame;
            if (!frame) return;
            this.kanvasSiap = false;
            try {
                frame.contentWindow.location.reload();
            } catch (e) {
                frame.src = frame.src;
            }
            window.setTimeout(() => {
                this.kanvasSiap = true;
            }, 1800);
        },
        labelDimensi() {
            if (this.perangkat === 'tablet') return '768 px';
            if (this.perangkat === 'desktop') return 'Desktop';
            return '390 px';
        }
    }"
    class="h-dvh w-screen overflow-hidden bg-[#F5F1E8] text-charcoal antialiased select-none"
>
    <div data-shell-pratinjau class="studio-kanvas-sesitemu">
        {{-- STUDIO TOP BAR KHAS SESITEMU (BERSIH, ELEGAN, ANTI-ZOOM) --}}
        <header
            data-bar-pratinjau-perangkat
            class="shrink-0 h-16 items-center justify-between gap-4 border-b border-[#BFA15F]/22 bg-[#FDFBF7]/98 px-6 lg:px-8 z-30 shadow-[0_1px_0_rgba(255,255,255,0.75)]"
        >
            {{-- Kiri: Identitas SesiTemu + Nama Tema & Tier --}}
            <div class="flex items-center gap-3 min-w-0">
                <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-charcoal ring-1 ring-[#BFA15F]/45 shadow-xs">
                    <img src="{{ asset('logo/logo-ikon-gelap.webp') }}" alt="SesiTemu" class="h-5 w-5 object-contain brightness-0 invert opacity-95">
                </span>
                <div class="min-w-0">
                    <div class="flex items-center gap-2">
                        <p class="text-[9.5px] font-semibold uppercase tracking-[0.24em] text-[#8E7342] leading-none">
                            Pratinjau Tema
                        </p>
                        <span class="inline-block h-1 w-1 rounded-full bg-[#BFA15F]/70" aria-hidden="true"></span>
                        <span class="text-[9.5px] font-semibold uppercase tracking-[0.16em] text-charcoal/50 leading-none">
                            {{ $tema->kategoriLabel() }}
                        </span>
                    </div>
                    <h1 class="mt-1 font-logo text-[16px] font-bold text-charcoal leading-tight truncate">
                        {{ $tema->nama_tema }}
                    </h1>
                </div>
            </div>

            {{-- Tengah: Pengalih Perangkat Kapsul Charcoal-Champagne Khas SesiTemu --}}
            <nav
                aria-label="Pilih ukuran tampilan pratinjau"
                class="inline-flex items-center gap-1 rounded-full bg-[#EFEAE0] p-1 border border-[#BFA15F]/25 shadow-inner"
            >
                <button
                    type="button"
                    @click="pilihPerangkat('handphone')"
                    :aria-pressed="perangkat === 'handphone'"
                    :class="perangkat === 'handphone'
                        ? 'bg-charcoal text-[#F3E5AB] shadow-sm'
                        : 'text-charcoal/65 hover:text-charcoal'"
                    class="inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-xs font-medium transition-colors duration-100 cursor-pointer"
                >
                    <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect width="12" height="20" x="6" y="2" rx="2.5" />
                        <path d="M12 18h.01" />
                    </svg>
                    <span>Handphone</span>
                </button>

                <button
                    type="button"
                    @click="pilihPerangkat('tablet')"
                    :aria-pressed="perangkat === 'tablet'"
                    :class="perangkat === 'tablet'
                        ? 'bg-charcoal text-[#F3E5AB] shadow-sm'
                        : 'text-charcoal/65 hover:text-charcoal'"
                    class="inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-xs font-medium transition-colors duration-100 cursor-pointer"
                >
                    <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect width="16" height="20" x="4" y="2" rx="2.5" />
                        <path d="M12 18h.01" />
                    </svg>
                    <span>Tablet</span>
                </button>

                <button
                    type="button"
                    @click="pilihPerangkat('desktop')"
                    :aria-pressed="perangkat === 'desktop'"
                    :class="perangkat === 'desktop'
                        ? 'bg-charcoal text-[#F3E5AB] shadow-sm'
                        : 'text-charcoal/65 hover:text-charcoal'"
                    class="inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-xs font-medium transition-colors duration-100 cursor-pointer"
                >
                    <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect width="20" height="14" x="2" y="3" rx="2" />
                        <path d="M8 21h8" />
                        <path d="M12 17v4" />
                    </svg>
                    <span>Desktop</span>
                </button>
            </nav>

            {{-- Kanan: Lencana Dimensi Ringkas + Tombol Muat Ulang Pratinjau --}}
            <div class="flex items-center gap-2 shrink-0">
                <span
                    class="inline-flex items-center gap-1.5 rounded-full border border-[#BFA15F]/28 bg-white/80 px-3 py-1 text-[11px] font-medium tabular-nums text-charcoal/70"
                >
                    <span class="h-1.5 w-1.5 rounded-full bg-sage" aria-hidden="true"></span>
                    <span x-text="labelDimensi()">390 px</span>
                </span>

                <button
                    type="button"
                    @click="muatUlangKanvas()"
                    title="Muat ulang pratinjau dari sampul"
                    aria-label="Muat ulang pratinjau dari sampul"
                    class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-[#BFA15F]/30 bg-white/85 text-charcoal/70 hover:bg-charcoal hover:text-[#F3E5AB] hover:border-charcoal active:scale-95 transition-colors duration-100 cursor-pointer"
                >
                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M3 12a9 9 0 1 0 3-6.7L3 8" />
                        <path d="M3 3v5h5" />
                    </svg>
                </button>
            </div>
        </header>

        {{-- PANGGUNG PRATINJAU BERBINGKAI PERANGKAT (HANDPHONE / TABLET / DESKTOP) --}}
        <main data-stage-pratinjau>
            <div
                data-slot-bingkai
                data-mode="{{ $modePerangkat ?? 'handphone' }}"
                :data-mode="perangkat"
            >
                <div
                    data-bingkai-pratinjau
                    data-mode="{{ $modePerangkat ?? 'handphone' }}"
                    :data-mode="perangkat"
                >
                {{-- Aksen Speaker Halus Di Tepi Atas Bezel Handphone --}}
                <div
                    data-aksen-bezel-hp
                    aria-hidden="true"
                    class="pointer-events-none absolute top-[3px] left-1/2 -translate-x-1/2 z-20 items-center justify-center gap-1.5"
                >
                    <span class="h-[3px] w-12 rounded-full bg-white/15"></span>
                    <span class="h-[4px] w-[4px] rounded-full bg-[#BFA15F]/45"></span>
                </div>

                {{-- Aksen Kamera Halus Di Tepi Atas Bezel Tablet --}}
                <div
                    data-aksen-bezel-tablet
                    aria-hidden="true"
                    class="pointer-events-none absolute top-[4px] left-1/2 -translate-x-1/2 z-20 items-center justify-center"
                >
                    <span class="h-[4px] w-[4px] rounded-full bg-[#BFA15F]/50 ring-1 ring-white/15"></span>
                </div>

                {{-- Titlebar Jendela Browser Studio Khusus Mode Desktop --}}
                <div
                    data-chrome-desktop
                    aria-hidden="true"
                    class="shrink-0 h-9 items-center justify-between gap-4 border-b border-[#BFA15F]/20 bg-gradient-to-b from-[#FFFFFF] to-[#F8F5EE] px-4"
                >
                    <div class="flex items-center gap-1.5">
                        <span class="h-2.5 w-2.5 rounded-full bg-[#D7BB83]/85"></span>
                        <span class="h-2.5 w-2.5 rounded-full bg-[#4B6358]/55"></span>
                        <span class="h-2.5 w-2.5 rounded-full bg-[#1F2937]/25"></span>
                    </div>

                    <div class="inline-flex items-center gap-1.5 rounded-full border border-[#BFA15F]/25 bg-white/90 px-3.5 py-0.5 text-[10.5px] font-medium text-charcoal/65 shadow-2xs">
                        <svg class="h-3 w-3 text-sage" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                        <span>sesitemu.id/{{ $tema->slug }}</span>
                    </div>

                    <div class="flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-[0.18em] text-charcoal/45">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        <span>Live</span>
                    </div>
                </div>

                {{-- Layar Kanvas Undangan Interaktif --}}
                <div data-layar-bingkai>
                    <div
                        x-show="!kanvasSiap"
                        x-transition.opacity.duration.300ms
                        aria-hidden="true"
                        class="pointer-events-none absolute inset-0 z-10 flex flex-col items-center justify-center gap-3 bg-[#F6F3EC]"
                    >
                        <span class="h-8 w-8 rounded-full border-2 border-champagne/30 border-t-champagne animate-spin"></span>
                        <span class="text-[11px] font-medium tracking-wider uppercase text-charcoal/50">Memuat Pratinjau...</span>
                    </div>

                    <iframe
                        x-ref="kanvasFrame"
                        data-kanvas-demo
                        src="{{ $urlKanvas }}"
                        title="Pratinjau {{ $tema->nama_tema }}"
                        allow="autoplay; fullscreen; clipboard-write"
                        @load="kanvasSiap = true"
                        class="block h-full w-full border-0 bg-transparent"
                    ></iframe>
                </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
