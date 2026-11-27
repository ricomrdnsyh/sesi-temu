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
        const gayaParent = getComputedStyle(parentKhusus);
        const bisaScroll = ['auto', 'scroll'].includes(gayaParent.overflowY)
            || ['auto', 'scroll'].includes(gayaParent.overflow);

        // Jangan menempelkan dropdown ke kontainer yang bisa di-scroll: Select2 v4 tidak menjumlahkan scrollTop parent.
        if (!bisaScroll) {
            if (gayaParent.position === 'static') {
                parentKhusus.style.position = 'relative';
            }

            return $(parentKhusus);
        }
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

const sesuaikanPosisiDropdown = (selectEl, dropdownParent) => {
    const instance = $(selectEl).data('select2');
    const dropdown = instance?.dropdown;
    if (!dropdown || !dropdown.$dropdownContainer) {
        return;
    }

    dropdown._positionDropdown();
    dropdown._resizeDropdown();

    const parentEl = dropdownParent?.[0];
    if (parentEl && parentEl !== document.body && parentEl !== document.documentElement) {
        const scrollY = parentEl.scrollTop || 0;
        const scrollX = parentEl.scrollLeft || 0;
        if (scrollY !== 0 || scrollX !== 0) {
            const topSaatIni = Number.parseFloat(dropdown.$dropdownContainer.css('top')) || 0;
            const leftSaatIni = Number.parseFloat(dropdown.$dropdownContainer.css('left')) || 0;
            dropdown.$dropdownContainer.css({
                top: `${topSaatIni + scrollY}px`,
                left: `${leftSaatIni + scrollX}px`,
            });
        }
    }
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

const harusDilewatiSelect2 = (selectEl) => (
    selectEl.hasAttribute('data-no-select2')
    || selectEl.multiple
    || selectEl.hidden
    || selectEl.style.display === 'none'
    || selectEl.classList.contains('swal2-select')
    || Boolean(selectEl.closest('.swal2-container, [data-no-select2-container], template'))
);

const renderOpsiBankSelect2 = (data) => {
    if (!data?.id) {
        return data?.text || '';
    }

    const logoUrl = data.element?.dataset?.bankLogo || '';
    const baris = document.createElement('span');
    baris.className = 's2-bank-option';

    const wadahIkon = document.createElement('span');
    wadahIkon.className = 's2-bank-icon';
    if (logoUrl) {
        const img = document.createElement('img');
        img.src = logoUrl;
        img.alt = '';
        img.className = 's2-bank-img';
        wadahIkon.appendChild(img);
    } else {
        wadahIkon.innerHTML = '<svg viewBox="0 0 24 18" fill="none" aria-hidden="true"><rect x="1.5" y="2" width="21" height="14" rx="3" stroke="#4B6358" stroke-width="1.6"/><path d="M1.5 7h21" stroke="#BFA15F" stroke-width="1.8"/><rect x="4.5" y="10" width="5" height="2" rx="0.8" fill="#4B6358"/></svg>';
    }
    baris.appendChild(wadahIkon);

    const label = document.createElement('span');
    label.className = 's2-bank-label';
    label.textContent = data.text || '';
    baris.appendChild(label);

    return baris;
};

let pelindungLabelTerpasang = false;
let labelSelect2TerbukaSaatMousedown = null;

const pasangPelindungLabelSelect2 = () => {
    if (pelindungLabelTerpasang || typeof document === 'undefined') {
        return;
    }
    pelindungLabelTerpasang = true;

    const cariSelect2DariLabel = (target) => {
        if (!(target instanceof Element)) {
            return null;
        }
        const labelEl = target.closest('label');
        if (!labelEl) {
            return null;
        }
        const kontrol = labelEl.control;
        if (kontrol instanceof HTMLSelectElement && kontrol.classList.contains('select2-hidden-accessible') && $(kontrol).data('select2')) {
            return kontrol;
        }
        return null;
    };

    document.addEventListener('mousedown', (event) => {
        const selectEl = cariSelect2DariLabel(event.target);
        if (!selectEl) {
            labelSelect2TerbukaSaatMousedown = null;
            return;
        }
        const instance = $(selectEl).data('select2');
        labelSelect2TerbukaSaatMousedown = instance?.isOpen?.() ? selectEl : null;
    }, true);

    document.addEventListener('click', (event) => {
        const selectEl = cariSelect2DariLabel(event.target);
        if (!selectEl) {
            return;
        }

        // Cegah <label> mengaktifkan <select> asli tersembunyi (yang memunculkan dropdown native ganda).
        event.preventDefault();

        const klikDiDalamSelect2 = event.target instanceof Element && Boolean(event.target.closest('.select2-container'));
        const baruDitutup = labelSelect2TerbukaSaatMousedown === selectEl;
        labelSelect2TerbukaSaatMousedown = null;

        if (!klikDiDalamSelect2 && !baruDitutup && !selectEl.disabled) {
            $(selectEl).select2('open');
        }
    });
};

export const inisialisasiSelect2Element = (selectEl) => {
    pasangPelindungLabelSelect2();

    if (!(selectEl instanceof HTMLSelectElement)) {
        return;
    }

    if (harusDilewatiSelect2(selectEl)) {
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

    const opsiSelect2 = {
        theme: 'sesitemu',
        width: lebar,
        minimumResultsForSearch,
        dropdownParent,
        selectionCssClass: kelasVarianSelection,
        dropdownCssClass: kelasVarianDropdown,
        language: BAHASA_INDONESIA,
    };

    if (selectEl.dataset.select2Bank === 'true') {
        opsiSelect2.templateResult = renderOpsiBankSelect2;
        opsiSelect2.templateSelection = renderOpsiBankSelect2;
    }

    $(selectEl).select2(opsiSelect2);

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
            const kirimEventNative = () => {
                selectEl.dispatchEvent(new Event('input', { bubbles: true }));
                selectEl.dispatchEvent(new Event('change', { bubbles: true }));
            };

            if (typeof queueMicrotask === 'function') {
                queueMicrotask(kirimEventNative);
            } else {
                window.setTimeout(kirimEventNative, 0);
            }
        }
    });

    $(selectEl).on('select2:open.sesitemu', () => {
        const perbarui = () => {
            sesuaikanPosisiDropdown(selectEl, dropdownParent);
            const kotakCari = dropdownParent[0]?.querySelector('.select2-container--open .select2-search__field');
            if (kotakCari) {
                kotakCari.focus({ preventScroll: true });
            }
        };

        if (typeof window.requestAnimationFrame === 'function') {
            window.requestAnimationFrame(perbarui);
        } else {
            window.setTimeout(perbarui, 0);
        }
    });
};

export const tutupSemuaSelect2 = () => {
    document.querySelectorAll('select.select2-hidden-accessible').forEach((selectEl) => {
        if ($(selectEl).data('select2')) {
            $(selectEl).select2('close');
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

                if (node.matches('.swal2-container, [data-no-select2-container]') || node.closest('.swal2-container, [data-no-select2-container]')) {
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
