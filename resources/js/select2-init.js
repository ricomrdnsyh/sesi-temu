import $ from './jquery-setup';
import select2 from 'select2';

if (typeof $.fn?.select2 !== 'function' && typeof select2 === 'function') {
    select2(window, $);
}

const BAHASA_INDONESIA = {
    errorLoading: () => 'Gagal memuat daftar pilihan.',
    inputTooLong: (args) => `Hapus ${args.input.length - args.maximum} karakter.`,
    inputTooShort: (args) => `Ketik minimal ${args.minimum - args.input.length} karakter lagi.`,
    loadingMore: () => 'Memuat pilihan lainnya…',
    maximumSelected: (args) => `Maksimal memilih ${args.maximum} pilihan.`,
    noResults: () => 'Tidak ada pilihan yang cocok.',
    searching: () => 'Mencari…',
};

const tentukanVarian = (selectEl) => {
    const eksplisit = selectEl.dataset.select2Variant;
    if (eksplisit) {
        return eksplisit;
    }

    if (selectEl.closest('.dt-container .dt-length')) {
        return 'dt-length';
    }

    const filterToolbar = Boolean(selectEl.closest('form[method="GET"]'));
    const latarPutih = selectEl.classList.contains('bg-white');

    if (filterToolbar && latarPutih) {
        return 'white-compact';
    }

    if (latarPutih) {
        return 'white';
    }

    if (filterToolbar || selectEl.classList.contains('py-2')) {
        return 'compact';
    }

    return 'default';
};

const tentukanDropdownParent = (selectEl, varian) => {
    const parentKhusus = selectEl.closest('[data-select2-parent]');
    if (parentKhusus) {
        if (getComputedStyle(parentKhusus).position === 'static') {
            parentKhusus.style.position = 'relative';
        }

        return $(parentKhusus);
    }

    // Jika berada di dalam modal fixed inset-0, tempelkan ke panel modal agar klik opsi tidak memicu @click.away.
    const modalOverlay = selectEl.closest('.fixed.inset-0');
    const panelModal = modalOverlay?.firstElementChild;
    if (panelModal && panelModal.contains(selectEl) && varian !== 'dark-compact') {
        if (getComputedStyle(panelModal).position === 'static') {
            panelModal.style.position = 'relative';
        }

        return $(panelModal);
    }

    return $(document.body);
};

const sinkronNilaiProgramatik = (selectEl) => {
    const descriptor = Object.getOwnPropertyDescriptor(HTMLSelectElement.prototype, 'value');
    if (!descriptor?.get || !descriptor?.set || selectEl.dataset.s2Hooked === '1') {
        return;
    }

    selectEl.dataset.s2Hooked = '1';
    let sedangSinkron = false;

    Object.defineProperty(selectEl, 'value', {
        configurable: true,
        get() {
            return descriptor.get.call(this);
        },
        set(nilaiBaru) {
            const nilaiLama = descriptor.get.call(this);
            descriptor.set.call(this, nilaiBaru);
            const nilaiAkhir = descriptor.get.call(this);

            if (!sedangSinkron && nilaiLama !== nilaiAkhir && $(this).data('select2')) {
                sedangSinkron = true;
                $(this).trigger('change.select2');
                sedangSinkron = false;
            }
        },
    });
};

export const inisialisasiSelect2Element = (selectEl) => {
    if (!(selectEl instanceof HTMLSelectElement)) {
        return;
    }

    if (selectEl.hasAttribute('data-no-select2') || selectEl.multiple) {
        return;
    }

    if (selectEl.classList.contains('select2-hidden-accessible') || $(selectEl).data('select2')) {
        return;
    }

    const varian = tentukanVarian(selectEl);
    const batasCariAtribut = selectEl.dataset.select2Search;
    let minimumResultsForSearch = 6;
    if (batasCariAtribut === 'true') {
        minimumResultsForSearch = 0;
    } else if (batasCariAtribut === 'false' || varian === 'dt-length') {
        minimumResultsForSearch = Infinity;
    }

    const lebar = selectEl.dataset.select2Width || (varian === 'dt-length' ? '76px' : '100%');
    const kelasVarianSelection = `s2-variant-${varian}`;
    const kelasVarianDropdown = `s2-dropdown-${varian}`;
    const dropdownParent = tentukanDropdownParent(selectEl, varian);

    const gayaAsli = getComputedStyle(selectEl);
    const marginAtas = gayaAsli.marginTop;
    const marginBawah = gayaAsli.marginBottom;

    $(selectEl).select2({
        theme: 'sesitemu',
        width: lebar,
        minimumResultsForSearch,
        dropdownParent,
        selectionCssClass: kelasVarianSelection,
        dropdownCssClass: kelasVarianDropdown,
        language: BAHASA_INDONESIA,
    });

    const instanceS2 = $(selectEl).data('select2');
    const kontainerDom = instanceS2?.$container?.[0];
    if (kontainerDom) {
        if (marginAtas && marginAtas !== '0px') {
            kontainerDom.style.marginTop = marginAtas;
        }
        if (marginBawah && marginBawah !== '0px') {
            kontainerDom.style.marginBottom = marginBawah;
        }
    }

    sinkronNilaiProgramatik(selectEl);

    $(selectEl).on('select2:select.sesitemu select2:clear.sesitemu', () => {
        if (!selectEl.closest('.dt-container') && !selectEl.getAttribute('onchange')) {
            selectEl.dispatchEvent(new Event('change', { bubbles: true }));
        }
    });

    $(selectEl).on('select2:open.sesitemu', () => {
        const kotakCari = dropdownParent[0]?.querySelector('.select2-container--open .select2-search__field');
        if (kotakCari) {
            window.setTimeout(() => kotakCari.focus(), 0);
        }
    });
};

export const inisialisasiSemuaSelect2 = (akar = document) => {
    akar.querySelectorAll('select').forEach((selectEl) => {
        inisialisasiSelect2Element(selectEl);
    });
};

export const amatiSelect2Baru = () => {
    if (typeof MutationObserver === 'undefined' || !document.body) {
        return;
    }

    const observer = new MutationObserver((mutasiDaftar) => {
        mutasiDaftar.forEach((mutasi) => {
            mutasi.addedNodes.forEach((node) => {
                if (!(node instanceof Element)) {
                    return;
                }

                if (node.tagName === 'SELECT') {
                    inisialisasiSelect2Element(node);
                } else if (node.querySelector('select')) {
                    inisialisasiSemuaSelect2(node);
                }
            });
        });
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true,
    });
};
