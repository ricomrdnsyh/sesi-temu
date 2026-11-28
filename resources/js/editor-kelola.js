export function editorKelolaUndangan(cfgMasuk = null) {
    let cfg = cfgMasuk;
    if (!cfg && typeof document !== 'undefined') {
        try {
            const elCfg = document.getElementById('editor-kelola-config');
            cfg = elCfg ? JSON.parse(elCfg.textContent || '{}') : {};
        } catch (_) {
            cfg = {};
        }
    }
    cfg = cfg || {};

    let cropImg = null;
    let cropSourceFile = null;
    let cropTempUrl = '';
    let cropCallbacks = {};
    const cropPointers = new Map();
    let cropLastPos = null;
    let cropPinchDist = 0;
    const ceritaAsliMap = new WeakMap();
    const ceritaHasilMap = new WeakMap();
    const hitungMundurAsliMap = new Map();
    const hitungMundurHasilMap = new Map();
    let hitungMundurUidCounter = 0;
    const buatItemFotoHitungMundur = (path = '', url = '') => ({
        uid: `hm-${++hitungMundurUidCounter}`,
        path: path || '',
        url: url || '',
    });
    const galeriAsliMap = new Map();
    const galeriHasilMap = new Map();
    let galeriUidCounter = 0;
    const buatItemGaleri = (item = {}) => ({
        uid: `gal-${++galeriUidCounter}`,
        id: Number(item?.id) > 0 ? Number(item.id) : null,
        path: item?.path || '',
        url: item?.url || '',
        keterangan: item?.keterangan || '',
    });
    let antreanSimpanFitur = Promise.resolve();
    const buatFormAcaraKosong = () => ({
        id: '',
        nama_acara: '',
        tanggal_acara: '',
        waktu_mulai: '08:00',
        waktu_selesai: '',
        zona_waktu: 'WIB',
        nama_tempat: '',
        alamat_lengkap: '',
        link_maps: '',
    });

    return {
        tab: cfg.tab === 'aktivasi' ? '' : cfg.tab,
        urutanTab: ['tema', 'ayat', 'mempelai', 'hitung_mundur', 'acara', 'dress_code', 'live_streaming', 'cerita', 'galeri', 'amplop', 'buku_tamu', 'doa_pengantin', 'turut_mengundang', 'penutup'],
        urlPublikPreview: cfg.urlPublikPreview,
        urlPublikSalin: cfg.urlPublikSalin || '',
        urlSimpanFitur: cfg.urlSimpanFitur,
        urlSimpanAcara: cfg.urlSimpanAcara || '',
        urlSimpanAmplop: cfg.urlSimpanAmplop || '',
        urlPratinjauLangsung: cfg.urlPratinjauLangsung,
        csrfToken: cfg.csrfToken,
        adaPerubahanBelumDisimpan: false,
        sedangMenyimpanSemua: false,
        statusSimpanTeks: '',
        rasioFotoTema: cfg.rasioFotoTema || {},
        cropTerbuka: false,
        cropMemuat: false,
        cropMenyimpan: false,
        cropGalat: '',
        cropJudul: 'Atur Potongan Foto',
        cropNamaAsli: 'foto.jpg',
        cropRasioTemplate: 0.75,
        cropLabelTemplate: 'Sesuai Template',
        cropBentukTemplate: 'rect',
        cropRasio: 0.75,
        cropBentuk: 'rect',
        cropZoom: 1,
        cropRotasi: 0,
        cropOffsetX: 0,
        cropOffsetY: 0,
        cropStageW: 360,
        cropStageH: 360,
        cropBoxW: 240,
        cropBoxH: 320,
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
        sakelarFitur: {
            ayat_pembuka: true,
            hitung_mundur: true,
            acara: true,
            dress_code: true,
            live_streaming: false,
            cerita_cinta: true,
            galeri: true,
            amplop_digital: true,
            doa_pengantin: true,
            turut_mengundang: true,
            ...(cfg.sakelarFitur || {}),
        },
        fiturMenyimpan: {
            ayat_pembuka: false,
            hitung_mundur: false,
            acara: false,
            dress_code: false,
            live_streaming: false,
            cerita_cinta: false,
            galeri: false,
            amplop_digital: false,
            doa_pengantin: false,
            turut_mengundang: false,
        },
        musikDipilih: cfg.musikDipilih,
        modeMusik: cfg.modeMusik || 'katalog',
        musikKustomUrlAwal: cfg.musikKustomUrlAwal || '',
        musikKustomNamaAwal: cfg.musikKustomNamaAwal || '',
        musikKustomPreviewUrl: '',
        musikKustomNamaBaru: '',
        musikKustomUkuranBaru: '',
        hapusMusikKustom: false,
        pesanGalatMusik: '',
        daftarUrlMusik: cfg.daftarUrlMusik,
        audioSedangPutar: false,
        slugTersalin: false,
        maksFotoHitungMundur: 4,
        daftarFotoHitungMundur: (Array.isArray(cfg.daftarFotoHitungMundur) ? cfg.daftarFotoHitungMundur : [])
            .slice(0, 4)
            .map((item) => buatItemFotoHitungMundur(item?.path, item?.url)),
        sedangTarikHitungMundur: false,
        pesanGalatHitungMundur: '',
        maksGaleri: 10,
        daftarGaleri: (Array.isArray(cfg.daftarGaleri) ? cfg.daftarGaleri : [])
            .slice(0, 10)
            .map((item) => buatItemGaleri(item)),
        sedangTarikGaleri: false,
        pesanGalatGaleri: '',
        daftarCerita: cfg.daftarCerita,
        liveAktifLive: cfg.liveAktifLive,
        daftarAmplop: Array.isArray(cfg.daftarAmplop) ? cfg.daftarAmplop : [],
        formAmplop: {
            nomor_rekening: '',
            atas_nama: '',
        },
        sedangSimpanAmplop: false,
        amplopHapusId: null,
        bankPilihan: '',
        bankKustom: '',
        bankBaru: '',
        daftarAcara: Array.isArray(cfg.daftarAcara) ? cfg.daftarAcara : [],
        formAcara: buatFormAcaraKosong(),
        pickerAcaraAktif: '',
        modePilihBulan: false,
        kalenderTahun: new Date().getFullYear(),
        kalenderBulan: new Date().getMonth(),
        namaBulanKalender: [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
        ],
        namaHariKalender: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
        acaraEdit: null,
        sedangSimpanAcara: false,
        acaraHapusId: null,
        galeriLightbox: null,
        modalAktivasiTerbuka: cfg.tab === 'aktivasi',
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
                if (this.cropTerbuka) {
                    this.ukurDanGambarCrop();
                }
            });
            this.$watch('tanpaFotoAktif', () => {
                this.tandaiPerubahan();
                this.jadwalkanLivePreview(true);
            });
            window.addEventListener('keydown', (event) => {
                if ((event.ctrlKey || event.metaKey) && event.key?.toLowerCase() === 's') {
                    event.preventDefault();
                    this.simpanSemuaPerubahan();
                }
            });
            setTimeout(() => {
                this.previewMemuat = false;
            }, 2500);
        },
        tandaiPerubahan() {
            this.adaPerubahanBelumDisimpan = true;
            this.statusSimpanTeks = '';
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
            const bezelPad = 12;
            const tersediaW = Math.max(80, stage.clientWidth - 20 - bezelPad);
            const tersediaH = Math.max(120, stage.clientHeight - 16 - bezelPad);
            const skala = Math.min(tersediaW / 390, tersediaH / 780, 1.0);
            this.previewStudioScale = Math.max(0.18, Number(skala.toFixed(4)));
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
            if (['foto_pria', 'foto_wanita', 'foto_sampul', 'foto_pembuka', 'foto_hitung_mundur', 'foto_penutup'].includes(detail.nama)) {
                this.fotoLiveMap = { ...this.fotoLiveMap, [detail.nama]: detail.url || '' };
                this.tandaiPerubahan();
                this.jadwalkanLivePreview(true);
            }
        },
        saatInputLive(event) {
            const el = event?.target;
            if (!el || !el.name || el.type === 'file') return;
            if (!el.closest('form')) {
                this.tandaiPerubahan();
            }
            const namaDiabaikan = [
                'slug', 'musik_latar', 'sumber_musik', 'file_musik_kustom', 'hapus_musik_kustom', 'tema_id', 'acara_id',
                'nama_acara', 'tanggal_acara', 'waktu_mulai', 'waktu_selesai', 'zona_waktu', 'nama_tempat', 'alamat_lengkap', 'link_maps',
                'foto', 'foto_hitung_mundur[]', 'galeri_foto[]', 'keterangan', 'nama_bank', 'nomor_rekening', 'atas_nama',
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
                : (['ayat', 'mempelai', 'hitung_mundur', 'acara', 'dress_code', 'live_streaming', 'cerita', 'galeri', 'amplop', 'buku_tamu', 'doa_pengantin', 'turut_mengundang', 'penutup'].includes(tabAktif)
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
                live_aktif: Boolean(this.sakelarFitur?.live_streaming),
                live_platform: nilai('live_platform'),
                live_link: nilai('live_link'),
                alamat_kado_fisik: nilai('alamat_kado_fisik'),
                turut_mengundang_wanita: nilai('turut_mengundang_wanita'),
                turut_mengundang_pria: nilai('turut_mengundang_pria'),
                hashtag: nilai('hashtag'),
                cerita_cinta: this.daftarCerita,
                foto_live: this.fotoLiveMap,
                foto_hitung_mundur_disertakan: true,
                foto_hitung_mundur_live: this.daftarFotoHitungMundur.map((item) => ({
                    path: item.path || '',
                    url: item.url || '',
                })),
                galeri_disertakan: true,
                galeri_live: this.daftarGaleri.map((item) => ({
                    id: item.id || null,
                    path: item.path || '',
                    url: item.url || '',
                    keterangan: item.keterangan || '',
                })),
                hapus_foto_sampul: tercentang('hapus_foto_sampul'),
                hapus_foto_pembuka: tercentang('hapus_foto_pembuka'),
                hapus_foto_penutup: tercentang('hapus_foto_penutup'),
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
        jumlahCeritaTerisi() {
            return (Array.isArray(this.daftarCerita) ? this.daftarCerita : []).filter((item) => (
                String(item?.judul || '').trim() !== ''
                || String(item?.cerita || '').trim() !== ''
                || String(item?.foto_url || item?.foto || '').trim() !== ''
            )).length;
        },
        pesanCatatanFiturKosong(kunci) {
            const root = this.$refs.panelKiri;
            if (kunci === 'acara' && this.daftarAcara.length === 0) {
                return 'Tambahkan jadwal acara agar tampil di undangan.';
            }
            if (kunci === 'dress_code') {
                const catatan = (root?.querySelector('[name="dress_code_catatan"]')?.value || '').trim();
                const jmlWarna = root?.querySelectorAll('[name^="dress_code_warna["]')?.length || 0;
                if (!catatan && jmlWarna === 0) {
                    return 'Isi catatan atau pilih warna agar Dress Code tampil di undangan.';
                }
            }
            if (kunci === 'live_streaming') {
                const link = (root?.querySelector('[name="live_link"]')?.value || '').trim();
                if (!link) {
                    return 'Isi Link Live agar tombol Live Streaming tampil di undangan.';
                }
            }
            if (kunci === 'cerita_cinta' && this.jumlahCeritaTerisi() === 0) {
                return 'Isi minimal satu momen cerita agar tampil di undangan.';
            }
            if (kunci === 'galeri') {
                if (this.tanpaFotoAktif) {
                    return 'Mode Tanpa Foto masih aktif sehingga galeri belum ditampilkan.';
                }
                if (this.daftarGaleri.length === 0) {
                    return 'Unggah minimal satu foto agar Galeri tampil di undangan.';
                }
            }
            if (kunci === 'amplop_digital') {
                const alamat = (root?.querySelector('[name="alamat_kado_fisik"]')?.value || '').trim();
                if (this.daftarAmplop.length === 0 && !alamat) {
                    return 'Tambahkan rekening atau alamat kado agar Amplop Digital tampil.';
                }
            }
            if (kunci === 'turut_mengundang') {
                const wanita = (root?.querySelector('[name="turut_mengundang_wanita"]')?.value || '').trim();
                const pria = (root?.querySelector('[name="turut_mengundang_pria"]')?.value || '').trim();
                if (!wanita && !pria) {
                    return 'Isi daftar nama pihak wanita atau pria agar Turut Mengundang tampil di undangan.';
                }
            }
            return '';
        },
        async toggleFitur(kunci) {
            if (this.fiturMenyimpan[kunci]) return;
            const nilaiLama = Boolean(this.sakelarFitur[kunci]);
            const nilaiBaru = !nilaiLama;
            this.sakelarFitur[kunci] = nilaiBaru;
            if (kunci === 'live_streaming') {
                this.liveAktifLive = nilaiBaru;
            }
            this.fiturMenyimpan[kunci] = true;

            const petaFokus = {
                ayat_pembuka: 'ayat',
                hitung_mundur: 'hitung_mundur',
                acara: 'acara',
                dress_code: 'dress_code',
                live_streaming: 'live_streaming',
                cerita_cinta: 'cerita',
                galeri: 'galeri',
                amplop_digital: 'amplop',
                doa_pengantin: 'doa_pengantin',
                turut_mengundang: 'turut_mengundang',
            };
            const labelFitur = {
                ayat_pembuka: 'Ayat Pembuka',
                hitung_mundur: 'Hitung Mundur',
                acara: 'Rangkaian Acara',
                dress_code: 'Dress Code',
                live_streaming: 'Live Streaming',
                cerita_cinta: 'Cerita Cinta',
                galeri: 'Galeri Foto',
                amplop_digital: 'Amplop & Kado',
                doa_pengantin: 'Doa Untuk Pengantin',
                turut_mengundang: 'Daftar Turut Mengundang',
            };
            const fokus = nilaiBaru ? (petaFokus[kunci] || '') : '';
            this.jadwalkanLivePreview(true, fokus);

            const simpanBerurutan = async () => {
                const token = document.querySelector('meta[name=csrf-token]')?.content || this.csrfToken;
                const respon = await fetch(this.urlSimpanFitur, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-HTTP-Method-Override': 'PUT',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify({ _method: 'PUT', bagian: 'fitur', kunci, aktif: nilaiBaru }),
                });
                if (!respon.ok) throw new Error('Gagal');
                return respon.json().catch(() => ({ ok: true }));
            };

            const tugas = antreanSimpanFitur.then(simpanBerurutan, simpanBerurutan);
            antreanSimpanFitur = tugas.catch(() => {});

            try {
                await tugas;
                const nama = labelFitur[kunci] || 'Bagian';
                this.statusSimpanTeks = nilaiBaru ? `${nama} ditampilkan` : `${nama} disembunyikan`;
                const catatanKosong = nilaiBaru ? this.pesanCatatanFiturKosong(kunci) : '';
                if (catatanKosong) {
                    this.tampilkanToast(catatanKosong, `${nama} Aktif`, 'info');
                } else {
                    this.tampilkanToast(
                        nilaiBaru ? `${nama} kini ditampilkan di undangan.` : `${nama} disembunyikan dari undangan.`,
                        nilaiBaru ? 'Bagian Diaktifkan' : 'Bagian Disembunyikan'
                    );
                }
            } catch (_) {
                this.sakelarFitur[kunci] = nilaiLama;
                if (kunci === 'live_streaming') {
                    this.liveAktifLive = nilaiLama;
                }
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
        async simpanSemuaPerubahan() {
            if (this.sedangMenyimpanSemua) return;
            const root = this.$refs.panelKiri;
            if (!root) return;

            this.sedangMenyimpanSemua = true;
            const fd = new FormData();
            fd.append('_method', 'PUT');
            fd.append('bagian', 'semua');
            fd.append('doa_disertakan', '1');
            fd.append('dress_code_disertakan', '1');
            fd.append('foto_hitung_mundur_disertakan', '1');
            fd.append('galeri_disertakan', '1');

            Object.entries(this.sakelarFitur || {}).forEach(([kunci, aktif]) => {
                fd.append(`fitur_${kunci}`, aktif ? '1' : '0');
            });

            this.daftarFotoHitungMundur.slice(0, this.maksFotoHitungMundur).forEach((item, idx) => {
                fd.append(`foto_hitung_mundur_items[${idx}][path]`, item.path || '');
                const berkasHasil = hitungMundurHasilMap.get(item.uid);
                if (berkasHasil) {
                    fd.append(`foto_hitung_mundur_items[${idx}][file]`, berkasHasil);
                }
            });

            this.daftarGaleri.slice(0, this.maksGaleri).forEach((item, idx) => {
                if (item.id) {
                    fd.append(`galeri_items[${idx}][id]`, String(item.id));
                }
                fd.append(`galeri_items[${idx}][keterangan]`, item.keterangan || '');
                const berkasGaleri = galeriHasilMap.get(item.uid);
                if (berkasGaleri) {
                    fd.append(`galeri_items[${idx}][file]`, berkasGaleri);
                }
            });

            root.querySelectorAll('input, select, textarea').forEach((el) => {
                if (!el.name || el.disabled) return;
                if (el.closest('form')) return;
                if ([
                    '_token', '_method', 'bagian', 'doa_disertakan', 'dress_code_disertakan',
                    'foto_hitung_mundur_disertakan', 'foto_hitung_mundur[]',
                    'galeri_disertakan', 'galeri_foto[]',
                ].includes(el.name)) return;

                if (el.type === 'file') {
                    if (el.files && el.files.length > 0) {
                        fd.append(el.name, el.files[0]);
                    }
                    return;
                }

                if (el.type === 'checkbox' || el.type === 'radio') {
                    if (el.checked) {
                        fd.append(el.name, el.value || '1');
                    }
                    return;
                }

                fd.append(el.name, el.value ?? '');
            });

            try {
                const token = document.querySelector('meta[name=csrf-token]')?.content || this.csrfToken;
                const respon = await fetch(this.urlSimpanFitur, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-HTTP-Method-Override': 'PUT',
                        'X-CSRF-TOKEN': token,
                    },
                    body: fd,
                });

                const data = await respon.json().catch(() => ({}));
                if (!respon.ok) {
                    const daftarGalat = data?.errors ? Object.values(data.errors).flat() : [];
                    const pesanError = daftarGalat.length > 0
                        ? daftarGalat.join('\n')
                        : (data?.message || 'Gagal menyimpan perubahan. Silakan periksa kembali isian Anda.');
                    window.Swal?.fire({
                        icon: 'error',
                        title: 'Periksa Isian Undangan',
                        text: pesanError,
                        confirmButtonColor: '#4B6358',
                    });
                    return;
                }

                this.adaPerubahanBelumDisimpan = false;
                this.statusSimpanTeks = 'Semua perubahan tersimpan';
                this.fotoLiveMap = {};

                if (data?.url_publik_relatif) {
                    this.urlPublikPreview = data.url_publik_relatif;
                }
                if (data?.url_publik) {
                    this.urlPublikSalin = data.url_publik;
                }
                if (data?.slug) {
                    const slugInput = root.querySelector('input[name="slug"]');
                    if (slugInput) slugInput.value = data.slug;
                }
                if (data?.musik_kustom) {
                    this.musikKustomUrlAwal = data.musik_kustom.url || '';
                    this.musikKustomNamaAwal = data.musik_kustom.nama || '';
                    this.batalkanMusikKustomBaru();
                    this.hapusMusikKustom = false;
                }
                if (Array.isArray(data?.foto_hitung_mundur)) {
                    this.daftarFotoHitungMundur.forEach((item) => {
                        if (item?.url && item.url.startsWith('blob:')) {
                            URL.revokeObjectURL(item.url);
                        }
                    });
                    hitungMundurAsliMap.clear();
                    hitungMundurHasilMap.clear();
                    this.daftarFotoHitungMundur = data.foto_hitung_mundur
                        .slice(0, this.maksFotoHitungMundur)
                        .map((item) => buatItemFotoHitungMundur(item?.path, item?.url));
                    this.pesanGalatHitungMundur = '';
                }
                if (Array.isArray(data?.galeri)) {
                    this.daftarGaleri.forEach((item) => {
                        if (item?.url && item.url.startsWith('blob:')) {
                            URL.revokeObjectURL(item.url);
                        }
                    });
                    galeriAsliMap.clear();
                    galeriHasilMap.clear();
                    this.daftarGaleri = data.galeri
                        .slice(0, this.maksGaleri)
                        .map((item) => buatItemGaleri(item));
                    this.pesanGalatGaleri = '';
                }
                if (Array.isArray(data?.cerita_cinta)) {
                    this.daftarCerita = data.cerita_cinta.length > 0
                        ? data.cerita_cinta
                        : [{ judul: '', tanggal: '', cerita: '', foto: '', foto_url: '', hapus_foto: false }];
                    root.querySelectorAll('input[name^="cerita_cinta["][type="file"]').forEach((inp) => {
                        inp.value = '';
                    });
                }

                window.dispatchEvent(new CustomEvent('editor-tersimpan', { detail: data }));
                this.jadwalkanLivePreview(true);

                this.tampilkanToast(
                    data?.pesan || 'Semua perubahan undangan berhasil disimpan.',
                    'Perubahan Tersimpan'
                );
            } catch (_) {
                window.Swal?.fire({
                    icon: 'error',
                    title: 'Koneksi Terputus',
                    text: 'Tidak dapat menghubungi server saat menyimpan. Silakan coba lagi.',
                    confirmButtonColor: '#4B6358',
                });
            } finally {
                this.sedangMenyimpanSemua = false;
            }
        },
        tampilkanToast(pesan, judul = 'Berhasil', ikon = 'success') {
            window.Swal?.fire({
                toast: true,
                position: 'top-end',
                icon: ikon,
                title: judul,
                text: pesan,
                showConfirmButton: false,
                showCloseButton: true,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = window.Swal.stopTimer;
                    toast.onmouseleave = window.Swal.resumeTimer;
                },
            });
        },
        sinkronSelect2El(selectEl, nilai) {
            if (!selectEl) return;
            // Alpine x-model toggles option.selected directly without triggering Select2 UI refresh.
            selectEl.value = nilai != null ? String(nilai) : '';
            if (window.jQuery && window.jQuery(selectEl).data('select2')) {
                window.jQuery(selectEl).trigger('change.select2');
            }
        },
        tutupPickerAcara() {
            this.pickerAcaraAktif = '';
            this.modePilihBulan = false;
        },
        togglePickerAcara(jenis) {
            if (this.pickerAcaraAktif === jenis) {
                this.tutupPickerAcara();
                return;
            }
            this.modePilihBulan = false;
            if (jenis === 'tanggal') {
                const cocok = (this.formAcara.tanggal_acara || '').match(/^(\d{4})-(\d{2})-(\d{2})$/);
                if (cocok) {
                    this.kalenderTahun = Number(cocok[1]);
                    this.kalenderBulan = Number(cocok[2]) - 1;
                } else {
                    const kini = new Date();
                    this.kalenderTahun = kini.getFullYear();
                    this.kalenderBulan = kini.getMonth();
                }
            }
            this.pickerAcaraAktif = jenis;
            if (jenis === 'mulai' || jenis === 'selesai') {
                const field = jenis === 'mulai' ? 'waktu_mulai' : 'waktu_selesai';
                this.$nextTick(() => {
                    const jamEl = this.$refs[`${jenis}JamList`];
                    const menitEl = this.$refs[`${jenis}MenitList`];
                    const jamAktif = this.bagianWaktuAcara(field, 'jam') || '08';
                    const menitAktif = this.bagianWaktuAcara(field, 'menit') || '00';
                    jamEl?.querySelector(`[data-jam="${jamAktif}"]`)?.scrollIntoView({ block: 'center' });
                    menitEl?.querySelector(`[data-menit="${menitAktif}"]`)?.scrollIntoView({ block: 'center' });
                });
            }
        },
        geserBulanKalender(arah) {
            let bulan = this.kalenderBulan + arah;
            let tahun = this.kalenderTahun;
            if (bulan < 0) {
                bulan = 11;
                tahun--;
            } else if (bulan > 11) {
                bulan = 0;
                tahun++;
            }
            this.kalenderBulan = bulan;
            this.kalenderTahun = tahun;
        },
        labelTanggalAcara() {
            const cocok = (this.formAcara.tanggal_acara || '').match(/^(\d{4})-(\d{2})-(\d{2})$/);
            if (!cocok) return 'Pilih tanggal acara...';
            const tgl = new Date(Number(cocok[1]), Number(cocok[2]) - 1, Number(cocok[3]));
            if (Number.isNaN(tgl.getTime())) return this.formAcara.tanggal_acara;
            return `${this.namaHariKalender[tgl.getDay()]}, ${Number(cocok[3])} ${this.namaBulanKalender[tgl.getMonth()]} ${cocok[1]}`;
        },
        daftarSelKalender() {
            const tahun = this.kalenderTahun;
            const bulan = this.kalenderBulan;
            const hariPertama = new Date(tahun, bulan, 1).getDay();
            const jumlahHari = new Date(tahun, bulan + 1, 0).getDate();
            const jumlahHariLalu = new Date(tahun, bulan, 0).getDate();
            const kini = new Date();
            const isoHariIni = `${kini.getFullYear()}-${String(kini.getMonth() + 1).padStart(2, '0')}-${String(kini.getDate()).padStart(2, '0')}`;
            const isoTerpilih = this.formAcara.tanggal_acara || '';

            const formatIso = (y, m, d) => {
                const dt = new Date(y, m, d);
                return `${dt.getFullYear()}-${String(dt.getMonth() + 1).padStart(2, '0')}-${String(dt.getDate()).padStart(2, '0')}`;
            };

            const sel = [];
            for (let i = hariPertama - 1; i >= 0; i--) {
                const angka = jumlahHariLalu - i;
                const iso = formatIso(tahun, bulan - 1, angka);
                sel.push({ kunci: `p-${iso}`, angka, iso, bulanAktif: false, hariIni: iso === isoHariIni, terpilih: iso === isoTerpilih });
            }
            for (let d = 1; d <= jumlahHari; d++) {
                const iso = formatIso(tahun, bulan, d);
                sel.push({ kunci: `c-${iso}`, angka: d, iso, bulanAktif: true, hariIni: iso === isoHariIni, terpilih: iso === isoTerpilih });
            }
            const sisa = (7 - (sel.length % 7)) % 7;
            for (let n = 1; n <= sisa; n++) {
                const iso = formatIso(tahun, bulan + 1, n);
                sel.push({ kunci: `n-${iso}`, angka: n, iso, bulanAktif: false, hariIni: iso === isoHariIni, terpilih: iso === isoTerpilih });
            }
            return sel;
        },
        pilihTanggalKalender(iso) {
            this.formAcara.tanggal_acara = iso;
            this.tutupPickerAcara();
        },
        pilihHariIniAcara() {
            const kini = new Date();
            const iso = `${kini.getFullYear()}-${String(kini.getMonth() + 1).padStart(2, '0')}-${String(kini.getDate()).padStart(2, '0')}`;
            this.pilihTanggalKalender(iso);
        },
        bagianWaktuAcara(field, bagian) {
            const nilai = this.formAcara?.[field] || '';
            const cocok = nilai.match(/^(\d{2}):(\d{2})$/);
            if (!cocok) return '';
            return bagian === 'jam' ? cocok[1] : cocok[2];
        },
        aturBagianWaktuAcara(field, bagian, nilai) {
            const jamLama = this.bagianWaktuAcara(field, 'jam') || (field === 'waktu_mulai' ? '08' : (this.bagianWaktuAcara('waktu_mulai', 'jam') || '10'));
            const menitLama = this.bagianWaktuAcara(field, 'menit') || '00';
            const jamBaru = bagian === 'jam' ? nilai : jamLama;
            const menitBaru = bagian === 'menit' ? nilai : menitLama;
            this.formAcara[field] = `${jamBaru}:${menitBaru}`;
        },
        mulaiEditAcara(acara) {
            if (!acara) return;
            this.tutupPickerAcara();
            this.acaraEdit = acara;
            this.formAcara = {
                id: acara.id || '',
                nama_acara: acara.nama_acara || '',
                tanggal_acara: acara.tanggal_acara || '',
                waktu_mulai: acara.waktu_mulai || '08:00',
                waktu_selesai: acara.waktu_selesai || '',
                zona_waktu: acara.zona_waktu || 'WIB',
                nama_tempat: acara.nama_tempat || '',
                alamat_lengkap: acara.alamat_lengkap || '',
                link_maps: acara.link_maps || '',
            };
            this.$nextTick(() => this.sinkronSelect2El(this.$refs.acaraZonaSelect, this.formAcara.zona_waktu || 'WIB'));
            this.$refs.formAcaraPanel?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        },
        batalEditAcara() {
            this.tutupPickerAcara();
            this.acaraEdit = null;
            this.formAcara = buatFormAcaraKosong();
            this.$nextTick(() => this.sinkronSelect2El(this.$refs.acaraZonaSelect, this.formAcara.zona_waktu || 'WIB'));
        },
        async simpanAcara(event) {
            if (this.sedangSimpanAcara) return;
            this.tutupPickerAcara();
            const form = event?.target;
            if (!this.formAcara.tanggal_acara) {
                window.Swal?.fire({
                    icon: 'warning',
                    title: 'Tanggal Acara Belum Dipilih',
                    text: 'Silakan pilih tanggal acara pada kalender terlebih dahulu.',
                    confirmButtonColor: '#4B6358',
                });
                return;
            }
            if (form && typeof form.reportValidity === 'function' && !form.reportValidity()) {
                return;
            }

            const url = this.urlSimpanAcara || form?.action;
            if (!url) return;

            this.sedangSimpanAcara = true;
            try {
                const token = document.querySelector('meta[name=csrf-token]')?.content || this.csrfToken;
                const payload = {
                    acara_id: this.formAcara.id || null,
                    nama_acara: this.formAcara.nama_acara,
                    tanggal_acara: this.formAcara.tanggal_acara,
                    waktu_mulai: this.formAcara.waktu_mulai || '08:00',
                    waktu_selesai: this.formAcara.waktu_selesai || '',
                    zona_waktu: this.$refs.acaraZonaSelect?.value || this.formAcara.zona_waktu || 'WIB',
                    nama_tempat: this.formAcara.nama_tempat,
                    alamat_lengkap: this.formAcara.alamat_lengkap,
                    link_maps: this.formAcara.link_maps,
                };

                const respon = await fetch(url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify(payload),
                });

                const data = await respon.json().catch(() => ({}));
                if (!respon.ok) {
                    const daftarGalat = data?.errors ? Object.values(data.errors).flat() : [];
                    const pesanError = daftarGalat.length > 0
                        ? daftarGalat.join('\n')
                        : (data?.message || 'Gagal menyimpan jadwal acara. Silakan periksa kembali isian Anda.');
                    window.Swal?.fire({
                        icon: 'error',
                        title: 'Periksa Isian Acara',
                        text: pesanError,
                        confirmButtonColor: '#4B6358',
                    });
                    return;
                }

                const sedangEdit = Boolean(this.acaraEdit);
                if (Array.isArray(data?.daftar_acara)) {
                    this.daftarAcara = data.daftar_acara;
                }
                this.batalEditAcara();
                this.jadwalkanLivePreview(true, 'acara');

                this.tampilkanToast(
                    data?.pesan || 'Jadwal acara berhasil disimpan.',
                    sedangEdit ? 'Acara Diperbarui' : 'Acara Ditambahkan'
                );
            } catch (_) {
                window.Swal?.fire({
                    icon: 'error',
                    title: 'Koneksi Terputus',
                    text: 'Tidak dapat menghubungi server saat menyimpan acara. Silakan coba lagi.',
                    confirmButtonColor: '#4B6358',
                });
            } finally {
                this.sedangSimpanAcara = false;
            }
        },
        async hapusAcara(acara) {
            if (!acara?.id || !acara?.url_hapus || this.acaraHapusId) return;

            if (window.Swal) {
                const konfirmasi = await window.Swal.fire({
                    title: 'Hapus Jadwal Acara?',
                    text: `Yakin ingin menghapus acara ${acara.nama_acara}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#DC2626',
                    cancelButtonColor: '#6B7280',
                    reverseButtons: true,
                    focusCancel: true,
                });
                if (!konfirmasi?.isConfirmed) return;
            }

            this.acaraHapusId = acara.id;
            try {
                const token = document.querySelector('meta[name=csrf-token]')?.content || this.csrfToken;
                const respon = await fetch(acara.url_hapus, {
                    method: 'DELETE',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': token,
                    },
                });

                const data = await respon.json().catch(() => ({}));
                if (!respon.ok) {
                    window.Swal?.fire({
                        icon: 'error',
                        title: 'Gagal Menghapus Acara',
                        text: data?.message || 'Tidak dapat menghapus jadwal acara saat ini. Silakan coba lagi.',
                        confirmButtonColor: '#4B6358',
                    });
                    return;
                }

                if (Array.isArray(data?.daftar_acara)) {
                    this.daftarAcara = data.daftar_acara;
                }
                if (this.acaraEdit?.id === acara.id) {
                    this.batalEditAcara();
                }
                this.jadwalkanLivePreview(true, 'acara');

                this.tampilkanToast(
                    data?.pesan || 'Jadwal acara berhasil dihapus.',
                    'Acara Dihapus'
                );
            } catch (_) {
                window.Swal?.fire({
                    icon: 'error',
                    title: 'Koneksi Terputus',
                    text: 'Tidak dapat menghubungi server saat menghapus acara. Silakan coba lagi.',
                    confirmButtonColor: '#4B6358',
                });
            } finally {
                this.acaraHapusId = null;
            }
        },
        toggleBagian(kodeTab) {
            this.hentikanAudioPreview();
            this.tutupPickerAcara();
            window.SesiTemuSelect2?.close?.();
            if (this.tab === kodeTab) {
                this.tab = '';
                return;
            }
            this.tab = kodeTab;
            this.$nextTick(() => {
                window.SesiTemuSelect2?.init?.(this.$refs.panelKiri);
                const el = this.$el.querySelector(`[data-mobile-tab='${kodeTab}']`);
                el?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                if (['tema', 'ayat', 'mempelai', 'hitung_mundur', 'acara', 'dress_code', 'live_streaming', 'cerita', 'galeri', 'amplop', 'buku_tamu', 'doa_pengantin', 'turut_mengundang', 'penutup'].includes(kodeTab)) {
                    this.jadwalkanLivePreview(true, kodeTab);
                }
            });
        },
        bukaBagian(kodeTab) {
            if (kodeTab === 'aktivasi') {
                this.bukaModalAktivasi();
                return;
            }
            this.hentikanAudioPreview();
            this.tutupPickerAcara();
            window.SesiTemuSelect2?.close?.();
            this.tab = kodeTab;
            this.$nextTick(() => {
                window.SesiTemuSelect2?.init?.(this.$refs.panelKiri);
                const el = this.$el.querySelector(`[data-mobile-tab='${kodeTab}']`);
                el?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                if (['tema', 'ayat', 'mempelai', 'hitung_mundur', 'acara', 'dress_code', 'live_streaming', 'cerita', 'galeri', 'amplop', 'buku_tamu', 'doa_pengantin', 'turut_mengundang', 'penutup'].includes(kodeTab)) {
                    this.jadwalkanLivePreview(true, kodeTab);
                }
            });
        },
        bukaModalAktivasi() {
            this.hentikanAudioPreview();
            this.tutupPickerAcara();
            window.SesiTemuSelect2?.close?.();
            this.modalAktivasiTerbuka = true;
        },
        tutupModalAktivasi() {
            this.modalAktivasiTerbuka = false;
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
            this.$nextTick(() => {
                this.hitungSkalaPreviewStudio();
                if (typeof requestAnimationFrame === 'function') {
                    requestAnimationFrame(() => this.hitungSkalaPreviewStudio());
                }
            });
            setTimeout(() => this.hitungSkalaPreviewStudio(), 230);
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
        ubahModeMusik(mode) {
            if (this.modeMusik === mode) return;
            this.hentikanAudioPreview();
            this.pesanGalatMusik = '';
            this.modeMusik = mode;
            this.tandaiPerubahan();
        },
        urlMusikAktif() {
            if (this.modeMusik === 'kustom') {
                if (this.musikKustomPreviewUrl) {
                    return this.musikKustomPreviewUrl;
                }
                if (this.hapusMusikKustom) {
                    return '';
                }
                return this.musikKustomUrlAwal || '';
            }
            return this.musikDipilih ? (this.daftarUrlMusik[this.musikDipilih] || '') : '';
        },
        namaMusikKustomTampil() {
            if (this.musikKustomNamaBaru) {
                return this.musikKustomNamaBaru;
            }
            if (this.hapusMusikKustom) {
                return '';
            }
            return this.musikKustomNamaAwal || '';
        },
        async saatPilihMusikKustom(event) {
            this.pesanGalatMusik = '';
            const inputEl = event?.target;
            const file = inputEl?.files?.[0];
            if (!file) return;

            const validator = typeof window !== 'undefined' ? window.SesiTemuValidasiBerkas : null;
            if (validator?.validasi) {
                const cek = await validator.validasi(file, 'musik', {
                    maksMb: 15,
                    pesanUkuran: 'Ukuran file musik melebihi batas maksimal 15 MB.',
                });
                if (!cek.valid) {
                    this.pesanGalatMusik = cek.pesan;
                    if (inputEl) inputEl.value = '';
                    return;
                }
            } else {
                const ekstensiValid = /\.(mp3|wav|ogg|m4a)$/i.test(file.name || '');
                if (!ekstensiValid) {
                    this.pesanGalatMusik = 'Format audio harus MP3, WAV, OGG, atau M4A.';
                    if (inputEl) inputEl.value = '';
                    return;
                }
                if (file.size > 15 * 1024 * 1024) {
                    this.pesanGalatMusik = 'Ukuran file musik melebihi batas maksimal 15 MB.';
                    if (inputEl) inputEl.value = '';
                    return;
                }
            }

            this.hentikanAudioPreview();
            if (this.musikKustomPreviewUrl) {
                URL.revokeObjectURL(this.musikKustomPreviewUrl);
            }
            this.musikKustomPreviewUrl = URL.createObjectURL(file);
            this.musikKustomNamaBaru = file.name;
            this.musikKustomUkuranBaru = file.size < 1024 * 1024
                ? Math.max(1, Math.round(file.size / 1024)) + ' KB'
                : (file.size / (1024 * 1024)).toFixed(1) + ' MB';
            this.hapusMusikKustom = false;
            this.modeMusik = 'kustom';
            this.tandaiPerubahan();
        },
        batalkanMusikKustomBaru() {
            this.hentikanAudioPreview();
            if (this.musikKustomPreviewUrl) {
                URL.revokeObjectURL(this.musikKustomPreviewUrl);
            }
            this.musikKustomPreviewUrl = '';
            this.musikKustomNamaBaru = '';
            this.musikKustomUkuranBaru = '';
            this.pesanGalatMusik = '';
            if (this.$refs.inputMusikKustom) {
                this.$refs.inputMusikKustom.value = '';
            }
        },
        tandaiHapusMusikKustom() {
            this.hentikanAudioPreview();
            this.hapusMusikKustom = true;
            this.tandaiPerubahan();
        },
        batalHapusMusikKustom() {
            this.hapusMusikKustom = false;
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
            this.tandaiPerubahan();
            this.jadwalkanLivePreview();
        },
        tambahCeritaPreset(judul, tanggal, cerita) {
            const barisKosong = this.daftarCerita.length === 1 &&
                !this.daftarCerita[0].judul?.trim() &&
                !this.daftarCerita[0].cerita?.trim();

            if (barisKosong) {
                this.daftarCerita[0] = { judul, tanggal, cerita, foto: '', foto_url: '', hapus_foto: false };
                this.tandaiPerubahan();
                this.jadwalkanLivePreview(true);
                return;
            }

            this.daftarCerita.push({ judul, tanggal, cerita, foto: '', foto_url: '', hapus_foto: false });
            this.tandaiPerubahan();
            this.jadwalkanLivePreview(true);
        },
        pilihFotoHitungMundur(event) {
            const inputEl = event?.target;
            const berkasDipilih = Array.from(inputEl?.files || []);
            if (inputEl) {
                inputEl.value = '';
            }
            if (berkasDipilih.length > 0) {
                this.prosesAntreanFotoHitungMundur(berkasDipilih);
            }
        },
        jatuhFotoHitungMundur(event) {
            this.sedangTarikHitungMundur = false;
            const berkasDipilih = Array.from(event?.dataTransfer?.files || []);
            if (berkasDipilih.length > 0) {
                this.prosesAntreanFotoHitungMundur(berkasDipilih);
            }
        },
        async prosesAntreanFotoHitungMundur(daftarBerkas) {
            this.pesanGalatHitungMundur = '';
            const sisaSlot = Math.max(0, this.maksFotoHitungMundur - this.daftarFotoHitungMundur.length);
            if (sisaSlot <= 0) {
                this.pesanGalatHitungMundur = `Maksimal ${this.maksFotoHitungMundur} foto slideshow hitung mundur.`;
                return;
            }

            const validator = typeof window !== 'undefined' ? window.SesiTemuValidasiBerkas : null;
            const berkasValid = [];
            let pesanGalatPertama = '';
            for (const file of daftarBerkas) {
                if (validator?.validasi) {
                    const cek = await validator.validasi(file, 'gambar', {
                        maksMb: 15,
                        pesanUkuran: 'Ukuran foto melebihi batas maksimal 15 MB sebelum dipotong.',
                    });
                    if (!cek.valid) {
                        if (!pesanGalatPertama) pesanGalatPertama = cek.pesan;
                        continue;
                    }
                } else {
                    if (!file.type || !['image/jpeg', 'image/png', 'image/webp'].includes(file.type.toLowerCase())) {
                        if (!pesanGalatPertama) pesanGalatPertama = 'Format berkas harus berupa gambar (JPG, PNG, atau WebP).';
                        continue;
                    }
                    if (file.size > 15 * 1024 * 1024) {
                        if (!pesanGalatPertama) pesanGalatPertama = 'Ukuran foto melebihi batas maksimal 15 MB sebelum dipotong.';
                        continue;
                    }
                }
                berkasValid.push(file);
            }

            if (berkasValid.length === 0) {
                this.pesanGalatHitungMundur = pesanGalatPertama || 'Format berkas harus berupa gambar (JPG, PNG, atau WebP).';
                return;
            }

            const antrean = berkasValid.slice(0, sisaSlot);
            if (berkasValid.length > sisaSlot) {
                this.pesanGalatHitungMundur = `Hanya ${sisaSlot} foto pertama yang diproses (maksimal ${this.maksFotoHitungMundur} foto).`;
            } else if (pesanGalatPertama) {
                this.pesanGalatHitungMundur = `Sebagian berkas ditolak: ${pesanGalatPertama}`;
            }

            const total = antrean.length;
            const meta = this.rasioFotoTema?.foto_hitung_mundur || { rasio: 1.3333, label: '4:3 Hitung Mundur', bentuk: 'rect' };

            const prosesIndex = (urutan) => {
                if (urutan >= total || this.daftarFotoHitungMundur.length >= this.maksFotoHitungMundur) {
                    return;
                }
                const file = antrean[urutan];
                const nomorSlide = this.daftarFotoHitungMundur.length + 1;
                const judul = total > 1
                    ? `Potong Foto Slideshow ${nomorSlide} (${urutan + 1}/${total})`
                    : `Atur Potongan Foto Slideshow #${nomorSlide}`;

                this.bukaCropperFoto({
                    file,
                    judul,
                    rasio: meta.rasio,
                    labelRasio: meta.label,
                    bentuk: meta.bentuk,
                    namaAsli: file.name,
                    onSelesai: (fileHasil) => {
                        if (fileHasil.size > 5 * 1024 * 1024) {
                            this.pesanGalatHitungMundur = 'Ukuran hasil foto melebihi batas maksimal 5 MB.';
                            return;
                        }
                        const itemBaru = buatItemFotoHitungMundur('', URL.createObjectURL(fileHasil));
                        hitungMundurAsliMap.set(itemBaru.uid, file);
                        hitungMundurHasilMap.set(itemBaru.uid, fileHasil);
                        this.daftarFotoHitungMundur = [...this.daftarFotoHitungMundur, itemBaru];
                        this.tandaiPerubahan();
                        this.jadwalkanLivePreview(true);

                        if (urutan + 1 < total && this.daftarFotoHitungMundur.length < this.maksFotoHitungMundur) {
                            this.$nextTick(() => {
                                window.setTimeout(() => prosesIndex(urutan + 1), 90);
                            });
                        }
                    },
                });
            };

            prosesIndex(0);
        },
        potongFotoHitungMundur(index) {
            const item = this.daftarFotoHitungMundur[index];
            if (!item || !item.url) return;
            this.pesanGalatHitungMundur = '';
            const fileAsli = hitungMundurAsliMap.get(item.uid) || null;
            const meta = this.rasioFotoTema?.foto_hitung_mundur || { rasio: 1.3333, label: '4:3 Hitung Mundur', bentuk: 'rect' };

            this.bukaCropperFoto({
                file: fileAsli,
                srcUrl: fileAsli ? '' : item.url,
                judul: `Atur Potongan Foto Slideshow #${index + 1}`,
                rasio: meta.rasio,
                labelRasio: meta.label,
                bentuk: meta.bentuk,
                namaAsli: fileAsli?.name || `foto-hitung-mundur-${index + 1}.jpg`,
                onSelesai: (fileHasil) => {
                    if (fileHasil.size > 5 * 1024 * 1024) {
                        this.pesanGalatHitungMundur = 'Ukuran hasil foto melebihi batas maksimal 5 MB.';
                        return;
                    }
                    if (item.url && item.url.startsWith('blob:')) {
                        URL.revokeObjectURL(item.url);
                    }
                    hitungMundurHasilMap.set(item.uid, fileHasil);
                    item.url = URL.createObjectURL(fileHasil);
                    this.tandaiPerubahan();
                    this.jadwalkanLivePreview(true);
                },
            });
        },
        pindahFotoHitungMundur(index, arah) {
            const target = index + arah;
            if (target < 0 || target >= this.daftarFotoHitungMundur.length) return;
            const salinan = [...this.daftarFotoHitungMundur];
            [salinan[index], salinan[target]] = [salinan[target], salinan[index]];
            this.daftarFotoHitungMundur = salinan;
            this.tandaiPerubahan();
            this.jadwalkanLivePreview(true);
        },
        hapusFotoHitungMundur(index) {
            const item = this.daftarFotoHitungMundur[index];
            if (!item) return;
            if (item.url && item.url.startsWith('blob:')) {
                URL.revokeObjectURL(item.url);
            }
            hitungMundurAsliMap.delete(item.uid);
            hitungMundurHasilMap.delete(item.uid);
            this.daftarFotoHitungMundur = this.daftarFotoHitungMundur.filter((_, i) => i !== index);
            this.pesanGalatHitungMundur = '';
            this.tandaiPerubahan();
            this.jadwalkanLivePreview(true);
        },
        pilihFotoGaleri(event) {
            const inputEl = event?.target;
            const berkasDipilih = Array.from(inputEl?.files || []);
            if (inputEl) {
                inputEl.value = '';
            }
            if (berkasDipilih.length > 0) {
                this.prosesAntreanFotoGaleri(berkasDipilih);
            }
        },
        jatuhFotoGaleri(event) {
            this.sedangTarikGaleri = false;
            const berkasDipilih = Array.from(event?.dataTransfer?.files || []);
            if (berkasDipilih.length > 0) {
                this.prosesAntreanFotoGaleri(berkasDipilih);
            }
        },
        async prosesAntreanFotoGaleri(daftarBerkas) {
            this.pesanGalatGaleri = '';
            const sisaSlot = Math.max(0, this.maksGaleri - this.daftarGaleri.length);
            if (sisaSlot <= 0) {
                this.pesanGalatGaleri = `Maksimal ${this.maksGaleri} foto galeri per undangan.`;
                return;
            }

            const validator = typeof window !== 'undefined' ? window.SesiTemuValidasiBerkas : null;
            const berkasValid = [];
            let pesanGalatPertama = '';
            for (const file of daftarBerkas) {
                if (validator?.validasi) {
                    const cek = await validator.validasi(file, 'gambar', {
                        maksMb: 15,
                        pesanUkuran: 'Ukuran foto melebihi batas maksimal 15 MB sebelum dipotong.',
                    });
                    if (!cek.valid) {
                        if (!pesanGalatPertama) pesanGalatPertama = cek.pesan;
                        continue;
                    }
                } else {
                    if (!file.type || !['image/jpeg', 'image/png', 'image/webp'].includes(file.type.toLowerCase())) {
                        if (!pesanGalatPertama) pesanGalatPertama = 'Format berkas harus berupa gambar (JPG, PNG, atau WebP).';
                        continue;
                    }
                    if (file.size > 15 * 1024 * 1024) {
                        if (!pesanGalatPertama) pesanGalatPertama = 'Ukuran foto melebihi batas maksimal 15 MB sebelum dipotong.';
                        continue;
                    }
                }
                berkasValid.push(file);
            }

            if (berkasValid.length === 0) {
                this.pesanGalatGaleri = pesanGalatPertama || 'Format berkas harus berupa gambar (JPG, PNG, atau WebP).';
                return;
            }

            const antrean = berkasValid.slice(0, sisaSlot);
            if (berkasValid.length > sisaSlot) {
                this.pesanGalatGaleri = `Hanya ${sisaSlot} foto pertama yang diproses (kuota maksimal ${this.maksGaleri} foto).`;
            } else if (pesanGalatPertama) {
                this.pesanGalatGaleri = `Sebagian berkas ditolak: ${pesanGalatPertama}`;
            }

            const total = antrean.length;
            const meta = this.rasioFotoTema?.foto_galeri || { rasio: 0.75, label: '3:4 Galeri', bentuk: 'rect' };

            const prosesIndex = (urutan) => {
                if (urutan >= total || this.daftarGaleri.length >= this.maksGaleri) {
                    return;
                }
                const file = antrean[urutan];
                const nomorFoto = this.daftarGaleri.length + 1;
                const judul = total > 1
                    ? `Potong Foto Galeri #${nomorFoto} (${urutan + 1}/${total})`
                    : `Atur Potongan Foto Galeri #${nomorFoto}`;

                this.bukaCropperFoto({
                    file,
                    judul,
                    rasio: meta.rasio,
                    labelRasio: meta.label,
                    bentuk: meta.bentuk,
                    namaAsli: file.name,
                    onSelesai: (fileHasil) => {
                        if (fileHasil.size > 5 * 1024 * 1024) {
                            this.pesanGalatGaleri = 'Ukuran hasil foto melebihi batas maksimal 5 MB.';
                            return;
                        }
                        const itemBaru = buatItemGaleri({
                            id: null,
                            path: '',
                            url: URL.createObjectURL(fileHasil),
                            keterangan: '',
                        });
                        galeriAsliMap.set(itemBaru.uid, file);
                        galeriHasilMap.set(itemBaru.uid, fileHasil);
                        this.daftarGaleri = [...this.daftarGaleri, itemBaru];
                        this.tandaiPerubahan();
                        this.jadwalkanLivePreview(true);

                        if (urutan + 1 < total && this.daftarGaleri.length < this.maksGaleri) {
                            this.$nextTick(() => {
                                window.setTimeout(() => prosesIndex(urutan + 1), 90);
                            });
                        }
                    },
                });
            };

            prosesIndex(0);
        },
        potongFotoGaleri(index) {
            const item = this.daftarGaleri[index];
            if (!item || !item.url) return;
            this.pesanGalatGaleri = '';
            const fileAsli = galeriAsliMap.get(item.uid) || null;
            const meta = this.rasioFotoTema?.foto_galeri || { rasio: 0.75, label: '3:4 Galeri', bentuk: 'rect' };

            this.bukaCropperFoto({
                file: fileAsli,
                srcUrl: fileAsli ? '' : item.url,
                judul: `Atur Potongan Foto Galeri #${index + 1}`,
                rasio: meta.rasio,
                labelRasio: meta.label,
                bentuk: meta.bentuk,
                namaAsli: fileAsli?.name || `galeri-${index + 1}.jpg`,
                onSelesai: (fileHasil) => {
                    if (fileHasil.size > 5 * 1024 * 1024) {
                        this.pesanGalatGaleri = 'Ukuran hasil foto melebihi batas maksimal 5 MB.';
                        return;
                    }
                    if (item.url && item.url.startsWith('blob:')) {
                        URL.revokeObjectURL(item.url);
                    }
                    galeriHasilMap.set(item.uid, fileHasil);
                    item.url = URL.createObjectURL(fileHasil);
                    this.tandaiPerubahan();
                    this.jadwalkanLivePreview(true);
                },
            });
        },
        pindahFotoGaleri(index, arah) {
            const target = index + arah;
            if (target < 0 || target >= this.daftarGaleri.length) return;
            const salinan = [...this.daftarGaleri];
            [salinan[index], salinan[target]] = [salinan[target], salinan[index]];
            this.daftarGaleri = salinan;
            this.tandaiPerubahan();
            this.jadwalkanLivePreview(true);
        },
        hapusFotoGaleri(index) {
            const item = this.daftarGaleri[index];
            if (!item) return;
            if (item.url && item.url.startsWith('blob:')) {
                URL.revokeObjectURL(item.url);
            }
            galeriAsliMap.delete(item.uid);
            galeriHasilMap.delete(item.uid);
            this.daftarGaleri = this.daftarGaleri.filter((_, i) => i !== index);
            this.pesanGalatGaleri = '';
            this.tandaiPerubahan();
            this.jadwalkanLivePreview(true);
        },
        saatUbahKeteranganGaleri() {
            this.tandaiPerubahan();
            this.jadwalkanLivePreview(false);
        },
        async pilihFotoCerita(index, acara) {
            const inputEl = acara?.target;
            const file = inputEl?.files?.[0];
            const item = this.daftarCerita[index];
            if (!file || !item) {
                return;
            }

            const validator = typeof window !== 'undefined' ? window.SesiTemuValidasiBerkas : null;
            if (validator?.validasi) {
                const cek = await validator.validasi(file, 'gambar', {
                    maksMb: 15,
                    pesanUkuran: 'Ukuran foto maksimal 15 MB sebelum dipotong.',
                });
                if (!cek.valid) {
                    inputEl.value = '';
                    window.Swal?.fire({
                        icon: 'warning',
                        title: 'Berkas Foto Ditolak',
                        text: cek.pesan,
                        confirmButtonColor: '#4B6358',
                    });
                    return;
                }
            } else {
                if (!file.type || !['image/jpeg', 'image/png', 'image/webp'].includes(file.type.toLowerCase())) {
                    inputEl.value = '';
                    return;
                }
                if (file.size > 15 * 1024 * 1024) {
                    inputEl.value = '';
                    window.Swal?.fire({
                        icon: 'warning',
                        title: 'Ukuran Foto Terlalu Besar',
                        text: 'Ukuran foto maksimal 15 MB sebelum dipotong.',
                        confirmButtonColor: '#4B6358',
                    });
                    return;
                }
            }

            const meta = this.rasioFotoTema?.foto_cerita || { rasio: 1.6, label: '16:10 Cerita', bentuk: 'rect' };
            this.bukaCropperFoto({
                file,
                judul: `Potong Foto Bab ${index + 1}`,
                rasio: meta.rasio,
                labelRasio: meta.label,
                bentuk: meta.bentuk,
                namaAsli: file.name,
                onSelesai: (fileHasil) => {
                    ceritaAsliMap.set(item, file);
                    ceritaHasilMap.set(item, fileHasil);
                    const dt = new DataTransfer();
                    dt.items.add(fileHasil);
                    inputEl.files = dt.files;
                    item.foto_url = URL.createObjectURL(fileHasil);
                    item.hapus_foto = false;
                    this.tandaiPerubahan();
                    this.jadwalkanLivePreview(true);
                },
                onBatal: () => {
                    const sebelumnya = ceritaHasilMap.get(item);
                    if (sebelumnya) {
                        const dt = new DataTransfer();
                        dt.items.add(sebelumnya);
                        inputEl.files = dt.files;
                    } else {
                        inputEl.value = '';
                    }
                },
            });
        },
        potongFotoCerita(index) {
            const item = this.daftarCerita[index];
            if (!item || !item.foto_url) return;
            const inputEl = this.$refs.panelKiri?.querySelector(`input[name="cerita_cinta[${index}][foto_file]"]`);
            const fileAsli = ceritaAsliMap.get(item) || null;
            const meta = this.rasioFotoTema?.foto_cerita || { rasio: 1.6, label: '16:10 Cerita', bentuk: 'rect' };
            this.bukaCropperFoto({
                file: fileAsli,
                srcUrl: fileAsli ? '' : item.foto_url,
                judul: `Atur Potongan Foto Bab ${index + 1}`,
                rasio: meta.rasio,
                labelRasio: meta.label,
                bentuk: meta.bentuk,
                namaAsli: fileAsli?.name || `foto-bab-${index + 1}.jpg`,
                onSelesai: (fileHasil) => {
                    ceritaHasilMap.set(item, fileHasil);
                    if (inputEl) {
                        const dt = new DataTransfer();
                        dt.items.add(fileHasil);
                        inputEl.files = dt.files;
                    }
                    item.foto_url = URL.createObjectURL(fileHasil);
                    item.hapus_foto = false;
                    this.tandaiPerubahan();
                    this.jadwalkanLivePreview(true);
                },
            });
        },
        hapusFotoCerita(index) {
            if (!this.daftarCerita[index]) {
                return;
            }
            const item = this.daftarCerita[index];
            ceritaAsliMap.delete(item);
            ceritaHasilMap.delete(item);
            const inputEl = this.$refs.panelKiri?.querySelector(`input[name="cerita_cinta[${index}][foto_file]"]`);
            if (inputEl) {
                inputEl.value = '';
            }
            item.foto = '';
            item.foto_url = '';
            item.hapus_foto = true;
            this.tandaiPerubahan();
            this.jadwalkanLivePreview(true);
        },
        bukaCropperFoto(detail) {
            if (!detail) return;
            if (cropTempUrl) {
                URL.revokeObjectURL(cropTempUrl);
                cropTempUrl = '';
            }
            cropImg = null;
            cropPointers.clear();
            cropLastPos = null;
            cropPinchDist = 0;
            cropSourceFile = detail.file || null;
            cropCallbacks = {
                onSelesai: typeof detail.onSelesai === 'function' ? detail.onSelesai : null,
                onBatal: typeof detail.onBatal === 'function' ? detail.onBatal : null,
            };

            const rasioAwal = Number(detail.rasio) > 0 ? Number(detail.rasio) : 0.75;
            this.cropJudul = detail.judul || 'Atur Potongan Foto';
            this.cropNamaAsli = detail.namaAsli || cropSourceFile?.name || 'foto.jpg';
            this.cropRasioTemplate = rasioAwal;
            this.cropLabelTemplate = detail.labelRasio || 'Sesuai Template';
            this.cropBentukTemplate = detail.bentuk || 'rect';
            this.cropRasio = rasioAwal;
            this.cropBentuk = this.cropBentukTemplate;
            this.cropZoom = 1;
            this.cropRotasi = 0;
            this.cropOffsetX = 0;
            this.cropOffsetY = 0;
            this.cropGalat = '';
            this.cropMenyimpan = false;
            this.cropMemuat = true;
            this.cropTerbuka = true;

            let src = '';
            if (cropSourceFile) {
                cropTempUrl = URL.createObjectURL(cropSourceFile);
                src = cropTempUrl;
            } else if (detail.srcUrl) {
                src = detail.srcUrl;
            }

            if (!src) {
                this.cropMemuat = false;
                this.cropGalat = 'Sumber gambar tidak ditemukan.';
                return;
            }

            const img = new Image();
            if (!src.startsWith('blob:') && !src.startsWith('data:')) {
                img.crossOrigin = 'anonymous';
            }
            img.onload = () => {
                cropImg = img;
                this.cropMemuat = false;
                this.$nextTick(() => {
                    window.requestAnimationFrame(() => this.ukurDanGambarCrop());
                });
            };
            img.onerror = () => {
                this.cropMemuat = false;
                this.cropGalat = 'Gagal memuat gambar untuk dipotong. Silakan pilih berkas gambar lain.';
            };
            img.src = src;
        },
        tutupCropperFoto(panggilBatal = true) {
            const cbBatal = cropCallbacks.onBatal;
            this.cropTerbuka = false;
            this.cropMemuat = false;
            this.cropMenyimpan = false;
            this.cropGalat = '';
            cropImg = null;
            cropSourceFile = null;
            cropCallbacks = {};
            cropPointers.clear();
            cropLastPos = null;
            cropPinchDist = 0;
            if (cropTempUrl) {
                URL.revokeObjectURL(cropTempUrl);
                cropTempUrl = '';
            }
            if (panggilBatal && typeof cbBatal === 'function') {
                cbBatal();
            }
        },
        putarCrop(derajat = 90) {
            this.cropRotasi = (this.cropRotasi + derajat + 360) % 360;
            this.cropOffsetX = 0;
            this.cropOffsetY = 0;
            this.gambarKanvasCrop();
        },
        resetCrop() {
            this.cropRasio = this.cropRasioTemplate;
            this.cropBentuk = this.cropBentukTemplate;
            this.cropZoom = 1;
            this.cropRotasi = 0;
            this.cropOffsetX = 0;
            this.cropOffsetY = 0;
            this.ukurDanGambarCrop();
        },
        ubahZoomCrop(nilaiBaru) {
            this.cropZoom = Math.min(3, Math.max(1, Number(nilaiBaru) || 1));
            this.batasiOffsetCrop();
            this.gambarKanvasCrop();
        },
        dimensiEfektifCrop() {
            if (!cropImg) return { effW: 1, effH: 1 };
            const rotasiTegak = this.cropRotasi % 180 !== 0;
            return {
                effW: rotasiTegak ? cropImg.naturalHeight : cropImg.naturalWidth,
                effH: rotasiTegak ? cropImg.naturalWidth : cropImg.naturalHeight,
            };
        },
        skalaDasarCrop() {
            const { effW, effH } = this.dimensiEfektifCrop();
            return Math.max(this.cropBoxW / effW, this.cropBoxH / effH);
        },
        batasiOffsetCrop() {
            if (!cropImg) return;
            const { effW, effH } = this.dimensiEfektifCrop();
            const scale = this.skalaDasarCrop() * this.cropZoom;
            const maxX = Math.max(0, (effW * scale - this.cropBoxW) / 2);
            const maxY = Math.max(0, (effH * scale - this.cropBoxH) / 2);
            this.cropOffsetX = Math.min(maxX, Math.max(-maxX, this.cropOffsetX));
            this.cropOffsetY = Math.min(maxY, Math.max(-maxY, this.cropOffsetY));
        },
        ukurDanGambarCrop() {
            const wadah = this.$refs.wadahKanvasCrop;
            if (!wadah) return;
            const rect = wadah.getBoundingClientRect();
            const stageW = Math.max(240, Math.floor(rect.width || 340));
            const stageH = Math.max(240, Math.floor(rect.height || 340));
            this.cropStageW = stageW;
            this.cropStageH = stageH;

            const pad = 24;
            const maksW = Math.max(140, stageW - pad * 2);
            const maksH = Math.max(140, stageH - pad * 2);
            let boxW = maksW;
            let boxH = boxW / this.cropRasio;
            if (boxH > maksH) {
                boxH = maksH;
                boxW = boxH * this.cropRasio;
            }
            this.cropBoxW = Math.round(boxW);
            this.cropBoxH = Math.round(boxH);
            this.batasiOffsetCrop();
            this.gambarKanvasCrop();
        },
        gambarKanvasCrop() {
            const canvas = this.$refs.kanvasCrop;
            if (!canvas || !cropImg) return;

            const dpr = Math.min(window.devicePixelRatio || 1, 2);
            const W = this.cropStageW;
            const H = this.cropStageH;
            if (canvas.width !== Math.round(W * dpr) || canvas.height !== Math.round(H * dpr)) {
                canvas.width = Math.round(W * dpr);
                canvas.height = Math.round(H * dpr);
            }

            const ctx = canvas.getContext('2d');
            if (!ctx) return;

            ctx.save();
            ctx.scale(dpr, dpr);
            ctx.clearRect(0, 0, W, H);
            ctx.fillStyle = '#111315';
            ctx.fillRect(0, 0, W, H);

            this.batasiOffsetCrop();
            const scale = this.skalaDasarCrop() * this.cropZoom;

            // 1. Gambar foto asli sesuai posisi, rotasi, dan zoom
            ctx.save();
            ctx.translate(W / 2 + this.cropOffsetX, H / 2 + this.cropOffsetY);
            ctx.rotate((this.cropRotasi * Math.PI) / 180);
            ctx.scale(scale, scale);
            ctx.drawImage(cropImg, -cropImg.naturalWidth / 2, -cropImg.naturalHeight / 2);
            ctx.restore();

            // 2. Redupkan area di luar kotak potong
            const x = Math.round((W - this.cropBoxW) / 2);
            const y = Math.round((H - this.cropBoxH) / 2);
            const bw = this.cropBoxW;
            const bh = this.cropBoxH;

            ctx.fillStyle = 'rgba(10, 12, 14, 0.62)';
            ctx.beginPath();
            ctx.rect(0, 0, W, H);
            ctx.rect(x, y, bw, bh);
            ctx.fill('evenodd');

            // 3. Garis bantu rule-of-thirds tipis di dalam bingkai potong
            ctx.strokeStyle = 'rgba(255, 255, 255, 0.24)';
            ctx.lineWidth = 1;
            ctx.beginPath();
            ctx.moveTo(x + bw / 3, y);
            ctx.lineTo(x + bw / 3, y + bh);
            ctx.moveTo(x + (bw * 2) / 3, y);
            ctx.lineTo(x + (bw * 2) / 3, y + bh);
            ctx.moveTo(x, y + bh / 3);
            ctx.lineTo(x + bw, y + bh / 3);
            ctx.moveTo(x, y + (bh * 2) / 3);
            ctx.lineTo(x + bw, y + (bh * 2) / 3);
            ctx.stroke();

            // 4. Panduan bentuk khusus template (kapsul / lengkung mihrab)
            if (this.cropBentuk === 'pill' || this.cropBentuk === 'arch') {
                const rAtas = Math.min(bw / 2, bh / 2);
                const rBawah = this.cropBentuk === 'pill' ? rAtas : Math.min(14, bw * 0.08);
                ctx.save();
                ctx.strokeStyle = 'rgba(243, 229, 171, 0.9)';
                ctx.lineWidth = 1.6;
                ctx.setLineDash([6, 4]);
                ctx.beginPath();
                ctx.moveTo(x + rAtas, y);
                ctx.arcTo(x + bw, y, x + bw, y + rAtas, rAtas);
                ctx.lineTo(x + bw, y + bh - rBawah);
                ctx.arcTo(x + bw, y + bh, x + bw - rBawah, y + bh, rBawah);
                ctx.lineTo(x + rBawah, y + bh);
                ctx.arcTo(x, y + bh, x, y + bh - rBawah, rBawah);
                ctx.lineTo(x, y + rAtas);
                ctx.arcTo(x, y, x + rAtas, y, rAtas);
                ctx.closePath();
                ctx.stroke();
                ctx.restore();
            }

            // 5. Bingkai kotak potong & siku sudut tegas
            ctx.strokeStyle = 'rgba(255, 255, 255, 0.92)';
            ctx.lineWidth = 1.5;
            ctx.strokeRect(x + 0.5, y + 0.5, bw - 1, bh - 1);

            const siku = 16;
            ctx.strokeStyle = '#FFFFFF';
            ctx.lineWidth = 3;
            ctx.beginPath();
            ctx.moveTo(x, y + siku); ctx.lineTo(x, y); ctx.lineTo(x + siku, y);
            ctx.moveTo(x + bw - siku, y); ctx.lineTo(x + bw, y); ctx.lineTo(x + bw, y + siku);
            ctx.moveTo(x, y + bh - siku); ctx.lineTo(x, y + bh); ctx.lineTo(x + siku, y + bh);
            ctx.moveTo(x + bw - siku, y + bh); ctx.lineTo(x + bw, y + bh); ctx.lineTo(x + bw, y + bh - siku);
            ctx.stroke();

            ctx.restore();
        },
        cropPointerDown(event) {
            if (!cropImg) return;
            event.currentTarget.setPointerCapture?.(event.pointerId);
            cropPointers.set(event.pointerId, { x: event.clientX, y: event.clientY });
            if (cropPointers.size === 1) {
                cropLastPos = { x: event.clientX, y: event.clientY };
            } else if (cropPointers.size === 2) {
                const [p1, p2] = Array.from(cropPointers.values());
                cropPinchDist = Math.hypot(p2.x - p1.x, p2.y - p1.y);
            }
        },
        cropPointerMove(event) {
            if (!cropPointers.has(event.pointerId) || !cropImg) return;
            cropPointers.set(event.pointerId, { x: event.clientX, y: event.clientY });

            if (cropPointers.size === 1 && cropLastPos) {
                const dx = event.clientX - cropLastPos.x;
                const dy = event.clientY - cropLastPos.y;
                cropLastPos = { x: event.clientX, y: event.clientY };
                this.cropOffsetX += dx;
                this.cropOffsetY += dy;
                this.batasiOffsetCrop();
                this.gambarKanvasCrop();
            } else if (cropPointers.size === 2) {
                const [p1, p2] = Array.from(cropPointers.values());
                const dist = Math.hypot(p2.x - p1.x, p2.y - p1.y);
                if (cropPinchDist > 0 && dist > 0) {
                    this.ubahZoomCrop(this.cropZoom * (dist / cropPinchDist));
                }
                cropPinchDist = dist;
            }
        },
        cropPointerUp(event) {
            cropPointers.delete(event.pointerId);
            if (cropPointers.size === 1) {
                const [sisa] = Array.from(cropPointers.values());
                cropLastPos = { x: sisa.x, y: sisa.y };
            } else {
                cropLastPos = null;
            }
            if (cropPointers.size < 2) {
                cropPinchDist = 0;
            }
        },
        cropWheelZoom(event) {
            if (!cropImg) return;
            const delta = -event.deltaY * 0.0014;
            this.ubahZoomCrop(this.cropZoom + delta);
        },
        terapkanPotonganFoto() {
            if (!cropImg || this.cropMenyimpan) return;
            this.cropMenyimpan = true;
            this.cropGalat = '';

            try {
                this.batasiOffsetCrop();
                const scale = this.skalaDasarCrop() * this.cropZoom;
                const maksSisi = 1600;
                let outW;
                let outH;
                if (this.cropRasio >= 1) {
                    outW = Math.min(maksSisi, Math.max(720, Math.round(this.cropBoxW / scale)));
                    outH = Math.max(1, Math.round(outW / this.cropRasio));
                } else {
                    outH = Math.min(maksSisi, Math.max(720, Math.round(this.cropBoxH / scale)));
                    outW = Math.max(1, Math.round(outH * this.cropRasio));
                }

                const exportScale = outW / this.cropBoxW;
                const outCanvas = document.createElement('canvas');
                outCanvas.width = outW;
                outCanvas.height = outH;
                const outCtx = outCanvas.getContext('2d');
                if (!outCtx) {
                    throw new Error('Canvas tidak tersedia');
                }

                outCtx.fillStyle = '#18181B';
                outCtx.fillRect(0, 0, outW, outH);
                outCtx.save();
                outCtx.translate(outW / 2 + this.cropOffsetX * exportScale, outH / 2 + this.cropOffsetY * exportScale);
                outCtx.rotate((this.cropRotasi * Math.PI) / 180);
                outCtx.scale(scale * exportScale, scale * exportScale);
                outCtx.drawImage(cropImg, -cropImg.naturalWidth / 2, -cropImg.naturalHeight / 2);
                outCtx.restore();

                const namaDasar = (this.cropNamaAsli || 'foto').replace(/\.[^.]+$/, '');
                const cbSelesai = cropCallbacks.onSelesai;

                outCanvas.toBlob((blob) => {
                    if (!blob) {
                        this.cropMenyimpan = false;
                        this.cropGalat = 'Gagal memproses potongan foto. Silakan coba lagi.';
                        return;
                    }
                    const fileHasil = new File([blob], `${namaDasar}.jpg`, {
                        type: 'image/jpeg',
                        lastModified: Date.now(),
                    });
                    this.tutupCropperFoto(false);
                    if (typeof cbSelesai === 'function') {
                        cbSelesai(fileHasil);
                    }
                }, 'image/jpeg', 0.92);
            } catch (_) {
                this.cropMenyimpan = false;
                this.cropGalat = 'Tidak dapat memotong gambar ini. Coba unggah ulang file dari perangkat.';
            }
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
        saatPilihBank(event) {
            const nilai = event?.target?.value ?? this.bankPilihan ?? '';
            this.bankPilihan = nilai;
            if (nilai === '__lainnya__') {
                this.bankBaru = (this.bankKustom || '').trim();
            } else {
                this.bankKustom = '';
                this.bankBaru = nilai;
            }
        },
        async simpanAmplop(event) {
            if (this.sedangSimpanAmplop) return;
            const form = event?.target;
            const pilihanAktif = this.$refs.bankSelect?.value || this.bankPilihan || '';
            const namaBank = pilihanAktif === '__lainnya__'
                ? (this.bankKustom || '').trim()
                : (pilihanAktif || this.bankBaru || '').trim();

            if (!namaBank) {
                window.Swal?.fire({
                    icon: 'warning',
                    title: 'Bank / E-Wallet Belum Dipilih',
                    text: 'Silakan pilih atau ketik nama bank / e-wallet terlebih dahulu.',
                    confirmButtonColor: '#4B6358',
                });
                return;
            }
            if (form && typeof form.reportValidity === 'function' && !form.reportValidity()) {
                return;
            }

            const url = this.urlSimpanAmplop || form?.action;
            if (!url) return;

            this.sedangSimpanAmplop = true;
            try {
                const token = document.querySelector('meta[name=csrf-token]')?.content || this.csrfToken;
                const respon = await fetch(url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify({
                        nama_bank: namaBank,
                        nomor_rekening: (this.formAmplop.nomor_rekening || '').trim(),
                        atas_nama: (this.formAmplop.atas_nama || '').trim(),
                    }),
                });

                const data = await respon.json().catch(() => ({}));
                if (!respon.ok) {
                    const daftarGalat = data?.errors ? Object.values(data.errors).flat() : [];
                    const pesanError = daftarGalat.length > 0
                        ? daftarGalat.join('\n')
                        : (data?.message || 'Gagal menambahkan rekening. Silakan periksa kembali isian Anda.');
                    window.Swal?.fire({
                        icon: 'error',
                        title: 'Periksa Isian Rekening',
                        text: pesanError,
                        confirmButtonColor: '#4B6358',
                    });
                    return;
                }

                if (Array.isArray(data?.daftar_amplop)) {
                    this.daftarAmplop = data.daftar_amplop;
                }
                this.bankPilihan = '';
                this.bankKustom = '';
                this.bankBaru = '';
                this.formAmplop = { nomor_rekening: '', atas_nama: '' };
                this.$nextTick(() => this.sinkronSelect2El(this.$refs.bankSelect, ''));
                this.jadwalkanLivePreview(true, 'amplop');

                this.tampilkanToast(
                    data?.pesan || 'Rekening amplop digital berhasil ditambahkan.',
                    'Rekening Ditambahkan'
                );
            } catch (_) {
                window.Swal?.fire({
                    icon: 'error',
                    title: 'Koneksi Terputus',
                    text: 'Tidak dapat menghubungi server saat menambahkan rekening. Silakan coba lagi.',
                    confirmButtonColor: '#4B6358',
                });
            } finally {
                this.sedangSimpanAmplop = false;
            }
        },
        async hapusAmplop(amplop) {
            if (!amplop?.id || !amplop?.url_hapus || this.amplopHapusId) return;

            if (window.Swal) {
                const konfirmasi = await window.Swal.fire({
                    title: 'Hapus Rekening?',
                    text: `Yakin ingin menghapus kartu ${amplop.nama_bank} (${amplop.nomor_rekening})?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#DC2626',
                    cancelButtonColor: '#6B7280',
                    reverseButtons: true,
                    focusCancel: true,
                });
                if (!konfirmasi?.isConfirmed) return;
            }

            this.amplopHapusId = amplop.id;
            try {
                const token = document.querySelector('meta[name=csrf-token]')?.content || this.csrfToken;
                const respon = await fetch(amplop.url_hapus, {
                    method: 'DELETE',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': token,
                    },
                });

                const data = await respon.json().catch(() => ({}));
                if (!respon.ok) {
                    window.Swal?.fire({
                        icon: 'error',
                        title: 'Gagal Menghapus Rekening',
                        text: data?.message || 'Tidak dapat menghapus kartu rekening saat ini. Silakan coba lagi.',
                        confirmButtonColor: '#4B6358',
                    });
                    return;
                }

                if (Array.isArray(data?.daftar_amplop)) {
                    this.daftarAmplop = data.daftar_amplop;
                }
                this.jadwalkanLivePreview(true, 'amplop');

                this.tampilkanToast(
                    data?.pesan || 'Rekening amplop digital berhasil dihapus.',
                    'Rekening Dihapus'
                );
            } catch (_) {
                window.Swal?.fire({
                    icon: 'error',
                    title: 'Koneksi Terputus',
                    text: 'Tidak dapat menghubungi server saat menghapus rekening. Silakan coba lagi.',
                    confirmButtonColor: '#4B6358',
                });
            } finally {
                this.amplopHapusId = null;
            }
        },
    };
}
