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
    let daftarItemGsap = [];
    let daftarKartuTumpuk = [];
    let pengamatUkuran = null;
    let timerResize = null;
    let timerRefresh = null;

    function sinkronkanElemenTerlihat() {
        if (!daftarItemGsap.length || typeof window === 'undefined') {
            return;
        }
        const vh = window.innerHeight || 800;
        daftarItemGsap.forEach(({ el, keadaanAktif }) => {
            if (el.offsetParent === null && window.getComputedStyle(el).position !== 'fixed') {
                gsap.killTweensOf(el);
                gsap.set(el, keadaanAktif);
                return;
            }
            const rect = el.getBoundingClientRect();
            const sedangDiLayar = rect.bottom > 4 && rect.top < vh - 4;
            if (sedangDiLayar && !gsap.isTweening(el)) {
                gsap.set(el, keadaanAktif);
            }
        });
    }

    function perbaruiOffsetKartuTumpuk() {
        if (!daftarKartuTumpuk.length || typeof window === 'undefined') {
            return;
        }
        const vh = window.innerHeight || 800;
        const scrollSekarang = window.scrollY || window.pageYOffset || 0;
        const barDemo = document.querySelector('[data-bar-pratinjau]');
        const tinggiBar = barDemo && barDemo.offsetParent !== null ? barDemo.offsetHeight || 56 : 0;

        // 1. Lepas sticky sementara dalam satu frame sinkron (tanpa repaint)
        //    agar koordinat Y statis alami setiap kartu diukur 100% akurat walau sedang menumpuk
        daftarKartuTumpuk.forEach((kartu) => {
            kartu.style.position = 'relative';
            kartu.style.top = 'auto';
        });

        daftarKartuTumpuk.forEach((kartu) => {
            const rectAlami = kartu.getBoundingClientRect();
            const yAlami = Math.round(rectAlami.top + scrollSekarang);
            const tinggiKartu = Math.round(kartu.offsetHeight || vh);
            kartu.dataset.yAlami = String(yAlami);
            kartu.dataset.tinggiAlami = String(tinggiKartu);
        });

        // 2. Pasang kembali sticky beserta offset top idealnya
        daftarKartuTumpuk.forEach((kartu) => {
            const tinggiKartu = Number(kartu.dataset.tinggiAlami) || kartu.offsetHeight || vh;
            const topIdeal = Math.min(tinggiBar, Math.round(vh - tinggiKartu));
            kartu.style.position = 'sticky';
            kartu.style.top = `${topIdeal}px`;
        });
    }

    function inisialisasiKartuTumpuk(panggung) {
        daftarKartuTumpuk = Array.from(panggung.querySelectorAll('[data-kartu-tumpuk]'));
        if (!daftarKartuTumpuk.length) {
            return;
        }

        if (kurangiGerak() || adalahEmbed()) {
            daftarKartuTumpuk.forEach((kartu) => {
                kartu.style.position = 'relative';
                kartu.style.top = 'auto';
            });
            daftarKartuTumpuk = [];
            return;
        }

        daftarKartuTumpuk.forEach((kartu, indeks) => {
            kartu.style.position = 'sticky';
            kartu.style.zIndex = String(10 + indeks);
            kartu.style.transformOrigin = 'center top';

            const kartuBerikutnya = daftarKartuTumpuk[indeks + 1];
            if (!kartuBerikutnya) {
                return;
            }

            const stTumpuk = ScrollTrigger.create({
                trigger: kartuBerikutnya,
                start: 'top 96%',
                end: 'top 14%',
                scrub: 0.35,
                invalidateOnRefresh: true,
                onUpdate: (self) => {
                    const p = self.progress;
                    const skala = 1 - p * 0.032;
                    gsap.set(kartu, {
                        scale: Number(skala.toFixed(4)),
                        overwrite: 'auto',
                    });
                },
                onLeaveBack: () => {
                    gsap.set(kartu, { scale: 1, overwrite: 'auto' });
                },
            });

            daftarTrigger.push(stTumpuk);
        });

        perbaruiOffsetKartuTumpuk();
    }

    function inisialisasiDragHorizontal(panggung) {
        const semuaJalur = Array.from(panggung.querySelectorAll('[data-horizontal-editorial]'));
        semuaJalur.forEach((jalur) => {
            let sedangTarik = false;
            let mulaiX = 0;
            let awalScrollLeft = 0;
            let sudahGeser = false;

            jalur.addEventListener('mousedown', (e) => {
                if (e.button !== 0) return;
                sedangTarik = true;
                sudahGeser = false;
                mulaiX = e.pageX - jalur.offsetLeft;
                awalScrollLeft = jalur.scrollLeft;
                jalur.classList.add('cursor-grabbing');
            });

            window.addEventListener('mouseup', () => {
                if (!sedangTarik) return;
                sedangTarik = false;
                jalur.classList.remove('cursor-grabbing');
            });

            jalur.addEventListener('mousemove', (e) => {
                if (!sedangTarik) return;
                const x = e.pageX - jalur.offsetLeft;
                const selisih = (x - mulaiX) * 1.35;
                if (Math.abs(selisih) > 6) {
                    sudahGeser = true;
                }
                if (sudahGeser) {
                    e.preventDefault();
                    jalur.scrollLeft = awalScrollLeft - selisih;
                }
            });

            jalur.addEventListener(
                'click',
                (e) => {
                    if (sudahGeser) {
                        e.preventDefault();
                        e.stopPropagation();
                        sudahGeser = false;
                    }
                },
                true,
            );
        });
    }

    const kurangiGerak = () =>
        typeof window !== 'undefined' &&
        window.matchMedia &&
        window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const adalahEmbed = () =>
        typeof window !== 'undefined' &&
        (new URLSearchParams(window.location.search).get('embed') === '1' ||
            Boolean(window.__SESITEMU_LIVE_PREVIEW__));

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
        document.documentElement.style.scrollBehavior = 'auto';

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

            daftarItemGsap.push({ el, profil, keadaanAktif });

            const tersembunyi =
                el.offsetParent === null && window.getComputedStyle(el).position !== 'fixed';
            const rect = el.getBoundingClientRect();
            const sudahTerlihat = !tersembunyi && rect.top < vh && rect.bottom > 0;
            if (tersembunyi || sudahTerlihat) {
                gsap.set(el, keadaanAktif);
            } else if (rect.bottom <= 0) {
                gsap.set(el, profil.masukAtas);
            } else {
                gsap.set(el, profil.masukBawah);
            }

            const sedangFokus = () =>
                Boolean(document.activeElement && el.contains(document.activeElement));

            const st = ScrollTrigger.create({
                trigger: el,
                start: 'top bottom-=6',
                end: 'bottom top+=6',
                invalidateOnRefresh: true,
                onEnter: () => {
                    if (el.offsetParent === null) {
                        return;
                    }
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
                    if (sedangFokus() || el.offsetParent === null) {
                        return;
                    }
                    const r = el.getBoundingClientRect();
                    if (r.bottom > 10) {
                        gsap.set(el, keadaanAktif);
                        return;
                    }
                    gsap.killTweensOf(el);
                    gsap.set(el, profil.masukAtas);
                },
                onEnterBack: () => {
                    if (el.offsetParent === null) {
                        return;
                    }
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
                    if (sedangFokus() || el.offsetParent === null) {
                        return;
                    }
                    const r = el.getBoundingClientRect();
                    const tinggiLayar = window.innerHeight || 800;
                    if (r.top < tinggiLayar - 10) {
                        gsap.set(el, keadaanAktif);
                        return;
                    }
                    gsap.killTweensOf(el);
                    gsap.set(el, profil.masukBawah);
                },
            });

            daftarTrigger.push(st);
        });

        inisialisasiKartuTumpuk(panggung);
        inisialisasiDragHorizontal(panggung);

        if ('ResizeObserver' in window) {
            let tinggiTerakhir = panggung.offsetHeight || 0;
            pengamatUkuran = new ResizeObserver(() => {
                const tinggiBaru = panggung.offsetHeight || 0;
                if (Math.abs(tinggiBaru - tinggiTerakhir) > 4) {
                    tinggiTerakhir = tinggiBaru;
                    refresh(100);
                }
            });
            pengamatUkuran.observe(panggung);
        }

        window.addEventListener(
            'resize',
            () => {
                if (timerResize) {
                    window.clearTimeout(timerResize);
                }
                timerResize = window.setTimeout(() => {
                    perbaruiOffsetKartuTumpuk();
                    ScrollTrigger.refresh();
                    sinkronkanElemenTerlihat();
                }, 180);
            },
            { passive: true },
        );
    }

    function gulirKeSeksi(selector) {
        if (typeof window === 'undefined' || !selector) {
            return false;
        }
        const target = typeof selector === 'string' ? document.querySelector(selector) : selector;
        if (!target) {
            return false;
        }

        window.dispatchEvent(new CustomEvent('sesitemu:lompat-seksi'));

        const barDemo = document.querySelector('[data-bar-pratinjau]');
        const tinggiBar = barDemo && barDemo.offsetParent !== null ? barDemo.offsetHeight || 56 : 0;

        let yTujuan = 0;
        const kartuInduk = target.closest('[data-kartu-tumpuk]');

        if (kartuInduk && daftarKartuTumpuk.length) {
            // Segarkan koordinat alami seluruh kartu tumpuk agar lompatan ke atas (misal RSVP -> Mempelai)
            // tidak tertipu oleh offsetTop/getBoundingClientRect kartu yang sedang tertahan sticky
            perbaruiOffsetKartuTumpuk();

            if (target === kartuInduk) {
                yTujuan = Math.max(0, (Number(kartuInduk.dataset.yAlami) || 0) - tinggiBar);
            } else {
                const scrollSekarang = window.scrollY || window.pageYOffset || 0;
                daftarKartuTumpuk.forEach((k) => {
                    k.style.position = 'relative';
                    k.style.top = 'auto';
                });
                yTujuan = Math.max(
                    0,
                    Math.round(target.getBoundingClientRect().top + scrollSekarang - tinggiBar),
                );
                const vh = window.innerHeight || 800;
                daftarKartuTumpuk.forEach((k) => {
                    const tk = Number(k.dataset.tinggiAlami) || k.offsetHeight || vh;
                    k.style.position = 'sticky';
                    k.style.top = `${Math.min(tinggiBar, Math.round(vh - tk))}px`;
                });
            }

            // Pulihkan skala kartu tujuan dan kartu setelahnya agar tampil utuh 100% saat dituju ke atas
            const idxKartu = daftarKartuTumpuk.indexOf(kartuInduk);
            if (idxKartu !== -1) {
                for (let i = idxKartu; i < daftarKartuTumpuk.length; i++) {
                    gsap.set(daftarKartuTumpuk[i], { scale: 1, overwrite: 'auto' });
                }
            }
        } else {
            const scrollSekarang = window.scrollY || window.pageYOffset || 0;
            yTujuan = Math.max(
                0,
                Math.round(target.getBoundingClientRect().top + scrollSekarang - tinggiBar),
            );
        }

        if (lenis && aktif) {
            document.documentElement.style.scrollBehavior = 'auto';
            if (sedangDijeda) {
                lenis.start();
                sedangDijeda = false;
            }
            lenis.scrollTo(Math.max(0, yTujuan), {
                duration: 0.9,
                force: true,
                onComplete: () => {
                    ScrollTrigger.update();
                    sinkronkanElemenTerlihat();
                },
            });
            return true;
        }

        window.scrollTo({ top: Math.max(0, yTujuan), behavior: 'smooth' });
        return true;
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
            document.documentElement.style.scrollBehavior = 'auto';
            if (sedangDijeda) {
                lenis.start();
                sedangDijeda = false;
            }
            daftarKartuTumpuk.forEach((k) => {
                gsap.set(k, { scale: 1, overwrite: 'auto' });
            });
            lenis.scrollTo(0, {
                duration: 1.15,
                force: true,
                onComplete: () => {
                    ScrollTrigger.update();
                    sinkronkanElemenTerlihat();
                },
            });
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
            perbaruiOffsetKartuTumpuk();
            ScrollTrigger.refresh();
            sinkronkanElemenTerlihat();
            timerRefresh = null;
        }, jedaMs);
    }

    return {
        inisialisasi,
        aktifkanLenis,
        jedaLenis,
        lanjutLenis,
        gulirKeAtas,
        gulirKeSeksi,
        refresh,
        sedangAktif: () => aktif,
    };
}
