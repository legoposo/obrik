import Chart from 'chart.js/auto';
import TomSelect from "tom-select";
import "tom-select/dist/css/tom-select.css";

window.Chart = Chart;

document.addEventListener("DOMContentLoaded", function () {
    const clientSelect = document.querySelector("#client_id");

    if (clientSelect) {
        new TomSelect(clientSelect, {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            },
            placeholder: "Digite para buscar um cliente",
        });
    }
});