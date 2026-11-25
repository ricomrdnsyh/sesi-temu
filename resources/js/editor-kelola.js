export function editorKelolaUndangan(cfg) {
    return {
        tab: cfg.tab,
        urutanTab: ['tema', 'mempelai', 'acara', 'cerita', 'galeri', 'amplop', 'penutup', 'aktivasi'],
        urlPublikPreview: cfg.urlPublikPreview,
        urlSimpanFitur: cfg.urlSimpanFitur,
        urlPratinjauLangsung: cfg.urlPratinjauLangsung,
        csrfToken: cfg.csrfToken,
        modePreview: 'mobile',
        previewKey: 1,
        previewMemuat: true,
        livePreviewAktif: false,
        livePreviewMenyinkron: false,
        livePreviewTimer: null,
        livePreviewAbort: null,
        fotoLiveMap: {},
        previewScale: 0.9,
        previewStudioScale: 0.56,
        previewObserver: null,
        previewStudioObserver: null,
        namaPriaLive: cfg.namaPriaLive,
        namaWanitaLive: cfg.namaWanitaLive,
        tanpaFotoAktif: cfg.tanpaFotoAktif,
        sakelarFitur: cfg.sakelarFitur,
        fiturMenyimpan: {},
        musikDipilih: cfg.musikDipilih,
        daftarUrlMusik: cfg.daftarUrlMusik,
        audioSedangPutar: false,
        slugTersalin: false,
        daftarCerita: cfg.daftarCerita,
        liveAktifLive: cfg.liveAktifLive,
        katalogBank: cfg.katalogBank,
        bankBaru: '',
        nomorBaru: '',
        atasNamaBaru: '',
        acaraEdit: null,
        galeriLightbox: null,
        drawerTemaTerbuka: false,
        kategoriDrawerTema: 'semua',
        cariDrawerTema: '',
        tabMobileStudio: 'daftar',
        sumberPreviewStudio: 'undangan',
        previewStudioMemuat: false,
        temaAktifEditorId: cfg.temaAktifEditorId,
        hargaTemaAktifEditor: cfg.hargaTemaAktifEditor,
        temaAwalStudio: cfg.temaAwalStudio,
        temaPreviewStudio: cfg.temaAwalStudio,
        temaKonfirmasi: null,
        init() {
            if (this.tab) {
                this.$nextTick(() => {
                    const el = this.$el.querySelector(`[data-mobile-tab='${this.tab}']`);
                    el?.scrollIntoView({ behavior: 'auto', block: 'nearest' });
                });
            }
            this.$nextTick(() => {
                this.hitungSkalaPreview();
                this.hitungSkalaPreviewStudio();
                if (typeof ResizeObserver !== 'undefined') {
                    if (this.$refs.stagePreview) {
                        this.previewObserver = new ResizeObserver(() => this.hitungSkalaPreview());
                        this.previewObserver.observe(this.$refs.stagePreview);
                    }
                    const stageStudio = this.$el.querySelector('[data-stage-preview-studio]');
                    if (stageStudio) {
                        this.previewStudioObserver = new ResizeObserver(() => this.hitungSkalaPreviewStudio());
                        this.previewStudioObserver.observe(stageStudio);
                    }
                }
            });
            window.addEventListener('resize', () => {
                this.hitungSkalaPreview();
                this.hitungSkalaPreviewStudio();
            });
            this.$watch('tanpaFotoAktif', () => this.jadwalkanLivePreview(true));
            this.$watch('liveAktifLive', () => this.jadwalkanLivePreview(true));
            setTimeout(() => {
                this.previewMemuat = false;
            }, 2500);
        },
        previewVirtualW() {
            return this.modePreview === 'mobile' ? 390 : 1280;
        },
        previewVirtualH() {
            return this.modePreview === 'mobile' ? 780 : 800;
        },
        hitungSkalaPreview() {
            const stage = this.$refs.stagePreview;
            if (!stage || stage.clientWidth === 0 || stage.clientHeight === 0) return;
            const padX = this.modePreview === 'mobile' ? 40 : 32;
            const padY = this.modePreview === 'mobile' ? 44 : 32;
            const tersediaW = Math.max(180, stage.clientWidth - padX);
            const tersediaH = Math.max(240, stage.clientHeight - padY);
            const batasMaks = this.modePreview === 'mobile' ? 1.55 : 1.25;
            const skala = Math.min(tersediaW / this.previewVirtualW(), tersediaH / this.previewVirtualH(), batasMaks);
            this.previewScale = Math.max(0.28, Number(skala.toFixed(4)));
        },
        hitungSkalaPreviewStudio() {
            const stage = this.$el.querySelector('[data-stage-preview-studio]');
            if (!stage || stage.clientWidth === 0 || stage.clientHeight === 0) return;
            const tersediaW = Math.max(160, stage.clientWidth - 28);
            const tersediaH = Math.max(220, stage.clientHeight - 24);
            const skala = Math.min(tersediaW / 390, tersediaH / 780, 1.0);
            this.previewStudioScale = Math.max(0.28, Number(skala.toFixed(4)));
        },
        ubahModePreview(mode) {
            this.modePreview = mode;
            this.$nextTick(() => this.hitungSkalaPreview());
        },
        urlPreviewAktif() {
            const pemisah = this.urlPublikPreview.includes('?') ? '&' : '?';
            return `${this.urlPublikPreview}${pemisah}_preview=${this.previewKey}`;
        },
        muatUlangPreview() {
            if (this.livePreviewAktif) {
                this.kirimLivePreview();
                return;
            }
            this.previewMemuat = true;
            this.previewKey++;
            setTimeout(() => {
                this.previewMemuat = false;
            }, 2500);
        },
        perbaruiFotoLive(detail) {
            if (!detail?.nama) return;
            if (['foto_pria', 'foto_wanita', 'foto_sampul', 'foto_pembuka', 'foto_penutup', 'foto_latar_tema'].includes(detail.nama)) {
                this.fotoLiveMap = { ...this.fotoLiveMap, [detail.nama]: detail.url || '' };
                this.jadwalkanLivePreview(true);
            }
        },
        saatInputLive(event) {
            const el = event?.target;
            if (!el || !el.name) return;
            const namaDiabaikan = [
                'slug', 'musik_latar', 'tema_id', 'acara_id',
                'nama_acara', 'tanggal_acara', 'waktu_mulai', 'waktu_selesai', 'zona_waktu', 'nama_tempat', 'alamat_lengkap', 'link_maps',
                'foto', 'keterangan', 'nama_bank', 'nomor_rekening', 'atas_nama',
                'paket', 'kode_promo', 'bukti_pembayaran',
            ];
            if (namaDiabaikan.includes(el.name)) return;
            const segera = el.tagName === 'SELECT' || el.type === 'checkbox' || el.type === 'color';
            this.jadwalkanLivePreview(segera);
        },
        jadwalkanLivePreview(segera = false, fokusBagian = '') {
            if (typeof window === 'undefined' || window.innerWidth < 1024) return;
            if (this.livePreviewTimer) {
                window.clearTimeout(this.livePreviewTimer);
                this.livePreviewTimer = null;
            }
            if (segera) {
                this.kirimLivePreview(fokusBagian);
                return;
            }
            this.livePreviewTimer = window.setTimeout(() => {
                this.livePreviewTimer = null;
                this.kirimLivePreview(fokusBagian);
            }, 420);
        },
        kumpulkanPayloadLive(fokusBagian = '') {
            const root = this.$refs.panelKiri;
            const nilai = (nama) => {
                const el = root?.querySelector(`[name='${nama}']`);
                return el ? el.value : undefined;
            };
            const tercentang = (nama) => Boolean(root?.querySelector(`[name='${nama}']`)?.checked);

            const teks = {};
            root?.querySelectorAll('[name^="teks["]').forEach((el) => {
                const cocok = el.name.match(/^teks\[([^\]]+)\]$/);
                if (cocok) teks[cocok[1]] = el.value ?? '';
            });

            const warnaDressCode = [];
            root?.querySelectorAll('[name^="dress_code_warna["]').forEach((el) => {
                if (el.value) warnaDressCode.push(el.value);
            });

            let scrollY = 0;
            let sampulSudahTerbuka = false;
            try {
                const iframeWin = this.$refs.iframePreview?.contentWindow;
                const iframeDoc = iframeWin?.document;
                scrollY = Math.max(0, Math.round(iframeWin?.scrollY || 0));
                const tirai = iframeDoc?.querySelector('[data-transisi-sampul]');
                sampulSudahTerbuka = Boolean(
                    !tirai ||
                    tirai.classList.contains('tirai-terbuka') ||
                    window.getComputedStyle(tirai).display === 'none'
                );
            } catch (_) {}

            const tabAktif = fokusBagian || this.tab;
            const bukaSampul = fokusBagian === 'tema'
                ? false
                : (['mempelai', 'acara', 'cerita', 'galeri', 'amplop', 'penutup'].includes(tabAktif)
                    ? true
                    : sampulSudahTerbuka);

            return {
                gaya_font: nilai('gaya_font'),
                tanpa_foto: this.tanpaFotoAktif,
                fitur_aktif: { ...this.sakelarFitur },
                nama_panggilan_pria: nilai('nama_panggilan_pria'),
                nama_lengkap_pria: nilai('nama_lengkap_pria'),
                nama_ayah_pria: nilai('nama_ayah_pria'),
                nama_ibu_pria: nilai('nama_ibu_pria'),
                instagram_pria: nilai('instagram_pria'),
                nama_panggilan_wanita: nilai('nama_panggilan_wanita'),
                nama_lengkap_wanita: nilai('nama_lengkap_wanita'),
                nama_ayah_wanita: nilai('nama_ayah_wanita'),
                nama_ibu_wanita: nilai('nama_ibu_wanita'),
                instagram_wanita: nilai('instagram_wanita'),
                kutipan_ayat: nilai('kutipan_ayat'),
                teks,
                doa_disertakan: true,
                dress_code_catatan: nilai('dress_code_catatan'),
                dress_code_warna: warnaDressCode,
                live_aktif: this.liveAktifLive,
                live_platform: nilai('live_platform'),
                live_link: nilai('live_link'),
                alamat_kado_fisik: nilai('alamat_kado_fisik'),
                turut_mengundang_wanita: nilai('turut_mengundang_wanita'),
                turut_mengundang_pria: nilai('turut_mengundang_pria'),
                hashtag: nilai('hashtag'),
                cerita_cinta: this.daftarCerita,
                foto_live: this.fotoLiveMap,
                hapus_foto_sampul: tercentang('hapus_foto_sampul'),
                hapus_foto_pembuka: tercentang('hapus_foto_pembuka'),
                hapus_foto_penutup: tercentang('hapus_foto_penutup'),
                hapus_foto_latar_tema: tercentang('hapus_foto_latar_tema'),
                buka_sampul: bukaSampul,
                scroll_y: fokusBagian ? 0 : scrollY,
                fokus_bagian: fokusBagian || '',
            };
        },
        async kirimLivePreview(fokusBagian = '') {
            const iframe = this.$refs.iframePreview;
            if (!iframe || typeof window === 'undefined' || window.innerWidth < 1024) return;
            if (this.livePreviewAbort) {
                this.livePreviewAbort.abort();
            }
            const controller = new AbortController();
            this.livePreviewAbort = controller;
            this.livePreviewMenyinkron = true;

            try {
                const token = document.querySelector('meta[name=csrf-token]')?.content || this.csrfToken;
                const respon = await fetch(this.urlPratinjauLangsung, {
                    method: 'POST',
                    credentials: 'same-origin',
                    signal: controller.signal,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'text/html',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify(this.kumpulkanPayloadLive(fokusBagian)),
                });
                if (!respon.ok) return;
                const html = await respon.text();
                if (controller.signal.aborted) return;
                this.livePreviewAktif = true;
                this.previewMemuat = false;
                iframe.srcdoc = html;
            } catch (err) {
                if (err?.name !== 'AbortError') {
                    // Biarkan pratinjau terakhir tetap tampil bila jaringan tersendat
                }
            } finally {
                if (this.livePreviewAbort === controller) {
                    this.livePreviewAbort = null;
                    this.livePreviewMenyinkron = false;
                }
            }
        },
        async toggleFitur(kunci) {
            if (this.fiturMenyimpan[kunci]) return;
            const nilaiLama = Boolean(this.sakelarFitur[kunci]);
            const nilaiBaru = !nilaiLama;
            this.sakelarFitur[kunci] = nilaiBaru;
            this.fiturMenyimpan[kunci] = true;
            this.jadwalkanLivePreview(true);
            try {
                const token = document.querySelector('meta[name=csrf-token]')?.content || this.csrfToken;
                const respon = await fetch(this.urlSimpanFitur, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify({ _method: 'PUT', bagian: 'fitur', kunci, aktif: nilaiBaru }),
                });
                if (!respon.ok) throw new Error('Gagal');
            } catch (_) {
                this.sakelarFitur[kunci] = nilaiLama;
                this.jadwalkanLivePreview(true);
                window.Swal?.fire({
                    icon: 'error',
                    title: 'Gagal Menyimpan Status',
                    text: 'Tidak dapat memperbarui status fitur saat ini. Silakan coba lagi.',
                    confirmButtonColor: '#4B6358',
                });
            } finally {
                this.fiturMenyimpan[kunci] = false;
            }
        },
        toggleBagian(kodeTab) {
            this.hentikanAudioPreview();
            if (this.tab === kodeTab) {
                this.tab = '';
                return;
            }
            this.tab = kodeTab;
            this.$nextTick(() => {
                const el = this.$el.querySelector(`[data-mobile-tab='${kodeTab}']`);
                el?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                if (['tema', 'mempelai', 'acara', 'cerita', 'galeri', 'amplop', 'penutup'].includes(kodeTab)) {
                    this.jadwalkanLivePreview(true, kodeTab);
                }
            });
        },
        bukaBagian(kodeTab) {
            this.hentikanAudioPreview();
            this.tab = kodeTab;
            this.$nextTick(() => {
                const el = this.$el.querySelector(`[data-mobile-tab='${kodeTab}']`);
                el?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                if (['tema', 'mempelai', 'acara', 'cerita', 'galeri', 'amplop', 'penutup'].includes(kodeTab)) {
                    this.jadwalkanLivePreview(true, kodeTab);
                }
            });
        },
        pilihTab(kodeTab) {
            this.bukaBagian(kodeTab);
        },
        bukaDrawerTema() {
            this.temaPreviewStudio = this.temaAwalStudio;
            this.sumberPreviewStudio = 'undangan';
            this.tabMobileStudio = 'daftar';
            this.previewStudioMemuat = true;
            this.drawerTemaTerbuka = true;
            this.temaKonfirmasi = null;
            this.$nextTick(() => this.hitungSkalaPreviewStudio());
            setTimeout(() => {
                this.previewStudioMemuat = false;
            }, 2500);
        },
        tutupDrawerTema() {
            this.drawerTemaTerbuka = false;
            this.temaKonfirmasi = null;
        },
        pilihTemaStudio(payload) {
            if (!payload) return;
            if (this.temaPreviewStudio?.id !== payload.id) {
                this.previewStudioMemuat = true;
                setTimeout(() => {
                    this.previewStudioMemuat = false;
                }, 2500);
            }
            this.temaPreviewStudio = payload;
        },
        ubahSumberPreviewStudio(sumber) {
            if (this.sumberPreviewStudio === sumber) return;
            this.sumberPreviewStudio = sumber;
            this.previewStudioMemuat = true;
            setTimeout(() => {
                this.previewStudioMemuat = false;
            }, 2500);
        },
        urlPreviewStudio() {
            if (!this.drawerTemaTerbuka || !this.temaPreviewStudio) {
                return 'about:blank';
            }
            return this.sumberPreviewStudio === 'demo'
                ? this.temaPreviewStudio.url_demo_embed
                : this.temaPreviewStudio.url_pratinjau;
        },
        selisihHargaStudio() {
            if (!this.temaPreviewStudio) {
                return { teks: '', kelas: '' };
            }
            const selisih = Number(this.temaPreviewStudio.harga_nominal || 0) - Number(this.hargaTemaAktifEditor || 0);
            if (selisih === 0) {
                return { teks: 'Harga Sama', kelas: 'bg-ivory text-charcoal/70 ring-1 ring-champagne/30' };
            }
            const nominal = 'Rp ' + Math.abs(selisih).toLocaleString('id-ID');
            if (selisih > 0) {
                return { teks: '+' + nominal, kelas: 'bg-amber-50 text-amber-800 ring-1 ring-amber-200' };
            }
            return { teks: 'Hemat ' + nominal, kelas: 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' };
        },
        pilihTemaKonfirmasi(payload) {
            this.temaKonfirmasi = payload;
        },
        temaCocokDrawer(kategori, teks) {
            const cocokKategori = this.kategoriDrawerTema === 'semua' || this.kategoriDrawerTema === kategori;
            const q = this.cariDrawerTema.trim().toLowerCase();
            const cocokCari = !q || teks.toLowerCase().includes(q);
            return cocokKategori && cocokCari;
        },
        urlMusikAktif() {
            return this.musikDipilih ? (this.daftarUrlMusik[this.musikDipilih] || '') : '';
        },
        hentikanAudioPreview() {
            const audio = this.$refs.audioPreview;
            if (audio) {
                audio.pause();
                audio.currentTime = 0;
            }
            this.audioSedangPutar = false;
        },
        toggleAudioPreview() {
            const url = this.urlMusikAktif();
            const audio = this.$refs.audioPreview;
            if (!url || !audio) return;

            if (this.audioSedangPutar) {
                audio.pause();
                this.audioSedangPutar = false;
                return;
            }

            if (audio.src !== url) {
                audio.src = url;
            }
            audio.play().then(() => {
                this.audioSedangPutar = true;
            }).catch(() => {
                this.audioSedangPutar = false;
            });
        },
        tambahCerita() {
            this.daftarCerita.push({ judul: '', tanggal: '', cerita: '', foto: '', foto_url: '', hapus_foto: false });
            this.jadwalkanLivePreview();
        },
        tambahCeritaPreset(judul, tanggal, cerita) {
            const barisKosong = this.daftarCerita.length === 1 &&
                !this.daftarCerita[0].judul?.trim() &&
                !this.daftarCerita[0].cerita?.trim();

            if (barisKosong) {
                this.daftarCerita[0] = { judul, tanggal, cerita, foto: '', foto_url: '', hapus_foto: false };
                this.jadwalkanLivePreview(true);
                return;
            }

            this.daftarCerita.push({ judul, tanggal, cerita, foto: '', foto_url: '', hapus_foto: false });
            this.jadwalkanLivePreview(true);
        },
        pilihFotoCerita(index, acara) {
            const file = acara.target?.files?.[0];
            if (!file || !this.daftarCerita[index]) {
                return;
            }
            this.daftarCerita[index].foto_url = URL.createObjectURL(file);
            this.daftarCerita[index].hapus_foto = false;
            this.jadwalkanLivePreview(true);
        },
        hapusFotoCerita(index) {
            if (!this.daftarCerita[index]) {
                return;
            }
            this.daftarCerita[index].foto = '';
            this.daftarCerita[index].foto_url = '';
            this.daftarCerita[index].hapus_foto = true;
            this.jadwalkanLivePreview(true);
        },
        pindahCerita(index, arah) {
            const target = index + arah;
            if (target < 0 || target >= this.daftarCerita.length) {
                return;
            }
            const salinan = [...this.daftarCerita];
            [salinan[index], salinan[target]] = [salinan[target], salinan[index]];
            this.daftarCerita = salinan;
            this.jadwalkanLivePreview(true);
        },
        hapusCerita(index) {
            if (this.daftarCerita.length > 1) {
                this.daftarCerita.splice(index, 1);
                this.jadwalkanLivePreview(true);
            }
        },
        gayaKartuLive() {
            const teks = (this.bankBaru || '').trim().toLowerCase();
            if (teks) {
                for (const item of this.katalogBank.items) {
                    if (item.kata_kunci.some((kata) => teks.includes(kata))) {
                        return item;
                    }
                }
            }
            const namaBersih = (this.bankBaru || '').trim();
            return {
                ...this.katalogBank.fallback,
                singkatan: namaBersih ? namaBersih.slice(0, 14).toUpperCase() : this.katalogBank.fallback.singkatan,
                subjudul: namaBersih || this.katalogBank.fallback.subjudul,
            };
        },
        formatNomorLive(nomor) {
            const bersih = (nomor || '').trim();
            if (!bersih) return '1234 5678 90';
            if (/^\d{6,}$/.test(bersih)) {
                return bersih.replace(/(\d{4})(?=\d)/g, '$1 ');
            }
            return bersih;
        },
    };
}
