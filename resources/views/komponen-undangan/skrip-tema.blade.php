<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    function temaUndangan() {
        return {
            undanganTerbuka: false,
            musikBerputar: false,
            musikDijedaManual: false,
            galeriModalTerbuka: false,
            galeriAktifUrl: '',
            galeriAktifKeterangan: '',
            rekeningTersalin: null,
            scrollPersen: 0,
            teksHeroTampil: true,
            videoHeroSedangIntro: false,
            videoHeroGagal: false,
            videoHeroSelesai: false,
            videoHeroSiap: false,
            videoHeroMulaiDetik: 0,
            cinema25dPutaran: 0,
            cinema25dSelesai: false,
            timerCinema25d: null,
            timerAutoScrollHero: null,
            timerWatchdogHero: null,
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

                if (this.$refs.heroVideo) {
                    this.siapkanVideoHero(this.$refs.heroVideo);
                }

                const panggungSampingEls = Array.from(document.querySelectorAll('aside[data-panggung-3d]'));
                const paralaksScrollEls = Array.from(document.querySelectorAll('.lapis-paralaks-scroll'));
                const scrubEls = Array.from(document.querySelectorAll('[data-scroll-scrub]'));

                let rafScroll = null;
                const perbaruiScroll = () => {
                    rafScroll = null;
                    const y = window.scrollY || 0;
                    const total = document.documentElement.scrollHeight - window.innerHeight;
                    this.scrollPersen = total > 0 ? Math.min(100, Math.round((y / total) * 100)) : 0;

                    const geserScroll = Math.min(26, y * 0.032).toFixed(2);
                    const syTerbatas = Math.min(1800, y).toFixed(1);
                    for (let i = 0; i < panggungSampingEls.length; i++) {
                        panggungSampingEls[i].style.setProperty('--ps', `${geserScroll}px`);
                    }
                    for (let i = 0; i < paralaksScrollEls.length; i++) {
                        paralaksScrollEls[i].style.setProperty('--sy', syTerbatas);
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
                }, {
                    passive: true
                });
                perbaruiScroll();

                // Jeda auto-scroll secara sopan bila tamu menggulir manual (wheel/sentuh)
                const jedaKarenaInteraksi = () => {
                    if (this.autoScrollAktif) {
                        this.hentikanAutoScroll(true);
                    }
                };
                window.addEventListener('wheel', jedaKarenaInteraksi, {
                    passive: true
                });
                window.addEventListener('touchstart', jedaKarenaInteraksi, {
                    passive: true
                });
                window.addEventListener('sesitemu:lompat-seksi', jedaKarenaInteraksi);

                // Jeda audio & auto-scroll otomatis saat pindah tab
                document.addEventListener('visibilitychange', () => {
                    if (document.hidden) {
                        if (this.autoScrollAktif) {
                            this.hentikanAutoScroll(false);
                        }
                        if (this.$refs.pemutarAudio && this.musikBerputar) {
                            this.$refs.pemutarAudio.pause();
                        }
                        if (this.$refs.heroVideo && !this.$refs.heroVideo.paused) {
                            this.$refs.heroVideo.pause();
                        }
                    } else if (this.$refs.pemutarAudio && this.musikBerputar && this.undanganTerbuka) {
                        this.$refs.pemutarAudio.play().catch(() => {});
                    }
                    if (!document.hidden && this.$refs.heroVideo && this.undanganTerbuka && this.videoHeroSedangIntro && !this.videoHeroSelesai) {
                        this.$refs.heroVideo.play().catch(() => {});
                    }
                });

                this.inisialisasiParallax3D();
                this.inisialisasiJedaHeroOffscreen();
                this.inisialisasiMasuk3D();
                this.inisialisasiFxReveal();

                if (window.SesiTemuSinema) {
                    window.SesiTemuSinema.inisialisasi();
                }

                this.$watch('galeriModalTerbuka', (terbuka) => {
                    if (!window.SesiTemuSinema) return;
                    if (terbuka) {
                        window.SesiTemuSinema.jedaLenis();
                    } else if (this.undanganTerbuka && !this.autoScrollAktif) {
                        window.SesiTemuSinema.lanjutLenis();
                    }
                });
            },
            inisialisasiParallax3D() {
                const mediaKurangiGerak = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)')
                    .matches;
                const mendukungHover = window.matchMedia && window.matchMedia('(hover: hover)').matches;
                if (mediaKurangiGerak || !mendukungHover) {
                    return;
                }

                // Hanya panel samping desktop yang memakai paralaks kursor (--px/--py); hindari mutasi variabel CSS di <main> agar hover tombol tetap instan
                document.querySelectorAll('aside[data-panggung-3d]').forEach((panggung) => {
                    let rafMove = null;
                    let rectTersimpan = null;
                    let targetX = 0;
                    let targetY = 0;

                    panggung.addEventListener('pointerenter', () => {
                        rectTersimpan = panggung.getBoundingClientRect();
                    }, { passive: true });

                    panggung.addEventListener('pointermove', (acara) => {
                        if (acara.pointerType === 'touch') {
                            return;
                        }
                        const rect = rectTersimpan || panggung.getBoundingClientRect();
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
                    }, {
                        passive: true
                    });

                    panggung.addEventListener('pointerleave', () => {
                        rectTersimpan = null;
                        panggung.style.setProperty('--px', '0');
                        panggung.style.setProperty('--py', '0');
                    });
                });
            },
            inisialisasiJedaHeroOffscreen() {
                const hero = document.querySelector('[data-diorama-3d]');
                if (!hero || !('IntersectionObserver' in window)) {
                    return;
                }
                const ioHero = new IntersectionObserver((entries) => {
                    const tampil = entries.some((entry) => entry.isIntersecting);
                    hero.classList.toggle('hero-tidak-terlihat', !tampil);
                }, {
                    threshold: 0,
                    rootMargin: '80px 0px 80px 0px',
                });
                ioHero.observe(hero);
            },
            inisialisasiMasuk3D() {
                const elemen = document.querySelectorAll('.masuk-3d');
                if (!elemen.length) {
                    return;
                }
                const kurangiGerak = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                if (kurangiGerak || !('IntersectionObserver' in window)) {
                    elemen.forEach((el) => el.classList.add('terlihat'));
                    return;
                }

                // Dual-observer histeresis: muncul halus dari bawah/atas, reset otomatis hanya saat 100% keluar layar
                const observerMasuk = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('terlihat');
                        }
                    });
                }, {
                    threshold: 0.01,
                    rootMargin: '-24px 0px -24px 0px'
                });

                const observerReset = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (!entry.isIntersecting) {
                            const el = entry.target;
                            if (document.activeElement && el.contains(document.activeElement)) {
                                return;
                            }
                            el.classList.remove('terlihat');
                            el.classList.toggle('fx-dari-atas', entry.boundingClientRect.bottom < 0);
                        }
                    });
                }, {
                    threshold: 0,
                    rootMargin: '24px 0px 24px 0px'
                });

                elemen.forEach((el) => {
                    observerMasuk.observe(el);
                    observerReset.observe(el);
                });
            },
            inisialisasiFxReveal() {
                const selektor =
                    '.fx-rise:not([data-gsap]), .fx-rise-down:not([data-gsap]), .fx-scale-in:not([data-gsap]), .fx-scale-out:not([data-gsap]), .fx-slide-left:not([data-gsap]), .fx-slide-right:not([data-gsap]), .fx-flip-in:not([data-gsap])';

                // Pastikan seluruh bagian tema (termasuk Amplop, Turut Mengundang, Buku Tamu & RSVP) ikut memiliki animasi scroll
                if (!document.querySelector('main[data-sinema-gsap]')) {
                    document.querySelectorAll('main[data-panggung-3d] > section:not([data-diorama-3d])').forEach((seksi) => {
                        if (!seksi.matches(selektor) && !seksi.querySelector(selektor) && !seksi.querySelector('.masuk-3d')) {
                            const wadahUtama = seksi.querySelector(':scope > div, :scope > article');
                            (wadahUtama || seksi).classList.add('fx-rise');
                        }
                    });
                }

                const elemen = document.querySelectorAll(selektor);
                if (!elemen.length) {
                    return;
                }

                const kurangiGerak = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                if (kurangiGerak || !('IntersectionObserver' in window)) {
                    elemen.forEach((el) => el.classList.add('active'));
                    return;
                }

                const petaTimer = new WeakMap();
                const petaSelesai = new WeakMap();

                const aktifkanElemen = (el) => {
                    el.classList.add('active');
                    if (petaSelesai.has(el)) {
                        window.clearTimeout(petaSelesai.get(el));
                    }
                    const idSelesai = window.setTimeout(() => {
                        el.classList.add('fx-selesai');
                        petaSelesai.delete(el);
                    }, 740);
                    petaSelesai.set(el, idSelesai);
                };

                // Observer A: picu animasi masuk saat elemen muncul baik dari scroll bawah maupun kembali scroll atas
                const observerMasuk = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (!entry.isIntersecting) {
                            return;
                        }
                        const el = entry.target;
                        if (petaTimer.has(el)) {
                            window.clearTimeout(petaTimer.get(el));
                            petaTimer.delete(el);
                        }
                        const jeda = Number.parseInt(el.dataset.fxDelay || '0', 10);
                        if (jeda > 0) {
                            const idTimer = window.setTimeout(() => {
                                aktifkanElemen(el);
                                petaTimer.delete(el);
                            }, jeda);
                            petaTimer.set(el, idTimer);
                        } else {
                            aktifkanElemen(el);
                        }
                    });
                }, {
                    threshold: 0.01,
                    rootMargin: '-28px 0px -28px 0px'
                });

                // Observer B: reset diam-diam hanya ketika elemen benar-benar 100% keluar viewport (+24px buffer anti-kedip)
                const observerReset = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            return;
                        }
                        const el = entry.target;
                        if (document.activeElement && el.contains(document.activeElement)) {
                            return;
                        }
                        if (petaTimer.has(el)) {
                            window.clearTimeout(petaTimer.get(el));
                            petaTimer.delete(el);
                        }
                        if (petaSelesai.has(el)) {
                            window.clearTimeout(petaSelesai.get(el));
                            petaSelesai.delete(el);
                        }
                        el.classList.remove('active', 'fx-selesai');
                        el.classList.toggle('fx-dari-atas', entry.boundingClientRect.bottom < 0);
                    });
                }, {
                    threshold: 0,
                    rootMargin: '24px 0px 24px 0px'
                });

                elemen.forEach((el) => {
                    observerMasuk.observe(el);
                    observerReset.observe(el);
                });
            },
            siapkanVideoHero(vid) {
                if (!vid || this.videoHeroGagal) {
                    return;
                }
                const kurangiGerak = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                const modeEmbed = new URLSearchParams(window.location.search).get('embed') === '1';
                const mulaiDetik = Math.max(0, Number.parseFloat(vid.dataset.startAt || '0') || 0);
                this.videoHeroMulaiDetik = mulaiDetik;
                this.teksHeroTampil = kurangiGerak || modeEmbed;

                if (kurangiGerak || modeEmbed) {
                    const lompatAkhir = () => {
                        try {
                            const titikAkhir = Number.parseFloat(vid.dataset.settledAt || '') || Math.max(0, (vid.duration || 16) - 0.5);
                            vid.currentTime = Math.min(titikAkhir, Math.max(0, (vid.duration || 24) - 0.4));
                            vid.pause();
                        } catch (e) {}
                    };
                    if (vid.readyState >= 1) {
                        lompatAkhir();
                    } else {
                        vid.addEventListener('loadedmetadata', lompatAkhir, { once: true });
                    }
                    return;
                }

                vid.muted = true;
                vid.defaultMuted = true;
                const lajuPutar = Math.max(0.5, Math.min(2, Number.parseFloat(vid.dataset.playbackRate || '1') || 1));
                vid.defaultPlaybackRate = lajuPutar;
                vid.playbackRate = lajuPutar;

                let sudahDipanaskan = false;
                const panaskanDecoder = () => {
                    if (sudahDipanaskan || this.undanganTerbuka || this.videoHeroSedangIntro || this.videoHeroGagal) {
                        return;
                    }
                    sudahDipanaskan = true;

                    const kunciFrameAwal = () => {
                        if (this.undanganTerbuka || this.videoHeroSedangIntro) {
                            return;
                        }
                        try {
                            // Pemanasan 1-frame decoder GPU saat masih di balik sampul agar langsung jalan tanpa jeda ketika diklik
                            const janjiWarm = vid.play();
                            if (janjiWarm && typeof janjiWarm.then === 'function') {
                                janjiWarm.then(() => {
                                    if (this.undanganTerbuka || this.videoHeroSedangIntro) {
                                        return;
                                    }
                                    const jedaSetelahFrame = () => {
                                        if (this.undanganTerbuka || this.videoHeroSedangIntro) {
                                            return;
                                        }
                                        vid.pause();
                                        if (vid.currentTime > mulaiDetik + 0.06) {
                                            try {
                                                vid.currentTime = mulaiDetik;
                                            } catch (e) {}
                                        }
                                        this.videoHeroSiap = true;
                                    };
                                    if (typeof vid.requestVideoFrameCallback === 'function') {
                                        vid.requestVideoFrameCallback(jedaSetelahFrame);
                                    } else {
                                        window.requestAnimationFrame(jedaSetelahFrame);
                                    }
                                }).catch(() => {
                                    this.videoHeroSiap = vid.readyState >= 2;
                                });
                            } else {
                                this.videoHeroSiap = vid.readyState >= 2;
                            }
                        } catch (e) {
                            this.videoHeroSiap = vid.readyState >= 2;
                        }
                    };

                    if (mulaiDetik > 0 && Math.abs((vid.currentTime || 0) - mulaiDetik) > 0.08) {
                        try {
                            vid.addEventListener('seeked', kunciFrameAwal, { once: true });
                            vid.currentTime = Math.min(mulaiDetik, Math.max(0, (vid.duration || 20) - 1));
                        } catch (e) {
                            kunciFrameAwal();
                        }
                    } else {
                        kunciFrameAwal();
                    }
                };

                if (vid.readyState >= 2) {
                    panaskanDecoder();
                } else {
                    vid.addEventListener('loadeddata', panaskanDecoder, { once: true });
                    vid.addEventListener('canplay', panaskanDecoder, { once: true });
                    if (vid.readyState === 0 && vid.networkState === 0) {
                        try {
                            vid.load();
                        } catch (e) {}
                    }
                }
            },
            bukaUndangan() {
                this.undanganTerbuka = true;
                this.autoScrollJedaManual = false;

                // Prioritas utama: putar video motion hero serentak di frame klik agar menyatu mulus dengan animasi sampul naik
                const kurangiGerak = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                const modeEmbed = new URLSearchParams(window.location.search).get('embed') === '1';

                if (this.$refs.heroVideo && !this.videoHeroGagal) {
                    const vid = this.$refs.heroVideo;
                    this.videoHeroSelesai = false;

                    if (kurangiGerak || modeEmbed) {
                        this.teksHeroTampil = true;
                        this.videoHeroSedangIntro = false;
                        try {
                            const titikAkhir = Number.parseFloat(vid.dataset.settledAt || '') || Math.max(0, (vid.duration || 16) - 0.5);
                            vid.currentTime = Math.min(titikAkhir, Math.max(0, (vid.duration || 24) - 0.4));
                            vid.pause();
                        } catch (e) {}
                    } else {
                        this.teksHeroTampil = false;
                        this.videoHeroSedangIntro = true;
                        vid.muted = true;
                        const lajuPutar = Math.max(0.5, Math.min(2, Number.parseFloat(vid.dataset.playbackRate || '1') || 1));
                        vid.defaultPlaybackRate = lajuPutar;
                        vid.playbackRate = lajuPutar;

                        const mulaiDetik = this.videoHeroMulaiDetik || Number.parseFloat(vid.dataset.startAt || '0') || 0;
                        const sudahDiTitikAwal = vid.currentTime >= Math.max(0, mulaiDetik - 0.05) && vid.currentTime <= mulaiDetik + 0.12;

                        // Hindari seek ulang jika sudah pre-warmed agar decoder tidak flush / terjeda
                        if (!sudahDiTitikAwal && !vid.seeking) {
                            if (vid.readyState >= 1) {
                                try {
                                    vid.currentTime = Math.min(mulaiDetik, Math.max(0, (vid.duration || 20) - 1));
                                } catch (e) {}
                            } else if (mulaiDetik > 0) {
                                vid.addEventListener('loadedmetadata', () => {
                                    if (this.undanganTerbuka && this.videoHeroSedangIntro && !this.videoHeroSelesai && vid.currentTime < mulaiDetik) {
                                        try {
                                            vid.currentTime = Math.min(mulaiDetik, Math.max(0, (vid.duration || 20) - 1));
                                        } catch (e) {}
                                    }
                                }, { once: true });
                            }
                        }

                        const janjiPutar = vid.play();
                        if (janjiPutar && typeof janjiPutar.catch === 'function') {
                            janjiPutar.catch((err) => {
                                if (err && err.name === 'AbortError' && this.undanganTerbuka && !this.videoHeroGagal) {
                                    window.requestAnimationFrame(() => {
                                        if (this.undanganTerbuka && !this.videoHeroGagal && vid.paused) {
                                            vid.play().catch(() => {
                                                this.videoHeroGagal = true;
                                                this.teksHeroTampil = true;
                                                this.videoHeroSedangIntro = false;
                                                this.jadwalkanAutoScrollSetelahVideo(3800);
                                            });
                                        }
                                    });
                                    return;
                                }
                                this.videoHeroGagal = true;
                                this.teksHeroTampil = true;
                                this.videoHeroSedangIntro = false;
                                this.jadwalkanAutoScrollSetelahVideo(3800);
                            });
                        }

                        if (this.timerWatchdogHero) {
                            window.clearTimeout(this.timerWatchdogHero);
                        }
                        const ambangReveal = Number.parseFloat(vid.dataset.revealAt || '13.15');
                        const durasiWatchdog = Math.max(8000, Math.round((((ambangReveal - mulaiDetik) / lajuPutar) + 2.4) * 1000));
                        this.timerWatchdogHero = window.setTimeout(() => {
                            if (!this.teksHeroTampil) {
                                this.teksHeroTampil = true;
                                this.videoHeroSedangIntro = false;
                                this.jadwalkanAutoScrollSetelahVideo(3400);
                            }
                        }, durasiWatchdog);
                    }
                } else if (!kurangiGerak && !modeEmbed) {
                    const panggungHero = document.querySelector('[data-diorama-3d]');
                    const jedaAutoScroll = Number.parseInt(panggungHero?.dataset.autoscrollDelay || '3800', 10) || 3800;
                    const durasiIntro25d = Number.parseInt(panggungHero?.dataset.cinemaDuration || '0', 10) || 0;

                    if (durasiIntro25d > 0) {
                        this.cinema25dSelesai = false;
                        if (this.timerCinema25d) {
                            window.clearTimeout(this.timerCinema25d);
                        }
                        this.timerCinema25d = window.setTimeout(() => {
                            this.cinema25dSelesai = true;
                        }, durasiIntro25d);
                    }

                    this.jadwalkanAutoScrollSetelahVideo(jedaAutoScroll);
                }

                if (!modeEmbed && this.$refs.pemutarAudio) {
                    const audio = this.$refs.pemutarAudio;
                    const putarDenganFade = () => {
                        try {
                            audio.volume = 0.24;
                        } catch (e) {}
                        const janjiAudio = audio.play();
                        if (janjiAudio && typeof janjiAudio.then === 'function') {
                            janjiAudio.then(() => {
                                this.musikBerputar = true;
                                let vol = 0.24;
                                const timerFade = window.setInterval(() => {
                                    if (audio.paused || vol >= 0.82) {
                                        window.clearInterval(timerFade);
                                        return;
                                    }
                                    vol = Math.min(0.82, vol + 0.12);
                                    try {
                                        audio.volume = vol;
                                    } catch (e) {
                                        window.clearInterval(timerFade);
                                    }
                                }, 110);
                            }).catch(() => {
                                this.musikBerputar = false;
                            });
                        }
                    };

                    if (audio.readyState >= 2) {
                        putarDenganFade();
                    } else {
                        putarDenganFade();
                        audio.addEventListener('canplay', () => {
                            if (this.undanganTerbuka && audio.paused && !this.musikDijedaManual) {
                                putarDenganFade();
                            }
                        }, { once: true });
                    }
                }

                // Tunda pemindaian DOM reveal/AOS hingga animasi transisi sampul selesai agar tidak memicu layout spike di tengah transisi
                const jedaReveal = document.querySelector('.tirai-gulir-atas') ? 960 : 820;
                window.setTimeout(() => {
                    document.querySelectorAll('.masuk-3d').forEach((el) => {
                        const rect = el.getBoundingClientRect();
                        if (rect.top < window.innerHeight * 1.15 && rect.bottom > 0) {
                            el.classList.add('terlihat');
                        }
                    });
                    document.querySelectorAll(
                        '.fx-rise:not([data-gsap]), .fx-rise-down:not([data-gsap]), .fx-scale-in:not([data-gsap]), .fx-scale-out:not([data-gsap]), .fx-slide-left:not([data-gsap]), .fx-slide-right:not([data-gsap]), .fx-flip-in:not([data-gsap])'
                    ).forEach((el) => {
                        const rect = el.getBoundingClientRect();
                        if (rect.top < window.innerHeight * 1.15 && rect.bottom > 0) {
                            el.classList.add('active');
                            window.setTimeout(() => {
                                if (el.classList.contains('active')) {
                                    el.classList.add('fx-selesai');
                                }
                            }, 740);
                        }
                    });
                    if (window.SesiTemuSinema) {
                        window.SesiTemuSinema.aktifkanLenis();
                    }
                    if (window.AOS && document.querySelector('[data-aos]')) {
                        window.AOS.refreshHard();
                    }
                }, jedaReveal);
            },
            pantauVideoHero(acara) {
                const vid = acara?.target;
                if (!vid || this.teksHeroTampil) {
                    return;
                }
                const ambang = Number.parseFloat(vid.dataset.revealAt || '13.15');
                if (vid.currentTime >= ambang) {
                    this.teksHeroTampil = true;
                    this.videoHeroSedangIntro = false;
                    if (this.timerWatchdogHero) {
                        window.clearTimeout(this.timerWatchdogHero);
                        this.timerWatchdogHero = null;
                    }
                    this.jadwalkanAutoScrollSetelahVideo(3400);
                }
            },
            selesaiVideoHero() {
                this.teksHeroTampil = true;
                this.videoHeroSedangIntro = false;
                this.videoHeroSelesai = true;
                if (this.timerWatchdogHero) {
                    window.clearTimeout(this.timerWatchdogHero);
                    this.timerWatchdogHero = null;
                }
            },
            putarUlangVideoHero() {
                const vid = this.$refs.heroVideo;
                if (!vid) {
                    return;
                }
                this.hentikanAutoScroll(true);
                this.teksHeroTampil = false;
                this.videoHeroSedangIntro = true;
                this.videoHeroSelesai = false;
                try {
                    const mulaiDetik = this.videoHeroMulaiDetik || Number.parseFloat(vid.dataset.startAt || '0') || 0;
                    const lajuPutar = Math.max(0.5, Math.min(2, Number.parseFloat(vid.dataset.playbackRate || '1') || 1));
                    vid.defaultPlaybackRate = lajuPutar;
                    vid.playbackRate = lajuPutar;
                    vid.currentTime = Math.min(mulaiDetik, Math.max(0, (vid.duration || 20) - 1));
                    vid.play().catch(() => {
                        this.teksHeroTampil = true;
                        this.videoHeroSedangIntro = false;
                    });
                } catch (e) {
                    this.teksHeroTampil = true;
                    this.videoHeroSedangIntro = false;
                }
            },
            putarUlangCinema25d() {
                const panggungHero = document.querySelector('[data-diorama-3d]');
                const durasiIntro25d = Number.parseInt(panggungHero?.dataset.cinemaDuration || '4400', 10) || 4400;
                this.hentikanAutoScroll(true);
                this.cinema25dSelesai = false;
                this.cinema25dPutaran += 1;

                if (panggungHero) {
                    panggungHero.classList.remove('cinema-aktif');
                    void panggungHero.offsetWidth;
                    window.requestAnimationFrame(() => {
                        panggungHero.classList.add('cinema-aktif');
                    });
                }

                if (this.timerCinema25d) {
                    window.clearTimeout(this.timerCinema25d);
                }
                this.timerCinema25d = window.setTimeout(() => {
                    this.cinema25dSelesai = true;
                }, durasiIntro25d);
            },
            jadwalkanAutoScrollSetelahVideo(jedaMs = 3400) {
                const kurangiGerak = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                const modeEmbed = new URLSearchParams(window.location.search).get('embed') === '1';
                if (kurangiGerak || modeEmbed) {
                    return;
                }
                if (this.timerAutoScrollHero) {
                    window.clearTimeout(this.timerAutoScrollHero);
                }
                this.timerAutoScrollHero = window.setTimeout(() => {
                    if (this.undanganTerbuka && !this.autoScrollJedaManual && window.scrollY < 40) {
                        this.mulaiAutoScroll();
                    }
                }, jedaMs);
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
                if (window.SesiTemuSinema) {
                    window.SesiTemuSinema.jedaLenis();
                }
                document.documentElement.classList.add('mode-autoscroll');
                this.tampilkanToastAutoScroll();

                // Kecepatan dalam piksel per detik (bebas jitter di layar 60Hz, 120Hz, maupun 144Hz)
                const kecepatanPxPerDetik = {
                    1: 38,
                    2: 68,
                    3: 112
                };
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
                        this.autoScrollPosY + (kecepatanPxPerDetik[this.kecepatanScroll] || 68) * faktorHalus *
                        dt
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
                if (window.SesiTemuSinema && this.undanganTerbuka && !this.galeriModalTerbuka) {
                    window.SesiTemuSinema.lanjutLenis();
                }
            },
            toggleAutoScroll() {
                if (this.autoScrollAktif) {
                    this.hentikanAutoScroll(true);
                } else {
                    const batasBawah = document.documentElement.scrollHeight - window.innerHeight - 10;
                    if (window.scrollY >= batasBawah) {
                        window.scrollTo({
                            top: 0,
                            behavior: 'auto'
                        });
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
                if (window.SesiTemuSinema && window.SesiTemuSinema.gulirKeAtas()) {
                    return;
                }
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            },
            toggleMusik() {
                if (!this.$refs.pemutarAudio) {
                    return;
                }
                if (this.musikBerputar) {
                    this.musikDijedaManual = true;
                    this.$refs.pemutarAudio.pause();
                    this.musikBerputar = false;
                } else {
                    this.musikDijedaManual = false;
                    try {
                        this.$refs.pemutarAudio.volume = 0.82;
                    } catch (e) {}
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

    function kanvasSinemaTema(opsi = {}) {
        return {
            rafId: null,
            terlihat: false,
            init() {
                const kurangiGerak = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                if (kurangiGerak) {
                    return;
                }
                const canvas = this.$el;
                if (!canvas || !canvas.getContext) {
                    return;
                }
                const ctx = canvas.getContext('2d');
                if (!ctx) {
                    return;
                }

                const palet = {
                    kupuUtama: opsi.kupuUtama || '#D7A348',
                    kupuTepi: opsi.kupuTepi || '#6E2C2C',
                    kelopak: opsi.kelopak || ['#FFFDF8', '#F8EED8', '#E7C87D'],
                    kilau: opsi.kilau || '#F7E7B4',
                    burung: opsi.burung || 'rgba(74, 23, 23, 0.42)',
                    jumlahKupu: opsi.jumlahKupu ?? 5,
                    jumlahKelopak: opsi.jumlahKelopak ?? 18,
                    jumlahKilau: opsi.jumlahKilau ?? 26,
                };

                // Pre-render 1 sprite pendar emas di memori sekali saja (hindari createRadialGradient 28x setiap frame)
                const spriteKilau = document.createElement('canvas');
                spriteKilau.width = 24;
                spriteKilau.height = 24;
                const sCtx = spriteKilau.getContext('2d');
                if (sCtx) {
                    const grad = sCtx.createRadialGradient(12, 12, 0, 12, 12, 12);
                    grad.addColorStop(0, palet.kilau);
                    grad.addColorStop(1, 'rgba(247, 231, 180, 0)');
                    sCtx.fillStyle = grad;
                    sCtx.fillRect(0, 0, 24, 24);
                }

                let w = 0;
                let h = 0;
                let dpr = 1;
                let sedangIntersect = true;
                let lalu = performance.now();

                const hentikanLoop = () => {
                    if (this.rafId) {
                        window.cancelAnimationFrame(this.rafId);
                        this.rafId = null;
                    }
                };

                const cekAktif = () => {
                    const aktif = !document.hidden
                        && sedangIntersect
                        && canvas.offsetParent !== null
                        && canvas.clientWidth > 0
                        && canvas.clientHeight > 0;
                    this.terlihat = aktif;
                    if (aktif) {
                        if (!this.rafId) {
                            lalu = performance.now();
                            this.rafId = window.requestAnimationFrame(gambar);
                        }
                    } else {
                        hentikanLoop();
                    }
                };

                const sesuaikanUkuran = () => {
                    if (canvas.offsetParent === null || canvas.clientWidth === 0 || canvas.clientHeight === 0) {
                        cekAktif();
                        return;
                    }
                    const rect = canvas.getBoundingClientRect();
                    w = Math.max(200, rect.width || 390);
                    h = Math.max(300, rect.height || 760);
                    dpr = Math.min(1.5, window.devicePixelRatio || 1);
                    canvas.width = Math.round(w * dpr);
                    canvas.height = Math.round(h * dpr);
                    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
                    cekAktif();
                };

                // Inisialisasi kupu-kupu emas yang terbang anggun melengkung dari bawah ke atas
                const kupuList = Array.from({ length: palet.jumlahKupu }, (_, idx) => ({
                    fase: (idx / Math.max(1, palet.jumlahKupu)) * Math.PI * 2,
                    progres: (idx * 0.23) % 1,
                    kecepatan: 0.032 + (idx % 3) * 0.009,
                    ukuran: 7 + (idx % 3) * 2.8,
                    pusatX: 0.18 + ((idx * 0.19) % 0.68),
                    amplitudoX: 0.14 + (idx % 3) * 0.055,
                    frekSayap: 8.5 + (idx % 4) * 1.4,
                    arah: idx % 2 === 0 ? 1 : -1,
                }));

                // Kelopak melati melayang lembut di 3 lapis kedalaman
                const kelopakList = Array.from({ length: palet.jumlahKelopak }, (_, idx) => ({
                    x: Math.random(),
                    y: Math.random(),
                    vx: (Math.random() - 0.35) * 0.016,
                    vy: 0.018 + Math.random() * 0.024,
                    rx: 2.6 + Math.random() * 3.4,
                    ry: 1.5 + Math.random() * 2.2,
                    rot: Math.random() * Math.PI * 2,
                    vRot: (Math.random() - 0.5) * 1.2,
                    ayun: Math.random() * Math.PI * 2,
                    opasitas: 0.35 + Math.random() * 0.48,
                    warna: palet.kelopak[idx % palet.kelopak.length],
                }));

                // Partikel kilau emas naik perlahan
                const kilauList = Array.from({ length: palet.jumlahKilau }, () => ({
                    x: Math.random(),
                    y: Math.random(),
                    vy: 0.008 + Math.random() * 0.016,
                    r: 0.9 + Math.random() * 1.9,
                    fase: Math.random() * Math.PI * 2,
                    kecepatanKedip: 1.4 + Math.random() * 2.2,
                }));

                // Kawanan kecil burung di langit fajar
                const burungList = [
                    { progres: 0.12, y: 0.19, skala: 0.95, kec: 0.024, offset: 0 },
                    { progres: 0.06, y: 0.22, skala: 0.72, kec: 0.024, offset: 1.2 },
                    { progres: 0.02, y: 0.17, skala: 0.62, kec: 0.024, offset: 2.3 },
                ];

                const gambar = (sekarang) => {
                    if (document.hidden || !this.terlihat || canvas.offsetParent === null) {
                        this.rafId = null;
                        return;
                    }
                    this.rafId = window.requestAnimationFrame(gambar);
                    const dt = Math.min(0.05, Math.max(0.001, (sekarang - lalu) / 1000));
                    lalu = sekarang;
                    const t = sekarang / 1000;

                    ctx.clearRect(0, 0, w, h);

                    // 1. Burung melintas pelan di langit atas
                    ctx.strokeStyle = palet.burung;
                    ctx.lineCap = 'round';
                    for (let i = 0; i < burungList.length; i++) {
                        const b = burungList[i];
                        b.progres = (b.progres + b.kec * dt) % 1.35;
                        const bx = (b.progres - 0.15) * w;
                        const by = b.y * h - Math.sin(b.progres * Math.PI) * 26;
                        const kepak = Math.sin(t * 6.5 + b.offset) * 3.2 * b.skala;
                        const lebarSayap = 7.5 * b.skala;
                        ctx.lineWidth = 1.15 * b.skala;
                        ctx.beginPath();
                        ctx.moveTo(bx - lebarSayap, by - kepak);
                        ctx.quadraticCurveTo(bx - lebarSayap * 0.45, by - 3.5 * b.skala, bx, by);
                        ctx.quadraticCurveTo(bx + lebarSayap * 0.45, by - 3.5 * b.skala, bx + lebarSayap, by - kepak);
                        ctx.stroke();
                    }

                    // 2. Kilau debu emas berpendar halus (drawImage sprite ter-cache, 0 alokasi per frame)
                    for (let i = 0; i < kilauList.length; i++) {
                        const k = kilauList[i];
                        k.y -= k.vy * dt;
                        if (k.y < -0.05) {
                            k.y = 1.05;
                            k.x = Math.random();
                        }
                        const alpha = 0.16 + 0.55 * (0.5 + 0.5 * Math.sin(t * k.kecepatanKedip + k.fase));
                        const kx = k.x * w + Math.sin(t * 0.9 + k.fase) * 8;
                        const ky = k.y * h;
                        const ukuran = k.r * 6.8;
                        ctx.globalAlpha = alpha;
                        ctx.drawImage(spriteKilau, kx - ukuran * 0.5, ky - ukuran * 0.5, ukuran, ukuran);
                    }

                    // 3. Kelopak melati melayang
                    for (let i = 0; i < kelopakList.length; i++) {
                        const p = kelopakList[i];
                        p.y += p.vy * dt;
                        p.x += (p.vx + Math.sin(t * 1.1 + p.ayun) * 0.012) * dt;
                        p.rot += p.vRot * dt;
                        if (p.y > 1.06) {
                            p.y = -0.06;
                            p.x = Math.random();
                        }
                        if (p.x > 1.08) p.x = -0.06;
                        if (p.x < -0.08) p.x = 1.06;
                        ctx.save();
                        ctx.translate(p.x * w, p.y * h);
                        ctx.rotate(p.rot);
                        ctx.globalAlpha = p.opasitas;
                        ctx.fillStyle = p.warna;
                        ctx.beginPath();
                        ctx.ellipse(0, 0, p.rx, p.ry, 0, 0, Math.PI * 2);
                        ctx.fill();
                        ctx.restore();
                    }

                    // 4. Kupu-kupu emas mengepak anggun naik dari bunga depan ke sekeliling bingkai
                    for (let i = 0; i < kupuList.length; i++) {
                        const kp = kupuList[i];
                        kp.progres = (kp.progres + kp.kecepatan * dt) % 1;
                        const u = kp.progres;
                        const fade = u < 0.12 ? u / 0.12 : (u > 0.85 ? (1 - u) / 0.15 : 1);
                        const xNorm = kp.pusatX + Math.sin(u * Math.PI * 2.4 + kp.fase) * kp.amplitudoX * kp.arah;
                        const yNorm = 0.94 - u * 0.82 + Math.sin(u * Math.PI * 5 + kp.fase) * 0.025;
                        const dx = Math.cos(u * Math.PI * 2.4 + kp.fase) * kp.amplitudoX * kp.arah;
                        const sudutGerak = Math.atan2(-0.82, dx * 2.2) + Math.PI / 2;
                        const kepak = 0.26 + 0.74 * Math.abs(Math.sin(t * kp.frekSayap + kp.fase));
                        const s = kp.ukuran;

                        ctx.save();
                        ctx.translate(xNorm * w, yNorm * h);
                        ctx.rotate(sudutGerak * 0.45);
                        ctx.globalAlpha = Math.max(0, Math.min(0.92, fade * 0.9));

                        // Sayap kiri & kanan dengan skala kepak perspektif
                        for (const sisi of [-1, 1]) {
                            ctx.save();
                            ctx.scale(sisi * kepak, 1);
                            ctx.fillStyle = palet.kupuUtama;
                            ctx.strokeStyle = palet.kupuTepi;
                            ctx.lineWidth = 0.7;

                            // Sayap atas
                            ctx.beginPath();
                            ctx.moveTo(0, 0);
                            ctx.bezierCurveTo(s * 0.75, -s * 1.15, s * 1.65, -s * 0.55, s * 1.15, s * 0.18);
                            ctx.bezierCurveTo(s * 0.7, s * 0.32, s * 0.25, s * 0.12, 0, 0);
                            ctx.fill();
                            ctx.stroke();

                            // Sayap bawah
                            ctx.beginPath();
                            ctx.moveTo(0, s * 0.08);
                            ctx.bezierCurveTo(s * 0.9, s * 0.25, s * 1.05, s * 1.05, s * 0.35, s * 0.95);
                            ctx.bezierCurveTo(s * 0.1, s * 0.85, 0, s * 0.45, 0, s * 0.08);
                            ctx.fill();
                            ctx.stroke();
                            ctx.restore();
                        }

                        // Tubuh kupu-kupu mungil
                        ctx.fillStyle = palet.kupuTepi;
                        ctx.beginPath();
                        ctx.ellipse(0, s * 0.18, s * 0.12, s * 0.42, 0, 0, Math.PI * 2);
                        ctx.fill();
                        ctx.restore();
                    }

                    ctx.globalAlpha = 1;
                };

                const ro = 'ResizeObserver' in window ? new ResizeObserver(sesuaikanUkuran) : null;
                if (ro) {
                    ro.observe(canvas);
                }

                if ('IntersectionObserver' in window) {
                    const io = new IntersectionObserver((entries) => {
                        sedangIntersect = entries.some((e) => e.isIntersecting);
                        cekAktif();
                    }, { threshold: 0.05 });
                    io.observe(canvas);
                }

                document.addEventListener('visibilitychange', cekAktif);
                sesuaikanUkuran();
            },
        };
    }

    function galeriPanggung(daftarFoto = []) {
        return {
            daftar: Array.isArray(daftarFoto) ? daftarFoto : [],
            indeks: 0,
            init() {
                if (this.daftar.length > 1) {
                    window.setInterval(() => {
                        if (!document.hidden) {
                            this.indeks = (this.indeks + 1) % this.daftar.length;
                        }
                    }, 5500);
                }
            },
            pilih(i) {
                if (i >= 0 && i < this.daftar.length) {
                    this.indeks = i;
                }
            },
            aktif() {
                return this.daftar[this.indeks] || null;
            }
        };
    }

    function hitungMundurPanggung(isoTarget) {
        return {
            targetMs: isoTarget ? new Date(isoTarget).getTime() : 0,
            hari: '00',
            jam: '00',
            menit: '00',
            detik: '00',
            perbarui() {
                if (!this.targetMs || Number.isNaN(this.targetMs)) {
                    return;
                }
                const selisih = Math.max(0, this.targetMs - Date.now());
                this.hari = String(Math.floor(selisih / 86400000)).padStart(2, '0');
                this.jam = String(Math.floor((selisih % 86400000) / 3600000)).padStart(2, '0');
                this.menit = String(Math.floor((selisih % 3600000) / 60000)).padStart(2, '0');
                this.detik = String(Math.floor((selisih % 60000) / 1000)).padStart(2, '0');
            },
            init() {
                this.perbarui();
                if (this.targetMs && !Number.isNaN(this.targetMs)) {
                    window.setInterval(() => this.perbarui(), 1000);
                }
            }
        };
    }

    function bukuTamuDemo(ucapanAwal = [], namaDefault = '') {
        return {
            daftarUcapan: Array.isArray(ucapanAwal) ? ucapanAwal.slice() : [],
            namaTamu: namaDefault && namaDefault !== 'Tamu Undangan' ? namaDefault : '',
            statusKehadiran: 'hadir',
            jumlahTamu: 1,
            ucapanDoa: '',
            pesanSukses: '',
            pesanGalat: '',
            labelStatus(kode) {
                const peta = {
                    hadir: 'Hadir',
                    ragu: 'Masih Ragu',
                    tidak_hadir: 'Tidak Hadir',
                };
                return peta[kode] || String(kode || 'Hadir').replaceAll('_', ' ');
            },
            kelasStatus(kode, gelap = false, defaultKelas = '') {
                if (kode === 'tidak_hadir') {
                    return gelap
                        ? 'bg-red-500/20 text-red-300 border border-red-400/45'
                        : 'bg-red-100 text-red-700 border border-red-200';
                }
                if (kode === 'ragu') {
                    return gelap
                        ? 'bg-amber-400/20 text-amber-300 border border-amber-400/45'
                        : 'bg-amber-100 text-amber-800 border border-amber-200';
                }
                return defaultKelas || (gelap
                    ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-400/40'
                    : 'bg-emerald-100 text-emerald-800 border border-emerald-200');
            },
            kirimUcapanDemo() {
                const nama = String(this.namaTamu || '').trim();
                const doa = String(this.ucapanDoa || '').trim();
                const statusTerpilih = this.$refs.selectKehadiran
                    ? String(this.$refs.selectKehadiran.value || 'hadir')
                    : String(this.statusKehadiran || 'hadir');
                this.statusKehadiran = statusTerpilih;
                const jumlah = statusTerpilih === 'hadir'
                    ? Math.max(1, Math.min(20, Number.parseInt(this.jumlahTamu, 10) || 1))
                    : 0;

                if (!nama || !doa) {
                    this.pesanGalat = 'Mohon isi nama tamu serta ucapan & doa terlebih dahulu.';
                    this.pesanSukses = '';
                    return;
                }

                this.daftarUcapan.unshift({
                    id: `demo-${Date.now()}-${Math.random().toString(36).slice(2, 7)}`,
                    nama_tamu: nama,
                    status_kehadiran: statusTerpilih,
                    jumlah_tamu: jumlah,
                    ucapan_doa: doa,
                    waktu: 'Baru saja',
                    baru: true,
                });

                this.ucapanDoa = '';
                this.pesanGalat = '';
                this.pesanSukses = 'Ucapan berhasil ditambahkan.';

                this.$nextTick(() => {
                    if (this.$refs.daftarUcapanScroll) {
                        this.$refs.daftarUcapanScroll.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }
                });
            },
        };
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (window.AOS && document.querySelector('[data-aos]')) {
            window.AOS.init({
                duration: 850,
                easing: 'ease-out-cubic',
                once: false,
                mirror: true,
                offset: 36,
            });
        }
    });
</script>
