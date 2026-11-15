<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    function temaUndangan() {
        return {
            undanganTerbuka: false,
            musikBerputar: false,
            galeriModalTerbuka: false,
            galeriAktifUrl: '',
            galeriAktifKeterangan: '',
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
                    if (window.AOS) {
                        window.AOS.refreshHard();
                    }
                }, 400);
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
