import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Lenis from 'lenis';

gsap.registerPlugin(ScrollTrigger);

/**
 * Mesin Sinema Scroll Per-Komponen (GSAP + ScrollTrigger + Lenis)
 * Mendukung animasi masuk & keluar dua arah (scroll turun maupun scroll naik kembali)
 * serta selaras dengan kunci sampul, auto-scroll sinema, dan modal galeri.
 */
export function buatPengendaliSinemaScroll() {
    let lenis = null;
    let tickerFn = null;
    let aktif = false;
    let siap = false;
    let sedangDijeda = false;
    let daftarTrigger = [];
    let timerResize = null;
    let timerRefresh = null;

    const kurangiGerak = () =>
        typeof window !== 'undefined' &&
        window.matchMedia &&
        window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const adalahEmbed = () =>
        typeof window !== 'undefined' &&
        new URLSearchParams(window.location.search).get('embed') === '1';

    function konfigurasiGerak(jenis) {
        switch (jenis) {
            case 'turun':
                return {
                    durasiMasuk: 0.72,
                    easeMasuk: 'power3.out',
                    masukBawah: { opacity: 0, y: -26, x: 0, scale: 0.94, rotate: 0 },
                    masukAtas: { opacity: 0, y: -28, x: 0, scale: 0.94, rotate: 0 },
                    keluarAtas: { opacity: 0, y: -22, x: 0, scale: 0.95, rotate: 0 },
                    keluarBawah: { opacity: 0, y: 22, x: 0, scale: 0.95, rotate: 0 },
                };
            case 'kiri':
                return {
                    durasiMasuk: 0.76,
                    easeMasuk: 'power3.out',
                    masukBawah: { opacity: 0, x: -38, y: 10, scale: 0.98, rotate: 0 },
                    masukAtas: { opacity: 0, x: -38, y: -10, scale: 0.98, rotate: 0 },
                    keluarAtas: { opacity: 0, x: -28, y: -12, scale: 0.98, rotate: 0 },
                    keluarBawah: { opacity: 0, x: -28, y: 12, scale: 0.98, rotate: 0 },
                };
            case 'kanan':
                return {
                    durasiMasuk: 0.76,
                    easeMasuk: 'power3.out',
                    masukBawah: { opacity: 0, x: 38, y: 10, scale: 0.98, rotate: 0 },
                    masukAtas: { opacity: 0, x: 38, y: -10, scale: 0.98, rotate: 0 },
                    keluarAtas: { opacity: 0, x: 28, y: -12, scale: 0.98, rotate: 0 },
                    keluarBawah: { opacity: 0, x: 28, y: 12, scale: 0.98, rotate: 0 },
                };
            case 'mekar':
                return {
                    durasiMasuk: 0.74,
                    easeMasuk: 'back.out(1.32)',
                    masukBawah: { opacity: 0, y: 18, x: 0, scale: 0.84, rotate: 0 },
                    masukAtas: { opacity: 0, y: -18, x: 0, scale: 0.84, rotate: 0 },
                    keluarAtas: { opacity: 0, y: -16, x: 0, scale: 0.88, rotate: 0 },
                    keluarBawah: { opacity: 0, y: 16, x: 0, scale: 0.88, rotate: 0 },
                };
            case 'potret':
                return {
                    durasiMasuk: 0.88,
                    easeMasuk: 'power3.out',
                    masukBawah: { opacity: 0, y: 28, x: 0, scale: 0.91, rotate: 0 },
                    masukAtas: { opacity: 0, y: -26, x: 0, scale: 0.91, rotate: 0 },
                    keluarAtas: { opacity: 0, y: -22, x: 0, scale: 0.94, rotate: 0 },
                    keluarBawah: { opacity: 0, y: 24, x: 0, scale: 0.94, rotate: 0 },
                };
            case 'garis':
                return {
                    durasiMasuk: 0.82,
                    easeMasuk: 'power3.out',
                    masukBawah: { opacity: 0, scaleX: 0, transformOrigin: 'center center' },
                    masukAtas: { opacity: 0, scaleX: 0, transformOrigin: 'center center' },
                    keluarAtas: { opacity: 0, scaleX: 0, transformOrigin: 'center center' },
                    keluarBawah: { opacity: 0, scaleX: 0, transformOrigin: 'center center' },
                    aktif: { opacity: 1, scaleX: 1, transformOrigin: 'center center' },
                };
            case 'teks':
                return {
                    durasiMasuk: 0.66,
                    easeMasuk: 'power3.out',
                    masukBawah: { opacity: 0, y: 20, x: 0, scale: 1, rotate: 0 },
                    masukAtas: { opacity: 0, y: -20, x: 0, scale: 1, rotate: 0 },
                    keluarAtas: { opacity: 0, y: -16, x: 0, scale: 1, rotate: 0 },
                    keluarBawah: { opacity: 0, y: 16, x: 0, scale: 1, rotate: 0 },
                };
            case 'naik':
            default:
                return {
                    durasiMasuk: 0.74,
                    easeMasuk: 'power3.out',
                    masukBawah: { opacity: 0, y: 30, x: 0, scale: 0.97, rotate: 0 },
                    masukAtas: { opacity: 0, y: -28, x: 0, scale: 0.97, rotate: 0 },
                    keluarAtas: { opacity: 0, y: -22, x: 0, scale: 0.97, rotate: 0 },
                    keluarBawah: { opacity: 0, y: 24, x: 0, scale: 0.97, rotate: 0 },
                };
        }
    }

    function inisialisasi() {
        if (siap) {
            return;
        }
        const panggung = document.querySelector('main[data-sinema-gsap]');
        if (!panggung) {
            return;
        }
        siap = true;

        const semuaTarget = Array.from(panggung.querySelectorAll('[data-gsap]'));
        if (!semuaTarget.length) {
            return;
        }

        if (kurangiGerak() || adalahEmbed()) {
            semuaTarget.forEach((el) => {
                gsap.set(el, { clearProps: 'all', opacity: 1 });
            });
            return;
        }

        aktif = true;
        document.body.classList.add('sinema-gsap-aktif');

        // 1. Inisialisasi Lenis (smooth inertia scrolling), dimulai dalam keadaan berhenti hingga sampul dibuka
        lenis = new Lenis({
            duration: 1.15,
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
            orientation: 'vertical',
            gestureOrientation: 'vertical',
            smoothWheel: true,
            wheelMultiplier: 0.92,
            touchMultiplier: 1.3,
        });
        lenis.stop();
        sedangDijeda = true;

        lenis.on('scroll', ScrollTrigger.update);

        tickerFn = (waktu) => {
            if (lenis) {
                lenis.raf(waktu * 1000);
            }
        };
        gsap.ticker.add(tickerFn);
        gsap.ticker.lagSmoothing(0);

        // 2. Pasang ScrollTrigger per komponen (masuk & keluar halus dua arah: scroll turun & scroll naik)
        const vh = window.innerHeight || 800;

        semuaTarget.forEach((el) => {
            const jenis = (el.dataset.gsap || 'naik').trim();
            const jeda = Math.max(0, Number.parseFloat(el.dataset.gsapDelay || '0') || 0);
            const profil = konfigurasiGerak(jenis);
            const keadaanAktif = profil.aktif || { opacity: 1, x: 0, y: 0, scale: 1, rotate: 0 };

            const rect = el.getBoundingClientRect();
            const sudahTerlihat = rect.top < vh * 0.92 && rect.bottom > vh * 0.08;
            if (sudahTerlihat) {
                gsap.set(el, keadaanAktif);
            } else if (rect.bottom <= vh * 0.08) {
                gsap.set(el, profil.masukAtas);
            } else {
                gsap.set(el, profil.masukBawah);
            }

            const sedangFokus = () =>
                Boolean(document.activeElement && el.contains(document.activeElement));

            const st = ScrollTrigger.create({
                trigger: el,
                start: 'top 93%',
                end: 'bottom 7%',
                invalidateOnRefresh: true,
                onEnter: () => {
                    gsap.killTweensOf(el);
                    gsap.fromTo(el, profil.masukBawah, {
                        ...keadaanAktif,
                        duration: profil.durasiMasuk,
                        delay: jeda,
                        ease: profil.easeMasuk,
                        overwrite: 'auto',
                    });
                },
                onLeave: () => {
                    if (sedangFokus()) {
                        return;
                    }
                    gsap.killTweensOf(el);
                    gsap.to(el, {
                        ...profil.keluarAtas,
                        duration: 0.42,
                        ease: 'power2.in',
                        overwrite: 'auto',
                    });
                },
                onEnterBack: () => {
                    gsap.killTweensOf(el);
                    gsap.fromTo(el, profil.masukAtas, {
                        ...keadaanAktif,
                        duration: Math.max(0.56, profil.durasiMasuk * 0.92),
                        delay: jeda * 0.55,
                        ease: profil.easeMasuk,
                        overwrite: 'auto',
                    });
                },
                onLeaveBack: () => {
                    if (sedangFokus()) {
                        return;
                    }
                    gsap.killTweensOf(el);
                    gsap.to(el, {
                        ...profil.keluarBawah,
                        duration: 0.38,
                        ease: 'power2.in',
                        overwrite: 'auto',
                    });
                },
            });

            daftarTrigger.push(st);
        });

        window.addEventListener(
            'resize',
            () => {
                if (timerResize) {
                    window.clearTimeout(timerResize);
                }
                timerResize = window.setTimeout(() => {
                    ScrollTrigger.refresh();
                }, 180);
            },
            { passive: true },
        );
    }

    function aktifkanLenis() {
        if (!siap) {
            inisialisasi();
        }
        if (!aktif) {
            return;
        }
        if (lenis) {
            lenis.start();
            lenis.scrollTo(window.scrollY || 0, { immediate: true });
            sedangDijeda = false;
        }
        refresh(120);
    }

    function jedaLenis() {
        if (lenis && !sedangDijeda) {
            lenis.stop();
            sedangDijeda = true;
        }
    }

    function lanjutLenis() {
        if (lenis && sedangDijeda && aktif) {
            lenis.start();
            lenis.scrollTo(window.scrollY || 0, { immediate: true });
            sedangDijeda = false;
        }
    }

    function gulirKeAtas() {
        if (lenis && aktif) {
            if (sedangDijeda) {
                lenis.start();
                sedangDijeda = false;
            }
            lenis.scrollTo(0, { duration: 1.35 });
            return true;
        }
        return false;
    }

    function refresh(jedaMs = 260) {
        if (!aktif) {
            return;
        }
        if (timerRefresh) {
            window.clearTimeout(timerRefresh);
        }
        timerRefresh = window.setTimeout(() => {
            ScrollTrigger.refresh();
            timerRefresh = null;
        }, jedaMs);
    }

    return {
        inisialisasi,
        aktifkanLenis,
        jedaLenis,
        lanjutLenis,
        gulirKeAtas,
        refresh,
        sedangAktif: () => aktif,
    };
}
