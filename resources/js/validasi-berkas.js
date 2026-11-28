const EKSTENSI_TERLARANG_GANDA = new Set([
    'php', 'phtml', 'pht', 'phps', 'phar', 'inc',
    'asp', 'aspx', 'asa', 'cer', 'jsp', 'jspx', 'cfm', 'cgi', 'pl', 'py', 'rb',
    'sh', 'bash', 'zsh', 'bat', 'cmd', 'ps1', 'psm1', 'vbs', 'vbe', 'wsf', 'wsh',
    'exe', 'dll', 'msi', 'com', 'scr', 'pif', 'jar', 'war', 'class', 'elf', 'bin',
    'js', 'mjs', 'cjs', 'ts', 'jsx', 'tsx',
    'html', 'htm', 'xhtml', 'shtml', 'mhtml', 'svg', 'svgz', 'xml', 'xsl', 'xslt',
    'htaccess', 'htpasswd', 'ini', 'env', 'conf', 'config', 'sql', 'sqlite', 'db',
    'zip', 'rar', '7z', 'tar', 'gz', 'bz2', 'xz', 'iso',
    'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'rtf',
    'jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp', 'ico', 'tif', 'tiff', 'heic', 'avif',
    'mp3', 'wav', 'ogg', 'm4a', 'aac', 'flac', 'mp4', 'webm', 'mov', 'avi', 'mkv',
    'csv', 'txt', 'tsv', 'json', 'yaml', 'yml', 'css',
]);

const KONFIG_JENIS = {
    gambar: {
        ekstensi: ['jpg', 'jpeg', 'png', 'webp'],
        mime: ['image/jpeg', 'image/png', 'image/webp'],
        maksMbBawaan: 5,
        label: 'gambar (JPG, PNG, atau WebP)',
    },
    musik: {
        ekstensi: ['mp3', 'wav', 'ogg', 'm4a'],
        mime: [
            'audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/x-wav', 'audio/wave',
            'audio/vnd.wave', 'audio/ogg', 'application/ogg', 'audio/mp4',
            'audio/x-m4a', 'audio/aac', 'video/mp4',
        ],
        maksMbBawaan: 15,
        label: 'audio (MP3, WAV, OGG, atau M4A)',
    },
    csv: {
        ekstensi: ['csv'],
        mime: [
            'text/csv', 'text/plain', 'application/csv',
            'application/vnd.ms-excel', 'text/x-csv', 'text/comma-separated-values',
        ],
        maksMbBawaan: 2,
        label: 'file CSV (.csv)',
    },
};

export function validasiNamaEkstensi(namaAsli, jenis) {
    const cfg = KONFIG_JENIS[jenis];
    if (!cfg) {
        return { valid: false, pesan: 'Jenis berkas tidak dikenali.' };
    }

    const nama = String(namaAsli || '').trim();
    if (
        !nama
        || nama.length > 255
        || /[\x00-\x1F\x7F\\/]/.test(nama)
        || nama.includes('..')
        || nama.toLowerCase().includes('%00')
    ) {
        return { valid: false, pesan: 'Nama berkas mengandung karakter tidak aman dan ditolak.' };
    }

    const bagian = nama.split('.');
    if (bagian.length < 2) {
        return { valid: false, pesan: `Berkas wajib memiliki ekstensi ${cfg.label}.` };
    }

    const ekstensiAkhir = bagian.pop().trim().toLowerCase();
    if (!cfg.ekstensi.includes(ekstensiAkhir)) {
        return {
            valid: false,
            pesan: `Format berkas .${ekstensiAkhir} tidak diizinkan. Gunakan ${cfg.label}.`,
        };
    }

    for (let i = 1; i < bagian.length; i++) {
        const segmen = bagian[i].trim().toLowerCase();
        if (!segmen || EKSTENSI_TERLARANG_GANDA.has(segmen) || /^php[0-9a-z]*$/.test(segmen)) {
            return {
                valid: false,
                pesan: 'Berkas dengan ekstensi ganda atau mencurigakan ditolak demi keamanan.',
            };
        }
    }

    return { valid: true, ekstensi: ekstensiAkhir, pesan: '' };
}

function deteksiSignatureGambar(bytes) {
    if (bytes.length >= 3 && bytes[0] === 0xFF && bytes[1] === 0xD8 && bytes[2] === 0xFF) {
        return 'jpg';
    }
    if (
        bytes.length >= 8
        && bytes[0] === 0x89 && bytes[1] === 0x50 && bytes[2] === 0x4E && bytes[3] === 0x47
        && bytes[4] === 0x0D && bytes[5] === 0x0A && bytes[6] === 0x1A && bytes[7] === 0x0A
    ) {
        return 'png';
    }
    if (
        bytes.length >= 12
        && bytes[0] === 0x52 && bytes[1] === 0x49 && bytes[2] === 0x46 && bytes[3] === 0x46
        && bytes[8] === 0x57 && bytes[9] === 0x45 && bytes[10] === 0x42 && bytes[11] === 0x50
    ) {
        return 'webp';
    }
    return null;
}

function cocokSignatureMusik(bytes, ext) {
    if (ext === 'mp3') {
        const id3 = bytes.length >= 3 && bytes[0] === 0x49 && bytes[1] === 0x44 && bytes[2] === 0x33;
        const sync = bytes.length >= 2 && bytes[0] === 0xFF && (bytes[1] & 0xE0) === 0xE0;
        return id3 || sync;
    }
    if (ext === 'wav') {
        return bytes.length >= 12
            && bytes[0] === 0x52 && bytes[1] === 0x49 && bytes[2] === 0x46 && bytes[3] === 0x46
            && bytes[8] === 0x57 && bytes[9] === 0x41 && bytes[10] === 0x56 && bytes[11] === 0x45;
    }
    if (ext === 'ogg') {
        return bytes.length >= 4
            && bytes[0] === 0x4F && bytes[1] === 0x67 && bytes[2] === 0x67 && bytes[3] === 0x53;
    }
    if (ext === 'm4a') {
        return bytes.length >= 8
            && bytes[4] === 0x66 && bytes[5] === 0x74 && bytes[6] === 0x79 && bytes[7] === 0x70;
    }
    return false;
}

function mengandungSkripBerbahaya(teks) {
    return /<\?(?:php|=)|<\s*(?:script|iframe|svg|html)\b|<!doctype\s+html/i.test(teks);
}

function bytesKeAscii(bytes) {
    let hasil = '';
    for (let i = 0; i < bytes.length; i++) {
        hasil += String.fromCharCode(bytes[i]);
    }
    return hasil;
}

async function bacaHeaderBytes(file, batas = 4096) {
    if (!file || typeof file.slice !== 'function') {
        return null;
    }
    try {
        const potongan = file.slice(0, batas);
        if (typeof potongan.arrayBuffer === 'function') {
            return new Uint8Array(await potongan.arrayBuffer());
        }
    } catch {
        return null;
    }
    return null;
}

export async function validasiBerkasKetat(file, jenis, opsi = {}) {
    const cfg = KONFIG_JENIS[jenis];
    if (!cfg || !file) {
        return { valid: false, pesan: 'Berkas tidak ditemukan.' };
    }

    const hasilNama = validasiNamaEkstensi(file.name, jenis);
    if (!hasilNama.valid) {
        return hasilNama;
    }

    if (!file.size || file.size <= 0) {
        return { valid: false, pesan: 'Berkas kosong dan tidak dapat diunggah.' };
    }

    const maksMb = Number(opsi.maksMb || cfg.maksMbBawaan);
    if (file.size > maksMb * 1024 * 1024) {
        return {
            valid: false,
            pesan: opsi.pesanUkuran || `Ukuran berkas melebihi batas maksimal ${maksMb} MB.`,
        };
    }

    const mime = String(file.type || '').trim().toLowerCase();
    if (jenis === 'gambar') {
        if (!mime || !cfg.mime.includes(mime)) {
            return { valid: false, pesan: 'Format berkas harus berupa gambar JPG, PNG, atau WebP.' };
        }
    } else if (mime && !cfg.mime.includes(mime)) {
        return { valid: false, pesan: `Tipe berkas tidak sesuai. Gunakan ${cfg.label}.` };
    }

    const bytes = await bacaHeaderBytes(file, jenis === 'gambar' ? 32 : 8192);
    if (!bytes || bytes.length === 0) {
        return { valid: true, pesan: '' };
    }

    if (jenis === 'gambar') {
        const sig = deteksiSignatureGambar(bytes);
        const extNormal = hasilNama.ekstensi === 'jpeg' ? 'jpg' : hasilNama.ekstensi;
        if (!sig || sig !== extNormal) {
            return {
                valid: false,
                pesan: 'Isi berkas gambar tidak cocok dengan ekstensinya dan ditolak.',
            };
        }
        return { valid: true, pesan: '' };
    }

    if (jenis === 'musik') {
        if (!cocokSignatureMusik(bytes, hasilNama.ekstensi)) {
            return {
                valid: false,
                pesan: 'Isi berkas musik tidak sesuai dengan format ekstensinya dan ditolak.',
            };
        }
        if (mengandungSkripBerbahaya(bytesKeAscii(bytes))) {
            return {
                valid: false,
                pesan: 'Berkas musik mengandung pola skrip berbahaya dan ditolak.',
            };
        }
        return { valid: true, pesan: '' };
    }

    if (jenis === 'csv') {
        for (let i = 0; i < bytes.length; i++) {
            if (bytes[i] === 0x00) {
                return { valid: false, pesan: 'Berkas CSV mengandung data biner tidak valid dan ditolak.' };
            }
        }
        const teksAwal = bytesKeAscii(bytes);
        const sigBiner = ['MZ', '\x7FELF', '%PDF-', 'PK\x03\x04', '\x89PNG', '\xFF\xD8\xFF', 'GIF8', 'Rar!', '\x1F\x8B'];
        if (sigBiner.some((s) => teksAwal.startsWith(s))) {
            return { valid: false, pesan: 'Berkas bukan file CSV murni dan ditolak.' };
        }
        if (mengandungSkripBerbahaya(teksAwal)) {
            return { valid: false, pesan: 'Berkas CSV mengandung kode skrip tidak diizinkan dan ditolak.' };
        }
        return { valid: true, pesan: '' };
    }

    return { valid: true, pesan: '' };
}
