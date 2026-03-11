import Chart from 'chart.js/auto';
import TomSelect from "tom-select";
import "tom-select/dist/css/tom-select.css";

window.Chart = Chart;

const initClientSelect = () => {
    const clientSelect = document.querySelector('#client_id');

    if (!clientSelect || clientSelect.tomselect) {
        return;
    }

    new TomSelect(clientSelect, {
        create: false,
        sortField: {
            field: 'text',
            direction: 'asc',
        },
        placeholder: 'Digite para buscar um cliente',
    });
};

const initContractUnitSelect = () => {
    const payloadField = document.querySelector('#contract_units_payload');
    const developmentSelect = document.querySelector('#development_id');
    const unitSelect = document.querySelector('#unit_id');
    const unitHint = document.querySelector('#unit_id_hint');
    const unitPriceInput = document.querySelector('#unit_price');

    if (!payloadField || !developmentSelect || !unitSelect) {
        return;
    }

    let units = [];

    try {
        units = JSON.parse(payloadField.value || '[]');
    } catch (error) {
        units = [];
    }

    const fillUnitOptions = () => {
        const selectedDevelopmentId = developmentSelect.value;
        const currentUnitId = unitSelect.dataset.selectedUnit || unitSelect.value || '';
        const filteredUnits = units.filter((unit) => unit.development_id === selectedDevelopmentId);

        unitSelect.innerHTML = '';

        const placeholderOption = document.createElement('option');
        placeholderOption.value = '';
        placeholderOption.textContent = 'Selecione a unidade';
        unitSelect.appendChild(placeholderOption);

        filteredUnits.forEach((unit) => {
            const option = document.createElement('option');
            option.value = unit.id;
            option.textContent = unit.label;

            if (currentUnitId === unit.id) {
                option.selected = true;
            }

            unitSelect.appendChild(option);
        });

        unitSelect.dataset.selectedUnit = unitSelect.value;

        if (unitHint) {
            const shouldShowHint = selectedDevelopmentId !== '' && filteredUnits.length === 0;
            unitHint.classList.toggle('hidden', !shouldShowHint);
        }
    };

    const syncUnitPrice = () => {
        if (!unitPriceInput || unitPriceInput.value) {
            return;
        }

        const unit = units.find((item) => item.id === unitSelect.value);

        if (unit?.price) {
            unitPriceInput.value = unit.price;
        }
    };

    developmentSelect.addEventListener('change', () => {
        unitSelect.dataset.selectedUnit = '';
        fillUnitOptions();
        syncUnitPrice();
    });

    unitSelect.addEventListener('change', () => {
        unitSelect.dataset.selectedUnit = unitSelect.value;
        syncUnitPrice();
    });

    fillUnitOptions();
    syncUnitPrice();
};

const bootAppEnhancements = () => {
    initClientSelect();
    initContractUnitSelect();
};

document.addEventListener('DOMContentLoaded', bootAppEnhancements);
document.addEventListener('livewire:navigated', bootAppEnhancements);