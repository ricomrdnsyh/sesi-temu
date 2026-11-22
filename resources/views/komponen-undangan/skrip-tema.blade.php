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
            teksHeroTampil: true,
            videoHeroSedangIntro: false,
            videoHeroGagal: false,
            videoHeroSelesai: false,
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
                    const kurangiGerak = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                    const modeEmbed = new URLSearchParams(window.location.search).get('embed') === '1';
                    this.teksHeroTampil = kurangiGerak || modeEmbed;
                    if (kurangiGerak || modeEmbed) {
                        const vid = this.$refs.heroVideo;
                        const lompatAkhir = () => {
                            try {
                                vid.currentTime = Math.min(15.5, (vid.duration || 16) - 0.5);
                                vid.pause();
                            } catch (e) {}
                        };
                        if (vid.readyState >= 1) {
                            lompatAkhir();
                        } else {
                            vid.addEventListener('loadedmetadata', lompatAkhir, { once: true });
                        }
                    }
                }

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
                this.inisialisasiKartuTilt3D();
                this.inisialisasiMasuk3D();
                this.inisialisasiFxReveal();
            },
            inisialisasiParallax3D() {
                const mediaKurangiGerak = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)')
                    .matches;
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
                    }, {
                        passive: true
                    });

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
                    }, {
                        passive: true
                    });

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
                }, {
                    threshold: 0.08,
                    rootMargin: '0px 0px -16px 0px'
                });

                elemen.forEach((el) => observer.observe(el));
            },
            inisialisasiFxReveal() {
                const selektor =
                    '.fx-rise, .fx-rise-down, .fx-scale-in, .fx-scale-out, .fx-slide-left, .fx-slide-right, .fx-flip-in';
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
                }, {
                    threshold: 0.08,
                    rootMargin: '0px 0px -18px 0px'
                });

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
                    document.querySelectorAll(
                        '.fx-rise, .fx-rise-down, .fx-scale-in, .fx-scale-out, .fx-slide-left, .fx-slide-right, .fx-flip-in'
                    ).forEach((el) => {
                        const rect = el.getBoundingClientRect();
                        if (rect.top < window.innerHeight * 1.15) {
                            el.classList.add('active');
                        }
                    });
                    if (window.AOS) {
                        window.AOS.refreshHard();
                    }
                }, 380);

                // Aktifkan pemutaran video motion hero jika tersedia, lalu jadwalkan Auto-Scroll Cinema
                const kurangiGerak = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                const modeEmbed = new URLSearchParams(window.location.search).get('embed') === '1';

                if (this.$refs.heroVideo && !this.videoHeroGagal) {
                    const vid = this.$refs.heroVideo;
                    this.videoHeroSelesai = false;

                    if (kurangiGerak || modeEmbed) {
                        this.teksHeroTampil = true;
                        this.videoHeroSedangIntro = false;
                        try {
                            vid.currentTime = Math.min(15.5, (vid.duration || 16) - 0.5);
                            vid.pause();
                        } catch (e) {}
                    } else {
                        this.teksHeroTampil = false;
                        this.videoHeroSedangIntro = true;
                        try {
                            vid.currentTime = 0;
                        } catch (e) {}

                        const janjiPutar = vid.play();
                        if (janjiPutar && typeof janjiPutar.catch === 'function') {
                            janjiPutar.catch(() => {
                                this.videoHeroGagal = true;
                                this.teksHeroTampil = true;
                                this.videoHeroSedangIntro = false;
                                this.jadwalkanAutoScrollSetelahVideo(3800);
                            });
                        }

                        if (this.timerWatchdogHero) {
                            window.clearTimeout(this.timerWatchdogHero);
                        }
                        this.timerWatchdogHero = window.setTimeout(() => {
                            if (!this.teksHeroTampil) {
                                this.teksHeroTampil = true;
                                this.videoHeroSedangIntro = false;
                                this.jadwalkanAutoScrollSetelahVideo(3400);
                            }
                        }, 14800);
                    }
                } else if (!kurangiGerak && !modeEmbed) {
                    this.jadwalkanAutoScrollSetelahVideo(3800);
                }
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
            lewatiIntroVideo() {
                const vid = this.$refs.heroVideo;
                if (vid) {
                    try {
                        const titikSettled = Number.parseFloat(vid.dataset.settledAt || '14.5');
                        vid.currentTime = Math.min(titikSettled, Math.max(0, (vid.duration || 19) - 0.5));
                        vid.play().catch(() => {});
                    } catch (e) {}
                }
                this.teksHeroTampil = true;
                this.videoHeroSedangIntro = false;
                if (this.timerWatchdogHero) {
                    window.clearTimeout(this.timerWatchdogHero);
                    this.timerWatchdogHero = null;
                }
                this.jadwalkanAutoScrollSetelahVideo(3200);
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
                    vid.currentTime = 0;
                    vid.play().catch(() => {
                        this.teksHeroTampil = true;
                        this.videoHeroSedangIntro = false;
                    });
                } catch (e) {
                    this.teksHeroTampil = true;
                    this.videoHeroSedangIntro = false;
                }
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
                once: true,
                offset: 36,
            });
        }
    });
</script>
