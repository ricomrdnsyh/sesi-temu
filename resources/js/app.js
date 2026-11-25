import Alpine from 'alpinejs';
import DataTable from 'datatables.net-dt';
import Swal from 'sweetalert2';
import { amatiSelect2Baru, inisialisasiSemuaSelect2 } from './select2-init';
import { buatPengendaliSinemaScroll } from './sinema-scroll';
import { editorKelolaUndangan } from './editor-kelola';

window.Alpine = Alpine;
window.Swal = Swal;
window.SesiTemuSinema = buatPengendaliSinemaScroll();
window.editorKelolaUndangan = editorKelolaUndangan;

Alpine.data('editorKelolaUndangan', editorKelolaUndangan);
Alpine.start();

const escapeHtml = (teks) => String(teks)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');

document.addEventListener('DOMContentLoaded', () => {
    const flashErrors = document.querySelector('[data-swal-errors]');
    let daftarGalat = [];
    if (flashErrors?.dataset.swalErrors) {
        try {
            const hasil = JSON.parse(flashErrors.dataset.swalErrors);
            if (Array.isArray(hasil)) {
                daftarGalat = hasil
                    .map((item) => String(item ?? '').trim())
                    .filter((item) => item.length > 0);
            }
        } catch {
            const mentah = flashErrors.dataset.swalErrors.trim();
            if (mentah) {
                daftarGalat = [mentah];
            }
        }
    }

    const flashWarning = document.querySelector('[data-swal-warning]');
    const pesanPeringatan = flashWarning?.dataset.swalWarning?.trim();

    const flashSuccess = document.querySelector('[data-swal-success]');
    const pesanSukses = flashSuccess?.dataset.swalSuccess?.trim();

    if (daftarGalat.length === 1) {
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            text: daftarGalat[0],
            confirmButtonText: 'Mengerti',
            confirmButtonColor: '#4B6358',
        });
    } else if (daftarGalat.length > 1) {
        const daftarHtml = `<ul class="text-left list-disc list-inside space-y-1">${daftarGalat.map((pesan) => `<li>${escapeHtml(pesan)}</li>`).join('')}</ul>`;

        Swal.fire({
            icon: 'error',
            title: 'Periksa Kembali Data Anda',
            html: daftarHtml,
            confirmButtonText: 'Mengerti',
            confirmButtonColor: '#4B6358',
        });
    } else if (pesanPeringatan) {
        Swal.fire({
            icon: 'warning',
            title: flashWarning?.dataset.swalWarningTitle?.trim() || 'Perhatian',
            text: pesanPeringatan,
            confirmButtonText: 'Mengerti',
            confirmButtonColor: '#4B6358',
        });
    } else if (pesanSukses) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: pesanSukses,
            confirmButtonText: 'OK',
            confirmButtonColor: '#4B6358',
            timer: 3500,
            timerProgressBar: true,
        });
    }

    const tables = document.querySelectorAll('table[data-datatable]');

    tables.forEach((table) => {
        const parsedLength = Number.parseInt(table.dataset.pageLength ?? '10', 10);
        const pageLength = Number.isFinite(parsedLength) && parsedLength > 0 ? parsedLength : 10;
        const emptyMessage = table.dataset.emptyMessage ?? 'Belum ada data tersedia.';
        const headerCells = Array.from(table.querySelectorAll('thead tr:first-child th'));
        const noSortTargets = headerCells.reduce((acc, th, index) => {
            if (th.hasAttribute('data-no-sort')) {
                acc.push(index);
            }

            return acc;
        }, []);

        const columnDefs = [];
        if (noSortTargets.length > 0) {
            columnDefs.push({
                targets: noSortTargets,
                orderable: false,
                searchable: false,
            });
        } else if (table.dataset.disableLastSort !== 'false') {
            columnDefs.push({
                targets: -1,
                orderable: false,
                searchable: false,
            });
        }

        new DataTable(table, {
            pageLength,
            lengthMenu: [5, 10, 25, 50],
            order: [],
            autoWidth: false,
            columnDefs,
            language: {
                search: 'Cari:',
                searchPlaceholder: 'Ketik kata kunci...',
                lengthMenu: 'Tampilkan _MENU_ data',
                info: 'Menampilkan _START_–_END_ dari _TOTAL_ data',
                infoEmpty: 'Tidak ada data untuk ditampilkan',
                infoFiltered: '(disaring dari _MAX_ total data)',
                zeroRecords: 'Tidak ada data yang cocok dengan pencarian.',
                emptyTable: emptyMessage,
                paginate: {
                    first: 'Awal',
                    previous: 'Sebelumnya',
                    next: 'Berikutnya',
                    last: 'Akhir',
                },
            },
        });
    });

    inisialisasiSemuaSelect2();
    amatiSelect2Baru();
});

const tampilkanSwalProses = (form) => {
    Swal.fire({
        title: form.dataset.swalLoadingTitle ?? 'Sedang Memproses...',
        text: form.dataset.swalLoadingText ?? 'Mohon tunggu sebentar, permintaan Anda sedang diproses.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });
};

window.addEventListener('pageshow', (event) => {
    if (event.persisted && Swal.isVisible() && Swal.isLoading()) {
        Swal.close();
    }
});

document.addEventListener('submit', (event) => {
    if (event.defaultPrevented) {
        return;
    }

    const form = event.target.closest('form[data-swal-confirm], form[data-swal-loading]');
    if (!form || form.dataset.swalConfirmed === 'true') {
        return;
    }

    if (form.hasAttribute('data-swal-confirm')) {
        event.preventDefault();

        Swal.fire({
            title: form.dataset.swalTitle ?? 'Konfirmasi Tindakan',
            text: form.dataset.swalConfirm ?? 'Apakah Anda yakin ingin melanjutkan?',
            icon: form.dataset.swalIcon ?? 'question',
            showCancelButton: true,
            confirmButtonText: form.dataset.swalConfirmButton ?? 'Ya, Lanjutkan',
            cancelButtonText: form.dataset.swalCancelButton ?? 'Batal',
            confirmButtonColor: form.dataset.swalConfirmColor ?? '#4B6358',
            cancelButtonColor: '#6B7280',
            reverseButtons: true,
            focusCancel: true,
        }).then((result) => {
            if (result.isConfirmed) {
                form.dataset.swalConfirmed = 'true';
                tampilkanSwalProses(form);
                HTMLFormElement.prototype.submit.call(form);
            }
        });

        return;
    }

    if (form.hasAttribute('data-swal-loading')) {
        form.dataset.swalConfirmed = 'true';
        tampilkanSwalProses(form);
    }
});
