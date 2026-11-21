<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    function temaUndangan() {
        return {
            undanganTerbuka: false,
            musikBerputar: false,
            galeriModalTerbuka: false,
            galeriAktifUrl: '',
            galeriAktifKeterangan: '',
            rekeningTersalin: null,
            scrollPersen: 0,
            autoScrollAktif: false,
            autoScrollPanelTerbuka: false,
            autoScrollToast: false,
            kecepatanScroll: 2,
            autoScrollRaf: null,
            autoScrollPosY: 0,
            autoScrollWaktuLalu: 0,
            autoScrollMulaiMs: 0,
            autoScrollTimerToast: null,
            autoScrollJedaManual: false,
            init() {
                document.body.classList.add('siap-3d');

                const panggungEls = Array.from(document.querySelectorAll('[data-panggung-3d]'));
                const scrubEls = Array.from(document.querySelectorAll('[data-scroll-scrub]'));

                let rafScroll = null;
                const perbaruiScroll = () => {
                    rafScroll = null;
                    const y = window.scrollY || 0;
                    const total = document.documentElement.scrollHeight - window.innerHeight;
                    this.scrollPersen = total > 0 ? Math.min(100, Math.round((y / total) * 100)) : 0;

                    const geserScroll = Math.min(26, y * 0.032).toFixed(2);
                    const syTerbatas = Math.min(1800, y).toFixed(1);
                    for (let i = 0; i < panggungEls.length; i++) {
                        panggungEls[i].style.setProperty('--ps', `${geserScroll}px`);
                        panggungEls[i].style.setProperty('--sy', syTerbatas);
                    }

                    const vh = window.innerHeight || 800;
                    for (let i = 0; i < scrubEls.length; i++) {
                        const rect = scrubEls[i].getBoundingClientRect();
                        if (rect.bottom < -120 || rect.top > vh + 120) {
                            continue;
                        }
                        const progres = ((rect.top + rect.height / 2) / vh) * 2 - 1;
                        const terjepit = Math.max(-1.15, Math.min(1.15, progres));
                        scrubEls[i].style.setProperty('--scrub', terjepit.toFixed(3));
                    }
                };

                window.addEventListener('scroll', () => {
                    if (!rafScroll) {
                        rafScroll = window.requestAnimationFrame(perbaruiScroll);
                    }
                }, { passive: true });
                perbaruiScroll();

                // Jeda auto-scroll secara sopan bila tamu menggulir manual (wheel/sentuh)
                const jedaKarenaInteraksi = () => {
                    if (this.autoScrollAktif) {
                        this.hentikanAutoScroll(true);
                    }
                };
                window.addEventListener('wheel', jedaKarenaInteraksi, { passive: true });
                window.addEventListener('touchstart', jedaKarenaInteraksi, { passive: true });

                // Jeda audio & auto-scroll otomatis saat pindah tab
                document.addEventListener('visibilitychange', () => {
                    if (document.hidden) {
                        if (this.autoScrollAktif) {
                            this.hentikanAutoScroll(false);
                        }
                        if (this.$refs.pemutarAudio && this.musikBerputar) {
                            this.$refs.pemutarAudio.pause();
                        }
                    } else if (this.$refs.pemutarAudio && this.musikBerputar && this.undanganTerbuka) {
                        this.$refs.pemutarAudio.play().catch(() => {});
                    }
                });

                this.inisialisasiParallax3D();
                this.inisialisasiKartuTilt3D();
                this.inisialisasiMasuk3D();
                this.inisialisasiFxReveal();
            },
            inisialisasiParallax3D() {
                const mediaKurangiGerak = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                const mendukungHover = window.matchMedia && window.matchMedia('(hover: hover)').matches;
                if (mediaKurangiGerak || !mendukungHover) {
                    return;
                }

                document.querySelectorAll('[data-panggung-3d]').forEach((panggung) => {
                    let rafMove = null;
                    let targetX = 0;
                    let targetY = 0;

                    panggung.addEventListener('pointermove', (acara) => {
                        if (acara.pointerType === 'touch') {
                            return;
                        }
                        const rect = panggung.getBoundingClientRect();
                        if (rect.width === 0 || rect.height === 0) {
                            return;
                        }
                        targetX = ((acara.clientX - rect.left) / rect.width - 0.5) * 2;
                        targetY = ((acara.clientY - rect.top) / rect.height - 0.5) * 2;
                        if (!rafMove) {
                            rafMove = window.requestAnimationFrame(() => {
                                rafMove = null;
                                panggung.style.setProperty('--px', targetX.toFixed(3));
                                panggung.style.setProperty('--py', targetY.toFixed(3));
                            });
                        }
                    }, { passive: true });

                    panggung.addEventListener('pointerleave', () => {
                        panggung.style.setProperty('--px', '0');
                        panggung.style.setProperty('--py', '0');
                    });
                });
            },
            inisialisasiKartuTilt3D() {
                const mendukungHover = window.matchMedia && window.matchMedia('(hover: hover)').matches;
                const kurangiGerak = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                if (!mendukungHover || kurangiGerak) {
                    return;
                }

                document.querySelectorAll('.kartu-3d').forEach((kartu) => {
                    kartu.addEventListener('pointermove', (acara) => {
                        if (acara.pointerType === 'touch') {
                            return;
                        }
                        const rect = kartu.getBoundingClientRect();
                        if (rect.width === 0 || rect.height === 0) {
                            return;
                        }
                        const dx = (acara.clientX - rect.left) / rect.width - 0.5;
                        const dy = (acara.clientY - rect.top) / rect.height - 0.5;
                        kartu.classList.add('sedang-tilt');
                        kartu.style.setProperty('--rx', `${(-dy * 4.5).toFixed(2)}deg`);
                        kartu.style.setProperty('--ry', `${(dx * 5.2).toFixed(2)}deg`);
                    }, { passive: true });

                    kartu.addEventListener('pointerleave', () => {
                        kartu.style.setProperty('--rx', '0deg');
                        kartu.style.setProperty('--ry', '0deg');
                        window.setTimeout(() => kartu.classList.remove('sedang-tilt'), 240);
                    });
                });
            },
            inisialisasiMasuk3D() {
                const elemen = document.querySelectorAll('.masuk-3d');
                if (!('IntersectionObserver' in window)) {
                    elemen.forEach((el) => el.classList.add('terlihat'));
                    return;
                }

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('terlihat');
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.08, rootMargin: '0px 0px -16px 0px' });

                elemen.forEach((el) => observer.observe(el));
            },
            inisialisasiFxReveal() {
                const selektor = '.fx-rise, .fx-rise-down, .fx-scale-in, .fx-scale-out, .fx-slide-left, .fx-slide-right, .fx-flip-in';
                const elemen = document.querySelectorAll(selektor);

                if (!('IntersectionObserver' in window)) {
                    elemen.forEach((el) => el.classList.add('active'));
                    return;
                }

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            const jeda = Number.parseInt(entry.target.dataset.fxDelay || '0', 10);
                            if (jeda > 0) {
                                window.setTimeout(() => entry.target.classList.add('active'), jeda);
                            } else {
                                entry.target.classList.add('active');
                            }
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.08, rootMargin: '0px 0px -18px 0px' });

                elemen.forEach((el) => observer.observe(el));
            },
            bukaUndangan() {
                this.undanganTerbuka = true;
                this.autoScrollJedaManual = false;

                if (this.$refs.pemutarAudio) {
                    this.$refs.pemutarAudio.play().then(() => {
                        this.musikBerputar = true;
                    }).catch(() => {
                        this.musikBerputar = false;
                    });
                }

                window.setTimeout(() => {
                    document.querySelectorAll('.masuk-3d').forEach((el) => {
                        const rect = el.getBoundingClientRect();
                        if (rect.top < window.innerHeight * 1.15) {
                            el.classList.add('terlihat');
                        }
                    });
                    document.querySelectorAll('.fx-rise, .fx-rise-down, .fx-scale-in, .fx-scale-out, .fx-slide-left, .fx-slide-right, .fx-flip-in').forEach((el) => {
                        const rect = el.getBoundingClientRect();
                        if (rect.top < window.innerHeight * 1.15) {
                            el.classList.add('active');
                        }
                    });
                    if (window.AOS) {
                        window.AOS.refreshHard();
                    }
                }, 380);

                // Aktifkan mode Auto-Scroll Cinema silky 60fps setelah koreografi diorama 3D selesai
                const kurangiGerak = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                const modeEmbed = new URLSearchParams(window.location.search).get('embed') === '1';
                if (!kurangiGerak && !modeEmbed) {
                    window.setTimeout(() => {
                        if (this.undanganTerbuka && !this.autoScrollJedaManual && window.scrollY < 40) {
                            this.mulaiAutoScroll();
                        }
                    }, 3800);
                }
            },
            mulaiAutoScroll() {
                if (this.autoScrollAktif) {
                    return;
                }
                const total = document.documentElement.scrollHeight - window.innerHeight;
                if (total <= 20) {
                    return;
                }

                this.autoScrollAktif = true;
                this.autoScrollJedaManual = false;
                this.autoScrollPosY = window.scrollY;
                this.autoScrollWaktuLalu = performance.now();
                this.autoScrollMulaiMs = this.autoScrollWaktuLalu;
                document.documentElement.classList.add('mode-autoscroll');
                this.tampilkanToastAutoScroll();

                // Kecepatan dalam piksel per detik (bebas jitter di layar 60Hz, 120Hz, maupun 144Hz)
                const kecepatanPxPerDetik = { 1: 38, 2: 68, 3: 112 };
                const langkah = (sekarang) => {
                    if (!this.autoScrollAktif) {
                        return;
                    }
                    const batasBawah = document.documentElement.scrollHeight - window.innerHeight - 2;
                    if (this.autoScrollPosY >= batasBawah) {
                        this.hentikanAutoScroll(false);
                        return;
                    }
                    const dt = Math.min(0.05, Math.max(0.001, (sekarang - this.autoScrollWaktuLalu) / 1000));
                    this.autoScrollWaktuLalu = sekarang;

                    // Ease-in lembut 650ms agar awal gerakan terasa sinematik tanpa hentakan
                    const ramp = Math.min(1, (sekarang - this.autoScrollMulaiMs) / 650);
                    const faktorHalus = ramp * ramp * (3 - 2 * ramp);

                    this.autoScrollPosY = Math.min(
                        batasBawah,
                        this.autoScrollPosY + (kecepatanPxPerDetik[this.kecepatanScroll] || 68) * faktorHalus * dt
                    );
                    window.scrollTo(0, this.autoScrollPosY);
                    this.autoScrollRaf = window.requestAnimationFrame(langkah);
                };

                this.autoScrollRaf = window.requestAnimationFrame(langkah);
            },
            hentikanAutoScroll(olehPengguna = false) {
                this.autoScrollAktif = false;
                if (olehPengguna) {
                    this.autoScrollJedaManual = true;
                }
                if (this.autoScrollRaf) {
                    window.cancelAnimationFrame(this.autoScrollRaf);
                    this.autoScrollRaf = null;
                }
                document.documentElement.classList.remove('mode-autoscroll');
                this.autoScrollToast = false;
            },
            toggleAutoScroll() {
                if (this.autoScrollAktif) {
                    this.hentikanAutoScroll(true);
                } else {
                    const batasBawah = document.documentElement.scrollHeight - window.innerHeight - 10;
                    if (window.scrollY >= batasBawah) {
                        window.scrollTo({ top: 0, behavior: 'auto' });
                    }
                    this.mulaiAutoScroll();
                }
            },
            ubahKecepatanScroll(delta) {
                const baru = Math.max(1, Math.min(3, this.kecepatanScroll + delta));
                this.kecepatanScroll = baru;
                if (this.autoScrollAktif) {
                    this.tampilkanToastAutoScroll();
                }
            },
            tampilkanToastAutoScroll() {
                this.autoScrollToast = true;
                if (this.autoScrollTimerToast) {
                    window.clearTimeout(this.autoScrollTimerToast);
                }
                this.autoScrollTimerToast = window.setTimeout(() => {
                    this.autoScrollToast = false;
                }, 3200);
            },
            gulirKeAtas() {
                this.hentikanAutoScroll(true);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            },
            toggleMusik() {
                if (!this.$refs.pemutarAudio) {
                    return;
                }
                if (this.musikBerputar) {
                    this.$refs.pemutarAudio.pause();
                    this.musikBerputar = false;
                } else {
                    this.$refs.pemutarAudio.play().then(() => {
                        this.musikBerputar = true;
                    }).catch(() => {});
                }
            },
            bukaGaleri(url, keterangan) {
                this.galeriAktifUrl = url;
                this.galeriAktifKeterangan = keterangan || '';
                this.galeriModalTerbuka = true;
            },
            salinRekening(nomor, id) {
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(String(nomor || ''));
                }
                this.rekeningTersalin = id;
                window.setTimeout(() => {
                    if (this.rekeningTersalin === id) {
                        this.rekeningTersalin = null;
                    }
                }, 2500);
            }
        };
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (window.AOS && document.querySelector('[data-aos]')) {
            window.AOS.init({
                duration: 850,
                easing: 'ease-out-cubic',
                once: true,
                offset: 36,
            });
        }
    });
</script>
