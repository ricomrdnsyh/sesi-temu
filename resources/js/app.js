import Alpine from 'alpinejs';
import DataTable from 'datatables.net-dt';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
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
});
