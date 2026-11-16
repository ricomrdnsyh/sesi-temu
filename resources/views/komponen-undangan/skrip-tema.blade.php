<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    function temaUndangan() {
        return {
            undanganTerbuka: false,
            musikBerputar: false,
            galeriModalTerbuka: false,
            galeriAktifUrl: '',
            galeriAktifKeterangan: '',
            scrollPersen: 0,
            init() {
                document.body.classList.add('siap-3d');

                const perbaruiScroll = () => {
                    const total = document.documentElement.scrollHeight - window.innerHeight;
                    this.scrollPersen = total > 0 ? Math.min(100, Math.round((window.scrollY / total) * 100)) : 0;
                    const geserScroll = Math.min(24, Math.round(window.scrollY * 0.035));
                    document.querySelectorAll('[data-panggung-3d]').forEach((el) => {
                        el.style.setProperty('--ps', `${geserScroll}px`);
                    });
                };

                window.addEventListener('scroll', perbaruiScroll, { passive: true });
                perbaruiScroll();

                this.inisialisasiParallax3D();
                this.inisialisasiKartuTilt3D();
                this.inisialisasiMasuk3D();
            },
            inisialisasiParallax3D() {
                const mediaKurangiGerak = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                if (mediaKurangiGerak) {
                    return;
                }

                document.querySelectorAll('[data-panggung-3d]').forEach((panggung) => {
                    panggung.addEventListener('pointermove', (acara) => {
                        if (acara.pointerType === 'touch') {
                            return;
                        }
                        const rect = panggung.getBoundingClientRect();
                        if (rect.width === 0 || rect.height === 0) {
                            return;
                        }
                        const nx = ((acara.clientX - rect.left) / rect.width - 0.5) * 2;
                        const ny = ((acara.clientY - rect.top) / rect.height - 0.5) * 2;
                        panggung.style.setProperty('--px', nx.toFixed(3));
                        panggung.style.setProperty('--py', ny.toFixed(3));
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
                        const rect = kartu.getBoundingClientRect();
                        if (rect.width === 0 || rect.height === 0) {
                            return;
                        }
                        const dx = (acara.clientX - rect.left) / rect.width - 0.5;
                        const dy = (acara.clientY - rect.top) / rect.height - 0.5;
                        const rx = (-dy * 6.5).toFixed(2);
                        const ry = (dx * 7.5).toFixed(2);
                        kartu.style.setProperty('--rx', `${rx}deg`);
                        kartu.style.setProperty('--ry', `${ry}deg`);
                    });

                    kartu.addEventListener('pointerleave', () => {
                        kartu.style.setProperty('--rx', '0deg');
                        kartu.style.setProperty('--ry', '0deg');
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
                }, { threshold: 0.12 });

                elemen.forEach((el) => observer.observe(el));
            },
            bukaUndangan() {
                this.undanganTerbuka = true;
                if (this.$refs.pemutarAudio) {
                    this.$refs.pemutarAudio.play().then(() => {
                        this.musikBerputar = true;
                    }).catch(() => {
                        this.musikBerputar = false;
                    });
                }
                setTimeout(() => {
                    document.querySelectorAll('.masuk-3d').forEach((el) => {
                        const rect = el.getBoundingClientRect();
                        if (rect.top < window.innerHeight * 1.15) {
                            el.classList.add('terlihat');
                        }
                    });
                    if (window.AOS) {
                        window.AOS.refreshHard();
                    }
                }, 420);
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
            }
        };
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (window.AOS) {
            window.AOS.init({
                duration: 1000,
                once: true,
                offset: 40,
            });
        }
    });
</script>
