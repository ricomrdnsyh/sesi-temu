export function halamanTamuUndangan(cfgMasuk = null) {
    let cfg = cfgMasuk;
    if (!cfg && typeof document !== 'undefined') {
        try {
            const el = document.getElementById('tamu-template-pesan-config');
            cfg = el ? JSON.parse(el.textContent || '{}') : {};
        } catch {
            cfg = {};
        }
    }
    cfg = cfg || {};

    return {
        urlPublikUndangan: cfg.urlPublikUndangan || '',
        namaPria: cfg.namaPria || '',
        namaWanita: cfg.namaWanita || '',
        siapDisebarUndangan: Boolean(cfg.siapDisebarUndangan),
        csrfToken: cfg.csrfToken || '',
        daftarTamu: Array.isArray(cfg.daftarTamu) ? cfg.daftarTamu : [],
        daftarKategori: Array.isArray(cfg.daftarKategori) ? cfg.daftarKategori : [],
        warnaKategoriPilihan: Array.isArray(cfg.warnaKategori) && cfg.warnaKategori.length > 0
            ? cfg.warnaKategori
            : ['#A85F6E', '#B37156', '#9A7F49', '#5F7D6E', '#527F80', '#5A789B', '#7E6C99', '#95677F'],
        urlSimpanKategori: cfg.urlSimpanKategori || '',
        templatePesanWa: cfg.templateAwal || '',
        templatePesanBawaan: cfg.templateBawaan || '',
        daftarPresetPesan: Array.isArray(cfg.presets) ? cfg.presets : [],
        urlSimpanTemplatePesan: cfg.urlSimpan || '',
        modalTemplatePesan: false,
        modalKategori: false,
        namaKategoriBaru: '',
        warnaKategoriBaru: '#A85F6E',
        sedangSimpanKategori: false,
        sedangHapusKategoriId: null,
        pesanGalatKategori: '',
        dropdownPresetTerbuka: false,
        dropdownKelolaTerbuka: false,
        dropdownAturTerbuka: false,
        presetPesanTerpilih: '',
        draftTemplatePesan: cfg.templateAwal || '',
        sedangSimpanTemplatePesan: false,
        pesanGalatTemplate: '',
        namaFileCsv: '',
        ukuranFileCsv: '',
        jumlahBarisCsv: null,
        sedangTarikCsv: false,
        pesanGalatCsv: '',
        daftarBulkTeks: cfg.daftarBulkAwal || '',
        filterStatus: 'semua',
        filterKategori: 'semua',
        kataCari: '',
        urutan: 'terbaru',
        perHalaman: 10,
        halaman: 1,
        menuTamu: null,
        menuStyle: { top: '0px', right: '16px', bottom: 'auto' },
        modalTambah: Boolean(cfg.modalTambah),
        modeTambah: cfg.modeTambah || 'satuan',
        modalEdit: false,
        tamuDiedit: null,
        editNama: '',
        editWa: '',
        editKategoriId: '',
        sedangSimpanEdit: false,

        init() {
            this.draftTemplatePesan = this.templatePesanWa;
            this.presetPesanTerpilih = this.deteksiPresetDariTeks(this.templatePesanWa);
            this.daftarTamu.forEach((item, idx) => {
                item._urutanAwal = idx;
                this.lengkapiDataTamu(item);
            });
        },

        inisialNama(nama) {
            const bagian = String(nama || '').trim().split(/\s+/).filter(Boolean);
            if (bagian.length === 0) return 'TM';
            if (bagian.length === 1) return bagian[0].slice(0, 2).toUpperCase();
            return (bagian[0][0] + bagian[bagian.length - 1][0]).toUpperCase();
        },

        persenDibuka() {
            if (this.daftarTamu.length === 0) return 0;
            return Math.round((this.stat().sudahDibuka / this.daftarTamu.length) * 100);
        },

        setFilterStatus(status) {
            this.filterStatus = status;
            this.halaman = 1;
            this.menuTamu = null;
        },

        setFilterKategori(kategoriId) {
            this.filterKategori = kategoriId;
            this.halaman = 1;
            this.menuTamu = null;
        },

        cariKategori(id) {
            if (id === null || id === undefined || id === '') return null;
            return this.daftarKategori.find((k) => Number(k.id) === Number(id)) || null;
        },

        labelFilterKategori() {
            if (this.filterKategori === 'tanpa') return 'Tanpa Kategori';
            return this.cariKategori(this.filterKategori)?.nama || '';
        },

        jumlahTamuKategori(katId) {
            return this.daftarTamu.filter((t) => Number(t.kategori_tamu_id) === Number(katId)).length;
        },

        bukaModalKategori() {
            if (typeof window !== 'undefined') window.SesiTemuSelect2?.close?.();
            this.menuTamu = null;
            this.dropdownKelolaTerbuka = false;
            this.dropdownAturTerbuka = false;
            this.pesanGalatKategori = '';
            this.namaKategoriBaru = '';
            this.warnaKategoriBaru = this.warnaKategoriPilihan[0] || '#A85F6E';
            this.modalKategori = true;
        },

        tutupModalKategori() {
            this.modalKategori = false;
            this.pesanGalatKategori = '';
        },

        sinkronSelect2Kategori() {
            if (typeof document === 'undefined') return;
            document.querySelectorAll('select[data-select2-kategori="true"]').forEach((el) => {
                if (el.id === 'edit_kategori_tamu') {
                    el.value = this.editKategoriId || '';
                } else if (el.value && !this.cariKategori(el.value)) {
                    el.value = '';
                }
                window.SesiTemuSelect2?.refresh?.(el);
            });
        },

        async tambahKategori() {
            if (this.sedangSimpanKategori) return;
            const nama = (this.namaKategoriBaru || '').trim();
            this.pesanGalatKategori = '';
            if (!nama) {
                this.pesanGalatKategori = 'Masukkan nama kategori terlebih dahulu.';
                return;
            }

            this.sedangSimpanKategori = true;
            try {
                const token = document.querySelector('meta[name=csrf-token]')?.content || this.csrfToken;
                const res = await fetch(this.urlSimpanKategori, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify({
                        nama,
                        warna: this.warnaKategoriBaru,
                    }),
                });

                const data = await res.json().catch(() => ({}));
                if (!res.ok || !data?.kategori) {
                    this.pesanGalatKategori = data?.pesan || data?.message || 'Gagal menambahkan kategori.';
                    return;
                }

                this.daftarKategori.push(data.kategori);
                this.namaKategoriBaru = '';
                const idxWarna = this.warnaKategoriPilihan.indexOf(this.warnaKategoriBaru);
                this.warnaKategoriBaru = this.warnaKategoriPilihan[(idxWarna + 1) % this.warnaKategoriPilihan.length];
                this.$nextTick(() => this.sinkronSelect2Kategori());

                window.Swal?.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: data?.pesan || 'Kategori ditambahkan',
                    showConfirmButton: false,
                    timer: 1800,
                });
            } catch {
                this.pesanGalatKategori = 'Koneksi terputus. Silakan coba lagi.';
            } finally {
                this.sedangSimpanKategori = false;
            }
        },

        async hapusKategori(kat) {
            if (!kat || this.sedangHapusKategoriId !== null) return;
            const jumlahDipakai = this.jumlahTamuKategori(kat.id);
            if (jumlahDipakai > 0 && window.Swal) {
                const konfirm = await window.Swal.fire({
                    icon: 'warning',
                    title: `Hapus Kategori "${kat.nama}"?`,
                    text: `${jumlahDipakai} tamu menggunakan kategori ini. Data tamu tetap tersimpan tanpa kategori.`,
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#DC2626',
                    cancelButtonColor: '#6B7280',
                    reverseButtons: true,
                });
                if (!konfirm.isConfirmed) return;
            }

            this.sedangHapusKategoriId = kat.id;
            this.pesanGalatKategori = '';
            try {
                const token = document.querySelector('meta[name=csrf-token]')?.content || this.csrfToken;
                const res = await fetch(kat.url_hapus, {
                    method: 'DELETE',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': token,
                    },
                });

                const data = await res.json().catch(() => ({}));
                if (!res.ok) {
                    this.pesanGalatKategori = data?.pesan || data?.message || 'Gagal menghapus kategori.';
                    return;
                }

                this.daftarKategori = this.daftarKategori.filter((k) => Number(k.id) !== Number(kat.id));
                this.daftarTamu.forEach((t) => {
                    if (Number(t.kategori_tamu_id) === Number(kat.id)) {
                        t.kategori_tamu_id = null;
                    }
                });
                if (String(this.filterKategori) === String(kat.id)) {
                    this.filterKategori = 'semua';
                }
                if (String(this.editKategoriId) === String(kat.id)) {
                    this.editKategoriId = '';
                }
                this.$nextTick(() => this.sinkronSelect2Kategori());

                window.Swal?.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: data?.pesan || 'Kategori dihapus',
                    showConfirmButton: false,
                    timer: 1800,
                });
            } catch {
                this.pesanGalatKategori = 'Koneksi terputus. Silakan coba lagi.';
            } finally {
                this.sedangHapusKategoriId = null;
            }
        },

        setUrutan(nilai) {
            this.urutan = nilai;
            this.halaman = 1;
        },

        formatNomorWaTampil(nomor) {
            const bersih = String(nomor || '').replace(/\D+/g, '');
            if (!bersih) return '';
            if (bersih.startsWith('62') && bersih.length >= 10) {
                const lokal = bersih.slice(2);
                return '+62 ' + lokal.replace(/(\d{3})(\d{4})(\d+)/, '$1-$2-$3');
            }
            return '+' + bersih;
        },

        susunPesanDariTemplate(template, namaTamu, urlTamu) {
            const dasar = String(template || this.templatePesanBawaan || '');
            return dasar
                .split('{nama}').join(String(namaTamu || ''))
                .split('{link}').join(String(urlTamu || ''));
        },

        lengkapiDataTamu(item) {
            const urlTamu = `${this.urlPublikUndangan}?to=${encodeURIComponent(item.nama_tamu)}&g=${encodeURIComponent(item.kode_tamu)}`;
            const pesan = this.susunPesanDariTemplate(this.templatePesanWa, item.nama_tamu, urlTamu);
            const nomorBersih = String(item.nomor_wa || '');

            item.urlTamu = urlTamu;
            item.pesan = this.siapDisebarUndangan ? pesan : '';
            item.waUrl = this.siapDisebarUndangan
                ? (item.nomor_wa
                    ? `https://wa.me/${item.nomor_wa}?text=${encodeURIComponent(pesan)}`
                    : `https://wa.me/?text=${encodeURIComponent(pesan)}`)
                : '#';
            item.nomorWaTampil = this.formatNomorWaTampil(item.nomor_wa);
            item.nomorLokalCari = nomorBersih.startsWith('62') ? '0' + nomorBersih.slice(2) : nomorBersih;
            return item;
        },

        perbaruiSemuaPesanTamu() {
            this.daftarTamu.forEach((item) => this.lengkapiDataTamu(item));
        },

        deteksiPresetDariTeks(teks) {
            const bersih = String(teks || '').replace(/\r\n?/g, '\n').trim();
            const cocok = this.daftarPresetPesan.find(
                (p) => String(p.isi || '').replace(/\r\n?/g, '\n').trim() === bersih
            );
            return cocok ? cocok.kode : 'kustom';
        },

        labelPresetAktif() {
            const cocok = this.daftarPresetPesan.find((p) => p.kode === this.presetPesanTerpilih);
            return cocok ? cocok.label : 'Kustom (Edit Sendiri)';
        },

        bukaModalTemplatePesan() {
            this.menuTamu = null;
            this.dropdownKelolaTerbuka = false;
            this.dropdownAturTerbuka = false;
            this.draftTemplatePesan = this.templatePesanWa;
            this.presetPesanTerpilih = this.deteksiPresetDariTeks(this.draftTemplatePesan);
            this.dropdownPresetTerbuka = false;
            this.pesanGalatTemplate = '';
            this.modalTemplatePesan = true;
        },

        tutupModalTemplatePesan() {
            this.dropdownPresetTerbuka = false;
            this.modalTemplatePesan = false;
        },

        pilihPresetPesan(preset) {
            if (!preset) return;
            this.presetPesanTerpilih = preset.kode;
            this.draftTemplatePesan = preset.isi;
            this.dropdownPresetTerbuka = false;
            this.pesanGalatTemplate = '';
        },

        resetTemplateBawaan() {
            this.draftTemplatePesan = this.templatePesanBawaan;
            this.presetPesanTerpilih = this.deteksiPresetDariTeks(this.draftTemplatePesan);
            this.pesanGalatTemplate = '';
        },

        templateMemilikiNama() {
            return String(this.draftTemplatePesan || '').includes('{nama}');
        },

        templateMemilikiLink() {
            return String(this.draftTemplatePesan || '').includes('{link}');
        },

        templatePesanValid() {
            return String(this.draftTemplatePesan || '').trim().length > 0
                && this.templateMemilikiNama()
                && this.templateMemilikiLink();
        },

        formatTeksTemplate(simbol) {
            const ta = this.$refs.textareaTemplatePesan;
            const teks = String(this.draftTemplatePesan || '');
            if (!ta) {
                this.draftTemplatePesan = teks + `${simbol}teks${simbol}`;
                this.presetPesanTerpilih = this.deteksiPresetDariTeks(this.draftTemplatePesan);
                return;
            }
            const start = ta.selectionStart ?? teks.length;
            const end = ta.selectionEnd ?? teks.length;
            const terpilih = teks.slice(start, end);
            const spasiAwal = terpilih.match(/^\s*/)[0];
            const spasiAkhir = terpilih.match(/\s*$/)[0];
            const intiStart = start + spasiAwal.length;
            const intiEnd = Math.max(intiStart, end - spasiAkhir.length);
            const inti = teks.slice(intiStart, intiEnd);
            let hasil;
            let selStart;
            let selEnd;
            if (inti.length > 0) {
                if (inti.includes('\n')) {
                    const baris = inti.split('\n');
                    const terbungkusSemua = baris.every((b) => {
                        const t = b.trim();
                        return !t || (t.startsWith(simbol) && t.endsWith(simbol) && t.length > simbol.length * 2);
                    });
                    const diubah = baris.map((b) => {
                        const t = b.trim();
                        if (!t) return b;
                        const aw = b.match(/^\s*/)[0];
                        const ak = b.match(/\s*$/)[0];
                        const baru = terbungkusSemua
                            ? t.slice(simbol.length, -simbol.length)
                            : `${simbol}${t}${simbol}`;
                        return aw + baru + ak;
                    }).join('\n');
                    hasil = teks.slice(0, intiStart) + diubah + teks.slice(intiEnd);
                    selStart = intiStart;
                    selEnd = intiStart + diubah.length;
                } else if (inti.startsWith(simbol) && inti.endsWith(simbol) && inti.length > simbol.length * 2) {
                    const isi = inti.slice(simbol.length, -simbol.length);
                    hasil = teks.slice(0, intiStart) + isi + teks.slice(intiEnd);
                    selStart = intiStart;
                    selEnd = intiStart + isi.length;
                } else if (
                    intiStart >= simbol.length
                    && teks.slice(intiStart - simbol.length, intiStart) === simbol
                    && teks.slice(intiEnd, intiEnd + simbol.length) === simbol
                ) {
                    hasil = teks.slice(0, intiStart - simbol.length) + inti + teks.slice(intiEnd + simbol.length);
                    selStart = intiStart - simbol.length;
                    selEnd = selStart + inti.length;
                } else {
                    hasil = teks.slice(0, intiStart) + simbol + inti + simbol + teks.slice(intiEnd);
                    selStart = intiStart + simbol.length;
                    selEnd = selStart + inti.length;
                }
            } else {
                const contoh = 'teks';
                hasil = teks.slice(0, start) + spasiAwal + simbol + contoh + simbol + teks.slice(end);
                selStart = start + spasiAwal.length + simbol.length;
                selEnd = selStart + contoh.length;
            }
            this.draftTemplatePesan = hasil;
            this.presetPesanTerpilih = this.deteksiPresetDariTeks(hasil);
            this.$nextTick(() => {
                ta.focus();
                ta.setSelectionRange(selStart, selEnd);
            });
        },

        sisipkanKodeTemplate(kode) {
            const ta = this.$refs.textareaTemplatePesan;
            const teks = String(this.draftTemplatePesan || '');
            if (!ta) {
                this.draftTemplatePesan = teks + kode;
                this.presetPesanTerpilih = this.deteksiPresetDariTeks(this.draftTemplatePesan);
                return;
            }
            const start = ta.selectionStart ?? teks.length;
            const end = ta.selectionEnd ?? teks.length;
            const hasil = teks.slice(0, start) + kode + teks.slice(end);
            const kursorBaru = start + kode.length;
            this.draftTemplatePesan = hasil;
            this.presetPesanTerpilih = this.deteksiPresetDariTeks(hasil);
            this.pesanGalatTemplate = '';
            this.$nextTick(() => {
                ta.focus();
                ta.setSelectionRange(kursorBaru, kursorBaru);
            });
        },

        waktuPreviewWa() {
            const d = new Date();
            return String(d.getHours()).padStart(2, '0') + ':' + String(d.getMinutes()).padStart(2, '0');
        },

        renderPreviewWaHtml() {
            const contohNama = this.daftarTamu[0]?.nama_tamu || 'Budi & Keluarga';
            const contohLink = this.daftarTamu[0]?.urlTamu
                || `${this.urlPublikUndangan}?to=${encodeURIComponent('Budi & Keluarga')}&g=a3f9c2b1`;
            const teksJadi = this.susunPesanDariTemplate(this.draftTemplatePesan, contohNama, contohLink);

            const escapeHtml = (s) => String(s)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');

            const daftarUrl = [];
            const teksTanpaUrl = teksJadi.replace(/https?:\/\/[^\s<>]+/g, (url) => {
                const idx = daftarUrl.push(url) - 1;
                return `\u0000URL${idx}\u0000`;
            });

            let aman = escapeHtml(teksTanpaUrl)
                .replace(/\*(\S(?:[^*\n]*\S)?)\*/g, '<strong>$1</strong>')
                .replace(/(^|[^\p{L}\p{N}_])_(\S(?:[^_\n]*\S)?)_(?![\p{L}\p{N}_])/gmu, '$1<em>$2</em>')
                .replace(/~(\S(?:[^~\n]*\S)?)~/g, '<s>$1</s>')
                .replace(/\n/g, '<br>');

            aman = aman.replace(/\u0000URL(\d+)\u0000/g, (_, idx) => {
                const urlAman = escapeHtml(daftarUrl[Number(idx)] || '');
                return `<span class="text-[#027EB5] underline break-all">${urlAman}</span>`;
            });

            return aman;
        },

        async simpanTemplatePesan() {
            if (this.sedangSimpanTemplatePesan) return;
            this.pesanGalatTemplate = '';
            if (!this.templatePesanValid()) {
                this.pesanGalatTemplate = 'Template pesan wajib menyertakan kode {nama} dan {link}.';
                return;
            }

            this.sedangSimpanTemplatePesan = true;
            try {
                const token = document.querySelector('meta[name=csrf-token]')?.content || this.csrfToken;
                const res = await fetch(this.urlSimpanTemplatePesan, {
                    method: 'PUT',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify({
                        template_pesan_wa: this.draftTemplatePesan,
                    }),
                });

                const data = await res.json().catch(() => ({}));
                if (!res.ok) {
                    this.pesanGalatTemplate = data?.pesan || data?.message || 'Gagal menyimpan template pesan.';
                    return;
                }

                this.templatePesanWa = data.template_pesan_wa || this.draftTemplatePesan;
                this.draftTemplatePesan = this.templatePesanWa;
                this.presetPesanTerpilih = this.deteksiPresetDariTeks(this.templatePesanWa);
                this.perbaruiSemuaPesanTamu();
                this.tutupModalTemplatePesan();

                window.Swal?.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: data?.pesan || 'Template pesan WhatsApp disimpan',
                    showConfirmButton: false,
                    timer: 2200,
                    timerProgressBar: true,
                });
            } catch {
                this.pesanGalatTemplate = 'Koneksi terputus. Silakan coba lagi.';
            } finally {
                this.sedangSimpanTemplatePesan = false;
            }
        },

        stat() {
            const total = this.daftarTamu.length;
            let sudahDikirim = 0;
            let sudahDibuka = 0;

            for (const item of this.daftarTamu) {
                if (item.sudah_dikirim) sudahDikirim++;
                if (item.sudah_dibuka) sudahDibuka++;
            }

            return {
                total,
                belumDikirim: total - sudahDikirim,
                sudahDikirim,
                sudahDibuka,
            };
        },

        daftarTersaring() {
            const kata = (this.kataCari || '').trim().toLowerCase();
            const hasil = this.daftarTamu.filter((item) => {
                if (this.filterStatus === 'belum_dikirim' && item.sudah_dikirim) return false;
                if (this.filterStatus === 'sudah_dikirim' && !item.sudah_dikirim) return false;
                if (this.filterStatus === 'sudah_dibuka' && !item.sudah_dibuka) return false;

                if (this.filterKategori === 'tanpa' && item.kategori_tamu_id) return false;
                if (this.filterKategori !== 'semua' && this.filterKategori !== 'tanpa'
                    && String(item.kategori_tamu_id || '') !== String(this.filterKategori)) {
                    return false;
                }

                if (kata) {
                    const cocokNama = (item.nama_tamu || '').toLowerCase().includes(kata);
                    const cocokWa = (item.nomor_wa || '').toLowerCase().includes(kata)
                        || (item.nomorWaTampil || '').toLowerCase().includes(kata)
                        || (item.nomorLokalCari || '').toLowerCase().includes(kata);
                    const cocokKat = (this.cariKategori(item.kategori_tamu_id)?.nama || '').toLowerCase().includes(kata);
                    return cocokNama || cocokWa || cocokKat;
                }

                return true;
            });

            if (this.urutan === 'nama_az') {
                return [...hasil].sort((a, b) => (a.nama_tamu || '').localeCompare(b.nama_tamu || '', 'id'));
            }
            if (this.urutan === 'sering_dibuka') {
                return [...hasil].sort((a, b) => (b.jumlah_dibuka - a.jumlah_dibuka) || (a._urutanAwal - b._urutanAwal));
            }

            return hasil;
        },

        totalHalaman() {
            const total = this.daftarTersaring().length;
            if (this.perHalaman <= 0) return 1;
            return Math.max(1, Math.ceil(total / this.perHalaman));
        },

        halamanAman() {
            return Math.min(Math.max(1, this.halaman), this.totalHalaman());
        },

        daftarHalamanIni() {
            const semua = this.daftarTersaring();
            if (this.perHalaman <= 0) return semua;
            const mulai = (this.halamanAman() - 1) * this.perHalaman;
            return semua.slice(mulai, mulai + this.perHalaman);
        },

        ringkasanRentang() {
            const total = this.daftarTersaring().length;
            if (total === 0) return '0 tamu';
            if (this.perHalaman <= 0) return `Menampilkan semua ${total} tamu`;
            const mulai = (this.halamanAman() - 1) * this.perHalaman + 1;
            const akhir = Math.min(total, mulai + this.perHalaman - 1);
            return `Menampilkan ${mulai}–${akhir} dari ${total} tamu`;
        },

        bukaModalTambah(mode) {
            if (typeof window !== 'undefined') window.SesiTemuSelect2?.close?.();
            this.menuTamu = null;
            this.dropdownKelolaTerbuka = false;
            this.dropdownAturTerbuka = false;
            this.modeTambah = mode || 'satuan';
            this.pesanGalatCsv = '';
            this.modalTambah = true;
            this.$nextTick(() => this.sinkronSelect2Kategori());
        },

        normalisasiNomorWaJs(nomor) {
            let hanyaAngka = String(nomor || '').replace(/\D+/g, '');
            if (!hanyaAngka) return null;
            if (hanyaAngka.startsWith('0')) {
                hanyaAngka = '62' + hanyaAngka.slice(1);
            } else if (hanyaAngka.startsWith('8')) {
                hanyaAngka = '62' + hanyaAngka;
            }
            if (hanyaAngka.length < 8 || hanyaAngka.length > 16) return null;
            return hanyaAngka;
        },

        analisisDaftarBulk() {
            const barisDaftar = String(this.daftarBulkTeks || '').split(/\r\n|\r|\n/);
            const galat = [];
            let validCount = 0;
            let denganWaCount = 0;
            let tanpaWaCount = 0;
            let barisTerisi = 0;
            let bisaDiperbaikiOtomatis = false;

            barisDaftar.forEach((barisAsli, idx) => {
                const baris = barisAsli.trim();
                if (!baris) return;

                const noBaris = idx + 1;
                barisTerisi++;

                if (barisTerisi > 200) {
                    if (barisTerisi === 201) {
                        galat.push({
                            baris: noBaris,
                            pesan: 'Maksimal 200 tamu per sekali simpan. Kurangi baris atau pakai Import CSV.',
                            saranBaris: null,
                        });
                    }
                    return;
                }

                const cocokPemisah = baris.match(/^(.*)\s*[,|;\t]\s*([^,|;\t]*)$/);
                if (cocokPemisah) {
                    const namaTamu = cocokPemisah[1].trim();
                    const nomorMentah = cocokPemisah[2].trim();

                    if (!namaTamu) {
                        galat.push({
                            baris: noBaris,
                            pesan: 'Nama tamu kosong sebelum tanda pemisah.',
                            saranBaris: null,
                        });
                        return;
                    }

                    if (nomorMentah !== '') {
                        if (!/^[\d\s+\-().]+$/.test(nomorMentah) || !this.normalisasiNomorWaJs(nomorMentah)) {
                            galat.push({
                                baris: noBaris,
                                pesan: `Nomor WA "${nomorMentah}" tidak valid (gunakan 8–16 digit, misal 081234567890).`,
                                saranBaris: null,
                            });
                            return;
                        }
                        validCount++;
                        denganWaCount++;
                        return;
                    }

                    validCount++;
                    tanpaWaCount++;
                    return;
                }

                if (/^(?:\+?62|0|8)[\d\s\-().]{6,}$/.test(baris)) {
                    galat.push({
                        baris: noBaris,
                        pesan: `Hanya berisi nomor WA tanpa nama tamu ("${baris}").`,
                        saranBaris: null,
                    });
                    return;
                }

                const cocokSalahPemisah = baris.match(/^(.+?)\s*([.:\/\-])\s*((?:\+?62|0|8)[\d\s\-().]{6,})$/);
                if (cocokSalahPemisah) {
                    const namaSaran = cocokSalahPemisah[1].trim();
                    const sep = cocokSalahPemisah[2];
                    const nomorSaran = cocokSalahPemisah[3].trim();
                    const labelSep = sep === '.' ? 'titik (.)' : (sep === ':' ? 'titik dua (:)' : (sep === '/' ? 'garis miring (/)' : 'strip (-)'));
                    const saran = `${namaSaran}, ${nomorSaran}`;
                    bisaDiperbaikiOtomatis = true;
                    galat.push({
                        baris: noBaris,
                        pesan: `Terdeteksi ${labelSep} sebelum nomor WA. Gunakan koma (,) → ${saran}`,
                        saranBaris: saran,
                    });
                    return;
                }

                const cocokTanpaKoma = baris.match(/^(.+?)\s+((?:\+?62|08)[\d\s\-().]{6,})$/);
                if (cocokTanpaKoma) {
                    const namaSaran = cocokTanpaKoma[1].trim();
                    const nomorSaran = cocokTanpaKoma[2].trim();
                    const saran = `${namaSaran}, ${nomorSaran}`;
                    bisaDiperbaikiOtomatis = true;
                    galat.push({
                        baris: noBaris,
                        pesan: `Tambahkan koma (,) sebelum nomor WA → ${saran}`,
                        saranBaris: saran,
                    });
                    return;
                }

                validCount++;
                tanpaWaCount++;
            });

            return {
                validCount,
                denganWaCount,
                tanpaWaCount,
                barisTerisi,
                galat,
                bisaDiperbaikiOtomatis,
            };
        },

        perbaikiFormatBulkOtomatis() {
            const barisDaftar = String(this.daftarBulkTeks || '').split(/\r\n|\r|\n/);
            const diperbaiki = barisDaftar.map((barisAsli) => {
                const baris = barisAsli.trim();
                if (!baris || /[,|;\t]/.test(baris)) return barisAsli;

                const cocokSalahPemisah = baris.match(/^(.+?)\s*([.:\/\-])\s*((?:\+?62|0|8)[\d\s\-().]{6,})$/);
                if (cocokSalahPemisah) {
                    return `${cocokSalahPemisah[1].trim()}, ${cocokSalahPemisah[3].trim()}`;
                }

                const cocokTanpaKoma = baris.match(/^(.+?)\s+((?:\+?62|08)[\d\s\-().]{6,})$/);
                if (cocokTanpaKoma) {
                    return `${cocokTanpaKoma[1].trim()}, ${cocokTanpaKoma[2].trim()}`;
                }

                return barisAsli;
            });

            this.daftarBulkTeks = diperbaiki.join('\n');
        },

        cekKirimDaftarBulk(event) {
            const hasil = this.analisisDaftarBulk();
            if (hasil.barisTerisi === 0 || hasil.galat.length > 0) {
                event.preventDefault();
                event.stopImmediatePropagation();
                return false;
            }
            return true;
        },

        pilihFileCsv(event) {
            const file = event?.target?.files?.[0];
            if (!file) {
                this.hapusFileCsv();
                return;
            }
            this.prosesFileCsv(file);
        },

        jatuhFileCsv(event) {
            this.sedangTarikCsv = false;
            const file = event?.dataTransfer?.files?.[0];
            if (!file) return;
            if (this.$refs.inputFileCsv && typeof DataTransfer !== 'undefined') {
                const dt = new DataTransfer();
                dt.items.add(file);
                this.$refs.inputFileCsv.files = dt.files;
            }
            this.prosesFileCsv(file);
        },

        prosesFileCsv(file) {
            this.pesanGalatCsv = '';
            const nama = String(file.name || '');
            if (!/\.(csv|txt)$/i.test(nama)) {
                this.hapusFileCsv();
                this.pesanGalatCsv = 'Format file harus .csv (Comma Separated Values).';
                return;
            }
            if (file.size > 2 * 1024 * 1024) {
                this.hapusFileCsv();
                this.pesanGalatCsv = 'Ukuran file CSV maksimal 2 MB.';
                return;
            }

            this.namaFileCsv = nama;
            this.ukuranFileCsv = file.size < 1024 * 1024
                ? Math.max(1, Math.round(file.size / 1024)) + ' KB'
                : (file.size / (1024 * 1024)).toFixed(1) + ' MB';
            this.jumlahBarisCsv = null;

            if (typeof FileReader !== 'undefined') {
                const reader = new FileReader();
                reader.onload = () => {
                    const teks = String(reader.result || '').replace(/^\uFEFF/, '').replace(/\r\n?/g, '\n');
                    const baris = teks.split('\n').map((b) => b.trim()).filter(Boolean);
                    if (baris.length === 0) {
                        this.jumlahBarisCsv = 0;
                        return;
                    }
                    const pertama = baris[0].toLowerCase();
                    const adaHeader = /(^|[,;\t"])\s*(nama|nama tamu|name|guest)\s*([,;\t"]|$)/i.test(pertama);
                    this.jumlahBarisCsv = Math.min(500, Math.max(0, baris.length - (adaHeader ? 1 : 0)));
                };
                reader.readAsText(file);
            }
        },

        hapusFileCsv() {
            this.namaFileCsv = '';
            this.ukuranFileCsv = '';
            this.jumlahBarisCsv = null;
            this.pesanGalatCsv = '';
            if (this.$refs.inputFileCsv) {
                this.$refs.inputFileCsv.value = '';
            }
        },

        toggleMenu(tamu, event) {
            if (this.menuTamu?.id === tamu.id) {
                this.menuTamu = null;
                return;
            }
            const rect = event?.currentTarget?.getBoundingClientRect();
            if (rect) {
                const bukaAtas = (window.innerHeight - rect.bottom) < 220;
                this.menuStyle = {
                    right: Math.max(12, window.innerWidth - rect.right) + 'px',
                    top: bukaAtas ? 'auto' : (rect.bottom + 6) + 'px',
                    bottom: bukaAtas ? (window.innerHeight - rect.top + 6) + 'px' : 'auto',
                };
            }
            this.menuTamu = tamu;
        },

        async setStatusKirim(tamu, terkirim) {
            if (!tamu || tamu.sedang_proses_kirim) return;
            const statusSebelumnya = tamu.sudah_dikirim;
            const labelSebelumnya = tamu.dikirim_pada_label;

            tamu.sedang_proses_kirim = true;
            tamu.sudah_dikirim = terkirim;
            if (!terkirim) {
                tamu.dikirim_pada_label = null;
            }

            try {
                const token = document.querySelector('meta[name=csrf-token]')?.content || this.csrfToken;
                const res = await fetch(tamu.url_status_kirim, {
                    method: 'PATCH',
                    keepalive: true,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify({ terkirim }),
                });

                if (!res.ok) {
                    throw new Error('Gagal memperbarui status');
                }

                const data = await res.json();
                tamu.sudah_dikirim = Boolean(data.sudah_dikirim);
                tamu.dikirim_pada_label = data.dikirim_pada_label || null;
            } catch {
                tamu.sudah_dikirim = statusSebelumnya;
                tamu.dikirim_pada_label = labelSebelumnya;
            } finally {
                tamu.sedang_proses_kirim = false;
            }
        },

        tandaiKirimSaatKlikWa(tamu) {
            if (!this.siapDisebarUndangan || tamu.sudah_dikirim) return;
            this.setStatusKirim(tamu, true);
        },

        salinPesan(tamu) {
            if (!this.siapDisebarUndangan || !tamu.pesan) return;
            navigator.clipboard?.writeText(tamu.pesan);
            tamu.tersalin = true;
            setTimeout(() => { tamu.tersalin = false; }, 1800);
            if (!tamu.sudah_dikirim) {
                this.setStatusKirim(tamu, true);
            }
        },

        salinLinkSaja(tamu) {
            this.menuTamu = null;
            if (!tamu?.urlTamu) return;
            navigator.clipboard?.writeText(tamu.urlTamu);
            window.Swal?.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Link personal disalin',
                showConfirmButton: false,
                timer: 1800,
            });
        },

        bukaModalEdit(tamu) {
            if (typeof window !== 'undefined') window.SesiTemuSelect2?.close?.();
            this.menuTamu = null;
            this.tamuDiedit = tamu;
            this.editNama = tamu.nama_tamu || '';
            this.editWa = tamu.nomor_wa || '';
            this.editKategoriId = tamu.kategori_tamu_id ? String(tamu.kategori_tamu_id) : '';
            this.modalEdit = true;
            this.$nextTick?.(() => this.sinkronSelect2Kategori());
        },

        tutupModalEdit() {
            if (typeof window !== 'undefined') window.SesiTemuSelect2?.close?.();
            this.modalEdit = false;
            this.tamuDiedit = null;
            this.editNama = '';
            this.editWa = '';
            this.editKategoriId = '';
        },

        async simpanEdit() {
            if (this.sedangSimpanEdit || !this.tamuDiedit) return;
            const namaBaru = (this.editNama || '').trim();
            if (!namaBaru) {
                window.Swal?.fire({
                    icon: 'warning',
                    title: 'Nama Tamu Kosong',
                    text: 'Nama tamu wajib diisi.',
                    confirmButtonText: 'Mengerti',
                    confirmButtonColor: '#4B6358',
                });
                return;
            }

            this.sedangSimpanEdit = true;
            try {
                const token = document.querySelector('meta[name=csrf-token]')?.content || this.csrfToken;
                const res = await fetch(this.tamuDiedit.url_perbarui, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify({
                        nama_tamu: namaBaru,
                        nomor_wa: (this.editWa || '').trim(),
                        kategori_tamu_id: this.editKategoriId ? Number(this.editKategoriId) : null,
                    }),
                });

                const data = await res.json().catch(() => ({}));
                if (!res.ok) {
                    window.Swal?.fire({
                        icon: 'error',
                        title: 'Periksa Data Tamu',
                        text: data?.pesan || data?.message || 'Gagal menyimpan perubahan data tamu.',
                        confirmButtonText: 'Mengerti',
                        confirmButtonColor: '#4B6358',
                    });
                    return;
                }

                this.tamuDiedit.nama_tamu = data.tamu?.nama_tamu || namaBaru;
                this.tamuDiedit.nomor_wa = data.tamu?.nomor_wa || null;
                this.tamuDiedit.kategori_tamu_id = data.tamu?.kategori_tamu_id ?? null;
                this.lengkapiDataTamu(this.tamuDiedit);
                this.tutupModalEdit();

                window.Swal?.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Data tamu diperbarui',
                    showConfirmButton: false,
                    timer: 1800,
                });
            } catch {
                window.Swal?.fire({
                    icon: 'error',
                    title: 'Gangguan Koneksi',
                    text: 'Gagal menghubungi server. Silakan coba lagi.',
                    confirmButtonText: 'Mengerti',
                    confirmButtonColor: '#4B6358',
                });
            } finally {
                this.sedangSimpanEdit = false;
            }
        },
    };
}
