export default function() {
    const $formulario_cobertura = document.getElementById("modal-cobertura-form");
    const provinceSelect = $formulario_cobertura.querySelector("#selectProvince");
    const citySelect = $formulario_cobertura.querySelector("#selectCity");
    const cellPhone = $formulario_cobertura.querySelector("#userCoberturaCellPhone");
    const checkboxNoFinded = document.getElementById("noFound");


    /**
     * General-purpose application to avoid repetition in the use of API parameters and add loading animation inside select.
     * @param {Object} query - Object with keys and "SQL" style queries to filter the data given by "datos.gov".
     * @param {ParentNode} nodeContainer - The parent selector containing the label to be found with the load animation.
     */
    function $geoApiGovernment(query, nodeContainer) {
        nodeContainer.querySelector("label.statusLoader").classList.remove("d-none");
        return fetch("https://www.datos.gov.co/resource/xdk5-pm3f.json?" + new URLSearchParams({
            "$$app_token" : "ZzKMj2amufo4vyzRDC9KIbp1s",
            ...query
        }))
            .then(res => res.json())
            .finally(() => nodeContainer.querySelector("label.statusLoader").classList.add("d-none"))
    }


    /**
     * General-purpose application to avoid repetition in the use of API parameters and add loading animation inside select.
     * @param {Object} query - Object with keys and "SQL" style queries to filter the on async $geoApiGovernment function service.
     * @param {HTMLSelectElement} selectNode - The parent selector containing the label to be found with the load animation.
     */
    async function getFormatedOptions(query, selectNode) {
        const response = await $geoApiGovernment(query, selectNode.parentNode);
        let options = "";

        for (let i = 0; i < response.length; i++) {
            let data = response[i];
            options += `<option value="${data.valor}" data-codigo="${data.codigo}">${data.valor}</option>`
        }

        selectNode.disabled = false;
        selectNode.insertAdjacentHTML("beforeend",options);
    }


    function init() {
        getFormatedOptions({
            "$select": "c_digo_dane_del_departamento as codigo, MAX(departamento) as valor",
            "$group":"c_digo_dane_del_departamento"
        }, provinceSelect);

        initEvents();
    }

    function initEvents() {
        provinceSelect.addEventListener('change', provinceSelectHandler);
        citySelect.addEventListener('change', citySelectHandler);
        checkboxNoFinded.addEventListener('change', checkboxNoFindedHandler);
    }

    /**
     * - Validates that the selected option contains the data-code attribute.
     * - Cleans the options to be selected and makes the call to fill them with valid options.
     * @param {InputEvent} ev.
     */
    async function provinceSelectHandler(ev) {
        const $target = ev.currentTarget;
        const optionSelected = $target.options[$target.selectedIndex];
        const optionDataset = optionSelected.dataset;

        if(optionDataset.hasOwnProperty('codigo')) {
            citySelect.innerHTML = "<option selected value='' hidden> Ciudad / Municipio </option>";
            getFormatedOptions({
                "$select": "c_digo_dane_del_municipio as codigo, municipio as valor",
                "$where":`c_digo_dane_del_departamento=${optionDataset.codigo}`,
            }, citySelect)
        }
    }

    /**
     * - Validates that the selected city is Bogotá D.C. and changes the success modal message.
     * - Change the town selector to visible if it is Bogotá D.C.
     * @param {InputEvent} ev.
     */
    function citySelectHandler(ev) {
        const c_municipio = ev.target.value;
        console.log(c_municipio);
    }

    /**
     * - If the user checks the box that does not find your city, disables all selectors and the neighborhood input.
     * - If the user unchecks the box, the first selector is re-enabled.
     * @param {InputEvent} ev.
     */
    function checkboxNoFindedHandler(ev){
        let isChecked = ev.target.checked;
        provinceSelect.disabled = isChecked;

        if(isChecked){
            citySelect.disabled = isChecked;
            townSelect.disabled = isChecked;
            suburbSelect.disabled = isChecked;
        }
    }

    init();
}